<?php
/** XN_REST manages HTTP connections for API calls
 * @file
 * @ingroup XN
 */

/* $Revision$ */

/** XN_REST manages HTTP connections for API calls
 *
 * Making API requests through the XN_REST class ensures correct and
 * efficient hostname lookup, header preparation and parsing, and
 * easy debugging.
 * 
 * @ingroup XN
 */
header("Content-type:text/html;charset=utf-8");
class XN_REST {
    /** @unsupported @internal
     * Singleton instance used internally
     */
    protected static $instance;

    /** @unsupported @internal
     * Multipliers for calculating memory limit values from ini setting
     */
    protected static $memMultipliers = array('k' => 1024, 'm' => 1048576, 'g' => 1073741824);

    /** @unsupported @internal
     * What fraction of the memory limit a response is limited to
     */
    protected static $responseSizeMemoryRatio = 0.9;

    /** @unsupported @internal
     * This is calculated in the constructor.
     */
    protected $maxResponseSize = null;

    /** Used for including HTTP status code in error arrays */
    const STATUS = 'xn:status';

    /** A pseudo-header that can be passed into one of the request methods
     * to tell XN_REST what service location to prefer (if specified) */
    const USE_SERVICE_LOCATION = 'X-XN-Use-Service-Location';

    /** A pseudo-header that can be passed into one of the request methods
     * to tell XN_REST what request timeout to use for the request */
    const USE_REQUEST_TIMEOUT = 'X-XN-Use-Request-Timeout';

    protected $body;
    protected $headers;
    protected $responseCode;
    protected $url;
    protected $bodyTooBig = false;

    const DEBUG = false;

    // Set based on response headers
    protected static $RESPONSE_FROM_HEADER = '';

    // Set in _xn_prepend.php
    public static $SECURITY_TOKEN = null;
    public static $LOCAL_API_HOST_PORT = null;
    public static $APPCORE_IP = null;
    public static $TRACE = null;

    // Set on first use
    protected static $GLOBAL_API_HOST_PORT = null;

    // Initialized by _xn_prepend.php call to setServiceLocations
    protected static $SERVICE_LOCATIONS = array();

    /** Maximum time allowed for a request/response (NING-5427)
     */
    protected static $requestTimeout = 90;

    /** Set maximum request/response time */
    public static function setRequestTimeout($t) {
        self::$requestTimeout = $t;
        // If curl resources have already been created, reset
        // their timeouts
        $instance = self::getInstance();
        foreach ($instance->curl as $k => $curl) {
            if (! is_null($curl)) {
                curl_setopt($instance->curl[$k], CURLOPT_TIMEOUT, $t);
            }
        }
    }
    /** Get maximum request/response time */
    public static function getRequestTimeout() { return self::$requestTimeout; }

    /** Curl resources in use for the current request. There are resources for
     * - each unique host:port in the service map
     * - the $LOCAL_API_HOST PORT for the local appcore
     * - the $GLOBAL_API_HOST_PORT for cross-app queries
     * - __other__ for any other outbound HTTP requests
     * For all but the __other__ resource, keeping them around for the duration
     * of the request enables a persistent connection to the service
     *
     * Each resource is created on demand the first time there is a request for
     * it
     */
    protected $curl = array();

    protected static function getInstance() {
        if (is_null(self::$instance)) { self::$instance = new XN_REST; }
        return self::$instance;
    }

    /**
     * Sets the singleton instance. Called by the unit tests.
     *
     * @param $instance mixed  an object implementing XN_REST's interface
     */
    protected static function setInstance($instance) {
        self::$instance = $instance;
    }

    public static function urlsprintf() {
          $args = func_get_args();
          return self::mapsprintf('urlsprintf','rawurlencode',$args);
    }
    public static function xmlsprintf() {
          $args = func_get_args();
          return self::mapsprintf('xmlsprintf',array('XN_REST','utf8specialchars'),$args);
    }

    protected static function mapsprintf($caller, $callback, $args) {
        if (count($args) >= 2) {
            $format = array_shift($args);
            return vsprintf($format, array_map($callback,$args));
        } else if (count($args) == 1) {
            return $args[0];
        } else {
            throw new XN_Exception("$caller expects at least 1 argument");
        }
    }

    public static function utf8specialchars($s) { return htmlspecialchars($s, ENT_COMPAT, 'UTF-8'); }
    public static function singleQuote($s) {
        $s = str_replace('\\','\\\\',$s);
        $s = str_replace("'","\\'",$s);
        return $s;
    }

    protected function __construct() {
        if (strlen($t = trim(ini_get('memory_limit')))) {
            if (isset(self::$memMultipliers[$c=strtolower(substr($t,-1))])) { $t *= self::$memMultipliers[$c]; }
            $this->maxResponseSize = $t * self::$responseSizeMemoryRatio;
        }
    }

    protected function _initializeCurl($slot) {
        /* Has this slot already been initialized for this request? */
        /*  curl 每次都需要初始化了。
	        if (array_key_exists($slot, $this->curl)) {
            return;
        }*/

        $this->curl[$slot] = curl_init();
        curl_setopt($this->curl[$slot], CURLOPT_HEADERFUNCTION, array($this,'parseHeader'));
        curl_setopt($this->curl[$slot], CURLOPT_WRITEFUNCTION, array($this, 'parseBody'));
        curl_setopt($this->curl[$slot], CURLOPT_USERAGENT, 'XN-REST 0.2');
        curl_setopt($this->curl[$slot], CURLOPT_VERBOSE, self::DEBUG);
        curl_setopt($this->curl[$slot], CURLOPT_TIMEOUT, self::getRequestTimeout());
    }

    /**
     * Set the locations (host:port combinations) to use for various
     * services. This is customarily called from _xn_prepend.php with
     * a $locationsHeader that is passed in to the request
     *
     * @param $locationsHeader string a comma-separated list of services
     * and their locations; Each service is of the form service=location
     * where service is a service name and location is a host or host:port
     */
    public static function setServiceLocations($locationsHeader) {
        foreach (explode(',', $locationsHeader) as $service) {
            list($name, $host) = explode('=', $service, 2);
            self::$SERVICE_LOCATIONS[trim($name)] = trim($host);
        }
    }

    /** @unsupported @internal
     * Figure out which curl slot to use, given the provided path. The path
     * should begin with:
     *
     *  /xn/format/entity/version
     *  or
     *  /xn/format/version/entity
     *
     * Where "format" is generally "rest" or "atom"; version begins with
     * a digit and then is all digits or "." chars; and entity (in the second case)
     * terminates with a "/", ":", or "(".
     *
     * @param $path string path to examine
     * @param $serviceLocation string optional explicit service location to use if available
     * @return string slot to use.
     */
    protected static function determineSlot($path, $serviceLocation = null) {

        // If a specific service location has been requested and is available, use that
        if (isset($serviceLocation) && isset(self::$SERVICE_LOCATIONS[$serviceLocation])) {
            return self::$SERVICE_LOCATIONS[$serviceLocation];
        }

        // Otherwise, examine the path to figure out which one to use
        $parts = explode('/', $path);
        $format = $parts[2]; // generally "rest" or "atom", for PRET-245
        
        // PRET-255: next part could be version or entity
        if (preg_match('@^\d[\d\.]+$@', $parts[3])) {
            $version = $parts[3];
            $entity = preg_replace('@[:\(].*$@', '', urldecode($parts[4]));
        }
        else {
            $version = $parts[4];
            $entity = preg_replace('@[:\(].*$@', '', urldecode($parts[3]));
        }

        /* First check "$format/$entity", e.g. "rest/application" */
        if (isset(self::$SERVICE_LOCATIONS["$format/$entity"])) {
            $slot = self::$SERVICE_LOCATIONS["$format/$entity"];
        }
        /* Then check "$entity", e.g. "application" */
        else if (isset(self::$SERVICE_LOCATIONS[$entity])) {
            $slot = self::$SERVICE_LOCATIONS[$entity];
        }
        /* And fallback to the default slot if nothing's found */
        else {
            $slot = self::$LOCAL_API_HOST_PORT;
        }
        return $slot;
    }

    public static function get($url, $headers = null) {
        $ref = null;
        return self::getInstance()->doRequest('GET', $url, $ref, null, $headers);
    }

    public static function post($url, $postData = null, $contentType = 'text/xml', $headers = null) {
        if (is_array($postData)) {
            $tmp = array();
            foreach ($postData as $k => $v) {
                $tmp[] = urlencode($k).'='.urlencode($v);
            }
            $postBody = implode('&',$tmp);
            $contentType = 'application/x-www-form-urlencoded';
        } else {
            $postBody = $postData;
        }

        return self::getInstance()->doRequest('POST', $url, $postBody, $contentType, $headers);
    }

    public static function put($url, $body, $contentType = 'text/xml', $headers = null) {
        return self::getInstance()->doRequest('PUT',$url,$body,$contentType,$headers);
    }

    public static function delete($url, $headers = null) {
        $ref = null;
        return self::getInstance()->doRequest('DELETE',$url, $ref, null, $headers);
    }

    public static function head($url, $headers = null) {
        try {
            $ref = null;
            $instance = self::getInstance();
            $instance->doRequest('HEAD', $url, $ref, null, $headers);
            return $instance->responseCode;
        } catch (XN_Exception $e) {
            return $instance->responseCode;
        }
    }

    protected function parseHeader($curl, $data) {
        if (self::DEBUG) { print self::mem_info(); print "<code>[h] ".xnhtmlentities($data)."</code><br/>\n"; }
        if (is_null($this->responseCode) && preg_match('@^HTTP/1\.\d (\d\d\d)@',$data, $matches)) {
            if ($matches[1] != '100') { // Skip over '100 Continue' header lines
                $this->responseCode = $matches[1];
            }
        }
        list($header, $value) = explode(': ', $data, 2);
        if (strlen($header = trim($header))) {
            if (($header == 'Content-Length') && (! is_null($this->maxResponseSize)) &&
            ($value > $this->maxResponseSize)) {
                $this->bodyTooBig = true;
            }
            if (is_array($this->headers[$header])) {
                $this->headers[$header][] = trim($value);
            } else if (isset($this->headers[$header])) {
                $this->headers[$header] =array($this->headers[$header], trim($value));
            } else {
                $this->headers[$header] = trim($value);
            }
        }
        return strlen($data);
    }

    protected function parseBody($curl, $data) {
        if (self::DEBUG) { print self::mem_info(); print "<code>[b] (".strlen($data).') '.xnhtmlentities($data)."</code><br/>\n"; }
        if ($this->bodyTooBig) { return -1; }
        $this->body .= $data;
        return strlen($data);
    }

    protected static function mem_info() {
        if (is_callable('memory_get_usage')) {
            return '<code>[m] '.memory_get_usage()."</code><br/>\n";
        }
    }

    /** @unsupported @internal
     * Replace the host in a URL with one of the provided IP address/port combinations
     * if applicable, and calculate the correct Host header and curl slot to use
     *
     * @param $url string The URL to process
     * @param $serviceLocation string optional service location to use (from the service
     *        locations array) if available. Only active for requests that would not
     *        otherwise use the __global__ or __other__ slot
     * @return array The returned array has these elements: 'url', which contains the
     *               modified URL, 'slot', which contains the curl slot to use, and,
     *               optionally, 'host', containing the Host header to set if necessary.
     */
    protected static function prepareUrl($url, $serviceLocation = null) {
        $host = null;
        $slot = null;
        
        /* Is $url a relative URL (in which case it goes against the current app) */
        if (($isRelative = ($url[0] == '/')) ||
            /* Or is it a full URL against the current app? */
            (strncasecmp($thisAppBaseUrl = 'http://'.XN_AtomHelper::HOST_APP(XN_Application::$CURRENT_URL), $url, $thisAppBaseUrlLen = strlen($thisAppBaseUrl)) == 0)) {
            /* In either case, the URL is changed to hit the IP/port provided by
             * the core for the local app endpoint or the appropriate service in
             * in the service map
             */
            
            if ($isRelative) {
                /* Some URLs should have an /xn/rest or /xn/atom prefix prepended to
                 * them, so let's do that before figuring out which host:port to
                 * use
                 */
                
                /* If it's against /profile, use the PHP API v3 /xn/rest/2.0/profile
                 * endpoint (NING-6233) -- except for XN_Role queries (NING-6330) */
                if (strpos($url,'/profile') === 0 &&
                    !preg_match("@^/profile[^/]*/role@",$url)) {
                    $url = XN_AtomHelper::APP_REST_PREFIX() . $url;
                }
                /* Otherwise, if it doesn't begin with '/xn/', prepend the
                 * atom prefix */
                else if (substr($url,0,4) !== '/xn/') {
                    $url = XN_AtomHelper::APP_ATOM_PREFIX . $url.'?xn_out=xml';
                }
                
                /* Now that any prefixification is out of the way, time to figure
                 * out what host/port to use based on the service map.
                 * Assume paths look like /xn/(atom|rest)/(version)/entity
                 */
                $slot = self::determineSlot($url, $serviceLocation);
                $url = 'http://' . $slot . $url;
            }
            /* If it's not a relative URL, but a full URL against the
             * current app
             */
            else {
                $slot = self::determineSlot(parse_url($url, PHP_URL_PATH), $serviceLocation);
                $url = 'http://'. $slot . substr($url, $thisAppBaseUrlLen);
            }
            
            /* The real host goes in the Host header */
            $host = preg_replace('@:\d+$@','',XN_AtomHelper::HOST_APP(XN_Application::$CURRENT_URL));
        }
        /* Is $url a full URL for the api.* endpoint? */
        else if (strncasecmp(XN_AtomHelper::ENDPOINT_XN(), $url, $xnEndpointLen = strlen(XN_AtomHelper::ENDPOINT_XN())) == 0) {
            if (is_null(self::$GLOBAL_API_HOST_PORT)) {
                self::$GLOBAL_API_HOST_PORT = gethostbyname('api' .XN_AtomHelper::$DOMAIN_SUFFIX);;
            }
            $url = str_replace('http://api'.XN_AtomHelper::$DOMAIN_SUFFIX,'http://'.self::$GLOBAL_API_HOST_PORT, $url);
             $host = 'api'.XN_AtomHelper::$DOMAIN_SUFFIX;
             $slot = '__global__';
        }
        /* Is $url a cross-app request for another app? */
        else if (preg_match('@^http://([A-Z0-9]+'.preg_quote(XN_AtomHelper::HOST_APP(''),'@').')/@i', $url, $match)) {
            if (is_null(self::$GLOBAL_API_HOST_PORT)) {
                self::$GLOBAL_API_HOST_PORT = gethostbyname('api' .XN_AtomHelper::$DOMAIN_SUFFIX);
            }
            $url = str_replace($match[0], 'http://'.self::$GLOBAL_API_HOST_PORT.':'.XN_AtomHelper::$EXTERNAL_PORT.'/', $url);
             $host = preg_replace('@:\d+$@','',$match[1]);
             $slot = '__global__';
        }
        /* Is $url some other totally random full URL */
        else {
            $slot = '__other__';
        }
        
        $info = array('url' => $url, 'slot' => $slot);
        if (! is_null($host)) {
            $info['host'] = $host;
        }
        
        return $info;
    }

   protected function doRequest($method, $url, &$body = null,$contentType=null, $additionalHeaders = null) {
       $requestHeaders = array();        

       // PRET-279: If a service location is asked for in the headers, try to use it
       if (is_array($additionalHeaders) && isset($additionalHeaders[self::USE_SERVICE_LOCATION])) {
           $serviceLocation = $additionalHeaders[self::USE_SERVICE_LOCATION];
       } else {
           $serviceLocation = null;
       } 
        $urlInfo = self::prepareUrl($url, $serviceLocation);
         
        $slot = $urlInfo['slot'];
        $url  = $urlInfo['url'];
        
        if (isset($urlInfo['host'])) {
            $requestHeaders['Host'] = $urlInfo['host'];
        } 
		
	  
        // Based on the prepared URL and slot, make sure the slot is initialized
        $this->_initializeCurl($slot);

        
        $this->headers = array();
        $this->body = '';
        $this->responseCode = null;
        $this->bodyTooBig = false;

        // Clean out the headers and set the URL
        curl_setopt($this->curl[$slot], CURLOPT_HTTPHEADER, array());
        curl_setopt($this->curl[$slot], CURLOPT_URL, $url);

        if ($method == 'POST') {
            curl_setopt($this->curl[$slot], CURLOPT_CUSTOMREQUEST, 'POST');
        } elseif ($method == 'GET') {
            curl_setopt($this->curl[$slot], CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($this->curl[$slot], CURLOPT_HTTPGET, true);
        } else {
            // Setting the method to GET and then to the custom method
            // Ensures that any Content-Length and Content-Type headers from
            // a previous POST or PUT are removed.
            curl_setopt($this->curl[$slot], CURLOPT_HTTPGET, true);
            curl_setopt($this->curl[$slot], CURLOPT_CUSTOMREQUEST, $method);
            // Without a "Connection: close" on a HEAD request, curl_exec()
            // waits (after receiving the response) instead of returning
            // [ David Sklar 2006-10-10 ]
            if ($method == 'HEAD') {
                $requestHeaders['Connection'] = 'close';
            }
        }

        // Allow for multipart content
        if (is_array($body) || strlen($body)) {
	  /* CURLOPT_POST is set only when there's a body to handle
	   * responses with no body (NING-7074) */
            curl_setopt($this->curl[$slot], CURLOPT_POST, true);
            curl_setopt($this->curl[$slot], CURLOPT_POSTFIELDS, $body);
        }

        /* NING-9699 -- the ;charset=UTF-8 suffix gets in the way for binary
         * uploads, so the logic below excludes adding it to image/, video/
         * and audio/ mime types, but *not* if the MIME type ends in +xml. This
         * allows it to be added to MIME types such as image/svg+xml, which
         * contain text and therefore the charset matters. */
        if (strlen($contentType)) {
            /* Either the content type ends with +xml */
            if (preg_match("@\+xml$@",$contentType) ||
                /* OR the content type is not image/, audio/, video/ */
                (! preg_match("@^(image|audio|video)/@", $contentType))) {
                // Then add the charset string
                $requestHeaders['Content-Type'] = "$contentType;charset=UTF-8";
            }
            else {
                /* The unmodified content type is used. */
                $requestHeaders['Content-Type'] = $contentType;
            }
        }

        if (is_array($additionalHeaders)) {
            foreach ($additionalHeaders as $header => $value) {
                // PRET-279: Don't pass on the USE_SERVICE_LOCATION header with the request
                if ($header == self::USE_SERVICE_LOCATION) {
                    continue;
                }
                // PRET-292: Don't pass on the USE_REQUEST_TIMEOUT header with the request
                if ($header == self::USE_REQUEST_TIMEOUT) {
                    continue;
                }
                // A null value unsets the automatically set header
                if (is_null($value)) {
                    if (isset($requestHeaders[$header])) {
                        unset($requestHeaders[$header]);
                    }
                } else {
                    $requestHeaders[$header] = $value;
                }
            }

        }
		if (!is_null(XN_Profile::$VIEWER))
	    {
			$requestHeaders['profile'] = XN_Profile::$VIEWER;
	    }
        $combinedRequestHeaders = array();
        foreach ($requestHeaders as $header => $value) {
            $combinedRequestHeaders[] = "$header: $value";
        }


        curl_setopt($this->curl[$slot], CURLOPT_HTTPHEADER, $combinedRequestHeaders);

        // Set Accept-Encoding header to allow for compressed response
        curl_setopt($this->curl[$slot], CURLOPT_ENCODING, 'gzip');

        $this->url = $url;         

        // Adjust the request timeout if desired (PRET-292)
        if (isset($additionalHeaders[self::USE_REQUEST_TIMEOUT])) {
            curl_setopt($this->curl[$slot], CURLOPT_TIMEOUT, $additionalHeaders[self::USE_REQUEST_TIMEOUT]);
        }         

        /* Make the mighty request */
        $res = @curl_exec($this->curl[$slot]); 
        
        curl_close($this->curl[$slot]);
       
        // Put the request timeout back if we adjusted it
        if (isset($additionalHeaders[self::USE_REQUEST_TIMEOUT])) {
            curl_setopt($this->curl[$slot], CURLOPT_TIMEOUT, self::$requestTimeout);
        }      
        // If the response timed out, throw an exception (NING-5427)
        if ($res === false) {
            $errno = curl_errno($this->curl[$slot]);
            if ($errno == CURLE_OPERATION_TIMEOUTED) {
                $msg = "Request Timeout: " . self::getRequestTimeout() . " seconds exceeded";
            } else {
                $msg = curl_error($this->curl[$slot]);
            }
            $e = new XN_TimeoutException($msg);
            $apiUrlParts = parse_url($url);
            $e->setLogData(array('api-method' => $method,
                                 'api-host' => isset($apiUrlParts['host']) ? $apiUrlParts['host'] : '-',
                                 'api-url' => $url,
                                 'host' => isset($requestHeaders['Host']) ? $requestHeaders['Host'] : '-',
                                 'pg' => $_SERVER['SERVER_ADDR'],
                                 'method' => $_SERVER['REQUEST_METHOD'],
                                 'url' => $_SERVER['HTTP_X_NING_REQUEST_URI'],
                                 'trace' => self::$TRACE
                                 )
                           );
			$errormsg = "<pre>Uncaught : ".$e->getMessage()."\n".$e->getTraceAsString()."</pre>";
	        header('Content-Type:text/html;charset=utf-8');
			 
			if ($_SERVER["SERVER_ADDR"]== "117.41.237.48" || $_SERVER["SERVER_ADDR"] == "117.41.237.35"  ) 
			{
				$this->errorprint('警告','服务器连接失败!<br><br><div style="text-align: left;padding-left: 30px;"> 江西医流通医疗器械有限责任公司<br>Copyright © 2010-2016 qixieyun.com <br>紧急联系手机：13979158400(王瑞恒)<br></div>');
				
			}
			else 
			{
				$this->errorprint('警告','服务器连接失败!<br><br><div style="text-align: left;padding-left: 30px;"> 湖南赛明威科技有限公司<br>Copyright © 2010-2016 tezan.cn <br>紧急联系手机：15974160308(王真明)<br></div>');
 			}
 	    	
			die();			   
            throw $e;
        }

        // If the response is a 400 or a 500, log the request/response
        // bodies and other relevant info in the centralized log
        // (NING-5886)
        if (($slot != '__other__') &&
            (($this->responseCode == 400) || ($this->responseCode == 500))) {
            $this->logCentralizedError($url, $slot, $body, $combinedRequestHeaders);
        }
        
        if (! self::responseCodeIsOk($this->responseCode)) {
            list($errorCode, $errorMessage) = XN_AtomHelper::parseError($this->body);
            throw new XN_Exception($errorMessage, $this->responseCode);
        }
        
        if ($this->bodyTooBig) {
            throw new XN_Exception("Response body too big: ".$this->headers['Content-Length']." bytes. Max is ".$this->maxResponseSize);
        }  
        return $this->body;
    }
	
	 
	public static function errorprint($title,$msg)
	{
		   $html = '<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>'.$title.'</title>
		<style type="text/css">
		<!--
		.t {
				font-family: Verdana, Arial, Helvetica, sans-serif;
				color: #CC0000;
		}
		.c {
				font-family: Verdana, Arial, Helvetica, sans-serif;
				font-size: 12px;
				font-weight: normal;
				color: #000000;
				line-height: 18px;
				text-align: center;
				border: 1px solid #CCCCCC;
				background-color: #FFFFEC;
		}
		body {
				background-color: #FFFFFF;
				margin-top: 100px;
		}
		-->
		</style>
		</head>
		<body>
		<div align="center">
		  <h2><span class="t">'.$title.'</span></h2>
		  <table border="0" cellpadding="8" cellspacing="0" width="460">
			<tbody>
			  <tr>
				<td class="c">'.$msg.'.</td>
			  </tr>
			</tbody>
		  </table>
		</div>
		</body>
		</html>';
		  echo $html;
		   die();
	} 

    public static function getLastResponseCode() {
        return self::getInstance()->responseCode;
    }

    public static function getLastResponseHeaders() {
    return self::getInstance()->headers;
    }

    public static function setLastResponseCookies() {
    $headers = self::getLastResponseHeaders();
    if (isset($headers['Set-Cookie'])) {
        if (is_array($headers['Set-Cookie'])) {
        foreach ($headers['Set-Cookie'] as $cookieHeader) {
            header('Set-Cookie: '. $cookieHeader, false);
        }
        }
        else {
        header('Set-Cookie: ' . $headers['Set-Cookie']);
        }
    }
    }

    protected static function responseCodeisOk($code) {
        return (($code >= 200) && ($code < 300));
    }

    public static function getLastResponseBody() {
    return self::getInstance()->body;
    }
    /**
     * Return a properly formatted error array given an exception that's
     * come back from a REST call
     *
     * @param $e Exception
     * @return array
     *
     */
    public static function parseErrorsFromException(Exception $e) {
        $errorXml = @simplexml_load_string($e->getMessage());
        $errors = array();
        if ($errorXml instanceof SimpleXmlElement) {
            foreach ($errorXml->error as $error) {
                $errors[ (string) $error['code'] ] = (string) $error;
            }
        }
    if (count($errors) == 0) {
      $errors[-1] = 'Unknown Error';
        }
        $errors[XN_REST::STATUS] = $e->getCode();
        return $errors;
    }

    /**
     * Helper function to set the XN-ResponseFrom header when tracing
     * is enabled
     *
     * @param $url string URL requested
     * @param $requestStart float When the request started (epoch with with millis)
     */
    protected function setTraceResponseHeader($url, $requestStart) {
        /* Chop up $url so we can put just the host in the header */
        $urlParts = parse_url($url);
        /* Calculate milliseconds of elapsed time for the request */
        $time_ms = floor(1000*(microtime(true) - $requestStart));
        /* Add on the necessary info to the built-up header string */
        XN_REST::$RESPONSE_FROM_HEADER =
            sprintf('%s;%s,%d,%d%s',
                    XN_REST::$RESPONSE_FROM_HEADER,
                    $urlParts['host'],
                    $this->responseCode,
                    $time_ms,
                    (isset($this->headers['XN-ResponseFrom']) ?
                     ',(' . $this->headers['XN-ResponseFrom'] . ')' : ''));
        /* Set the XN-ResponseFrom header, trimming the leading semicolon */
        header('XN-ResponseFrom: '.$_SERVER['SERVER_ADDR'].',('.substr(XN_REST::$RESPONSE_FROM_HEADER,1).')');
    }

    /**
     * Log an error to the centralized error log when something's gone
     * significantly wrong with an API request
     *
     * @param $url string The URL requested
     * @param $slot string Which slot was used
     * @param $body string request body
     * @param $requestHeaders array The headers sent with the request
     */
    protected function logCentralizedError($url, $slot, $body, $requestHeaders) {
        // As per NING-6601, we don't log the centralized error if the error code
        // is 400, the response body is XML with an <errors/> clause, and there's
        // no <rest:*> error as a subcode for a listed error. This gives endpoints
        // the opportunity to include a <rest:*/> subcode to indicate that there 
        // was some problem with the data (which we don't really want to log) rather
        // than a more systemic problem with the envelope or request formatting (which
        // we do want to log.
        if ($this->responseCode == 400) {
            $sxml = simplexml_load_string($this->body, null, LIBXML_NOERROR | LIBXML_NOWARNING);
            if ($sxml && ($sxml->getName() == 'errors')) {
                foreach ($sxml->error as $error) {
                    if (strpos($error['code'],'rest:') === 0) {
                        // If we've gotten here, it means that
                        // - the response code is 400
                        // - the response body is well-formed XML
                        // - the top-level XML element is <errors/>
                        // - the <errors/> element has a sub element
                        //   named "<error/>" with a "code" attribute
                        //   whose value begins with the string "rest:"
                        return;
                    }
                }
            }
        }

        $msg = sprintf("%s Request Error: %d,%s,%s,%s,%s,%s,%s,%s,%s,%s\n",
                       gmdate('[Y-m-d\TH:i:s\Z]'),
                       $this->responseCode, $url, XN_Application::$CURRENT_URL,
                       $_SERVER['SERVER_ADDR'], $_SERVER['HTTP_X_NING_REQUEST_URI'],
                       strlen(XN_Profile::$VIEWER) ? XN_Profile::$VIEWER : 'xn_anonymous',
                       strlen(XN_Profile::$PROBABLE_VIEWER) ? XN_Profile::$PROBABLE_VIEWER : 'xn_probable_anonymous',
                       self::$APPCORE_IP,
                       $slot == '__global__' ? self::$GLOBAL_API_HOST_PORT : $slot,
                       self::$TRACE);

        // Add Request Headers
        $msg .= "  Request Headers:\n      ";
        $msg .= implode("\n      ", $requestHeaders) . "\n";

	// If there's a Content-Type header in the request to indicate that the
	// request body isn't text or XML, then base64 encode the request body
	// NING-6613
	$requestBodyIsText = true;
	foreach ($requestHeaders as $requestHeader) {
	    if (strpos($requestHeader,'Content-Type') === 0) {
		$parts = explode(': ', $requestHeader);
		if (isset($parts[1])) {
		    $requestBodyIsText = self::contentTypeIsText($parts[1]);
		    break;
		}
	    }
	}

	if ($requestBodyIsText) {
	    // Add Request Body, but sanitize it if necessary (NING-6581)
	    if (preg_match('@<xn:password>(.+?)</xn:password>@s',$body,$matches)) {
		$password = sprintf("[removed(NING-6581);hash=%s;len=%d]", md5($matches[1]), strlen($matches[1]));
		$body =str_replace($matches[0], "<xn:password>$password</xn:password>", $body);
	    }
	    $msg .= "   Request Body:\n   $body\n";
	} else {
	  $msg .= "   Request Body (base64 encoded):\n" . base64_encode($body)."\n";
	}
	
        $msg .= "   Response Headers:\n";
	$responseBodyIsText = true;
        if (is_array($this->headers)) {
            foreach ($this->headers as $h => $v) {
                $msg .= "      $h: " .
                    (is_array($v) ? implode("\n      $h: ", $v) : $v) .
                    "\n";
		if ((! is_array($v)) && ($v == 'Content-Type')) {
		    $responseBodyIsText = self::contentTypeIsText($v);
		}
            }
        }
	
	if ($responseBodyIsText) {
	  $msg .= "   Response Body:\n$this->body";
	} else {
	  $msg .= "   Response Body (base64 encoded):\n" . base64_encode($this->body);
	}
	$msg .= "\n===\n";
        $fp = @fopen('php://stderr','a');
        if ($fp) {
            @fputs($fp, $msg);
            @fclose($fp);
        }
    }

    protected static function contentTypeIsText($headerValue) {
	// Get rid of any ;charset= stuff
	$contentType = preg_replace('@;.*$@', '', $headerValue);
	// Text is text, XML is text
	return preg_match('@(^text/)|(^application/xml)|(\+xml$)@', $contentType);
    }
}



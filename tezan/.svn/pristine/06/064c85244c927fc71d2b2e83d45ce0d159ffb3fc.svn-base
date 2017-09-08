<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>REST工具</title>
	

	<script src="js/jquery-1.7.1.min.js" type="text/javascript"></script> 
	<script src="js/jquery.bgiframe.js" type="text/javascript"></script>
	<script src="js/jquery.autocomplete.js" type="text/javascript"></script>
	<link href="css/jquery.autocomplete.css" rel="stylesheet" rel="stylesheet" type="text/css" />
	 
		
	<script type="text/javascript" src="scripts/shCore.js"></script>
	<script type="text/javascript" src="scripts/shBrushBash.js"></script>
	<script type="text/javascript" src="scripts/shBrushCpp.js"></script>
	<script type="text/javascript" src="scripts/shBrushCSharp.js"></script>
	<script type="text/javascript" src="scripts/shBrushCss.js"></script>
	<script type="text/javascript" src="scripts/shBrushDelphi.js"></script>
	<script type="text/javascript" src="scripts/shBrushDiff.js"></script>
	<script type="text/javascript" src="scripts/shBrushGroovy.js"></script>
	<script type="text/javascript" src="scripts/shBrushJava.js"></script>
	<script type="text/javascript" src="scripts/shBrushJScript.js"></script>
	<script type="text/javascript" src="scripts/shBrushPhp.js"></script>
	<script type="text/javascript" src="scripts/shBrushPlain.js"></script>
	<script type="text/javascript" src="scripts/shBrushPython.js"></script>
	<script type="text/javascript" src="scripts/shBrushRuby.js"></script>
	<script type="text/javascript" src="scripts/shBrushScala.js"></script>
	<script type="text/javascript" src="scripts/shBrushSql.js"></script>
	<script type="text/javascript" src="scripts/shBrushVb.js"></script>
	<script type="text/javascript" src="scripts/shBrushXml.js"></script>
	
	<link type="text/css" rel="stylesheet" href="styles/shCore.css"/>
	<link type="text/css" rel="stylesheet" href="styles/shThemeDefault.css"/>
	<script type="text/javascript">
		SyntaxHighlighter.config.clipboardSwf = 'scripts/clipboard.swf';
		SyntaxHighlighter.all();
	</script> 
	<style>
	.ui-widget
	{
		 line-height: 30px;
	}
	</style>
</head>

<body>
	
<?php

function xml2array ( $xmlObject, $out = array () )
{
	foreach ( (array) $xmlObject as $index => $node )
	{
		$out[$index] = ( is_object ( $node ) ) ? xml2array ( $node ) : $node;
	}
	return $out;
}


 

function http_get($url,$host) 
{ 
	 $curlObj = curl_init();
	 curl_setopt($curlObj, CURLOPT_URL, str_replace(' ','%20',$url)); 
     
	 $requestHeaders = array("domain"=>$host);
	 $combinedRequestHeaders = array();
     foreach ($requestHeaders as $header => $value) {
         $combinedRequestHeaders[] = "$header: $value";
     } 
	 curl_setopt($curlObj, CURLOPT_HTTPHEADER, $combinedRequestHeaders); 
     curl_setopt($curlObj, CURLOPT_CUSTOMREQUEST, 'GET');
     curl_setopt($curlObj, CURLOPT_HTTPGET, true); 
	 curl_setopt($curlObj, CURLOPT_ENCODING, 'gzip');
	 curl_setopt($curlObj, CURLOPT_USERAGENT,"XN-REST 0.2");
	 curl_setopt($curlObj, CURLOPT_HEADER, TRUE);    //表示需要response header
     curl_setopt($curlObj, CURLOPT_NOBODY, FALSE); //表示需要response body
     curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, TRUE);
	 curl_setopt($curlObj, CURLOPT_VERBOSE, false);
     curl_setopt($curlObj, CURLOPT_TIMEOUT, 1200);
	 $res = @curl_exec($curlObj);
	 if ($res === false) {
           $errno = curl_errno($curlObj);
           if ($errno == CURLE_OPERATION_TIMEOUTED) {
               $msg = "Request Timeout: " . self::getRequestTimeout() . " seconds exceeded";
           } else {
               $msg = curl_error($curlObj);
           }
           $e = new XN_TimeoutException($msg);   
		   curl_close($curlObj);        
           throw $e;
       } 
	 curl_close($curlObj);
	 return $res;
} 

function array2options($arr,$select)
{
	$temp = "";
	foreach ( $arr as $node )
	{
		if ($select == $node)
			$temp .= "<option selected >".$node."</option> ";
		else
		    $temp .= "<option>".$node."</option> ";
	}
	return $temp;
}

 



 


	 $configxml =  file_get_contents("config.xml",true);
	 $configxmlObj = simplexml_load_string($configxml, 'SimpleXMLElement', LIBXML_NOCDATA);
	 //print_r($configxmlObj); 
	 $application_list =  explode(";",$configxmlObj->application); 
	 $address_list =  explode(";",$configxmlObj->address);
	 $history =   $configxmlObj->history;
	 $history_list = xml2array($history); 
	 
	if(isset($_REQUEST['address']) && $_REQUEST['address'] != '' &&
	   isset($_REQUEST['application']) && $_REQUEST['application'] != '' &&
	   isset($_REQUEST['url']) && $_REQUEST['url'] != '')
	{
		$address = $_REQUEST['address'];
		$application = $_REQUEST['application'];
		if(isset($_REQUEST['url_input']) != $_REQUEST['url'])
		{
			$url = $_REQUEST['url_input'];
		}
		else
		{
			$url = $_REQUEST['url'];
		}
		$url = $_REQUEST['url'];
	    $newurl = sprintf('http://%s%s',$address,$url);
		$body = http_get($newurl,$application);
	}
	else
	{
		$address = "127.0.0.1:8000";
		$application = "admin";
		$url = "/xn/rest/1.0/content(type eic 'tabs')?from=0&to=2&xn_out=xml";
	}
	
function url_encode($str)
{
	return str_replace('"','\'',$str);
}	
	
	$historys = array_map("url_encode",$history_list['item']);  

?>
<form  action="index.php" method="post">
<div class="ui-widget address">
	<label>服务器地址:&nbsp;</label>
	<select id="address" name="address">
	<option value="">Select one...</option> 
	<?php echo array2options($address_list,$address) ?> 
</select>
</div>
<div class="ui-widget application">
	<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;应用:&nbsp;</label>
	<select id="application" name="application">
	<option value="">Select one...</option>
	<?php echo array2options($application_list,$application) ?> 
	</select>
</div> 
<div class="ui-widget url">
	<label>&nbsp;&nbsp;&nbsp;链接地址:&nbsp;</label>
	<input autocomplete="off"  id="url" name="url" value="<?php echo $url; ?>" style="width: 900px; color:#555"  type="text"/>
</div>
<div class="ui-widget">
	<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
	<button type="submit">GET</button>
</div>
</form>
<script language="javascript">
$().ready(function() {

	 
	var cities = ["<?php echo join("\",\n\"",$historys); ?>"];
 
	
	$("#url").focus().autocomplete(cities,{
		matchContains: true,
		minChars: 0
	});
	 
	
	 
});

 
</script>
<pre class="brush: xml;">
<?php

	echo $body;
?>
</pre>
</html>

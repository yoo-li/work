<?php
/** Defines the XN Application PHP API.
 * @file
 * @ingroup XN
 */

/* $Revision: 50483 $ */

/** @cond */
if (! class_exists('XN_Application')) {
/** @endcond */ 

/** An XN_Application object represents an application in the system.
 *
 * An XN_Application object is composed of properties representing 
 * characteristics and relationships of the application. The names of these 
 * properties are identified by constants and are accessed as simulated 
 * instance variables through the '->' operator using the magic XN_Application::__get 
 * method. Properties can be categorized into intrinsic properties which are 
 * part of the application object stored in the database, and extrinsic 
 * properties which are not part of the application object stored in the 
 * database.    
 * 
 * @ingroup XN
 */
class XN_Application {
    
    /** @unsupported @internal 
     * Set automatically in the request
     */
    public static $CURRENT_URL;

	public static $DESCRIPTION;


    /* Set when XN_Application object is created for the current
     * application and only relativeUrl is set. _getProperty() resets this
     * after loading the rest of the information from the system. */
    private $_loadWasDelayed = false;

    /**
     * This can be passed to XN_Application::iconUrl() as a dimension to 
     * preserve aspect ratio. (NING-3312)
     */
    const PRESERVE_ASPECT_RATIO = 'preserve-aspect-ratio';
    
    //-------------------------------------------------------------------------
    // PUBLIC CONSTANTS: PROPERTIES
    //-------------------------------------------------------------------------
    /**
     * Read-only <i>string</i> intrinsic property: the created date of format
     * YYYYMMDDTHH:MM:DD where T and : are separators.
     */
    const createdDate = 'createdDate';
    /**
     * Read-only <i>string</i> intrinsic property: the updated date of format
     * YYYYMMDDTHH:MM:DD where T and : are separators.
     */
    const updatedDate = 'updatedDate';
    /**
     * Read-only <i>string</i> intrinsic property: the application name.
     */
    const name = 'name';
    /**
     * Read-only <i>string</i> intrinsic property: the description.
     */
    const description = 'description';
    /**
     * Read-only <i>string</i> intrinsic property: the relative url.
     */
    const relativeUrl = 'relativeUrl';
    /**
     * Writable <i>string</i> intrinsic property: the published state.
     */
    const publishedState = 'publishedState';   
    /**
      * Read-only <i>object</i> extrinsic property: the owner
      * {@link XN_Profile profile} object.
      */
    const owner = 'owner';
    /**
     * Read-only <i>string</i> intrinsic property: the owner profile 
     * name.
     */
    const ownerName = 'ownerName';
    /**
     * Read-only <i>array</i> property: premium services. Keys are
     * active premium service names. Values (if any) are currently
     * undefined 
     */
    const premiumServices = 'premiumServices';
    /**
     * Read-only <i>array</i> property: tags
     */
    const tags = 'tags';
    /**
     * Read-only <i>array</i> property: categories. Keys are terms,
     * values are labels.
     */
    const categories = 'categories';
    /**
     * Read-only <i>array</i> property: domains
     */
    const domains = 'domains';
    /**
     * Read-write <i>array</i> property: mappings
     * Keys are URL mapping patterns, values are target URLs
     */
    const mappings = 'mappings';
    /**
     * Read-only <i>array</i> property: cdnpolicy. This is an associative array
     * of arrays that describe the cdn policy structure. At a minimum, the array
     * looks like:
     *  'api' => array('default' => array(...hosts...)),
     *  'static' => array('default' => array(...hosts...))
     *
     * In which the two inner arrays contain the hosts to use for CDN-aware URLs for
     * API-generated images and static resources, respectively.
     */
    const cdnpolicy = 'cdnpolicy';

    const boost = 'boost';
    const codeVersion = 'codeVersion';
    const isLaunched = 'isLaunched';
    const locale = 'locale';
    const timezoneOffset = 'timezoneOffset';
    const useDST = 'useDST';
    const videoEncodingProfile = 'videoEncodingProfile';
    const tagline = 'tagline';
    const isPublic = 'isPublic';
    const invitationOnly = 'invitationOnly';
    const allowInvitationRequests = 'allowInvitationRequests';


    /**
     * Constants to represent various premium services
     */
    const PREMIUM_PRIVATE_SOURCE = 'private-source';
    const PREMIUM_RUN_OWN_ADS = 'run-own-ads';
    const PREMIUM_STORAGE = 'storage';
    const PREMIUM_DOMAIN_MAPPING = 'domain-mapping';
    
    

    //-------------------------------------------------------------------------
    // PRIVATE VARIABLES
    //-------------------------------------------------------------------------

    /*
     * Note: All instance variables are prefixed with '_' to avoid name 
     * collisions with properties.
     */
    
    /*
     * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
     * IMPORTANT: Update the _copy method if these vars are changed
     *!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!  
     */
    private $_remainnumberofsmss;
	private $_numberofsmss;
	private $_numberofusers;
	private $_remainstoragespace;
	private $_storagespace;
	private $_point;
	private $_active;
	private $_trialtime;
	private $_link;
	
	private $_province;
	private $_city;
	
    private $_createdDate;
    private $_updatedDate;
    private $_name;
    private $_description;
    private $_relativeUrl;
    private $_publishedState;
    private $_ownerName;
    private $_iconUrl;
    private $_premiumServices = array();
    private $_tags = array();
    private $_categories = array();
    private $_domains = array();
    private $_mappings = null;
    private $_cdnpolicy = array();

    // updatable fields
    private $_boost;
    private $_codeVersion;
    private $_isLaunched;
    private $_locale;
    private $_timezoneOffset;
    private $_useDST;
    private $_videoEncodingProfile;
    private $_tagline;
    private $_isPublic;
    private $_invitationOnly;
    private $_allowInvitationRequests;
    // for :update() / save() for appupdate
    private $_updated = null;
    private $_updatedMappings = null;

    /* Used by ::create() / save() for new apps */
    private $_parent;
    private $_unsaved = null;
	public $_tag = null;

    // Internal Property Fields
    // Static variables are used because constants cannot be declared private
    private static $ICON_URL = "_iconUrl";
    
    // XML RPC Operations and Field Identifiers
    // Static variables are used because constants cannot be declared private

    private static $F_CREATED_DATE = "createdDate";
    private static $F_UPDATED_DATE = "updatedDate";
    private static $F_NAME = "name"; 
    private static $F_DESCRIPTION = "description"; 
    private static $F_RELATIVE_URL = "relativeUrl"; 
    private static $F_PUBLISHED_STATE = "publishedState"; 
    private static $F_OWNER = "owner"; 
    private static $F_OWNER_NAME = "ownerName";
    
    private static $V_CURRENT = "CURRENT";

	

    //------------------------------------------------------------------------
    // DEBUG METHODS
    //------------------------------------------------------------------------
        
    /**
     * Returns a string debug representation of the XN_Application object.
     * @return string
     */
    public function debugString() {
        $str =  "XN_Application:\n";
        $str .= "  createdDate [".$this->createdDate."]\n";
        $str .= "  updatedDate [".$this->updatedDate."]\n";
        $str .= "  name [".$this->name."]\n";
        $str .= "  description [".$this->description."]\n";
        $str .= "  relativeUrl [".$this->relativeUrl."]\n";
        $str .= "  publishedState [".$this->publishedState."]\n";
        $str .= "  ownerName [".$this->ownerName."]\n";
        $str .= "  boost [".$this->boost."]\n";
        $str .= "  codeVersion [".$this->codeVersion."]\n";
        $str .= "  isLaunched [".$this->isLaunched."]\n";
        $str .= "  locale [".$this->locale."]\n";
        $str .= "  timezoneOffset [".$this->timezoneOffset."]\n";
        $str .= "  useDST [".$this->useDST."]\n";
        $str .= "  videoEncodingProfile [".$this->videoEncodingProfile."]\n";
        $str .= "  tagline [".$this->tagline."]\n";
        $str .= "  isPublic [".$this->isPublic."]\n";
        $str .= "  invitationOnly [".$this->invitationOnly."]\n";
        $str .= "  allowInvitationRequests [".$this->allowInvitationRequests."]\n";
        if (count($this->premiumServices)) {
            $str .= "  premiumServices [\n";
            foreach ($this->premiumServices as $service => $description) {
                $str .= "    $service\n";
            }
            $str .="  ]\n";
        }
        if (count($this->tags)) {
            $str .= "  tags [\n";
            foreach ($this->tags as $tag) {
                $str .= "    $tag\n";
            }
            $str .= "  ]\n";
        }
        if (count($this->categories)) {
            $str .= "  categories [\n";
            foreach ($this->categories as $term => $label) {
                $str .= "    $term ($label)\n";
            }
            $str .= "  ]\n";
        }
        if (count($this->domains)) {
            $str .= "  domains [\n"; 
            foreach ($this->domains as $domain) {
                $str .= "    $domain\n";
            }
           $str .= "  ]\n";
        }
        if (count($this->mappings)) {
            $str .= "  mappings [\n";
            foreach ($this->mappings as $pattern => $target) {
                $str .= "    $pattern => $target\n";
            }
            $str .= "  ]\n";
        }
        if (count($this->cdnpolicy)) {
            $str .= "  cdnpolicy [\n"; 
            foreach ($this->cdnpolicy as $policyType => $policyCategoryArray) {
                foreach ($policyCategoryArray as $category => $hostnames) {
                    $str .= "    $policyType: $category=" . implode(', ' , $hostnames) . "\n";
                }
            }
            $str .= "  ]\n";
        }
        return $str;        
    }

    /**
     * Returns a string debug representation of the XN_Application object 
     * within an HTML pre tag.
     * @return string
     */
    public function debugHtml() {
        return '<pre>' . xnhtmlentities($this->debugString()) . '</pre>';
    }

    //------------------------------------------------------------------------
    // PROPERTY ACCESSOR
    //------------------------------------------------------------------------        
    
    /**
     * Provides read access to the property of the given name simulated as a 
     * public instance variable accessed through the '->' operator.
     * 
     * @param $name string property name
     * @return mixed
     */
    public function __get($name) { 
        return $this->_getProperty($name);
    }

    /**
     * Provides write access to mutable properties
     */
    public function __set($name, $value) { 
        $this->_lazyLoad($name);
        $allowed_properties = array('remainnumberofsmss','numberofsmss','numberofusers','remainstoragespace','storagespace','trialtime','point','link','province','city','active','description');

        if ($name == self::mappings) {
            if (is_array($value)) {
                $this->_mappings = $value;
                $this->_updatedMappings = true;
            } else {
                throw new XN_IllegalArgumentException("Value for mappings must be an array");
	    }
        }
	elseif (in_array($name, $allowed_properties)) { 
	    $this->{"_$name"}  = $value;
	    $this->_updated = true;
	}
        else {
            throw new XN_IllegalArgumentException("Property $name is not settable");
        }
        
    }

    //------------------------------------------------------------------------
    // STATIC METHODS
    //------------------------------------------------------------------------            

    /**
     * Static method that loads and returns an XN_Application object 
     * from the database for the given application relative URL 
     * 
     * Throws an {@link XN_Exception} if an error occurred.
     * 
     * Example of retrieving the XN_Application object for a relative URL:
     * <code>
     * $application = XN_Application::load($relativeURL);
     * // $application is an XN_Application object
     * </code>
     * 
     * @param $relativeUrl string a string relative URL. If omitted or null, the 
     * current application is loaded.
     * @return XN_Application
     * @see XN_Exception
     */
    public static function load($relativeUrl = null,$tag = null) {
      if (!is_array($relativeUrl) && (is_null($relativeUrl)||(strcasecmp($relativeUrl,self::$CURRENT_URL) == 0))) {
            $app = XN_Cache::_get(self::$CURRENT_URL, 'XN_Application');
            if (is_null($app)) {
                
                /* Frequently, code just uses the relativeUrl property of the current
                 * XN_Application object. Since we already know that (self::$CURRENT_URL),
                 * create a new XN_Application object with that in it and defer
                 * loading the other properties until they're asked for
                 * (in _getProperty()) */
                 $app = XN_Application::_createEmpty();
                 $app->_relativeUrl = self::$CURRENT_URL;
                 $app->_loadWasDelayed = true;
				 $app->_tag = $tag;
                 XN_Cache::_put($app);
            }
            return $app;
        } else {
	  if (is_array($relativeUrl)) {  //load many
	    return self::loadMany($relativeUrl);
	  }
	  else {		// load single
            // Has this app object already been loaded on this request?
            $cachedApp = XN_Cache::_get($relativeUrl, 'XN_Application');
            if (is_null($cachedApp)) {
	      /* NING-6044: Load other application's info from that application's
	       * URL */
	       if ($_SERVER['XN_Application_use_proc_endpoint'] == 1) {
               $url = XN_AtomHelper::APP_REST_PREFIX('1.0') . XN_REST::urlsprintf("/application(subdomain='%s')", $relativeUrl);
   	           $rsp = XN_REST::get($url, array(XN_REST::USE_SERVICE_LOCATION => 'provisioning'));
           }
	       else {
				   //$url = XN_AtomHelper::ENDPOINT_APP($relativeUrl) . '/application';
				   $url = XN_REST::urlsprintf("/application(domain='%s')", $relativeUrl);
				   if ( $tag != null)
				   {
						 $headers = array('tag' => $tag);
						 $rsp = XN_REST::get($url,$headers);
				   }
				   else
				   {
						$rsp = XN_REST::get($url);
				   }
               }
	      // loadFromAtomFeed() populates XN_Cache
	      return XN_AtomHelper::loadFromAtomFeed($rsp,'XN_Application');
	    } else {
	      return $cachedApp;
	    }
	  }
        }
    }
    
    /** @unsupported @internal
     * Return a new application object. When the object is saved, the
     * new application will be created. This is only available from a
     * trusted app.
     *
     * @param $subdomain string subdomain (under .ning.com) for the new app
     * @param $parent string subdomain of parent app to clone from
     * @param $props array optional properties for the new app:
     *   "title": app name; defaults to $subdomain if not specified
     *   "description": app description. Defaults to empty string if not specified
     * 
     * Validation of subdomain, parent, and props happens on save.
     */
    public static function create($subdomain, $parent, $props = null) {
        if (! is_array($props)) { $props = array(); }
        $app = XN_Application::_createEmpty();
        $app->_relativeUrl = $subdomain;
        $app->_parent = $parent;
        $app->_name = isset($props['name']) ? $props['name'] : $subdomain;
        $app->_description = isset($props['description']) ? $props['description'] : '';
        $app->_unsaved = true;
        return $app;
    }


    /**
     * Static method that runs code in another application
     * 
     * Throws an {@link XN_Exception} if an error occurred
     * 
     * Example of running a file in another application:
     * <code>
     * XN_Application::includeFile('SomeOtherApp','/MyComponents/Whizzy.php');
     * </code>
     * 
     * @param $targetApp string|XN_Application A string application subdomain or XN_Application object
     * @param $path string Pathname of the file in the target application to run. Must begin with '/'
     */
    public static function includeFile($targetApp, $path) {
        $targetPath = self::checkIncludeFile($targetApp, $path);
        include $targetPath;
    }
    
    /**
     * Static method that runs code in another application. If the file
     * specified has already been included via includeFileOnce(), it 
     * won't be re-executed.
     * 
     * Throws an {@link XN_Exception} if an error occurred
     * 
     * Example of running a file in another application:
     * <code>
     * XN_Application::includeFileOnce('SomeOtherApp','/MyComponents/Whizzy.php');
     * </code>
     * 
     * @param $targetApp string|XN_Application A string application subdomain or XN_Application object
     * @param $path string Pathname of the file in the target application to run. Must begin with '/'
     */
    public static function includeFileOnce($targetApp, $path) {
        $targetPath = self::checkIncludeFile($targetApp, $path);
        include_once $targetPath;
    }
    
    protected static function checkIncludeFile($targetApp, $path) {
        // Validate $targetApp
        if ($targetApp instanceof XN_Application) {
            $targetApp = $targetApp->relativeUrl;
        }
        if (! preg_match('/^[a-zA-Z0-9\-\_ ]+$/', $targetApp)) {
            throw new XN_IllegalArgumentException("Invalid app: $targetApp");
        }
        // Validate $path
        if ($path{0} != '/') {
            throw new XN_IllegalArgumentException('$path must begin with /');
        }
        try {
            $targetPath = XN_AppFilesystemStream::translatePath(XN_AppFilesystemStream::SCHEME.'://' . $targetApp . $path);
            return $targetPath;
        } catch (Exception $e) {
            throw new XN_Exception("$path in $targetApp is not available.");
        }
    }

    /**
    * Method that retrieves the URL for the application's icon picture. 
    *
    * If called with no arguments, the URL returned will be for an image
    * with the default dimensions (64 x 64)
    *
    * If called with one integer argument, that argument will be the largest
    * dimension, and the other dimension will be scaled appropriately to 
    * preserve aspect ratio. For example, on an image of width 50 and height 100,
    * iconUrl(10) will produce a URL to an image that is 5px wide and 10px high.
    * (NING-3312)
    *
    * If called with two integer arguments, those arguments will be used as the
    * image dimensions. For example, on an image of width 50 and height 100,
    * iconUrl(43,582) will produce a URL to an image that is 43 px wide and
    * 582 px high.
    *
    * When called with two arguments, one of the arguments, instead of an integer,
    * can be the constant XN_Application::PRESERVE_ASPECT_RATIO, which will cause that
    * dimension to be whatever preserves the aspect ratio. For example, on an image
    * of width 50 and height 100, iconUrl(25, XN_Application::PRESERVE_ASPECT_RATIO)
    * will produce a URL to an image that is 25px wide and 50px high. On the same
    * image, iconUrl(XN_Application::PRESERVE_ASPECT_RATIO, 200) will produce a URL
    * to an image that is 100px wide and 200px high. (NING-3312)
    *
    * @param $width const|integer optional thumbnail width (defaults to 64) in pixels
    * @param $height const|integer optional thumbnail height (defaults to 64) in pixels
    */
    public function iconUrl($width = null, $height = null) {
        $url = $this->_lazyLoad(XN_Application::$ICON_URL);
        $url .= (strstr($this->_iconUrl,'?') === false) ? '?' : '&';
        
        /* Given the arguments, figure out what query string variables to add */
        $vars = array();
        $widthIsInt = ctype_digit((string) $width);
        $heightIsInt = ctype_digit((string) $height);
        /* No arguments? Use default dimensions */
        if (is_null($width) && is_null($height)) {
            $vars['width'] = 64;
            $vars['height'] = 64;
        }
        /* One argument that looks like an integer? */
        else if (is_null($height) && $widthIsInt) {
            $vars['size'] = $width;
        }
        /* Two integer arguments? */
        else if ($widthIsInt && $heightIsInt) {
            $vars['width'] = $width;
            $vars['height'] = $height;
        }
        /* Integer width and preserve aspect ratio height? */
        else if ($widthIsInt && ($height == self::PRESERVE_ASPECT_RATIO)) {
            $vars['width'] = $width;
            
        }
        /* Integer height and preserve aspect ratio width? */
        else if ($heightIsInt && ($width == self::PRESERVE_ASPECT_RATIO)) {
            $vars['height'] = $height;
        }
        /* Something else ?! */
        else {
            throw new XN_IllegalArgumentException("Invalid arguments to iconUrl($width,$height)");
        }
        $url .= http_build_query($vars);
        return $url;
    }    

    /**
     * Save any changeable application metadata
     */
    public function save($tag = null) {
	if ($this->_updated === true) {
            try {            	
            	$entry = '<?xml version="1.0" encoding="UTF-8"?>
<feed xmlns="http://www.w3.org/2005/Atom" xmlns:xn="http://localhost/atom/1.0">'. $this->_toAtomEntry(true).'</feed>';
            	
				$headers = array(XN_REST::USE_SERVICE_LOCATION => 'provisioning');
            	if ($tag != null)
				{
					$headers['tag'] = $tag;
				}
		        $res = XN_REST::put(XN_AtomHelper::APP_REST_PREFIX('1.0').'/application?xn_out=xml',
                                    $entry,
                                    'application/atom+xml',$headers);
            } catch (Exception $e) {
                //return XN_REST::parseErrorsFromException($e);
                throw XN_Exception::reformat("Failed to save Application:\n" . $this->debugString(), $e);
            }
	}
        else if ($this->_unsaved === true) {
            try { 
            	$entry = '<?xml version="1.0" encoding="UTF-8"?>
<feed xmlns="http://www.w3.org/2005/Atom" xmlns:xn="http://localhost/atom/1.0">'.$this->_toAtomEntry().'</feed>';
				$headers = array(XN_REST::USE_SERVICE_LOCATION => 'provisioning');
            	if ($tag != null)
				{
					$headers['tag'] = $tag;
				}
                $res = XN_REST::post(XN_AtomHelper::APP_REST_PREFIX('1.0').'/application?xn_out=xml', $entry, 'application/atom+xml',$headers);
                $this->_unsaved = false;
                /*$x = XN_AtomHelper::XPath($res);
                $this->_createdDate = $x->textContent('/atom:feed/atom:entry/atom:published');
                $this->_updatedDate = $x->textContent('/atom:feed/atom:entry/atom:updated');
                $this->_ownerName =$x->textContent('/atom:entry/atom:author/atom:name', null, true);*/
                
                $d = new DomDocument();
				$d->loadXML($res);
				$x = XN_AtomHelper::XPath($d);
				$node = $x->query('/atom:feed/atom:entry')->item(0);
				if ($node == null) {
					 //$errormsg = $d->getElementsByTagName("error")->item(0)->nodeValue;
					 $errormsg = "save application error.";		
				     throw new XN_Exception($errormsg); 
				} 
				$this->_fromAtomEntry($x, $node);
                
                $this->_publishedState = 'Y'; // start off published
            } catch (Exception $e) {
                //return XN_REST::parseErrorsFromException($e);
                throw XN_Exception::reformat("Failed to save Application:\n" , $e);
            }
        }
        if ($this->_updatedMappings === true) {
            try {
                $this->_saveMappings();
            } catch (Exception $e) {
                //return XN_REST::parseErrorsFromException($e);
                throw XN_Exception::reformat("Failed to save Application:\n" . $this->debugString(), $e);
            }
        }
	return true;
    }

    /**
     * Delete the specified application.
     *
     * @param $subdomain string subdomain of application to delete. The underlying endpoint
     *   verifies that the request is coming from a trusted app.
     * @return true|array If deletion succeeds, returns true, otherwise returns an array
     *   of error messages.
     */
    public function delete() {
        try {
            $url = XN_REST::urlsprintf(XN_AtomHelper::APP_REST_PREFIX('1.0')."/application(domain='%s')",$this->_relativeUrl);
            XN_REST::delete($url, array(XN_REST::USE_SERVICE_LOCATION => 'provisioning'));
            return true;
        } catch (Exception $e) {
            return XN_REST::parseErrorsFromException($e);
        }
    }


    /**
     * Accept a user as a member of the app.
     * Returns true if the acceptance succeeds.
     *
     * @param $user mixed user to accept. Defaults to currently logged in user. Provided
     *    value can be a screen name, an email address, or an XN_Profile object.
     * @param $joined string|DateTime date/time that the user should be marked as becoming a 
     *    member of the app. String must be an ISO-1601 datestamp. Defaults to current time.
     *
     * @return boolean
     * @throws XN_IllegalStateException if there is no currently signed-in user and no value for
     *    $user was provided
     */
    public function acceptMember($user = null, $joined = null) {
        if (is_null($user)) {
            $p = XN_Profile::current();
            if (! $p->isLoggedIn()) {
                throw new XN_IllegalStateException("Can't accept anonymous user as a member");
            }
        }
        else if ($user instanceof XN_Profile) {
            $p = $user;
        } else {
            $p = XN_Profile::load($user);
        }
        if (is_null($joined)) {
            $when = '';
        }
        elseif ($joined instanceof DateTime) {
            $when = XN_REST::xmlsprintf('<published>%s</published>', $joined->format(DATE_ATOM));
        }
        else {
            $when = XN_REST::xmlsprintf('<published>%s</published>', (string) $joined);
        }

        $entry = trim(XN_REST::xmlsprintf('
<entry xmlns="%s" xmlns:xn="%s">
  <xn:id>%s</xn:id>
  '.$when.'
</entry>', XN_AtomHelper::NS_ATOM, XN_AtomHelper::NS_XN, $p->screenName));
        XN_REST::post(XN_AtomHelper::APP_REST_PREFIX('1.0') . 
                      XN_REST::urlsprintf("/membership/application(subdomain='%s')/user",
                                          XN_Application::load()->relativeUrl), $entry, 'application/atom+xml');
        return (XN_REST::getLastResponseCode() == 201);
    }

    /**
     * Reject a current member so they are no longer a member of the app.
     * Returns true if the rejection succeeds.
     *
     * @param $user string|XN_Profile string screenName or XN_Profile object of the
     *   user to reject
     * @return boolean
     */
    public function rejectMember($user) {
        if ($user instanceof XN_Profile) {
            $user = $user->screenName;
        }
        XN_REST::delete(XN_AtomHelper::APP_REST_PREFIX('1.0') . 
                      XN_REST::urlsprintf("/membership/application(subdomain='%s')/user(id='%s')",
                                          XN_Application::load()->relativeUrl,
                                          $user));
        return (XN_REST::getLastResponseCode() == 204);
    }

    //------------------------------------------------------------------------
    // PACKAGE ONLY METHODS
    //------------------------------------------------------------------------        

    /** @unsupported @internal */
    function _getId(){
        return $this->_relativeUrl;
    }
    
    /** @unsupported @internal
     * Static method that returns the XN_Application object of the given
     * relative URL from the cache, or from the database if it hasn't yet
     * been loaded.
     * @param $relativeUrl string an XN_Application relative URL
     * @return XN_Application
     */
    static function _get($relativeUrl) {
        if ($relativeUrl == NULL) { return NULL; }
        $application = XN_Cache::_get($relativeUrl, 'XN_Application');
        return $application!=NULL ? $application : self::load($relativeUrl); 
    }
    
    //------------------------------------------------------------------------
    // PRIVATE METHODS
    //------------------------------------------------------------------------
            
    private function __construct() {
    }
    
    /** @unsupported @internal */
    public static function _createEmpty() {
        return new XN_Application();
    }

    private function _getProperty($name){
        if (strpos($name, '_') === 0) {
            throw new XN_IllegalArgumentException(
                "Invalid property name: '".$name."'");
        }
        return $this->_lazyLoad($name);
    }

    /**
     * Lazy-loads the specified property
     *
     * @param $prop string The property to load
     */
    private function _lazyLoad($prop) {
        if ($this->_loadWasDelayed && ($prop != self::relativeUrl)) {
            if ($this->_relativeUrl != self::$CURRENT_URL) {
                throw new XN_Exception('Delayed loading only supported for current application.');
            }
  	    if ($_SERVER['XN_Application_use_proc_endpoint'] == 1) {
                $url = XN_AtomHelper::APP_REST_PREFIX('1.0') . XN_REST::urlsprintf("/application(subdomain='%s')", $this->_relativeUrl);
				if ($this->_tag != null)
				{
					$headers = array('tag' => $this->_tag);
					$headers[XN_REST::USE_SERVICE_LOCATION] = 'provisioning';
					$rsp = XN_REST::get($url, $headers);
				}
				else
				{
					 $rsp = XN_REST::get($url, array(XN_REST::USE_SERVICE_LOCATION => 'provisioning'));
				}               
            }
            else {
				if ($this->_tag != null)
				{
					$headers = array('tag' => $this->_tag);
					$rsp = XN_REST::get('/application',$headers);
				}
				else
				{
    				$rsp = XN_REST::get('/application');
				}
            }
            // The cache-handling code in loadFromAtomFeed() copies the 1
            // properties from the loaded object into $this, since that's 
            // the (stub) object already in the cache
            $app = XN_AtomHelper::loadFromAtomFeed($rsp,'XN_Application');
            $this->_copy($app);
            $this->_loadWasDelayed = false;
        }

        // Only return certain properties for newly-created/unsaved apps
        if (($this->_unsaved === true) &&
            (! in_array($prop, array('name','description','relativeUrl')))) {
            throw new XN_Exception("Only name, description, and relativeUrl available for unsaved apps  ($prop) ");
        }
        
        switch ($prop) {
        case self::createdDate:
            return $this->_createdDate;
        case self::updatedDate:
            return $this->_updatedDate;
        case self::name:
            return $this->_name;
        case self::description:
            return $this->_description;
        case self::relativeUrl:
            return $this->_relativeUrl;
        case self::publishedState:
            return $this->_publishedState;
        case self::owner:
            return XN_Profile::_get($this->_ownerName);
        case self::ownerName:
            return $this->_ownerName;
        case XN_Application::$ICON_URL:
            return $this->_iconUrl;
        case self::premiumServices:
            return $this->_premiumServices;
        case self::tags:
            return $this->_tags;
        case self::categories:
            return $this->_categories;
        case self::domains:
            return $this->_domains;
        case self::mappings:
            /* $this->_mappings is null until we lazy-load the values */
            /*if (is_null($this->_mappings)) {
                $this->_loadMappings();
            }*/
            return $this->_mappings;
        case self::cdnpolicy:
            return $this->_cdnpolicy;
        case self::boost:
            return $this->_boost;
        case self::codeVersion:
            return $this->_codeVersion;
        case self::isLaunched:
            return $this->_isLaunched;
        case self::locale:
            return $this->_locale;
        case self::timezoneOffset:
            return $this->_timezoneOffset;
        case self::useDST:
            return $this->_useDST;
        case self::videoEncodingProfile:
            return $this->_videoEncodingProfile;
        case self::tagline:
            return $this->_tagline;
        case self::isPublic:
            return $this->_isPublic;
        case self::invitationOnly:
            return $this->_invitationOnly;
        case self::allowInvitationRequests:
            return $this->_allowInvitationRequests;
			
         case "province":
            return $this->_province; 
         case "city":
            return $this->_city;  
         case "remainnumberofsmss":
         	return $this->_remainnumberofsmss;
		 case "numberofsmss":
		 	return $this->_numberofsmss;
		 case "numberofusers":
		 	return $this->_numberofusers;
		 case "remainstoragespace":
		 	return $this->_remainstoragespace;
		 case "storagespace":
		 	return $this->_storagespace;
		 case "point":
		 	return $this->_point;
		 case "active":
		 	return $this->_active;
		 case "trialtime":
		 	return $this->_trialtime;
		 case "link":
		 	return $this->_link;			 	
        default:
            throw new XN_IllegalArgumentException("Invalid property name: '".$prop."'");
        }
    }

    /** @unsupported @internal
     * Copies the instance variables
     */
    public function _copy($obj){
        $this->_createdDate = $obj->_createdDate;
        $this->_updatedDate = $obj->_updatedDate;
        $this->_name = $obj->_name;
        $this->_description = $obj->_description;
        $this->_relativeUrl = $obj->_relativeUrl;
        $this->_publishedState = $obj->_publishedState;
        $this->_ownerName = $obj->_ownerName;
        $this->_iconUrl = $obj->_iconUrl;
        $this->_premiumServices = $obj->_premiumServices;
        $this->_tags = $obj->_tags;
        $this->_categories = $obj->_categories;
        $this->_domains = $obj->_domains;
        $this->_cdnpolicy = $obj->_cdnpolicy;
        $this->_mappings = $obj->_mappings;
        $this->_boost = $obj->_boost;
        $this->_codeVersion = $obj->_codeVersion;
        $this->_isLaunched = $obj->_isLaunched;
        $this->_locale = $obj->_locale;
        $this->_timezoneOffset = $obj->_timezoneOffset;
        $this->_useDST = $obj->_useDST;
       // $this->_videoEncodingProfile = $obj->videoEncodingProfile;
        $this->_tagline = $obj->_tagline;
		$this->_tag = $obj->_tag;
        $this->_isPublic = $obj->_isPublic;
        $this->_invitationOnly = $obj->_invitationOnly;
        $this->_allowInvitationRequests = $obj->_allowInvitationRequests;
         $this->_remainnumberofsmss  = $obj->_remainnumberofsmss;
		 $this->_numberofsmss = $obj->_numberofsmss;
		 $this->_numberofusers = $obj->_numberofusers;
		 $this->_remainstoragespace = $obj->_remainstoragespace;
		 $this->_storagespace = $obj->_storagespace;
		 $this->_province = $obj->_province;
		 $this->_city = $obj->_city;
		 $this->_point = $obj->_point;
		 $this->_active = $obj->_active;
		 $this->_trialtime = $obj->_trialtime;
		 $this->_link = $obj->_link;
    }
    
    /** @unsupported @internal */
     public function _fromAtomEntry(XN_XPathHelper $x, DomNode $node) {
         $this->_createdDate = $x->textContent('atom:published', $node);
         $this->_updatedDate = $x->textContent('atom:updated', $node);
         $this->_name = $x->textContent('atom:id', $node);
         $this->_description = $x->textContent('atom:title', $node, true);
         $this->_relativeUrl = $x->textContent('atom:id', $node);
         $this->_remainnumberofsmss  = $x->textContent('xn:remainnumberofsmss', $node);
		 $this->_numberofsmss = $x->textContent('xn:numberofsmss', $node);
		 $this->_numberofusers = $x->textContent('xn:numberofusers', $node);
		 $this->_remainstoragespace = $x->textContent('xn:remainstoragespace', $node);
		 $this->_storagespace = $x->textContent('xn:storagespace', $node);
		 $this->_province = $x->textContent('xn:province', $node);
		 $this->_city = $x->textContent('xn:city', $node);
		 $this->_point = $x->textContent('xn:point', $node);
		 $this->_active = $x->textContent('xn:active', $node);
		 $this->_trialtime = $x->textContent('xn:trialtime', $node);
		 $this->_link = $x->textContent('xn:link', $node);
         $this->_publishedState = ($x->textContent('xn:active',$node) == 'true') ? 'Y' : 'N';
         $this->_ownerName = $x->textContent('atom:author/atom:name',$node, true);
         foreach ($x->query('atom:link',$node) as $link) {
            $rel = XN_XPathHelper::attribute($link, 'rel');
            if ($rel == 'icon') {
                $this->_iconUrl = XN_XPathHelper::attribute($link,'href');
            }
         }
         foreach ($x->query('xn:premium-service', $node) as $svc) {
             $type = XN_XPathHelper::attribute($svc, 'type');
             if (mb_strlen($type)) {
                 $this->_premiumServices[$type] = true;
             }
         }
         foreach ($x->query('xn:tag', $node) as $tag) {
             $this->_tags[] = $tag->textContent;
         }
         foreach ($x->query('atom:category', $node) as $category) {
             $term = XN_XPathHelper::attribute($category, 'term');
             $label = XN_XPathHelper::attribute($category, 'label');
             $this->_categories[$term] = $label;
         }
         foreach ($x->query('xn:domain',$node) as $domain) {
             $this->_domains[] = $domain->textContent;
         }
         $cdnpolicy = array();
         $policy_json = $x->textContent('xn:cdnpolicy',$node, true);
         $policy_array = json_decode($policy_json, true);
         if (is_array($policy_array)) {
             // Remove version number
             unset($policy_array['v']);
             $this->_cdnpolicy = $policy_array;
         }

	 $propValue = $x->textContent('xn:boost', $node, true);
	 if (! is_null($propValue)) {
	    $this->_boost = floatval($propValue);
	 }
         $this->_codeVersion = $x->textContent('xn:codeVersion', $node, true);
         $this->_locale = $x->textContent('xn:locale', $node, true);
         $this->_timezoneOffset = $x->textContent('xn:timezoneOffset', $node, true);
         $this->_videoEncodingProfile = $x->textContent('xn:videoEncodingProfile', $node, true);
         $this->_tagline = $x->textContent('xn:tagline', $node, true);

         foreach (array('isLaunched', 'useDST', 'isPublic', 'invitationOnly', 'allowInvitationRequests') as $prop) {
			$propValue = $x->textContent("xn:$prop", $node, true);
			if (! is_null($propValue)) {
			         $this->{"_$prop"} = $propValue == "true";
			}
		}
         return $this;
     }

	 /** @unsupported @internal */
	 private function _toAtomEntry($put=false) {
			if ($put)
			{
				$xml = XN_REST::xmlsprintf(trim('<entry xmlns="http://www.w3.org/2005/Atom" xmlns:xn="http://www.ning.com/atom/1.0">
			  <id>%s</id> 
	  		  <xn:id>%s</xn:id> 
			  <xn:application>%s</xn:application> 	  		  
			  <author>
			    <name>%s</name>
			  </author> 
			  <title>%s</title>  
			  <xn:description>%s</xn:description> 
			  '), $this->_name,$this->_name,$this->_name,$this->_ownerName,$this->_description,$this->_description);
			}
			else
			{
				$xml = XN_REST::xmlsprintf(trim('<entry xmlns="http://www.w3.org/2005/Atom" xmlns:xn="http://www.ning.com/atom/1.0">
				  <id>%s</id> 
		  		  <xn:id>%s</xn:id> 	
		  		  <xn:application>%s</xn:application> 			
				  <author>
				    <name>%s</name>
				  </author> 
				  <title>%s</title>  
				   <xn:description>%s</xn:description> 
				  <xn:remainnumberofsmss>0</xn:remainnumberofsmss> 
				  <xn:numberofsmss>0</xn:numberofsmss> 
				  <xn:numberofusers>10</xn:numberofusers> 
				  <xn:remainstoragespace>500</xn:remainstoragespace> 
				  <xn:province>湖南省</xn:province> 
				  <xn:city>长沙市</xn:city> 
				  <xn:storagespace>500</xn:storagespace> 
				  <xn:trialtime>'.date( "Y-m-d 00:00:00",time()+24*60*60*30).'</xn:trialtime> 
				  <xn:point>0</xn:point> 
				  <xn:link>http://api.361crm.com/files/system/application.jpg</xn:link> 
				  <xn:active>true</xn:active> 
				   
				  '), $this->_name,$this->_name,$this->_name,XN_Profile::current()->screenName,$this->_description,$this->_description);
			}
		                
       		foreach (array('remainnumberofsmss','numberofsmss','numberofusers','remainstoragespace','storagespace','trialtime','point','province','city','link','active') as $prop) {
	                    $p = $this->{"_$prop"};
	                    if (! is_null($p)) {
	                        $xml .= XN_REST::xmlsprintf("    <xn:$prop>%s</xn:$prop>\n", $p);
	                    }
			}
			$xml .= '</entry>';      
       return $xml;
   }


     /** @unsupported @internal */
     public static function _getAppDirectoryHash($appUrl) {
        $str = strtolower($appUrl);
	if (isset($_SERVER['XNPG']) && ($_SERVER['XNPG'] == 'appfs')) {
	  return $str;
	}
        $h = 5381;
        for ($i = 0, $j = strlen($str); $i < $j; $i++) {
            /* Make sure it's not negative */
            $h &= 0xFFFFFFF;
            $h += ($h << 5) + ord($str[$i]);
        }
        $h = $h & 0xFFFFFFF;
        return sprintf("%X/%03X/%03X/%s", ($h >> 24) & 0xF, ($h >> 12) & 0xFFF, $h & 0xFFF, $str);
     }

     /** @unsupported @internal */
     private function _loadMappings() {
         $url = XN_AtomHelper::APP_REST_PREFIX('1.0') . '/application/mapping';
         $xml = XN_REST::get($url);
         $mappings = array();
         /* Only attempt to parse the response if there is one (NING-9568) */
         if (strlen(trim($xml))) {
             $sxml = @simplexml_load_string($xml);
             if ($sxml === false) {
                 throw new XN_Exception("Can't load mappings: $xml is not valid XML");
             }
             foreach ($sxml->mapping as $mapping) {
                 $mappings[(string) $mapping->pattern] = (string) $mapping->target;
             }
         }
         $this->_mappings = $mappings;
     }
     
     /** @unsupported @internal */
     private function _saveMappings() {
         if (! is_array($this->_mappings)) {
             return;
         }
         $xml = "<"."?xml version='1.0' encoding='UTF-8'?"."><mappings>";
         foreach ($this->_mappings as $pattern => $target) {
             $xml .= XN_REST::xmlsprintf("<mapping><pattern>%s</pattern><target>%s</target></mapping>", $pattern, $target);
         }
         $xml .= '</mappings>';
         $url = XN_AtomHelper::APP_REST_PREFIX('1.0') . '/application/mapping';
         XN_REST::put($url, $xml);

     }

     protected function _clearMappings() {
         $this->_mappings = null;
     }

     protected static function loadMany($relativeUrls) {
	if ($_SERVER['XN_Application_use_proc_endpoint'] == 1) {
	    $result = array();
	    $toSend = array();

	    /* first see if the XN_Cache has the application info already.  Only send to core for the missing ones */
            foreach ($relativeUrls as $relativeUrl) {
                $cachedApp = XN_Cache::_get($relativeUrl, 'XN_Application');
                if (is_null($cachedApp)) {
                    $toSend[] = $relativeUrl;
                }
                else {
                    $result[] = $cachedApp;
                }
            }

	    if (count($toSend)) {
                $url = XN_AtomHelper::APP_REST_PREFIX('1.0').'/application('.rawurlencode("subdomain in ['" . implode("','", $toSend) . "']") . ')';
                try {
                    $xml = XN_REST::get($url, array(XN_REST::USE_SERVICE_LOCATION => 'provisioning'));
                    $apps = XN_AtomHelper::loadFromAtomFeed($xml, 'XN_Application', false, true);
                    $result = array_merge($result, $apps);
                } catch (XN_Exception $e) {
                    if ($e->getCode() != 404) {
                        throw $e;
                    }
                }
            }
	    return $result;
        }
        else {
            throw new XN_UnsupportedOperationException("LoadMany is not supported on appc Application end point");
        }
     }
}

} // class_exists()


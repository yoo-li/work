<?php
/** Defines the XN Backup PHP API.
 * 
 * @file
 * @ingroup XN
 */

/* $Revision: 49399 $ */

/** @cond */
if (! class_exists('XN_Backup')) {
/** @endcond */

/** An XN_Backup object represents a user and its system information.
 *
 * A XN_Backup object is composed of properties, whose names are identified by
 * constants, that are accessed as simulated instance variables through the
 * '->' operator using the magic __get method.
 *
 * @ingroup XN
 */
class XN_Backup {
   


    //-------------------------------------------------------------------------
    // PUBLIC CONSTANTS: PROPERTIES
    //-------------------------------------------------------------------------
    /**
     * Read-only <i>string</i> intrinsic property: the screen name.
     */
    const screenName = 'screenName';
    /**
     * Read-only <i>string</i> intrinsic property: the full name
     */
    const fullName = 'fullName';
    /**
     * Read-only <i>string</i> intrinsinc property: the content upload e-mail address
     */
    const uploadEmailAddress = 'uploadEmailAddress';

    //-------------------------------------------------------------------------
    // PRIVATE VARIABLES
    //-------------------------------------------------------------------------

    protected $_data =
      array( 
        'id' => null,
        'path' => null,
        'status' => null,
		'style' => null,
		'application' => null,
		'type' => null,
        'published' => null,
	    );
    
	 private $_lazyLoaded = array();

    /* Some properties are not settable */
    private $_notSettable = array( 'path', 'published');

    /* Different behavior on save when various elements are changed */
    private $_changed = array();

    //------------------------------------------------------------------------
    // DEBUG METHODS
    //------------------------------------------------------------------------

    /**
     * Returns a string debug representation of the XN_Backup object.
     * @return string
     */
    public function debugString() {
        $str =  "XN_Backup:\n";
	foreach (array_keys($this->_data) as $property) {
	  /* The accessor is used here to trigger any necessary lazy-loading */
	  $str .= "  $property [" . $this->$property."]\n";
	}
        return $str;
    }

    /**
     * Returns a string debug representation of this XN_Backup object within
     * an HTML pre tag.
     * @return string
     */
    public function debugHtml() {
        return '<pre>' . xnhtmlentities($this->debugString()) . '</pre>';
    }

    //------------------------------------------------------------------------
    // PROPERTY ACCESSOR
    //------------------------------------------------------------------------
    /** @unsupported @internal */
    function _getId(){
        return $this->_data['id'];
    }
    /**
     * Provides read access to the property of the given name simulated as a
     * public instance variable accessed through the '->' operator.
     *
     * @param $name string property name
     * @return mixed
     */
    public function __get($name) {
	/* Is it a valid property name? */
	if (array_key_exists($name, $this->_data)) {
	    /* Does it need to be lazy-loaded? */
	    if (isset($this->_lazyLoaded[$name]) && ($this->_lazyLoaded[$name] === false)) {
		$this->_lazyLoad($name);
	    }
	    return $this->_data[$name];
	}
	else {
	    throw new XN_Exception("Invalid property name: '$name'");
	}
    }

    /**
     * Provides write access to properties of the profile
     *
     * @param $name string property name
     * @param $value mixed property value
     */
    public function __set($name, $value) {
	/* Is it a valid property name? */
	if (array_key_exists($name, $this->_data) && (! in_array($name, $this->_notSettable))) {
	    $this->_data[$name] = $value;
	    $this->_changed[$name] = true;
	    if ($name == 'birthdate') {
		$this->_setAgeFromBirthdate();
	    }
	}
	else if ($name == 'thumbnailUrl') {
	    $this->_thumbnailUrlUpload = $value;
	}
	else {
	    throw new XN_Exception("Invalid property name: '$name'");
	}
    }
    
 /** Static method that restore  XN_Backup
     */
    public static function restore($id) {	
        $entry = '<?xml version="1.0" encoding="UTF-8"?><feed xmlns="http://www.w3.org/2005/Atom" xmlns:xn="http://localhost/atom/1.0"></feed>';
	    $url = XN_AtomHelper::APP_REST_PREFIX().'/backup(id='.$id.')?xn_out=xml';
            try {
                $rsp = XN_REST::put($url, $entry);
            } catch (Exception $e) {
                return XN_REST::parseErrorsFromException($e);
            }
    }
    
 /**
     * Delete the specified backup.
     *     
     */
    public static function delete($id) {
        try {
            $url = XN_AtomHelper::APP_REST_PREFIX().'/backup(id='.$id.')?xn_out=xml';
		    XN_REST::delete($url);
            return true;
        } catch (Exception $e) {
            return XN_REST::parseErrorsFromException($e);
        }
    }
    
/** Static method that restore  XN_Backup
     */
    public static function load($id) {	
        $url = XN_AtomHelper::APP_REST_PREFIX().'/backup(id='.$id.')?xn_out=xml';
		$xml = XN_REST::get($url);
		$backup = XN_AtomHelper::loadFromAtomFeed($xml, 'XN_Backup', true, true);
		return $backup;
    }

   
    /** Static method that loads and returns an array of XN_Backup
     * objects for the given array of screen names or email addresses
     *
     * @param $screenNames array
     * @return array
     */
    public static function loadMany() {
		$url = XN_AtomHelper::APP_REST_PREFIX().'/backup?xn_out=xml';
		$xml = XN_REST::get($url);
		$backups = XN_AtomHelper::loadFromAtomFeed($xml, 'XN_Backup', false, true, '2.0');
		return $backups;
    }

    /**
     * Create a new profile object. At a minimum, email address and password must
     * be provided
     *
     * @param $email string The user's email address
     * @param $password string The user's desired password
     * @return XN_Backup
     */
    public static function create() {
		$backup = new XN_Backup();
		return $backup;
    }

    /**
     * Save a profile object. Perhaps this creates a new profile if the object
     * has not yet been saved.
     *
     * @param $auth XN_Auth_Captcha optional Authentication for creating a new user
     * @return boolean|array Returns true if save succeeded, otherwise an array of
     *   error messages
     */
    public function save() {
	 $entry = '<?xml version="1.0" encoding="UTF-8"?>
<feed xmlns="http://www.w3.org/2005/Atom" xmlns:xn="http://localhost/atom/1.0">'.$this->_toAtomEntry().'</feed>';
     
	
	$headers = array();
	$url = XN_AtomHelper::APP_REST_PREFIX() . "/backup?xn_out=xml";
	try {
	$rsp = XN_REST::post($url, $entry, 'text/xml', $headers);
	} catch (Exception $e) {
			return XN_REST::parseErrorsFromException($e);
		}
	/* Load any changed or new values from the response into this profile */
	$d = new DomDocument();
	$d->loadXML($rsp);
	$x = XN_AtomHelper::XPath($d);
	$node = $x->query('/atom:feed/atom:entry')->item(0);
	if ($node == null) {
		 $errormsg = $d->getElementsByTagName("error")->item(0)->nodeValue;		
	     throw new XN_Exception($errormsg); 
	} 
	$this->_fromAtomEntry($x, $node);

	return $this;
    }

    
  

    //------------------------------------------------------------------------
    // PRIVATE METHODS
    //------------------------------------------------------------------------
    private function __construct() { }  

    /** @unsupported @internal */
    public static function _createEmpty() {
        return new XN_Backup();
    }
    /** @unsupported @internal
     * Copies the instance variables
     */
    public function _copy($obj){
	$this->_data = $obj->_data;
    }

	 /**
     * Lazy-loads the specified property
     *
     * @param $prop string The property to load
     */
    private function _lazyLoad($prop) {
         // Complain if it's a bad property name
         if (! isset($this->_lazyLoaded[$prop])) {
             throw new XN_IllegalArgumentException("Unknown property: $prop");
         }
         // Don't do anything if the property has already been loaded
         if ($this->_lazyLoaded[$prop]) {
             return;
         }         
    }
    
 /** @unsupported @internal */
    public function _fromAtomEntry(XN_XPathHelper $x, DomNode $node) {
        $this->_data['id'] = $x->textContent('xn:id', $node);  
        $this->_data['published'] = $x->textContent('atom:published', $node);        
		foreach (array( 'path','status','appliction','type','style') as $prop) {
		    $this->_data[$prop] = $x->textContent("xn:$prop", $node, true);
		}
        return $this;
    }
    
    

	protected function _toAtomEntry() {
	$xml = XN_REST::xmlsprintf(
'<entry xmlns="%s" xmlns:xn="%s" xmlns:email="%s">
  <id></id>
  <title type="text">backup</title>
  <summary type="text">backup</summary>
',
XN_AtomHelper::NS_ATOM, XN_AtomHelper::NS_XN, XN_AtomHelper::NS_EMAIL);
	
	foreach (array( 'path','status') as $prop) {
	    if (mb_strlen($this->$prop)) {
		$xml .= XN_REST::xmlsprintf("  <xn:$prop>%s</xn:$prop>\n", $this->$prop);
	    }
	}

	$xml .= '</entry>';

	return $xml;
    }
 
    
}

} // class_exists()

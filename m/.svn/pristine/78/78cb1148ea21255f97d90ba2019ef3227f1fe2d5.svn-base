<?php
/** Defines the XN Profile PHP API.
 * 
 * @file
 * @ingroup XN
 */

/* $Revision: 49399 $ */

/** @cond */
if (! class_exists('XN_Profile')) {
/** @endcond */

/** An XN_Profile object represents a user and its system information.
 *
 * A XN_Profile object is composed of properties, whose names are identified by
 * constants, that are accessed as simulated instance variables through the
 * '->' operator using the magic __get method.
 *
 * @ingroup XN
 */
class XN_Profile {
    /** @unsupported @internal */
    public static $VIEWER;
    /** @unsupported @internal */
    public static $PROBABLE_VIEWER;
    /** @unsupported @internal */
    public static $LOGIN_VERIFIED;
    /** @unsupported @internal */
    private static $_currentProfile = null;


    /**
     * This can be passed to XN_Profile::thumbnailUrl() as a dimension to
     * preserve aspect ratio. (NING-3312)
     */
    const PRESERVE_ASPECT_RATIO = 'preserve-aspect-ratio';

    /**
     * Possible values for presence attribute
     */
    const ONLINE = 'online';

    /**
     * Possible return value for "loginIsVerified"
     * Indicates profile has not been verified and no other network has
     * requested it be verified.
     */
    const NOT_VERIFIED = 'not-verified';

    /**
     * Possible return value for "loginIsVerified"
     * Indicates profile has been verified and may be trusted.
     */
    const IS_VERIFIED = 'is-verified';

    /**
     * Possible return value for "loginIsVerified"
     * Indicates profile has not been verified, but some other network has
     * requested it be treated with particular concern.
     */
    const SHOULD_VERIFY = 'should-verify';

    /**
     * Constants for friend status and contact operations (NING-6978)
     */
    const FRIEND = 'friend';
    const BLOCK = 'block';
    const NOT_FRIEND = 'not-friend';
    const BLOCKED = 'blocked';
    const GROUPIE = 'groupie';
    const FRIEND_PENDING = 'pending';
    const EMAIL_VALID = 'valid';
    const EMAIL_INVALID = 'invalid';
    const EMAIL_UNVERIFIED = 'unverified';


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
      array('screenName' => null,
	    'profileid' => null,
	    'identifier' => null,
	    'fullName' => null,
        'application' => null,
        'type' => null,
		'online' => null,
		'friends' => null,
	    'uploadEmailAddress' => null,
	    'description' => null,
        'status' => null,
        'mobile' => null,
	    'gender' => null,
	    'age' => null,
	    'location' => null,
	    'country' => null,
	    'zipcode' => null,
	    'presence' => null,
	    'birthdate' => null,
		'givenname' => null,
		'qq' => null,
		'msn' => null,
		'link' => null,
	    'email' => null,
	    'password' => null,
	    'emailverified' => null,
		'mobileverified' => null,
		'address' => null,
		'province' => null,
		'city' => null,
		'cityarea' => null,
		'companyname' => null,
		'realname' => null,
		'popularize' => null,
		'sourcer' => null,
		'system' => null,
		'browser' => null,
		'signature' => null,
		
		'published' => null,
		'bank' => null,
		'bankname' => null,
		'bankaccount' => null,		
		'reg_ip' => null,
		'wxopenid' => null,	
		'sharefund' => null,	
		'unionid' => null,	
		'rank' => null,			
		'money' => null,
		'accumulatedmoney' => null,	
		'frozen_money' => null,
		'invitationcode' => null,
		'activationdate' => null,

		'identitycard' => null,
		'identitycardlink' => null,
		'businesscardlink' => null,
		'certificatelink' => null,
		'isaudit' => null,
	    'currentStatus' => null,
	    'currentStatusUpdated' => null,
	    'profileEnabled' => null,
	    'locale' => null,
	    'networkProfileVisibility' => null,
	    'allowNetworkInvitation' => null,
	    'allowGroupInvitation' => null,
	    'allowEventInvitation' => null,
	    'allowFriendRequest' => null,
	    'allowApplicationAlert' => null,
            'allowComment' => null,
	    );
    
    /* Stored separately since access is through a method that allows
     * for dimension setting */
    protected $_thumbnailUrl = null;
    protected $_thumbnailUrlUpload = null;
    protected $_isDefaultThumbnail = null;

    /*
     * Each property that can be lazy-loaded gets an entry in this array.
     * The key is the property name, the value is whether or not it has been
     * loaded yet. This array must also be copied in the _copy() method. Each
     * element starts out as false and is set to true in the _lazyLoad() method.
     */
    private $_lazyLoaded = array('uploadEmailAddress' => false);

    /* Some properties are not settable */
    private $_notSettable = array('screenName', 'uploadEmailAddress', 'presence');

    /* Different behavior on save when various elements are changed */
    private $_changed = array();

    //------------------------------------------------------------------------
    // DEBUG METHODS
    //------------------------------------------------------------------------

    /**
     * Returns a string debug representation of the XN_Profile object.
     * @return string
     */
    public function debugString() {
        $str =  "XN_Profile:\n";
	foreach (array_keys($this->_data) as $property) {
	  /* The accessor is used here to trigger any necessary lazy-loading */
	  $str .= "  $property [" . $this->$property."]\n";
	}
	$str .= "  thumbnailUrl [" . $this->thumbnailUrl() . "]\n";
	$str .= "  isDefaultThumbnail[" . $this->hasDefaultThumbnail() . "]\n";
        return $str;
    }

    /**
     * Returns a string debug representation of this XN_Profile object within
     * an HTML pre tag.
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

    //------------------------------------------------------------------------
    // STATIC METHODS
    //------------------------------------------------------------------------

    /**
     * Static method that loads and returns a {@link XN_Profile} object from
     * the database for the given screen name.
     *
     * Throws an {@link XN_Exception} if an error occurred.
     *
     * Example of retrieving the XN_Profile object for a screen name:
     * <code>
     * $profile = XN_Profile::load($screenName);
     * // $profile is a XN_Profile object
     * </code>
     *
     * @param $screenName string|array a string screen name or email address.
     * If omitted or null, the current profile is loaded. An array of all screen names or
     * all email addresses loads multiple profile objects.
     * @return XN_Profile|array
     * @see XN_Exception
     */
    public static function load($screenName=null,$keyname=null,$tag = null) {
        if (! isset($screenName)) {
            if (! isset(self::$VIEWER)) {
                return new XN_Profile();
            } else {
                $screenName = self::$VIEWER;
            }
        }
	if (is_array($screenName)) {
	    return self::loadMany($screenName,$keyname,$tag);
	} else {
	    $key = self::_idOrEmail($screenName);
	    if ( isset($keyname) && $key == 'id') 
	    {
	         $key = $keyname;
	    }
            try {
				 if ( $tag != null)
				 {
						 $headers = array('tag' => $tag);
						 $rsp = XN_REST::get(XN_REST::urlsprintf(XN_AtomHelper::APP_REST_PREFIX() . "/profile($key='%s')?xn_out=xml",XN_REST::singleQuote($screenName)),$headers); 
				 }
				 else
				 {
						  $rsp = XN_REST::get(XN_REST::urlsprintf(XN_AtomHelper::APP_REST_PREFIX() . "/profile($key='%s')?xn_out=xml",XN_REST::singleQuote($screenName))); 
				 }						 
				 
                $p = XN_AtomHelper::loadFromAtomFeed($rsp, 'XN_Profile', true, true); } catch (Exception $e) {
                if ($e->getCode() == 404) {
                    $p = null;
                }
            }
            if (is_null($p) && ($screenName == self::$VIEWER)) {
                throw new XN_Exception("Unable to load profile for current user ($screenName) key=$keyname");
	    }
            else if (!$p) {
                throw new XN_Exception("No profile found for user ($screenName) key=$keyname");
            }
	    return $p;
    	}
    }

    /** Static method that loads and returns an array of XN_Profile
     * objects for the given array of screen names or email addresses
     *
     * @param $screenNames array
     * @return array
     */
    public static function loadMany($screenNames,$keyname=null,$tag = null) {
	/* Make sure the list is all screenNames or all email addresses */
	$emails = 0;
	$screenNames = (array)$screenNames;
	foreach ($screenNames as $screenName) {
	    $emails += ((self::_idOrEmail($screenName) == 'email') ? 1 : 0);
        if(self::_idOrEmail($screenName) == 'email'){
        }
	}
	/* Are they all email addresses? */
	if ($emails == count($screenNames)) {
	    $key = 'email';
	    // NING-6576: single quotes in email addresses need to be escaped
	    foreach ($screenNames as $i => $sn) {
                $screenNames[$i] = XN_REST::singleQuote($sn);
	    }
	}
	/* Are they all screen names? */

	else if ($emails == 0) {
	    $key = 'id';
		if ( isset($keyname) ) 
	    {
	         $key = $keyname;
	    }
	}
	/* Uh-oh, it's a mix */
	else {
	    throw new XN_IllegalArgumentException("Can only load a list of screen names or a list of e-mail addresses");
	}

	$url = XN_AtomHelper::APP_REST_PREFIX().'/profile('.rawurlencode("$key in ['" . implode("','", $screenNames) . "']") . ')?xn_out=xml';
    if ( $tag != null)
	{
		 $headers = array('tag' => $tag);
		 $xml = XN_REST::get($url,$headers);
	}
	else
	{
		 $xml = XN_REST::get($url);
	}
	$profiles = XN_AtomHelper::loadFromAtomFeed($xml, 'XN_Profile', false, true, '2.0');
	return $profiles;
    }

    /**
     * Create a new profile object. At a minimum, email address and password must
     * be provided
     *
     * @param $email string The user's email address
     * @param $password string The user's desired password
     * @return XN_Profile
     */
    public static function create($email, $password) {
	$profile = new XN_Profile();
	$profile->email = $email;
	$profile->password = $password;
	return $profile;
    }

    /**
     * Save a profile object. Perhaps this creates a new profile if the object
     * has not yet been saved.
     *
     * @param $auth XN_Auth_Captcha optional Authentication for creating a new user
     * @return boolean|array Returns true if save succeeded, otherwise an array of
     *   error messages
     */
    public function save($tag = null,$auth = null) {
	//$entry = $this->_toAtomEntry();
	 $entry = '<?xml version="1.0" encoding="UTF-8"?>
<feed xmlns="http://www.w3.org/2005/Atom" xmlns:xn="http://localhost/atom/1.0">'.$this->_toAtomEntry().'</feed>';
     
	if (mb_strlen($this->screenName)) {
	    $url = XN_REST::urlsprintf(XN_AtomHelper::APP_REST_PREFIX() . "/profile(id='%s')?xn_out=xml", $this->screenName);
            try {
				    if ( $tag != null)
					{
						 $headers = array('tag' => $tag);
						 $rsp = XN_REST::put($url, $entry,'text/xml',$headers);
					}
					else
					{
						$rsp = XN_REST::put($url, $entry);
					}
            } catch (Exception $e) {
                return XN_REST::parseErrorsFromException($e);
            }
	}
	else {
	   // if ($auth instanceof XN_Auth_Captcha) {
		//$headers = $auth->getHeaders();
	   // } else {
		//throw new XN_Exception("No authentication provided to create a new profile");
	   // }
	    $headers = array();
	    $url = XN_AtomHelper::APP_REST_PREFIX() . "/profile?xn_out=xml";
	    try {
			if ( $tag != null)
			{
				$headers['tag'] = $tag;
			}
			$rsp = XN_REST::post($url, $entry, 'text/xml', $headers);

	    } catch (Exception $e) {
                return XN_REST::parseErrorsFromException($e);
            }
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

	return true;
    }

    /**
     * Sign in as a particular user. This method sets some cookies as part of the
     * response. Typically, the caller redirects the user somewhere after calling
     * this method. Note that the user isn't immediately signed in when this method
     * is called -- the next request made (with the set cookies) will be as the
     * signed-in user.
     *
     * @param $screenNameOrEmail string The user to sign in as
     * @param $password string The user's password
     * @param $options array optional array of options to pass:
     *               'max-age': how long the signed-in session should last, -1 for
     *                          browser session
     *               'set-cookies': whether to set the signin cookies automatically
     *                              in the response. Default is true
     *        If no options are specified, max-age is -1, and set-cookies is true
     */
    public static function signIn($screenNameOrEmail, $password, $options = array()) {
	if (! isset($options['max-age'])) {
	    $options['max-age'] = -1;
	}
	if (! isset($options['set-cookies'])) {
	    $options['set-cookies'] = true;
	}
	
	$key = self::_idOrEmail($screenNameOrEmail);
	if (isset($options['username']) && $options['username'] == true && $key == 'id') 
	{
	    $key = 'username';
	}
	$url = XN_REST::urlsprintf(XN_AtomHelper::APP_REST_PREFIX() . "/profile($key='%s')/signin?xn_out=xml&max-age=%d", XN_REST::singleQuote($screenNameOrEmail), $options['max-age']);
	$host = preg_replace('@:\d+$@','',XN_AtomHelper::HOST_APP(XN_Application::$CURRENT_URL));
	$headers = array('Authorization' => 'Basic ' . base64_encode($screenNameOrEmail.':' . $password),
			 'Host' => $host);
        try {
            $rsp = XN_REST::post($url, '', 'text/plain', $headers);
            if ($rsp != 'ok') throw new XN_Exception("INVALID_PASSWORD");
            if ($options['set-cookies']) {
                XN_REST::setLastResponseCookies();
            }
            return true;
        } catch (Exception $e) {
	     return false;
            //return XN_REST::parseErrorsFromException($e);
        }
    }
	
    /**
     * Sign out. This method sets some cookies as part of the response. Typically,
     * the caller redirects the user somewhere after calling this method. Note that
     * the user isn't immediately signed out when this method is called -- the next
     * request made (with the set cookies) will be as a signed-out user.
     *
     */
    public static function merge($profileid,$mergeprofileid) {
        try {
			$xml = '<?xml version="1.0" encoding="UTF-8"?><feed xmlns="http://www.w3.org/2005/Atom" xmlns:xn="http://localhost/atom/1.0">';
	 	    $xml .= '<profileid>'.$profileid.'</profileid>'; 
			$xml .= '<mergeprofileid>'.$mergeprofileid.'</mergeprofileid>'; 
			$xml .= '</feed>';
	        $rsp = XN_REST::post(XN_AtomHelper::APP_REST_PREFIX() . '/profile/merge?xn_out=xml',$xml,'text/plain',array('Host' => $_SERVER['HTTP_HOST'])); 
			if ($rsp != 'ok') throw new XN_Exception("merge failed.");
			return true;
        } catch (Exception $e) {
            return XN_REST::parseErrorsFromException($e);
        }
    }

    /**
     * Sign out. This method sets some cookies as part of the response. Typically,
     * the caller redirects the user somewhere after calling this method. Note that
     * the user isn't immediately signed out when this method is called -- the next
     * request made (with the set cookies) will be as a signed-out user.
     *
     */
    public static function signOut() {
        try {
	  XN_REST::post(XN_AtomHelper::APP_REST_PREFIX() . '/profile/signout?xn_out=xml','','text/plain',
			array('Host' => $_SERVER['HTTP_HOST']));
            XN_REST::setLastResponseCookies();
            return true;
        } catch (Exception $e) {
            return XN_REST::parseErrorsFromException($e);
        }
    }

    /**
     * Static method that allows sending a message to a screen name of a
     * registered user.
     *
     * Throws an {@link XN_Exception} if an error occurred.
     *
     * @param $destination string|XN_Profile - screenName or XN_Profile object
     * @param $subject string
     * @param $body string
     * @see XN_Exception
     */
    public static function sendMessage($destination, $subject, $body) {
        if ($destination instanceof XN_Profile) {
            $destination = $destination->screenName;
        }

        if (is_null($destination)) return;
        if (is_null($subject)) return;
        if (is_null($body)) return;

        $messageEntry = XN_Profile::_messageToAtom(array($destination => ''),
        $subject, $body, 'message');

        try {
            XN_REST::post('/message',$messageEntry);
        } catch (Exception $e) {
            throw XN_Exception::reformat("Failed to send message.", $e);
        }
    }

    /**
    * Static method that allows sending an invite message to screen names of
    * registered users and/or e-mail addresses.
    *
    * Throws an {@link XN_Exception} if an error occurred.
    *
    * @param $destination string|XN_Profile|array - a screen name, e-mail
    * address, XN_Profile object or array of the same.
    * @param $body string - the message body
    * @param $subject string optional the message subject
    * @param $url string optional the app url to be included in the invite message. Must
    * be a URL within the app. Is resolved relative to the current URL and host name. If
    * omitted, the current URL is used.
    */
    public static function tellAFriend($destination, $body, $subject = null, $url = null) {
        // Prepare message recipients
        $tos = array();
        if (is_string($destination)) {
            $tos[$destination] = '';
        } else if ($destination instanceof XN_Profile) {
            $tos[$destination->screenName] = '';
        } else if (is_array($destination)) {
            foreach ($destination as $dest) {
                if (is_string($dest)) {
                    $tos[$dest] = '';
                } else if ($dest instanceof XN_Profile) {
                    $tos[$dest->screenName] = '';
                }
            }
        } else {
            throw new XN_Exception("Failed to send tell-a-friend message: missing destination");
        }

        // Resolve relative url
        if (strlen($url) == 0) {
            $url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        } else if (substr($url,0,1) == '/') {
            $url = 'http://' . $_SERVER['HTTP_HOST'] . $url;
        } else if (strncasecmp('http://',$url,7) != 0) {
            $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_FILENAME']) . '/' .$url;
        }

        $messageEntry = XN_Profile::_messageToAtom($tos, $subject, $body, 'invitation', $url);

        try {
            XN_REST::post('/message',$messageEntry);
        } catch (Exception $e) {
            throw XN_Exception::reformat("Failed to send tell-a-friend message.",$e);
        }
    }

    /**
     * Static method to cause a reset password message to be sent to the
     * user with the specified email address (if such a user exists)
     *
     * @param $emailOrScreenName string The email address or screen name (Screen name
     *   is only allowed when specifying a template and callback URL)
     * @param $messageSubject string The subject of the message to send to the user
     * @param $messageTemplate string The message to send to the user. The string
     *  #{URL} in the message will be replaced with the URL the user should visit
     *  to reset their password
     * @param $callbackUrl string Where the user should end up in the app after
     *  following the URL in the message that is sent to them
     * @return true|array API v3: returns array of error messages or true on success
     * @throws XN_Exception API v2: if the user does not exist or
     *    there is a problem resetting the password
     */
    public static function resetPassword($emailOrScreenName, $messageSubject = null, $messageTemplate = null, $callbackUrl = null) {

        /* If subject, template, and callback are null, this is an old-style password reset
         * request, so we substitute a default subject, template, and callback, and use a
         * different endpoint */
	if (is_null($messageSubject) && is_null($messageTemplate) && is_null($callbackUrl)) {
            $messageSubject = "Ning ID Password";
            $messageTemplate = "We received a request to change the password for your Ning ID. Click the link below to set a new password:

        #{URL}

        If you don't want to change your password, you can ignore this email.

        ****
        You are receiving this email because you reset your password. You can contact us with any questions or concerns regarding your privacy at http://help.ning.com";
            $host = 'http://' . XN_AtomHelper::HOST_APP('www');
            $callbackUrl = $host . '/main/profile/resetPassword';
	    $key = self::_idOrEmail($emailOrScreenName);
	    $url = XN_REST::urlsprintf($host . XN_AtomHelper::APP_REST_PREFIX() .
                                       "/profile($key='%s')/forgot-password",
				       $emailOrScreenName);
            $useOldReturnStyle = true;

        }
        else {
	    $key = self::_idOrEmail($emailOrScreenName);
	    $url = XN_REST::urlsprintf(XN_AtomHelper::APP_REST_PREFIX() .
                                       "/profile($key='%s')/forgot-password",
				       $emailOrScreenName);
            $useOldReturnStyle = false;
        }

        $entry = XN_REST::xmlsprintf(
'<entry xmlns="%s">
  <title type="text">%s</title>
  <content type="text">%s</content>
  <link rel="target" href="%s" />
</entry>', XN_AtomHelper::NS_ATOM, $messageSubject, $messageTemplate, $callbackUrl);
        try {
            XN_REST::post($url, $entry, 'application/atom+xml', array('Host' => $_SERVER['HTTP_HOST']));
            return $useOldReturnStyle ? null : true;
        } catch (Exception $e) {
            if ($useOldReturnStyle) {
                throw new XN_Exception("Couldn't reset password for $emailOrScreenName");
            }
            else {
                return XN_REST::parseErrorsFromException($e);
            }
        }
    }

    /**
     * Static method to grant a role to a user.
     *
     * Throws an {@link XN_Exception} if an error occurred.
     *
     * @param $screenName string|XN_Profile screenName or XN_Profile object
     * @param $roleCode string
     * @see XN_Exception
     */
    public static function grantRole($screenName, $roleCode) {
        if ($screenName instanceof XN_Profile) {
            $screenName = $screenName->screenName;
        }
        if (is_null($screenName)) return;
        if (is_null($roleCode)) return;


        try {
            XN_REST::post(XN_REST::urlsprintf("/profile(id='%s')/role", $screenName),
                          XN_Profile::_roleToAtom($roleCode));
        } catch (Exception $e) {
            throw XN_Exception::reformat("Failed grant role.", $e);
        }
    }

    /**
     * Static method for dropping a role from a user.
     *
     * Throws an {@link XN_Exception} if an error occurred.
     *
     * @param $screenName string|XN_Profile screenName or XN_Profile object
     * @param $roleCode string
     * @see XN_Exception
     */
    public static function dropRole($screenName, $roleCode) {
        if ($screenName instanceof XN_Profile) {
            $screenName = $screenName->screenName;
        }
        if (is_null($screenName)) return;
        if (is_null($roleCode)) return;

        try {
            XN_REST::delete(XN_REST::urlsprintf("/profile(id='%s')/role(id='%s')",$screenName, $roleCode));
        } catch (Exception $e) {
            throw XN_Exception::reformat("Failed to drop role.", $e);
        }
    }

    /**
     * Static method for listing the roles granted to a user.
     *
     * Throws an {@link XN_Exception} if an error occurred.
     *
     * @param $screenName string|XN_Profile screenName or XN_Profile object
     * @return array an array of roles granted to the user
     * @see XN_Exception
     */
    public static function listRoles($screenName) {
        if ($screenName instanceof XN_Profile) {
            $screenName = $screenName->screenName;
        }
        if (is_null($screenName)) return;

        try {
            $roles = array();
            $rsp = XN_REST::get(XN_REST::urlsprintf("/profile(id='%s')/role", $screenName));
            $x = XN_AtomHelper::XPath($rsp);
            foreach ($x->query('/atom:feed/xn:role') as $role) {
                $roles[] = XN_XPathHelper::attribute($role,'name');
            }
        } catch (Exception $e) {
            throw XN_Exception::reformat("Failed to list roles.",$e);
        }
        return $roles;
    }

    /**
     * Static method for listing profiles which have been granted
     * a specific role.
     *
     * Throws an {@link XN_Exception} if an error occurs
     *
     * @param $roleName string which is the name of the role
     * @return array an array of the screenNames for Profiles which have
     *               been granted the specified role
     */
    public static function listProfilesInRole($roleName) {
        if (is_null($roleName)) return;
         try {
            $screenNames = array();
            $rsp = XN_REST::get(XN_REST::urlsprintf("/role(id='%s')/profile", $roleName));
            $x = XN_AtomHelper::XPath($rsp);
            foreach ($x->query('/atom:feed/atom:entry/atom:id') as $screenName) {
                $screenNames[] = $screenName->textContent;
            }
        } catch (Exception $e) {
            throw XN_Exception::reformat("Failed to list profiles for role.", $e);
        }
        return $screenNames;
    }

    /**
     * Static method for verifying that a user has been granted a given role.
     * Returns true if the role has been granted, false if it hasn't.
     *
     * Throws an {@link XN_Exception} if an error occurred.
     *
     * @param $screenName string|XN_Profile screenName or XN_Profile object
     * @param $roleCode string
     * @return boolean true boolean if the role is granted, false otherwise
     * @see XN_Exception
     */
    public static function verifyRole($screenName, $roleCode) {
        if ($screenName instanceof XN_Profile) {
            $screenName = $screenName->screenName;
        }
        if (is_null($screenName)) return;
        if (is_null($roleCode)) return;

        // Pass on exceptions
        return in_array($screenName,self::listProfilesInRole($roleCode));
    }

    /**
     * Static method for returning the profile of the currently logged in user,
     * or an empty profile object if there is no currently logged in user.
     * @return XN_Profile
     *
     */
    public static function current() {
        if (is_null(self::$_currentProfile)) {
            if (isset(self::$VIEWER)) {
                self::$_currentProfile = XN_Profile::load(self::$VIEWER);
            } else {
                self::$_currentProfile = new XN_Profile();
            }
        }
        return self::$_currentProfile;
    }

    /**
     * Static method for returning the profile of the currently logged in user,
     * or an empty profile object if there is no currently logged in user.
     * @return XN_Profile
     *
     */
    public static function probableScreenName() {
        return self::$PROBABLE_VIEWER;
    }

    /**
     * Indicates whether the profile object is the profile of the currently
     * logged in user.
     *
     * @return boolean
     */
    public function isLoggedIn() {
        return ((! is_null($this->screenName)) &&
                ($this->screenName == self::$VIEWER));
    }

    /**
     * Indicates whether the profile object is both logged in and "verified".
     * The precise meaning of verified may change, but it implies that the
     * user should be allowed to perform spectacularly destructive acts.
     *
     * @deprecated
     * @return boolean
     */
    public function loginIsVerified() {
        return self::IS_VERIFIED;
    }

    /**
     * Constructs a url which, when visited, will verify the current user
     * and send them to the target url
     *
     * @deprecated
     * @param $targetUrl const|string url to send the user after verification
     * @return the url for verifying the current user
     */
    public static function verificationUrl($targetUrl) {
        $verificationUrl = 'https://www'.XN_AtomHelper::$DOMAIN_SUFFIX
            .(XN_AtomHelper::$EXTERNAL_SSL_PORT == 443 ? '' : ':'.XN_AtomHelper::$EXTERNAL_SSL_PORT)
            .'/home/profile/enterPin?target='
            .rawurlencode($targetUrl);

        if (XN_Profile::current()->isLoggedIn()) {
            $verificationUrl .= '&id=' . XN_Profile::current()->screenName;
        }

        return $verificationUrl;
    }
    
    /**
     * Indicates whether the profile object is the profile of the owner of 
     * the currently-running application.
     *
     * @return boolean
     */
    public function isOwner() {
        return ((! is_null($this->screenName)) &&
                (strtolower($this->screenName) == 
                 strtolower(XN_Application::load()->ownerName)));
    }
    
    /**
    * Method that retrieves the URL for the profile's thumbnail picture. 
    *
    * If called with no arguments, the URL returned will be for an image
    * with the default dimensions (64 x 64)
    *
    * If called with one integer argument, that argument will be the largest
    * dimension, and the other dimension will be scaled appropriately to 
    * preserve aspect ratio. For example, on an image of width 50 and height 100,
    * thumbnailUrl(10) will produce a URL to an image that is 5px wide and 10px high.
    * (NING-3312)
    *
    * If called with two integer arguments, those arguments will be used as the
    * image dimensions. For example, on an image of width 50 and height 100,
    * thumbnailUrl(43,582) will produce a URL to an image that is 43 px wide and
    * 582 px high.
    *
    * When called with two arguments, one of the arguments, instead of an integer,
    * can be the constant XN_Profile::PRESERVE_ASPECT_RATIO, which will cause that
    * dimension to be whatever preserves the aspect ratio. For example, on an image
    * of width 50 and height 100, thumbnailUrl(25, XN_Profile::PRESERVE_ASPECT_RATIO)
    * will produce a URL to an image that is 25px wide and 50px high. On the same
    * image, thumbnailUrl(XN_Profile::PRESERVE_ASPECT_RATIO, 200) will produce a URL
    * to an image that is 100px wide and 200px high. (NING-3312)
    *
    * @param $width const|integer optional thumbnail width (defaults to 64) in pixels
    * @param $height const|integer optional thumbnail height (defaults to 64) in pixels
    */
    public function thumbnailUrl($width = null, $height = null) {
	if (mb_strlen($this->_thumbnailUrl) == 0) {
	    return '';
	}
        $url = $this->_thumbnailUrl;
	
        $url .= (strstr($this->_thumbnailUrl,'?') === false) ? '?' : '&';
        
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
            throw new XN_IllegalArgumentException("Invalid arguments to thumbnailUrl($width,$height)");
        }
        $url .= http_build_query($vars);
        return $url;
    }

    /**
     * determines whether the XN_Profile has the default Ning.com 'gray man' profile based on 
     * whether the request for the thumbnail without the 'default' param returns a 404
     *
     * @param boolean  whether the thumbnail is the default or not
     */
    public function hasDefaultThumbnail() {
        /* No thumbnail URL set, can't be a custom avatar */
        if (mb_strlen($this->_thumbnailUrl) == 0) {
            return true;
        }
	return $this->_isDefaultThumbnail;
    }

    /**
     * Set the profile thumbnail image to the data uploaded in the given
     * form field. This method is for environments (such as Pretzel) in
     * which uploaded files are passed unmodified to the app. In environments
     * (such as Bazel) where uploaded files are filtered by the upstream proxy,
     * just set $this->thumbnailUrl to the appropriate $_POST value.
     *
     * @param $formField string name of the file upload form field that
     *        provides the uploaded image
     * @throws XN_Exception if form field does not contain a valid
     *         uploaded file or upload fails
     * @return true if upload succeeds
     */
    public function setThumbnailFromUpload($formField) {
        if (isset($_FILES[$formField]) && is_array($_FILES[$formField]) &&
            ($_FILES[$formField]['error'] == UPLOAD_ERR_OK)) {
            $data = @file_get_contents($_FILES[$formField]['tmp_name']);
            if ($data === false) {
                throw new XN_IllegalArgumentException("Can't read uploaded file {$_FILES[$formField]['tmp_name']}");
            }
            /* Use user-provided type if available, otherwise use an
             * image/-based stub that the server will override */
            $type = isset($_FILES[$formField]['type']) ?
                $_FILES[$formField]['type'] : 'image/example';
            return $this->setThumbnailFromData($data, $type);
        }
        else {
            /* File upload error codes are at: http://php.net/file-upload.errors */
            throw new XN_Exception("Can't find valid uploaded file for $formField");
        }
    }
    
    /**
     * Set the profile thumbnail image to the provided data and
     * MIME type.
     *
     * @param $data string binary data containing the thumbnail image
     * @param $mimeType string MIME type of the binary data
     * @throws XN_Exception if upload fails or Location header is not returned
     * @return true if upload succeeds
     */
    public function setThumbnailFromData($data, $mimeType) {
        if (! mb_strlen($this->screenName)) {
            throw new XN_IllegalStateException("Can't set thumbnail on anonymous profile");
        }
        $url = XN_REST::urlsprintf("/xn/rest/2.0/profile(id='%s')/icon", $this->screenName);
        $rsp = XN_REST::put($url, $data, $mimeType,
                            array('Content-Length: ' . strlen($data)));
        // If the request is not a 200, then XN_REST will throw an exception, which
        // we can let bubble up.
        // If the request is a 200, we need to look at the Location header in the response
        // to determine the new URL for the uploaded icon
        $responseHeaders = XN_REST::getLastResponseHeaders();
        if (! isset($responseHeaders['Location'])) {
            throw new XN_Exception("Profile icon upload failed: no Location header in response");
        }
        $this->_thumbnailUrl = $responseHeaders['Location'];
        return true;
    }
    
    /**
    * Method that gets a new upload e-mail address for the current user
    *
    * @return string the new upload e-mail address
    * @throws XN_IllegalStateException if the method is called on a profile object
    * representing anybody but the currently logged-in user.
    */
    public function getNewUploadEmailAddress() {
        if (! $this->isLoggedIn()) {
            throw new XN_IllegalStateException("Upload e-mail address can only be reset for the currently logged-in user.");
        }
        $this->_data['uploadEmailAddress'] = $this->_getUploadEmailAddress('post');
        $this->_lazyLoaded['uploadEmailAddress'] = true;
        return $this->uploadEmailAddress;
    }

    /**
     * Provides the mutual friends of the user whose profile 
     * object this is and another user.
     * 
     * @param $user string|XN_Profile A string screen name or XN_Profile object
     * @return array string screen names of mutual friends. Returns an empty
     *    array if there are no common friends
     * @throws XN_IllegalStateException if this profile object is for an anonymous user
     * @throws XN_IllegalArgumentException if $user is a profile object for an anonymous user
     * @throws XN_Exception if the underlying REST request has a problem
     */
    public function getMutualFriends($user) {
        if (! mb_strlen($this->screenName)) {
            throw new XN_IllegalStateException("Can't get mutual friends: no screen name in profile object");
        }
        if ($user instanceof XN_Profile) {
            $otherScreenName = $user->screenName;
        } else {
            $otherScreenName = $user;
        }

        if (! mb_strlen($otherScreenName)) {
            throw new XN_IllegalArgumentException("Can't get mutual friends: no screen name provided");
        }

        $url = 'http://' . XN_AtomHelper::HOST_APP(XN_Application::$CURRENT_URL) .
            '/2.0/friend/common?' .
            XN_REST::urlsprintf("screen_name=%s&screen_name=%s", $this->screenName, $otherScreenName);
        $rsp = XN_REST::get($url, array(XN_REST::USE_SERVICE_LOCATION => 'contact'));
        $j = json_decode($rsp, true);
        if (is_array($j) && isset($j['results']) && is_array($j['results'])) {
            $res = array();
            foreach ($j['results'] as $result) {
                $res[] = $result['screen-name'];
            }
            return $res;
        } else {
            throw new XN_Exception("Unexpected friends-in-common response: $rsp");
        }
    }

    /**
     * Alters the relationship between a profile and one or more other
     * screenNames or profiles.
     *
     * If multiple users are specified, they must all be existing contacts
     * or they must all be non-existing contacts.
     *
     * @param $who A screen name, an XN_Profile object, an XN_Contact object
     *   or an array of those things in any combination
     * @param $relationship The desired relationship with the profiles listed
     *   in $who. To create a contact, this is:
     *      XN_Profile::FRIEND - to initiate a friend request
     *      XN_Profile::BLOCK  - to block someone
     *   To update an existing contact, this is:
     *      XN_Profile::FRIEND - to accept a friend request
     *      XN_Profile::NOT_FRIEND - to remove an existing friend link
     *      XN_Profile::BLOCK - to block someone
     * @param $message string optional message that can be supplied when creating
     *        a friend request
     *
     * @return true on success, an array of error messages on failure
     */
    public function setContactStatus($who, $relationship, $message = null) {
	if (! $this->isLoggedIn()) {
	    throw new XN_IllegalStateException("Contact status can only be changed for the currently logged-in user.");
	}
    $who = is_array($who) ? $who : array($who);
    $contactIds = '';
    foreach ($who as $x) {
        $contactIds .= '&contact_id=';
        if (($x instanceof XN_Profile) || ($x instanceof XN_Contact)) {
            $contactIds .= rawurlencode($x->screenName);
	} else {
            $contactIds .= rawurlencode($x);
        }
	}
	// For ::FRIEND or ::BLOCK, try a POST first
	$tryPut = true;
    $url = XN_REST::urlsprintf('/xn/rest/1.0/profile:%s/contact?contact_relationship=%s' . $contactIds . '&xn_out=xml', $this->screenName, $relationship);
	if (($relationship == self::FRIEND) || ($relationship == self::BLOCK)) {
	    try {
	        if (is_null($message)) {
		    $post_data = null;
		} else {
		    $post_data = array('message' => $message);
		}
		$rsp = XN_REST::post($url, $post_data);
		// The /profile:XXX/contact endpoint returns a 200 even if the operation failed.
		// We need to look at the response body to determine success
		$sxml = @simplexml_load_string($rsp);
		if ($sxml && $sxml->getName() != 'errors') {
		    $tryPut = false;
		}
	    } catch (Exception $e) {
	    }
	}
	if ($tryPut) {
	    try {
		$rsp = XN_REST::put($url,'');
		$sxml = @simplexml_load_string($rsp);
		if ($sxml && ($sxml->getName() == 'errors')) {
		    // Fake up the format of a regular REST exception to use standard
		    // error handling
		    $errorText = trim(strip_tags($sxml->asXml()));
		    throw new Exception('<errors><error code="-1">' . $errorText . '</error></errors>');
		}
		return true;
	    } catch (Exception $e) {
		return XN_REST::parseErrorsFromException($e);
	    }
	}
	else {
	    // The POST succeeded, so we didn't try a put
	    return true;
	}
    }
    
    // actual "to" value that is returned is min(actual value, asked for value) ==>
    // if total entries are 2174, asking for (from=3500, to=3600) will return total=2174, from=3500, to=2174
    // asking for (from=2150, to=2200) will return total=2174, from=2150, to=2174
    public function getApplicationsOwned($from = 0, $to = 100) {
        $subdomains = array();

        $url = XN_REST::urlsprintf("/xn/rest/2.0/profile(id='%s')/application?from=%d&to=%d", $this->screenName, $from, $to);
        $xml = XN_REST::get($url);
        $x = XN_AtomHelper::XPath($xml);
        $total = $x->textContent('/atom:feed/xn:size');

        foreach ($x->query('/atom:feed/atom:entry/xn:subdomain') as $node) {
            $subdomains[] = $node->textContent;
        }

        $numEntriesReturned = count($subdomains);

        if ($numEntriesReturned == 0) {
            $actualTo = 0;
		}
		else {
		    $actualTo = $from + $numEntriesReturned;
		}

        return array('total'=>$total,
                     'from'=>$from,
                     'to'=>$actualTo,
                     'subdomains'=>$subdomains);
    }

    /**
     * Remove an application from the user's set of recommended
     * applications.
     * 
     * @param $application string|XN_Application subdomain or XN_Application
     *   object of app to remove
     * @return boolean true if the application was removed successfully,
     *   false if the application wasn't on the list of recommendations for
     *   the user.
     * @throws XN_Exception if something goes wrong with the request
     */
    public function removeRecommendedApplication($application) {
        $subdomain = ($application instanceof XN_Application) ? $application->relativeUrl : $application;
        try {
            $url = 'http://' . XN_AtomHelper::HOST_APP(XN_Application::$CURRENT_URL) . 
                '/network/recommend/1.0?' . 
                http_build_query(array('q' => $this->screenName,
                                       'subdomain' => $subdomain));
            $res = XN_REST::delete($url, array(XN_REST::USE_SERVICE_LOCATION => 'network-search'));
            return true;
        } catch (XN_Exception $e) {
            if ($e->getCode() == 404) {
                return false;
            }
            throw $e;
        }
    }

    //------------------------------------------------------------------------
    // PACKAGE ONLY METHODS
    //------------------------------------------------------------------------        

    /** @unsupported @internal */
    function _getId(){
        return $this->screenName;
    }
    
    /** @unsupported @internal
     * Static method that returns the XN_Profile object of the given screen name from
     * the cache, or from the database if it hasn't yet been loaded.
     * @param $screenName string an XN_Profile screen name
     * @return XN_Profile
     */
    static function _get($screenName) {
        if ($screenName == NULL) { return NULL; }
        $profile = XN_Cache::_get($screenName, 'XN_Profile');
        return $profile!=NULL ? $profile : self::load($screenName); 
    }

    //------------------------------------------------------------------------
    // PRIVATE METHODS
    //------------------------------------------------------------------------
    private function __construct() { }  

    /** @unsupported @internal */
    public static function _createEmpty() {
        return new XN_Profile();
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
         // Load the property value
         if ($prop == 'uploadEmailAddress') {
             // uploadEmailAddress is only available for the currently logged-in user
             if ($this->isLoggedIn()) {
                 $this->_data['uploadEmailAddress'] = $this->_getUploadEmailAddress();
             } else {
                 // set uploadEmailAddress to null for users other than the
                 // currently logged-in user
                 $this->_data['uploadEmailAddress'] = null;
             }
             $this->_lazyLoaded[$prop] = true;
         }
    }
    /**
     * Retrieves the upload email address prefix and constructs the full address
     *
     * @param $method string optional method (get or post), defaults to get. A
     * method of 'post' changes the address.
     * @return string The full content upload e-mail address.
     */
    private function _getUploadEmailAddress($method = 'get') {
        $app = XN_Application::load()->relativeUrl;
        $url = 'http://' . XN_AtomHelper::HOST_APP($app) . '/xn/rest/internal/profile/content-email?xn_out=xml';
        if (strcasecmp($method,'get') == 0) {
            $xml = XN_REST::get($url);
        } else if (strcasecmp($method,'post') == 0) {
            $xml = XN_REST::post($url);
        } else {
            throw new XN_IllegalArgumentException("Unknown method: $method");
        }
        $xml = trim($xml);
        if (strlen($xml)) {
            $sxml = @simplexml_load_string($xml);
            if ($sxml) {
                $prefix = (string) $sxml;
                if (strlen($prefix)) {
                    $domainPart = $_SERVER['HTTP_HOST'];
                    if (substr($domainPart, 0, 4) == 'www.') {
                        $domainPart = substr($domainPart, 4);
                    }
                    return $prefix . '@' . $domainPart;
                }
            }
        }
        // If we didn't successfully retrieve an address
        return null;
    }
        
    
    private static function _messageToAtom($tos, $subject, $message, $type, $url = null) {
        // Build the list of <xn:to/> elements
        $toXML = '';
        foreach ($tos as $to => $fullName) {
            $toXML .= XN_REST::xmlsprintf('<xn:to address="%s">%s</xn:to>', $to, $fullName);
        }
        $xml = XN_REST::xmlsprintf('<entry xmlns="'.XN_AtomHelper::NS_ATOM.'" xmlns:xn="'.XN_AtomHelper::NS_XN.'">
<id>'.XN_AtomHelper::XN_IG_ID.'</id>
<published>%s</published>
<updated>%s</updated>
<author><name>'.XN_AtomHelper::XN_IG_AUTHOR.'</name></author>
<title type="text">%s</title>
<summary type="text">%s</summary>
'.$toXML.'
<xn:type>%s</xn:type>',gmstrftime('%Y-%m-%dT%H:%M:%SZ'), gmstrftime('%Y-%m-%dT%H:%M:%SZ'), $subject, $message, $type);
if (! is_null($url)) {
    $xml .= XN_REST::xmlsprintf('<link rel="target" href="%s"/>',$url);
}
$xml .= '</entry>';
return $xml;
    }
    
    /** @unsupported @internal */
    public function _fromAtomEntry(XN_XPathHelper $x, DomNode $node) {
        $this->_data['screenName'] = $x->textContent('xn:id', $node);
	    $this->_data['profileid'] = $x->textContent('xn:id', $node);
        $this->_data['fullName'] = $x->textContent('atom:title', $node);
        foreach ($x->query('atom:link',$node) as $link) {
            $rel = XN_XPathHelper::attribute($link, 'rel');
            if ($rel == 'icon') {
                $this->_thumbnailUrl = XN_XPathHelper::attribute($link,'href');
                $isDefaultIcon = XN_XPathHelper::attribute($link,'isDefault');
		if (! is_null($isDefaultIcon)) {
  	          $this->_isDefaultThumbnail = $isDefaultIcon == "true";
		}
		else {
		  $this->_isDefaultThumbnail  = false; // error on the side that if the link didn't indicate this is a default icon, treat it as not a default icon.
		}
            }
           
	}
	$this->_data['description'] = $x->textContent('atom:summary', $node, true);
	$this->_data['currentStatus'] = $x->textContent('xn:currentStatus/xn:value', $node, true);
	$this->_data['currentStatusUpdated'] = $x->textContent('xn:currentStatus/atom:updated', $node, true);

	$fields = array('application','type','zipcode','gender','givenname','link','location','country','presence',
		            'email','birthdate','mobile','status','qq','msn', 'locale', 'networkProfileVisibility','password',
					'address','province','city','cityarea','online','popularize','sourcer','system','browser','signature','realname','companyname','identitycard','identifier',
			        'identitycardlink','businesscardlink','certificatelink','isaudit','bank','bankname','bankaccount','reg_ip','wxopenid','sharefund','unionid','rank','money','accumulatedmoney','frozen_money','invitationcode','activationdate');

	foreach ($fields as $prop) {
	    $this->_data[$prop] = $x->textContent("xn:$prop", $node, true);
	}
	
	$this->_data['published'] = $x->textContent("atom:published", $node, true);

	$friends = array();
	$valueChildren = $x->query("xn:friends/xn:value", $node);	
	foreach ($valueChildren as $valueChild) {
			$friends[] = $valueChild->textContent;
	}
	$this->_data['friends'] = $friends;

	foreach (array('emailverified','mobileverified') as $prop) {
		$propValue = $x->textContent("xn:$prop", $node, true);
	    if (! is_null($propValue) && $propValue != '') {
			 $this->_data[$prop] = $propValue;
	    }
		else
		{
			 $this->_data[$prop] = '0';
		}
	}

    $propValue = $x->textContent("xn:profileEnabled", $node, true);
    if (! is_null($propValue)) {
      $this->profileEnabled = $propValue == "true";
    }

	foreach (array('allowNetworkInvitation','allowGroupInvitation','allowEventInvitation','allowFriendRequest','allowApplicationAlert','allowComment') as $prop) {
		$propValue = $x->textContent("email:$prop", $node, true);
		if (! is_null($propValue)) {
	        $this->_data[$prop] = $propValue == "true";
		}
	}
	
	$this->_setAgeFromBirthdate();
        return $this;
    }

    protected function _setAgeFromBirthdate() {
		// Calculate age from birthdate
		if (mb_strlen($this->_data['birthdate']) && preg_match('/^\d{4}-\d\d-\d\d$/',$this->_data['birthdate'])) {
			/* Today */
			list($y,$m,$d) = explode('-',gmdate('Y-m-d'));
			/* Birth date */
			list($by,$bm,$bd) = explode('-', $this->_data['birthdate']);
			/* Age = year difference */
			$this->_data['age'] = $y - $by;
			/* Except if it's before your birthday this year */
			if (($m < $bm) || (($m == $bm) && ($d < $bd))) {
			$this->_data['age']--;
			}
		}
		else {
			$this->_data['age'] = null;
		}
    }
    
    protected function _toAtomEntry() {
	$xml = XN_REST::xmlsprintf(
'<entry xmlns="%s" xmlns:xn="%s" xmlns:email="%s">
  <id>%s</id>
  <title type="text">%s</title>
  <summary type="text">%s</summary>
',
XN_AtomHelper::NS_ATOM, XN_AtomHelper::NS_XN, XN_AtomHelper::NS_EMAIL,
$this->_toAtomId(), $this->fullName, $this->description);
	if (mb_strlen($this->screenName)) {
	    $xml .= XN_REST::xmlsprintf("  <xn:id>%s</xn:id>\n", $this->screenName);
	}

	$fields = array('application','type','zipcode','gender','givenname','link','location','qq','msn',
					'country','email','birthdate','mobile','status',
					'address','province','city','cityarea','online','popularize','sourcer','system','browser','signature','realname','companyname','identitycard','identifier',
			        'identitycardlink','businesscardlink','certificatelink','isaudit','bank','bankname','bankaccount','reg_ip','wxopenid','sharefund','unionid','rank','money','accumulatedmoney','frozen_money','invitationcode','activationdate');

	foreach ($fields as $prop) {
	    if (mb_strlen($this->$prop)) 
		{
			$xml .= XN_REST::xmlsprintf("  <xn:$prop>%s</xn:$prop>\n", $this->$prop);
	    }
		else
		{
			if (isset($this->_changed[$prop]) && in_array($prop,array("mobile"))) {
			    $xml .= XN_REST::xmlsprintf("  <xn:$prop>%s</xn:$prop>\n", $this->$prop);
			} 
		}
	}
	if (mb_strlen($this->_thumbnailUrlUpload)) {
	    $xml .= XN_REST::xmlsprintf("  <link rel='icon' href='%s' />\n", rawurlencode($this->_thumbnailUrlUpload));
	}
	else if (mb_strlen($this->_thumbnailUrl)) {
	    $xml .= XN_REST::xmlsprintf("  <link rel='icon' href='%s' />\n", $this->_thumbnailUrl);
	}
	if (isset($this->_changed['profileid'])) {
	  $xml .= XN_REST::xmlsprintf("  <xn:profileid>%s</xn:profileid>\n", $this->profileid);
	}
	if (isset($this->_changed['password'])) {
	    $xml .= XN_REST::xmlsprintf("  <xn:password>%s</xn:password>\n", $this->password);
	} 
	else {
	    $xml .= "  <xn:password ignore='true' />\n";
	}
	 

    if (!is_null($this->currentStatus) && !is_null($this->currentStatusUpdated)) {
	    $xml .= "  <xn:currentStatus>\n";
		$xml .= XN_REST::xmlsprintf("  <xn:value>%s</xn:value>\n", $this->currentStatus);
		$xml .= XN_REST::xmlsprintf("  <updated>%s</updated>\n", $this->currentStatusUpdated);
	    $xml .= "  </xn:currentStatus>\n";
	}

	foreach (array('emailverified','mobileverified', 'locale','networkProfileVisibility') as $prop) {		 
	    if (! is_null($this->$prop)) {
			if ($this->$prop == "" || $this->$prop == "0")
			{
				$xml .= XN_REST::xmlsprintf("  <xn:$prop>0</xn:$prop>\n");
			}
			else
			{
				$xml .= XN_REST::xmlsprintf("  <xn:$prop>%s</xn:$prop>\n", $this->$prop);
			}
	    }
	}

	if (! is_null($this->profileEnabled)) {
		$xml .= XN_REST::xmlsprintf("  <xn:profileEnabled>%s</xn:profileEnabled>\n", $this->profileEnabled ? "true" : "false");
	}
	
	foreach (array('allowNetworkInvitation','allowGroupInvitation','allowEventInvitation','allowFriendRequest','allowApplicationAlert', 'allowComment') as $prop) {
	    if (! is_null($this->$prop)) {
			$xml .= XN_REST::xmlsprintf("  <email:$prop>%s</email:$prop>\n", $this->$prop ? "true" : "false");
	    }
	}

	$xml .= '</entry>';

	return $xml;
    }

    protected function _toAtomId() {
	return 'http://www.ning.com/profile/' . $this->screenName;
    }
    
    private static function _roleToAtom($roleCode) {
        return XN_REST::xmlsprintf('<xn:role xmlns:xn="'.XN_AtomHelper::NS_XN.'" name="%s"/>',$roleCode);
    }

    protected static function _idOrEmail($s) {
	return ((strpos($s,'@') === false) ? 'id' : 'email');
    }
}

} // class_exists()

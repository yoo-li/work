<?php
/**
 * The set of function for dealing with in-memory cache and XN_Cache:
 * 	- Caches loaded profile and content object in-memory on a per-request basis
 * 	- Wraps XN_Cache::get/put into a "single writer/multiple readers" pattern.
 * 	- Provides useful functions for the output caching
 *
 * 	TODO: Rename this class to XG_RequestCache (see Clearspace DOC-2081) [Jon Aquino 2008-09-11]
 * 	(it's not XG_RequestCache anymore)
 */

class XG_Cache {
    /** This is controlled by the dontCacheOrderN config variable in the admin
      * widget. Set that config variable to 1 to DISABLE caching of things for
      * which the cache growth will be linear wrt objects added (e.g. detail pages)
      * (BAZ-2969) */
    protected static $_cacheOrderN = null;

    /**
	 *	The list of acquired "cache write" locks
	 *
	 *  @var  {cacheKey:lockName}
     */
    protected static $cacheLocks = array();

    /**
	 *  @var    {email:screenName}
     */
    protected static $emailsToScreenNames = array();
    /**
	 *  @var    {screenName:XN_Profile}
     */
    protected static $screenNamesToProfiles = array();
    /**
     * 	Emails w/o XN_Profile object
	 *  @var    {email:1}
     */
	protected static $invalidProfileEmails = array();
    /**
     * 	screenNames w/o XN_Profile object
	 *  @var    {screenName:1}
     */
	protected static $invalidProfileScreenNames = array();

    /**
	 *  @var    {screenName:User}
     */
    protected static $screenNamesToUsers = array();
    /**
     * 	screenNames w/o XN_Content object
	 *  @var    {screenName:1}
     */
	protected static $invalidUserScreenNames = array();

    /**
	 *  @var    {screenName:User}
     */
    protected static $idsToObjects = array();
    /**
     * 	ids w/o XN_Content object
	 *  @var    {screenName:1}
     */
	protected static $invalidIds = array();

    public static function initialize() {
		// BAZ-13605: This function must be called after XG_App::go() [Andrey 2009-02-16]
    	$p = XN_Profile::current();
        if ($p->isLoggedIn()) {
			self::$screenNamesToProfiles[$p->screenName] = $p;
		}
		XN_Event::listen('xn/content/save/before', array(__CLASS__, 'onBeforeSave'));
		XN_Event::listen('xn/content/delete/before', array(__CLASS__, 'onBeforeDelete'));
    }
    /**
	 *  Returns the profile for the specified screenName/email. Result is cached in memory.
	 *  The difference between XG_Cache::profile and XG_Cache::profiles is that null value means "current profile" and "no profile" means Exception.
     *
     *  @param      $screenNameOrEmail   string    Screen name or ... email.
	 *  @return     XN_Profile
     */
	public static function profile($screenNameOrEmail) {
		if ($screenNameOrEmail === null) {
			return XN_Profile::current();
		}
		if (strpos($screenNameOrEmail, '@') === false) {  /** @non-mb */
			if (isset(self::$screenNamesToProfiles[$screenNameOrEmail])) {
				return self::$screenNamesToProfiles[$screenNameOrEmail];
			}
			// skip invalidProfileEmails check
		} else {
			if (isset(self::$emailsToScreenNames[$screenNameOrEmail])) {
				return self::$screenNamesToProfiles[ self::$emailsToScreenNames[$screenNameOrEmail] ];
			}
			// skip invalidProfileEmails check
		}
		$p = XN_Profile::load($screenNameOrEmail);
		if ($p->email) {
			self::$emailsToScreenNames[$p->email] = $p->screenName;
		}
		self::$screenNamesToProfiles[$p->screenName] = $p;
		return $p;
	}

    /**
	 * Loads XN_Profile objects for specified screenNames/emails/XN_Profiles/XN_Contents
     * Typically used in action methods to prime the cache using several objects.
     *
     * @param ...  XN_Content objects, XN_Contact objects, XN_Profile objects, screenNames, email addresses, and arrays of the aforementioned.
	 * @return An array of screenName (or email address) => XN_Profile, or if only one item was passed in, a single XN_Profile (or NULL if no profile was found).
     */
	public static function profiles() {
        $profiles = array();
		$args = func_get_args();
		$screenNamesToLoad = array();
        $emailsToLoad = array();
        foreach (self::screenNames($args) as $v) {
			if (strpos($v, '@') === false) { $sn = $v; } /** @non-mb */
			elseif (substr($v, -6) == '@users') { $sn = substr($v, 0, -6); } /** @non-mb */
			elseif (isset(self::$emailsToScreenNames[$v])) { $sn = self::$emailsToScreenNames[$v]; }
			else {
				if (!isset(self::$invalidProfileEmails[$v])) {
					$profiles[$v] = NULL;			// put placesholder in place
					$emailsToLoad[$v] = $v;
				}
				continue;
			}

			if (isset(self::$screenNamesToProfiles[$sn])) {
				$profiles[$sn] = self::$screenNamesToProfiles[$sn];
			} elseif (!isset(self::$invalidProfileScreenNames[$sn])) {
				$profiles[$sn] = NULL;
				$screenNamesToLoad[$sn] = $sn;
			}
		}

		if ($screenNamesToLoad) {
			foreach(array_chunk($screenNamesToLoad, 100) as $chunk) {
				foreach (XN_Profile::load($chunk) as $p) {
					$sn = $p->screenName;
					$profiles[$sn] = self::$screenNamesToProfiles[$sn] = $p;
					unset($screenNamesToLoad[$sn]); // mark item as found
				}
			}
			foreach ($screenNamesToLoad as $sn) { // go thru not found
				self::$invalidProfileScreenNames[$sn] = 1;
				unset($profiles[$sn]); // remove placeholder
			}
		}
		if ($emailsToLoad) {
			foreach(array_chunk($emailsToLoad, 50) as $chunk) {
				foreach (XN_Profile::load($chunk) as $p) {
					$e = $p->email;
					$sn = $p->screenName;
					self::$emailsToScreenNames[$e] = $sn;
					$profiles[$e] = self::$screenNamesToProfiles[$sn] = $p;
					unset($emailsToLoad[$e]);
				}
			}
			foreach ($emailsToLoad as $e) {
				self::$invalidProfileEmails[$e] = 1;
				unset($profiles[$e]);
			}
		}

		if (count($args) == 1 && !is_array($args[0])) {
            return count($profiles) ? reset($profiles) : NULL;
        }

        // Performance optimization: automatically prime the User cache, if more than one profile is requested [Jon Aquino 2007-09-20]
		if (count($profiles) > 1) { self::users($profiles); }

        return $profiles;
    }

    /**
	 * Loads XN_Content User objects for specified screenNames/XN_Profiles/XN_Contents
     * Typically used in action methods to prime the cache using several objects.
     *
     * @param ...  XN_Content objects, XN_Contact objects, XN_Profile objects, screenNames, and arrays of the aforementioned.
	 * @return An array of screenName (or email address) => XN_Content user object, or if only one item was passed in, a single XN_Profile (or NULL if no profile was found).
     */
	public static function users() {
		$users = array();
		$args = func_get_args();
		$loadByTitle = array();
        foreach (self::screenNames($args) as $snLc => $sn) {
			if (isset(self::$screenNamesToUsers[$snLc])) {
				$users[$sn] = self::$screenNamesToUsers[$snLc];
			} elseif (!isset(self::$invalidUserScreenNames[$snLc])) {
				$loadByTitle["User-$snLc"] = $sn;
				$users[$sn] = NULL; // put placeholder in place
			}
		}

		$loadById = array();
		if ($loadByTitle) {
			foreach (array_chunk($loadByTitle, 100, true) as $chunk) {
				foreach (XN_Cache::get(array_keys($chunk)) as $key => $id) { // Load the "title => ID" map
					if ($id) {	// Empty ID means "there is no User with such screenName on this network"
						$loadById[] = $id;
					} else {
						$snLc = substr($key, 5); /** @non-mb */
						self::$invalidUserScreenNames[$snLc] = 1;
						unset($users[ $loadByTitle[$key] ]);
					}
					unset($loadByTitle[$key]);
				}
			}
			if ($loadByTitle) { // If not everything is in cache, load it from DB and cache it
				foreach(array_chunk($loadByTitle, 100) as $chunk) {
					$query = XN_Query::create('Content')->alwaysReturnTotalCount(FALSE)->filter('type', '=', 'User')->filter('title', 'in', $chunk);
					foreach ($query->execute() as $u) {
						$snLc = mb_strtolower($u->title);
						self::$screenNamesToUsers[$snLc] = $users[$u->title] = $u;
						unset($loadByTitle["User-$snLc"]);
						XN_Cache::put("User-$snLc", $u->id);
					}
				}
			}
		}
		if ($loadById) { // Process collected IDs
			foreach (self::content($loadById) as $u) {
				$snLc = mb_strtolower($u->title);
				self::$screenNamesToUsers[$snLc] = $users[$u->title] = $u;
				unset($loadByTitle["User-$snLc"]);
			}
		}
		if ($loadByTitle) { // Process all not found users (no screenName, no such ID etc)
			foreach ($loadByTitle as $key=>$sn) {
				$snLc = substr($key, 5); /** @non-mb */
				self::$invalidUserScreenNames[$snLc] = 1;
				XN_Cache::put($key,""); // Prevent further loads
				unset($users[$sn]);
			}
		}

		if (count($args) == 1 && !is_array($args[0])) {
            return count($users) ? reset($users) : NULL;
        }

        return $users;
	}
    /**
	 *  Returns XN_Content User object if the User with this screenName is in memory or NULL otherwise
     *
	 *  @param	$screenName   string    Screen name to look up
     *  @return XN_Content|NULL
     */
	public static function cachedUser($screenName) {
		return self::$screenNamesToUsers[mb_strtolower($screenName)];
    }

    /**
	 *  Adds XN_Content User objects into memory map.
     *
	 *  @param	$users   XN_Content|[XN_Content]    Users to add into map
     *  @return void
     */
    public static function addUsers($users) {
		foreach (is_array($users) ? $users : array($users) as $u) {
			self::$screenNamesToUsers[mb_strtolower($u->title)] = $u;
		}
    }

    /**
	 *  Flush the cached user data for the screenName
     *
	 *  @param      $screenName   string	screenName to flush the data for
     *  @return     void
     */
    public static function flushUserInfo($screenName) {
		$snLc = mb_strtolower($screenName);
		if (isset(self::$screenNamesToUsers[$snLc])) {
			$user = self::$screenNamesToUsers[$snLc];
			if ($user->id) {
				unset(self::$idsToObjects[$user->id]);
				unset(self::$invalidIds[$user->id]);
			}
			unset(self::$screenNamesToUsers[$snLc]);
		}
		unset(self::$invalidUserScreenNames[$snLc]);
		XN_Cache::remove("User-$snLc");
        return;
    }

    /**
     * Recursively converts the given objects into screen names.
     * Content objects are converted to their contributorNames.
     * Arrays are searched recursively. Empty strings and nulls are ignored.
     *
     * @param $items array XN_Content objects, XN_Contact objects, XN_Profile objects, screenNames, and arrays of the aforementioned.
     * @return array  screenName => screenName
     */
	public static function screenNames($items) {
       	$screenNames = array();
		self::_screenNamesProper(is_array($items) ? $items : array($items), $screenNames);
        return $screenNames;
    }

    /**
     * Converts the given object into a screen name.
     * Content objects are converted to their contributorNames.
     *
     * @param $item array XN_Content|W_Content|XN_Content|XN_Contact|string  the object to convert
     * @return array  The screen name
     */
	protected static function _screenNamesProper($items, array &$screenNames) {
    	foreach ($items as $item) {
            if ($item === NULL || $item === '') { continue; }
			if (is_array($item)) {
				self::_screenNamesProper($item, $screenNames);
			} else if (!is_object($item)) {
				$screenNames[mb_strtolower("$item")] = "$item";
			} elseif ($item instanceof XN_Profile || $item instanceof XN_Contact) {
            	$screenNames[mb_strtolower($item->screenName)] = $item->screenName;
        	} else {
        		$sn = $item->type == 'User' ? $item->title : $item->contributorName;
				$screenNames[mb_strtolower($sn)] = $sn;
        	}
		}
    }


    /**
	 *  Returns content by IDs. If ids is a scalar, a single content object is returned, otherwise a hash keyed by ID is returned
     *
	 *	@param		$ids	string|[string]		One or more IDs
	 *  @return     XN_Content|{id:XN_Content}
     */
	public static function content($ids) {
		$content = array();
		$idsToLoad = array();
		foreach((array)$ids as $id) {
			if (isset(self::$idsToObjects[$id])) {
				$content[$id] = self::$idsToObjects[$id];
			} elseif (!isset(self::$invalidIds[$id])) {
				$content[$id] = NULL;
				$idsToLoad[$id] = $id;
			}
		}
		if ($idsToLoad) {
			foreach (array_chunk($idsToLoad, 100) as $chunk) {
				foreach (XN_Content::loadMany($chunk) as $o) {
					$id = $o->id;
					self::$idsToObjects[$id] = $content[$id] = $o;
					unset($idsToLoad[$id]);
				}
			}
			foreach ($idsToLoad as $id) {
				self::$invalidIds[$id] = 1;
			}
		}
		if (!is_array($ids)) {
			if (count($content)) {
				return reset($content);
			}
			// Mimic the original XN_Content behavior
			throw new XN_Exception("'Failed to load content object: ApplicationException: Cannot find content with ID '$ids'", 404);
        }
        return $content;
	}

  /**
   * Generates a cache invalidation key for app-wide use based on its argument(s)
   *
   *   When passed this.....                    Returns this....[1]
   * --------------------------------------------------------------------------
   *   XN_Profile object                        xg-user-<screenName>
   *   User Content object                      xg-user-<content contributor screenName>
   *   'user', screen name as string            xg-user-<screenName>
   *   Other content object                     xg-content-<id>
   *   'promotion', content object              xg-promotion-<content object type>
   *   'moderation', XN_Profile or User object  xg-moderation-<screenName>
   *   'moderation', XN_Profile or User object,
   *       content object                       xg-moderation-<screenName>-<content object type>
   *   'moderation', XN_Profile or User object
   *       or XN_Application object or string [3],
   *       W_Widget object                      xg-moderation-<screenName->-w-<widget instance name>
   *   'type', content object                   xg-type-<content object type>
   *   'type', string                           xg-type-<string>
   *   XG_Embed object                          xg-embed-<embed locator>-<[2]>
   *
   * When content object types or screen names are incorporated into cache keys,
   * they are made all-lowercase first.
   *
   * [1] The portion of the generated cache invalidation key after the initial
   * 'xg-' is hashed with the XG_Cache::hash() function before it is returned
   * to save space.
   *
   * [2] The second part of the embed cache key is 'o' if the embed object is
   * owned by the current user and 'u' otherwise.
   *
   * [3] If an XN_Application object is provided here, the screen name of the
   * application owner is used for the <screenName> portion of the key. If a
   * string is provided here, the string is used for the <screenName> portion
   * of the key.
   *
   *
   * The cache keys begin with "xg-" to prevent overlap with user-created keys
   * and with widget-specific keys {@see widgetKey()}.
   *
   * @return string
   */
	public static function key() {
		$args = func_get_args();
		$argc = func_num_args();
		// XN_Profile -> xg-user-<screenName>
		if (($argc == 1) && ($args[0] instanceof XN_Profile)) {
			$key = 'user-' . mb_strtolower($args[0]->screenName);
		}
		// User object -> xg-user-<content contributor screenName>
		else if (($argc == 1) && self::isContent($args[0]) && ($args[0]->type == 'User')) {
			$key = 'user-' . mb_strtolower($args[0]->contributorName);
		}
		// user', screen name as string -> xg-user-<screenName>
		else if (($argc == 2) && (strcasecmp('user', $args[0]) == 0)) {
			$key = 'user-' . mb_strtolower((string) $args[1]);
		}
		// Other content object -> xg-content-<id>
		else if (($argc == 1) && self::isContent($args[0])) {
			$key = 'content-' . $args[0]->id;
		}
		// 'promotion', content object => xg-promotion-<content object type>
		else if (($argc == 2) && (strcasecmp('promotion', $args[0]) == 0) && self::isContent($args[1])) {
			$key = 'promotion-' . mb_strtolower($args[1]->type);
		}
		// 'moderation', XN_Profile object or User object -> xg-moderation-<screenName>
		else if (($argc == 2) && (strcasecmp('moderation', $args[0]) == 0)) {
			if ($args[1] instanceof XN_Profile) {
				$key = 'moderation-' . mb_strtolower($args[1]->screenName);
			}
			else if (self::isContent($args[1]) && ($args[1]->type == 'User')) {
				$key = 'moderation-' . mb_strtolower($args[1]->contributorName);
			}
			else {
				throw new XG_Exception("XG_Cache::key() doesn't know how to handle 'moderation', {$args[1]}");
			}
		}
		// 'moderation', XN_Profile, content object -> xg-moderation-<screenName>-<content object type>
		else if (($argc == 3) && (strcasecmp('moderation', $args[0]) == 0) && self::isContent($args[2])) {
			if ($args[1] instanceof XN_Profile) {
				$key = 'moderation-' . mb_strtolower($args[1]->screenName) . '-' . mb_strtolower($args[2]->type);
			} else if (self::isContent($args[1]) && ($args[1]->type == 'User')) {
				$key = 'moderation-' . mb_strtolower($args[1]->contributorName) . '-' . mb_strtolower($args[2]->type);
			} else {
				throw new XG_Exception("XG_Cache::key() doesn't know how to handle 'moderation',{$args[1]},{$args[2]->id}");
			}
		}
		// 'moderation', XN_Profile or User object or XN_Application object,
		//       or XN_Application object or string [3],
		//       W_Widget object                      xg-moderation-<screenName->-m-<widget instance name>
		else if (($argc == 3) && (strcasecmp('moderation', $args[0]) == 0) && ($args[2] instanceof W_BaseWidget)) {
			if ($args[1] instanceof XN_Profile) {
				$key = 'moderation-' . mb_strtolower($args[1]->screenName) . '-w-' . mb_strtolower($args[2]->dir);
			} else if (self::isContent($args[1]) && ($args[1]->type == 'User')) {
				$key = 'moderation-' . mb_strtolower($args[1]->contributorName) . '-w-' . mb_strtolower($args[2]->dir);
			} else if (($args[1] instanceof XN_Application)) {
				$key = 'moderation-' . mb_strtolower($args[1]->ownerName) . '-w-' . mb_strtolower($args[2]->dir);
			} else if (is_string($args[1])) {
				$key = 'moderation-' . mb_strtolower($args[1]) . '-w-' . mb_strtolower($args[2]->dir);
			} else {
				throw new XG_Exception("XG_Cache::key() doesn't know how to handle 'moderation',{$args[1]},{$args[2]->dir}");
			}
		}
		// 'type', content object                   xg-type-<content object type>
		// 'type', string                           xg-type-<string>
		else if (($argc == 2) && (strcasecmp('type', $args[0]) == 0)) {
			if (self::isContent($args[1])) {
				$type = $args[1]->type;
			} else if (is_string($args[1]) || is_numeric($args[1])) {
				$type = $args[1];
			}
			$key = 'type-' . mb_strtolower($type);
		}
		// XG_Embed object                          xg-embed-<embed locator>-<[2]>
		else if (($argc == 1) && ($args[0] instanceof XG_Embed)) {
			$key = 'embed-' . $args[0]->getLocator() . '-'. ($args[0]->isOwnedByCurrentUser() ? 'o' : 'u');
		} else {
			throw new XG_Exception("Invalid set of arguments passed to XG_Cache::key()");
		}

		return 'xg-' . self::hash($key);
	}

	protected static function isContent($o) { return (($o instanceof XN_Content) || ($o instanceof W_Content)); }

   /** Methods and properties for managing the persistent cache
    * This is a file based cache that other code can use for storing
    * data between requests
    */

	/**
	 * A hash function to shrink strings so they take up less space in the
	 * cache key. Using the first ten characters (40 bits) of an MD5 hash,
	 * assuming the
	 * hash space is evenly distributed, should cause a collision only in
	 * 1 out of every 16^10 = 2^40 = 1,099,511,627,776 hashes.
	 *
	 * @param $str string What to hash
	 * @return string The hashed value
	 */
	public static function hash($str) {
		return substr(md5($str), 0, 10);
	}

    /**
     * Cache things which grow linearly with content growth (like detail pages)?
     *   (BAZ-2969)
     */
    public static function cacheOrderN() {
        if (!isset(self::$_cacheOrderN)) {
            $adminWidget = W_Cache::getWidget('admin');
            self::$_cacheOrderN = $adminWidget->config['dontCacheOrderN'] ? false : true;
        }
        return self::$_cacheOrderN;
    }

    /**
     * Returns whether cached output with the given ID is available and hasn't yet expired.
     * If so, outputs the cached output; otherwise, captures the output until the matching
     * outputCacheEnd() call. Usage is similar to the Cache_Lite_Output functions:
     *
     *     if (! XG_Cache::outputCacheStart('feed', 3600)) {
     *         echo 'Expensive output here';
     *         XG_Cache::outputCacheEnd('feed');
     *     }
     *
     * One advantage of this technique over standard action caching is that the expensive
     * cache-building is done in the first request only; other requests continue to use the old cache until
     * the new cache is built.
     *
     * @param $id string  ID for the cache entry
     * @param $maxAge integer  max age in seconds
     * @return boolean  whether valid cached output is available
     */
    public static function outputCacheStart($id, $maxAge) {
        list($then, $data) = XN_Cache::get($id);
        if ($then < time() - 2*$maxAge) {
            try {
                XN_Cache::remove($id . '-lock'); // Just in case [Jon Aquino 2007-09-04]
            } catch(Exception $e) { }
        }
        if ($then < time() - $maxAge && XN_Cache::insert($id . '-lock', 'foo')) {
            ob_start();
            return false;
        }
        echo $data;
        return true;
    }

    /**
     * Finishes the output capture started by outputCacheStart().
     *
     * @param $id string  ID for the cache entry
     */
    public static function outputCacheEnd($id) {
        $data = ob_get_contents();
        ob_end_clean();
        XN_Cache::put($id, array(time(), $data));
        XN_Cache::remove($id . '-lock');
        echo $data;
    }

    /**
	 *  Retrives a cache entry.
	 *
	 *  If the data is about to expire, tries to acquire a write lock. If it succeeds, NULL is returned and the caller
	 *  can update the data and put it back into the cache using XG_Cache::put(). If it fails, the existing data is returned.
	 *
	 *  If maxAge <= 5 seconds, function works as a regular XN_Cache::get
	 *
	 *  @param      $cacheKey	string		Cache key to fetch
	 *  @param		$maxAge		int			Data expiration period in seconds. Default is 5 mins. NULL means "forever"
	 *  @param		$lockName	string		Lock name to guard cache updates. Default is $cacheKey:lock
	 *  @param		$waitTimeout float		Wait timeout when there is no data and lock cannot be acquired.
	 *  									When even after this timeout the lock cannot be acquired, NULL is returned.
     *  @return     mixed | NULL
     */
	public static function get($cacheKey, $maxAge = 300, $lockName = NULL, $waitTimeout = 2) {
		if ( ($res = self::_get($cacheKey, $maxAge)) && ((time() - $res[0]) < $maxAge * 0.9) ) {
			// if data is fresh, just return it
   	        return $res[1];
        }
		// Data doesn't exist or is about to expire (but we still have the staled data)
		if ($maxAge !== NULL && $maxAge > 5) {
			if ( !$lockName ) {
				$lockName = "$cacheKey:lock";
			}
			// If there is some data, do not wait. If we can't acquire lock, just return the staled data.
			$start = microtime(TRUE);
			$locked = XG_LockHelper::lock($lockName, $res ? 0 : $waitTimeout);
			$end = microtime(TRUE);
			// If we waited for the lock at least 0.5 seconds, try to get the data again before
			// we return NULL and make caller to rebuild it
			if ($locked) {
				if ($end - $start > 0.5) {
					if ( ($res = self::_get($cacheKey, $maxAge)) && ((time() - $res[0]) < $maxAge * 0.9) ) {
						// if data has been updated, just return it
						return $res[1];
					}
				}
				if ($locked) {
					self::$cacheLocks[$cacheKey] = $lockName;
					return NULL;
				}
			}
		}
		return $res ? $res[1] : NULL;
	}

    //
	protected static function _get($cacheKey, $maxAge) { # void
        try {
            $res = XN_Cache::get($cacheKey, $maxAge === NULL ? NULL : intval($maxAge*1.1));
        } catch (Exception $e) {
            return NULL;
        }
		if ( $res && is_array($res = unserialize($res)) ) { // if there is some data and data format is valid
			return $res;
		}
		return NULL;
    }


    /**
	 *	Puts value in the cache, so other processes could recieve it using XG_Cache::get() call.
	 *	If process acquired lock using XG_Cache::get() call, this lock is released.
     *
     *  @param      $cacheKey   string			Cache key to put data into
	 *  @param		$value		mixed			Cache value
	 *  @param		$labels		string|array	Optional invalidation labels
     *  @return     void
     */
	public static function put($cacheKey, $value, $labels = null) {
        try {
			XN_Cache::put($cacheKey, serialize(array(time(), $value)), $labels);
        } catch (Exception $e) {
        	// Do not remove it. BAZ-5728 [Andrey 2008-11-19]
			XG_LogHelper::error_log("XG_Query error: cache put failed: ".$e->getMessage());
        }
		if (isset(self::$cacheLocks[$cacheKey])) {
			XG_LockHelper::unlock(self::$cacheLocks[$cacheKey]);
			unset(self::$cacheLocks[$cacheKey]);
		}
    }

    /**
	 *  Handles new user object creation
     */
	public static function onBeforeSave($objects) {
		foreach (is_array($objects) ? $objects : array($objects) as $o) {
			if ($o->type == 'User' && !$o->id) {
				$l = mb_strtolower($o->title);
				XN_Cache::remove("User-".$l);
				unset(self::$invalidUserScreenNames[$l]);
			}
		}
    }

    /**
	 *  Handles user object removing
     */
	public static function onBeforeDelete($objects) {
		foreach (is_array($objects) ? $objects : array($objects) as $o) {
			if ($o->type == 'User') {
				$l = mb_strtolower($o->title);
				XN_Cache::remove("User-".$l);
				unset(self::$screenNamesToUsers[$l]);
			}
			unset(self::$idsToObjects[$o->id]);
		}
    }

    /**
	 *  Clears the in-memory cache. Should be used from unit tests by extending this class and making this function public:
	 *
	 *  // bazel-8098 review:
	 *  class Foo extends XG_Cache {
	 *    public static function clear() {
	 *       parent::_clear();
	 *    }
	 *  }
     *
     *  @return     void
     */
    protected static function _clear() {
    	self::$emailsToScreenNames = array();
    	self::$screenNamesToProfiles = array();
		self::$invalidProfileEmails = array();
		self::$invalidProfileScreenNames = array();
    	self::$screenNamesToUsers = array();
		self::$invalidUserScreenNames = array();
    	self::$idsToObjects = array();
		self::$invalidIds = array();
    }
}

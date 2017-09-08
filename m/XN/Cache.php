<?php
/**
 * XN_Cache is used for some per-request caching, but also for accessing
 * the Ning core cache service
 *
 * @file
 * @ingroup XN
 */

/* $Revision */

/** @cond */
if (! class_exists('XN_Cache')) {
/** @endcond */
 
/**
 * The XN_Cache class is responsible for maintaining a cache of objects loaded
 * from the database.
 *
 * @ingroup XN
 */
class XN_Cache {
    /** 
     * Cache of objects loaded from the database. The cache is keyed by 
     * classname concatenated with object id.
     */ 
    private static $cache = array();
    
    //--- Package methods ---
    
    /** @unsupported @internal */
    static function _put($object){
        self::$cache[self::_keyFromObject($object)] = $object;
    }
    
    /** @unsupported @internal */
    static function _remove($object){
        unset(self::$cache[self::_keyFromObject($object)]);
    }
    
    /** @unsupported @internal */
    static function _get($id, $classname){
        $key = self::_keyFromIdAndClassName($id, $classname);
        return array_key_exists($key, self::$cache) ?
            self::$cache[$key] : null;
    }
    
    //--- Private methods ---
    
    private static function _keyFromObject($object){
        return self::_keyFromIdAndClassName($object->_getId(), 
                                            self::_toClassName($object));
    }
    
    private static function _keyFromIdAndClassName($id, $classname){
        return $classname.$id;
    }
    
    private static function _toClassName($object){
        if (!is_object($object))
            throw new Exception("$object is not an object");
        else if ($object instanceof XN_Profile)
            return "XN_Profile";
        else if ($object instanceof XN_Content)
            return "XN_Content";
        else if ($object instanceof XN_Application)
            return "XN_Application";
        else if ($object instanceof XN_Tag)
            return "XN_Tag";
        else if ($object instanceof XN_Shape)
            return "XN_Shape";
	      else if ($object instanceof XN_Backup)
            return "XN_Backup";
        else
            throw new Exception("Unsupported class: $obj");
    }
    
    /*
     * Cache Service Access
     */
     
    const INSERT = 1;
    const UPDATE = 2;
    const ALL = 3;
    
    const MAX_DATA_SIZE = 1048576;
    
    /** @unsupported @internal
     * Parse a cache reply into an array of cache items. A cache item is
     * represented in the reply from the server as a series of "Name: Value\n"
     * headers, the last of which is the "Length" header. If the reply
     * includes entry values, then after the "Length: NNN\n" header are the
     * NNN bytes of the entry value.
     *
     * @param $reply string The reply from the request to the cache server
     * @param $returnEntryOptions boolean Whether to return an array of
     *   XN_Cache_Entry objects or an array of string cache values (the default)
     * @param $onlyEntryMetadata boolean Whether $reply contains just entry
     *   metadata or entry values as well (the default)
     * @return array An array of XN_Cache_Entry objects or string entry values
     */
    protected static function _itemsFromCacheReply($reply,
                                                   $returnEntryObjects = false,
                                                   $onlyEntryMetadata = false) {
        $items = array();
        $pos = 0; $last = strlen($reply) - 1;
        $headers = array();
        while ($pos < $last) {
            $eol = strpos($reply, "\n", $pos);
            if ($eol === FALSE) {
                throw new XN_Exception('Malformed cache response', 500);
            }
            $line = substr($reply, $pos, $eol - $pos);
            list($header,$value) = explode(': ', $line, 2);
            $headers[$header] = $value;
            $pos = $eol + 1;
            // If we just hit the Length header, then next comes the data
            if ($header == 'Length') {
                if ($onlyEntryMetadata) {
                    $value = null;
                } else {
                    $value = unserialize(substr($reply, $pos, $headers['Length']));
                    $pos += $headers['Length'] + 1; /* +1 to skip "\n" -- NING-9850 */
                }
                $items[$headers['Id']] = $returnEntryObjects ?
                    XN_Cache_Entry::create($headers, $value) : $value;
                $headers = array();
            }
            
        }
        return $items;
    }
    
    /** @unsupported @internal
     * Create a URL for a cache operation given a particular term and
     * selector values
     *
     * @param $term string|null term to use, such as "id" or "label"
     * @param $values string|array values to match against the term in the selector
     * @return string the full URL for the cache operation
     */
    protected static function _buildUrl($term, $values) {
        $url = 'http://'.XN_AtomHelper::HOST_APP(XN_Application::load()->relativeUrl) . '/xn/rest/1.0/cache';
        if (is_array($values)) {
            $quotedValues = array_map(array('XN_REST','singleQuote'), $values);
            $url .= XN_REST::urlsprintf('(%s)',"$term in ['".implode("','",$quotedValues)."']");
        }
        /* $term = null is passed for DELETE everything */
        else if (! is_null($term)) {
            $url .= XN_REST::urlsprintf("($term='%s')", $values);
        }
        return $url;
    }

    /**
     * Get something(s) from the cache
     *
     * @param $ids string|array Either a single string cache ID or an array of
     *        string cache IDs.
     * @param $maxAge integer optional max age in seconds. Cache entries older than
     * this value will not be returned
     * @return null|string|array If $ids is a string and a cache entry is
              available, then the return value is the value of that cache entry. If
              no cache entry is available, the return value is null.
              If $ids is an array and there are any matching cache entries, then
              the return value is an array whose keys are cache IDs and whose values
              are the corresponding values from the cache. If no cache entries are
              available then the return value is an empty array.
     */          
    public static function get($ids, $maxAge = null) {
        return self::_getValuesOrEntries($ids, $maxAge, false);
    }
 
    /**
     * Get something(s) from the cache
     *
     * @param $ids string|array Either a single string cache ID or an array of
     *        string cache IDs.
     * @param $maxAge integer optional max age in seconds. Cache entries older than
     * this value will not be returned
     * @return null|XN_Cache_Entry|array If $ids is a string and a cache entry is
              available, then the return value is an XN_Cache_Entry object containing
              information about and the value of that cache entry. If
              no cache entry is available, the return value is null.
              If $ids is an array and there are any matching cache entries, then
              the return value is an array whose keys are cache IDs and whose values
              are XN_Cache_Entry objects for the corresponding values from the cache.
              If no cache entries are available then the return value is an empty array.
    */          
    public static function getEntry($ids, $maxAge = null) {
        return self::_getValuesOrEntries($ids, $maxAge, true);
    }

    /**
     * @unsupported @internal
     *
     * Used by get() and getEntry() to format arguments and retrieve results
     *
     * @param $ids string|array Entry ID or IDs to retrieve from the cache
     * @param $maxAge integer|null Max age of entries to retrieve if desired
     * @param $returnEntryObjects boolean Whether to format the results as 
     *   XN_Cache_Entry objects or string entry values
     * @return Returns a single value if $ids is a single value: null if 
     *   no entry was found, a string if $returnEntryObjects is false,
     *   an XN_Cache_Entry object if $returnEntryObjects is true. If $ids
     *   is an array (no matter how many elements it has), return value is
     *   an empty array if no entries were found, or either an array of
     *   strings or XN_Cache_Entry objects depending on the value of
     *   $returnEntryObjects.
     */
    protected static function _getValuesOrEntries($ids, $maxAge, $returnEntryObjects) {
        $single = (! is_array($ids));
        $url = self::_buildUrl('id',$ids);
        $headers = array();
        if (! is_null($maxAge)) {
            $headers['Cache-Control'] = 'max-age=' . $maxAge;
        }
        try {
            $rsp = XN_REST::get($url, $headers);
            $items = self::_itemsFromCacheReply($rsp, $returnEntryObjects);
            return $single ? $items[$ids] : $items; 
        } catch (XN_Exception $e) {
            if (($e->getCode() == 404) || ($e instanceof XN_SerializationException)) {
                if ($e instanceof XN_SerializationException) {
                    $rspLen = strlen($rsp);
                    error_log('Serialization exception -- ids: ' . ($single ? $ids : implode(', ', $ids)) . ' rspLen: ' . $rspLen . ($rspLen > 0 && $rspLen < 1000 ? ' rsp: ' . $rsp : '') . ' trace: ' . $e->getTraceAsString());
                }
                return $single ? null : array();
            } 
            if (($e->getCode() == 404) || ($e instanceof XN_SerializationException)) {
                return $single ? null : array();
            } 
            else {
                throw $e;
            }
        }
    }

    /**
     * Put something into the cache, whether or not it's already there
     *
     * @param $id string ID for the cache entry
     * @param $data string Data to cache
     * @param $labels string|array optional cache entry labels. Can either be
     *        a single string label or an array of string labels
     * @return mixed XN_Cache::INSERT if the entry was not already there
     *               XN_Cache::UPDATE if the entry was already there
     */
    public static function put($id, $data, $labels = null) {
        return self::putProper($id, $data, $labels);
    }

    /** @unsupported @internal
     * Put something into the cache, whether or not it's already there. This
     * method is only public because XN_Cache_Entry needs access to it. Do 
     * not call it from outside of XN_Cache or XN_Cache_Entry. It may change
     * or be removed at any time.
     *
     * @param $id string ID for the cache entry
     * @param $data string Data to cache
     * @param $labels string|array optional cache entry labels. Can either be
     *        a single string label or an array of string labels
     * @param $version optional integer version of the cache entry. If present,
     *        a version-aware save is performed and XN_Cache_Entry objects are
     *        returned on conflict
     * @return mixed On a version-aware save:
     *                  The new version number if the save succeeded
     *                  An XN_Cache_Entry object containing up-to-date entry if 
     *                    the save failed
     *               Otherwise:
     *                  XN_Cache::INSERT if the entry was not already there
     *                  XN_Cache::UPDATE if the entry was already there
     *               
     */
    public static function putProper($id, $data, $labels, $version = null) {
        // complain if $id isn't a scalar?
        $url = self::_buildUrl('id',$id);
        $body = serialize($data);
        if (strlen($body) > self::MAX_DATA_SIZE) {
            throw new XN_Exception("Data too big for cache ID $id -- max allowed size is " . self::MAX_DATA_SIZE . " bytes", 413);
        }
        $headers = array();
        if (! is_null($labels)) {
            // @todo check label syntax (no ,), trim
            if (is_array($labels)) {
                if (count($labels)) {
                    $headers['X-Ning-Cache-Labels'] = implode(',', $labels);
                }
            } else {
                $headers['X-Ning-Cache-Labels'] = $labels;
            }
        }

        if (isset($version)) {
            $headers['X-Ning-Entry-Version'] = $version;
        }

        try {
            $rsp = XN_REST::put($url, $body, 'application/octet-stream', $headers);
            $code = XN_REST::getLastResponseCode();
            if (($code == 200) || ($code == 201)) {
                if (isset($version)) {
                    $items = XN_Cache::_itemsFromCacheReply($rsp, true, true);
                    if (! isset($items[$id])) {
                        throw new Exception("Cache entry put reply is missing an ID");
                    }
                    return $items[$id]->version;
                } else if ($code == 200) {
                    return self::UPDATE;
                } else { 
                    return self::INSERT;
                }
            }
            else {
                throw new XN_Exception("Unknown response code from cache put: $code");
            }
        } catch (Exception $e) {
            // 409 means the entry exists but version doesn't match
            if ($e->getCode() == 409) {
                /* On 4xx and 5xx errors, the XN_Exception thrown by 
                 * XN_REST contains the response body as the exception
                 * message
                 */
                $items = XN_Cache::_itemsFromCacheReply($e->getMessage(), true);
                if (! isset($items[$id])) {
                    throw new Exception("Cache entry put reply is missing an ID");
                }
                return $items[$id];
            } 
            // 404 means the entry doesn't exist (anymore)
            else if ($e->getCode() == 404) {
                return XN_Cache_Entry::create(array('Id' => $id,
                                                    'Version' => 0), null);
            }
            else {
                throw $e;
            }

        }
            
    }
 
    /**
     * Put something into the cache if it's not already there
     * 
     * @param $id string ID for the cache entry
     * @param $data string Data to cache
     * @param $labels string|array optional cache entry labels. Can either be
     *        a single string label or an array of string labels
     * @return bool  true if the insertion succeeded, false if the entry was
     *               already there
     */
    public static function insert($id, $data, $labels = null) {
        return self::insertProper($id, $data, $labels, false);
    }

    /** @unsupported @internal
     * Put something into the cache if it's not already there.
     * This method is only public because XN_Cache_Entry needs access to it. Do 
     * not call it from outside of XN_Cache or XN_Cache_Entry. It may change
     * or be removed at any time.
     * 
     * @param $id string ID for the cache entry
     * @param $data string Data to cache
     * @param $labels string|array optional cache entry labels. Can either be
     *        a single string label or an array of string labels
     * @param $returnEntryOnConflict Whether to return an XN_Cache_Entry if
     *        the insertion failed because the entry was already in the cache,
     *        or just false.
     * @return bool  true if the insertion succeeded, false if the entry was
     *               already there
     */
    public static function insertProper($id, $data, $labels,
                                        $returnEntryOnConflict = false) {
        // complain if id isn't a scalar?
        $url = self::_buildUrl('id',$id);
        $body = serialize($data);
        if (strlen($body) > self::MAX_DATA_SIZE) {
            throw new XN_Exception("Data too big for cache ID $id -- max allowed size is " . self::MAX_DATA_SIZE . " bytes", 413);
        }
        $headers = array();
        if (! is_null($labels)) {
            // @todo check label syntax (no ,), trim
            if (is_array($labels)) {
                if (count($labels)) {
                    $headers['X-Ning-Cache-Labels'] = implode(',', $labels);
                }
            } else {
                $headers['X-Ning-Cache-Labels'] = $labels;
            }
        }

        // Allow the exception this might throw to bubble up
        try {
            XN_REST::post($url, $body, 'application/octet-stream', $headers);
            return true;
        } catch (XN_Exception $e) {
            // 405 Method Not Allowed means "this was already in the cache"
            if ($e->getCode() == 405) {
                if ($returnEntryOnConflict) {
                    // The item is already present, so we need to retrieve it
                    // to provide it back to the caller
                    $item = self::getEntry($id);
                    // Item was re-deleted between the insert try and this get?
                    if (! ($item instanceof XN_Cache_Entry)) {
                        $item =  XN_Cache_Entry::create(array('Id' => $id,
                                                              'Version' => 0), null);
                    }
                    return $item;
                } else {
                    return false;
                }
            }
            // Anything else is a more serious error
            else {
                throw $e;
            }
        }
    }
 
 
    /**
     * Remove some thing(s) from the cache
     *
     * @param $ids string|array Either a single string cache ID or an array of
     *        string cache IDs. Can also be the constant XN_Cache::ALL to remove
     *        everything in the cache.
     */
    public static function remove($ids) {
        if ((! is_array($ids)) && ($ids == self::ALL)) {
            $url = self::_buildUrl(null,null);
        } else {
            $url = self::_buildUrl('id',$ids);
        }
        try {
            $rsp = XN_REST::delete($url);
        } catch (XN_Exception $e) {
            // 404 == didn't remove anything
            if ($e->getCode() != 404) {
                throw $e;
            }
        }
    }

    /**
     * Invalidate some thing(s) from the cache by label
     *
     * @param $labels string|array Either a single string label or an array of
     *        string labels.
     */
    public static function invalidate($labels) {
        $url = self::_buildUrl('label',$labels);
        try {
            $rsp = XN_REST::delete($url);
        } catch (XN_Exception $e) {
            // 404 == didn't remove anything
            if ($e->getCode() != 404) {
                throw $e;
            }
        }
    }
}

/**
 * The XN_Cache_Entry class is used for working with version-aware
 * cache entries.
 *
 * @ingroup XN
 */
class XN_Cache_Entry {
    protected $data = array('id' => null,
                            'labels' => array(),
                            'value' => null,
                            'version' => null);

    /** @unsupported @internal
     * Populate the internal $data array and make sure ID is set
     *
     * @param $headers array The headers from the cache entry server reply
     * @param $value mixed The value for the cache entry
     */
    protected function __construct($headers, $value) {
        foreach ($headers as $k => $v) {
            $lower_k = strtolower($k);
            if (array_key_exists($lower_k, $this->data)) {
                if ($lower_k == 'labels') {
                    $v = explode(',', $v);
                }
                else if ($lower_k == 'version') {
                    $v = (int) $v;
                }
                $this->data[$lower_k] = $v;
            }
        }
        $this->data['value'] = $value;
        if (! isset($this->data['id'])) {
            throw new Exception("No ID provided for XN_Cache_Entry");
        }
    }

    /**
     * @unsupported @internal
     *
     * To be called only by XN_Cache::_itemsFromCacheReply() for creating
     * entries.
     *
     * @param $headers array of cache reply headers + values
     * @param $value mixed the cache entry value
     * @return XN_Cache_Entry
     */
    public static function create($headers, $value) {
        return new XN_Cache_Entry($headers, $value);
    }

    /**
     * All properties are readable
     *
     * @param $property string property to read
     * @return mixed
     */
    public function __get($property) {
        if (array_key_exists($property, $this->data)) {
            return $this->data[$property];
        }
        else {
            throw new Exception("Unknown XN_Cache_Entry property: $property");
        }
    }

    /**
     * Value and labels are writeable
     *
     * @param $property string property to set
     * @param $value mixed new value to set
     */
    public function __set($property, $value) {
        switch ($property) {
        case 'value':
            $this->data[$property] = $value;
            break;
        case 'labels':
            /* Labels should always be an array */
            if (! is_array($value)) { $value = array($value); }
            $this->data[$property] = $value;
            break;
        default:
            throw new Exception("XN_Cache_Entry property $property is not settable");
        }
    }

    /**
     * Save the cache entry, with automatic conflict resolution if 
     * a callback is specified.
     *
     * If the version number in the entry is equal to the version
     * number of the entry in the cache, the cache is updated, the
     * version number in the cache and in the entry object is updated,
     * and the method returns true.
     *
     * If the version number in the entry doesn't match the version
     * number of the entry in the cache (either the cache contains a
     * newer entry or the item has been deleted from the cache, then
     * the method returns a new XN_Cache_Entry object. This new
     * XN_Cache_Entry object contains the up-to-date info from the
     * cache (version number, labels, value) and so can then be
     * manipulated so that conflicts are resolved and re-saved. If the
     * item had been deleted from the cache, there's no up-to-date
     * info from the cache to use, so the returned XN_Cache_Entry
     * object will have a version of 0, a null value, and no labels.
     *
     * If anything else goes wrong with the save, the method throws an
     * exception.

     * If $conflictCallback is specified, then it will be called if
     * the put produces a conflict, either entry-has-been-deleted or
     * entry-version-doesn't-match. The conflict callback should
     * accept two arguments: the first is the original object that you
     * attempted to save; the second is the up-to-date object from the
     * cache. The conflict callback should modify the up-to-date
     * object to get it into a ready-to-save state and then return
     * that object.
     * 
     * put() will then attempt to save the returned object. If there's
     * a conflict again, the conflict callback will be invoked
     * again. This time the first argument is the object that we
     * attempted to save (the updated one returned from the first
     * invocation of the callback) and the second argument is the one
     * representing the up-to-date state when the second save was
     * attempted.
     *
     * This reinvocation of the conflict callback is attempted up to
     * $maxTries times. $maxTries defaults to 5 if not specified. If there
     * are still conflicts after retrying $maxTries times, then put() returns
     * false.
     * 
     * The conflict callback can also return false to indicate "stop with the
     * looping and cache operations." When this happens, the iteration stops
     * and put() returns true. The conflict callback can also throw an
     * Exception. If this happens, iteration stops and the exception
     * percolates up.
     *
     * If an exception due to something other than a version conflict is
     * thrown by put(), the conflict callback is not invoked and the
     * exception percolates up.
     *
     * @param $conflictCallback callable Optional callback function to
     *  use for conflict resolution
     * @param $maxRetries integer Optional limit on the number of retries
     *  for saving after conflict resolution
     * @return boolean|XN_Cache_Entry
     */
    public function put($conflictCallback = null, $maxRetries = 5) {
        /* If a conflict callback was specified, loop while calling it
         * to attempt to resolve conflicts */
        if (isset($conflictCallback)) {
            if (! is_callable($conflictCallback, false, $callableName)) {
                throw new XN_IllegalArgumentException("$callableName is not callable");
            }
            $tries = 0;
            $entryToSave = $this;
            // $maxRetries is the number of times to retry the save after the
            // first one fails, so the while() comparison is <=, not <
            while ($tries <= $maxRetries) {
                // Try to save the entry. No conflict callback is passed in to
                // just get the regular saving behavior
                if ($entryToSave->version == 0) {
                    $putResult = $entryToSave->insert();
                } else {
                    $putResult = $entryToSave->put();
                }
                // If that worked, we're done
                if ($putResult === true) {
                    return true;
                } 
                // If it didn't work, there was a conflict
                if ($putResult instanceof XN_Cache_Entry) {
                    // Give the conflict callback the entry we tried to save
                    // and the result of saving it (the most up-to-date version)
                    $entryToSave = call_user_func($conflictCallback, $entryToSave, $putResult);
                    // The conflict callback can return false to stop
                    // the looping
                    if ($entryToSave === false) {
                        return true;
                    }
                }
                $tries++;
            }
            // If we've gotten here, then a successful save wasn't possible
            // after all the retries
            return false;
        }

        // No conflict callback set, just regular save attempt
        $r = XN_Cache::putProper($this->id, $this->value, $this->labels, $this->version);
        if ($r instanceof XN_Cache_Entry) {
            return $r;
        } else {
            $this->data['version'] = $r;
            return true;
        }
    }
    
    /**
     * Insert the entry into the cache.
     *
     * @return bool|XN_Cache_Entry Returns true if the insertion succeeds, or
     *  an XN_Cache_Entry (containing the most up-to-date cache entry) if there
     *  is already a cache entry with the given ID
     */
    public function insert() {
        return XN_Cache::insertProper($this->id, $this->value, $this->labels, true);
    }
}

} // class_exists()

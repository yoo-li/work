<?php
/**
 * An variation of XN_Query that caches query results
 *
 *  When to use XG_Query vs. XN_Query:
 *
 *   - Is the query run infrequently? (e.g. adding/deleting content). Use XN_Query.
 *   - Does the query have a FRIENDS() filter? (e.g. addVisibilityFilter).
 *     Use XG_Query with XG_QueryHelper::setMaxAgeForFriendsQuery()
 *   - Is one of the filters "order N"? That is, does the number of possibilities for the filter
 *     scale with the amount of content or the number of members? (e.g. username, content ID,
 *     various $_GET values). Use XG_Query *IF* XG_Cache::cacheOrderN() - this is a config setting.
 *   - Otherwise, use XG_Query.
 *
 *   - If in doubt, use XN_Query.
 *
 *   TODO: Rename this class to XG_CachedQuery (see Clearspace DOC-2081) [Jon Aquino 2008-09-11]
 */
XG_App::includeFileOnce('/XN/XG_Cache.php');
XG_App::includeFileOnce('/XN/XG_LockHelper.php');
XG_App::includeFileOnce('/XN/XG_CachedQuery.php');
class XG_Query {
    /**
     * Cached value what version of XG_Query to use
     *  @var	bool
     */
	protected static $versionToUse = NULL;

    /**
	 *  XG_Query can automatically cache the totalCount results if this number exceeds some threshold.
	 *  These constants specify this threshold and maxAge for the count.
	 *
	 *  This mode is turned on by default and can be changed using cacheTotalCount() call.
     */
	protected static $autoCountCacheThreshold	= 1000;
	protected static $autoCountCacheMaxAge		= 300;

    /**
     * The  actual XN_Query object is stored as a property of XG_Query
     * rather than having XG_Query extend XN_Query so that the XG_Query
     * constructor can accept an XN_Query object and cache its operations.
     */
    protected $_query = null;

    /**
	 * 	Result expiaration period. Default is forever.
	 *
     *  @var	int
     */
    protected $_maxAge = null;

    /**
	 * 	totalCount cache settings:
	 *  	false		Disable total count caching
	 *  	int			Cache total count for this period of time
	 *  	'auto'		Automatically cache total count depends on the number of returned rows.
	 *
     *  @var	mixed
     */
	protected $_cacheTotalCount = 'auto';

    /**
     * 	Invalidation labels
     *
     *  @var    string|[string]
     */
    protected $_keys = array();

    /**
     * 	Cached results. NULL if query wasn't executed.
     *  @var	{} | NULL
     */
    protected $_cachedResults = null;

    /**
	 * Creation and construction works a bit differently so we can store the
     * XN_Query object internally
     */
    public static function create($subjectOrQuery) {
    	/*if (NULL === self::$versionToUse) {
			self::$versionToUse = W_Cache::getWidget('main')->config['useXgCachedQuery'] ? 'new' : 'old';
		}*/
		if (!is_object($subjectOrQuery) && $subject != 'Content') {
			return new XG_Query($subjectOrQuery);
		}
		return self::$versionToUse == 'new' ? XG_CachedQuery::create($subjectOrQuery) : new XG_Query($subjectOrQuery);
    }
    /**
	 *  Checks whether query is a cached query or not. We should never use "instanceof".
     *
	 *  @param  $query   object    XN_Query or cached query
	 *  @return bool
	 */
	public static function isCached($query) {
		return ($query instanceof XG_Query) || ($query instanceof XG_CachedQuery);
    }


    /**
     * Invalidate thing(s) from the cache. The argument(s) can be XG_Query objects, XN_Query
	 * objects or string invalidation keys
     *
     * @param mixed ... What to invalidate
     */
    public static function invalidateCache() {
		$list = array();
        foreach (func_get_args() as $arg) {
            if (is_array($arg)) {
                call_user_func_array(array('XG_Query', 'invalidateCache'), $arg);
			} else if ($arg instanceof XG_Query) {
				XN_Cache::remove(self::_cacheId($arg->_query->_toAtomEndpoint()));
			} else if ($arg instanceof XG_CachedQuery) {
				$arg->invalidate();
            } else if ($arg instanceof XN_Query) {
				XN_Cache::remove(self::_cacheId($arg->_toAtomEndpoint()));
            } else {
				$list[] = $arg;
            }
        }
        if ($list) {
			XN_Cache::invalidate($list);
		}
    }

    protected function __construct($subjectOrQuery) {
        if ($subjectOrQuery instanceof XN_Query) {
            $this->_query = $subjectOrQuery;
        } else {
            $this->_query = XN_Query::create($subjectOrQuery);
        }
    }

	/**
     * XN_Query methods that get special handling. They must be defined as
     * all lowercase in the array so that mixed-case invocation works.
     */
     protected static $methods = array(
        /** These methods get proxied over to the XN_Query instance or have saved results
          * returned if the results are cached */
        'proxyCached' => array('getresultfrom' => true, 'getresultto' => true, 'getresultsize' => true, 'gettotalcount' => true),
        /** These methods are proxied, but static */
        'proxyStatic' => array('friends' => true),
        /** These methods get proxied over but then we return $this instead of the method's return value
          * (which is the XN_Query instance) */
        'returnThis' => array('filter' => true,'order' => true,'rollup' => true,'begin' => true,'end' => true,'alwaysreturntotalcount' => true),
        /** These methods get proxied over, but wrapped with caching logic */
        'cache' => array('execute' => true, 'uniqueresult' => true)
        );

    public function __call($method, $args) {
        $lowercaseMethod = strtolower($method); /* @non-mb */
        // This if/else chain is arranged in rough order of use frequency
        if (isset(self::$methods['returnThis'][$lowercaseMethod])) {
            $this->_query = call_user_func_array(array($this->_query, $method), $args);
            return $this;
        }
        else if (isset(self::$methods['cache'][$lowercaseMethod])) {
            return $this->executeCached($method, $args);
        }
        else if (isset(self::$methods['proxyCached'][$lowercaseMethod])) {
            if ($this->_cachedResults) {
                $property = substr($lowercaseMethod, 3); /* @non-mb */
                return $this->_cachedResults[$property];
            } else {
                return call_user_func(array($this->_query, $method));
            }
        }
        else if (isset(self::$methods['proxyStatic'][$lowercaseMethod])) {
            return call_user_func_array(array('XN_Query', $method), $args);
        }
        throw new XG_Exception("Unknown method: XG_Query::$method");
    }

    //
	public function __clone() { # void
		$this->_query = clone $this->_query;
    }


    /**
     * Methods that are copies of those in XN_Query, but that we need to duplicate
     * here so that "$this" refers to the XG_Query object rather than the internal
     * XN_Query object stored in $this->_query
	 **/
    public function debugString() {
		$debugString = $this->_query->debugString() . "\nXG_Query:\n" .
              "  maxAge [" . $this->_maxAge . "]\n".
              "  keys [" . implode(', ', $this->_keys) . "]\n" .
			  "  state [" . (is_null($this->_cachedResults) ? 'not executed' : (!$this->_cachedResults['loaded'] ? 'cached' : 'executed')) . "]";
        return $debugString;
    }

    public function debugHtml() {
        return '<pre>' . xnhtmlentities($this->debugString()) . '</pre>';
    }

   /** New public methods to support cache-related options */

    /**
	 *  Turns on and off total count caching. $value can be:
	 *  	false		Disable total count caching
	 *  	int			Cache total count for this period of time
	 *  	'auto'		Automatically cache total count depends on the number of returned rows.
	 *  				See class constants.
     *
     *  @param      $mode   mixed    Total count caching mode
     *  @return     XG_Query
     */
    public function cacheTotalCount($mode) {
		$this->_cacheTotalCount = $mode;
        return $this;
    }


   /**
    * Specify the max age of a cached result that the caller is willing to accept
    *
    * @param $maxAge integer How old can an otherwise matching cached result be and
    *                        still be considered valid?
    * @return XG_Query Returns $this for method chaining
    */
    public function maxAge($maxAge) {
        $this->_maxAge = $maxAge;
        return $this;
    }

    /**
     * Return the max age allowable for the current query
     *
     * @return integer
     */
	public function getMaxAge() {
    	return $this->_maxAge;
	}

    /**
     * Specify one or more invalidation keys to be added on to the list that
     * goes with the cached result
     *
     * @param $keys mixed One or more strings or arrays of strings of invalidation keys
     * @return XG_Query Returns $this for method chaining.
     */
	public function addCaching() {
		foreach (func_get_args() as $arg) {
			if (is_array($arg)) {
				call_user_func_array(array($this, addCaching), $arg);
			} else {
				$this->_keys[] = $arg;
			}
		}
		return $this;
    }

    public function setCaching() {
        $args = func_get_args();
        return call_user_func_array(array($this, 'addCaching'), $args);
    }

    /**
     * Return the invalidation keys attached to the cached result
     *
     * @return array
     */
	public function getCaching() {
    	return $this->_keys;
	}

    /**
     * keys -- what happens if you specify keys a and b and there is a cached copy
     * that matches but has keys c and d (or a and c) -- do you get the cached result?
     * does a new cached result get saved?
     */
    protected function executeCached($methodName, $methodArgs) {
		$queryUrl = $this->_query->_toAtomEndpoint();
		// To reused the cached totalCount for the similiar queries we need to remove order/begin/end from the cache key.
		list($baseUrl, $args) = self::_parseAtomUrl($queryUrl);

		$queryKey = self::_cacheId($queryUrl);
		$countKey = self::_cacheId("$baseUrl:count");

		// If query doesn't need totalCount or totalCount caching is disabled, use simple logic
		if ($this->_cacheTotalCount === false || $args['count'] == 'false') {
			if ($this->_cachedResults = XG_Cache::get($queryKey, $this->_maxAge)) {
				return $this->_cachedResults['results'];
			}
			$totalCount = NULL;
			$useTotalCount = false;
		} else {
			if ($this->_cachedResults = XG_Cache::get($queryKey, $this->_maxAge)) {
				// If query has too many rows, try to get updated totalCount
				if ($this->_cacheTotalCount === 'auto' && $this->_cachedResults['totalcount'] > self::$autoCountCacheThreshold) {
					// And if we have it, we consider it as more consistent across different query variations
					if ($totalCount = XN_Cache::get($countKey, self::$autoCountCacheMaxAge)) {
						$this->_cachedResults['totalcount'] = $totalCount;
					}
				}
				return $this->_cachedResults['results'];
			}
			$totalCount = XN_Cache::get($countKey, $this->_cacheTotalCount === 'auto' ? self::$autoCountCacheMaxAge : $this->_cacheTotalCount);
			$useTotalCount = true;
		}
		// Ok, we have to execute it
		if ($useTotalCount && $totalCount) {
			$this->_query->alwaysReturnTotalCount(FALSE);
		}
		$results = call_user_func_array(array($this->_query, $methodName), $methodArgs);
		try {
			$data = array(
				'results' => $results,
				'resultfrom' => $this->_query->getResultFrom(),
				'resultto' => $this->_query->getResultTo(),
				'resultsize' => $this->_query->getResultSize(),
				'totalcount' => null,
			);
		} catch (Exception $e) {
			return $results; // BAZ-13366 [Andrey 2009-02-19]
		}
		if ($useTotalCount) {
			if ($totalCount) {
				$data['totalcount'] = $totalCount;
			} else {
				// Swallow exception if total count isn't provided
				try { $data['totalcount'] = $this->_query->getTotalCount(); } catch (Exception $e) { }
				if ($this->_cacheTotalCount !== 'auto' || $data['totalcount'] > self::$autoCountCacheThreshold) {
					XN_Cache::put($countKey, $data['totalcount']);
				}
			}
		}
		// Put data into cache and release the lock
		XG_Cache::put($queryKey, $data, count($this->_keys) ? $this->_keys : null);
		$data['loaded'] = true;
		$this->_cachedResults = &$data;
		return $this->_cachedResults['results'];
    }

	// Parses Atom URL to the baseUrl and query parameters
	protected static function _parseAtomUrl($url) { #
		$pos = strrpos($url,'?'); /* @non-mb */
		parse_str(substr($url, $pos+1), $args); /* @non-mb */
		return array(substr($url, 0, $pos), $args); /* @non-mb */
    }

    protected static function _cacheId($string) {
        /* BAZ-5745: make sure cache ID doesn't grow too long */
        if (strlen($string) > 2000) {
            XG_LogHelper::error_log("Truncating long query cache ID: $string");
			$string = substr($string, 0, 1968) . md5($string); /* @non-mb */
        }
        return $string;
    }

//** New extended interface
	public function minAge($minAge) {
		// do nothing
		return $this;
	}

	public function labels() {
    	$args = func_get_args();
		return call_user_func_array(array($this, 'addCaching'), $args);
	}

	public function autoLabels() {
		// do nothing
		return $this;
	}

	public function autoLabelsPrefix() {
		// do nothing
		return $this;
	}

    public function oldAddCaching() {
    	$args = func_get_args();
		return call_user_func_array(array($this, 'addCaching'), $args);
    }
}

<?php
/**
 * An variation of XN_Query that caches query results (in a smart way)
 ** CACHING **
 *
 *	Supported caching options:
 *		maxAge					Cache no longer than N seconds (default is forever)
 *		minAge					Cache no less than for N seconds (no matter if any label is invalidated, etc)
 *		cacheTotalCount			Cache total count separately and disable count=true if count is found.
 *		labels					Add manual invalidation labels to the query
 *		autoLabels				Turn on/off query parsing and add extra auto labels
 *		autoLabelsPrefix		Sets the prefix for all auto labels
 *
 ** IMPLEMENTATION DETAILS **
 *
 *	Cache keys that exceed the max allowed length are shortened to [LENGTH-32] + md5(key)
 *
 *	The main changes in the new format:
 *		- keys are limited to 128 chars vs 2000.
 *		- hostname is removed from the key
 *		- all entries now include "created" field, because we fetch all required query keys in 1 request and we can't specify different
 *	      maxAge values for different keys, so we set maxAge to the maximum value and then check "created" value for returned keys.
 *
 *	Cache entries format:
 *	  * Data cache entry (new format):
 *	  	KEY: Query URL (w/o hostname) [128]
 *	  	DATA: {ids: [id], created:int, from:int, to:int, size:int, total:int}
 *	  	LABELS: ->addCaching()
 *	  	MAX-AGE: ->maxAge()
 *
 *	  * Data cache entry (old format):
 *	    KEY: Query URL (w/ hostname) [2000]
 *	  	DATA: [created, {results: [object], resultfrom:int, resultto:int, resultsize:int, totalcount:int}]
 *	  	LABELS: ->addCaching()
 *	  	MAX-AGE: ->maxAge()
 *
 *	  * Total count entry (new format):
 *	    KEY: Query URL w/o hostname w/o query_string [128] + ":count"
 *	    DATA: {count: int, created: int}
 *	    LABELS: n/a
 *	  	MAX-AGE: ->_cacheTotalCount | const
 *
 *	  * The backup data entry (there is no old format):
 *	  	KEY: Query URL (w/o hostname) [128] + ":min-age"
 *	  	DATA: {ids: [id], created:int, from:int, to:int, size:int, total:int}
 *	  	LABELS: n/a
 *	  	MAX-AGE: ->minAge()
 *
 *	In 3.14:
 *		- we will support reading cache entries in the old format, but we will write into the new format.
 *		- we still will invalidate old labels, but we will stop adding them to cached queries
 *	In 3.15:
 *		- we can remove old format reading support.
 *		- we can stop invalidating old labels
 */

XG_App::includeFileOnce('/XN/XG_LockHelper.php');
XG_App::includeFileOnce('/XN/XG_CachedQueryAutoLabelsHelper.php');

class XG_CachedQuery {
    /**
	 *  XG_CachedQuery can automatically cache the totalCount results if the number of returned rows exceeds some threshold.
	 *  These constants specify this threshold and maxAge for the total count cache.
	 *
	 *  These variables are used only when _cacheTotalCount === 'auto'
     */
	protected static $autoTotalCountCacheThreshold = 1000;
	protected static $autoTotalCountCacheMaxAge = 300;

    /**
     * The  actual XN_Query object is stored as a property of XG_CachedQuery
     * rather than having XG_CachedQuery extend XN_Query so that the XG_CachedQuery
     * constructor can accept an XN_Query object and cache its operations.
     */
    protected $_query = NULL;

    /**
	 * 	Result expiaration period. Default is forever.
	 *
     *  @var	int
     */
    protected $_maxAge = NULL;

    /**
	 *	Specifies the minimum period of time for the query to be cached. Even if one of the labels is invalidated,
	 *	query still remains cached. Default is 0 (no minimum period). NULL means 0 (no minimum period).
     *
     *  @var    int
     */
	protected $_minAge = 0;

    /**
     * 	Invalidation labels
     *
     *  @var    string|[string]
     */
    protected $_labels = array();

    /**
	 * 	AutoLabels prefix. See XG_CachedQueryAutoLabelsHelper
	 *  @var    mixed
     */
	protected $_autoLabelsPrefix = NULL;

    /**
	 * 	Turns on and off the adding of all used query attributes to the list of automatic labels. See XG_CachedQueryAutoLabelsHelper
     *  @var	bool
     */
	protected $_autoLabelsFromQuery = true;

    /**
	 * 	The list of extra automatic labels.
     *  @var    bool
     */
    protected $_autoLabels = array();


    /**
	 * 	The separate totalCount cache settings:
	 *  	false		Disable total count caching
	 *  	int			Cache total count for this period of time
	 *  	'auto'		Automatically cache total count depends on the number of returned rows. See variables below.
	 *
     *  @var	int|string|bool
     */
	protected $_cacheTotalCount = 'auto';
	protected $_totalCount = NULL; // temporary storage for totalCount

    /**
     * 	Cached results. NULL if query wasn't executed.
     *  @var	{ids, created, from, to, size, total, data, source} | NULL
     */
    protected $_cachedResults = NULL;

    /**
	 * Creation and construction works a bit differently so we can store the
     * XN_Query object internally
     */
    public static function create($subjectOrQuery) {
        return new XG_CachedQuery($subjectOrQuery);
    }

    /**
     * Invalidate thing(s) from the cache. The argument(s) can be XG_CachedQuery objects, XN_Query
	 * objects or string invalidation labels
     *
     * @param mixed ... What to invalidate
     */
    public static function invalidateCache() {
		$list = array();
        foreach (func_get_args() as $arg) {
            if (is_array($arg)) {
                call_user_func_array(array('XG_CachedQuery', 'invalidateCache'), $arg);
			} elseif (is_object($arg)) {
				if ($arg instanceof XG_CachedQuery) {
					$info = self::_queryUrlInfo($arg->_query);
            	} else if ($arg instanceof XN_Query) {
					$info = self::_queryUrlInfo($arg);
				} else {
					throw new XG_Exception("Unsupported argument to ".__METHOD__.": ".get_class($arg));
				}
				XN_Cache::remove(array_values($info['keys']));
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
		'getresultfrom' => 'proxyCached',
		'getresultto' => 'proxyCached',
		'getresultsize' => 'proxyCached',
		'gettotalcount' => 'proxyCached',

		'friends' => 'proxyStatic',

		'filter' => 'returnThis',
		'order' => 'returnThis',
		'rollup' => 'returnThis',
		'begin' => 'returnThis',
		'end' => 'returnThis',
		'alwaysreturntotalcount' => 'returnThis',

		'execute' => 'cache',
		'uniqueresult' => 'cache'
	);

    public function __call($method, $args) {
        $lowercaseMethod = strtolower($method); /* @non-mb */
        switch (self::$methods[$lowercaseMethod]) {
			case 'returnThis': // These methods get proxied over but then we return $this instead of the method's return value
	            call_user_func_array(array($this->_query, $method), $args);
    	        return $this;
			case 'cache': // These methods get proxied over, but wrapped with caching logic
	            $this->_executeCached($method, $args);
				if ($lowercaseMethod == 'uniqueresult') {
					return $this->_cachedResults['data'][0];
				}
				return $this->_cachedResults['data'];
			case 'proxyCached': // These methods get proxied over to the XN_Query instance or have saved results returned if the results are cached
				if ($this->_cachedResults === NULL) {
					return call_user_func(array($this->_query, $method));
				}
				switch ($lowercaseMethod) {
					case 'getresultfrom': return $this->_cachedResults['from'];
					case 'getresultto': return $this->_cachedResults['to'];
					case 'getresultsize': return $this->_cachedResults['size'];
					case 'gettotalcount':
						if ($this->_cachedResults['total'] !== NULL) {
							return $this->_cachedResults['total'];
						}
						throw new XG_Exception("Cannot call getTotalCount() if alwaysReturnTotalCount is false");
				}
				break;
			case 'proxyStatic': // These methods are proxied, but static
	            return call_user_func_array(array('XN_Query', $method), $args);
		}
        throw new Exception("Unknown method: XG_CachedQuery::$method");
    }

	public function __clone() { # void
		$this->_query = clone $this->_query;
    }

    /**
	 *  Invalidates the cache for itself
     *
	 *  @return     XG_CachedQuery
     */
    public function invalidate() {
		$info = self::_queryUrlInfo($this->_query);
		XN_Cache::remove(array_values($info['keys']));
		return $this;
    }

    /**
     * Methods that are copies of those in XN_Query, but that we need to duplicate
     * here so that "$this" refers to the XG_CachedQuery object rather than the internal
     * XN_Query object stored in $this->_query
	 **/
    public function debugString() {
		$debugString = $this->_query->debugString() . "\nXG_CachedQuery:\n" .
              "  maxAge [" . ($this->_maxAge === NULL ? 'no' : $this->_maxAge). "]\n".
			  "  minAge [" . ($this->_minAge ? $this->_minAge : 'no') . "]\n" .
			  "  labels [" . join(', ', $this->_labels) . "]\n" .
			  "  totalCount [" . ($this->_cacheTotalCount === false ? 'disabled' : ($this->_cacheTotalCount)) . "]\n" .
			  "  state [" . (is_null($this->_cachedResults) ? 'not executed' : $this->_cachedResults['source']) . "]";
        return $debugString;
    }

    public function debugHtml() {
        return '<pre>' . xnhtmlentities($this->debugString()) . '</pre>';
    }

//** Public methods to support cache-related options
    /**
	 *  Turns on and off total count caching. $value can be:
	 *  	false		Disable total count caching
	 *  	int			Cache total count for this period of time
	 *  	'auto'		Automatically cache total count for self::$autoTotalCountCacheMaxAge if the number of returned
	 *  				rows exceeds self::$autoTotalCountCacheThreshold
     *
     *  @param      $mode   mixed    Total count caching mode
     *  @return     XG_CachedQuery
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
    * @return XG_CachedQuery
    */
    public function maxAge($maxAge) {
        $this->_maxAge = $maxAge;
        return $this;
    }

    /**
	 *  Sets the minimum amount of time query should remain cached even if one of the invalidation labels is invalidated.
	 *  After this period of time, cache behavior will fall back to normal
     *
	 *  @param      $minAge   int	Number of seconds
     *  @return     XG_CachedQuery
     */
	public function minAge($minAge) {
		$this->_minAge = $minAge;
        return $this;
    }

    /**
	 *  Adds one or more invalidation labels to the query. Usually it's not required and the automatic labels is a preferred way.
     *
	 *  @param      ...   string|array    Invalidation labels
     *  @return     XG_CachedQuery
     */
    public function labels() {
		foreach (func_get_args() as $arg) {
			if (is_array($arg)) {
				call_user_func_array(array($this, 'labels'), $arg);
			} else {
				$this->_labels[] = $arg;
			}
		}
		return $this;
    }

    /**
	 * 	If the first argument is boolean, it turns on and off the adding of all used query attributes to the list of automatic labels.
	 * 	Other arguments are treated as extra automatic labels. See XG_CachedQueryAutoLabelsHelper for details.
     *
	 *	@param	...		AUTOLABEL		The extra automatic labels
     *  @return     XG_CachedQuery
     */
    public function autoLabels() {
    	$args = func_get_args();
		if ($args && is_bool($args[0])) {
			$this->_autoLabelsFromQuery = array_shift($args);
		}
		$this->_autoLabels = array_merge($this->_autoLabels, $args);
    	return $this;
    }

    /**
	 *  Sets the automatic labels prefix. See XG_CachedQueryAutoLabelsHelper for details.
     *
	 *	@param	$prefix		AUTOLABEL		Automatic label that is used as prefix.
     *  @return XG_CachedQuery
     */
    public function autoLabelsPrefix($prefix) {
		$this->_autoLabelsPrefix = $prefix;
        return $this;
    }

//** Deprecated methods (will be removed)
    public function oldAddCaching() {
		// gracefully ignore old calls
		return $this;
    }

	public function addCaching() {
		// gracefully ignore old calls
		return $this;
    }

	public function getCaching() {
    	return array();
	}

//** Implementation
    /**
	 *  Internal function to hook up unit tests
     *  @return     int
     */
    protected function _now() {
    	return time();
    }

    /**
     *  Returns the longest max-age value
     *  @return     int|NULL
     */
	protected function _longestMaxAge($ageA, $ageB) {
		return $ageA === NULL || $ageB === NULL ? NULL : ($ageA > $ageB ? $ageA : $ageB);
    }

    /**
     *  Checks whether "created" is expired according maxAge multiplied by factor
	 *  @return     bool
     */
	protected function _isExpired($created, $maxAge, $factor) {
		//var_dump("_isExpired(".$this->_now().",$created,$maxAge,$factor");
		return $maxAge === NULL ? false : ($this->_now() - $created >= $maxAge * $factor);
    }

    /**
     *  Returns the value of loaded cache entry if it exists and is not expired
	 *  @param		$entries	hash		The list of loaded cache keys
	 *  @param		$key		string		Key to look for
	 *  @param		$maxAge,$factor 		Expiration parameters. @see _isExpired
	 *  @return     bool
     */
	protected function _getEntry($entries, $key, $maxAge, $factor) { # hash
		return ($r =& $entries[$key]) && !$this->_isExpired($r['created'], $maxAge, $factor) ? $entries[$key] : NULL;
    }

    /**
	 *  Initializes the cached result structure.
     *
	 *  @param      $source		string		Where results were loaded from
	 *  @param		$info		hash		Data entry (new or old format)
	 *  @param		$objects	list		The actual objects (otherwise they're loaded by IDs)
     *  @return     void
     */
	protected function _setCachedResult($source, array $info, $objects = NULL) { # bool
		$info['source'] = $source;
		if ($info['total'] === NULL) {
			$info['total'] = $this->_totalCount;
		}
		if ($objects !== NULL) {
			$info['data'] = $objects;
		} elseif (isset($info['ids'])) { // IDs only (new format)
			$info['data'] = array();
			if ($info['ids']) {
				$objects = array();
				foreach (XG_Cache::content($info['ids']) as $o) {
					$objects[$o->id] = $o;
				}
				foreach ($info['ids'] as $id) { // Preserve the order and skip missing objects (were they deleted ?)
					if (isset($objects[$id])) {
						$info['data'][] = $objects[$id];
					}
				}
			}
		} elseif (isset($info['results'])) { // The actual object data (old format)
			$info['data'] = is_array($info['results']) ? $info['results'] : array($info['results']);
			$info['from'] = $info['resultfrom'];
			$info['to'] = $info['resultto'];
			$info['size'] = $info['resultsize'];
			$info['total'] = $info['totalcount'];
		} else {
			throw new XG_Exception("Cannot get the information about object IDs:" . var_export($info, true));
		}
		$this->_cachedResults =& $info;
        return true;
    }

    /**
     *  Prepares data for sending cache request
     *  @return     hash
     */
	protected function _prepareRequest() {
		$q = self::_queryUrlInfo($this->_query);
		$reqKeys = array();		// cache keys to send request for
		$reqMaxAge = 0;			// maxAge to specify (the longest amongst reqKeys)

		if (method_exists($this->_query, 'getAlwaysReturnTotalCount')) {
			$countEnabled = $this->_query->getAlwaysReturnTotalCount();
		} else {
			$countEnabled = preg_match('/count=true/i',$q['args']); /** @non-mb */
		}

		if ($countEnabled && $this->_cacheTotalCount !== false) { // If totalCount caching is enabled, add totalCount key
    		$reqKeys[] = $q['keys']['count'];
			$countAge = $this->_cacheTotalCount === 'auto' ? self::$autoTotalCountCacheMaxAge : $this->_cacheTotalCount;
			$reqMaxAge = $this->_longestMaxAge($reqMaxAge, $countAge);
		} else {
			$countAge = 0;
		}

		if ($this->_minAge) { // If minAge is specified, add the minAge key
			$reqKeys[] = $q['keys']['minAge'];
			$reqMaxAge = $this->_longestMaxAge($reqMaxAge, $this->_minAge);
		}
		$reqKeys[] = $q['keys']['data']; // Add the main cache entry
		$reqKeys[] = $q['keys']['dataOld']; // TODO: support old format
		$reqMaxAge = $this->_longestMaxAge($reqMaxAge, $this->_maxAge);

        return array(
        	'url' => $q['url'],
			'args' => $q['args'],
        	'keys' => $q['keys'],
			'reqKeys' => $reqKeys,
			'reqMaxAge' => $reqMaxAge,
			'countAge' => $countAge,
			'countEnabled' => $countEnabled,
		);
    }

    /**
	 *  Analyzes the loaded cache entries for the valid data
     *  @return     hash
     */
	protected function _parseEntries($c, $reqData, $factor) { # bool
		if ($c['countEnabled']) {
			$this->_totalCount = ($r = $this->_getEntry($reqData, $c['keys']['count'], $c['countAge'], $factor)) ? $r['count'] : NULL;
		}
		if ( $info = $this->_getEntry($reqData, $c['keys']['data'], $this->_maxAge, $factor) )  { // The main entry
			return $this->_setCachedResult('cached', $info);
		} elseif ( $info = $this->_getEntry($reqData, $c['keys']['minAge'], $this->_minAge, $factor) ) { // The minAge entry (if exists)
			return $this->_setCachedResult('cached(minAge)', $info);
		} elseif ( is_array( $info = @unserialize($reqData[ $c['keys']['dataOld'] ]) ) && !$this->_isExpired($info[0], $this->_maxAge, $factor) ) {
			 // TODO: old format
			return $this->_setCachedResult('cached(old)', $info[1]);
		}
		return false;
    }

    /**
     *  Loads the data from cache
     *  @return     void
     */
    protected function _executeCached($methodName, $methodArgs) {
    	$c = $this->_prepareRequest();
		$reqData = XN_Cache::get($c['reqKeys'], $c['reqMaxAge']);
		if ($this->_parseEntries($c, $reqData, 0.9)) {
			return;
		}
		if ($r = $reqData[$c['keys']['data']]) {
			XG_LogHelper::error_log("Cache key `".$c['keys']['data']."' is found, but considered expired ($r[created])");
		}
		// The data is about to expire or we we don't have the data at all
		$lockName = $c['keys']['data'] . ':lock';
		if (!$locked = XG_LockHelper::lock($lockName, 0)) { // If we can't lock, somebody else is updating it right now, just show the staled data
			if ($this->_parseEntries($c, $reqData, 1.1)) {
				return;
			}
		}

		if ($c['countEnabled'] && $this->_totalCount !== NULL) { // if totalCount is enabled and we already have the totalCount value, disable count
			$this->_query->alwaysReturnTotalCount(FALSE);
		}
		$objects = call_user_func_array(array($this->_query, $methodName), $methodArgs);
		try {
			$info = array(
				'created' => $this->_now(),
				'ids' => (array)xg_ids($objects),
				'from' => $this->_query->getResultFrom(),
				'to' => $this->_query->getResultTo(),
				'size' => $this->_query->getResultSize(),
			);
		} catch (Exception $e) {
			return $objects; // BAZ-13366 [Andrey 2009-02-19]
		}

		if ($c['countEnabled'] && $this->_totalCount === NULL) {
			$this->_totalCount = $this->_query->getTotalCount();
			if ($this->_cacheTotalCount === 'auto') {
				$cacheCount = ($this->_totalCount > self::$autoTotalCountCacheThreshold);
			} else {
				$cacheCount = ($this->_cacheTotalCount !== false);
			}
			if ($cacheCount) {
				XN_Cache::put($c['keys']['count'], array('created' => $this->_now(), 'count' => $this->_totalCount));
			}
		}

		if ($this->_minAge) {
			XN_Cache::put($c['keys']['minAge'], $info);
		}

		$this->_labels = array_merge($this->_labels, XG_CachedQueryAutoLabelsHelper::getLabels( array(
			'prefix' => $this->_autoLabelsPrefix,
			'extra' => $this->_autoLabels,
			'parseQuery' => $this->_autoLabelsFromQuery,
			'queryUrl' => $c['url'],
			'queryArgs' => $c['args'],
		) ) );

		$info['total'] = $this->_totalCount;
		XN_Cache::put($c['keys']['data'], $info, count($this->_labels) ? $this->_labels : NULL);
		if ($locked) {
			XG_LockHelper::unlock($lockName);
		}
		$this->_setCachedResult('executed', $info, is_array($objects) ? $objects : array($objects));
    }

    /**
	 *  Returns the key value cut to the maximum length
     *  @return     string
     */
	static protected function _hash($key, $length) { # string
		return strlen($key) <= $length ? $key : substr($key, 0, $length-32) . md5($key); /** @non-mb */
    }

    /**
	 *  Returns the information about the specified XN_Query object: all possible cache keys, url parameters, base url
     *  @return     hash
     */
	static protected function _queryUrlInfo(XN_Query $query) {
		$url = $query->_toAtomEndpoint();
		$urlNoHost = preg_replace('#^https?://[^/]+#', '', $url);
		if (preg_match('#^([^?]*)\?(.*)$#', $urlNoHost, $m)) {
			// To reuse the cached totalCount for the similar queries we need to remove count/order/begin/end from the cache key.
			$urlNoHostNoArgs = $m[1];
			$args = $m[2];
		} else {
			$urlNoHostNoArgs = $urlNoHost;
			$args = '';
		}
		return array(
			'url' => $urlNoHostNoArgs,
			'args' => $args,
			'keys' => array(
				'data' => self::_hash($urlNoHost, 128),
				'dataOld' => self::_hash($url, 2000),
				'count' => self::_hash($urlNoHostNoArgs, 128) . ':count',
				'minAge' => self::_hash($urlNoHost, 128) . ':min-age',
			)
		);
    }
}

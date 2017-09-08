<?php
 
if (! class_exists('XN_Query')) {
/** @oldhand */

/*
 *  * Returns an array of content objects owned by the current application of
 *  * a type equals-ignore-case "test" with a my->group attribute equal to
 *  * "front" and a my->rating attribute >= 0. The result array is ordered by
 *  * descending my->rating 
 *  {@*}
 * $contents = XN_Query::create('content')
 *    ->filter( 'type', 'eic', 'test' )
 *    ->filter( 'my->group', '=', 'front' )
 *    ->filter( 'my->rating', '>=', 0 )
 *    ->order( 'my->rating', XN_Order::DESC)
 *    ->execute();
 *
 * @ingroup XN
 */
class XN_Query {

    /** The operator for an 'equal' constraint. */
    const EQ = '=';
    /** The operator for a 'not-equal' constraint. */
    const NE = '<>';
    /** The operator for an 'equal-ignore-case' constraint. */
    const EIC = 'eic';
    /** The operator for a 'not-equal-ignore-case' constraint. */
    const NEIC = 'neic';
    /** The operator for a '<' constraint. */
    const LT = '<';
    /** The operator for a '<=' constraint. */
    const LE = '<=';
    /** The operator for a '>' constraint. */
    const GT = '>';
    /** The operator for a '>=' constraint. */
    const GE = '>=';
    /** The operator for a 'like' constraint. */
    const LIKE = 'like';
    /** The operator for an 'ignore-case like' constraint. */
    const LIKEIC = 'likeic';
    /** The operator for an 'in' constraint. */
    const IN = 'in';
    /** The operator for an '!in' constraint. */
    const NIN = '!in';

    /** The subject name for querying content objects. */
    const SUBJECT_CONTENT = 'Content';
    
    const SUBJECT_BIGCONTENT = 'BigContent';  
     
    const SUBJECT_BIGCONTENT_COUNT = 'BigContent_Count';
	
    const SUBJECT_MESSAGE = 'Message';  
     
    const SUBJECT_MESSAGE_COUNT = 'Message_Count';
    
    const SUBJECT_SIMPLECONTENT = 'SimpleContent'; 
     
    const SUBJECT_SIMPLECONTENT_COUNT = 'SimpleContent_Count';

	const SUBJECT_MAINCONTENT = 'MainContent'; 
     
    const SUBJECT_MAINCONTENT_COUNT = 'MainContent_Count';
	
	const SUBJECT_YEARCONTENT = 'YearContent'; 
     
    const SUBJECT_YEARCONTENT_COUNT = 'YearContent_Count';
	
	const SUBJECT_MAINYEARCONTENT = 'MainYearContent'; 
     
    const SUBJECT_MAINYEARCONTENT_COUNT = 'MainYearContent_Count';
	
	const SUBJECT_YEARMONTHCONTENT = 'YearmonthContent'; 
     
    const SUBJECT_YEARMONTHCONTENT_COUNT = 'YearmonthContent_Count';
	
	const SUBJECT_MAINYEARMONTHCONTENT = 'MainYearmonthContent'; 
     
    const SUBJECT_MAINYEARMONTHCONTENT_COUNT = 'MainYearmonthContent_Count';
	 
	const SUBJECT_PROFILE_COUNT = 'Profile_Count';

	const SUBJECT_MQ = 'Mq';
    
    const SUBJECT_FULLTEXT = 'FullText';
    
    const SUBJECT_FULLTEXT_COUNT = 'FullText_Count';
    
    /** The subject name for querying tag objects. */
    const SUBJECT_TAG = 'Tag';
    /**
     * The subject name for querying the counts of tag values. Tag_ValueCount
     * queries return an array in which each element's key is a tag value and
     * each element's value is a count of tags with the tag value.
     */
    const SUBJECT_TAG_VALUECOUNT = 'Tag_ValueCount';
    /** The subject name for querying content rollups */
    const SUBJECT_CONTENT_COUNT = 'Content_Count';

    /** The subject name for querying contacts */
    const SUBJECT_CONTACT = 'Contact';

    /** The subject name for querying invitations. */
    const SUBJECT_INVITATION = 'Invitation';

    /** The subject name for searching. */
    const SUBJECT_SEARCH = 'Search';

    /** The subject name for activity event feed queries */
    const SUBJECT_ACTIVITYEVENT = 'ActivityEvent';

    /** The subject name for member queries */
    const SUBJECT_MEMBER = 'Member';

    /** The subject name for application queries */
    const SUBJECT_APPLICATION = 'Application';

	const SUBJECT_PROFILE = 'Profile';

    private $subject;
    private $returnIds = false;
    private $begin = 0;
    private $tag = "";
    private $end;
    /** alwaysReturnTotalCount starts off as null so we can detect
     * when a caller explicitly changes it */
    private $alwaysReturnTotalCount = null;
    private $orders = array();
    private $filters = array('content' => array(),
                             'tag' => array(),
                             'rollup' => array(),
    						 'group' => array(),
                             'contact' => array(),
                             'invitation' => array(),
                             'message' => array(),
                             'search' => array(),
                             'activity' => array(),
                             'member' => array(),
                             'application' => array());
    private $resultFrom;
    private $resultTo;
    private $totalCount;


    /** Query subjects whose implementations are supported by separate
     * strategy classes */
    private static $strategySubjects = array('ActivityQueueUpdate' => true,
                                             'Person' => true);

    private static $_contentFilterMap = array('id' => true, 'createddate' => true,'author' => true,'key' => true,
    'updateddate' => true, 'type' => true, 'title' => true, 'description' => true,
    'isprivate' => true, 'owner' => true, 'owner.relativeurl' => true,
    'contributor' => true, 'contributorname' => true, 'contributor.screenname' => true, 'tag.value' => true,
    'tag.owner.screenname' => true, 'referencerid' => true,
	'year' => true,'yearmonth' => true,
    'published' => true, 'updated' => true, 'summary' => true, 'fulltext' => true);
    private static $_contentFilterRegex = '@^my\..+$@';
    private static $_tagFilterMap = array('content' => true, 'contentid' => true, 'content.id' => true,
    'value' => true, 'createddate' => true, 'updateddate' => true, 'owner' => true,
    'ownername' => true, 'owner.screenname' => true, 'content.owner' => true,'content.ownername' => true);
    private static $_tagValueCountFilterMap = array('content' => true, 'contentid' => true, 'content.id' => true,
                                                    'owner' => true, 'ownername' => true, 'owner.screenname' => true,
                                                    'content.owner' => true, 'content.ownername' => true, 'content.type' => true,
                                                    'content.contributor' => true, 'content.contributorname' => true);
    private static $_contactFilterMap = array('owner' => true, 'contact' => true, 'relationship' => true, 'updateddate' => true, 'application' => true);
    private static $_invitationFilterMap = array(
            'id' => array('=' => true),
            'recipient' => array('=' => true, 'like' => true, 'in' => true),
            'recipient.screenname' => array('=' => true),
            'recipient.pid' => array('=' => true),
            'application' => array('=' => true),
            'name' => array('=' => true, 'like' => true),
            'label' => array('=' => true, 'in' => true, '<>' => true),
            'author' => array('=' => true),
            'type' => array('=' => true, '!=' => true, 'in' => true),
                                                 );
    private static $_messageFilterMap = array('folder' => array('=' => true),
                                              'application' => array('=' => true),
                                              'read' => array('=' => true));
    private static $_invitationOrders = array('createddate' => 'published', 'name' => 'name', 'recipient' => 'recipient');
    private static $_contactOrders = array('updateddate' => 'updatedDate', 'name' => 'name', 'email' => 'email', 'contact' => 'ningId');

    private static $_activityEventFilterMap = array('user' => array('=' => true),
                                                    'application' => array('=' => true),
                                                    'type' => array('=' => true,
                                                                    'in' => true),
                                                    'author' => array('=' => true,
                                                                      'in' => true),
                                                    'originapplication' => array('=' => true,
                                                                                 'in' => true));
    
    private static $_memberFilterMap = array('application' => array('=' => true,
								    'in' => true),
                                             'user' => array('=' => true,
                                                             'in' => true));
    private static $_memberOrders = array();

    /* Also popular for application query (NING-10340) but it's not listed here since
     * it doesn't use any operators */
    private static $_applicationFilterMap = array('description' => array('=' => true),
                                                    'published' => array('=' => true,'>' => true,'<' => true,'>=' => true,'<=' => true,'!=' => true),
												    'trialtime' => array('=' => true,'>' => true,'<' => true,'>=' => true,'<=' => true,'!=' => true),
												    'storagespace' => array('=' => true,'>' => true,'<' => true,'>=' => true,'<=' => true,'!=' => true),
    												'remainstoragespace' => array('=' => true,'>' => true,'<' => true,'>=' => true,'<=' => true,'!=' => true),
     												'numberofusers' => array('=' => true,'>' => true,'<' => true,'>=' => true,'<=' => true,'!=' => true),
    												'numberofsmss' => array('=' => true,'>' => true,'<' => true,'>=' => true,'<=' => true,'!=' => true),
    												'remainnumberofsmss' => array('=' => true,'>' => true,'<' => true,'>=' => true,'<=' => true,'!=' => true),

                                                  '');
    
    private static $_applicationOrders = array("trialtime" => "trialtime","published" => "published","remainnumberofsmss" => "remainnumberofsmss","remainstoragespace" => "remainstoragespace");

    /**
     * Constructs a new XN_Query object for the given subject. The supported
     * subjects are given by the SUBJECT constants.
     *
     * @param $subject string specifies the subject of the query
     * @return XN_Query the XN_Query object
     */
    public static function create($subject){
        return new XN_Query($subject);
    }

    private function __construct($subject){
    	
        if (strcasecmp($subject ,self::SUBJECT_CONTENT) != 0 &&
            strcasecmp($subject, self::SUBJECT_BIGCONTENT) != 0 &&
            strcasecmp($subject, self::SUBJECT_BIGCONTENT_COUNT) != 0 &&
			strcasecmp($subject, self::SUBJECT_SIMPLECONTENT) != 0 &&
            strcasecmp($subject, self::SUBJECT_SIMPLECONTENT_COUNT) != 0 &&
			strcasecmp($subject, self::SUBJECT_MAINCONTENT) != 0 &&
            strcasecmp($subject, self::SUBJECT_MAINCONTENT_COUNT) != 0 &&
			strcasecmp($subject, self::SUBJECT_YEARCONTENT) != 0 &&
            strcasecmp($subject, self::SUBJECT_YEARCONTENT_COUNT) != 0 &&
			strcasecmp($subject, self::SUBJECT_MAINYEARCONTENT) != 0 &&
            strcasecmp($subject, self::SUBJECT_MAINYEARCONTENT_COUNT) != 0 &&
			strcasecmp($subject, self::SUBJECT_YEARMONTHCONTENT) != 0 &&
            strcasecmp($subject, self::SUBJECT_YEARMONTHCONTENT_COUNT) != 0 &&
			strcasecmp($subject, self::SUBJECT_MAINYEARMONTHCONTENT) != 0 &&
            strcasecmp($subject, self::SUBJECT_MAINYEARMONTHCONTENT_COUNT) != 0 &&
			strcasecmp($subject, self::SUBJECT_PROFILE_COUNT) != 0 &&
            strcasecmp($subject, self::SUBJECT_FULLTEXT) != 0 &&
            strcasecmp($subject, self::SUBJECT_FULLTEXT_COUNT) != 0 &&
			strcasecmp($subject, self::SUBJECT_MQ) != 0 &&
            strcasecmp($subject, self::SUBJECT_TAG) != 0 &&
            strcasecmp($subject, self::SUBJECT_MESSAGE) != 0 &&
            strcasecmp($subject, self::SUBJECT_MESSAGE_COUNT) != 0 &&
            strcasecmp($subject, self::SUBJECT_TAG_VALUECOUNT) != 0 &&
            strcasecmp($subject, self::SUBJECT_CONTENT_COUNT) != 0 &&
            strcasecmp($subject, self::SUBJECT_CONTACT) != 0 &&
            strcasecmp($subject, self::SUBJECT_INVITATION) != 0 &&
            strcasecmp($subject, self::SUBJECT_MESSAGE) != 0 &&
            strcasecmp($subject ,self::SUBJECT_SEARCH) != 0 &&
            strcasecmp($subject ,self::SUBJECT_ACTIVITYEVENT) != 0 &&
            strcasecmp($subject ,self::SUBJECT_MEMBER) != 0 &&
            strcasecmp($subject ,self::SUBJECT_APPLICATION) != 0 &&
			strcasecmp($subject ,self::SUBJECT_PROFILE) != 0 &&
            (! isset(self::$strategySubjects[$subject]))) {
            throw new XN_Exception(
                                   "Invalid query subject: $subject. Only 'Content',".
                                   "'Content_Count','Application','".implode("', '", array_keys(self::$strategySubjects))."' are supported");
        }
        $this->subject = $subject;
    } 
    /**
     * Filters the query with the given constraint. Multiple filters can be
     * applied to a query. See the {@link XN_Query} Class Details for the
     * properties applicable for each query subject.
     *
     * @param $prop string the property to apply the constraint
     * @param $operator string the constraint operator. The allowable operators
     * are given by the operator constants of this class.
     * @param $value mixed the constraint value. If the 'in' operator is used, this
     * value is an array.
     * @param $type string the type to treat the value as. Only useful for
     * scalar values
     * @return XN_Query the XN_Query object
     */
     public function filter() {
        $args = func_get_args();
        $argc = func_num_args();
        // If $args has no elements , then complain, since filter() can't be
        // called without any arguments. Issue a warning to maintain backwards
        // compatibility with filter() before it knew about subclauses
        if ($argc == 0) {
            trigger_error('Missing argument(s) for XN_Query::filter()', E_USER_WARNING);
        }
        // If $args has one element and that element is a filter clause, then
        // walk down the filter clause and convert everything to the right
        // values based on the query type
        else if (($argc == 1) && ($args[0] instanceof XN_Query_InternalType_FilterClause)) {
            // Subclauses are only allowed on Content queries or on other subjects that
            // allow them
        	if ((strcasecmp($this->subject,'Content') != 0) &&
				(strcasecmp($this->subject,'SimpleContent') != 0) &&
				(strcasecmp($this->subject,'MainContent') != 0) &&
				(strcasecmp($this->subject,'YearContent') != 0) &&
				(strcasecmp($this->subject,'MainYearContent') != 0) &&
				(strcasecmp($this->subject,'YearmonthContent') != 0) &&
				(strcasecmp($this->subject,'MainYearmonthContent') != 0) &&
                (strcasecmp($this->subject,'Profile') != 0) &&
				(strcasecmp($this->subject,'Search') != 0) &&
                (isset($this->strategyImplementor) &&
                 (! $this->strategyImplementor->subclausesAreAllowed()))) {
                throw new XN_IllegalArgumentException("Sub-clauses are not allowed on {$this->subject} queries.");
            }
            // Convert the clause into a tree of filters (with potential sub-trees);
            if (isset($this->strategyImplementor)) {
                $tree = $args[0]->_toFilterTree($this->strategyImplementor);
                $this->strategyImplementor->acceptFilterTree($tree);
            } else {
                $tree = $args[0]->_toFilterTree($this->subject);
                // And add the tree onto the content or search filter list
                if ($this->subject == 'Search') {
                    $this->filters['search'][] = $tree;
                } else {
                    $this->filters['content'][] = $tree;
                }
            }
        }
        // Otherwise, treat the first four elements of args as $prop, $operator
        // $value, and $type (setting $operator, $value, and $type to null if
        // not present. Ignore any additional elements in $args to maintain BC.
        else {
            $prop = $args[0];
            $operator = isset($args[1]) ? $args[1] : null;
            $value    = isset($args[2]) ? $args[2] : null;
            $type     = isset($args[3]) ? $args[3] : null;
            // Some basic sanity checking on the supplied values
            XN_Filter::_verify($prop, $operator, $value, $type);
            if (strncasecmp($this->subject, 'Content',7)==0){
                $this->_addContentFilter($prop, $operator, $value, $type);
            }
			if (strncasecmp($this->subject, 'MainContent',11)==0){
                $this->_addContentFilter($prop, $operator, $value, $type);
            }
			if (strncasecmp($this->subject, 'YearContent',11)==0){
                $this->_addContentFilter($prop, $operator, $value, $type);
            }
			if (strncasecmp($this->subject, 'MainYearContent',15)==0){
                $this->_addContentFilter($prop, $operator, $value, $type);
            }
			if (strncasecmp($this->subject, 'YearmonthContent',15)==0){
                $this->_addContentFilter($prop, $operator, $value, $type);
            }
			if (strncasecmp($this->subject, 'MainYearmonthContent',19)==0){
                $this->_addContentFilter($prop, $operator, $value, $type);
            }
			if (strncasecmp($this->subject, 'SimpleContent',13)==0){
                $this->_addContentFilter($prop, $operator, $value, $type);
            }
         	if (strncasecmp($this->subject, 'BigContent',10)==0){
                $this->_addContentFilter($prop, $operator, $value, $type);
            }
         	if (strncasecmp($this->subject, 'Message',7)==0){
                $this->_addContentFilter($prop, $operator, $value, $type);
            }
        	if (strncasecmp($this->subject, 'Mq',2)==0){
                $this->_addContentFilter($prop, $operator, $value, $type);
            }
        	if (strncasecmp($this->subject, 'Fulltext',8)==0){
                $this->_addContentFilter($prop, $operator, $value, $type);
            }
            else if (strcasecmp($this->subject, 'Application')==0){
                $this->_addApplicationFilter($prop, $operator, $value, $type);
            }
			else if (strncasecmp($this->subject, 'Profile',7)==0){
                $this->_addProfileFilter($prop, $operator, $value, $type);
            }
            else if (isset($this->strategyImplementor)) {
                $this->strategyImplementor->filter($prop, $operator, $value, $type);
            }
        }

        // Return the object for method chaining
        return $this;
    }

    /**
     * Adds a sort order for the query results. Depending on the subject of the
     * query, multiple sort orders can be applied to the query result. See the
     * {@link XN_Query} Class Details for the orders applicable for each query
     * subject.
     *
     * Random ordering is specified by setting the $prop argument to "random()"
     *
     * "Search" queries can only be ordered on indexed fields that have an
     * indexing type of "term" or "phrase". Fields with other indexing types
     * ("stored","text","fulltext" will be ignored as orderings).
     *
     * @param $prop string the property to sort on.
     * @param $direction string an XN_Order constant: ::ASC, ::DESC,
     *   ::ASC_NULL_FIRST, ::ASC_NULL_LAST, ::DESC_NULL_FIRST, ::DESC_NULL_LAST
     * @param $type string an optional argument applicable only when sorting
     * on a content my->attribute. Specifies the type of the attribute for
     * sorting purposes. Is either 'string' or 'number' and defaults to
     * 'string' if omitted.
     * @return XN_Query the XN_Query object
     */
    public function order($prop, $direction = null, $type='string'){
    	    	
        if (strcasecmp($this->subject, 'Content')==0){
            $this->orders[] = $this->_createContentOrder(
                $prop, $direction, $type);
        }
		if (strcasecmp($this->subject, 'Profile')==0){
            $this->orders[] = $this->_createContentOrder(
                $prop, $direction, $type);
        }
     	if (strcasecmp($this->subject, 'Content_Count')==0){
            $this->orders[] = $this->_createContentOrder(
                $prop, $direction, $type);
        }
     	if (strcasecmp($this->subject, 'Profile_Count')==0){
            $this->orders[] = $this->_createContentOrder(
                $prop, $direction, $type);
        }
		if (strcasecmp($this->subject, 'SimpleContent')==0){
            $this->orders[] = $this->_createContentOrder(
                $prop, $direction, $type);
        }
		if (strcasecmp($this->subject, 'MainContent')==0){
            $this->orders[] = $this->_createContentOrder(
                $prop, $direction, $type);
        }
		if (strcasecmp($this->subject, 'MainContent_Count')==0){
            $this->orders[] = $this->_createContentOrder(
                $prop, $direction, $type);
        }
		if (strcasecmp($this->subject, 'YearContent')==0){
            $this->orders[] = $this->_createContentOrder(
                $prop, $direction, $type);
        }
		if (strcasecmp($this->subject, 'MainYearContent')==0){
            $this->orders[] = $this->_createContentOrder(
                $prop, $direction, $type);
        }
		if (strcasecmp($this->subject, 'YearContent_Count')==0){
            $this->orders[] = $this->_createContentOrder(
                $prop, $direction, $type);
        }
		if (strcasecmp($this->subject, 'MainYearContent_Count')==0){
            $this->orders[] = $this->_createContentOrder(
                $prop, $direction, $type);
        }
		if (strcasecmp($this->subject, 'YearmonthContent')==0){
            $this->orders[] = $this->_createContentOrder(
                $prop, $direction, $type);
        }
		if (strcasecmp($this->subject, 'MainYearmonthContent')==0){
            $this->orders[] = $this->_createContentOrder(
                $prop, $direction, $type);
        }
		if (strcasecmp($this->subject, 'YearmonthContent_Count')==0){
            $this->orders[] = $this->_createContentOrder(
                $prop, $direction, $type);
        }
		if (strcasecmp($this->subject, 'MainYearmonthContent_Count')==0){
            $this->orders[] = $this->_createContentOrder(
                $prop, $direction, $type);
        }
        if (strcasecmp($this->subject, 'BigContent')==0){
            $this->orders[] = $this->_createContentOrder(
                $prop, $direction, $type);
        } 
    	if (strcasecmp($this->subject, 'Fulltext')==0){
            $this->orders[] = $this->_createContentOrder(
                $prop, $direction, $type);
        } 
		if (strcasecmp($this->subject, 'Mq')==0){
            $this->orders[] = $this->_createContentOrder(
                $prop, $direction, $type);
        }  
        else if (strcasecmp($this->subject,'Application') == 0) {
            $this->orders[] = $this->_createApplicationOrder($prop, $direction);
        }
        else if (isset($this->strategyImplementor)) {
            $this->strategyImplementor->order($prop, $direction, $type);
        }
        return $this;
    }

    /**
     * Specifies the rollup field for Content_Count queries
     *
     * @param $prop string the property to rollup on: contributor or type
     * @return XN_Query the XN_Query object
     */
    public function rollup($prop='') {
        if (strcasecmp($this->subject, 'Content_Count') != 0 && 
		    strcasecmp($this->subject, 'MainContent_Count') != 0 && 
			strcasecmp($this->subject, 'YearContent_Count') != 0 && 
			strcasecmp($this->subject, 'MainYearContent_Count') != 0 && 
			strcasecmp($this->subject, 'YearmonthContent_Count') != 0 && 
			strcasecmp($this->subject, 'MainYearmonthContent_Count') != 0 && 
		    strcasecmp($this->subject, 'Profile_Count') != 0 && 
		    strcasecmp($this->subject, 'BigContent_Count') != 0 ) {
            throw new XN_IllegalArgumentException("rollup() only supported for Content_Count queries");
        }
        if ($prop=='')
        {
	        if (isset($this->strategyImplementor)) {
	            $this->strategyImplementor->alwaysReturnTotalCount($always);
	        } else {
	            $this->alwaysReturnTotalCount = $always;
	        }
	        return $this;
        }
        $this->_addRollupFilter('field','=',$prop);
        return $this;
    }
/**
     * Specifies the rollup field for Content_Count queries
     *
     * @param $prop string the property to rollup on: contributor or type
     * @param $prop  世纪(@century) 年份域除以100  century  
     * @param $prop  日期(@day) (月分)里的日期域(1-31) day  
     * @param $prop  年代(@decade) 年份域除以10 decade  
     * @param $prop  星期几(@dow) 每周的星期号(0 - 6；星期天是 0)  dow 
     * @param $prop  年日(@doy) 一年的第几天(1 -365/366)  doy 
     * @param $prop  纪元(@epoch) epoch  
     * @param $prop  小时(@hour) 小时域 (0 - 23) hour  
     * @param $prop  微秒(@microseconds) 
     * @param $prop  千年(@millennium) 年域除以 1000
     * @param $prop  毫秒(@milliseconds) 秒域，包括小数部分，乘以 1000．请注意它包括完整的秒．
     * @param $prop  分钟(@minute) 分钟域 (0 - 59)
     * @param $prop  月份(@month) 它是一年里的月份数(1 - 12)； 
     * @param $prop  季度(@quarter) 该天所在的该年的季度(1 - 4)(仅用于 timestamp)
     * @param $prop  秒(@second) 秒域，包括小数部分 (0 - 59 [1])
     * @param $prop  周(@week) 从一个 timestamp 数值里计算该天在所在的年份里 是第几周．根据定义 (iso 8601)，一年的 第一周包含该年的一月四日．(iso 的周从星期一开始．) 换句话说，一年的第一个星期四在第一周．
     * @param $prop  年(@year) 年份域
     * @return XN_Query the XN_Query object
     */
    public function group($prop) {
        if (strcasecmp($this->subject, 'Content_Count') != 0 && 
		    strcasecmp($this->subject, 'MainContent_Count') != 0 && 
			strcasecmp($this->subject, 'YearContent_Count') != 0 && 
			strcasecmp($this->subject, 'MainYearContent_Count') != 0 && 
			strcasecmp($this->subject, 'YearmonthContent_Count') != 0 && 
			strcasecmp($this->subject, 'MainYearmonthContent_Count') != 0 && 
		    strcasecmp($this->subject, 'Profile_Count') != 0 && 
		    strcasecmp($this->subject, 'BigContent_Count') != 0) {
            throw new XN_IllegalArgumentException("group() only supported for Content_Count queries");
        }   
        $this->_addGroupFilter('field','=',$prop);
        return $this;
    }

/**     
     *
     * @param $tag string
     * @return XN_Query the XN_Query object
     */
    public function tag($tag){        
        $this->tag = $tag;
        return $this;
    }
    
    
    /**
     * Sets the zero-based position of the first object to retrieve relative to
     * the total count of possible query results. The default is 0.
     *
     * @param $begin int
     * @return XN_Query the XN_Query object
     */
    public function begin($begin){
        if (isset($this->strategyImplementor)) {
            $this->strategyImplementor->begin($begin);
        } else {
            $this->begin = $begin;
        }
        return $this;
    }

    /**
     * Sets the zero-based position <b>+1</b> of the last object to retrieve
     * relative to the total count of possible query results. The default is
     * the beginning position + 100.
     *
     * @param $end int
     * @return XN_Query the XN_Query object
     * @throws XN_IllegalArgumentException if end < begin + 1.
     */
    public function end($end){
        if (isset($this->strategyImplementor)) {
            $this->strategyImplementor->end($end);
        } else {
            if (($end < $this->begin + 1) && ($end != -1)) {
                /* Allow begin=0=end on Member queries (@see NING-10709). These sorts
                 * of exceptions are best handled in strategy subclasses! */
                if (! (($this->subject == self::SUBJECT_MEMBER) &&
                       ($this->begin == 0) && ($end == 0))) {
                    throw new XN_IllegalArgumentException("Cannot set end position '".$end."' as it is less than the begin position '".$this->begin."' + 1");
                }
            }
            $this->end = $end;
        }
        return $this;
    }

    /**
     * Controls whether a count of the total number of objects that match the
     * query is always returned. The total number,  given by
     * getTotalCount, is only returned for queries with
     * a begin position of 0 or for any begin position. By default is
     * false meaning that a count is only returned for queries with a begin
     * position of 0. Returning the count on all queries involves an extra
     * query of the database and will affect query response time.
     *
     * @param $always boolean
     * @return XN_Query the XN_Query object
     */
    public function alwaysReturnTotalCount($always=false){
        if (isset($this->strategyImplementor)) {
            $this->strategyImplementor->alwaysReturnTotalCount($always);
        } else {
            $this->alwaysReturnTotalCount = $always;
        }
        return $this;
    }

    /**
     * Return the value of alwaysReturnTotalCount. For most
     * query types, the value starts out
     * as null and is set to true or false when alwaysReturnTotalCount()
     * is called or, if still null when the query is executed, set to
     * true or false by _toAtomEndpoint() when the endpoint is calculated.
     *
     * @return boolean|null
     */
    public function getAlwaysReturnTotalCount() {
        if (isset($this->strategyImplementor)) {
            return $this->strategyImplementor->getAlwaysReturnTotalCount();
        } else {
            return $this->alwaysReturnTotalCount;
        }
    }

    /**
     * Returns the zero-based integer position of the first object in the
     * returned list of results relative to the total count of possible query
     * results. Is always the same as the begin position.
     *
     * @return int the int from position
     * @throws XN_IllegalStateException if this method is called before the
     * query has been executed.
     */
    public function getResultFrom(){
        if (isset($this->strategyImplementor)) {
            return $this->strategyImplementor->getResultFrom();
        } else {
            if (!isset($this->resultFrom))
                throw new XN_IllegalStateException("Cannot call getResultFrom() before the query is executed");
            return $this->resultFrom;
        }
    }

    /**
     * Returns the zero-based integer position <b>+1</b> of the last object in
     * the returned list of results relative to the total count of possible
     * query results.
     *
     * @return int the int to position
     * @throws XN_IllegalStateException if this method is called before the
     * query has been executed.
     */
    public function getResultTo(){
        if (isset($this->strategyImplementor)) {
            return $this->strategyImplementor->getResultTo();
        } else {
            if (!isset($this->resultTo))
                throw new XN_IllegalStateException(
                                                   "Cannot call getResultTo() before the query is executed");
            return $this->resultTo;
        }
    }

    /**
     * Returns the number of objects in the returned result set. Is always
     * equal to getResultTo minus getResultFrom.
     *
     * @return int the int result size
     * @throws XN_IllegalStateException if this method is called before the
     * query has been executed.
     */
    public function getResultSize(){
        if (isset($this->strategyImplementor)) {
            return $this->strategyImplementor->getResultSize();
        } else {
            if (!isset($this->resultTo))
                throw new XN_IllegalStateException(
                                                   "Cannot call getResultSize() before the query is executed");
            return $this->resultTo - $this->resultFrom;
        }
    }

    /**
     * If the begin position is 0 or alwaysReturnTotalCount is
     * true, returns the total count of objects that match the query without
     * bounds constraints.
     *
     * The assumed use case is that if the query is not beginning at 0, the
     * caller already knows the total count from a previous query beginning at
     * 0. The caller can override this assumed behavior by setting
     * alwaysReturnTotalCount with true.
     *
     * @return int the int total count
     * @throws XN_IllegalStateException if this method is called before the
     * query has been executed, or if the begin position is > 0 and
     * alwaysReturnTotalCount is false.
     */
    public function getTotalCount(){
        if (isset($this->strategyImplementor)) {
            return $this->strategyImplementor->getTotalCount();
        } else {
            if (!isset($this->totalCount))
                throw new XN_IllegalStateException("Cannot call getTotalCount() before the query is executed");
            if ($this->alwaysReturnTotalCount !== true) {
                throw new XN_IllegalStateException("Cannot call getTotalCount() if begin > 0 and alwaysReturnTotalCount is false");
            }
            return $this->totalCount;
        }
    }
    
    /**
     * Executes the query and returns an array of objects or ids of the
     * subjects that match the query or an empty array if there are no subjects
     * found.
     *
     * @param $returnIds boolean optional argument that if true specifies that
     * ids are to be returned. If omitted defaults to false meaning that
     * objects are to be returned.
     * @return array an array of result objects or an empty array
     * @throws an {@link XN_Exception} if the query failed.
     */
    public function execute($returnIds=false) {
        if (isset($this->strategyImplementor)) {
            $this->strategyImplementor->setReturnIds($returnIds);
        } else {
            $this->returnIds = $returnIds;
        }
        return $this->_executeQuery();
    }

    /**
     * Convenience method to return a single object or id of the subject that
     * matches the query or null if there is no matching subject.
     * Throws an {@link XN_Exception} if the query failed.
     *
     * @param $returnIds boolean optional argument that if true specifies that
     * an id is to be returned. If omitted defaults to false meaning that an
     * object is to be returned.
     * @return mixed a result object or null
     */
    public function uniqueResult($returnIds=false){
        if (isset($this->strategyImplementor)) {
            $this->strategyImplementor->setReturnIds($returnIds);
        } else {
            $this->returnIds = $returnIds;
        }
        $result = $this->_executeQuery();
        $numresults = count($result);
        if ($numresults==0){
            return null;
        }
        else if ($numresults==1){
            return $result[0];
        }
        else {
            throw new XN_Exception(
                "Failed query. More than one matching result\n".
                $this->debugString());
        }
    }

    /**
     * Returns a string debug representation of the XN_Query object
     * @return string a debug string
     */
    public function debugString() {
        if (isset($this->strategyImplementor)) {
            $returnIds = $this->strategyImplementor->returnIds;
            $begin = $this->strategyImplementor->begin;
            $end = $this->strategyImplementor->end;
            $artc = $this->strategyImplementor->alwaysReturnTotalCount;
            $orders = $this->strategyImplementor->orders;
            $filters = $this->strategyImplementor->filters;
        } else {
            $returnIds = $this->returnIds;
            $begin = $this->begin;
            $end = $this->end;
            $artc = $this->alwaysReturnTotalCount;
            $orders = $this->orders;
            $filters = $this->filters;
        }

        $retval = "XN_Query:\n" .
            "  subject [".$this->subject."]\n".
            "  returnIds [". $returnIds ."]\n".
            "  begin [".$begin."]\n".
            "  end [".$end."]\n".
            "  alwaysReturnTotalCount [".$artc."]\n".
            "  orders [\n";
        foreach ($orders as $order) {
            $retval.= "    ".$order->debugString()."\n";
        }
        $retval .= "  ]\n";
        $retval .= "  filters [\n";
        foreach ($filters as $filterType => $filters) {
            $retval .= self::_getSubtreeDebugString($filters);
        }
        $retval .= "\n  ]";
        return $retval;
    }
    
    /**
     * Returns a string debug representation of the XN_Query object within an
     * HTML pre tag.
     * @return string a debug string wrapped in html pre tags
     */
    public function debugHtml() {
        return '<pre>' . xnhtmlentities($this->debugString()). '</pre>';
    }
    
    /**
     * Prints a string debug epresentation of the XN_Query object within an
     * HTML pre tag.
     * @return XN_Query the XN_Query object
     */
    public function printDebugHtml() {
        print $this->debugHtml();
        return $this;
    }

    /**
     * Returns an representation for a filter value for filtering
     * against the friends of a particular user. To be used as the value
     * of a contributor or contributorName filter. If no screen name or
     * XN_Profile object is provided, the current user is used.
     *
     * @param $user string|XN_Profile optional screen name or XN_Profile object
     * @return
     * @throws XN_IllegalArgumentException if no argument is provided and there
     * is no currently logged-in user.
     */
     public static function FRIENDS($user = null) {
         if (is_null($user)) {
             $screenName = XN_Profile::current()->screenName;
         } else if ($user instanceof XN_Profile) {
             $screenName = $user->screenName;
         } else {
             $screenName = $user;
         }
         
         if (is_null($screenName)) {
             throw new XN_IllegalArgumentException("Must specify a user when there is not a currently logged-in user.");
         }

         return new XN_Query_InternalType_Friends($screenName);
     }

    //-------------------------------------------------------------------------
    // PRIVATE METHODS
    //-------------------------------------------------------------------------


	 public static function _prepareProfileFilter($prop, $operator, $value, $type = null) {
		  // Replace '->' with '.'
        $prop = implode('.', explode('->', $prop));
        $lowerProp = strtolower($prop);
        $filterType = 'content'; 

        if ($prop == 'owner'){
            if (!is_null($value) && !is_object($value))
                throw new XN_Exception("Expected [".$value."] to be an object");
            $prop = 'owner.relativeUrl';
            $value = is_null($value) ? XN_Application::$CURRENT_URL :
                $value->_getId();
            if (is_null($operator)) {
                $operator = '=';
            }
        } else if (($prop == 'owner.relativeUrl') && is_null($value)) {
            $value = XN_Application::$CURRENT_URL;
            if (is_null($operator)) {
                $operator = '=';
            }
        } else if ($prop == 'contributor') {
            if (!is_null($value) && !is_object($value))
                throw new XN_Exception("Expected [".$value."] to be an object");
            $prop = 'author';
            // Prevent internal type value from being string-quoted
            if ($value instanceof XN_Query_InternalType) {
                $type = XN_Filter::LITERAL;
            }
            $value = is_null($value) ? null : $value->_getId();
	    // NING-9209: eic/neic -> =/!=
	    if ($operator == 'eic') { $operator = '='; }
	    elseif ($operator == 'neic') { $operator = '!='; }
            if (is_null($operator)) {
                $operator = '=';
            }
        } else if (($prop == 'contributorName')||($prop == 'contributor.screenName')) {
            $prop = 'author';
            // Prevent internal type value from being string-quoted
            if ($value instanceof XN_Query_InternalType) {
                $value = $value->_getId();
                $type = XN_Filter::LITERAL;
            }
	    // NING-9209: eic/neic -> =/!=
	    if ($operator == 'eic') { $operator = '='; }
	    elseif ($operator == 'neic') { $operator = '!='; }
        } else if (($prop == 'id') && is_object($value)) {
	    $value = $value->_getId();
        } else if ($prop == 'isPrivate'){
            $prop = 'private';
            // Correct for accidentally leaving out the operator
            if (($operator !== '=') && ($operator !== '<>')) {
                $value = $operator;
                $operator = '=';
            }
            $type = XN_Attribute::BOOLEAN;
        } else if ($lowerProp == 'tag.value') {
            $filterType = 'tag';
            $prop = 'value';
        } else if ($lowerProp == 'tag.owner.screenname') {
            $filterType = 'tag';
            $prop = 'author';
        } else if ($lowerProp == 'referencerid') {
            $prop = 'referencer';
        } else if ($lowerProp == 'description') {
            $prop = 'summary';
        }/* else if (($lowerProp == 'createddate')||
                   ($lowerProp == 'updateddate')||
                   ($lowerProp == 'published')||
                   ($lowerProp == 'updated')) {
            $type = XN_Attribute::DATE;
        }*/
		if ($prop == "id")
		{
			if (is_array($value))
			{
				$newvalue = array();
				foreach($value as $childvalue)
				{
					$newvalue[] = "'".$childvalue."'";
				}
				$value = $newvalue;
			}
			else
			{
			    $value = "'".$value."'";
			}
		}

        return array('filterType' => $filterType,
                     'prop' => $prop,
                     'operator' => $operator,
                     'value' => $value,
                     'type' => $type);
	 }

    /** @unsupported @internal */
    public static function _prepareContentFilter($prop, $operator, $value, $type = null) {
        // Replace '->' with '.'
        $prop = implode('.', explode('->', $prop));
        $lowerProp = strtolower($prop);
        $filterType = 'content'; 
	 
        // Silently ignore invalid filters. These can't be passed to the
        // ATOM api, since it will complain, unlike the XMLRPC API
        if (! (isset(self::$_contentFilterMap[$lowerProp]) ||
        preg_match(self::$_contentFilterRegex, $lowerProp))) {
            return null;
        }

        if ($prop == 'owner'){
            if (!is_null($value) && !is_object($value))
                throw new XN_Exception("Expected [".$value."] to be an object");
            $prop = 'owner.relativeUrl';
            $value = is_null($value) ? XN_Application::$CURRENT_URL :
                $value->_getId();
            if (is_null($operator)) {
                $operator = '=';
            }
        } else if (($prop == 'owner.relativeUrl') && is_null($value)) {
            $value = XN_Application::$CURRENT_URL;
            if (is_null($operator)) {
                $operator = '=';
            }
        } else if ($prop == 'contributor') {
            if (!is_null($value) && !is_object($value))
                throw new XN_Exception("Expected [".$value."] to be an object");
            $prop = 'author';
            // Prevent internal type value from being string-quoted
            if ($value instanceof XN_Query_InternalType) {
                $type = XN_Filter::LITERAL;
            }
            $value = is_null($value) ? null : $value->_getId();
	    // NING-9209: eic/neic -> =/!=
	    if ($operator == 'eic') { $operator = '='; }
	    elseif ($operator == 'neic') { $operator = '!='; }
            if (is_null($operator)) {
                $operator = '=';
            }
        } else if (($prop == 'contributorName')||($prop == 'contributor.screenName')) {
            $prop = 'author';
            // Prevent internal type value from being string-quoted
            if ($value instanceof XN_Query_InternalType) {
                $value = $value->_getId();
                $type = XN_Filter::LITERAL;
            }
	    // NING-9209: eic/neic -> =/!=
	    if ($operator == 'eic') { $operator = '='; }
	    elseif ($operator == 'neic') { $operator = '!='; }
        } else if (($prop == 'id') && is_object($value)) {
	    $value = $value->_getId();
        } else if ($prop == 'isPrivate'){
            $prop = 'private';
            // Correct for accidentally leaving out the operator
            if (($operator !== '=') && ($operator !== '<>')) {
                $value = $operator;
                $operator = '=';
            }
            $type = XN_Attribute::BOOLEAN;
        } else if ($lowerProp == 'tag.value') {
            $filterType = 'tag';
            $prop = 'value';
        } else if ($lowerProp == 'tag.owner.screenname') {
            $filterType = 'tag';
            $prop = 'author';
        } else if ($lowerProp == 'referencerid') {
            $prop = 'referencer';
        } else if ($lowerProp == 'description') {
            $prop = 'summary';
        }/* else if (($lowerProp == 'createddate')||
                   ($lowerProp == 'updateddate')||
                   ($lowerProp == 'published')||
                   ($lowerProp == 'updated')) {
            $type = XN_Attribute::DATE;
        }*/ 
        return array('filterType' => $filterType,
                     'prop' => $prop,
                     'operator' => $operator,
                     'value' => $value,
                     'type' => $type);
    }

    

    /** @unsupported @internal */
    public static function _prepareApplicationFilter($subject, $prop, $operator, $value, $type = null) {
         $prop = str_replace('->','.',$prop);
         $lowerProp = strtolower($prop);

         // Explicitly *not* ignoring invalid filters 
         if ((! self::$_applicationFilterMap[$lowerProp][$operator]) &&
             ($lowerProp != 'popular')) {
             throw new XN_Exception("Operator $operator not allowed with $lowerProp filter in Application query: only '" . implode("', '", array_keys(self::$_applicationFilterMap[$lowerProp])) . "'");
         }

         // Process XN_Profile objects and arrays thereof
         if ($value instanceof XN_Profile) {
             $value = $value->screenName;
         }
         else if (is_array($value)) {
             foreach ($value as $k => $v) {
                 if ($v instanceof XN_Profile) {
                     $value[$k] = $v->screenName;
                 }
             }
         }
         
         if (($lowerProp != 'popular') && (is_null($value) || (mb_strlen($value) == 0))) {
             throw new XN_Exception("Value must be specified for $lowerProp filter in Application query.");
         }
         
         /* Network search parameter should not be quoted */
         if (($lowerProp == 'fulltext')||($lowerProp == 'recommended')) {
             $type = XN_Filter::LITERAL;
         }
         /* operator and value don't matter for popular */
         elseif ($lowerProp == 'popular') {
             $type = XN_Filter::LITERAL;
             $operator = $value = '';
         } else {
             $type = XN_Attribute::STRING;
         }

        return array('filterType' => 'application', 'prop' => $lowerProp, 'operator' => $operator, 'value' => $value, 'type' => $type);
    }

    private function _addContentFilter($prop, $operator, $value, $type = null){ 
        if (is_array($filterInfo = self::_prepareContentFilter($prop, $operator, $value, $type))) { 
            $this->filters[$filterInfo['filterType']][] = new XN_Filter($filterInfo['prop'], $filterInfo['operator'],$filterInfo['value'],$filterInfo['type']);
        }
        return $this;
    }
	 private function _addProfileFilter($prop, $operator, $value, $type = null){ 
        if (is_array($filterInfo = self::_prepareProfileFilter($prop, $operator, $value, $type))) { 
            $this->filters[$filterInfo['filterType']][] = new XN_Filter($filterInfo['prop'], $filterInfo['operator'],$filterInfo['value'],$filterInfo['type']);
        }
        return $this;
    }

    private function _addTagFilter($prop, $operator, $value,$type = null){
        if (is_array($filterInfo = self::_prepareTagFilter($this->subject, $prop, $operator, $value, $type))) {
            $this->filters[$filterInfo['filterType']][] = new XN_Filter($filterInfo['prop'], $filterInfo['operator'],$filterInfo['value'],$filterInfo['type']);
        }
        return $this;
    }

    private function _addContactFilter($prop, $operator, $value, $type = null) {
        if (is_array($filterInfo = self::_prepareContactFilter($this->subject, $prop, $operator, $value, $type))) {
            $this->filters[$filterInfo['filterType']][] = new XN_Filter($filterInfo['prop'], $filterInfo['operator'],$filterInfo['value'],$filterInfo['type']);
        }
        return $this;
    }

    private function _addInvitationFilter($prop, $operator, $value, $type = null) {
        if (is_array($filterInfo = self::_prepareInvitationFilter($this->subject, $prop, $operator, $value, $type))) {
            $this->filters[$filterInfo['filterType']][] = new XN_Filter($filterInfo['prop'], $filterInfo['operator'],$filterInfo['value'],$filterInfo['type']);
        }
        return $this;
    }

    private function _addMessageFilter($prop, $operator, $value, $type = null) {
        if (is_array($filterInfo = self::_prepareMessageFilter($this->subject, $prop, $operator, $value, $type))) {
            $this->filters[$filterInfo['filterType']][] = new XN_Filter($filterInfo['prop'], $filterInfo['operator'],$filterInfo['value'],$filterInfo['type']);
        }
        return $this;
    }

    private function _addActivityEventFilter($prop, $operator, $value, $type = null) {
        if (is_array($filterInfo = self::_prepareActivityEventFilter($this->subject, $prop, $operator, $value, $type))) {
            $this->filters[$filterInfo['filterType']][] = new XN_Filter($filterInfo['prop'], $filterInfo['operator'],$filterInfo['value'],$filterInfo['type']);
        }
        return $this;
    }

    private function _addMemberFilter($prop, $operator, $value, $type = null) {
        if (is_array($filterInfo = self::_prepareMemberFilter($this->subject, $prop, $operator, $value, $type))) {
            $this->filters[$filterInfo['filterType']][] = new XN_Filter($filterInfo['prop'], $filterInfo['operator'],$filterInfo['value'],$filterInfo['type']);
        }
        return $this;
    }

    private function _addApplicationFilter($prop, $operator, $value, $type = null) {
        if (count($this->filters['application']) != 0) {
            throw new XN_IllegalArgumentException("Only one filter allowed for Application queries");
        }
        if (is_array($filterInfo = self::_prepareApplicationFilter($this->subject, $prop, $operator, $value, $type))) {
            $this->filters[$filterInfo['filterType']][] = new XN_Filter($filterInfo['prop'], $filterInfo['operator'],$filterInfo['value'],$filterInfo['type']);
        }
        return $this;
    }

    private function _addRollupFilter($prop, $operator, $value, $type = null) {
        // Replace '->' with '.'
        $prop = implode('.', explode('->', $prop));
        $lowerProp = strtolower($prop);
        $this->filters['rollup'][] = new XN_Filter($prop, $operator, $value, $type);
    }
    
    private function _addGroupFilter($prop, $operator, $value, $type = null) {
        // Replace '->' with '.'
        $prop = implode('.', explode('->', $prop));
        $lowerProp = strtolower($prop);
        $this->filters['group'][] = new XN_Filter($prop, $operator, $value, $type);
    }
    
    

    private function _addSearchFilter($prop, $operator, $value, $type = null){
        if (is_array($filterInfo = self::_prepareSearchFilter($prop, $operator, $value, $type))) {
            $this->filters[$filterInfo['filterType']][] = new XN_Filter($filterInfo['prop'], $filterInfo['operator'],$filterInfo['value'],$filterInfo['type']);
        }
        return $this;
    }

    private function _createContentOrder($prop, $direction, $type){
        // Remove spaces
        $prop = str_replace(' ','', $prop);
        // Replace '->' with '.'
        $prop = str_replace('->','.', $prop);
        $lowerProp = strtolower($prop);

        if ($prop == 'owner'){
            $prop = 'ownerName';
        }
        else if ($lowerProp == 'contributor'){
            $prop = 'author';
        }
        else if ($lowerProp == 'contributor.screenname') {
            $prop = 'author';
        }
        else if ($lowerProp == 'contributorname') {
            $prop = 'author';
        }
        else if ($prop == 'isPrivate'){
            $prop = 'private';
        }
        else if ($prop == 'count(owner)'){
            $prop = 'count(ownerName)';
        }
        else if ($prop == 'count(contributor)'){
            $prop = 'count(contributorName)';
        } else if ($prop == 'createdDate') {
            $prop = 'published';
        } else if ($prop == 'updatedDate') {
            $prop = 'updated';
        }


        return new XN_Order($prop, $direction, $type);
    }


    protected function _createApplicationOrder($prop, $direction) {
        if (! isset(self::$_applicationOrders[strtolower($prop)])) {
            throw new XN_IllegalArgumentException("$prop is not a valid order for an Application query.");
        }
        return new XN_Order(self::$_applicationOrders[strtolower($prop)], $direction, null);
    }


    /** @unsupported @internal */
    public function toEndpoint() {
        if (isset($this->strategyImplementor)) {
            return $this->strategyImplementor->toEndpoint();
        } 
        else {
            return null;
        }
    }


    /** @unsupported @internal */
    public function _toAtomEndpoint() {
        // Assume in-app endpoint unless specified otherwise (NING-6855)
        $atomEndpointHost = XN_AtomHelper::ENDPOINT_APP(XN_Application::$CURRENT_URL);
        $removeAppFilters = false;
        $qsParams = array();
        $selectors = array('content' => array(),
                           'tag' => array(),
                           'rollup' => array(),
                           'search' => array(),
         				   'group' => array(),
                           'invitation' => array());
        $apps = array();
        if (strcasecmp($this->subject, 'Search') == 0) {
            $atomEndpointHost = XN_AtomHelper::ENDPOINT_APP(XN_Application::$CURRENT_URL, '1.1');
            $removeAppFilters = true;
        }
        else {
            // Walk through all the filters once to determine whether to hit against
            // an app-specific endpoint (in which case all app filters are removed from
            // selectors) or the global endpoint (in which case app filters are left in
            // the endpoint.

            /* The 'owner' specification determines the endpoint:
             *
             * (Op is =) If there is a single owner filter, the query goes against
             * that app's endpoint.
             * If there is no owner filter, the query goes against the
             * global end point.
             * (Op is 'in') If there is an owner filter against multiple apps, the query
             * goes against the global endpoint
             * (Op is anything else) Query goes against the global endpoint. This is
             * indicated by the XN_Filter::FORCE_GLOBAL_ENDPOINT operator
             */
             foreach ($this->filters as $filterCategory => $filters) {
                 foreach ($filters as $filter) {
                     // $apps is passed by reference and updated in the function
                     self::_getSubtreeAppFilters($apps, $filter);
                 }
             }
             // If only one app was asked for, set the endpoint to the app-specific
             // one and make sure to remove any app-filters from the selectors
             // If one of the "apps" listed is the special constant
             if ((count($apps) == 1) && (! isset($apps[XN_Filter::FORCE_GLOBAL_ENDPOINT]))) {
                 $tmp = array_keys($apps);
                 $atomEndpointHost = XN_AtomHelper::ENDPOINT_APP($tmp[0]);
                 $removeAppFilters = true;
             }
             elseif ((count($apps) > 1) || isset($apps[XN_Filter::FORCE_GLOBAL_ENDPOINT])) {
                 $atomEndpointHost = XN_AtomHelper::ENDPOINT_XN();
             }
        }
        // Now build up the selectors
        foreach ($this->filters as $filterCategory => $filters) {
            $selectors[$filterCategory] = self::_getSubtreeSelector($filters, '&', $removeAppFilters);
        }

        /* NING-8220: ask for the count of the result set size
         * If $this->alwaysReturnTotalCount has not been set, then use
         * the default behavior:
         * if begin=0, ask for the total count, if begin >0 don't.
         */
        /*if (is_null($this->alwaysReturnTotalCount)) {
            $this->alwaysReturnTotalCount = (intval($this->begin) == 0);
        }*/
        $this->alwaysReturnTotalCount = true;
         
	/* NING-9032: only use this parameter for content queries */
	if (strcasecmp($this->subject, self::SUBJECT_CONTENT) == 0) {
	    if ($this->alwaysReturnTotalCount) {
		$qsParams[] = 'count=true';
	    } else {
		$qsParams[] = 'count=false';
	    }
	}
        $qsParams[] = 'xn_out=xml';
        $qsParams[] = 'from='.intval($this->begin);
        if (isset($this->end)) {
            $qsParams[] = 'to='.$this->end;
        } else {
            $qsParams[] = 'to='.(100 + intval($this->begin));
        }

        // Content queries get a default order of published@D if not
        // otherwise specified
        if ((strcasecmp($this->subject,'Content') == 0) && (count($this->orders) == 0)) {
           // $this->order('createdDate','desc');
        }
		if ((strcasecmp($this->subject,'SimpleContent') == 0) && (count($this->orders) == 0)) {
           // $this->order('createdDate','desc');
        }
		if ((strcasecmp($this->subject,'MainContent') == 0) && (count($this->orders) == 0)) {
           // $this->order('createdDate','desc');
        }

        foreach ($this->orders as $order) {
            $qsParams[] = $order->_toQueryStringValue();
        }
        /* All tag queries should go against a local endpoint. Keep a specific one
         * if specified in a filter, otherwise go to the current app's endpoint */
        if (((strcasecmp($this->subject, self::SUBJECT_TAG) == 0) ||
             (strcasecmp($this->subject, self::SUBJECT_TAG_VALUECOUNT) == 0)) &&
            ($atomEndpointHost == XN_AtomHelper::ENDPOINT_XN())) {
            $atomEndpointHost = XN_AtomHelper::ENDPOINT_APP(XN_Application::$CURRENT_URL);
        }
        if (strcasecmp($this->subject, self::SUBJECT_INVITATION) == 0) {
            $atomEndpointHost = XN_AtomHelper::ENDPOINT_APP_REST(XN_Application::$CURRENT_URL);
        }

        $url = $atomEndpointHost;

        if (strcasecmp($this->subject, self::SUBJECT_CONTENT) == 0) {
            if (strlen($selectors['tag'])) {
                $url .= "/tag({$selectors['tag']})/content({$selectors['content']})";
            } else {
                $url .= "/content({$selectors['content']})";
            }
		} else if (strcasecmp($this->subject, self::SUBJECT_MAINCONTENT) == 0) {
            if (strlen($selectors['tag'])) {
                $url .= "/tag({$selectors['tag']})/maincontent({$selectors['content']})";
            } else {
                $url .= "/maincontent({$selectors['content']})";
            }
		} else if (strcasecmp($this->subject, self::SUBJECT_YEARCONTENT) == 0) {
            if (strlen($selectors['tag'])) {
                $url .= "/tag({$selectors['tag']})/yearcontent({$selectors['content']})";
            } else {
                $url .= "/yearcontent({$selectors['content']})";
            }
		} else if (strcasecmp($this->subject, self::SUBJECT_MAINYEARCONTENT) == 0) {
            if (strlen($selectors['tag'])) {
                $url .= "/tag({$selectors['tag']})/mainyearcontent({$selectors['content']})";
            } else {
                $url .= "/mainyearcontent({$selectors['content']})";
            }
		} else if (strcasecmp($this->subject, self::SUBJECT_YEARMONTHCONTENT) == 0) {
            if (strlen($selectors['tag'])) {
                $url .= "/tag({$selectors['tag']})/yearmonthcontent({$selectors['content']})";
            } else {
                $url .= "/yearmonthcontent({$selectors['content']})";
            }
		} else if (strcasecmp($this->subject, self::SUBJECT_MAINYEARMONTHCONTENT) == 0) {
            if (strlen($selectors['tag'])) {
                $url .= "/tag({$selectors['tag']})/mainyearmonthcontent({$selectors['content']})";
            } else {
                $url .= "/mainyearmonthcontent({$selectors['content']})";
            }
        } else if (strcasecmp($this->subject, self::SUBJECT_SIMPLECONTENT) == 0) {
            if (strlen($selectors['tag'])) {
                $url .= "/tag({$selectors['tag']})/simplecontent({$selectors['content']})";
            } else {
                $url .= "/simplecontent({$selectors['content']})";
            }
        } else if (strcasecmp($this->subject, self::SUBJECT_BIGCONTENT) == 0) {
        	$url .= "/bigcontent({$selectors['content']})";
        } else if (strcasecmp($this->subject, self::SUBJECT_YEARCONTENT) == 0) {
        	$url .= "/yearcontent({$selectors['content']})";
        } else if (strcasecmp($this->subject, self::SUBJECT_MAINYEARCONTENT) == 0) {
        	$url .= "/mainyearcontent({$selectors['content']})";
        } else if (strcasecmp($this->subject, self::SUBJECT_YEARMONTHCONTENT) == 0) {
        	$url .= "/yearmonthcontent({$selectors['content']})";
        } else if (strcasecmp($this->subject, self::SUBJECT_MAINYEARMONTHCONTENT) == 0) {
        	$url .= "/mainyearmonthcontent({$selectors['content']})";
        } else if (strcasecmp($this->subject, self::SUBJECT_MESSAGE) == 0) {
        	$url .= "/message({$selectors['content']})";
		} else if (strcasecmp($this->subject, self::SUBJECT_MQ) == 0) {
        	$url .= "/mq({$selectors['content']})";
        } else if (strcasecmp($this->subject, self::SUBJECT_BIGCONTENT) == 0) {
        	$url .= "/bigcontent({$selectors['content']})/rollup({$selectors['rollup']})";
        } else if (strcasecmp($this->subject, self::SUBJECT_YEARCONTENT) == 0) {
        	$url .= "/yearcontent({$selectors['content']})/rollup({$selectors['rollup']})";
        } else if (strcasecmp($this->subject, self::SUBJECT_MAINYEARCONTENT) == 0) {
        	$url .= "/mainyearcontent({$selectors['content']})/rollup({$selectors['rollup']})";
        } else if (strcasecmp($this->subject, self::SUBJECT_YEARMONTHCONTENT) == 0) {
        	$url .= "/yearmonthcontent({$selectors['content']})/rollup({$selectors['rollup']})";
        } else if (strcasecmp($this->subject, self::SUBJECT_MAINYEARMONTHCONTENT) == 0) {
        	$url .= "/mainyearmonthcontent({$selectors['content']})/rollup({$selectors['rollup']})";
        } else if (strcasecmp($this->subject, self::SUBJECT_FULLTEXT) == 0) {
        	$url .= "/fulltext({$selectors['content']})";
	    } else if (strcasecmp($this->subject, self::SUBJECT_PROFILE) == 0) {
        	$url .= "/profile({$selectors['content']})";
        } else if (strcasecmp($this->subject, self::SUBJECT_FULLTEXT) == 0) {
        	$url .= "/fulltext({$selectors['content']})/rollup({$selectors['rollup']})";
        }else if (strcasecmp($this->subject, self::SUBJECT_TAG) == 0) {
            $url .= "/content({$selectors['content']})/tag({$selectors['tag']})";
        } else if (strcasecmp($this->subject, self::SUBJECT_TAG_VALUECOUNT) == 0) {
            $url .= "/content({$selectors['content']})/tag({$selectors['tag']})/rollup({$selectors['rollup']})";
        } else if ((strcasecmp($this->subject, self::SUBJECT_CONTENT_COUNT) == 0) && isset($selectors['group'])){
            $url .= "/content({$selectors['content']})/rollup({$selectors['rollup']})/group({$selectors['group']})"; 
        } else if ((strcasecmp($this->subject, self::SUBJECT_PROFILE_COUNT) == 0) && isset($selectors['group'])){
            $url .= "/profile({$selectors['content']})/rollup({$selectors['rollup']})/group({$selectors['group']})";   
		 } else if ((strcasecmp($this->subject, self::SUBJECT_SIMPLECONTENT_COUNT) == 0) && isset($selectors['group'])){
            $url .= "/simplecontent({$selectors['content']})/rollup({$selectors['rollup']})/group({$selectors['group']})"; 
		 } else if ((strcasecmp($this->subject, self::SUBJECT_MAINCONTENT_COUNT) == 0) && isset($selectors['group'])){
            $url .= "/maincontent({$selectors['content']})/rollup({$selectors['rollup']})/group({$selectors['group']})"; 
	    } else if ((strcasecmp($this->subject, self::SUBJECT_YEARCONTENT_COUNT) == 0) && isset($selectors['group'])){
           $url .= "/yearcontent({$selectors['content']})/rollup({$selectors['rollup']})/group({$selectors['group']})"; 
        } else if ((strcasecmp($this->subject, self::SUBJECT_MAINYEARCONTENT_COUNT) == 0) && isset($selectors['group'])){
           $url .= "/mainyearcontent({$selectors['content']})/rollup({$selectors['rollup']})/group({$selectors['group']})"; 
        } else if ((strcasecmp($this->subject, self::SUBJECT_YEARMONTHCONTENT_COUNT) == 0) && isset($selectors['group'])){
           $url .= "/yearmonthcontent({$selectors['content']})/rollup({$selectors['rollup']})/group({$selectors['group']})"; 
        } else if ((strcasecmp($this->subject, self::SUBJECT_MAINYEARMONTHCONTENT_COUNT) == 0) && isset($selectors['group'])){
           $url .= "/mainyearmonthcontent({$selectors['content']})/rollup({$selectors['rollup']})/group({$selectors['group']})"; 
        } else if (strcasecmp($this->subject, self::SUBJECT_CONTENT_COUNT) == 0){
            $url .= "/content({$selectors['content']})/rollup({$selectors['rollup']})";
		} else if (strcasecmp($this->subject, self::SUBJECT_SIMPLECONTENT_COUNT) == 0){
            $url .= "/simplecontent({$selectors['content']})/rollup({$selectors['rollup']})";
		} else if (strcasecmp($this->subject, self::SUBJECT_MAINCONTENT_COUNT) == 0){
            $url .= "/maincontent({$selectors['content']})/rollup({$selectors['rollup']})";
        } else if (strcasecmp($this->subject, self::SUBJECT_BIGCONTENT_COUNT) == 0){
            $url .= "/bigcontent({$selectors['content']})/rollup({$selectors['rollup']})/group({$selectors['group']})"; 
        } else if (strcasecmp($this->subject, self::SUBJECT_YEARCONTENT_COUNT) == 0){
            $url .= "/yearcontent({$selectors['content']})/rollup({$selectors['rollup']})/group({$selectors['group']})"; 
        } else if (strcasecmp($this->subject, self::SUBJECT_MAINYEARCONTENT_COUNT) == 0){
            $url .= "/mainyearcontent({$selectors['content']})/rollup({$selectors['rollup']})/group({$selectors['group']})"; 
        } else if (strcasecmp($this->subject, self::SUBJECT_YEARMONTHCONTENT_COUNT) == 0){
            $url .= "/yearmonthcontent({$selectors['content']})/rollup({$selectors['rollup']})/group({$selectors['group']})"; 
        } else if (strcasecmp($this->subject, self::SUBJECT_MAINYEARMONTHCONTENT_COUNT) == 0){
            $url .= "/mainyearmonthcontent({$selectors['content']})/rollup({$selectors['rollup']})/group({$selectors['group']})"; 
        } else if (strcasecmp($this->subject, self::SUBJECT_MESSAGE_COUNT) == 0){
            $url .= "/message({$selectors['content']})/rollup({$selectors['rollup']})/group({$selectors['group']})"; 
        } else if (strcasecmp($this->subject, self::SUBJECT_FULLTEXT_COUNT) == 0){
            $url .= "/fulltext({$selectors['content']})/rollup({$selectors['rollup']})";    
        } else if (strcasecmp($this->subject, self::SUBJECT_SEARCH) == 0){
            $url .= "/search({$selectors['search']})";
        } else if (strcasecmp($this->subject, self::SUBJECT_INVITATION) == 0){
            $url .= "/invite({$selectors['invitation']})";
        }
        $url .= '?'.implode('&',$qsParams);
        return $url;
    }

    

    /** @unsupported @internal */
    public function _toApplicationEndpoint() {
        if (count($this->filters['application']) != 1) {
            throw new XN_IllegalStateException("Application queries must have exactly 1 filter instead of " . count($this->filters['application']));
        }

         // Application queries are always against the app-specific endpoint
        $url = '/xn/rest/1.0/membership/user(' . 
            rawurlencode($this->filters['application'][0]->_toSelectorValue(array('property' => array('member' => 'id')))) . ')/application';
        
        // Add query string parameters
        $qsParams = array('from' => (int) $this->begin);
        $qsParams['to'] = isset($this->end) ? $this->end : (100 + $this->begin);
        $url .= '?' . http_build_query($qsParams);

        // Total count is available for application queries (NING-9586)
        $this->alwaysReturnTotalCount = true;

        return $url;
    }

/** @unsupported @internal */
    public function _toNetworkSearchEndpoint() {
        /*if (count($this->filters['application']) != 1) {
            throw new XN_IllegalStateException("Application queries must have exactly 1 filter instead of " . count($this->filters['application']));
        }*/

        // Network search queries don't have the /xn/(rest|atom) prefix, so the full
        // URL must be specified to XN_REST
        $url = 'http://' . XN_AtomHelper::HOST_APP(XN_Application::$CURRENT_URL) . '/xn/rest/1.0/application';
		
       $selectors = array('application' => array());
        
    	foreach ($this->filters as $filterCategory => $filters) {
            $selectors[$filterCategory] = self::_getSubtreeSelector($filters, '&', $removeAppFilters);
        }
        
        if (strlen($selectors['application'])) 
        {
            $url .= "({$selectors['application']})";
        } 
        else 
        {
         	$url .= "()";
        }

        //$qsParams['from'] =  (int) $this->begin;
        //$qsParams['to'] = isset($this->end) ? $this->end : (100 + $this->begin);
        
        $qsParams[] = 'from='.intval($this->begin);
        if (isset($this->end)) {
            $qsParams[] = 'to='.$this->end;
        } else {
            $qsParams[] = 'to='.(100 + intval($this->begin));
        }
        if  (count($this->orders) == 0) {
            $this->order('published','desc');
        }

        foreach ($this->orders as $order) {
            $qsParams[] = $order->_toQueryStringValue();
        }
        
        //$url .= '?xn_out=xml&' . http_build_query($qsParams);
        $url .= '?xn_out=xml&' . implode('&',$qsParams);

        // Total count is available for application queries (NING-9586)
        $this->alwaysReturnTotalCount = true;
        
        return $url;
    }

    /** @unsupported @internal */
    protected function _isMemberIntersectionQuery() {
        $props = array();
        foreach ($this->filters['member'] as $f) {
            $props[] = $f->getProperty();
        }
        sort($props);
        return ((strcasecmp($this->subject, self::SUBJECT_MEMBER) == 0) &&
                (count($this->filters['member']) == 2) &&
                ($props == array('application','user')));
    }

    /** @unsupported @internal 
     * Is this query a member query for applications
     * (that a user is a member of?
     */
    protected function _isMemberAppQuery() {
        return ((strcasecmp($this->subject, self::SUBJECT_MEMBER) == 0) &&
                (count($this->filters['member']) == 1) &&
                ($this->filters['member'][0]->getProperty() == 'user'));
    }
    
    /** @unsupported @internal */
    protected function _toMemberIntersectionRequestBody() {
        $xmlParts = array('application' => '',
                          'user' => '');
        foreach ($this->filters['member'] as $filter) {
            foreach ((array) $filter->getValue() as $v) {
                $xmlParts[$filter->getProperty()] .= XN_REST::xmlsprintf("<id>%s</id>",$v);
            }
        }
        return "<intersection><applications>{$xmlParts['application']}</applications><users>{$xmlParts['user']}</users></intersection>";
    }

    private static function _getSubtreeAppFilters(&$apps, $filterOrSubtree) {
        if ($filterOrSubtree instanceof XN_Filter) {
            $filterApps = $filterOrSubtree->_getFilterApps();
            if (is_string($filterApps)) {
                $apps[$filterApps] = true;
            } else if (is_array($filterApps)) {
                foreach ($filterApps as $filterApp) { $apps[$filterApp] = true; }
            }
        }
        // A sub-clause that's been converted to a tree
        else if (is_array($filterOrSubtree)) {
            // The first element in the sub-tree is the operator to join with
            for ($i = 1, $j = count($filterOrSubtree); $i < $j; $i++) {
                self::_getSubtreeAppFilters($apps, $filterOrSubtree[$i]);
            }
        }
    }

    private static function _getSubtreeSelector($filters, $operator, $removeAppFilters) {
        $tmp = array();
        foreach ($filters as $filterOrSubtree) {
            if ($filterOrSubtree instanceof XN_Filter) {
                if ((! $removeAppFilters) || ($removeAppFilters && ($filterOrSubtree->getProperty() != 'owner.relativeUrl'))) {
                    $tmp[] = rawurlencode($filterOrSubtree->_toSelectorValue());
                }
            }
            // A sub-clause that's been converted to a tree
            else {
                $tmp[] = '(' . self::_getSubtreeSelector(array_slice($filterOrSubtree, 1), $filterOrSubtree[0], $removeAppFilters). ')';
            }
        }
        return  implode(rawurlencode($operator), $tmp);
    }
    
    /** @unsupported @internal
     * Convert a filter tree into a lucene-style expression. 
     *
     * @param $filters array of filters
     * @param $operator string operator to combine the filters on
     * @return string
     */
    public static function _getSubtreeLuceneStyle($filters, $operator) {
        /* Operators may be selector-style, convert them to lucene-style */
        if ($operator == '&') { $operator = ' AND '; }
        else if ($operator == '|') { $operator = ' OR '; }

        $tmp = array();

        foreach ($filters as $filterOrSubtree) {
            if ($filterOrSubtree instanceof XN_Filter) {
                $tmp[] = $filterOrSubtree->_toLuceneStyleValue();
            }
            // A sub-clause that's been converted to a tree
            else {
                $slice = array_slice($filterOrSubtree, 1);
                $subtreeString = self::_getSubtreeLuceneStyle($slice, $filterOrSubtree[0]);
                /* No need to wrap in parens if there's just one sub-term */
                if ((count($slice) == 1) && ($slice[0] instanceof XN_Filter)) {
                    $tmp[] .= $subtreeString;
                } else {
                    $tmp[] = '(' . $subtreeString . ')';
                }
            }
        }
        return implode($operator, $tmp);
    }

    private static function _getSubtreeDebugString($filters, $operator = '&', $level = 1) {
        static $opWords = array('&' => 'AND', '|' => 'OR');
        $lines = array();
        foreach ($filters as $filterOrSubtree) {
            if ($filterOrSubtree instanceof XN_Filter) {
                $lines[] = str_repeat(' ',2 * $level) . $filterOrSubtree->debugString();
            }
            // A sub-clause that's been converted to a tree
            else {
                $lines[] = self::_getSubtreeDebugString(array_slice($filterOrSubtree, 1), $filterOrSubtree[0], $level + 1);
            }
        }
        return implode("\n" . str_repeat(' ', 2 * $level) . $opWords[$operator] . "\n", $lines);
    }

    private function _executeQuery(){
        if (isset($this->strategyImplementor)) {
            try {
                return $this->strategyImplementor->execute();
            } catch (Exception $ex) {
                throw XN_Exception::reformat("Failed query:\n".$this->debugString(), $ex);
            }
        }
        try {
            // Contact queries go against a different endpoint and do not return
            // atom feeds, so they have to be handled differently than the other
            // kinds of queries
            if (strcasecmp($this->subject,'Contact') == 0) {
                // Build the URL
                $url = $this->_toContactEndpoint();
                // Retrieve the URL
                $x = XN_AtomHelper::XPath(XN_REST::get($url));
                // NING-3099: Check for error in the response body [ David Sklar 2006-09-29 ]
                if (! is_null($error = $x->textContent('/errors/element/error', null, true))) {
                    throw new Exception($error);
                }

                // set totalCount, resultFrom, resultTo
                $this->totalCount = (integer) $x->textContent('/contacts/total');
                $this->resultFrom = (integer) $x->textContent('/contacts/begin');
                $this->resultTo   = (integer) $x->textContent('/contacts/end');
                // Turn the results into an array of XN_Contact objects
                return XN_Contact::_loadFromRestFeed($x);
            // Message queries go against a different endpoint and do not return
            // atom feeds, so they have to be handled differently than the other
            // kinds of queries
            }  
			else if (strcasecmp($this->subject, 'Application') == 0) 
            {
				$url = $this->_toNetworkSearchEndpoint();
				$headers = array(XN_REST::USE_SERVICE_LOCATION => 'network-search');
				if ($this->tag != "")
			    {
					$headers['tag'] = $this->tag;
				}
				$rsp = XN_REST::get($url, $headers);
				$x = XN_AtomHelper::XPath($rsp);
				$this->totalCount = (integer) $x->textContent('/atom:feed/xn:size');
				return XN_AtomHelper::loadFromAtomFeed($rsp,'XN_Application',false);
				/*
				$json = json_decode($rsp, true);
				if (! is_array($json)) {
				    throw new XN_Exception("Can't parse Application search results: $rsp");
				}
				$this->totalCount = (integer) $json['total'];
				$this->resultFrom = (integer) $json['from'];
				$this->resultTo   = (integer) $json['to'];
				$subdomains = array();
				foreach ($json['results'] as $result) {
				    $subdomains[] = $result['subdomain'];
				}
				return $subdomains;*/
            }
			else if (strcasecmp($this->subject, 'Profile') == 0) 
            {
				$url = $this->_toAtomEndpoint();
				$headers = array(XN_REST::USE_SERVICE_LOCATION => 'network-search');
				if ($this->tag != "")
			    {
					$headers['tag'] = $this->tag;
				}
				$rsp = XN_REST::get($url, $headers);
				$x = XN_AtomHelper::XPath($rsp);
				$this->totalCount = (integer) $x->textContent('/atom:feed/xn:size');
				return XN_AtomHelper::loadFromAtomFeed($rsp,'XN_Profile',false); 
            }
			else if (strcasecmp($this->subject, 'Member') == 0) {
                $url = $this->_toMemberEndpoint();
                if ($this->_isMemberIntersectionQuery()) {
                    $xml = XN_REST::post($url, $this->_toMemberIntersectionRequestBody(),'application/xml');
                    // Simpler response format, we can use SimpleXML
                    $res = array();
                    $sxml = @simplexml_load_string($xml);
                    if ($sxml === false) {
                        return $res;
                    }
                    foreach ($sxml->application as $app) {
                        foreach ($app->user as $user) {
                            $res[(string) $app['subdomain']][] = (string) $user['id'];
                        }
                    }

                    /* No member count provided for intersection */
                    $this->totalCount = false;

                    return $res;
                }
                else { 
                    $x = XN_AtomHelper::XPath(XN_REST::get($url));
                    $this->totalCount = (integer) $x->textContent('/atom:feed/xn:size');
                    $this->resultFrom = (integer) $this->begin;
                    $this->resultTo = ($this->end == 0) ?
                        $this->totalCount : min ((integer) $this->end, $this->totalCount);
		    if ($this->_isMemberAppQuery()) {
			return XN_Member::_loadFromApplicationAtomFeed($x);
		    } else {
			return XN_Member::_loadFromMemberAtomFeed($x);
		    }
                }
            } else {
                $version = ($this->subject == 'Search') ? '1.1' : '1.0';
                $headers = null;
                if ($this->subject == 'ActivityEvent') {
                    $url = $this->_toActivityEndpoint();
                    $t = XN_ActivityEvent::getQueryTimeout();
                    if ($t) {
                        $headers = array(XN_REST::USE_REQUEST_TIMEOUT => $t);
                    }
                    /* NING-10566: retrieving activity feed as JSON */
                    if (isset($_SERVER['XN_Activity_query_json']) &&
                        ($_SERVER['XN_Activity_query_json'] == 1)) {
                        $rsp = XN_REST::get($url, $headers);
                        list($size, $results) = XN_ActivityEvent::_fromJsonFeed($rsp);
                        $this->totalCount = $size;
                        $this->resultFrom = (integer) $this->begin;
                        if ($this->end == 0) {
                            $this->resultTo = $this->totalCount;
                        } else {
                            $this->resultTo = min((integer) $this->end, $this->totalCount);
                        }
                        return $results;
                    }
                } else {
                    $url = $this->_toAtomEndpoint();
                     //$headers = null;
                     $headers = array('tag' => $this->tag,);
                }
                $x = XN_AtomHelper::XPath(XN_REST::get($url, $headers), $version);
                $this->totalCount = (integer) $x->textContent('/atom:feed/xn:size');
                $this->resultFrom = (integer) $this->begin;

                /* If it's a content query, and we didn't ask for total count,
                 * then don't set $this->totalCount and don't use it when
                 * calculating $this->resultTo */
                if ((strcasecmp($this->subject, self::SUBJECT_CONTENT) == 0) &&
                    ($this->alwaysReturnTotalCount !== true)) {
                    //$this->totalCount = -1;
                    $entries = $x->query('/atom:feed/atom:entry');
                    $this->resultTo = $this->resultFrom + $entries->length;
                }else  if ((strcasecmp($this->subject, self::SUBJECT_SIMPLECONTENT) == 0) &&
                    ($this->alwaysReturnTotalCount !== true)) {
                    //$this->totalCount = -1;
                    $entries = $x->query('/atom:feed/atom:entry');
                    $this->resultTo = $this->resultFrom + $entries->length;
				 }else  if ((strcasecmp($this->subject, self::SUBJECT_MAINCONTENT) == 0) &&
                    ($this->alwaysReturnTotalCount !== true)) {
                    //$this->totalCount = -1;
                    $entries = $x->query('/atom:feed/atom:entry');
                    $this->resultTo = $this->resultFrom + $entries->length;
			    }else  if ((strcasecmp($this->subject, self::SUBJECT_YEARCONTENT) == 0) &&
                   ($this->alwaysReturnTotalCount !== true)) {
                   //$this->totalCount = -1;
                   $entries = $x->query('/atom:feed/atom:entry');
                   $this->resultTo = $this->resultFrom + $entries->length;
		        }else  if ((strcasecmp($this->subject, self::SUBJECT_MAINYEARCONTENT) == 0) &&
                  ($this->alwaysReturnTotalCount !== true)) {
                  //$this->totalCount = -1;
                  $entries = $x->query('/atom:feed/atom:entry');
                  $this->resultTo = $this->resultFrom + $entries->length;
			    }else  if ((strcasecmp($this->subject, self::SUBJECT_YEARMONTHCONTENT) == 0) &&
	                 ($this->alwaysReturnTotalCount !== true)) {
	                 //$this->totalCount = -1;
	                 $entries = $x->query('/atom:feed/atom:entry');
	                 $this->resultTo = $this->resultFrom + $entries->length;
		        }else  if ((strcasecmp($this->subject, self::SUBJECT_MAINYEARMONTHCONTENT) == 0) &&
	                ($this->alwaysReturnTotalCount !== true)) {
	                //$this->totalCount = -1;
	                $entries = $x->query('/atom:feed/atom:entry');
	                $this->resultTo = $this->resultFrom + $entries->length;
                }else  if ((strcasecmp($this->subject, self::SUBJECT_BIGCONTENT) == 0) &&
                    ($this->alwaysReturnTotalCount !== true)) {
                    //$this->totalCount = -1;
                    $entries = $x->query('/atom:feed/atom:entry');
                    $this->resultTo = $this->resultFrom + $entries->length;        
                }else  if ((strcasecmp($this->subject, self::SUBJECT_MESSAGE) == 0) &&
                    ($this->alwaysReturnTotalCount !== true)) {
                    //$this->totalCount = -1;
                    $entries = $x->query('/atom:feed/atom:entry');
                    $this->resultTo = $this->resultFrom + $entries->length;        
				}else  if ((strcasecmp($this->subject, self::SUBJECT_MQ) == 0) &&
                    ($this->alwaysReturnTotalCount !== true)) {
                    //$this->totalCount = -1;
                    $entries = $x->query('/atom:feed/atom:entry');
                    $this->resultTo = $this->resultFrom + $entries->length;        
                }else  if ((strcasecmp($this->subject, self::SUBJECT_FULLTEXT) == 0) &&
                    ($this->alwaysReturnTotalCount !== true)) {
                    //$this->totalCount = -1;
                    $entries = $x->query('/atom:feed/atom:entry');
                    $this->resultTo = $this->resultFrom + $entries->length;
                }else  if (strcasecmp($this->subject, self::SUBJECT_CONTENT_COUNT) == 0) {
                    $this->totalCount = (integer) $x->textContent('/atom:feed/xn:size');
                    $entries = $x->query('/atom:feed/atom:entry');
                    $this->resultTo = $this->resultFrom + $entries->length;
				}else  if (strcasecmp($this->subject, self::SUBJECT_BIGCONTENT_COUNT) == 0) {
                    $this->totalCount = (integer) $x->textContent('/atom:feed/xn:size');
                    $entries = $x->query('/atom:feed/atom:entry');
                    $this->resultTo = $this->resultFrom + $entries->length;
				}else  if (strcasecmp($this->subject, self::SUBJECT_MESSAGE_COUNT) == 0) {
                    $this->totalCount = (integer) $x->textContent('/atom:feed/xn:size');
                    $entries = $x->query('/atom:feed/atom:entry');
                    $this->resultTo = $this->resultFrom + $entries->length;
                }else  if (strcasecmp($this->subject, self::SUBJECT_PROFILE_COUNT) == 0) {
                    $this->totalCount = (integer) $x->textContent('/atom:feed/xn:size');
                    $entries = $x->query('/atom:feed/atom:entry');
                    $this->resultTo = $this->resultFrom + $entries->length;
                }else  if (strcasecmp($this->subject, self::SUBJECT_SIMPLECONTENT_COUNT) == 0) {
                    $this->totalCount = (integer) $x->textContent('/atom:feed/xn:size');
                    $entries = $x->query('/atom:feed/atom:entry');
                    $this->resultTo = $this->resultFrom + $entries->length;
				}else  if (strcasecmp($this->subject, self::SUBJECT_MAINCONTENT_COUNT) == 0) {
                    $this->totalCount = (integer) $x->textContent('/atom:feed/xn:size');
                    $entries = $x->query('/atom:feed/atom:entry');
                    $this->resultTo = $this->resultFrom + $entries->length;
				}else  if (strcasecmp($this->subject, self::SUBJECT_YEARCONTENT_COUNT) == 0) {
                    $this->totalCount = (integer) $x->textContent('/atom:feed/xn:size');
                    $entries = $x->query('/atom:feed/atom:entry');
                    $this->resultTo = $this->resultFrom + $entries->length;
				}else  if (strcasecmp($this->subject, self::SUBJECT_MAINYEARCONTENT_COUNT) == 0) {
                    $this->totalCount = (integer) $x->textContent('/atom:feed/xn:size');
                    $entries = $x->query('/atom:feed/atom:entry');
                    $this->resultTo = $this->resultFrom + $entries->length;
				}else  if (strcasecmp($this->subject, self::SUBJECT_YEARMONTHCONTENT_COUNT) == 0) {
                    $this->totalCount = (integer) $x->textContent('/atom:feed/xn:size');
                    $entries = $x->query('/atom:feed/atom:entry');
                    $this->resultTo = $this->resultFrom + $entries->length;
				}else  if (strcasecmp($this->subject, self::SUBJECT_MAINYEARMONTHCONTENT_COUNT) == 0) {
                    $this->totalCount = (integer) $x->textContent('/atom:feed/xn:size');
                    $entries = $x->query('/atom:feed/atom:entry');
                    $this->resultTo = $this->resultFrom + $entries->length;
                }else {
                    $this->totalCount = (integer) $x->textContent('/atom:feed/xn:size');
                    if ($this->end == 0) {
                        $this->resultTo = $this->totalCount;
                    } else {
                        $this->resultTo   = min((integer) $this->end, $this->totalCount);
                    }
                }

                if ($this->returnIds == 'true') {
                    return self::_atomFeedToIDs($x);
                }
                else if (strcasecmp($this->subject, self::SUBJECT_CONTENT)==0) {
                    return XN_Atomhelper::loadFromAtomFeed($x, 'XN_Content', false);
                }
				else if (strcasecmp($this->subject, self::SUBJECT_MAINCONTENT)==0) {
                    return XN_Atomhelper::loadFromAtomFeed($x, 'XN_Content', false,true,4);
                }
				else if (strcasecmp($this->subject, self::SUBJECT_YEARCONTENT)==0) {
                    return XN_Atomhelper::loadFromAtomFeed($x, 'XN_Content', false,true,7);
                }
				else if (strcasecmp($this->subject, self::SUBJECT_MAINYEARCONTENT)==0) {
                    return XN_Atomhelper::loadFromAtomFeed($x, 'XN_Content', false,true,8);
                }
				else if (strcasecmp($this->subject, self::SUBJECT_YEARMONTHCONTENT)==0) {
                    return XN_Atomhelper::loadFromAtomFeed($x, 'XN_Content', false,true,9);
                }
				else if (strcasecmp($this->subject, self::SUBJECT_MAINYEARMONTHCONTENT)==0) {
                    return XN_Atomhelper::loadFromAtomFeed($x, 'XN_Content', false,true,10);
                }
				else if (strcasecmp($this->subject, self::SUBJECT_PROFILE)==0) {
                    return XN_Atomhelper::loadFromAtomFeed($x, 'XN_Content', false,true,4);
                }
				else if (strcasecmp($this->subject, self::SUBJECT_SIMPLECONTENT)==0) {
                    return XN_Atomhelper::loadFromAtomFeed($x, 'XN_Content', false);
                }
            	else if (strcasecmp($this->subject, self::SUBJECT_CONTENT_COUNT)==0) {
                    return XN_Atomhelper::loadFromAtomFeed($x, 'XN_Content', false);
                }
            	else if (strcasecmp($this->subject, self::SUBJECT_PROFILE_COUNT)==0) {
                    return XN_Atomhelper::loadFromAtomFeed($x, 'XN_Content', false);
                }
				else if (strcasecmp($this->subject, self::SUBJECT_SIMPLECONTENT_COUNT)==0) {
                    return XN_Atomhelper::loadFromAtomFeed($x, 'XN_Content', false);
                }
				else if (strcasecmp($this->subject, self::SUBJECT_MAINCONTENT_COUNT)==0) {
                    return XN_Atomhelper::loadFromAtomFeed($x, 'XN_Content', false);
                }
				else if (strcasecmp($this->subject, self::SUBJECT_YEARCONTENT_COUNT)==0) {
                    return XN_Atomhelper::loadFromAtomFeed($x, 'XN_Content', false);
                }
				else if (strcasecmp($this->subject, self::SUBJECT_MAINYEARCONTENT_COUNT)==0) {
                    return XN_Atomhelper::loadFromAtomFeed($x, 'XN_Content', false);
                }
				else if (strcasecmp($this->subject, self::SUBJECT_YEARMONTHCONTENT_COUNT)==0) {
                    return XN_Atomhelper::loadFromAtomFeed($x, 'XN_Content', false);
                }
				else if (strcasecmp($this->subject, self::SUBJECT_MAINYEARMONTHCONTENT_COUNT)==0) {
                    return XN_Atomhelper::loadFromAtomFeed($x, 'XN_Content', false);
                }
				else if (strcasecmp($this->subject, self::SUBJECT_BIGCONTENT_COUNT)==0) {
                    return XN_Atomhelper::loadFromAtomFeed($x, 'XN_Content', false);
                }
            	else if (strcasecmp($this->subject, self::SUBJECT_BIGCONTENT)==0) {
                    return XN_Atomhelper::loadFromAtomFeed($x, 'XN_Content', false);
                }
				else if (strcasecmp($this->subject, self::SUBJECT_MESSAGE_COUNT)==0) {
                    return XN_Atomhelper::loadFromAtomFeed($x, 'XN_Content', false);
                }
            	else if (strcasecmp($this->subject, self::SUBJECT_MESSAGE)==0) {
                    return XN_Atomhelper::loadFromAtomFeed($x, 'XN_Content', false);
				}
				else if (strcasecmp($this->subject, self::SUBJECT_MQ)==0) {
                    return XN_Atomhelper::loadFromAtomFeed($x, 'XN_Content', false);
                }
            	else if (strcasecmp($this->subject, self::SUBJECT_FULLTEXT)==0) {
                    return XN_Atomhelper::loadFromAtomFeed($x, 'XN_Content', false);
                }
                else if (strcasecmp($this->subject, self::SUBJECT_TAG)==0) {
                    return XN_AtomHelper::loadFromAtomFeed($x, 'XN_Tag', false);
                }
                else if ((strcasecmp($this->subject, self::SUBJECT_TAG_VALUECOUNT)==0)||
                (strcasecmp($this->subject, self::SUBJECT_CONTENT_COUNT)==0)||
				(strcasecmp($this->subject, self::SUBJECT_PROFILE_COUNT)==0)||
				(strcasecmp($this->subject, self::SUBJECT_SIMPLECONTENT_COUNT)==0)||
				(strcasecmp($this->subject, self::SUBJECT_MAINCONTENT_COUNT)==0)||
				(strcasecmp($this->subject, self::SUBJECT_YEARCONTENT_COUNT)==0)||
				(strcasecmp($this->subject, self::SUBJECT_MAINYEARCONTENT_COUNT)==0)||
				(strcasecmp($this->subject, self::SUBJECT_YEARMONTHCONTENT_COUNT)==0)||
				(strcasecmp($this->subject, self::SUBJECT_MAINYEARMONTHCONTENT_COUNT)==0)||
                (strcasecmp($this->subject, self::SUBJECT_FULLTEXT_COUNT)==0)||
                (strcasecmp($this->subject, self::SUBJECT_BIGCONTENT_COUNT)==0)){
                    return self::_loadRollupFromAtomFeed($x);
                }
                else if (strcasecmp($this->subject, self::SUBJECT_SEARCH)==0) {
                    return XN_AtomHelper::loadFromAtomFeed($x, 'XN_SearchResult', false, false);
                }
                else if (strcasecmp($this->subject, self::SUBJECT_INVITATION)==0) {
                    return XN_AtomHelper::loadFromAtomFeed($x, 'XN_Invitation', false, false);
                }
                else if (strcasecmp($this->subject, self::SUBJECT_ACTIVITYEVENT)==0) {
                    return XN_AtomHelper::loadFromAtomFeed($x, 'XN_ActivityEvent', false, false);
                }
            }
        } catch (XN_Exception $ex) {
            // NING-3304: Queries against single IDs that don't find anything return
            // a 404; in that case, we should just return an empty result set [ David Sklar 2006-10-05 ]
        // NING-5887: Except that search queries return a 404 if the searcher core is missing
            // [ David Sklar 2007-08-03]
            if (($ex->getCode() == 404) && (strcasecmp($this->subject, self::SUBJECT_SEARCH) != 0)) {
                return array();
            } else {
                throw XN_Exception::reformat("Failed query:\n".$url.$this->debugString(), $ex);
            }
        } catch (Exception $ex) {
            throw XN_Exception::reformat("Failed query:\n".$url.$this->debugString(), $ex);
        }
    }

    private static function _atomFeedToIDs(XN_XPathHelper $x) {
        $ids = array();
        foreach ($x->query('/atom:feed/atom:entry/atom:id') as $node) {
            $ids[] = $node->textContent;
        }
        return $ids;
    }

    private static function _loadRollupFromAtomFeed(XN_XPathHelper $x) {
        $rollup = array();
        foreach ($x->query('/atom:feed/xn:rollup') as $node) {
            if (! is_null($key = XN_XPathHelper::attribute($node, 'key'))) {
                $rollup[$key] = (integer) $node->textContent;
            }
        }
        return $rollup;
    }
}

/** @cond Hide implementation classes in generated documentation */

//-----------------------------------------------------------------------------
// IMPLEMENTATION CLASSES - NOT TO BE EXPOSED - NEEDS CLEANUP OR DELETION
//-----------------------------------------------------------------------------


/** Represents an order imposed upon a {@link XN_Query} result set.
 *
 * @ingroup XN
 */
class XN_Order {
    private $sort;
    private $property;
    private $type;

    const ASC = 'A';
    const ASC_NUMBER = 'A_N';
    const ASC_NULL_FIRST = 'A@NF';
    const ASC_NULL_LAST = 'A@NL';
    const DESC = 'D';
    const DESC_NUMBER = 'D_N';
    const DESC_NULL_FIRST = 'D@NF';
    const DESC_NULL_LAST = 'D@NL';

    private static $sorts = array(self::ASC => 'asc',  
    							  self::ASC_NUMBER => 'asc number',  							      
                                  self::ASC_NULL_FIRST => 'asc null first',
                                  self::ASC_NULL_LAST => 'asc null last',
                                  self::DESC_NUMBER => 'desc number',  
                                  self::DESC => 'desc',  	                               
                                  self::DESC_NULL_FIRST => 'desc null first', 
                                  self::DESC_NULL_LAST => 'desc null last');
    
    /**
     * Ascending sort order of the given property.
     *
     * If the property is an attribute, the optional type argument specifies
     * the type of the attribute value for sorting. The supported sort types
     * are "string", "number", "date". If type is omitted and the sort property
     * is an attribute, the attribute value is sorted as a string. The type
     * argument is not used for non-attribute properties.
     *
     * @param $property string property name
     * @param $type string optional attribute sort type
     * @access private
     * @deprecated
     */
    public static function asc($property, $type="string"){
        return new XN_Order($property, self::ASC, $type);
    }
    /**
     * Descending order of the given property.
     *
     * If the property is an attribute, the optional type argument specifies
     * the type of the attribute value for sorting. The supported sort types
     * are "string", "number", "date". If type is omitted and the sort property
     * is an attribute, the attribute value is sorted as a string. The type
     * argument is not used for non-attribute properties.
     *
     * @param $property string property name
     * @param $type string optional attribute sort type
     * @access private
     * @deprecated
     */
    public static function desc($property, $type="string"){
        return new XN_Order($property, self::DESC, $type);
    }
    /**
     * Returns a string debug representation of the XN_Filter object
     * @return string
     * @access private
     * @deprecated
     */
    public function debugString() {
        $str = $this->property." : ";
        if (isset(self::$sorts[$this->sort])) {
            $str .= self::$sorts[$this->sort];
        }
        $str .= " : ".$this->type;
        return $str;
    }
    /** @unsupported @internal */
    function isAscending(){
        return ($this->sort == 'A'); // for BC (NING-7428)
    }
    /** @unsupported @internal */
    function getType(){
        return $this->type;
    }
    /** @unsupported @internal */
    function getProperty(){
        return $this->property;
    }
    /** @unsupported @internal */
    function __construct($property, $sort, $type){
        $this->type = $type;
        $this->property = $property;
        
        if (! is_null($sort)) {
            // Map pre-NING-7428 values properly for BC
            if ($type == 'number'){
	            if ($sort == 'asc') { $sort = self::ASC_NUMBER; }
	            else if ($sort == 'desc') { $sort = self::DESC_NUMBER; }
	            else if ($sort === true) { $sort = self::ASC_NUMBER; }
	            else if ($sort === false) { $sort = self::DESC_NUMBER; }
	            else if (! isset(self::$sorts[$sort])) { $sort = self::DESC_NUMBER; } // default
            }
            else
            {
	            if ($sort == 'asc') { $sort = self::ASC; }
	            else if ($sort == 'desc') { $sort = self::DESC; }
	             else if ($sort === true) { $sort = self::ASC; }
	            else if ($sort === false) { $sort = self::DESC; }
	            else if (! isset(self::$sorts[$sort])) { $sort = self::DESC; } // default            	
            }
        } else {
            $sort = self::DESC; // default;
        }
        $this->sort = $sort;
    }

    /** @unsupported @internal */
    function _toQueryStringValue() {
        if ($this->property == 'random()') {
            return 'order=random()';
        } else {
            if (isset(self::$sorts[$this->sort])) {
                return 'order='.urlencode($this->property).'@'.$this->sort;
            }
        }
    }
}


/**
 * Factory for building filters to use with XN_Query::filter(),
 * XN_Filter::any(), or XN_Filter::all().
 *
 * @ingroup XN
 * @param $prop string
 * @param $operator string optional
 * @param $value string|object|array optional
 * @param $type string optional
 */
function XN_Filter($prop, $operator = null, $value = null, $type = null) {
    // Some basic sanity checking on the supplied values
    XN_Filter::_verify($prop, $operator, $value, $type);

    $payload = array('prop' => $prop, 'operator' => $operator,
                     'value' => $value, 'type' => $type);
    return new XN_Query_InternalType_RawFilter($payload);
}


/** Represents a constraint imposed upon an {@link XN_Query} result set.
 * Multiple filters can be added to a query.
 *
 * @ingroup XN
 */
class XN_Filter {
    /* A pseudo-type to prevent XN_Query_InternalType values from being
     * string-escaped */
    const LITERAL = 'literal';
    /* A pseudo-type to force values to be quoted and string-escaped.
     * Used for XN_Invitation ids, which would otherwise be automatically unquoted. */
    const QUOTED = 'quoted';
    // This value needs to be something that can't be a valid
    // app URL prefix
    const FORCE_GLOBAL_ENDPOINT = '_global_endpoint';

    /**
     * Create a new filter expression sub-clause that requires
     * any of the sub-filters to be true. Takes a variable number
     * of arguments, each of which should be what you get from
     * XN_Filter(), XN_Filter::any(), or XN_Filter::all()
     *
     * @return object
     */
     public static function any() {
         $args = func_get_args();
         return self::_clause('|', $args);
     }

     /**
     * Create a new filter expression sub-clause that requires
     * all of the sub-filters to be true. Takes a variable number
     * of arguments, each of which should be what you get from
     * XN_Filter(), XN_Filter::any(), or XN_Filter::all()
     *
     * @return object
     */
     public static function all() {
         $args = func_get_args();
         return self::_clause('&', $args);
     }

     protected static function _clause($op, $args) {
         // Make sure each of $args is the correct type
         foreach ($args as $i => $arg) {
             if (! (($arg instanceof XN_Query_InternalType_RawFilter)||
             ($arg instanceof XN_Query_InternalType_FilterClause))) {
                 throw new XN_IllegalArgumentException("Argument #$i is neither the result of calling XN_Filter(), XN_Filter::any(), nor XN_Filter::all()");
             }
         }
         $payload = array($op, $args);
         return new XN_Query_InternalType_FilterClause($payload);
     }

    /** @unsupported @internal */
    public static function _verify($prop, $operator, $value, $type) {
        if (! is_null($value)) {
            if (strcasecmp($operator,XN_Query::IN)==0) {
                // IN operator must have an array argument
                // Except that 'contributor' or 'contributorName' filters
                // can have an XN_Query_InternalType argument with the 'in'
                // operator [ David Sklar 2006-07-19 ]
                if (!is_array($value)) {
                    $lowerProp = strtolower($prop);
                    $isContributor = (($lowerProp == 'contributor')||($lowerProp == 'contributorname')||($lowerProp=='contributor.screenname'));
                    if ($isContributor) {
                        if  (! ($value instanceof XN_Query_InternalType_Friends)) {
                            throw new XN_IllegalArgumentException("The value argument for an 'in' filter must be an array or XN_Query::FRIENDS() result");
                        }
                    } else {
                        throw new XN_IllegalArgumentException("The value argument for an 'in' filter must be an array");
                    }
                }
            } elseif (strcasecmp($operator,XN_Query::NIN)==0) {
                // NIN operator must have an array argument
                if (!is_array($value)) {
                    throw new XN_IllegalArgumentException("The value argument for an '!in' filter must be an array");
                }
            } elseif (is_array($value)) {
                // If the operator is not IN, then the argument shouldn't be an array
                throw new XN_IllegalArgumentException("The value argument for an $operator filter can not be an array.");
            }
        }
    }

    /**
     * If this filter doesn't affect app filtering, return null
     * If this filter determines a single app to match against, return that app URL
     * If this filter determines multiple apps to match against, return an array of
     * the app URLs
     * If this filter uses an operator other than = eic or in, then return something
     * that forces the query to use the global endpoint and include the filter
     * in the atom endpoint (NING-3056)
     *
     * @access private */
    public function _getFilterApps() {
        if ($this->property != 'owner.relativeUrl') {
            return null;
        }
        if (($this->operator != '=') &&
            (strcasecmp($this->operator,'eic') != 0) &&
            (strcasecmp($this->operator,'in') != 0)) {
            return XN_Filter::FORCE_GLOBAL_ENDPOINT;
        }
        if (is_array($this->value)) {
            $tmp = array();
            foreach ($this->value as $host) {
                // Remove the quotes around the "strings"
                $strippedHost = substr($host,1);
                $strippedHost = substr($strippedHost,0,-1);
                $tmp[] = $strippedHost;
            }
            return $tmp;
        } else {
            // Remove the quotes around the "strings"
            $strippedHost = substr($this->value,1);
            $strippedHost = substr($strippedHost,0,-1);
            return $strippedHost;
        }
    }


    /** Apply a "not-equal" constraint to the given property. */
    public static function ne($property, $value, $type=null){
        return new XN_Filter($property, '<>', $value, $type);
    }
    /** Apply an 'equal' constraint to the given property. */
    public static function eq($property, $value=null, $type=null){
        return new XN_Filter($property, '=', $value, $type);
    }
    /** Apply a 'less-than' constraint to the given property. */
    public static function lt($property, $value, $type=null){
        return new XN_Filter($property, '<', $value, $type);
    }
    /** Apply a 'greater-than' constraint to the given property. */
    public static function gt($property, $value, $type=null){
        return new XN_Filter($property, '>', $value, $type);
    }
    /** Apply a 'less-than-equal' constraint to the given property. */
    public static function le($property, $value, $type=null){
        return new XN_Filter($property, '<=', $value, $type);
    }
    /** Apply a 'greater-than-equal' constraint to the given property. */
    public static function ge($property, $value, $type=null){
        return new XN_Filter($property, '>=', $value, $type);
    }
    /** Apply an 'equal-ignore-case' constraint to the given property. */
    public static function eic($property, $value, $type=null){
        return new XN_Filter($property, 'eic', $value, $type);
    }
    /** Apply an 'not-equal-ignore-case' constraint to the given property. */
    public static function neic($property, $value, $type=null){
        return new XN_Filter($property, 'neic', $value, $type);
    }
    /** Apply a 'like' constraint to the given property. */
    public static function like($property, $value, $type=null){
        return new XN_Filter($property, 'like', $value, $type);
    }
    /** Apply a 'in' constraint to the given property for the value array. */
    public static function in($property, $array, $type=null){
        return new XN_Filter($property, 'in', $array, $type);
    }
    /** Apply a '!in' constraint to the given property for the value array. */
    public static function nin($property, $array, $type=null){
        return new XN_Filter($property, '!in', $array, $type);
    }

    /**
     * Returns a string debug representation of the XN_Filter object
     * @return string
     */
    public function debugString() {
        if (is_array($this->value)) {
            $val = implode(',',$this->value);
            $type = self::determineType($this->value[0]);
        } else {
            $val = $this->value;
            $type = self::determineType($this->value);
        }
        return $this->property." : ".$this->operator." : " . $val . ' : ' . $type;
    }

    //--- Private stuff ---

    private static function determineType($value) {
        if ((substr($value,0,1) == "'") && (substr($value,-1) == "'")) {
            $type = XN_Attribute::STRING;
        } else if (preg_match('@^-?\d*(\.\d+)?$@', $value)) {
            $type = XN_Attribute::NUMBER;
        } else if (preg_match('@^\d{4}-\d\d-\d\dT\d\d:\d\d:\d\d(.\d+)?(Z|((\+|-)\d\d:\d\d))$@', $value)) {
            $type = XN_Attribute::DATE;
        } else {
            // fall through
            $type = XN_Attribute::STRING;
        }
        return $type;
    }

    private $property = "";
    private $operator = "==";
    private $value;
    private $paramType;

    // Translating to the operators Atom understands
    private static $operatorMap = array('<>' => '!=');
    // Translating to properties Atom understands
    private static $propertyMap = array('owner.relativeUrl' => 'application',
                                        'contact' => 'id');

    private static $idFilters = array('id' => true, 'content.id' => true, 'contentId' => true, 'referencerId' => true);

    /** @unsupported @internal */
    function __construct($name, $operator, $value=null,$type=null) {
        $this->property = $name;
        $this->operator = $operator;

        // Any cleanups on value before it gets processed
        if ($type == XN_Attribute::DATE && (! strlen($value))) {
            $value = null;
        }

        if (is_array($value)) {
            $this->value = array();
            foreach ($value as $checkVal) {
                if (is_scalar($checkVal)) {
                    $scalarVal = $checkVal;
                } elseif (is_object($checkVal) && is_callable(array($checkVal,'_getId'))) {
                    $scalarVal = $checkVal->_getId();
                    if (! is_scalar($scalarVal)) {
                        throw new XN_IllegalArgumentException("Very invalid value for 'in' filter");
                    }
                } else {
                    throw new XN_IllegalArgumentException("Invalid value for 'in' filter");
                }
                if ($type == self::QUOTED) {
                    $this->value[] = "'".XN_REST::singleQuote($scalarVal)."'";
                } elseif (is_int($scalarVal) || is_float($scalarVal)) {
                    // number
                    $this->value[] = $scalarVal;
                } elseif (isset(self::$idFilters[$name]) || ($type == self::LITERAL)) {
                    $this->value[] = $scalarVal;
                } else {
                    // string
                    $this->value[] = "'".XN_REST::singleQuote($scalarVal)."'";
                }
            }
        } elseif (! is_null($value)) {
            if (! is_null($type)) {
                if ($type == XN_Attribute::STRING || $type == self::QUOTED) {
                    $this->value = "'".XN_REST::singleQuote($value)."'";
                } else if ($type == XN_Attribute::BOOLEAN) {
                    $this->value = ((boolean) $value) ? 'true' : 'false';
                } else {
                    $this->value = $value;
                }
            } else {
                if (is_int($value) || is_float($value)) {
                    $this->value = $value;
                } elseif (isset(self::$idFilters[$name])) {
                    $this->value = $value;
                } else {
                    // default to string
                    $this->value = "'".XN_REST::singleQuote($value)."'";
                }
            }
        } else {
            if (isset(self::$idFilters[$name])) {
                throw new XN_IllegalArgumentException("Value for filter '$name' cannot be null.");
            } else {
                $this->value = 'null';
            }
        }
    }

    /** @unsupported @internal */
    function getProperty(){return $this->property;}
    /** @unsupported @internal */
    function getOperator(){return $this->operator;}
    /** @unsupported @internal */
    function getValue(){return $this->value;}
    /** @unsupported @internal */
    function getType(){return $this->paramType;}

    function _toSelectorValue($maps = null) {
        $operator = isset(self::$operatorMap[$this->operator]) ?
                    self::$operatorMap[$this->operator] :
                    $this->operator;
        $property = isset(self::$propertyMap[$this->property]) ?
                    self::$propertyMap[$this->property] :
                    $this->property;
        
        // Allow passed in maps to override mapping of property. This allows for the mapping
        // To happen on a per-filter or per-query-type basis instead of for all filters.
        if (is_array($maps) && isset($maps['property']) && isset($maps['property'][$property])) {
            $property = $maps['property'][$property];
        }

        $value = is_array($this->value) ?
            ('[' . implode(',',$this->value) . ']') : $this->value;
        return "$property $operator $value";
    }

    /** @unsupported @internal
     * Returns a representation of this filter appropriate for a lucene-style
     * query, as described at http://lucene.apache.org/java/2_4_0/queryparsersyntax.html
     *
     * @return string
     */
    public function _toLuceneStyleValue() {
        /* Anything other than the special "fulltext" field gets a field name prefix */
        $field = ($this->property == 'fulltext') ? '' : (self::escapeForLuceneStyle($this->property).':');
        
        /* Phrase match or tokenized match? */
        $quot = ($this->operator == '=') ? '"' : '';

        /* Note: no support for array values since allowable operators
         * don't permit that; this is a safety check but this should
         * have already been taken care of by the query subject classes */
        if (is_array($this->value)) {
            throw new XN_IllegalStateException("Arrays not allowed with lucene-style values");
        }
        
        /* Escape special characters in the value. */
        $value = self::escapeForLuceneStyle($this->value);

        /* If the operator is "like" -- a tokenized match -- AND the field
         * is not "fulltext", then the value is surrounded by parentheses to
         * in case there are multiple tokens in the value (spaces, punctuation, etc.)
         */
        if (($this->operator == 'like') && ($this->property != 'fulltext')) {
            $value = "($value)";
        }
        return "$field$quot$value$quot";
    }

    /**
     * Escape characters that Lucene-style query syntax considers special. 
     * preg_replace() is used here so the search + replace can be UTF-8-aware.
     * The backlashing below is a little funky because of the need to
     * backslash-escape for PHP's string quoting rules as well as to escape
     * regex special characters. The list of chars we want to actually escape is:
     * + - & | ! ( ) { } [ ] ^ " ~ * ? : \
     * 
     * @param $s string to escape
     * @return string
     */
    protected static function escapeForLuceneStyle($s) {
        return preg_replace('/[\+\-&\|!\(\)\{\}\[\]\^"~\*\?:\\\\]/u','\\\\$0', $s);
    }

}

/** For generating opaque typed internal representations of query
 * filter values and other data structures..
 *
 * @ingroup XN
 */
class XN_Query_InternalType {
    protected $_payload;

    public function __construct($payload) {
        $this->_payload = $payload;
    }

    public function __get($prop) {
        if ($prop == 'payload') {
            return $this->_payload;
        } else {
             throw new Exception('Unknown property: ' . $prop);
        }
    }

    public function __toString() { return $this->_payload; }
    public function _getId() { return $this->_payload; }
}

/** For XN_Query::FRIENDS()
 *
 * @ingroup XN
 */
class XN_Query_InternalType_Friends extends XN_Query_InternalType {
    public function _getId() {
        $s = str_replace('\\','\\\\', $this->payload);
        $s = str_replace("'", "\\'", $this->payload);
        return "friends('".$s."')";
    }
}

/** For XN_Filter(). Expects that the payload is a four element array with
 * keys prop, operator, value, type. This is used to store the user-specified
 * filter parameters so they can be transformed later into the appropriate
 * values based on the query type
 *
 * @ingroup XN
 */
class XN_Query_InternalType_RawFilter extends XN_Query_InternalType {
    // Only for debugging purposes
    public function __toString() { return implode(', ', $this->_payload); }

    /**
     * Converts the payload into an XN_Filter object, with subject-specific
     * verification and modification
     *
     * @param string|XN_Query_Subject The string query subject, or the strategy
     *   implementation object if that's how the query subject is handled
     *
     * @return XN_Filter|null
     */
    public function _toSubjectSpecificFilter($subjectOrStrategyImplementor) {
        if ($subjectOrStrategyImplementor instanceof XN_Query_Subject) {
            return $subjectOrStrategyImplementor->processFilter($this->payload['prop'],
                                                                $this->payload['operator'],
                                                                $this->payload['value'],
                                                                $this->payload['type']);
            

        } else {
            $filterInfo = null;
            if (strcasecmp($subjectOrStrategyImplementor, 'Content') == 0 || 
				strcasecmp($subjectOrStrategyImplementor, 'SimpleContent') == 0 ||
				strcasecmp($subjectOrStrategyImplementor, 'MainContent') == 0 ||
				strcasecmp($subjectOrStrategyImplementor, 'YearContent') == 0 ||
				strcasecmp($subjectOrStrategyImplementor, 'MainYearContent') == 0 ||
				strcasecmp($subjectOrStrategyImplementor, 'YearmonthContent') == 0 ||
				strcasecmp($subjectOrStrategyImplementor, 'MainYearmonthContent') == 0 ||
				strcasecmp($subjectOrStrategyImplementor, 'Content_Count') == 0 ||
				strcasecmp($subjectOrStrategyImplementor, 'Fulltext') == 0 ||
                strcasecmp($subjectOrStrategyImplementor, 'Search') == 0) {
                $filterInfo = XN_Query::_prepareContentFilter($this->payload['prop'],
                                                              $this->payload['operator'],
                                                              $this->payload['value'],
                                                              $this->payload['type']);
            } else if (strcasecmp($subjectOrStrategyImplementor, 'Profie')||strcasecmp($subjectOrStrategyImplementor, 'Profile_Count') == 0 ) {
                $filterInfo = XN_Query::_prepareProfileFilter($this->payload['prop'],
                                                              $this->payload['operator'],
                                                              $this->payload['value'],
                                                              $this->payload['type']);
            } else {
                throw new XN_IllegalArgumentException("Sub-clauses only allowed on content terms in Content or Search queries");
            }
            if (is_array($filterInfo)) {
                if ($filterInfo['filterType'] != 'content' &&
                    $filterInfo['filterType'] != 'search') {
                    throw new XN_IllegalArgumentException("Sub-clauses only allowed on content terms in Content or Search queries");
                }
                // referencerId is not allowed in sub-clauses
                if (strcasecmp($filterInfo['prop'], 'referencer') == 0) {
                    throw new XN_IllegalArgumentException("referencerId not allowed in sub-clauses");
                }
                $filter = new XN_Filter($filterInfo['prop'], $filterInfo['operator'],
                                        $filterInfo['value'], $filterInfo['type']);
                return $filter;
            }  else {
                return null;
            }
        }
    }
}

/** For XN_Filter::any() and XN_Filter::all()
 * Expects that payload is a two element array:
 * The first element is the combining operator (& or |)
 * The second element is an array of filters
 *
 * @ingroup XN
 */
class XN_Query_InternalType_FilterClause extends XN_Query_InternalType {
    // @todo define a different toString() here (just for debugging) ?
    public function __toString() {
        if (is_array($this->_payload) && isset($this->_payload[0])) {
            $tmp = array();
            if (isset($this->_payload[1]) && is_array($this->_payload[1])) {
                foreach ($this->_payload[1] as $filter) {
                    $tmp[] = $filter->_toSelectorValue();
                }
            }
            return '(' . implode($this->_payload[0], $tmp) . ')';
        } else {
            return '';
        }
    }

    /** @internal @unsupported
     * Converts a filter clause (::any(), ::all()) into a tree of filters with
     * potential subtrees
     *
     * @param string|XN_Query_Subject The string query subject, or the strategy
     *   implementation object if that's how the query subject is handled
     * @return array
     */
    public function _toFilterTree($subjectOrStrategyImplementor) {
        $tree = array();
        if (is_array($this->_payload) && isset($this->_payload[0])) {
            $tree[] = $this->payload[0];
            if (isset($this->_payload[1]) && is_array($this->payload[1])) {
                foreach ($this->_payload[1] as $rawFilter) {
                    if ($rawFilter instanceof XN_Query_InternalType_RawFilter) {
                        $tree[] = $rawFilter->_toSubjectSpecificFilter($subjectOrStrategyImplementor);
                    } else if ($rawFilter instanceof XN_Query_InternalType_FilterClause) {
                        $tree[] = $rawFilter->_toFilterTree($subjectOrStrategyImplementor);
                    } else {
                        throw new XN_IllegalArgumentException("$rawFilter is neither a raw filter nor a filter clause");
                    }
                }
            }
        }
        // The $tree array for a clause has the operator as the first element and then
        // the rest of the elements are either filters or subtrees
        return $tree;
    }
}

/** @endcond (hiding internal classes) */
 } // class_exists()

<?php
include_once('config.php');
require_once('include/utils/utils.php');

class Mall_Shares extends CRMEntity {
	
	public $table_name = 'mall_shares';
	public $table_index= 'id';
	public $default_published_section = 'day';//month day year
	public $tab_name = Array('mall_shares');
	public $tab_name_index = Array('mall_shares'=>'id');
	public $customFieldTable = Array('mall_shares', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('shares_no','profileid','sharedate','pv','uv','orderscount','sharepage','sharedatetime');
	public $list_link_field= 'shares_no';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(
	);
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('shares_no');
    public $special_search_fields = array(
/*        'order_status' => array(
            '' => array('value'=>'','label'=>'全部','operator'=>'='),
            'index' => array('value'=>'index','label'=>'待付款','operator'=>'='),
            'trade' => array('value'=>'trade','label'=>'成交','operator'=>'='),
            '已付款' => array('value'=>'已付款','label'=>'已付款','operator'=>'='),
            '已发货' => array('value'=>'已发货','label'=>'已发货','operator'=>'='),
            '退货中' => array('value'=>'退货中','label'=>'退货中','operator'=>'='),
            '已退货' => array('value'=>'已退货','label'=>'已退货','operator'=>'='),
            '确认收货' => array('value'=>'确认收货','label'=>'确认收货','operator'=>'='),
        ),*/
    );
	var $sortby_number_fields = Array('shares_no','pv','uv','orderscount');
	
    function Mall_Shares() {
		
		$this->column_fields = getColumnFields('Mall_Shares');
	}

	function save_module($module){}

	function getSortOrder() {
		
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['MALL_SHARES_SORT_ORDER'] != '')?($_SESSION['MALL_SHARES_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}
	
	function getOrderBy() {
		
		$use_default_order_by = $this->default_order_by;
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['MALL_SHARES_ORDER_BY'] != '')?($_SESSION['MALL_SHARES_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}
}?>
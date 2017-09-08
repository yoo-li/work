<?php
include_once('config.php');
require_once('include/utils/utils.php');

class Mall_OfficialSettlements extends CRMEntity {
	
	public $table_name = 'mall_officialsettlements';
    public $datatype='7';
	public $table_index= 'id';
	public $tab_name = Array('mall_officialsettlements');
	public $tab_name_index = Array('mall_officialsettlements'=>'id');
	public $customFieldTable = Array('mall_officialsettlements', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('mall_officialsettlements_no','suppliers','ordername','purchases','consignee','mobile','address','sumorderstotal','orderstotal','paymentamount','usemoney','order_status','orderssources','isinvoice','singletime','paymenttime','confirmreceipt_time','settlementstatus');
	public $list_link_field= 'mall_officialsettlements_no';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(
	);
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('mall_officialsettlements_no');
	
	var $popup_fields = Array('mall_officialsettlements_no','consignee','mobile','orderstotal','order_status');

	var $sortby_number_fields = Array('mall_officialsettlements_no','mobile','orderstotal','paymentamount','usemoney');
	
	public $special_search_fields = array(
		'order_status' => array(
			'' => array('value'=>'全部','label'=>'全部','operator'=>'='),
			'待付款' => array('value'=>'待付款','label'=>'待付款','operator'=>'='),
			'确认下单' => array('value'=>'确认下单','label'=>'确认下单','operator'=>'='),
			'trade' => array('value'=>'trade','label'=>'成交','operator'=>'='),
			'已付款' => array('value'=>'已付款','label'=>'已付款','operator'=>'='),
			'已发货' => array('value'=>'已发货','label'=>'已发货','operator'=>'='),
			'退货中' => array('value'=>'退货中','label'=>'退货中','operator'=>'='),
			'已退货' => array('value'=>'已退货','label'=>'已退货','operator'=>'='),
		    '已退款' => array('value'=>'已退款','label'=>'已退款','operator'=>'='),
			'确认收货' => array('value'=>'确认收货','label'=>'确认收货','operator'=>'='),
		),
		'platform' => array(
			'' => array('value'=>'全部','label'=>'全部','operator'=>'='),
			'公众号' => array('value'=>'公众号','label'=>'公众号','operator'=>'='),
			'web' => array('value'=>'web','label'=>'网站','operator'=>'='),
			'iOS' => array('value'=>'iOS','label'=>'iOS','operator'=>'='),
			'安卓' => array('value'=>'安卓','label'=>'安卓','operator'=>'='),
		),
	);
	
	function Mall_OfficialSettlements() {
		
		$this->column_fields = getColumnFields('Mall_OfficialSettlements');
	}

	function save_module($module){}

	function getSortOrder() {
		
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['MALL_ORDERS_SORT_ORDER'] != '')?($_SESSION['MALL_ORDERS_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}
	
	function getOrderBy() {
		
		$use_default_order_by = $this->default_order_by;
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['MALL_ORDERS_ORDER_BY'] != '')?($_SESSION['MALL_ORDERS_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}
}?>
<?php
include_once('config.php');
require_once('include/utils/utils.php');

class Mall_SettlementOrders extends CRMEntity {
	
	public $table_name = 'mall_settlementorders';
    public $datatype='7';
	public $table_index= 'id';
	public $tab_name = Array('mall_settlementorders');
	public $tab_name_index = Array('mall_settlementorders'=>'id');
	public $customFieldTable = Array('mall_settlementorders', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('orderid','profileid','productid','propertydesc','shop_price','quantity','totalmoney','vendorid','vendor_price','vendormoney','vendorsettlementid','vendorsettlementstatus','vendorsettlementtime','mall_settlementordersstatus');
	public $list_link_field= 'mall_settlementorders_no';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(
	);
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('mall_settlementorders_no');
	
	var $popup_fields = Array();

	var $sortby_number_fields = Array('shop_price','quantity','totalmoney','vendor_price','vendormoney');
	
	public $special_search_fields = array(
		'vendorsettlementstatus' => array(
			'' => array('value'=>'全部','label'=>'全部','operator'=>'='),
			'0' => array('value'=>'0','label'=>'不可结算','operator'=>'='),
			'1' => array('value'=>'1','label'=>'可结算','operator'=>'='),
			'2' => array('value'=>'2','label'=>'已提交','operator'=>'='), 
			'3' => array('value'=>'3','label'=>'结算完成','operator'=>'='),
			'4' => array('value'=>'4','label'=>'退货中','operator'=>'='), 
			'5' => array('value'=>'5','label'=>'已退货','operator'=>'='), 
		),  
		'deliverystatus' => array(
			'' => array('value'=>'全部','label'=>'全部','operator'=>'='),
			'0' => array('value'=>'0','label'=>'待发货','operator'=>'='),
			'1' => array('value'=>'1','label'=>'已发货','operator'=>'='),  
		), 
	);
	 
	
	function Mall_SettlementOrders() {
		
		$this->column_fields = getColumnFields('Mall_SettlementOrders');
	}

	function save_module($module){}

	function getSortOrder() {
		
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['MALL_SETTLEMENTORDERS_SORT_ORDER'] != '')?($_SESSION['MALL_SETTLEMENTORDERS_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}
	
	function getOrderBy() {
		
		$use_default_order_by = $this->default_order_by;
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['MALL_SETTLEMENTORDERS_ORDER_BY'] != '')?($_SESSION['MALL_SETTLEMENTORDERS_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}
}?>
<?php
include_once('config.php');
require_once('include/utils/utils.php');

class Mall_Bargains extends CRMEntity {
	
	public $table_name = 'mall_bargains'; 
	public $table_index= 'id';
	public $tab_name = Array('mall_bargains');
	public $tab_name_index = Array('mall_bargains'=>'id');
	public $customFieldTable = Array('mall_bargains', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('mall_bargains_no','mall_bargainsname','sequence','usestatus',);
    var $sortby_number_fields = Array('sequence');	
	public $list_link_field= 'mall_bargainsname';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(
	);
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('mall_bargains_no');

	var $popup_fields =  Array('mall_bargains_no','mall_bargainsname','sequence',);
	var $select_fields = array(
		'Location' => array('mall_bargains_no','mall_bargainsname',),
	);
	var $filter_fields = Array('mall_bargainsname',);
	
	function Mall_Bargains() {
		
		$this->column_fields = getColumnFields('Mall_Bargains');
	}

	function save_module($module){}

	function getSortOrder() {
		
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['MALL_ORDERS_PRODUCTS_SORT_ORDER'] != '')?($_SESSION['MALL_ORDERS_PRODUCTS_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}
	
	function getOrderBy() {
		
		$use_default_order_by = $this->default_order_by;
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['MALL_ORDERS_PRODUCTS_ORDER_BY'] != '')?($_SESSION['MALL_ORDERS_PRODUCTS_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}
	
    
	
	
}?>
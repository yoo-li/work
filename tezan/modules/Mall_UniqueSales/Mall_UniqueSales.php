<?php
include_once('config.php');
require_once('include/utils/utils.php');

class Mall_UniqueSales extends CRMEntity {
	
	public $table_name = 'mall_uniquesales'; 
	public $table_index= 'id';
	public $tab_name = Array('mall_uniquesales');
	public $tab_name_index = Array('mall_uniquesales'=>'id');
	public $customFieldTable = Array('mall_uniquesales', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('mall_uniquesales_no','mall_uniquesalesname','sequence','usestatus',);
    var $sortby_number_fields = Array('sequence');	
	public $list_link_field= 'mall_uniquesalesname';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(
	);
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('mall_uniquesales_no');

	var $popup_fields =  Array('mall_uniquesales_no','mall_uniquesalesname','sequence',);
	var $select_fields = array(
		'Location' => array('mall_uniquesales_no','mall_uniquesalesname',),
	);
	var $filter_fields = Array('mall_uniquesalesname',);
	
	function Mall_UniqueSales() {
		
		$this->column_fields = getColumnFields('Mall_UniqueSales');
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
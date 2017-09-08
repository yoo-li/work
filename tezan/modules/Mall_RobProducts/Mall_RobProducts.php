<?php
include_once('config.php');
require_once('include/utils/utils.php');

class Mall_RobProducts extends CRMEntity {
	
	public $table_name = 'mall_robproducts'; 
	public $table_index= 'id';
	public $tab_name = Array('mall_robproducts');
	public $tab_name_index = Array('mall_robproducts'=>'id');
	public $customFieldTable = Array('mall_robproducts', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('mall_robproducts_no','mall_robproductsname','sequence','usestatus',);
    var $sortby_number_fields = Array('sequence');	
	public $list_link_field= 'mall_robproductsname';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(
	);
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('mall_robproducts_no');

	var $popup_fields =  Array('mall_robproducts_no','mall_robproductsname','sequence',);
	var $select_fields = array(
		'Location' => array('mall_robproducts_no','mall_robproductsname',),
	);
	var $filter_fields = Array('mall_robproductsname',);
	
	function Mall_RobProducts() {
		
		$this->column_fields = getColumnFields('Mall_RobProducts');
	}

	function save_module($module){}

	function getSortOrder() {
		
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['MALL_ROBPRODUCTS_SORT_ORDER'] != '')?($_SESSION['MALL_ROBPRODUCTS_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}
	
	function getOrderBy() {
		
		$use_default_order_by = $this->default_order_by;
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['MALL_ROBPRODUCTS_ORDER_BY'] != '')?($_SESSION['MALL_ROBPRODUCTS_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}
	
    
	
	
}?>
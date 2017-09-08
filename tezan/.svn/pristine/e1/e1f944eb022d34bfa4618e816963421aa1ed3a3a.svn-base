<?php
include_once('config.php');
require_once('include/utils/utils.php');

class Mall_Categorys extends CRMEntity {
	
	public $table_name = 'mall_categorys';
	public $table_index= 'id';
	public $tab_name = Array('mall_categorys');
	public $tab_name_index = Array('mall_categorys'=>'id');
	public $customFieldTable = Array('mall_categorys', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('categorys_no');
	public $list_link_field= 'categorys_no';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(
	);
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('categorys_no');
	
	function Mall_Categorys() {
		
		$this->column_fields = getColumnFields('Mall_Categorys');
	}

	function save_module($module){}

	function getSortOrder() {
		
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['MALL_CATEGORYS_SORT_ORDER'] != '')?($_SESSION['MALL_CATEGORYS_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}
	
	function getOrderBy() {
		
		$use_default_order_by = $this->default_order_by;
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['MALL_CATEGORYS_ORDER_BY'] != '')?($_SESSION['MALL_CATEGORYS_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}
}?>
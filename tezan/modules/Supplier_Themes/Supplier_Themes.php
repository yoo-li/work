<?php
include_once('config.php');
require_once('include/utils/utils.php');
class Supplier_Themes extends CRMEntity {
	public $table_name = 'supplier_themes';
	public $table_index= 'id';
	public $tab_name = Array('supplier_themes');
	public $tab_name_index = Array('supplier_themes'=>'id');
	public $customFieldTable = Array('supplier_themes', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('published');
	public $list_link_field= 'modulename';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(
	);
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('modulename');
 	var $popup_fields = Array('modulename','contact','mobile');
	var $filter_fields = Array('modulename','contact','mobile');
	var $sortby_number_fields = Array();
	

	function Supplier_Themes() {
		$this->column_fields = getColumnFields('Supplier_Themes');
	}

	function save_module($module){}

	function getSortOrder() {
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['SUPPLIER_THEMES_SORT_ORDER'] != '')?($_SESSION['SUPPLIER_THEMES_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}
	
	function getOrderBy() {
		$use_default_order_by = $this->default_order_by;
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['SUPPLIER_THEMES_ORDER_BY'] != '')?($_SESSION['SUPPLIER_THEMES_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}
}
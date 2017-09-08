<?php
include_once('config.php');
require_once('include/utils/utils.php');

class Supplier_ReportSettings extends CRMEntity {
	public $table_name = 'supplier_reportsettings';
	public $table_index= 'id';
	public $tab_name = Array('supplier_reportsettings');
	public $tab_name_index = Array('supplier_reportsettings'=>'id');
	public $customFieldTable = Array('supplier_reportsettings', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array();
	public $list_link_field= '';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(
	);
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('');
	
	
	var $popup_fields = Array();
	var $filter_fields = Array();
	var $sortby_number_fields = Array();
	
	
	var $select_fields = array(
	);
	
	public $special_search_fields = array(
	);
	
	function Supplier_ReportSettings() {
		$this->column_fields = getColumnFields('Supplier_ReportSettings');
	}

	function save_module($module){}

	function getSortOrder() {
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['SUPPLIER_REPORTSETTINGS_SORT_ORDER'] != '')?($_SESSION['SUPPLIER_REPORTSETTINGS_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}
	
	function getOrderBy() {
		$use_default_order_by = $this->default_order_by;
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['SUPPLIER_REPORTSETTINGS_ORDER_BY'] != '')?($_SESSION['SUPPLIER_REPORTSETTINGS_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}
}
<?php
include_once('config.php');
require_once('include/utils/utils.php');

class PotenitalSuppliers extends CRMEntity {
	
	public $table_name = 'potenitalsuppliers';
	public $table_index= 'id';
	public $tab_name = Array('potenitalsuppliers');
	public $tab_name_index = Array('potenitalsuppliers'=>'id');
	public $customFieldTable = Array('potenitalsuppliers', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('profileid','mobile','gystype','description','potenitalsuppliersstatus');
	var $sortby_number_fields = Array();
	public $list_link_field= 'mobile';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(
	);
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('potenitalsuppliers_no');
    public $special_search_fields = array(
      
    );
	//var $sortby_number_fields = Array('potenitalsuppliers_no');
	
    function PotenitalSuppliers() {
		
		$this->column_fields = getColumnFields('PotenitalSuppliers');
	}

	function save_module($module){}

	function getSortOrder() {
		
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['POTENITALSUPPLIERS_SORT_ORDER'] != '')?($_SESSION['POTENITALSUPPLIERS_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}
	
	function getOrderBy() {
		
		$use_default_order_by = $this->default_order_by;
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['POTENITALSUPPLIERS_ORDER_BY'] != '')?($_SESSION['POTENITALSUPPLIERS_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}
}?>
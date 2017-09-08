<?php
include_once('config.php');
require_once('include/utils/utils.php');

class Supplier_Users extends CRMEntity {
	
	public $table_name = 'supplier_users';
	public $table_index= 'id';
	public $default_published_section = 'year';//month day year
	public $tab_name = Array('supplier_users');
	public $tab_name_index = Array('supplier_users'=>'id');
	public $customFieldTable = Array('supplier_users', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('supplierid','account','email','mobile','supplierusertype','status',);
    var $sortby_number_fields = Array('sequence');	
	public $list_link_field= 'account';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(
	);
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('supplier_users_no');

	var $popup_fields =  Array();
	var $select_fields = array();
	var $filter_fields = Array('account',);
	
	function __construct() {
		
		$this->column_fields = getColumnFields('Supplier_Users');
	}

	function save_module($module){}

	function getSortOrder() {
		
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['SUPPLIER_USERS_SORT_ORDER'] != '')?($_SESSION['SUPPLIER_USERS_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}
	
	function getOrderBy() {
		
		$use_default_order_by = $this->default_order_by;
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['SUPPLIER_USERS_ORDER_BY'] != '')?($_SESSION['SUPPLIER_USERS_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}
}?>
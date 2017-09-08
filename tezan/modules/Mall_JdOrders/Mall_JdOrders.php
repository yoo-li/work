<?php
include_once('config.php');
require_once('include/utils/utils.php');

class Mall_JdOrders extends CRMEntity {
	
	public $table_name = 'mall_jdorders'; 
	public $datatype = '7';
	public $table_index= 'id';
	public $tab_name = Array('mall_jdorders');
	public $tab_name_index = Array('mall_jdorders'=>'id');
	public $customFieldTable = Array('mall_jdorders', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('usagename','sequence','status','pinyin','cityid');
    public $sortby_number_fields = Array('usagename','sequence');
	public $list_link_field= 'usagename';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(
	);
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('usagename');

	var $popup_fields =  Array('usagename','pinyin','sequence');
	var $select_fields = array(
		'Location' => array('usagename','usagename',),
	);
	var $filter_fields = Array('usagename','pinyin');
	
	function Mall_JdOrders() {
		
		$this->column_fields = getColumnFields('Mall_JdOrders');
	}

	function save_module($module){}

	function getSortOrder() {
		
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['MALL_USAGES_SORT_ORDER'] != '')?($_SESSION['MALL_USAGES_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}
	
	function getOrderBy() {
		
		$use_default_order_by = $this->default_order_by;
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['MALL_USAGES_ORDER_BY'] != '')?($_SESSION['MALL_USAGES_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}
}?>
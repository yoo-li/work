<?php
include_once('config.php');

require_once('include/utils/utils.php');

class BaiduPushs extends CRMEntity {
	
	public $table_name = 'baidupushs';
	public $table_index= 'id';
	public $tab_name = Array('baidupushs');
	public $tab_name_index = Array('baidupushs'=>'id');
	public $customFieldTable = Array('baidupushs', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('gender','birthdate','logindate',"lastsingletime","lastpaymenttime","directpayamount","direct_ordersnum","indirectpayamount","indirect_ordersnum","lastsignaturetime");
	var $sortby_number_fields = Array('directpayamount','direct_ordersnum','indirectpayamount','indirect_ordersnum');
	public $list_link_field= 'baidupushs_no';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(
	);
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('baidupushs_no');
    public $special_search_fields = array(
      
    );
	//var $sortby_number_fields = Array('baidupushs_no');
	
    function BaiduPushs() {
		
		$this->column_fields = getColumnFields('BaiduPushs');
	}

	function save_module($module){}

	function getSortOrder() {
		
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['BAIDUPUSHS_SORT_ORDER'] != '')?($_SESSION['BAIDUPUSHS_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}
	
	function getOrderBy() {
		
		$use_default_order_by = $this->default_order_by;
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['BAIDUPUSHS_ORDER_BY'] != '')?($_SESSION['BAIDUPUSHS_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}
}?>
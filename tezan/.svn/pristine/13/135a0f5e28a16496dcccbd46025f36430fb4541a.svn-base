<?php
include_once('config.php');
require_once('include/utils/utils.php');

class Ma_CheckInventoryWarns extends CRMEntity {
	public $table_name = 'ma_checkinventorywarns';
	public $table_index= 'id';
	public $tab_name = Array('ma_checkinventorywarns');
	public $tab_name_index = Array('ma_checkinventorywarns'=>'id');
	public $customFieldTable = Array('ma_checkinventorywarns', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('ma_products','ma_factorys','ma_agencys','ma_hospitals','certificate_end_date','published');
	public $list_link_field= 'ma_products';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(
	);
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('ma_products');
    public $special_search_fields = array(
      
    );
	var $sortby_number_fields = Array('ma_products');
	
    function Ma_CheckInventoryWarns() {
		$this->column_fields = getColumnFields('Ma_CheckInventoryWarns');
	}

	function save_module($module){}

	function getSortOrder() {
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['MA_CHECKINVENTORYWARNS_SORT_ORDER'] != '')?($_SESSION['MA_CHECKINVENTORYWARNS_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}
	
	function getOrderBy() {
		$use_default_order_by = $this->default_order_by;
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['MA_CHECKINVENTORYWARNS_ORDER_BY'] != '')?($_SESSION['MA_CHECKINVENTORYWARNS_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}
}?>
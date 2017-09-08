<?php
include_once('config.php');
require_once('include/utils/utils.php');

class Mall_MyCollections extends CRMEntity {
	
	public $table_name = 'mall_mycollections';
	public $table_index= 'id';
	public $tab_name = Array('mall_mycollections');
	public $tab_name_index = Array('mall_mycollections'=>'id');
	public $customFieldTable = Array('mall_mycollections', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('mycollections_no','operprofileid','profileid','opertype','oldrank','rank','oldmoney','amount','money','published');
	public $list_link_field= 'mycollections_no';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(
	);
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('mycollections_no');
    public $special_search_fields = array(
      
    );
	var $sortby_number_fields = Array('mycollections_no','oldrank','rank','oldmoney','amount','money');
	
    function Mall_MyCollections() {
		
		$this->column_fields = getColumnFields('Mall_MyCollections');
	}

	function save_module($module){}

	function getSortOrder() {
		
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['MALL_MYCOLLECTIONS_SORT_ORDER'] != '')?($_SESSION['MALL_MYCOLLECTIONS_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}
	
	function getOrderBy() {
		
		$use_default_order_by = $this->default_order_by;
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['MALL_MYCOLLECTIONS_ORDER_BY'] != '')?($_SESSION['MALL_MYCOLLECTIONS_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}
}?>
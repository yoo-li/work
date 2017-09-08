<?php
include_once('config.php');
require_once('include/utils/utils.php');

class Mall_OfficialRankLog extends CRMEntity {
	
	public $table_name = 'mall_officialranklog';
	public $table_index= 'id';
	public $tab_name = Array('mall_officialranklog');
	public $tab_name_index = Array('Mall_OfficialRankLog'=>'id');
	public $customFieldTable = Array('Mall_OfficialRankLog', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('mall_officialranklogstatus');
	public $list_link_field= 'id';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(); 
	
	var $popup_fields = Array('mall_officialranklogstatus');
	var $filter_fields = Array('mall_officialranklogstatus');
	
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('published');
    public $special_search_fields = array();
	var $sortby_number_fields = Array('mall_officialranklogstatus','published');
	
    function Mall_OfficialRankLog() {
		
		$this->column_fields = getColumnFields('Mall_OfficialRankLog');
	}

	function save_module($module){} 

	function getSortOrder() {
		
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION[strtoupper($this->table_name).'_SORT_ORDER'] != '')?($_SESSION[strtoupper($this->table_name).'_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}
	
	function getOrderBy() {
		
		$use_default_order_by = $this->default_order_by;
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION[strtoupper($this->table_name).'_ORDER_BY'] != '')?($_SESSION[strtoupper($this->table_name).'_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}
}?>
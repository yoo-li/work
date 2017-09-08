<?php
include_once('config.php');
require_once('include/utils/utils.php');

class Mall_OfficialShiduLogs extends CRMEntity {
	
	public $table_name = 'mall_officialshidulogs';
	public $table_index= 'id';
    public $datetype='7';
	public $tab_name = Array('mall_officialshidulogs');
	public $tab_name_index = Array('mall_officialshidulogs'=>'id');
	public $customFieldTable = Array('mall_officialshidulogs', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('supplierid', 'profileid','orderid','shidu_beforemoney', 'shidu_changemoney','shidu_aftermoney','credit_beforemoney','credit_changemoney','credit_aftermoney','consumetype','published');
	public $list_link_field= 'id';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(); 
	
	var $popup_fields = Array();
	var $filter_fields = Array();
	
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('published');
    public $special_search_fields = array();
	var $sortby_number_fields = Array('shidu_beforemoney', 'shidu_changemoney','shidu_aftermoney','credit_beforemoney','credit_changemoney','credit_aftermoney',);
	
    function __construct() {
		
		$this->column_fields = getColumnFields('Mall_OfficialShiduLogs');
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
<?php
include_once('config.php');
require_once('include/utils/utils.php');

class Mall_LogisticDrivers extends CRMEntity {
	
	public $table_name = 'mall_logisticdrivers';
	public $table_index= 'id';
	public $tab_name = Array('mall_logisticdrivers');
	public $tab_name_index = Array('mall_logisticdrivers'=>'id');
	public $customFieldTable = Array('mall_logisticdrivers', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('mall_logisticdrivers_no','brand_name','site_url','brand_desc','is_show');
	public $list_link_field= 'brand_name';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(
	);
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('brands_no');
    public $special_search_fields = array( 
    );
    var $popup_fields = Array('brand_name','suppliers','brand_desc','site_url');
    var $filter_fields = Array('brand_name','brand_desc','site_url');
    var $sortby_number_fields = Array('brands_no');
    
    function Mall_LogisticDrivers() {
		
		$this->column_fields = getColumnFields('Mall_LogisticDrivers');
	}
    public function approval_event($record,$event) {
        
    }
	function save_module($module){}

	function getSortOrder() {
		
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['MALL_LOGISTICDRIVERS_SORT_ORDER'] != '')?($_SESSION['MALL_LOGISTICDRIVERS_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}
	
	function getOrderBy() {
		
		$use_default_order_by = $this->default_order_by;
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['MALL_LOGISTICDRIVERS_ORDER_BY'] != '')?($_SESSION['MALL_LOGISTICDRIVERS_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}
}?>
<?php
include_once('config.php');
require_once('include/utils/utils.php');

class Mall_Vendors extends CRMEntity {
	
	public $table_name = 'mall_vendors';
	public $table_index= 'id';
	public $tab_name = Array('mall_vendors');
	public $tab_name_index = Array('mall_vendors'=>'id');
	public $customFieldTable = Array('mall_vendors', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('vendorname','telphone','status','mall_vendorsstatus');
	public $list_link_field= 'vendorname';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(
	);
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('vendorname');
    public $special_search_fields = array(
        
    );
    var $popup_fields = Array('vendorname','telphone','status','mall_vendorsstatus');
    var $filter_fields = Array('vendorname','account','telphone');
    var $sortby_number_fields = Array();
 
    
    function Mall_Vendors() {
		
		$this->column_fields = getColumnFields('Mall_Vendors');
	}
    public function approval_event($record,$event) {
        
    }
	function save_module($module){}

	function getSortOrder() {
		
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['MALL_VENDORS_SORT_ORDER'] != '')?($_SESSION['MALL_VENDORS_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}
	
	function getOrderBy() {
		
		$use_default_order_by = $this->default_order_by;
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['MALL_VENDORS_ORDER_BY'] != '')?($_SESSION['MALL_VENDORS_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}
}?>
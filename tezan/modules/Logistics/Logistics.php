<?php
include_once('config.php');
require_once('include/utils/utils.php');

class Logistics extends CRMEntity {
	
	
	var $verify_data_fields = Array('template_data');
	
	public $table_name = 'logistics';
	public $table_index= 'id';
	public $tab_name = Array('logistics');
	public $tab_name_index = Array('logistics'=>'id');
	public $customFieldTable = Array('logistics', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('logistics_no','telphone','site','status','sequence');
	public $list_link_field= 'logisticsname';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(
	);
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('logistics_no');
    public $special_search_fields = array(
      
    );
	var $popup_fields = Array('logisticsname','telphone','site','status','sequence');
	var $filter_fields = Array('logisticsname','telphone');

    function Logistics() {
		
		$this->column_fields = getColumnFields('Logistics');
	}

	function save_module($module){}

	function getSortOrder() {
		
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['LOGISTICS_SORT_ORDER'] != '')?($_SESSION['LOGISTICS_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}
	
	function getOrderBy() {
		
		$use_default_order_by = $this->default_order_by;
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['LOGISTICS_ORDER_BY'] != '')?($_SESSION['LOGISTICS_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}
}?>
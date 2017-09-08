<?php
include_once('config.php');

require_once('include/utils/utils.php');

class Smslog extends CRMEntity {
	
	public $table_name = 'Smslog';
	public $table_index= 'id';
	public $tab_name = Array('Smslog');
	public $tab_name_index = Array('Smslog'=>'id');
	public $customFieldTable = Array('Smslog', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('smslogid','mobile','sendtype','smsinfo','published');
	public $list_link_field= '';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(
	);
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array();
	
	
	var $popup_fields = Array();
	var $filter_fields = Array();
	var $sortby_number_fields = Array();
	
	
	var $select_fields = array(
	);
	
	public $special_search_fields = array(
	);
	
	function Smslog() {
		
		$this->column_fields = getColumnFields('Smslog');
	}

	function save_module($module){}

	function getSortOrder() {
		
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['Smslog_SORT_ORDER'] != '')?($_SESSION['Smslog_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}
	
	function getOrderBy() {
		
		$use_default_order_by = $this->default_order_by;
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['Smslog_ORDER_BY'] != '')?($_SESSION['Smslog_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}
}?>
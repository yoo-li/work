<?php
include_once('config.php'); 
require_once('include/utils/utils.php');

class Domains extends CRMEntity {
	public $table_name = 'domains';
	public $table_index= 'id';
	public $tab_name = Array('domains');
	public $tab_name_index = Array('domains'=>'id');
	public $customFieldTable = Array('domains', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('domains_no','domain','domaindescription','province','city','agentname','startdate','enddate','status');
	public $list_link_field= 'domains_no';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(
	);
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('domains_no');
    public $special_search_fields = array(
      
    ); 
	var $sortby_number_fields = Array('domains_no');
	
    function Domains() { 
		$this->column_fields = getColumnFields('Domains');
	}

	function save_module($module){}

	function getSortOrder() {
		
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['DOMAINS_SORT_ORDER'] != '')?($_SESSION['DOMAINS_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}
	
	function getOrderBy() {
		
		$use_default_order_by = $this->default_order_by;
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['DOMAINS_ORDER_BY'] != '')?($_SESSION['DOMAINS_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}
}?>
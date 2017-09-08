<?php
include_once('config.php');

require_once('include/utils/utils.php');

class AdMessages extends CRMEntity {
	
	public $table_name = 'admessages';
	public $table_index= 'id';
	public $default_published_section = 'day';//month day year
	public $tab_name = Array('admessages');
	public $tab_name_index = Array('admessages'=>'id');
	public $customFieldTable = Array('admessages', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('profileid',"appid",'suppliers','message');
	var $sortby_number_fields = Array('profileid',"appid",'suppliers','message');
	public $list_link_field= 'admessages_no';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(
	);
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('admessages_no');
    public $special_search_fields = array(
      
    );
	//var $sortby_number_fields = Array('admessages_no');
	
    function AdMessages() {
		
		$this->column_fields = getColumnFields('AdMessages');
	}

	function save_module($module){}

	function getSortOrder() {
		
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['ADMESSAGES_SORT_ORDER'] != '')?($_SESSION['ADMESSAGES_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}
	
	function getOrderBy() {
		
		$use_default_order_by = $this->default_order_by;
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['ADMESSAGES_ORDER_BY'] != '')?($_SESSION['ADMESSAGES_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}
}?>
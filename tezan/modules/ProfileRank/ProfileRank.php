<?php
include_once('config.php');
require_once('include/utils/utils.php');

class ProfileRank extends CRMEntity {
	
	public $table_name = 'profilerank';
	public $table_index= 'id';
	public $tab_name = Array('profilerank');
	public $tab_name_index = Array('profilerank'=>'id');
	public $customFieldTable = Array('profilerank', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('profilerank_no',);
	public $list_link_field= 'profilerank_no';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(
	);
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('profilerank_no');
    public $special_search_fields = array(
      
    );

    function ProfileRank() {
		
		$this->column_fields = getColumnFields('ProfileRank');
	}

	function save_module($module){}

	function getSortOrder() {
		
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['PROFILERANK_SORT_ORDER'] != '')?($_SESSION['PROFILERANK_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}
	
	function getOrderBy() {
		
		$use_default_order_by = $this->default_order_by;
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['PROFILERANK_ORDER_BY'] != '')?($_SESSION['PROFILERANK_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}
}?>
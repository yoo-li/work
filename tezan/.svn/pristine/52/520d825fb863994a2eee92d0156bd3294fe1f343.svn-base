<?php
include_once('config.php');
require_once('include/utils/utils.php');

class WxRoles extends CRMEntity {
	
	public $table_name = 'wxroles';
	public $table_index= 'id';
	public $tab_name = Array('wxroles');
	public $tab_name_index = Array('wxroles'=>'id');
	public $customFieldTable = Array('wxroles', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('wxroles_no',);
	public $list_link_field= 'wxroles_no';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(
	);
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('wxroles_no');
    public $special_search_fields = array(
      
    );

    function WxRoles() {
		
		$this->column_fields = getColumnFields('WxRoles');
	}

	function save_module($module){}

	function getSortOrder() {
		
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['WXROLES_SORT_ORDER'] != '')?($_SESSION['WXROLES_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}
	
	function getOrderBy() {
		
		$use_default_order_by = $this->default_order_by;
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['WXROLES_ORDER_BY'] != '')?($_SESSION['WXROLES_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}
}?>
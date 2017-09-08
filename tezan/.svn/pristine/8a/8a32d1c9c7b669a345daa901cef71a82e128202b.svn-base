<?php
include_once('config.php');
require_once('include/utils/utils.php');

class Mall_Turnovers extends CRMEntity {
	
	public $table_name = 'mall_turnovers';
	public $table_index= 'id';
    public $datatype='7';
	public $tab_name = Array('mall_turnovers');
	public $tab_name_index = Array('mall_turnovers'=>'id');
	public $customFieldTable = Array('mall_turnovers', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('mall_turnovers_no','products','property','turnoversstatus','oldinventorys','newinventorys');
	public $list_link_field= 'mall_turnovers_no';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(
	);
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('mall_turnovers_no');
    public $special_search_fields = array(
      
    );
	var $sortby_number_fields = Array('mall_turnovers_no','oldinventorys','newinventorys');
    function Mall_Turnovers() {
		
		$this->column_fields = getColumnFields('Mall_Turnovers');
	}

	function save_module($module){}

	function getSortOrder() {
		
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['MALL_TURNOVERS_SORT_ORDER'] != '')?($_SESSION['MALL_TURNOVERS_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}
	
	function getOrderBy() {
		
		$use_default_order_by = $this->default_order_by;
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['MALL_TURNOVERS_ORDER_BY'] != '')?($_SESSION['MALL_TURNOVERS_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}
}?>
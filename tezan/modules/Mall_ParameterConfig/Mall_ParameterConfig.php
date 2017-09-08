<?php
include_once('config.php');
require_once('include/utils/utils.php');

class Mall_ParameterConfig extends CRMEntity {
	
	public $table_name = 'mall_parameterconfig';
	public $table_index= 'id';
	public $tab_name = Array('mall_parameterconfig');
	public $tab_name_index = Array('mall_parameterconfig'=>'id');
	public $customFieldTable = Array('parameterconfig', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('parametertype');
	public $list_link_field= 'parametername';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(
	);
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('parametername');
    public $special_search_fields = array(
      
    );
	var $sortby_number_fields = Array('parametertype');
	
    function Mall_ParameterConfig() {
		
		$this->column_fields = getColumnFields('Mall_ParameterConfig');
	}

	function save_module($module){}

	function getSortOrder() {
		
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['MALL_PARAMETERCONFIG_SORT_ORDER'] != '')?($_SESSION['MALL_PARAMETERCONFIG_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}
	
	function getOrderBy() {
		
		$use_default_order_by = $this->default_order_by;
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['MALL_PARAMETERCONFIG_ORDER_BY'] != '')?($_SESSION['MALL_PARAMETERCONFIG_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}
}?>
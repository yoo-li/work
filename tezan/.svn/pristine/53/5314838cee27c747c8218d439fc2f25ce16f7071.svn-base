<?php
include_once('config.php');
require_once('include/utils/utils.php');

class Supplier_Recharges extends CRMEntity {
	
	public $table_name = 'supplier_recharges';
	public $table_index= 'id';
	public $tab_name = Array('supplier_recharges');
	public $tab_name_index = Array('supplier_recharges'=>'id');
	public $customFieldTable = Array('supplier_recharges', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('adname','adtype','adlocation','timeset','sequence','starttime','endtime','status');
	public $sortby_number_fields = Array('sequence');	
	public $list_link_field= 'adname';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(
	);
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('supplier_recharges_no');
    public $special_search_fields = array(
        'status' => array(
            '0' => array('value'=>'0','label'=>'启用','operator'=>'='),
            '1' => array('value'=>'1','label'=>'停用','operator'=>'='),
        ),
    );
	
	function Supplier_Recharges() {
		
		$this->column_fields = getColumnFields('Supplier_Recharges');
	}

	function save_module($module){}

	function getSortOrder() {
		
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['SUPPLIER_RECHARGES_SORT_ORDER'] != '')?($_SESSION['SUPPLIER_RECHARGES_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}
	
	function getOrderBy() {
		
		$use_default_order_by = $this->default_order_by;
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['SUPPLIER_RECHARGES_ORDER_BY'] != '')?($_SESSION['SUPPLIER_RECHARGES_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}
}?>
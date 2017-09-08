<?php
include_once('config.php');
require_once('include/utils/utils.php');

class Supplier_FrozenLists extends CRMEntity {
	
	public $table_name = 'supplier_frozenlists';
	public $table_index= 'id';
	public $tab_name = Array('supplier_frozenlists');
	public $tab_name_index = Array('supplier_frozenlists'=>'id');
	public $customFieldTable = Array('supplier_frozenlists', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('supplier_frozenlists_no','profileid','published');
	public $list_link_field= 'supplier_frozenlists_no';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(
	);
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('supplier_frozenlists_no');
    public $special_search_fields = array(
        'supplier_frozenlistsstatus' => array(
            '' => array('value'=>'All','label'=>'All','operator'=>'='),
            'Frozen' => array('value'=>'Frozen','label'=>'冻结','operator'=>'='),
            'UnFrozen' => array('value'=>'UnFrozen','label'=>'解冻','operator'=>'='),
        ),
    );
	var $sortby_number_fields = Array('supplier_frozenlists_no');
	
    function Supplier_FrozenLists() {
		
		$this->column_fields = getColumnFields('Supplier_FrozenLists');
	}

	function save_module($module){}

	function getSortOrder() {
		
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['SUPPLIER_FROZENLISTS_SORT_ORDER'] != '')?($_SESSION['SUPPLIER_FROZENLISTS_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}
	
	function getOrderBy() {
		
		$use_default_order_by = $this->default_order_by;
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['SUPPLIER_FROZENLISTS_ORDER_BY'] != '')?($_SESSION['SUPPLIER_FROZENLISTS_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}
}?>
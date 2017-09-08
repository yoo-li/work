<?php
include_once('config.php'); 
require_once('include/utils/utils.php');

class Mall_SmkCardRecords extends CRMEntity {
	
	public $table_name = 'mall_smkcardrecords';
	public $table_index= 'id';
	public $tab_name = Array('mall_smkcardrecords');
	public $tab_name_index = Array('mall_smkcardrecords'=>'id');
	public $customFieldTable = Array('mall_smkcardrecords', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('suppliercorrect_no','correctsuppliers_name');
	public $list_link_field= 'correctsuppliers_name';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(
	);
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('suppliercorrect_no');
    public $special_search_fields = array(
        'suppliercorrectstatus' => array(
            '' => array('value'=>'All','label'=>'All','operator'=>'='),
            'Saved' => array('value'=>'Saved','label'=>'Saved','operator'=>'='),
            'Approvaling' => array('value'=>'Approvaling','label'=>'Approvaling','operator'=>'='),
            'Agree' => array('value'=>'Agree','label'=>'Agree','operator'=>'='),
            'Disagree' => array('value'=>'Disagree','label'=>'Disagree','operator'=>'='),
        ),
    );
	var $filter_fields = Array('correctsuppliers_name');
	var $sortby_number_fields = Array('suppliercorrect_no');

    function Mall_SmkCardRecords() {
		$this->column_fields = getColumnFields('Mall_SmkCardRecords');
	}

	function save_module($module){}

    
	function getSortOrder() {
		
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['SUPPLIERS_SORT_ORDER'] != '')?($_SESSION['SUPPLIERS_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}
	
	function getOrderBy() {
		
		$use_default_order_by = $this->default_order_by;
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['SUPPLIERS_ORDER_BY'] != '')?($_SESSION['SUPPLIERS_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}
}?>
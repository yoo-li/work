<?php
include_once('config.php');
require_once('include/utils/utils.php');

class Supplier_Chats extends CRMEntity {
	public $table_name = 'supplier_chats';
	public $table_index= 'id';
	public $tab_name = Array('supplier_chats');
	public $tab_name_index = Array('supplier_chats'=>'id');
	public $customFieldTable = Array('supplier_chats', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('articletitle','articleauthor','articletype','description','status','supplier_chatsstatus');
	public $sortby_number_fields = Array('sequence');	
	public $list_link_field= 'articletitle';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(
	);
	public $search_fields_name = Array(
	);
	var $popup_fields = Array('articletitle','articleauthor','articletype','description','status','supplier_chatsstatus');
	var $filter_fields = Array('articletitle');
	
	public $mandatory_fields = Array('supplier_chats_no');
    public $special_search_fields = array(
        'status' => array(
            '0' => array('value'=>'0','label'=>'启用','operator'=>'='),
            '1' => array('value'=>'1','label'=>'停用','operator'=>'='),
        ),
    );
	
	function Supplier_Chats() {
		
		$this->column_fields = getColumnFields('Supplier_Chats');
	}

	function save_module($module){}

	function getSortOrder() {
		
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['SUPPLIER_CHATS_SORT_ORDER'] != '')?($_SESSION['SUPPLIER_CHATS_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}
	
	function getOrderBy() {
		
		$use_default_order_by = $this->default_order_by;
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['SUPPLIER_CHATS_ORDER_BY'] != '')?($_SESSION['SUPPLIER_CHATS_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}
}?>
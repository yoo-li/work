<?php
include_once('config.php');
require_once('include/utils/utils.php');

class Supplier_WxServices extends CRMEntity {
	
	public $table_name = 'supplier_wxservices';
	public $table_index= 'id';
	public $tab_name = Array('supplier_wxservices');
	public $tab_name_index = Array('supplier_wxservices'=>'id');
	public $customFieldTable = Array('supplier_wxservices', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('wxid','fromprofileid','wxmsgtype','msgcontent','replycount','customservice','lastreplytime','updated','published');
	public $list_link_field= 'supplier_wxservices_no';
	public $default_order_by = 'updated';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(
	);
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('supplier_wxservices_no');
    public $special_search_fields = array(
      
    );

    function __construct() {
		
		$this->column_fields = getColumnFields('Supplier_WxServices');
	}

	function save_module($module){}

	function getSortOrder() {
		
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['SUPPLIER_WXSERVICES_SORT_ORDER'] != '')?($_SESSION['SUPPLIER_WXSERVICES_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}
	
	function getOrderBy() {
		
		$use_default_order_by = $this->default_order_by;
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['SUPPLIER_WXSERVICES_ORDER_BY'] != '')?($_SESSION['SUPPLIER_WXSERVICES_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}
}?>
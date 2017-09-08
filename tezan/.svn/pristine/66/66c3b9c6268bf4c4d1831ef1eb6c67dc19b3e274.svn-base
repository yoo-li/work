<?php
include_once('config.php');
require_once('include/utils/utils.php');

class Supplier_PhysicalStores extends CRMEntity {
	
	public $table_name = 'supplier_physicalstores';
	public $default_published_section = 'year';//month day year
	public $table_index= 'id';
	public $tab_name = Array('supplier_physicalstores');
	public $tab_name_index = Array('supplier_physicalstores'=>'id');
	public $customFieldTable = Array('supplier_physicalstores', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('name','address','district','street','telphone','source','businessestype','businessesstatus','hasthumb','hasvipcard','hascashondelivery','imagescount');
	public $list_link_field= 'name';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(
	);
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('supplier_physicalstores_no');
    public $special_search_fields = array(
      
    );
	 
	var $popup_fields = Array('name','address','district','street','businessestype');
	var $filter_fields = Array('name','district','street');
	var $sortby_number_fields = Array('imagescount');
	
	
    function Supplier_PhysicalStores() {
		
		$this->column_fields = getColumnFields('Supplier_PhysicalStores');
	}

	function save_module($module){}

	function getSortOrder() {
		
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['SUPPLIER_PHYSICALSTORES_SORT_ORDER'] != '')?($_SESSION['SUPPLIER_PHYSICALSTORES_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}
	
	function getOrderBy() {
		
		$use_default_order_by = $this->default_order_by;
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['SUPPLIER_PHYSICALSTORES_ORDER_BY'] != '')?($_SESSION['SUPPLIER_PHYSICALSTORES_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}
	public function approval_event($id,$event) 
	{
		if ($id > 0 && $event == 'Agree') 
		{ 
			approval_physicalstore_agree($id);
		}
	}
	 
		
}?>
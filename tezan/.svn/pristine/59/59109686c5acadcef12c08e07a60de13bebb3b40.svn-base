<?php
include_once('config.php');
require_once('include/utils/utils.php');

class Mall_VipCards extends CRMEntity {
	
	public $table_name = 'mall_vipcards'; 
	public $table_index= 'id';
	public $tab_name = Array('mall_vipcards');
	public $tab_name_index = Array('mall_vipcards'=>'id');
	public $customFieldTable = Array('mall_vipcards', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('vipcardname','sequence','status','pinyin','cityid');
    public $sortby_number_fields = Array('vipcardname','sequence');
	public $list_link_field= 'vipcardname';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(
	);
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('vipcardname');

	var $popup_fields =  Array('vipcardname','pinyin','sequence');
	var $select_fields = array(
		'Location' => array('vipcardname','vipcardname',),
	);
	var $filter_fields = Array('vipcardname','pinyin');
	
	function Mall_VipCards() {
		
		$this->column_fields = getColumnFields('Mall_VipCards');
	}

	function save_module($module){}

	function getSortOrder() {
		
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['MALL_VIPCARDS_SORT_ORDER'] != '')?($_SESSION['MALL_VIPCARDS_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}
	
	function getOrderBy() {
		
		$use_default_order_by = $this->default_order_by;
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['MALL_VIPCARDS_ORDER_BY'] != '')?($_SESSION['MALL_VIPCARDS_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}
}?>
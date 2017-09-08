<?php
include_once('config.php');
require_once('include/utils/utils.php');

class Mall_ShareDatas extends CRMEntity {
	
	public $table_name = 'mall_sharedatas';
	public $table_index= 'id';
	public $tab_name = Array('mall_sharedatas');
	public $tab_name_index = Array('mall_sharedatas'=>'id');
	public $customFieldTable = Array('mall_sharedatas', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('share_title','enablestatus','published','updated');
	public $list_link_field= 'share_title';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(
	);
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('share_title');
    public $special_search_fields = array(
        'enablestatus' => array(
            '0' => array('value'=>'0','label'=>'启用','operator'=>'='),
            '1' => array('value'=>'1','label'=>'禁用','operator'=>'='),
        ),
    );
	var $sortby_number_fields = Array('enablestatus');
	
    function Mall_ShareDatas() {
		
		$this->column_fields = getColumnFields('Mall_ShareDatas');
	}

	function save_module($module){}

	function getSortOrder() {
		
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['MALL_SHAREDATAS_SORT_ORDER'] != '')?($_SESSION['MALL_SHAREDATAS_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}
	
	function getOrderBy() {
		
		$use_default_order_by = $this->default_order_by;
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['MALL_SHAREDATAS_ORDER_BY'] != '')?($_SESSION['MALL_SHAREDATAS_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}
}?>
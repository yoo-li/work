<?php
include_once('config.php');
require_once('include/utils/utils.php');

class Mall_SmkConsumeLogs extends CRMEntity {
	
	public $table_name = 'mall_smkconsumeLogs';
	public $table_index= 'id';
	public $tab_name = Array('mall_smkconsumeLogs');
	public $tab_name_index = Array('mall_smkconsumeLogs'=>'id');
	public $customFieldTable = Array('mall_smkconsumeLogs', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('profileid','buyer_email','payment','orderid','subject','trade_no','amount','total_fee','paymentdatetime');
	public $list_link_field= 'mall_smkconsumeLogs_no';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(
	);
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('mall_smkconsumeLogs_no');
    public $special_search_fields = array(
      
    );

    function Mall_SmkConsumeLogs() {
		
		$this->column_fields = getColumnFields('Mall_SmkConsumeLogs');
	}

	function save_module($module){}

	function getSortOrder() {
		
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['MALL_CONSUMELOGS_SORT_ORDER'] != '')?($_SESSION['MALL_CONSUMELOGS_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}
	
	function getOrderBy() {
		
		$use_default_order_by = $this->default_order_by;
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['MALL_CONSUMELOGS_ORDER_BY'] != '')?($_SESSION['MALL_CONSUMELOGS_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}
}?>
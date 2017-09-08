<?php
include_once('config.php');
require_once('include/utils/utils.php');

class Ma_InventoryWarn extends CRMEntity {
	public $table_name = 'ma_inventorywarn';
	public $table_index= 'id';
	public $tab_name = Array('ma_inventorywarn');
	public $tab_name_index = Array('ma_inventorywarn'=>'id');
	public $customFieldTable = Array('ma_inventorywarn', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('supplierid','isenabled','execute','ma_inventorywarnstatus','published');
	public $list_link_field= 'supplierid';

	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(
	);
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('supplierid');
	public $special_search_fields = array(
		'ma_inventorywarnstatus'          => array (
			''    => array ('value' => 'All', 'label' => 'All', 'operator' => '='),
			'Saved'  => array ('value' => "Saved", 'label' => '未提', 'operator' => '='),
			'Agreeing'  => array ('value' => "Agreeing", 'label' => '待审', 'operator' => '='),
			'Agree'  => array ('value' => "Agree", 'label' => '同意', 'operator' => '='),
			'Disagree'  => array ('value' => "Disagree", 'label' => '拒绝', 'operator' => '='),
		)
	);
	
    function Ma_InventoryWarn() {
		$this->column_fields = getColumnFields('Ma_InventoryWarn');
	}

	function save_module($module){}

	function getSortOrder() {
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['MA_INVENTORYWARN_SORT_ORDER'] != '')?($_SESSION['MA_INVENTORYWARN_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}
	
	function getOrderBy() {
		$use_default_order_by = $this->default_order_by;
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['MA_INVENTORYWARN_ORDER_BY'] != '')?($_SESSION['MA_INVENTORYWARN_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}

	public function approval_event($record, $event){
		if ($event == "Agree"){
			$loadcontent = XN_Content::load($record, "ma_inventorywarn");
			$loadcontent->my->status='0';
			$loadcontent->my->approvalstatus = '2';
			$loadcontent->my->ma_inventorywarnstatus = 'Agree';
			$loadcontent->my->finishapprover = XN_Profile::$VIEWER;
			$loadcontent->my->submitapprovalreplydatetime = date("Y-m-d H:i");
			$loadcontent->save("ma_inventorywarn");
		}
	}
}
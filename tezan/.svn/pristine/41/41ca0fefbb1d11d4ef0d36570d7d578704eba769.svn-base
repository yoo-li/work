<?php
include_once('config.php');
require_once('include/utils/utils.php');

class Supplier_TakeCashs extends CRMEntity {
	
	public $table_name = 'supplier_takecashs';
	public $table_index= 'id';
	public $datatype='7';
	public $tab_name = Array('takecashs');
	public $tab_name_index = Array('takecashs'=>'id');
	public $customFieldTable = Array('takecashs', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('profileid','bank','bankname','bankaccount','money','amount','newmoney','takecashsdatetime','takecashsstatus','subscribestatus','frozenstatus','execute','executedatetime');
	public $list_link_field= 'takecashs_no';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(
	);
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('takecashs_no');
	public $special_search_fields = array(
		'supplier_takecashsstatus' => array(
			'' => array('value'=>'全部','label'=>'全部','operator'=>'='),
			'待处理' => array('value'=>'待处理','label'=>'待处理','operator'=>'='),
			'处理中' => array('value'=>'处理中','label'=>'处理中','operator'=>'='),
			'提现完成' => array('value'=>'提现完成','label'=>'提现完成','operator'=>'='),
			'驳回申请' => array('value'=>'驳回申请','label'=>'驳回申请','operator'=>'='), 
			'转账失败' => array('value'=>'转账失败','label'=>'转账失败','operator'=>'='),
		), 
	);

    function Supplier_TakeCashs() {
		
		$this->column_fields = getColumnFields('Supplier_TakeCashs');
	}

	function save_module($module){}

	function getSortOrder() {
		
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['SUPPLIER_TAKECASHS_SORT_ORDER'] != '')?($_SESSION['SUPPLIER_TAKECASHS_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}
	
	function getOrderBy() {
		
		$use_default_order_by = $this->default_order_by;
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['SUPPLIER_TAKECASHS_ORDER_BY'] != '')?($_SESSION['SUPPLIER_TAKECASHS_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}
}?>
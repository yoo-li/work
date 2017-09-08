<?php
include_once('config.php');
require_once('include/utils/utils.php');

class Mall_BillWaters extends CRMEntity {
	
	public $table_name = 'mall_billwaters';
    public $datetype='7';
	public $table_index= 'id';
	public $tab_name = Array('mall_billwaters');
	public $tab_name_index = Array('mall_billwaters'=>'id');
	public $customFieldTable = Array('mall_billwaters', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('profileid','billwatertype','sharedate','amount','money','shareid','takecashid','orderid','productid','royaltyrate','commissiontype','submitdatetime');
	public $list_link_field= 'billwaters_no';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(
	);
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('billwaters_no');
    public $special_search_fields = array( 
        'billwatertype' => array(
            '' => array('value'=>'All','label'=>'All','operator'=>'='),
            'commission' => array('value'=>'commission','label'=>'提成收益','operator'=>'='),
            'consumption' => array('value'=>'consumption','label'=>'消费支出','operator'=>'='),
            'popularize' => array('value'=>'popularize','label'=>'推广收益','operator'=>'='), 
			'reimburse' => array('value'=>'reimburse','label'=>'余额退款','operator'=>'='), 
			'takecash' => array('value'=>'takecash','label'=>'提现','operator'=>'='), 
			'rejecttakecash' => array('value'=>'rejecttakecash','label'=>'驳回提现','operator'=>'='), 
        ),
    );  
	var $sortby_number_fields = Array('amount','money');
	
    function Mall_BillWaters() {
		
		$this->column_fields = getColumnFields('Mall_BillWaters');
	}

	function save_module($module){}

	function getSortOrder() {
		
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['Mall_BILLWATERS_SORT_ORDER'] != '')?($_SESSION['Mall_BILLWATERS_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}
	
	function getOrderBy() {
		
		$use_default_order_by = $this->default_order_by;
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['Mall_BILLWATERS_ORDER_BY'] != '')?($_SESSION['Mall_BILLWATERS_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}
}?>
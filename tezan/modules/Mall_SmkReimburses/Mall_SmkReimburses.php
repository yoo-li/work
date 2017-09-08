<?php
include_once('config.php');
require_once('include/utils/utils.php');

class Mall_SmkReimburses extends CRMEntity {

	public $table_name = 'mall_smkreimburses';
	public $datatype = '7';
	public $table_index= 'id';
	public $tab_name = Array('mall_smkreimburses');
	public $tab_name_index = Array('mall_smkreimburses'=>'id');
	public $customFieldTable = Array('mall_smkreimburses', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('businesseid','orderid','returnedgoodsapplyid','profileid','returngoodsdate','payment','paymentaccount','actuallypaid','amountpayable','mall_smkreimbursestatus');
	public $list_link_field= 'commissions_no';
	public $default_order_by = 'published';//returngoodsdate published
	public $default_sort_order = 'DESC';
	public $search_fields = Array(
	);
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('commissions_no');
    public $special_search_fields = array(
        'payment' => array(
            '' => array('value'=>'全部','label'=>'全部','operator'=>'='),
            '支付宝' => array('value'=>'支付宝','label'=>'支付宝','operator'=>'='),
			'微信支付' => array('value'=>'微信支付','label'=>'微信支付','operator'=>'='),
			'银联支付' => array('value'=>'银联支付','label'=>'银联支付','operator'=>'='),
			'市民卡' => array('value'=>'市民卡','label'=>'市民卡','operator'=>'='),
            '余额' => array('value'=>'余额','label'=>'余额支付','operator'=>'='),
        ),
        'mall_smkreimbursestatus' => array(
            '' => array('value'=>'全部','label'=>'全部','operator'=>'='),
            '退余额' => array('value'=>'退余额','label'=>'退余额','operator'=>'='),
            '待退款' => array('value'=>'待退款','label'=>'待退款','operator'=>'='),
            '已退款' => array('value'=>'已退款','label'=>'已退款','operator'=>'='),
        ),
    );
	var $sortby_number_fields = Array('amount','money','royaltyrate');

    function Mall_SmkReimburses() {

		$this->column_fields = getColumnFields('Mall_SmkReimburses');
	}

	function save_module($module){}

	function getSortOrder() {

		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['mall_REIMBURSES_SORT_ORDER'] != '')?($_SESSION['mall_REIMBURSES_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}

	function getOrderBy() {

		$use_default_order_by = $this->default_order_by;
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['mall_REIMBURSES_ORDER_BY'] != '')?($_SESSION['mall_REIMBURSES_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}
}?>
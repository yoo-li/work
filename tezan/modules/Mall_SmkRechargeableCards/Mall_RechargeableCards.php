<?php
include_once('config.php');
require_once('include/utils/utils.php');

class Mall_SmkRechargeableCards extends CRMEntity {
	
	public $table_name = 'mall_smkrechargeablecards';
	public $datatype='7';
	public $table_index= 'id';
	public $tab_name = Array('mall_smkrechargeablecards');
	public $tab_name_index = Array('mall_smkrechargeablecards'=>'id');
	public $customFieldTable = Array('mall_smkrechargeablecards', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('supplierid','username','password','productid','facevalue','orderid','deliverdatetime','mall_rechargeablecardsstatus');
	public $list_link_field= 'username';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(
	); 
	
	var $popup_fields = Array('supplierid','username','password','productid','facevalue','orderid','deliverdatetime','mall_rechargeablecardsstatus');
	var $filter_fields = Array('username');
	
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('activityname');
    public $special_search_fields = array(
        'mall_rechargeablecardsstatus' => array(
            '' => array('value'=>'All','label'=>'All','operator'=>'='),
            'JustCreated' => array('value'=>'JustCreated','label'=>'JustCreated','operator'=>'='),
            'OnShelf' => array('value'=>'OnShelf','label'=>'OnShelf','operator'=>'='),
			'OffShelf' => array('value'=>'OffShelf','label'=>'OffShelf','operator'=>'='),
            'Used' => array('value'=>'Used','label'=>'Used','operator'=>'='),
        ), 
    );
	var $sortby_number_fields = Array('submitdatetime','mall_rechargeablecardsstatus','published');
	
    function Mall_SmkRechargeableCards() {
		
		$this->column_fields = getColumnFields('Mall_SmkRechargeableCards');
	}

	function save_module($module){} 

	function getSortOrder() {
		
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['MALL_RECHARGEABLECARDS_SORT_ORDER'] != '')?($_SESSION['MALL_RECHARGEABLECARDS_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}
	
	function getOrderBy() {
		
		$use_default_order_by = $this->default_order_by;
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['MALL_RECHARGEABLECARDS_ORDER_BY'] != '')?($_SESSION['MALL_RECHARGEABLECARDS_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}
}?>
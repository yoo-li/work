<?php
include_once('config.php');
require_once('include/utils/utils.php');

class Mall_Appraises extends CRMEntity {
	
	public $table_name = 'mall_appraises';
	public $datatype = '7';
	public $table_index= 'id';
	public $tab_name = Array('mall_appraises');
	public $tab_name_index = Array('mall_appraises'=>'id');
	public $customFieldTable = Array('mall_appraises', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('profileid','subordinate','commissionsource','amount','money','orderid','productid','royaltyrate','commissiontype');
	public $list_link_field= 'commissions_no';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(
	);
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('commissions_no');
    public $special_search_fields = array(
        
        'praise' => array(
            '' => array('value'=>'All','label'=>'All','operator'=>'='),
            '1' => array('value'=>'1','label'=>'好评','operator'=>'='),
            '2' => array('value'=>'2','label'=>'中评','operator'=>'='),
            '3' => array('value'=>'3','label'=>'差评','operator'=>'='), 
        ),
    ); 
	var $sortby_number_fields = Array('amount','money','royaltyrate');
	
    function Mall_Appraises() {
		
		$this->column_fields = getColumnFields('Mall_Appraises');
	}

	function save_module($module){}

	function getSortOrder() {
		
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['MALL_APPRAISES_SORT_ORDER'] != '')?($_SESSION['MALL_APPRAISES_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}
	
	function getOrderBy() {
		
		$use_default_order_by = $this->default_order_by;
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['MALL_APPRAISES_ORDER_BY'] != '')?($_SESSION['MALL_APPRAISES_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}
}?>
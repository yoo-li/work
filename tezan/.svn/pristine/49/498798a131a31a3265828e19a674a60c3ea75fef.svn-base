<?php
include_once('config.php');
require_once('include/utils/utils.php');

class Mall_HitshelfLog extends CRMEntity {
	
	public $table_name = 'mall_hitshelflog';
	public $table_index= 'id';
    public $datatype='7';
	public $tab_name = Array('mall_hitshelflog');
	public $tab_name_index = Array('mall_hitshelflog'=>'id');
	public $customFieldTable = Array('mall_hitshelflog', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('hitshelflog_no','profileid','published');
	public $list_link_field= 'hitshelflog_no';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(
	);
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('hitshelflog_no');
    public $special_search_fields = array(
        'handle_type'=>array(
            '' => array('value'=>'All','label'=>'All','operator'=>'='),
            'on'=>array('value'=>"on",'label'=>'上架','operator'=>'='),
            'off'=>array('value'=>"off",'label'=>'下架','operator'=>'='),
        ),

    );
	var $sortby_number_fields = Array('hitshelflog_no');
	
    function Mall_HitshelfLog() {
		
		$this->column_fields = getColumnFields('Mall_HitshelfLog');
	}

	function save_module($module){}

	function getSortOrder() {
		
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['MALL_HITSHELFLOG_SORT_ORDER'] != '')?($_SESSION['MALL_HITSHELFLOG_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}
	
	function getOrderBy() {
		
		$use_default_order_by = $this->default_order_by;
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['MALL_HITSHELFLOG_ORDER_BY'] != '')?($_SESSION['MALL_HITSHELFLOG_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}
}?>
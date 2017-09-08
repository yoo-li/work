<?php
include_once('config.php');
require_once('include/utils/utils.php');

class Mall_RobSingles extends CRMEntity {
	
	public $table_name = 'mall_robsingles';
	public $table_index= 'id';
	public $tab_name = Array('mall_robsingles');
	public $tab_name_index = Array('mall_robsingles'=>'id');
	public $customFieldTable = Array('mall_robsingles', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('activityname','display_type','begindate','enddate','status','sequence','mall_robsinglesstatus');
	public $list_link_field= 'activityname';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(
	); 
	
	var $popup_fields = Array('activityname','display_type','begindate','enddate','status','sequence','mall_robsinglesstatus');
	var $filter_fields = Array('activityname');
	
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('activityname');
    public $special_search_fields = array(
        'status' => array(
			'' => array('value'=>'','label'=>'全部','operator'=>'='),
            '0' => array('value'=>'0','label'=>'启用','operator'=>'='),
            '1' => array('value'=>'1','label'=>'停用','operator'=>'='),
        ),
    );
	var $sortby_number_fields = Array('submitdatetime','mall_robsinglesstatus','published');
	
    function Mall_RobSingles() {
		
		$this->column_fields = getColumnFields('Mall_RobSingles');
	}

	function save_module($module){}

    public function approval_event($record,$event) {
        
    }

	function getSortOrder() {
		
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['MALL_ROBSINGLES_SORT_ORDER'] != '')?($_SESSION['MALL_ROBSINGLES_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}
	
	function getOrderBy() {
		
		$use_default_order_by = $this->default_order_by;
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['MALL_ROBSINGLES_ORDER_BY'] != '')?($_SESSION['MALL_ROBSINGLES_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}
}?>
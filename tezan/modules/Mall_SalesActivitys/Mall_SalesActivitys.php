<?php
include_once('config.php');
require_once('include/utils/utils.php');

class Mall_SalesActivitys extends CRMEntity {
	
	public $table_name = 'mall_salesactivitys';
	public $table_index= 'id';
	public $tab_name = Array('mall_salesactivitys');
	public $tab_name_index = Array('mall_salesactivitys'=>'id');
	public $customFieldTable = Array('mall_salesactivitys', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('activityname','display_type','begindate','enddate','status','sequence','mall_salesactivitysstatus');
	public $list_link_field= 'activityname';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(
	); 
	
	var $popup_fields = Array('activityname','display_type','begindate','enddate','status','sequence','mall_salesactivitysstatus');
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
	var $sortby_number_fields = Array('submitdatetime','mall_salesactivitysstatus','published');
	
    function Mall_SalesActivitys() {
		
		$this->column_fields = getColumnFields('Mall_SalesActivitys');
	}

	function save_module($module){}

    public function approval_event($record,$event) {
        if($event=="Agree"){
            $activityproducts=XN_Query::create("Content")
                ->tag("activity_product")
                ->filter("type","eic","activity_product")
                ->filter("my.activityid","=",$record)
                ->end(-1)
                 ->execute();
            foreach($activityproducts as $info){
                $info->my->approvalstatus='Agree';
                $info->save("activity_product");
            }
        }
        else
        {
            $activityproducts=XN_Query::create("Content")
                ->tag("activity_product")
                ->filter("type","eic","activity_product")
                ->filter("my.activityid","=",$record)
                ->end(-1)
                ->execute();
            foreach($activityproducts as $info){
                $info->my->approvalstatus='Disagree';
                $info->save("activity_product");
            }
        }
    }

	function getSortOrder() {
		
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['MALL_SALESACTIVITYS_SORT_ORDER'] != '')?($_SESSION['MALL_SALESACTIVITYS_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}
	
	function getOrderBy() {
		
		$use_default_order_by = $this->default_order_by;
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['MALL_SALESACTIVITYS_ORDER_BY'] != '')?($_SESSION['MALL_SALESACTIVITYS_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}
}?>
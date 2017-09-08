<?php
include_once('config.php');
require_once('include/utils/utils.php');

class WxServices extends CRMEntity {
	
	public $table_name = 'wxservices';
	public $table_index= 'id';
	public $tab_name = Array('wxservices');
	public $tab_name_index = Array('wxservices'=>'id');
	public $customFieldTable = Array('wxservices', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('wxid','fromprofileid','wxmsgtype','msgcontent','replycount','customservice','lastreplytime','updated','published');
	public $list_link_field= 'wxservices_no';
	public $default_order_by = 'updated';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(
	);
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('wxservices_no');
    public $special_search_fields = array(
      
    );

    function WxServices() {
		
		$this->column_fields = getColumnFields('WxServices');
	}

	function save_module($module){}

	function getSortOrder() {
		
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['WXSERVICES_SORT_ORDER'] != '')?($_SESSION['WXSERVICES_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}
	
	function getOrderBy() {
		
		$use_default_order_by = $this->default_order_by;
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['WXSERVICES_ORDER_BY'] != '')?($_SESSION['WXSERVICES_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}
}?>
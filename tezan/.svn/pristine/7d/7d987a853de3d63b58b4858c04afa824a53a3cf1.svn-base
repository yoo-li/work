<?php
include_once('config.php');
require_once('include/utils/utils.php');

class WxSettings extends CRMEntity {
	
	public $table_name = 'wxsettings';
	public $table_index= 'id';
	public $tab_name = Array('wxsettings');
	public $tab_name_index = Array('wxsettings'=>'id');
	public $customFieldTable = Array('wxsettings', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('wxname','appid','secret','published');

	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(
	);
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('wxsettings_no');
    public $special_search_fields = array(  );
      
	  
    var $popup_fields = Array('wxname','author','published');

    var $list_link_field= 'wxname';

    var $filter_fields = Array('wxname',);
	


   var $select_fields = array(
		'WxChannels' => array('wxname'),
	);
  

    function WxSettings() {
		
		$this->column_fields = getColumnFields('WxSettings');
	}

	function save_module($module){}

	function getSortOrder() {
		
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['WXSETTINGS_SORT_ORDER'] != '')?($_SESSION['WXSETTINGS_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}
	
	function getOrderBy() {
		
		$use_default_order_by = $this->default_order_by;
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['WXSETTINGS_ORDER_BY'] != '')?($_SESSION['WXSETTINGS_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}
}?>
<?php
include_once('config.php');
require_once('include/utils/utils.php');

class Mall_OfficialAuthorizeRelationships extends CRMEntity {
	
	public $table_name = 'mall_officialauthorizerelationships';
	public $table_index= 'id';
	public $tab_name = Array('mall_officialauthorizerelationships');
	public $tab_name_index = Array('Mall_OfficialAuthorizeRelationships'=>'id');
	public $customFieldTable = Array('Mall_OfficialAuthorizeRelationships', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('mall_officialauthorizerelationshipsstatus');
	public $list_link_field= 'mall_officialauthorizerelationships_no';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(); 
	
    var $popup_fields = Array('mall_officialauthorizerelationships_no','authorizedperson','authorizer','status','mall_officialauthorizerelationshipsstatus','published');
    var $filter_fields = Array('mall_officialauthorizerelationships_no'); 
	
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('mall_officialauthorizerelationships_no');
	public $special_search_fields = array(
		'status' => array(
			'' => array('value'=>'全部','label'=>'全部','operator'=>'='),
			'Active' => array('value'=>'0','label'=>'启用','operator'=>'='),
			'Inactive' => array('value'=>'1','label'=>'停用','operator'=>'='), 
		), 
	);
	var $sortby_number_fields = Array('mall_officialauthorizerelationshipsstatus','published');
	
    function Mall_OfficialAuthorizeRelationships() {
		
		$this->column_fields = getColumnFields('Mall_OfficialAuthorizeRelationships');
	}

	function save_module($module){} 

	function getSortOrder() {
		
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION[strtoupper($this->table_name).'_SORT_ORDER'] != '')?($_SESSION[strtoupper($this->table_name).'_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}
	
	function getOrderBy() {
		
		$use_default_order_by = $this->default_order_by;
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION[strtoupper($this->table_name).'_ORDER_BY'] != '')?($_SESSION[strtoupper($this->table_name).'_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}
}?>
<?php
include_once('config.php');
require_once('include/utils/utils.php');

class Dc_ExperiencedCraftsmans extends CRMEntity {
	
	public $table_name = 'dc_experiencedcraftsmans';
	public $table_index= 'id';
	public $tab_name = Array('dc_experiencedcraftsmans');
	public $tab_name_index = Array('Dc_ExperiencedCraftsmans'=>'id');
	public $customFieldTable = Array('Dc_ExperiencedCraftsmans', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('dc_experiencedcraftsmansstatus');
	public $list_link_field= 'id';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(); 
	
	var $popup_fields = Array('dc_experiencedcraftsmansstatus');
	var $filter_fields = Array('dc_experiencedcraftsmansstatus');
	
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('published');
    public $special_search_fields = array();
	var $sortby_number_fields = Array('dc_experiencedcraftsmansstatus','published');
	
    function Dc_ExperiencedCraftsmans() {
		
		$this->column_fields = getColumnFields('Dc_ExperiencedCraftsmans');
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
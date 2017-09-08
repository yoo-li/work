<?php
include_once('config.php');
require_once('include/utils/utils.php');

class Mall_ProductLibs extends CRMEntity {
	
	public $table_name = 'mall_productlibs';
	public $default_published_section = 'year';//month day year
	public $table_index= 'id';
	public $tab_name = Array('mall_productlibs');
	public $tab_name_index = Array('mall_productlibs'=>'id');
	public $customFieldTable = Array('mall_productlibs', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array("sequence","updated",'productname','categorys','suppliers','brand','shop_price','market_price','mall_productlibsstatus','salevolume','submitapprovalreplydatetime');
	public $list_link_field= 'productname';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(
	);
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('mall_productlibs_no');
	
	
	var $popup_fields = Array('productname','internalno','categorys','brand','supplierid','shop_price');
	var $filter_fields = Array('productname','keywords');
	var $sortby_number_fields = Array('sequence','shop_price','internalno','market_price','inventory','member_price','promote_price','salevolume');
	
	
	var $select_fields = array(
	    'Recommends' => array('shop_price','mall_productlibs_no'),
	    'StockinStorages' => array('mall_productlibs_no','suppliers'),
	);
	
	public $special_search_fields = array(
		'mall_productlibsstatus' => array(
			'' => array('value'=>'All','label'=>'All','operator'=>'='),
			'Saved' => array('value'=>'Saved','label'=>'Saved','operator'=>'='),
			'Approvaling' => array('value'=>'Approvaling','label'=>'Approvaling','operator'=>'='),
			'Agree' => array('value'=>'Agree','label'=>'Agree','operator'=>'='),
			'Disagree' => array('value'=>'Disagree','label'=>'Disagree','operator'=>'='),
		),
        'hitshelf'=>array(
            '' => array('value'=>'All','label'=>'All','operator'=>'='),
            'on'=>array('value'=>"on",'label'=>'上架','operator'=>'='),
            'off'=>array('value'=>"off",'label'=>'下架','operator'=>'='),
        )
	);
	
	function Mall_ProductLibs() {
		
		$this->column_fields = getColumnFields('Mall_ProductLibs');
	}

	function save_module($module){}

	function getSortOrder() {
		
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['MALL_PRODUCTS_SORT_ORDER'] != '')?($_SESSION['MALL_PRODUCTS_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}
	
	function getOrderBy() {
		
		$use_default_order_by = $this->default_order_by;
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['MALL_PRODUCTS_ORDER_BY'] != '')?($_SESSION['MALL_PRODUCTS_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}
	
	
	 
}?>
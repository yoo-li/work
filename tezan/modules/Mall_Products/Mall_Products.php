<?php
include_once('config.php');
require_once('include/utils/utils.php');

class Mall_Products extends CRMEntity {
	
	public $table_name = 'mall_products'; 
	public $table_index= 'id';
	public $tab_name = Array('mall_products');
	public $tab_name_index = Array('mall_products'=>'id');
	public $customFieldTable = Array('mall_products', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array("sequence","updated",'productname','categorys','suppliers','brand','shop_price','market_price','profitrate','mall_productsstatus','salevolume','submitapprovalreplydatetime');
	public $list_link_field= 'productname';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(
	);
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('mall_products_no');
	
	
	var $popup_fields = Array('mall_products_no','productname','categorys','shop_price','profitrate');
	var $filter_fields = Array('productname','mall_products_no','profitrate');
	var $sortby_number_fields = Array('sequence','shop_price','internalno','market_price','inventory','member_price','profitrate','promote_price','salevolume');
	
	
	var $select_fields = array(
	    'Recommends' => array('shop_price','mall_products_no'),
	    'StockinStorages' => array('mall_products_no','suppliers'),
	);
	
	public $special_search_fields = array(
		'mall_productsstatus' => array(
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
	
	function Mall_Products() {
		
		$this->column_fields = getColumnFields('Mall_Products');
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
	
	
	public function approval_event($id,$event) {
		if ($id > 0 && $event == 'Agree') {
			$details = XN_Query::create('Content')->tag('mall_inventorys')
				->filter('type','eic','mall_inventorys')
				->filter('my.productid','=',$id)
				->execute();
			foreach ( array_chunk($details,50,true) as $chunk_query){
				XN_Content::delete($chunk_query,'mall_inventorys');
			}
			 
			try{
				XN_Content::create('mall_products_keywords', '',false,2)	 
					  ->my->add('productid',$id) 
					  ->my->add('profileid',XN_Profile::$VIEWER)
					  ->my->add('module','mall_products')
					  ->my->add('action','productkeywords')
					  ->my->add('record',$id)
					  ->save("mall_products_keywords");
			}
			catch(XN_Exception $e){}
			
			
			$loadcontent = XN_Content::load($id,"mall_products");
            $loadcontent->my->hitshelf="on";
            $loadcontent->save($this->table_name);
			$vendorid = $loadcontent->my->vendorid;
			$details = XN_Query::create('Content')->tag('mall_product_property')
				->filter('type','eic','mall_product_property')
                ->filter('my.deleted','=','0')
				->filter('my.productid','=',$id)
				->execute(); 
            
			if(count($details)>0){
				foreach($details as $info){ 
					$brand = XN_Content::create('mall_inventorys',"",false);
					$brand->my->createnew = '0';
					$brand->my->deleted = '0'; 
					$brand->my->productid = $loadcontent->id;
					$brand->my->vendorid = $vendorid;
					$brand->my->productname = $loadcontent->my->productname;
					$brand->my->supplierid = $loadcontent->my->supplierid;
					$brand->my->inventory = $info->my->inventorys;
					$brand->my->categorys = $loadcontent->my->categorys;
					$brand->my->propertytypeid = $info->id;
					$brand->my->propertytype = $info->my->propertydesc;
                    $brand->my->warnline = 50;
					$brand->my->price = $info->my->shop;
					$brand->save('mall_inventorys,mall_inventorys_'.$loadcontent->my->supplierid);
					
					$brand = XN_Content::create('mall_turnovers',"",false,7);  
					$brand->my->supplierid = $loadcontent->my->supplierid;
					$brand->my->deleted = '0'; 
				    $brand->my->productid = $loadcontent->id;
				    $brand->my->productname = $loadcontent->my->productname;
				    $brand->my->propertyid = $info->id;
					$brand->my->propertydesc = $info->my->propertydesc;
				    $brand->my->mall_turnoversstatus = '新建商品入库';
				    $brand->my->oldinventory = '0';
					$brand->my->amount = '+'.$info->my->inventorys;
				    $brand->my->newinventory = $info->my->inventorys;
				    $brand->save('mall_turnovers,mall_turnovers_'.$loadcontent->my->supplierid);
				}
			}else{
				 
				$brand = XN_Content::create('mall_inventorys',"",false);
				$brand->my->createnew = '0';
				$brand->my->deleted = '0'; 
				$brand->my->productid = $loadcontent->id;
				$brand->my->vendorid = $vendorid;
				$brand->my->productname = $loadcontent->my->productname;
				$brand->my->supplierid = $loadcontent->my->supplierid;
				$brand->my->inventory = $loadcontent->my->inventory;
				$brand->my->categorys = $loadcontent->my->categorys;
				$brand->my->propertytype = "";
				$brand->my->propertytypeid = "";
                $brand->my->warnline = 50;
				$brand->my->price = $loadcontent->my->shop_price;
				$brand->save('mall_inventorys,mall_inventorys_'.$loadcontent->my->supplierid);
				
				$brand = XN_Content::create('mall_turnovers',"",false,7);  
				$brand->my->supplierid = $loadcontent->my->supplierid;
				$brand->my->deleted = '0'; 
			    $brand->my->productid = $loadcontent->id;
			    $brand->my->productname = $loadcontent->my->productname;
			    $brand->my->propertyid = "";
				$brand->my->propertydesc = "";
			    $brand->my->mall_turnoversstatus = '新建商品入库';
			    $brand->my->oldinventory = '0';
				$brand->my->amount = '+'.$loadcontent->my->inventory;
			    $brand->my->newinventory = $loadcontent->my->inventory;
			    $brand->save('mall_turnovers,mall_turnovers_'.$loadcontent->my->supplierid);
			}
			 
		}
	}
}?>
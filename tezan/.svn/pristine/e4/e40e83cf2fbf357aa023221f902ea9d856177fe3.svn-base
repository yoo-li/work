<?php
include_once('config.php');
require_once('include/utils/utils.php');

if (!function_exists('raw_json_encode')) {
	function raw_json_encode($input) {
		return preg_replace_callback(
		    '/\\\\u([0-9a-zA-Z]{4})/',
		 	create_function('$matches', 'return mb_convert_encoding(pack("H*",$matches[1]),"UTF-8","UTF-16");'),
		    /**
		    function ($matches) {
		    	return mb_convert_encoding(pack('H*',$matches[1]),'UTF-8','UTF-16');
		    },
		    **/
		    json_encode($input)
		);
	}
}

class Mall_PropertyCorrect extends CRMEntity {
	
	public $table_name = 'mall_propertycorrect';
	public $table_index= 'id';
	public $tab_name = Array('mall_propertycorrect');
	public $tab_name_index = Array('mall_propertycorrect'=>'id');
	public $customFieldTable = Array('propertycorrect', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('mall_propertycorrect_no','property_name');
	public $list_link_field= 'property_name';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(
	);
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('mall_propertycorrect_no');
    public $special_search_fields = array(
        'mall_propertycorrectstatus' => array(
            '' => array('value'=>'All','label'=>'All','operator'=>'='),
            'Saved' => array('value'=>'Saved','label'=>'Saved','operator'=>'='),
            'Approvaling' => array('value'=>'Approvaling','label'=>'Approvaling','operator'=>'='),
            'Agree' => array('value'=>'Agree','label'=>'Agree','operator'=>'='),
            'Disagree' => array('value'=>'Disagree','label'=>'Disagree','operator'=>'='),
        ),
    );
	var $filter_fields = Array('property_name');
	var $sortby_number_fields = Array('mall_propertycorrect_no');

    function Mall_PropertyCorrect() {
		
		$this->column_fields = getColumnFields('Mall_PropertyCorrect');
	}

	function save_module($module){}
		
	
		
	public function approval_event($record,$event){
	        $correct_fields=array("correctmarket_price","correctshop_price","correctproductname","correctcategorys","correctroyaltyrate","correctbarcode","correctinternalno","correctproduct_weight","correctkeywords","correctproduct_guige","correctsimple_desc","correctdescription","correctproductlogo","correctproductthumbnail","correctqualitycertificate");
	        $lowermodule="mall_propertycorrect";
	        if($event=="Agree")
			{
	            $correctContent=XN_Content::load($record,$lowermodule);
	            $productid=$correctContent->my->product_id;
	            $product_info=XN_Content::load($productid,"mall_products");
	            foreach($correct_fields as $fieldname){
	                if($correctContent->my->$fieldname!=""){
	                    $product_fieldname=substr($fieldname,7);
	                    $product_info->my->$product_fieldname=$correctContent->my->$fieldname;
	                }
	            } 
				
				try{
					XN_Content::create('mall_products_keywords', '',false,2)	 
						  ->my->add('productid',$productid) 
						  ->my->add('profileid',XN_Profile::$VIEWER)
						  ->my->add('module','mall_products')
						  ->my->add('action','productkeywords')
						  ->my->add('record',$productid)
						  ->save("mall_products_keywords");
				}
				catch(XN_Exception $e){}
					
				
				 $supplierid = $product_info->my->supplierid; 
				 
	 		     $propertys = XN_Query::create ( 'Content' )->tag('mall_propertys')
	 		        ->filter ( 'type', 'eic', 'mall_propertys' ) 
	 		        ->filter ( 'my.productid', '=', $productid )
	 		        ->end(-1)
	 		        ->execute ();
				 XN_Content::delete($propertys,'mall_propertys,mall_propertys_'.$supplierid);
				 
			     $product_propertys = XN_Query::create ( 'Content' )->tag('mall_product_property')
			        ->filter ( 'type', 'eic', 'mall_product_property' ) 
			        ->filter ( 'my.productid', '=', $productid )
			        ->end(-1)
			        ->execute ();
				 foreach($product_propertys as $product_property_info)
				 {
				 	$product_property_info->my->deleted = "1";
					$product_property_info->save('mall_product_property,mall_product_property_'.$supplierid);
				 }
				 // XN_Content::delete($product_propertys,'mall_product_property,mall_product_property_'.$supplierid);
				  
	  			  $property_inventorys = XN_Query::create('Content')->tag('mall_inventorys_'.$supplierid)
		  				->filter('type','eic','mall_inventorys')
		  				->filter ('my.productid','=',$productid)
		  				->end(-1)
		  				->execute();
	  			  XN_Content::delete($property_inventorys,'mall_inventorys,mall_inventorys_'.$supplierid);
			  	
				
				 $product_propertys=XN_Query::create ( 'Content' )
			  	    ->tag("mall_product_property")
			  	    ->filter ( 'type', 'eic', 'mall_product_property' )
			  	    ->filter ( 'my.productid', '=', $record)
			  		->filter ( 'my.deleted', '=', '0')
			  		->filter ( 'my.status', '=', '0')
			  	    ->begin(0)->end(-1)
			  	    ->execute (); 
				
				 if (count($product_propertys) > 0)
				 {
					// $property_type =  $correctContent->my->property_type;
					// $product_info->my->property_type = $property_type;
					// $product_info->save("mall_products,mall_products_".$supplierid); 
				  
				  
				  	$propertys=XN_Query::create ( 'Content' ) 
				  	    ->filter ( 'type', 'eic', 'mall_propertys' )
				  	    ->filter ( 'my.productid', '=', $record)
				  	     ->filter ( 'my.deleted', '=','0')
				  	    ->begin(0)->end(-1)
				  	    ->execute ();
				  	$keys = array();
				  	foreach($propertys as $property_info)
				  	{
				          $property=XN_Content::create("mall_propertys","",false);
				          $property->my->productid = $productid;
				          $property->my->property_type = $property_info->my->property_type;
				          $property->my->property_value = $property_info->my->property_value;
				          $property->my->deleted='0';
				          $property->my->status='0';
				          $property->my->sequence = $property_info->my->sequence;
				          $property->save("mall_propertys,mall_propertys_".$supplierid);
				  		  $keys[$property_info->id] = $property->id;
				  	}
				  
	
				  	foreach($product_propertys as $product_property_info)
				  	{
				  		 $propertyids = $product_property_info->my->propertyids;
				  		 $newpropertyids = array();
				  		 foreach((array)$propertyids as $propertyid)
				  		 {
				  			if (isset($keys[$propertyid]) && $keys[$propertyid] != "")
				  			{
				  				$newpropertyids[] = $keys[$propertyid];
				  			}
				  		 }
				          $newcontent = XN_Content::create('mall_product_property',"",false);
				          $newcontent->my->status = "0";
				          $newcontent->my->productid = $productid; 
				          $newcontent->my->barcode = $product_property_info->my->barcode;
				          $newcontent->my->propertyids = $newpropertyids;
				          $newcontent->my->propertydesc = $product_property_info->my->propertydesc;
				          $newcontent->my->market = $product_property_info->my->market;
				          $newcontent->my->imgurl = $product_property_info->my->imgurl; 
				          $newcontent->my->shop = $product_property_info->my->shop;
				          $newcontent->my->inventorys = $product_property_info->my->inventorys;
				          $newcontent->my->deleted='0';
			  			  $vendorid = $product_info->my->vendorid;
			  			  if (isset($vendorid) && $vendorid != "")
						  {
						        $vendorid = $_SESSION['vendorid'];
	  				  			$vendor_price = $product_property_info->my->shop; 
	  				  			$newcontent->my->vendor_price = $vendor_price;
						  }
				  		 
				  		  $newcontent->save("mall_product_property,mall_product_property_".$supplierid);
						  
	  					$brand = XN_Content::create('mall_inventorys',"",false);
	  					$brand->my->createnew = '0';
	  					$brand->my->deleted = '0'; 
						$brand->my->supplierid = $supplierid;
	  					$brand->my->productid = $product_info->id;
	  					$brand->my->vendorid = $vendorid;
	  					$brand->my->productname = $product_info->my->productname; 
	  					$brand->my->inventory = $product_property_info->my->inventorys;
	  					$brand->my->categorys = $product_info->my->categorys;
	  					$brand->my->propertytypeid = $newcontent->id;
	  					$brand->my->propertytype = $product_property_info->my->propertydesc;
	                    $brand->my->warnline = 50;
	  					$brand->my->price = $product_property_info->my->shop;
	  					$brand->save('mall_inventorys,mall_inventorys_'.$supplierid);
					
	  					$brand = XN_Content::create('mall_turnovers',"",false,7);  
	  					$brand->my->supplierid = $supplierid;
	  					$brand->my->deleted = '0'; 
	  				    $brand->my->productid = $product_info->id;
	  				    $brand->my->productname = $product_info->my->productname;
	  				    $brand->my->propertyid = $product_property_info->id;
	  					$brand->my->propertydesc = $product_property_info->my->propertydesc;
	  				    $brand->my->mall_turnoversstatus = '调整商品入库';
	  				    $brand->my->oldinventory = '0';
	  					$brand->my->amount = '+'.$product_property_info->my->inventorys;
	  				    $brand->my->newinventory = $product_property_info->my->inventorys;
	  				    $brand->save('mall_turnovers,mall_turnovers_'.$supplierid);
				  	}
	 	            $new_propertys=XN_Query::create ( 'Content' )
	 		                ->tag('mall_propertys')
	 		                ->filter( 'type', 'eic', 'mall_propertys')
	 		                ->filter('my.productid', '=', $productid)
							->filter('my.status','=','0')
	 		                ->filter('my.deleted','=','0')
	 		                ->begin(0)
	 		                ->end(-1)
	 		                ->execute(); 
					 $propArray = array();
	 				 foreach($new_propertys as $new_property_info)
	 				 {
						 $property_value = $new_property_info->my->property_value;
						 $property_type  = $new_property_info->my->property_type;
						 $propertyid = $new_property_info->id;
						 $propArray[$property_type][$propertyid] = $property_value;
					 } 
					 
		             $product_info->my->property_type = raw_json_encode($propArray);
					 
	   				 $shop_price = $product_info->my->shop_price;
	   				 $mall_productpropertys=XN_Query::create ( 'Content' )
	   				 	    ->tag('mall_product_property')
	   				 	    ->filter( 'type', 'eic', 'mall_product_property')
	   				 	    ->filter('my.productid', '=', $productid)
	   				 	    ->filter('my.deleted','=','0')
							->filter('my.status','=','0')
	   				 		->order('my.shop',XN_Order::ASC_NUMBER)
	   				 	    ->begin(0)
	   				 	    ->end(1)
	   				 	    ->execute();
	
	   				 	if (count($mall_productpropertys) > 0)
	   				 	{
	   				 		$mall_productproperty_info = $mall_productpropertys[0];
	   				 		$shop = $mall_productproperty_info->my->shop;
	   				 		if ($shop_price != $shop)
	   				 		{
	   							$product_info->my->shop_price = $shop;
	   				 			
	   				 		}
	   				 	}
					$product_info->save("mall_products,mall_products_".$supplierid);
				 }
				 else
				 {
					 $product_info->my->property_type = "";
					 $product_info->save("mall_products,mall_products_".$supplierid); 
					 $vendorid = $product_info->my->vendorid;
					  
  					$brand = XN_Content::create('mall_inventorys',"",false);
  					$brand->my->createnew = '0';
  					$brand->my->deleted = '0'; 
					$brand->my->supplierid = $supplierid;
  					$brand->my->productid = $product_info->id;
  					$brand->my->vendorid = $vendorid;
  					$brand->my->productname = $product_info->my->productname; 
  					$brand->my->inventory = $product_info->my->inventory;
  					$brand->my->categorys = $product_info->my->categorys;
  					$brand->my->propertytypeid = '';
  					$brand->my->propertytype = '';
                    $brand->my->warnline = 50;
  					$brand->my->price = $product_info->my->shop_price;
  					$brand->save('mall_inventorys,mall_inventorys_'.$supplierid);
				
  					$brand = XN_Content::create('mall_turnovers',"",false,7);  
  					$brand->my->supplierid = $supplierid;
  					$brand->my->deleted = '0'; 
  				    $brand->my->productid = $product_info->id;
  				    $brand->my->productname = $product_info->my->productname;
  				    $brand->my->propertyid = '';
  					$brand->my->propertydesc = '';
  				    $brand->my->mall_turnoversstatus = '调整商品入库';
  				    $brand->my->oldinventory = '0';
  					$brand->my->amount = '+'.$product_info->my->inventory;
  				    $brand->my->newinventory = $product_info->my->inventory;
  				    $brand->save('mall_turnovers,mall_turnovers_'.$supplierid);
				 } 
		    } 
	}
 
	function getSortOrder() {
		
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['MALL_PROPERTYCORRECT_SORT_ORDER'] != '')?($_SESSION['MALL_PROPERTYCORRECT_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}
	
	function getOrderBy() {
		
		$use_default_order_by = $this->default_order_by;
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['MALL_PROPERTYCORRECT_ORDER_BY'] != '')?($_SESSION['MALL_PROPERTYCORRECT_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}
}?>
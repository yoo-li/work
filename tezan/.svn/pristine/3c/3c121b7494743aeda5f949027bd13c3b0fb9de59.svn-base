<?php
require_once('Smarty_setup.php');
require_once('include/utils/utils.php');
$businesseid = '334458';
$sourcebusinesseid = '72262';
$supplierid = '329747';
	
	
syncbasedata($businesseid,$sourcebusinesseid,$supplierid);

function syncbasedata($businesseid,$sourcebusinesseid,$supplierid)
{
	$source_businesses = XN_Content::load($sourcebusinesseid,"local_businesses",4);
	$source_application = $source_businesses->application;
	$businesses = XN_Content::load($businesseid,"local_businesses",4);
	$application = $businesses->application;
	
	XN_Application::$CURRENT_URL = $source_application;
	$local_brandids = array();
	$local_brands = XN_Query::create('Content')
					->tag('local_brands')
					->filter('type','eic','local_brands')
					->filter('my.businesseid','=',$sourcebusinesseid)
					->filter('my.deleted','=','0') 
					->end(-1)
					->execute();
	foreach($local_brands as $local_brand_info)
	{
		$brandid = $local_brand_info->id;
		$fields = array("deleted","status","brand_desc","brand_name","local_brandsstatus","brand_logo");
		XN_Application::$CURRENT_URL = $application;
		$brands = XN_Query::create('Content')
						->tag('local_brands')
						->filter('type','eic','local_brands')  
						->filter('my.businesseid','=',$businesseid)
						->filter('my.syncsource','=',$brandid) 
						->end(1)
						->execute();
		if (count($brands) > 0)
		{ 	 
			$brand_info = $brands[0];
            foreach($fields as $fieldname){ 
                 $brand_info->my->$fieldname=$local_brand_info->my->$fieldname; 
            } 
			$brand_info->save("local_brands,local_brands_".$supplierid.",local_brands_".$businesseid); 
			$local_brandids[$brandid] = $brand_info->id;
		}
		else
		{
		    $brand_info = XN_Content::create('local_brands','',false);
			$brand_info->my->add('supplierid',$supplierid);
			$brand_info->my->add('businesseid',$businesseid);
			$brand_info->my->add('syncsource',$brandid);
            foreach($fields as $fieldname){ 
                 $brand_info->my->$fieldname=$local_brand_info->my->$fieldname; 
            }   
			$brand_info->save("local_brands,local_brands_".$supplierid.",local_brands_".$businesseid); 
			$local_brandids[$brandid] = $brand_info->id;      
		} 
	}
	 
	XN_Application::$CURRENT_URL = $source_application;
	$local_categoryids = array();
	$local_categorys = XN_Query::create('Content')
					->tag('local_categorys')
					->filter('type','eic','local_categorys')
					->filter('my.businesseid','=',$sourcebusinesseid)
					->filter('my.deleted','=','0') 
					->end(-1)
					->execute();
	foreach($local_categorys as $local_category_info)
	{
		$categoryid = $local_category_info->id;
		$fields = array("deleted","pid","categoryicon","categoryname","sequence"); 
		XN_Application::$CURRENT_URL = $application;
		$categorys = XN_Query::create('Content')
						->tag('local_categorys')
						->filter('type','eic','local_categorys')  
						->filter('my.businesseid','=',$businesseid)
						->filter('my.syncsource','=',$categoryid) 
						->end(1)
						->execute();
		if (count($categorys) > 0)
		{ 	 
			$category_info = $categorys[0];
            foreach($fields as $fieldname){ 
                 $category_info->my->$fieldname=$local_category_info->my->$fieldname; 
            } 
			$category_info->save("local_categorys,local_categorys_".$supplierid.",local_categorys_".$businesseid); 
			$local_categoryids[$categoryid] = $category_info->id;
		}
		else
		{
		    $category_info = XN_Content::create('local_categorys','',false);
			$category_info->my->add('supplierid',$supplierid);
			$category_info->my->add('businesseid',$businesseid);
			$category_info->my->add('syncsource',$categoryid);
            foreach($fields as $fieldname){ 
                 $category_info->my->$fieldname=$local_category_info->my->$fieldname; 
            }   
			$category_info->save("local_categorys,local_categorys_".$supplierid.",local_categorys_".$businesseid);  
			$local_categoryids[$categoryid] = $category_info->id;      
		} 
	}
	
	
	XN_Application::$CURRENT_URL = $source_application;
	$local_products = XN_Query::create('Content')
					->tag('local_products')
					->filter('type','eic','local_products')
					->filter('my.businesseid','=',$sourcebusinesseid)
					->filter('my.deleted','=','0') 
					->end(-1)
					->execute();
	foreach($local_products as $local_product_info)
	{
		$productid = $local_product_info->id;
		$fields = array("property_type","submitapprovalreplydatetime","finishapprover","local_productsstatus","approvalstatus",
						"keywords","productname","hitshelf","shop_price","simple_desc","productthumbnail","preview",
						"barcode","market_price","parameters","internalno","description","product_weight","salevolume",
						"memberrate","weight_unit","productlogo","local_products_no","inventory","product_guige","deleted"); 
		XN_Application::$CURRENT_URL = $application;
		$products = XN_Query::create('Content')
						->tag('local_products')
						->filter('type','eic','local_products')  
						->filter('my.businesseid','=',$businesseid)
						->filter('my.syncsource','=',$productid) 
						->end(1)
						->execute();
		if (count($products) > 0)
		{ 	 
			$old_brand = $local_product_info->my->brand;
			$old_categorys = $local_product_info->my->categorys;
			$product_info = $products[0];
            foreach($fields as $fieldname){ 
                 $product_info->my->$fieldname=$local_product_info->my->$fieldname; 
            } 
			$product_info->my->brand = $local_brandids[$old_brand];
			$product_info->my->categorys= $local_categoryids[$old_categorys];
			$product_info->save("local_products,local_products_".$supplierid.",local_products_".$businesseid); 
			
			$productid = $product_info->id;
			$local_inventorys = XN_Query::create('Content')
							->tag('local_inventorys')
							->filter('type','eic','local_inventorys')  
							->filter('my.businesseid','=',$businesseid)
							->filter('my.productid','=',$productid) 
							->end(1)
							->execute();
			if (count($local_inventorys) == 0)
			{
				$brand = XN_Content::create('local_inventorys',"",false);
				$brand->my->createnew = '0';
				$brand->my->deleted = '0'; 
				$brand->my->productid = $product_info->id;
				$brand->my->productname = $product_info->my->productname;
				$brand->my->supplierid = $product_info->my->supplierid;
				$brand->my->businesseid = $product_info->my->businesseid; 
				$brand->my->inventory = $product_info->my->inventory;
				$brand->my->propertytype = "";
				$brand->my->propertytypeid = "";
	            $brand->my->warnline = 50;
				$brand->my->price = $product_info->my->shop_price;
				$brand->save('local_inventorys,local_inventorys_'.$product_info->my->businesseid);
			
				$brand = XN_Content::create('local_turnovers',"",false,7);  
				$brand->my->supplierid = $product_info->my->supplierid;
				$brand->my->businesseid = $product_info->my->businesseid; 
				$brand->my->deleted = '0'; 
			    $brand->my->productid = $product_info->id;
			    $brand->my->productname = $product_info->my->productname;
			    $brand->my->propertyid = "";
				$brand->my->propertydesc = "";
			    $brand->my->local_turnoversstatus = '新建商品入库';
			    $brand->my->oldinventory = '0';
				$brand->my->amount = '+'.$product_info->my->inventorys;
			    $brand->my->newinventory = $product_info->my->inventorys;
			    $brand->save('local_turnovers,local_turnovers_'.$product_info->my->businesseid);
			} 
		}
		else
		{
			$old_brand = $local_product_info->my->brand;
			$old_categorys = $local_product_info->my->categorys;
		    $product_info = XN_Content::create('local_products','',false);
			$product_info->my->add('supplierid',$supplierid);
			$product_info->my->add('businesseid',$businesseid);
			$product_info->my->add('syncsource',$productid);
			$product_info->my->brand = $local_brandids[$old_brand];
			$product_info->my->categorys= $local_categoryids[$old_categorys];
            foreach($fields as $fieldname){ 
                 $product_info->my->$fieldname=$local_product_info->my->$fieldname; 
            }   
			$product_info->save("local_products,local_products_".$supplierid.",local_products_".$businesseid);
			
			$productid = $product_info->id;
			$local_inventorys = XN_Query::create('Content')
							->tag('local_inventorys')
							->filter('type','eic','local_inventorys')  
							->filter('my.businesseid','=',$businesseid)
							->filter('my.productid','=',$productid) 
							->end(1)
							->execute();
			if (count($local_inventorys) == 0)
			{
				$brand = XN_Content::create('local_inventorys',"",false);
				$brand->my->createnew = '0';
				$brand->my->deleted = '0'; 
				$brand->my->productid = $product_info->id;
				$brand->my->productname = $product_info->my->productname;
				$brand->my->supplierid = $product_info->my->supplierid;
				$brand->my->businesseid = $product_info->my->businesseid; 
				$brand->my->inventory = $product_info->my->inventory;
				$brand->my->propertytype = "";
				$brand->my->propertytypeid = "";
	            $brand->my->warnline = 50;
				$brand->my->price = $product_info->my->shop_price;
				$brand->save('local_inventorys,local_inventorys_'.$product_info->my->businesseid);
			
				$brand = XN_Content::create('local_turnovers',"",false,7);  
				$brand->my->supplierid = $product_info->my->supplierid;
				$brand->my->businesseid = $product_info->my->businesseid; 
				$brand->my->deleted = '0'; 
			    $brand->my->productid = $product_info->id;
			    $brand->my->productname = $product_info->my->productname;
			    $brand->my->propertyid = "";
				$brand->my->propertydesc = "";
			    $brand->my->local_turnoversstatus = '新建商品入库';
			    $brand->my->oldinventory = '0';
				$brand->my->amount = '+'.$product_info->my->inventorys;
			    $brand->my->newinventory = $product_info->my->inventorys;
			    $brand->save('local_turnovers,local_turnovers_'.$product_info->my->businesseid);
			} 
			
		} 
	}
	
	 
}
/*
global  $currentModule;

if (isset($_REQUEST['record']) && $_REQUEST['record'] != "" &&
    isset($_REQUEST['type']) && $_REQUEST['type'] == "submit" )
{
	if (isset($_REQUEST['sourceshopid']) && $_REQUEST['sourceshopid'] != "")
	{
	    try {
	        $binds = $_REQUEST['record'];
	        $sourceshopid = $_REQUEST['sourceshopid']; 
	        $binds = str_replace(";",",",$binds);
	        $binds = explode(",",trim($binds,','));
	        array_unique($binds);
			if (count($binds) > 0)
			{
				$sourceshop = XN_Content::load($sourceshopid,"supplier_shops");
				$supplierid= $sourceshop->my->supplierid; 
				$sourcebusinesseid = $sourceshop->my->businesseid;
				if ($sourceshop->my->standardsource != "1")
				{
					$sourceshop->my->standardsource = '1';
					$sourceshop->save("supplier_shops,supplier_shops_".$supplierid);
				}
				 
				$loadcontents = XN_Content::loadMany($binds,"supplier_shops");
		        foreach($loadcontents as $supplier_shop_info)
		        { 
					$businesseid = $supplier_shop_info->my->businesseid; 
					syncbasedata($businesseid,$sourcebusinesseid,$supplierid);
		        } 
		        
			} 
	        echo '{"statusCode":"200","message":null,"tabid":"'.$currentModule.'","closeCurrent":true,"forward":null}';
	    } catch ( XN_Exception $e )
	    {
	        echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
	    }
	}
	else
	{
		echo '{"statusCode":"300","message":"同步店铺源必选！"}';
	}
   
    die();
}
else{ 
	
    $binds = $_REQUEST['ids'];  
    $binds = str_replace(";",",",$binds);
    $binds = explode(",",trim($binds,','));
    array_unique($binds); 
	
	
	$supplier_shops = XN_Query::create('Content')
					->tag('supplier_shops')
					->filter('type','eic','supplier_shops') 
					->filter('my.approvalstatus','=','2') 
					->filter('my.standardsource','=','1') 
					->filter('my.deleted','=','0') 
					->end(1)
					->execute();
	$shopoptions =  "";
	if (count($supplier_shops) > 0) 
	{		
		foreach($supplier_shops as $supplier_shop_info)	 
		{ 
			$key = $supplier_shop_info->id;
			$name = $supplier_shop_info->my->name;
			if (!in_array($key,$binds))
			{
				$shopoptions .= '<option value='.$key.'>'.$name.'</option>';
			} 
		}		
	} 
	else
	{
		$supplier_shops = XN_Query::create('Content')
						->tag('supplier_shops')
						->filter('type','eic','supplier_shops') 
						->filter('my.approvalstatus','=','2') 
						->filter('my.deleted','=','0')
						->execute(); 
		if (count($supplier_shops) > 0) 
		{		
			foreach($supplier_shops as $supplier_shop_info)	 
			{ 
				$key = $supplier_shop_info->id;
				$name = $supplier_shop_info->my->name;
				if (!in_array($key,$binds))
				{
					$shopoptions .= '<option value='.$key.'>'.$name.'</option>';
				} 
			}		
		} 
	} 
	
	$msg =  '<div class="form-group">
	                <label class="control-label x120">同步店铺源:</label>
					<select id="sourceshopid" name="sourceshopid" class="required" style="cursor: pointer;width:200px;">'.$shopoptions.'</select>
	                <span style="float:left; line-height: 25px;padding: 0 5px;"></span>
			    </div> ';
}

$smarty = new vtigerCRM_Smarty;
global $mod_strings;
global $app_strings;
global $app_list_strings;
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->assign("MSG", $msg);
$smarty->assign("OKBUTTON", "确定");
$smarty->assign("RECORD",$_REQUEST['ids']);
$smarty->assign("SUBMODULE", "Supplier_Shops");
$smarty->assign("SUBACTION", "SyncBaseData");

$smarty->display("MessageBox.tpl");*/

?>
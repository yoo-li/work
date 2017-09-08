<?php
require_once('Smarty_setup.php');
global  $currentModule,$supplierid;

if(isset($_REQUEST['type']) && $_REQUEST['type'] == "submit")
{

	$productid = $_REQUEST['record']; 
	$product_info =  XN_Content::load($productid,"mall_products_".$supplierid);

	$mall_product_property = XN_Query::create("Content")->tag("mall_product_property")
		->filter("type","eic","mall_product_property")
		->filter("my.productid","=",$productid)
		->filter("my.deleted","=",'0')
		->end(-1)
		->execute();
	if (count($mall_product_property) > 0)
	{
		$min_price = 999999;
		$total_inventory = 0;
		foreach ($mall_product_property as $mall_product_property_info)
		{
			$propertyid = $mall_product_property_info->id;
			if(isset($_REQUEST['property_price_'.$propertyid]) && $_REQUEST['property_price_'.$propertyid] != "" &&
				isset($_REQUEST['property_inventory_'.$propertyid]) && $_REQUEST['property_inventory_'.$propertyid] != "" )
			{
				$property_price = $_REQUEST['property_price_'.$propertyid];
				$property_inventory = $_REQUEST['property_inventory_'.$propertyid];
				$property_price = number_format($property_price, 2, ".", "");
				$old_shop_price = $mall_product_property_info->my->shop;
				if ($mall_product_property_info->my->shop != $property_price || $mall_product_property_info->my->vendor_price != $property_price)
				{
					$mall_product_property_info->my->shop = $property_price;
					$mall_product_property_info->my->vendor_price = $property_price;
					$mall_product_property_info->save("mall_product_property,mall_product_property_".$supplierid);
					
					$newcontent=XN_Content::create('mall_adjustratelog',"",false,7);
		            $newcontent->my->deleted = '0';
		            $newcontent->my->supplierid = $product_info->my->supplierid;
		            $newcontent->my->profileid = XN_Profile::$VIEWER;
		            $newcontent->my->productid = $product_info->id;
		            $newcontent->my->adjusttype  = "调整价格";
		            $newcontent->my->products_no  =$product_info->my->mall_products_no ;
		            $newcontent->my->productname = $product_info->my->productname;
		            $newcontent->my->oldrate = '-'; 
		            $newcontent->my->newrate = '-'; 
		            $newcontent->my->old_commissionswitch = '-'; 
		            $newcontent->my->new_commissionswitch = '-'; 
		            $newcontent->my->oldpostage = '-'; 
		            $newcontent->my->newpostage = '-'; 
					$newcontent->my->propertyid = $propertyid; 
					$newcontent->my->propertydesc = $mall_product_property_info->my->propertydesc; 
					$newcontent->my->old_shop_price = $old_shop_price; 
					$newcontent->my->new_shop_price = $property_price;  
		            $newcontent->save("mall_adjustratelog,mall_adjustratelog_".$product_info->my->supplierid);
				}
				$property_inventorys = XN_Query::create('Content')->tag('mall_inventorys_'.$supplierid)
					->filter('type','eic','mall_inventorys')
					->filter ('my.productid','=',$productid)
					->filter ('my.propertytypeid','=',$propertyid)
					->end(1)
					->execute();
				if (count($property_inventorys) > 0)
				{
					$property_inventory_info = $property_inventorys[0];
					if ($property_inventory_info->my->inventory != $property_inventory)
					{
						$property_inventory_info->my->inventory = $property_inventory;
						$property_inventory_info->save("mall_inventorys,mall_inventorys_".$supplierid);
					}
				}
				if (floatval($property_price) < $min_price)
				{
					$min_price = $property_price;
				}
				$total_inventory += intval($property_inventory);
			}
		}
		if ($product_info->my->shop_price != $min_price || $product_info->my->vendor_price != $min_price)
		{
			$product_info->my->shop_price = number_format($min_price, 2, ".", "");
			$vendorid = $product_info->my->vendorid;
			if (isset($vendorid) && $vendorid != "")
			{
				$product_info->my->vendor_price = number_format($min_price, 2, ".", "");
			}
			else
			{
				$product_info->my->vendor_price = "";
			}
			
			$product_info->save("mall_products,mall_products_".$supplierid);
		}
	}
	else
	{
		if(isset($_REQUEST['product_price']) && $_REQUEST['product_price'] != "" &&
			isset($_REQUEST['product_inventory']) && $_REQUEST['product_inventory'] != "" )
		{
			$product_price = $_REQUEST['product_price'];
			$product_inventory = $_REQUEST['product_inventory'];
			$product_price = number_format($product_price, 2, ".", "");
			$old_shop_price = $product_info->my->shop_price;
			if ($product_info->my->shop_price != $product_price || $product_info->my->vendor_price != $product_price)
			{
				$product_info->my->shop_price = $product_price;
				$product_info->my->vendor_price = $product_price;
				$product_info->save("mall_products,mall_products_".$supplierid);
				
				$newcontent=XN_Content::create('mall_adjustratelog',"",false,7);
	            $newcontent->my->deleted = '0';
	            $newcontent->my->supplierid = $product_info->my->supplierid;
	            $newcontent->my->profileid = XN_Profile::$VIEWER;
	            $newcontent->my->productid = $product_info->id;
	            $newcontent->my->adjusttype  = "调整价格";
	            $newcontent->my->products_no  =$product_info->my->mall_products_no ;
	            $newcontent->my->productname = $product_info->my->productname;
	            $newcontent->my->oldrate = '-'; 
	            $newcontent->my->newrate = '-'; 
	            $newcontent->my->old_commissionswitch = '-'; 
	            $newcontent->my->new_commissionswitch = '-'; 
	            $newcontent->my->oldpostage = '-'; 
	            $newcontent->my->newpostage = '-'; 
				$newcontent->my->propertyid = ''; 
				$newcontent->my->propertydesc = '-'; 
				$newcontent->my->old_shop_price = $old_shop_price; 
				$newcontent->my->new_shop_price = $product_price;  
	            $newcontent->save("mall_adjustratelog,mall_adjustratelog_".$product_info->my->supplierid);
			}
			$property_inventorys = XN_Query::create('Content')->tag('mall_inventorys_'.$supplierid)
				->filter('type','eic','mall_inventorys')
				->filter ('my.productid','=',$productid)
				->end(1)
				->execute();
			if (count($property_inventorys) > 0)
			{
				$property_inventory_info = $property_inventorys[0];
				if ($property_inventory_info->my->inventory != $product_inventory)
				{
					$property_inventory_info->my->inventory = $product_inventory;
					$property_inventory_info->save("mall_inventorys,mall_inventorys_".$supplierid);
					
					$brand = XN_Content::create('mall_turnovers',"",false,7);
					$brand->my->supplierid = $product_info->my->supplierid;
					$brand->my->deleted = '0';
					$brand->my->productid = $product_info->my->productid;
					$brand->my->productname = $product_info->my->productname;
					$brand->my->propertyid = $product_info->my->propertytypeid;
					$brand->my->propertydesc = $product_info->my->propertytype;
					$brand->my->mall_turnoversstatus = '估清';
					$brand->my->oldinventory = $oldinventory;
					$brand->my->amount = $amount;
					$brand->my->newinventory = $newinventory;
					$brand->save('mall_turnovers,mall_turnovers_'.$info->my->supplierid);
				}
			}
			
			
		}
	}

	/*
	$mall_inventorys = XN_Query::create('Content')->tag('mall_inventorys')
		->filter('type','eic','mall_inventorys')
		->filter('my.deleted','=','0')
		->filter('my.supplierid','=',$supplierid)
		->filter('my.productid','=',$productid)
		->end(1)
		->execute();
	foreach($mall_inventorys as $mall_inventory_info)
	{
		if ($mall_inventory_info->my->vendorid != $vendorid)
		{
			$mall_inventory_info->my->vendorid = $vendorid;
			$mall_inventory_info->save("mall_inventorys,mall_inventorys_".$supplierid);
		}
	}*/


	echo '{"statusCode":"200","message":null,"tabid":"'.$currentModule.'","closeCurrent":true,"forward":null}';
	die();
}
else
{
	$smarty = new vtigerCRM_Smarty;
	$binds = $_REQUEST['ids'];
	$binds = str_replace(";",",",$binds);
	$binds = explode(",",trim($binds,','));
	array_unique($binds);
	array_unique($binds);
	if (count($binds) > 1)
	{
		echo '<div style="width:100%;text-align:center;"><br><br><font color="red" size="2">您只能选择单条记录进行修改操作！</font></div>';
		die();
	}
	$productid = $_REQUEST['ids']; 
	$product_info =  XN_Content::load($productid,"mall_products_".$supplierid);
	$shop_price = $product_info->my->shop_price;
	$shop_price = number_format($shop_price, 2, ".", "");
	
	if ($product_info->my->approvalstatus != "2")
	{
		echo '<div style="width:100%;text-align:center;"><br><br><font color="red" size="2">您只能对已经审批通过的商品进行修改操作！</font></div>';
		die();
	}


	$msg='<table class="table table-bordered" border="0" cellspacing="0" cellpadding="0">';

	$mall_product_property = XN_Query::create("Content")->tag("mall_product_property")
		->filter("type","eic","mall_product_property")
		->filter("my.productid","=",$productid)
		->filter("my.deleted","=",'0')
		->end(-1)
		->execute();
	if (count($mall_product_property) > 0)
	{
		foreach ($mall_product_property as $mall_product_property_info)
		{
			$propertyid = $mall_product_property_info->id;
			$shop = $mall_product_property_info->my->shop;
			$shop = number_format($shop, 2, ".", "");
			$property_inventorys = XN_Query::create('Content')->tag('mall_inventorys_'.$supplierid)
				->filter('type','eic','mall_inventorys')
				->filter ('my.productid','=',$productid)
				->filter ('my.propertytypeid','=',$propertyid)
				->end(1)
				->execute();
			if (count($property_inventorys) > 0)
			{
				$property_inventory_info = $property_inventorys[0];
				$property_inventory = $property_inventory_info->my->inventory;
			}
			else
			{
				$property_inventory = 0;
			}
			$propertydesc = $mall_product_property_info->my->propertydesc;
			$msg.= '<tr>
				<td>' . $propertydesc . '-销售价:</td>
				<td>
					<input class="form-control number required" type="text" value="' . $shop . '" name="property_price_'.$propertyid.'" tabindex="16" style="width:120px" maxlength="100" data-rule="number;required;" >元
				</td>
				<td>' . $propertydesc . '-库存量:</td>
				<td>
						<input class="form-control number required" type="text" value="' . $property_inventory . '" name="property_inventory_'.$propertyid.'" tabindex="16" style="width:120px" maxlength="100" data-rule="number;required;" >
						 </td>
				</tr>';
		}
	}
	else
	{
		$mall_inventorys = XN_Query::create('Content')->tag('mall_inventorys')
			->filter('type','eic','mall_inventorys')
			->filter('my.deleted','=','0')
			->filter('my.supplierid','=',$supplierid)
			->filter('my.productid','=',$productid)
			->end(1)
			->execute();
		$inventory = 0;
		if (count($mall_inventorys) > 0)
		{
			$mall_inventory_info = $mall_inventorys[0];
			$inventory = $mall_inventory_info->my->inventory;
		} 
		$msg.= '<tr>
				<td>销售价:</td>
				<td>
					<input class="form-control number required" type="text" value="'.$shop_price.'" name="product_price" tabindex="16" style="width:120px" maxlength="100"  data-rule="number;required;"  >
					元
				</td>
				<td>库存量:</td>
				<td>
					<input class="form-control number required" type="text" value="' . $inventory . '" name="product_inventory" tabindex="16" style="width:120px" maxlength="100" data-rule="number;required;"  >
				 </td>
			</tr>';
	}



	$msg.= '</table>';
	$smarty->assign("MSG", $msg);
	$smarty->assign("OKBUTTON", "确定修改");
	$smarty->assign("RECORD",$_REQUEST['ids']);
	$smarty->assign("SUBMODULE", $currentModule);
	$smarty->assign("SUBACTION", $_REQUEST['action']);
	$smarty->display("MessageBox.tpl");
}

 

?>

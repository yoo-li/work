<?php
require_once('Smarty_setup.php');
global  $currentModule,$supplierid;

if(isset($_REQUEST['type']) && $_REQUEST['type'] == "submit")
{

	$record = $_REQUEST['record'];
	$inventory_info=XN_Content::load($record,$currentModule);
	$productid=$inventory_info->my->productid;
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
				if ($mall_product_property_info->my->shop != $property_price || $mall_product_property_info->my->vendor_price != $property_price)
				{
					$mall_product_property_info->my->shop = $property_price;
					$mall_product_property_info->my->vendor_price = $property_price;
					$mall_product_property_info->save("mall_product_property,mall_product_property_".$supplierid);
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
			$product_info->my->vendor_price = number_format($min_price, 2, ".", "");
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
			if ($product_info->my->shop_price != $product_price || $product_info->my->vendor_price != $product_price)
			{
				$product_info->my->shop_price = $product_price;
				$product_info->my->vendor_price = $product_price;
				$product_info->save("mall_products,mall_products_".$supplierid);
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
				}
			}
		}
	}


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
	}


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
	$record = $_REQUEST['ids'];
	$loadcontent =  XN_Content::load($record,"mall_inventorys_".$supplierid);
	$productid = $loadcontent->my->productid;
	$inventory = $loadcontent->my->inventory;
	$product_info =  XN_Content::load($productid,"mall_products_".$supplierid);
	$shop_price = $product_info->my->shop_price;
	$shop_price = number_format($shop_price, 2, ".", "");


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
			$msg.= '<tr class="edit-form-tr">
				<td class="edit-form-tdlabel mandatory">' . $propertydesc . '-销售价:</td>
				<td class="edit-form-tdinfo">
					<input class="input input-large number number textInput required" type="text" value="' . $shop . '" name="property_price_'.$propertyid.'" tabindex="16" style="width:60px" maxlength="100" >元
				</td>
				<td class="edit-form-tdlabel mandatory">' . $propertydesc . '-库存量:</td>
				<td class="edit-form-tdinfo">
						<input class="input input-large number number textInput required" type="text" value="' . $property_inventory . '" name="property_inventory_'.$propertyid.'" tabindex="16" style="width:60px" maxlength="100" >
						 </td>
				</tr>';
		}
	}
	else
	{

		$msg.= '<tr class="edit-form-tr">
				<td class="edit-form-tdlabel mandatory">销售价:</td>
				<td class="edit-form-tdinfo">
					<input class="input input-large number number textInput required" type="text" value="'.$shop_price.'" name="product_price" tabindex="16" style="width:60px" maxlength="100" >
					元
				</td>
				<td class="edit-form-tdlabel mandatory">库存量:</td>
				<td class="edit-form-tdinfo">
					<input class="input input-large number number textInput required" type="text" value="' . $inventory . '" name="product_inventory" tabindex="16" style="width:60px" maxlength="100" >
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

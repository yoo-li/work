<?php

XN_Application::$CURRENT_URL = "admin";

 

$mall_inventorys = XN_Query::create("Content") 
    ->filter("type","eic","mall_inventorys")
    ->filter("my.deleted","=",'0') 
    ->end(-1)
    ->execute();
foreach($mall_inventorys as $mall_inventory_info)
{
	$categorys = $mall_inventory_info->my->categorys; 
	if (!isset($categorys) || $categorys == "") 
	{ 
		$productid = $mall_inventory_info->my->productid; 
		$businesseid = $mall_inventory_info->my->businesseid; 
		if (isset($productid) && $productid != "")
		{
			$product_info = XN_Content::load($productid,"mall_products");
			$productname = $mall_product_info->my->productname;
			$mall_inventory_info->my->categorys = $product_info->my->categorys;  
			$mall_inventory_info->save("mall_inventorys,mall_inventorys_".$businesseid); 
			echo '_______'.$productname.'______________________<br>';
		} 
	}
}
die(); 
?>







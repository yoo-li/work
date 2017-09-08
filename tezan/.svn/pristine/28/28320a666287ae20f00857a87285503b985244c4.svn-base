<?php
/*********************************************************************************
 * The contents of this file are subject to the SugarCRM Public License Version 1.1.2
 * ("License"); You may not use this file except in compliance with the
 * License. You may obtain a copy of the License at http://www.sugarcrm.com/SPL
 * Software distributed under the License is distributed on an  "AS IS"  basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied. See the License for
 * the specific language governing rights and limitations under the License.
 * The Original Code is:  SugarCRM Open Source
 * The Initial Developer of the Original Code is SugarCRM, Inc.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.;
 * All Rights Reserved.
 * Contributor(s): ______________________________________.
 ********************************************************************************/
require_once('Smarty_setup.php');
require_once('include/utils/utils.php');

global $app_strings, $default_charset;
global $currentModule, $current_user;

$currentModule = "Mall_ProductLibs";

$smarty = new vtigerCRM_Smarty;

$popuptype = $_REQUEST["popuptype"];

$smarty->assign("MOD", $mod_strings);
$smarty->assign("APP", $app_strings);
$smarty->assign("MODULE",$currentModule);

global  $supplierid,$supplierusertype;

if(isset($_REQUEST['productid']) && $_REQUEST['productid'] !='')
{
    $productid = $_REQUEST['productid']; 
	$_SESSION['libproductid'] = $productid;
}
else if(isset($_SESSION['libproductid']) && $_SESSION['libproductid'] !='')
{
	$productid = $_SESSION['libproductid']; 
}
else
{
	echo '参数错误!';
	die();
}


if(isset($_SESSION['vendorid']) && $_SESSION['vendorid'] !='')
{
	$vendorid = $_SESSION['vendorid']; 
}
else
{
	$vendorid = ""; 
}

 

if(isset($_REQUEST['type']) && trim($_REQUEST['type']) == "submit" &&
	isset($_REQUEST['record']) && trim($_REQUEST['record']) != "")
{
 	$record = $_REQUEST['record']; 
    $productlib_info = XN_Content::load($record,"mall_productlibs");
	$product_info = XN_Content::load($productid,"mall_products");
    $fields=array("market_price","shop_price","productname","categorys","royaltyrate","brand","sequence",
	              "barcode","internalno","product_weight","keywords","product_guige","simple_desc",
				  "description","productlogo","productthumbnail","qualitycertificate","taobaoid",
			  	  "property_type","myproperty_type","physicaltype","postage","include_post_count",
				  "mergepostage","memberrate","inventory","measurementunit");
    
	foreach($fields as $fieldname)
	{
		$product_info->my->$fieldname = $productlib_info->my->$fieldname; 
	}
	$product_info->my->deleted='0';
	$product_info->my->createnew='0';
	$product_info->my->supplierid = $supplierid;
	$product_info->my->vendorid = $vendorid;
	if (isset($vendorid) && $vendorid != "")
	{
		$vendor_price = $productlib_info->my->shop_price; 
		$product_info->my->vendor_price = $vendor_price;
	}
	$mall_products_no = XN_ModentityNum::get("Mall_Products");
	$product_info->my->mall_products_no = $mall_products_no;
	
    $product_info->my->approvalstatus = '0';
    $product_info->my->status = '0';
    $product_info->my->salevolume = '0';
    $product_info->my->hitshelf = 'off'; 
    $product_info->my->mall_productsstatus = 'Saved'; 
	$product_info->save("mall_products,mall_products_".$supplierid);



	$propertys=XN_Query::create ( 'Content' ) 
	    ->filter ( 'type', 'eic', 'mall_propertys' )
	    ->filter ( 'my.productid', '=', $productid)
	    ->begin(0)->end(-1)
	    ->execute ();
	if(count($propertys) > 0){
	    XN_Content::delete($propertys,"mall_propertys,mall_propertys_".$supplierid);
	}
	$product_propertys=XN_Query::create ( 'Content' ) 
	    ->filter ( 'type', 'eic', 'mall_product_property' )
	    ->filter ( 'my.productid', '=', $productid) 
	    ->begin(0)->end(-1)
	    ->execute ();
	if(count($product_propertys) > 0){
	    XN_Content::delete($product_propertys,"mall_product_property,mall_product_property_".$supplierid);
	}
	
	
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
	$product_propertys=XN_Query::create ( 'Content' )
	    ->tag("mall_product_property")
	    ->filter ( 'type', 'eic', 'mall_product_property' )
	    ->filter ( 'my.productid', '=', $record)
		->filter ( 'my.deleted', '=', '0')
		->filter ( 'my.status', '=', '0')
	    ->begin(0)->end(-1)
	    ->execute ();
	
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
		if (isset($vendorid) && $vendorid != "")
		{
			$vendor_price = $product_property_info->my->shop; 
			$newcontent->my->vendor_price = $vendor_price;
		}
		$newcontent->save("mall_product_property,mall_product_property_".$supplierid);
	}
	echo $product_info->id;
	die();
}

 

include ('modules/Mall_ProductLibs/Popup.php');

?>

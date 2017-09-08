<?php
/*+**********************************************************************************
 * The contents of this file are subject to the 361CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  361CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

global $mod_strings,$app_strings,$theme,$currentModule,$current_user,$supplierid,$supplierusertype;
global  $supplierid,$supplierusertype;

if (isset($_REQUEST['record']) && $_REQUEST['record'] != "" && 
    isset($_REQUEST['type']) && $_REQUEST['type'] == "submit" )
{
    try { 
        $binds = $_REQUEST['record'];  
        $binds = str_replace(";",",",$binds);
        $binds = explode(",",trim($binds,','));
        array_unique($binds);
		if (count($binds) > 0)
		{
			$loadcontents = XN_Content::loadMany($binds,"mall_products_".$supplierid);
	        foreach($loadcontents as $product_info)
	        {
				 $productid = $product_info->id;
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
				  XN_Content::delete($product_propertys,'mall_product_property,mall_product_property_'.$supplierid);
				  $product_info->my->property_type = "";
				  $product_info->save("mall_products,mall_products_".$supplierid);
			} 
		}
		 

        echo '{"statusCode":"200","message":null,"tabid":"edit","closeCurrent":true,"forward":null}';
    } 
	catch ( XN_Exception $e )
    {
        echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
    }
    die();
}


require_once('Smarty_setup.php');
require_once('include/utils/utils.php');

$smarty = new vtigerCRM_Smarty;

$smarty->assign("MODULE",$currentModule);
$smarty->assign("APP",$app_strings);
$smarty->assign("MOD", $mod_strings);

if(isset($_REQUEST['ids']) && $_REQUEST['ids'] !='') 
{
    $record=$_REQUEST['ids']; 
 
    $msg = '';
	$msg .= '<div style="width:100%"><font color="red" size="2">确定清除提交后，当前商品的所有的属性将会被删除，是否确定清除?</font></div>'; 
	$smarty->assign("MSG", $msg);
	$smarty->assign("SUBMODULE", $currentModule);
	$smarty->assign("SUBACTION", 'ClearAllPropertys'); 
	$smarty->assign("OKBUTTON", '确定清除');
    $smarty->assign("CANCELBUTTON", getTranslatedString('LBL_CANCEL_BUTTON_LABEL'));
    $smarty->assign("RECORD", $record);
}

$smarty->display('MessageBox.tpl');


?>
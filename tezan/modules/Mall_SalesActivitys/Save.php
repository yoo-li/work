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
/*********************************************************************************
 * $Header: /advent/projects/wesat/vtiger_crm/sugarcrm/modules/Users/Save.php,v 1.14 2005/03/17 06:37:39 rank Exp $
 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

require_once('modules/Users/Users.php');
require_once('include/utils/UserInfoUtil.php');




global $currentModule,$current_user;



$focus = CRMEntity::getInstance($currentModule);


setObjectValuesFromRequest($focus);
global  $supplierid,$localusertype;
if($focus->column_fields['supplierid'] == '' && $focus->mode == "create")
{
		$focus->column_fields['supplierid'] = $supplierid;
}

if($focus->column_fields[strtolower($currentModule). 'status'] == '' && $focus->mode == "create")
{
    $focus->column_fields[strtolower($currentModule). 'status'] = 'JustCreated'; 
}
 
$product_arr = array();
$product_ids = $_REQUEST['products_id'];
$nums = $_REQUEST['num']; 
$nums = (array)$nums;

foreach((array)$product_ids as $index=>$product_id)
{
    if(trim($product_id)!='')
	{
        $product_arr[$product_id]['num']=$nums[$index];
        $product_arr[$product_id]['label']=$nums[$index]."折";
    }
}

 

try {
	if(isset($_REQUEST['record']) && $_REQUEST['record'] !='')
	{
		$salesactivityid = $_REQUEST['record'];  
		$loadcontent = XN_Content::load($salesactivityid,'mall_salesactivitys');
        $salesactivitys_products = XN_Query::create("Content")->tag("mall_salesactivitys_products")
				           ->filter("type","eic","mall_salesactivitys_products")
				           ->filter("my.salesactivityid","=",$salesactivityid)
				           ->end(-1)
				           ->execute();
	     XN_Content::delete($salesactivitys_products,"mall_salesactivitys_products");
		 $productids = array_keys($product_arr);
		 $products = XN_Content::load($productids,"mall_products");
		 foreach($products as $product_info)
		 {
			 $productid = $product_info->id;
	         $activity_product_content=XN_Content::create("mall_salesactivitys_products","",false);
	         $activity_product_content->my->deleted=0;
	         $activity_product_content->my->supplierid=$supplierid;
			 $activity_product_content->my->businesseid=$businesseid;
	         $activity_product_content->my->zhekou = $product_arr[$productid]['num'];
	         $activity_product_content->my->label = $product_arr[$productid]['label'];
	         $activity_product_content->my->productid = $productid;//只要这种商品参与活动，则不管他有没有属性，都按同一个规则
			 $activity_product_content->my->productname = $product_info->my->productname;
	         $activity_product_content->my->salesactivityid=$salesactivityid;
	         $activity_product_content->my->salesactivitytype= '0';
	         $activity_product_content->my->begindate=$loadcontent->my->begindate;
	         $activity_product_content->my->enddate=$loadcontent->my->enddate;   
	         $activity_product_content->my->status=$_REQUEST['status'];
	         $activity_product_content->my->approvalstatus='0';
	         $activity_product_content->save("mall_salesactivitys_products");
		 }
	 } 
	 
	 
	$focus->saveentity($currentModule);
} 
catch (XN_Exception $e) 
{
	echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
	die;
}

echo '{"statusCode":"200","message":null,"tabid":"'.$currentModule.'","closeCurrent":true,"forward":null}';



?>







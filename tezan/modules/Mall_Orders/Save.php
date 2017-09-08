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



if(isset($_REQUEST['savetype']) && $_REQUEST['savetype'] == 'Invoice' && (!isset($_REQUEST['delivery']) || $_REQUEST['delivery'] == '')) {
	echo '{"status":300,"statusCode":300,"message":"物流公司不能为空！","tabid":"'.$currentModule.'","closeCurrent":true,"forward":null}';
	die();
}

if(isset($_REQUEST['savetype']) && $_REQUEST['savetype'] == 'Invoice' && (!isset($_REQUEST['invoicenumber']) || $_REQUEST['invoicenumber'] == '')) {
	echo '{"status":300,"statusCode":300,"message":"发货单号不能为空！","tabid":"'.$currentModule.'","closeCurrent":true,"forward":null}';
	die();
}
if(isset($_REQUEST['savetype']) && $_REQUEST['savetype'] == 'Invoice' && isset($_REQUEST['record']) && $_REQUEST['record'] != ''){
	global $currentModule;
	$focus = XN_Content::load($_REQUEST['record'],strtolower($currentModule),7);
	$profileid = $focus->my->profileid;
	$supplierid = $focus->my->supplierid;
	$focus->my->order_status = "已发货";
	$focus->my->deliverystatus = "sendout";
	$focus->my->delivery_status = "1";
	$focus->my->invoicenumber = $_REQUEST['invoicenumber'];
	$focus->my->delivery = $_REQUEST['delivery'];
	$focus->my->deliverytime = date('Y-m-d H:i:s');
    $tag = strtolower($currentModule).','.strtolower($currentModule).'_'.$profileid.','.strtolower($currentModule).'_'.$supplierid;
	try {
	    $focus->save($tag);
		
		$smsCon = '您的订单'.$focus->my->mall_orders_no.'已经发货,物流公司:'.getModuleByToBy("Logistics", $_REQUEST['delivery'], 'logisticsname').',发货单号:'.$_REQUEST['invoicenumber'].',预计12小时后,物流信息将会更新.';
		global  $supplierid; 
		$supplier_wxsettings = XN_Query::create ( 'MainContent' ) ->tag('supplier_wxsettings')
		    ->filter ( 'type', 'eic', 'supplier_wxsettings')
		    ->filter ( 'my.deleted', '=', '0' )
		    ->filter ( 'my.supplierid', '=' ,$supplierid)
			->end(1)
		    ->execute(); 
		if (count($supplier_wxsettings) > 0)
		{
		    $supplier_wxsetting_info = $supplier_wxsettings[0];
			$appid = $supplier_wxsetting_info->my->appid;
			require_once (XN_INCLUDE_PREFIX."/XN/Message.php");
	        XN_Message::sendmessage($profileid,$smsCon,$appid);   
		} 
		 
	} 
	catch (XN_Exception $e) 
	{
		echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
		die;
	}
}
echo '{"statusCode":"200","message":null,"tabid":"'.$currentModule.'","closeCurrent":true,"forward":null}';

//echo '{"statusCode":"200","message":null,"tabid":null,"callbackType":"forward","forward":"/index.php?module='.$currentModule.'&action=EditView&record='.$focus->id.'"}';

?>







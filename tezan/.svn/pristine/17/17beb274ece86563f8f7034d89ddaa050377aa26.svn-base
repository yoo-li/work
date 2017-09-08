<?php
/*+**********************************************************************************
 * The contents of this file are subject to the 361CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  361CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

global $mod_strings,$app_strings,$theme,$currentModule,$current_user;
global  $supplierid;
if (isset($_REQUEST['record']) && $_REQUEST['record'] != "" && 
    isset($_REQUEST['type']) && $_REQUEST['type'] == "submit" )
{
    try {
        $record = $_REQUEST['record']; 
        
		$loadcontent = XN_Content::load($record,strtolower($currentModule).'_'.$supplierid);

        $officialorder_info=XN_Content::load($record,"mall_officialorders");
        $supplierid=$officialorder_info->my->supplierid;
        $orderid=$officialorder_info->my->orderid;
        $profileid=$officialorder_info->my->profileid;
        $order_info = XN_Content::load($orderid,"mall_orders_".$profileid,7);
        $paymentamount=$order_info->my->paymentamount;
        $amount=$paymentamount*100;

        official_notify($order_info,round(floatval($amount)/100, 2));//与mall_orders订单相关的支付成功回调操作
        //与事务官相关的支付成功回调操作
        $supplier_profile = XN_Query::create('MainContent')->tag("supplier_profile_" . $profileid)
            ->filter('type', 'eic', 'supplier_profile')
            ->filter('my.deleted', '=', '0')
            ->filter('my.official', '=', '0')
            ->filter('my.profileid', '=', $profileid)
            ->end(1)
            ->execute();
        if (count($supplier_profile) > 0) {
            $supplier_profile_info = $supplier_profile[0];
            $official_supplierid = $supplier_profile_info->my->supplierid;
            $mall_officialenterprisecurrencysauthorizes = XN_Query::create('MainContent')->tag("mall_officialenterprisecurrencysauthorizes")
                ->filter('type', 'eic', 'mall_officialenterprisecurrencysauthorizes')
                ->filter('my.deleted', '=', '0')
                ->filter('my.status', '=', '0')
                ->filter('my.approvalstatus', '=', '2')
                ->filter('my.supplierid', '=', $official_supplierid)
                ->filter('my.profileid', '=', $profileid)
                ->end(1)
                ->execute();
            if (count($mall_officialenterprisecurrencysauthorizes) > 0)
            {
                $mall_officialenterprisecurrencysauthorize_info = $mall_officialenterprisecurrencysauthorizes[0];
                $authorizedenterprisecurrency = $mall_officialenterprisecurrencysauthorize_info->my->authorizedenterprisecurrency;
                $currentcumulativeamount = $mall_officialenterprisecurrencysauthorize_info->my->currentcumulativeamount;
                $enterprisecurrencyid = $mall_officialenterprisecurrencysauthorize_info->my->enterprisecurrencyid;

                $mall_officialenterprisecurrency_info = XN_Content::load($enterprisecurrencyid, 'mall_officialenterprisecurrencys');

                $enterprisecurrency = $mall_officialenterprisecurrency_info->my->enterprisecurrency;
                $exchangerate = $mall_officialenterprisecurrency_info->my->exchangerate;

                $cost = round(floatval($amount) / 100 / floatval($exchangerate), 2);

                $new_authorizedenterprisecurrency = floatval($authorizedenterprisecurrency) - floatval($cost);
                if($new_authorizedenterprisecurrency<0){
                    echo '{"statusCode":300,"message":"企业币余额不足!"}';
                    die();
                }
                $new_currentcumulativeamount = floatval($currentcumulativeamount) + floatval($cost);
                $mall_officialenterprisecurrencysauthorize_info->my->authorizedenterprisecurrency = $new_authorizedenterprisecurrency;
                $mall_officialenterprisecurrencysauthorize_info->my->currentcumulativeamount = $new_currentcumulativeamount;
                $mall_officialenterprisecurrencysauthorize_info->save('mall_officialenterprisecurrencysauthorizes,mall_officialenterprisecurrencysauthorizes_' . $profileid . ',mall_officialenterprisecurrencysauthorizes_' . $official_supplierid);

                //企业币日志
                $newcontent = XN_Content::create('mall_officialenterprisecurrencylogs', '', false, 8);
                $newcontent->my->deleted = '0';
                $newcontent->my->profileid = $profileid;
                $newcontent->my->supplierid = $official_supplierid;
                $newcontent->my->operator = $profileid;
                $newcontent->my->enterprisecurrencyid = $enterprisecurrencyid;
                $newcontent->my->enterprisecurrencytype = 'consumption';
                $newcontent->my->orderid = $order_info->id;
                $newcontent->my->money = number_format($new_authorizedenterprisecurrency, 2, ".", "");
                $newcontent->my->amount = number_format($cost, 2, ".", "");
                $newcontent->my->submitdatetime = date('Y-m-d H:i:s');
                $newcontent->save('mall_officialenterprisecurrencylogs,mall_officialenterprisecurrencylogs_' . $profileid . ',mall_officialenterprisecurrencylogs_' . $official_supplierid);
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

if(isset($_REQUEST['record']) && $_REQUEST['record'] !='') 
{
    $record=$_REQUEST['record']; 
	$msg = "当前状态：未提交";
    $msg = '<div style="width:99%;height:136px"><textarea readonly rows="8" style="width:100%;height:125px"    class="detailedViewTextBox">'.$msg.'</textarea></div>';
	$msg .= '<div style="width:100%"><font color="red" size="2">'.getTranslatedString('LBL_APPROVALS_SURE_BUTTON_LABEL').'后，您将没有权限再进行修改，是否确定提交?</font></div>'; 
	$smarty->assign("MSG", $msg);
	$smarty->assign("SUBMODULE", $currentModule);
	$smarty->assign("SUBACTION", 'SimulateApply'); 
	$smarty->assign("OKBUTTON", getTranslatedString('LBL_APPROVALS_SURE_BUTTON_LABEL'));
    $smarty->assign("CANCELBUTTON", getTranslatedString('LBL_CANCEL_BUTTON_LABEL'));
    $smarty->assign("RECORD", $record);
}

$smarty->display('MessageBox.tpl');


?>
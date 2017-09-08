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

global  $supplierid,$businesseid,$localusertype;

if (isset($_REQUEST['record']) && $_REQUEST['record'] != "" && 
	isset($_REQUEST['logisticpackageid']) && $_REQUEST['logisticpackageid'] != "" && 
    isset($_REQUEST['type']) && $_REQUEST['type'] == "submit" )
{
    try {
        $record = $_REQUEST['record'];
		$orderid = $record;
		$logisticpackageid = $_REQUEST['logisticpackageid'];   
		
		$mall_settings = XN_Query::create ( 'Content' )->tag("mall_settings")
		            ->filter("type","=","mall_settings") 
		            ->filter("my.deleted",'=','0')
		            ->filter("my.supplierid",'=',$supplierid)
		            ->end(1)
		            ->execute();
		if (count($mall_settings) > 0)
		{
			$mall_setting_info = $mall_settings[0];
			$mylogistic = $mall_setting_info->my->mylogistic; //自有物流 
			$mylogisticname = $mall_setting_info->my->mylogisticname; // 自有物流名称
			if ($mylogistic == '1')
			{ 
		        $logistics = XN_Query::create("Content")->tag("logistics")
		            ->filter("type","eic",'logistics')
		            ->filter("my.deleted","=","0")
		            ->filter("my.logisticsname","=",$mylogisticname)
		            ->end(1)
		            ->execute();
				if (count($logistics) > 0)
				{
					$logistic_info = $logistics[0];
				}
				else
				{
		            $logistic_info = XN_Content::create('logistics','',false);
		            $logistic_info->my->description='';
					$logistic_info->my->logisticsname=$mylogisticname;
					$logistic_info->my->sequence='1';
		            $logistic_info->my->site='';
		            $logistic_info->my->telphone='';
					$logistic_info->my->deleted='0';
		            $logistic_info->my->status='Inactive';
		            $logistic_info->my->template_data='';
		            $logistic_info->save('logistics');
				}
				
				$delivery = $logistic_info->id;
				
				$prev_inv_no = XN_ModentityNum::get("Mall_LogisticBills");
			   
			    $order_info = XN_Content::load($record,'mall_orders',7);
				
				$invoicenumber = str_replace("WL","",$prev_inv_no);
			   
			    $logisticbill_info = XN_Content::create('mall_logisticbills','',false,7);
	            $logisticbill_info->my->deleted = '0';
				$logisticbill_info->my->supplierid = $supplierid;
				$logisticbill_info->my->mall_logisticbills_no = $prev_inv_no;
				$logisticbill_info->my->logisticbills_no = $invoicenumber;
				$logisticbill_info->my->orderid = $record;
	            $logisticbill_info->my->lastmodifydatetime = date("Y-m-d H:i");
				$logisticbill_info->my->consignee = $order_info->my->consignee;
				$logisticbill_info->my->mobile = $order_info->my->mobile;
				$logisticbill_info->my->zipcode = $order_info->my->zipcode;
				$logisticbill_info->my->province = $order_info->my->province;
				$logisticbill_info->my->city = $order_info->my->city;
				$logisticbill_info->my->district = $order_info->my->district;
				$logisticbill_info->my->address = $order_info->my->address; 
	            $logisticbill_info->my->mall_logisticbillsstatus = 'JustCreated';  
				$logisticbill_info->my->vendorid = '';  
				$logisticbill_info->my->logisticpackageid = $logisticpackageid;
	            $logisticbill_info->save('mall_logisticbills,mall_logisticbills_'.$supplierid);
				
			    $logisticroute_info = XN_Content::create('mall_logisticroutes','',false,7);
	            $logisticroute_info->my->deleted = '0';
				$logisticroute_info->my->supplierid = $supplierid;  
				$logisticroute_info->my->logisticbillid = $logisticbill_info->id; 
				$logisticroute_info->my->route = "您的订单开始处理。";
	            $logisticroute_info->save('mall_logisticroutes,mall_logisticroutes_'.$supplierid);
				
				$mall_settlementorders = XN_Query::create ( 'YearContent' ) ->tag('mall_settlementorders')
				    ->filter ( 'type', 'eic', 'mall_settlementorders')
				    ->filter ( 'my.deleted', '=', '0' )
				    ->filter ( 'my.orderid', '=' ,$orderid) 
					->end(-1)
				    ->execute(); 
				foreach($mall_settlementorders as $mall_settlementorder_info)
				{ 
						$mall_settlementorder_info->my->deliverystatus = "1"; 
						$mall_settlementorder_info->my->invoicenumber = $invoicenumber;
						$mall_settlementorder_info->my->delivery = $delivery;
						$mall_settlementorder_info->my->deliverytime = date('Y-m-d H:i:s'); 
						$mall_settlementorder_info->my->mall_settlementordersstatus = '已发货';
						$mall_settlementorder_info->save("mall_settlementorders,mall_settlementorders_".$supplierid);
	 			}
				$calendars = XN_Query::create ( 'Content' ) ->tag('calendar')
				    ->filter ( 'type', 'eic', 'calendar')
				    ->filter ( 'my.deleted', '=', '0' )  
				    ->filter ( 'my.record', '=' ,$orderid) 
					->end(-1)
				    ->execute(); 
				foreach($calendars as $calendar_info)
				{  
					if ($calendar_info->my->calendarstatus != 'Has been executed')
					{
						$calendar_info->my->calendarstatus = 'Has been executed';
						$calendar_info->save("calendar,calendar_".$supplierid);
					 
						$newcontent = XN_Content::create('memo','',false);					  
						$newcontent->my->deleted = '0';
						$newcontent->my->memo =  date("Y-m-d H:i").' 将状态转换为已执行！';	
						$newcontent->my->record =  $calendar_info->id;	
						$newcontent->my->module =  'Calendar';	
						$newcontent->save('memo'); 
					} 
	 			}
				
				$loadcontent = XN_Content::load($record,strtolower($currentModule),7);
				$profileid = $loadcontent->my->profileid;
				$supplierid = $loadcontent->my->supplierid;
				$loadcontent->my->order_status = "已发货";
				$loadcontent->my->deliverystatus = "sendout";
				$loadcontent->my->delivery_status = "1";
				$loadcontent->my->invoicenumber = $invoicenumber;
				$loadcontent->my->delivery = $delivery;
				$loadcontent->my->deliverytime = date('Y-m-d H:i:s');
			    $tag = strtolower($currentModule).','.strtolower($currentModule).'_'.$profileid.','.strtolower($currentModule).'_'.$supplierid;
				try {
				    $loadcontent->save($tag);
		
					$smsCon = '您的订单'.$loadcontent->my->mall_orders_no.'已经发货,物流公司:'.$mylogisticname.',发货单号:'.$invoicenumber.',预计12小时后,物流信息将会更新.';
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
		}
		else
		{
			echo '{"statusCode":"300","message":"没有启用自有物流配置。"}';
			die;
		}
		
 
		
		echo '{"statusCode":200,"message":null,"tabid":"edit","closeCurrent":"true","forward":null}';
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
 
    $mall_logisticpackages = XN_Query::create ( 'Content' )->tag('mall_logisticpackages_'.$supplierid)
	    ->filter ( 'type', 'eic', 'mall_logisticpackages') 
	    ->filter('my.deleted','=','0')
		->filter('my.status','=','0')  
	    ->end(-1)
	    ->execute(); 
    $logisticpackageoption = "";
    foreach ($mall_logisticpackages as $logisticpackage_info)
	{ 
		$logisticpackageoption .= '<option value='.$logisticpackage_info->id.'>'.$logisticpackage_info->my->serialname.'</option>';
    }
	 
	$msg = '<div class="form-group">
                <label class="control-label x120">路线选择:</label>
				<select name="logisticpackageid" class="required" style="cursor: pointer;width:135px;">'.$logisticpackageoption.'</select>
		    </div>'; 
	$msg .= '<div style="width:100%;text-align:center;"><font color="red" size="2"><br><br>系统将自动生成发货单号，并进行发货操作，您是否确定发货?</font></div>'; 
	$smarty->assign("MSG", $msg);
	$smarty->assign("SUBMODULE", $currentModule);
	$smarty->assign("SUBACTION", 'MyInvoice'); 
	$smarty->assign("OKBUTTON", '确定发货');
    $smarty->assign("CANCELBUTTON", getTranslatedString('LBL_CANCEL_BUTTON_LABEL'));
    $smarty->assign("RECORD", $record);
}

$smarty->display('MessageBox.tpl');


?>
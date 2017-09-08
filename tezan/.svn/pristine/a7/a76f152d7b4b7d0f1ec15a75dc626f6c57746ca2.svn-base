<?php
require_once('Smarty_setup.php');
require_once('include/utils/utils.php');


global  $currentModule,$supplierid;

if (isset($_REQUEST['record']) && $_REQUEST['record'] != "" &&
    isset($_REQUEST['type']) && $_REQUEST['type'] == "submit" )
{
    try {
        $binds = $_REQUEST['record']; 
		$transferfailurereason = $_REQUEST['transferfailurereason']; 

        $binds = str_replace(";",",",$binds);
        $binds = explode(",",trim($binds,','));
        array_unique($binds);
		if (count($binds) > 0)
		{
			$loadcontents = XN_Content::loadMany($binds,"supplier_takecashs_".$supplierid,7);
	        foreach($loadcontents as $supplier_takecashs_info)
	        {  
				$profileid = $supplier_takecashs_info->my->profileid; 
				$amount = $supplier_takecashs_info->my->amount; 
				require_once (dirname(__FILE__) . "/../Supplier_Profile/util.php"); 
				$profile_info = get_supplier_profile_info($profileid,$supplierid);
				
				if (count($profile_info) == 0)
				{
					echo '{"statusCode":"300","message":"无法获得用户信息，驳回失败！"}';
					die();
				}
	            $supplier_takecashs_info->my->executedatetime = date("Y-m-d H:i"); 
	            $supplier_takecashs_info->my->execute = XN_Profile::$VIEWER;
				$supplier_takecashs_info->my->transferfailurereason = $transferfailurereason;
				$supplier_takecashs_info->my->tradestatus = 'notrade';
				$supplier_takecashs_info->my->supplier_takecashsstatus = '转账失败';
				$supplier_takecashs_info->save("supplier_takecashs,supplier_takecashs_".$supplierid.",supplier_takecashs_".$profileid);
				
			 
				
				$money = $profile_info['money'];  
				$maxtakecash = $profile_info['maxtakecash'];
				$new_money = $money + floatval($amount);  
				$profile_info['money'] = $new_money;  
				$new_maxtakecash = $maxtakecash + floatval($amount); 
				$profile_info['money'] = $new_money;  
				$profile_info['maxtakecash'] = $new_maxtakecash;
				update_supplier_profile_info($profile_info);  
		
				$newcontent = XN_Content::create('mall_billwaters','',false,7);					  
				$newcontent->my->deleted = '0';  
				$newcontent->my->supplierid = $supplierid;  
				$newcontent->my->profileid = $profileid; 
				$newcontent->my->billwatertype = 'transferfailure';
				$newcontent->my->sharedate = '-';  
				$newcontent->my->orderid = '';
				$newcontent->my->amount = '+'.number_format($amount,2,".",""); 
				$newcontent->my->money = number_format($new_money,2,".","");
				$newcontent->save('mall_billwaters,mall_billwaters_'.$profileid.',mall_billwaters_'.$supplierid); 
				
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
					$message = '您好,您提交的提现，转账失败，请前往【提现申请】-【历史提现记录】界面查看原因，再重新提交！';
					XN_Message::sendmessage($profileid,$message,$appid);  
				} 
				XN_MemCache::delete("mall_badges_".$businesseid."_".$profileid);  
	        }  
		} 
        echo '{"statusCode":"200","message":null,"tabid":"'.$currentModule.'","closeCurrent":true,"forward":null}';
    } catch ( XN_Exception $e )
    {
        echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
    }
    die();
}
else{ 
	
    $binds = $_REQUEST['ids']; 
    $binds = str_replace(";",",",$binds);
    $binds = explode(",",trim($binds,','));
    array_unique($binds);
	if (count($binds) > 1)
	{
		$smarty = new vtigerCRM_Smarty;
		global $mod_strings;
		global $app_strings;
		global $app_list_strings;
		$smarty->assign("APP", $app_strings);
		$smarty->assign("CMOD", $mod_strings); 
	    $msg = '<div style="width:100%;text-align:center;"><br><br><font color="red" size="2">您只能选择单条记录进行驳回操作！</font></div>';  
		$smarty->assign("MSG", $msg);  
		$smarty->display("MessageBox.tpl");
		die();
	}
	else
	{
        $record = $_REQUEST['ids']; 
		$loadcontent =  XN_Content::load($record,"supplier_takecashs_".$supplierid,7);   
		//$tradestatus = $loadcontent->my->tradestatus;
		$takecashsstatus = $loadcontent->my->supplier_takecashsstatus;
		if (isset($takecashsstatus) && $takecashsstatus != "处理中")
		{
			$smarty = new vtigerCRM_Smarty;
			global $mod_strings;
			global $app_strings;
			global $app_list_strings;
			$smarty->assign("APP", $app_strings);
			$smarty->assign("CMOD", $mod_strings); 
		    $msg = '<div style="width:100%;text-align:center;"><br><br><font color="red" size="2">只能对“处理中”的申请进行驳回操作!</font></div>';  
			$smarty->assign("MSG", $msg);  
			$smarty->display("MessageBox.tpl");
			die();
		} 
	}
	
	$msg =  '<div class="form-group">
	                 <label class="control-label x120">转账失败原因:</label>
					 <textarea data-rule="required" style="width:200px;height:50px;" name="transferfailurereason" class="required"/></textarea> 
			 </div> ';
}

$smarty = new vtigerCRM_Smarty;
global $mod_strings;
global $app_strings;
global $app_list_strings;
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->assign("MSG", $msg);
$smarty->assign("OKBUTTON", "确定提交");
$smarty->assign("RECORD",$_REQUEST['ids']);
$smarty->assign("SUBMODULE", "Supplier_TakeCashs");
$smarty->assign("SUBACTION", "TransferFailure");

$smarty->display("MessageBox.tpl");

?>
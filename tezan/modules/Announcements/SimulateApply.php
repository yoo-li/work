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

if (isset($_REQUEST['record']) && $_REQUEST['record'] != "" &&
    isset($_REQUEST['type']) && $_REQUEST['type'] == "submit" )
{
    try {
        $record = $_REQUEST['record'];

        $loadcontent = XN_Content::load($record,strtolower($currentModule)); 
		$supplierid = $loadcontent->my->supplierid;
        $loadcontent->my->approvalstatus = '2';
        $status = strtolower($currentModule).'status';
        $loadcontent->my->$status = 'Release';
		$loadcontent->my->releasedate  = date("Y-m-d H:i:s");
        $loadcontent->my->finishapprover = XN_Profile::$VIEWER;
        $loadcontent->my->submitapprovalreplydatetime = date("Y-m-d H:i");
        $loadcontent->my->supplierid = $supplierid; 
        $loadcontent->save("announcements,announcements_".$supplierid); 
		
		
	   	$supplier_modules = XN_Query::create("Content")->tag("supplier_modules_".$supplierid)
	   						   ->filter("type", "eic", "supplier_modules")
	   						   ->filter("my.deleted", "=", "0")
							   ->filter("my.status", "=", "0")
							   ->filter("my.modulename", "=", "公告")
	   						   ->filter("my.supplierid", "=", $supplierid) 
	   						   ->end(-1)
	   						   ->execute();
	   	if (count($supplier_modules) > 0)
		{
				$supplier_module_info = $supplier_modules[0];
			    $tabid = $supplier_module_info->id;
		   	    $supplier_users = XN_Query::create("Content")->tag("supplier_users_".$supplierid)
		   						   ->filter("type", "eic", "supplier_users")
		   						   ->filter("my.deleted", "=", "0")
								   ->filter ( 'my.approvalstatus', '=', '2')
		   						   ->filter("my.supplierid", "=", $supplierid) 
		   						   ->end(-1)
		   						   ->execute();
		    
				foreach($supplier_users as $modules_user_info)
				{
					$profileid = $modules_user_info->my->profileid;
				   	$modules_users = XN_Query::create("Content")->tag("supplier_modules_users_".$profileid)
				   						   ->filter("type", "eic", "supplier_modules_users")
				   						   ->filter("my.deleted", "=", "0")
				   						   ->filter("my.supplierid", "=", $supplierid)
				   						   ->filter("my.profileid", "=", $profileid)
				   						   ->filter("my.record", "=", $tabid)
				   						   ->end(-1)
				   						   ->execute();
				   	if (count($modules_users) > 0)
				   	{
				   		$modules_user_info = $modules_users[0];
				   		$untreated = $modules_user_info->my->untreated; 
				   		$modules_user_info->my->untreated = intval($untreated) + 1;
				   		$modules_user_info->save("supplier_modules_users,supplier_modules_users_".$supplierid.",supplier_modules_users_".$profileid);
						
				   	}
				   	else
				   	{
				   		$newcontent = XN_Content::create("supplier_modules_users", "", false);
				   		$newcontent->my->untreated   = '1';
				   		$newcontent->my->processed   = '0';
				   		$newcontent->my->lasttime   =  date("Y-m-d H:i"); 
				   		$newcontent->my->record  = $tabid;
				   		$newcontent->my->profileid  = $profileid;
				   		$newcontent->my->supplierid   = $supplierid;
				   		$newcontent->my->deleted      = "0";
				   		$newcontent->save("supplier_modules_users,supplier_modules_users_".$supplierid.",supplier_modules_users_".$profileid);
				   	}
				} 
		}
		 
	   	
		 

        echo '{"status":"1","statusCode":200,"message":null,"tabid":"edit","closeCurrent":true,"forward":null}';
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
    $msg = "当前状态：未发布";
    $msg = '<div style="width:99%;height:136px"><textarea readonly rows="8"  style="width:100%;height:125px"    class="detailedViewTextBox">'.$msg.'</textarea></div>';
    $msg .= '<div style="width:100%"><font color="red" size="2">发布后，您将没有权限再进行修改，是否确定发布?</font></div>';
    $smarty->assign("MSG", $msg);
    $smarty->assign("SUBMODULE", $currentModule);
    $smarty->assign("SUBACTION", 'SimulateApply');
    $smarty->assign("OKBUTTON", '确定发布');
    $smarty->assign("CANCELBUTTON", getTranslatedString('LBL_CANCEL_BUTTON_LABEL'));
    $smarty->assign("RECORD", $record);
}

$smarty->display('MessageBox.tpl');


?>
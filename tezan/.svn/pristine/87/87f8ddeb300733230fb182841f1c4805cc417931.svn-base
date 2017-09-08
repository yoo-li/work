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

if (isset($_REQUEST['record']) && $_REQUEST['record'] != "" && 
    isset($_REQUEST['type']) && $_REQUEST['type'] == "submit" )
{
    try {
        $record = $_REQUEST['record']; 
        
		$loadcontent = XN_Content::load($record,strtolower($currentModule)); 
		$loadcontent->my->approvalstatus = '0';
		$status = strtolower($currentModule).'status';
		$loadcontent->my->$status = 'Saved';   
		 
		$loadcontent->save(strtolower($currentModule).','.strtolower($currentModule).'_'.$supplierid);

		 
		

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
	$msg = "当前状态：审批同意";
    $msg .= '<div style="width:100%;text-align:center;"><br><br><font color="red" size="2">您正在提交”重新修改权限“，系统将再次开放修改权限，是否确定提交?</font></div>';  
 	$smarty->assign("MSG", $msg);
	$smarty->assign("SUBMODULE", $currentModule);
	$smarty->assign("SUBACTION", 'UnSimulateApply'); 
	$smarty->assign("OKBUTTON", getTranslatedString('LBL_APPROVALS_SURE_BUTTON_LABEL'));
    $smarty->assign("CANCELBUTTON", getTranslatedString('LBL_CANCEL_BUTTON_LABEL'));
    $smarty->assign("RECORD", $record);
}

$smarty->display('MessageBox.tpl');


?>
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
		
	    $image = $loadcontent->my->image;  
		if (!isset($image) || $image == "")
		{
			echo '{"statusCode":"300","message":"广告推广图不能为空！"}';
			die(); 
		}
		
		$loadcontent->my->approvalstatus = '2';
		$status = strtolower($currentModule).'status';
		$loadcontent->my->$status = 'Agree'; 
		$loadcontent->my->finishapprover = XN_Profile::$VIEWER;
		$loadcontent->my->submitapprovalreplydatetime = date("Y-m-d H:i");  
		
		 
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
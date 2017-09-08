<?php
/*+********************************************************************************
 * The contents of this file are subject to the 361CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  361CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ********************************************************************************/
require_once('Smarty_setup.php');
require_once('include/utils/utils.php');

global  $currentModule;
$smarty = new vtigerCRM_Smarty;

if(isset($_REQUEST['record']) && $_REQUEST['record'] != '' && $_REQUEST['type']=='dialog')
{	
	$record= $_REQUEST['record'];

	$msg =  '<div class="form-group">
                <label class="control-label x120">'.getTranslatedString('ERR_ENTER_NEW_PASSWORD').':</label>
				<input id="newpassword" type="password" name="newpassword" class="required alphanumeric" minlength="6" maxlength="20" alt="字母、数字、下划线 6-20位"/>					
            </div>
		 <div class="form-group">
                <label class="control-label x120">'.getTranslatedString('ERR_ENTER_CONFIRMATION_PASSWORD').':</label>
				<input type="password" name="confirpassword" class="required" equalto="#newpassword"/>
            </div>';		
	$smarty->assign("RECORD", $record);
}
else if(isset($_REQUEST['record']) && $_REQUEST['record'] != ''&& $_REQUEST['type'] == 'submit')
{
    try
    {
        $supplier_user=XN_Content::load($record,strtolower($currentModule));
        $profileid=$supplier_user->my->profileid;
        XN_Application::$CURRENT_URL = "admin";

        $profile = XN_Profile::load($profileid,"id");
        $profile->password = $_REQUEST['newpassword'];
        $profile->save();
    }
    catch(XN_Exception $e)
    {}
    echo '{"statusCode":"200","message":null,"tabid":"edit","closeCurrent":true,"forward":null}';
    die();
}





$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->assign("MSG", $msg);
$smarty->assign("SUBMODULE", "Supplier_Users");
$smarty->assign("OKBUTTON", "保存");
$smarty->assign("SUBACTION", "ChangePassword");

$smarty->display("Settings/changepwd.tpl");


?>
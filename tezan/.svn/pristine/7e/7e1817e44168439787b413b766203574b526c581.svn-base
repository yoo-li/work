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

require_once('Smarty_setup.php');
require_once('include/utils/utils.php');

$smarty = new vtigerCRM_Smarty;

$smarty->assign("MODULE",$currentModule);
$smarty->assign("APP",$app_strings);
$smarty->assign("MOD", $mod_strings);

if(isset($_REQUEST['record']) && $_REQUEST['record'] !='' && isset($_REQUEST['formodule']) && $_REQUEST['formodule'] !='') 
{
    $record=$_REQUEST['record'];
    $formodule=$_REQUEST['formodule'];
    $tabid = getTabid($formodule);
    $mode=$_REQUEST['mode'];
    $msg=approvalprocess($record,$formodule,$tabid,$mode,$smarty);
	if(isset($_REQUEST['from']) && $_REQUEST['from'] !='')
	{
		$msg .= '<input type="hidden" value="' . $_REQUEST['from'] . '" name="from">';
	}
    $smarty->assign("MSG", $msg);
    $smarty->assign("CANCELBUTTON", getTranslatedString('LBL_CANCEL_BUTTON_LABEL'));
    $smarty->assign("RECORD", $record);
}

$smarty->display('MessageBox.tpl');


?>
<?php

/*********************************************************************************
** The contents of this file are subject to the 361CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  361CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
*
 ********************************************************************************/
global $mod_strings,$app_strings,$theme,$currentModule,$current_user,$action;

require_once('Smarty_setup.php');
require_once('include/utils/utils.php');

$profileId = $_REQUEST['record'];
$userName = getUserName($profileId);
$smarty = new vtigerCRM_Smarty;
$smarty->assign("APP",$app_strings);
$smarty->assign("MOD", $mod_strings);
$smarty->assign('PROFILEID', $profileId);
$userlist = getUserList();
$smarty->assign('USERNAME', $userName);
$smarty->assign('USERLIST', $userlist);
$smarty->display('Settings/DeleteUserStep2.tpl');

?>

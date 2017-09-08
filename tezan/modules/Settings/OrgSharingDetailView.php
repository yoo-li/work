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
require_once('include/utils/utils.php');
require_once('include/utils/UserInfoUtil.php');
global $mod_strings;
global $app_strings;
global $app_list_strings;

global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";

$smarty = new vtigerCRM_Smarty;

$defSharingPermissionData = getDefaultSharingAction();
$access_privileges = array();
$row=1;
foreach($defSharingPermissionData as $tab_id => $def_perr)
{

	$entity_name = getTabname($tab_id);
	if($tab_id == 6)
    {
    	$cont_name = getTabname(4);
        $entity_name .= ' & '.$cont_name;
    }

	$entity_perr = getDefOrgShareActionName($def_perr);

	$access_privileges[] = $entity_name;
	$access_privileges[] = $entity_perr;
	if($entity_perr != 'Private')	
		$access_privileges[] = $mod_strings['LBL_USR_CAN_ACCESS'] .str_replace('Public:','',$mod_strings[$entity_perr]). $mod_strings['LBL_USR_OTHERS'] . $app_strings[$entity_name];
	else
	        $access_privileges[] = $mod_strings['LBL_USR_CANNOT_ACCESS'] . $app_strings[$entity_name];
	$row++;
}
$access_privileges=array_chunk($access_privileges,3);
$smarty->assign("DEFAULT_SHARING", $access_privileges);

$custom_access = array();
 
$smarty->assign("MODSHARING", $custom_access);

/** returns the list of sharing rules for the specified module
  * @param $module -- Module Name:: Type varchar
  * @returns $access_permission -- sharing rules list info array:: Type array
  *
 */
 
$smarty->assign("THEME", $theme);
$smarty->assign("IMAGE_PATH",$image_path);
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->assign("MOD", return_module_language($current_language,'Settings'));

$smarty->display("OrgSharingDetailView.tpl");
?>

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
global $mod_strings;
global $app_strings;
global $app_list_strings;

global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";

$smarty = new vtigerCRM_Smarty; 
$defSharingPermissionData = getDefaultSharingEditAction();

$row=1;
$entries = Array();

$Config_org_share_action_mapping = array (
0 => array ('share_action_id' => '0','share_action_name' => 'Public: Read Only',),
1 => array ('share_action_id' => '1','share_action_name' => 'Public: Read, Create/Edit',),
2 => array ('share_action_id' => '2','share_action_name' => 'Public: Read, Create/Edit, Delete',),
3 => array ('share_action_id' => '3','share_action_name' => 'Private',),
/*4 => array ('share_action_id' => '4','share_action_name' => 'Hide Details',),
5 => array ('share_action_id' => '5','share_action_name' => 'Hide Details and Add Events',),
6 => array ('share_action_id' => '6','share_action_name' => 'Show Details',),
7 => array ('share_action_id' => '7','share_action_name' => 'Show Details and Add Events',),*/
);


foreach($defSharingPermissionData as $tab_id => $def_perr_info)
{
	    $def_perr = $def_perr_info['permission'];
	    $action_mapping = array();
		$entity_name = getTabname($tab_id);
		if($tab_id == 6)
		{
			$cont_name = getTabname(4);
			$entity_name .= ' & '.$cont_name;
		}
		$defActionArr=array();

		foreach ( $Config_org_share_action_mapping as $org_share_action_mapping ) 
		{
			$defActionArr [$org_share_action_mapping ['share_action_id']] = $org_share_action_mapping ['share_action_name'];
		}

		$entries[] = $entity_name;
		
		if($tab_id != 6)
		{
			$output = '<select class="detailedViewTextBox" id="'.$tab_id.'_perm_combo" name="'.$tab_id.'_per">';
		}
		else
		{
			$output = '<select class="detailedViewTextBox" id="'.$tab_id.'_perm_combo" name="'.$tab_id.'_per" onchange="checkAccessPermission(this.value)">';
		}
		$entries[] = $tab_id;
		
		foreach($defActionArr as $shareActId=>$shareActName)
		{
			$selected='';
			if($shareActId == $def_perr)
			{
				$selected='selected';
			}
			$output .= '<option value="'.$shareActId.'" '.$selected. '>'.$mod_strings[$shareActName].'</option>';
				
		}


		$output .= '</select>';
		$entries[] = $output;
		$row++;
}

$list_entries=array_chunk($entries,3);
$smarty->assign("ORGINFO",$list_entries);
$smarty->assign("MOD", return_module_language($current_language,'Settings'));
$smarty->assign("THEME", $theme);
$smarty->assign("IMAGE_PATH",$image_path);
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);

$smarty->display("OrgSharingEditView.tpl");
?>

<?php
/*+*******************************************************************************
 * The contents of this file are subject to the 361CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  361CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ********************************************************************************/

require_once('include/utils/UserInfoUtil.php');
require_once('Smarty_setup.php');
$smarty = new vtigerCRM_Smarty;

global $mod_strings;
global $app_strings;
global $app_list_strings;
global $adb;
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";


$roleout ='';

$profiles = XN_Query::create ( 'Content' )
		->tag ( 'profiles' )
		->filter ( 'type', 'eic', 'profiles' )
		->filter ( 'my.deleted', '=', '0' )
		->filter ( 'my.profilename', '!=', 'Boss' )
		->order ( 'published', XN_Order::ASC )
		->execute ();
$roleout = '';		
if (count ( $profiles ) > 0) 
{
	foreach ( $profiles as $profile_info ) 
	{
		$roleid = $profile_info->my->roleid;
		$parent = $profile_info->my->parentrole;
		$roleout .='<li><img align="absmiddle" border="0"  src="themes/images/vtigerDevDocs.gif">&nbsp;<a class="x" href="javascript:loadProfilesValue(\''.$profile_info->my->profilename.'\',\''.$profile_info->id.'\');">'.$profile_info->my->profilename.'</a></li>';
	}
}

$smarty->assign("THEME",$theme_path);
$smarty->assign("THEME", $theme);
$smarty->assign("IMAGE_PATH",$image_path);
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->assign("ROLETREE", '<ul id="H5" class="uil" style="display:block;list-style-type:none;">'.$roleout.'</ul>');
$smarty->display("RolePopup.tpl");
?>
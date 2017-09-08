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

require_once('include/utils/UserInfoUtil.php');
require_once('Smarty_setup.php');
global $mod_strings;
global $app_strings;
global $app_list_strings;

global $currentModule;


$smarty = new vtigerCRM_Smarty;


$backups = XN_Backup::loadMany();


$noofrows = count($backups);

$smarty->assign('NOOFROWS',$noofrows);


$list_entries = array();

$list_entries['backup_restore_name'] = array('label' => $mod_strings['LBL_BACKUP_RESTORE_NAME'],'sort'=> false,'width' => 30,'align' => "left" );
$list_entries['backup_restore_date'] = array('label' => $mod_strings['LBL_BACKUP_RESTORE_DATE'],'sort'=> false,'width' => 30,'align' => "left" );
$list_entries['type'] = array('label' => $mod_strings['LBL_BACKUP_TYPE'],'sort'=> false,'width' => 20,'align' => "center" );
//$list_entries['restore'] = array('label' => $mod_strings['LBL_BACKUP_RESTORE_RESTORE'],'sort'=> false,'width' => 10,'align' => "center" );
$list_entries['download'] = array('label' => $mod_strings['LBL_BACKUP_RESTORE_DOWNLOAD'],'sort'=> false,'width' => 10,'align' => "center" );

$smarty->assign("LISTHEADER",$list_entries);

//Array ( [68109] => Array ( [0] => YF1 [1] => boss [2] => CEO [3] => Boss [4] => boss [5] => 15974160318 [6] => oldhand18@gmail.com [7] => boss [8] => 2013-05-18 [9] => 1 [10] => 启用 [worknotices] => )


/** gives the profile list info array 
  * @param $profileListResult -- profile list database result:: Type array
  * @param $noofrows -- no of rows in the $profileListResult:: Type integer 
  * @param $mod_strings -- i18n mod_strings array:: Type array 
  * @returns $return_date -- profile list info array:: Type array
  *
 */
function getStdOutput($backups, $noofrows, $mod_strings)
{
	global $adb;
	$return_data = array();		
	global $current_user;
    $current_profile = fetchUserProfileId($current_user->id);
    if (!isset($current_profile)) $current_profile = array();
	for($i=0; $i<$noofrows; $i++)
	{
		$standCustFld = array();
		$profile_name = $backups[$i]->id;
		$profile_id = $backups[$i]->id;
		$published = $backups[$i]->published;
		$standCustFld[]= $profile_name;
		$standCustFld[]= $published;
		switch($backups[$i]->style)
		{
			case "Auto":
				$standCustFld[]="系统自动";
			break;
			case "User":
				$standCustFld[]="用户创建";
			break;
			default:
				$standCustFld[]="";
			break;
		}
		//$standCustFld[]= '<a href="index.php?module=Settings&action=RestoreBackup&record='.$profile_id.'" data-toggle="doajax" data-callback="refresh" data-confirm-msg="还原需谨慎，确定需要还原吗?"><i class="fa fa-upload"></i></a>';
		$standCustFld[]= '<a href="index.php?module=Settings&action=DownBackup&record='.$profile_id.'" ><i class="fa fa-download"></i></a>';
		$return_data[$profile_id]=$standCustFld;
	}
	return $return_data;
}


$smarty->assign("LISTENTITY",getStdOutput($backups, $noofrows, $mod_strings));
$smarty->assign("MOD", return_module_language($current_language,'Settings'));

$listview_check_button = array();


$listview_check_button[] = '<a class="btn btn-default" data-icon="copy" data-toggle="doajax" data-loadingmask="true" data-callback="refresh" href="index.php?module=Settings&amp;action=CreateBackup"  >新建备份</a>';
$listview_check_button[] = '<a class="btn btn-red" data-icon="trash-o" data-group="ids" data-toggle="doajaxchecked" data-callback="refresh" href="index.php?module=Settings&amp;action=DeleteBackup" data-confirm-msg="确定要删除这些备份吗?" >删除备份</a>';


$smarty->assign("LISTVIEW_CHECK_BUTTON", $listview_check_button);

$smarty->assign("MODULE", $currentModule);
$smarty->assign("ACTION", "ListBackup");
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->assign("CHECKBOX", "enabled");
$smarty->display("List.tpl");
?>

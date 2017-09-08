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
require_once('modules/Settings/AuditTrail.php');
require_once('modules/Users/Users.php');

require_once('include/utils/utils.php');

global $app_strings;
global $mod_strings;
global $app_list_strings;
global $current_language, $current_user, $adb;
$current_module_strings = return_module_language($current_language, 'Settings');

global $list_max_entries_per_page;
global $urlPrefix;

 

global $currentModule;

global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";

$focus = new AuditTrail();

$smarty = new vtigerCRM_Smarty;

$category = getParenttab();

$userid = $_REQUEST['userid'];
 

$loginhistory_query = XN_Query::create ( 'BigContent' )->tag ( "Audit_trials" )
			->filter ( 'type', 'eic', 'audit_trials' )
			->filter ( 'my.userid', '=', $userid )
			->alwaysReturnTotalCount(true);	

$loginhistory_query->execute ();

$no_of_rows = $loginhistory_query->getTotalCount ();

//Retreiving the start value from request
if(isset($_REQUEST['start']) && $_REQUEST['start'] != '') {
	$start = $_REQUEST['start'];
} else
	$start=1;

//Retreive the Navigation array
$navigation_array = getNavigationValues($start, $no_of_rows, '100');

$start_rec = $navigation_array['start'];
$end_rec = $navigation_array['end_val'];

$record_string= $app_strings[LBL_SHOWING]." " .$start_rec." - ".$end_rec." " .$app_strings[LBL_LIST_OF] ." ".$no_of_rows;

$navigationOutput = getTableHeaderNavigation($navigation_array, $url_string,"Settings","ShowAuditTrail",'');

$smarty->assign("MOD", $current_module_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->assign("APP", $app_strings);
$smarty->assign("THEME", $theme);
$smarty->assign("IMAGE_PATH",$image_path);
$smarty->assign("THEME_PATH",$theme_path);
$smarty->assign("LIST_HEADER",$focus->getAuditTrailHeader());
$smarty->assign("LIST_ENTRIES",$focus->getAuditTrailEntries($userid, $navigation_array, $sorder, $sortby));
$smarty->assign("RECORD_COUNTS", $record_string);
$smarty->assign("NAVIGATION", $navigationOutput);
$smarty->assign("USERID", $userid);
$smarty->assign("CATEGORY",$category);

if($_REQUEST['ajax'] !='')
	$smarty->display("ShowAuditTrailContents.tpl");
else	
	$smarty->display("ShowAuditTrail.tpl");

?>
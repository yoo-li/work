<?php
require_once('Smarty_setup.php');
require_once('modules/Users/LoginHistory.php');
require_once('modules/Users/Users.php');
require_once('include/utils/utils.php');

global $app_strings;
global $mod_strings;
global $app_list_strings;
global $current_language, $current_user;

global $list_max_entries_per_page;

global $currentModule;

$focus = new LoginHistory();

$smarty = new vtigerCRM_Smarty;

$category = getParenttab();

$userid = $_REQUEST['record'];
$username = getUserName($userid);
$loginhistory_query = XN_Query::create ( 'BigContent' )->tag ( "Loginhistorys" )
			->filter ( 'type', 'eic', 'loginhistorys' )
			->filter ( 'my.user_name', '=', $username )
			->alwaysReturnTotalCount(true);	

$loginhistory_query->execute ();

$no_of_rows = $loginhistory_query->getTotalCount();

if(isset($_REQUEST['start']) && $_REQUEST['start'] != '') {
	$start = $_REQUEST['start'];
} else {
	$start=1;
}

//Retreive the Navigation array
$navigation_array = getNavigationValues($start, $no_of_rows, '10');

$start_rec = $navigation_array['start'];
$end_rec = $navigation_array['end_val'];
$record_string= $app_strings[LBL_SHOWING]." " .$start_rec." - ".$end_rec." " .$app_strings[LBL_LIST_OF] ." ".$no_of_rows;

$navigationOutput = getTableHeaderNavigation($navigation_array, $url_string,"Users","ShowHistory",'');

$smarty->assign("CMOD", $mod_strings);
$smarty->assign("MOD", return_module_language($current_language, "Settings"));
$smarty->assign("APP", $app_strings);
$smarty->assign("THEME", $theme);
$smarty->assign("IMAGE_PATH",$image_path);
$smarty->assign("LIST_HEADER",$focus->getHistoryListViewHeader());
$smarty->assign("LIST_ENTRIES",$focus->getHistoryListViewEntries($username, $navigation_array, $sorder, $sortby));
$smarty->assign("RECORD_COUNTS", $record_string);
$smarty->assign("NAVIGATION", $navigationOutput);
$smarty->assign("CATEGORY",$category);

$smarty->display("ShowHistoryContents.tpl");
?>
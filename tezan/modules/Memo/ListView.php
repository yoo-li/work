<?php


global $currentModule;
require_once('modules/'.$currentModule.'/'.$currentModule.'.php');
require_once('Smarty_setup.php');

require_once('include/utils/utils.php');
require_once('modules/CustomView/CustomView.php');

global $app_strings,$mod_strings,$current_language;
$current_module_strings = return_module_language($current_language, $currentModule);

global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";

$upperModule = strtoupper($currentModule);

$focus = CRMEntity::getInstance($currentModule);
// Initialize sort by fields
$focus->initSortbyField($currentModule);
// END
$category = getParentTab();
$smarty = new vtigerCRM_Smarty;
$other_text = Array();
$url_string = ''; // assigning http url string

if(!$_SESSION['lvs'][$currentModule])
{
	unset($_SESSION['lvs']);
	$modObj = new ListViewSession();
	$modObj->sorder = $sorder;
	$modObj->sortby = $order_by;
	$_SESSION['lvs'][$currentModule] = get_object_vars($modObj);
}


if($_REQUEST['errormsg'] != '')
{
        $errormsg = $_REQUEST['errormsg'];
        $smarty->assign("ERROR",$errormsg);
}else
{
        $smarty->assign("ERROR","");
}

if(CustomView::hasViewChanged($currentModule,$viewid)) {
	$_SESSION[$upperModule.'_ORDER_BY'] = '';
}

//<<<<<<<<<<<<<<<<<<< sorting - stored in session >>>>>>>>>>>>>>>>>>>>
$sorder = $focus->getSortOrder();
$order_by = $focus->getOrderBy();

$_SESSION[$upperModule.'_ORDER_BY'] = $order_by;
$_SESSION[$upperModule.'_SORT_ORDER'] = $sorder;
//<<<<<<<<<<<<<<<<<<< sorting - stored in session >>>>>>>>>>>>>>>>>>>>

//<<<<cutomview>>>>>>>
$oCustomView = new CustomView($currentModule);
$viewid = $oCustomView->getViewId($currentModule);
$customviewcombo_html = $oCustomView->getCustomViewCombo($viewid);
$viewnamedesc = $oCustomView->getCustomViewByCvid($viewid);


//Added to handle approving or denying status-public by the admin in CustomView
$statusdetails = $oCustomView->isPermittedChangeStatus($viewnamedesc['status']);
$smarty->assign("CUSTOMVIEW_PERMISSION",$statusdetails);

//To check if a user is able to edit/delete a customview
$edit_permit = $oCustomView->isPermittedCustomView($viewid,'EditView',$currentModule);
$delete_permit = $oCustomView->isPermittedCustomView($viewid,'Delete',$currentModule);
$smarty->assign("CV_EDIT_PERMIT",$edit_permit);
$smarty->assign("CV_DELETE_PERMIT",$delete_permit);

$listview_check_button = ListView_Button_Check($module);
$smarty->assign("LISTVIEW_CHECK_BUTTON", $listview_check_button);

//<<<<<customview>>>>>

if($viewid != 0)
{
        $CActionDtls = $oCustomView->getCustomActionDetails($viewid);
}
elseif($viewid ==0)
{
	echo "<table border='0' cellpadding='5' cellspacing='0' width='100%' height='450px'><tr><td align='center'>";
	echo "<div style='border: 3px solid rgb(153, 153, 153); background-color: rgb(255, 255, 255); width: 55%; position: relative; z-index: 10000000;'>

		<table border='0' cellpadding='5' cellspacing='0' width='98%'>
		<tbody><tr>
		<td rowspan='2' width='11%'><img src='". vtiger_imageurl('denied.gif', $theme)."' ></td>
		<td style='border-bottom: 1px solid rgb(204, 204, 204);' nowrap='nowrap' width='70%'>
			<span class='genHeaderSmall'>$app_strings[LBL_PERMISSION]</span></td>
		</tr>
		<tr>
		<td class='small' align='right' nowrap='nowrap'>
		<a href='javascript:window.history.back();'>$app_strings[LBL_GO_BACK]</a><br>
		</td>
		</tr>
		</tbody></table>
		</div>";
	echo "</td></tr></table>";
	exit;
}

if($viewnamedesc['viewname'] == 'All')
{
	$smarty->assign("ALL", 'All');
}

$smarty->assign("CUSTOMVIEW_OPTION",$customviewcombo_html);
$smarty->assign("VIEWID", $viewid);
$smarty->assign("MOD", $mod_strings);
$smarty->assign("APP", $app_strings);
$smarty->assign("THEME", $theme);
$smarty->assign("IMAGE_PATH",$image_path);
$smarty->assign("MODULE",$currentModule);
$smarty->assign("BUTTONS",$other_text);
$smarty->assign("CATEGORY",$category);
$smarty->assign("SINGLE_MOD",$currentModule);

//Retreive the list from Database
//<<<<<<<<<customview>>>>>>>>>
global $current_user;
$queryGenerator = new QueryGenerator($currentModule, $current_user);
if ($viewid != "0") {
	$queryGenerator->initForCustomViewById($viewid);
} else {
	$queryGenerator->initForDefaultCustomView();
}
//<<<<<<<<customview>>>>>>>>>

// Enabling Module Search
$url_string = '';
if($_REQUEST['query'] == 'true') {
	$queryGenerator->addUserSearchConditions($_REQUEST);
	if($_REQUEST['searchtype'] == 'searchPanel') {
		$ustring = '&searchtype=searchPanel';
		$searchUrl = $queryGenerator->getSearchUrl();	
		if(count($searchUrl) > 0) {
			for($i=0;$i<count($searchUrl);$i++) {
				$ustring .= '&'.$searchUrl[$i]['fieldname'].'='.$searchUrl[$i]['value'];
			}
		}
	}else {
		$ustring = getSearchURL($_REQUEST);
	}
	//exit($ustring);
	$url_string .= "&query=true$ustring";
	$smarty->assign('SEARCH_URL', $url_string);
}

$query = XN_Query::create ( 'Content' ) ->tag($focus->table_name)
	->filter ( 'type', 'eic', $focus->table_name)
	->filter ( 'my.deleted', '=', '0' );	
	


$permission = listviewpermission($currentModule,$search);

if (isset($permission)) $query->filter($permission);
	
	
if (isset($order_by) && $order_by != '' && strncmp($order_by,'my.',3)!=0 && $order_by != 'updateDate' && $order_by != 'createdDate' && $order_by != 'published' && $order_by != 'updated' && $order_by != 'author' && $order_by!= 'title')
{    		
    $query_order_by = "my.".$order_by;
}
    		
if(isset($query_order_by) && $query_order_by != ''){
	if ($sorder == 'DESC'){
		$query->order($query_order_by,XN_Order::DESC);
	}
	else 
		$query->order($query_order_by,XN_Order::ASC);	
}
else {
	if ($sorder == 'DESC')
{
       $query->order($order_by,XN_Order::DESC);
}
else
{
	$query->order($order_by,XN_Order::ASC);
}
}
	

$queryMode = (isset($_REQUEST['query']) && $_REQUEST['query'] == 'true');
$start = ListViewSession::getRequestCurrentPage($currentModule, $query, $viewid, $queryMode);
$limit_start_rec = ($start-1) * $list_max_entries_per_page;

$query->begin($limit_start_rec);
$query->end($list_max_entries_per_page+$limit_start_rec);

$list_result = $query->execute();

$noofrows = $query->getTotalCount();

$navigation_array = VT_getSimpleNavigationValues($start,$list_max_entries_per_page,$noofrows);
$recordListRangeMsg = getRecordRangeMessage($list_result, $limit_start_rec,$noofrows);
$smarty->assign('recordListRange',$recordListRangeMsg);


foreach ($list_result as $contact) 
{
 	$ids[] = $contact->id;
}
if(isset($ids))
{
	$smarty->assign("ALLIDS", implode($ids,";"));
}

//Retreive the List View Table Header
if($viewid !='')
	$url_string .="&viewname=".$viewid;
	
global $listview_setting;
$controller = new ListViewController($current_user, $queryGenerator);
$listview_header = $controller->getListViewHeader($focus,$currentModule,$url_string,$sorder,$order_by);
$smarty->assign("LISTHEADER", $listview_header);
$smarty->assign("LISTVIEWSETTING", $listview_setting);
$listview_header_search = $controller->getBasicSearchFieldInfoList();
$smarty->assign("SEARCHLISTHEADER",$listview_header_search);

$listview_entries = $controller->getListViewEntries($focus,$currentModule,$list_result,$navigation_array);

$smarty->assign("LISTENTITY", $listview_entries);
$smarty->assign("SELECT_SCRIPT", $view_script);
//Added to select Multiple records in multiple pages
$smarty->assign("SELECTEDIDS", $_REQUEST['selobjs']);
$smarty->assign("ALLSELECTEDIDS", $_REQUEST['allselobjs']);
$smarty->assign("CURRENT_PAGE_BOXES", implode(array_keys($listview_entries),";"));

$navigationOutput = getTableHeaderSimpleNavigation($navigation_array, $url_string,$currentModule,"index",$viewid);
$alphabetical = AlphabeticalSearch($currentModule,'index','storageid','true','basic',"","","","",$viewid);
$fieldnames = $controller->getAdvancedSearchOptionString();

$smarty->assign("FIELDNAMES", $fieldnames);
$smarty->assign("ALPHABETICAL", $alphabetical);

$smarty->assign("NAVIGATION", $navigationOutput);

$check_button = Button_Check($module);
$smarty->assign("CHECK", $check_button);

ListViewSession::setSessionQuery($currentModule,$list_query,$viewid);



if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] != '')
	$smarty->display("ListViewEntries.tpl");
else	
	$smarty->display("ListView.tpl");
?>
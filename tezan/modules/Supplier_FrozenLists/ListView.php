<?php
/*+********************************************************************************
 * The contents of this file are subject to the 361CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  361CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ********************************************************************************/
if($_REQUEST['mode'] == 'Export')
{
	include ('modules/Public/SheetExportExcel.php');
	die();
}


global $currentModule;
require_once('modules/'.$currentModule.'/'.$currentModule.'.php');
require_once('Smarty_setup.php');
require_once('include/utils/utils.php');
require_once('include/utils/DataSearch.php');
require_once('modules/CustomView/CustomView.php');

global $app_strings,$mod_strings,$current_language;
$current_module_strings = return_module_language($current_language, $currentModule);

$focus = CRMEntity::getInstance($currentModule);

$focus->initSortbyField($currentModule);

$category = getParentTab();

$smarty = new vtigerCRM_Smarty;

if($_REQUEST['errormsg'] != '')
{
        $errormsg = $_REQUEST['errormsg'];
        $smarty->assign("ERROR",$errormsg);
}else
{
        $smarty->assign("ERROR","");
}
if($_REQUEST['numPerPage'] != '' && $_REQUEST['numPerPage'] != $_SESSION['numPerPage'])
{
	$numperpage = $_REQUEST['numPerPage'];
	$_SESSION['numPerPage'] = $numperpage;
} 
else if(isset($_SESSION['numPerPage']) && $_SESSION['numPerPage'] != "")
{
	$numperpage = $_SESSION['numPerPage'];
}
else
{
	$numperpage = 50;
}
$smarty->assign("NUMPERPAGE", $numperpage);

$upperModule = strtoupper($currentModule);

if(CustomView::hasViewChanged($currentModule,$viewid)) {
	$_SESSION[$upperModule.'_ORDER_BY'] = '';
}

//<<<<<<<<<<<<<<<<<<< sorting - stored in session >>>>>>>>>>>>>>>>>>>>

if($_REQUEST['_order'] != '' && $_REQUEST['_order'] != $_SESSION[$upperModule.'_ORDER_BY'])
{
	$order_by = $_REQUEST['_order'];
	$_SESSION[$upperModule.'_ORDER_BY'] = $order_by;
} 
else if(isset($_SESSION[$upperModule.'_ORDER_BY']) && $_SESSION[$upperModule.'_ORDER_BY'] != "")
{
	$order_by = $_SESSION[$upperModule.'_ORDER_BY'];
}
else
{
	$order_by = $focus->getOrderBy();
}
////////////////////////////////
if($_REQUEST['_sort'] != '' && $_REQUEST['_sort'] != $_SESSION[$upperModule.'_SORT_ORDER'])
{
	$sorder= $_REQUEST['_sort'];
	$_SESSION[$upperModule.'_SORT_ORDER'] = $sorder;
} 
else if(isset($_SESSION[$upperModule.'_SORT_ORDER']) && $_SESSION[$upperModule.'_SORT_ORDER'] != "")
{
	$sorder = $_SESSION[$upperModule.'_SORT_ORDER'];
}
else
{
	$sorder = $focus->getSortOrder();
}


//<<<<<<<<<<<<<<<<<<< sorting - stored in session >>>>>>>>>>>>>>>>>>>>

//<<<<cutomview>>>>>>>
$oCustomView = new CustomView($currentModule);
$viewid = $oCustomView->getViewId($currentModule);
$customviewcombo_html = $oCustomView->getCustomViewCombo($viewid);
$viewnamedesc = $oCustomView->getCustomViewByCvid($viewid);

$edit_permit = $oCustomView->isPermittedCustomView($viewid,$currentModule);
$smarty->assign("CV_EDIT_PERMIT",$edit_permit);
//<<<<<customview>>>>>




$listview_check_button = ListView_Button_Check($module);
$smarty->assign("LISTVIEW_CHECK_BUTTON", $listview_check_button);

if($viewid != 0)
{
        $CActionDtls = $oCustomView->getCustomActionDetails($viewid);
}
elseif($viewid ==0)
{
	echo "<table border='0' cellpadding='5' cellspacing='0' width='100%' height='450px'><tr><td align='center' class='center'>";
	echo "<div style='border: 3px solid rgb(153, 153, 153); background-color: rgb(255, 255, 255); width: 55%; position: relative; z-index: 10000000;'>

		<table border='0' cellpadding='5' cellspacing='0' width='98%'>
		<tbody><tr>
		<td rowspan='2' width='11%'><img src='/images/denied.gif' ></td>
		<td style='border-bottom: 1px solid rgb(204, 204, 204);' nowrap='nowrap' width='70%'>
			<span class='genHeaderSmall'>$app_strings[LBL_PERMISSION]</span></td>
		</tr>
		<tr>
		<td class='small' align='right' nowrap='nowrap'><br>
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
$smarty->assign("MODULE",$currentModule);
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


$search = new DataSearch($currentModule,$queryGenerator,$focus);
$searchpanel = $search->getBasicSearchPanel();

$smarty->assign('SEARCHPANEL',$searchpanel);

 



$query = XN_Query::create ( 'MainContent' ) ->tag($focus->table_name)
	->filter ( 'type', 'eic', $focus->table_name)
	->filter ( 'my.deleted', '=', '0' );	


foreach($search->searchfields as $searchfield)
{
		if ($searchfield == "published")
		{
			if(isset($_REQUEST['published_startdate']) && $_REQUEST['published_startdate'] != '' && isset($_REQUEST['published_enddate']) && $_REQUEST['published_enddate'] != '')
			{
				$query->filter ( 'published', '>=', $_REQUEST['published_startdate'].' 00:00:00' )
					  ->filter ( 'published', '<=', $_REQUEST['published_enddate'].' 23:59:59' );
			}
			else
			{
				$query->filter ( 'published', '>=', date("Y").'-01-01 00:00:00' )
					  ->filter ( 'published', '<=', date("Y").'-12-31 23:59:59' );
			}
		}
		elseif ($searchfield == "author")
		{
			if(isset($_REQUEST['author']) && $_REQUEST['author'] != '')
			{
				$author = $_REQUEST['author'];
				$query->filter ( 'author', 'in', explode(';',$author));
			}

		}
		elseif ($searchfield == "user_role")
		{
			if(isset($_REQUEST['user_role']) && $_REQUEST['user_role'] != '')
			{
				$user_role = $_REQUEST['user_role'];
				$query->filter ( 'my.user_role', 'in', explode(';',$user_role));
			}
		}
		elseif (is_array($searchfield))
		{
			if ($searchfield[0] == "input")
			{
				$input = $_REQUEST['search_input'];
			    if($searchfield[1] == "profileid"){
			    	if($input != "")
					{ 
						$search ='/^1([0-9]{10})$/';
						if(preg_match($search,$input)) 
						{
				        	$profile = XN_Query::create ( 'Profile' ) ->tag("profile")
								->filter('type','=','wxuser')
								->filter('mobile','=',$input)
								->begin(0)->end(50)
								->execute();
							$pids = array();
							foreach($profile as $pinfo){
								$pids[] = $pinfo->screenName;
							}
							if(count($pids)>0){
								$query->filter('my.profileid','in',$pids);
							}
							else
							{
                                $query->filter('my.profileid','=',0);
							} 
						}
						else
						{
				        	$profile = XN_Query::create ( 'Profile' ) ->tag("profile")
								->filter('type','=','wxuser')
								->filter('givenname','=',$input)
								->begin(0)->end(100)
								->execute();
							$pids = array();
							foreach($profile as $pinfo){
								$pids[] = $pinfo->screenName;
							}
							if(count($pids)>0)
							{
								$query->filter('my.profileid','in',$pids);
							} 
							else
							{
                                $query->filter('my.profileid','=',0);
							} 
						} 
					}
			    }else{
					if (isset($input) && $input != "")
					{
						$fields = $searchfield[1];
						$fieldlist = explode(",", $fields);	
						$fieldlist = array_unique($fieldlist);
						if (count($fieldlist) == 1)
						{
							if ($fieldlist[0] == "title")
							{
								$query->filter ( 'title', 'like', $input);
							}
							else
							{
								$query->filter ( 'my.'.$fieldlist[0], 'like', $input);
							}
						}
						elseif(count($fieldlist) == 2)
						{
							if ($fieldlist[0] == "title")
							{
								$fieldlist1 = "title";
							}
							else
							{
								$fieldlist1 = "my.".$fieldlist[0];
							}
							if ($fieldlist[1] == "title")
							{
								$fieldlist2 = "title";
							}
							else
							{
								$fieldlist2 = "my.".$fieldlist[1];
							}
							$query1 = XN_Filter( $fieldlist1,'like',$input);
							$query2 = XN_Filter( $fieldlist2,'like',$input);
							$query->filter(XN_Filter::any( $query1,$query2));
						}
					}
				}
			}elseif($searchfield[0] == "calendar"){
				if ($searchfield[1] == "published")
				{
					if(isset($_REQUEST['published_startdate']) && $_REQUEST['published_startdate'] != '' && isset($_REQUEST['published_enddate']) && $_REQUEST['published_enddate'] != '')
					{
						$query->filter ( 'published', '>=', $_REQUEST['published_startdate'].' 00:00:00' )
							  ->filter ( 'published', '<=', $_REQUEST['published_enddate'].' 23:59:59' );
					}
					else
					{
						$query->filter ( 'published', '>=', date("Y").'-01-01 00:00:00' )
							  ->filter ( 'published', '<=', date("Y").'-12-31 23:59:59' );
					}
				}else{
					if(isset($_REQUEST[$searchfield[1].'_startdate']) && $_REQUEST[$searchfield[1].'_startdate'] != '' && isset($_REQUEST[$searchfield[1].'_enddate']) && $_REQUEST[$searchfield[1].'_enddate'] != '')
					{
						$query->filter ( 'my.'.$searchfield[1], '>=', $_REQUEST[$searchfield[1].'_startdate'].' 00:00:00' )
							  ->filter ( 'my.'.$searchfield[1], '<=', $_REQUEST[$searchfield[1].'_enddate'].' 23:59:59' );
					}
					else
					{
						$query->filter ( 'my.'.$searchfield[1], '>=', date("Y").'-01-01 00:00:00' )
							  ->filter ( 'my.'.$searchfield[1], '<=', date("Y").'-12-31 23:59:59' );
					}
				}
			}
		}
		else
		{
			if(isset($_REQUEST[$searchfield]) && $_REQUEST[$searchfield] != '')
			{
				$query->filter ( 'my.'.$searchfield, '=', $_REQUEST[$searchfield]);
			}
			elseif(isset($_REQUEST['search_'.$searchfield]) && $_REQUEST['search_'.$searchfield] != '')
			{
				$query->filter ( 'my.'.$searchfield, '=', $_REQUEST['search_'.$searchfield]);
			}
		}
}

if (!check_authorize('tezanadmin') && !is_admin($current_user))  
{ 
	global  $supplierid;
	$query->filter ( 'my.supplierid', '=', $supplierid); 
}

 
	
$smarty->assign("ORDER_BY", $order_by);
$query_order_by = $order_by;
if (isset($order_by) && $order_by != '' && strncmp($order_by,'my.',3)!=0 && $order_by != 'updateDate' && $order_by != 'createdDate' && $order_by != 'published' && $order_by != 'updated' && $order_by != 'author' && $order_by!= 'title')
{    		
	$query_order_by = "my.".$order_by;
}
    		
if (strtolower($sorder) == 'desc'){
	if (isset($focus->sortby_number_fields) && in_array($order_by,$focus->sortby_number_fields))
	{
			$query->order($query_order_by,XN_Order::DESC_NUMBER);
	}
	else
	{
		$query->order($query_order_by,XN_Order::DESC);
	}
	$smarty->assign("ORDER", "desc");
}
else 
{
	if (isset($focus->sortby_number_fields) && in_array($order_by,$focus->sortby_number_fields))
	{
		$query->order($query_order_by,XN_Order::ASC_NUMBER);
	}
	else
	{
		$query->order($query_order_by,XN_Order::ASC);
	}
		
	$smarty->assign("ORDER", "asc");
}
	

if(isset($_REQUEST['pageNum']) && $_REQUEST['pageNum'] != "")
{
	$pagenum = $_REQUEST['pageNum'];
}
else
{
	$pagenum = 1;
}
$smarty->assign("PAGENUM", $pagenum);

$limit_start_rec = ($pagenum-1) * $numperpage;
if ($limit_start_rec < 0) $limit_start_rec = 0;
$query->begin($limit_start_rec);
$query->end($numperpage+$limit_start_rec);

$list_result = $query->execute();

$noofrows = $query->getTotalCount();

$smarty->assign('NOOFROWS',$noofrows);

$controller = new ListViewController($current_user, $queryGenerator);
if(isset($changeArray) &&is_array($changeArray)){
    $listview_header = $controller->getListViewHeader($focus,$currentModule,"",$sorder,$order_by,$changeArray);
    $listview_entries = $controller->getListViewEntries($focus,$currentModule,$list_result,$navigation_array,$changeArray);
}else{
    $listview_header = $controller->getListViewHeader($focus,$currentModule,"",$sorder,$order_by);
    $listview_entries = $controller->getListViewEntries($focus,$currentModule,$list_result,$navigation_array);
}
$smarty->assign("LISTHEADER", $listview_header);
$smarty->assign("LISTENTITY", $listview_entries);

if(isset($_REQUEST["mode"]) && $_REQUEST["mode"] == "ajax"){
        $smarty->display("ListViewEntries.tpl");
}else
{
        $smarty->display("ListView.tpl");
}


?>
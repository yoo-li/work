<?php
global  $supplierid;
if (isset($_REQUEST['reportid']) && $_REQUEST['reportid'] != '')
{
    $reportid = $_REQUEST['reportid'];
}
else
{
    die();
}
//print_r($_REQUEST);
$loadcontent = XN_Content::load($reportid,"ma_reportsettings");
$reportname = $loadcontent->my->reportname;
$reporttype = $loadcontent->my->reporttype;   
$modulestabid = $loadcontent->my->modulestabid;
$reportmodule =  getModule($modulestabid);   

    
global $currentModule;
$currentModule = $reportmodule;
require_once('modules/'.$currentModule.'/'.$currentModule.'.php');
require_once('Smarty_setup.php');
require_once('include/utils/DataSearch.php');
require_once('modules/CustomView/CustomView.php');
//中英文对照
global $app_strings, $mod_strings, $current_language;
$current_module_strings = return_module_language($current_language, $currentModule);
//根据当前模块名生成类
$focus = CRMEntity::getInstance($currentModule);
$focus->initSortbyField($currentModule);
$category = getParentTab();
$smarty = new vtigerCRM_Smarty;
  
//分页条用到的每页展示多少条
if ($_REQUEST['numPerPage'] != '' && $_REQUEST['numPerPage'] != $_SESSION['numPerPage'])
{
    $numperpage             = $_REQUEST['numPerPage'];
    $_SESSION['numPerPage'] = $numperpage;
}
else if (isset($_SESSION['numPerPage']) && $_SESSION['numPerPage'] != "")
{
    $numperpage = $_SESSION['numPerPage'];
}
else
{
    $numperpage = 50;
}
$smarty->assign("NUMPERPAGE", $numperpage);
$upperModule = strtoupper($currentModule);

//列表按哪个字段排序，默认按$focus->getOrderBy()里面的字段排序，如果点了某个列排序，就按这个列，且放入session
if (CustomView::hasViewChanged($currentModule, $viewid))
{
    $_SESSION[$upperModule.'_ORDER_BY'] = '';
}
//<<<<<<<<<<<<<<<<<<< sorting - stored in session >>>>>>>>>>>>>>>>>>>>
if ($_REQUEST['_order'] != '' && $_REQUEST['_order'] != $_SESSION[$upperModule.'_ORDER_BY'])
{
    $order_by                           = $_REQUEST['_order'];
    $_SESSION[$upperModule.'_ORDER_BY'] = $order_by;
}
else if (isset($_SESSION[$upperModule.'_ORDER_BY']) && $_SESSION[$upperModule.'_ORDER_BY'] != "")
{
    $order_by = $_SESSION[$upperModule.'_ORDER_BY'];
}
else
{
    $order_by = $focus->getOrderBy();
}
////////////////////////////////
if ($_REQUEST['_sort'] != '' && $_REQUEST['_sort'] != $_SESSION[$upperModule.'_SORT_ORDER'])
{
    $sorder                               = $_REQUEST['_sort'];
    $_SESSION[$upperModule.'_SORT_ORDER'] = $sorder;
}
else if (isset($_SESSION[$upperModule.'_SORT_ORDER']) && $_SESSION[$upperModule.'_SORT_ORDER'] != "")
{
    $sorder = $_SESSION[$upperModule.'_SORT_ORDER'];
}
else
{
    $sorder = $focus->getSortOrder();
}
//<<<<<<<<<<<<<<<<<<< sorting - stored in session >>>>>>>>>>>>>>>>>>>>
//<<<<cutomview>>>>>>>
//按哪个视图展示，就是展示哪几个字段的值
$oCustomView          = new CustomView($currentModule);
$viewid               = $oCustomView->getViewId($currentModule);
$customviewcombo_html = $oCustomView->getCustomViewCombo($viewid);
$viewnamedesc         = $oCustomView->getCustomViewByCvid($viewid);
$edit_permit = $oCustomView->isPermittedCustomView($viewid, $currentModule);
$smarty->assign("CV_EDIT_PERMIT", $edit_permit);
//<<<<<customview>>>>>
$listview_check_button = ListView_Button_Check($currentModule);
$smarty->assign("LISTVIEW_CHECK_BUTTON", $listview_check_button);
if ($viewid != 0)
{
    $CActionDtls = $oCustomView->getCustomActionDetails($viewid);
}
elseif ($viewid == 0)
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
if ($viewnamedesc['viewname'] == 'All')
{
    $smarty->assign("ALL", 'All');
}
$smarty->assign("CUSTOMVIEW_OPTION", $customviewcombo_html);
$smarty->assign("VIEWID", $viewid);
$smarty->assign("MOD", $mod_strings);
$smarty->assign("APP", $app_strings);
$smarty->assign("MODULE", $currentModule);

global $current_user;
//查询语句类
$queryGenerator = new QueryGenerator($currentModule, $current_user);
if ($viewid != "0")
{
    $queryGenerator->initForCustomViewById($viewid);
}
else
{
    $queryGenerator->initForDefaultCustomView();
}
//<<<<<<<<customview>>>>>>>>> 
 
//查询语句,最终要展示的哪些数据
require_once('modules/'.$reportmodule.'/'.$reportmodule.'.php'); 
$focus = CRMEntity::getInstance($reportmodule); 
if ($focus->datatype == 7)
{
	$query = XN_Query::create('YearContent')->tag($focus->table_name)
	    ->filter('type', 'eic', $focus->table_name)
	    ->filter('my.deleted', '=', '0');
}
else
{
	$query = XN_Query::create('Content')->tag($focus->table_name)
	    ->filter('type', 'eic', $focus->table_name)
	    ->filter('my.deleted', '=', '0');
}

//自定义的查询字段，要自己链接到$query查询语句里面


global  $supplierid; 
$nomodules = array("Ma_Products","Ma_Factorys","Ma_Products",'Ma_Factorys','Ma_Agencys','Ma_Hospitals',);
if (isset($supplierid) && $supplierid != "" && $supplierid != "0" && !in_array($reportmodule,$nomodules))
{
	$query->filter('my.supplierid','=',$supplierid);
} 


if (isset($_REQUEST['x']) && $_REQUEST['x'] != "" &&
	isset($_REQUEST['x_key']) && $_REQUEST['x_key'] != "") 
{
	$fieldname = $_REQUEST['x'];
	$fieldvalue = $_REQUEST['x_key'];
    if ($fieldname == "published")
	{
		if (preg_match('/(\d{4})-(\d{1,2})/', $fieldvalue))
		{
			$lastdate = date("Y-m-t",strtotime($fieldvalue."-01")); 
			$query->filter('published','>=',$fieldvalue.'-01'.' 00:00:00'); 
			$query->filter('published','<=',$lastdate.' 23:59:59'); 
		}
		else
		{
			$query->filter('published','>=',date("Y").'-'.$fieldvalue.' 00:00:00'); 
			$query->filter('published','<=',date("Y").'-'.$fieldvalue.' 23:59:59'); 
		}
	}
	else
	{
		$query->filter('my.'.$fieldname,'=',$fieldvalue); 
	}
}

if (isset($_REQUEST['z']) && $_REQUEST['z'] != "" &&
	isset($_REQUEST['z_key']) && $_REQUEST['z_key'] != "") 
{
	$fieldname = $_REQUEST['z'];
	$fieldvalue = $_REQUEST['z_key'];
    if ($fieldname == "published")
	{
		if (preg_match('/(\d{4})-(\d{1,2})/', $fieldvalue))
		{
			$lastdate = date("Y-m-t",strtotime($fieldvalue."-01")); 
			$query->filter('published','>=',$fieldvalue.'-01'.' 00:00:00'); 
			$query->filter('published','<=',$lastdate.' 23:59:59'); 
		}
		else
		{
			$query->filter('published','>=',date("Y").'-'.$fieldvalue.' 00:00:00'); 
			$query->filter('published','<=',date("Y").'-'.$fieldvalue.' 23:59:59'); 
		}
	}
	else
	{
		$query->filter('my.'.$fieldname,'=',$fieldvalue); 
	}
}
 

$reportsettingsquerys = XN_Query::create('Content')
	->tag('supplier_reportsettingsquerys')
	->filter('type','eic','supplier_reportsettingsquerys') 							
	->filter('my.deleted','=','0')
	->filter('my.record','=',$reportid)
	->end(-1)
	->execute();
	 
foreach($reportsettingsquerys as  $reportsettingsquery_info)
{
	$fieldname = $reportsettingsquery_info->my->fieldname;
	$logic = $reportsettingsquery_info->my->logic;
	$queryvalue = $reportsettingsquery_info->my->queryvalue;
	$query->filter('my.'.$fieldname,$logic,$queryvalue); 
} 
    
//分页展示第几页
if (isset($_REQUEST['pageNum']) && $_REQUEST['pageNum'] != "")
{
    $pagenum = $_REQUEST['pageNum'];
}
else
{
    $pagenum = 1;
}
$smarty->assign("PAGENUM", $pagenum);
$limit_start_rec = ($pagenum - 1) * $numperpage;
if ($limit_start_rec < 0)
    $limit_start_rec = 0;
$query->begin($limit_start_rec);
$query->end($numperpage + $limit_start_rec);
$list_result = $query->execute();
$noofrows = $query->getTotalCount();
$smarty->assign('NOOFROWS', $noofrows);
//根据config.data.php里面配置的显示设置来形成数据，在模块里面解析之后形成table
$controller = new ListViewController($current_user, $queryGenerator);
if (isset($changeArray) && is_array($changeArray))
{
    $listview_header  = $controller->getListViewHeader($focus, $currentModule, "", $sorder, $order_by, $changeArray);
    $listview_entries = $controller->getListViewEntries($focus, $currentModule, $list_result, $navigation_array, $changeArray);
}
else
{
    $listview_header  = $controller->getListViewHeader($focus, $currentModule, "", $sorder, $order_by);
    $listview_entries = $controller->getListViewEntries($focus, $currentModule, $list_result, $navigation_array);
}
$smarty->assign("LISTHEADER", $listview_header);
$smarty->assign("LISTENTITY", $listview_entries);


		
 
$smarty->display("Reports/ListViewEntries.tpl");
     

?>
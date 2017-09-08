<?php
if ($_REQUEST['mode'] == 'Export')
{
    include('modules/Public/SheetExportExcel.php');
    die();
}
global $currentModule;
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
if ($_REQUEST['errormsg'] != '')
{
    $errormsg = $_REQUEST['errormsg'];
    $smarty->assign("ERROR", $errormsg);
}
else
{
    $smarty->assign("ERROR", "");
}
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
//Retreive the list from Database
//<<<<<<<<<customview>>>>>>>>>
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


//删除几天之前的所有废数据（新建但没保存）
$time = strtotime("today");
$time = strtotime('-1 days', $time);
$createnews = XN_Query::create('Content')->tag($focus->table_name)
    ->filter('type', 'eic', $focus->table_name)
    ->filter('my.createnew', '=', '1')
    ->filter('published', '< ', date("Y-m-d H:i:s", $time))
    ->end(-1)
    ->execute();
if (count($createnews) > 0)
{
    foreach (array_chunk($createnews, 50, true) as $chunk_fields)
    {
        XN_Content::delete($chunk_fields, $focus->table_name);
    }
}
$search      = new DataSearch($currentModule, $queryGenerator, $focus);
//查询语句,最终要展示的哪些数据
$query = XN_Query::create('Content')->tag($focus->table_name)
    ->filter('type', 'eic', $focus->table_name)
    ->filter('my.deleted', '=', '0')
    ->filter("my.modifystatus","=","1")
    ->order("published",XN_Order::DESC);
//自定义的查询字段，要自己链接到$query查询语句里面
global  $current_user,$supplierusertype,$user_type_id,$supplierid;
if($supplierusertype=="admin" || $supplierusertype=="superadmin"){
    $query->filter("my.supplierid","=","admin");
}
else{
    $query->filter("my.supplierid","=",$supplierid);
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

$listview_header  = $controller->getListViewHeader($focus, $currentModule, "", $sorder, $order_by);
$listview_entries=array();
$module_types=array("ma_agencys"=>"Ma_Agencys","ma_factorys"=>"Ma_Factorys","ma_hospitals"=>"Ma_Hospitals","ma_products"=>"Ma_Products");
$module_names=array("ma_agencys"=>"经营企业","ma_factorys"=>"生产企业","ma_hospitals"=>"医疗机构","ma_products"=>"产品信息");
$modifystatus=array("1"=>"待修改","2"=>"已修改","3"=>"审核不通过");
if(count($list_result)){
    foreach($list_result as $info){
        $module_type=$info->my->module_type;
        $modulename=$module_types[$module_type];
        $infoname=$module_names[$module_type];
        $listview_entries[$info->id]=array(
            "relation_id"=>'<a onclick="BJUI.dialog(\'closeCurrent\');" href="index.php?module='.$modulename.'&action=EditView&record='.$info->my->relation_id.'" data-toggle="navtab"  data-id="edit" data-title="'.$infoname.'">'.$info->my->info_name.'</a>',
            "module_type"=>$infoname,
            "warn_msg"=>$info->my->warn_msg,
            "end_date"=>$info->my->end_date,
            "modifystatus"=>$modifystatus[$info->my->modifystatus],
            "published"=>$info->published
        );
    }

    echo '<table class="table table-bordered">';
    foreach($listview_entries as $entry_info){
        echo '<tr>';
        echo '<td>'.$entry_info['relation_id'].'</td>';
        echo '<td>'.$entry_info['module_type'].'</td>';
        echo '<td>'.$entry_info['warn_msg'].'</td>';
        echo '<td style="color:red;">'.$entry_info['end_date'].'</td>';
    }
    echo '</table>';
}
die();
/*
$smarty->assign("LISTHEADER", $listview_header);
$smarty->assign("LISTENTITY", $listview_entries);
$smarty->assign("SEARCHTYPE", "1");
global $startTime;
	$endTime = microtime(); 
	$smarty->assign("RUNTIME", round( microtime_diff($startTime, $endTime),2));
			
	if(isset($_REQUEST["mode"]) && $_REQUEST["mode"] == "ajax"){
    $smarty->display("ListViewEntries.tpl");
}else
{
    $smarty->display("ListView.tpl");
}
*/
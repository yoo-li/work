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
    include ('modules/'.$currentModule.'/SheetExportExcel.php');
	die();
}
function GetCategory($depth,$exclude){
	global $supplierid;
    $mall_categorys = XN_Query::create ( 'Content' )->tag('mall_categorys_'.$supplierid)
		    ->filter ( 'type', 'eic', 'mall_categorys')
		    ->filter ( 'my.supplierid',"=",$supplierid)
		    ->filter ( 'my.deleted', '=', 0)
		    ->order("my.sequence",XN_Order::ASC_NUMBER)
		    ->end(-1)
		    ->execute();
	$categorys = array();
	foreach($mall_categorys as $category_info)
	{
		$categoryid = $category_info->id;
		$categorys[$categoryid] = array('pid'=>$category_info->my->pid,'categoryname'=>$category_info->my->categoryname);
	} 
	return Recursion_GetCategory($categorys,0,$depth,$exclude);
}
function Recursion_GetCategory($categorys,$pid,$depth,$exclude)
{ 
    $excludes = explode(',', $exclude); 
    $categoryOption = array();
    $Prefix = "";
    if($depth>0){
        $Prefix = "　┣━";
        for($i=2;$i<=$depth;$i++){
            $Prefix .= "━";
        }
    }
    foreach ($categorys as $categoryid => $info){ 
        if(!in_array($categoryid,$excludes))
		{
			if ($info['pid'] == $pid)
			{
	            $categoryOption['"'.$categoryid.'"'] = $Prefix . $info['categoryname'];
	            $categoryOption = array_merge($categoryOption,Recursion_GetCategory($categorys,$categoryid,$depth+1,$exclude));
			} 
        }
    }
    return $categoryOption;
}

global $currentModule,$supplierid;
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
if (!check_authorize('tezanadmin') && !is_admin($current_user)) 
{	
	global $current_user,$supplierid,$supplierusertype;
	if (isset($supplierid) && $supplierid != "")
	{
		$customviews = XN_Query::create ( 'Content' ) ->tag('customviews')
			->filter ( 'type', 'eic', 'customviews')
			->filter ( 'my.entitytype', '=', 'Mall_Products' )
			->filter ( 'my.viewname', '=' , 'Default')
			->execute();
		if (count($customviews) > 0)
		{
			$customview_info = $customviews[0];
			$viewid = $customview_info->id;
		}
	 
	}
}
$smarty->assign("CUSTOMVIEW_OPTION",$customviewcombo_html);
$smarty->assign("VIEWID", $viewid);
$smarty->assign("MOD", $mod_strings);
$smarty->assign("APP", $app_strings);
$smarty->assign("MODULE",$currentModule);
//Retreive the list from Database
//<<<<<<<<<customview>>>>>>>>>

$queryGenerator = new QueryGenerator($currentModule, $current_user);
if ($viewid != "0") {
	$queryGenerator->initForCustomViewById($viewid);
} else {
	$queryGenerator->initForDefaultCustomView();
}
//<<<<<<<<customview>>>>>>>>>


$search = new DataSearch($currentModule,$queryGenerator,$focus);
$searchpanel = $search->getBasicSearchPanel();

$categoryArray = GetCategory(0,$record);
$categoryOption = '<option value="">全部</option>';

foreach ($categoryArray as $key => $value){
    $key=substr($key,1,-1);
    if(intval($_REQUEST['listcategorys'])==intval($key)){
        $categoryOption .= '<option value='.$key.' selected="selected">'.$value.'</option>';
    }else{
        $categoryOption .= '<option value='.$key.'>'.$value.'</option>';
    }
}
$searchpanel["商品分类"]='<div style="display:block;float:right;width:200px;margin-top:-5px;">
		<select data-toggle="selectpicker" id="listcategorys" name="listcategorys"   style="cursor: pointer;width:180px;">'.$categoryOption.'</select>
        </div>';
		
		
if(isset($_SESSION['minprofitrate']) && $_SESSION['minprofitrate'] !='' &&
	isset($_SESSION['maxprofitrate']) && $_SESSION['maxprofitrate'] !='')
{
    $minprofitrate = $_SESSION['minprofitrate'];
	$maxprofitrate = $_SESSION['maxprofitrate'];
}
else
{
    $minprofitrate = "";
	$maxprofitrate = "";
}
 

$searchpanel["利润区间"]='<input type="text" name="minprofitrate" style="width:75px;" value="'.$minprofitrate.'"  placeholder="请输入下限">-<input type="text" name="maxprofitrate"  value="'.$maxprofitrate.'" style="width:75px;" placeholder="请输入上限">';		
		
		
$smarty->assign('SEARCHPANEL',$searchpanel);

$time = strtotime("today");
$time = strtotime('-1 days',$time);
 
$createnews = XN_Query::create ( 'Content' ) ->tag($focus->table_name)
		->filter ( 'type', 'eic', $focus->table_name)
		->filter ( 'my.createnew', '=', '1' )
		->filter ( 'published', '< ', date("Y-m-d H:i:s",$time))
		->end(-1)
		->execute();
if(count($createnews) > 0)
{
	foreach ( array_chunk($createnews,50,true) as $chunk_fields)
	{
		 XN_Content::delete($chunk_fields,$focus->table_name);
	}
}



$query = XN_Query::create ( 'Content' ) ->tag($focus->table_name)
	->filter ( 'type', 'eic', $focus->table_name)
	->filter ( 'my.deleted', '=', '0' );	

if (isset($_REQUEST['listcategorys']) && $_REQUEST['listcategorys'] != "")
{
	$query->filter ( 'my.categorys', '=', $_REQUEST['listcategorys']);	 
}

$search->setQuery($query);
 

//权限
if (!check_authorize('tezanadmin') && !is_admin($current_user))
{
    if(isset($_SESSION['supplierid']) && $_SESSION['supplierid'] != '')
    {
        $supplierid = $_SESSION['supplierid'];
    }
    else
    {
        $supplierid = "0";
    }
    $query->filter ( 'my.supplierid', '=', $supplierid);
	
    if(isset($_SESSION['vendorid']) && $_SESSION['vendorid'] != '')
    {
        $vendorid= $_SESSION['vendorid'];
		$query->filter ( 'my.vendorid', '=', $vendorid);
    }
	
}else{
    if(isset($_REQUEST['suppliers_search_input']) && trim($_REQUEST['suppliers_search_input'])!=""){
        $suppliers_search_input=$_REQUEST['suppliers_search_input'];
        $suppliers_name=XN_Filter("my.suppliers_name","like",$suppliers_search_input);
        $suppliers_username=XN_Filter("my.suppliers_username","like",$suppliers_search_input);
        $query=XN_Query::create("Content")
            ->tag("suppliers")
            ->filter("type","eic","suppliers")
            ->filter(XN_Filter::any($suppliers_name,$suppliers_username))
            ->filter("my.deleted","=","0")
            ->end(10)
            ->execute();
        if(count($query)){
            $supplierids=array();
            foreach($query as $info){
                $supplierids[]=$info->id;
            }
            $query->filter ( 'my.supplierid', 'in',$supplierids);
        }
    }
}

if(isset($_REQUEST['minprofitrate'])  && isset($_REQUEST['maxprofitrate']) )
{
	if($_REQUEST['minprofitrate'] != "" && $_REQUEST['maxprofitrate'] != "" )
	{
	   	 $_SESSION['minprofitrate'] = $_REQUEST['minprofitrate'];
	   	 $_SESSION['maxprofitrate'] = $_REQUEST['maxprofitrate'];
	   	 $query->filter("my.profitrate", '>=', intval($_REQUEST['minprofitrate']));
	   	 $query->filter("my.profitrate", '<=', intval($_REQUEST['maxprofitrate']));
	}
	else
	{
   	 	$_SESSION['minprofitrate'] = "";
   	 	$_SESSION['maxprofitrate'] = "";
	}
	
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
/*
$pre_url="index.php?module=Mall_PropertyCorrect&action=EditView&from=Mall_Products";
$changeArray['operates']=array(
    "header"=>array('label'=>'修改商品信息','sort'=>false,'width'=>12,'align'=>'center'),
    "orientation"=>"vertical",
    "fieldbase"=>'mall_productsstatus',
    "operate_link"=>array(
        "Agree"=>array("=",array("修改信息"=>$pre_url),"destination"=>array("target"=>"navTab","rel"=>"edit" )),
    )
);
*/
$controller = new ListViewController($current_user, $queryGenerator);
if(isset($supplierid) && $supplierid != ""){
	global $copyrights;
    $changeArray['hideFields']=array("supplierid");


    $listview_header = $controller->getListViewHeader($focus,$currentModule,"",$sorder,$order_by,$changeArray);
    $listview_entries = $controller->getListViewEntries($focus,$currentModule,$list_result,$navigation_array,$changeArray);
	
	$productids = array_keys($listview_entries);
	$inventorys = array();
	if (count($productids) > 0)
	{
		$mall_inventorys= XN_Query::create('Content_Count')->tag('mall_inventorys_'.$supplierid)
			->filter('type','eic','mall_inventorys') 	
			->filter('my.supplierid','=',$supplierid) 								
			->rollup('my.inventory')
			->group('my.productid')   
			->end(-1)
			->execute ();
		foreach($mall_inventorys as $mall_inventory_info)
		{
			$productid = $mall_inventory_info->my->productid;
			$inventory = $mall_inventory_info->my->inventory;
			$inventorys[$productid] = $inventory;
		} 
	} 
	
	foreach($listview_entries as $record=>$entry_info){
		if ($entry_info['mall_productsstatus'] == "审批同意")
		{
			$url='<a data-toggle="navtab" data-fresh="true" data-id="edit" data-title="商品信息修改" href="index.php?module=Mall_PropertyCorrect&action=EditView&from=Mall_Products&record='.$record.'">修改</a>';
			$listview_entries[$record]["operates"]=$url;
			$listview_entries[$record]["realtimeinventory"]=$inventorys[$record];
		} 
		else
		{
			$listview_entries[$record]["operates"]='--';
			$listview_entries[$record]["realtimeinventory"]='--';
		}
	}
}else{
    $hiddenArray=array('hideFields'=>array('operates','realtimeinventory'));
	
    $listview_header = $controller->getListViewHeader($focus,$currentModule,"",$sorder,$order_by,$hiddenArray);
    $listview_entries = $controller->getListViewEntries($focus,$currentModule,$list_result,$navigation_array,$hiddenArray);
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
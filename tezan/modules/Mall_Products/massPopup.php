<?php
/*********************************************************************************
 * The contents of this file are subject to the SugarCRM Public License Version 1.1.2
 * ("License"); You may not use this file except in compliance with the
 * License. You may obtain a copy of the License at http://www.sugarcrm.com/SPL
 * Software distributed under the License is distributed on an  "AS IS"  basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied. See the License for
 * the specific language governing rights and limitations under the License.
 * The Original Code is:  SugarCRM Open Source
 * The Initial Developer of the Original Code is SugarCRM, Inc.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.;
 * All Rights Reserved.
 * Contributor(s): ______________________________________.
 ********************************************************************************/
require_once('Smarty_setup.php');
require_once('include/utils/utils.php');
require_once('XN/MemCache.php');

global $app_strings, $default_charset;
global $currentModule, $current_user,$supplierid,$supplierusertype;

$smarty = new vtigerCRM_Smarty;

$popuptype = $_REQUEST["popuptype"];



$smarty->assign("MOD", $mod_strings);
$smarty->assign("APP", $app_strings);
$smarty->assign("MODULE",$currentModule);



require_once("modules/".$currentModule."/".$currentModule.".php");
$focus = CRMEntity::getInstance($currentModule);




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


$query_content = XN_Query::create ( 'Content' ) ->tag($focus->table_name)
    ->filter ( 'type', 'eic', $focus->table_name)
    ->filter ( 'my.deleted', '=', '0' )
    ->filter ( 'my.hitshelf',"=",'on');


if(isset($_REQUEST['categorys']) &&$_REQUEST['categorys']!=""){
    $category_arr=explode(",",$_REQUEST['categorys']);
    $smarty->assign("categorys",$_REQUEST['categorys']);
    $query_content->filter ("my.categorys","in",$category_arr);
}
if(isset($supplierid) && $supplierid != ""){
    $query_content->filter("my.supplierid","=",$supplierid);
}

$products=array();
if($_REQUEST['selected_products']!=""){
    $selected_product_ids=$_REQUEST['selected_products'];
    $selected_product_array=explode(",",$selected_product_ids);
    $products=array_merge($products,array_filter($selected_product_array));
}
if(count($products)){
    $query_content->filter('id','!in',$products);
}

if(isset($_REQUEST['search_field']) && $_REQUEST['search_field'] != '' && isset($_REQUEST['search_text']) && $_REQUEST['search_text'] != '' )
{
	if ($_REQUEST['search_field'] == "profitrate")
	{
		$search_text = explode("-",$_REQUEST['search_text']);
		if (count($search_text) == 2)
		{
			$query_content->filter ( 'my.'.$_REQUEST['search_field'], '>', intval($search_text[0]) );
			$query_content->filter ( 'my.'.$_REQUEST['search_field'], '<', intval($search_text[1]) );
			$smarty->assign("SEARCH_FIELD",$_REQUEST['search_field']);
			$smarty->assign("SEARCH_TEXT",$_REQUEST['search_text']);
		}
		else
		{
			$query_content->filter ( 'my.'.$_REQUEST['search_field'], 'like', $_REQUEST['search_text'] );
			$smarty->assign("SEARCH_FIELD",$_REQUEST['search_field']);
			$smarty->assign("SEARCH_TEXT",$_REQUEST['search_text']);
		}
		
	}
	else
	{
		$query_content->filter ( 'my.'.$_REQUEST['search_field'], 'like', $_REQUEST['search_text'] );
		$smarty->assign("SEARCH_FIELD",$_REQUEST['search_field']);
		$smarty->assign("SEARCH_TEXT",$_REQUEST['search_text']);
	}
    
}
if(isset($_REQUEST['filter']) && $_REQUEST['filter'] != '')
{
    $filter = unserialize(base64_decode($_REQUEST['filter']));
    $query_content->filter($filter);
}

if(isset($_REQUEST['exclude']) && $_REQUEST['exclude'] != '' && $_REQUEST['exclude'] != 'undefined')
{
    $exclude_list = explode(",",$_REQUEST['exclude']);
    $smarty->assign("EXCLUDE",$_REQUEST['exclude']);
    if ($currentModule != 'Users')
        $query_content->filter ( 'id', '!in', $exclude_list );
    else
        $query_content->filter ( 'my.profileid', '!in', $exclude_list );
    $url_string .='&exclude='.$_REQUEST['exclude'];
}

if(isset($_REQUEST['query']) && $_REQUEST['query'] == 'true')
{
    list($where, $ustring) = explode("#@@#",getWhereCondition($currentModule,$query_content));
    $url_string .="&query=true".$ustring;
}

if(isset($where) && $where != '')
{
    $query .= ' and '.$where;
}
//Added to fix the issue #2307 



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
    $order_by = $focus->default_order_by;
}
////////////////////////////////
if($_REQUEST['_sort'] != '' && $_REQUEST['_sort'] != $_SESSION[$upperModule.'_SORT_ORDER'])
{
    $sorder= $_REQUEST['_sort'];
    $_SESSION[$upperModule.'_SORT_ORDER'] = $order_by;
}
else if(isset($_SESSION[$upperModule.'_SORT_ORDER']) && $_SESSION[$upperModule.'_SORT_ORDER'] != "")
{
    $sorder = $_SESSION[$upperModule.'_SORT_ORDER'];
}
else
{
    $sorder = $focus->default_sort_order;
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
        $query_content->order($query_order_by,XN_Order::DESC_NUMBER);
    }
    else
    {
        $query_content->order($query_order_by,XN_Order::DESC);
    }
    $smarty->assign("ORDER", "desc");
}
else
{
    if (isset($focus->sortby_number_fields) && in_array($order_by,$focus->sortby_number_fields))
    {
        $query_content->order($query_order_by,XN_Order::ASC_NUMBER);
    }
    else
    {
        $query_content->order($query_order_by,XN_Order::ASC);
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
$query_content->begin($limit_start_rec);
$query_content->end($numperpage+$limit_start_rec);
$list_result = $query_content->execute();
$noofrows = $query_content->getTotalCount();
$smarty->assign('NOOFROWS',$noofrows);


$listview_header_search=getSearchListHeaderValues($focus,$currentModule);
$smarty->assign("SEARCHLISTHEADER", $listview_header_search);


$listview_header = getSearchListViewHeader($focus,$currentModule,$url_string,$sorder,$order_by);
$smarty->assign("LISTHEADER", $listview_header);

$listview_entries = getSearchListViewEntries($focus,$currentModule,$list_result);
 

if(isset($_REQUEST['selected_products']) && $_REQUEST['selected_products']!=""){
    foreach($listview_entries as $product_id=>$info){
        $product_propertys=XN_Query::create("Content")
            ->tag("mall_product_property")
            ->filter("type","=","mall_product_property")
            ->filter("my.productid","=",strval($product_id))
            ->filter("my.deleted","=","0")
            ->end(1)
            ->execute();
        if(count($product_propertys)){
            $property_array=array();
            foreach($product_propertys as $property_info){
                $property_array[]=$property_info->id;
            }
            if(count($selected_property_array)){
                $diff=array_diff($property_array,$selected_property_array);
                if(empty($diff)){
                    unset($listview_entries[$product_id]);
                }
            }
        }
        else
        {
            if(in_array($product_id,$selected_product_array)){
                unset($listview_entries[$product_id]);
            }
        }
    }
}
//print_r($listview_entries);exit();
$smarty->assign("LISTENTITY", $listview_entries);

$smarty->assign("CALLBACK", $_REQUEST['callback']);
$smarty->assign("MODULE", $currentModule);
$smarty->assign("POPUPTYPE", $_REQUEST["popuptype"]);
$smarty->assign("RECORDID", $_REQUEST["recordid"]);
$smarty->assign("EXCLUDE", $_REQUEST["exclude"]);
$smarty->assign("PARENT_MODULE", $_REQUEST['parent_module']);
$smarty->assign("FILTER", $_REQUEST["filter"]);


if(isset($_REQUEST["mode"]) && $_REQUEST["mode"] == "ajax"){
    $smarty->display("massPopupListViewEntries.tpl");
}
else
{
	$categorys = GetCategory(0,"");
	$smarty->assign("SEARCHCATEGORYS", $categorys);
	$smarty->display("massPopup.tpl");
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
    $result=array();
    $result[''] = "全部";
    Recursion_GetCategory($result,$categorys,0,$depth,$exclude);
    return $result;
    //return Recursion_GetCategory($categorys,0,$depth,$exclude);
}
function Recursion_GetCategory(&$categoryOption,$categorys,$pid,$depth,$exclude)
{ 
    $excludes = explode(',', $exclude); 
    //$categoryOption = array();
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
	            $categoryOption[$categoryid] = $Prefix . $info['categoryname'];
	            Recursion_GetCategory($categoryOption,$categorys,$categoryid,$depth+1,$exclude);
			} 
        }
    }
    return $categoryOption;
}

?>

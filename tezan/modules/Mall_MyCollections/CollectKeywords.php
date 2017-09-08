<?php

global $currentModule;
require_once('Smarty_setup.php');
require_once('include/utils/utils.php');
require_once('include/utils/DataSearch.php');
require_once('modules/CustomView/CustomView.php');


global $app_strings,$mod_strings,$current_language;
$current_module_strings = return_module_language($current_language, $currentModule);


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

$upperModule = 'POPULARIZESTATISTICS';


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
	$order_by = "published";
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
	$sorder = "DESC";
}


//<<<<<<<<<<<<<<<<<<< sorting - stored in session >>>>>>>>>>>>>>>>>>>>


$smarty->assign("MOD", $mod_strings);
$smarty->assign("APP", $app_strings);
$smarty->assign("MODULE",$currentModule);
//Retreive the list from Database
//<<<<<<<<<customview>>>>>>>>>

$query = XN_Query::create('Content_Count')->tag('Mall_MyCollections')
    ->filter('type','=','mall_mycollections')
    ->filter ( 'my.deleted', '=', 0 )
    ->rollup()
    ->group('my.productid')
    ->order("my.count",XN_Order::DESC);

if (isset($supplierid) &&  $supplierid != "" && $supplierid != "0")
{ 
    $query->filter ( 'my.supplierid', '=', $supplierid);
}  
 
$smarty->assign("PAGENUM", 1);
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

$list_entries = array();



$list_entries['productid'] = array('label' => '收藏商品名称','sort'=> true,'width' => 60,'align' => "center" );
$list_entries['shoucangcount'] = array('label' => '收藏数','sort'=> false,'width' => 40,'align' => "center" );

$smarty->assign("LISTHEADER",$list_entries);


function getStdOutput($list_result, $list_entries,$start,$end)
{ 
	$return_data = array();
	$pos = 0;
	$productids = array();
	foreach($list_result as $info)
	{
	    $productid = $info->my->productid;
	    $productids[] = $productid;
	}
	$productnames = array();
	if (count($productids) > 0)
	{
		$products = XN_Content::loadMany(array_unique($productids),'mall_products');
		foreach($products as $product_info)
		{
			$productnames[$product_info->id] = $product_info->my->productname;
		}
	}
	 
	foreach($list_result as $info)
	{
	    $productid = $info->my->productid;
	    if($productid != ""){
    		$standCustFld = array();
    		foreach(array_keys($list_entries) as $field)
    		{
    			if ($field != 'oper')
    			{
    				if($field == "shoucangcount"){
    				    $standCustFld[]= $info->my->count; 
    				}elseif($field == 'productid'){ 
    				    $standCustFld[] = '<a rel="Mall_Products" target="navTab" href="index.php?module=Mall_Products&action=EditView&record='.$productid.'" title="产品">'.$productnames[$productid].'</a>';
    				}else
    				{
    					$standCustFld[]= $info->my->$field;
    				}
    			}
    		}
    		$return_data[]=$standCustFld;
	    }
		if ($pos > 100) break;
		$pos++;
	}
	return $return_data;
}


$smarty->assign("LISTENTITY",getStdOutput($list_result, $list_entries,$published_startdate,$published_enddate));
/*
if($invitecount>0 || $membercount>0)
    $smarty->assign("CUSTOMSHOWMSG", "<font color=blue>&nbsp;&nbsp;&nbsp;&nbsp;邀请码总计：".$invitecount . "&nbsp;&nbsp;&nbsp;&nbsp;会员注册总计：" . $membercount ."</font>");

$searchpanel = array();

$searchpanel['激活日期'] = '<div style="float:left;line-height: 23px;"><a href="#" id="popularize_ipaddress_thisyear" for="popularize_ipaddress_period">本年</a>&nbsp;
					<a href="#" id="popularize_ipaddress_thisquater" for="popularize_ipaddress_period">本季</a>&nbsp;
					<a href="#" id="popularize_ipaddress_thismonth" for="popularize_ipaddress_period">本月</a>&nbsp;</div>
					<span><input style="float:left;width:75px" value="'.$published_startdate.'" type="text" id="popularize_ipaddress_startdate" name="popularize_ipaddress_startdate" class="date" dateFmt="yyyy-MM-dd" readonly="true"/><a class="inputDateButton" href="javascript:;">选择</a></span>
					<div style="float:left">_</div>
					<span><input style="float:left;width:75px" value="'.$published_enddate.'" type="text" id="popularize_ipaddress_enddate" name="popularize_ipaddress_enddate" class="date" dateFmt="yyyy-MM-dd" readonly="true"/><a class="inputDateButton" href="javascript:;">选择</a></span>

<script type="text/javascript">
function popularize_ipaddress_period_onclick()
{
	jQuery(\'a[for="popularize_ipaddress_period"]\').toggleClass("over",false);
	jQuery(this).addClass("over");
	var dt = new Date();

	if (jQuery(this).attr("id")=="popularize_ipaddress_thisyear")
	{
		var start = dt.getFullYear() + "-01-01";
		var end = dt.getFullYear() + "-12-31";
	}
	else if (jQuery(this).attr("id")=="popularize_ipaddress_thisquater")
	{
		var nowMonth = dt.getMonth()+1;
		if (nowMonth<=3)
		{
			var start = dt.getFullYear() + "-01-01";
			var end = dt.getFullYear() + "-3-31";
		}
		else if(3<nowMonth && nowMonth<7)
		{
			var start = dt.getFullYear() + "-04-01";
			var end = dt.getFullYear() + "-6-30";
		}
		else if(6<nowMonth && nowMonth<10)
		{
			var start = dt.getFullYear() + "-07-01";
			var end = dt.getFullYear() + "-9-31";
	    }
	    else
	   {
	      var start = dt.getFullYear() + "-10-01";
		  var end = dt.getFullYear() + "-12-31";
	   }
	}
	else
	{
		var nowMonth = dt.getMonth()+1;
		var start = dt.getFullYear() + "-" +nowMonth+ "-01";
		var end = dt.getFullYear() + "-" +nowMonth+ "-" + dt.getDate();
	}
	jQuery("#popularize_ipaddress_startdate").val(start);
	jQuery("#popularize_ipaddress_enddate").val(end);
}
jQuery(document).ready(function()
{
	jQuery("#popularize_ipaddress_thisyear").click(popularize_ipaddress_period_onclick);
	jQuery("#popularize_ipaddress_thisquater").click(popularize_ipaddress_period_onclick);
	jQuery("#popularize_ipaddress_thismonth").click(popularize_ipaddress_period_onclick);

});
</script>';

if ($profile_search_input != "")
{
	$searchpanel['IP地址'] = '<span class="ph-label" style="display:none;"  onclick="$(this).css(\'display\',\'none\');$(\'#popularize_ipaddress_input\').focus();">输入IP地址查询……</span><input  class="search-text" type="text"  value="'.$profile_search_input.'" id="popularize_ipaddress_input" name="popularize_ipaddress_input"  onFocus="$(\'.ph-label\').css(\'display\',\'none\');" onBlur="if (this.value == \'\') $(\'.ph-label\').css(\'display\',\'inline\');">';
}
else
{
    $searchpanel['IP地址'] = '<span class="ph-label" onclick="$(this).css(\'display\',\'none\');$(\'#popularize_ipaddress_input\').focus();">输入IP地址查询……</span><input  class="search-text" type="text"  value="" id="popularize_ipaddress_input" name="popularize_ipaddress_input"  onFocus="$(\'.ph-label\').css(\'display\',\'none\');" onBlur="if (this.value == \'\') $(\'.ph-label\').css(\'display\',\'inline\');">';
}

*/

$smarty->assign('SEARCHPANEL',$searchpanel);

$listview_check_button = array();


$smarty->assign("LISTVIEW_CHECK_BUTTON", $listview_check_button);
$smarty->assign("ACTION", "CollectKeywords");
$smarty->display("Settings/ListTabView.tpl");



?>

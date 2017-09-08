<?php


global $currentModule;
require_once('Smarty_setup.php'); 
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

$upperModule = strtoupper($currentModule);


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

global $supplierid,$supplierusertype;
$query = XN_Query::create ( 'Content' ) ->tag("ma_deliverycontract")
	->filter ( 'type', 'eic', 'ma_deliverycontract');	

$query->filter ( 'my.deleted', '=', '0' ); 
//$query->filter ( 'my.supplierid', '=', $supplierid);
	if($supplierusertype!="admin" && $supplierusertype!="superadmin"){
		$query->filter(XN_Filter::any(XN_Filter("my.submit_id","=",$supplierid),XN_Filter("my.delivery_id","=",$supplierid)));
	}

if (isset($_REQUEST['reportsintegrated_published_thistype']) && 
	$_REQUEST['reportsintegrated_published_thistype'] != "all" &&
	isset($_REQUEST['published_enddate']) &&
	isset($_REQUEST['published_startdate']))
{
	$_SESSION['PUBLISHED_THISTYPE']= $_REQUEST['reportsintegrated_published_thistype'];
	$_SESSION['PUBLISHED_STARTDATE'] = $_REQUEST['published_startdate'];
	$_SESSION['PUBLISHED_ENDDATE'] = $_REQUEST['published_enddate']; 
}

if (isset($_REQUEST['published_enddate']) && $_REQUEST['published_enddate'] != '' &&
	isset($_REQUEST['published_startdate']) && $_REQUEST['published_startdate'] != '')
{
	$published_enddate = $_REQUEST['published_enddate'];
	$published_startdate = $_REQUEST['published_startdate'];
	$query->filter('published','>=',$published_startdate." 00:00:00");
	$query->filter('published','<=',$published_enddate." 23:59:59");  
}  
elseif (isset($_SESSION['PUBLISHED_STARTDATE']) && $_SESSION['PUBLISHED_STARTDATE'] != '' && 
	    isset($_SESSION['PUBLISHED_ENDDATE']) && $_SESSION['PUBLISHED_ENDDATE'] != '' && 
		$_REQUEST['reportsintegrated_published_thistype'] != "all" )
{ 
	$published_startdate = $_SESSION['PUBLISHED_STARTDATE']; 
	$published_enddate = $_SESSION['PUBLISHED_ENDDATE'];  
	$query->filter('published','>=',$published_startdate." 00:00:00");
	$query->filter('published','<=',$published_enddate." 23:59:59");  
} 
else
{ 
	$published_startdate = ''; 
	$published_enddate = ''; 
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

$list_entries = array();
$list_entries['submit_id'] = array('label' => '委托方','sort'=> false,'width' => 12,'align' => "center" );
$list_entries['delivery_id'] = array('label' => '被委托方','sort'=> false,'width' => 12,'align' => "center" );
$list_entries['ma_deliverycontract_no'] = array('label' => '协议编号','sort'=> true,'width' => 20,'align' => "center" );
$list_entries['execute'] = array('label' => '经手人','sort'=> true,'width' => 12,'align' => "center" );
$list_entries['entrust_type'] = array('label' => '委托类型','sort'=> true,'width' => 12,'align' => "center" ); 
$list_entries['begin_date'] = array('label' => '开始委托时间','sort'=> true,'width' => 12,'align' => "center" );
$list_entries['end_date'] = array('label' => '结束委托时间','sort'=> true,'width' => 12,'align' => "center" );
//$list_entries['oper'] = array('label' => '委托范围','sort'=> true,'width' => 12,'align' => "center" );
$list_entries['oper'] = array('label' => '操作','sort'=> true,'width' => 12,'align' => "center" );

$smarty->assign("LISTHEADER",$list_entries);



function getStdOutput($list_result, $list_entries)
{
	$usernameids = array();
	$deliveryids = array();
	$submitids = array();
	foreach($list_result as $info)
	{ 
		$usernameids[] = $info->my->execute;
		$deliveryids[] = $info->my->delivery_id;
		$submitids[] = $info->my->submit_id;
	}
	$usernames = getUserNameList(array_unique($usernameids));
	
	$delivery_contents = XN_Content::loadMany(array_unique($deliveryids),"ma_suppliers");
	$deliverys = array();
	foreach($delivery_contents as $delivery_content_info)
	{
		$deliverys[$delivery_content_info->id] = $delivery_content_info->my->nickname;
	}
	$ss = XN_Content::loadMany(array_unique($submitids),"ma_suppliers");
	$s = array();
	foreach($ss as $s_info)
	{
		$s[$s_info->id] = $s_info->my->nickname;
	}
	require_once "modules/PickList/PickListUtils.php";
	$entrust_types = getAssignedPicklistValues('entrust_type');
	
	
	
	$return_data = array();
	foreach($list_result as $info)
	{
		$standCustFld = array();
		foreach(array_keys($list_entries) as $field)
		{
			if ($field == "execute")
			{
				$standCustFld[]= $usernames[$info->my->$field];
			}
			else if ($field == "delivery_id")
			{
				$standCustFld[]= $deliverys[$info->my->$field];
			}
			else if ($field == "submit_id")
			{
				$standCustFld[]= $s[$info->my->$field];
			}
			else if ($field == "entrust_type")
			{
				$standCustFld[]= $entrust_types[$info->my->$field];
			}
			else if ($field == "oper")
			{ 
				//$categoryids = explode(';', $info->my->ma_categorys);
//				$viewcategorys = '<a data-title="操作"  data-height="560" data-width="800" data-resizable="false" data-maxable="false" data-mask="true"  data-toggle="dialog" title="操作" href="index.php?module=Ma_DeliveryContract&action=EditView&record='.$info->id.'" ><i class="fa fa-file-text-o"></i> 查看委托范围</a>';
				$viewcategorys = '<a rel="edit" target="navTab" href="index.php?module=Ma_DeliveryContract&action=EditView&record='.$info->id.'&type=baobiao" title="查看委托协议" data-toggle="navtab" data-fresh="true" data-id="edit" data-title="委托协议信息"><i class="fa fa-file-text-o"></i></a>';
				$standCustFld[] = $viewcategorys;
			}
			
			else
			{
				$standCustFld[]= $info->my->$field;
			}
			
		}
		$return_data[$info->id]=$standCustFld;
	}
	return $return_data;
}

$smarty->assign("LISTENTITY",getStdOutput($list_result, $list_entries));



$searchpanel = array();
if (isset($_REQUEST['reportsintegrated_published_thistype']))
{
	$thistype = $_REQUEST['reportsintegrated_published_thistype']; 
}
else if ( isset($_SESSION['PUBLISHED_THISTYPE']) && $_SESSION['PUBLISHED_THISTYPE'] != '' )
{
	$thistype = $_SESSION['PUBLISHED_THISTYPE'];  
}
else
{
	$thistype = "";  
} 

 

$searchpanel['操作日期'] = '<a href="javascript:;" id="reportsintegrated_published_all" for="reportsintegrated_published_period" '.(($thistype == 'all'?'class="over"':'')).' title="全部">全部</a>
						<a href="javascript:;" id="reportsintegrated_published_thisyear" for="reportsintegrated_published_period" '.(($thistype == 'thisyear'?'class="over"':'')).'  title="本年">本年</a>
						<a href="javascript:;" id="reportsintegrated_published_thisquater" for="reportsintegrated_published_period" '.(($thistype == 'thisquater'?'class="over"':'')).'  title="本季">本季</a>
						<a href="javascript:;" id="reportsintegrated_published_thismonth" for="reportsintegrated_published_period" '.(($thistype == 'thismonth'?'class="over"':'')).'  title="本月">本月</a>
						<a href="javascript:;" id="reportsintegrated_published_recently" for="reportsintegrated_published_period" '.(($thistype == 'recently'?'class="over"':'')).' title="最近">最近</a>
						<input type="text" name="published_startdate" id="reportsintegrated_published_startdate" value="'.$published_startdate.'" readonly data-toggle="datepicker" data-rule="date" size="11">
						-
						<input type="text" name="published_enddate" id="reportsintegrated_published_enddate" value="'.$published_enddate.'" readonly data-toggle="datepicker" data-rule="date" size="11">
						<input value="'.$thistype.'" type="hidden" id="reportsintegrated_published_thistype" name="reportsintegrated_published_thistype" />
						<br/>
						<a  class="btn btn-default" data-toggle="dialog" data-icon="print" data-mask="true" data-maxable="false" data-resizable="false" data-width="900" data-height="600" href="index.php?module='.$module.'&action=DeliverySummaryPrint&oper=view&record='.$focus->id.'" > 打印</a>';
 


$smarty->assign('SEARCHPANEL',$searchpanel);

$listview_check_button = array();

$smarty->assign("LISTVIEW_CHECK_BUTTON", $listview_check_button);
$smarty->assign("ACTION", "DeliverySummary");
$smarty->display("Settings/ListTabView.tpl");

?>


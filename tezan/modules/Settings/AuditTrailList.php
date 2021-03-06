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


$query = XN_Query::create ( 'BigContent' ) ->tag("audit_trials")
	->filter ( 'type', 'eic', 'audit_trials');	

if($_REQUEST['author'] != '' && $_REQUEST['author'] != "")
{
	$author = $_REQUEST['author'];
	$users = explode(";",$author);
	$query->filter ( 'my.userid', 'in', $users );
	$user_name = $_REQUEST['author_Name'];
}
else
{
	$author = XN_Profile::$VIEWER;
	$user_name = getUserNameByProfile($author);
	$query->filter ( 'my.userid', '=', $author );
}


$published_startdate = "";
$published_enddate = "";
if(isset($_REQUEST['published_startdate']) && $_REQUEST['published_startdate'] != '' && isset($_REQUEST['published_enddate']) && $_REQUEST['published_enddate'] != '')
{
	$published_startdate = $_REQUEST['published_startdate'];
	$published_enddate = $_REQUEST['published_enddate'];
	$query->filter ( 'published', '>=', $_REQUEST['published_startdate'].' 00:00:00' )
		  ->filter ( 'published', '<=', $_REQUEST['published_enddate'].' 23:59:59' );
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

$list_entries['userid'] = array('label' => getTranslatedString('LBL_LIST_USER_NAME'),'sort'=> false,'width' => 20,'align' => "center" );
$list_entries['module'] = array('label' => getTranslatedString('LBL_MODULE'),'sort'=> true,'width' => 20,'align' => "center" );
$list_entries['action'] = array('label' => getTranslatedString('LBL_ACTION'),'sort'=> true,'width' => 20,'align' => "center" );
$list_entries['recordid'] = array('label' => getTranslatedString('LBL_RECORD_ID'),'sort'=> true,'width' => 20,'align' => "center" );
$list_entries['actiondate'] = array('label' => getTranslatedString('LBL_ACTION_DATE'),'sort'=> true,'width' => 20,'align' => "center" );

$smarty->assign("LISTHEADER",$list_entries);

function getStdOutput($list_result, $list_entries)
{
	$return_data = array();
	$userids = array();
	foreach($list_result as $info)
	{
		$userids[] = $info->my->userid;
	}
	$userids = array_unique($userids);
	
	if (count($userids > 0))
	{
		$usenames = getUserNameList($userids);
	}

	foreach($list_result as $info)
	{
		$standCustFld = array();
		foreach(array_keys($list_entries) as $field)
		{
			if ($field == "userid")
			{
				$standCustFld[]= $usenames[$info->my->$field];
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


$published_startdate = date("Y-m-d");
$published_enddate = date("Y-m-d");

$searchpanel = array();

$searchpanel['操作日期'] = '<a href="javascript:;" id="listviewpublished__thisyear" for="listviewpublished__period"
  title="本年">本年</a>
					<a href="javascript:;" id="listviewpublished__thisquater" for="listviewpublished__period"
  title="本季">本季</a>
					<a href="javascript:;" id="listviewpublished__thismonth" for="listviewpublished__period"
  title="本月">本月</a>
					<a href="javascript:;" id="listviewpublished__recently" for="listviewpublished__period"
 class="over" title="最近">最近</a>
					<input type="text" name="published_startdate" id="listviewpublished__startdate" value="'.$published_startdate.'"
 readonly data-toggle="datepicker" data-rule="date" size="11">
					-
					<input type="text" name="published_enddate" id="listviewpublished__enddate" value="'.$published_enddate.'"
 readonly data-toggle="datepicker" data-rule="date" size="11">
					<input value="recently" type="hidden" id="listviewpublished__thistype" name="listviewpublished__thistype"
 />
					<script type="text/javascript">
						$(document).ready(function()
						{
							$(\'a[for="listviewpublished__period"]\').each(function(){
								$(this).click(listviewpublished__period_onclick);
								});
						});
						$("#listviewpublished__startdate").on("afterchange.bjui.datepicker", function(e, data) {
							$("#listviewpublished__thistype").val("");
							$(\'a[for="listviewpublished__period"]\').toggleClass("over",false);
						});
						$("#listviewpublished__enddate").on("afterchange.bjui.datepicker", function(e, data) {
							$("#listviewpublished__thistype").val("");
							$(\'a[for="listviewpublished__period"]\').toggleClass("over",false);
						});
						function listviewpublished__period_onclick() {
							$(\'a[for="listviewpublished__period"]\').toggleClass("over",false);
							$(this).addClass("over");	
							var dt = new Date();
		
							if ($(this).attr("id")=="listviewpublished__thisyear") 
							{
								var start = dt.getFullYear() + "-01-01";
								var end = dt.getFullYear() + "-12-31";
								$("#listviewpublished__thistype").val("thisyear");
							}
							else if ($(this).attr("id")=="listviewpublished__thisquater") 
							{
								var nowMonth = dt.getMonth()+1; 
								if (nowMonth<=3) 
								{    
									var start = dt.getFullYear() + "-01-01";
									var end = dt.getFullYear() + "-03-31";   
								}
								else if(3<nowMonth && nowMonth<7)
								{     
									var start = dt.getFullYear() + "-04-01";
									var end = dt.getFullYear() + "-06-30";     
								}
								else if(6<nowMonth && nowMonth<10)
								{    
									var start = dt.getFullYear() + "-07-01";
									var end = dt.getFullYear() + "-09-30";     
							    }     
							    else
							   {   
							      var start = dt.getFullYear() + "-10-01";
								  var end = dt.getFullYear() + "-12-31";     
							   }
							   $("#listviewpublished__thistype").val("thisquater");
							}
							else if ($(this).attr("id")=="listviewpublished__recently") 
							{
						      var start = "2016-01-05";
							  var end = "2016-02-05";
							  $("#listviewpublished__thistype").val("recently");
							}
							else 
							{
								var nowMonth = dt.getMonth()+1; 
								if(nowMonth < 10){
									nowMonth = "0" + nowMonth;
								}
								var nowDay = dt.getDate();
								if(nowDay < 10){
									nowDay = "0" + nowDay;
								}
								var start = dt.getFullYear() + "-" + nowMonth + "-01";
								var end = dt.getFullYear() + "-" + nowMonth + "-" + nowDay;
								$("#listviewpublished__thistype").val("thismonth");
							}
							$("#listviewpublished__startdate").val(start);
							$("#listviewpublished__enddate").val(end);
						}
					</script>';

$searchpanel['操作用户'] = '<input type="hidden" value="" name="roleid.id" id="roleid_id">
						<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;">
							<input type="text" name="roleid.name" id="roleid_name" value="全部" size="15" style="padding-right
: 15px;" readonly>
							<a class="bjui-lookup" data-toggle="lookupbtn" data-newurl="" data-oldurl="index.php?module=Public
&action=SelectRole&mode=checkbox&roleid=" data-url="index.php?module=Public&action
=SelectRole&mode=checkbox&roleid=" data-group="roleid" data-maxable="false" data-title
="请选择用户"  data-width="300" data-height="300" href="javascript:;" style="height: 22px; line-height: 22px
;">
								<i class="fa fa-search"></i>
							</a>
						</span>';
 


$smarty->assign('SEARCHPANEL',$searchpanel);

$listview_check_button = array();

global $global_session;
$audit_trail  = $global_session['audit_trail']; 

if ($audit_trail == 'true')
{
	$listview_check_button[] = '<a class="btn btn-default" data-icon="toggle-on" data-toggle="doajax" data-callback="refresh" href="index.php?module=Settings&action=SaveAuditTrail&ajax=true&audit=disabled"  >'.getTranslatedString('LBL_CLOSE_AUDITTRAIL_BUTTON_LABEL').'</a>';
}
else
{
	$listview_check_button[] = '<a class="btn btn-default" data-icon="toggle-off" data-toggle="doajax" data-callback="refresh" href="index.php?module=Settings&action=SaveAuditTrail&ajax=true&audit=enabled"  >'.getTranslatedString('LBL_OPEN_AUDITTRAIL_BUTTON_LABEL').'</a>';
}

$smarty->assign("LISTVIEW_CHECK_BUTTON", $listview_check_button);
$smarty->assign("ACTION", "AuditTrailList");
$smarty->display("Settings/ListTabView.tpl");

?>

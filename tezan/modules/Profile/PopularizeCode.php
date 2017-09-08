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
 
$smarty->assign("NUMPERPAGE", 100);

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

// $query = XN_Query::create ( 'Profile' ) ->tag("profile")
// 	->filter('type','=','wxuser')
//     ->filter('invitationcode','!=','');
// 	->filter ('activationdate','!=','');
$query = XN_Query::create('Profile_Count')->tag('profile')
    ->filter('type','=','wxuser')
    ->filter('invitationcode','!=','')
    ->rollup()
    ->group('invitationcode')
    ->order("count",XN_Order::DESC_NUMBER);

if(isset($_REQUEST['popularize_code_input']) && $_REQUEST['popularize_code_input'] != '' )
{
	$profile_search_input = $_REQUEST['popularize_code_input'];
	$query->filter('invitationcode','like',$profile_search_input);
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

$published_startdate = date('Y-m-d');
$published_enddate = date('Y-m-d');
if(isset($_REQUEST['published_startdate']) && $_REQUEST['published_startdate'] != '' && isset($_REQUEST['published_enddate']) && $_REQUEST['published_enddate'] != '')
{
    $published_startdate = $_REQUEST['published_startdate'];
    $published_enddate = $_REQUEST['published_enddate'];
	$query->filter ( 'activationdate', '>=', date('Y-m-d H:i:s',strtotime($published_startdate.' 00:00:00' )))
   		  ->filter ( 'activationdate', '<=', date('Y-m-d H:i:s',strtotime($published_enddate.' 23:59:59' )));
}
else
{
	$published_enddate = strtotime("today");
	$published_startdate = strtotime('-1 month',strtotime("today"));
	$query->filter ( 'activationdate', '>=', date('Y-m-d H:i:s',$published_startdate  ))
		->filter ( 'activationdate', '<=', date('Y-m-d H:i:s',$published_enddate  ));

}
 
$query->begin(0);
$query->end(-1);

$list_result = $query->execute();
$noofrows = $query->getTotalCount();

$smarty->assign('NOOFROWS',100);

$list_entries = array();

// $list_entries['username'] = array('label' => '推广人','sort'=> false,'width' => 10,'align' => "center" );
// $list_entries['mobile'] = array('label' => '推广人手机','sort'=> false,'width' => 10,'align' => "center" );
$list_entries['invitationcode'] = array('label' => '邀请码','sort'=> false,'width' => 50,'align' => "center" );
$list_entries['membercount'] = array('label' => '激活数','sort'=> false,'width' => 50,'align' => "center" );

$smarty->assign("LISTHEADER",$list_entries);

function getStdOutput($list_result, $list_entries,$start,$end,&$invitecount,&$membercount)
{
    $pos = 0;
	$return_data = array();
	foreach($list_result as $info)
	{
	    $invitationcode = $info->my->invitationcode;
	    if($invitationcode != "" && is_numeric($invitationcode) && $invitationcode != "881138"){
    		$standCustFld = array();
    		foreach(array_keys($list_entries) as $field)
    		{
    			if ($field != 'oper')
    			{
    				if($field == "membercount"){
    				    $standCustFld[]= $info->my->count; 
    				}elseif($field == 'invitationcode'){
						$standCustFld[] = '<a data-id="Profile"  href="index.php?module=Profile&action=index&parenttab=B2C&profile_search_input='.$invitationcode.'" data-toggle="navtab" data-title="会员['.$invitationcode.']">'.$invitationcode.'</a>';
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

$invitecount = 0;
$membercount = 0;
$smarty->assign("LISTENTITY",getStdOutput($list_result, $list_entries,$published_startdate,$published_enddate,$invitecount,$membercount));

if($invitecount>0 || $membercount>0)
    $smarty->assign("CUSTOMSHOWMSG", "<font color=blue>&nbsp;&nbsp;&nbsp;&nbsp;邀请码总计：".$invitecount . "&nbsp;&nbsp;&nbsp;&nbsp;会员注册总计：" . $membercount ."</font>");

$searchpanel = array();

$searchpanel['激活日期'] = '<a href="javascript:;" id="popularizecodepublished_all" for="popularizecodepublished_period"  title="全部">全部</a>
					<a href="javascript:;" id="popularizecodepublished_thisyear" for="popularizecodepublished_period"  title="本年">本年</a>
					<a href="javascript:;" id="popularizecodepublished_thisquater" for="popularizecodepublished_period"  title="本季">本季</a>
					<a href="javascript:;" id="popularizecodepublished_thismonth" for="popularizecodepublished_period"  title="本月">本月</a>
					<a href="javascript:;" id="popularizecodepublished_recently" for="popularizecodepublished_period" class="over" title="最近">最近</a>
					<input type="text" name="published_startdate" id="popularizecodepublished_startdate" value="2016-05-01" readonly data-toggle="datepicker" data-rule="date" size="11">
					-
					<input type="text" name="published_enddate" id="popularizecodepublished_enddate" value="2016-06-01" readonly data-toggle="datepicker" data-rule="date" size="11">
					<input value="recently" type="hidden" id="popularizecodepublished_thistype" name="popularizecodepublished_thistype" />
					<script type="text/javascript">
						$(document).ready(function()
						{
							$(\'a[for="popularizecodepublished_period"]\').each(function(){
								$(this).click(popularizecodepublished_period_onclick);
								});
						});
						$("#popularizecodepublished_startdate").on("afterchange.bjui.datepicker", function(e, data) {
							$("#popularizecodepublished_thistype").val("");
							$(\'a[for="popularizecodepublished_period"]\').toggleClass("over",false);
						});
						$("#popularizecodepublished_enddate").on("afterchange.bjui.datepicker", function(e, data) {
							$("#popularizecodepublished_thistype").val("");
							$(\'a[for="popularizecodepublished_period"]\').toggleClass("over",false);
						});
						function popularizecodepublished_period_onclick() {
							$(\'a[for="popularizecodepublished_period"]\').toggleClass("over",false);
							$(this).addClass("over");
							var dt = new Date();
		                    if ($(this).attr("id")=="popularizecodepublished_all"){
								var start = "";
								var end = "";
		                        $("#popularizecodepublished_thistype").val("");
							}else if ($(this).attr("id")=="popularizecodepublished_thisyear")
							{
								var start = dt.getFullYear() + "-01-01";
								var end = dt.getFullYear() + "-12-31";
								$("#popularizecodepublished_thistype").val("thisyear");
							}
							else if ($(this).attr("id")=="popularizecodepublished_thisquater")
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
							   $("#popularizecodepublished_thistype").val("thisquater");
							}
							else if ($(this).attr("id")=="popularizecodepublished_recently")
							{
						      var start = "2016-05-01";
							  var end = "2016-06-01";
							  $("#popularizecodepublished_thistype").val("recently");
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
								$("#popularizecodepublished_thistype").val("thismonth");
							}
							$("#popularizecodepublished_startdate").val(start);
							$("#popularizecodepublished_enddate").val(end);
						}
					</script>';

if ($profile_search_input != "")
{
	$searchpanel['邀请码'] = '<input type="text" name="popularize_code_input" id="popularize_code_input" value="'.$profile_search_input.'" size=25 placeholder="输入邀请码查询">';
}
else
{
	$searchpanel['邀请码'] = '<input type="text" name="popularize_code_input" id="popularize_code_input" value="" size=25 placeholder="输入邀请码查询">';
}



$smarty->assign('SEARCHPANEL',$searchpanel);

$listview_check_button = array();


$smarty->assign("LISTVIEW_CHECK_BUTTON", $listview_check_button);
$smarty->assign("ACTION", "PopularizeCode");
$smarty->display("Settings/ListTabView.tpl");



?>

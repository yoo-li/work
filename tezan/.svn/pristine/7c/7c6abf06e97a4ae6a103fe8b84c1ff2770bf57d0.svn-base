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
 

$query = XN_Query::create ( 'Profile' ) ->tag("profile");	
$query->filter('type','=','wxuser');


$published_startdate = "";
$published_enddate = "";
if(isset($_REQUEST['published_startdate']) && $_REQUEST['published_startdate'] != '' && isset($_REQUEST['published_enddate']) && $_REQUEST['published_enddate'] != '')
{
	$published_startdate = $_REQUEST['published_startdate'];
	$published_enddate = $_REQUEST['published_enddate'];
	$query->filter ( 'published', '>=', $_REQUEST['published_startdate'].' 00:00:00' )
		  ->filter ( 'published', '<=', $_REQUEST['published_enddate'].' 23:59:59' );
}
$profile_search_input = '';


if(isset($_REQUEST['profile_search_input']) && $_REQUEST['profile_search_input'] != '' )
{
	$profile_search_input = $_REQUEST['profile_search_input'];
	$query1 = XN_Filter( 'mobile','=',$profile_search_input); 
	$query3 = XN_Filter( 'invitationcode','=',$profile_search_input);
	$query4 = XN_Filter( 'givenname','like',$profile_search_input);
	 
	$query->filter(XN_Filter::any($query1,$query3,$query4));
}
if(isset($_REQUEST['profile_search_ip']) && $_REQUEST['profile_search_ip'] != '' ){
    $profile_search_ip = $_REQUEST['profile_search_ip'];
    $query->filter ( 'reg_ip', '=', $_REQUEST['profile_search_ip']);
}


if(isset($_REQUEST['gender']) && $_REQUEST['gender'] != '' )
{
	$gender_search_input = $_REQUEST['gender'];
	$query->filter('gender','like',$gender_search_input);
}
	
$smarty->assign("ORDER_BY", $order_by);

$query_order_by = $order_by;
if (isset($order_by) && $order_by != '')
{    		
	$query_order_by = $order_by;
}
    		
if (strtolower($sorder) == 'desc'){
	$query->order($query_order_by,XN_Order::DESC);
	$smarty->assign("ORDER", "desc");
}
else 
{
	$query->order($query_order_by,XN_Order::ASC);
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
 
$smarty->assign("STATISTICS", 'false'); 

$smarty->assign('NOOFROWS',$noofrows);

$list_entries = array();
$list_entries['givenname'] = array('label' => getTranslatedString('LBL_GIVENNAME'),'sort'=> false,'width' => 8,'align' => "center" );
$list_entries['province'] = array('label' => getTranslatedString('LBL_PROVINCE'),'sort'=> true,'width' => 4,'align' => "center" );
$list_entries['city'] = array('label' => getTranslatedString('LBL_CITY'),'sort'=> true,'width' => 4,'align' => "center" );
$list_entries['gender'] = array('label' => getTranslatedString('LBL_GENDER'),'sort'=> true,'width' => 3,'align' => "center" );
$list_entries['mobile'] = array('label' => getTranslatedString('LBL_MOBILE'),'sort'=> true,'width' => 8,'align' => "center" );
$list_entries['reg_ip'] = array('label' => getTranslatedString('LBL_REG_IP'),'sort'=> true,'width' => 8,'align' => "center" );
$list_entries['invitationcode'] = array('label' => getTranslatedString('LBL_INVITATIONCODE'),'sort'=> true,'width' => 5,'align' => "center" );
$list_entries['published'] = array('label' => getTranslatedString('LBL_PUBLISHED'),'sort'=> true,'width' => 8,'align' => "center" );
$list_entries['activationdate'] = array('label' => getTranslatedString('LBL_ACTIVATIONDATE'),'sort'=> true,'width' => 10,'align' => "center" );
$list_entries['system'] = array('label' => getTranslatedString('LBL_SYSTEM'),'sort'=> true,'width' => 8,'align' => "center" );
$list_entries['browser'] = array('label' => getTranslatedString('LBL_BROWSER'),'sort'=> true,'width' => 8,'align' => "center" );
$list_entries['oper'] = array('label' => getTranslatedString('LBL_OPER'),'sort'=> false,'width' => 3,'align' => "center" );


$smarty->assign("LISTHEADER",$list_entries);

function getStdOutput($list_result, $list_entries)
{
	$return_data = array();
	foreach($list_result as $info)
	{
		$standCustFld = array();
		foreach(array_keys($list_entries) as $field)
		{
			if ($field != 'oper')
			{
				if ($field == 'fullName')
				{
					$wxopenid= $info->wxopenid;
					$mobile= $info->mobile;
					$identitycard= $info->identitycard;
					$fullName= $info->fullName;
					if ($mobile == '' || $identitycard == '' )
					{
						$standCustFld[]= '未激活用户';
					}
					else
					{
						if ($wxopenid == $fullName)
						{
							$standCustFld[]= $mobile;
						}
						else
						{
							$standCustFld[]= $fullName;
						}
						
					}
				}
				else if($field == "money" || $field == "accumulatedmoney" || $field == "sharefund" )
				{
					$standCustFld[]= str_replace("$","￥",$info->$field);
				}
				else
				{
					$standCustFld[]= $info->$field;
				}
			}
		}
		$standCustFld[] = '<a data-title="查看会员" data-id="edit" data-fresh="true" data-toggle="navtab" title="查看会员" href="index.php?module=Profile&action=EditView&profileid='.$info->screenName.'" target="navTab" rel="edit"><i class="fa fa-file-text-o"></i></a>';

		$return_data[$info->screenName]=$standCustFld;
	}
	return $return_data;
}

$smarty->assign("LISTENTITY",getStdOutput($list_result, $list_entries));


$searchpanel = array();

 


$genderhtml = '<a href="javascript:;" id="profilepublished_all" for="profilepublished_period"  title="全部">全部</a>
					<a href="javascript:;" id="profilepublished_thisyear" for="profilepublished_period"  title="本年">本年</a>
					<a href="javascript:;" id="profilepublished_thisquater" for="profilepublished_period"  title="本季">本季</a>
					<a href="javascript:;" id="profilepublished_thismonth" for="profilepublished_period"  title="本月">本月</a>
					<a href="javascript:;" id="profilepublished_recently" for="profilepublished_period" class="over" title="最近">最近</a>
					<input type="text" name="published_startdate" id="profilepublished_startdate" value="'.$published_startdate.'" readonly data-toggle="datepicker" data-rule="date" size="11">
					-
					<input type="text" name="published_enddate" id="profilepublished_enddate" value="'.$published_enddate.'" readonly data-toggle="datepicker" data-rule="date" size="11">
					<input value="recently" type="hidden" id="profilepublished_thistype" name="profilepublished_thistype" />
					<script type="text/javascript">
						$(document).ready(function()
						{
							$(\'a[for="profilepublished_period"]\').each(function(){
								$(this).click(profilepublished_period_onclick);
								});
						});
						$("#profilepublished_startdate").on("afterchange.bjui.datepicker", function(e, data) {
							$("#profilepublished_thistype").val("");
							$(\'a[for="profilepublished_period"]\').toggleClass("over",false);
						});
						$("#profilepublished_enddate").on("afterchange.bjui.datepicker", function(e, data) {
							$("#profilepublished_thistype").val("");
							$(\'a[for="profilepublished_period"]\').toggleClass("over",false);
						});
						function profilepublished_period_onclick() {
							$(\'a[for="profilepublished_period"]\').toggleClass("over",false);
							$(this).addClass("over");
							var dt = new Date();
		                    if ($(this).attr("id")=="profilepublished_all"){
								var start = "";
								var end = "";
		                        $("#profilepublished_thistype").val("");
							}else if ($(this).attr("id")=="profilepublished_thisyear")
							{
								var start = dt.getFullYear() + "-01-01";
								var end = dt.getFullYear() + "-12-31";
								$("#profilepublished_thistype").val("thisyear");
							}
							else if ($(this).attr("id")=="profilepublished_thisquater")
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
							   $("#profilepublished_thistype").val("thisquater");
							}
							else if ($(this).attr("id")=="profilepublished_recently")
							{
						      var start = "2016-05-01";
							  var end = "2016-06-01";
							  $("#profilepublished_thistype").val("recently");
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
								$("#profilepublished_thistype").val("thismonth");
							}
							$("#profilepublished_startdate").val(start);
							$("#profilepublished_enddate").val(end);
						}
					</script>';

$searchpanel['关注日期'] = $genderhtml;
if ($profile_search_input != "")
{
	$searchpanel['会员查找'] = '<input type="text" name="profile_search_input" id="profile_search_input" value="'.$profile_search_input.'" size=25 placeholder="输入手机号,昵称,邀请码或用户名进行查询">';
}
else
{
	$searchpanel['会员查找'] = '<input type="text" name="profile_search_input" id="profile_search_input" value="" size=25 placeholder="输入手机号,昵称,邀请码或用户名进行查询">';
}
if ($profile_search_ip != "")
{
	$searchpanel['IP查找'] = '<input type="text" name="profile_search_ip" id="profile_search_ip" value="'.$profile_search_ip.'" size=25 placeholder="输入IP地址进行查询">';
}
else
{
	$searchpanel['IP查找'] = '<input type="text" name="profile_search_ip" id="profile_search_ip" value="" size=25 placeholder="输入IP地址进行查询">';
}



$smarty->assign('SEARCHPANEL',$searchpanel);



$listview_check_button = array();
 
$listview_check_button[] = '<a class="btn btn-default" data-icon="weixin" data-group="ids" data-toggle="doajaxchecked" data-dialog=true data-title="确定发送微信消息？"  data-mask="true" data-maxable="false" data-resizable="false" data-width="500" data-height="300" href="index.php?module=Profile&action=sendmessage&ope=reason" > 发送微信消息</a>';
if (check_authorize('manageproflie') ){
	$listview_check_button[] = '<a class="btn btn-default"  data-group="ids" data-toggle="doajaxchecked" data-dialog=true data-mask="true" data-maxable="false" data-resizable="false" data-width="500" data-height="300" href="index.php?module=Profile&action=DeleteProfile" data-title="删除会员"><i class="fa fa-trash"></i> 删除会员</a>';
}

$listview_check_button[] = '<a data-id="PopularizeCode" class="btn btn-default"  href="index.php?module=Profile&action=PopularizeCode" data-toggle="navtab" data-title="激活统计"><i class="fa fa-bar-chart"></i> 激活统计</a>';
$listview_check_button[] = '<a data-id="popularizeipaddress" class="btn btn-default"  href="index.php?module=Profile&action=PopularizeIpAddress" data-toggle="navtab" data-title="激活IP统计"><i class="fa fa-bar-chart"></i> 激活IP统计</a>';


$smarty->assign("LISTVIEW_CHECK_BUTTON", $listview_check_button);
$smarty->assign("ACTION", "index");
$smarty->display("Settings/ListTabView.tpl");



?>

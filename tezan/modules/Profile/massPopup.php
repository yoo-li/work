<?php


global $currentModule;
require_once('Smarty_setup.php');
require_once('include/utils/utils.php');
require_once('include/utils/DataSearch.php');
require_once('modules/CustomView/CustomView.php');


function getAreaPicklists($fieldname,$parentnode) {
    $query = XN_Query::create ( 'SimpleContent' ) ->tag('picklists')
        ->filter ('type','eic','picklists')
        ->filter ('my.name','=',$fieldname)
        ->filter('my.parentnode','eic',$parentnode)
        ->order ('my.sequence',XN_Order::ASC_NUMBER)
        ->begin(0)->end(-1)
        ->execute();
    foreach($query as $info){
        $arr[] = $info->my->$fieldname;
    }
    return $arr;
}



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

$profileranks = XN_Query::create('MainContent')->tag('profilerank')
    ->filter('type','eic','profilerank')
    ->filter('my.deleted','=','0')
    ->order('my.minrank',XN_Order::DESC_NUMBER)
    ->execute();

$profilerankinfo = array();
$maxrank = 999999;
foreach($profileranks as $profilerank_info)
{
    $rankid = $profilerank_info->id;
    $rankname = $profilerank_info->my->rankname;
    $minrank = intval($profilerank_info->my->minrank);
    $profilerankinfo[$rankid]['maxrank'] = $maxrank;
    $profilerankinfo[$rankid]['minrank'] = $minrank;
    $profilerankinfo[$rankid]['rankname'] = $rankname;
    $maxrank = $minrank;

}




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


if(isset($_REQUEST['profilerank']) && $_REQUEST['profilerank'] != '' )
{
    $profilerank = $_REQUEST['profilerank'];

    if ($profilerank == '0')
    {
        $query->filter('mobile','!=','');
    }
    elseif ($profilerank == '-1')
    {
        $query->filter(XN_Filter::any(XN_Filter('mobile','=',null),XN_Filter('mobile','=','')));
    }
    elseif (isset($profilerankinfo[$profilerank]))
    {
        $maxrank = $profilerankinfo[$profilerank]['maxrank'];
        $minrank = $profilerankinfo[$profilerank]['minrank'];

        if ($minrank == 0 && $maxrank == 1)
        {
            $query1 = XN_Filter( 'rank','<',$maxrank);
            $query2 = XN_Filter( 'rank','>=',$minrank);
            $query3 = XN_Filter( 'mobile','!=','');
            $query->filter(XN_Filter::all($query1,$query2,$query3));
        }
        else
        {
            $query1 = XN_Filter( 'rank','<',$maxrank);
            $query2 = XN_Filter( 'rank','>=',$minrank);
            $query->filter(XN_Filter::all($query1,$query2));
        }
    }
}

if(isset($_REQUEST['profile_search_input']) && $_REQUEST['profile_search_input'] != '' )
{
    $profile_search_input = $_REQUEST['profile_search_input'];
    $query1 = XN_Filter( 'mobile','=',$profile_search_input);
    $query3 = XN_Filter( 'invitationcode','=',$profile_search_input);
    $query4 = XN_Filter( 'givenname','like',$profile_search_input);
    $query->filter(XN_Filter::any($query1,$query3,$query4));
}

$profileid = XN_Profile::$VIEWER;
$profile = XN_Profile::load($profileid,"id","profile");
$province = $profile->province;
$city = $profile->city;

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

$smarty->assign('NOOFROWS',$noofrows);

$list_entries = array();
$list_entries['givenname'] = array('label' => getTranslatedString('LBL_GIVENNAME'),'sort'=> false,'width' => 8,'align' => "center" );
$list_entries['province'] = array('label' => getTranslatedString('LBL_PROVINCE'),'sort'=> true,'width' => 4,'align' => "center" );
$list_entries['city'] = array('label' => getTranslatedString('LBL_CITY'),'sort'=> true,'width' => 4,'align' => "center" );
$list_entries['gender'] = array('label' => getTranslatedString('LBL_GENDER'),'sort'=> true,'width' => 3,'align' => "center" );
$list_entries['mobile'] = array('label' => getTranslatedString('LBL_MOBILE'),'sort'=> true,'width' => 8,'align' => "center" );
$list_entries['rank'] = array('label' => getTranslatedString('LBL_RANK'),'sort'=> true,'width' => 5,'align' => "center" );
$list_entries['invitationcode'] = array('label' => getTranslatedString('LBL_INVITATIONCODE'),'sort'=> true,'width' => 5,'align' => "center" );
$list_entries['published'] = array('label' => getTranslatedString('LBL_PUBLISHED'),'sort'=> true,'width' => 8,'align' => "center" );
$list_entries['activationdate'] = array('label' => getTranslatedString('LBL_ACTIVATIONDATE'),'sort'=> true,'width' => 10,'align' => "center" );
$list_entries['system'] = array('label' => getTranslatedString('LBL_SYSTEM'),'sort'=> true,'width' => 8,'align' => "center" );
$list_entries['browser'] = array('label' => getTranslatedString('LBL_BROWSER'),'sort'=> true,'width' => 8,'align' => "center" );

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
                        $standCustFld[$field]= '未激活用户';
                    }
                    else
                    {
                        if ($wxopenid == $fullName)
                        {
                            $standCustFld[$field]= $mobile;
                        }
                        else
                        {
                            $standCustFld[$field]= $fullName;
                        }

                    }
                }
                else if($field == "money" || $field == "accumulatedmoney" || $field == "sharefund" )
                {
                    $standCustFld[$field]= str_replace("$","￥",$info->$field);
                }
                else
                {
                    $standCustFld[$field]= $info->$field;
                }
            }
        }
        $standCustFld[$field] = '<a rel="edit" target="navTab" title="查看" href="index.php?module=Profile&action=EditView&profileid='.$info->screenName.'"><img width="16" height="16" border="0" src="/images/icon_view.gif"></a>';
        /*<a rel="edit" target="navTab" title="收货地址" href="index.php?module=Profile&action=EditView&profileid='.$info->screenName.'"><img width="16" height="16" border="0" src="/images/book_open.gif"></a>
        <a rel="edit" target="navTab" title="查看订单" href="index.php?module=Profile&action=EditView&profileid='.$info->screenName.'"><img width="16" height="16" border="0" src="/images/icon_view.gif"></a>
        <a rel="edit" target="navTab" title="查看账目明细" href="index.php?module=Profile&action=EditView&profileid='.$info->screenName.'"><img width="16" height="16" border="0" src="/images/icon_account.gif"></a>
        ';*/
        $return_data[$info->screenName]=$standCustFld;
    }
    return $return_data;
}

$smarty->assign("LISTENTITY",getStdOutput($list_result, $list_entries));


$searchpanel = array();
if ($profile_search_input != "")
{
    $searchpanel['会员查找'] = '<span class="ph-label" style="display:none;"  onclick="$(this).css(\'display\',\'none\');$(\'#profile_search_input\').focus();">输入手机号,邀请码或用户名进行查询……</span><input  class="search-text" type="text"  value="'.$profile_search_input.'" id="profile_search_input" name="profile_search_input"  onFocus="$(this).prev().css(\'display\',\'none\');" onBlur="if (this.value == \'\') $(this).prev().css(\'display\',\'inline\');">';
}
else
{
    $searchpanel['会员查找'] = '<span class="ph-label" onclick="$(this).css(\'display\',\'none\');$(\'#profile_search_input\').focus();">输入手机号,昵称,邀请码或用户名进行查询……</span><input  class="search-text" type="text"  value="" id="profile_search_input" name="profile_search_input"  onFocus="$(this).prev().css(\'display\',\'none\');" onBlur="if (this.value == \'\') $(this).prev().css(\'display\',\'inline\');">';
}

$smarty->assign('SEARCHPANEL',$searchpanel);

$listview_check_button[] = '<a href="index.php?module=Profile&action=sendmessage&ope=reason" class="edit" rel="ids" height="300" width="400" posttype="string" target="selectedTodo" mode="dialog"  title="确定发送微信消息？"><span>发送微信消息</span></a>';
$smarty->assign("LISTVIEW_CHECK_BUTTON", $listview_check_button);

$smarty->assign("ACTION", "index");
$smarty->display("massPopup.tpl");



?>

<?php

session_start();

require_once (dirname(__FILE__) . "/../include/config.inc.php");
require_once (dirname(__FILE__) . "/../include/config.common.php");
require_once (dirname(__FILE__) . "/../include/utils.php");
require_once (dirname(__FILE__) . "/../approval/utils.php");
//身份验证 D
if (isset($_REQUEST["parameter"]) && $_REQUEST["parameter"] != "" && isset($_REQUEST["token"]) && $_REQUEST["token"] != "")
{
    $Sou = Verification($_REQUEST["parameter"],$_REQUEST["token"]);
    if(!isset($Sou) || !is_array($Sou) || count($Sou) <= 0){
        errorprint("错误", '参数校验错误！');
        die();
    }
    $profileid = $Sou["profileid"];

    $_SESSION['profileid'] = $profileid;
}
else
{
    if(isset($_SESSION['profileid']) && $_SESSION['profileid'] !='')
    {
        $profileid = $_SESSION["profileid"];
    }
    else
    {
        messagebox("错误", '检测不到必需的请求参数！');
        die();
    }
}
$supplier_profile = XN_Query::create('MainContent')->tag("supplier_profile_".$profileid)
    ->filter('type', 'eic', "supplier_profile")
    ->filter('my.deleted', '=', '0')
    ->filter('my.official', '=', '0')
    ->filter('my.profileid', '=', $profileid)
    ->end(1)
    ->execute();
$_SESSION["supplierid"] = $supplier_profile[0]->my->supplierid;
$supplierid = $_SESSION["supplierid"];

if(isset($_SESSION['supplierid']) && $_SESSION['supplierid'] !='' &&
	isset($_SESSION['profileid']) && $_SESSION['profileid'] !='' )
{
	$supplierid =  $_SESSION["supplierid"];
	$profileid = $_SESSION["profileid"];
}
else
{
	die();
}

if(isset($_REQUEST['nextapprovalid']) && $_REQUEST['nextapprovalid'] != '')
{
	$approvalid = $_REQUEST['nextapprovalid'];
	$approval_info = XN_Content::load($approvalid,"approvals");
	$approval_info->my->sequence = strtotime("now");
	$approval_info->save("approvals,approvals_".$supplierid);
    $query = XN_Query::create ( 'Content' )
        ->tag ( 'approvals' )
        ->filter ( 'type', 'eic', 'approvals' )
        ->filter ( 'my.finished', '=', 'false' )
        ->filter ( XN_Filter::any(XN_Filter( 'my.userid', '=', $profileid),XN_Filter( 'my.proxyapproval', '=', $profileid)))
        ->filter ( 'my.deleted', '=', '0' )
        ->order('my.sequence',XN_Order::ASC_NUMBER)
        ->begin(0)
        ->end(1);
    $num = $_GET['num'];
    $num++;
}elseif(isset($_REQUEST['beforeapprovalid']) && $_REQUEST['beforeapprovalid'] != ''){
    $approvalid = $_REQUEST['beforeapprovalid'];
    $approval_info = XN_Content::load($approvalid,"approvals");
    $approval_info->my->sequence = strtotime("now");
    $approval_info->save("approvals,approvals_".$supplierid);
    $query = XN_Query::create ( 'Content' )
        ->tag ( 'approvals' )
        ->filter ( 'type', 'eic', 'approvals' )
        ->filter ( 'my.finished', '=', 'false' )
        ->filter ( XN_Filter::any(XN_Filter( 'my.userid', '=', $profileid),XN_Filter( 'my.proxyapproval', '=', $profileid)))
        ->filter ( 'my.deleted', '=', '0' )
        ->order('my.sequence',XN_Order::ASC_NUMBER)
        ->begin(0)
        ->end(1);
    $num = $_GET['num'];
    $num--;
}else{
    $query = XN_Query::create ( 'Content' )
        ->tag ( 'approvals' )
        ->filter ( 'type', 'eic', 'approvals' )
        ->filter ( 'my.finished', '=', 'false' )
        ->filter ( XN_Filter::any(XN_Filter( 'my.userid', '=', $profileid),XN_Filter( 'my.proxyapproval', '=', $profileid)))
        ->filter ( 'my.deleted', '=', '0' )
        ->order('my.sequence',XN_Order::ASC_NUMBER)
        ->begin(0)
        ->end(1);
    $num = 1;
}


$approvals = $query->execute();
$noofrows = $query->getTotalCount();
$approvalinfo = array();
if(count($approvals) > 0)
{
	$approval_info = $approvals[0];
	$tabid = $approval_info->my->tabid;
	$module = getModule($tabid);
	$record = $approval_info->my->record;
	$approvalinfo['tabid'] = $tabid;
	$approvalinfo['module'] = $module;
	$approvals_from_userid = $approval_info->my->from_userid;
	$approvalinfo['userid'] = $approvals_from_userid;
	$approvalinfo['username'] = getUserNameByProfile($approvals_from_userid);
	$approvalinfo['amount'] = $approval_info->my->amount;
	$approvalinfo['submittime'] = date('Y-m-d H:i',strtotime($approval_info->published));
	$approvalinfo['approvalinfo'] = $approval_info->my->approvalinfo;
	$approvalinfo['record'] = $record;
	$approvalinfo['approvalid'] = $approval_info->id;
	$approvalinfo['modulelabel'] = getTranslatedString($module, $module);

	$baseinfo = getModuleBaseInfo($record, $tabid);
	   //ziv 20170806
    $value= XN_Query::create("Content")->tag("supplier_users")
    ->filter("type", "eic", "supplier_users")
    ->filter("my.deleted", "=", "0")
    ->filter("my.profileid", "=", $baseinfo[1]['value'])
    ->end(1)
    ->execute();
    $baseinfo[1]['value']= $value[0]->my->account;
    $loadcontent = XN_Content::load($record,strtolower('Mall_OfficialTreatPayments'));

    if($baseinfo[7]['fieldname'] == 'authorizedperson'){
    $value= XN_Query::create("Content")->tag("supplier_users")
    ->filter("type", "eic", "supplier_users")
    ->filter("my.deleted", "=", "0")
    ->filter("my.profileid", "=", $baseinfo[7]['value'])
    ->end(1)
    ->execute();
    $baseinfo[7]['value'] =$value[0]->my->account;
    }
    if($baseinfo[8]['fieldname'] == 'decider'){
    $value= XN_Query::create("Content")->tag("supplier_users")
    ->filter("type", "eic", "supplier_users")
    ->filter("my.deleted", "=", "0")
    ->filter("my.profileid", "=", $baseinfo[8]['value'])
    ->end(1)
    ->execute();
    $baseinfo[8]['value'] =$value[0]->my->account;
    }
    if($baseinfo[9]['fieldname'] == 'opinion'){
    $value= XN_Query::create("Content")->tag("supplier_users")
    ->filter("type", "eic", "supplier_users")
    ->filter("my.deleted", "=", "0")
    ->filter("my.profileid", "=", $baseinfo[9]['value'])
    ->end(1)
    ->execute();
    $baseinfo[9]['value'] =$value[0]->my->account;
    }

    if($loadcontent->my->treatsupplier){

        $Mall_OfficialTreats= XN_Query::create("Content")->tag("Mall_OfficialTreats")
        ->filter("type", "eic", "Mall_OfficialTreats")
        ->filter("my.deleted", "=", "0")
        ->filter("id", "=", $loadcontent->my->officialtreatid )
        ->end(1)
        ->execute();
        $mall_officialtreats_no=$Mall_OfficialTreats[0]->my->mall_officialtreats_no;
        $baseinfo[count($approvalinfo)+2]['translatedfieldlabel'] = '宴请编号';
        $baseinfo[count($approvalinfo)+2]['value'] = $mall_officialtreats_no;

        $Mall_OfficialTreats= XN_Query::create("Content")
        ->tag("Mall_OfficialTreats")
        ->filter("type", "eic", "Mall_OfficialTreats")
        ->filter("my.deleted", "=", "0")
        ->filter("id", "=", $loadcontent->my->officialtreatid )
        ->end(1)
        ->execute();

        $Mall_OfficialTreatObjects= XN_Query::create("Content")
        ->tag("Mall_OfficialTreatObjects")
        ->filter("type", "eic", "Mall_OfficialTreatObjects")
        ->filter("my.deleted", "=", "0")
        ->filter("id", "=", $loadcontent->my->treatsupplier  )
        ->end(1)
        ->execute();

        $baseinfo[count($approvalinfo)+3]['translatedfieldlabel'] = '联系人';
        $baseinfo[count($approvalinfo)+3]['value'] = $Mall_OfficialTreatObjects[0]->my->contact; //联系人
        $baseinfo[count($approvalinfo)+4]['translatedfieldlabel'] = '联系电话';
        $baseinfo[count($approvalinfo)+4]['value'] = $Mall_OfficialTreatObjects[0]->my->mobile;
        $baseinfo[count($approvalinfo)+5]['translatedfieldlabel'] = '商户地址';
        $baseinfo[count($approvalinfo)+5]['value'] = $Mall_OfficialTreatObjects[0]->my->companyaddress;
        $baseinfo[count($approvalinfo)+6]['translatedfieldlabel'] = '开户行';
        $baseinfo[count($approvalinfo)+6]['value'] = $Mall_OfficialTreatObjects[0]->my->bankname;
        $baseinfo[count($approvalinfo)+7]['translatedfieldlabel'] = '开户名';
        $baseinfo[count($approvalinfo)+7]['value'] = $Mall_OfficialTreatObjects[0]->my->accountname;
        $baseinfo[count($approvalinfo)+8]['translatedfieldlabel'] = '银行账户';
        $baseinfo[count($approvalinfo)+8]['value'] = $Mall_OfficialTreatObjects[0]->my->bankaccount;
    }
    $approvalinfo['baseinfo'] = $baseinfo;
}

$modules_users = XN_Query::create("Content")->tag("supplier_modules_users_".$profileid)
					   ->filter("type", "eic", "supplier_modules_users")
					   ->filter("my.deleted", "=", "0")
					   ->filter("my.supplierid", "=", $supplierid)
					   ->filter("my.profileid", "=", $profileid)
					   ->filter("my.record", "=", $tabid)
					   ->end(-1)
					   ->execute();
if (count($modules_users) > 0)
{
	$modules_user_info = $modules_users[0];
	$untreated = $modules_user_info->my->untreated;
	if (intval($untreated) != intval($noofrows))
	{
   		$modules_user_info->my->untreated = intval($noofrows);
   		$modules_user_info->save("supplier_modules_users,supplier_modules_users_".$supplierid.",supplier_modules_users_".$profileid);
	}
}
else
{
	$newcontent = XN_Content::create("supplier_modules_users", "", false);
	$newcontent->my->untreated   = $noofrows;
	$newcontent->my->processed   = '0';
	$newcontent->my->lasttime   =  date("Y-m-d H:i");
	$newcontent->my->record  = $tabid;
	$newcontent->my->profileid  = $profileid;
	$newcontent->my->supplierid   = $supplierid;
	$newcontent->my->deleted      = "0";
	$newcontent->save("supplier_modules_users,supplier_modules_users_".$supplierid.",supplier_modules_users_".$profileid);
}

require_once('Smarty_setup.php');
$smarty = new platform_Smarty;
if($num>$noofrows){
    $num = 1;
}elseif($num==0){
    $num=$noofrows;
}
$smarty->assign("num",$num);
$smarty->assign("noofrows",$noofrows);

$smarty->assign("approval_info",$approvalinfo);



$smarty->assign("supplier_info",get_supplier_info());
$smarty->assign("theme_info",get_system_theme_info());

$smarty->assign("copyrights",get_copyright_info());


$action = strtolower(basename(__FILE__, ".php"));
$smarty->display($action . '.tpl');

?>

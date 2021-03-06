<?php

session_start(); 

require_once (dirname(__FILE__) . "/../include/config.inc.php");
require_once (dirname(__FILE__) . "/../include/config.common.php");
require_once (dirname(__FILE__) . "/../include/utils.php");
require_once (dirname(__FILE__) . "/utils.php"); 
 

if(isset($_SESSION['supplierid']) && $_SESSION['supplierid'] !='' &&
	isset($_SESSION['profileid']) && $_SESSION['profileid'] !='' &&
	isset($_SESSION['tabid']) && $_SESSION['tabid'] !='')
{
	$supplierid =  $_SESSION["supplierid"];
	$tabid = $_SESSION["tabid"];
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
}

$query = XN_Query::create ( 'Content' )
	->tag ( 'approvals' )
	->filter ( 'type', 'eic', 'approvals' )
	->filter ( 'my.finished', '=', 'false' )
	->filter ( XN_Filter::any(XN_Filter( 'my.userid', '=', $profileid),XN_Filter( 'my.proxyapproval', '=', $profileid)))
	->filter ( 'my.deleted', '=', '0' )
	->order('my.sequence',XN_Order::ASC_NUMBER)
	->begin(0)
	->end(1);
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

$smarty->assign("noofrows",$noofrows);

$smarty->assign("approval_info",$approvalinfo); 

$smarty->assign("supplier_info",get_supplier_info()); 

$smarty->assign("copyrights",get_copyright_info());	
	
$action = strtolower(basename(__FILE__, ".php"));
$smarty->display($action . '.tpl');  

?>
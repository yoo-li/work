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
if (isset($_REQUEST["type"]) && $_REQUEST["type"] == "ajax")
{ 
	if(isset($_REQUEST['page']) && $_REQUEST['page'] != '')
	{
		$page = $_REQUEST['page'];   
		
        $startdate = date("Y-m-d", strtotime('-6 month', strtotime("today"))).' 00:00:00';
        $enddate   = date("Y-m-d",strtotime("today")).' 23:59:59';
		
		$query = XN_Query::create ( 'Content' )->tag ( 'approvals' )
			->filter ( 'type', 'eic', 'approvals' )
			->filter ( 'my.finished', '=', 'true' )
			->filter ( XN_Filter::any(XN_Filter( 'my.userid', '=', $profileid),XN_Filter( 'my.proxyapproval', '=', $profileid)))
			->filter ( 'my.deleted', '=', '0' )
            ->filter('published', '>=', $startdate)
			->filter('published', '<=', $enddate)
			->order('my.submitapprovalreplydatetime',XN_Order::DESC)
			->begin(($page-1)*5)
			->end($page*5); 
	   $approvals = $query->execute ();
	   $noofrows = $query->getTotalCount();
	   if ($noofrows == 0 && $page != 1)
	   {
		   echo '{"code":202, "data":[]}'; 
		   die();
	   }
	   $approvallist = array();
	   $pos = 1;  
	   foreach($approvals as $approval_info)
	   { 
		   	$tabid = $approval_info->my->tabid;
		   	$module = getModule($tabid);  
		   	$record = $approval_info->my->record;
		   	$approvallist[$pos]['tabid'] = $tabid;
		   	$approvallist[$pos]['module'] = $module;
		   	$approvals_from_userid = $approval_info->my->from_userid;
		   	$approvallist[$pos]['userid'] = $approvals_from_userid;
		   	$approvallist[$pos]['username'] = getUserNameByProfile($approvals_from_userid);
		   	$approvallist[$pos]['amount'] = $approval_info->my->amount;
		   	$approvallist[$pos]['submittime'] = date('Y-m-d H:i',strtotime($approval_info->published));
		   	$approvallist[$pos]['approvalinfo'] = $approval_info->my->approvalinfo;
		   	$approvallist[$pos]['record'] = $record;
		   	$approvallist[$pos]['approvalid'] = $approval_info->id;   
		   	$approvallist[$pos]['modulelabel'] = getTranslatedString($module, $module); 
			$reply = $approval_info->my->reply;
			$approvallist[$pos]['reply'] = $reply;
			$approvallist[$pos]['translatedreply'] = getTranslatedString($reply, $module); 
			$reply_text = $approval_info->my->reply_text;
			if (isset($reply_text) && $reply_text != "")
			{
				$approvallist[$pos]['reply_text'] = $reply_text;
			}
			else
			{
				$approvallist[$pos]['reply_text'] = "无";
			} 
			$approvallist[$pos]['submitapprovalreplydatetime'] = $approval_info->my->submitapprovalreplydatetime;
			$approvallist[$pos]['approvaltype'] = $approval_info->my->approvaltype; 
			$pos++; 
	   }  
	   echo '{"code":200,"length":'.$noofrows.',"data":'.json_encode($approvallist).'}'; 
	   die(); 
		 
	}
	echo '{"code":200,"length":0,"data":[]}'; 
	die(); 
}
   
	  

require_once('Smarty_setup.php');  
$smarty = new platform_Smarty;   

$smarty->assign("supplier_info",get_supplier_info()); 

$smarty->assign("copyrights",get_copyright_info());	
	
$action = strtolower(basename(__FILE__, ".php"));
$smarty->display($action . '.tpl');  

?>
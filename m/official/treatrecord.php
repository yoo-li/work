<?php
 
session_start();
header("Content-type:text/html;charset=utf-8");
require_once (dirname(__FILE__) . "/../include/config.inc.php");
require_once (dirname(__FILE__) . "/../include/config.common.php");
require_once (dirname(__FILE__) . "/../include/utils.php");
require_once (dirname(__FILE__) . "/../approval/utils.php");



if(isset($_SESSION['supplierid']) && $_SESSION['supplierid'] !='' &&
	isset($_SESSION['profileid']) && $_SESSION['profileid'] !='' )
{
	$supplierid =  $_SESSION["supplierid"]; 
	$profileid = $_SESSION["profileid"];
}
else
{    
	messagebox("错误", '检测不到必需的请求参数！');
	die();
} 

if(isset($_REQUEST['record']) && $_REQUEST['record'] !='' && $_REQUEST['type'] == 'delete')
{
	$record = $_REQUEST['record'];  
	try{   
		$loadcontent = XN_Content::load($record,'mall_officialtreats_'.$supplierid); 
		$loadcontent->my->deleted = '1';
		$loadcontent->save('mall_officialtreats,mall_officialtreats_'.$supplierid);  
		
		$officialopinions = XN_Query::create ( 'Content' )->tag ( 'mall_officialopinions_'.$supplierid )
			->filter ( 'type', 'eic', 'mall_officialopinions' )
			->filter ( 'my.record', '=', $record )
			->filter ( 'my.deleted', '=', '0' ) 
			->end(-1)
			->execute ();
 	   foreach($officialopinions as $officialopinion_info)
 	   {
	   		$officialopinion_info->my->deleted = '1';
	   		$officialopinion_info->save('mall_officialopinions,mall_officialopinions_'.$supplierid);
	   }
	}
	catch(XN_Exception $e)
	{
		$msg = $e->getMessage();	
		messagebox('错误',$msg);
		die(); 
	} 
} 
if (isset($_REQUEST["type"]) && $_REQUEST["type"] == "ajax")
{ 
	if(isset($_REQUEST['page']) && $_REQUEST['page'] != '')
	{
		$page = $_REQUEST['page'];    
		
		$query = XN_Query::create ( 'Content' )->tag ( 'mall_officialtreats' )
			->filter ( 'type', 'eic', 'mall_officialtreats' )
			->filter ( 'my.profileid', '=', $profileid )
			->filter ( 'my.deleted', '=', '0' ) 
			->order('published',XN_Order::DESC)
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
		   	$approvallist[$pos]['treatid'] = $approval_info->id;
		   	$approvallist[$pos]['treatobject'] = $approval_info->my->treatobject;
			$approvallist[$pos]['authorizeevent'] = $approval_info->my->authorizeevent;
			$approvallist[$pos]['participants'] = $approval_info->my->participants;
			$approvallist[$pos]['treatdatetime'] = $approval_info->my->treatdatetime;
			$approvallist[$pos]['address'] = $approval_info->my->address;
			$approvallist[$pos]['estimatedcost'] = $approval_info->my->estimatedcost;
			$approvallist[$pos]['percapita'] = $approval_info->my->percapita;
			$approvallist[$pos]['treatreason'] = $approval_info->my->treatreason;
			$approvallist[$pos]['approvalstatus'] = $approval_info->my->approvalstatus;
			$approvallist[$pos]['treatpayment'] = $approval_info->my->treatpayment;
			$mall_officialtreatsstatus = $approval_info->my->mall_officialtreatsstatus;
			 
			$approvallist[$pos]['mall_officialtreatsstatus'] = getTranslatedString($mall_officialtreatsstatus,"Mall_OfficialTreats");   
			$approvallist[$pos]['submitapprovalreplydatetime'] = $approval_info->my->submitapprovalreplydatetime; 
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
$smarty->assign("theme_info",get_system_theme_info());	

$smarty->assign("copyrights",get_copyright_info());	
	
$action = strtolower(basename(__FILE__, ".php"));
$smarty->display($action . '.tpl');  

?>
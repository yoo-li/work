<?php
session_start(); 

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
	//die();
}
if (isset($_REQUEST["type"]) && $_REQUEST["type"] == "ajax")
{ 
	if(isset($_REQUEST['page']) && $_REQUEST['page'] != '' &&
	   isset($_REQUEST['approval']) && $_REQUEST['approval'] != '')
	{ 
		$page = $_REQUEST['page'];   
		$approval = $_REQUEST['approval'];  
		
		$approvallist = array(); 
		$noofrows = 0;
		if ($approval == "treat")
		{
			$query = XN_Query::create ( 'Content' )->tag ( 'mall_officialtreats_'.$supplierid )
				->filter ( 'type', 'eic', 'mall_officialtreats' )
				->filter ( 'my.supplierid', '=', $supplierid)
				->filter ( 'my.decider', '=', $profileid)
				->filter ( 'my.authorized', 'in', array('1','2'))
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
			    $authorized = $approval_info->my->authorized;
	   		   	$approvallist[$pos]['approvalid'] = $approval_info->id;
	   			$approvallist[$pos]['record'] = $approval_info->id;
	   			$approvallist[$pos]['published'] = $approval_info->published;
	   		   	$approvallist[$pos]['profileid'] = $approval_info->my->profileid;
	   			$approvallist[$pos]['givenname'] = getGivenName($approval_info->my->profileid);
	   			$approvallist[$pos]['modulelabel'] = '宴请';
				$approvallist[$pos]['authorized'] = $authorized;
//				7271007s
               $approvallist[$pos]['participants'] = $approval_info->my->participants;
               $approvallist[$pos]['estimatedcost']= $approval_info->my->estimatedcost;
               $approvallist[$pos]['flag']= 1;
 //				7271007e
				if ($authorized == "2")
				{
					$approvallist[$pos]['reply'] = '审核同意';
				}
				else
				{
					$approvallist[$pos]['reply'] = '审核不同意';
				}
	   			$approvallist[$pos]['submitdatetime'] = $approval_info->my->submitdatetime; 
				$pos++; 
		   }   
		} 
		else
		{
			$query = XN_Query::create ( 'Content' )->tag ( 'mall_officialorders_'.$supplierid )
				->filter ( 'type', 'eic', 'mall_officialorders' )
				->filter ( 'my.supplierid', '=', $supplierid)
				->filter ( 'my.decider', '=', $profileid)
				->filter ( 'my.authorized', 'in', array('1','2'))
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
			    $authorized = $approval_info->my->authorized;
	   		   	$approvallist[$pos]['approvalid'] = $approval_info->id;
	   			$approvallist[$pos]['record'] = $approval_info->id;
	   			$approvallist[$pos]['published'] = $approval_info->published;
	   		   	$approvallist[$pos]['profileid'] = $approval_info->my->profileid;
	   			$approvallist[$pos]['givenname'] = getGivenName($approval_info->my->profileid);
	   			$approvallist[$pos]['modulelabel'] = '购物';
                $approvallist[$pos]['authorized'] = $authorized;
	   			$approvallist[$pos]['flag'] = 0;

				if ($authorized == "2")
				{
					$approvallist[$pos]['reply'] = '审核同意';
				}
				else
				{
					$approvallist[$pos]['reply'] = '审核不同意';
				}
	   			$approvallist[$pos]['submitdatetime'] = $approval_info->my->submitdatetime; 
				$pos++; 
		   }   
			
		}
		echo '{"code":200,"length":'.$noofrows.',"data":'.json_encode($approvallist).'}';
	    die(); 
		 
	}
	echo '{"code":200,"length":0,"data":[]}'; 
	die(); 
}
   
require_once('Smarty_setup.php');
$smarty = new platform_Smarty;   

$smarty->assign("type",$_REQUEST["type"]); 

 $smarty->assign("supplier_info",get_supplier_info());
$smarty->assign("theme_info",get_system_theme_info());

$smarty->assign("copyrights",get_copyright_info());	
	
$action = strtolower(basename(__FILE__, ".php"));
$smarty->display($action . '.tpl');

?>
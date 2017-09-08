<?php
 
session_start(); 

require_once (dirname(__FILE__) . "/../include/config.inc.php");
require_once (dirname(__FILE__) . "/../include/config.common.php");
require_once (dirname(__FILE__) . "/../include/utils.php");
 
 
/*
$_SESSION['supplierid'] = "71352";
$_SESSION['profileid'] = 'hx5eyjjmlg6'; //老手
$_SESSION['tabid'] = '879084';
*/


if (isset($_REQUEST["type"]) && $_REQUEST["type"] == "ajax")
{
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
	if(isset($_REQUEST['page']) && $_REQUEST['page'] != '' && isset($_REQUEST['t']) && $_REQUEST['t'] != '')
	{
		$page = $_REQUEST['page'];   
		$type = $_REQUEST["t"];  
		
        $startdate = date("Y-m-d", strtotime('-6 month', strtotime("today"))).' 00:00:00';
        $enddate   = date("Y-m-d",strtotime("today")).' 23:59:59';
		
		$announcementviews = XN_Query::create ( 'Content' )->tag('announcementviews_'.$supplierid)
					->filter ( 'type', 'eic', 'announcementviews') 
					->filter ( 'my.deleted', '=', '0') 
					->filter ( 'my.supplierid', '=', $supplierid)
			  	    ->filter( 'my.profileid','=',$profileid)   
                    ->filter('published', '>=', $startdate)
					->filter('published', '<=', $enddate)
					->end(-1)
					->execute ();
		
		$announcementids = array();
		foreach($announcementviews as $announcementview_info)
		{
			$announcementids[] = $announcementview_info->my->announcementid;
		}
		
		if ($type == "read")
		{
			if (count($announcementids) > 0)
			{
				$query = XN_Query::create ( 'Content' )->tag('announcements_'.$supplierid)
							->filter ( 'type', 'eic', 'announcements') 
							->filter ( 'my.deleted', '=', '0') 
							->filter ( 'my.approvalstatus', '=', '2')  
							->filter ( 'my.supplierid', '=', $supplierid)  
		                    ->filter('published', '>=', $startdate)
							->filter('published', '<=', $enddate)
							->begin(($page-1)*5)
							->end($page*5);  
				 
			   $query->filter ( 'id', 'in', $announcementids);
				 
			   $announcements = $query->execute ();
			   $noofrows = $query->getTotalCount();
			   if ($noofrows == 0 && $page != 1)
			   {
				   echo '{"code":202, "data":[]}'; 
				   die();
			   }
			   $announcementlist = array();
			   $pos = 1;
		   
	   	  
			   $picklists = array( 
				   	'Notification' => '通知',
				   	'Activity' => '活动',
				   	'Meeting' => '会议',
				   	'Business' => '财务',
				   	'Other' => '其它',
			   );
		 
	 		   foreach($announcements as $announcement_info)
	 		   { 
	 	   			$announcementlist[$pos]['announcementid'] = $announcement_info->id; 
					$announcementlist[$pos]['announcementstitle'] = $announcement_info->my->announcementstitle; 
					$announcementstype = $announcement_info->my->announcementstype;  
					$announcementlist[$pos]['announcementstype'] = $picklists[$announcementstype]; 
					$announcementlist[$pos]['simple_desc'] = $announcement_info->my->simple_desc; 
					$description = $announcement_info->my->description; 
					$announcementlist[$pos]['description'] = $description; 
					$announcementlist[$pos]['releasedate'] = $announcement_info->my->releasedate; 
					$announcementlist[$pos]['announcementsstatus'] = $announcement_info->my->announcementsstatus;  
					$announcementlist[$pos]['read_num'] = $announcement_info->my->read_num; 
					$announcementlist[$pos]['approvalstatus'] = $announcement_info->my->approvalstatus;  
					$pos++; 
			   } 
			   rsort($announcementlist);
			   echo '{"code":200,"length":'.$noofrows.',"data":'.json_encode($announcementlist).'}'; 
			   die(); 
			}
			else
			{
				echo '{"code":200,"length":0,"data":[]}'; 
				die(); 
			}
		}
		else
		{
			
			$query = XN_Query::create ( 'Content' )->tag('announcements_'.$supplierid)
						->filter ( 'type', 'eic', 'announcements') 
						->filter ( 'my.deleted', '=', '0') 
						->filter ( 'my.approvalstatus', '=', '2')  
						->filter ( 'my.supplierid', '=', $supplierid)  
	                    ->filter('published', '>=', $startdate)
						->filter('published', '<=', $enddate)
						->begin(($page-1)*5)
						->end($page*5);  
			if (count($announcementids) > 0)
			{
				$query->filter ( 'id', '!in', $announcementids);
			}
		   $announcements = $query->execute ();
		   $noofrows = $query->getTotalCount();
		   
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
			
			
		   if ($noofrows == 0 && $page != 1)
		   {
			   echo '{"code":202, "data":[]}'; 
			   die();
		   }
		   $announcementlist = array();
		   $pos = 1;
		   
	   	  
		   $picklists = array( 
			   	'Notification' => '通知',
			   	'Activity' => '活动',
			   	'Meeting' => '会议',
			   	'Business' => '财务',
			   	'Other' => '其它',
		   );
		 
 		   foreach($announcements as $announcement_info)
 		   { 
 	   			$announcementlist[$pos]['announcementid'] = $announcement_info->id; 
				$announcementlist[$pos]['announcementstitle'] = $announcement_info->my->announcementstitle; 
				$announcementstype = $announcement_info->my->announcementstype;  
				$announcementlist[$pos]['announcementstype'] = $picklists[$announcementstype]; 
				$announcementlist[$pos]['simple_desc'] = $announcement_info->my->simple_desc; 
				$description = $announcement_info->my->description; 
				$announcementlist[$pos]['description'] = $description; 
				$announcementlist[$pos]['releasedate'] = $announcement_info->my->releasedate; 
				$announcementlist[$pos]['announcementsstatus'] = $announcement_info->my->announcementsstatus;  
				$announcementlist[$pos]['read_num'] = $announcement_info->my->read_num; 
				$announcementlist[$pos]['approvalstatus'] = $announcement_info->my->approvalstatus;  
				$pos++; 
		   } 
		   rsort($announcementlist);
		   echo '{"code":200,"length":'.$noofrows.',"data":'.json_encode($announcementlist).'}'; 
		   die(); 
		} 
		 
	}	 
	die(); 
}
	

if (isset($_REQUEST["parameter"]) && $_REQUEST["parameter"] != "" && isset($_REQUEST["token"]) && $_REQUEST["token"] != "") 
{
	$Sou = Verification($_REQUEST["parameter"],$_REQUEST["token"]);
	if(!isset($Sou) || !is_array($Sou) || count($Sou) <= 0){
		errorprint("错误", '参数校验错误！');
		die();
	}
	$supplierid =  $Sou["supplierid"];
	$tabid = $Sou["record"];
	$profileid = $Sou["profileid"];
	
	$_SESSION['supplierid'] = $supplierid;
	$_SESSION['profileid'] = $profileid;
	$_SESSION['tabid'] = $tabid; 
}
else
{ 
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
		messagebox("错误", '检测不到必需的请求参数！');
		die();
	} 
} 


 
if(isset($_REQUEST['type']) && $_REQUEST['type'] == 'unread' &&
   isset($_REQUEST['markid']) && $_REQUEST['markid'] != '')
{
	$markid = $_REQUEST['markid']; 
	$announcementviews = XN_Query::create ( 'Content' )->tag('announcementviews_'.$supplierid)
				->filter ( 'type', 'eic', 'announcementviews') 
				->filter ( 'my.deleted', '=', '0') 
				->filter ( 'my.supplierid', '=', $supplierid)
		  	    ->filter( 'my.profileid','=',$profileid)   
                ->filter( 'my.announcementid','=',$markid)   
				->end(1)
				->execute ();
	if (count($announcementviews) == 0)
	{
        $newcontent = XN_Content::create('announcementviews', '', false);
        $newcontent->my->deleted = '0';
        $newcontent->my->profileid = $profileid;
        $newcontent->my->supplierid = $supplierid;
        $newcontent->my->announcementid = $markid; 
		$tag = "announcementviews,announcementviews_" . $profileid. ",announcementviews_" . $supplierid;
	    $newcontent->save($tag);
	} 
} 

require_once('Smarty_setup.php');  
$smarty = new platform_Smarty;  

$smarty->assign("supplier_info",get_supplier_info()); 

if (isset($_REQUEST["type"]) && $_REQUEST["type"] == "read")
{
	$smarty->assign("type","read");
}
else
{ 
	$smarty->assign("type","unread");
}

$smarty->assign("copyrights",get_copyright_info());	
	
$action = strtolower(basename(__FILE__, ".php"));
$smarty->display($action . '.tpl');  

?>
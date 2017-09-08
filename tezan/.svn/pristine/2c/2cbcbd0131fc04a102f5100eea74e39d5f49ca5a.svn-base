<?php

 
set_include_path(get_include_path() . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT']); 
	
require_once('include/utils/utils.php');
require_once('modules/Users/Users.php');
require_once('config.inc.php');

header('Content-Type:text/html;charset=utf-8');
session_start();

global $currentModule; 

if (isset($_REQUEST['record']) && $_REQUEST['record'] != "" && 
	isset($_REQUEST['supplierid']) && $_REQUEST['supplierid'] != "" &&
	isset($_REQUEST['profileid']) && $_REQUEST['profileid'] != "" &&
	isset($_REQUEST['tabid']) && $_REQUEST['tabid'] != "")
{ 
    $supplierid = $_REQUEST ['supplierid']; 
	$profileid = $_REQUEST ['profileid']; 
    $record = $_REQUEST ['record'];  
	$tabid = $_REQUEST ['tabid'];  
	$token = $_REQUEST ['token']; 
	
	try{    
		$postdata = array('record'=>$record,
						   'supplierid'=>$supplierid,
						   'profileid'=>$profileid,
						   'tabid'=>$tabid,);
		$buildbody = http_build_query($postdata);			   
		$verifyToken = md5($buildbody.'tezan168');	
		
	    $takecash_token = XN_MemCache::get("sendapproval_".$token);
	 
		
		if ($verifyToken == $takecash_token)
		{
			require_once('modules/Approvals/config.func.php'); 
			XN_Profile::$VIEWER = $profileid;   
			$formodule = getModule($tabid);
			 
			$customapprovals = XN_Query::create("Content")->tag('supplier_approvalflows')
                                     ->filter("type", "eic", 'supplier_approvalflows')
                                     ->filter("my.deleted", "=", "0")
                                     ->filter("my.supplierid", "=", $supplierid)
                                     ->filter("my.customapprovalflowtabid", "=", $tabid)
                                     ->filter("my.approvalflowsstatus", "=", '1')
                                     ->end(1)
                                     ->execute();

		    if (count($customapprovals) > 0)
			{
				 sendapproval($record,$formodule,"app",'supplier_approvalflows');
			}
			else
			{
				 sendapproval($record,$formodule,"app");
			}
		} 
	}
	catch(XN_Exception $e){
		
	} 
} 



?>
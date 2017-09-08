<?php

 
set_include_path(get_include_path() . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT']); 
	
require_once('include/utils/utils.php');
require_once('modules/Users/Users.php');
require_once('config.inc.php');

header('Content-Type:text/html;charset=utf-8');
session_start();

global $currentModule; 

if (isset($_REQUEST['approvalid']) && $_REQUEST['approvalid'] != "" && 
	isset($_REQUEST['supplierid']) && $_REQUEST['supplierid'] != "" &&
	isset($_REQUEST['profileid']) && $_REQUEST['profileid'] != "" &&
	isset($_REQUEST['reply']) && $_REQUEST['reply'] != "" &&
	isset($_REQUEST['token']) && $_REQUEST['token'] != "" )
{
	
    $supplierid = $_REQUEST ['supplierid']; 
	$profileid = $_REQUEST ['profileid']; 
    $approvalid = $_REQUEST ['approvalid']; 
    $reply = $_REQUEST ['reply'];
    $reply_text = $_REQUEST ['replytext']; 
	$token = $_REQUEST ['token']; 
	
	try{    
		$postdata = array('approvalid'=>$approvalid,
						   'supplierid'=>$supplierid,
						   'profileid'=>$profileid,
						   'reply'=>$reply,
						   'replytext'=>$reply_text,);
		$buildbody = http_build_query($postdata);			   
		$verifyToken = md5($buildbody.'tezan168');	
		
	    $takecash_token = XN_MemCache::get("saveapproval_".$token);
		if ($verifyToken == $takecash_token)
		{
			require_once('modules/Approvals/config.func.php');
			$formodule = "APP"; 
			$_SESSION['supplierid'] = $supplierid; 
			XN_Profile::$VIEWER = $profileid;   
			saveapproval($approvalid, $formodule, $reply,$reply_text); 
		} 
	}
	catch(XN_Exception $e){
		
	} 
} 



?>
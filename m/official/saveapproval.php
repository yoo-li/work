<?php

session_start(); 

require_once (dirname(__FILE__) . "/../include/config.inc.php");
require_once (dirname(__FILE__) . "/../include/config.common.php");
require_once (dirname(__FILE__) . "/../include/utils.php");
require_once (dirname(__FILE__) . "/../approval/utils.php");

if(isset($_SESSION['supplierid']) && $_SESSION['supplierid'] !='' &&
	isset($_SESSION['profileid']) && $_SESSION['profileid'] !='')
{
	$supplierid =  $_SESSION["supplierid"]; 
	$profileid = $_SESSION["profileid"];
}
else
{    
	die();
} 
 

if (isset($_REQUEST['approvalid']) && $_REQUEST['approvalid'] != '' && 
	isset($_REQUEST['reply']) && $_REQUEST['reply'] != '')
{
    $approvalid = $_REQUEST ['approvalid']; 
    $reply = $_REQUEST ['reply'];
    $reply_text = $_REQUEST ['replytext']; 
	
	try{
		$takecashs['token'] = $takecash_token;
		$postdata = array('approvalid'=>$approvalid,
						   'supplierid'=>$supplierid,
						   'profileid'=>$profileid,
						   'reply'=>$reply,
						   'replytext'=>$reply_text,);
		$buildbody = http_build_query($postdata);			   
		$verifyToken = md5($buildbody.'tezan168');	
		$takecash_token = guid();			
		XN_MemCache::put($verifyToken,"saveapproval_".$takecash_token,"120");     
		$newbuildbody = $buildbody.'&token='.$takecash_token;  
// 		$MAINDOMAIN = 'http://admin.tezan.com';      //本地
//        $MAINDOMAIN = 'http://'.$_SERVER['HTTP_HOST']; //服务器
         $MAINDOMAIN = 'http://admin.business-steward.com'; //服务器
  
   		if (isset($MAINDOMAIN) && $MAINDOMAIN != "")
		{
  			$responsebody = curl_post($MAINDOMAIN.'/api/saveapproval.php?',$newbuildbody);
 			echo $responsebody;
		} 
		
	}
	catch(XN_Exception $e){
	    echo $e->getMessage();
	}

}
 



?>
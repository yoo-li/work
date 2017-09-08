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
	messagebox("错误", '检测不到必需的请求参数！');
	die();
}

if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'submit')
{
	if (isset($_REQUEST['approvalid']) && $_REQUEST['approvalid'] != '' &&
		isset($_REQUEST['reply']) && $_REQUEST['reply'] != '')
	{
		
	    $approvalid = $_REQUEST ['approvalid'];     
		$reply = $_REQUEST ['reply'];     
		$officialopinion_info = XN_Content::load($approvalid,"mall_officialorders"); 
		if ($reply == "Agree")
		{
			$officialopinion_info->my->authorized = "2";  
			$officialopinion_info->my->submitapproval = $profileid;  
			$officialopinion_info->my->submitdatetime = date("Y-m-d H:i:s");  
			$officialopinion_info->save("mall_officialtreats,mall_officialtreats_".$supplierid);
			try{   
				$takecashs['token'] = $takecash_token;
				$postdata = array('record'=>$officialopinion_info->id,
								   'supplierid'=>$supplierid, 
								   'profileid'=>$profileid,
							       'tabid'=>'3110',);
				$buildbody = http_build_query($postdata);			   
				$verifyToken = md5($buildbody.'tezan168');	
				$takecash_token = guid();			
				XN_MemCache::put($verifyToken,"sendapproval_".$takecash_token,"120");     
				$newbuildbody = $buildbody.'&token='.$takecash_token;  
				global $MAINDOMAIN;
				if (isset($MAINDOMAIN) && $MAINDOMAIN != "")
				{  
					$responsebody = curl_post($MAINDOMAIN.'/api/sendapproval.php',$newbuildbody); 
					echo $responsebody; 
				} 
			}
			catch(XN_Exception $e){
	
			} 
		}
		else
		{
			$officialopinion_info->my->authorized = "1";
			$officialopinion_info->my->approvalstatus = '1'; 
			$officialopinion_info->my->mall_officialtreatsstatus = 'Disagree';
			$officialopinion_info->my->finishapprover = $profileid;
			$officialopinion_info->my->submitapprovalreplydatetime = date("Y-m-d H:i");   
		} 
		$officialopinion_info->my->submitdatetime = date("Y-m-d H:i");  
		$officialopinion_info->save("mall_officialorders,mall_officialorders_".$supplierid);
		echo "ok";  
	}
	die();
}


require_once('Smarty_setup.php');  
$smarty = new platform_Smarty;

if(isset($_REQUEST['nextapprovalid']) && $_REQUEST['nextapprovalid'] != '')
{
	$approvalid = $_REQUEST['nextapprovalid'];
	$approval_info = XN_Content::load($approvalid,"mall_officialorders");
	$approval_info->my->sequence = strtotime("now");
	$approval_info->save("mall_officialorders,mall_officialorders_".$supplierid);
    $query = XN_Query::create ( 'Content' )->tag('mall_officialorders_'.$supplierid)
        ->filter ( 'type', 'eic', 'mall_officialorders')
        ->filter ( 'my.deleted', '=', '0')
        ->filter ( 'my.supplierid', '=', $supplierid)
        ->filter ( 'my.decider', '=', $profileid)
        ->filter ( 'my.authorized', '=', '0')
        ->order('my.sequence',XN_Order::ASC_NUMBER)
        ->end(1);
    $flag = 0;
    $num =$_GET['num'];
    $num ++;
}elseif(isset($_REQUEST['beforeapprovalid']) && $_REQUEST['beforeapprovalid'] != ''){
    $approvalid = $_REQUEST['beforeapprovalid'];
    $approval_info = XN_Content::load($approvalid,"mall_officialorders");
    $approval_info->my->sequence = strtotime("now");
    $approval_info->save("mall_officialorders,mall_officialorders_".$supplierid);
    $query = XN_Query::create ( 'Content' )->tag('mall_officialorders_'.$supplierid)
        ->filter ( 'type', 'eic', 'mall_officialorders')
        ->filter ( 'my.deleted', '=', '0')
        ->filter ( 'my.supplierid', '=', $supplierid)
        ->filter ( 'my.decider', '=', $profileid)
        ->filter ( 'my.authorized', '=', '0')
        ->order('my.sequence',XN_Order::ASC_NUMBER)
        ->end(1);
    $flag = 1;
    $num =$_GET['num'];
    $num --;
}else{
    $num = 1;
    $query = XN_Query::create ( 'Content' )->tag('mall_officialorders_'.$supplierid)
        ->filter ( 'type', 'eic', 'mall_officialorders')
        ->filter ( 'my.deleted', '=', '0')
        ->filter ( 'my.supplierid', '=', $supplierid)
        ->filter ( 'my.decider', '=', $profileid)
        ->filter ( 'my.authorized', '=', '0')
        ->order('my.sequence',XN_Order::ASC_NUMBER)
        ->end(1);
    $flag = 2;
}


$mall_officialtreats = $query->execute();
$noofrows = $query->getTotalCount();
$officialtreat = array();
if (count($mall_officialtreats) > 0)
{
	$loadcontent = $mall_officialtreats[0];
   	$officialtreat['record'] = $loadcontent->id;
	$officialtreat['published'] = $loadcontent->published;
	$officialtreat['profileid'] = $loadcontent->my->profileid;
	$officialtreat['profileid_givenname'] = getGivenName($loadcontent->my->profileid);
   	$officialtreat['baseinfo']['mall_orders_no'] = array('type'=>'span','label'=>'订单号','value'=>$loadcontent->my->mall_orders_no);
    $officialtreat['baseinfo']['sumorderstotal'] = array('type'=>'span','label'=>'总金额','value'=>$loadcontent->my->sumorderstotal);
   	$officialtreat['baseinfo']['orderdatetime'] = array('type'=>'span','label'=>'下单时间','value'=>$loadcontent->my->orderdatetime);
   
 
}
//大于小于的标识
$smarty->assign("flag",$flag);
//修改样式
if($num > $noofrows){
    $num =1;
}elseif ($num == 0){
    $num = $noofrows;
}
$smarty->assign("noofrows",$noofrows);
$smarty->assign("num",$num);
$smarty->assign("officialtreat",$officialtreat);

$smarty->assign("supplier_info",get_supplier_info()); 
$smarty->assign("theme_info",get_system_theme_info());	

$smarty->assign("copyrights",get_copyright_info());	
	
$action = strtolower(basename(__FILE__, ".php"));
$smarty->display($action . '.tpl');  

?>
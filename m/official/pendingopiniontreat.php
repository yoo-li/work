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
		isset($_REQUEST['replytext']) && $_REQUEST['replytext'] != '')
	{
	    $approvalid = $_REQUEST ['approvalid'];  
	    $reply_text = $_REQUEST ['replytext'];  
		$officialopinion_info = XN_Content::load($approvalid,"mall_officialopinions"); 
		$officialopinion_info->my->opinioned = "1";  
		$officialopinion_info->my->submitdatetime = date("Y-m-d H:i");
		$officialopinion_info->my->opinion = $reply_text;  
		$officialopinion_info->save("mall_officialopinions,mall_officialopinions_".$supplierid);
		echo "ok";  
	}
	die();
}


require_once('Smarty_setup.php');  
$smarty = new platform_Smarty;  

if(isset($_REQUEST['nextapprovalid']) && $_REQUEST['nextapprovalid'] != '')
{
	$approvalid = $_REQUEST['nextapprovalid'];
	$approval_info = XN_Content::load($approvalid,"mall_officialopinions");
	$approval_info->my->sequence = strtotime("now");
	$approval_info->save("mall_officialopinions,mall_officialopinions_".$supplierid);
    $query = XN_Query::create ( 'Content' )->tag('mall_officialopinions_'.$supplierid)
        ->filter ( 'type', 'eic', 'mall_officialopinions')
        ->filter ( 'my.deleted', '=', '0')
        ->filter ( 'my.supplierid', '=', $supplierid)
        ->filter ( 'my.profileid', '=', $profileid)
        ->filter ( 'my.opiniontype', '=', 'treat')
        ->filter ( 'my.opinioned', '=', '0')
        ->order('my.sequence',XN_Order::ASC_NUMBER)
        ->end(1);
    $num =$_GET['num'];
    $num ++;
}elseif(isset($_REQUEST['beforeapprovalid']) && $_REQUEST['beforeapprovalid'] != ''){
    $approvalid = $_REQUEST['beforeapprovalid'];
    $approval_info = XN_Content::load($approvalid,"mall_officialopinions");
    $approval_info->my->sequence = strtotime("now");
    $approval_info->save("mall_officialopinions,mall_officialopinions_".$supplierid);
    $query = XN_Query::create ( 'Content' )->tag('mall_officialopinions_'.$supplierid)
        ->filter ( 'type', 'eic', 'mall_officialopinions')
        ->filter ( 'my.deleted', '=', '0')
        ->filter ( 'my.supplierid', '=', $supplierid)
        ->filter ( 'my.profileid', '=', $profileid)
        ->filter ( 'my.opiniontype', '=', 'treat')
        ->filter ( 'my.opinioned', '=', '0')
        ->order('my.sequence',XN_Order::ASC_NUMBER)
        ->end(1);
    $num = $_GET['num'];
    $num--;
    var_dump(111);
}else{
    $num=1;
    $query = XN_Query::create ( 'Content' )->tag('mall_officialopinions_'.$supplierid)
        ->filter ( 'type', 'eic', 'mall_officialopinions')
        ->filter ( 'my.deleted', '=', '0')
        ->filter ( 'my.supplierid', '=', $supplierid)
        ->filter ( 'my.profileid', '=', $profileid)
        ->filter ( 'my.opiniontype', '=', 'treat')
        ->filter ( 'my.opinioned', '=', '0')
        ->order('my.sequence',XN_Order::ASC_NUMBER)
        ->end(1);
}
	

$mall_officialopinions	= $query->execute();
$noofrows = $query->getTotalCount(); 
$officialopinion = array();
if (count($mall_officialopinions) > 0)
{
	$mall_officialopinion_info = $mall_officialopinions[0];
	$record = $mall_officialopinion_info->my->record; 
	
	$loadcontent = XN_Content::load($record,"mall_officialtreats_".$supplierid);  
	
	$officialopinion['record'] = $mall_officialopinion_info->id;
   	$officialopinion['treatid'] = $loadcontent->id;
	$officialopinion['published'] = $loadcontent->published;
	$officialopinion['profileid'] = $loadcontent->my->profileid;
	$officialopinion['profileid_givenname'] = getGivenName($loadcontent->my->profileid);
   	$officialopinion['baseinfo']['treatobject'] = array('type'=>'span','label'=>'宴请对象','value'=>$loadcontent->my->treatobject);
   	$officialopinion['baseinfo']['participants'] = array('type'=>'span','label'=>'参与人员','value'=>$loadcontent->my->participants);
   	$officialopinion['baseinfo']['treatdatetime'] = array('type'=>'span','label'=>'宴请时间','value'=>$loadcontent->my->treatdatetime);
   	$officialopinion['baseinfo']['estimatedcost'] = array('type'=>'span','label'=>'预计费用','value'=>$loadcontent->my->estimatedcost);
   	$officialopinion['baseinfo']['percapita'] = array('type'=>'span','label'=>'人均消费','value'=>$loadcontent->my->percapita);
   	$officialopinion['baseinfo']['address'] = array('type'=>'span','label'=>'宴请地点','value'=>$loadcontent->my->address);
   	$officialopinion['baseinfo']['treatreason'] = array('type'=>'span','label'=>'宴请事由','value'=>$loadcontent->my->treatreason);
  
 
}
//大于小于的标识
$smarty->assign("flag",$flag);
//var_dump($num);die;
//修改样式
if($num > $noofrows){
    $num =1;
}elseif ($num == 0){
    $num = $noofrows;
}
$smarty->assign("num",$num);
$smarty->assign("noofrows",$noofrows);
$smarty->assign("officialopinion",$officialopinion);
$smarty->assign("supplier_info",get_supplier_info()); 
$smarty->assign("theme_info",get_system_theme_info());	

$smarty->assign("copyrights",get_copyright_info());	
	
$action = strtolower(basename(__FILE__, ".php"));
$smarty->display($action . '.tpl');  

?>
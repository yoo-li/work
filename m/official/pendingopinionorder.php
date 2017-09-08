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
        ->filter ( 'my.opiniontype', '=', 'order')
        ->filter ( 'my.opinioned', '=', '0')
        ->order('my.sequence',XN_Order::ASC)
        ->end(1);
    $flag = 0;
    $num = $_GET['num'];
    $num++;
   
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
        ->filter ( 'my.opiniontype', '=', 'order')
        ->filter ( 'my.opinioned', '=', '0')
//        ->filter('id','<',$approvalid)
        ->order('my.sequence',XN_Order::ASC)
        ->end(1);
    $flag = 1;
    $num = $_GET['num'];
    $num--;
    
}else{
    $query = XN_Query::create ( 'Content' )->tag('mall_officialopinions_'.$supplierid)
        ->filter ( 'type', 'eic', 'mall_officialopinions')
        ->filter ( 'my.deleted', '=', '0')
        ->filter ( 'my.supplierid', '=', $supplierid)
        ->filter ( 'my.profileid', '=', $profileid)
        ->filter ( 'my.opiniontype', '=', 'order')
        ->filter ( 'my.opinioned', '=', '0')
        ->order('my.sequence',XN_Order::ASC)
        ->end(1);
    $flag = 2;
    $num =1;
}
 
$mall_officialopinions	= $query->execute();
$noofrows = $query->getTotalCount();
$officialopinion = array();
if (count($mall_officialopinions) > 0)
{
	$mall_officialopinion_info = $mall_officialopinions[0];
	$record = $mall_officialopinion_info->my->record; 
	$loadcontent = XN_Content::load($record,"mall_officialorders_".$supplierid);
	$officialopinion['record'] = $mall_officialopinion_info->id;
   	$officialopinion['treatid'] = $loadcontent->id;
	$officialopinion['published'] = $loadcontent->published;
	$officialopinion['profileid'] = $loadcontent->my->profileid;
	$officialopinion['profileid_givenname'] = getGivenName($loadcontent->my->profileid);
    //   	根据订单好将商品信息查出 并写入数组 $loadcontent->my->mall_orders_no
    $result = XN_Query::create('Content')->tag("mall_officialorders")
        ->filter('type','eic','mall_officialorders')
        ->filter('my.mall_orders_no','=',$loadcontent->my->mall_orders_no)
        ->filter('my.deleted','=','0')
        ->end(1)
        ->execute();
    $orderid = $result[0]->my->orderid;
    $result = XN_Query::create('yearContent')->tag("mall_orders_products")
        ->filter('type','eic','mall_orders_products')
        ->filter('my.orderid','=',$orderid)
        ->filter('my.deleted','=','0')
        ->end(1)
        ->execute();

    //$officialopinion['baseinfo']['orderid'] = array('type'=>'span','label'=>'订单ID','value'=>$loadcontent->my->orderid);
   	$officialopinion['baseinfo']['mall_orders_no'] = array('type'=>'span','label'=>'订单号','value'=>$loadcontent->my->mall_orders_no);
    $officialopinion['baseinfo']['sumorderstotal'] = array('type'=>'span','label'=>'总金额','value'=>$loadcontent->my->sumorderstotal);
   	$officialopinion['baseinfo']['orderdatetime'] = array('type'=>'span','label'=>'下单时间','value'=>$loadcontent->my->orderdatetime);
   	$officialopinion['baseinfo']['orderdatename'] = array('type'=>'span','label'=>'商品名称','value'=>$result[0]->my->productname);
   	$officialopinion['baseinfo']['orderdatenum'] = array('type'=>'span','label'=>'商品数量','value'=>$result[0]->my->quantity);
   	$officialopinion['baseinfo']['orderdateprice'] = array('type'=>'span','label'=>'商品单价','value'=>$result[0]->my->shop_price);
    $officialopinion['baseinfo']['orderdatedesc'] = array('type'=>'span','label'=>'商品属性','value'=>$result[0]->my->propertydesc);



}  
 $officialopinion['baseinfo']['mall_orders_no']['value'];//订单号
 
  //修改样式
if($num > $noofrows){
    $num =1;
}elseif ($num == 0){
    $num = $noofrows;
}
$smarty->assign("num",$num);
$smarty->assign("flag",$flag);
$smarty->assign("noofrows",$noofrows);
$smarty->assign("officialopinion",$officialopinion);

$smarty->assign("supplier_info",get_supplier_info()); 
$smarty->assign("theme_info",get_system_theme_info());	

$smarty->assign("copyrights",get_copyright_info());	
	
$action = strtolower(basename(__FILE__, ".php"));
$smarty->display($action . '.tpl');  

?>
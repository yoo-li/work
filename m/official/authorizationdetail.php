<?php
 
session_start(); 

require_once (dirname(__FILE__) . "/../include/config.inc.php");
require_once (dirname(__FILE__) . "/../include/config.common.php");
require_once (dirname(__FILE__) . "/../include/utils.php");
header("Content-type:text/html;charset=utf-8");

if(isset($_SESSION['profileid']) && $_SESSION['profileid'] !='')
{ 
	$profileid = $_SESSION["profileid"];
}
else
{
	messagebox("错误", '检测不到必需的请求参数！');
	die();
}
global $supplierid;
if(isset($_SESSION['supplierid']) && $_SESSION['supplierid'] !='')
{ 
	$supplierid = $_SESSION["supplierid"]; 
}
else
{
	messagebox("错误", '检测不到必需的请求参数！');
	die();
} 

$officialauthorizeevent = array();
if(isset($_REQUEST['record']) && $_REQUEST['record'] != '')
{   
		$record = $_REQUEST['record'];
	    $loadcontent = XN_Content::load($record,"mall_officialauthorizeevents_".$supplierid);  
		 
	   	$officialauthorizeevent['record'] = $loadcontent->id; 
	   	$officialauthorizeevent['authorizationtitle'] = $loadcontent->my->authorizationtitle;
		if ($loadcontent->my->authorizationtype == "1")
		{
			$officialauthorizeevent['authorizationtype'] = '项目授权';
		}
		else
		{
			$officialauthorizeevent['authorizationtype'] = '日常授权';
		}
		
		$officialauthorizeevent['startdate'] = $loadcontent->my->startdate;
		$officialauthorizeevent['enddate'] = $loadcontent->my->enddate;
		if ($loadcontent->my->authorizedtype == "1")
		{
			$officialauthorizeevent['authorizedtype'] = '购物';
		}
		else
		{
			$officialauthorizeevent['authorizedtype'] = '宴请';
		} 
		$officialauthorizeevent['authorizedperson'] = join(",",getGivenNameArrByids($loadcontent->my->authorizedperson));
		$officialauthorizeevent['decider'] = join(",",getGivenNameArrByids($loadcontent->my->decider));
		$officialauthorizeevent['opinion'] = join(",",getGivenNameArrByids($loadcontent->my->opinion));
		$officialauthorizeevent['applicant'] = join(",",getGivenNameArrByids($loadcontent->my->applicant));
		$officialauthorizeevent['authorizationdescription'] = $loadcontent->my->authorizationdescription; 


		
		$mall_officialauthorizeevents_details = XN_Query::create ( 'Content' )->tag ( 'mall_officialauthorizeevents_details' )
			->filter ( 'type', 'eic', 'mall_officialauthorizeevents_details' ) 
			->filter ( 'my.deleted', '=', '0' )  
			->filter ( 'my.record', '=', $record )  
			->order('published',XN_Order::ASC) 
			->end(-1)
			->execute ();
		$details = array();
		$pos = 1;
		foreach($mall_officialauthorizeevents_details as $detail_info)
		{
			$detailid = $detail_info->id;
			$details[$detailid]['dimensiontypename'] = $detail_info->my->dimensiontypename; 
			$details[$detailid]['comparisonoperator'] = $detail_info->my->comparisonoperator;
			$details[$detailid]['dimensionvalue'] = $detail_info->my->dimensionvalue;
			$details[$detailid]['pos'] = $pos;
			$pos++;
		}
		$officialauthorizeevent['details'] = $details;  
}
else
{
	messagebox("错误", '检测不到必需的请求参数！');
	die();
}  


require_once('Smarty_setup.php');  
$smarty = new platform_Smarty;  
 

$smarty->assign("officialauthorizeevent",$officialauthorizeevent);  

$smarty->assign("supplier_info",get_supplier_info()); 

 
try{     
 
	 
}
catch(XN_Exception $e)
{
	$msg = $e->getMessage();	
	messagebox('错误',$msg);
	die(); 
}
$id = $record;
$loadcontent = XN_Query::create ( 'Content' )
    ->tag('Mall_OfficialAuthorizeEvents')
    ->filter ( 'type', 'eic', 'Mall_OfficialAuthorizeEvents')
    ->filter ( 'id', '=',$id)
    ->execute();
if(isset($_GET['flag'])){
    $sign = $_GET['flag'];
}else{
    $sign = 0;
}
$smarty->assign("sign",$sign);	 //我的授权才有提交上线
$smarty->assign("decider_now",$loadcontent[0]->my->decider);	 //决定人
$smarty->assign("authorizedperson_now",$loadcontent[0]->my->authorizedperson);	 //授权人
$smarty->assign("user_now",$profileid);	 //当前登录者身份
$smarty->assign("status_now",$loadcontent[0]->my->mall_officialauthorizeeventsstatus);	 //上线标志 0 1
$smarty->assign("id_now",$loadcontent[0]->id);	 //当前授权事件的id 唯一
$smarty->assign("theme_info",get_system_theme_info());
$smarty->assign("copyrights",get_copyright_info());
$action = strtolower(basename(__FILE__, ".php"));
$smarty->display($action . '.tpl');

?>
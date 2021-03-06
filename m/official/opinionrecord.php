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
	   isset($_REQUEST['opinion']) && $_REQUEST['opinion'] != '')
	{
		$page = $_REQUEST['page'];    
		$opinion = $_REQUEST['opinion'];    
		
		$query = XN_Query::create ( 'Content' )->tag ( 'mall_officialopinions_'.$supplierid )
			->filter ( 'type', 'eic', 'mall_officialopinions' )
			->filter ( 'my.profileid', '=', $profileid )
			->filter ( 'my.deleted', '=', '0' ) 
			->filter ( 'my.opinioned', '=', '1' ) 
			->filter ( 'my.opiniontype', '=', $opinion )  
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
		   	$approvallist[$pos]['approvalid'] = $approval_info->id;
			$approvallist[$pos]['record'] = $approval_info->my->record;
//727926s
           $record = $approvallist[$pos]['record'];
           $loadcontent_add = XN_Content::load($record,"mall_officialtreats_".$supplierid);
           $authorizeevent = $loadcontent_add->my->authorizeevent;
           $approvallist[$pos]['participants'] = $loadcontent_add->my->participants;
           $approvallist[$pos]['estimatedcost'] = $loadcontent_add->my->estimatedcost;
//727926e
			$approvallist[$pos]['published'] = $approval_info->published;
		   	$approvallist[$pos]['submitid'] = $approval_info->my->submitid;
			$approvallist[$pos]['submitgivenname'] = $approval_info->my->submitgivenname;
			$approvallist[$pos]['opinion'] = $approval_info->my->opinion;
			$approvallist[$pos]['opiniontype'] = $approval_info->my->opiniontype;
			$approvallist[$pos]['submitdatetime'] = $approval_info->my->submitdatetime; 
			$pos++; 
	   }
        echo '{"code":200,"length":'.$noofrows.',"data":'.json_encode($approvallist).'}';
	   die(); 
		 
	}
	echo '{"code":200,"length":0,"data":[]}'; 
	die(); 
}
//7261706s 待我宴请意见  添加宴请金额 宴请对象
$query = XN_Query::create ( 'Content' )->tag('mall_officialopinions_'.$supplierid)
    ->filter ( 'type', 'eic', 'mall_officialopinions')
    ->filter ( 'my.deleted', '=', '0')
    ->filter ( 'my.supplierid', '=', $supplierid)
    ->filter ( 'my.profileid', '=', $profileid)
    ->filter ( 'my.opiniontype', '=', 'treat')
    ->filter ( 'my.opinioned', '=', '0')
    ->order('my.sequence',XN_Order::ASC_NUMBER)
    ->end(1)
    ->execute();

$record = $query[0]->my->record;
if(empty($record)){
     $officialopinion = array();
    $officialopinion['baseinfo']['treatobject'] = array('type'=>'span','label'=>'宴请对象','value'=>'');
    $officialopinion['baseinfo']['estimatedcost'] = array('type'=>'span','label'=>'预计费用','value'=>'');
}else{
    $loadcontent = XN_Content::load($record,"mall_officialtreats_".$supplierid);
    $officialopinion = array();
    $officialopinion['baseinfo']['treatobject'] = array('type'=>'span','label'=>'宴请对象','value'=>$loadcontent->my->treatobject);
    $officialopinion['baseinfo']['estimatedcost'] = array('type'=>'span','label'=>'预计费用','value'=>$loadcontent->my->estimatedcost);
}
//7261706e
require_once('Smarty_setup.php');
$smarty = new platform_Smarty;
$smarty->assign("treat_pm",$officialopinion);

$smarty->assign("type",$_REQUEST["type"]); 

$smarty->assign("supplier_info",get_supplier_info()); 
$smarty->assign("theme_info",get_system_theme_info());	

$smarty->assign("copyrights",get_copyright_info());	
	
$action = strtolower(basename(__FILE__, ".php"));
$smarty->display($action . '.tpl');

?>
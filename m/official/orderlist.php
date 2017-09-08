<?php
 
session_start(); 

require_once (dirname(__FILE__) . "/../include/config.inc.php");
require_once (dirname(__FILE__) . "/../include/config.common.php");
require_once (dirname(__FILE__) . "/../include/utils.php");
require_once (dirname(__FILE__) . "/../approval/utils.php"); 
// =
if (isset($_REQUEST["parameter"]) && $_REQUEST["parameter"] != "" && isset($_REQUEST["token"]) && $_REQUEST["token"] != "")
{
    $Sou = Verification($_REQUEST["parameter"],$_REQUEST["token"]);
    if(!isset($Sou) || !is_array($Sou) || count($Sou) <= 0){
        errorprint("错误", '参数校验错误！');
        die();
    }
    $profileid = $Sou["profileid"];

    $_SESSION['profileid'] = $profileid;
}
else
{
    if(isset($_SESSION['profileid']) && $_SESSION['profileid'] !='')
    {
        $profileid = $_SESSION["profileid"];
    }
    else
    {
        messagebox("错误", '检测不到必需的请求参数！');
        die();
    }
}
//=
$supplier_profile = XN_Query::create('MainContent')->tag("supplier_profile_".$profileid)
    ->filter('type', 'eic', "supplier_profile")
    ->filter('my.deleted', '=', '0')
    ->filter('my.official', '=', '0')
    ->filter('my.profileid', '=', $profileid)
    ->end(1)
    ->execute();
$_SESSION["supplierid"] = $supplier_profile[0]->my->supplierid;
$supplierid = $_SESSION["supplierid"];
if(empty($supplierid))
{
    header("Location: index.php?parameter=".$_REQUEST["parameter"]."&token=".$_REQUEST["token"]);
    die();
}

if (isset($_REQUEST["type"]) && $_REQUEST["type"] == "ajax")
{ 
	if(isset($_REQUEST['page']) && $_REQUEST['page'] != '' )
	{
		$page = $_REQUEST['page'];     
		
		$query = XN_Query::create ( 'Content' )->tag ( 'mall_officialorders_'.$supplierid )
			->filter ( 'type', 'eic', 'mall_officialorders' )
			->filter ( 'my.profileid', '=', $profileid )
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
			$approvallist[$pos]['record'] = $approval_info->id;
			$approvallist[$pos]['published'] = $approval_info->published;
		   	$approvallist[$pos]['submitid'] = $approval_info->my->submitid;
			$approvallist[$pos]['mall_orders_no'] = $approval_info->my->mall_orders_no;
			$approvallist[$pos]['sumorderstotal'] = $approval_info->my->sumorderstotal;  
			$pos++; 
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
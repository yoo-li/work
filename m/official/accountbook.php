<?php
/*+**********************************************************************************
 * The contents of this file are subject to the 361CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  361CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/


session_start(); 

require_once (dirname(__FILE__) . "/../include/config.inc.php");
require_once (dirname(__FILE__) . "/../include/config.common.php");
require_once (dirname(__FILE__) . "/../include/utils.php");

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

if(isset($_SESSION['supplierid']) && $_SESSION['supplierid'] !='')
{
	$supplierid = $_SESSION['supplierid']; 
} 
else
{
	messagebox('错误',"没有店铺ID!"); 
	die();  
} 


 
try{    
    $commissions_query = XN_Query::create('YearContent_Count')->tag('mall_commissions_'.$profileid)
	   		->filter('type','eic','mall_commissions')
	   		->filter('my.deleted','=','0') 
            ->filter('my.supplierid','=',$supplierid) 
   		    ->filter('my.profileid','=',$profileid) 						
   		    ->rollup('my.amount')
            ->group('my.commissiontype')
	   		->begin(0)
	   		->end(-1)
	   		->execute();
   $commission = array('0'=>0,'1'=>0,'2'=>0,);
   foreach($commissions_query as $commission_info)
   {
       $amount = $commission_info->my->amount;
	   $commissiontype = $commission_info->my->commissiontype;
	   $data = $commission[$commissiontype];
       $commission[$commissiontype] = $data + floatval($amount);
   }
   
   $billwaters_query = XN_Query::create('MainYearContent_Count')->tag('mall_billwaters_'.$profileid)
   		    ->filter('type','eic','mall_billwaters')
   		    ->filter('my.deleted','=','0') 
            ->filter('my.supplierid','=',$supplierid) 
  		    ->filter('my.profileid','=',$profileid) 	
		    ->filter('my.billwatertype','in',array("share","popularize")) 					
  		    ->rollup('my.amount')
            ->group('my.billwatertype')
   		->begin(0)
   		->end(-1)
   		->execute();
  $billwater = array('share'=>0,'popularize'=>0);
  foreach($billwaters_query as $billwater_info)
  {
      $amount = $billwater_info->my->amount;
      $billwatertype = $billwater_info->my->billwatertype;
      $data = $billwater[$commissiontype];
      $billwater[$billwatertype] = $data + floatval($amount);
  }

}
catch(XN_Exception $e)
{
	$msg = $e->getMessage();	
	messagebox('错误',$msg);
	die(); 
} 

require_once('Smarty_setup.php');  
$smarty = new platform_Smarty;   

$profileinfo = array();
// $profileinfo = get_supplier_profile_info();
// $accumulatedmoney = $profileinfo['accumulatedmoney'];
// $money = $profileinfo['money'];
$accumulatedmoney = 0;
$money = 0;
$profileinfo['money'] = number_format($money,2,".","");	
$profileinfo['accumulatedmoney'] = number_format($accumulatedmoney,2,".","");	
$smarty->assign("profile_info",$profileinfo); 

$totalcommission = $commission['0']+$commission['1']+$commission['2'];
$frozencommission = $commission['0'];
$smarty->assign("frozencommission",number_format($frozencommission,2,".",""));
$smarty->assign("totalcommission",number_format($totalcommission,2,".",""));

$share = $billwater['share'];
$popularize = $billwater['popularize']; 
$smarty->assign("share",number_format($share,2,".",""));
$smarty->assign("popularize",number_format($popularize,2,".",""));

$total = $popularize + $share + $totalcommission;
$smarty->assign("total",number_format($total,2,".",""));

$smarty->assign("supplier_info",get_supplier_info()); 
$smarty->assign("theme_info",get_system_theme_info());	

$smarty->assign("copyrights",get_copyright_info());	
	
$action = strtolower(basename(__FILE__, ".php"));
$smarty->display($action . '.tpl'); 


 



?>
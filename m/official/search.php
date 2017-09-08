<?php
 
session_start(); 

require_once (dirname(__FILE__) . "/../include/config.inc.php");
require_once (dirname(__FILE__) . "/../include/config.common.php");
require_once (dirname(__FILE__) . "/../include/utils.php");
 



 
	
if( isset($_SESSION['profileid']) && $_SESSION['profileid'] !='')
{ 
	$profileid = $_SESSION["profileid"];
}
else
{
	messagebox("错误", '检测不到必需的请求参数！');
	die();
}
 

require_once('Smarty_setup.php');  
$smarty = new platform_Smarty;  

$smarty->assign("supplier_info",get_supplier_info()); 
 
$keywords = ""; 
if (isset($_REQUEST["keywords"]) && $_REQUEST["keywords"] != "")
{
    $keywords = $_REQUEST["keywords"]; 
}

try{    
	$mall_officialapplys = XN_Query::create('MainContent')->tag("mall_officialapplys" )
	    ->filter('type', 'eic', 'mall_officialapplys') 
	    ->filter('my.deleted', '=', '0')    
		->filter('my.approvalstatus', 'in', array("0","1"))
		->filter('my.profileid', '=', $profileid) 
	    ->end(-1)
	    ->execute(); 
	
	$officialapplyids = array();	
	foreach($mall_officialapplys as $mall_officialapply_info)
	{ 
		$applysupplierid = $mall_officialapply_info->my->supplierid;
		$officialapplyids[$applysupplierid] =  $mall_officialapply_info->my->approvalstatus;
	}
	$official = '1';
	$supplier_profile = XN_Query::create('MainContent')->tag("supplier_profile_" . $profileid)
	    ->filter('type', 'eic', 'supplier_profile') 
	    ->filter('my.deleted', '=', '0') 
		->filter('my.official', '=', '0') 
		->filter('my.profileid', '=', $profileid)  
	    ->end(-1)
	    ->execute();
	$suppliers = array();	  
	$supplierids = array();	
	if (count($supplier_profile) > 0)
	{ 
		foreach($supplier_profile as $supplier_profile_info)
		{ 
			$supplierids[] = $supplier_profile_info->my->supplierid; 
		}
		$official = '0';
	}
	if (count($supplierids) > 0)
	{
		if ($keywords != "")
		{
			$supplierinfos = XN_Query::create('MainContent')->tag("suppliers" )
			    ->filter('type', 'eic', 'suppliers') 
			    ->filter('my.deleted', '=', '0')  
				->filter('id', '!in', $supplierids) 
				->filter('my.suppliers_name', 'like', $keywords)   
				->order('published',XN_Order::DESC) 
			    ->end(50)
			    ->execute();
		}
		else
		{
			$supplierinfos = XN_Query::create('MainContent')->tag("suppliers" )
			    ->filter('type', 'eic', 'suppliers') 
			    ->filter('my.deleted', '=', '0')  
				->filter('id', '!in', $supplierids) 
				->order('published',XN_Order::DESC) 
			    ->end(50)
			    ->execute();
		}
		
	}
	else
	{
		if ($keywords != "")
		{
			$supplierinfos = XN_Query::create('MainContent')->tag("suppliers" )
			    ->filter('type', 'eic', 'suppliers') 
			    ->filter('my.deleted', '=', '0')   
				->filter('my.suppliers_name', 'like', $keywords)   
				->order('published',XN_Order::DESC) 
			    ->end(50)
			    ->execute();
		}
		else
		{
			$supplierinfos = XN_Query::create('MainContent')->tag("suppliers" )
			    ->filter('type', 'eic', 'suppliers') 
			    ->filter('my.deleted', '=', '0')   
				->order('published',XN_Order::DESC) 
			    ->end(50)
			    ->execute();
		} 
	} 
	  		 
	$pos = 1; 
	foreach($supplierinfos as $supplier_info)
	{
		$supplierid = $supplier_info->id;
		$suppliers_shortname = $supplier_info->my->suppliers_shortname;
		$suppliers_name = $supplier_info->my->suppliers_name;
		$mallname = $supplier_info->my->mallname;
		$suppliertype = $supplier_info->my->suppliertype;	
		$longitude = $supplier_info->my->longitude;	
		$latitude = $supplier_info->my->latitude;	
		$company = $supplier_info->my->company;	
		$companyaddress = $supplier_info->my->companyaddress;	
		$province = $supplier_info->my->province;	
		$city = $supplier_info->my->city;	
		$logo = $supplier_info->my->logo;	
		if (!isset($logo) || $logo == "")
		{
			$logo = "images/supplier.png";
		}
		$suppliers[$pos]['suppliers_name'] = $suppliers_name;
		$suppliers[$pos]['suppliers_shortname'] = $suppliers_shortname;
		$suppliers[$pos]['mallname'] = $mallname;
		$suppliers[$pos]['suppliertype'] = $suppliertype;
		$suppliers[$pos]['longitude'] = $longitude;
		$suppliers[$pos]['latitude'] = $latitude;
		$suppliers[$pos]['company'] = $company;
		$suppliers[$pos]['companyaddress'] = $companyaddress;
		$suppliers[$pos]['province'] = $province;
		$suppliers[$pos]['city'] = $city;
		$suppliers[$pos]['logo'] = $logo; 
		$suppliers[$pos]['supplierid'] = $supplierid;
		$suppliers[$pos]['profileid'] = $profileid;
		if (isset($officialapplyids[$supplierid]) && $officialapplyids[$supplierid] != "")
		{
			if ($officialapplyids[$supplierid] == "0")
			{
				$suppliers[$pos]['status'] = '已申请';
			}
			else
			{
				$suppliers[$pos]['status'] = '重新申请';
			}
		}
		else
		{
			$suppliers[$pos]['status'] = '申请加入';
		}
		$pos++; 
	}
	
	

	 
}
catch(XN_Exception $e)
{
	$msg = $e->getMessage();	
	messagebox('错误',$msg);
	die(); 
} 


$smarty->assign("suppliers",$suppliers); 
$smarty->assign("official",$official); 
 

$smarty->assign("theme_info",get_system_theme_info());	 

$smarty->assign("copyrights",get_copyright_info());	
	
$action = strtolower(basename(__FILE__, ".php"));
$smarty->display($action . '.tpl');  

?>
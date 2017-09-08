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

require_once (dirname(__FILE__) . "/config.inc.php");
require_once (dirname(__FILE__) . "/config.common.php");
require_once (dirname(__FILE__) . "/util.php");


if(isset($_SESSION['profileid']) && $_SESSION['profileid'] !='')
{
    $profileid = $_SESSION['profileid'];
}
elseif(isset($_SESSION['accessprofileid']) && $_SESSION['accessprofileid'] !='')
{
    $profileid = $_SESSION['accessprofileid'];
}
else
{
	messagebox('错误','请从微信公众号“特赞商城”或朋友圈中朋友分享链接进入本平台，如您确实采用上述方式仍然出现本信息，请与系统管理员联系。');
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
if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'submit' &&
	isset($_REQUEST['realname']) && $_REQUEST['realname'] != '' &&
	isset($_REQUEST['idcard']) && $_REQUEST['idcard'] != '' &&
	isset($_REQUEST['authenticationtype']) && $_REQUEST['authenticationtype'] != '')
{ 
	
    try
    {
		$authenticationprofiles = XN_Query::create('Content')->tag('supplier_authenticationprofiles_' . $supplierid)
	        ->filter('type', 'eic', 'supplier_authenticationprofiles')
	        ->filter('my.deleted', '=', '0')
	        ->filter('my.supplierid', '=', $supplierid)
	        ->filter('my.profileid', '=', $profileid)
	        ->end(1)
	        ->execute();
		if (count($authenticationprofiles) == 0)
		{
			    $province = trim($_REQUEST['province']); 
				$city = trim($_REQUEST['city']); 
				$district = trim($_REQUEST['district']); 
				$shortaddress = trim($_REQUEST['shortaddress']); 
				$address = $province.$city.$district." ".$shortaddress;
			    $newcontent = XN_Content::create('supplier_authenticationprofiles', '', false);
                $newcontent->my->deleted = '0';
                $newcontent->my->profileid = $profileid;
                $newcontent->my->supplierid = $supplierid;
                $newcontent->my->realname = trim($_REQUEST['realname']);
				$newcontent->my->idcard = trim($_REQUEST['idcard']);
				$newcontent->my->authenticationtype = trim($_REQUEST['authenticationtype']);
				$newcontent->my->shopname = trim($_REQUEST['shopname']);
				$newcontent->my->province = trim($_REQUEST['province']);
				$newcontent->my->city = trim($_REQUEST['city']);
				$newcontent->my->district = trim($_REQUEST['district']);
				$newcontent->my->address = $address;
				$newcontent->my->shortaddress = trim($_REQUEST['shortaddress']);
				$newcontent->my->authenticationstatus = "0";
				$newcontent->my->supplier_authenticationprofilesstatus = "JustCreated";
                $newcontent->save("supplier_authenticationprofiles,supplier_authenticationprofiles_".$profileid.",supplier_authenticationprofiles_".$supplierid);
		}
		else
		{
			    $authenticationprofile_info = $authenticationprofiles[0];
			    $province = trim($_REQUEST['province']); 
				$city = trim($_REQUEST['city']); 
				$district = trim($_REQUEST['district']); 
				$shortaddress = trim($_REQUEST['shortaddress']); 
				$address = $province.$city.$district." ".$shortaddress; 
              
                $authenticationprofile_info->my->realname = trim($_REQUEST['realname']);
				$authenticationprofile_info->my->idcard = trim($_REQUEST['idcard']);
				$authenticationprofile_info->my->authenticationtype = trim($_REQUEST['authenticationtype']);
				$authenticationprofile_info->my->shopname = trim($_REQUEST['shopname']);
				$authenticationprofile_info->my->province = trim($_REQUEST['province']);
				$authenticationprofile_info->my->city = trim($_REQUEST['city']);
				$authenticationprofile_info->my->district = trim($_REQUEST['district']);
				$authenticationprofile_info->my->address = $address;
				$authenticationprofile_info->my->shortaddress = trim($_REQUEST['shortaddress']);
				$authenticationprofile_info->my->authenticationstatus = "0";
				$$authenticationprofile_info->my->supplier_authenticationprofilesstatus = "JustCreated";
                $authenticationprofile_info->save("supplier_authenticationprofiles,supplier_authenticationprofiles_".$profileid.",supplier_authenticationprofiles_".$supplierid);

		}
	
	}
	catch (XN_Exception $e)
	{ }
}

try
{
    $authentication = array();
	$authenticationprofiles = XN_Query::create('Content')->tag('supplier_authenticationprofiles_' . $supplierid)
        ->filter('type', 'eic', 'supplier_authenticationprofiles')
        ->filter('my.deleted', '=', '0')
        ->filter('my.supplierid', '=', $supplierid)
        ->filter('my.profileid', '=', $profileid)
        ->end(1)
        ->execute();
	if (count($authenticationprofiles) > 0)
	{
		$authenticationprofile_info = $authenticationprofiles[0];
		$authentication['supplierid'] = $authenticationprofile_info->my->supplierid;
	 	$authentication['profileid'] = $authenticationprofile_info->my->profileid;
		$authentication['realname'] = $authenticationprofile_info->my->realname;
		$authentication['idcard'] = $authenticationprofile_info->my->idcard;
		$authentication['authenticationtype'] = $authenticationprofile_info->my->authenticationtype;
		$authentication['shopname'] = $authenticationprofile_info->my->shopname;
		$authentication['province'] = $authenticationprofile_info->my->province;
		$authentication['city'] = $authenticationprofile_info->my->city;
		$authentication['district'] = $authenticationprofile_info->my->district;
		$authentication['address'] = $authenticationprofile_info->my->address;
		$authentication['shortaddress'] = $authenticationprofile_info->my->shortaddress;
		$authentication['authenticationstatus'] = $authenticationprofile_info->my->authenticationstatus;
		$authentication['supplier_authenticationprofilesstatus'] = $authenticationprofile_info->my->supplier_authenticationprofilesstatus;
	}
	else 
	{ 
	    $authentication['authenticationstatus'] = -1;
	} 
  
}
catch (XN_Exception $e)
{
    $msg = $e->getMessage();
    messagebox('错误', $msg);
    die();
}

require_once('Smarty_setup.php'); 

$smarty = new vtigerCRM_Smarty;
$smarty->assign('smk_id',$_SESSION['supplierid']);
$islogined = false;
if ($_SESSION['u'] == $_SESSION['profileid'])
{
	$islogined = true;
} 
$smarty->assign("islogined",$islogined); 

$action = strtolower(basename(__FILE__,".php")); 

$recommend_info = checkrecommend();   
$smarty->assign("share_info",$recommend_info); 
$supplier_info = get_supplier_info(); 
$smarty->assign("supplier_info",$supplier_info);  
 

$smarty->assign("authentication",$authentication);  
 
$profile_info = get_supplier_profile_info();  
 
$smarty->assign("profile_info",$profile_info);

	
$sysinfo = array();
$sysinfo['action'] = 'index'; 
$sysinfo['date'] = date("md"); 
$sysinfo['api'] = $APISERVERADDRESS; 
$sysinfo['http_user_agent'] = check_http_user_agent();  
$sysinfo['domain'] = $WX_DOMAIN; 
$sysinfo['width'] = $_SESSION['width'];  
$smarty->assign("sysinfo",$sysinfo); 
 
$smarty->assign("needverifycode",'no');

$smarty->display($action.'.tpl');



?>
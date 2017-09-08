<?php
/*+********************************************************************************
 * The contents of this file are subject to the 361CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  361CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ********************************************************************************/
require_once('Smarty_setup.php');
require_once('include/utils/utils.php');

global  $currentModule;
$smarty = new vtigerCRM_Smarty;


if(isset($_REQUEST['record']) && $_REQUEST['record'] != '')
{	
	$record= $_REQUEST['record'];
	if(isset($_REQUEST['type']) && $_REQUEST['type'] == 'submit')
	{
		if(isset($_REQUEST['newpassword']) && $_REQUEST['newpassword'] != '')
		{
				try
				{     
					  $checkcode = $_REQUEST['checkcode'];
					  $guid = $_REQUEST['guid'];
					  $cache_checkcode = XN_MemCache::get("checkcode_".$guid);
				}
				catch (XN_Exception $e) 
				{
					echo '{"statusCode":"300","message":"验证码过期！","tabid":null,"closeCurrent":false, "forward":null, "forwardConfirm":null}';
					die(); 
				} 	
	            if (strtolower($cache_checkcode) != strtolower($checkcode))
	            {
					echo '{"statusCode":"300","message":"验证码错误！","tabid":null,"closeCurrent":false, "forward":null, "forwardConfirm":null}';
					die();
				}
				try
				{
					$user = XN_Content::load($record,"users");
					$profileid = $user->my->profileid;
					$profile = XN_Profile::load($profileid,"id");
					$profile->password = $_REQUEST['newpassword'];	         
					$profile->save();	
					echo '{"statusCode":"200","message":"修改密码成功!","tabid":null,"closeCurrent":true, "forward":null, "forwardConfirm":null}';
					die();
				}
				catch(XN_Exception $e)
				{}
		}
	
		echo '{"statusCode":"200","message":null,"tabid":null,"closeCurrent":true, "forward":null, "forwardConfirm":null}';
		die();
	} 
	 
	$smarty->assign("RECORD", $record);
	$smarty->assign("HasOldPassword", 'false'); 
}
else if(isset($_REQUEST['profileid']) && $_REQUEST['profileid'] != '')
{
		$profileid = $_REQUEST['profileid'];
		if(isset($_REQUEST['type']) && $_REQUEST['type'] == 'submit')
		{
			try
			{     
				  $checkcode = $_REQUEST['checkcode'];
				  $guid = $_REQUEST['guid'];
				  $cache_checkcode = XN_MemCache::get("checkcode_".$guid);
			}
			catch (XN_Exception $e) 
			{
				echo '{"statusCode":"300","message":"验证码过期！","tabid":null,"closeCurrent":false, "forward":null, "forwardConfirm":null}';
				die(); 
			} 	
            if (strtolower($cache_checkcode) != strtolower($checkcode))
            {
				echo '{"statusCode":"300","message":"验证码错误！","tabid":null,"closeCurrent":false, "forward":null, "forwardConfirm":null}';
				die(); 
			}
			try
			{	 	 
				XN_Application::$CURRENT_URL = "admin";
				$profile = XN_Profile::load($profileid,"id");
				$oldpassword = $profile->password;
				if ($oldpassword != $_REQUEST['oldpassword'])
				{
					echo '{"statusCode":"300","message":"旧密码输入错误！","tabid":null,"closeCurrent":false, "forward":null, "forwardConfirm":null}';
					die(); 
				}
				else
				{
					$profile = XN_Profile::load($profileid,"id");
					$profile->password = $_REQUEST['newpassword'];	         
					$profile->save();	
					echo '{"statusCode":"200","message":"修改密码成功!","tabid":null,"closeCurrent":true, "forward":null, "forwardConfirm":null}';
					die();
				}
			}
			catch(XN_Exception $e)
			{}
			echo '{"statusCode":"200","message":null,"tabid":null,"closeCurrent":true, "forward":null, "forwardConfirm":null}';
			die();
		} 
		
		$smarty->assign("RECORD", $profileid); 
		 
		$smarty->assign("HasOldPassword", 'true');
}



$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->assign("SUBMODULE", "Users");
$smarty->assign("OKBUTTON", "保存");
$smarty->assign("SUBACTION", "ChangePassword");

 $smarty->assign("GUID",hash('md5', guid(), false));
 
$smarty->display("Settings/changepwd.tpl");


?>
<?php
/*+**********************************************************************************
 * The contents of this file are subject to the 361CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  361CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

global $mod_strings,$app_strings,$theme,$currentModule,$current_user,$supplierid;

if (isset($_REQUEST['record']) && $_REQUEST['record'] != "" && 
    isset($_REQUEST['type']) && $_REQUEST['type'] == "submit" )
{
    try {
        $record = $_REQUEST['record'];

        $loadcontent = XN_Content::load($record,strtolower($currentModule)); 
        $loadcontent->my->approvalstatus = '2';
        $status = strtolower($currentModule).'status';
        $loadcontent->my->$status = 'Agree';
        $loadcontent->my->finishapprover = XN_Profile::$VIEWER;
        $loadcontent->my->submitapprovalreplydatetime = date("Y-m-d H:i"); 
        
		
		
		$supplierid = $loadcontent->my->supplierid;
		
		$account = $loadcontent->my->account;
		$email = $loadcontent->my->email;
		$mobile = $loadcontent->my->mobile;
		$password =$loadcontent->my->password;
		
	    $username=$account;
	    $nickname=$account;
		 
	    $supplierContent=XN_Content::load($supplierid,"suppliers");
	    $companyname=$supplierContent->my->company;
	    $bankaccount="";$bankname="";$accountname="";
	    $companyaddress=$supplierContent->my->companyaddress;
	    $system="system";
	    $browser=""; 
 

	    //审批通过后，要给供应商生成对应的用户，供应商可以使用这个用户登录后台
	    $profile = XN_Profile::create ( trim($email), $password );
	    $profile->fullName = $username.'#'.XN_Application::$CURRENT_URL;
	    $profile->mobile = trim($mobile);
	    $profile->givenname=$username;
	    $profile->companyname=$companyname;
	    $profile->bankaccount=$bankaccount;
	    $profile->bank=$bankname;
	    $profile->bankname=$accountname;
	    $profile->address=$companyaddress;
	    $profile->system=$system;
	    $profile->browser=$browser;
	    $profile->money = "0";
	    $profile->frozen_money = "0";
	    $profile->accumulatedmoney = "0";
	    $profile->status = 'True';
	    $profile->application = XN_Application::$CURRENT_URL;
	    $profile->type = "pt";
	    $profile->save ();


	    $app = XN_Application::load( XN_Application::$CURRENT_URL);
	    $author = $app->ownerName;

	    //获取供应商权限组id，即profilesid
	    $suppliers_profiles = XN_Query::create ( 'Content' )
	        ->tag("profiles")
	        ->filter ( 'type', 'eic', "profiles")
	        ->filter ( 'my.profilename ','=','商家')
	        ->filter ( 'my.deleted', '=', '0' )
	        ->end(1)
	        ->execute();
	    if(count($suppliers_profiles) > 0)
		{
	        $profilesid=$suppliers_profiles[0]->id;
	    }
	    
	    //获取本部门按sequence降序排列的最后一个人信息
	    $last_users=XN_Query::create ( 'Content' )
	        ->tag("users")
	        ->filter ( 'type', 'eic', "users")
	        ->filter ( 'my.deleted', '=', '0' )
	        ->order("my.sequence ",XN_Order::DESC_NUMBER)
	        ->end(1)
	        ->execute();
	    $last_user=$last_users[0];
	    $sequence=$last_user->my->sequence;
	    //users表里面要有对应的记录才能登录的O
	    XN_Content::create ( 'users', $username, false )
	        ->my->add ( 'profileid', $profile->screenName )
	        ->my->add ( 'profilesid', $profilesid )
	        ->my->add ( 'currency_id', '1' )
	        ->my->add ( 'date_format', 'yyyy-mm-dd' )
	        ->my->add ( 'email1', $profile->email )
	        ->my->add ( 'end_hour', '' )
	        ->my->add ( 'first_name', $nickname )
	        ->my->add ( 'hour_format', '' )
	        ->my->add ( 'imagename', '' )
	        ->my->add ( 'internal_mailer', '1' )
	        ->my->add ( 'is_admin', 'pt' )
	        ->my->add ( 'last_name', $nickname )
	        ->my->add ( 'lead_view', 'Today' )
	        ->my->add ( 'phone_mobile', $profile->mobile )
	        ->my->add ( 'reminder_interval', 'None' )
	        ->my->add ( 'reports_to_id', $author )
	        ->my->add ( 'roleid', "" )
	        ->my->add ( 'signature', '' )
	        ->my->add ( 'start_hour', '' )
	        ->my->add ( 'status', 'Active' )
	        ->my->add ( 'title', '' )
	        ->my->add ( 'user_name', $username )
	        ->my->add ( 'deleted', '0' )
	        ->my->add ( 'creator', '1' )
			->my->add ( 'user_type', 'guest' ) 
	        ->my->add ( 'sequence', intval($sequence)+1)
	        ->save('users');
		
		
		$loadcontent->my->profileid = $profile->screenName;
		
		$loadcontent->save(strtolower($currentModule));
		
		$supplier_accesssetting = XN_Query::create ( 'Content' ) ->tag('supplier_accesssetting')
		    ->filter ( 'type', 'eic', 'supplier_accesssetting')
		    ->filter ( 'my.deleted', '=', '0' )
		    ->filter ( 'my.access_name', '=' ,'供应商权限')
		    ->filter ( 'my.supplierid', '=' ,$supplierid)
			->end(-1)
		    ->execute();
		if(count($supplier_accesssetting) > 0)
		{
			$supplier_accesssetting_info = $supplier_accesssetting[0];
		    $vendor_accesssettingid = $supplier_accesssetting_info->id;
		}
		
		$supplier_departments = XN_Query::create ( 'Content' ) ->tag('supplier_departments')
		    ->filter ( 'type', 'eic', 'supplier_departments')
		    ->filter ( 'my.deleted', '=', '0' )
		    ->filter ( 'my.supplierid', '=' ,$supplierid)
			->end(1)
		    ->execute();
		if(count($supplier_departments) > 0)
		{
			$supplier_department_info = $supplier_departments[0];
		    $departmentid = $supplier_department_info->id;
		}
		$supplier_users = XN_Query::create ( 'Content' ) ->tag('supplier_users')
		    ->filter ( 'type', 'eic', 'supplier_users')
		    ->filter ( 'my.deleted', '=', '0' )
		    ->filter ( 'my.supplierid', '=' ,$supplierid)
			->filter ( 'my.supplierusertype', '=' ,'boss')
			->end(-1)
		    ->execute(); 
	
		if (count($supplier_users) > 0)
		{
			$supplier_user_info = $supplier_users[0];
			$boss = $supplier_user_info->my->profileid;
		}
        $supplier_user=XN_Content::create("supplier_users");
        $supplier_user->my->supplierid=$supplierid;
        $supplier_user->my->account=$username;
        $supplier_user->my->password=$password;
        $supplier_user->my->email=$email;
        $supplier_user->my->mobile=$mobile;
        $supplier_user->my->profileid=$profile->screenName;
        $supplier_user->my->supplierusertype='employee';
        $supplier_user->my->status='0';
        $supplier_user->my->deleted='0'; 
		$supplier_user->my->approvalstatus = '2'; 
		$supplier_user->my->supplier_usersstatus = 'Agree';
		$supplier_user->my->departments = $departmentid;
		$supplier_user->my->access_id = $vendor_accesssettingid;
		$supplier_user->my->parentsuperiors = $boss;
        $supplier_user->save("supplier_users,supplier_users_".$supplierid);

        echo '{"statusCode":"200","message":null,"tabid":"edit","closeCurrent":true,"forward":null}';
    } 
	catch ( XN_Exception $e )
    {
        echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
    }
    die();
}


require_once('Smarty_setup.php');
require_once('include/utils/utils.php');

$smarty = new vtigerCRM_Smarty;

$smarty->assign("MODULE",$currentModule);
$smarty->assign("APP",$app_strings);
$smarty->assign("MOD", $mod_strings);

if(isset($_REQUEST['record']) && $_REQUEST['record'] !='') 
{
    $record=$_REQUEST['record']; 
	$msg = "当前状态：未提交";
    $msg = '<div style="width:99%;height:136px"><textarea readonly rows="8" style="width:100%;height:125px"    class="detailedViewTextBox">'.$msg.'</textarea></div>';
	$msg .= '<div style="width:100%"><font color="red" size="2">'.getTranslatedString('LBL_APPROVALS_SURE_BUTTON_LABEL').'后，您将没有权限再进行修改，是否确定提交?</font></div>'; 
	$smarty->assign("MSG", $msg);
	$smarty->assign("SUBMODULE", $currentModule);
	$smarty->assign("SUBACTION", 'SimulateApply'); 
	$smarty->assign("OKBUTTON", getTranslatedString('LBL_APPROVALS_SURE_BUTTON_LABEL'));
    $smarty->assign("CANCELBUTTON", getTranslatedString('LBL_CANCEL_BUTTON_LABEL'));
    $smarty->assign("RECORD", $record);
}

$smarty->display('MessageBox.tpl');


?>
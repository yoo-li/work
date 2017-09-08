<?php

require_once('modules/Users/Users.php'); 
require_once('include/utils/UserInfoUtil.php');


$user_name = strtolower($_REQUEST['user_name']);
if(isset($_REQUEST['status']) && $_REQUEST['status'] != '')
	$_REQUEST['status']=$_REQUEST['status'];
else
	$_REQUEST['status']='Active';

$profileid = null;
try 
{			
	 if ($_REQUEST['mode'] == 'create')
	 {
		 $Users = XN_Query::create ( 'Content' )
				->filter ( 'type', 'eic', 'users' )
			    ->filter ( 'my.deleted', '=', '0' )
				->filter ( XN_Filter::any(XN_Filter ('my.user_name', '=', $user_name ), 
						   XN_Filter( 'my.phone_mobile', '=', $_REQUEST['phone_mobile'])))
				->execute ();

		 if (count($Users) > 0) throw new XN_Exception("账号,电子邮箱，手机必须唯一!");

		 try 
		 {
			  $profile = XN_Profile::load($user_name."#".XN_Application::$CURRENT_URL,"username"); 
		 }
		 catch ( XN_Exception $e ) 
		 {					 
		 }
		 if (isset($profile)) throw new XN_Exception($user_name."的用户名已经存在!");
	 }
	 else
	 {
		try 
		 {
			$profile = XN_Profile::load($user_name."#".XN_Application::$CURRENT_URL,"username");	
			$profileid = $profile->screenName;				
		 }
		 catch ( XN_Exception $e ) 
		 {	
			 try 
			 {
				$profile = XN_Profile::load($user_name,"username");		
				$profileid = $profile->screenName;
			 }
			 catch ( XN_Exception $e ) 
			 {			
				 throw $e;
			 }
		 }				

		 if (!isset($profile)) throw new XN_Exception($user_name."的用户名信息错误!");

		 
		 $Users = XN_Query::create ( 'Content' )
				->filter ( 'type', 'eic', 'users' )
			    ->filter ( 'my.deleted', '=', '0' )
				->filter ( 'my.user_name', '!=', $user_name )
				->filter ( 'my.phone_mobile', '=', $_REQUEST['phone_mobile'])
				->execute ();

		 if (count($Users) > 0) throw new XN_Exception("账号,电子邮箱，手机必须唯一!");	
		
	 }
} catch (XN_Exception $e) 
{	
		echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
		die;
} 

 

if (!is_admin($current_user) && !check_authorize('authorizeadmin')) 
{
	echo '{"statusCode":"300","message":"Unauthorized access to user administration."}';
	die();
}

$focus = new Users();

	
//if (!isset($_POST['is_admin'])) $_REQUEST["is_admin"] = 'off';


$thumb =  $_REQUEST['thumb'];
if (is_array($_REQUEST['thumb']))
{
	$_REQUEST['thumb'] = $thumb[0];
}


setObjectValuesFromRequest($focus);

 

if ($focus->mode == 'create')
{
	$focus->column_fields['user_type'] = 'system';
	$profileid = $focus->createProfile();
	$profile = XN_Profile::load($profileid,"id","profile_".$profileid);	
}
else
{
	$loadcontent = XN_Content::load($_REQUEST['record'],"users");
	$profileid = $loadcontent->my->profileid;
	$profile = XN_Profile::load($loadcontent->my->profileid,"id","profile_".$profileid);	
	$update = false; 
	 
	if(isset($_REQUEST['thumb']) && $_REQUEST['thumb'] !='' && $profile->link != $_REQUEST['thumb']){
		$update = true;
	    $profile->link= $_REQUEST['thumb'];
	}
	if(isset($_REQUEST['last_name']) && $_REQUEST['last_name'] !='' && $profile->givenname != $_REQUEST['last_name']){
		$update = true;
	    $profile->givenname= $_REQUEST['last_name'];
	}
	if(isset($_REQUEST['phone_mobile']) && $_REQUEST['phone_mobile'] !='' && $profile->mobile != $_REQUEST['phone_mobile']){
		$update = true;
	    $profile->mobile= $_REQUEST['phone_mobile'];
	}
	if(isset($_REQUEST['province']) && $_REQUEST['province'] !='' && $profile->province != $_REQUEST['province']){
		$update = true;
	    $profile->province= $_REQUEST['province'];
	}
	if(isset($_REQUEST['city']) && $_REQUEST['city']!='' && $profile->city != $_REQUEST['city']){
		$update = true;
	    $profile->city= $_REQUEST['city'];
	}
	if(isset($_REQUEST['district']) && $_REQUEST['district']!='' && $profile->cityarea != $_REQUEST['district']){
		$update = true;
	    $profile->cityarea= $_REQUEST['district'];
	} 
	//    $profile->location= "";


	if(isset($_REQUEST['status']) && $_REQUEST['status'] != '')
	{
		if ($profile->type != $_REQUEST['is_admin'])
		{
			$update = true;
			$profile->type = $_REQUEST['is_admin'];
		}	
	}
	try 
	{
		if ($update) 
		{
			$profile->save("profile,profile_".$profile->screenName);
			SynchronousProfile($profile->screenName);
		}
	}
	catch (XN_Exception $e) 
	{	
	 
	} 
	
} 



	
$focus->column_fields['thumb'] = $thumb;

$user_type = $focus->column_fields['user_type'];

if (isset($user_type) && $user_type != "system")
{
	$focus->column_fields['roleid'] = "";
}

try {
	$focus->saveentity("Users");
} 
catch (XN_Exception $e) 
{
	echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
	die;
}



//Creating the Privileges Flat File
require_once('modules/Users/CreateUserPrivilegeFile.php');
createUserPrivilegesfile($profileid);  
 

echo '{"statusCode":"200","tabid":"Users","closeCurrent":"true"}';

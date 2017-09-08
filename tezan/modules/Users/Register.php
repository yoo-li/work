<?php
 
require_once('utils.php');
require_once("modules/Approvals/config.func.php");
require_once('Smarty_setup.php');
global $register_settings;

global $app_strings;

$application =  XN_Application::$CURRENT_URL;
$app = XN_Application::load($application);
$author = $app->ownerName;
XN_Profile::$VIEWER = $author;

$app_strings = return_application_language(default_language());

$smarty = new vtigerCRM_Smarty;

$smarty->assign("APP",$app_strings);
$smarty->assign("copyrights",$copyrights);

$smarty->assign("table","ma_registerusers");

$smarty->assign("domain",getDomain());
  
function getDomain()
{ 
	$domainArray=explode('.',$_SERVER['HTTP_HOST']);
	$domain=$domainArray[0];
	return $domain;
}

if (isset($_REQUEST['step']) && $_REQUEST['step'] == "account_info")
{
	if (isset($_REQUEST['checkcode']) && $_REQUEST['checkcode'] != "" &&
	    isset($_REQUEST['guid']) && $_REQUEST['guid'] != "")
	{  
			$checkcode =  $_REQUEST['checkcode'];
			$guid = $_REQUEST['guid'];
			try
			{ 
				  $cache_checkcode = XN_MemCache::get("checkcode_".$guid);
		          if (strtolower($cache_checkcode) == strtolower($checkcode)) 
		          {
						$reg_info = array();
						$reg_info['username'] = $_REQUEST['username'];
					  	$reg_info['nickname'] = $_REQUEST['nickname'];
						$reg_info['password'] = $_REQUEST['password'];
						$reg_info['mobile'] = $_REQUEST['mobile'];
						$reg_info['province'] = $_REQUEST['province'];
						$reg_info['city'] = $_REQUEST['city'];
						$reg_info['district'] = $_REQUEST['district'];
						$reg_info['address'] = $_REQUEST['address'];
					  
						$guid = hash('md5', guid(), false);
						XN_MemCache::put($reg_info,"checkcode_".$guid,"6000");
						$return_msg=create_ptuser($guid);
						if($return_msg)
						{
							$smarty->assign("guid",$guid);
							$smarty->assign("step","finished");
							$smarty->display('Register.tpl');
						}
						else
						{
							$smarty->assign("guid",$guid);
							$smarty->assign("step","account_info");
							$smarty->display('Register.tpl');
						}
						die();
		          } 
			}
			catch (XN_Exception $e) 
			{ 
				  
			}   
	}
	$smarty->assign("guid",hash('md5', guid(), false));
	$smarty->assign("register_type",$reg_info['register_type']);
	$smarty->assign("step","finished");
	$smarty->display('Register.tpl');
	die();
}


$smarty->assign("guid",hash('md5', guid(), false));
$smarty->assign("step","account_info"); 
$smarty->display('Register.tpl');

function create_ptuser($guid){
	try{
		$user_info=XN_MemCache::get("checkcode_".$guid);
		$users=XN_Query::create("Content")
			->tag("ma_registerusers")
			->filter("type","eic","ma_registerusers")
			->filter("my.username","=",$user_info['username'])
			->filter("my.ma_registerusersstatus","=","Agree")
			->filter("my.deleted","=","0")
			->end(1)
			->execute();
		if(count($users))
		{
			return true;
		}
		else
		{
			$content=XN_Content::create("ma_registerusers","",false);
			$content->my->deleted='0';
			$content->my->createnew='0';
			$content->my->username=$user_info['username'];
			$content->my->nickname=$user_info['nickname'];
			$content->my->password=$user_info['password'];
			$content->my->mobile=$user_info['mobile'];
			$content->my->province=$user_info['province'];
			$content->my->city=$user_info['city'];
			$content->my->district=$user_info['district'];
			$content->my->address=$user_info['address'];
			$content->my->ma_registerusersstatus='Saved';
			$content->my->enablestatus='2';
			$content->my->submitapprovalreplydatetime='';
			$content->my->relation_id="";
			$content->save("ma_registerusers");

			$username=$content->my->username;
			$password=$content->my->password;
			$mobile=$content->my->mobile;
			$address=$content->my->address;

			if(isset($user_info["nickname"]) && $user_info["nickname"] != ""){
				$nickname = $user_info["nickname"];
			}else{
				$nickname = $username;
			}
			//审批通过后，要给供应商生成对应的用户，供应商可以使用这个用户登录后台
			
			$fullName = $username.'#'.XN_Application::$CURRENT_URL;
			
			$checkprofiles = XN_Query::create ( 'Profile' )
			    ->filter('username','=',$fullName)
				->end(1)
				->execute();
			if (count($checkprofiles) > 0)
			{
				$profile = $checkprofiles[0];
			}
			else
			{
				$profile = XN_Profile::create ( trim($username), $password );
				$profile->fullName = $fullName;
				$profile->mobile = trim($mobile);
				$profile->givenname=$nickname;
				$profile->companyname="";
				$profile->bankaccount="";
				$profile->bank="";
				$profile->bankname="";
				$profile->address=$address;
				$profile->system="";
				$profile->browser="";
				$profile->money = "0";
				$profile->frozen_money = "0";
				$profile->accumulatedmoney = "0";
				$profile->status = 'True';
				$profile->application = XN_Application::$CURRENT_URL;
				$profile->type = "pt";
				$profile->save ("profile");
			} 
			$content->my->enablestatus=1;
			$content->my->profileid=$profile->screenName;

			$app = XN_Application::load( XN_Application::$CURRENT_URL);
			$author = $app->ownerName;

			//获取供应商权限组id，即profilesid
			$profilesid=initprofilebyname('注册用户');
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
				->my->add ( 'user_type', 'guest' )
				->my->add ( 'last_name', $nickname )
				->my->add ( 'lead_view', 'Today' )
				->my->add ( 'phone_mobile', $profile->mobile )
				->my->add ( 'reminder_interval', 'None' )
				->my->add ( 'reports_to_id', $author )
				->my->add ( 'signature', '' )
				->my->add ( 'start_hour', '' )
				->my->add ( 'status', 'Active' )
				->my->add ( 'title', '' )
				->my->add ( 'user_name', $username )
				->my->add ( 'deleted', '0' )
				->my->add ( 'creator', '1' )
				->my->add ( 'sequence', $sequence)
				->save('users');
			$content->my->approvalstatus='2';
			$content->my->ma_registerusersstatus = 'Agree';
			$content->my->finishapprover = XN_Profile::$VIEWER;
			$content->my->submitapprovalreplydatetime = date("Y-m-d H:i");
			$content->save("ma_registerusers");
			$approvals = XN_Query::create('Content')
				->tag('approvals')
				->filter('type', 'eic', 'approvals')
				->filter('my.deleted', '=', '0')
				->filter('my.record', '=', $content->id)
				->execute();
			foreach($approvals as $approval_info){
				$approval_info->my->finished = 'true';
				$approval_info->my->approvalstatus = '2';
				$approval_info->my->reply_text = "自动审批通过";
				$approval_info->my->reply = 'Agree';
				$approval_info->my->approver = XN_Profile::$VIEWER;
				$approval_info->my->finishapprover=XN_Profile::$VIEWER;
				$approval_info->my->submitapprovalreplydatetime = date("Y-m-d H:i:s");
			}
			XN_Content::batchsave($approvals,"approvals");
			return true;
		}
	}
	catch(XN_Exception $e){
		return false;
	}
}

function initprofilebyname($name)
{
	try
	{

		$profiles = XN_Query::create ( 'Content' )->tag('profiles')
			->filter ( 'type', 'eic', 'profiles' )
			->filter ( 'my.profilename', '=', $name )
			->filter ( 'my.deleted', '=', '0' )
			->begin(0)->end(1)
			->execute ();
		if (count($profiles) == 0)
		{

			$Administrator = XN_Content::create('profiles','',false);
			$Administrator->my->profilename  = $name;
			$Administrator->my->description   = $name;
			$Administrator->my->globalactionpermission1  = 0;
			$Administrator->my->globalactionpermission2   = 0;
			$Administrator->my->allowdeleted = 1;
			$Administrator->my->deleted = 0;
			$Administrator->save('profiles');
			$profilesid = $Administrator->id;
		}
		else
		{
			$Administrator = $profiles[0];
			$profilesid = $Administrator->id;
		}
		return $profilesid;
	} catch ( XN_Exception $e ) {
		return null;
	}
}

?>
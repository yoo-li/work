<?php
 
require_once('utils.php'); 

$startTime = microtime();
 
global $app_strings;

$app_strings = return_application_language(default_language());
 

require_once('Smarty_setup.php');
$smarty = new vtigerCRM_Smarty;

$smarty->assign("APP",$app_strings);
$smarty->assign("copyrights",$copyrights);

function getDomain()
{ 
	$domainArray=explode('.',$_SERVER['HTTP_HOST']);
	$domain=$domainArray[0];
	return $domain;
}

function randomkeys($length)
{
	$pattern='1234567890';
	for($i=0;$i<$length;$i++)
	{
	   $key .= $pattern{mt_rand(0,9)};    //生成php随机数
	}
	return $key;
}



if (isset($_REQUEST['step']) && $_REQUEST['step'] == "forgot_pwd")
{
	if (isset($_REQUEST['username']) && $_REQUEST['username'] != "" &&
	    isset($_REQUEST['checkcode']) && $_REQUEST['checkcode'] != "" &&
	    isset($_REQUEST['guid']) && $_REQUEST['guid'] != "")
	{
			 
			$checkcode =  $_REQUEST['checkcode'];
			$guid = $_REQUEST['guid'];
			try
			{ 
				  $cache_checkcode = XN_MemCache::get("checkcode_".$guid);
		          if (strtolower($cache_checkcode) != strtolower($checkcode)) 
		          {
					  $smarty->assign("GUID",hash('md5', guid(), false));
					  $smarty->assign("STEP","forgot_pwd");  
					  $smarty->assign("domain",getDomain());
					  $smarty->display('Forgetpassword.tpl');
					  die(); 
		          } 
			}
			catch (XN_Exception $e) 
			{ 
				  $smarty->assign("GUID",hash('md5', guid(), false));
				  $smarty->assign("STEP","forgot_pwd"); 
				  $smarty->assign("domain",getDomain());
				  $smarty->display('Forgetpassword.tpl');
				  die(); 
			}  

			try 
			{ 
				$username = $_REQUEST['username'];  
			    $users = XN_Query::create ( 'Content' )->tag("users")
			        ->filter ( 'type', 'eic', 'Users' )
			        ->filter ( 'my.deleted', '=', '0' )
			        ->filter ( 'my.status', '=', 'Active' )
					->filter ( XN_Filter::any(XN_Filter('my.phone_mobile','=',$username),XN_Filter('my.user_name','=',$username))) 
					->end(1)
			        ->execute ();
				if (count($users) == 0)
				{
	  				  $smarty->assign("GUID",hash('md5', guid(), false));
	  				  $smarty->assign("STEP","forgot_pwd"); 
	  				  $smarty->display('Forgetpassword.tpl');
	  				  die(); 
				}
				$user_info = $users[0];
				$profileid = $user_info->my->profileid;
				$mobile = $user_info->my->phone_mobile;
				$user_name = $user_info->my->user_name;
				
				$guid = hash('md5', guid(), false); 
				XN_MemCache::put($guid,"sendmobile_".$profileid,"600");  
				$smarty->assign("PROFILEID",$profileid);
				$smarty->assign("USERNAME",$user_name);
				$smarty->assign("MOBILE",$mobile); 
				$smarty->assign("GUID",$guid);
				$smarty->assign("STEP","verify_user"); 
				$smarty->assign("domain",getDomain());
				$smarty->display('Forgetpassword.tpl');
				die();
				 
			}
			catch ( XN_Exception $e ) 
			{
				 
			}
	}
    $smarty->assign("GUID",hash('md5', guid(), false));
    $smarty->assign("STEP","forgot_pwd"); 
	$smarty->assign("domain",getDomain());
    $smarty->display('Forgetpassword.tpl');
    die();
}



if (isset($_REQUEST['step']) && $_REQUEST['step'] == "verify_user")
{
	if (isset($_REQUEST['checkcode']) && $_REQUEST['checkcode'] != "" &&
		isset($_REQUEST['profileid']) && $_REQUEST['profileid'] != "" &&
	    isset($_REQUEST['guid']) && $_REQUEST['guid'] != "")
	{ 
			$guid = $_REQUEST['guid'];
			$checkcode =  $_REQUEST['checkcode'];
			$profileid =  $_REQUEST['profileid']; 
			try
			{ 
				  $cache_checkcode = XN_MemCache::get("sendmobilecode_".$profileid);
		          if (strtolower($cache_checkcode) != strtolower($checkcode)) 
		          {
					  $smarty->assign("GUID",hash('md5', guid(), false));
					  $smarty->assign("STEP","forgot_pwd"); 
					  $smarty->assign("domain",getDomain());
					  $smarty->display('Forgetpassword.tpl');
					  die(); 
		          } 
			}
			catch (XN_Exception $e) 
			{ 
				  $smarty->assign("GUID",hash('md5', guid(), false));
				  $smarty->assign("STEP","forgot_pwd"); 
				  $smarty->assign("domain",getDomain());
				  $smarty->display('Forgetpassword.tpl');
				  die(); 
			}  
			 
			$guid = hash('md5', guid(), false); 
			XN_MemCache::put($guid,"forgot_pwd_pass_".$profileid,"600");  
			$smarty->assign("PROFILEID",$profileid); 
		    $smarty->assign("GUID",$guid);
		    $smarty->assign("STEP","new_pwd"); 
			$smarty->assign("domain",getDomain());
		    $smarty->display('Forgetpassword.tpl');
		    die();  
	} 
}



if (isset($_REQUEST['step']) && $_REQUEST['step'] == "new_pwd")
{
	if (isset($_REQUEST['newpassword']) && $_REQUEST['newpassword'] != "" &&
		isset($_REQUEST['profileid']) && $_REQUEST['profileid'] != "" &&
	    isset($_REQUEST['guid']) && $_REQUEST['guid'] )
	{  
			$guid = $_REQUEST['guid'];
			$newpassword =  $_REQUEST['newpassword'];
			$profileid =  $_REQUEST['profileid']; 
			try
			{ 
				  $cache_guid = XN_MemCache::get("forgot_pwd_pass_".$profileid);
		          if (strtolower($cache_guid) != strtolower($guid)) 
		          {
					  $smarty->assign("GUID",hash('md5', guid(), false));
					  $smarty->assign("STEP","forgot_pwd"); 
					  $smarty->assign("domain",getDomain());
					  $smarty->display('Forgetpassword.tpl');
					  die(); 
		          } 
			}
			catch (XN_Exception $e) 
			{ 
				  $smarty->assign("GUID",hash('md5', guid(), false));
				  $smarty->assign("STEP","forgot_pwd"); 
				  $smarty->assign("domain",getDomain());
				  $smarty->display('Forgetpassword.tpl');
				  die(); 
			}  
			
            try {
                    $profile_info = XN_Profile::load($profileid,"id","profile_".$profileid);
		            $profile_info->password = $newpassword;
		            $profile_info->save("profile_".$profileid); 
		            $smarty->assign("STEP","finished");
					$smarty->assign("domain",getDomain());
		            $smarty->display('Forgetpassword.tpl');
		            die();
            }
			catch (XN_Exception $q){
				  $smarty->assign("GUID",hash('md5', guid(), false));
				  $smarty->assign("STEP","forgot_pwd"); 
				  $smarty->assign("domain",getDomain());
				  $smarty->display('Forgetpassword.tpl');
				  die();
            } 
	} 
}


$smarty->assign("GUID",hash('md5', guid(), false));
$smarty->assign("STEP","forgot_pwd"); 
$smarty->assign("domain",getDomain());
$smarty->display('Forgetpassword.tpl');

?>
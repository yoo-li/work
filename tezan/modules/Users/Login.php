<?php


require_once('utils.php');
 
try {
    if (XN_Application::$CURRENT_URL != "my")
    {
        $app = XN_Application::load(XN_Application::$CURRENT_URL);
        if ( $app->name == null)
        {
            errorprint('错误','当前域名还没有使用。 <a href="/register.php">用户注册</a><br><div style="text-align: left;padding-left: 30px;">联系人：王真明<br>手&nbsp;&nbsp;&nbsp;机：15974160308<br>邮&nbsp;&nbsp;&nbsp;箱：admin@oldhand.cn<br>Q&nbsp;&nbsp;&nbsp;&nbsp;Q：68594864</div>');
        }
        else
        {
            $appname = $app->description;
        }
    }
} 
catch (XN_Exception $e)
{
    if ($e->getMessage() == 'couldn\'t connect to host')
    {
        errorprint('错误',"无法连接到REST服务器，请联系管理员<br><div style='text-align: left;padding-left: 30px;'>联系人：王真明<br>手&nbsp;&nbsp;&nbsp;机：15974160308<br>邮&nbsp;&nbsp;&nbsp;箱：admin@oldhand.cn<br>Q&nbsp;&nbsp;&nbsp;&nbsp;Q：68594864</div>");

    }
    else
    {
        errorprint('错误',$e->getMessage());
    }
    die();

}

function getDomain()
{ 
	$domainArray=explode('.',$_SERVER['HTTP_HOST']);
	$domain=$domainArray[0];
	return $domain;
}

require_once('Smarty_setup.php');

global $app_strings; 
global $mod_strings;
global $currentModule,$default_charset;


$smarty=new vtigerCRM_Smarty;


$smarty->assign("UMOD", $mod_strings);
global $current_language;
$smod_strings = return_module_language($current_language,'Users');
$smarty->assign("MOD", $smod_strings);
$smarty->assign("APP", $app_strings);
$smarty->assign("MODULE", 'Users');
$smarty->assign("domain",getDomain());
 

if (isset($_REQUEST['f']) && $_REQUEST['f'] == "login")
{
    if (isset($_REQUEST['username']) && $_REQUEST['username'] != ""
        &&isset($_REQUEST['password']) && $_REQUEST['password'] != ""
        &&isset($_REQUEST['guid']) && $_REQUEST['guid'] != "")
    {
        $user_name = $_REQUEST['username'];
        $user_password = $_REQUEST['password'];  
        $guid = $_REQUEST['guid'];


        if (isset($_SESSION['needcheckcode']) && $_SESSION['needcheckcode'] != "")
        {
            $checkcode =  $_REQUEST['checkcode']; 
			try
			{ 
				  $cache_checkcode = XN_MemCache::get("checkcode_".$guid);
			}
			catch (XN_Exception $e) 
			{ 
                $smarty->assign("ERRORMESSAGE","验证码输入错误，请重新输入。");
                $smarty->assign("GUID",$guid);
                $_SESSION['needcheckcode'] = 'yes';
			} 
            if (strtolower($cache_checkcode) == strtolower($checkcode))
            { 
                try
                {  
                    signIn($user_name,$user_password); 
                    die();
                } 
				catch ( XN_Exception $e )
                { 
                    $smarty->assign("ERRORMESSAGE",$e->getMessage ());
                    $smarty->assign("GUID",$guid);
                    $_SESSION['needcheckcode'] = 'yes';
                }
            }
            else
            {
                $smarty->assign("ERRORMESSAGE","验证码输入错误，请重新输入。");
                $smarty->assign("GUID",$guid);
                $_SESSION['needcheckcode'] = 'yes';
            }
        }
        else
        {
            try
            {

                signIn($user_name,$user_password); 
                die();
            } catch ( XN_Exception $e )
            { 
                $smarty->assign("ERRORMESSAGE",$e->getMessage ());
                $_SESSION['needcheckcode'] = 'yes';
                $smarty->assign("GUID",$guid);
            }
        }

    }
    else
    {
        $smarty->assign("ERRORMESSAGE","输入错误，请重新输入。");
        $guid = hash('md5', guid(), false);
        $_SESSION['needcheckcode'] = 'yes';
        $smarty->assign("GUID",$guid);
    }
}
else
{
    $smarty->assign("GUID",hash('md5', guid(), false));
} 


if (isset($_SESSION['needcheckcode']) && $_SESSION['needcheckcode'] != "")
{
    $smarty->assign("CHECKCODE",$_SESSION['needcheckcode']);
}
else
{
    $smarty->assign("CHECKCODE","");
}
$domain = getDomain();
if ($domain == "admin")
{
	$login_logo = $copyrights['login_logo'];  
    $new_login_logo = str_replace('.png','_blue.png',$login_logo);
    if (@file_exists($_SERVER['DOCUMENT_ROOT'].$new_login_logo))
    {
		$copyrights['login_logo'] = $new_login_logo; 
	}
}
else if ($domain == "vip")
{
	$login_logo = $copyrights['login_logo'];   
    $new_login_logo =  str_replace('.png','_green.png',$login_logo);
    if (@file_exists($_SERVER['DOCUMENT_ROOT'].$new_login_logo))
    {
		$copyrights['login_logo'] = $new_login_logo; 
	}
}
else
{
	$login_logo = $copyrights['login_logo'];   
    $new_login_logo =  str_replace('.png','_orange.png',$login_logo); 
    if (@file_exists($_SERVER['DOCUMENT_ROOT'].$new_login_logo))
    {
		$copyrights['login_logo'] = $new_login_logo; 
	} 
}

$smarty->assign("copyrights",$copyrights);
$smarty->assign("BROWSERS", getBrowser());
$smarty->assign("BROWSERSVER", getBrowserVer());

$smarty->assign("THISYEAR",date("Y"));
$smarty->display('Login.tpl');
die();


function signIn($user_name,$user_password)
{
    try
    {
        $app = XN_Application::load(XN_Application::$CURRENT_URL);
        if ( $app->name == null) throw new XN_Exception("不存在的企业代码!");
        $author = $app->ownerName;
    }
    catch ( XN_Exception $e )
    {
        throw new XN_Exception("不存在的企业代码!");
    }
    try{
        $profile = XN_Profile::load($user_name."#".XN_Application::$CURRENT_URL,"username");
        $Users = XN_Query::create ( 'Content' )
            ->filter ( 'type', 'eic', 'users' )
            ->filter ( 'my.deleted', '=', '0' )
            ->filter ( 'my.status', '=', 'Active' )
            ->filter ( 'my.profileid', '=', $profile->screenName )
            ->execute ();
        if (count($Users) == 0 ) throw new XN_Exception("该用户不能在此应用登录!");
    }
    catch(XN_Exception $e){
        try
        {
            $profile = XN_Profile::load($user_name,"username");
        }
        catch ( XN_Exception $e )
        {
            if(preg_match("/1[3|4|5|7|8]\d{9}/",$user_name))
            {
                $wxusers = XN_Query::create ( 'Profile' )->tag('profile')
                    ->filter( 'type', '=', 'wxuser')
                    ->filter( 'mobile', '=', $user_name)
                    ->begin(0)->end(1)
                    ->execute();
                if (count($wxusers))
                {
                    $profile=$wxusers[0];
                }
                else
                {
                    try{
                        $profile = XN_Profile::load($user_name."#".XN_Application::$CURRENT_URL,"username");
                    }
                    catch(XN_Exception $e){
                        throw new XN_Exception("不存在的用户名!");
                    }
                }
            }else{
                throw new XN_Exception("不存在的用户名!");
            }
        };
        $Users = XN_Query::create ( 'Content' )
            ->filter ( 'type', 'eic', 'users' )
            ->filter ( 'my.deleted', '=', '0' )
            ->filter ( 'my.status', '=', 'Active' )
            ->filter ( 'my.profileid', '=', $profile->screenName )
            ->execute ();
        if (count($Users) == 0 ) throw new XN_Exception("该用户不能在此应用登录!");
    }
	
	global $copyrights; 
	if ($copyrights['singlelogin'] != 'disabled')
	{ 
		try
		{
			$sessionkey = "user_privileges_".XN_Application::$CURRENT_URL."_".$profile->screenName;
			$global_user_privileges = XN_MemCache::get($sessionkey);
		
			$session_id = $global_user_privileges["session_id"]; 
			$timestamp = $global_user_privileges["timestamp"]; 
		
			if ($session_id != session_id())
			{
				if (time() < $timestamp + 120)
				{
					  throw new XN_Exception("already logged.");
				} 
			}    
		}
		catch (XN_Exception $e)
		{
			if ($e->getMessage() == "already logged.")
			{
				throw new XN_Exception("用户已登录!");
			} 
		} 
	}

    try
    {
        if (true == XN_Profile::signIn($profile->screenName,$user_password, array('set-cookies' => true,'max-age' => 60*60*24*365)))
        {
            require_once('include/utils/UserInfoUtil.php');
            //Security related entries end

            unset($_SESSION['login_password']);
            unset($_SESSION['login_error']);
            unset($_SESSION['login_user_name']);
			unset($_SESSION['needcheckcode']);
			unset($_SESSION['supplierid']);
         
            $_SESSION['authenticated_user_id'] = $profile->screenName;

            // Recording the login info
            $usip=$_SERVER['REMOTE_ADDR'];
            $intime=date("Y-m-d H:i");
            require_once('modules/Users/LoginHistory.php');
            $loghistory=new LoginHistory();
            $Signin = $loghistory->user_login($profile->screenName,$user_name,$usip,$intime);

            $audit_trail  = $global_session['audit_trail'];
             
            if($audit_trail == 'true')
            {
                try {
                    $content = XN_Content::create('audit_trials','',false,true)
                        ->my->add('userid',$profile->screenName)
                        ->my->add('module','Users')
                        ->my->add('action','Authenticate')
                        ->my->add('recordid','-')
                        ->my->add('actiondate',date('Y-m-d H:i:s'))
                        ->save("Audit_trials");
                } catch ( XN_Exception $e ) {
                    echo $e->getMessage () . "<br>";
                }
            }

            require_once('modules/Users/Users.php');
            require_once('modules/Users/CreateUserPrivilegeFile.php');
            require_once('include/utils/UserInfoUtil.php');

            createUserPrivilegesfile($profile->screenName); 

            $default_theme = 'starcloud';
            $default_language = 'zh_cn';

            // store the user's theme in the session
            if (isset($_REQUEST['login_theme'])) {
                $authenticated_user_theme = $_REQUEST['login_theme'];
            }
            elseif (isset($_REQUEST['ck_login_theme']))  {
                $authenticated_user_theme = $_REQUEST['ck_login_theme'];
            }
            else {
                $authenticated_user_theme = $default_theme;
            }

            // store the user's language in the session
            if (isset($_REQUEST['login_language'])) {
                $authenticated_user_language = $_REQUEST['login_language'];
            }
            elseif (isset($_REQUEST['ck_login_language']))  {
                $authenticated_user_language = $_REQUEST['ck_login_language'];
            }
            else {
                $authenticated_user_language = $default_language;
            }

            // If this is the default user and the default user theme is set to reset, reset it to the default theme value on each login
            if($reset_theme_on_default_user && $profile->user_name == $default_user_name)
            {
                $authenticated_user_theme = $default_theme;
            }
            if(isset($reset_language_on_default_user) && $reset_language_on_default_user && $focus->user_name == $default_user_name)
            {
                $authenticated_user_language = $default_language;
            }

            $_SESSION['vtiger_authenticated_user_theme'] = $authenticated_user_theme;
            $_SESSION['authenticated_user_language'] = $authenticated_user_language;


            header("Location: index.php");

            die();
        }
        else
        {
            throw new XN_Exception('请检查用户名与密码是否输入错误!');
        }
    }
    catch ( XN_Exception $e )
    {
        throw new XN_Exception('请检查用户名与密码是否输入错误!');
    }
}

    function getBrowser(){
        $agent=$_SERVER["HTTP_USER_AGENT"];
        if(strpos($agent,'MSIE')!==false || strpos($agent,'rv:11.0')) //ie11判断
            return "ie";
        else if(strpos($agent,'Firefox')!==false)
            return "firefox";
        else if(strpos($agent,'Chrome')!==false)
            return "chrome";
        else if(strpos($agent,'Opera')!==false)
            return 'opera';
        else if((strpos($agent,'Chrome')==false)&&strpos($agent,'Safari')!==false)
            return 'safari';
        else
            return 'unknown';
    }

    function getBrowserVer(){
        if (empty($_SERVER['HTTP_USER_AGENT'])){    //当浏览器没有发送访问者的信息的时候
             return 'unknow';
        } 
        $agent= $_SERVER['HTTP_USER_AGENT'];
        if (preg_match('/MSIE\s(\d+)\..*/i', $agent, $regs))
            return $regs[1];
        elseif (preg_match('/rv:(\d+)\..*/i', $agent, $regs))
            return $regs[1];
        elseif (preg_match('/FireFox\/(\d+)\..*/i', $agent, $regs))
            return $regs[1];
        elseif (preg_match('/Opera[\s|\/](\d+)\..*/i', $agent, $regs))
            return $regs[1];
        elseif (preg_match('/Chrome\/(\d+)\..*/i', $agent, $regs))
            return $regs[1];
        elseif ((strpos($agent,'Chrome')==false)&&preg_match('/Safari\/(\d+)\..*$/i', $agent, $regs))
            return $regs[1];
        else
            return 'unknow';
    }

?>
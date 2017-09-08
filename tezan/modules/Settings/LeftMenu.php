<?php


require_once('Smarty_setup.php');
require_once("include/Tracker.php");
require_once("include/utils/utils.php");
require_once('modules/Home/Home.php');

global $currentModule;
global $app_strings;
global $app_list_strings;
global $moduleList;

$smarty = new vtigerCRM_Smarty;
$header_array = getHeaderArray();
$smarty->assign("HEADERS",$header_array);
$ShortCut_array = getShortCutArray();
$smarty->assign("SHORTCUTS",$ShortCut_array);

$category = getParentTab();
$smarty->assign("CATEGORY",$category);
$header_label_array = getHeaderLabelArray();
$smarty->assign("HEADERLABELS",$header_label_array);
$smarty->assign("APP", $app_strings);
$smarty->assign("MODULE", $currentModule);
$smarty->assign("ACTION", $_REQUEST['action']);
$smarty->assign("DATE", getDisplayDate(date("Y-m-d H:i")));

if (isset($_REQUEST['record']) && $_REQUEST['record'] != "" )
{
	$smarty->assign("RECORD",  $_REQUEST['record']);
}
global $current_user;

$smarty->assign("CURRENT_USER", $current_user->last_name);

try
{
	$loadcontent = XN_Content::load($current_user->profilesid,"profiles");
	$smarty->assign("PROFILENAME", $loadcontent->my->profilename);
}
catch ( XN_Exception $e ) 
{
  
}

if (!function_exists('errorprint'))
{
	function errorprint($title,$msg)
	{
	   $html = '<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>404 Not Found</title>
	<style type="text/css">
	<!--
	.t {
			font-family: Verdana, Arial, Helvetica, sans-serif;
			color: #CC0000;
	}
	.c {
			font-family: Verdana, Arial, Helvetica, sans-serif;
			font-size: 12px;
			font-weight: normal;
			color: #000000;
			line-height: 18px;
			text-align: center;
			border: 1px solid #CCCCCC;
			background-color: #FFFFEC;
	}
	body {
			background-color: #FFFFFF;
			margin-top: 100px;
	}
	-->
	</style>
	</head>
	<body>
	<div align="center">
	  <h2><span class="t">'.$title.'</span></h2>
	  <table border="0" cellpadding="8" cellspacing="0" width="460">
		<tbody>
		  <tr>
			<td class="c">'.$msg.'.</td>
		  </tr>
		</tbody>
	  </table>
	</div>
	</body>
	</html>';
	  echo $html;
	   die();
	}
}

try {
	global $global_user_privileges;
     
    $is_admin=$global_user_privileges["is_admin"];
    $current_user_roles=$global_user_privileges['current_user_roles'];
    $current_user_parent_role_seq=$global_user_privileges['current_user_parent_role_seq'];
    $current_user_profiles=$global_user_privileges['current_user_profiles'];
    $profileGlobalPermission=$global_user_privileges['profileGlobalPermission'];
    $profileTabsPermission=$global_user_privileges['profileTabsPermission'];
    $profileActionPermission=$global_user_privileges['profileActionPermission'];
    $subordinate_roles=$global_user_privileges['subordinate_roles'];
    $parent_roles=$global_user_privileges['parent_roles'];
    $subordinate_roles_users=$global_user_privileges['subordinate_roles_users'];
    $user_info=$global_user_privileges['user_info'];

    $loginInfo=XN_MemCache::get("logintime_".XN_Profile::$VIEWER);
    $lastlogintime=$loginInfo["lastlogintime"];
    $lastloginip=$loginInfo["lastloginip"];
    $smarty->assign("LASTLOGINTIME", $lastlogintime);
    $smarty->assign("LASTLOGINIP", $lastloginip);

    $app = XN_Application::load(XN_Application::$CURRENT_URL);
    $smarty->assign("TRIALTIME", date('Y-m-d',strtotime($app->trialtime)));
    $smarty->assign("CURRENT_USER_ID", XN_Profile::$VIEWER);
    $smarty->assign("MODULELISTS",$app_list_strings['moduleList']);

	global $global_session; 
	$tabdata  = $global_session['tabdata']; 
    $applicationname=$tabdata['applicationname'];
    $tab_info_array=$tabdata['tab_info_array'];
    $approvaltabs=$tabdata['approvaltabs'];
    $optionalapprovals=$tabdata['optionalapprovals'];
    $detailapprovals=$tabdata['detailapprovals'];
    $all_tabs_array=$tabdata['all_tabs_array'];
    $all_entity_tabs_array=$tabdata['all_entity_tabs_array'];
    $all_tablabels_array=$tabdata['all_tablabels_array'];
    $tab_label_array=$tabdata['tab_label_array'];
    $tab_quickcreate_array=$tabdata['tab_quickcreate_array'];
    $tab_seq_array=$tabdata['tab_seq_array'];
    $tab_ownedby_array=$tabdata['tab_ownedby_array'];
    $defaultOrgSharingPermission=$tabdata['defaultOrgSharingPermission'];


    $smarty->assign("IS_ADMIN",$is_admin);
    $smarty->assign("VIEWER",XN_Profile::$VIEWER);
    require('modules/Settings/config.setting.php');
    $smarty->assign("MENUS",$Config_Menu_Setting);

    if (!$is_admin)
    {
        $authorizes = array();
        foreach($Config_Menu_Setting as $menus)
        {
            foreach($menus as $menu => $link)
            {
                if ( 'boss_authorize' != strtolower($menu))
                {
                    $authorizes[strtolower($menu)] = strtolower($menu);
                }
            }
        }

        $authorize=XN_MemCache::get("authorize_".XN_Application::$CURRENT_URL);
        if( isset($authorize))
        {
            $authorize_menu = array();
            foreach($authorize as $key =>  $info)
            {
                if (in_array(XN_Profile::$VIEWER,$info) && in_array($key,$authorizes)) $authorize_menu[] = $key;
            }

            $smarty->assign("AUTHORIZE",$authorize_menu);
        }
    }


	$homeObj=new Homestuff;
	$homedetails = $homeObj->getHomePageFrame();
	$maxdiv = sizeof($homedetails)-1;
	$numberofcols = 3;
	$smarty->assign("MAXLEN",$maxdiv);
	$smarty->assign("HOMEFRAME",$homedetails);
	$smarty->assign("LAYOUT", $numberofcols);
	$widgetBlockSize = 12;
	$smarty->assign('widgetBlockSize', count($homedetails));

} catch (XN_Exception $e)
{
    require_once('modules/Users/Users.php');
    require_once('modules/Users/CreateUserPrivilegeFile.php');
    require_once('include/utils/UserInfoUtil.php');
    createUserPrivilegesfile(XN_Profile::$VIEWER);
    if ($e->getMessage() == 'couldn\'t connect to host')
    {
        errorprint('错误',"无法连接到REST服务器，请联系管理员<br><div style='text-align: left;padding-left: 30px;'>联系人：王真明<br>手&nbsp;&nbsp;&nbsp;机：15974160308<br>邮&nbsp;&nbsp;&nbsp;箱：admin@oldhand.cn<br>Q&nbsp;&nbsp;&nbsp;&nbsp;Q：68594864</div>");
    }
    else
    {
        errorprint('错误',$e->getMessage());
    }
}

try{
    $system_file = XN_MemCache::get("system_".XN_Application::$CURRENT_URL);
    $unitlogo = $system_file['unitlogo'];
}
catch(XN_Exception $e){}
$smarty->assign("APPLOGO", $unitlogo);

$channeltypes = XN_Query::create ( 'Content' )
			->tag ( 'channeltype' )
			->filter ( 'type', 'eic', 'ChannelType' )
			->filter ( 'my.deleted', '=', '0')
			->filter ( 'my.isshow', '=', '1')
			->execute ();

$channeltypelist = array();
foreach($channeltypes as $channeltype_info)
{
	$channeltypelist[$channeltype_info->id] = $channeltype_info->my->typename;
}

if (count($channeltypelist) > 0)
{
	$arctypes = XN_Query::create ( 'Content' )
				->tag ( 'arctype' )
				->filter ( 'type', 'eic', 'ArcType' )
				->filter ( 'my.deleted', '=', '0')
				->filter ( 'my.channeltype', 'in', array_keys($channeltypelist))
				->execute ();

	$arctypelist = array();
	foreach($arctypes as $arctype_info)
	{
		$channeltype = $arctype_info->my->channeltype;
		$typename = $channeltypelist[$channeltype];
		$arctypelist[$channeltype] = $typename;
	}
}

$smarty->assign("ARCTYPELIST", $arctypelist);
$smarty->assign("DESCRIPTION", XN_Application::$DESCRIPTION);
if (preg_match("/[\w\-]+\.\w+$/", $_SERVER['SERVER_NAME'], $domain))
{
	$smarty->assign("DOMAIN",strtolower($domain[0]));
}

 
$profile = XN_Profile::load (XN_Profile::$VIEWER,"id","profile");	
if ( $profile->type == "superadmin" || $profile->type == "superuser")
{
	$xn_applications = XN_Query::create('Application')
					->tag(XN_Application::$CURRENT_URL)
					->begin(0)
					->end(-1)
					->order('trialtime',XN_Order::ASC)
					->execute();

	$citylists = array(); 
	foreach($xn_applications as $app_info)
	{
		if ($app_info->name != "www")
			$citylists[$app_info->name] =  $app_info->description;
	}	
	$smarty->assign("CITYLISTS", $citylists);
}


$results = XN_Query::create ( 'Content' )->tag ( 'programs' )
				->filter ( 'type', 'eic', 'programs' ) 
				->filter ( 'my.status', '=', '0' ) 
				->execute ();
$programs = array(); 
if (count($results) > 0)
{
	foreach($results as $program_info)
	{
		$programs[$program_info->my->name] =  'true';
	}			
}

$smarty->assign("PROGRAMS", $programs);


$smarty->display("LeftMenu.tpl");
?>

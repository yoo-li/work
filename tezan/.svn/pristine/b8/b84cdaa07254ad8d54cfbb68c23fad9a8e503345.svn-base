<?php

require_once('Smarty_setup.php');
require_once("include/utils/utils.php");

global $currentModule;
global $app_strings;
global $app_list_strings;
global $moduleList;

$smarty = new vtigerCRM_Smarty;

$header_array = getHeaderArray();
getAggregate($header_array,getSubHeaderArray());

$reports = array();
 
if ($copyrights['program'] == 'ma')
{
	$employess = XN_Query::create("Content")->tag("ma_staffs")
						 ->filter("type", "eic", "ma_staffs")
						 ->filter('my.status', '=', '0')
						 ->filter("my.profileid", "=", XN_Profile::$VIEWER)
						 ->filter("my.deleted", "=", "0")
						 ->end(1)
						 ->execute();
	if(count($employess) > 0)
	{
		$supplierid = $employess[0]->my->supplierid;
		$access_id = $employess[0]->my->access_id;
		$isboss = false;
		 
		try{
			 $accessContent  = XN_Content::load($access_id, "ma_accesssetting"); 
			if($accessContent->my->isadmin == '1'){
				$isboss = true;
			}
		}
		catch(XN_Exception $e){}
		 
		
		if(isset($supplierid) && $supplierid != "")
		{
			$query   = XN_Query::create("Content")->tag("ma_reportsettingscategorys")->end(-1)
							   ->filter("type", "eic", "ma_reportsettingscategorys")
							   ->filter("my.deleted", "=", "0")
							   ->filter("my.supplierid", "=", $supplierid)
							   ->order("my.sequence", XN_Order::ASC_NUMBER)
							   ->execute();
			foreach($query as $item){
				$reporttype[$item->id] = $item->my->categorys;
			}

			$query = XN_Query::create("Content")->tag("ma_reportsettings")->end(-1)
				->filter("type", "eic", "ma_reportsettings")
				->filter("my.supplierid", "=", $supplierid)
				->filter("my.status", "=", "0")
				->filter("my.deleted", "=", "0")
				->order("my.reporttype", XN_Order::ASC_NUMBER);
			if(!$isboss){
				$query->filter("my.reportuser", "=", $current_user->id);
			}
			$query = $query->execute();
			$reportsinfo = array();
			foreach($query as $item){
				$reportsinfo[$item->my->reporttype][$item->id] = array(
					"reportname" => $item->my->reportname,
					"reportgroup" => $item->my->reportgroup,
				);

			}
			if(count($reportsinfo) > 0){
				foreach($reporttype as $key => $item){
					if(array_key_exists($key,$reportsinfo))
					{
						$reports[$item] = array ();
					}
				}
				foreach($reportsinfo as $key => $item){
					foreach($item as $id => $info){
						$reports[$reporttype[$key]][$info["reportgroup"]][$id] = $info["reportname"];
					}
				}
			}
		}
	}
}
else if ($copyrights['program'] == 'tezan')
{
    $employess = XN_Query::create ( 'Content' ) ->tag('supplier_users')
        ->filter ( 'type', 'eic', 'supplier_users')
        ->filter ( 'my.deleted', '=', '0' )
        ->filter ( 'my.profileid', '=' ,XN_Profile::$VIEWER)
		 ->end(1)
        ->execute();
	if(count($employess) > 0)
	{
		$supplierid = $employess[0]->my->supplierid;
		$supplierusertype= $employess[0]->my->supplierusertype; 
		
		if(isset($supplierid) && $supplierid != "")
		{
			$query   = XN_Query::create("Content")->tag("supplier_reportsettingscategorys")->end(-1)
							   ->filter("type", "eic", "supplier_reportsettingscategorys")
							   ->filter("my.deleted", "=", "0")
							   ->filter("my.supplierid", "=", $supplierid)
							   ->order("my.sequence", XN_Order::ASC_NUMBER)
							   ->execute();
			foreach($query as $item){
				$reporttype[$item->id] = $item->my->categorys;
			}

			$query = XN_Query::create("Content")->tag("supplier_reportsettings")->end(-1)
				->filter("type", "eic", "supplier_reportsettings")
				->filter("my.supplierid", "=", $supplierid)
				->filter("my.status", "=", "0")
				->filter("my.deleted", "=", "0")
				->order("my.reporttype", XN_Order::ASC_NUMBER);
			if($supplierusertype != "boss"){
				$query->filter("my.reportuser", "=", XN_Profile::$VIEWER);
			}
			$query = $query->execute();
			$reportsinfo = array();
			foreach($query as $item){
				$reportsinfo[$item->my->reporttype][$item->id] = array(
					"reportname" => $item->my->reportname,
					"reportgroup" => $item->my->reportgroup,
				);

			}
			if(count($reportsinfo) > 0){
				foreach($reporttype as $key => $item){
					if(array_key_exists($key,$reportsinfo))
					{
						$reports[$item] = array ();
					}
				}
				foreach($reportsinfo as $key => $item){
					foreach($item as $id => $info){
						$reports[$reporttype[$key]][$info["reportgroup"]][$id] = $info["reportname"];
					}
				}
			}
		}
	}
} 
 


 
if (count($reports) > 0)
{
	$header_array['Analytics'] = $reports;
	$smarty->assign("HASREPORT", 'true');
} 

 
$smarty->assign("HEADERS", $header_array);

$ShortCut_array = getShortCutArray();
$smarty->assign("SHORTCUTS", $ShortCut_array);

$category = getParentTab();
$smarty->assign("CATEGORY", $category);
$header_label_array = getHeaderLabelArray();
$smarty->assign("HEADERLABELS", $header_label_array);
$smarty->assign("APP", $app_strings);
$smarty->assign("MODULE", $currentModule);
$smarty->assign("ACTION", $_REQUEST['action']);
$smarty->assign("DATE", getDisplayDate(date("Y-m-d H:i")));

if (isset($_REQUEST['record']) && $_REQUEST['record'] != "")
{
    $smarty->assign("RECORD", $_REQUEST['record']);
}
global $current_user;
$givename = $current_user->givename;
if (isset($givename) && $givename != "")
{
    $smarty->assign("CURRENT_USER", $givename);
}
else
{
    $smarty->assign("CURRENT_USER", $current_user->last_name);
}


if (!function_exists('errorprint'))
{
    function errorprint($title, $msg)
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
	  <h2><span class="t">' . $title . '</span></h2>
	  <table border="0" cellpadding="8" cellspacing="0" width="460">
		<tbody>
		  <tr>
			<td class="c">' . $msg . '.</td>
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

try
{
	global $global_user_privileges; 
    $is_admin = $global_user_privileges["is_admin"];
    $current_user_roles = $global_user_privileges['current_user_roles'];
    $current_user_parent_role_seq = $global_user_privileges['current_user_parent_role_seq'];
    $current_user_profiles = $global_user_privileges['current_user_profiles'];
    $profileGlobalPermission = $global_user_privileges['profileGlobalPermission'];
    $profileTabsPermission = $global_user_privileges['profileTabsPermission'];
    $profileActionPermission = $global_user_privileges['profileActionPermission'];
    $subordinate_roles = $global_user_privileges['subordinate_roles'];
    $parent_roles = $global_user_privileges['parent_roles'];
    $subordinate_roles_users = $global_user_privileges['subordinate_roles_users'];

    try
    {
	    $loginInfo = XN_MemCache::get("logintime_" . XN_Profile::$VIEWER);
	    $lastlogintime = $loginInfo["thislogintime"];
	    $lastloginip = $loginInfo["thisloginip"];
         
    }
    catch (XN_Exception $e)
    {
        $loginhistorys = XN_Query::create('BigContent')->tag("loginhistorys_".XN_Profile::$VIEWER)
            ->filter('type', 'eic', 'loginhistorys')
            ->filter('my.user_id', '=', XN_Profile::$VIEWER)
			->filter('published', '>', date("Y-m-d")." 00:00:00")
			->order('published', XN_Order::DESC)
            ->end(1)
		    ->execute();
       if (count($loginhistorys) > 0)
	   {
	   		$loginhistory_info = $loginhistorys[0];
		    $lastlogintime = $loginhistory_info->my->login_time;
		    $lastloginip = $loginhistory_info->my->user_ip;
            $loginInfo  = array ();
            $loginInfo["thisloginip"]   = $lastloginip;
            $loginInfo["thislogintime"] = $lastlogintime;
            XN_MemCache::put($loginInfo, "logintime_". XN_Profile::$VIEWER);
	   }      
    } 
	
    $smarty->assign("LASTLOGINTIME", $lastlogintime);
    $smarty->assign("LASTLOGINIP", $lastloginip);
	
	
    $app = XN_Application::load(XN_Application::$CURRENT_URL);
    $smarty->assign("TRIALTIME", date('Y-m-d', strtotime($app->trialtime)));
    $smarty->assign("CURRENT_USER_ID", XN_Profile::$VIEWER);
    $smarty->assign("MODULELISTS", $app_list_strings['moduleList']);

	global $global_session; 
	$tabdata = $global_session['tabdata'];
    $applicationname = $tabdata['applicationname'];
    $tab_info_array = $tabdata['tab_info_array'];
    $approvaltabs = $tabdata['approvaltabs'];
    $optionalapprovals = $tabdata['optionalapprovals'];
    $detailapprovals = $tabdata['detailapprovals'];
    $all_tabs_array = $tabdata['all_tabs_array'];
    $all_entity_tabs_array = $tabdata['all_entity_tabs_array'];
    $all_tablabels_array = $tabdata['all_tablabels_array'];
    $tab_label_array = $tabdata['tab_label_array'];
    $tab_quickcreate_array = $tabdata['tab_quickcreate_array'];
    $tab_seq_array = $tabdata['tab_seq_array'];
    $tab_ownedby_array = $tabdata['tab_ownedby_array'];
    $defaultOrgSharingPermission = $tabdata['defaultOrgSharingPermission'];
    $smarty->assign("APPLICATIONNAME", "【" . $app->description . "】");
    $smarty->assign("APPLICATION", XN_Application::$CURRENT_URL);

    if ($is_admin || $is_admin == 'admin' || $is_admin == 'on' || $is_admin == 'superadmin')
    {
        $is_admin = 1;
    }

    $smarty->assign("IS_ADMIN", $is_admin);
    $smarty->assign("VIEWER", XN_Profile::$VIEWER);
    require('modules/Settings/config.setting.php');
    $smarty->assign("MENUS", $Config_Menu_Setting);

    if (!$is_admin)
    {

        $authorizes = array();
        foreach ($Config_Menu_Setting as $menus)
        {
            foreach ($menus as $menu => $link)
            {
                if ('boss_authorize' != strtolower($menu))
                {
                    $authorizes[strtolower($menu)] = strtolower($menu);
                }
            }
        }
		global $global_session;
		$authorize = $global_session['authorize'];
 
        if (isset($authorize) && count($authorize) > 0)
        {
            $authorize_menu = array();
            foreach ($authorize as $key => $info)
            {
                if (in_array(XN_Profile::$VIEWER, (array)$info) && in_array($key, (array)$authorizes))
                    $authorize_menu[] = $key;
            }

            $smarty->assign("AUTHORIZE", $authorize_menu);
        }
    }
	if ($copyrights['program'] == 'ma')
	{
	    $announcement_preview = $homeframes['announcements']['add'];
		if (isset($announcement_preview) && $announcement_preview == '1')
		{
	        $register_users = XN_Query::create("Content")
	            ->tag("ma_registerusers")
	            ->filter("type", "eic", "ma_registerusers")
	            ->filter("my.profileid", "=", XN_Profile::$VIEWER) 
	            ->filter("my.deleted", "=", "0")
	            ->end(1)
	            ->execute();
			if (count($register_users) == 0)
			{
				$homeframes['announcements']['add'] = '0';
			}
		}
	    $calendar_preview = $homeframes['calendar']['add'];
		if (isset($calendar_preview) && $calendar_preview == '1')
		{
	        $register_users = XN_Query::create("Content")
	            ->tag("ma_registerusers")
	            ->filter("type", "eic", "ma_registerusers")
	            ->filter("my.profileid", "=", XN_Profile::$VIEWER) 
	            ->filter("my.deleted", "=", "0")
	            ->end(1)
	            ->execute();
			if (count($register_users) == 0)
			{
				$homeframes['calendar']['add'] = '0';
			}
		}
	} 

    $smarty->assign("HOMEFRAME", $homeframes);

}
catch (XN_Exception $e)
{    
    $errMsg = $e->getMessage();
    if ($errMsg == 'couldn\'t connect to host')
    {
        errorprint('错误', "无法连接到REST服务器，请联系管理员<br><div style='text-align: left;padding-left: 30px;'>联系人：王真明<br>手&nbsp;&nbsp;&nbsp;机：15974160308<br>邮&nbsp;&nbsp;&nbsp;箱：admin@oldhand.cn<br>Q&nbsp;&nbsp;&nbsp;&nbsp;Q：68594864</div>");
    }
    elseif ($errMsg == 'ErrorMsg:{error,"no key."}')
    {
        header("Location: index.php?action=Login&module=Users");
    }
    else
    {
        errorprint('错误', $e->getMessage());
    }
}

if ($copyrights['program'] == 'ma')
{
    if ($current_user->is_admin == 'superadmin'|| $current_user->is_admin=="admin")
    {
        $supplierusertype 		= "superadmin";
        $supplierid				= '0';
        $relation_id			= '0';
        $accesstype				= '0';
        $isplatagency           = '0';
        $user_type_id			= '0';
    }
    else
    {
        $platsuppliers=XN_Query::create("Content")
            ->tag("ma_suppliers")
            ->filter("type","eic","ma_suppliers")
            ->filter("my.isplatagency","=","1")
            ->filter("my.deleted","=","0")
            ->end(1)
            ->execute();
        if(count($platsuppliers)){
            $platsupplierid=$platsuppliers[0]->id;
        }
        else{
            $platsupplierid=0;
        }
        $staffs = XN_Query::create("Content")
            ->tag("ma_staffs")
            ->filter("type", "eic", "ma_staffs")
            ->filter("my.profileid", "=", XN_Profile::$VIEWER)
            ->filter("my.deleted", "=", "0")
            ->end(1)
            ->execute();
        if (count($staffs))
        {
            $staff_info   		= $staffs[0];
			if($staff_info->my->supplierid != "")
			{
				$user_type_id     = $staff_info->my->ma_registerusers;
				$supplierusertype = $staff_info->my->ma_registertype;
				$supplierid       = $staff_info->my->supplierid;
				$accesstype       = $staff_info->my->authorize_type;
				$relation_content = XN_Content::load($supplierid, "ma_suppliers");
				$relation_id      = $relation_content->my->relation_id;
				$isplatagency     = $relation_content->my->isplatagency;
			}else{
				$supplierusertype		= "visitor";
				$supplierid				= '0';
				$relation_id			= '0';
				$isplatagency           = 0;
				$accesstype				= '0';
			}
        }
        else
        {
            $register_users = XN_Query::create("Content")
                ->tag("ma_registerusers")
                ->filter("type", "eic", "ma_registerusers")
                ->filter("my.profileid", "=", XN_Profile::$VIEWER)
                ->filter("my.deleted", "=", "0")
                ->end(1)
                ->execute();
            if (count($register_users))
            {
                $user_type_id			= $register_users[0]->id;
                $supplierusertype		= "visitor";
            }
            else
            {
                $supplierusertype		= "admin";
                $user_type_id			= '0';
            }
            $supplierid				= '0';
            $relation_id			= '0';
            $isplatagency           = 0;
            $accesstype				= '0';
        }
    }
    try{
        $warn_memcache=XN_MemCache::get("FIRSTWARN_".XN_Profile::$VIEWER."_".date("Y-m-d"));
        $smarty->assign("SUPPLIERWARN", "true");
    }
    catch(XN_Exception $e)
	{
        $warns_query = XN_Query::create("Content_Count")
            ->tag("ma_checkwarns")
            ->filter('type', 'eic', 'ma_checkwarns');
        if($supplierusertype=="admin" || $supplierusertype=="superadmin"){
            $warns_query->filter('my.ma_registerusers', '=', "admin");
        }else{
            $warns_query->filter('my.ma_registerusers', '=', $user_type_id);
        }
        $warns_query->filter("my.modifystatus","=","1")
            ->rollup();
        $warns_query->execute();
        $warn_count=$warns_query->getTotalCount();
        if($warn_count>0){
            $smarty->assign("SUPPLIERWARN", "true");
        }
        XN_MemCache::put("true","FIRSTWARN_".XN_Profile::$VIEWER."_".date("Y-m-d"));
    }
}



$smarty->assign("DESCRIPTION", XN_Application::$DESCRIPTION);
if (preg_match("/[\w\-]+\.\w+$/", $_SERVER['SERVER_NAME'], $domain))
{
    $smarty->assign("DOMAIN", strtolower($domain[0]));
}

$results = XN_Query::create('Content')->tag('programs')
    ->filter('type', 'eic', 'programs')
    ->filter('my.status', '=', '0')
    ->execute();
$programs = array();
if (count($results) > 0)
{
    foreach ($results as $program_info)
    {
        $programs[$program_info->my->name] = 'true';
    }
}
$smarty->assign("PROGRAMS", $programs);

    /**
     * 购物车处理
     */
global $supplierusertype, $relation_id;
if($supplierusertype=="ma_hospitals"){
    $details = XN_Query::create("Content_Count")->tag("ma_shoppingcarts_details_".$relation_id)
                       ->filter('type', 'eic', 'ma_shoppingcarts_details')
                       ->filter('my.hospitals', '=', $relation_id)
                       ->rollup('my.number')
                       ->execute();
    if(count($details)>0)
    {
        $smarty->assign("shoppingcart_num", intval($details[0]->my->number));
    }else{
        $smarty->assign("shoppingcart_num", "0");
    }
}else{
    $smarty->assign("shoppingcart_num", false);
}



$approvals = XN_Query::create ( 'Content' )
    ->tag ( 'approvals' )
    ->filter ( 'type', 'eic', 'approvals' )
    ->filter ( 'my.finished', '=', 'false' )
    ->filter ( 'my.deleted', '=', '0' )
    ->filter ( XN_Filter::any(XN_Filter( 'my.userid', '=', XN_Profile::$VIEWER),XN_Filter( 'my.proxyapproval', '=', XN_Profile::$VIEWER)))
    ->execute ();
if(count($approvals) > 0)
{
    $smarty->assign("APPROVALDIALOG", "true");
}

$smarty->assign("copyrights",$copyrights);

/**
 * 扫码设备处理
 */
if(isset($_SESSION["savescanport"]) && $_SESSION["savescanport"] != ""){
	$savescanport = $_SESSION["savescanport"];
}
if(!isset($savescanport) || $savescanport == ""){
	$savescanport = "COM3";
}

global $current_user;
$smarty->assign("SELECTPRINTER", $current_user->selectprinter);


$smarty->assign("SAVESCANPORT",$savescanport);

$smarty->assign("THISYEAR",date("Y"));


function getDomain()
{ 
	$domainArray=explode('.',$_SERVER['HTTP_HOST']);
	$domain=$domainArray[0];
	return $domain;
}

$smarty->assign("domain",getDomain());

$smarty->display("Index.tpl");

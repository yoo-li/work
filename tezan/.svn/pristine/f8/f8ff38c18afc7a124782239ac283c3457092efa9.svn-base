<?php
	require_once('include/utils/utils.php');
	require_once('modules/Users/Users.php');
	require_once('config.inc.php');
	global $currentModule,$global_session,$global_user_privileges;
	$startTime = microtime();
	
	
	try
	{
		$global_session = XN_MemCache::get("session_".XN_Application::$CURRENT_URL);
		if ($global_session['run_initapp'] == "true")
		{
			header('Content-Type:text/html;charset=utf-8');
			errorprint('警告', "正在初始化配置数据，请2分钟后重试！");
			die();
		}
		
		if (isset($global_session['parent_tabdata']) && $global_session['parent_tabdata'] != "")
		{
			$parent_tabdata                 = $global_session['parent_tabdata'];
			$parent_tab_info_array          = $parent_tabdata['parent_tab_info_array'];
			$all_parent_tab_info_array      = $parent_tabdata['all_parent_tab_info_array'];
			$parent_child_tab_rel_array     = $parent_tabdata['parent_child_tab_rel_array'];
			$all_parent_child_tab_rel_array = $parent_tabdata['all_parent_child_tab_rel_array'];
		}
		else
		{ 
			$parent_tabdata                 = create_parenttab_data_file();
			$global_session['parent_tabdata'] = $parent_tabdata;
			$parent_tab_info_array          = $parent_tabdata['parent_tab_info_array'];
			$all_parent_tab_info_array      = $parent_tabdata['all_parent_tab_info_array'];
			$parent_child_tab_rel_array     = $parent_tabdata['parent_child_tab_rel_array'];
			$all_parent_child_tab_rel_array = $parent_tabdata['all_parent_child_tab_rel_array'];
		}
		
		if (isset($global_session['tabdata']) && $global_session['tabdata'] != "")
		{
			$tabdata                     = $global_session['tabdata'];
			$applicationname             = $tabdata['applicationname'];
			$tab_info_array              = $tabdata['tab_info_array'];
			$approvaltabs                = $tabdata['approvaltabs'];
			$optionalapprovals           = $tabdata['optionalapprovals'];
			$detailapprovals             = $tabdata['detailapprovals'];
			$all_tabs_array              = $tabdata['all_tabs_array'];
			$all_entity_tabs_array       = $tabdata['all_entity_tabs_array'];
			$all_tablabels_array         = $tabdata['all_tablabels_array'];
			$tab_label_array             = $tabdata['tab_label_array'];
			$tab_quickcreate_array       = $tabdata['tab_quickcreate_array'];
			$tab_seq_array               = $tabdata['tab_seq_array'];
			$tab_ownedby_array           = $tabdata['tab_ownedby_array'];
			$defaultOrgSharingPermission = $tabdata['defaultOrgSharingPermission'];
		}
		else
		{ 
			$tabdata                     = create_tab_data_file();
			$global_session['tabdata']   = $tabdata; 
			$applicationname             = $tabdata['applicationname'];
			$tab_info_array              = $tabdata['tab_info_array'];
			$approvaltabs                = $tabdata['approvaltabs'];
			$optionalapprovals           = $tabdata['optionalapprovals'];
			$detailapprovals             = $tabdata['detailapprovals'];
			$all_tabs_array              = $tabdata['all_tabs_array'];
			$all_entity_tabs_array       = $tabdata['all_entity_tabs_array'];
			$all_tablabels_array         = $tabdata['all_tablabels_array'];
			$tab_label_array             = $tabdata['tab_label_array'];
			$tab_quickcreate_array       = $tabdata['tab_quickcreate_array'];
			$tab_seq_array               = $tabdata['tab_seq_array'];
			$tab_ownedby_array           = $tabdata['tab_ownedby_array'];
			$defaultOrgSharingPermission = $tabdata['defaultOrgSharingPermission'];
		} 
		 
		if (isset($global_session['rolesdata']) && $global_session['rolesdata'] != "")
		{
			$rolesdata = $global_session['rolesdata'];
		}
		else
		{
			$rolesdata = create_roles_tree_data_file(); 
			$global_session['rolesdata']   = $rolesdata; 
		}
		
		if (isset($global_session['authorize']) && $global_session['authorize'] != "")
		{
			$authorize = $global_session['authorize'];
		}
		else
		{
			$authorize = create_authorize_file(); 
			$global_session['authorize']   = $authorize;
		}
		
		if (isset($global_session['system']) && $global_session['system'] != "")
		{
			$system_file     = $global_session['system'];
			$admin_delete    = $system_file['admin_delete'];
			$unitname        = $system_file['unitname'];
			$unitsubname     = $system_file['unitsubname'];
			$unitaddr        = $system_file['unitaddr'];
			$unitzipcode     = $system_file['unitzipcode'];
			$unitwebsite     = $system_file['unitwebsite'];
			$unitphone       = $system_file['unitphone'];
			$unitfax         = $system_file['unitfax'];
			$fetionmobile    = $system_file['fetionmobile'];
			$fetionpassword  = $system_file['fetionpassword'];
			$unitbankaccount = $system_file['unitbankaccount'];
			$unittaxnumber   = $system_file['unittaxnumber'];
			$unitlogo        = $system_file['unitlogo'];
			
		}
		else
		{ 
			$system_file     = create_system_file();
			$global_session['system']   = $system_file;
			$admin_delete    = $system_file['admin_delete'];
			$unitname        = $system_file['unitname'];
			$unitsubname     = $system_file['unitsubname'];
			$unitaddr        = $system_file['unitaddr'];
			$unitzipcode     = $system_file['unitzipcode'];
			$unitwebsite     = $system_file['unitwebsite'];
			$unitphone       = $system_file['unitphone'];
			$unitfax         = $system_file['unitfax'];
			$fetionmobile    = $system_file['fetionmobile'];
			$fetionpassword  = $system_file['fetionpassword'];
			$unitbankaccount = $system_file['unitbankaccount'];
			$unittaxnumber   = $system_file['unittaxnumber'];
			$unitlogo        = $system_file['unitlogo'];
		}

	}
	catch (XN_Exception $e)
	{
		if ($e->getMessage() == 'couldn\'t connect to host')
		{
			errorprint('错误', "无法连接到REST服务器，请联系管理员<br><div style='text-align: left;padding-left: 30px;'>联系人：王真明<br>手&nbsp;&nbsp;&nbsp;机：15974160308<br>邮&nbsp;&nbsp;&nbsp;箱：admin@oldhand.cn<br>Q&nbsp;&nbsp;&nbsp;&nbsp;Q：68594864</div>");
		}
		else
		{ 
			$parent_tabdata                 = create_parenttab_data_file();
			$global_session['parent_tabdata'] = $parent_tabdata;
			$parent_tab_info_array          = $parent_tabdata['parent_tab_info_array'];
			$all_parent_tab_info_array      = $parent_tabdata['all_parent_tab_info_array'];
			$parent_child_tab_rel_array     = $parent_tabdata['parent_child_tab_rel_array'];
			$all_parent_child_tab_rel_array = $parent_tabdata['all_parent_child_tab_rel_array'];
			
			$tabdata                     = create_tab_data_file();
			$global_session['tabdata']   = $tabdata;
			$applicationname             = $tabdata['applicationname'];
			$tab_info_array              = $tabdata['tab_info_array'];
			$approvaltabs                = $tabdata['approvaltabs'];
			$optionalapprovals           = $tabdata['optionalapprovals'];
			$detailapprovals             = $tabdata['detailapprovals'];
			$all_tabs_array              = $tabdata['all_tabs_array'];
			$all_entity_tabs_array       = $tabdata['all_entity_tabs_array'];
			$all_tablabels_array         = $tabdata['all_tablabels_array'];
			$tab_label_array             = $tabdata['tab_label_array'];
			$tab_quickcreate_array       = $tabdata['tab_quickcreate_array'];
			$tab_seq_array               = $tabdata['tab_seq_array'];
			$tab_ownedby_array           = $tabdata['tab_ownedby_array'];
			$defaultOrgSharingPermission = $tabdata['defaultOrgSharingPermission'];
			
			$rolesdata = create_roles_tree_data_file(); 
			$global_session['rolesdata']   = $rolesdata; 
			
			$authorize = create_authorize_file(); 
			$global_session['authorize']   = $authorize;
			
			$system_file     = create_system_file();
			$global_session['system']   = $system_file;
			$admin_delete    = $system_file['admin_delete'];
			$unitname        = $system_file['unitname'];
			$unitsubname     = $system_file['unitsubname'];
			$unitaddr        = $system_file['unitaddr'];
			$unitzipcode     = $system_file['unitzipcode'];
			$unitwebsite     = $system_file['unitwebsite'];
			$unitphone       = $system_file['unitphone'];
			$unitfax         = $system_file['unitfax'];
			$fetionmobile    = $system_file['fetionmobile'];
			$fetionpassword  = $system_file['fetionpassword'];
			$unitbankaccount = $system_file['unitbankaccount'];
			$unittaxnumber   = $system_file['unittaxnumber'];
			$unitlogo        = $system_file['unitlogo'];
		}
	}
	
 

	//获取长时间处理时的状态 by 徐雁
	Fast_Finish_Status();

	header('Content-Type:text/html;charset=utf-8');
	session_start(); 
 
	if (XN_Application::$CURRENT_URL != 'my')
	{
		try
		{
			$app = XN_Application::load(XN_Application::$CURRENT_URL, XN_Application::$CURRENT_URL);
			if ($app->name == null)
			{
				errorprint('错误', '当前域名还没有使用。 <a href="/register.php">用户注册</a><br><div style="text-align: left;padding-left: 30px;">联系人：王真明<br>手&nbsp;&nbsp;&nbsp;机：15974160308<br>邮&nbsp;&nbsp;&nbsp;箱：admin@oldhand.cn<br>Q&nbsp;&nbsp;&nbsp;&nbsp;Q：68594864</div>');
				die();
			} 
			XN_Application::$DESCRIPTION = $app->description;
		}
		catch (XN_Exception $e)
		{
			  errorprint('错误', $e->getMessage()); 
		}
	}
	global $currentModule;
	function stripslashes_checkstrings($value)
	{
		if (is_string($value))
		{
			return stripslashes($value);
		}

		return $value;
	}

	if (get_magic_quotes_gpc() == 1)
	{
		$_REQUEST = array_map("stripslashes_checkstrings", $_REQUEST);
		$_POST    = array_map("stripslashes_checkstrings", $_POST);
		$_GET     = array_map("stripslashes_checkstrings", $_GET);
	}
	// Allow for the session information to be passed via the URL for printing.
	if (isset($_REQUEST['PHPSESSID']))
	{
		session_id($_REQUEST['PHPSESSID']);
		$sid = $_REQUEST['PHPSESSID'];
	}
	

	if (!isset($_SERVER['REQUEST_URI']))
	{
		$_SERVER['REQUEST_URI'] = '';
	}
	$action = '';
	if (isset($_REQUEST['action']))
	{
		$action = $_REQUEST['action'];
	}
	//Code added for 'Path Traversal/File Disclosure' security fix - Philip
	$is_module = false;
	$is_action = false;
	if (isset($_REQUEST['module']))
	{
		$module   = $_REQUEST['module'];
		$dir      = @scandir($root_directory."modules");
		$temp_arr = Array ("CVS", "Attic");
		$res_arr  = @array_intersect($dir, $temp_arr);
		if (count($res_arr) == 0 && !preg_match("/[\/.]/", $module))
		{
			if (@in_array($module, $dir))
				$is_module = true;
		}
		$in_dir  = @scandir($root_directory."modules/".$module);
		$res_arr = @array_intersect($in_dir, $temp_arr);
		if (count($res_arr) == 0 && !preg_match("/[\/.]/", $module))
		{
			if (@in_array($action.".php", $in_dir))
				$is_action = true;
		}
		if (!$is_module)
		{
			die("Module name is missing. Please check the module name.");
		}
		if (!$is_action)
		{
			die("Action name is missing. Please check the action name.");
		}
	}
	// Check to see if there is an authenticated user in the session.
	$use_current_login = false;
	if ((isset(XN_Profile::$VIEWER)) && XN_Profile::$VIEWER != "" && XN_Profile::$VIEWER == $_SESSION["authenticated_user_id"])
	{
		$use_current_login = true;
		require_once('modules/Users/Users.php');
		require_once('modules/Users/CreateUserPrivilegeFile.php');
		require_once('include/utils/UserInfoUtil.php');
		try
		{
			$sessionkey = "user_privileges_".XN_Application::$CURRENT_URL."_".XN_Profile::$VIEWER;
			$global_user_privileges = XN_MemCache::get($sessionkey);
			
			$session_id = $global_user_privileges["session_id"]; 
			$timestamp = $global_user_privileges["timestamp"];  
			
			
			global $copyrights; 
			if ($copyrights['singlelogin'] != 'disabled')
			{
				if ($session_id == session_id())
				{
					if (time() > $timestamp + 30)
					{
						$global_user_privileges["timestamp"] = time();
				        XN_MemCache::put($global_user_privileges,$sessionkey);
					}
				}
				else
				{
					XN_Profile::signOut();
					setcookie("xn_id_".XN_Application::$CURRENT_URL, "", time() - 3600, '/');
					errorprint('警告', "登录失效,您的用户已经在另一处登录！");
					die();
				}
			}  
		}
		catch (XN_Exception $e)
		{
			$global_user_privileges = createUserPrivilegesfile(XN_Profile::$VIEWER);
		}
	}
	
	//如果已登录的话，跳转到默认页面，不显示登陆页面
	// Prevent loading Login again if there is an authenticated user in the session.
	if ($use_current_login && $module == 'Users' && $action == 'Login')
	{
		header("Location: index.php");
	}
	
	
	$skipSecurityCheck = false;
	if (isset($action) && isset($module))
	{
		if ($action == 'Save')
		{
			header("Expires: Mon, 20 Dec 1998 01:00:00 GMT");
			header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
			header("Cache-Control: no-cache, must-revalidate");
			header("Pragma: no-cache");
		}
		if (($module == 'Users' || $module == 'Home') && $_REQUEST['parenttab'] != 'Settings')
		{
			$skipSecurityCheck = true;
		}
		if ($module == 'Settings')
		{
			$skipSecurityCheck = true;
		}
		$currentModuleFile = 'modules/'.$module.'/'.$action.'.php';
		$currentModule     = $module;
	}
	elseif (isset($module))
	{
		$currentModule     = $module;
		$currentModuleFile = "modules/".$currentModule."/index.php";
	}
	else
	{
		$currentModule     = "Home";
		$currentModuleFile = "base.php";
	}
	
	// for printing
	$module       = (isset($_REQUEST['module'])) ? $_REQUEST['module'] : "";
	$action       = (isset($_REQUEST['action'])) ? $_REQUEST['action'] : "";
	$record       = (isset($_REQUEST['record'])) ? $_REQUEST['record'] : "";
	
	$current_user = new Users(); 
	if ($use_current_login)
	{
		if (XN_Profile::$VIEWER == null)
		{
			header("Location: index.php?action=Login&module=Users");
		}
		try
		{
			$current_user->retrieveCurrentUserInfoFromFile(XN_Profile::$VIEWER);
		}
		catch (XN_Exception $e)
		{
			$sessionkey = "logindata_".XN_Application::$CURRENT_URL."_".XN_Profile::$VIEWER;
			XN_MemCache::delete($sessionkey);

			XN_Profile::signOut();
			setcookie("xn_id_".XN_Application::$CURRENT_URL, "", time() - 3600, '/');
			header("Location: index.php?action=Login&module=Users");
			die();
		}
		
		$audit_trail  = $global_session['audit_trail'];
		 
		if ($audit_trail == 'true')
		{
			if ($record == '')
				$auditrecord = '-';
			else
				$auditrecord = $record;
			if (!$skip_auditing)
			{
				try
				{
					XN_Content::create('audit_trials', '', false, 1)->my->add('user_name', $user_name)->my->add('userid', $current_user->id)->my->add('module', $module)->my->add('action', $action)->my->add('recordid', $auditrecord)->my->add('actiondate', date('Y-m-d H:i:s'))->save("Audit_trials");
				}
				catch (XN_Exception $e)
				{
					errorprint('错误', "服务器正在临时维护，请30秒后重试！");
				}
			}
		} 
	}
	else
	{ 
		if ($module != 'Users' && $action != 'Login')
		{
			header("Location: index.php?action=Login&module=Users");
			die();
		}
	}
	
	//Used for current record focus
	$focus = "";
	// if the language is not set yet, then set it to the default language.
	if (isset($_SESSION['authenticated_user_language']) && $_SESSION['authenticated_user_language'] != '')
	{
		$current_language = $_SESSION['authenticated_user_language'];
	}
	else
	{
		$current_language = $default_language;
	}
	//set module and application string arrays based upon selected language
	$app_currency_strings = return_app_currency_strings_language($current_language);
	$app_strings          = return_application_language($current_language);
	$app_list_strings     = return_app_list_strings_language($current_language);
	$mod_strings          = return_module_language($current_language, $currentModule);
	
	if ($currentModuleFile == "base.php")
	{
		include("base.php");
		die();
	}
	 
	//如果$skipSecurityCheck==false,需要验证权限
	if (!$skipSecurityCheck)
	{
		require_once('include/utils/UserInfoUtil.php');
		$now_action = $action;
		if (isset($_REQUEST['record']) && $_REQUEST['record'] != '')
		{
			$display = isPermitted($module, $now_action, $_REQUEST['record']);
		}
		else
		{
			$display = isPermitted($module, $now_action);
		}
	}
	 
	if ($display == "no")
	{
		echo "<table border='0' cellpadding='5' cellspacing='0' width='100%' height='".(($now_action == "ListViewTop") ? "232px" : "450px")."'><tr><td align='center'>";
		echo "<div style='border: 3px solid rgb(153, 153, 153); background-color: rgb(255, 255, 255); width: 55%; position: relative; z-index: 10000000;'>

		<table border='0' cellpadding='5' cellspacing='0' width='98%'>
		<tbody><tr>
		<td rowspan='2' width='11%'><i class='fa fa-ban' style='font-size:2.2em;'></i></td>
		<td style='border-bottom: 1px solid rgb(204, 204, 204);' nowrap='nowrap' width='70%'><span class='genHeaderSmall'>$app_strings[LBL_PERMISSION]</span></td>
		</tr>
		<tr>
		<td class='small' align='right' nowrap='nowrap'>
		<a href='javascript:window.history.back();'>$app_strings[LBL_GO_BACK]</a><br>								   						     </td>
		</tr>
		</tbody></table>
		</div>";
		echo "</td></tr></table>";
	}
	else
	{
		$func = 'modules/'.$currentModule.'/config.func.php';
		if (@file_exists($func))
		{
			require_once($func);
		}
		include($currentModuleFile);
	}

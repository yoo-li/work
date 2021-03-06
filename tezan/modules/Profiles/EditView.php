<?php
	require_once('Smarty_setup.php');
	require_once('include/utils/UserInfoUtil.php');
	require_once('include/utils/utils.php');

	global $app_strings;
	global $mod_strings;
	global $current_user, $currentModule;
	$smarty = new vtigerCRM_Smarty;
	$smarty->assign("ID", $_REQUEST['record']);
	$smarty->assign("MOD", return_module_language($current_language, 'Settings'));
	$smarty->assign("APP", $app_strings);
	$smarty->assign("MODULE", $currentModule);
	$smarty->assign("CMOD", $mod_strings);

	$ProfilesInfo = array();
	if(isset($_REQUEST['record']) && $_REQUEST['record'] != ""){
		try{
			$profile_info = XN_Content::load($_REQUEST['record'], "Profiles");
			$ProfilesInfo["profilename"] = $profile_info->my->profilename;
			$ProfilesInfo["view_all"] = $profile_info->my->globalactionpermission1;
			$ProfilesInfo["edit_all"] = $profile_info->my->globalactionpermission2;
			if ($profile_info->my->profilename == 'Boss'){
				$superdeleted = $profile_info->my->superdeleted;
				if (!is_null($superdeleted) && $superdeleted == 1)
				{
					$ProfilesInfo["superdeleted"] = "1";
				}else{
					$ProfilesInfo["superdeleted"] = "0";
				}
				$smarty->assign("PROFILESINFO", $ProfilesInfo);
				$smarty->display("EditProfile.tpl");
				die();
			}
		}catch (XN_Exception $e)
		{
			die(getTranslatedString('ERR_INVALID_PROFILE_ID', $currentModule));
		}


		global $global_session;
		$tabdata                    = $global_session['tabdata']; 
		$parent_tabdata             = $global_session['parent_tabdata'];
		
		$parent_child_tab_rel_array = $parent_tabdata['parent_child_tab_rel_array'];
		$tab_info_array = $tabdata['tab_info_array'];
		$all_tabs_array = $tabdata['all_tabs_array'];
		$parent_modules = array();
		foreach ($parent_child_tab_rel_array as $parenttab => $subtabs)
		{
			if (count($subtabs) > 0)
			{
				foreach($subtabs as $mname){
					$parent_modules[$parenttab][$tab_info_array[$mname]] = "";
				}
			}
		}

		$alltabsids = array();
		$tab_perr_array = getTabsPermission($_REQUEST['record']);
		foreach ($tab_perr_array as $tabid => $tab_perr)
		{
			foreach($parent_modules as $parentname => $parentmodules){
				foreach($parentmodules as $moduleid => $value){
					if($moduleid == $tabid){
						$parent_modules[$parentname][$moduleid]["modulename"] = $all_tabs_array[$tabid];
						$parent_modules[$parentname][$moduleid]["module"] = $tab_perr;
					}
				}
			}
			$alltabsids[] = $tabid;
		}
		$act_perr_arry = getTabsActionPermissionBy($_REQUEST['record'],$alltabsids);
		foreach ($act_perr_arry as $tabid => $action_array)
		{
			foreach($parent_modules as $parentname => $parentmodules){
				foreach($parentmodules as $moduleid => $value){
					if($moduleid == $tabid){
						$parent_modules[$parentname][$moduleid]["editview"] = $action_array['EditView'];
						$parent_modules[$parentname][$moduleid]["delete"] = $action_array['Delete'];
						$parent_modules[$parentname][$moduleid]["listview"] = $action_array['Index'];
					}
				}
			}
		}

		$ProfilesInfo["tabmodules"] = $parent_modules;
		$smarty->assign("PROFILESINFO", $ProfilesInfo);
		$smarty->display("EditProfile.tpl");
		die();
	}
	die(getTranslatedString('ERR_INVALID_PROFILE_ID', $currentModule));



	function getTabsActionPermissionBy($profileid,$tabids){
		$check = Array ();
		$profile2standardpermissions = XN_Query::create('Content')->tag('profile2standardpermissions')
											   ->filter('type', 'eic', 'profile2standardpermissions')
											   ->filter('my.profileid', '=', $profileid)
											   ->order('my.tabid', XN_Order::ASC_NUMBER)
											   ->begin(0)->end(-1)
											   ->execute();
		foreach ($profile2standardpermissions as $profile2standardpermission_info)
		{
			$tab_id = $profile2standardpermission_info->my->tabid;
			if (in_array($tab_id, $tabids))
			{
				$actionname  = $profile2standardpermission_info->my->actionname;
				$permissions = $profile2standardpermission_info->my->permissions;
				if ($tab_id != '16')
				{
					$access[$actionname] = $permissions;
					$check[$tab_id]      = $access;
				}
			}
		}
		return $check;
	}
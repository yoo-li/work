<?php

	function fetchUserRole($userid)
	{
		$users  = XN_Query::create('Content')->tag('Users')
						  ->filter('type', 'eic', 'users')
						  ->filter('my.profileid', '=', $userid)
						  ->begin(0)->end(1)
						  ->execute();
		$roleid = null;
		if (count($users) > 0)
		{
			$user   = $users[0];
			$roleid = $user->my->roleid;
		}
		return $roleid;
	}

	/** Depricated. Function to be replaced by getUserProfile()
	 * Should be done accross the product
	 */
	function fetchUserProfileId($userid)
	{
		$profileid = VTCacheUtils::lookupUserProfileId($userid);

		if ($profileid === false)
		{
			$users = XN_Query::create('Content')->tag('Users')->filter('type', 'eic', 'users')->filter('my.profileid', '=', $userid)->execute();
			if (count($users) > 0)
			{
				$user   = $users [0];
				$roleid = $user->my->roleid;
				$roles  = XN_Query::create('Content')->tag('Roles')->filter('type', 'eic', 'roles')->filter('my.roleid', '=', $roleid)->execute();
				if (count($roles) > 0)
				{
					$role      = $roles [0];
					$profileid = $role->my->profileid;
				}
			}
			else return null;
			// Update information to cache for re-use
			VTCacheUtils::updateUserProfileId($userid, $profileid);
		}

		return $profileid;
	}

	/** Function to get all the vtiger_tab permission for the specified vtiger_profile other than tabid 15
	 * @param $profileid              -- Profile Id:: Type integer
	 * @returns  TabPermission Array in the following format:
	 *                                $tabPermission = Array($tabid1=>permission,
	 *                                $tabid2=>permission,
	 *                                |
	 *                                $tabidn=>permission)
	 */
	function getTabsPermission($profileid)
	{
		global $persistPermArray;
		if ($profileid == '1')
		{
			$tab_perr_array = Array ();
			$tabs           = XN_Query::create('Content')->tag('tabs')
									  ->filter('type', 'eic', 'tabs')
									  ->filter('my.presence', '=', '0')
									  ->filter(XN_Filter::any(XN_Filter('my.isentitytype', '=', '1'), XN_Filter('my.isentitytype', '=', '2')))
									  ->order('my.tabsequence', XN_Order::DESC)
									  ->begin(0)->end(-1)
									  ->execute();
			foreach ($tabs as $tab_info)
			{
				$tab_perr_array[$tab_info->my->tabid] = 0;
			}
			ksort($tab_perr_array);
			return $tab_perr_array;
		}
		else
		{
			$tab_array = Array ();
			$tabs      = XN_Query::create('Content')->tag('tabs')
								 ->filter('type', 'eic', 'tabs')
								 ->filter('my.presence', '=', '0')
								 ->filter(XN_Filter::any(XN_Filter('my.isentitytype', '=', '1'), XN_Filter('my.isentitytype', '=', '2')))
								 ->order('my.tabsequence', XN_Order::DESC)
								 ->begin(0)->end(-1)
								 ->execute();
			foreach ($tabs as $tab_info)
			{
				$tab_array[] = $tab_info->my->tabid;
			}

			$tab_perr_array = Array ();
			$profile2tabs   = XN_Query::create('Content')->tag('Profile2tabs')
									  ->filter('type', 'eic', 'profile2tabs')
									  ->filter('my.profileid', '=', $profileid)
									  ->order('my.tabid', XN_Order::ASC_NUMBER)
									  ->begin(0)->end(-1)
									  ->execute();
			foreach ($profile2tabs as $profile2tabs_info)
			{
				$tab_id = $profile2tabs_info->my->tabid;
				if (in_array($tab_id, $tab_array))
				{
					$permissions = $profile2tabs_info->my->permissions;
					if ($tab_id != 3 && $tab_id != 16)
					{
						$tab_perr_array[$tab_id] = $permissions;
					}
				}
			}
			ksort($tab_perr_array);
			return $tab_perr_array;
		}
	}

	/** Function to get all the vtiger_tab standard action permission for the specified vtiger_profile
	 * @param $profileid              -- Profile Id:: Type integer
	 * @returns  Tab Action Permission Array in the following format:
	 *                                $tabPermission = Array($tabid1=>Array(actionid1=>permission, actionid2=>permission,...,actionidn=>permission),
	 *                                $tabid2=>Array(actionid1=>permission, actionid2=>permission,...,actionidn=>permission),
	 *                                |
	 *                                $tabidn=>Array(actionid1=>permission, actionid2=>permission,...,actionidn=>permission))
	 */
	function getTabsActionPermission($profileid)
	{
		$check = Array ();
		try
		{
			if ($profileid == '1')
			{
				$tabs   = XN_Query::create('Content')->tag('tabs')
								  ->filter('type', 'eic', 'tabs')
								  ->filter('my.isentitytype', '=', '1')
								  ->filter('my.presence', '=', '0')
								  ->order('my.tabsequence', XN_Order::DESC)
								  ->begin(0)->end(-1)
								  ->execute();
				$access = Array ('Index' => 0, 'EditView' => 0, 'Delete' => 0);
				foreach ($tabs as $tab_info)
				{
					$check[$tab_info->my->tabid] = $access;
				}
			}
			else
			{
				$profile2standardpermissions = XN_Query::create('Content')->tag('profile2standardpermissions')
													   ->filter('type', 'eic', 'profile2standardpermissions')
													   ->filter('my.profileid', '=', $profileid)
													   ->order('my.tabid', XN_Order::ASC_NUMBER)
													   ->begin(0)->end(-1)
													   ->execute();
				$access                      = array ();
				$temp_tabid                  = Array ();
				foreach ($profile2standardpermissions as $profile2standardpermission_info)
				{
					$tab_id = $profile2standardpermission_info->my->tabid;
					if (!in_array($tab_id, $temp_tabid))
					{
						$temp_tabid[] = $tab_id;
						$access       = Array ();
					}
					//$operation = $profile2standardpermission_info->my->operation;
					$actionname  = $profile2standardpermission_info->my->actionname;
					$permissions = $profile2standardpermission_info->my->permissions;
					if ($tab_id != '16')
					{
						$access[$actionname] = $permissions;
						$check[$tab_id]      = $access;
					}
				}
			}
		}
		catch (XN_Exception $e)
		{

		}
		return $check;
	}

	/** Function to get all the vtiger_tab utility action permission for the specified vtiger_profile
	 * @param $profileid              -- Profile Id:: Type integer
	 * @returns  Tab Utility Action Permission Array in the following format:
	 *                                $tabPermission = Array($tabid1=>Array(actionid1=>permission, actionid2=>permission,...,actionidn=>permission),
	 *                                $tabid2=>Array(actionid1=>permission, actionid2=>permission,...,actionidn=>permission),
	 *                                |
	 *                                $tabidn=>Array(actionid1=>permission, actionid2=>permission,...,actionidn=>permission))
	 */

	function getTabsUtilityActionPermission($profileid)
	{
		$check = Array ();
		try
		{
			if ($profileid == '1')
			{
				$tabs = XN_Query::create('Content')->tag('tabs')
								->filter('type', 'eic', 'tabs')
								->filter('my.isentitytype', '=', '1')
								->order('my.tabsequence', XN_Order::DESC)
								->begin(0)->end(-1)
								->execute();
				foreach ($tabs as $tab_info)
				{
					$tab_id   = $tab_info->my->tabid;
					$module   = $tab_info->my->tabname;
					$datafile = $_SERVER['DOCUMENT_ROOT'].'/modules/'.$module.'/config.inc.php';
					if (@file_exists($datafile))
					{
						require($datafile);
						if (isset($actionmapping) && count($actionmapping) > 0)
						{
							$access = array ();
							foreach ($actionmapping as $actionmapping_info)
							{
								$activity      = $actionmapping_info['actionname'];
								$securitycheck = $actionmapping_info['securitycheck'];
								$type          = $actionmapping_info['type'];
								if (($type == 'ajax' || $type == 'button' || $type == 'listview') && $securitycheck == '0')
								{
									$access[$activity] = 0;
								}
							}
							if (count($access) > 0)
							{
								ksort($access);
								$check[$tab_id] = $access;
							}
						}
					}
				}
				ksort($check);
			}
			else
			{

				$profile2utilitys = XN_Query::create('Content')->tag('profile2utilitys')
											->filter('type', 'eic', 'profile2utilitys')
											->filter('my.profileid', '=', $profileid)
											->order('my.tabid', XN_Order::ASC_NUMBER)
											->begin(0)->end(10000)
											->execute();
				$access           = array ();
				$temp_tabid       = Array ();
				foreach ($profile2utilitys as $profile2utility_info)
				{
					$tab_id = $profile2utility_info->my->tabid;
					if (!in_array($tab_id, $temp_tabid))
					{
						$temp_tabid[] = $tab_id;
						$access       = Array ();
					}
					$activity   = $profile2utility_info->my->activity;
					$permission = $profile2utility_info->my->permission;

					$access[$activity] = $permission;
					$check[$tab_id]    = $access;
				}
				foreach ($check as $tab_id => $access)
				{
					ksort($access);
					$check[$tab_id] = $access;
				}
			}

		}
		catch (XN_Exception $e)
		{

		}
		return $check;

	}

	/**This Function returns the Default Organisation Sharing Action Array for all modules whose sharing actions are editable
	 * The result array will be in the following format:
	 * Arr=(tabid1=>Sharing Action Id,
	 *      tabid2=>SharingAction Id,
	 *            |
	 *            |
	 *            |
	 *      tabid3=>SharingAcion Id)
	 */

	function getDefaultSharingEditAction()
	{
		$def_org_shares = XN_Query::create('Content')->tag('Def_org_shares')->filter('type', 'eic', 'def_org_shares')->filter('my.editstatus', '=', '0')->order('published', XN_Order::ASC)->execute();
		$copy           = Array ();
		foreach ($def_org_shares as $def_org_share_info)
		{
			$tabid          = $def_org_share_info->my->tabid;
			$permission     = $def_org_share_info->my->permission;
			$action_mapping = $def_org_share_info->my->action_mapping;
			$copy[$tabid]   = array ('permission' => $permission, 'action_mapping' => $action_mapping);
		}
		return $copy;

	}

	/**This Function returns the Default Organisation Sharing Action Array for modules with edit status in (0,1)
	 * The result array will be in the following format:
	 * Arr=(tabid1=>Sharing Action Id,
	 *      tabid2=>SharingAction Id,
	 *            |
	 *            |
	 *            |
	 *      tabid3=>SharingAcion Id)
	 */
	function getDefaultSharingAction()
	{
		$def_org_shares = XN_Query::create('Content')->tag('Def_org_shares')
								  ->filter('type', 'eic', 'def_org_shares')
								  ->filter('my.editstatus', 'in', array ('0', '1'))
								  ->order('published', XN_Order::ASC)->execute();
		$copy           = Array ();
		foreach ($def_org_shares as $def_org_share_info)
		{
			$tabid        = $def_org_share_info->my->tabid;
			$permission   = $def_org_share_info->my->permission;
			$copy[$tabid] = $permission;
		}
		return $copy;

	}

	/**This Function returns the Default Organisation Sharing Action Array for all modules
	 * The result array will be in the following format:
	 * Arr=(tabid1=>Sharing Action Id,
	 *      tabid2=>SharingAction Id,
	 *            |
	 *            |
	 *            |
	 *      tabid3=>SharingAcion Id)
	 */
	function getAllDefaultSharingAction()
	{
		$def_org_shares = XN_Query::create('Content')->tag('def_org_shares')
								  ->filter('type', 'eic', 'def_org_shares')
								  ->order('my.tabid', XN_Order::ASC_NUMBER)
								  ->begin(0)->end(1000)
								  ->execute();
		$copy           = Array ();
		foreach ($def_org_shares as $def_org_share_info)
		{
			$tabid        = $def_org_share_info->my->tabid;
			$permission   = $def_org_share_info->my->permission;
			$copy[$tabid] = $permission;
		}
		return $copy;

	}

	/** Function to get the vtiger_role UniqueId
	 */
	function getRoleUniqueId()
	{
		$roles    = XN_Query::create('Content')->tag('Roles')->filter('type', 'eic', 'roles')->execute();
		$roleInfo = Array ();
		$uniqueId = 0;
		if (count($roles) > 0)
		{
			foreach ($roles as $role)
			{
				$roleid = $role->my->roleid;
				if ($roleid[0] === 'H')
				{
					$newroleid = (integer)substr($roleid, 1);
					if ($newroleid > $uniqueId)
					{
						$uniqueId = $newroleid;
					}
				}
			}
		}

		return $uniqueId + 1;

	}

	/** Function to create the vtiger_role
	 * @param $roleName         -- Role Name:: Type varchar
	 * @param $parentRoleId     -- Parent Role Id:: Type varchar
	 * @param $roleProfileArray -- Profile to be associated with this vtiger_role:: Type Array
	 * @returns  the Rold Id :: Type varchar
	 */

	function createRole($roleName, $parentRoleId, $sequence, $leadership, $mainleadership, $roletype = '0')
	{
		$roleid_no = getRoleUniqueId();
		$roleId    = 'H'.$roleid_no;
		if (isset($parentRoleId) && $parentRoleId != "" && $parentRoleId != "root")
		{
			$parentRoleDetails = getRoleInformation($parentRoleId);
			$parentRoleInfo    = $parentRoleDetails[$parentRoleId];
			$parentRoleHr      = $parentRoleInfo[1];
			$parentRoleDepth   = $parentRoleInfo[2];
			$nowParentRoleHr   = $parentRoleHr.'::'.$roleId;
			$nowRoleDepth      = $parentRoleDepth + 1;
		}
		else
		{
			$nowParentRoleHr = $roleId;
			$nowRoleDepth    = 0;
		}
		VTCacheUtils::clearRoleSubordinates($roleId);

		$leadership = explode(";", trim($leadership, ';'));
		array_filter($leadership);

		$role = XN_Content::create('roles', $roleName, false)
			->my->add('roleid', $roleId)
			->my->add('rolename', $roleName)
			->my->add('leadership', $leadership)
			->my->add('mainleadership', $mainleadership)
			->my->add('parentrole', $nowParentRoleHr)
			->my->add('roletype', $roletype)
			->my->add('depth', $nowRoleDepth)
			->my->add('sequence', $sequence);

		$users = XN_Query::create('Content')->tag('users')
						 ->filter('type', 'eic', 'users');
		$users->filter('my.profileid', 'in', $leadership);
		$users = $users->execute();

		foreach ($users as $user)
		{
			if ($user->my->roleid != $roleId)
			{
				$user->my->roleid = $roleId;
				$user->save("users");
			}
		}
		$role->save("Roles");
		return $roleId;

	}

	/** Function to update the vtiger_role
	 * @param $roleName         -- Role Name:: Type varchar
	 * @param $roleId           -- Role Id:: Type varchar
	 * @param $roleProfileArray -- Profile to be associated with this vtiger_role:: Type Array
	 */
	function updateRole($roleId, $roleName, $sequence, $leadership = null, $mainleadership = null, $roletype = '0')
	{
		VTCacheUtils::clearRoleSubordinates($roleId);

		$leadership = explode(";", trim($leadership, ';'));
		array_filter($leadership);

		$roles = XN_Query::create('Content')
						 ->tag('Roles')
						 ->filter('type', 'eic', 'roles')
						 ->filter('my.roleid', '=', $roleId)
						 ->execute();

		if (count($roles) > 0)
		{
			$role               = $roles[0];
			$role->my->rolename = $roleName;
			if ($leadership)
				$role->my->leadership = $leadership;
			if ($mainleadership)
				$role->my->mainleadership = $mainleadership;
			$role->my->sequence = $sequence;
			$role->my->roletype = $roletype;
			$profilearray       = array ();
			$role->save("Roles");
		}
		$users = XN_Query::create('Content')->tag('users')
						 ->filter('type', 'eic', 'users');
		$users->filter('my.profileid', 'in', $leadership);
		$users = $users->execute();

		foreach ($users as $user)
		{
			if ($user->my->roleid != $roleId)
			{
				$user->my->roleid = $roleId;
				$user->save("users");
			}
		}
	}

	function getUserRoleid($profileid)
	{
		$users = XN_Query::create('Content')->tag('users')
						 ->filter('type', 'eic', 'users')
						 ->filter('my.profileid', '=', $profileid)
						 ->end(1)
						 ->execute();
		if (count($users) > 0)
		{
			$user_info = $users[0];
			return $user_info->my->roleid;
		}
		return null;
	}

	function getRoleInfo($roleid)
	{
		$roles    = XN_Query::create('Content')->tag('roles')
							->filter('type', 'eic', 'roles')
							->filter('my.roleid', '=', $roleid)
							->end(1)
							->execute();
		$roleinfo = array ();
		if (count($roles) > 0)
		{
			$role_info                  = $roles[0];
			$roleinfo['xnid']           = $role_info->id;
			$roleinfo['rolename']       = $role_info->my->rolename;
			$roleinfo['leadership']     = $role_info->my->leadership;
			$roleinfo['mainleadership'] = $role_info->my->mainleadership;
			$parentrole                 = $role_info->my->parentrole;
			$parentRoleArr              = explode('::', $parentrole);
			$parent                     = $parentRoleArr[count($parentRoleArr) - 2];
			$roleinfo['sequence']       = $role_info->my->sequence;
			$roleinfo['roletype']       = $role_info->my->roletype;
			$roleinfo['parent']         = $parent;
			$roleinfo['parentrole']     = $parentrole;
		}
		return $roleinfo;
	}

	/** Function to get the vtiger_role name from the vtiger_roleid
	 * @param $roleid -- Role Id:: Type varchar
	 * @returns $rolename -- Role Name:: Type varchar
	 */
	function getRoleName($roleid)
	{
		global $global_rolenames;
		if (isset($global_rolenames[$roleid]) && $global_rolenames[$roleid] != "")
		{
			return $global_rolenames[$roleid];
		}
		if (!isset($global_rolenames))
		{
			$global_rolenames = array();
		}
		if ($roleid == null)
			return '';
		$roles = XN_Query::create('Content')->tag('Roles')->filter('type', 'eic', 'roles')->filter('my.roleid', '=', $roleid)->execute();
		if (count($roles) > 0)
		{
			$role = $roles[0];
			$global_rolenames[$roleid] = $role->my->rolename;
			return $global_rolenames[$roleid];
		}
		return null;
	}

	function getRoleNameList($roleid)
	{
		if ($roleid == null)
			return '';
		$roleids = (array)$roleid;
		$roles   = XN_Query::create('Content')->tag('Roles')->filter('type', 'eic', 'roles')->filter('my.roleid', 'in', $roleids)->order("my.sequence", XN_Order::ASC_NUMBER)->execute();
		if (count($roles) > 0)
		{
			$rolenames = array ();
			foreach ($roles as $role_info)
			{
				$rolenames[] = $role_info->my->rolename;
			}
			return join(",", $rolenames);
		}
		return null;
	}

	function getRolesList($roleid)
	{
		$roleids   = (array)$roleid;
		$rolenames = array ();
		if (count($roleids) > 0)
		{
			$roles = XN_Query::create('Content')
							 ->tag('Roles')
							 ->filter('type', 'eic', 'roles')
							 ->filter('my.roleid', 'in', $roleids)
							 ->order("my.sequence", XN_Order::ASC_NUMBER)
							 ->execute();

			if (count($roles) > 0)
			{
				foreach ($roles as $role_info)
				{
					$rolenames[$role_info->my->roleid] = $role_info->my->rolename;
				}
			}
		}
		return $rolenames;
	}

	function getSuperDeleteProfile($profileid)
	{
		try
		{
			if (isset($profileid) && $profileid != '')
			{
				$profile_info = XN_Content::load($profileid, "Profiles");
				$superdeleted = $profile_info->my->superdeleted;
				if (!is_null($superdeleted) && $superdeleted == 1)
					return 1;

			}
		}
		catch (XN_Exception $e)
		{
		}
		return "0";
	}

	/** Function to get the vtiger_profile name from the vtiger_profileid
	 * @param $profileid -- Profile Id:: Type integer
	 * @returns $rolename -- Role Name:: Type varchar
	 */
	function getProfileName($profileid)
	{
		try
		{
			if (isset($profileid) && $profileid != '')
			{
				$profile_info = XN_Content::load($profileid, "Profiles");
				$profilename  = $profile_info->my->profilename;
			}
			else
			{
				return "";
			}
		}
		catch (XN_Exception $e)
		{
			return null;
		}
		return $profilename;
	}

	/** Function to get the vtiger_profile Description from the vtiger_profileid
	 * @param $profileid -- Profile Id:: Type integer
	 * @returns $rolename -- Role Name:: Type varchar
	 */
	function getProfileDescription($profileid)
	{
		try
		{
			$profile_info       = XN_Content::load($profileid, "Profiles");
			$profileDescription = $profile_info->my->description;
		}
		catch (XN_Exception $e)
		{
			return null;
		}
		return $profileDescription;
	}

	/** Function to check if the currently logged in user is permitted to perform the specified action
	 * @param $module     -- Module Name:: Type varchar
	 * @param $actionname -- Action Name:: Type varchar
	 * @param $recordid   -- Record Id:: Type integer
	 * @returns yes or no. If Yes means this action is allowed for the currently logged in user. If no means this action is not allowed for the currently logged in user
	 */
	function deletePermitted($module, $idlist)
	{
		$errormsg = '';
		try
		{
			$focus = CRMEntity::getInstance($module);  
		    if (isset($focus->datatype) && $focus->datatype != '')
		    {
				$loadcontents = XN_Content::loadMany($idlist, strtolower($module),$focus->datatype);
			}
			else
			{
				$loadcontents = XN_Content::loadMany($idlist, strtolower($module));
			}
			foreach ($loadcontents as $loadcontent_info)
			{
				$status         = strtolower($module)."status";
				$approvalstatus = $loadcontent_info->my->approvalstatus;
				$modulestatus   = $loadcontent_info->my->$status;

				global $global_user_privileges;
				$is_admin = $global_user_privileges["is_admin"];

				if ($modulestatus == 'Archive')
				{
					$errormsg .= getTranslatedFormatString('LBL_MODULESTATUSERRORMSG', '', array ($loadcontent_info->id, getTranslatedString($modulestatus, $module))).'<br>';
				}
				else if ($loadcontent_info->author != XN_Profile::$VIEWER)
				{
					$errormsg .= getTranslatedFormatString('LBL_DELETEDAUTHORERRORMSG', '', array ($loadcontent_info->id)).'<br>';
				}
				else if ($approvalstatus == 1 || $approvalstatus == 2 || $approvalstatus == 3 || $approvalstatus == 4)
				{
					$errormsg .= getTranslatedFormatString('LBL_APPROVALSTATUSERRORMSG', '', array ($loadcontent_info->id)).'<br>';
				}
				else if ($is_admin == true || $loadcontent_info->author == XN_Profile::$VIEWER)
				{

				}
				else
				{
					global $global_session; 
					$tabdata  = $global_session['tabdata']; 
					$defaultOrgSharingPermission = $tabdata['defaultOrgSharingPermission'];

					$tabid = getTabid($module);

					$approvalrecords = approvalpermission($module);
					if (isset($defaultOrgSharingPermission))
					{
						$permission = $defaultOrgSharingPermission[$tabid];
						switch ($permission)
						{

							case 2:
								break;
							case 3:
							case 0:
							case 1:
							default:
								$errormsg .= getTranslatedFormatString('LBL_PRIVATEORGSHARINGPERMISSIONERRORMSG', '', array ($loadcontent_info->id)).'<br>';
								break;
						}
					}
					else
					{
						$errormsg = getTranslatedFormatString('LBL_ORGSHARINGPERMISSIONERRORMSG');
						break;
					}
				}

			}
		}
		catch (XN_Exception $e)
		{
			$errormsg = 'Error:'.$e->getMessage();
		}
		return $errormsg;
	}

	function isPermitted($module, $action_name, $record_id = '')
	{
		global $current_user;
		global $AllPermitted;

		if ($AllPermitted)
		{
			$permission = "yes";
			return $permission;

		}

		 
		global $global_user_privileges;
		$is_admin                = $global_user_privileges["is_admin"];
		$profileGlobalPermission = $global_user_privileges['profileGlobalPermission'];
		$profileTabsPermission   = $global_user_privileges['profileTabsPermission'];

		$profileActionPermission = $global_user_privileges['profileActionPermission'];
		 

		$permission = "no";
		$actionname = $action_name;
		if (strtolower($actionname) == 'index')
			$actionname = 'Index';

		if ($action_name == 'Delete' && $is_admin)
		{
			$permission = "yes";
		}

		if ($module == 'Suppliers' || $module == "Partners")
		{
			$permission = "yes";
		}
		if ($module == 'Ma_Categorys' || $module == "Ma_Suppliers" || $module == "Ma_InventoryBillWaters" || $module == "Ma_Logistics" || $module = "Ma_Financials")
		{
			$permission = "yes";
			return $permission;

		}
		if ($module == 'ProductDeveloper' || $module == 'Categorys' || $module == 'Home' || $module == 'Collaborative' || $module == 'CustomView' || $module == 'ManagementReports')
		{
			$permission = "yes";
			return $permission;

		}

		if (($module == 'Users' || $module == 'Approvals' || $module == 'Logistics' || $module == 'Home' || $module == 'uploads' || $module == 'Tooltip' || $module == 'InvoicePrint') && $_REQUEST['parenttab'] != 'Settings')
		{
			$permission = "yes";
			return $permission;
		}

		if ($module == 'ManagementReports' ||
			$module == 'ReportsSameRelative' ||
			$module == 'ReportsLinkRelative' ||
			$module == 'ReportsHome' ||
			$module == 'ReportsMarketing' ||
			$module == 'InvoicePrint' ||
			$module == 'ExpressForm' ||
			$module == 'Members' ||
			$module == 'QuickLogin' ||
			$module == 'ReportsAccounts' ||
			$module == 'ReportsSales' ||
			$module == 'ReportsProducts' ||
			$module == 'ReportsInventory' ||
			$module == 'ReportsServices' ||
			$module == 'ReportsBusiness' ||
			$module == 'ReportsTopN' ||
			$module == 'Public' ||
			$module == 'Memo' ||
			$module == 'ProxyApproval'
		)
		{
			return "yes";
		}
		if ($module == 'Settings' ||
			$module == 'Users' ||
			$module == 'Profiles' ||
			$module == 'PickList' ||
			$module == 'ApprovalFlows' ||
			$module == 'WorkFlows' ||
			$module == 'AdvWorkFlows' ||
			$module == 'UnitsInfomation' ||
			$module == 'Recovery' ||
			$module == 'Logistics' ||
			$module == 'ApprovalFlows' ||
			$module == 'InvoicePrint' ||
			$module == 'ExpressForm' ||
			$module == 'Administration' ||
			$module == 'System'
		)
		{
			if (!$is_admin)
			{
				global $global_session; 
				$authorize = $global_session['authorize']; 
				if (isset($authorize))
				{
					require('modules/Settings/config.setting.php');

					foreach ($Config_Menu_Setting as $menus)
					{
						foreach ($menus as $menu => $info)
						{
							if ($module == $info['module'])
							{
								foreach ($authorize as $key => $info)
								{
									if (is_array($info) && !empty($info))
									{
										if (in_array(XN_Profile::$VIEWER, $info) && $key == strtolower($menu))
										{
											return "yes";
										}
										else if (in_array(XN_Profile::$VIEWER, $info) && $module == 'Settings')
										{
											return "yes";
										}
									}
								}
							}
						}
					}
				}
			}
		}

		if ($module == 'Settings' || $module == 'Administration' || $module == 'System' || $_REQUEST['parenttab'] == 'Settings')
		{
			if (!$is_admin)
			{
				$permission = "no";
			}
			else
			{
				$permission = "yes";
			}
			return $permission;
		}

		$tabid = getTabid($module);
		if ($actionname == 'EditView' && $record_id != '')
		{
			try
			{
				$focus = CRMEntity::getInstance($module);  
			    if (isset($focus->datatype) && $focus->datatype != '')
			    {
					$con = XN_Content::load($record_id, strtolower($module),$focus->datatype);
				}
				else
				{
					$con = XN_Content::load($record_id, strtolower($module));
				}
				if ($con->contributorName != $current_user->id)
					$_REQUEST['readonly'] = 'true';
				$permission = "yes";
				return $permission;
			}
			catch (XN_Exception $e)
			{

			}
			global $global_session; 
			$tabdata  = $global_session['tabdata']; 
			$defaultOrgSharingPermission = $tabdata['defaultOrgSharingPermission'];
			 

			if (isset($defaultOrgSharingPermission))
			{
				$permission = $defaultOrgSharingPermission[$tabid];
				switch ($permission)
				{
					case 1:
					case 2:
						break;
					case 0:
					case 3:
					default:
						$_REQUEST['readonly'] = 'true';
						break;
				}
			}
		}

		if ($is_admin)
		{
			$permission = "yes";
			return $permission;
		}

		$profileTabPermission = $profileTabsPermission[$tabid];

		if (!isset($profileTabPermission) || $profileTabPermission[$actionname] == 1)
		{
			return $permission;
		}

		if ($profileGlobalPermission[1] == 0 && $actionname == 'Index')
		{
			$permission = "yes";
			return $permission;
		}
		if ($profileGlobalPermission[2] == 0 && $actionname == 'EditView')
		{
			$permission = "yes";
			return $permission;
		}

		$profile_Action_Permission = $profileActionPermission[$tabid];

		if (isset($profile_Action_Permission))
		{
			if (isset($profile_Action_Permission[$actionname]))
			{
				if ($profile_Action_Permission[$actionname] == 0)
				{
					$permission = "yes";
					return $permission;
				}
				else
				{
					return $permission;
				}
			}
		}
		else
		{
			return $permission;
		}

		if ($actionname != 'Index' && $actionname != 'EditView' && $actionname != 'Delete')
			return "yes";
		return $permission;
	}

	function getProfileGlobalPermission($profileid)
	{
		$copy = array ();
		try
		{
			$profile_info = XN_Content::load($profileid, "Profiles");
			$copy [1]     = $profile_info->my->globalactionpermission1;
			$copy [2]     = $profile_info->my->globalactionpermission2;
		}
		catch (XN_Exception $e)
		{
			$copy [1] = 0;
			$copy [2] = 0;
		}
		return $copy;

	}

	function getProfileTabsPermission($profileid)
	{
		$profile2tabs = XN_Query::create('Content')->tag('profile2tabs')
								->filter('type', 'eic', 'profile2tabs')
								->filter('my.profileid', '=', $profileid)
								->order('my.tabid', XN_Order::ASC_NUMBER)
								->begin(0)->end(-1)
								->execute();
		$copy         = array ();
		foreach ($profile2tabs as $profile2tabs_info)
		{
			$tab_id        = $profile2tabs_info->my->tabid;
			$per_id        = $profile2tabs_info->my->permissions;
			$copy[$tab_id] = $per_id;
		}

		return $copy;

	}

	function getProfileActionPermission($profileid)
	{
		$check                       = Array ();
		$temp_tabid                  = Array ();
		$profile2standardpermissions = XN_Query::create('Content')->tag('profile2standardpermissions')
											   ->filter('type', 'eic', 'profile2standardpermissions')
											   ->filter('my.profileid', '=', $profileid)
											   ->order('my.tabid', XN_Order::ASC_NUMBER)
											   ->begin(0)->end(-1)
											   ->execute();
		foreach ($profile2standardpermissions as $Standard_Permission_info)
		{
			$tab_id = $Standard_Permission_info->my->tabid;
			if (!in_array($tab_id, $temp_tabid))
			{
				$temp_tabid[] = $tab_id;
				$access       = Array ();
			}
			$actionname          = $Standard_Permission_info->my->actionname;
			$per_id              = $Standard_Permission_info->my->permissions;
			$access[$actionname] = $per_id;
			$check[$tab_id]      = $access;
		}
		return $check;
	}

	function getProfileAllActionPermission($profileid)
	{
		$actionArr = getProfileActionPermission($profileid);
		$utilArr   = getTabsUtilityActionPermission($profileid);

		foreach ($utilArr as $tabid => $act_arr)
		{
			$act_tab_arr = $actionArr[$tabid];
			foreach ($act_arr as $utilid => $util_perr)
			{
				$act_tab_arr[$utilid] = $util_perr;
			}
			$actionArr[$tabid] = $act_tab_arr;
		}
		return $actionArr;
	}

	function deleteProfile($prof_id, $transfer_profileid = '')
	{
		$profile_info              = XN_Content::load($prof_id, "Profiles");
		$profile_info->my->deleted = '1';
		$profile_info->save("Profiles");
		if (isset($transfer_profileid) && $transfer_profileid != '')
		{
			$users = XN_Query::create('Content')
							 ->tag('Users')
							 ->filter('type', 'eic', 'users')
							 ->filter('my.profilesid', '=', $prof_id)
							 ->execute();
			if (count($users) > 0)
			{
				foreach ($users as $user_info)
				{
					$user_info->my->profilesid = $transfer_profileid;
					$user_info->save('users');
				}
			}
		}
	}

	function getUserSubordinate($uid, $containMe = false)
	{
		global $current_user;
		$userlist = array ();

		$adminassistant = false;
		$authorize      = array ();
		global $global_session; 
		$authorize = $global_session['authorize']; 
		if (isset($authorize))
		{
			if (isset($authorize['adminassistant']))
			{
				if (in_array(XN_Profile::$VIEWER, $authorize['adminassistant']))
				{
					$adminassistant = true;
				}
			}
		}
		if ($adminassistant || is_admin($current_user))
		{
			$query = XN_Query::create('Content')->tag('users')
							 ->filter('type', 'eic', 'users')
							 ->filter('my.deleted', '=', '0')
							 ->filter('my.status', '=', 'Active')
							 ->order('my.sequence', XN_Order::ASC_NUMBER)
							 ->end(-1)
							 ->execute();
		}
		else
		{
			$roleid     = $current_user->roleid;
			$subroles   = XN_Query::create('Content')->tag('Roles')
								  ->filter('type', 'eic', 'roles')
								  ->filter('my.parentrole', 'like', $roleid."::")
								  ->execute();
			$subroleids = array ();
			if (count($subroles) > 0)
			{
				foreach ($subroles as $info)
				{
					$subroleids[] = $info->my->roleid;
				}
			}

			if (count($subroleids) > 0)
			{
				$viewer     = XN_Filter("my.profileid", '=', XN_Profile::$VIEWER);
				$subroleids = XN_Filter("my.roleid", 'in', $subroleids);
				$query      = XN_Query::create('Content')->tag('users')
									  ->filter('type', 'eic', 'users')
									  ->filter('my.deleted', '=', '0')
									  ->filter(XN_Filter::any($subroleids, $viewer))
									  ->filter('my.status', '=', 'Active')
									  ->order('my.sequence', XN_Order::ASC_NUMBER)
									  ->end(-1)
									  ->execute();
			}
			else
			{
				$query = XN_Query::create('Content')->tag('users')
								 ->filter('type', 'eic', 'users')
								 ->filter('my.deleted', '=', '0')
								 ->filter('my.profileid', '=', XN_Profile::$VIEWER)
								 ->filter('my.status', '=', 'Active')
								 ->order('my.sequence', XN_Order::ASC_NUMBER)
								 ->end(-1)
								 ->execute();
			}
		}

		foreach ($query as $info)
		{
			$givename = $info->my->givename;
			if (!isset($givename) || $givename == "")
			{
				$givename = $info->my->last_name;
			}
			$userlist[$info->my->profileid] = array ('superior' => $info->my->reports_to_id, 'roleid' => $info->my->roleid, 'name' => $givename);
		}
		$query = XN_Query::create('Content')->tag('users')
						 ->filter('type', 'eic', 'users')
						 ->filter('my.deleted', '=', '0')
						 ->filter('my.reports_to_id', '=', XN_Profile::$VIEWER)
						 ->filter('my.status', '=', 'Active')
						 ->order('my.sequence', XN_Order::ASC_NUMBER)
						 ->end(-1)
						 ->execute();
		foreach ($query as $info)
		{
			$profileid = $info->my->profileid;
			if (!isset($userlist[$profileid]))
			{
				$givename = $info->my->givename;
				if (!isset($givename) || $givename == "")
				{
					$givename = $info->my->last_name;
				}
				$userlist[$profileid] = array ('superior' => $info->my->reports_to_id, 'roleid' => $info->my->roleid, 'name' => $givename);
			}
		}

		return $userlist;
	}

	function getUsersByRoleId($roleid)
	{
		$userInfo = array ();
		$users    = XN_Query::create('Content')->tag('Users')
							->filter('type', 'eic', 'users')
							->filter('my.status', '=', 'Active')
							->filter('my.user_type', '=', 'system') 
							->filter('my.deleted', '=', '0')
							->filter('my.roleid', '=', $roleid)
							->order('my.sequence', XN_Order::ASC_NUMBER)
							->end(-1)
							->execute();
		foreach ($users as $user)
		{
			$givename = $user->my->givename;
			if (isset($givename) && $givename != "")
			{
				$givename = $user->my->givename;
			}
			else
			{
				$givename = $user->my->last_name;
			}
			$userInfo[] = array ('profileid' => $user->my->profileid, 'username' => $givename);
		}
		return $userInfo;
	}

	function getUsersByRoleIdAndList($roleid, $userlist)
	{
		$userInfo = array ();
		if (count($userlist) > 0)
		{
			$users = XN_Query::create('Content')->tag('Users')
							 ->filter('type', 'eic', 'users')
							 ->filter('my.status', '=', 'Active')
							 ->filter('my.deleted', '=', '0')
							 ->filter('my.user_type', '=', 'system') 
							 ->filter('my.roleid', '=', $roleid)
							 ->filter('my.profileid', 'in', $userlist)
							 ->order('my.sequence', XN_Order::ASC_NUMBER)
							 ->execute();
			foreach ($users as $user)
			{
				$givename = $user->my->givename;
				if (isset($givename) && $givename != "")
				{
					$username = $user->my->givename;
				}
				else
				{
					$username = $user->my->last_name;
				}
				$userInfo[] = array ('profileid' => $user->my->profileid, 'username' => $username);
			}
		}
		return $userInfo;
	}

	/**
	 * 获取通用部门树结构信息
	 * @return array
	 * @throws XN_Exception
	 * @throws XN_IllegalArgumentException
	 */
	function getGenericRoleTree()
	{
		$hrarray = array ();
		try
		{
			$switch = XN_Memcache::get("show_role_".XN_Application::$CURRENT_URL);
		}
		catch (XN_Exception $e)
		{
			$switch = 'true';
			XN_Memcache::put("true", "show_role_".XN_Application::$CURRENT_URL);
		}

		if ($switch == 'true')
		{
			$roles = XN_Query::create('Content')
							 ->tag('Roles')
							 ->filter('type', 'eic', 'roles')
							 ->order('my.sequence', XN_Order::ASC_NUMBER)
							 ->execute();
		}
		else
		{
			$roles = XN_Query::create('Content')
							 ->tag('Roles')
							 ->filter('type', 'eic', 'roles')
							 ->filter('my.roletype', '=', '1')
							 ->order('my.sequence', XN_Order::ASC_NUMBER)
							 ->execute();
		}
		if (count($roles) > 0)
		{
			foreach ($roles as $role)
			{
				$parent                    = $role->my->parentrole;
				$temp_list                 = explode('::', $parent);
				$role_id                   = $role->my->roleid;
				$rolename                  = $role->my->rolename;
				$leadership                = $role->my->leadership;
				$mainleadership            = $role->my->mainleadership;
				$leadership_screenname     = null;
				$mainleadership_screenname = null;
				if (is_array($leadership))
				{
					$leaderships           = getUserNameList($leadership);
					$leadership_screenname = join(";", $leaderships);
				}
				else
				{
					if (isset($leadership) && $leadership != "")
					{
						$leadership_id         = $leadership;
						$leadership_screenname = getUserNameByProfile($leadership);
					}

				}
				if (isset($mainleadership) && $mainleadership != "")
				{
					$mainleadership_screenname = getUserNameByProfile($mainleadership);
				}
				$parentid = $temp_list[count($temp_list) - 2];
				if (!isset($parentid))
					$parentid = '';
				$hrarray[$role_id] = array ('key'                => $role_id,
											'name'               => $rolename,
											'leadership'         => $leadership_screenname,
											'leadership_ids'     => join(";", $leadership),
											'mainleadership'     => $mainleadership_screenname,
											'mainleadership_ids' => $mainleadership,
											'sequence'           => $role->my->sequence,
											'roletype'           => $role->my->roletype,
											'parentid'           => $parentid,);
			}
		}
		return $hrarray;
	}

	/**
	 * 创建常规的部门树HTML对像
	 * @param string $roleNodes
	 * @param array  $hrarray
	 * @param null   $selectNodes
	 * @param null   $excludeNodes
	 * @param bool   $rootBox
	 * @param bool   $isAllinfo
	 * @param bool   $hasUser
	 */
	function createGenericRoleTree(&$roleNodes = "", $hrarray, $selectNodes = null, $excludeNodes = null, $rootBox = false, $isAllinfo = false, $hasUser = false)
	{
		if (isset($excludeNodes) && $excludeNodes != "")
		{
			if (is_string($excludeNodes))
			{
				$excludeNodes = explode(';', $excludeNodes);
			}
		}
		$excludeNodes = findExcludeNodes($hrarray, $excludeNodes, true);
		if (isset($selectNodes) && $selectNodes != "")
		{
			if (is_string($selectNodes))
			{
				$selectNodes = explode(';', $selectNodes);
			}
		}
		foreach ($hrarray as $roleid => $roleinfo)
		{
			$label = $roleinfo["name"];
			if ($hasUser)
			{
				$userinfo = getUsersByRoleId($roleid);
				if (count($userinfo) > 0)
				{
					$label .= " (".count($userinfo).")";
				}
			}
			$pid   = "";
			$pname = $roleinfo["name"];
			if ($roleinfo['parentid'] !== '')
			{
				$pid   = $roleinfo['parentid'];
				$pname = $hrarray[$pid]["name"];
			}
			if (isset($excludeNodes) && is_array($excludeNodes) && count($excludeNodes) > 0 && in_array($roleid, $excludeNodes))
			{
				continue;
			}
			$roleNodes .= '<li  data-id="'.$roleid.'"
							data-pid="'.$pid.'"
							data-faicon="gift"
							data-checkall="false"
							data-nodename="'.$roleinfo["name"].'"
			';
			if (((!isset($roleinfo['parentid']) || $roleinfo['parentid'] == "") && !$rootBox))
			{
				$roleNodes .= 'data-nocheck="true"';
			}
			elseif (isset($selectNodes) && is_array($selectNodes) && count($selectNodes) > 0 && in_array($roleid, $selectNodes))
			{
				$roleNodes .= 'data-checked="true"';
			}
			if ($isAllinfo)
			{
				$roleNodes .= '
				data-leadership="'.$roleinfo['leadership'].'"
				data-leadershipids="'.$roleinfo['leadership_ids'].'"
				data-mainleadership="'.$roleinfo['mainleadership'].'"
				data-mainleadershipids="'.$roleinfo['mainleadership_ids'].'"
				data-sequence="'.$roleinfo['sequence'].'"
				data-roletype="'.$roleinfo['roletype'].'"
				data-parentname="'.$pname.'"
				';
			}
			if ($hasUser)
			{
				$roleNodes .= 'data-user-data='.json_encode($userinfo);
				if (!$isAllinfo)
				{
					$roleNodes .= '
					data-leadership="'.$roleinfo['leadership'].'"
					data-mainleadership="'.$roleinfo['mainleadership'].'"
					';
				}
			}
			$roleNodes .= '>'.$label.'</li>';
		}
	}

	/**
	 * 查找所有需排除的树节点
	 * @param $hrarray
	 * @param $excludeNodes
	 * @param $isRoot
	 * @return array
	 */
	function findExcludeNodes($hrarray, $excludeNodes, $isRoot)
	{
		$allExcludeNodes = array ();
		if (isset($excludeNodes))
		{
			if (is_string($excludeNodes) && $excludeNodes != "")
			{
				foreach ($hrarray as $key => $value_info)
				{
					$tmpID = $key;
					if (isset($value_info["value"]) && !empty($value_info["value"]))
					{
						$tmpID = $value_info["value"];
					}
					if (!$isRoot)
					{
						$tmpID = $value_info['parentid'];
					}
					if ($excludeNodes == $tmpID)
					{
						$allExcludeNodes[] = $key;
						$allExcludeNodes   = array_merge($allExcludeNodes, findExcludeNodes($hrarray, strval($key), false));
						if ($isRoot)
							break;
					}
				}
			}
			elseif (is_array($excludeNodes) && count($excludeNodes) > 0)
			{
				foreach ($excludeNodes as $ekey)
				{
					foreach ($hrarray as $key => $value_info)
					{
						$tmpID = $key;
						if (isset($value_info["value"]) && !empty($value_info["value"]))
						{
							$tmpID = $value_info["value"];
						}
						if (!$isRoot)
						{
							$tmpID = $value_info['parentid'];
						}
						if ($ekey == $tmpID)
						{
							$allExcludeNodes[] = $key;
							$allExcludeNodes   = array_merge($allExcludeNodes, findExcludeNodes($hrarray, strval($key), false));
							if ($isRoot)
								break;
						}
					}
				}
			}
		}
		return $allExcludeNodes;
	}

	function getAllProfileInfo()
	{
		$profileList  = XN_Query::create('Content')->tag('profiles')->filter('type', 'eic', 'Profiles')->order('published', XN_Order::ASC)->execute();
		$prof_details = Array ();
		foreach ($profileList as $profile)
		{
			$profileid                = $profile->id;
			$profilename              = $profile->my->profilename;
			$prof_details[$profileid] = $profilename;
		}
		return $prof_details;
	}

	function getRoleInformation($roleid)
	{
		$roles    = XN_Query::create('Content')->tag('roles')->filter('type', 'eic', 'roles')->filter('my.roleid', '=', $roleid)->execute();
		$roleInfo = Array ();
		if (count($roles) > 0)
		{
			$role              = $roles[0];
			$rolename          = $role->my->rolename;
			$parentrole        = $role->my->parentrole;
			$roledepth         = $role->my->depth;
			$parentRoleArr     = explode('::', $parentrole);
			$immediateParent   = $parentRoleArr[sizeof($parentRoleArr) - 2];
			$roleDet           = Array ();
			$roleDet[]         = $rolename;
			$roleDet[]         = $parentrole;
			$roleDet[]         = $roledepth;
			$roleDet[]         = $immediateParent;
			$roleInfo          = Array ();
			$roleInfo[$roleid] = $roleDet;
		}
		return $roleInfo;
	}

	function getRoleRelatedProfiles($roleId)
	{
		$roleRelatedProfiles = Array ();
		try
		{
			$roles = XN_Query::create('Content')->tag('Roles')->filter('type', 'eic', 'roles')->filter('my.roleid', '=', $roleId)->execute();
			if (count($roles) > 0)
			{
				$loadrole = $roles[0];
				if (is_array($loadrole->my->profileid))
				{
					$profilelist = XN_Content::loadMany($loadrole->my->profileid, "Profiles");
					foreach ($profilelist as $profile_info)
					{
						$roleRelatedProfiles[$profile_info->id] = $profile_info->my->profilename;
					}
				}
				else
				{
					$profile_info                           = XN_Content::load($loadrole->my->profileid, "Profiles");
					$roleRelatedProfiles[$profile_info->id] = $profile_info->my->profilename;
				}
			}
		}
		catch (XN_Exception $e)
		{

		}
		return $roleRelatedProfiles;
	}

	function getRoleUsers($roleId)
	{
		$users            = XN_Query::create('Content')->tag("Users")
									->filter('type', 'eic', 'Users')
									->filter('my.roleid', '=', $roleId)
									->execute();
		$roleRelatedUsers = Array ();
		foreach ($users as $user_info)
		{
			$givename = $user_info->my->givename;
			if (isset($givename) && $givename != "")
			{
				$roleRelatedUsers[$user_info->my->profileid] = $user_info->my->givename;
			}
			else
			{
				$roleRelatedUsers[$user_info->my->profileid] = $user_info->my->last_name;
			}
		}
		return $roleRelatedUsers;
	}

	function getRoleAndSubordinatesInformation($roleId)
	{
		$roleDetails   = getRoleInformation($roleId);
		$roleInfo      = $roleDetails [$roleId];
		$roleParentSeq = $roleInfo [1];

		$roles    = XN_Query::create('Content')->tag('Roles')->filter('type', 'eic', 'roles')->filter('my.parentrole', 'like', $roleParentSeq)->order('my.parentrole', XN_Order::ASC)->execute();
		$roleInfo = Array ();
		if (count($roles) > 0)
		{
			foreach ($roles as $role)
			{
				$id                 = $role->id;
				$roleid             = $role->my->roleid;
				$rolename           = $role->my->rolename;
				$parentrole         = $role->my->parentrole;
				$roledepth          = $role->my->depth;
				$roleDet            = Array ();
				$roleDet []         = $rolename;
				$roleDet []         = $parentrole;
				$roleDet []         = $roledepth;
				$roleDet []         = $id;
				$roleInfo [$roleid] = $roleDet;
			}
		}
		return $roleInfo;
	}

//获取部门所有根部门
	function getRootRolseInfo($excludeNodes = array ())
	{
		$allRoles      = XN_Query::create("Content")->tag("Roles")
								 ->filter("type", "eic", "roles")
								 ->order('my.sequence', XN_Order::ASC_NUMBER)
								 ->execute();
		$rootRolesInfo = array ();
		foreach ($allRoles as $role_info)
		{
			if ($role_info->my->parentrole !== $role_info->my->roleid || in_array($role_info->my->roleid, $excludeNodes))
			{
				continue;
			}
			$rootRolesInfo[$role_info->id]["xnid"]           = $role_info->id;
			$rootRolesInfo[$role_info->id]["roleid"]         = $role_info->my->roleid;
			$rootRolesInfo[$role_info->id]['rolename']       = $role_info->my->rolename;
			$rootRolesInfo[$role_info->id]['leadership']     = $role_info->my->leadership;
			$rootRolesInfo[$role_info->id]['mainleadership'] = $role_info->my->mainleadership;
			$rootRolesInfo[$role_info->id]['sequence']       = $role_info->my->sequence;
			$rootRolesInfo[$role_info->id]['roletype']       = $role_info->my->roletype;
			$rootRolesInfo[$role_info->id]['parent']         = $role_info->my->parentrole;
			$rootRolesInfo[$role_info->id]['parentrole']     = $role_info->my->parentrole;
		}
		return $rootRolesInfo;
	}

// 获取部门的子部门
	function getSubRolseInfo($roleId, $isSelf = false, $level = 0)
	{
		$roleinfo        = getRoleInfo($roleId);
		$roleParentLevel = count(explode('::', $roleinfo["parentrole"]));

		$subRoles     = XN_Query::create("Content")->tag("Roles")
								->filter("type", "eic", "roles")
								->filter("my.parentrole", "like", $roleinfo["parentrole"])
								->order('my.sequence', XN_Order::ASC_NUMBER)
								->execute();
		$subRolesInfo = array ();
		foreach ($subRoles as $role_info)
		{
			$parentrole    = $role_info->my->parentrole;
			$parentRoleArr = explode('::', $parentrole);
			if (!$isSelf && $roleId == $role_info->my->roleid)
			{
				continue;
			}
			if ($level > 0 && $roleParentLevel + $level < count($parentRoleArr))
			{
				continue;
			}

			$subRolesInfo[$role_info->id]["xnid"]           = $role_info->id;
			$subRolesInfo[$role_info->id]["roleid"]         = $role_info->my->roleid;
			$subRolesInfo[$role_info->id]['rolename']       = $role_info->my->rolename;
			$subRolesInfo[$role_info->id]['leadership']     = $role_info->my->leadership;
			$subRolesInfo[$role_info->id]['mainleadership'] = $role_info->my->mainleadership;
			$parent                                         = $parentRoleArr[count($parentRoleArr) - 2];
			$subRolesInfo[$role_info->id]['sequence']       = $role_info->my->sequence;
			$subRolesInfo[$role_info->id]['roletype']       = $role_info->my->roletype;
			$subRolesInfo[$role_info->id]['parent']         = $parent;
			$subRolesInfo[$role_info->id]['parentrole']     = $parentrole;
		}
		return $subRolesInfo;
	}

// 获取部门的子部门ids
	function getSubRolesIds($roleId, $isSelf = false)
	{
		$subRolesInfo = getSubRolseInfo($roleId, $isSelf);
		$roleids      = array ();
		foreach ($subRolesInfo as $key => $role_info)
		{
			$roleids[] = $role_info["roleid"];
		}
		return $roleids;
	}

// function getRoleAndSubordinatesRoleIds($roleId)
// {
// 	$roleDetails=getRoleInformation($roleId);
// 	$roleInfo=$roleDetails[$roleId];
// 	$roleParentSeq=$roleInfo[1];
// 	$roles = XN_Query::create ( 'Content' )->tag ( 'Roles' )->filter ( 'type', 'eic', 'roles' )->filter ( 'my.parentrole', 'like', $roleParentSeq )->execute ();
// 	$roleInfo=Array();
// 	if (count ( $roles ) > 0) {
// 		foreach ($roles as $role){
// 			$roleInfo[]=$role->my->roleid;
// 		}
// 	}
// 	return $roleInfo;
//
// }

	/** Function to get delete the spcified vtiger_role
	 * @param $roleid         -- RoleId :: Type varchar
	 * @param $transferRoleId -- RoleId to which vtiger_users of the vtiger_role that is being deleted are transferred:: Type varchar
	 */
	function deleteRole($roleId, $transferRoleId)
	{
		$hrarray    = Array ();
		$deletelist = array ();
		$roles      = XN_Query::create('Content')
							  ->tag('Roles')
							  ->filter('type', 'eic', 'roles')
							  ->execute();
		if (count($roles) > 0)
		{
			foreach ($roles as $role)
			{
				$parent    = $role->my->parentrole;
				$temp_list = explode('::', $parent);
				if (in_array($roleId, $temp_list))
				{
					$hrarray[]    = $role->my->roleid;
					$deletelist[] = $role;
				}
			}
		}
		if (count($hrarray) > 0)
		{
			$users = XN_Query::create('Content')
							 ->tag('Users')
							 ->filter('type', 'eic', 'Users')
							 ->filter('my.roleid', 'in', $hrarray)
							 ->execute();
			if (count($users) > 0)
			{
				foreach ($users as $user)
				{
					$user->my->roleid = $transferRoleId;
					$user->save('Users');
				}
			}
		}
		try
		{
			if (count($deletelist) > 0)
			{
				XN_Content::delete($deletelist, 'Roles');
			}
		}
		catch (XN_Exception $e)
		{
			throw new XN_Exception("error");
		}
	}

	/** Function to get userid and username of all vtiger_users
	 * @returns $userArray -- User Array in the following format:
	 * $userArray=Array($userid1=>$username, $userid2=>$username,............,$useridn=>$username);
	 */
	function getAllUserName()
	{
		$users        = XN_Query::create('Content')->tag('Users')->filter('type', 'eic', 'Users')->filter('my.deleted', '=', '0')->execute();
		$user_details = Array ();
		if (count($users) > 0)
		{
			foreach ($users as $user)
			{
				$userid   = $user->my->profileid;
				$givename = $user->my->givename;
				if (isset($givename) && $givename != "")
				{
					$user_details[$userid] = $givename;
				}
				else
				{
					$user_details[$userid] = $user->my->last_name;
				}
			}
		}
		return $user_details;

	}

	/** This function is to retreive the vtiger_profiles associated with the  the specified user
	 * It takes the following input parameters:
	 *     $userid -- The User Id:: Type Integer
	 *This function will return the vtiger_profiles associated to the specified vtiger_users in an Array in the following format:
	 *     $userProfileArray=(profileid1,profileid2,profileid3,...,profileidn);
	 */
	function getUserProfile($userId)
	{
		$users = XN_Query::create('Content')->tag('users')
						 ->filter('type', 'eic', 'users')
						 ->filter('my.profileid', '=', $userId)
						 ->begin(0)->end(1)
						 ->execute();
		if (count($users) > 0)
		{
			$user_info = $users[0];
			if (!isset($user_info->my->profilesid) && $user_info->my->profilesid != '')
				return array ($user_info->my->profilesid);
		}
		return array ();
	}

	/** To retreive the global permission of the specifed user from the various vtiger_profiles associated with the user
	 * @param $userid -- The User Id:: Type Integer
	 * @returns  user global permission  array in the following format:
	 *                $gloabalPerrArray=(view all action id=>permission,
	 *                edit all action id=>permission)                            );
	 */
	function getCombinedUserGlobalPermissions($userId)
	{
		$profArr = getUserProfile($userId);

		$no_of_profiles = sizeof($profArr);

		$userGlobalPerrArr = Array ();

		$userGlobalPerrArr = getProfileGlobalPermission($profArr[0]);

		if ($no_of_profiles != 1)
		{
			for ($i = 1; $i < $no_of_profiles; $i++)
			{
				$tempUserGlobalPerrArr = getProfileGlobalPermission($profArr[$i]);

				foreach ($userGlobalPerrArr as $globalActionId => $globalActionPermission)
				{
					if ($globalActionPermission == 1)
					{
						$now_permission = $tempUserGlobalPerrArr[$globalActionId];
						if ($now_permission == 0)
						{
							$userGlobalPerrArr[$globalActionId] = $now_permission;
						}
					}
				}
			}
		}
		return $userGlobalPerrArr;

	}

	/** To retreive the vtiger_tab permissions of the specifed user from the various vtiger_profiles associated with the user
	 * @param $userid -- The User Id:: Type Integer
	 * @returns  user global permission  array in the following format:
	 *                $tabPerrArray=(tabid1=>permission,
	 *                tabid2=>permission)                            );
	 */
	function getCombinedUserTabsPermissions($userId)
	{
		$profArr        = getUserProfile($userId);
		$no_of_profiles = sizeof($profArr);
		$userTabPerrArr = Array ();
		$userTabPerrArr = getProfileTabsPermission($profArr[0]);
		return $userTabPerrArr;

	}

	/** To retreive the vtiger_tab acion permissions of the specifed user from the various vtiger_profiles associated with the user
	 * @param $userid -- The User Id:: Type Integer
	 * @returns  user global permission  array in the following format:
	 *                $actionPerrArray=(tabid1=>permission,
	 *                tabid2=>permission);
	 */
	function getCombinedUserActionPermissions($userId)
	{
		$profArr        = getUserProfile($userId);
		$no_of_profiles = sizeof($profArr);
		$actionPerrArr  = Array ();

		$actionPerrArr = getProfileAllActionPermission($profArr[0]);

		if ($no_of_profiles != 1)
		{
			for ($i = 1; $i < $no_of_profiles; $i++)
			{
				$tempActionPerrArr = getProfileAllActionPermission($profArr[$i]);
				foreach ($actionPerrArr as $tabId => $perArr)
				{
					foreach ($perArr as $actionid => $per)
					{
						if ($per == 1)
						{
							$now_permission = $tempActionPerrArr[$tabId][$actionid];
							if ($now_permission == 0)
							{
								$actionPerrArr[$tabId][$actionid] = $now_permission;
							}
						}
					}

				}

			}

		}
		return $actionPerrArr;

	}

	/** To retreive the parent vtiger_role of the specified vtiger_role
	 * @param $roleid -- The Role Id:: Type varchar
	 * @returns  parent vtiger_role array in the following format:
	 *                $parentRoleArray=(roleid1,roleid2,.......,roleidn);
	 */
	function getParentRole($roleId)
	{
		$roleInfo          = getRoleInformation($roleId);
		$parentRole        = $roleInfo[$roleId][1];
		$tempParentRoleArr = explode('::', $parentRole);
		$parentRoleArr     = Array ();
		foreach ($tempParentRoleArr as $role_id)
		{
			if ($role_id != $roleId)
			{
				$parentRoleArr[] = $role_id;
			}
		}
		return $parentRoleArr;

	}

	/** To retreive the subordinate vtiger_roles of the specified parent vtiger_role
	 * @param $roleid -- The Role Id:: Type varchar
	 * @returns  subordinate vtiger_role array in the following format:
	 *                $subordinateRoleArray=(roleid1,roleid2,.......,roleidn);
	 */
	function getRoleSubordinates($roleId)
	{
		$roleSubordinates = VTCacheUtils::lookupRoleSubordinates($roleId);

		if ($roleSubordinates === false)
		{
			//global $adb;
			$roleDetails   = getRoleInformation($roleId);
			$roleInfo      = $roleDetails[$roleId];
			$roleParentSeq = $roleInfo[1];

			$roles_result     = XN_Query::create('Content')->tag('Roles')
										->filter('type', 'eic', 'roles')
										->filter('my.parentrole', 'like', $roleParentSeq."::")
										->order('my.parentrole', XN_Order::ASC)
										->execute();
			$roleSubordinates = Array ();
			foreach ($roles_result as $role_info)
			{
				$roleid             = $role_info->my->roleid;
				$roleSubordinates[] = $roleid;
			}

			VTCacheUtils::updateRoleSubordinates($roleId, $roleSubordinates);
		}

		return $roleSubordinates;

	}

	/** To retreive the subordinate vtiger_roles and vtiger_users of the specified parent vtiger_role
	 * @param $roleid -- The Role Id:: Type varchar
	 * @returns  subordinate vtiger_role array in the following format:
	 *                $subordinateRoleUserArray=(roleid1=>Array(userid1,userid2,userid3),
	 *                vtiger_roleid2=>Array(userid1,userid2,userid3)
	 *                |
	 *                |
	 *                vtiger_roleidn=>Array(userid1,userid2,userid3));
	 */
	function getSubordinateRoleAndUsers($roleId)
	{
		$subRoleAndUsers  = Array ();
		$subordinateRoles = getRoleSubordinates($roleId);
		foreach ($subordinateRoles as $subRoleId)
		{
			$userArray                   = getRoleUsers($subRoleId);
			$subRoleAndUsers[$subRoleId] = $userArray;

		}
		return $subRoleAndUsers;

	}

	function getCurrentUserProfileList()
	{
		$profList = array ();
		 
		global $global_user_privileges;
		$current_user_profiles = $global_user_privileges['current_user_profiles'];
		foreach ($current_user_profiles as $profid)
		{
			array_push($profList, $profid);
		}
		return $profList;
		 
	}

 
	function getSubordinateUsersList()
	{
		global $global_user_privileges;
		$subordinate_roles_users = $global_user_privileges['subordinate_roles_users'];
		 
		$user_array = Array ();
		if (sizeof($subordinate_roles_users) > 0)
		{
			foreach ($subordinate_roles_users as $roleid => $userArray)
			{
				foreach ($userArray as $userid)
				{
					if (!in_array($userid, $user_array))
					{
						$user_array[] = $userid;
					}
				}
			}
		}
		$subUserList = constructList($user_array, 'INTEGER');
		return $subUserList;

	}

	/** Function to get the vtiger_field access module array
	 * @returns The vtiger_field Access module Array :: Type Array
	 */
	function getFieldModuleAccessArray()
	{
		$tabs      = XN_Query::create('Content')->tag('tabs')
							 ->filter('type', 'eic', 'tabs')
							 ->order('my.tabid', XN_Order::ASC_NUMBER)
							 ->begin(0)->end(-1)
							 ->execute();
		$fldModArr = Array ();
		foreach ($tabs as $tab_info)
		{
			$module              = $tab_info->my->tabname;
			$fldModArr [$module] = $module;
		}
		return $fldModArr;
	}

	/** Function to get the permitted module name Array with presence as 0
	 * @returns permitted module name Array :: Type Array
	 */
	function getPermittedModuleNames()
	{
		global $global_session; 
		$tabdata  = $global_session['tabdata']; 
		$tab_seq_array = $tabdata['tab_seq_array'];
		 
		global $global_user_privileges;
		$is_admin                = $global_user_privileges['is_admin'];
		$profileGlobalPermission = $global_user_privileges['profileGlobalPermission'];
		$profileTabsPermission   = $global_user_privileges['profileTabsPermission'];
		 

		$permittedModules = Array ();
		if (($is_admin != "admin" || !is_admin(XN_Profile::$VIEWER) || !$is_admin) && $profileGlobalPermission[1] == 1 && $profileGlobalPermission[2] == 1)
		{
			foreach ($tab_seq_array as $tabid => $seq_value)
			{
				if ($seq_value == 0 && $profileTabsPermission[$tabid] == 0)
				{
					$permittedModules[] = getTabModuleName($tabid);
				}
			}
		}
		else
		{
			foreach ($tab_seq_array as $tabid => $seq_value)
			{
				if ($seq_value == 0)
				{
					$permittedModules[] = getTabModuleName($tabid);
				}
			}
		}
		return $permittedModules;
	}

	/**
	 * Function to get the permitted module id Array with presence as 0
	 * @global Users $current_user
	 * @return Array Array of accessible tabids.
	 */
	function getPermittedModuleIdList()
	{
		global $current_user;
		$permittedModules = Array ();
		 
		global $global_user_privileges;
		$is_admin                = $global_user_privileges['is_admin'];
		$profileGlobalPermission = $global_user_privileges['profileGlobalPermission'];
		$profileTabsPermission   = $global_user_privileges['profileTabsPermission'];
		global $global_session; 
		$tabdata  = $global_session['tabdata']; 
		$tab_seq_array           = $tabdata['tab_seq_array'];
		 

		if ($is_admin == true && $profileGlobalPermission[1] == 1 &&
			$profileGlobalPermission[2] == 1
		)
		{
			foreach ($tab_seq_array as $tabid => $seq_value)
			{
				if ($seq_value === 0 && $profileTabsPermission[$tabid] === 0)
				{
					$permittedModules[] = ($tabid);
				}
			}
		}
		else
		{
			foreach ($tab_seq_array as $tabid => $seq_value)
			{
				if ($seq_value === 0)
				{
					$permittedModules[] = ($tabid);
				}
			}
		}
		return $permittedModules;
	}
	
	function fetchSupplierUserRoleid($userid,$supplierid=null)
	{
		global $global_supplier_users;
		if (!isset($global_supplier_users))
		{
			$global_supplier_users = array();
		}
		if ($supplierid == null)
		{
			if(!isset($_SESSION['supplierid']) || $_SESSION['supplierid'] == '')
			{
				$supplierid = $_SESSION['supplierid'];
			}
			else
			{
				return null;
			}
		}
		$supplier_users = $global_supplier_users[$supplierid];
		
		if (!isset($supplier_users) || count($supplier_users) == 0)
		{
			$users = XN_Query::create ( 'Content' ) ->tag('supplier_users')
			    ->filter ( 'type', 'eic', 'supplier_users')
			    ->filter ( 'my.deleted', '=', '0' )
			    ->filter ( 'my.supplierid', '=' ,$supplierid)
				->end(-1)
			    ->execute();
			$supplier_users = array();
			if (count($users) > 0)
			{
				foreach($users as $supplier_user_info)
				{
					$user_info = array();
					$profileid = $supplier_user_info->my->profileid;
					$user_info['account'] = $supplier_user_info->my->account; 
					$user_info['email'] = $supplier_user_info->my->email; 
					$user_info['mobile'] = $supplier_user_info->my->mobile; 
					$user_info['supplierusertype'] = $supplier_user_info->my->supplierusertype; 
					$user_info['status'] = $supplier_user_info->my->status; 
					$user_info['supplier_usersstatus'] = $supplier_user_info->my->supplier_usersstatus; 
					$user_info['departments'] = $supplier_user_info->my->departments; 
					$user_info['access_id'] = $supplier_user_info->my->access_id; 
					$user_info['parentsuperiors'] = $supplier_user_info->my->parentsuperiors; 
					$supplier_users[$profileid] = $user_info;
				}
			}
			$global_supplier_users[$supplierid] = $supplier_users;
		}
		
		
		$user_info = $supplier_users[$userid]; 
		if (isset($user_info) && count($user_info) > 0)
		{
			return $user_info['departments'];
		}
		return null;
	}
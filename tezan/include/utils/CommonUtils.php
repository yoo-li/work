<?php
	require_once 'include/QueryGenerator/QueryGenerator.php';
	require_once 'include/ListView/ListViewController.php';
	require_once 'include/utils/VTCacheUtils.php';
	/**
	 * Check if user id belongs to a system admin.
	 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
	 * All Rights Reserved.
	 * Contributor(s): ______________________________________..
	 */
	function getUniqueID($type, $fieldname)
	{
		$contents = XN_Query::create('Content')
							->filter('type', 'eic', strtolower($type))
							->order('my.'.$fieldname, XN_Order::DESC_NUMBER)
							->begin(0)->end(1)
							->execute();
		if (count($contents) > 0)
		{
			$content_info = $contents[0];
			$myname       = strtolower($fieldname);

			return intval($content_info->my->$myname) + 1;
		}

		return 1;
	}

	/**
	 * Check if user id belongs to a system admin.
	 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
	 * All Rights Reserved.
	 * Contributor(s): ______________________________________..
	 */
	function is_admin($user)
	{
		if ($user->is_admin || $user->is_admin == 'on' || $user->is_admin == 'admin' || $user->is_admin == 'superadmin')
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	 * Decodes the given set of special character
	 * input values $string - string to be converted, $encode - flag to decode
	 * returns the decoded value in string fromat
	 */
	function from_html($string)
	{
		if (is_string($string))
		{
			if (preg_match('/(script).*(\/script)/i', $string))
				$string = preg_replace(array ('/</', '/>/', '/"/'), array ('&lt;', '&gt;', '&quot;'), $string);
		}

		return $string;
	}

	/**
	 *    Function used to decodes the given single quote and double quote only. This function used for popup selection
	 * @param string $string - string to be converted, $encode - flag to decode
	 * @return string $string - the decoded value in string fromat where as only single and double quotes will be decoded
	 */
	function popup_from_html($string, $encode = true)
	{
		$popup_toHtml = array (
			'"' => '&quot;',
			"'" => '&#039;',
		);
		if ($encode && is_string($string))
		{
			$string = addslashes(str_replace(array_values($popup_toHtml), array_keys($popup_toHtml), $string));
		}

		return $string;
	}

	/**
	 * Function to get the tabid
	 * Takes the input as $module - module name
	 * returns the tabid, integer type
	 */
	function getTabid($module)
	{
		$tabid = VTCacheUtils::lookupTabid($module);
		if ($tabid === false)
		{
			global $global_session; 
			$tabdata = $global_session['tabdata'];
			
			$all_tabs_array = $tabdata['all_tabs_array'];
			if (is_array($all_tabs_array) && count($all_tabs_array))
			{
				foreach ($all_tabs_array as $tabid => $tabname)
				{
					if (strtolower($tabname) == strtolower($module))
					{
						VTCacheUtils::updateTabidInfo($tabid, $module);

						return $tabid;
					}
				}
			}
			$query = XN_Query::create("Content")
							 ->tag("tabs")
							 ->filter("type", "eic", "tabs")
							 ->filter("my.tabname", "eic", $module)
							 ->end(1)
							 ->execute();
			if (count($query))
			{
				return $query[0]->my->tabid;
			}

			return 0;
		}

		return $tabid;
	}

	function getModuleLabel($module)
	{
		global $global_session; 
		$tabdata  = $global_session['tabdata']; 
		$all_tabs_array = $tabdata['all_tabs_array'];
		 
		$tab_id = getTabid($module);
		if (isset($all_tabs_array))
		{
			foreach ($all_tabs_array as $tabid => $tablabel)
			{
				if ($tabid == $tab_id)
					return $tablabel;
			}
		}

		return "";
	}

	/**
	 * Function to get the tabid
	 * Takes the input as $module - module name
	 * returns the tabid, integer type
	 */
	function getModule($tab_id)
	{
		global $global_session; 
		$tabdata  = $global_session['tabdata']; 
		$all_tabs_array = $tabdata['all_tabs_array'];
		 
		foreach ($all_tabs_array as $tabid => $tabname)
		{
			if ($tab_id == $tabid && $tabname!='')
			{
				return $tabname;
			}
		}
        $tab_query=XN_Query::create("Content")
            ->tag("tabs")
            ->filter("type","eic","tabs")
            ->filter("my.tabid","=",$tab_id)
            ->end(1)
            ->execute();
		if(count($tab_query)){
		    return $tab_query[0]->my->tabname;
        }
		return $tabid;
	}

	/**
	 * Function to get the fieldid
	 * @param Integer $tabid
	 * @param Boolean $onlyactive
	 */
	function getFieldid($tabid, $fieldname, $onlyactive = true)
	{
		// Look up information at cache first
		$fieldinfo = VTCacheUtils::lookupFieldInfo($tabid, $fieldname);
		if ($fieldinfo === false)
		{
			$fields = XN_Query::create('Content')->tag('Fields')
							  ->filter('type', 'eic', 'fields')
							  ->filter('my.tabid', '=', $tabid)
							  ->filter('my.fieldname', '=', $fieldname)
							  ->order('my.sequence', XN_Order::ASC_NUMBER)
							  ->end(-1)
							  ->execute();
			foreach ($fields as $field_info)
			{
				VTCacheUtils::updateFieldInfo(
					$field_info->my->tabid, $field_info->my->fieldname, $field_info->my->fieldid,
					$field_info->my->fieldlabel, $field_info->my->uitype, $field_info->my->typeofdata, $field_info->my->presence
				);
			}
			$fieldinfo = VTCacheUtils::lookupFieldInfo($tabid, $fieldname);
		}
		// Get the field id based on required criteria
		$fieldid = false;
		if ($fieldinfo)
		{
			$fieldid = $fieldinfo['fieldid'];
			if ($onlyactive && !in_array($fieldinfo['presence'], array ('0', '2')))
			{
				$fieldid = false;
			}
		}

		return $fieldid;
	}

	function getUserNameByProfile($profileid)
	{
		global $global_username;
		if (!isset($global_username))
		{
			$global_username = array();
			$users = XN_Query::create('Content')->tag('users')
							 ->filter('type', 'eic', 'users')
							 ->end(-1)
							 ->execute();
			foreach ($users as $user)
			{ 
				if (isset($user->my->givename) && $user->my->givename != "")
				{ 
					$global_username[$user->my->profileid]= $user->my->givename;
				}
				else if (isset($user->my->last_name) && $user->my->last_name != "")
				{ 
					$global_username[$user->my->profileid]= $user->my->last_name;
				}
				else 
				{ 
					$global_username[$user->my->profileid]= $user->my->user_name;
				}
			}
		}
		if (isset($global_username[$profileid]) && $global_username[$profileid] != "")
		{
			return $global_username[$profileid];
		} 
		return "";
	}

	function getUserNameList($profilelist)
	{
		global $global_username;
		if (!isset($global_username))
		{
			$global_username = array();
			$users = XN_Query::create('Content')->tag('users')
							 ->filter('type', 'eic', 'users')
							 ->end(-1)
							 ->execute();
			foreach ($users as $user)
			{ 
				if (isset($user->my->givename) && $user->my->givename != "")
				{ 
					$global_username[$user->my->profileid]= $user->my->givename;
				}
				else if (isset($user->my->last_name) && $user->my->last_name != "")
				{ 
					$global_username[$user->my->profileid]= $user->my->last_name;
				}
				else 
				{ 
					$global_username[$user->my->profileid]= $user->my->user_name;
				}
			}
		} 
		$username = array(); 
		foreach ($profilelist as $profileid)
		{
			if (isset($global_username[$profileid]) && $global_username[$profileid] != "")
			{
				$username[$profileid] = $global_username[$profileid];
			} 
		}  
		return $username;
	}

	function getMobileList($profilelist)
	{
		$username = array ();
		try
		{
			$users = XN_Query::create('Content')->tag('users')
							 ->filter('type', 'eic', 'users');
			if (is_array($profilelist))
			{
				$users->filter('my.profileid', 'in', $profilelist);
			}
			else
			{
				$users->filter('my.profileid', '=', $profilelist);
			}
			$users->order('my.sequence', XN_Order::ASC_NUMBER);
			$users = $users->execute();
			foreach ($users as $user)
			{
				$username[$user->my->profileid] = $user->my->phone_mobile;
			}
		}
		catch (XN_Exception $e)
		{
		}

		return $username;
	}

	function getFieldNamesArray($tabid)
	{
		$fields_query  = XN_Query::create("Content")
								 ->tag("fields")
								 ->filter("type", "eic", "fields")
								 ->filter("my.tabid", "=", $tabid)
								 ->begin(0)
								 ->end(-1);
		$fields_result = $fields_query->execute();
		$fields        = array ();
		foreach ($fields_result as $field_info)
		{
			$fields[] = $field_info->my->fieldname;
		}

		return $fields;
	}

	function getGivenNamesByids($ids)
	{
		if (!is_array($ids) || count($ids) == 1)
		{
			$id_array = explode(',', $ids);
		}
		else
		{
			$id_array = $ids;
		}
		$infos      = XN_Profile::loadMany($id_array);
		$givenNames = '';
		foreach ($infos as $info)
		{
			$givenname = $info->givenname;
			if ($givenname == "")
			{
				$fullName = $info->fullName;
				if (preg_match('.[#].', $fullName))
				{
					$fullNames = explode('#', $fullName);
					$fullName  = $fullNames[0];
				}
				$givenname = $fullName;
			}
			$givenNames .= strip_tags($givenname).',';
		}
		$givenNames = substr($givenNames, 0, -1);

		return $givenNames;
	}

	function getGivenNameArrByids($ids)
	{
		if (!is_array($ids))
		{
			$id_array = explode(',', $ids);
		}
		else
		{
			$id_array = (array)$ids;
		}
		if (count($id_array) == 0)
			return array ();
		$infos      = XN_Profile::loadMany($id_array, "id", "profile");
		$givenNames = array ();
		foreach ($infos as $info)
		{
			$givenname = $info->givenname;
			if ($givenname == "")
			{
				$fullName = $info->fullName;
				if (preg_match('.[#].', $fullName))
				{
					$fullNames = explode('#', $fullName);
					$fullName  = $fullNames[0];
				}
				$givenname = $fullName;
			}
			$givenNames[$info->screenName] = $givenname;
		}

		return $givenNames;
	}

	function getGivenName($profileid)
	{
		try
		{
			$info      = XN_Profile::load($profileid);
			$givenname = $info->givenname;
			if ($givenname == "")
			{
				$fullName = $info->fullName;
				if (preg_match('.[#].', $fullName))
				{
					$fullNames = explode('#', $fullName);
					$fullName  = $fullNames[0];
				}
				$givenname = $fullName;
			}

			return $givenname;
		}
		catch (XN_Exception $e)
		{
			return "";
		}
	}

	function getUserNameByProfileId($profileid)
	{
		$username = array ();
		try
		{
			$users = XN_Query::create('Content')->tag('users')
							 ->filter('type', 'eic', 'users');
			if (is_array($profileid))
			{
				$users->filter('my.profileid', 'in', $profileid);
			}
			else
			{
				$users->filter('my.profileid', '=', $profileid);
			}
			$users->order('my.sequence', XN_Order::ASC_NUMBER);
			$users->end(-1);
			$users = $users->execute();
			foreach ($users as $user)
			{
				$givename = $user->my->givename;
				if (isset($givename) && $givename != "")
				{
					$username[] = $user->my->givename;
				}
				else
				{
					$username[] = $user->my->last_name;
				}
			}
		}
		catch (XN_Exception $e)
		{
		}

		return $username;
	}

	function array_to_phpfilestr($array,$level = 1)
	{
		if (is_array($array))
		{
			$tmp = array ();
			$tab = "";
			for($i=1; $i<= $level; $i++){
				$tab .= "\t";
			}
			foreach ($array as $key => $value)
			{
				if (is_array($value))
				{
					$client = array_to_phpfilestr($value,$level+1);
					$tmp[]  = $tab . "'".$key."' => ".$client;
				}
				else
					$tmp[] = $tab . "'".$key."' => '".$value."'";
			}
			if (count($tmp) > 0)
			{
				$tab = "";
				for ($i = 1; $i < $level; $i++)
				{
					$tab .= "\t";
				}
				return "array(\n".implode(",\n", $tmp)."\n".$tab.")";
			}else
				return 'array()';
		}
		else
			return 'array()';
	}

	/*	function PhpArray_to_JsArray($array, $module = '')
		{
			if (is_array($array))
			{
				$tmp = array ();
				foreach ($array as $key => $value)
				{
					if (is_array($value))
					{
						$client = PhpArray_to_JsArray($value);
						$tmp[]  = '"'.$key.'":'.$client;
					}
					else
						$tmp[] = '"'.$key.'":"'.getTranslatedString($value, $module).'"';
				}
				if (count($tmp) > 0)
					return '{'.implode(',', $tmp).'}';
				else
					return '""';
			}
			else
				return $array;
		}*/

	/**
	 * Get the username by giving the user id.   This method expects the user id
	 */
	function getUserName($userid)
	{
		if ($userid != '')
		{
			$users = XN_Query::create('Content')->tag("Users")
							 ->filter('type', 'eic', 'Users')
							 ->filter('my.profileid', '=', $userid)
							 ->execute();
			foreach ($users as $user)
			{
				$givename = $user->my->givename;
				if (isset($givename) && $givename != "")
				{
					return $user->my->givename;
				}
				else
				{
					return $user->my->last_name;
				}
			}
		}

		return '';
	}

	function getHeaderLabelArray()
	{
		$all_tabs_label_array = array ();
		global $global_session; 
		$tabdata = $global_session['tabdata']; 
		$all_tabs_array      = $tabdata['all_tabs_array'];
		$all_tablabels_array = $tabdata['all_tablabels_array'];
		 
		if (isset($all_tabs_array) && isset($all_tablabels_array))
		{
			foreach ($all_tabs_array as $tabid => $tabname)
			{
				$all_tabs_label_array[$tabname] = $all_tablabels_array[$tabid];
			}
		}

		return $all_tabs_label_array;
	}

	/**
	 * This function is used to get the Parent and Child vtiger_tab relation array.
	 * Takes no parameter and get the data from parent_tabdata.php and vtiger_tabdata.php
	 * This returns array type value
	 */
	function getShortCutArray()
	{
		$config_system_file   = 'config.system.php';
		$Config_ShortCut_Tabs = array ();
		if (@file_exists($config_system_file))
		{
			@include($config_system_file);
		}

		return $Config_ShortCut_Tabs;
	}

	function getHeaderArray()
	{
		global $current_user;
		global $global_session;
		global $global_user_privileges;
		 
		$parent_tabdata             = $global_session['parent_tabdata'];
		$parent_tab_info_array      = $parent_tabdata['parent_tab_info_array'];
		$parent_child_tab_rel_array = $parent_tabdata['parent_child_tab_rel_array'];
		$tabdata                    = $global_session['tabdata'];
		$tab_info_array             = $tabdata['tab_info_array'];
		$all_tablabels_array        = $tabdata['all_tablabels_array']; 
		$is_admin                   = $global_user_privileges["is_admin"];
		$profileGlobalPermission    = $global_user_privileges['profileGlobalPermission'];
		$profileTabsPermission      = $global_user_privileges['profileTabsPermission'];
	
		 
		$config_system_file   = 'config.system.php'; 
		$Config_ShortCut_Tabs = array ();
		if (@file_exists($config_system_file))
		{
			@include($config_system_file);
		}
	 
		$noofrows = count($parent_tab_info_array);
		$subtabs  = array ();
		if (count($parent_tab_info_array) && !empty($parent_tab_info_array))
		{
			foreach ($parent_tab_info_array as $parenttab)
			{
				 
					$subtabs     = Array ();
					$tablist     = $parent_child_tab_rel_array[$parenttab];
					$noofsubtabs = count($tablist);
					foreach ($tablist as $childTabId)
					{
						if ($childTabId != '')
						{
							$tabid = $tab_info_array[$childTabId];
							$label = $all_tablabels_array[$tabid];
							if ($is_admin || $tabid == 3 || $is_admin == 'admin' || $is_admin == 'on' || $is_admin == 'superadmin')
							{
								$assembly = $Config_Assemblys_Tabs[$childTabId];
								if (isset($assembly))
								{
									$subtabs[$assembly][] = $childTabId;
								}
								else
								{
									$subtabs[] = $childTabId;
								}
							}
							elseif ($profileGlobalPermission[2] == 0 || $profileGlobalPermission[1] == 0 || $profileTabsPermission[$tabid] == 0)
							{
								$assembly = $Config_Assemblys_Tabs[$childTabId];
								if (isset($assembly))
								{
									$subtabs[$assembly][] = $childTabId;
								}
								else
								{
									$subtabs[] = $childTabId;
								}
							}
						}
					}
					$relatedtabs[$parenttab] = $subtabs;
				} 
		}
		$newrelatedtabs = array ();
		if (count($relatedtabs) && !empty($relatedtabs))
		{
			foreach ($relatedtabs as $parenttab => $subtabs)
			{
				if (count($subtabs) > 0)
				{
					$newrelatedtabs[$parenttab] = $subtabs;
				}
			}
		}

		return $newrelatedtabs;
	}

	function getSubHeaderArray()
	{
		$subHeader = array ();
		try
		{
			$subHeader = XN_MemCache::get("employees_tabdata_".XN_Profile::$VIEWER);
		}
		catch (XN_Exception $e)
		{   
			global $copyrights;
			if ($copyrights['program'] == 'ma')
			{ 
					$employess = XN_Query::create("Content")->tag("ma_staffs")
											->filter("type", "eic", "ma_staffs")
											->filter('my.status', '=', '0')
											->filter("my.profileid", "=", XN_Profile::$VIEWER)
											->filter("my.deleted", "=", "0")
											->end(1)
											->execute();
					if (count($employess) > 0)
					{
						$ma_accesssetting = $employess[0]->my->access_id;
						try
						{
							$accessContent  = XN_Content::load($ma_accesssetting, "ma_accesssetting");
							if($accessContent->my->isadmin == '1'){
								XN_MemCache::delete("employees_tabdata_".XN_Profile::$VIEWER);
								return null;
							}
							$access_content = $accessContent->my->access_content;
							if ($access_content != "")
							{
								$subHeader = explode(";", $access_content);
								XN_MemCache::put($subHeader, "employees_tabdata_".XN_Profile::$VIEWER);
							}
						}
						catch (XN_Exception $e)
						{
						}
					}
					else
					{
						return null;
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
				if (count($employess) > 0)
				{
					$access_id = $employess[0]->my->access_id;
					$supplierusertype = $employess[0]->my->supplierusertype;
					if ($supplierusertype == "boss")
					{ 
						return null;
					}
					else
					{
						$accessContent  = XN_Content::load($access_id, "supplier_accesssetting");
						$access_content = $accessContent->my->access_content;
						if ($access_content != "")
						{
							$subHeader = explode(";", $access_content);
							XN_MemCache::put($subHeader, "employees_tabdata_".XN_Profile::$VIEWER);
						}
					} 
				}
				else
				{
					return null;
				} 
			}
			else
			{
				return null;
			}
		}
		return $subHeader;
	}

	function getAggregate(&$MainArray, $SubArray){
		if(isset($SubArray)){
			foreach($MainArray as $key => $value){
				if(is_numeric($key)){
					if(!in_array($value, $SubArray))
					{
						unset($MainArray[$key]);
					}elseif(is_array($value)){
						getAggregate($MainArray[$key],$SubArray);
					}
				}else{
					if(!in_array($key, $SubArray)){
						unset($MainArray[$key]);
					}elseif(is_array($value)){
						getAggregate($MainArray[$key],$SubArray);
					}
				}
			}
		}
	}


	 

	/**
	 * This function is used to get the Parent Tab name for a given module.
	 * Takes the input parameter as $module - module name
	 * This returns value string type
	 */
	function getParentTabFromModule($module)
	{
		global $global_session;
		$tabdata                    = $global_session['tabdata'];
 
		$parent_tabdata             = $global_session['parent_tabdata'];
		$all_parent_tab_info_array      = $parent_tabdata['all_parent_tab_info_array'];
		$all_parent_child_tab_rel_array = $parent_tabdata['all_parent_child_tab_rel_array'];
		
		 
		if (count($all_parent_tab_info_array) && !empty($all_parent_tab_info_array))
		{
			if (in_array($module, $all_parent_tab_info_array))
			{
				return $module;
			}
		}
		if (count($all_parent_child_tab_rel_array) && !empty($all_parent_child_tab_rel_array))
		{
			foreach ($all_parent_child_tab_rel_array as $parent_tabname => $childArr)
			{
				if (in_array($module, (array)$childArr))
				{
					return $parent_tabname;
				}
			}
		}

		return null; 
	}
	
	function getParentTabLabelFromModule($module)
	{
		$parenttablabel =  getParentTabFromModule($module);
		if ($parenttablabel)
		{
			return getTranslatedString($parenttablabel);
		}
		return null; 
	}

	function getSalesEntityType($crmid)
	{
		$loadcontent = XN_Content::load($crmid);

		return $loadcontent->type;
	}

	/**
	 * This function is used to get the Parent Tab name for a given module.
	 * Takes no parameter but gets the vtiger_parenttab value from form request
	 * This returns value string type
	 */
	function getParentTab()
	{
		global $default_charset;
		if (!empty($_REQUEST['parenttab']))
		{
			if (checkParentTabExists($_REQUEST['parenttab']))
			{
				return $_REQUEST['parenttab'];
			}
			else
			{
				return getParentTabFromModule($_REQUEST['module']);
			}
		}
		else
		{
			return getParentTabFromModule($_REQUEST['module']);
		}
	}

	function checkParentTabExists($parenttab)
	{
		global $global_session; 
 
		$parent_tabdata             = $global_session['parent_tabdata'];
		$all_parent_tab_info_array = $parent_tabdata['all_parent_tab_info_array'];
		if (in_array($parenttab, $all_parent_tab_info_array))
			return true;
		else
			return false;
		 
	}

	/** This function returns the date in user specified format.
	 * param $cur_date_val - the default date format
	 */
	function getDisplayDate($cur_date_val)
	{
		global $current_user;
		$dat_fmt = $current_user->date_format;
		if ($dat_fmt == '')
		{
			$dat_fmt = 'dd-mm-yyyy';
		}
		$date_value = explode(' ', $cur_date_val);
		list($y, $m, $d) = explode('-', $date_value[0]);
		if ($dat_fmt == 'dd-mm-yyyy')
		{
			$display_date = $d.'-'.$m.'-'.$y;
		}
		elseif ($dat_fmt == 'mm-dd-yyyy')
		{
			$display_date = $m.'-'.$d.'-'.$y;
		}
		elseif ($dat_fmt == 'yyyy-mm-dd')
		{
			$display_date = $y.'-'.$m.'-'.$d;
		}
		if ($date_value[1] != '')
		{
			$display_date = $display_date.' '.$date_value[1];
		}

		return $display_date;
	}

	/**
	 * Converts localized date format string to jscalendar format
	 * Example: $array = array_csort($array,'town','age',SORT_DESC,'name');
	 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
	 * All Rights Reserved.
	 * Contributor(s): ______________________________________..
	 */
	function parse_calendardate()
	{
		global $current_user;
		if ($current_user->date_format == 'dd-mm-yyyy')
		{
			$dt_popup_fmt = "%d-%m-%Y";
		}
		elseif ($current_user->date_format == 'mm-dd-yyyy')
		{
			$dt_popup_fmt = "%m-%d-%Y";
		}
		elseif ($current_user->date_format == 'yyyy-mm-dd')
		{
			$dt_popup_fmt = "%Y-%m-%d";
		}

		return $dt_popup_fmt;
	}

	/**
	 * This function returns the date in user specified format.
	 * limitation is that mm-dd-yyyy and dd-mm-yyyy will be considered same by this API.
	 * As in the date value is on mm-dd-yyyy and user date format is dd-mm-yyyy then the mm-dd-yyyy
	 * value will be return as the API will be considered as considered as in same format.
	 * this due to the fact that this API tries to consider the where given date is in user date
	 * format. we need a better gauge for this case.
	 * @global Users $current_user
	 * @param Date   $cur_date_val the date which should a changed to user date format.
	 * @return Date
	 */
	function getValidDisplayDate($cur_date_val)
	{
		global $current_user;
		$dat_fmt = $current_user->date_format;
		if ($dat_fmt == '')
		{
			$dat_fmt = 'dd-mm-yyyy';
		}
		$date_value = explode(' ', $cur_date_val);
		list($y, $m, $d) = explode('-', $date_value[0]);
		list($fy, $fm, $fd) = explode('-', $dat_fmt);
		if ((strlen($fy) == 4 && strlen($y) == 4) || (strlen($fd) == 4 && strlen($d) == 4))
		{
			return $cur_date_val;
		}

		return getDisplayDate($cur_date_val);
	}

	function getNewDisplayDate()
	{
		global $current_user;
		$dat_fmt = $current_user->date_format;
		if ($dat_fmt == '')
		{
			$dat_fmt = 'dd-mm-yyyy';
		}
		$display_date = '';
		if ($dat_fmt == 'dd-mm-yyyy')
		{
			$display_date = date('d-m-Y');
		}
		elseif ($dat_fmt == 'mm-dd-yyyy')
		{
			$display_date = date('m-d-Y');
		}
		elseif ($dat_fmt == 'yyyy-mm-dd')
		{
			$display_date = date('Y-m-d');
		}

		return $display_date;
	}

	/**
	 * This function is used to get the display type.
	 * Takes the input parameter as $mode - edit  (mostly)
	 * This returns string type value
	 */
	function getView($mode)
	{
		if ($mode == "edit")
			$disp_view = "edit_view";
		else
			$disp_view = "create_view";

		return $disp_view;
	}

	/**
	 * This function returns the vtiger_blocks and its related information for given module.
	 * Input Parameter are $module - module name, $disp_view = display view (edit,detail or create),$mode - edit, $col_fields - * column vtiger_fields,/
	 * This function returns an array
	 */
	function getBlocks($module, $disp_view, $mode, $col_fields = '', $info_type = '')
	{
		$tabid        = getTabid($module);
		$block_detail = Array ();
		$getBlockinfo = "";
		$blocks       = XN_Query::create('Content')->tag('Blocks')
								->filter('type', 'eic', 'blocks')
								->filter('my.tabid', '=', $tabid)
								->filter('my.visible', '=', '0')
								->order('my.sequence', XN_Order::ASC_NUMBER)
								->execute();
		$prev_header  = "";
		$blockid_list = array ();
		$blockcolumns = array ();
		foreach ($blocks as $block_info)
		{
			$blockid = $block_info->my->blockid;
			array_push($blockid_list, $blockid);
			$blocklabel               = $block_info->my->blocklabel;
			$block_label[$blockid]    = $blocklabel;
			$sLabelVal                = getTranslatedString($blocklabel, $module);
			$aBlockStatus[$sLabelVal] = $block_info->my->display_status;
			$columns                  = $block_info->my->columns;
			if (isset($columns))
			{
				$blockcolumns[$blockid] = $columns;
			}
			else
			{
				$blockcolumns[$blockid] = "2";
			}
		}
		try
		{
			global $global_user_privileges;
			$is_admin                = $global_user_privileges["is_admin"];
			$profileGlobalPermission = $global_user_privileges['profileGlobalPermission'];
			global $global_session; 
			$tabdata  = $global_session['tabdata']; 
			$all_tabs_array          = $tabdata['all_tabs_array'];
			$all_entity_tabs_array   = $tabdata['all_entity_tabs_array'];
		}
		catch (XN_Exception $e)
		{
		}
		if ($is_admin == false && in_array($module, array_values($all_tabs_array)) && !in_array($module, array_values($all_entity_tabs_array)))
		{
			$is_admin = true;
		}


		if ($info_type != '')
		{
			if ($is_admin == true || $profileGlobalPermission[1] == 0 || $profileGlobalPermission[2] == 0 || $module == 'Users' || $module == "Emails")
			{
				$fields_query = XN_Query::create('Content')->tag('Fields')
										->filter('type', 'eic', 'fields')
										->filter('my.tabid', '=', $tabid)
										->filter('my.block', 'in', $blockid_list)
										->filter('my.info_type', '=', $info_type)
										->filter('my.presence', 'in', array ('0', '2'))
										->begin(0)->end(-1)
										->order('my.sequence', XN_Order::ASC_NUMBER);
				if ($mode == 'edit')
				{
					$fields_query->filter('my.displaytype', 'in', array ('1', '6'));
				}
				else
				{
					$fields_query->filter('my.displaytype', 'in', array ('1', '6', '4'));
				}
			}
			else
			{
				$profileList    = getCurrentUserProfileList();
				$profile2fields = XN_Query::create('Content')->tag('Profile2fields')
										  ->filter('type', 'eic', 'Profile2fields')
										  ->filter('my.profileid', 'in', $profileList)
										  ->filter('my.tabid', '=', $tabid)
										  ->filter('my.visible ', '!=', '0')
										  ->begin(0)->end(-1)
										  ->execute();
				$fieldlist      = array ();
				foreach ($profile2fields as $profile2field_info)
				{
					$fieldlist[] = $profile2field_info->my->fieldname;
				}
				if (count($fieldlist) == 0)
				{
					$fields_query = XN_Query::create('Content')->tag('Fields')
											->filter('type', 'eic', 'fields')
											->filter('my.tabid', '=', $tabid)
											->filter('my.block', 'in', $blockid_list)
											->filter('my.info_type', '=', $info_type)
											->filter('my.presence', 'in', array ('0', '2'))
											->begin(0)->end(-1)
											->order('my.sequence', XN_Order::ASC_NUMBER);
					if ($mode == 'edit')
					{
						$fields_query->filter('my.displaytype', 'in', array ('1', '6'));
					}
					else
					{
						$fields_query->filter('my.displaytype', 'in', array ('1', '6', '4'));
					}
				}
				else
				{
					$fields_query = XN_Query::create('Content')->tag('Fields')
											->filter('type', 'eic', 'fields')
											->filter('my.tabid', '=', $tabid)
											->filter('my.block', 'in', $blockid_list)
											->filter('my.info_type', '=', $info_type)
											->filter('my.presence', 'in', array ('0', '2'))
											->filter('my.fieldname', '!in', $fieldlist)
											->begin(0)->end(-1)
											->order('my.sequence', XN_Order::ASC_NUMBER);
					if ($mode == 'edit')
					{
						$fields_query->filter('my.displaytype', 'in', array ('1', '6'));
					}
					else
					{
						$fields_query->filter('my.displaytype', 'in', array ('1', '6', '4'));
					}
				}
			}
		}
		else
		{
			if ($is_admin == true || $profileGlobalPermission[1] == 0 || $profileGlobalPermission[2] == 0 || $module == 'Users' || $module == "Emails")
			{
				//$params = array($tabid, $blockid_list);
				$fields_query = XN_Query::create('Content')->tag('Fields')
										->filter('type', 'eic', 'fields')
										->filter('my.tabid', '=', $tabid)
										->filter('my.block', 'in', $blockid_list)
										->filter('my.presence', 'in', array ('0', '2'))
										->end(-1)
										->order('my.sequence', XN_Order::ASC_NUMBER);
				if ($mode == 'edit')
				{
					$fields_query->filter('my.displaytype', 'in', array ('1', '6'));
				}
				else
				{
					$fields_query->filter('my.displaytype', 'in', array ('1', '6', '4'));
				}
			}
			else
			{
				$profileList    = getCurrentUserProfileList();
				$profile2fields = XN_Query::create('Content')->tag('Profile2fields')
										  ->filter('type', 'eic', 'Profile2fields')
										  ->filter('my.profileid', 'in', $profileList)
										  ->filter('my.tabid', '=', $tabid)
										  ->filter('my.visible ', '!=', '0')
										  ->begin(0)->end(-1)
										  ->execute();
				$fieldlist      = array ();
				foreach ($profile2fields as $profile2field_info)
				{
					$fieldlist[] = $profile2field_info->my->fieldname;
				}
				if (count($fieldlist) == 0)
				{
					$fields_query = XN_Query::create('Content')->tag('Fields')
											->filter('type', 'eic', 'fields')
											->filter('my.tabid', '=', $tabid)
											->filter('my.block', 'in', $blockid_list)
											->filter('my.presence', 'in', array ('0', '2'))
											->end(-1)
											->order('my.sequence', XN_Order::ASC_NUMBER);
					if ($mode == 'edit')
					{
						$fields_query->filter('my.displaytype', 'in', array ('1', '6'));
					}
					else
					{
						$fields_query->filter('my.displaytype', 'in', array ('1', '6', '4'));
					}
				}
				else
				{
					$fields_query = XN_Query::create('Content')->tag('Fields')
											->filter('type', 'eic', 'fields')
											->filter('my.tabid', '=', $tabid)
											->filter('my.block', 'in', $blockid_list)
											->filter('my.presence', 'in', array ('0', '2'))
											->filter('my.fieldname', '!in', $fieldlist)
											->end(-1)
											->order('my.sequence', XN_Order::ASC_NUMBER);
					if ($mode == 'edit')
					{
						$fields_query->filter('my.displaytype', 'in', array ('1', '6'));
					}
					else
					{
						$fields_query->filter('my.displaytype', 'in', array ('1', '6', '4'));
					}
				}
			}
		}
		$fields_result = $fields_query->execute();
		$getBlockInfo  = getBlockInformation($module, $fields_result, $col_fields, $block_label, $mode, $blockcolumns);

		return $getBlockInfo;
	}

	/**
	 * This function is used to get the days in between the current time and the modified time of an entity .
	 * Takes the input parameter as $id - crmid  it will calculate the number of days in between the
	 * the current time and the modified time from the vtiger_crmentity vtiger_table and return the result as a string.
	 * The return format is updated <No of Days> day ago <(date when updated)>
	 */
	function updateEditViewInfo($currentModule, $focus)
	{
		global $app_strings;
		$modifiedtime = $focus->column_fields['updated'];
		$values       = explode(' ', $modifiedtime);
		$date_info    = explode('-', $values[0]);
		$time_info    = explode(':', $values[1]);
		$date          = $date_info[0].$app_strings['LBL_YEAR'].$app_strings[date("M", mktime(0, 0, 0, $date_info[1], $date_info[2], $date_info[0]))].$date_info[2].$app_strings['LBL_DAY'];
		$time_modified = @mktime($time_info[0], $time_info[1], $time_info[2], $date_info[1], $date_info[2], $date_info[0]);
		$time_now      = time();
		$days_diff     = (int)(($time_now - $time_modified) / (60 * 60 * 24));
		if ($days_diff == 0)
			$update_info = $app_strings['LBL_UPDATED_TODAY']." (".$date.")";
		elseif ($days_diff == 1)
			$update_info = $app_strings['LBL_UPDATED']." ".$days_diff." ".$app_strings['LBL_DAY_AGO']." (".$date.")";
		else
			$update_info = $app_strings['LBL_UPDATED']." ".$days_diff." ".$app_strings['LBL_DAYS_AGO']." (".$date.")";

		return $update_info;
	}

	function updateInfo($currentModule, $id)
	{
		global $app_strings;
		$query         = XN_Content::load($id, $currentModule);
		$modifiedtime  = $query->updatedDate;
		$values        = explode(' ', $modifiedtime);
		$date_info     = explode('-', $values[0]);
		$time_info     = explode(':', $values[1]);
		$date          = $date_info[0].$app_strings['LBL_YEAR'].$app_strings[date("M", mktime(0, 0, 0, $date_info[1], $date_info[2], $date_info[0]))].$date_info[2].$app_strings['LBL_DAY'];
		$time_modified = @mktime($time_info[0], $time_info[1], $time_info[2], $date_info[1], $date_info[2], $date_info[0]);
		$time_now      = time();
		$days_diff     = (int)(($time_now - $time_modified) / (60 * 60 * 24));
		if ($days_diff == 0)
			$update_info = $app_strings['LBL_UPDATED_TODAY']." (".$date.")";
		elseif ($days_diff == 1)
			$update_info = $app_strings['LBL_UPDATED']." ".$days_diff." ".$app_strings['LBL_DAY_AGO']." (".$date.")";
		else
			$update_info = $app_strings['LBL_UPDATED']." ".$days_diff." ".$app_strings['LBL_DAYS_AGO']." (".$date.")";

		return $update_info;
	}

	function ListView_Button_Check($module)
	{
		$buttons = array ();
		$file    = 'modules/'.$module.'/config.inc.php';
		if (@file_exists($file))
		{
			require($file);
			$systemButtons = array ();
			if ($Create)
				$systemButtons[1] = 'EditView';
			if ($Delete)
				$systemButtons[2] = 'Delete';
			
			global $global_user_privileges;
			$is_admin     = $global_user_privileges["is_admin"];
			
			global $global_session;  
			$system_file  = $global_session['system'];
			$admin_delete = $system_file['admin_delete'];
			if ($admin_delete && $is_admin)
				$systemButtons[3] = 'SuperDelete';
			
			$tabdata  = $global_session['tabdata'];
			$approvaltabs = $tabdata['approvaltabs'];
			$tabid        = getTabid($module);
			if ($MassSendApprove && in_array($tabid, $approvaltabs))
				$systemButtons[4] = 'MassSendApprove';
			if ($ExportExcel)
				$systemButtons[5] = 'ExportExcel';
			foreach ($systemButtons as $key => $action)
			{
				if (isPermitted($module, $action, '') == 'yes')
				{
					$buttons[$key] = $action;
				}
			}
			if (isset($actionmapping) && is_array($actionmapping) && count($actionmapping) > 0)
			{
				foreach ($actionmapping as $actionmapping_info)
				{
					if ($actionmapping_info['type'] == 'listview')
					{
						$action        = $actionmapping_info['actionname'];
						$securitycheck = $actionmapping_info['securitycheck'];
						$button        = $actionmapping_info['button'];
						$func          = $actionmapping_info['func'];
						if ($securitycheck == '1' || isPermitted($module, $action, '') == 'yes')
						{
							if (function_exists($func))
							{
								try
								{
									$button = $func();
								}
								catch (XN_Exception $e)
								{
								}
							}
							if ($action == "EditView")
							{
								$buttons[1] = $button;
							}
							elseif ($action == "Delete")
							{
								$buttons[2] = $button;
							}
							elseif ($action == "SuperDelete")
							{
								$buttons[3] = $button;
							}
							elseif ($action == "MassSendApprove")
							{
								$buttons[4] = $button;
							}
							elseif ($action == "ExportExcel")
							{
								$buttons[5] = $button;
							}
							else
							{
								$buttons[] = $button;
							}
						}
					}
				}
			}
		}
		ksort($buttons);  
	   // $modulereports = array(array('reportid'=>'204261','reportname'=>'供货者-数量'));
	   
       // $buttons['ModuleReport'] = $modulereports;
	    $modulereports = array();
		if(isset($_SESSION['supplierid']) && $_SESSION['supplierid'] !='')
		{
			$tabid        = getTabid($module);
			$reportsettings = array();
			global $copyrights;
		    try
		    { 
					$supplierid = $_SESSION['supplierid'];  
					$reportsettings = XN_MemCache::get("modulereport_".XN_Profile::$VIEWER); 
		    }
		    catch (XN_Exception $e)
		    { 
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
						$employes_info = $employess[0];
						$supplierusertype= $employes_info->my->authorize_type; 
					}  
					$ma_reportsettingscategorys = XN_Query::create("Content")->tag("ma_reportsettingscategorys_".$supplierid)
							 ->filter("type", "eic", "ma_reportsettingscategorys")
							 ->filter("my.deleted", "=", "0")
							 ->filter("my.supplierid", "=", $supplierid)  
							 ->end(-1)
							 ->execute();
					$categorys = array();
					foreach($ma_reportsettingscategorys as $ma_reportsettingscategorys_info)
					{
						$categoryid = $ma_reportsettingscategorys_info->id;
						$categoryname = $ma_reportsettingscategorys_info->my->categorys;
						$categorys[$categoryid] = $categoryname;
					}
					$query = XN_Query::create("Content")->tag("ma_reportsettings_".$supplierid)
							 ->filter("type", "eic", "ma_reportsettings")
							 ->filter("my.deleted", "=", "0")
							 ->filter("my.supplierid", "=", $supplierid)
							 ->filter("my.status", "=", "0")	 
							 ->end(-1); 
					if(!in_array("boss",(array)$supplierusertype))
					{
						$query->filter("my.reportuser", "=", XN_Profile::$VIEWER);
					}
					$ma_reportsettings = $query->execute();
					foreach($ma_reportsettings as $ma_reportsetting_info)
					{
						$reportid = $ma_reportsetting_info->id;
						$modulestabid = $ma_reportsetting_info->my->modulestabid;
						$reportname = $ma_reportsetting_info->my->reportname;
						$reportuser = $ma_reportsetting_info->my->reportuser;
						$reporttype = $ma_reportsetting_info->my->reporttype;
						$reportsettings[$reportid]['tabid'] = $modulestabid;
						$reportsettings[$reportid]['reportname'] = $reportname;
						$reportsettings[$reportid]['reportuser'] = $reportuser;
						$reportsettings[$reportid]['reporttype'] = $categorys[$reporttype];
					}   
					XN_MemCache::put($reportsettings,"modulereport_".XN_Profile::$VIEWER); 
				}
				else if ($copyrights['program'] == 'tezan')
				{
				    $employess = XN_Query::create ( 'Content' ) ->tag('supplier_users')
				        ->filter ( 'type', 'eic', 'supplier_users')
				        ->filter ( 'my.deleted', '=', '0' )
						->filter ( "my.supplierid", "=", $supplierid)
				        ->filter ( 'my.profileid', '=' ,XN_Profile::$VIEWER)
						 ->end(1)
				        ->execute(); 
					if(count($employess) > 0)
					{
						$employes_info = $employess[0];
						$supplierusertype= $employes_info->my->supplierusertype;  
					} 
					$supplier_reportsettingscategorys = XN_Query::create("Content")->tag("supplier_reportsettingscategorys_".$supplierid)
							 ->filter("type", "eic", "supplier_reportsettingscategorys")
							 ->filter("my.deleted", "=", "0")
							 ->filter("my.supplierid", "=", $supplierid)  
							 ->end(-1)
							 ->execute();
					$categorys = array();
					foreach($supplier_reportsettingscategorys as $supplier_reportsettingscategorys_info)
					{
						$categoryid = $supplier_reportsettingscategorys_info->id;
						$categoryname = $supplier_reportsettingscategorys_info->my->categorys;
						$categorys[$categoryid] = $categoryname;
					}
					
					$query = XN_Query::create("Content")->tag("supplier_reportsettings_".$supplierid)
							 ->filter("type", "eic", "supplier_reportsettings")
							 ->filter("my.deleted", "=", "0")
							 ->filter("my.supplierid", "=", $supplierid)
							 ->filter("my.status", "=", "0")	 
							 ->end(-1); 
					
					if($supplierusertype != "boss"){
						$query->filter("my.reportuser", "=", XN_Profile::$VIEWER);
					}
					
					$supplier_reportsettings = $query->execute();
					
					foreach($supplier_reportsettings as $supplier_reportsetting_info)
					{
						$reportid = $supplier_reportsetting_info->id;
						$modulestabid = $supplier_reportsetting_info->my->modulestabid;
						$reportname = $supplier_reportsetting_info->my->reportname;
						$reportuser = $supplier_reportsetting_info->my->reportuser;
						$reporttype = $supplier_reportsetting_info->my->reporttype;
						$reportsettings[$reportid]['tabid'] = $modulestabid;
						$reportsettings[$reportid]['reportname'] = $reportname;
						$reportsettings[$reportid]['reportuser'] = $reportuser;
						$reportsettings[$reportid]['reporttype'] = $categorys[$reporttype];
					}   
					XN_MemCache::put($reportsettings,"modulereport_".XN_Profile::$VIEWER); 
				}
		    }
			if (count($reportsettings) > 0)
			{
				$modulereports = array();
				foreach($reportsettings as $reportid => $reportsetting_info)
				{
					if ($tabid == $reportsetting_info['tabid'])
					{
						$reporttype = $reportsetting_info['reporttype'];
						$modulereports[$reporttype][$reportid]['reportid'] = $reportid;
						$modulereports[$reporttype][$reportid]['reportname'] = $reportsetting_info['reportname'];
					}
				}
				if (count($modulereports) > 0)
				{ 
					$buttons[] = array('key'=>'ModuleReport','value'=>$modulereports);
				} 
			}
		}
		
		return $buttons;
	}

	function EditView_Button_Check($module, $focus)
	{
		$file       = 'modules/'.$module.'/config.inc.php';
		$permit_arr = array ();
		if (@file_exists($file))
		{
			require($file);
			if (isset($actionmapping) && is_array($actionmapping) && count($actionmapping) > 0)
			{
				foreach ($actionmapping as $actionmapping_info)
				{
					if ($actionmapping_info['type'] == 'button')
					{
						$action        = $actionmapping_info['actionname'];
						$securitycheck = $actionmapping_info['securitycheck'];
						$button        = $actionmapping_info['button'];
						$func          = $actionmapping_info['func'];
						$tempPer       = isPermitted($module, $action, '');
						if ($tempPer == 'yes' || $securitycheck == '1')
						{
							if (function_exists($func))
							{
								try
								{
									$newbutton    = $func($module, $focus);
									$permit_arr[] = $newbutton;
								}
								catch (XN_Exception $e)
								{
									$permit_arr[] = $button;
								}
							}
							else
							{
								$permit_arr[] = $button;
							}
						}
					}
				}
			}
		}

		return $permit_arr;
	}

	function Ajax_Panel_Check($module, $focus = NULL)
	{
		$file       = 'modules/'.$module.'/config.inc.php';
		$permit_arr = array ();
		if (@file_exists($file))
		{
			require($file);
			if (isset($actionmapping) && is_array($actionmapping) && count($actionmapping) > 0)
			{
				foreach ($actionmapping as $actionmapping_info)
				{
					if ($actionmapping_info['type'] == 'ajax')
					{
						$action        = $actionmapping_info['actionname'];
						$securitycheck = $actionmapping_info['securitycheck'];
						$location      = $actionmapping_info['location'];
						$width         = $actionmapping_info['width'];
						$page          = $actionmapping_info['page'];
						$sequence      = $actionmapping_info['sequence'];
						$params        = $actionmapping_info['params'];
						if (!isset($sequence))
							$sequence = 0;
						$func    = $actionmapping_info['func'];
						$tempPer = isPermitted($module, $action, '');
						if ($tempPer == 'yes' || $securitycheck == '1')
						{
							if (function_exists($func))
							{
								try
								{
									$visible       = $func($module, $focus); 
									$permit_arr[] = array ('action' => $action, 'return_action' => $return_action, 'location' => $location, 'width' => $width, 'page' => $page, 'visible' => $visible, 'sequence' => $sequence, 'params' => $params);
								}
								catch (XN_Exception $e)
								{
									$permit_arr[] = array ('action' => $action, 'return_action' => $return_action, 'location' => $location, 'width' => $width, 'page' => $page, 'visible' => 'true', 'sequence' => $sequence, 'params' => $params);
								}
							}
							else
							{
								$permit_arr[] = array ('action' => $action, 'return_action' => $return_action, 'location' => $location, 'width' => $width, 'page' => $page, 'visible' => 'true', 'sequence' => $sequence, 'params' => $params);
							}
						}
					}
				}
			}
		}

		return $permit_arr;
	}

	/**
	 *    Function to Check for Security whether the Buttons are permitted in List/Edit/Detail View of all Modules
	 * @param string $module -- module name
	 *                       Returns an array with permission as Yes or No
	 **/
	function Button_Check($module)
	{
		$permit_arr = array ('EditView'           => '',
							 'index'              => '',
							 'Import'             => '',
							 'Export'             => '',
							 'Merge'              => '',
							 'DuplicatesHandling' => '');
		foreach ($permit_arr as $action => $perr)
		{
			$tempPer             = isPermitted($module, $action, '');
			$permit_arr[$action] = $tempPer;
		}
		$permit_arr["Calendar"]       = isPermitted("Calendar", "index", '');
		$permit_arr["moduleSettings"] = isModuleSettingPermitted($module);

		return $permit_arr;
	}

	/**
	 *    Function to Check whether the User is allowed to delete a particular record from listview of each module using
	 *    mass delete button.
	 * @param string $module   -- module name
	 * @param array  $ids_list -- Record id
	 *                         Returns the Record Names of each module that is not permitted to delete
	 **/
	function getEntityName($module, $ids_list)
	{
		if ($module != '')
		{
			if (!isset($ids_list) || ($ids_list == ""))
			{
				return array ();
			}
			if(is_string($ids_list) && (!(strpos($ids_list, ',') === false) || !(strpos($ids_list, ';') === false))){
				if (!(strpos($ids_list, ',') === false))
					$ids_list = explode(',', $ids_list);
				if (!(strpos($ids_list, ';') === false))
					$ids_list = explode(';', $ids_list);
			}
			if (!is_array($ids_list))
				$ids_list = array ($ids_list);
			if (count($ids_list) <= 0)
			{
				return array ();
			}
			$entitynames = XN_Query::create('Content')->tag('entitynames')
								   ->filter('type', 'eic', 'entitynames')
								   ->filter('my.modulename', 'eic', $module)
								   ->execute();
			if (count($entitynames) > 0)
			{
				$entityname_info = $entitynames[0];
				$fieldsname      = $entityname_info->my->fieldname;
				$tablename       = $entityname_info->my->tablename;
				try
				{
					$focus = CRMEntity::getInstance($module); 
					$datatype = $focus->datatype; 
					if ( isset($datatype) && $datatype != '')
					{
						$query = XN_Content::loadMany(array_unique($ids_list), strtolower($module),$datatype); 
					}
					else
					{
						$query = XN_Content::loadMany(array_unique($ids_list), strtolower($module));
					} 
					
					$entity_info = array ();
					foreach ($query as $query_info)
					{
						$entity_id = $query_info->id;
						if (!(strpos($fieldsname, ',') === false) || !(strpos($fieldsname, ';') === false))
						{
							if(!(strpos($fieldsname, ',') === false))
								$fieldlists = explode(',', $fieldsname);
							if(!(strpos($fieldsname, ';') === false))
								$fieldlists = explode(';', $fieldsname);
							$fieldvalue = '';
							foreach ($fieldlists as $fieldname)
							{
								if($fieldname == 'xn_id'){
									$fieldvalue .= $entity_id;
								}elseif ($fieldname == 'title' || $fieldname == 'published' || $fieldname == 'author' || $fieldname == 'updated'){
									$fieldvalue .= $query_info->$fieldname;
								}else
								{
									$fieldvalue .= $query_info->my->$fieldname;
								}
							}
							$entity_info[$entity_id] = $fieldvalue;
						}
						else
						{
							if($fieldsname == 'xn_id'){
								$entity_info[$entity_id] = $entity_id;
							}
							elseif ($fieldsname == 'title' || $fieldsname == 'published' || $fieldsname == 'author' || $fieldsname == 'updated')
							{
								$entity_info[$entity_id] = $query_info->$fieldsname;
							}
							else
							{
								$func = strtolower($module)."_getentityname_func";
								if (function_exists($func))
								{
									try
									{
										$label  = $func($query_info,$fieldsname);
										$entity_info[$entity_id] =  $label;
									}
									catch (XN_Exception $e)
									{
								 	   	$entity_info[$entity_id] =  "";
									}
								} 
								else
								{
									$entity_info[$entity_id] = $query_info->my->$fieldsname;
								}
							}
						}
					}

					return $entity_info;
				}
				catch (XN_Exception $e)
				{
				}
			}
		}

		return array ();
	}

	function getEntityNameAllValues($module)
	{
		if ($module != '')
		{
			$entitynames = XN_Query::create('Content')->tag('entitynames')
								   ->filter('type', 'eic', 'entitynames')
								   ->filter('my.modulename', '=', $module)
								   ->execute();
			if (count($entitynames) > 0)
			{
				$entityname_info = $entitynames[0];
				$fieldsname      = $entityname_info->my->fieldname;
				$tablename       = $entityname_info->my->tablename;
				try
				{
					$result = XN_Query::create('Content')->tag(strtolower($module))
									  ->filter('type', 'eic', strtolower($module))
									  ->filter('my.deleted', '=', '0')
									  ->end(-1)
									  ->order("published", XN_Order::ASC)
									  ->execute();
					foreach ($result as $info)
					{
						if ($fieldsname == 'id' || $fieldsname == 'xn_id')
						{
							$value = $info->id;
						}
						else
						{
							$value = $info->my->$fieldsname;
						}
						$values[$info->id] = $value;
					}

					return $values;
				}
				catch (XN_Exception $e)
				{
				}
			}
		}

		return array ();
	}

	/**Function to get all permitted modules for a user with their parent
	 */
	function getAllParenttabmoduleslist()
	{
		$resultant_array                = Array ();
		global $global_user_privileges;
		$is_admin                       = $global_user_privileges["is_admin"];
		$profileGlobalPermission        = $global_user_privileges['profileGlobalPermission'];
		$profileTabsPermission          = $global_user_privileges['profileTabsPermission'];
		global $global_session; 
		$tabdata  = $global_session['tabdata']; 
		$tab_info_array                 = $tabdata['tab_info_array'];
		$tab_label_array                = $tabdata['tab_label_array'];
		$parent_tabdata  = $global_session['parent_tabdata']; 
		$parent_tab_info_array          = $parent_tabdata['parent_tab_info_array'];
		$all_parent_tab_info_array      = $parent_tabdata['all_parent_tab_info_array'];
		$parent_child_tab_rel_array     = $parent_tabdata['parent_child_tab_rel_array'];
		$all_parent_child_tab_rel_array = $parent_tabdata['all_parent_child_tab_rel_array'];
		foreach ($parent_tab_info_array as $parenttabname)
		{
			$tablist = $parent_child_tab_rel_array[$parenttabname];
			foreach ($tablist as $TabName)
			{
				if ($TabName != '')
				{
					$tabid    = $tab_info_array[$TabName];
					$tablabel = $tab_label_array[$tabid];
					if ($is_admin)
					{
						$resultant_array [$parenttabname] [] = Array ($TabName, $tablabel);
					}
					elseif ($profileGlobalPermission[2] == 0 || $profileGlobalPermission[1] == 0 || $profileTabsPermission[$tabid] == 0)
					{
						$resultant_array [$parenttabname] [] = Array ($TabName, $tablabel);
					}
				}
			}
		}
		if ($is_admin)
		{
			$resultant_array['Settings'][] = Array ('Settings', 'Settings');
			$resultant_array['Settings'][] = Array ('Settings', getTranslatedString('VTLIB_LBL_MODULE_MANAGER', 'Settings'), 'NewModuleManager');
		}

		return $resultant_array;
	}


	/** This function returns the conversion rate and vtiger_currency symbol
	 * in array format for a given id.
	 * param $id - vtiger_currency id.
	 */
	function getCurrencySymbolandCRate($id)
	{
		getCurrencyName($id);
		$currencyinfo          = VTCacheUtils::lookupCurrencyInfo($id);
		$rate_symbol['rate']   = $currencyinfo['rate'];
		$rate_symbol['symbol'] = $currencyinfo['symbol'];

		return $rate_symbol;
	}

	/** Function to get the Currency name from the vtiger_currency_info
	 * @param $currencyid -- vtiger_currencyid:: Type integer
	 * @returns $currencyname -- Currency Name:: Type varchar
	 */
	function getCurrencyName($currencyid, $show_symbol = true)
	{
		$currencyinfo = VTCacheUtils::lookupCurrencyInfo($currencyid);
		if ($currencyinfo === false)
		{
			VTCacheUtils::updateCurrencyInfo($currencyid,
											 "China, Yuan Renminbi", "CNY", '¥', 1.000
			);
			$currencyinfo = VTCacheUtils::lookupCurrencyInfo($currencyid);
		}
		$currencyname = $currencyinfo['name'];
		$curr_symbol  = $currencyinfo['symbol'];
		if ($show_symbol)
			return getTranslatedCurrencyString($currencyname).' : '.$curr_symbol;
		else return $currencyname;
	}

	/**    Function used to get the translated string to the input string
	 * @param string $str - input string which we want to translate
	 * @return string $str - translated string, if the translated string is available then the translated string other wise original string will be returned
	 */
	function getTranslatedString($str, $module = '')
	{
		global $app_strings, $mod_strings, $current_language;
		$temp_mod_strings = ($module != '') ? return_module_language($current_language, $module) : $mod_strings;
		$trans_str        = ($temp_mod_strings[$str] != '') ? $temp_mod_strings[$str] : (($app_strings[$str] != '') ? $app_strings[$str] : $str);

		return $trans_str;
	}

	/**    Function used to get the translated string to the input string
	 * @param string $str - input string which we want to translate
	 * @return string $str - translated string, if the translated string is available then the translated string other wise original string will be returned
	 */
	function getTranslatedFormatString($str, $module = '', $format = array ())
	{
		global $app_strings, $mod_strings, $current_language;
		$temp_mod_strings = ($module != '') ? return_module_language($current_language, $module) : $mod_strings;
		$trans_str        = ($temp_mod_strings[$str] != '') ? $temp_mod_strings[$str] : (($app_strings[$str] != '') ? $app_strings[$str] : $str);
		if (!isset($format) || count($format) == 0)
			return $trans_str;
		for ($i = 0; $i < count($format); $i++)
		{
			$trans_str = str_replace("%".($i + 1), $format[$i], $trans_str);
		}

		return $trans_str;
	}

	/**
	 * Get translated currency name string.
	 * @param String $str - input currency name
	 * @return String $str - translated currency name
	 */
	function getTranslatedCurrencyString($str)
	{
		global $app_currency_strings;
		if (isset($app_currency_strings) && isset($app_currency_strings[$str]))
		{
			return $app_currency_strings[$str];
		}

		return $str;
	}

	/** Function to get picklist values for the given field that are accessible for the given role.
	 *  @ param $tablename picklist fieldname.
	 *  It gets the picklist values for the given fieldname
	 *    $fldVal = Array(0=>value,1=>value1,-------------,n=>valuen)
	 * @return Array of picklist values accessible by the user.
	 */
	function getPickListValues($tablename)
	{
		$picklists = XN_Query::create('Content')
							 ->tag('Picklists')
							 ->filter('type', 'eic', 'picklists')
							 ->filter('my.name', '=', $tablename)
							 ->execute();
		$fldVal    = Array ();
		foreach ($picklists as $picklist_info)
		{
			$fldVal [] = $picklist_info->my->$tablename;
		}

		return $fldVal;
	}

	function getPickListByValue($tablename, $value)
	{
		$picklists = XN_Query::create('Content')
							 ->tag('Picklists')
							 ->filter('type', 'eic', 'picklists')
							 ->filter('my.name', '=', $tablename)
							 ->filter('my.picklist_valueid', '=', $value)
							 ->execute();
		if (count($picklists) > 0)
		{
			$picklist_info = $picklists[0];

			return $picklist_info->my->$tablename;
		}

		return "";
	}

	/** Function to check the file access is made within web root directory. */
	function checkFileAccess($filepath)
	{
		global $root_directory;
		// Set the base directory to compare with
		$use_root_directory = $root_directory;
		if (empty($use_root_directory))
		{
			$use_root_directory = realpath(dirname(__FILE__).'/../../.');
		}
		$realfilepath = realpath($filepath);
		/** Replace all \\ with \ first */
		$realfilepath = str_replace('\\\\', '\\', $realfilepath);
		$rootdirpath  = str_replace('\\\\', '\\', $use_root_directory);
		/** Replace all \ with / now */
		$realfilepath = str_replace('\\', '/', $realfilepath);
		$rootdirpath  = str_replace('\\', '/', $rootdirpath);
		/*if(stripos($realfilepath, $rootdirpath) !== 0) {
		die("Sorry! Attempt to access restricted file.");
	}*/
	}

	/** Function to get owner name either user or group */
	function getOwnerName($id)
	{
		$ownerList = getOwnerNameList(array ($id));

		return $ownerList[$id];
	}

	function getOwnerProfileNameList($idList)
	{
		if (is_array($idList))
		{
			$idList = array_filter($idList);
			if (count($idList) == 0)
				return array ();
		}
		elseif ($idList == '')
		{
			return array ();
		}
		$uniqueids = array_unique((array)$idList);
		if (count($uniqueids) >= 100)
		{
			$profiles = array ();
			foreach (array_chunk($uniqueids, 100, true) as $chunk_uniqueids)
			{
				$chunkprofiles = XN_Profile::loadMany($chunk_uniqueids, 'id', "profile");
				$profiles      = array_merge(array_values($profiles), array_values($chunkprofiles));
			}
		}
		else
		{
			$profiles = XN_Profile::loadMany(array_unique((array)$idList), 'id', "profile");
		}
		$nameList = array ();
		foreach ($profiles as $profile_info)
		{
			$givenname = $profile_info->givenname;
			if (is_null($givenname) || $givenname == "")
			{
				$fullName = $profile_info->fullName;
				$wxopenid = $profile_info->wxopenid;
				if ($fullName == $wxopenid)
				{
					$givenname = '-';
				}
				else
				{
					if (preg_match('.[#].', $fullName))
					{
						$fullNames = explode('#', $fullName);
						$givenname = $fullNames[0];
					}
					else
					{
						$givenname = $fullName;
					}
				}
			}
			$nameList[$profile_info->screenName] = $givenname;
		}
		if (in_array("SYSTEM", (array)$idList))
		{
			$nameList["SYSTEM"] = "系统";
		}

		return $nameList;
	}

	/** Function to get owner name either user or group */
	function getOwnerNameList($idList)
	{
		if (is_array($idList))
		{
			$idList = array_filter($idList);
			if (count($idList) == 0)
				return array ();
		}
		elseif ($idList == '')
		{
			return array ();
		}
		$nameList = array ();
		/*	$db = PearDatabase::getInstance();
	$sql = "select user_name,id from vtiger_users where id in (".generateQuestionMarks($idList).")";
	$result = $db->pquery($sql, $idList);
	$it = new SqlResultIterator($db, $result);
	foreach ($it as $row) {
		$nameList[$row->id] = $row->user_name;
	}
*/
		$query = XN_Query::create('Content')->tag('Users')
						 ->filter('type', 'eic', 'users');
		if (is_array($idList))
			$query->filter('my.profileid', 'in', array_unique($idList));
		else
			$query->filter('my.profileid', '=', $idList);
		$query->order('my.sequence', XN_Order::ASC_NUMBER);
		$query->end(-1);
		$resutle = $query->execute();
		foreach ($resutle as $query_info)
		{
			$givename = $query_info->my->givename;
			if (isset($givename) && $givename != "")
			{
				$nameList[$query_info->my->profileid] = $query_info->my->givename;
			}
			else
			{
				$nameList[$query_info->my->profileid] = $query_info->my->last_name;
			}
		}

		/*$groupIdList = array_diff($idList, array_keys($nameList));
	if(count($groupIdList) > 0)
		$query = XN_Content::loadMany($groupIdList,'Groups');
		foreach($query as $query_info){
			$nameList[$query_info->id] = $query_info->my->groupname;
		}
	}*/

		return $nameList;
	}

	function isModuleSettingPermitted($module)
	{
		if (file_exists("modules/$module/Settings.php") &&
			isPermitted('Settings', 'index', '') == 'yes'
		)
		{
			return 'yes';
		}

		return 'no';
	}

	function approvals_reply($tabid, $recordId)
	{
		if ($recordId == null)
			return '';
		global $current_user;
		$approvals = XN_Query::create('Content')
							 ->tag('approvals')
							 ->filter('type', 'eic', 'approvals')
							 ->filter('my.tabid', '=', $tabid)
							 ->filter('my.record', '=', $recordId)
							 ->filter('my.finished', '=', 'true')
							 ->order('published', XN_Order::DESC)
							 ->execute();
		$html      = '';
		if (count($approvals) > 0)
		{
			foreach ($approvals as $approval_info)
			{
				$html .= "".$approval_info->createdDate.' '.$from_username.getTranslatedString("LBL_APPROVALS_TO").getUserLastName($approval_info->my->userid).getTranslatedString("LBL_APPROVALS_REPLY")."<br>";
			}
		}

		return $html;
	}

	function get_approvals_id($formodule, $recordId)
	{
		if ($recordId == null)
			return '';
		global $current_user;
		$tabid     = getTabid($formodule);
		$approvals = XN_Query::create('Content')
							 ->tag('approvals')
							 ->filter('type', 'eic', 'approvals')
							 ->filter('my.tabid', '=', $tabid)
							 ->filter('my.record', '=', $recordId)
			//->filter ( 'my.finished', '=', 'false' )
							 ->filter('my.userid', '=', $current_user->id)
							 ->order('published', XN_Order::DESC)
							 ->execute();
		if (count($approvals) > 0)
		{
			global $alreadyapproval, $reply, $reply_text;
			$reply_text      = $approvals[0]->my->reply_text;
			$reply           = $approvals[0]->my->reply;
			$alreadyapproval = $approvals[0]->my->finished;

			return $approvals[0]->id;
		}

		return '';
	}

	function smarty_approvals($smarty, $currentModule, $focus)
	{
		global $alreadyapproval, $reply, $reply_text;
		$smarty->assign("APPROVALS_ID", get_approvals_id($currentModule, $focus->id));
		$smarty->assign("APPROVALS_REPLY", approvals_reply($currentModule, $focus->id));
		$smarty->assign("REPLY_TEXT", $reply_text);
		$smarty->assign("REPLY", $reply);
		$smarty->assign("ALREADYAPPROVAL", $alreadyapproval);
	}

	function listviewpermission($currentModule, $search, $customfilter = NULL)
	{
		global $global_user_privileges;
		$is_admin        = $global_user_privileges["is_admin"];
		$basSearchFilter = $search->basSearchFilter;
		if ($is_admin == true && count($basSearchFilter) == 0)
			return null;
		global $global_session; 
		$tabdata  = $global_session['tabdata']; 
		$defaultOrgSharingPermission = $tabdata['defaultOrgSharingPermission'];
		$tabid                       = getTabid($currentModule);
		if (isset($defaultOrgSharingPermission))
		{
			$permission = $defaultOrgSharingPermission[$tabid];
			switch ($permission)
			{
				case 0:
				case 1:
				case 2:
					return null;
					break;
				case 3:
				default:
					$authors = array ();
					if (count($basSearchFilter) > 0)
					{
						for ($i = 0; $i < count($basSearchFilter); $i++)
						{
							if ($basSearchFilter[$i]['type'] == 'normal' && $basSearchFilter[$i]['name'] == 'author')
							{
								update_excavation_config(XN_Profile::$VIEWER, array ('selected' => $basSearchFilter[$i]['value']));
								$authors = explode(';', $basSearchFilter[$i]['value']);
							}
						}
					}
					$filtername = 'author';
					$search     = false;
					if (count($authors) > 0)
					{
						$roles_data = $authors;
						$search     = true;
					}
					else
					{
						global $global_session; 
						$rolesdata = $global_session['rolesdata']; 
						$roles_data = $rolesdata[XN_Profile::$VIEWER];
						if (!isset($roles_data))
						{
							$roles_data = array ();
						}
						$roles_data[] = XN_Profile::$VIEWER;
					}
					$approvalrecords = approvalpermission($tabid, $roles_data);
					if (count($approvalrecords) == 0)
					{
						$orgsharingpermission = XN_Filter($filtername, 'in', array_unique($roles_data));
						if (isset($customfilter))
						{
							return XN_Filter::any($orgsharingpermission, $customfilter);
						}
						else
						{
							return XN_Filter::any($orgsharingpermission);
						}
					}
					else
					{
						$orgsharingpermission = XN_Filter($filtername, 'in', array_unique($roles_data));
						$approvalpermission   = XN_Filter('id', 'in', $approvalrecords);
						if (isset($customfilter))
						{
							return XN_Filter::any($approvalpermission, $orgsharingpermission, $customfilter);
						}
						else
						{
							return XN_Filter::any($approvalpermission, $orgsharingpermission);
						}
					}
					break;
			}
		}

		return NULL;
	}

	function approvalpermission($tabid, $roles_data)
	{
		$allusers        = XN_Filter::any(XN_Filter('my.userid', 'in', $roles_data), XN_Filter('my.proxyapproval', '=', XN_Profile::$VIEWER));
		$query_result    = XN_Query::create('Content')->tag('approvals')
								   ->filter('type', 'eic', 'approvals')
								   ->filter('my.tabid', '=', $tabid)
								   ->filter($allusers)
								   ->order('published', XN_Order::DESC)
								   ->end(100)
								   ->execute();
		$approvalrecords = array ();
		foreach ($query_result as $info)
		{
			$approvalrecords[] = $info->my->record;
		}

		return $approvalrecords;
	}

	if (!function_exists('guid'))
	{
		function guid()
		{
			if (function_exists('com_create_guid'))
			{
				return com_create_guid();//window��
			}
			else
			{
				mt_srand((double)microtime() * 10000);//optional for php 4.2.0 and up.
				$charid = strtoupper(md5(uniqid(rand(), true)));
				$hyphen = chr(45);// "-"
				$uuid   = chr(123)// "{"
						  .substr($charid, 0, 8).$hyphen
						  .substr($charid, 8, 4).$hyphen
						  .substr($charid, 12, 4).$hyphen
						  .substr($charid, 16, 4).$hyphen
						  .substr($charid, 20, 12)
						  .chr(125);// "}"
				return $uuid;
			}
		}
	}

	function update_excavation_config($profileid, $config)
	{
		$result = XN_Query::create('Content')->tag('excavation')
						  ->filter('type', 'eic', 'excavation')
						  ->filter('my.profileid', '=', $profileid)
						  ->begin(0)
						  ->end(-1)
						  ->execute();
		if (count($result) >= 1)
		{
			$content = $result[0];
			$update  = false;
			foreach ($config as $key => $config_info)
			{
				if ($content->my->$key != $config_info)
				{
					$content->my->$key = $config_info;
					$update            = true;
				}
			}
			if ($update)
			{
				$content->save("excavation");
			}
		}
		else
		{
			$content = XN_Content::create('excavation', '', false);
			$content->my->add('profileid', $profileid);
			foreach ($config as $key => $config_info)
			{
				$content->my->$key = $config_info;
			}
			$content->save("excavation");
		}

		return array ();
	}

	function getPersonmanFromFocus($focus)
	{
		$profile = $focus->column_fields['author'];
		$name    = getUserNameByProfileId($profile);

		return $name;
	}

	function getRecordNum($focus,$module) {
		$mod_seq_field = getModuleSequenceField($module);
		$num = null;
		if ($focus->mode != 'create' && $mod_seq_field != null){
			$num = $focus->column_fields[$mod_seq_field["name"]];
		}
		return $num;
	}
	/**
	 * This function is used get the User Count.
	 * It returns the array which has the total vtiger_users ,admin vtiger_users,and the non admin vtiger_users
	 */
	function getUserList()
	{
		$users    = XN_Query::create('Content')->tag("Users")
							->filter('type', 'eic', 'Users')
							->filter('my.deleted', '=', '0')
							->execute();
		$userlist = array ();
		foreach ($users as $user)
		{
			$givename = $user->my->givename;
			if (isset($givename) && $givename != "")
			{
				$userlist[$user->my->profileid] = $user->my->givename;
			}
			else
			{
				$userlist[$user->my->profileid] = $user->my->last_name;
			}
		}

		return $userlist;
	}

	/**
	 * This function is used to set the Object values from the REQUEST values.
	 * @param  object reference $focus - reference of the object
	 */
	function setObjectValuesFromRequest($focus, $id = null)
	{
		global $current_user;
		if (isset($_REQUEST['record']) && $_REQUEST['record'] != '')
		{
			$focus->id = $_REQUEST['record'];
		}
		if (isset($id))
		{
			$focus->id = $id;
		}
		if (isset($_REQUEST['mode']))
		{
			$focus->mode = $_REQUEST['mode'];
		}
		foreach ($focus->column_fields as $fieldname => $val)
		{
			if (isset($_REQUEST[$fieldname]))
			{
				if (is_array($_REQUEST[$fieldname]))
					$value = $_REQUEST[$fieldname];
				else
					$value = trim($_REQUEST[$fieldname]);
				$focus->column_fields[$fieldname] = $value;
			}
			elseif (isset($_REQUEST[$fieldname."_id"]))
			{
				if (is_array($_REQUEST[$fieldname."_id"]))
					$value = $_REQUEST[$fieldname."_id"];
				else
					$value = trim($_REQUEST[$fieldname."_id"]);
				$focus->column_fields[$fieldname] = $value;
			}
		}
	}

	function create_system_file()
	{
		 
		$result = array ();
		
		$profiles = XN_Query::create('Content')->tag('profiles')
							->filter('type', 'eic', 'profiles')
							->filter('my.profilename', '=', 'Boss')
							->filter('my.superdeleted', '=', '1')
							->begin(0)->end(-1)
							->execute();
		$result   = array ();
		if (count($profiles) > 0)
		{
			$result['admin_delete'] = true;
		}
		else
		{
			$result['admin_delete'] = false;
		}
		$uinfo = XN_Query::create('Content')->tag('unitsinfomation')
						 ->filter('type', 'eic', 'unitsinfomation')
						 ->filter('my.deleted', '=', '0')
						 ->execute();
		if (count($uinfo) > 0)
		{
			$uinfo     = $uinfo[0];
			$tableinfo = array ();
			require('modules/UnitsInfomation/config.field.php');
			foreach ($tableinfo as $fieldinfo)
			{
				if ($fieldinfo['type'] == "previewimage")
				{
					$imgid = $uinfo->my->$fieldinfo['fieldname'];
					if (!empty($imgid))
					{
						try
						{
							$imageinfo                       = XN_Content::load($imgid, 'attachments');
							$url                             = $imageinfo->my->path.$imageinfo->my->savefile;
							$result[$fieldinfo['fieldname']] = $url;
						}
						catch (XN_Exception $e)
						{
						}
					}
				}
				else
					$result[$fieldinfo['fieldname']] = $uinfo->my->$fieldinfo['fieldname'];
			}
		} 
		
		try
		{
			$session = XN_MemCache::get("session_".XN_Application::$CURRENT_URL);
			$session['system'] = $result;
			XN_MemCache::put($session, "session_".XN_Application::$CURRENT_URL);
		}
		catch (XN_Exception $e)
		{
			$session = array();
			$session['system'] = $result;
			XN_MemCache::put($session, "session_".XN_Application::$CURRENT_URL);
		}
		return $result;
	}

	/**
	 * Function to write the tabid and name to a flat file vtiger_tabdata.txt so that the data
	 * is obtained from the file instead of repeated queries
	 * returns null
	 */
	function create_roles_tree_data_file()
	{
		$roles_data = getAllSubordinate(); 
		try
		{
			$session = XN_MemCache::get("session_".XN_Application::$CURRENT_URL);
			$session['rolesdata'] = $roles_data;
			XN_MemCache::put($session, "session_".XN_Application::$CURRENT_URL);
		}
		catch (XN_Exception $e)
		{
			$session = array();
			$session['rolesdata'] = $roles_data;
			XN_MemCache::put($session, "session_".XN_Application::$CURRENT_URL);
		}
		return $roles_data;
	}

	/**
	 * Function to write the tabid and name to a flat file vtiger_tabdata.txt so that the data
	 * is obtained from the file instead of repeated queries
	 * returns null
	 */
	function create_tab_data_file()
	{
		$quickcreate_fields      = XN_Query::create('Content')
										   ->tag('Fields')
										   ->filter('type', 'eic', 'fields')
										   ->filter('my.quickcreate', 'eic', '0')->execute();
		$quickcreate_tabid_array = Array ();
		foreach ($quickcreate_fields as $quickcreate_field)
		{
			$quickcreate_tabid_array[] = $quickcreate_field->my->tabid;
		}
		$all_tabs              = XN_Query::create('Content')
										 ->tag('Tabs')
										 ->filter('type', 'eic', 'tabs')
			//->order ( 'my.tabsequence', XN_Order::ASC_NUMBER )
										 ->end(-1)
										 ->execute();
		$all_tabs_array        = Array ();
		$all_tablabels_array   = Array ();
		$all_entity_tabs_array = Array ();
		$tab_info_array        = array ();
		foreach ($all_tabs as $all_tab_info)
		{
			$all_tablabels_array[$all_tab_info->my->tabid] = $all_tab_info->my->tablabel;
			$all_tabs_array[$all_tab_info->my->tabid]      = $all_tab_info->my->tabname;
			$tab_info_array[$all_tab_info->my->tabname]    = $all_tab_info->my->tabid;
			if ($all_tab_info->my->isentitytype == '1')
			{
				$all_entity_tabs_array[$all_tab_info->my->tabid] = $all_tab_info->my->tabname;
			}
		}
		$tabs_info         = XN_Query::create('Content')
									 ->tag('Tabs')
									 ->filter('type', 'eic', 'tabs')
									 ->filter('my.presence', 'in', array ('0', '2'))
									 ->order('my.tabsequence', XN_Order::ASC_NUMBER)
									 ->end(-1)
									 ->execute();
		$result_array      = Array ();
		$seq_array         = Array ();
		$ownedby_array     = Array ();
		$tablabel_array    = Array ();
		$quickcreate_array = Array ();
		foreach ($tabs_info as $tab_info) //for($i=0;$i<$num_rows;$i++)
		{
			$tabid                   = $tab_info->my->tabid;
			$tabname                 = $tab_info->my->tabname;
			$presence                = $tab_info->my->presence;
			$ownedby                 = $tab_info->my->ownedby;
			$tablabel                = $tab_info->my->tablabel;
			$result_array [$tabname] = $tabid;
			$seq_array [$tabid]      = $presence;
			$ownedby_array [$tabid]  = $ownedby;
			$tablabel_array[$tabid]  = $tablabel;
			if (in_array($tabid, $quickcreate_tabid_array))
				$quickcreate_array[] = $tabid;
		}
		$approvalflows     = XN_Query::create('Content')
									 ->tag('approvalflows')
									 ->filter('type', 'eic', 'approvalflows')
									 ->filter('my.approvalflowsstatus', '=', '1')
									 ->filter('my.deleted', '=', '0')
									 ->execute();
		$approvaltabs      = Array ();
		$optionalapprovals = array ();
		$detailapprovals   = array ();
		foreach ($approvalflows as $approvalflow_info) //for($i=0;$i<$num_rows;$i++)
		{
			$tabid           = $approvalflow_info->my->tabid;
			$approvaltabs[]  = $tabid;
			$approvaldetails = $approvalflow_info->my->approvaldetails;
			if ($approvaldetails == '1')
			{
				$detailapprovals[] = $tabid;
			} 
		}
		$def_org_share = getAllDefaultSharingAction();
		require_once('modules/Users/CreateUserPrivilegeFile.php');
		$app   = XN_Application::load(XN_Application::$CURRENT_URL);
		$datas = array (
			"applicationname"             => $app->name,
			"tab_info_array"              => $result_array,
			"approvaltabs"                => $approvaltabs, 
			"detailapprovals"             => $detailapprovals,
			"all_tabs_array"              => $all_tabs_array,
			"tab_info_array"              => $tab_info_array,
			"all_entity_tabs_array"       => $all_entity_tabs_array,
			"all_tablabels_array"         => $all_tablabels_array,
			"tab_label_array"             => $tablabel_array,
			"tab_quickcreate_array"       => $quickcreate_array,
			"tab_seq_array"               => $seq_array,
			"tab_ownedby_array"           => $ownedby_array,
			"defaultOrgSharingPermission" => $def_org_share,
		);  
		try
		{
			$session = XN_MemCache::get("session_".XN_Application::$CURRENT_URL);
			$session['tabdata'] = $datas;
			XN_MemCache::put($session, "session_".XN_Application::$CURRENT_URL);
		}
		catch (XN_Exception $e)
		{
			$session = array();
			$session['tabdata'] = $datas;
			XN_MemCache::put($session, "session_".XN_Application::$CURRENT_URL);
		}
		return $datas;
	}

	/**
	 * Function to write the vtiger_parenttabid and name to a flat file parent_tabdata.txt so that the data
	 * is obtained from the file instead of repeated queries
	 * returns null
	 */
	function create_parenttab_data_file()
	{
		$parenttabs   = XN_Query::create('Content')->tag('Parenttabs')
								->filter('type', 'eic', 'parenttabs')
								->filter('my.presence', '=', '0')
								->order('my.sequence', XN_Order::ASC_NUMBER)
								->execute();
		$result_array = Array ();
		foreach ($parenttabs as $parenttab_info)
		{
			$parenttabname   = $parenttab_info->my->parenttabname;
			$result_array [] = $parenttabname;
		}
		$all_parenttabs       = XN_Query::create('Content')->tag('Parenttabs')
										->filter('type', 'eic', 'parenttabs')
										->order('published', XN_Order::ASC)
										->execute();
		$all_parenttabs_array = Array ();
		foreach ($all_parenttabs as $parenttab_info)
		{
			$parenttabname           = $parenttab_info->my->parenttabname;
			$all_parenttabs_array [] = $parenttabname;
		}
		$parent_tabdata                              = array ();
		$parent_tabdata['parent_tab_info_array']     = $result_array;
		$parent_tabdata['all_parent_tab_info_array'] = $all_parenttabs_array;
		$parChildTabRelArray                         = Array ();
		foreach ($parenttabs as $parenttab_info)
		{
			$parenttabname = $parenttab_info->my->parenttabname;
			$tabname       = $parenttab_info->my->tabname;
			$all_tabs      = XN_Query::create('Content')
									 ->tag('Tabs')
									 ->filter('type', 'eic', 'tabs')
									 ->filter('my.presence', '=', '0')
									 ->filter('my.tabname', 'in', (array)$tabname)
									 ->order('my.tabsequence', XN_Order::ASC_NUMBER)
									 ->end(-1)
									 ->execute();
			$alltabs       = array ();
			foreach ($all_tabs as $tab_info)
			{
				$alltabs[] = $tab_info->my->tabname;
			}
			$parChildTabRelArray [$parenttabname] = $alltabs;
		}
		$parent_tabdata['parent_child_tab_rel_array'] = $parChildTabRelArray;
		$all_parChildTabRelArray                      = Array ();
		foreach ($all_parenttabs as $parenttab_info)
		{
			$parenttabname                            = $parenttab_info->my->parenttabname;
			$all_parChildTabRelArray [$parenttabname] = $parenttab_info->my->tabname;
		}
		$parent_tabdata['all_parent_child_tab_rel_array'] = $all_parChildTabRelArray; 
		try
		{
			$session = XN_MemCache::get("session_".XN_Application::$CURRENT_URL);
			$session['parent_tabdata'] = $parent_tabdata;
			XN_MemCache::put($session, "session_".XN_Application::$CURRENT_URL);
		}
		catch (XN_Exception $e)
		{
			$session = array();
			$session['parent_tabdata'] = $parent_tabdata;
			XN_MemCache::put($session, "session_".XN_Application::$CURRENT_URL);
		}
		return $parent_tabdata;
	}

	/** Function to sanitize the upload file name when the file name is detected to have bad extensions
	 * @param String -- $fileName - File name to be sanitized
	 * @return String - Sanitized file name
	 */
	function sanitizeUploadFileName($fileName, $badFileExtensions)
	{
		$fileName             = preg_replace('/\s+/', '_', $fileName);//replace space with _ in filename
		$fileName             = rtrim($fileName, '\\/<>?*:"<>|');
		$fileNameParts        = explode(".", $fileName);
		$countOfFileNameParts = count($fileNameParts);
		$badExtensionFound    = false;
		for ($i = 0; $i < $countOfFileNameParts; ++$i)
		{
			$partOfFileName = $fileNameParts[$i];
			if (in_array(strtolower($partOfFileName), $badFileExtensions))
			{
				$badExtensionFound = true;
				$fileNameParts[$i] = $partOfFileName.'file';
			}
		}
		$newFileName = implode(".", $fileNameParts);
		if ($badExtensionFound)
		{
			$newFileName .= ".txt";
		}

		return $newFileName;
	}

	/**
	 *    This function is used to decide the File Storage Path in where we will upload the file in the server.
	 *    return string $filepath  - filepath inwhere the file should be stored in the server will be return
	 */
	function decideFilePath()
	{
		global $adb;
		$filepath = 'storage';
		if (!is_dir($filepath))
		{
			mkdir($filepath);
		}
		$filepath .= '/'.XN_Application::$CURRENT_URL;
		if (!is_dir($filepath))
		{
			mkdir($filepath);
		}
		$year  = date('Y');
		$month = date('F');
		$day   = date('md');
		$week  = '';
		$filepath .= '/'.$year;
		if (!is_dir($filepath))
		{
			mkdir($filepath);
		}
		$filepath .= '/'.$month;
		if (!is_dir($filepath))
		{
			mkdir($filepath);
		}
		$filepath .= '/'.$day;
		if (!is_dir($filepath))
		{
			mkdir($filepath);
		}
		$filepath .= '/';

		return $filepath;
	}

	/**
	 * 获取当前用户的所有下级
	 * @return array
	 * @throws XN_IllegalArgumentException
	 */
	function getAllSubordinate()
	{
		global $list, $user_list;
		if (!isset($user_list))
		{
			global $copyrights;
			if ($copyrights['program'] == 'ma'){
				$employess = XN_Query::create("Content")->tag("ma_staffs")
									 ->filter("type", "eic", "ma_staffs")
									 ->filter('my.status', '=', '0')
									 ->filter("my.deleted", "=", "0")
									 ->filter("my.profileid", "=", $_SESSION['authenticated_user_id'])
									 ->end(1)
									 ->execute();
				if(count($employess) > 0){
					$employess = XN_Query::create("Content")->tag("ma_staffs")
										 ->filter("type", "eic", "ma_staffs")
										 ->filter('my.status', '=', '0')
										 ->filter("my.deleted", "=", "0")
										 ->filter("my.supplierid", "=", $employess[0]->my->supplierid)
										 ->end(-1)
										 ->execute();
					$userlist = array ();
					foreach ($employess as $info)
					{
						$user_list[$info->my->profileid] = $info->my->parentsuperiors;
					}
				}
			}else
			{
				$query    = XN_Query::create('Content')->tag('users')
									->filter('type', 'eic', 'users')
									->filter('my.deleted', '=', '0')
									->filter('my.status', '=', 'Active')
									->order('my.sequence', XN_Order::ASC_NUMBER)
									->execute();
				$userlist = array ();
				foreach ($query as $info)
				{
					$user_list[$info->my->profileid] = $info->my->reports_to_id;
				}
			}
		}
		$roles_data = array ();
		if (is_array($user_list))
		{
			foreach ($user_list as $uid => $superior)
			{
				$list = array ();
				get_All_Subordinate($uid, $user_list);
				$roles_data[$uid] = array_unique($list);
			}
		}

		return $roles_data;
	}

	function get_All_Subordinate($uid, $user_list)
	{
		global $list;
		if (isset($user_list[$uid]))
		{
			foreach ($user_list as $key => $value)
			{
				if (!in_array($key, $list) && ($uid == $value) && $uid != $key)
				{
					$list[] = $key;
					get_All_Subordinate($key, $user_list);
				}
			}
		}
	}

	function get_applicator_name()
	{
		try
		{
			$app = XN_Application::load(XN_Application::$CURRENT_URL);
			if ($app->name == null)
				return "";

			return $app->name;
		}
		catch (XN_Exception $e)
		{
			return "";
		}
	}

	function sendemail($to_email, $subject, $contents, $from_name = '', $from_email = '')
	{
		try
		{
			XN_Content::create('sendemail', '', false, 2)
				->my->add('status', 'waiting')
				->my->add('type', 'simple')
				->my->add('to_email', $to_email)
				->my->add('from_email', $from_email)
				->my->add('from_name', $from_name)
				->my->add('subject', $subject)
				->my->add('contents', $contents)
					->save("sendemail");
		}
		catch (XN_Exception $e)
		{
		}
	}

	function subtext_check($sourcestr, $cutlength)
	{
		$returnstr  = '';
		$i          = 0;
		$n          = 0;
		$str_length = strlen($sourcestr);//字符串的字节数
		while (($n < $cutlength) and ($i <= $str_length))
		{
			$temp_str = substr($sourcestr, $i, 1);
			$ascnum   = Ord($temp_str);//得到字符串中第$i位字符的ascii码
			if ($ascnum >= 224)    //如果ASCII位高与224，
			{
				$returnstr = $returnstr.substr($sourcestr, $i, 3); //根据UTF-8编码规范，将3个连续的字符计为单个字符
				$i         = $i + 3;            //实际Byte计为3
				$n         = $n + 2;            //字串长度计1
			}
			elseif ($ascnum >= 192) //如果ASCII位高与192，
			{
				$returnstr = $returnstr.substr($sourcestr, $i, 2); //根据UTF-8编码规范，将2个连续的字符计为单个字符
				$i         = $i + 2;            //实际Byte计为2
				$n         = $n + 1.5;            //字串长度计1
			}
			elseif ($ascnum >= 65 && $ascnum <= 90) //如果是大写字母，
			{
				$returnstr = $returnstr.substr($sourcestr, $i, 1);
				$i         = $i + 1;            //实际的Byte数仍计1个
				$n++;            //但考虑整体美观，大写字母计成一个高位字符
			}
			else                //其他情况下，包括小写字母和半角标点符号，
			{
				$returnstr = $returnstr.substr($sourcestr, $i, 1);
				$i         = $i + 1;            //实际的Byte数计1个
				$n++;        //小写字母和半角标点等与半个高位字符宽...
			}
		}
		if ($str_length > $cutlength)
		{
			$returnstr = $returnstr."...";//超过长度时在尾处加上省略号
		}

		return $returnstr;
	}

	function stringtofloat($str)
	{
		preg_match("/[0-9\.]+/", $str, $number);
		if (count($number) > 0)
		{
			return floatval($number[0]);
		}

		return 0;
	}

	function formatpercent($a, $b)
	{
		if ($b == 0)
			return 0;
		$temp = $a / $b * 100;

		return number_format($temp, 2, ".", "")."%";
	}

	function formatnumber($value)
	{
		if ($value == 0)
			return "0";
		if ($value == "")
			return "";
		if ($value == "-")
			return "-";
		if (floatval($value) == intval($value))
		{
			return number_format(floatval($value), 0, "", ",");
		}
		else
		{
			return number_format(floatval($value), 2, ".", ",");
		}
	}

	function rmbnumber($value)
	{
		if ($value == 0)
			return "0";
		if ($value == "")
			return "";
		if ($value == "-")
			return "-";

		return number_format(floatval($value), 2, ".", ",");
	}

	/**
	 * 人民币小写转大写
	 * @param string $number        数值
	 * @param string $int_unit      币种单位，默认"元"，有的需求可能为"圆"
	 * @param bool   $is_round      是否对小数进行四舍五入
	 * @param bool   $is_extra_zero 是否对整数部分以0结尾，小数存在的数字附加0,比如1960.30，
	 *                              有的系统要求输出"壹仟玖佰陆拾元零叁角"，实际上"壹仟玖佰陆拾元叁角"也是对的
	 * @return string
	 */
	function num2rmb($number = 0, $int_unit = '元', $is_round = TRUE, $is_extra_zero = FALSE)
	{
		// 将数字切分成两段
		$parts = explode('.', $number, 2);
		$int   = isset($parts[0]) ? strval($parts[0]) : '0';
		$dec   = isset($parts[1]) ? strval($parts[1]) : '';
		// 如果小数点后多于2位，不四舍五入就直接截，否则就处理
		$dec_len = strlen($dec);
		if (isset($parts[1]) && $dec_len > 2)
		{
			$dec = $is_round
				? substr(strrchr(strval(round(floatval("0.".$dec), 2)), '.'), 1)
				: substr($parts[1], 0, 2);
		}
		// 当number为0.001时，小数点后的金额为0元
		if (empty($int) && empty($dec))
		{
			return '零';
		}
		// 定义
		$chs     = array ('0', '壹', '贰', '叁', '肆', '伍', '陆', '柒', '捌', '玖');
		$uni     = array ('', '拾', '佰', '仟');
		$dec_uni = array ('角', '分');
		$exp     = array ('', '万');
		$res     = '';
		// 整数部分从右向左找
		for ($i = strlen($int) - 1, $k = 0; $i >= 0; $k++)
		{
			$str = '';
			// 按照中文读写习惯，每4个字为一段进行转化，i一直在减
			for ($j = 0; $j < 4 && $i >= 0; $j++, $i--)
			{
				$u   = $int{$i} > 0 ? $uni[$j] : ''; // 非0的数字后面添加单位
				$str = $chs[$int{$i}].$u.$str;
			}
			//echo $str."|".($k - 2)."<br>";
			$str = rtrim($str, '0');// 去掉末尾的0
			$str = preg_replace("/0+/", "零", $str); // 替换多个连续的0
			if (!isset($exp[$k]))
			{
				$exp[$k] = $exp[$k - 2].'亿'; // 构建单位
			}
			$u2  = $str != '' ? $exp[$k] : '';
			$res = $str.$u2.$res;
		}
		// 如果小数部分处理完之后是00，需要处理下
		$dec = rtrim($dec, '0');
		// 小数部分从左向右找
		if (!empty($dec))
		{
			$res .= $int_unit;
			// 是否要在整数部分以0结尾的数字后附加0，有的系统有这要求
			if ($is_extra_zero)
			{
				if (substr($int, -1) === '0')
				{
					$res .= '零';
				}
			}
			for ($i = 0, $cnt = strlen($dec); $i < $cnt; $i++)
			{
				$u = $dec{$i} > 0 ? $dec_uni[$i] : ''; // 非0的数字后面添加单位
				$res .= $chs[$dec{$i}].$u;
			}
			$res = rtrim($res, '0');// 去掉末尾的0
			$res = preg_replace("/0+/", "零", $res); // 替换多个连续的0
		}
		else
		{
			$res .= $int_unit.'整';
		}

		return $res;
	}

	function create_authorize_file()
	{
		$result     = array ();
		$authorizes = XN_Query::create('Content')->tag('authorize')
							  ->filter('type', 'eic', 'authorize')
							  ->execute();
		if (count($authorizes) > 0)
		{
			foreach ($authorizes as $authorize_info)
			{
				$authorize = $authorize_info->my->authorize;
				$userid    = $authorize_info->my->userid;
				$users     = explode(";", $userid);
				if (count($users) > 0)
				{
					$result[$authorize] = $users;
				}
			}
		} 
		try
		{
			$session = XN_MemCache::get("session_".XN_Application::$CURRENT_URL);
			$session['authorize'] = $result;
			XN_MemCache::put($session, "session_".XN_Application::$CURRENT_URL);
		}
		catch (XN_Exception $e)
		{
			$session = array();
			$session['authorize'] = $result;
			XN_MemCache::put($session, "session_".XN_Application::$CURRENT_URL);
		}
		return $result; 
	}

	if (!function_exists('check_authorize'))
	{
		function check_authorize($key,$userid=null)
		{
			global $global_session;
			$authorize = $global_session['authorize']; 
			if (!$userid)
			{
				$userid = XN_Profile::$VIEWER;
			}
			
			if (count($authorize) > 0) 
			{
				if (isset($authorize[$key]) && !empty($authorize[$key]))
				{
					$authorize_profiles =  $authorize[$key];
					if (in_array($userid, $authorize_profiles))
					{
						return true;
					}
				}
			}
			
			global $global_user_privileges;
			
			$authorize = $global_user_privileges['authorize'];
			 
			if (count($authorize) > 0) 
			{
				if (isset($authorize[$key]) && !empty($authorize[$key]))
				{
					$authorize_profiles =  $authorize[$key];
					if (in_array($userid, $authorize_profiles))
					{
						return true;
					}
				}
			}  
			return false;
		}
	}
	/*function simple_content($content)
	{
		if (count($content) > 0)
		{
			$content_info = $content[0];

			return format_simple_content($content_info);
		}

		return array ();
	}*/

	/*function format_simple_content($content)
	{
		$values = array ();
		if (get_class($content) == "XN_Content")
		{
			foreach ($content->my->attribute() as $na)
			{
				if (is_array($na))
				{
					foreach ($na as $na1)
					{
						if (isset($na1))
						{
							$name               = $na1->name;
							$values[$na1->name] = $content->my->$name;
						}
					}
				}
				else if (isset($na))
				{
					$values[$na->name] = $na->value;
				}
			}
			$values['id']          = $content->id;
			$values['createdDate'] = $content->createdDate;
			$values['published']   = $content->createdDate;
			$values['updatedDate'] = $content->updatedDate;
			$values['updated']     = $content->updatedDate;
			$values['author']      = $content->contributorName;
			$values['title']       = $content->title;
			$values['type']        = $content->type;
		}

		return $values;
	}

	function format_content($result)
	{
		$list = array ();
		foreach ($result as $key => $content)
		{
			$values = array ();
			foreach ($content->my->attribute() as $na)
			{
				if (is_array($na))
				{
					foreach ($na as $na1)
					{
						if (isset($na1))
						{
							$name               = $na1->name;
							$values[$na1->name] = $content->my->$name;
						}
					}
				}
				else if (isset($na))
				{
					$values[$na->name] = $na->value;
				}
			}
			$values['id']          = $content->id;
			$values['createdDate'] = $content->createdDate;
			$values['published']   = $content->createdDate;
			$values['updatedDate'] = $content->updatedDate;
			$values['updated']     = $content->updatedDate;
			$values['author']      = $content->contributorName;
			$values['title']       = $content->title;
			$values['type']        = $content->type;
			$list[$key]            = $values;
		}

		return $list;
	}*/

	/**
	 *  短消息函数,可以在某个动作处理后友好的提示信息
	 * @param     string $msg       消息提示信息
	 * @param     string $navTabId  刷新navTabid
	 * @param     int    $limittime 延迟窗口关闭时间
	 * @return    void
	 */
	function ShowMessage($msg, $navTabId = null, $limittime = 2000)
	{
		global $currentModule;
		$msg = '<style>div{line-height:160%;}</style>
<center>
<br>
<div style="width:100%;padding:0px;">
<div style="font-size:10pt;">
<br>'.$msg.'
<br><br><br></div>
</div>
</center>
<script type="text/javascript" defer="defer">
function closemessagebox()
{
		jQuery.pdialog.closeCurrent();
		navTab.reloadFlag(\''.$currentModule.'\');
}
setTimeout("closemessagebox();",'.$limittime.');
</script>
';
		echo $msg;
	}

	function create_profilerank_config()
	{
		$profileranks      = XN_Query::create('MainContent')->tag('profilerank')
									 ->filter('type', 'eic', 'profilerank')
									 ->filter('my.deleted', '=', '0')
									 ->filter('my.status', '=', 'Active')
									 ->order('my.minrank', XN_Order::DESC_NUMBER)
									 ->end(-1)
									 ->execute();
		$profilerankconfig = array ();
		foreach ($profileranks as $profilerank_info)
		{
			$id                     = $profilerank_info->id;
			$rankname               = $profilerank_info->my->rankname;
			$minrank                = $profilerank_info->my->minrank;
			$discountrate           = $profilerank_info->my->discountrate;
			$sharebonus             = $profilerank_info->my->sharebonus;
			$logo                   = $profilerank_info->my->logo;
			$profilerankconfig[$id] = array (
				'rankname'     => $rankname,
				"minrank"      => $minrank,
				"logo"         => $logo,
				'discountrate' => $discountrate,
				'sharebonus'   => $sharebonus,
			);
		}
		XN_MemCache::put($profilerankconfig, "profilerank_".XN_Application::$CURRENT_URL);

		return $profilerankconfig;
	}

	function GetProfileInfo($profileid)
	{
		$fields = array ();
		try
		{
			$profile  = XN_Profile::load($profileid, "id", "profile");
			$fullName = $profile->fullName;
			if (preg_match('.[#].', $fullName))
			{
				$fullNames = explode('#', $fullName);
				$fullName  = $fullNames[0];
			}
			$displayname = $profile->givenname;
			if ($displayname == "")
			{
				$fullName = $profile->fullName;
				if (!preg_match('#,#', $fullName))
				{
					$fullNames = explode('#', $fullName);
					$fullName  = $fullNames[0];
				}
				$displayname = $fullName;
			}
			$membertype            = ($profile->type == "jjr") ? "经纪人" : "个人";
			$emailverified         = ($profile->emailverified == "true") ? "1" : "0";
			$mobileverified        = ($profile->mobileverified == "true") ? "1" : "0";
			$fields['membertype']  = $membertype;
			$fields['mobile']      = $profile->mobile;
			$fields['gender']      = $profile->gender;
			$fields['age']         = $profile->age;
			$fields['birthdate']   = $profile->birthdate;
			$fields['address']     = $profile->address;
			$fields['zipcode']     = $profile->zipcode;
			$fields['givenname']   = $profile->givenname;
			$fields['fullName']    = $fullName;
			$fields['displayname'] = $displayname;
			global $cfg_imgserver;
			$fields['link']             = $cfg_imgserver.$profile->link;
			$fields['email']            = $profile->email;
			$fields['qq']               = $profile->qq;
			$fields['msn']              = $profile->msn;
			$fields['emailverified']    = $emailverified;
			$fields['mobileverified']   = $mobileverified;
			$fields['realname']         = $profile->realname;
			$fields['companyname']      = $profile->companyname;
			$fields['identitycard']     = $profile->identitycard;
			$fields['identitycardlink'] = $cfg_imgserver.$profile->identitycardlink;
			$fields['businesscardlink'] = $cfg_imgserver.$profile->businesscardlink;
			$fields['certificatelink']  = $cfg_imgserver.$profile->certificatelink;
			$fields['profile_cityarea'] = $profile->cityarea;
			$fields['profile_location'] = $profile->location;
			$fields['isaudit']          = $profile->isaudit;
		}
		catch (XN_Exception $e)
		{
		}

		return $fields;
	}

	function SynchronousProfile($profileid)
	{
		try
		{
			$profile  = XN_Profile::load($profileid, "id", "profile");
			$fullName = $profile->fullName;
			if (preg_match('.[#].', $fullName))
			{
				$fullNames = explode('#', $fullName);
				$fullName  = $fullNames[0];
			}
			$membertype     = ($profile->type == "jjr") ? "jjr" : "pt";
			$emailverified  = ($profile->emailverified == "true") ? "1" : "0";
			$mobileverified = ($profile->mobileverified == "true") ? "1" : "0";
			$members        = XN_Query::create('Content')->tag('members')
									  ->filter('type', 'eic', 'members')
									  ->filter('my.profileid', '=', $profileid)
									  ->filter('my.deleted', '=', '0')
									  ->execute();
			$update         = false;
			if (count($members) > 0)
			{
				$member_info = $members[0];
				if ($member_info->my->membertype != $membertype)
				{
					$member_info->my->membertype = $membertype;
					$update                      = true;
				}
				if ($member_info->my->emailverified != $emailverified)
				{
					$member_info->my->emailverified = $emailverified;
					$update                         = true;
				}
				if ($member_info->my->mobileverified != $mobileverified)
				{
					$member_info->my->mobileverified = $mobileverified;
					$update                          = true;
				}
				$fields = array ("realname", "givenname", "email", "mobile", "province", "city", "cityarea", "location", "gender",
								 "birthdate", "isaudit", "link", "identitycardlink", "identitycard",
								 "businesscardlink", "certificatelink");
				foreach ($fields as $fieldname)
				{
					if ($member_info->my->$fieldname != $profile->$fieldname)
					{
						$member_info->my->$fieldname = $profile->$fieldname;
						$update                      = true;
					}
				}
				if ($update)
					$member_info->save('members');
			}
			else
			{
				/*try
			{
				$newcontent = XN_Content::create('members','',false);
				$newcontent->my->deleted = '0';
				$newcontent->save('members');

				chdir($_SERVER['DOCUMENT_ROOT']);

				global $AllPermitted;
				$AllPermitted = true;

				require_once('modules/Members/Members.php');
				$focus = CRMEntity::getInstance('Members');
				$focus->id = $newcontent->id;
				$focus->column_fields['profileid'] = $profileid;
				$focus->column_fields['username'] = $fullName;
				$focus->column_fields['membertype'] = $membertype;
				$focus->column_fields['realname'] = $profile->realname;
				$focus->column_fields['givenname'] = $profile->givenname;
				$focus->column_fields['email'] = $profile->email;
				$focus->column_fields['mobile'] = $profile->mobile;
				$focus->column_fields['cityarea'] = $profile->cityarea;
				$focus->column_fields['location'] = $profile->location;
				$focus->column_fields['gender'] = $profile->gender;
				$focus->column_fields['birthdate'] = $profile->birthdate;
				$focus->column_fields['emailverified'] = $emailverified;
				$focus->column_fields['mobileverified'] = $mobileverified;
				$focus->column_fields['isaudit'] = $profile->isaudit;
				$focus->column_fields['link'] = $profile->link;
				$focus->column_fields['identitycardlink'] = $profile->identitycardlink;
				$focus->column_fields['identitycard'] = $profile->identitycard;
				$focus->column_fields['businesscardlink'] = $profile->businesscardlink;
				$focus->column_fields['certificatelink'] = $profile->certificatelink;

				$focus->save('Members');
			}
			catch ( XN_Exception $e ) { }*/
			}
			$users = XN_Query::create('Content')->tag('users')
							 ->filter('type', 'eic', 'users')
							 ->filter('my.profileid', '=', $profileid)
							 ->filter('my.deleted', '=', '0')
							 ->execute();
			if (count($users) > 0)
			{
				$user_info = $users[0];
				$update    = false;
				if ($user_info->my->last_name != $profile->givenname)
				{
					$user_info->my->last_name = $profile->givenname;
					$user_info->my->givenname = $profile->givenname;
					$update                   = true;
				}
				if ($user_info->my->email1 != $profile->email)
				{
					$user_info->my->email1 = $profile->email;
					$update                = true;
				}
				if ($user_info->my->phone_mobile != $profile->mobile)
				{
					$user_info->my->phone_mobile = $profile->mobile;
					$update                      = true;
				}
				if ($user_info->my->gender != $profile->gender)
				{
					$user_info->my->gender = $profile->gender;
					$update                = true;
				}
				if ($user_info->my->birthday != $profile->birthdate)
				{
					$user_info->my->birthday = $profile->birthdate;
					$update                  = true;
				}
				if ($user_info->my->thumb != $profile->link)
				{
					$user_info->my->thumb = $profile->link;
					$update               = true;
				}
				if ($user_info->my->is_admin != $profile->type)
				{
					$user_info->my->is_admin = $profile->type;
					$update                  = true;
				}
				if ($update)
					$user_info->save('users');
			}
		}
		catch (XN_Exception $e)
		{
			echo $e->getMessage();
		}
	}

	function getProfileRank($rank)
	{
		//$configfile = $_SERVER['DOCUMENT_ROOT'].'/cache/'.XN_Application::$CURRENT_URL.'/profilerank.php';
		try
		{
			$profilerankconfig = XN_MemCache::get("profilerank_".XN_Application::$CURRENT_URL);
		}
		catch (XN_Exception $e)
		{
			create_profilerank_config();
			$profilerankconfig = XN_MemCache::get("profilerank_".XN_Application::$CURRENT_URL);
		}
		if ($rank < 0)
			$rank = 0;
		foreach ($profilerankconfig as $profilerank_info)
		{
			$rankname = $profilerank_info['rankname'];
			$minrank  = $profilerank_info['minrank'];
			if ($rank >= $minrank)
				return $rankname;
		}
		$profilerank_info = $profilerankconfig[0];

		return $profilerank_info['rankname'];
	}

    function getdoamin()
    {
        if (strpos($_SERVER["SERVER_SOFTWARE"],"nginx") !==false)
        {
            $servername =$_SERVER['HTTP_HOST'];
        }
        else
        {
            $servername =$_SERVER['SERVER_NAME'];
        }
        if (preg_match("/[\w\-]+\.\w+$/", $servername, $domain))
        {
            return strtolower($domain[0]);
        }
        return "";
    }
/*
	function getdoamin()
	{
		if (preg_match("/[\w\-]+\.\w+$/", $_SERVER['SERVER_NAME'], $domain))
		{
			return strtolower($domain[0]);
		}

		return "";
	}
*/
	function get_zh_cn_weekday($numofweekday)
	{
		if ($numofweekday == 0)
			return "周日";
		if ($numofweekday == 1)
			return "周一";
		if ($numofweekday == 2)
			return "周二";
		if ($numofweekday == 3)
			return "周三";
		if ($numofweekday == 4)
			return "周四";
		if ($numofweekday == 5)
			return "周五";
		if ($numofweekday == 6)
			return "周六";
	}

	//时间转换函数
	function strtrantime($datetime)
	{
		$time     = strtotime($datetime);
		$swaptime = strtotime("now") - $time;
		if ($swaptime > 31536000)
		{
			return date("Y-m-d H:i", $time);
		}
		else if ($swaptime > 5616000)
		{
			return date("m-d H:i", $time);
		}
		else if ($swaptime > 5184000)
		{
			return "2月前";
		}
		else if ($swaptime > 5092000)
		{
			return "1月前";
		}
		else if ($swaptime > 1296000)
		{
			return "半月前";
		}
		else if ($swaptime > 864000)
		{
			return "10天前";
		}
		else if ($swaptime > 259200)
		{
			return "3天前";
		}
		else if ($swaptime > 172800)
		{
			return "前天";
		}
		else if ($swaptime > 86400)
		{
			return "昨天";
		}
		else if ($swaptime > 43200)
		{
			return "12小时前";
		}
		else if ($swaptime > 21600)
		{
			return "6小时前";
		}
		else if ($swaptime > 10800)
		{
			return "3小时前";
		}
		else if ($swaptime > 7200)
		{
			return "2小时前";
		}
		else if ($swaptime > 3600)
		{
			return "1小时前";
		}
		else if ($swaptime > 1800)
		{
			return "30分钟前";
		}
		else if ($swaptime > 900)
		{
			return "15分钟前";
		}
		else if ($swaptime > 600)
		{
			return "10分钟前";
		}
		else if ($swaptime > 300)
		{
			return "5分钟前";
		}
		else if ($swaptime > 180)
		{
			return "3分钟前";
		}
		else
		{
			return "刚刚";
		}
	}
	function strswaptime($swaptime)
	{ 	 
		if ($swaptime > 31536000)
		{
			return date("Y-m-d H:i", $time);
		}
		else if ($swaptime > 5616000)
		{
			return date("m-d H:i", $time);
		}
		else if ($swaptime > 5184000)
		{
			return "2月";
		}
		else if ($swaptime > 5092000)
		{
			return "1月";
		}
		else if ($swaptime > 1296000)
		{
			return "半月";
		}
		else if ($swaptime > 864000)
		{
			return "10天";
		}
		else if ($swaptime > 259200)
		{
			return "3天";
		}
		else if ($swaptime > 172800)
		{
			return "天";
		}
		else if ($swaptime > 86400)
		{
			return "昨天";
		}
		else if ($swaptime > 43200)
		{
			return "12小时";
		}
		else if ($swaptime > 21600)
		{
			return "6小时";
		}
		else if ($swaptime > 10800)
		{
			return "3小时";
		}
		else if ($swaptime > 7200)
		{
			return "2小时";
		}
		else if ($swaptime > 3600)
		{
			return "1小时";
		}
		else if ($swaptime > 1800)
		{
			return "30分钟";
		}
		else if ($swaptime > 900)
		{
			return "15分钟";
		}
		else if ($swaptime > 600)
		{
			return "10分钟";
		}
		else if ($swaptime > 300)
		{
			return "5分钟";
		}
		else if ($swaptime > 180)
		{
			return "3分钟";
		}
		else if ($swaptime > 120)
		{
			return "2分钟";
		}
		else if ($swaptime > 60)
		{
			return "1分钟";
		}
		else
		{
			return $swaptime."秒";
		}
	}

if (!function_exists('check_accesstype'))
{
	function check_accesstype($keys)
	{
		global $accesstype;
		if(empty($keys)){
			return false;
		}
		$keys=(array)$keys;
		if (isset($accesstype) && !empty($accesstype))
		{
			$accesstypes=(array)$accesstype;
			$inserts=array_intersect($keys,$accesstypes);
			if(count($inserts)>0)
				return true;
		}
		return false;
	}
}

function getPlupLoadHtml($currentModule, $record, $fieldname, $fieldvalues, $div_width, $div_height, $image_width, $image_height, $readonly, $multi_selection, $title)
	{
		$timestamp   = time();
		$unique_salt = md5('unique_salt'.$timestamp);
		$html        = '';
		if ($multi_selection == 'false')
			$html .= '<div id="'.$fieldname.'_file_container" style="display:block;float:left;"></div>';
		if ($readonly == 'false')
		{
			if (!empty($fieldvalues) && count($fieldvalues) > 0 && $fieldvalues[0] != "" && @file_exists($_SERVER['DOCUMENT_ROOT'].$fieldvalues[0]) && $multi_selection == 'false')
			{
				$html .= '<div id="'.$fieldname.'pickfiles" style="display:none;width'.$div_width.'px;height:'.$div_height.'px;position: relative;float:left;margin:2px 3px;border:1px solid #cdcdcd;">
            <img style="margin:4px 7px 8px 7px;width:'.($div_width - 14).'px;height:'.($div_height - 12).'px;" src="/Public/images/uploadimg.png" alt="'.$title.'">
        </div>';
			}
			else
			{
				$html .= '<div id="'.$fieldname.'pickfiles" style="display:block;width:'.$div_width.'px;height:'.$div_height.'px;position: relative;float:left;margin:2px 3px;border:1px solid #cdcdcd;">
            <img style="margin:4px 7px 8px 7px;width:'.($div_width - 14).'px;height:'.($div_height - 12).'px;" src="/Public/images/uploadimg.png" alt="'.$title.'">
        </div>';
			}
		}
		if (!empty($fieldvalues) != "" && count($fieldvalues) >= 1 && $fieldvalues[0] != "" && @file_exists($_SERVER['DOCUMENT_ROOT'].$fieldvalues[0]))
		{
			$html .= '<div style="clear:both;">';
			foreach ($fieldvalues as $key => $fieldvalue)
			{
				if ($fieldvalue != "")
				{
					$recordid = $record.$key;
					if ($image_width > 0 && $image_height > 0)
					{
						$html .= '<div id="plupload_img_'.$fieldname.$recordid.'" style="width:'.($div_width + 14).'px;height:'.($div_height + 12).'px;position: relative;float:left;margin:8px 3px;border:1px solid #cdcdcd;">
                    <input id="'.$fieldname.$recordid.'" type="hidden" name="'.$fieldname.'[]" value="'.$fieldvalue.'">
                    <input type="hidden" name="image_'.$fieldname.$recordid.'" value="'.$fieldvalue.'">
                    <a id="data_lightbox_'.$fieldname.$recordid.'" href="'.$fieldvalue.'" data-lightbox="roadtrip"><img class="img-responsive" src="'.$fieldvalue.'" style="margin:4px 7px 0px 7px;border:1px #ddd solid;display:block;height:'.$div_height.'px;width:'.$div_width.'px;"></a>';
					}
					else
					{
						$html .= '<div id="plupload_img_'.$fieldname.$recordid.'" style="max-width:140px;position: relative;float:left;margin:8px 3px;border:1px solid #cdcdcd;">
                    <input id="'.$fieldname.$recordid.'" type="hidden" name="'.$fieldname.'[]" value="'.$fieldvalue.'">
                    <input type="hidden" name="image_'.$fieldname.$recordid.'" value="'.$fieldvalue.'">
                    <a id="data_lightbox_'.$fieldname.$recordid.'" href="'.$fieldvalue.'" data-lightbox="roadtrip"><img class="img-responsive" src="'.$fieldvalue.'" style="margin:4px 7px 0px 7px;border:1px #ddd solid;display:block;max-width:126px;"></a>';
					}
					if ($readonly == 'false')
					{
						$html .= '<a onclick="productfile_delete(\''.$fieldname.'\',\''.$recordid.'\');" href="javascript:void(0);" style="display:block; height:15px; width:15px; position:absolute; top:0px; right:2px;">
                <img src="/Public/images/guanbi.jpg">
            </a>';
					}
					else
					{
						$html .= '<a onclick="productfile_delete(\''.$fieldname.$recordid.'\');" href="javascript:void(0);" style="display:none; height:15px; width:15px; position:absolute; top:0px; right:2px;">
                <img src="/Public/images/guanbi.jpg">
            </a>';
					}
					$html .= '<div id="progress_'.$fieldname.$recordid.'" style="width: 120px; float: left; margin: 0px 7px; height: 4px; text-align: center; display: none; background-color: rgba(18, 18, 224, 0.498039);">100%</div></div>';
				}
			}
			$html .= '</div>';
		}
		if ($multi_selection == 'true')
			$html .= '<div id="'.$fieldname.'_file_container" style="display:block;clear:both;"></div>';
		if ($readonly == 'false')
		{
			$html .= '<div id="'.$fieldname.'filelist" style="display:block;float:left;">Your browser doesn\'t have Flash, Silverlight or HTML5 support.</div>
    <style>.moxie-shim,.moxie-shim-html5{display:none;}</style>
    <script type="text/javascript" >
    $(document).ready(function(){
        var fieldname="'.$fieldname.'";
        var multi_selection="'.$multi_selection.'";
        if(multi_selection!=""){
            if(multi_selection=="false")multi_selection_value=false;
            if(multi_selection=="true")multi_selection_value=true;
        }else{
            multi_selection_value=true;
        }
        var width=parseInt('.$div_width.',10);
        var height=parseInt('.$div_height.',10);
        var browse_button=fieldname+"pickfiles";
        if(width>0 && height>0){
            var resize_parameter="{width:"+width+",height:"+height+",quality: 90}";
            var image_style="width:"+width+"px;height:"+height+"px;";
            var image_div_style="width:"+(width+14)+"px;height:"+(height+12)+"px;";
        }
        if(width>0 && height==0){
            var resize_parameter="{width:"+width+",quality: 90}";
            var image_style="width:"+width+"px;";
            var image_div_style="width:"+(width+14)+"px;";
        }
        if(width==0 && height>0){
            var resize_parameter="{height:"+height+",quality: 90}";
            var image_style="height:"+height+"px;";
            var image_div_style="height:"+(height+12)+"px;";
        }
        if(width==0 && height==0){
            var resize_parameter="{quality: 90}";
            var image_style="max-width:126px;";
            var image_div_style="max-width:140px;";
        }
        var uploader = new plupload.Uploader({
            runtimes : "html5,flash,silverlight,html4",
            browse_button : browse_button,
            file_data_name: "Filedata",
            container: document.getElementById(fieldname+"_file_container"),
            multi_selection:multi_selection_value,
            url : "Upload.php?m="+ Math.random(),
            multipart_params: {
                "timestamp" : "'.$timestamp.'",
                "token"     : "'.$unique_salt.'",
                "module"    : "'.$currentModule.'",
                "record"    : "'.$record.'",
                '.($image_width ? "img_width:$image_width," : "img_width:0,").($image_height ? "img_height:$image_height" : "img_height:0").'
            },
            resize: resize_parameter,
            filters : {
                max_file_size : "50mb",
                mime_types: [
                    {title : "Image files", extensions : "jpg,gif,png"}
                ]
            },
            init: {
                PostInit: function() {
                    $("#"+fieldname+"filelist").html("") ;
                },
                FilesAdded: function(up, files) {
                    plupload.each(files, function(file) {
                        var filename=file.name;
                        var filesize=file.size;
                        var fileid=file.id;
                        var filesrc=file.src;
                        if(multi_selection=="false"){
                            $("<div id=\'plupload_img_"+fieldname+""+fileid+"\' style=\'"+image_div_style+"position: relative;float:left;margin:8px 3px;border:1px solid #cdcdcd;\'>"
                                    +"<input type=\'hidden\' id=\'"+fieldname+""+fileid+"\' name=\'"+fieldname+"[]\' value=\'\'>"
                                    +"<input type=\'hidden\' name=\'image_"+fieldname+""+fileid+"\' value=\'\'  />"
                                    +"<a id=\'data_lightbox_"+fieldname+""+fileid+"\' href=\'/Public/images/uploading.gif\' data-lightbox=\'roadtrip\'><img class=\'img-responsive\' src=\'/Public/images/uploading.gif\' style=\'margin:4px 7px 0px 7px;border:1px #ddd solid;display:block;"+image_style+"\' />"
                                    +"<a onclick=\'productfile_delete(\""+fieldname+"\",\""+fileid+"\");\' href=\'javascript:void(0);\' style=\'display:block; height:15px; width:15px; position:absolute; top:0px; right:2px;\'>"
                                    +"<img src=\'/Public/images/guanbi.jpg\' /></a><div id=\'progress_"+fieldname+""+fileid+"\' style=\'width:0px;float:left;margin:0px 7px;height:4px;background-color:rgba(18,18,224,0.5);text-align:center;\'></div></div>").insertBefore($("#"+fieldname+"pickfiles"));
                            $("#"+fieldname+"pickfiles").css("display","none");
                        }else{
                            $("#"+fieldname+"_file_container").append("<div id=\'plupload_img_"+fieldname+""+fileid+"\' style=\'"+image_div_style+"position: relative;float:left;margin:8px 3px;border:1px solid #cdcdcd;\'>"
                                    +"<input type=\'hidden\' id=\'"+fieldname+""+fileid+"\' name=\'"+fieldname+"[]\' value=\'\'>"
                                    +"<input type=\'hidden\' name=\'image_"+fieldname+""+fileid+"\' value=\'\'  />"
                                    +"<a id=\'data_lightbox_"+fieldname+""+fileid+"\' href=\'/Public/images/uploading.gif\' data-lightbox=\'roadtrip\'><img class=\'img-responsive\' src=\'/Public/images/uploading.gif\' style=\'margin:4px 7px 0px 7px;border:1px #ddd solid;display:block;"+image_style+"\' />"
                                    +"<a onclick=\'productfile_delete(\""+fieldname+"\",\""+fileid+"\");\' href=\'javascript:void(0);\' style=\'display:block; height:15px; width:15px; position:absolute; top:0px; right:2px;\'>"
                                    +"<img src=\'/Public/images/guanbi.jpg\' /></a><div id=\'progress_"+fieldname+""+fileid+"\' style=\'width:0px;float:left;margin:0px 7px;height:4px;background-color:rgba(18,18,224,0.5);text-align:center;\'></div></div>");
                        }

                    });
                    uploader.start();
                },
                UploadProgress:function(uploader,file){
                    var cur_width=width*file.percent/100;
                    $("#progress_"+fieldname+""+file.id).css("width",cur_width+"px");
                    $("#progress_"+fieldname+""+file.id).text(file.percent+"%");
                },
                FileUploaded:function(up, file, info){
                    eval( "var jsondata =" + info.response+";");
                    var err_msg=jsondata.error;
                    var orginalid=file.id;
                    var orginalname=file.name;
                    if(err_msg!=""){
                        alert("图片("+orginalname+")"+err_msg);
                        jQuery("#plupload_img_"+fieldname+orginalid).remove();
                        jQuery("#"+fieldname+"pickfiles").css("display","block");
                        jQuery("#"+fieldname).val("");
                    }else{
                        var fileid=jsondata.id;
                        var type=file.type;
                        var size=file.size;
                        var imgurl=decodeURIComponent(jsondata.src);
                        $("#"+fieldname+""+orginalid).val(imgurl);
                        $("#plupload_img_"+fieldname+""+orginalid).find("input[name^=\'image_\']").val(imgurl);
                        $("#plupload_img_"+fieldname+""+orginalid).find(".img-responsive").attr("src",imgurl);
                        $("#data_lightbox_"+fieldname+""+orginalid).attr("href",imgurl);
                        $("#plupload_img_"+fieldname+""+orginalid).find("div[id^=\'progress_\']").css("display","none");
                        $("#plupload_img_"+fieldname+""+orginalid).find("div[id^=\'progress_percent_\']").css("display","none");
                        if(multi_selection=="false")$("#"+fieldname+"pickfiles").css("display","none");
                    }
                },
                Error: function(up, err) {
                    alert("Error : " + err.message);
                }
            }
        });
        uploader.init();
    });
    function productfile_delete(fieldname,fileid){
        $("#plupload_img_"+fieldname+fileid).remove();
        $("#"+fieldname+"pickfiles").css("display","block");
        $("#"+fieldname).val("");
    }
    </script>
    ';
		}

		return $html;
	}

function getResiterPlupLoadHtml($fieldname,$div_width, $div_height, $image_width, $image_height, $readonly, $multi_selection, $title)
{
	$timestamp   = time();
	$unique_salt = md5('unique_salt'.$timestamp);
	$html        = '';
	if ($multi_selection == 'false')
		$html .= '<div id="'.$fieldname.'_file_container" style="display:block;float:left;"></div>';
	if ($readonly == 'false')
	{
		$html .= '<div id="'.$fieldname.'pickfiles" style="display:inline-block;width:'.$div_width.'px;height:'.$div_height.'px;position: relative;margin:2px 3px;border:1px solid #cdcdcd;">
            <img style="margin:4px 7px 8px 7px;width:'.($div_width - 14).'px;height:'.($div_height - 12).'px;" src="/Public/images/uploadimg.png" alt="'.$title.'">
        </div>';

	}

	if ($multi_selection == 'true')
		$html .= '<div id="'.$fieldname.'_file_container" style="display:block;clear:both;"></div>';
	if ($readonly == 'false')
	{
		$html .= '<div id="'.$fieldname.'filelist" style="display:block;float:left;">Your browser doesn\'t have Flash, Silverlight or HTML5 support.</div>
    <style>.moxie-shim,.moxie-shim-html5{display:none;}</style>
    <script type="text/javascript" >
    $(document).ready(function(){
        var fieldname="'.$fieldname.'";
        var multi_selection="'.$multi_selection.'";
        if(multi_selection!=""){
            if(multi_selection=="false")multi_selection_value=false;
            if(multi_selection=="true")multi_selection_value=true;
        }else{
            multi_selection_value=true;
        }
        var width=parseInt('.$div_width.',10);
        var height=parseInt('.$div_height.',10);
        var browse_button=fieldname+"pickfiles";
        if(width>0 && height>0){
            var resize_parameter="{width:"+width+",height:"+height+",quality: 90}";
            var image_style="width:"+width+"px;height:"+height+"px;";
            var image_div_style="width:"+(width+14)+"px;height:"+(height+12)+"px;";
        }
        if(width>0 && height==0){
            var resize_parameter="{width:"+width+",quality: 90}";
            var image_style="width:"+width+"px;";
            var image_div_style="width:"+(width+14)+"px;";
        }
        if(width==0 && height>0){
            var resize_parameter="{height:"+height+",quality: 90}";
            var image_style="height:"+height+"px;";
            var image_div_style="height:"+(height+12)+"px;";
        }
        if(width==0 && height==0){
            var resize_parameter="{quality: 90}";
            var image_style="max-width:626px;";
            var image_div_style="max-width:640px;";
        }
        var uploader = new plupload.Uploader({
            runtimes : "html5,flash,silverlight,html4",
            browse_button : browse_button,
            file_data_name: "Filedata",
            container: document.getElementById(fieldname+"_file_container"),
            multi_selection:multi_selection_value,
            url : "/registerUpload.php?m="+ Math.random(),

            resize: resize_parameter,
            filters : {
                max_file_size : "50mb",
                mime_types: [
                    {title : "Image files", extensions : "jpg,gif,png"}
                ]
            },
            init: {
                PostInit: function() {
                    $("#"+fieldname+"filelist").html("") ;
                },
                FilesAdded: function(up, files) {
                    plupload.each(files, function(file) {
                        var filename=file.name;
                        var filesize=file.size;
                        var fileid=file.id;
                        var filesrc=file.src;
                        if(multi_selection=="false"){
                            $("<div id=\'plupload_img_"+fieldname+""+fileid+"\' style=\'"+image_div_style+"position: relative;float:left;margin:8px 3px;border:1px solid #cdcdcd;\'>"
                                    +"<input type=\'hidden\' id=\'"+fieldname+""+fileid+"\' name=\'"+fieldname+"[]\' value=\'\'>"
                                    +"<input type=\'hidden\' name=\'image_"+fieldname+""+fileid+"\' value=\'\'  />"
                                    +"<a id=\'data_lightbox_"+fieldname+""+fileid+"\' href=\'/Public/images/uploading.gif\' data-lightbox=\'roadtrip\'><img class=\'img-responsive\' src=\'/Public/images/uploading.gif\' style=\'margin:4px 7px 0px 7px;border:1px #ddd solid;display:block;"+image_style+"\' />"
                                    +"<a onclick=\'productfile_delete(\""+fieldname+"\",\""+fileid+"\");\' href=\'javascript:void(0);\' style=\'display:block; height:15px; width:15px; position:absolute; top:0px; right:2px;\'>"
                                    +"<img src=\'/Public/images/guanbi.jpg\' /></a><div id=\'progress_"+fieldname+""+fileid+"\' style=\'width:0px;float:left;margin:0px 7px;height:4px;background-color:rgba(18,18,224,0.5);text-align:center;\'></div></div>").insertBefore($("#"+fieldname+"pickfiles"));
                            $("#"+fieldname+"pickfiles").css("display","none");
                        }else{
                            $("#"+fieldname+"_file_container").append("<div id=\'plupload_img_"+fieldname+""+fileid+"\' style=\'"+image_div_style+"position: relative;float:left;margin:8px 3px;border:1px solid #cdcdcd;\'>"
                                    +"<input type=\'hidden\' id=\'"+fieldname+""+fileid+"\' name=\'"+fieldname+"[]\' value=\'\'>"
                                    +"<input type=\'hidden\' name=\'image_"+fieldname+""+fileid+"\' value=\'\'  />"
                                    +"<a id=\'data_lightbox_"+fieldname+""+fileid+"\' href=\'/Public/images/uploading.gif\' data-lightbox=\'roadtrip\'><img class=\'img-responsive\' src=\'/Public/images/uploading.gif\' style=\'margin:4px 7px 0px 7px;border:1px #ddd solid;display:block;"+image_style+"\' />"
                                    +"<a onclick=\'productfile_delete(\""+fieldname+"\",\""+fileid+"\");\' href=\'javascript:void(0);\' style=\'display:block; height:15px; width:15px; position:absolute; top:0px; right:2px;\'>"
                                    +"<img src=\'/Public/images/guanbi.jpg\' /></a><div id=\'progress_"+fieldname+""+fileid+"\' style=\'width:0px;float:left;margin:0px 7px;height:4px;background-color:rgba(18,18,224,0.5);text-align:center;\'></div></div>");
                        }

                    });
                    uploader.start();
                },
                UploadProgress:function(uploader,file){
                    var cur_width=width*file.percent/100;
                    $("#progress_"+fieldname+""+file.id).css("width",cur_width+"px");
                    $("#progress_"+fieldname+""+file.id).text(file.percent+"%");
                },
                FileUploaded:function(up, file, info){
                    eval( "var jsondata = " + info.response+";");
                    var err_msg=jsondata.error;
                    var orginalid=file.id;
                    var orginalname=file.name;
                    if(err_msg!=""){
                        alert("图片("+orginalname+")"+err_msg);
                        jQuery("#plupload_img_"+fieldname+orginalid).remove();
                        jQuery("#"+fieldname+"pickfiles").css("display","block");
                        jQuery("#"+fieldname).val("");
                    }else{
                        var fileid=jsondata.id;
                        var type=file.type;
                        var size=file.size;
                        var imgurl=decodeURIComponent(jsondata.src);
                        $("#"+fieldname+""+orginalid).val(imgurl);
                        $("#plupload_img_"+fieldname+""+orginalid).find("input[name^=\'image_\']").val(imgurl);
                        $("#plupload_img_"+fieldname+""+orginalid).find(".img-responsive").attr("src",imgurl);
                        $("#data_lightbox_"+fieldname+""+orginalid).attr("href",imgurl);
                        $("#plupload_img_"+fieldname+""+orginalid).find("div[id^=\'progress_\']").css("display","none");
                        $("#plupload_img_"+fieldname+""+orginalid).find("div[id^=\'progress_percent_\']").css("display","none");
                        if(multi_selection=="false")$("#"+fieldname+"pickfiles").css("display","none");
                    }
                },
                Error: function(up, err) {
                    alert("Error : " + err.message);
                }
            }
        });
        uploader.init();
    });
    function productfile_delete(fieldname,fileid){
        $("#plupload_img_"+fieldname+fileid).remove();
        $("#"+fieldname+"pickfiles").css("display","block");
        $("#"+fieldname).val("");
    }
    </script>
    ';
	}

	return $html;
}
function getButtonPlupLoadHtml($fieldname, $image_width, $image_height,$readonly, $multi_selection, $title,$fieldvalues=array())
{
	$timestamp   = time();
	$unique_salt = md5('unique_salt'.$timestamp);
	$html        = '';
	if ($multi_selection == 'false')
		$html .= '<div id="'.$fieldname.'_file_container" style="display:block;float:left;"></div>';
	if ($readonly == 'false')
	{
		$html .= '<div id="'.$fieldname.'pickfiles" style="display:block;position: relative;float:left;margin:2px 3px;border:1px solid #cdcdcd;">
            <button type="button" class="btn btn-green"><i class="fa fa-plus"></i></button>
        </div>';
	}
	if (!empty($fieldvalues) != "" && count($fieldvalues) >= 1 && $fieldvalues[0] != "" && @file_exists($_SERVER['DOCUMENT_ROOT'].$fieldvalues[0]))
	{
		$html .= '<div style="position:relative;">';
		foreach ($fieldvalues as $key => $fieldvalue)
		{
			if ($fieldvalue != "")
			{
				$recordid = $key;
				if ($image_width > 0 && $image_height > 0)
				{
					$html .= '<div id="plupload_img_'.$fieldname.$recordid.'" style="width:'.($image_width + 2).'px;height:'.($image_height + 2).'px;position: relative;float:left;border:1px solid #cdcdcd;">
                    <input id="'.$fieldname.$recordid.'" type="hidden" name="'.$fieldname.'[]" value="'.$fieldvalue.'">
                    <input type="hidden" name="image_'.$fieldname.$recordid.'" value="'.$fieldvalue.'">
                    <a style="display:block;width:100%;height:100%;" id="data_lightbox_'.$fieldname.$recordid.'"  href="'.$fieldvalue.'" data-lightbox="roadtrip"><img class="img-responsive" src="'.$fieldvalue.'" style="margin:1px 2px 0px 1px;border:1px #ddd solid;display:block;height:'.$image_width.'px;width:'.$image_height.'px;"></a>';
				}
				else
				{
					$html .= '<div id="plupload_img_'.$fieldname.$recordid.'" style="max-width:40px;position: relative;float:left;border:1px solid #cdcdcd;">
                    <input id="'.$fieldname.$recordid.'" type="hidden" name="'.$fieldname.'[]" value="'.$fieldvalue.'">
                    <input type="hidden" name="image_'.$fieldname.$recordid.'" value="'.$fieldvalue.'">
                    <a id="data_lightbox_'.$fieldname.$recordid.'"  href="'.$fieldvalue.'" data-lightbox="roadtrip"><img class="img-responsive" src="'.$fieldvalue.'" style="margin:1px 2px 0px 1px;border:1px #ddd solid;display:block;"></a>';
				}
				if ($readonly == 'false')
				{
					$html .= '<a style="width:12px;height:12px;position:absolute;top:1px;right:1px;" onclick="productfile_delete(\''.$fieldname.'\',\''.$recordid.'\');" href="javascript:void(0);" style="margin:1px 2px 0px 1px;border:1px #ddd solid;display:block;;">
                <img src="/Public/images/guanbi.jpg">
            </a>';
				}
				else
				{
					$html .= '<a style="width:12px;height:12px;position:absolute;top:1px;right:1px;" onclick="productfile_delete(\''.$fieldname.$recordid.'\');" href="javascript:void(0);" style="margin:1px 2px 0px 1px;border:1px #ddd solid;display:block;">
                <img src="/Public/images/guanbi.jpg">
            </a>';
				}
				$html.='</div>';
			}
		}
		$html .= '</div>';
	}
	if ($multi_selection == 'true')
		$html .= '<div id="'.$fieldname.'_file_container" style="display:block;"></div>';
	if ($readonly == 'false')
	{
		$html .= '<div id="'.$fieldname.'filelist" style="display:block;float:left;">Your browser doesn\'t have Flash, Silverlight or HTML5 support.</div>
    <style>.moxie-shim,.moxie-shim-html5{display:none;}</style>
    <script type="text/javascript" >
    $(document).ready(function(){
        var fieldname="'.$fieldname.'";
        var multi_selection="'.$multi_selection.'";
        if(multi_selection!=""){
            if(multi_selection=="false")multi_selection_value=false;
            if(multi_selection=="true")multi_selection_value=true;
        }else{
            multi_selection_value=true;
        }
        var width=parseInt('.$image_width.',10);
        var height=parseInt('.$image_height.',10);
        var browse_button=fieldname+"pickfiles";
        if(width>0 && height>0){
            var resize_parameter="{width:"+width+",height:"+height+",quality: 90}";
            var image_style="width:"+width+"px;height:"+height+"px;";
            var image_div_style="width:"+(width+4)+"px;height:"+(height+2)+"px;";
        }
        if(width>0 && height==0){
            var resize_parameter="{width:"+width+",quality: 90}";
            var image_style="width:"+width+"px;";
            var image_div_style="width:"+(width+4)+"px;";
        }
        if(width==0 && height>0){
            var resize_parameter="{height:"+height+",quality: 90}";
            var image_style="height:"+height+"px;";
            var image_div_style="height:"+(height+2)+"px;";
        }
        if(width==0 && height==0){
            var resize_parameter="{quality: 90}";
            var image_style="max-width:626px;";
            var image_div_style="max-width:640px;";
        }
        var uploader = new plupload.Uploader({
            runtimes : "html5,flash,silverlight,html4",
            browse_button : browse_button,
            file_data_name: "Filedata",
            container: document.getElementById(fieldname+"_file_container"),
            multi_selection:multi_selection_value,
            url : "/registerUpload.php?m="+ Math.random(),

            resize: resize_parameter,
            filters : {
                max_file_size : "50mb",
                mime_types: [
                    {title : "Image files", extensions : "jpg,gif,png"}
                ]
            },
            init: {
                PostInit: function() {
                    $("#"+fieldname+"filelist").html("") ;
                },
                FilesAdded: function(up, files) {
                    plupload.each(files, function(file) {
                        var filename=file.name;
                        var filesize=file.size;
                        var fileid=file.id;
                        var filesrc=file.src;
                        if(multi_selection=="false"){
                            $("<div id=\'plupload_img_"+fieldname+""+fileid+"\' style=\'"+image_div_style+"position: relative;float:left;border:1px solid #cdcdcd;\'>"
                                    +"<input type=\'hidden\' id=\'"+fieldname+""+fileid+"\' name=\'"+fieldname+"[]\' value=\'\'>"
                                    +"<input type=\'hidden\' name=\'image_"+fieldname+""+fileid+"\' value=\'\'  />"
                                    +"<a id=\'data_lightbox_"+fieldname+""+fileid+"\' href=\'/Public/images/uploading.gif\' data-lightbox=\'roadtrip\'><img class=\'img-responsive\' src=\'/Public/images/uploading.gif\' style=\'margin:1px 2px 0px 1px;border:1px #ddd solid;display:block;"+image_style+"\' />"
                                    +"<a onclick=\'productfile_delete(\""+fieldname+"\",\""+fileid+"\");\' href=\'javascript:void(0);\' style=\'display:block; height:15px; width:15px; position:absolute; top:0px; right:2px;\'>"
                                    +"<img src=\'/Public/images/guanbi.jpg\' /></a><div id=\'progress_"+fieldname+""+fileid+"\' style=\'width:0px;float:left;margin:0px 7px;height:4px;background-color:rgba(18,18,224,0.5);text-align:center;\'></div></div>").insertBefore($("#"+fieldname+"pickfiles"));
                            $("#"+fieldname+"pickfiles").css("display","none");
                        }else{
                            $("#"+fieldname+"_file_container").append("<div id=\'plupload_img_"+fieldname+""+fileid+"\' style=\'"+image_div_style+"position: relative;float:left;border:1px solid #cdcdcd;\'>"
                                    +"<input type=\'hidden\' id=\'"+fieldname+""+fileid+"\' name=\'"+fieldname+"[]\' value=\'\'>"
                                    +"<input type=\'hidden\' name=\'image_"+fieldname+""+fileid+"\' value=\'\'  />"
                                    +"<a id=\'data_lightbox_"+fieldname+""+fileid+"\' href=\'/Public/images/uploading.gif\' data-lightbox=\'roadtrip\'><img class=\'img-responsive\' src=\'/Public/images/uploading.gif\' style=\'margin:1px 2px 0px 1px;border:1px #ddd solid;display:block;"+image_style+"\' />"
                                    +"<a onclick=\'productfile_delete(\""+fieldname+"\",\""+fileid+"\");\' href=\'javascript:void(0);\' style=\'display:block; height:15px; width:15px; position:absolute; top:0px; right:2px;\'>"
                                    +"<img src=\'/Public/images/guanbi.jpg\' /></a><div id=\'progress_"+fieldname+""+fileid+"\' style=\'width:0px;float:left;margin:0px 7px;height:4px;background-color:rgba(18,18,224,0.5);text-align:center;\'></div></div>");
                        }

                    });
                    uploader.start();
                },
                UploadProgress:function(uploader,file){
                    var cur_width=width*file.percent/100;
                    $("#progress_"+fieldname+""+file.id).css("width",cur_width+"px");
                    $("#progress_"+fieldname+""+file.id).text(file.percent+"%");
                },
                FileUploaded:function(up, file, info){
                    eval( "var jsondata = " + info.response+";");
                    var err_msg=jsondata.error;
                    var orginalid=file.id;
                    var orginalname=file.name;
                    if(err_msg!=""){
                        alert("图片("+orginalname+")"+err_msg);
                        jQuery("#plupload_img_"+fieldname+orginalid).remove();
                        jQuery("#"+fieldname+"pickfiles").css("display","block");
                        jQuery("#"+fieldname).val("");
                    }else{
                        var fileid=jsondata.id;
                        var type=file.type;
                        var size=file.size;
                        var imgurl=decodeURIComponent(jsondata.src);
                        $("#"+fieldname+""+orginalid).val(imgurl);
                        $("#plupload_img_"+fieldname+""+orginalid).find("input[name^=\'image_\']").val(imgurl);
                        $("#plupload_img_"+fieldname+""+orginalid).find(".img-responsive").attr("src",imgurl);
                        $("#data_lightbox_"+fieldname+""+orginalid).attr("href",imgurl);
                        $("#plupload_img_"+fieldname+""+orginalid).find("div[id^=\'progress_\']").css("display","none");
                        $("#plupload_img_"+fieldname+""+orginalid).find("div[id^=\'progress_percent_\']").css("display","none");
                        if(multi_selection=="false")$("#"+fieldname+"pickfiles").css("display","none");
                    }
                },
                Error: function(up, err) {
                    alert("Error : " + err.message);
                }
            }
        });
        uploader.init();
    });
    function productfile_delete(fieldname,fileid){
        $("#plupload_img_"+fieldname+fileid).remove();
        $("#"+fieldname+"pickfiles").css("display","block");
        $("#"+fieldname).val("");
    }
    </script>
    ';
	}

	return $html;
}

function getCropperLoadHtml($currentModule, $fieldname, $fieldvalue, $div_width, $div_height, $image_width, $image_height, $readonly, $required = false)
{
$html = '<link href="/Public/css/cropper.min.css" rel="stylesheet">
		<link href="/Public/css/cropper.upload.css" rel="stylesheet">  
		<div id="'.$fieldname.'_crop_avatar" style="position: relative;">';
	if ($readonly == 'true')
	{
		if (isset($fieldvalue) && $fieldvalue != "")
		{
			$html .= '<div class="avatar-view form-control"  style="width:'.($div_width+11).'px;height:'.($div_height+11).'px;">
				    	<a id="data_lightbox_'.$fieldname.'" href="'.$fieldvalue.'" data-lightbox="roadtrip"> <img class="avatar-image"  style="width:'.$div_width.'px;height:'.$div_height.'px;" src="'.$fieldvalue.'"></a>
					</div></div>';
		}
		else
		{
			$html .= '<div class="avatar-view form-control" style="width:'.($div_width+11).'px;height:'.($div_height+11).'px;" >
				    	 <img class="avatar-image"  style="width:'.$div_width.'px;height:'.$div_height.'px;" src="/Public/images/noimage.jpg">
					</div></div>';
		} 
	}
	else
	{
		$html .= '<script language="javascript" type="text/javascript">
					$.ajaxSetup({cache: true });  
				</script> 
				<script src="/Public/js/cropper.min.js"></script>
				<script src="/Public/js/cropper.upload.js"></script>
				<script language="javascript" type="text/javascript">
					$.ajaxSetup({ cache: false });  
				</script>';
		if (isset($fieldvalue) && $fieldvalue != "")
		{
			$html .= '<div class="avatar-view form-control '.(($required)?"required":"").'" style="width:'.($div_width+11).'px;height:'.($div_height+11).'px;" >
		    	 <a data-on-load="'.$fieldname.'_upload_dialog_onLoad" data-toggle="dialog" data-id="uploaddialog" data-options="{mask:true,resizable:false,drawable:false,maxable:false,minable:false,width:860,height:600}" data-target="#'.$currentModule.'_upload_dialog_target" data-title="图片上传">  
					 <img class="avatar-image" style="width:'.$div_width.'px;height:'.$div_height.'px;" src="'.$fieldvalue.'">
				</a>
				<a class="avatar-close-image" id="close_btn"  onclick="close_btn_upload_dialog(this);" href="javascript:void(0);"><img src="/Public/images/guanbi.jpg"></a>
			</div>
			<input type="hidden" value="'.$fieldvalue.'" name="'.$fieldname.'" id="'.$fieldname.'" '.(($required)?'data-rule="required;" data-msg-required="请上传一张图片"':"").' >
			';
		}
		else
		{
			$html .= '<div class="avatar-view form-control '.(($required)?"required":"").'" style="width:'.($div_width+11).'px;height:'.($div_height+11).'px;" >
		    	 <a data-on-load="'.$fieldname.'_upload_dialog_onLoad" data-toggle="dialog" data-id="uploaddialog" data-options="{mask:true,resizable:false,drawable:false,maxable:false,minable:false,width:860,height:600}" data-target="#'.$currentModule.'_upload_dialog_target" data-title="图片上传">  
					 <img class="avatar-image" style="width:'.$div_width.'px;height:'.$div_height.'px;" src="/Public/images/uploadimg.png">
				</a>
				<a class="avatar-close-image" id="close_btn" style="display:none;" onclick="close_btn_upload_dialog(this);" href="javascript:void(0);"><img src="/Public/images/guanbi.jpg"></a>
			</div>
			<input type="hidden" value="" name="'.$fieldname.'" id="'.$fieldname.'" '.(($required)?'data-rule="required;" data-msg-required="请上传一张图片"':"").' >
		';
		} 
		$html .= '</div>';  
		$html .= '<script type="text/javascript"  defer="defer">  
		function close_btn_upload_dialog(obj) 
		{ 
			$(obj).css("display","none");
			$(obj).parent().parent().find("input").val("");
			$(obj).parent().parent().find(".avatar-image").attr("src", "/Public/images/uploadimg.png"); 
		}  
		function '.$fieldname.'_upload_dialog_onLoad($dialog) 
		{  
			setTimeout(function(){  $.InitCropAvatar("'.$currentModule.'","'.$fieldname.'",'.$image_width.','.$image_height.');  } ,100);
		} 
		</script>';
	}
	
	return $html;
}

function getMyBlocks($module, $disp_view, $mode, $col_fields = '', $info_type = '')
{
	$tabid        = getTabid($module);
	$block_detail = Array ();
	$getBlockinfo = "";
	$blocks       = XN_Query::create('Content')->tag('Blocks')
		->filter('type', 'eic', 'blocks')
		->filter('my.tabid', '=', $tabid)
		->filter('my.visible', '=', '0')
		->order('my.sequence', XN_Order::ASC_NUMBER)
		->execute();
	$prev_header  = "";
	$blockid_list = array ();
	$blockcolumns = array ();
	$block_label =array();
	foreach ($blocks as $block_info)
	{
		$blockid = $block_info->my->blockid;
		array_push($blockid_list, $blockid);
		$blocklabel               = $block_info->my->blocklabel;
		$block_label[$blockid]    = $blocklabel;
		$sLabelVal                = getTranslatedString($blocklabel, $module);
		$aBlockStatus[$sLabelVal] = $block_info->my->display_status;
		$columns                  = $block_info->my->columns;
		if (isset($columns))
		{
			$blockcolumns[$blockid] = $columns;
		}
		else
		{
			$blockcolumns[$blockid] = "2";
		}
	}

	global $global_user_privileges;
	$is_admin                = $global_user_privileges["is_admin"];
	$profileGlobalPermission = $global_user_privileges['profileGlobalPermission'];
	global $global_session; 
	$tabdata  = $global_session['tabdata']; 
	$all_tabs_array          = $tabdata['all_tabs_array'];
	$all_entity_tabs_array   = $tabdata['all_entity_tabs_array'];

	if ($is_admin == false && in_array($module, array_values($all_tabs_array)) && !in_array($module, array_values($all_entity_tabs_array)))
	{
		$is_admin = true;
	}

	if ($info_type != '')
	{
		if ($is_admin == true || $profileGlobalPermission[1] == 0 || $profileGlobalPermission[2] == 0 || $module == 'Users' || $module == "Emails")
		{
			$fields_query = XN_Query::create('Content')->tag('Fields')
				->filter('type', 'eic', 'fields')
				->filter('my.tabid', '=', $tabid)
				->filter('my.block', 'in', $blockid_list)
				->filter('my.info_type', '=', $info_type)
				->filter('my.presence', 'in', array ('0', '2'))
				->begin(0)->end(-1)
				->order('my.sequence', XN_Order::ASC_NUMBER);
			if ($mode == 'edit')
			{
				$fields_query->filter('my.displaytype', 'in', array ('1', '6'));
			}
			else
			{
				$fields_query->filter('my.displaytype', 'in', array ('1', '6', '4'));
			}
		}
		else
		{
			$profileList    = getCurrentUserProfileList();
			$profile2fields = XN_Query::create('Content')->tag('Profile2fields')
				->filter('type', 'eic', 'Profile2fields')
				->filter('my.profileid', 'in', $profileList)
				->filter('my.tabid', '=', $tabid)
				->filter('my.visible ', '!=', '0')
				->begin(0)->end(-1)
				->execute();
			$fieldlist      = array ();
			foreach ($profile2fields as $profile2field_info)
			{
				$fieldlist[] = $profile2field_info->my->fieldname;
			}
			if (count($fieldlist) == 0)
			{
				$fields_query = XN_Query::create('Content')->tag('Fields')
					->filter('type', 'eic', 'fields')
					->filter('my.tabid', '=', $tabid)
					->filter('my.block', 'in', $blockid_list)
					->filter('my.info_type', '=', $info_type)
					->filter('my.presence', 'in', array ('0', '2'))
					->begin(0)->end(-1)
					->order('my.sequence', XN_Order::ASC_NUMBER);
				if ($mode == 'edit')
				{
					$fields_query->filter('my.displaytype', 'in', array ('1', '6'));
				}
				else
				{
					$fields_query->filter('my.displaytype', 'in', array ('1', '6', '4'));
				}
			}
			else
			{
				$fields_query = XN_Query::create('Content')->tag('Fields')
					->filter('type', 'eic', 'fields')
					->filter('my.tabid', '=', $tabid)
					->filter('my.block', 'in', $blockid_list)
					->filter('my.info_type', '=', $info_type)
					->filter('my.presence', 'in', array ('0', '2'))
					->filter('my.fieldname', '!in', $fieldlist)
					->begin(0)->end(-1)
					->order('my.sequence', XN_Order::ASC_NUMBER);
				if ($mode == 'edit')
				{
					$fields_query->filter('my.displaytype', 'in', array ('1', '6'));
				}
				else
				{
					$fields_query->filter('my.displaytype', 'in', array ('1', '6', '4'));
				}
			}
		}
	}
	else
	{
		if ($is_admin == true || $profileGlobalPermission[1] == 0 || $profileGlobalPermission[2] == 0 || $module == 'Users' || $module == "Emails")
		{
			$fields_query = XN_Query::create('Content')->tag('Fields')
				->filter('type', 'eic', 'fields')
				->filter('my.tabid', '=', $tabid)
				->filter('my.block', 'in', $blockid_list)
				->filter('my.presence', 'in', array ('0', '2'))
				->end(-1)
				->order('my.sequence', XN_Order::ASC_NUMBER);
			if ($mode == 'edit')
			{
				$fields_query->filter('my.displaytype', 'in', array ('1', '6'));
			}
			else
			{
				$fields_query->filter('my.displaytype', 'in', array ('1', '6', '4'));
			}
		}
		else
		{
			$profileList    = getCurrentUserProfileList();
			$profile2fields = XN_Query::create('Content')->tag('Profile2fields')
				->filter('type', 'eic', 'Profile2fields')
				->filter('my.profileid', 'in', $profileList)
				->filter('my.tabid', '=', $tabid)
				->filter('my.visible ', '!=', '0')
				->begin(0)->end(-1)
				->execute();
			$fieldlist      = array ();
			foreach ($profile2fields as $profile2field_info)
			{
				$fieldlist[] = $profile2field_info->my->fieldname;
			}
			if (count($fieldlist) == 0)
			{
				$fields_query = XN_Query::create('Content')->tag('Fields')
					->filter('type', 'eic', 'fields')
					->filter('my.tabid', '=', $tabid)
					->filter('my.block', 'in', $blockid_list)
					->filter('my.presence', 'in', array ('0', '2'))
					->end(-1)
					->order('my.sequence', XN_Order::ASC_NUMBER);
				if ($mode == 'edit')
				{
					$fields_query->filter('my.displaytype', 'in', array ('1', '6'));
				}
				else
				{
					$fields_query->filter('my.displaytype', 'in', array ('1', '6', '4'));
				}
			}
			else
			{
				$fields_query = XN_Query::create('Content')->tag('Fields')
					->filter('type', 'eic', 'fields')
					->filter('my.tabid', '=', $tabid)
					->filter('my.block', 'in', $blockid_list)
					->filter('my.presence', 'in', array ('0', '2'))
					->filter('my.fieldname', '!in', $fieldlist)
					->end(-1)
					->order('my.sequence', XN_Order::ASC_NUMBER);
				if ($mode == 'edit')
				{
					$fields_query->filter('my.displaytype', 'in', array ('1', '6'));
				}
				else
				{
					$fields_query->filter('my.displaytype', 'in', array ('1', '6', '4'));
				}
			}
		}
	}
	$fields_result = $fields_query->execute();
	$getBlockInfo  = getMyBlockInformation($module, $fields_result, $col_fields, $block_label,$blockcolumns);

	return $getBlockInfo;
}
function getMyBlockInformation($module, $result, $col_fields,$block_label,$blockcolumns)
{
	$editview_arr = Array ();
	$vt_tab       = 1;
	global $editview_hidden_fields;
	foreach ($result as $field_info)
	{
		$uitype        = $field_info->my->uitype;
		$fieldname     = $field_info->my->fieldname;

		if (isset($editview_hidden_fields) && in_array($fieldname,$editview_hidden_fields))
		{
			continue;
		}
		$fieldlabel    = $field_info->my->fieldlabel;
		$block         = $field_info->my->block;
		$maxlength     = $field_info->my->maximumlength;
		$generatedtype = $field_info->my->generatedtype;
		$typeofdata    = $field_info->my->typeofdata;
		$deputy_column = $field_info->my->deputy_column;
		$merge_column  = $field_info->my->merge_column;
		$show_title    = $field_info->my->show_title;
		$readonly      = $field_info->my->readonly;
		$unit          = getTranslatedString($field_info->my->unit);
		$editwidth     = $field_info->my->editwidth;
		$picklist      = $field_info->my->picklist;
		$multiselect   = $field_info->my->multiselect;
		if (!isset($multiselect) || $multiselect == '')
		{
			$multiselect = '0';
		}
		$defaultvalue           = $field_info->my->defaultvalue;
		$remotevalidation       = $field_info->my->remotevalidation;
		$relation               = $field_info->my->relation;
		$custfld                = getOutputHtml($uitype, $fieldname, $fieldlabel, $col_fields, $module, $typeofdata, $picklist,$relation);
		$custfld[]              = array ($deputy_column);
		$custfld[]              = array ($merge_column);
		$custfld[]              = array ($show_title);
		$custfld[]              = array ($readonly);
		$custfld[]              = array ($unit);
		$custfld[]              = array ($editwidth);
		$custfld[]              = array ($vt_tab);
		$custfld[]              = array ($maxlength);
		$custfld[]              = array ($multiselect);
		$custfld[]              = array ($defaultvalue);
		$custfld[]              = array ($remotevalidation);
		$custfld[]              = array ($relation);
		$editview_arr[$block][] = $custfld;
		$vt_tab++;
	}
	return array(
		"col_fields"=>$col_fields,
		"editview_arr"=>$editview_arr,
		"block_label"=>$block_label,
		"blockcolumns"=>$blockcolumns
	);
}
function getMyViewInformation($module, $col_fields, $editview_arr,$block_label,$blockcolumns)
{
	$optionalapprovals = array ();
	global $global_session; 
	$tabdata  = $global_session['tabdata']; 
	$optionalapprovals = $tabdata['optionalapprovals'];
	 
	$tabid = getTabid($module);
	if (in_array($tabid, array_keys($optionalapprovals)))
	{
		if ($optionalapprovals[$tabid]['required'] == '1')
		{
			$custfld = getOutputHtml('225', 'optionalapproval', $optionalapprovals[$tabid]['label'], $col_fields, $module, 'V~M');
		}
		else
		{
			$custfld = getOutputHtml('225', 'optionalapproval', $optionalapprovals[$tabid]['label'], $col_fields, $module, 'V~O');
		}
		$custfld[] = array ('0');
		$custfld[] = array ('0');
		$custfld[] = array ('1');
		if ($optionalapprovals[$tabid]['readonly'] == '1')
		{
			$custfld[] = array ('1');
		}
		else
		{
			$custfld[] = array ('0');
		}
		$blocks    = array_keys($editview_arr);
		$block     = $blocks[0];
		$blockdata = $editview_arr[$block];
		$endfld    = end($blockdata);
		if ($endfld[6][0] == '1')
		{
			array_pop($blockdata);
			$blockdata[]          = $custfld;
			$blockdata[]          = $endfld;
			$editview_arr[$block] = $blockdata;
		}
		else
		{
			$editview_arr[$block][] = $custfld;
		}
	}
	foreach ($editview_arr as $blockid => $editview_value)
	{
		$blockcolumn   = $blockcolumns[$blockid];
		$editview_data = Array ();
		$pos           = 0;
		foreach ($editview_value as $custfld)
		{
			$deputy_column = $custfld[5][0];
			$merge_column  = $custfld[6][0];
			if ($deputy_column == "1")
			{
				$deputy_pos                 = $pos - 1;
				$newcustfld                 = $editview_data[$deputy_pos];
				$newcustfld[200][]          = $custfld;
				$editview_data[$deputy_pos] = $newcustfld;
			}
			else
			{
				$editview_data[$pos] = $custfld;
				$pos++;
			}
		}
		$pos               = 0;
		$row               = 0;
		$new_editview_data = array ();
		for ($i = 0; $i < count($editview_data); $i++)
		{
			$custfld      = $editview_data[$i];
			$merge_column = $custfld[6][0];
			if ($merge_column == "1")
			{
				if ($pos == 0)
				{
					$new_editview_data[$row] = array (0 => $custfld);
					$row++;
				}
				else
				{
					$row++;
					$new_editview_data[$row] = array (0 => $custfld);
					$row++;
				}
				$pos = 0;
			}
			elseif ($merge_column == "2")
			{
				if ($pos == 0)
				{
					$new_editview_data[$row] = array (0 => $custfld);
					$pos                     = 1;
				}
				else
				{
					$row++;
					$new_editview_data[$row] = array (0 => $custfld);
					$pos                     = 1;
				}
			}
			else
			{
				$cblockcolumn = $blockcolumn - 1;
				if ($pos == 0)
				{
					$new_editview_data[$row] = array (0 => $custfld);
					$pos++;
				}
				elseif ($pos >= $cblockcolumn)
				{
					$pos++;
					$temp                    = $new_editview_data[$row];
					$temp[$pos]              = $custfld;
					$new_editview_data[$row] = $temp;
					$row++;
					$pos = 0;
				}
				else
				{
					$temp       = $new_editview_data[$row];
					$temp[$pos] = $custfld;
					$pos++;
					$new_editview_data[$row] = $temp;
				}
				if($pos > 0 && $cblockcolumn == 0){
					$row ++;
				}
			}
		}
		$editview_arr[$blockid] = $new_editview_data;
	}
	$returndata = array ();
	foreach ($block_label as $blockid => $label)
	{
		$blockcolumn        = $blockcolumns[$blockid];
		$returndata[$label] = array ($blockcolumn, $editview_arr[$blockid]);
	}

	return $returndata;
}
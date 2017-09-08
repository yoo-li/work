<?php
	require_once('include/utils/ListViewUtils.php');
	require_once('include/utils/EditViewUtils.php');
	require_once('include/utils/CommonUtils.php');
	require_once('include/CRMEntity.php');

	/** This function retrieves an application language file and returns the array of strings included in the $app_list_strings var.
	 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
	 * All Rights Reserved.
	 * Contributor(s): ______________________________________..
	 * If you are using the current language, do not call this function unless you are loading it for the first time */

	function return_app_list_strings_language($language)
	{

		global $app_list_strings, $default_language, $translation_string_prefix;
		$temp_app_list_strings = $app_list_strings;
		$language_used         = $language;

		@include("include/language/$language.lang.php");
		if (!isset($app_list_strings))
		{
			require("include/language/$default_language.lang.php");
			$language_used = $default_language;
		}

		if (!isset($app_list_strings))
		{
			return null;
		}

		$return_value     = $app_list_strings;
		$app_list_strings = $temp_app_list_strings;

		return $return_value;
	}

	/**
	 * Retrieve the app_currency_strings for the required language.
	 */
	function return_app_currency_strings_language($language)
	{

		global $app_currency_strings, $default_language, $translation_string_prefix;
		// Backup the value first
		$temp_app_currency_strings = $app_currency_strings;
		@include("include/language/$language.lang.php");
		if (!isset($app_currency_strings))
		{
			require("include/language/$default_language.lang.php");
			$language_used = $default_language;
		}
		if (!isset($app_currency_strings))
		{
			return null;
		}
		$return_value = $app_currency_strings;

		// Restore the value back
		$app_currency_strings = $temp_app_currency_strings;

		return $return_value;
	}

	/** This function retrieves an application language file and returns the array of strings included.
	 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
	 * All Rights Reserved.
	 * Contributor(s): ______________________________________..
	 * If you are using the current language, do not call this function unless you are loading it for the first time */
	if (!function_exists('return_application_language'))
	{
		function return_application_language($language)
		{
			global $app_strings, $default_language, $translation_string_prefix;
			$temp_app_strings = $app_strings;
			$language_used    = $language;
			checkFileAccess("include/language/$language.lang.php");
			@include("include/language/$language.lang.php");
			if (!isset($app_strings))
			{
				require("include/language/$default_language.lang.php");
				$language_used = $default_language;
			}

			if (!isset($app_strings))
			{
				return null;
			}

			// If we are in debug mode for translating, turn on the prefix now!
			if ($translation_string_prefix)
			{
				foreach ($app_strings as $entry_key => $entry_value)
				{
					$app_strings[$entry_key] = $language_used.' '.$entry_value;
				}
			}

			$return_value = $app_strings;
			/*
			 $app_strings = $temp_app_strings;

			*/
			return $return_value;
		}
	}

	/** This function retrieves a module's language file and returns the array of strings included.
	 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
	 * All Rights Reserved.
	 * Contributor(s): ______________________________________..
	 * If you are in the current module, do not call this function unless you are loading it for the first time */
	if (!function_exists('return_module_language'))
	{
		function return_module_language($language, $module)
		{
			global $mod_strings, $default_language, $currentModule, $translation_string_prefix;
			static $cachedModuleStrings = array ();

			if (!empty($cachedModuleStrings[$module]))
			{
				return $cachedModuleStrings[$module];
			}

			$temp_mod_strings = $mod_strings;
			$language_used    = $language;

			@include("modules/$module/language/$language.lang.php");
			if (!isset($mod_strings))
			{
				if ($default_language == 'en_us')
				{
					if (@file_exists("modules/$module/language/$default_language.lang.php"))
						require("modules/$module/language/$default_language.lang.php");
					$language_used = $default_language;
				}
				else
				{
					@include("modules/$module/language/$default_language.lang.php");
					if (!isset($mod_strings))
					{
						if (@file_exists("modules/$module/language/en_us.lang.php"))
							require("modules/$module/language/en_us.lang.php");
						$language_used = 'en_us';
					}
					else
					{
						$language_used = $default_language;
					}
				}
			}

			if (!isset($mod_strings))
			{
				return null;
			}

			// If we are in debug mode for translating, turn on the prefix now!
			if ($translation_string_prefix)
			{
				foreach ($mod_strings as $entry_key => $entry_value)
				{
					$mod_strings[$entry_key] = $language_used.' '.$entry_value;
				}
			}

			$return_value = $mod_strings;
			$mod_strings  = $temp_mod_strings;

			$cachedModuleStrings[$module] = $return_value;
			return $return_value;
		}

	}
	/*This function returns the mod_strings for the current language and the specified module
	*/

	function return_specified_module_language($language, $module)
	{
		global $default_language, $translation_string_prefix;

		@include("modules/$module/language/$language.lang.php");
		if (!isset($mod_strings))
		{
			require("modules/$module/language/$default_language.lang.php");
			$language_used = $default_language;
		}

		if (!isset($mod_strings))
		{
			return null;
		}

		$return_value = $mod_strings;

		return $return_value;
	}

	/** This function retrieves an application language file and returns the array of strings included in the $mod_list_strings var.
	 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
	 * All Rights Reserved.
	 * Contributor(s): ______________________________________..
	 * If you are using the current language, do not call this function unless you are loading it for the first time */
	function return_mod_list_strings_language($language, $module)
	{
		global $mod_list_strings, $default_language, $currentModule, $translation_string_prefix;

		$language_used         = $language;
		$temp_mod_list_strings = $mod_list_strings;

		if ($currentModule == $module && isset($mod_list_strings) && $mod_list_strings != null)
		{
			return $mod_list_strings;
		}

		@include("modules/$module/language/$language.lang.php");

		if (!isset($mod_list_strings))
		{
			return null;
		}

		$return_value     = $mod_list_strings;
		$mod_list_strings = $temp_mod_list_strings;

		return $return_value;
	}

	$toHtml = array (
		'"'    => '&quot;',
		'<'    => '&lt;',
		'>'    => '&gt;',
		'& '   => '&amp; ',
		"'"    => '&#039;',
		''     => '\r',
		'\r\n' => '\n',

	);

	/** Function to convert the given string to html
	 * @param $string -- string:: Type string
	 * @param $ecnode -- boolean:: Type boolean
	 * @returns $string -- string:: Type string
	 */
	function to_html($string)
	{
		global $default_charset;
		$action = $_REQUEST['action'];
		$search = $_REQUEST['search'];

		$doconvert = false;

		if ($_REQUEST['module'] != 'Settings' && $_REQUEST['file'] != 'ListView' && $_REQUEST['module'] != 'Portal' && $_REQUEST['module'] != "Reports")// && $_REQUEST['module'] != 'Emails')
			$ajax_action = $_REQUEST['module'].'Ajax';

		if (is_string($string))
		{
			if ($action != 'CustomView' && $action != 'Export' && $action != $ajax_action && $action != 'LeadConvertToEntities' && $action != 'CreatePDF' && $action != 'ConvertAsFAQ' && $_REQUEST['module'] != 'Dashboard' && $action != 'CreateSOPDF' && $action != 'SendPDFMail' && (!isset($_REQUEST['submode'])))
			{
				$doconvert = true;
			}
			else if ($search == true)
			{
				// Fix for tickets #4647, #4648. Conversion required in case of search results also.
				$doconvert = true;
			}
			if ($doconvert == true)
			{
				if (strtolower($default_charset) == 'utf-8')
					$string = htmlentities($string, ENT_QUOTES, $default_charset);
				else
					$string = preg_replace(array ('/</', '/>/', '/"/'), array ('&lt;', '&gt;', '&quot;'), $string);
			}
		}

		//
		return $string;
	}

	/** Function to get the tablabel for a given id
	 * @param $tabid -- tab id:: Type integer
	 * @returns $string -- string:: Type string
	 */

	function getTabname($tabid)
	{
		global $global_session; 
		$tabdata  = $global_session['tabdata']; 
		$all_tabs_array = $tabdata['all_tabs_array']; 
		return $all_tabs_array[$tabid];
		//return $tabname;

	}

	/** Function to get the tablabel for a given id
	 * @param $tabid -- tab id:: Type integer
	 * @returns $string -- string:: Type string
	 */

	function getTablabel($tabid)
	{
		global $global_session; 
		$tabdata  = $global_session['tabdata']; 
		$all_tablabels_array = $tabdata['all_tablabels_array'];  
		return $all_tablabels_array[$tabid]; 

	}

	/** Function to get the tab module name for a given id
	 * @param $tabid -- tab id:: Type integer
	 * @returns $string -- string:: Type string
	 */

	function getTabModuleName($tabid)
	{
		// Lookup information in cache first
		$tabname = VTCacheUtils::lookupModulename($tabid);
		if ($tabname === false || isset($tabname))
		{
			global $global_session; 
			$tabdata  = $global_session['tabdata']; 
			$all_tabs_array = $tabdata['all_tabs_array'];
			 
			$module = $all_tabs_array[$tabid];
			VTCacheUtils::updateTabidInfo($tabid, $module);
			return $module;
		}
		return $tabname;
	}

	/** Function to get column fields for a given module
	 * @param $module -- module:: Type string
	 * @returns $column_fld -- column field :: Type array
	 */

	function getColumnFields($module)
	{
		// Lookup in cache for information
		$cachedModuleFields = VTCacheUtils::lookupFieldInfo_Module($module);

		if ($cachedModuleFields === false)
		{
			$tabid = getTabid($module);
			// Let us pick up all the fields first so that we can cache information
			if (is_array($tabid))
			{
				$fields = XN_Query::create('Content')->tag('Fields')
								  ->filter('type', 'eic', 'fields')
								  ->filter('my.tabid', 'in', $tabid)
								  ->order('my.sequence', XN_Order::ASC_NUMBER)
								  ->end(-1)
								  ->execute();
			}
			else
			{
				$fields = XN_Query::create('Content')->tag('Fields')
								  ->filter('type', 'eic', 'fields')
								  ->filter('my.tabid', '=', $tabid)
								  ->end(-1)
								  ->order('my.sequence', XN_Order::ASC_NUMBER)
								  ->execute();
			}
			foreach ($fields as $field_info)
			{
				VTCacheUtils::updateFieldInfo(
					$field_info->my->tabid, $field_info->my->fieldname, $field_info->my->fieldid,
					$field_info->my->fieldlabel, $field_info->my->uitype, $field_info->my->typeofdata, $field_info->my->presence
				);
			}
			$optionalapprovals = array ();
			global $global_session; 
			$tabdata  = $global_session['tabdata']; 
			$optionalapprovals = $tabdata['optionalapprovals'];
			 
			if (count($optionalapprovals) && !empty($optionalapprovals))
			{
				if (in_array($tabid, array_keys($optionalapprovals)))
				{
					if ($optionalapprovals[$tabid]['required'] == '1')
					{
						VTCacheUtils::updateFieldInfo(
							$tabid, 'optionalapproval', '100000',
							$optionalapprovals[$tabid], '225', 'V~M', '2');
					}
					else
					{
						VTCacheUtils::updateFieldInfo(
							$tabid, 'optionalapproval', '100000',
							$optionalapprovals[$tabid]['label'], '225', 'V~O', '2');
					}
				}
			}
			// For consistency get information from cache
			$cachedModuleFields = VTCacheUtils::lookupFieldInfo_Module($module);
		}

//	if($module == 'Calendar') {
//		$cachedEventsFields = VTCacheUtils::lookupFieldInfo_Module('Events');
//		if($cachedModuleFields == false) $cachedModuleFields = $cachedEventsFields;
//		else $cachedModuleFields = array_merge($cachedModuleFields, $cachedEventsFields);
//	}

		$column_fld = array ();
		if ($cachedModuleFields)
		{
			foreach ($cachedModuleFields as $fieldinfo)
			{
				$column_fld[$fieldinfo['fieldname']] = '';
			}
		}
		return $column_fld;
	}

	/** Function to insert value to profile2fieldPermissions table
	 * @param $fld_module -- field module :: Type string
	 * @param $profileid  -- profileid :: Type integer
	 * @returns $return_data -- return_data :: Type string
	 */

//added by jeri

	function getProfile2FieldPermissionList($fld_module, $profileid)
	{
		static $_module_fieldpermission_cache = array ();

		if (!isset($_module_fieldpermission_cache[$fld_module]))
		{
			$_module_fieldpermission_cache[$fld_module] = array ();
		}

		// Lookup cache first
		$return_data = VTCacheUtils::lookupProfile2FieldPermissionList($fld_module, $profileid);

		if ($return_data === false)
		{

			$return_data = array ();

			$tabid = getTabid($fld_module);
			try
			{
				if ($profileid == '1')
				{
					$fields = XN_Query::create('Content')->tag('Fields')
									  ->filter('type', 'eic', 'fields')
									  ->filter('my.tabid', '=', $tabid)
									  ->order('my.sequence', XN_Order::ASC_NUMBER)
									  ->end(-1)
									  ->execute();
					foreach ($fields as $field_info)
					{
						$fieldid       = $field_info->my->fieldid;
						$return_data[] = array (
							$field_info->my->fieldlabel,
							0,
							$field_info->my->uitype,
							0,
							$fieldid,
							$field_info->my->displaytype,
							$field_info->my->typeofdata,
						);
					}
				}
				else
				{
					$profile2fields = XN_Query::create('Content')->tag('Profile2fields')
											  ->filter('type', 'eic', 'profile2fields')
											  ->filter('my.tabid', '=', $tabid)
											  ->end(-1);
					if (is_array($profileid))
						$profile2fields->filter('my.profileid', 'in', $profileid);
					else
						$profile2fields->filter('my.profileid', '=', $profileid);
					$p2f = $profile2fields->execute();

					$fields         = XN_Query::create('Content')->tag('Fields')
											  ->filter('type', 'eic', 'fields')
											  ->filter('my.tabid', '=', $tabid)
											  ->order('my.sequence', XN_Order::ASC_NUMBER)
											  ->end(-1)
											  ->execute();
					$profile_fields = array ();
					foreach ($fields as $field_info)
					{
						$fieldname = $field_info->my->fieldname;
						$fieldid   = $field_info->my->fieldid;
						foreach ($p2f as $profile2field_info)
						{
							if ($fieldname == $profile2field_info->my->fieldname)
							{
								$visible          = $profile2field_info->my->visible;
								$profile_fields[] = $fieldname;
								$return_data[]    = array (
									$field_info->my->fieldlabel,
									$visible,
									$field_info->my->uitype,
									$visible,
									$fieldid,
									$field_info->my->displaytype,
									$field_info->my->typeofdata,
								);
							}
						}
					}
					////
					foreach ($fields as $field_info)
					{
						$fieldname = $field_info->my->fieldname;
						$fieldid   = $field_info->my->fieldid;
						if (!in_array($fieldname, $profile_fields))
						{
							$return_data[] = array (
								$field_info->my->fieldlabel,
								'1',
								$field_info->my->uitype,
								'1',
								$fieldid,
								$field_info->my->displaytype,
								$field_info->my->typeofdata,
							);
						}
					}

				}
			}
			catch (XN_Exception $e)
			{

			}

			VTCacheUtils::updateProfile2FieldPermissionList($fld_module, $profileid, $return_data);
		}

		return $return_data;
	}

	/** Function to getProfile2allfieldsListinsert value to profile2fieldPermissions table
	 * @param $mod_array -- mod_array :: Type string
	 * @param $profileid -- profileid :: Type integer
	 * @returns $profilelist -- profilelist :: Type string
	 */

	function getProfile2AllFieldList($mod_array, $profileid)
	{
		$profilelist    = array ();
		global $global_session; 
		$tabdata  = $global_session['tabdata']; 
		$tab_info_array = $tabdata['tab_info_array'];
		$all_tabs_array = $tabdata['all_tabs_array'];
		$tabids         = array ();
		foreach ($mod_array as $fldmodule)
		{
			$tabids[] = $tab_info_array[$fldmodule];
		}
		$profile2field_infos = array ();
		$field_infos         = array ();
		$profile2fields      = XN_Query::create('Content')->tag('Profile2fields')
									   ->filter('type', 'eic', 'profile2fields')
									   ->end(-1);
		if (is_array($profileid))
			$profile2fields->filter('my.profileid', 'in', $profileid);
		else
			$profile2fields->filter('my.profileid', '=', $profileid);
		$p2f = $profile2fields->execute();
		foreach ($p2f as $profile2field_info)
		{
			$profile2field_infos[$profile2field_info->my->tabid][] = $profile2field_info;
		}

		$fields = XN_Query::create('Content')->tag('Fields')
						  ->filter('type', 'eic', 'fields')
						  ->order('my.sequence', XN_Order::ASC_NUMBER)
						  ->end(-1)
						  ->execute();
		foreach ($fields as $field_info)
		{
			$field_infos[$field_info->my->tabid][$field_info->my->fieldname] = $field_info;
		}

		//$profile2field_infos=array();
		foreach ($profile2field_infos as $tabid => $profile2field_tab_infos)
		{
			$return_data = array ();
			$module      = $all_tabs_array[$tabid];
			$fields      = $field_infos[$tabid];
			if ($profileid == '1')
			{
				$fields = $field_infos[$tabid];
				if (count($fields))
				{
					foreach ($fields as $field_info)
					{
						$fieldid       = $field_info->my->fieldid;
						$return_data[] = array (
							$field_info->my->fieldlabel,
							0,
							$field_info->my->uitype,
							0,
							$fieldid,
							$field_info->my->displaytype,
							$field_info->my->typeofdata,
						);
					}
				}
			}
			else
			{
				$profile_fields = array ();
				if (count($fields))
				{
					foreach ($fields as $field_info)
					{
						$fieldname = $field_info->my->fieldname;
						$fieldid   = $field_info->my->fieldid;
						foreach ($profile2field_tab_infos as $profile2field_info)
						{
							if ($fieldname == $profile2field_info->my->fieldname)
							{
								$visible          = $profile2field_info->my->visible;
								$profile_fields[] = $fieldname;
								$return_data[]    = array (
									$field_info->my->fieldlabel,
									$visible,
									$field_info->my->uitype,
									$visible,
									$fieldid,
									$field_info->my->displaytype,
									$field_info->my->typeofdata,
								);
							}
						}
					}
					////
					foreach ($fields as $field_info)
					{
						$fieldname = $field_info->my->fieldname;
						$fieldid   = $field_info->my->fieldid;
						if (!in_array($fieldname, $profile_fields))
						{
							$return_data[] = array (
								$field_info->my->fieldlabel,
								'1',
								$field_info->my->uitype,
								'1',
								$fieldid,
								$field_info->my->displaytype,
								$field_info->my->typeofdata,
							);
						}
					}
				}

			}
			$profilelist[$module] = $return_data;
		}
		/*
		for($i=0;$i<count($mod_array);$i++)
		{
			$profilelist[key($mod_array)]=getProfile2FieldPermissionList(key($mod_array), $profileid);
			next($mod_array);
		}
		*/
		return $profilelist;
	}

	/**
	 *simple HTML to UTF-8 conversion:
	 */
	function html_to_utf8($data)
	{
		return preg_replace("/\\&\\#([0-9]{3,10})\\;/e", '_html_to_utf8("\\1")', $data);
	}

	function _html_to_utf8($data)
	{
		if ($data > 127)
		{
			$i = 5;
			while (($i--) > 0)
			{
				if ($data != ($a = $data % ($p = pow(64, $i))))
				{
					$ret = chr(base_convert(str_pad(str_repeat(1, $i + 1), 8, "0"), 2, 10) + (($data - $a) / $p));
					for ($i; $i > 0; $i--)
						$ret .= chr(128 + ((($data % pow(64, $i)) - ($data % ($p = pow(64, $i - 1)))) / $p));
					break;
				}
			}
		}
		else
			$ret = "&#$data;";
		return $ret;
	}

	function getAllTabs_Picklists()
	{
		$config_inc_file = $_SERVER['DOCUMENT_ROOT'].'/modules/PickList/config.inc.php';
		if (@file_exists($config_inc_file))
		{
			include($config_inc_file);
		}
		else
		{
			$config_profile_picklist = array ();
		}

		$fields_query = XN_Query::create('Content')->tag('Fields')
								->filter('type', 'eic', 'fields')
								->filter('my.tabid', '!=', '29')
								->filter('my.presence', 'in', array ('0', '2'))
								->filter(XN_Filter::any(XN_Filter('my.uitype', 'in', array ('15', '33')), XN_Filter('my.fieldname', 'in', array_keys($config_picklist))))
								->end(-1)
								->order('my.tabid', XN_Order::ASC_NUMBER);
		$fields       = $fields_query->execute();
		$tabids       = array ();
		foreach ($fields as $field_info)
		{
			if (!in_array($field_info->my->tabid, $tabids))
			{
				$tabids[] = $field_info->my->tabid;
			}
		}

		$tabs_query = XN_Query::create('Content')->tag('Tabs')
							  ->filter('type', 'eic', 'tabs')
							  ->filter('my.isentitytype', '=', '1')
							  ->end(-1)
							  ->order('my.tabsequence', XN_Order::ASC_NUMBER);

		if (count($config_profile_picklist) > 0)
		{
			$tabs_query->filter(XN_Filter::any(XN_Filter('my.tabid', 'in', $tabids), XN_Filter('my.tabname', 'in', array_keys($config_profile_picklist))));
		}
		else
		{
			$tabs_query->filter('my.tabid', 'in', $tabids);
		}

		$tabs = $tabs_query->execute();

		$config_system_file = 'data/config.system.php';
		if (file_exists($config_system_file))
		{
			include($config_system_file);
		}
		else
		{
			$Config_Hidden_Tabs = array ();
		}

		$role_det = array ();
		$hrarray  = array ();
		foreach ($tabs as $tab_info)
		{
			if (!in_array($tab_info->my->tabname, $Config_Hidden_Tabs))
			{
				$parenttab_array          = array ();
				$parent_id                = 'tab'.$tab_info->my->tabid;
				$parenttabname            = $tab_info->my->tablabel;
				$parenttab_array['name']  = getTranslatedString($parenttabname, 'Settings');
				$parenttab_array['depth'] = '1';
				$child_ids                = '';
				$parent_array             = array ();
				foreach ($fields as $field_info)
				{
					if ($field_info->my->tabid == $tab_info->my->tabid)
					{
						$fieldlabel            = $field_info->my->fieldlabel;
						$fieldid               = 'field'.$field_info->my->fieldid;
						$field_array           = array ();
						$field_array['name']   = getTranslatedString($fieldlabel, 'Settings');
						$field_array['depth']  = '2';
						$field_array['ids']    = '';
						$field_array['linkto'] = 'index.php?module=PickList&amp;action=EditPickList&amp;parenttab=Settings&amp;record='.$field_info->my->fieldid;
						$role_det[$fieldid]    = $field_array;
						if ($child_ids == '')
						{
							$child_ids = $fieldid;
						}
						else
						{
							$child_ids = $child_ids.','.$fieldid;
						}
						$parent_array[$fieldid] = array ();
					}
				}
				$tabname = $tab_info->my->tabname;

				if (array_key_exists($tabname, $config_profile_picklist))
				{
					$profile_picklist = $config_profile_picklist[$tabname];

					$profile_fields_query = XN_Query::create('Content')->tag('Fields')
													->filter('type', 'eic', 'fields')
													->filter('my.tabid', '=', $tab_info->my->tabid)
													->filter('my.presence', 'in', array ('0', '2'))
													->end(-1)
													->filter('my.fieldname', 'in', $profile_picklist);

					$profile_fields = $profile_fields_query->execute();
					foreach ($profile_fields as $field_info)
					{
						$fieldlabel            = $field_info->my->fieldlabel;
						$fieldid               = 'field'.$field_info->my->fieldid;
						$field_array           = array ();
						$field_array['name']   = getTranslatedString($fieldlabel, 'Settings');
						$field_array['depth']  = '2';
						$field_array['ids']    = '';
						$field_array['linkto'] = 'index.php?module=PickList&amp;action=EditPickList&amp;parenttab=Settings&amp;record='.$field_info->my->fieldid;
						$role_det[$fieldid]    = $field_array;
						if ($child_ids == '')
						{
							$child_ids = $fieldid;
						}
						else
						{
							$child_ids = $child_ids.','.$fieldid;
						}
						$parent_array[$fieldid] = array ();
					}
				}
				$parenttab_array['ids'] = $child_ids;
				$role_det[$parent_id]   = $parenttab_array;
				$hrarray[$parent_id]    = $parent_array;
			}
		}
		$tabsout = '';

		$tabsout .= tree_indent($hrarray, $tabsout, $role_det);
		$tabsout = '<div style=" font-size: 12px;font-weight: bold;"><a href="/index.php?module=PickList&action=PickList&parenttab=Settings">'.getTranslatedString('LBL_PICKLIST_EDITOR', 'Settings').'</a></div>'.$tabsout;
		return $tabsout;
	}

//functions for settings page

	function getAllTabs()
	{
		$parentid = 1;
		$role_det = array ();
		$hrarray  = array ();
		// require('data/config.tabs.php');

		$config_system_file = 'data/config.system.php';
		if (file_exists($config_system_file))
		{
			include($config_system_file);
		}
		else
		{
			$Config_Hidden_Tabs = array ();
		}

		$parenttabs = XN_Query::create('Content')
							  ->filter('type', 'eic', 'parenttabs')
							  ->order('published', XN_Order::ASC)
							  ->execute();
		foreach ($parenttabs as $parenttab_info)
		{
			$parenttabname = $parenttab_info->my->parenttabname;
			if ($parenttabname == 'Settings')
				continue;
			$parenttab_array           = array ();
			$parent_id                 = 'parentid'.$parentid;
			$parenttab_array['name']   = getTranslatedString($parenttabname, 'Settings');
			$parenttab_array['depth']  = '1';
			$parenttab_array['linkto'] = 'index.php?module=Settings&amp;action=NewModuleManager&amp;parenttab=Settings&amp;formodule='.$parenttabname;
			$child_ids                 = '';
			$parent_array              = array ();
			$tabnames                  = $parenttab_info->my->tabname;

			if (is_array($tabnames))
			{
				$tabs = XN_Query::create('Content')
								->filter('type', 'eic', 'tabs')
								->filter('my.tabname', 'in', $tabnames)
								->filter('my.isentitytype', '=', '1')
								->end(-1)
								->order('my.tabsequence', XN_Order::ASC)
								->execute();
			}
			else
			{
				$tabs = XN_Query::create('Content')
								->filter('type', 'eic', 'tabs')
								->filter('my.tabname', '=', $tabnames)
								->filter('my.isentitytype', '=', '1')
								->order('my.tabsequence', XN_Order::ASC)
								->end(-1)
								->execute();
			}

			foreach ($tabs as $tab_info)
			{
				if (!in_array($tab_info->my->tabname, $Config_Hidden_Tabs))
				{
					$tablabel = $tab_info->my->tablabel;
					$tabname  = $tab_info->my->tabname;
					$presence = $tab_info->my->presence;
					$tabid    = $tab_info->my->tabid;
					if (($tabname != 'Users') && ($presence == '0' || $presence == '1'))
					{

						//$hassettings = file_exists ( "modules/$tabname/Settings.php" );
						//if ($hassettings)
						{
							$tab_array           = array ();
							$tab_array['name']   = getTranslatedString($tabname, 'Settings');
							$tab_array['depth']  = '2';
							$tab_array['ids']    = '';
							$tab_array['linkto'] = 'index.php?module=Settings&amp;action=LayoutBlockList&amp;parenttab=Settings&amp;formodule='.$tabname;
							$role_det[$tabid]    = $tab_array;
							if ($child_ids == '')
							{
								$child_ids = $tabid;
							}
							else
							{
								$child_ids = $child_ids.','.$tabid;
							}
							$parent_array[$tabid] = array ();
						}
					}
				}
			}
			$parenttab_array['ids'] = $child_ids;
			$role_det[$parent_id]   = $parenttab_array;
			$hrarray[$parent_id]    = $parent_array;
			$parentid++;
		}

		$tabsout = '';

		$tabsout .= tree_indent($hrarray, $tabsout, $role_det);
		$tabsout = '<div style=" font-size: 12px;font-weight: bold;"><a href="/index.php?module=Settings&action=NewModuleManager&parenttab=Settings">'.getTranslatedString('LBL_MODULE', 'Settings').'</a></div>'.$tabsout;
		return $tabsout;

	}

//functions for settings page end
	/**
	 * this function returns the blocks for the settings page
	 */
	function tree_indent($hrarray, $roleout, $role_det)
	{
		global $theme, $mod_strings, $app_strings;
		$theme_path = "themes/".$theme."/";
		$image_path = $theme_path."images/";
		foreach ($hrarray as $roleid => $value)
		{
			//retreiving the vtiger_role details
			$role_det_arr = $role_det[$roleid];
			$roleid_arr   = $role_det_arr['ids'];
			$rolename     = $role_det_arr['name'];
			$roledepth    = $role_det_arr['depth'];
			$linkto       = $role_det_arr['linkto'];
			/*$roleid_arr=$role_det_arr[2];
			$rolename = $role_det_arr[0];
			$roledepth = $role_det_arr[1]; */
			$roleout .= '<ul class="uil" style=" list-style-type: none;line-height:10px;margin-left: 0px;" id="'.$roleid.'" style="display:block;list-style-type:none;">';
			//$roleout .=  '<li ><table border="0" cellpadding="0" cellspacing="0" onMouseOver="fnVisible(\'layer_'.$roleid.'\')" onMouseOut="fnInVisible(\'layer_'.$roleid.'\')">';
			$roleout .= '<li ><table border="0" cellpadding="0" >';
			$roleout .= '<tr><td nowrap>';
			if (sizeof($value) > 0 && $roledepth != 0)
			{
				//$roleout.='<b style="font-weight:bold;margin:0;padding:0;cursor:pointer;">';
				$roleout .= '<img src="'.vtiger_imageurl('minus.gif', $theme).'" id="img_'.$roleid.'" border="0"  alt="'.$app_strings['LBL_EXPAND_COLLAPSE'].'" title="'.$app_strings['LBL_EXPAND_COLLAPSE'].'" align="absmiddle" onClick="showhide(\''.$roleid_arr.'\',\'img_'.$roleid.'\')" style="cursor:pointer;">';
			}
			else if ($roledepth != 0)
			{
				$roleout .= '<img src="'.vtiger_imageurl('vtigerDevDocs.gif', $theme).'" id="img_'.$roleid.'" border="0"  alt="'.$app_strings['LBL_EXPAND_COLLAPSE'].'" title="'.$app_strings['LBL_EXPAND_COLLAPSE'].'" align="absmiddle">';
			}
			else
			{
				$roleout .= '<img src="'.vtiger_imageurl('menu_root.gif', $theme).'" id="img_'.$roleid.'" border="0"  alt="'.$app_strings['LBL_ROOT'].'" title="'.$app_strings['LBL_ROOT'].'" align="absmiddle">';
			}
			if ($roledepth == 0)
			{
				$roleout .= '&nbsp;<b class="genHeaderGray">'.$rolename.'</b></td></tr></table>';
			}
			else
			{
				if ($linkto != null)
				{
					$roleout .= '&nbsp;<a href="'.$linkto.'"  id="user_'.$roleid.'">'.$rolename.'</a></td></tr></table>';
				}
				else
				{
					$roleout .= '&nbsp;'.$rolename.'</td></tr></table>';
				}

			}
			$roleout .= '</li>';
			if (sizeof($value) > 0)
			{
				$roleout = tree_indent($value, $roleout, $role_det);
			}

			$roleout .= '</ul>';

		}

		return $roleout;
	}

	/**
	 * this function takes an url and returns the module name from it
	 */
	function getPropertiesFromURL($url, $action)
	{
		$result = array ();
		preg_match("/$action=([^&]+)/", $url, $result);
		return $result[1];
	}

	function getModuleModentityNum($focus, $module)
	{
		$mod_seq_field = getModuleSequenceField($module);
		$prev_inv_no   = "";
		if ($focus->mode != 'edit' && $mod_seq_field != null)
		{
			$prev_inv_no = XN_ModentityNum::get($module);
		}
		return $prev_inv_no;
	}

	/* Function to get the name of the Field which is used for Module Specific Sequence Numbering, if any
	 * @param module String - Module label
	 * return Array - Field name and label are returned */
	function getModuleSequenceField($module)
	{
		$field = null;
		if (!empty($module))
		{

			// First look at the cached information
			$cachedModuleFields = VTCacheUtils::lookupFieldInfo_Module($module);

			if ($cachedModuleFields === false)
			{
				//uitype 4 points to Module Numbering Field
				$seqColRes = XN_Query::create('Content')->tag('fields')
									 ->filter('type', 'eic', 'fields')
									 ->filter('my.uitype', '=', '4')
									 ->filter('my.tabid', '=', getTabid($module))
									 ->filter('my.presence', 'in', array (0, 2))
									 ->end(-1)
									 ->execute();

				if (count($seqColRes) > 0)
				{
					$fieldname      = $seqColRes[0]->my->fieldname;
					$fieldlabel     = $seqColRes[0]->my->fieldlabel;
					$field          = array ();
					$field['name']  = $fieldname;
					$field['label'] = $fieldlabel;
				}
			}
			else
			{

				foreach ($cachedModuleFields as $fieldinfo)
				{
					if ($fieldinfo['uitype'] == '4')
					{
						$field          = array ();
						$field['name']  = $fieldinfo['fieldname'];
						$field['label'] = $fieldinfo['fieldlabel'];
						break;
					}
				}
			}
		}

		return $field;
	}

	function microtime_diff($a, $b)
	{

		list($a_dec, $a_sec) = explode(" ", $a);
		list($b_dec, $b_sec) = explode(" ", $b);

		return $b_sec - $a_sec + $b_dec - $a_dec;
	}

	/**
	 * Function to find the UI type of a field based on the uitype id
	 */
	function is_uitype($uitype, $reqtype)
	{
		$ui_type_arr = array (
			'_date_'       => array (5, 6, 23, 70),
			'_picklist_'   => array (15, 16, 52, 53, 54, 55, 59, 62, 63, 66, 68, 76, 77, 78, 80, 98, 101, 115, 357),
			'_users_list_' => array (52),
		);

		if ($ui_type_arr[$reqtype] != null)
		{
			if (in_array($uitype, $ui_type_arr[$reqtype]))
			{
				return true;
			}
		}
		return false;
	}

	function DeleteEntity($module, $return_module, $focus, $record, $return_id)
	{

		$focus->trash($module, $record);

	}

	function getusersbyfields($module, $fieldname)
	{
		$tabid     = getTabid($module);
		$picklists = XN_Query::create('Content')->tag('Picklists')
							 ->filter('type', 'eic', 'picklists')
							 ->filter('my.name', '=', $fieldname)
							 ->filter('my.tabid', '=', $tabid)
							 ->filter('my.presence', '=', '1')
							 ->order('my.sequence ', XN_Order::ASC_NUMBER)
							 ->execute();
		$users     = '';
		foreach ($picklists as $picklist_info)
		{
			$users = $users.$picklist_info->my->$fieldname.';';
		}
		return $users;
	}

	function getCustomFieldTypeName($uitype)
	{

		global $mod_strings, $app_strings;

		$fldname = '';

		if ($uitype == 1)
		{
			$fldname = $mod_strings['Text'];
		}
		elseif ($uitype == 7)
		{
			$fldname = $mod_strings['Number'];
		}
		elseif ($uitype == 9)
		{
			$fldname = $mod_strings['Percent'];
		}
		elseif ($uitype == 5)
		{
			$fldname = $mod_strings['Date'];
		}
		elseif ($uitype == 13)
		{
			$fldname = $mod_strings['Email'];
		}
		elseif ($uitype == 11)
		{
			$fldname = $mod_strings['Phone'];
		}
		elseif ($uitype == 15)
		{
			$fldname = $mod_strings['PickList'];
		}
		elseif ($uitype == 17)
		{
			$fldname = $mod_strings['LBL_URL'];
		}
		elseif ($uitype == 56)
		{
			$fldname = $mod_strings['LBL_CHECK_BOX'];
		}
		elseif ($uitype == 71)
		{
			$fldname = $mod_strings['Currency'];
		}
		elseif ($uitype == 21)
		{
			$fldname = $mod_strings['LBL_TEXT_AREA'];
		}
		elseif ($uitype == 33)
		{
			$fldname = $mod_strings['LBL_MULTISELECT_COMBO'];
		}
		elseif ($uitype == 85)
		{
			$fldname = $mod_strings['Skype'];
		}

		return $fldname;
	}

	function getDBInsertDateValue($value)
	{

		global $current_user;
		$dat_fmt = $current_user->date_format;
		if ($dat_fmt == '')
		{
			$dat_fmt = 'dd-mm-yyyy';
		}
		$insert_date = '';
		if ($dat_fmt == 'dd-mm-yyyy')
		{
			list($d, $m, $y) = explode('-', $value);
		}
		elseif ($dat_fmt == 'mm-dd-yyyy')
		{
			list($m, $d, $y) = explode('-', $value);
		}
		elseif ($dat_fmt == 'yyyy-mm-dd')
		{
			list($y, $m, $d) = explode('-', $value);
		}

		if (!$y && !$m && !$d)
		{
			$insert_date = '';
		}
		else
		{
			$insert_date = $y.'-'.$m.'-'.$d;
		}

		return $insert_date;
	}

	/** Function to set date values compatible to database (YY_MM_DD)
	 * @param $value -- value :: Type string
	 * @returns $insert_date -- insert_date :: Type string
	 */
	function getValidDBInsertDateValue($value)
	{

		$delim = array ('/', '.');
		foreach ($delim as $delimiter)
		{
			$x = strpos($value, $delimiter);
			if ($x === false)
				continue;
			else
			{
				$value = str_replace($delimiter, '-', $value);
				break;
			}
		}
		global $current_user;
		list($y, $m, $d) = explode('-', $value);

		if (strlen($y) < 4)
		{
			$insert_date = getDBInsertDateValue($value);
		}
		else
		{
			$insert_date = $value;
		}

		return $insert_date;
	}

	if (!function_exists('errorprint'))
	{
		function errorprint($title, $msg)
		{
			$html = '<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>'.$title.'</title>
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

	function Fast_Finish_Request(){
		ignore_user_abort(true);
		if(function_exists('fastcgi_finish_request')) {
			fastcgi_finish_request();
		} else {
			header('X-Accel-Buffering: no');
			header('Content-Length: '. strlen(ob_get_contents()));
			header("Connection: close");
			header("HTTP/1.1 200 OK");
			ob_end_flush();
			flush();
		}
	}

	//添加异步等待数据处理 by 徐雁
	function Fast_Finish_Status(){
		if(isset($_REQUEST["action"]) && $_REQUEST["action"] == "getlongtimestatus")
		{
			try
			{
				$msg = XN_MemCache::get("get_longtime_status_".$_REQUEST["module"]);
				if(isset($msg) && !empty($msg)){
					echo $msg;
				}else{
					if (isset($_REQUEST["waitbarcomplete"]) && $_REQUEST["waitbarcomplete"] != "")
						$status = $_REQUEST["waitbarcomplete"];
					else
						$status = "complete";
					echo '{"statusCode":300,"message":"获取状态失败！","status":"'.$status.'"}';
				}
			}
			catch (XN_Exception $e)
			{
				if (isset($_REQUEST["waitbarcomplete"]) && $_REQUEST["waitbarcomplete"] != "")
					$status = $_REQUEST["waitbarcomplete"];
				else
					$status = "complete";
				echo '{"statusCode":300,"message":"获取状态失败！","status":"'.$status.'"}';
			}
			die();
		}
	}

	function Fast_Finish_Start($isReturn = true){
		if(isset($_REQUEST["waitbar"]) && $_REQUEST["waitbar"] == 'true')
		{
			if($isReturn)
			{
				echo '{"statusCode":201}';
			}
			Fast_Finish_Request();
			XN_MemCache::put('{"statusCode":200,"message":"正在处理数据，请稍候。。。！"}',"get_longtime_status_".$_REQUEST["waitbarkey"]);
		}
	}

	function Fast_Finish_Progress($progress = 0)
	{
		if (isset($_REQUEST["waitbar"]) && $_REQUEST["waitbar"] == 'true'){
			XN_MemCache::put('{"statusCode":200,"progress":"'.$progress.'"}', "get_longtime_status_".$_REQUEST["waitbarkey"]);
		}
	}

	function Fast_Finish_End($returnMsg,$isBreak = false){
		if(isset($_REQUEST["waitbarcomplete"]) && $_REQUEST["waitbarcomplete"] != "")
			$waitbarcomplete = $_REQUEST["waitbarcomplete"];
		else
			$waitbarcomplete = "complete";
		if(is_string($returnMsg)){
			$returnMsg = json_decode($returnMsg,true);
		}
		if(is_array($returnMsg)){
			$returnMsg["status"] = $waitbarcomplete;
		}
		if(isset($_REQUEST["waitbar"]) && $_REQUEST["waitbar"] == 'true')
		{
			XN_MemCache::put(json_encode($returnMsg),"get_longtime_status_".$_REQUEST["waitbarkey"],"120");
		}else{
			echo json_encode($returnMsg);
		}
		if($isBreak)
		{
			die();
		}
	}

	//添加仓库商品出入库锁定 by 徐雁
	function isLockStorageByProducts($products,$storage) {
		try{
			$out_products = XN_MemCache::get("PRODUCT_INOROUT_STORAGE_".$storage);
			$outsect      = array_intersect(array_unique($products), $out_products);
			if(count($outsect) > 0){
				return true;
			}
		}catch(XN_Exception $e){
		}
		return false;
	}

	function LockStorageByProducts($products,$storage){
		try{
			$out_products = XN_MemCache::get("PRODUCT_INOROUT_STORAGE_".$storage);
			$outsect      = array_intersect(array_unique($products), $out_products);
			if(count($outsect) > 0){
				return false;
			}else{
				$out_products = array_merge($out_products,array_unique($products));
				XN_MemCache::put($out_products, "PRODUCT_INOROUT_STORAGE_".$storage);
			}
		}catch(XN_Exception $e){
			XN_MemCache::put(array_unique($products), "PRODUCT_INOROUT_STORAGE_".$storage);
		}
		return true;
	}

	function unLockStorageByProducts($products,$storage){
		try{
			$out_products = XN_MemCache::get("PRODUCT_INOROUT_STORAGE_".$storage);
			$outsect      = array_diff(array_unique($products), $out_products);
			if(count($outsect) > 0){
				XN_MemCache::put($outsect, "PRODUCT_INOROUT_STORAGE_".$storage);
			}else{
				XN_MemCache::delete("PRODUCT_INOROUT_STORAGE_".$storage);
			}
		}catch(XN_Exception $e){
		}
	}
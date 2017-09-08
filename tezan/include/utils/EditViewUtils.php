<?php
    /** This function returns the vtiger_field details for a given vtiger_fieldname.
     * Param $uitype - UI type of the vtiger_field
     * Param $fieldname - Form vtiger_field name
     * Param $fieldlabel - Form vtiger_field label name
     * Param $maxlength - maximum length of the vtiger_field
     * Param $col_fields - array contains the vtiger_fieldname and values
     * Param $generatedtype - Field generated type (default is 1)
     * Param $module_name - module name
     * Return type is an array
     */
    function getOutputHtml($uitype, $fieldname, $fieldlabel, $col_fields, $module_name, $typeofdata = null, $picklist = null,$relation=null)
    {
        global $app_strings;
        global $default_charset;
        global $mod_strings;
        global $current_user;
         
        global $global_user_privileges;
        $is_admin                = $global_user_privileges["is_admin"];
        $profileGlobalPermission = $global_user_privileges['profileGlobalPermission'];
        $user_info               = $global_user_privileges['user_info'];
         
        $fieldlabel         = from_html($fieldlabel);
        $fieldvalue         = Array ();
        $final_arr          = Array ();
        $value              = $col_fields[$fieldname];
        $custfld            = '';
        $ui_type[]          = $uitype;
        $editview_fldname[] = $fieldname;
        if ($uitype == 10)
        {
			$func = "editview_".strtolower($module_name)."_".strtolower($fieldname)."_func";
			if (function_exists($func))
			{
				try
				{
					$record_id = $col_fields["record_id"]; 
					$options = $func($record_id,$value); 
		            $editview_label[] = getTranslatedString($fieldlabel, $module_name); 
		            $fieldvalue [] = Array ('type' => 'select', 'options' => $options);
				}
				catch (XN_Exception $e)
				{
					
				}
			}
			else
			{
	            $fieldmodulerels = XN_Query::create('Content')->tag('fieldmodulerels')
	                ->filter('type', 'eic', 'fieldmodulerels')
	                ->filter('my.fieldname ', '=', $fieldname)
	                ->filter('my.module', '=', $module_name)
	                ->execute();
	            $entityType      = "";
	            $parent_id       = $value;
	            foreach ($fieldmodulerels as $fieldmodulerel_info)
	            {
	                $entityType = $fieldmodulerel_info->my->relmodule;
	            }
	            if (!empty($value))
	            {
	                $displayValueArray = getEntityName($entityType, $value);
	                if (!empty($displayValueArray))
	                {
	                    $displayValue = join(",", $displayValueArray);
	                    $parent_id    = join(";", array_keys($displayValueArray));
	                }
	            }
	            else
	            {
	                $displayValue = '';
	                $valueType    = '';
	                $value        = '';
	            }
	            $label            = getTranslatedString($entityType);
	            $editview_label[] = getTranslatedString($fieldlabel, $module_name);
	            $fieldvalue[]     = Array ('type' => 'popup','displayvalue' => $displayValue, 'entityid' => $parent_id, 'module' => $entityType, 'label' => $label);
			
			} 
	    }
        elseif ($uitype == 5 || $uitype == 6 || $uitype == 23 || $uitype == 70 || $uitype == 60)
        {
            if ($value == '')
            {
                if ($uitype == 6)
                {
                    $disp_value = getNewDisplayDate()." ".date('H:i');
                }
                if ($uitype == 70 || $uitype == 60)
                {
                    $disp_value = '';
                }
                else
                {
                    $disp_value = '';
                }
            }
            else
            {
                $disp_value = getValidDisplayDate($value);
            }
            $editview_label[] = getTranslatedString($fieldlabel, $module_name);
            $date_format      = parse_calendardate();
            if ($uitype == 6)
            {
                if ($col_fields['time_start'] != '')
                {
                    $curr_time = $col_fields['time_start'];
                }
                else
                {
                    $curr_time = date('H:i', (time() + (5 * 60)));
                }
            }
            $fieldvalue[] = array ($disp_value => $curr_time);
            if ($uitype == 5 || $uitype == 23)
            {
                if ($module_name == 'Events' && $uitype == 23)
                {
                    $fieldvalue[] = array ($date_format => $current_user->date_format.' '.$app_strings['YEAR_MONTH_DATE']);
                }
                else
                    $fieldvalue[] = array ($date_format => $current_user->date_format);
            }
            else
            {
                $fieldvalue[] = array ($date_format => $current_user->date_format.' '.$app_strings['YEAR_MONTH_DATE']);
            }
        }
        elseif ($uitype == 15)
        {
            require_once 'modules/PickList/PickListUtils.php';
            $picklistname = $fieldname;
            if (isset($picklist) && $picklist != "")
            {
                $picklistname = $picklist;
            }
            $picklistValues = getAssignedPicklistValues($picklistname);
            $valueArr       = explode("|##|", $value);
            $pickcount      = 0;
            if (!empty($picklistValues))
            {
                foreach ($picklistValues as $order => $pickListValue)
                {
                    if (in_array(trim($pickListValue), array_map("trim", $valueArr)))
                    {
                        $chk_val = "selected";
                        $pickcount++;
                    }
                    else
                    {
                        $chk_val = '';
                    }
                    $options[] = array (getTranslatedString($pickListValue), $pickListValue, $chk_val);
                }
                if ($pickcount == 0 && !empty($value))
                {
                    $options[] = array ($app_strings['LBL_NOT_ACCESSIBLE'], $value, 'selected');
                }
            }
            if (check_authorize('picklist'))
            {
                $options[]             = array ('新建', 'add_'.$picklistname, '');
                $fieldvalue["addlink"] = true;
            }
            $editview_label[] = getTranslatedString($fieldlabel, $module_name);
            $fieldvalue []    = $options;
        }
        elseif ($uitype == 33 || $uitype == 221)
        {
            require_once 'modules/PickList/PickListUtils.php';
            $picklistname = $fieldname;
            if (isset($picklist) && $picklist != "")
            {
                $picklistname = $picklist;
            }
            $picklistValues = getAssignedPicklistValues($picklistname);
            $valueArr       = (array)$value;
            $pickcount      = 0;
            if (!empty($picklistValues))
            {
                foreach ($picklistValues as $order => $pickListValue)
                {
                    if (in_array(trim($order), array_map("trim", $valueArr)))
                    {
                        $chk_val = "selected";
                        $pickcount++;
                    }
                    else
                    {
                        $chk_val = '';
                    }
                    $options[] = array (getTranslatedString($pickListValue), $order, $chk_val);
                }
            }
            $editview_label[] = getTranslatedString($fieldlabel, $module_name);
            $fieldvalue []    = $options;
        }
        elseif ($uitype == 533 || $uitype == 534)
        {
	        require_once 'modules/PickList/PickListUtils.php';
	        $picklistValues = getAssignedPicklistValues($fieldname); 
	        $valueArr = (array) $value;
	        $pickcount = 0;
	        if(!empty($picklistValues)){
	            foreach($picklistValues as $order=>$pickListValue){
	                if(in_array(trim($order),array_map("trim", $valueArr))){
	                    $chk_val = "selected";
	                    $disabled='false';
	                    $pickcount++;
	                }else{
	                    $chk_val = '';
	                    $disabled='true';
	                }
	                $options[] = array(getTranslatedString($pickListValue),$order,$chk_val,'disabled'=>$disabled );
	            }
	        }
	        $editview_label[]=getTranslatedString($fieldlabel, $module_name);
	        $fieldvalue [] = $options;
        }
        elseif ($uitype == 16)
        {
            require_once 'modules/PickList/PickListUtils.php';
            $editview_label[] = getTranslatedString($fieldlabel, $module_name);
            $picklists        = XN_Query::create('Content')->tag('Picklists')
                ->filter('type', 'eic', 'picklists')
                ->filter('my.name', '=', $fieldname)
                ->filter('my.presence', '=', '1')
                ->order('my.sequence', XN_Order::ASC_NUMBER)
                ->execute();
            if (count($picklists) > 0)
            {
                $options   = array ();
                $pickcount = 0;
                $found     = false;
                foreach ($picklists as $picklist_info)
                {
                    $value           = decode_html($value);
                    $lower_fieldname = strtolower($fieldname);
                    $pickListValue   = decode_html($picklist_info->my->$lower_fieldname);
                    if ($value == trim($pickListValue))
                    {
                        $chk_val = "selected";
                        $pickcount++;
                        $found = true;
                    }
                    else
                    {
                        $chk_val = '';
                    }
                    $pickListValue = to_html($pickListValue);
                    $options[] = array (getTranslatedString($pickListValue), $pickListValue, $chk_val);
                }
                if (!$found)
                {
                    $options[] = array ($value, $value, "selected");
                }
                $fieldvalue [] = $options;
            }
            else
            {
                $fieldvalue [] = array ();
            }
        }
        elseif ($uitype == 17)
        {
            $editview_label[] = getTranslatedString($fieldlabel, $module_name);
            $fieldvalue []    = $value;
        }
        elseif ($uitype == 19 || $uitype == 20)
        {
            if (isset($_REQUEST['body']))
            {
                $value = ($_REQUEST['body']);
            }
            $editview_label[] = getTranslatedString($fieldlabel, $module_name);
            $fieldvalue []    = $value;
        }
        elseif ($uitype == 21 || $uitype == 24)
        {
            $editview_label[] = getTranslatedString($fieldlabel, $module_name);
            $fieldvalue []    = $value;
        }
        elseif ($uitype == 22)
        {
            $editview_label[] = getTranslatedString($fieldlabel, $module_name);
            $fieldvalue[]     = $value;
        }
        elseif ($uitype == 100)
        {
            $subtabid = $col_fields["tabid"];
            $options  = array ();
            if (isset($subtabid) && $subtabid != '')
            {
                $submodule    = getModule($subtabid);
                $fields       = XN_Query::create('Content')->tag('fields')
                    ->filter('type', 'eic', 'fields')
                    ->filter('my.tabid', '=', $subtabid)
                    ->order('my.sequence', XN_Order::ASC_NUMBER)
                    ->execute();
                $selectfields = array ();
                foreach ($fields as $field_info)
                {
                    $field_name  = $field_info->my->fieldname;
                    $field_label = getTranslatedString($field_info->my->fieldlabel, $submodule);
                    if ($value == $field_name)
                    {
                        $options[] = array ($field_label, $field_name, 'selected');
                    }
                    else
                    {
                        $options[] = array ($field_label, $field_name, '');
                    }
                }
            }
            $editview_label[] = getTranslatedString($fieldlabel, $module_name);
            $fieldvalue []    = $options;
        }
        elseif ($uitype == 222)
        {
            $all_entity_tabs_array = array ();
            if ($module_name == "ApprovalFlows")
            {
                $tabdata_file = 'modules/ApprovalFlows/config.tabs.php';
                include($tabdata_file);
            }
            else
            {
				global $global_session; 
				$tabdata  = $global_session['tabdata']; 
                $all_entity_tabs_array = $tabdata['all_entity_tabs_array']; 
            }
            $pickcount = 0;
            $options   = array (array ("==请选择==", '', 'selected'));
            foreach ($all_entity_tabs_array as $tabid => $tabname)
            {
                if ($tabid == $value)
                {
                    $chk_val = "selected";
                    $pickcount++;
                }
                else
                {
                    $chk_val = '';
                }
                $options[] = array (getTranslatedString($tabname), $tabid, $chk_val);
            }
            if ($pickcount == 0 && !empty($value))
            {
                $options[] = array ('[未知模块]', $value, 'selected', 'unknown');
            }
            $editview_label[] = getTranslatedString($fieldlabel, $module_name);
            $fieldvalue []    = $options;
        }
        elseif ($uitype == 85) //added for Skype by Minnie
        {
            $editview_label[] = getTranslatedString($fieldlabel, $module_name);
            $fieldvalue []    = $value;
        }
        elseif ($uitype == 52 || $uitype == 77)
        {
            $editview_label[] = getTranslatedString($fieldlabel, $module_name);
            global $current_user;
            if ($value != '')
            {
                $personman = $value;
            }
            else
            {
                $personman = $current_user->id;
            }
            if ($uitype == 52)
            {
                $combo_lbl_name = 'personman';
            }
            elseif ($uitype == 77)
            {
                $combo_lbl_name = 'personman1';
            }
            //Control will come here only for Products - Handler and Quotes - Inventory Manager
            if ($is_admin == false && $profileGlobalPermission[2] == 1 && ($defaultOrgSharingPermission[getTabid($module_name)] == 3 or $defaultOrgSharingPermission[getTabid($module_name)] == 0))
            {
                $users_combo = get_select_options_array(get_user_array(FALSE, "Active", $personman, 'private'), $personman);
            }
            else
            {
                $users_combo = get_select_options_array(get_user_array(FALSE, "Active", $personman), $personman);
            }
            $fieldvalue [] = $users_combo;
        }
        elseif ($uitype == 53)
        {
            if ($_REQUEST['convertmode'] != 'update_quote_val' && $_REQUEST['convertmode'] != 'update_so_val')
            {
                if (isset($_REQUEST['account_id']) && $_REQUEST['account_id'] != '')
                    $value = $_REQUEST['account_id'];
            }
            if ($value != '')
            {
                $users     = getUserNameByProfileId($value);
                $user_name = implode(';', $users);
            }
            $editview_label[] = getTranslatedString($fieldlabel, $module_name);
            $fieldvalue[]     = $user_name;
            $fieldvalue[]     = is_array($value) ? implode(';', $value) : $value;
        }
        elseif ($uitype == 54)
        {
            if ($value != '')
            {
                $users     = getOwnerProfileNameList($value);
                $user_name = implode(';', $users);
            }
            $editview_label[] = getTranslatedString($fieldlabel, $module_name);
            $fieldvalue[]     = $user_name;
            $fieldvalue[]     = is_array($value) ? implode(';', $value) : $value;
        }
        elseif ($uitype == 51 || $uitype == 50 || $uitype == 73)
        {
            if ($_REQUEST['convertmode'] != 'update_quote_val' && $_REQUEST['convertmode'] != 'update_so_val')
            {
                if (isset($_REQUEST['account_id']) && $_REQUEST['account_id'] != '')
                    $value = $_REQUEST['account_id'];
            }
            if ($value != '')
            {
                $account_name = getAccountName($value);
            }
            $editview_label[] = getTranslatedString($fieldlabel, $module_name);
            $fieldvalue[]     = $account_name;
            $fieldvalue[]     = $value;
        }
        elseif ($uitype == 207)
        {
            if ($_REQUEST['convertmode'] != 'update_quote_val' && $_REQUEST['convertmode'] != 'update_so_val')
            {
                if (isset($_REQUEST['account_id']) && $_REQUEST['account_id'] != '')
                    $value = $_REQUEST['account_id'];
            }
            if ($value != '')
            {
                if (is_array($value))
                {
                    foreach ($value as $profileid)
                    {
                        $users[] = getUserNameByProfileId($profileid);
                    }
                    $user_name = implode(',', $users);
                    $value     = implode(';', $value);
                }
                else
                {
                    $user_name = getUserNameByProfileId($value);
                }
            }
            $editview_label[] = getTranslatedString($fieldlabel, $module_name);
            $fieldvalue[]     = $user_name;
            $fieldvalue[]     = $value;
        }
        elseif ($uitype == 209)
        {
            if ($_REQUEST['convertmode'] != 'update_quote_val' && $_REQUEST['convertmode'] != 'update_so_val')
            {
                if (isset($_REQUEST['assigned_storage_manage_user_id']) && $_REQUEST['assigned_storage_manage_user_id'] != '')
                    $value = $_REQUEST['assigned_storage_manage_user_id'];
            }
            if ($value != '')
            {
                $users     = getUserNameByProfileId($value);
                $user_name = implode(',', $users);
            }
            $editview_label[] = getTranslatedString($fieldlabel, $module_name);
            $fieldvalue[]     = $user_name;
            $fieldvalue[]     = is_array($value) ? implode(',', $value) : $value;
        }
        elseif ($uitype == 55 || $uitype == 255)
        {
            require_once 'modules/PickList/PickListUtils.php';
            if ($uitype == 255)
            {
                $fieldpermission = getFieldVisibilityPermission($module_name, $current_user->id, 'firstname');
            }
            if ($uitype == 255 && $fieldpermission == '0')
            {
                $fieldvalue[] = '';
            }
            else
            {
                $roleid         = $current_user->roleid;
                $picklistValues = getAssignedPicklistValues('salutationtype', $roleid, $adb);
                $pickcount      = 0;
                $salt_value     = $col_fields["salutationtype"];
                foreach ($picklistValues as $order => $pickListValue)
                {
                    if ($salt_value == trim($pickListValue))
                    {
                        $chk_val = "selected";
                        $pickcount++;
                    }
                    else
                    {
                        $chk_val = '';
                    }
                    $options[] = array (getTranslatedString($pickListValue), $pickListValue, $chk_val);
                }
                if ($pickcount == 0 && $salt_value != '')
                {
                    $options[] = array ($app_strings['LBL_NOT_ACCESSIBLE'], $salt_value, 'selected');
                }
                $fieldvalue [] = $options;
            }
            $editview_label[] = getTranslatedString($fieldlabel, $module_name);
            $fieldvalue[]     = $value;
        }
        elseif ($uitype == 64)
        {
            $editview_label[] = getTranslatedString($fieldlabel, $module_name);
            $date_format      = parse_calendardate();
            $fieldvalue[]     = $value;
        }
        elseif ($uitype == 156)
        {
            $editview_label[] = getTranslatedString($fieldlabel, $module_name);
            $fieldvalue[]     = $value;
            $fieldvalue[]     = $is_admin;
        }
        elseif ($uitype == 56)
        {
            $editview_label[] = getTranslatedString($fieldlabel, $module_name);
            $fieldvalue[]     = $value;
        }
        elseif ($uitype == 115)
        {
            require_once 'modules/PickList/PickListUtils.php';
            if (isset($picklist) && $picklist != "")
            {
                $picklistValues = getAssignedPicklistValues($picklist);
                $picklistname   = $picklist;
            }
            else
            {
                $picklistValues = getAssignedPicklistValues($fieldname);
                $picklistname   = $fieldname;
            }
            $valueArr  = explode("|##|", $value);
            $pickcount = 0;
            if (!empty($picklistValues))
            {
                foreach ($picklistValues as $order => $pickListValue)
                {
                    if (in_array(trim($pickListValue), array_map("trim", $valueArr)))
                    {
                        $chk_val = "selected";
                        $pickcount++;
                    }
                    else
                    {
                        $chk_val = '';
                    }
                    $options[] = array (getTranslatedString($pickListValue), $pickListValue, $chk_val);
                }
                if ($pickcount == 0 && !empty($value))
                {
                    $options[] = array ($app_strings['LBL_NOT_ACCESSIBLE'], $value, 'selected');
                }
            }
            if (check_authorize('picklist'))
            {
                $options[]             = array ('新建', 'add_'.$picklistname, '');
                $fieldvalue["addlink"] = true;
            }
            $editview_label[] = getTranslatedString($fieldlabel, $module_name);
            $fieldvalue []    = $options;
        }
        elseif ($uitype == 116)
        {
            $func = "editview_".strtolower($module_name)."_".strtolower($fieldname)."_func";
            if (function_exists($func))
            {
                try
                {
                    $record_id = $col_fields["record_id"];
                    $options = $func($record_id,$value);
                    $editview_label[] = getTranslatedString($fieldlabel, $module_name);
                    $fieldvalue [] =  $options;
                }
                catch (XN_Exception $e)
                {

                }
            }
            else
            {
                require_once 'modules/PickList/PickListUtils.php';
                $picklistname   = $fieldname;
                if (isset($picklist) && $picklist != "")
                {
                    $picklistname   = $picklist;
                }
                $picklistValues = getAssignedPicklistValues($picklistname);
                $valueArr  = (array)$value;
                $pickcount = 0;
                if (!empty($picklistValues))
                {
                    foreach ($picklistValues as $order => $pickListValue)
                    {
                        if (in_array(trim($order), array_map("trim", $valueArr)))
                        {
                            $chk_val = "selected";
                            $pickcount++;
                        }
                        else
                        {
                            $chk_val = '';
                        }
                        $options[] = array (getTranslatedString($pickListValue), $order, $chk_val);
                    }
                }
                $editview_label[] = getTranslatedString($fieldlabel, $module_name);
                $fieldvalue []    = $options;
            }
        }
        elseif($uitype ==98)
        {
            $editview_label[]=getTranslatedString($fieldlabel, $module_name);
            $fieldvalue[]=$value;
            $fieldvalue[]=getRoleName($value);
            $fieldvalue[]=$is_admin;
        }
        elseif ($uitype == 230)
        {
            $editview_label[] = getTranslatedString($fieldlabel, $module_name);
            $fieldvalue[]     = $value;
            $fieldvalue[]     = getProfileName($value);
            $fieldvalue[]     = $is_admin;
        }
        elseif ($uitype == 101)
        {
            $editview_label[] = getTranslatedString($fieldlabel, $module_name);
            $fieldvalue[]     = getUserName($value);
            $fieldvalue[]     = $value;
        }
        elseif ($uitype == 305 || $uitype == 306 || $uitype == 308)
        {
			
            $editview_label[] = getTranslatedString($fieldlabel, $module_name);
            $src_arr          = array ();
            if (is_array($value) && count($value))
            {
                foreach ($value as $src)
                {
                    if (!strstr(strtolower($src), "http://"))
                    {
                        if ($src != "" && @file_exists($_SERVER['DOCUMENT_ROOT'].$src))
                            $src_arr[] = $src;
                    }
                    else
                    {
                        $src_arr[] = $src;
                    }
                }
            }
            elseif ($value != "")
            {
                $re = json_decode($value); 
                if (is_null($re) || is_string($value))
                { 
                    if (!strstr(strtolower($value), "http://"))
                    {
                        if ($value != "" && @file_exists($_SERVER['DOCUMENT_ROOT'].$value))
                            $src_arr[] = $value;
                    }
                    else
                    {
                        $src_arr[] = $value;
                    } 
                }
                else
                {
                    $value_arr = json_decode($value);
                    foreach ($value_arr as $src)
                    {
                        if (!strstr(strtolower($src), "http://"))
                        {
                            if ($src != "" && @file_exists($_SERVER['DOCUMENT_ROOT'].$src))
                                $src_arr[] = $src;
                        }
                        else
                        {
                            $src_arr[] = $src;
                        }
                    }
                }
            }
            $decode_str   = json_encode($src_arr);
            $fieldvalue[] = $decode_str;
        } 
        else
        {
            if ($_REQUEST['module'] == 'Emails' && $_REQUEST['mg_subject'] != '')
            {
                $value = $_REQUEST['mg_subject'];
            }
            $editview_label[] = getTranslatedString($fieldlabel, $module_name);
            $fieldvalue[] = $value;
        }
        if (!preg_match("/id=/i", $custfld))
            $custfld = preg_replace("/<input/iS", "<input id='$fieldname' ", $custfld);
        if (in_array($uitype, array (71, 72, 7, 9, 90)))
        {
            $custfld = preg_replace("/<input/iS", "<input align=right ", $custfld);
        }
        $final_arr[]  = $ui_type;
        $final_arr[]  = $editview_label;
        $final_arr[]  = $editview_fldname;
        $final_arr[]  = $fieldvalue;
        $type_of_data = explode('~', $typeofdata);
        $final_arr[]  = $type_of_data;

        return $final_arr;
    }

    /** This function returns the detail block information of a record for given block id.
     * Param $module - module name
     * Param $block - block name
     * Param $mode - view type (detail/edit/create)
     * Param $col_fields - vtiger_fields array
     * Param $tabid - vtiger_tab id
     * Param $info_type - information type (basic/advance) default ""
     * Return type is an object array
     */
    function getBlockInformation($module, $result, $col_fields, $block_label, $mode, $blockcolumns)
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

    /** This function returns the data type of the vtiger_fields, with vtiger_field label, which is used for javascript validation.
     * Param $validationData - array of vtiger_fieldnames with datatype
     * Return type array
     */
    function split_validationdataArray($validationData)
    {
        $fieldName   = '';
        $fieldLabel  = '';
        $fldDataType = '';
        $data        = array ();
        if (count($validationData) > 0)
        {
            $rows = count($validationData);
            foreach ($validationData as $fldName => $fldLabel_array)
            {
                if ($fieldName == '')
                {
                    $fieldName = "'".$fldName."'";
                }
                else
                {
                    $fieldName .= ",'".$fldName."'";
                }
                foreach ($fldLabel_array as $fldLabel => $datatype)
                {
                    if ($fieldLabel == '')
                    {
                        $fieldLabel = "'".addslashes($fldLabel)."'";
                    }
                    else
                    {
                        $fieldLabel .= ",'".addslashes($fldLabel)."'";
                    }
                    if ($fldDataType == '')
                    {
                        $fldDataType = "'".$datatype."'";
                    }
                    else
                    {
                        $fldDataType .= ",'".$datatype."'";
                    }
                }
            }
            $data['fieldname']  = $fieldName;
            $data['fieldlabel'] = $fieldLabel;
            $data['datatype']   = $fldDataType;
        }

        return $data;
    }
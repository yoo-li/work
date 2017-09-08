<?php
    function getSearchListHeaderValues($focus, $module)
    {
        $search_header = Array ();
        $moduleFields  = $focus->getPopSearchFields($module);
        if (is_array($focus->filter_fields))
        {
            foreach ($focus->filter_fields as $fieldname)
            {
                $moduleField               = $moduleFields[$fieldname];
                $fieldlabel                = $moduleField['fieldlabel'];
                 $search_header[$fieldname] = getTranslatedString($fieldlabel);
            }
            if (in_array('title', $focus->filter_fields))
            {
                $search_header['title'] = getTranslatedString('title');
            }
        }

        return $search_header;
    }

    function getSearchListViewHeader($focus, $module, $sort_qry = '', $sorder = '', $order_by = '',$changeArray)
    {
        global $theme;
        global $app_strings;
        global $mod_strings, $current_user;
        $arrow       = '';
        $list_header = Array ();
        $tabid       = getTabid($module);
        $hideFields=$changeArray['hideFields'];
        if (isset($_REQUEST['task_relmod_id']))
        {
            $task_relmod_id = $_REQUEST['task_relmod_id'];
            $pass_url .= "&task_relmod_id=".$task_relmod_id;
        }
        if (isset($_REQUEST['relmod_id']))
        {
            $relmod_id = $_REQUEST['relmod_id'];
            $pass_url .= "&relmod_id=".$relmod_id;
        }
        if (isset($_REQUEST['task_parent_module']))
        {
            $task_parent_module = $_REQUEST['task_parent_module'];
            $pass_url .= "&task_parent_module=".$task_parent_module;
        }
        if (isset($_REQUEST['parent_module']))
        {
            $parent_module = $_REQUEST['parent_module'];
            $pass_url .= "&parent_module=".$parent_module;
        }
        if (isset($_REQUEST['fromPotential']) && (isset($_REQUEST['acc_id']) && $_REQUEST['acc_id'] != ''))
        {
            $pass_url .= "&parent_module=Accounts&relmod_id=".$_REQUEST['acc_id'];
        }
        $moduleFields = $focus->getmoduleFields($module);
        //end
        $theme_path = "themes/".$theme."/";
        $image_path = $theme_path."images/";
        $totalwidth = 0;
        foreach ($focus->popup_fields as $fieldname)
        {
            if(in_array($fieldname,$hideFields)){
                continue;
            }
            if ($fieldname == "author" || $fieldname == "published")
            {
                $totalwidth += 10;
            }
            if ($fieldname == "title")
            {
                $totalwidth += 30;
            }
            else
            {
                $field = $moduleFields[$fieldname];
                $width = $field['width'];
                if ($width == 0)
                {
                    $totalwidth = 0;
                    break;
                }
                $totalwidth += $width;
            }
        }
        foreach ($focus->popup_fields as $fieldname)
        {
            if(in_array($fieldname,$hideFields)){
                continue;
            }
            if ($fieldname == "author" || $fieldname == "published")
            {
                $label = getTranslatedString($fieldname, $module);
                if ($totalwidth == 0)
                    $newwidth = 10;
                else
                    $newwidth = round(1000 / $totalwidth);
                $list_header[$fieldname] = array ('label' => $label, 'align' => 'center', 'sort' => 'true', 'width' => $newwidth);
            }
            if ($fieldname == "title")
            {
                $label = getTranslatedString($fieldname, $module);
                if ($totalwidth == 0)
                    $newwidth = 30;
                else
                    $newwidth = round(1000 / $totalwidth);
                $list_header[$fieldname] = array ('label' => $label, 'align' => 'center', 'sort' => 'true', 'width' => $newwidth);
            }
            else
            {
                $field      = $moduleFields[$fieldname];
                $fieldlabel = $field['fieldlabel'];
                $uitype     = $field['uitype'];
                $tabid      = getTabid($module);
                $label      = getTranslatedString($fieldlabel, $module);
                $sort       = 'false';
                if (isset($focus->sortby_fields) && $focus->sortby_fields != '' && in_array($fieldname, $focus->sortby_fields))
                {
                    $sort = 'true';
                }
                if ($totalwidth == 0)
                {
                    $align                   = $field['align'];
                    $width                   = 10;
                    $list_header[$fieldname] = array ('label' => $label, 'align' => $align, 'sort' => $sort, 'width' => $width);
                }
                else
                {
                    $width                   = $field['width'];
                    $align                   = $field['align'];
                    $newwidth                = round($width * 100 / $totalwidth);
                    $list_header[$fieldname] = array ('label' => $label, 'align' => $align, 'sort' => $sort, 'width' => $newwidth);
                }
            }
        }

        return $list_header;
    }

    function getNavigationValues($display, $noofrows, $limit)
    {
        $navigation_array = Array ();
        global $limitpage_navigation;
        if (isset($_REQUEST['allflag']) && $_REQUEST['allflag'] == 'All')
        {
            $navigation_array['start']    = 1;
            $navigation_array['first']    = 1;
            $navigation_array['end']      = 1;
            $navigation_array['prev']     = 0;
            $navigation_array['next']     = 0;
            $navigation_array['end_val']  = $noofrows;
            $navigation_array['current']  = 1;
            $navigation_array['allflag']  = 'Normal';
            $navigation_array['verylast'] = 1;

            return $navigation_array;
        }
        if ($noofrows != 0)
        {
            if (((($display * $limit) - $limit) + 1) > $noofrows)
            {
                $display = floor($noofrows / $limit);
            }
            $start = ((($display * $limit) - $limit) + 1);
        }
        else
        {
            $start = 0;
        }
        $end = $start + ($limit - 1);
        if ($end > $noofrows)
        {
            $end = $noofrows;
        }
        $paging = ceil($noofrows / $limit);
        // Display the navigation
        if ($display > 1)
        {
            $previous = $display - 1;
        }
        else
        {
            $previous = 0;
        }
        if ($noofrows < $limit)
        {
            $first = '';
        }
        elseif ($noofrows != $limit)
        {
            $last  = $paging;
            $first = 1;
            if ($paging > $limitpage_navigation)
            {
                $first = $display - floor(($limitpage_navigation / 2));
                if ($first < 1)
                    $first = 1;
                $last = ($limitpage_navigation - 1) + $first;
            }
            if ($last > $paging)
            {
                $first = $paging - ($limitpage_navigation - 1);
                $last  = $paging;
            }
        }
        if ($display < $paging)
        {
            $next = $display + 1;
        }
        else
        {
            $next = 0;
        }
        $navigation_array['start']    = $start;
        $navigation_array['first']    = $first;
        $navigation_array['end']      = $last;
        $navigation_array['prev']     = $previous;
        $navigation_array['next']     = $next;
        $navigation_array['end_val']  = $end;
        $navigation_array['current']  = $display;
        $navigation_array['allflag']  = 'All';
        $navigation_array['verylast'] = $paging;

        return $navigation_array;
    }

    function getSearchFieldTypeFromUIType()
    {
        $fieldTypeMapping = array ();
        $tabsquery        = XN_Query::create('Content')->tag('Ws_fieldtypes')
            ->filter('type', 'eic', 'ws_fieldtypes')
            ->execute();
        foreach ($tabsquery as $info)
        {
            $ft                                  = array ();
            $ft['fieldtypeid']                   = $info->id;
            $ft['uitype']                        = $info->my->uitype;
            $ft['fieldtype']                     = $info->my->fieldtype;
            $fieldTypeMapping[$info->my->uitype] = $ft;
        }

        return $fieldTypeMapping;
    }

    function getSearchOwnerFieldList($fields, $fieldTypeMapping)
    {
        $OwnerFieldList = array ();
        foreach ($fields as $field_info)
        {
            $uitype = $field_info['uitype'];
            $row    = $fieldTypeMapping[$uitype];
            if (isset($row) && $row['fieldtype'] == 'owner')
            {
                $OwnerFieldList[] = $field_info['fieldname'];
            }
        }

        return $OwnerFieldList;
    }

    function getSearchReferenceFieldList($fields, $fieldTypeMapping)
    {
        $ReferenceFieldList = array ();
        foreach ($fields as $field_info)
        {
            $uitype      = $field_info['uitype'];
            $row         = $fieldTypeMapping[$uitype];
            $fieldtypeid = $row['fieldtypeid'];
            if (isset($row) && $row['fieldtype'] == 'reference')
            {
                $ReferenceFieldList[] = $field_info['fieldname'];
            }
        }

        return $ReferenceFieldList;
    }

    function getReferenceFieldInfoList($fieldtypeid, $uitype, $fieldid)
    {
        $referenceTypes = array ();
        if ($uitype != '10')
        {
            $query = XN_Query::create('Content')->tag('Ws_referencetypes')
                ->filter('type', 'eic', 'ws_referencetypes')
                ->filter('my.fieldtypeid', '=', $fieldtypeid)
                ->execute();
            foreach ($query as $query_info)
            {
                array_push($referenceTypes, $query_info->my->type);
            }
        }
        else
        {
            $query = XN_Query::create('Content')->tag('Fieldmodulerels')
                ->filter('type', 'eic', 'fieldmodulerels')
                ->filter('my.fieldid', '=', $fieldid)
                ->execute();
            foreach ($query as $query_info)
            {
                array_push($referenceTypes, $query_info->my->relmodule);
            }
        }
        if (count($referenceTypes) > 0)
            return $referenceTypes[0];

        return '';
    }

    function getSearchListViewEntries($focus, $module, $list_result)
    {
        global $app_strings, $theme, $current_user, $list_max_entries_per_page;
        $noofrows    = count($list_result);
        $list_header = '';
        $theme_path  = "themes/".$theme."/";
        $image_path  = $theme_path."images/";
        $list_block  = Array ();
        //getting the vtiger_fieldtable entries from database
        $tabid = getTabid($module);
        //constructing the uitype and columnname array
        $ui_col_array = array ();
        $moduleFields = array ();
        foreach ($focus->getmoduleFields($module) as $field_info)
        {
            $field_name = $field_info['fieldname'];
            if (in_array($field_name, $focus->popup_fields))
            {
                $tempArr                   = array ();
                $uitype                    = $field_info['uitype'];
                $tempArr[$uitype]          = $field_name;
                $ui_col_array[$field_name] = $tempArr;
                $moduleFields[$field_name] = $field_info;
            }
        }
        if (in_array('title', $focus->popup_fields))
        {
            $field_info            = array ('fieldid' => '0', 'fieldname' => 'title', 'columnname' => 'title', 'uitype' => '1', 'fieldlabel' => 'title', 'width' => '30', 'align' => 'left');
            $moduleFields['title'] = $field_info;
        }
        $fieldTypeMapping = getSearchFieldTypeFromUIType();
        global $referenceFieldList;
        global $OwnerFieldList;
        global $ownerNameList;
        global $referenceValueList;
        global $productPrice;
        $referenceFieldList = getSearchReferenceFieldList($moduleFields, $fieldTypeMapping);
        $OwnerFieldList     = getSearchOwnerFieldList($moduleFields, $fieldTypeMapping);
        $ownerNameList      = array ();
        $referenceValueList = array ();
        //if(!is_array($productPrice) || empty($productPrice) || is_null($productPrice) || count($productPrice) == 0 )
        //	$productPrice = getProductPrice();
        if (in_array('author', $focus->popup_fields))
            $OwnerFieldList[] = 'author';
        foreach ($OwnerFieldList as $fieldName)
        {
            $idList = array ();
            foreach ($list_result as $result_info)
            {
                if ($fieldName == 'author')
                {
                    $id = $result_info->contributorName;
                }
                else
                {
                    $id = $result_info->my->$fieldName;
                }
                if (is_array($id))
                {
                    $idList = array_merge($idList, $id);
                }
                else
                {
                    $idList[] = $id;
                }
            }
            if (count($idList) > 0)
            {
                $newOwnerList = getOwnerNameList($idList);
                foreach ($newOwnerList as $id => $name)
                {
                    $ownerNameList[$fieldName][$id] = $name;
                }
            }
        }
        foreach ($referenceFieldList as $fieldtypeid => $fieldName)
        {
            $fieldid         = $moduleFields[$fieldName]['fieldid'];
            $uitype          = $moduleFields[$fieldName]['uitype'];
            $referencemodule = getReferenceFieldInfoList($fieldtypeid, $uitype, $fieldid);
            $idList          = array ();
            foreach ($list_result as $result_info)
            {
                if ($fieldName == 'author')
                {
                    $id = $result_info->contributorName;
                }
                else
                {
                    $columnname = $moduleFields[$fieldName]['columnname'];
                    $id         = $result_info->my->$columnname;
                }
                if (is_array($id))
                {
                    $idList = array_merge($idList, $id);
                }
                elseif (isset($id) && $id != '-' && $id != '')
                {
                    $idList[] = $id;
                }
            }
            if (count($idList) > 0)
            {
                $nameList = getEntityName($referencemodule, $idList);
                foreach ($nameList as $id => $name)
                {
                    $referenceValueList[$fieldName][$id] = $name;
                }
            }
        }
        foreach ($list_result as $result_info)
        {
            if ($module != 'Users')
            {
                $entity_id = $result_info->id;
            }
            else
            {
                $entity_id = $result_info->my->profileid;
            }
            $list_header = Array ();
            foreach ($focus->popup_fields as $fieldname)
            {
                switch ($fieldname)
                {
                    case 'published':
                        $value = $result_info->createdDate;
                        break;
                    case 'updated':
                        $value = $result_info->updatedDate;
                        break;
                    case 'author':
                        $value = $result_info->contributorName;
                        break;
                    case 'title':
                        $value = $result_info->title;
                        break;
                    default:
                        $uitype = $moduleFields[$fieldname]['uitype'];
                        if (isset($fieldname))
                            $value = $result_info->my->$fieldname;
                        else
                            $value = '';
                }
                if(in_array($fieldname, $OwnerFieldList))
                {
                    $owners = array ();
                    if (is_array($value))
                    {
                        foreach ($value as $owner)
                        {
                            $owners[] = textlength_check($ownerNameList[$fieldname][$owner]);
                        };
                        $value = implode(',', $owners);
                    }
                    elseif ($value == "")
                    {
                        $value = "-";
                    }
                    elseif (isset($ownerNameList[$fieldname][$value]))
                    {
                        $value = textlength_check($ownerNameList[$fieldname][$value]);
                    }
                    else
                    {
                    }
                }
                elseif (in_array($fieldname, $referenceFieldList))
                {
                    if ((is_array($focus->list_link_field) && in_array($fieldname, $focus->list_link_field)) || (is_string($focus->list_link_field) && $fieldname==$focus->list_link_field))
                    {
                        $value = getValue($ui_col_array, $result_info, $fieldname, $focus, $module, $entity_id, "search", $popuptype, $form);
                    }
                    else
                    {
                        $owners = array ();
                        if (is_array($value))
                        {
                            foreach ($value as $owner)
                            {
                                $owners[] = textlength_check($referenceValueList[$fieldname][$owner]);
                            };
                            $value = implode(',', $owners);
                        }
                        else
                        {
                            $value = textlength_check($referenceValueList[$fieldname][$value]);
                        }
                    }
                }
                else if ($fieldname == "published")
                {
                    $value = date('Y-m-t', strtotime($value));
                }
                else if ($uitype == "20")
                {
                    $value = subtext_check($value,60);
                }
                else if ($fieldname == "title")
                {
                }
                else
                {
                    $popuptype = '';
                    $popuptype = $_REQUEST["popuptype"];
                    $value     = getValue($ui_col_array, $result_info, $fieldname, $focus, $module, $entity_id, "search", $popuptype, $moduleFields[$fieldname]);
                }
                $list_header[$fieldname] = $value;
            }
            $list_block[$entity_id] = $list_header;
        }
        $list = $list_block;
        return $list;
    }

    function getValue($field_result, $content, $fieldname, $focus, $module, $entity_id, $mode, $popuptype, $field_info = '')
    {
        global $listview_max_textlength, $app_strings, $current_language, $currentModule;
        global $adb, $current_user, $default_charset;
        global $global_user_privileges;
        $user_info = $global_user_privileges['user_info'];
         
        $tabname                = getParentTab();
        $tabid                  = getTabid($module);
        $current_module_strings = return_module_language($current_language, $module);
        $uicolarr               = $field_result[$fieldname];
        if ($uicolarr == null)
            return '';
        foreach ($uicolarr as $key => $value)
        {
            $uitype  = $key;
            $colname = $value;
        }
        //added for getting event status in Custom view - Jaguar
        if ($module == 'Calendar' && ($colname == "status" || $colname == "eventstatus"))
        {
            $colname = "activitystatus";
        }
        //Ends
        $field_val = $content->my->$colname;
        if (($field_val != null) && ($field_val != '') && (!is_array($field_val)))
        {
            if (stristr(html_entity_decode($field_val), "<a href") === false && $uitype != 8)
            {
                $temp_val = textlength_check($field_val);
            }
            elseif ($uitype != 8)
            {
                $temp_val = html_entity_decode($field_val, ENT_QUOTES);
            }
            else
            {
                $temp_val = $field_val;
            }
        }
        else
        {
            $temp_val = '';
        }
        // vtlib customization: New uitype to handle relation between modules
        if ($uitype == 10)
        {
            $parent_id = $field_val;
            if (!empty($parent_id))
            {
                $parent_module = getSalesEntityType($parent_id);
                $valueTitle    = $parent_module;
                if ($app_strings[$valueTitle])
                    $valueTitle = $app_strings[$valueTitle];
                $displayValueArray = getEntityName($parent_module, $parent_id);
                if (!empty($displayValueArray))
                {
                    foreach ($displayValueArray as $key => $value)
                    {
                        $displayValue = $value;
                    }
                }
                if ((is_array($focus->list_link_field) && in_array($fieldname, $focus->list_link_field)) || (is_string($focus->list_link_field) && $fieldname==$focus->list_link_field))
                {
                    if ($mode == "search")
                    {
						global $global_session; 
						$tabdata  = $global_session['tabdata']; 
                        $all_tabs_array = $tabdata['all_tabs_array'];
                        
                        $specific = false;

                        if (in_array($popuptype, $all_tabs_array) || (isset($focus->select_fields) && array_key_exists($popuptype, $focus->select_fields)))
                        {
                            global $referenceFieldList;
                            global $OwnerFieldList;
                            global $ownerNameList;
                            global $referenceValueList;

                            if (isset($focus->select_fields))
                            {
                                $select_fields = $focus->select_fields[$popuptype];
                                if (is_array($select_fields))
                                {
                                    $slashes_temp_val = popup_from_html($displayValue);
                                    $slashes_temp_val = htmlspecialchars($slashes_temp_val, ENT_QUOTES, $default_charset);
                                    $link             = '<a href="javascript:void(0);" onclick=\'set_return_'.strtolower($popuptype).'("'.$entity_id.'", "'.nl2br(decode_html($slashes_temp_val)).'"';
                                    foreach ($select_fields as $select_fieldname)
                                    {
                                        $select_fieldinfo = $field_result[$select_fieldname];
                                        if ($select_fieldinfo != null)
                                        {
                                            $select_column = array_values($select_fieldinfo);
                                            $select_values = $content->my->$select_column[0];
                                            if (is_array($select_values))
                                            {
                                                $temp             = join(",", $select_values);
                                                $slashes_temp_val = popup_from_html($temp);
                                                $slashes_temp_val = htmlspecialchars($slashes_temp_val, ENT_QUOTES, $default_charset);
                                                $link             = $link.',"'.nl2br(decode_html($slashes_temp_val)).'"';
                                                if (in_array($select_fieldname, $OwnerFieldList))
                                                {
                                                    $owners = array ();
                                                    foreach ($select_values as $owner)
                                                    {
                                                        $owners[] = $ownerNameList[$select_fieldname][$owner];
                                                    };
                                                    $value = implode(',', $owners);
                                                    $link  = $link.',"'.$value.'"';
                                                }
                                                if (in_array($select_fieldname, $referenceFieldList))
                                                {
                                                    $owners = array ();
                                                    foreach ($select_values as $owner)
                                                    {
                                                        $owners[] = $referenceValueList[$select_fieldname][$owner];
                                                    };
                                                    $value = implode(',', $owners);
                                                    $link  = $link.',"'.$value.'"';
                                                }
                                            }
                                            else
                                            {
                                                $slashes_temp_val = popup_from_html($select_values);
                                                $slashes_temp_val = htmlspecialchars($slashes_temp_val, ENT_QUOTES, $default_charset);
                                                $link             = $link.',"'.nl2br(decode_html($slashes_temp_val)).'"';
                                                if (in_array($select_fieldname, $OwnerFieldList))
                                                {
                                                    $link = $link.',"'.$ownerNameList[$select_fieldname][$select_values].'"';
                                                }
                                                if (in_array($select_fieldname, $referenceFieldList))
                                                {
                                                    $link = $link.',"'.$referenceValueList[$select_fieldname][$select_values].'"';
                                                }
//                                                if ($select_fieldname == 'category_id')
//                                                {
//                                                    $categoryArr = getCategoryArray();
//                                                    $value       = textlength_check(getCategoryPath($content->my->$select_fieldname, $categoryArr));
//                                                    $link        = $link.',"'.$value.'"';
//                                                }
                                            }
                                        }
                                        else
                                        {
                                            switch ($select_fieldname)
                                            {
                                                case 'published':
                                                    $value = $content->createdDate;
                                                    $link  = $link.',"'.$value.'"';
                                                    break;
                                                case 'updated':
                                                    $value = $content->updatedDate;
                                                    $link  = $link.',"'.$value.'"';
                                                    break;
                                                case 'recordid':
                                                    if (isset($_REQUEST['recordid']) && $_REQUEST['recordid'] != '')
                                                        $value = $_REQUEST['recordid'];
                                                    $link = $link.',"'.$value.'"';
                                                    break;
                                                case 'author':
                                                    $value = $content->contributorName;
                                                    $link  = $link.',"'.$value.'"';
                                                    $link  = $link.',"'.$ownerNameList['author'][$value].'"';
                                                    break;
                                            }
                                        }
                                    }
                                    if ($popuptype == 'Stocktake')
                                    {
                                        global $inventoryNumber;
                                        $number = isset($inventoryNumber[$entity_id]) ? $inventoryNumber[$entity_id] : 0;
                                        $link   = $link.','.$number;
                                    }
                                    $value    = $link.");'>".$displayValue."</a>";
                                    $specific = true;
                                }
                            }
                        }

                        if (!$specific)
                        {
                            $slashes_temp_val = popup_from_html($displayValue);
                            $slashes_temp_val = htmlspecialchars($slashes_temp_val, ENT_QUOTES, $default_charset);
                            //$value = '<a href="javascript:void(0);" onclick=\'set_return("'.$entity_id.'", "'.nl2br(decode_html($slashes_temp_val)).'");\'>'.$displayValue.'</a>';
                            // $value .= '<a href="javascript:void(0);" onclick="$.bringBack({id:\''.$entity_id.'\', Name:\''.nl2br(decode_html($slashes_temp_val)).'\'})">'.$displayValue.'</a>';
                            $value = '<a href="javascript:;" data-toggle="lookupback" data-args="{id:\''.$entity_id.'\', name:\''.nl2br(decode_html($slashes_temp_val)).'\'}"  title="'.$displayValue.'" data-icon="check">'.$displayValue.'</a>';
                            // $value .= '<a href="javascript:void(0);" onclick="$.bringBack({id:\''.$entity_id.'\', Name:\''.nl2br(decode_html($slashes_temp_val)).'\'})">'.$displayValue.'</a>';
                        }
                    }
                    else
                    {
                        $value = $displayValue;
                    }
                }
                else
                {
                    $value = $displayValue;
                    //$value = "<a href='index.php?module=$parent_module&action=EditView&record=$parent_id' title='$valueTitle'>$displayValue</a>";
                }
            }
            else
            {
                $value = '';
            }
        } // END
        else if ($uitype == 53)
        {
            $givename = $content->my->givename;
            if (isset($givename) && $givename != "")
            {
                $value = $content->my->givename;
            }
            else
            {
                $value = $content->my->last_name;
            } 
            // When Assigned To field is used in Popup window
            if ($value == '')
            {
                $user_id = $content->my->personman;
                if ($user_id != null && $user_id != '')
                {
                    if (is_array($user_id))
                    {
                        foreach ($user_id as $id)
                        {
                            $owners[] = getOwnerName($id);
                        }
                        $value = implode(',', $owners);
                    }
                    else
                    {
                        $value = getOwnerName($user_id);
                    }
                }
            }
        }
        elseif ($uitype == 52)
        {
            $value = getUserName($content->my->colname);
        }
        elseif ($uitype == 66)
        {
			$value =  strswaptime(intval($value)); 
        } 
        elseif ($uitype == 5 || $uitype == 6 || $uitype == 23 || $uitype == 70)
        {
            if ($temp_val != '' && $temp_val != '0000-00-00')
            {
                $value = getDisplayDate($temp_val);
            }
            elseif ($temp_val == '0000-00-00')
            {
                $value = '';
            }
            else
            {
                $value = $temp_val;
            }
        }
        elseif ($uitype == 15 || ($uitype == 55 && $fieldname == "salutationtype"))
        {
            $temp_val = decode_html($content->my->$colname);
            $value    = ($current_module_strings[$temp_val] != '') ? $current_module_strings[$temp_val] : (($app_strings[$temp_val] != '') ? ($app_strings[$temp_val]) : $temp_val);
            if ($value != "<font color='red'>".$app_strings['LBL_NOT_ACCESSIBLE']."</font>")
            {
                $value = textlength_check($value);
            }
        }
        elseif ($uitype == 56)
        {
            if ($temp_val == 1)
            {
                $value = $app_strings['yes'];
            }
            elseif ($temp_val == 0)
            {
                $value = $app_strings['no'];
            }
            else
            {
                $value = '';
            }
        }
        elseif ($uitype == 98)
        {
            $value = textlength_check(getRoleName($temp_val));
        }
        elseif ($uitype == 7)
        {
            $value = formatnumber($temp_val);
        }
        elseif ($uitype == 33 || $uitype == 116)
        {
            require_once('modules/PickList/PickListUtils.php');
            $valueArr = getAssignedPicklistValues($colname);
            $value    = getTranslatedString($valueArr[$field_val]);
        }
        elseif ($uitype == 156)
        {
            $value = getTranslatedString($temp_val);
        }
        elseif ($uitype == 85)
        {
            $value = ($temp_val != "") ? "<a href='skype:{$temp_val}?call'>{$temp_val}</a>" : "";
        }
        //asterisk changes end here
        //Added for email status tracking
        elseif ($uitype == 25)
        {
        }
        elseif ($uitype == 212)
        {
            global $current_user, $productPrice;
            $contactid = $content->id;
            if (!isset($productPrice[$contactid][$current_user->id]))
                $value = $productPrice[$contactid]["EmptyMax"];
            else
                $value = $productPrice[$contactid][$current_user->id];
        }
        else
        {

            if ((is_array($focus->list_link_field) && in_array($fieldname, $focus->list_link_field)) || (is_string($focus->list_link_field) && $fieldname==$focus->list_link_field))
            {
                if ($mode == "search")
                {
					global $global_session; 
					$tabdata  = $global_session['tabdata']; 
                    $all_tabs_array = $tabdata['all_tabs_array'];
                    
                    $specific = false;
                    if (in_array($popuptype, $all_tabs_array) || (isset($focus->select_fields) && array_key_exists($popuptype, $focus->select_fields)))
                    {
                        global $referenceFieldList;
                        global $OwnerFieldList;
                        global $ownerNameList;
                        global $referenceValueList;
                        if (isset($focus->select_fields))
                        {
                            $select_fields = $focus->select_fields[$popuptype];
                            if (is_array($select_fields))
                            {
                                $slashes_temp_val = popup_from_html($temp_val);
                                $slashes_temp_val = htmlspecialchars($slashes_temp_val, ENT_QUOTES, $default_charset);
                                $link             = '<a href="javascript:;" data-toggle="lookupback" data-args="{id:\''.$entity_id.'\', name:\''.nl2br(str_replace("\\\"", "", decode_html($slashes_temp_val))).'\'';
                                // $link = '<a href="javascript:void(0);" onclick="$.bringBack({id:\''.$entity_id.'\', Name:\''.nl2br(str_replace("\\\"", "", decode_html($slashes_temp_val))).'\'';
                                foreach ($select_fields as $select_fieldname)
                                {
                                    $select_fieldinfo = $field_result[$select_fieldname];
                                    //echo '________'.$select_fieldname.'_____________<br>';
                                    if ($select_fieldinfo != null)
                                    {
                                        $select_column = array_values($select_fieldinfo);
                                        $select_values = $content->my->$select_column[0];
                                        if (is_array($select_values))
                                        {
                                            if (in_array($select_fieldname, $OwnerFieldList))
                                            {
                                                $owners = array ();
                                                foreach ($select_values as $owner)
                                                {
                                                    $owners[] = $ownerNameList[$select_fieldname][$owner];
                                                };
                                                $value = implode(',', $owners);
                                                $link  = $link.','.$select_fieldname.':\''.json_encode($value).'\'';
                                            }
                                            else if (in_array($select_fieldname, $referenceFieldList))
                                            {
                                                $owners = array ();
                                                foreach ($select_values as $owner)
                                                {
                                                    $owners[] = $referenceValueList[$select_fieldname][$owner];
                                                };
                                                $value = implode(',', $owners);
                                                $link  = $link.','.$select_fieldname.':\''.json_encode($value).'\'';
                                            }
                                            else
                                            {
                                                $value = implode(',', $select_values);
                                                $link  = $link.','.$select_fieldname.':\''.json_encode($value).'\'';
                                            }
                                        }
                                        else
                                        {
                                            if (in_array($select_fieldname, $OwnerFieldList))
                                            {
                                                $link = $link.','.$select_fieldname.':\''.$select_values.'\'';
                                                $link = $link.','.$select_fieldname.'_name:\''.$ownerNameList[$select_fieldname][$select_values].'\'';
                                            }
                                            else if (in_array($select_fieldname, $referenceFieldList))
                                            {
                                                $link = $link.','.$select_fieldname.':\''.$select_values.'\'';
                                                $link = $link.','.$select_fieldname.'_reference:\''.$referenceValueList[$select_fieldname][$select_values].'\'';
                                            }
                                            else
                                            {
                                                $link = $link.','.$select_fieldname.':\''.str_replace('"', "", $select_values).'\'';
                                            }
                                        }
                                    }
                                    else
                                    {
                                        switch ($select_fieldname)
                                        {
                                            case 'published':
                                                $value = $content->createdDate;
                                                $link  = $link.',published:\''.$value.'\'';
                                                break;
                                            case 'updated':
                                                $value = $content->updatedDate;
                                                $link  = $link.',updated:\''.$value.'\'';
                                                break;
                                            case 'recordid':
                                                if (isset($_REQUEST['recordid']) && $_REQUEST['recordid'] != '')
                                                    $value = $_REQUEST['recordid'];
                                                $link = $link.',recordid:\''.$value.'\'';
                                                break;
                                            case 'author':
                                                $value = $content->contributorName;
                                                $link  = $link.',author:\''.$value.'\'';
                                                $link  = $link.',authorname:\''.$ownerNameList['author'][$value].'\'';
                                                break;
                                        }
                                    }
                                }
                                $value = $link.'}" title="'.$temp_val.'">'.$temp_val.'</a>';
                                // $value =  $link.'})">'.$temp_val.'</a>';
                                $specific = true;
                            }
                        }
                    }
                    if (!$specific)
                    {
                        $slashes_temp_val = popup_from_html($temp_val);
                        $slashes_temp_val = htmlspecialchars($slashes_temp_val, ENT_QUOTES, $default_charset);
                        // $value = '<a href="javascript:;" data-toggle="lookupback" data-args="{id:\''.$entity_id.'\', name:\''.nl2br(decode_html($slashes_temp_val)).'\'}"  title="'.$temp_val.'">'.$temp_val.'</a>';
                        $value = array ("label" => $temp_val, "value" => '{id:\''.$entity_id.'\', name:\''.nl2br(decode_html($slashes_temp_val)).'\'}');
                        // $value = '<a href="javascript:void(0);" onclick="$.bringBack({id:\''.$entity_id.'\', Name:\''.nl2br(decode_html($slashes_temp_val)).'\'})">'.$temp_val.'</a>';
                    }
                }
                else
                {
                    $value = $temp_val;
                }
            }
            elseif ($fieldname == 'expectedroi' || $fieldname == 'actualroi' || $fieldname == 'actualcost' || $fieldname == 'budgetcost' || $fieldname == 'expectedrevenue')
            {
                $rate  = $user_info['conv_rate'];
                $value = convertFromDollar($temp_val, $rate);
            }
            elseif (($module == 'Invoice' || $module == 'Quotes' || $module == 'PurchaseOrder' || $module == 'SalesOrder')
                    && ($fieldname == 'hdnGrandTotal' || $fieldname == 'hdnSubTotal' || $fieldname == 'txtAdjustment'
                        || $fieldname == 'hdnDiscountAmount' || $fieldname == 'hdnS_H_Amount')
            )
            {
                $currency_info   = getInventoryCurrencyInfo($module, $entity_id);
                $currency_id     = $currency_info['currency_id'];
                $currency_symbol = $currency_info['currency_symbol'];
                $value           = $currency_symbol.$temp_val;
            }
            elseif ($fieldname == strtolower($module).'status')
            {
                $value = getTranslatedString($temp_val, $module);
            }
            else if ($uitype == 115)
            {
                $value = getTranslatedString($temp_val, $currentModule);
            }
            else
            {
                $value = $temp_val;
            }
        }
        // Mike Crowe Mod --------------------------------------------------------Make right justified and vtiger_currency value
        if (in_array($uitype, array (71, 72, 7, 9, 90)))
        {
            $value = '<span align="right">'.$value.'</div>';
        }

        return $value;
    }

    function getTableHeaderNavigation($navigation_array, $url_qry, $module = '', $action_val = 'index', $viewid = '')
    {
        global $app_strings;
        global $theme, $current_user;
        $theme_path = "themes/".$theme."/";
        $image_path = $theme_path."images/";
        if ($module == 'Documents')
        {
            $output = '<td class="mailSubHeader" width="100%" align="center">';
        }
        else
        {
            $output = '<td align="right" style="padding: 5px;">';
        }
        $tabname    = getParentTab();
        $url_string = '';
        if ($module == 'Calendar' && $action_val == 'index')
        {
            if ($_REQUEST['view'] == '')
            {
                if ($current_user->activity_view == "This Year")
                {
                    $mysel = 'year';
                }
                else if ($current_user->activity_view == "This Month")
                {
                    $mysel = 'month';
                }
                else if ($current_user->activity_view == "This Week")
                {
                    $mysel = 'week';
                }
                else
                {
                    $mysel = 'day';
                }
            }
            $data_value = date('Y-m-d H:i:s');
            preg_match('/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/', $data_value, $value);
            $date_data = Array (
                'day'   => $value[3],
                'month' => $value[2],
                'year'  => $value[1],
                'hour'  => $value[4],
                'min'   => $value[5],
            );
            $tab_type  = ($_REQUEST['subtab'] == '') ? 'event' : $_REQUEST['subtab'];
            $url_string .= isset($_REQUEST['view']) ? "&view=".$_REQUEST['view'] : "&view=".$mysel;
            $url_string .= isset($_REQUEST['subtab']) ? "&subtab=".$_REQUEST['subtab'] : '';
            $url_string .= isset($_REQUEST['viewOption']) ? "&viewOption=".$_REQUEST['viewOption'] : '&viewOption=listview';
            $url_string .= isset($_REQUEST['day']) ? "&day=".$_REQUEST['day'] : '&day='.$date_data['day'];
            $url_string .= isset($_REQUEST['week']) ? "&week=".$_REQUEST['week'] : '';
            $url_string .= isset($_REQUEST['month']) ? "&month=".$_REQUEST['month'] : '&month='.$date_data['month'];
            $url_string .= isset($_REQUEST['year']) ? "&year=".$_REQUEST['year'] : "&year=".$date_data['year'];
            $url_string .= isset($_REQUEST['n_type']) ? "&n_type=".$_REQUEST['n_type'] : '';
            $url_string .= isset($_REQUEST['search_option']) ? "&search_option=".$_REQUEST['search_option'] : '';
        }
        if ($module == 'Calendar' && $action_val != 'index') //added for the All link from the homepage -- ticket 5211
            $url_string .= isset($_REQUEST['from_homepage']) ? "&from_homepage=".$_REQUEST['from_homepage'] : '';
        if (($navigation_array['prev']) != 0)
        {
            if ($module == 'Calendar' && $action_val == 'index')
            {
                //$output .= '<a href="index.php?module=Calendar&action=index&start=1'.$url_string.'" alt="'.$app_strings['LBL_FIRST'].'" title="'.$app_strings['LBL_FIRST'].'"><img src="themes/images/start.gif" border="0" align="absmiddle"></a>&nbsp;';
                $output .= '<a href="javascript:;" onClick="cal_navigation(\''.$tab_type.'\',\''.$url_string.'\',\'&start=1\');" alt="'.$app_strings['LBL_FIRST'].'" title="'.$app_strings['LBL_FIRST'].'"><img src="'.vtiger_imageurl('start.gif', $theme).'" border="0" align="absmiddle"></a>&nbsp;';
                //$output .= '<a href="index.php?module=Calendar&action=index&start='.$navigation_array['prev'].$url_string.'" alt="'.$app_strings['LNK_LIST_PREVIOUS'].'"title="'.$app_strings['LNK_LIST_PREVIOUS'].'"><img src="themes/images/previous.gif" border="0" align="absmiddle"></a>&nbsp;';
                $output .= '<a href="javascript:;" onClick="cal_navigation(\''.$tab_type.'\',\''.$url_string.'\',\'&start='.$navigation_array['prev'].'\');" alt="'.$app_strings['LBL_FIRST'].'" title="'.$app_strings['LBL_FIRST'].'"><img src="'.vtiger_imageurl('start.gif', $theme).'" border="0" align="absmiddle"></a>&nbsp;';
            }
            else if ($action_val == "FindDuplicate")
            {
                $output .= '<a href="javascript:;" onClick="getDuplicateListViewEntries_js(\''.$module.'\',\'parenttab='.$tabname.'&start=1'.$url_string.'\');" alt="'.$app_strings['LBL_FIRST'].'" title="'.$app_strings['LBL_FIRST'].'"><img src="'.vtiger_imageurl('start.gif', $theme).'" border="0" align="absmiddle"></a>&nbsp;';
                $output .= '<a href="javascript:;" onClick="getDuplicateListViewEntries_js(\''.$module.'\',\'parenttab='.$tabname.'&start='.$navigation_array['prev'].$url_string.'\');" alt="'.$app_strings['LNK_LIST_PREVIOUS'].'"title="'.$app_strings['LNK_LIST_PREVIOUS'].'"><img src="'.vtiger_imageurl('previous.gif', $theme).'" border="0" align="absmiddle"></a>&nbsp;';
            }
            elseif ($action_val == 'UnifiedSearch')
            {
                $output .= '<a href="javascript:;" onClick="getUnifiedSearchEntries_js(\''.$module.'\',\'parenttab='.$tabname.'&start=1'.$url_string.'\');" alt="'.$app_strings['LBL_FIRST'].'" title="'.$app_strings['LBL_FIRST'].'"><img src="'.vtiger_imageurl('start.gif', $theme).'" border="0" align="absmiddle"></a>&nbsp;';
                $output .= '<a href="javascript:;" onClick="getUnifiedSearchEntries_js(\''.$module.'\',\'parenttab='.$tabname.'&start='.$navigation_array['prev'].$url_string.'\');" alt="'.$app_strings['LNK_LIST_PREVIOUS'].'"title="'.$app_strings['LNK_LIST_PREVIOUS'].'"><img src="'.vtiger_imageurl('previous.gif', $theme).'" border="0" align="absmiddle"></a>&nbsp;';
            }
            elseif ($module == 'Documents')
            {
                $output .= '<a href="javascript:;" onClick="getListViewEntries_js(\''.$module.'\',\'parenttab='.$tabname.'&start=1'.$url_string.'\');" alt="'.$app_strings['LBL_FIRST'].'" title="'.$app_strings['LBL_FIRST'].'"><img src="'.vtiger_imageurl('start.gif', $theme).'" border="0" align="absmiddle"></a>&nbsp;';
                $output .= '<a href="javascript:;" onClick="getListViewEntries_js(\''.$module.'\',\'parenttab='.$tabname.'&start='.$navigation_array['prev'].$url_string.'&folderid='.$action_val.'\');" alt="'.$app_strings['LNK_LIST_PREVIOUS'].'"title="'.$app_strings['LNK_LIST_PREVIOUS'].'"><img src="'.vtiger_imageurl('previous.gif', $theme).'" border="0" align="absmiddle"></a>&nbsp;';
            }
            else
            {
                $output .= '<a href="javascript:;" onClick="getListViewEntries_js(\''.$module.'\',\'parenttab='.$tabname.'&start=1'.$url_string.'\');" alt="'.$app_strings['LBL_FIRST'].'" title="'.$app_strings['LBL_FIRST'].'"><img src="'.vtiger_imageurl('start.gif', $theme).'" border="0" align="absmiddle"></a>&nbsp;';
                $output .= '<a href="javascript:;" onClick="getListViewEntries_js(\''.$module.'\',\'parenttab='.$tabname.'&start='.$navigation_array['prev'].$url_string.'\');" alt="'.$app_strings['LNK_LIST_PREVIOUS'].'"title="'.$app_strings['LNK_LIST_PREVIOUS'].'"><img src="'.vtiger_imageurl('previous.gif', $theme).'" border="0" align="absmiddle"></a>&nbsp;';
            }
        }
        else
        {
            $output .= '<img src="'.vtiger_imageurl('start_disabled.gif', $theme).'" border="0" align="absmiddle">&nbsp;';
            $output .= '<img src="'.vtiger_imageurl('previous_disabled.gif', $theme).'" border="0" align="absmiddle">&nbsp;';
        }
        if ($module == 'Calendar' && $action_val == 'index')
        {
            $jsNavigate = "cal_navigation('$tab_type','$url_string','&start='+this.value);";
        }
        else if ($action_val == "FindDuplicate")
        {
            $jsNavigate = "getDuplicateListViewEntries_js('$module','parenttab=$tabname&start='+this.value+'$url_string');";
        }
        elseif ($action_val == 'UnifiedSearch')
        {
            $jsNavigate = "getUnifiedSearchEntries_js('$module','parenttab=$tabname&start='+this.value+'$url_string');";
        }
        elseif ($module == 'Documents')
        {
            $jsNavigate = "getListViewEntries_js('$module','parenttab=$tabname&start='+this.value+'$url_string&folderid=$action_val');";
        }
        else
        {
            $jsNavigate = "getListViewEntries_js('$module','parenttab=$tabname&start='+this.value+'$url_string');";
        }
        if ($module == 'Documents')
        {
            $url = '&folderid='.$action_val;
        }
        else
        {
            $url = '';
        }
        $jsHandler = "return VT_disableFormSubmit(event);";
        $output .= "<input class='small' name='pagenum' type='text' value='{$navigation_array['current']}'
		style='width: 3em;margin-right: 0.7em;' onchange=\"$jsNavigate\"
		onkeypress=\"$jsHandler\">";
        $output .= "<span name='".$module."_listViewCountContainerName' class='small' style='white-space: nowrap;'>";
        $output .= $app_strings['LBL_LIST_OF'].' '.$navigation_array['verylast'].'</span>';
        if (($navigation_array['next']) != 0)
        {
            if ($module == 'Calendar' && $action_val == 'index')
            {
                //$output .= '<a href="index.php?module=Calendar&action=index&start='.$navigation_array['next'].$url_string.'" alt="'.$app_strings['LNK_LIST_NEXT'].'" title="'.$app_strings['LNK_LIST_NEXT'].'"><img src="themes/images/next.gif" border="0" align="absmiddle"></a>&nbsp;';
                $output .= '<a href="javascript:;" onClick="cal_navigation(\''.$tab_type.'\',\''.$url_string.'\',\'&start='.$navigation_array['next'].'\');" alt="'.$app_strings['LNK_LIST_NEXT'].'" title="'.$app_strings['LNK_LIST_NEXT'].'"><img src="'.vtiger_imageurl('next.gif', $theme).'" border="0" align="absmiddle"></a>&nbsp;';
                //$output .= '<a href="index.php?module=Calendar&action=index&start='.$navigation_array['verylast'].$url_string.'" alt="'.$app_strings['LBL_LAST'].'" title="'.$app_strings['LBL_LAST'].'"><img src="themes/images/end.gif" border="0" align="absmiddle"></a>&nbsp;';
                $output .= '<a href="javascript:;" onClick="cal_navigation(\''.$tab_type.'\',\''.$url_string.'\',\'&start='.$navigation_array['verylast'].'\');" alt="'.$app_strings['LBL_LAST'].'" title="'.$app_strings['LBL_LAST'].'"><img src="'.vtiger_imageurl('end.gif', $theme).'" border="0" align="absmiddle"></a>&nbsp;';
            }
            else if ($action_val == "FindDuplicate")
            {
                $output .= '<a href="javascript:;" onClick="getDuplicateListViewEntries_js(\''.$module.'\',\'parenttab='.$tabname.'&start='.$navigation_array['next'].$url_string.'\');" alt="'.$app_strings['LNK_LIST_NEXT'].'" title="'.$app_strings['LNK_LIST_NEXT'].'"><img src="'.vtiger_imageurl('next.gif', $theme).'" border="0" align="absmiddle"></a>&nbsp;';
                $output .= '<a href="javascript:;" onClick="getDuplicateListViewEntries_js(\''.$module.'\',\'parenttab='.$tabname.'&start='.$navigation_array['verylast'].$url_string.'\');" alt="'.$app_strings['LBL_LAST'].'" title="'.$app_strings['LBL_LAST'].'"><img src="'.vtiger_imageurl('end.gif', $theme).'" border="0" align="absmiddle"></a>&nbsp;';
            }
            elseif ($action_val == 'UnifiedSearch')
            {
                $output .= '<a href="javascript:;" onClick="getUnifiedSearchEntries_js(\''.$module.'\',\'parenttab='.$tabname.'&start='.$navigation_array['next'].$url_string.'\');" alt="'.$app_strings['LNK_LIST_NEXT'].'" title="'.$app_strings['LNK_LIST_NEXT'].'"><img src="'.vtiger_imageurl('next.gif', $theme).'" border="0" align="absmiddle"></a>&nbsp;';
                $output .= '<a href="javascript:;" onClick="getUnifiedSearchEntries_js(\''.$module.'\',\'parenttab='.$tabname.'&start='.$navigation_array['verylast'].$url_string.'\');" alt="'.$app_strings['LBL_LAST'].'" title="'.$app_strings['LBL_LAST'].'"><img src="themes/images/end.gif" border="0" align="absmiddle"></a>&nbsp;';
            }
            elseif ($module == 'Documents')
            {
                $output .= '<a href="javascript:;" onClick="getListViewEntries_js(\''.$module.'\',\'parenttab='.$tabname.'&start='.$navigation_array['next'].$url_string.'&folderid='.$action_val.'\');" alt="'.$app_strings['LNK_LIST_NEXT'].'" title="'.$app_strings['LNK_LIST_NEXT'].'"><img src="'.vtiger_imageurl('next.gif', $theme).'" border="0" align="absmiddle"></a>&nbsp;';
                $output .= '<a href="javascript:;" onClick="getListViewEntries_js(\''.$module.'\',\'parenttab='.$tabname.'&start='.$navigation_array['verylast'].$url_string.'&folderid='.$action_val.'\');" alt="'.$app_strings['LBL_LAST'].'" title="'.$app_strings['LBL_LAST'].'"><img src="'.vtiger_imageurl('end.gif', $theme).'" border="0" align="absmiddle"></a>&nbsp;';
            }
            else
            {
                $output .= '<a href="javascript:;" onClick="getListViewEntries_js(\''.$module.'\',\'parenttab='.$tabname.'&start='.$navigation_array['next'].$url_string.'\');" alt="'.$app_strings['LNK_LIST_NEXT'].'" title="'.$app_strings['LNK_LIST_NEXT'].'"><img src="'.vtiger_imageurl('next.gif', $theme).'" border="0" align="absmiddle"></a>&nbsp;';
                $output .= '<a href="javascript:;" onClick="getListViewEntries_js(\''.$module.'\',\'parenttab='.$tabname.'&start='.$navigation_array['verylast'].$url_string.'\');" alt="'.$app_strings['LBL_LAST'].'" title="'.$app_strings['LBL_LAST'].'"><img src="'.vtiger_imageurl('end.gif', $theme).'" border="0" align="absmiddle"></a>&nbsp;';
            }
        }
        else
        {
            $output .= '<img src="'.vtiger_imageurl('next_disabled.gif', $theme).'" border="0" align="absmiddle">&nbsp;';
            $output .= '<img src="'.vtiger_imageurl('end_disabled.gif', $theme).'" border="0" align="absmiddle">&nbsp;';
        }
        $output .= '</td>';
        if ($navigation_array['first'] == '')
            return;
        else
            return $output;
    }

    function decode_html($str)
    {
        global $default_charset;
        if ($_REQUEST['action'] == 'Popup' || $_REQUEST['file'] == 'Popup')
            return html_entity_decode($str);
        else
            return html_entity_decode($str, ENT_QUOTES, $default_charset);
    }

    function decode_html_force($str)
    {
        global $default_charset;

        return html_entity_decode($str, ENT_QUOTES, $default_charset);
    }

    function popup_decode_html($str)
    {
        global $default_charset;
        $slashes_str = popup_from_html($str);
        $slashes_str = htmlspecialchars($slashes_str, ENT_QUOTES, $default_charset);

        return decode_html(br2nl($slashes_str));
    }

    function textlength_check($field_val)
    {
        global $listview_max_textlength, $default_charset;
        if ($listview_max_textlength)
        {
            $temp_val = preg_replace("/(<\/?)(\w+)([^>]*>)/i", "", $field_val);
            if (function_exists('mb_strlen'))
            {
                if (mb_strlen($default_charset) > $listview_max_textlength)
                {
                    $temp_val = mb_substr(preg_replace("/(<\/?)(\w+)([^>]*>)/i", "", $field_val), 0,
                                          $listview_max_textlength, $default_charset).'...';
                }
            }
            elseif (strlen($field_val) > $listview_max_textlength)
            {
                $temp_val = substr(preg_replace("/(<\/?)(\w+)([^>]*>)/i", "", $field_val), 0, $listview_max_textlength).'...';
            }
        }
        else
        {
            $temp_val = $field_val;
        }

        return $temp_val;
    }
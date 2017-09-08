<?php

    class ListViewController
    {
        private $queryGenerator;
        private $nameList;
        private $typeList;
        private $ownerNameList;
        private $user;
        private $picklistValueMap;
        private $picklistRoleMap;
        private $headerSortingEnabled;
        private $customapprovaltabs = array();
        public  $addonSearchFilter = array ();

        public function __construct($user, $generator)
        {
            $this->queryGenerator       = $generator;
            $this->user                 = $user;
            $this->nameList             = array ();
            $this->typeList             = array ();
            $this->ownerNameList        = array ();
            $this->picklistValueMap     = array ();
            $this->picklistRoleMap      = array ();
            $this->headerSortingEnabled = true;
            $this->category             = array ();
            $this->productinventory     = array ();
            $this->productsprice        = array ();
        }

        public function setupAccessiblePicklistValueList($name)
        {
            require_once('modules/PickList/PickListUtils.php');
            $this->picklistRoleMap[$name] = true;
            if ($this->picklistRoleMap[$name])
            {
                $this->picklistValueMap[$name] = getAssignedPicklistValues($name, $this->user->roleid, $this->db);
            }
        }

        public function fetchNameList($field, $result)
        {
            $referenceFieldInfoList = $this->queryGenerator->getReferenceFieldInfoList();
            $fieldName              = $field->getFieldName();
            $idList                 = array ();
            foreach ($result as $result_info)
            {
                $id = $result_info->my->$fieldName;
                if (!isset($this->nameList[$fieldName][$id]) && $id)
                {
                    if (is_numeric($id))
                    {
                        $idList[$id] = $id;
                    }
                    elseif (is_array($id))
                    {
                        foreach ($id as $subid)
                        {
                            if (is_numeric($subid))
                            {
                                $idList[$subid] = $subid;
                            }
                        }
                    }
                }
            }
            $idList = array_keys($idList);
            if (count($idList) == 0)
            {
                return;
            }
            $moduleList = $referenceFieldInfoList[$fieldName];
            foreach ($moduleList as $module)
            {
                $meta = $this->queryGenerator->getMeta($module);
                if ($meta->isModuleEntity())
                {
                    if ($module == 'Users')
                    {
                        $nameList = getOwnerNameList($idList);
                    }
                    else
                    {
                        //TODO handle multiple module names overriding each other.
                        $nameList = getEntityName($module, $idList);
                    }
                }
                else
                {
                    $nameList = vtws_getActorEntityName($module, $idList);
                }
                $entityTypeList = array_intersect(array_keys($nameList), $idList);
                /*			foreach ($entityTypeList as $id) {
				$this->typeList[$id] = $module;
			}
*/
                if (empty($this->nameList[$fieldName]))
                {
                    $this->nameList[$fieldName] = array ();
                }
                foreach ($entityTypeList as $id)
                {
                    $this->typeList[$id]             = $module;
                    $this->nameList[$fieldName][$id] = $nameList[$id];
                }
            }
        }
        function getListViewEntries($focus, $module, $result, $navigationInfo, $needChange = false)
        { 
			global $global_user_privileges;
            $is_admin  = $global_user_privileges["is_admin"];
            $user_info = $global_user_privileges['user_info'];
            global $listview_max_textlength, $theme, $default_charset;
            $fields              = $this->queryGenerator->getFields();
            $meta                = $this->queryGenerator->getMeta($this->queryGenerator->getModule());
            $moduleFields        = $meta->getModuleFields();
            $accessibleFieldList = array_keys($moduleFields);
            $listViewFields      = array_intersect($fields, $accessibleFieldList);
            $referenceFieldList  = $this->queryGenerator->getReferenceFieldList();

            foreach ($referenceFieldList as $fieldName)
            {
                if (in_array($fieldName, $listViewFields))
                {
                    $field = $moduleFields[$fieldName];
                    $this->fetchNameList($field, $result);
                }
            }
            $ownerFieldList = $this->queryGenerator->getOwnerFieldList();
            foreach ($ownerFieldList as $fieldName)
            {
                $hideFields = (array)$needChange['hideFields'];
                if (in_array($fieldName, $hideFields))
                {
                    continue;
                }
                if (in_array($fieldName, $listViewFields))
                {
                    $field  = $moduleFields[$fieldName];
                    $idList = array ();
                    foreach ($result as $result_info)
                    {
                        if ($fieldName == 'author')
                        {
                            $id = $result_info->contributorName;
                        }
                        else
                        {
                            $id = $result_info->my->$fieldName;
                        }
                        if (!isset($this->ownerNameList[$fieldName][$id]) && isset($id))
                        {
                            if (is_array($id))
                            {
                                $idList = array_merge($idList, $id);
                            }
                            elseif ($id != null && $id != '')
                            {
                                $idList[] = $id;
                            }
                        }
                    }
                    if (count($idList) > 0)
                    {
                        if (!is_array($this->ownerNameList[$fieldName]))
                        {
                            if ($field->getUIType() == 54)
                            {
                                $this->ownerNameList[$fieldName] = getOwnerProfileNameList($idList);
                            }
                            else
                            {
                                $this->ownerNameList[$fieldName] = getOwnerNameList($idList);
                            }
                        }
                        else
                        {
                            $newOwnerList = getOwnerNameList($idList);
                            foreach ($newOwnerList as $id => $name)
                            {
                                $this->ownerNameList[$fieldName][$id] = $name;
                            }
                        }
                    }
                }
            }
            foreach ($listViewFields as $fieldName)
            {
                $field = $moduleFields[$fieldName];
                if ($field->getFieldDataType() == 'picklist' || $field->getFieldDataType() == 'multipicklist')
                {
                    $this->setupAccessiblePicklistValueList($fieldName);
                }
            }
            $ids = array ();
            foreach ($result as $result_info)
            {
                $ids[] = $result_info->id;
            }
            $data = array ();
            foreach ($result as $result_info)
            {
                if ($module != 'Users')
                {
                    $recordId = $result_info->id;
                    $ownerId  = $result_info->my->personman;
                }
                else
                {
                    $recordId = $result_info->id;
                }
                $row = array ();
                foreach ($listViewFields as $fieldName)
                {
                    $field  = $moduleFields[$fieldName];
                    $uitype = $field->getUIType();
                    $fieldDataType = $field->getFieldDataType();
                    switch ($fieldName)
                    {
                        case 'published':
                            $rawValue = $result_info->createdDate;
                            break;
                        case 'updated':
                            $rawValue = $result_info->updatedDate;
                            break;
                        case 'title':
                            $rawValue = $result_info->title;
                            break;
                        case 'author':
                            $rawValue = $result_info->contributorName;
                            break;
                        case 'xn_id':
                            $rawValue = $result_info->id;
                            break;
                        default:
                            $rawValue = $result_info->my->$fieldName;
                    }
                    $datatype = $field->getFieldType();
                    if ($rawValue != "")
                    {
                        if ($datatype == "DMTI")
                        {
                            $rawValue = date("m-d H:i", strtotime($rawValue));
                        }
                        elseif ($datatype == "TI")
                        {
                            $rawValue = date("H:i", strtotime($rawValue));
                        }
                        elseif ($datatype == "T")
                        {
                            $rawValue = date("H:i:s", strtotime($rawValue));
                        }
                        elseif ($datatype == "DM")
                        {
                            $rawValue = date("Y-m-d", strtotime($rawValue));
                        }
                        elseif ($datatype == "MD")
                        {
                            $rawValue = date("m-d", strtotime($rawValue));
                        }
                        elseif ($datatype == "YDMTI")
                        {
                            $rawValue = date("Y-m-d H:i", strtotime($rawValue));
                        }
                    }
                    $hideFields = (array)$needChange['hideFields'];
                    if (in_array($fieldName, $hideFields))
                    {
                        continue;
                    }
                    if (!is_array($rawValue) && stristr(html_entity_decode($rawValue), "<a href") === false && $uitype != 8)
                    {
                        $value = textlength_check($rawValue);
                    }
                    elseif ($uitype != 8 && !is_array($rawValue))
                    {
                        $value = html_entity_decode($rawValue, ENT_QUOTES);
                    }
                    else
                    {
                        $value = $rawValue;
                    }
                    if (strtolower($module).'status' == $fieldName)
                    {
						if ($fieldDataType == 'boolean')
	                    {
	                        if ($value == 1)
	                        {
	                            $value = getTranslatedString('yes', $module);
	                        }
	                        elseif ($value == 0)
	                        {
	                            $value = getTranslatedString('no', $module);
	                        }
	                        else
	                        {
	                            $value = '--';
	                        }
						}
						else
						{
	                        $tabid        = getTabid($module);
	                        $approvaltabs = array ();
							global $global_session; 
							$tabdata  = $global_session['tabdata']; 
	                        $approvaltabs = $tabdata['approvaltabs'];
	                        
	                        if (in_array($tabid, $approvaltabs) && $result_info->author == XN_Profile::$VIEWER)
	                        {
	                            $statusname = strtolower($module).'status';
	                            if (is_null($result_info->my->approvalstatus) && $result_info->my->$statusname != 'Terminate')
	                            {
	                                $value = '<a href="index.php?module=Approvals&action=viewApprove&record='.$result_info->id.'&mode=submit&formodule='.$module.'&from=listview"    data-toggle="dialog" data-width="600" data-height="260" data-id="dialog-mask" data-mask="true" data-resizable="false" data-maxable="false">提交审批</a>';
	                            }
	                            else
	                            {
	                                $value = getTranslatedString($rawValue);
	                            }
	                        }
	                        else
	                        {
								global $copyrights,$supplierid;
								
								if (!isset($this->customapprovaltabs[$tabid]))
								{
									if (isset($copyrights['customapproval']) && $copyrights['customapproval'] != "" &&
										isset($supplierid) && $supplierid != "")
									{
										$customapproval = $copyrights['customapproval'];
							            $customapprovals = XN_Query::create("Content")->tag($customapproval)
							                                        ->filter("type", "eic", $customapproval)
							                                        ->filter("my.deleted", "=", "0")
							                                        ->filter("my.supplierid", "=", $supplierid)
							                                        ->filter("my.customapprovalflowtabid", "=", $tabid)
							                                        ->filter("my.approvalflowsstatus", "=", '1')
							                                        ->end(1)
							                                        ->execute();
			  
									    if (count($customapprovals) > 0)
										{
											$this->customapprovaltabs[$tabid] = 1;
										}
										else
										{
											$this->customapprovaltabs[$tabid] = 0;
										}
									}
									else
									{
										$this->customapprovaltabs[$tabid] = 0;
									}
								} 
		                        if ($this->customapprovaltabs[$tabid] == 1 && $result_info->author == XN_Profile::$VIEWER)
		                        {
		                            $statusname = strtolower($module).'status';
		                            if (is_null($result_info->my->approvalstatus) && $result_info->my->$statusname != 'Terminate')
		                            {
		                                $value = '<a href="index.php?module=Approvals&action=viewApprove&record='.$result_info->id.'&mode=submit&formodule='.$module.'&from=listview"    data-toggle="dialog" data-width="600" data-height="260" data-id="dialog-mask" data-mask="true" data-resizable="false" data-maxable="false">提交审批</a>';
		                            }
		                            else
		                            {
		                                $value = getTranslatedString($rawValue);
		                            }
		                        }
								else
								{
									 $value = getTranslatedString($rawValue);
								}
	                           
	                        }
						} 
                    }
                    elseif ($module == 'Approvals' && $fieldName == 'reply')
                    {
                        $value = getTranslatedString($value);
                    }
                    elseif ($uitype == 27)
                    {
                        if ($value == 'I')
                        {
                            $value = getTranslatedString('LBL_INTERNAL', $module);
                        }
                        elseif ($value == 'E')
                        {
                            $value = getTranslatedString('LBL_EXTERNAL', $module);
                        }
                        else
                        {
                            $value = ' --';
                        }
                    }
                    elseif ($uitype == 117){
                        $value = $result_info->my->$fieldName;
                        $relation=$field->getrelationname();
                        $relation_name=$result_info->my->$relation;
                        $relation_modules=array("ma_agencys"=>"Ma_Agencys","ma_factorys"=>"Ma_Factorys","ma_hospitals"=>"Ma_Hospitals","ma_foodanddrugadmin"=>"Ma_FoodandDrugAdmin","ma_financials"=>"Ma_Financials","ma_socialsecurity"=>"Ma_SocialSecurity");
                        $module_labels=array("ma_agencys"=>"agencys_name","ma_factorys"=>"factorys_name","ma_hospitals"=>"hospitals_name","ma_foodanddrugadmin"=>"fullname","ma_financials"=>"fullname","ma_socialsecurity"=>"fullname");
                        $module_label=$module_labels[$relation_name];
                        $relation_module=$relation_modules[$relation_name];
                        try{
                            if(isset($value) && !empty($value))
                            {
                                $content    = XN_Content::load($value, $relation_name);
                                $text_value = $content->my->$module_label;
                                $value      = "<a href='index.php?module=$relation_module&action=EditView&record=$value' title='查看".getTranslatedString($relation_module)."' data-toggle='navtab' data-fresh='true' data-id='edit' data-title='".getTranslatedString($relation_module)."信息'>$text_value</a>";
                            }else{
                                $value="--";
                            }
                        }
                        catch(XN_Exception $e){
                            $value="--";
                        }
                    }
                    elseif ($fieldDataType == 'picklist')
                    {
                        if ($this->picklistValueMap[$fieldName] && in_array($value, array_values($this->picklistValueMap[$fieldName])))
                        {
                            $value = getTranslatedString($value, $module);
                            $value = textlength_check($value);
                        }
                        elseif ($this->picklistValueMap[$fieldName] && in_array($value, array_keys($this->picklistValueMap[$fieldName])))
                        {
                            $value = $this->picklistValueMap[$fieldName][$value];
                            $value = getTranslatedString($value, $module);
                            $value = textlength_check($value);
                        }
                        else
                        {
                            $value = getTranslatedString($value, $module);
                            $value = textlength_check($value);
                        }
                    }
                    elseif ($fieldDataType == 'multipicklist')
                    {
                        if (is_array($value))
                        {
                            $newvalues = array ();
                            foreach ($value as $simplevalue)
                            {
                                if ($this->picklistValueMap[$fieldName] && in_array($simplevalue, array_values($this->picklistValueMap[$fieldName])))
                                {
                                    $simplevalue = getTranslatedString($simplevalue, $module);
                                    $newvalues[] = textlength_check($simplevalue);
                                }
                                elseif ($this->picklistValueMap[$fieldName] && in_array($simplevalue, array_keys($this->picklistValueMap[$fieldName])))
                                {
                                    $simplevalue = $this->picklistValueMap[$fieldName][$simplevalue];
                                    $simplevalue = getTranslatedString($simplevalue, $module);
                                    $newvalues[] = textlength_check($simplevalue);
                                }
                                else
                                {
                                    $simplevalue = getTranslatedString($simplevalue, $module);
                                    $newvalues[] = textlength_check($simplevalue);
                                }
                            }
                            $value = join(",", $newvalues);
                        }
                        else
                        {
                            if ($this->picklistValueMap[$fieldName] && in_array($value, array_values($this->picklistValueMap[$fieldName])))
                            {
                                $value = getTranslatedString($value, $module);
                                $value = textlength_check($value);
                            }
                            elseif ($this->picklistValueMap[$fieldName] && in_array($value, array_keys($this->picklistValueMap[$fieldName])))
                            {
                                $value = $this->picklistValueMap[$fieldName][$value];
                                $value = getTranslatedString($value, $module);
                                $value = textlength_check($value);
                            }
                            else
                            {
                                $value = getTranslatedString($value, $module);
                                $value = textlength_check($value);
                            }
                        }
                    }
                    elseif ($fieldDataType == 'date')
                    {
                        if ($value != '-' && $value != '' && $value != '0000-00-00')
                        {
                            $value = date('Y-m-d', strtotime($value));
                            $value = getDisplayDate($value);
                        }
                        elseif ($value == '0000-00-00')
                        {
                            $value = '';
                        }
                    }
                    elseif ($fieldDataType == 'datetime')
                    {
                        if ($value != '-' && $value != '' && $value != '0000-00-00')
                        {
                            $value = date('Y-m-d H:i', strtotime($value));
                            $value = getDisplayDate($value);
                        }
                        elseif ($value == '0000-00-00')
                        {
                            $value = '';
                        }
                    }
                    elseif ($fieldDataType == 'url')
                    {
						$rawValue = str_replace("http://","",$rawValue);
						if ($rawValue != "")
						{
							$value = '<a href="http://'.$rawValue.'" target="_blank">'.$value.'</a>';
						}
						else
						{
							$value = '';
						}
						
                    }
                    elseif ($fieldDataType == 'boolean')
                    {
                        if ($value == 1)
                        {
                            $value = getTranslatedString('yes', $module);
                        }
                        elseif ($value == 0)
                        {
                            $value = getTranslatedString('no', $module);
                        }
                        else
                        {
                            $value = '--';
                        }
                    }
                    elseif ($uitype == 222)
                    {
                        if (!is_null($value) && $value != '')
                            $value = getTranslatedString(getModule($value), $module);
                        else
                            $value = '--';
                    }
					elseif ($uitype == 223) {
						$tab_id  = $result_info->my->tabid;
						$tabname = getModule($tab_id);
						$value = "<a rel='edit' target='navTab' href='index.php?action=EditView&module=".$tabname."&record=".$value."' data-hint='poshytip' title='查看".getTranslatedString($tabname)."' data-toggle='navtab' data-fresh='true' data-id='edit' data-title='".getTranslatedString($tabname)."信息'><i class='fa fa-file-text-o'></i></a>";
					}
					elseif ($uitype == 230)
                    {
						global $listloadprofiles;
						if (isset($listloadprofiles) && $listloadprofiles[$value] != "")
						{
							$value = $listloadprofiles[$value];
						}
						else
						{
	                        if (isset($value) && !empty($value))
	                        {
	                            try
	                            {
	                                $profileContent = XN_Content::load($value, 'profiles');
									$listloadprofiles[$value] = $profileContent->my->profilename;
	                                $value          = $profileContent->my->profilename;
	                            }
	                            catch (XN_Exception $e)
	                            {
									$listloadprofiles[$value] = '--';
	                                $value = '--';
	                            }
	                        }
	                        else
	                        {
	                            $value = '--';
	                        }
						} 
                    }
                    elseif ($uitype == 98)
                    {
                        $value = textlength_check(getRoleName($value));
                    }
                    elseif ($uitype == 66)
                    {
                        $value =  strswaptime(intval($value)); 
                    }
                    elseif ($uitype == 97)
                    {
                        $value = getRoleNameList($value);
                    }           
                    elseif ($fieldDataType == 'reference')
                    {
                        $referenceFieldInfoList = $this->queryGenerator->getReferenceFieldInfoList();
                        $moduleList             = $referenceFieldInfoList[$fieldName];
                        if (count($moduleList) == 1)
                        {
                            $parentModule = $moduleList[0];
                        }
                        else
                        {
                            $parentModule = $this->typeList[$value];
                        }
                        if (!empty($value) && !empty($this->nameList[$fieldName]) && !empty($parentModule))
                        {
                            $parentMeta = $this->queryGenerator->getMeta($parentModule);
                            if (is_array($value))
                            {
                                $newvalues = array ();
                                foreach ($value as $newvalue)
                                {
                                    $new_value = textlength_check($this->nameList[$fieldName][$newvalue]);
                                    if ($parentMeta->isModuleEntity() && $parentModule != "Users")
                                    {
                                        $new_value = "<a href='index.php?module=$parentModule&action=EditView&"."record=$newvalue' title='查看".getTranslatedString($parentModule)."' data-toggle='navtab' data-fresh='true' data-id='edit' data-title='".getTranslatedString($parentModule)."信息'>$new_value</a>";
                                    }
                                    $newvalues[] = $new_value;
                                }
                                $value = join(",", $newvalues);
                            }
                            else
                            {
                                $value = textlength_check($this->nameList[$fieldName][$value]);


                                if ($parentMeta->isModuleEntity() && $parentModule != "Users")
                                {
                                    $value = "<a href='index.php?module=$parentModule&action=EditView&opertype=edit&".
                                             "record=$rawValue' title='查看".getTranslatedString($parentModule)."' data-toggle='navtab' data-fresh='true' data-id='edit' data-title='".getTranslatedString($parentModule)."信息'>$value</a>";
                                }
                            }
                        }
                        else
                        {
                            $value = '--';
                        }
                    }
                    elseif ($fieldDataType == 'owner')
                    {
                        $owners = array ();
                        if (is_array($value))
                        {
                            foreach ($this->ownerNameList[$fieldName] as $key => $v)
                            {
                                if (in_array($key, $value))
                                {
                                    $owners[] = textlength_check($v);
                                }
                            }
                            $value = implode(',', $owners);
                        }
                        elseif ($value == "")
                        {
                            $value = "-";
                        }
                        elseif (isset($this->ownerNameList[$fieldName][$value]))
                        {
                            if ($uitype == 54)
                            {
                               /* global $current_user;
                                $label = $this->ownerNameList[$fieldName][$value];
                                if (($value != "SYSTEM") && (check_authorize("tezanadmin") || is_admin($current_user->id)))
                                {
                                    $value = '<a title="【'.$label.'】" href="index.php?module=Profile&action=EditView&profileid='.$value.'" target="navTab" rel="viewprofile">'.$label.'</a>';
                                }
                                else
                                {
                                    $value = $label;
                                }*/
							     global $copyrights;
								 if ($copyrights['program'] == 'tezan')
								 {
								 	$label = $this->ownerNameList[$fieldName][$value];
									if(isset($_SESSION['supplierid']) && $_SESSION['supplierid'] !='' && $_SESSION['supplierid'] !='0')
									{
								 	    $value = '<a data-title="【'.$label.'】" data-id="profile_'.$value.'" data-fresh="true" data-toggle="navtab" href="index.php?module=Supplier_Profile&action=EditView&profileid='.$value.'" >'.$label.'</a>';
							   		}
									else
									{
									   	$value = '<a data-title="【'.$label.'】" data-id="profile_'.$value.'" data-fresh="true" data-toggle="navtab" href="index.php?module=Profile&action=EditView&profileid='.$value.'">'.$label.'</a>';
								    } 
								 }
								 else
								 {
								 	$value = $this->ownerNameList[$fieldName][$value];
								 }
                            }
                            else
                            {
                                $value = $this->ownerNameList[$fieldName][$value];
                            }
                        }
                        else
                        {
                            $value = "-";
                        }
                    }
                    elseif ($uitype == 100)
                    {
                        if ($result_info->my->tabid != '' && $value != '')
                        {
                            $fields = XN_Query::create('Content')->tag('fields')
                                ->filter('type', 'eic', 'fields')
                                ->filter('my.tabid', '=', $result_info->my->tabid)
                                ->filter('my.fieldname', '=', $value)
                                ->end(-1)
                                ->execute();
                            if (count($fields) > 0)
                            {
                                $field_info = $fields[0];
                                $submodule  = getModule($result_info->my->tabid);
                                $value      = getTranslatedString($field_info->my->fieldlabel, $submodule);
                            }
                        }
                    }
                    elseif ($uitype == 7)
                    {
                        $value = formatnumber($value);
                    }
                    elseif ($uitype == 20)
                    {
                        $value = subtext_check($value,60);
                    }
                    elseif ($uitype == 305)
                    {
                        if ($_SERVER['HTTPS'])
                        {
                            $http = "https://";
                        }
                        else
                        {
                            $http = "http://";
                        }
                        if ($_SERVER['SERVER_PORT'])
                        {
                            $port = ":".$_SERVER['SERVER_PORT'];
                        }
                        else
                        {
                            $port = ":80";
                        }
                        $domain = $http.$_SERVER['SERVER_NAME'].$port;
                        if ($value == "")
                        {
                            $imglink = $domain."/Public/Images/person.png";
                        }
                        elseif (strpos($value, "http://", 0) == 0)
                        {
                            $imglink = $value;
                        }
                        else
                        {
                            if ($fp = @fopen($domain.$value, 'r'))
                            {
                                fclose($fp);
                                $size = getimagesize($domain.$value);
                                if (!$size)
                                {
                                    $imglink = $domain."/Public/Images/person.png";
                                }
                                else
                                {
                                    $imglink = $domain.$value;
                                }
                            }
                            else
                            {
                                $imglink = $domain."/Public/Images/person.png";
                            }
                        }
                        $value = '
						<a href="'.$imglink.'"  data-lightbox="roadtrip" title="" ><img align="absmiddle" width="32" height="32" title="点击查看大图" src="'.$imglink.'"></a> ';
                        $value .= '<style>.grid .gridTbody td div { height: auto; }</style>';
                    }
                    elseif ($uitype == 300)
                    {
						$func = "listview_custom_func"; 
						if (function_exists($func))
						{
							try
							{
								$value  = $func($fieldName,$result_info); 
							}
							catch (XN_Exception $e)
							{
								 
							} 
						}  
                    }
                    if ($uitype == 4)
                    {
                        if ($fieldName == "oper")
                        {
                            $value = "<a rel='edit' target='navTab' href='index.php?module=".$module."&action=EditView&record=".$recordId."' title='查看".getTranslatedString($module)."' data-hint='poshytip' data-toggle='navtab' data-fresh='true' data-id='edit' data-title='".getTranslatedString($module)."信息'><i class='fa fa-file-text-o'></i></a>";
                        }
                        else
                        {
                            if(!in_array("oper",$listViewFields))
                            {
                                $value = "<a rel='edit' target='navTab' href='index.php?module=".$module."&action=EditView&record=".$recordId."' title='查看".getTranslatedString($module)."' data-toggle='navtab' data-fresh='true' data-id='edit' data-hint='poshytip' data-title='".getTranslatedString($module)."信息'>".$value."</a>";
                            }
                        }
                    }
                    // END
                    $row[$fieldName] = $value;
                }
                $data[$recordId] = $row;
            }

            return $data;
        }

        public function getListViewHeader($focus, $module, $sort_qry = '', $sorder = '', $orderBy = '', $needChange = false, $skiplink = false)
        {
            global $singlepane_view;
            $header  = Array ();
            $tabid   = getTabid($module);
            $tabname = getParentTab();
            global $current_user;
            $fields              = $this->queryGenerator->getFields();
            $meta                = $this->queryGenerator->getMeta($this->queryGenerator->getModule());
            $moduleFields        = $meta->getModuleFields();
            $accessibleFieldList = array_keys($moduleFields);
            $listViewFields      = array_intersect($fields, $accessibleFieldList);
            $totalwidth          = 0;
            $hideFields          = (array)$needChange['hideFields'];
            $operates            = $needChange['operates']['header'];
            foreach ($listViewFields as $fieldName)
            {
                if (in_array($fieldName, $hideFields))
                {
                    continue;
                }
                $field = $moduleFields[$fieldName]; 
                $width = $field->getWidth();
                $totalwidth += $width;  
            } 
            if (count($operates))
            {
                $totalwidth += $operates['width'];
            } 
            foreach ($listViewFields as $fieldName)
            {
                if (in_array($fieldName, $hideFields))
                {
                    continue;
                }
                $field = $moduleFields[$fieldName];
                $label = getTranslatedString($field->getFieldLabelKey(), $module);
                if (in_array($fieldName, $focus->sortby_fields) || $fieldName == 'published' || $fieldName == 'author')
                {
                    $sort = 'true';
                }
                else
                {
                    $sort = 'false';
                }
                $width = round($field->getWidth() * 100 / $totalwidth, 2); 
                $align              = $field->getAlign();
                $header[$fieldName] = array ('label' => $label, 'sort' => $sort, 'width' => $width, 'align' => $align);
            }
            if (count($operates))
            {
                $width              = round($operates['width'] * 100 / $totalwidth, 2);
                $header['operates'] = array ('label' => $operates['label'], 'sort' => $operates['sort'], 'width' => $width, 'align' => $operates['align']);
            }

            return $header;
        }
    }


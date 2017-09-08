<?php
    global $app_strings, $mod_strings;
    define("CV_STATUS_DEFAULT", 0);
    define("CV_STATUS_PRIVATE", 1);
    define("CV_STATUS_PENDING", 2);
    define("CV_STATUS_PUBLIC", 3);
    require_once('include/MetaField.php');
    require_once('include/CRMEntityMeta.php');

    class CustomView extends CRMEntity
    {
        var       $module_list = Array ();
        var       $customviewmodule;
        var       $mandatoryvalues;
        var       $data_type;
        var       $essentialField;
        protected $_status     = false;
        protected $_userid     = false;
        protected $_init       = 0;
        protected $meta;
        protected $moduleMetaInfo;

        function __construct($module = "")
        {
            global $current_user;
            $this->customviewmodule = $module;
            $this->moduleMetaInfo   = array ();
            if ($module != "" && $module != 'Calendar')
            {
                $this->meta = $this->getMeta($module, $current_user);
            }
        }

        public function getMeta($module, $user)
        {
            if (empty($this->moduleMetaInfo[$module]))
            {
                $meta                          = CRMEntityMeta::fromName($module, $user);
                $this->moduleMetaInfo[$module] = $meta;
            }

            return $this->moduleMetaInfo[$module];
        }

        function getViewId($module)
        {
            global $current_user;
            $now_action = $_REQUEST['action'];
            if (empty($_REQUEST['viewid']))
            {
                if (isset($_SESSION['lvs'][$module]["viewid"]) && $_SESSION['lvs'][$module]["viewid"] != '')
                {
                    $viewid = $_SESSION['lvs'][$module]["viewid"];
                }
                else
                {
                    $fieldsquery = XN_Query::create('Content')->tag('Customviews')
                        ->filter('type', 'eic', 'customviews')
                        ->filter('my.entitytype', 'in', array ($module))
                        ->filter('my.setdefault', '=', '1')
                        ->execute();
                    if (count($fieldsquery) > 0)
                    {
                        $viewid = $fieldsquery[0]->id;
                    }
                    else
                    {
                        $viewid = '';
                    }
                }
                if ($viewid == '' || $viewid == 0)
                {
                    $fieldsquery = XN_Query::create('Content')->tag('Customviews')
                        ->filter('type', 'eic', 'customviews')
                        ->filter('my.entitytype', 'in', array ($module))
                        ->filter('my.viewname', 'in', array ('All', 'Default'));
                    $customviews = $fieldsquery->execute();
                    foreach ($customviews as $customviews_info)
                    {
                        $viewid = $customviews_info->id;
                    }
                }
            }
            else
            {
                $viewid = $_REQUEST['viewid'];
                if ($viewid == 0 || $viewid == "")
                {
                    $viewid = $this->getViewIdByName('All', $module);
                }
            }
            $_SESSION['lvs'][$module]["viewid"] = $viewid;

            return $viewid;
        }

        function getViewIdByName($viewname, $module)
        {
            if (isset($viewname))
            {
                $fieldsquery = XN_Query::create('Content')->tag('Customviews')
                    ->filter('type', 'eic', 'customviews')
                    ->filter('my.entitytype', '=', $module)
                    ->filter('my.viewname', '=', $viewname);
                $customviews = $fieldsquery->execute();
                foreach ($customviews as $customviews_info)
                {
                    $viewid = $customviews_info->id;
                }

                return $viewid;
            }
            else
            {
                return 0;
            }
        }

        function getViewNameById($viewid)
        {
            if (isset($viewid))
            {
                try
                {
                    $customviews_info = XN_Content::load($viewid, "customviews");

                    return $customviews_info->my->viewname;
                }
                catch (XN_Exception $e)
                {
                    return "";
                }
            }
            else
            {
                return "";
            }
        }

        function getCustomViewByCvid($cvid)
        {
            global $current_user;
            try
            {
                $customviews_info              = XN_Content::load($cvid, 'Customviews');
                $customviewlist                = array ();
                $customviewlist ["viewname"]   = $customviews_info->my->viewname;
                $customviewlist ["setdefault"] = $customviews_info->my->setdefault;
                $customviewlist ["setmetrics"] = $customviews_info->my->setmetrics;
                $customviewlist ["userid"]     = $customviews_info->my->userid;
                $customviewlist ["status"]     = $customviews_info->my->status;

                return $customviewlist;
            }
            catch (XN_Exception $e)
            {
                return array ();
            }
        }

        function getCustomViewCombo($viewid = '', $markselected = true)
        {
            global $current_user;
            global $app_strings;
            global $global_user_privileges;
            $is_admin = $global_user_privileges["is_admin"];
             
            $shtml_user    = '';
            $shtml_pending = '';
            $shtml_public  = '';
            $shtml_others  = '';
            $selected      = 'selected';
            if ($markselected == false)
                $selected = '';
            $customviewsquery = XN_Query::create('Content')->tag('Customviews')
                ->filter('type', 'eic', 'customviews')
                ->filter('my.entitytype', '=', $this->customviewmodule)
                ->order('my.viewname', XN_Order::ASC);
            $customviews      = $customviewsquery->execute();
            foreach ($customviews as $customviews_info)
            {
                $viewname = $customviews_info->my->viewname;
                if ($customviews_info->my->viewname == 'All')
                {
                    $viewname = $app_strings['COMBO_ALL'];
                }
                else
                {
                    $viewname = getTranslatedString($viewname);
                }
                $option = '';
                if ($customviews_info->my->status == CV_STATUS_DEFAULT || $customviews_info->my->userid == $current_user->id)
                {
                    $disp_viewname = $viewname;
                }
                else
                {
                    $disp_viewname = $viewname." [".getUserName($customviews_info->my->userid)."] ";
                }
                if ($customviews_info->my->setdefault == 1 && $viewid == '')
                {
                    $option = "<option $selected value=\"".$customviews_info->id."\">".$disp_viewname."</option>";
                }
                elseif ($customviews_info->id == $viewid)
                {
                    $option = "<option $selected value=\"".$customviews_info->id."\">".$disp_viewname."</option>";
                }
                else
                {
                    $option = "<option value=\"".$customviews_info->id."\">".$disp_viewname."</option>";
                }
                if ($option != '')
                {
                    if ($customviews_info->my->status == CV_STATUS_DEFAULT || $customviews_info->my->userid == $current_user->id)
                    {
                        $shtml_user .= $option;
                    }
                    elseif ($customviews_info->my->status == CV_STATUS_PUBLIC)
                    {
                        $shtml_public .= $option;
                    }
                }
            }
            $shtml = $shtml_user;
            if ($is_admin == true)
                $shtml .= $shtml_pending;
            $shtml = $shtml.$shtml_public.$shtml_others;

            return $shtml;
        }

        function getModuleColumnsList($module)
        {
            $module_info = $this->getCustomViewModuleInfo($module);
            foreach ($this->module_list[$module] as $key => $value)
            {
                $columnlist = $this->getColumnsListbyBlock($module, $value);
                if (isset($columnlist))
                {
                    $ret_module_list[$module][$key] = $columnlist;
                }
            }

            return $ret_module_list;
        }

        function getCustomViewModuleInfo($module)
        {
            global $current_language;
            $current_mod_strings = return_specified_module_language($current_language, $module);
            $block_info          = Array ();
            $modules_list        = explode(",", $module);
            if ($module == "Calendar")
            {
                $module       = "Calendar','Events";
                $modules_list = array ('Calendar', 'Events');
            }
            $skipBlocksList = array ();
            $result         = array ();
            try
            {
                $tabsquery = XN_Query::create('Content')->tag('Tabs')
                    ->filter('type', 'eic', 'tabs')
                    ->filter('my.tabname', 'in', $modules_list)
                    ->execute();
                foreach ($tabsquery as $tabs_info)
                {
                    $tabsid      = $tabs_info->my->tabid;
                    $tabsname    = $tabs_info->my->tabname;
                    $blocksquery = XN_Query::create('Content')->tag('Blocks')
                        ->filter('type', 'eic', 'blocks')
                        ->filter('my.tabid', '=', $tabsid)
                        ->filter('my.visible', '=', '0')
                        ->execute();
                    $blockids    = array ();
                    $blocks      = array ();
                    foreach ($blocksquery as $blocks_info)
                    {
                        $blockids[]                        = $blocks_info->my->blockid;
                        $blocks[$blocks_info->my->blockid] = $blocks_info->my->blocklabel;
                    }
                    if (count($blockids) > 0)
                    {
                        $fieldsquery = XN_Query::create('Content')->tag('Fields')
                            ->filter('type', 'eic', 'fields')
                            ->filter('my.tabid', '=', $tabsid)
                            ->filter('my.block', 'in', $blockids)
                            ->order('my.block', XN_Order::ASC_NUMBER)
                            ->end(-1)
                            ->execute();
                        foreach ($fieldsquery as $fields_info)
                        {
                            $id = $fields_info->my->block;
                            if (!array_key_exists($id, $result))
                            {
                                $result[$id]['block']      = $id;
                                $result[$id]['tabid']      = $tabsid;
                                $result[$id]['name']       = $tabsname;
                                $result[$id]['blocklabel'] = $blocks[$id];
                            }
                        }
                    }
                }
            }
            catch (XN_Exception $e)
            {
            }
            if ($module == "Calendar','Events")
                $module = "Calendar";
            $pre_block_label = '';
            foreach ($result as $block_result)
            {
                $block_label = $block_result['blocklabel'];
                $tabid       = $block_result['tabid'];
                if (array_key_exists($tabid, $skipBlocksList) && in_array($block_label, $skipBlocksList[$tabid]))
                    continue;
                if (trim($block_label) == '')
                {
                    $block_info[$pre_block_label] = $block_info[$pre_block_label].",".$block_result['block'];
                }
                else
                {
                    $lan_block_label = $current_mod_strings[$block_label];
                    if (isset($block_info[$lan_block_label]) && $block_info[$lan_block_label] != '')
                    {
                        $block_info[$lan_block_label] = $block_info[$lan_block_label].",".$block_result['block'];
                    }
                    else
                    {
                        $block_info[$lan_block_label] = $block_result['block'];
                    }
                }
                $pre_block_label = $lan_block_label;
            }
            $this->module_list[$module] = $block_info;

            return $this->module_list;
        }

        function getColumnsListbyBlock($module, $block)
        {
            global $current_user, $mod_strings, $app_strings;
            $block_ids = explode(",", $block);
            $tabid     = getTabid($module);
            global $global_user_privileges;
            $is_admin                = $global_user_privileges["is_admin"];
            $profileGlobalPermission = $global_user_privileges['profileGlobalPermission'];
             
            if (empty($this->meta))
            {
                $this->meta = $this->getMeta($module, $current_user);
            }
            $query = XN_Query::create('Content')->tag('Fields')
                ->filter('type', 'eic', 'fields')
                ->filter('my.displaytype', 'in', array (1, 2, 3))
                ->filter('my.presence', 'in', array (0, 2))
                ->end(-1)
                ->order('sequence', XN_Order::ASC_NUMBER);
			global $global_session; 
			$tabdata  = $global_session['tabdata']; 
            $all_tabs_array        = $tabdata['all_tabs_array'];
            $all_entity_tabs_array = $tabdata['all_entity_tabs_array'];
            
            if ($is_admin == false && in_array($module, array_values($all_tabs_array)) &&
                !in_array($module, array_values($all_entity_tabs_array))
            )
            {
                $is_admin = true;
            }
            if ($is_admin == true || $profileGlobalPermission[1] == 0 || $profileGlobalPermission[2] == 0)
            {
                $tab_ids = explode(",", $tabid);
                $query->filter('my.tabid', 'in', $tab_ids)
                    ->filter('my.block', 'in', $block_ids);
            }
            else
            {
                $tab_ids     = explode(",", $tabid);
                $profileList = getCurrentUserProfileList();
                $p2f         = XN_Query::create('Content')->tag('Profile2fields')
                    ->filter('type', 'eic', 'profile2fields')
                    ->filter('my.tabid', 'in', $tab_ids)
                    ->filter('my.visible', '!=', 0);
                if (count($profileList) > 0)
                {
                    $p2f->filter('my.profileid', 'in', $profileList);
                }
                $p2fr  = $p2f->execute();
                $p2fid = array ();
                foreach ($p2fr as $info)
                {
                    $p2fid[] = $info->my->fieldname;
                }
                if (count($p2fid) > 0)
                {
                    $query->filter('my.tabid', 'in', $tab_ids)
                        ->filter('my.block', 'in', $block_ids)
                        ->filter('my.fieldname', '!in', $p2fid);
                }
                else
                {
                    $query->filter('my.tabid', 'in', $tab_ids)
                        ->filter('my.block', 'in', $block_ids);
                }
            }
            $result          = $query->execute();
            $moduleFieldList = $this->meta->getModuleFields();
            foreach ($result as $info)
            {
                $fieldname       = $info->my->fieldname;
                $fieldtype       = $info->my->typeofdata;
                $fieldtype       = explode("~", $fieldtype);
                $fieldtypeofdata = $fieldtype[0];
                $fieldlabel      = $info->my->fieldlabel;
                $field           = $moduleFieldList[$fieldname];
                if ($info->my->uitype == 4)
                    $this->essentialField = $fieldlabel;
                $fieldlabel1                     = str_replace(" ", "_", $fieldlabel);
                $optionvalue                     = $fieldname;
                $module_columnlist[$optionvalue] = $fieldlabel;
                if ($fieldtype[1] == "M")
                {
                    $this->mandatoryvalues[]      = "'".$optionvalue."'";
                    $this->data_type[$fieldlabel] = $fieldtype[1];
                }
            }
            $module_columnlist['published'] = 'published';
            $module_columnlist['updated']   = 'updated';
            $module_columnlist['author']    = 'author';

            return $module_columnlist;
        }

        function getColumnsListByCvid($cvid)
        {
            $customviewsquery = XN_Query::create('Content')->tag('cvcolumnlists')
                ->filter('type', 'eic', 'cvcolumnlists')
                ->filter('my.cvid', 'in', array ($cvid))
                ->order('my.columnindex', XN_Order::ASC_NUMBER);
            $customviews      = $customviewsquery->execute();
            foreach ($customviews as $customviews_info)
            {
                $columnlist[$customviews_info->my->columnindex] = $customviews_info->my->columnname;
            }

            return $columnlist;
        }

        function getCustomActionDetails($cvid)
        {
            $customactionsquery = XN_Query::create('Content')->tag('Customactions')
                ->filter('type', 'eic', 'customactions')
                ->filter('my.cvid', '=', $cvid);
            $customactions      = $customactionsquery->execute();
            foreach ($customactions as $customactions_info)
            {
                $calist["subject"] = $customactions_info->my->subject;
                $calist["module"]  = $customactions_info->my->module;
                $calist["content"] = $customactions_info->my->content;
                $calist["cvid"]    = $customactions_info->my->cvid;
            }

            return $calist;
        }

        function isPermittedCustomView($record_id)
        {
            global $current_user;
            global $global_user_privileges;
            $is_admin = $global_user_privileges["is_admin"];
             
            $permission = "yes";
            if ($record_id != '')
            {
                $status_userid_info = $this->getStatusAndUserid($record_id);
                if ($status_userid_info)
                {
                    $status   = $status_userid_info['status'];
                    $userid   = $status_userid_info['userid'];
                    $viewname = $status_userid_info['viewname'];
                    $init     = $status_userid_info['init'];
                    if ($viewname == "Default")
                    {
                        $permission = "no";
                    }
                    elseif ($init == 1)
                    {
                        $permission = 'no';
                    }
                    elseif ($is_admin)
                    {
                        $permission = 'yes';
                    }
                    elseif ($userid == $current_user->id)
                    {
                        $permission = "yes";
                    }
                }
                else
                {
                    $permission = 'no';
                }
            }

            return $permission;
        }

        function getStatusAndUserid($viewid)
        {
            if ($this->_status === false || $this->_userid === false)
            {
                try
                {
                    $loadcontent     = XN_Content::load($viewid, 'Customviews');
                    $this->_status   = $loadcontent->my->status;
                    $this->_userid   = $loadcontent->my->userid;
                    $this->_viewname = $loadcontent->my->viewname;
                    $this->_init     = intval($loadcontent->my->init);
                }
                catch (XN_Exception $e)
                {
                    return false;
                }
            }

            return array ('status'   => $this->_status,
                          'userid'   => $this->_userid,
                          'viewname' => $this->_viewname,
                          'init'     => $this->_init);
        }

        static function hasViewChanged($currentModule)
        {
            if (empty($_SESSION['lvs'][$currentModule]['viewid']))
                return true;
            if (empty($_REQUEST['viewid']))
                return false;
            if ($_REQUEST['viewid'] != $_SESSION['lvs'][$currentModule]['viewid'])
                return true;

            return false;
        }
    }


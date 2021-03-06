<?php
/*+********************************************************************************
 * The contents of this file are subject to the 361CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  361CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ********************************************************************************/
require_once('include/utils/CommonUtils.php');
require_once('Smarty_setup.php');

global $mod_strings, $app_strings, $theme;
$smarty = new vtigerCRM_Smarty;
$smarty->assign("MOD", $mod_strings);
$smarty->assign("APP", $app_strings);

$module_name = $_REQUEST['module_name'];
$module_enable = $_REQUEST['enable_disable'];

$formodule = $_REQUEST['formodule'];

function getToggleParentModuleInfo($formodule)
{
    global $formmodule_presence;
    $modinfo = Array();
    if ($formodule == null)
    {
        $parenttabs = XN_Query::create('Content')->tag('Parenttabs')
            ->filter('type', 'eic', 'parenttabs')
            ->filter('my.parenttabname', '!=', 'Settings')
            ->order('published', XN_Order::ASC)
            ->execute();

        foreach ($parenttabs as $parenttab_info)
        {
            $parenttabname = $parenttab_info->my->parenttabname;
            $presence = $parenttab_info->my->presence;
            $modinfo [$parenttabname] = Array('customized' => '0', 'presence' => $presence, 'hassettings' => FALSE, 'isentitytype' => '1');
        }
    }
    else
    {
        $parenttabs = XN_Query::create('Content')->tag('Parenttabs')
            ->filter('type', 'eic', 'parenttabs')
            ->filter('my.parenttabname', '=', urldecode($formodule))
            ->execute();

        if (count($parenttabs) > 0)
        {
            $parenttab_info = $parenttabs[0];
            $formmodule_presence = $parenttab_info->my->presence;
            if (is_array($parenttab_info->my->tabname))
            {
                $tabs = XN_Query::create('Content')->tag('Tabs')
                    ->filter('type', 'eic', 'tabs')
                    ->filter('my.tabname', 'in', $parenttab_info->my->tabname)
                    ->end(-1)
                    ->execute();
                $tablist = $parenttab_info->my->tabname;
                asort($tablist);
                foreach ($tablist as $tabname)
                {
                    foreach ($tabs as $tab_info)
                    {
                        if ($tab_info->my->tabname == $tabname)
                        {
                            $presence = $tab_info->my->presence;
                            $modinfo [$tabname] = Array('customized' => '0', 'presence' => $presence, 'hassettings' => FALSE, 'isentitytype' => '1');
                        }
                    }
                }

            }
            else
            {
                $tabs = XN_Query::create('Content')->tag('Tabs')
                    ->filter('type', 'eic', 'tabs')
                    ->filter('my.tabname', '=', $parenttab_info->my->tabname)
                    ->end(-1)
                    ->execute();
                if (count($tabs) > 0)
                {
                    $tab_info = $tabs[0];
                    $presence = $tab_info->my->presence;
                    $modinfo [$tabname] = Array('customized' => '0', 'presence' => $presence, 'hassettings' => FALSE, 'isentitytype' => '1');
                }
            }

        }
    }
    return $modinfo;
}

function toggleParentTabsAccess($module, $enable_disable, $parenttabname)
{

    if ($module == $parenttabname)
    {
        $tabs = XN_Query::create('Content')->tag('Parenttabs')
            ->filter('type', 'eic', 'parenttabs')
            ->filter('my.parenttabname', '=', $module)
            ->execute();
        if (count($tabs) > 0)
        {
            $tab_info = $tabs[0];
            $tab_info->my->presence = $enable_disable;
            $tab_info->save('Parenttabs');
            XN_MemCache::delete("session_".XN_Application::$CURRENT_URL);
        }
    }
    else
    {
        $tabs = XN_Query::create('Content')->tag('Tabs')
            ->filter('type', 'eic', 'tabs')
            ->filter('my.tabname', '=', $module)
            ->end(-1)
            ->execute();
        if (count($tabs) > 0)
        {
            $tab_info = $tabs[0];
            $tab_info->my->presence = $enable_disable;
            $tab_info->save('Tabs');
            XN_MemCache::delete("session_".XN_Application::$CURRENT_URL);
        }
    }

}

if ($module_name != '')
{
    toggleParentTabsAccess($module_name, $module_enable, $formodule);
}
global $formmodule_presence;
if (!isset($formodule) || $formodule == "")
{
    $formodule = "My Home Page";
    $smarty->assign("FORMMODULE", $formodule);
    $smarty->assign("TOGGLE_MODINFO", getToggleParentModuleInfo($formodule));
    $header_array = array();
    $formmodule_presence = 1;

    $tab_datas = array();
    $tabs = XN_Query::create('Content')->tag('tabs')
        ->filter('type', 'eic', 'tabs')
        ->end(-1)
        ->execute();
    foreach ($tabs as $tab_info)
    {
        $tab_datas[] = $tab_info->my->tabname;
    }

    $header_array = array();
    $tabs = XN_Query::create('Content')->tag('parenttabs')
        ->filter('type', 'eic', 'parenttabs')
        ->order("my.sequence", XN_Order::ASC)
        ->execute();
    if (count($tabs) > 0)
    {
        foreach ($tabs as $tab_info)
        {
            $tabname = $tab_info->my->tabname;
            if ($tab_info->my->parenttabname != "Settings" && $tab_info->my->parenttabname != "Tools")
            {
                if (count(array_intersect($tab_datas, (array)$tabname)) > 0)
                {
                    $parenttabname = $tab_info->my->parenttabname;
                    $key = urlencode($parenttabname);
                    $header_array[$key] = $parenttabname;
                }
            }
            if ($tab_info->my->parenttabname == $formodule)
            {
                $formmodule_presence = $tab_info->my->presence;
            }
        }
    }

    $smarty->assign("FORMMODULE_PRESENCE", $formmodule_presence);
    $smarty->assign("HEADERS", $header_array);
    $smarty->display('Settings/ModuleSwitch.tpl');
}
else
{
    $smarty->assign("FORMMODULE", $formodule);
    $smarty->assign("TOGGLE_MODINFO", getToggleParentModuleInfo($formodule));
    $smarty->assign("FORMMODULE_PRESENCE", $formmodule_presence);
    $smarty->display('Settings/navtab-content.tpl');
    die();
}


?>
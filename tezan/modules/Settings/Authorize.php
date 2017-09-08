<?php

/*********************************************************************************
 ** The contents of this file are subject to the 361CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  361CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *
 ********************************************************************************/

require_once('include/utils/UserInfoUtil.php');
require_once('include/utils/CommonUtils.php');
require_once('Smarty_setup.php');
global $mod_strings;
global $app_strings;
global $app_list_strings;

global $currentModule;


if (isset($_REQUEST['ids']) && $_REQUEST['ids'] != '' && isset($_REQUEST['pid']) && $_REQUEST['pid'] != '' && isset($_REQUEST['pname']) && $_REQUEST['pname'] != '')
{
    $id_lists = explode(",", $_REQUEST['ids']);

    $authorizes = XN_Query::create('Content')->tag('authorize')
        ->filter('type', 'eic', 'authorize')
        ->execute();

    foreach ($id_lists as $info)
    {
        if ($info != "")
        {
            $save = false;
            foreach ($authorizes as $authorize_info)
            {
                if ($authorize_info->my->authorize == $info)
                {
                    $save = true;
                    $authorize_info->my->userid = $_REQUEST['pid'];
                    $authorize_info->my->userlist = $_REQUEST['pname'];
                    $authorize_info->save('authorize');
                }
            }
            if (!$save)
            {
                $newcontent = XN_Content::create('authorize', '', false);
                $newcontent->my->authorize = $info;
                $newcontent->my->userid = $_REQUEST['pid'];
                $newcontent->my->userlist = $_REQUEST['pname'];
                $newcontent->save('authorize');
            }
        }
    }

    XN_MemCache::delete("session_".XN_Application::$CURRENT_URL);
    echo 'SUCCESS'; 
    die();

}


$smarty = new vtigerCRM_Smarty;


$list_entries = array();

$list_entries['name'] = array('label' => '权限', 'sort' => false, 'width' => 20, 'align' => "right");
$list_entries['profile'] = array('label' => '授权人', 'sort' => false, 'width' => 80, 'align' => "left");


$smarty->assign("LISTHEADER", $list_entries);


require('modules/Settings/config.setting.php');

$authorizes = XN_Query::create('Content')->tag('authorize')
    ->filter('type', 'eic', 'authorize')
    ->execute();


$authorize = array();


$authorizelist = array(
    'adminassistant'      => 'LBL_ADMINASSISTANT',
    'announcementrelease' => 'LBL_ANNOUNCEMENTRELEASE',
    'archive'             => 'LBL_ARCHIVE',
    'picklist'            => 'LBL_PICKLIST',
);
$results = XN_Query::create('Content')->tag('programs')
    ->filter('type', 'eic', 'programs')
    ->filter('my.status', '=', '0')
    ->execute();
if (count($results) > 0)
{
    require($_SERVER['DOCUMENT_ROOT'] . '/admin/config.program.php');

    foreach ($results as $program_info)
    {

        $key = $program_info->my->name;
        if (is_array($programs[$key]['authorize']))
        {
            $authorizelist = array_merge($authorizelist, $programs[$key]['authorize']);
        }
    }
}


$authorizelist['authorizeadmin'] = 'LBL_AUTHORIZEADMIN';
foreach ($authorizelist as $key => $authorizelabel)
{
    $userid = '';
    $userlist = '';
    foreach ($authorizes as $authorize_info)
    {
        if ($authorize_info->my->authorize == $key)
        {
            $userid = $authorize_info->my->userid;
            $userlist = $authorize_info->my->userlist;
        }
    }
    $authorize[$key] = array(getTranslatedString($authorizelabel), $userlist);
}


$smarty->assign("LISTENTITY", $authorize);
$smarty->assign('NOOFROWS', count($authorize));
$smarty->assign("MOD", return_module_language($current_language, 'Settings'));

$listview_check_button = array();

//$listview_check_button[] = '<a data-callback="doauthorize_callback" data-title="请选择人员" class="btn btn-default" data-icon="user-secret" data-callback="refresh" data-group="ids"  data-toggle="dodialogchecked"  data-id="Profiles" data-mask="true" data-maxable="false" data-resizable="false" data-width="700" data-height="300" href="index.php?module=Public&action=SelectRoleUser&mode=checkbox&roleid=" >'.getTranslatedString('LBL_AUTHORIZE').'</a>

$listview_check_button[] = '<a data-callback="doauthorize_callback" data-title="请选择人员" class="btn btn-default lookupbtn" data-icon="user-secret"  data-checkgroup="ids"  data-toggle="lookupbtn"  data-id="Profiles" data-mask="true" data-maxable="false" data-resizable="false" href="index.php?module=Public&action=SelectRoleUser&mode=checkbox&selectids=" >' . getTranslatedString('LBL_AUTHORIZE') . '</a>
<script type="text/javascript">
function doauthorize_callback(group,args)
{ 
		var ids  = []; 
		var objs = $.CurrentNavtab.find(\'input[type="checkbox"][name="ids"]:checked\'); 
		objs.each(function(i){ ids.push($(this).val()) });  
		var url = "module=Settings&action=Authorize&pid="+args.id+"&pname="+args.name + "&ids=" + ids.join(\',\');
	    jQuery.post("index.php", url,
		function (data, textStatus)
		{
				if (data == "SUCCESS")
				{
				    $(this).navtab("refresh");  
				}

		});
}

</script>
';


$smarty->assign("LISTVIEW_CHECK_BUTTON", $listview_check_button);

$smarty->assign("MODULE", $currentModule);
$smarty->assign("ACTION", "Authorize");
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->assign("CHECKBOX", "enabled");
$smarty->display("List.tpl");


?>
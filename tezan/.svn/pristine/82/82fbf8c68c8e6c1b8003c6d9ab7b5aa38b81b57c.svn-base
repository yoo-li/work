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
require_once('Smarty_setup.php');
global $mod_strings;
global $app_strings;
global $app_list_strings;

global $currentModule;


$results = XN_Query::create('Content')->tag('modentity_nums')
			->filter('type','eic','modentity_nums') 
			->end(-1)
			->execute();
foreach($results as $info)
{ 
	$update = false;
	$date = $info->my->date; 
	if (is_null($date) || $date == "")
	{
		$info->my->date = date("ymd"); 
		$update = true; 
	}
	$include_date = $info->my->include_date; 
	if (is_null($include_date) || $include_date == "")
	{
		$info->my->include_date = '1'; 
		$update = true; 
	}
	$length = $info->my->length; 
	if (is_null($length) || $length == "")
	{
		$info->my->length = '3'; 
		$update = true; 
	}
	if ($update)
	{
		$info->save('modentity_nums');
	} 
}


$smarty = new vtigerCRM_Smarty;

$modules = getCRMSupportedModules();

$noofrows = count($modules);

$smarty->assign('NOOFROWS',$noofrows);


$list_entries = array();

$list_entries['modulename'] = array('label' => $mod_strings['LBL_MODULE_NAME'],'sort'=> false,'width' => 20,'align' => "left" );
$list_entries['prefix'] = array('label' => $mod_strings['LBL_USE_PREFIX'],'sort'=> false,'width' => 20,'align' => "left" );
$list_entries['include_date'] = array('label' => $mod_strings['LBL_INCLUDE_DATE'],'sort'=> false,'width' => 10,'align' => "center" );
$list_entries['length'] = array('label' => $mod_strings['LBL_LENGTH'],'sort'=> false,'width' => 10,'align' => "center" );
$list_entries['current_seq'] = array('label' => $mod_strings['LBL_CURRENT_SEQ'],'sort'=> false,'width' => 20,'align' => "center" );
$list_entries['start_seq'] = array('label' => $mod_strings['LBL_START_SEQ'],'sort'=> false,'width' => 10,'align' => "center" );
$list_entries['date'] = array('label' => $mod_strings['LBL_DATE_PREFIX'],'sort'=> false,'width' => 10,'align' => "center" );
$list_entries['edit'] = array('label' => $mod_strings['LBL_OPER'],'sort'=> false,'width' => 10,'align' => "center" );

$smarty->assign("LISTHEADER",$list_entries);


function getCRMSupportedModules()
{
	$query = XN_Query::create ( 'Content' ) ->tag('Fields')
		->filter ( 'type', 'eic', 'fields' )
		->filter ( 'my.uitype', '=', '4' )
		->execute();
	$tabids = array();
	foreach($query as $info){
		$tabids[] = $info->my->tabid;
	}
	$modulelist = array();
	if (count($tabids) > 0)
	{
		$query = XN_Query::create ( 'Content' ) ->tag('Tabs')
			->filter ( 'type', 'eic', 'tabs' )
			->filter ( 'my.presence', '=', '0' )
			->filter ( 'my.tabid', 'in', $tabids )
			->execute();

		foreach($query as $info){
			$modulelist[] = $info->my->tabname;
		}
	}
	
	return $modulelist;
}

/** gives the profile list info array 
  * @param $profileListResult -- profile list database result:: Type array
  * @param $noofrows -- no of rows in the $profileListResult:: Type integer 
  * @param $mod_strings -- i18n mod_strings array:: Type array 
  * @returns $return_date -- profile list info array:: Type array
  *
 */
function getStdOutput($modules, $noofrows, $mod_strings)
{
	$return_data = array();			
	$results = XN_Query::create('Content')->tag('modentity_nums')
				->filter('type','eic','modentity_nums')
				->filter('my.semodule','in',$modules)
				->execute();
	foreach($results as $info)
	{
		$standCustFld = array();
		$standCustFld[]= getTranslatedString($info->my->semodule);
		$standCustFld[]= $info->my->prefix;
		$include_date = $info->my->include_date;
		if ($include_date == "1")
		{
			$standCustFld[]= '包含';
		}
		else
		{
			$standCustFld[]= '不包含';
		} 
		$standCustFld[]= $info->my->length;
		$standCustFld[]= $info->my->cur_id;		
		$standCustFld[]= $info->my->start_id;
		$standCustFld[]= $info->my->date;
		$standCustFld[]= '<a href="index.php?module=Settings&action=EditeModEntityNo&record='.$info->id.'" data-toggle="dialog" data-id="edit" data-mask="true" data-maxable="false" data-resizable="false" data-width="550" data-height="320" data-title="编辑"><i class="fa fa-file-text-o"></a>';
		$return_data[$info->id]=$standCustFld;
	}
	return $return_data;
}

$smarty->assign("LISTENTITY",getStdOutput($modules, $noofrows, $mod_strings));
$smarty->assign("MOD", return_module_language($current_language,'Settings'));

$listview_check_button = array();

$listview_check_button[] = '<a class="btn btn-default" data-icon="refresh" data-callback="refresh"  data-toggle="doajax" href="index.php?module=Settings&action=refreshentityno"  >'.getTranslatedString('LBL_REFRESH_ENTITYNO_BUTTON_LABEL').'</a>';

$smarty->assign("LISTVIEW_CHECK_BUTTON", $listview_check_button);

$smarty->assign("MODULE", $currentModule);
$smarty->assign("ACTION", "CustomModEntityNo");
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);

$smarty->display("List.tpl");
?>



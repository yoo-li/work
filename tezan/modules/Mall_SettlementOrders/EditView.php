<?php
	/*+********************************************************************************
	 * The contents of this file are subject to the 361CRM Public License Version 1.0
	 * ("License"); You may not use this file except in compliance with the License
	 * The Original Code is:  361CRM Open Source
	 * The Initial Developer of the Original Code is vtiger.
	 * Portions created by vtiger are Copyright (C) vtiger.
	 * All Rights Reserved.
	 ********************************************************************************/
	require_once('Smarty_setup.php');
	require_once('include/utils/utils.php');
	global $currentModule;
	require_once('modules/'.$currentModule.'/'.$currentModule.'.php');

	global $app_strings, $mod_strings, $theme;

	$focus  = CRMEntity::getInstance($currentModule);
	$smarty = new vtigerCRM_Smarty();

	$focus->retrieve_entity_info($_REQUEST['record'], $currentModule);

	$smarty->assign("HASAPPROVALS", $focus->hasapprovals);
	$smarty->assign("APPROVALSTATUS", $focus->approvalstatus);
	$smarty->assign("APPROVALID", $focus->approvalid);
	$smarty->assign("DETAILAPPROVAL", $focus->detailapproval);
	$smarty->assign("HEADERDETAILS", $focus->headerdetails);
	$smarty->assign("DETAILS", $focus->details);
	$smarty->assign("PARAMS", $params);

	if (empty($_REQUEST['record']) && $focus->mode != 'edit')
	{
		setObjectValuesFromRequest($focus);
	}
	$currentUser = XN_Profile::$VIEWER;

	$smarty->assign("READONLY", 'true');

	$disp_view = getView($focus->mode);

	$smarty->assign("BLOCKS", getBlocks($currentModule, $disp_view, $focus->mode, $focus->column_fields));
	$smarty->assign("OP_MODE", $disp_view);

	$smarty->assign("MODULE", $currentModule);
	$smarty->assign("SINGLE_MOD", $currentModule);
	$smarty->assign("MOD", $mod_strings);
	$smarty->assign("APP", $app_strings);

	$smarty->assign("ID", $focus->id);

	if ($focus->mode == 'edit')
	{
		$smarty->assign("MODE", $focus->mode);
	}
	else
	{
		$smarty->assign("MODE", 'create');
	}

	$tabid = getTabid($currentModule);

	$check_button = Button_Check($module);
	$smarty->assign("CHECK", $check_button);

	$editview_check_button = EditView_Button_Check($module, $focus);

	$smarty->assign("EDITVIEW_CHECK_BUTTON", $editview_check_button);

	$ajax_panel_check = Ajax_Panel_Check($module, $focus);

	$smarty->assign("AJAX_PANEL_CHECK", $ajax_panel_check);

	$smarty->assign("MOD_SEQ_ID", getModuleModentityNum($focus, $module));

	$smarty->assign("CURRENT_USERID", $current_user->id);
	$profile = $focus->column_fields['author'];
	$name    = getGivenNamesByids($profile);
	$smarty->assign("CREATEUSER", (array)$name);
	$smarty->assign("CREATEDATE", $focus->column_fields['published']);
	$smarty->assign("CURRENTRECORDNUM", getRecordNum($focus, $module));

	if ($focus->column_fields['physicaltype'] == "1")
	{
		$logisticsname      = XN_Filter("my.logisticsname", '=', "顺丰");
		$filter             = array ();
		$filter['delivery'] = base64_encode(serialize(XN_Filter::all($logisticsname)));
	}
	if (isset($filter) && $filter != "")
	{
		$smarty->assign("FILTER", $filter);
	}
	$smarty->display("salesEditView.tpl");
?>
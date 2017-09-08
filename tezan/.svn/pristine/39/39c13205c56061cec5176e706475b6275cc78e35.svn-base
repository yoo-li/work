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

	$focus          = CRMEntity::getInstance($currentModule);
	$smarty         = new vtigerCRM_Smarty();
	$correct_fields = array ("suppliers_name", "suppliers_shortname", "suppliers_username", "contact", "mobile", "province", "city",
							 "company", "companyaddress", "bankname", "accountname", "bankaccount", "ceo", "email", "bussinesslicense", "idcardfront", "idcardback","logo", "longitude", "latitude");
	if (isset($_REQUEST['mode_type']) && $_REQUEST['mode_type'] != "" && isset($_REQUEST['parent_id']) && $_REQUEST['parent_id'] != "")
	{
		$mode_type    = $_REQUEST['mode_type'];
		$fromsupplier = true;
		if ($mode_type == "edit")
		{
			$supplierid       = $_REQUEST['parent_id'];
			$suppliercorrects = XN_Query::create("Content")
										->tag("mall_smkcardrecords")
										->filter("type", "=", "mall_smkcardrecords")
										->filter("my.supplierid", "=", $supplierid)
										->filter("my.suppliercorrectstatus", "in", array ("Saved", "Approvaling"))
										->filter("my.deleted", "=", "0")
										->order("published", XN_Order::DESC)
										->end(1)
										->execute();
			if (count($suppliercorrects))
			{
				$suppliercorrectContent = $suppliercorrects[0];
				$focus->retrieve_entity_info($suppliercorrectContent->id, $currentModule);
				$smarty->assign("ID", $suppliercorrectContent->id);
			}
			else
			{
				$fromsupplier = false;
			}
		}
		else
		{
			$fromsupplier = false;
		}
		if (!$fromsupplier)
		{
			$focus->retrieve_entity_info("", $currentModule);
			setObjectValuesFromRequest($focus);
			$supplierid    = $_REQUEST['parent_id'];
			$supplier_info = XN_Content::load($supplierid, "suppliers");
			foreach ($correct_fields as $fieldname)
			{
				$focus->column_fields[$fieldname] = $supplier_info->my->$fieldname;
			}
			$focus->column_fields["supplierid"] = $supplierid;
			$smarty->assign("ID", $focus->id);
		}
	}
	elseif (!empty($_REQUEST['record']))
	{
		$focus->retrieve_entity_info($_REQUEST['record'], $currentModule);
		setObjectValuesFromRequest($focus);
		$smarty->assign("ID", $_REQUEST['record']);
	}
	else
	{
		$focus->retrieve_entity_info("", $currentModule);
		setObjectValuesFromRequest($focus);
		$smarty->assign("ID", $focus->id);
	}
	if (isset($readonly) && $readonly == 'true')
		$smarty->assign("READONLY", $readonly);
	else
		$smarty->assign("READONLY", $focus->readOnly);
	if (isset($customReadonly))
	{
		$smarty->assign("READONLY", $customReadonly);
	}
	$smarty->assign("HASAPPROVALS", $focus->hasapprovals);
	$smarty->assign("APPROVALSTATUS", $focus->approvalstatus);

	$smarty->assign("APPROVALID", $focus->approvalid);
	$smarty->assign("DETAILAPPROVAL", $focus->detailapproval);
	$smarty->assign("HEADERDETAILS", $focus->headerdetails);
	$smarty->assign("DETAILS", $focus->details);
	$smarty->assign("PARAMS", $params);

	$disp_view = getView($focus->mode);

	$smarty->assign("BLOCKS", getBlocks($currentModule, $disp_view, $focus->mode, $focus->column_fields));
	$smarty->assign("OP_MODE", $disp_view);

	$smarty->assign("MODULE", $currentModule);
	$smarty->assign("SINGLE_MOD", $currentModule);
	$smarty->assign("MOD", $mod_strings);
	$smarty->assign("APP", $app_strings);

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
	$smarty->assign("CREATEUSER", getPersonmanFromFocus($focus));
	$smarty->assign("CREATEDATE", $focus->column_fields['published']);
	$smarty->assign("CURRENTRECORDNUM", getRecordNum($focus, $module));

	if (isset($filter) && $filter != "")
	{
		$smarty->assign("FILTER", $filter);
	}
	$smarty->assign("domain", getdoamin());
	$smarty->display("salesEditView.tpl");
?>
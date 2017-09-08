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
	global $currentModule, $supplierid, $supplierusertype, $app_strings, $mod_strings, $theme;;
	require_once('modules/'.$currentModule.'/'.$currentModule.'.php');

	$focus  = CRMEntity::getInstance($currentModule);
	$smarty = new vtigerCRM_Smarty();
	$record = $_REQUEST['record'];
	if (isset($supplierid) && $supplierid != "" && $_REQUEST['from'] == "Mall_Products")
	{
		$productcorrects = XN_Query::create("Content")
								   ->tag("mall_propertycorrect")
								   ->filter("type", "eic", "mall_propertycorrect")
								   ->filter("my.product_id", "=", $record)
								   ->filter("my.mall_propertycorrectstatus", 'in', array ("Saved", "Approvaling", "Agree", "Disagree"))
								   ->filter("my.deleted", "=", 0)
								   ->order("published", XN_Order::DESC)
								   ->end(1)
								   ->execute();
		$needcreate      = true;
		if (count($productcorrects))
		{
			$productcorrect = $productcorrects[0];
			if (in_array($productcorrect->my->mall_propertycorrectstatus, array ("Saved", "Approvaling", "Disagree")))
			{
				$focus->retrieve_entity_info($productcorrect->id, $currentModule);
				$needcreate = false;
			}
		}
		if ($needcreate)
		{
			$focus->retrieve_entity_info('', $currentModule);
			$focus->mode                                        = 'create';
			$focus->column_fields['mall_propertycorrectstatus'] = '';
			$focus->column_fields['product_id']                 = $record;
			$focus->column_fields['deleted']                    = '-1';
			$focus->column_fields['supplierid']                 = $supplierid;
			$propertycorrectid                                  = $focus->id;

			$product_info = XN_Content::load($record, "mall_products");

			$loadcontent                 = XN_Content::load($propertycorrectid, strtolower($module));
			$loadcontent->my->product_id = $record;
			$fields                      = array ("property_type");
			foreach ($fields as $fieldname)
			{
				$loadcontent->my->$fieldname = $product_info->my->$fieldname;
			}
			$loadcontent->save(strtolower($module).",".strtolower($module)."_".$supplierid);

			$propertys = XN_Query::create('Content')
								 ->filter('type', 'eic', 'mall_propertys')
								 ->filter('my.productid', '=', $record)
								 ->filter('my.deleted', '=', '0')
								 ->begin(0)->end(-1)
								 ->execute();
			$keys      = array ();
			foreach ($propertys as $property_info)
			{
				$property                     = XN_Content::create("mall_propertys", "", false);
				$property->my->productid      = $propertycorrectid;
				$property->my->property_type  = $property_info->my->property_type;
				$property->my->property_value = $property_info->my->property_value;
				$property->my->deleted        = '0';
				$property->my->status         = '0';
				$property->my->sequence       = $property_info->my->sequence;
				$property->save("mall_propertys,mall_propertys_".$supplierid);
				$keys[$property_info->id] = $property->id;
			}
			$product_propertys = XN_Query::create('Content')
										 ->tag("mall_product_property")
										 ->filter('type', 'eic', 'mall_product_property')
										 ->filter('my.productid', '=', $record)
										 ->filter('my.deleted', '=', '0')
										 ->filter('my.status', '=', '0')
										 ->begin(0)->end(-1)
										 ->execute();

			foreach ($product_propertys as $product_property_info)
			{
				$propertyids    = $product_property_info->my->propertyids;
				$newpropertyids = array ();
				foreach ((array)$propertyids as $propertyid)
				{
					if (isset($keys[$propertyid]) && $keys[$propertyid] != "")
					{
						$newpropertyids[] = $keys[$propertyid];
					}
				}
				$newcontent                   = XN_Content::create('mall_product_property', "", false);
				$newcontent->my->status       = "0";
				$newcontent->my->productid    = $propertycorrectid;
				$newcontent->my->barcode      = $product_property_info->my->barcode;
				$newcontent->my->propertyids  = $newpropertyids;
				$newcontent->my->propertydesc = $product_property_info->my->propertydesc;
				$newcontent->my->market       = $product_property_info->my->market;
				$newcontent->my->imgurl       = $product_property_info->my->imgurl;
				$newcontent->my->shop         = $product_property_info->my->shop;
				$newcontent->my->inventorys   = $product_property_info->my->inventorys;
				$newcontent->my->deleted      = '0';

				$newcontent->save("mall_product_property,mall_product_property_".$supplierid);
			}
		}

	}
	else
	{
		$focus->retrieve_entity_info($record, $currentModule);
	}

	if ($focus->mode == "")
	{
		$focus->mode     = "create";
		$focus->readOnly = "false";
	}
	$smarty->assign("ID", $focus->id);

	if (isset($supplierid) && $supplierid != "")
	{
		if (in_array($focus->column_fields['mall_propertycorrectstatus'], array ('', 'Saved', "Disagree")))
		{
			$customReadonly = 'false';
		}
		else
		{
			$customReadonly = 'true';
		}
	}
	else
	{
		$customReadonly = 'true';
	}
	if (isset($readonly) && $readonly == 'true')
		$smarty->assign("READONLY", $readonly);
	else
		$smarty->assign("READONLY", $focus->readOnly);
	if (isset($customReadonly))
	{
		$smarty->assign("READONLY", $customReadonly);
	}

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
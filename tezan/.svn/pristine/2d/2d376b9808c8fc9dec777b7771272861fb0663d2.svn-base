<?php

	require_once('Smarty_setup.php');
	require_once('include/utils/utils.php');
	require_once "modules/PickList/PickListUtils.php";
	global $currentModule;
	session_start();
	require_once('modules/'.$currentModule.'/'.$currentModule.'.php');

	global $app_strings, $mod_strings, $theme;

	$focus  = CRMEntity::getInstance($currentModule);
	$smarty = new vtigerCRM_Smarty();

	if (isset($focus->datatype) && $focus->datatype != "")
	{
		$focus->retrieve_entity_info($_REQUEST['record'], $currentModule, $focus->datatype);
	}
	else
	{
		$focus->retrieve_entity_info($_REQUEST['record'], $currentModule);
	}

	$smarty->assign("HASAPPROVALS", $focus->hasapprovals);
	$smarty->assign("APPROVALSTATUS", $focus->approvalstatus);
	if (isset($readonly) && $readonly == 'true')
		$smarty->assign("READONLY", $readonly);
	else
		$smarty->assign("READONLY", $focus->readOnly);
	
	global $supplierid;
	if ($supplierid != '71352')
	{
		$smarty->assign("READONLY", 'true');
	} 
	 
	$smarty->assign("APPROVALID", $focus->approvalid);
	$smarty->assign("DETAILAPPROVAL", $focus->detailapproval);
	$smarty->assign("HEADERDETAILS", $focus->headerdetails);
	$smarty->assign("DETAILS", $focus->details);
	$smarty->assign("PARAMS", $params);

	if (empty($_REQUEST['record']) && $focus->mode != 'edit')
	{
		setObjectValuesFromRequest($focus);
	}

	$disp_view = getView($focus->mode);

	$smarty->assign("ID", $focus->id);

	if ($focus->mode == 'edit')
	{
		$smarty->assign("MODE", $focus->mode);
	}
	else
	{
		$smarty->assign("MODE", 'create');
	}

	$reportmoduletabid = $focus->column_fields['modulestabid'];
	$reporttypeid      = $focus->column_fields['reporttype'];
	$complexid         = $focus->column_fields['complex'];
	$modulestab        = getAssignedPicklistValues('modulestabid');
	$complex           = getAssignedPicklistValues('complex');
	$query             = XN_Query::create("Content")->tag("supplier_reportsettingscategorys")->end(-1)
								 ->filter("type", "eic", "supplier_reportsettingscategorys")
								 ->filter("my.deleted", "=", "0")
								 ->filter("my.supplierid", "=", $supplierid)
								 ->order("my.sequence", XN_Order::ASC_NUMBER)
								 ->execute();
	$reporttype        = array ();
	foreach ($query as $item)
	{
		$reporttype[$item->id] = $item->my->categorys;
	}

	$modulesoption    = '<option value="">==选择模块==</option>';
	$reporttypeoption = '<option value="">==选择报表类型==</option>';
	$complexoption    = '<option value="">==选择报表索引==</option>';
	foreach ($modulestab as $key => $value)
	{
		if ($key == $reportmoduletabid)
		{
			$modulesoption .= '<option value="'.$key.'" selected>'.$value.'</option>';
		}
		else
		{
			$modulesoption .= '<option value="'.$key.'">'.$value.'</option>';
		}
	}
	foreach ($reporttype as $key => $value)
	{
		if ($key == $reporttypeid)
		{
			$reporttypeoption .= '<option value="'.$key.'" selected>'.$value.'</option>';
		}
		else
		{
			$reporttypeoption .= '<option value="'.$key.'">'.$value.'</option>';
		}
	}
	foreach ($complex as $key => $value)
	{
		if ($key == $complexid)
		{
			$complexoption .= '<option value="'.$key.'" selected>'.$value.'</option>';
		}
		else
		{
			$complexoption .= '<option value="'.$key.'">'.$value.'</option>';
		}
	}

	$reportmodule = getModule($reportmoduletabid);
	$x_axis       = $focus->column_fields['x_axis'];
	$y_axis       = $focus->column_fields['y_axis'];
	$z_axis       = $focus->column_fields['z_axis'];

	$x_axisfields = '<optgroup label="系统字段">';
	$x_axisfields .= '<option value="published@monthday" '.($x_axis == "published@monthday" ? "selected" : "").'>日期</option>';
	$x_axisfields .= '<option value="published@yearmonth" '.($x_axis == "published@yearmonth" ? "selected" : "").'>月度</option>';
	$x_axisfields .= '<option value="published@quarter" '.($x_axis == "published@quarter" ? "selected" : "").'>季度</option>';
	$x_axisfields .= '<option value="published@year" '.($x_axis == "published@year" ? "selected" : "").'>年度</option>';
	$x_axisfields .= '<option value="author" '.($x_axis == "author" ? "selected" : "").'>创建人</option>';
	$x_axisfields .= '</optgroup>';

	$y_axisfields = '<optgroup label="系统字段">';
	$y_axisfields .= '<option value="count" '.($y_axis == "count" ? "selected" : "").'>数量</option>';
	$y_axisfields .= '</optgroup>';

	$z_axisfields = '<optgroup label="系统字段">';
	$z_axisfields .= '<option value="published@yearmonth" '.($z_axis == "published@yearmonth" ? "selected" : "").'>月度</option>';
	$z_axisfields .= '<option value="published@quarter" '.($z_axis == "published@quarter" ? "selected" : "").'>季度</option>';
	$z_axisfields .= '<option value="published@year" '.($z_axis == "published@year" ? "selected" : "").'>年度</option>';
	$z_axisfields .= '</optgroup>';

	$reportfields = '<optgroup label="系统字段">';
	$reportfields .= '<option value="published">创建日期</option>';
	$reportfields .= '</optgroup>';

	$fields = XN_Query::create('Content')->tag('fields')
					  ->filter('type', 'eic', 'fields')
					  ->filter('my.tabid', '=', $reportmoduletabid)
					  ->filter('my.presence', 'in', array ('0', '2'))
					  ->order('my.sequence', XN_Order::ASC_NUMBER)
					  ->end(-1)
					  ->execute();
	if (count($fields) > 0)
	{
		$x_axisfields .= '<optgroup label="模块字段">';
		$y_axisfields .= '<optgroup label="模块字段">';
		$z_axisfields .= '<optgroup label="模块字段">';
		$reportfields .= '<optgroup label="模块字段">';
		foreach ($fields as $field_info)
		{
			$field = $field_info->my->fieldname;
			$x_axisfields .= '<option value="'.$field.'" '.($x_axis == $field ? "selected" : "").'>'.getTranslatedString($field_info->my->fieldlabel, $reportmodule).'</option>';
			$y_axisfields .= '<option value="'.$field.'" '.($y_axis == $field ? "selected" : "").'>'.getTranslatedString($field_info->my->fieldlabel, $reportmodule).'</option>';
			$z_axisfields .= '<option value="'.$field.'" '.($z_axis == $field ? "selected" : "").'>'.getTranslatedString($field_info->my->fieldlabel, $reportmodule).'</option>';
			$reportfields .= '<option value="'.$field.'">'.getTranslatedString($field_info->my->fieldlabel, $reportmodule).'</option>';
		}
		$x_axisfields .= '</optgroup>';
		$y_axisfields .= '</optgroup>';
		$z_axisfields .= '</optgroup>';
		$reportfields .= '</optgroup>';
	}

	/**
	 * 设置组合筛选
	 */
	$reportfiltertype = array (
		"calendar"     => "日期型",
		"search_input" => "单字段输入型",
		"multi_input"  => "多字段输入型",
		"text"         => "普通文本选择型",
		"select"       => "下拉选择型",
		"picklist"     => "字典型",
		"multitree"    => "多选树型",
		"radiotree"    => "单选树型",
	);

	$filtertypeoption = '<option value="">==选择模型==</option>';
	foreach ($reportfiltertype as $key => $value)
	{
		$filtertypeoption .= '<option value="'.$key.'">'.$value.'</option>';
	}

	$reportfilters = array ();
	$query         = XN_Query::create("Content")->tag("supplier_reportsettingsfilters")->end(-1)
							 ->filter("type", "eic", "supplier_reportsettingsfilters")
							 ->filter("my.record", "=", $focus->id)
							 ->execute();
	foreach ($query as $item)
	{
		$filterfield = $item->my->fieldname;
		$fieldsarray = explode(",", $filterfield);
		if (count($fieldsarray) <= 0)
		{
			$fieldsarray[] = $filterfield;
		}
		$fieldlabel = "";
		foreach ($fieldsarray as $info)
		{
			if ($fieldlabel != "")
			{
				$fieldlabel .= ",";
			}
			foreach ($fields as $field_info)
			{
				if ($field_info->my->fieldname == $info)
				{
					$fieldlabel .= getTranslatedString($field_info->my->fieldlabel, $reportmodule);
					break;
				}
			}
		}

		$filtertype      = $item->my->filtertype;
		$reportfilters[] = array ("filterfield" => $filterfield, "filtertype" => $filtertype, "fieldlabel" => $fieldlabel, "typelabel" => $reportfiltertype[$filtertype]);
	}

	/**
	 * 设置过滤条件
	 */
	$reportquerylogic = array (
		"="    => "等于",
		"!="   => "不等于",
		">"    => "大于",
		">="   => "大于等于",
		"<"    => "小于",
		"<="   => "小于等于",
		"in"   => "包含",
		"!in"  => "不包含",
		"like" => "模糊比较",
	);

	$querylogicoption = '<option value="">==选择逻辑==</option>';
	foreach ($reportquerylogic as $key => $value)
	{
		$querylogicoption .= '<option value="'.$key.'">'.$value.'</option>';
	}

	$reportquerys = array ();
	$query        = XN_Query::create("Content")->tag("supplier_reportsettingsquerys")->end(-1)
							->filter("type", "eic", "supplier_reportsettingsquerys")
							->filter("my.record", "=", $focus->id)
							->execute();
	foreach ($query as $item)
	{
		$filterfield = $item->my->fieldname;
		$fieldlabel  = "";
		foreach ($fields as $field_info)
		{
			if ($field_info->my->fieldname == $filterfield)
			{
				$fieldlabel .= getTranslatedString($field_info->my->fieldlabel, $reportmodule);
				break;
			}
		}

		$logic          = $item->my->logic;
		$reportquerys[] = array ("queryfield" => $filterfield, "querylogic" => $logic, "fieldlabel" => $fieldlabel, "logiclabel" => $reportquerylogic[$logic], "queryvalue" => $item->my->queryvalue);
	}

	/**
	 * 报表用户
	 */
	$query = XN_Query::create("Content")->tag("supplier_users")->end(-1)
					 ->filter("type", "eic", "supplier_users")
					 ->filter("my.supplierid", "=", $supplierid)
					 ->filter("my.status", "=", "0")
					 ->execute();

	$reportuser = $focus->column_fields['reportuser'];
	if (!empty($reportuser) && !is_array($reportuser))
	{
		$reportuser = explode(",", $reportuser);
		if (empty($reportuser) || count($reportuser) <= 0)
		{
			$reportuser[] = $focus->column_fields['reportuser'];
		}
	}
	$reportuseroption = '';
	foreach ($query as $item)
	{
		$profileid = $item->my->profileid;
		$reportuseroption .= '<option value="'.$profileid.'" '.(in_array($profileid, $reportuser) ? "selected" : "").'>'.$item->my->account.'</option>';
	}

	$reportinfo = array ("reportname"        => $focus->column_fields['reportname'],
						 "reportgroup"       => $focus->column_fields['reportgroup'],
						 "modulestabid"      => $modulesoption,
						 "reporttype"        => $reporttypeoption,
						 "status"            => $focus->column_fields['status'],
						 "reportfilters"     => $reportfilters,
						 "reportfiltercount" => count($reportfilters),
						 "filtertypeoption"  => $filtertypeoption,
						 "reportquerys"      => $reportquerys,
						 "reportqueryscount" => count($reportquerys),
						 "querylogicoption"  => $querylogicoption,
						 "reporttypeid"      => $reporttypeid,
						 "reporttypelabel"   => $reporttype[$reporttypeid],
						 "reportuser"        => $reportuseroption,
						 "complexoption"     => $complexoption,
	);

	$reportinfo["Xaxisfields"]  = $x_axisfields;
	$reportinfo["Yaxisfields"]  = $y_axisfields;
	$reportinfo["Zaxisfields"]  = $z_axisfields;
	$reportinfo["reportfields"] = $reportfields;

	$smarty->assign("OP_MODE", $disp_view);
	$smarty->assign("MODULE", $currentModule);
	$smarty->assign("SINGLE_MOD", $currentModule);
	$smarty->assign("MOD", $mod_strings);
	$smarty->assign("APP", $app_strings);
	$smarty->assign("REPORTINFO", $reportinfo);

	$tabid = getTabid($currentModule);

	$check_button = Button_Check($module);
	$smarty->assign("CHECK", $check_button);

	$editview_check_button = EditView_Button_Check($module, $focus);

	$smarty->assign("EDITVIEW_CHECK_BUTTON", $editview_check_button);

	$ajax_panel_check = Ajax_Panel_Check($module, $focus);

	$smarty->assign("AJAX_PANEL_CHECK", $ajax_panel_check);

	$smarty->assign("HASCSS", 'true');

	$smarty->assign("CURRENT_USERID", $current_user->id);
	$smarty->assign("CREATEUSER", getPersonmanFromFocus($focus));
	$smarty->assign("CREATEDATE", $focus->column_fields['published']);
	$smarty->assign("CURRENTRECORDNUM",getRecordNum($focus, $module));

	$guid = guid();
	XN_MemCache::put($guid, "token_edit_".XN_Profile::$VIEWER, "600");
	$smarty->assign("TOKEN", $guid);
	$smarty->assign("domain", getdoamin());
	global $startTime;
	$endTime = microtime();
	$smarty->assign("RUNTIME", round(microtime_diff($startTime, $endTime), 2));

	$smarty->display($currentModule."/EditView.tpl");
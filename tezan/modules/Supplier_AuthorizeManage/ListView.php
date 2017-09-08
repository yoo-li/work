<?php

	require_once('include/utils/UserInfoUtil.php');
	require_once('include/utils/CommonUtils.php');
	require_once('Smarty_setup.php');
	global $mod_strings;
	global $app_strings;
	global $app_list_strings;

	global $currentModule;
	global $supplierid;
	global $supplierusertype;
 

	$smarty = new vtigerCRM_Smarty;

	$list_entries = array ();

	$list_entries['name'] = array ('label' => '权限', 'sort' => false, 'width' => 20, 'align' => "right");
	if ($supplierusertype == "superadmin" || $supplierusertype == "admin")
	{
		$list_entries['supplierid'] = array ('label' => '商家', 'sort' => false, 'width' => 20, 'align' => "center");
		$list_entries['profile']    = array ('label' => '授权人', 'sort' => false, 'width' => 60, 'align' => "left");
	}
	else
	{
		$list_entries['profile'] = array ('label' => '授权人', 'sort' => false, 'width' => 80, 'align' => "left");
	}
	$smarty->assign("LISTHEADER", $list_entries);
	$supplier = array();
	if ($supplierusertype == "superadmin" || $supplierusertype == "admin")
	{
		$suppliercontent = XN_Query::create('Content')->tag('suppliers')->end(-1)
			->filter('type', 'eic', 'suppliers')
			->filter('my.deleted', '=', '0')
			->execute();
		foreach ($suppliercontent as $item)
		{
			$supplier[$item->id] = $item->my->suppliername;
		}
		$authorizes = XN_Query::create('Content')->tag(strtolower($currentModule))->end(-1)
							  ->filter('type', 'eic', strtolower($currentModule))
							  ->execute();
	}
	else
	{
		$authorizes = XN_Query::create('Content')->tag(strtolower($currentModule)."_".$supplierid)->end(-1)
							  ->filter('type', 'eic', strtolower($currentModule))
							  ->filter('my.supplierid', '=', $supplierid)
							  ->execute();
	}

	$authorize = array ();

	$authorizelist = array ( 
		'manager'  => 'LBL_MANAGER',
		'delivery'  => 'LBL_DELIVERY',
		'finance'   => 'LBL_FINANCE',
		'customerservice'    => 'LBL_CUSTOMERSERVICE', 
	); 

	foreach ($authorizelist as $key => $authorizelabel)
	{
		$userlist = '';
		$supid    = '';
		foreach ($authorizes as $authorize_info)
		{
			if ($authorize_info->my->authorize == $key)
			{
				$userlist = $authorize_info->my->userlist;
				if ($supplierusertype == "superadmin" || $supplierusertype == "admin"){
					$supid = $supplier[$authorize_info->my->supplierid];
				}
			}
		}
		if ($supplierusertype == "superadmin" || $supplierusertype == "admin")
		{
			$authorize[$key] = array (getTranslatedString($authorizelabel), $supid, $userlist);
		}
		else
		{
			$authorize[$key] = array (getTranslatedString($authorizelabel), $userlist);
		}
	}

	$smarty->assign("LISTENTITY", $authorize);
	$smarty->assign('NOOFROWS', count($authorize));
	$smarty->assign("MOD", return_module_language($current_language, $currentModule));

	$listview_check_button = array ();
	if ($supplierusertype != "superadmin" && $supplierusertype != "admin" && $supplierid != '')
	{
		$listview_check_button[] = '<a data-callback="supplier_authorizemanage_doauthorize_callback" data-title="请选择人员" class="btn btn-default lookupbtn" data-icon="user-secret"  data-checkgroup="ids"  data-toggle="lookupbtn"  data-id="Profiles" data-mask="true" data-maxable="false" data-resizable="false" href="index.php?module=Supplier_Departments&action=SelectDepartmentsUser&mode=checkbox&selectids=" >'.getTranslatedString('LBL_AUTHORIZE').'</a>';
	}
	$smarty->assign("LISTVIEW_CHECK_BUTTON", $listview_check_button);

	$smarty->assign("MODULE", $currentModule);
	$smarty->assign("APP", $app_strings);
	$smarty->assign("CMOD", $mod_strings);
	$smarty->assign("CHECKBOX", "enabled");
	$smarty->display($currentModule."/ListView.tpl");

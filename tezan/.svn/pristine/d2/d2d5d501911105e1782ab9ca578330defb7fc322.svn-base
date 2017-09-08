<?php
	if ($_REQUEST['mode'] == 'Export')
	{
		include('modules/Public/SheetExportExcel.php');
		die();
	}
	global $currentModule;
	require_once('modules/'.$currentModule.'/'.$currentModule.'.php');
	require_once('Smarty_setup.php');
	require_once('include/utils/DataSearch.php');
	require_once('modules/CustomView/CustomView.php');
	global $app_strings, $mod_strings, $current_language;
	$current_module_strings = return_module_language($current_language, $currentModule);
	$focus = CRMEntity::getInstance($currentModule);
	$focus->initSortbyField($currentModule);
	$category = getParentTab();
	$smarty = new vtigerCRM_Smarty;
	if ($_REQUEST['errormsg'] != '')
	{
		$errormsg = $_REQUEST['errormsg'];
		$smarty->assign("ERROR", $errormsg);
	}
	else
	{
		$smarty->assign("ERROR", "");
	}
	if ($_REQUEST['numPerPage'] != '' && $_REQUEST['numPerPage'] != $_SESSION['numPerPage'])
	{
		$numperpage             = $_REQUEST['numPerPage'];
		$_SESSION['numPerPage'] = $numperpage;
	}
	else if (isset($_SESSION['numPerPage']) && $_SESSION['numPerPage'] != "")
	{
		$numperpage = $_SESSION['numPerPage'];
	}
	else
	{
		$numperpage = 50;
	}
	$smarty->assign("NUMPERPAGE", $numperpage);
	$upperModule = strtoupper($currentModule);
	if (CustomView::hasViewChanged($currentModule, $viewid))
	{
		$_SESSION[$upperModule.'_ORDER_BY'] = '';
	}
//<<<<<<<<<<<<<<<<<<< sorting - stored in session >>>>>>>>>>>>>>>>>>>>
	if ($_REQUEST['_order'] != '' && $_REQUEST['_order'] != $_SESSION[$upperModule.'_ORDER_BY'])
	{
		$order_by                           = $_REQUEST['_order'];
		$_SESSION[$upperModule.'_ORDER_BY'] = $order_by;
	}
	else if (isset($_SESSION[$upperModule.'_ORDER_BY']) && $_SESSION[$upperModule.'_ORDER_BY'] != "")
	{
		$order_by = $_SESSION[$upperModule.'_ORDER_BY'];
	}
	else
	{
		$order_by = $focus->getOrderBy();
	}
////////////////////////////////
	if ($_REQUEST['_sort'] != '' && $_REQUEST['_sort'] != $_SESSION[$upperModule.'_SORT_ORDER'])
	{
		$sorder                               = $_REQUEST['_sort'];
		$_SESSION[$upperModule.'_SORT_ORDER'] = $sorder;
	}
	else if (isset($_SESSION[$upperModule.'_SORT_ORDER']) && $_SESSION[$upperModule.'_SORT_ORDER'] != "")
	{
		$sorder = $_SESSION[$upperModule.'_SORT_ORDER'];
	}
	else
	{
		$sorder = $focus->getSortOrder();
	}
//<<<<<<<<<<<<<<<<<<< sorting - stored in session >>>>>>>>>>>>>>>>>>>>
//<<<<cutomview>>>>>>>
	$oCustomView          = new CustomView($currentModule);
	$viewid               = $oCustomView->getViewId($currentModule);
	$customviewcombo_html = $oCustomView->getCustomViewCombo($viewid);
	$viewnamedesc         = $oCustomView->getCustomViewByCvid($viewid);
	$edit_permit = $oCustomView->isPermittedCustomView($viewid, $currentModule);
	$smarty->assign("CV_EDIT_PERMIT", $edit_permit);
//<<<<<customview>>>>>
	$listview_check_button = ListView_Button_Check($module);
	$smarty->assign("LISTVIEW_CHECK_BUTTON", $listview_check_button);
	if ($viewid != 0)
	{
		$CActionDtls = $oCustomView->getCustomActionDetails($viewid);
	}
	elseif ($viewid == 0)
	{
		echo "<table border='0' cellpadding='5' cellspacing='0' width='100%' height='450px'><tr><td align='center' class='center'>";
		echo "<div style='border: 3px solid rgb(153, 153, 153); background-color: rgb(255, 255, 255); width: 55%; position: relative; z-index: 10000000;'>

		<table border='0' cellpadding='5' cellspacing='0' width='98%'>
		<tbody><tr>
		<td rowspan='2' width='11%'><img src='/images/denied.gif' ></td>
		<td style='border-bottom: 1px solid rgb(204, 204, 204);' nowrap='nowrap' width='70%'>
			<span class='genHeaderSmall'>$app_strings[LBL_PERMISSION]</span></td>
		</tr>
		<tr>
		<td class='small' align='right' nowrap='nowrap'><br>
		</td>
		</tr>
		</tbody></table>
		</div>";
		echo "</td></tr></table>";
		exit;
	}
	if ($viewnamedesc['viewname'] == 'All')
	{
		$smarty->assign("ALL", 'All');
	}
	$smarty->assign("CUSTOMVIEW_OPTION", $customviewcombo_html);
	$smarty->assign("VIEWID", $viewid);
	$smarty->assign("MOD", $mod_strings);
	$smarty->assign("APP", $app_strings);
	$smarty->assign("MODULE", $currentModule);
//Retreive the list from Database
//<<<<<<<<<customview>>>>>>>>>
	global $current_user;
	$queryGenerator = new QueryGenerator($currentModule, $current_user);
	if ($viewid != "0")
	{
		$queryGenerator->initForCustomViewById($viewid);
	}
	else
	{
		$queryGenerator->initForDefaultCustomView();
	}
//<<<<<<<<customview>>>>>>>>>
	$search      = new DataSearch($currentModule, $queryGenerator, $focus);
	$searchpanel = $search->getBasicSearchPanel();
	$searchpanel["货主"]='
        <span>
            <input name="'.$currentModule.'_suppliername" placeholder="请输入货主名称" value="'.$_REQUEST[$currentModule."_suppliername"].'" style="width:180px;">
        </span>';
	$searchpanel["产品编码"]='
        <span>
            <input name="'.$currentModule.'_barcode" placeholder="请输入产品编码" value="'.$_REQUEST[$currentModule."_barcode"].'" style="width:180px;">
        </span>';
	$searchpanel["产品条码"]='
        <span>
            <input name="'.$currentModule.'_itemcode" placeholder="请输入产品条码" value="'.$_REQUEST[$currentModule."_itemcode"].'" style="width:180px;">
        </span>';
	$smarty->assign('SEARCHPANEL', $searchpanel);
	$time = strtotime("today");
	$time = strtotime('-1 days', $time);
	$createnews = XN_Query::create('Content')->tag($focus->table_name)
		->filter('type', 'eic', $focus->table_name)
		->filter('my.createnew', '=', '1')
		->filter('published', '< ', date("Y-m-d H:i:s", $time))
		->end(-1)
		->execute();
	if (count($createnews) > 0)
	{
		foreach (array_chunk($createnews, 50, true) as $chunk_fields)
		{
			XN_Content::delete($chunk_fields, $focus->table_name);
		}
	}
	$query = XN_Query::create('Content')->tag($focus->table_name)
		->filter('type', 'eic', $focus->table_name)
		->filter('my.deleted', '=', '0')
		->order('updated',XN_Order::DESC);
	$search->setQuery($query);
	global $supplierusertype,$supplierid,$isplatagency;
	if($supplierusertype!="superadmin"){
		$query->filter("my.supplierid","=",$supplierid);
	}
	if(isset($_REQUEST[$currentModule."_suppliername"]) && $_REQUEST[$currentModule."_suppliername"]!="")
	{
		$input_suppliername=$_REQUEST[$currentModule."_suppliername"];
		$suppliersquery = XN_Query::create("Content")->tag("ma_suppliers")
			->filter("type", "eic", "ma_suppliers")
			->filter("my.suppliername", "like", $input_suppliername)
			->filter("my.deleted", "=", "0")
			->end(20)
			->execute();
		if(count($suppliersquery)>0){
			$supplier_ids=array();
			foreach($suppliersquery as $supplier_info){
				$supplier_ids[]=$supplier_info->id;
			}
			$query->filter("my.supplierid","in",$supplier_ids);
		}else{
			$query->filter("my.supplierid","=","0");
		}
	}

	if(isset($_REQUEST[$currentModule."_barcode"]) && $_REQUEST[$currentModule."_barcode"]!="")
	{
		$input_barcode=$_REQUEST[$currentModule."_barcode"];
		$barcodequery = XN_Query::create("Content")->tag("ma_inventorywarndetails")
			->filter("type", "eic", "ma_inventorywarndetails")
			->filter("my.barcode", "like", $input_barcode)
			->filter("my.deleted", "=", "0")
			->end(20)
			->execute();
		if(count($barcodequery)>0){
			$barcode_ids=array();
			foreach($barcodequery as $barcode_info){
				$barcode_ids[]=$barcode_info->my->record;
			}
			$query->filter("id","in",$barcode_ids);
		}else{
			$query->filter("id","=","0");
		}
	}

	if(isset($_REQUEST[$currentModule."_itemcode"]) && $_REQUEST[$currentModule."_itemcode"]!="")
	{
		$input_itemcode=$_REQUEST[$currentModule."_itemcode"];
		$itemcodequery = XN_Query::create("Content")->tag("ma_inventorywarndetails")
			->filter("type", "eic", "ma_inventorywarndetails")
			->filter("my.itemcode", "like", $input_itemcode)
			->filter("my.deleted", "=", "0")
			->end(20)
			->execute();
		if(count($itemcodequery)>0){
			$itemcode_ids=array();
			foreach($itemcodequery as $itemcode_info){
				$itemcode_ids[]=$itemcode_info->my->record;
			}
			$query->filter("id","in",$itemcode_ids);
		}else{
			$query->filter("id","=","0");
		}
	}

	$smarty->assign("ORDER_BY", $order_by);
	$query_order_by = $order_by;
	if (isset($order_by) && $order_by != '' && strncmp($order_by, 'my.', 3) != 0 && $order_by != 'updateDate' && $order_by != 'createdDate' && $order_by != 'published' && $order_by != 'updated' && $order_by != 'author' && $order_by != 'title')
	{
		$query_order_by = "my.".$order_by;
	}
	if (strtolower($sorder) == 'desc')
	{
		if (isset($focus->sortby_number_fields) && in_array($order_by, $focus->sortby_number_fields))
		{
			$query->order($query_order_by, XN_Order::DESC_NUMBER);
		}
		else
		{
			$query->order($query_order_by, XN_Order::DESC);
		}
		$smarty->assign("ORDER", "desc");
	}
	else
	{
		if (isset($focus->sortby_number_fields) && in_array($order_by, $focus->sortby_number_fields))
		{
			$query->order($query_order_by, XN_Order::ASC_NUMBER);
		}
		else
		{
			$query->order($query_order_by, XN_Order::ASC);
		}
		$smarty->assign("ORDER", "asc");
	}
	if (isset($_REQUEST['pageNum']) && $_REQUEST['pageNum'] != "")
	{
		$pagenum = $_REQUEST['pageNum'];
	}
	else
	{
		$pagenum = 1;
	}
	$smarty->assign("PAGENUM", $pagenum);
	$limit_start_rec = ($pagenum - 1) * $numperpage;
	if ($limit_start_rec < 0)
		$limit_start_rec = 0;
	$query->begin($limit_start_rec);
	$query->end($numperpage + $limit_start_rec);
	$list_result = $query->execute();
	$noofrows = $query->getTotalCount();
	$smarty->assign('NOOFROWS', $noofrows);
	$controller = new ListViewController($current_user, $queryGenerator);
	if (isset($changeArray) && is_array($changeArray))
	{
		$listview_header  = $controller->getListViewHeader($focus, $currentModule, "", $sorder, $order_by, $changeArray);
		$listview_entries = $controller->getListViewEntries($focus, $currentModule, $list_result, $navigation_array, $changeArray);
	}
	else
	{
		$listview_header  = $controller->getListViewHeader($focus, $currentModule, "", $sorder, $order_by);
		$listview_entries = $controller->getListViewEntries($focus, $currentModule, $list_result, $navigation_array);
	}

	$smarty->assign("LISTHEADER", $listview_header);
	$smarty->assign("LISTENTITY", $listview_entries);
	$smarty->assign("SEARCHTYPE", "1");
	global $startTime;
	$endTime = microtime();
	$smarty->assign("RUNTIME", round( microtime_diff($startTime, $endTime),2));

	if(isset($_REQUEST["mode"]) && $_REQUEST["mode"] == "ajax"){
		$smarty->display("ListViewEntries.tpl");
	}else
	{
		$smarty->display("ListView.tpl");
	}

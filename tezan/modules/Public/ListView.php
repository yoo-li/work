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
    //中英文对照
    global $app_strings, $mod_strings, $current_language;
    $current_module_strings = return_module_language($current_language, $currentModule);
    //根据当前模块名生成类
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
    //分页条用到的每页展示多少条
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

    //列表按哪个字段排序，默认按$focus->getOrderBy()里面的字段排序，如果点了某个列排序，就按这个列，且放入session
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
    //按哪个视图展示，就是展示哪几个字段的值
    $oCustomView          = new CustomView($currentModule);
    $viewid               = $oCustomView->getViewId($currentModule);
    $customviewcombo_html = $oCustomView->getCustomViewCombo($viewid);
    $viewnamedesc         = $oCustomView->getCustomViewByCvid($viewid);
    $edit_permit = $oCustomView->isPermittedCustomView($viewid, $currentModule);
    $smarty->assign("CV_EDIT_PERMIT", $edit_permit);
//<<<<<customview>>>>>
    $listview_check_button = ListView_Button_Check($currentModule);
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
    //查询语句类
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

    //形成搜索字段
    $search      = new DataSearch($currentModule, $queryGenerator, $focus);
    $searchpanel = $search->getBasicSearchPanel();
    //如果有自定义搜索字段，就加入$searchpanel这个数组
    $smarty->assign('SEARCHPANEL', $searchpanel);

    //删除几天之前的所有废数据（新建但没保存）
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
    //查询语句,最终要展示的哪些数据
    $query = XN_Query::create('Content')->tag($focus->table_name)
        ->filter('type', 'eic', $focus->table_name)
        ->filter('my.deleted', '=', '0');
    $search->setQuery($query);
    //自定义的查询字段，要自己链接到$query查询语句里面

    //权限设置。默认就是admin能看到所有数据，不是管理员的只能看到自己创建的数据
    if (isset($customFilter) && $customFilter)
    {
        $query->filter($customFilter);
    }
    else
    {
        $permission = listviewpermission($currentModule, $search);
        if (isset($permission))
            $query->filter($permission);
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
    //分页展示第几页
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
    //根据config.data.php里面配置的显示设置来形成数据，在模块里面解析之后形成table
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

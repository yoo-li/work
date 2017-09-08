<?php
    require_once('Smarty_setup.php');
    require_once('include/utils/utils.php');
    global $app_strings, $default_charset;
    global $currentModule, $current_user;
    $upperModule=$currentModule;
    $smarty = new vtigerCRM_Smarty;
    $popuptype = $_REQUEST["popuptype"];
    $smarty->assign("MOD", $mod_strings);
    $smarty->assign("APP", $app_strings);
    $smarty->assign("MODULE", $currentModule);
    require_once("modules/".$currentModule."/".$currentModule.".php");
    $focus = CRMEntity::getInstance($currentModule);
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
    $query_content = XN_Query::create('Content')->tag($focus->table_name)
        ->filter('type', 'eic', $focus->table_name)
        ->filter('my.deleted', '=', '0');
	
	global $current_user;
	if (!check_authorize('tezanadmin') && !is_admin($current_user)) { 
	    if(isset($_SESSION['supplierid']) && $_SESSION['supplierid'] != '')
	    {
	         $supplierid = $_SESSION['supplierid'];
			 $query_content->filter ( 'my.supplierid', '=', $supplierid);
	    } 
	}
	$query_content->filter ( 'my.approvalstatus', '=', '2');
	
    if (isset($_REQUEST['search_field']) && $_REQUEST['search_field'] != '' && isset($_REQUEST['search_text']) && $_REQUEST['search_text'] != '')
    {
        $query_content->filter('my.'.$_REQUEST['search_field'], 'like', $_REQUEST['search_text']);
        $smarty->assign("SEARCH_FIELD", $_REQUEST['search_field']);
        $smarty->assign("SEARCH_TEXT", $_REQUEST['search_text']);
    }
    if (isset($_REQUEST['filter']) && $_REQUEST['filter'] != '')
    {
        $filter = unserialize(base64_decode($_REQUEST['filter']));
        $query_content->filter($filter);
    }
    if (isset($_REQUEST['exclude']) && $_REQUEST['exclude'] != '' && $_REQUEST['exclude'] != 'undefined')
    {
        $exclude_list = explode(",", $_REQUEST['exclude']);
        $smarty->assign("EXCLUDE", $_REQUEST['exclude']);
        if ($currentModule != 'Users')
            $query_content->filter('id', '!in', $exclude_list);
        else
            $query_content->filter('my.profileid', '!in', $exclude_list);
        $url_string .= '&exclude='.$_REQUEST['exclude'];
    }
    if (isset($_REQUEST['query']) && $_REQUEST['query'] == 'true')
    {
        list($where, $ustring) = explode("#@@#", getWhereCondition($currentModule, $query_content));
        $url_string .= "&query=true".$ustring;
    }
    if (isset($where) && $where != '')
    {
        $query .= ' and '.$where;
    }
    //Added to fix the issue #2307
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
        $order_by = $focus->default_order_by;
    }
    ////////////////////////////////
    if ($_REQUEST['_sort'] != '' && $_REQUEST['_sort'] != $_SESSION[$upperModule.'_SORT_ORDER'])
    {
        $sorder                               = $_REQUEST['_sort'];
        $_SESSION[$upperModule.'_SORT_ORDER'] = $order_by;
    }
    else if (isset($_SESSION[$upperModule.'_SORT_ORDER']) && $_SESSION[$upperModule.'_SORT_ORDER'] != "")
    {
        $sorder = $_SESSION[$upperModule.'_SORT_ORDER'];
    }
    else
    {
        $sorder = $focus->default_sort_order;
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
            $query_content->order($query_order_by, XN_Order::DESC_NUMBER);
        }
        else
        {
            $query_content->order($query_order_by, XN_Order::DESC);
        }
        $smarty->assign("ORDER", "desc");
    }
    else
    {
        if (isset($focus->sortby_number_fields) && in_array($order_by, $focus->sortby_number_fields))
        {
            $query_content->order($query_order_by, XN_Order::ASC_NUMBER);
        }
        else
        {
            $query_content->order($query_order_by, XN_Order::ASC);
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
    $query_content->begin($limit_start_rec);
    $query_content->end($numperpage + $limit_start_rec);
    $list_result = $query_content->execute();
    $noofrows    = $query_content->getTotalCount();
    $smarty->assign('NOOFROWS', $noofrows);
    $listview_header_search = getSearchListHeaderValues($focus, $currentModule);
    $smarty->assign("SEARCHLISTHEADER", $listview_header_search);
    $listview_header = getSearchListViewHeader($focus, $currentModule, $url_string, $sorder, $order_by);
    $smarty->assign("LISTHEADER", $listview_header);
    $listview_entries = getSearchListViewEntries($focus, $currentModule, $list_result);
    $smarty->assign("LISTENTITY", $listview_entries);
    $smarty->assign("MODULE", $currentModule);
    $smarty->assign("POPUPTYPE", $_REQUEST["popuptype"]);
    $smarty->assign("RECORDID", $_REQUEST["recordid"]);
    $smarty->assign("EXCLUDE", $_REQUEST["exclude"]);
    $smarty->assign("PARENT_MODULE", $_REQUEST['parent_module']);
    $smarty->assign("FILTER", $_REQUEST["filter"]);
    $smarty->assign("SELECTMODE", $_REQUEST["mode"]);
    $smarty->assign("SELECTID", explode(",", $_REQUEST['select']));
    $smarty->assign("SELECTIDS", $_REQUEST['select']);
    $smarty->display("Popup.tpl");
?>

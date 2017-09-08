<?php
	 
ini_set('memory_limit','2048M');
set_time_limit(0);
header('Content-Type: text/html; charset=utf-8');
session_start();

 
$tabs = array(
	//'模块ID'=>array('模块名称',是否需要提交上线功能,),mode=0,普通功能,mode=1,提交上线功能,mode=2,提交上线与启用停用功能,mode=3,分类功能,
	// '5050'=>array('module'=>'Erp_Customers','mode'=>2,), /*客户*/
	 '5051'=>array('module'=>'Erp_Contacts','mode'=>2,), /*联系人*/
	//'5052'=>array('module'=>'Erp_ContractCategorys','mode'=>3,), /*合同分类*/
	// '5053'=>array('module'=>'Erp_Contracts','mode'=>1,), /*合同管理*/
	// '5054'=>array('module'=>'Erp_Budgets','mode'=>0,), /*年度预算*/
	// '5055'=>array('module'=>'Erp_Reimbursements','mode'=>1,), /*报账管理*/
	// '5056'=>array('module'=>'Erp_Loans','mode'=>1,), /*借款管理*/
	// '5057'=>array('module'=>'Erp_Receivables','mode'=>0,), /*应收款*/
	// '5058'=>array('module'=>'Erp_Payables','mode'=>0,), /*应付款*/
	// '5059'=>array('module'=>'Erp_ReceivableRecords','mode'=>0,), /*应收记录*/
	// '5060'=>array('module'=>'Erp_PayablesRecords','mode'=>0,), /*应付记录*/
	// '5061'=>array('module'=>'Erp_ProjectResolves','mode'=>0,), /*项目分解*/
	// '5062'=>array('module'=>'Erp_ProjectMaintains','mode'=>0,), /*项目维护*/
	// '5063'=>array('module'=>'Erp_ProjectGanttCharts','mode'=>0,), /*项目甘特图*/
	// '5064'=>array('module'=>'Erp_Artisans','mode'=>2,), /*技术人员*/
	// '5065'=>array('module'=>'Erp_BillWaters','mode'=>0,), /*账单流水*/
	// '5066'=>array('module'=>'Erp_WorkLogs','mode'=>0,), /*工作日志*/
	// '5067'=>array('module'=>'Erp_Products','mode'=>2,), /*采购商品*/
	// '5068'=>array('module'=>'Erp_Inventorys','mode'=>0,), /*商品库存*/
	// '5069'=>array('module'=>'Erp_PurchaseOrders','mode'=>1,), /*采购订单*/
	// '5010'=>array('module'=>'Sop_WorkSops','mode'=>0,),  /*SOP列表*/
	//     '5020'=>array('module'=>'Sop_WorkNotices','mode'=>0,),  /*SOP通知*/
	// '5002'=>array('module'=>'Sop_Plugins','mode'=>2,), /*插件设置*/
	// '5003'=>array('module'=>'Sop_DocNums','mode'=>2,), /*插件设置*/
	// '5004'=>array('module'=>'Sop_DocTemplates','mode'=>2,), /*文档模板*/
	//     '5005'=>array('module'=>'Sop_Settings','mode'=>0,), /*运维设置*/
	'5000'=>array('module'=>'Sop_Categorys','mode'=>3,), /*流程分类*/
);

$tabid   = '5000';
$tabname = 'Sop_Categorys';
		


foreach($tabs as $tabid => $module_info)
{
	$module = $module_info['module'];
	$mode = $module_info['mode'];
	if ($mode == 3)
	{
		init_category_module($module,$tabid);
	}
	else
	{
		init_module($module,$tabid,$mode);
	}
	
}


function init_module($module,$tabid,$mode)
{   
    if(!@is_dir($_SERVER['DOCUMENT_ROOT'].'/modules/'.$module))
    {
        @mkdir($_SERVER['DOCUMENT_ROOT'].'/modules/'.$module);
		echo '建立模块【' . $module . '】目录...<br>';
    }
    if(!@is_dir($_SERVER['DOCUMENT_ROOT'].'/modules/'.$module."/language"))
    {
        @mkdir($_SERVER['DOCUMENT_ROOT'].'/modules/'.$module."/language"); 
    }
	
	
	$config_func_php = "<?php\nrequire_once('modules/Public/config.func.php');"; 
	nocoverwritefile($module,"config.func.php",$config_func_php);
	
	$config_inc_php = "<?php
\$Create = true;
\$Delete = true;
\$MassEdit = false;
\$CustomMassDelete = false;
if(!isset(\$_SESSION['supplierid']) || \$_SESSION['supplierid'] == '')
{
	\$Create = false;
	\$Delete = true;
}

\$actionmapping = array ();
?>"; 

	$config_approval_inc_php = "<?php
\$Create = true;
\$Delete = true;
\$MassEdit = false;
\$CustomMassDelete = false;
if(!isset(\$_SESSION['supplierid']) || \$_SESSION['supplierid'] == '')
{
	\$Create = false;
	\$Delete = true;
}

\$actionmapping = array (
	array('actionname' => 'SimulateApply','securitycheck' => '1','type'=>'button','func'=>'check_SimulateApply'),
);

if (!function_exists('check_SimulateApply')) 
{
    function check_SimulateApply(\$module,\$focus)
    {
        global \$current_user,\$supplierid,\$supplierusertype;
        if (isset(\$supplierid) && \$supplierid != '' && \$focus->column_fields[strtolower(\$module).'status'] == 'JustCreated')
        {
            if(\$focus->mode=='edit')
			{
				global \$supplierusertype, \$supplierid;
				\$tabid = getTabid(\$module);
				\$supplier_approvalflows = XN_Query::create('Content')
											->tag('supplier_approvalflows')
											->filter('type', 'eic', 'supplier_approvalflows')
											->filter('my.supplierid', '=', \$supplierid)
											->filter('my.approvalflowsstatus', '=', '1')
											->filter('my.deleted', '=', '0')
											->filter('my.customapprovalflowtabid', '=', \$tabid)
											->end(1)
											->execute();
				\$approvalflows    = XN_Query::create('Content')
											->tag('approvalflows')
											->filter('type', 'eic', 'approvalflows')
											->filter('my.approvalflowsstatus', '=', '1')
											->filter('my.deleted', '=', '0')
											->filter('my.tabid', '=', \$tabid)
											->end(1)
											->execute();
				if (count(\$supplier_approvalflows) == 0 && count(\$approvalflows) == 0)
				{
	                if (\$focus->column_fields['approvalstatus'] != '2')
	                {
	                    return '<a class=\"btn btn-default\" data-toggle=\"dialog\" data-icon=\"lock\" data-mask=\"true\" data-maxable=\"false\" data-resizable=\"false\" href=\"index.php?module='.\$module.'&amp;action=SimulateApply&amp;record='.\$focus->id.'\" > 提交上线</a>';
	                }
	                else
	                {
	                    return '<a disabled class=\"btn btn-default\" data-icon=\"lock\" href=\"javascript:;\" > 提交上线</a>';
	                }
				} 
            }
			else
			{
                return '';
            }
        }
    }
}
?>";

$config_status_approval_inc_php = "<?php
\$Create = true;
\$Delete = true;
\$MassEdit = false;
\$CustomMassDelete = false;
if(!isset(\$_SESSION['supplierid']) || \$_SESSION['supplierid'] == '')
{
	\$Create = false;
	\$Delete = true;
}

\$actionmapping = array (
	array('actionname' => 'SimulateApply','securitycheck' => '1','type'=>'button','func'=>'check_SimulateApply'),
    array('actionname' => 'Enable','securitycheck' => '1','func'=>'check_module_enable','type'=>'listview'),
    array('actionname' => 'Disable','securitycheck'=>'1','func'=>'check_module_disable','type'=>'listview'),
);

if (!function_exists('check_module_enable')) {
    function check_module_enable(){
        global \$currentModule;
        return '<a data-id=\"edit\" class=\"btn btn-default\" data-group=\"ids\" data-icon=\"edit\" data-toggle=\"doajaxchecked\" href=\"index.php?module='.\$currentModule.'&action=Enable\" data-confirm-msg=\"确实要启用吗?\"><span>启用</span></a>';
    }
}

if (!function_exists('check_module_disable')) {
    function check_module_disable(){
        global \$currentModule;
        return '<a data-id=\"edit\" class=\"btn btn-default\" data-group=\"ids\" data-icon=\"edit\" data-toggle=\"doajaxchecked\" href=\"index.php?module='.\$currentModule.'&action=Disable\" data-confirm-msg=\"确实要停用吗?\"><span>停用</span></a>';
    }
}
if (!function_exists('check_SimulateApply')) 
{
    function check_SimulateApply(\$module,\$focus)
    {
        global \$current_user,\$supplierid,\$supplierusertype;
        if (isset(\$supplierid) && \$supplierid != '' && \$focus->column_fields[strtolower(\$module).'status'] == 'JustCreated')
        {
            if(\$focus->mode=='edit')
			{
				global \$supplierusertype, \$supplierid;
				\$tabid = getTabid(\$module);
				\$supplier_approvalflows = XN_Query::create('Content')
											->tag('supplier_approvalflows')
											->filter('type', 'eic', 'supplier_approvalflows')
											->filter('my.supplierid', '=', \$supplierid)
											->filter('my.approvalflowsstatus', '=', '1')
											->filter('my.deleted', '=', '0')
											->filter('my.customapprovalflowtabid', '=', \$tabid)
											->end(1)
											->execute();
				\$approvalflows    = XN_Query::create('Content')
											->tag('approvalflows')
											->filter('type', 'eic', 'approvalflows')
											->filter('my.approvalflowsstatus', '=', '1')
											->filter('my.deleted', '=', '0')
											->filter('my.tabid', '=', \$tabid)
											->end(1)
											->execute();
				if (count(\$supplier_approvalflows) == 0 && count(\$approvalflows) == 0)
				{
	                if (\$focus->column_fields['approvalstatus'] != '2')
	                {
	                    return '<a class=\"btn btn-default\" data-toggle=\"dialog\" data-icon=\"lock\" data-mask=\"true\" data-maxable=\"false\" data-resizable=\"false\" href=\"index.php?module='.\$module.'&amp;action=SimulateApply&amp;record='.\$focus->id.'\" > 提交上线</a>';
	                }
	                else
	                {
	                    return '<a disabled class=\"btn btn-default\" data-icon=\"lock\" href=\"javascript:;\" > 提交上线</a>';
	                }
				} 
            }
			else
			{
                return '';
            }
        }
    }
}
?>";

   if ($mode == 1)
   {
   		writefile($module,"config.inc.php",$config_approval_inc_php);
   }
   else if ($mode == 2)
   {
   		writefile($module,"config.inc.php",$config_status_approval_inc_php);
   }
   else
   {
   		writefile($module,"config.inc.php",$config_inc_php);
   }
	
	 
	nocoverwritefile($module,$module.".js","");
	
	$language_file = "<?php 
\$mod_strings = Array(
	'LBL_BASE_INFORMATION' => '基本信息', 
	'Supplier'			   => '商家', 
	'{MODULE} Status'	       => '状态',
);
?>";
    $language_file = str_replace("{LOWERMODULE}",strtolower($module),$language_file);
	$language_file = str_replace("{MODULE}",$module,$language_file); 
	nocoverwritefile($module,"language/zh_cn.lang.php",$language_file);
	
	writefile($module,"CustomView.php","<?php\ninclude('modules/CustomView/index.php');\n?>"); 
	
	writefile($module,"massdelete.php","<?php\ninclude('modules/Public/massdelete.php');\n"); 
	writefile($module,"Popup.php","<?php\nrequire_once('Popup.php');\n"); 
	
	writefile($module,"index.php","<?php\nglobal \$currentModule;\ninclude ('modules/'.\$currentModule.'/ListView.php');\n?>");
	
	$Save_file = "<?php  
require_once('modules/Users/Users.php');
require_once('include/utils/UserInfoUtil.php');
 
global \$supplierid,\$currentModule,\$current_user;  
\$focus = CRMEntity::getInstance(\$currentModule);  
setObjectValuesFromRequest(\$focus);
if(\$focus->column_fields['supplierid'] == '' && \$focus->mode == \"create\")
{
	\$focus->column_fields['supplierid'] = \$supplierid;
} 
if(\$focus->column_fields[strtolower(\$currentModule). 'status'] == '' && \$focus->mode == \"create\")
{
    \$focus->column_fields[strtolower(\$currentModule). 'status'] = 'JustCreated'; 
} 

try
{  
	\$focus->saveentity(\$currentModule);
} 
catch (XN_Exception \$e) 
{
	echo '{\"statusCode\":\"300\",\"message\":\"'.\$e->getMessage().'\"}';
	die;
}

echo '{\"statusCode\":\"200\",\"message\":null,\"tabid\":\"'.\$currentModule.'\",\"closeCurrent\":true,\"forward\":null}';
?>";
	writefile($module,"Save.php",$Save_file);
	
	
	$ListView_file = "<?php
if(\$_REQUEST['mode'] == 'Export')
{
	include ('modules/Public/SheetExportExcel.php');
	die();
} 

global \$currentModule,\$app_strings,\$mod_strings,\$current_language;
require_once('modules/'.\$currentModule.'/'.\$currentModule.'.php');
require_once('Smarty_setup.php');
require_once('include/utils/utils.php');
require_once('include/utils/DataSearch.php');
require_once('modules/CustomView/CustomView.php');
 
\$current_module_strings = return_module_language(\$current_language, \$currentModule);
\$focus = CRMEntity::getInstance(\$currentModule);
\$focus->initSortbyField(\$currentModule);
\$category = getParentTab();
\$smarty = new vtigerCRM_Smarty;

if(\$_REQUEST['errormsg'] != '')
{
    \$errormsg = \$_REQUEST['errormsg'];
    \$smarty->assign(\"ERROR\",\$errormsg);
}
else
{
        \$smarty->assign(\"ERROR\",\"\");
}
if(\$_REQUEST['numPerPage'] != '' && \$_REQUEST['numPerPage'] != \$_SESSION['numPerPage'])
{
	\$numperpage = \$_REQUEST['numPerPage'];
	\$_SESSION['numPerPage'] = \$numperpage;
} 
else if(isset(\$_SESSION['numPerPage']) && \$_SESSION['numPerPage'] != \"\")
{
	\$numperpage = \$_SESSION['numPerPage'];
}
else
{
	\$numperpage = 50;
}
\$smarty->assign(\"NUMPERPAGE\", \$numperpage);

\$upperModule = strtoupper(\$currentModule);

if(CustomView::hasViewChanged(\$currentModule,\$viewid)) {
	\$_SESSION[\$upperModule.'_ORDER_BY'] = '';
}
 

if(\$_REQUEST['_order'] != '' && \$_REQUEST['_order'] != \$_SESSION[\$upperModule.'_ORDER_BY'])
{
	\$order_by = \$_REQUEST['_order'];
	\$_SESSION[\$upperModule.'_ORDER_BY'] = \$order_by;
} 
else if(isset(\$_SESSION[\$upperModule.'_ORDER_BY']) && \$_SESSION[\$upperModule.'_ORDER_BY'] != \"\")
{
	\$order_by = \$_SESSION[\$upperModule.'_ORDER_BY'];
}
else
{
	\$order_by = \$focus->getOrderBy();
}

if(\$_REQUEST['_sort'] != '' && \$_REQUEST['_sort'] != \$_SESSION[\$upperModule.'_SORT_ORDER'])
{
	\$sorder= \$_REQUEST['_sort'];
	\$_SESSION[\$upperModule.'_SORT_ORDER'] = \$sorder;
} 
else if(isset(\$_SESSION[\$upperModule.'_SORT_ORDER']) && \$_SESSION[\$upperModule.'_SORT_ORDER'] != \"\")
{
	\$sorder = \$_SESSION[\$upperModule.'_SORT_ORDER'];
}
else
{
	\$sorder = \$focus->getSortOrder();
}

\$oCustomView = new CustomView(\$currentModule);
\$viewid = \$oCustomView->getViewId(\$currentModule);
\$customviewcombo_html = \$oCustomView->getCustomViewCombo(\$viewid);
\$viewnamedesc = \$oCustomView->getCustomViewByCvid(\$viewid);

\$edit_permit = \$oCustomView->isPermittedCustomView(\$viewid,\$currentModule);
\$smarty->assign(\"CV_EDIT_PERMIT\",\$edit_permit);
 

\$listview_check_button = ListView_Button_Check(\$module);
\$smarty->assign(\"LISTVIEW_CHECK_BUTTON\", \$listview_check_button);

if(\$viewid != 0)
{
        \$CActionDtls = \$oCustomView->getCustomActionDetails(\$viewid);
}
elseif(\$viewid ==0)
{
	echo \"<table border='0' cellpadding='5' cellspacing='0' width='100%' height='450px'><tr><td align='center' class='center'>\";
	echo \"<div style='border: 3px solid rgb(153, 153, 153); background-color: rgb(255, 255, 255); width: 55%; position: relative; z-index: 10000000;'>

		<table border='0' cellpadding='5' cellspacing='0' width='98%'>
		<tbody><tr>
		<td rowspan='2' width='11%'><img src='/images/denied.gif' ></td>
		<td style='border-bottom: 1px solid rgb(204, 204, 204);' nowrap='nowrap' width='70%'>
			<span class='genHeaderSmall'>\$app_strings[LBL_PERMISSION]</span></td>
		</tr>
		<tr>
		<td class='small' align='right' nowrap='nowrap'><br>
		</td>
		</tr>
		</tbody></table>
		</div>\";
	echo \"</td></tr></table>\";
	exit;
}

if(\$viewnamedesc['viewname'] == 'All')
{
	\$smarty->assign(\"ALL\", 'All');
}

\$smarty->assign(\"CUSTOMVIEW_OPTION\",\$customviewcombo_html);
\$smarty->assign(\"VIEWID\", \$viewid);
\$smarty->assign(\"MOD\", \$mod_strings);
\$smarty->assign(\"APP\", \$app_strings);
\$smarty->assign(\"MODULE\",\$currentModule);
 
global \$current_user;
\$queryGenerator = new QueryGenerator(\$currentModule, \$current_user);
if (\$viewid != \"0\") 
{
	\$queryGenerator->initForCustomViewById(\$viewid);
} 
else 
{
	\$queryGenerator->initForDefaultCustomView();
}
 


\$search = new DataSearch(\$currentModule,\$queryGenerator,\$focus);
\$searchpanel = \$search->getBasicSearchPanel();

\$smarty->assign('SEARCHPANEL',\$searchpanel);  

\$query = XN_Query::create ( 'Content' ) ->tag(\$focus->table_name)
	->filter ( 'type', 'eic', \$focus->table_name)
	->filter ( 'my.deleted', '=', '0' );

global \$current_user;
if (!check_authorize('tezanadmin') && !is_admin(\$current_user)) 
{
    if(isset(\$_SESSION['supplierid']) && \$_SESSION['supplierid'] != '')
    {
        \$supplierid = \$_SESSION['supplierid'];
		\$query->filter ( 'my.supplierid', '=', \$supplierid);
    } 
}  
\$search->setQuery(\$query); 
 
\$smarty->assign(\"ORDER_BY\", \$order_by);
\$query_order_by = \$order_by;
if (isset(\$order_by) && \$order_by != '' && strncmp(\$order_by,'my.',3)!=0 && \$order_by != 'updateDate' && \$order_by != 'createdDate' && \$order_by != 'published' && \$order_by != 'updated' && \$order_by != 'author' && \$order_by!= 'title')
{    		
	\$query_order_by = \"my.\".\$order_by;
}
    		
if (strtolower(\$sorder) == 'desc')
{
	if (isset(\$focus->sortby_number_fields) && in_array(\$order_by,\$focus->sortby_number_fields))
	{
	    \$query->order(\$query_order_by,XN_Order::DESC_NUMBER);
	}
	else
	{
		\$query->order(\$query_order_by,XN_Order::DESC);
	}
	\$smarty->assign(\"ORDER\", \"desc\");
}
else 
{
	if (isset(\$focus->sortby_number_fields) && in_array(\$order_by,\$focus->sortby_number_fields))
	{
		\$query->order(\$query_order_by,XN_Order::ASC_NUMBER);
	}
	else
	{
		\$query->order(\$query_order_by,XN_Order::ASC);
	} 
	\$smarty->assign(\"ORDER\", \"asc\");
}
	

if(isset(\$_REQUEST['pageNum']) && \$_REQUEST['pageNum'] != \"\")
{
	\$pagenum = \$_REQUEST['pageNum'];
}
else
{
	\$pagenum = 1;
}
\$smarty->assign(\"PAGENUM\", \$pagenum);

\$limit_start_rec = (\$pagenum-1) * \$numperpage;
if (\$limit_start_rec < 0) \$limit_start_rec = 0;
\$query->begin(\$limit_start_rec);
\$query->end(\$numperpage+\$limit_start_rec);
\$list_result = \$query->execute();
\$noofrows = \$query->getTotalCount();
\$smarty->assign('NOOFROWS',\$noofrows);

\$controller = new ListViewController(\$current_user, \$queryGenerator);
if(isset(\$changeArray) &&is_array(\$changeArray)){
    \$listview_header = \$controller->getListViewHeader(\$focus,\$currentModule,\"\",\$sorder,\$order_by,\$changeArray);
    \$listview_entries = \$controller->getListViewEntries(\$focus,\$currentModule,\$list_result,\$navigation_array,\$changeArray);
}else{
    \$listview_header = \$controller->getListViewHeader(\$focus,\$currentModule,\"\",\$sorder,\$order_by);
    \$listview_entries = \$controller->getListViewEntries(\$focus,\$currentModule,\$list_result,\$navigation_array);
}
\$smarty->assign(\"LISTHEADER\", \$listview_header);
\$smarty->assign(\"LISTENTITY\", \$listview_entries);

if(isset(\$_REQUEST[\"mode\"]) && \$_REQUEST[\"mode\"] == \"ajax\")
{
    \$smarty->display(\"ListViewEntries.tpl\");
}
else
{
    \$smarty->display(\"ListView.tpl\");
}
?>";
	writefile($module,"ListView.php",$ListView_file);
	
	
	$EditView_file = "<?php
require_once('Smarty_setup.php');
require_once('include/utils/utils.php');
global \$currentModule,\$app_strings, \$mod_strings, \$theme; 
require_once('modules/'.\$currentModule.'/'.\$currentModule.'.php');
 
\$focus  = CRMEntity::getInstance(\$currentModule);
\$smarty = new vtigerCRM_Smarty();

\$focus->retrieve_entity_info(\$_REQUEST['record'], \$currentModule);

\$smarty->assign(\"HASAPPROVALS\", \$focus->hasapprovals);
\$smarty->assign(\"APPROVALSTATUS\", \$focus->approvalstatus);
if (isset(\$readonly) && \$readonly == 'true')
	\$smarty->assign(\"READONLY\", \$readonly);
else
	\$smarty->assign(\"READONLY\", \$focus->readOnly);
if (isset(\$customReadonly))
{
	\$smarty->assign(\"READONLY\", \$customReadonly);
}
if (\$focus->column_fields['approvalstatus'] == '2')
{
	\$smarty->assign(\"READONLY\", 'true');
}
\$smarty->assign(\"APPROVALID\", \$focus->approvalid);
\$smarty->assign(\"DETAILAPPROVAL\", \$focus->detailapproval);
\$smarty->assign(\"HEADERDETAILS\", \$focus->headerdetails);
\$smarty->assign(\"DETAILS\", \$focus->details);
\$smarty->assign(\"PARAMS\", \$params);

if (empty(\$_REQUEST['record']) && \$focus->mode != 'edit')
{
	setObjectValuesFromRequest(\$focus);
}

\$disp_view = getView(\$focus->mode);
\$smarty->assign(\"BLOCKS\", getBlocks(\$currentModule, \$disp_view, \$focus->mode, \$focus->column_fields));
\$smarty->assign(\"OP_MODE\", \$disp_view);
\$smarty->assign(\"MODULE\", \$currentModule);
\$smarty->assign(\"SINGLE_MOD\", \$currentModule);
\$smarty->assign(\"MOD\", \$mod_strings);
\$smarty->assign(\"APP\", \$app_strings);
\$smarty->assign(\"ID\", \$focus->id);

if (\$focus->mode == 'edit')
{
	\$smarty->assign(\"MODE\", \$focus->mode);
}
else
{
	\$smarty->assign(\"MODE\", 'create');
}
\$tabid = getTabid(\$currentModule);
\$check_button = Button_Check(\$module);
\$smarty->assign(\"CHECK\", \$check_button);
\$editview_check_button = EditView_Button_Check(\$module, \$focus);
\$smarty->assign(\"EDITVIEW_CHECK_BUTTON\", \$editview_check_button);
\$ajax_panel_check = Ajax_Panel_Check(\$module, \$focus);
\$smarty->assign(\"AJAX_PANEL_CHECK\", \$ajax_panel_check);
\$smarty->assign(\"MOD_SEQ_ID\", getModuleModentityNum(\$focus, \$module));
\$smarty->assign(\"CURRENT_USERID\", \$current_user->id);
\$smarty->assign(\"CREATEUSER\", getPersonmanFromFocus(\$focus));
\$smarty->assign(\"CREATEDATE\", \$focus->column_fields['published']);
\$smarty->assign(\"CURRENTRECORDNUM\", getRecordNum(\$focus, \$module));
if (isset(\$filter) && \$filter != \"\")
{
	\$smarty->assign(\"FILTER\", \$filter);
}
\$guid = guid();
XN_MemCache::put(\$guid, \"token_edit_\".XN_Profile::\$VIEWER, \"600\");
\$smarty->assign(\"TOKEN\", \$guid);
\$smarty->assign(\"domain\", getdoamin());
\$smarty->display(\"salesEditView.tpl\");
?>";
	writefile($module,"EditView.php",$EditView_file);
	
	$SimulateApply_file = "<?php 
global \$mod_strings,\$app_strings,\$theme,\$currentModule,\$current_user,\$supplierid,\$supplierusertype;

if (isset(\$_REQUEST['record']) && \$_REQUEST['record'] != \"\" && 
    isset(\$_REQUEST['type']) && \$_REQUEST['type'] == \"submit\" )
{
    try {
        \$record = \$_REQUEST['record'];  
		\$loadcontent = XN_Content::load(\$record,strtolower(\$currentModule)); 
		\$loadcontent->my->approvalstatus = '2';
		\$status = strtolower(\$currentModule).'status';
		\$loadcontent->my->\$status = 'Agree';
        \$loadcontent->my->hitshelf = 'on';
		\$loadcontent->my->finishapprover = XN_Profile::\$VIEWER;
		\$loadcontent->my->submitapprovalreplydatetime = date(\"Y-m-d H:i\");    
		\$loadcontent->save(strtolower(\$currentModule).','.strtolower(\$currentModule).'_'.\$supplierid);   
        echo '{\"statusCode\":\"200\",\"message\":null,\"tabid\":\"edit\",\"closeCurrent\":true,\"forward\":null}';
    } 
	catch ( XN_Exception \$e )
    {
        echo '{\"statusCode\":\"300\",\"message\":\"'.\$e->getMessage().'\"}';
    }
    die();
}


require_once('Smarty_setup.php');
require_once('include/utils/utils.php');

\$smarty = new vtigerCRM_Smarty;

\$smarty->assign(\"MODULE\",\$currentModule);
\$smarty->assign(\"APP\",\$app_strings);
\$smarty->assign(\"MOD\", \$mod_strings);

if(isset(\$_REQUEST['record']) && \$_REQUEST['record'] !='') 
{
    \$record=\$_REQUEST['record']; 
	\$msg = \"当前状态：未提交\";
    \$msg = '<div style=\"width:99%;height:136px\"><textarea readonly rows=\"8\" style=\"width:100%;height:125px\"    class=\"detailedViewTextBox\">'.\$msg.'</textarea></div>';
	\$msg .= '<div style=\"width:100%\"><font color=\"red\" size=\"2\">'.getTranslatedString('LBL_APPROVALS_SURE_BUTTON_LABEL').'后，您将没有权限再进行修改，是否确定提交?</font></div>'; 
	\$smarty->assign(\"MSG\", \$msg);
	\$smarty->assign(\"SUBMODULE\", \$currentModule);
	\$smarty->assign(\"SUBACTION\", 'SimulateApply'); 
	\$smarty->assign(\"OKBUTTON\", getTranslatedString('LBL_APPROVALS_SURE_BUTTON_LABEL'));
    \$smarty->assign(\"CANCELBUTTON\", getTranslatedString('LBL_CANCEL_BUTTON_LABEL'));
    \$smarty->assign(\"RECORD\", \$record);
}

\$smarty->display('MessageBox.tpl');
?>";

	$Enable_file = "<?php
global \$mod_strings,\$app_strings,\$theme,\$currentModule,\$current_user,\$supplierid,\$supplierusertype;
\$ids=\$_REQUEST['ids'];
\$ids=explode(\",\",\$ids);
\$lists=XN_Content::loadMany(\$ids,strtolower(\$currentModule)); 
\$tag = strtolower(\$currentModule).\",\".strtolower(\$currentModule).\"_\".\$supplierid; 
foreach(\$lists as \$info)
{
	if (\$info->my->status != 0)
	{
	    \$info->my->status=0;
	    \$info->save(\$tag);  
	} 
} 
echo '{\"statusCode\":\"200\",\"message\":\"启用成功！\"}';";
	$Disable_file = "<?php
global \$mod_strings,\$app_strings,\$theme,\$currentModule,\$current_user,\$supplierid,\$supplierusertype;
\$ids=\$_REQUEST['ids'];
\$ids=explode(\",\",\$ids);
\$lists=XN_Content::loadMany(\$ids,strtolower(\$currentModule)); 
 
\$tag = strtolower(\$currentModule).\",\".strtolower(\$currentModule).\"_\".\$supplierid; 
foreach(\$lists as \$info)
{
	if (\$info->my->status != 1)
	{
	    \$info->my->status = 1;
	    \$info->save(\$tag);  
	} 
} 
echo '{\"statusCode\":\"200\",\"message\":\"停用成功！\"}';";

 
if ($mode == 1)
{
	 writefile($module,"SimulateApply.php",$SimulateApply_file);
	 $datafile = $_SERVER['DOCUMENT_ROOT'].'/modules/'.$module.'/Enable.php';
	 if (@file_exists($datafile))
	 {
		 @unlink($datafile);
	 } 
	 $datafile = $_SERVER['DOCUMENT_ROOT'].'/modules/'.$module.'/Disable.php';
	 if (@file_exists($datafile))
	 {
		 @unlink($datafile);
	 }
}  
else if ($mode == 2)
{
	writefile($module,"SimulateApply.php",$SimulateApply_file);
	writefile($module,"Enable.php",$Enable_file);
	writefile($module,"Disable.php",$Disable_file);
}  
else
{
	 $datafile = $_SERVER['DOCUMENT_ROOT'].'/modules/'.$module.'/SimulateApply.php';
	 if (@file_exists($datafile))
	 {
		 @unlink($datafile);
	 } 
	 $datafile = $_SERVER['DOCUMENT_ROOT'].'/modules/'.$module.'/Enable.php';
	 if (@file_exists($datafile))
	 {
		 @unlink($datafile);
	 } 
	 $datafile = $_SERVER['DOCUMENT_ROOT'].'/modules/'.$module.'/Disable.php';
	 if (@file_exists($datafile))
	 {
		 @unlink($datafile);
	 }
}
	
	
	$Module_file = "<?php
include_once('config.php');
require_once('include/utils/utils.php');

class {MODULE} extends CRMEntity 
{ 
	public \$table_name = '{LOWERMODULE}';
	//public \$datatype='7'; 
	public \$table_index= 'id';
	public \$tab_name = Array('{LOWERMODULE}');
	public \$tab_name_index = Array('{MODULE}'=>'id');
	public \$customFieldTable = Array('{MODULE}', 'id');
	public \$column_fields = Array();
	public \$sortby_fields = Array('{LOWERMODULE}status');
	public \$list_link_field= 'id';
	public \$default_order_by = 'published';
	public \$default_sort_order = 'DESC';
	public \$search_fields = Array();   
	public \$search_fields_name = Array();
	public \$mandatory_fields = Array('published');
    public \$special_search_fields = array();
	var \$popup_fields = Array('{LOWERMODULE}status');
	var \$filter_fields = Array('{LOWERMODULE}status'); 
	var \$sortby_number_fields = Array('{LOWERMODULE}status','published');
	
    function {MODULE}() 
	{ 
		\$this->column_fields = getColumnFields('{MODULE}');
	}

	function save_module(\$module){}  

	function getSortOrder() 
	{ 
		if(isset(\$_REQUEST['sorder']))
			\$sorder = \$_REQUEST['sorder'];
		else
			\$sorder = ((\$_SESSION[strtoupper(\$this->table_name).'_SORT_ORDER'] != '')?(\$_SESSION[strtoupper(\$this->table_name).'_SORT_ORDER']):(\$this->default_sort_order));
		return \$sorder;
	}
	
	function getOrderBy() 
	{ 
		\$use_default_order_by = \$this->default_order_by;
		if (isset(\$_REQUEST['order_by']))
			\$order_by = \$_REQUEST['order_by'];
		else
			\$order_by = ((\$_SESSION[strtoupper(\$this->table_name).'_ORDER_BY'] != '')?(\$_SESSION[strtoupper(\$this->table_name).'_ORDER_BY']):(\$use_default_order_by));
		return \$order_by;
	}
}?>";
    $Module_file = str_replace("{LOWERMODULE}",strtolower($module),$Module_file);
	$Module_file = str_replace("{MODULE}",$module,$Module_file);
	writefile($module,$module.".php",$Module_file);
	
	
	$Config_Data_file = "<?php

\$tabid  = 'TABID';
\$tabname  = '{MODULE}';

\$config_tabs =  array (  	 			    
					'tabname' => '{MODULE}',
					'tablabel' => '{MODULE}',
				    'presence' => '0',
				    'customized' => '0',
				    'isentitytype' => '1',
				    'tabsequence' => 'TABID',
				    'ownedby' => '0',
					);

\$Config_Blocks = array (
	  1 => array (	    
	    'blocklabel' => 'LBL_BASE_INFORMATION',
	    'sequence' => '1',
	    'show_title' => '0',
	    'visible' => '0',
	    'create_view' => '0',
	    'edit_view' => '0',
	    'detail_view' => '0',
	    'display_status' => '1',
	    'iscustom' => '0',
		'columns' =>  '2',
	  ), 
);


\$Config_Fields = array (
array(
	'generatedtype' => '1',
	'uitype' => '10',
	'fieldname' => 'supplierid',
	'fieldlabel' => 'Supplier',
	'readonly' => '0',
	'presence' => '0',
	'maximumlength' => '50',
	'sequence' => '1',
	'block' => '1',
	'displaytype' => '2',
	'typeofdata' => 'V~M',
	'info_type' => 'BAS',
	'merge_column' => '1',
	'deputy_column' => '0',
	'show_title' => '1',
	'width' => '12', // 4,8,12,20,30
	'align' => 'center', // left,center,right
),   
array(
    'generatedtype' => '1',
    'uitype' => '1',
    'fieldname' => '{LOWERMODULE}status',
    'fieldlabel' => '{MODULE} Status',
    'readonly' => '1',
    'presence' => '0',
    'maximumlength' => '50',
    'sequence' => '18',
    'block' => '1',
    'displaytype' => '2',
    'typeofdata' => 'V~O',
    'info_type' => 'BAS',
    'merge_column' => '1',
    'deputy_column' => '0',
    'show_title' => '1',
    'width' => '6', // 4,8,12,20,30
    'align' => 'center', // left,center,right
),
array (
    'generatedtype' => '1',
    'uitype' => '1',
    'fieldname' => 'approvalstatus',
    'fieldlabel' => 'Approval Status',
    'readonly' => '1',
    'presence' => '0',
    'maximumlength' => '100',
    'sequence' => '44',
    'block' => '1',
    'displaytype' => '2',
    'typeofdata' => 'V~M',
    'info_type' => 'BAS',
    'merge_column' => '0',
    'deputy_column' => '0',
    'show_title' => '1',
    'width' => '12', // 4,8,12,20,30 
    'align' => 'center', // left,center,right
),
);

\$Config_CustomViews = array (
  array (
	'viewname' => 'Default',
	'setdefault' => '1',
	'setmetrics' => '0',
	'entitytype' => '{MODULE}',
	'status' => '0',
	'cvcolumnlist' => array ('supplierid','{LOWERMODULE}status','published','oper'),
  ), 
);    

\$Config_Entitynames = array ( 
  array (   
    'modulename' => '{MODULE}',
    'tablename' => '{MODULE}',
    'fieldname' => 'xn_id',
    'entityidfield' => 'xn_id',
    'entityidcolumn' => 'xn_id',
  ),
);


\$config_fieldmodulerels = array (  
 array (
	 'fieldname' => 'supplierid',
	 'module' => '{MODULE}',
	 'relmodule' => 'Suppliers',
	 'status' => '',
	 'sequence' => '0',
  ), 
);

\$config_modentity_nums = array();

\$config_searchcolumn = array(
	array(
		'sequence' => '1',
		'columnname' => 'published',
		'fieldname' => 'published',
		'fieldlabel' => 'Create Date',
		'type' => 'calendar',
		'info_type' => 'BAS',
		'newline' => false,
	),

);
 
\$config_picklists = array();

?>";
   
	
	
    $fields = XN_Query::create("Content")->tag("fields")
        ->filter("type","eic","fields")
        ->filter("my.tabid","=",$tabid)
		->order('my.sequence',XN_Order::ASC_NUMBER)
        ->end(-1)
        ->execute();
    if(count($fields) == 0)
	{
	    $Config_Data_file = str_replace("{LOWERMODULE}",strtolower($module),$Config_Data_file);
		$Config_Data_file = str_replace("{MODULE}",$module,$Config_Data_file);
		$Config_Data_file = str_replace("TABID",$tabid,$Config_Data_file); 
	
		writefile($module,"config.data.php",$Config_Data_file);
	} 
	else
	{
		$Config_Data_file = "<?php 
\$tabid  = '".$tabid."';
\$tabname  = '".$module."';

\$config_tabs =  array(
	'tabname' => '".$module."',
	'tablabel' => '".$module."',
    'presence' => '0',
    'customized' => '0',
    'isentitytype' => '1',
    'tabsequence' => '".$tabid."',
    'ownedby' => '0',
);\n\n";
		/*恢复块*/			
		$blocks = XN_Query::create ( 'Content' )->tag("blocks")
			   ->filter ( 'type', 'eic', 'blocks' )
			   ->filter ( 'my.tabid', '=', $tabid )
			   ->order('my.sequence',XN_Order::ASC_NUMBER)
			   ->execute ();			
		$config_blocks = array();			
		if (count($blocks)>0)
		{
			$Config_Data_file .= "\$Config_Blocks = array (\n";
			$index = 1; 
			foreach($blocks as $block_info) 
			{
				$blockid = $block_info->my->blockid;
				$config_blocks[$blockid] = $index;
				$Config_Data_file .= "\t".$index . " => array (
		'blocklabel'     => '".$block_info->my->blocklabel."',
		'sequence'       => '".$block_info->my->sequence."',
		'show_title'     => '".$block_info->my->show_title."',
		'visible'        => '".$block_info->my->visible."', 
		'display_status' => '".$block_info->my->display_status."',
		'iscustom'       => '".$block_info->my->iscustom."',
		'columns'        => '".$block_info->my->columns."',\n\t),";
				$index ++;
			}		
			$Config_Data_file .= "\n);\n\n"; 
		}	 
		/*恢复字段*/
		$Config_Data_file .= "\$Config_Fields = array (\n";
		$index = 1; 
		foreach($fields as $field_info) 
		{ 
			$blockid = $field_info->my->block;
			$Config_Data_file .= " \tarray (
		'generatedtype' => '".$field_info->my->generatedtype."',
		'uitype' 		=> '".$field_info->my->uitype."',
		'fieldname' 	=> '".$field_info->my->fieldname."',
		'fieldlabel' 	=> '".$field_info->my->fieldlabel."',
		'readonly' 		=> '".$field_info->my->readonly."',
		'presence' 		=> '".$field_info->my->presence."',
		'maximumlength' => '".$field_info->my->maximumlength."',
		'sequence' 		=> '".$index."',
		'block' 		=> '".$config_blocks[$blockid]."',
		'displaytype' 	=> '".$field_info->my->displaytype."',
		'typeofdata' 	=> '".$field_info->my->typeofdata."',
		'info_type' 	=> '".$field_info->my->info_type."',
		'merge_column' 	=> '".$field_info->my->merge_column."',
		'deputy_column' => '".$field_info->my->deputy_column."',
		'show_title' 	=> '".$field_info->my->show_title."',
		'width' 		=> '".$field_info->my->width."',  
		'align' 		=> '".$field_info->my->align."',\n";
		$editwidth = $field_info->my->editwidth;
		if (isset($editwidth) && $editwidth != "")
		{
			$Config_Data_file .= "\t\t'editwidth' 	=> '".$field_info->my->editwidth."',\n";
		}  
		$unit = $field_info->my->unit;
		if (isset($unit) && $unit != "")
		{
			$Config_Data_file .= "\t\t'unit' 	=> '".$field_info->my->unit."',\n";
		}  
		$multiselect = $field_info->my->multiselect;
		if (isset($multiselect) && $multiselect != "")
		{
			$Config_Data_file .= "\t\t'multiselect' 	=> '".$field_info->my->multiselect."',\n";
		}  
			$Config_Data_file .= "\t),\n"; 
			$index ++;
		}		
		$Config_Data_file .= ");\n\n"; 
		
		/*恢复视图*/
		$customviews = XN_Query::create ( 'Content' )->tag("customviews")
			   ->filter ( 'type', 'eic', 'customviews' )
			   ->filter ( 'my.tabid', '=', $tabid ) 
			   ->execute ();		 		
		if (count($customviews)>0)
		{
			$Config_Data_file .= "\$Config_CustomViews = array (\n";  
			foreach($customviews as $customview_info) 
			{ 
				$cvcolumnlists = XN_Query::create ( 'Content' )->tag("cvcolumnlists")
					   ->filter ( 'type', 'eic', 'cvcolumnlists' )
					   ->filter ( 'my.tabid', '=', $tabid ) 
					   ->filter ( 'my.cvid', '=', $customview_info->id )
					   ->order('my.columnindex',XN_Order::ASC_NUMBER) 
					   ->execute ();
				$lists = array();
				foreach($cvcolumnlists as $cvcolumnlist_info)
				{
					$lists[] = $cvcolumnlist_info->my->columnname;
				} 
				$Config_Data_file .= "\tarray (
		'viewname'    => '".$customview_info->my->viewname."', 
		'setdefault'  => '".$customview_info->my->setdefault."',
		'setmetrics'  => '".$customview_info->my->setmetrics."', 
		'entitytype'  => '".$customview_info->my->entitytype."',
		'status'      => '".$customview_info->my->status."',
		'cvcolumnlist' => array ('".join($lists,"','")."'),\n\t),"; 
			}		
			$Config_Data_file .= "\n);\n\n"; 
		}	  
		
		/*恢复关联显示*/			
		$entitynames = XN_Query::create ( 'Content' )->tag("entitynames")
			   ->filter ( 'type', 'eic', 'entitynames' )
			   ->filter ( 'my.tabid', '=', $tabid ) 
			   ->execute (); 
		if (count($entitynames)>0)
		{
			$entityname_info = $entitynames[0];
			$Config_Data_file .= "\$Config_Entitynames = array (\n";
			$Config_Data_file .= "\t array (
		'modulename'     => '".$entityname_info->my->modulename."',
		'tablename'      => '".$entityname_info->my->tablename."',
		'fieldname'      => '".$entityname_info->my->fieldname."',
		'entityidfield'  => '".$entityname_info->my->entityidfield."', 
		'entityidcolumn' => '".$entityname_info->my->entityidcolumn."',\n\t),"; 
			$Config_Data_file .= "\n);\n\n"; 
		}	  
		
		/*恢复关联模块*/
		$fieldmodulerels = XN_Query::create ( 'Content' )->tag("fieldmodulerels")
			   ->filter ( 'type', 'eic', 'fieldmodulerels' )
			   ->filter ( 'my.tabid', '=', $tabid ) 
			   ->execute ();		 		
		if (count($fieldmodulerels)>0)
		{
			$Config_Data_file .= "\$config_fieldmodulerels = array (\n";  
			foreach($fieldmodulerels as $fieldmodulerel_info) 
			{  
				$Config_Data_file .= "\tarray (
		'fieldname'  => '".$fieldmodulerel_info->my->fieldname."', 
		'module'  	 => '".$fieldmodulerel_info->my->module."',
		'relmodule'  => '".$fieldmodulerel_info->my->relmodule."', 
		'status'  	 => '".$fieldmodulerel_info->my->status."',
		'sequence'   => '".$fieldmodulerel_info->my->sequence."',\n\t),"; 
			}		
			$Config_Data_file .= "\n);\n\n"; 
		}	  
		
		
		/*恢复编号配置*/
		$modentity_nums = XN_Query::create ( 'Content' )->tag("modentity_nums")
			   ->filter ( 'type', 'eic', 'modentity_nums' )
			   ->filter ( 'my.tabid', '=', $tabid ) 
			   ->execute ();		 		
		if (count($modentity_nums)>0)
		{
			$Config_Data_file .= "\$config_modentity_nums = array (\n";  
			foreach($modentity_nums as $modentity_num_info) 
			{  
				$include_date = "1";
				if (isset($modentity_num_info->my->include_date) && $modentity_num_info->my->include_date != "")
				{
					$include_date = $modentity_num_info->my->include_date;
				}
				$length = "3";
				if (isset($modentity_num_info->my->length) && $modentity_num_info->my->length != "")
				{
					$length = $modentity_num_info->my->length;
				}
				$Config_Data_file .= "\tarray (
		'semodule'  	=> '".$modentity_num_info->my->semodule."', 
		'prefix'  		=> '".$modentity_num_info->my->prefix."',
		'start_id' 	 	=> '".$modentity_num_info->my->start_id."', 
		'cur_id'  		=> '".$modentity_num_info->my->cur_id."',
		'include_date'  => '".$include_date."',
		'length'  		=> '".$length."',
		'active'    	=> '".$modentity_num_info->my->active."',\n\t),"; 
			}		
			$Config_Data_file .= "\n);\n\n"; 
		}	
		 
		/*恢复数据挖掘配置*/
		$searchcolumns = XN_Query::create ( 'Content' )->tag("searchcolumn")
			   ->filter ( 'type', 'eic', 'searchcolumn' )
			   ->filter ( 'my.tabid', '=', $tabid ) 
			   ->execute ();		 		
		if (count($searchcolumns)>0)
		{
			$Config_Data_file .= "\$config_searchcolumn = array (\n";  
			foreach($searchcolumns as $searchcolumn_info) 
			{  
				$Config_Data_file .= "\tarray (
		'columnname'  => '".$searchcolumn_info->my->columnname."', 
		'fieldname'   => '".$searchcolumn_info->my->fieldname."',
		'fieldlabel'  => '".$searchcolumn_info->my->fieldlabel."', 
		'type'  	  => '".$searchcolumn_info->my->type."',
		'info_type'   => '".$searchcolumn_info->my->info_type."',
		'newline'  	  => '".$searchcolumn_info->my->newline."',
		'sequence'    => '".$searchcolumn_info->my->sequence."',\n\t),"; 
			}		
			$Config_Data_file .= "\n);\n\n"; 
		}	 
		
	    $fields = XN_Query::create("Content")->tag("fields")
	        ->filter("type","eic","fields")
	        ->filter("my.tabid","=",$tabid) 
			->filter("my.uitype","in",array("33","115","116"))
	        ->end(-1)
	        ->execute();
	    if(count($fields) == 0)
		{
			$Config_Data_file .= "\$config_picklists = array ();\n";  
		}
		else
		{
			$Config_Data_file .= "\$config_picklists = array (\n";  
			foreach($fields as $field_info)
			{  
				$fieldname = $field_info->my->fieldname;
				$Config_Data_file .= "\tarray (
		'name'  	=> '".$fieldname."', 
		'picklist'  => "; 
			    $picklists = XN_Query::create ( 'Content' )
					   	->filter ( 'type', 'eic', 'picklists' )
					   	->filter ( 'my.name', '=', $fieldname )
						->order('my.sequence',XN_Order::ASC_NUMBER)
					   	->begin(0)->end(-1)	
					   	->execute (); 
				if (count($picklists) > 0)
				{
						$Config_Data_file .= "\n\t\tarray (\n";
						foreach($picklists as $picklist_info)
						{
							$Config_Data_file .= "\t\t\tarray (0 => '".$picklist_info->my->$fieldname."',1 => '".$picklist_info->my->presence."',2 => '".$picklist_info->my->picklist_valueid."',),\n";
						}
						$Config_Data_file .= "\t\t),"; 
				}
				else
				{
					$Config_Data_file .= "array(),"; 
				}
		
		        $Config_Data_file .= "\n\t),\n"; 
			}		
			$Config_Data_file .= "\n);\n\n"; 
			 
		}
   	  
		writefile($module,"config.data.php",$Config_Data_file);	
	} 
}










function init_category_module($module,$tabid)
{   
    if(!@is_dir($_SERVER['DOCUMENT_ROOT'].'/modules/'.$module))
    {
        @mkdir($_SERVER['DOCUMENT_ROOT'].'/modules/'.$module);
		echo '建立模块【' . $module . '】目录...<br>';
    }
    if(!@is_dir($_SERVER['DOCUMENT_ROOT'].'/modules/'.$module."/language"))
    {
        @mkdir($_SERVER['DOCUMENT_ROOT'].'/modules/'.$module."/language"); 
    }
	
	
	$config_func_php = "<?php\nrequire_once('modules/Public/config.func.php');"; 
	writefile($module,"config.func.php",$config_func_php);
	
	writefile($module,"config.inc.php",""); 
	
	writefile($module,"CustomView.php","<?php\ninclude('modules/CustomView/index.php');\n?>"); 
	
	$Js_file = "function {LOWERMODULE}_CategoryManager_removeHoverDom(treeId, treeNode){
	jQuery(\"#addBtn_\"+treeNode.id).unbind().remove();
	jQuery(\"#editBtn_\"+treeNode.id).unbind().remove();
	jQuery(\"#removeBtn_\"+treeNode.id).unbind().remove();
}

function {LOWERMODULE}_CategoryManager_addHoverDom(treeId, treeNode){
	if (!treeNode.iscustom)
	{
		var sObj = \$.CurrentNavtab.find(\"#\" + treeNode.tId + \"_a\");
		if (\$.CurrentNavtab.find(\"#addBtn_\" + treeNode.id).length > 0) return;
		sObj.append('<span class=\"tree_add\" style=\"vertical-align:top;\" id=\"addBtn_' + treeNode.id + '\" title=\"增加一个新的分类信息\"></span>')
		\$(\"#addBtn_\" + treeNode.id).bind(\"click\", function ()
		{
			var ajaxurl = \"index.php?module={MODULE}&action=EditView&opertype=add&parent=\" + treeNode.value;
			\$(this).dialog({id: \"CategoryManagerDialog\",height:\"180\", url: ajaxurl, title: \"新建分类\", mask: true, resizable: false, maxable: false});
		});

		if (treeNode.value != \"root\")
		{
			if (\$.CurrentNavtab.find(\"#editBtn_\" + treeNode.id).length > 0) return;
			sObj.append('<span class=\"tree_edit\" style=\"vertical-align:top;\" id=\"editBtn_' + treeNode.id + '\" title=\"编辑当前分类信息\"></span>')
			\$.CurrentNavtab.find(\"#editBtn_\" + treeNode.id).bind(\"click\", function ()
			{
				var ajaxurl = \"index.php?module={MODULE}&action=EditView&opertype=edit&record=\" + treeNode.value;
				\$(this).dialog({
								   id: \"CategoryManagerDialog\",
								   url: ajaxurl,
								   title: \"编辑分类：\" + treeNode.nodename,
								   height:\"180\",
								   mask: true,
								   resizable: false,
								   maxable: false
							   });
			});

			if (\$.CurrentNavtab.find(\"#removeBtn_\" + treeNode.id).length > 0) return;
			sObj.append('<span class=\"tree_del\" style=\"vertical-align:top;\" id=\"removeBtn_' + treeNode.id + '\" title=\"删除当前分类信息\"></span>')
			\$.CurrentNavtab.find(\"#removeBtn_\" + treeNode.id).bind(\"click\", function ()
			{
				var ajaxurl = \"index.php?module={MODULE}&action=EditView&opertype=del&record=\" + treeNode.value;
				\$(this).dialog({
								   id: \"CategoryManagerDialog\",
								   url: ajaxurl,
								   title: \"删除分类：\" + treeNode.nodename,
								   mask: true,
								   resizable: false,
								   maxable: false,
								   height: 180
							   });
			});
		}
	}
}

function {LOWERMODULE}_CategoryManager_beforeDrop(treeId, treeNodes, targetNode, moveType, isCopy) {
	if( targetNode == null) {
		return false;
	}
	if(treeNodes[0].iscustom){
		return false;
	}
}

function {LOWERMODULE}_CategoryManager_onDrop(event, treeId, treeNodes, targetNode, moveType, isCopy){
	if(moveType == null) {
		return;
	}

	var nodes = \"\";
	for (var i = 0; i < treeNodes.length; i++) {
		nodes += \";\"+ treeNodes[i].value
	}
	if (nodes.length > 0) {
		nodes = nodes.substr(1);
	}
	var ajaxurl = \"index.php?module={MODULE}&action=EditView&opertype=move&movetype=\"+(moveType?moveType:\"\")+\"&parenttab=Ma_Products Manage&record=\"+nodes+\"&parent=\";
	if (targetNode) {
		ajaxurl += targetNode.value
	}
	\$(this).bjuiajax(\"doAjax\", {url:ajaxurl,loadingmask:true});
}


function {LOWERMODULE}_CategoryManager_OnBeforeExpand(treeId, treeNode)
{
	var curExpandNode = CategoryManager_GetOpendNode(treeId);
	var pNode         = curExpandNode ? curExpandNode.getParentNode() : null;
	var treeNodeP     = treeNode.parentTId ? treeNode.getParentNode() : null;
	var zTree         = \$.fn.zTree.getZTreeObj(treeId);
	for (var i = 0, l = !treeNodeP ? 0 : treeNodeP.children.length; i < l; i++)
	{
		if (treeNode !== treeNodeP.children[i])
		{
			zTree.expandNode(treeNodeP.children[i], false);
		}
	}
	while (pNode)
	{
		if (pNode === treeNode)
		{
			break;
		}
		pNode = pNode.getParentNode();
	}
	if (!pNode)
	{
		CategoryManager_singlePath(treeId, treeNode, curExpandNode);
	}
}

function CategoryManager_singlePath(treeId, newNode, oldNode)
{
	if (newNode === oldNode) return;
	var zTree = \$.fn.zTree.getZTreeObj(treeId);
	var rootNodes, tmpRoot, tmpTId, i, j, n;
	if (!oldNode)
	{
		tmpRoot = newNode;
		while (tmpRoot)
		{
			tmpTId  = tmpRoot.tId;
			tmpRoot = tmpRoot.getParentNode();
		}
		rootNodes = zTree.getNodes();
		for (i = 0, j = rootNodes.length; i < j; i++)
		{
			n = rootNodes[i];
			if (n.tId != tmpTId)
			{
				zTree.expandNode(n, false);
			}
		}
	}
	else if (oldNode && oldNode.open)
	{
		if (newNode.parentTId === oldNode.parentTId)
		{
			zTree.expandNode(curExpandNode, false);
		}
		else
		{
			var newParents = [];
			while (newNode)
			{
				newNode = newNode.getParentNode();
				if (newNode === curExpandNode)
				{
					newParents = null;
					break;
				}
				else if (newNode)
				{
					newParents.push(newNode);
				}
			}
			if (newParents != null)
			{
				var oldNode    = curExpandNode;
				var oldParents = [];
				while (oldNode)
				{
					oldNode = oldNode.getParentNode();
					if (oldNode)
					{
						oldParents.push(oldNode);
					}
				}
				if (newParents.length > 0)
				{
					zTree.expandNode(oldParents[Math.abs(oldParents.length - newParents.length) - 1], false);
				}
				else
				{
					zTree.expandNode(oldParents[oldParents.length - 1], false);
				}
			}
		}
	}
}

function CategoryManager_GetOpendNode(treeId)
{
	var zTree = \$.fn.zTree.getZTreeObj(treeId);
	var nodes = zTree.getNodes();
	\$.each(nodes, function (node)
	{
		if (node.open)
			return node;
	});
	return null;
}

function {LOWERMODULE}_CategoryManager_onClick(event, treeId, treeNode)
{
	event.preventDefault()

	if (treeNode.isParent)
	{
		var zTree = \$.fn.zTree.getZTreeObj(treeId)

		zTree.expandNode(treeNode, !treeNode.open, false, true, true)
		return
	}
}";
	$Js_file = str_replace("{LOWERMODULE}",strtolower($module),$Js_file);
	$Js_file = str_replace("{MODULE}",$module,$Js_file);  
	
	writefile($module,$module.".js",$Js_file);
	
	$language_file = "<?php 
\$mod_strings = Array (
	'LBL_BASE_INFORMATION'         => '基本信息',
	'Supplier'			   		   => '商家', 
	'Category Name'                => '分类名称',
	'Sequence'                     => '排序',
	'Pid'                    	   => '父分类',
	'LBL_CATEGORYS_HIERARCHY_TREE' => '分类管理',
);"; 
	writefile($module,"language/zh_cn.lang.php",$language_file); 
	 
	$Popup_file = "<?php
require_once('Smarty_setup.php');
require_once('include/utils/UserInfoUtil.php');
\$smarty = new vtigerCRM_Smarty;

global \$mod_strings;
global \$app_strings,\$supplierusertype;
global \$app_list_strings,\$current_user;
global \$currentModule;
require_once('modules/'.\$currentModule.'/utils.php');

\$roleout = '';
\$hrarray = getGenericCategoryTree(\"分类目录树\");

if (isset(\$_REQUEST['mode']) && \$_REQUEST['mode'] == '1')
{
	createGenericCategoryTree(\$roleout,\$hrarray , strval(\$_REQUEST['exclude']),null,true);
	\$roleout = '<ul id=\"poprole-ztree\" class=\"ztree\" data-setting=\"{check:{chkboxType:{\'Y\':\'s\',\'N\':\'s\'}},callback:{beforeExpand:category_popup_OnBeforeExpand}}\" data-toggle=\"ztree\" data-expand-all=\"false\" data-check-enable=\"true\" data-on-click=\"category_popup_tree_onclick\">'.\$roleout.'</ul>';
}
else
{
	createGenericCategoryTree(\$roleout,\$hrarray , strval(\$_REQUEST['exclude']),null,true);
	\$roleout = '<ul id=\"poprole-ztree\" class=\"ztree\" data-setting=\"{callback:{beforeExpand:category_popup_OnBeforeExpand}}\" data-toggle=\"ztree\" data-expand-all=\"false\" data-chk-style=\"radio\" data-radio-type=\"all\" data-check-enable=\"true\" data-on-click=\"category_popup_tree_onclick\">'.\$roleout.'</ul>';
}
\$smarty->assign(\"SCRIPT\", javascript());
\$smarty->assign(\"APP\", \$app_strings);
\$smarty->assign(\"CMOD\", \$mod_strings);

\$smarty->assign(\"MSG\", \$roleout);
if (isset(\$_REQUEST['mode']) && \$_REQUEST['mode'] != '')
{
	\$smarty->assign(\"BUTTONS\", array ('<button type=\"button\" class=\"btn-green\" onclick=\"category_popup_tree_onreturn();\" data-icon=\"check-square-o\">确定</button>'));
}

\$smarty->display(\"PopupTree.tpl\");

function javascript()
{
	return '
	function category_popup_tree_onclick(event,treeID,treeNode){
		var zTree = \$.fn.zTree.getZTreeObj(treeID);
		if (treeNode.isParent && !treeNode.open){
			zTree.expandNode(treeNode, !treeNode.open, false, true, true)
		}else{
			zTree.checkNode(treeNode,!treeNode.checked,true,true)
		}
		event.preventDefault()
	}

	function category_popup_OnBeforeExpand(treeId, treeNode)
	{
		var curExpandNode = category_popup_GetOpendNode(treeId);
		var pNode         = curExpandNode ? curExpandNode.getParentNode() : null;
		var treeNodeP     = treeNode.parentTId ? treeNode.getParentNode() : null;
		var zTree         = \$.fn.zTree.getZTreeObj(treeId);
		for (var i = 0, l = !treeNodeP ? 0 : treeNodeP.children.length; i < l; i++)
		{
			if (treeNode !== treeNodeP.children[i])
			{
				zTree.expandNode(treeNodeP.children[i], false);
			}
		}
		while (pNode)
		{
			if (pNode === treeNode)
			{
				break;
			}
			pNode = pNode.getParentNode();
		}
		if (!pNode)
		{
			category_popup_singlePath(treeId, treeNode, curExpandNode);
		}
	}

	function category_popup_singlePath(treeId, newNode, oldNode)
	{
		if (newNode === oldNode) return;
		var zTree = \$.fn.zTree.getZTreeObj(treeId);
		var rootNodes, tmpRoot, tmpTId, i, j, n;
		if (!oldNode)
		{
			tmpRoot = newNode;
			while (tmpRoot)
			{
				tmpTId  = tmpRoot.tId;
				tmpRoot = tmpRoot.getParentNode();
			}
			rootNodes = zTree.getNodes();
			for (i = 0, j = rootNodes.length; i < j; i++)
			{
				n = rootNodes[i];
				if (n.tId != tmpTId)
				{
					zTree.expandNode(n, false);
				}
			}
		}
		else if (oldNode && oldNode.open)
		{
			if (newNode.parentTId === oldNode.parentTId)
			{
				zTree.expandNode(curExpandNode, false);
			}
			else
			{
				var newParents = [];
				while (newNode)
				{
					newNode = newNode.getParentNode();
					if (newNode === curExpandNode)
					{
						newParents = null;
						break;
					}
					else if (newNode)
					{
						newParents.push(newNode);
					}
				}
				if (newParents != null)
				{
					var oldNode    = curExpandNode;
					var oldParents = [];
					while (oldNode)
					{
						oldNode = oldNode.getParentNode();
						if (oldNode)
						{
							oldParents.push(oldNode);
						}
					}
					if (newParents.length > 0)
					{
						zTree.expandNode(oldParents[Math.abs(oldParents.length - newParents.length) - 1], false);
					}
					else
					{
						zTree.expandNode(oldParents[oldParents.length - 1], false);
					}
				}
			}
		}
	}

	function category_popup_GetOpendNode(treeId)
	{
		var zTree = \$.fn.zTree.getZTreeObj(treeId);
		var nodes = zTree.getNodes();
		\$.each(nodes, function (node)
		{
			if (node.open)
				return node;
		});
		return null;
	}

	function category_popup_tree_onreturn(){
		var zTree = \$.fn.zTree.getZTreeObj(\"poprole-ztree\"),
			nodes = zTree.getCheckedNodes(true)
		var ret = \"\",names = \"\";
		for(var i=0; i< nodes.length; i++){
				ret += \";\" + nodes[i].value;
				names += \",\"+nodes[i].name;
		}
		var args = {};
		if (ret.length > 0){
			ret = ret.substr(1);
			names = names.substr(1);
			args[\"id\"] = ret;
			args[\"name\"] = names;
		}else{
			args[\"id\"] = \"\";
			args[\"name\"] = \"\";
		}
		\$.CurrentNavtab.find(\":input\").each(function() {
			var \$input = \$(this), inputName = \$input.attr(\"name\");
			for(var key in args){
				var name = \$.fn.lookup.Constructor.prototype.getField(key);
				if (name == inputName){
					\$input
						.val(args[key])
						.trigger(\$.fn.lookup.Constructor.EVENTS.afterChange, {value:args[key]});
				}
			}
		});
		var loup = \$.fn.lookup.Constructor.prototype.LookupElement();
		var callback = loup.attr(\"data-callback\");
		var group = loup.attr(\"data-group\");

		if (callback != \"\" &&  callback != undefined)
		{
			try
			{
				var fn = window[callback];
				fn(group,args);
			}
			catch (e)
			{
			}
		}
		BJUI.dialog(\"closeCurrent\");
	}
';
}"; 
	$Popup_file = str_replace("{LOWERMODULE}",strtolower($module),$Popup_file);
	$Popup_file = str_replace("{MODULE}",$module,$Popup_file);  
	
	writefile($module,"Popup.php",$Popup_file); 
	
	
	$Index_file = "<?php 
if (isset(\$_REQUEST['loadtree']) && \$_REQUEST['loadtree'] == \"true\")
{
	echo getCategoryTree();
	die();
}
global \$currentModule, \$current_user;
global \$app_strings, \$mod_strings;
require_once('modules/'.\$currentModule.'/'.\$currentModule.'.php');
require_once('Smarty_setup.php');
\$smarty = new vtigerCRM_Smarty; 

\$smarty->assign(\"MOD\", \$mod_strings);
\$smarty->assign(\"APP\", \$app_strings);
\$smarty->assign(\"MODULE\", \$currentModule);
\$smarty->assign(\"MODULENAME\", getTranslatedString('LBL_CATEGORYS_HIERARCHY_TREE'));
\$smarty->display('CategorysManager.tpl');

 
function getCategoryTree()
{
	global \$current_user;
	global \$currentModule;
	require_once('modules/'.\$currentModule.'/utils.php');
	\$hrarray         = array ();
	\$customcategorys = null;
	\$canCustom       = false;
	\$hrarray = getGenericCategoryTree(\"分类目录树\");

	\$roleout = '';
	createGenericCategoryTree(\$roleout, \$hrarray);
	\$ztree = '<ul id=\"{LOWERMODULE}_categorymanager-ztree\" class=\"ztree\"
                data-setting=\"{callback:{beforeExpand:{LOWERMODULE}_CategoryManager_OnBeforeExpand}}\"
                data-on-click=\"{LOWERMODULE}_CategoryManager_onClick\"
				data-toggle=\"ztree\"
				'; 
    
	if (check_authorize('manager') )
	{ 
		\$ztree .= '
				data-add-hover-dom = \"{LOWERMODULE}_CategoryManager_addHoverDom\"
				data-remove-hover-dom = \"{LOWERMODULE}_CategoryManager_removeHoverDom\"
				data-before-drop = \"{LOWERMODULE}_CategoryManager_beforeDrop\"
				data-on-drop = \"{LOWERMODULE}_CategoryManager_onDrop\"
				data-edit-enable = \"true\"
		';
	}
	\$ztree .= 'data-expand-all=\"true\">'.\$roleout.'</ul>';
	return \$ztree;
}";
	$Index_file = str_replace("{LOWERMODULE}",strtolower($module),$Index_file);
	$Index_file = str_replace("{MODULE}",$module,$Index_file);  
	
	writefile($module,"index.php",$Index_file);
	
	$Save_file = "<?php
require_once('modules/Users/Users.php');
require_once('include/utils/UserInfoUtil.php');

global \$currentModule;
require_once('modules/'.\$currentModule.'/utils.php');
try
{

	if (isset(\$_REQUEST['record']) && \$_REQUEST['record'] == '-1')
	{
		global \$supplierid;
		\$newcontent                    = XN_Content::create('{LOWERMODULE}', '', false);
		\$newcontent->my->sequence      = \$_REQUEST['sequence'];
		\$newcontent->my->pid           = \$_REQUEST['parent'] == \"root\" ? \"0\" : \$_REQUEST['parent']; 
		\$newcontent->my->deleted       = '0';
		\$newcontent->my->categoryname  = \$_REQUEST['categoryname']; 
		\$newcontent->my->supplierid    = \$supplierid;
		\$newcontent->save(\"{LOWERMODULE}\");
		echo '{\"statusCode\":200,\"divid\":\"{LOWERMODULE}_CategorysManagerTreeForm\",\"closeCurrent\":true}';
		getCategoryStructure(null, null, true);
		die();
	}
	elseif (isset(\$_REQUEST['record']) && \$_REQUEST['record'] != '-1' && \$_REQUEST['record'] != '')
	{
		global \$supplierid;
		\$newcontent                    = XN_Content::load(\$_REQUEST['record'], '{LOWERMODULE}');
		\$newcontent->my->sequence      = \$_REQUEST['sequence']; 
		\$newcontent->my->categoryname  = \$_REQUEST['categoryname'];   
		\$newcontent->save(\"{LOWERMODULE}\");

		getCategoryStructure(null, null, true);
		echo '{\"statusCode\":200,\"divid\":\"{MODULE}_CategorysManagerTreeForm\",\"closeCurrent\":true}';
		die();
	}
	else
	{
		echo '{\"statusCode\":\"300\",\"message\":\"参数错误，无法完成操作！\"}';
		die();
	}
}
catch (XN_Exception \$e)
{
	echo '{\"statusCode\":\"300\",\"message\":\"'.\$e->getMessage().'\"}';
	die;
}";
	$Save_file = str_replace("{LOWERMODULE}",strtolower($module),$Save_file);
	$Save_file = str_replace("{MODULE}",$module,$Save_file);  

	writefile($module,"Save.php",$Save_file);
	
	
	$ListView_file = "";
	writefile($module,"ListView.php",$ListView_file);
	
	
	$EditView_file = "<?php
    require_once('Smarty_setup.php');
    require_once('include/utils/UserInfoUtil.php');
    global \$currentModule,\$current_user;
    global \$mod_strings;
    global \$app_strings;
	require_once('modules/'.\$currentModule.'/utils.php');
    \$smarty = new vtigerCRM_Smarty;
    \$readonly = false;
    if (!check_authorize('manager') )
    {
        \$readonly = true;
        \$smarty->assign(\"READONLY\", '1');
    }
    \$smarty->assign(\"APP\", \$app_strings);
    \$smarty->assign(\"MOD\", \$mod_strings);
    \$smarty->assign(\"MODULE\", \$currentModule);
    \$smarty->assign(\"ACTION\", \"Save\");
    \$opertype = \"\";
    if (isset(\$_REQUEST[\"opertype\"]) && \$_REQUEST[\"opertype\"] != \"\")
    {
        \$opertype = \$_REQUEST[\"opertype\"];
    }
    if (\$opertype == \"add\")
    {
        if (isset(\$_REQUEST[\"parent\"]) && \$_REQUEST[\"parent\"] != \"\")
        {
			\$customHtml = '<div>
				<input type=\"hidden\" value=\"'.\$_REQUEST[\"parent\"].'\" id=\"parent\" name=\"parent\">
				<div class=\"form-group\">
					<label class=\"control-label x120\" for=\"categoryname\">分类名称：</label>
					<input id=\"categoryname\" name=\"categoryname\" value=\"\" class=\"form-control required\" style=\"padding-right: 15px;\" data-rule=\"required;\" type=\"text\" placeholder=\"输入分类的名称\" size=\"20\">
				</div>
				<div class=\"form-group\">
					<label class=\"control-label x120\" for=\"sequence\">排序：</label>
					<input id=\"sequence\" name=\"sequence\"  class=\"form-control required\" style=\"padding-right: 15px;\" data-rule=\"required;number;\" type=\"text\" placeholder=\"输入分类显示序号\" size=\"20\" value=\"100\">
				</div>
			</div>';
            \$smarty->assign(\"RECORD\", \"-1\");
            \$smarty->assign(\"MSG\", \$customHtml);
			\$smarty->assign(\"SUBMODULE\", \$currentModule);
			\$smarty->assign(\"SUBACTION\", 'Save');
            \$smarty->assign(\"BUTTONS\", array ('<button type=\"submit\" class=\"btn-green\" '.(\$readonly?'disabled':'').' data-icon=\"save\">保存</button>'));
        }
    }
    elseif (\$opertype == \"edit\")
    {
        if (isset(\$_REQUEST[\"record\"]) && \$_REQUEST[\"record\"] != \"\" && \$_REQUEST[\"record\"] != \"-1\")
        {
            \$record   = \$_REQUEST['record'];
            \$category = getCategoryInfo(\$record);
			\$customHtml = '<div>
				<input type=\"hidden\" value=\"'.\$category[\"parent\"].'\" id=\"parent\" name=\"parent\">
				<div class=\"form-group\">
					<label class=\"control-label x120\" for=\"categoryname\">分类名称：</label>
					<input id=\"categoryname\" name=\"categoryname\" value=\"'.\$category[\"name\"].'\" class=\"form-control required\" style=\"padding-right: 15px;\" data-rule=\"required;\" type=\"text\" placeholder=\"输入分类的名称\" size=\"20\">
				</div>
				<div class=\"form-group\">
					<label class=\"control-label x120\" for=\"sequence\">排序：</label>
					<input id=\"sequence\" name=\"sequence\" class=\"form-control required\" style=\"padding-right: 15px;\" data-rule=\"required;number;\" type=\"text\" placeholder=\"输入分类显示序号\" size=\"20\" value=\"'.\$category[\"sequence\"].'\">
				</div>
			</div>';
           
            \$smarty->assign(\"RECORD\", \$record); 
            \$smarty->assign(\"MSG\", \$customHtml);
			\$smarty->assign(\"SUBMODULE\", \$currentModule);
			\$smarty->assign(\"SUBACTION\", 'Save');
            \$smarty->assign(\"BUTTONS\", array ('<button type=\"submit\" class=\"btn-green\" '.(\$readonly?'disabled':'').' data-icon=\"edit\">更新</button>'));
        }
    }
    elseif (\$opertype == \"del\")
    {
        if (isset(\$_REQUEST[\"record\"]) && \$_REQUEST[\"record\"] != \"\" && \$_REQUEST[\"record\"] != \"-1\")
        {
            \$record   = \$_REQUEST['record'];
            \$category = getCategoryInfo(\$record);
            \$roleout  = '';
            createGenericCategoryTree(\$roleout, getGenericCategoryTree(), null, \$record, true);
            \$roleout    = '<ul id=\"categorysmanager_selectztree\" class=\"ztree hide\"
						data-toggle=\"ztree\" 
						data-check-enable=\"true\" 
						data-chk-style=\"radio\"
						data-radio-type=\"all\"
						data-on-check=\"categorysmanager_selectztree_nodecheck\" 
						data-on-click=\"categorysmanager_selectztree_nodeclick\"
						data-expand-all=\"false\">'.\$roleout.'</ul>';
            \$customHtml = '
			<div class=\"form-group\">
				<label class=\"control-label x120\" for=\"rolename\">要删除的分类：</label>
				<input readonly id=\"categoryname\" name=\"categoryname\" value=\"'.\$category[\"name\"].'\" class=\"required\" style=\"padding-right: 15px;\" data-rule=\"required;\" type=\"text\" placeholder=\"输入分类的名称\" size=\"20\">
			</div>
			<div class=\"form-group\">
				<label class=\"control-label x120\" for=\"rolename\">为分类转移：</label>
				<input type=\"hidden\" value=\"\" id=\"parent\" name=\"parent\">
				<span class=\"wrap_bjui_btn_box\" style=\"position: relative; display: inline-block;\">
					<input type=\"text\" id=\"moveto_categorys\" value=\"\" style=\"cursor: pointer;\" data-toggle=\"selectztree\" data-value=\"#parent\" size=\"20\" data-tree=\"#categorysmanager_selectztree\"  data-rule=\"required\" placeholder=\"请选择一个分类\" readonly>
					<a class=\"bjui-lookup\" style=\"height: 22px; line-height: 22px;\" href=\"javascript:moveto_categorysclick();\">
						<i class=\"fa fa-search\"></i>
					</a>
				</span>
			</div>
		'.\$roleout;
            \$script     = '
			function moveto_categorysclick(){
				\$.CurrentDialog.find(\"#moveto_categorys\").focus();
				\$.CurrentDialog.find(\"#moveto_categorys\").trigger(\"click\");
			}
			function categorysmanager_selectztree_nodecheck(event, treeId, treeNode) {
				var zTree = \$.fn.zTree.getZTreeObj(treeId),
					nodes = zTree.getCheckedNodes(true)
				var ids = \"\", names = \"\"
				for (var i = 0; i < nodes.length; i++) {
					ids   += \";\"+ nodes[i].id
					names += \";\"+ nodes[i].name
				}
				if (ids.length > 0) {
					ids = ids.substr(1), names = names.substr(1);  
					\$.CurrentDialog.find(\"#parent\").val(ids); 
				}
				var \$from = \$(\"#\"+ treeId).data(\"fromObj\")
				if (\$from && \$from.length) {
					\$from.val(names).trigger(\"validate\")
					var \$fromvalue = \$(\$(\"#\"+ treeId).data(\"fromObj\").data(\"value\")); 
					if (\$fromvalue && \$fromvalue.length) {
						\$fromvalue.val(ids).trigger(\"validate\")
					}
				}
			}
			
			function categorysmanager_selectztree_nodeclick(event, treeId, treeNode) {
				var zTree = \$.fn.zTree.getZTreeObj(treeId)
				zTree.checkNode(treeNode, !treeNode.checked, true, true)
				event.preventDefault()
			}
			';
            \$smarty->assign(\"RECORD\", \$record);
            \$smarty->assign(\"MSG\", \$customHtml);
			\$smarty->assign(\"SUBMODULE\", \$currentModule);
			\$smarty->assign(\"SUBACTION\", 'DeleteCategory');  
            \$smarty->assign(\"SCRIPT\", \$script);
            \$smarty->assign(\"BUTTONS\", array ('<button type=\"submit\" class=\"btn-red\" '.(\$readonly?'disabled':'').' data-icon=\"trash-o\">删除</button>'));
        }
    }
    elseif (\$opertype == \"move\")
    {
        if (isset(\$_REQUEST[\"record\"]) && \$_REQUEST[\"record\"] != \"\" && \$_REQUEST[\"record\"] != \"-1\")
        {
            \$moveNodes  = explode(';', \$_REQUEST[\"record\"]);
            \$moveParent = \$_REQUEST[\"parent\"];
            \$moveType   = \$_REQUEST[\"movetype\"];
            if (\$moveType == \"inner\")
            {
                \$subCategoryInfo = getSubCategoryID(1,\$moveParent);
                \$sequence        = \"0\";
                if (isset(\$subCategoryInfo) && is_array(\$subCategoryInfo) && count(\$subCategoryInfo) > 0)
                {
                    rsort(\$subCategoryInfo);
                    \$sequence = \$subCategoryInfo[0][\"sequence\"];
                }
                \$CategorySave = array ();
                foreach (\$moveNodes as \$moveCategoryID)
                {
                    \$sequence++;
                    \$moveCategoryInfo          = getCategoryInfo(\$moveCategoryID);
                    \$loadcontent               = \$moveCategoryInfo[\"content\"];
                    \$loadcontent->my->pid      = \$moveParent;
                    \$loadcontent->my->sequence = \$sequence;
                    \$CategorySave[]            = \$loadcontent;
                }
                if (count(\$CategorySave) > 0)
                {
                    XN_Content::batchsave(\$CategorySave, \"{LOWERMODULE}\");
                    getCategoryStructure(null,null,true);
                }
            }
            elseif (\$moveType == \"prev\")
            {
                \$parentInfo      = getCategoryInfo(\$moveParent);
                \$parentPath      = \$parentInfo[\"parent\"];
                \$CategorySave    = array ();
                \$subCategoryInfo = getSubCategoryID(1,\$parentPath);
                \$sequence        = \"1\";
                foreach (\$subCategoryInfo as \$key => \$sub_info)
                {
                    if (in_array(\$key, \$moveNodes))
                    {
                        continue;
                    }
                    if (\$moveParent == \$key)
                    {
                        foreach (\$moveNodes as \$moveCategoryID)
                        {
                            \$moveCategoryInfo          = getCategoryInfo(\$moveCategoryID);
                            \$loadcontent               = \$moveCategoryInfo[\"content\"];
                            \$loadcontent->my->pid      = \$parentPath;
                            \$loadcontent->my->sequence = \$sequence;
                            \$CategorySave[]            = \$loadcontent;
                            \$sequence++;
                        }
                        \$moveCategoryInfo          = getCategoryInfo(\$moveParent);
                        \$loadcontent               = \$moveCategoryInfo[\"content\"];
                        \$loadcontent->my->sequence = \$sequence;
                        \$CategorySave[]            = \$loadcontent;
                        \$sequence++;
                    }
                    else
                    {
                        \$moveCategoryInfo          = getCategoryInfo(\$key);
                        \$loadcontent               = \$moveCategoryInfo[\"content\"];
                        \$loadcontent->my->sequence = \$sequence;
                        \$CategorySave[]            = \$loadcontent;
                        \$sequence++;
                    }
                }
                if (count(\$CategorySave) > 0)
                {
                    XN_Content::batchsave(\$CategorySave, \"{LOWERMODULE}\");
                    getCategoryStructure(null,null,true);
                }
            }
            elseif (\$moveType == \"next\")
            {
                \$parentInfo      = getCategoryInfo(\$moveParent);
                \$parentPath      = \$parentInfo[\"parent\"];
                \$CategorySave    = array ();
                \$subCategoryInfo = getSubCategoryID(1,\$parentPath);
                \$sequence        = \"1\";
                foreach (\$subCategoryInfo as \$key => \$sub_info)
                {
                    if (in_array(\$key, \$moveNodes))
                    {
                        continue;
                    }
                    if (\$moveParent == \$key)
                    {
                        \$moveCategoryInfo          = getCategoryInfo(\$moveParent);
                        \$loadcontent               = \$moveCategoryInfo[\"content\"];
                        \$loadcontent->my->sequence = \$sequence;
                        \$CategorySave[]            = \$loadcontent;
                        \$sequence++;
                        foreach (\$moveNodes as \$moveCategoryID)
                        {
                            \$moveCategoryInfo          = getCategoryInfo(\$moveCategoryID);
                            \$loadcontent               = \$moveCategoryInfo[\"content\"];
                            \$loadcontent->my->pid      = \$parentPath;
                            \$loadcontent->my->sequence = \$sequence;
                            \$CategorySave[]            = \$loadcontent;
                            \$sequence++;
                        }
                    }
                    else
                    {
                        \$moveCategoryInfo          = getCategoryInfo(\$key);
                        \$loadcontent               = \$moveCategoryInfo[\"content\"];
                        \$loadcontent->my->sequence = \$sequence;
                        \$CategorySave[]            = \$loadcontent;
                        \$sequence++;
                    }
                }
                if (count(\$CategorySave) > 0)
                {
                    XN_Content::batchsave(\$CategorySave, \"{LOWERMODULE}\");
                    getCategoryStructure(null,null,true);
                }
            }
            echo '{\"statusCode\":200,\"divid\":\"{MODULE}_CategorysManagerTreeForm\"}';
            die();
        }
        echo '{\"statusCode\":\"300\",\"message\":\"参数错误，无法完成操作！\"}';
        die();
    }
\$smarty->display(\"MessageBox.tpl\");
";
	$EditView_file = str_replace("{LOWERMODULE}",strtolower($module),$EditView_file);
	$EditView_file = str_replace("{MODULE}",$module,$EditView_file); 
	writefile($module,"EditView.php",$EditView_file);
	
	 
	
	
	$Module_file = "<?php
include_once('config.php');
require_once('include/utils/utils.php');

class {MODULE} extends CRMEntity 
{ 
	public \$table_name = '{LOWERMODULE}';
	//public \$datatype='7'; 
	public \$table_index= 'id';
	public \$tab_name = Array('{LOWERMODULE}');
	public \$tab_name_index = Array('{MODULE}'=>'id');
	public \$customFieldTable = Array('{MODULE}', 'id');
	public \$column_fields = Array();
	public \$sortby_fields = Array('{LOWERMODULE}status');
	public \$list_link_field= 'id';
	public \$default_order_by = 'published';
	public \$default_sort_order = 'DESC';
	public \$search_fields = Array();   
	public \$search_fields_name = Array();
	public \$mandatory_fields = Array('published');
    public \$special_search_fields = array();
	var \$popup_fields = Array('categoryname','pid','sequence','published');
	var \$filter_fields = Array('categoryname'); 
	var \$sortby_number_fields = Array('categoryname','pid','sequence','published');
	
    function {MODULE}() 
	{ 
		\$this->column_fields = getColumnFields('{MODULE}');
	}

	function save_module(\$module){}  

	function getSortOrder() 
	{ 
		if(isset(\$_REQUEST['sorder']))
			\$sorder = \$_REQUEST['sorder'];
		else
			\$sorder = ((\$_SESSION[strtoupper(\$this->table_name).'_SORT_ORDER'] != '')?(\$_SESSION[strtoupper(\$this->table_name).'_SORT_ORDER']):(\$this->default_sort_order));
		return \$sorder;
	}
	
	function getOrderBy() 
	{ 
		\$use_default_order_by = \$this->default_order_by;
		if (isset(\$_REQUEST['order_by']))
			\$order_by = \$_REQUEST['order_by'];
		else
			\$order_by = ((\$_SESSION[strtoupper(\$this->table_name).'_ORDER_BY'] != '')?(\$_SESSION[strtoupper(\$this->table_name).'_ORDER_BY']):(\$use_default_order_by));
		return \$order_by;
	}
}?>";
    $Module_file = str_replace("{LOWERMODULE}",strtolower($module),$Module_file);
	$Module_file = str_replace("{MODULE}",$module,$Module_file);
	writefile($module,$module.".php",$Module_file);
	
	
	$Config_Data_file = "<?php

\$tabid  = 'TABID';
\$tabname  = '{MODULE}';

\$config_tabs =  array (  	 			    
					'tabname' => '{MODULE}',
					'tablabel' => '{MODULE}',
				    'presence' => '0',
				    'customized' => '0',
				    'isentitytype' => '1',
				    'tabsequence' => 'TABID',
				    'ownedby' => '0',
					);

\$Config_Blocks = array (
	  1 => array (	    
	    'blocklabel' => 'LBL_BASE_INFORMATION',
	    'sequence' => '1',
	    'show_title' => '0',
	    'visible' => '0',
	    'create_view' => '0',
	    'edit_view' => '0',
	    'detail_view' => '0',
	    'display_status' => '1',
	    'iscustom' => '0',
		'columns' =>  '2',
	  ), 
);


\$Config_Fields = array (
 	array (
		'generatedtype' => '1',
		'uitype' 		=> '10',
		'fieldname' 	=> 'supplierid',
		'fieldlabel' 	=> 'Supplier',
		'readonly' 		=> '0',
		'presence' 		=> '0',
		'maximumlength' => '50',
		'sequence' 		=> '1',
		'block' 		=> '1',
		'displaytype' 	=> '2',
		'typeofdata' 	=> 'V~M',
		'info_type' 	=> 'BAS',
		'merge_column' 	=> '1',
		'deputy_column' => '0',
		'show_title' 	=> '1',
		'width' 		=> '12',  
		'align' 		=> 'center',
	),
 	array (
		'generatedtype' => '1',
		'uitype' 		=> '1',
		'fieldname' 	=> 'categoryname',
		'fieldlabel' 	=> 'Category Name',
		'readonly' 		=> '1',
		'presence' 		=> '0',
		'maximumlength' => '50',
		'sequence' 		=> '2',
		'block' 		=> '1',
		'displaytype' 	=> '2',
		'typeofdata' 	=> 'V~O',
		'info_type' 	=> 'BAS',
		'merge_column' 	=> '1',
		'deputy_column' => '0',
		'show_title' 	=> '1',
		'width' 		=> '6',  
		'align' 		=> 'center',
	),
	array (
		'generatedtype' => '1',
		'uitype'        => '7',
		'fieldname'     => 'sequence',
		'fieldlabel'    => 'Sequence',
		'readonly'      => '0',
		'presence'      => '0',
		'maximumlength' => '50',
		'sequence'      => '11',
		'block'         => '77',
		'displaytype'   => '1',
		'typeofdata'    => 'N~M',
		'info_type'     => 'BAS',
		'merge_column'  => '0',
		'deputy_column' => '0',
		'show_title'    => '1',
		'width'         => '8',
		'align'         => 'center',
	),
 	array (
		'generatedtype' => '1',
		'uitype' 		=> '1',
		'fieldname' 	=> 'pid',
		'fieldlabel' 	=> 'Pid',
		'readonly' 		=> '1',
		'presence' 		=> '0',
		'maximumlength' => '100',
		'sequence' 		=> '3',
		'block' 		=> '1',
		'displaytype' 	=> '2',
		'typeofdata' 	=> 'V~M',
		'info_type' 	=> 'BAS',
		'merge_column' 	=> '0',
		'deputy_column' => '0',
		'show_title' 	=> '1',
		'width' 		=> '12',  
		'align' 		=> 'center',
	),
);

\$Config_CustomViews = array (
  array (
	'viewname' => 'Default',
	'setdefault' => '1',
	'setmetrics' => '0',
	'entitytype' => '{MODULE}',
	'status' => '0',
	'cvcolumnlist' => array ('supplierid','categoryname','pid','sequence','published','oper'),
  ), 
);    

\$Config_Entitynames = array ( 
  array (   
    'modulename'     => '{MODULE}',
    'tablename'      => '{MODULE}',
    'fieldname'      => 'categoryname',
    'entityidfield'  => 'xn_id',
    'entityidcolumn' => 'xn_id',
  ),
);


\$config_fieldmodulerels = array (  
	array (
		'fieldname'  => 'supplierid', 
		'module'  	 => '{MODULE}',
		'relmodule'  => 'Suppliers', 
		'status'  	 => '',
		'sequence'   => '0',
	),
	array (
		'fieldname'  => 'pid', 
		'module'  	 => '{MODULE}',
		'relmodule'  => '{MODULE}', 
		'status'  	 => '',
		'sequence'   => '0',
	),
);

\$config_modentity_nums = array();

\$config_searchcolumn = array(
	array(
		'sequence' => '1',
		'columnname' => 'published',
		'fieldname' => 'published',
		'fieldlabel' => 'Create Date',
		'type' => 'calendar',
		'info_type' => 'BAS',
		'newline' => false,
	),

);
 
\$config_picklists = array();

?>"; 
$Config_Data_file = str_replace("{LOWERMODULE}",strtolower($module),$Config_Data_file);
$Config_Data_file = str_replace("{MODULE}",$module,$Config_Data_file);  
$Config_Data_file = str_replace("TABID",$tabid,$Config_Data_file);  
writefile($module,"config.data.php",$Config_Data_file);	


$DeleteCategory_file = "<?php
require_once('include/utils/UserInfoUtil.php');
global \$currentModule;
require_once('modules/'.\$currentModule.'/utils.php');

if (isset(\$_REQUEST['record']) && \$_REQUEST['record'] != '' && isset(\$_REQUEST['parent']) && \$_REQUEST['parent'] != '')
{
	\$record       = \$_REQUEST['record'];
	\$subCategorys = getSubCategoryID(0, \$record);
	\$allkeys      = array_keys(\$subCategorys);
	\$allkeys[]    = \$record;
	\$allkeys      = array_unique(\$allkeys);
	if (count(\$allkeys) > 0)
	{
		try
		{
			// \$ma_products = XN_Query::create('Content')->tag('ma_products')
// 				  ->filter('type','eic','ma_products')
// 				  ->filter('my.ma_categorys','in',\$allkeys)
// 				  ->execute();
// 				foreach (\$ma_products as \$info){
// 				    \$info->my->ma_categorys = \$_REQUEST['movetocategoryid'];
// 				    \$info->save('ma_products');
// 				}
			\$loadcontent = XN_Content::loadMany(\$allkeys, '{LOWERMODULE}');
			foreach (\$loadcontent as \$info)
			{
				\$info->my->deleted = \"1\";
				\$info->save(\"{LOWERMODULE}\");
			}
			getCategoryStructure(null, null, true);
		}
		catch (XN_Exception \$ex)
		{
			echo '{\"statusCode\":300,\"message\":\"删除分类出错！\"}';
			die();
		}
	}
	echo '{\"statusCode\":200,\"message\":\"删除成功！相关数据已转移至指定分类！\",\"divid\":\"{MODULE}_CategorysManagerTreeForm\",\"closeCurrent\":true}';
	die();
}
echo '{\"statusCode\":300,\"message\":\"指定的分类转移无效！\"}';
die();";
$DeleteCategory_file = str_replace("{LOWERMODULE}",strtolower($module),$DeleteCategory_file);
$DeleteCategory_file = str_replace("{MODULE}",$module,$DeleteCategory_file);  

writefile($module,"DeleteCategory.php",$DeleteCategory_file);	


$utils_file = "<?php

	/**
	 * 创建分类树结构,方便过滤没有商品的分类
	 * @param string \$root      根节点ID
	 * @param bool   \$isRefresh 是否刷新数据缓存
	 * @return array
	 * @throws XN_IllegalArgumentException
	 */
	function getCategoryStructure(\$root = null, \$categorys = null, \$isRefresh = false)
	{
		\$Structre = array ();
		if (\$isRefresh === true)
		{
			XN_MemCache::delete(\"{MODULE}Structure\");
		}
		try
		{
			if (!isset(\$root) || empty(\$root))
			{
				\$Structre = XN_MemCache::get(\"{MODULE}Structure\");
			}
			else
			{
				throw new XN_Exception(\"取子节点数据\");
			}
		}
		catch (XN_Exception \$e)
		{
			if (!isset(\$root) && empty(\$root))
			{
				\$root = '0';
			}
			\$Structre = getCategoryStructureFromDB(\$root);
			XN_MemCache::put(\$Structre, \"{MODULE}Structure\");
		}
		return \$Structre;
	}

	/**
	 * 根据根结点获取子结点
	 * @param string \$pid
	 * @param        \$categorys
	 * @return Generator
	 */
	function getSubCategoryStructureYield(\$pid = '0', \$categorys)
	{
		if (isset(\$categorys) && !empty(\$categorys))
		{
			foreach (\$categorys as \$category_info)
			{
				if (\$category_info[\"pid\"] == \$pid)
				{
					yield \$category_info;
				}
			}
		}
	}

	/**
	 * 从数据库获取分类结构
	 * @param string \$pid
	 * @param null   \$Categorysinfo
	 * @return array
	 * @throws XN_IllegalArgumentException
	 */
	function getCategoryStructureFromDB(\$pid = '0', \$Categorysinfo = null)
	{
		if (!isset(\$Categorysinfo) || empty(\$Categorysinfo))
		{
			global \$supplierid;
			\$categorys = XN_Query::create('Content')->tag('{LOWERMODULE}')
								 ->filter('type', 'eic', '{LOWERMODULE}')
								 ->filter('my.deleted', '=', '0')
								 ->filter(\"my.supplierid\",\"=\",\$supplierid)
								 ->order(\"my.sequence\", XN_Order::ASC_NUMBER)
								 ->end(-1)
								 ->execute();

			foreach (\$categorys as \$category_info)
			{
				\$Categorysinfo[] = array ('xnid'     => \$category_info->id,
										  'name'     => \$category_info->my->categoryname,
										  'sequence' => \$category_info->my->sequence,
										  'icon'     => \$category_info->my->categoryicon,
										  'level'    => (\$category_info->my->isproducts == '1') ? \$category_info->my->categorylevel : \"\",
										  'pid'      => \$category_info->my->pid,
				);
			}
		}
		\$Structre = array ();
		foreach (getSubCategoryStructureYield(\$pid, \$Categorysinfo) as \$item)
		{
			\$Structre[\$item[\"xnid\"]] = array ('xnid'     => \$item[\"xnid\"],
											  'name'     => \$item[\"name\"],
											  'sequence' => \$item[\"sequence\"],
											  'parent'   => \$item[\"pid\"],
											  'icon'     => \$item[\"icon\"],
											  'level'    => \$item[\"level\"],
											  'children' => getCategoryStructureFromDB(\$item[\"xnid\"], \$Categorysinfo),
			);
		}
		return \$Structre;
	}

	/**
	 * 返回子分类数据
	 * @param null \$categorystructure
	 * @param null \$cid   父类XN_ID
	 * @param int  \$level 获取子类级数,0为全部子类
	 * @return array
	 */
	function getSubCategoryID(\$level = 0, \$cid = null, \$categorystructure = null)
	{
		if (!isset(\$categorystructure) || !is_array(\$categorystructure))
		{
			\$categorystructure = getCategoryStructure();
		}
		\$pid = \$cid;
		if (!isset(\$pid) || empty(\$pid))
		{
			\$pid = '0';
		}
		\$subCategoryInfo = array ();
		foreach (\$categorystructure as \$categoryid => \$children)
		{
			\$childreninfo = \$children[\"children\"];
			if (\$children[\"parent\"] == \$pid)
			{
				\$subCategoryInfo[strval(\$categoryid)]['xnid']     = \$children[\"xnid\"];
				\$subCategoryInfo[strval(\$categoryid)]['name']     = \$children[\"name\"];
				\$subCategoryInfo[strval(\$categoryid)]['sequence'] = \$children[\"sequence\"];
				\$subCategoryInfo[strval(\$categoryid)]['parent']   = \$children[\"parent\"];
				\$subCategoryInfo[strval(\$categoryid)]['icon']     = \$children[\"icon\"];
				\$subCategoryInfo[strval(\$categoryid)]['level']    = \$children[\"level\"];
				if (\$level == 0)
				{
					foreach (\$childreninfo as \$childid => \$ch_info)
					{
						\$subCategoryInfo[strval(\$childid)]['xnid']     = \$ch_info[\"xnid\"];
						\$subCategoryInfo[strval(\$childid)]['name']     = \$ch_info[\"name\"];
						\$subCategoryInfo[strval(\$childid)]['sequence'] = \$ch_info[\"sequence\"];
						\$subCategoryInfo[strval(\$childid)]['parent']   = \$ch_info[\"parent\"];
						\$subCategoryInfo[strval(\$childid)]['icon']     = \$ch_info[\"icon\"];
						\$subCategoryInfo[strval(\$childid)]['level']    = \$ch_info[\"level\"];
						if (isset(\$ch_info[\"children\"]) && is_array(\$ch_info[\"children\"]) && count(\$ch_info[\"children\"]) > 0)
						{
							\$subCategoryInfo += getSubCategoryID(\$level, strval(\$childid), \$ch_info[\"children\"]);
						}
					}
				}
				elseif (\$level - 1 > 0)
				{
					foreach (\$childreninfo as \$childid => \$ch_info)
					{
						\$subCategoryInfo[strval(\$childid)]['xnid']     = \$ch_info[\"xnid\"];
						\$subCategoryInfo[strval(\$childid)]['name']     = \$ch_info[\"name\"];
						\$subCategoryInfo[strval(\$childid)]['sequence'] = \$ch_info[\"sequence\"];
						\$subCategoryInfo[strval(\$childid)]['parent']   = \$ch_info[\"parent\"];
						\$subCategoryInfo[strval(\$childid)]['icon']     = \$ch_info[\"icon\"];
						\$subCategoryInfo[strval(\$childid)]['level']    = \$ch_info[\"level\"];
						if (\$level - 1 > 1)
						{
							if (isset(\$ch_info[\"children\"]) && is_array(\$ch_info[\"children\"]) && count(\$ch_info[\"children\"]) > 0)
							{
								\$subCategoryInfo += getSubCategoryID(\$level - 1, strval(\$childid), \$ch_info[\"children\"]);
							}
						}
					}
				}
			}
			elseif (isset(\$childreninfo) && is_array(\$childreninfo) && count(\$childreninfo) > 0)
			{
				\$subCategoryInfo += getSubCategoryID(\$level, strval(\$pid), \$childreninfo);
			}
		}
		return \$subCategoryInfo;
	}

	function getParentCategoryID(\$cid, \$categorystructure = null)
	{
		if (!isset(\$categorystructure) || !is_array(\$categorystructure))
		{
			\$categorystructure = getCategoryStructure();
		}
		\$parentids = array ();
		\$isFind    = false;
		foreach (\$categorystructure as \$categoryid => \$children)
		{
			\$childreninfo = \$children[\"children\"];
			if (\$categoryid == \$cid)
			{
				\$isFind = true;
				if (\$children[\"parent\"] != \"\" && \$children[\"parent\"] != \"0\" & \$children[\"parent\"] != \"root\")
				{
					\$parentids += getParentCategoryID(\$children[\"parent\"]);
					\$parentids[] = \$children[\"parent\"];
				}
			}
			elseif (isset(\$childreninfo) && is_array(\$childreninfo) && count(\$childreninfo) > 0)
			{
				\$parentids += getParentCategoryID(\$cid, \$childreninfo);
			}
			if (\$isFind)
				break;
		}
		return \$parentids;
	}

	/**
	 * 获取分类信息
	 * @param \$cid
	 * @return array
	 */
	function getCategoryInfo(\$cid)
	{
		\$category_info = array ();
		try
		{
			\$loadcontent               = XN_Content::load(\$cid, '{LOWERMODULE}');
			\$category_info[\"parent\"]   = \$loadcontent->my->pid;
			\$category_info[\"name\"]     = \$loadcontent->my->categoryname;
			\$category_info[\"sequence\"] = \$loadcontent->my->sequence; 
			\$category_info['content']  = \$loadcontent;
		}
		catch (XN_Exception \$e)
		{
		}
		return \$category_info;
	}

	/**
	 * 获取通用分类树结构信息
	 * @param null \$rootlabel
	 * @return array
	 * @throws XN_IllegalArgumentException
	 */
	function getGenericCategoryTree(\$rootlabel = null)
	{
		global \$supplierid;
		\$hrarray   = array ();
		\$categorys = XN_Query::create('Content')->tag('{LOWERMODULE}')
							 ->filter('type', 'eic', '{LOWERMODULE}')
							 ->filter('my.deleted', '=', '0')
							 ->filter(\"my.supplierid\",\"=\",\$supplierid)
							 ->order(\"my.sequence\", XN_Order::ASC_NUMBER)
							 ->end(-1)
							 ->execute();
		if (\$categorys > 0)
		{
			if (isset(\$rootlabel) && !empty(\$rootlabel))
			{
				\$hrarray[\"root\"] = array ('key'      => \"root\",
										  'name'     => \$rootlabel,
										  'value'    => \"root\",
										  'level'    => \"\",
										  'sequence' => \"1\",
										  'parentid' => \"\");
			}
			foreach (\$categorys as \$category_info)
			{
				\$pid = \$category_info->my->pid;
				if (!isset(\$pid) || \$pid == '0')
				{
					\$pid = '';
				}
				if (isset(\$rootlabel) && !empty(\$rootlabel) && \$pid == '')
				{
					\$pid = \"root\";
				}
				\$hrarray[\$category_info->id] = array ('key'      => \$category_info->id,
													  'name'     => \$category_info->my->categoryname,
													  'value'    => \$category_info->id,
													  'sequence' => \$category_info->my->sequence,
													  'parentid' => \$pid);

			}
		}
		return \$hrarray;
	}

	/**
	 * 创建常规的分类树HTML对像
	 * @param string \$categoryNodes 输入输出结果
	 * @param array  \$hrarray       由函数:getGenericCategoryTree创建的数据
	 * @param array  \$selectNodes   默认选择的结点数据
	 * @param array  \$excludeNodes  默认排除的结点数据,在树结构中将不显示出来
	 * @param bool   \$rootBox       当树结构能进行选择时,是否可选择根结点
	 * @throws XN_IllegalArgumentException
	 */
	function createGenericCategoryTree(&\$categoryNodes = \"\", \$hrarray, \$selectNodes = null, \$excludeNodes = null, \$rootBox = false)
	{
		if (isset(\$excludeNodes) && \$excludeNodes != \"\")
		{
			if (is_string(\$excludeNodes))
			{
				\$excludeNodes = explode(';', \$excludeNodes);
			}
		}
		\$excludeNodes = findExcludeNodes(\$hrarray, \$excludeNodes, true);
		if (isset(\$selectNodes) && \$selectNodes != \"\")
		{
			if (is_string(\$selectNodes))
			{
				\$selectNodes = explode(';', \$selectNodes);
			}
		}
		\$index = 1;
		foreach (\$hrarray as \$category_info)
		{
			\$label = \$category_info[\"name\"];
			\$key   = \$category_info[\"key\"];
			if (isset(\$excludeNodes) && is_array(\$excludeNodes) && count(\$excludeNodes) > 0 && in_array(\$key, \$excludeNodes))
			{
				continue;
			}
			\$categoryNodes .= '<li  data-id=\"'.\$key.'\"
							data-pid=\"'.\$category_info[\"parentid\"].'\"
							data-faicon=\"gift\"
							data-checkall=\"false\"
							data-sequence=\"'.\$category_info['sequence'].'\"
							data-nodename=\"'.\$category_info[\"name\"].'\"
			';
			if (isset(\$category_info[\"value\"]) && !empty(\$category_info[\"value\"]))
			{
				\$categoryNodes .= 'data-value=\"'.\$category_info[\"value\"].'\"';
			}
			else
			{
				\$categoryNodes .= 'data-value=\"'.\$key.'\"';
			}
			if (isset(\$category_info[\"iscustom\"]) && !empty(\$category_info[\"iscustom\"]))
			{
				\$categoryNodes .= 'data-iscustom=\"true\"';
			}
			else
			{
				\$categoryNodes .= 'data-iscustom=\"false\"';
			}
			if (\$index == 1)
			{
				\$categoryNodes .= 'data-open=\"true\"';
			}
			if (\$category_info['key'] == \"root\")
			{
				\$categoryNodes .= 'data-nocheck=\"true\"';
			}
			elseif ((!isset(\$category_info['parentid']) || \$category_info['parentid'] == \"\") && !\$rootBox)
			{
				\$categoryNodes .= 'data-nocheck=\"true\"';
			}
			elseif (\$category_info['parentid'] == \"root\" && !\$rootBox)
			{
				\$categoryNodes .= 'data-nocheck=\"true\"';
			}
			elseif (\$category_info['isbox'] == \"false\")
			{
				\$categoryNodes .= 'data-nocheck=\"true\"';
			}
			elseif (isset(\$selectNodes) && is_array(\$selectNodes) && count(\$selectNodes) > 0)
			{
				if (\$category_info['value'] && in_array(\$category_info['value'], \$selectNodes))
					\$categoryNodes .= 'data-checked=\"true\"';
				elseif (in_array(\$category_info['key'], \$selectNodes))
				{
					\$categoryNodes .= 'data-checked=\"true\"';
				}
			}
			\$categoryNodes .= '>'.\$label.'</li>';
			\$index++;
		}
	}
";
$utils_file = str_replace("{LOWERMODULE}",strtolower($module),$utils_file);
$utils_file = str_replace("{MODULE}",$module,$utils_file);  

writefile($module,"utils.php",$utils_file);	


	$ListView_file = "<?php
if(\$_REQUEST['mode'] == 'Export')
{
	include ('modules/Public/SheetExportExcel.php');
	die();
} 

global \$currentModule,\$app_strings,\$mod_strings,\$current_language;
require_once('modules/'.\$currentModule.'/'.\$currentModule.'.php');
require_once('Smarty_setup.php');
require_once('include/utils/utils.php');
require_once('include/utils/DataSearch.php');
require_once('modules/CustomView/CustomView.php');
 
\$current_module_strings = return_module_language(\$current_language, \$currentModule);
\$focus = CRMEntity::getInstance(\$currentModule);
\$focus->initSortbyField(\$currentModule);
\$category = getParentTab();
\$smarty = new vtigerCRM_Smarty;

if(\$_REQUEST['errormsg'] != '')
{
    \$errormsg = \$_REQUEST['errormsg'];
    \$smarty->assign(\"ERROR\",\$errormsg);
}
else
{
        \$smarty->assign(\"ERROR\",\"\");
}
if(\$_REQUEST['numPerPage'] != '' && \$_REQUEST['numPerPage'] != \$_SESSION['numPerPage'])
{
	\$numperpage = \$_REQUEST['numPerPage'];
	\$_SESSION['numPerPage'] = \$numperpage;
} 
else if(isset(\$_SESSION['numPerPage']) && \$_SESSION['numPerPage'] != \"\")
{
	\$numperpage = \$_SESSION['numPerPage'];
}
else
{
	\$numperpage = 50;
}
\$smarty->assign(\"NUMPERPAGE\", \$numperpage);

\$upperModule = strtoupper(\$currentModule);

if(CustomView::hasViewChanged(\$currentModule,\$viewid)) {
	\$_SESSION[\$upperModule.'_ORDER_BY'] = '';
}
 

if(\$_REQUEST['_order'] != '' && \$_REQUEST['_order'] != \$_SESSION[\$upperModule.'_ORDER_BY'])
{
	\$order_by = \$_REQUEST['_order'];
	\$_SESSION[\$upperModule.'_ORDER_BY'] = \$order_by;
} 
else if(isset(\$_SESSION[\$upperModule.'_ORDER_BY']) && \$_SESSION[\$upperModule.'_ORDER_BY'] != \"\")
{
	\$order_by = \$_SESSION[\$upperModule.'_ORDER_BY'];
}
else
{
	\$order_by = \$focus->getOrderBy();
}

if(\$_REQUEST['_sort'] != '' && \$_REQUEST['_sort'] != \$_SESSION[\$upperModule.'_SORT_ORDER'])
{
	\$sorder= \$_REQUEST['_sort'];
	\$_SESSION[\$upperModule.'_SORT_ORDER'] = \$sorder;
} 
else if(isset(\$_SESSION[\$upperModule.'_SORT_ORDER']) && \$_SESSION[\$upperModule.'_SORT_ORDER'] != \"\")
{
	\$sorder = \$_SESSION[\$upperModule.'_SORT_ORDER'];
}
else
{
	\$sorder = \$focus->getSortOrder();
}

\$oCustomView = new CustomView(\$currentModule);
\$viewid = \$oCustomView->getViewId(\$currentModule);
\$customviewcombo_html = \$oCustomView->getCustomViewCombo(\$viewid);
\$viewnamedesc = \$oCustomView->getCustomViewByCvid(\$viewid);

\$edit_permit = \$oCustomView->isPermittedCustomView(\$viewid,\$currentModule);
\$smarty->assign(\"CV_EDIT_PERMIT\",\$edit_permit);
 

\$listview_check_button = ListView_Button_Check(\$module);
\$smarty->assign(\"LISTVIEW_CHECK_BUTTON\", \$listview_check_button);

if(\$viewid != 0)
{
        \$CActionDtls = \$oCustomView->getCustomActionDetails(\$viewid);
}
elseif(\$viewid ==0)
{
	echo \"<table border='0' cellpadding='5' cellspacing='0' width='100%' height='450px'><tr><td align='center' class='center'>\";
	echo \"<div style='border: 3px solid rgb(153, 153, 153); background-color: rgb(255, 255, 255); width: 55%; position: relative; z-index: 10000000;'>

		<table border='0' cellpadding='5' cellspacing='0' width='98%'>
		<tbody><tr>
		<td rowspan='2' width='11%'><img src='/images/denied.gif' ></td>
		<td style='border-bottom: 1px solid rgb(204, 204, 204);' nowrap='nowrap' width='70%'>
			<span class='genHeaderSmall'>\$app_strings[LBL_PERMISSION]</span></td>
		</tr>
		<tr>
		<td class='small' align='right' nowrap='nowrap'><br>
		</td>
		</tr>
		</tbody></table>
		</div>\";
	echo \"</td></tr></table>\";
	exit;
}

if(\$viewnamedesc['viewname'] == 'All')
{
	\$smarty->assign(\"ALL\", 'All');
}

\$smarty->assign(\"CUSTOMVIEW_OPTION\",\$customviewcombo_html);
\$smarty->assign(\"VIEWID\", \$viewid);
\$smarty->assign(\"MOD\", \$mod_strings);
\$smarty->assign(\"APP\", \$app_strings);
\$smarty->assign(\"MODULE\",\$currentModule);
 
global \$current_user;
\$queryGenerator = new QueryGenerator(\$currentModule, \$current_user);
if (\$viewid != \"0\") 
{
	\$queryGenerator->initForCustomViewById(\$viewid);
} 
else 
{
	\$queryGenerator->initForDefaultCustomView();
}
 


\$search = new DataSearch(\$currentModule,\$queryGenerator,\$focus);
\$searchpanel = \$search->getBasicSearchPanel();

\$smarty->assign('SEARCHPANEL',\$searchpanel);  

\$query = XN_Query::create ( 'Content' ) ->tag(\$focus->table_name)
	->filter ( 'type', 'eic', \$focus->table_name)
	->filter ( 'my.deleted', '=', '0' );

global \$current_user;
if (!check_authorize('tezanadmin') && !is_admin(\$current_user)) 
{
    if(isset(\$_SESSION['supplierid']) && \$_SESSION['supplierid'] != '')
    {
        \$supplierid = \$_SESSION['supplierid'];
		\$query->filter ( 'my.supplierid', '=', \$supplierid);
		\$changeArray['hideFields']=array(\"supplierid\");
    } 
}  
\$search->setQuery(\$query); 
 
\$smarty->assign(\"ORDER_BY\", \$order_by);
\$query_order_by = \$order_by;
if (isset(\$order_by) && \$order_by != '' && strncmp(\$order_by,'my.',3)!=0 && \$order_by != 'updateDate' && \$order_by != 'createdDate' && \$order_by != 'published' && \$order_by != 'updated' && \$order_by != 'author' && \$order_by!= 'title')
{    		
	\$query_order_by = \"my.\".\$order_by;
}
    		
if (strtolower(\$sorder) == 'desc')
{
	if (isset(\$focus->sortby_number_fields) && in_array(\$order_by,\$focus->sortby_number_fields))
	{
	    \$query->order(\$query_order_by,XN_Order::DESC_NUMBER);
	}
	else
	{
		\$query->order(\$query_order_by,XN_Order::DESC);
	}
	\$smarty->assign(\"ORDER\", \"desc\");
}
else 
{
	if (isset(\$focus->sortby_number_fields) && in_array(\$order_by,\$focus->sortby_number_fields))
	{
		\$query->order(\$query_order_by,XN_Order::ASC_NUMBER);
	}
	else
	{
		\$query->order(\$query_order_by,XN_Order::ASC);
	} 
	\$smarty->assign(\"ORDER\", \"asc\");
}
	

if(isset(\$_REQUEST['pageNum']) && \$_REQUEST['pageNum'] != \"\")
{
	\$pagenum = \$_REQUEST['pageNum'];
}
else
{
	\$pagenum = 1;
}
\$smarty->assign(\"PAGENUM\", \$pagenum);

\$limit_start_rec = (\$pagenum-1) * \$numperpage;
if (\$limit_start_rec < 0) \$limit_start_rec = 0;
\$query->begin(\$limit_start_rec);
\$query->end(\$numperpage+\$limit_start_rec);
\$list_result = \$query->execute();
\$noofrows = \$query->getTotalCount();
\$smarty->assign('NOOFROWS',\$noofrows);

\$controller = new ListViewController(\$current_user, \$queryGenerator);
if(isset(\$changeArray) &&is_array(\$changeArray)){
    \$listview_header = \$controller->getListViewHeader(\$focus,\$currentModule,\"\",\$sorder,\$order_by,\$changeArray);
    \$listview_entries = \$controller->getListViewEntries(\$focus,\$currentModule,\$list_result,\$navigation_array,\$changeArray);
}else{
    \$listview_header = \$controller->getListViewHeader(\$focus,\$currentModule,\"\",\$sorder,\$order_by);
    \$listview_entries = \$controller->getListViewEntries(\$focus,\$currentModule,\$list_result,\$navigation_array);
}
\$smarty->assign(\"LISTHEADER\", \$listview_header);
\$smarty->assign(\"LISTENTITY\", \$listview_entries);

if(isset(\$_REQUEST[\"mode\"]) && \$_REQUEST[\"mode\"] == \"ajax\")
{
    \$smarty->display(\"ListViewEntries.tpl\");
}
else
{
    \$smarty->display(\"ListView.tpl\");
}
?>";
	writefile($module,"ListView.php",$ListView_file);

}









 
	 
function writefile($module,$file,$data)
{
		 $datafile = $_SERVER['DOCUMENT_ROOT'].'/modules/'.$module.'/'.$file;
		 if (@file_exists($datafile))
		 {
	         if (!is_writeable($datafile))
	         {
	             echo '配置文件' . $datafile . '不支持写入，无法修改微信的配置参数！';
	             die;
	         } 
		 } 
		 echo '写入文件【'.$datafile.'】...<br>';
	     $fp = fopen($datafile, 'w+');
	     flock($fp, 3);  
	     fwrite($fp, $data);
	     fclose($fp);
}


function nocoverwritefile($module,$file,$data)
{
		 $datafile = $_SERVER['DOCUMENT_ROOT'].'/modules/'.$module.'/'.$file;
		 if (!@file_exists($datafile))
		 {
			 echo '写入文件【'.$datafile.'】...<br>';
		     $fp = fopen($datafile, 'w+');
		     flock($fp, 3);  
		     fwrite($fp, $data);
		     fclose($fp);
		 }  
}
     

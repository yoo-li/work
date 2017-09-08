<?php
/*********************************************************************************
 * The contents of this file are subject to the SugarCRM Public License Version 1.1.2
 * ("License"); You may not use this file except in compliance with the
 * License. You may obtain a copy of the License at http://www.sugarcrm.com/SPL
 * Software distributed under the License is distributed on an  "AS IS"  basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied. See the License for
 * the specific language governing rights and limitations under the License.
 * The Original Code is:  SugarCRM Open Source
 * The Initial Developer of the Original Code is SugarCRM, Inc.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.;
 * All Rights Reserved.
 * Contributor(s): ______________________________________.
 ********************************************************************************/
/*********************************************************************************
 * $Header: /advent/projects/wesat/vtiger_crm/sugarcrm/modules/Reports/language/zh_cn.lang.php,v 1.0 2011/04/10 06:50:39 rank Exp $
 * Description:  Defines the Chinese language pack for the Reports module.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s):  KOFECHEM.COM 翻译整理
 * 
 * Ver 0.1 2011-4-10 本完美中文语言包是以361CRM 5.1.0简体中文包(20100513)为底本，
 *                            并参考了网上众多的语言包，以及商业CRM软件。
 *                            由于原来的翻译有很多同一个词多种表述的现象，这里全部统一了术语规范。
 *                            所有文件均采用UTF-8 无 BOM 格式编码。
 * 
 * 最新的中文语言包，vtigerCRM的本地化，企业级扩展，问题修正补丁，请访问kofechem的博客
 * http://blog.kofechem.com/archives/tag/vtiger-crm
 ********************************************************************************/

$mod_strings = Array(
'LBL_MODULE_NAME' => '报表',
'LBL_MODULE_TITLE' => '报表：首页',
'LBL_CREATE_REPORT' => '建立报表',
  'LBL_CUSTOMIZE_REPORT' => '自定义报表',
'LBL_REP_BUTTON' => '建立新报表',
'LBL_REP_FOLDER_BUTTON' => '建立新报表文件夹',
  'LBL_REP_FOLDER' => '报表文件夹',
  'LBL_REP_FOLDER_DTLS' => '文件夹信息',
  'LBL_REP_FOLDER_NAME' => '文件夹名称：',
  'LBL_REP_FOLDER_DESC' => '文件夹说明：',
'LBL_NEW_REP0_HDR1' => '选择新报表的数据来自哪个模块：',
'LBL_NEW_REP0_HDR2' => '选择相关模块：',
'LBL_NEW_REP0_HDR3' => '摘要',
'LBL_NEW_REP0_HDR4' => '报表使用的模块与相关模块一旦决定就无法再修改',
'LBL_CONTINUE_BUTTON' => '继续',
  'LBL_NEW_REP1_HDR1' => '提供以下报表信息',
  'LBL_SELECT_COLUMNS' => '选择字段',
  'LBL_SPECIFY_GROUPING' => '指定分组',
  'LBL_COLUMNS_TO_TOTAL' => '选择汇总字段',
  'LBL_SPECIFY_CRITERIA' => '指定规则',
  'LBL_SAVERUN_BUTTON' => '保存并执行',
  'LBL_TABULAT_REPORT' => '表格式报表',
  'LBL_REPORT_TYPE_HDR1' => '表格式报表是呈现数据的最简单和最快速的方式',
  'LBL_SUMMARY_REPORT' => '汇总式报表',
  'LBL_REPORT_TYPE_HDR2' => '汇总式报表可以查看数据的小计和其他汇总信息',
  'LBL_AVAILABLE_COLUMNS' => '可用的字段：',
  'LBL_SELECTED_COLUMNS' => '已选的字段：',
  'LBL_ADD_BUTTON' => '添加',
  'LBL_COLUMNS' => '字段',
  'LBL_COLUMNS_SUM' => '总计',
  'LBL_COLUMNS_AVERAGE' => '平均',
  'LBL_COLUMNS_LOW_VALUE' => '最小值',
  'LBL_COLUMNS_LARGE_VALUE' => '最大值',
  'LBL_NONE' => '无',
  'LBL_GROUPING_SORT' => '排序：',
  'LBL_GROUPING_SUMMARIZE' => '汇总数据来自：',
  'LBL_GROUPING_THEN_BY' => '接着来自：',
  'LBL_GROUPING_FINALLY_BY' => '最后来自：',
  'LBL_ADVANCED_FILTER' => '高级过滤器',
  'LBL_STANDARD_FILTER' => '标准过滤器',
  'LBL_SF_COLUMNS' => '字段',
  'LBL_SF_STARTDATE' => '开始日期',
  'LBL_SF_ENDDATE' => '结束日期',
'LBL_AF_HDR1' => '设定查找条件',
'LBL_AF_HDR2' => '您可以在第三个字段输入多个项目来使用规则 "or"',
  'LBL_AF_HDR3' => '您最多可以输入10个项目，以逗号分隔。例如CA,NY,TX,FL会尝试查找CA或NY或TX或FL。',
'LBL_FILTER_OPTIONS' => '规则选项',
  'LBL_CUSTOMIZE_BUTTON' => '自定义',
  'LBL_EXPORTPDF_BUTTON' => '导出 PDF',
  'LBL_APPLYFILTER_BUTTON' => '使用规则',
  'LBL_GENERATED_REPORT' => '生成报表',
  'LBL_GRAND_TOTAL' => '总计',

//Added for 4.2 Patch I
 'LBL_EXPORTXL_BUTTON' => '导出 Excel',

//Added for 5 Beta
 'LBL_NO_PERMISSION' => '您没有查看这个报表的权限',
  'LBL_SELECT_COLUMNS_TO_GENERATE_REPORTS' => '选择生成报表的字段',
  'LBL_AVAILABLE_FIELDS' => '可用字段',
  'LBL_SELECTED_FIELDS' => '已选字段',
  'LBL_CALCULATIONS' => '计算',
  'LBL_SELECT_COLUMNS_TO_TOTAL' => '选择要统计的字段',
  'LBL_SELECT_FILTERS_TO_STREAMLINE_REPORT_DATA' => '选择报表数据的过滤规则',
  'LBL_SELECT_FILTERS' => '规则',
  'LBL_SELECT_COLUMNS_TO_GROUP_REPORTS' => '选择分组排序字段',
  'LBL_BACK_TO_REPORTS' => '返回报表',
  'LBL_SELECT_ANOTHER_REPORT' => '选择另一个报表',
  'LBL_SELECT_COLUMN' => '选择字段',
  'LBL_SELECT_TIME' => '选择时间',
  'LBL_PRINT_REPORT' => '打印报表',
  'LBL_CLICK_HERE' => '点击这里',
  'LBL_TO_ADD_NEW_GROUP' => '新建报表文件夹',
'LBL_CREATE_NEW' => '建立',
'LBL_REPORT_DETAILS' => '报表细节',
'LBL_RELATIVE_MODULE' => '相关模块',
'LBL_REPORT_TYPE'=>'报表类型',
'LBL_REPORT_DETAILS'=>'报表细节',
'LBL_TYPE_THE_NAME' => '输入名称',
'LBL_DESCRIPTION_FOR_REPORT' => '报表说明',
'LBL_REPORT_NAME' => '报表名称',
'LBL_DESCRIPTION' => '报表说明 ',
'LBL_TOOLS' => '工具',
'LBL_AND' => 'and',
  'LBL_ADD_NEW_GROUP' => '新建报表文件夹',
  'LBL_REPORT_MODULE' => '报表模块',
  'LBL_SELECT_RELATIVE_MODULE_FOR_REPORT' => '选择要生成报表的相关模块',
  'LBL_SELECT_REPORT_TYPE_BELOW' => '选择一种报表类型',
  'LBL_TABULAR_FORMAT' => '表格式报表',
  'LBL_TABULAR_REPORTS_ARE_SIMPLEST' => '表格式报表是呈现数据的最简单和最快速的方式',
  'LBL_SUMMARY_REPORT_VIEW_DATA_WITH_SUBTOTALS' => '汇总式报表可以查看数据的小计和其他汇总信息',
  'LBL_FILTERS' => '规则',
  'LBL_MOVE_TO' => '移动到',
  'LBL_RENAME_FOLDER' => '重命名文件夹',
  'LBL_DELETE_FOLDER' => '删除文件夹',

 'Account and Contact Reports' => '客户与联系人报表',
  'Lead Reports' => '潜在客户报表',
  'Potential Reports' => '项目机会报表',
  'Activity Reports' => '待办事项报表',
  'HelpDesk Reports' => '故障单报表',
  'Product Reports' => '产品报表',
  'Quote Reports' => '报价单报表',
  'PurchaseOrder Reports' => '采购合同报表',
  'SalesOrder Reports' => '销售合同报表', //Added for SO
  'Invoice Reports' => '发货单报表',
  'Campaign Reports' => '营销活动报表', //Added for Campaigns 
'Contacts by Accounts' => '按客户显示联系人',
'Contacts without Accounts' => '没有公司资料的联系人',
'Contacts by Potentials' => '按项目机会显示联系人',
'Contacts related to Accounts' => '与客户有关的联系人',
'Contacts not related to Accounts' => '与客户无关的联系人',
'Contacts related to Potentials' => '与项目机会有关的联系人',
'Lead by Source' => '按来源显示潜在客户',
'Lead Status Report' => '潜在客户状态报表',
'Potential Pipeline' => '按阶段显示项目机会',
'Closed Potentials' => '已结案的项目机会',
'Potential that have Won' => '已中标（成功结案）的项目机会',
'Tickets by Products' => '按产品显示故障单',
'Tickets by Priority' => '按优先级显示故障单',
'Open Tickets' => '故障单',
  'Tickets related to Products' => '与产品有关的故障单报表',
  'Tickets that are Open' => '待处理故障单',
'Product Details' => '产品细节',
'Products by Contacts' => '按联系人显示产品',
'Product Detailed Report' => '产品细节报表',
'Products related to Contacts' => '与联系人有关的产品',
'Open Quotes' => '进行中的报价单',
'Quotes Detailed Report' => '报价单细节报表',
'Quotes that are Open' => '进行中的报价单',
'PurchaseOrder by Contacts' => '按联系人显示采购合同',
'PurchaseOrder Detailed Report' => '采购合同细节报表',
'PurchaseOrder related to Contacts' => '与联系人有关的采购合同',
'Invoice Detailed Report' => '发货单细节报表',
'Last Month Activities' => '上个月的工作状况',
'This Month Activities' => '这个月的工作状况',
'Campaign Expectations and Actuals' => '营销活动的预期与实际', //Added for Campaigns
'SalesOrder Detailed Report' => '销售合同细节报表',//Added for SO

'LBL_DELETE' => '删除',
'Create_Reports' => '建立新报表',
'Create_New_Folder' => '建立新文件夹',
'Move_Reports' => '移动报表',
'Delete_Report' => '删除报表',

  'Custom' => '自定义',
  'Previous FY' => '上财年',
  'Current FY' => '本财年',
  'Next FY' => '下财年',
  'Previous FQ' => '上财季',
  'Current FQ' => '本财季',
  'Next FQ' => '下财季',
  'Yesterday' => '昨天',
  'Today' => '今天',
  'Tomorrow' => '明天',
  'Last Week' => '上周',
  'Current Week' => '本周',
  'Next Week' => '下周',
  'Last Month' => '上月',
  'Current Month' => '本月',
'Next Month' => '下月',
'Last 7 Days' => '过去 7 天',
'Last 30 Days' => '过去 30 天',
'Last 60 Days' => '过去 60 天',
'Last 90 Days' => '过去 90 天',
'Last 120 Days' => '过去 120 天',
'Next 7 Days' => '未来 7 天',
'Next 30 Days' => '未来 30 天',
'Next 60 Days' => '未来 60 天',
'Next 90 Days' => '未来 90 天',
'Next 120 Days' => '未来 120 天',
'TITLE_VTIGERCRM_CREATE_REPORT' => '361CRM - 创建报表',
'TITLE_VTIGERCRM_PRINT_REPORT' => 'vtiger -  打印报表',
'NO_FILTER_SELECTED' => '没有选择过滤规则',

'LBL_GENERATE_NOW' => '立即生成',
'Totals'=>'汇总字段',
'SUM' => '合计',
'AVG' => '平均',
'MAX' => '最大',
'MIN' => '最小',
 'LBL_CUSTOM_REPORTS' => '自定义报表',

'ticketid'=>'故障单ID',
'NO_COLUMN'=>'没有栏目提供',
// Added/Updated for 361CRM 5.0.4
'LBL_REPORT_DELETED' => '您要查看的报表已删除。',

//Added for Reports
'LBL_SHARING'=>'共享',
'SELECT_FILTER_TYPE'=>'选择共享类型',
'LBL_USERS'=>'用户',
'LBL_GROUPS'=>'组',
'LBL_SELECT_FIELDS'=>'选择字段',
'LBL_MEMBERS'=>'成员',
'LBL_RELATED_FIELDS'=>'相关字段',
'LBL_NO_ACCESS'=>' 拒绝访问模块 ',
'LBL_NOT_ACTIVE'=>' 拒绝访问模块 ',
'LBL_PERM_DENIED'=>' 权限被拒绝的报表: ',
'LBL_FLDR_NOT_EMPTY'=>'您正在试图删除的文件夹非空，请移动或删除其中的的报表。',
'NO_REL_MODULES'=>'您选择的模块没有其他相关模块',
'LBL_REPORT_GENERATION_FAILED'=>'报表生成失败!',

'LBL_OR'=>'or',
'LBL_NEW_GROUP'=>'New Group',
'LBL_DELETE_GROUP'=>'Delete Group',
'LBL_NEW_CONDITION'=>'New Condition',
'LBL_SHARING_TYPE'=>'共享',
'LBL_SELECT_REPORT_TYPE_TO_CONTROL_ACCESS'=>'选择报表的共享方式', 
'LBL_ACTION' => 'Action',
'LBL_VIEW_DETAILS' => 'View Details',
'LBL_SHOW_STANDARD_FILTERS' => '显示标准过滤器',
)

?>
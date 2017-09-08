<?php
	require_once('Smarty_setup.php');
	require_once('include/utils/UserInfoUtil.php');
	$smarty = new vtigerCRM_Smarty;

	global $mod_strings;
	global $app_strings;
	global $app_list_strings;

	$roleout = '';
	if(isset($_SESSION['supplierid']) && $_SESSION['supplierid'] !='' && $_SESSION['supplierid'] !='0'){
		require_once('modules/Ma_Departments/utils.php');
		createGenericDepartmentsTree($roleout,getGenericDepartmentsTree($supplierid) , strval($_REQUEST['select']), strval($_REQUEST['exclude']), false);
	}else
	{
		createGenericRoleTree($roleout, getGenericRoleTree(), $_REQUEST['roleid'], null, false, false, false);
	}
	if (isset($_REQUEST['mode']) && $_REQUEST['mode'] == 'checkbox')
	{
		$roleout = '<ul id="poprole-ztree" class="ztree" data-setting="{check:{chkboxType:{\'Y\':\'\',\'N\':\'\'}}}" data-toggle="ztree" data-expand-all="true" data-check-enable="true" data-on-click="roleonclick">'.$roleout.'</ul>';
		$roleout .= '<input type="checkbox" style="display:none;" name="select_ids" checked value="{id:\'\',name:\'\'}">';
	}
	if (isset($_REQUEST['mode']) && $_REQUEST['mode'] == 'radio')
	{
		$roleout = '<ul id="poprole-ztree" class="ztree" data-toggle="ztree" data-expand-all="true" data-chk-style="radio" data-radio-type="all" data-check-enable="true" data-on-click="roleonclick">'.$roleout.'</ul>';
		$roleout .= '<input type="checkbox" style="display:none;" name="select_ids" checked value="{id:\'\',name:\'\'}">';
	}
	$smarty->assign("SCRIPT", javascript());
	$smarty->assign("APP", $app_strings);
	$smarty->assign("CMOD", $mod_strings);

	$smarty->assign("MSG", $roleout);
	if (isset($_REQUEST['mode']) && $_REQUEST['mode'] != '')
	{
		$smarty->assign("BUTTONS", array ('<button type="button" class="btn-green" data-toggle="lookupback" data-lookupid="select_ids" data-warn="请至少选择一个成员" data-icon="check-square-o">确定</button>'));
	}

	$smarty->display("PopupTree.tpl");

	function javascript()
	{
		return '
		function roleonclick(event,treeID,treeNode){
			var zTree = $.fn.zTree.getZTreeObj(treeID);
			zTree.checkNode(treeNode,!treeNode.checked,true,true)
			event.preventDefault()
			var nodes = zTree.getCheckedNodes(true)
			var selectids = ""
			var ret = "",names = "";
			for(var i=0; i< nodes.length; i++){
				if (ret != "") ret += ";";
				if (names != "") names += "；";
				ret += nodes[i].id;
				names += nodes[i].name;
			}
			$.CurrentDialog.find("input[name=\'select_ids\']").each(function() {
				$(this).val("{id:\'" + ret + "\', name:\'" + names + "\'}")
			});
		}
	';
	}

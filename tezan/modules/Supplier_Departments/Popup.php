<?php
	require_once('Smarty_setup.php');
	require_once('include/utils/UserInfoUtil.php');
	require_once('modules/'.$currentModule.'/utils.php');
	
	$smarty = new vtigerCRM_Smarty;

	global $mod_strings;
	global $app_strings;
	global $app_list_strings,$current_user;
	global  $supplierid,$supplierusertype;  

	$roleout = '';
	createGenericDepartmentsTree($roleout,getGenericDepartmentsTree($supplierid) , strval($_REQUEST['select']), strval($_REQUEST['exclude']), true);

	if (isset($_REQUEST['mode']) && $_REQUEST['mode'] == '1')
	{
		$roleout = '<ul id="poprole-ztree" class="ztree" data-setting="{check:{chkboxType:{\'Y\':\'\',\'N\':\'\'}}}" data-toggle="ztree" data-expand-all="true" data-check-enable="true" data-on-click="departments_popup_tree_onclick">'.$roleout.'</ul>';
	}
	else
	{
		$roleout = '<ul id="poprole-ztree" class="ztree" data-toggle="ztree" data-expand-all="true" data-chk-style="radio" data-radio-type="all" data-check-enable="true" data-on-click="departments_popup_tree_onclick">'.$roleout.'</ul>';
	}
	$smarty->assign("SCRIPT", javascript());
	$smarty->assign("APP", $app_strings);
	$smarty->assign("CMOD", $mod_strings);

	$smarty->assign("MSG", $roleout);
	if (isset($_REQUEST['mode']) && $_REQUEST['mode'] != '')
	{
		$smarty->assign("BUTTONS", array ('<button type="button" class="btn-green" onclick="departments_popup_tree_onreturn();" data-icon="check-square-o">确定</button>'));
	}

	$smarty->display("PopupTree.tpl");

	function javascript()
	{
		return '
		function departments_popup_tree_onclick(event,treeID,treeNode){
			var zTree = $.fn.zTree.getZTreeObj(treeID);
			zTree.checkNode(treeNode,!treeNode.checked,true,true)
			event.preventDefault()
		}
		function departments_popup_tree_onreturn(){
			var zTree = $.fn.zTree.getZTreeObj("poprole-ztree"),
				nodes = zTree.getCheckedNodes(true)
			var ret = "",names = "";
			for(var i=0; i< nodes.length; i++){
					ret += ";" + nodes[i].value;
					names += ","+nodes[i].name;
			}
			var args = {};
			if (ret.length > 0){
				ret = ret.substr(1);
				names = names.substr(1);
				args["id"] = ret;
				args["name"] = names;
			}else{
				args["id"] = "";
				args["name"] = "";
			}
			$.CurrentNavtab.find(":input").each(function() {
				var $input = $(this), inputName = $input.attr("name");
				for(var key in args){
					var name = $.fn.lookup.Constructor.prototype.getField(key);
					if (name == inputName){
						$input
							.val(args[key])
							.trigger($.fn.lookup.Constructor.EVENTS.afterChange, {value:args[key]});
					}
				}
			});
			var loup = $.fn.lookup.Constructor.prototype.LookupElement();
			var callback = loup.attr("data-callback");
			var group = loup.attr("data-group");
			
			if (callback != "" &&  callback != undefined)
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
			BJUI.dialog("closeCurrent");
		}
	';
	}
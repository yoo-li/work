<?php
require_once('Smarty_setup.php');
require_once('include/utils/UserInfoUtil.php');
require_once('modules/Mall_Categorys/utils.php');
$smarty = new vtigerCRM_Smarty;

global $mod_strings;
global $app_strings,$supplierusertype;
global $app_list_strings,$current_user;

$roleout = '';

$hrarray = getGenericCategoryTree("商品分类");

if (isset($_REQUEST['mode']) && $_REQUEST['mode'] == '1')
{
	//check:{chkboxType:{'Y':'','N':''}},
	createGenericCategoryTree($roleout,$hrarray , strval($_REQUEST['exclude']), null, true);
	$roleout = '<ul id="poprole-ztree" class="ztree" data-setting="{check:{chkboxType:{\'Y\':\'s\',\'N\':\'s\'}},callback:{beforeExpand:category_popup_OnBeforeExpand}}" data-toggle="ztree" data-expand-all="false" data-check-enable="true" data-on-click="category_popup_tree_onclick">'.$roleout.'</ul>';
}
else
{
	createGenericCategoryTree($roleout,$hrarray , strval($_REQUEST['exclude']), null, true);
	$roleout = '<ul id="poprole-ztree" class="ztree" data-setting="{callback:{beforeExpand:category_popup_OnBeforeExpand}}" data-toggle="ztree" data-expand-all="false" data-chk-style="radio" data-radio-type="all" data-check-enable="true" data-on-click="category_popup_tree_onclick">'.$roleout.'</ul>';
}
$smarty->assign("SCRIPT", javascript());
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);

$smarty->assign("MSG", $roleout);
if (isset($_REQUEST['mode']) && $_REQUEST['mode'] != '')
{
	$smarty->assign("BUTTONS", array ('<button type="button" class="btn-green" onclick="category_popup_tree_onreturn();" data-icon="check-square-o">确定</button>'));
}

$smarty->display("PopupTree.tpl");

function javascript()
{
	return '
		function category_popup_tree_onclick(event,treeID,treeNode){
			var zTree = $.fn.zTree.getZTreeObj(treeID);
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
			var zTree         = $.fn.zTree.getZTreeObj(treeId);
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
			var zTree = $.fn.zTree.getZTreeObj(treeId);
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
			var zTree = $.fn.zTree.getZTreeObj(treeId);
			var nodes = zTree.getNodes();
			$.each(nodes, function (node)
			{
				if (node.open)
					return node;
			});
			return null;
		}

		function category_popup_tree_onreturn(){
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
<?php
require_once('include/utils/UserInfoUtil.php');
require_once('Smarty_setup.php');
if (isset($_REQUEST['loadtree']) && $_REQUEST['loadtree'] == "true") {
	echo getRolesTree();
	die();
}
if(isset($_REQUEST['switch']) && $_REQUEST['switch'] != '')
{
	$switch = $_REQUEST['switch'];
    XN_Memcache::put($switch,"show_role_".XN_Application::$CURRENT_URL); 
	echo '{"statusCode":200,"tabid":"Settings"}';
	die();
}
$smarty = new vtigerCRM_Smarty;
global $mod_strings;
global $app_strings;
$smarty->assign("APP", $app_strings);
$smarty->assign("MOD", return_module_language($current_language,'Settings'));
$smarty->assign("CMOD", $mod_strings);
$smarty->assign("MODULE",$currentModule);
global $current_user;
if (is_admin($current_user))
{
	try{
	    $switch = XN_Memcache::get("show_role_".XN_Application::$CURRENT_URL);
	}
	catch(XN_Exception $e){
	    $switch='true';
	    XN_Memcache::put("true","show_role_".XN_Application::$CURRENT_URL);
	}

	if ($switch == 'true')
	{
		$show_role_button = '<button type="button" class="btn-default" data-icon="toggle-off" onclick="RoleManager_switch(false);">'.getTranslatedString('LBL_CLOSE_SHOW_ROLE_BUTTON_LABEL').'</button>';
	}
	else
	{
		$show_role_button = '<button type="button" class="btn-default" data-icon="toggle-on" onclick="RoleManager_switch(true);">'.getTranslatedString('LBL_OPEN_SHOW_ROLE_BUTTON_LABEL').'</button>';
	}

	$smarty->assign("SHOW_ROLE_BUTTON", $show_role_button);
}
// $smarty->assign("ROLETREE", getRolesTree());
$smarty->assign("SCRIPT",javascript());
$smarty->display("Roles/RolesManager.tpl");



function getRolesTree(){
	$roleout = '';
	createGenericRoleTree($roleout,getGenericRoleTree(),null,null,false,false,true);
	$roleout = '<ul id="rolemanager-ztree" class="ztree" 
					data-on-node-created = "RoleManager_onNodeCreated" 
					data-on-collapse = "RoleManager_CollapseTreeNode" 
					data-on-expand = "RoleManager_ExpandTreeNode" 
					data-add-hover-dom = "RoleManager_addHoverDom" 
					data-remove-hover-dom = "RoleManager_removeHoverDom" 
					data-before-drag = "RoleManager_beforeDrag"
					data-before-drop = "RoleManager_beforeDrop"
					data-on-drop = "RoleManager_onDrop"
					data-edit-enable = "true"
					data-toggle="ztree" 
					data-expand-all="true">'.$roleout.'</ul>';
	$roleout .= '<span id="rolemanager-ztree-string-width" style="visibility: hidden; white-space: nowrap;font-weight: bold;"></span>';
	return $roleout;
}

function javascript() {
	return '
		function RoleManager_removeHoverDom(treeId, treeNode){
			jQuery("#addBtn_"+treeNode.id).unbind().remove();
			jQuery("#editBtn_"+treeNode.id).unbind().remove();
			jQuery("#removeBtn_"+treeNode.id).unbind().remove();
		}
		
		function RoleManager_addHoverDom(treeId, treeNode){
			jQuery("#"+treeNode.tId+"_nbsp_span").unbind().remove();
			var sObj = jQuery("#"+treeNode.tId + "_bt_span");
			if ($("#addBtn_"+treeNode.id).length > 0) return;
			sObj.append(\'<span class="tree_add" style="vertical-align:top;" id="addBtn_\' + treeNode.id +\'" title="增加一个新的部门信息"></span>\')
			$("#addBtn_"+treeNode.id).bind("click", function() {
				var ajaxurl = "index.php?module=Settings&action=RolesManagerOper&opertype=add&parenttab=Settings&parent="+treeNode.id;	
				$(this).dialog({id:"RolesManagerDialog", url:ajaxurl, title:"新建部门", mask:true, resizable:false, maxable:false});
			});
			
			if ($("#editBtn_"+treeNode.id).length > 0) return;
			sObj.append(\'<span class="tree_edit" style="vertical-align:top;" id="editBtn_\' + treeNode.id +\'" title="编辑当前部门信息"></span>\')
			$("#editBtn_"+treeNode.id).bind("click", function() {
			    var ajaxurl = "index.php?module=Settings&action=RolesManagerOper&opertype=edit&parenttab=Settings&roleid="+treeNode.id;
				$(this).dialog({id:"RolesManagerDialog", url:ajaxurl, title:"编辑部门："+treeNode.nodename, mask:true, resizable:false, maxable:false});
			});
			
			if (treeNode.getParentNode() != null) {
				if ($("#removeBtn_"+treeNode.id).length > 0) return;
				sObj.append(\'<span class="tree_del" style="vertical-align:top;" id="removeBtn_\' + treeNode.id +\'" title="删除当前部门信息"></span>\')
				$("#removeBtn_"+treeNode.id).bind("click", function() {
					var ajaxurl = "index.php?module=Settings&action=RolesManagerOper&opertype=del&parenttab=Settings&roleid="+treeNode.id;
					$(this).dialog({id:"RolesManagerDialog", url:ajaxurl, title:"删除部门："+treeNode.nodename, mask:true, resizable:false, maxable:false, height:180});
				});
			}
		}
		
		function RoleManager_CollapseTreeNode(event, treeId, treeNode){
			var sObj = jQuery("#"+treeNode.tId + "_a");
			sObj.find("span.line").each(function(){
					$(this).hide();
				});
		}
		
		function RoleManager_ExpandTreeNode(event, treeId, treeNode){
			var sObj = jQuery("#"+treeNode.tId + "_a");
			sObj.find("span.line").each(function(){
					$(this).show();
				});
		}
		
		function RoleManager_getNodeWidth(treeNode,isAll) {
			var width = 0;
			if (treeNode != null) {
				$("#rolemanager-ztree-string-width").text(treeNode.name);
				width += $("#rolemanager-ztree-string-width")[0].offsetWidth + (treeNode.level+2) * 22;
			}
			return width;
		}
		
		function RoleManager_onNodeCreated(event, treeId, treeNode) {
			var span = "";
			var treeWidth = $("#"+treeId).width();
			var treeLeftWidth = RoleManager_getNodeWidth(treeNode,true);
			var spanWidth = treeWidth - treeLeftWidth;
			var sObj = jQuery("#"+treeNode.tId + "_a");
			var diyDom = "";
			var tmplist = "";
			if ($("#"+treeId).data("addHoverDom")) {
				spanWidth -= 60;
			}
			if (treeNode.leadership != null && treeNode.leadership != "")
			{
				span += "<font color=red>【部门领导:"+treeNode.leadership+"】</font>";
				tmplist += "【部门领导:"+treeNode.leadership+"】";
			}
			if (treeNode.mainleadership != null && treeNode.mainleadership != "")
			{
				span += "<font color=red>【主管领导:"+treeNode.mainleadership +"】</font>";
				tmplist += "【主管领导:"+treeNode.mainleadership +"】";
			}
			if (treeNode.userData != null && treeNode.userData != "")
			{
				var userlist = "";
				for (var i = 0; i < treeNode.userData.length; i++) {
					if (userlist == "") {
						userlist = treeNode.userData[i].username;
					}else{
						userlist += ", "+treeNode.userData[i].username;
					}
				}
				if (userlist != "") {
					userlist = "【成员:"+ userlist+"】";
					tmplist += userlist;
				}
				if (span != "") {
					userlist = span + userlist;
				}
				var height = 0;
				var subheight = 0;
				var lineHeight = 0;
				if (tmplist != "") {
					$("#rolemanager-ztree-string-width").text(tmplist);
					linewidth = $("#rolemanager-ztree-string-width")[0].offsetWidth;
					if (spanWidth > linewidth) {
						spanWidth = 0;
					}else{
						var lineHeight = ($("#rolemanager-ztree-string-width").height()+3);
						height = (Math.floor(linewidth/spanWidth)+1) * lineHeight;
						subheight = Math.floor(linewidth/spanWidth) * lineHeight +2;
					}
				}
				sObj.parent().find("span.switch").each(function(){
						$(this).css("vertical-align","top");
						if (spanWidth > 0) {
							if (!$(this).hasClass("center_docu") && !$(this).hasClass("bottom_docu")) {
								if ($("#"+treeNode.tId+"_a_line").length <= 0){
									sObj.prepend("<span id=\""+treeNode.tId+"_a_line\" class=\"line\" style=\"height: "+subheight+"px; width: 9px; margin-top: 17px; margin-left: -1px; position: absolute;\"></span>");
								}
							}
							if ($(this).hasClass("center_docu") || $(this).hasClass("center_close")) {
								if ($("#"+treeNode.tId+"_span_line").length <= 0){
									sObj.parent().prepend("<span id=\""+treeNode.tId+"_span_line\" class=\"line\" style=\"height: "+subheight+"px; width: 9px; margin-top: 20px; position: absolute;\"></span>");
								}
							}
						}
					});
				if (height > 0) {
					sObj.css("height", height+"px");
				}
				diyDom = "<span style=\'vertical-align:top;font-weight: normal;color:#222;"+(spanWidth > 0?"word-wrap:break-word; white-space: normal;display:inline-block;width:"+spanWidth+"px;":"")+"\'>"+userlist+"</span>";
			}

			if ($("#"+treeId).data("addHoverDom")) {
				diyDom = "<span style=\'margin-left: 4px;\'><span style=\'vertical-align:top;width:55px;\' id=\'"+treeNode.tId+"_bt_span\'></span>"+diyDom+"</span>";
			}
			if (diyDom != "") {
				sObj.append(diyDom);
			}
		}
		
		function RoleManager_beforeDrag(treeId, treeNodes) {
			// for (var i=0,l=treeNodes.length; i<l; i++) {
			// 	if (treeNodes[i].pid == "0" || treeNodes[i].pid == "") {
			// 		return false;
			// 	}
			// }
			// return true;
		}

		function RoleManager_beforeDrop(treeId, treeNodes, targetNode, moveType, isCopy) {
			if( targetNode == null) {
				return false;
			}
		}
		
		function RoleManager_onDrop(event, treeId, treeNodes, targetNode, moveType, isCopy){
			if(moveType == null) {
				return;
			}
			
			var nodes = "";
			for (var i = 0; i < treeNodes.length; i++) {
				nodes += ";"+ treeNodes[i].id
			}
			if (nodes.length > 0) {
				nodes = nodes.substr(1);
			}
			var ajaxurl = "index.php?module=Settings&action=RolesManagerOper&opertype=move&movetype="+(moveType?moveType:"")+"&parenttab=Settings&roleid="+nodes+"&parent=";
			if (targetNode) {
				ajaxurl += targetNode.id
			}
			$(this).bjuiajax("doAjax", {url:ajaxurl});
		}
		
		function RoleManager_switch(isHide){
			var ajaxurl = "index.php?module=Settings&action=RolesManager&parenttab=Settings&switch=";
			if (isHide) {
				ajaxurl += "true";
			}else{
				ajaxurl += "false";
			}
			$(this).bjuiajax("doAjax", {url:ajaxurl});
		}
	';
}

?>
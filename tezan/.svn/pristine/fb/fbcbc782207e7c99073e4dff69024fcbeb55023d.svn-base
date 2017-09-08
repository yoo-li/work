<?php
require_once('include/utils/UserInfoUtil.php');
require_once('Smarty_setup.php');
$smarty = new vtigerCRM_Smarty;
global $mod_strings;
global $app_strings;
$smarty->assign("APP", $app_strings);
$smarty->assign("MOD", return_module_language($current_language,'Settings'));
$smarty->assign("CMOD", $mod_strings);
$smarty->assign("MODULE",$currentModule);
$smarty->assign("ACTION","SaveRole");

$opertype ="";
if (isset($_REQUEST["opertype"]) && $_REQUEST["opertype"] != "") {
	$opertype = $_REQUEST["opertype"];
}
if ($opertype == "add") {
	if (isset($_REQUEST["parent"]) && $_REQUEST["parent"] != "") {
		$smarty->assign("PARENT",$_REQUEST["parent"]);
		$smarty->assign("ROLEID","-1");
		$smarty->assign("SEQUENCE","100");
		$smarty->assign("ROLETYPE","1");
		$smarty->assign("PARENTNAME",getRoleName($_REQUEST["parent"]));
		$smarty->assign("BUTTONS", array('<button type="submit" class="btn-green" data-icon="save">保存</button>'));
	}
}elseif ($opertype == "edit") {
	if (isset($_REQUEST["roleid"]) && $_REQUEST["roleid"] != "" && $_REQUEST["roleid"] != "-1") {
		$roleid= $_REQUEST['roleid'];
		$roleinfo = getRoleInfo($roleid);
		if (is_array($roleinfo) && count($roleinfo) > 0) {
 		   $rolename = $roleinfo["rolename"];
 		   $leadership = $roleinfo["leadership"];
 		   $mainleadership = $roleinfo["mainleadership"];
		   
 		   $leadership_screenname = getUserNameList($leadership);
 		   $mainleadership_screenname = getUserNameByProfile($mainleadership);

 		   $parent = $roleinfo["parent"];
		
 		   $sequence = $roleinfo["sequence"];
 		   $roletype = $roleinfo["roletype"];
 			if(!isset($sequence) || $sequence == ''){
 				$sequence = 100;	
 			}
 			$smarty->assign("PARENT",$parent);
 			$smarty->assign("SEQUENCE",$sequence);
 			$smarty->assign("PARENTNAME",getRoleName($parent));
 			$smarty->assign("ROLEID", $roleid);
 			$smarty->assign("ROLENAME",$rolename);
 			$smarty->assign("LEADERSHIP",join(";",$leadership));
 			$smarty->assign("MAINLEADERSHIP",$mainleadership);
 			$smarty->assign("LEADERSHIP_SCREENNAME",join(";",$leadership_screenname));
 			$smarty->assign("MAINLEADERSHIP_SCREENNAME",$mainleadership_screenname);
 			$smarty->assign("ROLETYPE",$roletype);
		}
		$smarty->assign("BUTTONS", array('<button type="submit" class="btn-green" data-icon="edit">更新</button>'));
	}
}elseif ($opertype == "del") {
	if (isset($_REQUEST["roleid"]) && $_REQUEST["roleid"] != "" && $_REQUEST["roleid"] != "-1") {
		$roleid= $_REQUEST['roleid'];
		$rolename = getRoleName($roleid);
		$roleout = '';
		createGenericRoleTree($roleout,getGenericRoleTree(),null,$roleid,false,false,false);
		$roleout = '<ul id="rolemanager_selectztree" class="ztree hide" 
						data-toggle="ztree" 
						data-check-enable="true" 
						data-chk-style="radio"
						data-radio-type="all"
						data-on-check="rolemanager_selectztree_nodecheck" 
						data-on-click="rolemanager_selectztree_nodeclick"
						data-expand-all="true">'.$roleout.'</ul>';
		$customHtml = '
			<div class="form-group">
				<label class="control-label x120" for="rolename">要删除的部门：</label>
				<input readonly id="rolename" name="rolename" value="'.$rolename.'" class="required" style="padding-right: 15px;" data-rule="required;" type="text" placeholder="输入部门的名称" size="20">
			</div>
			<div class="form-group">
				<label class="control-label x120" for="rolename">为成员分配部门：</label>
				<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;">
					<input type="text" id="user_rolename" value="" style="cursor: pointer;" data-toggle="selectztree" data-value="#parent" size="20" data-tree="#rolemanager_selectztree"  data-rule="required" placeholder="请选择一个部门" readonly>
					<a class="bjui-lookup" style="height: 22px; line-height: 22px;" href="javascript:user_rolenameclick();">
						<i class="fa fa-search"></i>
					</a>
				'.$roleout.'
				</span>
			</div>
		';
		$script = '
			function user_rolenameclick(){
				$("#user_rolename").focus();
				$("#user_rolename").trigger("click");
			}
			function rolemanager_selectztree_nodecheck(event, treeId, treeNode) {
				var zTree = $.fn.zTree.getZTreeObj(treeId),
					nodes = zTree.getCheckedNodes(true)
				var ids = "", names = ""
				for (var i = 0; i < nodes.length; i++) {
					ids   += ";"+ nodes[i].id
					names += ";"+ nodes[i].name
				}
				if (ids.length > 0) {
					ids = ids.substr(1), names = names.substr(1)
				}
				var $from = $("#"+ treeId).data("fromObj")
				if ($from && $from.length) {
					$from.val(names).trigger("validate")
					var $fromvalue = $($("#"+ treeId).data("fromObj").data("value"));
					if ($fromvalue && $fromvalue.length) {
						$fromvalue.val(ids).trigger("validate")
					}
				}
			}
			
			function rolemanager_selectztree_nodeclick(event, treeId, treeNode) {
				var zTree = $.fn.zTree.getZTreeObj(treeId)
				zTree.checkNode(treeNode, !treeNode.checked, true, true)
				event.preventDefault()
			}
			';
		$smarty->assign("ROLEID", $roleid);
		$smarty->assign("CUSTOMHTML",$customHtml);
		$smarty->assign("ACTION","DeleteRole");
		$smarty->assign("SCRIPT",$script);
		$smarty->assign("BUTTONS", array('<button type="submit" class="btn-red" data-icon="trash-o">删除</button>'));
	}
}elseif ($opertype == "move") {
	if (isset($_REQUEST["roleid"]) && $_REQUEST["roleid"] != "" && $_REQUEST["roleid"] != "-1") {
		$moveNodes = explode(';',$_REQUEST["roleid"]);
		$moveParent = $_REQUEST["parent"];
		$moveType = $_REQUEST["movetype"];
		$parentInfo = getRoleInfo($moveParent);
		$parentPath = $parentInfo["parentrole"];
		if ($moveType == "inner") {
			$subRolesInfo = getSubRolseInfo($moveParent,false,1);
			$sequence = "0";
			if (isset($subRolesInfo) && is_array($subRolesInfo) && count($subRolesInfo)>0) {
				rsort($subRolesInfo);
				$sequence = $subRolesInfo[0]["sequence"];
			}
			$roleSave = array();
			foreach($moveNodes as $moveRoleID){
				$sequence++;
				$moveRoleInfo = getRoleInfo($moveRoleID);
				$loadcontent = XN_Content::load($moveRoleInfo["xnid"],"Roles");
				$parentrole = $parentPath."::".$moveRoleID;
				$loadcontent->my->parentrole = $parentrole;
				$loadcontent->my->depth = count(explode('::',$parentrole));
				$loadcontent->my->sequence = $sequence;
				$roleSave[] = $loadcontent;
			}
			if (count($roleSave) > 0) {
				XN_Content::batchsave($roleSave,"Roles");
			}
		}elseif ($moveType == "prev") {
			$tmpParent = explode('::',$parentPath);
			array_pop($tmpParent);
			$tmpPath = array_pop($tmpParent);
			$roleSave = array();
			if (isset($tmpPath)) {
				$parentInfo = getRoleInfo($tmpPath);
				$rootInfo = getSubRolseInfo($tmpPath,false,1);
				$parentPath = $parentInfo["parentrole"];
			}else{
				$rootInfo = getRootRolseInfo($moveNodes);
			}
			$sequence = "1";
			foreach($rootInfo as $root){
				if (in_array($root["roleid"],$moveNodes)) {
					continue;
				}
				if ($moveParent == $root["roleid"]) {
					foreach($moveNodes as $moveRoleID){
						if (isset($tmpPath)) {
							$newParentrole = $parentPath."::".$moveRoleID;
						}else{
							$newParentrole = $moveRoleID;
						}
						$moveRoleInfo = getRoleInfo($moveRoleID);
						$loadcontent = XN_Content::load($moveRoleInfo["xnid"],"Roles");
						$loadcontent->my->parentrole = $newParentrole;
						$loadcontent->my->sequence = $sequence;
						$loadcontent->my->depth = "1";
						$roleSave[] = $loadcontent;
						$sequence++;
					}
					$loadcontent = XN_Content::load($root["xnid"],"Roles");
					$loadcontent->my->sequence = $sequence;
					$loadcontent->my->depth = "1";
					$roleSave[] = $loadcontent;
					$sequence++;
				}else{
					$loadcontent = XN_Content::load($root["xnid"],"Roles");
					$loadcontent->my->sequence = $sequence;
					$loadcontent->my->depth = "1";
					$roleSave[] = $loadcontent;
					$sequence++;
				}
			}
			if (count($roleSave) > 0) {
				XN_Content::batchsave($roleSave,"Roles");
			}
		}elseif ($moveType == "next") {
			$tmpParent = explode('::',$parentPath);
			array_pop($tmpParent);
			$tmpPath = array_pop($tmpParent);
			$roleSave = array();
			if (isset($tmpPath)) {
				$parentInfo = getRoleInfo($tmpPath);
				$rootInfo = getSubRolseInfo($tmpPath,false,1);
				$parentPath = $parentInfo["parentrole"];
			}else{
				$rootInfo = getRootRolseInfo($moveNodes);
			}
			$sequence = "1";
			foreach($rootInfo as $root){
				if (in_array($root["roleid"],$moveNodes)) {
					continue;
				}
				if ($moveParent == $root["roleid"]) {
					$loadcontent = XN_Content::load($root["xnid"],"Roles");
					$loadcontent->my->sequence = $sequence;
					$loadcontent->my->depth = "1";
					$roleSave[] = $loadcontent;
					$sequence++;
					foreach($moveNodes as $moveRoleID){
						if (isset($tmpPath)) {
							$newParentrole = $parentPath."::".$moveRoleID;
						}else{
							$newParentrole = $moveRoleID;
						}
						$moveRoleInfo = getRoleInfo($moveRoleID);
						$loadcontent = XN_Content::load($moveRoleInfo["xnid"],"Roles");
						$loadcontent->my->parentrole = $newParentrole;
						$loadcontent->my->sequence = $sequence;
						$loadcontent->my->depth = "1";
						$roleSave[] = $loadcontent;
						$sequence++;
					}
				}else{
					$loadcontent = XN_Content::load($root["xnid"],"Roles");
					$loadcontent->my->sequence = $sequence;
					$loadcontent->my->depth = "1";
					$roleSave[] = $loadcontent;
					$sequence++;
				}
			}
			if (count($roleSave) > 0) {
				XN_Content::batchsave($roleSave,"Roles");
			}
			foreach($moveNodes as $moveRoleID){
				VTCacheUtils::clearRoleSubordinates($moveRoleID);
			}
			XN_MemCache::delete("session_".XN_Application::$CURRENT_URL);
		}
		echo '{"statusCode":200,"divid":"RoleManagerTreeForm"}';
		die();
	}
	echo '{"statusCode":"300","message":"参数错误，无法完成操作！"}';
	die();
}


$smarty->display("Roles/RolesManagerOper.tpl");
?>
<?php
	require_once('include/utils/CommonUtils.php');

	global $app_strings, $mod_strings;

	$header_array = getHeaderArray();
	$access = array();
	if(isset($_REQUEST["record"]) && $_REQUEST["record"] != ""){
		try{
			$permission = XN_Content::load($_REQUEST["record"],"ma_accesssetting");
			$access_content = $permission->my->access_content;
			$access = explode(";",$access_content);
		}catch(XN_Exception $e){}
	}
	$readonly = false;
	if(isset($_REQUEST["readonly"]) && $_REQUEST["readonly"] == "true"){
		$readonly = true;
	}
	if (isset($header_array["Ma_Setting Manage"]))
	{
		unset($header_array["Ma_Setting Manage"]);
	}
	$nodes = "";
	foreach ($header_array as $modname => $subinfo)
	{
		$modselect = false;
		if (isset($access) && is_array($access) && count($access)>0 && in_array($modname,$access)) {
			$modselect = true;
		}
		$nodes .= '<li  data-id="'.$modname.'"
							data-pid="0"
							data-faicon="gift"
							'.($modselect?'data-checked="true"':"").'
							'.($readonly?'data-chk-disabled="true"':"").'
							data-checkall="false">'.getTranslatedString($modname).'</li>';
		foreach ($subinfo as $value)
		{
			$nodselect = false;
			if (isset($access) && is_array($access) && count($access)>0 && in_array($modname,$access) && in_array($value,$access)) {
				$nodselect = true;
			}
			$nodes .= '<li  data-id="'.$value.'"
							data-pid="'.$modname.'"
							data-faicon="gift"
							'.($nodselect?'data-checked="true"':"").'
							data-checkall="false">'.getTranslatedString($value).'</li>';
		}
	}
	$roleout = '
		<input type="hidden" id="access_content" name="access_content" value="'.$access_content.'">
		<ul id="poprole-ztree" class="ztree" data-setting="{check:{chkboxType:{\'Y\':\'ps\',\'N\':\'ps\'}'.($readonly?',chkDisabledInherit:true':"").'}}" data-toggle="ztree" data-expand-all="false" data-check-enable="true" data-on-check="subpermission_oncheck" data-on-click="subpermission_onclick">'.$nodes.'</ul>
	';

	$roleout .= '
		<script type="text/javascript" defer="defer">
			function subpermission_onclick(event,treeID,treeNode){
				var zTree = $.fn.zTree.getZTreeObj(treeID);
				zTree.checkNode(treeNode,!treeNode.checked,true,true);
				event.preventDefault();
			}
			function subpermission_oncheck(event,treeID,treeNode){
				var zTree = $.fn.zTree.getZTreeObj(treeID);
				var nodes = zTree.getCheckedNodes(true);
				event.preventDefault();
				var ret = "";
				for(var i=0; i< nodes.length; i++){
					ret += ";" + nodes[i].id;
				}
				if (ret.length > 0){
					ret = ret.substr(1);
				}

				$("#access_content").val(ret);
			}
		</script>
	';
	echo $roleout;
<?php
	require_once('Smarty_setup.php');
	require_once('include/utils/UserInfoUtil.php');
	$smarty = new vtigerCRM_Smarty;

	global $mod_strings;
	global $app_strings;
	global $app_list_strings;

	$smarty->assign("SCRIPT", javascript());
	$smarty->assign("APP", $app_strings);
	$smarty->assign("CMOD", $mod_strings);

	if (isset($_SESSION['supplierid']) && $_SESSION['supplierid'] != '' && $_SESSION['supplierid'] != '0')
	{
		global $copyrights; 
		if ($copyrights['program'] == 'ma')
		{
			require_once('modules/Ma_Departments/utils.php');
		}
		else
		{
			require_once('modules/Supplier_Departments/utils.php');
		}
		
		$smarty->assign("MSG", getSupplierRolesTree($_SESSION['supplierid']));
	}
	else
	{
		$smarty->assign("MSG", getSysRolesTree());
	}
	if (isset($_REQUEST['mode']) && $_REQUEST['mode'] != '')
	{
		$smarty->assign("BUTTONS", array ('<button type="button" class="btn-green" data-toggle="lookupback" data-lookupid="select_ids" data-warn="请至少选择一个成员" data-icon="check-square-o">确定</button>'));
	}

	$smarty->display("Roles/PopupTreeByPanel.tpl");

	function getSysRolesTree()
	{
		$selectNodes = array ();
		if (isset($_REQUEST['selectids']) && $_REQUEST['selectids'] != "")
		{
			if (is_string($_REQUEST['selectids']))
			{
				$selectNodes = explode(';', $_REQUEST['selectids']);
			}
		}
		$roleout = '';
		createGenericRoleTree($roleout, getGenericRoleTree(), null, null, false, false, true);
		$roleout = '<ul id="popuprole-ztree" class="ztree"
					data-on-node-created = "PopupRole_onNodeCreated" 
					data-on-collapse = "PopupRole_CollapseTreeNode" 
					data-on-expand = "PopupRole_ExpandTreeNode" 
					data-on-click = "PopupRole_onClick"
					data-user-checkmode = '.$_REQUEST['mode'].'
					data-user-select = '.json_encode($selectNodes).'
					data-toggle="ztree" 
					data-expand-all="true">'.$roleout.'</ul>';
		$roleout .= '<span id="popuprole-ztree-string-width" style="position: absolute; top: -20px;visibility: hidden; white-space: nowrap;font-weight: bold;"></span>';
		if(isset($_REQUEST["canempty"]) && $_REQUEST["canempty"] == "true")
		{
			$roleout .= '<input type="checkbox" style="display:none;" name="select_ids" checked value="{id:\'\',name:\'\'}">';
		}
		return $roleout;
	}

	function getSupplierRolesTree($supplierid)
	{
		$selectNodes = array ();
		if (isset($_REQUEST['selectids']) && $_REQUEST['selectids'] != "")
		{
			if (is_string($_REQUEST['selectids']))
			{
				$selectNodes = explode(';', $_REQUEST['selectids']);
			}
		}
		$roleout = '';
		createGenericDepartmentsTree($roleout, getGenericDepartmentsTree($supplierid), null, null, false, false, true);

		$roleout = '<ul id="popuprole-ztree" class="ztree"
				data-on-node-created = "PopupRole_onNodeCreated"
				data-on-collapse = "PopupRole_CollapseTreeNode"
				data-on-expand = "PopupRole_ExpandTreeNode"
				data-on-click = "PopupRole_onClick"
				data-user-checkmode = '.$_REQUEST['mode'].'
				data-user-select = '.json_encode($selectNodes).'
				data-toggle="ztree"
				data-expand-all="true">'.$roleout.'</ul>';
		$roleout .= '<span id="popuprole-ztree-string-width" style="position: absolute; top: -20px;visibility: hidden; white-space: nowrap;font-weight: bold;"></span>';
		return $roleout;
	}

	function javascript()
	{
		return '
		function PopupRole_CollapseTreeNode(event, treeId, treeNode){
			var sObj = jQuery("#"+treeNode.tId + "_a");
			sObj.find("span.line").each(function(){
					$(this).hide();
				});
		}
	
		function PopupRole_ExpandTreeNode(event, treeId, treeNode){
			var sObj = jQuery("#"+treeNode.tId + "_a");
			sObj.find("span.line").each(function(){
					$(this).show();
				});
		}
	
		function PopupRole_getNodeWidth(treeNode) {
			var width = 0;
			if (treeNode != null) {
				$("#popuprole-ztree-string-width").text(treeNode.name);
				width += $("#popuprole-ztree-string-width")[0].offsetWidth + (treeNode.level+1) * 22+20;
			}
			return width;
		}
	
		function PopupRole_onNodeCreated(event, treeId, treeNode) {
			var treeWidth = $("#"+treeId).clientwidth;
			$("#"+treeId).each(function(){
				treeWidth = this.offsetWidth - this.offsetLeft*2;
				})
			var userSelect = $("#"+treeId).data("userSelect");
			var checkmode = $("#"+treeId).data("userCheckmode");
			var treeLeftWidth = PopupRole_getNodeWidth(treeNode);
			var spanWidth = treeWidth - treeLeftWidth;
			var sObj = jQuery("#"+treeNode.tId + "_a");
			var diyDom = "";
			var tmplist = "";
			if ($("#"+treeId).data("addHoverDom")) {
				spanWidth -= 60;
			}
			if (treeNode.userData != null && treeNode.userData != "")
			{
				var userlist = "";
				var linewidth = 0;
				var line = 0;
				var subWidth = 0;
				for (var i = 0; i < treeNode.userData.length; i++) {
					var isCheck = "";
					for(var j=0; j < userSelect.length; j++){
						if (treeNode.userData[i].profileid == userSelect[j]) {
							isCheck = "checked";
							break;
						}
					}
					var value = "\'{id:\""+treeNode.userData[i].profileid+"\",name:\""+treeNode.userData[i].username+"\"}\'";
					$("#popuprole-ztree-string-width").text(treeNode.userData[i].username);
					var tmpWidth = $("#popuprole-ztree-string-width")[0].offsetWidth + 40;
					linewidth += tmpWidth;
					if (spanWidth < linewidth) {
						line++;
						linewidth = tmpWidth;
					}else if(subWidth < linewidth){
						subWidth = linewidth;
					}
					userlist += \'<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;margin: -4px 0px 4px 10px;">\';
					userlist += \'<input type="\'+checkmode+\'" \'+isCheck+\' id="\'+treeNode.userData[i].profileid+\'" name="select_ids" value=\'+value+\' data-toggle="icheck" data-label="\'+treeNode.userData[i].username+\'">\';
					userlist += \'</span>\';
				}
				var Lineheight = 0;
				if (line > 0) {
					Lineheight = (line+1)*19;
					sObj.css("height", Lineheight+"px");
				}
				sObj.parent().find("span.switch").each(function(){
						$(this).css("vertical-align","top");
						if (spanWidth > 0) {
							if (!$(this).hasClass("center_docu") && !$(this).hasClass("bottom_docu")) {
								if ($("#"+treeNode.tId+"_a_line").length <= 0){
									sObj.prepend("<span id=\""+treeNode.tId+"_a_line\" class=\"line\" style=\"height: "+(Lineheight-17)+"px; width: 9px; margin-top: 17px; margin-left: -1px; position: absolute;\"></span>");
								}
							}
							if ($(this).hasClass("center_docu") || $(this).hasClass("center_close")) {
								if ($("#"+treeNode.tId+"_span_line").length <= 0){
									sObj.parent().prepend("<span id=\""+treeNode.tId+"_span_line\" class=\"line\" style=\"height: "+(Lineheight-20)+"px; width: 9px; margin-top: 20px; position: absolute;\"></span>");
								}
							}
						}
					});
				diyDom = "<span id=\'"+treeNode.tId+"_user_span\' style=\'vertical-align:top;font-weight: normal;color:#222;"+(subWidth > 0?"word-wrap:break-word; white-space: normal;display:inline-block;width:" + subWidth + "px;":"")+"\'>"+userlist+"</span>";
			}

			if ($("#"+treeId).data("addHoverDom")) {
				diyDom = "<span style=\'margin-left: 4px;\'><span style=\'vertical-align:top;width:55px;\' id=\'"+treeNode.tId+"_bt_span\'></span>"+diyDom+"</span>";
			}
			if (diyDom != "") {
				sObj.append(diyDom).initui();
			}
		}
		
		function PopupRole_onClick(event,treeID,treeNode){
			if ($("#"+treeID).data("userCheckmode") == "checkbox") {
				event.preventDefault()
				var sObj = jQuery("#"+treeNode.tId + "_user_span");
				sObj.find(":input").each(function() {
					if (treeNode.checkall) {
						$(this).iCheck("uncheck");
					}else{
						$(this).iCheck("check");
					}
				});
				if (treeNode.children) {
					for(var i=0;i < treeNode.children.length; i++){
						treeNode.children[i].checkall = treeNode.checkall;
						PopupRole_onClick(event,treeID,treeNode.children[i]);
					}
				}
				treeNode.checkall = !treeNode.checkall;
			}
		}
	';
	}
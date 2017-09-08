function DepartmentsManager_removeHoverDom(treeId, treeNode){
	jQuery("#addBtn_"+treeNode.id).unbind().remove();
	jQuery("#editBtn_"+treeNode.id).unbind().remove();
	jQuery("#removeBtn_"+treeNode.id).unbind().remove();
}

function DepartmentsManager_addHoverDom(treeId, treeNode){
	jQuery("#"+treeNode.tId+"_nbsp_span").unbind().remove();
	var sObj = jQuery("#"+treeNode.tId + "_bt_span");
	if ($("#addBtn_" + treeNode.id).length > 0) return;
	sObj.append('<span class="tree_add" style="vertical-align:top;" id="addBtn_' + treeNode.id + '" title="增加一个新的部门信息"></span>')
	$("#addBtn_" + treeNode.id).bind("click", function ()
	{
		var ajaxurl = "index.php?module=Supplier_Departments&action=EditView&opertype=add&parenttab=Supplier_Departments Manage&parent=" + treeNode.value;
		$(this).dialog({id: "DepartmentsManagerDialog",height:"260", url: ajaxurl, title: "新建部门", mask: true, resizable: false, maxable: false});
	});

	if ($("#editBtn_" + treeNode.id).length > 0) return;
	sObj.append('<span class="tree_edit" style="vertical-align:top;" id="editBtn_' + treeNode.id + '" title="编辑当前分类信息"></span>')
	$("#editBtn_" + treeNode.id).bind("click", function ()
	{
		var ajaxurl = "index.php?module=Supplier_Departments&action=EditView&opertype=edit&parenttab=Supplier_Departments Manage&record=" + treeNode.value;
		$(this).dialog({
						   id: "DepartmentsManagerDialog",
						   url: ajaxurl,
						   title: "编辑部门：" + treeNode.nodename,
						   height:"260",
						   mask: true,
						   resizable: false,
						   maxable: false
					   });
	});

	if (treeNode.pid != "")
	{
		if ($("#removeBtn_" + treeNode.id).length > 0) return;
		sObj.append('<span class="tree_del" style="vertical-align:top;" id="removeBtn_' + treeNode.id + '" title="删除当前分类信息"></span>')
		$("#removeBtn_" + treeNode.id).bind("click", function ()
		{
			var ajaxurl = "index.php?module=Supplier_Departments&action=EditView&opertype=del&parenttab=Supplier_Departments Manage&record=" + treeNode.value;
			$(this).dialog({
							   id: "DepartmentsManagerDialog",
							   url: ajaxurl,
							   title: "删除部门：" + treeNode.nodename,
							   mask: true,
							   resizable: false,
							   maxable: false,
							   height: 180
						   });
		});
	}
}

function DepartmentsManager_beforeDrop(treeId, treeNodes, targetNode, moveType, isCopy) {
	if( targetNode == null) {
		return false;
	}
	if(treeNodes[0].iscustom){
		return false;
	}
}

function DepartmentsManager_onDrop(event, treeId, treeNodes, targetNode, moveType, isCopy){
	if(moveType == null) {
		return;
	}
	
	var nodes = "";
	for (var i = 0; i < treeNodes.length; i++) {
		nodes += ";"+ treeNodes[i].value
	}
	if (nodes.length > 0) {
		nodes = nodes.substr(1);
	}
	var ajaxurl = "index.php?module=Supplier_Departments&action=EditView&opertype=move&movetype="+(moveType?moveType:"")+"&parenttab=Supplier_Departments Manage&record="+nodes+"&parent=";
	if (targetNode) {
		ajaxurl += targetNode.value
	}
	$(this).bjuiajax("doAjax", {url:ajaxurl,loadingmask:true});
}


function DepartmentsManager_OnBeforeExpand(treeId, treeNode)
{
	var curExpandNode = DepartmentsManager_GetOpendNode(treeId);
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
		DepartmentsManager_singlePath(treeId, treeNode, curExpandNode);
	}
}

function DepartmentsManager_singlePath(treeId, newNode, oldNode)
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

function DepartmentsManager_GetOpendNode(treeId)
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

function DepartmentsManager_onClick(event, treeId, treeNode)
{
	event.preventDefault()

	if (treeNode.isParent)
	{
		var zTree = $.fn.zTree.getZTreeObj(treeId)

		zTree.expandNode(treeNode, !treeNode.open, false, true, true)
		return
	}
}

function DepartmentsManager_CollapseTreeNode(event, treeId, treeNode){
	var sObj = jQuery("#"+treeNode.tId + "_a");
	sObj.find("span.line").each(function(){
		$(this).hide();
	});
}

function DepartmentsManager_ExpandTreeNode(event, treeId, treeNode){
	var sObj = jQuery("#"+treeNode.tId + "_a");
	sObj.find("span.line").each(function(){
		$(this).show();
	});
}

function DepartmentsManager_getNodeWidth(treeNode,isAll) {
	var width = 0;
	if (treeNode != null) {
		$("#departmentsmanager-ztree-string-width").text(treeNode.name);
		width += $("#departmentsmanager-ztree-string-width")[0].offsetWidth + (treeNode.level+2) * 22;
	}
	return width;
}

function DepartmentsManager_onNodeCreated(event, treeId, treeNode) {
	var span = "";
	var treeWidth = $("#"+treeId).width();
	var treeLeftWidth = DepartmentsManager_getNodeWidth(treeNode,true);
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
	if ((treeNode.userData != null && treeNode.userData != "") || tmplist != "")
	{
		var userlist = "";
		for (var i = 0; i < treeNode.userData.length; i++) {
			if (userlist == "") {
				if(treeNode.userData[i].username == undefined){
					break;
				}
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
			$("#departmentsmanager-ztree-string-width").text(tmplist);
			linewidth = $("#departmentsmanager-ztree-string-width")[0].offsetWidth;
			if (spanWidth > linewidth) {
				spanWidth = 0;
			}else{
				var lineHeight = ($("#departmentsmanager-ztree-string-width").height()+3);
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
		diyDom = "<span style='vertical-align:top;font-weight: normal;color:#222;"+(spanWidth > 0?"word-wrap:break-word; white-space: normal;display:inline-block;width:"+spanWidth+"px;":"")+"'>"+userlist+"</span>";
	}

	if ($("#"+treeId).data("addHoverDom")) {
		diyDom = "<span style='margin-left: 4px;'><span style='vertical-align:top;width:55px;' id='"+treeNode.tId+"_bt_span'></span>"+diyDom+"</span>";
	}
	if (diyDom != "") {
		sObj.append(diyDom);
	}
}

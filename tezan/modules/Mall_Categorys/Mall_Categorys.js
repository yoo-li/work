/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/


function addCategory(obj,cp,label){
	var ajaxurl = 'index.php?module=Mall_Categorys&action=EditView&pid='+cp;
//	jQuery("#Category_info_form_div").loadUrl(ajaxurl);
	$(this).dialog({id:'catalog', url:ajaxurl, title:'新建顶级分类',width:600,height:280,mask:true,resizable:false,drawable:false,maxable:false});
}

function editCategory(obj,cp,label){
    var ajaxurl = 'index.php?module=Mall_Categorys&action=EditView&record='+cp;
	$(this).dialog({id:"catalog",url:ajaxurl, title:"编辑分类",width:600,height:280,mask:true});
}

function deleteCategory(obj,cp,label)
{
	var ajaxurl = 'index.php?module=Mall_Categorys&action=DeleteCategory&record='+cp;
	$(this).dialog({id:"catalog",url:ajaxurl, title: "删除分类",width:600,height:280,mask:true});
}

function saveCategory(module,parentid,id,name,sequence)
{
    if(name==''){
		$(this).alertmsg('warn','分类名称必填',{okName: "确定", cancelName: false, title: '提示', autoClose: true, alertTimeout: 5000});
		return;
	}
	if(sequence == '')
		sequence = '50';

	if(id == '-1')
	{
		var urlstring ="&mode=create&roleName="+name+"&sequence="+sequence+"&parent="+parentid;
	    var isnew = true;
	}
	else
	{
		 var urlstring = "&mode=edit&roleName="+name+"&sequence="+sequence+"&roleid="+id;
		 var isnew = false;
	}
	 var postBody = 'module='+module+'&action='+module+'Ajax&file=SaveRole'+urlstring;
	jQuery.post("index.php", postBody,
		function (data, textStatus)
		{
				    if(data.indexOf('<SUCCESS>')!== -1)
					{
						loadCategoryTree(module);
						return;
					}
					else
					{
						alert(data,alert_arr.ALERT_TITLE);
					}
		});

}



function  savedeleteCategory(module,roleid,user_role)
{

	var postBody = 'module='+module+'&action='+module+'Ajax&file=DeleteRole&delete_role_id='+roleid+'&user_role='+user_role;
	jQuery.post("index.php", postBody,
		function (data, textStatus)
		{
				         if(data.indexOf('<SUCCESS>')!== -1)
						{
								var zTree = jQuery.fn.zTree.getZTreeObj("categorys_tree");
								nodes = zTree.getSelectedNodes();
								if(nodes.length < 1)
								{
									loadCategoryTree(module);
									return;
								}
								var node = nodes[0];
								zTree.removeNode(node);
						}
						else
						{
							$(this).alertmsg('warn',data,{okName: "确定", cancelName: false, title: alert_arr.ALERT_TITLE, autoClose: true, alertTimeout: 5000});
							//jAlert(data,alert_arr.ALERT_TITLE);
						}
		});

}

function moveCategory(from,to)
{
   var postBody = 'module=Mall_Categorys&action=CategoryDragDrop&ajax=true&parentId='+to+'&childId='+from;
	jQuery.post("index.php", postBody,
		function (data, textStatus)
		{
				var zTree = jQuery.fn.zTree.getZTreeObj("categorys_tree");
				var node = zTree.getNodeByParam("id", to, null);
				zTree.reAsyncChildNodes(node, "refresh");
		});
}

function noNumbers(e)
{
	var keynum;
	if(window.event) // IE
	{
		keynum = e.keyCode;
	}
	else if(e.which) // Netscape/Firefox/Opera
	{
		keynum = e.which;
	}
	if((keynum < 48 || keynum > 57) && (keynum >= 32))
		return false;
	else
		return true;
}

function loadCmsCategoryTree(){
	var setting = {
			edit: {
				enable: true,
				showRemoveBtn: true,
				showRenameBtn: true,
				drag: {
					autoExpandTrigger: true,
					isMove : true,
					inner: true,
					prev : false,
					next: false
				}
			},
			data: {
				key: {
					title:"t"
				},
				simpleData: {
					enable: true,
					pIdKey : "pId",
					idKey: "id",
					rootPId: 0
				}
			},
			view:{
				addDiyDom: addDiyDom,
				addHoverDom: addHoverDom,
				removeHoverDom: removeHoverDom,
				selectedMulti: false
			},
			callback: {
				onClick: cmsCategoryTreeClick,
				beforeDrag: beforeDrag,
				beforeDrop: beforeDrop
			}
		};
    var postBody = "module=Mall_Categorys&action=LoadCategoryTree";
	    jQuery.post("index.php", postBody,
		function (data, textStatus)
		{
					if(data == '[]')
						jQuery('#categorys_tree').html('');
					else{
						var zNodes = eval(data);
						jQuery.fn.zTree.init(jQuery("#categorys_tree"), setting,zNodes);
//						var zTree = jQuery.fn.zTree.getZTreeObj("categorys_tree");
//						zTree.expandAll(false);
					}

		});
}

function loadCategoryTree(){
	var setting = {
			edit: {
				enable: true,
				showRemoveBtn: true,
				showRenameBtn: true,
				drag: {
					autoExpandTrigger: false,
					isMove : true,
					inner: true,
					prev : false,
					next: false
				}
			},
			data: {
				key: {
					title:"t"
				},
				simpleData: {
					enable: true,
					pIdKey : "pId",
					idKey: "id",
					rootPId: 0
				}
			},
			view:{
				selectedMulti: false
			},
			callback: {
				onClick: cmsCategoryTreeClick,
				beforeDrag: beforeDrag,
				beforeDrop: beforeDrop
			}
		};
    var postBody = "module=Mall_Categorys&action=LoadCategoryTree";
	    jQuery.post("index.php", postBody,
		function (data, textStatus)
		{
					if(data == '[]')
						jQuery('#categorys_tree').html('');
					else{
						var zNodes = eval(data);
						jQuery.fn.zTree.init(jQuery("#categorys_tree"), setting,zNodes);
						var zTree = jQuery.fn.zTree.getZTreeObj("categorys_tree");
						zTree.expandAll(false);
					}
		});
}

function beforeDrag(treeId, treeNodes) {
	for (var i=0,l=treeNodes.length; i<l; i++) {
		if (treeNodes[i].pId === 0) {
			return false;
		}
	}
	return true;
}

function beforeDrop(treeId, treeNodes, targetNode, moveType) {
	if( targetNode == null ) return false;
	moveCategory(treeNodes[0].id,targetNode.id);
}
function addDiyDom(treeId, treeNode) {

	var span = "";
	addStr = "<span><span id='"+treeNode.tId + "_bt_span'><span id='"+treeNode.tId + "_nbsp_span'></span></span><span>"+span+"</span></span>";
	var sObj = jQuery("#"+treeNode.tId + "_a");
	sObj.append(addStr);


};

function addHoverDom(treeId, treeNode) {
	jQuery("#"+treeNode.tId+"_nbsp_span").unbind().remove();
	var sObj = jQuery("#"+treeNode.tId + "_bt_span");

	if (jQuery("#addBtn_"+treeNode.id).length > 0) return;
	var addStr = "<button type='button' class='add' id='addBtn_" + treeNode.id
		+ "' title='"+hint_arr.LBL_NEW_BUTTON_LABEL+"' onfocus='this.blur();'></button>";
	sObj.append(addStr);
	var btn = jQuery("#addBtn_"+treeNode.id);
	if (btn) btn.bind("click", function(){
		var zTree = jQuery.fn.zTree.getZTreeObj("categorys_tree");
		zTree.selectNode(treeNode);
		zTree.expandNode(treeNode, true, false, false);
		addCategory(this,treeNode.id,hint_arr.LBL_NEW_BUTTON_LABEL);
		return false;
	});

	if (jQuery("#editBtn_"+treeNode.id).length > 0) return;
	addStr = "<button type='button' class='edit' id='editBtn_" + treeNode.id
		+ "' title='"+hint_arr.LBL_EDIT_BUTTON_LABEL+"' onfocus='this.blur();'></button>";
	sObj.append(addStr);
	btn = jQuery("#editBtn_"+treeNode.id);
	if (btn) btn.bind("click", function(){
		var zTree = jQuery.fn.zTree.getZTreeObj("categorys_tree");
		zTree.selectNode(treeNode);
		editCategory(this,treeNode.id,hint_arr.LBL_CURRENT_NODE+':&nbsp;'+treeNode.name);
		return false;
	});

	if (jQuery("#removeBtn_"+treeNode.id).length > 0) return;
	addStr = "<button type='button' class='remove' id='removeBtn_" + treeNode.id
		+ "' title='"+hint_arr.LBL_DELETE_BUTTON_LABEL+"' onfocus='this.blur();'></button>";
	sObj.append(addStr);
	btn = jQuery("#removeBtn_"+treeNode.id);
	if (btn) btn.bind("click", function(){
		deleteCategory(this,treeNode.id,treeNode.name);
		return false;
	});




};
function removeHoverDom(treeId, treeNode) {
	jQuery("#addBtn_"+treeNode.id).unbind().remove();
	jQuery("#editBtn_"+treeNode.id).unbind().remove();
	jQuery("#removeBtn_"+treeNode.id).unbind().remove();
	addStr = "<span id='"+treeNode.tId + "_nbsp_span'></span>";
	var sObj = jQuery("#"+treeNode.tId + "_bt_span");
	sObj.append(addStr);
};

function zTreeOnAsyncSuccess(event, treeId, treeNode, msg) {
	if(treeNode == undefined && msg == '[]')
		$('categorys_tree').innerHTML = '<a style="cursor:pointer;" onclick="addCategory(this,\'root\',\''+hint_arr.LBL_NEW_BUTTON_LABEL+'\')"><img border="0" align="absmiddle" style="width:18px;height:18px;" src="images/btnadd.gif">&nbsp;'+hint_arr.LBL_NEW_BUTTON_LABEL+'</a>';
	else if(treeNode == undefined) {
		var zTree = jQuery.fn.zTree.getZTreeObj("categorys_tree");
		var nodes = zTree.getNodes();
		for(var i=0;i<nodes.length;i++){
			if(nodes[i].isParent && !nodes[i].open)
				zTree.expandNode(nodes[i], false, false, false);
		}
	}
}

function cmsCategoryTreeClick(event, treeId, treeNode){
//	var ajaxurl = 'index.php?module=Categorys&action=EditView&record='+treeNode.id;
//	jQuery("#Category_info_form_div").loadUrl(ajaxurl);
}


function selectCategoryOnAsyncSuccess(event, treeId, treeNode, msg) {
	if(treeNode == undefined && msg != '[]') {
		var zTree = jQuery.fn.zTree.getZTreeObj("select_categorys_tree");
		var nodes = zTree.getNodes();
		for(var i=0;i<nodes.length;i++){
			if(nodes[i].isParent && !nodes[i].open)
				zTree.expandNode(nodes[i], true, false, false);
		}
	}
}

function CustomCategoryManager_removeHoverDom(treeId, treeNode){
	jQuery("#addBtn_"+treeNode.id).unbind().remove();
	jQuery("#editBtn_"+treeNode.id).unbind().remove();
	jQuery("#removeBtn_"+treeNode.id).unbind().remove();
}

function CustomCategoryManager_addHoverDom(treeId, treeNode){
	if (treeNode.iscustom){
		var sObj = jQuery("#" + treeNode.tId + "_a");
		if ($("#addBtn_" + treeNode.id).length > 0) return;
		sObj.append('<span class="tree_add" style="vertical-align:top;" id="addBtn_' + treeNode.id + '" title="增加一个新的分类信息"></span>')
		$("#addBtn_" + treeNode.id).bind("click", function ()
		{
			var ajaxurl = "index.php?module=Mall_Categorys&action=CustomCategorys&opertype=add&parenttab=Micro Mall&parent=" + treeNode.id;
			$(this).dialog({id: "CategoryManagerDialog",height:"320", url: ajaxurl, title: "新建分类", mask: true, resizable: false, maxable: false});
		});
		if(treeNode.value != "root")
		{
			if ($("#editBtn_" + treeNode.id).length > 0) return;
			sObj.append('<span class="tree_edit" style="vertical-align:top;" id="editBtn_' + treeNode.id + '" title="编辑当前分类信息"></span>')
			$("#editBtn_" + treeNode.id).bind("click", function ()
			{
				var ajaxurl = "index.php?module=Mall_Categorys&action=CustomCategorys&opertype=edit&parenttab=Micro Mall&record=" + treeNode.value;
				$(this).dialog({
					id: "CategoryManagerDialog",
					url: ajaxurl,
					title: "编辑分类：" + treeNode.nodename,
					height:"320",
					mask: true,
					resizable: false,
					maxable: false
				});
			});

			if ($("#removeBtn_" + treeNode.id).length > 0) return;
			sObj.append('<span class="tree_del" style="vertical-align:top;" id="removeBtn_' + treeNode.id + '" title="删除当前分类信息"></span>')
			$("#removeBtn_" + treeNode.id).bind("click", function ()
			{
				var ajaxurl = "index.php?module=Mall_Categorys&action=CustomCategorys&opertype=del&parenttab=Micro Mall&record=" + treeNode.value;
				$(this).alertmsg("confirm","确定要删除分类："+treeNode.nodename+' 吗?',{okCall:function(){
					$(this).bjuiajax("doAjax",{url:ajaxurl, loadingmask:true});
				}});
			});
		}
	}
}
function CategoryManager_removeHoverDom(treeId, treeNode){
	jQuery("#addBtn_"+treeNode.id).unbind().remove();
	jQuery("#editBtn_"+treeNode.id).unbind().remove();
	jQuery("#removeBtn_"+treeNode.id).unbind().remove();
}

function CategoryManager_addHoverDom(treeId, treeNode){
	if (!treeNode.iscustom)
	{
		var sObj = jQuery("#" + treeNode.tId + "_a");
		if ($("#addBtn_" + treeNode.id).length > 0) return;
		sObj.append('<span class="tree_add" style="vertical-align:top;" id="addBtn_' + treeNode.id + '" title="增加一个新的分类信息"></span>')
		$("#addBtn_" + treeNode.id).bind("click", function ()
		{
			var ajaxurl = "index.php?module=Mall_Categorys&action=EditView&opertype=add&parenttab=Micro Mall&parent=" + treeNode.value;
			$(this).dialog({id: "CategoryManagerDialog",height:"320", url: ajaxurl, title: "新建分类", mask: true, resizable: false, maxable: false});
		});

		if (treeNode.value != "root")
		{
			if ($("#editBtn_" + treeNode.id).length > 0) return;
			sObj.append('<span class="tree_edit" style="vertical-align:top;" id="editBtn_' + treeNode.id + '" title="编辑当前分类信息"></span>')
			$("#editBtn_" + treeNode.id).bind("click", function ()
			{
				var ajaxurl = "index.php?module=Mall_Categorys&action=EditView&opertype=edit&parenttab=Micro Mall&record=" + treeNode.value;
				$(this).dialog({
					id: "CategoryManagerDialog",
					url: ajaxurl,
					title: "编辑分类：" + treeNode.nodename,
					height:"320",
					mask: true,
					resizable: false,
					maxable: false
				});
			});

			if ($("#removeBtn_" + treeNode.id).length > 0) return;
			sObj.append('<span class="tree_del" style="vertical-align:top;" id="removeBtn_' + treeNode.id + '" title="删除当前分类信息"></span>')
			$("#removeBtn_" + treeNode.id).bind("click", function ()
			{
				var ajaxurl = "index.php?module=Mall_Categorys&action=EditView&opertype=del&parenttab=Micro Mall&record=" + treeNode.value;
				$(this).dialog({
					id: "CategoryManagerDialog",
					url: ajaxurl,
					title: "删除分类：" + treeNode.nodename,
					mask: true,
					resizable: false,
					maxable: false,
					height: 180
				});
			});
		}
	}
}

function CategoryManager_beforeDrop(treeId, treeNodes, targetNode, moveType, isCopy) {
	if( targetNode == null) {
		return false;
	}
	if(treeNodes[0].iscustom){
		return false;
	}
}

function CategoryManager_onDrop(event, treeId, treeNodes, targetNode, moveType, isCopy){
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
	var ajaxurl = "index.php?module=Mall_Categorys&action=EditView&opertype=move&movetype="+(moveType?moveType:"")+"&parenttab=Micro Mall&record="+nodes+"&parent=";
	if (targetNode) {
		ajaxurl += targetNode.value
	}
	$(this).bjuiajax("doAjax", {url:ajaxurl,loadingmask:true});
}


function CategoryManager_OnBeforeExpand(treeId, treeNode)
{
	var curExpandNode = CategoryManager_GetOpendNode(treeId);
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
		CategoryManager_singlePath(treeId, treeNode, curExpandNode);
	}
}

function CategoryManager_singlePath(treeId, newNode, oldNode)
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

function CategoryManager_GetOpendNode(treeId)
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

function CategoryManager_onClick(event, treeId, treeNode)
{
	event.preventDefault()

	if (treeNode.isParent)
	{
		var zTree = $.fn.zTree.getZTreeObj(treeId)

		zTree.expandNode(treeNode, !treeNode.open, false, true, true)
		return
	}
}

function CategoryManager_onNodeCreated(event, treeId, treeNode){

}
function CategoryManager_CollapseTreeNode(event, treeId, treeNode){

}
function CategoryManager_ExpandTreeNode(event, treeId, treeNode){

}
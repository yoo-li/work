/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/



function wxtype_onchange() 
{
		var wxroletype = $('input[name=wxtype]:checked').val();
		if (wxroletype == "1")
		{
			jQuery('#cid_welcometitle').css("display","none");
			jQuery('#cid_image').css("display","none"); 
			
		}
		else
		{
			jQuery('#cid_welcometitle').css("display","");
			jQuery('#cid_image').css("display",""); 
		}
	 	

	 	
}
 
	
	if (jQuery('#wxtype_1').length > 0)
	{
	    var wxroletype = $('input[id="wxtype_1"]:checked').val();
		jQuery("[name=wxtype]").attr("onchange","wxtype_onchange();");
		jQuery("#wxtype_1").change(wxtype_onchange); 
		jQuery("#wxtype_2").change(wxtype_onchange);
		wxtype_onchange();
	}
	
 




var	hint_arr={
		       LBL_CATEGORY_NAME_EMPTY:"部门名称不能为空",
		       MISSING_CATEGORY_NOT_EMPTY:"{$MOD.MISSING_CATEGORY_NOT_EMPTY}",
		       MISSING_CATEGORY_MOVE_NODE:"{$MOD.MISSING_CATEGORY_MOVE_NODE}",
		       MISSING_CATEGORY_MOVE_NOT_CHILD:"{$MOD.MISSING_CATEGORY_MOVE_NOT_CHILD}",
		       LBL_SAVE_BUTTON_LABEL:"保存",
		       LBL_CANCEL_BUTTON_LABEL:"取消",
		       LBL_DELETE_TREEID:"{$MOD.LBL_DELETE_TREEID}",		      
		       LBL_CURRENT_NODE:"{$MOD.LBL_CURRENT_NODE}",
		       LBL_NEW_BUTTON_LABEL:"新建",
		       LBL_EDIT_BUTTON_LABEL:"编辑",
		       LBL_DELETE_BUTTON_LABEL:"删除"
		};

var status_wxid = "";

function loadwxmenus(wxid){
	status_wxid = wxid;
	var setting = {
			edit: {
				enable: false,
				showRemoveBtn: false,
				showRenameBtn: false,
				drag: {
					autoExpandTrigger: false,
					isMove : false,
					inner: false,
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
				onClick: wxmenusCatalogTreeClick,
			}
		};
    var postBody = "module=Supplier_WxSettings&action=LoadMenus&wxid="+wxid;
	    jQuery.post("index.php", postBody,
		function (data, textStatus)
		{
					if(data == '[]')
						jQuery('#wxmenus_div').html('');
					else{
						var zNodes = eval(data);
						jQuery.fn.zTree.init(jQuery("#wxmenus_div"), setting,zNodes);
					}	

		});	
}




function wxmenusCatalogTreeClick(event, treeId, treeNode){
    
}

function addDiyDom(treeId, treeNode) {
	var span = "";
	if (treeNode.type == "view")
	{
		span += "【链接地址："; 
		span += "<span>"+treeNode.key+"</span>";
		span += "】</font>";
	}
	else
	{
		span += "【关键字："; 
		span += "<span>"+treeNode.key+"</span>";
		span += "】";
	}
	addStr = "<span><span id='"+treeNode.tId + "_bt_span'><span id='"+treeNode.tId + "_nbsp_span'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span><span>"+span+"</span></span>";
	var sObj = jQuery("#"+treeNode.tId + "_a");  
	sObj.append(addStr);
	
	addStr = "<span><span id='"+treeNode.tId + "_bt_span'><span id='"+treeNode.tId + "_nbsp_span'></span></span></span>";
	var sObj = jQuery("#"+treeNode.tId + "_a");	
	sObj.append(addStr);


};

function addHoverDom(treeId, treeNode) {
	jQuery("#"+treeNode.tId+"_nbsp_span").unbind().remove();
	var sObj = jQuery("#"+treeNode.tId + "_bt_span");
	if (treeNode.pId == "0")
	{	
		if (jQuery("#addBtn_"+treeNode.id).length > 0) return;
		var addStr = "<button type='button' class='add' id='addBtn_" + treeNode.id
			+ "' title='"+hint_arr.LBL_NEW_BUTTON_LABEL+"' onfocus='this.blur();'></button>";
		sObj.append(addStr);
		var btn = jQuery("#addBtn_"+treeNode.id);
		if (btn) btn.bind("click", function(){
			var zTree = jQuery.fn.zTree.getZTreeObj("wxmenus_div");
			zTree.selectNode(treeNode);
			zTree.expandNode(treeNode, true, false, false);
			wxmenusaddCatalog(this,treeNode.id,hint_arr.LBL_NEW_BUTTON_LABEL);
		});
	}

	if (jQuery("#editBtn_"+treeNode.id).length > 0) return;
	addStr = "<button type='button' class='edit' id='editBtn_" + treeNode.id
		+ "' title='"+hint_arr.LBL_EDIT_BUTTON_LABEL+"' onfocus='this.blur();'></button>";
	sObj.append(addStr);
	btn = jQuery("#editBtn_"+treeNode.id);
	if (btn) btn.bind("click", function(){
		var zTree = jQuery.fn.zTree.getZTreeObj("wxmenus_div");
		zTree.selectNode(treeNode);
		wxmenuseditCatalog(this,treeNode.id,hint_arr.LBL_CURRENT_NODE+':&nbsp;'+treeNode.name);
	});

	if (jQuery("#removeBtn_"+treeNode.id).length > 0) return;
	addStr = "<button type='button' class='remove' id='removeBtn_" + treeNode.id
		+ "' title='"+hint_arr.LBL_DELETE_BUTTON_LABEL+"' onfocus='this.blur();'></button>";
	sObj.append(addStr);
	btn = jQuery("#removeBtn_"+treeNode.id);
	if (btn) btn.bind("click", function(){
		wxmenusdeleteCatalog(this,treeNode.id,treeNode.name);
	});

	
	

};
function removeHoverDom(treeId, treeNode) {
	jQuery("#addBtn_"+treeNode.id).unbind().remove();
	jQuery("#editBtn_"+treeNode.id).unbind().remove();
	jQuery("#removeBtn_"+treeNode.id).unbind().remove();
	addStr = "<span id='"+treeNode.tId + "_nbsp_span'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>";
	var sObj = jQuery("#"+treeNode.tId + "_bt_span");
	sObj.append(addStr);
};

function addHoverDom1(treeId, treeNode) {
	jQuery("#"+treeNode.tId+"_nbsp_span").unbind().remove();
	var sObj = jQuery("#"+treeNode.tId + "_bt_span");

	if (treeNode.pId == "0")
	{	
		if (jQuery("#addBtn_"+treeNode.id).length > 0) return;
		var addStr = "<button type='button' class='add' id='addBtn_" + treeNode.id
			+ "' title='"+hint_arr.LBL_NEW_BUTTON_LABEL+"' onfocus='this.blur();'></button>";
		sObj.append(addStr);
		var btn = jQuery("#addBtn_"+treeNode.id);
		if (btn) btn.bind("click", function(){
			var zTree = jQuery.fn.zTree.getZTreeObj("wxmenus_catalog_tree");
			zTree.selectNode(treeNode);
			zTree.expandNode(treeNode, true, false, false);
			wxmenusaddCatalog(this,treeNode.id,hint_arr.LBL_NEW_BUTTON_LABEL);
		});
	}
	else
	{
		if (jQuery("#editBtn_"+treeNode.id).length > 0) return;
		addStr = "<button type='button' class='edit' id='editBtn_" + treeNode.id
			+ "' title='"+hint_arr.LBL_EDIT_BUTTON_LABEL+"' onfocus='this.blur();'></button>";
		sObj.append(addStr);
		btn = jQuery("#editBtn_"+treeNode.id);
		if (btn) btn.bind("click", function(){
			var zTree = jQuery.fn.zTree.getZTreeObj("wxmenus_catalog_tree");
			zTree.selectNode(treeNode);
			wxmenuseditCatalog(this,treeNode.id,hint_arr.LBL_CURRENT_NODE+':&nbsp;'+treeNode.name);
		});

		if (jQuery("#removeBtn_"+treeNode.id).length > 0) return;
		addStr = "<button type='button' class='remove' id='removeBtn_" + treeNode.id
			+ "' title='"+hint_arr.LBL_DELETE_BUTTON_LABEL+"' onfocus='this.blur();'></button>";
		sObj.append(addStr);
		btn = jQuery("#removeBtn_"+treeNode.id);
		if (btn) btn.bind("click", function(){
			wxmenusdeleteCatalog(this,treeNode.id,treeNode.name);
		});
	}

	

};



function wxmenusaddCatalog(obj,cp,label){
	var ajaxurl = 'index.php?module=WxSettings&action=WxMenuItem&parentid='+cp;	
	if(cp == 'root')
		ajaxurl += '&root=true';
	else if(cp!='new')
		ajaxurl += '&node='+cp;
	jQuery.pdialog.open(ajaxurl,"catalog","新建",{height:240,mask:true});
}

function wxmenuseditCatalog(obj,cp,label){
	var ajaxurl = 'index.php?module=WxSettings&action=WxMenuItem&record='+cp;	
	if(cp == 'root')
		ajaxurl += '&root=true';
	else if(cp!='new')
		ajaxurl += '&node='+cp;
	jQuery.pdialog.open(ajaxurl,"catalog","编辑",{height:240,mask:true});
}

function wxmenusdeleteCatalog(obj,cp,label){
   var ajaxurl = 'index.php?module=WxSettings&action=WxMenuItem&type=deleted&record='+cp;	
   $(this).alertmsg.confirm("您确定要删除当前菜单项？", {
   		okCall: function(){
   			$.post(ajaxurl,"",function(data){},"json");
			loadwxmenus(status_wxid);
   		}
   	});
   
}
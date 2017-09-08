<?php /* Smarty version 2.6.18, created on 2017-08-11 13:15:23
         compiled from Settings/ModuleFieldLayout.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'Settings/ModuleFieldLayout.tpl', 362, false),)), $this); ?>
<style>
<?php echo '
<!--
    .my-bjui-navtab { position:absolute;width:100%; left:0px;}
    .tabsPageHeaderMarginLeft{margin-left:20px;}
    .tabsPageHeaderMarginRight{margin-right:39px;}
	.tabcontainer td {line-height:30px;}
	.tabcontainer td i {font-size: 14px;}
	.btn-default { background-color: transparent; }
	 
	.fieldcol {
	    border-right: 1px solid #dddddd;
	    padding-left: 4px; 
	}
	.fieldcol div { 
		vertical-align : middle;
		line-height:30px;
		height:30px;
	}
	a.customMnuSelected {
	  background-color: #0099ff;
	  background-position: left center;
	  background-repeat: no-repeat;
	  color: #ffffff;
	  display: block;
	  padding-bottom: 5px;
	  padding-left: 30px;
	  padding-top: 5px;
	  text-decoration: none;
	  width: 155px;
	}
	a.customMnu {
	  background-position: left center;
	  background-repeat: no-repeat;
	  color: #000000;
	  display: block;
	  padding-bottom: 5px;
	  padding-left: 30px;
	  padding-top: 5px;
	  text-decoration: none;
	  width: 155px;
	}
	
	.tabcontainer
	{
		 
	}
	.tabsubmenu
	{							
		border-bottom:1px solid #bcb7a0;
		font-weight:bold;
		font-size: 12px;
	}
	.selecttabsubmenu
	{	 
		font-weight:bold;
		border-bottom:1px solid #bcb7a0;
		font-size: 13px;
	}
	.tabsubmenuOver
	{
		background-color: #FFFFCC;
	}
	.selectedtab
	{
		min-width:60px;
		padding-left:10px;
		padding-right:10px;
		 height:38px; 
		 line-height:38px;
		 background:#ffffff url(/images/tab.png) 0px 0px ;
		 font-weight:bold;
		 font-size: 14px;
	}
	.selected_tab
	{
		 width:10px; 
		 height:38px; 
		 line-height:38px;
		 background:#ffffff url(/images/tab.png) 0px 38px ; 
	}

	.unselectedtab
	{
		min-width:60px;
		padding-left:10px;
		padding-right:10px;
		height:38px; 
		line-height:38px;
		background:#ffffff url(/images/tab.png) 0px 76px;
		font-weight:bold;
		font-size: 14px;
	}
	.unselected_tab 
	{
		 width:10px; 
		 height:38px; 
		 line-height:38px;
		 background:#ffffff url(/images/tab.png) 0px 114px ; 
	}
	.selectedtab span,
	.unselectedtab span 
	{
		color:#267b9f;
		font-size:14px;
		font-weight:bold;
	}
    .selected,.selected:hover{
        background-color: #dfe5ed;
    }
     
-->	 
'; ?>

</style>
<script type='text/javascript' src="/Public/js/my_bjui_navtab.js"></script>
<script type='text/javascript'>
<?php echo '
	var prevBtn     = $(".my-bjui-navtab").find(\'.tabsLeft\')
	var nextBtn     = $(".my-bjui-navtab").find(\'.tabsRight\')
	var ul_contaimer= $(".my-bjui-navtab").find(".tabsPageHeaderContent")
	var maxIndex    = $(".my-bjui-navtab").find("ul.navtab-tab>li").length
	var iW=0;//所有选显卡的宽度之和
	$(".my-bjui-navtab").find("ul.navtab-tab>li").each(function() {
	    iW += $(this).outerWidth(true)
	}) 
 
function ParentTabClick(tab,index,max){
	jQuery("#picklistpanel").css(\'display\',\'none\');
	for(var i=1;i<=max;i++){
		if(i == index){
			jQuery(\'.parenttabs_\'+i).addClass("selected");
		}else{
			jQuery(\'.parenttabs_\'+i).removeClass("selected");
		}
	}
	var postBody = "index.php?module=Settings&action=ModuleFieldLayout&operatingtype=selectparenttabs&tabs="+encodeURIComponent(tab);
	jQuery("#subtabs").loadUrl(postBody);
}

function selectTabClick(tab,index,max){
	for(var i=1;i<=max;i++){
		if(i == index){
			jQuery("#img_select_"+i).css(\'display\',\'block\');
			jQuery(\'#tabs_select_\'+i).addClass("selecttabsubmenu");
		}else{
			jQuery("#img_select_"+i).css(\'display\',\'none\');
			jQuery(\'#tabs_select_\'+i).removeClass("selecttabsubmenu");
		}
	}
	var postBody = "index.php?module=Settings&action=ModuleFieldLayout&operatingtype=selecttabs&tabs="+encodeURIComponent(tab);
	$(this).bjuiajax("doLoad", {url:postBody, target:"#picklistEntries",loadingmask:false});
}

function ModfiyFieldInfo(fid,flabel){
	var url = "index.php?module=Settings&action=ModuleFieldLayout&operatingtype=modifyfieldinfo&record="+fid;
	$(this).dialog({id:\'modifyfieldinfo\', url:url, title:flabel+"字段属性",width:420,height:290,mask:true,maxable:false});
}

function showhiddenfields(bid,module){
	var url = "index.php?module=Settings&action=ModuleFieldLayout&operatingtype=showhiddenfields&blockid="+bid+"&tabs="+encodeURIComponent(module);
	$(this).dialog({id:\'modifyfieldinfo\', url:url, title:"隐藏字段",width:280,height:300,mask:true,maxable:false});
}

function validateHiddenfields(){
	 var selectedfields = document.getElementById(\'hiddenfields\');
	 var selectedids_str = \'\';
	 for(var i=0; i<selectedfields.length; i++) {
		if (selectedfields[i].selected == true) {
			selectedids_str = selectedids_str + selectedfields[i].value + ";";
		}
	 }
	 jQuery("#hiddenfields_select").val(selectedids_str);
}

function RefreshBlockInfo(params){
	BJUI.dialog("closeCurrent");
	var black = "#" + params.module + "_block_" + params.blockid;
	var postBody = "index.php?module=Settings&action=ModuleFieldLayout&operatingtype=refreshblockinfo&tabs="+encodeURIComponent(params.module)+"&blockid=" + params.blockid;
	jQuery(black).loadUrl(postBody);
}

function addnewfieldinfo(bid,module){
	var url = "index.php?module=Settings&action=ModuleFieldLayout&operatingtype=addnewfieldinfo&blockid="+bid+"&tabs="+encodeURIComponent(module);
	$(this).dialog({id:\'modifyfieldinfo\', url:url, title:"增加自定义字段",width:680,height:340,mask:true,maxable:false});
}

var gselected_fieldtype = \'\';
var fieldValueArr=new Array(\'Line\',\'Text\',\'Number\',\'Percent\',\'Currency\',\'Date\',\'Email\',\'Phone\',\'Picklist\',\'URL\',\'Checkbox\',\'TextArea\',\'MultiSelectCombo\',\'Skype\');
var fieldTypeArr=new Array(\'line\',\'text\',\'number\',\'percent\',\'currency\',\'date\',\'email\',\'phone\',\'picklist\',\'url\',\'checkbox\',\'textarea\',\'multiselectcombo\',\'skype\');
function makeFieldSelected(oField,fieldid,blockid)
{
	if(gselected_fieldtype != \'\')
	{
		jQuery(gselected_fieldtype).attr(\'class\',\'customMnu\');
	}
	oField.className = \'customMnuSelected\';	
	gselected_fieldtype = \'#\'+oField.id;
	changeFieldType(fieldid,blockid);
}

function changeFieldType(fieldid,blockid){
    currFieldIdx=fieldid
    var type=fieldTypeArr[currFieldIdx]
    if (type==\'line\'){
        jQuery("#fldLabel").removeClass("required");
		jQuery("#fldLabel").attr("data-rule",""); 
        jQuery("#fldmandatory").attr("disabled",true);
        jQuery("#fldmerge_column").attr("disabled",true);
        jQuery("#fldmerge_column").attr("checked",true);
    }else{
    	jQuery("#fldLabel").addClass("required");
		jQuery("#fldLabel").attr("data-rule","required"); 
        jQuery("#fldmandatory").removeAttr("disabled");
        jQuery("#fldmerge_column").removeAttr("disabled");
        jQuery("#fldmerge_column").removeAttr("checked");
    }
    var pickListLayer=document.getElementById("picklistdetails_"+blockid);
    if (type==\'picklist\' || type==\'multiselectcombo\') {
        pickListLayer.style.visibility="visible"
    }else{
    	pickListLayer.style.visibility="hidden"
    }
	jQuery("#selectedfieldtype").val(fieldValueArr[currFieldIdx]);
}

function deleteCustomField(fid,fla,module,blockid){
	
 $(this).alertmsg(\'confirm\', "删除自定义字段："+fla+"将不可逆,<br>　　您是否确定需要删除？", {displayMode:\'slide\', displayPosition:\'middlecenter\', okName:\'确定删除\', cancelName:\'取消\', title:\'删除提示\',okCall: function(){
 		var postBody = "operatingtype=fieldinfodelete&record="+fid+"&tabs="+encodeURIComponent(module)+"&blockid=" + blockid;
		jQuery.post("index.php?module=Settings&action=ModuleFieldLayout", postBody,
				function (data, textStatus){
			       var params = eval(\'(\'+data+\')\');
			       RefreshBlockInfo(params);
			    });
	}}); 
}

function mergecolumnboxclick(obj,canDeputy){
	jQuery(\'#newrow_column\').attr(\'disabled\',obj.checked);
	if(canDeputy)
		   jQuery(\'#deputy_column\').attr(\'disabled\',obj.checked);
}

function newrowcolumnboxclick(obj,canDeputy){
	jQuery(\'#merge_column\').attr(\'disabled\',obj.checked);
	if(canDeputy)
		   jQuery(\'#deputy_column\').attr(\'disabled\',obj.checked);
}

function deputycolumnboxclick(obj){
	jQuery(\'#newrow_column\').attr(\'disabled\',obj.checked);
	jQuery(\'#merge_column\').attr(\'disabled\',obj.checked);
}

function blockmoveupdown(module,blockid,movetype){
	var postBody = "operatingtype=blockmoveupdown&tabs="+encodeURIComponent(module)+"&blockid=" + blockid+"&movetype="+encodeURIComponent(movetype);
	jQuery.post("index.php?module=Settings&action=ModuleFieldLayout", postBody,
			function (data, textStatus){
		       var params = eval(\'(\'+data+\')\');
		       var rmodule = params.module;
		       var block1 = params.blocks.block1;
		       var block2 = params.blocks.block2;
		       if(block1 > \'0\' && block2 > \'0\'){
		    	   var black1 = "#" + rmodule + "_block_" + block1;
		    	   var black2 = "#" + rmodule + "_block_" + block2;
		    	   var postBody1 = "index.php?module=Settings&action=ModuleFieldLayout&operatingtype=refreshblockinfo&tabs="+encodeURIComponent(rmodule)+"&blockid=" + block2;
		    	   var postBody2 = "index.php?module=Settings&action=ModuleFieldLayout&operatingtype=refreshblockinfo&tabs="+encodeURIComponent(rmodule)+"&blockid=" + block1;
		    	   var blackdiv1 = document.getElementById(rmodule + "_block_" + block1);
		    	   var blackdiv2 = document.getElementById(rmodule + "_block_" + block2);
		    	   jQuery(black1).loadUrl(postBody1);
		    	   jQuery(black2).loadUrl(postBody2);
		    	   blackdiv2.id = rmodule + "_block_" + block1;
		    	   blackdiv1.id = rmodule + "_block_" + block2;
		    	}
		    });
}

function fieldmoveleftright(module,blockid,fieldid,deputyids,movetype){
	var postBody = "operatingtype=fieldmoveleftright&tabs="+encodeURIComponent(module)+"&blockid=" + blockid+"&movetype="+encodeURIComponent(movetype)+"&record="+fieldid+"&deputyids="+encodeURIComponent(deputyids);
	jQuery.post("index.php?module=Settings&action=ModuleFieldLayout", postBody,
		    function (data, textStatus){
		       var params = eval(\'(\'+data+\')\');
		   	   var black = "#" + params.module + "_block_" + params.blockid;
			   var postBody = "index.php?module=Settings&action=ModuleFieldLayout&operatingtype=refreshblockinfo&tabs="+encodeURIComponent(params.module)+"&blockid=" + params.blockid;
			   jQuery(black).loadUrl(postBody);
		    });
}

function fieldmoveupdown(module,blockid,b_columns,fieldid,f_columns,deputyids,movetype){
	var postBody = "operatingtype=fieldmoveupdown&tabs="+encodeURIComponent(module)+"&blockid=" + blockid+"&movetype="+encodeURIComponent(movetype)+"&record="+fieldid+"&deputyids="+encodeURIComponent(deputyids)+"&b_columns="+b_columns+"&f_columns="+f_columns;
	jQuery.post("index.php?module=Settings&action=ModuleFieldLayout", postBody,
		    function (data, textStatus){
		       var params = eval(\'(\'+data+\')\');
		   	   var black = "#" + params.module + "_block_" + params.blockid;
			   var postBody = "index.php?module=Settings&action=ModuleFieldLayout&operatingtype=refreshblockinfo&tabs="+encodeURIComponent(params.module)+"&blockid=" + params.blockid;
			   jQuery(black).loadUrl(postBody);
		    });
}

function showblockinfo(blockid,module){
	var url = "index.php?module=Settings&action=ModuleFieldLayout&operatingtype=showblockinfo&blockid="+blockid+"&tabs="+encodeURIComponent(module);
	$(this).dialog({id:\'addnewblockinfo\', url:url, title:"增加自定义区块",width:450,height:200,mask:true,maxable:false});
}
function addnewblockinfo(blockid,module){
	var url = "index.php?module=Settings&action=ModuleFieldLayout&operatingtype=addnewblockinfo&blockid="+blockid+"&tabs="+encodeURIComponent(module)
	$(this).dialog({id:\'showblockinfo\', url:url, title:"区块信息",width:450,height:200,mask:true,maxable:false});
}

function RefreshTabsInfo(params){
	jQuery.pdialog.closeCurrent();
	var postBody = "index.php?module=Settings&action=ModuleFieldLayout&operatingtype=selecttabs&tabs="+encodeURIComponent(params.module);
	jQuery("#picklistEntries").loadUrl(postBody);
}

function deleteblockinfo(blockid,module,bla){ 
    $(this).alertmsg(\'confirm\', "删除自定义区块："+bla+"将不可逆,区块中的字段将自动上移<br>　　您是否确定需要删除？", {displayMode:\'slide\', displayPosition:\'middlecenter\', okName:\'确定删除\', cancelName:\'取消\', title:\'删除提示\',okCall: function(){
    	var postBody = "operatingtype=deleteblockinfo&tabs="+encodeURIComponent(module)+"&blockid=" + blockid;
   		jQuery.post("index.php?module=Settings&action=ModuleFieldLayout", postBody,
   				function (data, textStatus){ 
   			        var params = eval(\'(\'+data+\')\');  
				   	var postBody = "index.php?module=Settings&action=ModuleFieldLayout&operatingtype=selecttabs&tabs="+encodeURIComponent(params.module);
					$(this).bjuiajax("doLoad", {url:postBody, target:"#picklistEntries",loadingmask:false});
   			    });
   	}});  
}

function changeblockShowstatus(blockid,module,isshow){
	var postBody = "operatingtype=showhideblock&tabs="+encodeURIComponent(module)+"&blockid=" + blockid+"&showhide="+isshow;
	jQuery.post("index.php?module=Settings&action=ModuleFieldLayout", postBody,
			function (data, textStatus){
		       var params = eval(\'(\'+data+\')\');
		       RefreshBlockInfo(params);
		    });
}
 
$(document).ready(function(){	 
     var iContentH = $(window).height();  
	 $("#subtabs").height(iContentH - 153);
	 $("#picklistEntries").height(iContentH - 170);
	 $(window).on(\'bjui.resizeGrid\', function() { 
	    var iContentH = $(window).height();  
	  	$("#subtabs").height(iContentH - 153);
	  	$("#picklistEntries").height(iContentH - 170); 
	 }); 
});



'; ?>

</script> 

<div class="pageFormContent">
    <div id="bjui-navtab" class="my-bjui-navtab tabsPage" style="left:0px;">
        <div class="tabsPageHeader">
            <div class="tabsPageHeaderContent">
                <ul class="navtab-tab nav nav-tabs">
                    <?php $_from = $this->_tpl_vars['HEADERS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['parenttabs'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['parenttabs']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['maintabs']):
        $this->_foreach['parenttabs']['iteration']++;
?>
                        <?php if ($this->_foreach['parenttabs']['iteration'] == '1'): ?>
                            <?php $this->assign('tabSelected', $this->_tpl_vars['maintabs']); ?>
                        <?php endif; ?>
                        <li align="center" nowrap <?php if ($this->_foreach['parenttabs']['iteration'] == 1): ?>class="active"<?php endif; ?>>
                            <a href="##" onclick="ParentTabClick('<?php echo $this->_tpl_vars['maintabs']; ?>
',<?php echo $this->_foreach['parenttabs']['iteration']; ?>
,<?php echo count($this->_tpl_vars['HEADERS']); ?>
);" title="模块菜单"><span><?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['maintabs']]; ?>
</span></a>
                        </li>
                    <?php endforeach; endif; unset($_from); ?> 
                </ul>
            </div>
            <div class="tabsLeft" style="display: none;" onclick="scrolltoleft()"><i class="fa fa-angle-double-left"></i></div>
            <div class="tabsRight" style="display: none;" onclick="scrolltoright()"><i class="fa fa-angle-double-right"></i></div>
            <div class="tabsMore" onclick='showMoreList()'><i class="fa fa-angle-double-down"></i></div>
        </div>
  
        <ul class="tabsMoreList" style="display: none;">
            <?php $_from = $this->_tpl_vars['HEADERS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['parenttabs'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['parenttabs']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['maintabs']):
        $this->_foreach['parenttabs']['iteration']++;
?>
                <li class="parenttabs_<?php echo $this->_foreach['parenttabs']['iteration']; ?>
" align="center" nowrap <?php if ($this->_foreach['parenttabs']['iteration'] == '1'): ?>class="active"<?php endif; ?>>
                    <a  href="##" onclick="ParentTabClick('<?php echo $this->_tpl_vars['maintabs']; ?>
',<?php echo $this->_foreach['parenttabs']['iteration']; ?>
,<?php echo count($this->_tpl_vars['HEADERS']); ?>
);" title="模块菜单"><span><?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['maintabs']]; ?>
</span></a>
                </li>
            <?php endforeach; endif; unset($_from); ?> 
        </ul>
        <script type="text/javascript">
            if("<?php echo $this->_tpl_vars['tabSelected']; ?>
" != "")
                ParentTabClick("<?php echo $this->_tpl_vars['tabSelected']; ?>
",1,<?php echo count($this->_tpl_vars['HEADERS']); ?>
);
        </script>
			
            <div class="navTab-panel tabsPageContent" style="padding:0px;">
                <div class="page unitBox">
                    <div class="pageFormContent" >
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="tabcontainer">
                            <tr>
                                <td width="100" valign="top">
                                    <div id="subtabs" class="pageContent" style="height:300px;overflow-y:scroll" ></div>
                                </td>
                                <td valign="top">
                                    <div style="border:1px solid #bcb7a0;margin: 10px;">
                                        <div id="picklistEntries" class="pageContent" style="background: none repeat scroll 0 0 #EEF4F5;height:300px;overflow-y:scroll;"  >
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
	 
    </div>
</div>
<div class="bjui-pageFooter">
    <ul>
        <li><button type="button" class="btn-close" data-icon="close">关闭</button></li> 
    </ul>
</div>
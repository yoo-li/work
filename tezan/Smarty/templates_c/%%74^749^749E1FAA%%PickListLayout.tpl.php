<?php /* Smarty version 2.6.18, created on 2017-08-11 13:15:31
         compiled from Settings/PickListLayout.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'Settings/PickListLayout.tpl', 183, false),)), $this); ?>
<style>
<?php echo '
<!--
    .my-bjui-navtab { position:absolute;width:100%; left:0px;}
    .tabsPageHeaderMarginLeft{margin-left:20px;}
    .tabsPageHeaderMarginRight{margin-right:39px;}
	.tabcontainer td {line-height:30px;}
	.tabcontainer td i {}
	.btn-default { background-color: transparent; }
	 
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
	var postBody = "index.php?module=Settings&action=PickListManage&operatingtype=selectparenttabs&tabs="+encodeURIComponent(tab);
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
	jQuery("#picklistpanel").css(\'display\',\'none\');
	var postBody = "index.php?module=Settings&action=PickListManage&operatingtype=selecttabs&tabs="+encodeURIComponent(tab);
	$(this).bjuiajax("doLoad", {url:postBody, target:"#tabpicklist",loadingmask:false});
}

function selectPicklist(obj){
	var postBody = "index.php?module=Settings&action=PickListManage&operatingtype=selectpicklist&picklist="+encodeURIComponent(obj);
	jQuery("#picklistEntries").loadUrl(postBody);
	jQuery("#picklistpanel").css(\'display\',\'block\');
}

function dialog_callback(obj){
	jQuery.pdialog.closeCurrent();
	selectPicklist(obj);
}

function ModfiyPicklist(record,picklist){
	var url = "index.php?module=Settings&action=PickListManage&operatingtype=modify&record="+record+"&picklist="+picklist;
	$(this).dialog({id:\'addnewpicklist\', url:url, title:\'修改选项\',width:420,height:250,mask:true,maxable:false});
}

function movePicklist(record,picklist,type){
	var postBody = "index.php?module=Settings&action=PickListManage&operatingtype="+encodeURIComponent(type)+"&record="+encodeURIComponent(record)+"&picklist="+encodeURIComponent(picklist);
	jQuery("#picklistEntries").loadUrl(postBody);	
}

function DeletePicklist(record,picklist){
	 $(this).alertmsg(\'confirm\', \'你确定需要删除当前选项吗？\', {displayMode:\'slide\', displayPosition:\'middlecenter\', okName:\'确定删除\', cancelName:\'取消\', title:\'删除提示\',okCall: function(){
			var postBody = "index.php?module=Settings&action=PickListManage&operatingtype=delete&record="+encodeURIComponent(record)+"&picklist="+encodeURIComponent(picklist);
			jQuery("#picklistEntries").loadUrl(postBody);	 
		}});
	 
}

function addNewPicklist(){
	var url = "index.php?module=Settings&action=PickListManage&operatingtype=add&picklist="+jQuery("#tabspicklist").val();
	$(this).dialog({id:\'addnewpicklist\', url:url, title:\'新建选项\',width:420,height:250,mask:true,maxable:false});
}


 
 
$(document).ready(function(){	 
     var iContentH = $(window).height();  
	 $("#subtabs").height(iContentH - 153);
	 $("#tabpicklist-container").height(iContentH - 170);
	 $(window).on(\'bjui.resizeGrid\', function() { 
	    var iContentH = $(window).height();  
	  	$("#subtabs").height(iContentH - 153);
	  	$("#tabpicklist-container").height(iContentH - 170); 
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
        <div  class="tab-content" style="padding:0px;">
            <div id="my-navtab-content">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="tabcontainer">
                    <tr>
                        <td width="100" valign="top">
                            <div id="subtabs" class="pageContent" layoutH="70" style="height:300px;overflow-y:scroll"></div>
                        </td>
                        <td valign="top">
                            <div id="tabpicklist-container" style="border:1px solid #bcb7a0;margin: 10px;overflow-y: scroll" >
                                <div id="tabpicklist" style="height:30px;line-height:30px;padding-left: 10px;background-color: #EFEFEF;">
                                </div>
                                <div id="picklistpanel" style="display:none;">
                                    
                                        <div class="panelBar" style="padding:5px;">
                                            <ul class="toolBar">
                                                <li>
													<a data-title="新建" onClick="addNewPicklist();" href="javascript:;" data-icon="plus" class="btn btn-default"> 新建选择项</a></li>
                                            </ul>
                                        </div> 
										
                                    <div id="picklistEntries" class="pageContent" style="background: none repeat scroll 0 0 #EEF4F5;" layoutH="147">
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="bjui-pageFooter">
    <ul>
        <li><button type="button" class="btn-close" data-icon="close">关闭</button></li> 
    </ul>
</div>
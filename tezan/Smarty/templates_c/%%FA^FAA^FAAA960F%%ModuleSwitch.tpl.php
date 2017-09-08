<?php /* Smarty version 2.6.18, created on 2017-08-11 13:15:17
         compiled from Settings/ModuleSwitch.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'Settings/ModuleSwitch.tpl', 102, false),)), $this); ?>
<style>
    <?php echo '
        .my-bjui-navtab { position:absolute;width:100%; left:0px;}
        .tabsPageHeaderMarginLeft{margin-left:20px;}
        .tabsPageHeaderMarginRight{margin-right:39px;}
		.tabcontainer td {line-height:30px;}
		.tabcontainer td i {}
		 
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
    function vtlib_toggleModule(module, enable_disable, type,formodule) {
        if(typeof(formodule) == \'undefined\') formodule = \'\';
        if(typeof(type) == \'undefined\') type = \'\';
        var postBody = "index.php?module=Settings&action=ModuleSwitch&module_name=" + encodeURIComponent(module) + "&enable_disable=" + enable_disable  + "&type=" + type + "&formodule="+formodule;
        //jQuery("#my-navtab-content").loadUrl(postBody);
		 $(this).bjuiajax("doLoad", {url:postBody, target:"#my-navtab-content",loadingmask:true});
    }

    '; ?>

</script>


<div class="pageFormContent">
    <div id="bjui-navtab" class="my-bjui-navtab tabsPage" style="left:0px;">
        <div class="tabsPageHeader">
            <div class="tabsPageHeaderContent">
                <ul class="navtab-tab nav nav-tabs">
				<?php $this->assign('modulelabel', $this->_tpl_vars['APP'][$this->_tpl_vars['FORMMODULE']]); ?>
                <?php $_from = $this->_tpl_vars['HEADERS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['tabname'] => $this->_tpl_vars['tablabel']):
?> 
                    <?php if ($this->_tpl_vars['APP'][$this->_tpl_vars['tablabel']] != ''): ?>
                    <?php if ($this->_tpl_vars['APP'][$this->_tpl_vars['tablabel']] == $this->_tpl_vars['modulelabel']): ?>
                        <li id="<?php echo $this->_tpl_vars['tabname']; ?>
" data-url="" class="active">
                            <a href="index.php?module=Settings&action=ModuleSwitch&formodule=<?php echo $this->_tpl_vars['tabname']; ?>
" role="tab" data-toggle="ajaxtab" data-target="#my-navtab-content" data-reload="true">
                                <span><?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['tablabel']]; ?>
</span>
                            </a>
                        </li>
                    <?php else: ?>
                        <li id="<?php echo $this->_tpl_vars['tabname']; ?>
" data-url="">
                            <a href="index.php?module=Settings&action=ModuleSwitch&formodule=<?php echo $this->_tpl_vars['tabname']; ?>
" role="tab" data-toggle="ajaxtab" data-target="#my-navtab-content" data-reload="true">
                                <span><?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['tablabel']]; ?>
</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?>
                </ul>
            </div>
            <div class="tabsLeft" style="display: none;" onclick="scrolltoleft()"><i class="fa fa-angle-double-left"></i></div>
            <div class="tabsRight" style="display: none;" onclick="scrolltoright()"><i class="fa fa-angle-double-right"></i></div>
            <div class="tabsMore" onclick='showMoreList()'><i class="fa fa-angle-double-down"></i></div>
        </div>

        <ul class="tabsMoreList" style="display: none;">
            <?php $_from = $this->_tpl_vars['HEADERS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['tabname'] => $this->_tpl_vars['tablabel']):
?>
                <?php if ($this->_tpl_vars['APP'][$this->_tpl_vars['tablabel']] != ''): ?>
                    <li data-id="<?php echo $this->_tpl_vars['tabname']; ?>
" data-tabid="<?php echo $this->_tpl_vars['tabname']; ?>
" data-url="index.php?module=Settings&action=ModuleSwitch&module_name=<?php echo $this->_tpl_vars['tabname']; ?>
&formodule=<?php echo $this->_tpl_vars['tabname']; ?>
">
                        <a onclick="switchtotab(this,'<?php echo $this->_tpl_vars['tabname']; ?>
','index.php?module=Settings&action=ModuleSwitch&module_name=<?php echo $this->_tpl_vars['tabname']; ?>
&formodule=<?php echo $this->_tpl_vars['tabname']; ?>
')" data-tabid="<?php echo $this->_tpl_vars['tabname']; ?>
" href="javascript:;" role="tab" data-toggle="ajaxtab" data-reload="true">
                            <?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['tablabel']]; ?>

                        </a>
                    </li>
                <?php endif; ?>
            <?php endforeach; endif; unset($_from); ?>
        </ul>

        <div  class="tab-content">
            <div id="my-navtab-content">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="tabcontainer">
                    <tr>
                        <td>
                            <table border=0 cellspacing=5 cellpadding=5 width=100% style="border-spacing: 10px 10px;border-bottom:1px solid #bcb7a0; ">
                                <tr>
                                <?php $this->assign('modulelabel', $this->_tpl_vars['APP'][$this->_tpl_vars['FORMMODULE']]); ?>
                                    <td align=right width=150><?php echo $this->_tpl_vars['modulelabel']; ?>
</td>
                                    <td align=left width=50>
                                    <?php if ($this->_tpl_vars['FORMMODULE_PRESENCE'] == 0): ?>
                                        <a href="javascript:void(0);" onclick="vtlib_toggleModule('<?php echo $this->_tpl_vars['FORMMODULE']; ?>
', 'main','1','<?php echo $this->_tpl_vars['FORMMODULE']; ?>
');">
                                            <i class="fa fa-toggle-on"></i>
                                        </a>
                                        <?php else: ?>
                                        <a href="javascript:void(0);" onclick="vtlib_toggleModule('<?php echo $this->_tpl_vars['FORMMODULE']; ?>
', 'main','0','<?php echo $this->_tpl_vars['FORMMODULE']; ?>
');">
                                            <i class="fa fa-toggle-off"></i>
                                        </a>
                                    <?php endif; ?>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>

                            <table border=0 cellspacing=5 cellpadding=5 width=750 style="border-spacing: 10px 10px;">
                            <?php $this->assign('i', 0); ?>
                            <?php $this->assign('count', count($this->_tpl_vars['TOGGLE_MODINFO'])); ?>
                            <?php $_from = $this->_tpl_vars['TOGGLE_MODINFO']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['modulename'] => $this->_tpl_vars['modinfo']):
?>
                                <?php if ($this->_tpl_vars['modinfo']['customized'] == false): ?>
                                    <?php $this->assign('modulelabel', $this->_tpl_vars['modulename']); ?>
                                    <?php $this->assign('modi', $this->_tpl_vars['i']%4); ?>
                                    <?php if ($this->_tpl_vars['APP'][$this->_tpl_vars['modulename']]): ?><?php $this->assign('modulelabel', $this->_tpl_vars['APP'][$this->_tpl_vars['modulename']]); ?><?php endif; ?>

                                    <?php if (( $this->_tpl_vars['modi'] == 0 )): ?><tr><?php endif; ?>
                                    <td align=right width=150><?php echo $this->_tpl_vars['modulelabel']; ?>
</td>
                                    <td align=left>
                                        <?php if ($this->_tpl_vars['modinfo']['presence'] == 0): ?>
                                            <a href="javascript:void(0);" onclick="vtlib_toggleModule('<?php echo $this->_tpl_vars['modulename']; ?>
', '1','','<?php echo $this->_tpl_vars['FORMMODULE']; ?>
');">
                                                <i class="fa fa-toggle-on"></i>
                                            </a>
                                            <?php else: ?>
                                            <a href="javascript:void(0);" onclick="vtlib_toggleModule('<?php echo $this->_tpl_vars['modulename']; ?>
', '0','','<?php echo $this->_tpl_vars['FORMMODULE']; ?>
');">
                                                <i class="fa fa-toggle-off"></i>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                    <?php if ($this->_tpl_vars['modi'] == 3): ?></tr><?php endif; ?>
                                <?php endif; ?>
                                <?php $this->assign('i', $this->_tpl_vars['i']+1); ?>
                            <?php endforeach; endif; unset($_from); ?>
                            </table>
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
<?php /* Smarty version 2.6.18, created on 2017-08-23 13:26:04
         compiled from Settings/navtab-content.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'Settings/navtab-content.tpl', 25, false),)), $this); ?>
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
', '1','main','<?php echo $this->_tpl_vars['FORMMODULE']; ?>
');">
                            <i class="fa fa-toggle-on"></i>
                        </a>
                        <?php else: ?>
                        <a href="javascript:void(0);" onclick="vtlib_toggleModule('<?php echo $this->_tpl_vars['FORMMODULE']; ?>
', '0','main','<?php echo $this->_tpl_vars['FORMMODULE']; ?>
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
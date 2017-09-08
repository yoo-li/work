<?php /* Smarty version 2.6.18, created on 2017-07-31 11:07:11
         compiled from LeftMenu.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'strtolower', 'LeftMenu.tpl', 11, false),array('modifier', 'str_replace', 'LeftMenu.tpl', 12, false),array('modifier', 'getTranslatedString', 'LeftMenu.tpl', 109, false),)), $this); ?>

<div id="bjui-hnav">
    <div id="bjui-hnav-navbar-box">
        <ul id="bjui-hnav-navbar">
            <li class="active"><a href="javascript:;" data-toggle="slidebar"><i class="fa-iconfont icon-application"></i> 应用 </a>
                <div class="items hide" data-noinit="true">
					<?php $this->assign('did', 1); ?>
                    <ul id="bjui-hnav-tree0" class="ztree ztree_main" data-toggle="ztree" data-on-click="MainMenuClick" data-setting="{callback:{beforeExpand:MainMenu_ztree_beforeexpand}}" data-faicon="iconfont icon-application" data-tit="应用">
						<?php $_from = $this->_tpl_vars['HEADERS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['tabname'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['tabname']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['maintabs'] => $this->_tpl_vars['detail']):
        $this->_foreach['tabname']['iteration']++;
?>
							<?php if ($this->_tpl_vars['maintabs'] != 'Analytics'): ?>
								<?php $this->assign('lowermaintabs', strtolower($this->_tpl_vars['maintabs'])); ?>
								<?php $this->assign('newmaintabs', str_replace(' ', '_', $this->_tpl_vars['lowermaintabs'])); ?>
								<!--一级菜单-->
								<li data-id="<?php echo $this->_tpl_vars['did']; ?>
" data-pid="0" <?php if ($this->_foreach['tabname']['iteration'] == 1): ?>data-open="true"<?php endif; ?> data-faicon="iconfont icon-<?php echo $this->_tpl_vars['newmaintabs']; ?>
" data-faicon-close="iconfont icon-<?php echo $this->_tpl_vars['newmaintabs']; ?>
"><?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['maintabs']]; ?>
</li>
								<!--二级菜单-->
								<?php $this->assign('pid', $this->_tpl_vars['did']); ?>
								<?php $this->assign('did', $this->_tpl_vars['did']+1); ?>
								<?php $_from = $this->_tpl_vars['detail']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['subtab'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['subtab']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['assembly'] => $this->_tpl_vars['module']):
        $this->_foreach['subtab']['iteration']++;
?>
									<?php if (is_array ( $this->_tpl_vars['module'] )): ?>
										<li data-id="<?php echo $this->_tpl_vars['did']; ?>
" data-pid="<?php echo $this->_tpl_vars['pid']; ?>
" data-faicon="iconfont icon-<?php echo strtolower($this->_tpl_vars['assembly']); ?>
" <?php if ($this->_foreach['subtab']['iteration'] == 1): ?>data-open="true"<?php endif; ?> data-faicon-close="iconfont icon-<?php echo strtolower($this->_tpl_vars['assembly']); ?>
"><?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['assembly']]; ?>
</li>
										<?php $this->assign('spid', $this->_tpl_vars['did']); ?>
										<?php $_from = $this->_tpl_vars['module']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['subsubtab'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['subsubtab']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['submodule']):
        $this->_foreach['subsubtab']['iteration']++;
?>
											<?php $this->assign('label', $this->_tpl_vars['HEADERLABELS']['submodule']); ?>
											<?php if ($this->_tpl_vars['APP'][$this->_tpl_vars['label']]): ?>
												<?php $this->assign('modulelabel', $this->_tpl_vars['APP'][$this->_tpl_vars['label']]); ?>
											<?php else: ?>
												<?php $this->assign('modulelabel', $this->_tpl_vars['APP'][$this->_tpl_vars['submodule']]); ?>
											<?php endif; ?>
											<!--三级菜单-->
											<?php $this->assign('did', $this->_tpl_vars['did']+1); ?>
											<li data-id="<?php echo $this->_tpl_vars['did']; ?>
" data-pid="<?php echo $this->_tpl_vars['spid']; ?>
" data-url="index.php?module=<?php echo $this->_tpl_vars['submodule']; ?>
&action=index&parenttab=<?php echo $this->_tpl_vars['maintabs']; ?>
" data-fresh="true" data-tabid="<?php echo $this->_tpl_vars['submodule']; ?>
" data-faicon="iconfont icon-<?php echo strtolower($this->_tpl_vars['submodule']); ?>
"><?php echo $this->_tpl_vars['modulelabel']; ?>
</li>
											<?php $this->assign('shortcuts', $this->_tpl_vars['SHORTCUTS'][$this->_tpl_vars['submodule']]); ?>
											<?php if ($this->_tpl_vars['shortcuts']): ?>  
												<?php $_from = $this->_tpl_vars['shortcuts']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['shortcut'] => $this->_tpl_vars['action']):
?> 
													<?php $this->assign('did', $this->_tpl_vars['did']+1); ?>
												    <li data-id="<?php echo $this->_tpl_vars['did']; ?>
" data-pid="<?php echo $this->_tpl_vars['spid']; ?>
" data-url="index.php?module=<?php echo $this->_tpl_vars['submodule']; ?>
&action=<?php echo $this->_tpl_vars['action']; ?>
&parenttab=<?php echo $this->_tpl_vars['maintabs']; ?>
" data-fresh="true" data-tabid="<?php echo $this->_tpl_vars['submodule']; ?>
" data-faicon="iconfont icon-<?php echo strtolower($this->_tpl_vars['shortcut']); ?>
"><?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['shortcut']]; ?>
</li>
												 <?php endforeach; endif; unset($_from); ?>
											<?php endif; ?>
										<?php endforeach; endif; unset($_from); ?>
									<?php else: ?>
										<?php $this->assign('label', $this->_tpl_vars['HEADERLABELS'][$this->_tpl_vars['module']]); ?>
										<?php if ($this->_tpl_vars['APP'][$this->_tpl_vars['label']]): ?>
											<?php $this->assign('modulelabel', $this->_tpl_vars['APP'][$this->_tpl_vars['label']]); ?>
										<?php else: ?>
											<?php $this->assign('modulelabel', $this->_tpl_vars['APP'][$this->_tpl_vars['module']]); ?>
										<?php endif; ?>
										<?php $this->assign('did', $this->_tpl_vars['did']+1); ?>
										<li data-id="<?php echo $this->_tpl_vars['did']; ?>
" data-pid="<?php echo $this->_tpl_vars['pid']; ?>
" data-url="index.php?module=<?php echo $this->_tpl_vars['module']; ?>
&action=index&parenttab=<?php echo $this->_tpl_vars['maintabs']; ?>
" data-fresh="true" data-tabid="<?php echo $this->_tpl_vars['module']; ?>
" data-faicon="iconfont icon-<?php echo strtolower($this->_tpl_vars['module']); ?>
"><?php echo $this->_tpl_vars['modulelabel']; ?>
</li>
										<?php $this->assign('shortcuts', $this->_tpl_vars['SHORTCUTS'][$this->_tpl_vars['module']]); ?>
										<?php if ($this->_tpl_vars['shortcuts']): ?>  
											<?php $_from = $this->_tpl_vars['shortcuts']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['shortcut'] => $this->_tpl_vars['action']):
?> 
												<?php $this->assign('did', $this->_tpl_vars['did']+1); ?>
											    <li data-id="<?php echo $this->_tpl_vars['did']; ?>
" data-pid="<?php echo $this->_tpl_vars['pid']; ?>
" data-url="index.php?module=<?php echo $this->_tpl_vars['module']; ?>
&action=<?php echo $this->_tpl_vars['action']; ?>
&parenttab=<?php echo $this->_tpl_vars['maintabs']; ?>
" data-fresh="true" data-tabid="<?php echo $this->_tpl_vars['submodule']; ?>
" data-faicon="iconfont icon-<?php echo strtolower($this->_tpl_vars['shortcut']); ?>
"><?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['shortcut']]; ?>
</li>
											 <?php endforeach; endif; unset($_from); ?>
										<?php endif; ?>
									<?php endif; ?>									
								<?php endforeach; endif; unset($_from); ?>
							<?php endif; ?>
						<?php endforeach; endif; unset($_from); ?>
                    </ul>
					<!--增加一个一级菜单(报表)-->

					<?php if ($this->_tpl_vars['HASREPORT'] == 'true'): ?>
					<ul id="bjui-hnav-tree1" class="ztree ztree_main" data-toggle="ztree" data-on-click="MainMenuClick" data-setting="{callback:{beforeExpand:MainMenu_ztree_beforeexpand}}" data-expand-all="false" data-faicon="iconfont icon-group-reports" data-tit="<?php echo $this->_tpl_vars['APP']['Analytics']; ?>
">
						<?php $_from = $this->_tpl_vars['HEADERS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['tabname'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['tabname']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['maintabs'] => $this->_tpl_vars['detail']):
        $this->_foreach['tabname']['iteration']++;
?>
							<?php if ($this->_tpl_vars['maintabs'] == 'Analytics'): ?>
								<!--二级菜单-->
								<?php $this->assign('pid', $this->_tpl_vars['did']); ?>
								<?php $this->assign('did', $this->_tpl_vars['did']+1); ?>
								<?php $_from = $this->_tpl_vars['detail']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['subtab'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['subtab']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['assembly'] => $this->_tpl_vars['module']):
        $this->_foreach['subtab']['iteration']++;
?>
									<?php if ($this->_tpl_vars['assembly'] == 'TopN报表'): ?>
										<?php $this->assign('menuicon', 'ReportsTopN'); ?>
									<?php elseif ($this->_tpl_vars['assembly'] == '环比报表'): ?>
										<?php $this->assign('menuicon', 'ReportsLinkRelative'); ?>
									<?php elseif ($this->_tpl_vars['assembly'] == '同比报表'): ?>
										<?php $this->assign('menuicon', 'ReportsSameRelative'); ?>
									<?php elseif ($this->_tpl_vars['assembly'] == '综合报表'): ?>
										<?php $this->assign('menuicon', 'ReportsIntegrated'); ?>
									<?php else: ?>
										<?php $this->assign('menuicon', 'Reports'); ?>
									<?php endif; ?>
									<li data-id="<?php echo $this->_tpl_vars['did']; ?>
" data-pid="<?php echo $this->_tpl_vars['pid']; ?>
" <?php if ($this->_foreach['subtab']['iteration'] == 1): ?>data-open="true"<?php endif; ?> data-faicon="iconfont icon-<?php echo strtolower($this->_tpl_vars['menuicon']); ?>
" data-faicon-close="iconfont icon-<?php echo strtolower($this->_tpl_vars['menuicon']); ?>
"><?php echo $this->_tpl_vars['assembly']; ?>
</li>
									<?php $this->assign('spid', $this->_tpl_vars['did']); ?>
									<?php $_from = $this->_tpl_vars['module']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['subsubtab'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['subsubtab']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['submodulename'] => $this->_tpl_vars['submodule']):
        $this->_foreach['subsubtab']['iteration']++;
?>
										<!--三级菜单-->
										<?php $this->assign('did', $this->_tpl_vars['did']+1); ?>
										<?php if (is_array ( $this->_tpl_vars['submodule'] )): ?>
											<li data-id="<?php echo $this->_tpl_vars['did']; ?>
" data-pid="<?php echo $this->_tpl_vars['spid']; ?>
" <?php if ($this->_foreach['subsubtab']['iteration'] == 1): ?>data-open="true"<?php endif; ?> data-faicon="iconfont icon-reportitem" data-faicon-close="iconfont icon-reportitem"><?php echo $this->_tpl_vars['submodulename']; ?>
</li>
											<?php $this->assign('sspid', $this->_tpl_vars['did']); ?>
											<?php $_from = $this->_tpl_vars['submodule']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['subsubsubtab'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['subsubsubtab']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['subsubmoduleid'] => $this->_tpl_vars['subsubmodulename']):
        $this->_foreach['subsubsubtab']['iteration']++;
?>
												<?php $this->assign('did', $this->_tpl_vars['did']+1); ?>
												<li data-id="<?php echo $this->_tpl_vars['did']; ?>
" data-pid="<?php echo $this->_tpl_vars['sspid']; ?>
" data-url="index.php?module=<?php echo $this->_tpl_vars['menuicon']; ?>
&action=index&reportid=<?php echo $this->_tpl_vars['subsubmoduleid']; ?>
&parenttab=<?php echo $this->_tpl_vars['maintabs']; ?>
" data-fresh="true" data-tabid="<?php echo $this->_tpl_vars['menuicon']; ?>
" data-faicon="iconfont icon-reportitem"><?php echo $this->_tpl_vars['subsubmodulename']; ?>
</li>
											<?php endforeach; endif; unset($_from); ?>
										<?php else: ?>
											<li data-id="<?php echo $this->_tpl_vars['did']; ?>
" data-pid="<?php echo $this->_tpl_vars['pid']; ?>
" data-url="index.php?module=<?php echo $this->_tpl_vars['menuicon']; ?>
&action=index&reportid=<?php echo $this->_tpl_vars['submodule']; ?>
&parenttab=<?php echo $this->_tpl_vars['maintabs']; ?>
" data-fresh="true" data-tabid="<?php echo $this->_tpl_vars['menuicon']; ?>
" data-faicon="iconfont icon-reportitem"><?php echo $this->_tpl_vars['submodulename']; ?>
</li>
										<?php endif; ?>
									<?php endforeach; endif; unset($_from); ?>
								<?php endforeach; endif; unset($_from); ?>
							<?php endif; ?>
						<?php endforeach; endif; unset($_from); ?>
					</ul>
					<?php endif; ?>

					<!--增加一个一级菜单（系统设置）-->
					<?php if ($this->_tpl_vars['IS_ADMIN'] == 1): ?>
						<ul id="bjui-hnav-tree2" class="ztree ztree_main" data-toggle="ztree" data-on-click="MainMenuClick" data-setting="{callback:{beforeExpand:MainMenu_ztree_beforeexpand}}" data-faicon="iconfont icon-settings" data-tit="<?php echo $this->_tpl_vars['APP']['Settings']; ?>
">
							<?php $_from = $this->_tpl_vars['MENUS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['blockname'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['blockname']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['blockid'] => $this->_tpl_vars['details']):
        $this->_foreach['blockname']['iteration']++;
?>
								<?php $this->assign('lbl_blockid', "LBL_".($this->_tpl_vars['blockid'])); ?>
								<?php $this->assign('blocklabel', getTranslatedString($this->_tpl_vars['lbl_blockid'], 'Settings')); ?>
								<!--一级菜单-->
	                                <li data-id="<?php echo $this->_tpl_vars['did']; ?>
" data-pid="0" <?php if ($this->_foreach['blockname']['iteration'] == 1): ?>data-open="true"<?php endif; ?> data-faicon="iconfont icon-<?php echo strtolower($this->_tpl_vars['lbl_blockid']); ?>
" data-faicon-close="iconfont icon-<?php echo strtolower($this->_tpl_vars['lbl_blockid']); ?>
"><?php echo $this->_tpl_vars['blocklabel']; ?>
</li>
								<!--二级菜单-->
								<?php $this->assign('pid', $this->_tpl_vars['did']); ?>
								<?php $this->assign('did', $this->_tpl_vars['did']+1); ?>
								<?php $_from = $this->_tpl_vars['details']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['menuid'] => $this->_tpl_vars['data']):
?>
									<?php $this->assign('lbl_menuid', "LBL_".($this->_tpl_vars['menuid'])); ?>
									<?php $this->assign('label', getTranslatedString($this->_tpl_vars['lbl_menuid'], 'Settings')); ?>
									<?php $this->assign('did', $this->_tpl_vars['did']+1); ?>
									<li data-id="<?php echo $this->_tpl_vars['did']; ?>
" data-pid="<?php echo $this->_tpl_vars['pid']; ?>
" data-url="<?php echo $this->_tpl_vars['data']['link']; ?>
" data-fresh="true" data-tabid="<?php echo $this->_tpl_vars['data']['module']; ?>
" data-faicon="iconfont icon-<?php echo strtolower($this->_tpl_vars['lbl_menuid']); ?>
"><?php echo $this->_tpl_vars['label']; ?>
</li>
								<?php endforeach; endif; unset($_from); ?>
							<?php endforeach; endif; unset($_from); ?>
						</ul>
					<?php endif; ?>
				</div>
            </li>
        </ul>
    </div>
</div>
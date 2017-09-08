<?php /* Smarty version 2.6.18, created on 2017-07-31 16:23:05
         compiled from salesEditView.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getParentTabLabelFromModule', 'salesEditView.tpl', 10, false),array('modifier', 'count', 'salesEditView.tpl', 17, false),array('modifier', 'strtolower', 'salesEditView.tpl', 34, false),array('modifier', 'getTranslatedString', 'salesEditView.tpl', 51, false),array('modifier', 'lower', 'salesEditView.tpl', 55, false),array('modifier', 'is_array', 'salesEditView.tpl', 74, false),array('function', 'math', 'salesEditView.tpl', 91, false),)), $this); ?>
<?php if ($this->_tpl_vars['HASCSS'] == 'true'): ?>
<link rel="stylesheet" href="modules/<?php echo $this->_tpl_vars['MODULE']; ?>
/<?php echo $this->_tpl_vars['MODULE']; ?>
.css">
<?php endif; ?>
<link rel="stylesheet" href="Public/css/waitbar.css">
<script language="JavaScript" type="text/javascript" src="modules/<?php echo $this->_tpl_vars['MODULE']; ?>
/<?php echo $this->_tpl_vars['MODULE']; ?>
.js"></script>

<div class="bjui-pageHeader">
	<h5 class="contentTitle" style="margin-bottom:5px;margin-top:5px;">
		<center><?php echo getParentTabLabelFromModule($this->_tpl_vars['MODULE']); ?>
 - <?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['MODULE']]; ?>
</center>
	</h5>
	<h6 class="contentTitle">
		<center>
			<label><?php echo $this->_tpl_vars['APP']['LBL_AUTHOR']; ?>
：</label><?php echo $this->_tpl_vars['CREATEUSER']['0']; ?>

			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<label><?php echo $this->_tpl_vars['APP']['LBL_CREATED']; ?>
：</label><?php echo $this->_tpl_vars['CREATEDATE']; ?>

			<?php if (count($this->_tpl_vars['DEFAULTdATAS']) > 0): ?>
				<?php $_from = $this->_tpl_vars['DEFAULTdATAS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['label'] => $this->_tpl_vars['defaultdata']):
?>
				    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<label><?php echo $this->_tpl_vars['label']; ?>
：</label><?php echo $this->_tpl_vars['defaultdata']; ?>

				<?php endforeach; endif; unset($_from); ?>
			<?php endif; ?>
			<?php if ($this->_tpl_vars['CURRENTRECORDNUM'] != ''): ?>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<label>编号：</label><?php echo $this->_tpl_vars['CURRENTRECORDNUM']; ?>

			<?php elseif ($this->_tpl_vars['MOD_SEQ_ID'] != ''): ?>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<label>编号：</label><?php echo $this->_tpl_vars['MOD_SEQ_ID']; ?>

			<?php endif; ?>
		</center>
	</h6>
</div>
<div class="bjui-pageContent tableContent" style="overflow:hidden;">
	<form id="salesEditViewForm" method="post" action="index.php" callback="<?php echo strtolower($this->_tpl_vars['MODULE']); ?>
_validate" data-toggle="validate" data-validator-option="{focusCleanup:true,timely:false}" data-alertmsg="false">
		<input type="hidden" id="module" name="module" value="<?php echo $this->_tpl_vars['MODULE']; ?>
">
		<input type="hidden" id="action" name="action" value="Save">
		<input type="hidden" id="record" name="record" value="<?php echo $this->_tpl_vars['ID']; ?>
">
		<input type="hidden" id="mode" name="mode" value="<?php echo $this->_tpl_vars['MODE']; ?>
">
		<input type="hidden" id="savetype" name="savetype" value="">
		<input type="hidden" id="params" name="params" value='<?php echo $this->_tpl_vars['PARAMS']; ?>
'>
		<input type="hidden" id="token" name="token" value="<?php echo $this->_tpl_vars['TOKEN']; ?>
">
		<input type="hidden" name="__hash__" value="f05447c821012018c16dec99264a7bdc_ea332f4bef78750abe1e93924eaf44f8" />
		<?php if ($this->_tpl_vars['WAITBARKEY'] != ''): ?>
		<input type="hidden" id="waitbar" name="waitbar" value='true'>
		<input type="hidden" id="waitbarkey" name="waitbarkey" value='<?php echo $this->_tpl_vars['WAITBARKEY']; ?>
'>
		<input type="hidden" id="waitbarcomplete" name="waitbarcomplete" value='complete'>
		<?php endif; ?>
		<div class="bjui-pageContent tableContent" style="overflow:hidden;margin:4px;">
		    <ul class="nav nav-tabs" role="tablist">
					<?php $_from = $this->_tpl_vars['BLOCKS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['blocks'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['blocks']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['header'] => $this->_tpl_vars['data']):
        $this->_foreach['blocks']['iteration']++;
?>
						<li class="<?php if ($this->_foreach['blocks']['iteration'] == 1): ?>active<?php endif; ?>"><a href="#<?php echo $this->_tpl_vars['header']; ?>
" role="tab" data-toggle="tab"><?php echo getTranslatedString($this->_tpl_vars['header'], $this->_tpl_vars['MODULE']); ?>
</a></li>
					<?php endforeach; endif; unset($_from); ?>
					<?php $_from = $this->_tpl_vars['AJAX_PANEL_CHECK']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['header'] => $this->_tpl_vars['paneldata']):
?>
						<?php if ($this->_tpl_vars['paneldata']['location'] == 'panel' && $this->_tpl_vars['paneldata']['visible'] == 'true'): ?>
							<li><a href="#<?php echo ((is_array($_tmp=$this->_tpl_vars['paneldata']['action'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)); ?>
_form_div" role="tab" data-toggle="tab"><?php echo getTranslatedString($this->_tpl_vars['paneldata']['action'], $this->_tpl_vars['MODULE']); ?>
</a>
						<?php endif; ?>
					<?php endforeach; endif; unset($_from); ?>
		    </ul>
			<?php $_from = $this->_tpl_vars['AJAX_PANEL_CHECK']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['data']):
?>
				<?php if ($this->_tpl_vars['data']['location'] == 'right' && $this->_tpl_vars['data']['visible'] == 'true'): ?>
					<?php $this->assign('ajax_panel_action', $this->_tpl_vars['data']['action']); ?>
					<?php $this->assign('ajax_panel_width', $this->_tpl_vars['data']['width']); ?>
				<?php endif; ?>
			<?php endforeach; endif; unset($_from); ?>
			<div class="bjui-pageContent tableContent tab-content" style="overflow:auto;top:27px;">
				<?php $_from = $this->_tpl_vars['BLOCKS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['blocks'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['blocks']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['header'] => $this->_tpl_vars['data']):
        $this->_foreach['blocks']['iteration']++;
?>
					<div class="tab-pane navtab-panel tabsPageContent <?php if ($this->_foreach['blocks']['iteration'] == 1): ?>active in<?php endif; ?>" id="<?php echo $this->_tpl_vars['header']; ?>
">
						<?php $_from = $this->_tpl_vars['AJAX_PANEL_CHECK']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['topdata']):
?>
							<?php if ($this->_tpl_vars['topdata']['location'] == 'top' && $this->_tpl_vars['topdata']['visible'] == 'true' && ( $this->_tpl_vars['data']['sequence'] == '' || $this->_tpl_vars['data']['sequence'] == $this->_foreach['blocks']['iteration'] )): ?>
								<div id="<?php echo ((is_array($_tmp=$this->_tpl_vars['topdata']['action'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)); ?>
_form_div">
									<script language="javascript" type="text/javascript">
										var params = "";
										<?php if ($this->_tpl_vars['topdata']['params'] != ''): ?>
											<?php if (((is_array($_tmp=$this->_tpl_vars['topdata']['params'])) ? $this->_run_mod_handler('is_array', true, $_tmp) : is_array($_tmp))): ?>
												<?php $_from = $this->_tpl_vars['topdata']['params']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['subparam']):
?>
													params += "&<?php echo $this->_tpl_vars['subparam']; ?>
="+$("#<?php echo $this->_tpl_vars['subparam']; ?>
").val();
												<?php endforeach; endif; unset($_from); ?>
											<?php else: ?>
												params = "&<?php echo $this->_tpl_vars['topdata']['params']; ?>
="+$("#<?php echo $this->_tpl_vars['topdata']['params']; ?>
").val();
											<?php endif; ?>
										<?php endif; ?>
										var postBody = "index.php?module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=<?php echo $this->_tpl_vars['topdata']['action']; ?>
&record=<?php echo $this->_tpl_vars['ID']; ?>
&mode=ajax&readonly=<?php echo $this->_tpl_vars['READONLY']; ?>
"+params;
										$("#<?php echo ((is_array($_tmp=$this->_tpl_vars['topdata']['action'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)); ?>
_form_div").loadUrl(postBody);
									</script>
								</div>
							<?php endif; ?>
						<?php endforeach; endif; unset($_from); ?>
						<?php if ($this->_foreach['blocks']['iteration'] == 1): ?>
							<?php if ($this->_tpl_vars['ajax_panel_action'] != ""): ?>
								<div>
								<span style="width:<?php echo smarty_function_math(array('equation' => "x - y",'x' => 100,'y' => $this->_tpl_vars['ajax_panel_width']), $this);?>
%;float:left;">
									<table class="table nowrap">
										<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "DisplayFields.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
									</table>
								</span>
								<span style="width:<?php echo $this->_tpl_vars['ajax_panel_width']; ?>
%;float:right;">
									<div id="<?php echo ((is_array($_tmp=$this->_tpl_vars['ajax_panel_action'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)); ?>
_form_div">
										<script language="javascript" type="text/javascript">
											var postBody = "index.php?module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=<?php echo $this->_tpl_vars['ajax_panel_action']; ?>
&record=<?php echo $this->_tpl_vars['ID']; ?>
&mode=ajax&readonly=<?php echo $this->_tpl_vars['READONLY']; ?>
";
											$("#<?php echo ((is_array($_tmp=$this->_tpl_vars['ajax_panel_action'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)); ?>
_form_div").loadUrl(postBody);
										</script>
									</div>
								</span>
								</div>
								<?php $_from = $this->_tpl_vars['AJAX_PANEL_CHECK']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['data']):
?>
									<?php if ($this->_tpl_vars['data']['location'] == 'base' && $this->_tpl_vars['data']['visible'] == 'true' && ( $this->_tpl_vars['data']['sequence'] == '' || $this->_tpl_vars['data']['sequence'] == '1' )): ?>
										<div id="<?php echo ((is_array($_tmp=$this->_tpl_vars['data']['action'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)); ?>
_form_div">
											<script language="javascript" type="text/javascript">
												var params = "";
												<?php if ($this->_tpl_vars['data']['params'] != ''): ?>
													<?php if (((is_array($_tmp=$this->_tpl_vars['data']['params'])) ? $this->_run_mod_handler('is_array', true, $_tmp) : is_array($_tmp))): ?>
														<?php $_from = $this->_tpl_vars['data']['params']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['subparam']):
?>
															params += "&<?php echo $this->_tpl_vars['subparam']; ?>
="+$("#<?php echo $this->_tpl_vars['subparam']; ?>
").val();
														<?php endforeach; endif; unset($_from); ?>
													<?php else: ?>
														params = "&<?php echo $this->_tpl_vars['data']['params']; ?>
="+$("#<?php echo $this->_tpl_vars['data']['params']; ?>
").val();
													<?php endif; ?>
												<?php endif; ?>
												var postBody = "index.php?module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=<?php echo $this->_tpl_vars['data']['action']; ?>
&record=<?php echo $this->_tpl_vars['ID']; ?>
&mode=ajax&readonly=<?php echo $this->_tpl_vars['READONLY']; ?>
"+params;
												$("#<?php echo ((is_array($_tmp=$this->_tpl_vars['data']['action'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)); ?>
_form_div").loadUrl(postBody);
											</script>
										</div>
									<?php endif; ?>
								<?php endforeach; endif; unset($_from); ?>
							<?php else: ?>
								<table class="table table-none">
									<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "DisplayFields.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
								</table>
								<?php $_from = $this->_tpl_vars['AJAX_PANEL_CHECK']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['data']):
?>
									<?php if ($this->_tpl_vars['data']['location'] == 'base' && $this->_tpl_vars['data']['visible'] == 'true' && ( $this->_tpl_vars['data']['sequence'] == '' || $this->_tpl_vars['data']['sequence'] == '1' )): ?>
										<div id="<?php echo ((is_array($_tmp=$this->_tpl_vars['data']['action'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)); ?>
_form_div">
											<script language="javascript" type="text/javascript">
												var params = "";
												<?php if ($this->_tpl_vars['data']['params'] != ''): ?>
													<?php if (((is_array($_tmp=$this->_tpl_vars['data']['params'])) ? $this->_run_mod_handler('is_array', true, $_tmp) : is_array($_tmp))): ?>
														<?php $_from = $this->_tpl_vars['data']['params']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['subparam']):
?>
															params += "&<?php echo $this->_tpl_vars['subparam']; ?>
="+$("#<?php echo $this->_tpl_vars['subparam']; ?>
").val();
														<?php endforeach; endif; unset($_from); ?>
													<?php else: ?>
														params = "&<?php echo $this->_tpl_vars['data']['params']; ?>
="+$("#<?php echo $this->_tpl_vars['data']['params']; ?>
").val();
													<?php endif; ?>
												<?php endif; ?>
												var postBody = "index.php?module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=<?php echo $this->_tpl_vars['data']['action']; ?>
&record=<?php echo $this->_tpl_vars['ID']; ?>
&mode=ajax&readonly=<?php echo $this->_tpl_vars['READONLY']; ?>
"+params;
												$("#<?php echo ((is_array($_tmp=$this->_tpl_vars['data']['action'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)); ?>
_form_div").loadUrl(postBody);
											</script>
										</div>
									<?php endif; ?>
								<?php endforeach; endif; unset($_from); ?>
							<?php endif; ?>
							<?php if ($this->_tpl_vars['HASAPPROVALS'] == 'true' && $this->_tpl_vars['APPROVALID'] != ''): ?>
							<div class="nav-tabs" style="margin-top:10px;margin-bottom:10px;"></div>
							<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "Approvals.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
							<div class="nav-tabs" style="margin-top:10px;margin-bottom:10px;"></div>
							<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "ApprovalsTransferStep.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
							<?php endif; ?>
						<?php else: ?>
							<table class="table table-none nowrap">
								<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "DisplayFields.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
							</table>
							<?php $_from = $this->_tpl_vars['AJAX_PANEL_CHECK']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['data']):
?>
								<?php if ($this->_tpl_vars['data']['location'] == 'base' && $this->_tpl_vars['data']['visible'] == 'true' && ( $this->_tpl_vars['data']['sequence'] == '' || $this->_tpl_vars['data']['sequence'] == $this->_foreach['blocks']['iteration'] )): ?>
									<div id="<?php echo ((is_array($_tmp=$this->_tpl_vars['data']['action'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)); ?>
_form_div">
										<script language="javascript" type="text/javascript">
											var params = "";
											<?php if ($this->_tpl_vars['data']['params'] != ''): ?>
												<?php if (((is_array($_tmp=$this->_tpl_vars['data']['params'])) ? $this->_run_mod_handler('is_array', true, $_tmp) : is_array($_tmp))): ?>
													<?php $_from = $this->_tpl_vars['data']['params']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['subparam']):
?>
														params += "&<?php echo $this->_tpl_vars['subparam']; ?>
="+$("#<?php echo $this->_tpl_vars['subparam']; ?>
").val();
													<?php endforeach; endif; unset($_from); ?>
												<?php else: ?>
													params = "&<?php echo $this->_tpl_vars['data']['params']; ?>
="+$("#<?php echo $this->_tpl_vars['data']['params']; ?>
").val();
												<?php endif; ?>
											<?php endif; ?>
											var postBody = "index.php?module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=<?php echo $this->_tpl_vars['data']['action']; ?>
&record=<?php echo $this->_tpl_vars['ID']; ?>
&mode=ajax&readonly=<?php echo $this->_tpl_vars['READONLY']; ?>
"+params;
											$("#<?php echo ((is_array($_tmp=$this->_tpl_vars['data']['action'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)); ?>
_form_div").loadUrl(postBody);
										</script>
									</div>
								<?php endif; ?>
							<?php endforeach; endif; unset($_from); ?>
						<?php endif; ?>
						<?php $_from = $this->_tpl_vars['AJAX_PANEL_CHECK']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['data']):
?>
							<?php if ($this->_tpl_vars['data']['location'] == 'bottom' && $this->_tpl_vars['data']['visible'] == 'true' && ( $this->_tpl_vars['data']['sequence'] == '' || $this->_tpl_vars['data']['sequence'] == $this->_foreach['blocks']['iteration'] )): ?>
								<div class="nav-tabs" style="margin-top:10px;margin-bottom:10px;"></div>
								<div class="panel panel-default" style="margin:2px;">
									<div class="panel-heading"><h3 class="panel-title"><?php echo getTranslatedString($this->_tpl_vars['data']['action'], $this->_tpl_vars['MODULE']); ?>
  <a style="float:right;cursor:pointer;text-decoration: none;font-size:17px;"  data-toggle="collapse" data-target="#<?php echo ((is_array($_tmp=$this->_tpl_vars['data']['action'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)); ?>
_form_div"><i class="fa btn-default fa-caret-square-o-up"></i><i class="fa btn-default fa-caret-square-o-down"></i></a></h3> </div>
									<div style="padding:0;" class="panel-body bjui-doc">
										<div id="<?php echo ((is_array($_tmp=$this->_tpl_vars['data']['action'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)); ?>
_form_div"  class="collapse in">
											<script language="javascript" type="text/javascript">
												var params = "";
												<?php if ($this->_tpl_vars['data']['params'] != ''): ?>
													<?php if (((is_array($_tmp=$this->_tpl_vars['data']['params'])) ? $this->_run_mod_handler('is_array', true, $_tmp) : is_array($_tmp))): ?>
														<?php $_from = $this->_tpl_vars['data']['params']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['subparam']):
?>
															params += "&<?php echo $this->_tpl_vars['subparam']; ?>
="+$("#<?php echo $this->_tpl_vars['subparam']; ?>
").val();
														<?php endforeach; endif; unset($_from); ?>
													<?php else: ?>
														params = "&<?php echo $this->_tpl_vars['data']['params']; ?>
="+$("#<?php echo $this->_tpl_vars['data']['params']; ?>
").val();
													<?php endif; ?>
												<?php endif; ?>
												var postBody = "index.php?module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=<?php echo $this->_tpl_vars['data']['action']; ?>
&record=<?php echo $this->_tpl_vars['ID']; ?>
&mode=ajax&readonly=<?php echo $this->_tpl_vars['READONLY']; ?>
"+params;
												<?php if ($this->_tpl_vars['data']['action'] == 'Memo'): ?>
													postBody = "index.php?module=Memo&action=ShowMemo&record=<?php echo $this->_tpl_vars['ID']; ?>
&mode=ajax&readonly=<?php echo $this->_tpl_vars['READONLY']; ?>
&submodule=<?php echo $this->_tpl_vars['MODULE']; ?>
"+params;
													jQuery("#<?php echo ((is_array($_tmp=$this->_tpl_vars['data']['action'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)); ?>
_form_div").attr("data-toggle","autoajaxload");
													jQuery("#<?php echo ((is_array($_tmp=$this->_tpl_vars['data']['action'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)); ?>
_form_div").attr("data-url",postBody);
												<?php else: ?>
													jQuery("#<?php echo ((is_array($_tmp=$this->_tpl_vars['data']['action'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)); ?>
_form_div").loadUrl(postBody);
												<?php endif; ?>
											</script>
										</div>
									</div>
								</div>
							<?php endif; ?>
						<?php endforeach; endif; unset($_from); ?>
					</div>
				<?php endforeach; endif; unset($_from); ?>
				<?php $_from = $this->_tpl_vars['AJAX_PANEL_CHECK']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['header'] => $this->_tpl_vars['paneldata']):
?>
					<?php if ($this->_tpl_vars['paneldata']['location'] == 'panel' && $this->_tpl_vars['paneldata']['visible'] == 'true'): ?>
						<div class="tab-pane navtab-panel tabsPageContent" id="<?php echo ((is_array($_tmp=$this->_tpl_vars['paneldata']['action'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)); ?>
_form_div">
							<script language="javascript" type="text/javascript">
								var params = "";
								<?php if ($this->_tpl_vars['paneldata']['params'] != ''): ?>
									<?php if (((is_array($_tmp=$this->_tpl_vars['paneldata']['params'])) ? $this->_run_mod_handler('is_array', true, $_tmp) : is_array($_tmp))): ?>
										<?php $_from = $this->_tpl_vars['paneldata']['params']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['subparam']):
?>
											params += "&<?php echo $this->_tpl_vars['subparam']; ?>
="+$("#<?php echo $this->_tpl_vars['subparam']; ?>
").val();
										<?php endforeach; endif; unset($_from); ?>
									<?php else: ?>
										params = "&<?php echo $this->_tpl_vars['paneldata']['params']; ?>
="+$("#<?php echo $this->_tpl_vars['paneldata']['params']; ?>
").val();
									<?php endif; ?>
								<?php endif; ?>
								var postBody = "index.php?module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=<?php echo $this->_tpl_vars['paneldata']['action']; ?>
&record=<?php echo $this->_tpl_vars['ID']; ?>
&mode=ajax&readonly=<?php echo $this->_tpl_vars['READONLY']; ?>
"+params;
								$("#<?php echo ((is_array($_tmp=$this->_tpl_vars['paneldata']['action'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)); ?>
_form_div").loadUrl(postBody);
							</script>
						</div>
					<?php endif; ?>
				<?php endforeach; endif; unset($_from); ?>
			</div>
		</div>
		<input type="hidden" id="max_yiliao_elementlength" name="max_yiliao_elementlength" value="yiliao">
	</form>
</div>
<div class="bjui-pageFooter" <?php if ($this->_tpl_vars['RUNTIME'] != ''): ?>title="响应时间:<?php echo $this->_tpl_vars['RUNTIME']; ?>
s"<?php endif; ?>>
    <ul>
        <li><button type="button" class="btn-close" data-icon="close">关闭</button></li>
		<li><button type="submit" id="savebutton" <?php if ($this->_tpl_vars['READONLY'] == 'true'): ?>disabled<?php endif; ?> class="btn-green" data-icon="save"><?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
</button></li>
		<?php $_from = $this->_tpl_vars['EDITVIEW_CHECK_BUTTON']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['data']):
?>
			<li><?php echo $this->_tpl_vars['data']; ?>
</li>
		<?php endforeach; endif; unset($_from); ?>
		<?php if ($this->_tpl_vars['HASAPPROVALS'] == 'true' && $this->_tpl_vars['MODE'] == 'edit'): ?>
			<?php if ($this->_tpl_vars['READONLY'] == 'true' || $this->_tpl_vars['read_only'] == '1' || $this->_tpl_vars['APPROVALSTATUS'] == '1' || $this->_tpl_vars['APPROVALSTATUS'] == '2'): ?>
				<?php if ($this->_tpl_vars['APPROVALSTATUS'] != ''): ?>
					<li><a type="button" class="btn btn-default" data-icon="envelope-o" title="<?php echo $this->_tpl_vars['APP']['LBL_VIEWAPPROVALS_BUTTON_LABEL']; ?>
" href="index.php?module=Approvals&action=viewApprove&record=<?php echo $this->_tpl_vars['ID']; ?>
&formodule=<?php echo $this->_tpl_vars['MODULE']; ?>
"  data-title="<?php echo $this->_tpl_vars['APP']['LBL_VIEWAPPROVALS_BUTTON_LABEL']; ?>
" data-toggle="dialog" data-width="600" data-height="260" data-id="dialog-mask" data-mask="true" data-resizable="false" data-maxable="false"><?php echo $this->_tpl_vars['APP']['LBL_VIEWAPPROVALS_BUTTON_LABEL']; ?>
</a></li>
				<?php endif; ?>
			<?php else: ?>
				<li><a id="submitapprovals_btn" class="btn btn-default" data-icon="envelope" onclick="submitApprovals();" title="<?php echo $this->_tpl_vars['APP']['LBL_APPROVALS_BUTTON_LABEL']; ?>
" href="#"><?php echo $this->_tpl_vars['APP']['LBL_APPROVALS_BUTTON_LABEL']; ?>
</a></li>
			<?php endif; ?>
		<?php endif; ?>
    </ul>
</div>

<!-- Cropping modal -->
<div id="<?php echo $this->_tpl_vars['MODULE']; ?>
_upload_dialog_target" data-noinit="true" class="hide">
	<div class="bjui-pageContent" id="<?php echo $this->_tpl_vars['MODULE']; ?>
_upload_dialog"> 
		 <form class="avatar-form" action="Upload_crop.php" enctype="multipart/form-data" method="post"> 
	            <div class="avatar-body"> 
	                <!-- Upload image and data -->
	                <div class="avatar-upload">
	                    <input class="avatar-src" name="avatar_src" type="hidden"/>
	                    <input class="avatar-data" name="avatar_data" type="hidden"/> 
	                    <input class="avatar-input" accept="image/jpeg,image/gif,image/png" id="avatarInput" name="avatar_file" type="file"/>
	                </div> 
	                <!-- Crop and preview -->
	                <div class="row">
	                    <div class="col-md-9">
	                        <div class="avatar-wrapper"></div>
	                    </div>
	                    <div class="col-md-3">
	                        <div class="avatar-preview preview-lg"></div>
	                        <div class="avatar-preview preview-md"></div>
	                        <div class="avatar-preview preview-sm"></div>
	                    </div>
	                </div>

	                <div class="row avatar-btns">
	                    <div class="col-md-9">
	                        <div class="btn-group">
	                            <button class="btn btn-primary" data-method="rotate" data-option="-90" type="button" title="左旋90&deg;"><span class="fa fa-rotate-left"></span> 90&deg;</button>
	                            <button class="btn btn-primary" data-method="rotate" data-option="-15" type="button"><span class="fa fa-rotate-left"></span> 15&deg;</button>
	                            <button class="btn btn-primary" data-method="rotate" data-option="-30" type="button"><span class="fa fa-rotate-left"></span> 30&deg;</button>
	                            <button class="btn btn-primary" data-method="rotate" data-option="-45" type="button"><span class="fa fa-rotate-left"></span> 45&deg;</button>
	                        </div>
	                        <div class="btn-group" style="padding-left: 148px;">
	                            <button class="btn btn-primary" data-method="rotate" data-option="90" type="button" title="右旋90度"><span class="fa fa-rotate-right"></span> 90&deg;</button>
	                            <button class="btn btn-primary" data-method="rotate" data-option="15" type="button"><span class="fa fa-rotate-right"></span> 15&deg;</button>
	                            <button class="btn btn-primary" data-method="rotate" data-option="30" type="button"><span class="fa fa-rotate-right"></span> 30&deg;</button>
	                            <button class="btn btn-primary" data-method="rotate" data-option="45" type="button"><span class="fa fa-rotate-right"></span> 45&deg;</button>
	                        </div>
	                    </div> 
	                </div>
	            </div> 
	    </form>	 
	</div> 
	<div class="bjui-pageFooter" id="<?php echo $this->_tpl_vars['MODULE']; ?>
_upload_btn_dialog">
	    <ul>
			<li><button type="button" class="btn-close" data-icon="close">关闭</button></li> 
			<li><button type="submit" class="btn-green avatar-save" data-icon="upload">确定上传</button></li>
	    </ul>
	</div>
</div>
<!-- /.modal -->  


<script type="text/javascript">
	function submitApprovals() {
		if(!isUpdateWithForm()){
			$(this).dialog({
							   id:'dialog-mask',
							   url:'index.php?module=Approvals&action=viewApprove&record=<?php echo $this->_tpl_vars['ID']; ?>
&mode=submit&formodule=<?php echo $this->_tpl_vars['MODULE']; ?>
&from=editview',
							   title:'<?php echo $this->_tpl_vars['APP']['LBL_APPROVALS_BUTTON_LABEL']; ?>
',
							   width:600,
							   height:260,
							   mask:true,
							   resizable:false,
							   maxable:false
			});
		}
	}

	<?php echo $this->_tpl_vars['SCRIPT']; ?>

</script>

<script type="text/javascript">
	<?php echo '
	function isUpdateWithForm(){
		var isUpdate = false;
		$.CurrentNavtab.find("#salesEditViewForm").find("input").each(function(e,obj){
			if($(obj).data("value") != undefined)
			{
				if($(obj).attr("type") == "radio" || $(obj).attr("type") == "checkbox"){
					if($(obj).is(\':checked\')){
						if ($(obj).data("value") == "off"){
							isUpdate = true;
						}
					}else{
						if ($(obj).data("value") == "on"){
							isUpdate = true;
						}
					}
				}else
				{
					if ($(obj).data("value") != $(obj).val()){
						isUpdate = true;
					}
				}
			}
		});
		$.CurrentNavtab.find("#salesEditViewForm").find("select").each(function(e,obj){
			if($(obj).data("value") != undefined)
			{
				if ($(obj).data("value")!= $(obj).val()){
					isUpdate = true;
				}
			}
		});
		if(isUpdate){
			$(this).alertmsg("warn", "表单有更新,请保存后再试!", {autoClose: true, alertTimeout: 3000});
		}
		return isUpdate;
	}

	'; ?>

</script>
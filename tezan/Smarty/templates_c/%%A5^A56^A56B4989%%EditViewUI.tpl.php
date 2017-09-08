<?php /* Smarty version 2.6.18, created on 2017-07-31 11:05:51
         compiled from EditViewUI.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'math', 'EditViewUI.tpl', 60, false),array('modifier', 'strpos', 'EditViewUI.tpl', 62, false),array('modifier', 'count', 'EditViewUI.tpl', 84, false),)), $this); ?>

<?php $this->assign('popuptype', ($this->_tpl_vars['POPUPTYPE'])); ?>

<?php if ($this->_tpl_vars['uitype'] == 444 || $this->_tpl_vars['uitype'] == 56): ?>
    <?php $this->assign('fldlabel', ($this->_tpl_vars['maindata'][1][0])); ?>
<?php else: ?>
    <?php $this->assign('fldlabel', ($this->_tpl_vars['maindata'][1][0]).":"); ?>
<?php endif; ?>
<?php if ($this->_tpl_vars['uitype'] == 305): ?>
    <?php $this->assign('img_width', ($this->_tpl_vars['maindata'][4][2])); ?>
    <?php $this->assign('img_height', ($this->_tpl_vars['maindata'][4][3])); ?>
<?php endif; ?>
<?php $this->assign('fldlabel_sel', ($this->_tpl_vars['maindata'][1][1])); ?>
<?php $this->assign('fldlabel_combo', ($this->_tpl_vars['maindata'][1][2])); ?>
<?php $this->assign('fldlabel_other', ($this->_tpl_vars['maindata'][1][3])); ?>
<?php $this->assign('fldname', ($this->_tpl_vars['maindata'][2][0])); ?>
<?php $this->assign('fldvalue', ($this->_tpl_vars['maindata'][3][0])); ?>
<?php $this->assign('addlink', $this->_tpl_vars['maindata'][3]['addlink']); ?>
<?php $this->assign('secondvalue', ($this->_tpl_vars['maindata'][3][1])); ?>
<?php $this->assign('thirdvalue', ($this->_tpl_vars['maindata'][3][2])); ?>
<?php $this->assign('typeofdata', ($this->_tpl_vars['maindata'][4][0])); ?>
<?php $this->assign('mustofdata', ($this->_tpl_vars['maindata'][4][1])); ?>
<?php $this->assign('extenddata', ($this->_tpl_vars['maindata'][4])); ?>

<?php $this->assign('deputy_column', ($this->_tpl_vars['maindata'][5][0])); ?>			<?php $this->assign('merge_column', ($this->_tpl_vars['maindata'][6][0])); ?>				<?php $this->assign('show_title', ($this->_tpl_vars['maindata'][7][0])); ?>
<?php $this->assign('read_only', ($this->_tpl_vars['maindata'][8][0])); ?>
<?php $this->assign('field_unit', ($this->_tpl_vars['maindata'][9][0])); ?>
<?php $this->assign('edit_width', ($this->_tpl_vars['maindata'][10][0])); ?>
<?php $this->assign('vt_tab', ($this->_tpl_vars['maindata'][11][0])); ?>
<?php $this->assign('maxlength', ($this->_tpl_vars['maindata'][12][0])); ?>
<?php $this->assign('multiselect', ($this->_tpl_vars['maindata'][13][0])); ?>				<?php $this->assign('defaultvalue', ($this->_tpl_vars['maindata'][14][0])); ?> 			<?php $this->assign('remotevalidationfunc', ($this->_tpl_vars['maindata'][15][0])); ?>	<?php $this->assign('relation', ($this->_tpl_vars['maindata'][16][0])); ?>				<?php $this->assign('places', ($this->_tpl_vars['maindata'][200])); ?>					
<?php if (count ( $this->_tpl_vars['places'] ) > 0): ?>
    <?php $this->assign('deputy_field', 1); ?>
<?php endif; ?>

<?php if ($this->_tpl_vars['uitype'] == '444'): ?>
	<td colspan="<?php echo $this->_tpl_vars['blockcolumn']*2; ?>
" style="width: 100%">
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "uitype/".($this->_tpl_vars['uitype']).".tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	</td>
<?php else: ?>
	<td>
		<?php if ($this->_tpl_vars['show_title'] == '1'): ?>
			<?php if ($this->_tpl_vars['uitype'] == 56): ?>
				<label class="control-label x150" style="font-weight: normal;" for="<?php echo $this->_tpl_vars['fldname']; ?>
">&nbsp;</label>
			<?php else: ?>
				<label class="control-label x150" style="font-weight: normal;" for="<?php echo $this->_tpl_vars['fldname']; ?>
<?php if ($this->_tpl_vars['uitype'] == '10'): ?>_name<?php endif; ?>"><?php echo $this->_tpl_vars['fldlabel']; ?>
</label>
			<?php endif; ?>
		<?php endif; ?>
	</td>
	<?php if ($this->_tpl_vars['merge_column'] == '1'): ?>
		<td colspan="<?php echo $this->_tpl_vars['blockcolumn']*2-1; ?>
" style="width: 100%">
	<?php else: ?>
		<td style="width:<?php echo smarty_function_math(array('equation' => 'x / y','x' => 100,'y' => $this->_tpl_vars['blockcolumn']), $this);?>
%">
	<?php endif; ?>
	<?php if ($this->_tpl_vars['edit_width'] != '' && $this->_tpl_vars['edit_width'] != '0' && ((is_array($_tmp=$this->_tpl_vars['edit_width'])) ? $this->_run_mod_handler('strpos', true, $_tmp, "%") : strpos($_tmp, "%")) !== false): ?>
		<?php $this->assign('style', "width:".($this->_tpl_vars['edit_width']).";"); ?>
	<?php else: ?>
		<?php $this->assign('style', ""); ?>
	<?php endif; ?>

	<?php if ($this->_tpl_vars['uitype'] == '19'): ?>
		<?php if ($this->_tpl_vars['field_unit'] != '' && $this->_tpl_vars['style'] == ''): ?>
			<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;width:100%;">
		<?php else: ?>
			<?php if ($this->_tpl_vars['style'] != ''): ?>
				<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;<?php echo $this->_tpl_vars['style']; ?>
">
			<?php endif; ?>
		<?php endif; ?>
	<?php elseif ($this->_tpl_vars['uitype'] == '20' && $this->_tpl_vars['style'] == '' && $this->_tpl_vars['edit_width'] == ''): ?>
		<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;width:80%;">
	<?php elseif ($this->_tpl_vars['uitype'] != '70' && $this->_tpl_vars['uitype'] != '5' && $this->_tpl_vars['uitype'] != '60' && $this->_tpl_vars['uitype'] != '6' && $this->_tpl_vars['uitype'] != '23'): ?>
		<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;<?php echo $this->_tpl_vars['style']; ?>
">
	<?php endif; ?>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "uitype/".($this->_tpl_vars['uitype']).".tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

	<?php if (count($this->_tpl_vars['places']) > '0'): ?>
		<?php if ($this->_tpl_vars['uitype'] == '305'): ?>
			<?php $this->assign('isbottom', 1); ?>
		<?php else: ?>
			<?php if ($this->_tpl_vars['uitype'] == '19'): ?>
				<?php if ($this->_tpl_vars['field_unit'] != '' && $this->_tpl_vars['style'] == ''): ?>
					</span>
				<?php else: ?>
					<?php if ($this->_tpl_vars['style'] != ''): ?>
						</span>
					<?php endif; ?>
				<?php endif; ?>
			<?php elseif ($this->_tpl_vars['uitype'] == '20' && $this->_tpl_vars['style'] == '' && $this->_tpl_vars['edit_width'] == ''): ?>
				</span>
			<?php elseif ($this->_tpl_vars['uitype'] != '70' && $this->_tpl_vars['uitype'] != '5' && $this->_tpl_vars['uitype'] != '60' && $this->_tpl_vars['uitype'] != '6' && $this->_tpl_vars['uitype'] != '23'): ?>
				</span>
			<?php endif; ?>
		<?php endif; ?>
		<?php $_from = $this->_tpl_vars['places']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['pla']):
?>
			<?php $this->assign('uitype', ($this->_tpl_vars['pla'][0][0])); ?>
			<?php $this->assign('fldlabel', ($this->_tpl_vars['pla'][1][0])); ?>
			<?php $this->assign('fldlabel_sel', ($this->_tpl_vars['pla'][1][1])); ?>
			<?php $this->assign('fldlabel_combo', ($this->_tpl_vars['pla'][1][2])); ?>
			<?php $this->assign('fldlabel_other', ($this->_tpl_vars['pla'][1][3])); ?>
			<?php $this->assign('fldname', ($this->_tpl_vars['pla'][2][0])); ?>
			<?php $this->assign('fldvalue', ($this->_tpl_vars['pla'][3][0])); ?>
			<?php $this->assign('addlink', $this->_tpl_vars['pla'][3]['addlink']); ?>
			<?php $this->assign('secondvalue', ($this->_tpl_vars['pla'][3][1])); ?>
			<?php $this->assign('thirdvalue', ($this->_tpl_vars['pla'][3][2])); ?>
			<?php $this->assign('typeofdata', ($this->_tpl_vars['pla'][4][0])); ?>
			<?php $this->assign('mustofdata', ($this->_tpl_vars['pla'][4][1])); ?>
			<?php $this->assign('extenddata', ($this->_tpl_vars['pla'][4])); ?>

			<?php $this->assign('deputy_column', ($this->_tpl_vars['pla'][5][0])); ?>
			<?php $this->assign('merge_column', ($this->_tpl_vars['pla'][6][0])); ?>
			<?php $this->assign('show_title', ($this->_tpl_vars['pla'][7][0])); ?>
			<?php $this->assign('read_only', ($this->_tpl_vars['pla'][8][0])); ?>
			<?php $this->assign('field_unit', ($this->_tpl_vars['pla'][9][0])); ?>
			<?php $this->assign('edit_width', ($this->_tpl_vars['pla'][10][0])); ?>
			<?php $this->assign('vt_tab', ($this->_tpl_vars['pla'][11][0])); ?>
			<?php $this->assign('maxlength', ($this->_tpl_vars['pla'][12][0])); ?>
			<?php $this->assign('multiselect', ($this->_tpl_vars['pla'][13][0])); ?>
			<?php $this->assign('defaultvalue', ($this->_tpl_vars['pla'][14][0])); ?>
			<?php $this->assign('remotevalidationfunc', ($this->_tpl_vars['pla'][15][0])); ?>
			<?php $this->assign('relation', ($this->_tpl_vars['pla'][16][0])); ?>
			<?php $this->assign('places', ($this->_tpl_vars['pla'][200])); ?>

			<?php if ($this->_tpl_vars['isbottom'] == '1'): ?>
				<span style="position: absolute;bottom: 2px;">
			<?php endif; ?>
			<?php if ($this->_tpl_vars['show_title'] == '1'): ?>
				<?php if ($this->_tpl_vars['isbottom'] == '1'): ?>
					<label class="control-label"  style="font-weight: normal;" for="<?php echo $this->_tpl_vars['fldname']; ?>
<?php if ($this->_tpl_vars['uitype'] == '10'): ?>_name<?php endif; ?>"><?php if ($this->_tpl_vars['uitype'] == 56): ?>"&nbsp;"<?php else: ?><?php echo $this->_tpl_vars['fldlabel']; ?>
<?php endif; ?></label>
						<?php else: ?>
							<label class="control-label x85"  style="font-weight: normal;" for="<?php echo $this->_tpl_vars['fldname']; ?>
<?php if ($this->_tpl_vars['uitype'] == '10'): ?>_name<?php endif; ?>"><?php if ($this->_tpl_vars['uitype'] == 56): ?>"&nbsp;"<?php else: ?><?php echo $this->_tpl_vars['fldlabel']; ?>
<?php endif; ?></label>
				<?php endif; ?>
			<?php endif; ?>
			<?php if ($this->_tpl_vars['edit_width'] != '' && $this->_tpl_vars['edit_width'] != '0' && ((is_array($_tmp=$this->_tpl_vars['edit_width'])) ? $this->_run_mod_handler('strpos', true, $_tmp, "%") : strpos($_tmp, "%")) !== false): ?>
				<?php $this->assign('style', "width:".($this->_tpl_vars['edit_width']).";"); ?>
			<?php else: ?>
				<?php $this->assign('style', ""); ?>
			<?php endif; ?>
			<?php if ($this->_tpl_vars['uitype'] == '19'): ?>
				<?php if ($this->_tpl_vars['field_unit'] != '' && $this->_tpl_vars['style'] == ''): ?>
					<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;width:100%;">
				<?php else: ?>
					<?php if ($this->_tpl_vars['style'] != ''): ?>
						<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;<?php echo $this->_tpl_vars['style']; ?>
">
					<?php endif; ?>
				<?php endif; ?>
			<?php elseif ($this->_tpl_vars['uitype'] == '20' && $this->_tpl_vars['style'] == '' && $this->_tpl_vars['edit_width'] == ''): ?>
				<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;width:80%;">
			<?php elseif ($this->_tpl_vars['uitype'] != '70' && $this->_tpl_vars['uitype'] != '5' && $this->_tpl_vars['uitype'] != '60' && $this->_tpl_vars['uitype'] != '6' && $this->_tpl_vars['uitype'] != '23'): ?>
				<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;<?php echo $this->_tpl_vars['style']; ?>
">
			<?php endif; ?>

			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "uitype/".($this->_tpl_vars['uitype']).".tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

			<?php if ($this->_tpl_vars['isbottom'] == '1'): ?>
				</span>
			<?php endif; ?>
			<?php if ($this->_tpl_vars['uitype'] == '19'): ?>
				<?php if ($this->_tpl_vars['field_unit'] != '' && $this->_tpl_vars['style'] == ''): ?>
					</span>
				<?php else: ?>
					<?php if ($this->_tpl_vars['style'] != ''): ?>
						</span>
					<?php endif; ?>
				<?php endif; ?>
			<?php elseif ($this->_tpl_vars['uitype'] == '20' && $this->_tpl_vars['style'] == '' && $this->_tpl_vars['edit_width'] == ''): ?>
				</span>
			<?php elseif ($this->_tpl_vars['uitype'] != '70' && $this->_tpl_vars['uitype'] != '5' && $this->_tpl_vars['uitype'] != '60' && $this->_tpl_vars['uitype'] != '6' && $this->_tpl_vars['uitype'] != '23'): ?>
				</span>
			<?php endif; ?>
		<?php endforeach; endif; unset($_from); ?>
	<?php endif; ?>
	<?php if (count($this->_tpl_vars['places']) == '0' || $this->_tpl_vars['isbottom'] != '1'): ?>
		<?php if ($this->_tpl_vars['uitype'] == '19'): ?>
			<?php if ($this->_tpl_vars['field_unit'] != '' && $this->_tpl_vars['style'] == ''): ?>
				</span>
			<?php else: ?>
				<?php if ($this->_tpl_vars['style'] != ''): ?>
					</span>
				<?php endif; ?>
			<?php endif; ?>
		<?php elseif ($this->_tpl_vars['uitype'] == '20' && $this->_tpl_vars['style'] == '' && $this->_tpl_vars['edit_width'] == ''): ?>
			</span>
		<?php elseif ($this->_tpl_vars['uitype'] != '70' && $this->_tpl_vars['uitype'] != '5' && $this->_tpl_vars['uitype'] != '60' && $this->_tpl_vars['uitype'] != '6' && $this->_tpl_vars['uitype'] != '23'): ?>
			</span>
		<?php endif; ?>
	<?php endif; ?>
	</td>
<?php endif; ?>

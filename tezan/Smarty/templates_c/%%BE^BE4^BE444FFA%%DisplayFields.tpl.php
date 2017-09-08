<?php /* Smarty version 2.6.18, created on 2017-07-31 11:05:51
         compiled from DisplayFields.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'math', 'DisplayFields.tpl', 27, false),)), $this); ?>


<?php $this->assign('fromlink', ""); ?>

<?php $this->assign('blockcolumn', $this->_tpl_vars['data']['0']); ?>

<?php $_from = $this->_tpl_vars['data']['1']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['label'] => $this->_tpl_vars['subdata']):
?>
	<?php $this->assign('cid', ($this->_tpl_vars['subdata'][0][2][0])); ?> 
	<?php if ($this->_tpl_vars['HIDDENFIELDS'][$this->_tpl_vars['cid']]): ?>
		<tr style="display:none;" id="cid_<?php echo $this->_tpl_vars['cid']; ?>
">
	<?php else: ?>
		<tr id="cid_<?php echo $this->_tpl_vars['cid']; ?>
">
	<?php endif; ?>
	<?php $this->assign('tdindex', 0); ?>
	<?php $_from = $this->_tpl_vars['subdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['subdata'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['subdata']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['mainlabel'] => $this->_tpl_vars['maindata']):
        $this->_foreach['subdata']['iteration']++;
?>		
		<?php $this->assign('uitype', ($this->_tpl_vars['maindata'][0][0])); ?>
		<?php $this->assign('merge_column', ($this->_tpl_vars['maindata'][6][0])); ?>
		<?php if ($this->_tpl_vars['merge_column'] == '1'): ?>
			<?php $this->assign('tdindex', $this->_tpl_vars['blockcolumn']*2); ?>
		<?php else: ?>
			<?php $this->assign('tdindex', $this->_tpl_vars['tdindex']+2); ?>
		<?php endif; ?>
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'EditViewUI.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<?php endforeach; endif; unset($_from); ?>
	<?php if ($this->_tpl_vars['tdindex'] < $this->_tpl_vars['blockcolumn']*2): ?>
		<td>&nbsp;</td>
		<td style="width:<?php echo smarty_function_math(array('equation' => 'x / y','x' => 100,'y' => $this->_tpl_vars['blockcolumn']), $this);?>
%"></td>
	<?php endif; ?>
	</tr>
<?php endforeach; endif; unset($_from); ?>
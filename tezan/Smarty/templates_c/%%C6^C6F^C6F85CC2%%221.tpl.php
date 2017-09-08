<?php /* Smarty version 2.6.18, created on 2017-05-08 10:38:03
         compiled from uitype/221.tpl */ ?>
<div id="slabel">
	<?php $this->assign('i', 0); ?>
	<?php $_from = $this->_tpl_vars['fldvalue']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arr']):
?>
		<?php $this->assign('i', $this->_tpl_vars['i']+1); ?> 
		<input data-toggle="icheck"  data-label="<?php echo $this->_tpl_vars['arr'][0]; ?>
" <?php echo $this->_tpl_vars['style']; ?>
 <?php if ($this->_tpl_vars['READONLY'] == 'true'): ?> disabled="true" <?php endif; ?> <?php if ($this->_tpl_vars['read_only'] == '1'): ?>onclick="return false;"<?php endif; ?> tabindex="<?php echo $this->_tpl_vars['vt_tab']; ?>
" type="checkbox" value="<?php echo $this->_tpl_vars['arr'][1]; ?>
" data-value="<?php echo $this->_tpl_vars['arr'][1]; ?>
" id="<?php echo $this->_tpl_vars['fldname']; ?>
_<?php echo $this->_tpl_vars['i']; ?>
" name="<?php echo $this->_tpl_vars['fldname']; ?>
[]" <?php if ($this->_tpl_vars['arr'][2] == 'selected'): ?> checked <?php endif; ?>><br>
	 <?php endforeach; endif; unset($_from); ?>
</div>
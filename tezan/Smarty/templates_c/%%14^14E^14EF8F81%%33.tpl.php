<?php /* Smarty version 2.6.18, created on 2017-07-31 11:05:51
         compiled from uitype/33.tpl */ ?>

<?php $this->assign('i', 0); ?>
<?php $_from = $this->_tpl_vars['fldvalue']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['foreachname'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foreachname']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['arr']):
        $this->_foreach['foreachname']['iteration']++;
?>
	<?php $this->assign('i', $this->_tpl_vars['i']+1); ?>
	<?php if ($this->_tpl_vars['MODE'] == 'create' && $this->_tpl_vars['defaultvalue'] != '' && $this->_tpl_vars['defaultvalue'] == $this->_tpl_vars['arr'][1]): ?>
		<?php $this->assign('selected', 'selected'); ?>
	<?php elseif ($this->_tpl_vars['i'] == 1 && $this->_tpl_vars['MODE'] == 'create'): ?>
		<?php $this->assign('selected', 'selected'); ?>
	<?php else: ?>
		<?php $this->assign('selected', $this->_tpl_vars['arr'][2]); ?>
	<?php endif; ?>
	<input type="radio"
		name="<?php echo $this->_tpl_vars['fldname']; ?>
" 
		id="<?php echo $this->_tpl_vars['fldname']; ?>
_<?php echo $this->_tpl_vars['i']; ?>
"
	    class="<?php echo $this->_tpl_vars['fldname']; ?>
"
		<?php if ($this->_tpl_vars['READONLY'] == 'true' || $this->_tpl_vars['read_only'] == '1'): ?>
			disabled
		<?php endif; ?>
		<?php if ($this->_tpl_vars['selected'] == 'selected'): ?>
			data-value="on"
			checked
		<?php else: ?>
			data-value="off"
		<?php endif; ?>
		tabindex="<?php echo $this->_tpl_vars['vt_tab']; ?>
"
		value="<?php echo $this->_tpl_vars['arr'][1]; ?>
"
		data-toggle="icheck"
		<?php if ($this->_tpl_vars['mustofdata'] == 'M' && $this->_tpl_vars['READONLY'] != 'true' && $this->_tpl_vars['read_only'] != '1'): ?>
			data-rule="checked"
			<?php if (($this->_foreach['foreachname']['iteration'] == $this->_foreach['foreachname']['total'])): ?>
		   		data-label="<?php echo $this->_tpl_vars['arr'][0]; ?>
&nbsp;<font color=red>*</font>"
			<?php else: ?>
				data-label="<?php echo $this->_tpl_vars['arr'][0]; ?>
&nbsp;<font color=red>*</font>"
			<?php endif; ?>
		<?php else: ?>
			data-label=<?php echo $this->_tpl_vars['arr'][0]; ?>

	    <?php endif; ?>
		/>
<?php endforeach; endif; unset($_from); ?>
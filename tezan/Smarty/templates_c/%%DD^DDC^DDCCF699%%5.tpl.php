<?php /* Smarty version 2.6.18, created on 2017-07-31 11:05:51
         compiled from uitype/5.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'strpos', 'uitype/5.tpl', 16, false),)), $this); ?>

<?php if ($this->_tpl_vars['style'] != ''): ?>
	<?php if ($this->_tpl_vars['field_unit'] != ''): ?>
		<?php $this->assign('editwidth', "width:90%;"); ?>
	<?php else: ?>
		<?php $this->assign('editwidth', "width:100%;"); ?>
	<?php endif; ?>
<?php else: ?>
	<?php if ($this->_tpl_vars['edit_width'] != '' && $this->_tpl_vars['edit_width'] != '0'): ?>
		<?php if (((is_array($_tmp=$this->_tpl_vars['edit_width'])) ? $this->_run_mod_handler('strpos', true, $_tmp, 'px') : strpos($_tmp, 'px')) !== false): ?>
			<?php $this->assign('editwidth', "width:".($this->_tpl_vars['edit_width']).";"); ?>
		<?php else: ?>
			<?php $this->assign('px', 'px'); ?>
			<?php $this->assign('editwidth', "width:".($this->_tpl_vars['edit_width']).($this->_tpl_vars['px']).";"); ?>
		<?php endif; ?>
	<?php else: ?>
		<?php $this->assign('editwidth', ""); ?>
	<?php endif; ?>
<?php endif; ?>

<?php $_from = $this->_tpl_vars['fldvalue']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['date_value'] => $this->_tpl_vars['time_value']):
?>
	<?php $this->assign('date_val', ($this->_tpl_vars['date_value'])); ?>
	<?php $this->assign('time_val', ($this->_tpl_vars['time_value'])); ?>
<?php endforeach; endif; unset($_from); ?>
<?php $_from = $this->_tpl_vars['secondvalue']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['date_format'] => $this->_tpl_vars['date_str']):
?>
	<?php $this->assign('dateFormat', ($this->_tpl_vars['date_format'])); ?>
	<?php $this->assign('dateStr', ($this->_tpl_vars['date_str'])); ?>
<?php endforeach; endif; unset($_from); ?>
<?php if ($this->_tpl_vars['READONLY'] == 'true' || $this->_tpl_vars['read_only'] == '1'): ?>
	<input maxlength="<?php echo $this->_tpl_vars['maxlength']; ?>
"
			readonly
			<?php if ($this->_tpl_vars['editwidth'] == ''): ?>
				<?php if ($this->_tpl_vars['uitype'] == '5' || $this->_tpl_vars['uitype'] == '70'): ?>
					size='11'
				<?php elseif ($this->_tpl_vars['uitype'] == '6' || $this->_tpl_vars['uitype'] == '60'): ?>
					size='19'
				<?php elseif ($this->_tpl_vars['uitype'] == '23'): ?>
					size='9'
				<?php endif; ?>
			<?php endif; ?>
		   type="text"
		   tabindex="<?php echo $this->_tpl_vars['vt_tab']; ?>
"
		   name="<?php echo $this->_tpl_vars['fldname']; ?>
"
		   id ="<?php echo $this->_tpl_vars['fldname']; ?>
"
		   data-value="<?php echo $this->_tpl_vars['date_value']; ?>
"
		   value="<?php echo $this->_tpl_vars['date_value']; ?>
"
	/>
<?php else: ?>
	<input maxlength="<?php echo $this->_tpl_vars['maxlength']; ?>
"
			<?php if ($this->_tpl_vars['editwidth'] == ''): ?>
				<?php if ($this->_tpl_vars['uitype'] == '5' || $this->_tpl_vars['uitype'] == '70'): ?>
					size='11'
				<?php elseif ($this->_tpl_vars['uitype'] == '6' || $this->_tpl_vars['uitype'] == '60'): ?>
					size='19'
				<?php elseif ($this->_tpl_vars['uitype'] == '23'): ?>
					size='9'
				<?php endif; ?>
			<?php endif; ?>
		   type="text"
		   tabindex="<?php echo $this->_tpl_vars['vt_tab']; ?>
"
		   name="<?php echo $this->_tpl_vars['fldname']; ?>
"
		   id ="<?php echo $this->_tpl_vars['fldname']; ?>
"
		   data-value="<?php echo $this->_tpl_vars['date_value']; ?>
"
		   value="<?php echo $this->_tpl_vars['date_value']; ?>
"
		   style="<?php echo $this->_tpl_vars['editwidth']; ?>
padding-right: 15px;<?php if ($this->_tpl_vars['READONLY'] != 'true' && $this->_tpl_vars['read_only'] != '1'): ?>cursor: pointer;<?php endif; ?>"
			<?php if ($this->_tpl_vars['READONLY'] != 'true' && $this->_tpl_vars['read_only'] != '1'): ?>
				<?php if ($this->_tpl_vars['uitype'] == '5' || $this->_tpl_vars['uitype'] == '70'): ?>
					data-rule="<?php if ($this->_tpl_vars['mustofdata'] == 'M'): ?>required;<?php endif; ?>date;"
				<?php elseif ($this->_tpl_vars['uitype'] == '6'): ?>
					data-rule="<?php if ($this->_tpl_vars['mustofdata'] == 'M'): ?>required;<?php endif; ?>datetime;"
				<?php elseif ($this->_tpl_vars['uitype'] == '60'): ?>
					data-rule="<?php if ($this->_tpl_vars['mustofdata'] == 'M'): ?>required;<?php endif; ?>simpledatetime;"
				<?php elseif ($this->_tpl_vars['uitype'] == '23'): ?>
					data-rule="<?php if ($this->_tpl_vars['mustofdata'] == 'M'): ?>required;<?php endif; ?>time;"
				<?php endif; ?>
			<?php endif; ?>
		   data-toggle="datepicker"
			<?php if ($this->_tpl_vars['uitype'] == '5' || $this->_tpl_vars['uitype'] == '70'): ?>
				data-pattern="yyyy-MM-dd"
			<?php elseif ($this->_tpl_vars['uitype'] == '6'): ?>
				data-pattern="yyyy-MM-dd HH:mm:ss"
			<?php elseif ($this->_tpl_vars['uitype'] == '60'): ?>
				data-pattern="yyyy-MM-dd HH:mm"
			<?php elseif ($this->_tpl_vars['uitype'] == '23'): ?>
				data-pattern="HH:mm:ss"
			<?php endif; ?>
		   class="<?php if ($this->_tpl_vars['mustofdata'] == 'M' && $this->_tpl_vars['READONLY'] != 'true'): ?>required<?php endif; ?>"
	/>
	<?php if ($this->_tpl_vars['uitype'] == '70' && $this->_tpl_vars['READONLY'] != 'true' && $this->_tpl_vars['read_only'] != '1'): ?>
		<span  style="margin-left:-3px;z-index:-1;">
		<a class="btn btn-default" onclick="$.CurrentNavtab.find('#<?php echo $this->_tpl_vars['fldname']; ?>
').val('2099-12-31');">长期</a>
	</span>
	<?php endif; ?>
<?php endif; ?>
<?php if ($this->_tpl_vars['field_unit'] != ''): ?>
	<span  style="padding:0px 2px;margin-left:3px;z-index:-1;"><?php echo $this->_tpl_vars['field_unit']; ?>
</span>
<?php endif; ?>
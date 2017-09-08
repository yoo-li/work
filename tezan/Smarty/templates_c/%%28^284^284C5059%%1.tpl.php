<?php /* Smarty version 2.6.18, created on 2017-07-31 11:05:51
         compiled from uitype/1.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'strpos', 'uitype/1.tpl', 12, false),array('modifier', 'default', 'uitype/1.tpl', 67, false),)), $this); ?>

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
<?php if ($this->_tpl_vars['READONLY'] != 'true' && $this->_tpl_vars['read_only'] != '1' && $this->_tpl_vars['fldvalue'] == ''): ?>
	<?php $this->assign('fldvalue', $this->_tpl_vars['defaultvalue']); ?>
<?php endif; ?>

<?php if ($this->_tpl_vars['mustofdata'] == 'M'): ?>
	<?php $this->assign('dataRule', "required;"); ?>
<?php endif; ?>
<?php if ($this->_tpl_vars['typeofdata'] == 'NN'): ?>
	<?php $this->assign('dataRule', ($this->_tpl_vars['dataRule'])."+\"number;\""); ?>
	<?php if ($this->_tpl_vars['extenddata'][2] != '' && $this->_tpl_vars['extenddata'][3] != ''): ?>
		<?php $this->assign('dataRule', ($this->_tpl_vars['dataRule'])."+\"range[".($this->_tpl_vars['extenddata'][2])."~".($this->_tpl_vars['extenddata'][3])."];\""); ?>
	<?php elseif ($this->_tpl_vars['extenddata'][2] != ''): ?>
		<?php $this->assign('dataRule', ($this->_tpl_vars['dataRule'])."+\"range[".($this->_tpl_vars['extenddata'][2])."~];\""); ?>
	<?php elseif ($this->_tpl_vars['extenddata'][3] != ''): ?>
		<?php $this->assign('dataRule', ($this->_tpl_vars['dataRule'])."+\"range[~".($this->_tpl_vars['extenddata'][3])."];\""); ?>
	<?php endif; ?>
<?php elseif ($this->_tpl_vars['typeofdata'] == 'IN'): ?>
	<?php $this->assign('dataRule', ($this->_tpl_vars['dataRule'])."+\"digits;\""); ?>
	<?php if ($this->_tpl_vars['extenddata'][2] != '' && $this->_tpl_vars['extenddata'][3] != ''): ?>
		<?php $this->assign('dataRule', ($this->_tpl_vars['dataRule'])."+\"range[".($this->_tpl_vars['extenddata'][2])."~".($this->_tpl_vars['extenddata'][3])."];\""); ?>
	<?php elseif ($this->_tpl_vars['extenddata'][2] != ''): ?>
		<?php $this->assign('dataRule', ($this->_tpl_vars['dataRule'])."+\"range[".($this->_tpl_vars['extenddata'][2])."~];\""); ?>
	<?php elseif ($this->_tpl_vars['extenddata'][3] != ''): ?>
		<?php $this->assign('dataRule', ($this->_tpl_vars['dataRule'])."+\"range[~".($this->_tpl_vars['extenddata'][3])."];\""); ?>
	<?php endif; ?>
<?php elseif ($this->_tpl_vars['typeofdata'] == 'MONEY'): ?>
	<?php $this->assign('dataRule', ($this->_tpl_vars['dataRule'])."+\"number;money;\""); ?>
<?php elseif ($this->_tpl_vars['typeofdata'] == 'MO'): ?>
	<?php $this->assign('dataRule', ($this->_tpl_vars['dataRule'])."+\"mobile;\""); ?>
<?php elseif ($this->_tpl_vars['typeofdata'] == 'EM'): ?>
	<?php $this->assign('dataRule', ($this->_tpl_vars['dataRule'])."+\"email;\""); ?>
<?php elseif ($this->_tpl_vars['typeofdata'] == 'ID'): ?>
	<?php $this->assign('dataRule', ($this->_tpl_vars['dataRule'])."+\"ID_card;\""); ?>
<?php elseif ($this->_tpl_vars['typeofdata'] == 'LF' || $this->_tpl_vars['typeofdata'] == 'SF'): ?>
	<?php $this->assign('dataRule', ($this->_tpl_vars['dataRule'])."+\"number;\""); ?>
<?php elseif ($this->_tpl_vars['typeofdata'] == 'PH'): ?>
	<?php $this->assign('dataRule', ($this->_tpl_vars['dataRule'])."+\"tel;\""); ?>
<?php elseif ($this->_tpl_vars['typeofdata'] == 'QQ'): ?>
	<?php $this->assign('dataRule', ($this->_tpl_vars['dataRule'])."+\"qq;\""); ?>
<?php endif; ?>
<?php if ($this->_tpl_vars['remotevalidationfunc'] != ''): ?>
	<?php $this->assign('dataRule', ($this->_tpl_vars['dataRule'])."+\"remote_validation;\""); ?>
<?php endif; ?>

<?php if ($this->_tpl_vars['uitype'] == '17'): ?>
	<?php $this->assign('fldvalue', ((is_array($_tmp=@$this->_tpl_vars['fldvalue'])) ? $this->_run_mod_handler('default', true, $_tmp, '') : smarty_modifier_default($_tmp, ''))); ?>
<?php endif; ?>

<input maxlength="<?php echo $this->_tpl_vars['maxlength']; ?>
"
		<?php if ($this->_tpl_vars['read_only'] == '1' || $this->_tpl_vars['READONLY'] == 'true'): ?>
			readOnly
		<?php endif; ?>
		<?php if ($this->_tpl_vars['editwidth'] == ''): ?>
			size='20'
		<?php endif; ?>
		type="text"
		tabindex="<?php echo $this->_tpl_vars['vt_tab']; ?>
"
		name="<?php echo $this->_tpl_vars['fldname']; ?>
"
		id="<?php echo $this->_tpl_vars['fldname']; ?>
"
	    data-value="<?php echo $this->_tpl_vars['fldvalue']; ?>
"
		value="<?php echo $this->_tpl_vars['fldvalue']; ?>
"
		style="<?php echo $this->_tpl_vars['editwidth']; ?>
<?php if ($this->_tpl_vars['mustofdata'] == 'M'): ?>padding-right: 15px;<?php endif; ?>"
		<?php if ($this->_tpl_vars['READONLY'] != 'true' && $this->_tpl_vars['read_only'] != '1'): ?>
			<?php if ($this->_tpl_vars['dataRule'] != ''): ?>
				data-rule=<?php echo $this->_tpl_vars['dataRule']; ?>

			<?php endif; ?>
			<?php if ($this->_tpl_vars['remotevalidationfunc'] != ''): ?>
				data-rule-remote_validation="<?php echo $this->_tpl_vars['fldname']; ?>
remote_validation_func"
			<?php endif; ?>
			<?php if ($this->_tpl_vars['mustofdata'] == 'M'): ?>
				class="required"
			<?php endif; ?>
		<?php endif; ?>
	   />
<?php if ($this->_tpl_vars['field_unit'] != ''): ?>
	<span  style="padding:0px 2px;margin-left:3px;z-index:-1;"><?php echo $this->_tpl_vars['field_unit']; ?>
</span>
<?php endif; ?>
<?php if ($this->_tpl_vars['remotevalidationfunc'] != ''): ?>
	<script language="javascript" type="text/javascript">
		function <?php echo $this->_tpl_vars['fldname']; ?>
remote_validation_func()
		{
			if (typeof(<?php echo $this->_tpl_vars['remotevalidationfunc']; ?>
) == "function")
			{
				return <?php echo $this->_tpl_vars['remotevalidationfunc']; ?>
("#<?php echo $this->_tpl_vars['fldname']; ?>
");
			}
			else
			{
				return "远程序验证函数不存在";
				}
			}
	</script>
<?php endif; ?>
<?php /* Smarty version 2.6.18, created on 2017-08-14 11:12:56
         compiled from uitype/115.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'strpos', 'uitype/115.tpl', 13, false),array('modifier', 'substr', 'uitype/115.tpl', 55, false),)), $this); ?>

<?php if ($this->_tpl_vars['style'] != ''): ?>
	<?php if ($this->_tpl_vars['field_unit'] != ''): ?>
		<?php $this->assign('editwidth', "data-width='90%'"); ?>
	<?php else: ?>
		<?php $this->assign('editwidth', "data-width='100%'"); ?>
	<?php endif; ?>
<?php else: ?>
	<?php if ($this->_tpl_vars['edit_width'] != '' && $this->_tpl_vars['edit_width'] != '0'): ?>
		<?php if (((is_array($_tmp=$this->_tpl_vars['edit_width'])) ? $this->_run_mod_handler('strpos', true, $_tmp, 'px') : strpos($_tmp, 'px')) !== false || ((is_array($_tmp=$this->_tpl_vars['edit_width'])) ? $this->_run_mod_handler('strpos', true, $_tmp, "%") : strpos($_tmp, "%")) !== false): ?>
			<?php $this->assign('editwidth', "data-width='".($this->_tpl_vars['edit_width'])."'"); ?>
		<?php else: ?>
			<?php $this->assign('px', 'px'); ?>
			<?php $this->assign('editwidth', "data-width='".($this->_tpl_vars['edit_width']).($this->_tpl_vars['px'])."'"); ?>
		<?php endif; ?>
	<?php else: ?>
		<?php $this->assign('editwidth', "data-width='200px'"); ?>
	<?php endif; ?>
<?php endif; ?>
<?php $this->assign('selectvalue', ""); ?>
<?php $_from = $this->_tpl_vars['fldvalue']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arr']):
?>
	<?php if ($this->_tpl_vars['arr'][2] != ''): ?>
		<?php $this->assign('selectvalue', ($this->_tpl_vars['arr'][1])); ?>
	<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>

<select data-toggle="selectpicker"
	name="<?php echo $this->_tpl_vars['fldname']; ?>
" 
	id="<?php echo $this->_tpl_vars['fldname']; ?>
" 
	tabindex="<?php echo $this->_tpl_vars['vt_tab']; ?>
" 
	<?php echo $this->_tpl_vars['editwidth']; ?>

	<?php if ($_REQUEST['record'] != $this->_tpl_vars['APPLICATOR_CREATOR'] && $this->_tpl_vars['CURRENT_USERID'] != $_REQUEST['record']): ?>
		<?php if ($this->_tpl_vars['READONLY'] == 'true' || $this->_tpl_vars['read_only'] == '1'): ?>
			disabled
		<?php else: ?>
			<?php if ($this->_tpl_vars['addlink'] == '1'): ?> 
				onChange="add_new_picklist(this,'<?php echo $this->_tpl_vars['fldname']; ?>
','<?php echo $this->_tpl_vars['fldlabel']; ?>
');"
			<?php endif; ?>
		<?php endif; ?>
	<?php else: ?>
		disabled
	<?php endif; ?>
	<?php if ($this->_tpl_vars['mustofdata'] == 'M' && $this->_tpl_vars['READONLY'] != 'true' && $this->_tpl_vars['read_only'] != '1'): ?>
		data-rule="required;"
	<?php endif; ?>
	data-value="<?php echo $this->_tpl_vars['selectvalue']; ?>
"
	>
	<?php $_from = $this->_tpl_vars['fldvalue']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arr']):
?>
		<?php if ($this->_tpl_vars['arr'][0] == $this->_tpl_vars['APP']['LBL_NOT_ACCESSIBLE']): ?>
		<option value="<?php echo $this->_tpl_vars['arr'][0]; ?>
" <?php echo $this->_tpl_vars['arr'][2]; ?>
> <?php echo $this->_tpl_vars['arr'][0]; ?>
 </option>
		<?php else: ?>
			<?php if (((is_array($_tmp=$this->_tpl_vars['arr'][1])) ? $this->_run_mod_handler('substr', true, $_tmp, 0, 4) : substr($_tmp, 0, 4)) == 'add_'): ?>
				<option style="color:blue;" value="<?php echo $this->_tpl_vars['arr'][1]; ?>
" <?php echo $this->_tpl_vars['arr'][2]; ?>
> <?php echo $this->_tpl_vars['arr'][0]; ?>
 </option>
			<?php else: ?>
				<option value="<?php echo $this->_tpl_vars['arr'][1]; ?>
" <?php echo $this->_tpl_vars['arr'][2]; ?>
> <?php echo $this->_tpl_vars['arr'][0]; ?>
 </option>
        	<?php endif; ?>
		<?php endif; ?>
	<?php endforeach; else: ?>
		<option value=""></option>
		<option value="" style='color: #777777' disabled> <?php echo $this->_tpl_vars['APP']['LBL_NONE']; ?>
 </option>
	<?php endif; unset($_from); ?>
</select>
<?php if ($this->_tpl_vars['field_unit'] != ''): ?>
	<span  style="padding:0px 2px;margin-left:3px;z-index:-1;"><?php echo $this->_tpl_vars['field_unit']; ?>
</span>
<?php endif; ?>
<?php if ($_REQUEST['record'] != $this->_tpl_vars['APPLICATOR_CREATOR'] && $this->_tpl_vars['CURRENT_USERID'] != $_REQUEST['record'] && $this->_tpl_vars['READONLY'] != 'true' && $this->_tpl_vars['read_only'] != '1' && $this->_tpl_vars['addlink'] == '1'): ?>
	<script language="javascript" type="text/javascript">
	<?php echo '
		function add_new_picklist(obj,pname,label){
			if(obj.value.indexOf("add_")>=0){
				var pv = obj.value.split("_");
				$(obj).get(0).selectedIndex = 0;
				$(obj).selectpicker(\'render\');
				$(obj).dialog({
					id:\'addnew_picklist_dialog\',
					url:"index.php?module=Settings&action=EditViewAddPicklist&operatingtype=add&picklist="+pv[1]+"&sequence="+$(obj)[0].options.length+"&add_module="+$("#module").val(),
					title:label,
					width:420,
					height:250,
					mask:true,
					resizable:false,
					maxable:false
				});
			}
		}
	'; ?>

	</script>
<?php endif; ?>
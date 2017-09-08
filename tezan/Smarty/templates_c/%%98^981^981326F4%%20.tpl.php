<?php /* Smarty version 2.6.18, created on 2017-06-28 18:57:36
         compiled from uitype/20.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'strpos', 'uitype/20.tpl', 19, false),)), $this); ?>
 

<?php if ($this->_tpl_vars['style'] != ''): ?>
	<?php $this->assign('editwidth', "width:100%;"); ?>
<?php else: ?>
	<?php if ($this->_tpl_vars['edit_width'] != '' && $this->_tpl_vars['edit_width'] != '0'): ?>
		<?php if (((is_array($_tmp=$this->_tpl_vars['edit_width'])) ? $this->_run_mod_handler('strpos', true, $_tmp, 'px') : strpos($_tmp, 'px')) !== false): ?>
			<?php $this->assign('editwidth', "width:".($this->_tpl_vars['edit_width']).";"); ?>
		<?php else: ?>
			<?php $this->assign('px', 'px'); ?>
			<?php $this->assign('editwidth', "width:".($this->_tpl_vars['edit_width']).($this->_tpl_vars['px']).";"); ?>
		<?php endif; ?>
	<?php else: ?>
		<?php $this->assign('editwidth', "width:100%;"); ?>
	<?php endif; ?>
<?php endif; ?>

<script 
	type="text/plain" 
	name="<?php echo $this->_tpl_vars['fldname']; ?>
" 
	id="<?php echo $this->_tpl_vars['fldname']; ?>
" 
	data-toggle="ueditor" 
	data-maxlength="<?php echo $this->_tpl_vars['maxlength']; ?>
"
	<?php if ($this->_tpl_vars['read_only'] == '1' || $this->_tpl_vars['READONLY'] == 'true'): ?>
		data-readonly="true"
	<?php endif; ?>
	style="<?php echo $this->_tpl_vars['editwidth']; ?>
min-height:200px;"><?php echo $this->_tpl_vars['fldvalue']; ?>
</script>
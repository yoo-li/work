<?php /* Smarty version 2.6.18, created on 2017-07-31 11:05:51
         compiled from uitype/56.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'substr', 'uitype/56.tpl', 8, false),)), $this); ?>
<?php $this->assign('datavalue', 'off'); ?>
<?php if ($this->_tpl_vars['fldvalue'] == 1 && $this->_tpl_vars['MODE'] == 'create'): ?>						
	<?php $this->assign('selected', 'checked'); ?>
	<?php $this->assign('datavalue', 'on'); ?>
<?php elseif (( $this->_tpl_vars['PROD_MODE'] == 'create' && ((is_array($_tmp=$this->_tpl_vars['fldname'])) ? $this->_run_mod_handler('substr', true, $_tmp, 0, 3) : substr($_tmp, 0, 3)) != 'cf_' ) || ( ((is_array($_tmp=$this->_tpl_vars['fldname'])) ? $this->_run_mod_handler('substr', true, $_tmp, 0, 3) : substr($_tmp, 0, 3)) != 'cf_' && $this->_tpl_vars['PRICE_BOOK_MODE'] == 'create' ) || $this->_tpl_vars['USER_MODE'] == 'create'): ?>
	<?php $this->assign('selected', 'checked'); ?>
	<?php $this->assign('datavalue', 'on'); ?>
<?php elseif ($this->_tpl_vars['fldvalue'] == '1'): ?>
	<?php $this->assign('selected', 'checked'); ?>
	<?php $this->assign('datavalue', 'on'); ?>
<?php endif; ?>

<input type="checkbox" 
	name="<?php echo $this->_tpl_vars['fldname']; ?>
" 
	id="<?php echo $this->_tpl_vars['fldname']; ?>
" 
	<?php if ($this->_tpl_vars['READONLY'] == 'true'): ?>
		disabled 
	<?php endif; ?>
	<?php if ($this->_tpl_vars['read_only'] == '1'): ?>
		readOnly 
	<?php endif; ?>
	<?php echo $this->_tpl_vars['selected']; ?>

    data-value="<?php echo $this->_tpl_vars['datavalue']; ?>
"
	tabindex="<?php echo $this->_tpl_vars['vt_tab']; ?>
"
	data-label=<?php echo $this->_tpl_vars['fldlabel']; ?>

	data-toggle="icheck" 
/>
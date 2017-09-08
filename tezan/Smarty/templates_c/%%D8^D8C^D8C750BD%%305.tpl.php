<?php /* Smarty version 2.6.18, created on 2017-08-09 15:37:46
         compiled from uitype/305.tpl */ ?>
 
<?php $this->assign('imagewidth', ($this->_tpl_vars['extenddata'][2])); ?>
<?php $this->assign('imageheight', ($this->_tpl_vars['extenddata'][3])); ?>

<div id="<?php echo $this->_tpl_vars['fldname']; ?>
_plupload_div"></div>
<script type="text/javascript"  defer="defer">
var prams = {
	currentModule	: 	'<?php echo $this->_tpl_vars['MODULE']; ?>
',
	record		 	:	'<?php echo $this->_tpl_vars['ID']; ?>
',
	fieldname		: 	'<?php echo $this->_tpl_vars['fldname']; ?>
',
	fieldvalues		: 	'<?php echo $this->_tpl_vars['fldvalue']; ?>
',
	div_width		: 	125,
	div_height 		: 	125,
	readonly 		: 	<?php if ($this->_tpl_vars['READONLY'] == 'true' || $this->_tpl_vars['read_only'] == '1'): ?>'true'<?php else: ?>'false'<?php endif; ?>,
	multi_selection	: 	<?php if ($this->_tpl_vars['multiselect'] == '1'): ?>'true'<?php else: ?>'false'<?php endif; ?>,
	mode			: 	'smarty',
	img_width		: 	<?php if ($this->_tpl_vars['imagewidth'] > '0'): ?><?php echo $this->_tpl_vars['imagewidth']; ?>
<?php else: ?>0<?php endif; ?>,
	img_height		: 	<?php if ($this->_tpl_vars['imageheight'] > '0'): ?><?php echo $this->_tpl_vars['imageheight']; ?>
<?php else: ?>0<?php endif; ?>,
	required		: 	<?php if ($this->_tpl_vars['mustofdata'] == 'M'): ?>'true'<?php else: ?>'false'<?php endif; ?>,
	required_info	: 	"选择一张图片"
};
$(function() {
	getPlupLoadForJson(prams);
});
</script> 
<?php if ($this->_tpl_vars['field_unit'] != ''): ?>
	<span style="position: absolute; bottom: 3px;white-space:nowrap;padding:0px 2px;margin-left:3px;margin-top:2px;z-index:-1;"><?php echo $this->_tpl_vars['field_unit']; ?>
</span>
<?php endif; ?>
 
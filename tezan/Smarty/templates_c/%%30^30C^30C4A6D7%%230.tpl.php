<?php /* Smarty version 2.6.18, created on 2017-08-21 16:48:40
         compiled from uitype/230.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'strpos', 'uitype/230.tpl', 15, false),)), $this); ?>

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
<?php if ($this->_tpl_vars['multiselect'] == '1'): ?>
	<?php $this->assign('selectmode', 'checkbox'); ?>
<?php else: ?>
	<?php $this->assign('selectmode', 'radio'); ?>
<?php endif; ?>
<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;">
	<input type="hidden" data-value="<?php echo $this->_tpl_vars['fldvalue']; ?>
" value="<?php echo $this->_tpl_vars['fldvalue']; ?>
" name="<?php echo $this->_tpl_vars['fldname']; ?>
.id" id="<?php echo $this->_tpl_vars['fldname']; ?>
_id">
	<input type="text" name="<?php echo $this->_tpl_vars['fldname']; ?>
.name" id="<?php echo $this->_tpl_vars['fldname']; ?>
_name" value="<?php echo $this->_tpl_vars['secondvalue']; ?>
"
	<?php if ($this->_tpl_vars['READONLY'] != 'true' && $this->_tpl_vars['read_only'] != '1'): ?>
		onclick="<?php echo $this->_tpl_vars['fldname']; ?>
_onclick(this)"
	<?php endif; ?>
	<?php if ($this->_tpl_vars['editwidth'] == ''): ?>
		size='20'
	<?php endif; ?>
	style="<?php echo $this->_tpl_vars['editwidth']; ?>
<?php if ($this->_tpl_vars['READONLY'] != 'true' && $this->_tpl_vars['read_only'] != '1'): ?>padding-right: 25px;<?php endif; ?><?php if ($this->_tpl_vars['READONLY'] != 'true' && $this->_tpl_vars['read_only'] != '1'): ?>cursor: pointer;<?php endif; ?>"
	<?php if ($this->_tpl_vars['mustofdata'] == 'M'): ?>
	   data-rule="required;"
	<?php endif; ?>
	class="<?php if ($this->_tpl_vars['mustofdata'] == 'M' && $this->_tpl_vars['READONLY'] != 'true'): ?>required<?php endif; ?>"
	readonly>
	<?php if ($this->_tpl_vars['READONLY'] != 'true' && $this->_tpl_vars['read_only'] != '1'): ?>
		<a data-callback="<?php echo $this->_tpl_vars['fldname']; ?>
_callback" class="bjui-lookup" data-toggle="lookupbtn" data-newurl=""
			data-oldurl="index.php?module=Profiles&action=Popup&recordid=58457&mode=<?php echo $this->_tpl_vars['selectmode']; ?>
&popuptype=<?php echo $this->_tpl_vars['MODULE']; ?>
&exclude=" 
			data-url="index.php?module=Profiles&action=Popup&recordid=58457&mode=<?php echo $this->_tpl_vars['selectmode']; ?>
&popuptype=<?php echo $this->_tpl_vars['MODULE']; ?>
&select=<?php echo $this->_tpl_vars['fldvalue']; ?>
&exclude=" 
			data-group="<?php echo $this->_tpl_vars['fldname']; ?>
" data-maxable="false" data-title="请选择权限"  data-width="700" data-height="300" href="javascript:;" style="height: 22px; line-height: 22px;">
			<i class="fa fa-search"></i>
		</a>
	<?php endif; ?>
</span>
<?php if ($this->_tpl_vars['READONLY'] != 'true' && $this->_tpl_vars['read_only'] != '1'): ?>
	<script language="javascript" type="text/javascript">
		function <?php echo $this->_tpl_vars['fldname']; ?>
_onclick(obj){
			$(obj).parent().find('a.bjui-lookup').trigger("click");
		}
		$.CurrentNavtab.find(":input").each(function() {
			if ($(this).attr("id") == "<?php echo $this->_tpl_vars['fldname']; ?>
_id"){
				$(this).on('afterchange.bjui.lookup', function(e, data) {
					var oldurl = $(this).parent().find("a.bjui-lookup").data("oldurl");
					$(this).parent().find("a.bjui-lookup").data("newurl", oldurl+"&select="+data.value);
				});
			}
			<?php if ($this->_tpl_vars['mustofdata'] == 'M'): ?>
				if ($(this).attr("id") == "<?php echo $this->_tpl_vars['fldname']; ?>
_name"){
					$(this).on('afterchange.bjui.lookup', function(e, data) {
						$(this).trigger("validate");
					});
				}
			<?php endif; ?>
		});
	</script>
<?php endif; ?>
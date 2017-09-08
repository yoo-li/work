<?php /* Smarty version 2.6.18, created on 2017-07-31 11:05:51
         compiled from uitype/10.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'strpos', 'uitype/10.tpl', 11, false),)), $this); ?>

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

<?php if ($this->_tpl_vars['fldvalue']['type'] == 'select'): ?>  
	<?php $this->assign('selectvalue', ""); ?>
	<?php $_from = $this->_tpl_vars['fldvalue']['options']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['optionitems'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['optionitems']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['arr']):
        $this->_foreach['optionitems']['iteration']++;
?>
		<?php if ($this->_foreach['optionitems']['iteration'] == 1): ?>
			<?php $this->assign('selectvalue', ($this->_tpl_vars['arr'][1])); ?>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['arr'][2] != ''): ?>
			<?php $this->assign('selectvalue', ($this->_tpl_vars['arr'][1])); ?>
		<?php endif; ?>
	<?php endforeach; else: ?>
		<?php $this->assign('selectvalue', ""); ?>
	<?php endif; unset($_from); ?>
	<select data-toggle="selectpicker"
		name="<?php echo $this->_tpl_vars['fldname']; ?>
" 
		id="<?php echo $this->_tpl_vars['fldname']; ?>
" 
		tabindex="<?php echo $this->_tpl_vars['vt_tab']; ?>
" 
		<?php echo $this->_tpl_vars['editwidth']; ?>

		<?php if ($this->_tpl_vars['READONLY'] == 'true' || $this->_tpl_vars['read_only'] == '1'): ?>
			disabled  
		<?php endif; ?>
		<?php if ($this->_tpl_vars['mustofdata'] == 'M' && $this->_tpl_vars['READONLY'] != 'true' && $this->_tpl_vars['read_only'] != '1'): ?>
			data-rule="required;"
		<?php endif; ?>
		data-value="<?php echo $this->_tpl_vars['selectvalue']; ?>
"
		>
		<?php $_from = $this->_tpl_vars['fldvalue']['options']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arr']):
?> 
				<option value="<?php echo $this->_tpl_vars['arr'][0]; ?>
" <?php echo $this->_tpl_vars['arr'][2]; ?>
> <?php echo $this->_tpl_vars['arr'][1]; ?>
 </option> 
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
<?php else: ?>   
	<?php if ($this->_tpl_vars['mustofdata'] == 'M'): ?>
		<?php $this->assign('dataRule', "required;"); ?>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['typeofdata'] == 'NN'): ?>
		<?php $this->assign('dataRule', ($this->_tpl_vars['dataRule'])."+\"digits;\""); ?>
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

	<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;width:100%;"> 
		<input type="hidden" data-value="<?php echo $this->_tpl_vars['fldvalue']['entityid']; ?>
" value="<?php echo $this->_tpl_vars['fldvalue']['entityid']; ?>
" name="<?php echo $this->_tpl_vars['fldname']; ?>
.id" id="<?php echo $this->_tpl_vars['fldname']; ?>
_id">
		<?php if ($this->_tpl_vars['multiselect'] != '1'): ?>
		<input type="text" name="<?php echo $this->_tpl_vars['fldname']; ?>
.name" id="<?php echo $this->_tpl_vars['fldname']; ?>
_name" value="<?php echo $this->_tpl_vars['fldvalue']['displayvalue']; ?>
"
	        <?php if ($this->_tpl_vars['READONLY'] != 'true' && $this->_tpl_vars['read_only'] != '1'): ?>
				onclick = "$(this).parent().find('a.bjui-lookup').trigger('click');"
	        <?php endif; ?>
			<?php if ($this->_tpl_vars['READONLY'] == 'true'): ?>
				disabled
			<?php endif; ?>
			<?php if ($this->_tpl_vars['read_only'] == '1' && $this->_tpl_vars['remotevalidationfunc'] == ''): ?>
				readonly
			<?php endif; ?>
			<?php if ($this->_tpl_vars['editwidth'] == ''): ?>
				size='20'
			<?php endif; ?>
			style="<?php echo $this->_tpl_vars['editwidth']; ?>
<?php if ($this->_tpl_vars['READONLY'] != 'true' && $this->_tpl_vars['read_only'] != '1'): ?>padding-right: 25px;<?php endif; ?><?php if ($this->_tpl_vars['READONLY'] != 'true'): ?>cursor: pointer;<?php if ($this->_tpl_vars['read_only'] == '1'): ?>background-color:#eeeeee;<?php else: ?>background-color:#ffffff;<?php endif; ?><?php endif; ?>"
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
		<?php else: ?>
		<textarea maxlength="<?php echo $this->_tpl_vars['maxlength']; ?>
"
				  name="<?php echo $this->_tpl_vars['fldname']; ?>
.name" id="<?php echo $this->_tpl_vars['fldname']; ?>
_name"
				  tabindex="<?php echo $this->_tpl_vars['vt_tab']; ?>
"
				  rows="3"
				  <?php if ($this->_tpl_vars['READONLY'] != 'true' && $this->_tpl_vars['read_only'] != '1'): ?>
					onclick = "$(this).parent().find('a.bjui-lookup').trigger('click');"
				  <?php endif; ?>
				  style="<?php echo $this->_tpl_vars['editwidth']; ?>
<?php if ($this->_tpl_vars['mustofdata'] == 'M'): ?>padding-right: 15px;<?php endif; ?>"
					<?php if ($this->_tpl_vars['READONLY'] == 'true'): ?>
						disabled
					<?php endif; ?>
					<?php if ($this->_tpl_vars['read_only'] == '1'): ?>
						readOnly
					<?php endif; ?>
				  data-value="<?php echo $this->_tpl_vars['fldvalue']['displayvalue']; ?>
"
				  data-toggle="autoheight"
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
			><?php echo $this->_tpl_vars['fldvalue']['displayvalue']; ?>
</textarea>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['READONLY'] != 'true' && $this->_tpl_vars['read_only'] != '1'): ?>
			<a data-callback="<?php echo $this->_tpl_vars['fldname']; ?>
_callback" id="<?php echo $this->_tpl_vars['fldname']; ?>
_lookup" class="bjui-lookup" data-toggle="lookupbtn"
				data-newurl=""
				data-oldurl="index.php?module=<?php echo $this->_tpl_vars['fldvalue']['module']; ?>
&action=Popup&popuptype=<?php echo $this->_tpl_vars['MODULE']; ?>
&mode=<?php echo $this->_tpl_vars['multiselect']; ?>
&<?php if ($this->_tpl_vars['FILTER'][$this->_tpl_vars['fldname']] != ''): ?>filter=<?php echo $this->_tpl_vars['FILTER'][$this->_tpl_vars['fldname']]; ?>
&<?php endif; ?>exclude="
				data-url="index.php?module=<?php echo $this->_tpl_vars['fldvalue']['module']; ?>
&action=Popup&popuptype=<?php echo $this->_tpl_vars['MODULE']; ?>
&mode=<?php echo $this->_tpl_vars['multiselect']; ?>
&<?php if ($this->_tpl_vars['FILTER'][$this->_tpl_vars['fldname']] != ''): ?>filter=<?php echo $this->_tpl_vars['FILTER'][$this->_tpl_vars['fldname']]; ?>
&<?php endif; ?>exclude=<?php echo $this->_tpl_vars['fldvalue']['entityid']; ?>
"
				data-group="<?php echo $this->_tpl_vars['fldname']; ?>
" data-maxable="false" data-title="选择<?php echo $this->_tpl_vars['fldvalue']['label']; ?>
"
				href="javascript:;" style="height: 22px; line-height: 22px;">
				<i class="fa fa-search"></i>
			</a>
		<?php endif; ?>
	</span>
	<?php if ($this->_tpl_vars['READONLY'] != 'true' && $this->_tpl_vars['read_only'] != '1'): ?>
		<script language="javascript" type="text/javascript">
			$('#<?php echo $this->_tpl_vars['fldname']; ?>
_id').on('afterchange.bjui.lookup', function(e, data) {
				var oldurl = $('#<?php echo $this->_tpl_vars['fldname']; ?>
_id').parent().find("a.bjui-lookup").data("oldurl");
				$('#<?php echo $this->_tpl_vars['fldname']; ?>
_id').parent().find("a.bjui-lookup").data("newurl", oldurl+data.value);
			});
			<?php if ($this->_tpl_vars['mustofdata'] == 'M'): ?>
				$('#<?php echo $this->_tpl_vars['fldname']; ?>
_name').on('afterchange.bjui.lookup', function(e, data) {
					$('#<?php echo $this->_tpl_vars['fldname']; ?>
_name').trigger("validate");
				});
			<?php endif; ?>
		</script>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['remotevalidationfunc'] != ''): ?>
		<script language="javascript" type="text/javascript">
			function <?php echo $this->_tpl_vars['fldname']; ?>
remote_validation_func() {
				if (typeof(<?php echo $this->_tpl_vars['remotevalidationfunc']; ?>
)=="function"){
					return <?php echo $this->_tpl_vars['remotevalidationfunc']; ?>
();
				}else{
					return "远程序验证函数不存在";
				}
			}
		</script>
	<?php endif; ?>
<?php endif; ?>
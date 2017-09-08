<?php /* Smarty version 2.6.18, created on 2017-08-09 15:37:46
         compiled from uitype/208.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'strpos', 'uitype/208.tpl', 14, false),array('modifier', 'strtoupper', 'uitype/208.tpl', 24, false),)), $this); ?>

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
<?php $this->assign('nonelabel', strtoupper($this->_tpl_vars['fldname'])); ?>
<?php $this->assign('nonelabel1', '_NONE'); ?>
<?php $this->assign('nonelabel', "LBL_".($this->_tpl_vars['nonelabel']).($this->_tpl_vars['nonelabel1'])); ?>
<?php $this->assign('datasource', ($this->_tpl_vars['extenddata'][2])); ?>
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
		<?php if ($this->_tpl_vars['relation'] != ''): ?>
		data-nextselect="#<?php echo $this->_tpl_vars['relation']; ?>
"
		data-refurl="relation_data_source_<?php echo $this->_tpl_vars['fldname']; ?>
"
		<?php endif; ?>
		<?php if ($this->_tpl_vars['mustofdata'] == 'M' && $this->_tpl_vars['READONLY'] != 'true' && $this->_tpl_vars['read_only'] != '1'): ?>
			data-rule="required;"
			class="form-control required"
		<?php endif; ?>
		data-val="<?php echo $this->_tpl_vars['fldvalue']; ?>
"
		data-value="<?php echo $this->_tpl_vars['fldvalue']; ?>
"
		data-emptytxt="<?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['nonelabel']]; ?>
"
>
	<option value="" style='color: #777777'> <?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['nonelabel']]; ?>
 </option>
</select>
<?php if ($this->_tpl_vars['field_unit'] != ''): ?>
	<span  style="padding:0px 2px;margin-left:3px;z-index:-1;"><?php echo $this->_tpl_vars['field_unit']; ?>
</span>
<?php endif; ?>
<?php if ($this->_tpl_vars['relation'] != ''): ?>
	<script language="javascript" type="text/javascript">
		$.ajaxSetup({ cache: true });  
	</script>
	<script src="/Public/js/areajson.js"></script>
	<script language="javascript" type="text/javascript">
		$.ajaxSetup({ cache: false });  
	</script>
	<script language="javascript" type="text/javascript">
		<?php if ($this->_tpl_vars['datasource'] == 'P'): ?>
		$.each(citydata, function (key, area)
		{
			if (area.text == '<?php echo $this->_tpl_vars['fldvalue']; ?>
')
			{
				$("#<?php echo $this->_tpl_vars['fldname']; ?>
").append('<option value="' + area.text + '" selected> ' + area.text + ' </option>');
				}
			else
			{
				$("#<?php echo $this->_tpl_vars['fldname']; ?>
").append('<option value="' + area.text + '"> ' + area.text + ' </option>');
				}
			});
		<?php endif; ?>
		function relation_data_source_<?php echo $this->_tpl_vars['fldname']; ?>
(selectvalue)
		{
			var json = '';
			$.each(citydata, function (provincekey, province)
			{
				if (province.text == selectvalue)
				{
					if (province.children != undefined)
					{
						json = '{"value":"","label":"' + $("#<?php echo $this->_tpl_vars['relation']; ?>
").data("emptytxt") + '"}';
						$.each(province.children, function (citykey, city)
						{
							json += ',{"value":"' + city.text + '","label":"' + city.text + '"}';
						});
					}
				}
				else if (province.children != undefined)
				{
					$.each(province.children, function (citykey, city)
					{
						if (city.text == selectvalue)
						{
							if (city.children != undefined)
							{
								json = '{"value":"","label":"' + $("#<?php echo $this->_tpl_vars['relation']; ?>
").data("emptytxt") + '"}';
								$.each(city.children, function (districtkey, district)
								{
									json += ',{"value":"' + district.text + '","label":"' + district.text + '"}';
									});
								}
							}
						});
					}
				});
			return eval("[" + json + "]");
			}
	</script>
<?php endif; ?>
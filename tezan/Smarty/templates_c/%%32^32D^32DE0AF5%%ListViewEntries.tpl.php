<?php /* Smarty version 2.6.18, created on 2017-08-25 09:59:08
         compiled from ListViewEntries.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'ListViewEntries.tpl', 1, false),array('modifier', 'strip_tags', 'ListViewEntries.tpl', 38, false),array('modifier', 'lower', 'ListViewEntries.tpl', 102, false),)), $this); ?>
<?php if (((is_array($_tmp=$this->_tpl_vars['LISTVIEW_CHECK_BUTTON'])) ? $this->_run_mod_handler('count', true, $_tmp) : count($_tmp)) > 0 || ((is_array($_tmp=$this->_tpl_vars['CUSTOMVIEW_OPTION'])) ? $this->_run_mod_handler('count', true, $_tmp) : count($_tmp)) > 0): ?> 
		<?php $_from = $this->_tpl_vars['LISTVIEW_CHECK_BUTTON']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['data']):
?> 
			 <?php if ($this->_tpl_vars['data']['key'] == 'ModuleReport'): ?> 
				<?php $this->assign('modulereport', $this->_tpl_vars['data']['value']); ?> 
			 <?php endif; ?>
		<?php endforeach; endif; unset($_from); ?> 
<?php endif; ?>


	<table data-toggle="tablefixed" class="table table-striped table-bordered table-hover nowrap" data-width="100%" data-nowrap="true">
		<thead>
		<tr>
			<th class="center" width="30px" maxwidth="20">
				<input type="checkbox" class="checkboxCtrl" data-group="ids" data-toggle="icheck">
			</th>
			<?php $_from = $this->_tpl_vars['LISTHEADER']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['listviewforeach'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['listviewforeach']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['header']):
        $this->_foreach['listviewforeach']['iteration']++;
?>
				<?php if ($this->_tpl_vars['header']['sort'] == 'true'): ?>
					<th class="center" width="<?php echo $this->_tpl_vars['header']['width']; ?>
%" height="35px;" data-order-field="<?php echo $this->_tpl_vars['key']; ?>
"><?php echo $this->_tpl_vars['header']['label']; ?>
</th>
				<?php else: ?>
					<th class="center" width="<?php echo $this->_tpl_vars['header']['width']; ?>
%" height="35px;"><?php echo $this->_tpl_vars['header']['label']; ?>
</th>
				<?php endif; ?>
			<?php endforeach; endif; unset($_from); ?>
		</tr>
		</thead>

		<?php $_from = $this->_tpl_vars['LISTENTITY']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['listviewentity'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['listviewentity']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['entity_id'] => $this->_tpl_vars['entity']):
        $this->_foreach['listviewentity']['iteration']++;
?>
			<tr data-id="<?php echo $this->_tpl_vars['entity_id']; ?>
">
				<td class="center"><input type="checkbox" name="ids" data-toggle="icheck" value="<?php echo $this->_tpl_vars['entity_id']; ?>
"></td>
				<?php $_from = $this->_tpl_vars['entity']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['data']):
?>
					<?php $_from = $this->_tpl_vars['LISTHEADER']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['listviewforeach'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['listviewforeach']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['headkey'] => $this->_tpl_vars['header']):
        $this->_foreach['listviewforeach']['iteration']++;
?>
						<?php if ($this->_tpl_vars['headkey'] == $this->_tpl_vars['key']): ?>
						    <?php if ($this->_tpl_vars['key'] == 'oper' || $this->_tpl_vars['key'] == 'record' || $this->_tpl_vars['header']['notip'] == 1): ?>
								<td class="<?php echo $this->_tpl_vars['header']['align']; ?>
" ><?php echo $this->_tpl_vars['data']; ?>
</td>
							<?php else: ?>
							    <?php if ($this->_tpl_vars['data'] == '' || $this->_tpl_vars['data'] == '-' || $this->_tpl_vars['data'] == '--'): ?>
										<td class="<?php echo $this->_tpl_vars['header']['align']; ?>
"><?php echo $this->_tpl_vars['data']; ?>
</td>
								<?php else: ?>
									<td class="<?php echo $this->_tpl_vars['header']['align']; ?>
" data-toggle="poshytip" title="<?php echo smarty_modifier_strip_tags($this->_tpl_vars['data']); ?>
"><?php echo $this->_tpl_vars['data']; ?>
</td>
								<?php endif; ?> 
							<?php endif; ?> 
						<?php endif; ?>
					<?php endforeach; endif; unset($_from); ?>
				<?php endforeach; endif; unset($_from); ?>
			</tr> 
		<?php endforeach; endif; unset($_from); ?>
		<?php if (count($this->_tpl_vars['modulereport']) > 0 && $this->_tpl_vars['modulereport'] != ''): ?> 
		<tr>
			<td class="center" style="background-color:#fff;">&nbsp;</td>
			<td class="center" colspan="<?php echo count($this->_tpl_vars['LISTHEADER']); ?>
" style="padding:5px;padding-top:15px;background-color:#fff;">
				<div style="border:1px solid #dfdfdf;background:#fff6e1;">
					<table width="100%" cellspacing="0" cellpadding="0">
					<tr>
						<td class="center" width="20" rowspan="2" align="center" valign="top"><img src="/Public/images/x1chart.png"><!--<i class="fa fa-iconfont icon-group-reports" style="font-size:5.0em;">--></td>
						<td class="center" width="99%" align="left" valign="middle" style="height:30px;font-size:1.5em;">&nbsp;&nbsp;<i class="fa fa-iconfont icon-group-reports"></i>&nbsp;<?php echo $this->_tpl_vars['APP']['MODULEREPORT']; ?>
</td>
					</tr>
					<tr>
						<td class="center">
							<ul>
								<?php $_from = $this->_tpl_vars['modulereport']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['reporttype'] => $this->_tpl_vars['modulereport_info']):
?> 
									<?php $_from = $this->_tpl_vars['modulereport_info']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['report_info']):
?>
										<?php if ($this->_tpl_vars['reporttype'] == 'TopN报表'): ?>
											<?php $this->assign('reportmodule', 'ReportsTopN'); ?>
										<?php elseif ($this->_tpl_vars['reporttype'] == '环比报表'): ?>
											<?php $this->assign('reportmodule', 'ReportsLinkRelative'); ?>
										<?php elseif ($this->_tpl_vars['reporttype'] == '同比报表'): ?>
											<?php $this->assign('reportmodule', 'ReportsSameRelative'); ?>
										<?php elseif ($this->_tpl_vars['reporttype'] == '综合报表'): ?>
											<?php $this->assign('reportmodule', 'ReportsIntegrated'); ?>
										<?php else: ?>
											<?php $this->assign('reportmodule', 'Reports'); ?>
										<?php endif; ?>
									     <li style="float:left;padding:5px 15px;"><a data-id="<?php echo $this->_tpl_vars['reportmodule']; ?>
" data-toggle="navtab"  data-title="<?php echo $this->_tpl_vars['report_info']['reportname']; ?>
【<?php echo $this->_tpl_vars['reporttype']; ?>
】" href="index.php?module=<?php echo $this->_tpl_vars['reportmodule']; ?>
&action=index&reportid=<?php echo $this->_tpl_vars['report_info']['reportid']; ?>
&parenttab=Analytics"><i class="fa fa-iconfont icon-reports"></i> <?php echo $this->_tpl_vars['report_info']['reportname']; ?>
【<?php echo $this->_tpl_vars['reporttype']; ?>
】</a></li>
								    <?php endforeach; endif; unset($_from); ?> 
								<?php endforeach; endif; unset($_from); ?>
							</ul>
						</td>
					</tr>
					</table>
				</div>
			</td>
		</tr>
		<?php endif; ?>
	</table>
 
<div id="order_footer" class="bjui-pageFooter" <?php if ($this->_tpl_vars['RUNTIME'] != ''): ?>title="响应时间:<?php echo $this->_tpl_vars['RUNTIME']; ?>
s"<?php endif; ?>>
	<div class="pages">
		<span>每页&nbsp;</span>
		<div class="selectPagesize">
			<select data-toggle="selectpicker" data-toggle-change="changepagesize">
				<option value="15" <?php if ($this->_tpl_vars['fNUMPERPAGE'] == '15'): ?>selected<?php endif; ?>>15</option>
				<option value="20" <?php if ($this->_tpl_vars['NUMPERPAGE'] == '20'): ?>selected<?php endif; ?>>20</option>
				<option value="50" <?php if ($this->_tpl_vars['NUMPERPAGE'] == '50'): ?>selected<?php endif; ?>>50</option>
				<option value="100" <?php if ($this->_tpl_vars['NUMPERPAGE'] == '100'): ?>selected<?php endif; ?>>100</option>
				<option value="200" <?php if ($this->_tpl_vars['NUMPERPAGE'] == '200'): ?>selected<?php endif; ?>>200</option>
				<option value="500" <?php if ($this->_tpl_vars['NUMPERPAGE'] == '500'): ?>selected<?php endif; ?>>500</option>
				<option value="1000" <?php if ($this->_tpl_vars['NUMPERPAGE'] == '1000'): ?>selected<?php endif; ?>>1000</option>
			</select>
		</div>
		<span>&nbsp;条，共 <?php echo $this->_tpl_vars['NOOFROWS']; ?>
 条</span>
	</div>
	<?php if ($this->_tpl_vars['STATISTICS'] == 'true'): ?>
	  <div class="pages"><span id="<?php echo ((is_array($_tmp=$this->_tpl_vars['MODULE'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)); ?>
_statistics_div" ></span></div>
	  <script language="javascript" type="text/javascript">
	      function <?php echo ((is_array($_tmp=$this->_tpl_vars['MODULE'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)); ?>
_statistics()
		  {
		    jQuery("[id=progressBar]").addClass("hidden");
			var postBody = "module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=statistics&mode=ajax";
			jQuery.post("index.php", postBody,
			function (data, textStatus)
			{
				 jQuery("[id=progressBar]").addClass("hidden");
				 jQuery("#<?php echo ((is_array($_tmp=$this->_tpl_vars['MODULE'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)); ?>
_statistics_div").html(data); 
				 jQuery("#<?php echo ((is_array($_tmp=$this->_tpl_vars['MODULE'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)); ?>
_statistics_div").attr('title',data);
				 jQuery("#<?php echo ((is_array($_tmp=$this->_tpl_vars['MODULE'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)); ?>
_statistics_div").poshytip({allowTipHover:true}); 
			}); 
			jQuery("[id=progressBar]").removeClass("hidden");
		 }
		 setTimeout('<?php echo ((is_array($_tmp=$this->_tpl_vars['MODULE'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)); ?>
_statistics();',100);
	  </script>
	<?php endif; ?>
	<!--<?php if ($this->_tpl_vars['RUNTIME'] != ''): ?>
		<div class="pages" style="float:right"><span><?php echo $this->_tpl_vars['RUNTIME']; ?>
s</span></div>
	<?php endif; ?>-->
	<div class="pagination-box" data-toggle="pagination" data-total="<?php echo $this->_tpl_vars['NOOFROWS']; ?>
" data-page-size="<?php echo $this->_tpl_vars['NUMPERPAGE']; ?>
" data-page-current="<?php echo $this->_tpl_vars['PAGENUM']; ?>
">
	</div>
	
</div>
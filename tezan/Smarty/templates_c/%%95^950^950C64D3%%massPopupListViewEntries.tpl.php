<?php /* Smarty version 2.6.18, created on 2017-06-29 14:11:13
         compiled from massPopupListViewEntries.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'massPopupListViewEntries.tpl', 14, false),array('modifier', 'is_array', 'massPopupListViewEntries.tpl', 21, false),)), $this); ?>
<div class="bjui-pageContent tableContent" style="margin-bottom:30px;">
   <table class="table table-bordered table-top table-hover" data-width="100%" data-nowrap="true" >
			<thead>
			<tr>
				<th align="center" width="2%" maxwidth="18"><input type="checkbox" class="checkboxCtrl" data-group="ids" data-toggle="icheck"></th>
				<?php $_from = $this->_tpl_vars['LISTHEADER']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['listviewforeach'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['listviewforeach']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['header']):
        $this->_foreach['listviewforeach']['iteration']++;
?>
					<th class="center" width="<?php echo $this->_tpl_vars['header']['width']; ?>
%" ><?php echo $this->_tpl_vars['header']['label']; ?>
</th>
				<?php endforeach; endif; unset($_from); ?>
			</tr>
			</thead>
			<tbody>
			<?php $_from = $this->_tpl_vars['LISTENTITY']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['listviewentity'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['listviewentity']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['entity_id'] => $this->_tpl_vars['entity']):
        $this->_foreach['listviewentity']['iteration']++;
?>
				<?php $this->assign('worknotices', $this->_tpl_vars['entity']['worknotices']); ?>
				<tr target="sid" rel="<?php echo $this->_tpl_vars['entity_id']; ?>
" <?php if ($this->_tpl_vars['worknotices'] == 'UnRead'): ?> style= "background:#DDDDD0"<?php endif; ?> bgcolor=<?php echo smarty_function_cycle(array('values' => "#FFFFFF,#EEEEEE"), $this);?>
 id="row_<?php echo $this->_tpl_vars['entity_id']; ?>
">
				<td width="2%" align="center"> <input type="checkbox" name="ids" data-toggle="icheck" value="<?php echo $this->_tpl_vars['entity_id']; ?>
"></td>
				<?php $_from = $this->_tpl_vars['entity']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['data']):
?>
					 <?php if ($this->_tpl_vars['key'] != 'worknotices' || $this->_tpl_vars['key'] == '0'): ?>
						<?php $_from = $this->_tpl_vars['LISTHEADER']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['listviewforeach'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['listviewforeach']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['headkey'] => $this->_tpl_vars['header']):
        $this->_foreach['listviewforeach']['iteration']++;
?>
							<?php if ($this->_foreach['listviewforeach']['iteration'] == $this->_tpl_vars['key']+1): ?>
								<td class="listview <?php echo $this->_tpl_vars['header']['align']; ?>
 <?php echo $this->_tpl_vars['key']; ?>
" >
									<?php if (((is_array($_tmp=$this->_tpl_vars['data'])) ? $this->_run_mod_handler('is_array', true, $_tmp) : is_array($_tmp)) == true && $this->_tpl_vars['data']['label'] != ''): ?>
										<?php echo $this->_tpl_vars['data']['label']; ?>

									<?php else: ?>
										<?php echo $this->_tpl_vars['data']; ?>

									<?php endif; ?>
								</td>
							<?php endif; ?>
						<?php endforeach; endif; unset($_from); ?>
					<?php endif; ?>
				<?php endforeach; endif; unset($_from); ?> 
				</tr> 
			<?php endforeach; endif; unset($_from); ?>

				</tbody>
		</table>
	</div>

	<div  class="bjui-pageFooter" <?php if ($this->_tpl_vars['RUNTIME'] != ''): ?>title="响应时间:<?php echo $this->_tpl_vars['RUNTIME']; ?>
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
				</select>
			</div>
			<span>&nbsp;条，共 <?php echo $this->_tpl_vars['NOOFROWS']; ?>
 条</span>
		</div>
		<!--<?php if ($this->_tpl_vars['RUNTIME'] != ''): ?>
		<div class="pages" style="float:right"><span><?php echo $this->_tpl_vars['RUNTIME']; ?>
s</span></div>
	<?php endif; ?>-->
		<div class="pagination-box" data-toggle="pagination" data-total="<?php echo $this->_tpl_vars['NOOFROWS']; ?>
" data-page-size="<?php echo $this->_tpl_vars['NUMPERPAGE']; ?>
" data-page-current="<?php echo $this->_tpl_vars['PAGENUM']; ?>
">
		</div>
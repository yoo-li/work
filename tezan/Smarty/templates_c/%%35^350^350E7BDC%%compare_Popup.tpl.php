<?php /* Smarty version 2.6.18, created on 2017-06-27 16:31:36
         compiled from compare_Popup.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'compare_Popup.tpl', 19, false),array('modifier', 'is_array', 'compare_Popup.tpl', 74, false),array('modifier', 'in_array', 'compare_Popup.tpl', 76, false),array('function', 'html_options', 'compare_Popup.tpl', 26, false),)), $this); ?>
<div class="bjui-pageHeader">
    <form id="pagerForm" data-toggle="ajaxsearch" action="index.php" method="post">
	    <input type="hidden" name="module" value="<?php echo $this->_tpl_vars['MODULE']; ?>
"/>
	    <input type="hidden" name="filter" value="<?php echo $this->_tpl_vars['FILTER']; ?>
"/>
	    <input type="hidden" name="action" value="<?php if ($this->_tpl_vars['POPUP'] != ''): ?><?php echo $this->_tpl_vars['POPUP']; ?>
<?php else: ?>Popup<?php endif; ?>"/>
	    <input type="hidden" name="recordid" value="<?php echo $this->_tpl_vars['RECORDID']; ?>
"/>
	    <input type="hidden" name="popuptype" value="<?php echo $this->_tpl_vars['POPUPTYPE']; ?>
"/>
	    <input type="hidden" name="exclude" value="<?php echo $this->_tpl_vars['EXCLUDE']; ?>
"/>
		<input type="hidden" name="mode" value="<?php echo $this->_tpl_vars['SELECTMODE']; ?>
"/>
		<input type="hidden" name="select" value="<?php echo $this->_tpl_vars['SELECTIDS']; ?>
"/>

	    <input type="hidden" name="pageNum" value="<?php echo $this->_tpl_vars['PAGENUM']; ?>
"/>
	    <input type="hidden" name="numPerPage" value="<?php echo $this->_tpl_vars['NUMPERPAGE']; ?>
"/>
	    <input type="hidden" name="_order" value="<?php echo $this->_tpl_vars['ORDER_BY']; ?>
"/>
	    <input type="hidden" name="_sort" value="<?php echo $this->_tpl_vars['ORDER']; ?>
"/>
	    <input type="hidden" name="__hash__" value="ff0146f931b6eab52136821c0e137737_f1aa993e20c19c1e1d618235cb38cf1d" />
		
        <div class="bjui-searchBar">
			<?php if (((is_array($_tmp=$this->_tpl_vars['SEARCHLISTHEADER'])) ? $this->_run_mod_handler('count', true, $_tmp) : count($_tmp)) > 0): ?>
				<span style="display: inline-block;margin-right: 10px;margin-top:1px;">
					<label>关键词：</label><input type="text" name="search_text" value="<?php echo $this->_tpl_vars['SEARCH_TEXT']; ?>
"/>
				</span>
				<span style="display: inline-block;margin-right: 10px;margin-top:1px;">
					<label>字段：</label>
					<select id="search_field" name ="search_field" data-toggle="selectpicker">
						<?php echo smarty_function_html_options(array('selected' => ($this->_tpl_vars['SEARCH_FIELD']),'options' => $this->_tpl_vars['SEARCHLISTHEADER']), $this);?>

					</select>
				</span>
			<?php endif; ?>
			<?php if (((is_array($_tmp=$this->_tpl_vars['SEARCHPANEL'])) ? $this->_run_mod_handler('count', true, $_tmp) : count($_tmp)) > 0): ?>
				<?php $_from = $this->_tpl_vars['SEARCHPANEL']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['searchlabel'] => $this->_tpl_vars['searchdata']):
?>
					<span style="display: inline-block;margin-right: 10px;margin-top:1px;">
						<label><?php echo $this->_tpl_vars['searchlabel']; ?>
：</label><?php echo $this->_tpl_vars['searchdata']; ?>

					</span>
				<?php endforeach; endif; unset($_from); ?>
			<?php endif; ?>
			<?php if (((is_array($_tmp=$this->_tpl_vars['SEARCHLISTHEADER'])) ? $this->_run_mod_handler('count', true, $_tmp) : count($_tmp)) > 0 || ((is_array($_tmp=$this->_tpl_vars['SEARCHPANEL'])) ? $this->_run_mod_handler('count', true, $_tmp) : count($_tmp)) > 0): ?>
	            <div class="pull-right">
					<span style="display: inline-block;margin-right: 10px;margin-top:1px;">
		                <button type="submit" class="btn-orange" data-icon="search">查询</button>&nbsp;
						<?php if ($this->_tpl_vars['SELECTMODE'] == 'checkbox'): ?>
							<button type="button" class="btn-green" data-toggle="lookupback" data-lookupid="ids" data-warn="<?php if ($this->_tpl_vars['SELECTWARN'] == ''): ?>请至少选择一项权限<?php else: ?><?php echo $this->_tpl_vars['SELECTWARN']; ?>
<?php endif; ?>" data-icon="check-square-o">返回选择</button>
						<?php endif; ?>
					</span>
	            </div>
			<?php endif; ?>
        </div>
    </form>
</div>
<div class="bjui-pageContent tableContent">
    <table class="table table-bordered table-top table-hover" data-width="100%" data-nowrap="true">
        <thead>
            <tr>
				<?php if ($this->_tpl_vars['SELECTMODE'] == 'checkbox'): ?>
					<th style="width:28px;"><input type="checkbox" class="checkboxCtrl" data-group="ids" data-toggle="icheck"></th>
				<?php endif; ?>
		        <?php $_from = $this->_tpl_vars['LISTHEADER']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['listviewforeach'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['listviewforeach']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['header']):
        $this->_foreach['listviewforeach']['iteration']++;
?>
					<?php if ($this->_tpl_vars['header']['sort'] == 'true'): ?>
		            	<th class="center" data-order-field="<?php echo $this->_tpl_vars['key']; ?>
"><?php echo $this->_tpl_vars['header']['label']; ?>
</th>
					<?php else: ?>
						<th class="center"><?php echo $this->_tpl_vars['header']['label']; ?>
</th> 
					<?php endif; ?>
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
" <?php if ($this->_tpl_vars['worknotices'] == 'UnRead'): ?> style= "background:#DDDDD0"<?php endif; ?> id="row_<?php echo $this->_tpl_vars['entity_id']; ?>
">
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
									<?php if (is_array($this->_tpl_vars['data']) == '1'): ?>
										<?php if ($this->_tpl_vars['SELECTMODE'] == 'checkbox'): ?>
											<td><input type="checkbox" name="ids" data-toggle="icheck" <?php if (((is_array($_tmp=$this->_tpl_vars['entity_id'])) ? $this->_run_mod_handler('in_array', true, $_tmp, $this->_tpl_vars['SELECTID']) : in_array($_tmp, $this->_tpl_vars['SELECTID']))): ?>checked<?php endif; ?> value="<?php echo $this->_tpl_vars['data']['value']; ?>
"></td>
											<td class="<?php echo $this->_tpl_vars['header']['align']; ?>
"><?php echo $this->_tpl_vars['data']['label']; ?>
</td>
										<?php else: ?>
											<td class="<?php echo $this->_tpl_vars['header']['align']; ?>
">
												<a href="javascript:;" data-toggle="lookupback" data-args="<?php echo $this->_tpl_vars['data']['value']; ?>
"  title="<?php echo $this->_tpl_vars['data']['label']; ?>
"><?php echo $this->_tpl_vars['data']['label']; ?>
</a>
											</td>
										<?php endif; ?>
									<?php else: ?>
										<td class="<?php echo $this->_tpl_vars['header']['align']; ?>
"><?php echo $this->_tpl_vars['data']; ?>
</td>
									<?php endif; ?>
								<?php endif; ?>
							<?php endforeach; endif; unset($_from); ?>
						<?php endif; ?>
					<?php endforeach; endif; unset($_from); ?>
				</tr>
			<?php endforeach; endif; unset($_from); ?>
        </tbody>
    </table>
</div>
<div class="bjui-pageFooter">
    <div class="pages">
        <span>每页&nbsp;</span>
        <div class="selectPagesize">
            <select data-toggle="selectpicker" data-toggle-change="changepagesize">
				<option value="15" <?php if ($this->_tpl_vars['filters']['pageSize'] == '15'): ?>selected<?php endif; ?>>15</option>
                <option value="20" <?php if ($this->_tpl_vars['filters']['pageSize'] == '20'): ?>selected<?php endif; ?>>20</option>
                <option value="50" <?php if ($this->_tpl_vars['filters']['pageSize'] == '50'): ?>selected<?php endif; ?>>50</option>
                <option value="100" <?php if ($this->_tpl_vars['filters']['pageSize'] == '100'): ?>selected<?php endif; ?>>100</option>
                <option value="200" <?php if ($this->_tpl_vars['filters']['pageSize'] == '200'): ?>selected<?php endif; ?>>200</option>
            </select>
        </div>
        <span>&nbsp;条，共 <?php echo $this->_tpl_vars['NOOFROWS']; ?>
 条</span>
    </div>
    <div class="pagination-box"  data-toggle="pagination" data-total="<?php echo $this->_tpl_vars['NOOFROWS']; ?>
" data-page-size="<?php echo $this->_tpl_vars['NUMPERPAGE']; ?>
" data-page-current="<?php echo $this->_tpl_vars['PAGENUM']; ?>
">
    </div>
</div>
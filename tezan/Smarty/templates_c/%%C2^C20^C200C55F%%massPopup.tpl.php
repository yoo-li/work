<?php /* Smarty version 2.6.18, created on 2017-06-29 14:11:13
         compiled from massPopup.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'massPopup.tpl', 29, false),array('modifier', 'lower', 'massPopup.tpl', 74, false),array('function', 'html_options', 'massPopup.tpl', 36, false),)), $this); ?>
<script language="JavaScript" type="text/javascript" src="modules/<?php echo $this->_tpl_vars['MODULE']; ?>
/<?php echo $this->_tpl_vars['MODULE']; ?>
.js"></script>
 

<div class="bjui-pageHeader">
    <form id="pagerForm" data-toggle="ajaxsearch" action="index.php" method="post">
	    <input type="hidden" name="module" value="<?php echo $this->_tpl_vars['MODULE']; ?>
"/>
	    <input type="hidden" name="filter" value="<?php echo $this->_tpl_vars['FILTER']; ?>
"/>
	    <input type="hidden" name="action" value="massPopup"/>
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
		
		<input type="hidden" name="filter" value="<?php echo $this->_tpl_vars['FILTER']; ?>
"/>
		<input type="hidden" name="callback" id="callback" value="<?php echo $this->_tpl_vars['CALLBACK']; ?>
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
	        <table data-nowrap="true" style="width:100%;">
				<tr>
					<td style="width:100%;">
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
						<?php if (((is_array($_tmp=$this->_tpl_vars['SEARCHCATEGORYS'])) ? $this->_run_mod_handler('count', true, $_tmp) : count($_tmp)) > 0): ?> 
									<span style="display: inline-block;margin-right: 10px;margin-top:1px;">
										<label>分类：</label>
										<select id="categorys" name ="categorys" data-toggle="selectpicker">
											<?php echo smarty_function_html_options(array('selected' => ($this->_tpl_vars['CATEGORYS']),'options' => $this->_tpl_vars['SEARCHCATEGORYS']), $this);?>

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
						</td>
				</tr>
				<tr>
					<td colspan="2" style="height:2px;">
						<div class="nav-tabs" style="margin-top:4px;margin-bottom:4px;"></div>
					</td>
				</tr>
			</table>
			<ul class="nav">
				<li><div class="pull-left"><a type="button" class="btn btn-default" onclick="confirm_select_<?php echo ((is_array($_tmp=$this->_tpl_vars['MODULE'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)); ?>
();" href="##" >确定</a></div></li>
			</ul>
        </div>
    </form>
</div>
<div id="masspopup_listview_entries" class="bjui-pageContent tableContent">
	  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "massPopupListViewEntries.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 
</div>
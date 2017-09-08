<?php /* Smarty version 2.6.18, created on 2017-08-21 16:47:50
         compiled from List.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'strtolower', 'List.tpl', 13, false),array('modifier', 'count', 'List.tpl', 17, false),)), $this); ?>
<script language="JavaScript" type="text/javascript" src="modules/<?php echo $this->_tpl_vars['MODULE']; ?>
/<?php echo $this->_tpl_vars['MODULE']; ?>
.js"></script>

<div class="bjui-pageHeader">
    <form id="pagerForm" name="pagerForm" data-toggle="ajaxsearch" action="index.php" method="post">
		<input type="hidden" name="module" value="<?php echo $this->_tpl_vars['MODULE']; ?>
"/>
		<input type="hidden" name="action" value="<?php if ($this->_tpl_vars['ACTION'] != ''): ?><?php echo $this->_tpl_vars['ACTION']; ?>
<?php else: ?>ListView<?php endif; ?>"/>
		<input type="hidden" name="parenttab" value="<?php echo $this->_tpl_vars['CATEGORY']; ?>
"/>
		<input type="hidden" name="pageNum" value="<?php echo $this->_tpl_vars['PAGENUM']; ?>
"/>
		<input type="hidden" name="numPerPage" value="<?php echo $this->_tpl_vars['NUMPERPAGE']; ?>
"/>	
		<input type="hidden" name="allRows" value="<?php echo $this->_tpl_vars['NOOFROWS']; ?>
"/>
		<input type="hidden" name="_order" value="<?php echo $this->_tpl_vars['ORDER_BY']; ?>
"/>
		<input type="hidden" name="_sort" value="<?php echo $this->_tpl_vars['ORDER']; ?>
"/>
		<input type="hidden" id="<?php echo strtolower($this->_tpl_vars['MODULE']); ?>
_viewid" name="viewid" value="<?php echo $this->_tpl_vars['VIEWID']; ?>
"/>
		<input type="hidden" name="__hash__" value="ff0146f931b6eab52136821c0e137737_f1aa993e20c19c1e1d618235cb38cf1d" />
        <div class="bjui-searchBar">
			<ul class="nav">
				<?php if (count($this->_tpl_vars['SEARCHPANEL']) > 0): ?>
					<li> 
						<?php $_from = $this->_tpl_vars['SEARCHPANEL']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['searchlabel'] => $this->_tpl_vars['searchdata']):
?>
						    <?php if ($this->_tpl_vars['searchdata']['newline'] == 'true'): ?>
									<span style="display: inline-block;margin-right: 10px;margin-top:4px;"><label><?php echo $this->_tpl_vars['searchlabel']; ?>
：</label><?php echo $this->_tpl_vars['searchdata']['search']; ?>
</span>
									<br>
							<?php else: ?>
									<span style="display: inline-block;margin-right: 10px;margin-top:4px;"><label><?php echo $this->_tpl_vars['searchlabel']; ?>
：</label><?php echo $this->_tpl_vars['searchdata']; ?>
</span>
							<?php endif; ?>
						<?php endforeach; endif; unset($_from); ?>
						<div class="pull-right" style="margin-right:14px;margin-top:4px;">
							<button class="btn-orange" type="submit" data-icon="search">查询</button>
			            </div>
					</li>
					<li class="nav-tabs" style="margin-top:4px;margin-bottom:4px;"></li>
				<?php endif; ?> 
				<li>
					<div class="pull-left">
			 			<script type="text/javascript">
				 			function refresh(json)
				 			{
								if (json.statusCode == 200){
									$(this)
										.bjuiajax('ajaxDone', json)
										.navtab('refresh')
								}else{
									$(this).bjuiajax('ajaxDone', json)
								}
				 			}
						</script>
						<?php $_from = $this->_tpl_vars['LISTVIEW_CHECK_BUTTON']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['data']):
?>
						    <?php if ($this->_tpl_vars['data'] == 'Delete'): ?>
							<a class="btn btn-default" data-icon="trash-o" data-callback="refresh" data-group="ids" data-toggle="doajaxchecked" href="index.php?module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=massdelete" data-confirm-msg="确实要删除这些记录吗?"><?php echo $this->_tpl_vars['APP']['LBL_DELETE_BUTTON_LABEL']; ?>
</a>	
						    <?php elseif ($this->_tpl_vars['data'] == 'SuperDelete'): ?>
							<a class="btn btn-default" data-icon="trash" data-group="ids" data-toggle="doajaxchecked" href="index.php?module=Public&action=superdelete&submodule=<?php echo $this->_tpl_vars['MODULE']; ?>
" data-confirm-msg="超级删除将直接删除这些记录，<br>可能存在风险，<br>确实要删除这些记录吗?"><span><?php echo $this->_tpl_vars['APP']['LBL_SUPERDELETE_BUTTON_LABEL']; ?>
</span></a>			
						    <?php elseif ($this->_tpl_vars['data'] == 'ExportExcel'): ?>
							<a class="btn btn-default" data-icon="file-excel-o" data-toggle="doexportchecked" href="index.php?mode=Export" data-confirm-msg="确定导出Excel文件吗?"><?php echo $this->_tpl_vars['APP']['LNK_EXPORTEXCEL']; ?>
</a>
						    <?php elseif ($this->_tpl_vars['data'] == 'EditView'): ?>
							<a data-id="edit" class="btn btn-default" data-icon="edit" href="index.php?module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=EditView" data-toggle="navtab" data-title="新建"><?php echo $this->_tpl_vars['APP']['LBL_NEW_BUTTON_LABEL']; ?>
</a>
			                <?php elseif ($this->_tpl_vars['data'] != ''): ?>
							<?php echo $this->_tpl_vars['data']; ?>

						    <?php endif; ?>
						<?php endforeach; endif; unset($_from); ?>
					</div> 
				</li>
			</ul>
		</div>
     </form>
</div>
<div class="bjui-pageContent tableContent">
    <table data-toggle="tablefixed" data-width="100%" data-nowrap="true">
        <thead>
            <tr>
				<th align="center" width="30px" maxwidth="20"><input type="checkbox" class="checkboxCtrl" data-group="ids" data-toggle="icheck"></th>
				<?php $_from = $this->_tpl_vars['LISTHEADER']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['listviewforeach'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['listviewforeach']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['header']):
        $this->_foreach['listviewforeach']['iteration']++;
?>
					<?php if ($this->_tpl_vars['header']['sort'] == 'true'): ?>
						<th align="center" width="<?php echo $this->_tpl_vars['header']['width']; ?>
%" height="35px;" data-order-field="<?php echo $this->_tpl_vars['key']; ?>
"><?php echo $this->_tpl_vars['header']['label']; ?>
</th> 
					<?php else: ?>
						<th align="center" width="<?php echo $this->_tpl_vars['header']['width']; ?>
%" height="35px;"><?php echo $this->_tpl_vars['header']['label']; ?>
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
             <tr data-id="<?php echo $this->_tpl_vars['entity_id']; ?>
">
				 <td align="center"><input type="checkbox" name="ids" data-toggle="icheck" value="<?php echo $this->_tpl_vars['entity_id']; ?>
"></td>
				<?php $_from = $this->_tpl_vars['entity']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['data']):
?>  	
				 		<?php $_from = $this->_tpl_vars['LISTHEADER']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['listviewforeach'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['listviewforeach']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['headkey'] => $this->_tpl_vars['header']):
        $this->_foreach['listviewforeach']['iteration']++;
?>					 			
				 			<?php if ($this->_foreach['listviewforeach']['iteration'] == $this->_tpl_vars['key']+1): ?>				
								<td align="<?php echo $this->_tpl_vars['header']['align']; ?>
" ><?php echo $this->_tpl_vars['data']; ?>
</td>
							<?php endif; ?>
						<?php endforeach; endif; unset($_from); ?> 
				<?php endforeach; endif; unset($_from); ?>
             </tr> 
   		  <?php endforeach; endif; unset($_from); ?> 
        </tbody>
    </table>
</div>
<div id="order_footer" class="bjui-pageFooter">
    <div class="pages"> 
        <span>共 <?php echo $this->_tpl_vars['NOOFROWS']; ?>
 条</span>
    </div> 
</div>
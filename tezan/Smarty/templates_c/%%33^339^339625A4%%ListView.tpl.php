<?php /* Smarty version 2.6.18, created on 2017-08-30 08:53:19
         compiled from ListView.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'strtolower', 'ListView.tpl', 20, false),array('modifier', 'count', 'ListView.tpl', 24, false),)), $this); ?>
<script language="javascript" type="text/javascript">
	$.ajaxSetup({ cache: true });
</script>
<script language="JavaScript" type="text/javascript" src="modules/<?php echo $this->_tpl_vars['MODULE']; ?>
/<?php echo $this->_tpl_vars['MODULE']; ?>
.js"></script>
<script language="javascript" type="text/javascript">
	$.ajaxSetup({ cache: false });
</script>

<?php if ($this->_tpl_vars['MSG']): ?><?php echo $this->_tpl_vars['MSG']; ?>
<?php endif; ?>
<div class="bjui-pageHeader">
	<form id="pagerForm" name="pagerForm" data-toggle="ajaxsearch" data-loadingmask="true" action="index.php" data-target="#refresh_listview_entries" method="post">
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
		<input type="hidden" name="__hash__" value="ff0146f931b6eab52136821c0e137737_f1aa993e20c19c1e1d618235cb38cf1d"/>
		<?php echo $this->_tpl_vars['CustomHiddenInput']; ?>

		<div class="bjui-searchBar">
			<?php if (count($this->_tpl_vars['SEARCHPANEL']) > 0): ?>
				<table data-nowrap="true" style="width:100%;">
					<tr>
						<td style="width:100%;">
							<?php if ($this->_tpl_vars['SEARCHTYPE'] == 1): ?>
								<table data-nowrap="true" style="width:100%;">
									<?php $_from = $this->_tpl_vars['SEARCHPANEL']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['search'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['search']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['searchlabel'] => $this->_tpl_vars['searchdata']):
        $this->_foreach['search']['iteration']++;
?>
									<?php if (($this->_foreach['search']['iteration'] <= 1)): ?>
										<tr>
									<?php elseif ($this->_foreach['search']['iteration'] % 2 == 1): ?>
										</tr><tr>
									<?php endif; ?>
										<td width="50%">
											<span style="display: inline-block;margin-right: 10px;width:100%;margin-top: 4px;"><label style="font-weight: normal;"><?php echo $this->_tpl_vars['searchlabel']; ?>
：</label><?php echo $this->_tpl_vars['searchdata']; ?>
</span>
										</td>
									<?php if (($this->_foreach['search']['iteration'] == $this->_foreach['search']['total'])): ?>
										</tr>
									<?php endif; ?>
									<?php endforeach; endif; unset($_from); ?>
								</table>
							<?php else: ?>
								<?php $_from = $this->_tpl_vars['SEARCHPANEL']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['searchlabel'] => $this->_tpl_vars['searchdata']):
?>
									<?php if ($this->_tpl_vars['searchdata']['newline'] == 'true'): ?>
										<span style="display: inline-block;margin-right: 10px;margin-top:4px;"><label style="font-weight: normal;"><?php echo $this->_tpl_vars['searchlabel']; ?>

												：</label><?php echo $this->_tpl_vars['searchdata']['search']; ?>
</span>
										<br>
									<?php else: ?>
										<span style="display: inline-block;margin-right: 10px;margin-top:4px;"><label style="font-weight: normal;"><?php echo $this->_tpl_vars['searchlabel']; ?>

												：</label><?php echo $this->_tpl_vars['searchdata']; ?>
</span>
									<?php endif; ?>
								<?php endforeach; endif; unset($_from); ?>
							<?php endif; ?>
						</td>
						<td style="padding-right:14px;width:78px;vertical-align:bottom;">
							<script type="text/javascript">
								<?php echo '
								function getPostParams(){
									var paramstr = "";
									$.CurrentNavtab.find("#pagerForm").find("input").each(function(e,obj){
										if(paramstr == ""){
											paramstr = $(obj).attr("name") + "=" + $(obj).val();
										}else{
											paramstr += "&"+$(obj).attr("name") + "=" + $(obj).val();
										}
									});
									$.CurrentNavtab.find("#pagerForm").find("select").each(function(e,obj){
										if(paramstr == ""){
											paramstr = $(obj).attr("name") + "=" + $(obj).val();
										}else{
											paramstr += "&"+$(obj).attr("name") + "=" + $(obj).val();
										}
									});
									return paramstr;
								}
								function ajaxsearchFrame(){
									if($.CurrentNavtab.find("#refresh_listview_entries")){
										var paramstr = getPostParams();
										var postBody = "index.php?mode=ajax&"+paramstr;
										$.CurrentNavtab.find("#refresh_listview_entries").ajaxUrl({url:postBody, loadingmask:true})
									}
								}
							'; ?>

							</script>
							<button class="btn-orange" type="button" onclick="ajaxsearchFrame();" data-icon="search">查询</button>
						</td>
					</tr>
					<tr>
						<td colspan="2" style="height:2px;">
							<div class="nav-tabs" style="margin-top:4px;margin-bottom:4px;"></div>
						</td>
					</tr>
				</table>
			<?php endif; ?>
			<?php if (((is_array($_tmp=$this->_tpl_vars['LISTVIEW_CHECK_BUTTON'])) ? $this->_run_mod_handler('count', true, $_tmp) : count($_tmp)) > 0 || ((is_array($_tmp=$this->_tpl_vars['CUSTOMVIEW_OPTION'])) ? $this->_run_mod_handler('count', true, $_tmp) : count($_tmp)) > 0): ?>
				<ul class="nav">
				<li>
					<div class="pull-left" style="line-height:28px;">
						<script type="text/javascript">
							function refresh(json)
							{
								if (json.statusCode == 200)
								{
									$(this)
											.bjuiajax('ajaxDone', json)
											.navtab('refresh');
									}
								else
								{
									$(this).bjuiajax('ajaxDone', json);
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
" data-confirm-msg="超级删除将直接删除这些记录，<br>可能存在风险，<br>确实要删除这些记录吗?"><?php echo $this->_tpl_vars['APP']['LBL_SUPERDELETE_BUTTON_LABEL']; ?>
</a>
							<?php elseif ($this->_tpl_vars['data'] == 'ExportExcel'): ?>
								<a class="btn btn-default" data-icon="file-excel-o" onclick="<?php echo $this->_tpl_vars['MODULE']; ?>
ExportExcel();" ><?php echo $this->_tpl_vars['APP']['LNK_EXPORTEXCEL']; ?>
</a>
								<script type="text/javascript">
									function <?php echo $this->_tpl_vars['MODULE']; ?>
ExportExcel()
									{
										var ids      = [],
											$checks  = $.CurrentNavtab.find(':checkbox[name=ids]:checked');
										if (!$checks.length) {
											BJUI.alertmsg('error', BJUI.regional.notchecked)
											return
											}
										$checks.each(function() {
											ids.push($(this).val())
											})
										$('<form action="index.php" method="post">' +
										  '<input type="hidden" name="module" value="<?php echo $this->_tpl_vars['MODULE']; ?>
"/>' +
										  '<input type="hidden" name="action" value="ListView"/>' +
										  '<input type="hidden" name="mode" value="Export"/>' +
										  '<input type="hidden" name="ids" value="'+ids.join(',')+'"/>').appendTo('body').submit().remove();
										}
								</script>
							<?php elseif ($this->_tpl_vars['data'] == 'EditView'): ?>
								<a data-id="edit" class="btn btn-default" data-icon="edit" href="index.php?module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=EditView" data-toggle="navtab" data-title="新建"><?php echo $this->_tpl_vars['APP']['LBL_NEW_BUTTON_LABEL']; ?>
</a>
							<?php elseif ($this->_tpl_vars['data'] == 'MassSendApprove'): ?>
								<a class="btn btn-default" data-icon="edit" data-group="ids" data-toggle="doajaxchecked" href="index.php?module=Approvals&action=sendApprove&formodule=<?php echo ((is_array($_tmp=$this->_tpl_vars['MODULE'])) ? $this->_run_mod_handler('strtolower', true, $_tmp) : strtolower($_tmp)); ?>
" data-confirm-msg="确实要提交审批这些记录吗?">提交审批</a>
							<?php elseif ($this->_tpl_vars['data']['key'] == 'ModuleReport'): ?>
								<?php $this->assign('modulereport', $this->_tpl_vars['data']['value']); ?>
							<?php elseif ($this->_tpl_vars['data'] != ''): ?>
								<?php echo $this->_tpl_vars['data']; ?>

							<?php endif; ?>
						<?php endforeach; endif; unset($_from); ?>
					</div>
					<div class="pull-right" style="line-height:28px;margin-right:14px;margin-top: 0px;">
						<script type="text/javascript">
							function showDefaultCustomView()
							{
								var viewid = $('#<?php echo strtolower($this->_tpl_vars['MODULE']); ?>
_viewname').val();
								$('#<?php echo strtolower($this->_tpl_vars['MODULE']); ?>
_viewid').val(viewid);
								$("#pagerForm").bjuiajax('pageCallback');
								}
							function deleteview()
							{
								$(this).alertmsg('confirm', '您确实要删除这个视图吗?', {
									okCall: function ()
									{
										var postBody = 'module=CustomView&dmodule=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=Delete&record=<?php echo $this->_tpl_vars['VIEWID']; ?>
';
										$.post("index.php", postBody,
													function (data, textStatus)
													{
														$('#<?php echo strtolower($this->_tpl_vars['MODULE']); ?>
_viewid').val('');
														$("#pagerForm").bjuiajax('pageCallback');
														});
										}
									});
								}
						</script>
						<label style="margin-top:8px;font-weight: normal;">自定义视图：</label>
						<select data-toggle="selectpicker" name="viewname" id="<?php echo strtolower($this->_tpl_vars['MODULE']); ?>
_viewname" onchange="showDefaultCustomView();"><?php echo $this->_tpl_vars['CUSTOMVIEW_OPTION']; ?>
</select>
						<a class="btn btn-default" data-icon="plus" title="<?php echo $this->_tpl_vars['APP']['LNK_CV_ADD']; ?>
" href="index.php?module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=CustomView" data-title="新建自定义视图" data-toggle="dialog" data-width="700" data-height="300" data-id="dialog-mask" data-mask="true" data-resizable="false" data-maxable="false"></a>
						<?php if ($this->_tpl_vars['CV_EDIT_PERMIT'] != 'yes'): ?>
							<a class="btn btn-default disabled" data-icon="pencil" disabled title="<?php echo $this->_tpl_vars['APP']['LNK_CV_EDIT']; ?>
"></a>
							<a class="btn btn-default disabled" data-icon="trash-o" disabled title="<?php echo $this->_tpl_vars['APP']['LNK_CV_DELETE']; ?>
"></a>
						<?php else: ?>
							<a class="btn btn-default" data-icon="pencil" title="<?php echo $this->_tpl_vars['APP']['LNK_CV_EDIT']; ?>
" href="index.php?module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=CustomView&record=<?php echo $this->_tpl_vars['VIEWID']; ?>
" data-title="编辑自定义视图" data-toggle="dialog" data-width="700" data-height="300" data-id="dialog-mask" data-mask="true" data-resizable="false" data-maxable="false"></a>
							<a class="btn btn-default" data-icon="trash-o" title="<?php echo $this->_tpl_vars['APP']['LNK_CV_DELETE']; ?>
" onclick="deleteview();"></a>
						<?php endif; ?>
					</div>
				</li>
			</ul>
			<?php endif; ?>
		</div>
	</form>
</div>
<?php if ($this->_tpl_vars['ZTREEDATA'] == ''): ?>
	<div id="refresh_listview_entries" class="bjui-pageContent tableContent bjui-resizeGrid">
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "ListViewEntries.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	</div>
<?php else: ?>
	<div class="bjui-pageContent tableContent tree-left-box" style="width:30%;">
		<?php echo $this->_tpl_vars['ZTREEDATA']; ?>

	</div>
	<div id="refresh_listview_entries" class="bjui-pageContent tableContent bjui-resizeGrid" style="left: 30%;width:70%;">
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "ListViewEntries.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	</div>
<?php endif; ?>
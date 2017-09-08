<?php /* Smarty version 2.6.18, created on 2017-08-15 17:18:25
         compiled from EditProfile.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getTranslatedString', 'EditProfile.tpl', 92, false),)), $this); ?>

<link href="/Public/css/favorite.css" rel="stylesheet" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="modules/Profiles/Profiles.css">
<div class="bjui-pageContent" >
	<form name="profileform" action="index.php" data-toggle="validate" data-alertmsg="false" method="post">
		<input type="hidden" name="module" value="<?php echo $this->_tpl_vars['MODULE']; ?>
">
		<input type="hidden" name="action" value="UpdateProfileChanges">
		<input type="hidden" name="record" value="<?php echo $this->_tpl_vars['ID']; ?>
">
		<input type="hidden" name="mode" value="<?php echo $this->_tpl_vars['MODE']; ?>
">
		<input type="hidden" name="__hash__" value="f05447c821012018c16dec99264a7bdc_ea332f4bef78750abe1e93924eaf44f8" />

		<div class="pageFormContent">
			<table border="0" cellpadding="10" cellspacing="0" width="100%">
				<tbody><tr>
					<td>
						<table border="0" cellpadding="5" cellspacing="0" width="100%"><tbody><tr><td class="cellLabel big"> <?php echo $this->_tpl_vars['CMOD']['LBL_SUPER_USER_PRIV']; ?>
 </td></tr></tbody></table>
						<table class="small" align="center" border="0" cellpadding="5" cellspacing="0" width="90%">
							<tbody>
							<tr>
								<td class="prvPrfTexture" style="width: 20px;">&nbsp;</td>
								<td valign="top" width="97%">
									<table class="small" border="0" cellpadding="2" cellspacing="0" width="100%">
										<tbody>
										<?php if ($this->_tpl_vars['PROFILESINFO']['profilename'] != 'Boss'): ?>
											<tr id="gva">
												<td valign="top">
													<input data-toggle="icheck" type="checkbox" id="view_all_chk" name="view_all" <?php if ($this->_tpl_vars['PROFILESINFO']['view_all'] == '0'): ?>checked<?php endif; ?>>
												</td>
												<td ><label class="control-label" for="view_all_chk"><?php echo $this->_tpl_vars['CMOD']['LBL_VIEW_ALL']; ?>
</label></td>
											</tr>
											<tr>
												<td valign="top"></td>
												<td width="100%" ><?php echo $this->_tpl_vars['CMOD']['LBL_ALLOW']; ?>
 "<?php echo $this->_tpl_vars['PROFILESINFO']['profilename']; ?>
" <?php echo $this->_tpl_vars['CMOD']['LBL_MESG_VIEW']; ?>
</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
											</tr>
											<tr>
												<td valign="top">
													<input data-toggle="icheck" type="checkbox" id="edit_all_chk" name="edit_all" <?php if ($this->_tpl_vars['PROFILESINFO']['edit_all'] == '0'): ?>checked<?php endif; ?>>
												</td>
												<td ><label class="control-label" for="edit_all_chk"><?php echo $this->_tpl_vars['CMOD']['LBL_EDIT_ALL']; ?>
</label></td>
											</tr>
											<tr>
												<td valign="top"></td>
												<td > <?php echo $this->_tpl_vars['CMOD']['LBL_ALLOW']; ?>
 "<?php echo $this->_tpl_vars['PROFILESINFO']['profilename']; ?>
" <?php echo $this->_tpl_vars['CMOD']['LBL_MESG_EDIT']; ?>
</td>
											</tr>
										<?php else: ?>
											<tr>
												<td valign="top"><input data-toggle="icheck" type="checkbox" <?php if ($this->_tpl_vars['PROFILESINFO']['superdeleted'] == '1'): ?>checked<?php endif; ?> name="superdelete"  id="superdelete"></td>
												<td ><label class="control-label" for="superdelete"><?php echo $this->_tpl_vars['CMOD']['LBL_SUPERDELETE']; ?>
</label></td>
											</tr>
											<tr>
												<td valign="top"></td>
												<td > <?php echo $this->_tpl_vars['CMOD']['LBL_SUPERDELETE_DESCRIPTION']; ?>
</td>
											</tr>
										<?php endif; ?>
										</tbody>
									</table>
								</td>
							</tr>
							</tbody>
						</table>
						<?php if ($this->_tpl_vars['PROFILESINFO']['profilename'] != 'Boss'): ?>
							<br>
							<table border="0" cellpadding="5" cellspacing="0" width="100%">
								<tbody>
								<tr><td class="cellLabel big"> <?php echo $this->_tpl_vars['CMOD']['LBL_SET_PRIV_FOR_EACH_MODULE']; ?>
 </td></tr>
								</tbody>
							</table>

							<table class="small" align="center" border="0" cellpadding="5" cellspacing="0" width="90%">
								<tbody>
								<tr>
									<td class="prvPrfTexture" style="width: 20px;">&nbsp;</td>
									<td valign="top" width="97%">
										<table class="small listTable" border="0" cellpadding="5" cellspacing="0" width="100%">
											<tbody>
											<tr id="gva">
												<td colspan="2" rowspan="2" class="small colHeader" style="border-left:medium none #ffffff;background-size:100% 100%"><strong> <?php echo $this->_tpl_vars['CMOD']['LBL_TAB_MESG_OPTION']; ?>
 </strong></td>
												<td colspan="3" class="small colHeader"><div align="center"><strong><?php echo $this->_tpl_vars['CMOD']['LBL_EDIT_PERMISSIONS']; ?>
</strong></div></td>
												<td rowspan="2" class="small colHeader" style="background-size:100% 100%" nowrap="nowrap"><?php echo $this->_tpl_vars['CMOD']['LBL_FIELDS_AND_TOOLS_SETTINGS']; ?>
</td>
											</tr>
											<tr id="gva">
												<td class="small colHeader"><div align="center"><strong><?php echo $this->_tpl_vars['CMOD']['LBL_CREATE_EDIT']; ?>
</strong></div></td>
												<td class="small colHeader"> <div align="center"><strong><?php echo $this->_tpl_vars['CMOD']['LBL_VIEW']; ?>
</strong></div></td>
												<td class="small colHeader"> <div align="center"><strong><?php echo $this->_tpl_vars['CMOD']['LBL_DELETE']; ?>
</strong></div></td>
											</tr>
											<!-- module loops-->
											<?php $_from = $this->_tpl_vars['PROFILESINFO']['tabmodules']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['parentname'] => $this->_tpl_vars['elements']):
?>
												<tr style="height: 30px;">
													<td colspan="6" class="small cellLabel"><strong><?php echo ((is_array($_tmp=$this->_tpl_vars['parentname'])) ? $this->_run_mod_handler('getTranslatedString', true, $_tmp) : getTranslatedString($_tmp)); ?>
</strong></td>
												</tr>
												<?php $_from = $this->_tpl_vars['elements']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['tabid'] => $this->_tpl_vars['modules']):
?>
													<tr style="height: 40px;">
														<td style="width: 5%;"></td>
														<td class="small cellLabel" width="40%">
															<input data-toggle="icheck" class="tab_chk_com" data-id="<?php echo $this->_tpl_vars['tabid']; ?>
" type="checkbox" data-label="<?php echo ((is_array($_tmp=$this->_tpl_vars['modules']['modulename'])) ? $this->_run_mod_handler('getTranslatedString', true, $_tmp) : getTranslatedString($_tmp)); ?>
" id="tab_chk_com_<?php echo $this->_tpl_vars['tabid']; ?>
" name="<?php echo $this->_tpl_vars['tabid']; ?>
_tab" <?php if ($this->_tpl_vars['modules']['module'] == '0'): ?>checked<?php endif; ?>>
														</td>
														<td class="small cellText" width="15%">
															<div align="center">
																<input data-toggle="icheck" class="tab_chk_editview" data-id="<?php echo $this->_tpl_vars['tabid']; ?>
" type="checkbox" id="tab_chk_editview_<?php echo $this->_tpl_vars['tabid']; ?>
" name="<?php echo $this->_tpl_vars['tabid']; ?>
_editview" <?php if ($this->_tpl_vars['modules']['editview'] == '0' && $this->_tpl_vars['modules']['module'] == '0'): ?>checked<?php endif; ?>>
															</div>
														</td>
														<td class="small cellText" width="15%">
															<div align="center">
																<input data-toggle="icheck" class="tab_chk_index" data-id="<?php echo $this->_tpl_vars['tabid']; ?>
" type="checkbox" id="tab_chk_index_<?php echo $this->_tpl_vars['tabid']; ?>
" name="<?php echo $this->_tpl_vars['tabid']; ?>
_index" <?php if ($this->_tpl_vars['modules']['listview'] == '0' && $this->_tpl_vars['modules']['module'] == '0'): ?>checked<?php endif; ?>>
															</div>
														</td>
														<td class="small cellText" width="15%">
															<div align="center">
																<input data-toggle="icheck" class="tab_chk_delete" data-id="<?php echo $this->_tpl_vars['tabid']; ?>
" type="checkbox" id="tab_chk_delete_<?php echo $this->_tpl_vars['tabid']; ?>
" name="<?php echo $this->_tpl_vars['tabid']; ?>
_delete" <?php if ($this->_tpl_vars['modules']['delete'] == '0' && $this->_tpl_vars['modules']['module'] == '0'): ?>checked<?php endif; ?>>
															</div>
														</td>
														<td class="small cellLabel" width="22%">
															<div align="center">
																<img src="/Public/images/showDown.gif" id="img_<?php echo $this->_tpl_vars['tabid']; ?>
" alt="<?php echo $this->_tpl_vars['APP']['LBL_EXPAND_COLLAPSE']; ?>
" title="<?php echo $this->_tpl_vars['APP']['LBL_EXPAND_COLLAPSE']; ?>
" onclick="fnToggleVIew('<?php echo $this->_tpl_vars['tabid']; ?>
_view','<?php echo $this->_tpl_vars['tabid']; ?>
','<?php echo $this->_tpl_vars['ID']; ?>
')" border="0" height="16" width="40" style="display:none;cursor:pointer;">
															</div>
														</td>
													</tr>
													<tr class="hideTable" id="<?php echo $this->_tpl_vars['tabid']; ?>
_view" className="hideTable">
														<td style="width: 5%;"></td>
														<td colspan="5" class="small settingsSelectedUI" style="border-bottom:1px solid #dadada;border-left:1px solid #dadada;">
															<table  id="<?php echo $this->_tpl_vars['tabid']; ?>
_fields" class="small" border="0" cellpadding="2" cellspacing="0" width="100%">
																<tbody>
																<tr>
																	<input type="hidden" id="load_<?php echo $this->_tpl_vars['tabid']; ?>
_fields" name="load_<?php echo $this->_tpl_vars['tabid']; ?>
_fields" value="0">
																	<td class="small colHeader" colspan="6" valign="top"><?php echo $this->_tpl_vars['CMOD']['LBL_FIELDS_TO_BE_SHOWN']; ?>
</td>
																</tr>
																</tbody>
															</table>
														</td>
													</tr>
												<?php endforeach; endif; unset($_from); ?>
											<?php endforeach; endif; unset($_from); ?>
											</tbody>
										</table>
									</td>
								</tr>
								</tbody>
							</table>
						<?php endif; ?>
				</tbody>
			</table>
		</div>
	</form>
</div>

<div class="bjui-pageFooter">
	<ul>
		<li><button type="button" class="btn-close" data-icon="close"><?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
</button></li>
		<li><button type="submit" <?php if ($this->_tpl_vars['READONLY'] == 'true'): ?>disabled<?php endif; ?> class="btn-green" data-icon="save"><?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
</button></li>
	</ul>
</div>


<script language="javascript" type="text/javascript">
	<?php echo '
	function fnToggleVIew(obj,tabid,profileid){
		$.CurrentNavtab.find(\'#\'+obj).each(function(){
			if($(this).data("isload")){
				if($(this).hasClass(\'hideTable\')){
					$(this).removeClass(\'hideTable\')
				}else{
					$(this).addClass(\'hideTable\')
				}
			}else{
				var obj = $(this);
				$(this).bjuiajax(\'doAjax\',{
					url:\'index.php?module=Profiles&action=getProfilesFields&tabid=\'+tabid + \'&profileid=\' + profileid,
					type:\'GET\',
					loadingmask:true,
					callback:function(json){
						if(json.statusCode == \'200\'){
							var fieldhtml;
							$.each(json.fields, function(i,item){
								$.each(item, function(j,row){
									fieldhtml += \'<tr>\';
									$.each(row, function(k,col){
										fieldhtml += \'<td valign="top" style="width: 24px;">\'+col[1]+\'</td>\';
										fieldhtml += \'<td>\'+col[0]+\'</td>\';
									});
									fieldhtml += "</tr>";
								});
							});
							obj.find("#load_"+tabid+"_fields").val("1");
							obj.find("#"+tabid+"_fields").append(fieldhtml).initui();
							obj.data("isload",true);
							if(obj.hasClass(\'hideTable\')){
								obj.removeClass(\'hideTable\')
							}else{
								obj.addClass(\'hideTable\')
							}
						}
					}
				});
			}
		});
	}

	$.CurrentNavtab.find(\'#view_all_chk\').on(\'ifClicked\',function(e){
		var checked = $(this).is(\':checked\');
		if(!checked)
		{
			$.CurrentNavtab.find(".listTable").find("input[type=checkbox]").each(function (e, obj)
																				 {
																					 var $objid = $(obj).attr("id");
																					 if ($objid.indexOf(\'tab_chk_com_\') != -1 ||
																						 $objid.indexOf(\'tab_chk_index_\') != -1
																					 )
																					 {
																						 $(obj).iCheck(\'check\');
																					 }
																				 })
		}else{
			$.CurrentNavtab.find(".listTable").find("input[type=checkbox]").each(function (e, obj)
																				 {
																					 var $objid = $(obj).attr("id");
																					 if ($objid.indexOf(\'tab_chk_com_\') != -1 ||
																						 $objid.indexOf(\'tab_chk_index_\') != -1 ||
																						 $objid.indexOf(\'tab_chk_editview_\') != -1 ||
																						 $objid.indexOf(\'tab_chk_delete_\') != -1
																					 )
																					 {
																						 $(obj).iCheck(\'uncheck\');
																					 }
																				 })
			unselect_edit_all();
		}
		showAllImages();
	})

	function showAllImages()
	{
		$.CurrentNavtab.find(\'.tab_chk_com\').each(function(){
			var checked = $(this).is(\':checked\');
			var id = $(this).data("id");
			var imageid = \'#img_\'+id;
			if(checked){
				if($.CurrentNavtab.find(imageid))
					$.CurrentNavtab.find(imageid).css(\'display\',\'block\');
			}else{
				if($.CurrentNavtab.find(imageid))
					$.CurrentNavtab.find(imageid).css(\'display\',\'none\');
			}
		});
	}

	$.CurrentNavtab.find(\'#edit_all_chk\').on(\'ifClicked\',function(e){
		var checked = $(this).is(\':checked\');
		if(!checked){
			$.CurrentNavtab.find(".listTable").find("input[type=checkbox]").each(function (e, obj)
																				 {
																					 var $objid = $(obj).attr("id");
																					 if ($objid.indexOf(\'tab_chk_com_\') != -1 ||
																						 $objid.indexOf(\'tab_chk_index_\') != -1 ||
																						 $objid.indexOf(\'tab_chk_editview_\') != -1 ||
																						 $objid.indexOf(\'tab_chk_delete_\') != -1
																					 )
																					 {
																						 $(obj).iCheck(\'check\');
																					 }
																				 })
			$.CurrentNavtab.find(\'#view_all_chk\').iCheck(\'check\');
			showAllImages();
		}else{
			$.CurrentNavtab.find(".listTable").find("input[type=checkbox]").each(function (e, obj)
																				 {
																					 var $objid = $(obj).attr("id");
																					 if (
																						 $objid.indexOf(\'tab_chk_editview_\') != -1 ||
																						 $objid.indexOf(\'tab_chk_delete_\') != -1
																					 )
																					 {
																						 $(obj).iCheck(\'uncheck\');
																					 }
																				 })
		}
	})

	function unselect_edit_all()
	{
		$.CurrentNavtab.find(\'#edit_all_chk\').iCheck(\'uncheck\');
	}
	function unselect_view_all()
	{
		$.CurrentNavtab.find(\'#view_all_chk\').iCheck(\'uncheck\');
	}
	$.CurrentNavtab.find(\'.tab_chk_index\').on(\'ifClicked\',function(e){
		var checked = $(this).is(\':checked\');
		var id = $(this).data("id");
		var createid = \'#tab_chk_editview_\'+id;
		var deleteid = \'#tab_chk_delete_\'+id;
		var tab_id = \'#tab_chk_com_\'+id;
		if(!checked){
			var imageid = \'#img_\'+id;
			if($.CurrentNavtab.find(imageid))
				$.CurrentNavtab.find(imageid).css(\'display\',\'block\');
			$.CurrentNavtab.find(tab_id).iCheck(\'check\');
		}else{
			unselect_view_all();
			unselect_edit_all();
			$.CurrentNavtab.find(createid).iCheck(\'uncheck\');
			$.CurrentNavtab.find(deleteid).iCheck(\'uncheck\');
			$.CurrentNavtab.find(tab_id).iCheck(\'uncheck\');
		}
		showAllImages();
	})
	$.CurrentNavtab.find(\'.tab_chk_editview\').on(\'ifClicked\',function(e){
		var checked = $(this).is(\':checked\');
		var id = $(this).data("id");
		var viewid = \'#tab_chk_index_\'+id;
		var tab_id = \'#tab_chk_com_\'+id;
		if(!checked){
			var imageid = \'#img_\'+id;
			if($.CurrentNavtab.find(imageid))
				$.CurrentNavtab.find(imageid).css(\'display\',\'block\');
			$.CurrentNavtab.find(tab_id).iCheck(\'check\');
			$.CurrentNavtab.find(viewid).iCheck(\'check\');
		}else{
			unselect_edit_all();
		}
	})
	$.CurrentNavtab.find(\'.tab_chk_delete\').on(\'ifClicked\',function(e){
		var checked = $(this).is(\':checked\');
		var id = $(this).data("id");
		var viewid = \'#tab_chk_index_\'+id;
		var tab_id = \'#tab_chk_com_\'+id;
		if(!checked){
			var imageid = \'#img_\'+id;
			if($.CurrentNavtab.find(imageid))
				$.CurrentNavtab.find(imageid).css(\'display\',\'block\');
			$.CurrentNavtab.find(tab_id).iCheck(\'check\');
			$.CurrentNavtab.find(viewid).iCheck(\'check\');
		}
	})
	$.CurrentNavtab.find(\'.tab_chk_com\').on(\'ifClicked\',function(e){
		var checked = $(this).is(\':checked\');
		var id = $(this).data("id");
		var createid = \'#tab_chk_editview_\'+id;
		var viewid = \'#tab_chk_index_\'+id;
		var deleteid = \'#tab_chk_delete_\'+id;
		var imageid = \'#img_\'+id;
		var contid = \'#\'+id+\'_view\';
		if(!checked){
			if($.CurrentNavtab.find(imageid))
				$.CurrentNavtab.find(imageid).css(\'display\',\'block\');
			$.CurrentNavtab.find(createid).iCheck(\'check\');
			$.CurrentNavtab.find(viewid).iCheck(\'check\');
			$.CurrentNavtab.find(deleteid).iCheck(\'check\');
		}else {
			unselect_view_all();
			unselect_edit_all();
			if($.CurrentNavtab.find(imageid))
				$.CurrentNavtab.find(imageid).css(\'display\',\'none\');
			$.CurrentNavtab.find(createid).iCheck(\'uncheck\');
			$.CurrentNavtab.find(viewid).iCheck(\'uncheck\');
			$.CurrentNavtab.find(deleteid).iCheck(\'uncheck\');
			$.CurrentNavtab.find(contid).addClass(\'hideTable\');
		}
	})

	showAllImages();
	'; ?>

</script>
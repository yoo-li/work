
<link href="/Public/css/favorite.css" rel="stylesheet" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="modules/Profiles/Profiles.css">
<div class="bjui-pageContent" >
	<form name="profileform" action="index.php" data-toggle="validate" data-alertmsg="false" method="post">
		<input type="hidden" name="module" value="{$MODULE}">
		<input type="hidden" name="action" value="UpdateProfileChanges">
		<input type="hidden" name="record" value="{$ID}">
		<input type="hidden" name="mode" value="{$MODE}">
		<input type="hidden" name="__hash__" value="f05447c821012018c16dec99264a7bdc_ea332f4bef78750abe1e93924eaf44f8" />

		<div class="pageFormContent">
			<table border="0" cellpadding="10" cellspacing="0" width="100%">
				<tbody><tr>
					<td>
						<table border="0" cellpadding="5" cellspacing="0" width="100%"><tbody><tr><td class="cellLabel big"> {$CMOD.LBL_SUPER_USER_PRIV} </td></tr></tbody></table>
						<table class="small" align="center" border="0" cellpadding="5" cellspacing="0" width="90%">
							<tbody>
							<tr>
								<td class="prvPrfTexture" style="width: 20px;">&nbsp;</td>
								<td valign="top" width="97%">
									<table class="small" border="0" cellpadding="2" cellspacing="0" width="100%">
										<tbody>
										{if $PROFILESINFO.profilename neq 'Boss'}
											<tr id="gva">
												<td valign="top">
													<input data-toggle="icheck" type="checkbox" id="view_all_chk" name="view_all" {if $PROFILESINFO.view_all eq '0'}checked{/if}>
												</td>
												<td ><label class="control-label" for="view_all_chk">{$CMOD.LBL_VIEW_ALL}</label></td>
											</tr>
											<tr>
												<td valign="top"></td>
												<td width="100%" >{$CMOD.LBL_ALLOW} "{$PROFILESINFO.profilename}" {$CMOD.LBL_MESG_VIEW}</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
											</tr>
											<tr>
												<td valign="top">
													<input data-toggle="icheck" type="checkbox" id="edit_all_chk" name="edit_all" {if $PROFILESINFO.edit_all eq '0'}checked{/if}>
												</td>
												<td ><label class="control-label" for="edit_all_chk">{$CMOD.LBL_EDIT_ALL}</label></td>
											</tr>
											<tr>
												<td valign="top"></td>
												<td > {$CMOD.LBL_ALLOW} "{$PROFILESINFO.profilename}" {$CMOD.LBL_MESG_EDIT}</td>
											</tr>
										{else}
											<tr>
												<td valign="top"><input data-toggle="icheck" type="checkbox" {if $PROFILESINFO.superdeleted eq '1'}checked{/if} name="superdelete"  id="superdelete"></td>
												<td ><label class="control-label" for="superdelete">{$CMOD.LBL_SUPERDELETE}</label></td>
											</tr>
											<tr>
												<td valign="top"></td>
												<td > {$CMOD.LBL_SUPERDELETE_DESCRIPTION}</td>
											</tr>
										{/if}
										</tbody>
									</table>
								</td>
							</tr>
							</tbody>
						</table>
						{if $PROFILESINFO.profilename neq 'Boss'}
							<br>
							<table border="0" cellpadding="5" cellspacing="0" width="100%">
								<tbody>
								<tr><td class="cellLabel big"> {$CMOD.LBL_SET_PRIV_FOR_EACH_MODULE} </td></tr>
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
												<td colspan="2" rowspan="2" class="small colHeader" style="border-left:medium none #ffffff;background-size:100% 100%"><strong> {$CMOD.LBL_TAB_MESG_OPTION} </strong></td>
												<td colspan="3" class="small colHeader"><div align="center"><strong>{$CMOD.LBL_EDIT_PERMISSIONS}</strong></div></td>
												<td rowspan="2" class="small colHeader" style="background-size:100% 100%" nowrap="nowrap">{$CMOD.LBL_FIELDS_AND_TOOLS_SETTINGS}</td>
											</tr>
											<tr id="gva">
												<td class="small colHeader"><div align="center"><strong>{$CMOD.LBL_CREATE_EDIT}</strong></div></td>
												<td class="small colHeader"> <div align="center"><strong>{$CMOD.LBL_VIEW}</strong></div></td>
												<td class="small colHeader"> <div align="center"><strong>{$CMOD.LBL_DELETE}</strong></div></td>
											</tr>
											<!-- module loops-->
											{foreach key=parentname item=elements from=$PROFILESINFO.tabmodules}
												<tr style="height: 30px;">
													<td colspan="6" class="small cellLabel"><strong>{$parentname|getTranslatedString}</strong></td>
												</tr>
												{foreach key=tabid item=modules from=$elements}
													<tr style="height: 40px;">
														<td style="width: 5%;"></td>
														<td class="small cellLabel" width="40%">
															<input data-toggle="icheck" class="tab_chk_com" data-id="{$tabid}" type="checkbox" data-label="{$modules.modulename|getTranslatedString}" id="tab_chk_com_{$tabid}" name="{$tabid}_tab" {if $modules.module eq '0'}checked{/if}>
														</td>
														<td class="small cellText" width="15%">
															<div align="center">
																<input data-toggle="icheck" class="tab_chk_editview" data-id="{$tabid}" type="checkbox" id="tab_chk_editview_{$tabid}" name="{$tabid}_editview" {if $modules.editview eq '0' && $modules.module eq '0'}checked{/if}>
															</div>
														</td>
														<td class="small cellText" width="15%">
															<div align="center">
																<input data-toggle="icheck" class="tab_chk_index" data-id="{$tabid}" type="checkbox" id="tab_chk_index_{$tabid}" name="{$tabid}_index" {if $modules.listview eq '0' && $modules.module eq '0'}checked{/if}>
															</div>
														</td>
														<td class="small cellText" width="15%">
															<div align="center">
																<input data-toggle="icheck" class="tab_chk_delete" data-id="{$tabid}" type="checkbox" id="tab_chk_delete_{$tabid}" name="{$tabid}_delete" {if $modules.delete eq '0' && $modules.module eq '0'}checked{/if}>
															</div>
														</td>
														<td class="small cellLabel" width="22%">
															<div align="center">
																<img src="/Public/images/showDown.gif" id="img_{$tabid}" alt="{$APP.LBL_EXPAND_COLLAPSE}" title="{$APP.LBL_EXPAND_COLLAPSE}" onclick="fnToggleVIew('{$tabid}_view','{$tabid}','{$ID}')" border="0" height="16" width="40" style="display:none;cursor:pointer;">
															</div>
														</td>
													</tr>
													<tr class="hideTable" id="{$tabid}_view" className="hideTable">
														<td style="width: 5%;"></td>
														<td colspan="5" class="small settingsSelectedUI" style="border-bottom:1px solid #dadada;border-left:1px solid #dadada;">
															<table  id="{$tabid}_fields" class="small" border="0" cellpadding="2" cellspacing="0" width="100%">
																<tbody>
																<tr>
																	<input type="hidden" id="load_{$tabid}_fields" name="load_{$tabid}_fields" value="0">
																	<td class="small colHeader" colspan="6" valign="top">{$CMOD.LBL_FIELDS_TO_BE_SHOWN}</td>
																</tr>
																</tbody>
															</table>
														</td>
													</tr>
												{/foreach}
											{/foreach}
											</tbody>
										</table>
									</td>
								</tr>
								</tbody>
							</table>
						{/if}
				</tbody>
			</table>
		</div>
	</form>
</div>

<div class="bjui-pageFooter">
	<ul>
		<li><button type="button" class="btn-close" data-icon="close">{$APP.LBL_CANCEL_BUTTON_LABEL}</button></li>
		<li><button type="submit" {if $READONLY eq 'true'}disabled{/if} class="btn-green" data-icon="save">{$APP.LBL_SAVE_BUTTON_LABEL}</button></li>
	</ul>
</div>


<script language="javascript" type="text/javascript">
	{literal}
	function fnToggleVIew(obj,tabid,profileid){
		$.CurrentNavtab.find('#'+obj).each(function(){
			if($(this).data("isload")){
				if($(this).hasClass('hideTable')){
					$(this).removeClass('hideTable')
				}else{
					$(this).addClass('hideTable')
				}
			}else{
				var obj = $(this);
				$(this).bjuiajax('doAjax',{
					url:'index.php?module=Profiles&action=getProfilesFields&tabid='+tabid + '&profileid=' + profileid,
					type:'GET',
					loadingmask:true,
					callback:function(json){
						if(json.statusCode == '200'){
							var fieldhtml;
							$.each(json.fields, function(i,item){
								$.each(item, function(j,row){
									fieldhtml += '<tr>';
									$.each(row, function(k,col){
										fieldhtml += '<td valign="top" style="width: 24px;">'+col[1]+'</td>';
										fieldhtml += '<td>'+col[0]+'</td>';
									});
									fieldhtml += "</tr>";
								});
							});
							obj.find("#load_"+tabid+"_fields").val("1");
							obj.find("#"+tabid+"_fields").append(fieldhtml).initui();
							obj.data("isload",true);
							if(obj.hasClass('hideTable')){
								obj.removeClass('hideTable')
							}else{
								obj.addClass('hideTable')
							}
						}
					}
				});
			}
		});
	}

	$.CurrentNavtab.find('#view_all_chk').on('ifClicked',function(e){
		var checked = $(this).is(':checked');
		if(!checked)
		{
			$.CurrentNavtab.find(".listTable").find("input[type=checkbox]").each(function (e, obj)
																				 {
																					 var $objid = $(obj).attr("id");
																					 if ($objid.indexOf('tab_chk_com_') != -1 ||
																						 $objid.indexOf('tab_chk_index_') != -1
																					 )
																					 {
																						 $(obj).iCheck('check');
																					 }
																				 })
		}else{
			$.CurrentNavtab.find(".listTable").find("input[type=checkbox]").each(function (e, obj)
																				 {
																					 var $objid = $(obj).attr("id");
																					 if ($objid.indexOf('tab_chk_com_') != -1 ||
																						 $objid.indexOf('tab_chk_index_') != -1 ||
																						 $objid.indexOf('tab_chk_editview_') != -1 ||
																						 $objid.indexOf('tab_chk_delete_') != -1
																					 )
																					 {
																						 $(obj).iCheck('uncheck');
																					 }
																				 })
			unselect_edit_all();
		}
		showAllImages();
	})

	function showAllImages()
	{
		$.CurrentNavtab.find('.tab_chk_com').each(function(){
			var checked = $(this).is(':checked');
			var id = $(this).data("id");
			var imageid = '#img_'+id;
			if(checked){
				if($.CurrentNavtab.find(imageid))
					$.CurrentNavtab.find(imageid).css('display','block');
			}else{
				if($.CurrentNavtab.find(imageid))
					$.CurrentNavtab.find(imageid).css('display','none');
			}
		});
	}

	$.CurrentNavtab.find('#edit_all_chk').on('ifClicked',function(e){
		var checked = $(this).is(':checked');
		if(!checked){
			$.CurrentNavtab.find(".listTable").find("input[type=checkbox]").each(function (e, obj)
																				 {
																					 var $objid = $(obj).attr("id");
																					 if ($objid.indexOf('tab_chk_com_') != -1 ||
																						 $objid.indexOf('tab_chk_index_') != -1 ||
																						 $objid.indexOf('tab_chk_editview_') != -1 ||
																						 $objid.indexOf('tab_chk_delete_') != -1
																					 )
																					 {
																						 $(obj).iCheck('check');
																					 }
																				 })
			$.CurrentNavtab.find('#view_all_chk').iCheck('check');
			showAllImages();
		}else{
			$.CurrentNavtab.find(".listTable").find("input[type=checkbox]").each(function (e, obj)
																				 {
																					 var $objid = $(obj).attr("id");
																					 if (
																						 $objid.indexOf('tab_chk_editview_') != -1 ||
																						 $objid.indexOf('tab_chk_delete_') != -1
																					 )
																					 {
																						 $(obj).iCheck('uncheck');
																					 }
																				 })
		}
	})

	function unselect_edit_all()
	{
		$.CurrentNavtab.find('#edit_all_chk').iCheck('uncheck');
	}
	function unselect_view_all()
	{
		$.CurrentNavtab.find('#view_all_chk').iCheck('uncheck');
	}
	$.CurrentNavtab.find('.tab_chk_index').on('ifClicked',function(e){
		var checked = $(this).is(':checked');
		var id = $(this).data("id");
		var createid = '#tab_chk_editview_'+id;
		var deleteid = '#tab_chk_delete_'+id;
		var tab_id = '#tab_chk_com_'+id;
		if(!checked){
			var imageid = '#img_'+id;
			if($.CurrentNavtab.find(imageid))
				$.CurrentNavtab.find(imageid).css('display','block');
			$.CurrentNavtab.find(tab_id).iCheck('check');
		}else{
			unselect_view_all();
			unselect_edit_all();
			$.CurrentNavtab.find(createid).iCheck('uncheck');
			$.CurrentNavtab.find(deleteid).iCheck('uncheck');
			$.CurrentNavtab.find(tab_id).iCheck('uncheck');
		}
		showAllImages();
	})
	$.CurrentNavtab.find('.tab_chk_editview').on('ifClicked',function(e){
		var checked = $(this).is(':checked');
		var id = $(this).data("id");
		var viewid = '#tab_chk_index_'+id;
		var tab_id = '#tab_chk_com_'+id;
		if(!checked){
			var imageid = '#img_'+id;
			if($.CurrentNavtab.find(imageid))
				$.CurrentNavtab.find(imageid).css('display','block');
			$.CurrentNavtab.find(tab_id).iCheck('check');
			$.CurrentNavtab.find(viewid).iCheck('check');
		}else{
			unselect_edit_all();
		}
	})
	$.CurrentNavtab.find('.tab_chk_delete').on('ifClicked',function(e){
		var checked = $(this).is(':checked');
		var id = $(this).data("id");
		var viewid = '#tab_chk_index_'+id;
		var tab_id = '#tab_chk_com_'+id;
		if(!checked){
			var imageid = '#img_'+id;
			if($.CurrentNavtab.find(imageid))
				$.CurrentNavtab.find(imageid).css('display','block');
			$.CurrentNavtab.find(tab_id).iCheck('check');
			$.CurrentNavtab.find(viewid).iCheck('check');
		}
	})
	$.CurrentNavtab.find('.tab_chk_com').on('ifClicked',function(e){
		var checked = $(this).is(':checked');
		var id = $(this).data("id");
		var createid = '#tab_chk_editview_'+id;
		var viewid = '#tab_chk_index_'+id;
		var deleteid = '#tab_chk_delete_'+id;
		var imageid = '#img_'+id;
		var contid = '#'+id+'_view';
		if(!checked){
			if($.CurrentNavtab.find(imageid))
				$.CurrentNavtab.find(imageid).css('display','block');
			$.CurrentNavtab.find(createid).iCheck('check');
			$.CurrentNavtab.find(viewid).iCheck('check');
			$.CurrentNavtab.find(deleteid).iCheck('check');
		}else {
			unselect_view_all();
			unselect_edit_all();
			if($.CurrentNavtab.find(imageid))
				$.CurrentNavtab.find(imageid).css('display','none');
			$.CurrentNavtab.find(createid).iCheck('uncheck');
			$.CurrentNavtab.find(viewid).iCheck('uncheck');
			$.CurrentNavtab.find(deleteid).iCheck('uncheck');
			$.CurrentNavtab.find(contid).addClass('hideTable');
		}
	})

	showAllImages();
	{/literal}
</script>

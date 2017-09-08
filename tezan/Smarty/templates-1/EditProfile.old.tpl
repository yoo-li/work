
{literal}
<style>
.showTable{
	display:inline-table;
}
.hideTable{
	display:none;
}
</style>
{/literal}


{literal}
<style>

.listTable {
    border-bottom: 1px solid #CCCCCC;
    border-left: 1px solid #CCCCCC;
    border-right: 1px solid #CCCCCC;
}

.settingsSelectedUI {
    background: url("Public/images/settingsSelUIBg.gif") repeat-x scroll 0 0 transparent;
    padding: 15px 25px;
}
.dvtCellLabel, .cellLabel {
    padding-left: 10px;
    white-space: nowrap;
}
.cellLabel {
    background-color: #F5F5FF;
    border-bottom: 1px solid #DADADA;
    border-top: 1px solid #EFEFEF;
    color: #555555;
    text-align: left;
}
.big {
    color: #000000;
    font-family: "Microsoft Yahei",微软雅黑,arial,宋体,Arial Narrow,serif;
    font-size: 12px;
    font-weight: bold;
    line-height: 18px;
}
.small {
    color: #000000;
    font-family: "Microsoft Yahei",微软雅黑,arial,宋体,Arial Narrow,serif;
    font-size: 12px;
}
.cellText {
    border-bottom: 1px solid #DADADA;
    color: #333333;
}
.colHeader {
    background-color: #FFFFFF;
    background-image: url("Public/images/mailSubHeaderBg-grey.gif");
    background-repeat: repeat-x;
    border-color: #DDDDDD #DDDDDD #DDDDDD #FFFFFF;
    border-left: 1px solid #FFFFFF;
    border-style: solid;
    border-width: 1px;
    font-weight: bold;
}
</style>
{/literal}


<link href="/Public/css/favorite.css" rel="stylesheet" rel="stylesheet" type="text/css" />
<div class="bjui-pageContent" >
<form name="profileform" action="index.php" data-toggle="validate" data-alertmsg="false" method="post">
<input type="hidden" name="module" value="Users">
<input type="hidden" name="action" value="UpdateProfileChanges">
<input type="hidden" name="record" value="{$ID}">
<input type="hidden" name="mode" value="{$MODE}">
<input type="hidden" name="__hash__" value="f05447c821012018c16dec99264a7bdc_ea332f4bef78750abe1e93924eaf44f8" />

<div class="pageFormContent" layoutH="36">  
<!-- privilege lists -->


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
								{if $PROFILE_NAME neq 'Boss'}
										<tr id="gva">
											<td valign="top">{$GLOBAL_PRIV.0}</td>
											<td ><label class="control-label" for="view_all_chk">{$CMOD.LBL_VIEW_ALL}</label></td>
										</tr>
										<tr>
											<td valign="top"></td>
											<td width="100%" >{$CMOD.LBL_ALLOW} "{$PROFILE_NAME}" {$CMOD.LBL_MESG_VIEW}</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td valign="top">{$GLOBAL_PRIV.1}</td>
											<td ><label class="control-label" for="edit_all_chk">{$CMOD.LBL_EDIT_ALL}</label></td>
										</tr>
										<tr>
											<td valign="top"></td>
											<td > {$CMOD.LBL_ALLOW} "{$PROFILE_NAME}" {$CMOD.LBL_MESG_EDIT}</td>
										</tr>
									{else}
										<tr>
											<td valign="top"><input data-toggle="icheck" type="checkbox" {if $SUPERDELETE eq '1'}checked{/if} name="superdelete"  id="superdelete"></td>
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
		{if $PROFILE_NAME neq 'Boss'}
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
									<td colspan="2" rowspan="2" class="small colHeader" style="border-left:medium none #ffffff;background-size:100% 100%"><strong> {$CMOD.LBL_TAB_MESG_OPTION} </strong><strong></strong></td>
									<td colspan="3" class="small colHeader"><div align="center"><strong>{$CMOD.LBL_EDIT_PERMISSIONS}</strong></div></td>
									<td rowspan="2" class="small colHeader" style="background-size:100% 100%" nowrap="nowrap">{$CMOD.LBL_FIELDS_AND_TOOLS_SETTINGS}</td>
								</tr>
								<tr id="gva">
									<td class="small colHeader">
										<div align="center"><strong>{$CMOD.LBL_CREATE_EDIT}</strong></div>
									</td>
									<td class="small colHeader"> <div align="center"><strong>{$CMOD.LBL_VIEW}</strong></div></td>
									<td class="small colHeader"> <div align="center"><strong>{$CMOD.LBL_DELETE}</strong></div></td>
								</tr>
									<!-- module loops-->
								{foreach key=tabid item=elements from=$TAB_PRIV}	
									<tr>
											{assign var=modulename value=$TAB_PRIV[$tabid][0]}
											{assign var="MODULELABEL" value=$modulename}
											{if $APP[$modulename] neq ''}
												{assign var="MODULELABEL" value=$APP[$modulename]}
											{/if}
										<td colspan="2" class="small cellLabel" width="40%">
											{$TAB_PRIV[$tabid][1]}
										</td>
										<td class="small cellText" width="15%">
											&nbsp;<div align="center">{$STANDARD_PRIV[$tabid][1]}</div>
										</td>
										<td class="small cellText" width="15%">
											&nbsp;<div align="center">{$STANDARD_PRIV[$tabid][3]}</div>
										</td>
										<td class="small cellText" width="15%">
											&nbsp;<div align="center">{$STANDARD_PRIV[$tabid][2]}</div>
										</td>
										<td class="small cellLabel" width="22%">
											&nbsp;
											<div align="center">
													{if $FIELD_PRIVILEGES[$tabid] neq NULL}
														<img src="Public/images/showDown.gif" id="img_{$tabid}" alt="{$APP.LBL_EXPAND_COLLAPSE}" title="{$APP.LBL_EXPAND_COLLAPSE}" onclick="fnToggleVIew('{$tabid}_view')" border="0" height="16" width="40" style="display:block;cursor:pointer;">
													{/if}
												</div>
											</td>
										</tr>
								<tr class="hideTable" id="{$tabid}_view" className="hideTable">
										<td colspan="6" class="small settingsSelectedUI">
												<table class="small" border="0" cellpadding="2" cellspacing="0" width="100%">
											<tbody>
														{if $FIELD_PRIVILEGES[$tabid] neq ''}
															<tr>
																<td class="small colHeader" colspan="6" valign="top">{$CMOD.LBL_FIELDS_TO_BE_SHOWN}</td>
															</tr>
														{/if}
														{foreach item=row_values from=$FIELD_PRIVILEGES[$tabid]}
														<tr>
														      {foreach item=element from=$row_values}
														      <td valign="top" style="width: 24px;">{$element.1}</td>
														      <td>{$element.0}</td>
														      {/foreach}
														</tr>
														{/foreach}
														{if $UTILITIES_PRIV[$tabid] neq ''}
														<tr>
														      <td colspan="6" class="small colHeader" valign="top">{$CMOD.LBL_TOOLS_TO_BE_SHOWN}</td>
														</tr>
														{/if}
														{foreach item=util_value from=$UTILITIES_PRIV[$tabid]}
															<tr>
															{foreach item=util_elements from=$util_value}
																<td valign="top">{$util_elements.1}</td>
																<td>{$util_elements.0|@getTranslatedString:$modulename}</td>
															{/foreach}
															</tr>
														{/foreach}
												</tbody>
												</table>
											</td>
									</tr>
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
	</td>
        </tr>
        </tbody>
	</table>
      </td>
      </tr>
      </tbody></table>
       </td>
      </tr>
      </tbody></table>
	
					
	</td>
	</tr>
	</tbody></table>

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
var Imagid_array = ['img_2','img_4','img_6','img_7','img_8','img_9','img_10','img_13','img_14','img_18','img_19','img_20','img_21','img_22','img_23','img_26']
function fnToggleVIew(obj){
	if($.CurrentNavtab.find('#'+obj).hasClass('hideTable')){
		$.CurrentNavtab.find('#'+obj).removeClass('hideTable')
	}else{
		$.CurrentNavtab.find('#'+obj).addClass('hideTable')
	}
//	if(jQuery('#'+obj).attr("class")) {
//		jQuery('#'+obj).removeClass('hideTable');
//	} else {
//		jQuery('#'+obj).addClass('hideTable');
//	}
}

$.CurrentNavtab.find('#view_all_chk').on('ifChanged',function(e){
	var checked = $(this).is(':checked');
	if(checked)
	{
		$.CurrentNavtab.find(".listTable").find("input[type=checkbox]").each(function (e, obj)
																			 {
																				 $objid = $(obj).attr("id");
																				 if ($objid.indexOf('tab_chk_com_') != -1 ||
																					 $objid.indexOf('tab_chk_index_') != -1 ||
																					 $objid.indexOf('_field_') != -1
																				 )
																				 {
																					 $(obj).iCheck('check');
																				 }
																			 })
		showAllImages();
	}
})
//function invokeview_all()
//{
//	if($('#view_all_chk').attr('checked') == true)
//	{
//
//		for(var i = 0;i < document.profileform.elements.length;i++)
//		{
//			if(document.profileform.elements[i].type == 'checkbox')
//			{
//				if(document.profileform.elements[i].id.indexOf('tab_chk_com_') != -1 ||
//				document.profileform.elements[i].id.indexOf('tab_chk_index_') != -1 ||
//				document.profileform.elements[i].id.indexOf('_field_') != -1)
//					document.profileform.elements[i].checked = true;
//			}
//		}
//		showAllImages();
//	}
//}
function showAllImages()
{
	for(var j=0;j < Imagid_array.length;j++)
	{
		if($.CurrentNavtab.find('#'+Imagid_array[j]))
			$.CurrentNavtab.find('#'+Imagid_array[j]).css('display','block');
//		if(typeof(jQuery('#'+Imagid_array[j]).val()) != 'undefined')
//			jQuery('#'+Imagid_array[j]).css('display','block');
	}
}

$.CurrentNavtab.find('#edit_all_chk').on('ifChanged',function(e){
	var checked = $(this).is(':checked');
	if(checked)
	{
		$.CurrentNavtab.find(".listTable").find("input[type=checkbox]").each(function (e, obj)
																			 {
																				 var $objid = $(obj).attr("id");
																				 if ($objid.indexOf('tab_chk_editview_') != -1 ||
																					 $objid.indexOf('tab_chk_com_') != -1 ||
																					 $objid.indexOf('tab_chk_delete_') != -1 ||
																					 $objid.indexOf('_field_') != -1
																				 )
																				 {
																					 $(obj).iCheck('check');
																				 }
																			 })
		showAllImages();
	}
})

//function invokeedit_all()
//{
//	if(jQuery('#edit_all_chk').attr('checked') == 'checked')
//	{
//		jQuery('#view_all_chk').attr('checked',true);
//		for(var i = 0;i < document.profileform.elements.length;i++)
//		{
//
//			if(document.profileform.elements[i].type == 'checkbox')
//			{
//				if(document.profileform.elements[i].id.indexOf('tab_chk_com_') != -1 ||
//				   document.profileform.elements[i].id.indexOf('tab_chk_editview_') != -1 ||
//				   document.profileform.elements[i].id.indexOf('tab_chk_index_') != -1 ||
//				   document.profileform.elements[i].id.indexOf('_field_') != -1)
//				{
//					document.profileform.elements[i].checked = true;
//				}
//			}
//		}
//		showAllImages();
//	}
//
//}
function unselect_edit_all()
{
	$.CurrentNavtab.find('#edit_all_chk').iCheck('uncheck');
//	jQuery('#edit_all_chk').attr('checked',false);
}
function unselect_view_all()
{
	$.CurrentNavtab.find('#view_all_chk').iCheck('uncheck');
//	jQuery('#view_all_chk').attr('checked',false);
}
$.CurrentNavtab.find('.tab_chk_index').on('ifChanged',function(e){
	var checked = $(this).is(':checked');
	var id = $(this).data("id");
	var createid = '#tab_chk_editview_'+id;
	var deleteid = '#tab_chk_delete_'+id;
	var tab_id = '#tab_chk_com_'+id;
	if(checked){
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
})
//function unSelectView(id)
//{
//	var createid = '#tab_chk_editview_'+id;
//	var deleteid = '#tab_chk_delete_'+id;
//	var tab_id = '#tab_chk_com_'+id;
//	if(jQuery('#tab_chk_index_'+id).attr('checked') == undefined)
//	{
//		unselect_view_all();
//		unselect_edit_all();
//		jQuery(createid).attr('checked',false);
//		jQuery(deleteid).attr('checked',false);
//		jQuery(tab_id).attr('checked',false);
//	}else
//	{
//		var imageid = '#img_'+id;
//		var viewid = '#tab_chk_index_'+id;
//		if(typeof(jQuery(imageid)) != 'undefined')
//			jQuery(imageid).css('display','block');
//		jQuery('#tab_chk_com_'+id).attr('checked',true);
//	}
//}
$.CurrentNavtab.find('.tab_chk_editview').on('ifChanged',function(e){
	var checked = $(this).is(':checked');
	var id = $(this).data("id");
	var viewid = '#tab_chk_index_'+id;
	var tab_id = '#tab_chk_com_'+id;
	if(checked){
		var imageid = '#img_'+id;
		if($.CurrentNavtab.find(imageid))
			$.CurrentNavtab.find(imageid).css('display','block');
		$.CurrentNavtab.find(tab_id).iCheck('check');
		$.CurrentNavtab.find(viewid).iCheck('check');
	}else{
		unselect_edit_all();
	}
})
//function unSelectCreate(id)
//{
//	var viewid = '#tab_chk_index_'+id;
//	if(jQuery('#tab_chk_editview_'+id).attr('checked') == undefined)
//	{
//		unselect_edit_all();
//	}else
//	{
//		var imageid = '#img_'+id;
//		var viewid = '#tab_chk_index_'+id;
//		if(typeof(jQuery(imageid).val()) != 'undefined')
//			jQuery(imageid).css('display','block');
//		jQuery('#tab_chk_com_'+id).attr('checked',true);
//		jQuery(viewid).attr('checked',true);
//	}
//}
$.CurrentNavtab.find('.tab_chk_delete').on('ifChanged',function(e){
	var checked = $(this).is(':checked');
	var id = $(this).data("id");
	var viewid = '#tab_chk_index_'+id;
	var tab_id = '#tab_chk_com_'+id;
	if(checked){
		var imageid = '#img_'+id;
		if($.CurrentNavtab.find(imageid))
			$.CurrentNavtab.find(imageid).css('display','block');
		$.CurrentNavtab.find(tab_id).iCheck('check');
		$.CurrentNavtab.find(viewid).iCheck('check');
	}
})
//function unSelectDelete(id)
//{
//	var contid = id+'_view';
//	if(jQuery('#tab_chk_delete_'+id).attr('checked') == undefined)
//	{
//	}else
//	{
//		var imageid = '#img_'+id;
//		var viewid = '#tab_chk_index_'+id;
//		if(typeof(jQuery(imageid).val()) != 'undefined')
//			jQuery(imageid).css('display','block');
//		jQuery('#tab_chk_com_'+id).attr('checked',true);
//		jQuery(viewid).attr('checked',true);
//	}
//
//}
$.CurrentNavtab.find('.tab_chk_com').on('ifChanged',function(e){
	var checked = $(this).is(':checked');
	var id = $(this).data("id");
	var createid = '#tab_chk_editview_'+id;
	var viewid = '#tab_chk_index_'+id;
	var deleteid = '#tab_chk_delete_'+id;
	var imageid = '#img_'+id;
	var contid = '#'+id+'_view';
	if(checked){
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
//function hideTab(id,checked)
//{
//	var createid = '#tab_chk_editview_'+id;
//	var viewid = '#tab_chk_index_'+id;
//	var deleteid = '#tab_chk_delete_'+id;
//	var imageid = '#img_'+id;
//	var contid = '#'+id+'_view';
//	if(!checked)
//	{
//		unselect_view_all();
//		unselect_edit_all();
//		if(typeof(jQuery(imageid).val()) != 'undefined')
//			jQuery(imageid).css('display','none');
//			jQuery(contid).addClass('hideTable');
//		if(typeof(jQuery(createid).val()) != 'undefined')
//			jQuery(createid).attr('checked',false);
//		if(typeof(jQuery(deleteid).val()) != 'undefined')
//			jQuery(deleteid).attr('checked',false);
//		if(typeof(jQuery(viewid).val()) != 'undefined')
//			jQuery(viewid).attr('checked',false);
//	}else
//	{
//		if(typeof(jQuery(imageid).val()) != 'undefined')
//			jQuery(imageid).css('display','block');
//		if(typeof(jQuery(createid).val()) != 'undefined')
//		{
//			$(createid).attr('checked',true);
//			$(createid).prop('checked',true);
//		}
//		if(typeof(jQuery(deleteid).val()) != 'undefined')
//		{
//			$(deleteid).attr('checked',true);
//			$(deleteid).prop('checked',true);
//		}
//
//		if(typeof(jQuery(viewid).val()) != 'undefined')
//		{
//			$(viewid).attr('checked',true);
//			$(viewid).prop('checked',true);
//		}
//		/*for(var i = 0;i < document.profileform.elements.length;i++)
//                {
//                        if(document.profileform.elements[i].type == 'checkbox' && document.profileform.elements[i].id.indexOf(fieldid) != -1)
//                        {
//                                        document.profileform.elements[i].checked = true;
//                        }
//                }*/
//	}
//}
//function selectUnselect(oCheckbox)
//{
//	if(oCheckbox.checked == false)
//	{
//		unselect_view_all();
//		unselect_edit_all();
//	}
//}
//function initialiseprofile()
//{
//	var module_array = Array(1,2,4,6,7,8,9,10,13,14,15,17,18,19,20,21,22,23,24,25,26,27);
//	for (var i=0;i < module_array.length;i++)
//	{
//		hideTab(module_array[i]);
//	}
//}
//initialiseprofile();
{/literal}
</script>

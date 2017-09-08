{*<!-- 图片类型 -->*} 

<script language="javascript" type="text/javascript">
	$.ajaxSetup({ldelim} cache: true {rdelim});  
</script>
<link href="/Public/css/cropper.min.css" rel="stylesheet">
<link href="/Public/css/cropper.upload.css" rel="stylesheet"> 
<script src="/Public/js/cropper.min.js"></script>
<script src="/Public/js/cropper.upload.js"></script>
<script language="javascript" type="text/javascript">
	$.ajaxSetup({ldelim} cache: false {rdelim});  
</script>
		
{assign var="imagewidth" value="$extenddata[2]"}
{assign var="imageheight" value="$extenddata[3]"}

<div id="{$fldname}_crop_avatar" style="position: relative;">
	{if $READONLY eq 'true' || $read_only eq '1'}
		{if $fldvalue eq ''}
			<div class="avatar-view form-control"  style='height:{math equation="111 * height / width + 11" height=$imageheight width=$imagewidth format="%d"}px;'>
		    	 <img class="avatar-image" style='height:{math equation="111 * height / width" height=$imageheight width=$imagewidth format="%d"}px;' src="/Public/images/noimage.jpg">
			</div>  
		{else}
			<div class="avatar-view form-control"  style='height:{math equation="111 * height / width + 11" height=$imageheight width=$imagewidth format="%d"}px;'>
		    	<a id="data_lightbox_{$fldname}" href="{$fldvalue}" data-lightbox="roadtrip"> <img class="avatar-image" style='height:{math equation="111 * height / width" height=$imageheight width=$imagewidth format="%d"}px;' src="{$fldvalue}"></a>
			</div>
		{/if}
		<input type="hidden" value="{$fldvalue}" name="{$fldname}" id="avatar-image-input">
	{else}
	    {if $fldvalue eq ''}
			<div class="avatar-view form-control {if $mustofdata eq 'M'}required{/if}"  style='height:{math equation="111 * height / width + 11" height=$imageheight width=$imagewidth format="%d"}px;'>
		    	 <a data-on-load="{$fldname}_upload_dialog_onLoad" data-toggle="dialog" data-id="uploaddialog" data-options="{ldelim}mask:true,resizable:false,drawable:false,maxable:false,minable:false,width:860,height:600{rdelim}" data-target="#{$MODULE}_upload_dialog_target" data-title="图片上传">  
					 <img class="avatar-image" style='height:{math equation="111 * height / width" height=$imageheight width=$imagewidth format="%d"}px;' src="/Public/images/uploadimg.png">
				</a>
				<a class="avatar-close-image" id="close_btn" style="display:none;" href="javascript:void(0);"><img src="/Public/images/guanbi.jpg"></a>
			</div>
			<input type="hidden" value="" name="{$fldname}" id="{$fldname}" {if $mustofdata eq 'M'}data-rule="required;" data-msg-required="请上传一张图片"{/if}>
		{else}
			<div class="avatar-view form-control {if $mustofdata eq 'M'}required{/if}"  style='height:{math equation="111 * height / width + 11" height=$imageheight width=$imagewidth format="%d"}px;'>
		    	 <a data-on-load="{$fldname}_upload_dialog_onLoad" data-toggle="dialog" data-id="uploaddialog" data-options="{ldelim}mask:true,resizable:false,drawable:false,maxable:false,minable:false,width:860,height:600{rdelim}" data-target="#{$MODULE}_upload_dialog_target" data-title="图片上传">  
					 <img class="avatar-image" style='height:{math equation="111 * height / width" height=$imageheight width=$imagewidth format="%d"}px;' src="{$fldvalue}">
				</a>
				<a class="avatar-close-image" id="close_btn" onclick="close_btn_upload_dialog(this);"href="javascript:void(0);"><img src="/Public/images/guanbi.jpg"></a>
			</div>
			<input type="hidden" value="{$fldvalue}" name="{$fldname}" id="{$fldname}" {if $mustofdata eq 'M'}data-rule="required;" data-msg-required="请上传一张图片"{/if}>
		{/if}
	{/if}
	  
</div> 
{if $field_unit neq ''}
	<span style="position: absolute; bottom: 3px;white-space:nowrap;padding:0px 2px;margin-left:3px;margin-top:2px;z-index:-1;">{$field_unit}</span>
{/if}
<script type="text/javascript"  defer="defer">  
function close_btn_upload_dialog(obj) 
{ldelim} 
	$(obj).css("display","none");
	$(obj).parent().parent().find("input").val('');
	$(obj).parent().parent().find(".avatar-image").attr('src', "/Public/images/uploadimg.png"); 
{rdelim} 

function {$fldname}_upload_dialog_onLoad($dialog) 
{ldelim}
		setTimeout(function(){ldelim}  $.InitCropAvatar('{$MODULE}','{$fldname}','{$imagewidth}','{$imageheight}');  {rdelim} ,100);
{rdelim} 
</script>  
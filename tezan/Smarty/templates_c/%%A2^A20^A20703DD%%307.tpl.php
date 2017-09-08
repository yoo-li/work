<?php /* Smarty version 2.6.18, created on 2017-08-21 16:48:41
         compiled from uitype/307.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'math', 'uitype/307.tpl', 20, false),)), $this); ?>
 

<script language="javascript" type="text/javascript">
	$.ajaxSetup({ cache: true });  
</script>
<link href="/Public/css/cropper.min.css" rel="stylesheet">
<link href="/Public/css/cropper.upload.css" rel="stylesheet"> 
<script src="/Public/js/cropper.min.js"></script>
<script src="/Public/js/cropper.upload.js"></script>
<script language="javascript" type="text/javascript">
	$.ajaxSetup({ cache: false });  
</script>
		
<?php $this->assign('imagewidth', ($this->_tpl_vars['extenddata'][2])); ?>
<?php $this->assign('imageheight', ($this->_tpl_vars['extenddata'][3])); ?>

<div id="<?php echo $this->_tpl_vars['fldname']; ?>
_crop_avatar" style="position: relative;">
	<?php if ($this->_tpl_vars['READONLY'] == 'true' || $this->_tpl_vars['read_only'] == '1'): ?>
		<?php if ($this->_tpl_vars['fldvalue'] == ''): ?>
			<div class="avatar-view form-control"  style='height:<?php echo smarty_function_math(array('equation' => "111 * height / width + 11",'height' => $this->_tpl_vars['imageheight'],'width' => $this->_tpl_vars['imagewidth'],'format' => "%d"), $this);?>
px;'>
		    	 <img class="avatar-image" style='height:<?php echo smarty_function_math(array('equation' => "111 * height / width",'height' => $this->_tpl_vars['imageheight'],'width' => $this->_tpl_vars['imagewidth'],'format' => "%d"), $this);?>
px;' src="/Public/images/noimage.jpg">
			</div>  
		<?php else: ?>
			<div class="avatar-view form-control"  style='height:<?php echo smarty_function_math(array('equation' => "111 * height / width + 11",'height' => $this->_tpl_vars['imageheight'],'width' => $this->_tpl_vars['imagewidth'],'format' => "%d"), $this);?>
px;'>
		    	<a id="data_lightbox_<?php echo $this->_tpl_vars['fldname']; ?>
" href="<?php echo $this->_tpl_vars['fldvalue']; ?>
" data-lightbox="roadtrip"> <img class="avatar-image" style='height:<?php echo smarty_function_math(array('equation' => "111 * height / width",'height' => $this->_tpl_vars['imageheight'],'width' => $this->_tpl_vars['imagewidth'],'format' => "%d"), $this);?>
px;' src="<?php echo $this->_tpl_vars['fldvalue']; ?>
"></a>
			</div>
		<?php endif; ?>
		<input type="hidden" value="<?php echo $this->_tpl_vars['fldvalue']; ?>
" name="<?php echo $this->_tpl_vars['fldname']; ?>
" id="avatar-image-input">
	<?php else: ?>
	    <?php if ($this->_tpl_vars['fldvalue'] == ''): ?>
			<div class="avatar-view form-control <?php if ($this->_tpl_vars['mustofdata'] == 'M'): ?>required<?php endif; ?>"  style='height:<?php echo smarty_function_math(array('equation' => "111 * height / width + 11",'height' => $this->_tpl_vars['imageheight'],'width' => $this->_tpl_vars['imagewidth'],'format' => "%d"), $this);?>
px;'>
		    	 <a data-on-load="<?php echo $this->_tpl_vars['fldname']; ?>
_upload_dialog_onLoad" data-toggle="dialog" data-id="uploaddialog" data-options="{mask:true,resizable:false,drawable:false,maxable:false,minable:false,width:860,height:600}" data-target="#<?php echo $this->_tpl_vars['MODULE']; ?>
_upload_dialog_target" data-title="图片上传">  
					 <img class="avatar-image" style='height:<?php echo smarty_function_math(array('equation' => "111 * height / width",'height' => $this->_tpl_vars['imageheight'],'width' => $this->_tpl_vars['imagewidth'],'format' => "%d"), $this);?>
px;' src="/Public/images/uploadimg.png">
				</a>
				<a class="avatar-close-image" id="close_btn" style="display:none;" href="javascript:void(0);"><img src="/Public/images/guanbi.jpg"></a>
			</div>
			<input type="hidden" value="" name="<?php echo $this->_tpl_vars['fldname']; ?>
" id="<?php echo $this->_tpl_vars['fldname']; ?>
" <?php if ($this->_tpl_vars['mustofdata'] == 'M'): ?>data-rule="required;" data-msg-required="请上传一张图片"<?php endif; ?>>
		<?php else: ?>
			<div class="avatar-view form-control <?php if ($this->_tpl_vars['mustofdata'] == 'M'): ?>required<?php endif; ?>"  style='height:<?php echo smarty_function_math(array('equation' => "111 * height / width + 11",'height' => $this->_tpl_vars['imageheight'],'width' => $this->_tpl_vars['imagewidth'],'format' => "%d"), $this);?>
px;'>
		    	 <a data-on-load="<?php echo $this->_tpl_vars['fldname']; ?>
_upload_dialog_onLoad" data-toggle="dialog" data-id="uploaddialog" data-options="{mask:true,resizable:false,drawable:false,maxable:false,minable:false,width:860,height:600}" data-target="#<?php echo $this->_tpl_vars['MODULE']; ?>
_upload_dialog_target" data-title="图片上传">  
					 <img class="avatar-image" style='height:<?php echo smarty_function_math(array('equation' => "111 * height / width",'height' => $this->_tpl_vars['imageheight'],'width' => $this->_tpl_vars['imagewidth'],'format' => "%d"), $this);?>
px;' src="<?php echo $this->_tpl_vars['fldvalue']; ?>
">
				</a>
				<a class="avatar-close-image" id="close_btn" onclick="close_btn_upload_dialog(this);"href="javascript:void(0);"><img src="/Public/images/guanbi.jpg"></a>
			</div>
			<input type="hidden" value="<?php echo $this->_tpl_vars['fldvalue']; ?>
" name="<?php echo $this->_tpl_vars['fldname']; ?>
" id="<?php echo $this->_tpl_vars['fldname']; ?>
" <?php if ($this->_tpl_vars['mustofdata'] == 'M'): ?>data-rule="required;" data-msg-required="请上传一张图片"<?php endif; ?>>
		<?php endif; ?>
	<?php endif; ?>
	  
</div> 
<?php if ($this->_tpl_vars['field_unit'] != ''): ?>
	<span style="position: absolute; bottom: 3px;white-space:nowrap;padding:0px 2px;margin-left:3px;margin-top:2px;z-index:-1;"><?php echo $this->_tpl_vars['field_unit']; ?>
</span>
<?php endif; ?>
<script type="text/javascript"  defer="defer">  
function close_btn_upload_dialog(obj) 
{ 
	$(obj).css("display","none");
	$(obj).parent().parent().find("input").val('');
	$(obj).parent().parent().find(".avatar-image").attr('src', "/Public/images/uploadimg.png"); 
} 

function <?php echo $this->_tpl_vars['fldname']; ?>
_upload_dialog_onLoad($dialog) 
{
		setTimeout(function(){  $.InitCropAvatar('<?php echo $this->_tpl_vars['MODULE']; ?>
','<?php echo $this->_tpl_vars['fldname']; ?>
','<?php echo $this->_tpl_vars['imagewidth']; ?>
','<?php echo $this->_tpl_vars['imageheight']; ?>
');  } ,100);
} 
</script>  
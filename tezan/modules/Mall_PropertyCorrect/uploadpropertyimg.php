<?php
require_once('Smarty_setup.php');
require_once('include/utils/utils.php');
global $mod_strings,$app_strings,$theme,$currentModule,$current_user;
$smarty = new vtigerCRM_Smarty;

function getselectPlupLoadHtml($currentModule,$record,$fieldname,$fieldvalues,$div_width,$div_height,$image_width,$image_height,$readonly,$multi_selection,$title){
    $timestamp = time();
    $unique_salt = md5('unique_salt' . $timestamp);
    $html ='';
    if($multi_selection=='false')$html .='<div id="'.$fieldname.'_file_container" style="display:block;float:left;"></div>';
    if($readonly=='false'){
        if(!empty($fieldvalues)&&count($fieldvalues)>0 && $fieldvalues[0]!="" && @file_exists($_SERVER['DOCUMENT_ROOT'] .$fieldvalues[0]) &&$multi_selection=='false'){
            $html .='<div id="'.$fieldname.'pickfiles" style="display:none;width'.$div_width.'px;height:'.$div_height.'px;position: relative;float:left;margin:8px 3px;border:1px solid #cdcdcd;">
            <img style="margin:4px 7px 8px 7px;width:'.($div_width-14).'px;height:'.($div_height-12).'px;" src="/Public/images/uploadimg.png" alt="'.$title.'">
        </div>';
        }else{
            $html .='<div id="'.$fieldname.'pickfiles" style="display:block;width:'.$div_width.'px;height:'.$div_height.'px;position: relative;float:left;margin:8px 3px;border:1px solid #cdcdcd;">
            <img style="margin:4px 7px 8px 7px;width:'.($div_width-14).'px;height:'.($div_height-12).'px;" src="/Public/images/uploadimg.png" alt="'.$title.'">
        </div>';
        }
    }
	
    if(!empty($fieldvalues)!="" &&count($fieldvalues)>=1 && $fieldvalues[0]!="" )
	{
        $html.='<div style="clear:both;">';
        foreach($fieldvalues as $key=>$fieldvalue)
		{
			if (@file_exists($_SERVER['DOCUMENT_ROOT'].$fieldvalue))
			{
	            if($fieldvalue!=""){
	                $recordid=$record.$key;
	                if($image_width>0 && $image_height>0){
	                    $html.='<div id="plupload_img_'.$fieldname.$recordid.'" style="width:'.($div_width+14).'px;height:'.($div_height+12).'px;position: relative;float:left;margin:8px 3px;border:1px solid #cdcdcd;">
	                    <input id="'.$fieldname.$recordid.'" type="hidden" name="'.$fieldname.'[]" value="'.$fieldvalue.'">
	                    <input type="hidden" name="image_'.$fieldname.$recordid.'" value="'.$fieldvalue.'">
	                    <a id="data_lightbox_'.$fieldname.$recordid.'" href="'.$fieldvalue.'" data-lightbox="roadtrip"><img class="img-responsive" src="'.$fieldvalue.'" style="margin:4px 7px 0px 7px;border:1px #ddd solid;display:block;height:'.$div_height.'px;width:'.$div_width.'px;"></a>';
	                }else{
	                    $html.='<div id="plupload_img_'.$fieldname.$recordid.'" style="max-width:640px;position: relative;float:left;margin:8px 3px;border:1px solid #cdcdcd;">
	                    <input id="'.$fieldname.$recordid.'" type="hidden" name="'.$fieldname.'[]" value="'.$fieldvalue.'">
	                    <input type="hidden" name="image_'.$fieldname.$recordid.'" value="'.$fieldvalue.'">
	                    <a id="data_lightbox_'.$fieldname.$recordid.'" href="'.$fieldvalue.'" data-lightbox="roadtrip"><img class="img-responsive" src="'.$fieldvalue.'" style="margin:4px 7px 0px 7px;border:1px #ddd solid;display:block;max-width:626px;"></a>';
	                }
	                if($readonly=='false'){
	                    $html.='<a onclick="productfile_delete(\''.$fieldname.'\',\''.$recordid.'\');" href="javascript:void(0);" style="display:block; height:15px; width:15px; position:absolute; top:0px; right:2px;">
	                <img src="/Public/images/guanbi.jpg">
	            </a>';
	                }else{
	                    $html.='<a onclick="productfile_delete(\''.$fieldname.$recordid.'\');" href="javascript:void(0);" style="display:none; height:15px; width:15px; position:absolute; top:0px; right:2px;">
	                <img src="/Public/images/guanbi.jpg">
	            </a>';
	                }
	                $html.='<div id="progress_'.$fieldname.$recordid.'" style="width: 120px; float: left; margin: 0px 7px; height: 4px; text-align: center; display: none; background-color: rgba(18, 18, 224, 0.498039);">100%</div>
	                <div style="width:100%;text-align:center;margin-top:5px;"><input id="propertyimg_'.$fieldname.$recordid.'" name="propertyimg_'.$fieldname.$record.'" value="'.$fieldvalue.'" type="radio"><label for="propertyimg_'.$fieldname.$recordid.'">&nbsp;&nbsp;选择图片</label></div></div>
	                ';
	            }
			} 
        }
        $html.='</div>';
    }
	 

    if($multi_selection=='true')$html .='<div id="'.$fieldname.'_file_container" style="display:block;clear:both;"></div>';
    if($readonly=='false'){
        $html .='<div id="'.$fieldname.'filelist" style="display:block;float:left;">Your browser doesn\'t have Flash, Silverlight or HTML5 support.</div>
    <style>.moxie-shim,.moxie-shim-html5{display:none;}</style>
    <script type="text/javascript" >
    $(document).ready(function(){
        var fieldname="'.$fieldname.'";
        var multi_selection="'.$multi_selection.'";
        if(multi_selection!=""){
            if(multi_selection=="false")multi_selection_value=false;
            if(multi_selection=="true")multi_selection_value=true;
        }else{
            multi_selection_value=true;
        }
        var width=parseInt('.$div_width.',10);
        var height=parseInt('.$div_height.',10);
        var browse_button=fieldname+"pickfiles";
        if(width>0 && height>0){
            var resize_parameter="{width:"+width+",height:"+height+",quality: 90}";
            var image_style="width:"+width+"px;height:"+height+"px;";
            var image_div_style="width:"+(width+14)+"px;height:"+(height+12)+"px;";
        }
        if(width>0 && height==0){
            var resize_parameter="{width:"+width+",quality: 90}";
            var image_style="width:"+width+"px;";
            var image_div_style="width:"+(width+14)+"px;";
        }
        if(width==0 && height>0){
            var resize_parameter="{height:"+height+",quality: 90}";
            var image_style="height:"+height+"px;";
            var image_div_style="height:"+(height+12)+"px;";
        }
        if(width==0 && height==0){
            var resize_parameter="{quality: 90}";
            var image_style="max-width:626px;";
            var image_div_style="max-width:640px;";
        }
        var uploader = new plupload.Uploader({
            runtimes : "html5,flash,silverlight,html4",
            browse_button : browse_button,
            file_data_name: "Filedata",
            container: document.getElementById(fieldname+"_file_container"),
            multi_selection:multi_selection_value,
            url : "/Upload.php?m="+ Math.random(),
            flash_swf_url : "/Public/js/Moxie.swf",
	        silverlight_xap_url : "/Public/js/Moxie.xap",
            multipart_params: {
                "timestamp" : "'.$timestamp.'",
                "token"     : "'.$unique_salt.'",
                "module"    : "'.$currentModule.'",
                "category"  : "'.$fieldname.'",
                "record"    : "'.$record.'",
                 '.($image_width ? "img_width:$image_width," : "img_width:0,").($image_height ? "img_height:$image_height" : "img_height:0").'
            },
            resize: resize_parameter,
            filters : {
                max_file_size : "10mb",
                mime_types: [
                    {title : "Image files", extensions : "jpg,gif,png"}
                ]
            },
            init: {
                PostInit: function() {
                    $("#"+fieldname+"filelist").html("") ;
                },
                FilesAdded: function(up, files) {
                    plupload.each(files, function(file) {
                        var filename=file.name;
                        var filesize=file.size; 
                        var fileid=file.id;
                        var filesrc=file.src; 
                        if(multi_selection=="false"){
                            $("<div id=\'plupload_img_"+fieldname+""+fileid+"\' style=\'"+image_div_style+"position: relative;float:left;margin:8px 3px;border:1px solid #cdcdcd;\'>"
                                    +"<input type=\'hidden\' id=\'"+fieldname+""+fileid+"\' name=\'"+fieldname+"[]\' value=\'\'>"
                                    +"<input type=\'hidden\' name=\'image_"+fieldname+""+fileid+"\' value=\'\'  />"
                                    +"<a id=\'data_lightbox_"+fieldname+""+fileid+"\' href=\'/Public/images/uploading.gif\' data-lightbox=\'roadtrip\'><img class=\'img-responsive\' src=\'/Public/images/uploading.gif\' style=\'margin:4px 7px 0px 7px;border:1px #ddd solid;display:block;"+image_style+"\' />"
                                    +"<a onclick=\'productfile_delete(\""+fieldname+"\",\""+fileid+"\");\' href=\'javascript:void(0);\' style=\'display:block; height:15px; width:15px; position:absolute; top:0px; right:2px;\'>"
                                    +"<img src=\'/Public/images/guanbi.jpg\' /></a><div id=\'progress_"+fieldname+""+fileid+"\' style=\'width:0px;float:left;margin:0px 7px;height:4px;background-color:rgba(18,18,224,0.5);text-align:center;\'></div>"
                                    +"<div style=\'width:100%;text-align:center;margin-top:5px;\'><input id=\'propertyimg_"+fileid+"\' name=\'propertyimg_"+fileid+"\' type=\'radio\'><label for=\'propertyimg_"+fileid+"\'>&nbsp;&nbsp;选择图片</label></div></div>").insertBefore($("#"+fieldname+"pickfiles"));
                            $("#"+fieldname+"pickfiles").css("display","none");
                        }else{
                            $("#"+fieldname+"_file_container").append("<div id=\'plupload_img_"+fieldname+""+fileid+"\' style=\'"+image_div_style+"position: relative;float:left;margin:8px 3px;border:1px solid #cdcdcd;\'>"
                                    +"<input type=\'hidden\' id=\'"+fieldname+""+fileid+"\' name=\'"+fieldname+"[]\' value=\'\'>"
                                    +"<input type=\'hidden\' name=\'image_"+fieldname+""+fileid+"\' value=\'\'  />"
                                    +"<a id=\'data_lightbox_"+fieldname+""+fileid+"\' href=\'/Public/images/uploading.gif\' data-lightbox=\'roadtrip\'><img class=\'img-responsive\' src=\'/Public/images/uploading.gif\' style=\'margin:4px 7px 0px 7px;border:1px #ddd solid;display:block;"+image_style+"\' />"
                                    +"<a onclick=\'productfile_delete(\""+fieldname+"\",\""+fileid+"\");\' href=\'javascript:void(0);\' style=\'display:block; height:15px; width:15px; position:absolute; top:0px; right:2px;\'>"
                                    +"<img src=\'/Public/images/guanbi.jpg\' /></a><div id=\'progress_"+fieldname+""+fileid+"\' style=\'width:0px;float:left;margin:0px 7px;height:4px;background-color:rgba(18,18,224,0.5);text-align:center;\'></div>"
                                    +"<div style=\'width:100%;text-align:center;margin-top:5px;\'><input id=\'propertyimg_"+fileid+"\' name=\'propertyimg_"+fileid+"\' type=\'radio\'><label for=\'propertyimg_"+fileid+"\'>&nbsp;&nbsp;选择图片</label></div></div>");
                        }
                    });
                    uploader.start();
                },
                UploadProgress:function(uploader,file){
                    var cur_width=width*file.percent/100;
                    $("#progress_"+fieldname+""+file.id).css("width",cur_width+"px");
                    $("#progress_"+fieldname+""+file.id).text(file.percent+"%");
                },
                FileUploaded:function(up, file, info){ 
                    eval( "var jsondata = " + info.response+";");
					var err_msg=jsondata.error;
                    if(err_msg!="")
					{
						var orginalname=file.name;
                        alert("图片("+orginalname+")"+err_msg);  
                        var fileid=file.id;  
						productfile_delete(fieldname,fileid);
                    }
					else
					{
	                    var fileid=jsondata.id;
	                    var type=file.type;
	                    var size=file.size;
	                    var orginalid=file.id;
	                    var imgurl=decodeURIComponent(jsondata.src);
	                    $("#"+fieldname+""+orginalid).val(imgurl);
	                    $("#plupload_img_"+fieldname+""+orginalid).find("input[name^=\'image_\']").val(imgurl);
	                    $("#plupload_img_"+fieldname+""+orginalid).find(".img-responsive").attr("src",imgurl);
	                    $("#data_lightbox_"+fieldname+""+orginalid).attr("href",imgurl);
	                    $("#plupload_img_"+fieldname+""+orginalid).find("div[id^=\'progress_\']").css("display","none");
	                    $("#plupload_img_"+fieldname+""+orginalid).find("div[id^=\'progress_percent_\']").css("display","none");
	                    $("#propertyimg_"+orginalid).attr("value",imgurl);
	                    if(multi_selection=="false")$("#"+fieldname+"pickfiles").css("display","none");
					} 
                },
                Error: function(up, err) {
                    alert("Error : " + err.message);
                }
            }
        });
        uploader.init();
    });
    function productfile_delete(fieldname,fileid){
        $("#plupload_img_"+fieldname+fileid).remove();
        $("#"+fieldname+"pickfiles").css("display","block");
        $("#"+fieldname).val("");
    }
    </script>
    ';
    }
    return $html;
}

if (isset($_REQUEST['record']) && $_REQUEST['record'] != "")
{
    $record = $_REQUEST['record']; 
	
    $productContent = XN_Content::load($record,'mall_products');
    $fieldname="productpropertyimg";
	
	$correct_fieldname = $_REQUEST['correct_fieldname'];
    if ($correct_fieldname == "correctproductlogo")
	{
	    $image_width=768;
	    $image_height=550; 
	}
	else
	{
	    $image_width=500;
	    $image_height=500; 
	}
	
    $attachments=XN_Query::create("Content")
        ->tag("attachments")
        ->filter("type","eic","attachments") 
        ->filter("my.category",'=','productpropertyimg')
        ->filter("my.deleted","=","0")
		->filter("my.record","=",$record)
        ->order("my.sequence",XN_Order::ASC_NUMBER)
        ->end(-1)
        ->execute();
    $fieldvalues=array();
    foreach($attachments as $attachment_info)
    {
        $path = $attachment_info->my->path;
        $savefile  = $attachment_info->my->savefile;
        $img = $path.((strrpos($path,'/') == strlen($path) -1 )?'':'/').$savefile;
		$src = $_SERVER['DOCUMENT_ROOT'] . $img;
        if (file_exists($src))
        {
	        $size = getimagesize($src);
	        $size_w = $size[0]; // natural width
	        $size_h = $size[1]; // natural height
			if (intval($size_w) == $image_width && intval($size_h) == $image_height)
			{
				 $fieldvalues[]=$img;
			}
		} 
    } 
  
   
    $div_width=ceil($image_width/5);
    $div_height=ceil($image_height/5);

    $pluploadhtml ='<span style="color: #666666;display:block">注意：<font color="red">图片尺寸限制为'.$image_width.'*'.$image_height.'，选中后，需保存才能生效；</font></span>';
   
    $multi_selection='true';
    $title="商品图片";
    $readonly='false';
    $pluploadhtml.=getselectPlupLoadHtml($currentModule,$record,$fieldname,$fieldvalues,$div_width,$div_height,$image_width,$image_height,$readonly,$multi_selection,$title);
    $smarty->assign("MSG",$pluploadhtml);
	
 	
	
    $ONCLICK = '
        var img_url=$("input[name^=\'propertyimg_\']:checked").val();
        var correct_fieldname="'.$correct_fieldname.'";
        if(img_url!=""){
            $("#"+correct_fieldname).val(img_url);
            $("#"+correct_fieldname+"_link").attr("href",img_url).css("display","inline");
            $("#"+correct_fieldname+"_view").attr("src",img_url);
            $("#"+correct_fieldname+"_select").css("display","none");
            $("#"+correct_fieldname+"_delete").css("display","inline");
			BJUI.dialog("closeCurrent");
        }
	';
    $smarty->assign("ONCLICK", $ONCLICK);
    $smarty->assign("OKBUTTON", "确定选中");
    $smarty->display("MessageBox.tpl");
    die();
}

function allfilePluploadHtmlJson(json){
    allfilegetPlupLoadHtml(json.currentModule,json.record,json.fieldname,json.fieldvalues,json.width,json.readonly,json.multi_selection,json.mode,json.required,json.required_info);
}
function allfilegetPlupLoadHtml(currentModule,record,fieldname,values,divwidth,readonly,multi_selection,mode,required,required_info){
    var fieldvalues = (new Function("return "+values ))();
    var html = '<style>.moxie-shim,.moxie-shim-html5{display:none;}</style>';
    var reclass = ' class="form-control" ';
    if(fieldvalues!="" && fieldvalues.length>0){
        var length=fieldvalues.length;
        for(var i=0;i<length;i++){
            var fieldvalue=fieldvalues[i];
            var tmpnames = fieldvalue.split("/");
            var shortname = tmpnames[tmpnames.length-1];
            var fileinfo = shortname.split(".");
            var recordid=record+""+i;
            if(fieldvalue!=""){
                html+='<div id="plupload_img_'+fieldname+""+recordid+'" class=\'form-control\' style="width'+divwidth+'px;height:'+(divwidth-2)+'px;margin-top:2px;margin-right: 2px;position: relative;float:left;border:1px solid #cdcdcd;overflow: hidden;">'
                      +'<input class="'+fieldname+'" id="'+fieldname+""+recordid+'" type="hidden" name="'+fieldname+'[]" value="'+fieldvalue+'">';
                if (fileinfo[fileinfo.length-1].toLowerCase() == "jpg" || fileinfo[fileinfo.length-1].toLowerCase() == "png" || fileinfo[fileinfo.length-1].toLowerCase() == "gif"){
                    html+= '<a id="data_lightbox_'+fieldname+""+recordid+'" href="'+fieldvalue+'" data-lightbox="roadtrip">';
                    html+='<img class="img-responsive" src="'+fieldvalue+'" style="border:1px #ddd solid;display:block;width:'+(divwidth-14)+'px;height:'+(divwidth-12)+'px;"></a>';
                }else{
                    html+= '<a id="data_lightbox_'+fieldname+""+recordid+'" href="'+fieldvalue+'">';
                    html+='<span style="text-align: center; line-height:'+(divwidth-12)+'px;border:1px #ddd solid;display:block;width:'+(divwidth-14)+'px;height:'+(divwidth-12)+'px;" title="'+shortname+'">'+shortname+'</span></a>';
                }
                if(readonly=='false'){
                    html+='<a onclick="plupload_delete(\''+fieldname+'\',\''+recordid+'\');" href="javascript:void(0);" style="display:block; height:15px; width:15px; position:absolute; top:0px; right:2px;">'
                          +'<img src="/Public/images/guanbi.jpg"></a>';
                }else{
                    html+='<a onclick="plupload_delete(\''+fieldname+'\',\''+recordid+'\');" href="javascript:void(0);" style="display:none; height:15px; width:15px; position:absolute; top:0px; right:2px;">'
                          +'<img src="/Public/images/guanbi.jpg"></a>';
                }
                html+='<div id="progress_'+fieldname+""+recordid+'" style="width: 120px; float: left; margin: 0px 7px; height: 4px; text-align: center; display: none; background-color: rgba(18, 18, 224, 0.498039);">100%</div></div>';
            }
        }
    }
    else if(readonly=='true')
    {
        var recordid=record;
        var fieldvalue= "";
        html+='<div id="plupload_img_'+fieldname+""+recordid+'" style="width:'+divwidth+'px;height:'+divwidth+'px;position: relative;float:left;margin:2px 3px;border:1px solid #cdcdcd;">'
              +'<input class="'+fieldname+'" id="'+fieldname+""+recordid+'" type="hidden" name="'+fieldname+'[]" value="'+fieldvalue+'">'
              +'<input type="hidden" name="image_'+fieldname+""+recordid+'" value="'+fieldvalue+'">'
              +'<img class="img-responsive" src="/Public/images/noimage.jpg" style="margin:4px 7px 0px 7px;border:1px #ddd solid;display:block;width:'+(divwidth-14)+'px;height:'+(divwidth-12)+'px;">';
    }

    if(readonly=='false'){
        if (required == 'true')
            reclass = ' class="form-control required" ';
        if(fieldvalues!="" && multi_selection=='false' && fieldvalues.length>0){
            html +='<div id="'+fieldname+'pickfiles"'+reclass+'style="display:none;width'+divwidth+'px;height:'+(divwidth-2)+'px;position: relative;float:left;margin:2px 3px;border: 1px solid #cdcdcd;cursor:pointer;">'
                   +'<img style="margin-top:4px;width:'+(divwidth-16)+'px;height:'+(divwidth-14)+'px;" src="/Public/images/uploadimg.png">'
                   +'</div>';
        }else{
            html +='<div id="'+fieldname+'pickfiles"'+reclass+'style="display:block;width:'+divwidth+'px;height:'+(divwidth-2)+'px;position: relative;float:left;margin:2px 3px;border:1px solid #cdcdcd;cursor:pointer;">'
                   +'<img style="margin-top:4px;width:'+(divwidth-16)+'px;height:'+(divwidth-14)+'px;" src="/Public/images/uploadimg.png">'
                   +'</div>';
        }
    }else{
        html +='<div id="'+fieldname+'pickfiles" '+reclass+' style="display:none;'+divwidth+'height:24px;margin-top:2px;position: relative;float:left;border:1px solid #cdcdcd;cursor:pointer;">'
               +'</div>';
    }

    if(readonly=='false'){
        html +='<div id="'+fieldname+'filelist" style="display:block;float:left;"></div>';
    }
    if(required=='true'){
        var fieldvalue = "";
        if(fieldvalues!="" && fieldvalues.length>0)
        {
            fieldvalue = "1";
        }
        if(readonly=='false')
        {
            if (required_info != "")
            {
                html += '<input type="hidden" value="' + fieldvalue + '"  id="' + fieldname + '_plupload_required" name="' + fieldname + '_plupload_required"  data-rule="required;" data-msg-required="' + required_info + '">';
            }
            else
            {
                html += '<input type="hidden" value="' + fieldvalue + '"  id="' + fieldname + '_plupload_required" name="' + fieldname + '_plupload_required"  data-rule="required;">';
            }
        }else{
            html += '<input type="hidden" value="' + fieldvalue + '"  id="' + fieldname + '_plupload_required" name="' + fieldname + '_plupload_required">';
        }
    }
    else
    {
        var fieldvalue = "";
        if(fieldvalues!="" && fieldvalues.length>0)
        {
            fieldvalue = "1";
        }
        html += '<input type="hidden" value="' + fieldvalue + '"  id="' + fieldname + '_plupload_required" name="' + fieldname + '_plupload_required">';
    }
    jQuery("#"+fieldname+"_plupload_div").html(html);
    var browse_button_id=fieldname+"pickfiles";
    var container_id=fieldname+"_file_container";
    allfileinitplopupload(currentModule,record,fieldname,multi_selection,required,divwidth,mode,browse_button_id,container_id);
}
function allfileinitplopupload(module,record,fieldname,multi_selection,required,divwidth,mode,browse_button_id,container_id){
    var resize_parameter="{quality: 90}";
    var multi_selection_value=false;
    var width = document.getElementById(browse_button_id).offsetWidth;

    if(multi_selection!=""){
        if(multi_selection=="false")multi_selection_value=false;
        if(multi_selection=="true")multi_selection_value=true;
    }
    var uploader = new plupload.Uploader({
        runtimes : "html5,flash,silverlight,html4",
        browse_button : browse_button_id,
        file_data_name: "Filedata",
        multi_selection:multi_selection_value,
        url : "/Upload.php?upt=file&m="+ Math.random(),
        flash_swf_url : "/Public/js/Moxie.swf",
        silverlight_xap_url : "/Public/js/Moxie.xap",
        multipart_params: {
            'module'     : module,
            'token'      : mode,
            'record'     : record,
            'category'   : fieldname,
        },
        resize: resize_parameter,
        filters : {
            max_file_size : "50mb",
            mime_types: [
                {title : "All files", extensions : "*"}
            ]
        },

        init: {
            PostInit: function() {
                jQuery("#"+fieldname+"filelist").html("");
                var onInitFunc=fieldname+"_onload";
                if (typeof onInitFunc === 'string') onInitFunc = onInitFunc.toFunc()
                if(onInitFunc && typeof onInitFunc ==="function"){
                    onInitFunc();
                }
            },
            FilesAdded: function(up, files) {
                plupload.each(files, function(file) {
                    var filename=file.name;
                    var fileid=file.id;
                    var filesrc=file.src;
                    var tmpnames = filename.split("/");
                    var shortname = tmpnames[tmpnames.length-1];
                    var fileinfo = filename.split(".");
                    var html ='<div id="plupload_img_'+fieldname+""+fileid+'" class=\'form-control\' style="width'+divwidth+'px;height:'+(divwidth-2)+'px;margin-top:2px;margin-right:2px;position: relative;float:left;border:1px solid #cdcdcd;overflow: hidden;">'
                              +'<input class="'+fieldname+'" id="'+fieldname+""+fileid+'" type="hidden" name="'+fieldname+'[]" value="">';
                    if (fileinfo[fileinfo.length-1].toLowerCase() == "jpg" || fileinfo[fileinfo.length-1].toLowerCase() == "png" || fileinfo[fileinfo.length-1].toLowerCase() == "gif"){
                        html+= '<a id="data_lightbox_'+fieldname+""+fileid+'" href="'+filesrc+'" data-lightbox="roadtrip">';
                        html+='<img class="img-responsive" style="border:1px #ddd solid;display:block;width:'+(divwidth-14)+'px;height:'+(divwidth-12)+'px;"></a>';
                    }else{
                        html+= '<a id="data_lightbox_'+fieldname+""+fileid+'" href="'+filesrc+'">';
                        html+='<span style="text-align: center; line-height:'+(divwidth-12)+'px;border:1px #ddd solid;display:block;width:'+(divwidth-14)+'px;height:'+(divwidth-12)+'px;" title="'+shortname+'">'+shortname+'</span></a>';
                    }
                    html+='<a onclick="plupload_delete(\''+fieldname+'\',\''+fileid+'\');" href="javascript:void(0);" style="display:block; height:15px; width:15px; position:absolute; top:0px; right:2px;">'
                          +'<img src="/Public/images/guanbi.jpg"></a>';
                    html+="<div id='progress_"+fieldname+""+fileid+"' style='width:0px;float:left;margin:0px 7px;height:4px;background-color:rgba(18,18,224,0.5);text-align:center;'></div></div>";

                    if(multi_selection=="false"){
                        jQuery(html).insertBefore($("#"+fieldname+"pickfiles"));
                        jQuery("#"+fieldname+"pickfiles").css("display","none");
                    }else{
                        jQuery(html).insertBefore($("#"+fieldname+"pickfiles"));
                        //jQuery("#"+fieldname+"_plupload_div").append(html);
                    }
                    if(required=='true'){
                        jQuery("#"+fieldname+"_plupload_required").val('1');
                        jQuery("#"+fieldname+"_plupload_required").trigger("validate");
                    }
                });
                uploader.start();
            },
            UploadProgress:function(uploader,file){
                var cur_width=(width-14)*file.percent/100;
                jQuery("#progress_"+fieldname+""+file.id).css("width",cur_width+"px");
                jQuery("#progress_"+fieldname+""+file.id).text(file.percent+"%");
            },
            FileUploaded:function(up, file, info){
                eval( "var jsondata = " + info.response );
                var err_msg=jsondata.error;
                var orginalid=file.id;
                var orginalname=file.name;
                if(err_msg!=""){
                    alert("文件("+orginalname+")"+err_msg);
                    jQuery("#plupload_img_"+fieldname+orginalid).remove();
                    jQuery("#"+fieldname+"pickfiles").css("display","block");
                    jQuery("#"+fieldname).val("");
                }else{
                    jQuery("#"+fieldname+"_plupload_required").val('1');
                    var fileid=jsondata.id;
                    var type=file.type;
                    var size=file.size;
                    var imgurl=decodeURIComponent(jsondata.src);
                    jQuery("#"+fieldname+""+orginalid).val(imgurl);
                    jQuery("#plupload_img_"+fieldname+""+orginalid).find(".img-responsive").attr("src",imgurl);
                    jQuery("#data_lightbox_"+fieldname+""+orginalid).attr("href",imgurl);
                    jQuery("#plupload_img_"+fieldname+""+orginalid).find("div[id^=\'progress_\']").css("display","none");
                    jQuery("#plupload_img_"+fieldname+""+orginalid).find("div[id^=\'progress_percent_\']").css("display","none");
                    if(multi_selection=="false")$("#"+fieldname+"pickfiles").css("display","none");
                }
            },
            Error: function(up, err) {
                alert("失败 : " + err.message);
            }
        }

    })
    uploader.init();

}




function filegetPlupLoadHtmlJson(json){
    filegetPlupLoadHtml(json.currentModule,json.record,json.fieldname,json.fieldvalues,json.width,json.readonly,json.multi_selection,json.mode,json.required,json.required_info);
}
function filegetPlupLoadHtml(currentModule,record,fieldname,values,divwidth,readonly,multi_selection,mode,required,required_info){
    var fieldvalues = (new Function("return "+values ))();
    var html = '<style>.moxie-shim,.moxie-shim-html5{display:none;}</style>';
    var reclass = ' class="form-control" ';
    if(readonly=='false'){
        if (required == 'true')
            reclass = ' class="form-control required" ';
        if(fieldvalues!="" && multi_selection=='false' && fieldvalues.length>0){
            html +='<div id="'+fieldname+'pickfiles" '+reclass+' style="display:none;'+divwidth+'height:24px;margin-top:2px;position: relative;float:left;border:1px solid #cdcdcd;cursor:pointer;">'
                   +'<img style="float:right;margin-right:3px;width:20px;height:20px;" src="/Public/images/uploadimg.png">'
                   +'</div>';
        }else{
            html +='<div id="'+fieldname+'pickfiles" '+reclass+' style="display:block;'+divwidth+'height:24px;margin-top:2px;position: relative;float:left;border:1px solid #cdcdcd;cursor:pointer;">'
                   +'<img style="float:right;margin-right:3px;width:20px;height:20px;" src="/Public/images/uploadimg.png">'
                   +'</div>';
        }
    }else{
        html +='<div id="'+fieldname+'pickfiles" '+reclass+' style="display:none;'+divwidth+'height:24px;margin-top:2px;position: relative;float:left;border:1px solid #cdcdcd;cursor:pointer;">'
               +'</div>';
    }

    if(fieldvalues!="" && fieldvalues.length>0){
        var length=fieldvalues.length;
        for(var i=0;i<length;i++){
            var fieldvalue=fieldvalues[i];
            var tmpnames = fieldvalue.split("/");
            var shortname = tmpnames[tmpnames.length-1];
            var fileinfo = shortname.split(".");
            var recordid=record+""+i;
            if(fieldvalue!=""){
                html+='<div id="plupload_img_'+fieldname+""+recordid+'" class=\'form-control\' style="height:24px;'+divwidth+'margin-top:2px;position: relative;float:left;border:1px solid #cdcdcd;overflow: hidden;">'
                      +'<input class="'+fieldname+'" id="'+fieldname+""+recordid+'" type="hidden" name="'+fieldname+'[]" value="'+fieldvalue+'">';
                if (fileinfo[fileinfo.length-1].toLowerCase() == "jpg" || fileinfo[fileinfo.length-1].toLowerCase() == "png" || fileinfo[fileinfo.length-1].toLowerCase() == "gif"){
                    html+= '<a id="data_lightbox_'+fieldname+""+recordid+'" href="'+fieldvalue+'" data-lightbox="roadtrip">';
                    html+='<span style="line-height:24px;height: 24px;cursor: pointer;padding-right:15px;" title="'+shortname+'">'+fieldvalue+'</span></a>';
                }else{
                    html+= '<a id="data_lightbox_'+fieldname+""+recordid+'" href="'+fieldvalue+'">';
                    html+='<span style="line-height:24px;height: 24px;cursor: pointer;padding-right:15px;" title="'+shortname+'">'+fieldvalue+'</span></a>';
                }
                if(readonly=='false'){
                    html+='<a onclick="plupload_delete(\''+fieldname+'\',\''+recordid+'\');" href="javascript:void(0);" style="display:block; height:15px; width:15px; position:absolute; top:0px; right:2px;">'
                          +'<img src="/Public/images/guanbi.jpg"></a>';
                }else{
                    html+='<a onclick="plupload_delete(\''+fieldname+'\',\''+recordid+'\');" href="javascript:void(0);" style="display:none; height:15px; width:15px; position:absolute; top:0px; right:2px;">'
                          +'<img src="/Public/images/guanbi.jpg"></a>';
                }
                html+='<div id="progress_'+fieldname+""+recordid+'" style="width: 120px; float: left; margin: 0px 7px; height: 4px; text-align: center; display: none; background-color: rgba(18, 18, 224, 0.498039);">100%</div></div>';
            }
        }
    }
    else if(readonly=='true')
    {
        var recordid=record;
        var fieldvalue= "";
        html+='<div id="plupload_img_'+fieldname+""+recordid+'"'+reclass+'style="display:block;'+divwidth+'height:24px;margin-top:2px;position: relative;float:left;border:1px solid #cdcdcd;background-color:#eeeeee">'
              +'<input class="'+fieldname+'" id="'+fieldname+""+recordid+'" type="hidden" name="'+fieldname+'[]" value="'+fieldvalue+'">'
              +'<input type="hidden" name="image_'+fieldname+""+recordid+'" value="'+fieldvalue+'">'
              +'</div>';
    }

    if(readonly=='false'){
        html +='<div id="'+fieldname+'filelist" style="display:block;float:left;">Your browser doesn\'t have Flash, Silverlight or HTML5 support.</div>';
    }
    if(required=='true'){
        var fieldvalue = "";
        if(fieldvalues!="" && fieldvalues.length>0)
        {
            fieldvalue = "1";
        }
        if(readonly=='false')
        {
            if (required_info != "")
            {
                html += '<input type="hidden" value="' + fieldvalue + '"  id="' + fieldname + '_plupload_required" name="' + fieldname + '_plupload_required"  data-rule="required;" data-msg-required="' + required_info + '">';
            }
            else
            {
                html += '<input type="hidden" value="' + fieldvalue + '"  id="' + fieldname + '_plupload_required" name="' + fieldname + '_plupload_required"  data-rule="required;">';
            }
        }else{
            html += '<input type="hidden" value="' + fieldvalue + '"  id="' + fieldname + '_plupload_required" name="' + fieldname + '_plupload_required">';
        }
    }
    else
    {
        html += '<input type="hidden" value="' + fieldvalue + '"  id="' + fieldname + '_plupload_required" name="' + fieldname + '_plupload_required">';
    }
    jQuery("#"+fieldname+"_plupload_div").html(html);
    var browse_button_id=fieldname+"pickfiles";
    var container_id=fieldname+"_file_container";
    fileinitplopupload(currentModule,record,fieldname,multi_selection,required,divwidth,mode,browse_button_id,container_id);
}
function fileinitplopupload(module,record,fieldname,multi_selection,required,divwidth,mode,browse_button_id,container_id){
    var resize_parameter="{quality: 90}";
    var multi_selection_value=false;
    var width = document.getElementById(browse_button_id).offsetWidth;

    if(multi_selection!=""){
        if(multi_selection=="false")multi_selection_value=false;
        if(multi_selection=="true")multi_selection_value=true;
    }
    var uploader = new plupload.Uploader({
        runtimes : "html5,flash,silverlight,html4",
        browse_button : browse_button_id,
        file_data_name: "Filedata",
        multi_selection:multi_selection_value,
        url : "/Upload.php?upt=file&m="+ Math.random(),
        flash_swf_url : "/Public/js/Moxie.swf",
        silverlight_xap_url : "/Public/js/Moxie.xap",
        multipart_params: {
            'module'     : module,
            'token'      : mode,
            'record'     : record,
            'category'   : fieldname,
        },
        resize: resize_parameter,
        filters : {
            max_file_size : "50mb",
            mime_types: [
                {title : "All files", extensions : "*"}
            ]
        },

        init: {
            PostInit: function() {
                jQuery("#"+fieldname+"filelist").html("");
                var onInitFunc=fieldname+"_onload";
                if (typeof onInitFunc === 'string') onInitFunc = onInitFunc.toFunc()
                if(onInitFunc && typeof onInitFunc ==="function"){
                    onInitFunc();
                }
            },
            FilesAdded: function(up, files) {
                plupload.each(files, function(file) {
                    var filename=file.name;
                    var filesize=file.size;
                    var fileid=file.id;
                    var filesrc=file.src;
                    var fileinfo = filename.split(".");
                    //if(multi_selection=="false"){
                    //    jQuery("<div id=\'plupload_img_"+fieldname+""+fileid+"\' class=\'form-control\' style=\'height:24px;"+divwidth+"margin-top:2px;position: relative;float:left;border:1px solid #cdcdcd;\'>"
                    //           +"<input type=\'hidden\' id=\'"+fieldname+""+fileid+"\' name=\'"+fieldname+"[]\' value=\'\'>"
                    //           +"<label style='line-height:24px;height: 24px;'>"+filename+"</label>"
                    //           +"<a onclick=\'plupload_delete(\""+fieldname+"\",\""+fileid+"\");\' href=\'javascript:void(0);\' style=\'display:block; height:15px; width:15px; position:absolute; top:0px; right:2px;\'>"
                    //           +"<img src=\'/Public/images/guanbi.jpg\' /></a><div id=\'progress_"+fieldname+""+fileid+"\' style=\'width:0px;float:left;margin:0px 7px;height:4px;background-color:rgba(18,18,224,0.5);text-align:center;\'></div></div>").insertBefore($("#"+fieldname+"pickfiles"));
                    //    jQuery("#"+fieldname+"pickfiles").css("display","none");
                    //}else{
                    //    jQuery("#"+fieldname+"_plupload_div").append("<div id=\'plupload_img_"+fieldname+""+fileid+"\' class=\'form-control\' style=\'height:24px;"+divwidth+"margin-top:2px;position: relative;float:left;border:1px solid #cdcdcd;\'>"
                    //                                                 +"<input type=\'hidden\' id=\'"+fieldname+""+fileid+"\' name=\'"+fieldname+"[]\' value=\'\'>"
                    //                                                 +"<label style='line-height:24px;height: 24px;'>"+filename+"</label>"
                    //                                                 +"<a onclick=\'plupload_delete(\""+fieldname+"\",\""+fileid+"\");\' href=\'javascript:void(0);\' style=\'display:block; height:15px; width:15px; position:absolute; top:0px; right:2px;\'>"
                    //                                                 +"<img src=\'/Public/images/guanbi.jpg\' /></a><div id=\'progress_"+fieldname+""+fileid+"\' style=\'width:0px;float:left;margin:0px 7px;height:4px;background-color:rgba(18,18,224,0.5);text-align:center;\'></div></div>");
                    //}
                    var html ='<div id="plupload_img_'+fieldname+""+fileid+'" class=\'form-control\' style="height:24px;'+divwidth+'margin-top:2px;position: relative;float:left;border:1px solid #cdcdcd;overflow: hidden;">'
                          +'<input class="'+fieldname+'" id="'+fieldname+""+fileid+'" type="hidden" name="'+fieldname+'[]" value="">';
                    if (fileinfo[fileinfo.length-1].toLowerCase() == "jpg" || fileinfo[fileinfo.length-1].toLowerCase() == "png" || fileinfo[fileinfo.length-1].toLowerCase() == "gif"){
                        html+= '<a id="data_lightbox_'+fieldname+""+fileid+'" href="'+filesrc+'" data-lightbox="roadtrip">';
                        html+='<span style="line-height:24px;height: 24px;cursor: pointer;" title="'+filename+'">'+filename+'</span></a>';
                    }else{
                        html+= '<a id="data_lightbox_'+fieldname+""+fileid+'" href="'+filesrc+'">';
                        html+='<span style="line-height:24px;height: 24px;cursor: pointer;" title="'+filename+'">'+filename+'</span></a>';
                    }
                    html+='<a onclick="plupload_delete(\''+fieldname+'\',\''+fileid+'\');" href="javascript:void(0);" style="display:block; height:15px; width:15px; position:absolute; top:0px; right:2px;">'
                          +'<img src="/Public/images/guanbi.jpg"></a>';
                    html+="<div id='progress_"+fieldname+""+fileid+"' style='width:0px;float:left;margin:0px 7px;height:4px;background-color:rgba(18,18,224,0.5);text-align:center;'></div></div>";

                    if(multi_selection=="false"){
                        jQuery(html).insertBefore($("#"+fieldname+"pickfiles"));
                        jQuery("#"+fieldname+"pickfiles").css("display","none");
                    }else{
                        jQuery("#"+fieldname+"_plupload_div").append(html);
                    }
                    if(required=='true'){
                        jQuery("#"+fieldname+"_plupload_required").val('1');
                        jQuery("#"+fieldname+"_plupload_required").trigger("validate");
                    }
                });
                uploader.start();
            },
            UploadProgress:function(uploader,file){
                var cur_width=(width-14)*file.percent/100;
                jQuery("#progress_"+fieldname+""+file.id).css("width",cur_width+"px");
                jQuery("#progress_"+fieldname+""+file.id).text(file.percent+"%");
            },
            FileUploaded:function(up, file, info){
                eval( "var jsondata = " + info.response );
                var err_msg=jsondata.error;
                var orginalid=file.id;
                var orginalname=file.name;
                if(err_msg!=""){
                    alert("文件("+orginalname+")"+err_msg);
                    jQuery("#plupload_img_"+fieldname+orginalid).remove();
                    jQuery("#"+fieldname+"pickfiles").css("display","block");
                    jQuery("#"+fieldname).val("");
                }else{
                    jQuery("#"+fieldname+"_plupload_required").val('1');
                    var fileid=jsondata.id;
                    var type=file.type;
                    var size=file.size;
                    var imgurl=decodeURIComponent(jsondata.src);
                    jQuery("#"+fieldname+""+orginalid).val(imgurl);
                    jQuery("#plupload_img_"+fieldname+""+orginalid).find(".img-responsive").attr("src",imgurl);
                    jQuery("#data_lightbox_"+fieldname+""+orginalid).attr("href",imgurl);
                    jQuery("#plupload_img_"+fieldname+""+orginalid).find("div[id^=\'progress_\']").css("display","none");
                    jQuery("#plupload_img_"+fieldname+""+orginalid).find("div[id^=\'progress_percent_\']").css("display","none");
                    if(multi_selection=="false")$("#"+fieldname+"pickfiles").css("display","none");
                }
            },
            Error: function(up, err) {
                alert("失败 : " + err.message);
            }
        }

    })
    uploader.init();

}

function fileinitplopupload_old(module,record,fieldname,multi_selection,mode,browse_button_id,container_id){
    var resize_parameter="{quality: 90}";
    
    var uploader = new plupload.Uploader({
        runtimes : "html5,flash,silverlight,html4",
        browse_button : browse_button_id,
        file_data_name: "Filedata",
        //container: jQuery("#"+container_id),
        multi_selection:false,
        url : "/Upload.php?m="+ Math.random(),
        flash_swf_url : "/Public/js/Moxie.swf",
        silverlight_xap_url : "/Public/js/Moxie.xap",
        multipart_params: {
            'module'     : module,
            'token'      : mode,
            'record'     : record,
            'category'   : fieldname
        },
        resize: resize_parameter,
        filters : {
            max_file_size : "50mb",
            mime_types: [
                {title : "pem files", extensions : "pem"}
            ]
        },

        init: {
            PostInit: function() {
                jQuery("#"+fieldname+"filelist").html("");
                var onInitFunc=fieldname+"_onload";
                if (typeof onInitFunc === 'string') onInitFunc = onInitFunc.toFunc()
                if(onInitFunc && typeof onInitFunc ==="function"){
                    onInitFunc();
                }
            },
            FilesAdded: function(up, files) {
                plupload.each(files, function(file) {
                    var filename=file.name;
                    var filesize=file.size;
                    var fileid=file.id;
                    var filesrc=file.src;
					var image_div_style="width:400px;height:30px;"; 
					var input_style="margin:4px 7px 8px 7px;width:365px;"; 
					
	                jQuery("<div id=\'plupload_img_"+fieldname+""+fileid+"\' style=\'"+image_div_style+"position: relative;float:left;margin:2px 3px;border:1px solid #cdcdcd;\'>"
	                        +"<input class=\'"+fieldname+"\' style=\'"+input_style+"\' type=\'text\' id=\'"+fieldname+""+fileid+"\' name=\'"+fieldname+"[]\' value=\'\'>"
 				   			+"<a onclick=\'plupload_delete(\""+fieldname+"\",\""+fileid+"\");\' href=\'javascript:void(0);\' style=\'display:block; height:15px; width:15px; position:absolute; top:0px; right:2px;\'>"
	                        +"<img src=\'/Public/images/guanbi.jpg\' /></a><div id=\'progress_"+fieldname+""+fileid+"\' style=\'width:0px;float:left;margin:0px 7px;height:4px;background-color:rgba(18,18,224,0.5);text-align:center;\'></div></div>").insertBefore($("#"+fieldname+"pickfiles"));
           
					jQuery("#"+fieldname+"pickfiles").css("display","none");
                    
                });
                uploader.start();
            },
            UploadProgress:function(uploader,file){
                var cur_width=200*file.percent/100;
                jQuery("#progress_"+fieldname+""+file.id).css("width",cur_width+"px");
                jQuery("#progress_"+fieldname+""+file.id).text(file.percent+"%");
            },
            FileUploaded:function(up, file, info){
                eval( "var jsondata = " + info.response );
                var err_msg=jsondata.error;
                var orginalid=file.id;
                var orginalname=file.name;
                if(err_msg!=""){
                    alert("图片("+orginalname+")"+err_msg);
                    jQuery("#plupload_img_"+fieldname+orginalid).remove();
                    jQuery("#"+fieldname+"pickfiles").css("display","block");
                    jQuery("#"+fieldname).val("");
                }else{
                    var fileid=jsondata.id;
                    var type=file.type;
                    var size=file.size;
                    var imgurl=decodeURIComponent(jsondata.src);
                    jQuery("#"+fieldname+""+orginalid).val(imgurl);
                    //jQuery("#plupload_img_"+fieldname+""+orginalid).find(".img-responsive").attr("src",imgurl);
                    //jQuery("#data_lightbox_"+fieldname+""+orginalid).attr("href",imgurl);
                    jQuery("#plupload_img_"+fieldname+""+orginalid).find("div[id^=\'progress_\']").css("display","none");
                    jQuery("#plupload_img_"+fieldname+""+orginalid).find("div[id^=\'progress_percent_\']").css("display","none");
                    if(multi_selection=="false")$("#"+fieldname+"pickfiles").css("display","none");
                }
            },
            Error: function(up, err) {
                alert("失败");
                alert("Error : " + err.message);
            }
        }

    })
    uploader.init();

}

//currentModule：模块名；fieldname：字段名；div_width：图片框宽度；div_height：图片框高度；readonly：是否只读；multi_selection：是否多选；title：提示文字；
function getPlupLoadForJson(json){
	getPlupLoadHtml(json.currentModule,json.record,json.fieldname,json.fieldvalues,json.div_width,json.div_height,json.readonly,json.multi_selection,json.mode,json.img_width,json.img_height,json.required,json.required_info);
}

function getPlupLoadHtml(currentModule,record,fieldname,values,div_width,div_height,readonly,multi_selection,mode,img_width,img_height,required,required_info){
    //var fieldvalues = eval("("+values+")");
    var fieldvalues = (new Function("return "+values ))();
    var html = '<style>.moxie-shim,.moxie-shim-html5{display:none;}</style>';
    var reclass = ' class="form-control" ';
    if(readonly=='false'){
        if (required == 'true')
            reclass = ' class="form-control required" ';
        if(fieldvalues!="" && multi_selection=='false' && fieldvalues.length>0){
            html +='<div id="'+fieldname+'pickfiles"'+reclass+'style="display:none;width'+div_width+'px;height:'+(div_height-2)+'px;position: relative;float:left;margin:2px 3px;border: 1px solid #cdcdcd;cursor:pointer;">'
                    +'<img style="margin-top:4px;width:'+(div_width-16)+'px;height:'+(div_height-14)+'px;" src="/Public/images/uploadimg.png">'
                    +'</div>';
        }else{
            html +='<div id="'+fieldname+'pickfiles"'+reclass+'style="display:block;width:'+div_width+'px;height:'+(div_height-2)+'px;position: relative;float:left;margin:2px 3px;border: 1px solid #cdcdcd;cursor:pointer;">'
                    +'<img style="margin-top:4px;width:'+(div_width-16)+'px;height:'+(div_height-14)+'px;" src="/Public/images/uploadimg.png">'
                    +'</div>';
        }
    }

    if(fieldvalues!="" && fieldvalues.length>0){
        var length=fieldvalues.length;var i=0;
        for(i=0;i<length;i++){
            var fieldvalue=fieldvalues[i];
            var recordid=record+""+i;
            if(fieldvalue!=""){
                html+='<div id="plupload_img_'+fieldname+""+recordid+'" style="width:'+div_width+'px;height:'+div_height+'px;position: relative;float:left;margin:2px 3px;border:1px solid #cdcdcd;">'
                        +'<input class="'+fieldname+'" id="'+fieldname+""+recordid+'" type="hidden" name="'+fieldname+'[]" value="'+fieldvalue+'">'
                        +'<input type="hidden" name="image_'+fieldname+""+recordid+'" value="'+fieldvalue+'">'
                        +'<a id="data_lightbox_'+fieldname+""+recordid+'" href="'+fieldvalue+'" data-lightbox="roadtrip">'
                        +'<img class="img-responsive" src="'+fieldvalue+'" style="margin:4px 7px 0px 7px;border:1px #ddd solid;display:block;width:'+(div_width-14)+'px;height:'+(div_height-12)+'px;"></a>';
                if(readonly=='false'){
                    html+='<a onclick="plupload_delete(\''+fieldname+'\',\''+recordid+'\');" href="javascript:void(0);" style="display:block; height:15px; width:15px; position:absolute; top:0px; right:2px;">'
                            +'<img src="/Public/images/guanbi.jpg"></a>';
                }else{
                    html+='<a onclick="plupload_delete(\''+fieldname+'\',\''+recordid+'\');" href="javascript:void(0);" style="display:none; height:15px; width:15px; position:absolute; top:0px; right:2px;">'
                            +'<img src="/Public/images/guanbi.jpg"></a>';
                }
                html+='<div id="progress_'+fieldname+""+recordid+'" style="width: 120px; float: left; margin: 0px 7px; height: 4px; text-align: center; display: none; background-color: rgba(18, 18, 224, 0.498039);">100%</div></div>';
            }
        }
    }
	else if(readonly=='true')
	{
		var recordid=record;
		var fieldvalue= "";
	    html+='<div id="plupload_img_'+fieldname+""+recordid+'" style="width:'+div_width+'px;height:'+div_height+'px;position: relative;float:left;margin:2px 3px;border:1px solid #cdcdcd;">'
	            +'<input class="'+fieldname+'" id="'+fieldname+""+recordid+'" type="hidden" name="'+fieldname+'[]" value="'+fieldvalue+'">'
	            +'<input type="hidden" name="image_'+fieldname+""+recordid+'" value="'+fieldvalue+'">' 
	            +'<img class="img-responsive" src="/Public/images/noimage.jpg" style="margin:4px 7px 0px 7px;border:1px #ddd solid;display:block;width:'+(div_width-14)+'px;height:'+(div_height-12)+'px;">';
 
	}

    if(readonly=='false'){
        html +='<div id="'+fieldname+'filelist" style="display:block;float:left;"></div>';
    }
    if(required=='true'){
		var fieldvalue = "";
		if(fieldvalues!="" && fieldvalues.length>0)
		{
			fieldvalue = "1";
		}
        if(readonly=='false')
        {
            if (required_info != "")
            {
                html += '<input type="hidden" value="' + fieldvalue + '"  id="' + fieldname + '_plupload_required" name="' + fieldname + '_plupload_required"   data-rule="required;" data-msg-required="' + required_info + '">';
            }
            else
            {
                html += '<input type="hidden" value="' + fieldvalue + '"  id="' + fieldname + '_plupload_required" name="' + fieldname + '_plupload_required"  data-rule="required;">';
            }
        }else{
            html += '<input type="hidden" value="' + fieldvalue + '"  id="' + fieldname + '_plupload_required" name="' + fieldname + '_plupload_required">';
        }
    }
    jQuery("#"+fieldname+"_plupload_div").html(html);
    var browse_button_id=fieldname+"pickfiles";
    var container_id=fieldname+"_file_container";
    initplopupload(currentModule,record,fieldname,multi_selection,div_width,div_height,img_width,img_height,mode,browse_button_id,container_id);
}
function initplopupload(module,record,fieldname,multi_selection,width,height,img_width,img_height,mode,browse_button_id,container_id){
    var resize_parameter="{quality: 90}";
    var image_div_style="width:"+width+"px;height:"+height+"px;";
    var image_style="width:"+(width-14)+"px;height:"+(height-12)+"px;";
    var multi_selection_value=false;

    if(multi_selection!=""){
        if(multi_selection=="false")multi_selection_value=false;
        if(multi_selection=="true")multi_selection_value=true;
    }else{
        multi_selection_value=false;
    }
    var uploader = new plupload.Uploader({
        runtimes : "html5,flash,silverlight,html4",
        browse_button : browse_button_id,
        file_data_name: "Filedata",
        //container: jQuery("#"+container_id),
        multi_selection:multi_selection_value,
        url : "/Upload.php?m="+ Math.random(),
        flash_swf_url : "/Public/js/Moxie.swf",
        silverlight_xap_url : "/Public/js/Moxie.xap",
        multipart_params: {
            'module'     : module,
            'token'      : mode,
            'record'     : record,
            'category'   : fieldname,
            'img_width'  : img_width,
            'img_height' : img_height
        },
        resize: resize_parameter,
        filters : {
            max_file_size : "50mb",
            mime_types: [
                {title : "Image files", extensions : "jpg,gif,png"}
            ]
        },

        init: {
            PostInit: function() {
                jQuery("#"+fieldname+"filelist").html("");
                var onInitFunc=fieldname+"_onload";
                if (typeof onInitFunc === 'string') onInitFunc = onInitFunc.toFunc()
                if(onInitFunc && typeof onInitFunc ==="function"){
                    onInitFunc();
                }
            },
            FilesAdded: function(up, files) {
                plupload.each(files, function(file) {
                    var filename=file.name;
                    var filesize=file.size;
                    var fileid=file.id;
                    var filesrc=file.src;
                    if(multi_selection=="false"){
                        jQuery("<div id=\'plupload_img_"+fieldname+""+fileid+"\' style=\'"+image_div_style+"position: relative;float:left;margin:2px 3px;border:1px solid #cdcdcd;\'>"
                                +"<input class=\'"+fieldname+"\' type=\'hidden\' id=\'"+fieldname+""+fileid+"\' name=\'"+fieldname+"[]\' value=\'\'>"
                                +"<a id=\'data_lightbox_"+fieldname+""+fileid+"\' href=\'/Public/images/uploading.gif\' data-lightbox=\'roadtrip\'><img class=\'img-responsive\' src=\'/Public/images/uploading.gif\' style=\'margin:4px 7px 0px 7px;border:1px #ddd solid;display:block;"+image_style+"\' />"
                                +"<a onclick=\'plupload_delete(\""+fieldname+"\",\""+fileid+"\");\' href=\'javascript:void(0);\' style=\'display:block; height:15px; width:15px; position:absolute; top:0px; right:2px;\'>"
                                +"<img src=\'/Public/images/guanbi.jpg\' /></a><div id=\'progress_"+fieldname+""+fileid+"\' style=\'width:0px;float:left;margin:0px 7px;height:4px;background-color:rgba(18,18,224,0.5);text-align:center;\'></div></div>").insertBefore($("#"+fieldname+"pickfiles"));
                        jQuery("#"+fieldname+"pickfiles").css("display","none");
                    }else{
                        jQuery("#"+fieldname+"_plupload_div").append("<div id=\'plupload_img_"+fieldname+""+fileid+"\' style=\'"+image_div_style+"position: relative;float:left;margin:2px 3px;border:1px solid #cdcdcd;\'>"
                                +"<input class=\'"+fieldname+"\' type=\'hidden\' id=\'"+fieldname+""+fileid+"\' name=\'"+fieldname+"[]\' value=\'\'>"
                                +"<a id=\'data_lightbox_"+fieldname+""+fileid+"\' href=\'/Public/images/uploading.gif\' data-lightbox=\'roadtrip\'><img class=\'img-responsive\' src=\'/Public/images/uploading.gif\' style=\'margin:4px 7px 0px 7px;border:1px #ddd solid;display:block;"+image_style+"\' />"
                                +"<a onclick=\'plupload_delete(\""+fieldname+"\",\""+fileid+"\");\' href=\'javascript:void(0);\' style=\'display:block; height:15px; width:15px; position:absolute; top:0px; right:2px;\'>"
                                +"<img src=\'/Public/images/guanbi.jpg\' /></a><div id=\'progress_"+fieldname+""+fileid+"\' style=\'width:0px;float:left;margin:0px 7px;height:4px;background-color:rgba(18,18,224,0.5);text-align:center;\'></div></div>");
                    }
                });
                uploader.start();
            },
            UploadProgress:function(uploader,file){
                var cur_width=(width-14)*file.percent/100;
                jQuery("#progress_"+fieldname+""+file.id).css("width",cur_width+"px");
                jQuery("#progress_"+fieldname+""+file.id).text(file.percent+"%");
            },
            FileUploaded:function(up, file, info){
                eval( "var jsondata = " + info.response );
                var err_msg=jsondata.error;
                var orginalid=file.id;
                var orginalname=file.name;
                if(err_msg!=""){
                    alert("图片("+orginalname+")"+err_msg);
                    jQuery("#plupload_img_"+fieldname+orginalid).remove();
                    jQuery("#"+fieldname+"pickfiles").css("display","block");
                    jQuery("#"+fieldname).val("");
                }else{
					jQuery("#"+fieldname+"_plupload_required").val('1');
                    var fileid=jsondata.id;
                    var type=file.type;
                    var size=file.size;
                    var imgurl=decodeURIComponent(jsondata.src);
                    jQuery("#"+fieldname+""+orginalid).val(imgurl);
                    jQuery("#plupload_img_"+fieldname+""+orginalid).find(".img-responsive").attr("src",imgurl);
                    jQuery("#data_lightbox_"+fieldname+""+orginalid).attr("href",imgurl);
                    jQuery("#plupload_img_"+fieldname+""+orginalid).find("div[id^=\'progress_\']").css("display","none");
                    jQuery("#plupload_img_"+fieldname+""+orginalid).find("div[id^=\'progress_percent_\']").css("display","none");
                    if(multi_selection=="false")$("#"+fieldname+"pickfiles").css("display","none");
                }
            },
            Error: function(up, err) {
                alert("失败");
                alert("Error : " + err.message);
            }
        }

    })
    uploader.init();

}

function getfontPlupLoadHtml(currentModule,fieldname,values,div_width,div_height,readonly,multi_selection,mode,img_width,img_height,required,required_info){
    //var fieldvalues = eval("("+values+")");
    if(values==""){values="[]";}
    var fieldvalues = (new Function("return "+values ))();
    var html = '<style>.moxie-shim,.moxie-shim-html5{display:none;}</style>';
    if(readonly=='false'){
        if(fieldvalues!="" && multi_selection=='false' && fieldvalues.length>0){
            html +='<div id="'+fieldname+'pickfiles" style="display:none;width'+div_width+'px;height:'+(div_height-2)+'px;position: relative;float:left;margin:2px 3px;border: 1px solid #cdcdcd;cursor:pointer;">'
                +'<img style="margin:4px 7px 8px 7px;width:'+(div_width-14)+'px;height:'+(div_height-14)+'px;" src="/Public/images/uploadimg.png">'
                +'</div>';
        }else{
            html +='<div id="'+fieldname+'pickfiles" style="display:block;width:'+div_width+'px;height:'+(div_height-2)+'px;position: relative;float:left;margin:2px 3px;border: 1px solid #cdcdcd;cursor:pointer;">'
                +'<img style="margin:4px 7px 8px 7px;width:'+(div_width-14)+'px;height:'+(div_height-14)+'px;" src="/Public/images/uploadimg.png">'
                +'</div>';
        }
    }

    if(fieldvalues!="" && fieldvalues.length>0){
        var length=fieldvalues.length;var i=0;
        for(i=0;i<length;i++){
            var fieldvalue=fieldvalues[i];
            var recordid=record+""+i;
            if(fieldvalue!=""){
                html+='<div id="plupload_img_'+fieldname+""+recordid+'" style="width:'+div_width+'px;height:'+div_height+'px;position: relative;float:left;margin:2px 3px;border: 1px solid #cdcdcd;cursor:pointer;">'
                    +'<input class="'+fieldname+'" id="'+fieldname+""+recordid+'" type="hidden" name="'+fieldname+'[]" value="'+fieldvalue+'">'
                    +'<input type="hidden" name="image_'+fieldname+""+recordid+'" value="'+fieldvalue+'">'
                    +'<a id="data_lightbox_'+fieldname+""+recordid+'" href="'+fieldvalue+'" data-lightbox="roadtrip">'
                    +'<img class="img-responsive" src="'+fieldvalue+'" style="margin:4px 7px 0px 7px;border:1px #ddd solid;display:block;width:'+(div_width-14)+'px;height:'+(div_height-12)+'px;"></a>';
                if(readonly=='false'){
                    html+='<a onclick="plupload_delete(\''+fieldname+'\',\''+recordid+'\');" href="javascript:void(0);" style="display:block; height:15px; width:15px; position:absolute; top:0px; right:2px;">'
                        +'<img src="/Public/images/guanbi.jpg"></a>';
                }else{
                    html+='<a onclick="plupload_delete(\''+fieldname+'\',\''+recordid+'\');" href="javascript:void(0);" style="display:none; height:15px; width:15px; position:absolute; top:0px; right:2px;">'
                        +'<img src="/Public/images/guanbi.jpg"></a>';
                }
                html+='<div id="progress_'+fieldname+""+recordid+'" style="width: 120px; float: left; margin: 0px 7px; height: 4px; text-align: center; display: none; background-color: rgba(18, 18, 224, 0.498039);">100%</div></div>';
            }
        }
    }
    else if(readonly=='true')
    {
        var recordid=record;
        var fieldvalue= "";
        html+='<div id="plupload_img_'+fieldname+""+recordid+'" style="width:'+div_width+'px;height:'+div_height+'px;position: relative;float:left;margin:2px 3px;border:1px solid #cdcdcd;">'
            +'<input class="'+fieldname+'" id="'+fieldname+""+recordid+'" type="hidden" name="'+fieldname+'[]" value="'+fieldvalue+'">'
            +'<input type="hidden" name="image_'+fieldname+""+recordid+'" value="'+fieldvalue+'">'
            +'<img class="img-responsive" src="/Public/images/noimage.jpg" style="margin:4px 7px 0px 7px;border:1px #ddd solid;display:block;width:'+(div_width-14)+'px;height:'+(div_height-12)+'px;">';

    }

    if(readonly=='false'){
        html +='<div id="'+fieldname+'filelist" style="display:block;float:left;"></div>';
    }
    if(required=='true'){
        var fieldvalue = "";
        if(fieldvalues!="" && fieldvalues.length>0)
        {
            fieldvalue = "1";
        }
        if(readonly=='false')
        {
            if (required_info != "")
            {
                html += '<input type="hidden" value="' + fieldvalue + '"  id="' + fieldname + '_plupload_required" name="' + fieldname + '_plupload_required"  data-rule="required;" data-msg-required="' + required_info + '">';
            }
            else
            {
                html += '<input type="hidden" value="' + fieldvalue + '"  id="' + fieldname + '_plupload_required" name="' + fieldname + '_plupload_required"  data-rule="required;">';
            }
        }else{
            html += '<input type="hidden" value="' + fieldvalue + '"  id="' + fieldname + '_plupload_required" name="' + fieldname + '_plupload_required">';
        }
    }
    jQuery("#"+fieldname+"_plupload_div").html(html);
    var browse_button_id=fieldname+"pickfiles";
    var container_id=fieldname+"_file_container";
    initfontplopupload(currentModule,fieldname,multi_selection,div_width,div_height,img_width,img_height,mode,browse_button_id,container_id);
}
function initfontplopupload(module,fieldname,multi_selection,width,height,img_width,img_height,mode,browse_button_id,container_id){
    var resize_parameter="{quality: 90}";
    var image_div_style="width:"+width+"px;height:"+height+"px;";
    var image_style="width:"+(width-14)+"px;height:"+(height-12)+"px;";
    var multi_selection_value=false;

    if(multi_selection!=""){
        if(multi_selection=="false")multi_selection_value=false;
        if(multi_selection=="true")multi_selection_value=true;
    }else{
        multi_selection_value=false;
    }
    var uploader = new plupload.Uploader({
        runtimes : "html5,flash,silverlight,html4",
        browse_button : browse_button_id,
        file_data_name: "Filedata",
        //container: jQuery("#"+container_id),
        multi_selection:multi_selection_value,
        url : "/registerUpload.php?m="+ Math.random(),
        flash_swf_url : "/Public/js/Moxie.swf",
        silverlight_xap_url : "/Public/js/Moxie.xap",
        multipart_params: {
            'module'     : module,
            'img_width'  : img_width,
            'img_height' : img_height
        },
        resize: resize_parameter,
        filters : {
            max_file_size : "50mb",
            mime_types: [
                {title : "Image files", extensions : "jpg,gif,png"}
            ]
        },

        init: {
            PostInit: function() {
                jQuery("#"+fieldname+"filelist").html("");
                var onInitFunc=fieldname+"_onload";
                if (typeof onInitFunc === 'string') onInitFunc = onInitFunc.toFunc()
                if(onInitFunc && typeof onInitFunc ==="function"){
                    onInitFunc();
                }
            },
            FilesAdded: function(up, files) {
                plupload.each(files, function(file) {
                    var filename=file.name;
                    var filesize=file.size;
                    var fileid=file.id;
                    var filesrc=file.src;
                    if(multi_selection=="false"){
                        jQuery("<div id=\'plupload_img_"+fieldname+""+fileid+"\' style=\'"+image_div_style+"position: relative;float:left;margin:2px 3px;border:1px solid #cdcdcd;\'>"
                            +"<input class=\'"+fieldname+"\' type=\'hidden\' id=\'"+fieldname+""+fileid+"\' name=\'"+fieldname+"[]\' value=\'\'>"
                            +"<a id=\'data_lightbox_"+fieldname+""+fileid+"\' href=\'/Public/images/uploading.gif\' data-lightbox=\'roadtrip\'><img class=\'img-responsive\' src=\'/Public/images/uploading.gif\' style=\'margin:4px 7px 0px 7px;border:1px #ddd solid;display:block;"+image_style+"\' />"
                            +"<a onclick=\'plupload_delete(\""+fieldname+"\",\""+fileid+"\");\' href=\'javascript:void(0);\' style=\'display:block; height:15px; width:15px; position:absolute; top:0px; right:2px;\'>"
                            +"<img src=\'/Public/images/guanbi.jpg\' /></a><div id=\'progress_"+fieldname+""+fileid+"\' style=\'width:0px;float:left;margin:0px 7px;height:4px;background-color:rgba(18,18,224,0.5);text-align:center;\'></div></div>").insertBefore($("#"+fieldname+"pickfiles"));
                        jQuery("#"+fieldname+"pickfiles").css("display","none");
                    }else{
                        jQuery("#"+fieldname+"_plupload_div").append("<div id=\'plupload_img_"+fieldname+""+fileid+"\' style=\'"+image_div_style+"position: relative;float:left;margin:2px 3px;border:1px solid #cdcdcd;\'>"
                            +"<input class=\'"+fieldname+"\' type=\'hidden\' id=\'"+fieldname+""+fileid+"\' name=\'"+fieldname+"[]\' value=\'\'>"
                            +"<a id=\'data_lightbox_"+fieldname+""+fileid+"\' href=\'/Public/images/uploading.gif\' data-lightbox=\'roadtrip\'><img class=\'img-responsive\' src=\'/Public/images/uploading.gif\' style=\'margin:4px 7px 0px 7px;border:1px #ddd solid;display:block;"+image_style+"\' />"
                            +"<a onclick=\'plupload_delete(\""+fieldname+"\",\""+fileid+"\");\' href=\'javascript:void(0);\' style=\'display:block; height:15px; width:15px; position:absolute; top:0px; right:2px;\'>"
                            +"<img src=\'/Public/images/guanbi.jpg\' /></a><div id=\'progress_"+fieldname+""+fileid+"\' style=\'width:0px;float:left;margin:0px 7px;height:4px;background-color:rgba(18,18,224,0.5);text-align:center;\'></div></div>");
                    }
                });
                uploader.start();
            },
            UploadProgress:function(uploader,file){
                var cur_width=(width-14)*file.percent/100;
                jQuery("#progress_"+fieldname+""+file.id).css("width",cur_width+"px");
                jQuery("#progress_"+fieldname+""+file.id).text(file.percent+"%");
            },
            FileUploaded:function(up, file, info){
                eval( "var jsondata = " + info.response );
                var err_msg=jsondata.error;
                var orginalid=file.id;
                var orginalname=file.name;
                if(err_msg!=""){
                    alert("图片("+orginalname+")"+err_msg);
                    jQuery("#plupload_img_"+fieldname+orginalid).remove();
                    jQuery("#"+fieldname+"pickfiles").css("display","block");
                    jQuery("#"+fieldname).val("");
                }else{
                    jQuery("#"+fieldname+"_plupload_required").val('1');
                    var fileid=jsondata.id;
                    var type=file.type;
                    var size=file.size;
                    var imgurl=decodeURIComponent(jsondata.src);
                    jQuery("#"+fieldname+""+orginalid).val(imgurl);
                    jQuery("#plupload_img_"+fieldname+""+orginalid).find(".img-responsive").attr("src",imgurl);
                    jQuery("#data_lightbox_"+fieldname+""+orginalid).attr("href",imgurl);
                    jQuery("#plupload_img_"+fieldname+""+orginalid).find("div[id^=\'progress_\']").css("display","none");
                    jQuery("#plupload_img_"+fieldname+""+orginalid).find("div[id^=\'progress_percent_\']").css("display","none");
                    if(multi_selection=="false")$("#"+fieldname+"pickfiles").css("display","none");
                }
            },
            Error: function(up, err) {
                alert("失败");
                alert("Error : " + err.message);
            }
        }

    })
    uploader.init();

}
function plupload_delete(fieldname,fileid){
    jQuery("#plupload_img_"+fieldname+fileid).remove();
    jQuery("#"+fieldname+"pickfiles").css("display","block");
    if(jQuery('.'+fieldname).length <= 0)
    {
        jQuery("#" + fieldname).val("");
        jQuery("#" + fieldname + "_plupload_required").val('');
    }
}
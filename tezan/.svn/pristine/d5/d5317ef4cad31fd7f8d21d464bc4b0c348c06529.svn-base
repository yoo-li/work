function Upload_PurchaseStrategy_Template(module,template,record,supplierid){
    var uploader = new plupload.Uploader({
        runtimes : "html5,flash,silverlight,html4",
        browse_button : "uploadtemplate",
        file_data_name: "Filedata",
        multi_selection:"false",
        url : "index.php?module="+module+"&action=ImportExcelTemplate&upt=file&m="+ Math.random(),
        flash_swf_url : "/Public/js/Moxie.swf",
        silverlight_xap_url : "/Public/js/Moxie.xap",
        multipart_params: {
            "module"     : module,
            "token"      : "smarty",
            "record"     : record,
            "supplierid" : supplierid,
            "template"   : template,
        },
        filters : {
            max_file_size : "50mb",
            mime_types: [
                {title : "Excel files", extensions : "xls,xlsx"}
            ]
        },

        init: {
            PostInit: function() {
            },
            FilesAdded: function(up, files) {
                $(this).alertmsg("warn", "正在处理,请稍候...");
                uploader.settings.multipart_params.ma_factorys = $.CurrentNavtab.find("#ma_factorys_id").val();
                uploader.start();
            },
            UploadProgress:function(uploader,file){
            },
            FileUploaded:function(up, file, info){
                var jsondata = info.response.toObj();
                if(jsondata.error == "importok")
                {
                    $(this).navtab('refresh');
                    $(this).alertmsg("warn", "批量导入已完成!请保存生效!");
                }else{
                    $(this).navtab('refresh');
                    $(this).alertmsg("warn", jsondata.error);
                }
            },
            Error: function(up, err) {
                alert("失败 : " + err.message);
            }
        }

    })
    uploader.init();
}

function SubmitSimulateApply(module,record){
    if(!isUpdateWithForm()){
        $(this).dialog({
                           id:'dialog-mask',
                           url:'index.php?module='+module+'&action=SimulateApply&record='+record,
                           title:'提交上线',
                           mask:true,
                           resizable:false,
                           maxable:false
                       });
    }
}

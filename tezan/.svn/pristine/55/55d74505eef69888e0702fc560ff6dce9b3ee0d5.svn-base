
function SheetExportExcel(obj){
	var URL = "index.php?module=TakeCashs&action=SheetExportExcel&ids="+encodeURIComponent(obj.ids);
	setTimeout('downExcel("'+URL+'");',1500);
	$(this).alertmsg("warn",'正在处理数据，导出后点击“确定”关闭窗口');
}
function downExcel(url){
	location.href = url;
}

function applyReject(obj){
	jQuery.pdialog.open("index.php?module=TakeCashs&action=SheetExportExcel&opr=rejectexplanation&ids="+obj.ids,"rejectexplanation","驳回确认",{width:280,height:100,mask:true});
}

/*
function applyReject(){
	var ids = "";
	jQuery("input[name='ids']").each(
		function(){
			if($(this).attr("checked")=="checked"){
				if(ids != "")
					ids += ",";
				ids += $(this).val();
			}
		}
	);
	if(ids == ""){
		$(this).alertmsg("error",'请选择需要驳回的记录！');
	}else{
		var postBody = 'module=TakeCashs&action=SheetExportExcel&opr=rejectcheck&ids='+ids;
			jQuery.post("index.php", postBody,
				function (data, textStatus)
				{
					if(data != ""){
						$(this).alertmsg("error",data);
					}else{
						jQuery.pdialog.open("index.php?module=TakeCashs&action=SheetExportExcel&opr=rejectexplanation&ids="+ids,"rejectexplanation","驳回确认",{width:280,height:100,mask:true});
					}
			});	
	}
}
*/
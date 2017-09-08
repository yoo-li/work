function cityid_callback(groupid,args)
{ 
			jQuery("#cityid").val(args.id); 	
}
function SheetExportExcel(obj){
    var URL = "index.php?module=Mall_jdOrders&action=SheetExportExcel&ids="+encodeURIComponent(obj.ids);
    setTimeout('downExcel("'+URL+'");',1500);
    $(this).alertmsg("warn",'正在处理数据，导出后点击“确定”关闭窗口');
}


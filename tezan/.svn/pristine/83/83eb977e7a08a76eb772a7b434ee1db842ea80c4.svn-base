
function SheetExportExcel(obj){
	var URL = "index.php?module=Profile&action=SheetExportExcel&ids="+encodeURIComponent(obj.ids);
	setTimeout('downExcel("'+URL+'");',1500);
	$(this).alertmsg("warn",'正在处理数据，导出后点击“确定”关闭窗口');
}
function downExcel(url){
	location.href = url;
}


function changearea(value,type,select) {
	var urlstring = 'parent='+type+'&value='+value;
	jQuery.post("geturbanareas.php", urlstring,
	function (data, textStatus)
	{
						result = eval('(' + data + ')');
						switch(type) {
							
							case 'province':
								$("#city").html("<option value='--None--'>-- 无 --</option>");
								$("#district").html("<option value='--None--'>-- 无 --</option>");
								if (result.options)
								{
									for(var i=1;i<=result.options.length;i++) {
										if (result.options[i-1] == select){
											jQuery("#city").append(new Option(result.options[i-1],result.options[i-1]));
											jQuery("#city").val(result.options[i-1]);
										}else if(result.options[i-1] == result.selected){
											jQuery("#city").append(new Option(result.options[i-1],result.options[i-1]));
											jQuery("#city").val(result.options[i-1]);
										}else
											jQuery("#city").append(new Option(result.options[i-1],result.options[i-1]));										
									}
								}
								break;
							
						}

						
	});	
}
function confirm_select_profile(obj){
    var ids="";
    var names="";
    var shop_price="";
    var count=0;
    $(obj).parent().parent().parent().next().find("tbody>tr>td>div>input[name='ids']:checked").each(function(){
        count++;
        ids+=$(this).val()+";";
        names+=$(this).parent().parent().parent().find("td.givenname>div").text()+";";
    })
    if(count>1){
        alert("只能绑定一个会员");
        return false;
    }
    ids=ids.substr(0,ids.length-1);
    names=names.substr(0,names.length-1);
    $.bringBack({"id":ids,"Name":names});
}
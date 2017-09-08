//弹出列表框中选中某一行的回调函数，module为关联的模块名，args为返回的json数据对象
function mall_salesactivitys_massPopupcallback(args){
    var ids=args.id;
    var names=args.Name;
    var index=$("#selectproduct_table>tbody>tr").length;
    var ids_arr=ids.split(";");
    var names_arr=names.split(";");
    var length=ids_arr.length;
    var i=0;
    for(i=0;i<length;i++){
        var key=index+i+1;
        $("#selectproduct_table>tbody").append('<tr id="tr_salesactivity_'+key+'"><td align="center" class="index">'+key+'</td><td align="left"><input class="products_id" name="products_id['+key+']"  id="products_id'+key+'" type="hidden" value="'+ids_arr[i]+'"><input class="products_name required" name="products_name['+key+']" id="products_name'+key+'" style="width:99%;float:left;" readonly="" type="text"  value="'+names_arr[i]+'"></td><td align="center" width="10%"><span ><button type="button" onclick="delete_product(\''+key+'\')" class="btn btn-red" data-icon="times"><i class="fa fa-times"></i></button></span></td></tr>');

    }
}

function confirm_select_mall_products(){
    var ids="";
    var names="";
    var reg = /^\s*|\s*$/g;
    var str = "";
    str.replace(reg, "")
    $.CurrentDialog.find("#masspopup_listview_entries").find("div>table>tbody>tr>td>div>input[name='ids']:checked").each(function(){
        ids+=$(this).val()+";";
        var name=$(this).parent().parent().parent().find("td.productname").text();
        name=name.replace(reg, "")
        names+=name+";";
    })
    if (ids != "")
    {
	    ids=ids.substr(0,ids.length-1);
	    names=names.substr(0,names.length-1);
	    var callback=$("#callback").val();
	    var obj={"id":ids,"Name":names};
	    BJUI.dialog("closeCurrent");
	    mall_salesactivitys_massPopupcallback(obj);
    }
    else
    {
	    $(this).alertmsg("warn", "至少选择一件商品");
    }
}

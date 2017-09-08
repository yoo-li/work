function profile_callback(groupid,args)
{
    var ids=args.id;
    var names=args.Name;
    var ids_arr=ids.split(";");
    var names_arr=names.split(";");
    $("#profileid").val(ids_arr[0]);
    $("#profile_name").val(names_arr[0]);
}
function closeCurrentDialogandFlushList(){
    jQuery.pdialog.closeCurrent();
    navTab.reload("index.php?module=Suppliers&action=ListView",{title:"商家列表",fresh:false,mask:true, data:{} },"Suppliers");
}
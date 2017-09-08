function suppliercorrect_validate(){
    var abc="a";
    $("input[name^='change']").each(function(){
        if(this.value==1){
            abc="b";
        }
    });
    if(abc=="b"){
        return true;
    }else{
        $(this).alertmsg("info","至少更改一项");
        return false;
    }
}
function closeCurrentDialogandFlushList(){
    jQuery.pdialog.closeCurrent();
    navTab.reload("index.php?module=PropertyCorrect&action=ListView",{title:"商品信息修改",fresh:false,mask:true, data:{} },"PropertyCorrect");
}
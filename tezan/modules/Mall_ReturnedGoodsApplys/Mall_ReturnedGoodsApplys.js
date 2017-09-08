function Mall_ReturnedGoodsApplys_ProcessDetails_callback(json){
    $(this).bjuiajax('ajaxDone', json);
    BJUI.dialog("closeCurrent");
    $(this).navtab('closeTab','edit');
    $(this).navtab('refresh','Ma_Hospitals');
}
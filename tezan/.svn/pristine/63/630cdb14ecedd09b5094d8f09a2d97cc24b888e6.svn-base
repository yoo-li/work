var prevBtn     = $(".my-bjui-navtab").find('.tabsLeft')
var nextBtn     = $(".my-bjui-navtab").find('.tabsRight')
var ul_contaimer= $(".my-bjui-navtab").find(".tabsPageHeaderContent")
var maxIndex    = $(".my-bjui-navtab").find("ul.navtab-tab>li").length
var iW=0;//所有选显卡的宽度之和
$(".my-bjui-navtab").find("ul.navtab-tab>li").each(function() {
    iW += $(this).outerWidth(true)
})

$(function(){
    //ul容器的可视宽度
    var scrollW = $(".my-bjui-navtab").width() - 55
    if(iW>scrollW){
        prevBtn.css("display","none").addClass('tabsLeftDisabled');
        nextBtn.css("display","inline-block").removeClass('tabsRightDisabled');
        ul_contaimer.addClass('tabsPageHeaderMarginRight')
    }
})

function scrolltoleft(){
    var scrollW = $(".my-bjui-navtab").width() - 55
    var cLeft=$(".my-bjui-navtab").find("ul.navtab-tab>li").position().left;
    var iLeft=0;
    if(cLeft<0){
        var ks=0;
        for(var i=0;i<=maxIndex;i++){
            if(ks+$(".my-bjui-navtab").find("ul.navtab-tab>li").eq(i).outerWidth(true)>=-cLeft){
                break;
            }else{
                ks+=$(".my-bjui-navtab").find("ul.navtab-tab>li").eq(i).outerWidth(true)
            }
        }
        iLeft=ks-$(".my-bjui-navtab").find("ul.navtab-tab>li").eq(i).outerWidth(true)
        if(i>0){
            $(".my-bjui-navtab").find("ul.navtab-tab>li").animate({ left: -iLeft }, 200)
        }else{
            $(".my-bjui-navtab").find("ul.navtab-tab>li").animate({ left: 0 }, 200)
            prevBtn.css("display","none").addClass('tabsLeftDisabled')
            ul_contaimer.removeClass('tabsPageHeaderMarginLeft')
        }

        if(iLeft+scrollW<iW){
            nextBtn.css("display","block").removeClass('tabsRightDisabled')
            ul_contaimer.addClass('tabsPageHeaderMarginRight')
        }
    }
}
function scrolltoright(){
    var cLeft=$(".my-bjui-navtab").find("ul.navtab-tab>li").position().left;
    var scrollW = $(".my-bjui-navtab").width() - 55
    prevBtn.css("display","block").removeClass('tabsRightDisabled')
    ul_contaimer.addClass('tabsPageHeaderMarginLeft')
    if(iW>scrollW && iW>(scrollW-cLeft) ){
        var iLeft=0;
        var ks=0;
        for(var i=0;i<maxIndex;i++){
            ks+=$(".my-bjui-navtab").find("ul.navtab-tab>li").eq(i).outerWidth(true)
            if(ks>=(scrollW-cLeft)){
                iLeft=cLeft-$(".my-bjui-navtab").find("ul.navtab-tab>li").eq(i).outerWidth(true);
                break;
            }
        }
        $(".my-bjui-navtab").find("ul.navtab-tab>li").animate({ left: iLeft }, 200)
        if(i>=maxIndex){
            nextBtn.css("display","none").addClass('tabsLeftDisabled')
            ul_contaimer.removeClass('tabsPageHeaderMarginRight')
        }
    }
}
function switchtotab(obj,tabname,url){
    jQuery(".my-bjui-navtab").find("ul.tabsMoreList").css("display","none");

    var activeIndex=$(".my-bjui-navtab").find("ul.navtab-tab>li.active").index();
    $(obj).parent().parent().find("li").removeClass("active");
    $(obj).parent().addClass("active");
    var currentIndex=parseInt($(obj).parent().index(),10);
    var $tab = $(".my-bjui-navtab").find("ul.navtab-tab>li").removeClass('active').eq(currentIndex).addClass('active');
    var $tabs=$(".my-bjui-navtab").find("ul.navtab-tab>li");
    //ul容器的可视宽度
    var scrollW = $(".my-bjui-navtab").width()-55
    //选项卡当前距左端的距离
    var cLeft=$(".my-bjui-navtab").find("ul.navtab-tab>li").position().left;
    if(currentIndex==0){
        prevBtn.css("display","none").addClass('tabsLeftDisabled')
        ul_contaimer.removeClass('tabsPageHeaderMarginLeft')
    }
    if(currentIndex+1==maxIndex){
        nextBtn.css("display","none").addClass('tabsLeftDisabled')
        ul_contaimer.removeClass('tabsPageHeaderMarginRight')
    }
    if(iW>scrollW){
        var startIndex=getStartIndex();
        var endIndex=getEndIndex();
        if(currentIndex+1<startIndex){
            var visibleW=0;
            for (var i = 0; i < currentIndex; i++) {
                visibleW += $tabs.eq(i).outerWidth(true)
            }
            $(".my-bjui-navtab").find("ul.navtab-tab>li").animate({ left:-visibleW }, 200)
            nextBtn.css("display","block").removeClass('tabsLeftDisabled')
            ul_contaimer.addClass('tabsPageHeaderMarginRight')
        }
        if(currentIndex+1>endIndex){
            var visibleW=0;
            for (var i = 0; i <= currentIndex; i++) {
                visibleW += $tabs.eq(i).outerWidth(true)
            }
            $(".my-bjui-navtab").find("ul.navtab-tab>li").animate({ left:scrollW-visibleW }, 200)
            prevBtn.css("display","block").removeClass('tabsLeftDisabled')
            ul_contaimer.removeClass('tabsPageHeaderMarginLeft')
        }
    }
    //$("#my-navtab-content").loadUrl(url);
    $(this).bjuiajax("doLoad", {url:url, target:"#my-navtab-content",loadingmask:true});

}
function getStartIndex(){
    var ks=0;
    var cLeft=$(".my-bjui-navtab").find("ul.navtab-tab>li").position().left;
    var scrollW = $(".my-bjui-navtab").width() - 55
    for(var i=0;i<maxIndex;i++){
        if(ks>=-cLeft){
            return i+1;
        }else{
            ks+=$(".my-bjui-navtab").find("ul.navtab-tab>li").eq(i).outerWidth(true)
        }
    }
}
function getEndIndex(){
    var ks=0;
    var cLeft=$(".my-bjui-navtab").find("ul.navtab-tab>li").position().left;
    var scrollW = $(".my-bjui-navtab").width() - 55
    for(var i=0;i<maxIndex;i++){
        ks+=$(".my-bjui-navtab").find("ul.navtab-tab>li").eq(i).outerWidth(true)
        if(ks>(scrollW-cLeft)){
            return i;
        }
        if(ks==(scrollW-cLeft)){
            return i+1;
        }
    }
}

function showMoreList(){
    jQuery(".my-bjui-navtab").find("ul.tabsMoreList").css("display","block");
}
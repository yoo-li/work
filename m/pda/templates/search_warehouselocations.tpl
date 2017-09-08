<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <title>仓位信息</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <!--标准mui.css-->
    <link rel="stylesheet" href="/public/css/mui.min.css">
    <link href="/public/css/public.css" rel="stylesheet"/>
    <link href="/public/css/iconfont.css" rel="stylesheet"/>
    <!--App自定义的css-->
    <link rel="stylesheet" type="text/css" href="/public/css/tezan.css"/>
    <style>
        {literal}
        p {
            text-indent: 22px;
            padding: 5px 8px;
        }

        html,
        body,
        .mui-content {
            background-color: #fff;
        }

        h4 {
            margin-left: 5px;
        }

        .mui-plus header.mui-bar {
            display: none;
        }

        .mui-plus .mui-bar-nav ~ .mui-content {
            padding: 0;
        }

        {/literal}
    </style>
</head>

<body>
<header class="mui-bar mui-bar-nav">
    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
    <h1 class="mui-title">仓位信息</h1>
    <input type="hidden" readonly="readonly"  value="{$supplierid}" id="supplierid" class="form-control middle-width">
    <input type="hidden" readonly="readonly"  value="{$profileid}" id="profileid" class="form-control middle-width">
</header>
<div id="pullrefresh" class="mui-content mui-scroll-wrapper" style="padding-top: 50px;">
    <div class="mui-collapse-content">
        <form class="mui-input-group">
                <div class="mui-collapse-content" style="margin: 3px 3px;">
                    <div class="mui-input-row">
                        <label style="font-size: 15px;"></label>
                    </div>
                    <div class="mui-input-row">
                        <label style="font-size: 15px;">条码：</label>
                        <input style="font-size: 15px;" type="text" readonly="readonly" id="barcode"
                               >
                    </div>
                    {*<div class="mui-input-row">*}
                        {*<label style="font-size: 15px;">仓位编码：</label>*}
                        {*<input style="font-size: 15px;" type="text" readonly="readonly" id="no" >*}
                    {*</div>*}
                    {*<div class="mui-input-row">*}
                        {*<label style="font-size: 15px;">行：</label>*}
                        {*<input style="font-size: 15px;" type="text" readonly="readonly" id="warehouselocationrow">*}
                    {*</div>*}
                    {*<div class="mui-input-row">*}
                        {*<label style="font-size: 15px;">列：</label>*}
                        {*<input style="font-size: 15px;" type="text" readonly="readonly" id="warehouselocationcolumn">*}
                    {*</div>*}
                    {*<div class="mui-input-row">*}
                        {*<label style="font-size: 15px;">货架位置：</label>*}
                        {*<input style="font-size: 15px;" type="text" readonly="readonly" id="warehouselocationplace" >*}
                    {*</div>*}
                    <div id="div_search">
                    </div>
                </div>
        </form>
        {include file='copyright.tpl'}
    </div>
</div>
<script src="/public/js/mui.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/public/js/cordova.js"></script>
<script type="text/javascript" charset="utf-8">
    {literal}
    mui.init({
        gestureConfig: {
            longtap: true
        },
        swipeBack: false //启用右滑关闭功能
    });
    //处理点击事件，需要打开原生浏览器
    mui('body').on('tap', 'a', function (e) {
        var href = this.getAttribute('href');
        if (href) {
            if (window.plus) {
                plus.runtime.openURL(href);
            } else {
                location.href = href;
            }
        }
    });
    mui('.mui-scroll-wrapper').scroll({

        deceleration: 0.0005 //flick 减速系数，系数越大，滚动速度越慢，滚动距离越小，默认值0.0006
    });
    function JsonSearch(Str) {
        document.getElementById("div_search").innerHTML = '';
        document.getElementById("barcode").value=Str;
        var supplierid=document.getElementById("supplierid").value;
        var profileid=document.getElementById("profileid").value;
        mui.ajax({
            type: 'POST',
            traditional :true,
            dataType:"json",
            url: "search_warehouselocationsresult.php",
            data: {"barcodes":Str,"supplierid":supplierid},
            success: function (data) {
//                document.getElementById("no").value=data.no;
//                document.getElementById("warehouselocationrow").value=data.warehouselocationrow;
//                document.getElementById("warehouselocationcolumn").value=data.warehouselocationcolumn;
//                document.getElementById("warehouselocationplace").value=data.warehouselocationplace;
                var testdiv = document.getElementById("div_search");
                for (var key in data.details) {
                        var sitem = data.details[key];
                        testdiv.innerHTML +=
                                '<div class="mui-input-row" >' +
                                '<label style="font-size: 15px;"></label>' +
                                '</div>'+
                                '<div class="mui-input-row" style="height: 60px">' +
                                '<label style="font-size: 15px;">产品名:</label>' +
                                '<textarea  rows="2" >' + sitem.productname + '</textarea>' +
                                '</div>' +
                                '<div class="mui-input-row">' +
                                '<label style="font-size: 15px;">生产厂家：</label>' +
                                '<textarea  rows="2" >' + sitem.factorys_name + '</textarea>' +
                                '</div>'+
                                '<div class="mui-input-row">' +
                                '<label style="font-size: 15px;">产品编码：</label>' +
                                '<textarea  rows="2" >' + sitem.itemcode + '</textarea>' +
                                '</div>'+
                                '<div class="mui-input-row">' +
                                '<label style="font-size: 15px;">产品条码：</label>' +
                                '<textarea  rows="2" >' + sitem.barcode + '</textarea>' +
                                '</div>'+
                                '<div class="mui-input-row">' +
                                '<label style="font-size: 15px;">规格：</label>' +
                                '<textarea  rows="2" >' + sitem.guige + '</textarea>' +
                                '</div>'+
                                '<div class="mui-input-row">' +
                                '<label style="font-size: 15px;">库存数量：</label>' +
                                '<textarea  rows="2" >' + sitem.number + '</textarea>' +
                                '</div>';
                    }
            }
        });
    }


    {/literal}
</script>
</body>

</html>
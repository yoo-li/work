<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>采购收货</title>
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
    <h1 class="mui-title">采购收货</h1>
</header>
<div id="pullrefresh" class="mui-content mui-scroll-wrapper" style="padding-top: 50px;">
    <div class="mui-scroll">
        <div class="mui-card" style="margin: 3px 3px;">
            <ul id="orders" class="mui-table-view" style="padding-top: 5px;text-align:center;">
                {foreach name=blocks key=header item=data from=$purchaseordersinfo}
                    <li class="mui-table-view-cell">
                        <a href="sa_incheckstorage.php?record={$data.id}&no={$data.ma_purchaseorders_no}&profileid={$profileid}&suppliername={$suppliername}"
                           class="mui-navigate-right">
                            <div class="mui-media-body">{$data.ma_purchaseorders_no}</div>
                        </a>
                    </li>
                {/foreach}
                <li class="mui-table-view-cell">
                    <div class="mui-input-row" align="center">
                        <input style="width: 200px" type="text"  id="no" placeholder="请输入订单号">
                        <button type="button" class="mui-btn-outlined" id="submit" >提交</button>
                    </div>
                </li>
            </ul>
        </div>
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
    mui.ready(function () {
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
    mui('body').on('tap', 'button#submit', function (e) {
        var record=document.getElementById("no").value;
        mui.ajax({
            type: 'POST',
            traditional :true,
            dataType:"json",
            url: "adddata.php",
            data: {"record":record},
            success: function (data)
            {
                if(data=="200"){
                    alert("操作成功");
                }else if(data=="300"){
                    alert("该订单号无产品缺失");
                }else if(data=="400"){
                    alert("找不到该订单号");
                }
            }
        });
    });
    mui('.mui-scroll-wrapper').scroll({
        deceleration: 0.0005 //flick 减速系数，系数越大，滚动速度越慢，滚动距离越小，默认值0.0006
    });
    });
    {/literal}
</script>
</body>

</html>
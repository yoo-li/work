<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>扫码查询</title>
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
   {if $suppliername neq ''}
    <h1 class="mui-title">{$suppliername}信息化平台</h1>
       {else}
       <h1 class="mui-title">大泗医疗器械信息化平台</h1>
   {/if}
</header>
<div id="pullrefresh" class="mui-content mui-scroll-wrapper" style="padding-top: 50px;">
    <div class="mui-scroll">
        <div class="mui-card" style="margin: 3px 3px;">
            <ul id="orders" class="mui-table-view" style="padding-top: 5px;text-align:center;">
                <li class="mui-table-view-cell">
                    <a href="search_warehouselocations.php?supplierid={$supplierid}&profileid={$profileid}" class="mui-navigate-right">
                        <div class="mui-media-body  mui-pull-left">
                            <span class="mui-icon iconfont icon-xiaoshouchuku  menuicon button-color"></span>扫仓位条码
                        </div>
                    </a>
                </li>
                <li class="mui-table-view-cell">
                    <a href="search_barcode.php?supplierid={$supplierid}&profileid={$profileid}" class="mui-navigate-right">
                        <div class="mui-media-body  mui-pull-left">
                            <span class="mui-icon iconfont icon-jiechuchuku menuicon button-color"></span>扫商品条码(条码与产品信息匹配)
                        </div>
                    </a>
                </li>
                <li class="mui-table-view-cell">
                    <a href="search_barcode_other.php?supplierid={$supplierid}&profileid={$profileid}" class="mui-navigate-right">
                        <div class="mui-media-body  mui-pull-left">
                            <span class="mui-icon iconfont icon-jiechuchuku menuicon button-color"></span>扫商品条码(条码与产品信息不匹配)
                        </div>
                    </a>
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
    {/literal}
</script>
</body>

</html>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>领券中心</title>
    <link href="public/css/mui.css" rel="stylesheet" />
    <link href="public/css/public.css" rel="stylesheet" />
    <link href="public/css/iconfont.css" rel="stylesheet" />
    <link href="public/css/voupons.css" rel="stylesheet" />
    <script src="public/js/mui.min.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" src="public/js/jweixin.js"></script>
    <script src="public/js/zepto.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="public/js/utils.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" src="public/js/jweixin.js"></script>
    <style>
        {literal}
        .img-responsive { display: block; height: auto; width: 100%; }
        .mui-bar .tit-sortbar{
            left: 0;
            right: 0;
            margin-top: 45px;
        }
        .mui-bar .mui-segmented-control {
            top: 0px;
        }
        .mui-segmented-control.mui-segmented-control-inverted .mui-control-item {
            color: #333;
        }
        .price {
            color:#fe4401;
        }
        .mui-table-view-cell .mui-table-view-label
        {
            width:60px;
            text-align:right;
            display:inline-block;
        }
        .tishi
        {
            color:#fe4401;
            width:100%;
            text-align:center;
            padding-top:10px;
        }
        .tishi .mui-icon
        {
            font-size: 4.4em;
        }
        .msgbody
        {
            width:100%;
            font-size: 1.4em;
            line-height: 25px;
            color:#333;
            text-align:center;
            padding-top:10px;
        }
        .msgbody a
        {
            font-size: 1.0em;
        }
        header.mui-bar{
            background-color: #f9f9f9 !important;
        }
        header .mui-title, header a{
            color: #232326 !important;
        }
        .mui-segmented-control-negative.mui-segmented-control-inverted .mui-control-item.mui-active{
            color: #fb3e21 !important;
            border-bottom: 2px solid #fb3e21 !important;
        }
        .mui-content .mui-table-view-cell{
            margin-bottom: 5px;
            background: #f9f9f9;
        }
        .mui-content .mui-table-view-cell .mui-table-view-label{
            width: auto !important;
            text-align: left !important;
        }
        .mui-bar-tab .mui-tab-item.mui-active{
            color: #fb3e21 !important;
        }
        .mui-bar .tit-sortbar{
            background: #fff;
        }
        .mui-content{
            background: #fff;
        }
        .mui-table-view:after{
            display: none;
        }
        .promote-card-list .promote-left-part{
            width: 38%;
        }
        .promote-left-part .promote-condition{
            width: 38%;
            text-align: center;
            border-top: 0 !important;
            color: #fff !important;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .font-size-12{
            font-size: 10px !important;
        }
        .tishi{
            display: block;
            width: 80px;
            margin: 0 auto;
            padding-top: 30px;
        }
        .msgbody{
            font-size: 18px !important;
        }
        .promote-card-list .coupon-style-0 .promote-left-part {
            text-align: center;
            background: -webkit-gradient(linear, 0 0, 0 100%, from(#949191), to(rgb(125, 125, 125)));
        }
        .promote-card-list .coupon-style-1 .promote-left-part {
            text-align: center;
            background: -webkit-gradient(linear, 0 0, 0 100%, from(#fd740c), to(#fd740c));
            background: -moz-linear-gradient(top, #fd740c, #fd740c);
        }
        .promote-card-list .promote-item{
            border-radius: 0;
        }
        .promote-card-list .promote-left-part .promote-card-value i{
            font-weight: 500;
            font-size: 28px;
            font-style: normal;
        }
        .promote-card-list .promote-left-part .promote-card-value p{
            font-size: 10px;
            color:#fff;
            line-height: 20px;
            text-align: center;
        }
        .promote-card-list .promote-left-part .inner {
            padding: 10px 5px;
        }
        .promote-card-list .promote-right-part{
            width: 60%;
        }
        .promote-use-state{
            font-size: 12px !important;
            float: right;
            color: #ccc;
            border: 1px solid #ccc !important;
            border-radius: 12px !important;
            padding: 0 5px !important;
            margin-top: 12px !important;
        }
        @media screen and (max-width: 374px) {
            .promote-use-state{
                margin-top:29px !important;
            }
        }
        .promote-condition{
            position: absolute;
            bottom: 0;
            text-align: left;
            padding: 5px 0px !important;
            border-top: 1px dashed #ccc !important;
            color: #a4a4a4;
            width: 54%;
        }
        .promote-card-list .promote-left-part .promote-card-value{
            margin-top: 10px;
        }
        .promote-card-list h4{
            font-size: 16px;
            color: #1f2120;
            text-align: left;
            font-weight: 400;
        }
        .promote-card-list .promote-right-part .inner{
            padding: 10px;
        }
        .promote-right-part p{
            margin-top: 30px;
            color: #a4a4a4;
            font-size: 10px;
        }
        {/literal}
    </style>
    {include file='theme.tpl'}
    {if $supplierids eq 12352 }
        <style>
            {literal}
            header.mui-bar {
                background-color: #f9f9f9;
            }
            i{
                font-style: normal;
            }
            {/literal}
        </style>
    {/if}
</head>
<body>
<div class="mui-off-canvas-wrap mui-draggable" id="offCanvasWrapper">
    <div class="mui-inner-wrap">
        <header class="mui-bar mui-bar-nav" style="padding-right: 15px;">
            <a class="mui-icon mui-action-back mui-icon-back mui-pull-left"></a>
            <h1 class="mui-title">领券中心</h1>
            <div class="mui-title mui-content tit-sortbar" id="sortbar">
                <div id="segmentedControl" class="mui-segmented-control mui-segmented-control-inverted mui-segmented-control-negative">
                    <a class="mui-control-item " href="coupons.php">卡券优惠</a>
                    <a class="mui-control-item mui-active" href="couponsofme.php">我的卡券使用记录</a>
                </div>
            </div>
        </header>
        {include file='footer.tpl'}
        <div id="pullrefresh" class="mui-content mui-scroll-wrapper" style="padding-top: 85px;">
            <div class="mui-scroll">
                <input id="page" value="1" type="hidden" >
                <div  class="mui-table-view" >
                    <ul class="mui-table-view" style="padding-top: 5px;padding-bottom: 5px;"  >
                        <div class="promote-card-list" style="margin: 10px 10px;" id="list">

                        </div>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    {literal}

    mui.ready(function() {
        mui('#pullrefresh').scroll();
        mui('.mui-bar').on('tap','a',function(e){
            mui.openWindow({
                url: this.getAttribute('href'),
                id: 'info'
            });
        });

        mui('.mui-table-view').on('tap','a',function(e){
            mui.openWindow({
                url: this.getAttribute('href'),
                id: 'info'
            });
        });

    });

    mui.init({
        pullRefresh: {
            container: '#pullrefresh', //待刷新区域标识，querySelector能定位的css选择器均可，比如：id、.class等
            down: {
                callback: pulldownRefresh
            },
            up: {
                contentrefresh: "正在加载...", //可选，正在加载状态时，上拉加载控件上显示的标题内容
                contentnomore: '没有更多数据了', //可选，请求完毕若没有更多数据时显示的提醒内容；
                callback: add_more //必选，刷新函数，根据具体业务来编写，比如通过ajax从服务器获取新数据；
            }
        },
    });

    function pulldownRefresh() {
        Zepto('#sortbar').css("display","none");
        setTimeout(function() {
            Zepto('#sortbar').css("display","");
            Zepto('#page').val(1);
            Zepto('#list').html('');
            add_more();
            mui('#pullrefresh').pullRefresh().refresh(true);
            mui('#pullrefresh').pullRefresh().endPulldownToRefresh(); //refresh completed
        }, 1000);
    }

    function usage_html(v) {
        var sb=new StringBuilder();
//        sb.append('<li class="promote-item coupon-style-0 "><div class="promote-left-part"><div class="inner"><div class="promote-card-value"><i style="font-size: 0.6em;">'+v.vipcardname+'</i></div><div class="promote-condition font-size-12">'+v.order_no+'</div></div></div><div class="promote-right-part left font-size-12"><div class="inner"><h4> 金额：¥'+v.sumorderstotal+'</h4><p><div class="promote-use-state font-size-16">已使用</div><div class="promote-condition font-size-12">'+v.published+'</div></div><i class="expired-icon"></i><i class="left-dot-line"></i></li> ');
          sb.append('<li class="promote-item coupon-style-0 ">' +
                       '<div class="promote-left-part">' +
                         '<div class="inner">' +
                            '<div class="promote-card-value">' +
                                    '<span>￥</span>' +
                                    '<i>'+v.discount+'</i>' +
                            '</div>' +

                         '</div>' +
                       '</div>' +
                       '<div class="promote-right-part left font-size-12">' +
                          '<div class="inner">' +
                            '<h5 style="font-size: 1.2em;">'+v.vipcardname+'</h5>' +
                            '<div class="promote-use-state font-size-16">已使用</div>' +
                            '<div class="font-size-12" style="margin-top: 30px;">'+v.order_no+'</div>' +
                            '<div class="promote-condition font-size-12">'+v.published+'</div>' +
                          '</div>' +
                          '<i class="expired-icon"></i>' +
                          '<i class="left-dot-line"></i>' +
                       '</div>' +
                     '</li> ');
        return sb.toString();
    }


    function usage_empty_html()
    {
        var sb=new StringBuilder();
        sb.append('<div class="mui-content-padded"><img src="/public/images/coupons.png" alt="" class="tishi"><p class="msgbody">还没有券哦~<br></p></div>');
        return sb.toString();
    }


    function add_more() {
        var page = Zepto('#page').val();
        Zepto('#page').val(parseInt(page,10) + 1);
        mui.ajax({
            type: 'POST',
            url: "coupons.ajax.php",
            data: 'page=' + page,
            success: function(json) {
                var msg = eval("("+json+")");
              
                if (msg.code == 200) {


                    if (msg.data.length == 0 && page == 1)
                    {
                        Zepto('#list').html(usage_empty_html());
                        mui('#pullrefresh').pullRefresh().endPullupToRefresh(true); //参数为true代表没有更多数据
                    }
                    else
                    {
                        Zepto.each(msg.data, function(i, v) {
                            var nd = usage_html(v);
                            Zepto('#list').append(nd);
                        });
                        mui('#pullrefresh').pullRefresh().endPullupToRefresh(false); //参数为true代表没有更多数据了。
                    }
                } else {
                    mui('#pullrefresh').pullRefresh().endPullupToRefresh(true); //参数为true代表没有更多数据了。
                }
            }
        });
    }
    //触发第一页
    if (mui.os.plus) {
        mui.plusReady(function() {
            setTimeout(function() {
                mui('#pullrefresh').pullRefresh().pullupLoading();
            }, 1000);

        });
    } else {
        mui.ready(function() {
            Zepto('#page').val(1);
            mui('#pullrefresh').pullRefresh().pullupLoading();
        });
    }


    {/literal}
</script>
{include file='weixin.tpl'}
<script src="/public/js/baidu.js?_=20140821" type="text/javascript"></script>
</body>
</html>

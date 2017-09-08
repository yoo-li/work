<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>联系我们</title>
    <link href="public/css/mui.css" rel="stylesheet" />
    <link href="public/css/common.css" rel="stylesheet" />
    <link href="public/css/public.css" rel="stylesheet" />
    <link href="public/css/iconfont.css" rel="stylesheet" />
    <script src="public/js/mui.min.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" src="public/js/jweixin.js"></script>
    <script src="public/js/zepto.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="public/js/utils.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" src="public/js/jweixin.js"></script>
    <style>
        {literal}
        .img-responsive { display: block; height: auto; width: 100%; }
        .mui-table-view-cell .mui-table-view-label
        {
            width:60px;
            text-align:right;
            display:inline-block;
        }
        header.mui-bar{
            background-color: #f9f9f9 !important;
        }
        header .mui-title, header a{
            color: #232326 !important;
        }
        .mui-card{
            border: 0;
        }
        .mui-bar-nav{
            box-shadow: none;
            -webkit-box-shadow: none;
        }
        .mui-table-view:before,
        .mui-table-view-cell:after,
        .mui-table-view:after{
            top: 0;
            height: 0;
        }
        .mui-content{
            background: #fff;
        }
        .logo-qrcode{
            margin: 20px auto;
            display: block;
            width: 60%;
        }
        .mui-table-view-cell{
            margin-bottom: 5px;
            background: #f9f9f9;
        }
        .mui-table-view-cell .mui-table-view-label{
            width: auto !important;
            text-align: left !important;
        }
        .mui-bar-tab .mui-tab-item.mui-active{
            color: #fb3e21 !important;
        }
        header.mui-bar{
            background-color: #f9f9f9 !important;
        }
        header .mui-title, header a{
            color: #232326 !important;
        }
        .mui-content{
            background: #fff;
        }
        .mui-bar-nav{
            box-shadow: none;
            -webkit-box-shadow: none;
        }
        .mui-card{
            border: 0;
        }
        .mui-table-view-cell .mui-table-view-label{
            display: inline  !important;
            width: auto !important;
            text-align: left !important;
            font-size: 16px;
            line-height: 40px;
            color: #51a736;
        }
        .red{
            color: #fb3e21 !important;
        }
        .mui-bar-tab .mui-tab-item.mui-active{
            color: #fb3e21 !important;
        }
        .mui-content{
            background: #fff;
        }
        .show-content{
            display: none;
            padding: 0 10px;
            letter-spacing: 1px;
            padding: 0 10px;
            letter-spacing: 1px;
            position: fixed;
            top: 10%;
            left: 5%;
            width: 90%;
            height: 80%;
            z-index: 99;
            background: #fff;
            overflow: hidden;
            border-radius: 10px;
        }
        .show-content dd{
            margin: 0;
        }
        .show-content dd.name{
            margin-bottom: 10px;
            border-left: 4px solid #fe4205;
            padding-left: 5px;
        }
        .bg-shadow{
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 99;
        }
        .show-content .mui-scroll{
            width: 94%
        }
        .icon-close{
            display: none;
            color: #fff;
            position: fixed;
            z-index: 99;
            top: 10%;
            right: 5%;
            font-size: 24px;
            margin-top: -30px;
        }
        dd.name{
            margin-bottom: 10px;
            border-left: 4px solid #fe4205;
            padding-left: 5px;
        }
        .detail p{
            line-height: 20px;
            margin-bottom: 10px;
        }
        {/literal}
    </style>
    {include file='theme.tpl'}
</head>
<body>

<div class="mui-inner-wrap">
    <header class="mui-bar mui-bar-nav" style="padding-right: 15px;">
        <a class="mui-icon mui-action-back mui-icon-back mui-pull-left"></a>
        <h1 class="mui-title">兑换券使用许可协议</h1>
    </header>
    {*{include file='footer.tpl'}*}
    <div id="pullrefresh" class="mui-content mui-scroll-wrapper" style="padding-top: 45px;">
        <div class="mui-scroll">
            <div id="list" class="mui-table-view">
                <div class="mui-card" style="margin: 0;">
                    <ul class="mui-table-view">
                        <li class="mui-table-view-cell" style="background: #fff;letter-spacing: 1px;">
                            <div class="mui-media-body" style="color:red;text-align:left;">
                                <dl>
                                <dd class="detail" style="margin:-15px 0px 0px 0px;">
                                    <p>1.兑换券是仅限在无锡惠民商城使用，按面值总额减免支付的优惠码;</p>
                                    <p>2.兑换券分几种，按不同使用说明有不同用途;</p>
                                    <p>3.兑换券获取方式：通过无锡惠民商城的买赠、活动参与等形式获取;</p>
                                    <p>4.兑换券不能进行兑现、出售、转让或其他用途;</p>
                                    <p>5.本规则由无锡惠民商城依据国家相关法律法规及规章制度予以解释;</p>
                                </dd>
                                </dl>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<span class="icon icon-close">&#xe654;</span>
<script type="text/javascript">
    {literal}
    mui.init({
        pullRefresh: {
            container: '#pullrefresh', //待刷新区域标识，querySelector能定位的css选择器均可，比如：id、.class等
        },
    });
    mui.ready(function() {
        mui('.scroll-wrapper').scroll({
            indicators: false //是否显示滚动条
        });
        mui('#pullrefresh').scroll();
        mui('.mui-bar').on('tap','a',function(e){
            mui.openWindow({
                url: this.getAttribute('href'),
                id: 'info'
            });
        });
        mui('.mui-table-view-cell').on('tap','a',function(e){
            mui.openWindow({
                url: this.getAttribute('href'),
                id: 'info'
            });
        });
    });
    {/literal}
</script>
{include file='weixin.tpl'}
<script src="/public/js/baidu.js?_=20140821" type="text/javascript"></script>
</body>
</html>
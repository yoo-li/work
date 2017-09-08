<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>商城介绍</title>
    <link href="public/css/mui.css" rel="stylesheet" />
    <link href="public/css/public.css" rel="stylesheet" />
    <link href="public/css/reset.css" rel="stylesheet"/>
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
        .text_indent{
            text-indent: 2em;
        }
        .text_indent p{
            color: #000;
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
            color: #fe4401 !important;
        }
        .mui-bar-tab .mui-tab-item.mui-active{
            color: #fb3e21 !important;
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
        .mui-table-view-cell:after{
            display: none;
        }
        .contact .mui-table-view-cell{
            padding: 0 15px;
        }
        .contact .mui-table-view-cell,
        .contact .mui-table-view-cell .mui-table-view-label,
        .mui-table-view .mui-media-body{
            border: 0;
            font-size: 12px;
            color: #000;
        }
        {/literal}
    </style>
    {include file='theme.tpl'}
</head>
<body>

<div class="mui-inner-wrap">
    <header class="mui-bar mui-bar-nav" style="padding-right: 15px;">
        <a class="mui-icon mui-action-back mui-icon-back mui-pull-left"></a>
        <h1 class="mui-title">关于我们</h1>
    </header>
    {include file='footer.tpl'}
    <div id="pullrefresh" class="mui-content mui-scroll-wrapper" style="padding-top: 44px;">
        <div class="mui-scroll">
            <img src="/public/images/contact.jpg" alt="" class="logo-qrcode">
            <div class="mui-card" style="margin: 0;">
                <ul class="mui-table-view">
                    <li class="mui-table-view-cell">
                        <div class="mui-media-body  mui-pull-left">
                            <span class="mui-table-view-label red">关于惠民商城</span><br>
                            <p class="text_indent" style="letter-spacing: 1px;">无锡惠民商城是由无锡市民卡有限公司全资子公司无锡太湖交通卡有限公司独立研发运营的综合电商服务平台，为各类企事业单位提供方便、实惠、优质、快捷的综合福利消费平台，为企业员工提供“网络商店+实体店+联机账户+商城卡”的线上线下多渠道福利消费场景。目前无锡惠民商城已经与京东商城及无锡本地特色产品供应商开展了战略合作，实现最快“上午下单，下午发货”的全新福利消费新体验。</p>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="mui-card" style="margin: 0;">
                <ul class="mui-table-view contact">
                    <li class="mui-table-view-cell">
                        <div class="mui-media-body  mui-pull-left">
                            <span class="mui-table-view-label">客服电话：</span>0510-66660066
                        </div>
                    </li>
                    <li class="mui-table-view-cell">
                        <div class="mui-media-body  mui-pull-left">
                            <span class="mui-table-view-label">公司地址：</span>无锡市滨湖区建筑西路599号1幢19楼
                        </div>
                    </li>
                    <li class="mui-table-view-cell">
                        <div class="mui-media-body  mui-pull-left">
                            <span class="mui-table-view-label">微信公众号：</span>无锡惠民商城
                        </div>
                    </li>
                    <li class="mui-table-view-cell">
                        <div class="mui-media-body  mui-pull-left">
                            <span class="mui-table-view-label">企业邮箱：</span>wxhmmall@wxhmmall.com
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript">
    {literal}
    mui.init({
        pullRefresh: {
            container: '#pullrefresh', //待刷新区域标识，querySelector能定位的css选择器均可，比如：id、.class等
        },
    });
    mui.ready(function() {
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
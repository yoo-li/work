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
        <h1 class="mui-title">注意事项</h1>
    </header>
    {include file='footer.tpl'}
    <div id="pullrefresh" class="mui-content mui-scroll-wrapper" style="padding-top: 45px;">
        <div class="mui-scroll">
            <div id="list" class="mui-table-view">
                <div class="mui-card" style="margin: 0;">
                    <ul class="mui-table-view">
                        <li class="mui-table-view-cell" style="background: #fff;letter-spacing: 1px;">
                            <div class="mui-media-body" style="color:red;text-align:left;">
                                <dd class="name" >注意事项：
                                </dd>
                                <dd class="detail">
                                    <p>请务必在购物前仔细阅读以下条款，如有疑问，可咨询商城在线客服或者拨打客服热线。</p>
                                    <p>1.凡商品为自营的，均由京东配送，并且不支持货到付款；</p>
                                    <p>2.凡商品为非自营的，由与惠民商城合作的物流公司负责配送，不支持货到付款；</p>
                                    <p>3.所有订单在下单配送后7天内请确认收货，如有漏单、破损、延迟、丢件等问题请于下单后7天内及时联系商城在线客服，7天内均支持无理由退换货（<span style="color: #fb3e21;" class="show-shadow">退换货细则点击</span>）；</p>
                                    <p>4.惠民商城支持市民卡联机账户、惠民商城卡、惠民e卡、微信等多种支付方式，请您妥善保管好您的账户及密码，惠民商城从不会向用户索要账户密码，更不会泄露您的个人信息；</p>
                                    <p>5.惠民商城会不定期策划一些促销活动，商品价格有波动都是正常现象，我司不会因此补偿相应的差额。</p>
                                    <br/>
                                    <p>为了更多的消费者能够正常参与惠民商城的优惠活动，营造一个公平公正透明的网络购物环境，对存在以下情形的购买行为，惠民商城将保留取消相关订单或服务以及进行追偿的权利：</p>
                                    <p>1.因收货人信息填写有误，连续3天联系不上，无法完成订单配送；</p>
                                    <p>2.利用惠民商城漏洞多次下单，骗取商品优惠、折扣、赠品的行为；</p>
                                    <p>3.同一顾客（包括但不限于收货电话、用户名、用户地址、收货地址相同或类似，以及存在其他可能被认为属同一自然人的情形）购买数量超过活动限制的订单；</p>
                                    <p style="padding-bottom: 10px;">4.天气等不可抗力造成的因素；</p>
                                </dd>
                                </dl>

                                <dl class="seven-days">
                                    <dd class="name">退换货规则</dd>
                                    <dd class="detail">
                                        <p>1.订单未支付前，可以随时取消该订单；</p>
                                        <p>2.订单支付成功后，若您想取消该订单，因为物流流转速度很快，请您提交退货退款申请后及时联系在线客服咨询此订单的配送情况，若订单尚未出库，会在3个工作日内为您办理退款，退款金额原路返回至您的账户。<span style="color: #f94302">若订单已经出库进入配送阶段，请您选择拒收此单，待订单退库成功后，3个工作日内为您办理退款，退款金额原路返回至您的账户。</span>若您不拒收此单，我们将拒绝您的退款申请；</p>
                                        <p>3.自客户收到商品之日起7日内可以退货，15日内可以换货</p>
                                        <p>4.您退货时应当将商品本身、配件及赠品（包括赠送的实物、积分、代金券、优惠券等形式）一并退回。若赠品不能一并退回，惠民商城有权要求您按照事先标明的赠品价格支付赠品价款。</p>
                                        <p>5.退货价款以您实际支出的价款为准。</p>
                                        <p>6.您退货时所产生的运费依法由您自行承担，另有约定的除外。</p>
                                        <p>7.该退换货规则根据实际运营情况酌情修改。</p>
                                    </dd>
                                </dl>
                                <dl>
                                    <!-- <h3 class="show-content" style="font-size: 18px"><em>具体细则</em></h3> -->
                                    <dd class="name" >以下商品不支持无理由退货：
                                    </dd>
                                    <dd class="detail">
                                        <p>1.个人定制类；</p>
                                        <p>2.鲜活易腐类；</p>
                                        <p>3.在线下载类/拆封的音像制品/计算机软件等数字化商品；</p>
                                        <p>4.交付的报纸期刊类商品；</p>
                                        <p>5.根据商品性质不适宜退货，并经您在购买时确认的商品：</p>
                                        <p>a.拆封后易影响人身安全或者生命健康的商品，或者拆封后易导致商品品质发生改变的商品；</p>
                                        <p>b.一经激活或者试用后价值贬损较大的商品；</p>
                                        <p>c.销售时已明示的临近保质期的商品、有瑕疵的商品；</p>
                                        <p>d.其他根据商品性质不适宜退货，在商品页面标注“不支持无理由退货”并经您在购买时确认的商品；</p>
                                        <p>6.无法保证退回商品完好的商品（能够保持原有品质、功能，商品本身、配件、商标标识齐全的，视为商品完好）。</p>
                                    </dd>
                                </dl>
                                <dl>
                                    <dd class="name" >以下商品不支持退换货：</dd>
                                    <dd class="detail">
                                        <p>1.任何非惠民商城出售的商品；</p>
                                        <p>2.过保商品（超过三包保修期的商品）；</p>
                                        <p>3.未经授权的维修、误用、碰撞、疏忽、滥用、进液、事故、改动、不正确的安装所造成的商品质量问题，或撕毁、涂改标贴、机器序号、防伪标记；</p>
                                        <p>4.三包凭证信息与商品不符及被涂改的；</p>
                                        <p>5.其他依法不应办理退换货的。</p>
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
<div class="bg-shadow"></div>
<div class="show-content scroll-wrapper">
    <div class="mui-scroll">
        <dl class="seven-days">
            <dd class="name">退换货规则</dd>
            <dd class="detail" style="letter-spacing: 1px;">
                <p>1.订单未支付前，可以随时取消该订单；</p>
                <p>2.订单支付成功后，若您想取消该订单，因为物流流转速度很快，请您提交退货退款申请后及时联系在线客服咨询此订单的配送情况，若订单尚未出库，会在3个工作日内为您办理退款，退款金额原路返回至您的账户。<span style="color: #f94302">若订单已经出库进入配送阶段，请您选择拒收此单，待订单退库成功后，3个工作日内为您办理退款，退款金额原路返回至您的账户。</span>若您不拒收此单，我们将拒绝您的退款申请；</p>
                <p>3.自客户收到商品之日起7日内可以退货，15日内可以换货</p>
                <p>4.您退货时应当将商品本身、配件及赠品（包括赠送的实物、积分、代金券、优惠券等形式）一并退回。若赠品不能一并退回，惠民商城有权要求您按照事先标明的赠品价格支付赠品价款。</p>
                <p>5.退货价款以您实际支出的价款为准。</p>
                <p>6.您退货时所产生的运费依法由您自行承担，另有约定的除外。</p>
                <p>7.该退换货规则根据实际运营情况酌情修改。</p>
                <br/>
                <p>以下商品不支持退换货：</p>
                <p>1.任何非惠民商城出售的商品。</p>
                <p>2.过保商品（超过三包保修期的商品）。</p>
                <p>3.未经授权的维修、误用、碰撞、疏忽、滥用、进液、事故、改动、不正确的安装所造成的商品质量问题，或撕毁、涂改标贴、机器序号、防伪标记。</p>
                <p>4.三包凭证信息与商品不符及被涂改的。</p>
                <p>5.其他依法不应办理退换货的。</p>
            </dd>
        </dl>
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
        mui('#list').on('tap','.show-shadow',function(e){
            $('.icon-close').show();
            $('.show-content').show();
            $('.bg-shadow').show();
        });
        mui('body').on('tap','.bg-shadow, .icon-close',function(e){
            $('.icon-close').hide();
            $('.show-content').hide();
            $('.bg-shadow').hide();
        });

    });
    {/literal}
</script>
{include file='weixin.tpl'}
<script src="/public/js/baidu.js?_=20140821" type="text/javascript"></script>
</body>
</html>
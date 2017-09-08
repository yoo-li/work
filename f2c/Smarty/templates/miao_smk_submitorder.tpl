<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="public/css/mui.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="public/css/smk_order.css">
    <link href="public/css/public.css" rel="stylesheet"/>
    <link href="public/css/common.css" rel="stylesheet"/>
    <link href="public/css/iconfont.css" rel="stylesheet"/>
    <link href="public/css/mui.picker.css" rel="stylesheet"/>
    <link href="public/css/mui.poppicker.css" rel="stylesheet"/>
    <link href="public/css/mui.listpicker.css" rel="stylesheet"/>
    <link href="public/css/mui.dtpicker.css" rel="stylesheet"/>
    <link href="public/css/sweetalert.css" rel="stylesheet"/>
    <script src="public/js/mui.min.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" src="public/js/jweixin.js"></script>
    <script src="public/js/zepto.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="public/js/mui.picker.js"></script>
    <script src="public/js/mui.poppicker.js"></script>
    <script src="public/js/mui.listpicker.js"></script>
    <script src="public/js/mui.dtpicker.js"></script>
    <script src="public/js/utils.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" src="public/js/sweetalert.min.js"></script>
    <title>确认订单</title>
</head>
<style>
    {literal}

    .mysure_top .mui-media-body span {
        color: #fe4401;
    }

    .mysure .mysure_list .mui-media-body p:first-child span{
        font-size: .28rem;
    }
    .mysure .mysure_list{
        position: relative;
        padding: 10px 10px 10px 30px;
        background: url(public/images/line.png) left bottom repeat-x;
        background-color: #fff;
    }
    .icon-address{
        position: absolute;
        position: absolute;
        left: 0;
        font-size: .4rem !important;
        font-weight: bold;
    }
    .h50{
        height: 50px;
    }
    .confirmpayment{
        border-radius: 0 !important;
    }
    .goods-img{
        line-height: inherit !important;
        max-width: 1.66rem !important;
        height: auto !important;
    }
    .mui-table-view-chevron .mui-table-view-cell span,
    .mui-pull-right span{
        font-size: .26rem;
        color: #fb3e21;
    }
    .price{
        color: #fb3e21 !important;
    }
    .mysure_top .mui-media-body p:first-child{
        word-break: break-all;
    }
    .order_lift p{
        color:#232326;
        font-size:0.26rem;
    }
    .order_lift ul{
        padding:0;
    }
    .order_lift li{
        list-style:none;
        text-align:left;
        color:#808080;
        font-size:0.26rem;
    }
    .order_lift span{
        font-size:0.24rem;
        margin:0 5px;
    }
    .adress_list_bg{
        width:100%;
        height:100%;
        background: rgba(0,0,0,.5);
        position: fixed;
        bottom:0;
        z-index: 20;
    }
    .adress_list{
        position: absolute;
        bottom:0;
        width:100%;
    }
    .adress_list h3{
        font-size:0.3rem;
        background: white;
    }
    .mui-navigate-right{
        font-size:0.26rem;
    }
    .mui-navigate-right:after{
        color:#f25618 !important;
        font-size:0.6rem !important;
    }
    .order_lift_choose{
        height:0.8rem;
    }
    .order_lift_adress{
        text-align:left !important;
    }
    .order_lift_choose label{
        transform: translateY(3px);
        width:40% !important;
        padding-left:0 !important;
    }
    .order_lift_choose input{
        font-size:0.22rem;
        width:60% !important;
    }
    {/literal}

</style>
<body>
<header id="header" class="mui-bar mui-bar-nav mui-draggable mysure_hd">
    <p class="mui-title">确认订单</p>
    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
</header>
{*<nav class="mui-bar mui-bar-tab mysure_bottom">*}
    {*合计&nbsp;&nbsp;<span style="color:#fb3e21;">￥*}
        {*{if $miao_price <= 119}*}
            {*{$miao_price+6}*}
        {*{else}*}
            {*{$miao_price}*}
        {*{/if}*}
             {*&nbsp;&nbsp;&nbsp;</span><!--（邮费*}
        {*{if $shoppingcarts.0.productallcount >= 1}{$shoppingcarts.0.postage}{else}0{/if}*}
        {*元）-->*}
		{*{if $allowpayment eq 'true'}*}
	    {*<button type="button" class="mui-btn confirmpayment " style="display: inline-block;width:30%;font-size: 14px !important">确认</button>*}
		{*{/if}*}
{*</nav>*}
<nav class="mui-bar mui-bar-tab mysure_bottom">
    合计&nbsp;&nbsp;<span style="color:#fb3e21;">￥{$total_money}&nbsp;&nbsp;&nbsp;</span><!--（邮费

        {if $shoppingcarts.0.productallcount >= 1}
            {$shoppingcarts.0.postage}{else}
            0
         {/if}
        元）-->
    {if $allowpayment eq 'true'}
        <button type="button" class="mui-btn confirmpayment " style="display: inline-block;width:30%;font-size: 14px !important">确认</button>
    {/if}
</nav>
<div class="mui-scroll-wrapper" id="pullrefresh" style="padding-top: 44px;">
    <div class="mui-scroll">
        <div class="mui-content mysure">
            <form method="post" name="frm" action="/rob_confirmpayment.php">
                <input name="token" value="{$token}" type="hidden">
                <input name="record" value="{$orderid}" type="hidden">
                <input id="sumorderstotal" value="{$total_money}" type="hidden">
                <input name="productid" value="{$productid}" type="hidden">{* 秒杀活动ID*}
                <input name="salesactivityid" value="{$salesactivityid}" type="hidden">{* 秒杀活动商品ID*}
                <input id="deliveraddress_count" value="{$deliveraddress|@count}" type="hidden">
                <ul class="mui-table-view">
                    {if $deliveraddress|@count eq 0}
                    <li class="mui-table-view-cell mui-media mysure_list">
                        <a href="/deliveraddress.php" >
                            <div class="mui-media-body">
                                <p class="mysure_user"> 您还没有收货地址，赶快去创建吧！</span></p>
                            </div>
                        </a>
                    {else}
                    <li class="mui-table-view-cell mui-media mysure_list">
                        <div class="mui-media-body">
                            <p class="mysure_user">{$deliveraddress.consignee}<span>{$deliveraddress.mobile}</span></p>
                            {if $tradestatus eq 'pretrade'}
                            <p>{$deliveraddress.province}{$deliveraddress.city}{$deliveraddress.district}</p>
                            <p>{$deliveraddress.shortaddress}
                        </div>
                            {else}
                            <a href="deliveraddress.php?orderid={$orderid}" >
                                <p style="font-weight: 400;"><span class="icon icon-address">&#xe600;</span>{$deliveraddress.province}{$deliveraddress.city}{$deliveraddress.district}{$deliveraddress.shortaddress}</p>
                            </a>
                            <!--add-->
                        </div>
                            {/if}
                            <span class="mui-icon mui-icon-forward" style="position: absolute;top: 20px;right: 10px"></span>
                        <!--del-->
                        <!--</div>-->
                    </li>
                    {/if}
                    <li class="mui-table-view-cell mysure_top">
                        <div class="mui-media-body">
                            <ul class="mui-table-view mui-table-view-chevron" style="color: #333;">
                                {foreach name="shoppingcarts" item=shoppingcart_info  from=$shoppingcarts}
                                <li class="mui-table-view-cell mui-left" style="min-height:104px;height: auto;  padding-right: 5px;">
                        <img class="mui-media-object mui-pull-left" src="{$shoppingcart_info.productthumbnail}">
                        <div class="mui-media-body">
                            <p class='mui-ellipsis' style="color:#333">{$shoppingcart_info.productname}</p>
                            {if $shoppingcart_info.propertydesc neq ""}
                            <p class='mui-ellipsis'>属性：{$shoppingcart_info.propertydesc}</p>
                            {/if}
                            <p class='mui-ellipsis'>数量：
                                {if $miao_price neq 0}
                                   1
                                {else}
                                {$shoppingcart_info.quantity}
                                {/if}
                                件</p>
                            <p class='mui-ellipsis'>{if $shoppingcart_info.zhekou neq ''}{if $shoppingcart_info.activitymode eq '1'}底价{else}活动价{/if}：
                                <span class="price">¥{$shoppingcart_info.shop_price}</span>
                                        <span style="color:#878787;margin-left:5px;text-decoration:line-through;">
                                        ¥{$shoppingcart_info.old_shop_price}</span>{else}单价：
                                        <span class="price">
                                            {*{if $miao_price neq ''}*}
                                                {*¥{$miao_price}*}
                                                {*{else}*}
                                                ¥{$miao_price}
                                            {*{/if}*}
                                    {*<input type="text" value="{$miao_price}" id ="miao_price">*}


                                        </span>{/if}</p>
                            {if $shoppingcart_info.activitymode eq '1'}
                            <p class='mui-ellipsis'>
                                砍价：{if $shoppingcart_info.bargains_count eq 0}还没有好友帮忙砍价{else}已有 {$shoppingcart_info.bargains_count}位好友帮忙砍价{/if}
                            </p>
                            {/if}

                            {*<p class='mui-ellipsis'>*}
                            {*小计：<span id="total_price_{$shoppingcart_info.id}" class="price">¥{$shoppingcart_info.total_price}</span>*}
                            {*</p>*}
                        </div>
                    </li>
                                {/foreach}
                            </ul>
                        </div>
                    </li>
                    <li class="mui-table-view-cell">卖家留言<input id="buyermemo" name="buyermemo" class="mui-pull-right mysure_input" type="text" placeholder="选填：对本次交易的说明" style="font-size:0.24rem"></li>
                    {if $address_list neq ''}
                    <li class="mui-table-view-cell order_lift">
                        <p>自提时间和地址</p>
                        <form class="mui-input-group">
                            <div class="mui-input-row">
                                <div class="mui-table-view-cell order_lift_choose">
                                    <label>提取日期 :</label>
                                    <input type="text" class="mui-input-clear lift_date" name="date">
                                </div>
                                <div class="mui-table-view-cell order_lift_choose">
                                    <label>提取时间 :</label>
                                    <input type="text" class="mui-input-clear lift_time" name="time">
                                </div>
                                <div class="mui-table-view-cell order_lift_choose">
                                    <label>自提门店地址 :</label>
                                    <input type="text" class="mui-input-clear order_lift_adress" name="adress">
                                    <input type="hidden" value="111" name="adressid" class="order_lift_adressid">
                                </div>
                            </div>
                        </form>
                    </li>
                    {/if}
                    </form>

                    {if $allowpayment neq 'true'}
                    <div class="mui-table-view-cell" style="margin-top:3px;">
                        <div  class="mui-media-body" style="color:#cc3300;text-align:center">
                            {$errormsg}
                        </div>
                    </div>
                    {/if}
                    <li class="mui-table-view-cell" style="text-align:right;" id="total_quantity">共
                        {if $miao_price neq 0}
                            1
                        {else}
                            {$total_quantity}
                        {/if}

                        件商品&nbsp;&nbsp;&nbsp;商品金额：
                        <span style="color:#fb3e21;width:80px;margin-right:0px;display:inline-block;text-align: left" id="total_money">￥<span id='goods_money_all'> {$miao_price} </span></span><br/>
                        运费：
                        {if $miao_price >= 119}
                            <span style="color:#fb3e21;width:80px;margin-right:0px;display:inline-block;text-align: left" id="postage">¥ 0.00</span>
                        {else}
                            <span style="color:#fb3e21;width:80px;margin-right:0px;display:inline-block;text-align: left" id="postage">
                                ¥{if $shoppingcart_info.mergepostage|@intval eq 1}{$shoppingcart_info.postage}{else}{$shoppingcart_info.postage*$shoppingcart_info.quantity|string_format:"%0.2f"}{/if}
                            </span>
                        {/if}
                     </li>
                </ul>

            </form>
        <!--add-->
        </div>
    </div>

</div>
<div class="adress_list_bg" hidden>
        <div class="adress_list">
            <ul class="mui-table-view mui-table-view-radio">
                <h3 class="mui-table-view-cell">请选择提货地址</h3>
                {foreach name="address_list" item=address  from=$address_list}
                <li class="mui-table-view-cell ">
                    <a href="javascript:;" class="mui-navigate-right">{$address.address}</a>
                    <input type="hidden" value="{$address.id}">
                </li>
                {/foreach}
            </ul>
        </div>
    </div>
    <script type="text/javascript">
        {literal}
            $('.lift_date').on('tap',function(){
                var dtpicker = new mui.DtPicker({
                    "type": "date"
                })
                dtpicker.show(function(selectItems){
                    $('.lift_date').val(selectItems.value)
                });
            });
            $('.lift_time').on('tap',function(){
                var dtpicker = new mui.DtPicker({
                    "type": "time"
                })
                dtpicker.show(function(selectItems) {
                    $('.lift_time').val(selectItems.value)
                })
            })
            $('.order_lift_adress').val($('.mui-selected a').text())
            $('.order_lift_adress').on('tap',function(){
                $('.adress_list_bg').show()
            });
            $('.mui-navigate-right').on('tap',function(){
                $('.adress_list_bg').hide();
                 $('.order_lift_adress').val($(this).text());
                 $('.order_lift_adressid').val($(this).next().val());
            });
            $('.adress_list_bg').on('tap',function(){
                $('.adress_list_bg').hide();
            });

        {/literal}
    </script>

</body>

<script type="text/javascript">
    {literal}
    ! function() {
        function a() {
            document.documentElement.style.fontSize = document.documentElement.clientWidth / 6.4 + "px";
            if (document.documentElement.clientWidth >= 640) document.documentElement.style.fontSize = '100px';
        }
        var b = null;
        window.addEventListener("resize", function() {
            clearTimeout(b), b = setTimeout(a, 300)
        }, !1), a()
    }(window);
    mui('body').on('tap','a',function(){document.location.href=this.href;});

    mui.init({
        pullRefresh: {
            container: '#pullrefresh'
        }
    });
    mui.ready(function (){

        mui('#pullrefresh').scroll();
        var postage=$('#postage').html();

        mui('.msgbody').on('tap', 'a', function (e)
        {
            mui.openWindow({
                url: this.getAttribute('href'),
                id: 'info'
            });
        });

        mui('.mui-table-view').on('tap', 'a.deliveraddress', function (e)
        {
            mui.openWindow({
                url: this.getAttribute('href'),
                id: 'info'
            });
        });
        mui('.mui-table-view').on('tap', 'a.fapiao', function (e)
        {
            mui.openWindow({
                url: this.getAttribute('href'),
                id: 'info'
            });
        });
        mui('.mui-bar').on('tap', 'button.confirmpayment', function (e)
        {
            var deliveraddress_count = $("#deliveraddress_count").val();
            if (deliveraddress_count != "0")
            {
                document.frm.submit();
            }
            else
            {
                sweetAlert("警告", "请先创建收货地址，谢谢！", "error");
            }

        });
        mui('header.mui-bar').on('tap', 'a.mui-icon-back', function (e)
        {
            mui.openWindow({
                url: this.getAttribute('href'),
                id: 'info'
            });
        });

    });

    {/literal}
</script>

</html>

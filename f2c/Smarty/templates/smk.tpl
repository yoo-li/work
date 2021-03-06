<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <meta name="x5-orientation" content="portrait">
    <meta name="x5-fullscreen" content="true">
    <meta name="full-screen" content="yes">
    <title>惠民商城</title>
    <script src="public/js/mui.min.js"></script>
    <script src="public/js/zepto.min.js"></script>
    <link href="public/css/public.css" rel="stylesheet" />
    <link href="public/css/mui.min.css" rel="stylesheet"/>
    <link href="public/css/reset.css" rel="stylesheet"/>
    <link href="public/css/iconfont.css" rel="stylesheet" />
    <script type="text/javascript">
        {*//高度适配说明：通过设置一个方便计算的数值，来设置根元素的font-size,所有元素通过rem为单位达到适配需求；*}
        {*//具体使用：*}
        {*//通过视觉稿宽度除以一个数获得一个方便计算的值100；*}
        {*//所有元素的高度可用{(视觉稿量的的高度)/100}rem获得适配的高度；*}
        {literal}
        !function(){function a(){document.documentElement.style.fontSize=document.documentElement.clientWidth/6.4+"px";if(document.documentElement.clientWidth>=640)document.documentElement.style.fontSize='100px';}var b=null;window.addEventListener("resize",function(){clearTimeout(b),b=setTimeout(a,300)},!1),a()}(window);

        window.onload = function(){
            mui('.hot').scroll({
                scrollX: true,
                scrollY: false,
                indicators: false, //是否显示滚动条
                deceleration: 0.0005 //flick 减速系数，系数越大，滚动速度越慢，滚动距离越小，默认值0.0006
            });
        }
        mui.init({
            pullRefresh: {
                container: '#pullrefresh'
            }
        });
        mui.ready(function() {

            document.querySelector('.mui-media').addEventListener('touchend',function(event){
                $('.mui-media').removeClass('mui-active');
            });
            document.querySelector('.mui-content').addEventListener('touchstart',function(event){
                document.querySelector('input').blur();
            });
            mui('#pullrefresh').scroll({
                scrollX: false,
                scrollY: true,
                indicators: false, //是否显示滚动条
                deceleration:0.0006, //阻尼系数,系数越小滑动越灵敏
                bounce: false //是否启用回弹
            });
            var slider = mui("#slider");
            slider.slider({
                interval: 3000
            });
            mui('body').on('tap','a',function(e){
                var record =  this.getAttribute('class');
                if(record=="add_shoppingcart" || record=="star") return;
                location.href = this.getAttribute('href');
            });
            mui('body').on('tap','.add_shoppingcart',function(){
                var record =  this.getAttribute('data-id');
                add_shoppingcart(record);
            });
            mui('body').on('tap','.star img',function(){
                var src = this.getAttribute('src');
                if(src ==  'public/images/icon_active.png'){
                    this.src =  'public/images/icon_star.png';
                }else{
                    this.src =  'public/images/icon_active.png';
                }
            });

//            Zepto('.mui-focusin input').focus();
//            var btn = document.getElementById("keywords");
//            btn.addEventListener("tap",function () {
//                console.log("tap event trigger");
//            });
//            mui.trigger(btn,'tap');
            function add_shoppingcart(record)
            {
                mui.ajax({
                    type: 'POST',
                    url: "shoppingcart_add.ajax.php",
                    data: 'record=' + record,
                    success: function(json) {
                        var jsondata = eval("("+json+")");
                        if (jsondata.code == 200) {
                            mui.toast(jsondata.msg);
                            Zepto('#shoppingcart_badge').html('<span class="mui-badge">'+jsondata.shoppingcart+'</span>');
                        }
                        else
                        {
                            mui.toast(jsondata.msg);
                        }
                    }
                });
            }
            //        时间开
            var timer=null;
            var starttime1 = $("#begindate").val();
            var endtime1 = $("#enddate").val();
            $(function(){
                getTimer();
                timer=window.setInterval(getTimer,1000);/*设置不间断定时器执行getTimer函数*/
            })

            function getTimer(){
                var starttime2=starttime1.slice(0,4)+'/'+starttime1.slice(5,7)+'/'+starttime1.slice(8);
                var starttime=new Date(starttime2);  /*定义开始时间*/
                var endtime2=endtime1.slice(0,4)+'/'+endtime1.slice(5,7)+'/'+endtime1.slice(8);
                var endtime=new Date(endtime2);
                var nowtime=new Date();/*获取当前时间*/
                var cha;
                if(starttime-nowtime>0){
                    cha=starttime.getTime()-nowtime.getTime();/*得到距离开始的时间*/
                    $("#activity_before").css("display","block");
                    $("#activity_during").css("display","none");
                    $("#activity_after").css("display","none");
                    $("#activity_time").css("display","block");
                    $(".rob_button_gre").css("display","none");
                }else if(nowtime<endtime){
                    cha=endtime.getTime()-nowtime.getTime();/*得到距离结束的时间*/
                    $("#activity_before").css("display","none");
                    $("#activity_during").css("display","block");
                    $("#activity_after").css("display","none");
                    $("#activity_time").css("display","block");
                    $(".rob_button_gre").css("display","none");
                }else{  /*活动结束*/
                    var activity = 0;
                    clearInterval(timer);
                    $("#activity_before").css("display","none");
                    $("#activity_during").css("display","none");
                    $("#activity_after").css("display","block");
                    $("#activity_time").css("display","none");
                    $(".rob_button_red").css("display","none");
                    $(".rob_button_gre").css("display","block");
    //                $(".rob_button").style.backgroundColor = "green"; //.backgroundColor = "red";
    //                 $("button").css("backgroundcolor","green"); //.backgroundColor = "red";

                }
                var day=Math.floor(cha/1000/60/60/24); /*划分出时分秒*/
    //              var hour=Math.floor(cha/1000/60/60%24);
                var hour=Math.floor(cha/1000/60/60);
                var minute=Math.floor(cha/1000/60%60);
                var  second=Math.floor(cha/1000%60);
                if (minute <= 9) minute = '0' + minute;
                if (second <= 9) second = '0' + second;
                if (hour <= 9) hour = '0' + hour;
                $(".day").html(day); /*写到页面中*/
                $(".hour").html(hour);
                $(".minute").html(minute);
                $(".second").html(second);
            }
    //        结束
        });
        {/literal}
    </script>
    <style>
        {literal}
        .hot-sale {
          width: 12rem;
      }
      .h-grid p .gray{
          font-size:10px;
      }
      form{
          float: left;
      }
        /*秒杀头部提示第一版*/
      /*.activity_header{*/
          /*padding:0.1rem;*/
      /*;*/
          /*overflow: hidden;*/
          /*background-color: #fff;*/
      /*}*/
      /*.activity_header>span{*/
          /*float:left;*/
          /*color:#7d7e7e;*/
          /*font-size: 0.23rem;*/
      /*}*/
      /*.activity_header>a{*/
          /*float:right;*/
          /*color:#7d7e7e;*/
          /*font-size: 0.23rem;*/
      /*}*/
      /*.activity_header #activity_title{*/
          /*font-size: 0.28rem;*/
          /*color:#222;*/
          /*font-weight:bold;*/
      /*}*/
      /*.activity_header span{*/

      /*}*/
      /*.activity_header #activity_time a{*/
          /*padding: 0.02rem;*/
          /*border:1px solid #ddd;*/
          /*color:#e4393c;*/
          /*font-size: 0.22rem;*/
      /*}*/
        /*秒杀头部提示第二版-开始*/
        .activity_header{
        padding:0.1rem;
        ;
        overflow: hidden;
        background-color: #fff;
        }
        .activity_header>span>img{
            display:block;
            width:0.4rem;
            height:auto;
        }
        .activity_header>a>img{
            display:block;
            width:0.38rem;
            height:auto;
        }
        .activity_header>span{
        float:left;
        color:#7d7e7e;
        font-size: 0.23rem;
        }
        .activity_header>a{
        float:right;
        color:#e4393c;
        font-size: 0.23rem;
        }
        .activity_header>a>span>img{
            display:inline-block;
            width:0.34rem;
            height:auto;
            vertical-align: middle;
        }
        .activity_header #activity_title{
        font-size: 0.28rem;
        color:#e4393c;
        font-weight:bold;
        }
        .activity_header #activity_during{
            color:#000;
            font-size: 0.23rem;
        }
        .activity_header #activity_time{
            width:auto !important;
        }
        .activity_header #activity_time a{
            padding: 0.01rem;
            background-color: #000000;
            color:#fff;
            font-size: 0.2rem;
            border-radius: 3px;
            border:1px solid #000;
        }
        /*秒杀头部提示第二版-结束*/
      .recommend{
          background-color: #fff;
          width:100%;
          /*height:2.5rem;*/
          padding: 0.1rem;
          overflow: hidden;
      }
      .recommend-tegong{
          float: left;
          width: 50%;
          /*height:2.5rem;*/
          padding-right: 0.05rem;
      }
      .recommend-tegong img,.recommend-baokuan img{
          display: block;
          width:100%;
          height:auto;
      }
      .recommend-baokuan{
          float:right;
          width: 50%;
          /*height:2.5rem;*/
          padding-left: 0.05rem;
      }
        {/literal}
    </style>
</head>
<body>
<div class="mui-off-canvas-wrap  mui-draggable">
    <!-- 主页面容器 -->
    <div class="mui-inner-wrap">
        <!-- 菜单容器 -->
        <aside class="mui-off-canvas-left" id="offCanvasSide">
            <style>
                <!--
                .user-info .mui-ellipsis .iconfont {ldelim}width:18px;color: #fff; {rdelim}
                -->
            </style>
            <div class="mui-scroll-wrapper">
                <div class="mui-scroll">
                    <!-- 菜单具体展示内容 -->
                    <div class="user-info">
                        {if $profile_info.profileid neq 'anonymous'}
                            {if $profile_info.givenname neq ''}
                                <a href="javascript:;">
                                    <img class="mui-media-object mui-pull-left" src="{$profile_info.headimgurl}">
                                    <div class="mui-media-body">
                                        {$profile_info.givenname}，您好！
                                        <p class='mui-ellipsis' >等级：{include file='profilerank.tpl'}</p>

                                    </div>
                                </a>
                            {else}
                                <a href="javascript:;">
                                    <img class="mui-media-object mui-pull-left" src="{if $supplier_info.logo neq ''}{$supplier_info.logo}{else}images/logo.png{/if}">
                                    <div class="mui-media-body">
                                        尊敬的客人，您好！<br>
                                        <p class='mui-ellipsis'>关注之后内容更精彩!</p>
                                    </div>
                                </a>
                            {/if}

                        {else}
                            <a href="javascript:;">
                                <img class="mui-media-object mui-pull-left" src="{if $businesse_info.logo neq ''}{$businesse_info.logo}{else}images/logo.png{/if}">
                                <div class="mui-media-body">
                                    {$businesse_info.businessename}
                                    <p class='mui-ellipsis'>注册之后内容更精彩!</p>
                                </div>
                            </a>
                            <p>{$businesse_info.share_description}</p>
                            <p style="text-align: center;">
                                <a href="login.php" class="mui-btn mui-btn-outlined mui-btn-primary">登陆 </a>
                                <a href="register.php" class="mui-btn mui-btn-outlined mui-btn-primary">注册 </a>
                            </p>
                        {/if}
                    </div>
                    <ul class="mui-table-view mui-table-view-chevron mui-table-view-inverted">
                        <li class="mui-table-view-cell">
                            <a href="index.php" class="mui-navigate-right mui-ellipsis"><span class="mui-icon iconfont icon-mainpage"></span> 店铺首页 </a>
                        </li>
                        <!--<li class="mui-table-view-cell">
                            <a href="usercenter.php" class="mui-navigate-right mui-ellipsis">
                                <span class="mui-icon iconfont icon-gerenzhongxin"></span> 会员中心
                                <span class="left-desc"></span>
                            </a>
                        </li>-->
                        {assign var="badges" value=$share_info.badges}

                        <li class="mui-table-view-cell">
                            <a href="orders_receipt.php" class="mui-navigate-right mui-ellipsis">
                                <span class="mui-icon iconfont icon-daichulidingdan"></span> 我的待处理订单{if $badges.new_order eq 'yes'}<span style="font-size: 20px;padding: 1px 3px;" class="mui-badge mui-badge-danger iconfont icon-newbadge"></span>{/if}
                                <span class="left-desc"></span>
                            </a>
                        </li>
                        <li class="mui-table-view-cell">
                            <a href="orders_payment.php" class="mui-navigate-right mui-ellipsis">
                                <span class="mui-icon iconfont icon-dingdan"></span> 全部已付款订单
                                <span class="left-desc"></span>
                            </a>
                        </li>
                        {if $supplier_info.allowtakecash eq '1'}
                            <li class="mui-table-view-cell">
                                <a href="takecashs.php" class="mui-navigate-right mui-ellipsis">
                                    <span class="mui-icon iconfont icon-money"></span> 提现申请
                                    <span class="left-desc"></span>
                                </a>
                            </li>
                        {/if}
                        <li class="mui-table-view-cell">
                            <a href="mycollections.php" class="mui-navigate-right mui-ellipsis">
                                <span class="mui-icon iconfont icon-shoucang"></span> 我的收藏
                                <span class="left-desc"></span>
                            </a>
                        </li>
                        {if $supplier_info.showfubisi eq '0'}
                            <li class="mui-table-view-cell">
                                <a href="fubusi.php" class="mui-navigate-right mui-ellipsis">
                                    <span class="mui-icon iconfont icon-fubushi"></span> 福布斯榜
                                    <span class="left-desc"></span>
                                </a>
                            </li>
                        {/if}
                        <li class="mui-table-view-cell">
                            <a href="contactus.php" class="mui-navigate-right mui-ellipsis">
                                <span class="mui-icon iconfont icon-lianxiwomen"></span> 联系我们
                                <span class="left-desc"></span>
                            </a>
                        </li>
                        {if $sysinfo.http_user_agent eq 'tezan'}
                            {assign var="copyrights" value=$supplier_info.copyrights}
                            <script type="text/javascript" charset="utf-8" src="/public/js/cordova.js"></script>
                            <li class="mui-table-view-cell">
                                <a id="back_tezan" class="mui-navigate-right mui-ellipsis">
                                    <span class="mui-icon iconfont icon-logo"></span> 返回{$copyrights.trademark}
                                    <span class="left-desc"></span>
                                </a>
                            </li>
                            <script type="text/javascript">
                                {literal}
                                mui.ready(function() {
                                    document.getElementById('back_tezan').addEventListener('tap', function() {
                                        Cordova.exec(null, null, "PhoneGapPlugin", "PluginFunction", [{"type":"historyback"}]);
                                    });
                                });
                                {/literal}
                            </script>
                        {/if}
                    </ul>
                </div>
            </div>
        </aside>
        <!-- 主页面标题 -->
        <header class="mui-bar mui-bar-nav mui-row">
            <a class="mui-icon mui-action-menu mui-icon-bars mui-pull-left" href="#offCanvasSide"></a>
            <form action="search.php" onSubmit="return searchgo()">
                <div class="mui-input-row mui-search">
                        <input id="keywords" name="keywords" type="search" class="mui-input-clear" placeholder="">
                        {*<input type="search" class="mui-input-clear" placeholder="">*}
                </div>
            </form>
            <a class="mui-pull-right message" href="webim.php">
                <span class="mui-icon mui-icon-chat"></span>
                <br>消息
            </a>
        </header>
        <!-- 底部navbar -->
        {include file='footer.tpl'}
        <!-- 主页面内容容器 -->
        <div class="mui-content mui-scroll-wrapper">
            <div class="mui-scroll-wrapper" id="pullrefresh" style="padding-top:44px;">
                <div class="mui-scroll">
                    <!-- 轮播 -->
                    <div id="slider" class="mui-slider" >
                        <div class="mui-slider-group mui-slider-loop">
                            <!-- 额外增加的一个节点(循环轮播：第一个节点是最后一张轮播) -->
                            <div class="mui-slider-item mui-slider-item-duplicate">
                                <a href="{$ads_date.lunbotu3.url}">
                                    <img src="{$ads_date.lunbotu3.image}">
                                </a>
                            </div>
                            <!-- 第一张 -->
                            <div class="mui-slider-item">
                                <a href="{$ads_date.lunbotu1.url}">
                                <img src="{$ads_date.lunbotu1.image}">
                                </a>
                            </div>
                            <!-- 第二张 -->

                            <!-- 第三张 -->
                            <div class="mui-slider-item">
                                <a href="{$ads_date.lunbotu2.url}">
                                    <img src="{$ads_date.lunbotu2.image}">
                                </a>
                            </div>
                            <!-- 第四张 -->
                            <div class="mui-slider-item">
                                <a href="{$ads_date.lunbotu3.url}">
                                    <img src="{$ads_date.lunbotu3.image}">
                                </a>
                            </div>
                            <!-- 额外增加的一个节点(循环轮播：最后一个节点是第一张轮播) -->
                            <div class="mui-slider-item mui-slider-item-duplicate">
                                <a href="{$ads_date.lunbotu1.url}">
                                    <img src="{$ads_date.lunbotu1.image}">
                                </a>
                            </div>
                        </div>
                        <div class="mui-slider-indicator">
                            <div class="mui-indicator mui-active"></div>
                            <div class="mui-indicator"></div>

                            <div class="mui-indicator"></div>
                        </div>
                    </div>
                    <!-- 图片 -->
                    <ul class="mui-table-view mui-grid-view mui-grid-9">
                        <li class="mui-table-view-cell mui-media mui-col-xs-3">
                            <a href="{$ads_date.tubiao1.url}">
                                <img src="{$ads_date.tubiao1.image}" alt="">
                                <span><br>食品粮油</span>
                            </a>
                        </li>
                        <li class="mui-table-view-cell mui-media mui-col-xs-3">
                            <a href="{$ads_date.tubiao2.url}">
                                <img src="{$ads_date.tubiao2.image}" alt="">
                                <span><br>个护清洁</span>
                            </a>
                        </li>
                        <li class="mui-table-view-cell mui-media mui-col-xs-3">
                            <a href="{$ads_date.tubiao3.url}">
                                <img src="{$ads_date.tubiao3.image}" alt="">
                                <span><br>母婴用品</span>
                            </a>
                        </li>
                        <li class="mui-table-view-cell mui-media mui-col-xs-3">
                            <a href="{$ads_date.tubiao4.url}">
                                <img src="{$ads_date.tubiao4.image}" alt="">
                                <span><br>家居日用</span>
                            </a>
                        </li>
                        <li class="mui-table-view-cell mui-media mui-col-xs-3">
                            <!--<a href="search.php?categoryid=202174">-->
                            <a href="{$ads_date.tubiao5.url}">
                                <img src="{$ads_date.tubiao5.image}" alt="">
                                <span><br>清凉采购</span>
                            </a>
                        </li>
                        <li class="mui-table-view-cell mui-media mui-col-xs-3">
                            <a href="{$ads_date.tubiao6.url}">
                                <img src="{$ads_date.tubiao6.image}" alt="">
                                <span><br>领券中心</span>
                            </a>
                        </li>
                        <li class="mui-table-view-cell mui-media mui-col-xs-3">
                            <a href="{$ads_date.tubiao7.url}">
                                <img src="{$ads_date.tubiao7.image}" alt="">
                                <span><br>惠折扣</span>
                            </a>
                        </li>
                        <li class="mui-table-view-cell mui-media mui-col-xs-3">
                            <!--<a href="index.php?module=Mall_SalesActivitys&action=EditView&record=410623">-->
                            <a href="{$ads_date.tubiao8.url}">
                                <img src="{$ads_date.tubiao8.image}" alt="">
                                <span><br>劳保采购</span>
                            </a>
                        </li>
                    </ul>
                    <!--惠民推荐-->
                    
                    <!-- 特卖 -->
                    <div class="warp">
                        <div class="w-title">
                            <img src="public/images/icon_Sale.png" alt="">
                            <span>主题特卖</span>
                        </div>
                        <a href="{$ads_date.zhutitemai1.url}"><img class="banner" src="{$ads_date.zhutitemai1.image}" alt=""></a>
                        <div class="hot" id="tph_hot">
                            <div class="hot-sale clear" id="tph_bar"  style="width:14rem;">

                                    <div class="h-grid">
                                            <a href="{$ads_date.zhutitemaishangpin11.url}">
                                            <img src="{$ads_date.zhutitemaishangpin11.productlogo}" alt=""></a>
                                        <p>{$ads_date.zhutitemaishangpin11.productname}</p>
                                        <p class="mui-text-center" style="padding-right: 12px;">
                                            <span class="red" style="font-size:1.3em;color: #fb0000;display:block;">￥{$ads_date.zhutitemaishangpin11.promotionalprice}</span>
                                            <s class="gray" style="font-size:1.0em;display:block;margin-top: -5px;">￥{$ads_date.zhutitemaishangpin11.shop_price}</s>
                                        </p>
                                    </div>
                                    <div class="h-grid">
                                            <a href="{$ads_date.zhutitemaishangpin12.url}">
                                            <img src="{$ads_date.zhutitemaishangpin12.productlogo}" alt=""></a>
                                        <p>{$ads_date.zhutitemaishangpin12.productname}</p>
                                        <p class="mui-text-center" style="padding-right: 12px;">
                                            <span class="red" style="font-size:1.3em;color: #fb0000;display:block;">￥{$ads_date.zhutitemaishangpin12.promotionalprice}</span>
                                            <s class="gray" style="font-size:1.0em;display:block;margin-top: -5px;">￥{$ads_date.zhutitemaishangpin12.shop_price}</s>
                                        </p>
                                    </div>
                                    <div class="h-grid">
                                            <a href="{$ads_date.zhutitemaishangpin13.url}">
                                            <img src="{$ads_date.zhutitemaishangpin13.productlogo}" alt=""></a>
                                        <p>{$ads_date.zhutitemaishangpin13.productname}</p>
                                        <p class="mui-text-center" style="padding-right: 12px;">
                                            <span class="red" style="font-size:1.3em;color: #fb0000;display:block;">￥{$ads_date.zhutitemaishangpin13.promotionalprice}</span>
                                            <s class="gray" style="font-size:1.0em;display:block;margin-top: -5px;">￥{$ads_date.zhutitemaishangpin13.shop_price}</s>
                                        </p>
                                    </div>
                                    <div class="h-grid">
                                            <a href="{$ads_date.zhutitemaishangpin14.url}">
                                            <img src="{$ads_date.zhutitemaishangpin14.productlogo}" alt=""></a>
                                        <p>{$ads_date.zhutitemaishangpin14.productname}</p>
                                        <p class="mui-text-center" style="padding-right: 12px;">
                                            <span class="red" style="font-size:1.3em;color: #fb0000;display:block;">￥{$ads_date.zhutitemaishangpin14.promotionalprice}</span>
                                            <s class="gray" style="font-size:1.0em;display:block;margin-top: -5px;">￥{$ads_date.zhutitemaishangpin14.shop_price}</s>
                                        </p>
                                    </div>
                                    <div class="h-grid">
                                            <a href="{$ads_date.zhutitemaishangpin15.url}">
                                            <img src="{$ads_date.zhutitemaishangpin15.productlogo}" alt=""></a>
                                        <p>{$ads_date.zhutitemaishangpin15.productname}</p>
                                        <p class="mui-text-center" style="padding-right: 12px;">
                                            <span class="red" style="font-size:1.3em;color: #fb0000;display:block;">￥{$ads_date.zhutitemaishangpin15.promotionalprice}</span>
                                            <s class="gray" style="font-size:1.0em;display:block;margin-top: -5px;">￥{$ads_date.zhutitemaishangpin15.shop_price}</s>
                                        </p>
                                    </div>
                                    <div class="h-grid">
                                            <a href="{$ads_date.zhutitemaishangpin16.url}">
                                            <img src="{$ads_date.zhutitemaishangpin16.productlogo}" alt=""></a>
                                        <p>{$ads_date.zhutitemaishangpin16.productname}</p>
                                        <p class="mui-text-center" style="padding-right: 12px;">
                                            <span class="red" style="font-size:1.3em;color: #fb0000;display:block;">￥{$ads_date.zhutitemaishangpin16.promotionalprice}</span>
                                            <s class="gray" style="font-size:1.0em;display:block;margin-top: -5px;">￥{$ads_date.zhutitemaishangpin16.shop_price}</s>
                                        </p>
                                    </div>

                                <div class="h-grid">
                                    <a href="{$ads_date.zhutitemai1.url}" class="more-icon">
                                        <img src="public/images/more_wash.jpg" alt="">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <a href="{$ads_date.zhutitemai2.url}"><img class="banner" src="{$ads_date.zhutitemai2.image}" alt=""></a>
                        <div class="hot" id="tph_hot1">
                            <div class="hot-sale clear" id="tph_bar1" style="width:14rem;">

                            <div class="h-grid">
                                    <a href="{$ads_date.zhutitemaishangpin21.url}">
                                    <img src="{$ads_date.zhutitemaishangpin21.productlogo}" alt=""></a>
                                <p>{$ads_date.zhutitemaishangpin21.productname}</p>
                                <p class="mui-text-center" style="padding-right: 12px;">
                                    <span class="red" style="font-size:1.3em;color: #fb0000;display:block;">￥{$ads_date.zhutitemaishangpin21.promotionalprice}</span>
                                    <s class="gray" style="font-size:1.0em;display:block;margin-top: -5px;">￥{$ads_date.zhutitemaishangpin21.shop_price}</s>
                                </p>
                            </div>
                            <div class="h-grid">
                                    <a href="{$ads_date.zhutitemaishangpin22.url}">
                                    <img src="{$ads_date.zhutitemaishangpin22.productlogo}" alt=""></a>
                                <p>{$ads_date.zhutitemaishangpin22.productname}</p>
                                <p class="mui-text-center" style="padding-right: 12px;">
                                    <span class="red" style="font-size:1.3em;color: #fb0000;display:block;">￥{$ads_date.zhutitemaishangpin22.promotionalprice}</span>
                                    <s class="gray" style="font-size:1.0em;display:block;margin-top: -5px;">￥{$ads_date.zhutitemaishangpin22.shop_price}</s>
                                </p>
                            </div>
                            <div class="h-grid">
                                    <a href="{$ads_date.zhutitemaishangpin23.url}">
                                    <img src="{$ads_date.zhutitemaishangpin23.productlogo}" alt=""></a>
                                <p>{$ads_date.zhutitemaishangpin23.productname}</p>
                                <p class="mui-text-center" style="padding-right: 12px;">
                                    <span class="red" style="font-size:1.3em;color: #fb0000;display:block;">￥{$ads_date.zhutitemaishangpin23.promotionalprice}</span>
                                    <s class="gray" style="font-size:1.0em;display:block;margin-top: -5px;">￥{$ads_date.zhutitemaishangpin23.shop_price}</s>
                                </p>
                            </div>
                            <div class="h-grid">
                                    <a href="{$ads_date.zhutitemaishangpin24.url}">
                                    <img src="{$ads_date.zhutitemaishangpin24.productlogo}" alt=""></a>
                                <p>{$ads_date.zhutitemaishangpin24.productname}</p>
                                <p class="mui-text-center" style="padding-right: 12px;">
                                    <span class="red" style="font-size:1.3em;color: #fb0000;display:block;">￥{$ads_date.zhutitemaishangpin24.promotionalprice}</span>
                                    <s class="gray" style="font-size:1.0em;display:block;margin-top: -5px;">￥{$ads_date.zhutitemaishangpin24.shop_price}</s>
                                </p>
                            </div>
                            <div class="h-grid">
                                    <a href="{$ads_date.zhutitemaishangpin25.url}">
                                    <img src="{$ads_date.zhutitemaishangpin25.productlogo}" alt=""></a>
                                <p>{$ads_date.zhutitemaishangpin25.productname}</p>
                                <p class="mui-text-center" style="padding-right: 12px;">
                                    <span class="red" style="font-size:1.3em;color: #fb0000;display:block;">￥{$ads_date.zhutitemaishangpin25.promotionalprice}</span>
                                    <s class="gray" style="font-size:1.0em;display:block;margin-top: -5px;">￥{$ads_date.zhutitemaishangpin25.shop_price}</s>
                                </p>
                            </div>
                            <div class="h-grid">
                                    <a href="{$ads_date.zhutitemaishangpin26.url}">
                                    <img src="{$ads_date.zhutitemaishangpin26.productlogo}" alt=""></a>
                                <p>{$ads_date.zhutitemaishangpin26.productname}</p>
                                <p class="mui-text-center" style="padding-right: 12px;">
                                    <span class="red" style="font-size:1.3em;color: #fb0000;display:block;">￥{$ads_date.zhutitemaishangpin26.promotionalprice}</span>
                                    <s class="gray" style="font-size:1.0em;display:block;margin-top: -5px;">￥{$ads_date.zhutitemaishangpin26.shop_price}</s>
                                </p>
                            </div>

                                <div class="h-grid">
                                    <a href="{$ads_date.zhutitemai2.url}" class="more-icon"><img src="public/images/more_wash.jpg" alt=""></a>
                                </div>
                            </div>
                        </div>
                        <!--五粮液-->
                        <a href="{$ads_date.zhutitemai3.url}"><img class="banner" src="{$ads_date.zhutitemai3.image}" alt=""></a>
                        <div class="hot" id="tph_hot2">
                            <div class="hot-sale clear" id="tph_bar2"  style="width:14rem;">

                            <div class="h-grid">
                                    <a href="{$ads_date.zhutitemaishangpin31.url}">
                                    <img src="{$ads_date.zhutitemaishangpin31.productlogo}" alt=""></a>
                                <p>{$ads_date.zhutitemaishangpin31.productname}</p>
                                <p class="mui-text-center" style="padding-right: 12px;">
                                    <span class="red" style="font-size:1.3em;color: #fb0000;display:block;">￥{$ads_date.zhutitemaishangpin31.promotionalprice}</span>
                                    <s class="gray" style="font-size:1.0em;display:block;margin-top: -5px;">￥{$ads_date.zhutitemaishangpin31.shop_price}</s>
                                </p>
                            </div>
                            <div class="h-grid">
                                    <a href="{$ads_date.zhutitemaishangpin32.url}">
                                    <img src="{$ads_date.zhutitemaishangpin32.productlogo}" alt=""></a>
                                <p>{$ads_date.zhutitemaishangpin32.productname}</p>
                                <p class="mui-text-center" style="padding-right: 12px;">
                                    <span class="red" style="font-size:1.3em;color: #fb0000;display:block;">￥{$ads_date.zhutitemaishangpin32.promotionalprice}</span>
                                    <s class="gray" style="font-size:1.0em;display:block;margin-top: -5px;">￥{$ads_date.zhutitemaishangpin32.shop_price}</s>
                                </p>
                            </div>
                            <div class="h-grid">
                                    <a href="{$ads_date.zhutitemaishangpin33.url}">
                                    <img src="{$ads_date.zhutitemaishangpin33.productlogo}" alt=""></a>
                                <p>{$ads_date.zhutitemaishangpin33.productname}</p>
                                <p class="mui-text-center" style="padding-right: 12px;">
                                    <span class="red" style="font-size:1.3em;color: #fb0000;display:block;">￥{$ads_date.zhutitemaishangpin33.promotionalprice}</span>
                                    <s class="gray" style="font-size:1.0em;display:block;margin-top: -5px;">￥{$ads_date.zhutitemaishangpin33.shop_price}</s>
                                </p>
                            </div>
                            <div class="h-grid">
                                    <a href="{$ads_date.zhutitemaishangpin34.url}">
                                    <img src="{$ads_date.zhutitemaishangpin34.productlogo}" alt=""></a>
                                <p>{$ads_date.zhutitemaishangpin34.productname}</p>
                                <p class="mui-text-center" style="padding-right: 12px;">
                                    <span class="red" style="font-size:1.3em;color: #fb0000;display:block;">￥{$ads_date.zhutitemaishangpin34.promotionalprice}</span>
                                    <s class="gray" style="font-size:1.0em;display:block;margin-top: -5px;">￥{$ads_date.zhutitemaishangpin34.shop_price}</s>
                                </p>
                            </div>
                            <div class="h-grid">
                                    <a href="{$ads_date.zhutitemaishangpin35.url}">
                                    <img src="{$ads_date.zhutitemaishangpin35.productlogo}" alt=""></a>
                                <p>{$ads_date.zhutitemaishangpin35.productname}</p>
                                <p class="mui-text-center" style="padding-right: 12px;">
                                    <span class="red" style="font-size:1.3em;color: #fb0000;display:block;">￥{$ads_date.zhutitemaishangpin35.promotionalprice}</span>
                                    <s class="gray" style="font-size:1.0em;display:block;margin-top: -5px;">￥{$ads_date.zhutitemaishangpin35.shop_price}</s>
                                </p>
                            </div>
                            <div class="h-grid">
                                    <a href="{$ads_date.zhutitemaishangpin36.url}">
                                    <img src="{$ads_date.zhutitemaishangpin36.productlogo}" alt=""></a>
                                <p>{$ads_date.zhutitemaishangpin36.productname}</p>
                                <p class="mui-text-center" style="padding-right: 12px;">
                                    <span class="red" style="font-size:1.3em;color: #fb0000;display:block;">￥{$ads_date.zhutitemaishangpin36.promotionalprice}</span>
                                    <s class="gray" style="font-size:1.0em;display:block;margin-top: -5px;">￥{$ads_date.zhutitemaishangpin36.shop_price}</s>
                                </p>
                            </div>

                                <div class="h-grid">
                                    <a href="{$ads_date.zhutitemai3.url}" class="more-icon">
                                        <img src="public/images/more_wash.jpg" alt="">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 楼层 -->
                    <div class="warp">
                        <div class="w-title">
                            <img src="public/images/icon_Sale.png" alt="">
                            <span>食品粮油</span>
                            <a class="more" href="{$ads_date.louceng1.url}">查看更多<span class="mui-icon mui-icon-arrowright"></span></a>
                        </div>
                        <a href="{$ads_date.louceng1.url}"><img class="banner" src="{$ads_date.louceng1.image}" alt=""></a>
                        <div class="goods clear">

                        <div class="goods-container">
                            <a href="{$ads_date.loucengshangpin11.url}"><img src="{$ads_date.loucengshangpin11.productlogo}" alt=""></a>
                            <p>{$ads_date.loucengshangpin11.productname}</p>
                            <div class="goods-bottom">
                                <span class="mui-pull-left red">￥{$ads_date.loucengshangpin11.shop_price}</span>
                                <div class="mui-pull-right icon">
                                    {*<a class="star">*}
                                        {*<img src="public/images/icon_star.png" alt=""></a>*}
                                    <a class="add_shoppingcart" data-id="{$ads_date.loucengshangpin11.productid}">
                                        <img src="public/images/icon_cart.png" alt=""></a>
                                </div>
                            </div>
                        </div>
                        <div class="goods-container">
                            <a href="{$ads_date.loucengshangpin12.url}"><img src="{$ads_date.loucengshangpin12.productlogo}" alt=""></a>
                            <p>{$ads_date.loucengshangpin12.productname}</p>
                            <div class="goods-bottom">
                                <span class="mui-pull-left red">￥{$ads_date.loucengshangpin12.shop_price}</span>
                                <div class="mui-pull-right icon">
                                    {*<a class="star">*}
                                        {*<img src="public/images/icon_star.png" alt=""></a>*}
                                    <a class="add_shoppingcart" data-id="{$ads_date.loucengshangpin12.productid}">
                                        <img src="public/images/icon_cart.png" alt=""></a>
                                </div>
                            </div>
                        </div>
                        <div class="goods-container">
                            <a href="{$ads_date.loucengshangpin13.url}"><img src="{$ads_date.loucengshangpin13.productlogo}" alt=""></a>
                            <p>{$ads_date.loucengshangpin13.productname}</p>
                            <div class="goods-bottom">
                                <span class="mui-pull-left red">￥{$ads_date.loucengshangpin13.shop_price}</span>
                                <div class="mui-pull-right icon">
                                    {*<a class="star">*}
                                        {*<img src="public/images/icon_star.png" alt=""></a>*}
                                    <a class="add_shoppingcart" data-id="{$ads_date.loucengshangpin13.productid}">
                                        <img src="public/images/icon_cart.png" alt=""></a>
                                </div>
                            </div>
                        </div>
                        <div class="goods-container">
                            <a href="{$ads_date.loucengshangpin14.url}"><img src="{$ads_date.loucengshangpin14.productlogo}" alt=""></a>
                            <p>{$ads_date.loucengshangpin14.productname}</p>
                            <div class="goods-bottom">
                                <span class="mui-pull-left red">￥{$ads_date.loucengshangpin14.shop_price}</span>
                                <div class="mui-pull-right icon">
                                    {*<a class="star">*}
                                        {*<img src="public/images/icon_star.png" alt=""></a>*}
                                    <a class="add_shoppingcart" data-id="{$ads_date.loucengshangpin14.productid}">
                                        <img src="public/images/icon_cart.png" alt=""></a>
                                </div>
                            </div>
                        </div>

                        </div>
                    </div>

                    <div class="warp">
                        <div class="w-title">
                            <img src="public/images/icon_activity_cleaning.png" alt="">
                            <span>个护清洁</span>
                            <a class="more" href="{$ads_date.louceng2.url}">查看更多<span class="mui-icon mui-icon-arrowright"></span></a>
                        </div>
                        <a href="{$ads_date.louceng2.url}"><img class="banner" src="{$ads_date.louceng2.image}" alt=""></a>
                        <div class="goods clear">

                        <div class="goods-container">
                            <a href="{$ads_date.loucengshangpin21.url}"><img src="{$ads_date.loucengshangpin21.productlogo}" alt=""></a>
                            <p>{$ads_date.loucengshangpin21.productname}</p>
                            <div class="goods-bottom">
                                <span class="mui-pull-left red">￥{$ads_date.loucengshangpin21.shop_price}</span>
                                <div class="mui-pull-right icon">
                                    {*<a class="star">*}
                                        {*<img src="public/images/icon_star.png" alt=""></a>*}
                                    <a class="add_shoppingcart" data-id="{$ads_date.loucengshangpin21.productid}">
                                        <img src="public/images/icon_cart.png" alt=""></a>
                                </div>
                            </div>
                        </div>
                        <div class="goods-container">
                            <a href="{$ads_date.loucengshangpin22.url}"><img src="{$ads_date.loucengshangpin22.productlogo}" alt=""></a>
                            <p>{$ads_date.loucengshangpin22.productname}</p>
                            <div class="goods-bottom">
                                <span class="mui-pull-left red">￥{$ads_date.loucengshangpin22.shop_price}</span>
                                <div class="mui-pull-right icon">
                                    {*<a class="star">*}
                                        {*<img src="public/images/icon_star.png" alt=""></a>*}
                                    <a class="add_shoppingcart" data-id="{$ads_date.loucengshangpin22.productid}">
                                        <img src="public/images/icon_cart.png" alt=""></a>
                                </div>
                            </div>
                        </div>
                        <div class="goods-container">
                            <a href="{$ads_date.loucengshangpin23.url}"><img src="{$ads_date.loucengshangpin23.productlogo}" alt=""></a>
                            <p>{$ads_date.loucengshangpin23.productname}</p>
                            <div class="goods-bottom">
                                <span class="mui-pull-left red">￥{$ads_date.loucengshangpin23.shop_price}</span>
                                <div class="mui-pull-right icon">
                                    {*<a class="star">*}
                                        {*<img src="public/images/icon_star.png" alt=""></a>*}
                                    <a class="add_shoppingcart" data-id="{$ads_date.loucengshangpin23.productid}">
                                        <img src="public/images/icon_cart.png" alt=""></a>
                                </div>
                            </div>
                        </div>
                        <div class="goods-container">
                            <a href="{$ads_date.loucengshangpin24.url}"><img src="{$ads_date.loucengshangpin24.productlogo}" alt=""></a>
                            <p>{$ads_date.loucengshangpin24.productname}</p>
                            <div class="goods-bottom">
                                <span class="mui-pull-left red">￥{$ads_date.loucengshangpin24.shop_price}</span>
                                <div class="mui-pull-right icon">
                                    {*<a class="star">*}
                                        {*<img src="public/images/icon_star.png" alt=""></a>*}
                                    <a class="add_shoppingcart" data-id="{$ads_date.loucengshangpin24.productid}">
                                        <img src="public/images/icon_cart.png" alt=""></a>
                                </div>
                            </div>
                        </div>

                        </div>
                    </div>

                    <div class="warp">
                        <div class="w-title">
                            <img src="public/images/icon_drinks.png" alt="">
                            <span>酒水饮料</span>
                            <a class="more" href="{$ads_date.louceng3.url}">查看更多<span class="mui-icon mui-icon-arrowright"></span></a>
                        </div>
                        <a href="{$ads_date.louceng3.url}"><img class="banner" src="{$ads_date.louceng3.image}" alt=""></a>
                        <div class="goods clear">

                        <div class="goods-container">
                            <a href="{$ads_date.loucengshangpin31.url}"><img src="{$ads_date.loucengshangpin31.productlogo}" alt=""></a>
                            <p>{$ads_date.loucengshangpin31.productname}</p>
                            <div class="goods-bottom">
                                <span class="mui-pull-left red">￥{$ads_date.loucengshangpin31.shop_price}</span>
                                <div class="mui-pull-right icon">
                                    {*<a class="star">*}
                                        {*<img src="public/images/icon_star.png" alt=""></a>*}
                                    <a class="add_shoppingcart" data-id="{$ads_date.loucengshangpin31.productid}">
                                        <img src="public/images/icon_cart.png" alt=""></a>
                                </div>
                            </div>
                        </div>
                        <div class="goods-container">
                            <a href="{$ads_date.loucengshangpin32.url}"><img src="{$ads_date.loucengshangpin32.productlogo}" alt=""></a>
                            <p>{$ads_date.loucengshangpin32.productname}</p>
                            <div class="goods-bottom">
                                <span class="mui-pull-left red">￥{$ads_date.loucengshangpin32.shop_price}</span>
                                <div class="mui-pull-right icon">
                                    {*<a class="star">*}
                                        {*<img src="public/images/icon_star.png" alt=""></a>*}
                                    <a class="add_shoppingcart" data-id="{$ads_date.loucengshangpin32.productid}">
                                        <img src="public/images/icon_cart.png" alt=""></a>
                                </div>
                            </div>
                        </div>
                        <div class="goods-container">
                            <a href="{$ads_date.loucengshangpin33.url}"><img src="{$ads_date.loucengshangpin33.productlogo}" alt=""></a>
                            <p>{$ads_date.loucengshangpin33.productname}</p>
                            <div class="goods-bottom">
                                <span class="mui-pull-left red">￥{$ads_date.loucengshangpin33.shop_price}</span>
                                <div class="mui-pull-right icon">
                                    {*<a class="star">*}
                                        {*<img src="public/images/icon_star.png" alt=""></a>*}
                                    <a class="add_shoppingcart" data-id="{$ads_date.loucengshangpin33.productid}">
                                        <img src="public/images/icon_cart.png" alt=""></a>
                                </div>
                            </div>
                        </div>
                        <div class="goods-container">
                            <a href="{$ads_date.loucengshangpin34.url}"><img src="{$ads_date.loucengshangpin34.productlogo}" alt=""></a>
                            <p>{$ads_date.loucengshangpin34.productname}</p>
                            <div class="goods-bottom">
                                <span class="mui-pull-left red">￥{$ads_date.loucengshangpin34.shop_price}</span>
                                <div class="mui-pull-right icon">
                                    {*<a class="star">*}
                                        {*<img src="public/images/icon_star.png" alt=""></a>*}
                                    <a class="add_shoppingcart" data-id="{$ads_date.loucengshangpin34.productid}">
                                        <img src="public/images/icon_cart.png" alt=""></a>
                                </div>
                            </div>
                        </div>

                        </div>
                    </div>
                    <div class="warp">
                        <div class="w-title">
                            <img src="public/images/icon_mother.png" alt="">
                            <span>母婴用品</span>
                            <a class="more" href="{$ads_date.louceng4.url}">查看更多<span class="mui-icon mui-icon-arrowright"></span></a>
                        </div>
                        <a href="{$ads_date.louceng4.url}"><img class="banner" src="{$ads_date.louceng4.image}" alt=""></a>
                        <div class="goods clear">

                        <div class="goods-container">
                            <a href="{$ads_date.loucengshangpin41.url}"><img src="{$ads_date.loucengshangpin41.productlogo}" alt=""></a>
                            <p>{$ads_date.loucengshangpin41.productname}</p>
                            <div class="goods-bottom">
                                <span class="mui-pull-left red">￥{$ads_date.loucengshangpin41.shop_price}</span>
                                <div class="mui-pull-right icon">
                                    {*<a class="star">*}
                                        {*<img src="public/images/icon_star.png" alt=""></a>*}
                                    <a class="add_shoppingcart" data-id="{$ads_date.loucengshangpin41.productid}">
                                        <img src="public/images/icon_cart.png" alt=""></a>
                                </div>
                            </div>
                        </div>
                        <div class="goods-container">
                            <a href="{$ads_date.loucengshangpin42.url}"><img src="{$ads_date.loucengshangpin42.productlogo}" alt=""></a>
                            <p>{$ads_date.loucengshangpin42.productname}</p>
                            <div class="goods-bottom">
                                <span class="mui-pull-left red">￥{$ads_date.loucengshangpin42.shop_price}</span>
                                <div class="mui-pull-right icon">
                                    {*<a class="star">*}
                                        {*<img src="public/images/icon_star.png" alt=""></a>*}
                                    <a class="add_shoppingcart" data-id="{$ads_date.loucengshangpin42.productid}">
                                        <img src="public/images/icon_cart.png" alt=""></a>
                                </div>
                            </div>
                        </div>
                        <div class="goods-container">
                            <a href="{$ads_date.loucengshangpin43.url}"><img src="{$ads_date.loucengshangpin43.productlogo}" alt=""></a>
                            <p>{$ads_date.loucengshangpin43.productname}</p>
                            <div class="goods-bottom">
                                <span class="mui-pull-left red">￥{$ads_date.loucengshangpin43.shop_price}</span>
                                <div class="mui-pull-right icon">
                                    {*<a class="star">*}
                                        {*<img src="public/images/icon_star.png" alt=""></a>*}
                                    <a class="add_shoppingcart" data-id="{$ads_date.loucengshangpin43.productid}">
                                        <img src="public/images/icon_cart.png" alt=""></a>
                                </div>
                            </div>
                        </div>
                        <div class="goods-container">
                            <a href="{$ads_date.loucengshangpin44.url}"><img src="{$ads_date.loucengshangpin44.productlogo}" alt=""></a>
                            <p>{$ads_date.loucengshangpin44.productname}</p>
                            <div class="goods-bottom">
                                <span class="mui-pull-left red">￥{$ads_date.loucengshangpin44.shop_price}</span>
                                <div class="mui-pull-right icon">
                                    {*<a class="star">*}
                                        {*<img src="public/images/icon_star.png" alt=""></a>*}
                                    <a class="add_shoppingcart" data-id="{$ads_date.loucengshangpin44.productid}">
                                        <img src="public/images/icon_cart.png" alt=""></a>
                                </div>
                            </div>
                        </div>

                        </div>
                    </div>
                    <div class="h50"></div>
                </div>
            </div>
        </div>
    <div class="mui-off-canvas-backdrop"></div>
        {include file='weixin.tpl'}
</div>
</div>
</body>
</html>

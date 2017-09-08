<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>惠民商城 </title>
    <link href="public/css/mui.min.css" rel="stylesheet"/>
    <link href="public/css/common.css" rel="stylesheet"/>
    <link href="public/css/goods-list.css" rel="stylesheet"/>
    <link href="public/css/iconfont.css" rel="stylesheet" />
    <script src="public/js/zepto.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="public/js/mui.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="public/js/lazyload.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="public/js/utils.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" src="public/js/jweixin.js"></script>
    <script type="text/javascript" charset="utf-8">
        {literal}
        mui.init();
        window.onload = function(){
            mui('.mui-scroll-wrapper').scroll({
                deceleration: 0.0005 //flick 减速系数，系数越大，滚动速度越慢，滚动距离越小，默认值0.0006
            });

        }
        !function(){function a(){
            document.documentElement.style.fontSize=document.documentElement.clientWidth/6.4+"px";
            if(document.documentElement.clientWidth>=640)document.documentElement.style.fontSize='100px';}
            var b=null;window.addEventListener("resize",function(){clearTimeout(b),b=setTimeout(a,300)},!1),a()}(window);
        {/literal}
    </script>
    <style>
        {literal}
        .icon-tezan:before {
            content: "\e619";
        }
        .pop_mask{
            width:100%;
            height:100%;
            background: rgba(0,0,0,.5);
            position:absolute;
            z-index:100;
            display: none;
        }
        .pop_content{
            width:80%;
            position:absolute;
            right:0;
            top:0;
        }
        .pop_head{
            background: white;
            text-align:center;
            color:#434343;
            font-size:18px;
            line-height: 30px;
            font-family: '黑体';
        }
        .pop_main{
            background: #f3f3f3;
            overflow:hidden;
            padding-bottom:10px;
        }
        .pop_main p{
            margin:10px 0;
            text-indent:1em;
        }
        .pop_input{
            text-align:center;
            font-size:12px !important;
        }
        .pop_input input{
            width:30%;
            height:20px;
        }
        .pop_btn a{
            display: inline-block;
            width:50%;
            text-align:center;
            font-size:16px;
            line-height: 30px;
        }
        .pop_reset{
            background: white;
            color:#4f4f52;
        }
        .pop_sure{
            background: #f23030;
            float:right;
            color:white;
        }

        .time_limit{
            height:0.6rem;
            line-height:0.6rem;
            padding:0 0.2rem;
        }
        .time_limit p{
            color:#000100;
            font-size:0.28rem;
            float:left;
        }
        .time_limit span{
            font-size:0.24rem;
            color:#636466;
            float:right;
        }
        .time_limit a{
            color:white;
            background:#4b4a58;
            padding: 2px;
        }
        .goods_list_right button{
            float:right;
            margin-top:0.4rem;
            margin-right:0.1rem;
            width:2rem;
            background:#f15352;
            color:white;
        }
        .secKill_right{
            float:right;
            width:40%;
            background-color: #FFEAE9;
            padding:3px;
            height:100%;
            text-align: center;
            overflow: hidden;
        }
        .secKill_right div{
            color:#F2306F;
            font-weight:bold;
            font-size: 13px;
            word-spacing:4px;
            letter-spacing: 2px;
        }
        .secKill_right ul{
            margin:3px 0 0 5px;
            padding:0px;
            text-align: center;
            position: relative;
            left: 50%;
            float: left;
        }
        .secKill_right ul li{
            margin-right:4px;
            float: left;
            list-style:none;
            position: relative;
            left: -50%;
        }
        .secKill_right ul li span.time{
            display:inline-block;
            width:22px;
            height:22px;
            border-radius: 3px;
            background-color:#F32D8E;
            text-align: center;"
        }
        .secKill_right ul li span.time{
            display:inline-block;
            width:22px;
            height:22px;
            border-radius: 3px;
            background-color:#F32D8E;
            text-align: center;"
        }
        .secKill_right ul li span.separator{
            padding:3px;
        }
        .popup_bg{
            background: rgba(0,0,0,.5);
            position:absolute;
            width:100%;
            height:100%;
            top:0;
            left:0;
            z-index: 20;
        }
        .popup_content{
            background: white;
            width:70%;
            height:60%;
            position: absolute;
            left:50%;
            transform: translateX(-50%);
            top:20%;
        }
        .popup_content img{
            width:1rem;
            height:1rem;
            margin-top:1rem;
            margin-left:50%;
            transform: translateX(-50%);
        }
        .popup_content p{
            text-align:center;
        }
        .popup_content button{
            position: absolute;
            bottom:0.5rem;
            left:50%;
            transform: translateX(-50%);
        }
        .popup_btn_true{
            background: #f15352;
            color:white;
        }
        {/literal}
    </style>
</head>
<body>
<div class="pop_mask">
    <div class="pop_content" style="position: absolute;">
        <div class="pop_head">筛选</div>
        <form>
            <div class="pop_main">
                <p>价格区间:</p>
                <div class="pop_input">
                    <input type="number" onkeypress="return (/[\d]/.test(String.fromCharCode(event.keyCode)))" id="num1" name="" class="minprice"> — <input id="num2" type="number" name="" onkeypress="return (/[\d]/.test(String.fromCharCode(event.keyCode)))" class="maxprice">
                </div>
            </div>
            <div class="pop_btn">
                <a href="javascript:;" class="pop_reset">重置</a>
                <a href="javascript:;" class="pop_sure"  id="tijiao">确定</a>
                <input type="hidden" value="{$categoryid}" id="categoryid">
            </div>
        </form>
    </div>
</div>
<div class="mui-off-canvas-wrap mui-draggable">
    <!-- 主页面容器 -->
    <div class="mui-inner-wrap">
        <!-- 底部navbar -->
        {include file='footer.tpl'}
        <!-- 主页面内容容器 -->
        <div class="mui-content">
            <div class="mui-scroll-wrapper" id="pullrefresh">
                <div class="mui-scroll">
                    <!-- 搜索 -->
                    <div class="mui-input-row mui-search">
                        {*<input type="search" class="mui-input-clear" placeholder="搜索你喜欢的商品">*}
                        <form action="search.php" onSubmit="return searchgo()">
                            <div class="mui-table-view-cell" style="padding:0">
                                <div class="mui-input-row mui-search">
                                    <input id="keywords" name="keywords" type="search" class="mui-input-clear" value="{$keywords}" placeholder="搜索你喜欢的商品">
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- 筛选 -->
                    <input type="hidden" value="{$rob_list}" id="rob_list">
                    <div id="has_rob"  >
                        <div class="mui-table-view" style="text-align:center">
                            <img src="public/images/time_sales_pic.png" style="width:3rem;margin:auto">
                        </div>
                        <div class="mui-table-view time_limit" style="background:#f1f2f6">
                            <p class="rob_button_yel">活动马上就要开始了哦~-~</p>
                            <p class="rob_button_red">抢购中，先到先得哦~~</p>
                            <p class="rob_button_gre"> 期待下一期商品吧</p>
                            <input type="hidden" value="{$starttime}" id = "starttime" >
                            <input type="hidden" value="{$endtime}" id = "endtime" >
                            <span>
                              <span id="activity_time" style="display:none;">
                                     <a class="hour">01</a> : <a class="minute">58</a> : <a class="second">41</a>
                             </span>
                                <span>&nbsp;&nbsp;</span>
                                <span id="activity_before" style="display:none;">距开始</span>
                                <span id="activity_during" style="display:none;">距结束</span>
                                <span id="activity_after" style="display:none;">活动结束</span>
                             </span>
                        </div>
                    </div>

                    <!--<P><span>starttime1&nbsp;&nbsp;</span><span id="1"></span></P>-->
                    <!--<P><span>starttime&nbsp;&nbsp;</span><span id="2"></span></P>-->
                    <!--<P><span>endtime1&nbsp;&nbsp;</span><span id="3"></span></P>-->
                    <!--<P><span>endtime&nbsp;&nbsp;</span><span id="4"></span></P>-->
                    <!--<P><span>nowtime&nbsp;&nbsp;</span><span id="5"></span></P>-->

                    <div class="mui-row"  id="sortbar" style="position:relative;"  >
                        <div class="mui-col-xs-3 filter"  data-sort="desc" data-order="published">
                            默认
                        </div>
                        <div class="mui-col-xs-3 filter" data-sort="desc" data-order="price">
                            价格<span id="icon_price" style="display:none" class="icon-sort iconfont icon-sort-desc"></span>
                        </div>
                        <div class="mui-col-xs-3 filter" data-sort="desc" data-order="salevalue">
                            销量<span id="icon_salevalue" style="display:none" class="icon-sort iconfont icon-sort-desc">
                        </div>
                        <div class="mui-col-xs-3 filter my_praise" data-sort="desc" data-order="praise">
                            筛选<span id="icon_praise" style="display:none" class="icon-sort iconfont icon-sort-desc">
                        </div>
                    </div>

                    <input id="page"  type="hidden" value="1">
                    <input id="categoryid"  type="hidden" value="{$categoryid}">
                    <input id="keywords"  type="hidden" value="{$keywords}">
                    <input id="sort"  type="hidden" value="asc">
                    <input id="order"  type="hidden" value="published">
                    <input type="hidden"  value="{$begindate}" id="begindate">
                    <input type="hidden"  value="{$enddate}" id="enddate">
                    {*<ul class="mui-table-view list" >*}
                        {*{foreach  item=list_info from=$list_infos}*}
                            {*<li class="mui-table-view-cell mui-media">*}
                                {*<a href="detail.php?from=index&amp;productid={$list_info.productid}&salesactivityid={$salesactivityid}" id="aa">*}
                                    {*<div class="mui-media-body">*}
                                        {*<img id="product_item_502296" class="mui-media-object lazy img-responsive mui-pull-left" src="images/smkLoad.png" data-original="http://api.tezan.cn/storage/cropper/2017/July/0706/20170706063011894.jpg?width=768">*}
                                           {*<p class="goods-title">{$list_info.productname}  </p>*}
                                        {*<div class="goods-price clearfix">*}
                                            {*<div class="mui-pull-left">*}
                                                {*<span class="price-red">￥ {$list_info.robprice}  </span>*}
                                            {*</div>*}
                                            {*<div class="mui-pull-right"></div>*}
                                        {*</div>*}
                                    {*</div>*}
                                 {*</a>*}

                                {*{if $list_info.activitynumber gt 0}*}
                                {*<a href="detail.php?from=index&amp;productid={$list_info.productid}&salesactivityid={$salesactivityid}" id="aa">*}
                                    {*<button class="rob_button_red" style="width: 25%; float: right;color:white; background-color: #f15352"  ><span>去抢购</span></button>*}
                                {*</a>*}
                                {*{else}*}
                                    {*<button class="rob_button_gre" style="width: 25%; float: right;color:white; background-color: grey"  ><span>去抢购</span></button>*}
                                {*{/if}*}


                            {*</li>*}
                        {*{/foreach}*}
                    {*</ul>*}
                    <ul class="mui-table-view list" >
                        {foreach  item=lists from=$list_info}
                            <li class="mui-table-view-cell mui-media">
                                {foreach item=list from=$lists.productid }
                                    <a href="detail.php?from=index&amp;productid={$list}&salesactivityid={$salesactivityid}" id="aa">
                                        <div class="mui-media-body">
                                            {foreach item=list from=$lists.productthumbnail}
                                             <img id="product_item_502296" class="mui-media-object lazy img-responsive mui-pull-left" src="{$list}" data-original="http://img20.360buyimg.com/vc/jfs/t598/255/1252620114/106886/5812aacd/54c1e376N889a5e85.jpg">
                                            {/foreach}
                                            {foreach item=list from=$lists.productname }
                                                <p class="goods-title">{$list}  </p>
                                            {/foreach}
                                            {foreach item=list from=$lists.robprice }
                                            <div class="goods-price clearfix"><div class="mui-pull-left"><span class="price-red">￥ {$list}  </span></div><div class="mui-pull-right"></div></div></div>
                                        {/foreach}
                                        {foreach item=list from=$lists.begindate }
                                            <input type="hidden"  value="{$list}" id="begindate">
                                        {/foreach}
                                        {foreach item=list from=$lists.enddate }
                                            <input type="hidden"  value="{$list}" id="enddate">
                                        {/foreach}
                                        {*{foreach item=list from=$lists.activitynumber }*}
                                            {*<input type="hidden"  value="{$list}" id="enddate">*}
                                        {*{/foreach}*}
                                    </a>
                                {/foreach}
                                <!--{foreach item=list from=$lists.productid }
                                <a href="detail.php?from=index&amp;productid={$list}&salesactivityid={$salesactivityid}" id="aa">
                                <button style="width: 25%; float: right;color:white; background-color: #f15352"><span>去抢购</span></button>
                                </a>
                                {/foreach}-->
                                {if $lists.activitynumber neq 0}
                                    <a href="detail.php?from=index&amp;productid={$lists.productid}&salesactivityid={$salesactivityid}" id="aa">
                                        <button class="rob_button_red" style="width: 25%; float: right;color:white; background-color: #f15352"  ><span>去抢购</span></button>
                                    </a>
                                    <button class="rob_button_gre" style="width: 25%; float: right;color:white; background-color: grey"  ><span>去抢购</span></button>
                                    <button class="rob_button_yel" style="width: 25%; float: right;color:white; background-color: #f0c040"  ><span>请等待</span></button>
                                {else}
                                    <button class=" " style="width: 25%; float: right;color:white; background-color: grey"  ><span>已抢光</span></button>
                                {/if}
                            </li>
                        {/foreach}
                    </ul>
                    <div class="h50"></div>
                </div>
            </div>
        </div>
        <div class="mui-off-canvas-backdrop"></div>
    </div>
</div>

 <div class="popup_bg popup_false" hidden>
    <div class="popup_content">
        <img src="../public/images/icon_attention.png">
        <p>很遗憾，您没有抢到该商品！</p>
        <button class="popup_btn_false">返回</button>
    </div>
</div>
<div class="popup_bg popup_true" hidden>
    <div class="popup_content">
        <img src="../public/images/icon_attention.png">
        <p>恭喜，您已抢到该商品！</p>
        <button class="popup_btn_true">前去付款</button>
    </div>
</div>

</body>
</html>
<script type="text/javascript">


     var activity_statue =1;
    {literal}
     //抢购
     $('.rob_button_red').on('tap',function(){
//         alert("123");
     });


     $('.snap_up').on('tap',function(){
        $('.popup_false').show();
    });
     $('.popup_bg').on('tap',function(){
        $(this).hide();
     });
     $('.popup_content').on('tap',function(e){
        e.stopPropagation()
     });
     $('.popup_btn_false').on('tap',function(){
        $('.popup_bg').hide()
     });
//    var rob_list = document.getElementById("rob_list");
    var rob_list =Zepto('#rob_list').val();;
//    console.log(rob_list);

    if(rob_list == 1){
         $("#sortbar").css("display","none");
//        ui2 =document.getElementById("rob_list");
//        ui2.style.display="none";
    }else{
//        alert(1111)
        $("#has_rob").css("display","none");
    }

    mui.ready(function() {
        //        监听a
        mui('body').on('tap','a',function(){
            window.top.location.href=this.href;
        });
 //        时间开
        var timer=null;
        var starttime1 = $("#begindate").val();
        var endtime1 = $("#enddate").val();
//        console.log(starttime1)
//        console.log(endtime1)
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
//            console.log(nowtime);
//            $('#1').html(starttime2);
//            $('#2').html(starttime);
//            $('#3').html(endtime2);
//            $('#4').html(endtime);
//            $('#5').html(nowtime);

            var cha;
            if(starttime-nowtime>0){
                cha=starttime.getTime()-nowtime.getTime();/*得到距离开始的时间*/
                $("#activity_before").css("display","block");
                $("#activity_during").css("display","none");
                $("#activity_after").css("display","none");
                $("#activity_time").css("display","block");
                $(".rob_button_gre").css("display","none");
                $(".rob_button_red").css("display","none");
                $(".rob_button_yel").css("display","block");
            }else if(nowtime<endtime){
                cha=endtime.getTime()-nowtime.getTime();/*得到距离结束的时间*/
                $("#activity_before").css("display","none");
                $("#activity_during").css("display","block");
                $("#activity_after").css("display","none");
                $("#activity_time").css("display","block");
                $(".rob_button_gre").css("display","none");
                $(".rob_button_yel").css("display","none");
            }else{  /*活动结束*/
                var activity = 0;
                clearInterval(timer);
                $("#activity_before").css("display","none");
                $("#activity_during").css("display","none");
                $("#activity_after").css("display","block");
                $("#activity_time").css("display","none");
                $(".rob_button_red").css("display","none");
                $(".rob_button_gre").css("display","block");
                $(".rob_button_yel").css("display","none");
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


        mui('#pullrefresh').scroll();
//        mui('.mui-bar').on('tap','a',function(e){
//            mui.openWindow({
//                url: this.getAttribute('href'),
//                id: 'info'
//            });
//        });
//        mui('#list').on('tap','a',function(e){
//            mui.openWindow({
//                url: this.getAttribute('href'),
//                id: 'info'
//            });
//        });

//        mui('#sortbar').on('tap','div.mui-col-xs-3',function(){
//            var order =  this.getAttribute('data-order');
//            var sort =  this.getAttribute('data-sort');
//            Zepto(".bar-item").removeClass("active");
//            Zepto(this).addClass("active");
//            if (order == "price")
//            {
//                Zepto("#icon_price").css("display","");
//                if (sort == "asc")
//                {
//                    Zepto("#icon_price").removeClass("icon-sort-asc");
//                    Zepto("#icon_price").addClass("icon-sort-desc");
//                    Zepto(this).attr("data-sort","desc");
//                }
//                else
//                {
//                    Zepto("#icon_price").removeClass("icon-sort-desc");
//                    Zepto("#icon_price").addClass("icon-sort-asc");
//                    Zepto(this).attr("data-sort","asc");
//                }
//
//                Zepto("#icon_salevalue").css("display","none");
//                Zepto("#icon_praise").css("display","none");
//            }
//            else if (order == "salevalue")
//            {
//                Zepto("#icon_salevalue").css("display","");
//                if (sort == "asc")
//                {
//                    Zepto("#icon_salevalue").removeClass("icon-sort-asc");
//                    Zepto("#icon_salevalue").addClass("icon-sort-desc");
//                    Zepto(this).attr("data-sort","desc");
//                }
//                else
//                {
//                    Zepto("#icon_salevalue").removeClass("icon-sort-desc");
//                    Zepto("#icon_salevalue").addClass("icon-sort-asc");
//                    Zepto(this).attr("data-sort","asc");
//                }
//
//                Zepto("#icon_price").css("display","none");
//                Zepto("#icon_praise").css("display","none");
//            }
//            else if (order == "praise")
//            {
//                Zepto("#icon_praise").css("display","");
//                if (sort == "asc")
//                {
//                    Zepto("#icon_praise").removeClass("icon-sort-asc");
//                    Zepto("#icon_praise").addClass("icon-sort-desc");
//                    Zepto(this).attr("data-sort","desc");
//                }
//                else
//                {
//                    Zepto("#icon_praise").removeClass("icon-sort-desc");
//                    Zepto("#icon_praise").addClass("icon-sort-asc");
//                    Zepto(this).attr("data-sort","asc");
//                }
//
//                Zepto("#icon_price").css("display","none");
//                Zepto("#icon_salevalue").css("display","none");
//            }
//            else
//            {
//                Zepto("#icon_price").css("display","none");
//                Zepto("#icon_salevalue").css("display","none");
//                Zepto("#icon_praise").css("display","none");
//            }
//
//            Zepto("#sort").val(sort);
//            Zepto("#order").val(order);
//            Zepto('#page').val(1);
//            Zepto('.list').html('');
//            add_more();
//            mui('#pullrefresh').pullRefresh().refresh(true);
//        });
//        mui('.mui-table-view').on('tap','a.add_shoppingcart',function(){
//            var record =  this.getAttribute('data-id');
//            add_shoppingcart(record);
//        });
    });
//     时间  *

    /**
     * 下拉刷新具体业务实现
     */
//    function pulldownRefresh() {
//        Zepto('#sortbar').css("display","none");
//        setTimeout(function() {
//            Zepto('#page').val(1);
//            Zepto('.list').html('');
//            Zepto('#sortbar').css("display","");
//            add_more();
//            mui('#pullrefresh').pullRefresh().refresh(true);
//            mui('#pullrefresh').pullRefresh().endPulldownToRefresh(); //refresh completed
//            $(".lazy").lazyload();
//        }, 1000);
//    }


//    function add_shoppingcart(record)
//    {
//        mui.ajax({
//            type: 'POST',
//            url: "shoppingcart_add.ajax.php",
//            data: 'record=' + record,
//            success: function(json) {
//                var jsondata = eval("("+json+")");
//                if (jsondata.code == 200) {
//                    mui.toast(jsondata.msg);
//                    flyItem("product_item_"+record);
//                    Zepto('#shoppingcart_badge').html('<span class="mui-badge">'+jsondata.shoppingcart+'</span>');
//                }
//                else
//                {
//                    mui.toast(jsondata.msg);
//                }
//            }
//        });
//    }
//     function product_html(v) {
//        if(rob_list == 1){
//            if( activity_statue == 1 ){
//                var aa = '<button style="width: 25%; float: right;color:white; background-color: #f15352"><span>去抢购</span></button>'
//            }else{
//                var aa = '<button style="width: 25%; float: right;color:white; background-color: grey; "><span>活动结束</span></button>'
//            }
//        }else{
//            var aa = '<a class="add_shoppingcart" data-id="'+v.productid+'" href="javascript:;"><span class="mui-icon iconfont icon-shoppingcart" style="font-size:.3rem;"></span></a>'
//
//        }
//        var sb=new StringBuilder();
//        sb.append('<li class="mui-table-view-cell mui-media">' +
//                '<a href="detail.php?from=index&productid='+v.productid+'"><div class="mui-media-body">' +
//                '<img id="product_item_'+v.productid+'" class="mui-media-object lazy img-responsive mui-pull-left" src="images/smkLoad.png" data-original="'+v.productlogo+'">' +
//                '<p class="goods-title">'+v.productname+'</p>' +
//                '<div class="goods-price clearfix">' +
//                '<div class="mui-pull-left">' +
//                '<span class="price-red">￥'+v.shop_price+'</span></div>' +
//                '<div class="mui-pull-right">' +
//                '</div></div></div></a>'+
//                aa );
//        return sb.toString();
//    }

//    function add_more() {
//        var page = Zepto('#page').val();
//        var categoryid = Zepto('#categoryid').val();
//        var sort = Zepto('#sort').val();
//        var order = Zepto('#order').val();
//        var keywords = Zepto('#keywords').val();
//        Zepto('#page').val(parseInt(page) + 1);
//        mui.ajax({
//            type: 'POST',
//            url: "search.ajax.php",
//            data: 'page='+page+'&keywords='+keywords+'&categoryid='+categoryid+'&order='+order+'&sort='+sort,
//            success: function(json) {
//                var msg = eval("("+json+")");
//                if (msg.code == 200) {
//                    Zepto.each(msg.data, function(i, v) {
//                        var nd = product_html(v);
//                        Zepto('.list').append(nd);
//                    });
//                    $(".lazy").lazyload();
//                    mui('#pullrefresh').pullRefresh().endPullupToRefresh(false); //参数为true代表没有更多数据了。
//                } else {
//                    mui('#pullrefresh').pullRefresh().endPullupToRefresh(true); //参数为true代表没有更多数据了。
//                }
//            }
//        });
//    }

    //触发第一页
//    if (mui.os.plus) {
//        mui.plusReady(function() {
//            setTimeout(function() {
//                mui('#pullrefresh').pullRefresh().pullupLoading();
//            }, 1000);
//
//        });
//    } else {
//        mui.ready(function() {
//            Zepto('#page').val(1);
//            mui('#pullrefresh').pullRefresh().pullupLoading();
//        });
//    }


    {/literal}
</script>

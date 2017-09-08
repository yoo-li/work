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
            mui('body').on('tap', 'a', function(){
                document.location.href=this.href;
            });
            mui('.goods-price').on('tap', '.praise', function(){
                $(this).toggleClass('active');
            });
            mui('.mui-row').on('tap', '.filter', function(){
                $('.filter').removeClass('active');
                $(this).addClass('active');
            });
        }
        !function(){function a(){document.documentElement.style.fontSize=document.documentElement.clientWidth/6.4+"px";if(document.documentElement.clientWidth>=640)document.documentElement.style.fontSize='100px';}var b=null;window.addEventListener("resize",function(){clearTimeout(b),b=setTimeout(a,300)},!1),a()}(window);
        {/literal}
    </script>
    <style>
        {literal}
        .icon-tezan:before {
            content: "\e619";
        }
        {/literal}
    </style>
</head>
<body>
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
                    <div class="mui-row"  id="sortbar">
                        <div class="mui-col-xs-3 filter"  data-sort="desc" data-order="published">
                            默认
                        </div>
                        <div class="mui-col-xs-3 filter" data-sort="desc" data-order="price">
                            价格<span id="icon_price" style="display:none" class="icon-sort iconfont icon-sort-desc"></span>
                        </div>
                        <div class="mui-col-xs-3 filter" data-sort="desc" data-order="salevalue">
                            销量<span id="icon_salevalue" style="display:none" class="icon-sort iconfont icon-sort-desc">
                        </div>
                        <div class="mui-col-xs-3 filter" data-sort="desc" data-order="praise">
                            筛选<span id="icon_praise" style="display:none" class="icon-sort iconfont icon-sort-desc">
                        </div>
                    </div>
                    <input id="page"  type="hidden" value="1">
                    <input id="categoryid"  type="hidden" value="{$categoryid}">
                    <input id="keywords"  type="hidden" value="{$keywords}">
                    <input id="sort"  type="hidden" value="asc">
                    <input id="order"  type="hidden" value="published">
                    <ul class="mui-table-view list" id="list">

                    </ul>
                    <div class="h50"></div>
                </div>
            </div>
        </div>
        <div class="mui-off-canvas-backdrop"></div>
    </div>
</div>
</body>
</html>
<script type="text/javascript">
    {literal}
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
    mui.ready(function() {
        mui('#pullrefresh').scroll();
        mui('.mui-bar').on('tap','a',function(e){
            mui.openWindow({
                url: this.getAttribute('href'),
                id: 'info'
            });
        });
        mui('#list').on('tap','a',function(e){
            mui.openWindow({
                url: this.getAttribute('href'),
                id: 'info'
            });
        });
        mui('#sortbar').on('tap','div.mui-col-xs-3',function(){
            var order =  this.getAttribute('data-order');
            var sort =  this.getAttribute('data-sort');
            Zepto(".bar-item").removeClass("active");
            Zepto(this).addClass("active");
            if (order == "price")
            {
                Zepto("#icon_price").css("display","");
                if (sort == "asc")
                {
                    Zepto("#icon_price").removeClass("icon-sort-asc");
                    Zepto("#icon_price").addClass("icon-sort-desc");
                    Zepto(this).attr("data-sort","desc");
                }
                else
                {
                    Zepto("#icon_price").removeClass("icon-sort-desc");
                    Zepto("#icon_price").addClass("icon-sort-asc");
                    Zepto(this).attr("data-sort","asc");
                }

                Zepto("#icon_salevalue").css("display","none");
                Zepto("#icon_praise").css("display","none");
            }
            else if (order == "salevalue")
            {
                Zepto("#icon_salevalue").css("display","");
                if (sort == "asc")
                {
                    Zepto("#icon_salevalue").removeClass("icon-sort-asc");
                    Zepto("#icon_salevalue").addClass("icon-sort-desc");
                    Zepto(this).attr("data-sort","desc");
                }
                else
                {
                    Zepto("#icon_salevalue").removeClass("icon-sort-desc");
                    Zepto("#icon_salevalue").addClass("icon-sort-asc");
                    Zepto(this).attr("data-sort","asc");
                }

                Zepto("#icon_price").css("display","none");
                Zepto("#icon_praise").css("display","none");
            }
            else if (order == "praise")
            {
                Zepto("#icon_praise").css("display","");
                if (sort == "asc")
                {
                    Zepto("#icon_praise").removeClass("icon-sort-asc");
                    Zepto("#icon_praise").addClass("icon-sort-desc");
                    Zepto(this).attr("data-sort","desc");
                }
                else
                {
                    Zepto("#icon_praise").removeClass("icon-sort-desc");
                    Zepto("#icon_praise").addClass("icon-sort-asc");
                    Zepto(this).attr("data-sort","asc");
                }

                Zepto("#icon_price").css("display","none");
                Zepto("#icon_salevalue").css("display","none");
            }
            else
            {
                Zepto("#icon_price").css("display","none");
                Zepto("#icon_salevalue").css("display","none");
                Zepto("#icon_praise").css("display","none");
            }

            Zepto("#sort").val(sort);
            Zepto("#order").val(order);
            Zepto('#page').val(1);
            Zepto('.list').html('');
            add_more();
            mui('#pullrefresh').pullRefresh().refresh(true);
        });
        mui('.mui-table-view').on('tap','a.add_shoppingcart',function(){
            var record =  this.getAttribute('data-id');
            add_shoppingcart(record);
        });
    });

    /**
     * 下拉刷新具体业务实现
     */
    function pulldownRefresh() {
        Zepto('#sortbar').css("display","none");
        setTimeout(function() {
            Zepto('#page').val(1);
            Zepto('.list').html('');
            Zepto('#sortbar').css("display","");
            add_more();
            mui('#pullrefresh').pullRefresh().refresh(true);
            mui('#pullrefresh').pullRefresh().endPulldownToRefresh(); //refresh completed
            $(".lazy").lazyload();
        }, 1000);
    }


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
                    flyItem("product_item_"+record);
                    Zepto('#shoppingcart_badge').html('<span class="mui-badge">'+jsondata.shoppingcart+'</span>');
                }
                else
                {
                    mui.toast(jsondata.msg);
                }
            }
        });
    }
    function product_html(v) {
        var sb=new StringBuilder();
        sb.append('<li class="mui-table-view-cell mui-media">' +
                '<a href="detail.php?from=index&productid='+v.productid+'"><div class="mui-media-body">' +
                '<img id="product_item_'+v.productid+'" class="mui-media-object lazy img-responsive mui-pull-left" src="images/smkLoad.png" data-original="'+v.productlogo+'">' +
                '<p class="goods-title">'+v.productname+'</p>' +
                '<div class="goods-price clearfix">' +
                '<div class="mui-pull-left">' +
                '<span class="price-red">￥'+v.shop_price+'</span></div>' +
                '<div class="mui-pull-right">' +
                '</div></div></div></a>'+
                '<a class="add_shoppingcart" data-id="'+v.productid+'" href="javascript:;"><span class="mui-icon iconfont icon-shoppingcart" style="font-size:.3rem;"></span></a></li>');
        return sb.toString();
    }

    function add_more() {
        var page = Zepto('#page').val();
        var categoryid = Zepto('#categoryid').val();
        var sort = Zepto('#sort').val();
        var order = Zepto('#order').val();
        var keywords = Zepto('#keywords').val();
        Zepto('#page').val(parseInt(page) + 1);
        mui.ajax({
            type: 'POST',
            url: "newproducts.ajax.php",
            data: 'page='+page+'&keywords='+keywords+'&categoryid='+categoryid+'&order='+order+'&sort='+sort,
            success: function(json) {
                var msg = eval("("+json+")");
                if (msg.code == 200) {
                    Zepto.each(msg.data, function(i, v) {
                        var nd = product_html(v);
                        Zepto('.list').append(nd);
                    });
                    $(".lazy").lazyload();
                    mui('#pullrefresh').pullRefresh().endPullupToRefresh(false); //参数为true代表没有更多数据了。
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

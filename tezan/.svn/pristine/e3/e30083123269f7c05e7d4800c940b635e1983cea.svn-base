<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>easyWeb Framework</title>
    <link href="/homepage/css/FA/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/menu.css" />
    <link rel="stylesheet" type="text/css" href="css/owl.carousel.css" />
    <link rel="stylesheet" type="text/css" href="css/jquery.fancybox-1.3.4.css" />
    <link rel="stylesheet" type="text/css" href="css/pgwslideshow.css" />
    <link rel="stylesheet" type="text/css" href="css/responsive.tabs.css" />
    <link rel="stylesheet" type="text/css" href="css/animate.min.css" />
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/pagination.css"">

    <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="js/jquery.ba-resize.js"></script>
    <script type="text/javascript" src="js/superfish.js"></script>
    <script type="text/javascript" src="js/owl.carousel.min.js"></script>
    <script type="text/javascript" src="js/jquery.fancybox-1.3.4.pack.js"></script>
    <script type="text/javascript" src="js/pgwslideshow.min.js"></script>
    <script type="text/javascript" src="js/cloud-zoom.1.0.2.min.js"></script>
    <script type="text/javascript" src="js/responsive.tabs.js"></script>
    <script type="text/javascript" src="js/animate.min.js"></script>
    <script type="text/javascript" src="html5media/html5media-1.2.js"></script>
    <script type="text/javascript" src="js/custom.js"></script>
    <script type="text/javascript" src="js/jquery.pagination.js"></script>
    <script type="text/javascript">
        //Video Player
        html5media.flowplayerSwf = "html5media/flowplayer-3.2.18.swf";
        html5media.flowplayerControlsSwf = "html5media/flowplayer.controls-3.2.16.swf";
    </script>

    <!--[if lt IE 9]>
    <script src="js/html5.js"></script>
    <![endif]-->
</head>

<body>
<div id="wrapper">
    <!-- S ======================= header ======================= -->
    <header class="header header-v1 desktops-section">
        <section class="top-bar">
            <div class="container">
                <div class="float-left">
                    <p>咨询电话：020-12345678</p>
                </div>
                <div class="float-right">
                    <div class="link-line link-line-rtl">
                        <a href="#">
                            <i class="fa fa-weibo" style="font-size:14px;">
                                <span>微博</span>
                            </i>
                        </a>

                        <a href="mycollections.php">
                            <i class="fa fa-star-o" style="font-size:14px;">
                                <span>我的收藏</span>
                            </i>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section class="top-main">
            <div class="container">
                <div class="logo">
                    <a href="#"><img src="images/logo.png" alt="" /></a>
                </div>
                <div class="top-main-content">
                    <!-- S nav -->
                    <nav class="nav">
                        <div class="main-nav clearfix">
                            <ul class="sf-menu">
                                <li ><a class="first-level" href="index.php"><strong>首页</strong></a></li>
                                <li class="current">
                                    <a class="first-level" href="#factoryproductDiv"><strong>企业库</strong></a>
                                </li>
                                <li>
                                    <a class="first-level" href="#projects"><strong>产品库</strong></a>
                                </li>
                                <li>
                                    <a class="first-level" href="#descripts"><strong>信息平台</strong></a>
                                </li>
                                <li>
                                    <a class="first-level" href="#tese"><strong>技术抢单</strong></a>
                                </li>
                                <li>
                                    <a class="first-level" href="#zixun"><strong>行业资讯</strong></a>
                                </li>
                                <li><a class="first-level" href="#fagui"><strong>政策法规</strong></a></li>
                                <li><a class="first-level" href="#footer"><strong>关于我们</strong></a></li>
                            </ul>
                        </div>
                    </nav>
                    <!-- E nav-->
                </div>
            </div>
        </section>
    </header>
    <!-- E ======================= header ======================= -->


    <!-- S mobile-header -->
    <div class="mobile-header mobile-section">
        <div class="mobile-header-bar clearfix">
            <div class="mobile-logo">
                <a href="#"><img src="images/logo.png" alt="" /></a>
            </div>
            <div class="mobile-menu-icons">
                <a href="javascript:;" data-drawer="drawer-section-search" class="menu-icon-search"><span>搜索</span></a>
                <a href="javascript:;" data-drawer="drawer-section-language" class="menu-icon-language"><span>语言</span></a>
                <a href="javascript:;" data-drawer="drawer-section-nav" class="menu-icon-nav"><span>导航</span></a>
            </div>
        </div>

    </div>
    <!-- S mobile-header -->



    <!-- S ======================= slider-wrap ======================= -->
    <header class="slider-wrap">
        <!-- S owl-slider -->
        <div class="owl-carousel owl-slider owl-slider-default">
            {foreach item=ad_info from=$ad_infos}
                <div class="slider-item"><a href="#"><img src="{$ad_info.webimage}" alt="" /></a></div>
            {/foreach}
        </div>
        <!-- E owl-slider -->
    </header>
    <input type="hidden" name="productid" id="productid" value="{$productid}">
    <input type="hidden" name="mycollection" id="mycollection" value="{$mycollections}">
    <div class="main">
        <div class="container">
            <section class="float-center">
                <div class="page-info page-info-inner clearfix">
                    <div class="breadcrumbs float-right">
                        <span>当前位置：</span>
                        <a href="/">首页</a><i>&gt;</i>
                        <a href="#">我的收藏</a><i>&gt;</i>
                        <strong>列表</strong>
                    </div>
                    <h2 class="page-name">收藏列表</h2>
                </div>

                <div class="content-wrap">

                    <div class="module module-bottom">
                        <div class="module-title-wrap clearfix">
                            <div class="module-title clearfix">
                                <h2>产品名称</h2>
                            </div>
                        </div>
                        <div class="module-content">
                            <div class="list-line">
                                <ul id="collection_content">
                                </ul>
                            </div>
                            <div id="collectionPagination" class="pagination" style="width:100%;text-align: center;"></div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    {include file="footer.tpl"}
</div>

<div class="gotop gotop-fixed"><a href="#" title="返回顶部"><span>返回顶部</span></a></div>

<script type="text/javascript">
    var num_count={$mycollections_num};
    {literal}
    $(function() {
        $("#collectionPagination").pagination(num_count, {
            items_per_page: 10,
            num_edge_entries: 2,
            num_display_entries: 4,
            link_to: "javascript:void(0);",
            prev_text: "<&nbsp;上一页",
            next_text: "下一页&nbsp;>",
            prev_show_always: true,
            next_show_always: true,
            callback: pageselectCallback
        })
    })
    function pageselectCallback(page, pagination) {
        var url = "mycollections.ajax.php?cur_page="+page;
        $.get(url, "", function (data) {
            $("#collection_content").empty().append(data);
        })
    }
    {/literal}
</script>

</body>
</html>




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
    <section class="main">    	
    	<section class="full-width-content">
        	<div class="container">
            	
                <!-- S product-detail-zoom -->
                <div class="product-detail product-detail-zoom">                	
                	<!-- S product-intr -->
                    <div class="product-intr clearfix">
                    	<div class="product-preview">
                        	
                            <!-- S　放大镜 PC端显示 -->
                            <div class="zoom-section">
                                <div class="zoom-small-image">
                                    <a href="images/upload/zoom/product-b-01.jpg" class="cloud-zoom" id="zoom1" data-rel="adjustX:10, adjustY:0, zoomWidth:'auto', zoomHeight:'auto', showTitle:false">
                                        <img src="images/upload/product-category-01.jpg" alt="" title="Optional title display" width="600" />
                                    </a>
                                </div>
                                <div class="zoom-thumbs">
                                    <ul class="owl-carousel owl-scrollable owl-scrollable-zoom">
                                        <li class="zoom-selected">
                                            <a href="images/upload/zoom/product-b-01.jpg" class="cloud-zoom-gallery" data-rel="useZoom:'zoom1', smallImage:'images/upload/product-category-01.jpg'">
                                                <img class="zoom-tiny-image" src="images/upload/product-category-01.jpg" alt="" />
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- E　放大镜 -->

                            <!-- S 图片集 移动端显示 -->
                            <div class="gallery-img-wrap gallery-caption-hide gallery-img-fancybox gallery-img-product-detail" data-rel-name="pgwSlideshow-imgZoom-01" data-icon-zoom-text="查看大图">
                                <ul class="pgwSlideshow-gallery-zoom pgwSlideshow clearfix">
                                    <li><a href="images/upload/zoom/product-b-01.jpg"><img src="images/upload/product-category-01.jpg" width="80" height="80" data-large-src="images/upload/product-category-01.jpg" alt="图片名称" /></a></li>
                                </ul>
                            </div>
                            <!-- E 图片集-->


                            <!-- S 单张图片时显示 -->
                            <div class="product-img-single" style="display:none;">
	                        	<img src="images/upload/product-category-01.jpg" alt="" />
	                        </div>
                            
                        </div><!-- end of product-preview -->
                        
                        <div class="product-info">
                        	<div class="product-name"><h1>{$productname}</h1></div>
                            <div class="product-sku">规格：<span>{$guige}</span></div>

                            <div class="product-info-item">
                            	<div class="product-summary">
                                	<div class="typography-text">
                                    	<p>{$simple_desc}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="product-info-item">
                            	<div class="product-attr">
                                	<dl class="dl-horizontal clearfix">
                                        <dt>材质：</dt>
                                        <dd><span>{$material}</span></dd>
                                    </dl>
                                    <dl class="dl-horizontal clearfix">
                                        <dt>型号：</dt>
                                        <dd><span>{$model}</span></dd>
                                    </dl>
                                </div>
                            </div>

                            <div class="product-info-item dl-horizontal">
                            	<div class="dd">
	                            	<div class="buy-action-btn btn-group">
	                                    <button class="btn btn-large btn-primary">
                                            <a target="_blank" href="http://wpa.qq.com/msgrd?v={$descrip_infos.uid}&uin={$descrip_infos.qq}&site=qq&menu=yes">
                                                <span>在线咨询</span>
                                            </a>
                                        </button>
	                                    <button id="addcollectionicon" class="btn btn-large {if $mycollections eq '1'}btn-default{else}btn-primary{/if}"><span>{if $mycollections eq '1'}取消收藏{else}收藏{/if}</span></button>
	                                </div>
                                </div>
                            </div>
                            <div class="product-info-item product-info-item-last dl-horizontal">
                                <div class="dd">
	                                <div class="back-to-list-single"><a href="index.php?ma_clinicalcategorys={$ma_clinicalcategorys}">查看更多<span>类似产品</span></a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- E product-intr -->
                    
                    <!-- S product-desc -->
                    <div class="product-desc clearfix">
                    	<div class="tabs-placeholder" style="overflow:hidden; font-size:0;">&nbsp;</div>
                    	<!-- S tabs -->
	                    <div class="tabs tabs-no-resp">
					    	<ul class="tabs-list clearfix">
					    		<li class="active"><a href="javascript:;">产品介绍</a></li>
					    		<li><a href="javascript:;">规格参数</a></li>
					    		<li><a href="javascript:;">附件下载</a></li>
					    	</ul>
					        <div class="tabs-container">
					        	<div class="tab-content" style="display:block;">
					            	<!-- S typography-text -->
                                    <div class="typography-text">
                                        {$description}
                                    </div>
                                    <!-- E typography-text -->
					            </div>
					            <div class="tab-content">
					            	<!-- S typography-text -->
                                    <div class="typography-text">
                                        <h5>规格参数及使用说明</h5>
                                        {$description}
                                    </div>
                                    <!-- E typography-text -->
					            </div>
					            <div class="tab-content">
					            	<div class="product-detail-download">
                                        <ul class="list-line-simple">
			                                <li><a href="#">产品附件 01 </a></li>
			                                <li><a href="#">产品附件、产品附件 02 </a></li>
			                                <li><a href="#">产品附件、产品附件、产品附件 03 </a></li>
			                            </ul>
                                    </div>
					            </div>
					        </div>
					    </div>
	                    <!-- E tabs -->
                        
                    </div>
                    <!-- E product-desc -->
                </div>
                
            </div><!-- end of content -->
        </section>
    </section>
    <!-- E ======================= main ======================= -->
    
    
    
    
    
    <!-- S ======================= footer ======================= -->
    {include file="footer.tpl"}
</div>

<div class="gotop gotop-fixed"><a href="#" title="返回顶部"><span>返回顶部</span></a></div>

<script type="text/javascript">
    {literal}
    $(function() {
        $('#addcollectionicon').click(function () {
            addcollectionicon();
        });
    })
    function addcollectionicon()
    {
        var productid = $('#productid').val();
        var status = $('#mycollection').val();
        if (status == "0")
        {
            var postbody = 'record=' + productid + '&status=1';
            jQuery.post("mycollection_add.ajax.php", postbody,
                    function (json, textStatus) {
                        $('#mycollection').val("1");
                        $('#addcollectionicon').removeClass("btn-primary").addClass("btn-default").html("取消收藏");
                    });
        }
        else
        {
            var postbody = 'record=' + productid + '&status=0';
            jQuery.post("mycollection_add.ajax.php", postbody,
                    function (json, textStatus) {
                        $('#mycollection').val("0");
                        $('#addcollectionicon').removeClass("btn-default").addClass("btn-primary").html("收藏");
                    });
        }
    }
    {/literal}
</script>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<title>easyWeb Framework</title>
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
                        	<img src="images/upload/icon-github.png" alt="" />
                            <span>GitHub</span>
                        </a>
                        
                    	<a href="#">
                        	<img src="images/upload/icon-sina.png" alt="" />
                            <span>微博</span>
                        </a>
                        
                    	<a href="#">
                        	<img src="images/upload/icon-115.png" alt="" />
                            <span>站酷</span>
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

    <header class="slider-wrap">
    	<!-- S owl-slider -->
        <div class="owl-carousel owl-slider owl-slider-default">
			{foreach item=ad_info from=$ad_infos}
				<div class="slider-item"><a href="#"><img src="{$ad_info.webimage}" alt="" /></a></div>
			{/foreach}
        </div>
        <!-- E owl-slider -->
    </header>

    <section class="main">    	
    	<section class="full-width-content">
        	<div class="container">
            	
                <!-- S product-detail -->
                <div class="product-detail">                	
                	<!-- S product-intr -->
                    <div class="product-intr clearfix">
                    	<div class="product-preview">
                        	
                            <!-- S　图库 -->
                            <div class="gallery-img-wrap gallery-caption-hide gallery-img-fancybox" data-rel-name="pgwSlideshow-imgZoom-02" data-icon-zoom-text="查看大图">
                                <ul class="pgwSlideshow-gallery pgwSlideshow clearfix">
                                    <li><a href="images/upload/gallery/hotel-01.jpg" title="xxxxxxx"><img src="images/upload/gallery/thumbs/hotel-01.jpg" width="120" height="90" data-large-src="images/upload/gallery/hotel-01.jpg" alt="外观" /></a></li>
                                    <li><a href="images/upload/gallery/hotel-01.jpg"><img src="images/upload/gallery/thumbs/hotel-02.jpg" width="120" height="90" data-large-src="images/upload/gallery/hotel-02.jpg" alt="大堂吧" /></a></li>
                                    <li><a href="images/upload/gallery/hotel-01.jpg"><img src="images/upload/gallery/thumbs/hotel-03.jpg" width="120" height="90" data-large-src="images/upload/gallery/hotel-03.jpg" alt="大堂" /></a></li>
                                    <li><a href="images/upload/gallery/hotel-01.jpg"><img src="images/upload/gallery/thumbs/hotel-04.jpg" width="120" height="90" data-large-src="images/upload/gallery/hotel-04.jpg" alt="馆阅览室" /></a></li>
                                    <li><a href="images/upload/gallery/hotel-01.jpg"><img src="images/upload/gallery/thumbs/hotel-05.jpg" width="120" height="90" data-large-src="images/upload/gallery/hotel-05.jpg" alt="儿童活动室" /></a></li>
                                    <li><a href="images/upload/gallery/hotel-01.jpg"><img src="images/upload/gallery/thumbs/hotel-06.jpg" width="120" height="90" data-large-src="images/upload/gallery/hotel-06.jpg" alt="游泳池" /></a></li>
                                    <li><a href="images/upload/gallery/hotel-01.jpg"><img src="images/upload/gallery/thumbs/hotel-07.jpg" width="120" height="90" data-large-src="images/upload/gallery/hotel-07.jpg" alt="棋牌" /></a></li>
                                    <li><a href="images/upload/gallery/hotel-01.jpg"><img src="images/upload/gallery/thumbs/hotel-08.jpg" width="120" height="90" data-large-src="images/upload/gallery/hotel-08.jpg" alt="桌球" /></a></li>
                                    <li><a href="images/upload/gallery/hotel-01.jpg"><img src="images/upload/gallery/thumbs/hotel-09.jpg" width="120" height="90" data-large-src="images/upload/gallery/hotel-09.jpg" alt="会议厅" /></a></li>
                                    <li><a href="images/upload/gallery/hotel-01.jpg"><img src="images/upload/gallery/thumbs/hotel-10.jpg" width="120" height="90" data-large-src="images/upload/gallery/hotel-10.jpg" alt="特级贵宾房" /></a></li>
                                </ul>
                            </div>
                            <!-- E　图库 -->
                            
                            <!-- S 单张图片时显示 -->
                            <div class="product-img-single" style="display:none;">
	                        	<img src="images/upload/gallery/hotel-01.jpg" alt="" />
	                        </div>
                            <!-- E 单张图片时显示 -->
                            
                            
                        </div><!-- end of product-preview -->
                        
                        <div class="product-info">
                        	<div class="product-name"><h1>广州白云宾馆</h1></div>
                            <!--<div class="product-sku">编码：<span>E646123</span></div>                            
                            <div class="price"><p><strong>529</strong>元起</p></div>-->
                            <div class="product-info-item">
                            	<div class="product-summary">
                                	<div class="typography-text">
                                    	<p>1976年开业 &nbsp;&nbsp; 2012年装修 &nbsp;&nbsp; 588间房</p>
                                        <p>广州白云宾馆矗立于广州中央商务区、黄金商圈核心的环市东路，可便捷前往火车站、国际机场及会展中心。酒店毗邻广州最奢华的国际品牌购物中心丽柏广场、友谊商店、世贸中心，缤纷精彩的知名风情酒吧街，5分钟步行距离内即可领略现代化大都市的繁华与魅力。</p>
                                        <p>宾馆拥有2000平方米的前庭花园。宾馆还荣获2010年中国饭店业的最高荣誉"中国饭店金星奖"。</p>
                                        <p>位于33楼的空中游泳池，悬在高空，浮在水中，可以看到白云山，旁边还有一个温泉，一冷一热，孩子们可以此尽情戏水。</p>
                                        <p>白云轩餐厅有正宗粤菜和精美茶点；祥云西餐厅有美味的自助餐；位于30楼的意大利餐厅有正宗的意大利美食和美酒；白云豪宴中餐厅可举办各式宴会。这里还有11间不同规格的会议厅，配备先进的视听设备。</p>
                                    </div>
                                </div>
                            </div>
                            <div class="product-info-item">
                            	<div class="product-attr">
                                	<dl class="dl-horizontal clearfix">
                                        <dt>网络</dt>
                                        <dd><span>可无线上网</span></dd>
                                    </dl>
                                    <dl class="dl-horizontal clearfix">
                                        <dt>停车</dt>
                                        <dd><span>免费停车场</span></dd>
                                    </dl>
                                </div>
                            </div>
                            <!--
                            <div class="product-info-item">
                            	<div class="buy-action-btn btn-group">                                    
                                    <button class="btn btn-large btn-primary btn-disabled" disabled="disabled"><span>暂时缺货</span></button>
                                    <a href="#" class="btn btn-large btn-main"><span>到货通知</span></a>                                    
                                    <button class="btn btn-large btn-primary"><span>立即预定</span></button>
                                    <button class="btn btn-large btn-default"><span>收藏</span></button>                                    
                                </div>
                            </div>
                            <div class="product-info-item product-info-item-last">                                
                                <div class="back-to-list-single">
                                    <a href="#">查看更多<span>酒店</span></a>
                                </div>                                
                            </div>
                            -->
                            
                            <div class="share-bar-line share-bar-line-16 share-bar-line-min-margin">
                                <strong class="share-title">分享到：</strong>
                                <div class="bdsharebuttonbox">                            	
                                    <a title="分享到微信" href="#" class="bds_weixin" data-cmd="weixin"></a><a title="分享到QQ空间" href="#" class="bds_qzone" data-cmd="qzone"></a><a title="分享到新浪微博" href="#" class="bds_tsina" data-cmd="tsina"></a><a title="分享到腾讯微博" href="#" class="bds_tqq" data-cmd="tqq"></a><a target="_blank;" data-cmd="more" class="more" onclick="return false;" href="#"></a>
                                </div>
                            </div>
                            
                            
                            
                        </div><!-- end of product-info -->
                        
                    </div>
                    <!-- E product-intr -->
                    
                    <div class="product-desc-single-wrapper">
                        <div class="product-desc-single-title">
                            <h3>详情介绍</h3>
                        </div>
                        <div class="product-desc-single-content">
                        	<div class="typography-text">
                                <p>1976年开业 &nbsp;&nbsp; 2012年装修 &nbsp;&nbsp; 588间房</p>
                                <p>广州白云宾馆矗立于广州中央商务区、黄金商圈核心的环市东路，可便捷前往火车站、国际机场及会展中心。酒店毗邻广州最奢华的国际品牌购物中心丽柏广场、友谊商店、世贸中心，缤纷精彩的知名风情酒吧街，5分钟步行距离内即可领略现代化大都市的繁华与魅力。</p>
                                <p>宾馆拥有2000平方米的前庭花园。宾馆还荣获2010年中国饭店业的最高荣誉"中国饭店金星奖"。</p>
                                <p>位于33楼的空中游泳池，悬在高空，浮在水中，可以看到白云山，旁边还有一个温泉，一冷一热，孩子们可以此尽情戏水。</p>
                                <p>白云轩餐厅有正宗粤菜和精美茶点；祥云西餐厅有美味的自助餐；位于30楼的意大利餐厅有正宗的意大利美食和美酒；白云豪宴中餐厅可举办各式宴会。这里还有11间不同规格的会议厅，配备先进的视听设备。</p>
                            </div>
                        </div>
                    </div>
                    
                    
                    
                    <!-- S single-navigation -->
                    <div class="single-navigation single-navigation-icon clearfix">
                        <div class="prev-post"><a href="#" title="上一个"><i></i><span>上一个</span></a></div>
                        <div class="back-to-list"><a href="#" title="返回列表"><i></i><span>返回列表</span></a></div>
                        <div class="next-post"><a href="#" title="下一个"><i></i><span>下一个</span></a></div>
                    </div>
                    <!-- E single-navigation -->
                    
                </div>
                <!-- S product-detail -->
                <br /><br /><br /><br /><br />
                
            </div><!-- end of content -->
        </section>
    </section>
    <!-- E ======================= main ======================= -->
    
    
    
    
    
    <!-- S ======================= footer ======================= -->
    <footer class="footer">
    	<div class="container">
        	<div class="row">
            	<div class="col-5-1">
                
                	<div class="module">
		            	<div class="module-title-wrap clearfix">
		                    <div class="module-title clearfix">
		                        <h2>联系方式</h2>
		                    </div>
		                </div>
		                <div class="module-content">
		                	<!-- S typography-text -->
		                    <div class="typography-text">
                            	<p>
                                	QQ：<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=304683191&amp;site=qq&amp;menu=yes">304683191</a> <br />                                    
                                    邮箱：<a href="mailto:304683191@qq.com">304683191@qq.com</a> <br />                                    
                                    博客：<a target="_blank" href="http://sufangyu.github.io">sufangyu.github.io</a> <br />
                                    地址：白云，广州，广东
                                </p>
					        </div>
		                    <!-- E typography-text -->
		                </div>
		            </div>
                    
                </div>
                <div class="col-5-1">
                	
                    <div class="module">
		            	<div class="module-title-wrap clearfix">
		                    <div class="module-title clearfix">
		                        <h2>文章</h2>
		                    </div>
		                </div>
		                <div class="module-content">
		                    <div class="link-block">
		                    	<ul>
		                        	<li><a href="article-category-01.html"><span>分类</span></a></li>
		                        	<li><a href="article-list-01.html"><span>列表</span></a></li>
		                            <li><a href="article-detail-text.html"><span>详情</span></a></li>
		                            <li><a href="article-set-01.html"><span>集合</span></a></li>
		                        </ul>
		                    </div>
		                </div>
		            </div>
                    
                </div>
                <div class="col-5-1">
                	
                    <div class="module">
		            	<div class="module-title-wrap clearfix">
		                    <div class="module-title clearfix">
		                        <h2>产品</h2>
		                    </div>
		                </div>
		                <div class="module-content">
		                    <div class="link-block">
		                    	<ul>
		                        	<li><a href="product-filter.html"><span>规格筛选</span></a></li>
                                    <li><a href="product-category-01.html"><span>分类</span></a></li>
		                        	<li><a href="product-list-01.html"><span>列表</span></a></li>
		                            <li><a href="product-detail-single.html"><span>详情</span></a></li>
		                            <li><a href="product-set-01.html"><span>集合</span></a></li>
		                        </ul>
		                    </div>
		                </div>
		            </div>
                    
                </div>
                <div class="col-5-1">
                	
                    <div class="module">
		            	<div class="module-title-wrap clearfix">
		                    <div class="module-title clearfix">
		                        <h2>其他</h2>
		                    </div>
		                </div>
		                <div class="module-content">
		                    <div class="link-block">
		                    	<ul>
		                        	<li><a href="layout-no-sidebar.html"><span>页面布局</span></a></li>
                                    <li><a href="slideshow.html"><span>广告轮换</span></a></li>
                                    <li><a href="tab.html"><span>Tabs 选项卡</span></a></li>
		                        	<li><a href="link-01.html"><span>链接</span></a></li>
		                            <li><a href="typography.html"><span>图文排版</span></a></li>
		                        </ul>
		                    </div>
		                </div>
		            </div>
                    
                </div>
                <div class="col-5-1 col-last">
                	
                    <div class="module">
		                <div class="module-content">
		                	<!-- S typography-text -->
		                    <div class="typography-text">                            	
                            	<p style="text-align:center;">
                                	<br />
                                    <img src="images/upload/erweima.png" width="110" alt="" />
                                    <br />
                                    博客
                                </p>
					        </div>
		                    <!-- E typography-text -->
		                </div>
		            </div>
                    
                </div>
            </div>
        </div>
    </footer>
    <!-- E ======================= footer ======================= -->
    
    
    
    
    
    <!-- S ======================= footer ======================= -->
    <section class="bottom">
    	<div class="container">
        	<div class="row">
            	<div class="col-5-3">
                	<p>2016 © Copyright 方雨_Yu</p>
                </div>
                <div class="col-5-2 col-last">
                	<div class="link-line link-line-rtl">
                        <a target="_blank" href="https://github.com/sufangyu"><span>GitHub</span></a>
                        <em class="sep">|</em>
                        <a target="_blank" href="http://www.weibo.com"><span>微博</span></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- E ======================= footer ======================= -->
    
</div>

<div class="gotop gotop-fixed"><a href="#" title="返回顶部"><span>返回顶部</span></a></div>

</body>
</html>
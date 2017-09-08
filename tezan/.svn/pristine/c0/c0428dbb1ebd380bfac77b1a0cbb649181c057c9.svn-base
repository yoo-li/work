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
					        	<li>
	                          		<a class="first-level" href="index.php"><strong>企业库</strong></a>
					          	</li>
                                <li>
	                          		<a class="first-level" href="index.php"><strong>产品库</strong></a>
					          	</li>
					          	<li>
	                            	<a class="first-level" href="index.php"><strong>信息平台</strong></a>
					          	</li>
                                <li>
	                            	<a class="first-level" href="index.php"><strong>技术抢单</strong></a>
					          	</li>
								<li class="current">
									<a class="first-level" href="index.php"><strong>行业资讯</strong></a>
								</li>
                                <li><a class="first-level" href="index.php"><strong>政策法规</strong></a></li>
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
	<div class="main" style="margin-top: 30px;">
		<div class="container" >
		<section class="float-center">
			<div class="page-info page-info-inner clearfix">
				<div class="breadcrumbs float-right">
					<span>当前位置：</span>
					<a href="/">首页</a><i>&gt;</i>
					<a href="#">资讯文章</a><i>&gt;</i>
					<strong>详情</strong>
				</div>
				<h2 class="page-name">资讯详情</h2>
			</div>

			<div class="content-wrap">

				<!-- S article-detail -->
				<article class="article-detail video-detail">
					<div class="article-title">
						<h1>{$title}</h1>
					</div>
					<div class="entry-meta">
						<span>作者：<strong>{$author}</strong></span>
						<span>时间：<strong>{$published}</strong></span>
					</div>


					<div class="article-content">
						<div class="typography-text">
							<p><img src="{$image}" alt=""></p>
							{$text}
						</div>
					</div>
					{if $fujians neq ''}
					<div class="detail-file-download">
						<h4>附件下载：</h4>
						<ul class="list-line-simple">
							{foreach item=fujian_info from=$fujians}
								<li><a href="{$fujian_info.download_src}">{$fujian_info.name}</a></li>
							{/foreach}
						</ul>
					</div>
					{/if}


					<div class="nav-next-prev">
						<ul class="clearfix">
							{if $prev_artical neq ''}
								<li class="prev-page">
									<a href="artical.php?record={$prev_artical.key}">
										<em>上一篇</em>
										<strong>{$prev_artical.title}</strong>
									</a>
								</li>
							{else}
								<li class="prev-page prev-page-disabled">
                                	<span>
                                    	<em>上一篇</em>
                                        <strong>已经没有了！</strong>
                                    </span>
								</li>
							{/if}

							{if $next_artical neq ''}
								<li class="next-page">
									<a href="artical.php?record={$next_artical.key}">
										<em>下一篇</em>
										<strong>{$next_artical.title}</strong>
									</a>
								</li>
							{else}
								<li class="next-page next-page-disabled">
                                	<span>
                                    	<em>下一篇</em>
                                        <strong>已经没有了！</strong>
                                    </span>
								</li>
							{/if}

						</ul>
					</div>


				</article>
			</div>
		</section>
	</div>
	</div>
	{include file="footer.tpl"}
</div>

<div class="gotop gotop-fixed"><a href="#" title="返回顶部"><span>返回顶部</span></a></div>

</body>
</html>
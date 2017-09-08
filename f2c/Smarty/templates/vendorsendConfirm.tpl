

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>发货完成</title>
	<link href="public/css/mui.css" rel="stylesheet" />
	<link href="public/css/public.css" rel="stylesheet" />
	<link href="public/css/iconfont.css" rel="stylesheet" />
	<script src="public/js/mui.min.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript" src="public/js/jweixin.js"></script>
	<script src="public/js/zepto.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="public/js/utils.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript" src="public/js/jweixin.js"></script>
	<style>
		{literal}
		.img-responsive {
			display: block;
			height: auto;
			width: 100%;
		}

		.menuicon {
			font-size: 1.4em;
			color: #fe4401;
			padding-right: 10px;
		}

		.menuitem a {
			font-size: 1.3em;
		}

		.mui-checkbox.mui-left label {
			padding-right: 3px;
			padding-left: 35px;
		}

		.mui-checkbox.mui-left input[type='checkbox'] {
			left: 3px;
		}

		.mui-table-view .mui-media-object {
			line-height: 100px;
			max-width: 100px;
			height: 100px;
		}

		.mui-input-row {
			margin: 2px;
		}

		.mui-input-group .mui-input-row:after {
			left: 0px;
		}

		.mui-input-row .mui-numbox {
			float: left;
			margin: 2px 2px;
		}

		.mui-numbox {
			width: 120px;
			height: 30px;
			padding: 0 40px 0 40px;
		}

		.mui-card .mui-ellipsis {
			margin-bottom: 0px;
		}

		.tishi {
			color: #fe4401;
			width: 100%;
			text-align: center;
			padding-top: 10px;
		}

		.tishi .mui-icon {
			font-size: 4.4em;
		}

		.msgbody {
			width: 100%;
			font-size: 1.4em;
			line-height: 25px;
			color: #333;
			text-align: center;
			padding-top: 10px;
		}

		.msgbody a {
			font-size: 1.0em;
		}

		.mui-bar-tab .mui-tab-item .mui-icon {
			width: auto;
		}

		.mui-bar-tab .mui-tab-item, .mui-bar-tab .mui-tab-item.mui-active {
			color: #cc3300;
		}

		.mui-ellipsis {
			line-height: 17px;
		}

		.price {
			color: #fe4401;
		}

		.deleteshoppingcart {
			color: #cc3300;
			font-size: 1.1em;
		}

		.deleteshoppingcart span {
			font-size: 1.1em;
		}
		header.mui-bar{
			background: #f9f9f9;
		}
		{/literal}
	</style>
	{include file='theme.tpl'}
</head>

	<body>
		<div class="mui-off-canvas-wrap mui-draggable" id="offCanvasWrapper">
			<div class="mui-inner-wrap">
				<header class="mui-bar mui-bar-nav" style="padding-right: 15px;">
					 <h1 class="mui-title" id="pagetitle">发货完成</h1>
				</header>
				<nav class="mui-bar mui-bar-tab">
					<center><button type="button" class='mui-btn mui-btn-danger mui-action-back'>关闭</button></center>
				</nav>
		        <div id="pullrefresh" class="mui-content mui-scroll-wrapper" style="padding-top: 44px;">
		                <div class="mui-scroll">
							<div class="mui-card" style="margin: 0 3px;">
						         <ul class="mui-table-view">
                                     <div class="mui-content-padded">
                                         <p class="tishi"><span class="mui-icon iconfont icon-tishi"></span></p>
                                         <p class="msgbody">{$showmsg}<br>
                                         </p>
                                     </div>
								 </ul>
					    </div>
					</div>
				</div>
		    </div>
	    </div>
</body>
</html>

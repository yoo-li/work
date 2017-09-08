<!DOCTYPE html>
<html> 
	<head>
		<meta charset="utf-8">
		<title>报销</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black"> 
		<!--标准mui.css-->
		<link rel="stylesheet" href="/public/css/mui.min.css">
	    <link href="/public/css/public.css" rel="stylesheet" />  
		<link href="/public/css/iconfont.css" rel="stylesheet" />
		<!--App自定义的css-->
		<link rel="stylesheet" type="text/css" href="/public/css/tezan.css" />
		<style>
		{literal}
			p {
				text-indent: 22px;
				padding: 5px 8px;
			}
			
			html,
			body,
			.mui-content {
				background-color: #fff;
			}
			
			h4 {
				margin-left: 5px;
			}
			
			.mui-plus header.mui-bar {
				display: none;
			}
			
			.mui-plus .mui-bar-nav~.mui-content {
				padding: 0;
			}  
		{/literal}
		</style>
	</head>

	<body>
		<header class="mui-bar mui-bar-nav">
			<a id="returnback" class="mui-icon mui-icon-left-nav mui-pull-left"></a>
			<h1 class="mui-title">报销</h1>
		</header>
		<div class="mui-content">
			<div class="mui-content-padded">  
				<p>当前模块正在开发中...
				</p> 	
			</div>
		</div>
		<script src="/public/js/mui.min.js"></script>
		<script type="text/javascript" charset="utf-8" src="/public/js/cordova.js"></script>
		<script type="text/javascript" charset="utf-8">
		{literal}
			mui.init({
				gestureConfig: {
					longtap: true
				},
				swipeBack: false //启用右滑关闭功能
			});
			//处理点击事件，需要打开原生浏览器
			mui('body').on('tap', 'a', function(e) {
				var href = this.getAttribute('href');
				if (href) {
					if (window.plus) {
						plus.runtime.openURL(href);
					} else {
						location.href = href;
					}
				}
			}); 
			document.getElementById('returnback').addEventListener('tap', function() {
				 Cordova.exec(null, null, "PhoneGapPlugin", "PluginFunction", [{"type":"historyback"}]); 
			});
		{/literal}
		</script>
	</body>

</html>
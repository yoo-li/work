<!DOCTYPE html>
<html> 
	<head>
		<meta charset="utf-8">
		<title>帮助中心</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<link rel="stylesheet" href="/public/css/mui.min.css">
		<style type="text/css">
		{literal}
			#list {
				/*避免导航边框和列表背景边框重叠，看起来像两条边框似得；*/
				margin-top: -1px;
			}
		{/literal}
		</style>
	</head> 
	<body>
		<div class="mui-content">
			<ul id="list" class="mui-table-view mui-table-view-chevron">
				<li class="mui-table-view-divider">常见问题</li>
				<li class="mui-table-view-cell">
					<a class="mui-navigate-right" href="help.php?id=1">
						企业特赞给您解决什么问题？
					</a>
				</li>
				<li class="mui-table-view-cell mui-collapse">
					<a class="mui-navigate-right" href="#">
						企业特赞的产品优势
					</a>
					<ul class="mui-table-view mui-table-view-chevron">
						<li class="mui-table-view-cell">
							<a class="mui-navigate-right" href="help.php?id=2">
								原生与Web的混合架构
							</a>
						</li>
						<li class="mui-table-view-cell">
							<a class="mui-navigate-right" href="help.php?id=3">
								所有图标为矢量图标
							</a>
						</li>
						<li class="mui-table-view-cell">
							<a class="mui-navigate-right" href="help.php?id=4">
								所有网络请求都异步操作
							</a>
						</li> 
					</ul>
				</li> 
			</ul>  
		</div>
		<script src="/public/js/mui.min.js"></script> 
		<script> 
		{literal}
			mui.init({
				swipeBack: false,
				statusBarBackground: '#f7f7f7',
				gestureConfig: {
					doubletap: true
				} 
			});  
		{/literal}
	</body> 
</html>

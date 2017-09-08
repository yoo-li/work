<!DOCTYPE html>
<html> 
	<head>
		<meta charset="utf-8">
		<title>意见反馈</title>
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
				<li class="mui-table-view-divider">请选择问题发生的场景</li>
				<li class="mui-table-view-cell">
					<a class="mui-navigate-right" href="opinion.php?id=100">
						闪退、卡顿或界面错位
					</a>
				</li>
				<li class="mui-table-view-cell mui-collapse">
					<a class="mui-navigate-right" href="#">
						聊天
					</a>
					<ul class="mui-table-view mui-table-view-chevron">
						<li class="mui-table-view-cell">
							<a class="mui-navigate-right" href="opinion.php?id=101">
								收发文字消息
							</a>
						</li>
						<li class="mui-table-view-cell">
							<a class="mui-navigate-right" href="opinion.php?id=102">
								发送图片消息
							</a>
						</li>
						<li class="mui-table-view-cell">
							<a class="mui-navigate-right" href="opinion.php?id=103">
								接受图片消息
							</a>
						</li> 
						<li class="mui-table-view-cell">
							<a class="mui-navigate-right" href="opinion.php?id=104">
								收发语音消息
							</a>
						</li>
						<li class="mui-table-view-cell">
							<a class="mui-navigate-right" href="opinion.php?id=105">
								表情
							</a>
						</li>
					</ul>
				</li> 
				<li class="mui-table-view-cell mui-collapse">
					<a class="mui-navigate-right" href="#">
						工作台
					</a>
					<ul class="mui-table-view mui-table-view-chevron">
						<li class="mui-table-view-cell">
							<a class="mui-navigate-right" href="opinion.php?id=111">
								列表模式工作台异常
							</a>
						</li>
						<li class="mui-table-view-cell">
							<a class="mui-navigate-right" href="opinion.php?id=112">
								九宫格模式工作台异常
							</a>
						</li>
						<li class="mui-table-view-cell">
							<a class="mui-navigate-right" href="opinion.php?id=113">
								没有红点提示
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

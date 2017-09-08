<!DOCTYPE html>
<html> 
	<head>
		<meta charset="utf-8">
		<title>帮助</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black"> 
		<!--标准mui.css-->
		<link rel="stylesheet" href="/public/css/mui.min.css">
	    <link href="/public/css/public.css" rel="stylesheet" />  
		<link href="/public/css/iconfont.css" rel="stylesheet" />
		<!--App自定义的css-->
		<link rel="stylesheet" type="text/css" href="/public/css/tezan.css" />
		
		{include file='theme.tpl'}  
		<style>
		{literal}
		.tishi
		{
			color:#fe4401; 
			width:100%; 
			text-align:center;
			padding-top:10px;
		}
		.tishi .mui-icon
		{ 
			font-size: 4.4em; 
		}
		.msgbody
		{ 
			width:100%;
			font-size: 1.4em;
			line-height: 25px;
			color:#333;
			text-align:center;
			padding-top:10px;
		} 
		.msgbody a 
		{   
			font-size: 1.0em; 
		} 
		{/literal}
		</style> 
		
	</head>

	<body> 
		<div class="mui-content">
		    <div class="mui-content-padded">
			   		  <p class="tishi"><span class="mui-icon iconfont icon-tishi"></span></p>
				      <p class="msgbody" style="text-indent:2em;text-align:left;">
						  感谢您的参与！帮助内容正在完善中...<br> 
					  </p>  
					  <br> 
	                  <a id="returnback" href="javascript:;"><h4  class="show-content" style="padding: 10px;">返回</h4></a>
				     
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
			 
			document.getElementById('returnback').addEventListener('tap', function(event) {
				setTimeout(returnback,100);
				event.preventDefault()
				Cordova.exec(null, null, "PhoneGapPlugin", "PluginFunction", [{"type":"historyback"}]);
				//alert(cordova.require('cordova/exec').nativeFetchMessages());
			});
		{/literal}
		</script>
	</body>

</html>
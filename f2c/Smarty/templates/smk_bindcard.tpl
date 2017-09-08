<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
	<title>惠民商城 </title>
	<script src="public/js/mui.min.js"></script>
	<link href="public/css/mui.min.css" rel="stylesheet"/>
	<link href="public/css/public.css" rel="stylesheet" />
	<link href="public/css/reset.css" rel="stylesheet"/>
	<link href="public/css/center.css" rel="stylesheet"/>
	<link href="public/css/iconfont.css" rel="stylesheet" />
	<script type="text/javascript" charset="utf-8">
		{literal}
		mui.init();
		mui.ready(function() {
			mui('.mui-inner-wrap').on('tap','a',function(e){
				mui.openWindow({
					url: this.getAttribute('href'),
					id: 'info'
				});
			});

			mui('.mui-inner-wrap').on('tap','button',function(e){
				var mychoice=mui("#mycheckboxchoice")[0];
				if(mychoice.checked) {
					var card = mui("#card")[0].value;
					var word = mui("#word")[0].value;
					mui("#bind")[0].setAttribute("disabled",true);
					mui("#bind")[0].innerHTML="提交中";
					if(card.length==15) {
						mui.ajax('/smk_bindcard.ajax.php', {
							data: {
								card: card, //卡号
								word: word  //密码
							},
							type: 'post',//HTTP请求类型
							success: function (data) {
								//服务器返回响应，根据响应结果，分析是否登录成功；登陆成功
								if (data == 200) {
									mui.alert("恭喜您，绑定成功！", " ", "确定", function (e) {
										mui("#bind")[0].removeAttribute("disabled");
										mui("#bind")[0].innerHTML = "绑定";
										var self = window.location.href;
										if (document.referrer.indexOf("confirmpayment") > 0) {
											mui.openWindow({
												url: "confirmpayment.php" + "?" + self.substring(self.indexOf("?") + 1),
												id: "confirmpayment.php"
											})
										} else {
											//self.location='smk_mycard.php';
											mui.openWindow({
												url: 'smk_mycard.php',
												id: 'smk_mycard.php'
											})
										}
									});
								}else if(data == 203){
									//登陆失败；
									mui.alert("卡号不能少于15位，请重新提交！", " ", "确定");
									mui("#bind")[0].removeAttribute("disabled");
									mui("#bind")[0].innerHTML = "绑定";
								}else{
									mui.alert("卡号或密码错误，请重新提交！", " ", "确定");
									mui("#bind")[0].removeAttribute("disabled");
									mui("#bind")[0].innerHTML = "绑定";
								}
							},
							error: function (xhr, type, errorThrown) {
								//异常处理；
								mui.alert("卡号或密码错误，请重新提交！", " ", "确定");
								mui("#bind")[0].removeAttribute("disabled");
								mui("#bind")[0].innerHTML = "绑定";
							}
						});
					}else{
						//输入商城卡号不等于15位
						mui.alert("卡号不能少于15位，请重新提交！", " ", "确定");
						mui("#bind")[0].removeAttribute("disabled");
						mui("#bind")[0].innerHTML = "绑定";
					}
				}else{
					mui.alert("请先阅读并同意《使用许可协议》", " ", "确定");
				}
			});
		});
		window.onload = function(){
			mui('.mui-scroll-wrapper').scroll({
				deceleration: 0.0005 //flick 减速系数，系数越大，滚动速度越慢，滚动距离越小，默认值0.0006
			});
		}
		{/literal}
	</script>
	<script type="text/javascript">
		{literal}
		!function(){function a(){document.documentElement.style.fontSize=document.documentElement.clientWidth/6.4+"px";if(document.documentElement.clientWidth>=640)document.documentElement.style.fontSize='100px';}var b=null;window.addEventListener("resize",function(){clearTimeout(b),b=setTimeout(a,300)},!1),a()}(window);
		{/literal}
	</script>
	<style>
		{literal}
		.mui-bar-tab~.mui-content{ background: #f9f9f9; }
		.mui-table-view-cell span{ color:#000 }
		header{
			color: #232326;;
			font-size: 17px;
		}
		.mui-off-canvas-wrap .mui-bar.mui-bar-nav {
			background-color: #f9f9f9;
		}
		.mui-off-canvas-wrap .mui-bar.mui-bar-nav{
			color: #232326;
			font-size: 17px;
		}
		.card p {
			margin-top: .05rem;
			color: #000;
		}
		{/literal}
	</style>
</head>
<body>
<div class="mui-off-canvas-wrap mui-draggable">
	<!-- 主页面容器 -->
	<div class="mui-inner-wrap" style="background-color:#fff;">
		<!-- 菜单容器 -->
		<aside class="mui-off-canvas-left" id="offCanvasSide">
			<style>
				<!--
				.user-info .mui-ellipsis .iconfont {ldelim}width:18px;color: #fff; {rdelim}
				-->
			</style>
			<div class="mui-scroll-wrapper">
				<div class="mui-scroll">
					<!-- 菜单具体展示内容 -->
					<div class="user-info">
						{if $profile_info.profileid neq 'anonymous'}
						{if $profile_info.givenname neq ''}
						<a href="javascript:;">
							<img class="mui-media-object mui-pull-left" src="{$profile_info.headimgurl}">
							<div class="mui-media-body">
								{$profile_info.givenname}，您好！
								<p class='mui-ellipsis' >等级：{include file='profilerank.tpl'}</p>

							</div>
						</a>

						{else}
						<a href="javascript:;">
							<img class="mui-media-object mui-pull-left" src="{if $supplier_info.logo neq ''}{$supplier_info.logo}{else}images/logo.png{/if}">
							<div class="mui-media-body">
								尊敬的客人，您好！<br>
								<p class='mui-ellipsis'>关注之后内容更精彩!</p>
							</div>
						</a>
						{/if}

						{else}
						<a href="javascript:;">
							<img class="mui-media-object mui-pull-left" src="{if $businesse_info.logo neq ''}{$businesse_info.logo}{else}images/logo.png{/if}">
							<div class="mui-media-body">
								{$businesse_info.businessename}
								<p class='mui-ellipsis'>注册之后内容更精彩!</p>
							</div>
						</a>
						<p>{$businesse_info.share_description}</p>
						<p style="text-align: center;">
							<a href="login.php" class="mui-btn mui-btn-outlined mui-btn-primary">登陆 </a>
							<a href="register.php" class="mui-btn mui-btn-outlined mui-btn-primary">注册 </a>
						</p>
						{/if}
					</div>
					<ul class="mui-table-view mui-table-view-chevron mui-table-view-inverted">
						<li class="mui-table-view-cell">
							<a href="index.php" class="mui-navigate-right mui-ellipsis"><span class="mui-icon iconfont icon-mainpage"></span> 店铺首页 </a>
						</li>
						{assign var="badges" value=$share_info.badges}

						<li class="mui-table-view-cell">
							<a href="orders_receipt.php" class="mui-navigate-right mui-ellipsis">
								<span class="mui-icon iconfont icon-daichulidingdan"></span> 我的待处理订单{if $badges.new_order eq 'yes'}<span style="font-size: 20px;padding: 1px 3px;" class="mui-badge mui-badge-danger iconfont icon-newbadge"></span>{/if}
								<span class="left-desc"></span>
							</a>
						</li>
						<li class="mui-table-view-cell">
							<a href="orders_payment.php" class="mui-navigate-right mui-ellipsis">
								<span class="mui-icon iconfont icon-dingdan"></span> 全部已付款订单
								<span class="left-desc"></span>
							</a>
						</li>
						{if $supplier_info.allowtakecash eq '1'}
						<li class="mui-table-view-cell">
							<a href="takecashs.php" class="mui-navigate-right mui-ellipsis">
								<span class="mui-icon iconfont icon-money"></span> 提现申请
								<span class="left-desc"></span>
							</a>
						</li>
						{/if}
						<li class="mui-table-view-cell">
							<a href="mycollections.php" class="mui-navigate-right mui-ellipsis">
								<span class="mui-icon iconfont icon-shoucang"></span> 我的收藏
								<span class="left-desc"></span>
							</a>
						</li>
						{if $supplier_info.showfubisi eq '0'}
						<li class="mui-table-view-cell">
							<a href="fubusi.php" class="mui-navigate-right mui-ellipsis">
								<span class="mui-icon iconfont icon-fubushi"></span> 福布斯榜
								<span class="left-desc"></span>
							</a>
						</li>
						{/if}
						<li class="mui-table-view-cell">
							<a href="contactus.php" class="mui-navigate-right mui-ellipsis">
								<span class="mui-icon iconfont icon-lianxiwomen"></span> 联系我们
								<span class="left-desc"></span>
							</a>
						</li>
						{if $sysinfo.http_user_agent eq 'tezan'}
						{assign var="copyrights" value=$supplier_info.copyrights}
						<script type="text/javascript" charset="utf-8" src="/public/js/cordova.js"></script>
						<li class="mui-table-view-cell">
							<a id="back_tezan" class="mui-navigate-right mui-ellipsis">
								<span class="mui-icon iconfont icon-logo"></span> 返回{$copyrights.trademark}
								<span class="left-desc"></span>
							</a>
						</li>
						<script type="text/javascript">
							{literal}
							mui.ready(function() {
								document.getElementById('back_tezan').addEventListener('tap', function() {
									Cordova.exec(null, null, "PhoneGapPlugin", "PluginFunction", [{"type":"historyback"}]);
								});
							});
							{/literal}
						</script>
						{/if}
					</ul>
				</div>
			</div>
		</aside>
		<!-- 主页面标题 -->
		<header class="mui-bar mui-bar-nav mui-row" style="background-color:#F4F4F4;">
			<a class="mui-icon mui-action-menu mui-icon-bars mui-pull-left" href="#offCanvasSide" style="color:#232326"></a>
			绑定惠民商城卡
		</header>
		<!-- 主页面内容容器 -->
		<div style="padding:50px 8px 100px 8px;">
			<form class="mui-input-group"  style="font-size: 16px">
				<br>
				请输入惠民商城卡编号:<br>
				<input type="number" id=" i" class="mui-input-clear" placeholder="请输入商城卡背面卡号"  style="border:1px solid #aaa;background-color:#fff;margin-top: 10px;font-size: 15px;"><br><br>
				请输入惠民商城卡密码:<br><br>
				<input type="text" id="word" class="mui-input-clear" placeholder="请刮开卡背面图层输入密码"  style="border:1px solid #aaa;background-color:#fff;margin:-8px auto;font-size: 15px;"><br><br><br>
				<div style="text-align: center;">
					<input name="checkbox" type="checkbox" id="mycheckboxchoice"  style="display:inline-block;vertical-align:middle; margin-top:-2px; margin-bottom:0px;">
					<span  style="font-size: 12px;">您已阅读并同意<a href="smk_sckagreement.php" style="color:#f00;text-decoration: underline">《惠民商城卡平台使用许可协议》</a></span>
				</div>
				<button id="bind" type="button" class="mui-btn mui-btn-danger"  style="border-radius: 0px;width:100%;margin-top:10px;">绑定</button>
			</form>
			<br>
			<br><br>
		</div>
	</div>
</div>
</body>
</html>

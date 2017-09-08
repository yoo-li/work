<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
	<title>事务官</title>
	<link rel="stylesheet" href="/public/css/mui.min.css">
    <link href="/public/css/public.css" rel="stylesheet" />
    <link href="/public/css/common.css" rel="stylesheet" />
	<link href="/public/css/iconfont.css" rel="stylesheet"/>
	<script src="/public/js/mui.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="/public/js/zepto.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/public/js/utils.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript" charset="utf-8" src="/public/js/cordova.js"></script>
	<style>
		{literal}
		  .img-responsive { display: block; height: auto; width: 100%; }
	  	  .mui-input-row label {
	  		  line-height: 21px;
	  		  height: 21px;
	  	  }
		  .menuicon
		  {
		 		color:#fe4401;
		 		padding-right:5px;
		  }
		  .mui-grid-view .mui-media {
		    color: #fe4401;
		    padding: 5px;
		  }
		  #orders .mui-table-view.mui-grid-view .mui-table-view-cell {
		    padding: 10px 0 5px 0;
			font-size: 1.4em;
		  }
		  #orders .mui-table-view.mui-grid-view .mui-table-view-cell .mui-icon {
			font-size: 2.0em;
		  }
		  #orders .mui-table-view.mui-grid-view .mui-table-view-cell .mui-media-body {
		    font-size: 12px;
		    text-overflow: clip;
		    color: #333;
		  }
		  #orders .mui-icon .mui-badge {
		    font-size: 10px;
		    line-height: 1.4;
		    position: absolute;
		    top: 0px;
		    left: 100%;
		    margin-left: -40px;
		    padding: 1px 5px;
		    color: red;
		    background: white;
			border: 1px solid red;
		  }

		{/literal}
	</style>
	{include file='theme.tpl'}
</head>
<body>

	<div class="mui-inner-wrap">
		<header class="mui-bar mui-bar-nav" style="padding-right: 15px;">
		    <a href="/official/index.php" class="mui-icon mui-icon-back mui-pull-left"></a>
			<h1 class="mui-title">事务官企业管理系统</h1>
		</header>
         <div id="pullrefresh" class="mui-content mui-scroll-wrapper" style="padding-top: 50px;">
                 <div class="mui-scroll">
  					 <div class="mui-card" style="margin: 3px 3px;">
 				         <ul id="orders" class="mui-table-view" style="padding-top: 5px;text-align:center;">
	                             <li class="mui-table-view-cell">
	                                 <a href="pendingapproval.php" class="mui-navigate-right">
										<div class="mui-media-body  mui-pull-left">
											<span class="mui-icon iconfont icon-bangzhu menuicon button-color"></span>通用审批
										</div>
										<div class="mui-media-body  mui-pull-right" style="color:#888;padding-right:20px;">
											{if $badges.centerapprovals gt 0}<span class="mui-badge mui-badge-danger">{$badges.centerapprovals}</span>{/if}  查看我的审批
										</div>
									</a>
	                             </li>
	                             <li class="mui-table-view-cell">
	                                 <a href="approval.php" class="mui-navigate-right">
										<div class="mui-media-body  mui-pull-left">
											<span class="mui-icon iconfont icon-bangzhu menuicon button-color"></span>待我审核
										</div>
										<div class="mui-media-body  mui-pull-right" style="color:#888;padding-right:20px;">
											{if $badges.approval gt 0}<span class="mui-badge mui-badge-danger">{$badges.approval}</span>{/if}  查看待我审核
										</div>
									</a>
	                             </li>

	                             <li class="mui-table-view-cell">
	                                 <a href="treat.php" class="mui-navigate-right">
										<div class="mui-media-body  mui-pull-left">
											<span class="mui-icon iconfont icon-shangpin menuicon button-color"></span>我要宴请
										</div>
										<div class="mui-media-body  mui-pull-right" style="color:#888;padding-right:20px;">
											查看我要宴请
										</div>
									</a>
	                             </li>
	                             <li class="mui-table-view-cell">
	                                 <a href="orderlist.php" class="mui-navigate-right">
										<div class="mui-media-body  mui-pull-left">
											<span class="mui-icon iconfont icon-shitidian menuicon button-color"></span>购物订单
										</div>
										<div class="mui-media-body  mui-pull-right" style="color:#888;padding-right:20px;">
											查看购物订单
										</div>
									</a>
	                             </li>
	                             <li class="mui-table-view-cell">
	                                 {*<a href="http://{$domain}/supplier.php?supplierid={$supplier_info.supplierid}&profileid={$profileid}&token={$token}" class="mui-navigate-right">*}
	                                 {*<a href="http://{$domain}/supplier.php?supplierid={$supplier_info.supplierid}&profileid={$profileid}&token={$token}" class="mui-navigate-right">*}
					{*http://admin.f2c.com/?parameter=ewogICJwcm9maWxlaWQiIDogImczODI2andhOXl2IiwKICAiYXBwdmVyIiA6ICIxLjAuMCIsCiAgInRpbWVzdGFtcCIgOiAxNDk1MTcwNTQ2LjU2NDY0MSwKICAic3lzbmFtZSIgOiAiaU9TIiwKICAic3lzdmVyIiA6ICIxMC4zIgp9&token=A97D13319D96A4A7849277C6F1FC3D2A#offCanvasSide*}
	                                 <a href="http://admin.f2c.com/supplier.php?parameter=ewogICJwcm9maWxlaWQiIDogImczODI2andhOXl2IiwKICAiYXBwdmVyIiA6ICIxLjAuMCIsCiAgInRpbWVzdGFtcCIgOiAxNDk1MTcwNTQ2LjU2NDY0MSwKICAic3lzbmFtZSIgOiAiaU9TIiwKICAic3lzdmVyIiA6ICIxMC4zIgp9&token=08bebc3abc8b960a059ad9d14ee09585" class="mui-navigate-right">

										<div class="mui-media-body  mui-pull-left">
											<span class="mui-icon iconfont icon-shouyi menuicon button-color"></span>企业内购
										</div>
										<div class="mui-media-body  mui-pull-right" style="color:#888;padding-right:20px;">
											查看企业内购
										</div>
									</a>
	                             </li>
	                             <li class="mui-table-view-cell">
	                                 <a href="authorizationlist.php" class="mui-navigate-right">
										<div class="mui-media-body  mui-pull-left">
											<span class="mui-icon iconfont icon-shitidian menuicon button-color"></span>授权列表
										</div>
										<div class="mui-media-body  mui-pull-right" style="color:#888;padding-right:20px;">
											查看授权列表
										</div>
									</a>
	                             </li>
	                             <li class="mui-table-view-cell">
	                                 <a href="accountbook.php" class="mui-navigate-right">
										<div class="mui-media-body  mui-pull-left">
											<span class="mui-icon iconfont icon-fuwuyuan menuicon button-color"></span>推广积分
										</div>
										<div class="mui-media-body  mui-pull-right" style="color:#888;padding-right:20px;">
											查看推广积分
										</div>
									</a>
	                             </li>
	                             <li class="mui-table-view-cell">
	                                 <a href="qrcodecard.php" class="mui-navigate-right">
										<div class="mui-media-body  mui-pull-left">
											<span class="mui-icon iconfont icon-fuwuyuan menuicon button-color"></span>推广二维码
										</div>
										<div class="mui-media-body  mui-pull-right" style="color:#888;padding-right:20px;">
											查看推广二维码
										</div>
									</a>
	                             </li>
	                             <li class="mui-table-view-cell">
	                                 <a href="supplierexit.php" class="mui-navigate-right">
										<div class="mui-media-body  mui-pull-left">
											<span class="mui-icon iconfont icon-fuwuyuan menuicon button-color"></span>退出企业
										</div>
										<div class="mui-media-body  mui-pull-right" style="color:#888;padding-right:20px;">
											退出当前企业
										</div>
									</a>
	                             </li>

 						 </ul>
 			       </div>
 				   {include file='copyright.tpl'}
 				</div>
 		</div>

	</div>

<script type="text/javascript">
	{literal}
	mui.init({
				 pullRefresh: {
					 container: '#pullrefresh' //待刷新区域标识，querySelector能定位的css选择器均可，比如：id、.class等
				 },
			 });
	mui.ready(function ()
			  {
				  mui('#pullrefresh').scroll();
				  mui('.mui-bar').on('tap', 'a', function (e)
				  {
					  mui.openWindow({
										 url: this.getAttribute('href'),
										 id: 'info'
									 });
				  });
			  });

	{/literal}
</script>
<script src="/public/js/baidu.js?_=20140821" type="text/javascript"></script>
</body>
</html>
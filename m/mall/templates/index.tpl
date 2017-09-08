<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
	<title>商城信息板</title>
	<link rel="stylesheet" href="/public/css/mui.min.css">
    <link href="/public/css/public.css" rel="stylesheet" />
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
		    <a id="returnback" class="mui-icon mui-icon-left-nav mui-pull-left"></a>
			<h1 class="mui-title">商城信息板</h1> 
		</header> 
         <div id="pullrefresh" class="mui-content mui-scroll-wrapper" style="padding-top: 50px;"> 
                 <div class="mui-scroll">  
 					<div class="mui-card" style="margin: 3px 3px;">  
 				         <ul class="mui-table-view" style="text-align:center;background:{$supplier_info.themecolor};color:{$supplier_info.textcolor};">    
 			                        <li class="mui-table-view-cell"> 
 										<div class="mui-media-body  mui-pull-left">
 											<span class="mui-table-view-label">今日订单：</span> <span class="price">{$mall_dynamic_info.today_orders} 笔</span>
 										</div>  
 										<div class="mui-media-body  mui-pull-right">
 											<span class="mui-table-view-label">今日订单金额：</span> <span class="price">￥{$mall_dynamic_info.today_orders_amounts}</span>
 										</div>
 			                        </li> 
 			                        <li class="mui-table-view-cell"> 
 										<div class="mui-media-body  mui-pull-left">
 											<span class="mui-table-view-label">今日待付款：</span> <span class="price">{$mall_dynamic_info.today_pendingpayment_orders} 笔</span>
 										</div>  
 										<div class="mui-media-body  mui-pull-right">
 											<span class="mui-table-view-label">今日待付款金额：</span> <span class="price">￥{$mall_dynamic_info.today_pendingpayment_orders_amounts}</span>
 										</div>
 			                        </li>
 			                        <li class="mui-table-view-cell"> 
 										<div class="mui-media-body  mui-pull-left">
 											<span class="mui-table-view-label">待发货：</span> <span class="price">{$mall_dynamic_info.pending_deliverys} 笔</span>
 										</div>  
 										<div class="mui-media-body  mui-pull-right">
 											<span class="mui-table-view-label">库存预警：</span> <span class="price">{$mall_dynamic_info.warning_inventorys} 个</span>
 										</div>
 			                        </li>
 			                        <li class="mui-table-view-cell"> 
 										<div class="mui-media-body  mui-pull-left">
 											<span class="mui-table-view-label">售后待处理：</span> <span class="price">{$mall_dynamic_info.pending_returnedgoodsapplys} 笔</span>
 										</div>  
 										<div class="mui-media-body  mui-pull-right">
 											<span class="mui-table-view-label">提现待处理：</span> <span class="price">{$mall_dynamic_info.pending_takecashs} 笔</span>
 										</div>
 			                        </li>
 						  </ul> 
 					</div>
 					<div class="mui-card" style="margin: 3px 3px;">  
 						  <ul class="mui-table-view">   
 		                        <li class="mui-table-view-cell"> 
 									<div class="mui-media-body  mui-pull-left">
 										<span class="mui-table-view-label">总会员：</span> <span class="price">{$mall_dynamic_info.total_members} 人</span>
 									</div>  
 									<div class="mui-media-body  mui-pull-right">
 										<span class="mui-table-view-label">今日新增会员：</span> <span class="price">{$mall_dynamic_info.today_members} 人</span>
 									</div>
 		                        </li>
 		                        <li class="mui-table-view-cell"> 
 									<div class="mui-media-body  mui-pull-left">
 										<span class="mui-table-view-label">激活会员：</span> <span class="price">{$mall_dynamic_info.total_activate_members} 人</span>
 									</div>  
 									<div class="mui-media-body  mui-pull-right">
 										<span class="mui-table-view-label">今日新增激活会员：</span> <span class="price">{$mall_dynamic_info.today_activate_members} 人</span>
 									</div>
 		                        </li>  
 		                        <li class="mui-table-view-cell"> 
 									<div class="mui-media-body  mui-pull-left">
 										<span class="mui-table-view-label">今日分享：</span> <span class="price">{$mall_dynamic_info.today_shares} 人</span>
 									</div>  
 									<div class="mui-media-body  mui-pull-right">
 										<span class="mui-table-view-label">今日咨询：</span> <span class="price">{$mall_dynamic_info.today_advices} 人</span>
 									</div>
 		                        </li>
 						  </ul>
 					</div> 
  					<!-- <div class="mui-card" style="margin: 3px 3px;">
  				         <ul id="orders" class="mui-table-view" style="padding-top: 5px;text-align:center;">
 	                             <li class="mui-table-view-cell">
 	                                 <a href="physicalstore_popularize.php" class="mui-navigate-right">
 										<div class="mui-media-body  mui-pull-left">
 											<span class="mui-icon iconfont icon-bangzhu menuicon button-color"></span>如何推广
 										</div>
 										<div class="mui-media-body  mui-pull-right" style="color:#888;padding-right:20px;">
 											多种推广方案供您选择
 										</div>
 									</a>
 	                             </li>
  						 </ul>
  			       </div>   -->
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
				  
	  			document.getElementById('returnback').addEventListener('tap', function() {
	  				 Cordova.exec(null, null, "PhoneGapPlugin", "PluginFunction", [{"type":"historyback"}]); 
	  			});

			  }); 

	{/literal}
</script> 
<script src="/public/js/baidu.js?_=20140821" type="text/javascript"></script>
</body>
</html>
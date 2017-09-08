 

<!DOCTYPE html>
<html> 
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title></title>	
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
	   	 .mui-bar .tit-sortbar{
	   	 	left: 0;
	   	 	right: 0;
	   	 	margin-top: 45px; 
	   	 }
		 .mui-bar .mui-segmented-control {
		   top: 0px; 
		 }
		 .mui-segmented-control.mui-segmented-control-inverted .mui-control-item {
		   color: #333; 
		 } 
	 	 .price {
	 	  color:#fe4401;
	 	 } 
	  	 .mui-table-view-cell .mui-table-view-label
	  	 {
	  	    width:60px;
	  		text-align:right;
	  		display:inline-block;
	  	 } 
	 {/literal} 
	</style>
	{include file='theme.tpl'} 
</head>
<body>  
<div class="mui-off-canvas-wrap mui-draggable" id="offCanvasWrapper"> 
		<div class="mui-inner-wrap">
			<header class="mui-bar mui-bar-nav" style="padding-right: 15px;">  
				  {*<a class="mui-icon mui-action-back mui-icon-back mui-pull-left"></a>*}
				<a id="returnback" class="mui-icon mui-icon-left-nav mui-pull-left"></a>
				  <h1 class="mui-title">我的积分</h1>
                 <div class="mui-title mui-content tit-sortbar" id="sortbar"> 
		 				<div id="segmentedControl" class="mui-segmented-control mui-segmented-control-inverted mui-segmented-control-negative">
		 					<a class="mui-control-item mui-active" href="accountbook.php">积分明细</a>
		 					<a class="mui-control-item" href="billwaters.php">积分流水</a> 
		 				</div> 
                 </div>
			</header>  
	        <div id="pullrefresh" class="mui-content mui-scroll-wrapper" style="padding-top: 85px;">  
                    <div class="mui-scroll">   
   		                 <div id="list" class="mui-table-view" >     
		 		 							<ul class="mui-table-view" style="padding-top: 5px;padding-bottom: 5px;">
												<div class="mui-card" style="margin: 3px 3px;"> 
												 <li class="mui-table-view-cell"> 
														<div class="mui-media-body  mui-pull-left">
															<span class="mui-table-view-label">可用资金：</span><span class="price">¥{$profile_info.money}</span>
														</div> 
				                                </li> 
												 <li class="mui-table-view-cell"> 
														<div class="mui-media-body  mui-pull-left">
															<span class="mui-table-view-label">累积收益：</span><span class="price">¥{$profile_info.accumulatedmoney}</span>
														</div> 
				                                </li>  
				                                <li class="mui-table-view-cell"> 
														<div class="mui-media-body  mui-pull-left">
															<span class="mui-table-view-label">冻结资金：</span> <span class="price">¥{$frozencommission}</span>
														</div>  
				                                </li>
											    </div>
												<div class="mui-card" style="margin: 3px 3px;">
				                                <li class="mui-table-view-cell">
				                                    <a href="profit_share.php" class="mui-navigate-right deliveraddress"> 
														<div class="mui-media-body  mui-pull-left">
															<span class="mui-table-view-label">分享收益：</span> <span class="price">¥{$share}</span>
														</div> 
													</a>
				                                </li>
				                                <li class="mui-table-view-cell">
				                                    <a href="profit_commission.php" class="mui-navigate-right deliveraddress"> 
														<div class="mui-media-body  mui-pull-left">
															<span class="mui-table-view-label">提成收益：</span> <span class="price">¥{$totalcommission}</span>
														</div> 
													</a>
				                                </li>
				                                <li class="mui-table-view-cell">
				                                    <a href="profit_popularize.php" class="mui-navigate-right deliveraddress"> 
														<div class="mui-media-body  mui-pull-left">
															<span class="mui-table-view-label">推广收益：</span> <span class="price">¥{$popularize}</span>
														</div> 
													</a>
				                                </li>
												 </div>
												<div class="mui-card" style="margin: 3px 3px;">
				                                <li class="mui-table-view-cell"> 
														<div class="mui-media-body  mui-pull-left">
															<span class="mui-table-view-label">总收益：</span> <span class="price">¥{$total}</span>
														</div>  
				                                </li>
												</div>
		 		 							</ul> 
						 </div>    

						{include file='copyright.tpl'}
                 </div>
			</div>
	    </div> 
 </div>
<script type="text/javascript">
    {literal}
    mui.ready(function ()
    {

        document.getElementById('returnback').addEventListener('tap', function() {
//                console.log(111111);
            Cordova.exec(null, null, "PhoneGapPlugin", "PluginFunction", [{"type":"historyback"}]);
        });

    });
    {/literal}
</script>
	<script type="text/javascript"> 
	{literal}	 
	    mui.init({
	        pullRefresh: {
	            container: '#pullrefresh', //待刷新区域标识，querySelector能定位的css选择器均可，比如：id、.class等  
	        },
	    });
		mui.ready(function() {  
			mui('#pullrefresh').scroll();
			mui('.mui-bar').on('tap','a',function(e){
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
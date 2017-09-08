 

<!DOCTYPE html>
<html> 
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>历史申请记录</title>
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
	{include file='theme.tpl'} 
</head>
<body>  
<div class="mui-off-canvas-wrap mui-draggable" id="offCanvasWrapper"> 
			<div class="mui-inner-wrap">
			<header class="mui-bar mui-bar-nav" style="padding-right: 15px;">  
				  <a class="mui-icon mui-action-back mui-icon-back mui-pull-left"></a>
				  <h1 class="mui-title">提现</h1>
                  <div class="mui-title mui-content tit-sortbar" id="sortbar"> 
		 				<div id="segmentedControl" class="mui-segmented-control mui-segmented-control-inverted mui-segmented-control-negative">
		 					<a class="mui-control-item" href="takecashs.php">提现申请</a>
		 					<a class="mui-control-item mui-active" href="takecashlogs.php">历史提现记录</a>
		 				</div> 
                 </div>
			</header> 
			{include file='footer.tpl'}   
	        <div id="pullrefresh" class="mui-content mui-scroll-wrapper" style="padding-top: 85px;">  
                    <div class="mui-scroll">  
						<input id="page" value="1" type="hidden" > 
   		                 <div class="mui-table-view" >   
		 		 					<ul id="list"  class="mui-table-view" style="padding-top: 1px;">
										  
		 		 					</ul> 
									<ul class="mui-table-view" style="background-color: #efeff4;">
										<li class="mui-table-view-cell mui-media"> 
												<img class="img-responsive" src="/images/baozhang.png"> 
										</li>
									</ul> 
						 </div>    
                 </div>
			</div>
	    </div> 
</div>   
	      
	<script type="text/javascript"> 
	{literal}	 
	    mui.init({
	        pullRefresh: {
	            container: '#pullrefresh', //待刷新区域标识，querySelector能定位的css选择器均可，比如：id、.class等 
				down: {
					callback: pulldownRefresh
				},
	            up: {
	                contentrefresh: "正在加载...", //可选，正在加载状态时，上拉加载控件上显示的标题内容
	                contentnomore: '没有更多数据了', //可选，请求完毕若没有更多数据时显示的提醒内容；
	                callback: add_more //必选，刷新函数，根据具体业务来编写，比如通过ajax从服务器获取新数据；
	            }
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
		function pulldownRefresh() { 
			Zepto('#sortbar').css("display","none");
			setTimeout(function() {  
				Zepto('#sortbar').css("display","");
	            Zepto('#page').val(1);  
				Zepto('#list').html(''); 
				add_more();
				mui('#pullrefresh').pullRefresh().refresh(true);
				mui('#pullrefresh').pullRefresh().endPulldownToRefresh(); //refresh completed 
			}, 1000);
		}
		
		function takecash_html(v) {	 
				var sb=new StringBuilder();  
sb.append('<div class="mui-card" style="margin: 3px 3px;" >'); 
sb.append('		 <ul class="mui-table-view" style="color: #333;background: #f3f3f3;">');
if (v.takecashsstatus == "驳回申请")
{
	sb.append('				<li class="mui-table-view-cell" style="height:164px;">');  
}
else
{
	sb.append('				<li class="mui-table-view-cell" style="height:144px;">'); 
}
sb.append('							<div class="mui-media-body">'); 
sb.append('								<p class="mui-ellipsis" style="color:#333">开户行：'+v.bank+'</p>');  
sb.append('								<p class="mui-ellipsis" style="color:#333">收款人姓名：'+v.realname+'</p>');  
sb.append('								<p class="mui-ellipsis" style="color:#333">银行账号：'+v.account+'</p>');  
sb.append('								<p class="mui-ellipsis" style="color:#333">提现金额：'+v.amount+'</p>');  
sb.append('								<p class="mui-ellipsis" style="color:#333">身份证：'+v.idcard+'</p>');  
sb.append('								<p class="mui-ellipsis" style="color:#333">提现日期：'+v.published+'</p>'); 
if (v.takecashsstatus == "驳回申请")
{
	sb.append('								<p class="mui-ellipsis" style="color:#333">驳回原因：'+v.rejectreason+'</p>'); 
}

sb.append('							</div> '); 
sb.append('				 </li> ');
sb.append('				 <li class="mui-table-view-cell order-link-cell"> ');
sb.append('					<div class="mui-media-body  mui-pull-left">');
sb.append('						 <a style="padding-left:15px;">处理状态：'+v.takecashsstatus+'</a>'); 
sb.append('					</div> '); 
sb.append('               </li>');
sb.append(' 	 	</ul>'); 
sb.append('</div>');  
				 return sb.toString(); 
		 }
		
	 
		
		
		 function takecash_empty_html() 
		 {
var sb=new StringBuilder();  
sb.append('<div class="mui-content-padded">'); 
sb.append('				   		  <p class="tishi"><span class="mui-icon iconfont icon-tishi"></span></p>'); 
sb.append('					      <p class="msgbody">您还没有提现记录,先去挣点钱吧!<br>');  
sb.append('						  </p>  '); 
sb.append(' </div>'); 
return sb.toString(); 
		 }
		   										   
		 
	    function add_more() {
			var page = Zepto('#page').val();
	            Zepto('#page').val(parseInt(page,10) + 1);
	            mui.ajax({
	                type: 'POST',
	                url: "takecashlogs.ajax.php",
	                data: 'page=' + page,
	                success: function(json) {   
	                    var msg = eval("("+json+")");
	                    if (msg.code == 200) {  
							if (msg.data.length == 0 && page == 1)
							{
								  Zepto('#list').html(takecash_empty_html()); 
								  mui('#pullrefresh').pullRefresh().endPullupToRefresh(true); //参数为true代表没有更多数据
							}
							else
							{
		                        Zepto.each(msg.data, function(i, v) {    
									    var nd = takecash_html(v); 
			                            Zepto('#list').append(nd);  
		                        });    
		                        mui('#pullrefresh').pullRefresh().endPullupToRefresh(false); //参数为true代表没有更多数据了。
							} 
	                    } else {
	                        mui('#pullrefresh').pullRefresh().endPullupToRefresh(true); //参数为true代表没有更多数据了。
	                    }
	                }
	            }); 
	    } 
	    //触发第一页
	    if (mui.os.plus) {
	        mui.plusReady(function() {
	            setTimeout(function() {
	                mui('#pullrefresh').pullRefresh().pullupLoading();
	            }, 1000);

	        });
	    } else {
	        mui.ready(function() {
	            Zepto('#page').val(1); 
	            mui('#pullrefresh').pullRefresh().pullupLoading();
	        });
	    } 
		
	   
	{/literal} 
	</script>
{include file='weixin.tpl'} 
<script src="/public/js/baidu.js?_=20140821" type="text/javascript"></script>
</body> 
</html>
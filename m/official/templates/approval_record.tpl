<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
	<title>审批</title>
	<link rel="stylesheet" href="/public/css/mui.min.css">
    <link href="/public/css/public.css" rel="stylesheet" />
     <link href="/public/css/common.css" rel="stylesheet" />
	<link href="/public/css/iconfont.css" rel="stylesheet"/>
	<link href="/public/css/sweetalert.css" rel="stylesheet"/>
	<script src="/public/js/mui.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="/public/js/zepto.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/public/js/utils.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript" src="/public/js/sweetalert.min.js"></script>
	<script type="text/javascript" charset="utf-8" src="/public/js/cordova.js"></script>
	<style>
		{literal}
		.img-responsive {
			display: block;
			height: auto;
			width: 100%;
		}
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
			color: #fe4401;
		}

		.mui-table-view-cell .mui-table-view-label {
			width: 60px;
			text-align: right;
			display: inline-block;
		}

		.mui-table-view .mui-media-object {
			margin-top: 10px;
		}

		.order-link-cell {
			line-height: 30px;
			height: 30px;
			padding: 0px 5px;
		}

		.order-link-cell a {
			font-size: 12px;
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

		.mui-input-row label {
		     float: none;
			 line-height:45px;
		}
		.mui-input-row input, select, textarea {
		    font-size: 12px;
		}
		{/literal}
	</style>
	{include file='theme.tpl'}
</head>
<body>

	<div class="mui-inner-wrap">
		<header class="mui-bar mui-bar-nav" style="padding-right: 15px;">
			<a id="returnback" class="mui-icon mui-icon-left-nav mui-pull-left"></a>
			<h1 class="mui-title">财务支付</h1>
            <div class="mui-title mui-content tit-sortbar" id="sortbar">
 				<div id="segmentedControl" class="mui-segmented-control mui-segmented-control-inverted mui-segmented-control-negative">
 					<a class="mui-control-item iconfont icon-daishenpi button-color" href="pendingapproval.php">&nbsp;待支付</a>
					<a class="mui-control-item iconfont icon-shenpijilu button-color mui-active" href="approval_record.php">&nbsp;支付记录</a>
 				</div>
            </div>
		</header>
		 <div id="pullrefresh" class="mui-content mui-scroll-wrapper" style="padding-top: 85px;">
			<div class="mui-scroll">
				<div class="mui-table-view">
					<input id="page" value="1" type="hidden">
					<input id="type" value="{$type}" type="hidden">
					<ul id="list" class="mui-table-view" style="padding-top: 5px;padding-bottom: 5px;">
					</ul>
				    <h6 class="mui-content-padded" style="height:3px;margin:0px">&nbsp;</h6>
				</div>
					{include file='copyright.tpl'}
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
	mui.ready(function ()
			  {
       //返回按钮
				  document.getElementById('returnback').addEventListener('tap', function() {
                      Cordova.exec(null, null, "PhoneGapPlugin", "PluginFunction", [{"type":"historyback"}]);
                  });
				  mui('#pullrefresh').scroll();
				  mui('.mui-bar').on('tap', 'a', function (e)
				  {
					  mui.openWindow({
										 url: this.getAttribute('href'),
										 id: 'info'
									 });
				  });
			  });

		  	function pulldownRefresh()
		  	{
		  		Zepto('#sortbar').css("display","none");
		  		setTimeout(function ()
		  				   {
		  					   Zepto('#sortbar').css("display","");
		  					   Zepto('#page').val(1);
		  					   Zepto('#list').html('');
		  					   add_more();
		  					   mui('#pullrefresh').pullRefresh().refresh(true);
		  					   mui('#pullrefresh').pullRefresh().endPulldownToRefresh(); //refresh completed
		  				   }, 1000);
		  	}

		  	function order_html(v)
		  	{

                var sb = new StringBuilder();
		  		sb.append('<div class="mui-card card_link" style="margin: 3px 3px;" >');
		  		sb.append('		 <ul class="mui-table-view" style="color: #333;background: #f3f3f3;">');
		  		sb.append('				 <li class="mui-table-view-cell order-link-cell">');
		  		sb.append('					<div class="mui-media-body  mui-pull-left">');
		  		sb.append('						<span class="mui-table-view-label">模块：</span>' + v.modulelabel);
		  		sb.append('					</div>');
		  		sb.append('					<div class="mui-media-body mui-pull-right" style="color:red"> ');
		  		sb.append('						 '+ v.translatedreply);
		  		sb.append('					</div> ');
		  		sb.append('                </li>');
		  		sb.append('				<a href="pay_detail.php?id=' + v.record + '" style="display:inline-block;width:100%;"><li class="mui-table-view-cell">');
		  		sb.append('							<div class="mui-media-body">');
		  		sb.append('								<p class="mui-ellipsis" style="color:#333">提交人：' + v.username + '</p>');
				sb.append('								<p class="mui-ellipsis" style="color:#333">提交时间：' + v.submittime + '</p>');
				sb.append('								<p class="mui-ellipsis" style="color:#333">审批时间：' + v.submitapprovalreplydatetime + '</p>');
				sb.append('								<p class="mui-ellipsis" style="color:#333">审批意见：' + v.reply_text + '</p>');
				sb.append('								<p class="mui-ellipsis" style="color:#333">备注：' + v.treatreason + '</p>');
				if(v.treatdatetime){
					sb.append('								<p class="mui-ellipsis" style="color:#333">宴请时间：' + v.treatdatetime + '</p>');
					sb.append('								<p class="mui-ellipsis" style="color:#333">宴请地点：' + v.address + '</p>');
					sb.append('								<p class="mui-ellipsis" style="color:#333">宴请编号：' + v.mall_officialtreats_no + '</p>');
					sb.append('								<p class="mui-ellipsis" style="color:#333">预计费用：' + v.estimatedcost + '</p>');
				}
				if(v.cost){
					sb.append('								<p class="mui-ellipsis" style="color:#333">实际费用：' + v.cost + '</p>');
				}
		  		sb.append('							</div> ');
		  		sb.append('				 </li></a> ');
		  		sb.append(' 	 	</ul>');
		  		sb.append('</div>');
		  		return sb.toString();
		  	}
		  	function order_empty_html()
		  	{
		  		var sb = new StringBuilder();
		  		sb.append('<div class="mui-card" style="margin: 3px 3px;"> ');
		  		sb.append('				   		  <p class="tishi"><span class="mui-icon iconfont icon-tishi"></span></p>');
		  		sb.append('					      <p class="msgbody">您还没有审批记录！<br>');
	  			sb.append('							  <br> ');
				sb.append('						  </p>  ');
		  		sb.append(' </div>');
		  		return sb.toString();
		  	}

		  	function add_more()
		  	{
		  		var page = Zepto('#page').val();
		  		Zepto('#page').val(parseInt(page, 10) + 1);
		  		mui.ajax({
 		  					 type: 'POST',
		  					 url: "approval_record.php",
		  					 data: 'type=ajax&page=' + page,
		  					 success: function (json)
		  					 {
		  						 var msg = eval("(" + json + ")");
		  						 if (msg.code == 200)
		  						 {
 		  							 if (msg.data.length == 0 && page == 1)
		  							 {
		  								 Zepto('#list').html(order_empty_html());
		  								 mui('#pullrefresh').pullRefresh().endPullupToRefresh(true); //参数为true代表没有更多数据
		  							 }
		  							 else
		  							 {
		  								 Zepto.each(msg.data, function (i, v)
		  								 {
		  									 var nd = order_html(v);
		  									 Zepto('#list').append(nd);
		  								 });
		  								 mui('#pullrefresh').pullRefresh().endPullupToRefresh(false); //参数为true代表没有更多数据了。
		  							 }
		  						 }
		  						 else
		  						 {
 		  							 mui('#pullrefresh').pullRefresh().endPullupToRefresh(true); //参数为true代表没有更多数据了。
		  						 }
		  					 },
							 error:function(xhr,type,errorThrown){
									//异常处理；
								}
		  				 });

//                $.ajax({
//                    type: 'POST',
//                    url: 'approval_record.php',
//                    // data to be added to query string:
//                    data: 'type=ajax&page=' + page,
//                    // type of data we are expecting in return:
// 					context: $('body'),
//                    success: function(json){
//                        alert('success_zepto');
//                        var msg = eval("(" + json + ")");
//
//                        Zepto.each(msg.data, function (i, v)
//                        {
//                            alert('order_html');
//                            var nd = order_html(v);
//                            Zepto('#list').append(nd);
//                        });
//                        mui('#pullrefresh').pullRefresh().endPullupToRefresh(false); //参数为true代表没有更多数据了。
//
//                        if (msg.code == 200)
//                        {
//                            alert('200')
//                            if (msg.data.length == 0 && page == 1)
//                            {
//                                Zepto('#list').html(order_empty_html());
//                                mui('#pullrefresh').pullRefresh().endPullupToRefresh(true); //参数为true代表没有更多数据
//                            }
//                            else
//                            {
//                                Zepto.each(msg.data, function (i, v)
//                                {
//                                    alert('order_html');
//                                    var nd = order_html(v);
//                                    Zepto('#list').append(nd);
//                                });
//                                mui('#pullrefresh').pullRefresh().endPullupToRefresh(false); //参数为true代表没有更多数据了。
//                            }
//                        }
//                        else
//                        {
//                            mui('#pullrefresh').pullRefresh().endPullupToRefresh(true); //参数为true代表没有更多数据了。
//                        }
//                    },
//                    error: function(xhr, type){
//                        alert('Ajax error!')
//                    }
//                })
		  	}
		  	//触发第一页
		  	if (mui.os.plus)
		  	{
		  		mui.plusReady(function ()
		  					  {
		  						  setTimeout(function ()
		  									 {
		  										 mui('#pullrefresh').pullRefresh().pullupLoading();
		  									 }, 1000);

		  					  });
		  	}
		  	else
		  	{
		  		mui.ready(function ()
		  				  {
		  					  Zepto('#page').val(1);
		  					  mui('#pullrefresh').pullRefresh().pullupLoading();
		  				  });
		  	}


            		mui('body').on('tap','a',function(){document.location.href=this.href;});

	{/literal}
</script>
<script src="/public/js/baidu.js?_=20140821" type="text/javascript"></script>
</body>
</html>

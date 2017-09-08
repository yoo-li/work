<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link href="public/css/mui.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="public/css/smk_order.css">

	<link href="public/css/public.css" rel="stylesheet"/>
	<link href="public/css/iconfont.css" rel="stylesheet"/>
	<link href="public/css/sweetalert.css" rel="stylesheet"/>
	<script src="public/js/mui.min.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript" src="public/js/jweixin.js"></script>
	<script src="public/js/zepto.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="public/js/common.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript" src="public/js/sweetalert.min.js"></script>
	<script type="text/javascript" src="public/js/jweixin.js"></script>
	<title>我的订单</title>
</head>

<body>
<div class="mui-off-canvas-wrap mui-draggable">
	<div class="mui-inner-wrap">
		<aside class="mui-off-canvas-left" id="offCanvasSide">
			<div class="mui-scroll-wrapper">
				<div class="mui-scroll">
					<!-- 菜单具体展示内容 -->
					<style>
						{literal}
						.mui-table-view-chevron .mui-table-view-cell{
							background: #333;
						}
						.mui-segmented-control.mui-segmented-control-inverted .mui-control-item{
							color: #000;
						}
						.icon-xiaohua:before {
							color: #fff;
						}
						header.mui-bar{
				            background-color: #f9f9f9 !important;
				        }
				        header .mui-title, header a{
				            color: #232326 !important;
				        }
						.mui-bar-tab .mui-tab-item.mui-active{
				        	color: #fb3e21 !important;
				        }
						{/literal}
					</style>
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
					<ul class="mui-table-view mui-table-view-chevron mui-table-view-inverted"">
						<li class="mui-table-view-cell">
							<a href="index.php" class="mui-navigate-right mui-ellipsis"><span class="mui-icon iconfont icon-mainpage"></span> 店铺首页 </a>
						</li>
						<!--<li class="mui-table-view-cell">
                            <a href="usercenter.php" class="mui-navigate-right mui-ellipsis">
                                <span class="mui-icon iconfont icon-gerenzhongxin"></span> 会员中心
                                <span class="left-desc"></span>
                            </a>
                        </li>-->
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
		<header class="mui-bar mui-bar-nav mui-row myorder_header">
			<a class="mui-icon mui-action-menu mui-icon-bars mui-pull-left" href="#offCanvasSide"></a>
			<p class="mui-title">全部已付款订单</p>
		</header>
		{include file='footer.tpl'}
		<div  id="pullrefresh" class="mui-content mui-scroll-wrapper myorder_ul" style="padding-top:88px;margin-bottom:50px;">
			<div class="mui-scroll" style="transform: translate3d(0px, 0px, 0px) translateZ(0px);top: 50px;">
				<input id="page" value="1" type="hidden">
				<ul id="list"  class="mui-table-view">
				</ul>
			</div>
		</div>

	</div>
</div>
</body>

<script type="text/javascript">
	{literal}
	! function() {
		function a() {
			document.documentElement.style.fontSize = document.documentElement.clientWidth / 6.4 + "px";
			if (document.documentElement.clientWidth >= 640) document.documentElement.style.fontSize = '100px';
		}
		var b = null;
		window.addEventListener("resize", function() {
			clearTimeout(b), b = setTimeout(a, 300)
		}, !1), a()
	}(window);
	mui('body').on('tap', 'a', function() {
		document.location.href = this.href;
	});

	mui.init();
	window.onload = function() {
		mui('.mui-scroll-wrapper').scroll({
			deceleration: 0.0005 //flick 减速系数，系数越大，滚动速度越慢，滚动距离越小，默认值0.0006
		});
		// mui('body').on('tap', 'a', function(){
		//     document.location.href=this.href;
		// });
		mui('.hot').scroll({
			scrollX: true,
			deceleration: 0.0005 //flick 减速系数，系数越大，滚动速度越慢，滚动距离越小，默认值0.0006
		});
	}

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
		mui('#pullrefresh').scroll();
		mui('.mui-bar').on('tap', 'a', function (e)
		{
			mui.openWindow({
				url: this.getAttribute('href'),
				id: 'info'
			});
		});

		mui('.mui-table-view').on('tap', 'button.confirmreceipt', function (e)
		{
			var orderid = this.getAttribute('data-id');
			swal({
				title: "提示",
				text: "您确定已经收到此商品吗？",
				type: "warning",
				showCancelButton: true,
				closeOnConfirm: true,
				confirmButtonText: "确定收到",
				confirmButtonColor: "#ec6c62"
			}, function ()
			{
				window.location.href = 'appraise_submit.php?type=confirmreceipt&record=' + orderid;
			});
		});
	});
	function pulldownRefresh()
	{
		Zepto('#sortbar').css("display", "none");
		setTimeout(function ()
		{
			Zepto('#sortbar').css("display", "");
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
		sb.append('<li class=" mui-media">');
		sb.append('<div class="mui-content-padded">');
		sb.append('<p>订单号:<span>' + v.mall_orders_no + '</span><a  href="aftersaleservice.php?record=' + v.orderid + '"><span class="sh mui-pull-right ">退货退款/换货</span></a> <span class="icon-pingtaibaozhang sh mui-pull-right"></span></p>');
		sb.append('</div>');
		sb.append('	<a href="orderdetail.php?record=' + v.orderid + '" > ');
		sb.append('<div class="myorder_list_body">');
		sb.append('<div class="mui-pull-left img">');
		sb.append('<img src="' + v.thumbnail + '">');
		sb.append('</div>');
		sb.append('<div class="mui-media-body">');
		sb.append('<p class="">' + v.ordername + '</p>');
		sb.append('<span class="red">￥' + v.sumorderstotal + '</span>');
		sb.append('</div>');
		sb.append('</div>');
		sb.append('</a>');
		sb.append('<div class="myorder_list_hj">');
		sb.append('<p>共' + v.productcount + '件商品 合计：￥' + v.sumorderstotal + '</p>');
		sb.append('</div>');
		sb.append('<div class="myorder_list_btn">');
		sb.append('<button type="button" class="mui-btn ">' + v.order_status + '</button>');
		if (v.aftersaleservicestatus != 'yes')
		{
			if (v.order_status != "退货中" && v.order_status != "已退货" && v.order_status != "已退款" && v.order_status != "已付款")
			{
				if (v.confirmreceipt != 'receipt')
				{
					sb.append('<button type="button" class="mui-btn red confirmreceipt" data-id="' + v.orderid + '">确认收货</button>');
				}
				else
				{
					if (v.appraisestatus == 'yes')
					{
						sb.append('<a class="mui-btn red confirmreceipt"  href="appraise_submit.php?record=' + v.orderid + '" style="font-size: .28rem; margin-left: 0.24rem;" >&nbsp;查看评价</a> ');
					}
					else
					{
						sb.append('<a class="mui-btn red confirmreceipt" href="appraise_submit.php?record=' + v.orderid + '" style="font-size: .28rem; margin-left: 0.24rem;">&nbsp;去评价</a> ');
						}
				}
			}
		}
		sb.append('</div>');
		sb.append('</li>');
		return sb.toString();
	}
	function order_empty_html()
	{
		var sb = new StringBuilder();
		sb.append('<div class="mui-content-padded">');
		sb.append('				   		  <p class="tishi"><span class="mui-icon iconfont icon-tishi"></span></p>');
		sb.append('					      <p class="msgbody">您的已付款订单还是空的，快去选购商品吧<br>');
		sb.append('							  <a href="index.php">>>>&nbsp;去逛逛</a> ');
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
			url: "orders.ajax.php",
			data: 'type=trade&page=' + page,
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
							//alert(nd);
							Zepto('#list').append(nd);
						});
						mui('#pullrefresh').pullRefresh().endPullupToRefresh(false); //参数为true代表没有更多数据了。
					}
				}
				else
				{
					mui('#pullrefresh').pullRefresh().endPullupToRefresh(true); //参数为true代表没有更多数据了。
				}
			}
		});
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

	{/literal}
</script>
</html>
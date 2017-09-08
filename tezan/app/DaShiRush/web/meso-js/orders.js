/**
 * Created by clubs on 2017/3/21.
 */
var mask   = null;
var isPull = false;

function onWebSiteReady()
{
	if (ProfileID == "")
	{
		swal({title: "", text: "需登录后才能查看订单", type: "info", confirmButtonText: "确定"}, function ()
		{
			window.location = "index.html"
		})
	}
	else
	{
		setTimeout(function ()
				   {
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
				   }, 1)
	}
	if (typeof(UpdateLeftMenu) == "function")
	{
		UpdateLeftMenu({"profileid": ProfileID, "givename": givename, "image": imgurl});
	}
	if (typeof(UpdateFooter) == "function")
	{
		UpdateFooter({
						 "mainpage": {
							 "title": "跟单首页",
							 "active": "0",
							 "href": "index.html",
							 "icon": "mainpage",
							 "badge": "0"
						 },
						 "orders": {
							 "title": "我的订单",
							 "active": "1",
							 "href": "orders.html",
							 "icon": "shoppingcart",
							 "badge": "0"
						 }
					 });
	}
	if (typeof(UpdateCopyRight) == "function")
	{
		UpdateCopyRight({"title": "大泗医疗器械产业投资有限公司", "link": "www.dashi-china.com"})
	}
}

//下拉刷新列表函数
function PullDownRefresh()
{
	setTimeout(function ()
			   {
				   $('#page').val(1);
				   $('#list').html('');
				   PullupLoadMore()
				   mui('#pullrefresh').pullRefresh().refresh(true);
				   mui('#pullrefresh').pullRefresh().endPulldownToRefresh(); //refresh completed
			   }, 1000);
}

//上拉加载更多函数
function PullupLoadMore()
{
	if (!isPull)
	{
		isPull   = true;
		var page = $('#page').val();
		getServerData("/app/DaShiRush/api/orders.ajax.php", {page: page, mode: "loadlist", profileid: ProfileID}, function (json)
					  {
						  if (json == null)
						  {
							  if (page <= 1)
							  {
								  OrdersEmpty()
							  }
							  mui('#pullrefresh').pullRefresh().endPullupToRefresh(true);
							  isPull = false
						  }
						  else if (json.statusCode == "200")
						  {
							  UpdateOrders(json.message)
							  mui('#pullrefresh').pullRefresh().endPullupToRefresh(false);
							  isPull = false
							  $('#page').val(parseInt(page) + 1);
						  }
						  else
						  {
							  swal({title: "", text: json.message, type: "error", confirmButtonText: "确定"})
							  mui('#pullrefresh').pullRefresh().endPullupToRefresh(true);
							  isPull = false
						  }
					  }, function (type)
					  {
						  mui('#pullrefresh').pullRefresh().endPullupToRefresh(false);
					  }
		);
	}
}

//加载订单数据项
function UpdateOrders(data)
{
	var sb = new StringBuilder();
	$.each(data, function (key, item)
	{
		var style = 'style="color:orange;"';
		if (item.status < 0)
		{
			style = 'style="color:red;"';
		}
		else if (item.status == 3)
		{
			style = 'style="color:blue;"';
		}else if (item.status == 4)
		{
			style = 'style="color:green;"';
		}
		sb.append(
			'<div class="mui-card" style="margin: 3px 3px;" >' +
			'	<ul class="mui-table-view" style="color: #333;background: #f3f3f3;">' +
			'		<li class="mui-table-view-cell">' +
			'			<div class="mui-media-body" style="text-align: center;">' +
			'				<span class="mui-table-view-label" style="font-size: 16px;font-weight: bold;">' + item.title + '</span>' +
			'			</div>' +
			'		</li>')
		if (item.details != "")
		{
			sb.append(
				'	<li class="mui-table-view-cell">' +
				'		<div class="mui-media-body">' +
				'			<span class="mui-table-view-label">手术明细：' + item.details + '</span>' +
				'		</div>' +
				'	</li>'
			)
		}
		sb.append(
			'		<li class="mui-table-view-cell">' +
			'			<div class="mui-media-body">' +
			'				<p class="mui-ellipsis" style="color:#333">订单编号：' + item.ordernum + '</p>' +
			'				<p class="mui-ellipsis" style="color:#333">发布单位：' + item.supplier + '</p>' +
			'				<p class="mui-ellipsis" style="color:#333">发布地址：' + item.suppaddr + '</p>' +
			'				<p class="mui-ellipsis" style="color:#333">联 系 人：' + item.account + '</p>' +
			'				<p class="mui-ellipsis" style="color:#333">联系电话：' + item.moblie + '</p>' +
			'				<p class="mui-ellipsis" style="color:#333">医疗机构：' + item.hospitals + '</p>' +
			'				<p class="mui-ellipsis" style="color:#333">手术地址：' + item.hosaddr + '</p>' +
			'				<p class="mui-ellipsis" style="color:#333">手术类型：' + item.surgery + '</p>' +
			'				<p class="mui-ellipsis" style="color:#333">手术时间：' + item.date + '</p>' +
			'				<p class="mui-ellipsis" style="color:#333">跟单费用：￥' + item.amount + ' 元</p>' +
			'			</div>' +
			'		</li>' +
			'		<li class="mui-table-view-cell">' +
			'			<div class="mui-media-body">' +
			'				<p class="mui-table-view-label" ' + style + '>抢单时间：' + item.rushdate + '</p>' +
			'				<p class="mui-table-view-label" ' + style + '>订单状态：' + item.statustext + '</p>'
		)
		if (item.status == "4")
		{
			sb.append(
				'				<p class="mui-table-view-label" ' + style + '>结束时间：' + item.finishdate + '</p>'
			)
		}
		sb.append(
			'			</div>' +
			'		</li>'
		)
		if (item.status == "2")
		{
			sb.append(
				'		<li class="mui-table-view-cell">' +
				'			<div class="mui-media-body mui-pull-right">' +
				'				<a class="left-arrow cancel-rush" style="color:red;" data-id="' + item.id + '">&nbsp;撤销申请</a>' +
				'			</div>' +
				'		</li>'
			)
		}
		else if (item.status == "3")
		{
			sb.append(
				'		<li class="mui-table-view-cell">' +
				'			<div class="mui-media-body mui-pull-right">' +
				'				<a class="left-arrow confirm-rush" style="color:blue;" data-id="' + item.id + '">&nbsp;跟单完成</a>' +
				'			</div>' +
				'		</li>'
			)
		}else if (item.status == "6"){
			sb.append(
				'		<li class="mui-table-view-cell">' +
				'			<div class="mui-media-body mui-pull-right">' +
				'				<a class="left-arrow receivables-rush" style="color:blue;" data-id="' + item.id + '">&nbsp;跟单已收款</a>' +
				'			</div>' +
				'		</li>'
			)
		}
		sb.append(
			'	</ul>' +
			'</div>')
		$('#list').append(sb.toString())
		if (item.status == "2")
		{
			BindTipEvent(".mui-table-view-cell", ".cancel-rush", Cancel_Rush_Btn_Event)
		}else if (item.status == "3")
		{
			BindTipEvent(".mui-table-view-cell", ".confirm-rush", Confirm_Rush_Btn_Event)
		}else if (item.status == "6"){
			BindTipEvent(".mui-table-view-cell", ".receivables-rush", Receivables_Rush_Btn_Event)
		}
		sb.clear()
	})
}

function OrdersEmpty()
{
	var sb = new StringBuilder();
	sb.append(
		'<div class="mui-card" style="margin: 3px 3px;">' +
		'	<p>&nbsp;</p>' +
		'	<p style="text-align: center;font-size: 18px;">目前还没有跟单信息，去首页看看<br><br></p>' +
		'</div>'
	)
	$('#list').html(sb.toString())
	sb.clear()
}

function Cancel_Rush_Btn_Event()
{
	var $this  = $(this)
	var rushid = $this.attr("data-id")
	swal({
			 title: "",
			 text: "确定要撤销申请吗？",
			 type: "info",
			 showCancelButton: true,
			 showConfirmButton: true,
			 closeOnCancel: true,
			 confirmButtonText: "确定",
			 cancelButtonText: "取消"
		 }, function ()
		 {
			 setTimeout(function ()
						{
							swal({
									 title: "",
									 text: "正在提交申请，请稍候。。。",
									 type: "",
									 imageUrl: "images/loading.gif",
									 showCancelButton: false,
									 showConfirmButton: false,
									 closeOnConfirm: false
								 })
						}, 200)
			 getServerData("/app/DaShiRush/api/orders.ajax.php", {rushid: rushid, profileid: ProfileID, mode: "cancelrush"}, function (json)
						   {
							   if (json == null)
							   {
								   setTimeout(function ()
											  {
												  swal({title: "", text: "提交失败，请检查网络是否正常。", type: "error", confirmButtonText: "确定"})
											  }, 200)
							   }
							   else
							   {
								   if (json.statusCode == "200")
								   {
									   $this.parent().parent().parent().parent().remove()
									   if ($("#list").children().length <= 0)
									   {
										   OrdersEmpty()
									   }
									   setTimeout(function ()
												  {
													  swal({title: "", text: json.message, type: "info", confirmButtonText: "确定"})
												  }, 200)
								   }
								   else
								   {
									   setTimeout(function ()
												  {
													  swal({title: "", text: json.message, type: "error", confirmButtonText: "确定"})
												  }, 200)
								   }
							   }
						   }, function (type)
						   {
							   setTimeout(function ()
										  {
											  swal({title: "", text: "提交失败，请检查网络是否正常。", type: "error", confirmButtonText: "确定"})
										  }, 200)
						   }
			 )
		 }
	)
}

function Confirm_Rush_Btn_Event()
{
	var $this  = $(this)
	var rushid = $this.attr("data-id")
	swal({
			 title: "",
			 text: "确定要结束此跟单吗？",
			 type: "info",
			 showCancelButton: true,
			 showConfirmButton: true,
			 closeOnCancel: true,
			 confirmButtonText: "确定",
			 cancelButtonText: "取消"
		 }, function ()
		 {
			 setTimeout(function ()
						{
							swal({
									 title: "",
									 text: "正在提交申请，请稍候。。。",
									 type: "",
									 imageUrl: "images/loading.gif",
									 showCancelButton: false,
									 showConfirmButton: false,
									 closeOnConfirm: false
								 })
						}, 200)
			 getServerData("/app/DaShiRush/api/orders.ajax.php", {
							   rushid: rushid,
							   profileid: ProfileID,
							   mode: "completerush"
						   }, function (json)
						   {
							   if (json == null)
							   {
								   setTimeout(function ()
											  {
												  swal({title: "", text: "提交失败，请检查网络是否正常。", type: "error", confirmButtonText: "确定"})
											  }, 200)
							   }
							   else
							   {
								   if (json.statusCode == "200")
								   {
									   PullDownRefresh()
									   setTimeout(function ()
												  {
													  swal({title: "", text: json.message, type: "info", confirmButtonText: "确定"})
												  }, 200)
								   }
								   else
								   {
									   setTimeout(function ()
												  {
													  swal({title: "", text: json.message, type: "error", confirmButtonText: "确定"})
												  }, 200)
								   }
							   }
						   }, function (type)
						   {
							   setTimeout(function ()
										  {
											  swal({title: "", text: "提交失败，请检查网络是否正常。", type: "error", confirmButtonText: "确定"})
										  }, 200)
						   }
			 )
		 }
	)
}

function Receivables_Rush_Btn_Event()
{
	var $this  = $(this)
	var rushid = $this.attr("data-id")
	swal({
			 title: "",
			 text: "确定是否已收款？",
			 type: "info",
			 showCancelButton: true,
			 showConfirmButton: true,
			 closeOnCancel: true,
			 confirmButtonText: "确定",
			 cancelButtonText: "取消"
		 }, function ()
		 {
			 setTimeout(function ()
						{
							swal({
									 title: "",
									 text: "正在提交申请，请稍候。。。",
									 type: "",
									 imageUrl: "images/loading.gif",
									 showCancelButton: false,
									 showConfirmButton: false,
									 closeOnConfirm: false
								 })
						}, 200)
			 getServerData("/app/DaShiRush/api/orders.ajax.php", {
							   rushid: rushid,
							   profileid: ProfileID,
							   mode: "receivables"
						   }, function (json)
						   {
							   if (json == null)
							   {
								   setTimeout(function ()
											  {
												  swal({title: "", text: "提交失败，请检查网络是否正常。", type: "error", confirmButtonText: "确定"})
											  }, 200)
							   }
							   else
							   {
								   if (json.statusCode == "200")
								   {
									   PullDownRefresh()
									   setTimeout(function ()
												  {
													  swal({title: "", text: json.message, type: "info", confirmButtonText: "确定"})
												  }, 200)
								   }
								   else
								   {
									   setTimeout(function ()
												  {
													  swal({title: "", text: json.message, type: "error", confirmButtonText: "确定"})
												  }, 200)
								   }
							   }
						   }, function (type)
						   {
							   setTimeout(function ()
										  {
											  swal({title: "", text: "提交失败，请检查网络是否正常。", type: "error", confirmButtonText: "确定"})
										  }, 200)
						   }
			 )
		 }
	)
}
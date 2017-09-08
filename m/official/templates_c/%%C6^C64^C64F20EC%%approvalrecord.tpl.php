<?php /* Smarty version 2.6.18, created on 2017-08-15 17:23:25
         compiled from approvalrecord.tpl */ ?>
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
		<?php echo '
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
		'; ?>

	</style>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'theme.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</head>
<body>
 
	<div class="mui-inner-wrap">
		<header class="mui-bar mui-bar-nav" style="padding-right: 15px;">
		    <a href="/official/approval.php" class="mui-icon mui-icon-back mui-pull-left"></a> 
			<?php if ($this->_tpl_vars['type'] == 'treat'): ?>
			<h1 class="mui-title">待我宴请审核</h1>
            <div class="mui-title mui-content tit-sortbar" id="sortbar"> 
 				<div id="segmentedControl" class="mui-segmented-control mui-segmented-control-inverted mui-segmented-control-negative">
 					<a class="mui-control-item iconfont icon-daishenpi button-color" href="pendingapprovaltreat.php">&nbsp;审核</a> 
					<a class="mui-control-item iconfont icon-shenpijilu button-color  mui-active" href="approvalrecord.php?type=treat">&nbsp;审核记录</a>
 				</div> 
            </div>
			<?php else: ?>
			<h1 class="mui-title">待我购物审核</h1>
            <div class="mui-title mui-content tit-sortbar" id="sortbar"> 
 				<div id="segmentedControl" class="mui-segmented-control mui-segmented-control-inverted mui-segmented-control-negative">
 					<a class="mui-control-item iconfont icon-daishenpi button-color" href="pendingapprovalorder.php">&nbsp;审核</a> 
					<a class="mui-control-item iconfont icon-shenpijilu button-color  mui-active" href="approvalrecord.php?type=order">&nbsp;审核记录</a>
 				</div> 
            </div>
			<?php endif; ?>
		</header> 
		 <div id="pullrefresh" class="mui-content mui-scroll-wrapper" style="padding-top: 85px;">  
			<div class="mui-scroll"> 
				<div class="mui-table-view">  
					<input id="page" value="1" type="hidden">
					<input id="type" value="<?php echo $this->_tpl_vars['type']; ?>
" type="hidden"> 
					<ul id="list" class="mui-table-view" style="padding-top: 5px;padding-bottom: 5px;">
					</ul>  
				    <h6 class="mui-content-padded" style="height:3px;margin:0px">&nbsp;</h6>  
				</div> 
					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'copyright.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			</div>
		</div>
	</div> 

<script type="text/javascript">
	<?php echo '
	mui.init({
				 pullRefresh: {
					 container: \'#pullrefresh\', //待刷新区域标识，querySelector能定位的css选择器均可，比如：id、.class等
					 down: {
						 callback: pulldownRefresh
					 },
					 up: {
						 contentrefresh: "正在加载...", //可选，正在加载状态时，上拉加载控件上显示的标题内容
						 contentnomore: \'没有更多数据了\', //可选，请求完毕若没有更多数据时显示的提醒内容；
						 callback: add_more //必选，刷新函数，根据具体业务来编写，比如通过ajax从服务器获取新数据；
					 }
				 },
			 });
	mui.ready(function ()
			  {
				  mui(\'#pullrefresh\').scroll();
				  mui(\'.mui-bar\').on(\'tap\', \'a\', function (e)
				  {
					  mui.openWindow({
										 url: this.getAttribute(\'href\'),
										 id: \'info\'
									 });
				  });  
				  mui(\'.mui-table-view\').on(\'tap\', \'a\', function (e)
				  {
					  mui.openWindow({
										 url: this.getAttribute(\'href\'),
										 id: \'info\'
									 });
				  });
			  }); 
			  
		  	function pulldownRefresh()
		  	{
		  		Zepto(\'#sortbar\').css("display","none");
		  		setTimeout(function ()
		  				   {
		  					   Zepto(\'#sortbar\').css("display","");
		  					   Zepto(\'#page\').val(1);
		  					   Zepto(\'#list\').html(\'\');
		  					   add_more();
		  					   mui(\'#pullrefresh\').pullRefresh().refresh(true);
		  					   mui(\'#pullrefresh\').pullRefresh().endPulldownToRefresh(); //refresh completed
		  				   }, 1000);
		  	}

		  	function order_html(v)
		  	{
		  		var sb = new StringBuilder();
		  		sb.append(\'<div class="mui-card" style="margin: 3px 3px;" >\');
		  		sb.append(\'		 <ul class="mui-table-view" style="color: #333;background: #f3f3f3;">\');
		  		sb.append(\'				 <li class="mui-table-view-cell order-link-cell">\');
		  		sb.append(\'					<div class="mui-media-body  mui-pull-left">\');
		  		sb.append(\'						<span class="mui-table-view-label">模块：</span>\' + v.modulelabel);
		  		sb.append(\'					</div>\');  
		  		sb.append(\'					<div class="mui-media-body mui-pull-right" style="color:red"> \');
		  		sb.append(\'						 \'+ v.reply);
		  		sb.append(\'					</div> \');
		  		sb.append(\'                </li>\');
		  		sb.append(\'				<li class="mui-table-view-cell">\');  
				if (v.modulelabel == \'宴请\')
				{
					sb.append(\'					 <a href="treatdetail.php?record=\' + v.record + \'" class="mui-navigate-right"> \'); 
 				}
				else
				{
					sb.append(\'					 <a href="orderdetail.php?record=\' + v.record + \'" class="mui-navigate-right"> \'); 
					
				}
		  		sb.append(\'							<div class="mui-media-body">\');
		  		sb.append(\'								<p class="mui-ellipsis" style="color:#333">提交人：\' + v.givenname + \'</p>\'); 
				sb.append(\'								<p class="mui-ellipsis" style="color:#333">提交时间：\' + v.published + \'</p>\'); 
				sb.append(\'								<p class="mui-ellipsis" style="color:#333">审批时间：\' + v.submitdatetime + \'</p>\');
				if( v.flag == 1)
                {
                    sb.append(\'								<p class="mui-ellipsis" style="color:#333">宴请对象：\' + v.participants + \'</p>\');
                    sb.append(\'								<p class="mui-ellipsis" style="color:#333">宴请金额：\' + v.estimatedcost + \'</p>\');
                }
		  		sb.append(\'							</div> \');
				sb.append(\'					 </a>\'); 
		  		sb.append(\'				 </li> \');   
		  		sb.append(\' 	 	</ul>\');
		  		sb.append(\'</div>\');
		  		return sb.toString();
		  	}
		  	function order_empty_html()
		  	{
		  		var sb = new StringBuilder(); 
		  		sb.append(\'<div class="mui-card" style="margin: 3px 3px;"> \');
		  		sb.append(\'				   		  <p class="tishi"><span class="mui-icon iconfont icon-tishi"></span></p>\');
		  		sb.append(\'					      <p class="msgbody">您还没有审核记录！<br>\');
	  			sb.append(\'							  <br> \');
				sb.append(\'						  </p>  \');
		  		sb.append(\' </div>\');
		  		return sb.toString();
		  	}

		  	function add_more()
		  	{
		  		var page = Zepto(\'#page\').val(); 
				var type = Zepto(\'#type\').val();
		  		Zepto(\'#page\').val(parseInt(page, 10) + 1);
		  		mui.ajax({
		  					 type: \'POST\',
		  					 url: "approvalrecord.php",
		  					 data: \'type=ajax&approval=\'+type+\'&page=\' + page,
		  					 success: function (json)
		  					 {
		  						 var msg = eval("(" + json + ")");
		  						 if (msg.code == 200)
		  						 {
		  							 if (msg.data.length == 0 && page == 1)
		  							 {
		  								 Zepto(\'#list\').html(order_empty_html());
		  								 mui(\'#pullrefresh\').pullRefresh().endPullupToRefresh(true); //参数为true代表没有更多数据
		  							 }
		  							 else
		  							 {
		  								 Zepto.each(msg.data, function (i, v)
		  								 {
		  									 var nd = order_html(v); 
		  									 Zepto(\'#list\').append(nd);
		  								 });
		  								 mui(\'#pullrefresh\').pullRefresh().endPullupToRefresh(false); //参数为true代表没有更多数据了。
		  							 }
		  						 }
		  						 else
		  						 {
		  							 mui(\'#pullrefresh\').pullRefresh().endPullupToRefresh(true); //参数为true代表没有更多数据了。
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
		  										 mui(\'#pullrefresh\').pullRefresh().pullupLoading();
		  									 }, 1000);

		  					  });
		  	}
		  	else
		  	{
		  		mui.ready(function ()
		  				  {
		  					  Zepto(\'#page\').val(1);
		  					  mui(\'#pullrefresh\').pullRefresh().pullupLoading();
		  				  });
		  	}
	'; ?>

</script> 
<script src="/public/js/baidu.js?_=20140821" type="text/javascript"></script>
</body>
</html>
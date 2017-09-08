<?php /* Smarty version 2.6.18, created on 2017-08-16 10:00:43
         compiled from deliveraddress.tpl */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
	<title>收货地址管理</title>
	<link href="public/css/mui.css" rel="stylesheet"/>
	<link href="public/css/public.css" rel="stylesheet"/>
	<link href="public/css/iconfont.css" rel="stylesheet"/>
	<script src="public/js/mui.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="public/js/zepto.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="public/js/utils.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript" src="public/js/jweixin.js"></script>
	<style>
		<?php echo '
		.img-responsive {
			display: block;
			height: auto;
			width: 100%;
		}

		.mui-radio.mui-left label {
			padding-right: 3px;
			padding-left: 25px;
		}

		.mui-radio.mui-left input[type=\'radio\'] {
			left: 3px;
		}

		.mui-table-view .mui-media-object {
			line-height: 100px;
			max-width: 100px;
			height: 100px;
		}

		.mui-ellipsis {
			line-height: 20px;
			margin-bottom: 0px;
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

		.mui-bar-tab .mui-tab-item .mui-icon {
			width: auto;
		}

		.mui-tab-item .mui-icon {
			font-size: 16px;
		}

		.mui-ellipsis {
			line-height: 17px;
		}

		.mui-table-view-cell.mui-radio.mui-left, .mui-table-view-cell.mui-checkbox.mui-left {
			padding-left: 15px;
		}

		.deliveraddress-cell {
			position: relative;
			overflow: hidden;
			padding: 11px 15px;
			background-color: inherit;
			-webkit-touch-callout: none;
		}

		.deliveraddress-edit-cell {
			padding-top: 20px;
			padding-left: 12px;
		}

		.deliveraddress-edit-cell span {
			font-size: 2.2em;
		}
		header.mui-bar{
            background-color: #f9f9f9 !important;
        }
        header .mui-title, header a{
            color: #232326 !important;
        }
        #copyright .mui-table-view{
            background: #f9f9f9 !important;
        }
        .button-color{
            color: #fb3e21 !important;
        }
        .mui-table-view input[type=\'radio\']:checked:before, .mui-radio input[type=\'radio\']:checked:before, .mui-checkbox input[type=\'checkbox\']:checked:before{
            color: #fb3e21 !important;
        }
        .mui-bar-tab .mui-tab-item{
            background: #fb3e21 !important;
            color: #fff !important;
        }
        .mui-bar-tab .mui-tab-item .button-color{
            color: #fff !important;
        }
        aside .button-color{
            color: #fff !important;
        }
        .mui-content{
            background: #f9f9f9 !important;
        }
        .mui-card{
        	margin: 0 !important;
        	border: 0;
        	border-radius: 0;
        }
        .mui-table-view{
        	background: #f9f9f9;
        }
        .mui-table-view li,
        .mui-input-row:last-child{
        	background: #fff;
        	margin-bottom: 5px;
        }
        .mui-input-group .mui-input-row:after{
        	height: 0;
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
<div class="mui-off-canvas-wrap mui-draggable" id="offCanvasWrapper">
	<div class="mui-inner-wrap">
		<header class="mui-bar mui-bar-nav" style="padding-right: 15px;">
			<a class="mui-icon mui-icon-back mui-pull-left" href="/submitorder.php"></a>
			<h1 class="mui-title">收货地址管理</h1>
		</header>
		<nav class="mui-bar mui-bar-tab" style="height:40px;line-height:40px;">

			<!-- <a class="mui-tab-item mui-active add" href="<?php echo $this->_tpl_vars['weixin_deliveraddress_url']; ?>
">
				<span class="mui-icon iconfont icon-weixin">&nbsp;微信导入</span>
			</a> -->

			<a class="mui-tab-item mui-active add" href="deliveraddress_edit.php?orderid=<?php echo $this->_tpl_vars['orderid']; ?>
">
				<span class="mui-icon iconfont icon-zengjia">&nbsp;新增</span>
			</a>
			<a class="mui-tab-item mui-active submit" href="#">
				<span class="mui-icon iconfont icon-queren01">&nbsp;确认</span>
			</a>
		</nav>

		<div id="pullrefresh" class="mui-content mui-scroll-wrapper" style="bottom: 50px;">
			<div class="mui-scroll">
				<div class="mui-card" style="margin: 0 3px;">
					<form class="mui-input-group">
						<input type="hidden" id="orderid" name="orderid" value="<?php echo $this->_tpl_vars['orderid']; ?>
"/>
						<ul class="mui-table-view mui-table-view-chevron" style="color: #333;">
							<?php $_from = $this->_tpl_vars['deliveraddress']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['deliveraddress'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['deliveraddress']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['deliveraddressid'] => $this->_tpl_vars['deliveraddress_info']):
        $this->_foreach['deliveraddress']['iteration']++;
?>
								<li class="deliveraddress-cell mui-input-row mui-radio mui-left" style="height:80px;" id="shoppingcart_wrap_<?php echo $this->_tpl_vars['deliveraddressid']; ?>
">
									<a href="deliveraddress_edit.php?record=<?php echo $this->_tpl_vars['deliveraddressid']; ?>
&orderid=<?php echo $this->_tpl_vars['orderid']; ?>
" class="deliveraddress-edit-cell mui-pull-right" style="width:10%">
										<span class="mui-icon iconfont icon-tishi1"></span>
									</a>
									<div class="mui-pull-left" style="width:90%">
										<label>

											<div class="mui-media-body">
												<p class='mui-ellipsis' style="color:#333">
												<div class="mui-media-body  mui-pull-left">
													收货人：<?php echo $this->_tpl_vars['deliveraddress_info']['consignee']; ?>

												</div>
												<div class="mui-media-body mui-pull-right">
													<?php echo $this->_tpl_vars['deliveraddress_info']['mobile']; ?>

												</div>
												</p>
											</div>
											<div class="mui-media-body">
												<p class='mui-ellipsis' style="color:#333">
													收货地址：<?php echo $this->_tpl_vars['deliveraddress_info']['province']; ?>
<?php echo $this->_tpl_vars['deliveraddress_info']['city']; ?>
<?php echo $this->_tpl_vars['deliveraddress_info']['district']; ?>

													<br><?php echo $this->_tpl_vars['deliveraddress_info']['shortaddress']; ?>

											</div>

										</label>
										<input <?php if ($this->_tpl_vars['deliveraddress_info']['selected'] == '1'): ?>checked<?php endif; ?> value="<?php echo $this->_tpl_vars['deliveraddressid']; ?>
" id="deliveraddress_<?php echo $this->_tpl_vars['deliveraddressid']; ?>
" name="deliveraddress" type="radio" style="margin-top:20px;">
									</div>
								</li>
								<?php endforeach; else: ?>
								<div class="mui-content-padded">
									<p class="tishi"><span class="mui-icon iconfont icon-tishi"></span></p>
									<p class="msgbody">您的还没有收货地址，快点新建您的收货地址吧!<br>
									</p>
								</div>
							<?php endif; unset($_from); ?>
						</ul>
					</form>

				</div>
			</div>
		</div>
	</div>
</div>

<script>
	<?php echo '
	mui.init({
				 pullRefresh: {
					 container: \'#pullrefresh\'
				 },
			 });
	mui.ready(function ()
			  {
				  mui(\'#pullrefresh\').scroll();

				  mui(\'header.mui-bar\').on(\'tap\', \'a.mui-icon-back\', function (e)
				  {
					  mui.openWindow({
										 url: this.getAttribute(\'href\'),
										 id: \'info\'
									 });
				  });

				  mui(\'.mui-table-view\').on(\'tap\', \'a.deliveraddress-edit-cell\', function (e)
				  {
					  mui.openWindow({
										 url: this.getAttribute(\'href\'),
										 id: \'info\'
									 });
				  });
				  mui(\'.mui-bar\').on(\'tap\', \'a.add\', function (e)
				  {
					  mui.openWindow({
										 url: this.getAttribute(\'href\'),
										 id: \'info\'
									 });
				  });
				  mui(\'.mui-bar\').on(\'tap\', \'a.submit\', function (e)
				  {
					  var deliveraddressid = "";
					  var orderid = "";
					  Zepto(\'input[name=orderid]\').each(function (index)
															   {
																   orderid = Zepto(this).val();
															   });

					  Zepto(\'input[name=deliveraddress]\').each(function (index)
															   {
																   if (this.checked)
																   {
																	   deliveraddressid = Zepto(this).val();
																   }
															   });

					  if (deliveraddressid == "")
					  {
						  mui.toast(\'请新建或选择收货地址！\');
					  }
					  else
					  {
						  mui.openWindow({
											 url: \'submitorder.php?deliveraddressid=\' + deliveraddressid + \'&record=\'+orderid,
											 id: \'info\'
										 });
					  }
				  });

			  });
	'; ?>

</script>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'weixin.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script src="/public/js/baidu.js?_=20140821" type="text/javascript"></script>
</body>
</html>
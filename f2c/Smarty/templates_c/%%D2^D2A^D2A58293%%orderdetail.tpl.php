<?php /* Smarty version 2.6.18, created on 2017-08-16 10:45:01
         compiled from orderdetail.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'floatval', 'orderdetail.tpl', 230, false),array('modifier', 'intval', 'orderdetail.tpl', 253, false),)), $this); ?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>订单详情</title>
    <link href="public/css/mui.css" rel="stylesheet" />
    <link href="public/css/public.css" rel="stylesheet" />
	<link href="public/css/iconfont.css" rel="stylesheet" />
    <script src="public/js/mui.min.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript" src="public/js/jweixin.js"></script>
	<script src="public/js/zepto.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="public/js/utils.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript" src="public/js/jweixin.js"></script>
	<style>
	  <?php echo '
		  .img-responsive { display: block; height: auto; width: 100%; }

		  .mui-table-view-cell .mui-table-view-label
		  {
		  	    width:70px;
		  		text-align:right;
		  		display:inline-block;
		  }
		  .totalprice {color:#CF2D28; font-size:1.2em; font-weight:500; }

		  .ordersn { font-size:1.2em; font-weight:500; }

	 	  #orders_products .mui-table-view .mui-media-object {
		 	   line-height: 84px;
		 	   max-width: 84px;
		 	   height: 84px;
	 	  }
		  #orders_products .mui-ellipsis {
		  	  line-height: 17px;
		  }
	  	  .price {
	  	      color:#fe4401;
	  	  }
 		 .mui-table-view-cell:after {
 		   left: 0px;
 		 }
 		 .mui-table-view-chevron .mui-table-view-cell {
 		 	padding-right: 0px;
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
        .totalprice{
        	color: #fb3e21 !important;
        }
        .mui-card{
        	margin: 0 !important;
        	border: 0;
        	border-radius: 0;
        }
        .mui-table-view-cell:after,
        .mui-table-view-cell:last-child:after,
        .mui-card .mui-table-view:after{
    	    height: 10px;
	        transform: initial;
	        -webkit-transform: initial;
    		background-color: #efeff4;
        }
        .mui-table-view-label{
        	text-align: left !important;
        	font-size: 12px;
        	color: #8f8f94;
        }
        .ordersn{
        	font-size: 1em;
        }
        .blue{
        	color: #188fc9;
        }
        .totalprice{
        	font-size: 1em;
        }
        .mui-media-body{
        	padding-bottom: 10px;
        }
        .order-banner{
        	margin: 0 5px;
    	    padding: 10px;
		    color: #252525;
		    font-size: 14px;
		    border-bottom: 1px solid #eee;
        }
        .mui-table-view .mui-media-object{
        	width: 60px;
    	    line-height: normal !important;
			height: auto !important;
        }
        .mui-ellipsis-2{
        	font-size: 14px;
			overflow:hidden;
			text-overflow:ellipsis;
			display:-webkit-box;
			-webkit-box-orient:vertical;
			-webkit-line-clamp:2;
        }
        .order-info{
			float: left;
			width: 58%;
        }
        .mui-table-view-chevron .mui-table-view-cell:after{
        	height: 1px !important;
        }
        h5.show-content{
    	    background: #fb3e21 !important;
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
					 <a id="mui-action-back" class="mui-icon mui-action-back mui-icon-back mui-pull-left"></a>
					 <h1 class="mui-title" id="pagetitle">订单详情</h1>
				</header>
				  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		        <div id="pullrefresh" class="mui-content mui-scroll-wrapper" style="padding-top: 44px;">
		                <div class="mui-scroll">
							<div class="mui-card" style="margin: 0 3px;">
								 <input id="orderid" name="orderid"  value="<?php echo $this->_tpl_vars['orderinfo']['orderid']; ?>
" type="hidden" >
								 <input id="tradestatus" name="tradestatus"  value="<?php echo $this->_tpl_vars['orderinfo']['tradestatus']; ?>
" type="hidden" >
								 <input id="notify"  value="0" type="hidden" >
						         <ul class="mui-table-view">
			                                <li class="mui-table-view-cell">
													<div class="mui-media-body  mui-pull-left">
														<span class="mui-table-view-label">订单状态：</span><span class="ordersn blue"><?php echo $this->_tpl_vars['orderinfo']['order_status']; ?>
</span><br>
														<span class="mui-table-view-label">订单号：</span><span class="ordersn"><?php echo $this->_tpl_vars['orderinfo']['order_no']; ?>
</span><br>
														<span class="mui-table-view-label">成交状态：</span><span class="ordersn"><?php if ($this->_tpl_vars['orderinfo']['tradestatus'] == 'trade'): ?>成交<?php else: ?>未成交<?php endif; ?></span><br>

													</div>
			                                </li>
											<?php if ($this->_tpl_vars['orderinfo']['delivery'] != ''): ?>

                                                <?php $_from = $this->_tpl_vars['orderinfo']['deliverytime']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['invoicenumber_info']):
?>

                                                    <li class="mui-table-view-cell">
                                                            <div class="mui-media-body">
                                                                <span class="mui-table-view-label">发货时间：</span><span class="ordersn"><?php echo $this->_tpl_vars['orderinfo']['deliverytime'][$this->_tpl_vars['k']]; ?>
</span><br>
                                                                <span class="mui-table-view-label">物流公司：</span><span class="ordersn"><?php echo $this->_tpl_vars['orderinfo']['deliveryname'][$this->_tpl_vars['k']]; ?>
</span><br>
                                                                <span class="mui-table-view-label">发货单号：</span><span class="ordersn"><?php echo $this->_tpl_vars['orderinfo']['invoicenumber'][$this->_tpl_vars['k']]; ?>
</span><br>
                                                            </div>
                                                    </li>



                                                    <?php if ($this->_tpl_vars['orderinfo']['invoicenumber'][$this->_tpl_vars['k']] != 'JD'): ?>
                                                    <li class="mui-table-view-cell">
                                                            <div class="mui-media-body ">
                                                                <a id="wuliu" href="wuliu.php?type=<?php echo $this->_tpl_vars['orderinfo']['deliveryname'][$this->_tpl_vars['k']]; ?>
&invoicenumber=<?php echo $this->_tpl_vars['orderinfo']['invoicenumber'][$this->_tpl_vars['k']]; ?>
" style="width:100%"><h5 class="show-content" style="padding: 10px;">物流信息【点击查看物流信息】</h5></a>
                                                            </div>
                                                    </li>
                                                    <?php else: ?>
                                                        <?php $_from = $this->_tpl_vars['orderinfo']['invoicenumbers']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['invoicenumbers'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['invoicenumbers']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['invoicenumber_info']):
        $this->_foreach['invoicenumbers']['iteration']++;
?>
                                                             <li class="mui-table-view-cell">
                                                                <div class="mui-media-body ">
                                                                    <a id="wuliu" href="wuliu.php?type=<?php echo $this->_tpl_vars['orderinfo']['deliveryname']; ?>
&invoicenumber=<?php echo $this->_tpl_vars['invoicenumber_info']; ?>
" style="width:100%"><h5 class="show-content" style="padding: 10px;">物流信息【点击查看物流信息】</h5></a>
                                                                </div>
                                                        </li>
                                                        <?php endforeach; endif; unset($_from); ?>
                                                    <?php endif; ?>
                                                <?php endforeach; endif; unset($_from); ?>
                                            <?php endif; ?>
											<?php if ($this->_tpl_vars['orderinfo']['autoconfirmreceipt'] != ''): ?>
												<li class="mui-table-view-cell" style="display: none;">
														<div class="mui-media-body" style="color:red;text-align:center;">
															<?php echo $this->_tpl_vars['orderinfo']['autoconfirmreceipt']; ?>

														</div>
				                                </li>
											<?php endif; ?>
											<?php if ($this->_tpl_vars['orderinfo']['autosettlement'] != ''): ?>
												<li class="mui-table-view-cell" style="display: none;">
														<div class="mui-media-body" style="color:red;text-align:center;">
															<?php echo $this->_tpl_vars['orderinfo']['autosettlement']; ?>

														</div>
				                                </li>
											<?php endif; ?>
											<?php if ($this->_tpl_vars['orderinfo']['tradestatus'] == 'trade'): ?>
			                                <li class="mui-table-view-cell">
													<div class="mui-media-body  mui-pull-left">
														<span class="mui-table-view-label">付款时间：</span>
														    <span class="ordersn"><?php echo $this->_tpl_vars['orderinfo']['paymenttime']; ?>
</span>
														</span><br>
				 										<span class="mui-table-view-label">支付通道：</span>
														     <span class="ordersn"><?php echo $this->_tpl_vars['orderinfo']['payment']; ?>
</span>
														</span><br>
														<span class="mui-table-view-label">余额支付：</span>
														    <span class="totalpricse">￥<span><?php echo $this->_tpl_vars['orderinfo']['usemoney']; ?>
</span>
														</span><br>
														<span class="mui-table-view-label">卡券优惠：</span>
														    <span class="totalprice">￥<span><?php echo $this->_tpl_vars['orderinfo']['discount']; ?>
</span>
														</span><br>
                                                        <?php if ($this->_tpl_vars['amount'] != null): ?>
                                                        <span class="mui-table-view-label" style="height: 20px;width: 74px">商城卡支付：</span>
                                                        <span class="totalprice">￥<span><?php echo $this->_tpl_vars['amount']; ?>
</span>
														</span><br>
                                                        <?php endif; ?>
														<span class="mui-table-view-label">实付金额：</span>
														    <span class="totalprice">￥<span><?php echo $this->_tpl_vars['orderinfo']['paymentamount']; ?>
</span>
														</span>
													</div>
			                                 </li>
											<?php endif; ?>
			                                <li class="mui-table-view-cell">
													<div class="mui-media-body  mui-pull-left">
														<span class="mui-table-view-label">订单总额：</span>
														    <span class="totalprice">￥<?php echo $this->_tpl_vars['orderinfo']['sumorderstotal']; ?>

														</span>（邮费<?php echo $this->_tpl_vars['orderinfo']['orders_products']['0']['postage']; ?>
元）<br>
														<span class="mui-table-view-label">支付方式：</span>在线支付<br>
														 <span class="mui-table-view-label">收货人：</span><?php echo $this->_tpl_vars['orderinfo']['consignee']; ?>
<br>
														<span class="mui-table-view-label">收货手机：</span><?php echo $this->_tpl_vars['orderinfo']['mobile']; ?>
<br>
														<span class="mui-table-view-label">收货地址：</span><?php echo $this->_tpl_vars['orderinfo']['address']; ?>

													</div>
			                                </li>
											 <?php if (((is_array($_tmp=$this->_tpl_vars['orderinfo']['addpostage'])) ? $this->_run_mod_handler('floatval', true, $_tmp) : floatval($_tmp)) > 0): ?>
												 <li class="mui-table-view-cell">
													 <div class="mui-media-body">
														 偏远地区附加邮费：<span class="price">¥<?php echo $this->_tpl_vars['orderinfo']['addpostage']; ?>
</span>
													 </div>
												 </li>
											 <?php endif; ?>
								 </ul>
					    </div>
						<div class="mui-card" style="margin: 0;margin-top: 5px;" id="orders_products">
								<p class="order-banner">惠民商城</p>
								 <ul class="mui-table-view mui-table-view-chevron" style="color: #333;">
									  <?php $_from = $this->_tpl_vars['orderinfo']['orders_products']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['orders_products'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['orders_products']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['orders_products_info']):
        $this->_foreach['orders_products']['iteration']++;
?>
		  									<li class="mui-table-view-cell mui-left" style="min-height:104px;">
  											        <img class="mui-media-object mui-pull-left"  src="<?php echo $this->_tpl_vars['orders_products_info']['productthumbnail']; ?>
">
  													<div class="mui-media-body order-info">
														<p class='mui-ellipsis-2' style="color:#333"><?php echo $this->_tpl_vars['orders_products_info']['productname']; ?>
</p>
  																												<?php if ($this->_tpl_vars['orders_products_info']['activitymode'] == '1'): ?>
															<p class='mui-ellipsis'>
																砍价：<?php if ($this->_tpl_vars['orders_products_info']['bargains_count'] == 0): ?>还没有好友帮忙砍价<?php else: ?>已有 <?php echo $this->_tpl_vars['orders_products_info']['bargains_count']; ?>
 位好友帮忙砍价<?php endif; ?>
															</p>
														<?php endif; ?>
														<?php if (floatval($this->_tpl_vars['orders_products_info']['postage']) > 0 && ( intval($this->_tpl_vars['orders_products_info']['includepost']) == 0 || intval($this->_tpl_vars['orders_products_info']['includepost']) > intval($this->_tpl_vars['orders_products_info']['productallcount']) )): ?>
															<p class='mui-ellipsis'>
																																																																																	<?php if (intval($this->_tpl_vars['orders_products_info']['includepost']) > 0): ?>
																	<span style="color:#878787;margin-left:10px;">(<?php echo $this->_tpl_vars['orders_products_info']['includepost']; ?>

																												  件包邮)</span>
																<?php endif; ?>
															</p>
														<?php endif; ?>
  													</div>
  												<div class="mui-pull-right" style="margin-right: 10px">
  													<span><?php if ($this->_tpl_vars['orders_products_info']['zhekou'] != '' && ((is_array($_tmp=$this->_tpl_vars['orders_products_info']['zhekou'])) ? $this->_run_mod_handler('floatval', true, $_tmp) : floatval($_tmp)) > 0): ?><?php if ($this->_tpl_vars['orders_products_info']['activitymode'] == '1'): ?><?php else: ?><?php endif; ?><span class="price">¥<?php echo $this->_tpl_vars['orders_products_info']['shop_price']; ?>
</span> <span style="color:#878787;margin-left:5px;text-decoration:line-through;">¥<?php echo $this->_tpl_vars['orders_products_info']['old_shop_price']; ?>
</span><?php else: ?><span class="price">¥<?php echo $this->_tpl_vars['orders_products_info']['shop_price']; ?>
</span><?php endif; ?></span><br>
													<span>x<?php echo $this->_tpl_vars['orders_products_info']['quantity']; ?>
</span><br>
  												</div>
		  									</li>
							   		  <?php endforeach; endif; unset($_from); ?>
						 	 	</ul>
						</div>
					</div>
				</div>
		    </div>
	    </div>

	<script type="text/javascript">
	<?php echo '
	    mui.init({
	        pullRefresh: {
	            container: \'#pullrefresh\'
	        },
	    });
		mui.ready(function() {
			mui(\'#pullrefresh\').scroll();
			mui(\'.mui-bar\').on(\'tap\',\'a\',function(e){
				mui.openWindow({
					url: this.getAttribute(\'href\'),
					id: \'info\'
				});
			});
			mui(\'.mui-table-view-cell\').on(\'tap\',\'a#wuliu\',function(e){
				mui.openWindow({
					url: this.getAttribute(\'href\'),
					id: \'info\'
				});
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
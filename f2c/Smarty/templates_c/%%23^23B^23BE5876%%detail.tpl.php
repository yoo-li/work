<?php /* Smarty version 2.6.18, created on 2017-08-16 11:12:09
         compiled from detail.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'floatval', 'detail.tpl', 231, false),array('modifier', 'intval', 'detail.tpl', 238, false),array('modifier', 'string_format', 'detail.tpl', 248, false),array('modifier', 'count', 'detail.tpl', 273, false),)), $this); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title></title>
    <link href="public/css/mui.css" rel="stylesheet" />
    <link href="public/css/public.css" rel="stylesheet" />
    <link href="public/css/iconfont.css" rel="stylesheet" />
	<script src="public/js/mui.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="public/js/zepto.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="public/js/lazyload.min.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript" src="public/js/jweixin.js"></script>
	<script src="public/js/utils.js" type="text/javascript" charset="utf-8"></script>
	<script src="public/js/detail.js" type="text/javascript" charset="utf-8"></script>
	<style>
	<?php echo '
	 .name,.detail{ -webkit-margin-start:0px;  }
	 .img-responsive { display: block; height: auto; width: 100%; }
	 .price1 {text-decoration:line-through; color:#000;  }
	 .price3 {text-decoration:line-through; color:#999;  }
	 .price2 {padding-left:5px;color:#CF2D28; font-size:1.2em; font-weight:500; }
	 .price1 span,.price2 span,span.price{font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif; margin-left:0}
	 .price2 span {font-size:1.1em}
	 .mycollections {font-size:1.8em;color:#fe4401;}

	 .yanse_xz a{color:#ccc;margin-bottom:2px;margin-top:2px;}

	 .btn {
	   display: inline-block;
	   padding: 6px 12px;
	   margin-bottom: 0;
	   font-weight: normal;
	   line-height: 1.428571429;
	   text-align: center;
	   white-space: nowrap;
	   vertical-align: middle;
	   cursor: pointer;
	   background-image: none;
	   border: 1px solid transparent;
	   border-radius: 4px;
	   -webkit-user-select: none;
	   -moz-user-select: none;
	   -ms-user-select: none;
	   -o-user-select: none;
	   user-select: none;
	 }
	 .btn-default {
	   color: #333;
	   background-color: #fff;
	   border-color: #ccc;
	 }
	  .btn-default:hover, .btn-default:focus, .btn-default:active, .btn-default.active  {
	   color: #333;
	   background-color: #ebebeb;
	   border-color: #e53348;
	   background: url(images/checked.png) no-repeat bottom right;
	 }
	 .totalprice{
	   color:#CF2D28;
	   margin-top: 9px;
	 }
	 #inventory_label
	 {
		color:#CF2D28;
		font-size: 16px;
	 }
 	.mui-bar-tab .mui-tab-item, .mui-bar-tab .mui-tab-item.mui-active {
 	  color: #cc3300;
 	}
	.mui-table-view-cell:after {
	  left: 0px;
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

        <!-- 主页面容器 -->
        <div class="mui-inner-wrap">
            <!-- 主页面标题 -->
            <header class="mui-bar mui-bar-nav">
                <a class="mui-icon mui-action-back mui-icon-back mui-pull-left"></a>
                <h1 class="mui-title">商品详情</h1>
            </header>
			<nav class="mui-bar mui-bar-tab" style="height:40px;line-height:40px;">
				<a class="mui-tab-item mui-active home" href="/index.php" >
					<span class="mui-tab-label">
						  <span class="mui-icon iconfont icon-mainpage"></span>&nbsp;&nbsp;首页
				    </span>
				</a>
				<a class="mui-tab-item mui-active addshoppingcart" href="#" >
					<span class="mui-tab-label">
						  <span class="mui-icon iconfont icon-jiarugouwuche mui-twinkling" ></span>&nbsp;&nbsp;加入购物车
				    </span>
				</a>
				<a class="mui-tab-item mui-active shoppingcart" href="shoppingcart.php" >
					<span class="mui-tab-label">
						  <span class="mui-icon iconfont icon-shoppingcart " id="shoppingcart">
							   <span id="shoppingcart_badge"><?php if ($this->_tpl_vars['share_info']['shoppingcart'] != '0' && $this->_tpl_vars['share_info']['shoppingcart'] != ''): ?>
							   		<span class="mui-badge"><?php echo $this->_tpl_vars['share_info']['shoppingcart']; ?>
</span>
							   		<?php endif; ?>
							   </span>
					      </span>
						   &nbsp;&nbsp;立即结算
				   </span>
				</a>
			</nav>

            <div id="pullrefresh" class="mui-content mui-scroll-wrapper">
                <div class="mui-scroll">
                    <!-- 主界面具体展示内容 -->
			         <div  style="margin: 5px 5px;">
							 <img class="mui-media-object" style="border-radius: 6px;width: 100%;max-width: 100%;height: auto;" id="productlogo" src="<?php echo $this->_tpl_vars['productinfo']['productlogo']; ?>
">
				     </div>
					 <input type="hidden" id="property_type_count" value="<?php echo $this->_tpl_vars['property_type_count']; ?>
" />
					 <input type="hidden" id="from" value="<?php echo $this->_tpl_vars['from']; ?>
" />
					 <input type="hidden" id="product_property_id" name="product_property_id" value="" />
					 <input type="hidden" id="pagenum" name="pagenum" value="<?php echo $this->_tpl_vars['pagenum']; ?>
">
					 <input type="hidden" id="scrolltop" name="scrolltop" value="<?php echo $this->_tpl_vars['scrolltop']; ?>
">
					 <input type="hidden" id="productid" name="productid" value="<?php echo $this->_tpl_vars['productid']; ?>
">
					 <input type="hidden" name="total_price" id="total_price1" value="<?php echo $this->_tpl_vars['productinfo']['shop_price']; ?>
" />
					 <input type="hidden" name="shop_price" id="shop_price1" value="<?php echo $this->_tpl_vars['productinfo']['shop_price']; ?>
" />
					 <input type="hidden" name="inventory" id="inventory1" value="<?php echo $this->_tpl_vars['productinfo']['inventory']; ?>
" />
					 <input type="hidden" name="zhekou" id="zhekou" value="<?php echo $this->_tpl_vars['productinfo']['zhekou']; ?>
" />
					 <input type="hidden" name="salesactivityid" id="salesactivityid" value="<?php echo $this->_tpl_vars['productinfo']['salesactivityid']; ?>
" />
					 <input type="hidden" name="salesactivity_product_id" id="salesactivity_product_id" value="<?php echo $this->_tpl_vars['productinfo']['salesactivity_product_id']; ?>
" />

					 <input type="hidden" name="type" id="type" value="<?php echo $this->_tpl_vars['type']; ?>
" />
					 <input type="hidden" id="jd" value="<?php echo $this->_tpl_vars['jd']; ?>
" />
                    <!--detail-->
                    <div class="mui-content-padded">
                        <p style="margin-bottom: 0;">
                            <span class="detail-title"><?php echo $this->_tpl_vars['productinfo']['productname']; ?>
</span>
                        </p>
                        <p class="info">
							<?php if ($this->_tpl_vars['supplier_info']['showtradeorderrecord'] == '0'): ?>
								<span class="mui-badge mui-badge-primary"><?php echo $this->_tpl_vars['tradecount']; ?>
成交</span>
							<?php else: ?>
								<span class="mui-badge mui-badge-primary" style="background-color:inherit;">&nbsp;</span>
							<?php endif; ?>
							<?php if ($this->_tpl_vars['supplier_info']['productappraises'] == '0'): ?><span class="mui-badge mui-badge-primary"><?php echo $this->_tpl_vars['appraisecount']; ?>
评</span><?php endif; ?>
							<?php if ($this->_tpl_vars['productinfo']['activityname'] != '' && $this->_tpl_vars['productinfo']['zhekoulabel'] != '' && $this->_tpl_vars['productinfo']['zhekou'] != ''): ?>
								<span class="price">￥<b style="font-size: 32px;" id="shop_price"><?php echo $this->_tpl_vars['productinfo']['promotional_price']; ?>
</b>元</span>
							<?php else: ?>
								<span class="price">￥<b style="font-size: 32px;" id="shop_price"><?php echo $this->_tpl_vars['productinfo']['shop_price']; ?>
</b>元</span>
							<?php endif; ?>
                        </p>
						<ul id="propertygroup" class="mui-table-view" style="background: #f3f3f3;">
							<?php if ($this->_tpl_vars['productinfo']['vendorname'] != '' && $this->_tpl_vars['supplier_info']['showvendor'] == '1'): ?>
							<li class="mui-table-view-cell" >
								  <span class="mui-pull-left">供应商 : &nbsp;&nbsp; </span>
								  <div class="mui-pull-left">
					  				 <span><?php echo $this->_tpl_vars['productinfo']['vendorname']; ?>
</span>
	 							  </div>
	 			            </li>
							<?php endif; ?>
							<?php if ($this->_tpl_vars['productinfo']['shop_price'] == ''): ?>
							<li class="mui-table-view-cell" >
								 <span class="mui-pull-left">市场价 : <span class="price1">￥<span id="market_price"><?php echo $this->_tpl_vars['productinfo']['market_price']; ?>
</span></span></span>
			                     <span class="mui-pull-right">
								 <input type="hidden" id="mycollection" value="<?php echo $this->_tpl_vars['mycollections']; ?>
">
								 <?php if ($this->_tpl_vars['mycollections'] == '0'): ?>
								     <a class="mycollection" href="#" >
			                            <span id="mycollectionicon" class="mui-icon iconfont icon-nocollection mui-slow-twinkbng mycollections"></span>
								 	 </a>
			                     <?php else: ?>
			                          <a class="mycollection" href="#" >
			                            <span id="mycollectionicon" class="mui-icon iconfont icon-collection mycollections"></span>
								 	  </a>
			                     <?php endif; ?>
							     </span>
							</li>
							<?php endif; ?>

							<?php if ($this->_tpl_vars['productinfo']['activityname'] != '' && $this->_tpl_vars['productinfo']['zhekoulabel'] != '' && $this->_tpl_vars['productinfo']['zhekou'] != ''): ?>
								<li class="mui-table-view-cell" >
									 <span class="mui-pull-left">促销原价 : <span class="price1">￥<span id="old_shop_price"><?php echo $this->_tpl_vars['productinfo']['shop_price']; ?>
</span></span>
								</li>
								<li class="mui-table-view-cell" >
									 <span class="mui-pull-left">促销活动 : <span class="price"><?php echo $this->_tpl_vars['productinfo']['activityname']; ?>
【<?php echo $this->_tpl_vars['productinfo']['zhekoulabel']; ?>
】</span></span>
								</li>
							<?php endif; ?>

			                <?php $_from = $this->_tpl_vars['property_type']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['propertygroup'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['propertygroup']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['property_name'] => $this->_tpl_vars['property_info']):
        $this->_foreach['propertygroup']['iteration']++;
?>
			                   <li class="mui-table-view-cell" style="padding: 5px 15px;">
								    <span class="mui-pull-left"><?php echo $this->_tpl_vars['property_name']; ?>
 : &nbsp;&nbsp; </span>
			                        <div class="yanse_xz mui-pull-left">
			                        <input type="hidden" id="propertygroup_label_<?php echo $this->_foreach['propertygroup']['iteration']; ?>
" value="<?php echo $this->_tpl_vars['property_name']; ?>
" />
			                        <?php $_from = $this->_tpl_vars['property_info']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['property'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['property']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['propertyid'] => $this->_tpl_vars['property']):
        $this->_foreach['property']['iteration']++;
?>
			                            <a class="btn btn-default propertygroup_<?php echo $this->_foreach['propertygroup']['iteration']; ?>
" groupid="<?php echo $this->_foreach['propertygroup']['iteration']; ?>
" propertyid="<?php echo $this->_tpl_vars['propertyid']; ?>
" href="javascript:;"  ><?php echo $this->_tpl_vars['property']; ?>

			                                <div style="display:none">
			                                    <input class="propertygroup_input_<?php echo $this->_foreach['propertygroup']['iteration']; ?>
" id="property_<?php echo $this->_foreach['propertygroup']['iteration']; ?>
_<?php echo $this->_tpl_vars['propertyid']; ?>
" type="radio" name="propertygroup_<?php echo $this->_foreach['propertygroup']['iteration']; ?>
" propertyid="<?php echo $this->_tpl_vars['propertyid']; ?>
" value="<?php echo $this->_tpl_vars['property']; ?>
" />
			                                </div>
			                            </a>
			                        <?php endforeach; endif; unset($_from); ?>
								    </div>
			                   </li>
			                <?php endforeach; endif; unset($_from); ?>
							<li class="mui-table-view-cell" >
								  <span class="mui-pull-left">购买数量 : &nbsp;&nbsp; </span>
								  <div class="mui-pull-left">
					  				<div class="mui-numbox" data-numbox-step='1' data-numbox-min='1' data-numbox-max='999'>
					  					<button class="mui-btn mui-numbox-btn-minus" type="button">-</button>
										<input value="<?php echo $this->_tpl_vars['productinfo']['postage']; ?>
" id="postage" type="hidden"/>
										<input value="<?php echo $this->_tpl_vars['productinfo']['includepost']; ?>
" id="includepost" type="hidden"/>
										<input value="<?php echo $this->_tpl_vars['productinfo']['mergepostage']; ?>
" id="mergepostage" type="hidden"/>
					  					<input onkeyup="recalc();" readonly   id="qty_item" name="qty_item" class="mui-numbox-input" type="number" />
					  					<button class="mui-btn mui-numbox-btn-plus" type="button">+</button>
					  				</div>

	 							  </div>
								  <?php if ($this->_tpl_vars['jd'] != '1'): ?>
								  <div class="mui-pull-left" style="padding-left:5px;">
									  <button id="numaddten" class="mui-btn mui-numbox-btn-plus" type="button" style="height:36px;">+10</button>
								  </div>
								  <?php endif; ?>
	 			            </li>
							<li class="mui-table-view-cell" >
								  <span class="mui-pull-left">库存数量 : &nbsp;&nbsp; </span>
								  <div class="mui-pull-left">
									  <?php if ($this->_tpl_vars['jd'] == '1'): ?>
					  				  <span id="inventory_label"><?php if ($this->_tpl_vars['productinfo']['inventory'] == '0'): ?>无货<?php else: ?>有货<?php endif; ?></span>
									  <?php else: ?>
									  <span id="inventory_label"><?php echo $this->_tpl_vars['productinfo']['inventory']; ?>
</span>&nbsp;件
									  <?php endif; ?>
	 							  </div>
	 			            </li>
							<li id="postage_panel" class="mui-table-view-cell"  style="display: <?php if (floatval($this->_tpl_vars['productinfo']['postage']) > 0): ?>block<?php else: ?>none<?php endif; ?>;">
								<span class="mui-pull-left">邮费 : &nbsp;&nbsp; </span>
								<div class="mui-pull-left">
									<span class="totalprice">￥<b><span id="postage_span" style="font-size: 16px;"><?php echo $this->_tpl_vars['productinfo']['postage']; ?>
</span></b>元（满119包邮）</span>
																		<?php if (intval($this->_tpl_vars['productinfo']['includepost']) > 0): ?>
										<span style="color:#878787;margin-left:10px;">(<?php echo $this->_tpl_vars['productinfo']['includepost']; ?>

																					  件包邮)</span>
									<?php endif; ?>
								</div>
							</li>
							<li class="mui-table-view-cell" >
								  <span class="mui-pull-left">合计 : &nbsp;&nbsp; </span>
								  <div class="mui-pull-left">
									  <?php if ($this->_tpl_vars['productinfo']['activityname'] != '' && $this->_tpl_vars['productinfo']['zhekoulabel'] != '' && $this->_tpl_vars['productinfo']['zhekou'] != ''): ?>
									   		<span class="totalprice">￥<b><span id="totalprice" style="font-size: 16px;"><?php echo ((is_array($_tmp=$this->_tpl_vars['productinfo']['promotional_price']+$this->_tpl_vars['productinfo']['postage'])) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.2f") : smarty_modifier_string_format($_tmp, "%.2f")); ?>
</span></b>元</span>
									  <?php else: ?>
									  	 	<span class="totalprice">￥<b><span id="totalprice" style="font-size: 16px;"><?php echo ((is_array($_tmp=$this->_tpl_vars['productinfo']['shop_price']+$this->_tpl_vars['productinfo']['postage'])) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.2f") : smarty_modifier_string_format($_tmp, "%.2f")); ?>
</span></b>元</span>
									  <?php endif; ?>
	 							  </div>
	 			            </li>
						</ul>

						<?php if ($this->_tpl_vars['supplier_info']['productdisplaymode'] == '0'): ?>
                       		<a id="detail_image" href="javascript:;"><h5 class="show-content" style="padding: 10px;">图文详情【点击查看更多图文详情】</h5></a>
                        <?php endif; ?>
                        <div id="segmentedControl" class="mui-slider-indicator mui-segmented-control mui-segmented-control-inverted">
                            <a class="mui-control-item mui-active" href="#item1mobile">商品描述</a>
                            <?php if ($this->_tpl_vars['supplier_info']['productappraises'] == '0'): ?>
                            <a class="mui-control-item" href="#item2mobile">累计评价</a>
                            <?php endif; ?>
                           <?php if ($this->_tpl_vars['supplier_info']['showtradeorderrecord'] == '0'): ?> <a class="mui-control-item" href="#item3mobile">成交记录</a><?php endif; ?>
                            <a class="mui-control-item" href="#item4mobile">服务声明</a>
                        </div>
                        <div class="mui-content-padded-2" style="background: #FFFFFF; padding: 10px;">
                            <div id="item1mobile" class="mui-control-content mui-active">
								<?php echo $this->_tpl_vars['productinfo']['simple_desc']; ?>

							</div>
						    <?php if ($this->_tpl_vars['supplier_info']['productappraises'] == '0'): ?>
                            <div id="item2mobile" class="mui-control-content">
								<?php if (count($this->_tpl_vars['appraises']) == 0): ?>
								 <h5 class="show-content" style="padding: 10px;background: #ff5400;">目前没有评价。</h5>
								<?php else: ?>
									<ul class="mui-table-view">
										<?php $_from = $this->_tpl_vars['appraises']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['appraises'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['appraises']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['appraises_info']):
        $this->_foreach['appraises']['iteration']++;
?>
											<li class="mui-table-view-cell" style="padding: 8px 5px;">
												<div class="mui-media-body">
													<img class="mui-media-object mui-pull-left" style="width:20px;height:20px;" src="<?php echo $this->_tpl_vars['appraises_info']['headimgurl']; ?>
">
													<span style="width:80px;text-align:left;display:inline-block;"><?php echo $this->_tpl_vars['appraises_info']['givenname']; ?>
</span>
													【<?php echo $this->_tpl_vars['appraises_info']['praise_info']; ?>
】
												</div>
												<div class="mui-media-body" style="padding-left:30px;color:#4d4d4d">
													 <?php echo $this->_tpl_vars['appraises_info']['remark']; ?>

												</div>
												<?php if ($this->_tpl_vars['appraises']['hasimages'] > 0): ?>
												<div class="mui-media-body" style="padding-left:30px;">
													  <?php $_from = $this->_tpl_vars['appraises']['images']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['appraise_images'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['appraise_images']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['appraise_image_info']):
        $this->_foreach['appraise_images']['iteration']++;
?>
													      <img class="mui-media-object mui-pull-left" src="<?php echo $this->_tpl_vars['appraise_image_info']; ?>
">
													  <?php endforeach; endif; unset($_from); ?>
												</div>
												<?php endif; ?>
												<div class="mui-media-body" style="padding-left:30px;color:#999">
													 <?php echo $this->_tpl_vars['appraises_info']['published']; ?>

												</div>
										    </li>
										<?php endforeach; endif; unset($_from); ?>
									</ul>
									 <a id="moreappraises" href="javascript:;"><h5 class="show-content" style="padding: 10px;background: #ff5400;">【点击查看更多评价】</h5></a>
								<?php endif; ?>
							</div>
							<?php endif; ?>
							<?php if ($this->_tpl_vars['supplier_info']['showtradeorderrecord'] == '0'): ?>
                            <div id="item3mobile" class="mui-control-content">
								<ul class="mui-table-view">
									<li class="mui-table-view-cell" style="padding: 8px 5px;">
										<div class="mui-media-body  mui-pull-left">
											<span style="width:80px;text-align:left;display:inline-block;">买家</span>价格
										</div>
										<div class="mui-media-body mui-pull-right">
											<span style="width:105px;text-align:right;display:inline-block;">购买时间</span>
										</div>
										<div class="mui-media-body mui-pull-right">
											<span style="width:30px;text-align:left;display:inline-block;">数量</span>
										 </div>
								    </li>
									<?php $_from = $this->_tpl_vars['transactionrecords']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['transactionrecords'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['transactionrecords']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['transactionrecord_info']):
        $this->_foreach['transactionrecords']['iteration']++;
?>
										<li class="mui-table-view-cell" style="padding: 8px 5px;">
											<div class="mui-media-body  mui-pull-left">
												<span style="width:80px;text-align:left;display:inline-block;"><?php echo $this->_tpl_vars['transactionrecord_info']['givenname']; ?>
</span>¥<?php echo $this->_tpl_vars['transactionrecord_info']['shop_price']; ?>

											</div>
											<div class="mui-media-body mui-pull-right">
												<span style="width:105px;text-align:right;display:inline-block;"><?php echo $this->_tpl_vars['transactionrecord_info']['published']; ?>
</span>
											</div>
											<div class="mui-media-body mui-pull-right">
												<span style="width:30px;text-align:left;display:inline-block;"><?php echo $this->_tpl_vars['transactionrecord_info']['quantity']; ?>
</span>
											 </div>
									    </li>
									<?php endforeach; endif; unset($_from); ?>
								</ul>
							</div>
							<?php endif; ?>
                            <div id="item4mobile" class="mui-control-content">
							         <h3 class="show-content"><em>卖家承诺以下服务</em></h3>
							         <div class="show-content">
							   		         <dl class="seven-days">
							       			            <dd class="name" >退换货规则</dd>
							                            <dd class="detail">
							                               <p>1.订单未支付前，可以随时取消该订单；</p>
							                               <p>2.订单支付成功后，若您想取消该订单，因为物流流转速度很快，请您提交退货退款申请后及时联系在线客服咨询此订单的配送情况，若订单尚未出库，会在3个工作日内为您办理退款，退款金额原路返回至您的账户。若订单已经出库进入配送阶段，请您选择拒收此单，待订单退库成功后，3个工作日内为您办理退款，退款金额原路返回至您的账户。若您不拒收此单，我们将拒绝您的退款申请；</p>
														   <p>3.自客户收到商品之日起7日内可以退货，15日内可以换货<span style="color:red">（特殊商品不支持退换货，具体细则请点击）</span></p>
														   <p>4.您退货时应当将商品本身、配件及赠品（包括赠送的实物、积分、代金券、优惠券等形式）一并退回。若赠品不能一并退回，惠民商城有权要求您按照事先标明的赠品价格支付赠品价款。</p>
															<p>5.退货价款以您实际支出的价款为准。</p>
															<p>6.您退货时所产生的运费依法由您自行承担，另有约定的除外。</p>
															<p>7.该退换货规则根据实际运营情况酌情修改。</p>
							                           </dd>
												 </dl>
												 <dl>
												 <h3 class="show-content"><em>具体细则</em></h3>
												 <dd class="name" >以下商品不支持无理由退货：</dd>
												 <dd class="detail">
													 <p>1.个人定制类；</p>
													 <p>2.鲜活易腐类；</p>
													 <p>3.在线下载类/拆封的音像制品/计算机软件等数字化商品；</p>
													 <p>4.交付的报纸期刊类商品；</p>
													 <p>5.根据商品性质不适宜退货，并经您在购买时确认的商品：</p>
													 <p>a.拆封后易影响人身安全或者生命健康的商品，或者拆封后易导致商品品质发生改变的商品；</p>
													 <p>b.一经激活或者试用后价值贬损较大的商品；</p>
													 <p>c.销售时已明示的临近保质期的商品、有瑕疵的商品；</p>
													 <p>d.其他根据商品性质不适宜退货，在商品页面标注“不支持无理由退货”并经您在购买时确认的商品；</p>
													 <p>6.无法保证退回商品完好的商品（能够保持原有品质、功能，商品本身、配件、商标标识齐全的，视为商品完好）。</p>
												 </dd>
											 </dl>
										 <dl>
												 <dd class="name" >以下商品不支持退换货：</dd>
												 <dd class="detail">
												 <p>1.任何非惠民商城出售的商品；</p>
												 <p>2.过保商品（超过三包保修期的商品）；</p>
												 <p>3.未经授权的维修、误用、碰撞、疏忽、滥用、进液、事故、改动、不正确的安装所造成的商品质量问题，或撕毁、涂改标贴、机器序号、防伪标记；</p>
												 <p>4.三包凭证信息与商品不符及被涂改的；</p>
												 <p>5.其他依法不应办理退换货的。</p>
												 </dd>
											 </dl>

							         </div>
							</div>
                        </div>
						<?php if ($this->_tpl_vars['supplier_info']['productdisplaymode'] == '1'): ?>
						<div class="mui-content-padded" style="background: #FFFFFF; padding: 5px;margin:0px;margin-top: 5px;">
							 <?php echo $this->_tpl_vars['productinfo']['description']; ?>

 			            </div>
                        <?php endif; ?>
						<?php if ($this->_tpl_vars['supplier_info']['productqrcode'] == '0'): ?>
						<div class="mui-content-padded" style="margin:0px;margin-top: 5px;">
	   							 <img class="mui-media-object" style="border-radius: 6px;width: 100%;max-width: 100%;height: auto;" src="productqrcode.php?productid=<?php echo $this->_tpl_vars['productid']; ?>
">
	   				    </div>
                        <div class="mui-table-view-cell" id="checking-wrap-tip">
                            <div class="mui-media-body" style="color:red;text-align:center">
                               以上二维码图片可以保存后转发，效果更佳！
                            </div>
                        </div>
                        <?php endif; ?>
						<div class="show-content" style="padding-top: 15px;"><img class="img-responsive" src="images/baozhang.png"></div>
                    </div>
                    <!--end detail-->
                </div>
            </div>
            <div class="mui-backdrop" style="display:none;"></div>
        </div>


	<script type="text/javascript">
	    var propertys = <?php echo $this->_tpl_vars['propertys']; ?>
;
	<?php echo '
	    mui.init({
	        pullRefresh: {
	            container: \'#pullrefresh\'
	        },
	    });

		mui.ready(function() {
			mui(\'#pullrefresh\').scroll();
			$(".lazy").lazyload();
			mui(\'.mui-bar\').on(\'tap\',\'a.addshoppingcart\',function(e){
				addshoppingcart();
			});
			mui(\'.mui-bar\').on(\'tap\',\'a.shoppingcart\',function(e){
				var shoppingcarturl = this.getAttribute(\'href\');
				checkshoppingcart(shoppingcarturl);
			});
			mui(\'.mui-bar\').on(\'tap\', \'a.home\', function (e){
				  mui.openWindow({url: this.getAttribute(\'href\'), id: \'info\'});
			});



			mui(\'#propertygroup\').on(\'tap\',\'a.mycollection\',function(e){
				  var productid = Zepto(\'#productid\').val();
				  var status = Zepto(\'#mycollection\').val();
				  if (status == "0")
				  {

					   var postbody = \'record=\' + productid + \'&status=1\';
	 		           mui.ajax({
	 			            type: \'POST\',
	 			            url: "mycollection_add.ajax.php",
	 			            data: postbody,
	 			            success: function(json) {
	 								 mui.toast("成功添加到收藏！");
	 								  Zepto(\'#mycollection\').val("1");
	 								  Zepto("#mycollectionicon").addClass("icon-collection");
	 								  Zepto("#mycollectionicon").removeClass("icon-nocollection");
	 								  Zepto("#mycollectionicon").removeClass("mui-slow-twinkling");
		 			            }
	 					 });
				  }
				  else
				  {

					   var postbody = \'record=\' + productid + \'&status=0\';
	 		           mui.ajax({
	 			            type: \'POST\',
	 			            url: "mycollection_add.ajax.php",
	 			            data: postbody,
	 			            success: function(json) {
	 								 mui.toast("成功取消收藏！");
	 								 Zepto(\'#mycollection\').val("0");
	 								 Zepto("#mycollectionicon").addClass("icon-nocollection");
	 								 Zepto("#mycollectionicon").addClass("mui-slow-twinkling");
	 								  Zepto("#mycollectionicon").removeClass("icon-collection");
	 			            }
	 					 });

				  }
			});
			mui(\'#detail_image\').on(\'tap\',\'h5\',function(e){
				detail_image();
			});
			mui(\'#moreappraises\').on(\'tap\',\'h5\',function(e){
				var from = Zepto(\'#from\').val();
				var pagenum = Zepto(\'#pagenum\').val();
				var scrolltop = Zepto(\'#scrolltop\').val();
				var productid = Zepto(\'#productid\').val();
				var url = \'detail_appraise.php?productid=\'+productid+\'&scrolltop=\'+scrolltop+\'&pagenum=\'+pagenum+\'&from=\'+from;
				mui.openWindow({
					url: url,
					id: \'info\'
				});
			});
			mui(\'#propertygroup\').on(\'tap\', \'a\', function(e) {

				var groupid =  this.getAttribute(\'groupid\');
				var propertyid =  this.getAttribute(\'propertyid\');

				Zepto(".propertygroup_"+groupid).removeClass("active");
				Zepto(this).addClass("active");

				Zepto(".propertygroup_input_"+groupid).attr("checked",false);
				Zepto("#property_"+groupid+"_"+propertyid).attr("checked",true);
				Zepto("#type").val(\'\');
				change_price();
			});
			mui(\'.mui-numbox\').on(\'change\', \'input\', function() {
			     recalc();
			});
			mui(\'.mui-table-view-cell\').on(\'tap\', \'button#numaddten\', function() {
				 var qty_item = Zepto(\'#qty_item\').val();
				 var new_qty_item = parseInt(qty_item,10) + 10;
				 Zepto(\'#qty_item\').val(new_qty_item);
				  recalc();
			});

		});
		function detail_image()
		{
			var from = Zepto(\'#from\').val();
			var pagenum = Zepto(\'#pagenum\').val();
			var scrolltop = Zepto(\'#scrolltop\').val();
			var productid = Zepto(\'#productid\').val();
			var url = \'detail_image.php?productid=\'+productid+\'&scrolltop=\'+scrolltop+\'&pagenum=\'+pagenum+\'&from=\'+from;
			mui.openWindow({
				url: url,
				id: \'info\'
			});
		}
		function checkshoppingcart(shoppingcarturl)
		{
            var inventory = Zepto(\'#inventory1\').val();
            var newinventory = parseInt(inventory,10);
            if ( newinventory <= 0)
            {
				mui.toast(\'您选择的商品已经卖完了！\');
                return false;
            }
			if (Zepto(\'#type\').val() == "")
			{
	            var property_type_count = Zepto(\'#property_type_count\').val();
	            for(var i=1;i<=property_type_count;i++)
	            {
					var radio = Zepto(\'input[name=propertygroup_\'+i+\'][checked=true]\');
	                if( radio.val() == undefined )
	                {
	                    mui.toast(\'请选择商品的\'+Zepto(\'#propertygroup_label_\'+i).val());
	                    return false;
	                }
	            }
				mui.toast(\'您还需要选择商品的属性！\');
				return false;
			}
			else
			{
				var qty_item = Zepto(\'#qty_item\').val();
				var productid = Zepto(\'#productid\').val();
				var product_property_id = Zepto(\'#product_property_id\').val();

			    var postbody = \'shoppingcart=1&record=\' + productid + \'&quantity=\' + qty_item;
			    if (product_property_id != "" && product_property_id != undefined)
				{
					postbody = \'type=detail&shoppingcart=1&record=\' + productid + \'&quantity=\' + qty_item + \'&propertyid=\' + product_property_id;
				}
				var salesactivityid = Zepto(\'#salesactivityid\').val();
				var salesactivity_product_id = Zepto(\'#salesactivity_product_id\').val();
				if (salesactivityid != "" && salesactivity_product_id != "")
				{
					postbody += \'&salesactivityid=\'+salesactivityid + \'&salesactivitys_product_id=\'+salesactivity_product_id;
				}

		        mui.ajax({
			            type: \'POST\',
			            url: "shoppingcart_add.ajax.php",
			            data: postbody,
			            success: function(json) {
			                var jsondata = eval("("+json+")");
			                if (jsondata.code == 200) {
								mui.openWindow({
									url: shoppingcarturl,
									id: \'info\'
								});
			                }
							else
							{
								 mui.toast(jsondata.msg);
							}
			            }
					 });
			}
		}
		function addshoppingcart()
		{
            var inventory = Zepto(\'#inventory1\').val();
            var newinventory = parseInt(inventory,10);
            if ( newinventory <= 0)
            {
				mui.toast(\'您选择的商品已经卖完了！\');
                return false;
            }
			if (Zepto(\'#type\').val() == "")
			{
	            var property_type_count = Zepto(\'#property_type_count\').val();
	            for(var i=1;i<=property_type_count;i++)
	            {
					var radio = Zepto(\'input[name=propertygroup_\'+i+\'][checked=true]\');
	                if( radio.val() == undefined )
	                {
	                    mui.toast(\'请选择商品的\'+Zepto(\'#propertygroup_label_\'+i).val());
	                    return false;
	                }
	            }
				mui.toast(\'您还需要选择商品的属性！\');

				return false;
			}
			else
			{
				var qty_item = Zepto(\'#qty_item\').val();
				var productid = Zepto(\'#productid\').val();
				var product_property_id = Zepto(\'#product_property_id\').val();

			    var postbody = \'record=\' + productid + \'&quantity=\' + qty_item;
			    if (product_property_id != "" && product_property_id != undefined)
				{
					postbody = \'type=detail&record=\' + productid + \'&quantity=\' + qty_item + \'&propertyid=\' + product_property_id;
				}
				var salesactivityid = Zepto(\'#salesactivityid\').val();
				var salesactivity_product_id = Zepto(\'#salesactivity_product_id\').val();
				if (salesactivityid != "" && salesactivity_product_id != "")
				{
					postbody += \'&salesactivityid=\'+salesactivityid + \'&salesactivitys_product_id=\'+salesactivity_product_id;
				}

		        mui.ajax({
			            type: \'POST\',
			            url: "shoppingcart_add.ajax.php",
			            data: postbody,
			            success: function(json) {
			                var jsondata = eval("("+json+")");
			                if (jsondata.code == 200) {
								 mui.toast(jsondata.msg);
								 flyItem("productlogo");
			                     Zepto(\'#shoppingcart_badge\').html(\'<span class="mui-badge">\'+jsondata.shoppingcart+\'</span>\');
			                }
							else
							{
								 mui.toast(jsondata.msg);
							}
			            }
					 });
			}
		}


		function recalc()
		{
			var qty_item = Zepto(\'#qty_item\').val();
			var inventory = Zepto(\'#inventory1\').val();
			var shop_price = Zepto(\'#shop_price1\').val();
			var zhekou = Zepto(\'#zhekou\').val();
			var includepost    = Zepto("#includepost").val();
			var postage        = Zepto("#postage").val();
			var mergepostage   = Zepto("#mergepostage").val();

			var new_qty_item = parseInt(qty_item,10);
			var newinventory = parseInt(inventory,10);
			var newshop_price = parseFloat(shop_price,10);
			var newzhekou = parseFloat(zhekou,10) * 0.1;

			if (newinventory > 0 )
			{
				if (new_qty_item > newinventory )
				{
					new_qty_item = newinventory;
					Zepto(\'#qty_item\').val(newinventory);
				}
				var total = new_qty_item * newshop_price;
				if (newzhekou > 0)
				{
					total = new_qty_item * newshop_price * newzhekou ;
				}

				if (parseFloat(postage, 10) > 0)
				{
					if (parseInt(mergepostage, 10) != 1)
					{
						postage = parseFloat(postage, 10) * parseInt(new_qty_item, 10);
					}
					Zepto("#postage_span").html(parseFloat(postage, 10).toFixed(2));
					if (parseInt(includepost, 10) > 0 && parseInt(includepost, 10) <= parseInt(new_qty_item, 10))
					{
						Zepto("#postage_panel").css(\'display\', \'none;\');
					}
					else
					{
						Zepto("#postage_panel").css(\'display\', \'block;\');
						total = parseFloat(total, 10) + parseFloat(postage, 10);
					}
				}
				Zepto("#totalprice").html(total.toFixed(2));
				Zepto("#total_price1").val(total);
				Zepto("#type").val(\'submit\');
			}
			else
			{
				Zepto("#totalprice").html(\'0.00\');
				Zepto("#type").val(\'\');
			}
		}
	    function product_recalc(shop_price,inventory) {
			var zhekou = Zepto(\'#zhekou\').val();
			var newzhekou = parseFloat(zhekou,10) * 0.1;

			var newinventory = parseInt(inventory,10);
			var qty_item = Zepto(\'#qty_item\').val();
			var new_qty_item = parseInt(qty_item,10);
			var price = parseFloat(shop_price,10);
			var includepost    = Zepto("#includepost").val();
			var postage        = Zepto("#postage").val();
			var mergepostage   = Zepto("#mergepostage").val();
			if (newinventory > 0 )
			{
				if (new_qty_item > newinventory )
				{
					new_qty_item = newinventory;
					Zepto(\'#qty_item\').val(newinventory);
				}
				var total = new_qty_item * price;
				if (newzhekou > 0)
				{
					total = new_qty_item * price * newzhekou;
				}
				if (parseFloat(postage, 10) > 0)
				{
					if (parseInt(mergepostage, 10) != 1)
					{
						postage = parseFloat(postage, 10) * parseInt(new_qty_item, 10);
					}
					Zepto("#postage_span").html(parseFloat(postage, 10).toFixed(2));
					if (parseInt(includepost, 10) > 0 && parseInt(includepost, 10) <= parseInt(new_qty_item, 10))
					{
						Zepto("#postage_panel").css(\'display\', \'none;\');
					}
					else
					{
						Zepto("#postage_panel").css(\'display\', \'block;\');
						total = parseFloat(total, 10) + parseFloat(postage, 10);
					}
				}
				Zepto("#totalprice").html(total.toFixed(2));
				Zepto("#total_price1").val(total);
				Zepto("#type").val(\'submit\');
			}
			else
			{
				Zepto("#totalprice").html(\'0.00\');
				Zepto("#type").val(\'\');
			}
		}

		function change_price()
		{
            var property_type_count = Zepto(\'#property_type_count\').val();
			var propertygroup = [];
            for(var i=1;i<=property_type_count;i++)
            {
				var radio = Zepto(\'input[name=propertygroup_\'+i+\'][checked=true]\');
				if (radio)
				{
					var propertyid = radio.attr("propertyid");
					if (propertyid)
					{
						propertygroup.push(propertyid);
					}
				}
            }
			var propertygroupstr = propertygroup.sort().toString();
            Zepto.each(propertys, function(i, v) {
				var propertyids = v.propertyids;
				var propertyarray = propertyids.split(\',\');
                if (propertygroupstr == propertyarray.sort().toString())
                {
					var zhekou = Zepto(\'#zhekou\').val();
					var newzhekou = parseFloat(zhekou,10) * 0.1;
					if (newzhekou > 0)
					{
						Zepto("#old_shop_price").html(v.shop_price);
						var promotional_price = v.shop_price * newzhekou;
						Zepto("#shop_price").html(promotional_price.toFixed(2));
						Zepto("#shop_price1").val(v.shop_price);
					}
					else
					{
						Zepto("#shop_price").html(v.shop_price);
						Zepto("#shop_price1").val(v.shop_price);
					}
					Zepto("#productlogo").attr("src",v.imgurl);
					Zepto("#product_property_id").val(v.propertytypeid);
					Zepto("#market_price").html(v.market_price);

					Zepto("#productlogo").html(v.imgurl);
					var jd = Zepto("#jd").val();
					if (jd == "1")
					{
						if (v.inventory == \'0\')
						{
							Zepto("#inventory_label").html("无货");
						}
						else
						{
							Zepto("#inventory_label").html("有货");
						}
					}
					else
					{
						Zepto("#inventory_label").html(v.inventory);
					}

					Zepto("#inventory1").val(v.inventory);
					 product_recalc(v.shop_price,v.inventory)
				}

            });
		}
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
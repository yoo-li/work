<?php /* Smarty version 2.6.18, created on 2017-08-11 11:20:59
         compiled from coupons.tpl */ ?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>领券++中心</title>
    <link href="public/css/mui.css" rel="stylesheet" />
    <link href="public/css/public.css" rel="stylesheet" />
	<link href="public/css/iconfont.css" rel="stylesheet" />
	<link href="public/css/voupons.css" rel="stylesheet" />
    <script src="public/js/mui.min.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript" src="public/js/jweixin.js"></script>
	<script src="public/js/zepto.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="public/js/utils.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript" src="public/js/jweixin.js"></script>
	<style>
	  <?php echo '
		 .img-responsive { display: block; height: auto; width: 100%; }
	   	 .mui-bar .tit-sortbar{
	   	 	left: 0;
	   	 	right: 0;
	   	 	margin-top: 44px;
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
	 	header.mui-bar{
            background-color: #f9f9f9 !important;
        }
        header .mui-title, header a{
            color: #232326 !important;
        }
        .mui-segmented-control-negative.mui-segmented-control-inverted .mui-control-item.mui-active{
			color: #fb3e21 !important;
		    border-bottom: 2px solid #fb3e21 !important;
        }
        mui-content .mui-table-view-cell{
        	margin-bottom: 5px;
        	background: #f9f9f9;
        }
        .mui-content .mui-table-view-cell .mui-table-view-label{
	    	width: auto !important;
    		text-align: left !important;
        }
        .mui-bar-tab .mui-tab-item.mui-active{
	        	color: #fb3e21 !important;
        }
        .mui-bar .tit-sortbar{
        	background: #fff;
        }
        .mui-content{
        	background: #fff;
        }
        .mui-table-view:after{
        	display: none;
        }
        .promote-card-list .promote-left-part{
        	width: 38%;
        }
        .promote-left-part .promote-condition{
    	    width: 38%;
        	text-align: center;
        	border-top: 0 !important;
    	    color: #fff !important;
    	    overflow: hidden;
    	    text-overflow: ellipsis;
    	    white-space: nowrap;
        }
        .font-size-12{
        	font-size: 10px !important;
        }
        .tishi{
        	display: block;
        	width: 80px;
        	margin: 0 auto;
            padding-top: 30px;
        }
        .msgbody{
        	font-size: 18px !important;
        }
        .promote-card-list .coupon-style-0 .promote-left-part {
        	text-align: center;
		    background: -webkit-gradient(linear, 0 0, 0 100%, from(#fd740c), to(rgba(253, 116, 12, 0.85)));
		    background: -moz-linear-gradient(top,  #fd740c, #fd740c);
		}
		.promote-card-list .coupon-style-1 .promote-left-part {
			text-align: center;
		    background: -webkit-gradient(linear, 0 0, 0 100%, from(#fd740c), to(#fd740c));
		    background: -moz-linear-gradient(top, #fd740c, #fd740c);
		}
		.promote-card-list .promote-item{
			border-radius: 0;
		}
		.promote-card-list .promote-left-part .promote-card-value i{
			font-weight: 500;
			font-size: 28px;
			font-style: normal;
		}
		.promote-card-list .promote-left-part .promote-card-value p{
			font-size: 10px;
			color:#fff;
			line-height: 20px;
			text-align: center;
		}
		.promote-card-list .promote-left-part .inner {
		    padding: 10px 5px;
		}
		.promote-card-list .promote-right-part{
			width: 60%;
		}
		.promote-use-state{
			font-size: 12px !important;
		    float: right;
			color: #fc7915;
			border: 1px solid #fc7915 !important;
			border-radius: 12px !important;
			padding: 0 5px !important;
			margin-top: 12px !important;
		}
		@media screen and (max-width: 374px) {
			.promote-use-state{
				margin-top: 29px !important;
			}
		}
		.promote-condition{
			position: absolute;
		    bottom: 0;
		    text-align: left;
		    padding: 5px 0px !important;
		    border-top: 1px dashed #ccc !important;
		    color: #a4a4a4;
		    width: 54%;
		}
		.promote-card-list .promote-left-part .promote-card-value{
		    margin-top: 10px;
		}
		.promote-card-list h4{
			font-size: 16px;
			color: #1f2120;
			text-align: left;
			font-weight: 400;
		}
		.promote-card-list .promote-right-part .inner{
			padding: 10px;
		}
		.promote-right-part p{
			margin-top: 30px;
			color: #a4a4a4;
			font-size: 10px;
		}
	 '; ?>

	</style>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'theme.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<?php if ($this->_tpl_vars['supplierids'] == 12352): ?>
		<style>
			<?php echo '
			header.mui-bar {
				background-color: #f9f9f9;
			}
			'; ?>

		</style>
	<?php endif; ?>
	</head>
<body>
<div class="mui-off-canvas-wrap mui-draggable" id="offCanvasWrapper">
		<div class="mui-inner-wrap">
			<header class="mui-bar mui-bar-nav" style="padding-right: 15px;">
				 <a class="mui-icon mui-action-back mui-icon-back mui-pull-left"></a>
				 <h1 class="mui-title">领券中心</h1>
                 <div class="mui-title mui-content tit-sortbar" id="sortbar">
		 				<div id="segmentedControl" class="mui-segmented-control mui-segmented-control-inverted mui-segmented-control-negative">
		 					<a class="mui-control-item mui-active" href="coupons.php">卡券优惠</a>
		 					<a class="mui-control-item" href="couponsofme.php">我的卡券使用记录</a>
		 				</div>
                 </div>
			</header>
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	        <div id="pullrefresh" class="mui-content mui-scroll-wrapper" style="padding-top: 85px;">
                    <div class="mui-scroll">
   		                 <div id="list" class="mui-table-view" >
		 		 							<ul class="mui-table-view" style="padding-top: 5px;padding-bottom: 5px;">
												<div class="promote-card-list" style="margin: 10px 10px;">
			  									  <?php $_from = $this->_tpl_vars['vipcardlist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['vipcards'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['vipcards']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['vipcardid'] => $this->_tpl_vars['vipcard_info']):
        $this->_foreach['vipcards']['iteration']++;
?>
											           <?php $this->assign('iteration', $this->_foreach['vipcards']['iteration']); ?>
   													   <li class="promote-item <?php if ((1 & $this->_tpl_vars['iteration'])): ?>coupon-style-0<?php else: ?>coupon-style-1<?php endif; ?>">
   									                         <a class="clearfix" href=" <?php if ($this->_tpl_vars['vipcard_info']['usagesid'] == ''): ?>coupons_fetch.php<?php else: ?>coupons_view.php<?php endif; ?>?record=<?php echo $this->_tpl_vars['vipcardid']; ?>
">
   									                             <div class="promote-left-part">
   									                                 <div class="inner">
   									                                     <?php if ($this->_tpl_vars['vipcard_info']['cardtype'] == '0'): ?>
																			 <div class="promote-card-value">
	   									                                         <span>￥</span><i><?php echo $this->_tpl_vars['vipcard_info']['amount']; ?>
</i>
																			 </div>
																				 <?php if ($this->_tpl_vars['vipcard_info']['orderamount'] == '0'): ?>
																				 	<div class="promote-condition font-size-12">无门槛优惠券<br/><?php if ($this->_tpl_vars['vipcard_info']['timelimit'] == '0'): ?>限次使用<?php else: ?>不限次使用<?php endif; ?></div>
																				 <?php else: ?>
																				 	<div class="promote-condition font-size-12">满<?php echo $this->_tpl_vars['vipcard_info']['orderamount']; ?>
.00元可用<br/><?php if ($this->_tpl_vars['vipcard_info']['timelimit'] == '0'): ?>限次使用<?php else: ?>不限次使用<?php endif; ?></div>
																				 <?php endif; ?>
																		 <?php elseif ($this->_tpl_vars['vipcard_info']['cardtype'] == '1'): ?>
																			 <div class="promote-card-value">
	   									                                         <span>￥</span><i><?php echo $this->_tpl_vars['vipcard_info']['amount']; ?>
</i>
																			 </div>
																		 		 <?php if ($this->_tpl_vars['vipcard_info']['orderamount'] == '0'): ?>
																		 			<div class="promote-condition font-size-12">无门槛优惠券<br/><?php if ($this->_tpl_vars['vipcard_info']['timelimit'] == '0'): ?>限次使用<?php else: ?>不限次使用<?php endif; ?></div>
																		 		 <?php else: ?>
																				 	<div class="promote-condition font-size-12">满<?php echo $this->_tpl_vars['vipcard_info']['orderamount']; ?>
.00元可用<br/><?php if ($this->_tpl_vars['vipcard_info']['timelimit'] == '0'): ?>限次使用<?php else: ?>不限次使用<?php endif; ?></div>
																		 		 <?php endif; ?>

																		 <?php elseif ($this->_tpl_vars['vipcard_info']['cardtype'] == '2'): ?>
																			 <div class="promote-card-value">
	   									                                        <i><?php echo $this->_tpl_vars['vipcard_info']['discount']; ?>
</i> <span>折</span>
	   									                                     </div>
																			 <?php if ($this->_tpl_vars['vipcard_info']['orderamount'] == '0'): ?>
																			 	 <div class="promote-condition font-size-12">无门槛优惠券<br/><?php if ($this->_tpl_vars['vipcard_info']['timelimit'] == '0'): ?>限次使用<?php else: ?>不限次使用<?php endif; ?></div>
																			 <?php else: ?>
	   									                                    	 <div class="promote-condition font-size-12">满<?php echo $this->_tpl_vars['vipcard_info']['orderamount']; ?>
.00元可用<br/><?php if ($this->_tpl_vars['vipcard_info']['timelimit'] == '0'): ?>限次使用<?php else: ?>不限次使用<?php endif; ?></div>
																			 <?php endif; ?>
                                                                         <?php elseif ($this->_tpl_vars['vipcard_info']['cardtype'] == '3'): ?>
                                                                            <div class="promote-card-value">
                                                                               <span>￥</span><i><?php echo $this->_tpl_vars['vipcard_info']['amount']; ?>
</i>
                                                                            </div>
																		 <?php endif; ?>
   									                                 </div>
   									                             </div>
   									                             <div class="promote-right-part left font-size-12">
   									                                 <div class="inner">
                                                                         <?php if ($this->_tpl_vars['vipcard_info']['cardtype'] == '3'): ?>
                                                                         <h5 style="font-size: 1.2em;"><?php echo $this->_tpl_vars['vipcard_info']['vipcardname']; ?>
</h5>
                                                                         <?php else: ?>
                                                                         <h5 style="font-size: 1.2em;">全品类（特里商品除外）</h5>
																		 <?php endif; ?>
								                                         	<!--<p><?php echo $this->_tpl_vars['vipcard_info']['starttime']; ?>
-<?php echo $this->_tpl_vars['vipcard_info']['endtime']; ?>
</p>-->
																		 <?php if ($this->_tpl_vars['vipcard_info']['usagesid'] == ''): ?>
																		     <div class="promote-use-state font-size-16">未领用</div>
																		 <?php else: ?>
																		     <div class="promote-use-state font-size-16" style="color:#23bf4f;border:1px solid #23bf4f !important;"><?php echo $this->_tpl_vars['vipcard_info']['usagesstatus']; ?>
</div>
																		 <?php endif; ?>
   									                                     <!--<div class="promote-condition font-size-12">已领<?php echo $this->_tpl_vars['vipcard_info']['remaincount']; ?>
张，总计<?php echo $this->_tpl_vars['vipcard_info']['count']; ?>
张</div>-->
																		 <div class="promote-condition font-size-12"><?php echo $this->_tpl_vars['vipcard_info']['starttime']; ?>
-<?php echo $this->_tpl_vars['vipcard_info']['endtime']; ?>
</div>
   									                             </div>
   									                             <i class="expired-icon"></i>
   									                             <i class="left-dot-line"></i>
																 </div>
   									                         </a>
   									                  </li>
			  							   		  <?php endforeach; else: ?>
			  										    <div class="mui-content-padded">
			  						 					   		  <img src="/public/images/coupons.png" alt="" class="tishi">
			  												      <p class="msgbody">还没有券哦~<br>
			  													  </p>
			  							   	            </div>
			  							   		  <?php endif; unset($_from); ?>
												  <br>
											      <hr>
											      <div style="width:100%;margin:13px 0px;">
												      <a href="smk_bindticket.php" type="button" class="mui-btn mui-btn-danger" style="border-radius: 0px;width:100%;line-height:30px;font-size: 18px;">兑换券</a>
											      </div>
											      <a href="smk_ticketagreement.php" style="display:block;text-align:center;text-decoration: underline;color:#333;font-size: 13px;">帮助说明</a>


													<!--

													 <li class="promote-item coupon-style-0">
									                         <a class="clearfix" href="coupons_view.php">
									                             <div class="promote-left-part">
									                                 <div class="inner">
									                                     <h4 class="promote-shop-name font-size-14">甜甜圈10元代金券</h4>
									                                     <div class="promote-card-value">
									                                         <span>￥</span><i>10.00</i>
									                                     </div>
									                                     <div class="promote-condition font-size-12">
									                                         订单满 100.00 元 (含运费)                                    </div>
									                                 </div>
									                             </div>
									                             <div class="promote-right-part center font-size-12">
									                                 <div class="inner">
									                                     <div>
									                                         <p>使用期限</p>
									                                         <p>2015.07.13</p>
									                                         <p>2015.12.31</p>
									                                     </div>
									                                     <div class="promote-use-state font-size-16">
									                                         未使用                                    </div>
									                                 </div>
									                             </div>
									                             <i class="expired-icon"></i>
									                             <i class="left-dot-line"></i>
									                         </a>
									                  </li>

													  <li class="promote-item coupon-style-1">
								                          <a class="clearfix" href="coupons_fetch.php">
								                              <div class="promote-left-part">
								                                  <div class="inner">
								                                      <h4 class="promote-shop-name font-size-14">甜甜圈5元代金券</h4>
								                                      <div class="promote-card-value">
								                                          <span>￥</span><i>5.00</i>
								                                      </div>
								                                      <div class="promote-condition font-size-12">
								                                          订单满 50.00 元 (含运费)                                    </div>
								                                  </div>
								                              </div>
								                              <div class="promote-right-part center font-size-12">
								                                  <div class="inner">
								                                      <div>
								                                          <p>使用期限</p>
								                                          <p>2015.07.13</p>
								                                          <p>2015.12.31</p>
								                                      </div>
								                                      <div class="promote-use-state font-size-16">
								                                          未使用                                    </div>
								                                  </div>
								                              </div>
								                              <i class="expired-icon"></i>
								                              <i class="left-dot-line"></i>
								                          </a>
								                      </li>
													  <li class="promote-item coupon-style-1">
								                          <a class="clearfix" href="coupons_display.php">
								                              <div class="promote-left-part">
								                                  <div class="inner">
								                                      <h4 class="promote-shop-name font-size-14">甜甜圈5元代金券</h4>
								                                      <div class="promote-card-value">
								                                          <span>￥</span><i>5.00</i>
								                                      </div>
								                                      <div class="promote-condition font-size-12">
								                                          订单满 50.00 元 (含运费)                                    </div>
								                                  </div>
								                              </div>
								                              <div class="promote-right-part center font-size-12">
								                                  <div class="inner">
								                                      <div>
								                                          <p>使用期限</p>
								                                          <p>2015.07.13</p>
								                                          <p>2015.12.31</p>
								                                      </div>
								                                      <div class="promote-use-state font-size-16">
								                                          未使用                                    </div>
								                                  </div>
								                              </div>
								                              <i class="expired-icon"></i>
								                              <i class="left-dot-line"></i>
								                          </a>
								                      </li>-->
											    </div>
		 		 							</ul>
		 		 							<?php if ($this->_tpl_vars['supplierid'] == '12352'): ?>
												<!-- <ul class="mui-table-view" style="background-color: #efeff4;">
													<li class="mui-table-view-cell mui-media">
															<img class="img-responsive" src="/images/baozhang.png">
													</li>
												</ul> -->
											<?php else: ?>
												<!-- <ul class="mui-table-view" style="background-color: #efeff4;">
													<li class="mui-table-view-cell mui-media">
															<img class="img-responsive" src="/images/baozhang.png">
													</li>
												</ul>  -->
											<?php endif; ?>

						 </div>
                 </div>
			</div>
	    </div>
 </div>

	<script type="text/javascript">
	<?php echo '
	    mui.init({
	        pullRefresh: {
	            container: \'#pullrefresh\', //待刷新区域标识，querySelector能定位的css选择器均可，比如：id、.class等
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
			mui(\'.mui-table-view\').on(\'tap\',\'a\',function(e){
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
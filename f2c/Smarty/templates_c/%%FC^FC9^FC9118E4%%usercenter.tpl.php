<?php /* Smarty version 2.6.18, created on 2017-08-15 10:07:56
         compiled from usercenter.tpl */ ?>
 

<!DOCTYPE html>
<html> 
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title></title>
    <link href="public/css/mui.css" rel="stylesheet" />
    <link href="public/css/public.css" rel="stylesheet" />
	<link href="public/css/iconfont.css" rel="stylesheet" />  
	<link href="public/css/parsley.css" rel="stylesheet" >  
    <script src="public/js/mui.min.js" type="text/javascript" charset="utf-8"></script>  
	<script type="text/javascript" src="public/js/jweixin.js"></script> 
	<script src="public/js/zepto.js" type="text/javascript" charset="utf-8"></script>   
	<script type="text/javascript" src="public/js/jweixin.js"></script>   
	<script src="public/js/common.js" type="text/javascript" charset="utf-8"></script>
	
	 

    <script src="public/js/parsley.min.js"></script>   
    <script src="public/js/parsley.zh_cn.js"></script>
	<style>
	  <?php echo ' 
		  .img-responsive { display: block; height: auto; width: 100%; }   
	  	  .mui-input-row label { 
	  		  line-height: 21px; 
	  		  height: 21px;  
	  	  }
		  .menuicon
		  {
  	 		color:#fe4401; 
  	 		padding-right:5px;
		  }
		  .mui-grid-view .mui-media {
		    color: #fe4401;
		    background: #FFFFFF;
		    padding: 5px;
		  }
		  #orders .mui-table-view.mui-grid-view .mui-table-view-cell { 
		    padding: 10px 0 5px 0; 
			font-size: 1.4em;
		  }
		  #orders .mui-table-view.mui-grid-view .mui-table-view-cell .mui-icon {  
			font-size: 2.0em; 
		  }
		  #orders .mui-table-view.mui-grid-view .mui-table-view-cell .mui-media-body {
		    font-size: 12px; 
		    text-overflow: clip;
		    color: #333;
		  } 
		  #orders .mui-icon .mui-badge {
		    font-size: 10px;  
		    line-height: 1.4;
		    position: absolute;
		    top: 0px;
		    left: 100%;
		    margin-left: -40px;
		    padding: 1px 5px;
		    color: red;
		    background: white;
			border: 1px solid red;
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
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'leftmenu.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>  
	<div class="mui-inner-wrap">
		<header class="mui-bar mui-bar-nav" style="padding-right: 15px;">  
			 <a id="offCanvasShow" href="#offCanvasSide" class="mui-icon mui-action-menu mui-icon-bars mui-pull-left"></a>
			 <?php if ($this->_tpl_vars['supplier_info']['presalesconsultation'] == '0'): ?>
                 <a href="webim.php" class="mui-icon mui-action-menu mui-icon-chat mui-twinkling mui-pull-right"></a>
                 <?php endif; ?>
			 <h1 class="mui-title" id="pagetitle">会员中心</h1>
		</header>  
	    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>   
        <div id="pullrefresh" class="mui-content mui-scroll-wrapper" style="padding-top: 50px;"> 
                <div class="mui-scroll"> 
					<div class="mui-card" style="margin: 0 3px;">  
				         <ul class="mui-table-view">   
	                                <li class="mui-table-view-cell"> 
											<div class="mui-media-body" > 
										        <a href="javascript:;">
													<a href="usercenter.php?profileid=<?php echo $this->_tpl_vars['profile_info']['profileid']; ?>
" class="refreshprofile"><img class="mui-media-object mui-pull-left" src="<?php echo $this->_tpl_vars['profile_info']['headimgurl']; ?>
"></a>
													<div class="mui-media-body">
														<p class='mui-ellipsis' style="color:#333">昵称：<?php echo $this->_tpl_vars['profile_info']['givenname']; ?>
</p>
														<p class='mui-ellipsis' ><span style="color:#333">等级：</span><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'profilerank.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></p>
					
													</div>
												</a>
 											</div>  
	                                </li> 
			                        <?php if ($this->_tpl_vars['profile_info']['physicalstorename'] != ''): ?>
			                            <li class="mui-table-view-cell">
			                                <div class="mui-media-body  mui-pull-left">
			                                    <span class="mui-table-view-label">店铺：</span> 【<?php echo $this->_tpl_vars['profile_info']['physicalstorename']; ?>
】
			                                </div>
			                                <div class="mui-media-body  mui-pull-right">
			                                    <span class="mui-table-view-label">店员：</span> 【<?php echo $this->_tpl_vars['profile_info']['assistantprofile']; ?>
】
			                                </div>
			                            </li>
			                        <?php endif; ?>
						  </ul>
					</div> 
 					<div class="mui-card" style="margin: 3px 3px;">  
 				         <ul id="orders" class="mui-table-view" style="padding-top: 5px;text-align:center;">   
 	                                <li class="mui-table-view-cell" style="padding:0px;" > 
						                       <ul class="mui-table-view mui-grid-view" style="padding:0px;">  
						                          <li class="mui-table-view-cell mui-media" style="width:20%">
						                              <a href="orders_pendingpayment.php">
						                                  <span class="mui-icon iconfont icon-daifukuan button-color"><?php if ($this->_tpl_vars['badges']['pendingpayment'] > 0): ?><span class="mui-badge"><?php echo $this->_tpl_vars['badges']['pendingpayment']; ?>
</span><?php endif; ?></span>
						                                  <div class="mui-media-body button-color">待付款</div>
						                              </a>
						                          </li> 
						                          <li class="mui-table-view-cell mui-media" style="width:20%">
						                              <a href="orders_sendout.php">
						                                  <span class="mui-icon iconfont icon-daifahuo button-color"><?php if ($this->_tpl_vars['badges']['nosend'] > 0): ?><span class="mui-badge"><?php echo $this->_tpl_vars['badges']['nosend']; ?>
</span><?php endif; ?></span>
						                                  <div class="mui-media-body button-color">待发货</div>
						                              </a>
						                          </li>
						                          <li class="mui-table-view-cell mui-media" style="width:20%">
						                              <a href="orders_receipt.php">
						                                  <span class="mui-icon iconfont icon-daishouhuo button-color"><?php if ($this->_tpl_vars['badges']['receipt'] > 0): ?><span class="mui-badge"><?php echo $this->_tpl_vars['badges']['receipt']; ?>
</span><?php endif; ?></span>
						                                  <div class="mui-media-body button-color">待收货</div>
						                              </a>
						                          </li>
						                           <?php if ($this->_tpl_vars['supplier_info']['productappraises'] == '0'): ?>
						                          <li class="mui-table-view-cell mui-media" style="width:20%">
						                              <a href="orders_appraise.php">
						                                  <span class="mui-icon iconfont icon-daipingjia button-color"><?php if ($this->_tpl_vars['badges']['appraise'] > 0): ?><span class="mui-badge"><?php echo $this->_tpl_vars['badges']['appraise']; ?>
</span><?php endif; ?></span>
						                                  <div class="mui-media-body button-color">待评价</div>
						                              </a>
						                          </li> 
						                          <?php endif; ?>
						                          <?php if ($this->_tpl_vars['supplier_info']['allowreturngoods'] == '1'): ?>
						                          <li class="mui-table-view-cell mui-media" style="width:20%">
						                              <a href="orders_aftersaleservice.php">
						                                  <span class="mui-icon iconfont icon-pingtaibaozhang button-color"><?php if ($this->_tpl_vars['badges']['aftersaleservice'] > 0): ?><span class="mui-badge"><?php echo $this->_tpl_vars['badges']['aftersaleservice']; ?>
</span><?php endif; ?></span>
						                                  <div class="mui-media-body button-color">售后服务</div>
						                              </a>
						                          </li>
						                          <?php endif; ?>
						                      </ul>  
 	                                </li>
	                              
	                                <li class="mui-table-view-cell">
	                                    <a href="orders_payment.php" class="mui-navigate-right"> 
											<div class="mui-media-body  mui-pull-left">
												<span class="mui-icon iconfont icon-quanbudingdan  menuicon button-color"></span>全部订单
											</div> 
											<div class="mui-media-body  mui-pull-right" style="color:#888;padding-right:20px;"> 
												查看全部已付款订单
											</div>
										</a>
	                                </li>
	                                <!--<li class="mui-table-view-cell">
	                                    <a href="recharge.php" class="mui-navigate-right"> 
											<div class="mui-media-body  mui-pull-left">
												<span class="mui-icon iconfont icon-lianmengtuiguang menuicon button-color"></span>会员充值
											</div> 
											<div class="mui-media-body  mui-pull-right" style="color:#888;padding-right:20px;"> 
												会员充值,好礼相送
											</div>
										</a>
	                                </li>--> 
	                                <!--<li class="mui-table-view-cell">
	                                    <a href="pengyouquan.php" class="mui-navigate-right"> 
											<div class="mui-media-body  mui-pull-left">
												<span class="mui-icon iconfont icon-pengyouquan  menuicon button-color"></span>朋友圈
											</div> 
											<div class="mui-media-body  mui-pull-right" style="color:#888;padding-right:20px;"> 
												查看与您在一起的朋友
											</div>
										</a>
	                                </li>-->
									<?php if ($this->_tpl_vars['profile_info']['givenname'] != ''): ?>
											<li class="mui-table-view-cell">
												<a href="userdetail.php" class="mui-navigate-right">
													<div class="mui-media-body  mui-pull-left">
														<span class="mui-icon iconfont icon-gerenziliao menuicon button-color"></span>个人资料
													</div>
													<div class="mui-media-body  mui-pull-right" style="color:#888;padding-right:20px;">
														查看与编辑个人资料
													</div>
												</a>
											</li> 
									<?php endif; ?>
									<?php if ($this->_tpl_vars['supplier_info']['realnameauthentication'] == '0'): ?>
				                        <li class="mui-table-view-cell">
				                            <a href="authentication.php" class="mui-navigate-right">
				                                <div class="mui-media-body  mui-pull-left">
				                                    <span class="mui-icon iconfont icon-huiyuan menuicon button-color"></span>会员认证
				                                </div>
				                                <div class="mui-media-body  mui-pull-right" style="color:#888;padding-right:20px;">
				                                   认证可获得更多的权限
				                                </div>
				                            </a>
				                        </li>
									<?php endif; ?>
									<?php if ($this->_tpl_vars['supplier_info']['mylogistic'] == 'open'): ?>
				                        <li class="mui-table-view-cell">
				                            <a href="logistic.php" class="mui-navigate-right">
				                                <div class="mui-media-body  mui-pull-left">
				                                    <span class="mui-icon iconfont icon-wuliu menuicon button-color"></span><?php echo $this->_tpl_vars['supplier_info']['mylogisticname']; ?>
管理平台
				                                </div>
				                                <div class="mui-media-body  mui-pull-right" style="color:#888;padding-right:20px;">
				                                   司机配送,扫码等
				                                </div>
				                            </a>
				                        </li>
									<?php endif; ?>
									<?php if ($this->_tpl_vars['sysinfo']['http_user_agent'] == 'tezan'): ?> 
								     <script type="text/javascript" charset="utf-8" src="/public/js/cordova.js"></script>
									 <li class="mui-table-view-cell">
				                            <a id="cancal_subscribe" class="mui-navigate-right">
				                                <div class="mui-media-body  mui-pull-left">
				                                    <span class="mui-icon iconfont icon-jujue menuicon button-color"></span>取消关注
				                                </div>
				                                <div class="mui-media-body  mui-pull-right" style="color:#888;padding-right:20px;">
				                                  将不再展示本商城
				                                </div>
				                            </a>
				                        </li>
									<script type="text/javascript"> 
									<?php echo '	
									mui.ready(function() {  						 
										document.getElementById(\'cancal_subscribe\').addEventListener(\'tap\', function() {
											   mui.ajax({
													type: \'POST\',
													url: "usercenter.php",
													data: \'type=cancal_subscribe\',
													success: function (json)
													{
														 Cordova.exec(null, null, "PhoneGapPlugin", "PluginFunction", [{"type":"historyback"}]); 
													}
												}); 
										});
									});  
									'; ?>
 
									</script>
								    <?php endif; ?>
	                                <!--
	                                <li class="mui-table-view-cell">
	                                    <a href="#" class="mui-navigate-right"> 
											<div class="mui-media-body  mui-pull-left">
												<span class="mui-icon iconfont icon-zaiciquerenmima menuicon button-color"></span>修改密码
											</div> 
											<div class="mui-media-body  mui-pull-right" style="color:#888;padding-right:20px;"> 
												您在APP中登录需要使用
											</div>
										</a>
	                                </li>-->
	                                
 						 </ul>  
 			       </div>
					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'copyright.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
				</div>
		</div>
		
		<!-- end pullrefresh  -->
    </div>
</div> 

	      
	<script type="text/javascript"> 
	<?php echo '	
	    var mask = null;   
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
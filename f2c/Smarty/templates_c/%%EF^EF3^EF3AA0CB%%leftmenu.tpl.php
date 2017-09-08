<?php /* Smarty version 2.6.18, created on 2017-08-11 10:22:51
         compiled from leftmenu.tpl */ ?>
<style>
	<!--
	.user-info .mui-ellipsis .iconfont {width:18px;color: #fff; }
	-->
</style>
<aside class="mui-off-canvas-left">
    <div class="mui-scroll-wrapper">
        <div class="mui-scroll">
            <!-- 菜单具体展示内容 -->
            <div class="user-info">
				<?php if ($this->_tpl_vars['profile_info']['profileid'] != 'anonymous'): ?>
				   <?php if ($this->_tpl_vars['profile_info']['givenname'] != ''): ?>
				        <a href="javascript:;">
							<img class="mui-media-object mui-pull-left" src="<?php echo $this->_tpl_vars['profile_info']['headimgurl']; ?>
">
							<div class="mui-media-body">
								<?php echo $this->_tpl_vars['profile_info']['givenname']; ?>
，您好！
								<p class='mui-ellipsis' >等级：<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'profilerank.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></p>
							
							</div>
						</a>
					   <?php if ($this->_tpl_vars['smk_id'] != 12352): ?>
						<p class='mui-ellipsis' style="margin:0px;">可用资金：<span class="price2">¥<?php echo $this->_tpl_vars['profile_info']['money']; ?>
</span></p>
						<p class='mui-ellipsis' style="margin:0px;">累积收益：<span>¥<?php echo $this->_tpl_vars['profile_info']['accumulatedmoney']; ?>
</span></p>
					   <?php endif; ?>
				   <?php else: ?>
				        <a href="javascript:;">
							<img class="mui-media-object mui-pull-left" src="<?php if ($this->_tpl_vars['supplier_info']['logo'] != ''): ?><?php echo $this->_tpl_vars['supplier_info']['logo']; ?>
<?php else: ?>images/logo.png<?php endif; ?>">
							<div class="mui-media-body">
								尊敬的客人，您好！<br> 
								<p class='mui-ellipsis'>关注之后内容更精彩!</p>   
							</div>
						</a>
				   <?php endif; ?>
					
				<?php else: ?>
			        <a href="javascript:;">
						<img class="mui-media-object mui-pull-left" src="<?php if ($this->_tpl_vars['businesse_info']['logo'] != ''): ?><?php echo $this->_tpl_vars['businesse_info']['logo']; ?>
<?php else: ?>images/logo.png<?php endif; ?>">
						<div class="mui-media-body">
							<?php echo $this->_tpl_vars['businesse_info']['businessename']; ?>

							<p class='mui-ellipsis'>注册之后内容更精彩!</p>
						</div>
					</a>
					<p><?php echo $this->_tpl_vars['businesse_info']['share_description']; ?>
</p>
					<p style="text-align: center;">
						<a href="login.php" class="mui-btn mui-btn-outlined mui-btn-primary">登陆 </a>
						<a href="register.php" class="mui-btn mui-btn-outlined mui-btn-primary">注册 </a>
					</p>
				<?php endif; ?>
			</div>
			<ul class="mui-table-view mui-table-view-chevron mui-table-view-inverted">
				<li class="mui-table-view-cell">
					<a href="index.php" class="mui-navigate-right mui-ellipsis"><span class="mui-icon iconfont icon-mainpage"></span> 店铺首页 </a>
				</li>
				<!--<li class="mui-table-view-cell">
					<a href="usercenter.php" class="mui-navigate-right mui-ellipsis">
						<span class="mui-icon iconfont icon-gerenzhongxin"></span> 会员中心 
						<span class="left-desc"></span>
					</a>
				</li>-->
			    <?php $this->assign('badges', $this->_tpl_vars['share_info']['badges']); ?>
				<?php if ($this->_tpl_vars['smk_id'] != 12352): ?>
				<li class="mui-table-view-cell">
					<a href="accountbook.php" class="mui-navigate-right mui-ellipsis">
						<span class="mui-icon iconfont icon-zhangdanchaxun"></span> 我的账簿 <?php if ($this->_tpl_vars['badges']['new_billwater'] == 'yes'): ?><span style="font-size: 20px;padding: 1px 3px;" class="mui-badge mui-badge-danger iconfont icon-newbadge"></span><?php endif; ?>
						<span class="left-desc"></span>
					</a>
				</li>
				<?php endif; ?>
				<li class="mui-table-view-cell">
					<a href="orders_receipt.php" class="mui-navigate-right mui-ellipsis">
						<span class="mui-icon iconfont icon-daichulidingdan"></span> 我的待处理订单<?php if ($this->_tpl_vars['badges']['new_order'] == 'yes'): ?><span style="font-size: 20px;padding: 1px 3px;" class="mui-badge mui-badge-danger iconfont icon-newbadge"></span><?php endif; ?>
						<span class="left-desc"></span>
					</a>
				</li> 
				<li class="mui-table-view-cell">
					<a href="orders_payment.php" class="mui-navigate-right mui-ellipsis">
						<span class="mui-icon iconfont icon-dingdan"></span> 全部已付款订单
						<span class="left-desc"></span>
					</a>
				</li>
				<?php if ($this->_tpl_vars['supplier_info']['allowtakecash'] == '1'): ?> 
					<li class="mui-table-view-cell">
						<a href="takecashs.php" class="mui-navigate-right mui-ellipsis">
							<span class="mui-icon iconfont icon-money"></span> 提现申请
							<span class="left-desc"></span>
						</a>
					</li>
				<?php endif; ?>
				<li class="mui-table-view-cell">
					<a href="mycollections.php" class="mui-navigate-right mui-ellipsis">
						<span class="mui-icon iconfont icon-shoucang"></span> 我的收藏
						<span class="left-desc"></span>
					</a>
				</li> 
				<?php if ($this->_tpl_vars['supplier_info']['showfubisi'] == '0'): ?> 
				<li class="mui-table-view-cell">
					<a href="fubusi.php" class="mui-navigate-right mui-ellipsis">
						<span class="mui-icon iconfont icon-fubushi"></span> 福布斯榜
						<span class="left-desc"></span>
					</a>
				</li>
				<?php endif; ?>
				<li class="mui-table-view-cell">
					<a href="contactus.php" class="mui-navigate-right mui-ellipsis">
						<span class="mui-icon iconfont icon-lianxiwomen"></span> 联系我们
						<span class="left-desc"></span>
					</a>
				</li>
				<?php if ($this->_tpl_vars['sysinfo']['http_user_agent'] == 'tezan'): ?> 
				    <?php $this->assign('copyrights', $this->_tpl_vars['supplier_info']['copyrights']); ?>
				    <script type="text/javascript" charset="utf-8" src="/public/js/cordova.js"></script>
					<li class="mui-table-view-cell">
						<a id="back_tezan" class="mui-navigate-right mui-ellipsis">
							<span class="mui-icon iconfont icon-logo"></span> 返回<?php echo $this->_tpl_vars['copyrights']['trademark']; ?>

							<span class="left-desc"></span>
						</a>
					</li>
					<script type="text/javascript"> 
					<?php echo '	
					mui.ready(function() {  						 
						document.getElementById(\'back_tezan\').addEventListener(\'tap\', function() {
							 Cordova.exec(null, null, "PhoneGapPlugin", "PluginFunction", [{"type":"historyback"}]); 
						});
					});  
					'; ?>
 
					</script>
				<?php endif; ?>
			</ul>
        </div>
    </div>
</aside>
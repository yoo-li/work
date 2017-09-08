<?php /* Smarty version 2.6.18, created on 2017-08-11 11:04:21
         compiled from footer.tpl */ ?>
<nav class="mui-bar mui-bar-tab">
	<a id="defaultTab" class="mui-tab-item <?php if ($this->_tpl_vars['sysinfo']['action'] == 'index'): ?>mui-active<?php endif; ?>" href="/index.php">
		<span class="mui-icon iconfont icon-mainpage"></span>
		<span class="mui-tab-label">首页</span>
	</a>
	<?php if ($this->_tpl_vars['supplier_info']['showcategory'] == '0'): ?>
	<a class="mui-tab-item <?php if ($this->_tpl_vars['sysinfo']['action'] == 'category'): ?>mui-active<?php endif; ?>" href="/category.php">
		<span class="mui-icon iconfont icon-quanbushangpinicon"></span>
		<span class="mui-tab-label"><?php echo $this->_tpl_vars['businesse_info']['productprefix']; ?>
分类</span>
	</a> 
	<?php endif; ?>

	<?php if ($this->_tpl_vars['supplier_info']['showpromotioncenter'] == '0' && $this->_tpl_vars['profile_info']['givenname'] != ''): ?>
	<a class="mui-tab-item <?php if ($this->_tpl_vars['sysinfo']['action'] == 'promotioncenter'): ?>mui-active<?php endif; ?>" href="/promotioncenter.php">
			<span class="mui-icon iconfont icon-hezuo"></span>
			<span class="mui-tab-label">推广中心</span>
	</a>
	<?php endif; ?>
	<a class="mui-tab-item <?php if ($this->_tpl_vars['sysinfo']['action'] == 'shoppingcart'): ?>mui-active<?php endif; ?>" href="/shoppingcart.php">
		<span class="mui-icon iconfont icon-shoppingcart" id="shoppingcart">
			<span id="shoppingcart_badge"><?php if ($this->_tpl_vars['share_info']['shoppingcart'] != '0' && $this->_tpl_vars['share_info']['shoppingcart'] != ''): ?><span class="mui-badge"><?php echo $this->_tpl_vars['share_info']['shoppingcart']; ?>
</span><?php endif; ?></span>
		</span> 
		<span class="mui-tab-label">购物车</span>
	</a>
	<a class="mui-tab-item <?php if ($this->_tpl_vars['sysinfo']['action'] == 'usercenter'): ?>mui-active<?php endif; ?>" href="/usercenter.php">
		<span class="mui-icon iconfont icon-usercenter"></span>
		<span class="mui-tab-label">我的</span>
	</a>
</nav>

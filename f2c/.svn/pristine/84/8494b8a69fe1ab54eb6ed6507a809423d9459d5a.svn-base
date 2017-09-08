<nav class="mui-bar mui-bar-tab">
	<a id="defaultTab" class="mui-tab-item {if $sysinfo.action eq 'index'}mui-active{/if}" href="/index.php">
		<span class="mui-icon iconfont icon-mainpage"></span>
		<span class="mui-tab-label">首页</span>
	</a>
	{if $supplier_info.showcategory eq '0'}
	<a class="mui-tab-item {if $sysinfo.action eq 'category'}mui-active{/if}" href="/category.php">
		<span class="mui-icon iconfont icon-quanbushangpinicon"></span>
		<span class="mui-tab-label">{$businesse_info.productprefix}分类</span>
	</a> 
	{/if}

	{if $supplier_info.showpromotioncenter eq '0' && $profile_info.givenname neq ''}
	<a class="mui-tab-item {if $sysinfo.action eq 'promotioncenter'}mui-active{/if}" href="/promotioncenter.php">
			<span class="mui-icon iconfont icon-hezuo"></span>
			<span class="mui-tab-label">推广中心</span>
	</a>
	{/if}
	<a class="mui-tab-item {if $sysinfo.action eq 'shoppingcart'}mui-active{/if}" href="/shoppingcart.php">
		<span class="mui-icon iconfont icon-shoppingcart" id="shoppingcart">
			<span id="shoppingcart_badge">{if $share_info.shoppingcart neq '0' && $share_info.shoppingcart neq '' }<span class="mui-badge">{$share_info.shoppingcart}</span>{/if}</span>
		</span> 
		<span class="mui-tab-label">购物车</span>
	</a>
	<a class="mui-tab-item {if $sysinfo.action eq 'usercenter'}mui-active{/if}" href="/usercenter.php">
		<span class="mui-icon iconfont icon-usercenter"></span>
		<span class="mui-tab-label">我的</span>
	</a>
</nav>


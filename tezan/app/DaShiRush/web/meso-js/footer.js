/**
 * Created by clubs on 2017/2/20.
 */
document.write('<nav class="mui-bar mui-bar-tab update-footer-bar">' +
			   '	<a class="mui-tab-item mui-active" href="">' +
			   '		<span class="mui-icon iconfont icon-mainpage"></span>' +
			   '		<span class="mui-tab-label">抢单首页</span>' +
			   '	</a>' +
			   // '	<a class="mui-tab-item" href="/category.php">' +
			   // '		<span class="mui-icon iconfont icon-quanbushangpinicon"></span>' +
			   // '		<span class="mui-tab-label">分类</span>' +
			   // '	</a>' +
			   // '	<a class="mui-tab-item" href="">' +
			   // '		<span class="mui-icon iconfont icon-usercenter"></span>' +
			   // '		<span class="mui-tab-label">会员</span>' +
			   // '	</a>' +
			   '	<a class="mui-tab-item" href="">' +
			   '		<span class="mui-icon iconfont icon-shoppingcart">' +
			   '			<span><span class="mui-badge"></span></span>' +
			   '		</span>' +
			   '		<span class="mui-tab-label">我的订单</span>' +
			   '	</a>' +
			   '</nav>')

function UpdateFooter(footerinfo) {
	if(footerinfo != null && footerinfo != ""){
		var sb = new StringBuilder();
		Zepto.each(footerinfo, function(k,v){
			sb.append('<a class="mui-tab-item '+(v.active=='1'?'mui-active':'')+'" href="'+v.href+'">' +
					  '		<span class="mui-icon iconfont icon-'+v.icon+'">' + (v.badge > '0'? '' +
					  '			<span class="'+k+'_badge"><span class="mui-badge">'+v.badge+'</span></span>' : '') +
					  '		</span>' +
					  '		<span class="mui-tab-label">'+v.title+'</span>' +
					  '</a>')
		})
		Zepto('.update-footer-bar').html(sb.toString())
	}
}

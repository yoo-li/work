
window.onload = function(){
	var bigCw = Math.ceil(($(".bigtab").width()-$(".bigContent").width())/2);
    var bigCh = Math.ceil(($(".bigtab").height()-$(".bigContent").height())/2);
    $(".bigContent").css({"left":bigCw,"top":bigCh});
};


//异步加载数据
function onWebSiteReady(){
	setTimeout(function(){//顶部用户信息
		var sb=new StringBuilder();
		if (ProfileID != "") {
			jQuery("#mygoods_div").html('<a href="productsource.php"><img src="images/hy1.jpg"></a>');
			sb.append('<td width="18%" height="45" align="left">');
			// sb.append('		<a href="javascript:;" onclick="refreshProfileinfo(\''+ProfileID+'\');">');
			sb.append('		<a href="login.html">');
			sb.append('		<img src="'+imgurl+'" width="45" height="45"></a>');
			sb.append('</td>');
			sb.append('<td width="72%" height="45" align="left"><span>'+givename+'的微小店</span></td>');
			sb.append('<td width="10%" height="45" align="left">');
			sb.append('		<a href="userusage.php"><img src="images/userusage.png" width="30" height="30"></a>');
			sb.append('</td>');
		}else{
			sb.append('<td width="18%" height="45" align="left">');
			sb.append('		<a href="login.html">');
			sb.append('		<img src="images/logo1.png" width="45" height="45"></a>');
			sb.append('</td>');
			sb.append('<td width="72%" height="45" align="left"><span>天天微逛</span></td>');
			sb.append('<td width="10%" height="45" align="left"></td>');
		}
		jQuery("#headuserinfo").html(sb.toString());
	},100);
	setTimeout(function(){//轮播图板块
		getServerData("/ttwz/api/webservice.php","page=index&func=slides","#slides",slides_html);
	},0);
	setTimeout(function(){//新货特价板块
		getServerData("/ttwz/api/webservice.php","page=index&func=xhtj","#clearfix_xhtj",xhtj_html);
	},100);
	setTimeout(function(){//活动板块
		getServerData("/ttwz/api/webservice.php","page=index&func=activitys","#clearfix_activitys",activitys_html);
	},100);
	setTimeout(function(){//猜你喜欢
		getServerData("/ttwz/api/webservice.php","page=index&func=randomproducts&profileid="+ProfileID+"&uuid="+UUID,"#randomproducts",randomproducts_html);
	},100);
	setTimeout(function(){//天天精选
		getServerData("/ttwz/api/webservice.php","page=index&func=recommendsproducts&profileid="+ProfileID,"#recommendsproducts",recommendsproducts_html);
	},0);
	setTimeout(function(){//品牌大全
		getServerData("/ttwz/api/webservice.php","page=index&func=brandsproducts","#brandsproducts",brandsproducts_html);
	},100);
	setTimeout(function(){//商品分类菜单
		getServerData("/ttwz/api/webservice.php","page=index&func=categoryquery","#navmenu-box",category_html);
	},100);
	setTimeout('$("img.lazy").lazyload();',500);
}
//网页footer部份
function webfooter() {
	var sb=new StringBuilder(); 
	sb.append('<nav id="navbar" class="navbar navbar-default navbar-fixed-bottom bottommenu" role="navigation">');
	sb.append('		<div id="sy_bottom">');
	sb.append('			<ul>');
	sb.append('				<li class="new_xx">');
	sb.append('					<a href="index.php">');
	sb.append('						<img src="images/nav01.png"></a>');
	sb.append('				</li>');
	sb.append('				<li class="new_xx">');
	sb.append('					<a href="locallive.php"><img src="images/nav02.gif"></a>');
	sb.append('				</li>');
	sb.append('				<li class="new_xx">');
	sb.append('					<a href="usercenter.php">');
	sb.append('						<img src="images/nav04.png"></a>');
	sb.append('				</li>');
	sb.append('				<li>');
	sb.append('					<a href="more.php"><img src="images/nav05.png"></a>');
	sb.append('				</li>');
	sb.append('				<li class="gw">');
	sb.append('					<a href="shoppingcart.php">');
	sb.append('						<img src="images/gwc01.png"></a>');
	sb.append('					<div class="shuzi">0</div>');
	sb.append('				</li>');
	sb.append('		 	</ul>');
	sb.append('		</div>');
	sb.append('</nav>');
	document.write(sb.toString());
}
//创建滚动视图
function slides_html(v) {	 
	var sb=new StringBuilder(); 
	sb.append('<li>');
	sb.append('     <a href="'+v.link+'"><img name="ad_img" src="'+v.imgsrc+'" class="img-responsive" alt="'+v.alt+'"/></a>');
	sb.append('</li>'); 
	return sb.toString(); 
}

//创建新货上架与特价
function xhtj_html(obj) {
	var sb=new StringBuilder();
	if (obj != null && obj != "") {
		if (obj.birthday) {	//生日模块
			sb.append('<a href="activity_birthday.php" style="margin-bottom:6px;"><img src="images/sr/activity_birthday.jpg" class="img-responsive"></a>');
		}
		if (obj.factory_url) {	//新货上架与厂家特惠
			sb.append('<a style="position:relative;float:left;width:50%;background:#f2f2f2;" href="{$newproducts_url}"><img src="{$newproducts_img}" class="img-responsive"></a>');
			sb.append('<a style="position:relative;float:left;width:50%;background:#f2f2f2;" href="{$factorysale_url}"><img src="{$factorysale_img}" class="img-responsive"></a>');
		}else{	//新货上架
			sb.append('<a href="newproducts.php"><img src="images/xh.jpg" class="img-responsive"></a>');
		}
		if (obj.robsingle_url) {	//秒杀专场
			sb.append('<a style="padding-top:6px;" href="{$robsingle_url}"><img src="{$robsingle_img}" class="img-responsive"></a>');
		}
	}else{
		sb.append('<a href="newproducts.php"><img src="images/xh.jpg" class="img-responsive"></a>');
	}
	return sb.toString();
}
//活动板块
function activitys_html(obj) {
	var sb=new StringBuilder();
	if (obj != null && obj != "") {
		if (obj.crossyear != null && obj.crossyear != "") {
			sb.append('<div class="clearfix sy_knzc"><strong>跨年专场</strong><span>年货囤起来</span></div>');
			var index = 1;
			jQuery.each(obj.brand, function(i, v) {
				if (v.present_type == "0") {
					sb.append('<div class="sub_sy_knzc" style="position:relative;float:left;width:50%;padding-top:6px;background:#f2f2f2;">');
					sb.append('<a href="salesactivity.php?activityid='+i+'&form=index">');
					if (index % 2 == 1) {
						sb.append('<img style="width:100%;padding:0px 3px 0px 6px;" src="'+v.homepage+'" />');
					}else{
						sb.append('<img style="width:100%;padding:0px 6px 0px 3px;" src="'+v.homepage+'" />');
					}
					sb.append('</a></div>');
					index++;
				}else{
					sb.append('<div class="sub_sy_knzc" style="position:relative;float:left;width:100%;padding-top:6px;background:#f2f2f2;">');
					sb.append('<a href="salesactivity.php?activityid={$activityid}&form=index">');
					sb.append('<img style="padding:0px 6px;width:100%;" src="'+v.homepage+'" />');
					sb.append('</a></div>');
				}
			});
		}else if(obj.brand != null && obj.brand != ""){
			sb.append('<div class="clearfix sy_ppzc"><strong>特惠趴</strong><span>海量商品2折起</span></div>');
			sb.append('<div class="sub_sy_ppzc" class="clearfix">');
			var index = 1;
            jQuery.each(obj.brand, function(i, v) {
				if (v.present_type == "0") {
					sb.append('<div style="position:relative;float:left;width:50%;padding-top:6px;background:#f2f2f2;">')
					sb.append('<a href="salesactivity.php?activityid='+i+'&form=index">');
					if (index % 2 == 1) {
						sb.append('<img style="width:100%;padding:0px 3px 0px 6px;" src="'+v.homepage+'" />');
					}else{
						sb.append('<img style="width:100%;padding:0px 6px 0px 3px;" src="'+v.homepage+'" />');
					}
					sb.append('</a></div>');
					index++;
				}else{
					sb.append('<div style="position:relative;float:left;width:100%;padding-top:6px;background:#f2f2f2;">');
					sb.append('<a href="salesactivity.php?activityid='+i+'&form=index">');
					sb.append('<img style="padding:0px 6px;width:100%;" src="'+v.homepage+'" />');
					sb.append('</a></div>');
				}
            });
			sb.append('</div>');
		}		
	}
	return sb.toString();
}
//猜你喜欢板块
function randomproducts_html(obj) {
	var sb=new StringBuilder();
	if (obj != null && obj != "") {
		var index = 1;
		jQuery.each(obj, function(i, v) {
			if (index == 1) {
				sb.append('<div class="shangpin" style="margin-top:0px;padding-top:0px;">');
			}else{
				sb.append('<div class="shangpin" style="padding-top:6px;">');
			}
			if (v.product_type == '1') {
				if (index <= 2) {
					sb.append('<div class="hot_logo" style="margin-top:0px;padding-top:0px;"><img src="images/remai.png" class="img-responsive"></div>');
				}else{
					sb.append('<div class="hot_logo" style="padding-top:6px;"><img src="images/loading.png" data-original="images/remai.png" class="lazy img-responsive"></div>');
				}
			}
			sb.append('<div class="cp_miaoshu" style="display: none;">');
			sb.append('<div class="ms_left"></div><div class="ms_right">');
			sb.append('<div class="tit" style="background-color: rgba(255,255,255,0.7);border-top-left-radius:5px;">'+v.productname+'</div>');
			sb.append('<div class="cnt" style="background-color: #f5f5f5;border-bottom-left-radius:5px;">');
			sb.append('<ul>');
			sb.append('		<li class="wg1">');
			sb.append('			<span class="price1">¥'+v.market_price+'</span><br>');
			sb.append('			<span class="tit01">微逛价:</span>');
			sb.append('			<span class="tit01">¥'+v.shop_price+'</span><br>');
			sb.append('		</li>');
			sb.append('		<li class="wg2" onclick="praise(this,\''+i+'\');"><span><img src="images/zan01.png" width="14" height="14"></span>'+v.praise+'</li>');
			sb.append('		<li class="wg3"><a href="detail.html?from=index&productid='+i+'"><strong>立即购买</strong></a></li>');
			sb.append('</ul>');
			sb.append('</div>');
			sb.append('</div>');
			sb.append('</div>');
			if (index > 2) {
				sb.append('<a onclick="open_detail(\'detail.html?from=index&productid='+i+'\')" href="javascript:;"><img src="images/loading.png" data-original="'+v.productlogo+'?width=768" class="lazy img-responsive"></a>');
			}else{
				sb.append('<a onclick="open_detail(\'detail.html?from=index&productid='+i+'\')" href="javascript:;"><img src="'+v.productlogo+'?width=768" class="img-responsive"></a>')
			}
			sb.append('</div>');
			index++;
		});
	}
	return sb.toString();
}
//天天精选板块
function recommendsproducts_html(obj) {
	var sb=new StringBuilder();
	if (obj != null && obj != "") {
		var index = 1;
		jQuery.each(obj, function(i, v) {
			if (index == 1) {
				sb.append('<div class="shangpin" style="margin-top:0px;padding-top:0px;">');
			}else{
				sb.append('<div class="shangpin" style="padding-top:6px;">');
			}
			if (v.product_type == '1') {
				if (index <= 2) {
					sb.append('<div class="hot_logo" style="margin-top:0px;padding-top:0px;"><img src="images/remai.png" class="img-responsive"></div>');
				}else{
					sb.append('<div class="hot_logo" style="padding-top:6px;"><img src="images/loading.png" data-original="images/remai.png" class="lazy img-responsive"></div>');
				}
			}
			sb.append('<div class="cp_miaoshu" style="display: none;">');
			sb.append('<div class="ms_left"></div><div class="ms_right">');
			sb.append('<div class="tit">'+v.productname+'</div>');
			sb.append('<div class="cnt">');
			sb.append('<ul>');
			sb.append('		<li class="wg1">');
			sb.append('			<span class="price1">¥'+v.market_price+'</span><br>');
			sb.append('			<span class="tit01">微逛价:</span>');
			sb.append('			<span class="tit01">¥'+v.shop_price+'</span><br>');
			sb.append('		</li>');
			sb.append('		<li class="wg2" onclick="praise(this,\''+i+'\');"><span><img src="images/zan01.png" width="14" height="14"></span>'+v.praise+'</li>');
			sb.append('		<li class="wg3"><a href="detail.html?from=index&productid='+i+'"><strong>立即购买</strong></a></li>');
			sb.append('</ul>');
			sb.append('</div>');
			sb.append('</div>');
			sb.append('</div>');
			if (index > 2) {
				sb.append('<a onclick="open_detail(\'detail.html?from=index&productid='+i+'\')" href="javascript:;"><img src="images/loading.png" data-original="'+v.productlogo+'?width=768" class="lazy img-responsive"></a>');
			}else{
				sb.append('<a onclick="open_detail(\'detail.html?from=index&productid='+i+'\')" href="javascript:;"><img src="'+v.productlogo+'?width=768" class="img-responsive"></a>')
			}
			sb.append('</div>');
			index++;
		});
	}
	return sb.toString();
	// {if $suppliers neq ""}
// 	<div class="bigtab" style='margin-bottom:5px'>
// 		<img src="images/icon/indexbg.png" alt="">
// 		<div class="clearfix bigContent">
// 			<div class="bigtab_title">
//  				<h3>{$suppliersname}</h3>
//  			</div>
//  			<div class="bigtab_border"></div>
//  			<div class="bigt_a">
//  				<div class="bigt_ain"></div>
//  				<a href="supplier_shop.php?suppliers={$suppliers}&type=1">进店逛逛</a>
//  			</div>
// 		</div>
// 	</div>
// 	{/if}
}
//品牌大全板板
function brandsproducts_html(obj){
	var sb=new StringBuilder();
	if (obj != null && obj != "" && obj != "undefined") {
		sb.append('<a href="viewbrand.html?record='+obj.bid+'"><img src="'+obj.logo+'" class="img-responsive"></a>');
	}
	return sb.toString();
}
//商品分类板块
function category_html(obj){
	var sb=new StringBuilder();
	if (obj != null && obj != "" && obj != "undefined") {
		sb.append('<div class="navmenu_tit">');
		sb.append('		<img class="img_tit" src="'+obj.sysconfigs.spfl_header+'">');
		sb.append('</div>');
        jQuery.each(obj.category, function(i, v) {
	        jQuery.each(v, function(cid, item) {
		    	if (item.url == "") {
		    		sb.append('<dl class="navmenu-dl-bcolor" dataid="'+cid+'"><dt><img src="'+item.imgurl+'" ></dt><dd>'+item.name+'</dd></dl>');
		    	}else{
		    		sb.append('<dl class="navmenu-dl-bcolor"><a href="'+item.url+'"><dt><img src="'+item.imgurl+'" ></dt><dd>'+item.name+'</dd></a></dl>');
		    	}
	        });
			sb.append('<div class="navmenu-group">');
			jQuery.each(v, function(cid, item) {
				sb.append('<div class="submenu" id="submenu'+cid+'">');
				jQuery.each(item.child, function(subcid, child) {
					sb.append('<a href="search_sp.php?from=fenlei&category_type=child&categorys='+subcid+'" style="margin:3px"> '+child.name+'</a>');
				});
				sb.append('<a href="search_sp.php?from=fenlei&category_type=parent&categorys='+cid+'" style="margin:3px">查看全部</a>');
				sb.append('</div>');
			});
			sb.append('</div>');
        });
		sb.append('<img class="img_foot" src="'+obj.sysconfigs.spfl_footer+'">');
	}
	return sb.toString();
}


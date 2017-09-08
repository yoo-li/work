 

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
	<script type="text/javascript" src="public/js/jweixin.js"></script> 
	<script src="public/js/utils.js" type="text/javascript" charset="utf-8"></script>
	<script src="public/js/detail.js" type="text/javascript" charset="utf-8"></script>
	<style>
	{literal}
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
	   background: url(/images/checked.png) no-repeat bottom right;
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
	 
	.bargains-profile-show{
		display:block;
	}
	.main_title
	{ 
	  min-height: 20px;
	  line-height: 30px;
	  margin-right: auto;
	  margin-left: auto;
	  border-bottom-width: 2px;
	  border-bottom-style: solid;
	  border-bottom-color: #D8131B;
	  position: relative;
	}
	.main_title h1 {
	  background-color: #f3f3f3;
	  color:#CF2D28;
	  position: absolute;
	  left: 20px;
	  top: 5px;
	  padding-right: 10px;
	  padding-left: 10px;
	  font-size: 1.4em;
	  font-weight: 600;
	}
	{/literal}
	</style>
	{include file='theme.tpl'}  
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
				<a class="mui-tab-item mui-active addshoppingcart" href="#" > 
					<span class="mui-tab-label">
						  <span class="mui-icon iconfont icon-jiarugouwuche mui-twinkling"></span>&nbsp;&nbsp;加入购物车
				    </span>
				</a> 
				<a class="mui-tab-item mui-active shoppingcart" href="shoppingcart.php" > 
					<span class="mui-tab-label">
						  <span class="mui-icon iconfont icon-shoppingcart " id="shoppingcart"> 
							   <span id="shoppingcart_badge">{if $share_info.shoppingcart neq '0' && $share_info.shoppingcart neq '' }<span class="mui-badge">{$share_info.shoppingcart}</span>{/if}</span>
					      </span> 
						   &nbsp;&nbsp;立即结算
				   </span>
				</a>
			</nav>
             
            <div id="pullrefresh" class="mui-content mui-scroll-wrapper">
                <div class="mui-scroll">
                    <!-- 主界面具体展示内容 -->
			         <div  style="margin: 5px 5px;"> 
							 <img class="mui-media-object" style="border-radius: 6px;width: 100%;max-width: 100%;height: auto;" id="productlogo" src="{$productinfo.productlogo}">
				     </div> 
					 <input type="hidden" id="property_type_count" value="{$property_type_count}" />
					 <input type="hidden" id="from" value="{$from}" />
					 <input type="hidden" id="product_property_id" name="product_property_id" value="" />
					 <input type="hidden" id="pagenum" name="pagenum" value="{$pagenum}">
					 <input type="hidden" id="scrolltop" name="scrolltop" value="{$scrolltop}"> 
					 <input type="hidden" id="productid" name="productid" value="{$productid}">
					 <input type="hidden" name="total_price" id="total_price1" value="{$productinfo.shop_price}" />
					 <input type="hidden" name="shop_price" id="shop_price1" value="{$productinfo.shop_price}" />
					 <input type="hidden" name="inventory" id="inventory1" value="{$productinfo.inventory}" />
					 <input type="hidden" name="zhekou" id="zhekou" value="{$productinfo.zhekou}" />
					 <input type="hidden" name="salesactivityid" id="salesactivityid" value="{$productinfo.salesactivityid}" />
					 <input type="hidden" name="salesactivity_product_id" id="salesactivity_product_id" value="{$productinfo.salesactivity_product_id}" />
					 <input type="hidden" name="type" id="type" value="{$type}" />
					<input type="hidden" name="type" id="activitymode" value="{$productinfo.activitymode}" />
					<input type="hidden" name="type" id="bargainrequirednumber" value="{$productinfo.bargainrequirednumber}" />
					<input type="hidden" name="type" id="bargains_profile_count" value="{$productinfo.bargaincount}" />
					 <input type="hidden" id="jd" value="{$jd}" />
                    <!--detail-->
                    <div class="mui-content-padded">
                        <p style="margin-bottom: 0;">
                            <span class="detail-title">{$productinfo.productname}</span>
                        </p>
                        <p class="info">
							<span class="mui-badge mui-badge-primary">{$tradecount}成交</span>
							<span class="mui-badge mui-badge-primary">{$appraisecount}评</span>
							{if $productinfo.activityname neq '' &&  $productinfo.zhekoulabel neq '' && $productinfo.zhekou neq ''}
								{if $productinfo.activitymode eq '1'}
									<span class="price">底价: ￥<b style="font-size: 32px;" id="shop_price">{$productinfo.total_money}</b>元</span>
								{else}
									<span class="price">￥<b style="font-size: 32px;" id="shop_price">{$productinfo.total_money}</b>元</span>
								{/if}

							{else} 
								<span class="price">￥<b style="font-size: 32px;" id="shop_price">{$productinfo.shop_price}</b>元</span>
							{/if}
                        </p>   
						<ul id="propertygroup" class="mui-table-view" style="background: #f3f3f3;"> 
							<li class="mui-table-view-cell" >
								 <span class="mui-pull-left">市场价 : <span class="price1">￥<span id="market_price">{$productinfo.market_price}</span></span></span>
			                     <span class="mui-pull-right">
								 <input type="hidden" id="mycollection" value="{$mycollections}"> 
								 {if $mycollections eq '0'}
								     <a class="mycollection" href="#" > 
			                            <span id="mycollectionicon" class="mui-icon iconfont icon-nocollection mui-slow-twinkling mycollections"></span>
								 	 </a>
			                     {else}
			                          <a class="mycollection" href="#" > 
			                            <span id="mycollectionicon" class="mui-icon iconfont icon-collection mycollections"></span>
								 	  </a> 
			                     {/if}
							     </span>
							</li>
							{if $productinfo.activityname neq '' &&  $productinfo.zhekoulabel neq '' && $productinfo.zhekou neq ''}
								<li class="mui-table-view-cell" >
									 <span class="mui-pull-left">原价 : <span class="price1">￥<span id="old_shop_price">{$productinfo.shop_price}</span></span> 
								</li>
								<li class="mui-table-view-cell" >
									 <span class="mui-pull-left">砍价活动 : <span class="price">{$productinfo.activityname}</span></span>
								</li>
								{if $productinfo.activitymode eq '1'} 
									<li class="mui-table-view-cell" >
									    <div class="main_title"><h1>活动规则</h1> </div>
										<span class="mui-pull-left" style="padding-top:15px;color:#CF2D28; font-size:1.1em; font-weight:500;"> 
										 一、分享到朋友圈，请好友帮忙砍价；<br>
										 二、{if $productinfo.bargainrequirednumber gt $productinfo.bargaincount}已有{$productinfo.bargaincount}位,{/if}共需要{$productinfo.bargainrequirednumber}位好友帮忙点击砍价；<br>
										 三、每人限购1件；<br>
										 四、活动截止时间：{$productinfo.enddate}。<br>
										</span>
									</li>
									{if $productinfo.bargains|@count gt '0'}
									<li id="bargains_profile" class="mui-table-view-cell bargains-profile" >
										<ul class="mui-table-view">
											{foreach key=profileid item=profileinfo from=$productinfo.bargains}
												<li class="mui-table-view-cell" style="padding: 8px 5px;">
													<div class="mui-media-body">
														<img class="mui-media-object mui-pull-left" style="width:20px;height:20px;" src="{$profileinfo.headimgurl}">
														<span style="width:120px;text-align:left;display:inline-block;overflow: hidden;white-space:nowrap;">{$profileinfo.givenname}</span>   
														{if $profileinfo.bargain eq '1'}
														<span style="float: right;padding-left:5px;color:#CF2D28;"><span class="mui-icon iconfont icon-bargain"></span></span>
														{else}
														<span style="float: right;color:#999;padding-left:5px;"><span class="mui-icon iconfont icon-jujue"></span></span>
														{/if}
														<span style="float: right;color:#999">{$profileinfo.published}</span>
													</div>
												</li>
											{/foreach}
										</ul>
									</li>
									{/if}
								{/if}
							{/if}
			                {foreach name="propertygroup" item=property_info key=property_name from=$property_type}
			                   <li class="mui-table-view-cell" style="padding: 5px 15px;">
								    <span class="mui-pull-left">{$property_name} : &nbsp;&nbsp; </span>
			                        <div class="yanse_xz mui-pull-left">
			                        <input type="hidden" id="propertygroup_label_{$smarty.foreach.propertygroup.iteration}" value="{$property_name}" />
			                        {foreach name="property" item=property key=propertyid from=$property_info}
			                            <a class="btn btn-default propertygroup_{$smarty.foreach.propertygroup.iteration}" groupid="{$smarty.foreach.propertygroup.iteration}" propertyid="{$propertyid}" href="javascript:;"  >{$property}
			                                <div style="display:none">
			                                    <input class="propertygroup_input_{$smarty.foreach.propertygroup.iteration}" id="property_{$smarty.foreach.propertygroup.iteration}_{$propertyid}" type="radio" name="propertygroup_{$smarty.foreach.propertygroup.iteration}" propertyid="{$propertyid}" value="{$property}" />
			                                </div>
			                            </a>
			                        {/foreach}
								    </div>
			                   </li>
			                {/foreach} 
							<li class="mui-table-view-cell" >
								  <span class="mui-pull-left">购买数量 : &nbsp;&nbsp; </span>
								  <div class="mui-pull-left">
					  				<div class="mui-numbox" data-numbox-step='1' data-numbox-min='1' data-numbox-max='1'>
					  					<button disabled class="mui-btn mui-numbox-btn-minus" type="button">-</button>
										<input value="{$productinfo.postage}" id="postage" type="hidden"/>
										<input value="{$productinfo.includepost}" id="includepost" type="hidden"/>
										<input value="{$productinfo.mergepostage}" id="mergepostage" type="hidden"/>
					  					<input readonly   id="qty_item" name="qty_item" class="mui-numbox-input" type="number" />
					  					<button disabled class="mui-btn mui-numbox-btn-plus" type="button">+</button>
					  				</div>
	 							  </div>
	 			            </li> 
							<li class="mui-table-view-cell" >
								  <span class="mui-pull-left">库存数量 : &nbsp;&nbsp; </span>
								  <div class="mui-pull-left">
					  				  {if $jd eq '1'}
					  				  <span id="inventory_label">{if $productinfo.inventory eq '0'}无货{else}有货{/if}</span>
									  {else}
									  <span id="inventory_label">{$productinfo.inventory}</span>&nbsp;件
									  {/if}
	 							  </div>
	 			            </li>
							<li id="postage_panel" class="mui-table-view-cell"  style="display: {if $productinfo.postage|@floatval gt 0 }block{else}none{/if};">
								<span class="mui-pull-left">邮费 : &nbsp;&nbsp; </span>
								<div class="mui-pull-left">
									<span class="totalprice">￥<b><span id="postage_span" style="font-size: 16px;">{$productinfo.postage}</span></b>元</span>
									{*<span>
										{if $productinfo.mergepostage|@intval eq 1}合{else}分{/if}
									</span>*}
									{if $productinfo.includepost|@intval gt 0}
										<span style="color:#878787;margin-left:10px;">({$productinfo.includepost}
																					  件包邮)</span>
									{/if}
								</div>
							</li>
							<li class="mui-table-view-cell" >
								  <span class="mui-pull-left">合计 : &nbsp;&nbsp; </span>
								  <div class="mui-pull-left">
									  {if $productinfo.activityname neq '' &&  $productinfo.zhekoulabel neq '' && $productinfo.zhekou neq ''}
									   		<span class="totalprice">￥<b><span id="totalprice" style="font-size: 16px;">{$productinfo.promotional_price+$productinfo.postage|string_format:"%.2f"}</span></b>元</span>
									  {else}
									  	 	<span class="totalprice">￥<b><span id="totalprice" style="font-size: 16px;">{$productinfo.shop_price+$productinfo.postage|string_format:"%.2f"}</span></b>元</span>
									  {/if} 
	 							  </div>
	 			            </li>
						</ul> 
							
                        <a id="detail_image" href="javascript:;"><h5 class="show-content" style="padding: 10px;">图文详情【点击查看更多图文详情】</h5></a>
                         
                        <div id="segmentedControl" class="mui-slider-indicator mui-segmented-control mui-segmented-control-inverted">
                            <a class="mui-control-item mui-active" href="#item1mobile">商品描述</a>
                            <a class="mui-control-item" href="#item2mobile">累计评价</a>
                            <a class="mui-control-item" href="#item3mobile">成交记录</a>
                            <a class="mui-control-item" href="#item4mobile">服务声明</a>
                        </div>
                        <div class="mui-content-padded-2" style="background: #FFFFFF; padding: 10px;">
                            <div id="item1mobile" class="mui-control-content mui-active">
								{$productinfo.simple_desc}
							</div>
                            <div id="item2mobile" class="mui-control-content">
								{if $appraises|@count eq 0}
								 <h5 class="show-content" style="padding: 10px;background: #ff5400;">目前没有评价。</h5>                   
								{else}
									<ul class="mui-table-view"> 
										{foreach name="appraises" item=appraises_info   from=$appraises}
											<li class="mui-table-view-cell" style="padding: 8px 5px;">  
												<div class="mui-media-body">  
													<img class="mui-media-object mui-pull-left" style="width:20px;height:20px;" src="{$appraises_info.headimgurl}">
													<span style="width:80px;text-align:left;display:inline-block;">{$appraises_info.givenname}</span>
													【{$appraises_info.praise_info}】
												</div> 
												<div class="mui-media-body" style="padding-left:30px;color:#4d4d4d">  
													 {$appraises_info.remark}
												</div>  
												{if $appraises.hasimages gt 0}
												<div class="mui-media-body" style="padding-left:30px;">  
													  {foreach name="appraise_images" item=appraise_image_info   from=$appraises.images}
													      <img class="mui-media-object mui-pull-left" src="{$appraise_image_info}">
													  {/foreach}
												</div>
												{/if}
												<div class="mui-media-body" style="padding-left:30px;color:#999">  
													 {$appraises_info.published}
												</div>
										    </li>
										{/foreach}
									</ul>
									 <a id="moreappraises" href="javascript:;"><h5 class="show-content" style="padding: 10px;background: #ff5400;">【点击查看更多评价】</h5></a>   
								{/if}     
							</div>
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
									{foreach name="transactionrecords" item=transactionrecord_info   from=$transactionrecords}
										<li class="mui-table-view-cell" style="padding: 8px 5px;">  
											<div class="mui-media-body  mui-pull-left">  
												<span style="width:80px;text-align:left;display:inline-block;">{$transactionrecord_info.givenname}</span>¥{$transactionrecord_info.shop_price} 
											</div>   
											<div class="mui-media-body mui-pull-right">  
												<span style="width:105px;text-align:right;display:inline-block;">{$transactionrecord_info.published}</span>  
											</div>  
											<div class="mui-media-body mui-pull-right">  
												<span style="width:30px;text-align:left;display:inline-block;">{$transactionrecord_info.quantity}</span>  
											 </div>   
									    </li>
									{/foreach}
								</ul> 
							</div>
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
						<div class="show-content" style="padding-top: 15px;"><img class="img-responsive" src="images/baozhang.png"></div>
                    </div> 
                    <!--end detail-->
                </div>
            </div>
            <div class="mui-backdrop" style="display:none;"></div>
        </div>
 
	


	<script type="text/javascript">
	    var propertys = {$propertys}; 
	{literal} 
	    mui.init({
	        pullRefresh: {
	            container: '#pullrefresh' 
	        },
	    });
	    
		mui.ready(function() { 
			mui('#pullrefresh').scroll(); 
			mui('.mui-bar').on('tap','a.addshoppingcart',function(e){
				addshoppingcart();
			});
			mui('.mui-bar').on('tap','a.shoppingcart',function(e){ 
				var shoppingcarturl = this.getAttribute('href');
				checkshoppingcart(shoppingcarturl); 
			});
			
			mui('#propertygroup').on('tap','a.mycollection',function(e){ 
				  var productid = Zepto('#productid').val();
				  var status = Zepto('#mycollection').val();
				  if (status == "0")
				  {
					  
					   var postbody = 'record=' + productid + '&status=1';
	 		           mui.ajax({
	 			            type: 'POST',
	 			            url: "mycollection_add.ajax.php",
	 			            data: postbody,
	 			            success: function(json) {   
	 								 mui.toast("成功添加到收藏！"); 
	 								  Zepto('#mycollection').val("1");
	 								  Zepto("#mycollectionicon").addClass("icon-collection");
	 								  Zepto("#mycollectionicon").removeClass("icon-nocollection");
	 								  Zepto("#mycollectionicon").removeClass("mui-slow-twinkling"); 
		 			            }
	 					 }); 
				  }
				  else
				  {
					   
					   var postbody = 'record=' + productid + '&status=0';
	 		           mui.ajax({
	 			            type: 'POST',
	 			            url: "mycollection_add.ajax.php",
	 			            data: postbody,
	 			            success: function(json) {   
	 								 mui.toast("成功取消收藏！"); 
	 								 Zepto('#mycollection').val("0");
	 								 Zepto("#mycollectionicon").addClass("icon-nocollection");
	 								 Zepto("#mycollectionicon").addClass("mui-slow-twinkling"); 
	 								  Zepto("#mycollectionicon").removeClass("icon-collection");
	 			            }
	 					 }); 
					  
				  }
			});
			mui('#detail_image').on('tap','h5',function(e){ 
				detail_image();
			});
			mui('#moreappraises').on('tap','h5',function(e){ 
				var from = Zepto('#from').val();
				var pagenum = Zepto('#pagenum').val(); 
				var scrolltop = Zepto('#scrolltop').val();
				var productid = Zepto('#productid').val();
				var url = 'detail_appraise.php?productid='+productid+'&scrolltop='+scrolltop+'&pagenum='+pagenum+'&from='+from;
				mui.openWindow({
					url: url,
					id: 'info'
				});
			});
			mui('#propertygroup').on('tap', 'a', function(e) {
				
				var groupid =  this.getAttribute('groupid');
				var propertyid =  this.getAttribute('propertyid');    
				
				Zepto(".propertygroup_"+groupid).removeClass("active"); 
				Zepto(this).addClass("active"); 
				
				Zepto(".propertygroup_input_"+groupid).attr("checked",false); 
				Zepto("#property_"+groupid+"_"+propertyid).attr("checked",true); 
				Zepto("#type").val('');  
				change_price();
			});
			mui('#propertygroup').on('tap','li.bargainrequirednumber',function(e){
				if(Zepto("#bargains_profile").hasClass("bargains-profile-show"))
				{
					Zepto("#bargains_profile").removeClass("bargains-profile-show");
					Zepto("#bargains_profile").addClass("bargains-profile");
				}else{
					Zepto("#bargains_profile").removeClass("bargains-profile");
					Zepto("#bargains_profile").addClass("bargains-profile-show");
				}
			});
		});
		function detail_image()
		{ 
			var from = Zepto('#from').val();
			var pagenum = Zepto('#pagenum').val(); 
			var scrolltop = Zepto('#scrolltop').val();
			var productid = Zepto('#productid').val();
			var url = 'detail_image.php?productid='+productid+'&scrolltop='+scrolltop+'&pagenum='+pagenum+'&from='+from;
			mui.openWindow({
				url: url,
				id: 'info'
			});
		}
		function checkshoppingcart(shoppingcarturl)
		{ 
            var inventory = Zepto('#inventory1').val();
            var newinventory = parseInt(inventory,10);
            if ( newinventory <= 0)
            {
				mui.toast('您选择的商品已经卖完了！'); 
                return false;
            }
			if (Zepto('#type').val() == "")
			{
	            var property_type_count = Zepto('#property_type_count').val();
	            for(var i=1;i<=property_type_count;i++)
	            {
					var radio = Zepto('input[name=propertygroup_'+i+'][checked=true]');
	                if( radio.val() == undefined ) 
	                { 
	                    mui.toast('请选择商品的'+Zepto('#propertygroup_label_'+i).val()); 
	                    return false;
	                }
	            } 
				mui.toast('您还需要选择的商品属性！');  
				return false;
			}
			else
			{
				var qty_item = Zepto('#qty_item').val(); 
				var productid = Zepto('#productid').val();
				var product_property_id = Zepto('#product_property_id').val();  
			 
			    var postbody = 'shoppingcart=1&record=' + productid + '&quantity=' + qty_item;
			    if (product_property_id != "" && product_property_id != undefined)
				{
					postbody = 'type=detail&shoppingcart=1&record=' + productid + '&quantity=' + qty_item + '&propertyid=' + product_property_id;
				}
				var salesactivityid = Zepto('#salesactivityid').val();
				var salesactivity_product_id = Zepto('#salesactivity_product_id').val();
				if (salesactivityid != "" && salesactivity_product_id != "")
				{
					postbody += '&salesactivityid='+salesactivityid + '&salesactivitys_product_id='+salesactivity_product_id;
				}
			     
		        mui.ajax({
			            type: 'POST',
			            url: "shoppingcart_add.ajax.php",
			            data: postbody,
			            success: function(json) {   
			                var jsondata = eval("("+json+")");
			                if (jsondata.code == 200 || jsondata.code == 202) {
								mui.openWindow({
									url: shoppingcarturl,
									id: 'info'
								});
			                } 
							else
							{
								mui.toast(jsondata.msg);
								var jmpurl = "";
								if (jsondata.code == 203){
									jmpurl = "orders_pendingpayment.php";
								}else if (jsondata.code == 204){
									jmpurl = "orders_sendout.php";
								}else if (jsondata.code == 205){
									jmpurl = "orders_receipt.php";
								}else if (jsondata.code == 206){
									jmpurl = "orders_appraise.php";
								}
								if(jmpurl != ""){
									setTimeout(function()
											   {
												   mui.openWindow({url:jmpurl,id:"info"})
											   },
									2000);
								}
							}
			            }
					 }); 
			}
		}
		function addshoppingcart()
		{ 
            var inventory = Zepto('#inventory1').val();
            var newinventory = parseInt(inventory,10);
            if ( newinventory <= 0)
            {
				mui.toast('您选择的商品已经卖完了！'); 
                return false;
            }
			if (Zepto('#type').val() == "")
			{
	            var property_type_count = Zepto('#property_type_count').val();
	            for(var i=1;i<=property_type_count;i++)
	            {
					var radio = Zepto('input[name=propertygroup_'+i+'][checked=true]');
	                if( radio.val() == undefined ) 
	                { 
	                    mui.toast('请选择商品的'+Zepto('#propertygroup_label_'+i).val()); 
	                    return false;
	                }
	            } 
				mui.toast('您还需要选择的商品属性！');  
				return false;
			}
			else
			{
				var qty_item = Zepto('#qty_item').val(); 
				var productid = Zepto('#productid').val();
				var product_property_id = Zepto('#product_property_id').val();  
			 
			    var postbody = 'record=' + productid + '&quantity=' + qty_item;
			    if (product_property_id != "" && product_property_id != undefined)
				{
					postbody = 'type=detail&record=' + productid + '&quantity=' + qty_item + '&propertyid=' + product_property_id;
				}
				var salesactivityid = Zepto('#salesactivityid').val();
				var salesactivity_product_id = Zepto('#salesactivity_product_id').val();
				if (salesactivityid != "" && salesactivity_product_id != "")
				{
					postbody += '&salesactivityid='+salesactivityid + '&salesactivitys_product_id='+salesactivity_product_id;
				}
			     
		        mui.ajax({
			            type: 'POST',
			            url: "shoppingcart_add.ajax.php",
			            data: postbody,
			            success: function(json) {   
			                var jsondata = eval("("+json+")");
			                if (jsondata.code == 200) {   
								 mui.toast(jsondata.msg);
								 flyItem("productlogo");
			                     Zepto('#shoppingcart_badge').html('<span class="mui-badge">'+jsondata.shoppingcart+'</span>'); 
			                } 
							else
							{
								 mui.toast(jsondata.msg);
							}
			            }
					 }); 
			}
		}
		function change_price()
		{
			var property_type_count = Zepto('#property_type_count').val();
			var propertygroup = [];
			for(var i=1;i<=property_type_count;i++)
			{
				var radio = Zepto('input[name=propertygroup_'+i+'][checked=true]');
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
				var propertyarray = propertyids.split(',');
				if (propertygroupstr == propertyarray.sort().toString())
				{
					var zhekou = Zepto('#zhekou').val();
					var newzhekou = parseFloat(zhekou,10) * 0.1;
					var qty_item = Zepto('#qty_item').val();
					var includepost  = Zepto("#includepost").val();
					var postage      = Zepto("#postage").val();
					var mergepostage = Zepto("#mergepostage").val();
					var allpostage = 0; 
					if (parseFloat(postage, 10) > 0)
					{
						if (parseInt(mergepostage, 10) != 1)
						{
							postage = parseFloat(postage, 10) * parseInt(qty_item, 10);
						}
						Zepto("#postage_span").html(parseFloat(postage, 10).toFixed(2));
						if (parseInt(includepost, 10) > 0 && parseInt(includepost, 10) <= parseInt(qty_item, 10))
						{
							Zepto("#postage_panel").css('display', 'none;');
						}
						else
						{
							Zepto("#postage_panel").css('display', 'block;');
							allpostage = parseFloat(postage, 10);
						}
					}
					if (newzhekou > 0)
					{
						var activitymode = Zepto("#activitymode").val();
						var bargainrequirednumber = Zepto("#bargainrequirednumber").val();
						var bargains_profile_count = Zepto("#bargains_profile_count").val();
						
						Zepto("#old_shop_price").html(v.shop_price);
						if(activitymode == 1){
							var promotional_price = v.shop_price * newzhekou;
							Zepto("#shop_price").html(promotional_price.toFixed(2));
							promotional_price = v.shop_price - v.shop_price * (1 - newzhekou) / parseFloat(bargainrequirednumber,10) * parseInt(bargains_profile_count,10);
							promotional_price += parseFloat(allpostage,10);
							Zepto("#shop_price1").val(v.shop_price);
							Zepto("#total_price1").val(promotional_price.toFixed(2));
							Zepto("#totalprice").html(promotional_price.toFixed(2));
						}else
						{
							var promotional_price = v.shop_price * newzhekou;
							promotional_price += parseFloat(allpostage,10);
							Zepto("#shop_price").html(promotional_price.toFixed(2));
							Zepto("#shop_price1").val(v.shop_price);
							Zepto("#total_price1").val(promotional_price.toFixed(2));
							Zepto("#totalprice").html(promotional_price.toFixed(2));
						}
					}
					else
					{
						Zepto("#shop_price").html(v.shop_price);
						Zepto("#shop_price1").val(v.shop_price);
						Zepto("#total_price1").val(v.shop_price);
						Zepto("#totalprice").html(v.shop_price);
					}
					Zepto("#product_property_id").val(v.propertytypeid);
					Zepto("#market_price").html(v.market_price);

					Zepto("#productlogo").html(v.imgurl);
					var jd = Zepto("#jd").val();
					if (jd == "1")
					{
						if (v.inventory == '0')
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
					//Zepto("#inventory_label").html(v.inventory);
					Zepto("#inventory1").val(v.inventory);
					Zepto("#type").val('submit');
				}

			});
		}
		{/literal}
	</script>
{include file='weixin.tpl'} 
<script src="/public/js/baidu.js?_=20140821" type="text/javascript"></script>
</body>   
</html>
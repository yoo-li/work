<!DOCTYPE html>
<html> 
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>商城介绍</title>
    <link href="public/css/mui.css" rel="stylesheet" />
    <link href="public/css/public.css" rel="stylesheet" />
	<link href="public/css/iconfont.css" rel="stylesheet" />  
    <script src="public/js/mui.min.js" type="text/javascript" charset="utf-8"></script>  
	<script type="text/javascript" src="public/js/jweixin.js"></script> 
	<script src="public/js/zepto.min.js" type="text/javascript" charset="utf-8"></script>  
	<script src="public/js/utils.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript" src="public/js/jweixin.js"></script> 
	<style>
	  {literal} 
			.img-responsive { display: block; height: auto; width: 100%; } 
		  	.mui-table-view-cell .mui-table-view-label
		  	{
		  	    width:60px;
		  		text-align:right;
		  		display:inline-block;
		  	} 
		  	.text_indent{
		  		text-indent: 2em;
		  	}
		  	.text_indent p{
		  		color: #000;
		  	}
	 {/literal} 
	</style>
	{include file='theme.tpl'} 
</head>
<body>  
 
<div class="mui-inner-wrap">
	<header class="mui-bar mui-bar-nav" style="padding-right: 15px;">  
		 <a class="mui-icon mui-action-back mui-icon-back mui-pull-left"></a> 
		 <h1 class="mui-title">商城介绍</h1> 
	</header> 
	{include file='footer.tpl'}   
    <div id="pullrefresh" class="mui-content mui-scroll-wrapper" style="padding-top: 50px;">  
            <div class="mui-scroll">   
				<div class="mui-card" style="margin: 0 3px;"> 
                        <ul class="mui-table-view"> 
                                <li class="mui-table-view-cell"> 
										<div class="mui-media-body  mui-pull-left">
											<span class="mui-table-view-label">企业名称：</span>{$supplier_info.suppliername} 
										</div>
                                </li>
                                <li class="mui-table-view-cell"> 
										<div class="mui-media-body  mui-pull-left">
											<span class="mui-table-view-label">企业地址：</span>{$supplier_info.address} 
										</div>
                                </li>
                                {if $supplier_info.supplierid eq "12352"} 
                                <li class="mui-table-view-cell"> 
										<div class="mui-media-body  mui-pull-left text_indent">
											<!-- <span class="mui-table-view-label">企业地址：</span>{$supplier_info.address}  -->
											<p>无锡惠民商城是由无锡市民卡有限公司全资子公司无锡太湖交通卡有限公司独立研发运营的综合电商服务平台，为各类企事业单位提供方便、实惠、优质、快捷的综合福利消费平台，为企业员工提供“网络商店+实体店+联机账户+商城卡”的线上线下多渠道福利消费场景。目前无锡惠民商城已经与京东商城及无锡本地特色产品供应商开展了战略合作，实现最快“上午下单，下午发货”的全新福利消费新体验。</p>
											<p>请务必在购物前仔细阅读以下条款，如有疑问，可咨询商城在线客服或者拨打客服热线。</p>
											<p>1.凡商品为自营的，均由京东配送，并且不支持货到付款；</p>
											<p>2.凡商品为非自营的，由与惠民商城合作的物流公司负责配送，不支持货到付款；</p>
											<p>3.所有订单在下单配送后7天内请确认收货，如有漏单、破损、延迟、丢件等问题请于下单后7天内及时联系商城在线客服，7天内均支持无理由退换货（退换货细则点击）；</p>
											<p>4.惠民商城支持市民卡联机账户、惠民商城卡、惠民e卡、微信等多种支付方式，请您妥善保管好您的账户及密码，惠民商城从不会向用户索要账户密码，更不会泄露您的个人信息；</p>
											<p>5.惠民商城会不定期策划一些促销活动，商品价格有波动都是正常现象，我司不会因此补偿相应的差额。</p>
											<p>为了更多的消费者能够正常参与惠民商城的优惠活动，营造一个公平公正透明的网络购物环境，对存在以下情形的购买行为，惠民商城将保留取消相关订单或服务以及进行追偿的权利：</p>
											<p>1.因收货人信息填写有误，连续3天联系不上，无法完成订单配送；</p>
											<p>2.利用惠民商城漏洞多次下单，骗取商品优惠、折扣、赠品的行为；</p>
											<p>3.同一顾客（包括但不限于收货电话、用户名、用户地址、收货地址相同或类似，以及存在其他可能被认为属同一自然人的情形）购买数量超过活动限制的订单；</p>
											<p>4.天气等不可抗力造成的因素；</p>
											<p>客服热线：0510-88760000（周一~周五8:30-17:00）</p>
											<p>购卡热线：0510-66660066（周一~周五8:30-17:00）</p>
										</div>
                                </li>
                                {/if}    
                                <li class="mui-table-view-cell"> 
										<div class="mui-media-body "> 
										 <a id="detail_image" href="album.php" style="width:100%"><h5 class="show-content" style="padding: 10px;">商家相册【点击查看商家相册】</h5></a>
										</div>  
                                </li>
						</ul>  
			    </div>
			    {if $supplier_info.supplierid neq '7962' && $supplier_info.supplierid neq '12352'}
				<div class="mui-card" style="margin: 3px 3px;"> 
                        <ul class="mui-table-view">  
                                <li class="mui-table-view-cell"> 
				                        <a id="potenitalsuppliers" href="potenitalsuppliers.php"><h5 class="show-content" style="padding: 10px;">【商城合作请点击<span class="mui-icon iconfont icon-dianji"></span>】</h5></a>
							    </li>
               		</ul>  
			    </div>
			    {/if}
				{include file='copyright.tpl'}
         </div>
	</div>
</div> 
 
 
	      
	<script type="text/javascript"> 
	{literal}	 
	    mui.init({
	        pullRefresh: {
	            container: '#pullrefresh', //待刷新区域标识，querySelector能定位的css选择器均可，比如：id、.class等  
	        },
	    });
		mui.ready(function() {  
			mui('#pullrefresh').scroll();
			mui('.mui-bar').on('tap','a',function(e){
				mui.openWindow({
					url: this.getAttribute('href'),
					id: 'info'
				});
			});  
			mui('.mui-table-view-cell').on('tap','a',function(e){
				mui.openWindow({
					url: this.getAttribute('href'),
					id: 'info'
				});
			});  
	   }); 
	{/literal} 
	</script>
{include file='weixin.tpl'} 
<script src="/public/js/baidu.js?_=20140821" type="text/javascript"></script>
</body> 
</html>
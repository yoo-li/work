<?php /* Smarty version 2.6.18, created on 2017-08-25 17:01:12
         compiled from confirmpayment.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'confirmpayment.tpl', 437, false),)), $this); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
	<title>确认支付</title>
	<link href="public/css/mui.css" rel="stylesheet"/>
	<link href="public/css/public.css" rel="stylesheet"/>
	<link href="public/css/iconfont.css" rel="stylesheet"/>
	<link rel="stylesheet" href="public/css/smk_order.css">
	<link href="public/css/voupons.css" rel="stylesheet" />
	<script src="public/js/mui.min.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript" src="public/js/jweixin.js"></script>
	<script src="public/js/zepto.min.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript" src="public/js/jweixin.js"></script>
	<script src="public/js/utils.js" type="text/javascript" charset="utf-8"></script>
	<style>
		<?php echo '
		body{
			font-size: 12px;
		}
		@font-face {
			font-family: \'icon\';  /* project id 264504 */
			src: url(\'http://at.alicdn.com/t/font_pssamdgsvg5sif6r.eot\');
			src: url(\'http://at.alicdn.com/t/font_pssamdgsvg5sif6r.eot?#iefix\') format(\'embedded-opentype\'),
			url(\'http://at.alicdn.com/t/font_pssamdgsvg5sif6r.woff\') format(\'woff\'),
			url(\'http://at.alicdn.com/t/font_pssamdgsvg5sif6r.ttf\') format(\'truetype\'),
			url(\'http://at.alicdn.com/t/font_pssamdgsvg5sif6r.svg#iconfont\') format(\'svg\');
		}
		.mgrg25{
			margin-right: 25px;
		}
		.img-responsive {
			display: block;
			height: auto;
			width: 100%;
		}
		.menuicon {
			font-size: 1.2em;
			color: #fe4401;
			padding-right: 10px;
		}

		.menuitem a {
			font-size: 1.1em;
		}

		#payment_button {
			font-size: 20px;
			padding-left: 5px;
		}

		.mui-bar-tab .mui-tab-item .mui-icon {
			width: auto;
		}

		.mui-table-view-cell .mui-table-view-label {
			width: 60px;
			text-align: right;
			display: inline-block;
		}

		.totalprice {
			color: #CF2D28;
			font-size: 1.2em;
			font-weight: 500;
		}

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

		.btn-default:hover, .btn-default:focus, .btn-default:active, .btn-default.active {
			color: #333;
			background-color: #ebebeb;
			border-color: #e53348;
			background: url(images/checked.png) no-repeat bottom right;
		}

		#radiogroup .mui-icon {
			font-size: 1.2em;
			color: #fe4401;
		}

		.mui-checkbox.mui-left input[type=\'checkbox\'] {
			left: 5px;
			top: 0px;
		}

		.mui-checkbox.mui-left label {
			padding-right: 0px;
			padding-left: 36px;
		}

		.mui-radio.mui-left input[type=\'radio\'] {
			left: 5px;
			top: 0px;
		}

		.mui-radio.mui-left label {
			padding-right: 10px;
			padding-left: 36px;
		}
		header.mui-bar{
			background-color: #f9f9f9 !important;
		}
		header .mui-title, header a{
			color: #232326 !important;
		}
		.mui-bar-tab{
			background: #fb3e21 !important;
			color: #fff !important;
		}
		.mui-bar-tab .mui-tab-item.mui-active,
		.mui-bar-tab .mui-tab-item .mui-icon,
		#payment_button{
			color: #fff !important;
			font-size: 18px !important;
		}
		.totalprice{
			color: #fb3e21 !important;
		}
		.mui-table-view input[type=\'radio\']:checked:before, .mui-radio input[type=\'radio\']:checked:before, .mui-checkbox input[type=\'checkbox\']:checked:before{
			color: #fb3e21 !important;
		}
		.btn-default:hover, .btn-default:focus, .btn-default:active, .btn-default.active{
			border-color: #fb3e21 !important;
			background-color: #fff !important;
		}
		.mui-card{
			margin: 0;
			border: 0;
			border-radius: 0;
		}
		.mui-bar-nav ~ .mui-content{
			padding-top: 40px;
		}
		.mui-table-view-cell:after{
			left: 0;
		}
		.mui-table-view-cell .mui-table-view-label{
			text-align: left;
		}
		.mui-table-view-cell p{
			color: #000;
			font-size: 14px;
		}
		.totalprice{
			float: right;
		}
		.mui-table-view .mui-media, .mui-table-view .mui-media-body{
			width: 100%;
		}
		.mui-table-view-cell{
			background-color: #fff;
		}
		.price-yue:after{
			display: none;
		}
		.pay-icon{
			width: 50px;
			height:38px;
			display: block;
		}
		.shidubill_pic{
			margin-left:15px;
		}
		.shidubill_pic img{
			width:38px;
		}
		.official_pic{
			margin-left:15px;
		}
		.official_pic img{
			width:38px;
		}
		.radiogroup{
			padding: 0;
		}
		.btn-default.active{
			background: none;
			border: 1px solid #fb3e21 !important;
		}
		#paymentwaygroup:after{
			display: none;
		}
		.img-responsive {
			display: inline-block;
			height: auto;
			max-width: 100%;
		}
		.show-content{
			display: none;
			padding: 0 10px;
			letter-spacing: 1px;
			padding: 0 10px;
			letter-spacing: 1px;
			position: fixed;
			top: 10%;
			left: 5%;
			width: 90%;
			height: 80%;
			z-index: 99;
			background: #fff;
			overflow: hidden;
			border-radius: 10px;
		}
		.bg-shadow{
			display: none;
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background: rgba(0, 0, 0, 0.5);
			z-index: 99;
		}
		.show-content .mui-scroll{
			width: 94%
		}
		/*优惠券样式*/
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
			padding: 10px 0px;
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
</head>

<body>
<div class="mui-off-canvas-wrap mui-draggable" id="offCanvasWrapper">
	<div class="mui-inner-wrap">
		<header class="mui-bar mui-bar-nav" style="padding-right: 15px;">
			<a id="mui-action-back" class="mui-icon <?php if ($this->_tpl_vars['returnbackatcion'] == ""): ?>mui-action-back<?php endif; ?> mui-icon-back mui-pull-left" <?php if ($this->_tpl_vars['returnbackatcion'] != ""): ?>href="<?php echo $this->_tpl_vars['returnbackatcion']; ?>
"<?php endif; ?>></a>
			<h1 class="mui-title" id="payment_title">确认支付</h1>
		</header>
		<nav class="mui-bar mui-bar-tab" style="height:40px;line-height:40px;">
			<a id="confirmpayment" class="mui-tab-item mui-active confirmpayment" href="#" style="width:30%"><span id="payment_button">确定支付</span>
			</a>
		</nav>

		<div id="pullrefresh" class="mui-content mui-scroll-wrapper" style="top: 5px;bottom: 50px;background-color: #fff;">
			<div class="mui-scroll">
				<input id="orderid" name="orderid" value="<?php echo $this->_tpl_vars['orderid']; ?>
" type="hidden">
				<input id="type" name="type" value="" type="hidden">
				<input id="totalprice" name="totalprice" value="<?php echo $this->_tpl_vars['total_money']; ?>
" type="hidden">
				<input id="money" name="money" value="<?php echo $this->_tpl_vars['availablenumber']; ?>
" type="hidden">
				<input id="allmoney" name="allmoney" value="<?php echo $this->_tpl_vars['profile_info']['money']; ?>
" type="hidden">
				<input id="moneypaymentrate" name="moneypaymentrate" value="<?php echo $this->_tpl_vars['moneypaymentrate']; ?>
" type="hidden">
				<input id="needpayable" name="needpayable" value="<?php echo $this->_tpl_vars['total_money']; ?>
" type="hidden">
				<input id="vipcardusageid" name="vipcardusageid" value="<?php echo $this->_tpl_vars['vipcard_usage_info']['id']; ?>
" type="hidden">
				<input id="vipcardusageamount" name="vipcardusageamount" value="<?php echo $this->_tpl_vars['vipcard_usage_info']['amount']; ?>
" type="hidden">
				<div class="mui-card" style="margin: 0 3px 5px 3px;">
					<ul class="mui-table-view">
						<li class="mui-table-view-cell mui-media mysure_list">
							<div class="mui-media-body">
								<p class="mysure_user" style="text-indent: 17px;font-weight: bold;"><?php echo $this->_tpl_vars['deliveraddress']['consignee']; ?>
<span style="14px;"><?php echo $this->_tpl_vars['deliveraddress']['mobile']; ?>
</span></p>
								<p><span class="icon icon-address" style="font-size: 17px;">&#xe600;</span><?php echo $this->_tpl_vars['deliveraddress']['province']; ?>
<?php echo $this->_tpl_vars['deliveraddress']['city']; ?>
<?php echo $this->_tpl_vars['deliveraddress']['district']; ?>
<?php echo $this->_tpl_vars['deliveraddress']['shortaddress']; ?>

								</p>
							</div>
							<img src="public/images/line.png" class="line">
						</li>
						<li class="mui-table-view-cell" style="margin-top: 10px;">
							<div class="mui-media-body  mui-pull-right">
								<span class="mui-table-view-label">总金额： </span><span class="totalprice">￥<span style="font-size: 1em;"><?php echo $this->_tpl_vars['total_money']; ?>
</span></span>
							</div>
						</li>
						<div id="paymentgroup">
							<?php if ($this->_tpl_vars['total_money'] >= 50): ?>
							<?php if ($this->_tpl_vars['profile_info']['money'] > 0): ?>
							<li class="mui-table-view-cell price-yue">
								<div class="mui-media-body  mui-pull-right">
									<span class="mui-table-view-label">您的余额： </span><span class="totalprice">￥<span class="yuecanuse" style="font-size: 1em;"><?php echo $this->_tpl_vars['profile_info']['money']; ?>
</span></span>
								</div>
							</li>
							<?php if ($this->_tpl_vars['frozenstatus'] == 'Frozen'): ?>
							<li class="mui-table-view-cell" style="text-align:center;">
								<span style="color:#CF2D28; font-size:1em; font-weight:500;">账号异常冻结，禁止使用余额！请联系客服! </span>
							</li>
							<?php endif; ?>

							<?php if ($this->_tpl_vars['vendorid'] != '417978'): ?>
							<li class="mui-table-view-cell">
								<div class="mui-media-body  mui-pull-right">
									<div class="mui-checkbox mui-left mui-pull-left" style="width:90px;height:26px;line-height:26px;">
										<label>使用余额</label>
										<input <?php if ($this->_tpl_vars['frozenstatus'] == 'Frozen'): ?>disabled<?php endif; ?> id="usemoney" name="usemoney" value="1" type="checkbox">
									</div>
									<div class="mui-pull-right" style="height:26px;line-height:26px;text-align: right">
										【本单最大可用余额为<span class="totalprice" id="allowmoney">￥<?php echo $this->_tpl_vars['availablenumber']; ?>
</span>】
									</div>
								</div>
							</li>
							<?php endif; ?>

							<?php endif; ?>
							<?php endif; ?>
							<?php if ($this->_tpl_vars['total_money'] < 50): ?>
							<?php if ($this->_tpl_vars['profile_info']['money'] > 0): ?>
							<li class="mui-table-view-cell price-yue"  style="background-color: #ccc;color: #999;">
								<div class="mui-media-body  mui-pull-right">
									<span class="mui-table-view-label">您的余额： </span><span class="totalprice" style="color: #999 !important;">￥<span class="yuecanuse" style="font-size: 1em;"><?php echo $this->_tpl_vars['profile_info']['money']; ?>
</span></span>
								</div>
							</li>
							<?php if ($this->_tpl_vars['frozenstatus'] == 'Frozen'): ?>
							<li class="mui-table-view-cell" style="text-align:center;background-color: #ccc;color: #999;">
								<span style="color:#CF2D28; font-size:1em; font-weight:500;">账号异常冻结，禁止使用余额！请联系客服! </span>
							</li>
							<?php endif; ?>
							<li class="mui-table-view-cell"  style="background-color: #ccc;color: #999;">
								<div class="mui-media-body  mui-pull-right">
									<div class="mui-checkbox mui-left mui-pull-left" style="width:90px;height:26px;line-height:26px;">
										<label>使用余额</label>
										<span disabled <?php if ($this->_tpl_vars['frozenstatus'] == 'Frozen'): ?>disabled<?php endif; ?> type="checkbox"></span>
									</div>
									<div class="mui-pull-right" style="height:26px;line-height:26px;text-align: right;">
										【本单余额最大可用为<span class="totalprice" id="allowmoney" style="color: #999 !important;">￥<?php echo $this->_tpl_vars['availablenumber']; ?>
</span>】
									</div>
								</div>
								<div style="text-align:center;padding: 0.5px;color:#fb3e21;">小主，您的订单未满50元，不能使用余额抵扣哦，赶紧去凑单吧~</div>
							</li>
							<?php endif; ?>
							<?php endif; ?>
							<?php if (count($this->_tpl_vars['vipcardusagelist']) > 0 && $this->_tpl_vars['total_money'] >= $this->_tpl_vars['availablenumber']): ?>
							<li class="mui-table-view-cell">
								<a href="#vipcards" class="mui-navigate-right vipcards">
									<div class="mui-media-body  mui-pull-left">
										<span class="mui-table-view-label">卡券优惠：</span>
										<span id="vipcard_msg"><?php echo $this->_tpl_vars['vipcard_usage_info']['vipcardname']; ?>
</span>
									</div>
								</a>
							</li>
							<li class="mui-table-view-cell">
								<div class="mui-media-body  mui-pull-left">
									<span class="mui-table-view-label">优惠金额：</span>
										<span class="totalprice">￥
												<span style="font-size: 1em;" id="discount"><?php echo $this->_tpl_vars['vipcard_usage_info']['amount']; ?>
</span>
										</span>
								</div>
							</li>
							<?php else: ?>
							<li class="mui-table-view-cell">
								<div class="mui-media-body  mui-pull-left">
									<span class="mui-table-view-label">卡券优惠：</span>您没有可用的卡券
								</div>
							</li>
							<?php endif; ?>
							<?php if ($this->_tpl_vars['official'] != 'true'): ?>
							<li class="mui-table-view-cell price-yue">
								<div class="mui-media-body  mui-pull-right">
									<span class="mui-table-view-label" style="display: inline-block;width:75px;">惠民商城卡： </span>
									<!-- <a href="smk_bindcard.php?record=<?php echo $this->_tpl_vars['orderid']; ?>
" class="mui-btn mui-btn-danger" style="font-size: 12px;width:70px;height:22px;text-align: center;padding-top:2px;background-color: #f00;">绑定新卡</a> -->
									<span class="totalprice">￥<span style="font-size: 1em;" id="sckmoney"><?php if ($this->_tpl_vars['totle_money'] == null): ?>0.00<?php else: ?><?php echo $this->_tpl_vars['totle_money']; ?>
<?php endif; ?></span></span>
								</div>
							</li>
							<li class="mui-table-view-cell">
								<div class="mui-media-body  mui-pull-right">
									<div class="mui-checkbox mui-left mui-pull-left" style="width:90px;height:26px;line-height:26px;">
										<label style="display: inline-block;width:100px;">使用商城卡</label>
										<input  name="radio1" type="checkbox" id="mycheckboxchoice" >
									</div>
									<!--<div class="mui-pull-right" style="height:26px;line-height:26px;text-align: right">-->
										<!--【本单商城卡可用为<span class="totalprice" id="smk_use_money">￥</span>】-->
									<!--</div>-->
								</div>
								<input id="totle_money" name="totle_money" value="<?php echo $this->_tpl_vars['totle_money']; ?>
" type="hidden">
								<input id="smk_use" name="smk_use" value="0" type="hidden">
							</li>
							<?php endif; ?>
							<li class="mui-table-view-cell">
								<div class="mui-media-body  mui-pull-left">
									<span class="mui-table-view-label">还需支付：</span>
									<span class="totalprice">￥
											<span style="font-size: 1em;" id="needpayment"><?php if (count($this->_tpl_vars['vipcard_usage_info']) > 0): ?><?php echo $this->_tpl_vars['vipcard_usage_info']['total_money']; ?>
<?php else: ?><?php echo $this->_tpl_vars['total_money']; ?>
<?php endif; ?></span>
									</span>
								</div>
							</li>
							<li class="mui-table-view-cell" id="paymentwaygroup" >
								<div class="mui-media-body  mui-pull-left" style="width: 70px;">
									<span class="mui-table-view-label">支付方式：</span>
								</div>
								<div class="yanse_xz mui-pull-left" id="radiogroup">
									
									<?php if ($this->_tpl_vars['official'] == 'true' && $this->_tpl_vars['official_in'] == 'true'): ?>
										<a class="btn btn-default radiogroup official_pic" groupid="payment" paymentway="official" href="javascript:;" style="margin-right: 15px">
											<span class="mui-icon iconfont icon-kongxinshiwuguan" style="font-size: 3.2em;"></span>
											<div style="display:none">
												<input class="paymentway" id="official" type="radio" name="paymentway" value="official" />
											</div>
										</a>
									<?php endif; ?>
									<?php if ($this->_tpl_vars['official'] == 'true' && $this->_tpl_vars['shidubill_in'] == 'true'): ?>
                                    										<a class="btn btn-default radiogroup shidubill_pic" id="shidu_id"
										   groupid="payment"
										   paymentway="official" href="javascript:;" style="margin-right: 15px;
										 ">
											<img class="pay-icon " src="/public/images/shidubill.png" alt="">
											<div style="display:none">
												<input class="paymentway" id="official" type="radio" name="paymentway" value="official" />
											</div>
 										</a>
                                    <?php endif; ?>

									<div class="mui-pull-left mgrg25" style="margin-right: 15px">
										<a class="btn btn-default radiogroup" groupid="payment" paymentway="wxsmk" href="javascript:;" >
											<img class="pay-icon" src="/public/images/zhifu.png" alt="">
											<div style="display:none">
												<input class="paymentway" id="wxsmk" type="radio" name="paymentway" value="wxsmk"  />
												<!--  -->
											</div>
										</a>
										<!-- <div style="text-align:center">联机账户</div> -->
									</div>

									<div class="mui-pull-left" style="display: none">
										<a class="btn btn-default radiogroup" groupid="payment" paymentway="weixin" href="javascript:;">
											<img class="pay-icon" src="/public/images/wechat_pay.png" alt="">
											<div style="display:none">
												<input class="paymentway" id="weixin" type="radio" name="paymentway" value="weixin"/>
											</div>
										</a>
										<!-- <div style="text-align:center">微信支付</div> -->
									</div>
								</div>
							</li>
							<li class="mui-table-view-cell" style="text-align:center;padding: 0.5px;"></li>
							<?php if ($this->_tpl_vars['userlast_card'] != NULL): ?>
							<li id="wxsmk_cardno_div" class="mui-table-view-cell" style="display:block;" >
								<div class="mui-media-body  mui-pull-left">
									<span class="mui-table-view-label" style="width:72px;">市民卡卡号：</span>

									<input id="wxsmk_cardno" name="wxsmk_cardno"
										   value="<?php echo $this->_tpl_vars['userlast_card']; ?>
" type="text" required="required"
										   style="border:0px;font-size: 12px;width:180px;height:20px;margin-bottom:0px;padding:0px;" class="mui-input-clear required" maxlength="11"
									>
								</div>
							</li>
							<?php else: ?>
							<li id="wxsmk_cardno_div" class="mui-table-view-cell" style="display:block;" >
								<div class="mui-media-body  mui-pull-left">
									<span class="mui-table-view-label" style="width:72px;">市民卡卡号：</span>

									<input id="wxsmk_cardno" name="wxsmk_cardno"
										   value="" type="text" required="required"
										   style="border:0px;font-size: 12px;width:180px;height:20px;margin-bottom:0px;padding:0px;" class="mui-input-clear required" maxlength="11"
										   placeholder=	"请输入市民卡卡号" >
								</div>
							</li>


							<?php endif; ?>
							<li id="wxsmk_password_div" class="mui-table-view-cell" style="display:block;">
								<div class="mui-media-body  mui-pull-left">
									<span class="mui-table-view-label" style="width:72px;">市民卡密码：</span>
									<input id="wxsmk_password" name="wxsmk_password"
										   value="" type="password" required="required"
										   style="border:0px;font-size: 12px;width:180px;height:20px;margin-bottom:0px;padding:0px;" class="mui-input-clear required" maxlength="15"
										   placeholder="请输入市民卡密码">
								</div>
							</li>
							<li class="mui-table-view-cell" style="text-align:center;"></li>

						</div>

					</ul>
				</div>
			</div>
		</div>
		<?php if ($this->_tpl_vars['supplierid'] == '12352'): ?>
		<?php else: ?>
		<?php endif; ?>
	</div>
</div>
</div>
<!--旧版卡券优惠-->
<!--<div id="vipcards" class="mui-popover mui-popover-action mui-popover-bottom">
	<ul class="mui-table-view">
		<?php $_from = $this->_tpl_vars['vipcardusagelist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['vipcardusages'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['vipcardusages']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['vipcardusage_info']):
        $this->_foreach['vipcardusages']['iteration']++;
?>
		<li class="mui-table-view-cell">
			<a href="#" data-id="<?php echo $this->_tpl_vars['vipcardusage_info']['id']; ?>
" data-amount="<?php echo $this->_tpl_vars['vipcardusage_info']['amount']; ?>
"><?php echo $this->_tpl_vars['vipcardusage_info']['vipcardname']; ?>

				<?php if ($this->_tpl_vars['vipcardusage_info']['orderamount'] == '0'): ?>
				【下单可用,<?php if ($this->_tpl_vars['vipcardusage_info']['timelimit'] == '0'): ?>限次<?php else: ?>不限次<?php endif; ?>】
				<?php else: ?>
				【满<?php echo $this->_tpl_vars['vipcardusage_info']['orderamount']; ?>
元可用,<?php if ($this->_tpl_vars['vipcardusage_info']['timelimit'] == '0'): ?>限次<?php else: ?>不限次<?php endif; ?>】
				<?php endif; ?>
			</a>
		</li>
		<?php endforeach; endif; unset($_from); ?>
	</ul>
	<ul class="mui-table-view">
		<li class="mui-table-view-cell">
			<a href="#vipcards" data-id="" data-amount="" style="font-weight:900;">本次不使用卡券</a>
		</li>
	</ul>
</div>-->
<!--新版卡券优惠-->

<div id="vipcards" class="mui-popover mui-popover-action mui-popover-bottom"  >
	<!--<div class="mui-scroll-wrapper">-->
		<!--<div class="mui-scroll">-->
	<ul class="mui-table-view mui-scroll-wrapper" style="width:100%;margin:auto;overflow-y:hidden;border-radius: 0px;">
		<div class="promote-card-list" style="margin: 10px 10px;">
		<p style="text-align: left;">选择可用卡券</p>
		<!--~遍历已经领用的优惠券-->
		<!--根据奇偶性判断显示颜色-->
<?php $_from = $this->_tpl_vars['vipcardusagelist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['vipcardusages'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['vipcardusages']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['vipcardusage_info']):
        $this->_foreach['vipcardusages']['iteration']++;
?>
		<li class="promote-item coupon-style-0">
			<!--zl优惠券是否有效-->
			<!-- <div class="promote-left-part" style="background: -webkit-gradient(linear, 0 0, 0 100%, from(#949191), to(rgb(125, 125, 125)));"> -->
			<div class="promote-left-part">
				<div class="inner">
					<div class="promote-card-value">
						<span id="myamount_add">￥</span>
						<i id="myamount"><?php echo $this->_tpl_vars['vipcardusage_info']['amount']; ?>
</i>
					</div>
					<div class="promote-condition font-size-12"><p id="myorderamount" style="color:#fff;">
						<?php if ($this->_tpl_vars['vipcardusage_info']['orderamount'] == '0'): ?>
							<?php if ($this->_tpl_vars['vipcardusage_info']['cardtype'] != '3'): ?>
							无门槛优惠券
							<?php endif; ?>
						<?php else: ?>
						满<?php echo $this->_tpl_vars['vipcardusage_info']['orderamount']; ?>
元可用
						<?php endif; ?>
					</p><p id="mytimelimit" style="color:#fff;"><?php if ($this->_tpl_vars['vipcardusage_info']['timelimit'] == '0'): ?>限次使用<?php else: ?>不限次使用<?php endif; ?></p></div>
				</div>
			</div>
			<div class="promote-right-part left font-size-12">
				<div class="inner">
					<h5 style="font-size: 1.2em;text-align: left;"><?php echo $this->_tpl_vars['vipcardusage_info']['vipcardname']; ?>
</h5>
						<a class="mui-radio"  style="margin:18px 0px 6px 60px;"   href="#" data-id="<?php echo $this->_tpl_vars['vipcardusage_info']['id']; ?>
" data-name="<?php echo $this->_tpl_vars['vipcardusage_info']['vipcardname']; ?>
" data-amount="<?php echo $this->_tpl_vars['vipcardusage_info']['amount']; ?>
" data-orderamount="<?php if ($this->_tpl_vars['vipcardusage_info']['orderamount'] == '0'): ?>无门槛优惠券<?php else: ?>
						满<?php echo $this->_tpl_vars['vipcardusage_info']['orderamount']; ?>
元可用<?php endif; ?>" data-timelimit="<?php if ($this->_tpl_vars['vipcardusage_info']['timelimit'] == '0'): ?>限次<?php else: ?>不限次<?php endif; ?>">
							<!--zl优惠券是否有效-->
							<input  class="useticket" style="right:4px;" name="useticket" type="radio" value="0">
						</a>
					<!--~有效时间-->
					<div class="promote-condition font-size-12"><?php echo $this->_tpl_vars['vipcardusage_info']['starttime']; ?>
 到 <?php echo $this->_tpl_vars['vipcardusage_info']['endtime']; ?>
</div>
				</div>
				<i class="expired-icon"></i>
				<i class="left-dot-line"></i>
			</div>
		</li>
<?php endforeach; endif; unset($_from); ?>
		<!-- <li class="promote-item coupon-style-0">
				<div class="promote-left-part" style="background-color: red;">
					<div class="inner">
						<div class="promote-card-value">

							<span id="myamount_add">￥</span>
							<i id="myamount">222</i>
						</div>
						<div class="promote-condition font-size-12"><p id="myorderamount" style="color:#fff;">无门槛优惠券
							</p><p id="mytimelimit" style="color:#fff;">不限次使用</p></div>
					</div>
				</div>
				<div class="promote-right-part left font-size-12">
					<div class="inner">
						<h5 style="font-size: 1.2em;text-align: left;">全品类（特里商品除外）</h5>
						<a class="mui-radio"  style="margin:18px 0px 6px 60px;"   href="#" data-id="<?php echo $this->_tpl_vars['vipcardusage_info']['id']; ?>
" data-name="111" data-amount="222" data-orderamount="无门槛优惠券" data-timelimit="<?php if ($this->_tpl_vars['vipcardusage_info']['timelimit'] == '0'): ?>限次<?php else: ?>不限次<?php endif; ?>">
							<input  class="useticket" style="right:4px;" name="useticket" type="radio" value="0">
						</a>
						<div class="promote-condition font-size-12">2017.01.01-2017.02.02</div>
					</div>
					<i class="expired-icon"></i>
					<i class="left-dot-line"></i>
				</div>
			</li>
		<li class="promote-item coupon-style-0">
				<div class="promote-left-part" style="background-color: red;">
					<div class="inner">
						<div class="promote-card-value">

							<span id="myamount_add">￥</span>
							<i id="myamount">222</i>
						</div>
						<div class="promote-condition font-size-12"><p id="myorderamount" style="color:#fff;">无门槛优惠券
						</p><p id="mytimelimit" style="color:#fff;">不限次使用</p></div>
					</div>
				</div>
				<div class="promote-right-part left font-size-12">
					<div class="inner">
						<h5 style="font-size: 1.2em;text-align: left;">全品类（特里商品除外）</h5>
						<a class="mui-radio"  style="margin:18px 0px 6px 60px;"   href="#" data-id="<?php echo $this->_tpl_vars['vipcardusage_info']['id']; ?>
" data-name="111" data-amount="222" data-orderamount="无门槛优惠券" data-timelimit="<?php if ($this->_tpl_vars['vipcardusage_info']['timelimit'] == '0'): ?>限次<?php else: ?>不限次<?php endif; ?>">
							<input  class="useticket" style="right:4px;" name="useticket" type="radio" value="0">
						</a>
						<div class="promote-condition font-size-12">2017.01.01-2017.02.02</div>
					</div>
					<i class="expired-icon"></i>
					<i class="left-dot-line"></i>
				</div>
			</li> -->

		<button type="button" id="ticketconfirm" class="mui-btn mui-btn-danger">确定</button>
		<br/>
		<br/>
		</div>
	</ul>
		<!--</div>-->
	<!--</div>-->
</div>
<script type="text/javascript">
	var returnbackatcion = "<?php echo $this->_tpl_vars['returnbackatcion']; ?>
";
	var autoriza_sign = "<?php echo $this->_tpl_vars['autoriza_sign']; ?>
";
 	<?php echo '
	mui.init({
		swipeBack: true, //启用右滑关闭功能
		pullRefresh: {
			container: \'#pullrefresh\'
		},
	});
	mui.ready(function ()
	{
 //{*shidu_id*}适度通宝支付时的权限判断
        var btn_shidu_id = document.getElementById("shidu_id");
        //监听点击事件
        btn_shidu_id.addEventListener("tap",function () {
            if(autoriza_sign==1){
                mui.alert(\'您还没有购物权限，请申请授权\');
                var obj_show = document.getElementById("shidu_id");
                obj_show.style.display= "none";
            }
        });

		if(mui(\'.useticket\').length>0){
			$(mui(\'.useticket\')[0]).prop("checked",true);
		}
		mui(\'.mui-scroll-wrapper\').scroll({
			bounce: true,
			indicators: false,
			deceleration: 0.0005 //flick 减速系数，系数越大，滚动速度越慢，滚动距离越小，默认值0.0006
		});
		//小数位数处理
		var youhuiquan=$(\'#discount\').html();
		var newyouhuiquan=changeTwoDecimal_f(youhuiquan);
		$(\'#discount\').html(newyouhuiquan);
		var sckmoney=$(\'#sckmoney\').html();
		var newsckmoney=changeTwoDecimal_f(sckmoney);
		$(\'#sckmoney\').html(newsckmoney);
		var yuecanuse=$(\'.yuecanuse\').html();
		var newyuecanuse=changeTwoDecimal_f(yuecanuse);
		$(\'.yuecanuse\').html(newyuecanuse);

		//~实现radio选中之后可以取消选中
		$(".useticket").click(
				function(){

					var nm=$(this).attr("name");
					$(".useticket[name="+nm+"]:not(:checked)").attr("value",0);
					if($(this).attr("value")==1){
						$(this).prop("checked",false);
						$(this).attr("value",0);
					}else{
						$(this).attr("value",1);
					}
				}
		);

		mui(\'#pullrefresh\').scroll();
		mui(\'.scroll-wrapper\').scroll({
			indicators: false //是否显示滚动条
		});
		mui(\'header.mui-bar\').on(\'tap\', \'a.mui-icon-back\', function (e)
		{
			if(this.getAttribute(\'href\') != "" && this.getAttribute(\'href\'))
			{
				mui.openWindow({
					url: this.getAttribute(\'href\'),
					id: \'info\'
				});
			}
		});

		mui(\'#radiogroup\').on(\'tap\', \'a\', function (e)
		{
			if (Zepto(\'#type\').val() == \'submit\') return;
			var paymentway = this.getAttribute(\'paymentway\');
			Zepto(".radiogroup").removeClass("active");
			Zepto(this).addClass("active");

			Zepto(".paymentway").attr("checked", false);
			Zepto(".paymentway").prop("checked", false);
			Zepto("#" + paymentway).attr("checked", true);
			Zepto("#" + paymentway).prop("checked", true);
			if (paymentway == "wxsmk")
			{
				Zepto("#wxsmk_cardno_div").css("display", "");
				Zepto("#wxsmk_password_div").css("display", "");
			}
			else
			{
				Zepto("#wxsmk_cardno_div").css("display", "none");
				Zepto("#wxsmk_password_div").css("display", "none");
			}
		});

		mui(\'#paymentmodegroup\').on(\'change\', \'input\', function ()
		{
			if (Zepto(\'#type\').val() == \'submit\') return;
			var paymentway = Zepto(this).val();
			if (paymentway == "1")
			{
				Zepto("#paymentgroup").css("display", "");
				Zepto("#payment_button").html(\'确定支付\');
				Zepto("#payment_title").html(\'确认支付\');
				Zepto("#payment_icon").removeClass("icon-queren01");
				Zepto("#payment_icon").addClass("icon-feiyongshuomingicon");
			}
			else
			{
				Zepto("#paymentgroup").css("display", "none");
				Zepto("#payment_button").html(\'确定下单\');
				Zepto("#payment_title").html(\'确认下单\');
				Zepto("#payment_icon").removeClass("icon-feiyongshuomingicon");
				Zepto("#payment_icon").addClass("icon-queren01");
			}
		});
		mui(\'.mui-bar\').on(\'tap\', \'a.confirmpayment\', function (e)
		{
			if (Zepto(\'#type\').val() == \'submit\') return;
			confirmpayment_new();
		});
		mui(\'.mui-table-view-cell\').on(\'change\', \'input#usemoney\', function (e)
		{
			onusemoneychange();
		});
//        旧版触发事件
		/*mui(\'#vipcards\').on(\'tap\', \'a\', function ()
		{
			var a = this, parent;
			//根据点击按钮，反推当前是哪个actionsheet
			for (parent = a.parentNode; parent != document.body; parent = parent.parentNode.parentNode.parentNode)
			{
				if (parent.classList.contains(\'mui-popover-action\'))
				{
					break;
				}
			}
			//关闭actionsheet
			mui(\'#\' + parent.id).popover(\'toggle\');

			var usageid = Zepto(this).attr("data-id");
			var amount  = Zepto(this).attr("data-amount");
			Zepto(\'#vipcardusageid\').val(usageid);
			Zepto(\'#vipcardusageamount\').val(amount);
		  //Zepto(\'#vipcard_msg\').html(a.innerHTML);
			//~根据优惠券类型判断取￥还是折
			Zepto(\'#vipcard_msg\').html(mui(\'#myamount_add\')[0].innerHTML+mui(\'#myamount\')[0].innerHTML+\'【\'+mui(\'#myorderamount\')[0].innerHTML+\',\'+mui(\'#mytimelimit\')[0].innerHTML+\'】\');
			onusemoneychange();
		})*/
//		新版触发事件
		mui(\'#vipcards\').on(\'tap\', \'#ticketconfirm\', function ()
		{
			//关闭actionsheet
			mui(\'#vipcards\').popover(\'toggle\');
			var usetickets=Zepto(".useticket");
			var used=0;
			for( var i=0;i<usetickets.length;i++){
				if(usetickets[i].checked){
					used=1;
					var parent=usetickets[i].parentNode;
					var usageid = Zepto(parent).attr("data-id");
					var amount  = Zepto(parent).attr("data-amount");
					Zepto(\'#vipcardusageid\').val(usageid);
					Zepto(\'#vipcardusageamount\').val(amount);
					Zepto(\'#vipcard_msg\').html(Zepto(parent).attr("data-name"));
					onusemoneychange();
				}
			}
			if(used==0){
				Zepto(\'#vipcardusageid\').val(\'\');
				Zepto(\'#vipcardusageamount\').val(\'\');
				Zepto(\'#vipcard_msg\').html(\'本次不使用卡券\');
				onusemoneychange();
			}


		})
	});

	function onusemoneychange()
	{
		if(Zepto(\'#usemoney\').is(":checked"))
//		if (Zepto(\'#usemoney\').prop(\'checked\'))
		{
			var totalprice         = Zepto("#totalprice").val();
			var money              = Zepto("#money").val();
			var vipcardusageamount = Zepto("#vipcardusageamount").val();
			var moneypaymentrate   = Zepto("#moneypaymentrate").val();
			var allmoney           = Zepto("#allmoney").val();
			var totle_money 	   = Zepto("#totle_money").val();
			var smk_use 		   = Zepto(\'#smk_use\').val();

			var newtotalprice       = parseFloat(totalprice, 10);
			var newmoney            = parseFloat(money, 10);
			var newallmoney         = parseFloat(allmoney, 10);
			var newmoneypaymentrate = parseFloat(moneypaymentrate, 10);
			var newtotle_money 		= parseFloat(totle_money, 10);

			var newvipcardusageamount;
			if (vipcardusageamount == "")
			{
				newvipcardusageamount = 0;
			}
			else
			{
				newvipcardusageamount = parseFloat(vipcardusageamount, 10);
			}
			Zepto("#discount").html(newvipcardusageamount.toFixed(2));
			if (newmoneypaymentrate == 100)
			{
				if (smk_use == "1")
				{
					if ((newmoney + newvipcardusageamount + newtotle_money) >= newtotalprice)
					{
						Zepto("#needpayment").html(\'0.00\');
						Zepto("#needpayable").val(\'0\');
						Zepto("#paymentwaygroup").css("display", "none");
						Zepto("#wxsmk_cardno_div").css("display", "none");
						Zepto("#wxsmk_password_div").css("display", "none");
					}
					else
					{
						var needpayment = newtotalprice - newmoney - newvipcardusageamount - newtotle_money;
						Zepto("#needpayable").val(needpayment);
						Zepto("#needpayment").html(needpayment.toFixed(2));
						Zepto("#paymentwaygroup").css("display", "");
					}
				}
				else
				{
					if ((newmoney + newvipcardusageamount) >= newtotalprice)
					{
						Zepto("#needpayment").html(\'0.00\');
						Zepto("#needpayable").val(\'0\');
						Zepto("#paymentwaygroup").css("display", "none");
						Zepto("#wxsmk_cardno_div").css("display", "none");
						Zepto("#wxsmk_password_div").css("display", "none");
					}
					else
					{
						var needpayment = newtotalprice - newmoney - newvipcardusageamount;
						Zepto("#needpayable").val(needpayment);
						Zepto("#needpayment").html(needpayment.toFixed(2));
						Zepto("#paymentwaygroup").css("display", "");
					}
				}

			}
			else
			{
				var needpayment = newtotalprice - newvipcardusageamount;
				var allowmoney  = needpayment - newtotalprice * (100 - newmoneypaymentrate) / 100;
				if (newallmoney > allowmoney)
				{
					var remain = needpayment - allowmoney;
					Zepto("#allowmoney").html(\'￥\' + allowmoney.toFixed(2));
					Zepto("#money").val(\'￥\' + allowmoney.toFixed(2));
					Zepto("#needpayable").val(remain);
					Zepto("#needpayment").html(remain.toFixed(2));
				}
				else
				{
					var remain = needpayment - newallmoney;
					Zepto("#allowmoney").html(\'￥\' + newallmoney.toFixed(2));
					Zepto("#money").val(\'￥\' + newallmoney.toFixed(2));
					Zepto("#needpayable").val(remain);
					Zepto("#needpayment").html(remain.toFixed(2));
				}
				Zepto("#paymentwaygroup").css("display", "");
			}

		}
		else
		{
			var totalprice         = Zepto("#totalprice").val();
			var newtotalprice      = parseFloat(totalprice, 10);
			var vipcardusageamount = Zepto("#vipcardusageamount").val();

			var totle_money 	   = Zepto("#totle_money").val();
			var smk_use 		   = Zepto(\'#smk_use\').val();
			var newtotle_money 		= parseFloat(totle_money, 10);

			var newvipcardusageamount;
			if (vipcardusageamount == "")
			{
				newvipcardusageamount = 0;
			}
			else
			{
				newvipcardusageamount = parseFloat(vipcardusageamount, 10);
			}

			Zepto("#discount").html(newvipcardusageamount.toFixed(2));

			if (smk_use == "1")
			{

				var needpayment = newtotalprice - newvipcardusageamount - newtotle_money;

				if (needpayment <= 0)
				{
					Zepto("#needpayment").html(\'0.00\');
					Zepto("#needpayable").val(\'0\');
					Zepto("#paymentwaygroup").css("display", "none");
					Zepto("#wxsmk_cardno_div").css("display", "none");
					Zepto("#wxsmk_password_div").css("display", "none");
				}
				else
				{
					Zepto("#needpayable").val(needpayment);
					Zepto("#needpayment").html(needpayment.toFixed(2));
					Zepto("#paymentwaygroup").css("display", "");
				}
			}
			else
			{
				if (newtotalprice == newvipcardusageamount)
				{
					var needpayment = newtotalprice - newvipcardusageamount;
					Zepto("#needpayable").val(needpayment);
					Zepto("#needpayment").html(needpayment.toFixed(2));
					Zepto("#paymentwaygroup").css("display", "none");
					Zepto("#wxsmk_cardno_div").css("display", "none");
					Zepto("#wxsmk_password_div").css("display", "none");
				}
				else
				{
					var needpayment = newtotalprice - newvipcardusageamount;
					Zepto("#needpayable").val(needpayment);
					Zepto("#needpayment").html(needpayment.toFixed(2));
					Zepto("#paymentwaygroup").css("display", "");
				}

			}

		}
	}
//zl修改函数名
	function confirmpayment_new()
	{
		var paymentway = "";
		Zepto(\'input[name=paymentway]\').each(function (index)
		{
			if (Zepto(this).attr("checked") == "true")
			{
				paymentway = Zepto(this).val();
			}
		});

		var needpayable = Zepto(\'#needpayable\').val();

		if (paymentway == "" && parseFloat(needpayable, 10) > 0)
		{
			mui.toast("请选择支付方式！");
			return;
		}
		if (paymentway == "wxsmk" && parseFloat(needpayable, 10) > 0)
		{
			var wxsmk_cardno     = Zepto(\'#wxsmk_cardno\').val();
			var wxsmk_password = Zepto(\'#wxsmk_password\').val();
			if (wxsmk_cardno == "")
			{
				mui.toast("请选择输入市民卡卡号！");
				return;
			}
			if (wxsmk_password == "")
			{
				mui.toast("请选择输入市民卡密码！");
				return;
			}
		}

		var vipcardusageid     = Zepto(\'#vipcardusageid\').val();
		var vipcardusageamount = Zepto(\'#vipcardusageamount\').val();

		Zepto(\'input[name=paymentway]\').prop("disabled", \'disabled\');
		Zepto(\'#type\').val(\'submit\');

		var orderid  = Zepto(\'#orderid\').val();
		var usemoney = \'0\';
		if(Zepto(\'#usemoney\').is(":checked"))
		{
			usemoney = \'1\';
		}

		Zepto(\'#usemoney\').prop("disabled", \'disabled\');
		Zepto(\'#mycheckboxchoice\').prop("disabled", \'disabled\');

		Zepto("#payment_button").html(\'正在提交,请等待!\');
		Zepto("#payment_icon").removeClass("icon-qian");
		Zepto("#payment_icon").addClass("icon-loading");
		Zepto("#payment_icon").addClass("mui-rotation");
		Zepto("#confirmpayment").removeClass("confirmpayment_new");
		if(returnbackatcion != ""){
			Zepto("#mui-action-back").removeAttr("href");
		}else
		{
			Zepto("#mui-action-back").removeClass("mui-action-back");
		}

		var totle_money 	   = Zepto("#totle_money").val();
		var smk_use 		   = Zepto(\'#smk_use\').val();

		var postbody = \'orderid=\' + orderid + \'&paymentway=\' + paymentway + \'&usemoney=\' + usemoney + \'&needpayable=\' + needpayable + \'&vipcardusageid=\' + vipcardusageid + \'&vipcardusageamount=\' + vipcardusageamount + \'&smk_use=\' + smk_use + \'&totle_money=\' + totle_money;
		if (paymentway == "wxsmk")
		{
			postbody += \'&wxsmk_cardno=\' + wxsmk_cardno + \'&wxsmk_password=\' + wxsmk_password;
		}

		mui.ajax({
			type: \'POST\',
			url: "saveorder.php",
			data: postbody,
			success: function (json)
			{
				//alert(json);
				var jsondata = eval("(" + json + ")");
				if (jsondata.code == 200)
				{

					if (jsondata.paymentway == \'weixin\')
					{
						var orderid          = Zepto(\'#orderid\').val();
						mui.ajax({
							type: \'POST\',
							url: "QRCode.ajax.php",
							data:\'orderid=\'+orderid,
							success: function(json) {
								if(json == 200){
									callpay(jsondata.json);
								}
							}
						});
					}
					else if (jsondata.paymentway == \'tzb\')
					{
						var orderid          = Zepto(\'#orderid\').val();
						mui.ajax({
							type: \'POST\',
							url: "QRCode.ajax.php",
							data:\'orderid=\'+orderid,
							success: function(json) {
								if(json == 200){
								window.location.href = \'completepayment.php?record=\' + orderid;
								}
							}
						});
					}
					else if (jsondata.paymentway == \'official\')
					{
						var orderid          = Zepto(\'#orderid\').val();
						mui.ajax({
							type: \'POST\',
							url: "QRCode.ajax.php",
							data:\'orderid=\'+orderid,
							success: function(json) {
								if(json == 200){
								window.location.href = \'completepayment.php?record=\' + orderid;
								}
							}
						});
					}
					else if (jsondata.paymentway == \'wxsmk\')
					{
						var orderid          = Zepto(\'#orderid\').val();
//								 市民卡密码为888888时提示
//								 判断市民卡密码是否是888888，如果是
//								 mui.alert("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;您本次使用的密码为初始密码，为保证账户安全，您可以携带含联机账户的市民卡及本人身份证前往网点更改密码！"," ","朕知道了",function(){
//									 mui.toast();
//								 });
						mui.ajax({
							type: \'POST\',
							url: "QRCode.ajax.php",
							data:\'orderid=\'+orderid,
							success: function(json) {
								if(json == 200){
								window.location.href = \'completepayment.php?record=\' + orderid;
								}
							}
						});
					}
					else if (jsondata.paymentway == \'vipcard\')
					{
						var orderid          = Zepto(\'#orderid\').val();
						mui.ajax({
							type: \'POST\',
							url: "QRCode.ajax.php",
							data:\'orderid=\'+orderid,
							success: function(json) {
								if(json == 200){
								window.location.href = \'completepayment.php?record=\' + orderid;
								}
							}
						});
					}
					else
					{
						mui.toast(\'支付失败\');
						setTimeout("back_confirmpayment();", 1500);
					}

				}
				else
				{
					mui.toast(jsondata.msg);
					setTimeout("back_confirmpayment();", 1500);
				}
			}
		});
	}

	function back_confirmpayment()
	{
		Zepto(\'input[name=paymentway]\').prop("disabled", \'\');
		Zepto(\'#type\').val(\'\');
		Zepto(\'#usemoney\').prop("disabled", \'\');
		Zepto(\'#mycheckboxchoice\').prop("disabled", \'\');

		Zepto("#payment_button").html(\'确定支付\');

		Zepto("#payment_icon").removeClass("icon-loading");
		Zepto("#payment_icon").removeClass("mui-rotation");

		Zepto("#payment_icon").addClass("icon-qian");

		Zepto("#confirmpayment").addClass("confirmpayment_new");
		if(returnbackatcion != ""){
			Zepto("#mui-action-back").attr("href",returnbackatcion);
		}else
		{
			Zepto("#mui-action-back").addClass("mui-action-back");
		}
	}
	function jsApiCall(jsondata)
	{
		WeixinJSBridge.invoke(
				\'getBrandWCPayRequest\',
				jsondata,
				function (res)
				{
					//WeixinJSBridge.log(res.err_msg);
					//alert(res.err_code+res.err_desc+res.err_msg);
					if (res.err_msg == "get_brand_wcpay_request:cancel")
					{
						mui.toast("您的支付已经取消！");
						setTimeout("back_confirmpayment();", 1500);
					}
					else if (res.err_msg == "get_brand_wcpay_request:ok")
					{
						var orderid          = Zepto(\'#orderid\').val();
						mui.ajax({
							type: \'POST\',
							url: "QRCode.ajax.php",
							data:\'orderid=\'+orderid,
							success: function(json) {
								if(json == 200){
									window.location.href = \'completepayment.php?record=\' + orderid;
								}
							}
						});
					}
					else if (res.err_msg == "get_brand_wcpay_request:fail")
					{
						mui.toast("支付失败！");
						setTimeout("back_confirmpayment();", 1500);
					}
					else
					{
						mui.toast(res.err_msg);
						setTimeout("back_confirmpayment();", 1500);
					}
				}
		);
	}

	function callpay(jsondata)
	{
		if (typeof WeixinJSBridge == "undefined")
		{
			if (document.addEventListener)
			{
				document.addEventListener(\'WeixinJSBridgeReady\', jsApiCall, false);
			}
			else if (document.attachEvent)
			{
				document.attachEvent(\'WeixinJSBridgeReady\', jsApiCall);
				document.attachEvent(\'onWeixinJSBridgeReady\', jsApiCall);
			}
		}
		else
		{
			jsApiCall(jsondata);
		}
	}
	mui(\'body\').on(\'change\',\'#mycheckboxchoice\',function(e){
		var mychoice=mui("#mycheckboxchoice")[0];
		if(mychoice.checked) {
			$(\'#smk_use\').val(\'1\');
			onusemoneychange();
		}else{
			$(\'#smk_use\').val(\'0\');
			onusemoneychange();
		}
	});
	mui(\'.mui-scroll\').on(\'tap\',\'a\',function(e){
		mui.openWindow({
			url: this.getAttribute(\'href\'),
			id: \'info\'
		});
	});
	/**
	 * 保留两位小数
	 * @param number
	 * @returns {number}
     */
	function changeTwoDecimal_f(x) {
		var f_x = parseFloat(x);
		if (isNaN(f_x)) {
			return false;
		}
		var f_x = Math.round(x * 100) / 100;
		var s_x = f_x.toString();
		var pos_decimal = s_x.indexOf(\'.\');
		if (pos_decimal < 0) {
			pos_decimal = s_x.length;
			s_x += \'.\';
		}
		while (s_x.length <= pos_decimal + 2) {
			s_x += \'0\';
		}
		return s_x;
	}
	setTimeout(function () { onusemoneychange();  }, 100);
	'; ?>

</script>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'weixin.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script src="/public/js/baidu.js?_=20140822" type="text/javascript"></script>
</body>
</html>
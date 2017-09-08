<?php /* Smarty version 2.6.18, created on 2017-08-15 10:07:59
         compiled from shoppingcart.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'shoppingcart.tpl', 143, false),array('modifier', 'floatval', 'shoppingcart.tpl', 205, false),array('modifier', 'intval', 'shoppingcart.tpl', 205, false),array('modifier', 'string_format', 'shoppingcart.tpl', 208, false),)), $this); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
	<title></title>
	<link href="public/css/mui.css" rel="stylesheet"/>
	<link href="public/css/public.css" rel="stylesheet"/>
	<link href="public/css/iconfont.css" rel="stylesheet"/>
	<link href="public/css/sweetalert.css" rel="stylesheet"/>
	<script src="public/js/mui.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="public/js/zepto.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="public/js/common.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript" src="public/js/sweetalert.min.js"></script>
	<script type="text/javascript" src="public/js/jweixin.js"></script>
	<style>
		<?php echo '
		.img-responsive {
			display: block;
			height: auto;
			width: 100%;
		}

		.menuicon {
			font-size: 1.4em;
			color: #fe4401;
			padding-right: 10px;
		}

		.menuitem a {
			font-size: 1.3em;
		}

		.mui-checkbox.mui-left label {
			padding-right: 3px;
			padding-left: 35px;
		}

		.mui-checkbox.mui-left input[type=\'checkbox\'] {
			left: 3px;
		}

		.mui-table-view .mui-media-object {
			line-height: 100px;
			max-width: 100px;
			height: 100px;
		}

		.mui-input-row {
			margin: 2px;
		}

		.mui-input-group .mui-input-row:after {
			left: 0px;
		}

		.mui-input-row .mui-numbox {
			float: left;
			margin: 2px 2px;
		}

		.mui-numbox {
			width: 120px;
			height: 30px;
			padding: 0 40px 0 40px;
		}

		.mui-card .mui-ellipsis {
			margin-bottom: 0px;
		}

		.tishi {
			color: #fe4401;
			width: 100%;
			text-align: center;
			padding-top: 10px;
		}

		.tishi .mui-icon {
			font-size: 4.4em;
		}

		.msgbody {
			width: 100%;
			font-size: 1.4em;
			line-height: 25px;
			color: #333;
			text-align: center;
			padding-top: 10px;
		}

		.msgbody a {
			font-size: 1.0em;
		}

		.mui-bar-tab .mui-tab-item .mui-icon {
			width: auto;
		}

		.mui-bar-tab .mui-tab-item, .mui-bar-tab .mui-tab-item.mui-active {
			color: #cc3300;
		}

		.mui-ellipsis {
			line-height: 17px;
		}

		.price {
			color: #fe4401;
		}

		.deleteshoppingcart {
			color: #cc3300;
			font-size: 1.1em;
		}

		.deleteshoppingcart span {
			font-size: 1.1em;
		}
		header.mui-bar{
			background: #f9f9f9;
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
			<h1 class="mui-title">购物车</h1>
		</header>
		<nav class="mui-bar mui-bar-tab" style="height:40px;line-height:40px;">
			<div class="mui-tab-item" style="width:70%;color:#929292;">
				<input value="<?php echo $this->_tpl_vars['supplier_info']['totalpricefreeshipping']; ?>
" id="totalpricefreeshipping" type="hidden"/>
				<input value="<?php echo $this->_tpl_vars['supplier_info']['totalquantityfreeshipping']; ?>
" id="totalquantityfreeshipping" type="hidden"/>
				<span class="mui-tab-label">
					<div id="allselect_div" class="mui-input-row mui-checkbox mui-left mui-pull-left" style="width:60px">
						<label>全选</label>
						<input id="allselect" name="allselect" <?php if (count($this->_tpl_vars['shoppingcarts']) > 0): ?> checked<?php endif; ?> value="1" type="checkbox">
					</div>
					<div class="mui-pull-right" style="line-height: 20px;text-align: left;">
						合计：<span class="price" id="total_money">¥<?php echo $this->_tpl_vars['total_money']; ?>
</span>元<br>
						共计&nbsp;<span class="price" id="total_quantity"><?php echo $this->_tpl_vars['total_quantity']; ?>
</span>&nbsp;件商品
					</div>
				</span>
			</div>
			<a class="mui-tab-item confirmpayment" href="#" style="width:30%">
				<span class="mui-icon iconfont icon-feiyongshuomingicon button-color">&nbsp;结算</span>
			</a>
		</nav>

		<div id="pullrefresh" class="mui-content mui-scroll-wrapper" style="padding-top: 50px;bottom: 50px;">
			<div class="mui-scroll">
				<div class="mui-card" style="margin: 0 3px 3px;">
					<form class="mui-input-group" method="post" name="frm" action="submitorder.php">
						<input name="token" value="<?php echo $this->_tpl_vars['token']; ?>
" type="hidden">
						<ul id="shoppingcart_wrap" class="mui-table-view mui-table-view-chevron" style="color: #333;">
							<?php $_from = $this->_tpl_vars['shoppingcarts']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['shoppingcarts'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['shoppingcarts']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['shoppingcart_info']):
        $this->_foreach['shoppingcarts']['iteration']++;
?>
								<li class="mui-input-row mui-checkbox mui-left" style="min-height:100px;height: auto;"
									id="shoppingcart_wrap_<?php echo $this->_tpl_vars['shoppingcart_info']['id']; ?>
">
									<label>
										<img class="mui-media-object mui-pull-left" data-id="<?php echo $this->_tpl_vars['shoppingcart_info']['id']; ?>
" src="<?php echo $this->_tpl_vars['shoppingcart_info']['productthumbnail']; ?>
">
										<div class="mui-media-body">
											<p class='mui-ellipsis' style="color:#333"><?php echo $this->_tpl_vars['shoppingcart_info']['productname']; ?>
</p>
											<?php if ($this->_tpl_vars['shoppingcart_info']['vendorname'] != '' && $this->_tpl_vars['supplier_info']['showvendor'] == '1'): ?> 
											<p class='mui-ellipsis'>供应商：<?php echo $this->_tpl_vars['shoppingcart_info']['vendorname']; ?>
</p>
											<?php endif; ?> 
											<?php if ($this->_tpl_vars['shoppingcart_info']['propertydesc'] != ''): ?>
												<p class='mui-ellipsis'>属性：<?php echo $this->_tpl_vars['shoppingcart_info']['propertydesc']; ?>
</p>
											<?php endif; ?>
											<div class='mui-ellipsis' style="width:200px">
												<div class="mui-numbox" data-numbox-step='1' data-numbox-min='1' data-numbox-max='<?php if ($this->_tpl_vars['shoppingcart_info']['activitymode'] == '1'): ?>1<?php else: ?>99<?php endif; ?>'>
													<button class="mui-btn mui-numbox-btn-minus" type="button" data-id="<?php echo $this->_tpl_vars['shoppingcart_info']['id']; ?>
">-</button>
													<input value="<?php echo $this->_tpl_vars['shoppingcart_info']['productid']; ?>
" id="productid_<?php echo $this->_tpl_vars['shoppingcart_info']['id']; ?>
" type="hidden"/>
													<input value="<?php echo $this->_tpl_vars['shoppingcart_info']['shop_price']; ?>
" id="shop_price_<?php echo $this->_tpl_vars['shoppingcart_info']['id']; ?>
" type="hidden"/>
													<input value="<?php echo $this->_tpl_vars['shoppingcart_info']['old_shop_price']; ?>
" id="old_shop_price_<?php echo $this->_tpl_vars['shoppingcart_info']['id']; ?>
" type="hidden"/>
													<input value="<?php echo $this->_tpl_vars['shoppingcart_info']['postage']; ?>
" id="postage_<?php echo $this->_tpl_vars['shoppingcart_info']['id']; ?>
" type="hidden"/>
													<input value="<?php echo $this->_tpl_vars['shoppingcart_info']['includepost']; ?>
" id="includepost_<?php echo $this->_tpl_vars['shoppingcart_info']['id']; ?>
" type="hidden"/>
													<input value="<?php echo $this->_tpl_vars['shoppingcart_info']['mergepostage']; ?>
" id="mergepostage_<?php echo $this->_tpl_vars['shoppingcart_info']['id']; ?>
" type="hidden"/>
													<input value="<?php echo $this->_tpl_vars['shoppingcart_info']['zhekou']; ?>
" id="zhekou_<?php echo $this->_tpl_vars['shoppingcart_info']['id']; ?>
" type="hidden"/>
													<input value="<?php echo $this->_tpl_vars['shoppingcart_info']['bargains_count']; ?>
" id="bargains_count_<?php echo $this->_tpl_vars['shoppingcart_info']['id']; ?>
" type="hidden"/>
													<input value="<?php echo $this->_tpl_vars['shoppingcart_info']['activitymode']; ?>
" id="activitymode_<?php echo $this->_tpl_vars['shoppingcart_info']['id']; ?>
" type="hidden"/>
													<input value="<?php echo $this->_tpl_vars['shoppingcart_info']['bargainrequirednumber']; ?>
" id="bargainrequirednumber_<?php echo $this->_tpl_vars['shoppingcart_info']['id']; ?>
" type="hidden"/>
													<input readonly data-id="<?php echo $this->_tpl_vars['shoppingcart_info']['id']; ?>
" value="<?php echo $this->_tpl_vars['shoppingcart_info']['quantity']; ?>
"
														   id="qty_item_<?php echo $this->_tpl_vars['shoppingcart_info']['id']; ?>
" name="qty_item_<?php echo $this->_tpl_vars['shoppingcart_info']['id']; ?>
"
														   class="mui-numbox-input" type="number"/>
													<button class="mui-btn mui-numbox-btn-plus" type="button" data-id="<?php echo $this->_tpl_vars['shoppingcart_info']['id']; ?>
">+</button>
												</div>

											</div>
											<p class='mui-ellipsis'><?php if ($this->_tpl_vars['shoppingcart_info']['zhekou'] != ''): ?><?php if ($this->_tpl_vars['shoppingcart_info']['activitymode'] == '1'): ?>底价<?php else: ?>活动价<?php endif; ?>：
													<span class="price">¥<?php echo $this->_tpl_vars['shoppingcart_info']['shop_price']; ?>
</span>
													<span style="color:#878787;margin-left:5px;text-decoration:line-through;">
													¥<?php echo $this->_tpl_vars['shoppingcart_info']['old_shop_price']; ?>
</span><?php else: ?>单价：<span class="price">
													¥<?php echo $this->_tpl_vars['shoppingcart_info']['shop_price']; ?>
</span><?php endif; ?></p>
											<?php if ($this->_tpl_vars['shoppingcart_info']['activitymode'] == '1'): ?>
												<p class='mui-ellipsis'>
													砍价：<?php if ($this->_tpl_vars['shoppingcart_info']['bargains_count'] == 0): ?>还没有好友帮忙砍价<?php else: ?>已有 <?php echo $this->_tpl_vars['shoppingcart_info']['bargains_count']; ?>
 位好友帮忙砍价<?php endif; ?>
												</p>
											<?php endif; ?>
											<p id="postage_panel_<?php echo $this->_tpl_vars['shoppingcart_info']['id']; ?>
" class='mui-ellipsis' style="display: <?php if (floatval($this->_tpl_vars['shoppingcart_info']['postage']) > 0 && ( intval($this->_tpl_vars['shoppingcart_info']['includepost']) == 0 || intval($this->_tpl_vars['shoppingcart_info']['includepost']) > intval($this->_tpl_vars['shoppingcart_info']['productallcount']) ) && ( floatval($this->_tpl_vars['supplier_info']['totalpricefreeshipping']) == 0 || floatval($this->_tpl_vars['supplier_info']['totalpricefreeshipping']) > $this->_tpl_vars['total_money'] ) && ( intval($this->_tpl_vars['supplier_info']['totalquantityfreeshipping']) == 0 || intval($this->_tpl_vars['supplier_info']['totalquantityfreeshipping']) > $this->_tpl_vars['total_quantity'] )): ?>block<?php else: ?>none<?php endif; ?>;">
												邮费：
												<span id="postage_span_<?php echo $this->_tpl_vars['shoppingcart_info']['id']; ?>
" class="price">
													¥<?php if (intval($this->_tpl_vars['shoppingcart_info']['mergepostage']) == 1): ?><?php echo $this->_tpl_vars['shoppingcart_info']['postage']; ?>
<?php else: ?><?php echo ((is_array($_tmp=$this->_tpl_vars['shoppingcart_info']['postage']*$this->_tpl_vars['shoppingcart_info']['quantity'])) ? $this->_run_mod_handler('string_format', true, $_tmp, "%0.2f") : smarty_modifier_string_format($_tmp, "%0.2f")); ?>
<?php endif; ?>
												</span>
																								<?php if (intval($this->_tpl_vars['shoppingcart_info']['includepost']) > 0): ?>
													<span style="color:#878787;margin-left:10px;">(<?php echo $this->_tpl_vars['shoppingcart_info']['includepost']; ?>

																								  件包邮)</span>
												<?php endif; ?>
											</p>
											<p class='mui-ellipsis'>小计：<span id="total_price_<?php echo $this->_tpl_vars['shoppingcart_info']['id']; ?>
"
																			 class="price">¥<?php echo $this->_tpl_vars['shoppingcart_info']['total_price']; ?>
</span>
												<a class="deleteshoppingcart mui-pull-right button-color" data-id="<?php echo $this->_tpl_vars['shoppingcart_info']['id']; ?>
"
												   href="javascript:;"><span class="mui-icon iconfont icon-shanchu"></span>删除</a>
											</p>
										</div>
									</label>
									<input name="shoppingcart[]" value="<?php echo $this->_tpl_vars['shoppingcart_info']['id']; ?>
" id="shoppingcart_<?php echo $this->_tpl_vars['shoppingcart_info']['id']; ?>
"
										   checked type="checkbox" style="margin-top:45px;">
								</li>
								<?php endforeach; else: ?>
								<div class="mui-content-padded">
									<p class="tishi"><span class="mui-icon iconfont icon-tishi"></span></p>
									<p class="msgbody">您的购物车还是空的，快去选购商品吧<br>
										<a href="index.php">>>>&nbsp;去逛逛</a>
									</p>
								</div>
							<?php endif; unset($_from); ?>
						</ul>
					</form>
				</div>
			</div>
		</div>
		<nav class="mui-bar mui-bar-tab" style="height:40px;line-height:40px;bottom: 50px;">
			<ul class="mui-table-view" style="background-color: #efeff4;">
				<li class="mui-table-view-cell mui-media">
					<img class="img-responsive" src="/images/baozhang.png">
				</li>
			</ul>
		</nav>
	</div>
</div>
<script>
	var idlists = <?php echo $this->_tpl_vars['idlists']; ?>
;
	var errmsg = "<?php echo $this->_tpl_vars['errorMsg']; ?>
";
	<?php echo '
	mui.init({
				 pullRefresh: {
					 container: \'#pullrefresh\'
				 },
			 });

	mui.ready(function ()
			  {
				  mui(\'#pullrefresh\').scroll();

				  if (errmsg != "")
				  {
					  swal("", errmsg.replace(/<br>/g, "\\n"), "warning");
				  }

				  mui(\'.msgbody\').on(\'tap\', \'a\', function (e)
				  {
					  mui.openWindow({
										 url: this.getAttribute(\'href\'),
										 id: \'info\'
									 });
				  });

				  mui(\'.mui-bar\').on(\'tap\', \'div#allselect_div\', function (e)
				  {
					  setTimeout("allselect();", 50);
				  });
				  mui(\'.mui-bar\').on(\'tap\', \'a.confirmpayment\', function (e)
				  {
					  var total_quantity = Zepto("#total_quantity").html();
					  if (parseInt(total_quantity, 10) > 0)
					  {
						  document.frm.submit();
					  }
					  else
					  {
						  mui.toast("购物车没有需要结算的商品！");
					  }
				  });

				  mui(\'.mui-table-view\').on(\'tap\', \'input[type=checkbox]\', function (e)
				  {
					  setTimeout("recalc();", 50);
				  });

				  mui(\'.mui-table-view\').on(\'tap\', \'img.mui-media-object\', function (e)
				  {
					  var shoppingcartid = this.getAttribute(\'data-id\');
					  Zepto("#shoppingcart_" + shoppingcartid).attr("checked", !Zepto("#shoppingcart_" + shoppingcartid).attr("checked"));
					  Zepto("#shoppingcart_" + shoppingcartid).prop("checked", !Zepto("#shoppingcart_" + shoppingcartid).prop("checked"));
					  setTimeout("recalc();", 50);
				  });

				  mui(\'.mui-table-view\').on(\'change\', \'input[type=number]\', function ()
				  {
					  setTimeout("recalc();", 50);
					  var shoppingcartid = this.getAttribute(\'data-id\');
					  var qty_item       = Zepto("#qty_item_" + shoppingcartid).val();
					  productqty_change(shoppingcartid);
					  mui.ajax({
								   type: \'POST\',
								   url: "shoppingcart_update.ajax.php",
								   data: \'record=\' + shoppingcartid + \'&qty_item=\' + qty_item,
								   success: function (json)
								   {
								   }
							   });
				  });

				  mui(\'.mui-table-view\').on(\'tap\', \'a.deleteshoppingcart\', function (e)
				  {
					  var shoppingcartid = this.getAttribute(\'data-id\');
					  swal({
							   title: "提示",
							   text: "您确定需要删除商品吗？",
							   type: "warning",
							   showCancelButton: true,
							   closeOnConfirm: true,
							   confirmButtonText: "删除",
							   confirmButtonColor: "#ec6c62"
						   }, function ()
						   {
							   Zepto("#shoppingcart_wrap_" + shoppingcartid).remove();
							   mui.ajax({
											type: \'POST\',
											url: "shoppingcart_delete.ajax.php",
											data: \'record=\' + shoppingcartid,
											success: function (json)
											{
												Zepto.each(idlists, function (i, v)
												{
													if (v === shoppingcartid)
													{
														idlists.splice(i, 1);
													}
												});
												recalc();
												if (Zepto("#shoppingcart_wrap").children().size() <= 0)
												{
													Zepto("#shoppingcart_wrap").html(\'<div class="mui-content-padded">\' +
																					 \'<p class="tishi"><span class="mui-icon iconfont icon-tishi"></span></p>\' +
																					 \'<p class="msgbody">您的购物车还是空的，快去选购商品吧<br>\' +
																					 \'<a href="index.php">>>>&nbsp;去逛逛</a></p></div>\');
												}
											}
										});
						   });
				  });
			  });
	function productqty_change(shoppingcartid){
		var qty_item       = Zepto("#qty_item_" + shoppingcartid).val();
		var pice           = Zepto("#shop_price_" + shoppingcartid).val();
		var includepost    = Zepto("#includepost_" + shoppingcartid).val();
		var postage        = Zepto("#postage_" + shoppingcartid).val();
		var mergepostage   = Zepto("#mergepostage_" + shoppingcartid).val();
		var old_pice       = Zepto("#old_shop_price_" + shoppingcartid).val();
		var zhekou         = Zepto("#zhekou_" + shoppingcartid).val();
		var bargains       = Zepto("#bargains_count_" + shoppingcartid).val();
		var activitymode   = Zepto("#activitymode_" + shoppingcartid).val();
		var bargainsnumber = Zepto("#bargainrequirednumber_" + shoppingcartid).val();

		var total_price    = parseFloat(pice, 10) * parseInt(qty_item, 10);
		if(zhekou != "" && parseInt(activitymode,10) == \'1\'){
			total_price = parseFloat(old_pice,10) - parseFloat(old_pice,10) * (10 - parseFloat(zhekou,10)) / 10 / parseInt(bargainsnumber,10) * parseInt(bargains,10);
		}
		var totalpricefreeshipping = Zepto("#totalpricefreeshipping").val();
		var totalquantityfreeshipping = Zepto("#totalquantityfreeshipping").val();
		var productallmoney = productallselectmoney();
		var productallcount = productallselectcount();
		if((parseFloat(totalpricefreeshipping,10) <= 0 || parseFloat(totalpricefreeshipping,10) > productallmoney) && (parseInt(totalquantityfreeshipping,10) <= 0 || parseInt(totalquantityfreeshipping,10) > productallcount))
		{
			if (parseFloat(postage, 10) > 0)
			{
				if (parseInt(mergepostage, 10) != 1)
				{
					postage = parseFloat(postage, 10) * parseInt(qty_item, 10);
				}
				Zepto("#postage_span_" + shoppingcartid).html(\'¥\' + parseFloat(postage, 10).toFixed(2));
				var pct = productcount(Zepto("#productid_" + shoppingcartid).val());
				if (parseInt(includepost, 10) > 0 && parseInt(includepost, 10) <= pct)
				{
					Zepto("#postage_panel_" + shoppingcartid).css(\'display\', \'none;\');
				}
				else
				{
					Zepto("#postage_panel_" + shoppingcartid).css(\'display\', \'block;\');
					total_price = parseFloat(total_price, 10) + parseFloat(postage, 10);
				}
			}
		}else{
			Zepto("#postage_panel_" + shoppingcartid).css(\'display\', \'none;\');
		}
		Zepto("#total_price_" + shoppingcartid).html(\'¥\' + parseFloat(total_price, 10).toFixed(2));
	}
	function productcount(pid){
		var pc = 0;
		Zepto.each(idlists, function (i, v){
			var checked = Zepto("#shoppingcart_" + v).prop("checked");
			if (checked){
				var product         = Zepto("#productid_" + v).val();
				if(product == pid){
					var qty_item     = Zepto("#qty_item_" + v).val();
					pc += parseInt(qty_item, 10);
				}
			}
		});
		return pc;
	}
	function productallselectcount(){
		var pc = 0;
		Zepto.each(idlists, function (i, v){
			var checked = Zepto("#shoppingcart_" + v).prop("checked");
			if (checked){
				var qty_item = Zepto("#qty_item_" + v).val();
				pc += parseInt(qty_item, 10);
			}
		});
		return pc;
	}
	function productallselectmoney(){
		var pc = 0;
		Zepto.each(idlists, function (i, v){
			var checked = Zepto("#shoppingcart_" + v).prop("checked");
			if (checked){
				var qty_item = Zepto("#qty_item_" + v).val();
				var pice     = Zepto("#shop_price_" + v).val();
				pc += parseInt(qty_item, 10) * parseFloat(pice,10);
			}
		});
		return pc;
	}
	function recalc()
	{
		var total_money    = 0;
		var total_quantity = 0;
		var allpostage     = 0;
		var allmergepost   = 0;
		var isall          = true;
		var totalpricefreeshipping = Zepto("#totalpricefreeshipping").val();
		var totalquantityfreeshipping = Zepto("#totalquantityfreeshipping").val();
		var productallmoney = productallselectmoney();
		var productallcount = productallselectcount();
		Zepto.each(idlists, function (i, v)
		{
			productqty_change(v);
			var checked = Zepto("#shoppingcart_" + v).prop("checked");
			if (checked)
			{
				var qty_item     = Zepto("#qty_item_" + v).val();
				var pice         = Zepto("#shop_price_" + v).val();
				var includepost  = Zepto("#includepost_" + v).val();
				var postage      = Zepto("#postage_" + v).val();
				var mergepostage = Zepto("#mergepostage_" + v).val();
				var old_pice	 = Zepto("#old_shop_price_" + v).val();
				var zhekou 		 = Zepto("#zhekou_" + v).val();
				var bargains	 = Zepto("#bargains_count_" + v).val();
				var activitymode = Zepto("#activitymode_" + v).val();
				var bargainsnumber = Zepto("#bargainrequirednumber_" + v).val();

				var total_price  = parseFloat(pice, 10) * parseInt(qty_item, 10);
				if(zhekou != "" && parseInt(activitymode,10) == \'1\'){
					total_price = parseFloat(old_pice,10) - parseFloat(old_pice,10) * (10 - parseFloat(zhekou,10)) / 10 / parseInt(bargainsnumber,10) * parseInt(bargains,10);
				}
				if((parseFloat(totalpricefreeshipping,10) <= 0 || parseFloat(totalpricefreeshipping,10) > productallmoney) && (parseInt(totalquantityfreeshipping,10) <= 0 || parseInt(totalquantityfreeshipping,10) > productallcount))
				{
					if (parseFloat(postage, 10) > 0)
					{
						var pct = productcount(Zepto("#productid_" + v).val());
						if (parseInt(includepost, 10) <= 0 || parseInt(includepost, 10) > pct)
						{
							if (parseInt(mergepostage, 10) != 1)
							{
								allmergepost += parseFloat(postage, 10) * parseInt(qty_item, 10);
							}
							else if (parseFloat(postage, 10) > parseFloat(allpostage, 10))
							{
								allpostage = parseFloat(postage, 10);
							}

						}
					}
				}
				total_money += parseFloat(total_price, 10);
				total_quantity += parseInt(qty_item, 10);
			}
			else
			{
				isall = false;
			}
		});
		if(idlists.length <= 0){
			isall = false;
		}
		total_money += allpostage + allmergepost;
		Zepto("#total_money").html(\'¥\' + total_money.toFixed(2));
		Zepto("#total_quantity").html(total_quantity);
		$("#allselect").attr("checked", isall);
		$("#allselect").prop("checked", isall);
	}
	function allselect()
	{
		var checked = Zepto("#allselect").prop("checked");
		if (checked)
		{
			Zepto.each(idlists, function (i, v)
			{
				Zepto("#shoppingcart_" + v).attr("checked", true);
				Zepto("#shoppingcart_" + v).prop("checked", true);
			});
			recalc();
		}
		else
		{
			Zepto("#total_money").html("¥0.00");
			Zepto("#total_quantity").html("0");
			Zepto.each(idlists, function (i, v)
			{
				Zepto("#shoppingcart_" + v).attr("checked", null);
				Zepto("#shoppingcart_" + v).prop("checked", false);
				productqty_change(v);
			});
		}
	}
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
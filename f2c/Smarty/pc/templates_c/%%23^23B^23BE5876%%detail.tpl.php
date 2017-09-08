<?php /* Smarty version 2.6.18, created on 2017-04-12 14:13:24
         compiled from detail.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'floatval', 'detail.tpl', 82, false),array('modifier', 'intval', 'detail.tpl', 85, false),array('modifier', 'string_format', 'detail.tpl', 92, false),array('modifier', 'count', 'detail.tpl', 185, false),)), $this); ?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $this->_tpl_vars['productinfo']['productname']; ?>
</title>
<link href="/public/pc/css/pagination.css" rel="stylesheet">
<link href="/public/pc/css/bootstrap.min.css" rel="stylesheet">
<link href="/public/pc/css/public.css" rel="stylesheet">
<link href="/public/pc/css/index.css" rel="stylesheet">
<link href="public/css/iconfont.css" rel="stylesheet" />
<link href="public/css/sweetalert.css" rel="stylesheet"/>
</head>
<body>
<div id="zhezhao"></div>
<!--弹出遮罩层-->
<div class="order-alert order-alert1">
  <div class="order-alert-tit closealert"> <a href="javascript:;" class="alertclose pull-right">X</a>
    <h4>温馨提示</h4>
  </div>
  <div class="order-alert-lr font-wr">
    <h4><img src="/public/pc/images/ok.png" width="48" height="47" class="mr-10"><strong>收藏成功！</strong></h4>
    <p class="text-center"><a href="index-list.html" class="btn btn-lg btn-default btn-alert">继续购物</a><a href="person-post-collection.html" class="btn btn-lg btn-default btn-alert">去我的收藏</a></p>
  </div>
</div>
<div class="order-alert order-alert2">
  <div class="order-alert-tit closealert"> <a href="javascript:;" class="alertclose pull-right">X</a>
    <h4>温馨提示</h4>
  </div>
  <div class="order-alert-lr font-wr">
    <h4><img src="/public/pc/images/ok.png" width="48" height="47" class="mr-10"><strong>已加入购物车！</strong></h4>
    <p class="text-center"><a href="index-list.html" class="btn btn-lg btn-default btn-alert">继续购物</a><a href="order.html" class="btn btn-lg btn-default btn-alert">结算</a></p>
  </div>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'rightbar.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="warp">
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  <div class="blank20"></div>
  <div class="cont">
    <div class="container">
      <div class="break-tit">
        <p><a href="index.php">首页</a><em class="pull-left">&gt;</em><a href="search.php?categoryid=<?php echo $this->_tpl_vars['productinfo']['categorys']; ?>
" ><?php echo $this->_tpl_vars['productinfo']['categoryname']; ?>
</a><em class="pull-left">&gt;</em><span class="fw"><?php echo $this->_tpl_vars['productinfo']['productname']; ?>
</span></p>
      </div>
      <div class="poto-top clearfix">
        <div class="poto-top-l pull-left">
          <div class="poto-big border">
            <ul class="poto-big-img">
              <li class="active"><img id="productlogo" src="<?php echo $this->_tpl_vars['productinfo']['productlogo']; ?>
" width="505" height="360"></li> 
            </ul>
          </div>
          <ul class="poto-sma mt-10 clearfix">
            <li class="active"><img src="<?php echo $this->_tpl_vars['productinfo']['productlogo']; ?>
" width="105" height="75"></li> 
          </ul>
        </div>
        <!--poto-top-l-->
        <div class="poto-top-r pull-right">
          <h4 class="fw"><?php echo $this->_tpl_vars['productinfo']['productname']; ?>
</h4>
          <!--<div class="blank20"></div>-->
          <div class="poto-top-price hui f14st">
            <ul>
			 <input type="hidden" id="property_type_count" value="<?php echo $this->_tpl_vars['property_type_count']; ?>
" />
			 <input type="hidden" id="from" value="<?php echo $this->_tpl_vars['from']; ?>
" />
			 <input type="hidden" id="product_property_id" name="product_property_id" value="" />
			 <input type="hidden" id="pagenum" name="pagenum" value="<?php echo $this->_tpl_vars['pagenum']; ?>
">
			 <input type="hidden" id="scrolltop" name="scrolltop" value="<?php echo $this->_tpl_vars['scrolltop']; ?>
"> 
			 <input type="hidden" id="productid" name="productid" value="<?php echo $this->_tpl_vars['productid']; ?>
">
			 <input type="hidden" name="total_price" id="total_price1" value="<?php echo $this->_tpl_vars['productinfo']['shop_price']; ?>
" />
			 <input type="hidden" name="shop_price" id="shop_price1" value="<?php echo $this->_tpl_vars['productinfo']['shop_price']; ?>
" />
			 <input type="hidden" name="inventory" id="inventory1" value="<?php echo $this->_tpl_vars['productinfo']['inventory']; ?>
" />
			 <input type="hidden" name="zhekou" id="zhekou" value="<?php echo $this->_tpl_vars['productinfo']['zhekou']; ?>
" />
			 <input type="hidden" name="salesactivityid" id="salesactivityid" value="<?php echo $this->_tpl_vars['productinfo']['salesactivityid']; ?>
" />
			 <input type="hidden" name="salesactivity_product_id" id="salesactivity_product_id" value="<?php echo $this->_tpl_vars['productinfo']['salesactivity_product_id']; ?>
" />
			 <input type="hidden" name="type" id="type" value="<?php echo $this->_tpl_vars['type']; ?>
" />
			 <input type="hidden" id="mycollection" value="<?php echo $this->_tpl_vars['mycollections']; ?>
"> 
			 
			   <?php if ($this->_tpl_vars['productinfo']['vendorname'] != '' && $this->_tpl_vars['supplier_info']['showvendor'] == '1'): ?>
				<li><font>供应商：</font><span><?php echo $this->_tpl_vars['productinfo']['vendorname']; ?>
</span></li>
			   <?php endif; ?> 
              <li><font>市场价：</font><del class="delete arial">￥<span id="market_price"><?php echo $this->_tpl_vars['productinfo']['market_price']; ?>
</span></del></li>
              <li><font>销售价：</font><em class="f14">￥</em><span class="arial f33" id="shop_price"><?php echo $this->_tpl_vars['productinfo']['shop_price']; ?>
</span></li>
			  <li id="postage_panel"  style="display: <?php if (floatval($this->_tpl_vars['productinfo']['postage']) > 0): ?>block<?php else: ?>none<?php endif; ?>;">
					<font>邮费 : </font> 
						<em class="f14">￥</em><span id="postage_span" class="arial f33"><?php echo $this->_tpl_vars['productinfo']['postage']; ?>
</span></span>
					    <?php if (intval($this->_tpl_vars['productinfo']['includepost']) > 0): ?>
							<span style="color:#878787;margin-left:10px;">(<?php echo $this->_tpl_vars['productinfo']['includepost']; ?>
件包邮)</span>
						<?php endif; ?> 
			 </li>
			<li>
				  <font>合计 : </font> 
					  <?php if ($this->_tpl_vars['productinfo']['activityname'] != '' && $this->_tpl_vars['productinfo']['zhekoulabel'] != '' && $this->_tpl_vars['productinfo']['zhekou'] != ''): ?>
					   		<em class="f14">￥</em><span id="totalprice" class="arial f33 pricenum red"><?php echo ((is_array($_tmp=$this->_tpl_vars['productinfo']['promotional_price']+$this->_tpl_vars['productinfo']['postage'])) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.2f") : smarty_modifier_string_format($_tmp, "%.2f")); ?>
</span></span>
					  <?php else: ?>
					  	 	<em class="f14">￥</em><span id="totalprice" class="arial f33 pricenum red"><?php echo ((is_array($_tmp=$this->_tpl_vars['productinfo']['shop_price']+$this->_tpl_vars['productinfo']['postage'])) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.2f") : smarty_modifier_string_format($_tmp, "%.2f")); ?>
</span></span>
					  <?php endif; ?>  
            </li>
		    </ul>
          </div>
          <div class="poto-top-choice greey">
            <?php $_from = $this->_tpl_vars['property_type']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['propertygroup'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['propertygroup']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['property_name'] => $this->_tpl_vars['property_info']):
        $this->_foreach['propertygroup']['iteration']++;
?>
                 <dl class="clearfix choice-xx">
					<dt style="height:100%;"><?php echo $this->_tpl_vars['property_name']; ?>
 : &nbsp;&nbsp;</dt>  
                    <input type="hidden" id="propertygroup_label_<?php echo $this->_foreach['propertygroup']['iteration']; ?>
" value="<?php echo $this->_tpl_vars['property_name']; ?>
" />
                    <dd>
					    <?php $_from = $this->_tpl_vars['property_info']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['property'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['property']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['propertyid'] => $this->_tpl_vars['property']):
        $this->_foreach['property']['iteration']++;
?>
                        <a class="propertygroup propertygroup_<?php echo $this->_foreach['propertygroup']['iteration']; ?>
" groupid="<?php echo $this->_foreach['propertygroup']['iteration']; ?>
" propertyid="<?php echo $this->_tpl_vars['propertyid']; ?>
" href="javascript:;"  ><?php echo $this->_tpl_vars['property']; ?>

                            <i class="headbg"></i>
							<div style="display:none">
                                <input class="propertygroup_input_<?php echo $this->_foreach['propertygroup']['iteration']; ?>
" id="property_<?php echo $this->_foreach['propertygroup']['iteration']; ?>
_<?php echo $this->_tpl_vars['propertyid']; ?>
" type="radio" name="propertygroup_<?php echo $this->_foreach['propertygroup']['iteration']; ?>
" propertyid="<?php echo $this->_tpl_vars['propertyid']; ?>
" value="<?php echo $this->_tpl_vars['property']; ?>
" />
                            </div>
                        </a>
						<?php endforeach; endif; unset($_from); ?>
					</dd> 
                </dl>
            <?php endforeach; endif; unset($_from); ?>   
            <dl class="clearfix">
              <dt>数&nbsp;&nbsp;&nbsp;&nbsp;量：</dt>
              <dd class="numas"> 
				<input value="<?php echo $this->_tpl_vars['productinfo']['postage']; ?>
" id="postage" type="hidden"/>
				<input value="<?php echo $this->_tpl_vars['productinfo']['includepost']; ?>
" id="includepost" type="hidden"/>
				<input value="<?php echo $this->_tpl_vars['productinfo']['mergepostage']; ?>
" id="mergepostage" type="hidden"/>
				
				<input onkeyup="recalc();" id="qty_item" name="qty_item" type="text" class="pull-left arial numtext" value="1">  
			    <div class="input-group-btn-vertical pull-left">  
			      <button id="addnum" class="btn btn-default" type="button"><i class="glyphicon glyphicon-chevron-up"></i></button>  
			      <button id="subnum" class="btn btn-default" type="button"><i class="glyphicon glyphicon-chevron-down"></i></button>  
			    </div> 
				<span class="red pull-left mt-10 p-l10">库存数量&nbsp;<span id="inventory_label"><?php echo $this->_tpl_vars['productinfo']['inventory']; ?>
</span>&nbsp;件</span> 
			</dd>
            </dl>
          </div>
          <div class="buy">
            <div class="btntor clearfix"> 
				<a href="javascript:;" id="shoppingcart" class="btn btn-danger btn-lg">立即购买</a> 
				<a href="javascript:;" id="addshoppingcart" class="btn btn-gray btn-lg btn-car">加入购物车</a>
              <div class="pull-left">  
				  <a href="javascript:;" id="addcollectionicon" class="btn btn-default btn-block btn-sm  btn-sc a-sc" ><?php if ($this->_tpl_vars['mycollections'] == '0'): ?>收藏<?php else: ?>取消收藏<?php endif; ?></a> 
				  <a href="#" class="btn btn-default btn-block btn-smb btn-sc">推荐到首页</a> 
			  </div> 
            </div>
          </div>
          
        </div>
        <!--poto-top-r-->
      </div>
      <!--poto-top 顶部图片介绍-->
      <div class="blank20"></div>
      <div class="pro-bot clearfix">
        <div class="line2"></div>  
		<!--Overview-r 右侧同类产品推荐-->
        <div class="Overview-r pull-right">
          <div class="Overview-r-tit">
            <h3 class="f16">同类产品推荐</h3>
          </div>
          <div class="Recent-body Overview-r-lr">
            <ul>
			<?php $_from = $this->_tpl_vars['samecategory_products']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['samecategory_products'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['samecategory_products']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['samecategory_product_info']):
        $this->_foreach['samecategory_products']['iteration']++;
?> 
			  <li>
	             <div class="imgbox"><a href="detail.php?from=detail&productid=<?php echo $this->_tpl_vars['samecategory_product_info']['productid']; ?>
"><img class="lazy" src="/public/pc/images/load.gif" data-original="<?php echo $this->_tpl_vars['samecategory_product_info']['productlogo']; ?>
" width="260" height="165"></a>
	               <p><a href="detail.php?from=detail&productid=<?php echo $this->_tpl_vars['samecategory_product_info']['productid']; ?>
"><?php echo $this->_tpl_vars['samecategory_product_info']['productname']; ?>
</a></p>
	             </div>
	             <div class="imgbox-bot"> 
	               <p class="price red arial"><span class="price-icon">￥</span><?php echo $this->_tpl_vars['samecategory_product_info']['shop_price']; ?>
<del>￥<?php echo $this->_tpl_vars['samecategory_product_info']['market_price']; ?>
</del></p>
	             </div>
	           </li>
		    <?php endforeach; endif; unset($_from); ?>   
            </Ul>
          </div>
        </div>
		<!--Overview-l 左侧商品介绍-->
        <div class="Overview-l pull-left Overview-l-lr border-t1">
	      <div class="Overview-l-tit clearfix Overview-review" style="padding-top:5px;">
	          <ul class="nav nav-tabs">  
	              <li class="active"><a href="#commoditygraphicdetails" data-toggle="tab" class="md">商品图文详情</a></li>  
	              <li><a href="#cumulativeevaluation" data-toggle="tab">累计评价(<?php echo $this->_tpl_vars['appraisecount']; ?>
)</a></li>  
	              <li><a href="#transactionrecord" data-toggle="tab">成交记录(<?php echo $this->_tpl_vars['tradecount']; ?>
)</a></li>  
				  <li><a href="#servicedeclaration" data-toggle="tab">服务声明</a></li>  
	          </ul>  
	          <div class="tab-content Overview-review-nr border-t1" style="padding-top: 20px;">
	              <div class="tab-pane active" id="commoditygraphicdetails">  
	               <?php echo $this->_tpl_vars['productinfo']['simple_desc']; ?>

				   <?php echo $this->_tpl_vars['productinfo']['description']; ?>

	              </div>
	              <div id="cumulativeevaluation" class="Overveiw-tabcon">
						<?php if (count($this->_tpl_vars['appraises']) == 0): ?>
						 <h5 class="show-content" style="padding: 10px;background: #ff5400;">目前没有评价。</h5>                   
						<?php else: ?>
							<ul id="valuation-content">
								<?php $_from = $this->_tpl_vars['appraises']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['appraises'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['appraises']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['appraises_info']):
        $this->_foreach['appraises']['iteration']++;
?>
									<li class="clearfix reviewlist" style="padding: 8px 5px;background: #fff;">
										<div class="reviewlist" style="width:100%;">
											<ul class="star" style="display:block;width:79%;float:left;height:30px;line-height:30px;margin-left:1%;">
												<?php unset($this->_sections['total']);
$this->_sections['total']['name'] = 'total';
$this->_sections['total']['loop'] = is_array($_loop=$this->_tpl_vars['appraises_info']['active_praise']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['total']['show'] = true;
$this->_sections['total']['max'] = $this->_sections['total']['loop'];
$this->_sections['total']['step'] = 1;
$this->_sections['total']['start'] = $this->_sections['total']['step'] > 0 ? 0 : $this->_sections['total']['loop']-1;
if ($this->_sections['total']['show']) {
    $this->_sections['total']['total'] = $this->_sections['total']['loop'];
    if ($this->_sections['total']['total'] == 0)
        $this->_sections['total']['show'] = false;
} else
    $this->_sections['total']['total'] = 0;
if ($this->_sections['total']['show']):

            for ($this->_sections['total']['index'] = $this->_sections['total']['start'], $this->_sections['total']['iteration'] = 1;
                 $this->_sections['total']['iteration'] <= $this->_sections['total']['total'];
                 $this->_sections['total']['index'] += $this->_sections['total']['step'], $this->_sections['total']['iteration']++):
$this->_sections['total']['rownum'] = $this->_sections['total']['iteration'];
$this->_sections['total']['index_prev'] = $this->_sections['total']['index'] - $this->_sections['total']['step'];
$this->_sections['total']['index_next'] = $this->_sections['total']['index'] + $this->_sections['total']['step'];
$this->_sections['total']['first']      = ($this->_sections['total']['iteration'] == 1);
$this->_sections['total']['last']       = ($this->_sections['total']['iteration'] == $this->_sections['total']['total']);
?>
													<li class="active" style="width: 13px;height: 13px;display: block;float: left;margin-right: 5px;"></li>
												<?php endfor; endif; ?>
												<?php unset($this->_sections['total']);
$this->_sections['total']['name'] = 'total';
$this->_sections['total']['loop'] = is_array($_loop=$this->_tpl_vars['appraises_info']['unactive_praise']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['total']['show'] = true;
$this->_sections['total']['max'] = $this->_sections['total']['loop'];
$this->_sections['total']['step'] = 1;
$this->_sections['total']['start'] = $this->_sections['total']['step'] > 0 ? 0 : $this->_sections['total']['loop']-1;
if ($this->_sections['total']['show']) {
    $this->_sections['total']['total'] = $this->_sections['total']['loop'];
    if ($this->_sections['total']['total'] == 0)
        $this->_sections['total']['show'] = false;
} else
    $this->_sections['total']['total'] = 0;
if ($this->_sections['total']['show']):

            for ($this->_sections['total']['index'] = $this->_sections['total']['start'], $this->_sections['total']['iteration'] = 1;
                 $this->_sections['total']['iteration'] <= $this->_sections['total']['total'];
                 $this->_sections['total']['index'] += $this->_sections['total']['step'], $this->_sections['total']['iteration']++):
$this->_sections['total']['rownum'] = $this->_sections['total']['iteration'];
$this->_sections['total']['index_prev'] = $this->_sections['total']['index'] - $this->_sections['total']['step'];
$this->_sections['total']['index_next'] = $this->_sections['total']['index'] + $this->_sections['total']['step'];
$this->_sections['total']['first']      = ($this->_sections['total']['iteration'] == 1);
$this->_sections['total']['last']       = ($this->_sections['total']['iteration'] == $this->_sections['total']['total']);
?>
													<li style="width: 13px;height: 13px;display: block;float: left;margin-right: 5px;"></li>
												<?php endfor; endif; ?>
											</ul>
											<div style="display:block;width:20%;float:left;text-align: right;"><?php echo $this->_tpl_vars['appraises_info']['published']; ?>
</div>
										</div>
										<div class="reviewlistbox clearfix mt-10 reviewlist" style="width:100%;">
											<div style="max-height:50px;line-height: 1;width:60%;text-align: left;margin-left:1%;"><?php echo $this->_tpl_vars['appraises_info']['remark']; ?>
</div>
											<div style="width:14%;margin-left:5%;display:block;float:left;min-height:25px;">
												<ul>
													<li><span class="black"><?php echo $this->_tpl_vars['appraises_info']['propertydesc']; ?>
</span></li>
												</ul>
											</div>
											<div class="mui-media-body reviewlist" style="width:20%;display:block;float:left;text-align: right;">
												<p><img class="mui-media-object mui-pull-left" style="width:20px;height:20px;" src="<?php echo $this->_tpl_vars['appraises_info']['headimgurl']; ?>
"><strong><?php echo $this->_tpl_vars['appraises_info']['givenname']; ?>
</strong></p>
											</div>
										</div>
										<?php if ($this->_tpl_vars['appraises_info']['hasimages'] > 0): ?>
											<div class="mui-media-body reviewlist" style="width:100%;">
												<div class="imgshow pull-left">
													<ul class="poto-sma  mb-10 mt-10 clearfix">
														<?php $_from = $this->_tpl_vars['appraises']['images']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['appraise_images'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['appraise_images']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['appraise_image_info']):
        $this->_foreach['appraise_images']['iteration']++;
?>
															<?php if ($this->_tpl_vars['index'] == 0): ?>
																<li onclick="imgView(this);" class="active" style="width:auto;"><img class="mui-media-object mui-pull-left" src="<?php echo $this->_tpl_vars['appraise_image_info']; ?>
" width="105" height="75"></li>
															<?php else: ?>
																<li onclick="imgView(this);" style="width:auto;"><img class="mui-media-object mui-pull-left" src="<?php echo $this->_tpl_vars['appraise_image_info']; ?>
" width="105" height="75"></li>
															<?php endif; ?>
														<?php endforeach; endif; unset($_from); ?>
													</ul>

													<div class="poto-big border">
														<ul class="poto-big-img">
															<?php $_from = $this->_tpl_vars['appraises']['images']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['appraise_images'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['appraise_images']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['appraise_image_info']):
        $this->_foreach['appraise_images']['iteration']++;
?>
																<?php if ($this->_tpl_vars['index'] == 0): ?>
																	<li class="active"><img src="<?php echo $this->_tpl_vars['appraise_image_info']; ?>
" width="505" height="360"></li>
																<?php else: ?>
																	<li><img src="<?php echo $this->_tpl_vars['appraise_image_info']; ?>
" width="505" height="360"></li>
																<?php endif; ?>
															<?php endforeach; endif; unset($_from); ?>
														</ul>
													</div>
												</div>
											</div>
										<?php endif; ?>
								    </li>
								<?php endforeach; endif; unset($_from); ?>
							</ul>
							<div class="blank20"></div>

							<input type="hidden" id="valuation_cur_page" value="1">

							<div id="Pagination" class="pagination" style="width:100%;text-align: center;">
							</div>
						<?php endif; ?>
	              </div>

	              <div id="transactionrecord" class="tab-pane" >
	              <table cellpadding="0" cellspacing="0" border="0" width="100%" class="zbtable">
                  <thead>
                    <tr class="black" style="background: #f5f5f5;height: 35px;line-height:35px;">
                      <td>买家</td>
                      <td>价格</td>
                      <td>购买时间</td>
                      <td>数量</td>
                    </tr>
                  </thead>
                  <input id="page" value="2" type="hidden"> 
                  <tbody id="list">
                  <?php $_from = $this->_tpl_vars['transactionrecords']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['transactionrecords'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['transactionrecords']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['transactionrecord_info']):
        $this->_foreach['transactionrecords']['iteration']++;
?>
                  	<tr style="border-bottom: 1px solid #e8e8e8;height: 35px;line-height: 35px;">
						<td><span style="margin-right:10px;"><?php echo $this->_tpl_vars['transactionrecord_info']['givenname']; ?>
</span></td>
						<td><span>¥<?php echo $this->_tpl_vars['transactionrecord_info']['shop_price']; ?>
</span> </td>
						<td><span><?php echo $this->_tpl_vars['transactionrecord_info']['published']; ?>
</span></td>
						<td><span><?php echo $this->_tpl_vars['transactionrecord_info']['quantity']; ?>
</span></td>
					</tr>
                  <?php endforeach; endif; unset($_from); ?>
                  </tbody>
                </table>
	              </div>
	              <div id="servicedeclaration" class="tab-pane">  
			         <h3 class="show-content"><em>卖家承诺以下服务</em></h3>
			         <div class="show-content">
			   		         <dl class="seven-days">
	       			            <dd class="name" >7天无理由退货</dd>
	                            <dd class="detail">
	                               <p>该商品支持7天无理由退货，自商品签收之日起7天内:</p>
	                               <p>1、商品外包装完整，相关附（配）件齐全；</p>
								   <p>2、商品表面无划痕、无破损、无使用等痕迹；如商品使用留下记录参数，则不支持退；</p>
								   <p>3、（若有）防伪标识码未刮开或撕损</p>
								   <p>可申请无理由退货，包邮商品需要买家承担退货邮费，非包邮商品需要买家承担发货和退货邮费。</p>  
	                           </dd>
			       			</dl>
            
			                <dl>
	                           <dd class="name">消费者保障服务</dd>
	                           <dd class="detail"> 
		                            <p>在确认收货7天内，如有商品质量问题、描述不符或未收到货等，您有权申请退款或退货，来回邮费由卖家承担。</p>
	                           </dd>
			       			</dl>
            
			         </div>
	              </div>
	          </div>  
	      </div>  
        </div>
      </div>
      <div class="blank60"></div>
      <div class="Recent">
        <div class="Recent-tit">
          <h4>最近浏览</h4>
        </div>
        <div class="Recent-body">
          <ul>
			  <?php $_from = $this->_tpl_vars['product_historys']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['product_historys'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['product_historys']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['product_history_info']):
        $this->_foreach['product_historys']['iteration']++;
?> 
	              <li>
	                <div class="imgbox"><a href="detail.php?from=detail&productid=<?php echo $this->_tpl_vars['product_history_info']['productid']; ?>
"><img class="lazy" src="/public/pc/images/load.gif" data-original="<?php echo $this->_tpl_vars['product_history_info']['productlogo']; ?>
" width="260" height="165"></a>
	                  <p><a href="detail.php?from=detail&productid=<?php echo $this->_tpl_vars['product_history_info']['productid']; ?>
"><?php echo $this->_tpl_vars['product_history_info']['productname']; ?>
</a></p>
	                </div>
	                <div class="imgbox-bot"> 
	                  <p class="price red arial"><span class="price-icon">￥</span><?php echo $this->_tpl_vars['product_history_info']['shop_price']; ?>
<del>￥<?php echo $this->_tpl_vars['product_history_info']['market_price']; ?>
</del></p>
	                </div>
	              </li>
			  <?php endforeach; endif; unset($_from); ?>  
          </Ul>
        </div>
      </div>
    </div>
  </div>
  <!--cont 主体-->
  <div class="blank20"></div>
  <!--link 链接-->
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'footbar.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
<!--warp 外层-->
</body>




<script src="/public/pc/js/jquery-1.11.3.min.js"></script>
<script src="/public/pc/js/bootstrap.min.js"></script> 
<script src="/public/pc/js/jquery.lazyload.min.js"></script>
<script src="/public/pc/js/jquery.pagination.js"></script>
<script type="text/javascript" src="public/js/sweetalert.min.js"></script>
<script src="/public/pc/js/index.js"></script>
<script src="/public/pc/js/detail.js"></script>
<script>
    var propertys = <?php echo $this->_tpl_vars['propertys']; ?>
;
	var num_count=<?php echo $this->_tpl_vars['total_prase_num']; ?>
;
	var productid=<?php echo $this->_tpl_vars['productid']; ?>
;
<?php echo ' 
$(function(){
	$("#Pagination").pagination(num_count, {
		items_per_page:10,
		num_edge_entries: 2,
		num_display_entries: 4,
		link_to:"javascript:void(0);",
		prev_text: "<&nbsp;上一页",
		next_text: "下一页&nbsp;>",
		prev_show_always: true,
		next_show_always: true,
		callback: pageselectCallback
	});

	$(\'#addshoppingcart\').click(function(){ addshoppingcart(); });
	
	$(\'#addcollectionicon\').click(function(){ addcollectionicon(); });
	
	$(\'a#shoppingcart\').click(function(){
		checkshoppingcart(\'shoppingcart.php\'); 
	});
    $(\'.propertygroup\').click(function() { 
			var groupid =  $(this).attr(\'groupid\');
			var propertyid =  $(this).attr(\'propertyid\');   
			$(".propertygroup_"+groupid).removeClass("active"); 
			$(this).addClass("active"); 
			
			$(".propertygroup_input_"+groupid).attr("checked",false); 
			$("#property_"+groupid+"_"+propertyid).attr("checked",true); 
			$(".propertygroup_input_"+groupid).prop("checked",false); 
			$("#property_"+groupid+"_"+propertyid).prop("checked",true); 
			$("#type").val(\'\');  
			change_price(propertys);
		});  
	// 修改价格
	$(\'#addnum\').click(function() {
		var inventoryNum = parseInt($(\'#inventory1\').val());
		var nowNum = parseInt($(\'#qty_item\').val());
		if (nowNum < inventoryNum) {
			$(\'#qty_item\').val(nowNum + 1);
			recalc();
		}
	});
	$(\'#subnum\').click(function() {
		var nowNum = parseInt($(\'#qty_item\').val());
		if (nowNum > 1) {
			$(\'#qty_item\').val(nowNum - 1);
			recalc();
		}
	});	
		
});

function pageselectCallback(page, pageination) {
	var url = "moreprase.php?productid="+productid+"&cur_page="+page;
	$.get(url, "", function (data) {
		$("#valuation-content").empty().append(data);
	});
};



function checkshoppingcart(shoppingcarturl)
		{ 
            var inventory = $(\'#inventory1\').val();
            var newinventory = parseInt(inventory,10);
            if ( newinventory <= 0)
            {
				alert(\'您选择的商品已经卖完了！\'); 
                return false;
            }
			if ($(\'#type\').val() == "")
			{
	            var property_type_count = $(\'#property_type_count\').val();
	            for(var i=1;i<=property_type_count;i++)
	            {
					var radio = $(\'input[name=propertygroup_\'+i+\'][checked=true]\');
	                if( radio.val() == undefined ) 
	                { 
	                    alert(\'请选择商品的\'+$(\'#propertygroup_label_\'+i).val()); 
	                    return false;
	                }
	            } 
				alert(\'您还需要选择的商品属性！\');  
				return false;
			}
			else
			{
				var qty_item = $(\'#qty_item\').val(); 
				var productid = $(\'#productid\').val();
				var product_property_id = $(\'#product_property_id\').val();
			    var postbody = \'shoppingcart=1&record=\' + productid + \'&quantity=\' + qty_item;
			    if (product_property_id != "" && product_property_id != undefined)
				{
					postbody = \'type=detail&shoppingcart=1&record=\' + productid + \'&quantity=\' + qty_item + \'&propertyid=\' + product_property_id;
				}
				var salesactivityid = $(\'#salesactivityid\').val();
				var salesactivity_product_id = $(\'#salesactivity_product_id\').val();
				if (salesactivityid != "" && salesactivity_product_id != "")
				{
					postbody += \'&salesactivityid=\'+salesactivityid + \'&salesactivitys_product_id=\'+salesactivity_product_id;
				}
		        $.ajax({
			            type: \'POST\',
			            url: "shoppingcart_add.ajax.php",
			            data: postbody,
			            success: function(json) {   
			                var jsondata = eval("("+json+")");
			                if (jsondata.code == 200) {
			                	window.location.href = shoppingcarturl;
			                } 
							else
							{
								 alert(jsondata.msg);
							}
			            }
					 }); 
			}
		}
//图片展示
function imgView(obj){
	$(obj).addClass(\'active\').siblings().removeClass(\'active\');
	var oLi = $(obj).parent(\'.poto-sma\').find(\'li\');
	for(var i=0; i<oLi.length; i++){
		oLi.eq(i).attr(\'index\',i);
	}
	var oBigimg = $(obj).parent().parent().find(\'.poto-big-img li\');
	var _index = $(obj).attr(\'index\');
	oBigimg.eq(_index).show().siblings().hide();
}
//评论选项卡
//oPl();
//收藏弹出
//Oalert($(\'.a-sc\'),$(\'.order-alert1\'));
//Oalert($(\'.btn-car\'),$(\'.order-alert2\'));
/*
$(function(){	
	$(\'.poto-top-choice dd a\').click(function(){	//商品选择
		$(this).addClass(\'active\').siblings().removeClass(\'active\');
		return false;
	});
});*/
//右侧导航
oRight(60); //如果需要调用左侧辅助导航需要两个函数oRight()与oLeftbur()两个函数，oRight()需要传一个内容到头部的差值
oLeftbur();
rightBar(\'.btn-group-right ul\',\'.group-open\');
'; ?>

</script>
</html>
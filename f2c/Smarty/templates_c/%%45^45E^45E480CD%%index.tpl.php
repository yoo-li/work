<?php /* Smarty version 2.6.18, created on 2017-08-16 16:06:20
         compiled from index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'index.tpl', 15, false),)), $this); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
    <title><?php if ($this->_tpl_vars['supplier_info']['mainpagetitle'] != '0'): ?><?php echo $this->_tpl_vars['supplier_info']['suppliername']; ?>
<?php endif; ?> </title>
    <link href="public/css/mui.css" rel="stylesheet" />
    <link href="public/css/public.css" rel="stylesheet" />
	<link href="public/css/iconfont.css" rel="stylesheet" />
	<link href="public/css/index.css" rel="stylesheet" />
	<link href="public/css/global.css" rel="stylesheet" />
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'theme.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<?php if (count($this->_tpl_vars['vendors']) > 0): ?>
	<style>
	  <?php echo '
		  .img-responsive { display: block; height: auto; width: 100%; }

		  .mui-table-view-cell .mui-table-view-label
		  {
		  	    width:60px;
		  		text-align:right;
		  		display:inline-block;
		  }
		  .mui-table-view .mui-media-object {
		      line-height: 100px;
		      max-width: 100px;
		      height: auto;
		  }

		  .mui-table-view-chevron .mui-table-view-cell { padding-right: 25px; }
		  .mui-navigate-right:after, .mui-push-right:after {  right: 45px;  }
		  #vendors .mui-table-view-cell:after {  background-color: #c8c7cc; }
	 	 '; ?>

	</style>
	<?php endif; ?>
    <script src="public/js/mui.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="public/js/zepto.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="public/js/lazyload.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="public/js/common.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript" src="public/js/jweixin.js"></script>
</head>

<body>
    <!-- 侧滑导航根容器 -->
    <div class="mui-off-canvas-wrap mui-draggable" id="offCanvasWrapper">
        <!-- 菜单容器 -->
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'leftmenu.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <!-- 主页面容器 -->
        <div class="mui-inner-wrap">
		    <?php if ($this->_tpl_vars['supplier_info']['mainpagetitle'] == '0'): ?>
            <!-- 主页面标题 -->
            <header class="mui-bar mui-bar-nav">
                 <a id="offCanvasShow" href="#offCanvasSide" class="mui-icon mui-action-menu mui-icon-bars mui-pull-left"></a>
                 <?php if ($this->_tpl_vars['supplier_info']['presalesconsultation'] == '0'): ?>
                 <a href="webim.php" class="mui-icon mui-action-menu mui-icon-chat mui-twinkling mui-pull-right"></a>
                 <?php endif; ?>
                 <h1 class="mui-title"><?php echo $this->_tpl_vars['supplier_info']['suppliername']; ?>
</h1>
            </header>
		    <?php endif; ?>
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
             <div id="pullrefresh" class="mui-content mui-scroll-wrapper"  <?php if ($this->_tpl_vars['supplier_info']['mainpagetitle'] == '0'): ?>style="padding-top: 45px;"<?php endif; ?>>
                 <div class="mui-scroll">
					 	 <?php if ($this->_tpl_vars['supplier_info']['mainpageslider'] == '1'): ?>
		                 <!--slider-->
			             <div id="slider" class="mui-slider" >
			                     <div class="mui-slider-group mui-slider-loop">
				                        <?php $this->assign('ads_count', count($this->_tpl_vars['ads'])); ?>
                                        <?php $_from = $this->_tpl_vars['ads']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['ads'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['ads']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['ad_info']):
        $this->_foreach['ads']['iteration']++;
?>
                                            <?php if ($this->_foreach['ads']['iteration'] == 1): ?>
		 			                             <div class="mui-slider-item mui-slider-item-duplicate">
		 			                                 <a href="<?php echo $this->_tpl_vars['ad_info']['link']; ?>
">
		 			                                     <img style="" src="<?php echo $this->_tpl_vars['ad_info']['banner']; ?>
" alt="<?php echo $this->_tpl_vars['ad_info']['adname']; ?>
">
		 			                                 </a>
		 			                                 <p class="mui-slider-title"><?php echo $this->_tpl_vars['ad_info']['adtitle']; ?>
</p>
		 			                             </div>
	 			                             <?php endif; ?>
						 	           <?php endforeach; endif; unset($_from); ?>
					                   <?php $_from = $this->_tpl_vars['ads']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ad_info']):
?>
	 			                             <div class="mui-slider-item">
	 			                                 <a href="<?php echo $this->_tpl_vars['ad_info']['link']; ?>
">
	 			                                     <img style="" src="<?php echo $this->_tpl_vars['ad_info']['banner']; ?>
" alt="<?php echo $this->_tpl_vars['ad_info']['adname']; ?>
">
	 			                                 </a>
	 			                                 <p class="mui-slider-title"><?php echo $this->_tpl_vars['ad_info']['adtitle']; ?>
</p>
	 			                             </div>
						 	           <?php endforeach; endif; unset($_from); ?>
						 	           <?php $_from = $this->_tpl_vars['ads']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['ads'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['ads']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['ad_info']):
        $this->_foreach['ads']['iteration']++;
?>
                                            <?php if ($this->_foreach['ads']['iteration'] == $this->_tpl_vars['ads_count']): ?>
		 			                             <div class="mui-slider-item mui-slider-item-duplicate">
		 			                                 <a href="<?php echo $this->_tpl_vars['ad_info']['link']; ?>
">
		 			                                     <img style="" src="<?php echo $this->_tpl_vars['ad_info']['banner']; ?>
" alt="<?php echo $this->_tpl_vars['ad_info']['adname']; ?>
">
		 			                                 </a>
		 			                                 <p class="mui-slider-title"><?php echo $this->_tpl_vars['ad_info']['adtitle']; ?>
</p>
		 			                             </div>
	 			                             <?php endif; ?>
						 	           <?php endforeach; endif; unset($_from); ?>

								 </div>
			                     <div class="mui-slider-indicator mui-text-right">
				                   <?php $_from = $this->_tpl_vars['ads']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ad_info']):
?>
 			                            <div class="mui-indicator"></div>
					 	           <?php endforeach; endif; unset($_from); ?>
			 				     </div>
			              </div>
						   <!-- end slider -->
						 <?php endif; ?>
						 <?php if ($this->_tpl_vars['supplier_info']['mainpagetitle'] == '0'): ?>
				   			 <form action="search.php" onSubmit="return searchgo()">
								  <div class="mui-table-view">
									  <div class="mui-table-view-cell">
						   				<div class="mui-input-row mui-search">
						   					<input id="keywords" name="keywords" type="search" class="mui-input-clear" placeholder="搜索你喜欢的商品">
						   				</div>
								     </div>
							      </div>
						     </form>

			                  <?php if ($this->_tpl_vars['supplier_info']['suppliertype'] == 'F2C'): ?>
		                      <!--icon menu-->
		                      <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'iconmenu.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		                      <!--end icon menu-->
		                      <?php endif; ?>
							  <h6 class="mui-content-padded" style="height:3px;margin:0px">&nbsp;</h6>
						  <?php endif; ?>
						  <?php if ($this->_tpl_vars['supplier_info']['topadlogo'] != ''): ?>
						  		<img class="img-responsive"  src="<?php echo $this->_tpl_vars['supplier_info']['topadlogo']; ?>
">
						  <?php endif; ?>
						  <?php $_from = $this->_tpl_vars['salesactivitylist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['salesactivitys'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['salesactivitys']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['salesactivityid'] => $this->_tpl_vars['salesactivity_info']):
        $this->_foreach['salesactivitys']['iteration']++;
?>
	 						<div>
 								 <ul class="mui-table-view">
									  <li class="mui-table-view-cell mui-media salesactivity" >
			  								 <a style="margin:0px;" href="salesactivity.php?record=<?php echo $this->_tpl_vars['salesactivity_info']['id']; ?>
">
			  									 <img class="mui-media-object" style="width: 100%;max-width: 100%;height: auto;" src="<?php echo $this->_tpl_vars['salesactivity_info']['homepage']; ?>
">
			   								 </a>
			  						</li>
 						 	 	</ul>
	 						 </div>
				   		  <?php endforeach; endif; unset($_from); ?>

		                  <input id="page" name="page" value="2" type="hidden">
						 	 <?php if (count($this->_tpl_vars['vendors']) > 0): ?>
							 <ul id="vendors" class="mui-table-view mui-table-view-chevron" style="color: #333;">
								 	<?php $_from = $this->_tpl_vars['vendors']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['vendors'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['vendors']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['vendor_info']):
        $this->_foreach['vendors']['iteration']++;
?>
								 		<li class="mui-table-view-cell mui-left" style="height:104px;">
											<a class="mui-navigate-right" href="category.php?vendorid=<?php echo $this->_tpl_vars['vendor_info']['vendorid']; ?>
">
										        <img class="mui-media-object mui-pull-left" src="<?php echo $this->_tpl_vars['vendor_info']['image']; ?>
">
												<div class="mui-media-body mui-pull-left" style="width:180px">
													<p class='mui-ellipsis' style="color:#333;font-size:1.3em;"><?php echo $this->_tpl_vars['vendor_info']['vendorname']; ?>
</p>
													<?php if ($this->_tpl_vars['vendor_info']['address'] == ''): ?>
														<p class='mui-ellipsis'  style="padding-top:4px;line-height: 24px;">联系人：<?php echo $this->_tpl_vars['vendor_info']['contact']; ?>
</p>
														<p class='mui-ellipsis' style="line-height: 24px;">电话：<?php echo $this->_tpl_vars['vendor_info']['telphone']; ?>
</p>
													<?php else: ?>
														<p class='mui-ellipsis' style="padding-top:4px;line-height: 16px;">联系人：<?php echo $this->_tpl_vars['vendor_info']['contact']; ?>
</p>
														<p class='mui-ellipsis' style="padding-top:0px;line-height: 16px;">电话：<?php echo $this->_tpl_vars['vendor_info']['telphone']; ?>
</p>
														<p class='mui-ellipsis' style="padding-top:0px;line-height: 16px;">地址：<?php echo $this->_tpl_vars['vendor_info']['address']; ?>
</p>
													<?php endif; ?>
												</div>
											</a>
	  									</li>
						   		  <?php endforeach; endif; unset($_from); ?>
					 	 	</ul>
							<?php else: ?>
		                      <ul id="list" class="mui-table-view mui-grid-view list" <?php if ($this->_tpl_vars['supplier_info']['mainpageproductshowmode'] == '1'): ?>style="border:0px;position: static;"<?php endif; ?>>
							  </ul>
							<?php endif; ?>
						  <?php if ($this->_tpl_vars['supplier_info']['bottomadlogo'] != ''): ?>
						  		<img class="lazy img-responsive" src="images/lazyload.png" data-original="<?php echo $this->_tpl_vars['supplier_info']['bottomadlogo']; ?>
">
						  <?php endif; ?>
						   <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'copyright.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                 </div>

             </div>
            <div class="mui-backdrop" style="display:none;"></div>
        </div>
    </div>

<?php if ($this->_tpl_vars['seekattention'] == 'yes'): ?>
	<div id="seekattention" style="z-index: 999;position: fixed;right:0px; top: 65%; display: block;">
		<a href="seekattention.php">
			<img src="images/qrcode/seekattention.gif" style="width:120px;">
		</a>
	</div>
<?php endif; ?>

<script type="text/javascript">
var indexcolumns = <?php echo $this->_tpl_vars['supplier_info']['indexcolumns']; ?>
;
var mainpageproductshowmode = <?php echo $this->_tpl_vars['supplier_info']['mainpageproductshowmode']; ?>
;
var product_count = 1;
var lock = 0;
<?php echo '
    mui.init({
        pullRefresh: {
            container: \'#pullrefresh\', //待刷新区域标识，querySelector能定位的css选择器均可，比如：id、.class等
			down: {
				callback: pulldownRefresh
			},
            up: {
                contentrefresh: "正在加载...", //可选，正在加载状态时，上拉加载控件上显示的标题内容
                contentnomore: \'没有更多数据了\', //可选，请求完毕若没有更多数据时显示的提醒内容；
                callback: add_more //必选，刷新函数，根据具体业务来编写，比如通过ajax从服务器获取新数据；
            }
        },
    });
	/**
	 * 下拉刷新具体业务实现
	 */
	function pulldownRefresh() {
		setTimeout(function() {
            Zepto(\'#page\').val(1);
            Zepto(\'.list\').html(\'\');
			product_count = 1;
            add_more();
			mui(\'#pullrefresh\').pullRefresh().endPulldownToRefresh(); //refresh completed
		}, 1000);
	}

	function add_shoppingcart(record)
	{
        mui.ajax({
            type: \'POST\',
            url: "shoppingcart_add.ajax.php",
            data: \'record=\' + record,
            success: function(json) {
                var jsondata = eval("("+json+")");
                if (jsondata.code == 200) {
					 mui.toast(jsondata.msg);
					 flyItem("product_item_"+record);
                     Zepto(\'#shoppingcart_badge\').html(\'<span class="mui-badge">\'+jsondata.shoppingcart+\'</span>\');
                }
				else
				{
					 mui.toast(jsondata.msg);
				}
            }
        });
    }

	mui.ready(function() {
		mui(\'#seekattention\').on(\'tap\',\'a\',function(){
			mui.openWindow({
				url: this.getAttribute(\'href\'),
				id: \'info\'
			});
		});
		mui(\'#slider\').on(\'tap\',\'a\',function(){
			var adurl = this.getAttribute(\'href\');
			if (adurl != "")
			{
				mui.openWindow({
					url: adurl,
					id: \'info\'
				});
			}
		});
		mui(\'.mui-table-view\').on(\'tap\',\'a.add_shoppingcart\',function(){
			var record =  this.getAttribute(\'data-id\');
			add_shoppingcart(record);
		});
		mui(\'.mui-table-view\').on(\'tap\',\'li.praise_product\',function(){
			var productid =  this.getAttribute(\'data-id\');
			praise_product(productid);
		});

		mui(\'.mui-bar\').on(\'tap\',\'a\',function(e){
			mui.openWindow({
				url: this.getAttribute(\'href\'),
				id: \'info\'
			});
		});

		mui(\'.mui-table-view\').on(\'tap\', \'a\', function(e) {
			 var href = this.getAttribute(\'href\');
			  if (href && href != "")
			  {
				  mui.openWindow({
									 url: this.getAttribute(\'href\'),
									 id: \'info\'
							 });
			  }
		});


	});

function praise_product(productid) {
			_hmt.push([\'_setAutoPageview\', false]);
			_hmt.push([\'_trackPageview\', "praises.php"]);
	       mui.ajax({
			        type: \'POST\',
			        url: "praise.php",
			        data: \'productid=\' + productid + "&m="+Math.random(),
			        success: function(data) {
						$("#praise_product_"+productid).html(data);
			        }
			    });

	}

function product_singlerow_html(v) {
	 var sb=new StringBuilder();
	 if (mainpageproductshowmode == "1")
	 {
		 sb.append(\'<li class="mui-table-view-cell mui-media singlerow"  style="border:0px;">\');
 		 sb.append(\'<a href="company_detail.php?from=index&productid=\'+v.productid+\'">\');
		 sb.append(\'	 <img id="product_item_\'+v.productid+\'" class="mui-media-object lazy img-responsive"  src="images/lazyload.png" data-original="\'+v.productlogo+\'">\');
 		 sb.append(\'</a>\');
		 sb.append(\'</li>\');
	 }
	 else
	 {
		 sb.append(\'<li class="mui-table-view-cell mui-media singlerow">\');
 		 sb.append(\'<a href="company_detail.php?from=index&productid=\'+v.productid+\'">\');
		 sb.append(\'	 <img id="product_item_\'+v.productid+\'" class="mui-media-object lazy img-responsive"  src="images/lazyload.png" data-original="\'+v.productlogo+\'">\');
 		 sb.append(\'</a>\');
		 sb.append(\'	 <div class="cp_miaoshu">\');
		 sb.append(\'		 <div class="ms_left"></div>\');
		 sb.append(\'		 <div class="ms_right">\');
		 sb.append(\'			 <div class="tit">\'+v.productname+\'</div>\');
		 sb.append(\'			 <div class="cnt">\');
		 sb.append(\'				 <ul>\');
		 sb.append(\'					 <li class="wg1"><span class="tit01">市场价:&nbsp;</span><span class="price1">¥\'+v.market_price+\'</span><br><span class="price2">¥\'+v.shop_price+\'</span><br></li>\');
		 sb.append(\'					 <li class="wg2 praise_product" id="praise_product_\'+v.productid+\'" data-id="\'+v.productid+\'"><span class="mui-icon iconfont icon-tezan"></span>\'+v.praise+\'</li>\');
		 if (v.hasproperty == "1")
		 {
			 sb.append(\'<li class="wg3"><a href="company_detail.php?from=index&productid=\'+v.productid+\'"><span class="mui-icon iconfont icon-xinzeng special-button-color"></span></a></li>\');
		 }
		 else
		 {
			 sb.append(\'<li class="wg3"><a class="add_shoppingcart" data-id="\'+v.productid+\'" href="javascript:;"><span class="mui-icon iconfont icon-xinzeng special-button-color"></span></a></li>\');
		 }
		 sb.append(\'				 </ul>\');
		 sb.append(\'			 </div>\');
		 sb.append(\'		 </div>\');
		 sb.append(\'	 </div>\');
		 sb.append(\'</li>\');
	 }

	 return sb.toString();
}

function product_doublerow_html(v,align) {
	 var sb=new StringBuilder();
	 if (mainpageproductshowmode == "1")
	 {
		 sb.append(\'<li class="mui-table-view-cell mui-media singlerow" style="border:0px;">\');
 		 sb.append(\'<a href="company_detail.php?from=index&productid=\'+v.productid+\'">\');
		 sb.append(\'	 <img id="product_item_\'+v.productid+\'" class="mui-media-object lazy img-responsive"  src="images/lazyload.png" data-original="\'+v.productlogo+\'">\');
 		 sb.append(\'</a>\');
		 sb.append(\'</li>\');
	 }
	 else
	 {
		 sb.append(\'<li class="mui-table-view-cell mui-media \'+align+\' mui-col-xs-6 doublerow">\');
		 sb.append(\'    	<a href="company_detail.php?from=index&productid=\'+v.productid+\'">\');
		 sb.append(\'        <img id="product_item_\'+v.productid+\'" class="mui-media-object lazy img-responsive" src="images/lazyload.png" data-original="\'+v.productlogo+\'">\');
		 sb.append(\'        <div class="mui-media-body">\'+v.productname+\'</div> \');
		 sb.append(\'		</a>\');
		 sb.append(\'		<div class="mui-media-body" style="height:40px;">\');
 		 sb.append(\'           <div class="cnt">\');
  		 sb.append(\'          	<ul>\');
  		 sb.append(\'              	<li class="wg1"><span class="price1">¥\'+v.market_price+\'</span><br><span class="price2">¥\'+v.shop_price+\'</span></li>\');
   		 sb.append(\'                	<li class="wg2 praise_product" id="praise_product_\'+v.productid+\'" data-id="\'+v.productid+\'"><span class="mui-icon iconfont icon-tezan"></span>\'+v.praise+\'</li>\');
		 if (v.hasproperty == "1")
		 {
			 sb.append(\'               <li class="wg3"><a href="company_detail.php?from=index&productid=\'+v.productid+\'"><span class="mui-icon iconfont icon-xinzeng special-button-color"></span></a> </li>\');
		 }
		 else
		 {
			 sb.append(\'               <li class="wg3"><a class="add_shoppingcart" data-id="\'+v.productid+\'" href="javascript:;"><span class="mui-icon iconfont icon-xinzeng special-button-color"></span></a> </li>\');
 		 }
		 sb.append(\'                </ul>\');
		 sb.append(\'            </div>\');
		 sb.append(\'		</div> \');
		 sb.append(\'</li> \');
	 }
	 return sb.toString();
}

function product_html(v)
{
	if (indexcolumns == 1)
	{
		return product_singlerow_html(v);
	}
	else if (indexcolumns == 2)
	{
		if (product_count % 2 == 1)
		{
			product_count = product_count + 1;
			return product_doublerow_html(v,\'left\');
		}
		else
		{
			product_count = product_count + 1;
			return product_doublerow_html(v,\'right\');
		}

	}
	else if (indexcolumns == 3) //12121212
	{
		if (product_count % 3 == 1)
		{
			product_count = product_count + 1;
			return product_singlerow_html(v);
		}
		else
		{
			if (product_count % 3 == 2)
			{
				product_count = product_count + 1;
				return product_doublerow_html(v,\'left\');
			}
			else
			{
				product_count = product_count + 1;
				return product_doublerow_html(v,\'right\');
			}
		}
	}
	else if (indexcolumns == 4) //112112112
	{
		if (product_count % 4 == 1 || product_count % 4 == 2)
		{
			product_count = product_count + 1;
			return product_singlerow_html(v);
		}
		else
		{
			if (product_count % 4 == 3)
			{
				product_count = product_count + 1;
				return product_doublerow_html(v,\'left\');
			}
			else
			{
				product_count = product_count + 1;
				return product_doublerow_html(v,\'right\');
			}
		}
	}
	else if (indexcolumns == 5) //221221
	{
		if (product_count % 5 == 0)
		{
			product_count = product_count + 1;
			return product_singlerow_html(v);
		}
		else
		{
			if (product_count % 5 == 1 || product_count % 5 == 3)
			{
				product_count = product_count + 1;
				return product_doublerow_html(v,\'left\');
			}
			else
			{
				product_count = product_count + 1;
				return product_doublerow_html(v,\'right\');
			}
		}
	}
	else if (indexcolumns == 6) //11121112
	{
		if (product_count % 5 == 1 || product_count % 5 == 2 || product_count % 5 == 3)
		{
			product_count = product_count + 1;
			return product_singlerow_html(v);
		}
		else
		{
			if (product_count % 5 == 4 )
			{
				product_count = product_count + 1;
				return product_doublerow_html(v,\'left\');
			}
			else
			{
				product_count = product_count + 1;
				return product_doublerow_html(v,\'right\');
			}
		}
	}
	else if (indexcolumns == 7) //22212221
	{
		if (product_count % 7 == 0)
		{
			product_count = product_count + 1;
			return product_singlerow_html(v);
		}
		else
		{
			if (product_count % 7 == 1 || product_count % 7 == 3 || product_count % 7 == 5)
			{
				product_count = product_count + 1;
				return product_doublerow_html(v,\'left\');
			}
			else
			{
				product_count = product_count + 1;
				return product_doublerow_html(v,\'right\');
			}
		}
	}
	else
	{

	}
}
    function add_more() {
		   if (lock == 0)
		   {
		   	    lock = 1;
				setTimeout(function() {
				var page = Zepto(\'#page\').val();
		            Zepto(\'#page\').val(parseInt(page) + 1);
		            mui.ajax({
		                type: \'POST\',
		                url: "index.ajax.php",
		                data: \'page=\' + page,
		                success: function(json) {
		                    var msg = eval("("+json+")");
		                    if (msg.code == 200) {
		                        Zepto.each(msg.data, function(i, v) {
									    var nd = product_html(v);
			                            Zepto(\'.list\').append(nd);
		                        });
								//mui(document).imageLazyload({ placeholder: \'images/lazyload.png\' });
		                        mui(\'#pullrefresh\').pullRefresh().endPullupToRefresh(false); //参数为true代表没有更多数据了。
								$(".lazy").lazyload();
		                    } else {
		                        mui(\'#pullrefresh\').pullRefresh().endPullupToRefresh(true); //参数为true代表没有更多数据了。
		                    }
		                }
		            });
				 }, 500);
		   }
		   mui(\'#pullrefresh\').pullRefresh().endPullupToRefresh(false); //参数为true代表没有更多数据了。
		   setTimeout(function() { lock = 0 }, 3000);
        }

    //触发第一页
    if (mui.os.plus) {
        mui.plusReady(function() {
            setTimeout(function() {
                mui(\'#pullrefresh\').pullRefresh().pullupLoading();
            }, 1000);

        });
    } else {
        mui.ready(function() {
            Zepto(\'#page\').val(1);
            mui(\'#pullrefresh\').pullRefresh().pullupLoading();
        });
    }


'; ?>

<?php if ($this->_tpl_vars['loginswap'] == '0'): ?>
   function loginlog()
   {
   mui.ajax({
       type: 'POST',
       url: "loginlog.php",
       data: 'm=' + Math.random(),
       success: function(json) {   }
   });
   }
   setTimeout(loginlog,100);
<?php endif; ?>
</script>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'weixin.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script src="/public/js/baidu.js?_=20140821" type="text/javascript"></script>
</body>
</html>
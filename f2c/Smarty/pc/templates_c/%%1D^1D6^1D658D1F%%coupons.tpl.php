<?php /* Smarty version 2.6.18, created on 2017-04-12 14:12:31
         compiled from coupons.tpl */ ?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $this->_tpl_vars['supplier_info']['suppliername']; ?>
-个人中心</title>
<link href="/public/pc/css/bootstrap.min.css" rel="stylesheet">
<link href="/public/pc/css/public.css" rel="stylesheet">
<link href="/public/pc/css/index.css" rel="stylesheet">
<link href="/public/pc/css/person.css" rel="stylesheet">
<link href="/public/pc/css/coupons.css" rel="stylesheet">
<script src="public/pc/js/common.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="public/js/jweixin.js"></script>
<!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="http://cdn.bootcss.com/respond./public/pc/js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div id="warp">
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
   <div class="line3"></div>
  <!--head 头部-->
  <div class="cont" id="offCanvasWrapper">
    <div class="container">
      <div class="break-person clearfix">
        <p><a href="#">首页</a><em>&gt;</em><span>个人中心</span></p>
      </div>
      <!--break-person-->
      <div class="personbox" >
       <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'usercenterL.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <!--person-left 个人中心左侧-->
        <div class="person-right pull-right">
          <div class="person-post border hui bn">
            <div class="person-post-tit person-linetit">
              <h3 class="f16 pull-left">我的卡券包</h3>
              <ul class="pull-left">
                <li><a href="coupons.php" class="active">卡券优惠</a>|</li>
                <li><a href="couponsofme.php">我的卡券使用记录</a></li>
              </ul>
            </div>
            <div class="complaintbox border-t1">
              <div class="complaintbox-t favorable">
                <?php $_from = $this->_tpl_vars['vipcardlist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['vipcards'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['vipcards']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['vipcardid'] => $this->_tpl_vars['vipcard_info']):
        $this->_foreach['vipcards']['iteration']++;
?> 
		           <?php $this->assign('iteration', $this->_foreach['vipcards']['iteration']); ?> 
		            <a class="clearfix" href=" <?php if ($this->_tpl_vars['vipcard_info']['usagesid'] == ''): ?>coupons_fetch.php<?php else: ?>coupons_view.php<?php endif; ?>?record=<?php echo $this->_tpl_vars['vipcardid']; ?>
"><div class="stamp <?php if ((1 & $this->_tpl_vars['iteration'])): ?>stamp02<?php else: ?>stamp04<?php endif; ?>">
					    <div class="par">
						    <p><?php echo $this->_tpl_vars['vipcard_info']['vipcardname']; ?>
 【<?php if ($this->_tpl_vars['vipcard_info']['timelimit'] == '0'): ?>单次<?php else: ?>不限次<?php endif; ?></p>
						     <?php if ($this->_tpl_vars['vipcard_info']['cardtype'] == '0'): ?>
								<sub class="sign">￥</sub>
							    <span><?php echo $this->_tpl_vars['vipcard_info']['amount']; ?>
</span>
							    <p>订单满<?php echo $this->_tpl_vars['vipcard_info']['orderamount']; ?>
.00元</p>
							 <?php elseif ($this->_tpl_vars['vipcard_info']['cardtype'] == '1'): ?>
								<sub class="sign">￥</sub>
							    <span><?php echo $this->_tpl_vars['vipcard_info']['amount']; ?>
</span>
							    <p>下单直接送</p>
							 <?php elseif ($this->_tpl_vars['vipcard_info']['cardtype'] == '2'): ?>
                                 <span><?php echo $this->_tpl_vars['vipcard_info']['discount']; ?>
折</span>
								 <?php if ($this->_tpl_vars['vipcard_info']['orderamount'] == '0'): ?>
								 	<p>下单直接送</p>
								 <?php else: ?>
								 	<p>订单满<?php echo $this->_tpl_vars['vipcard_info']['orderamount']; ?>
.00元</p>
								 <?php endif; ?>
							 <?php endif; ?> 
						    <sub>已领<?php echo $this->_tpl_vars['vipcard_info']['remaincount']; ?>
张，总计<?php echo $this->_tpl_vars['vipcard_info']['count']; ?>
张</sub>
					    </div>
					    <div class="copy">副券<p><?php echo $this->_tpl_vars['vipcard_info']['starttime']; ?>
<br><?php echo $this->_tpl_vars['vipcard_info']['endtime']; ?>
</p>
					    <?php if ($this->_tpl_vars['vipcard_info']['usagesid'] == ''): ?>
									     <p style="margin-top: 5px;">未领用</p>
									 <?php else: ?>
									     <p style="margin-top: 5px;"><?php echo $this->_tpl_vars['vipcard_info']['usagesstatus']; ?>
</p>
									 <?php endif; ?>
					    </div>
					    <i></i>
					</div></a>
		   		  <?php endforeach; else: ?>
					    <div>
					      <p class="msgbody" style="font-size: 30px;text-align: center;margin-top: 20px;"><span class="iconfont icon-tishi" style="color: #fe4401;font-size: 1em;"></span>本店铺暂时没有设置卡券!<br> 
						  </p>  
	   	        </div>
		   		  <?php endif; unset($_from); ?>
		   		  <div style="border-top: 1px solid #e8e8e8;">
		            </div>
              </div>
            </div>
            <!--complaintbox-->
              <!-- <div class="blank20"></div>
              	          <div class="safe-tishi border hui">
              	            <p class="fw"> 特别提示：</p>
              	            <ul>
              	              <li>1.当您从购物车中去结算时，在订单确认页面可以选择（或输入）您的现金券券号，获得相应的优惠。</li>
              	              <li>2.每个订单限使用一张现金券，联营代发（品牌季）商品订单除外。</li>
              	              <li>3.现金券有不同的类型，如仅限某品牌、某品类使用的现金券等。</li>
              	              <li>4.请注意：现金券是有过期时间的哦！请在过期之前使用。</li>
              	              <li>5.现金券在激活状态下才能使用，已激活且未过期的现金券在您的现金券列表中状态显示为“未使用”。</li>
              	              <li>6.若您获得满额返券的订单发生退货，因该订单所返的所有现金券都将被取消。</li>
              	              <li>7.当您使用现金券购买的商品发生退货时，将不会退还该现金券分摊优惠至每个商品中的金额。</li>
              	              <li>8.独家品牌券在购买芙优润、梵柏莎、水果诱惑、悦己美、颜绯、凯莉丝汀、隐泉之语、肌御坊、优仪肽、河马家、花田色、
              	                
              	                净颜小筑这12个独家品牌商品时可使用。</li>
              	            </ul>
              	          </div> -->
          </div>
        </div>
        <!--person-right 个人中心右侧-->
      </div>
      <!---personbox 个人中心-->
    </div>
  </div>
  <!--cont 主体-->
  <div class="blank90"></div>
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
<script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
</html>
<?php /* Smarty version 2.6.18, created on 2017-04-19 16:20:06
         compiled from submitorder.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'submitorder.tpl', 44, false),)), $this); ?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $this->_tpl_vars['supplier_info']['suppliername']; ?>
-立即购买</title>
<link href="/public/pc/css/bootstrap.min.css" rel="stylesheet">
<link href="/public/pc/css/public.css" rel="stylesheet">
<link href="/public/pc/css/order.css" rel="stylesheet">
<link href="/public/pc/css/person.css" rel="stylesheet">
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
  <!--head 头部-->
  <div class="blank20"></div>
  <div class="cont">
    <div class="container">
      <div class="order-index">
        <div class="order-tit clearfix">
          <h3 class="pull-left">填写订单</h3>
          <ul class="pull-right order-tit-step">
            <li><a href="javascript:;">查看购物车<span></span></a></li>
            <li><a href="javascript:;" class="red w105">填写订单 <span></span></a></li>
            <li><a href="javascript:;">确认订单，去付款<span></span></a></li>
            <li><a href="javascript:;">完成购买</a></li>
          </ul>
        </div>
        <!--order-tit-->
        <div class="row-item-tit clearfix border fill-tit">
          <p>请填写并核对以下信息</p>
        </div>
        <!--row-item-tit-->
        <div class="blank20"></div>
        <form method="post" name="frm" action="/confirmpayment.php">
          <input name="token" value="<?php echo $this->_tpl_vars['token']; ?>
" type="hidden">
          <input name="record" value="<?php echo $this->_tpl_vars['orderid']; ?>
" type="hidden">
          <input id="sumorderstotal" value="<?php echo $this->_tpl_vars['total_money']; ?>
" type="hidden">
          <input id="deliveraddress_count" value="<?php echo count($this->_tpl_vars['deliveraddress']); ?>
" type="hidden">
        <div class="fill-first border">
        <?php if (count($this->_tpl_vars['deliveraddress']) == 0): ?>
                <div class="fill-first-tit">
                  <h4 class="f16">您还没有收货地址，赶快去创建吧！</h4>
                  <a href="/deliveraddress.php"><input type="button" value="添加收货地址" class="btn btn160 btn-danger f12 fw contolr-sur"></a>
                </div>
                <?php else: ?>
                <input name="deliveraddress" value="<?php echo $this->_tpl_vars['deliveraddress']['recordid']; ?>
" type="hidden"/>
          <div class="fill-first-tit">
            <h4 class="f16">收货人：<?php echo $this->_tpl_vars['deliveraddress']['consignee']; ?>
</h4>
            <p class="niceform chklist">
              联系电话：<?php echo $this->_tpl_vars['deliveraddress']['mobile']; ?>
</p>
          </div>
          <?php if ($this->_tpl_vars['tradestatus'] == 'pretrade'): ?>
          <div class="fill-first-tit">
            <h4 class="f16">收货地址：<?php echo $this->_tpl_vars['deliveraddress']['province']; ?>
<?php echo $this->_tpl_vars['deliveraddress']['city']; ?>
<?php echo $this->_tpl_vars['deliveraddress']['district']; ?>
</h4>
            <h4><?php echo $this->_tpl_vars['deliveraddress']['shortaddress']; ?>
</h4>
          </div>
          <?php else: ?>
          <div class="fill-first-tit">
           
            <h4 class="f16">收货地址：<?php echo $this->_tpl_vars['deliveraddress']['province']; ?>
<?php echo $this->_tpl_vars['deliveraddress']['city']; ?>
<?php echo $this->_tpl_vars['deliveraddress']['district']; ?>
</h4>
            <h4><?php echo $this->_tpl_vars['deliveraddress']['shortaddress']; ?>
</h4>
            <a href="deliveraddress.php?orderid=<?php echo $this->_tpl_vars['orderid']; ?>
" type="button" class="btn btn-danger btn120" style="margin-bottom: 20px;">更改收货地址</a>
          </div>
            <?php endif; ?>
          <?php endif; ?>
        </div>
        <!--fill-first 填写订单 第一次登录时-->
        <div class="blank20"></div>
        <div class="row-item-tit clearfix border">
          <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
              <td width="13%"></td>
              <td width="47%" align="left">商品信息</td>
              <td width="21%">数量</td>
              <td width="19%">订单金额</td>
            </tr>
          </table>
        </div>
        <!--row-item-tit-->
        <div class="blank20"></div>
        <?php $_from = $this->_tpl_vars['shoppingcarts']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['shoppingcarts'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['shoppingcarts']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['shoppingcart_info']):
        $this->_foreach['shoppingcarts']['iteration']++;
?>
        <div class="row-item row-item-shop">
          <div class="shop-body border">
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
              <tr>
                <td width="13%"><a href="javascript:;" target="_blank"><img src="<?php echo $this->_tpl_vars['shoppingcart_info']['productthumbnail']; ?>
" width="100" height="100"></a></td>
                <td width="47%" align="left"><p><a href="javascript:;" target="_blank"><?php echo $this->_tpl_vars['shoppingcart_info']['productname']; ?>
</a></p>
                <?php if ($this->_tpl_vars['shoppingcart_info']['propertydesc'] != ""): ?>
                <p class="greey">属性：<?php echo $this->_tpl_vars['shoppingcart_info']['propertydesc']; ?>
</p></td>
                    <?php endif; ?>
                  
                <td width="21%"><div>
                    <p class="numcontrol arial"><em class="f12" style="background: #eee"><?php echo $this->_tpl_vars['shoppingcart_info']['quantity']; ?>
</em></p>
                  </div></td>
                <td width="19%"><p class=" arial"><?php if ($this->_tpl_vars['shoppingcart_info']['zhekou'] != ''): ?><?php if ($this->_tpl_vars['shoppingcart_info']['activitymode'] == '1'): ?>底价<?php else: ?>活动价<?php endif; ?>：<?php echo $this->_tpl_vars['shoppingcart_info']['shop_price']; ?>
<?php else: ?>单价： ¥<?php echo $this->_tpl_vars['shoppingcart_info']['shop_price']; ?>
<?php endif; ?></p></td>
              </tr>
            </table>
            <div class="bot-line"></div>
          </div>
        </div>
        <?php endforeach; endif; unset($_from); ?>
        </form>
      </div>
      <!--row-item-->
      <div class="blank20"></div>
      <div class="bz border">
        <div class="bz-r">
          <p class="pos-right">共计商品<span class="red p-lr5 arial"><?php echo $this->_tpl_vars['total_quantity']; ?>
</span> 件<!-- <span class="m-l15">合计：<em class="arial">￥</em><em class="arial f24 pricenum"><?php echo $this->_tpl_vars['shoppingcart_info']['total_price']; ?>
</em></span> --></p>
        </div>
        <div class="bzlist">
          <h6>- 添加备注</h6>
          <div class="bz-box  border">
            <textarea style="color: #666;" <?php if ($this->_tpl_vars['tradestatus'] == 'pretrade'): ?>disabled="disabled"<?php endif; ?> class="textarea border text gray-c" id="buyermemo" name="buyermemo" placeholder="这里您可以留言"><?php echo $this->_tpl_vars['customersmsg']; ?>
</textarea>
          </div>
        </div>
        <div class="bzlist">
          <h6>- 索要发票</h6>
          <?php if ($this->_tpl_vars['tradestatus'] == 'pretrade'): ?>
                <div class="bz-box border mt-5 bz-form">
                  <p><span>发票抬头：</span>
                    <input type="text" class="text w300" value="<?php if ($this->_tpl_vars['fapiao'] == ''): ?>无需发票<?php else: ?><?php echo $this->_tpl_vars['fapiao']; ?>
<?php endif; ?>" disabled>
                    <input name="fapiao" value="<?php echo $this->_tpl_vars['fapiao']; ?>
" type="hidden"/>
                  </p>
                </div>
              <?php else: ?>
                <?php if ($this->_tpl_vars['total_money'] > 99): ?>
                <div class="bz-box border mt-5 bz-form">
                  <p><span>发票抬头：</span>
                  <a href="fapiao.php" class="mui-navigate-right fapiao">
                    <input type="text" class="text w300" value="<?php if ($this->_tpl_vars['fapiao'] == ''): ?>无需发票<?php else: ?><?php echo $this->_tpl_vars['fapiao']; ?>
<?php endif; ?>" disabled></a>
                    <input name="fapiao" value="<?php echo $this->_tpl_vars['fapiao']; ?>
" type="hidden"/>
                  </p>
                </div>
                <?php else: ?>
                  <div class="bz-box border mt-5 bz-form">
                  <p><span>发票抬头：</span>
                    <span>*发票：</span>订单总额&nbsp;<span class="price">¥100</span>&nbsp;以上,可以开发票*</span>
                    <input name="fapiao" value="" type="hidden"/>
                  </p>
                </div>
                <?php endif; ?>
              <?php endif; ?>
        </div>
        <div class="blank20"></div>
        <p class="text-right ">您需支付商品总金额：<span class="red arial">￥<em class="f24 arial"><?php echo $this->_tpl_vars['total_money']; ?>
</em></span></p>
        <p class="text-right mt-10">
        <?php if ($this->_tpl_vars['allowpayment'] == 'true'): ?>
          <input type="button" value="去付款" class="f14 btn btn-danger btn-lg btn160 confirmpayment">
          <?php endif; ?>
          
        </p>
      </div>
      <!--bz等信息-->
    </div>
    <!--order-index 购物车主页-->
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
<script type="text/javascript">
<?php echo '
$(function(){
  $(\'.confirmpayment\').click(function ()
          {
            var deliveraddress_count = $("#deliveraddress_count").val();
            if (deliveraddress_count != "0")
            {
              document.frm.submit();
            }
            else
            {
              alert("警告", "请先创建收货地址，谢谢！", "error");
            }
  });
});
'; ?>

</script>
</html>
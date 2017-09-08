<?php /* Smarty version 2.6.18, created on 2017-04-20 18:06:26
         compiled from appraise_submit.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'floatval', 'appraise_submit.tpl', 76, false),array('modifier', 'intval', 'appraise_submit.tpl', 79, false),)), $this); ?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php if ($this->_tpl_vars['orderinfo']['appraisestatus'] == 'yes'): ?>查看评价<?php else: ?>去评价<?php endif; ?></title>
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
          <h3 class="pull-left"><?php if ($this->_tpl_vars['orderinfo']['appraisestatus'] == 'yes'): ?>查看评价<?php else: ?>去评价<?php endif; ?></h3>
          <input id="orderid" name="orderid" value="<?php echo $this->_tpl_vars['orderinfo']['orderid']; ?>
" type="hidden" > 
          <input id="tradestatus" name="tradestatus" value="<?php echo $this->_tpl_vars['orderinfo']['tradestatus']; ?>
" type="hidden" > 
          <input id="notify" value="0" type="hidden" >
        </div>
        <div class="row-item-tit clearfix border fill-tit">
          <p>订单信息</p>
        </div>
        <!--row-item-tit-->
        <div class="fill-first border">
          <div class="fill-first-tit">
            <h4 class="f16">订单号：<?php echo $this->_tpl_vars['orderinfo']['order_no']; ?>
</h4>
            <h4 class="f16">订单状态：<?php echo $this->_tpl_vars['orderinfo']['order_status']; ?>
</h4>
            <h4 class="f16">订单总额：￥<?php echo $this->_tpl_vars['orderinfo']['sumorderstotal']; ?>
</h4>
          </div>
          <div class="fill-first-tit">
            <h4 class="f16">付款时间：<?php echo $this->_tpl_vars['orderinfo']['paymenttime']; ?>
</h4>
            <h4 class="f16">确认收货时间：<?php echo $this->_tpl_vars['orderinfo']['confirmreceipt_time']; ?>
</h4>
            <h4 class="f16" style="color: #c9302c;">*评价能提高您的积分，将获得平台更高的优惠政策！</h4>
          </div>
        </div>
        <!--fill-first 填写订单 第一次登录时-->
        <div class="blank20"></div>
        <div class="row-item-tit clearfix border">
          <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
              <td width="13%"></td>
              <td width="36%" align="left">商品信息</td>
              <td width="21%">数量</td>
              <td width="19%">订单金额</td>
              <td width="11%">操作</td>
            </tr>
          </table>
        </div>
        <!--row-item-tit-->
        <div class="blank20"></div>
        <?php $_from = $this->_tpl_vars['orderinfo']['orders_products']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['orders_products'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['orders_products']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['orders_products_info']):
        $this->_foreach['orders_products']['iteration']++;
?>
        <div class="row-item row-item-shop">
          <div class="shop-body border">
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
              <tr>
                <td width="13%"><a href="javascript:;" target="_blank"><img src="<?php echo $this->_tpl_vars['orders_products_info']['productthumbnail']; ?>
" width="100" height="100"></a></td>
                <td width="36%" align="left"><p><a href="javascript:;" target="_blank"><?php echo $this->_tpl_vars['orders_products_info']['productname']; ?>
</a></p>
                <?php if ($this->_tpl_vars['orders_products_info']['propertydesc'] != ""): ?>
                <p class="greey">属性：<?php echo $this->_tpl_vars['orders_products_info']['propertydesc']; ?>
</p></td>
                <?php endif; ?>
                <td width="21%"><div>
                    <p class="numcontrol arial"><em class="f12" style="background: #eee"><?php echo $this->_tpl_vars['orders_products_info']['quantity']; ?>
</em></p>
                  </div></td>
                <td width="19%"><p class=" arial">
                <?php if ($this->_tpl_vars['orders_products_info']['zhekou'] != '' && ((is_array($_tmp=$this->_tpl_vars['orders_products_info']['zhekou'])) ? $this->_run_mod_handler('floatval', true, $_tmp) : floatval($_tmp)) > 0): ?>
                <?php if ($this->_tpl_vars['orders_products_info']['activitymode'] == '1'): ?>底价<?php else: ?>活动价<?php endif; ?>：¥<?php echo $this->_tpl_vars['orders_products_info']['shop_price']; ?>
<?php else: ?>单价： ¥<?php echo $this->_tpl_vars['orders_products_info']['shop_price']; ?>
<?php endif; ?></p>

                <?php if (floatval($this->_tpl_vars['orders_products_info']['postage']) > 0 && ( intval($this->_tpl_vars['orders_products_info']['includepost']) == 0 || intval($this->_tpl_vars['orders_products_info']['includepost']) > intval($this->_tpl_vars['orders_products_info']['productallcount']) )): ?>
                  <p class='arial' style="color: #c9302c">
                    邮费：
                    <span class="price">
                      ¥<?php if (intval($this->_tpl_vars['orders_products_info']['mergepostage']) == 1): ?><?php echo $this->_tpl_vars['orders_products_info']['postage']; ?>
<?php else: ?><?php echo $this->_tpl_vars['orders_products_info']['postage']*$this->_tpl_vars['orders_products_info']['quantity']; ?>
<?php endif; ?>
                    </span>
                    <?php if (intval($this->_tpl_vars['orders_products_info']['includepost']) > 0): ?>
                      <span style="color:#878787;margin-left:10px;">(<?php echo $this->_tpl_vars['orders_products_info']['includepost']; ?>
件包邮)</span>
                    <?php endif; ?>
                  </p>
                <?php endif; ?>
                </td>
                <td width="11%">
                  <?php if ($this->_tpl_vars['orders_products_info']['praiseid'] != ''): ?>
                      <p>已评价</p>
                  <?php else: ?>
                    <a href="appraise_product_submit.php?record=<?php echo $this->_tpl_vars['orders_products_info']['id']; ?>
" type="button" class="btn btn-danger btn-sm btn-p10">去评价</a>
                  <?php endif; ?> 
                </td>
              </tr>
            </table>
            <div class="bot-line"></div>
          </div>
        </div>
        <?php endforeach; endif; unset($_from); ?>
      </div>
    </div>
    <!--order-index-->
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
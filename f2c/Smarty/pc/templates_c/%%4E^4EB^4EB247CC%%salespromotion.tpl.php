<?php /* Smarty version 2.6.18, created on 2017-04-12 14:12:36
         compiled from salespromotion.tpl */ ?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $this->_tpl_vars['supplier_info']['suppliername']; ?>
-促销活动</title>
  <link href="/public/pc/css/bootstrap.min.css" rel="stylesheet">
  <link href="/public/pc/css/public.css" rel="stylesheet">
  <link href="/public/pc/css/person.css" rel="stylesheet">
  <link href="/public/pc/css/seckill_area.css" rel="stylesheet">
  <!--[if lt IE 9]>
  <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'leftbar.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  <!--左侧悬浮导航-->
  <div id="warp">
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <!--cont 主体-->
    <!-- 秒杀专区 -->
    <div class='seckill_area'>
      <div class='seckill_tit'>
        <h4>促销活动</h4>
        <img src="/public/pc/images/seckill3.png">
      </div>
      <div class='clearfix seckill_goods'>
        <ul>
        <?php $_from = $this->_tpl_vars['salesactivitylist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['salesactivitys'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['salesactivitys']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['salesactivityid'] => $this->_tpl_vars['salesactivity_info']):
        $this->_foreach['salesactivitys']['iteration']++;
?> 
          <li>
            <a href='salesactivity.php?record=<?php echo $this->_tpl_vars['salesactivity_info']['id']; ?>
'><img src="<?php echo $this->_tpl_vars['salesactivity_info']['homepage']; ?>
"></a>
            <div>
              <span class="ms_stop_tit" style="width: 100%;height:122px;display: inline-block;white-space:normal;word-break:break-all;"><?php echo $this->_tpl_vars['salesactivity_info']['activityname']; ?>
</span>
              <!-- <p style="color: #cc3300;margin-top: 7px;">仅剩<span class='num'>2</span>件</p>
              <p></p>
              <p>秒杀价&nbsp;<span class='fh'>&yen;</span><em>11</em></p>
              <p>原价<del>&yen;110</del></p> -->
              <a style="margin-top: 30px;" class='btn_ms start' href="salesactivity.php?record=<?php echo $this->_tpl_vars['salesactivity_info']['id']; ?>
">马上进入</a>
            </div>
          </li>
        <?php endforeach; endif; unset($_from); ?> 
        </ul>
      </div>
    </div>
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
</body>
<script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
<script src="/public/pc/js/jquery.lazyload.min.js"></script> 
<script src="/public/pc/js/index.js"></script>
</html>
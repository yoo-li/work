<?php /* Smarty version 2.6.18, created on 2017-08-25 15:34:06
         compiled from submitorder.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'submitorder.tpl', 134, false),array('modifier', 'floatval', 'submitorder.tpl', 207, false),array('modifier', 'intval', 'submitorder.tpl', 250, false),array('modifier', 'string_format', 'submitorder.tpl', 254, false),)), $this); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
    <title>确认订单</title>
    <link href="public/css/mui.css" rel="stylesheet"/>
    <link href="public/css/public.css" rel="stylesheet"/>
    <link href="public/css/iconfont.css" rel="stylesheet"/>
    <link href="public/css/mui.picker.css" rel="stylesheet"/>
    <link href="public/css/mui.listpicker.css" rel="stylesheet"/>
    <link href="public/css/mui.dtpicker.css" rel="stylesheet"/>
    <link href="public/css/sweetalert.css" rel="stylesheet"/>
    <script src="public/js/mui.min.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" src="public/js/jweixin.js"></script>
    <script src="public/js/zepto.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="public/js/mui.picker.js"></script>
    <script src="public/js/mui.listpicker.js"></script>
    <script src="public/js/mui.dtpicker.js"></script>
    <script src="public/js/utils.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" src="public/js/sweetalert.min.js"></script>
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

        .mui-radio.mui-left label {
            padding-right: 3px;
            padding-left: 35px;
        }

        .mui-radio.mui-left input[type=\'radio\'] {
            left: 3px;
        }

        .mui-table-view .mui-media-object {
            line-height: 84px;
            max-width: 84px;
            height: 84px;
        }

        .mui-input-row {
            margin: 2px;
        }

        .mui-ellipsis {
            line-height: 20px;
            margin-bottom: 0px;
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

        .mui-radio input[type=\'radio\'], .mui-checkbox input[type=\'checkbox\'] {
            top: 0px;
        }

        .mui-table-view-cell .mui-table-view-label {
            width: 60px;
            text-align: right;
            display: inline-block;
        }

        #expectedconsumptiontime {
            line-height: 25px;
            width: 100%;
            height: 25px;
            margin-bottom: 0px;
            padding: 2px 5px;
            font-size: 12px;
        }
        .mui-bar-tab .mui-tab-item.mui-active{
            color: #fb3e21 !important;
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
            <a class="mui-icon mui-icon-back mui-pull-left" href="<?php echo $this->_tpl_vars['returnbackatcion']; ?>
"></a>
            <h1 class="mui-title">确认订单</h1>
        </header>
        <nav class="mui-bar mui-bar-tab" style="height:40px;line-height:40px;">
            <div class="mui-tab-item" style="width:70%;color:#929292;">
						<span class="mui-tab-label">
							<div class="mui-pull-right" style="line-height: 20px;">
								合计：<span class="price" id="total_money">¥<?php echo $this->_tpl_vars['total_money']; ?>
</span>元<br>共计&nbsp;<span class="price" id="total_quantity"><?php echo $this->_tpl_vars['total_quantity']; ?>
</span>&nbsp;件商品
							</div>
					    </span>
            </div>
            <?php if ($this->_tpl_vars['allowpayment'] == 'true'): ?>
                <a class="mui-tab-item confirmpayment" href="#" style="width:30%">
                    <span class="mui-icon iconfont icon-queren01 button-color">&nbsp;确认</span>
                </a>
            <?php endif; ?>
        </nav>

        <div id="pullrefresh" class="mui-content mui-scroll-wrapper" style="top: 5px;bottom: 50px;">
            <div class="mui-scroll">
                <form method="post" name="frm" action="/confirmpayment.php">
                    <input name="token" value="<?php echo $this->_tpl_vars['token']; ?>
" type="hidden">
                    <input name="record" value="<?php echo $this->_tpl_vars['orderid']; ?>
" type="hidden">
                    <input id="sumorderstotal" value="<?php echo $this->_tpl_vars['total_money']; ?>
" type="hidden">
                    <input id="deliveraddress_count" value="<?php echo count($this->_tpl_vars['deliveraddress']); ?>
" type="hidden">
                    <div class="mui-card" style="margin: 0 3px;">
                        <ul class="mui-table-view">
                            <?php if (count($this->_tpl_vars['deliveraddress']) == 0): ?>
                                <li class="mui-table-view-cell">
                                    <a href="/deliveraddress.php" class="mui-navigate-right deliveraddress">
                                        <div class="mui-media-body  mui-pull-left">
                                            <span class="mui-table-view-label">收货地址：</span> 您还没有收货地址，赶快去创建吧！
                                        </div>
                                    </a>
                                </li>
                            <?php else: ?>
                                <input name="deliveraddress" value="<?php echo $this->_tpl_vars['deliveraddress']['recordid']; ?>
" type="hidden"/>
                                <li class="mui-table-view-cell">
                                    <div class="mui-media-body  mui-pull-left">
                                        <span class="mui-table-view-label">收货人：</span><?php echo $this->_tpl_vars['deliveraddress']['consignee']; ?>

                                    </div>
                                    <div class="mui-media-body mui-pull-right">
                                        <?php echo $this->_tpl_vars['deliveraddress']['mobile']; ?>

                                    </div>
                                </li>
                                <?php if ($this->_tpl_vars['tradestatus'] == 'pretrade'): ?>
                                    <li class="mui-table-view-cell">
                                        <div class="mui-media-body  mui-pull-left">
                                            <span class="mui-table-view-label">收货地址：</span><?php echo $this->_tpl_vars['deliveraddress']['province']; ?>
<?php echo $this->_tpl_vars['deliveraddress']['city']; ?>
<?php echo $this->_tpl_vars['deliveraddress']['district']; ?>

                                            <br>
                                            <span class="mui-table-view-label">&nbsp;</span><?php echo $this->_tpl_vars['deliveraddress']['shortaddress']; ?>

                                        </div>
                                    </li>
                                <?php else: ?>
                                    <li class="mui-table-view-cell">
                                        <a href="deliveraddress.php?orderid=<?php echo $this->_tpl_vars['orderid']; ?>
" class="mui-navigate-right deliveraddress">
                                            <div class="mui-media-body  mui-pull-left">
                                                <span class="mui-table-view-label">收货地址：</span><?php echo $this->_tpl_vars['deliveraddress']['province']; ?>
<?php echo $this->_tpl_vars['deliveraddress']['city']; ?>
<?php echo $this->_tpl_vars['deliveraddress']['district']; ?>

                                                <br>
                                                <span class="mui-table-view-label">&nbsp;</span><?php echo $this->_tpl_vars['deliveraddress']['shortaddress']; ?>

                                            </div>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php if ($this->_tpl_vars['tradestatus'] == 'pretrade'): ?>
                                <li class="mui-table-view-cell">
                                    <div class="mui-media-body  mui-pull-left">
                                        <span class="mui-table-view-label">发票：</span><?php if ($this->_tpl_vars['fapiao'] == ''): ?>无需发票<?php else: ?><?php echo $this->_tpl_vars['fapiao']; ?>
<?php endif; ?>
                                        <input name="fapiao" value="<?php echo $this->_tpl_vars['fapiao']; ?>
" type="hidden"/>
                                    </div>
                                </li>
                            <?php else: ?>
                                <?php if ($this->_tpl_vars['total_money'] > 99): ?>
                                    <li class="mui-table-view-cell">
                                        <a href="fapiao.php" class="mui-navigate-right fapiao">
                                            <div class="mui-media-body  mui-pull-left">
                                                <span class="mui-table-view-label">发票：</span><?php if ($this->_tpl_vars['fapiao'] == ''): ?>无需发票<?php else: ?><?php echo $this->_tpl_vars['fapiao']; ?>
<?php endif; ?>
                                                <input name="fapiao" value="<?php echo $this->_tpl_vars['fapiao']; ?>
" type="hidden"/>
                                            </div>
                                        </a>
                                    </li>
                                <?php else: ?>
                                    <li class="mui-table-view-cell">
                                        <div class="mui-media-body  mui-pull-left">
                                            <span class="mui-table-view-label">发票：</span>订单总额&nbsp;<span class="price">¥100</span>&nbsp;以上,可以开发票
                                            <input name="fapiao" value="" type="hidden"/>
                                        </div>
                                    </li>
                                <?php endif; ?>
                            <?php endif; ?>

                            <div id="delivermode-wrap" class="mui-table-view-cell" style="margin-top:3px;display:none;">
                                <div id="delivermode-errormsg" class="mui-media-body" style="color:#cc3300;text-align:center">
                                </div>
                            </div>

                            <?php if (((is_array($_tmp=$this->_tpl_vars['addpostage'])) ? $this->_run_mod_handler('floatval', true, $_tmp) : floatval($_tmp)) > 0): ?>
                                <li class="mui-table-view-cell">
                                    <div class="mui-media-body">
                                        偏远地区附加邮费：<span class="price">¥<?php echo $this->_tpl_vars['addpostage']; ?>
</span>
                                    </div>
                                </li>
                            <?php endif; ?>

                            <li class="mui-table-view-cell" style="padding: 4px 15px;">
                                <textarea <?php if ($this->_tpl_vars['tradestatus'] == 'pretrade'): ?>disabled="disabled"<?php endif; ?> style="margin-bottom: 0px;padding: 5px;font-size: 15px;" class="mui-input-clear required" placeholder="这里您可以留言" id="buyermemo" name="buyermemo" rows="2"><?php echo $this->_tpl_vars['customersmsg']; ?>
</textarea>
                            </li>
                            <?php if ($this->_tpl_vars['allowpayment'] != 'true'): ?>
                                <div class="mui-table-view-cell"
                                     style="margin-top:3px;">
                                    <div  class="mui-media-body"
                                          style="color:#cc3300;text-align:center">
                                        <?php echo $this->_tpl_vars['errormsg']; ?>

                                    </div>
                                </div>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <div class="mui-card" style="margin: 5px 3px;">
                        <ul class="mui-table-view mui-table-view-chevron" style="color: #333;">
                            <?php $_from = $this->_tpl_vars['shoppingcarts']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['shoppingcarts'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['shoppingcarts']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['shoppingcart_info']):
        $this->_foreach['shoppingcarts']['iteration']++;
?>
                                <li class="mui-table-view-cell mui-left" style="min-height:104px;height: auto;  padding-right: 5px;">
                                    <img class="mui-media-object mui-pull-left" src="<?php echo $this->_tpl_vars['shoppingcart_info']['productthumbnail']; ?>
">
                                    <div class="mui-media-body">
                                        <p class='mui-ellipsis' style="color:#333"><?php echo $this->_tpl_vars['shoppingcart_info']['productname']; ?>
</p>
                                        <?php if ($this->_tpl_vars['shoppingcart_info']['propertydesc'] != ""): ?>
                                            <p class='mui-ellipsis'>属性：<?php echo $this->_tpl_vars['shoppingcart_info']['propertydesc']; ?>
</p>
                                        <?php endif; ?>
                                        <p class='mui-ellipsis'>数量：<?php echo $this->_tpl_vars['shoppingcart_info']['quantity']; ?>
件</p>
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
                                        <?php if (floatval($this->_tpl_vars['shoppingcart_info']['postage']) > 0 && ( intval($this->_tpl_vars['shoppingcart_info']['includepost']) == 0 || intval($this->_tpl_vars['shoppingcart_info']['includepost']) > intval($this->_tpl_vars['shoppingcart_info']['productallcount']) ) && ( floatval($this->_tpl_vars['supplier_info']['totalpricefreeshipping']) == 0 || floatval($this->_tpl_vars['supplier_info']['totalpricefreeshipping']) > $this->_tpl_vars['total_money'] ) && ( intval($this->_tpl_vars['supplier_info']['totalquantityfreeshipping']) == 0 || intval($this->_tpl_vars['supplier_info']['totalquantityfreeshipping']) > $this->_tpl_vars['total_quantity'] )): ?>
                                            <p class='mui-ellipsis'>
                                                邮费：
                                                <span class="price">
													¥<?php if (intval($this->_tpl_vars['shoppingcart_info']['mergepostage']) == 1): ?><?php echo $this->_tpl_vars['shoppingcart_info']['postage']; ?>
<?php else: ?><?php echo ((is_array($_tmp=$this->_tpl_vars['shoppingcart_info']['postage']*$this->_tpl_vars['shoppingcart_info']['quantity'])) ? $this->_run_mod_handler('string_format', true, $_tmp, "%0.2f") : smarty_modifier_string_format($_tmp, "%0.2f")); ?>
<?php endif; ?>
												</span>
                                                <?php if (intval($this->_tpl_vars['shoppingcart_info']['includepost']) > 0): ?>
                                                    <span style="color:#878787;margin-left:10px;">(<?php echo $this->_tpl_vars['shoppingcart_info']['includepost']; ?>

                                                        件包邮)</span>
                                                <?php endif; ?>
                                            </p>
                                        <?php endif; ?>
                                        <p class='mui-ellipsis'>
                                            小计：<span id="total_price_<?php echo $this->_tpl_vars['shoppingcart_info']['id']; ?>
" class="price">¥<?php echo $this->_tpl_vars['shoppingcart_info']['total_price']; ?>
</span>
                                        </p>
                                    </div>
                                </li>
                            <?php endforeach; endif; unset($_from); ?>
                        </ul>
                    </div>
                </form>
            </div>
        </div>
        <?php if ($this->_tpl_vars['supplierid'] == '12352'): ?>
        <?php else: ?>
            <nav class="mui-bar mui-bar-tab" style="height:40px;line-height:40px;bottom: 50px;">
                <ul class="mui-table-view" style="background-color: #efeff4;">
                    <li class="mui-table-view-cell mui-media">
                        <img class="img-responsive" src="/images/baozhang.png">
                    </li>
                </ul>
            </nav>
        <?php endif; ?>
    </div>
</div>
</div>

<script type="text/javascript">
    <?php echo '
    mui.init({
        pullRefresh: {
            container: \'#pullrefresh\'
        },
    });
    mui.ready(function ()
    {
        mui(\'#pullrefresh\').scroll();

        mui(\'.msgbody\').on(\'tap\', \'a\', function (e)
        {
            mui.openWindow({
                url: this.getAttribute(\'href\'),
                id: \'info\'
            });
        });

        mui(\'.mui-table-view\').on(\'tap\', \'a.deliveraddress\', function (e)
        {
            mui.openWindow({
                url: this.getAttribute(\'href\'),
                id: \'info\'
            });
        });
        mui(\'.mui-table-view\').on(\'tap\', \'a.fapiao\', function (e)
        {
            mui.openWindow({
                url: this.getAttribute(\'href\'),
                id: \'info\'
            });
        });
        mui(\'.mui-bar\').on(\'tap\', \'a.confirmpayment\', function (e)
        {
            var deliveraddress_count = $("#deliveraddress_count").val();
            if (deliveraddress_count != "0")
            {
                document.frm.submit();
            }
            else
            {
                sweetAlert("警告", "请先创建收货地址，谢谢！", "error");
            }

        });
        mui(\'header.mui-bar\').on(\'tap\', \'a.mui-icon-back\', function (e)
        {
            mui.openWindow({
                url: this.getAttribute(\'href\'),
                id: \'info\'
            });
        });

    });

    '; ?>

</script>
<script src="/public/js/baidu.js?_=20140821" type="text/javascript"></script>
</body>
</html>
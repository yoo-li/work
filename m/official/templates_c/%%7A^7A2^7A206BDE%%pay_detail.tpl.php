<?php /* Smarty version 2.6.18, created on 2017-08-16 17:16:37
         compiled from pay_detail.tpl */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
	<title>支付宴请</title>
	<link rel="stylesheet" href="/public/css/mui.min.css">
	<link href="/public/css/public.css" rel="stylesheet" />
	 <link href="/public/css/common.css" rel="stylesheet" />
	<link href="/public/css/iconfont.css" rel="stylesheet"/>
	<link href="/public/css/parsley.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="/public/css/mui.picker.min.css" />
	<link href="/public/css/mui.poppicker.css" rel="stylesheet" />
	<link href="/public/css/sweetalert.css" rel="stylesheet"/>

	<script src="/public/js/mui.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="/public/js/zepto.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="/public/js/utils.js" type="text/javascript" charset="utf-8"></script>

	<script src="/public/js/parsley.min.js"></script>
	<script src="/public/js/parsley.zh_cn.js"></script>
	<script type="text/javascript" src="/public/js/sweetalert.min.js"></script>
	<script src="/public/js/mui.picker.min.js"></script>
	<script src="/public/js/mui.poppicker.js"></script>
	<script type="text/javascript" charset="utf-8" src="/public/js/cordova.js"></script>
	<script type="text/javascript" charset="utf-8" src="/public/js/jquery-1.11.3.min.js"></script>
	<style type="text/css">
	<?php echo '
		header.mui-bar{
			background: #1e63b7;
		}
		header .mui-title, header a{
			color:#dfbc84;
		}
		.mui-input-row label{
			line-height: 21px;
			padding:10px 10px;
			text-align:right;
		}
	'; ?>

	</style>
	</head>
	<body>
		<div class="mui-inner-wrap">
		<header class="mui-bar mui-bar-nav" style="padding-right: 15px;">
		    <a class="mui-icon mui-action-back mui-icon-back mui-pull-left"></a>
			<h1 class="mui-title">支付详情</h1>
		</header>
         <div id="pullrefresh" class="mui-content mui-scroll-wrapper" style="padding-top: 45px;">
                 <div class="mui-scroll">
					     <form class="mui-input-group" name="frm" id="frm" method="post" action=""  parsley-validate>
					     <div class="mui-card" style="margin: 3px 3px;">
		                    <ul class="mui-table-view" style="padding-top: 5px;padding-bottom: 5px;">
	                                <div class="mui-input-row" style="margin-top:3px;">
	                                    <label>宴请编号:</label>
	                                    <input value="<?php echo $this->_tpl_vars['list']['mall_officialtreats_no']; ?>
" type="text" style="font-size: 12px;"
	                                           class="mui-input-clear required" disabled >
	                                </div>
	                                <div class="mui-input-row" style="margin-top:3px;">
	                                    <label>提交人:</label>
	                                    <input value="<?php echo $this->_tpl_vars['list']['profileid']; ?>
" type="text" style="font-size: 12px;"
	                                           class="mui-input-clear required" disabled>
	                                </div>
	                                <div class="mui-input-row" style="margin-top:3px;">
	                                   <label>实际宴请地点:</label>
	                                   <input value="<?php echo $this->_tpl_vars['list']['address']; ?>
" type="text" style="font-size: 12px;" class="mui-input-clear required" disabled>
	                                </div>
	                                <div class="mui-input-row" style="margin-top:3px;">
	                                   <label>联系人:</label>
	                                   <input value="<?php echo $this->_tpl_vars['list']['contact']; ?>
" type="text" style="font-size: 12px;" class="mui-input-clear required" disabled>
	                                </div>
	                                <div class="mui-input-row" style="margin-top:3px;">
	                                   <label>联系电话:</label>
	                                   <input value="<?php echo $this->_tpl_vars['list']['mobile']; ?>
" type="text" style="font-size: 12px;" class="mui-input-clear required" disabled>
	                                </div>
	                                <div class="mui-input-row" style="margin-top:3px;">
	                                   <label>商户地址:</label>
	                                   <input value="<?php echo $this->_tpl_vars['list']['companyaddress']; ?>
" type="text" style="font-size: 12px;" class="mui-input-clear required" disabled>
	                                </div>
	                                <div class="mui-input-row" style="margin-top:3px;">
	                                   <label>开户行:</label>
	                                   <input value="<?php echo $this->_tpl_vars['list']['bankname']; ?>
" type="text" style="font-size: 12px;" class="mui-input-clear required" disabled>
	                                </div>
	                                <div class="mui-input-row" style="margin-top:3px;">
	                                   <label>开户名:</label>
	                                   <input value="<?php echo $this->_tpl_vars['list']['accountname']; ?>
" type="text" style="font-size: 12px;" class="mui-input-clear required" disabled>
	                                </div>
	                                <div class="mui-input-row" style="margin-top:3px;">
	                                   <label>银行账号:</label>
	                                   <input value="<?php echo $this->_tpl_vars['list']['bankaccount']; ?>
" type="text" style="font-size: 12px;" class="mui-input-clear required" disabled>
	                                </div>

								<!-- <input type="hidden" value="<?php echo $this->_tpl_vars['id_now']; ?>
" id = "id_now"> -->
		                    </ul>
                     </div>
                     </form>
                     <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'copyright.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                </div>
            </div>

	</body>
	</html>
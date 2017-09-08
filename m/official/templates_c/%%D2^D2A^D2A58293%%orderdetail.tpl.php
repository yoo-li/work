<?php /* Smarty version 2.6.18, created on 2017-07-26 09:25:31
         compiled from orderdetail.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'floatval', 'orderdetail.tpl', 178, false),array('modifier', 'intval', 'orderdetail.tpl', 184, false),array('modifier', 'string_format', 'orderdetail.tpl', 197, false),array('modifier', 'count', 'orderdetail.tpl', 254, false),)), $this); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
	<title>订单信息</title>
	<link rel="stylesheet" href="/public/css/mui.min.css">
    <link href="/public/css/public.css" rel="stylesheet" />
	<link href="/public/css/iconfont.css" rel="stylesheet"/> 
	<link href="/public/css/parsley.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="/public/css/mui.picker.min.css" /> 
	<link href="/public/css/mui.poppicker.css" rel="stylesheet" />
	<link href="/public/css/sweetalert.css" rel="stylesheet"/>

 	<link href="/public/css/wuliu.css" rel="stylesheet"/>
	
	<script src="/public/js/mui.min.js" type="text/javascript" charset="utf-8"></script> 
	<script src="/public/js/zepto.min.js" type="text/javascript" charset="utf-8"></script>  
    <script src="/public/js/utils.js" type="text/javascript" charset="utf-8"></script>  
    
    <script src="/public/js/parsley.min.js"></script>
    <script src="/public/js/parsley.zh_cn.js"></script>

    <script type="text/javascript" src="/public/js/sweetalert.min.js"></script>
    <script src="/public/js/mui.picker.min.js"></script> 
	<script src="/public/js/mui.poppicker.js"></script>
	<script type="text/javascript" charset="utf-8" src="/public/js/cordova.js"></script>
	<style>
		<?php echo '
		  
        .img-responsive{ display:block; height:auto; width:100%; }

        .mui-input-row label{
            line-height:21px;
            height:21px;
        }

        .menuicon{ font-size:1.2em; color:#fe4401; padding-right:10px; }

        .menuitem a{ font-size:1.1em; }

        #save_button{
            font-size:20px;
            color:#cc3300;
            padding-left:5px;
        }

        .mui-bar-tab .mui-tab-item .mui-icon{
            width:auto;
        }

        .mui-bar-tab .mui-tab-item, .mui-bar-tab .mui-tab-item.mui-active{
            color:#cc3300;
        }

        .mui-input-row label{
            text-align:right;
            width:30%;
        }

        .mui-input-row label ~ input, .mui-input-row label ~ select, .mui-input-row label ~ textarea{
            float:right;
            width:70%;
        }

        .mui-input-row label{
            line-height:21px;
            padding:10px 10px;
        }

        .mui-input-clear{
            font-size:12px;
        }

        input.parsley-success,
        select.parsley-success,
        textarea.parsley-success{
            color:#468847;
            background-color:#DFF0D8;
            border:1px solid #D6E9C6;
        }

        input.parsley-error,
        select.parsley-error,
        textarea.parsley-error{
            color:#B94A48;
            background-color:#F2DEDE;
            border:1px solid #EED3D7;
        }

        .parsley-errors-list{
            margin:2px 0 3px;
            padding:0;
            list-style-type:none;
            font-size:0.9em;
            line-height:0.9em;
            opacity:0;
            transition:all .3s ease-in;
            -o-transition:all .3s ease-in;
            -moz-transition:all .3s ease-in;
            -webkit-transition:all .3s ease-in;
        }

        .parsley-errors-list.filled{
            opacity:1;
        }

        .mui-table-view input[type=\'radio\']{
            line-height:21px;
            width:20px;
            margin-top:10px;
            height:30px;
            float:left;
            border:0;
            outline:0 !important;
            background-color:transparent;
            -webkit-appearance:none;
        }

        .mui-input-row label.radio{
            line-height:21px;
            width:30px;
            height:40px;
            float:left;
            text-align:left;
            padding:10px 3px;
        }

        .mui-table-view input[type=\'radio\']{
        }

        .mui-table-view input[type=\'radio\']:before{
            content:\'\\e411\';
        }

        .mui-table-view input[type=\'radio\']:checked:before{
            content:\'\\e441\';
        }

        .mui-table-view input[type=\'radio\']:checked:before{
            color:#007aff;
        }

        .mui-table-view input[type=\'radio\']:before{
            font-family:Muiicons;
            font-size:20px;
            font-weight:normal;
            line-height:1;
            text-decoration:none;
            color:#aaa;
            border-radius:0;
            background:none;
            -webkit-font-smoothing:antialiased;
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
 
	<div class="mui-inner-wrap">
		<header class="mui-bar mui-bar-nav" style="padding-right: 15px;">
		    <a class="mui-icon mui-action-back mui-icon-back mui-pull-left"></a> 
			<h1 class="mui-title">订单详情</h1>
		</header> 
         <div id="pullrefresh" class="mui-content mui-scroll-wrapper" style="padding-top: 45px;">
			 <div class="mui-card" style="margin: 0 3px;margin-top: 5px;" id="orders_products">
				 <ul class="mui-table-view mui-table-view-chevron" style="color: #333;">
					 <?php $_from = $this->_tpl_vars['officialtreat']['orders_products']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['orders_products'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['orders_products']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['orders_products_info']):
        $this->_foreach['orders_products']['iteration']++;
?>
						 <li class="mui-table-view-cell mui-left" style="min-height:104px;">
							 <img class="mui-media-object mui-pull-left"  src="<?php echo $this->_tpl_vars['orders_products_info']['productthumbnail']; ?>
">
							 <div class="mui-media-body">
								 <p class='mui-ellipsis' style="color:#333"><?php echo $this->_tpl_vars['orders_products_info']['productname']; ?>
</p>
								 <p class='mui-ellipsis'>属性：<?php echo $this->_tpl_vars['orders_products_info']['propertydesc']; ?>
</p>
								 <p class='mui-ellipsis'>数量：<?php echo $this->_tpl_vars['orders_products_info']['quantity']; ?>
件</p>
								 <p class='mui-ellipsis'><?php if ($this->_tpl_vars['orders_products_info']['zhekou'] != '' && ((is_array($_tmp=$this->_tpl_vars['orders_products_info']['zhekou'])) ? $this->_run_mod_handler('floatval', true, $_tmp) : floatval($_tmp)) > 0): ?><?php if ($this->_tpl_vars['orders_products_info']['activitymode'] == '1'): ?>底价<?php else: ?>活动价<?php endif; ?>：<span class="price">¥<?php echo $this->_tpl_vars['orders_products_info']['shop_price']; ?>
</span> <span style="color:#878787;margin-left:5px;text-decoration:line-through;">¥<?php echo $this->_tpl_vars['orders_products_info']['old_shop_price']; ?>
</span><?php else: ?>单价：<span class="price">¥<?php echo $this->_tpl_vars['orders_products_info']['shop_price']; ?>
</span><?php endif; ?></p>
								 <?php if ($this->_tpl_vars['orders_products_info']['activitymode'] == '1'): ?>
									 <p class='mui-ellipsis'>
										 砍价：<?php if ($this->_tpl_vars['orders_products_info']['bargains_count'] == 0): ?>还没有好友帮忙砍价<?php else: ?>已有 <?php echo $this->_tpl_vars['orders_products_info']['bargains_count']; ?>
 位好友帮忙砍价<?php endif; ?>
									 </p>
								 <?php endif; ?>
								 <?php if (floatval($this->_tpl_vars['orders_products_info']['postage']) > 0 && ( intval($this->_tpl_vars['orders_products_info']['includepost']) == 0 || intval($this->_tpl_vars['orders_products_info']['includepost']) > intval($this->_tpl_vars['orders_products_info']['productallcount']) )): ?>
									 <p class='mui-ellipsis'>
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
								 <?php if (floatval($this->_tpl_vars['orders_products_info']['postage']) > 0 && ( intval($this->_tpl_vars['orders_products_info']['includepost']) == 0 || intval($this->_tpl_vars['orders_products_info']['includepost']) > intval($this->_tpl_vars['orders_products_info']['productallcount']) )): ?>
									 <p class='mui-ellipsis'>小计：<span id="total_price_<?php echo $this->_tpl_vars['shoppingcart_info']['id']; ?>
" class="price">¥<?php echo ((is_array($_tmp=$this->_tpl_vars['orders_products_info']['total_price']+$this->_tpl_vars['orders_products_info']['postage'])) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.2f") : smarty_modifier_string_format($_tmp, "%.2f")); ?>
</span></p>
								 <?php else: ?>
									 <p class='mui-ellipsis'>小计：<span id="total_price_<?php echo $this->_tpl_vars['shoppingcart_info']['id']; ?>
" class="price">¥<?php echo $this->_tpl_vars['orders_products_info']['total_price']; ?>
</span></p>
								 <?php endif; ?>
							 </div>
						 </li>
					 <?php endforeach; endif; unset($_from); ?>
				 </ul>
			 </div>
                 <div class="mui-scroll">  
					     <form class="mui-input-group" name="frm" id="frm" method="post" action=""  parsley-validate> 
					     <div class="mui-card" style="margin: 3px 3px;">
		                    <ul class="mui-table-view" style="padding-top: 5px;padding-bottom: 5px;">

								<div class="mui-input-row" style="margin-top:3px;">
	                                        <label>审批路径:</label>
											<input id="authorizeevent" name="authorizeevent" value="<?php echo $this->_tpl_vars['officialtreat']['authorizeevent']; ?>
" type="hidden">
										    <input id="authorizeevent_text" name="authorizeevent_text" value="<?php echo $this->_tpl_vars['officialtreat']['authorizeevent_text']; ?>
" 
		                                           disabled  type="text" class="mui-input-clear"
		                                           maxlength="20" placeholder="请选择授权"> 
	                                    </div>	                             
	                                    <div class="mui-input-row" style="margin-top:3px;">
	                                        <label>下单日期:</label>
										    <input disabled id="treatdatetime" name="treatdatetime" value="<?php echo $this->_tpl_vars['officialtreat']['orderdatetime']; ?>
"  type="text" class="mui-input-clear required"
		                                           maxlength="20" placeholder="请输入宴请日期">
		                                     
	                                    </div>
										<div class="mui-input-row" style="margin-top:3px;">
											<label>订单号:</label>
											<input disabled required="required"  name="sumorderstotal"
												   value="<?php echo $this->_tpl_vars['officialtreat']['record']; ?>
" type="number" style="font-size: 12px;"
												   class="mui-input-clear required"  placeholder="">
										</div>
	                                    <div class="mui-input-row" style="margin-top:3px;">
	                                        <label>总金额:</label>
		                                    <input disabled required="required"  name="sumorderstotal"
		                                           value="<?php echo $this->_tpl_vars['officialtreat']['sumorderstotal']; ?>
" type="number" style="font-size: 12px;"
		                                           class="mui-input-clear required"  placeholder="">
	                                    </div>   
	                                         
		                       
		                    </ul>
                     </div>
                   
                    <div class="mui-card" style="margin: 3px 3px;">  
						<ul id="wuliuinfo_ul" class="mui-table-view" style="height:100%;background-color:#eeeeee;">
							<nav class="mui-bar mui-bar-tab" style="height:35px;line-height:35px;top: 44px;position: static;">
								<div>
									<span id="result-comname" class="smart-result-comname">审批流程</span>
									<span id="result-kuaidinum" class="smart-result-kuaidinum">审批</span>
								</div>
							</nav>
							<div class="smart-result" style="margin-bottom: 10px;" data-role="content" role="main">
								<div class="content-primary">

									<table id="queryResult" cellspacing="0" cellpadding="0">
										<?php $this->assign('approvals', $this->_tpl_vars['officialtreat']['approvals']); ?>
										<?php if (count($this->_tpl_vars['approvals']) > 0): ?>
											<?php $_from = $this->_tpl_vars['approvals']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['approvals'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['approvals']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['approval_info']):
        $this->_foreach['approvals']['iteration']++;
?>
											    <?php if ($this->_tpl_vars['approval_info']['pos'] == 'start'): ?>
											    	<tr class="even first-line">
											    <?php elseif ($this->_tpl_vars['approval_info']['pos'] == 'end'): ?>
											        <tr class="even last-line checked">
											    <?php else: ?>
											        <tr class="odd">
											    <?php endif; ?>
		                        	 		
												<td class="col1"><span class="result-date"><?php echo $this->_tpl_vars['approval_info']['date']; ?>
</span><span class="result-time"><?php echo $this->_tpl_vars['approval_info']['time']; ?>
</span></td><td class="colstatus"></td>
												<td class="col2"><span><?php echo $this->_tpl_vars['approval_info']['route']; ?>
</span></td>
												</tr>   
			                        	 	<?php endforeach; endif; unset($_from); ?> 
		                        	 	<?php else: ?>
											<tr>
												<td>
													<li class="mui-table-view-cell" style="padding-right:0px;" id="loading">
														<div class="mui-media-body" style="color:red;text-align:center;">
															<span class="mui-icon iconfont icon-loading1 mui-rotation"></span><span> 没有审批信息...</span>
														</div>
													</li>
												</td>
											</tr>
										<?php endif; ?>
									</table>
								</div>
							</div>
						</ul>  	
					</div>   
                    <div class="mui-card" style="margin: 3px 3px;">
						<h4 class="mui-content-padded" style="margin-bottom:0px;">关注人</h4> 
	                    <ul id="opinion_div" class="mui-table-view" style="padding-left: 10px;padding-bottom: 5px;">   
									<?php $_from = $this->_tpl_vars['officialtreat']['opinion_givennames']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['opinions'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['opinions']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['opinion_info']):
        $this->_foreach['opinions']['iteration']++;
?>
									<li style="float:left;padding: 8px 5px;text-align:center;"><img style="width:50px;height:50px;" src="<?php echo $this->_tpl_vars['opinion_info']['headimgurl']; ?>
"><br><?php echo $this->_tpl_vars['opinion_info']['givenname']; ?>
</li>
									<?php endforeach; endif; unset($_from); ?> 
						 </ul>			
					</div>
					<?php $this->assign('officialopinions', $this->_tpl_vars['officialtreat']['officialopinions']); ?>
					<?php if (count($this->_tpl_vars['officialopinions']) > 0): ?>
					<div class="mui-card" style="margin: 3px 3px;"> 
						 <h4 class="mui-content-padded" style="margin-bottom:0px;">关注意见</h4>
						 <ul id="wuliuinfo_ul" class="mui-table-view" style="height:100%;">
							<?php $_from = $this->_tpl_vars['officialopinions']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['officialopinions'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['officialopinions']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['officialopinion_info']):
        $this->_foreach['officialopinions']['iteration']++;
?>
							<li class="mui-table-view-cell" style="padding: 8px 5px;"> 			 	
								<div class="mui-media-body">			 		
									<img class="mui-media-object mui-pull-left" style="width:20px;height:20px;" src="<?php echo $this->_tpl_vars['officialopinion_info']['profile']['headimgurl']; ?>
">			 		
									<span style="text-align:left;display:inline-block;"><?php echo $this->_tpl_vars['officialopinion_info']['profile']['givenname']; ?>
</span> <span style="padding-left:20px;color:#999"><?php echo $this->_tpl_vars['officialopinion_info']['submitdatetime']; ?>
</span>		 		 	
								</div> 	
										 	
								<div class="mui-media-body" style="padding-left:30px;color:#4d4d4d"><?php echo $this->_tpl_vars['officialopinion_info']['opinion']; ?>
</div>			 	
							</li>
							<?php endforeach; endif; unset($_from); ?> 
						 </ul>	
					</div>  
					<?php endif; ?>

					<h4 class="mui-content-padded" style="margin-bottom:0px;height:1px;">&nbsp;</h4>
 				    </form>  
 				   <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'copyright.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
 				</div>
 		</div>
		 
	</div> 

<script type="text/javascript">  
	<?php echo '
	mui.init({
				 pullRefresh: {
					 container: \'#pullrefresh\' //待刷新区域标识，querySelector能定位的css选择器均可，比如：id、.class等 
				 },
			 });
	mui.ready(function ()
			  {
				  mui(\'#pullrefresh\').scroll();
				  mui(\'.mui-bar\').on(\'tap\', \'a\', function (e)
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
<?php /* Smarty version 2.6.18, created on 2017-08-11 15:39:31
         compiled from supplierdetail.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'supplierdetail.tpl', 226, false),)), $this); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
	<title>事务官</title>
	<link rel="stylesheet" href="/public/css/mui.min.css">
    <link href="/public/css/public.css" rel="stylesheet" />
     <link href="/public/css/common.css" rel="stylesheet" />
	<link href="/public/css/iconfont.css" rel="stylesheet"/> 
	<link href="/public/css/parsley.css" rel="stylesheet">
	
	<link href="/public/css/sweetalert.css" rel="stylesheet"/>
	 
	<script src="/public/js/mui.min.js" type="text/javascript" charset="utf-8"></script> 
	<script src="/public/js/zepto.min.js" type="text/javascript" charset="utf-8"></script>  
    <script src="/public/js/utils.js" type="text/javascript" charset="utf-8"></script>  
    
    <script src="/public/js/parsley.min.js"></script>
    <script src="/public/js/parsley.zh_cn.js"></script>

    <script type="text/javascript" src="/public/js/sweetalert.min.js"></script>
    
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
		.mui-table-view select {
		    height: 40px;  
		}
		
	 

		.msgbody  .mui-icon {
			margin-top: 3px;
			font-size: 1.1em;
			padding-right: 5px;
		}

		.msgbody {
			width: 100%;
			font-size: 1.4em;
			line-height: 25px;
			color: red;
			text-align: center;
			padding-top: 10px;
		}

		.msgbody a {
			font-size: 1.0em;
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
		    <a href="/official/index.php" class="mui-icon mui-icon-back mui-pull-left"></a>
			<h1 class="mui-title">申请加入企业</h1> 
		</header> 
         <div id="pullrefresh" class="mui-content mui-scroll-wrapper" style="padding-top: 50px;"> 
                 <div class="mui-scroll">   
  					 <div class="mui-card" style="margin: 0 3px;"> 
								 <input id="orderid" name="orderid"  value="<?php echo $this->_tpl_vars['orderinfo']['orderid']; ?>
" type="hidden" > 
								 <input id="tradestatus" name="tradestatus"  value="<?php echo $this->_tpl_vars['orderinfo']['tradestatus']; ?>
" type="hidden" > 
								 <input id="notify"  value="0" type="hidden" >
						         <ul class="mui-table-view">  
									         
			                                <li class="mui-table-view-cell"> 
													<div class="mui-media-body  mui-pull-left">
														<span class="mui-table-view-label">企业名称：</span><span><?php echo $this->_tpl_vars['supplier_info']['suppliername']; ?>
</span><br> 
														 
													</div>  
			                                </li>   
											 
												<li class="mui-table-view-cell"> 
														<div class="mui-media-body"> 
															<span class="mui-table-view-label">地址：</span><span><?php echo $this->_tpl_vars['supplier_info']['address']; ?>
</span><br>
															<span class="mui-table-view-label">联系人：</span><span><?php echo $this->_tpl_vars['supplier_info']['contact']; ?>
</span><br>
															<span class="mui-table-view-label">联系电话：</span><span><?php echo $this->_tpl_vars['supplier_info']['mobile']; ?>
</span><br> 
															
														</div> 
				                                </li> 
											 
								 </ul> 
								
					    </div>
						<?php if ($this->_tpl_vars['erromsg'] != ''): ?>
     					 <div class="mui-card" style="margin: 3px 3px;">   
						  		  <p class="msgbody"><span class="mui-icon iconfont icon-tishi"></span><?php echo $this->_tpl_vars['erromsg']; ?>
<br> </p> 
   					    </div>
						<?php endif; ?>
					    
					     <form class="mui-input-group" style="background-color:transparent;position:static;" name="frm" id="frm" method="post" action="supplierdetail.php"  parsley-validate> 
					     <div class="mui-card" style="margin: 3px 3px;">
		                    <ul class="mui-table-view" style="padding-top: 5px;padding-bottom: 5px;">
									    <input  name="type" value="submit" type="hidden">	
									    <input  name="supplierid" value="<?php echo $this->_tpl_vars['supplier_info']['supplierid']; ?>
" type="hidden">
										<?php if (count($this->_tpl_vars['officialapplys']) > 0): ?>
			                                <div class="mui-input-row" style="margin-top:3px;">
			                                    <label style="height:45px;">真实姓名:</label>
			                                    <input id="type" name="type" value="submit" type="hidden">
			                                    <input <?php if ($this->_tpl_vars['officialapplys']['approvalstatus'] == '0'): ?>disabled<?php endif; ?> required="required"  id="account" name="account"
			                                           value="<?php echo $this->_tpl_vars['officialapplys']['account']; ?>
" type="text" style="font-size: 12px;"
			                                           class="mui-input-clear required" maxlength="11" placeholder="请输入真实姓名"
			                                           parsley-error-message="请输入真实姓名">
			                                </div>	                             
			                                <div class="mui-input-row" style="margin-top:3px;">
			                                    <label style="height:45px;">手机号码:</label> 
			                                    <input <?php if ($this->_tpl_vars['officialapplys']['approvalstatus'] == '0'): ?>disabled<?php endif; ?> required="required" parsley-rangelength="[11,11]" id="mobile" name="mobile"
			                                           value="<?php echo $this->_tpl_vars['officialapplys']['mobile']; ?>
" type="number" style="font-size: 12px;"
			                                           class="mui-input-clear required" maxlength="11" placeholder="您的常用手机号码"
			                                           parsley-error-message="请输入正确的手机号码">
			                                </div>
			                                <div class="mui-input-row" style="margin-top:3px;">
			                                    <label style="height:45px;">密码:</label> 
			                                    <input <?php if ($this->_tpl_vars['officialapplys']['approvalstatus'] == '0'): ?>disabled<?php endif; ?> required="required"  id="password" name="password"
			                                           value="<?php echo $this->_tpl_vars['officialapplys']['password']; ?>
" type="password" style="font-size: 12px;"
			                                           class="mui-input-clear required" maxlength="11" placeholder="您的密码"
			                                           parsley-error-message="您的密码">
			                                </div>
	                               
		                                    <div class="mui-input-row" style="margin-top:3px;">
		                                        <label style="height:45px;">邮箱:</label>
		                                        <input id="email" name="email" <?php if ($this->_tpl_vars['officialapplys']['approvalstatus'] == '0'): ?>disabled<?php endif; ?>
		                                               value="<?php echo $this->_tpl_vars['officialapplys']['email']; ?>
" type="text" required="required"
		                                               style="font-size: 12px;" class="mui-input-clear  required" 
		                                               placeholder="请输入正确的邮箱">
		                                    </div>
		                                    <div class="mui-input-row" style="margin-top:3px;">
		                                        <label style="height:45px;">所属部门:</label>
		                                        <select  id="department" name="department" <?php if ($this->_tpl_vars['officialapplys']['approvalstatus'] == '0'): ?>disabled<?php endif; ?> style="font-size: 12px;" class="required">
				  								 	<?php $_from = $this->_tpl_vars['departments']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['departments'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['departments']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['departmentid'] => $this->_tpl_vars['departmentname']):
        $this->_foreach['departments']['iteration']++;
?> 
				  								 		<option value=<?php echo $this->_tpl_vars['departmentid']; ?>
  <?php if ($this->_tpl_vars['selectdepartment'] == $this->_tpl_vars['departmentid']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['departmentname']; ?>
</option>
				  						   		    <?php endforeach; endif; unset($_from); ?> 
												</select>
		                                    </div>
										<?php else: ?>	
			                                <div class="mui-input-row" style="margin-top:3px;">
			                                    <label style="height:45px;">真实姓名:</label>
			                                    <input id="type" name="type" value="submit" type="hidden">
			                                    <input required="required"  id="account" name="account"
			                                           value="" type="text" style="font-size: 12px;"
			                                           class="mui-input-clear required" maxlength="11" placeholder="请输入真实姓名"
			                                           parsley-error-message="请输入真实姓名">
			                                </div>	                             
			                                <div class="mui-input-row" style="margin-top:3px;">
			                                    <label style="height:45px;">手机号码:</label> 
			                                    <input required="required" parsley-rangelength="[11,11]" id="mobile" name="mobile"
			                                           value="<?php echo $this->_tpl_vars['profile_info']['mobile']; ?>
" type="number" style="font-size: 12px;"
			                                           class="mui-input-clear required" maxlength="11" placeholder="您的常用手机号码"
			                                           parsley-error-message="请输入正确的手机号码">
			                                </div>
			                                <div class="mui-input-row" style="margin-top:3px;">
			                                    <label style="height:45px;">密码:</label> 
			                                    <input required="required"  id="password" name="password"
			                                           value="" type="password" style="font-size: 12px;"
			                                           class="mui-input-clear required" maxlength="11" placeholder="您的密码"
			                                           parsley-error-message="您的密码">
			                                </div>
		                                    <div class="mui-input-row" style="margin-top:3px;">
		                                        <label style="height:45px;">邮箱:</label>
		                                        <input id="email" name="email"
		                                               value="" type="text" required="required"
		                                               style="font-size: 12px;" class="mui-input-clear  required" maxlength=""
		                                               placeholder="请输入正确的邮箱">
		                                    </div>
		                                    <div class="mui-input-row" style="margin-top:3px;">
		                                        <label style="height:45px;">所属部门:</label>
		                                        <select  id="department" name="department" style="font-size: 12px;" class="required">
				  								 	<?php $_from = $this->_tpl_vars['departments']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['departments'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['departments']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['departmentid'] => $this->_tpl_vars['departmentname']):
        $this->_foreach['departments']['iteration']++;
?> 
				  								 		<option value=<?php echo $this->_tpl_vars['departmentid']; ?>
 ><?php echo $this->_tpl_vars['departmentname']; ?>
</option>
				  						   		    <?php endforeach; endif; unset($_from); ?> 
												</select>
		                                    </div>     
										<?php endif; ?>               
		                       
		                    </ul>
                     </div>
                
                	 	<?php if (count($this->_tpl_vars['officialapplys']) > 0): ?>
	 				       <?php if ($this->_tpl_vars['officialapplys']['approvalstatus'] == '1'): ?>
			 				    <div class="mui-card" style="margin: 3px 3px;background:<?php echo $this->_tpl_vars['theme_info']['buttoncolor']; ?>
;">  
			 					   <div class="mui-content-padded" style="margin:0px;margin-top: 5px;"> 
			 	               			<h5 class="show-content" style="padding: 10px;"><span class="mui-icon iconfont icon-hezuo"></span> 提交申请</h5>
			 	  				   </div> 
			 				    </div>
						   <?php endif; ?>
						<?php else: ?>
		 				    <div class="mui-card" style="margin: 3px 3px;background:<?php echo $this->_tpl_vars['theme_info']['buttoncolor']; ?>
;">  
		 					   <div class="mui-content-padded" style="margin:0px;margin-top: 5px;"> 
		 	               			<h5 class="show-content" style="padding: 10px;"><span class="mui-icon iconfont icon-hezuo"></span> 提交申请</h5>
		 	  				   </div> 
		 				    </div>
						<?php endif; ?> 
						
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
				  mui(\'.mui-content\').on(\'tap\', \'h5.show-content\', function (e)
				  {
		  				var validate = Zepto( \'#frm\' ).parsley( \'validate\' );
		  				if (validate)
		  				{
		  					document.frm.submit();
		  				}  
				  }); 
			  }); 

	'; ?>

</script> 
<script src="/public/js/baidu.js?_=20140821" type="text/javascript"></script>
</body>
</html>
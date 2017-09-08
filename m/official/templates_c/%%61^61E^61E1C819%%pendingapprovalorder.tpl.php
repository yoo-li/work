<?php /* Smarty version 2.6.18, created on 2017-08-24 15:54:30
         compiled from pendingapprovalorder.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'pendingapprovalorder.tpl', 115, false),)), $this); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
	<title>审核</title>
	<link rel="stylesheet" href="/public/css/mui.min.css">
    <link href="/public/css/public.css" rel="stylesheet" />
     <link href="/public/css/common.css" rel="stylesheet" />
	<link href="/public/css/iconfont.css" rel="stylesheet"/>
	<link href="/public/css/sweetalert.css" rel="stylesheet"/>
	<script src="/public/js/mui.min.js" type="text/javascript" charset="utf-8"></script> 
	<script src="/public/js/zepto.min.js" type="text/javascript" charset="utf-8"></script>  
    <script src="/public/js/utils.js" type="text/javascript" charset="utf-8"></script> 
	<script type="text/javascript" src="/public/js/sweetalert.min.js"></script>
	<script type="text/javascript" charset="utf-8" src="/public/js/cordova.js"></script>
	<style>
		<?php echo '
		.img-responsive {
			display: block;
			height: auto;
			width: 100%;
		}
	   	 .mui-bar .tit-sortbar{
	   	 	left: 0;
	   	 	right: 0;
	   	 	margin-top: 45px; 
	   	 }
		 .mui-bar .mui-segmented-control {
		   top: 0px; 
		 }
		 .mui-segmented-control.mui-segmented-control-inverted .mui-control-item {
		   color: #333; 
		 } 
		.price {
			color: #fe4401;
		}

		.mui-table-view-cell .mui-table-view-label {
			width: 60px;
			text-align: right;
			display: inline-block;
		}

		.mui-table-view .mui-media-object {
			margin-top: 10px;
		}

		.order-link-cell {
			line-height: 30px;
			height: 30px;
			padding: 0px 5px;
		}

		.order-link-cell a {
			font-size: 12px;
		}

		.tishi {
			color: #fe4401;
			width: 100%;
			text-align: center;
			padding-top: 10px;
		}

		.tishi .mui-icon {
			font-size: 4.4em;
		}

		.msgbody {
			width: 100%;
			font-size: 1.4em;
			line-height: 25px;
			color: #333;
			text-align: center;
			padding-top: 10px;
		}

		.msgbody a {
			font-size: 1.0em;
		}
		
		.mui-input-row label { 
		     float: none;  
			 line-height:45px;
		}
		.mui-input-row input, select, textarea {  
		    font-size: 12px; 
		}
		#nextapproval,#beforeapproval{
			background: #1bc1f8 !important;
			border:0;
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
		     <a href="/official/approval.php" class="mui-icon mui-icon-back mui-pull-left"></a> 
			<h1 class="mui-title">待我购物审核</h1>
            <div class="mui-title mui-content tit-sortbar" id="sortbar"> 
 				<div id="segmentedControl" class="mui-segmented-control mui-segmented-control-inverted mui-segmented-control-negative">
 					<a class="mui-control-item iconfont icon-daishenpi button-color mui-active" href="pendingapprovalorder.php">&nbsp;审核</a> 
					<a class="mui-control-item iconfont icon-shenpijilu button-color" href="approvalrecord.php?type=order">&nbsp;审核记录</a>
 				</div> 
            </div> 
		</header> 
		 <div id="pullrefresh" class="mui-content mui-scroll-wrapper" style="padding-top: 85px;">  
			<div class="mui-scroll"> 
				<div class="mui-table-view">
					<h6 class="mui-content-padded" style="height:3px;margin:0px">&nbsp;</h6>  
					<?php if (count($this->_tpl_vars['officialtreat']) == 0): ?>
						<div class="mui-card" style="margin: 3px 3px;">  
							<ul id="list" class="mui-table-view" style="padding-top: 5px;padding-bottom: 5px;"> 
								<div class="mui-content-padded">
									 <p class="tishi"><span class="mui-icon iconfont icon-tishi"></span></p>
									 <p class="msgbody">目前没有需要您审核操作！<br><br> </p>
							    </div>  
							</ul> 
						</div>
					<?php else: ?>
						<div class="mui-card" style="margin: 3px 3px;">  
				   				<input id="approvalid" name="approvalid" value="<?php echo $this->_tpl_vars['officialtreat']['record']; ?>
" type="hidden">
				   			    <div class="mui-input-row">
	                                <label style="height:45px;font-weight:bold;">审核选择:</label>
						                   <span><input type="radio" value="Agree" id="radio-1" name="reply" checked >
						                   <label style="width:100px;padding: 10px 5px;" class="radio radio_1" for="radio-1">审核同意</label></span>
						                   <span><input type="radio" value="Disagree" id="radio-2" name="reply" >
						                   <label style="width:100px;padding: 10px 5px;" class="radio radio_2" for="radio-2">审核不同意</label></span> 
									<div class="mui-input-row">
	                                   <label>审核意见 :</label>
	                                   <input type="text" style="font-size: 12px;width:70%" value="同意" class="mui-input-clear my_advice required">
	                                </div>
	                            </div> 
	                           
	                            <script type="text/javascript">
	                            	<?php echo '
	                            		$(document).on(\'change\',\'#radio-1\',function(){
	                            			$(\'.my_advice\').val(\'同意 \');
	                            		})
	                            		$(document).on(\'change\',\'#radio-2\',function(){
	                            			$(\'.my_advice\').val(\'不同意 \');
	                            		})
	                            	'; ?>

	                            </script>
					    </div> 
	  				    <div class="mui-card" style="margin: 3px 3px;background: <?php echo $this->_tpl_vars['supplier_info']['navigationbarcolor']; ?>
;">  
	  					   <div class="mui-content-padded" style="margin:0px;margin-top: 5px;"> 
	  	               			<a id="saveapproval"><h5 class="show-content" style="padding: 10px;"><span class="mui-icon iconfont icon-save"></span>&nbsp;保存审核</h5></a>
	  	  				   </div> 
	  				    </div>


						<?php if ($this->_tpl_vars['noofrows'] > 1): ?>
							<div class="mui-card" style="margin: 3px 3px;">
								<div class="mui-content-padded" style="height:35px;line-height:35px;">
									<label style="font-weight:bold;">待我审核:</label> &nbsp;
									<span class="mui-badge mui-badge-purple" style="background:#1bc1f8"><?php echo $this->_tpl_vars['num']; ?>
/<?php echo $this->_tpl_vars['noofrows']; ?>
</span>&nbsp;条
									<button id="nextapproval" data-approvalid="<?php echo $this->_tpl_vars['officialtreat']['record']; ?>
" type="button" class="mui-btn mui-btn-royal  mui-pull-right" style="background:<?php echo $this->_tpl_vars['supplier_info']['navigationbarcolor']; ?>
">
										<span class="mui-icon iconfont icon-next" ></span>&nbsp;下一条</button>
																			<button id="beforeapproval" data-approvalid="<?php echo $this->_tpl_vars['officialtreat']['record']; ?>
" type="button" class="mui-btn mui-btn-royal  mui-pull-right" style="background:<?php echo $this->_tpl_vars['supplier_info']['navigationbarcolor']; ?>
;margin-right:5px">
											<span class="mui-icon iconfont icon-next" ></span>&nbsp;上一条</button>
									
								</div>
							</div>
                        <?php endif; ?>

						<div class="mui-card" style="margin: 3px 3px;">   
		                           <div class="mui-input-row" style="height:25px;line-height:25px;">
		                               <label style="font-weight:bold;line-height:25px">提交人:</label>
						               <span><?php echo $this->_tpl_vars['officialtreat']['profileid_givenname']; ?>
</span>     
		                           </div>
		                           <div class="mui-input-row" style="height:25px;line-height:25px;">
		                               <label style="font-weight:bold;line-height:25px">提交时间:</label>
						               <span><?php echo $this->_tpl_vars['officialtreat']['published']; ?>
</span>     
		                           </div> 
					    </div> 
						<h6 class="mui-content-padded" style="height:20px;margin:7px 5px 0px 10px">基本信息</h6>  
						<div class="mui-card" style="margin: 0px 3px;">  
							      <?php $_from = $this->_tpl_vars['officialtreat']['baseinfo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['baseinfo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['baseinfo']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['base_info']):
        $this->_foreach['baseinfo']['iteration']++;
?> 
								      <?php if ($this->_tpl_vars['base_info']['type'] == 'desc'): ?>
				                           <div class="mui-input-row" style="line-height:25px;">
				                               <label style="font-weight:bold;line-height:25px"><?php echo $this->_tpl_vars['base_info']['label']; ?>
:</label>
								               <div style="display:inline-block;text-indent:2em;"><?php echo $this->_tpl_vars['base_info']['value']; ?>
</div>     
				                           </div>  
									  <?php elseif ($this->_tpl_vars['base_info']['type'] == 'img'): ?>  
				                           <div class="mui-input-row" style="line-height:25px;">
				                               <label style="font-weight:bold;line-height:25px"><?php echo $this->_tpl_vars['base_info']['label']; ?>
:</label>
								               <span style="display:inline-block;width:60%"><?php echo $this->_tpl_vars['base_info']['value']; ?>
</span>     
				                           </div>
									  <?php else: ?> 
				                           <div class="mui-input-row" style="height:25px;line-height:25px;">
				                               <label style="font-weight:bold;line-height:25px"><?php echo $this->_tpl_vars['base_info']['label']; ?>
:</label>
								               <span><?php echo $this->_tpl_vars['base_info']['value']; ?>
</span>     
				                           </div>  
									  <?php endif; ?>
								   <?php endforeach; endif; unset($_from); ?> 
					    </div> 
					<?php endif; ?>
				    <h6 class="mui-content-padded" style="height:3px;margin:0px">&nbsp;</h6>  
				</div> 
					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'copyright.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			</div>
		</div>
	</div> 

<script type="text/javascript">
	var num = <?php echo $this->_tpl_vars['num']; ?>
;
	<?php echo '
	mui.init({
				 pullRefresh: {
					 container: \'#pullrefresh\', //待刷新区域标识，querySelector能定位的css选择器均可，比如：id、.class等
					  
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
                  mui(\'.mui-table-view\').on(\'tap\', \'button#beforeapproval\', function (e)
                  {
                      var approvalid = this.getAttribute(\'data-approvalid\');
                      mui.openWindow({
                          url: \'pendingapprovalorder.php?beforeapprovalid=\'+approvalid+\'&num=\'+num,
                          id: \'info\'
                      });
                  });
				  mui(\'.mui-table-view\').on(\'tap\', \'button#nextapproval\', function (e)
				  { 
					  var approvalid = this.getAttribute(\'data-approvalid\');
					  mui.openWindow({
										 url: \'pendingapprovalorder.php?nextapprovalid=\'+approvalid+\'&num=\'+num,
										 id: \'info\'
									 });
				  }); 
				  
				  mui(\'.mui-table-view\').on(\'tap\', \'a#saveapproval\', function (e)
				  {  
					   
					  var url = this.getAttribute(\'href\');
                      swal({
                          title: "提示",
                          text: "您确定保存审核结果吗？",
                          type: "warning",
                          showCancelButton: true,
                          closeOnConfirm: true,
                          confirmButtonText: "确定",
                          confirmButtonColor: "#ec6c62"
                      }, function () { 
						    var approvalid = Zepto(\'#approvalid\').val(); 
							var reply = ""; 
							Zepto.each(Zepto(\'input[name=reply]\'), function (i, v){
								var checked = $(this).prop("checked");
								if (checked)
								{
									reply = $(this).val(); 
								}
							});
							var postbody = \'type=submit&approvalid=\' + approvalid + \'&reply=\' + reply ;  
							
						    mui.ajax({
   				  					 type: \'POST\',
   				  					 url: "pendingapprovalorder.php",
   				  					 data: postbody,
   				  					 success: function (reponsebody)
   				  					 { 
										 if (reponsebody == "ok")
										 {
     			  						       mui.openWindow({
     			  											 url: \'approvalrecord.php?type=order\',
     			  											 id: \'info\'
     			  										 });
										 }
										 else
										 {
								 	 	    swal({
								 	 	         title: "提示", 
								 	 	         text: "保存失败，请稍后再试！", 
								 	 	         type: "warning", 
								 	 	       }, function() { });
										 } 
   				  					 }
   				  				 });
						     
                      });
				  });  

			  }); 

	'; ?>

</script> 
<script src="/public/js/baidu.js?_=20140821" type="text/javascript"></script>
</body>
</html>
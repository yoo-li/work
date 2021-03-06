<?php /* Smarty version 2.6.18, created on 2017-08-11 15:39:24
         compiled from index.tpl */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
	<title>事务官企业管理系统</title>
	<link rel="stylesheet" href="/public/css/mui.min.css">
    <link href="/public/css/public.css" rel="stylesheet" />
     <link href="/public/css/common.css" rel="stylesheet" />
    <link href="/public/css/common.css" rel="stylesheet"/> 
	<link href="/public/css/iconfont.css" rel="stylesheet"/> 
	<style>
		<?php echo ' 
		    .img-responsive { display: block; height: auto; width: 100%; }   
		    .mui-table-view-cell:after {  left:0px;background-color: #c8c7cc; } 
	  		.tishi { color: #fe4401; width: 100%; text-align: center; padding-top: 10px; }
	  	    .tishi .mui-icon { font-size: 4.4em; }
	 	   	.msgbody { width: 100%; font-size: 1.4em; line-height: 25px; color: #333; text-align: center; padding-top: 10px; }
	 	    .msgbody a { font-size: 1.0em; }
				  
	 	 '; ?>
 
	</style>  
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'theme.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</head>
<body>
 <!-- 侧滑导航根容器 -->
 <div class="mui-off-canvas-wrap mui-draggable" id="offCanvasWrapper">
	 
	<div class="mui-inner-wrap">
		<header class="mui-bar mui-bar-nav" style="padding-right: 15px;">
		    <a id="returnback" class="mui-icon mui-icon-left-nav mui-pull-left"></a>
			<h1 class="mui-title">企业事务管理平台</h1>
		</header> 
         <div id="pullrefresh" class="mui-content mui-scroll-wrapper" style="padding-top: 50px;"> 
                 <div class="mui-scroll">   
  					 <ul id="vendors" class="mui-table-view mui-table-view-chevron" style="color: #333;">
								 	<?php $_from = $this->_tpl_vars['suppliers']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['suppliers'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['suppliers']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['supplier_info']):
        $this->_foreach['suppliers']['iteration']++;
?> 
								 		<li class="mui-table-view-cell mui-left"> 
											<a class="mui-navigate-right" href="supplier.php?supplierid=<?php echo $this->_tpl_vars['supplier_info']['supplierid']; ?>
">
										        <img class="mui-media-object mui-pull-left" style="width:20%" src="<?php echo $this->_tpl_vars['supplier_info']['logo']; ?>
">
												<div class="mui-media-body mui-pull-left" style="width:78%">
														<p class='mui-ellipsis' style="color:#333;font-size:1.3em;line-height: 27px;height: 27px;"><?php echo $this->_tpl_vars['supplier_info']['mallname']; ?>
</p>  
														<p class='mui-ellipsis' style="font-size:1.1em;line-height: 15px;height: 15px;"><?php echo $this->_tpl_vars['supplier_info']['suppliers_name']; ?>
</p>  
												</div>  
											</a> 
	  									</li> 
									<?php endforeach; else: ?> 
									    <h6 class="mui-content-padded" style="height:3px;margin:0px">&nbsp;</h6> 
						 		  		<div class="mui-card" style="margin: 3px 3px;"> 
			 		  						   		  <p class="tishi"><span class="mui-icon iconfont icon-tishi"></span></p>
			 		  							      <p class="msgbody">请先加入您所属的企业！<br>
			 	  									  <br> 
			 										  </p>
						 		  		 </div>
										  <h6 class="mui-content-padded" style="height:3px;margin:0px">&nbsp;</h6> 
						   		    <?php endif; unset($_from); ?>
					</ul>  
 				   <div class="mui-card mui-btn-my" style="margin: 3px 3px;background:<?php echo $this->_tpl_vars['theme_info']['buttoncolor']; ?>
;">  
 					   <div class="mui-content-padded" style="margin:0px;margin-top: 5px;"> 
 	               			<a href="search.php"><h5 class="show-content" style="padding: 10px;"><span class="mui-icon iconfont icon-hezuo"></span> 查找新的企业</h5></a>
 	  				   </div> 
 				   </div>       
 				   <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'copyright.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
 				</div>
 		</div>
		 
	</div> 
</div> 

<script src="/public/js/mui.min.js" type="text/javascript" charset="utf-8"></script> 
<script src="/public/js/zepto.min.js" type="text/javascript" charset="utf-8"></script>  
<script src="/public/js/utils.js" type="text/javascript" charset="utf-8"></script>  
<script type="text/javascript" charset="utf-8" src="/public/js/cordova.js"></script>


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
		  		mui(\'.mui-table-view-cell\').on(\'tap\',\'a\',function(e){
		  			mui.openWindow({
		  				url: this.getAttribute(\'href\'),
		  				id: \'info\'
		  			});
		  		}); 
		  		mui(\'.mui-content-padded\').on(\'tap\',\'a\',function(e){
		  			mui.openWindow({
		  				url: this.getAttribute(\'href\'),
		  				id: \'info\'
		  			});
		  		}); 
	  			document.getElementById(\'returnback\').addEventListener(\'tap\', function() {
	  				 Cordova.exec(null, null, "PhoneGapPlugin", "PluginFunction", [{"type":"historyback"}]); 
	  			});

			  }); 

	'; ?>

</script> 
<script src="/public/js/baidu.js?_=20140821" type="text/javascript"></script>
</body>
</html>
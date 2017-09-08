<?php /* Smarty version 2.6.18, created on 2017-08-11 15:39:27
         compiled from search.tpl */ ?>
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
	<script src="/public/js/mui.min.js" type="text/javascript" charset="utf-8"></script> 
	<script src="/public/js/zepto.min.js" type="text/javascript" charset="utf-8"></script>  
    <script src="/public/js/utils.js" type="text/javascript" charset="utf-8"></script>  
	<script type="text/javascript" charset="utf-8" src="/public/js/cordova.js"></script>
	<style>
		<?php echo '
		  
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
			<h1 class="mui-title">查找企业</h1> 
		</header> 
         <div id="pullrefresh" class="mui-content mui-scroll-wrapper" style="padding-top: 50px;"> 
                 <div class="mui-scroll">   
  					  <div class="mui-card" style="margin: 3px 3px;">  
	  					   <form action="search.php" onSubmit="return searchgo()"> 
									  <div class="mui-table-view">
										  <div class="mui-table-view-cell">     
							   				<div class="mui-input-row mui-search">
							   					<input id="keywords" name="keywords" type="search" class="mui-input-clear" placeholder="搜索企业">
							   				</div> 
									     </div>
								      </div>
						    </form>
					    </div>
						<?php if ($this->_tpl_vars['official'] == '0'): ?>
						<div class="mui-card" style="margin: 3px 3px;"> 
		  			        <div class="mui-table-view-cell" style="margin-top:3px;">
		                         <div  class="mui-media-body myfont-color"
		                              style="color:#cc3300;font-size: 17px;text-align:center">
		                                  您已经成为一个企业事务官！<br>
										  不能同时加入多个企业！
		                         </div>
		                    </div>
						</div>
						<?php endif; ?>
					    <ul id="vendors" class="mui-table-view" style="color: #333;">
								 	<?php $_from = $this->_tpl_vars['suppliers']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['suppliers'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['suppliers']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['supplier_info']):
        $this->_foreach['suppliers']['iteration']++;
?> 
								 		<li class="mui-table-view-cell mui-left"> 
											 	 <img class="mui-media-object mui-pull-left" style="width:20%" src="<?php echo $this->_tpl_vars['supplier_info']['logo']; ?>
">
												<div class="mui-media-body mui-pull-left" style="width:50%">
														<p class='mui-ellipsis' style="color:#333;font-size:1.3em;line-height: 27px;height: 27px;"><?php echo $this->_tpl_vars['supplier_info']['mallname']; ?>
</p>  
														<p class='mui-ellipsis' style="font-size:1.1em;line-height: 15px;height: 15px;"><?php echo $this->_tpl_vars['supplier_info']['suppliers_name']; ?>
</p>  
												</div> 
												<?php if ($this->_tpl_vars['official'] != '0'): ?> 
												<div class="mui-media-body mui-pull-right" style="width:28%;padding-top:5px; ">
													<button data-url="supplierdetail.php?supplierid=<?php echo $this->_tpl_vars['supplier_info']['supplierid']; ?>
" type="button" class="mui-btn mui-btn-danger"><?php echo $this->_tpl_vars['supplier_info']['status']; ?>
</button>
												</div> 
												<?php endif; ?>
	  									</li> 
						   		  <?php endforeach; endif; unset($_from); ?>
					 	 	</ul>  
   				   <div class="mui-card mui-btn-my" style="margin: 3px 3px;background:<?php echo $this->_tpl_vars['theme_info']['buttoncolor']; ?>
;">  
   					   <div class="mui-content-padded" style="margin:0px;margin-top: 5px;"> 
   	               			<a href="suppliernew.php"><h5 class="show-content" style="padding: 10px;"><span class="mui-icon iconfont icon-hezuo"></span> 新建企业</h5></a>
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
				  
				   mui(\'.mui-table-view\').on(\'tap\', \'button\', function (e)
				  {
					  mui.openWindow({
										 url: this.getAttribute(\'data-url\'),
										 id: \'info\'
									 });
				  });  
  		  		mui(\'.mui-content-padded\').on(\'tap\',\'a\',function(e){
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
<?php /* Smarty version 2.6.18, created on 2017-08-14 09:33:54
         compiled from approval.tpl */ ?>
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
		  .img-responsive { display: block; height: auto; width: 100%; }   
	  	  .mui-input-row label { 
	  		  line-height: 21px; 
	  		  height: 21px;  
	  	  }
		  .menuicon
		  {
		 		color:#fe4401; 
		 		padding-right:5px;
		  }
		  .mui-grid-view .mui-media {
		    color: #fe4401; 
		    padding: 5px;
		  }
		  #orders .mui-table-view.mui-grid-view .mui-table-view-cell { 
		    padding: 10px 0 5px 0; 
			font-size: 1.4em;
		  }
		  #orders .mui-table-view.mui-grid-view .mui-table-view-cell .mui-icon {  
			font-size: 2.0em; 
		  }
		  #orders .mui-table-view.mui-grid-view .mui-table-view-cell .mui-media-body {
		    font-size: 12px; 
		    text-overflow: clip;
		    color: #333;
		  } 
		  #orders .mui-icon .mui-badge {
		    font-size: 10px;  
		    line-height: 1.4;
		    position: absolute;
		    top: 0px;
		    left: 100%;
		    margin-left: -40px;
		    padding: 1px 5px;
		    color: red;
		    background: white;
			border: 1px solid red;
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
		    			<a id="returnback" class="mui-icon mui-icon-left-nav mui-pull-left"></a>
			<h1 class="mui-title">待我审核</h1> 
		</header> 
         <div id="pullrefresh" class="mui-content mui-scroll-wrapper" style="padding-top: 50px;"> 
                 <div class="mui-scroll">   
  					 <div class="mui-card" style="margin: 3px 3px;">  
 				         <ul id="orders" class="mui-table-view" style="padding-top: 5px;text-align:center;">   
	                             <li class="mui-table-view-cell">
	                                 <a href="pendingapprovalorder.php" class="mui-navigate-right"> 
										<div class="mui-media-body  mui-pull-left">
											<span class="mui-icon iconfont icon-bangzhu menuicon button-color"></span>待我审核_购物
										</div> 
										
										<div class="mui-media-body  mui-pull-right" style="color:#888;padding-right:20px;"> 
											<?php if ($this->_tpl_vars['badges']['officialorder_approval_count'] > 0): ?><span class="mui-badge mui-badge-danger"><?php echo $this->_tpl_vars['badges']['officialorder_approval_count']; ?>
</span><?php endif; ?>  查看购物审批
										</div>
										
									</a>
	                             </li>
	                              <li class="mui-table-view-cell">
	                                 <a href="pendingapprovaltreat.php" class="mui-navigate-right"> 
										<div class="mui-media-body  mui-pull-left">
											<span class="mui-icon iconfont icon-bangzhu menuicon button-color"></span>待我审核_宴请
										</div> 
										
										<div class="mui-media-body  mui-pull-right" style="color:#888;padding-right:20px;"> 
											<?php if ($this->_tpl_vars['badges']['officialtreat_approval_count'] > 0): ?><span class="mui-badge mui-badge-danger"><?php echo $this->_tpl_vars['badges']['officialtreat_approval_count']; ?>
</span><?php endif; ?>  查看宴请审批
										</div>
										
									</a>
	                             </li>
	                              <li class="mui-table-view-cell">
	                                 <a href="pendingopinionorder.php" class="mui-navigate-right"> 
										<div class="mui-media-body  mui-pull-left">
											<span class="mui-icon iconfont icon-bangzhu menuicon button-color"></span>待我意见_购物
										</div>  
										<div class="mui-media-body  mui-pull-right" style="color:#888;padding-right:20px;"> 
											<?php if ($this->_tpl_vars['badges']['officialorder_opinion_count'] > 0): ?><span class="mui-badge mui-badge-danger"><?php echo $this->_tpl_vars['badges']['officialorder_opinion_count']; ?>
</span><?php endif; ?>  查看购物意见
										</div> 
									</a>
	                             </li>
	                              <li class="mui-table-view-cell">
	                                 <a href="pendingopiniontreat.php" class="mui-navigate-right"> 
										<div class="mui-media-body  mui-pull-left">
											<span class="mui-icon iconfont icon-bangzhu menuicon button-color"></span>待我意见_宴请
										</div>  
										<div class="mui-media-body  mui-pull-right" style="color:#888;padding-right:20px;"> 
											<?php if ($this->_tpl_vars['badges']['officialtreat_opinion_count'] > 0): ?><span class="mui-badge mui-badge-danger"><?php echo $this->_tpl_vars['badges']['officialtreat_opinion_count']; ?>
</span><?php endif; ?>  查看宴请意见
										</div> 
									</a>
	                             </li>
								 
 						 </ul>  
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
        mui.ready(function ()
        {

            document.getElementById(\'returnback\').addEventListener(\'tap\', function() {
//                console.log(111111);
                Cordova.exec(null, null, "PhoneGapPlugin", "PluginFunction", [{"type":"historyback"}]);
            });

        });
        '; ?>

	</script>
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
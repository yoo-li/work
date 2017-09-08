<?php /* Smarty version 2.6.18, created on 2017-08-15 17:25:41
         compiled from accountbook.tpl */ ?>
 

<!DOCTYPE html>
<html> 
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title></title>
    <link href="public/css/mui.css" rel="stylesheet" />
    <link href="public/css/public.css" rel="stylesheet" />
	<link href="public/css/iconfont.css" rel="stylesheet" />  
    <script src="public/js/mui.min.js" type="text/javascript" charset="utf-8"></script>  
	<script type="text/javascript" src="public/js/jweixin.js"></script> 
	<script src="public/js/zepto.min.js" type="text/javascript" charset="utf-8"></script>  
	<script src="public/js/common.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript" src="public/js/jweixin.js"></script> 
	<style>
	  <?php echo ' 
		 .img-responsive { display: block; height: auto; width: 100%; }  
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
	 	  color:#fe4401;
	 	 } 
	  	 .mui-table-view-cell .mui-table-view-label
	  	 {
	  	    width:60px;
	  		text-align:right;
	  		display:inline-block;
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
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'leftmenu.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>  	
		<div class="mui-inner-wrap">
			<header class="mui-bar mui-bar-nav" style="padding-right: 15px;">  
				 <a id="offCanvasShow" href="#offCanvasSide" class="mui-icon mui-action-menu mui-icon-bars mui-pull-left"></a>
				 <h1 class="mui-title">我的账簿</h1>
                 <div class="mui-title mui-content tit-sortbar" id="sortbar"> 
		 				<div id="segmentedControl" class="mui-segmented-control mui-segmented-control-inverted mui-segmented-control-negative">
		 					<a class="mui-control-item mui-active" href="accountbook.php">收益明细</a>
		 					<a class="mui-control-item" href="billwaters.php">账单流水</a> 
		 				</div> 
                 </div>
			</header> 
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>   
	        <div id="pullrefresh" class="mui-content mui-scroll-wrapper" style="padding-top: 85px;">  
                    <div class="mui-scroll">   
   		                 <div id="list" class="mui-table-view" >     
		 		 							<ul class="mui-table-view" style="padding-top: 5px;padding-bottom: 5px;">
												<div class="mui-card" style="margin: 3px 3px;"> 
												 <li class="mui-table-view-cell"> 
														<div class="mui-media-body  mui-pull-left">
															<span class="mui-table-view-label">可用资金：</span><span class="price">¥<?php echo $this->_tpl_vars['profile_info']['money']; ?>
</span>
														</div> 
				                                </li> 
												 <li class="mui-table-view-cell"> 
														<div class="mui-media-body  mui-pull-left">
															<span class="mui-table-view-label">累积收益：</span><span class="price">¥<?php echo $this->_tpl_vars['profile_info']['accumulatedmoney']; ?>
</span>
														</div> 
				                                </li>  
				                                <li class="mui-table-view-cell"> 
														<div class="mui-media-body  mui-pull-left">
															<span class="mui-table-view-label">冻结资金：</span> <span class="price">¥<?php echo $this->_tpl_vars['frozencommission']; ?>
</span>
														</div>  
				                                </li>
											    </div>
												<div class="mui-card" style="margin: 3px 3px;">
				                                <li class="mui-table-view-cell">
				                                    <a href="profit_share.php" class="mui-navigate-right deliveraddress"> 
														<div class="mui-media-body  mui-pull-left">
															<span class="mui-table-view-label">分享收益：</span> <span class="price">¥<?php echo $this->_tpl_vars['share']; ?>
</span>
														</div> 
													</a>
				                                </li>
				                                <li class="mui-table-view-cell">
				                                    <a href="profit_commission.php" class="mui-navigate-right deliveraddress"> 
														<div class="mui-media-body  mui-pull-left">
															<span class="mui-table-view-label">提成收益：</span> <span class="price">¥<?php echo $this->_tpl_vars['totalcommission']; ?>
</span>
														</div> 
													</a>
				                                </li>
				                                <li class="mui-table-view-cell">
				                                    <a href="profit_popularize.php" class="mui-navigate-right deliveraddress"> 
														<div class="mui-media-body  mui-pull-left">
															<span class="mui-table-view-label">推广收益：</span> <span class="price">¥<?php echo $this->_tpl_vars['popularize']; ?>
</span>
														</div> 
													</a>
				                                </li>
												 </div>
												<div class="mui-card" style="margin: 3px 3px;">
				                                <li class="mui-table-view-cell"> 
														<div class="mui-media-body  mui-pull-left">
															<span class="mui-table-view-label">总收益：</span> <span class="price">¥<?php echo $this->_tpl_vars['total']; ?>
</span>
														</div>  
				                                </li>
												</div>
		 		 							</ul> 
											<ul class="mui-table-view" style="background-color: #efeff4;">
												<li class="mui-table-view-cell mui-media"> 
														<img class="img-responsive" src="/images/baozhang.png"> 
												</li>
											</ul> 
						 </div>    
                 </div>
			</div>
	    </div> 
 </div>  
	      
	<script type="text/javascript"> 
	<?php echo '	 
	    mui.init({
	        pullRefresh: {
	            container: \'#pullrefresh\', //待刷新区域标识，querySelector能定位的css选择器均可，比如：id、.class等  
	        },
	    });
		mui.ready(function() {  
			mui(\'#pullrefresh\').scroll();
			mui(\'.mui-bar\').on(\'tap\',\'a\',function(e){
				mui.openWindow({
					url: this.getAttribute(\'href\'),
					id: \'info\'
				});
			});  
	   }); 
	'; ?>
 
	</script>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'weixin.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 
<script src="/public/js/baidu.js?_=20140821" type="text/javascript"></script>
</body> 
</html>
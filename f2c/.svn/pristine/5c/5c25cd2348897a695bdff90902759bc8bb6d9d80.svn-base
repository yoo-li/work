 

<!DOCTYPE html>
<html> 
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>提现申请</title>
    <link href="public/css/mui.css" rel="stylesheet" />
    <link href="public/css/public.css" rel="stylesheet" />
	<link href="public/css/iconfont.css" rel="stylesheet" />   
	<link href="public/css/parsley.css" rel="stylesheet" >  
		
    <script src="public/js/mui.min.js" type="text/javascript" charset="utf-8"></script>  
	<script src="public/js/zepto.min.js" type="text/javascript" charset="utf-8"></script>  
	<script src="public/js/utils.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript" src="public/js/jweixin.js"></script> 
	
    <script src="public/js/parsley.min.js"></script>   
    <script src="public/js/parsley.zh_cn.js"></script>
	
	<style>
	  {literal} 
		 .img-responsive { display: block; height: auto; width: 100%; }  
	   	 .mui-bar .tit-sortbar{
	   	 	left: 0;
	   	 	right: 0;
	   	 	margin-top: 45px; 
	   	 }
		 .mui-bar .mui-segmented-control {
		   top: 0px; 
		 }
		 #submit_button
		 { 
			 font-size: 20px;
			 padding-left: 5px;
		 }
		 .mui-segmented-control.mui-segmented-control-inverted .mui-control-item {
		   color: #333; 
		 } 
	 	 .price {
	 	  color:#fe4401;
	 	 } 
	  	 .mui-table-view-cell .mui-table-view-label
	  	 {
	  	    width:90px;
	  		text-align:right;
	  		display:inline-block;
	  	 } 
		 
		 
		 
		 
		 
 	  	.mui-input-row label { 
 	  	  text-align: right; 
 	  	  width: 30%;
		  font-family: "Microsoft Yahei",微软雅黑,Arial,宋体,Arial Narrow,serif;
 	  	}  
 	  	.mui-input-row label ~ input, .mui-input-row label ~ select, .mui-input-row label ~ textarea {
 	  	  float: right;
 	  	  width: 70%; 
		  font-size: 12px;
		  padding: 10px 15px;
 	  	}
 	  	.mui-input-row label { 
 	  	  line-height: 21px; 
 	  	  padding: 10px 10px;
 	  	} 
 	  	.mui-input-clear
 	  	{
 	  		font-size: 12px;
 	  	}
		 
		
		
 	  	input.parsley-success,
 	  	select.parsley-success,
 	  	textarea.parsley-success {
 	  	  color: #468847;
 	  	  background-color: #DFF0D8;
 	  	  border: 1px solid #D6E9C6;
 	  	}

 	  	input.parsley-error,
 	  	select.parsley-error,
 	  	textarea.parsley-error {
 	  	  color: #B94A48;
 	  	  background-color: #F2DEDE;
 	  	  border: 1px solid #EED3D7;
 	  	}

 	  	.parsley-errors-list {
 	  	  margin: 2px 0 3px;
 	  	  padding: 0;
 	  	  list-style-type: none;
 	  	  font-size: 0.9em;
 	  	  line-height: 0.9em;
 	  	  opacity: 0;

 	  	  transition: all .3s ease-in;
 	  	  -o-transition: all .3s ease-in;
 	  	  -moz-transition: all .3s ease-in;
 	  	  -webkit-transition: all .3s ease-in;
 	  	}

 	  	.parsley-errors-list.filled {
 	  	  opacity: 1;
 	  	} 
	 	 
	 {/literal} 
	</style>
	{include file='theme.tpl'} 
</head>
<body>  
<div class="mui-off-canvas-wrap mui-draggable" id="offCanvasWrapper"> 
		<div class="mui-inner-wrap">
			<header class="mui-bar mui-bar-nav" style="padding-right: 15px;">  
				 <a class="mui-icon mui-action-back mui-icon-back mui-pull-left"></a> 
				 <h1 class="mui-title">提现</h1>
                 <div class="mui-title mui-content tit-sortbar" id="sortbar"> 
		 				<div id="segmentedControl" class="mui-segmented-control mui-segmented-control-inverted mui-segmented-control-negative">
		 					<a class="mui-control-item mui-active" href="takecashs.php">提现申请</a>
		 					<a class="mui-control-item" href="takecashlogs.php">历史提现记录</a> 
		 				</div> 
                 </div>
			</header>  
			<nav class="mui-bar mui-bar-tab" style="height:40px;line-height:40px;"> 
				{if $takecashs.takecash eq 'open'}
					<a class="mui-tab-item mui-active submit" href="#" style="width:30%">  
						<span class="mui-icon iconfont icon-save button-color" id="submit_icon" style="top:0px;"></span><span id="submit_button" >确定提交</span>
					</a>
				{else}
					<a class="mui-tab-item mui-active" href="index.php" style="width:30%">  
						<span class="mui-icon iconfont icon-queren01 button-color" style="top:0px;"></span><span style="font-size: 20px;padding-left: 5px;">返回首页</span>
					</a>
				{/if}
			</nav>
	        <div id="pullrefresh" class="mui-content mui-scroll-wrapper" style="padding-top: 85px;">  
                    <div class="mui-scroll">   
   		                 <div id="list" class="mui-table-view" >     
	 							<ul class="mui-table-view" style="padding-top: 5px;padding-bottom: 5px;">
									<div class="mui-card" style="margin: 3px 3px;"> 
									 <li class="mui-table-view-cell"> 
											<div class="mui-media-body  mui-pull-left">
												<span class="mui-table-view-label">当前可用资金：</span><span class="price">¥{$takecashs.money}</span>
											</div> 
	                                </li> 
									 
								    </div>
									<div class="mui-card" style="margin: 3px 3px;">
		                                <li class="mui-table-view-cell"> 
												<div class="mui-media-body  mui-pull-left">
													<span class="mui-table-view-label">分享收益：</span> <span class="price">¥{$takecashs.share}</span> 
												</div>  
												<div class="mui-media-body mui-pull-right" style="text-align:right;">  
													{if $takecashs.allow_share eq '1'} 【可提现】 {else} 【不可提现】{/if}
												</div>
		                                </li>
		                                <li class="mui-table-view-cell"> 
												<div class="mui-media-body  mui-pull-left">
													<span class="mui-table-view-label">提成收益：</span> <span class="price">¥{$takecashs.commission}</span>
												</div>  
												<div class="mui-media-body mui-pull-right" style="text-align:right;">  
													{if $takecashs.allow_commission eq '1'} 【可提现】 {else} 【不可提现】{/if}
												</div>
		                                </li>
		                                <li class="mui-table-view-cell"> 
												<div class="mui-media-body  mui-pull-left">
													<span class="mui-table-view-label">推广收益：</span> <span class="price">¥{$takecashs.popularize}</span>
												</div> 
												<div class="mui-media-body mui-pull-right" style="text-align:right;">  
													{if $takecashs.allow_popularize eq '1'} 【可提现】 {else} 【不可提现】{/if}
												</div> 
		                                </li>
									 </div>
									<div class="mui-card" style="margin: 3px 3px;">
										 <li class="mui-table-view-cell"> 
												<div class="mui-media-body  mui-pull-left">
													<span class="mui-table-view-label">总收益：</span><span class="price">¥{$takecashs.total}</span>
												</div> 
		                                 </li>
										 <li class="mui-table-view-cell"> 
												<div class="mui-media-body  mui-pull-left">
													<span class="mui-table-view-label">已提现资金：</span><span class="price">¥{$takecashs.historytakecash}</span>
												</div> 
		                                </li>
		                                <li class="mui-table-view-cell"> 
												<div class="mui-media-body  mui-pull-left">
													<span class="mui-table-view-label">可提现金额：</span> <span class="price">¥{$takecashs.allowtakecash}.00</span>
												</div>  
												<div class="mui-media-body mui-pull-right" style="text-align:right;">  
													【达到<span class="price">¥{$takecashs.takecashlimit}</span>可提现】
												</div>
		                                </li>
									</div>
									{if $takecashs.msg neq ''}
									<div class="mui-card" style="margin: 3px 3px;">
										 <li class="mui-table-view-cell"> 
												<div class="mui-media-body" style="text-align: center;color: #fe4401;">
													<span>{$takecashs.msg}</span>
												</div> 
		                                 </li> 
									</div>
									{/if}
									{if $takecashs.takecash eq 'open'}
										<form class="mui-input-group" name="frm" id="frm" method="post" action="takecashs.php"  parsley-validate>
										<input  id="type" name="type"  value="submit" type="hidden" > 
										<input  id="token" name="token" value="{$takecashs.token}" type="hidden" >
									
										<div class="mui-card" style="margin: 3px 3px;"> 
											<div class="mui-input-row">
						 						<label style="height:45px;">银行:</label>  
									            <select name="bank" id="bank" data-toggle="selectpicker" class="required"  data-width="200" onchange="onbankchange(this.value);" >											
										               <option value="" >请选择银行</option> 
													   <!--<option value="微信号">微信号</option>-->
													   <option value="支付宝">支付宝</option> 
													   <option value="中国农业银行">中国农业银行</option>  
													   <option value="中国工商银行">中国工商银行</option>  
													   <option value="中国建设银行">中国建设银行</option>  
													   <option value="中国银行">中国银行</option>  
													   <option value="交通银行">交通银行</option>   
									            </select> 
						 					</div>
			   			 					<div class="mui-input-row" style="margin-top:3px;">
			   			 						<label style="height:45px;" id="account_label">银行账号:</label>
			   			 						<input id="account" name="account" value="" type="text" style="font-size: 12px;"  class="mui-input-clear required"  >
			   			 					</div>
			   			 					<div class="mui-input-row" style="margin-top:3px;">
			   			 						<label style="height:45px;">收款人姓名:</label>
			   			 						<input id="realname" name="realname" value="" type="text" style="font-size: 12px;" class="mui-input-clear required"  >
			   			 					</div>
			   			 					<div class="mui-input-row" style="margin-top:3px;">
			   			 						<label style="height:45px;">提现金额:</label>
			   			 						<input id="amount" name="amount" placeholder="代扣银行手续费" value="" type="number" style="font-size: 12px;" class="mui-input-clear number required" parsley-min="{$takecashs.takecashlimit}"  parsley-max="{$takecashs.allowtakecash}">
			   			 					</div>
			   			 					<div class="mui-input-row" style="margin-top:3px;">
			   			 						<label style="height:45px;">身份证:</label>
			   			 						<input id="idcard" name="idcard" placeholder="" value="" type="text" style="font-size: 12px;" class="mui-input-clear required"  parsley-trigger="keyup" parsley-rangelength="[18,18]" parsley-error-message="请输入18位身份证号码">
			   			 					</div>
										</div>
										</form>
									{/if}
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
	{literal}	 
	    mui.init({
	        pullRefresh: {
	            container: '#pullrefresh', //待刷新区域标识，querySelector能定位的css选择器均可，比如：id、.class等  
	        },
	    });
		mui.ready(function() {  
			mui('#pullrefresh').scroll();
			mui('.mui-bar').on('tap','a',function(e){
				mui.openWindow({
					url: this.getAttribute('href'),
					id: 'info'
				});
			});  
			mui('.mui-table-view').on('tap','a',function(e){
				mui.openWindow({
					url: this.getAttribute('href'),
					id: 'info'
				});
			});
			mui('.mui-bar').on('tap','a.submit',function(e){   
				 
				var validate = Zepto( '#frm' ).parsley( 'validate' );
				 
				if (validate)
				{
					if (Zepto('#type').val() != "submit") return; 
					Zepto('#type').val("");
					var bank = Zepto('#bank').val();  
					var account = Zepto('#account').val();
					var realname = Zepto('#realname').val();
					var amount = Zepto('#amount').val(); 
					var idcard = Zepto('#idcard').val();
					var token = Zepto('#token').val();
					 
					Zepto("#submit_button").html('正在提交,请等待!'); 
				    Zepto("#submit_icon").removeClass("icon-save"); 
					Zepto("#submit_icon").addClass("icon-loading1");  
					Zepto("#submit_icon").addClass("mui-rotation");  
			        mui.ajax({
			            type: 'POST',
			            url: "takecashs.php",
			            data: 'type=submit&bank='+bank+'&account='+account+'&realname='+realname+'&amount='+amount+'&idcard='+idcard+'&token='+token,
			            success: function(json) {  
			                var jsondata = eval("("+json+")");
			                if (jsondata.code == 200) {    
								Zepto("#submit_button").html('提交成功'); 
							    Zepto("#submit_icon").removeClass("icon-loading1"); 
								setTimeout("window.location.href = 'takecashs.php';",500); 
			                } 
							else
							{
								 mui.toast(jsondata.msg); 
								 setTimeout("back_takecashs();",500);
							} 
						  }
			        }); 
				} 
			}); 
	   }); 
	   
	function back_takecashs()
	{
		Zepto('#type').val("submit");
		Zepto("#submit_button").html('提交'); 
	    Zepto("#submit_icon").removeClass("icon-loading1"); 
		Zepto("#submit_icon").addClass("icon-save");  
		Zepto("#submit_icon").removeClass("mui-rotation");  
	}
	function onbankchange(bank)
	{
		if (bank == "支付宝")
		{
			$("#account_label").html("支付宝账号:");  
		}
		else if (bank == "微信号")
		{
			$("#account_label").html("微信号:");  
		}
		else
		{
			$("#account_label").html("银行账号:");  
		} 
	}
	{/literal} 
	</script>
{include file='weixin.tpl'} 
<script src="/public/js/baidu.js?_=20140821" type="text/javascript"></script>
</body> 
</html>
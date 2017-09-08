<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
	<title>意见</title>
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
		{literal}
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
		{/literal}
	</style>
	{include file='theme.tpl'}
</head>
<body>

	<div class="mui-inner-wrap">
		<header class="mui-bar mui-bar-nav" style="padding-right: 15px;">
		     <a href="/official/approval.php" class="mui-icon mui-icon-back mui-pull-left"></a> 
			<h1 class="mui-title">待我宴请意见</h1>
            <div class="mui-title mui-content tit-sortbar" id="sortbar"> 
 				<div id="segmentedControl" class="mui-segmented-control mui-segmented-control-inverted mui-segmented-control-negative">
 					<a class="mui-control-item iconfont icon-daishenpi button-color mui-active" href="pendingopiniontreat.php">&nbsp;发表意见</a> 
					<a class="mui-control-item iconfont icon-shenpijilu button-color" href="opinionrecord.php?type=treat">&nbsp;意见记录</a>
 				</div> 
            </div> 
		</header> 
		 <div id="pullrefresh" class="mui-content mui-scroll-wrapper" style="padding-top: 85px;">  
			<div class="mui-scroll"> 
				<div class="mui-table-view">
					<h6 class="mui-content-padded" style="height:3px;margin:0px">&nbsp;</h6>  
					{if $officialopinion|@count eq 0}
						<div class="mui-card" style="margin: 3px 3px;">  
							<ul id="list" class="mui-table-view" style="padding-top: 5px;padding-bottom: 5px;"> 
								<div class="mui-content-padded">
									 <p class="tishi"><span class="mui-icon iconfont icon-tishi"></span></p>
									 <p class="msgbody">目前没有需要您发表意见的操作！<br><br> </p>
							    </div>  
							</ul> 
						</div>
					{else}
						<div class="mui-card" style="margin: 3px 3px;">  
				   				<input id="approvalid" name="approvalid" value="{$officialopinion.record}" type="hidden">
				   			    <div class="mui-input-row">
			 						<label style="height:65px;font-weight:bold;">意见:</label>
									<textarea style="width:71%;margin-right:5px;margin-bottom:5px;" required="required" parsley-minlength="10" class="mui-input-clear required" placeholder="请填写您的意见!" id="replytext" name="replytext" rows="2" ></textarea>
			 					</div>  
					    </div> 
	  				    <div class="mui-card mui-btn-my" style="margin: 3px 3px;background: {$supplier_info.navigationbarcolor};">  
	  					   <div class="mui-content-padded" style="margin:0px;margin-top: 5px;"> 
	  	               			<a id="saveapproval"><h5 class="show-content" style="padding: 10px;"><span class="mui-icon iconfont icon-save"></span>&nbsp;发表意见</h5></a>
	  	  				   </div> 
	  				    </div>

						{if $noofrows gt 1 }
 	   				    <div class="mui-card" style="margin: 3px 3px;">
					   	   <div class="mui-content-padded" style="height:35px;line-height:35px;">
							   <label style="font-weight:bold;">待我意见:</label> &nbsp;
							   <span class="mui-badge mui-badge-purple" style="background:#1bc1f8">{$num}/{$noofrows}</span>&nbsp;条
								   <button id="nextapproval" data-approvalid="{$officialopinion.record}" type="button" class="mui-btn mui-btn-royal  mui-pull-right" style="background:{$supplier_info.navigationbarcolor}">
									   <span class="mui-icon iconfont icon-next" ></span>&nbsp;下一条</button>
							   <button id="beforeapproval" data-approvalid="{$officialopinion.record}" type="button" class="mui-btn mui-btn-royal  mui-pull-right" style="background:{$supplier_info.navigationbarcolor};margin-right:5px">
								   <span class="mui-icon iconfont icon-next" ></span>&nbsp;上一条</button>

						    </div>
	   				    </div>
					    {/if}
						<div class="mui-card" style="margin: 3px 3px;">   
		                           <div class="mui-input-row" style="height:25px;line-height:25px;">
		                               <label style="font-weight:bold;line-height:25px">提交人:</label>
						               <span>{$officialopinion.profileid_givenname}</span>     
		                           </div>
		                           <div class="mui-input-row" style="height:25px;line-height:25px;">
		                               <label style="font-weight:bold;line-height:25px">提交时间:</label>
						               <span>{$officialopinion.published}</span>     
		                           </div> 
					    </div> 
						<h6 class="mui-content-padded" style="height:20px;margin:7px 5px 0px 10px">基本信息</h6>  
						<div class="mui-card" style="margin: 0px 3px;">  
							      {foreach name="baseinfo"  item=base_info  from=$officialopinion.baseinfo} 
								      {if $base_info.type eq 'desc'}
				                           <div class="mui-input-row" style="line-height:25px;">
				                               <label style="font-weight:bold;line-height:25px">{$base_info.label}:</label>
								               <div style="display:inline-block;text-indent:2em;">{$base_info.value}</div>     
				                           </div>  
									  {elseif $base_info.type eq 'img'}  
				                           <div class="mui-input-row" style="line-height:25px;">
				                               <label style="font-weight:bold;line-height:25px">{$base_info.label}:</label>
								               <span style="display:inline-block;width:60%">{$base_info.value}</span>     
				                           </div>
									  {else} 
				                           <div class="mui-input-row" style="height:25px;line-height:25px;">
				                               <label style="font-weight:bold;line-height:25px">{$base_info.label}:</label>
								               <span>{$base_info.value}</span>     
				                           </div>  
									  {/if}
								   {/foreach} 
					    </div> 
					{/if}
				    <h6 class="mui-content-padded" style="height:3px;margin:0px">&nbsp;</h6>  
				</div> 
					{include file='copyright.tpl'}
			</div>
		</div>
	</div> 

<script type="text/javascript">
	var num = {$num};
	console.log(num);
	{literal}
	mui.init({
				 pullRefresh: {
					 container: '#pullrefresh', //待刷新区域标识，querySelector能定位的css选择器均可，比如：id、.class等
					  
				 },
			 });
	mui.ready(function ()
			  {
				  mui('#pullrefresh').scroll();
				  mui('.mui-bar').on('tap', 'a', function (e)
				  {
					  mui.openWindow({
										 url: this.getAttribute('href'),
										 id: 'info'
									 });
				  }); 
				  
				  mui('.mui-table-view').on('tap', 'button#nextapproval', function (e)
				  { 
					  var approvalid = this.getAttribute('data-approvalid');
					  mui.openWindow({
										 url: 'pendingopiniontreat.php?nextapprovalid='+approvalid+'&num='+num,
										 id: 'info'
									 });
				  });
                  mui('.mui-table-view').on('tap', 'button#beforeapproval', function (e)
                  {
                      var approvalid = this.getAttribute('data-approvalid');
                      mui.openWindow({
                          url: 'pendingopiniontreat.php?beforeapprovalid='+approvalid+'&num='+num,
                          id: 'info'
                      });
                  });
                  mui('.mui-table-view').on('tap', 'a#saveapproval', function (e)
				  {  
					  var replytext = Zepto('#replytext').val(); 
					  if (replytext == "")
					  {
			  	 	    swal({
			  	 	         title: "提示", 
			  	 	         text: "您的意见还没有填写！", 
			  	 	         type: "warning", 
			  	 	       }, function() { });
						  return;
					  }
					  var url = this.getAttribute('href');
                      swal({
                          title: "提示",
                          text: "您确定保存意见吗？",
                          type: "warning",
                          showCancelButton: true,
                          closeOnConfirm: true,
                          confirmButtonText: "确定",
                          confirmButtonColor: "#ec6c62"
                      }, function () { 
						    var approvalid = Zepto('#approvalid').val(); 
							 
							var postbody = 'type=submit&approvalid=' + approvalid + '&replytext=' + replytext; 
							
						    mui.ajax({
   				  					 type: 'POST',
   				  					 url: "pendingopiniontreat.php",
   				  					 data: postbody,
   				  					 success: function (reponsebody)
   				  					 { 
										 if (reponsebody == "ok")
										 {
     			  						       mui.openWindow({
     			  											 url: 'opinionrecord.php?type=treat',
     			  											 id: 'info'
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

	{/literal}
</script> 
<script src="/public/js/baidu.js?_=20140821" type="text/javascript"></script>
</body>
</html>
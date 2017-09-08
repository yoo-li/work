<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
	<title>审批</title>
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
		{/literal}
	</style>
	{include file='theme.tpl'}
</head>
<body>
 
	<div class="mui-inner-wrap">
		<header class="mui-bar mui-bar-nav" style="padding-right: 15px;">
			{*<a href="/official/supplier.php?supplierid={$supplier_info.supplierid}" class="mui-icon mui-icon-back mui-pull-left"></a>*}
			<a id="returnback" class="mui-icon mui-icon-left-nav mui-pull-left"></a>
			<h1 class="mui-title">财务支付</h1>
            <div class="mui-title mui-content tit-sortbar" id="sortbar"> 
 				<div id="segmentedControl" class="mui-segmented-control mui-segmented-control-inverted mui-segmented-control-negative">
 					<a class="mui-control-item iconfont icon-daishenpi button-color mui-active" href="pendingapproval.php">&nbsp;待支付</a> 
					<a class="mui-control-item iconfont icon-shenpijilu button-color" href="approval_record.php">&nbsp;支付记录</a>
 				</div> 
            </div>
		</header> 
		 <div id="pullrefresh" class="mui-content mui-scroll-wrapper" style="padding-top: 85px;">  
			<div class="mui-scroll"> 
				<div class="mui-table-view">
					<h6 class="mui-content-padded" style="height:3px;margin:0px">&nbsp;</h6>  
					{if $approval_info|@count eq 0}
						<div class="mui-card" style="margin: 3px 3px;">  
							<ul id="list" class="mui-table-view" style="padding-top: 5px;padding-bottom: 5px;"> 
								<div class="mui-content-padded">
									 <p class="tishi"><span class="mui-icon iconfont icon-tishi"></span></p>
									 <p class="msgbody">目前没有需要您审批的操作！<br><br> </p>
							    </div>  
							</ul> 
						</div>
					{else}
						<div class="mui-card" style="margin: 3px 3px;">  
				   				<input id="approvalid" name="approvalid" value="{$approval_info.approvalid}" type="hidden">
				   			    <div class="mui-input-row">
	                                <label style="height:45px;font-weight:bold;">支付选择:</label>
						                   <span><input type="radio" value="Agree" id="radio-1" name="reply" checked >
						                   <label style="width:100px;padding: 10px 5px;" class="radio" for="radio-1">确认支付</label></span>
						                   <span><input type="radio" value="Disagree" id="radio-2" name="reply" >
						                   <label style="width:100px;padding: 10px 5px;" class="radio" for="radio-2">拒绝支付</label></span>  
	                            </div> 
		 					 
			 					<div class="mui-input-row">
			 						<label style="height:65px;font-weight:bold;">备注:</label>
									<textarea style="width:71%;margin-right:5px;margin-bottom:5px;" required="required" parsley-minlength="10" class="mui-input-clear required" placeholder="您的审批意见!" id="replytext" name="replytext" rows="2" ></textarea>
			 					</div>  
					    </div> 
	  				    <div class="mui-card" style="margin: 3px 3px;background: {$supplier_info.navigationbarcolor};">  
	  					   <div class="mui-content-padded" style="margin:0px;margin-top: 5px;"> 
	  	               			<a id="saveapproval"><h5 class="show-content" style="padding: 10px;"><span class="mui-icon iconfont icon-save"></span>&nbsp;保存审批</h5></a>
	  	  				   </div> 
	  				    </div>
						{if $noofrows gt 1}
	   				    <div class="mui-card" style="margin: 3px 3px;">
					   	   <div class="mui-content-padded" style="height:35px;line-height:35px;">
							   <label style="font-weight:bold;">待审批:</label> &nbsp;
							   <span class="mui-badge mui-badge-purple" style="background:{$supplier_info.navigationbarcolor}">{$num}/{$noofrows}</span>&nbsp;条
								   <button id="nextapproval" data-approvalid="{$approval_info.approvalid}" type="button" class="mui-btn mui-btn-royal  mui-pull-right" style="background:{$supplier_info.navigationbarcolor}">
									   <span class="mui-icon iconfont icon-next" ></span>&nbsp;下一条</button>
							   <button id="beforeapproval" data-approvalid="{$approval_info.approvalid}" type="button"
									   class="mui-btn mui-btn-royal  mui-pull-right" style="background:{$supplier_info.navigationbarcolor}">
								   <span class="mui-icon iconfont icon-next" ></span>&nbsp;上一条</button>
						   </div>
	   				    </div>
					    {/if}
						<div class="mui-card" style="margin: 3px 3px;">  
		                           <div class="mui-input-row" style="height:25px;line-height:25px;">
		                               <label style="font-weight:bold;line-height:25px">模块:</label>
						               <span>{$approval_info.modulelabel}</span>     
		                           </div>  
		                           <div class="mui-input-row" style="height:25px;line-height:25px;">
		                               <label style="font-weight:bold;line-height:25px">提交人:</label>
						               <span>{$approval_info.username}</span>     
		                           </div>
		                           <div class="mui-input-row" style="height:25px;line-height:25px;">
		                               <label style="font-weight:bold;line-height:25px">提交时间:</label>
						               <span>{$approval_info.submittime}</span>     
		                           </div> 
					    </div>
						{assign var="baseinfo" value=$approval_info.baseinfo}    
						{if $baseinfo|@count gt 0} 
						<h6 class="mui-content-padded" style="height:20px;margin:7px 5px 0px 10px">基本信息</h6>  
						<div class="mui-card" style="margin: 0px 3px;">  
							      {foreach name="baseinfo"  item=base_info  from=$baseinfo} 
								      {if $base_info.type eq 'desc'}
				                           <div class="mui-input-row" style="line-height:25px;">
				                               <label style="font-weight:bold;line-height:25px">{$base_info.translatedfieldlabel}:</label>
								               <div style="display:inline-block;text-indent:2em;">{$base_info.value}</div>     
				                           </div>  
									  {elseif $base_info.type eq 'img'}  
				                           <div class="mui-input-row" style="line-height:25px;">
				                               <label style="font-weight:bold;line-height:25px">{$base_info.translatedfieldlabel}:</label>
								               <span style="display:inline-block;width:60%">{$base_info.value}</span>     
				                           </div>
									  {else} 
				                           <div class="mui-input-row" style="height:25px;line-height:25px;">
				                               <label style="font-weight:bold;line-height:25px">{$base_info.translatedfieldlabel}:</label>
								               <span>{$base_info.value}</span>     
				                           </div>  
									  {/if}
								   {/foreach} 
					    </div>
						{/if}
					{/if}
				    <h6 class="mui-content-padded" style="height:3px;margin:0px">&nbsp;</h6>  
				</div> 
					{include file='copyright.tpl'}
			</div>
		</div>
	</div>
	<script type="text/javascript">
        {literal}
        mui.ready(function ()
        {

            document.getElementById('returnback').addEventListener('tap', function() {
//                console.log(111111);
                Cordova.exec(null, null, "PhoneGapPlugin", "PluginFunction", [{"type":"historyback"}]);
            });

        });
        {/literal}
	</script>
<script type="text/javascript">
	var	num = {$num};
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
										 url: 'pendingapproval.php?nextapprovalid='+approvalid+'&num='+num,
										 id: 'info'
									 });
				  });
                  mui('.mui-table-view').on('tap', 'button#beforeapproval', function (e)
                  {
                      var approvalid = this.getAttribute('data-approvalid');
                      mui.openWindow({
                          url: 'pendingapproval.php?beforeapprovalid='+approvalid+'&num='+num,
                          id: 'info'
                      });
                  });

                  mui('.mui-table-view').on('tap', 'a#saveapproval', function (e)
				  {  
					  var url = this.getAttribute('href');
                      swal({
                          title: "提示",
                          text: "您确定保存审批吗？",
                          type: "warning",
                          showCancelButton: true,
                          closeOnConfirm: true,
                          confirmButtonText: "确定",
                          confirmButtonColor: "#ec6c62"
                      }, function () { 
						    var approvalid = Zepto('#approvalid').val();
						    var replytext = Zepto('#replytext').val(); 
							var reply = ""; 
							Zepto.each(Zepto('input[name=reply]'), function (i, v){
								var checked = $(this).prop("checked");
								if (checked)
								{
									reply = $(this).val(); 
								}
							});
							var postbody = 'approvalid=' + approvalid + '&reply=' + reply + '&replytext=' + replytext; 
							
						    mui.ajax({
   				  					 type: 'POST',
   				  					 url: "saveapproval.php",
   				  					 data: postbody,
   				  					 success: function (reponsebody)
   				  					 {

                                         if (reponsebody == "ok")
                                         {
                                             mui.openWindow({
                                                 url: 'pendingapproval.php',
                                                 id: 'info'
                                             });
                                         }
                                         else
                                         {
                                             swal({
                                                 title: "提示",
								 	 	         text: "审批保存失败，请稍后再试！"+ reponsebody,
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
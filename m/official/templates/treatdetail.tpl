<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
	<meta name="format-detection" content="telephone=no" />
	<title>宴请信息</title>
	<link rel="stylesheet" href="/public/css/mui.min.css">
    <link href="/public/css/public.css" rel="stylesheet" />
     <link href="/public/css/common.css" rel="stylesheet" />
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
		{literal}
		  
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

        .mui-table-view input[type='radio']{
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

        .mui-table-view input[type='radio']{
        }

        .mui-table-view input[type='radio']:before{
            content:'\e411';
        }

        .mui-table-view input[type='radio']:checked:before{
            content:'\e441';
        }

        .mui-table-view input[type='radio']:checked:before{
            color:#007aff;
        }

        .mui-table-view input[type='radio']:before{
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
		  
		
		{/literal}
	</style>
	{include file='theme.tpl'}
</head>
<body>
 
	<div class="mui-inner-wrap">
		<header class="mui-bar mui-bar-nav" style="padding-right: 15px;">
		    <a class="mui-icon mui-action-back mui-icon-back mui-pull-left"></a> 
			<h1 class="mui-title">宴请信息</h1>
		</header> 
         <div id="pullrefresh" class="mui-content mui-scroll-wrapper" style="padding-top: 45px;"> 
                 <div class="mui-scroll">  
					     <form class="mui-input-group" name="frm" id="frm" method="post" action=""  parsley-validate> 
					     <div class="mui-card" style="margin: 3px 3px;">
		                    <ul class="mui-table-view" style="padding-top: 5px;padding-bottom: 5px;"> 
	                                    <div class="mui-input-row" style="margin-top:3px;">
	                                        <label>授权:</label>
											<input id="authorizeevent" name="authorizeevent" value="{$officialtreat.authorizeevent}" type="hidden">	
										    <input id="authorizeevent_text" name="authorizeevent_text" value="{$officialtreat.authorizeevent_text}" 
		                                           disabled  type="text" class="mui-input-clear"
		                                           maxlength="20" placeholder="请选择授权"> 
	                                    </div>	                             
		                                <div class="mui-input-row" style="margin-top:3px;">
		                                    <label>宴请对象:</label> 
		                                    <input disabled required="required" name="treatobject"
		                                           value="{$officialtreat.treatobject}" type="text" style="font-size: 12px;"
		                                           class="mui-input-clear required"  placeholder="宴请对象公司">
		                                </div>
	                               
	                                    <div class="mui-input-row" style="margin-top:3px;">
	                                        <label>参与人员:</label>
		                                    <input disabled required="required"  name="participants"
		                                           value="{$officialtreat.participants}" type="text" style="font-size: 12px;"
		                                           class="mui-input-clear required"  placeholder="参与人员">
	                                    </div>  
										
	                                    <div class="mui-input-row" style="margin-top:3px;">
	                                        <label>宴请地点:</label>
		                                    <input disabled required="required"  name="address"
		                                           value="{$officialtreat.address}" type="text" style="font-size: 12px;"
		                                           class="mui-input-clear required"  placeholder="宴请地点">
	                                    </div> 
	                                    <div class="mui-input-row" style="margin-top:3px;">
	                                        <label>宴请日期:</label>
										    <input disabled id="treatdatetime" name="treatdatetime" value="{$officialtreat.treatdatetime}"  type="text" class="mui-input-clear required"
		                                           maxlength="20" placeholder="请输入宴请日期">
		                                     
	                                    </div>
	                                    <div class="mui-input-row" style="margin-top:3px;">
	                                        <label>预计金额:</label>
		                                    <input disabled required="required"  name="estimatedcost"
		                                           value="{$officialtreat.estimatedcost}" type="number" style="font-size: 12px;"
		                                           class="mui-input-clear required"  placeholder="预计金额（元）">
	                                    </div>    
	                                    <div class="mui-input-row" style="margin-top:3px;">
	                                        <label>人均消费:</label>
		                                    <input disabled required="required"  name="percapita"
		                                           value="{$officialtreat.percapita}" type="number" style="font-size: 12px;"
		                                           class="mui-input-clear required"  placeholder="人均消费（元）">
	                                    </div>
	                                    <div class="mui-input-row" style="margin-top:3px;">
	                                        <label style="height:65px;">宴请理由:</label>
											<textarea disabled name="treatreason" required="required" parsley-minlength="10" class="mui-input-clear required" placeholder="宴请理由"   rows="2" >{$officialtreat.treatreason}</textarea>
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
										{assign var=approvals value=$officialtreat.approvals}
										{if $approvals|@count gt 0}
											{foreach name="approvals" item=approval_info from=$approvals}
											    {if $approval_info.pos eq 'start'}
											    	<tr class="even first-line">
											    {elseif $approval_info.pos eq 'end'}
											        <tr class="even last-line checked">
											    {else}
											        <tr class="odd">
											    {/if}
		                        	 		
												<td class="col1"><span class="result-date">{$approval_info.date}</span><span class="result-time">{$approval_info.time}</span></td><td class="colstatus"></td>
												<td class="col2"><span>{$approval_info.route}</span></td>
												</tr>   
			                        	 	{/foreach} 
		                        	 	{else}
											<tr>
												<td>
													<li class="mui-table-view-cell" style="padding-right:0px;" id="loading">
														<div class="mui-media-body" style="color:red;text-align:center;">
															<span class="mui-icon iconfont icon-loading1 mui-rotation"></span><span> 没有审批信息...</span>
														</div>
													</li>
												</td>
											</tr>
										{/if}
									</table>
								</div>
							</div>
						</ul>  	
					</div>   
                    <div class="mui-card" style="margin: 3px 3px;">
						<h4 class="mui-content-padded" style="margin-bottom:0px;">关注人</h4> 
	                    <ul id="opinion_div" class="mui-table-view" style="padding-left: 10px;padding-bottom: 5px;">   
									{foreach name="opinions" item=opinion_info from=$officialtreat.opinion_givennames}
									<li style="float:left;padding: 8px 5px;text-align:center;"><img style="width:50px;height:50px;" src="{$opinion_info.headimgurl}"><br>{$opinion_info.givenname}</li>
									{/foreach} 
						 </ul>			
					</div>
					{assign var=officialopinions value=$officialtreat.officialopinions}
					{if $officialopinions|@count gt 0}
					<div class="mui-card" style="margin: 3px 3px;"> 
						 <h4 class="mui-content-padded" style="margin-bottom:0px;">关注意见</h4>
						 <ul id="wuliuinfo_ul" class="mui-table-view" style="height:100%;">
							{foreach name="officialopinions" item=officialopinion_info from=$officialopinions}
							<li class="mui-table-view-cell" style="padding: 8px 5px;"> 			 	
								<div class="mui-media-body">			 		
									<img class="mui-media-object mui-pull-left" style="width:20px;height:20px;" src="{$officialopinion_info.profile.headimgurl}">			 		
									<span style="text-align:left;display:inline-block;">{$officialopinion_info.profile.givenname}</span> <span style="padding-left:20px;color:#999">{$officialopinion_info.submitdatetime}</span>		 		 	
								</div> 	
										 	
								<div class="mui-media-body" style="padding-left:30px;color:#4d4d4d">{$officialopinion_info.opinion}</div>			 	
							</li>
							{/foreach} 
						 </ul>	
					</div>  
					{/if}
					<h4 class="mui-content-padded" style="margin-bottom:0px;height:1px;">&nbsp;</h4> 
 				    </form>  
 				   {include file='copyright.tpl'}
 				</div>
 		</div>
		 
	</div> 

<script type="text/javascript">  
	{literal}
	mui.init({
				 pullRefresh: {
					 container: '#pullrefresh' //待刷新区域标识，querySelector能定位的css选择器均可，比如：id、.class等 
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
				 
			  }); 

	{/literal}
</script> 
<script src="/public/js/baidu.js?_=20140821" type="text/javascript"></script>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
	<title>授权信息</title>
	<link rel="stylesheet" href="/public/css/mui.min.css">
    <link href="/public/css/public.css" rel="stylesheet" />
     <link href="/public/css/common.css" rel="stylesheet" />
	<link href="/public/css/iconfont.css" rel="stylesheet"/>
	<link href="/public/css/parsley.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="/public/css/mui.picker.min.css" />
	<link href="/public/css/mui.poppicker.css" rel="stylesheet" />
	<link href="/public/css/mui.poppicker.css" rel="stylesheet" />

	<script src="/public/js/mui.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="/public/js/zepto.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/public/js/utils.js" type="text/javascript" charset="utf-8"></script>

    <script src="/public/js/parsley.min.js"></script>
    <script src="/public/js/parsley.zh_cn.js"></script>

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
        #change_status{
            width:98%;
            background: #f81b3f;
            color:white;
            margin-left:1%;
            margin-top:10px;
        }

		{/literal}
	</style>
	{include file='theme.tpl'}
</head>
<body>

	<div class="mui-inner-wrap">
		<header class="mui-bar mui-bar-nav" style="padding-right: 15px;">
		    <a class="mui-icon mui-action-back mui-icon-back mui-pull-left"></a>
			<h1 class="mui-title">授权信息</h1>
		</header>
         <div id="pullrefresh" class="mui-content mui-scroll-wrapper" style="padding-top: 45px;">
                 <div class="mui-scroll">
					     <form class="mui-input-group" name="frm" id="frm" method="post" action=""  parsley-validate>
					     <div class="mui-card" style="margin: 3px 3px;">
		                    <ul class="mui-table-view" style="padding-top: 5px;padding-bottom: 5px;">
	                                <div class="mui-input-row" style="margin-top:3px;">
	                                    <label>授权标题:</label>
	                                    <input disabled  value="{$officialauthorizeevent.authorizationtitle}" type="text" style="font-size: 12px;"
	                                           class="mui-input-clear required">
	                                </div>
	                                <div class="mui-input-row" style="margin-top:3px;">
	                                    <label>授权类型:</label>
	                                    <input disabled  value="{$officialauthorizeevent.authorizationtype}" type="text" style="font-size: 12px;"
	                                           class="mui-input-clear required">
	                                </div>
	                                <div class="mui-input-row" style="margin-top:3px;">
	                                   <label>有效期起:</label>
	                                   <input disabled  value="{$officialauthorizeevent.startdate}" type="text" style="font-size: 12px;" class="mui-input-clear required">
	                                </div>
	                                <div class="mui-input-row" style="margin-top:3px;">
	                                   <label>有效期止:</label>
	                                   <input disabled  value="{$officialauthorizeevent.enddate}" type="text" style="font-size: 12px;" class="mui-input-clear required">
	                                </div>
	                                <div class="mui-input-row" style="margin-top:3px;">
	                                   <label>授权用途:</label>
	                                   <input disabled  value="{$officialauthorizeevent.authorizedtype}" type="text" style="font-size: 12px;" class="mui-input-clear required">
	                                </div>
	                                <div class="mui-input-row" style="margin-top:3px;">
	                                   <label>授权人:</label>
	                                   <input disabled  value="{$officialauthorizeevent.authorizedperson}" type="text" style="font-size: 12px;" class="mui-input-clear required">
	                                </div>
	                                <div class="mui-input-row" style="margin-top:3px;">
	                                   <label>决定人:</label>
	                                   <input disabled  value="{$officialauthorizeevent.decider}" type="text" style="font-size: 12px;" class="mui-input-clear required">
	                                </div>
	                                <div class="mui-input-row" style="margin-top:3px;">
	                                   <label>关注人:</label>
	                                   <input disabled  value="{$officialauthorizeevent.opinion}" type="text" style="font-size: 12px;" class="mui-input-clear required">
	                                </div>
	                                <div class="mui-input-row" style="margin-top:3px;">
	                                   <label>业务申请人:</label>
	                                   <input disabled  value="{$officialauthorizeevent.applicant}" type="text" style="font-size: 12px;" class="mui-input-clear required">
	                                </div>
	                                <div class="mui-input-row" style="margin-top:3px;">
	                                   <label>授权内容描述:</label>
	                                   <textarea disabled  type="text" style="font-size: 12px;" class="mui-input-clear required">{$officialauthorizeevent.authorizationdescription}</textarea>
	                                </div>
								<input type="hidden" value="{$id_now}" id = "id_now">
		                    </ul>
                     </div>
					{assign var=details value=$officialauthorizeevent.details}
					{if $details|@count gt 0}
					 <div class="mui-card" style="margin: 3px 3px;">
	 		 					<ul id="list" class="mui-table-view">
								<h5>
									<li class="mui-table-view-cell fubusi-title" style="background-color: #efeff4;">
										<div class="mui-media-body  mui-pull-left"><span style="width:120px;text-align:left;display:inline-block;">维度类别</span></div>
										<div class="mui-media-body  mui-pull-left"><span style="padding-left:5px;">比较符</span></div>
										<div class="mui-media-body mui-pull-right" style="width:30px;text-align:right;">序号</div>
										<div class="mui-media-body mui-pull-right" style="text-align:right;">维度值</div>
									</li>
								</h5>
								   {foreach name="details" item=detail_info from=$details}
							        <li class="mui-table-view-cell">
										<div class="mui-media-body  mui-pull-left"><span style="display:inline-block;white-space:nowrap;width:120px;text-align:left;overflow: hidden;">{$detail_info.dimensiontypename}</span></div>
										<div class="mui-media-body  mui-pull-left"><span style="padding-left:5px;">{$detail_info.comparisonoperator}</span></div>
										<div class="mui-media-body mui-pull-right" style="width:30px;text-align:right;"><span>{$detail_info.pos}</span></div>
										<div class="mui-media-body mui-pull-right" style="text-align:right;"><span class="price">{$detail_info.dimensionvalue}</span></div>
									</li>
									{/foreach}
								</ul>

					 </div>

					 {/if}
							 {*添加判断 如果嗯登陆着为授权人 则 有权限进行提交*}

							 {if $authorizedperson_now == $user_now && $status_now == 'JustCreated' && $sign==1}
								 <button id="change_status">提交上线</button>
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
	<script type="text/javascript">
		var id_now = $("#id_now").val();
		console.log(id_now);
		{literal}
//		alert('asafasdfads')
        $("#change_status").click(function(){
            alert('click');
            mui.ajax('change_statues.php',{
                data:{
                    id_now:id_now
                },
                type:'POST',//HTTP请求类型
                success: function(data) {
                    alert('ajax_success');
                    alert(data);
                    $("#change_status").text(data);
                    mui.toast('上线成功')
                }
            });
//            $.ajax({
//                url:"change_statues.php",  //编写处理页面
////                data:id_now,  //将code值传过去
//                type:"POST",
//                data: {"id_now":id_now},
//                dataType:"TEXT",
//                success: function(data) {
//                    $("#change_status").text(data);
//                    alert(data)
//                    console.log(data)
//                }
//            });
        });

        {/literal}

	</script>
<script src="/public/js/baidu.js?_=20140821" type="text/javascript"></script>
</body>
</html>
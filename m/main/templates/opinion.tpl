<!DOCTYPE html>
<html> 
	<head>
		<meta charset="utf-8">
		<title>填写意见反馈</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black"> 
		<!--标准mui.css-->
		<link rel="stylesheet" href="/public/css/mui.min.css">
	    <link href="/public/css/public.css" rel="stylesheet" />  
		<link href="/public/css/iconfont.css" rel="stylesheet" />
	    <link href="/public/css/parsley.css" rel="stylesheet">  
	    <link href="/public/css/sweetalert.css" rel="stylesheet"/>
		<!--App自定义的css-->
		<link rel="stylesheet" type="text/css" href="/public/css/tezan.css" /> 
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
	            width:35%;
	        }

	        .mui-input-row label ~ input, .mui-input-row label ~ select, .mui-input-row label ~ textarea{
	            float:right;
	            width:65%;
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
 

	        {/literal}
	    </style>
		 {include file='theme.tpl'}
	</head>

	<body> 
        <nav class="mui-bar mui-bar-tab" style="height:40px;line-height:40px;">
            <a class="mui-tab-item save" href="#">
                <span class="mui-icon iconfont icon-save button-color">&nbsp;<span style="font-size:20px;">保存</span></span>
            </a>
        </nav>
		<div class="mui-content">
			
           <div class="mui-card" style="margin: 3px 3px;">
               <ul class="mui-table-view" style="padding-top: 5px;padding-bottom: 5px;">

                   <form class="mui-input-group" name="frm" id="frm" method="post" action="opinion.php"
                         parsley-validate> 
						 <input name="type" value="submit" type="hidden">
                        <div class="mui-input-row" style="margin-top:3px;">
                            <label style="height:45px;">问题分类:</label>
                            <input name="opinionid" value="{$opinionid}" type="hidden">
                            <span style="font-size: 12px;line-height: 40px;height: 40px;">{$reason}</span>
                        </div>
                        <div class="mui-input-row" style="margin-top:3px;">
                            <label style="height:45px;">问题发生时间:</label>  
							<span style="font-size: 12px;line-height: 40px;height: 40px;">{$datetime}</span>
                        </div>
                        <div class="mui-input-row" style="margin-top:3px;">
                            <label style="height:45px;">手机号码:</label> 
                            <input required="required" parsley-rangelength="[11,11]" id="mobile" name="mobile"
                                   value="{$profile_info.mobile}" type="number" style="font-size: 12px;"
                                   class="mui-input-clear required" maxlength="11" placeholder="您的常用手机号码"
                                   parsley-error-message="请输入正确的手机号码">
                        </div>  
						<div class="mui-table-view-divider">补充内容:</div>
						<div class="row mui-input-row">
							<textarea name='question' required="required" class="mui-input-clear question required" placeholder="请详细描述您的问题和意见..."></textarea>
						</div>
					     <br>
				   </form>
               </ul>
           </div>
           {include file='copyright.tpl'}
               
					
			<div class="mui-content-padded">  
				<p>
					 
				</p> 	
			</div>
		</div>
		<script src="/public/js/mui.min.js"></script>
		<script src="/public/js/zepto.min.js"></script>
	    <script src="/public/js/parsley.min.js"></script>
	    <script src="/public/js/parsley.zh_cn.js"></script> 
	    <script type="text/javascript" src="/public/js/sweetalert.min.js"></script> 
		<script type="text/javascript" charset="utf-8">
		{literal}
			mui.init({
				gestureConfig: {
					longtap: true
				},
				swipeBack: false //启用右滑关闭功能
			}); 
		    mui.ready(function () { 
		        mui('.mui-bar').on('tap', 'a.save', function (e) {
		            var validate = Zepto('#frm').parsley('validate');
		            if (validate) 
					{ 
		                    swal({
		                        title: "提示",
		                        text: "您确定提交吗？",
		                        type: "warning",
		                        showCancelButton: true,
		                        closeOnConfirm: true,
		                        confirmButtonText: "确定",
		                        confirmButtonColor: "#ec6c62"
		                    }, function () {
		                        document.frm.submit();
		                    }); 
		            }
		        });
		   });		
		{/literal}
		</script>
	</body>

</html>
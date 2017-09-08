<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="Shortcut icon" href="favicon.ico">   
<title>找回密码</title>
<!-- bootstrap - css -->
<link href="/Public/BJUI/themes/css/bootstrap.css" rel="stylesheet"> 
<link href="Public/css/sweetalert.css" rel="stylesheet" />
<link href="/Public/BJUI/themes/css/FA/css/font-awesome.min.css" rel="stylesheet">
<link href="/Public/BJUI/plugins/niceValidator/jquery.validator.css" rel="stylesheet">
<link href="/Public/BJUI/plugins/bootstrapSelect/bootstrap-select.css" rel="stylesheet">
<link href="Public/css/forgetpassword.css" rel="stylesheet" /> 
{if $domain eq 'admin'}
<link href="Public/css/login_blue.css" rel="stylesheet">
{elseif $domain eq 'vip'}
<link href="Public/css/login_green.css" rel="stylesheet"> 
{/if}  
<script src="/Public/js/jquery-1.11.3.min.js"></script>  
<!-- nice validate -->
<script src="/Public/BJUI/plugins/niceValidator/jquery.validator.js"></script> 
<script src="/Public/BJUI/plugins/niceValidator/local/zh_CN.js"></script>
<script src="/Public/js/jquery.validator.themes.js"></script>

<!-- bootstrap plugins -->
<script src="/Public/BJUI/plugins/bootstrap.min.js"></script> 
<script src="/Public/BJUI/plugins/bootstrapSelect/bootstrap-select.min.js"></script>
<script src="/Public/BJUI/plugins/bootstrapSelect/defaults-zh_CN.min.js"></script>

<!-- sweetalert plugins -->
<script src="/Public/js/sweetalert.min.js"></script> 
</head>
<body>
	
	
<div class="mainheader">	
	<div class="mainheader-content">
		<div class="mainheader-title">欢迎访问{$copyrights.name}，{$copyrights.manifesto}！</div>
		<div class="mainheader-info">		 
				 <div class="info">
					  <a href="index.php?action=Login&module=Users"><span style="color:#fff;">登录</span></a>
					  <span class="separate">|</span>
				 </div>	 
				 <div class="info">
					  <a href="index.php?action=Register&module=Users"><span style="color:#fff;">注册</span></a>
					  <span class="separate">|</span>
				 </div>
				<div class="info contactphone"><span class="glyphicon glyphicon-earphone"></span>咨询 {$copyrights.mobile} </div>
			</div>	 
	</div> 
</div>    

 
	<div class="validation_module clearfix">
		<div class="wrap binding_mobile">
			<div class="validation_common">
				<h1>找回密码</h1>	
				<div class="verify_step">
					<div class="inner">
						<ol class="steps"> <!-- span元素添加此样式 class="done"-->
							<li class="first"><span {if $STEP eq 'forgot_pwd' || $STEP eq 'verify_user' || $STEP eq 'new_pwd' || $STEP eq 'finished'}class="done"{/if}><em>找回密码</em><i></i></span></li>
							<li class="second"><span {if $STEP eq 'verify_user' || $STEP eq 'new_pwd' || $STEP eq 'finished' }class="done"{/if}><em>验证</em><i></i></span></li>
							<li class="thrid"><span {if $STEP eq 'new_pwd' || $STEP eq 'finished'}class="done"{/if}><em>新密码</em><i></i></span></li>
							<li class="fourth"><span {if $STEP eq 'finished'}class="done"{/if}><em>重置完成</em><i></i></span></li>
							<li class="last"><span {if $STEP eq 'finished'}class="done"{/if}><i></i></span></li>
						</ol>
					</div>
				</div>			
				{if $STEP eq 'forgot_pwd'}				
					<form action="index.php" method="post" name="find_pwd_form" id="find_pwd_form">
						<input type="hidden" name="module" value="Users" /> 
						<input type="hidden" name="action" value="Forgetpassword" />
						<input type="hidden" name="guid" value="{$GUID}" id="guid" > 
					    <input type="hidden" name="step" value="{$STEP}" />
						<div class="security_code"><!-- 获取验证码 -->
							<ul> 
								<li class="ui-form-item">
		                                <label class="ui-label">
									    <span style="display: inline" class="ui-form-required">*</span>用户名：</label>
		                                <input type="text" value="" placeholder="请输入用户名或手机号码" name="username" tabindex="1" maxlength="30" id="username" class="ui-input" data-rule="required;remote[passport/checkuser.php]"> 
		                        </li>
								<li class="ui-form-item">
		                                <label class="ui-label">
										<span style="display: inline" class="ui-form-required">*</span>验证码：</label>
		                                <input type="text" value="" placeholder="请输入验证码" name="checkcode" tabindex="3" maxlength="4" id="checkcode" class="ui-input" data-rule="required;" style="width:90px;" >
 
							   			<span class="msg-box" >
											<img id="captcha_img" style="" alt="点击更换" title="点击更换" src="/plugins/checkcode/make.php?sessionID={$GUID}" class="m">
							   			</span>
										<span class="msg-box" for="checkcode"></span>
		                        </li>
								<li>
									<div class="labcon"><!--点击按钮后添加样式 loading_mask -->
								 		<input id="submit_btn" type="submit" class="common_btn big_btn" value="下一步" />
								 		<span class="big_mask"><i class="loading_icon"></i></span>
								 	</div>
								</li> 
							</ul>
						</div>
					</form>
				{/if}
				{if $STEP eq 'verify_user'}				
					<form action="index.php" method="post" name="verify_user_form" id="verify_user_form">
						<input type="hidden" name="module" value="Users" /> 
						<input type="hidden" name="action" value="Forgetpassword" />
						<input type="hidden" name="guid" value="{$GUID}" id="guid" > 
						<input type="hidden" name="profileid" value="{$PROFILEID}" id="profileid" > 
					    <input type="hidden" name="step" value="{$STEP}" />
						<div class="security_code"><!-- 获取验证码 -->
							<ul> 
								<li class="ui-form-item">
		                                <label class="ui-label">用户名：</label>
		                                <input disabled type="text" value="{$USERNAME}"  class="ui-input"> 
		                        </li>
								<li class="ui-form-item">
		                                <label class="ui-label">手机号码：</label>
		                                <input disabled type="text" id="mobile" value="{$MOBILE}"  class="ui-input"> 
		                        </li>
								<li class="ui-form-item">
		                                <label class="ui-label">
										<span style="display: inline" class="ui-form-required">*</span>短信验证码：</label>
		                                <input type="text" value="" placeholder="请输入验证码" name="checkcode" tabindex="3" maxlength="6" id="checkcode" class="ui-input" data-rule="required;" style="width:90px;" >
  									  	<span class="msg-box" >
											<input id="sendmobile_btn" type="button" class="sendmobile_btn" value="获取验证码" />
										</span>
										<span class="msg-box" for="checkcode"></span>
		                        </li>
								<li>
									<div class="labcon"><!--点击按钮后添加样式 loading_mask -->
								 		<input id="submit_btn" type="submit" class="common_btn big_btn" value="下一步" />
								 		<span class="big_mask"><i class="loading_icon"></i></span>
								 	</div>
								</li> 
							</ul>
						</div>
					</form>
				{/if}
				{if $STEP eq 'new_pwd'}				
					<form action="index.php" method="post" name="new_pwd_form" id="new_pwd_form">
						<input type="hidden" name="module" value="Users" /> 
						<input type="hidden" name="action" value="Forgetpassword" />
						<input type="hidden" name="guid" value="{$GUID}" id="guid" > 
						<input type="hidden" name="profileid" value="{$PROFILEID}" id="profileid" > 
					    <input type="hidden" name="step" value="{$STEP}" />
						<div class="security_code"><!-- 获取验证码 -->
							<ul> 
								<li class="ui-form-item">
		                                <label class="ui-label"><span style="display: inline" class="ui-form-required">*</span>新密码：</label>
										 <input type="password" class="ui-input" data-rule="新密码:required" name="newpassword" id="newpassword" value="" placeholder="新密码" size="20" maxlength="20">
		                        </li>
								<li class="ui-form-item">
		                                <label class="ui-label"><span style="display: inline" class="ui-form-required">*</span>确认密码：</label>
		                               <input type="password" class="ui-input" data-rule="required;match(newpassword)" name="" id="j_pwschange_secpassword" value="" placeholder="确认新密码" size="20" maxlength="20">
		                        </li>   
								<li>
									<div class="labcon"><!--点击按钮后添加样式 loading_mask -->
								 		<input id="submit_btn" type="submit" class="common_btn big_btn" value="下一步" />
								 		<span class="big_mask"><i class="loading_icon"></i></span>
								 	</div>
								</li> 
							</ul>
						</div>
					</form>
				{/if}
				{if $STEP eq 'finished'}				
					<form action="index.php" method="post" name="finished" id="finished">
						<input type="hidden" name="module" value="Users" /> 
						<input type="hidden" name="action" value="Login" />
						<div class="security_code"><!-- 获取验证码 -->
							<ul> 
								<li>
									<div class="labcon"><!--点击按钮后添加样式 loading_mask -->
								 		<input id="submit_btn" type="submit" class="common_btn big_btn" value="密码重置成功" />
								 		<span class="big_mask"><i class="loading_icon"></i></span>
								 	</div>
								</li> 
							</ul>
						</div>
					</form>
				{/if}
			</div>
		</div>
	</div> 
	
<!--footer-->
<div class="footer_module clearfix">
	Copyright &copy; 2010-2015 <a href="http://www.{$copyrights.site}" target="_blank">{$copyrights.site}</a> All Rights Reserved.  {$copyrights.icp}
</div>	
<script type="text/javascript">
{literal}
$(function() { 
	$("#captcha_img").click(function(){
		changeCode();
	});
	$('#find_pwd_form').validator({
	    rules: {
	        //自定义一个规则，用来代替remote（注意：要把$.ajax()返回出来）
	        verifycodeRemote: function(element){
				var guid = $("#guid").val();
	            return $.ajax({
	                url: 'passport/checkverifycode.php',
	                type: 'post',
	                data: element.name + '=' + element.value + "&guid=" + guid,
	                dataType: 'json',
	                success: function(d){}
	            });
	        }
	    },
	    fields: {
	        'checkcode': 'required;verifycodeRemote;'
	    }, 
	});
	 
	$('#find_pwd_form').on('valid.form', function(e, form){
	     $("#submit_btn").attr("disabled", true).val('提交中..'); 
		 document.find_pwd_form.submit(); 
	});
	
	
	$("#sendmobile_btn").click(function(){
		var guid = $("#guid").val();
		var mobile = $("#mobile").val();
		var profileid = $("#profileid").val();
	    $.ajax({
                url: 'passport/sendmobilecode.php',
                type: 'post',
                data: "guid=" + guid + "&mobile=" + mobile + "&profileid=" + profileid,
                dataType: 'json',
                success: function(d){ 
					if (d.status == 200)
					{
						$("#sendmobile_btn").attr("disabled","disabled");
						sendmobile_countdown(120);
					}
					else
					{
						if (d.difftime > 0)
						{
							sweetAlert("警告", d.msg, "error");
							$("#sendmobile_btn").attr("disabled","disabled");
							sendmobile_countdown(120-d.difftime);
						}
						else
						{
							sweetAlert("警告", d.msg, "error");
						} 
					}
                }
            });
	});
	
	
	$('#verify_user_form').validator({
	    rules: {
	        //自定义一个规则，用来代替remote（注意：要把$.ajax()返回出来）
	        verifymobilecodeRemote: function(element){ 
				var profileid = $("#profileid").val();
	            return $.ajax({
	                url: 'passport/checkmobilecode.php',
	                type: 'post',
	                data: element.name + '=' + element.value + "&profileid=" + profileid,
	                dataType: 'json',
	                success: function(d){}
	            });
	        }
	    },
	    fields: {
	        'checkcode': 'required;verifymobilecodeRemote;'
	    }, 
	});
	 
	$('#verify_user_form').on('valid.form', function(e, form){
	     $("#submit_btn").attr("disabled", true).val('提交中..'); 
		 document.verify_user_form.submit(); 
	});
	
	$('#new_pwd_form').on('valid.form', function(e, form){
	     $("#submit_btn").attr("disabled", true).val('提交中..'); 
		 document.new_pwd_form.submit(); 
	});
	
	$('#finished').on('valid.form', function(e, form){
	     $("#submit_btn").attr("disabled", true).val('回到首页..'); 
		 document.finished.submit(); 
	});
	
});
function sendmobile_countdown(time){
	 time = time - 1;
	 $("#sendmobile_btn").val(time+"秒后重新获取"); 
	 if (time > 0)
	 {
	 	 setTimeout("sendmobile_countdown("+time+");",1000);
	 }
	 else
	 {
	 	$("#sendmobile_btn").val("获取验证码");
		$("#sendmobile_btn").removeAttr("disabled");
	 } 
}
function genTimestamp(){
	var time = new Date();
	return time.getTime();
}
function changeCode(){
	var timestamp = genTimestamp();
	$("#guid").val(timestamp);
	$("#captcha_img").attr("src", "/plugins/checkcode/make.php?sessionID="+timestamp);
}
{/literal}
</script> 
 
</body>
</html>
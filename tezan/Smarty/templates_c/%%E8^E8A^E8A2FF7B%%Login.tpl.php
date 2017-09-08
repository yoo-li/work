<?php /* Smarty version 2.6.18, created on 2017-07-31 11:07:07
         compiled from Login.tpl */ ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>登录</title> 
<link href="/Public/BJUI/plugins/niceValidator/jquery.validator.css" rel="stylesheet">
<link href="Public/css/login.css" rel="stylesheet">
<?php if ($this->_tpl_vars['domain'] == 'admin'): ?>
<link href="Public/css/login_blue.css" rel="stylesheet">
<?php elseif ($this->_tpl_vars['domain'] == 'vip'): ?>
<link href="Public/css/login_green.css" rel="stylesheet"> 
<?php endif; ?>  
<script src="/Public/js/jquery-1.11.3.min.js"></script>  
<!-- nice validate -->
<script src="/Public/BJUI/plugins/niceValidator/jquery.validator.js"></script> 
<script src="/Public/BJUI/plugins/niceValidator/local/zh_CN.js"></script>
<script src="Public/js/jquery.cookie.js"></script>
<script src="Public/js/sha256.js"></script>
<script src="Public/js/node.js"></script>
<style>
<?php echo '
<!--
.form_item{margin:0px auto; position:relative;padding-bottom:10px;}
.item_tip{display:none;background-color:#fff; color:#999; font-size:12px; left:42px; padding:0 3px; position:absolute; top:10px; transition:all .2s linear 0s}
.form_input-focus{border-color:#5188a6; outline:0 none}
.item_tip_focus{color:#5188a6; font-size:12px; top:-10px}
-->
'; ?>

</style>

<script type="text/javascript">
<?php echo '
var COOKIE_NAME = \'sys__username\';
var COOKIE_PASSWORD = \'sys__password\';
$(function() {
	if ($.cookie(COOKIE_NAME) && $.cookie(COOKIE_PASSWORD)){
	    $("#username").val($.cookie(COOKIE_NAME)); 
		$("#password").val($.cookie(COOKIE_PASSWORD)); 
	    $("#remember").val(1);
	} 
	else {
		$(\'.auto-login\').addClass("unchecked");
		$("#username").focus(); 
	}

	$("#captcha_img").click(function(){
		changeCode();
	}); 
	$(\'#login_form\').validator({
	    rules: {
	        //自定义一个规则，用来代替remote（注意：要把$.ajax()返回出来）
	        verifycodeRemote: function(element){
				var guid = $("#guid").val();
	            return $.ajax({
	                url: \'passport/checkverifycode.php\',
	                type: \'post\',
	                data: element.name + \'=\' + element.value + "&guid=" + guid,
	                dataType: \'json\',
	                success: function(d){}
	            });
	        }
	    },
	    fields: {
	         \'username\': \'required;username;\',
			 \'password\': \'required;password;\',
			 \'checkcode\': \'required;verifycodeRemote;\'
	    }, 
	});
	$("#login_form").submit(function(){ 
		$(".remind").html("");
        return true;
	});
	$(\'#login_form\').on(\'valid.form\', function(e, form){
			var issubmit = true;
			var i_index  = 0;
			$(this).find(\'.in\').each(function(i){
				if ($.trim($(this).val()).length == 0) {
					$(this).css(\'border\', \'1px #ff0000 solid\');
					issubmit = false;
					if (i_index == 0)
						i_index  = i;
				}
			});
			if (!issubmit) {
				$(this).find(\'.in\').eq(i_index).focus();
				return false;
			}
			var remember = $("#remember").val(); 
			if (remember == \'1\') {
				$.cookie(COOKIE_NAME, $("#username").val(), { path: \'/\', expires: 15 });
				$.cookie(COOKIE_PASSWORD, $("#password").val(), { path: \'/\', expires: 15 });
			} else {
				$.cookie(COOKIE_NAME, null, { path: \'/\' });  //删除cookie
				$.cookie(COOKIE_PASSWORD, null, { path: \'/\' });  //删除cookie
			}
			$("#login_ok").attr("disabled", true).val(\'登录中..\'); 
		    document.login_form.submit(); 
	});
	// 记住登陆账号按钮
	$(\'.auto-login\').click(function() { 
		$(this).toggleClass("unchecked");
		if ($(this).hasClass("unchecked"))
		{
			 $("#remember").val("0"); 
		}
		else
		{
			 $("#remember").val("1"); 
		}
	})
	
});

function genTimestamp(){
	var time = new Date();
	return time.getTime();
}
function changeCode(){
	var timestamp = genTimestamp();
	$("#guid").val(timestamp);
	$("#captcha_img").attr("src", "/plugins/checkcode/make.php?sessionID="+timestamp);
}
 
function focusInputLoginArea(obj) { 
    obj.addClass("form_input-focus");
	obj.prev("div").css("display","block");
	setTimeout(function(){obj.prev("div").addClass("item_tip_focus"); },10); 
}

function blurInputLoginArea(obj) { 
        obj.removeClass("form_input-focus");
        obj.prev("div").removeClass("item_tip_focus"); 
		obj.prev("div").css("display","none");
} 
'; ?>

</script>
<body>
	<div class="header-bg">
		<div class="header">
			<a class="logo" href="#" style="background:url(<?php echo $this->_tpl_vars['copyrights']['login_logo']; ?>
) no-repeat center center;"></a><span
				class="red-line"></span> <span class="wel">欢迎登录</span>
		</div>
	</div>
	<div class="main-bg">
		<div class="main"> 
			<?php if ($this->_tpl_vars['BROWSERS'] != 'ie' || ( $this->_tpl_vars['BROWSERS'] == 'ie' && $this->_tpl_vars['BROWSERSVER'] > 8 )): ?>
			<a href="#" class="main-left"><!--<img src="/Public/images/login-bg.jpg">--></a>
			<div class="right">
				<div class="con-01">
					<h3 class="title"
						style="font-size:15px;color:#666;padding:18px 0 0 29px;">账号密码登录</h3>
				</div>
				<div class="con-02">
					<form action="index.php" id="login_form" name="login_form" method="post" autocomplete="off">
						<input type="hidden" name="module" value="Users" /> 
						<input type="hidden" name="action" value="Login" />
						<input type="hidden" name="guid" value="<?php echo $this->_tpl_vars['GUID']; ?>
" id="guid" > 
					    <input type="hidden" name="f" value="login" />
						<input type="hidden" id="remember" value="1" />
						<div class="email-div">  
								<div class="email-div">
									<div class="form_item">
										<div class="item_tip">登录账号</div>
										<input class="input-common account" id="username" name="username" type="text" onfocus="javascript:focusInputLoginArea($(this));" onblur="javascript:blurInputLoginArea($(this));" placeholder="登录账号" data-rule="required;"> 
										<div class="error-msg username-msg">
											<span class="msg-box" for="username"></span>
										</div> 
									</div>
									<div class="div-01">
										<div class="form_item"> 
											<div class="item_tip">登录密码</div>
											<input class="input-common password" type="password" placeholder="登录密码" id="password" name="password" maxlength='16' data-rule="required;" onfocus="javascript:focusInputLoginArea($(this));" onblur="javascript:blurInputLoginArea($(this));"/>
											<div class="error-msg password-msg">
												<span class="msg-box" for="password"></span>
											</div>
										</div>
										<?php if ($this->_tpl_vars['CHECKCODE'] == 'yes'): ?> 
											<div class="form_item valid" id="veryCode" >
												<div class="item_tip">验证码</div>
												<input class="input-common checkcode input-validate" placeholder="输入右图验证码" type="text" id="checkcode" name="checkcode"  maxlength='4'   onfocus="javascript:focusInputLoginArea($(this));" onblur="javascript:blurInputLoginArea($(this));" data-rule="required;"/>
												<img id="captcha_img" alt="点击更换" title="点击更换" src="/plugins/checkcode/make.php?sessionID=<?php echo $this->_tpl_vars['GUID']; ?>
" class="m">
												<div class="error-msg checkcode-msg">
													<span class="msg-box" for="checkcode"></span>
												</div>
											</div>  
										<?php endif; ?>
										<div class="forget-pwd">
											<span class="span-01 m auto-login"></span><span>记住登录账号</span>
											<a class="a-01" href="index.php?action=Forgetpassword&module=Users">忘记密码?</a>
										</div>
									</div> 
									<!-- <div class="error pwd"><span></span>您的密码输入错误</div> -->
								</div>
					
							<!-- <div class="error pwd"><span></span>您的密码输入错误</div> -->
						</div>

						<div class="div-01">
							<!--<a class="btn-common" id="u11_input" href="javascript:checkbt();">登录</a>-->
	    			   	    <input type="submit" id="login_ok" value="&nbsp;登&nbsp;录&nbsp;" class="btn-common"> 
							<a class="to-register" href="<?php if ($this->_tpl_vars['copyrights']['program'] == 'ma'): ?>index.php?action=Register&module=Users<?php elseif ($this->_tpl_vars['copyrights']['program'] == 'tezan'): ?>index.php?module=Users&action=WzRegister&suppliers_type=0<?php endif; ?>">
								注册新账号？</a>
						</div>
						<?php if ($this->_tpl_vars['ERRORMESSAGE'] != ''): ?>
						<div class="remind"> 
							<span id="errormsg" class="common-error"><i class="icon"></i><?php echo $this->_tpl_vars['ERRORMESSAGE']; ?>
</span>
						</div>
						<?php endif; ?>
					</form>
				</div>
			</div>
			<?php else: ?>
					<h3 class="title" style="font-size:26px;color:#fff;padding:150px 0 0 29px;text-align:center;">您的IE浏览器版本(<?php echo $this->_tpl_vars['BROWSERSVER']; ?>
)过低，请先升级浏览器版本！</h3>
			<?php endif; ?>
		</div>
	</div> 
	<!--footer begin -->
	<div class="footer"> 
		<p class="footer-bq"> 
			Copyright &copy; 2010-<?php echo $this->_tpl_vars['THISYEAR']; ?>
 <a href="http://www.<?php echo $this->_tpl_vars['copyrights']['site']; ?>
" target="_blank"><?php echo $this->_tpl_vars['copyrights']['site']; ?>
</a> All Rights Reserved.  <?php echo $this->_tpl_vars['copyrights']['icp']; ?>

		</p>
		<p class="footer-bq">
			推荐使用Firefox或Google浏览器
		</p>
	</div>
	<!--footer end --> 
<script src="/Public/js/baidu.js?_=20140821" type="text/javascript"></script> 
</body>
</html>
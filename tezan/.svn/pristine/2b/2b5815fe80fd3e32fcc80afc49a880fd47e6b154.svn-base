
<div class="bjui-pageContent">
	<form id="j_pwschange_form" action="index.php" data-toggle="validate" data-alertmsg="false" method="post">  
        <input type="hidden" name="module" value="{$SUBMODULE}">
        <input type="hidden" name="action" value="{$SUBACTION}">
       
        <input type="hidden" name="type" value="submit">
		<input type="hidden" name="guid" value="{$GUID}" id="guid" > 
        <hr>
		{if $HasOldPassword eq 'true'}
	         <div class="form-group" style="margin: 20px 0 20px; ">
	            <label for="j_pwschange_oldpassword" class="control-label x85">旧密码：</label>
	            <input type="password" data-rule="required" name="oldpassword" id="j_pwschange_oldpassword" value="" placeholder="旧密码" size="20">
	         </div>
			 <input type="hidden" name="profileid" value="{$RECORD}">
		{else}
			 <input type="hidden" name="record" value="{$RECORD}">
		{/if}
        <div class="form-group" style="margin: 20px 0 20px; ">
            <label for="j_pwschange_newpassword" class="control-label x85">新密码：</label>
            <input type="password" data-rule="新密码:required" name="newpassword" id="j_pwschange_newpassword" value="" placeholder="新密码" size="20" maxlength="20">
        </div>
        <div class="form-group" style="margin: 20px 0 20px; ">
            <label for="j_pwschange_secpassword" class="control-label x85">确认密码：</label>
            <input type="password" data-rule="required;match(pass)" name="" id="j_pwschange_secpassword" value="" placeholder="确认新密码" size="20" maxlength="20">
        </div>
		 
		<div class="form-group" style="margin: 20px 0 20px; ">
			<label for="j_captcha"  class="control-label x85">验证码：</label> 
			<input id="j_captcha" data-rule="required"  name="checkcode" type="text" class="form-control in" style="width:90px;" maxlength="4">
			<img id="captcha_img" style="" alt="点击更换" title="点击更换" src="/plugins/checkcode/make.php?sessionID={$GUID}" class="m">
			<span class="msg-box" for="j_captcha"></span>
		</div>
	</form>
</div>
<div class="bjui-pageFooter">
    <ul>
        <li><button type="button" class="btn-close" data-icon="close">取消</button></li>
        <li><button type="submit" class="btn-green" data-icon="save">{$OKBUTTON}</button></li>
    </ul>
</div>



<script type="text/javascript"> 
_hmt.push(['_setAutoPageview', false]);
_hmt.push(['_trackPageview', "/index.php?module=Users&action=ChangePassword"]);
</script> 


<script type="text/javascript" defer="defer">
{literal}
function genTimestamp(){
	var time = new Date();
	return time.getTime();
}
$("#captcha_img").click(function(){
	changeCode();
});
function changeCode(){
	var timestamp = genTimestamp();
	$("#guid").val(timestamp);
	$("#captcha_img").attr("src", "/plugins/checkcode/make.php?sessionID="+timestamp);
}
{/literal}
</script>

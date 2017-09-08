<?php

require_once 'modules/PickList/PickListUtils.php';

if(isset($_REQUEST['profileid']) && $_REQUEST['profileid'] != '')
{
	try 
	{
		$profileid = $_REQUEST['profileid'];
		$profile = XN_Profile::load ($profileid,"id","profile");
		$fullName = $profile->fullName;

		if(preg_match('.[#].', $fullName))
		{
			$fullNames = explode('#', $fullName);
			$fullName = $fullNames[0];
		}
	}
	catch ( XN_Exception $e ) 
	{  
		echo  $e->getMessage(); 
	    die();
	}
}
else
{
	die();
}
?>
<div class="bjui-pageHeader">
	<h6 class="contentTitle">
		<center>
			<label>会员名称：<?php echo $profile->givenname; ?></label>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<label>注册日期：</label> <?php echo $profile->published; ?>
		</center>
	</h6>
</div>

<div class="bjui-pageContent tableContent" style="overflow:hidden;">
<form method="post" action="index.php" callback="mall_products_validate" data-toggle="validate" data-validator-option="{focusCleanup:true,timely:false}" data-alertmsg="false">
<input type="hidden" id="module" name="module" value="profile">
<input type="hidden" id="action" name="action" value="Save">
<input type="hidden" id="record" name="record" value="<?php echo $profileid; ?>">
<input type="hidden" id="mode" name="mode" value="edit">
<input type="hidden" id="params" name="params" value="">
<input type="hidden" name="__hash__" value="f05447c821012018c16dec99264a7bdc_ea332f4bef78750abe1e93924eaf44f8" />

	<div class="bjui-pageContent tableContent" style="overflow:hidden;margin:4px;">
		<ul class="nav nav-tabs" role="tablist">
			<li class="active"><a href="#base_information" role="tab" data-toggle="tab">基本信息</a></li>
			<li><a role="tab" data-toggle="ajaxtab" data-target="#deliveraddress" data-reload="false"  href="index.php?module=Profile&action=Deliveraddress&profileid=<?php echo $profileid; ?>">收货地址</a></li>
			<li><a role="tab" data-toggle="ajaxtab" data-target="#Smslog" data-reload="false"  href="index.php?module=Profile&action=ShareRecord&frommodule=Smslog&profileid=<?php echo $profile->mobile; ?>">短信日志</a>
		</ul>
		<div class="bjui-pageContent tableContent tab-content" style="overflow:auto;top:27px;">
			<div class="tab-pane navtab-panel tabsPageContent active in" id="base_information">
				<table border=0 cellspacing=0 cellpadding=0 class="table table-bordered table-hover table-striped">
					<tr id="cid_rankname">
						<td align="right"> 会员编号:</td>
						<td colspan="3"><span><?php echo $profile->identifier; ?></span>
						</td>
					</tr>
					<tr id="cid_rankname">
						<td align="right" > 会员昵称(微信号):</td>
						<td colspan="3"><span><?php echo $profile->givenname; ?></span>
						</td>
					</tr>
					<tr id="cid_rankname">
						<td align="right" > 会员积分:</td>
						<td colspan="3">
							<span><?php echo $profile->rank; ?></span>
						</td>
					</tr>
					<tr id="cid_rankname">
						<td align="right" > 手机号码:</td>
						<td colspan="3"><span><?php echo $profile->mobile; ?></span>
						</td>
					</tr>

					<tr id="cid_rankname">
						<td align="right" > 邀请码:</td>
						<td colspan="3"><span><?php echo $profile->invitationcode; ?></span>
						</td>
					</tr>
					<tr id="cid_rankname">
						<td align="right" > 推荐人:</td>
						<td colspan="3"><span><?php echo ($profile->sourcer=="")?"":getGivenName($profile->sourcer); ?></span>
						</td>
					</tr>
					<tr id="cid_rankname">
						<td  align="right"> 关注时间:</td>
						<td colspan="3"><span><?php echo $profile->published; ?></span>
						</td>
					</tr>
					<tr id="cid_rankname">
						<td  align="right"> 激活时间:</td>
						<td colspan="3"><span><?php echo $profile->activationdate; ?></span>
						</td>
					</tr>
					<?php

					global $current_user;
					if (is_admin($current_user))
					{
						echo '<tr id="cid_rankname">
									 <td align="right" > 微信OPENID:</td>
									 <td colspan="3"><span>'.$profile->wxopenid.'</span>
									</td>
								</tr>';
						echo '<tr id="cid_rankname">
									 <td  align="right"> 微信UNIONID:</td>
									 <td colspan="3"><span>'.$profile->unionid.'</span>
									</td>
								</tr>';
						echo '<tr id="cid_rankname">
									 <td  align="right"> 会员ID:</td>
									 <td colspan="3"><span>'.$profile->screenName.'</span>
									</td>
								</tr>';
					}


					?>

					<tr id="cid_rankname">
						<td  align="right"> 省份:</td>
						<td colspan="3"><span><?php echo $profile->province; ?></span> </td>
					</tr>
					<tr id="cid_rankname">
						<td   align="right"> 城市:</td>
						<td colspan="3"><span><?php echo $profile->city; ?></span> </td>
						</td>
					</tr>
					<tr id="cid_rankname">
						<td align="right"> 生日:</td>
						<td colspan="3"><span><?php echo $profile->birthdate; ?></span> </td>
					</tr>
					<tr id="cid_rankname">
						<td align="right"> 性别:</td>
						<td colspan="3">
							<input type="radio" <?php  if ($profile->gender == '男'){echo 'checked=""';} ?> value="男" name="gender">&nbsp;男&nbsp;
							<input type="radio" <?php  if ($profile->gender == '女'){echo 'checked=""';} ?> value="女" name="gender">&nbsp;女&nbsp;
							<input type="radio" <?php  if ($profile->gender != '男' && $profile->gender != '女'){echo 'checked=""';} ?> value="" name="gender">&nbsp;保密&nbsp;

						</td>
					</tr>
					<tr id="cid_identitycard">
						<td align="right"> 身份证号:</td>
						<td colspan="3">
							<input class="input input-large number" type="text" tabindex="1" name="identitycard" id ="identitycard" value="<?php echo $profile->identitycard; ?>"  />
						</td>
					</tr>
					<tr id="cid_bankaccount">
						<td align="right"> 银行账号:</td>
						<td colspan="3">
							<input   class="input input-large number" type="text" tabindex="1" name="bankaccount" id ="bankaccount" value="<?php echo $profile->bankaccount; ?>"/>
						</td>
					</tr>
					<tr id="cid_bank">
						<td align="right"> 银行开户行:</td>
						<td colspan="3">
							<input    type="text" tabindex="1" name="bank" id ="bank" value="<?php echo $profile->bank; ?>" class="input"  />
						</td>
					</tr>
					<tr id="cid_bankname">
						<td align="right"> 银行开户名:</td>
						<td colspan="3">
							<input    type="text" tabindex="1" name="bankname" id ="bankname" value="<?php echo $profile->bankname; ?>" class="input"  />
						</td>
					</tr>
					<tr id="cid_status">
						<td align="right"> 状态: </td>
						<td colspan="3">
							<input type="radio" <?php  if ($profile->status){echo 'checked=""';} ?> value="1" name="status">&nbsp;启用&nbsp;
							<input type="radio" <?php  if (!$profile->status){echo 'checked=""';} ?> value="0" name="status">&nbsp;停用&nbsp;
						</td>
					</tr>
				</table>
				<div class="divider"></div>
			</div>
			<div class="tab-pane fade" id="deliveraddress"><!-- Ajax加载 --></div>
			<div class="tab-pane fade" id="Smslog"><!-- Ajax加载 --></div>
		</div>
</form>
    
</div>
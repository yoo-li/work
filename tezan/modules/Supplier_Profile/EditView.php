<?php

require_once 'modules/PickList/PickListUtils.php';

if(isset($_REQUEST['record']) && $_REQUEST['record'] != '')
{
	try 
	{
		$record = $_REQUEST['record'];
		$supplier_profile = XN_Content::load($record,"supplier_profile",4);
		$profileid  = $supplier_profile->my->profileid;
		$profile = XN_Profile::load ($profileid,"id","profile");
		$fullName = $profile->fullName; 
		if(preg_match('.[#].', $fullName))
		{
			$fullNames = explode('#', $fullName);
			$fullName = $fullNames[0];
		} 
		
		$supplier_mobile  = $supplier_profile->my->mobile;
		$supplier_givenname  = $supplier_profile->my->givenname;
		
		$profile_givenname = $profile->givenname;
		$profile_mobile = $profile->mobile;
		if ($profile_givenname != "" && $profile_mobile != "")
		{
			if ($profile_givenname != $supplier_givenname || $profile_mobile != $supplier_mobile)
			{
				 $supplier_profile->my->mobile = $profile_mobile;
				 $supplier_profile->my->givenname = $profile_givenname;
				 $supplierid = $supplier_profile->my->supplierid;
				 $tag = "supplier_profile,supplier_profile_".$profileid.",supplier_profile_".$supplierid;
				 $supplier_profile->save($tag);
			} 
		}
		
	}
	catch ( XN_Exception $e ) 
	{  
		echo  $e->getMessage(); 
	    die();
	}
}
else if(isset($_REQUEST['profileid']) && $_REQUEST['profileid'] != '')
{
	try 
	{
		$profileid = $_REQUEST['profileid'];
		global  $supplierid,$supplierusertype;
		
		$supplier_profiles = XN_Query::create ( 'MainContent' )->tag("supplier_profile_".$wxopenid)
	 						->filter ( 'type', 'eic', 'supplier_profile')  
					        ->filter (  'my.profileid', '=', $profileid)
							->filter (  'my.supplierid', '=', $supplierid)
					        ->filter (  'my.deleted', '=', '0' )
	 						->end(1)
	 						->execute ();
	 	if (count($supplier_profiles) == 0 )	
	 	{
			echo  '未知的会员信息！'; 
		    die();
		}  
		$supplier_profile = $supplier_profiles[0];
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

<script language="JavaScript" type="text/javascript" src="modules/ProfileRank/ProfileRank.js"></script>
<div class="bjui-pageHeader">
	<h6 class="contentTitle">
		<center><span>会员名称: <?php echo $profile->givenname; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>注册日期: <?php echo $profile->published; ?></span></center>
	</h6>
</div>

<div class="bjui-pageContent tableContent" style="overflow:hidden;">

<form method="post" action="index.php" data-toggle="validate" callback="profile_validate" onsubmit="return validateCallback(this, navTabAjaxDone)">
<input type="hidden" id="module" name="module" value="profile">
<input type="hidden" id="action" name="action" value="Save">
<input type="hidden" id="record" name="record" value="<?php echo $profileid; ?>">
<input type="hidden" id="mode" name="mode" value="edit">
<input type="hidden" id="params" name="params" value="">
<input type="hidden" name="__hash__" value="f05447c821012018c16dec99264a7bdc_ea332f4bef78750abe1e93924eaf44f8" />
	<div class="bjui-pageContent tableContent" style="overflow:hidden;margin:4px;">
		<ul class="nav nav-tabs" role="tablist">
			<li class="active"><a href="#profile_<?php echo $profileid; ?>_home" role="tab" data-toggle="tab">基本信息</a></li>
			<li class=""><a role="tab" data-toggle="ajaxtab" data-target="#profile_<?php echo $profileid; ?>_1" data-reload="false" href="index.php?module=Supplier_Profile&action=SourcerList&profileid=<?php echo $profileid; ?>" >下级列表</a></li>
			<li class=""><a role="tab" data-toggle="ajaxtab" data-target="#profile_<?php echo $profileid; ?>_2" data-reload="false" href="index.php?module=Supplier_Profile&action=ShareRecord&frommodule=Mall_Shares&profileid=<?php echo $profileid; ?>">分享记录</a></li>
			<li class=""><a role="tab" data-toggle="ajaxtab" data-target="#profile_<?php echo $profileid; ?>_3" data-reload="false" href="index.php?module=Supplier_Profile&action=ShareRecord&frommodule=Mall_Orders&profileid=<?php echo $profileid; ?>" >订单记录</a></li>
			<li class=""><a role="tab" data-toggle="ajaxtab" data-target="#profile_<?php echo $profileid; ?>_4" data-reload="false" href="index.php?module=Supplier_Profile&action=ShareRecord&frommodule=Mall_ReturnedGoodsApplys&profileid=<?php echo $profileid; ?>" >退货记录</a></li>
			<li class=""><a role="tab" data-toggle="ajaxtab" data-target="#profile_<?php echo $profileid; ?>_5" data-reload="false" href="index.php?module=Supplier_Profile&action=ShareRecord&frommodule=Mall_Payments&profileid=<?php echo $profileid; ?>" >支付记录</a></li>
			<li class=""><a role="tab" data-toggle="ajaxtab" data-target="#profile_<?php echo $profileid; ?>_6" data-reload="false" href="index.php?module=Supplier_Profile&action=ShareRecord&frommodule=Mall_BillWaters&profileid=<?php echo $profileid; ?>" >帐单流水</a></li>
			<li class=""><a role="tab" data-toggle="ajaxtab" data-target="#profile_<?php echo $profileid; ?>_7" data-reload="false" href="index.php?module=Supplier_Profile&action=ShareRecord&frommodule=Mall_Commissions&profileid=<?php echo $profileid; ?>" >提成记录</a></li>
			<li class=""><a role="tab" data-toggle="ajaxtab" data-target="#profile_<?php echo $profileid; ?>_8" data-reload="false" href="index.php?module=Supplier_Profile&action=Deliveraddress&profileid=<?php echo $profileid; ?>">收货地址</a></li>
			<li class=""><a role="tab" data-toggle="ajaxtab" data-target="#profile_<?php echo $profileid; ?>_9" data-reload="false" href="index.php?module=Supplier_Profile&action=ShareRecord&frommodule=Smslog&profileid=<?php echo $profile->mobile; ?>">短信日志</a></li>
		</ul>
		<div class="bjui-pageContent tableContent tab-content" style="overflow:auto;top:27px;bottom:27px;">
			<div id="profile_<?php echo $profileid; ?>_home" class="tab-pane navtab-panel tabsPageContent fade active in" >
				<table border=0 cellspacing=0 cellpadding=0 class="table table-none nowwrap">
					<tr id="cid_rankname">
						<td class="edit-form-tdlabel mandatory" width="30%" style="padding-right:15px;text-align: right;">
							<label class="control-label x150" style="font-weight: normal;"> 会员编号:</label>
						</td>
						<td class="edit-form-tdinfo" width="70%" style="padding-left:15px;text-align: left;">
							<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;">
								<?php echo $profile->identifier; ?>
							</span>
						</td>
					</tr>
					
					<!--<tr class="edit-form-tr" id="cid_rankname">
									 <td class="edit-form-tdlabel mandatory"> 会员:</td>
									 <td class="edit-form-tdinfo" width="70%" style="padding-left:15px;text-align: left;"><span><?php echo $profile->fullName; ?></span>
									</td>
								</tr>-->
					<tr class="edit-form-tr" id="cid_rankname">
						<td class="edit-form-tdlabel mandatory" width="30%" style="padding-right:15px;text-align: right;">
							<label class="control-label x150" style="font-weight: normal;">会员昵称(微信昵称):</label>
						</td>
						<td class="edit-form-tdinfo" width="70%" style="padding-left:15px;text-align: left;">
							<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;">
								<?php echo $profile->givenname; ?>
							</span>
						</td>
					</tr>
					<tr class="edit-form-tr" id="cid_rankname">
						<td class="edit-form-tdlabel mandatory" width="30%" style="padding-right:15px;text-align: right;">
							<label class="control-label x150" style="font-weight: normal;">会员积分:</label>
						</td>
						<td class="edit-form-tdinfo" width="70%" style="padding-left:15px;text-align: left;">
							<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;">
								<?php echo $supplier_profile->my->rank; ?>
							</span>
						</td>
					</tr>
					<tr class="edit-form-tr" id="cid_rankname">
						<td class="edit-form-tdlabel mandatory" width="30%" style="padding-right:15px;text-align: right;">
							<label class="control-label x150" style="font-weight: normal;">手机号码:</label>
						</td>
						<td class="edit-form-tdinfo" width="70%" style="padding-left:15px;text-align: left;">
							<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;">
								<?php echo $profile->mobile; ?>
							</span>
						</td>
					</tr>
					<tr class="edit-form-tr" id="cid_rankname">
						<td class="edit-form-tdlabel mandatory" width="30%" style="padding-right:15px;text-align: right;">
							<label class="control-label x150" style="font-weight: normal;">余额:</label>
						</td>
						<td class="edit-form-tdinfo" width="70%" style="padding-left:15px;text-align: left;">
							<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;">
								<?php echo preg_replace("/[^0-9\.]/i", "", $supplier_profile->my->money); ?>
							</span>
						</td>
					</tr>
					<tr class="edit-form-tr" id="cid_rankname">
						<td class="edit-form-tdlabel mandatory" width="30%" style="padding-right:15px;text-align: right;">
							<label class="control-label x150" style="font-weight: normal;">提现基金:</label>
						</td>
						<td class="edit-form-tdinfo" width="70%" style="padding-left:15px;text-align: left;">
							<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;">
								<?php echo preg_replace("/[^0-9\.]/i", "", $supplier_profile->my->maxtakecash); ?>
							</span>
						</td>
					</tr>
					<tr class="edit-form-tr" id="cid_rankname">
						<td class="edit-form-tdlabel mandatory" width="30%" style="padding-right:15px;text-align: right;">
							<label class="control-label x150" style="font-weight: normal;">累积金额:</label>
						</td>
						<td class="edit-form-tdinfo" width="70%" style="padding-left:15px;text-align: left;">
							<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;">
								<?php echo preg_replace("/[^0-9\.]/i", "", $supplier_profile->my->accumulatedmoney); ?>
							</span>
						</td>
					</tr>
					<tr class="edit-form-tr" id="cid_rankname">
						<td class="edit-form-tdlabel mandatory" width="30%" style="padding-right:15px;text-align: right;">
							<label class="control-label x150" style="font-weight: normal;">分享基金:</label>
						</td>
						<td class="edit-form-tdinfo" width="70%" style="padding-left:15px;text-align: left;">
							<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;">
								<?php echo preg_replace("/[^0-9\.]/i", "", $supplier_profile->my->sharefund); ?>
							</span>
						</td>
					</tr>
					<tr class="edit-form-tr" id="cid_rankname">
						<td class="edit-form-tdlabel mandatory" width="30%" style="padding-right:15px;text-align: right;">
							<label class="control-label x150" style="font-weight: normal;">邀请码:</label>
						</td>
						<td class="edit-form-tdinfo" width="70%" style="padding-left:15px;text-align: left;">
							<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;">
								<?php echo $profile->invitationcode; ?>
							</span>
						</td>
					</tr>
					<tr class="edit-form-tr" id="cid_rankname">
						<td class="edit-form-tdlabel mandatory" width="30%" style="padding-right:15px;text-align: right;">
							<label class="control-label x150" style="font-weight: normal;">推荐人:</label>
						</td>
						<td class="edit-form-tdinfo" width="70%" style="padding-left:15px;text-align: left;">
							<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;">
								<?php echo ($profile->sourcer=="")?"":getGivenName($profile->sourcer); ?>
							</span>
						</td>
					</tr>
					<tr class="edit-form-tr" id="cid_rankname">
						<td class="edit-form-tdlabel mandatory" width="30%" style="padding-right:15px;text-align: right;">
							<label class="control-label x150" style="font-weight: normal;">关注时间:</label>
						</td>
						<td class="edit-form-tdinfo" width="70%" style="padding-left:15px;text-align: left;">
							<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;">
								<?php echo $profile->published; ?>
							</span>
						</td>
					</tr>
					<tr class="edit-form-tr" id="cid_rankname">
						<td class="edit-form-tdlabel mandatory" width="30%" style="padding-right:15px;text-align: right;">
							<label class="control-label x150" style="font-weight: normal;"> 激活时间:</label>
						</td>
						<td class="edit-form-tdinfo" width="70%" style="padding-left:15px;text-align: left;">
							<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;">
								<?php echo $profile->activationdate; ?>
							</span>
						</td>
					</tr>
					<?php

					global $current_user;
					if (is_admin($current_user))
					{
						echo '<tr class="edit-form-tr" id="cid_rankname">
								<td class="edit-form-tdlabel mandatory" width="30%" style="padding-right:15px;text-align: right;">
									<label class="control-label x150" style="font-weight: normal;"> 微信OPENID:</label>
								</td>
								<td class="edit-form-tdinfo" width="70%" style="padding-left:15px;text-align: left;">
									<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;">
										'.$profile->wxopenid.'
									</span>
								</td>
							</tr>';
						echo '<tr class="edit-form-tr" id="cid_rankname">
								<td class="edit-form-tdlabel mandatory" width="30%" style="padding-right:15px;text-align: right;">
									<label class="control-label x150" style="font-weight: normal;">微信UNIONID:</label>
								</td>
								<td class="edit-form-tdinfo" width="70%" style="padding-left:15px;text-align: left;">
									<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;">
										'.$profile->unionid.'
									</span>
								</td>
							</tr>';
						echo '<tr class="edit-form-tr" id="cid_rankname">
								<td class="edit-form-tdlabel mandatory" width="30%" style="padding-right:15px;text-align: right;">
									<label class="control-label x150" style="font-weight: normal;">会员ID:</label>
								</td>
								<td class="edit-form-tdinfo" width="70%" style="padding-left:15px;text-align: left;">
									<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;">
										'.$profile->screenName.'
									</span>
								</td>
							</tr>';
					}
					?>

					<tr class="edit-form-tr" id="cid_rankname">
						<td class="edit-form-tdlabel mandatory" width="30%" style="padding-right:15px;text-align: right;"> 省份:</td>
						<td class="edit-form-tdinfo" width="70%" style="padding-left:15px;text-align: left;">
							<?php echo $profile->province; ?>
						</td>
					</tr>
					<tr class="edit-form-tr" id="cid_rankname">
						<td class="edit-form-tdlabel mandatory" width="30%" style="padding-right:15px;text-align: right;"> 城市:</td>
						<td class="edit-form-tdinfo" width="70%" style="padding-left:15px;text-align: left;">
							<?php echo  $profile->city; ?>
						</td>
					</tr>
					<tr class="edit-form-tr" id="cid_rankname">
						<td class="edit-form-tdlabel mandatory" width="30%" style="padding-right:15px;text-align: right;"> 生日:</td>
						<td class="edit-form-tdinfo" width="70%" style="padding-left:15px;text-align: left;">
							<input id="birthdate"  type="text" readonly="true"  data-pattern="yyyy-MM-dd" name="birthdate" value="<?php echo $profile->birthdate; ?>" style="float:left;width:75px">	`
						</td>
					</tr>
					<tr class="edit-form-tr" id="cid_rankname">
						<td class="edit-form-tdlabel mandatory" width="30%" style="padding-right:15px;text-align: right;"> 性别:</td>
						<td class="edit-form-tdinfo" width="70%" style="padding-left:15px;text-align: left;">
							<input type="radio" disabled <?php  if ($profile->gender == '男'){echo 'checked=""';} ?> value="男" name="gender">&nbsp;男&nbsp;
							<input type="radio" disabled <?php  if ($profile->gender == '女'){echo 'checked=""';} ?> value="女" name="gender">&nbsp;女&nbsp;
							<input type="radio" disabled <?php  if ($profile->gender != '男' && $profile->gender != '女'){echo 'checked=""';} ?> value="" name="gender">&nbsp;保密&nbsp;
						</td>
					</tr>
					<tr class="edit-form-tr" id="cid_rankname">
						<td class="edit-form-tdlabel mandatory" width="30%" style="padding-right:15px;text-align: right;">
							<label class="control-label x150" style="font-weight: normal;">ProfileID:</label>
						</td>
						<td class="edit-form-tdinfo" width="70%" style="padding-left:15px;text-align: left;">
							<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;">
								<?php echo $profile->profileid; ?>
							</span>
						</td>
					</tr>
				</table>
				<div class="divider"></div>
			</div>
			<div id="profile_<?php echo $profileid; ?>_1" class="tab-pane navtab-panel tabsPageContent fade"> </div>
			<div id="profile_<?php echo $profileid; ?>_2" class="tab-pane navtab-panel tabsPageContent fade"> </div>
			<div id="profile_<?php echo $profileid; ?>_3" class="tab-pane navtab-panel tabsPageContent fade"> </div>
			<div id="profile_<?php echo $profileid; ?>_4" class="tab-pane navtab-panel tabsPageContent fade"> </div>
			<div id="profile_<?php echo $profileid; ?>_5" class="tab-pane navtab-panel tabsPageContent fade"> </div>
			<div id="profile_<?php echo $profileid; ?>_6" class="tab-pane navtab-panel tabsPageContent fade"> </div>
			<div id="profile_<?php echo $profileid; ?>_7" class="tab-pane navtab-panel tabsPageContent fade"> </div>
			<div id="profile_<?php echo $profileid; ?>_8" class="tab-pane navtab-panel tabsPageContent fade"> </div>
			<div id="profile_<?php echo $profileid; ?>_9" class="tab-pane navtab-panel tabsPageContent fade"> </div>
		</div>
		<div class="bjui-pageFooter">
			<ul>
				<li><button type="button" class="btn-close" data-icon="close">关闭</button></li>
			</ul>
		</div>
</form>
    
</div>
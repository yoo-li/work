<?php
require_once('Smarty_setup.php');
require_once('include/utils/utils.php');


global  $currentModule,$supplierid;

if (isset($_REQUEST['record']) && $_REQUEST['record'] != "" &&
    isset($_REQUEST['type']) && $_REQUEST['type'] == "submit" &&
	isset($_REQUEST['mobile']) && $_REQUEST['mobile'] != "")
{
    try {
        $record = $_REQUEST['record'];
        $mobile = $_REQUEST['mobile'];


		$supplier_info = XN_content::load($supplierid,"suppliers");
		 

			$profiles = XN_Query::create ( 'Profile' ) ->tag("profile")
				->filter('mobile','=',$mobile)
				->filter('type','=','wxuser')
				->execute();
			if (count($profiles) == 0)
			{
				echo '{"statusCode":"300","message":"手机号码不存在，不存在该上级会员!"}';
				die();
			}

			$profile_info = $profiles[0];
			$onelevelsourcer = $profile_info->profileid;
			$invitationgivenname = $profile_info->givenname;
			$supplier_profile = XN_Query::create('MainContent')->tag("supplier_profile")
				->filter('type', 'eic', 'supplier_profile')
				->filter('my.deleted', '=', '0')
				->filter('my.supplierid', '=', $supplierid)
				->filter('my.profileid', '=', $onelevelsourcer)
				->end(1)
				->execute();
			if (count($supplier_profile) == 0)
			{
				echo '{"statusCode":"300","message":"您填写的推荐人的手机号码有误!该会员没有关注本商城！"}';
				die();
			}
			$supplier_profile_info = $supplier_profile[0];
			$twolevelsourcer = $supplier_profile_info->my->onelevelsourcer;
			$threelevelsourcer = $supplier_profile_info->my->twolevelsourcer;

			$loadcontent =  XN_Content::load($record,"supplier_profile",4);
			$profileid = $loadcontent->my->profileid;
			$ranklevel = $loadcontent->my->ranklevel;

			if ($ranklevel == "1" && $supplierid != "496790" )
			{
				echo '{"statusCode":"300","message":"该会员已经产生了购买,不能修改关系链！"}';
				die();
			}

			$profile_info = XN_Profile::load ($profileid,"id","profile");
			$givenname = $profile_info->givenname;
			$loadcontent->my->onelevelsourcer = $onelevelsourcer;
			$loadcontent->my->twolevelsourcer = $twolevelsourcer;
			$loadcontent->my->threelevelsourcer = $threelevelsourcer;

			$wxopenid = $loadcontent->my->wxopenid;
			$tag = "supplier_profile,supplier_profile_" . $wxopenid . ",supplier_profile_" . $profileid . ",supplier_profile_" . $supplierid;
			$tag .= ",supplier_profile_" . $onelevelsourcer;
			$tag .= ",supplier_profile_" . $twolevelsourcer;
			$tag .= ",supplier_profile_" . $threelevelsourcer;
			$loadcontent->save($tag);

			$supplier_wxsettings = XN_Query::create ( 'MainContent' ) ->tag('supplier_wxsettings')
				->filter ( 'type', 'eic', 'supplier_wxsettings')
				->filter ( 'my.deleted', '=', '0' )
				->filter ( 'my.supplierid', '=' ,$supplierid)
				->end(1)
				->execute();
			if (count($supplier_wxsettings) > 0)
			{
				$supplier_wxsetting_info = $supplier_wxsettings[0];
				$appid = $supplier_wxsetting_info->my->appid;
				require_once (XN_INCLUDE_PREFIX."/XN/Message.php");
				$message = '您的推荐人调整为'.$invitationgivenname.'【'.$mobile.'】。';
				XN_Message::sendmessage($profileid,$message,$appid);
				$message = '会员'.$givenname.'经调整，荣幸成为您的粉丝。';
				XN_Message::sendmessage($onelevelsourcer,$message,$appid);
			}
			echo '{"statusCode":"200","message":null,"tabid":"'.$currentModule.'","closeCurrent":true,"forward":null}';
			die(); 
     } 
	catch ( XN_Exception $e )
    {
        echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
    }
    die();
}
else{ 
    $binds = $_REQUEST['ids']; 
    $binds = str_replace(";",",",$binds);
    $binds = explode(",",trim($binds,','));
    array_unique($binds);
	if (count($binds) > 1)
	{
		$smarty = new vtigerCRM_Smarty;
		global $mod_strings;
		global $app_strings;
		global $app_list_strings;
		$smarty->assign("APP", $app_strings);
		$smarty->assign("CMOD", $mod_strings); 
	    $msg = '<div style="width:100%;text-align:center;"><br><br><font color="red" size="2">您只能选择单条记录进行修改！</font></div>';  
		$smarty->assign("MSG", $msg);  
		$smarty->display("MessageBox.tpl");
		die();
	}
	else
	{
        $record = $_REQUEST['ids'];
        
		$loadcontent =  XN_Content::load($record,"supplier_profile",4); 
		$profileid  = $loadcontent->my->profileid;

		$ranklevel = $loadcontent->my->ranklevel;

		if ($ranklevel == "1" && $supplierid != "496790" )
		{
			$smarty = new vtigerCRM_Smarty;
			global $mod_strings;
			global $app_strings;
			global $app_list_strings;
			$smarty->assign("APP", $app_strings);
			$smarty->assign("CMOD", $mod_strings);
			$msg = '<div style="width:100%;text-align:center;"><br><br><font color="red" size="2">该会员已经产生了购买,不能修改关系链</font></div>';
			$smarty->assign("MSG", $msg);
			$smarty->display("MessageBox.tpl");
			die();
		}
		 
	   $msg =  '<div class="form-group">
	                <label class="control-label x120">上线会员手机号:</label>
					<input type="text" class="input mobile required textInput" data-rule="required;mobile;" placeholder="请输入手机号码"  id="mobile" name="mobile"  value="">
	                 
			    </div> ';
	}
}

$smarty = new vtigerCRM_Smarty;
global $mod_strings;
global $app_strings;
global $app_list_strings;
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->assign("MSG", $msg);
$smarty->assign("OKBUTTON", "确定");
$smarty->assign("RECORD",$_REQUEST['ids']);
$smarty->assign("SUBMODULE", "Supplier_Profile");
$smarty->assign("SUBACTION", "ModifySourcer");

$smarty->display("MessageBox.tpl");

?>
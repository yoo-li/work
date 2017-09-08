<?php

function randomkeys($length)
{
	$pattern='1234567890';
	for($i=0;$i<$length;$i++)
	{
	   $key .= $pattern{mt_rand(0,9)};    //生成php随机数
	}
	return $key;
}


if (isset($_REQUEST['type']) && $_REQUEST['type'] == "submit" &&
	isset($_REQUEST['profileid']) && $_REQUEST['profileid'] != "" &&
	isset($_REQUEST['verifycode']) && $_REQUEST['verifycode'] != ""  )
{
    try{
		 
		$profileid = $_REQUEST['profileid'];
		$verifycode = $_REQUEST['verifycode'];
		
		$profile = XN_Profile::load($profileid,"id","profile_".$profileid);
		
		$tag = "profile,orders,wxopenids,billwaters,supplier_profile"; 
		$tag .= ",profile_".$profileid;
		$tag .= ",wxopenids_".$profileid; 
		$tag .= ",billwaters_".$profileid;
		$tag .= ",supplier_profile_".$profileid;
			
	 	$wxopenids = XN_Query::create ( 'MainContent' )
	 						->filter ( 'type', 'eic', 'wxopenids')  
	 						->filter ( 'my.profileid', '=', $profileid)
	 						->end(-1)
	 						->execute ();  
		foreach($wxopenids as $wxopenid_info)
		{
			$wxopenid = $wxopenid_info->my->wxopenid;
			$tag .= ',profile_'.$wxopenid.',supplier_profile_'.$wxopenid;
		} 
		
	 	$supplier_profiles = XN_Query::create ( 'MainContent' )
	 						->filter ( 'type', 'eic', 'supplier_profile')  
	 						->filter ( 'my.profileid', '=', $profileid)
	 						->end(-1)
	 						->execute ();  
		foreach($supplier_profiles as $supplier_profile_info)
		{
			$wxopenid = $supplier_profile_info->my->wxopenid;
			$tag .= ',supplier_profile_'.$wxopenid.',profile_'.$wxopenid;
		} 
		$contents = XN_Content::create('deleteprofile', '',false,5)	 
				  ->my->add('profileid',$profileid)
				  ->my->add('verifycode',$verifycode) 
				  ->save($tag); 

		$delete_profile_id = $contents->id;  
		sleep(1);
		$loadcontent = XN_Content::load($delete_profile_id,"",5); 
		if ($loadcontent->my->status == "failure")
		{ 
			 echo '{"statusCode":"300","message":"提交失败！请检查校验码是否正确！"}';
			 die();
		}  
	 	$wxservices = XN_Query::create('Content')
				->tag('deleteprofilelog')
				->filter('type','eic','deleteprofilelog')
				->filter('my.deleted','=','0') 
				->filter('my.profileid','=',$profileid)  
				->end(1)
				->execute();
		if (count($wxservices) == 0 )
		{
			$query = XN_Query::create ( 'Content_Count' )->tag('orders')
					->filter('type','eic','orders') 
				    ->filter('my.deleted','=','0') 
					->filter('my.tradestatus','=','trade') 	
				    ->filter('my.orderssources','=',$profileid) 	
					->rollup()
					->end(-1);
			$query->execute (); 
			$ordercount = $query->getTotalCount();
			
			

			$newcontent = XN_Content::create('deleteprofilelog','',false); 
			$newcontent->my->profileid = $profileid; 
			$newcontent->my->givenname = $profile->givenname; 
			$newcontent->my->mobile = $profile->mobile;
			$newcontent->my->money = $profile->money;
			$newcontent->my->accumulatedmoney = $profile->accumulatedmoney;
			$newcontent->my->sharefund = $profile->sharefund;
			$newcontent->my->rank = $profile->rank;
			$newcontent->my->ordercount = $ordercount;
			$newcontent->my->execute = XN_Profile::$VIEWER;
			$newcontent->my->deleted = "0";    
			$newcontent->save('deleteprofilelog');
		}
		
    }
    catch(XN_Exception $e){
        echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
        die();
    }
    echo '{"statusCode":"200","message":"删除命令已经成功提交！请在30秒后，刷新会员数据！","tabid":null,"closeCurrent":true,"forward":null}';
	die();
}

if (isset($_REQUEST['type']) && $_REQUEST['type'] == "sendweixin" && 
	isset($_REQUEST['veriyfyprofile']) && $_REQUEST['veriyfyprofile'] != "" &&
	isset($_REQUEST['profileid']) && $_REQUEST['profileid'] != "")
{
	$checkcode = randomkeys(6); 
	$profileid = $_REQUEST['profileid'];
	$profile = XN_Profile::load($profileid,"id","profile_".$profileid);
	$mobile = $profile->mobile;
	$givenname = $profile->givenname;
	//
	
	if (isset($mobile) && $mobile != "")
	{
		$msg = '平台试图删除昵称为'.$givenname.'的会员,该会员手机号为'.$mobile.',校验码为'.$checkcode.',会员删除后,不能恢复,请谨慎操作!';
	}
	else
	{
		$msg = '平台试图删除昵称为'.$givenname.'的会员,校验码为'.$checkcode.',会员删除后,不能恢复,请谨慎操作!';
	}  
	 
	$veriyfyprofile = $_REQUEST['veriyfyprofile'];
	$profiles = XN_Query::create ( 'Profile' ) ->tag("profile")	
				->filter('type','=','wxuser')
				->filter('givenname','=',$veriyfyprofile)
				->end(1)
				->execute();
	if (count($profiles) > 0 )
	{
		$profile_info = $profiles[0];
		$admin = $profile_info->profileid; 
		
        $wxsettings = XN_Query::create('MainContent')->tag('wxsettings')
            ->filter('type', 'eic', 'wxsettings')
            ->filter('my.deleted', '=', '0') 
            ->end(1)
            ->execute();
        if (count($wxsettings) > 0)
        {
            $wxsettings_info = $wxsettings[0];
            $appid = $wxsettings_info->my->appid;
            require_once(XN_INCLUDE_PREFIX . "/XN/Message.php"); 
            XN_Message::sendmessage($admin, $msg, $appid); 
			XN_MemCache::put($checkcode,"deleteprofile_".$profileid,120); 
        }
		
	} 
	  
}	
	
if (isset($_REQUEST['ids']) && $_REQUEST['ids'] != "")
{
    $ids = $_REQUEST['ids'];
	$profileid = $_REQUEST['ids'];
    $author = getGivenNamesByids(XN_Profile::$VIEWER);
	
    $ids = explode(",",trim($ids,','));
    array_unique($ids);
    $ids = array_filter($ids);
	 
	
	require_once('Smarty_setup.php');
	require_once('include/utils/utils.php');

	global  $currentModule;
	$smarty = new vtigerCRM_Smarty;
	$smarty->assign("APP", $app_strings);
	$smarty->assign("CMOD", $mod_strings);
	
	if (count($ids) > 1)
	{
		echo '<div style="width:100%;text-align:center;"><br><br><font color="red" size="2">不能同时删除多个会员！</font></div>';
		die(); 
	}
	else
	{ 
		$html = '
			 <div class="form-group">
				     <label class="control-label x120">操作人：</label><input type="text" disabled value="'.$author.'" class="required textInput">
	 		 </div>
		 	 <div class="form-group">
		 	                <label class="control-label x120">校验码接收人:</label>
		 					 <select data-toggle="selectpicker" id="veriyfyprofile" name="veriyfyprofile" style="cursor: pointer;">
		 					    <option value="老手">老手</option>
		 						<option value="梦醒之间">梦醒之间</option> 
		 					 </select>
		 	 </div>
		     <div class="form-group">
			         <input type="hidden" name="profileid" id="deleteprofile_profileid" value="'.$profileid.'" >
				     <label class="control-label x120">校验码：</label><input type="text"  name="verifycode" id="verifycode" value="" class="required textInput">
	 		 </div>
		 	 
		     <div class="form-group">
				     <label class="control-label x120">&nbsp;</label>
					 <a id="send_weixin_info" class="btn btn-default" data-icon="weixin" onclick="page_cg();" > 给管理员的微信发送验证码</a>
					 
	 		 </div> 

		'; 
		$script = ' 
		 	var i = 30;
		 	function page_cg() {
		 		if (document.getElementById("send_weixin_info") != null)
		 		{
		 			if (i == 30)
		 			{  
		 				var profileid = document.getElementById("deleteprofile_profileid").value;  
						var veriyfyprofile = document.getElementById("veriyfyprofile").value;  
						jQuery("[id=progressBar]").addClass("hidden");
		 	  	        jQuery.post("index.php", "module=Profile&action=DeleteProfile&type=sendweixin&profileid=" + profileid + "&veriyfyprofile="+veriyfyprofile+"&m="+Math.random(),
		 	  			function (data, textStatus)
		 	  			{
  							jQuery("[id=progressBar]").removeClass("hidden");
		 	  			});	
		 			}
		 			jQuery("#send_weixin_info").html("发送成功!("+i+")");
		 		 
		 			if (i > 0) {
		 				i--; 
		 				jQuery("#send_weixin_info").attr("disabled","disabled");
		 				window.setTimeout(function () { page_cg() }, 1000);
		 				return;
		 			}
		 			else { 
		 				jQuery("#send_weixin_info").html("重新获取验证码");
						jQuery("#send_weixin_info").removeAttr("disabled");
		 				i = 30;
		 			} 
		 		}
		 	}
	    ';
		$smarty->assign("MSG", $html);
		$smarty->assign("SCRIPT", $script);
		$smarty->assign("MSGTITLE", '<h2 style="text-align:center;"><font color="red" size="2">会员删除后，不能恢复，请谨慎操作!</font></h2>');
		$smarty->assign("RECORD", $ids);
		$smarty->assign("SUBMODULE", "Profile");
		$smarty->assign("OKBUTTON", "确定删除会员");
		$smarty->assign("SUBACTION", "DeleteProfile");
	}  

	$smarty->display("MessageBox.tpl"); 
}
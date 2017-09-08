<?php
require_once('Smarty_setup.php');
require_once('include/utils/utils.php');


global  $currentModule,$supplierid;

if (isset($_REQUEST['record']) && $_REQUEST['record'] != "" &&
    isset($_REQUEST['type']) && $_REQUEST['type'] == "submit" )
{
    try {
        $record = $_REQUEST['record'];
        $mobile = $_REQUEST['mobile'];
		
		
		
		$supplier_profile_info = XN_content::load($record,"supplier_profile",4); 
		$profileid = $supplier_profile_info->my->profileid;
		
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
		$newprofileid = $profile_info->profileid;
		
		$supplier_physicalstores = XN_Query::create ( 'Content' ) ->tag('supplier_physicalstores')
		    ->filter ( 'type', 'eic', 'supplier_physicalstores') 
			->filter ( 'my.supplierid', '=',$supplierid)
			->filter ( 'my.profileid', '=',$profileid)
		    ->filter ( 'my.deleted', '=', '0' )
			->end(1)
		    ->execute ();
	    if (count ($supplier_physicalstores) > 0)
		{
			echo '{"statusCode":"300","message":"店主身份不能裁减!"}';
			die();
		}
		
		$supplier_profile = XN_Query::create('MainContent')->tag("supplier_profile")
			->filter('type', 'eic', 'supplier_profile')
			->filter('my.deleted', '=', '0')
			->filter('my.supplierid', '=', $supplierid)
			->filter('my.profileid', '=', $newprofileid)
			->end(1)
			->execute();
		if (count($supplier_profile) == 0)
		{
			echo '{"statusCode":"300","message":"您填写的手机号码有误!该会员没有关注本商城！"}';
			die();
		}
		$supplier_profile_info = $supplier_profile[0];
		$twolevelsourcer = $supplier_profile_info->my->onelevelsourcer;
		$threelevelsourcer = $supplier_profile_info->my->twolevelsourcer;
		
		$supplier_profile = XN_Query::create('MainContent')->tag("supplier_profile")
			->filter('type', 'eic', 'supplier_profile')
			->filter('my.deleted', '=', '0')
			->filter('my.supplierid', '=', $supplierid)
			->filter('my.onelevelsourcer', '=', $profileid)
			->end(-1)
			->execute();
		if (count($supplier_profile) > 0)
		{
			foreach($supplier_profile as $supplier_profile_info)
			{
				$modifyprofileid = $supplier_profile_info->my->onelevelsourcer;
				$supplier_profile_info->my->onelevelsourcer = $newprofileid;
				$supplier_profile_info->my->twolevelsourcer = $twolevelsourcer;
				$supplier_profile_info->my->threelevelsourcer = $threelevelsourcer;

				$wxopenid = $supplier_profile_info->my->wxopenid;
				
				$tag = "supplier_profile,supplier_profile_" . $wxopenid . ",supplier_profile_" . $modifyprofileid . ",supplier_profile_" . $supplierid;
				$tag .= ",supplier_profile_" . $newprofileid;
				$tag .= ",supplier_profile_" . $twolevelsourcer;
				$tag .= ",supplier_profile_" . $threelevelsourcer;
				$supplier_profile_info->save($tag);
			}
		} 

		$supplier_profile = XN_Query::create('MainContent')->tag("supplier_profile")
			->filter('type', 'eic', 'supplier_profile')
			->filter('my.deleted', '=', '0')
			->filter('my.supplierid', '=', $supplierid)
			->filter('my.twolevelsourcer', '=', $profileid)
			->end(-1)
			->execute();
		if (count($supplier_profile) > 0)
		{
			foreach($supplier_profile as $supplier_profile_info)
			{
				$modifyprofileid = $supplier_profile_info->my->onelevelsourcer; 
				$supplier_profile_info->my->twolevelsourcer = $newprofileid;
				$supplier_profile_info->my->threelevelsourcer = $twolevelsourcer;

				$wxopenid = $supplier_profile_info->my->wxopenid;
				
				$tag = "supplier_profile,supplier_profile_" . $wxopenid . ",supplier_profile_" . $modifyprofileid . ",supplier_profile_" . $supplierid;
				$tag .= ",supplier_profile_" . $newprofileid;
				$tag .= ",supplier_profile_" . $twolevelsourcer; 
				$supplier_profile_info->save($tag);
			}
		} 
		
	    $supplier_physicalstoreassistants = XN_Query::create ( 'Content' )->tag('supplier_physicalstoreassistants_'.$supplierid)
		    ->filter ( 'type', 'eic', 'supplier_physicalstoreassistants')
		    ->filter ( 'my.supplierid',"=",$supplierid)
			->filter ( 'my.deleted', '=', '0')  
			->filter ( 'my.profileid', '=', $profileid)   
		    ->end(-1)
		    ->execute(); 
		foreach($supplier_physicalstoreassistants as $supplier_physicalstoreassistant_info)
		{ 
			$supplier_physicalstoreassistant_info->my->profileid = $newprofileid;  
			$tag = "supplier_physicalstoreassistants,supplier_physicalstoreassistants_" . $profileid . ",supplier_physicalstoreassistants_" . $supplierid;
			$tag .= ",supplier_physicalstoreassistants_" . $newprofileid; 
			$supplier_physicalstoreassistant_info->save($tag);
		} 
	    $supplier_physicalstoreprofiles = XN_Query::create ( 'Content' )->tag('supplier_physicalstoreprofiles_'.$supplierid)
		    ->filter ( 'type', 'eic', 'supplier_physicalstoreprofiles')
		    ->filter ( 'my.supplierid',"=",$supplierid)
			->filter ( 'my.deleted', '=', '0')  
			->filter ( 'my.assistantprofileid', '=', $profileid)   
		    ->end(-1)
		    ->execute(); 
		foreach($supplier_physicalstoreprofiles as $supplier_physicalstoreprofile_info)
		{ 
			$supplier_physicalstoreprofile_info->my->assistantprofileid = $newprofileid;  
			$tag = "supplier_physicalstoreprofiles,supplier_physicalstoreprofiles_" . $profileid . ",supplier_physicalstoreprofiles_" . $supplierid;
			$tag .= ",supplier_physicalstoreprofiles_" . $newprofileid; 
			$supplier_physicalstoreprofile_info->save($tag);
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
		$supplier_physicalstores = XN_Query::create ( 'Content' ) ->tag('supplier_physicalstores')
		    ->filter ( 'type', 'eic', 'supplier_physicalstores') 
			->filter ( 'my.supplierid', '=',$supplierid)
			->filter ( 'my.profileid', '=',$profileid)
		    ->filter ( 'my.deleted', '=', '0' )
			->end(1)
		    ->execute ();
	    if (count ($supplier_physicalstores) > 0)
		{ 
			$smarty = new vtigerCRM_Smarty;
			global $mod_strings;
			global $app_strings;
			global $app_list_strings;
			$smarty->assign("APP", $app_strings);
			$smarty->assign("CMOD", $mod_strings); 
		    $msg = '<div style="width:100%;text-align:center;"><br><br><font color="red" size="2">店主身份不能裁减！</font></div>';  
			$smarty->assign("MSG", $msg);  
			$smarty->display("MessageBox.tpl"); 
			die();
		}
		$givenname = $loadcontent->my->givenname;   
	    $msg =  '<div class="form-group">
	                <label class="control-label x120" style="width:150px;">裁减会员:</label>
					<input type="text" class="input  textInput"  disabled value="'.$givenname.'">
	                 
			    </div> ';
	    $msg .=  '<div class="form-group">
	                <label class="control-label x120" style="width:150px;">转移关系的新会员手机:</label>
					<input type="text" data-rule="required;mobile;" class="input mobile required textInput" placeholder="请输入手机号码"  id="mobile" name="mobile"  value="">
             
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
$smarty->assign("SUBACTION", "ReduceProfileSourcer");

$smarty->display("MessageBox.tpl");

?>
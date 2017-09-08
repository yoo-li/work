<?php
require_once('Smarty_setup.php');
require_once('include/utils/utils.php');


global  $currentModule,$supplierid;

if (isset($_REQUEST['record']) && $_REQUEST['record'] != "" &&
    isset($_REQUEST['type']) && $_REQUEST['type'] == "submit" &&
	isset($_REQUEST['authentication']) && $_REQUEST['authentication'] != "")
{
    try {
        $binds = $_REQUEST['record'];
        $authentication = $_REQUEST['authentication'];

        $binds = str_replace(";",",",$binds);
        $binds = explode(",",trim($binds,','));
        array_unique($binds);
		if (count($binds) > 0)
		{
			$loadcontents = XN_Content::loadMany($binds,"supplier_authenticationprofiles_".$supplierid);
	        foreach($loadcontents as $authenticationprofile_info)
	        {  
		        $authenticationstatus = $authenticationprofile_info->my->authenticationstatus;
		        if ($authenticationstatus == "0")
		        {
			            if ($authentication == "1")
				        {
					        $authenticationprofile_info->my->approvalstatus = '2';
							$status = strtolower($currentModule).'status';
							$authenticationprofile_info->my->$status = 'Agree';
					        $authenticationprofile_info->my->finishapprover = XN_Profile::$VIEWER;
							$authenticationprofile_info->my->submitapprovalreplydatetime = date("Y-m-d H:i"); 
							$authenticationprofile_info->my->authenticationstatus = $authentication;
							$authenticationprofile_info->save("supplier_authenticationprofiles,supplier_authenticationprofiles_".$supplierid);
							
						}
				        else
				        {
					        $authenticationprofile_info->my->approvalstatus = '3';
							$status = strtolower($currentModule).'status';
							$authenticationprofile_info->my->$status = 'Disagree'; 
							$authenticationprofile_info->my->authenticationstatus = $authentication;
							$authenticationprofile_info->save("supplier_authenticationprofiles,supplier_authenticationprofiles_".$supplierid);
							
							$profileid = $authenticationprofile_info->my->profileid;
							$supplier_profile = XN_Query::create('MainContent')->tag("supplier_profile_" . $profileid)
					            ->filter('type', 'eic', 'supplier_profile')
					            ->filter('my.profileid', '=', $profileid)
					            ->filter('my.supplierid', '=', $supplierid)
					            ->filter('my.deleted', '=', '0') 
					            ->end(1)
					            ->execute();
					        if (count($supplier_profile) > 0)
					        {
						        $supplier_profile_info = $supplier_profile[0];
						        $authenticationprofile = $supplier_profile_info->my->authenticationprofile;
						        if ($authenticationprofile != "1")
						        {
							        $supplier_profile_info->my->authenticationprofile = '1';
							        $wxopenid = $supplier_profile_info->my->wxopenid;
							        $tag = "supplier_profile,supplier_profile_" . $wxopenid . ",supplier_profile_" . $profileid. ",supplier_profile_" . $supplierid;  
							        $supplier_profile_info->save($tag);
									XN_MemCache::delete("supplier_profile_" . $supplierid . '_' . $profileid);
						        }
						    }
				        }
		        }  
	        } 
		} 
		echo '{"statusCode":200,"message":null,"tabid":"'.$currentModule.'","closeCurrent":"true","forward":null}';
		
    } catch ( XN_Exception $e )
    {
        echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
    }
    die();
}
else{ 
	$msg =  '<div class="form-group">
	                <label class="control-label x120">会员认证:</label>
					  <select id="authentication" name="authentication" style="width:200px;cursor: pointer;">
					    <option value="2">接受认证</option>
						<option value="1">拒绝认证【会员重新提交认证】</option>
						 
					 </select>
			    </div> ';
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
$smarty->assign("SUBMODULE", "Supplier_AuthenticationProfiles");
$smarty->assign("SUBACTION", "ProcessAuthentication");

$smarty->display("MessageBox.tpl");

?>
<?php
require_once('Smarty_setup.php');
require_once('include/utils/utils.php');


global  $currentModule,$supplierid;

if (isset($_REQUEST['record']) && $_REQUEST['record'] != "" &&
    isset($_REQUEST['type']) && $_REQUEST['type'] == "submit" &&
	isset($_REQUEST['username']) && $_REQUEST['username'] != "")
{
    try {
		        $record = $_REQUEST['record'];
		        $username = $_REQUEST['username']; 
				
				$loadcontent =  XN_Content::load($record,"users");
				$profileid = $loadcontent->my->profileid;
		
				$Users = XN_Query::create ( 'Content' )
					->filter ( 'type', 'eic', 'users' )
					->filter ( 'my.deleted', '=', '0' ) 
					->filter ( 'my.profileid', '!=', $profileid )
					->filter ( 'my.user_name', '=', $username ) 
					->end(1)
					->execute (); 
				if (count($Users) > 0) 
				{
						echo '{"statusCode":"300","message":"账号名称已经占用!请更换账号名称！"}';
						die; 
				}
		 
				if ($loadcontent->my->user_name != $username)
				{
					$loadcontent->my->user_name = $username; 
					$loadcontent->save("users");
					$profile_info = XN_Profile::load($profileid,"id","profile");
					$fullName = $profile_info->fullName;
					if (strpos($fullName,'#') > 0)
					{
				        $profile_info->fullName = $username.'#admin'; 
				        $profile_info->givenname = $username;
						$profile_info->save("profile,profile_".$profileid); 
					}
					else
					{
				        $profile_info->fullName = $username; 
				        $profile_info->givenname = $username;
						$profile_info->save("profile,profile_".$profileid); 
					} 
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
        
		$loadcontent =  XN_Content::load($record,"users"); 
		$profileid  = $loadcontent->my->profileid;
		$user_name  = $loadcontent->my->user_name;
   
	    $msg =  '<div class="form-group">
	                <label class="control-label x120">账号名称:</label>
					<input class="form-control  required" type="text" data-rule="required;" class="required"  id="username" name="username"  value="'.$user_name.'"> 
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
$smarty->assign("OKBUTTON", "确定修改");
$smarty->assign("RECORD",$_REQUEST['ids']);
$smarty->assign("SUBMODULE", "Users");
$smarty->assign("SUBACTION", "ModifyUserName");

$smarty->display("MessageBox.tpl");

?>
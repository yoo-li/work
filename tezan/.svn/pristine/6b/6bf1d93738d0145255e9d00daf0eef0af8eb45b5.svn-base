<?php
global  $currentModule,$supplierid;
if(isset($_REQUEST['record']) && $_REQUEST['record'] != "" &&
	isset($_REQUEST['type']) && $_REQUEST['type'] == "submit")
{
	if (isset($_REQUEST['account']) && $_REQUEST['account'] != "" &&
		isset($_REQUEST['email']) && $_REQUEST['email'] != "" &&
		isset($_REQUEST['mobile']) && $_REQUEST['mobile'] != "" && 
		isset($_REQUEST['departments_id']) && $_REQUEST['departments_id'] != "" &&
		isset($_REQUEST['access_id_id']) && $_REQUEST['access_id_id'] != ""
	)
	{
		$record = $_REQUEST['record'];
		$account = $_REQUEST['account'];
		$email = $_REQUEST['email'];
		$mobile = $_REQUEST['mobile']; 
		$departments = $_REQUEST['departments_id'];
		$access_id = $_REQUEST['access_id_id'];

		
		$loadcontent =  XN_Content::load($record,strtolower($currentModule)."_".$supplierid);
		$profileid = $loadcontent->my->profileid;
		
		$Users = XN_Query::create ( 'Content' )
			->filter ( 'type', 'eic', 'users' )
			->filter ( 'my.deleted', '=', '0' ) 
			->filter ( 'my.profileid', '!=', $profileid )
			->filter ( 'my.user_name', '=', $account ) 
			->end(1)
			->execute (); 
		if (count($Users) > 0) 
		{
				echo '{"statusCode":"300","message":"后台账号已经占用!请更换员工账号！"}';
				die; 
		}
		$Users = XN_Query::create ( 'Content' )
			->filter ( 'type', 'eic', 'supplier_users' )
			->filter ( 'my.deleted', '=', '0' )
			->filter ( 'my.supplierid', '=', $supplierid )
			->filter ( 'my.mobile', '=', $mobile ) 
			->filter ( 'my.profileid', '!=', $profileid )
			->execute (); 
		if (count($Users) > 0) 
		{
				echo '{"statusCode":"300","message":"手机已经占用!请更换员工手机号码！"}';
				die; 
		} 
		 
		 
	        $users = XN_Query::create('Content')
	            ->tag("users")
	            ->filter('type', 'eic', "users")
	            ->filter('my.deleted', '=', '0')
	            ->filter ( 'my.profileid', '=', $profileid )
	            ->end(1)
	            ->execute();
			if (count($users) > 0) 
			{
				$user_info = $users[0];
				$user_info->my->email1 = $email;
				$user_info->my->phone_mobile = $mobile;
				$user_info->my->user_name = $account; 
				$user_info->my->first_name = $account; 
				$user_info->my->last_name = $account;  
				$user_info->my->user_type = 'guest';   
				$user_info->save("users");
			}
			$profile_info = XN_Profile::load($profileid,"id","profile");
	        $profile_info->fullName = $account . '#admin';
	        $profile_info->mobile = $mobile;
	        $profile_info->givenname = $account;
			$profile_info->save("profile,profile_".$profileid);
		} 
		 
		$loadcontent->my->account = $account;
		$loadcontent->my->email = $email;
		$loadcontent->my->mobile = $mobile; 
		$loadcontent->my->departments = $departments;
		$loadcontent->my->access_id = $access_id;
		$loadcontent->save(strtolower($currentModule).",".strtolower($currentModule)."_".$supplierid);
	 
	echo '{"statusCode":"200","message":null,"tabid":"'.$currentModule.'","closeCurrent":"true"}';
	die();
}

if (isset($_REQUEST['ids']) && $_REQUEST['ids'] != '') { 


	    $binds = $_REQUEST['ids']; 
	    $binds = str_replace(";",",",$binds);
	    $binds = explode(",",trim($binds,','));
	    array_unique($binds);
	    array_unique($binds);
		if (count($binds) > 1)
		{
			require_once('Smarty_setup.php');
			require_once('include/utils/utils.php');
			$smarty = new vtigerCRM_Smarty;
			global $mod_strings;
			global $app_strings;
			global $app_list_strings;
			$smarty->assign("APP", $app_strings);
			$smarty->assign("CMOD", $mod_strings); 
		    $msg = '<div style="width:100%;text-align:center;"><br><br><font color="red" size="2">您只能选择单条记录进行操作！</font></div>';  
			$smarty->assign("MSG", $msg);  
			$smarty->display("MessageBox.tpl");
			die();
		}
		$record = $_REQUEST['ids'];  
		$loadcontent =  XN_Content::load($record,strtolower($currentModule)."_".$supplierid); 
		$account = $loadcontent->my->account;
		$email = $loadcontent->my->email;
		$mobile = $loadcontent->my->mobile;
		$supplierusertype = $loadcontent->my->supplierusertype;
		$departments = $loadcontent->my->departments;
		$access_id = $loadcontent->my->access_id;
		$approvalstatus = $loadcontent->my->approvalstatus;
		$supplier_usersstatus = $loadcontent->my->supplier_usersstatus; 
		if ($supplier_usersstatus != "Agree")
		{
			require_once('Smarty_setup.php');
			require_once('include/utils/utils.php');
			$smarty = new vtigerCRM_Smarty;
			global $mod_strings;
			global $app_strings;
			global $app_list_strings;
			$smarty->assign("APP", $app_strings);
			$smarty->assign("CMOD", $mod_strings); 
		    $msg = '<div style="width:100%;text-align:center;"><br><br><font color="red" size="2">【'.$account.'】还没有提交上线，请直接编辑该记录！</font></div>';  
			$smarty->assign("MSG", $msg);  
			$smarty->display("MessageBox.tpl");
			die();
		}
		
		
		
		if (isset($departments) && $departments != "")
		{
			$department_info  =  XN_Content::load($departments,"supplier_departments_".$supplierid); 
			$departmentname = $department_info->my->departmentsname;
		}
		else
		{
			$departmentname = "";
		}
		if (isset($access_id) && $access_id != "")
		{
			$accesssetting_info  =  XN_Content::load($access_id,"supplier_accesssetting_".$supplierid);
			$access_name = $accesssetting_info->my->access_name;
		}
		else
		{
			$access_name = "";
		}
			 
			
		 
		  

		$msg.='<div class="form-group">
               <label class="control-label x85">员工账号：</label>
               	<input class="required" data-rule="required;" type="text" value="'.$account.'" name="account" tabindex="1" style="width:200px" maxlength="20" >
 			 </div>
			 <div class="form-group">
               <label class="control-label x85">邮箱：</label>
               <input class="required" data-rule="required;email;" type="text" value="'.$email.'" name="email" tabindex="2" style="width:200px" maxlength="30" >
			 </div>
			 <div class="form-group">
               <label class="control-label x85">手机号码：</label>
               <input class="required" data-rule="required;mobile;" type="text" value="'.$mobile.'" name="mobile" tabindex="11" style="width:200px" maxlength="100" >
			 </div> ';
		 
			   
		 $msg.= '
			 <div class="form-group">
               <label class="control-label x85">部门：</label>
			   <span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;"> 
			   	<input type="hidden" value="'.$departments.'" name="departments.id" id="departments_id">
			   	<input type="text" name="departments.name" id="departments_name" value="'.$departmentname.'"
			           			onclick = "$(this).parent().find(\'a.bjui-lookup\').trigger(\'click\');"
			           			size="20" style="padding-right: 25px;cursor: pointer;" data-rule=required; class="required" />
			   			<a data-callback="departments_callback" id="departments_lookup" class="bjui-lookup" data-toggle="lookupbtn"

			   			data-newurl=""
			   			data-oldurl="index.php?module=Supplier_Departments&action=Popup&popuptype=Supplier_Users&mode=0&exclude="
			   			data-url="index.php?module=Supplier_Departments&action=Popup&popuptype=Supplier_Users&mode=0&exclude="
			   			data-group="departments" data-maxable="false" data-title="选择部门管理"
			   			href="javascript:;" style="height: 22px; line-height: 22px;">
			   			<i class="fa fa-search"></i>
			   		</a>
					<script language="javascript" type="text/javascript">
						function departments_callback(group,args)
						{
							var oldurl = $("#departments_id").parent().find("a.bjui-lookup").data("oldurl");
							$("#departments_id").parent().find("a.bjui-lookup").data("newurl", oldurl+args.id);
							$("#departments_id").val(args.id);
							$("#departments_name").val(args.name);
						};
					</script>
			   	</span>
			 </div>
			 <div class="form-group">
               <label class="control-label x85">权限：</label> 
	 		  	<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;"> 
			   	<input type="hidden" value="'.$access_id.'" name="access_id.id" id="access_id_id">
			   	<input type="text" name="access_id.name" id="access_id_name" value="'.$access_name.'" onclick = "$(this).parent().find(\'a.bjui-lookup\').trigger(\'click\');"
			           			size="20" style="padding-right: 25px;cursor: pointer;" data-rule=required; class="required" />
			   			<a id="access_id_lookup" class="bjui-lookup" data-toggle="lookupbtn" 
			   			data-newurl=""
			   			data-oldurl="index.php?module=Supplier_AccessSetting&action=Popup&popuptype=Supplier_Users&mode=0&exclude="
			   			data-url="index.php?module=Supplier_AccessSetting&action=Popup&popuptype=Supplier_Users&mode=0&exclude="
			   			data-group="access_id" data-maxable="false" data-title="选择权限设置" href="javascript:;" style="height: 22px; line-height: 22px;">
			   			<i class="fa fa-search"></i>
			   		</a> 
			   	</span>
			 </div>';
		require_once('Smarty_setup.php');
		require_once('include/utils/utils.php');
		$smarty = new vtigerCRM_Smarty;
		global $mod_strings;
		global $app_strings;
		global $app_list_strings;
		$smarty->assign("APP", $app_strings);
		$smarty->assign("CMOD", $mod_strings);
		$smarty->assign("MSG", $msg);
		$smarty->assign("OKBUTTON", "确定修改");
		$smarty->assign("RECORD",$_REQUEST['ids']);
		$smarty->assign("SUBMODULE", $currentModule);
		$smarty->assign("SUBACTION", basename(__FILE__,".php"));

		$smarty->display("MessageBox.tpl");
		die();
}
 

?>

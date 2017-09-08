<?php
global  $currentModule,$supplierid;
if(isset($_REQUEST['record']) && $_REQUEST['record'] != "" &&
	isset($_REQUEST['type']) && $_REQUEST['type'] == "submit")
{
	if (isset($_REQUEST['suppliers_shortname']) && $_REQUEST['suppliers_shortname'] != "" &&
		isset($_REQUEST['suppliers_name']) && $_REQUEST['suppliers_name'] != "" &&
		isset($_REQUEST['companyaddress']) && $_REQUEST['companyaddress'] != ""   
	)
	{
		$record = $_REQUEST['record'];
		$suppliers_name = $_REQUEST['suppliers_name'];
		$suppliers_shortname = $_REQUEST['suppliers_shortname'];
		$companyaddress = $_REQUEST['companyaddress'];

		$loadcontent = XN_Content::load($record, strtolower($currentModule));
		$loadcontent->my->suppliers_shortname = $suppliers_shortname;
		$loadcontent->my->suppliers_name = $suppliers_name;
		$loadcontent->my->companyaddress = $companyaddress;
		$loadcontent->save(strtolower($currentModule));
	}
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
		$suppliers_shortname = $loadcontent->my->suppliers_shortname;
		$suppliers_name = $loadcontent->my->suppliers_name;
		$companyaddress = $loadcontent->my->companyaddress; 


		$msg.='<div class="form-group" style="margin: 20px 0 20px; ">
               <label class="control-label x85">商家全称：</label>
               	<input class="input input-large textInput required" type="text" value="'.$suppliers_name.'" name="suppliers_name" tabindex="16" style="width:150px" maxlength="100" >

             </div>
			 <div class="form-group" style="margin: 20px 0 20px; ">
               <label class="control-label x85">商家简称：</label>
               <input class="input input-large textInput required" type="text" value="'.$suppliers_shortname.'" name="suppliers_shortname" tabindex="16" style="width:150px" maxlength="100" >
			 </div>
			 <div class="form-group" style="margin: 20px 0 20px; ">
               <label class="control-label x85">商家地址：</label>
               <input class="input input-large textInput required" type="text" value="'.$companyaddress.'" name="companyaddress" tabindex="16" style="width:250px" maxlength="100" >
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

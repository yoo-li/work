<?php
require_once('Smarty_setup.php');
require_once('include/utils/utils.php');

global  $currentModule;

if(isset($_REQUEST['record']) && $_REQUEST['record']!="" &&
	isset($_REQUEST['type']) &&$_REQUEST['type']=="submit" ){
	$ids = $_REQUEST['record'];
	$ids = explode(",",trim($ids,','));
	array_unique($ids);
	$ids = array_filter($ids);
	try{
		 if(!isset($_REQUEST['reason']) || $_REQUEST['reason']=="" ){
			 echo '{"statusCode":"300","message":"发送信息不能空"}';
			 die();
		 } 

		global  $supplierid;

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
			if (isset($appid) && $appid != "")
			{
				
				require_once (XN_INCLUDE_PREFIX."/XN/Message.php");
				foreach($ids as $supplier_profileid){
					$supplier_profile = XN_Content::load($supplier_profileid,"supplier_profile",4);
					$profileid = $supplier_profile->my->profileid;
					 
					XN_Message::sendmessage($profileid,$_REQUEST['reason'],$appid);
				}
			}
		}

	}
	catch(XN_Exception $e){
		echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
		die();
	}
	echo '{"statusCode":"200","message":null,"tabid":"","closeCurrent":"true","forward":null}';
	die();
}
else{
	$smarty = new vtigerCRM_Smarty;
	$author=getGivenNamesByids(XN_Profile::$VIEWER);
	$msg= '
 	<div class="form-group" style="width:98%;margin:3px 0px;float:left;">
		<label class="control-label x100">操作人：</label>
		<input style="width:200px;" readonly class="form-control" value="'.$author.'">
	</div>
	<div class="form-group" style="width:98%;margin:3px 0px;float:left;">
		<label class="control-label x100">消息内容：</label>
		<textarea style="width:200px;height:100px;" class="form-control required" name="reason" data-rule="required"/></textarea>
	</div>
	';
	$smarty->assign("APP", $app_strings);
	$smarty->assign("CMOD", $mod_strings);
	$smarty->assign("MSG", $msg);
	$smarty->assign("RECORD", $_REQUEST['ids']);
	$smarty->assign("SUBMODULE", $currentModule);
	$smarty->assign("OKBUTTON", "确定发送");
	$smarty->assign("SUBACTION", $_REQUEST['action']);

	$smarty->display("MessageBox.tpl");
}

   
    

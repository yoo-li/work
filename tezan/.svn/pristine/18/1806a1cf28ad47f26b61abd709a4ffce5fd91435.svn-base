<?php
/*+**********************************************************************************
 * The contents of this file are subject to the 361CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  361CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

global $mod_strings,$app_strings,$theme,$currentModule,$current_user;

require_once('Smarty_setup.php');
require_once('include/utils/utils.php');

$smarty = new vtigerCRM_Smarty;

$panel =  strtolower(basename(__FILE__,".php"));

$smarty->assign("MODULE",$currentModule);
$smarty->assign("PANEL",$panel);

$smarty->assign("APP",$app_strings);
$smarty->assign("MOD", $mod_strings);
$smarty->assign("CATEGORY",getParentTab());

$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$smarty->assign("THEME", $theme);
$smarty->assign("IMAGE_PATH", $image_path);

if(isset($_REQUEST['record']) && $_REQUEST['record'] !='' && isset($_REQUEST['save']) && $_REQUEST['save'] =='true') 
{
		if (isset($_REQUEST['replaycontent']) && $_REQUEST['replaycontent'] != '') 
		{
		    $replaycontent = $_REQUEST['replaycontent'];
			global  $supplierid,$supplierusertype; 
		    $recordid = $_REQUEST['record'];
		    $supplier_chat_info = XN_Content::load($recordid,'supplier_chats_'.$supplierid); 
		    $profileid = $supplier_chat_info->my->profileid;
			$supplier_chat_info->my->chatstatus = '1';
			$supplier_chat_info->my->lastreplytime = date("Y-m-d H:i");
			$supplier_chat_info->save('supplier_chats,supplier_chats_'.$supplierid.',supplier_chats_'.$profileid);
		
		    $newcontent = XN_Content::create('supplier_messages','',false,9);  
	        $newcontent->my->deleted = '0';
			$newcontent->my->profileid = $profileid; 
	        $newcontent->my->supplierid = $supplierid; 
			$newcontent->my->businesseid = '';
			$newcontent->my->msgtype = '1'; 
			$newcontent->my->source = '1'; 
			$newcontent->my->fromprofileid = XN_Profile::$VIEWER; 
			$newcontent->my->message = $replaycontent;
	        $newcontent->save('supplier_messages,supplier_messages_'.$supplierid.',supplier_messages_'.$profileid);
		} 
		
		echo '{	"statusCode":"200","message":null,"tabid":"edit","closeCurrent":true,"forward":null}';
		die(); 
}

if(isset($_REQUEST['record']) && $_REQUEST['record'] !='') 
{
	    $recordid = $_REQUEST['record']; 

		 $msg = '
<input type="hidden" name="record" value="'.$recordid.'">
<input type="hidden" name="save" value="true"> 
<div class="form-group" style="margin: 20px 0 20px; ">
		<label class="control-label x120">'.getTranslatedString('CustomService').':</label>
		<input type="text" disabled  value="'.$current_user->last_name.'">
</div>

<div class="form-group" style="margin: 20px 0 20px; ">
		<label class="control-label x120">*</font>'.getTranslatedString('ReplyContent').':</label>
		<textarea class="required" data-rule="required" style="width:450px;height:120px;" name="replaycontent" id="replaycontent"></textarea>
</div>'; 
}



$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->assign("MSG", $msg);
$smarty->assign("SUBMODULE", $currentModule);
$smarty->assign("OKBUTTON", "保存");
$smarty->assign("SUBACTION", "AddMessage");

$smarty->display("MessageBox.tpl");

?>
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
	    $recordid = $_REQUEST['record'];
		$replaycontent = $_REQUEST['replaycontent'];
		
		$wxservice = XN_Content::load($recordid,'wxservices');
	    $wxid = $wxservice->my->wxid;
	   	$fromusername = $wxservice->my->fromusername;
		$fromprofileid = $wxservice->my->fromprofileid;	
		$replycount = $wxservice->my->replycount;	
			
		$newcontent = XN_Content::create('wxreplys','',false);	
	    $newcontent->my->record  = $recordid; 
	    $newcontent->my->wxid  = $wxid;  
		$newcontent->my->reply = $replaycontent;
		$newcontent->my->tousername = $fromusername;
		$newcontent->my->toprofileid = $fromprofileid;
		$newcontent->my->customservice = XN_Profile::$VIEWER;
		$newcontent->my->replytime = date("Y-m-d H:i");
		$newcontent->save('wxreplys');
		
		require_once (XN_INCLUDE_PREFIX."/XN/Wx.php");
		
		
		
		$wx = XN_Content::load($wxid,'wxsettings');
		$wxname = $wx->my->wxname;
		$appid = $wx->my->appid;
		$secret = $wx->my->secret;
		XN_WX::$APPID = $appid;
		XN_WX::$SECRET = $secret; 
	
		$msg = XN_WX::sendtextmessage($fromusername,$replaycontent); 
		
		$wxservice->my->customservice = $current_user->last_name;
		$wxservice->my->lastreplytime = date("Y-m-d H:i");
		$wxservice->my->replycount = intval($replycount)+1;
		$wxservice->save('wxservices');
		
		echo '{	"statusCode":"200","message":null,"tabid":"edit","closeCurrent":true,"forward":null}';
		die(); 
}

if(isset($_REQUEST['record']) && $_REQUEST['record'] !='') 
{
	    $recordid = $_REQUEST['record'];
	  			 

		 $msg = '
<div class="pageContent">

    <form method="post" action="index.php" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone)">
<input type="hidden" name="module" value="WxServices">
<input type="hidden" name="action" value="AddWxReplys">
<input type="hidden" name="record" value="'.$recordid.'">
<input type="hidden" name="save" value="true">
<input type="hidden" name="mode" value="ajax">

        <div class="pageFormContent" layoutH="58">            
            <div class="form-group">
                <label class="control-label x120">'.getTranslatedString('Custom Service').':</label>
                <input type="text" disabled  value="'.$current_user->last_name.'">
            </div>
			<div class="form-group">
                <label class="control-label x120">'.getTranslatedString('ReplyTime').':</label>
                <input type="text" disabled  value="'.date("Y-m-d H:i").'">
            </div>
            
            <div class="form-group">
                <label class="control-label x120">*</font>'.getTranslatedString('Reply Content').':</label>
				<textarea class="required" style="width:500px;height:145px;" name="replaycontent" id="replaycontent"></textarea>
            </div>
            
        </div>
        <div class="formBar">
            <ul>
                <li><div class="buttonActive"><div class="buttonContent"><button type="submit">保存</button></div></div></li>
                <li><div class="button"><div class="buttonContent"><button type="button" class="close">返回</button></div></div></li>
            </ul>
        </div>
    <input type="hidden" name="__hash__" value="f05447c821012018c16dec99264a7bdc_ea332f4bef78750abe1e93924eaf44f8" /></form>    
</div>

		 ';
		$smarty->assign("POPUP_DIV", $msg);
}


$smarty->assign("SCRIPT",'');

$smarty->assign("BUTTONS", array());

$smarty->display('PopupDiv.tpl');

?>
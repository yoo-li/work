<?php



require_once('Smarty_setup.php');
require_once('include/utils/utils.php');

global  $currentModule;

 

if (isset($_REQUEST['wxid']) && $_REQUEST['wxid'] != "" && isset($_REQUEST['type']) && $_REQUEST['type'] == "submit"  )
{
	try {
		$wxid = $_REQUEST['wxid']; 
		$menuitemname = $_REQUEST['menuitemname'];
		$apptype = $_REQUEST['apptype']; 
		$sequence= $_REQUEST['sequence']; 
		
		$wx = XN_Content::load($wxid,'WxSettings');
		$appid = $wx->my->appid;
		//
		 
		$menuitemkey = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri=http%3A%2F%2Fmall.tezan.cn%2Findex.php%3Ftarget%3Dindex%26type%3Dinit%26appid%3D'.$appid.'&response_type=code&scope=snsapi_base&state=1#wechat_redirect';
		 
		$newcontent = XN_Content::create('wxmenus','',false);					  
		$newcontent->my->parentid = '0';
		$newcontent->my->record = $wxid;
		$newcontent->my->name = $menuitemname;
		$newcontent->my->type = 'view';
		$newcontent->my->key = $menuitemkey;
		$newcontent->my->sequence = $sequence; 
	    $newcontent->my->deleted = '0';
		$newcontent->save('wxmenus');
		
			
		echo '{"statusCode":"200","message":null,"tabid":"edit","closeCurrent":true,"forward":null}';
	} catch ( XN_Exception $e ) 
	{
		 echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
	}			
	die();
}


$smarty = new vtigerCRM_Smarty;


$msg =  '<div class="form-group">
                <label class="control-label x120">'.getTranslatedString('MenuItem Name').':</label>
				<input type="text" data-rule="required" class="input required" value="" id="menuitemname" name="menuitemname" tabindex="1">
            </div> 
			<div class="form-group">
                <label class="control-label x120">'.getTranslatedString('Sequence').':</label>
				<input type="text" data-rule="required" class="input number required" value="'.$loadcontent->my->sequence.'" id="sequence" name="sequence" tabindex="1">
            </div>';

$msg .= '<input type="hidden" name="wxid" value="'.$_REQUEST['wxid'].'">';
	
 


$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->assign("MSG", $msg);
$smarty->assign("SUBMODULE", "WxSettings");
$smarty->assign("OKBUTTON", "保存");
$smarty->assign("SUBACTION", "AppMenuItem");

$smarty->display("MessageBox.tpl");
 

?>
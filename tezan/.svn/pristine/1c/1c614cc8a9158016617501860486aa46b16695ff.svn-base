<?php



require_once('Smarty_setup.php');
require_once('include/utils/utils.php');

global  $currentModule;

 


if (isset($_REQUEST['wxid']) && $_REQUEST['wxid'] != "" && isset($_REQUEST['type']) && $_REQUEST['type'] == "submit"  )
{
	try {
		$wxid = $_REQUEST['wxid']; 
		$specialmenuitem = $_REQUEST['specialmenuitem'];
		$apptype = $_REQUEST['apptype']; 
		$sequence= $_REQUEST['sequence']; 
		
		$wx = XN_Content::load($wxid,'Supplier_WxSettings');
		$appid = $wx->my->appid;
		//
		if  ($specialmenuitem == "usercenter")
		{
			if ( $apptype == "O2O")
			{
				$menuitemkey = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri=http%3A%2F%2Fo2o.'.get_wx_domain().'%2Findex.php%3Ftarget%3Dindex%26type%3Dusercenter%26appid%3D'.$appid.'&response_type=code&scope=snsapi_base&state=1#wechat_redirect';

			}
			else if ( $apptype == "F2C")
			{
				$menuitemkey = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri=http%3A%2F%2Ff2c.'.get_wx_domain().'%2Findex.php%3Ftarget%3Dindex%26type%3Dusercenter%26appid%3D'.$appid.'&response_type=code&scope=snsapi_base&state=1#wechat_redirect';
			}
			else if ( $apptype == "B2B")
			{
				$menuitemkey = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri=http%3A%2F%2Fb2b.'.get_wx_domain().'%2Findex.php%3Ftarget%3Dindex%26type%3Dusercenter%26appid%3D'.$appid.'&response_type=code&scope=snsapi_base&state=1#wechat_redirect';
			}
			else
			{
				echo '{"statusCode":"300","message":"没有此'.$apptype.'模式的菜单！"}';
				die();
			}
			$newcontent = XN_Content::create('wxmenus','',false);
			$newcontent->my->parentid = '0';
			$newcontent->my->record = $wxid;
			$newcontent->my->name = '会员中心';
			$newcontent->my->type = 'view';
			$newcontent->my->key = $menuitemkey;
			$newcontent->my->sequence = $sequence;
			$newcontent->my->deleted = '0';
			$newcontent->save('wxmenus');
		}
		else if  ($specialmenuitem == "qrcodecard")
		{
			$newcontent = XN_Content::create('wxmenus','',false);
			$newcontent->my->parentid = '0';
			$newcontent->my->record = $wxid;
			$newcontent->my->name = '推广名片';
			$newcontent->my->type = 'click';
			$newcontent->my->key = 'qrcodecard';
			$newcontent->my->sequence = $sequence;
			$newcontent->my->deleted = '0';
			$newcontent->save('wxmenus');
		}
		else
		{
			echo '{"statusCode":"300","message":"没有此特殊的菜单！"}';
			die();
		}


		
			
		echo '{"statusCode":"200","message":null,"tabid":"edit","closeCurrent":true,"forward":null}';
	} catch ( XN_Exception $e ) 
	{
		 echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
	}			
	die();
}


$smarty = new vtigerCRM_Smarty;


$msg =  '<div class="form-group">
                <label class="control-label x100" style="text-align:right;">特殊菜单:</label>
				<select data-toggle="selectpicker" id="specialmenuitem" name="specialmenuitem">
					<option value="usercenter">会员中心</option>
					<option value="qrcodecard">推广名片</option>
				 </select>
            </div>
		<div class="form-group" style="margin-top:5px;">
                <label class="control-label x100" style="text-align:right;">应用类型:</label>
				<select data-toggle="selectpicker" id="apptype" name="apptype"> 
				<option value="F2C">微信商城</option> 
				<option value="O2O">O2O餐饮商城</option>
				 </select>
            </div>
			<div class="form-group" style="margin-top:5px;">
                <label class="control-label x100" style="text-align:right;">'.getTranslatedString('Sequence').':</label>
				<input type="text" data-rule="required" class="input number required" value="'.$loadcontent->my->sequence.'" id="sequence" name="sequence" tabindex="1">
            </div>';

$msg .= '<input type="hidden" name="wxid" value="'.$_REQUEST['wxid'].'">';
	
 


$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->assign("MSG", $msg);
$smarty->assign("SUBMODULE", "Supplier_WxSettings");
$smarty->assign("OKBUTTON", "保存");
$smarty->assign("SUBACTION", "SpecialMenuItem");

$smarty->display("MessageBox.tpl");
 

?>
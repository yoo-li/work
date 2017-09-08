<?php
global $currentModule,$current_user;

require_once('Smarty_setup.php');
require_once('include/utils/utils.php');

function getYearModuleByToBy($module,$byid,$toid,$isSys = false){
    try{
        $details = XN_Content::load($byid,strtolower($module),7);
        if($isSys)
            return $details->$toid;
        else
            return $details->my->$toid;
    }catch (XN_Exception $ex){
        return '';
    }
}

function getModuleByToBy($module,$byid,$toid,$isSys = false){
    try{
        $details = XN_Content::load($byid,strtolower($module));
        if($isSys)
            return $details->$toid;
        else
            return $details->my->$toid;
    }catch (XN_Exception $ex){
        return '';
    }
}
 
if(isset($_REQUEST['type']) && $_REQUEST['type'] == "submit"){
    $record = $_REQUEST['record'];
    $delivery =$_REQUEST['delivery'];
    $mailno = $_REQUEST['invoicenumber'];
	global $currentModule;
	
	$focus = XN_Content::load($_REQUEST['record'],strtolower($currentModule),7);
	$profileid = $focus->my->profileid;
	$supplierid = $focus->my->supplierid;
	$focus->my->order_status = "已发货";
	$focus->my->deliverystatus = "sendout";
	$focus->my->delivery_status = "1";
	$focus->my->invoicenumber = $_REQUEST['invoicenumber'];
	$focus->my->delivery = $_REQUEST['delivery'];
	$focus->my->deliverytime = date('Y-m-d H:i:s');
    $tag = strtolower($currentModule).','.strtolower($currentModule).'_'.$profileid.','.strtolower($currentModule).'_'.$supplierid;
	try {
	    $focus->save($tag);
		
		$smsCon = '您的订单'.$focus->my->mall_orders_no.'已经发货,物流公司:'.getModuleByToBy("Logistics", $_REQUEST['delivery'], 'logisticsname').',发货单号:'.$_REQUEST['invoicenumber'].',预计12小时后,物流信息将会更新.';
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
			require_once (XN_INCLUDE_PREFIX."/XN/Message.php");
	        XN_Message::sendmessage($profileid,$smsCon,$appid);   
		} 
		if ($current_user->selectlogistic != $delivery)
		{
			$users = XN_Query::create ( 'Content' ) ->tag('users')
			    ->filter ( 'type', 'eic', 'users')
			    ->filter ( 'my.deleted', '=', '0' )
			    ->filter ( 'my.profileid', '=' ,XN_Profile::$VIEWER)
			    ->execute(); 
			if (count($users) > 0)
			{
				$user_info = $users[0];
				if ($user_info->my->selectlogistic != $delivery)
				{
					$user_info->my->selectlogistic = $delivery;
					$user_info->save("users");
					XN_MemCache::delete("user_privileges_".XN_Application::$CURRENT_URL."_".XN_Profile::$VIEWER);
				}
			}
		}
		 
	} 
	catch (XN_Exception $e) 
	{
		echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
		die;
	}

    echo '{"statusCode":"200","message":null,"tabid":"edit","closeCurrent":true,"forward":null}';
    die();
}

 

$query = XN_Query::create('Content')->tag('logistics')
    ->filter('type','eic','logistics')
    ->filter('my.deleted','=','0')
    ->filter('my.status','=','Active')
    ->begin(0)->end(-1)
    ->execute();
$delivery = array(); 
foreach($query as $info){
    if ($current_user->selectlogistic == $info->id)
	{
		$delivery[] = '<option value="'.$info->id.'" selected >'.$info->my->logisticsname.'</option>';
	}
	else
	{
		$delivery[] = '<option value="'.$info->id.'">'.$info->my->logisticsname.'</option>';
	}
        
} 
 

$msg =  '<div class="form-group">
                <label class="control-label x120">物流公司:</label>
			     <select id="delivery" class="form-contro" name="delivery" style="cursor: pointer;">'.implode('', $delivery).'</select>
				</div> ';
$msg .=  '<div class="form-group">
                <label class="control-label x120">发货单号:</label>
				<input id="invoicenumber" name="invoicenumber"  class="form-contro required" data-rule="required" type="text" value="'.$conn->my->invoicenumber.'">
		    </div> ';
			

$smarty = new vtigerCRM_Smarty;
global $mod_strings;
global $app_strings;
global $app_list_strings;
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->assign("MSG", $msg);
$smarty->assign("OKBUTTON", "确定发货");
$smarty->assign("RECORD",$_REQUEST['record']);
$smarty->assign("SUBMODULE", "Mall_Orders");
$smarty->assign("SUBACTION", "Invoice");

$smarty->display("MessageBox.tpl");
?>
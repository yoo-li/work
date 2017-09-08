<?php
global $currentModule,$current_user;

require_once('Smarty_setup.php');
require_once('include/utils/utils.php');

if(isset($_REQUEST['record']) && $_REQUEST['record'] != ""){
    try{
        $conn = XN_Content::load($_REQUEST['record'],strtolower($currentModule),7);
    }catch(XN_Exception $ex){
        echo '{"statusCode":300,"message":"获取数据出错！"}';
    	die();
    }
}else{
    echo '{"statusCode":300,"message":"错误的调用方式！"}';
    die();
}
if(isset($_REQUEST['type']) && $_REQUEST['type'] == "submit"){
    $record = $_REQUEST['record'];
    $delivery =$_REQUEST['delivery'];
    $mailno = $_REQUEST['invoicenumber'];
    $ordercontent = XN_Content::load($record,'mall_orders',7);
    $supplierid = $ordercontent->my->supplierid;
	$profileid = $ordercontent->my->profileid;
    $suppliercontent=XN_Content::load($supplierid,"suppliers");
    $d_city = $ordercontent->my->city ;
    $d_province = $ordercontent->my->province ;
    $j_province = $suppliercontent->my->province;
    $j_city = $suppliercontent->my->city;
    $orderid=$ordercontent->my->orders_no;//订单号    
    $j_company=$suppliercontent->my->company;//寄货公司
    $j_contact=$suppliercontent->my->suppliers_name;//寄货人
    $j_telphone=$suppliercontent->my->mobile;//寄货手机号码
    $j_address=$suppliercontent->my->companyaddress;//寄货地址
    $d_company=$ordercontent->my->consignee;//收货人公司
    $d_contact=$ordercontent->my->consignee;//收货人
    $d_telphone=$ordercontent->my->mobile;//收货手机号码
    $d_address=$ordercontent->my->address;//收货地址
    $name=$ordercontent->my->ordername;//商品名称
    $sendstarttime = date('Y-m-d H:i:s');
    $conn->my->delivery_status = "1";
    $conn->my->delivery = $_REQUEST['delivery'];
    $conn->my->invoicenumber =$mailno ;//物流单号
	$tag = strtolower($currentModule).','.strtolower($currentModule).'_'.$profileid.','.strtolower($currentModule).'_'.$supplierid;
    $conn->save($tag);
	
	
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

    echo '{"statusCode":"200","message":null,"tabid":"edit","rel":"edit","closeCurrent":true,"forward":null}';
    die();
}

$query = XN_Query::create('Content')->tag('logistics')
    ->filter('type','eic','logistics')
    ->filter('my.deleted','=','0')
    ->filter('my.status','=','Active')
    ->begin(0)->end(-1)
    ->execute();
$delivery = array();
$selected  = false;
foreach($query as $info){
    if($info->id == $conn->my->delivery)
	{
        $delivery[] = '<option selected value="'.$info->id.'">'.$info->my->logisticsname.'</option>';
		$selected = true;
	}
    else
        $delivery[] = '<option value="'.$info->id.'">'.$info->my->logisticsname.'</option>';
} 

if (!$selected)
{
	$logistic_info = XN_Content::load($conn->my->delivery,"logistics");
	$delivery[] = '<option selected value="'.$logistic_info->id.'">'.$logistic_info->my->logisticsname.'</option>';
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
$smarty->assign("OKBUTTON", "确定修改");
$smarty->assign("RECORD",$_REQUEST['record']);
$smarty->assign("SUBMODULE", "Mall_Orders");
$smarty->assign("SUBACTION", "UpdateInvoiceNumber");

$smarty->display("MessageBox.tpl");
?>
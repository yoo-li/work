<?php
global  $currentModule,$supplierid;
if (isset($_REQUEST['record']) && $_REQUEST['record'] != '' &&
	isset($_REQUEST['type']) && $_REQUEST['type'] == "submit") {
		$record = $_REQUEST['record'];
		$invoicenumber = $_REQUEST['invoicenumber'];
		$delivery = $_REQUEST['delivery'];

		try {
			$loadcontent = XN_Content::load($record,strtolower($currentModule),7);
			$orderid = $loadcontent->my->orderid;

			$mall_vendors = XN_Query::create ( 'Content' ) ->tag('mall_vendors')
				->filter ( 'type', 'eic', 'mall_vendors')
				->filter ( 'my.deleted', '=', '0' )
				->filter ( 'my.supplierid', '=' ,$supplierid)
				->filter ( 'my.profileid', '=' ,XN_Profile::$VIEWER)
				->execute();
			if (count($mall_vendors) > 0)
			{
				$mall_vendor_info = $mall_vendors[0];
				$vendorid = $mall_vendor_info->id;
				$mall_settlementorders = XN_Query::create ( 'YearContent' ) ->tag('mall_settlementorders')
					->filter ( 'type', 'eic', 'mall_settlementorders')
					->filter ( 'my.deleted', '=', '0' )
					->filter ( 'my.orderid', '=' ,$orderid)
					->filter ( 'my.vendorid', '=' ,$vendorid)
					->end(-1)
					->execute();
			}
			else
			{
				$mall_settlementorders = XN_Query::create ( 'YearContent' ) ->tag('mall_settlementorders')
					->filter ( 'type', 'eic', 'mall_settlementorders')
					->filter ( 'my.deleted', '=', '0' )
					->filter ( 'my.orderid', '=' ,$orderid)
					->end(-1)
					->execute();
			}

			if (count($mall_settlementorders) > 0)
			{
				foreach($mall_settlementorders as $mall_settlementorder_info)
				{
						$mall_settlementorder_info->my->deliverystatus = "1";
						$mall_settlementorder_info->my->invoicenumber = $invoicenumber;
						$mall_settlementorder_info->my->delivery = $delivery;
						$mall_settlementorder_info->my->deliverytime = date('Y-m-d H:i:s');
						$mall_settlementorder_info->my->mall_settlementordersstatus = '已发货';
						$mall_settlementorder_info->save("mall_settlementorders,mall_settlementorders_".$supplierid);
				}
			}

			$order_info = XN_Content::load($orderid,'mall_orders',7);
			$profileid = $order_info->my->profileid;
			$supplierid = $order_info->my->supplierid;
			$order_info->my->order_status = "已发货";
			$order_info->my->deliverystatus = "sendout";
			$order_info->my->delivery_status = "1";
			$order_info->my->invoicenumber = $invoicenumber;
			$order_info->my->delivery = $delivery;
			$order_info->my->deliverytime = date('Y-m-d H:i:s');
			$order_info->save("mall_orders,mall_orders_".$profileid.",mall_orders_".$supplierid);
			$delivery_info=XN_Content::load($delivery,"Logistics");
			$smsCon = '您的订单'.$order_info->my->mall_orders_no.'已经发货,物流公司:'.$delivery_info->my->logisticsname.',发货单号:'.$invoicenumber.',预计12小时后,物流信息将会更新.';
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

		}
		catch (XN_Exception $e)
		{
			echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
			die;
		}
		echo '{"statusCode":"200","message":null,"tabid":"edit","closeCurrent":true,"forward":null}';
		die();
}
else{
	$record = $_REQUEST['record'];
	$loadcontent =  XN_Content::load($record,strtolower($currentModule)."_".$supplierid,7);
	$delivery = $loadcontent->my->delivery;
	$invoicenumber = $loadcontent->my->invoicenumber;
	$logistics = getlogistics();
	$logisticoption = ""; 
	global $current_user;
	if (!isset($delivery) || $delivery == "")
	{
	 	$delivery = $current_user->selectlogistic;
	} 
	foreach ($logistics as $key => $value)
	{
		if ($delivery == $key)
		{
			$logisticoption .= '<option value='.$key.' selected>'.$value.'</option>';
		}
		else
		{
			$logisticoption .= '<option value='.$key.'>'.$value.'</option>';
		}
	}
	require_once('Smarty_setup.php');
	require_once('include/utils/utils.php');

	$smarty = new vtigerCRM_Smarty;

	$smarty->assign("MODULE",$currentModule);
	$smarty->assign("APP",$app_strings);
	$smarty->assign("MOD", $mod_strings);


	$msg= '
			<table class="table" border="0" cellspacing="0" cellpadding="0">
			<tr class="edit-form-tr">
				<td class="edit-form-tdlabel mandatory">物流公司:</td>
				<td class="edit-form-tdinfo">
					<select name="delivery" class="required" style="cursor: pointer;width:135px;">'.$logisticoption.'</select></td>
			</tr>
			<tr class="edit-form-tr">
				<td class="edit-form-tdlabel mandatory">发货单号:</td>
				<td class="edit-form-tdinfo">
						<input class="input input-large number number textInput required" type="text" value="'.$invoicenumber.'" name="invoicenumber" tabindex="16" style="width:200px" maxlength="100" >
				</td>
			</tr>
		</table>
	';
	$smarty->assign("MSG", $msg);
	$smarty->assign("SUBMODULE", $currentModule);
	$smarty->assign("SUBACTION", $_REQUEST['action']);
	$smarty->assign("OKBUTTON", '确定发货');
	$smarty->assign("CANCELBUTTON", "关闭");
	$smarty->assign("RECORD", $record);
	$smarty->display('MessageBox.tpl');
}


function getlogistics()
{
	global $supplierid;
    $logistics = array();
    $mall_vendors = XN_Query::create ( 'Content' )->tag('logistics')
	    ->filter ( 'type', 'eic', 'logistics') 
	    ->filter('my.deleted','=','0')
		->filter('my.status','=','Active')  
	    ->end(-1)
	    ->execute(); 
    foreach ($mall_vendors as $info)
	{ 
        $logistics[$info->id] = $info->my->logisticsname;  
    }
    return $logistics;
}

?>

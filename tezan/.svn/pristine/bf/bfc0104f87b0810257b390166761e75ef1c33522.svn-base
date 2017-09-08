<?php
global $mod_strings,$app_strings,$theme,$currentModule,$current_user,$action;

require_once('Smarty_setup.php');
require_once('include/utils/utils.php');

$idlist = $_REQUEST['idlist'];
$storearray = explode(";",trim($idlist,';'));
$content = XN_Content::load($storearray[0], 'users');
$profileId = $content->my->profileid;
$smarty = new vtigerCRM_Smarty;
$smarty->assign("APP",$app_strings);
$smarty->assign("MOD", $mod_strings);
$smarty->assign('PROFILEID', $profileId);

if ($content->my->is_admin == 'on' || $content->my->creator == 1) {
	$error = $mod_strings['LBL_CAN_NOT_DELETE_ADMIN'];
	$smarty->assign('ERROR', $error);
} else {
	/**代办事项**/
	$module = 'Calendar';
	$contents = XN_Query::create('Content')->tag(strtolower($module))
		->filter('type','eic',strtolower($module))
		->filter('my.personman','=',$profileId)
		->filter('my.deleted','=',0)
		->end(-1)
		->execute();
	$value = count($contents);
	$msgInfo[] = array('key' => 'Todo_Count','value'=> $value);
	/**客户数**/
	$module = 'Accounts';
	$contents = XN_Query::create('Content')->tag(strtolower($module))
		->filter('type','eic',strtolower($module))
		->filter('my.personman','=',$profileId)
		->filter('my.deleted','=',0)
		->end(-1)
		->execute();
	$value = count($contents);
	$msgInfo[] = array('key' => 'Accounts_Count','value'=> $value);
	/**联系人数**/
	$module = 'Contacts';
	$contents = XN_Query::create('Content')->tag(strtolower($module))
		->filter('type','eic',strtolower($module))
		->filter('my.personman','=',$profileId)
		->filter('my.deleted','=',0)
		->end(-1)
		->execute();
	$value = count($contents);
	$msgInfo[] = array('key' => 'Contacts_Count','value'=> $value);
	/**项目机会数量/总额**/
	$module = 'Potentials';
	$contents = XN_Query::create('Content')->tag(strtolower($module))
		->filter('type','eic',strtolower($module))
		->filter('my.personman','=',$profileId)
		->filter('my.deleted','=',0)
		->end(-1)
		->execute();
	if (count($contents) >0) {
		$count = count($contents);
		foreach ($contents as $content) {
			$amount += $content->my->expectedclosingamount;
		}
		$value = $count.'/'.$amount;
	}
	$msgInfo[] = array('key' => 'Potentials_Number/Amount','value'=> $value);
	/**合同数量/总额**/
	$value = '0/0';
	$count = 0;
	$amount = 0;
	$module = 'PurchaseOrder';
	$purchaseorder = XN_Query::create('Content')->tag(strtolower($module))
		->filter('type','eic',strtolower($module))
		->filter('my.personman','=',$profileId)
		->filter('my.deleted','=',0)
		->end(-1)
		->execute();
	if (count($purchaseorder) > 0) {
		foreach ($purchaseorder as $content) {
			$count ++;
			$amount += $content->my->contractamount;
		}
	}
	$module = 'SalesOrder';
	$salesorder = XN_Query::create('Content')->tag(strtolower($module))
		->filter('type','eic',strtolower($module))
		->filter('my.personman','=',$profileId)
		->filter('my.deleted','=',0)
		->execute();
	if (count($salesorder) > 0) {
		foreach ($salesorder as $content) {
			$count ++;
			$amount += $content->my->contractamount;
		}
	}
	$value = $count.'/'.$amount;
	$msgInfo[] = array('key' => 'Order_Number/Amount','value'=> $value);
	/**已收/已付总额**/
	$receivableAmount = $payableAmount = 0;
	$accountreceivables = XN_Query::create('Content')->tag('accountreceivable')
		->filter('type','eic','accountreceivable')
		->filter('my.personman','=',$profileId)
		->filter('my.orderbalance','=',0)
		->filter('my.deleted','=',0)
		->execute();
	$accountpayables = XN_Query::create('Content')->tag('accountpayable')
		->filter('type','eic','accountpayable')
		->filter('my.personman','=',$profileId)
		->filter('my.orderbalance','=',0)
		->filter('my.deleted','=',0)
		->execute();
	if (count($accountreceivables) > 0) {
		foreach($accountreceivables as $content) {
			$receivableAmount += $content->my->orderamount;
		}
	}
	if (count($accountpayables) > 0) {
		foreach($accountpayables as $content) {
			$payableAmount += $content->my->orderamount;
		}
	}
	$value = $receivableAmount.'/'.$payableAmount;
	$msgInfo[] = array('key' => 'Already_Account_Amount','value'=> $value);
	/**应收/应付总额**/
	$receivableAmount = $payableAmount = 0;
	$accountreceivables = XN_Query::create('Content')->tag('accountreceivable')
		->filter('type','eic','accountreceivable')
		->filter('my.personman','=',$profileId)
		->filter('my.orderbalance','>',0)
		->filter('my.deleted','=',0)
		->execute();
	$accountpayables = XN_Query::create('Content')->tag('accountpayable')
		->filter('type','eic','accountpayable')
		->filter('my.personman','=',$profileId)
		->filter('my.orderbalance','>',0)
		->filter('my.deleted','=',0)
		->execute();
	if (count($accountreceivables) > 0) {
		foreach($accountreceivables as $content) {
			$receivableAmount += $content->my->orderamount;
		}
	}
	if (count($accountpayables) > 0) {
		foreach($accountpayables as $content) {
			$payableAmount += $content->my->orderamount;
		}
	}
	$value = $receivableAmount.'/'.$payableAmount;
	$msgInfo[] = array('key' => 'Account_Number/Amount','value'=> $value);
	/**费用报销总额**/
	$module = 'Charege';
	$moduleDetail = 'charge_details';
	$amount = 0;
	$chargeidArr = array();
	$contents = XN_Query::create('Content')->tag(strtolower($moduleDetail))
		->filter('type','eic',strtolower($moduleDetail))
		->filter('my.personman','=',$profileId)
		->execute();
	if (count($contents) > 0) {
		foreach ($contents as $content) {
			if (in_array($content->my->recordid, $chargeidArr)) continue;
			else {
				$reimbursement_amount = $content->my->reimbursement_amount;
				if (is_array($content->my->account)) {
					$amount += $reimbursement_amount/(count($content->my->account));
				}else $amount += $reimbursement_amount;
				$chargeidArr[] = $charge->id;
			}
			
		}
	}
	$msgInfo[] = array('key' => 'Charge_Amount','value'=> $amount);
	$smarty->assign('MSGINFO', $msgInfo);
}
$smarty->display('Settings/DeleteUserStep1.tpl');
?>
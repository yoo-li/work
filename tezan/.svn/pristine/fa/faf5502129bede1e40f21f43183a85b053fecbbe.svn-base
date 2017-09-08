<?php
require_once('Smarty_setup.php');
require_once('include/utils/utils.php');

global  $currentModule,$supplierid;

if (isset($_REQUEST['record']) && $_REQUEST['record'] != "" &&
    isset($_REQUEST['type']) && $_REQUEST['type'] == "submit" )
{
    try {

        if(isset($_REQUEST['actual_amount']) && $_REQUEST['actual_amount'] != "" &&
            isset($_REQUEST['postage_refund']) && $_REQUEST['postage_refund'] != "" ){

            $actual_amount = $_REQUEST['actual_amount'];
            $postage_refund = $_REQUEST['postage_refund'];

            $mall_reimburses = XN_Query::create('YearContent')->tag('mall_reimburses')
                ->filter ( 'type', 'eic', 'mall_reimburses' )
                ->filter ( 'id', '=',$_REQUEST['record'])
                ->execute();
                foreach ($mall_reimburses as $list) {
                    $list->my->actual_amount = $actual_amount;
                    $list->my->postage_refund = $postage_refund;
                    $list->save("mall_reimburses");
                }

        }
			$loadcontents  = XN_Query::create('YearContent')->tag('mall_reimburses')
                ->filter ( 'type', 'eic', 'mall_reimburses' )
                ->filter ( 'id', '=',$_REQUEST['record'])
                ->execute();
        foreach($loadcontents as $reimburses_info)
	        {
				if ($reimburses_info->my->mall_reimbursestatus == "待退款")
				{
                    $supplierid = $reimburses_info->my->supplierid;
					$profileid = $reimburses_info->my->profileid;
					$orderid = $reimburses_info->my->orderid;
					$returnedgoodsapplyid = $reimburses_info->my->returnedgoodsapplyid;
					$reimburses_info->my->mall_reimbursestatus = '已退款';
					$reimburses_info->my->returngoodsdate = date("Y-m-d H:i");
					$reimburses_info->save("mall_reimburses,mall_reimburses_".$profileid.",mall_reimburses_".$supplierid);

					$loadcontent = XN_Content::load($orderid,"mall_orders_".$supplierid,7);
					$loadcontent->my->order_status = '已退款';
					$loadcontent->save("mall_orders,mall_orders_".$profileid.",mall_orders_".$supplierid);

					$returnedgoodsapply = XN_Content::load($returnedgoodsapplyid,"mall_returnedgoodsapplys_".$supplierid,7);
					$returnedgoodsapply->my->mall_returnedgoodsapplysstatus = '已退款';
					$returnedgoodsapply->save("mall_returnedgoodsapplys,mall_returnedgoodsapplys_".$profileid.",mall_returnedgoodsapplys_".$supplierid);

                    $SmkConsumeLogs = XN_Query::create ( 'Content' )->tag('Mall_SmkConsumeLogs')
                        ->filter ( 'type', 'eic', 'Mall_SmkConsumeLogs')
                        ->filter ( 'my.orderid', '=',$orderid)
                        ->end(1)
                        ->execute();
                    if($SmkConsumeLogs){

                    $SmkUsersss = XN_Query::create ( 'Content' )->tag('Mall_SmkUsers')
                        ->filter ( 'type', 'eic', 'Mall_SmkUsers')
                        ->filter ( 'my.profileid', '=',$profileid)
                        ->end(1)
                        ->execute();
                        if($reimburses_info->my->allreturned == 'no' && ($reimburses_info->my->payment  == '商城卡')){
                            $amount = $reimburses_info->my->amountpayable;
                        }else{
                            $amount = $SmkConsumeLogs[0]->my->amount;
                        }
                    foreach ($SmkUsersss as $list) {
                        $list->my->profileid = $profileid; // 用户W
                        $list->my->totle_account = ($list->my->totle_account + $amount);
                        $list->my->totle_refund = ($list->my->totle_refund + $amount);
                        $list->save('Mall_SmkUsers');
                    }
                    $Mall_SmkReimburses = XN_Content::create('Mall_SmkReimburses');
                    $Mall_SmkReimburses->my->profileid = $profileid; // 用户
                    $Mall_SmkReimburses->my->orderid = $orderid;
                    $Mall_SmkReimburses->my->supplierid = $supplierid;
                    $Mall_SmkReimburses->my->amount = $amount;
                    $Mall_SmkReimburses->my->supplierid = $supplierid;
                    $Mall_SmkReimburses->my->deleted = 0;
                    $Mall_SmkReimburses->save('Mall_SmkReimburses');
                    }
//                    echo '{"statusCode":"300","message":"'.$profileid.'"}';die;
                }
	        }
//		}
        echo '{"statusCode":"200","message":null,"tabid":"'.$currentModule.'","closeCurrent":true,"forward":null}';
    } catch ( XN_Exception $e )
    {
        echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
    }
    die();
}
else{
    $binds = $_REQUEST['ids'];
    $binds = str_replace(";",",",$binds);
    $binds = explode(",",trim($binds,','));
    array_unique($binds);
    if (count($binds) > 1)
    {
        $smarty = new vtigerCRM_Smarty;
        global $mod_strings;
        global $app_strings;
        global $app_list_strings;
        $smarty->assign("APP", $app_strings);
        $smarty->assign("CMOD", $mod_strings);
        $msg = '<div style="width:100%;text-align:center;"><br><br><font color="red" size="2">您只能选择单个商品进行退款操作！</font></div>';
        $smarty->assign("MSG", $msg);
        $smarty->display("MessageBox.tpl");
        die();
    }
    $list_result = XN_Query::create('YearContent')->tag('mall_reimburses')
        ->filter ( 'type', 'eic', 'mall_reimburses' )
        ->filter ( 'id', '=',$binds[0])
        ->end(1)
        ->execute();
    $msg .= '<div>实退金额：<input type="text" name="actual_amount" value="'.$list_result[0]->my->actual_amount.'"></div>';
    $msg .= '<div>实退邮费：<input type="text" name="postage_refund"  value="'.$list_result[0]->my->postage_refund.'"></div>';
	$msg .= '<div style="width:100%;text-align:center;"><br><br><font color="red" size="2">你确定款项已经退返给会员？</font></div>';
		
}

$smarty = new vtigerCRM_Smarty;
global $mod_strings;
global $app_strings;
global $app_list_strings;
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->assign("MSG", $msg);
$smarty->assign("OKBUTTON", "确定款项已经退返");
$smarty->assign("RECORD",$_REQUEST['ids']);
$smarty->assign("SUBMODULE", "Mall_Reimburses");
$smarty->assign("SUBACTION", "ModifyReimburse");

$smarty->display("MessageBox.tpl");

?>
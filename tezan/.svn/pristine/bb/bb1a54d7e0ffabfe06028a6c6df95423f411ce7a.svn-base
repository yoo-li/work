<?php
require_once('Smarty_setup.php');
require_once('include/utils/utils.php');
require_once('payment.func.php');


global $currentModule, $supplierid;

if (isset($_REQUEST['record']) && $_REQUEST['record'] != "" &&
    isset($_REQUEST['type']) && $_REQUEST['type'] == "submit" &&
    isset($_REQUEST['payment']) && $_REQUEST['payment'] != ""
)
{
    try
    {
        $binds = $_REQUEST['record'];
        $payment = $_REQUEST['payment'];

        $binds = str_replace(";", ",", $binds);
        $binds = explode(",", trim($binds, ','));
        array_unique($binds);
        if (count($binds) > 0)
        {
            $loadcontents = XN_Content::loadMany($binds, "mall_orders_" . $supplierid, 7);
            foreach ($loadcontents as $order_info)
            {
                $tradestatus = $order_info->my->tradestatus;
                if (isset($tradestatus) && $tradestatus == "pretrade")
                {
                    finished_offline_trade($order_info, $payment);
                }
            }
        }
        echo '{"statusCode":"200","message":null,"tabid":"' . $currentModule . '","closeCurrent":true,"forward":null}';
    }
    catch (XN_Exception $e)
    {
        echo '{"statusCode":"300","message":"' . $e->getMessage() . '"}';
    }
    die();
}
else
{

    $binds = $_REQUEST['ids'];
    $binds = str_replace(";", ",", $binds);
    $binds = explode(",", trim($binds, ','));
    array_unique($binds);
    if (count($binds) > 1)
    {
        $smarty = new vtigerCRM_Smarty;
        global $mod_strings;
        global $app_strings;
        global $app_list_strings;
        $smarty->assign("APP", $app_strings);
        $smarty->assign("CMOD", $mod_strings);
        $msg = '<div style="width:100%;text-align:center;"><br><br><font color="red" size="2">您只能选择单条记录进行线下支付操作！</font></div>';
        $smarty->assign("MSG", $msg);
        $smarty->display("MessageBox.tpl");
        die();
    }
    else
    {
        $record = $_REQUEST['ids'];
        $loadcontent = XN_Content::load($record, "mall_orders_" . $supplierid, 7);
        $tradestatus = $loadcontent->my->tradestatus;
        if (isset($tradestatus) && $tradestatus != "pretrade")
        {
            $smarty = new vtigerCRM_Smarty;
            global $mod_strings;
            global $app_strings;
            global $app_list_strings;
            $smarty->assign("APP", $app_strings);
            $smarty->assign("CMOD", $mod_strings);
            $msg = '<div style="width:100%;text-align:center;"><br><br><font color="red" size="2">只能对“确认下单”的订单进行线下支付操作!</font></div>';
            $smarty->assign("MSG", $msg);
            $smarty->display("MessageBox.tpl");
            die();
        }
    }
    $author = getGivenNamesByids(XN_Profile::$VIEWER);
    $msg = '<div class="form-group">
	                 <label class="control-label x120">操作人:</label>
					 <input style="width:200px;" readonly value="' . $author . '"/>
			 </div> ';
    $msg .= '<div class="form-group">
 	                <label class="control-label x120">支付平台:</label>
 					 <select id="payment" name="payment" style="width:200px;cursor: pointer;"> 
					    <option value="微信转账">微信转账</option>
 						<option value="支付宝转账">支付宝转账</option> 
 						<option value="银行转账">银行转账</option>
 						<option value="现金支付">现金支付</option> 
 					 </select>
 			 </div> ';
}

$smarty = new vtigerCRM_Smarty;
global $mod_strings;
global $app_strings;
global $app_list_strings;
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->assign("MSG", $msg);
$smarty->assign("OKBUTTON", "确定提交");
$smarty->assign("RECORD", $_REQUEST['ids']);
$smarty->assign("SUBMODULE", "Mall_Orders");
$smarty->assign("SUBACTION", "OfflinePayment");

$smarty->display("MessageBox.tpl");

?>
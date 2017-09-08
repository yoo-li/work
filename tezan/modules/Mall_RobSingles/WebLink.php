<?php
require_once('Smarty_setup.php');
require_once('include/utils/utils.php');

global $supplierid, $businesseid, $localusertype;
global $currentModule;


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
    $msg = '<div style="width:100%;text-align:center;"><br><br><font color="red" size="2">您只能选择单条记录进行修改！</font></div>';
    $smarty->assign("MSG", $msg);
    $smarty->display("MessageBox.tpl");
    die();
}
else
{
    $productid = $_REQUEST['ids'];
    $request_uri = 'products_rob.php?salesactivityid='.$productid;
    $url = "http://f2c.ttzan.cn/home.php?sid=" . $supplierid . "&uri=" . base64_encode($request_uri);
    
	$msg = '<div class="form-group"><label class="control-label x120">活动推文链接：</label>
		  <input type="text" style="width:320px;" class="input required  textInput" value="' . $url . '"  maxlength="100" >';
    $msg .= '</div>';
 
    $msg .= '<div style="width:100%;text-align:center;"><br><br><font color="red" size="2">此链接可以嵌入到推文中，会员点击进入后可以直接下单！</font></div>';


    $script = '
		function onchange_salesactivity(uri)
		{
			$("#salesactivitylink").val(uri);
		}';
    $smarty = new vtigerCRM_Smarty;
    global $mod_strings;
    global $app_strings;
    global $app_list_strings;
    $smarty->assign("APP", $app_strings);
    $smarty->assign("CMOD", $mod_strings);
    $smarty->assign("MSG", $msg);
    $smarty->assign("SCRIPT", $script);

    $smarty->display("MessageBox.tpl");
}


?>
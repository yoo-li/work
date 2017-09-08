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
    $url = "http://f2c.tezan.cn/home.php?sid=" . $supplierid . "&pid=" . $productid;
    $msg = '<div class="form-group"><label class="control-label x120">商品推文链接：</label>
		  <input type="text" style="width:320px;" class="input required  textInput" value="' . $url . '"  maxlength="100" >';
    $msg .= '</div>';

    $mall_salesactivitys = XN_Query::create('Content')->tag('mall_salesactivitys_' . $supplierid)
        ->filter('type', 'eic', 'mall_salesactivitys')
        ->filter('my.deleted', '=', '0')
        ->filter('my.supplierid', '=', $supplierid)
        ->filter('my.approvalstatus', '=', '2')
        ->filter('my.status', '=', '0')
        ->order("my.sequence", XN_Order::DESC_NUMBER)
        ->end(-1)
        ->execute();

    $salesactivitylist = array();
    if (count($mall_salesactivitys) > 0)
    {
        $msg .= '<div class="form-group"><label class="control-label x120">促销活动：</label>
		     <select id="salesactivity" onchange="onchange_salesactivity(this.value);" style="width:200px;cursor: pointer;">';
        $msg .= '<option value=""></option>';
	    foreach ($mall_salesactivitys as $mall_salesactivity_info)
        {
            $id = $mall_salesactivity_info->id;
            $activityname = $mall_salesactivity_info->my->activityname;
            $request_uri = 'detail.php?from=salesactivity&productid='.$productid.'&salesactivityid='.$id;
            $weblink = "http://f2c.tezan.cn/home.php?sid=" . $supplierid . "&uri=" . base64_encode($request_uri);
			
            $msg .= '<option value="'.$weblink.'">'.$activityname.'</option>';
        }
        $msg .= '</select></div>'; 
        $msg .= '<div class="form-group"><label class="control-label x120">活动推文链接：</label>
		  <input type="text" style="width:320px;" class="input required  textInput" value="" id="salesactivitylink" >';
        $msg .= '</div>';
    }


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
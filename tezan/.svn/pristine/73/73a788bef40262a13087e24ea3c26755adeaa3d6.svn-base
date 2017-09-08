<?php

global $currentModule;
if (isset($_REQUEST['record']) && $_REQUEST['record'] != "" &&
    isset($_REQUEST['type']) && $_REQUEST['type'] == "submit"
)
{

    if (isset($_REQUEST['reason']) && $_REQUEST['reason'] != "")
    {
        $ids = $_REQUEST['record'];
        $ids = explode(",", trim($ids, ','));
        array_unique($ids);
        $ids = array_filter($ids);
        $reason = $_REQUEST['reason'];
        try
        {
            require_once(XN_INCLUDE_PREFIX . "/XN/Message.php");
            foreach ($ids as $profileid)
            {
                XN_Message::sendmessage($profileid, $_REQUEST['reason']);
            }
        }
        catch (XN_Exception $e)
        {
            echo '{"statusCode":"300","message":"' . $e->getMessage() . '"}';
            die();
        }
    }
    echo '{"statusCode":"200","message":"发送成功!","tabid":"' . $currentModule . '","closeCurrent":"true"}';
    die();
}



if (isset($_REQUEST['ids']) && $_REQUEST['ids'] != "")
{
    $ids = $_REQUEST['ids'];
    $author = getGivenNamesByids(XN_Profile::$VIEWER);
    if (isset($_REQUEST['ope']) && $_REQUEST['ope'] == "reason")
    {

        $msg = '<div class="form-group" style="margin: 20px 0 20px; ">
               <label class="control-label x85">操作人：</label>
                <input style="width:200px;" readonly value="' . $author . '"/>
               </div>';
        $msg .= '<div class="form-group" style="margin: 20px 0 20px; ">
               <label class="control-label x85">消息内容：</label>
               <textarea data-rule="required" style="width:200px;height:100px;" name="reason" class="required"/></textarea>
               </div>';
        require_once('Smarty_setup.php');
        require_once('include/utils/utils.php');
        $smarty = new vtigerCRM_Smarty;
        global $mod_strings;
        global $app_strings;
        global $app_list_strings;
        $smarty->assign("APP", $app_strings);
        $smarty->assign("CMOD", $mod_strings);
        $smarty->assign("MSG", $msg);
        $smarty->assign("OKBUTTON", "确定发送");
        $smarty->assign("RECORD", $_REQUEST['ids']);
        $smarty->assign("SUBMODULE", $currentModule);
        $smarty->assign("SUBACTION", basename(__FILE__, ".php"));

        $smarty->display("MessageBox.tpl");
        die();
    }

}
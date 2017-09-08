<?php
require_once('Smarty_setup.php');
global $currentModule;
if(isset($_REQUEST['type']) && $_REQUEST['type'] == "submit"){
        $ids = $_REQUEST['record'];
        $ids = explode(",",trim($ids,','));
        array_unique($ids);
        $ids = array_filter($ids);
        $list_result = XN_Content::loadMany($ids,strtolower($currentModule));
        foreach($list_result as $info){
            $info->my->warnline = $_REQUEST['warnline'];
            $info->save(strtolower($currentModule));
        }
        echo '{"statusCode":"200","message":null,"tabid":"'.$currentModule.'","closeCurrent":true,"forward":null}';
        die();
}else{
    $smarty = new vtigerCRM_Smarty;
    $msg= '
        <div class="form-group" style="width:98%;margin:3px 0px;float:left;">
		    <label class="control-label x100">库存警戒线:</label>
            <input name="warnline" class="form-control" type="text" data-rule="digits;required;" value="">
        </div>
    ';
    $smarty->assign("MSG", $msg);
    $smarty->assign("OKBUTTON", "确定");
    $smarty->assign("RECORD",$_REQUEST['ids']);
    $smarty->assign("SUBMODULE", $currentModule);
    $smarty->assign("SUBACTION", $_REQUEST['action']);
    $smarty->display("MessageBox.tpl");
}


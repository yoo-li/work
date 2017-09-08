<?php
require_once('Smarty_setup.php');
require_once('include/utils/utils.php');
global $currentModule;
if (isset($_REQUEST['record']) && $_REQUEST['record'] != ""&&
    isset($_REQUEST['type']) && $_REQUEST['type'] == "submit") {
    $ids = $_REQUEST['record'];
    $ids = explode(",",trim($ids,','));
    array_unique($ids);
    $ids = array_filter($ids);

    try{
        $supplier_profile  = XN_Content::load($ids,"supplier_profile",4);
        foreach($supplier_profile as $supplier_profile_info)
        {
            $profileid = $supplier_profile_info->my->profileid;
            $supplierid = $supplier_profile_info->my->supplierid;
            $frozenlists = XN_Query::create ( 'MainContent' )->tag('supplier_frozenlists')
                ->filter ( 'type', 'eic', 'supplier_frozenlists')
                ->filter ( 'my.profileid', '=', $profileid)
                ->filter ( 'my.supplierid', '=', $supplierid)
                ->filter ( 'my.frozenliststatus', '=', 'Frozen')
                ->end(-1)
                ->execute ();
            if (count($frozenlists)  > 0)
            {
                echo '{"statusCode":"300","message":"当前用户已经加入了冻结名单！"}';
                die();
            }
            $newcontent=XN_Content::create('supplier_frozenlists',"",false,4);
            $newcontent->my->deleted = '0';
            $newcontent->my->supplierid=$supplierid;
            $newcontent->my->profileid=$profileid;
            $newcontent->my->reason=$_REQUEST['reason'];
            $newcontent->my->execute="";
            $newcontent->my->handle_reason="";
            $newcontent->my->frozenliststatus='Frozen';
            $newcontent->save("supplier_frozenlists,supplier_frozenlists_".$profileid.",supplier_frozenlists_".$supplierid);

        }
    }
    catch(XN_Exception $e){
        echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
        die();
    }
    echo '{"statusCode":"200","message":null,"tabid":"'.$currentModule.'","closeCurrent":"true","forward":null}';

}
else
{
    $smarty = new vtigerCRM_Smarty;
    $author = getGivenNamesByids(XN_Profile::$VIEWER);
    $msg= '
            <div class="form-group" style="width:98%;margin:3px 0px;float:left;">
				<label class="control-label x100">操作人：</label>
				<input style="width:200px;" readonly class="form-control" value="'.$author.'">
			</div>
			<div class="form-group" style="width:98%;margin:3px 0px;float:left;">
				<label class="control-label x100">原因：</label>
				<textarea style="width:200px;height:100px;" class="form-control" name="reason" data-rule="required"/></textarea>
			</div>
        ';
    $smarty->assign("MSG", $msg);
    $smarty->assign("SUBMODULE", $currentModule);
    $smarty->assign("SUBACTION", $_REQUEST['action']);
    $smarty->assign("OKBUTTON", "确认");
    $smarty->assign("CANCELBUTTON", "关闭");
    $smarty->assign("RECORD", $_REQUEST['ids']);
    $smarty->display('MessageBox.tpl');
}
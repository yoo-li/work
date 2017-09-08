<?php
require_once('Smarty_setup.php');
require_once('include/utils/utils.php');
require_once('modules/Suppliers/config.func.php');

global  $currentModule;
$query = XN_Query::create ( 'Content' ) ->tag('suppliers')
    ->filter ( 'type', 'eic', 'suppliers')
    ->filter ( 'my.deleted', '=', '0' )
    ->filter ( 'my.pers', '=' ,XN_Profile::$VIEWER)
    ->execute();
if(count($query)){
    $suppliers=$query[0]->id;
}

if (isset($_REQUEST['record']) && $_REQUEST['record'] != "" &&
    isset($_REQUEST['type']) && $_REQUEST['type'] == "submit")
{
    try {
        $record=$_REQUEST['record'];
        $supplierlogisticinfos=XN_Query::create("Content")
            ->filter('type','eic','supplierlogisticinfo')
            ->filter ( 'my.deleted', '=', '0' )
            ->filter('my.logistics',"=",$record)
            ->filter ( 'my.suppliers', '=',$suppliers)
            ->execute();
        if(count($supplierlogisticinfos)>0){
            $loadContent=$supplierlogisticinfos[0];
            $loadContent->my->ispass=$_REQUEST['ispass'];
            $loadContent->my->custid=$_REQUEST['custid'];
            $loadContent->my->checkname=$_REQUEST['checkname'];
            $loadContent->my->checkword=$_REQUEST['checkword'];
            $loadContent->save("supplierlogisticinfo");
        }else{
            $loadContent=XN_Content::create("supplierlogisticinfo","",false);
            $loadContent->my->deleted='0';
            $loadContent->my->suppliers=$suppliers;
            $loadContent->my->ispass=$_REQUEST['ispass'];
            $loadContent->my->logistics=$_REQUEST['record'];
            $loadContent->my->custid=$_REQUEST['custid'];
            $loadContent->my->checkname=$_REQUEST['checkname'];
            $loadContent->my->checkword=$_REQUEST['checkword'];
            $loadContent->save("supplierlogisticinfo");
        }
    }
    catch(XN_Exception $e){
        echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
        die();
    }
    echo '{"statusCode":"200","message":null,"tabid":"'.$currentModule.'","closeCurrent":true,"forward":null}';
    die();
}
else{
    $record=$_REQUEST['record'];
    $infos=XN_Query::create("Content")
        ->filter('type','eic','supplierlogisticinfo')
        ->filter ( 'my.deleted', '=', '0' )
        ->filter ( 'my.logistics', '=', $record)
        ->filter ( 'my.suppliers', '=',$suppliers)
        ->end(1)
        ->execute();
    if(count($infos)){
        $info=$infos[0];
        $ispass=$info->my->ispass;
        $custid=$info->my->custid;
        $checkname=$info->my->checkname;
        $checkword=$info->my->checkword;
    }
    $msg='
        <div><label>是否启用:</label>';
    if($ispass=='1'){
        $msg.= '
            <input type="radio" name="ispass" value="1" checked />启用
            <input type="radio" name="ispass" value="0" />关闭
            </div></br>';
    }
    else{
        $msg.= '
            <input type="radio" name="ispass" value="1" />启用
            <input type="radio" name="ispass" value="0" checked />关闭
            </div></br>';
    }
    $msg.= '
    <div><label>月结卡号:</label><input name="custid" value="'.$custid.'" class="required"></div><BR>
    <div><label>客户编码:</label><input name="checkname" value="'.$checkname.'" class="required"></div><BR>
    <div><label>物流密钥:</label><input name="checkword" value="'.$checkword.'" class="required"></div>';

    $smarty = new vtigerCRM_Smarty;
    global $mod_strings;
    global $app_strings;
    global $app_list_strings;
    $smarty->assign("APP", $app_strings);
    $smarty->assign("CMOD", $mod_strings);
    $smarty->assign("MSG", $msg);
    $smarty->assign("OKBUTTON", "确定");
    $smarty->assign("RECORD",$record);
    $smarty->assign("SUBMODULE", "Logistics");
    $smarty->assign("SUBACTION", "supplierLogisticInfo");

    $smarty->display("MessageBox.tpl");
}



?>
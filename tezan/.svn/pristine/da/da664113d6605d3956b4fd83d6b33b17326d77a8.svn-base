<?php
require_once('Smarty_setup.php');
require_once('include/utils/utils.php');


global  $currentModule;

if (isset($_REQUEST['record']) && $_REQUEST['record'] != "" &&
    isset($_REQUEST['type']) && $_REQUEST['type'] == "submit")
{
    try {
        $binds = $_REQUEST['record'];
        $run_type = $_REQUEST['run_type'];
		
        $binds = str_replace(";",",",$binds);
        $binds = explode(",",trim($binds,','));
        array_unique($binds);
		
		$contents=XN_Content::loadMany($binds,strtolower($currentModule));
		
        foreach($contents as $content)
        {
            $content->my->run_type = $run_type; 
        }
		XN_Content::batchsave($contents,strtolower($currentModule));
        echo '{"statusCode":"200","message":null,"tabid":"'.$currentModule.'","closeCurrent":"true"}';
    } catch ( XN_Exception $e )
    {
        echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
    }
    die();
}
else{
    require_once 'modules/PickList/PickListUtils.php';
    $picklistValues = getAssignedPicklistValues("run_type");
    $ids=$_REQUEST["ids"];
	$msg='<div class="form-group" style="margin: 20px 0 20px; ">
            <label class="control-label x85">商户类别：</label>';
			/*
    foreach($picklistValues as $key=>$value){
        $msg.='<span class="left" style="padding-right: 8px;">
                    <input style="cursor: pointer;margin-top: 5px;"  type="radio" value="'.$key.'"  name="run_type"  id="run_type_'.$key.'">
                    <label style="cursor: pointer;width:auto;padding: 0;" for="run_type_'.$key.'">
                        '.$value.'
                    </label>
                </span>
        ';
    }
	*/
	$msg.='<select name="run_type" data-toggle="selectpicker" data-width="200">';
	foreach($picklistValues as $key=>$value){
        $msg.='<option  value="'.$key.'">'.$value.'</option>';
    }
	$msg.='</select>';
    $msg.='</div>';
}

$smarty = new vtigerCRM_Smarty;
global $mod_strings;
global $app_strings;
global $app_list_strings;
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->assign("MSG", $msg);
$smarty->assign("OKBUTTON", "确定");
$smarty->assign("RECORD",$_REQUEST['ids']);
$smarty->assign("SUBMODULE", "Suppliers");
$smarty->assign("SUBACTION", "changeRuntype");

$smarty->display("MessageBox.tpl");

?>
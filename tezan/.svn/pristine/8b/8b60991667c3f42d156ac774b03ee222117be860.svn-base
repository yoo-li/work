<?php
require_once('Smarty_setup.php');
require_once('include/utils/utils.php');


global  $currentModule,$supplierid;

if (isset($_REQUEST['record']) && $_REQUEST['record'] != "" &&
    isset($_REQUEST['type']) && $_REQUEST['type'] == "submit" &&
	isset($_REQUEST['logisticpackage']) && $_REQUEST['logisticpackage'] != "")
{
    try {
        $binds = $_REQUEST['record'];
        $logisticpackage= $_REQUEST['logisticpackage'];

        $binds = str_replace(";",",",$binds);
        $binds = explode(",",trim($binds,','));
        array_unique($binds);
		if (count($binds) > 0)
		{
			$loadcontents = XN_Content::loadMany($binds,"mall_logisticbills_".$supplierid,7);
	        foreach($loadcontents as $logisticbill_info)
	        {   
				if ($logisticbill_info->my->mall_logisticbillsstatus == "JustCreated")
				{
					if ($logisticbill_info->my->logisticpackageid != $logisticpackage)
					{
						$logisticbill_info->my->logisticpackageid = $logisticpackage;
						$logisticbill_info->save(strtolower($currentModule).",".strtolower($currentModule)."_".$supplierid);
					} 
				} 
	        }  
		} 
        echo '{"statusCode":"200","message":null,"tabid":"'.$currentModule.'","closeCurrent":true,"forward":null}';
    } catch ( XN_Exception $e )
    {
        echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
    }
    die();
}
else{ 
    $mall_logisticpackages = XN_Query::create ( 'Content' )->tag('mall_logisticpackages_'.$supplierid)
	    ->filter ( 'type', 'eic', 'mall_logisticpackages') 
	    ->filter('my.deleted','=','0')
		->filter('my.status','=','0')  
	    ->end(-1)
	    ->execute(); 
    $logisticpackageoption = "";
    foreach ($mall_logisticpackages as $logisticpackage_info)
	{ 
		$logisticpackageoption .= '<option value='.$logisticpackage_info->id.'>'.$logisticpackage_info->my->serialname.'</option>';
    }
	$msg =  '<div class="form-group">
	                <label class="control-label x120">选择路线:</label>
					 <select id="logisticpackage" name="logisticpackage" style="width:200px;cursor: pointer;">'.$logisticpackageoption.'</select>
			 </div> ';
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
$smarty->assign("SUBMODULE", "Mall_LogisticBills");
$smarty->assign("SUBACTION", "ModifyLogisticPackage");

$smarty->display("MessageBox.tpl");

?>
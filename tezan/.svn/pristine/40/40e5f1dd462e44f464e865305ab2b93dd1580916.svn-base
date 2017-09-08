<?php
require_once('Smarty_setup.php');
global $currentModule,$supplierid;

if(isset($_REQUEST['type']) && $_REQUEST['type'] == "submit"){
	$ids = $_REQUEST['record'];
	$ids = explode(",",trim($ids,','));
	array_unique($ids);
	$ids = array_filter($ids);
	$list_result = XN_Content::loadMany($ids,strtolower($currentModule));
	foreach($list_result as $info){
		$oldinventory = intval($info->my->inventory);
		$newinventory = intval($_REQUEST['inventorys']);
		if ($oldinventory != $newinventory)
		{
			if ($newinventory > $oldinventory)
			{
				$amount = '+'.($newinventory - $oldinventory);
			}
			else
			{
				$amount = '-'.($oldinventory - $newinventory);
			}

			$brand = XN_Content::create('mall_turnovers',"",false,7);
			$brand->my->supplierid = $info->my->supplierid;
			$brand->my->deleted = '0';
			$brand->my->productid = $info->my->productid;
			$brand->my->productname = $info->my->productname;
			$brand->my->propertyid = $info->my->propertytypeid;
			$brand->my->propertydesc = $info->my->propertytype;
			$brand->my->mall_turnoversstatus = '估清';
			$brand->my->oldinventory = $oldinventory;
			$brand->my->amount = $amount;
			$brand->my->newinventory = $newinventory;
			$brand->save('mall_turnovers,mall_turnovers_'.$info->my->supplierid);


			$info->my->inventory = $newinventory;
			$info->save('mall_inventorys,mall_inventorys_'.$info->my->supplierid);
		}


	}
	echo '{"statusCode":"200","message":null,"tabid":"'.$currentModule.'","closeCurrent":true,"forward":null}';
	die();
}
else{
	$smarty = new vtigerCRM_Smarty;
	$msg='
		<div class="form-group" style="width:98%;margin:3px 0px;float:left;">
		    <label class="control-label x100">估清数量:</label>
            <input name="inventorys" class="form-control" type="text" data-rule="digits;required;" value="'.$sequence.'">
        </div>
	';
	$smarty->assign("MSG", $msg);
	$smarty->assign("OKBUTTON", "确认估清");
	$smarty->assign("RECORD",$_REQUEST['ids']);
	$smarty->assign("SUBMODULE", $currentModule);
	$smarty->assign("SUBACTION", $_REQUEST['action']);
	$smarty->display("MessageBox.tpl");

}


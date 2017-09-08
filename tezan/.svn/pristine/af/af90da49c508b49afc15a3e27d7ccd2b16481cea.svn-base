<?php
global  $currentModule,$app_strings,$mod_strings;
$author=getGivenNamesByids(XN_Profile::$VIEWER);
if(isset($_REQUEST['type']) &&$_REQUEST['type']=="submit"){
	$record=$_REQUEST['record'];
	$ids = explode(",",trim($record,','));
	array_unique($ids);
	$ids = array_filter($ids);
	try{
		if (count($ids) > 0)
		{
			$frozenlists = XN_Content::loadMany($ids,"supplier_frozenlists",4);
			if (count($frozenlists)  > 0)
			{
				foreach ($frozenlists as $frozenlist_info)
				{
					if ($frozenlist_info->my->frozenliststatus == 'Frozen')
					{
						$profileid =  $frozenlist_info->my->profileid;
						$supplierid =  $frozenlist_info->my->supplierid;
						$frozenlist_info->my->execute=XN_Profile::$VIEWER;
						$frozenlist_info->my->handle_reason=$_REQUEST['reason'];
						$frozenlist_info->my->frozenliststatus='UnFrozen';
						$frozenlist_info->my->executedatetime = date("Y-m-d H:i:s");
						$frozenlist_info->save("supplier_frozenlists,supplier_frozenlists_".$profileid.",supplier_frozenlists_".$supplierid);
					}
				}
			}
		}
	}
	catch(XN_Exception $e){
		echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
		die();
	}
	echo '{"statusCode":"200","message":null,"tabid":"'.$currentModule.'","closeCurrent":"true"}';
	die();
}
else
{
	$ids = $_REQUEST['ids'];
	$html= '
		<div class="form-group" style="width:98%;margin:3px 0px;float:left;">
			<label class="control-label x150">操作人：</label>
			<input class="form-control" type="text" readonly="" value="'.$author.'">
		</div>
		<div class="form-group" style="width:98%;margin:3px 0px;float:left;">
			<label class="control-label x150">解冻理由：</label>
			<textarea class="form-control" style="width:200px;height:100px;" name="reason" class="required"/></textarea>
		</div>
		';

	require_once('Smarty_setup.php');
	require_once('include/utils/utils.php');

	$smarty = new vtigerCRM_Smarty;
	$smarty->assign("APP", $app_strings);
	$smarty->assign("CMOD", $mod_strings);
	$smarty->assign("MSG", $html);

	$smarty->assign("RECORD", $ids);
	$smarty->assign("SUBMODULE", $currentModule);
	$smarty->assign("SUBACTION", $_REQUEST['action']);
	$smarty->assign("OKBUTTON", "确认");
	$smarty->display("MessageBox.tpl");

}

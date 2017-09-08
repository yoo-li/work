<?php
	require_once('Smarty_setup.php');
	require_once('include/utils/utils.php');
	global $mod_strings,$app_strings,$theme,$currentModule,$current_user,$supplierid;

	if (isset($_REQUEST['record']) && $_REQUEST['record'] != "" &&
		isset($_REQUEST['type']) && $_REQUEST['type'] == "submit" )
	{
		try {
			$record = $_REQUEST['record'];

			$loadcontent = XN_Content::load($record,strtolower($currentModule));
			$loadcontent->my->productscount = "0";
			$loadcontent->save(strtolower($currentModule));
			$checkorders = XN_Query::create("Content")->tag("ma_inventorywarndetails")->end(-1)
							   ->filter('type', 'eic', 'ma_inventorywarndetails')
							   ->filter('my.record', '=', $record)
							   ->filter('my.deleted', '=','0')
							   ->execute();
			foreach(array_chunk($checkorders,50,true) as $chunk)
			{
				XN_Content::delete($chunk,"ma_inventorywarndetails");
			}
			echo '{"status":"1","statusCode":200,"message":"清除完成","tabid":"edit","closeCurrent":"false","forward":null}';
		}
		catch ( XN_Exception $e )
		{
			echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
		}
		die();
	}


	$smarty = new vtigerCRM_Smarty;

	$smarty->assign("MODULE",$currentModule);
	$smarty->assign("APP",$app_strings);
	$smarty->assign("MOD", $mod_strings);

	if(isset($_REQUEST['record']) && $_REQUEST['record'] !='')
	{
		$record=$_REQUEST['record'];
		$msg .= '<div style="width:100%"><font color="red" size="2">此操作将清空当前所有策略详请,确定?</font></div>';

		$smarty->assign("MSG", $msg);
		$smarty->assign("SUBMODULE", $currentModule);
		$smarty->assign("SUBACTION", $_REQUEST['action']);
		$smarty->assign("OKBUTTON", "确定");
		$smarty->assign("RECORD", $record);
	}

	$smarty->display('MessageBox.tpl');


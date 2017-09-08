<?php

if(isset($_REQUEST['record']) && $_REQUEST['record'] !='' && 
   isset($_REQUEST['submodule']) && $_REQUEST['submodule'] !='' &&
   isset($_REQUEST['type']) && $_REQUEST['type'] =='submit')
{
	$submodule = $_REQUEST['submodule'];
	$record = $_REQUEST['record'];

	try
	{
		$loadcontent = XN_Content::load($record,strtolower($submodule));
		$status = strtolower($submodule) . 'status';
		$loadcontent->my->$status = "Has been executed";
		$loadcontent->my->enddate = date("Y-m-d H:i:s");
		$published = $loadcontent->published;
		$supplierid = $loadcontent->my->supplierid; 
		$swaptime = strtotime("now") - strtotime($published);
		$loadcontent->my->swaptime = $swaptime;	
		if (isset($supplierid) && $supplierid != "")
		{
			$loadcontent->save(strtolower($submodule).','.strtolower($submodule).'_'.$supplierid);
		}	
		else
		{
			$loadcontent->save(strtolower($submodule));
		}
		

		$newcontent = XN_Content::create('memo', '', false);
		$newcontent->my->deleted = '0';
		
		$newcontent->my->memo = date("Y-m-d H:i") . ' 将状态转换为执行完成！';
		$newcontent->my->record = $record;
		$newcontent->my->module = 'Calendar';
		$newcontent->save('memo');
	}
	catch (XN_Exception $e)
	{

	}

	echo '{"status":1,"statusCode":200,"message":null,"tabid":"edit","closeCurrent":"true","forward":null}';

	die();
}




global $mod_strings,$app_strings,$currentModule,$current_user;

require_once('Smarty_setup.php');
require_once('include/utils/utils.php');

$smarty = new vtigerCRM_Smarty;

$smarty->assign("MODULE",$currentModule);
$smarty->assign("APP",$app_strings);
$smarty->assign("MOD", $mod_strings);

$msg =  '';


if(isset($_REQUEST['record']) && $_REQUEST['record'] !='' && isset($_REQUEST['submodule']) && $_REQUEST['submodule'] !='') 
{
		$recordid = $_REQUEST['record'];
		$submodule = $_REQUEST['submodule'];

	    $smarty->assign("ID", $recordid);
	
		try{
		  			     
				$author = $loadcontent->author;
				$authorname = getUserNameByProfile($author);
				$msg = '<div><font color="red"><b>当前执行状态为执行中，执行完成将状态转换成执行完成!<br>您是否确认?</b></font></div>';			
				$msg .= '<input type="hidden" name="submodule" value="'.$submodule.'">';
				$smarty->assign("MSG", $msg);
				$smarty->assign("RECORD", $recordid);
				$smarty->assign("SUBMODULE", $currentModule);
				$smarty->assign("OKBUTTON", "执行完成");
				$smarty->assign("SUBACTION", "Executed");

		} catch ( XN_Exception $e ) {}	
		
		$smarty->assign("CANCELBUTTON", getTranslatedString('LBL_CANCEL_BUTTON_LABEL'));
}



$smarty->display('MessageBox.tpl');


?>
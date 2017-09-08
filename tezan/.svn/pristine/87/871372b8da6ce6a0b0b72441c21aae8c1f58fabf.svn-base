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
		$loadcontent->my->$status = "Archive";
		$loadcontent->save(strtolower($submodule));

		$newcontent = XN_Content::create('memo', '', false);
		$newcontent->my->deleted = '0';
		$newcontent->my->memo = date("Y-m-d H:i") . ' 存档完成！';
		$newcontent->my->record = $record;
		$newcontent->my->module = $submodule;
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
		    $loadcontent = XN_Content::load($recordid,strtolower($submodule));
			$approvalstatus = $loadcontent->my->approvalstatus;
			if ( $approvalstatus == '2')
			{				     
				$author = $loadcontent->author;
				$authorname = getUserNameByProfile($author);
				$msg = '<div><font color="red"><b>存档表示当前文档所有的操作全部完成!<br>您是否确认存档?</b></font></div>';				
				$msg .= '<input type="hidden" name="submodule" value="'.$submodule.'">';
				$smarty->assign("MSG", $msg);
				$smarty->assign("RECORD", $recordid);
				$smarty->assign("SUBMODULE", "Public");
				$smarty->assign("OKBUTTON", "确认存档");
				$smarty->assign("SUBACTION", "Archive");
			}
			elseif ( is_null($approvalstatus))
			{
				$author = $loadcontent->author;
				$authorname = getUserNameByProfile($author);
				$msg = '<div><font color="red"><b>存档表示当前文档所有的操作全部完成!<br>您是否确认存档?</b></font></div>';				
				$msg .= '<input type="hidden" name="submodule" value="'.$submodule.'">';
				$smarty->assign("MSG", $msg);
				$smarty->assign("RECORD", $recordid);
				$smarty->assign("SUBMODULE", "Public");
				$smarty->assign("OKBUTTON", "确认存档");
				$smarty->assign("SUBACTION", "Archive");			
			}

		} catch ( XN_Exception $e ) {}	

}



$smarty->display('MessageBox.tpl');


?>
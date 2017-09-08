<?php


function terminate_approval($record) 
{	
			$approvals = XN_Query::create ( 'Content' )
								->tag ( 'approvals' )
								->filter ( 'type', 'eic', 'approvals' )
								->filter ( 'my.record', '=', $record )
								->filter ( 'my.finished', '=', 'false' )
								->filter ( 'my.deleted', '=', '0' )
								->execute ();
							
			if (count($approvals) > 0)
			{		
				foreach ($approvals as $approval_info)
				{
					$tabid = $approval_info->my->tabid;
					$userid = $approval_info->my->userid;
					$from_userid = $approval_info->my->from_userid;
					$record =  $approval_info->my->record;				
					$approval_info->my->finished = 'true';
					$approval_info->my->reply_text = getTranslatedFormatString('LBL_TERMINATE_APPROVAL');
					$approval_info->my->reply = 'Disagree';
					$approval_info->my->approver = XN_Profile::$VIEWER;
					$approval_info->my->submitapprovalreplydatetime =  date("Y-m-d H:i:s");
					$approval_info->save('approvals');
				}

			}

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
		if(isset($_REQUEST['terminate']) && $_REQUEST['terminate'] !='' && isset($_REQUEST['type']) && $_REQUEST['type'] =='submit') 
		{
			$key = strtolower($submodule).'status';
			$loadcontent = XN_Content::load($recordid,strtolower($submodule));
			$loadcontent->my->$key = 'Terminate';
			$loadcontent->my->terminate = $_REQUEST['terminate'];
			$loadcontent->my->submitterminatedatetime = date("Y-m-d H:i");
			$loadcontent->my->submitterminateprofile = XN_Profile::$VIEWER;
			$loadcontent->my->submitterminateusername = $current_user->last_name;
			$loadcontent->save($submodule);

			$newcontent = XN_Content::create('memo', '', false);
			$newcontent->my->deleted = '0';
			$newcontent->my->memo = date("Y-m-d H:i") . ' 终止！';
			$newcontent->my->record = $record;
			$newcontent->my->module = $submodule;
			$newcontent->save('memo');

			terminate_approval($recordid);
			echo '{"status":1,"statusCode":200,"message":null,"tabid":"edit","closeCurrent":"true","forward":null}';
			die();				
		}

		
	    $smarty->assign("ID", $recordid);
	
		try{
		    $loadcontent = XN_Content::load($recordid,strtolower($submodule));
			$key = strtolower($submodule).'status';
			$status = $loadcontent->my->$key;
			if ( $status == 'Terminate')
			{
				
				$msg = '<div class="form-group">
					            <label class="control-label x85">终止操作人：</label>
					            <input type="text" disabled  value="'.$loadcontent->my->submitterminateusername.'"></div>';
				$msg .= '<div class="form-group">
					            <label class="control-label x85">终止时间：</label>
					            <input type="text" disabled  value="'.$loadcontent->my->submitterminatedatetime.'"></div>';
				$msg .= '<div class="form-group">
					            <label class="control-label x85">终止原因：</label>
					            <textarea style="width:71%;height:120px;" disabled >'.$loadcontent->my->terminate.'"</textarea></div>';
				$msg .= '<div class="form-group">
					            <label class="control-label x85">&nbsp;</label>
					            <font color="red"><b>已经终止！</b></font></div>'; 
				 
				$smarty->assign("MSG", $msg); 
			}
			else
			{          
				$msg = '<div class="form-group">
					            <label class="control-label x85">终止原因：</label>
					            <textarea  data-rule="required;" style="width:65%;height:120px;" id="terminate" name="terminate" class="required" placeholder="请输入终止原因"  ></textarea></div>';
				$msg .= '<div class="form-group">
					            <label class="control-label x85">&nbsp;</label>
					            <font color="red"><b>您确定需要终止！</b></font></div>';  		
				$msg .= '<input type="hidden" name="submodule" value="'.$submodule.'">';
								
				 
				$smarty->assign("MSG", $msg);
				$smarty->assign("OKBUTTON", getTranslatedString('Terminate',$submodule));
				$smarty->assign("RECORD", $recordid);
				$smarty->assign("SUBMODULE", "Public");
				$smarty->assign("OKBUTTON", "终止");
				$smarty->assign("SUBACTION", "Terminate");
			}

		} catch ( XN_Exception $e ) {}	
		
		$smarty->assign("CANCELBUTTON", getTranslatedString('LBL_CANCEL_BUTTON_LABEL'));
}



$smarty->display('MessageBox.tpl');
?>
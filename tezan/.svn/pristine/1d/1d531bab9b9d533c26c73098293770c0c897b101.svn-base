<?php
require_once('Smarty_setup.php');
global  $currentModule,$supplierid;

if(isset($_REQUEST['type']) && $_REQUEST['type'] == "submit")
{ 
	if (isset($_REQUEST['record']) && $_REQUEST['record'] != '' &&  
		isset($_REQUEST['reply']) && $_REQUEST['reply'] != '')
	{
		$binds = $_REQUEST['record']; 
		$binds = str_replace(";",",",$binds);
		$binds = explode(",",trim($binds,','));
		array_unique($binds); 
		$approvalcenters =  XN_Content::loadMany($binds,"approvalcenters");
		foreach($approvalcenters as $approvalcenter_info)
		{
			$pendingapprover = $approvalcenter_info->my->pendingapprover;
			if (!in_array(XN_Profile::$VIEWER,(array)$pendingapprover))
			{
				echo '{"statusCode":"300","message":"您只能对待审的记录进行批量审批！","forward":null}';
				die(); 
			}
		} 
	
	    $reply = $_REQUEST ['reply'];
	    $reply_text = $_REQUEST ['reply_text'];
		
		require_once('modules/Approvals/config.func.php');
		
		global $copyrights,$supplierid; 
		if(isset($_SESSION['supplierid']) && $_SESSION['supplierid'] !='')
		{ 
			$supplierid = $_SESSION['supplierid']; 
		} 
		
		foreach($approvalcenters as $approvalcenter_info)
		{
			try
	        { 
					$record = $approvalcenter_info->my->record;
					$tabid = $approvalcenter_info->my->tabid;
					
				    $approvals = XN_Query::create('Content')->tag("approvals")
				        ->filter('type', 'eic', "approvals")
						->filter("my.record", '=', $record)
						->filter("my.tabid", '=', $tabid)
						->filter("my.userid", '=', XN_Profile::$VIEWER)
				        ->filter('my.finished', '=', 'false')
						->filter('my.deleted', '=', '0')
						->end(1)
				        ->execute (); 
					if (count($approvals) > 0)
					{
						$approval_info = $approvals[0];
						$approvalid = $approval_info->id;
						saveapproval($approvalid, "ApprovalCenters", $reply,$reply_text);
					} 
	        }
	        catch (XN_Exception $e)
	        {
			 
	        } 
		}
		
		echo '{"statusCode":"200","message":null,"tabid":"'.$currentModule.'","closeCurrent":true,"forward":null}';
		die();
		
	} 
	else
	{
		echo '{"statusCode":"300","message":"审批参数异常！","forward":null}';
		die(); 
	} 
}
else
{
	$smarty = new vtigerCRM_Smarty;
	$binds = $_REQUEST['ids'];
	$binds = str_replace(";",",",$binds);
	$binds = explode(",",trim($binds,','));
	array_unique($binds); 
	$approvalcenters =  XN_Content::loadMany($binds,"approvalcenters");
	foreach($approvalcenters as $approvalcenter_info)
	{
		$pendingapprover = $approvalcenter_info->my->pendingapprover;
		if (!in_array(XN_Profile::$VIEWER,(array)$pendingapprover))
		{
			echo '<div style="width:100%;text-align:center;"><br><br><font color="red" size="2">您只能对待审的记录进行批量审批！</font></div>';
			die();
		}
	}  
 
	$msg  = '<div class="form-group">
	                <label class="control-label x85">'.getTranslatedString('LBL_APPROVALS_HIGHER_OPINION').':</label>
					<input data-rule="checked" data-toggle="icheck" type="radio" id="reply_agree" name="reply"  value="Agree" data-label="'.getTranslatedString('LBL_AGREE').'" > &nbsp;
					<input data-rule="checked" data-toggle="icheck" type="radio" id="reply_disagree" name="reply"  value="Disagree" data-label="'.getTranslatedString('LBL_DISAGREE').'" >&nbsp;
	            </div>
				<div class="form-group">
	                <label class="control-label x85" >'.getTranslatedString('LBL_APPROVALS_HIGHER_REPLAY').':</label>
					<textarea class="detailedViewTextBox textInput" id="reply_text" name="reply_text" style="width:400px;" ></textarea>
	            </div>';

	$fields = array(  
		'tabid' => array('label'=>'模块','width'=>'10','align'=>'center',),
		'sourcer' => array('label'=>'提交人','width'=>'10','align'=>'center',), 
		'amount' => array('label'=>'金额','width'=>'10','align'=>'center',),  
		'approvalcentersstatus' => array('label'=>'状态','width'=>'10','align'=>'center'), 
		'published' => array('label'=>'提交时间','width'=>'20','align'=>'center',),  
	);
				
	$msg .= "<table id='details_table' class='table table-bordered' border='0' cellspacing='0' cellpadding='0' width='100%' >";
	$msg .= "<tbody><tr>";
	foreach($fields as  $fieldname => $fieldname_info)
	{				
	    $msg .= "<th align='".$fieldname_info['align']."' width='".$fieldname_info['width']."%'>".$fieldname_info['label']."</th>";
	} 
	$msg .= "</tr>"; 
	 
	foreach($approvalcenters as $detail_info)
	{
		 $deleted = $detail_info->my->deleted;
		 if ($deleted == "0")
		 {
			 $msg .= "<tr id='row_".$auto_increment."'>";	
		 }
		 else
		 {
			 $msg .= "<tr style=\"background-color: #FF0000\" id='row_".$auto_increment."'>";
		 } 
		 foreach($fields as  $fieldname => $fieldname_info)
		 {
			 if ($fieldname == "tabid")
			 {
				 $tabid = $detail_info->my->tabid;
				 $msg .= "<td align='".$fieldname_info['align']."' width='".$fieldname_info['width']."%'>".getTranslatedString(getModuleLabel(getModule($tabid)))."</td>";  
			 }
			 else if ($fieldname == "sourcer")
			 {
				 $sourcer = $detail_info->my->sourcer;
				 $msg .= "<td align='".$fieldname_info['align']."' width='".$fieldname_info['width']."%'>".getUserNameByProfile($sourcer)."</td>";
			 }
			 else if ($fieldname == "approvalcentersstatus")
			 {
				 $approvalcentersstatus = $detail_info->my->approvalcentersstatus;
				 $msg .= "<td align='".$fieldname_info['align']."' width='".$fieldname_info['width']."%'>".getTranslatedString($approvalcentersstatus)."</td>";
			 } 
			 else if ($fieldname == "published")
			 {
				 $published = $detail_info->published;
				 $msg .= "<td align='".$fieldname_info['align']."' width='".$fieldname_info['width']."%'>".date("Y-m-d h:i",strtotime($published))."</td>";
			 }
			 else
			 {
				 $msg .= "<td align='".$fieldname_info['align']."' width='".$fieldname_info['width']."%'>".$detail_info->my->$fieldname."</td>";
			 } 
		 }	
		  $msg .= "</tr>";	
	 } 
	$msg .= "</tbody></table>"; 
	
	
	$smarty->assign("MSG", $msg);
	$smarty->assign("OKBUTTON", "确定审批");
	$smarty->assign("RECORD",$_REQUEST['ids']);
	$smarty->assign("SUBMODULE", $currentModule);
	$smarty->assign("SUBACTION", $_REQUEST['action']);
	 
	$smarty->assign("ALERTMSG","保存审批后，将无法撤销审批，<br>您是否确定保存审批？");
	 
	
	$smarty->display("MessageBox.tpl");
}

 

?>

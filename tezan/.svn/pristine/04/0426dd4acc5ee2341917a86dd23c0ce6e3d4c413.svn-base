<?php

global $mod_strings,$app_strings,$theme,$currentModule,$current_user;

require_once('Smarty_setup.php');
require_once('include/utils/utils.php');

$smarty = new vtigerCRM_Smarty;

$panel =  strtolower(basename(__FILE__,".php"));

$smarty->assign("MODULE",$currentModule);
$smarty->assign("PANEL",$panel);
$smarty->assign("APP",$app_strings);
$smarty->assign("MOD", $mod_strings);



$approvals = XN_Query::create ( 'Content' )
	->tag ( 'approvals' )
	->filter ( 'type', 'eic', 'approvals' )
	->filter ( 'my.finished', '=', 'false' )
	->filter ( 'my.sequence', '=', NULL )
	->filter ( 'my.deleted', '=', '0' )
	->order('published',XN_Order::ASC)
	->end(-1)
	->execute ();
if(count($approvals) > 0)
{
	foreach($approvals as $approval_info)
	{
		$approval_info->my->sequence = strtotime($approval_info->published);
		$approval_info->save("approvals");
	}
}



if(isset($_REQUEST['pos']) && $_REQUEST['pos'] != '')
{
	$pos = intval($_REQUEST['pos']);
}
else
{
	$pos = 0;
}

if(isset($_REQUEST['approvalid']) && $_REQUEST['approvalid'] != '')
{
	$approvalid = $_REQUEST['approvalid'];
	$approval_info = XN_Content::load($approvalid,"approvals");
	$approval_info->my->sequence = strtotime("now");
	$approval_info->save("approvals");
}


$query = XN_Query::create ( 'Content' )
	->tag ( 'approvals' )
	->filter ( 'type', 'eic', 'approvals' )
	->filter ( 'my.finished', '=', 'false' )
	->filter ( XN_Filter::any(XN_Filter( 'my.userid', '=', XN_Profile::$VIEWER),XN_Filter( 'my.proxyapproval', '=', XN_Profile::$VIEWER)))
	->filter ( 'my.deleted', '=', '0' )
	->order('my.sequence',XN_Order::ASC_NUMBER)
	->begin(0)
	->end(1);
$approvals = $query->execute();

if(count($approvals) > 0)
{
	$approval_info = $approvals[0];

	$approval_count = $query->getTotalCount();

	$approvals_tabid = $approval_info->my->tabid;
	$approvals_module = getModule($approvals_tabid);
	$approvals_from_userid = $approval_info->my->from_userid;
	$approvals_username = getUserNameByProfile($approvals_from_userid);
	$approvals_amount = $approval_info->my->amount;
	$approvals_submittime = date('Y-m-d H:i',strtotime($approval_info->createdDate));
	$approvals_info = $approval_info->my->approvalinfo;
	$record = $approval_info->my->record;
	$approvals_id = $approval_info->id;
}
else
{
	die();
}

if(isset($_REQUEST['pos']) && $_REQUEST['pos'] == 'CHECK')
{
	echo 'SUCCESS';
	die();
}
$pos++;
$msg = '
<fieldset>
			<legend >'.getTranslatedString('LBL_QUICKAPPROVAL').'【总计待审批'.$approval_count.'个，当前第'.$pos.'个】</legend>	
			<div class="form-group">
                <label class="control-label x85">'.getTranslatedString('LBL_APPROVALS_MODULE').':</label>
				<input readonly  disabled value="'.getTranslatedString($approvals_module).'" type="text">
            </div>';


$loadcontent = XN_Content::load($record,strtolower($approvals_module));

$msg .= '<div class="form-group">
                <label class="control-label x85">'.getTranslatedString('LBL_APPROVALS_USERID').':</label>
				<input  readonly disabled value="'.$approvals_username.'" type="text">
            </div>
			<div class="form-group">
                <label class="control-label x85">'.getTranslatedString('LBL_APPROVALS_SUBMITTIME').':</label>
				<input readonly disabled value="'.$approvals_submittime.'" type="text">
            </div>';

$author = $loadcontent->author;
$userrole = fetchUserRole($author);
$msg .= '<div class="form-group">
                <label class="control-label x85">'.getTranslatedString('LBL_APPROVALS_ROLE').':</label>
				<input  readonly disabled value="'.getRoleName($userrole).'" type="text">
            </div>';
$msg .= '<div class="form-group">
                <label class="control-label x85">'.getTranslatedString('LBL_APPROVALS_INFO').':</label>
				<input readonly disabled value="'.$approvals_info.'" type="text">
            </div>';
if($approvals_module=="Ma_Clients"){
	$msg .='
    <div class="form-group">
        <label class="control-label x85" for="approval_fullname">单位名称:</label>
        <input type="text" readonly disabled  value="'.$loadcontent->my->fullname.'">
    </div>
    <div class="form-group">
        <label class="control-label x85" for="approval_bussinesslicense" >营业执照:</label>
        <a href="'.$loadcontent->my->bussinesslicense.'" data-lightbox="roadtrip">
        	<image src="'.$loadcontent->my->bussinesslicense.'" style="width:100px;height:100px;" />
    	</a>
    </div>';
}

$reasonfields = XN_Query::create ( 'Content' ) ->tag('Fields')
	->filter ( 'type', 'eic', 'fields')
	->filter ( 'my.tabid', '=', $approvals_tabid)
	->filter ( 'my.presence', 'in', array('0','2','3'))
	->filter ( 'my.uitype', '=', '19')
	->execute();
if(count($reasonfields) >0)
{
	$reasonfield_info = $reasonfields[0];
	$fieldname = $reasonfield_info->my->fieldname;
	$fieldlabel = $reasonfield_info->my->fieldlabel;
	$loadcontent = XN_Content::load($record,strtolower($approvals_module));
	if ($loadcontent->my->$fieldname != "")
	{
		$msg .= '<div class="form-group">
                <label class="control-label x85">'.getTranslatedString($fieldlabel,$approvals_module).':</label>
				<input style="width:400px" readonly disabled value="'.$loadcontent->my->$fieldname.'" type="text">
            </div>';
	}

}

$msg .= '<div class="form-group">
                <label class="control-label x85">'.getTranslatedString('LBL_APPROVALS_HIGHER_OPINION').':</label>
				<input data-rule="checked" data-toggle="icheck" type="radio" id="reply_agree" name="reply"  value="Agree" data-label="'.getTranslatedString('LBL_AGREE').'" > &nbsp;
				<input data-rule="checked" data-toggle="icheck" type="radio" id="reply_disagree" name="reply"  value="Disagree" data-label="'.getTranslatedString('LBL_DISAGREE').'" >&nbsp;
            </div>
			<div class="form-group">
                <label class="control-label x85" >'.getTranslatedString('LBL_APPROVALS_HIGHER_REPLAY').':</label>
				<textarea class="detailedViewTextBox textInput" id="reply_text" name="reply_text" style="width:400px;" ></textarea>
            </div>';

$detailapprovals = array();
try{
	global $global_session; 
$tabdata  = $global_session['tabdata']; 
	$applicationname=$tabdata['applicationname'];
	$tab_info_array=$tabdata['tab_info_array'];
	$approvaltabs=$tabdata['approvaltabs'];
	$optionalapprovals=$tabdata['optionalapprovals'];
	$detailapprovals=$tabdata['detailapprovals'];
	$all_entity_tabs_array=$tabdata['all_entity_tabs_array'];
	$all_tablabels_array=$tabdata['all_tablabels_array'];
	$tab_label_array=$tabdata['tab_label_array'];
	$tab_quickcreate_array=$tabdata['tab_quickcreate_array'];
	$tab_seq_array=$tabdata['tab_seq_array'];
	$tab_ownedby_array=$tabdata['tab_ownedby_array'];
	$defaultOrgSharingPermission=$tabdata['defaultOrgSharingPermission'];
}
catch(XN_Exception $e){

}

if (in_array($approvals_tabid, $detailapprovals))
{
	$fields = array();
	$fieldsfile = "modules/$approvals_module/config.field.php";
	if (@file_exists($fieldsfile))
	{
		require_once($fieldsfile);
	}
	$msg .= '<div class="divider"></div>';
	$msg .= '<div class="form-group">';
	$msg .= "<table id='details_table' class='table table-bordered' border='0' cellspacing='0' cellpadding='0' width='100%' >";
	$msg .= "<tbody><tr>";

	if (isset($fields[strtolower($approvals_module).'_details']))
	{
		$fields = $fields[strtolower($approvals_module).'_details'];
	}
	$totalwidth = 1;
	foreach($fields as  $fieldname => $fieldname_info)
	{
		if (!$fieldname_info['approval']) continue;
		$totalwidth += floatval($fieldname_info['width']);
	}
	if ($totalwidth > 110)
	{
		foreach($fields as  $fieldname => $fieldname_info)
		{
			if (!$fieldname_info['approval']) continue;
			$percent = round(floatval($fieldname_info['width']) / $totalwidth * 100);
			$fieldname_info['width'] = $percent;
			$fields[$fieldname] = $fieldname_info;
		}
	}

	foreach($fields as  $fieldname => $fieldname_info)
	{
		if (!$fieldname_info['approval']) continue;
		$msg .= "<th align='".$fieldname_info['align']."' width='".$fieldname_info['width']."%'>".$fieldname_info['label']."</th>";

	}
	$msg .= "<th align='center' width='8%'>".getTranslatedString('OPER')."</th>";
	$msg .= "</tr>";
	try {


			$approvals = XN_Query::create ( 'Content' )->tag(strtolower($approvals_module).'_details')
				->filter ( 'type', 'eic', strtolower($approvals_module).'_details' )
				->filter ( 'my.record', '=', $record )
				->filter ( 'my.deleted', '=', '0' )
				->order("published",XN_Order::DESC)
				->execute ();

			foreach ($approvals as $approval_info)
			{
				$msg .= "<tr>";
				foreach($fields as  $fieldname => $fieldname_info)
				{
					if (!$fieldname_info['approval']) continue;
					switch($fieldname)
					{
						case "published":
							$msg .= "<td align='".$fieldname_info['align']."' width='".$fieldname_info['width']."%'>". date("Y-m-d",strtotime($approval_info->createdDate))."</td>";
							break;
						case "number":
						case "availablenumber":
						case "loannumber":
						case "budgetnumber":
							$msg .= "<td align='".$fieldname_info['align']."' width='".$fieldname_info['width']."%'>".formatnumber($approval_info->my->$fieldname)."(元)</td>";
							break;
						default:
							$msg .= "<td align='".$fieldname_info['align']."' width='".$fieldname_info['width']."%'>".$approval_info->my->$fieldname."</td>";
							break;
					}
				}
				$msg .= "<td align=center' width='8%'>";
				$msg .= '<label style="width:50px"><div style="float:left;position:relative;left:20%;"><input onchange="reply_change();" type="checkbox" checked id="details" name="details" value="'.$approval_info->id.'" />'.getTranslatedString('AGREE').'</div></label>';
				$msg .= "</td>";
				$msg .= "</tr>";
			}
	}
	catch ( XN_Exception $e )
	{
	}

	$msg .= "</tbody></table></div>";
	$msg .= '<input type="hidden" name="details_count" value="'.count($approvals).'">';

}
$msg .= '<input type="hidden" name="formodule" value="'.$approvals_module.'">';
$msg .= '<input type="hidden" name="pos" value="'.$pos.'">';
$msg .= '<input type="hidden" name="count" value="'.$approval_count.'">';
$msg .= '</div>
</fieldset>';


$buttons = array();
if ($approval_count > $pos )
{
	$buttons[] = '<a class="btn btn-default" data-icon="arrow-circle-o-right" onclick="next_approvals(\''.$pos.'\',\''.$approvals_id.'\');">'.getTranslatedString('LBL_APPROVALS_NEXT').'</a>';
}

$smarty->assign("BUTTONS", $buttons);


$script = '
function approve_open_dialog(pos,record)
{
     $(this).dialog({id:"ApproveDialog", url:"index.php?module=Approvals&action=ApproveDialog&pos="+pos+"&approvalid="+record, title:"快捷审批",width:700,height:500,mask:true,resizable:false,drawable:false,maxable:false});
}

function next_approvals(pos,record)
{
	BJUI.dialog("closeCurrent");
	setTimeout("approve_open_dialog(\'"+pos+"\',\'"+record+"\');",500);
}';


$smarty->assign("SCRIPT", $script);


$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->assign("MSG", $msg);
$smarty->assign("RECORD", $approvals_id);
$smarty->assign("SUBMODULE", "Approvals");
$smarty->assign("OKBUTTON", getTranslatedString('LBL_APPROVALS_SAVE_BUTTON_TITLE'));
$smarty->assign("ALERTMSG","保存审批后，将无法撤销审批，<br>您是否确定保存审批？");
$smarty->assign("SUBACTION", "saveApprove");

$smarty->display("MessageBox.tpl");

?>
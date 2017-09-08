<?php
global $mod_strings,$app_strings,$theme,$currentModule,$current_user,$action;
require_once('Smarty_setup.php');
require_once('include/utils/utils.php');

$smarty = new vtigerCRM_Smarty;
$fields = array();
$action = $_REQUEST['file'];
$record = $_REQUEST['record'];
$readonly = 'true';
if (empty($record) || !isset($record)) {exit;}
/**header**/
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/'.$currentModule.'/config.field.php');
$create_onclick = 'popup_click(this,\'module=Users&action=Popup&popuptype=CreateEvaluateRecord&form=TasksEditView&form_submit=false&fromlink=&record='.$record.'\',\''.$mod_strings[LBL_CREATE_EVALUATE_RECORD].'\',\'50\')';
$msg = "<table cellpadding=0 cellspacing=0 width='100%'><tr><td style='text-align:right;height:34px'>";
$msg .= '<a class="sexybutton sexygray green" href="javascript:void(0)" onclick="'.$create_onclick.'"><span><span>'.getTranslatedString('LBL_CREATE_EVALUATE_RECORD').'</span></span></a>';
$msg .= '</td></tr></table>';
$msg .= '<table cellpadding="0" cellspacing="0" class="table table-bordered">';
$msg .= '<tr>';
foreach($fields[$action] as  $field ) {
	$msg .= '<th width="'.$field['width'].'">'.$field['zh_cn'].'</th>';
}
$msg .= '</tr>';
/**details**/
$detailsTable = 'userevaluaterecords';
$details = XN_Query::create('content')->tag($detailsTable)
	->filter('type','eic',$detailsTable)
	->filter('my.record','=',$record)
	->execute();
if (count($details) > 0) {
	$profileIdArr  = array();
	foreach($details as $detail) {
		$profileIdArr[$detail->author] = $detail->author;
	}
	$profileNameArr = getOwnerNameList($profileIdArr);
	foreach($details as $detail) {
		$id = $detail->id;
		$msg .= "<tr>";
		foreach($fields[$action] as $fieldname => $field) {
			if ($fieldname == 'createdDate' || $fieldname == 'updatedDate') {
				$value = date('Y-m-d',strtotime($detail->$fieldname));
				$msg .= '<td>'.getDisplayDate($value).'</td>';
			}
			elseif ($fieldname == 'autor') {
				$msg .= '<td>'.$profileNameArr[$detail->author].'</td>';
			}
			else {
				if ($detail->my->type == 'normal') {
					$msg .= "<td><a href='javascript:void(0)' onclick='popup_click(this,\"module=Users&action=Popup&popuptype=CreateEvaluateRecord&from=TaskEditView&record=$record&id=$id\",\"$mod_strings[LBL_SHOW_EVALUATE_RECORD]\",50)'>".$detail->my->$fieldname."</a></td>";
				}
				elseif ($detail->my->type == 'assign') {
					$detailid = $detail->id;
					$msg .= "<td><a href='javascript:void(0)' onclick=\"assignEngineer($detailid,80,'show')\">".$detail->my->$fieldname."</a></td>";
				}
				else $msg .= "<td>".$detail->my->$fieldname."</td>";
			}	
		}
		$msg .= '</tr>';
	}
}

$msg .= '</table>';

$smarty->assign('RECORD',$record);
$smarty->assign('READONLY',$readonly);
$smarty->assign("MODULE",$currentModule);
$smarty->assign("APP",$app_strings);
$smarty->assign("MOD",$mod_strings);
$smarty->assign("THEME",$theme);
$smarty->assign("POPUP_DIV", $msg);
$smarty->display('PopupDiv.tpl');


?>
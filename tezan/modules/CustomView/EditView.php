<?php

global $mod_strings;
global $app_list_strings;
global $app_strings;
global $current_user;
global $oCustomView;

require_once('modules/CustomView/CustomView.php');

$cv_module = $_REQUEST['module'];

$recordid = $_REQUEST['record'];
require_once('Smarty_setup.php');
$smarty = new vtigerCRM_Smarty();

$smarty->assign("MOD", $mod_strings);
$smarty->assign("CATEGORY", getParentTab());
$smarty->assign("APP", $app_strings);
$smarty->assign("THEME", $theme);
$smarty->assign("IMAGE_PATH", $image_path);
$smarty->assign("MODULE",$cv_module);
$smarty->assign("MODULELABEL",getTranslatedString($cv_module,$cv_module));
$smarty->assign("CVMODULE", $cv_module);
$smarty->assign("CUSTOMVIEWID",$recordid);

if($recordid == "")
{
	$oCustomView = new CustomView();
	$modulecollist = $oCustomView->getModuleColumnsList($cv_module);
	
	$choosecol = array();
	if(isset($modulecollist))
	{		
		$choosecolhtml = getByModule_ColumnsHTML($cv_module,$modulecollist);
	}
	foreach($oCustomView->module_list[$cv_module] as $key=>$value){
		if(isset($modulecollist[$cv_module][$key])){
			foreach($modulecollist[$cv_module][$key] as $field=>$fieldlabel){
				$choosecol[] = $choosecolhtml;
			}
		}
	}
	$validator = "";
	for($i=1;$i<=count($choosecol);$i++){
		if($validator == "")
			$validator .= "column".$i;
		else
			$validator .= " column".$i;
	}

	$smarty->assign("VALIDATOR",$validator);
	$smarty->assign("CHOOSECOL",$choosecol);
	$smarty->assign("MANDATORYCHECK",implode(",",array_unique($oCustomView->mandatoryvalues)));
	$data_type = array();
    foreach($oCustomView->data_type as $key => $value)
    	$data_type[getTranslatedString($key,$cv_module)] = $value;
	$smarty->assign("DATATYPE",$data_type);
}
else
{
	$oCustomView = new CustomView($cv_module);
	$now_action = $_REQUEST['action'];
	if($oCustomView->isPermittedCustomView($recordid,$oCustomView->customviewmodule) == 'yes')
	{
		$customviewdtls = $oCustomView->getCustomViewByCvid($recordid);
		$modulecollist = $oCustomView->getModuleColumnsList($cv_module);
		$selectedcolumnslist = $oCustomView->getColumnsListByCvid($recordid);
		$smarty->assign("VIEWNAME",$customviewdtls["viewname"]);
		$status = $customviewdtls["status"];
		$smarty->assign("STATUS",$status);
		$choosecol = array();
		foreach($oCustomView->module_list[$cv_module] as $key=>$value){
			if(isset($modulecollist[$cv_module][$key])){
				$i=0;
				foreach($modulecollist[$cv_module][$key] as $field=>$fieldlabel){
					$choosecol[] = getByModule_ColumnsHTML($cv_module,$modulecollist,$selectedcolumnslist[$i]);
					$i++;
				}
			}
		}
		$validator = "";
		for($i=1;$i<=count($choosecol);$i++){
			if($validator == "")
				$validator .= "column".$i;
			else
				$validator .= " column".$i;
		}

		$smarty->assign("VALIDATOR",$validator);
		$smarty->assign("CHOOSECOL",$choosecol);
	    $data_type = array();
	    foreach($oCustomView->data_type as $key => $value)
	    	$data_type[getTranslatedString($key,$cv_module)] = $value;
	    $smarty->assign("DATATYPE",$data_type);
	}
    else
	{
		echo "<table border='0' cellpadding='5' cellspacing='0' width='100%' height='450px'><tr><td align='center'>";
		echo "<div style='border: 3px solid rgb(153, 153, 153); background-color: rgb(255, 255, 255); width: 55%; position: relative; z-index: 10000000;'>
			<table border='0' cellpadding='5' cellspacing='0' width='98%'>
			<tbody><tr>
			<td rowspan='2' width='11%'><img src='denied.gif' ></td>
			<td style='border-bottom: 1px solid rgb(204, 204, 204);' nowrap='nowrap' width='70%'><span class='genHeaderSmall'>$app_strings[LBL_PERMISSION]</span></td>
			</tr>
			<tr>
			<td class='small' align='right' nowrap='nowrap'>
			<a href='javascript:window.history.back();'>$app_strings[LBL_GO_BACK]</a><br>
			</td>
			</tr>
			</tbody></table>
			</div>";
		echo "</td></tr></table>";
		exit;
	}  
}

$smarty->assign("RETURN_MODULE", $cv_module);
if($cv_module == "Calendar")
        $return_action = "ListView";
else
        $return_action = "index";

if($recordid == '')
	$act = $mod_strings['LBL_NEW'];
else
	$act = $mod_strings['LBL_EDIT'];

$smarty->assign("ACT", $act);
$smarty->assign("RETURN_ACTION", $return_action);

$smarty->display("CustomView.tpl");

function getByModule_ColumnsHTML($module,$columnslist,$selected="")
{
	global $oCustomView, $current_language,$theme;
	global $app_list_strings;
	$advfilter = array();
	$mod_strings = return_specified_module_language($current_language,$module);
	$app_strings = return_application_language($current_language);
	
	$check_dup = Array();
	foreach($oCustomView->module_list[$module] as $key=>$value)
	{
		$advfilter = array();			
		$label = $key;
		if(isset($columnslist[$module][$key]))
		{
			foreach($columnslist[$module][$key] as $field=>$fieldlabel)
			{
				if(!in_array($fieldlabel,$check_dup))
				{
					if(isset($mod_strings[$fieldlabel]))
					{
						$advfilter_option['selected'] = "";
						if($selected == $field)
							$advfilter_option['selected'] = "selected";
						$advfilter_option['value'] = $field;
						$advfilter_option['text'] = str_replace("&nbsp;","",$mod_strings[$fieldlabel]);
						$advfilter_option['essentialField'] = $mod_strings[$oCustomView->essentialField];
					}elseif(isset($app_strings[$fieldlabel])){
						$advfilter_option['selected'] = "";
						if($selected == $field)
							$advfilter_option['selected'] = "selected";
						$advfilter_option['value'] = $field;
						$advfilter_option['text'] = str_replace("&nbsp;","",$app_strings[$fieldlabel]);
						$advfilter_option['essentialField'] = $app_strings[$oCustomView->essentialField];
					}else
					{
						$advfilter_option['selected'] = "";
						if($selected == $field)
							$advfilter_option['selected'] = "selected";
						$advfilter_option['value'] = $field;
						$advfilter_option['text'] = str_replace("&nbsp;","",$fieldlabel);
						$advfilter_option['essentialField'] = $oCustomView->essentialField;
					}
					$advfilter[] = $advfilter_option;
					$check_dup [] = $fieldlabel;
				}
			}
			$advfilter_out[$label]= $advfilter;
		}
	}
	// Special case handling only for Calendar moudle - Not required for other modules.
	// if($module == 'Calendar') {
	// 	$finalfield = Array();
	// 	$finalfield1 = Array();
	// 	$finalfield2 = Array();
	// 	$newLabel = $mod_strings['LBL_CALENDAR_INFORMATION'];
	//
	// 	if(isset($advfilter_out[$mod_strings['LBL_TASK_INFORMATION']])) {
	// 	    $finalfield1 = $advfilter_out[$mod_strings['LBL_TASK_INFORMATION']];
	// 	}
	// 	if(isset($advfilter_out[$mod_strings['LBL_EVENT_INFORMATION']])) {
	// 	    $finalfield2 = $advfilter_out[$mod_strings['LBL_EVENT_INFORMATION']];
	// 	}
	// 	$finalfield[$newLabel] = array_merge($finalfield1,$finalfield2);
	//     if (isset ($advfilter_out[$mod_strings['LBL_CUSTOM_INFORMATION']])) {
	//     	$finalfield[$mod_strings['LBL_CUSTOM_INFORMATION']] = $advfilter_out[$mod_strings['LBL_CUSTOM_INFORMATION']];
	// 	}
	// 	$advfilter_out=$finalfield;
	// }
	return $advfilter_out;
}
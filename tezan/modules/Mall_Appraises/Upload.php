<?php
/*+**********************************************************************************
 * The contents of this file are subject to the 361CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  361CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

global $mod_strings,$app_strings,$theme,$currentModule,$current_user;

require_once('Smarty_setup.php');
require_once('include/utils/utils.php');

$smarty = new vtigerCRM_Smarty;

$smarty->assign("MODULE",$currentModule);
$smarty->assign("APP",$app_strings);
$smarty->assign("MOD", $mod_strings);

$panel = strtolower($_REQUEST['action']);

$smarty->assign("PANEL", $panel);

global $readonly;
if(isset($_REQUEST['readonly']) && $_REQUEST['readonly'] != '') 
{
	$readonly = $_REQUEST['readonly'];
	$smarty->assign("READONLY",$readonly);
}

if(isset($_REQUEST['record']) && $_REQUEST['record'] !='') 
{
	    $recordid = $_REQUEST['record'];
	    $smarty->assign("ID", $recordid);

		 $loadcontent = XN_Content::load($recordid,"local_appraises",7); 
		 $images = $loadcontent->my->images;
		 $msg = ""; 
		
		 $msg .= "<ul style='width:100%;' >";
		  
      
		foreach((array)$images as $image_info)
		{
			$msg .= '<li style="width:25%;float:left;">';  
			$msg .= '<div style="padding:5px;">
					<a href="'.$image_info.'"  data-lightbox="roadtrip">
						<img align="absmiddle" style="border-radius: 6px;width: 100%;max-width: 100%;height: auto;" src="'.$image_info.'"/>
					</a>
					</div>';
		    $msg .= '</li>';
		}		 
		
		$msg .= "</ul>";
 		//$msg .= '<script language="JavaScript" type="text/javascript" src="/Public/js/jquery.imgpreview.js" defer="defer"></script>';
		$smarty->assign("PANELBODY", $msg);
}

 
$smarty->assign("SCRIPT", ''); 



$smarty->display('Panel.tpl');

?>
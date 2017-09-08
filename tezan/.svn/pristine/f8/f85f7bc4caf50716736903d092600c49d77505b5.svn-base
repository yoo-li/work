<?php


global $log, $mod_strings, $app_strings, $theme, $currentModule, $current_user;

if (isset($_REQUEST['record']) && $_REQUEST['record'] != '' && isset($_REQUEST['formodule']) && $_REQUEST['formodule'] != '' && isset($_REQUEST['reply']) && $_REQUEST['reply'] != '')
{
    $formodule = $_REQUEST ['formodule'];
    $recordId = $_REQUEST ['record'];

    $reply = $_REQUEST ['reply'];
    $reply_text = $_REQUEST ['reply_text'];
	
	global $copyrights,$supplierid; 
	if(isset($_SESSION['supplierid']) && $_SESSION['supplierid'] !='')
	{ 
		$supplierid = $_SESSION['supplierid']; 
	} 
	
    saveapproval($recordId, $formodule, $reply,$reply_text);

}





?>
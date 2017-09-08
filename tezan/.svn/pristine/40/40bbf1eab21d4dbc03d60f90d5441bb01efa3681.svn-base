<?php
/*+********************************************************************************
 * The contents of this file are subject to the 361CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  361CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ********************************************************************************/
require_once('include/utils/utils.php');
global  $current_user,$default_charset;

$cvid = (int) $_REQUEST["record"];
$cvmodule = $_REQUEST["cvmodule"];
if($cvmodule != "") {
	$cv_tabid = getTabid($cvmodule);
	$viewname = $_REQUEST["viewName"];
	$viewname = htmlentities($viewname,ENT_QUOTES,$default_charset);

	if(isset($_REQUEST['setStatus']) && $_REQUEST['setStatus'] != '' && $_REQUEST['setStatus'] != '1')
		$status = $_REQUEST['setStatus'];
	elseif(isset($_REQUEST['setStatus']) && $_REQUEST['setStatus'] != '' && $_REQUEST['setStatus'] == '1')
		$status = CV_STATUS_PUBLIC;
	else
		$status = CV_STATUS_PRIVATE;
	$userid = $current_user->id;
	$setdefault = 0;
	$setmetrics = 0;

	$allKeys = array_keys($_REQUEST); 

	for ($i=0;$i<count($allKeys);$i++) {
	   $string = substr($allKeys[$i], 0, 6);
	   if($string == "column") {
		   if($_REQUEST[$allKeys[$i]] != "") 
        	   $columnslist[] = $_REQUEST[$allKeys[$i]];
   	   }
	}
	
	if(!$cvid) {
			$customviewresult = false;
			$newcontent = XN_Content::create('customviews','',false);
			$newcontent->my->viewname = $viewname;
			$newcontent->my->setdefault = $setdefault;
			$newcontent->my->setmetrics = 0;
			$newcontent->my->entitytype = $cvmodule;
			$newcontent->my->status = $status;
			$newcontent->my->userid = $userid;
			$newcontent->save('Customviews');
			$genCVid = $newcontent->id;
			$customviewresult = true;
			
			if($customviewresult) {
				if(isset($columnslist)) {
					for($i=0;$i<count($columnslist);$i++) {
						$ump = XN_Content::create('cvcolumnlists','',false);
						$ump->my->cvid = $genCVid;
						$ump->my->columnindex = $i;
						$ump->my->columnname = $columnslist[$i];
						$ump->save('Cvcolumnlists');
					}
					//					
				}
			}
			$cvid = $genCVid;
			$_SESSION['lvs'][$cvmodule]["viewid"] = $genCVid;
			echo '{"statusCode":200,"tabid":"'.$cvmodule.'","closeCurrent":"true"}';
			die();
	} else {
			$updatecvresult = false;
			try {   
			 	$customview = XN_Content::load($cvid,'Customviews'); 
			 	$customview->my->viewname = $viewname;
			 	$customview->my->setmetrics = $setmetrics;
			 	$customview->my->status = $status;
			 	$customview->save('Customviews');
			 	$updatecvresult = true;
			} catch ( XN_Exception $e ) {}
			
			
			
			$query = XN_Query::create ( 'Content' ) ->tag('Cvcolumnlists')
				->filter ( 'type', 'eic', 'cvcolumnlists' )
				->filter ( 'my.cvid', '=', $cvid)
				->execute();
			XN_Content::delete ($query, 'Cvcolumnlists' ); 

			
	
			$genCVid = $cvid;
			if($updatecvresult) {
				if(isset($columnslist)) {
					for($i=0;$i<count($columnslist);$i++) {
						$ump = XN_Content::create('cvcolumnlists','',false);
						$ump->my->cvid = $genCVid;
						$ump->my->columnindex = $i;
						$ump->my->columnname = $columnslist[$i];
						$ump->save('Cvcolumnlists');
					}
					
				}
			}
		echo '{"statusCode":200,"tabid":"'.$cvmodule.'","closeCurrent":"true"}';
		die();

	  }
}
echo '{"statusCode":200,"closeCurrent":"true","forward":null}';

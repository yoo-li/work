<?php
/*+********************************************************************************
 * The contents of this file are subject to the 361CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  361CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ********************************************************************************/

require_once('include/database/PearDatabase.php');
require_once('include/utils/UserInfoUtil.php');
require_once('include/utils/CommonUtils.php');




$idlist = $_REQUEST['idlist'];
$viewid = $_REQUEST['viewname'];
$returnmodule = $_REQUEST['return_module'];
$module = $_REQUEST['module'];
$return_action = $_REQUEST['return_action'];
$rstart='';
//Added to fix 4600
$url = getBasic_Advance_SearchURL();

//split the string and store in an array

$storearray = explode(";",trim($idlist,';'));
array_filter($storearray);
$ids_list = array();
$errormsg = '';

try 
{
	   $result = XN_Query::create ( 'Content' )
					->tag ( 'storageinit' )
					->filter ( 'type', 'eic', 'storageinit' )
					->filter ( 'my.storageid', 'in', $storearray )
					->filter ( 'my.deleted', '=', '0' )
					->execute ();
	  $result1 = XN_Query::create ( 'Content' )
					->tag ( 'inventory' )
					->filter ( 'type', 'eic', 'inventory' )
					->filter ( 'my.storageid', 'in', $storearray )
					->filter ( 'my.deleted', '=', '0' )
					->execute ();
	 
	  if (count($result1) > 0 || count($result) > 0 ) 
	  {    
		 $errormsg .= getTranslatedString("LBL_DELETE_MSG_REFERENCE").'<br>';
	  }
	
} catch ( XN_Exception $e ) 
{
		$errormsg =  $e->getMessage ();
}

if ($errormsg == "")
{
	foreach($storearray as $id)
	{
			if(isPermitted($returnmodule,'Delete',$id) == 'yes')
			{
				$focus = CRMEntity::getInstance($returnmodule);
				DeleteEntity($returnmodule,$returnmodule,$focus,$id,'');
			}
			else
			{
				$ids_list[] = $id;
			}
	}
	if(count($ids_list) > 0) {
		$ret = getEntityName($returnmodule,$ids_list);
		if(count($ret) > 0)
		{
				$errormsg = implode(',',$ret);
		}
	}
}

if(isset($_REQUEST['smodule']) && ($_REQUEST['smodule']!=''))
{
	$smod = "&smodule=".$_REQUEST['smodule'];
}
if(isset($_REQUEST['start']) && ($_REQUEST['start']!=''))
{
	$rstart = "&start=".$_REQUEST['start'];
}
if($returnmodule == 'Emails')
{
	if(isset($_REQUEST['folderid']) && $_REQUEST['folderid'] != '')
	{
		$folderid = $_REQUEST['folderid'];
	}else
	{
		$folderid = 1;
	}
	header("Location: index.php?module=".$returnmodule."&action=".$returnmodule."Ajax&folderid=".$folderid."&ajax=delete".$rstart."&file=ListView&errormsg=".urlencode($errormsg).$url);
}
elseif($return_action == 'ActivityAjax')
{
	$subtab = $_REQUEST['subtab'];
	header("Location: index.php?module=".$returnmodule."&action=".$return_action."".$rstart."&view=".$_REQUEST['view'])."&hour=".$_REQUEST['hour'])."&day=".$_REQUEST['day'])."&month=".$_REQUEST['month'])."&year=".vtlib_purify($_REQUEST['year']."&type=".vtlib_purify($_REQUEST['type']."&viewOption=".vtlib_purify($_REQUEST['viewOption']."&subtab=".$subtab.$url;
}
			
elseif($returnmodule!='Faq')
{
	header("Location: index.php?module=".$returnmodule."&action=".$returnmodule."Ajax&ajax=delete".$rstart."&file=ListView&viewname=".$viewid."&errormsg=".urlencode($errormsg).$url);
}
else
{
	header("Location: index.php?module=".$returnmodule."&action=".$returnmodule."Ajax&ajax=delete".$rstart."&file=ListView&errormsg=".urlencode($errormsg).$url);
}
?>
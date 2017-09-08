<?php
/*+********************************************************************************
 * The contents of this file are subject to the 361CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  361CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ********************************************************************************/

require_once 'include/Webservices/Utils.php';

global $adb;
$del_id =  $_REQUEST['delete_user_id'];
$tran_id = $_REQUEST['transfer_user_id'];

 

try{
		$users = XN_Query::create('Content')->tag('users')
			->filter('type','eic','users')
			->filter('my.profileid','=',$del_id)
			->execute();
		foreach ($users as $user) 
		{
			//$user->my->deleted = '1';
			//$user->save("users");
			//XN_Content::delete($user,"users");
		}

		 $profile = XN_Profile::load($del_id);
		 $profile->status = 'false';
		// $profile->save();

		$tabs_query = XN_Query::create ( 'Content' )->tag ( 'Tabs' )
					      ->filter ( 'type', 'eic', 'tabs' )
						  ->filter ( 'my.isentitytype', '=', '1' )
						  ->filter ( 'my.tabname', '!in', array('Worklogs','Faq','Webmails') )
						  ->order('my.tabsequence',XN_Order::ASC_NUMBER);
	    $tabs = $tabs_query->execute();	 			     

		 foreach ($tabs as $tab_info) 
		 {
			$moduledatas = XN_Query::create ( 'Content' )->tag ( strtolower($tab_info->my->tabname) )
						->filter ( 'type', 'eic', $tab_info->my->tabname )
				 		->filter ( 'my.personman', '=', $del_id )
						->end(-1)
						->execute ();
			 foreach ($moduledatas as $module_data) 
			 {
				 $personman = $module_data->my->personman;
				 if (is_array($personman))
				 {
					 $personman[] = $tran_id;
					 $module_data->my->personman = array_diff($personman,array($del_id));	
				 }
				 else
				 {
					 $module_data->my->personman = $tran_id;				 
				 }
				 $module_data->save(strtolower($tab_info->my->tabname));
			 }
		 }

}catch(XN_Exception $e)
{
	echo 'Error:'.$e->getMessage();
	die();
}
	


//if check to delete user from detail view
if(isset($_REQUEST["ajax_delete"]) && $_REQUEST["ajax_delete"] == 'false')
	header("Location: index.php?action=ListView&module=Users");
else
	header("Location: index.php?action=UsersAjax&module=Users&file=ListView&ajax=true");
?>
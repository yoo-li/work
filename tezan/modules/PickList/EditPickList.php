<?php
/*+********************************************************************************
 * The contents of this file are subject to the 361CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  361CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *********************************************************************************/


require_once('Smarty_setup.php');
require_once 'include/utils/CommonUtils.php';
require_once 'modules/PickList/PickListUtils.php';


global $app_strings, $app_list_strings, $current_language, $currentModule, $theme;
global $fieldlabel,$tablabel,$parentlabel,$picklistname;

$temp_module_strings = return_module_language($current_language, $currentModule);

$smarty=new vtigerCRM_Smarty;
$smarty->assign("APP", $app_strings);		//the include language files
$smarty->assign("MOD", return_module_language($current_language,'Settings'));	//the settings module language file
$smarty->assign("MOD_PICKLIST", return_module_language($current_language,'PickList'));	//the picklist module language files
$smarty->assign("TEMP_MOD", $temp_module_strings);	//the selected modules' language file

$smarty->assign("MODULE",$currentModule);
$smarty->assign("THEME",$theme);


$record = $_REQUEST['record'];

$subMode = $_REQUEST['sub_mode'];
if($subMode == 'changeOrder')
	  changeFieldOrder();
elseif ($subMode == 'updateFieldProperties')
	updateFieldProperties();	  
elseif ($subMode == 'add')
	createcustomfieldform();
elseif ($subMode == 'batchadd')
	batchcreatepicklistform();	
elseif($subMode == 'showhiddenfields')
	show_hiddenfields();
elseif($subMode == 'deletepicklist')
	deletepicklist();	
	
function deletepicklist(){	
	$record = $_REQUEST['record'];
	$fields = XN_Query::create ( 'Content' )->tag ( 'Fields' )
				->filter ( 'type', 'eic', 'fields' )
				->filter ( 'my.fieldid', '=', $record )
				->execute ();
	if (count($fields) > 0 )
	{
			$field_info = $fields[0];
			$picklistname = $field_info->my->fieldname;
			
			$picklists = XN_Query::create ( 'Content' )->tag ( 'Picklists' )
							      ->filter ( 'type', 'eic', 'picklists' )
							      ->filter ( 'my.name', '=', $picklistname )
							      ->filter ( 'my.picklist_valueid', '=', $_REQUEST['picklistid'] )
							      ->execute();			
			if (count($picklists) >0 ){
				 $picklist_info = $picklists[0];
				 XN_Content::delete($picklist_info,'Picklists');
			}
	}
}
function show_hiddenfields(){	
	
	$selected_fields = $_REQUEST['selected'];	
	$selected = trim($selected_fields,":");
	if ( $selected != '')
	{
		$sel_arr = array();
		$sel_arr = explode(":",$selected);
		$record = $_REQUEST['record'];
		$fields = XN_Query::create ( 'Content' )->tag ( 'Fields' )
					->filter ( 'type', 'eic', 'fields' )
					->filter ( 'my.fieldid', '=', $record )
					->execute ();
		if (count($fields) > 0 )
		{
				$field_info = $fields[0];
				$picklistname = $field_info->my->fieldname;
				$presence_picklists = XN_Query::create ( 'Content' )->tag ( 'Picklists' )
							      ->filter ( 'type', 'eic', 'picklists' )
							      ->filter ( 'my.name', '=', $picklistname )
							      ->filter ( 'my.presence', '=', '0' )
							      ->filter ( 'my.picklist_valueid', 'in',$sel_arr )
							      ->execute();
				 foreach ($presence_picklists as $presence_picklist_info)
				 {					 	
				 	 $presence_picklist_info->my->presence = '1';
				 	 $presence_picklist_info->save('Picklists');
				 }	
		}
	}
}

function  batchcreatepicklistform(){
	$record = $_REQUEST['record'];
	$fields = XN_Query::create ( 'Content' )->tag ( 'Fields' )
				->filter ( 'type', 'eic', 'fields' )
				->filter ( 'my.fieldid', '=', $record )
				->execute ();
	if (count($fields) > 0 )
	{
			$field_info = $fields[0];
			$picklistname = $field_info->my->fieldname;
			$batchlabel = $_REQUEST['label'];			
			
			
			$batchlabel = trim($batchlabel,"\n");	
			$sel_arr = array();
			$batchlabel_arr = explode("\n",$batchlabel);
		
			
			$picklists = XN_Query::create ( 'Content' )->tag ( 'Picklists' )
							      ->filter ( 'type', 'eic', 'picklists' )
							      ->order('my.picklist_valueid',XN_Order::DESC_NUMBER)
							      ->begin(0)->end(1)
							      ->execute();			
			if (count($picklists) >0 ){
				 $picklist_info = $picklists[0];
				 $current_sequence = $picklist_info->my->sequence;				
				 $current_picklist_valueid = $picklist_info->my->picklist_valueid;
				 $sequence_picklists = XN_Query::create ( 'Content' )->tag ( 'Picklists' )
							      ->filter ( 'type', 'eic', 'picklists' )
							      ->filter ( 'my.name', '=', $picklistname )
							      ->order('my.sequence',XN_Order::DESC_NUMBER)
							      ->begin(0)->end(1)
							      ->execute();			
				if (count($picklists) >0 ){
					 $sequence_picklist_info = $sequence_picklists[0];
					 $current_sequence = $sequence_picklist_info->my->sequence;	
					
					 $arr = 1;
					 foreach($batchlabel_arr as $batchlabel_info) 
					 {
						  XN_Content::create('picklists', '',false)
							       ->my->add('name',$picklistname)
							       ->my->add($picklistname,$batchlabel_info)
							       ->my->add('picklist_valueid',intval($current_picklist_valueid)+$arr)  
							       ->my->add('sequence',intval($current_sequence)+$arr)  
							       ->my->add('presence','1')
							       ->my->add('isdefault','0')       
							       ->save("Picklists");
						   $arr++;
					 }
				}
			}
	}
	
}	
function createcustomfieldform(){
    $record = $_REQUEST['record'];
	$fields = XN_Query::create ( 'Content' )->tag ( 'Fields' )
				->filter ( 'type', 'eic', 'fields' )
				->filter ( 'my.fieldid', '=', $record )
				->execute ();
	if (count($fields) > 0 )
	{
			$field_info = $fields[0];
			$picklistname = $field_info->my->fieldname;
			
			$name = $_REQUEST['label'];			
			$default = $_REQUEST['default'];
			$presence = $_REQUEST['enable'];

			if (isset($_REQUEST['profile_picklist']) && $_REQUEST['profile_picklist'] == "true" ) 
			{
				    $tabid = $field_info->my->tabid;
					$current_sequence = '1';	
					$current_picklist_valueid = '1';
					$picklists = XN_Query::create ( 'Content' )->tag ( 'Picklists' )
										  ->filter ( 'type', 'eic', 'picklists' )
										  ->order('my.picklist_valueid',XN_Order::DESC_NUMBER)
										  ->begin(0)->end(1)
										  ->execute();			
					if (count($picklists) >0 )
					{
						 $picklist_info = $picklists[0];						
						 $current_picklist_valueid =  intval($picklist_info->my->picklist_valueid)+1;
					}
					$sequence_picklists = XN_Query::create ( 'Content' )->tag ( 'Picklists' )
									  ->filter ( 'type', 'eic', 'picklists' )
									  ->filter ( 'my.name', '=', $picklistname )
									  ->filter ( 'my.tabid', '=', $tabid )
									  ->order('my.sequence',XN_Order::DESC_NUMBER)
									  ->begin(0)->end(1)
									  ->execute();			
					if (count($sequence_picklists) >0 )
					{
						 $sequence_picklist_info = $sequence_picklists[0];
						 $current_sequence = $sequence_picklist_info->my->sequence;	
						 if ($default == '1')
						 {
							 $remove_default_picklists = XN_Query::create ( 'Content' )->tag ( 'Picklists' )
									  ->filter ( 'type', 'eic', 'picklists' )
									  ->filter ( 'my.name', '=', $picklistname )
									  ->filter ( 'my.tabid', '=', $tabid )
									  ->filter ( 'my.isdefault', '=','1' )
									  ->execute();
							 foreach ($remove_default_picklists as $remove_default_picklist_info)
							 {					 	
								 $remove_default_picklist_info->my->isdefault = '0';
								 $remove_default_picklist_info->save('Picklists');
							 }							
						 }
						 
					}

					$newcontent = XN_Content::create('picklists', '',false)
							   ->my->add('name',$picklistname)
							   ->my->add($picklistname,$name)
							   ->my->add('tabid',$tabid)  
						       ->my->add('picklist_valueid',$current_picklist_valueid)  
							   ->my->add('sequence',intval($current_sequence)+1)  
							   ->my->add('presence',$presence)
							   ->my->add('isdefault',$default);
									  
					$newcontent->save("Picklists");
			}
			else
			{
					$current_sequence = '1';				
					$current_picklist_valueid = '1';

					$picklists = XN_Query::create ( 'Content' )->tag ( 'Picklists' )
										  ->filter ( 'type', 'eic', 'picklists' )
										  ->order('my.picklist_valueid',XN_Order::DESC_NUMBER)
										  ->begin(0)->end(1)
										  ->execute();			
					if (count($picklists) >0 )
					{
						 $picklist_info = $picklists[0];
						 $current_sequence = $picklist_info->my->sequence;				
						 $current_picklist_valueid = $picklist_info->my->picklist_valueid;
						 $sequence_picklists = XN_Query::create ( 'Content' )->tag ( 'Picklists' )
										  ->filter ( 'type', 'eic', 'picklists' )
										  ->filter ( 'my.name', '=', $picklistname )
										  ->order('my.sequence',XN_Order::DESC_NUMBER)
										  ->begin(0)->end(1)
										  ->execute();			
						if (count($sequence_picklists) >0 )
						{
							 $sequence_picklist_info = $sequence_picklists[0];
							 $current_sequence = $sequence_picklist_info->my->sequence;	
							 if ($default == '1')
							 {
								 $remove_default_picklists = XN_Query::create ( 'Content' )->tag ( 'Picklists' )
										  ->filter ( 'type', 'eic', 'picklists' )
										  ->filter ( 'my.name', '=', $picklistname )
										   ->filter ( 'my.isdefault', '=','1' )
										  ->execute();
								 foreach ($remove_default_picklists as $remove_default_picklist_info)
								 {					 	
									 $remove_default_picklist_info->my->isdefault = '0';
									 $remove_default_picklist_info->save('Picklists');
								 }							
							 }
							 
						}
					}
				   $newcontent = XN_Content::create('picklists', '',false)
							   ->my->add('name',$picklistname)
							   ->my->add($picklistname,$name)
							   ->my->add('picklist_valueid',intval($current_picklist_valueid)+1)  
							   ->my->add('sequence',intval($current_sequence)+1)  
							   ->my->add('presence',$presence)
							   ->my->add('isdefault',$default);
							   
					if(isset($_REQUEST['fields']) && $_REQUEST['fields'] != '')
					{
						$fields = explode(",",trim($_REQUEST['fields'],','));
						foreach($fields as $field)
						{
							if(isset($_REQUEST[$field]) && $_REQUEST[$field] != '')
							{
								$newcontent->my->add($field,$_REQUEST[$field]);	
							}						
						}
					}	       
									  
					$newcontent->save("Picklists");
			}
			
	}
}
function updateFieldProperties(){	
	$record = $_REQUEST['record'];
	$fields = XN_Query::create ( 'Content' )->tag ( 'Fields' )
				->filter ( 'type', 'eic', 'fields' )
				->filter ( 'my.fieldid', '=', $record )
				->execute ();
	if (count($fields) > 0 )
	{
			$field_info = $fields[0];
			$picklistname = $field_info->my->fieldname;
			
			$picklists = XN_Query::create ( 'Content' )->tag ( 'Picklists' )
							      ->filter ( 'type', 'eic', 'picklists' )
							      ->filter ( 'my.name', '=', $picklistname )
							      ->filter ( 'my.picklist_valueid', '=', $_REQUEST['picklistid'] )
							      ->execute();			
			if (count($picklists) >0 ){
				 $picklist_info = $picklists[0];
				 $current_sequence = $picklist_info->my->sequence;
				 $current_name = $picklist_info->my->$picklistname;
				 $current_picklist_valueid = $picklist_info->my->picklist_valueid;
				 $current_default = $picklist_info->my->isdefault;
				 $current_presence = $picklist_info->my->presence;
				 
				 $name = $_REQUEST['label'];
				 $picklist_valueid = $_REQUEST['picklistid'];
				 $default = $_REQUEST['default'];
				 $presence = $_REQUEST['enable'];

				 $picklist_info->my->presence = $presence;
				 $picklist_info->my->isdefault = $default;				 	 
				 $picklist_info->my->$picklistname = $name;
				 $remove_default_picklists = XN_Query::create ( 'Content' )->tag ( 'Picklists' )
							  ->filter ( 'type', 'eic', 'picklists' )
							  ->filter ( 'my.name', '=', $picklistname )
							   ->filter ( 'my.isdefault', '=','1' )
							  ->filter ( 'my.picklist_valueid', '!=', $picklist_valueid )
							  ->execute();
				 foreach ($remove_default_picklists as $remove_default_picklist_info)
				 {					 	
					 $remove_default_picklist_info->my->isdefault = '0';
					 $remove_default_picklist_info->save('Picklists');
				 }	
				 if(isset($_REQUEST['fields']) && $_REQUEST['fields'] != '')
				 {
					$fields = explode(",",trim($_REQUEST['fields'],','));
					foreach($fields as $field)
					{
						if(isset($_REQUEST[$field]) && $_REQUEST[$field] != '')
						{
							$picklist_info->my->$field = $_REQUEST[$field];	
						}						
					}
				 }	 
				 $picklist_info->save('Picklists');
				
			}
	}
}
function changeFieldOrder(){
	global $smarty;
	$record = $_REQUEST['record'];
	$fields = XN_Query::create ( 'Content' )->tag ( 'Fields' )
				->filter ( 'type', 'eic', 'fields' )
				->filter ( 'my.fieldid', '=', $record )
				->execute ();
	if (count($fields) > 0 )
	{
			$field_info = $fields[0];
			$picklistname = $field_info->my->fieldname;
			if(!empty($_REQUEST['what_to_do'])){	
				if($_REQUEST['what_to_do']=='down'){
					$picklists = XN_Query::create ( 'Content' )->tag ( 'Picklists' )
							      ->filter ( 'type', 'eic', 'picklists' )
							      ->filter ( 'my.name', '=', $picklistname )
							      ->filter ( 'my.picklist_valueid', '=', $_REQUEST['picklistid'] )
							      ->execute();
					if (count($picklists) >0 ){
						$picklist_info = $picklists[0];
						$current_sequence=$picklist_info->my->sequence;
						$picklists_next = XN_Query::create ( 'Content' )->tag ( 'Picklists' )
							      ->filter ( 'type', 'eic', 'picklists' )
							      ->filter ( 'my.name', '=', $picklistname )
							      ->filter ( 'my.sequence', '>', intval($current_sequence) )
							      ->order('my.sequence',XN_Order::ASC_NUMBER)
							      ->execute();
						if (count($picklists_next) >0 ){
							$picklist_next_info = $picklists_next[0];
							$next_sequence=$picklist_next_info->my->sequence;
							$picklist_info->my->sequence = $next_sequence;
							$picklist_info->save('Picklists');
							$picklist_next_info->my->sequence = $current_sequence;
							$picklist_next_info->save('Picklists');
						}
					}
				}
			    if($_REQUEST['what_to_do']=='up'){
					$picklists = XN_Query::create ( 'Content' )->tag ( 'Picklists' )
							      ->filter ( 'type', 'eic', 'picklists' )
							      ->filter ( 'my.name', '=', $picklistname )
							      ->filter ( 'my.picklist_valueid', '=', $_REQUEST['picklistid'] )
							      ->execute();
					if (count($picklists) >0 ){
						$picklist_info = $picklists[0];
						$current_sequence=$picklist_info->my->sequence;
						$picklists_next = XN_Query::create ( 'Content' )->tag ( 'Picklists' )
							      ->filter ( 'type', 'eic', 'picklists' )
							      ->filter ( 'my.name', '=', $picklistname )
							      ->filter ( 'my.sequence', '<', intval($current_sequence) )
							      ->order('my.sequence',XN_Order::DESC_NUMBER)
							      ->execute();
						if (count($picklists_next) >0 ){
							$picklist_next_info = $picklists_next[0];
							$next_sequence=$picklist_next_info->my->sequence;
							$picklist_info->my->sequence = $next_sequence;
							$picklist_info->save('Picklists');
							$picklist_next_info->my->sequence = $current_sequence;
							$picklist_next_info->save('Picklists');
						}
					}
				}
			}
	}
	
}	  

function get_Picklists($record){	
	global $fieldlabel,$tablabel,$parentlabel,$picklistname;
	try {
		//$tabsout ='<div style=" font-size: 12px;font-weight: bold;">'.getTranslatedString('LBL_MODULE', 'Settings').'</div>';

		$config_inc_file = $_SERVER['DOCUMENT_ROOT'].'/modules/PickList/config.inc.php';
		if (@file_exists($config_inc_file)) 
		{
			include($config_inc_file);
		}
		else	
		{		
			$config_picklist = array();
		}
		$fields = XN_Query::create ( 'Content' )->tag ( 'Fields' )
				->filter ( 'type', 'eic', 'fields' )
				->filter ( 'my.fieldid', '=', $record )
				->execute ();
		if (count($fields) > 0 )
		{
			$field_info = $fields[0];
			$cflist=array();
			$picklistname = $field_info->my->fieldname;
			$picklists = XN_Query::create ( 'Content' )->tag ( 'Picklists' )
					->filter ( 'type', 'eic', 'picklists' )
					->filter ( 'my.name', '=', $field_info->my->fieldname )
					->order ( 'my.sequence ', XN_Order::ASC_NUMBER )
					->execute ();
			$fieldlabel	= getTranslatedString($field_info->my->fieldlabel);	
			$tabid	= $field_info->my->tabid;
			$module = getTabModuleName($tabid);
			$tablabel = getTranslatedString( getTablabel($tabid) );
			$parentlabel = getTranslatedString( getParentTabFromModule($module));
			if (count ( $picklists ) > 0) {				
				foreach ( $picklists as $picklist_info ) {
					$linkto = 'index.php?module=PickList&amp;action=EditPickList&amp;parenttab=Settings&amp;record=' . $record;
					$name = $field_info->my->fieldname;
					$picklist_name = $picklist_info->my->$name;
					$presence = $picklist_info->my->presence;
					$isdefault = $picklist_info->my->isdefault;
					$picklist_valueid = $picklist_info->my->picklist_valueid;	
			
					if (isset($config_picklist[$picklistname]))
					{
						$temp = getTranslatedString($picklist_name).'&nbsp;&nbsp;&nbsp;[';
						foreach($config_picklist[$picklistname] as $customfield)	
						{							 
							$customfieldname = $customfield['fieldname'];
							
							$picklist[$customfieldname] = $picklist_info->my->$customfieldname; 
							
							if (isset($customfieldname) && !is_null($picklist_info->my->$customfieldname))
							{
								$temp .= $customfield['label'].':'.$picklist_info->my->$customfieldname.",";
							}
						}
						$temp = trim($temp,',');
						$temp .= ']';
						$picklist['picklistlabel'] = $temp;		
						$picklist['picklistname'] = getTranslatedString($picklist_name);				
						
					}
					else 
					{
						$picklist['picklistlabel'] = getTranslatedString($picklist_name);
						$picklist['picklistname'] = getTranslatedString($picklist_name);
					}
					$picklist['picklist_valueid'] = $picklist_valueid;
					$picklist['presence'] = $presence;
					$picklist['isdefault'] = $isdefault;
					$picklist['record'] = $record;
					$cflist[] = $picklist;	
					}
			}			
			return $cflist;
		}
		else 
		{
			echo '<div style=" font-size: 12px;font-weight: bold;">error record!</div>';
			exit();			
		}	
	} catch ( XN_Exception $e ) {
		echo '<div style=" font-size: 12px;font-weight: bold;">'.$e->getMessage ().'</div>';
		exit();	
	}	
}


function get_profile_Picklists($record,$tabid,$userlist)
{	
	global $fieldlabel,$tablabel,$parentlabel,$picklistname;
	global $select_profiles;
	try {
		//$tabsout ='<div style=" font-size: 12px;font-weight: bold;">'.getTranslatedString('LBL_MODULE', 'Settings').'</div>';

		$select_profiles = array();
		$fields = XN_Query::create ( 'Content' )->tag ( 'Fields' )
				->filter ( 'type', 'eic', 'fields' )
				->filter ( 'my.fieldid', '=', $record )
				->execute ();
		if (count($fields) > 0 )
		{
			$field_info = $fields[0];
			$cflist=array();
			$picklistname = $field_info->my->fieldname;
			$picklists = XN_Query::create ( 'Content' )->tag ( 'Picklists' )
					->filter ( 'type', 'eic', 'picklists' )
					->filter ( 'my.name', '=', $field_info->my->fieldname )
				    ->filter ( 'my.tabid', '=', $tabid )
					->order ( 'my.sequence ', XN_Order::ASC_NUMBER )
					->execute ();
			$fieldlabel	= getTranslatedString($field_info->my->fieldlabel);	
			$tabid	= $field_info->my->tabid;
			$module = getTabModuleName($tabid);
			$tablabel = getTranslatedString( getTablabel($tabid) );
			$parentlabel = getTranslatedString( getParentTabFromModule($module));
			if (count ( $picklists ) > 0) {				
				foreach ( $picklists as $picklist_info ) {
					$linkto = 'index.php?module=PickList&amp;action=EditPickList&amp;parenttab=Settings&amp;record=' . $record;
					$name = $field_info->my->fieldname;
					$picklist_name = $picklist_info->my->$name;
					$presence = $picklist_info->my->presence;
					$isdefault = $picklist_info->my->isdefault;
					$picklist_valueid = $picklist_info->my->picklist_valueid;

					if (isset($userlist[$picklist_name]))
					{			
						$picklist['picklistlabel'] = $userlist[$picklist_name];
						$picklist['picklistname'] = getTranslatedString($picklist_name);
						$picklist['picklist_valueid'] = $picklist_valueid;
						$picklist['presence'] = $presence;
						$picklist['isdefault'] = $isdefault;
						$picklist['record'] = $record;
						$cflist[] = $picklist;	
						$select_profiles[$picklist_name] = $userlist[$picklist_name];
					}
					
				}
			}			
			return $cflist;
		}
		else 
		{
			echo '<div style=" font-size: 12px;font-weight: bold;">error record!</div>';
			exit();			
		}	
	} catch ( XN_Exception $e ) {
		echo '<div style=" font-size: 12px;font-weight: bold;">'.$e->getMessage ().'</div>';
		exit();	
	}	
}


$config_inc_file = $_SERVER['DOCUMENT_ROOT'].'/modules/PickList/config.inc.php';
if (@file_exists($config_inc_file)) 
{
	include($config_inc_file);
}
else	
{		
	$config_picklist = array();
}
$smarty->assign("CONFIG_PICKLIST",$config_picklist);

//$smarty->assign("PROFILE_PICKLIST",$config_profile_picklist);

$fields = XN_Query::create ( 'Content' )->tag ( 'Fields' )
				->filter ( 'type', 'eic', 'fields' )
				->filter ( 'my.fieldid', '=', $record )
				->execute ();
if (count($fields) > 0 )
{
	  $field_info = $fields[0];
	  $tabid = $field_info->my->tabid;
	  $fieldname = $field_info->my->fieldname;
	  $tabname = getModule($tabid);

	  if (array_key_exists($tabname,$config_profile_picklist) )
	  {
		   if (in_array($fieldname,$config_profile_picklist[$tabname]) )
		   {
				$profile_picklist = $config_profile_picklist[$tabname];		
				$users = XN_Query::create('Content')->tag('users')->filter('type','eic','users')->filter ( 'my.status', '=', 'Active' )->filter ( 'my.deleted', '=', '0' )->order('my.sequence',XN_Order::ASC_NUMBER)->execute();
				$userlist = array();
				foreach ($users as $user) 
				{
					$userlist[$user->my->profileid] = $user->my->last_name;
				}
				
				global $select_profiles;
				$smarty->assign("PICKLISTS",get_profile_Picklists($record,$tabid,$userlist));
				$smarty->assign("PROFILES",array_diff($userlist,$select_profiles));	
				$smarty->assign("PROFILE_PICKLIST",'true');
		  }
		  else
		  {
			 $smarty->assign("PICKLISTS",get_Picklists($record));
		  }
	  }
	  else
	  {
		 $smarty->assign("PICKLISTS",get_Picklists($record));
	  }
}


$smarty->assign("RECORD",$record);
//$smarty->assign("PICKLISTS",get_Picklists($record));
//$smarty->assign("FIELDLABEL",'aaaaa');
$smarty->assign("PICKLISTNAME",$picklistname);
$smarty->assign("FIELDLABEL",$fieldlabel);
$smarty->assign("TABLABEL",$tablabel);
$smarty->assign("PARENTLABEL",$parentlabel);

if($_REQUEST['ajax'] != 'true'){
	$smarty->display("modules/PickList/EditPickList.tpl");
}else{
	$smarty->display("modules/PickList/EditPickListContents.tpl");
}


?>

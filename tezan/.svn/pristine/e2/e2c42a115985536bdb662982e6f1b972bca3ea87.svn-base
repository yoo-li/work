<?php
/*+********************************************************************************
 * The contents of this file are subject to the 361CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  361CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *********************************************************************************/
 

/** 
 * Function to get modules which has picklist values  
 * It gets the picklist modules and return in an array in the following format 
 * $modules = Array($tabid=>$tablabel,$tabid1=>$tablabel1,$tabid2=>$tablabel2,-------------,$tabidn=>$tablabeln)	
 */
function getPickListModules(){

	$fields_query = XN_Query::create ( 'Content' )->tag ( 'Fields' )
					      ->filter ( 'type', 'eic', 'fields' )
						  ->filter ( 'my.tabid', '!=', '29' )
						  ->filter ( 'my.presence', 'in', array('0','2') )
						  ->filter ( 'my.uitype', 'in', array('15','33') )
						  ->begin(0)->end(-1)
					      ->order('my.tabid',XN_Order::ASC_NUMBER);
	$fields = $fields_query->execute();				     
    $tabids = array();
    foreach ($fields as $field_info)
    {
    	if (!in_array($field_info->my->tabid,$tabids))
    	{
    		$tabids[]=$field_info->my->tabid;
    	}    	
    }				     
	$tabs_query = XN_Query::create ( 'Content' )->tag ( 'Tabs' )
					      ->filter ( 'type', 'eic', 'tabs' )
						  ->filter ( 'my.tabid', 'in', $tabids );
	$tabs = $tabs_query->execute();
	$modules = array();
	foreach ($tabs as $tab_info){
		$modules[$tab_info->my->tablabel] = $tab_info->my->tabname;
	}
	return $modules;
}
 

/**
 * this function returns the picklists available for a module
 * @param array $picklist_details - the details about the picklists in the module
 * @return array $module_pick - the picklists present in the module in an array format
 */
function get_available_module_picklist($picklist_details){
	$avail_pick_values = $picklist_details;
	foreach($avail_pick_values as $key => $val){
		$module_pick[$avail_pick_values[$key]['fieldname']] = getTranslatedString($avail_pick_values[$key]['fieldlabel']);
	}
	return $module_pick;	
}
 

/**
 * this function returns all the assigned picklist values for the given tablename for the given roleid
 * @param string $tableName - the picklist tablename
 * @param integer $roleid - the roleid of the role for which you want data
 * @param object $adb - the peardatabase object
 * @return array $val - the assigned picklist values in array format
 */
function getAssignedPicklistValues($tableName){
    global $picklistcaches;
	if (isset($picklistcaches[$tableName]))
	{
		return $picklistcaches[$tableName];
	}
	else
	{

			$query = XN_Query::create ( 'Content' ) ->tag('Picklists')
				->filter ( 'type', 'eic', 'picklists')
				->filter ( 'my.name', '=', $tableName)
				->order ('my.sequence',XN_Order::ASC_NUMBER)
				->begin(0)->end(-1)
				->execute();
 
	 
		foreach($query as $info){
			$arr[$info->my->picklist_valueid] = $info->my->$tableName;
		}
		$picklistcaches[$tableName] = $arr;
		return $arr;
	}
	
}

function getPicklistByName($name) {

		$query = XN_Query::create ( 'Content' ) ->tag('Picklists')
			->filter ( 'type', 'eic', 'picklists')
			->filter ( 'my.name', 'eic', $name)
			->filter ( "my.$name",'neic','--none--')
			->order  ( 'my.sequence',XN_Order::ASC_NUMBER)
			->begin(0)->end(-1)
			->execute();
 
	$arr = array();
	foreach($query as $info) {
		$arr[$info->my->picklist_valueid] = $info->my->$name;
	}
	return $arr;
}

function getTranslatePicklistByName($name) {
 
	$query = XN_Query::create ( 'Content' ) ->tag('Picklists')
		->filter ( 'type', 'eic', 'picklists')
		->filter ( 'my.name', 'eic', $name)
		->filter("my.$name",'neic','--none--')
		->order ('my.sequence',XN_Order::ASC_NUMBER)
		->begin(0)->end(-1)
		->execute();
 
    $arr = array();

	foreach($query as $info) {
		$arr[$info->my->$name] = getTranslatedString($info->my->$name);
	}
	return $arr;
}

function getAreaPicklists($fieldname,$parentnode) {
	$query = XN_Query::create ( 'SimpleContent' ) ->tag('picklists')
		->filter ('type','eic','picklists')
		->filter ('my.name','=',$fieldname)
		->filter('my.parentnode','eic',$parentnode)
		->order ('my.sequence',XN_Order::ASC_NUMBER)
		->begin(0)->end(-1)
		->execute();
	foreach($query as $info){
		$arr[] = $info->my->$fieldname;
	}
	if(!empty($arr)){
		array_unshift($arr,"LBL_".strtoupper($fieldname)."_NONE");
	}
	return $arr;
}

function getAreaPicklistValues($tableName){
	$query = XN_Query::create ( 'SimpleContent' ) ->tag('Picklists')
		->filter ( 'type', 'eic', 'picklists')
		->filter ( 'my.name', '=', $tableName)
		->order ('my.sequence',XN_Order::ASC_NUMBER)
		->begin(0)->end(-1)
		->execute();
	foreach($query as $info){
		$arr[] = array($info->id,$info->my->$tableName);
	}
	return $arr;
}
function getAreaPicklistValuesByID($ID){
	try{
		$querybyid = XN_Content::load($ID,'Picklists',3);
		$parentid = $querybyid->my->parentid;
		$query = XN_Query::create ( 'SimpleContent' ) ->tag('Picklists')
			->filter ( 'type', 'eic', 'picklists')
			->filter ( 'my.parentid', '=', $parentid)
			->filter ( 'my.type', 'eic', 'area')
			->order ('my.sequence',XN_Order::ASC_NUMBER)
			->begin(0)->end(-1)
			->execute();
		foreach($query as $info){
			$arr[] = array($info->id,$info->my->name);
		}
		if(!empty($arr)){
			array_unshift($arr,array(-1,'--None--'));
		}
	}catch (Exception $e) {

	}
	return $arr;
}

function getAreaPicklistValuesByParentId($id){
	try{
		$query = XN_Query::create ( 'SimpleContent' ) ->tag('Picklists')
			->filter ( 'type', 'eic', 'picklists')
			->filter ( 'my.parentid', '=', $id)
			->filter ( 'my.type', 'eic', 'area')
			->order ('my.sequence',XN_Order::ASC_NUMBER)
			->begin(0)->end(-1)
			->execute();
		foreach($query as $info){
			$arr[] = array($info->id,$info->my->name);
		}
		if(!empty($arr)){
			array_unshift($arr,array(-1,'--None--'));
		}
	}catch (Exception $e) {
		
	}
	return $arr;
}
?>

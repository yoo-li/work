<?php 
 	
function getModule($tabid)
{ 
	global $cache_tabs;
	if (!isset($cache_tabs))
	{
		$cache_tabs = array();
	} 
	if (isset($cache_tabs[$tabid]) && $cache_tabs[$tabid] != "")
	{
		return $cache_tabs[$tabid];
	} 
	$tabs = XN_Query::create("Content")
					 ->tag("tabs")
					 ->filter("type", "eic", "tabs")
					 ->filter("my.tabid", "=", $tabid)
					 ->end(1)
					 ->execute();
	if (count($tabs))
	{
		$tab_info = $tabs[0];
		$cache_tabs[$tabid] = $tab_info->my->tabname;
		return $tab_info->my->tabname;
	}
	else
	{
		return 0;
	}
	 
}

function getUserNameByProfile($profileid)
{
	global $cache_usernames;
	if (!isset($cache_usernames))
	{
		$cache_usernames = array();
	} 
	if (isset($cache_usernames[$profileid]) && $cache_usernames[$profileid] != "")
	{
		return $cache_usernames[$profileid];
	}  
	$users = XN_Query::create('Content')->tag('users')
					 ->filter('type', 'eic', 'users')
					 ->filter('my.profileid', '=', $profileid)
				     ->end(-1)
				     ->execute();
	if (count($users) > 0)
	{
		$user_info = $users[0];
		$givename = $user_info->my->givename;
		if (isset($givename) && $givename != "")
		{
			$cache_usernames[$profileid] = $givename;
			return $givename;
		}
		else
		{
			$cache_usernames[$profileid] = $user_info->my->last_name;
			return $user_info->my->last_name;
		}
	} 
	return ""; 
}

function getModuleBaseInfo($record, $tabid)
{
	$module = getModule($tabid); 
	$baseinfo = array();
    $field_contents = XN_Query::create('Content')->tag('fields')
        ->filter('type', 'eic', 'fields')
        ->filter('my.tabid', '=', $tabid)
	    ->filter('my.uitype', '!=', '10')
        ->filter('my.presence', 'in', array ('0', '2'))
        ->filter('my.displaytype', 'in', array ('1', '6'))
		->order('my.sequence', XN_Order::ASC_NUMBER)
	    ->end(-1)
	    ->execute();
		
	$fields = array();	
	$picklistkeys = array();	
    foreach ($field_contents as $field_info)
    {
		$fieldid = $field_info->my->fieldid; 
        $fieldname = $field_info->my->fieldname; 
		$fieldlabel = $field_info->my->fieldlabel;  
        $uitype = $field_info->my->uitype;	
		$fields[$fieldid]['fieldname'] = $fieldname;
		$fields[$fieldid]['fieldlabel'] = $fieldlabel;
		$fields[$fieldid]['uitype'] = $uitype;
		if (in_array($uitype,array("33","116")))
		{
			$picklistkeys[] = $fieldname;
		}
	}
	$picklists = array();	
	if (count($picklistkeys) > 0)
	{
	   $picklist_contents = XN_Query::create ( 'Content' ) ->tag('picklists')
			->filter ( 'type', 'eic', 'picklists')
			->filter ( 'my.name', 'in', $picklistkeys) 
			->order  ( 'my.sequence',XN_Order::ASC_NUMBER)
			->end(-1)
			->execute();  
		foreach($picklist_contents as $picklist_info) 
		{
			$name = $picklist_info->my->name;
			$translatedname = $picklist_info->my->$name; 
			$picklists[$name][$picklist_info->my->picklist_valueid] = getTranslatedString($translatedname, $module);
		}
	}
	$loadcontent = XN_Content::load($record,strtolower($module));
	$pos = 1;
	foreach($fields as $field_info)
	{
        $fieldname = $field_info['fieldname']; 
		$fieldlabel = $field_info['fieldlabel'];  
        $uitype = $field_info['uitype'];	
		$value = $loadcontent->my->$fieldname;
		if (isset($value) && $value != "")
		{
			if (in_array($uitype,array("33","116")))
			{
				$baseinfo[$pos]['fieldname'] = $fieldname;
				$baseinfo[$pos]['fieldlabel'] = $fieldlabel;
				$baseinfo[$pos]['translatedfieldlabel'] = getTranslatedString($fieldlabel, $module);
				$baseinfo[$pos]['value'] = $picklists[$fieldname][$value]; 
			}
			else if ($uitype == '305' || $uitype == '307' )
			{
				$baseinfo[$pos]['fieldname'] = $fieldname;
				$baseinfo[$pos]['fieldlabel'] = $fieldlabel;
				$baseinfo[$pos]['translatedfieldlabel'] = getTranslatedString($fieldlabel, $module);
				$baseinfo[$pos]['value'] = '<img class="img-responsive" src="'.$value.'">';
				$baseinfo[$pos]['type'] = 'img';
			}
			else if ($uitype == '20')
			{
				$baseinfo[$pos]['fieldname'] = $fieldname;
				$baseinfo[$pos]['fieldlabel'] = $fieldlabel;
				$baseinfo[$pos]['translatedfieldlabel'] = getTranslatedString($fieldlabel, $module);
				$baseinfo[$pos]['value'] = $value; 
				$baseinfo[$pos]['type'] = 'desc';
			}
			else
			{
				$baseinfo[$pos]['fieldname'] = $fieldname;
				$baseinfo[$pos]['fieldlabel'] = $fieldlabel;
				$baseinfo[$pos]['translatedfieldlabel'] = getTranslatedString($fieldlabel, $module);
				$baseinfo[$pos]['value'] = $value; 
			}
			$pos ++;
		} 
	}
	return $baseinfo; 
}
<?php
/*+********************************************************************************
 * The contents of this file are subject to the 361CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  361CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ********************************************************************************/

require_once('Smarty_setup.php');
require_once('include/utils/UserInfoUtil.php');
require_once('include/utils/utils.php');

global $mod_strings,$app_strings,$theme;

$smarty=new vtigerCRM_Smarty;

$subMode = $_REQUEST['sub_mode'];
$smarty->assign("MOD",$mod_strings);
$smarty->assign("APP",$app_strings);

$smarty->assign("PARENT",$_REQUEST['parentmodule']);

if ($subMode == 'updateFieldProperties')
	updateFieldProperties();
elseif($subMode == 'deleteCustomField')
	deleteCustomField();
elseif($subMode == 'changeOrder')
	changeFieldOrder();
elseif($subMode == 'addBlock')
	$duplicate = addblock();
elseif($subMode == 'deleteCustomBlock')
	deleteBlock();
elseif($subMode == 'addCustomField')
	$duplicate = addCustomField();
elseif($subMode == 'movehiddenfields' || $subMode == 'showhiddenfields')
	show_move_hiddenfields($subMode);
elseif($subMode == 'changeRelatedInfoOrder')
	changeRelatedListOrder();
	
$smarty->assign("THEME", $theme);


$module_array=getCustomFieldSupportedModules();

$cfimagecombo = Array(
	$image_path."text.gif",
	$image_path."number.gif",
	$image_path."percent.gif",
	$image_path."currency.gif",
	$image_path."date.gif",
	$image_path."email.gif",
	$image_path."phone.gif",
	$image_path."picklist.gif",
	$image_path."url.gif",
	$image_path."checkbox.gif",
	$image_path."text.gif",
	$image_path."picklist.gif"
	);

$cftextcombo = Array(
	$mod_strings['Text'],
	$mod_strings['Number'],
	$mod_strings['Percent'],
	$mod_strings['Currency'],
	$mod_strings['Date'],
	$mod_strings['Email'],
	$mod_strings['Phone'],
	$mod_strings['PickList'],
	$mod_strings['LBL_URL'],
	$mod_strings['LBL_CHECK_BOX'],
	$mod_strings['LBL_TEXT_AREA'],
	$mod_strings['LBL_MULTISELECT_COMBO']
	);
	

	
$smarty->assign("MODULES",$module_array);
$smarty->assign("CFTEXTCOMBO",$cftextcombo);
$smarty->assign("CFIMAGECOMBO",$cfimagecombo);


if (isset($_REQUEST['fld_module']) && $_REQUEST['fld_module'] != "")
{
	$fld_module = $_REQUEST['fld_module'];
}
elseif (isset($_REQUEST['formodule']) && $_REQUEST['formodule'] != "")
{
	$fld_module = $_REQUEST['formodule'];
}
else
{
	/*$parenttabs = XN_Query::create ( 'Content' )->tag ( 'Parenttabs' )
				    ->filter ( 'type', 'eic', 'parenttabs' )
					->filter ( 'my.parenttabname', '=', $_REQUEST['parentmodule'] )
				    ->execute ();
		
		if (count($parenttabs) > 0)
		{
			$parenttab_info = $parenttabs[0];
			$tabname  = $parenttab_info->my->tabname;
			$parenttabs = XN_Query::create ( 'Content' )->tag ( 'Parenttabs' )
				    ->filter ( 'type', 'eic', 'parenttabs' )
					->filter ( 'my.parenttabname', '=', $_REQUEST['parentmodule'] )
				    ->execute ();
		}
		else
		{
			$fld_module = 'Accounts';
		}*/
	if (isset($_REQUEST['parentmodule']) && $_REQUEST['parentmodule'] != "")
	{
		global $global_session; 
		$parent_tabdata  = $global_session['parent_tabdata'];
        $parent_tab_info_array=$parent_tabdata['parent_tab_info_array'];
        $all_parent_tab_info_array=$parent_tabdata['all_parent_tab_info_array'];
        $parent_child_tab_rel_array=$parent_tabdata['parent_child_tab_rel_array'];
        $all_parent_child_tab_rel_array=$parent_tabdata['all_parent_child_tab_rel_array'];
        
		$parentmodule = $_REQUEST['parentmodule'];
		
		if (isset($parent_child_tab_rel_array[$parentmodule]) && is_array($parent_child_tab_rel_array[$parentmodule]))
		{
			$alltabs = $parent_child_tab_rel_array[$parentmodule];
			$fld_module = $alltabs[0];
		}
		else
		{
			$fld_module = 'Announcements';
		}	
	}
	else
	{
		$fld_module = 'Announcements';
	}
	
}

$field_query = XN_Query::create ( 'Content' )->tag ( 'Fields' )
	      ->filter ( 'type', 'eic', 'fields' )
	      ->filter ( 'my.tabid', '=',getTabid($fld_module) )
		  ->filter ( 'my.presence', 'in', array('0','2') )
		  ->filter ( 'my.displaytype', '!=','2' )		  
	      ->order('my.sequence',XN_Order::ASC_NUMBER);	
$fields = $field_query->execute();
if (count($fields) > 0)
{
	$sequence = 1;
	foreach($fields as $field_info)
	{
		if ($field_info->my->sequence != $sequence)
		{			
			$field_info->my->sequence = $sequence;
			$field_info->save('fields');
		}
		$sequence += 1;
	}	
}
$sequence += 10;
$field_query = XN_Query::create ( 'Content' )->tag ( 'Fields' )
	      ->filter ( 'type', 'eic', 'fields' )
	      ->filter ( 'my.tabid', '=',getTabid($fld_module) )
		  ->filter ( 'my.presence', 'in', array('0','2') )
		  ->filter ( 'my.displaytype', '=','2' )
	      ->order('my.sequence',XN_Order::ASC_NUMBER);	
$fields = $field_query->execute();
if (count($fields) > 0)
{
	foreach($fields as $field_info)
	{
		if ($field_info->my->sequence != $sequence)
		{			
			$field_info->my->sequence = $sequence;
			$field_info->save('fields');
		}
		$sequence += 1;
	}	
}


//echo '__________'.$fld_module.'_________________';
$block_array = getModuleBlocks($fld_module);

$smarty->assign("BLOCKS",$block_array);

$smarty->assign("FORMMODULE", $fld_module);
$smarty->assign("MODULE", $fld_module);

$parentmodule = getParentTabFromModule($fld_module);
$smarty->assign("PARENTMODULE",$parentmodule);

$smarty->assign("CFENTRIES",getFieldListEntries($fld_module));
$smarty->assign("RELATEDLIST",getRelatedListInfo($fld_module));


if($_REQUEST['mode'] !='')
	$mode = $_REQUEST['mode'];
	
$smarty->assign("MODE", $mode);

$smarty->assign("TOGGLE_MODINFO", vtlib_getToggleParentModuleInfo($parentmodule));


$header_array = array();
	$tabs = XN_Query::create ( 'Content' )->tag ( 'parenttabs' )
					->filter ( 'type', 'eic', 'parenttabs' )
					->filter ( 'my.presence', '=', '0')
					->order("my.sequence",XN_Order::ASC)
					->execute ();
	if (count($tabs) >0)
	{
		foreach($tabs as $tab_info)
		{
			if ($tab_info->my->parenttabname != "Settings" && $tab_info->my->parenttabname != "Tools")
			{
				$header_array[] = $tab_info->my->parenttabname;
			}
		}
	}		

$smarty->assign("HEADERS",$header_array);


if($_REQUEST['ajax'] != 'true'){
	
	$smarty->display('Settings/ModuleLayout.tpl');
}	
elseif(($subMode == 'getRelatedInfoOrder' || $subMode == 'changeRelatedInfoOrder') &&  $_REQUEST['ajax'] == 'true'){
	$smarty->display('Settings/OrderRelatedList.tpl');
}
else{
	$smarty->display('Settings/LayoutBlockEntries.tpl');
}


function InStrCount($String,$Find,$CaseSensitive = false) {
	
	$i=0;
    $x=0;
    $substring = '';
	while (strlen($String)>=$i) {
		unset($substring);
		if ($CaseSensitive) {
			$Find=strtolower($Find);
      		$String=strtolower($String);
     	}
     	$substring=substr($String,$i,strlen($Find));
     	if ($substring==$Find) $x++;
     	$i++;
	}
	
	return $x;
}


/**
* Function to get customfield entries
* @param string $module - Module name
* return array  $cflist - customfield entries
*/	
function getFieldListEntries($module)
{
	$tabid = getTabid($module);
	global $adb, $smarty,$log;
	global $theme;
	$theme_path="themes/".$theme."/";
	$image_path="themes/images/";
	
	/*$dbQuery = "select vtiger_blocks.*,vtiger_tab.presence as tabpresence  from vtiger_blocks" .
				" inner join vtiger_tab on vtiger_tab.tabid = vtiger_blocks.tabid" .
				" where vtiger_blocks.tabid=?  and vtiger_tab.presence = 0 order by sequence";*/
	
	$tabs = XN_Query::create ( 'Content' )->tag ( 'Tabs' )
			->filter ( 'type', 'eic', 'tabs' )
			->filter ( 'my.tabid', '=', $tabid )
			->filter ( 'my.presence', '=', '0' )
			->end(-1)
			->execute ();
			
	if (count($tabs) == 0 )	return Array();	
	
	$blocks = XN_Query::create ( 'Content' )->tag ( 'Blocks' )
			->filter ( 'type', 'eic', 'blocks' )
			->filter ( 'my.tabid', '=', $tabid )
			->order('my.sequence',XN_Order::ASC_NUMBER)
			->execute ();
			
	$focus = CRMEntity::getInstance($module);
	$nonEditableUiTypes = array('4','70');	
	$cflist=Array();
	$i=0;
	
	foreach($blocks as $block_info){
		    $blocklabel = $block_info->my->blocklabel;
		    $blockid = $block_info->my->blockid;
		    $presence = '0';
		    $display_status = $block_info->my->display_status;
		    $sequence = $block_info->my->sequence;
		    $iscustom = $block_info->my->iscustom;
		    
			if($blocklabel == 'LBL_CUSTOM_INFORMATION' )
			{
				$smarty->assign("CUSTOMSECTIONID",$blockid);
			}
			if($blocklabel == 'LBL_RELATED_PRODUCTS' )
			{
				$smarty->assign("RELPRODUCTSECTIONID",$blockid);
			}
			if($blocklabel == 'LBL_COMMENTS' || $blocklabel == 'LBL_COMMENT_INFORMATION' )
			{
				$smarty->assign("COMMENTSECTIONID",$blockid);
			}
			if($blocklabel == 'LBL_TICKET_RESOLUTION'){
				$smarty->assign("SOLUTIONBLOCKID",$blockid);
			}
			if($blocklabel == ''){
				continue;
			}
			$cflist[$i]['tabpresence']= $presence;
			$cflist[$i]['module'] = $module;
			$cflist[$i]['blocklabel']=getTranslatedString($blocklabel, $module);
			$cflist[$i]['blockid']=$blockid;
			$cflist[$i]['display_status']=$display_status;
			$cflist[$i]['tabid']=$tabid;
			$cflist[$i]['blockselect']=$blockid;
			$cflist[$i]['sequence'] = $sequence;
			$cflist[$i]['iscustom'] = $iscustom;
			
			
			$field_query = XN_Query::create ( 'Content' )->tag ( 'Fields' )
				      ->filter ( 'type', 'eic', 'fields' )
				      ->filter ( 'my.tabid', '=', $tabid )
					  ->filter ( 'my.uitype', '!=',  '4' )
					  ->filter ( 'my.uitype', '!=',  '35' )
				      ->filter ( 'my.block', '=', $blockid )
				      ->order('my.sequence',XN_Order::ASC_NUMBER);
			if($module!='Invoices' && $module!='Quotes' && $module!='SalesOrder' && $module!='Invoice')
			{ 
				$field_query->filter ( 'my.displaytype', 'in', array('1','2','4') );
			}else
			{
				$field_query->filter ( 'my.displaytype', 'in', array('1','2','4') )
				       ->filter ( 'my.fieldlabel', '!=',  'Total' )
				       ->filter ( 'my.fieldlabel', '!=',  'Sub Total' )
				       ->filter ( 'my.fieldlabel', '!=',  'Tax' );
			}
			$fields = $field_query->execute();
			if (count($fields) > 0)
			{
				$cf_element=Array();
				$cf_hidden_element=Array();
			 	$count=0;
			 	$hiddencount=0;
			 	foreach($fields as $field_info){
			 		$fieldid = $field_info->my->fieldid;
					$presence = $field_info->my->presence;
					$fieldname = $field_info->my->fieldname;
					$customfieldflag=InStrCount($field_info->my->fieldname,'cf_',true);
					$quickcreate = $field_info->my->quickcreate;
					$massedit = $field_info->my->masseditable;
					$typeofdata = $field_info->my->typeofdata;
					$displaytype = $field_info->my->displaytype;
					$uitype = $field_info->my->uitype;
					
					$merge_column = $field_info->my->merge_column;
					$deputy_column = $field_info->my->deputy_column;
					$show_title = $field_info->my->show_title;
					
					
			
					$fld_type_name = getCustomFieldTypeName($field_info->my->uitype);
					
					$fieldlabel = getTranslatedString($field_info->my->fieldlabel, $module);
					
					$strictlyMandatory = false;
					if(isset($focus->mandatory_fields) && (!empty($focus->mandatory_fields)) && in_array($fieldname, $focus->mandatory_fields)){
						$strictlyMandatory = true;
					} elseif (in_array($uitype, $nonEditableUiTypes) || $displaytype == 2) {
						$strictlyMandatory = true;
					}
					$visibility = getFieldInfo($fieldname,$typeofdata,$quickcreate,$massedit,$presence,$strictlyMandatory,$customfieldflag,$displaytype,$uitype);
					
					if ($presence == 0 || $presence == 2) {
						$cf_element[$count]['fieldselect']=$fieldid;
						$cf_element[$count]['blockid']=$blockid;
						$cf_element[$count]['tabid']=$tabid;
						$cf_element[$count]['no']=$count;					
						$cf_element[$count]['label']=$fieldlabel;					
						$cf_element[$count]['fieldlabel'] = $field_info->my->fieldlabel;
						$cf_element[$count]['type']=$fld_type_name;
						$cf_element[$count]['uitype']=$uitype;
						$cf_element[$count]['sequence'] = $field_info->my->sequence;
						$cf_element[$count]['merge_column']=$merge_column;
						$cf_element[$count]['deputy_column']=$deputy_column;
						$cf_element[$count]['show_title']=$show_title;						
						$cf_element[$count]['columnname']=$field_info->my->columnname;	
						$cf_element[$count]['width']=$field_info->my->width;	
						$cf_element[$count]['align']=$field_info->my->align;					
						$cf_element[$count] = array_merge($cf_element[$count], $visibility);
						
						$count++;
					} else {
						$cf_hidden_element[$hiddencount]['fieldselect']=$fieldid;
						$cf_hidden_element[$hiddencount]['blockid']=$blockid;
						$cf_hidden_element[$hiddencount]['tabid']=$tabid;
						$cf_hidden_element[$hiddencount]['no']=$hiddencount;					
						$cf_hidden_element[$hiddencount]['label']=$fieldlabel;					
						$cf_hidden_element[$hiddencount]['fieldlabel'] = $field_info->my->fieldlabel;
						$cf_hidden_element[$hiddencount]['type']=$fld_type_name;
						$cf_hidden_element[$hiddencount]['uitype']=$uitype;
						$cf_hidden_element[$hiddencount]['sequence'] = $field_info->my->sequence;
						$cf_hidden_element[$hiddencount]['merge_column']=$merge_column;
						$cf_hidden_element[$hiddencount]['deputy_column']=$deputy_column;
						$cf_hidden_element[$hiddencount]['show_title']=$show_title;
						$cf_hidden_element[$hiddencount]['columnname']=$field_info->my->columnname;	
						$cf_element[$count]['width']=$field_info->my->width;	
						$cf_element[$count]['align']=$field_info->my->align;				
						$cf_hidden_element[$hiddencount] = array_merge($cf_hidden_element[$hiddencount], $visibility);
						
						$hiddencount++;						
					}					
				}
				$cflist[$i]['no']=$count;
				$cflist[$i]['hidden_count'] = $hiddencount;
			}
			else
			{
				$cflist[$i]['no']= 0;
			}
			/*$query_fields_not_in_block ='select fieldid,fieldlabel,block from vtiger_field ' .
									'inner join vtiger_blocks on vtiger_field.block=vtiger_blocks.blockid ' .
									'where vtiger_field.application = \''.$_SERVER['domain'].'\' and vtiger_field.block != ? and vtiger_blocks.blocklabel not in ("LBL_TICKET_RESOLUTION","LBL_COMMENTS","LBL_COMMENT_INFORMATION") ' .
									'AND vtiger_field.tabid = ? and vtiger_field.displaytype IN (1,2,4) order by vtiger_field.sequence';
			$params =array($row['blockid'],$tabid);	*/					
		    $blocks_not_in_block = XN_Query::create ( 'Content' )->tag ( 'Blocks' )
				->filter ( 'type', 'eic', 'blocks' )					
				->filter ( 'my.tabid', '=', $tabid )
				->execute ();
				
			$query_fields_not_in_block = $field_query = XN_Query::create ( 'Content' )->tag ( 'Fields' )
				      ->filter ( 'type', 'eic', 'fields' )
				     // ->filter ( 'my.block', '!=', $blockid )
				      ->filter ( 'my.tabid', '=', $tabid )
				      ->filter ( 'my.displaytype', 'in', array('1','2','4') )				      
				      ->order('my.sequence',XN_Order::ASC_NUMBER);
				      
			if (count($blocks_not_in_block) > 0)
			{	
				$block_not_in_block_array = array();
				foreach($blocks_not_in_block as $block_not_in_block_info){
					if ($blockid !=  $block_not_in_block_info->my->blockid)
					{
						$block_not_in_block_array[] =  $block_not_in_block_info->my->blockid;
					}
				}
				if (count($block_not_in_block_array) == 0)
				{
					$query_fields_not_in_block->filter (  'my.block', '!=', $blockid );
				}
				else 
				{
					$query_fields_not_in_block->filter ( 'my.block', 'in', $block_not_in_block_array );
				}
			}
			else 
			{
				$query_fields_not_in_block->filter (  'my.block', '!=', $blockid );
			}
			$fields_not_in_block = $query_fields_not_in_block->execute();
			if (count($fields_not_in_block) > 0 ) 
			{
				$movefields = array();
				$movefieldcount = 0;
				foreach($fields_not_in_block as $field_not_in_block_info){
					$movefields[$movefieldcount]['fieldid'] =  $field_not_in_block_info->my->fieldid;
					$movefields[$movefieldcount]['fieldlabel'] =  getTranslatedString($field_not_in_block_info->my->fieldlabel, $module);
					$movefieldcount++;
				}	
				$cflist[$i]['movefieldcount'] = $movefieldcount;
			}
			else{
				$cflist[$i]['movefieldcount'] = 0 ;	
			}  
			
			$cflist[$i]['field']= $cf_element;
			$cflist[$i]['hiddenfield']= $cf_hidden_element;
			$cflist[$i]['movefield'] = $movefields;
			
			$cflist[$i]['hascustomtable'] = $focus->customFieldTable;
			unset($cf_element);
			unset($cf_hidden_element);
			unset($movefields);
			$i++;  
	}
	return $cflist;
	 
}
 

/* function to get the modules supports Custom Fields
*/
function getCustomFieldSupportedModules()
{
	 
	$tabs = XN_Query::create ( 'Content' )->tag ( 'tabs' )
			->filter ( 'type', 'eic', 'tabs' )
			->filter ( 'my.tabname', '!=', 'Calendar' )
			->filter ( 'my.tabname', '!=', 'Emails' )
			->filter ( 'my.tabname', '!=', 'Events' )
			->filter ( 'my.tabname', '!=', 'Faq' )
			->filter ( 'my.tabname', '!=', 'Users' )
			->filter ( 'my.presence', '=', '0' )
			->end(-1)
			->execute ();
	$modulelist = array ();
	foreach ( $tabs as $tab_info ) {
		$name = $tab_info->my->tabname;
		$modulelist [$name] = $name;
	}
	return $modulelist;
}


function getModuleBlocks($module){
	global $adb;
	$tabid = getTabid($module); 
	 
    $blocks = XN_Query::create ( 'Content' )->tag ( 'Blocks' )
			->filter ( 'type', 'eic', 'blocks' )
			->filter ( 'my.tabid', '=', $tabid )
			->order ( 'my.sequence ', XN_Order::ASC_NUMBER )
			->execute ();
	$blocklist = array ();
	foreach ( $blocks as $block_info ) {
		$blockid = $block_info->my->blockid;
		$blocklabel = $block_info->my->blocklabel;
		$blocklist[$blockid] = getTranslatedString($blocklabel,$module);		
	}
	return $blocklist;
}

/**
 * 
 */
function changeFieldOrder(){
	global $adb,$smarty;
	if(!empty($_REQUEST['what_to_do'])){	
		if($_REQUEST['what_to_do']=='block_down'){
			$blocks = XN_Query::create ( 'Content' )->tag ( 'Blocks' )
					      ->filter ( 'type', 'eic', 'blocks' )
					      ->filter ( 'my.blockid', '=', $_REQUEST['blockid'] )
					      ->execute();
			if (count($blocks) >0 ){
				$block_info = $blocks[0];
				$current_sequence=$block_info->my->sequence;
				$blocks_next = XN_Query::create ( 'Content' )->tag ( 'Blocks' )
					      ->filter ( 'type', 'eic', 'blocks' )
					      ->filter ( 'my.tabid', '=', $_REQUEST['tabid'] )
					      ->filter ( 'my.sequence', '>', intval($current_sequence) )
					      ->order('my.sequence',XN_Order::ASC_NUMBER)
					      ->execute();
				if (count($blocks_next) >0 ){
					$blocks_next_info = $blocks_next[0];
					$next_sequence=$blocks_next_info->my->sequence;
					$block_info->my->sequence = $next_sequence;
					$block_info->save('Blocks');
					$blocks_next_info->my->sequence = $current_sequence;
					$blocks_next_info->save('Blocks');
				}
			}			
		}
	
		if($_REQUEST['what_to_do']=='block_up'){
			$blocks = XN_Query::create ( 'Content' )->tag ( 'Blocks' )
					      ->filter ( 'type', 'eic', 'blocks' )
					      ->filter ( 'my.blockid', '=', $_REQUEST['blockid'] )
					      ->execute();
			if (count($blocks) >0 ){
				$block_info = $blocks[0];
				$current_sequence=$block_info->my->sequence;
				$blocks_previous = XN_Query::create ( 'Content' )->tag ( 'Blocks' )
					      ->filter ( 'type', 'eic', 'blocks' )
					      ->filter ( 'my.tabid', '=', $_REQUEST['tabid'] )
					      ->filter ( 'my.sequence', '<', intval($current_sequence) )
					      ->order('my.sequence',XN_Order::DESC_NUMBER)
					      ->execute();
				if (count($blocks_previous) >0 ){
					$blocks_previous_info = $blocks_previous[0];
					$previous_sequence=$blocks_previous_info->my->sequence;
					$block_info->my->sequence = $previous_sequence;
					$block_info->save('Blocks');
					$blocks_previous_info->my->sequence = $current_sequence;
					$blocks_previous_info->save('Blocks');
				}
			}
		}
	
		if($_REQUEST['what_to_do']=='down' || $_REQUEST['what_to_do']=='Right'){
			$fields = XN_Query::create ( 'Content' )->tag ( 'Fields' )
					      ->filter ( 'type', 'eic', 'fields' )
					      ->filter ( 'my.fieldid', '=', $_REQUEST['fieldid'] )
					      ->filter ( 'my.presence', 'in', array('0','2') )
					      ->execute();
			if (count($fields) >0 ){
				$field_info = $fields[0];
				$current_sequence=$field_info->my->sequence;
				if($_REQUEST['what_to_do']=='down'){	
					$fields_next = XN_Query::create ( 'Content' )->tag ( 'Fields' )
						      ->filter ( 'type', 'eic', 'fields' )
						      ->filter ( 'my.block', '=', $_REQUEST['blockid'] )
						      ->filter ( 'my.presence', 'in', array('0','2') )
						      ->filter ( 'my.deputy_column', '=', '0' )
						      ->filter ( 'my.sequence', '>', intval($current_sequence) )
						      ->order('my.sequence',XN_Order::ASC_NUMBER)
						      ->begin(1)->end(2)
						      ->execute();
				}
				else {
					$fields_next = XN_Query::create ( 'Content' )->tag ( 'Fields' )
						      ->filter ( 'type', 'eic', 'fields' )
						      ->filter ( 'my.block', '=', $_REQUEST['blockid'] )
						      ->filter ( 'my.presence', 'in', array('0','2') )
						      ->filter ( 'my.deputy_column', '=', '0' )
						      ->filter ( 'my.sequence', '>', intval($current_sequence) )
						      ->order('my.sequence',XN_Order::ASC_NUMBER)
						      ->begin(0)->end(1)
						      ->execute();					
				}
				if (count($fields_next) >0 ){
					$field_next_info = $fields_next[0];
					$next_sequence=$field_next_info->my->sequence;
					$field_info->my->sequence = $next_sequence;
					$field_info->save('Fields');
					$field_next_info->my->sequence = $current_sequence;
					$field_next_info->save('Fields');
				}
			}
			$smarty->assign("COLORID",$_REQUEST['fieldid']);
		 
		}
	
		if($_REQUEST['what_to_do']=='up' || $_REQUEST['what_to_do']=='Left'){
			$fields = XN_Query::create ( 'Content' )->tag ( 'Fields' )
					      ->filter ( 'type', 'eic', 'fields' )
					      ->filter ( 'my.fieldid', '=', $_REQUEST['fieldid'] )
					      ->filter ( 'my.presence', 'in', array('0','2') )
					      ->execute();
			if (count($fields) >0 ){
				$field_info = $fields[0];
				$current_sequence=$field_info->my->sequence;
				if($_REQUEST['what_to_do']=='up'){	
					$fields_next = XN_Query::create ( 'Content' )->tag ( 'Fields' )
						      ->filter ( 'type', 'eic', 'fields' )
						      ->filter ( 'my.block', '=', $_REQUEST['blockid'] )
						      ->filter ( 'my.presence', 'in', array('0','2') )
						      ->filter ( 'my.sequence', '<', intval($current_sequence) )
						      ->order('my.sequence',XN_Order::DESC_NUMBER)
						      ->begin(1)->end(2)
						      ->execute();
				}
				else {
					$fields_next = XN_Query::create ( 'Content' )->tag ( 'Fields' )
						      ->filter ( 'type', 'eic', 'fields' )
						      ->filter ( 'my.block', '=', $_REQUEST['blockid'] )
						      ->filter ( 'my.presence', 'in', array('0','2') )
						      ->filter ( 'my.sequence', '<', intval($current_sequence) )
						      ->order('my.sequence',XN_Order::DESC_NUMBER)
						      ->begin(0)->end(1)
						      ->execute();					
				}
				if (count($fields_next) >0 ){
					$field_next_info = $fields_next[0];
					$next_sequence=$field_next_info->my->sequence;
					$field_info->my->sequence = $next_sequence;
					$field_info->save('Fields');
					$field_next_info->my->sequence = $current_sequence;
					$field_next_info->save('Fields');
				}
			}
			$smarty->assign("COLORID",$_REQUEST['fieldid']);
			 
		}
	
		if($_REQUEST['what_to_do']=='show'){ 
			$blocks = XN_Query::create ( 'Content' )->tag ( 'Blocks' )
					      ->filter ( 'type', 'eic', 'blocks' )
					      ->filter ( 'my.blockid', '=', $_REQUEST['blockid'] )
					      ->execute();
			if (count($blocks) >0 ){
				$block_info = $blocks[0];
				$block_info->my->display_status = '1';
				$block_info->save('Blocks');
			}
		}
	
		if($_REQUEST['what_to_do']=='hide'){ 
			$blocks = XN_Query::create ( 'Content' )->tag ( 'Blocks' )
					      ->filter ( 'type', 'eic', 'blocks' )
					      ->filter ( 'my.blockid', '=', $_REQUEST['blockid'] )
					      ->execute();
			if (count($blocks) >0 ){
				$block_info = $blocks[0];
				$block_info->my->display_status = '0';
				$block_info->save('Blocks');
			}
		}
	}
}
/**
 * 
 */
function getFieldInfo($fieldname,$typeofdata,$quickcreate,$massedit,$presence,$strictlyMandatory,$customfieldflag,$displaytype,$uitype){
	

	$fieldtype =  explode("~",$typeofdata);
		
	if($strictlyMandatory){//fields without which the CRM Record will be inconsistent
		$mandatory = '0';
	}elseif($fieldtype[1] == "M"){//fields which are made mandatory
		$mandatory = '2';
	}else{
		$mandatory = '1'; //fields not mandatory
	}
	if ($uitype == 4 || $displaytype == 2) {
		$mandatory = '3';
	}
	
	
	$visibility = array();
	$visibility['mandatory']	= $mandatory;
	$visibility['quickcreate']	= $quickcreate;
	$visibility['presence']		= $presence;
	$visibility['massedit']		= $massedit;
	$visibility['displaytype']	= $displaytype;
	$visibility['customfieldflag'] = $customfieldflag;
	$visibility['fieldtype'] = $fieldtype[1];
	return $visibility; 	
 }

function updateFieldProperties(){
	global $smarty,$log;
	$fieldid = $_REQUEST['fieldid'];
	$fields = XN_Query::create ( 'Content' )->tag ( 'Fields' )
					      ->filter ( 'type', 'eic', 'fields' )
					      ->filter ( 'my.fieldid', '=', $fieldid )
					      ->filter ( 'my.presence', 'in', array('0','2') )
					      ->execute();
	
	if (count($fields) >0 ){
			$field_info = $fields[0];
			$typeofdata = $field_info->my->typeofdata;
			$tabid = $field_info->my->tabid;
			$fieldname = $field_info->my->fieldname;
			$uitype = $field_info->my->uitype;
			
			$oldfieldlabel = $field_info->my->fieldlabel;
			$oldmassedit = $field_info->my->masseditable;
			$oldpresence = $field_info->my->presence;
			
			$old_merge_column = $field_info->my->merge_column;
			$old_deputy_column = $field_info->my->deputy_column;
			
			$old_display_width = $field_info->my->width;
			$old_display_align = $field_info->my->align;
			
			if(!empty($_REQUEST['fld_module'])){
				$fld_module = $_REQUEST['fld_module'];
			}else{
				$fld_module = getTabModuleName($tabid);
			}
			
			$focus = CRMEntity::getInstance($fld_module);
			
			$fieldtype =  explode("~",$typeofdata);
			$mandatory_checked= $_REQUEST['ismandatory'];
			$presence_check = $_REQUEST['isPresent'];
			$merge_column = $_REQUEST['merge_column'];
			$deputy_column = $_REQUEST['deputy_column'];
			$show_title = $_REQUEST['show_title'];
			
			$display_width = $_REQUEST['display_width'];
			$display_align = $_REQUEST['display_align'];			
	    
			if(isset($focus->mandatory_fields) && (!empty($focus->mandatory_fields)) && in_array($fieldname, $focus->mandatory_fields)){
				$fieldtype[1] = 'M';
			} elseif($mandatory_checked == 'true' || $mandatory_checked == ''){
				$fieldtype[1] = 'M';
			} else{
				$fieldtype[1] = 'O';
			}
			
			$datatype = implode('~', $fieldtype);
			$maxseq = '';
			
			if($oldpresence != 3){
				if($presence_check == 'true' || $presence_check == ''){
					$presence = 2;
				}else{
					$presence = 1;
				}
			}else{
				$presence =1;
			}
			
			
			if(isset($focus->mandatory_fields) && (!empty($focus->mandatory_fields))){
				$fieldname_list = implode(',',$focus->mandatory_fields);
			}else{
				$fieldname_list = '';
			}
			$field_info->my->typeofdata	= $datatype;
			
			$field_info->my->presence = $presence;
			$field_info->my->masseditable = $massedit;
			if ($merge_column == 'true' )
			{
				$field_info->my->merge_column = '1';				
			}
			else 
			{
				$field_info->my->merge_column = '0';
			}
			if ($deputy_column == 'true' )
			{
				$field_info->my->deputy_column = '1';				
			}
			else 
			{
				$field_info->my->deputy_column = '0';
			}
			if ($show_title == 'true' )
			{
				$field_info->my->show_title = '1';				
			}
			else 
			{
				$field_info->my->show_title = '0';
			}
			
			$field_info->my->width = $display_width;
			$field_info->my->align = $display_align;

			if (isset($_REQUEST['fieldname']) && $_REQUEST['fieldname'] != "")
			{
				$field_info->my->fieldlabel = $_REQUEST['fieldname'];
			}			
			$field_info->save('Fields');
	}
}



function deleteCustomField(){
	$fld_module = $_REQUEST["fld_module"];
	$id = $_REQUEST["fld_id"];
	$colName = $_REQUEST["colName"];
	$uitype = $_REQUEST["uitype"];
	
	$fields = XN_Query::create ( 'Content' )->tag ( 'Fields' )
				      ->filter ( 'type', 'eic', 'fields' )
				      ->filter ( 'my.fieldid', '=', $id )
				      ->execute();
	if (count($fields)){
		$field_info = $fields[0];
		$typeofdata = $field_info->my->typeofdata;
		$fieldname = $field_info->my->fieldname;
		$oldfieldlabel = $field_info->my->fieldlabel;
		$tablename = $field_info->my->tablename;
		$columnname = $field_info->my->columnname;
		$fieldtype =  explode("~",$typeofdata);
		$fields = XN_Query::create ( 'Content' )->tag ( 'Fields' )
				->filter ( 'type', 'eic', 'fields' )
				->filter ( 'my.fieldid', '=', $id )
				->filter ( 'my.presence', 'in', array('0','2') )
				->execute ();
		foreach ($fields as $field_info)
		{	  
		   XN_Content::delete($field_info,'Fields');
		}
	}	 
}


function addblock(){
	global $mod_strings,$log;
	$fldmodule=$_REQUEST['fld_module'];
	$mode=$_REQUEST['mode'];
	 
	$newblocklabel = trim($_REQUEST['blocklabel']);
	$after_block = $_REQUEST['after_blockid'];
		
	$tabid = getTabid($fldmodule);
	$flag = 0;
	
	$blocks = XN_Query::create ( 'Content' )->tag ( 'Blocks' )
			->filter ( 'type', 'eic', 'blocks' )
			->filter ( 'my.tabid', '=', $tabid )
			->order('my.sequence',XN_Order::ASC_NUMBER)
			->execute ();
	
	foreach ($blocks as $block_info){		
		$blklbl = $block_info->my->blocklabel;
		$blklbltran = getTranslatedString($blklbl,$fldmodule);
		if(strtolower($blklbltran) == strtolower($newblocklabel)){
			$flag = 1;
			$duplicate='yes';
			return $duplicate;
			}
	}
	$length = strlen($newblocklabel);
	if($length > 50){
		$flag = 1;
		$duplicate='LENGTH_ERROR';
		return $duplicate;
	}
	if($flag!=1){
		$blocks = XN_Query::create ( 'Content' )->tag ( 'Blocks' )
					      ->filter ( 'type', 'eic', 'blocks' )
					      ->filter ( 'my.blockid', '=', $after_block )					    
					      ->execute();
		if (count($blocks)>0){
			$block_info = $blocks[0];
			$block_sequence=intval($block_info->my->sequence);
			$newblock_sequence=$block_sequence+1;
			
			$update_blocks = XN_Query::create ( 'Content' )->tag ( 'Blocks' )
					      ->filter ( 'type', 'eic', 'blocks' )
					      ->filter ( 'my.tabid', '=', $tabid )	
					      ->filter ( 'my.sequence', '>', $block_sequence ) 						      			    
					      ->execute();
		    foreach($update_blocks as $update_block_info){
		    	$update_block_info->my->sequence = $update_block_info->my->sequence+1;
		    	$update_block_info->save('Blocks');
		    }		    
			$max_blockid=getUniqueID('blocks','blockid');
			$iscustom = 1;
			XN_Content::create('blocks', 'blocks',false)
		       ->my->add('tabid',$tabid)
		       ->my->add('blockid',$max_blockid) 
		       ->my->add('sequence',$newblock_sequence) 
		       ->my->add('blocklabel',$newblocklabel) 
		       ->my->add('iscustom',$iscustom)    
		       ->my->add('show_title','0')    
		       ->my->add('visible','0')    
		       ->my->add('create_view','0')    
		       ->my->add('edit_view','0')    
		       ->my->add('detail_view','0')    
		       ->my->add('display_status','1')    
		       ->save("Blocks");
		}			
	}
	 
	
}

function deleteBlock(){ 
	$blockid = $_REQUEST['blockid'];
	$blocks = XN_Query::create ( 'Content' )->tag ( 'Blocks' )
			->filter ( 'type', 'eic', 'blocks' )
			->filter ( 'my.blockid', '=', $blockid )
			->filter ( 'my.iscustom', '=', '1' )
			->execute ();
	foreach ($blocks as $block_info)
	{	  
	   XN_Content::delete($block_info,'Blocks');
	}
}

function addCustomField(){
	global $current_user,$log;
	$fldmodule=$_REQUEST['fld_module'];
	$fldlabel=trim($_REQUEST['fldLabel']);
	$fldType= $_REQUEST['fieldType'];
	$parenttab=$_REQUEST['parenttab'];
	$mode=$_REQUEST['mode'];
	$blockid = $_REQUEST['blockid'];
	
	$tabid = getTabid($fldmodule);
	if ($fldmodule == 'Calendar' && isset($_REQUEST['activity_type'])) {
		$activitytype = $_REQUEST['activity_type'];
		if ($activitytype == 'E') $tabid = '16';
		if ($activitytype == 'T') $tabid = '9';
	}
	if(get_magic_quotes_gpc() == 1){
		$fldlabel = stripslashes($fldlabel);
	}
	

	$dup_check_tab_id = array($tabid);
		
	$check_fields = XN_Query::create ( 'Content' )->tag ( 'Fields' )
				      ->filter ( 'type', 'eic', 'fields' )
				      ->filter ( 'my.tabid', 'in', $dup_check_tab_id )
				      ->filter ( 'my.fieldlabel', '=', $fldlabel )
				      ->execute();
					      
if(count($check_fields) > 0 )
{
	$duplicate = 'yes';
	return $duplicate ;
}
else{
	$max_fieldid = getUniqueID("fields",'fieldid');
	$columnName = 'cf_'.$max_fieldid;
	$custfld_fieldid = $max_fieldid;	
	//Assigning the uitype
	$fldlength=$_REQUEST['fldLength'];
	$uitype='';
	$fldPickList='';
	if(isset($_REQUEST['fldDecimal']) && $_REQUEST['fldDecimal'] != ''){
		$decimal=$_REQUEST['fldDecimal'];
	}else{
		$decimal=0;
	}
	$type='';
	$uichekdata='';
	if($fldType == 'Text'){
		$uichekdata='V~O~LE~'.$fldlength;
		$uitype = 1;
		$type = "C(".$fldlength.") default ()"; // adodb type
	}elseif($fldType == 'Number'){
		$uitype = 7;
		//this may sound ridiculous passing decimal but that is the way adodb wants
		$dbfldlength = $fldlength + $decimal + 1;
		$type="N(".$dbfldlength.".".$decimal.")";	// adodb type
		// Fix for http://trac.vtiger.com/cgi-bin/trac.cgi/ticket/6363
		$uichekdata='NN~O~'.$fldlength .','.$decimal;
	}elseif($fldType == 'Percent'){
		$uitype = 9;
		$type="N(5.2)"; //adodb type
		$uichekdata='N~O~2~2';
	}elseif($fldType == 'Currency'){
		$uitype = 71;
		$dbfldlength = $fldlength + $decimal + 1;
		$type="N(".$dbfldlength.".".$decimal.")"; //adodb type
		$uichekdata='N~O~'.$fldlength .','.$decimal;
	}elseif($fldType == 'Date'){
		$uichekdata='D~O';
		$uitype = 5;
		$type = "D"; // adodb type
	}elseif($fldType == 'Email'){
		$uitype = 13;
		$type = "C(50) default () "; //adodb type
		$uichekdata='E~O';
	}elseif($fldType == 'Phone'){
		$uitype = 11;
		$type = "C(30) default () "; //adodb type
		$uichekdata='V~O';
	}elseif($fldType == 'Picklist'){
		$uitype = 15;
		$type = "C(255) default () "; //adodb type
		$uichekdata='V~O';
	}elseif($fldType == 'URL'){
		$uitype = 17;
		$type = "C(255) default () "; //adodb type
		$uichekdata='V~O';
	}elseif($fldType == 'Checkbox'){	 
         $uitype = 56;	 
         $type = "C(3) default 0"; //adodb type	 
         $uichekdata='C~O';	 
    }elseif($fldType == 'TextArea'){	 
         $uitype = 21;	 
         $type = "X"; //adodb type	 
         $uichekdata='V~O';	 
	}elseif($fldType == 'MultiSelectCombo'){
		 $uitype = 33;
		 $type = "X"; //adodb type
		 $uichekdata='V~O';
	}elseif($fldType == 'Skype'){
		$uitype = 85;
		$type = "C(255) default () "; //adodb type
		$uichekdata='V~O';
	}
	
	     if(is_numeric($blockid)){
			if($_REQUEST['fieldid'] == ''){
				$max_fieldsequence_fields = XN_Query::create ( 'Content' )->tag ( 'Fields' )
						->filter ( 'type', 'eic', 'fields' )
						->filter ( 'my.tabid', '=', $tabid )
						->order('my.sequence',XN_Order::DESC_NUMBER)
						->execute ();
			    $max_fieldsequence_field_info = $max_fieldsequence_fields[0];
			    $max_seq = $max_fieldsequence_field_info->my->sequence;				
				XN_Content::create('fields', 'fields',false)
			       ->my->add('tabid',$tabid)
			       ->my->add('fieldid',$custfld_fieldid) 			      
			       ->my->add('generatedtype','2')    
			       ->my->add('uitype',$uitype)    
			       ->my->add('fieldname',$columnName)    
			       ->my->add('fieldlabel',$fldlabel)    
			       ->my->add('readonly','0')    
			       ->my->add('presence','2')   
			       ->my->add('selected','0')   
			       ->my->add('maximumlength','100') 
			       ->my->add('sequence',$max_seq+1)  
			       ->my->add('block',$blockid)  
			       ->my->add('displaytype','1')
			       ->my->add('typeofdata',$uichekdata)  
			       ->my->add('info_type','BAS')  
			       ->my->add('merge_column','0')  
			       ->my->add('deputy_column','0')  
			       ->my->add('show_title','1')  
			       ->my->add('width','12')  
			       ->my->add('align','left')       
			       ->save("Fields");			       
				
			if($fldType == 'Picklist' || $fldType == 'MultiSelectCombo'){				
				$picklists = XN_Query::create ( 'Content' )->tag ( 'Picklists' )
						->filter ( 'type', 'eic', 'picklists' )
						->filter ( 'my.name', '=', $columnName )
						->execute ();
				$picklist_Array = Array();	
				$max_sequence = 1; 	
				$max_picklist_valueid = 1;
				foreach ($picklists as $picklist_info)
				{
					$pickvalue = $picklist_info->my->$columnName;
					if (!in_array($pickvalue, $picklist_Array))
						$picklist_Array[] = $pickvalue;	
					$sequence = $picklist_info->my->sequence;
					$picklist_valueid = $picklist_info->my->picklist_valueid;
					if ($sequence > $max_sequence)	$max_sequence = $sequence; 					
					if ($picklist_valueid > $max_picklist_valueid)	$max_picklist_valueid = $picklist_valueid;			
				}
				$pickArray = Array();
				$fldPickList =  $_REQUEST['fldPickList'];
				$pickArray = explode("\n",$fldPickList);
				$count = count($pickArray);
				for($i = 0; $i < $count; $i++)
				{
					$pickArray[$i] = trim(from_html($pickArray[$i]));
					if($pickArray[$i] != '')
					{
						if (!in_array($pickArray[$i], $picklist_Array))
						{
							$newcontent = XN_Content::create('picklists','',false)
								  ->my->add('name',$columnName);
								$newcontent->my->$columnName = $pickArray[$i];
								$newcontent->my->presence = '1';
								$newcontent->my->sequence = $max_sequence;
								$newcontent->my->picklist_valueid = $max_picklist_valueid;
								$newcontent->save('Picklists');   
							    $max_sequence = $max_sequence + 1;
							    $max_picklist_valueid = $max_picklist_valueid +1; 
						}						
					}
				}
			}
		}	
	}
}

}

function show_move_hiddenfields($submode){
	
	$selected_fields = $_REQUEST['selected'];	
	$selected = trim($selected_fields,":");
	if ( $selected != '')
	{
		$sel_arr = array();
		$sel_arr = explode(":",$selected);
			
			if($submode == 'showhiddenfields'){
					$updates = XN_Query::create ( 'Content' )->tag ( 'Fields' )
							      ->filter ( 'type', 'eic', 'fields' )
							      ->filter ( 'my.fieldid', 'in', $sel_arr )
							      ->filter ( 'my.block', '=', $_REQUEST['blockid'] )
							      ->execute(); 
					foreach ($updates as $update_info)
					{
							$update_info->my->presence = 2;
							$update_info->my->sequence = $max_seq;
							$update_info->save('Fields');
							$max_seq++;
					}	
				}
			else{
					$updates = XN_Query::create ( 'Content' )->tag ( 'Fields' )
							      ->filter ( 'type', 'eic', 'fields' )
							      ->filter ( 'my.fieldid', 'in', $sel_arr )
							      ->execute(); 
					foreach ($updates as $update_info)
					{
							$update_info->my->block = $_REQUEST['blockid'];
							$update_info->save('Fields');
					} 			
				}
	}
				      
	
}

function getRelatedListInfo($module){
	global $adb;
	$tabid = getTabid($module);
	$relatedlists = XN_Query::create ( 'Content' )->tag ( 'Relatedlists' )
					      ->filter ( 'type', 'eic', 'relatedlists' )
					      ->filter ( 'my.tabid', '=', $tabid )
					      ->order('my.sequence',XN_Order::ASC_NUMBER)
					      ->execute();
	$res = array();
	$i=0;
	foreach($relatedlists as $relatedlist_info){	
		//$res[$i]['name'] = $relatedlist_info->my->name;
		$res[$i]['sequence'] = $relatedlist_info->my->sequence;
		$label = $relatedlist_info->my->label;
		$relatedModule = getTabname($relatedlist_info->my->related_tabid);
		$res[$i]['name'] = $relatedModule;
		$res[$i]['label'] = getTranslatedString($label,$relatedModule);
		$res[$i]['presence'] = $relatedlist_info->my->presence;
		$res[$i]['tabid'] = $tabid;
		$res[$i]['id'] = $relatedlist_info->my->relation_id;
		$i = $i + 1; 		
	}	
	return $res;
	 
}

function changeRelatedListOrder(){
     
	$tabid = $_REQUEST['tabid'];
	$what_todo = $_REQUEST['what_to_do'];
	if(!empty($_REQUEST['what_to_do'])){
		if($_REQUEST['what_to_do'] == 'move_up'){
			$currentsequence = $_REQUEST['sequence'];			
			$sequences = XN_Query::create ( 'Content' )->tag ( 'Relatedlists' )
					      ->filter ( 'type', 'eic', 'relatedlists' )
					      ->filter ( 'my.tabid', '=', $tabid )
					      ->filter ( 'my.relation_id', '=', $_REQUEST['id'] )
					      ->filter ( 'my.sequence', '=', $currentsequence )
					      ->begin(0)->end(1)
					      ->order('my.sequence',XN_Order::DESC_NUMBER)
					      ->execute();
			if (count($sequences)>0)
			{
				    $sequence_info = $sequences[0];
					$previous_sequences = XN_Query::create ( 'Content' )->tag ( 'Relatedlists' )
							      ->filter ( 'type', 'eic', 'relatedlists' )
							      ->filter ( 'my.tabid', '=', $tabid )
							      ->filter ( 'my.sequence', '<', intval($currentsequence) )
							      ->begin(0)->end(1)
							      ->order('my.sequence',XN_Order::DESC_NUMBER)
							      ->execute();
					if (count($previous_sequences)>0)
					{
						$previous_sequence_info = $previous_sequences[0];
						$previous_sequence = $previous_sequence_info->my->sequence;
						$sequence_info->my->sequence = $previous_sequence;
						$sequence_info->save('Relatedlists');
						$previous_sequence_info->my->sequence = $currentsequence;
						$previous_sequence_info->save('Relatedlists');
					}
			}
		}elseif($_REQUEST['what_to_do'] == 'move_down'){
			
			$currentsequence = $_REQUEST['sequence'];
			$sequences = XN_Query::create ( 'Content' )->tag ( 'Relatedlists' )
					      ->filter ( 'type', 'eic', 'relatedlists' )
					      ->filter ( 'my.tabid', '=', $tabid )
					      ->filter ( 'my.relation_id', '=', $_REQUEST['id'] )
					      ->filter ( 'my.sequence', '=', $currentsequence )
					      ->begin(0)->end(1)
					      ->order('my.sequence',XN_Order::DESC_NUMBER)
					      ->execute();
			if (count($sequences)>0)
			{
				    $sequence_info = $sequences[0];
					$previous_sequences = XN_Query::create ( 'Content' )->tag ( 'Relatedlists' )
							      ->filter ( 'type', 'eic', 'relatedlists' )
							      ->filter ( 'my.tabid', '=', $tabid )
							      ->filter ( 'my.sequence', '>', intval($currentsequence) )
							      ->begin(0)->end(1)
							      ->order('my.sequence',XN_Order::ASC_NUMBER)
							      ->execute();
					if (count($previous_sequences)>0)
					{
						$previous_sequence_info = $previous_sequences[0];
						$previous_sequence = $previous_sequence_info->my->sequence;
						$sequence_info->my->sequence = $previous_sequence;
						$sequence_info->save('Relatedlists');
						$previous_sequence_info->my->sequence = $currentsequence;
						$previous_sequence_info->save('Relatedlists');
					}
			}
			
		}
	}
	 
}

?>
<?php

global  $copyrights;

if ($copyrights['program'] == 'ma')
{
	 require_once('modules/Ma_Public/config.func.php'); 
}
else if ($copyrights['program'] == 'tezan')
{
	require_once('modules/Public/config.func.php'); 
}


function TransFieldLabel($fieldname,$module)
{
	switch($fieldname)
	{
		case "count":
			return "数量";
		case "published@monthday":
			return "日期";
		case "published@yearmonth":
			return "月度";
		case "published@quarter":
			return "委度";
		case "published@year":
			return "年度";
		default:
			$tabid = getTabid($module);
			$fields = XN_Query::create('Content')->tag('Fields')
							  ->filter('type', 'eic', 'fields')
							  ->filter('my.tabid', '=', $tabid)
							  ->filter('my.fieldname', '=', $fieldname) 
							  ->end(1)
							  ->execute();
	        if (count($fields) > 0)
			{
				$field_info = $fields[0];
				$fieldlabel = $field_info->my->fieldlabel;
				return getTranslatedString($fieldlabel, $module);
			} 
	}
	return $fieldname;
} 

function TransReportWidth($colnames)
{
	$total = 0;
	foreach($colnames as $colname_info)
	{
		$total += intval($colname_info['width']); 
	}
	$newcolnames = array();
	foreach($colnames as $colname_info)
	{
		$width = intval($colname_info['width']); 
		$colname_info['width'] = number_format($width/$total*100, 2, ".", "")."%";
		$newcolnames[] = $colname_info;
	}
	return $newcolnames;
}

function GetReferenceInfo($reportmodule,$fieldname)
{
	$tabid = getTabid($reportmodule);
    $fields = XN_Query::create ( 'Content' )->tag ( 'fields' )
	      ->filter ( 'type', 'eic', 'fields' )
	      ->filter ( 'my.tabid', '=', $tabid )
		  ->filter ( 'my.uitype', '=', '10' )
		  ->filter ( 'my.fieldname', '=', $fieldname )
		  ->end(1)
	      ->execute();
	 if (count($fields) > 0)	
	 {
	 	$field_info = $fields[0];
		$fieldid = $field_info->my->fieldid;
		$fieldmodulerels = XN_Query::create ( 'Content' )
			->filter ( 'type', 'eic', 'fieldmodulerels' )
			->filter ( 'my.tabid', '=', $tabid )
			->filter ( 'my.fieldid', '=', $fieldid )
			->end(1)
			->execute ();
	   	 if (count($fieldmodulerels) > 0)	
	   	 {
	   	 	$fieldmodulerel_info = $fieldmodulerels[0];
			$relmodule = $fieldmodulerel_info->my->relmodule;
			$reference_tabid = getTabid($relmodule);
		 	$entitynames = XN_Query::create ( 'Content' )->tag ( 'entitynames' )
		      ->filter ( 'type', 'eic', 'entitynames' )
		      ->filter ( 'my.tabid', '=', $reference_tabid )
			  ->end(1)  
		      ->execute(); 
		    if (count($entitynames) > 0)	
			{  
      			$entityname_info = $entitynames[0];
		 		$fieldname = $entityname_info->my->fieldname;
				return array("relmodule"=>$relmodule,"fieldname"=>$fieldname);
			}
		 } 
	}
	return array();
}



?>

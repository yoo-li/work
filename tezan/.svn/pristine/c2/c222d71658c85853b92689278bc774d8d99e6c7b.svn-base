<?php

if(isset($_REQUEST["subtabid"]) && $_REQUEST["subtabid"] != '')
{
	$subtabid = $_REQUEST["subtabid"];
	$submodule = getModule($subtabid);
	$fields =  XN_Query::create('Content')->tag('fields')
			->filter('type','eic','fields')
			->filter('my.tabid','=',$subtabid)
			->order('my.sequence',XN_Order::ASC_NUMBER)
			->execute();
	$selectfields = array();
	foreach($fields as $field_info)
	{
		$field_name = $field_info->my->fieldname;
		$field_label = getTranslatedString($field_info->my->fieldlabel,$submodule);
		$selectfields[] = '{"key":"'.$field_name .'","value":"'.$field_label.'"}';
	}
	echo '['.join(',',$selectfields).']';
	
}
else
{
  echo '[]';
}



?>
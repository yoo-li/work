<?php

	require_once('modules/Users/Users.php');
	require_once('include/utils/UserInfoUtil.php');

	global $currentModule;

	$focus = CRMEntity::getInstance($currentModule);

	setObjectValuesFromRequest($focus);
	global $supplierid;
	if ($focus->column_fields['supplierid'] == '' && $focus->mode == "create")
	{
		$focus->column_fields['supplierid'] = $supplierid;
	}

	try
	{
		$tmpname = $focus->column_fields['invoiceprintname'];
		$template = $focus->column_fields['template_editor'];
		$pregprintdata = preg_replace('/<span key="\{INVOICEPRINTNAME\}">(.*)<\/span>/iUs', '<span key="{INVOICEPRINTNAME}">'.$tmpname.'</span>', $template);
		$focus->column_fields['template_editor'] = $pregprintdata;

		$focus->saveentity($currentModule);
	}
	catch (XN_Exception $e)
	{
		echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
		die;
	}

	echo '{"statusCode":200,"tabid":"'.$currentModule.'","closeCurrent":true}';




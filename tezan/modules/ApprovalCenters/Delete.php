<?php

	global $currentModule;
	$focus = CRMEntity::getInstance($currentModule);

	global $mod_strings;

	if (!isset($_REQUEST['record']))
		die($mod_strings['ERR_DELETE_RECORD']);

	DeleteEntity($_REQUEST['module'], $_REQUEST['return_module'], $focus, $_REQUEST['record'], $_REQUEST['return_id']);

	header("Location: index.php?module=".$_REQUEST['return_module']."&action=".$_REQUEST['return_action']."&record=".$_REQUEST['return_id']."&relmodule=".$_REQUEST['module']."&parenttab=".getParentTab());

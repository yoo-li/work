<?php$Create = false;$Delete = false;$MassEdit = false;$CustomMassDelete = false; 	$actionmapping = array (	array('actionname' => 'ModifyPersonman','securitycheck' => '1','func'=>'ModifyPersonman','type'=>'listview'),      	);if (!function_exists('ModifyPersonman')){	function ModifyPersonman()	{		global $current_user;		if (check_authorize('tezanadmin') || is_admin($current_user))			return '<a class="btn btn-default" data-icon="edit" data-group="ids" data-toggle="doajaxchecked" data-dialog=true data-title="指定责任人"  data-mask="true" data-maxable="false" data-resizable="false" data-width="360" data-height="200" href="index.php?module=PotenitalSuppliers&action=ModifyPersonman" > 指定责任人</a>';		else			return "";	}}?>
<?php
	$Config_contacts = array ( 
		  1 => 
		  array (
			'event_name' => 'vtiger.entity.beforesave',
		    'handler_path' => 'modules/WorkFlows/VTEventGlobalHandler.inc',
		    'handler_class' => 'VTWorkflowEventGlobalHandler',
		    'cond' => '',
		    'is_active' => '1',
		  ),

		  2 => 
		  array (
		    'event_name' => 'vtiger.entity.aftersave',
		    'handler_path' => 'modules/WorkFlows/VTEventHandler.inc',
		    'handler_class' => 'VTWorkflowEventHandler',
		    'cond' => '',
		    'is_active' => '1',
		  ), 
	);
?>
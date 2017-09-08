<?php
	global $mod_strings,$app_strings,$theme,$currentModule,$current_user;

	require_once('Smarty_setup.php');
	require_once('include/utils/utils.php');
	$smarty = new vtigerCRM_Smarty;
	$smarty->assign("MODULE",$currentModule);
	$smarty->assign("APP",$app_strings);
	$smarty->assign("MOD", $mod_strings);
	if(isset($_REQUEST['record']) && $_REQUEST['record'] != '' )
	{
		try {
			$condition_summary_options = array();
			$recordid = $_REQUEST['record'];
			$loadcontent = XN_Content::load($recordid,'Supplier_InvoicePrint');
			$tabid = $loadcontent->my->supplier_invoiceprint_tabid;
			if (!empty($tabid) )
			{
				$module = getModule($tabid);
				$smarty->assign("INVOICE_TEMPLATE_CONTENT", $loadcontent->my->template_editor);
				$smarty->assign("MODULENAME", $module);
				$smarty->assign("TABID", $tabid);
				$config_file = 'modules/Public/config.print.details.php';
				$printfields = array(); 
				if (@file_exists($config_file))
				{
					include ($config_file);
					if (isset($print_config))
					{
						if(!empty($print_config["details"][$module])){
							foreach($print_config["details"][$module] as $detail){
								$printfields["子表信息"][$detail["key"]] = $detail["label"];
							}
						}
						if(!empty($print_config["default"])){
							$defaultfields = array();
							foreach($print_config["default"] as $item){
								$defaultfields[$item["key"]] = $item["label"];
							}
							if(count($defaultfields) > 0){
								$smarty->assign("DEFAULTFIELDS", $defaultfields);
							}
						}
					}
				}
				$printfields["子表信息"]['PRINTAPPROVALS'] = '审批意见明细';
				$fields = XN_Query::create('Content')->tag('fields')
								  ->filter('type', 'eic', 'fields')
								  ->filter('my.tabid', '=', $tabid)
								  ->filter('my.presence', 'in', array('0', '2'))
								  ->order('my.sequence', XN_Order::ASC_NUMBER)
								  ->end(-1)
								  ->execute();
				$reference = array();
				foreach ($fields as $field_info)
				{
					$uitype = $field_info->my->uitype;
					$field  = $field_info->my->fieldname;
					if(intval($uitype) == 10){
						$reference[$field] = getTranslatedString($field_info->my->fieldlabel, $module);
					}else
					{
						$printfields["主表信息"]["{".strtoupper($field_info->my->fieldname)."}"] = getTranslatedString($field_info->my->fieldlabel, $module);
					}
				}
				if(count($reference) > 0){
					$fieldmodulerels = XN_Query::create('Content')->tag('fieldmodulerels')->end(-1)
						->filter('type', 'eic', 'fieldmodulerels')
						->filter('my.fieldname ', 'in', array_unique(array_keys($reference)))
						->filter('my.tabid', '=', $tabid)
						->execute();
					foreach($fieldmodulerels as $item){
						$optgroup = $reference[$item->my->fieldname] . "关联表";
						$optmainkey = $item->my->fieldname;
						$relmodule = $item->my->relmodule;
						$retabid = getTabid($relmodule);
						$relmodulefields = XN_Query::create('Content')->tag('fields')
							->filter('type', 'eic', 'fields')
							->filter('my.tabid', '=', $retabid)
							->filter('my.presence', 'in', array ('0', '2'))
							->filter('my.uitype', '!=', '10')
							->order('my.sequence', XN_Order::ASC_NUMBER)
							->end(-1)
							->execute();
						foreach($relmodulefields as $relmodulefield){
							$optkey = "{".$optmainkey."@".$relmodule."@".$relmodulefield->my->fieldname."}";
							$printfields[$optgroup][strtoupper($optkey)] = $reference[$item->my->fieldname] ." : ".getTranslatedString($relmodulefield->my->fieldlabel, $relmodule);
						}
					}
				}
				if(count($printfields) > 0)
				{
					$smarty->assign("PRINTFIELDS", $printfields);
				}
			}
		}
		catch ( XN_Exception $e )
		{
			echo $e->getMessage ();
			die();
		}
	}
	$smarty->display('Supplier_InvoicePrint/EditPrintTemplate.tpl');
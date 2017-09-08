<?php

	require_once('modules/Users/Users.php');
	require_once('include/utils/UserInfoUtil.php');

	global $currentModule;
    global $supplierid;
	if(isset($_REQUEST['record']) && $_REQUEST['record'] != "" && $_REQUEST['record'] != "0"){
		if(isset($_REQUEST['reportfiltercount']) && $_REQUEST['reportfiltercount'] != "" && intval($_REQUEST['reportfiltercount']) > 0){
			$query = XN_Query::create("Content")->tag("supplier_reportsettingsfilters")->end(-1)
				->filter("type", "eic", "supplier_reportsettingsfilters")
				->filter("my.record", "=", $_REQUEST['record'])
				->execute();
			if(count($query) > 0){
				XN_Content::delete($query,"supplier_reportsettingsfilters");
			}
			$querycount = intval($_REQUEST['reportfiltercount']);
			$savecontent = array();
			for($i = 0; $i <= $querycount; $i++){
				if(isset($_REQUEST["reportfilterfield_".$i]) && $_REQUEST["reportfilterfield_".$i] != "" && isset($_REQUEST["reportfiltertype_".$i]) && $_REQUEST["reportfiltertype_".$i] != "" ){
					$newcontent = XN_Content::create("supplier_reportsettingsfilters","",false);
					$newcontent->my->deleted = "0";
					$newcontent->my->record = $_REQUEST['record'];
					$newcontent->my->fieldname = $_REQUEST["reportfilterfield_".$i];
					$newcontent->my->filtertype = $_REQUEST["reportfiltertype_".$i];
					$savecontent[] = $newcontent;
				}
			}
			if(count($savecontent) > 0){
				XN_Content::batchsave($savecontent,"supplier_reportsettingsfilters");
			}
		}

		if(isset($_REQUEST['reportquerycount']) && $_REQUEST['reportquerycount'] != "" && intval($_REQUEST['reportquerycount']) > 0){
			$query = XN_Query::create("Content")->tag("supplier_reportsettingsquerys")->end(-1)
							 ->filter("type", "eic", "supplier_reportsettingsquerys")
							 ->filter("my.record", "=", $_REQUEST['record'])
							 ->execute();
			if(count($query) > 0){
				XN_Content::delete($query,"supplier_reportsettingsquerys");
			}
			$querycount = intval($_REQUEST['reportquerycount']);
			$savecontent = array();
			for($i = 0; $i <= $querycount; $i++){
				if(isset($_REQUEST["reportqueryfield_".$i]) && $_REQUEST["reportqueryfield_".$i] != "" && isset($_REQUEST["reportquerylogic_".$i]) && $_REQUEST["reportquerylogic_".$i] != "" && isset($_REQUEST["reportqueryvalue_".$i]) && $_REQUEST["reportqueryvalue_".$i] != "" ){
					$newcontent = XN_Content::create("supplier_reportsettingsquerys","",false);
					$newcontent->my->deleted = "0";
					$newcontent->my->record = $_REQUEST['record'];
					$newcontent->my->fieldname = $_REQUEST["reportqueryfield_".$i];
					$newcontent->my->logic = $_REQUEST["reportquerylogic_".$i];
					$newcontent->my->queryvalue = $_REQUEST["reportqueryvalue_".$i];
					$savecontent[] = $newcontent;
				}
			}
			if(count($savecontent) > 0){
				XN_Content::batchsave($savecontent,"supplier_reportsettingsquerys");
			}
		}

		$focus = CRMEntity::getInstance($currentModule);
		setObjectValuesFromRequest($focus);
		try {
			$reporttype = XN_Content::load($_REQUEST['reporttype'],"supplier_reportsettingscategorys");
			if($reporttype->my->categorys == "综合报表"){
				$focus->column_fields['modulestabid'] = "";
				$focus->column_fields['x_axis'] = "";
				$focus->column_fields['y_axis'] = "";
				$focus->column_fields['z_axis'] = "";
			}else{
				$focus->column_fields['complex'] = "";
			}
			$focus->tag = $currentModule.",".$currentModule."_".$supplierid;
			$focus->saveentity($currentModule);
			
			$reportsettings = XN_MemCache::delete("modulereport_".$supplierid); 
		}
		catch (XN_Exception $e)
		{
			echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
			die;
		}
		
		$query = XN_Query::create("Content")
						 ->tag("supplier_users")
						 ->filter("type", "eic", "supplier_users")
						 ->filter("my.supplierid", "=", $supplierid)
						 ->filter("my.deleted", "=", "0")
						 ->end(-1)
						 ->execute();
		foreach ($query as $info)
		{
			$profiled  = $info->my->profileid; 
			XN_MemCache::delete("modulereport_".$profiled);

		}
		echo '{"statusCode":"200","tabid":"'.$currentModule.'","forward":"index.php?module='.$currentModule.'&action=EditView&record='.$focus->id.'"}';
	}

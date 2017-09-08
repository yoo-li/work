<?php
/*+********************************************************************************
 * The contents of this file are subject to the 361CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  361CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ********************************************************************************/
require_once('include/utils/CommonUtils.php');

$def_org_shares = XN_Query::create ( 'Content' )->tag ( 'Def_org_shares' )->filter ( 'type', 'eic', 'def_org_shares' )->filter ( 'my.editstatus', '=', '0')->begin ( 0 )->end ( 100 )->order ( 'published', XN_Order::ASC )->execute ();

foreach ( $def_org_shares as $def_org_share_info ) {
	$ruleid=$def_org_share_info->id;
	$tabid=$def_org_share_info->my->tabid;
	$reqval = $tabid.'_per';	
	$permission=$_REQUEST[$reqval];
	$def_org_share_info->my->permission = $permission;
	$def_org_share_info->save('Def_org_shares');
	if($tabid == 6) {
		$def_org_shares1 = XN_Query::create ( 'Content' )->filter ( 'type', 'eic', 'def_org_shares' )->filter ( 'my.editstatus', '=', '0')->filter ( 'my.tabid', '=', '4')->execute ();
		if (count($def_org_shares1) > 0){
			$def_org_share1 = $def_org_shares1[0];
			$def_org_share1->my->permission = $permission;
			$def_org_share1->save('Def_org_shares');
		}
	}
	if($tabid == 9) {
		$def_org_shares1 = XN_Query::create ( 'Content' )->filter ( 'type', 'eic', 'def_org_shares' )->filter ( 'my.editstatus', '=', '0')->filter ( 'my.tabid', '=', '16')->execute ();
		if (count($def_org_shares1) > 0){
			$def_org_share1 = $def_org_shares1[0];
			$def_org_share1->my->permission = $permission;
			$def_org_share1->save('Def_org_shares');
		}
	}
}

create_tab_data_file();

$loc = "Location: index.php?action=OrgSharingDetailView&module=Settings&parenttab=Settings";
header($loc);
?>
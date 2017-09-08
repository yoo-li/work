/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/


function set_return_principal(ids,names) {
	jQuery('#reports_to_id').val(ids);
	jQuery('#reports_to_name').val(names);
	popUpDivClose('Select_Principal_Panel');
}
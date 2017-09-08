/*********************************************************************************

** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ********************************************************************************/


function thisMovie(movieName) {
    if (navigator.appName.indexOf("Microsoft") != -1) {
        return window[movieName];
    } else {
        return document[movieName];
    }
}

function getflowdata() {
    var message= thisMovie("WorkFlowDesigner").getflowdata();
}

function verify_data_description(fieldlabel,value) {
		var message= thisMovie("WorkFlowDesigner").getflowdata();
		if(typeof $('flowdata') != 'undefined') $('flowdata').value = message;
		return true;
}


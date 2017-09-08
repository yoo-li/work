<?php
/*********************************************************************************
 * The contents of this file are subject to the SugarCRM Public License Version 1.1.2
 * ("License"); You may not use this file except in compliance with the 
 * License. You may obtain a copy of the License at http://www.sugarcrm.com/SPL
 * Software distributed under the License is distributed on an  "AS IS"  basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied. See the License for
 * the specific language governing rights and limitations under the License.
 * The Original Code is:  SugarCRM Open Source
 * The Initial Developer of the Original Code is SugarCRM, Inc.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.;
 * All Rights Reserved.
 * Contributor(s): ______________________________________.
 ********************************************************************************/
/*********************************************************************************
 * $Header: /advent/projects/wesat/vtiger_crm/sugarcrm/modules/Users/Save.php,v 1.14 2005/03/17 06:37:39 rank Exp $
 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

require_once('modules/Users/Users.php');

require_once('include/utils/UserInfoUtil.php');




global $currentModule;

$focus = CRMEntity::getInstance($currentModule);


setObjectValuesFromRequest($focus);


//var_dump($_REQUEST);


 
try {
	$focus->saveentity($currentModule);
    //�û� ��ݲ����
    if(count($query)){
        $suppliers=$query[0]->id;//��Ӧ��id
        
        $suppliers_info=XN_Query::create("Content")
        ->filter('type','eic','supplierlogisticinfo')
        ->filter ( 'my.deleted', '=', '0' )
        ->filter ( 'my.suppliers', '=',$suppliers)
        ->execute();
        if(count($suppliers_info)){
            $suppliers_id = $suppliers_info[0]->id;
            $content=XN_Content::load($suppliers_id,"supplierlogisticinfo");
            $content->my->ispass=$_REQUEST['ispass'];
            $content->my->custid=$_REQUEST['custid'];
            $content->my->checkname=$_REQUEST['checkname'];
            $content->my->checkword=$_REQUEST['checkword'];
            $content->save("supplierlogisticinfo");
        }
        else{
            $content=XN_Content::create("supplierlogisticinfo","",false);
            $content->my->deleted='0';
            $content->my->suppliers=$suppliers;
            $content->my->ispass=$_REQUEST['ispass'];
            $content->my->logistics=$_REQUEST['logistics'];
            $content->my->custid=$_REQUEST['custid'];
            $content->my->checkname=$_REQUEST['checkname'];
            $content->my->checkword=$_REQUEST['checkword'];
            $content->save("supplierlogisticinfo");  
        }
    }
    
} 
catch (XN_Exception $e) 
{
	echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
	die;
}

echo '{"statusCode":"200","message":null,"tabid":"'.$currentModule.'","closeCurrent":true,"forward":null}';

//echo '{"statusCode":"200","message":null,"tabid":null,"callbackType":"forward","forward":"/index.php?module='.$currentModule.'&action=EditView&record='.$focus->id.'"}';

?>







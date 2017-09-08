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




global $currentModule,$current_user;



$focus = CRMEntity::getInstance($currentModule);


setObjectValuesFromRequest($focus);
global  $supplierid,$localusertype;
if($focus->column_fields['supplierid'] == '' && $focus->mode == "create")
{
		$focus->column_fields['supplierid'] = $supplierid;
}

if($focus->column_fields[strtolower($currentModule). 'status'] == '' && $focus->mode == "create")
{
    $focus->column_fields[strtolower($currentModule). 'status'] = 'JustCreated'; 
}
$Datas=array();
foreach($_REQUEST['dimensiontypename'] as $index => $dimensiontypename )
{
    if($_REQUEST['dimensionvalue'][$index] == "" ){
        $_REQUEST['dimensionvalue'][$index] =$_REQUEST['arr'];
//        var_dump($_REQUEST['comparisonoperator'][$index] );die();
        if($_REQUEST['comparisonoperator'][$index] == '包含'){
//	        var_dump(1000000);die();
            $result = $_REQUEST['dimensionvalue'][$index];  //遍历取别名
//            var_dump($result);die();
            foreach ( $result as $_REQUEST['dimensionvalue'][$index] ){
                $dimensionvalue = $_REQUEST['dimensionvalue'][$index];
                $comparisonoperator = $_REQUEST['comparisonoperator'][$index];
                $memo = $_REQUEST['memo'][$index];
                $warehouselocationsproduct=XN_Content::create("mall_officialauthorizedimensions_details","",false);
                $warehouselocationsproduct->my->supplierid=$supplierid;
                $warehouselocationsproduct->my->record=$focus->id;
                $warehouselocationsproduct->my->dimensiontypename=$dimensiontypename;
                $warehouselocationsproduct->my->dimensionvalue=$dimensionvalue;
                $warehouselocationsproduct->my->comparisonoperator=$comparisonoperator;
                $warehouselocationsproduct->my->memo=$memo;
                $warehouselocationsproduct->my->deleted='0';
                $Datas[]=$warehouselocationsproduct;
//                var_dump(123);die();
            }
            $_REQUEST['dimensionvalue'][$index] = implode(",",$_REQUEST['dimensionvalue'][$index] );
        }

    }

    //    ========================
    //判断是否是人均
    if ( $dimensiontypename == '人均' && $_REQUEST['comparisonoperator'][$index] == '介于' ){
        var_dump( $_REQUEST['dimensionvalue'][$index] );die();
        var_dump(22222222);die();
// 纬度值 用逗号拼接  =》将其分割
        $dimentions = $_REQUEST['dimensionvalue'][$index];
        $dimensionall = explode(',',$dimentions);
        $dimensionallSmall = $dimensionall[0];
        $dimensionallBig = $dimensionall[1];

        //将数据分别插入数组
//          大于
            $_REQUEST['comparisonoperator'][$index] = '>=';
            $_REQUEST['dimensionvalue'][$index] = $dimentionalls;
            $dimensionvalue = $_REQUEST['dimensionvalue'][$index];
            $comparisonoperator = $_REQUEST['comparisonoperator'][$index];
            $memo = $_REQUEST['memo'][$index];
            $warehouselocationsproduct=XN_Content::create("mall_officialauthorizedimensions_details","",false);
            $warehouselocationsproduct->my->supplierid=$supplierid;
            $warehouselocationsproduct->my->record=$focus->id;
            $warehouselocationsproduct->my->dimensiontypename=$dimensiontypename;
            $warehouselocationsproduct->my->dimensionvalue=$dimensionallSmall;
            $warehouselocationsproduct->my->comparisonoperator=$comparisonoperator;
            $warehouselocationsproduct->my->memo=$memo;
            $warehouselocationsproduct->my->deleted='0';
            $Datas[]=$warehouselocationsproduct;
//          小于
        $_REQUEST['comparisonoperator'][$index] = '<=';
        $_REQUEST['dimensionvalue'][$index] = $dimentionalls;
        $dimensionvalue = $_REQUEST['dimensionvalue'][$index];
        $comparisonoperator = $_REQUEST['comparisonoperator'][$index];
        $memo = $_REQUEST['memo'][$index];
        $warehouselocationsproduct=XN_Content::create("mall_officialauthorizedimensions_details","",false);
        $warehouselocationsproduct->my->supplierid=$supplierid;
        $warehouselocationsproduct->my->record=$focus->id;
        $warehouselocationsproduct->my->dimensiontypename=$dimensiontypename;
        $warehouselocationsproduct->my->dimensionvalue=$dimensionallBig;
        $warehouselocationsproduct->my->comparisonoperator=$comparisonoperator;
        $warehouselocationsproduct->my->memo=$memo;
        $warehouselocationsproduct->my->deleted='0';
        $Datas[]=$warehouselocationsproduct;

        $_REQUEST['dimensionvalue'][$index] = implode(",",$_REQUEST['dimensionvalue'][$index] );
    }

//    =============
//    var_dump(100);die();
    if($_REQUEST['dimensionvalue'][$index] != "" && $_REQUEST['comparisonoperator'][$index] != "")
    if( $_REQUEST['comparisonoperator'][$index] != "")
	{
//            var_dump(22222222 );die();
            $dimensionvalue = $_REQUEST['dimensionvalue'][$index];
            $comparisonoperator = $_REQUEST['comparisonoperator'][$index];
            $memo = $_REQUEST['memo'][$index];
            $warehouselocationsproduct=XN_Content::create("mall_officialauthorizedimensions_details","",false);
            $warehouselocationsproduct->my->supplierid=$supplierid;
            $warehouselocationsproduct->my->record=$focus->id;
            $warehouselocationsproduct->my->dimensiontypename=$dimensiontypename;
            $warehouselocationsproduct->my->dimensionvalue=$dimensionvalue;
            $warehouselocationsproduct->my->comparisonoperator=$comparisonoperator;
            $warehouselocationsproduct->my->memo=$memo;
            $warehouselocationsproduct->my->deleted='0';
            $Datas[]=$warehouselocationsproduct;
//        var_dump($dimensionvalue);die();

    }
}
//var_dump(3333333333);die();

$tags = "mall_officialauthorizedimensions_details,mall_officialauthorizedimensions_details_".$supplierid;
foreach(array_chunk($Datas,50) as $chunk_Datas){
    XN_Content::batchsave($chunk_Datas,$tags);
}

if($_REQUEST['details_delete_ids'] != "")
{
    $details_delete_ids = $_REQUEST['details_delete_ids']; 
    $details_delete_ids = str_replace(";",",",$details_delete_ids);
    $details_delete_ids = explode(",",trim($details_delete_ids,','));
    array_unique($details_delete_ids); 
	$delete_details = XN_content::loadMany($details_delete_ids,"mall_officialauthorizedimensions_details"); 
	XN_Content::delete($delete_details,$tags); 
}

try {  
	$focus->tag = strtolower($currentModule).",".strtolower($currentModule)."_".$supplierid;
	$focus->saveentity($currentModule);
} 
catch (XN_Exception $e) 
{
	echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
	die;
}

//echo '{"statusCode":"200","message":null,"tabid":"'.$currentModule.'","closeCurrent":true,"forward":null}';
echo '{"statusCode":"200","message":null,"tabid":null,"callbackType":"forward","forward":"/index.php?module='.$currentModule.'&action=EditView&record='.$focus->id.'"}';


?>







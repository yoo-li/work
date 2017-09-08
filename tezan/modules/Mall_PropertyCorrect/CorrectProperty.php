<?php
/*+********************************************************************************
 * The contents of this file are subject to the 361CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  361CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ********************************************************************************/
require_once('Smarty_setup.php');
require_once('include/utils/utils.php');
global $currentModule,$supplierid,$supplierusertype;
require_once('modules/'.$currentModule.'/'.$currentModule.'.php');
global $app_strings,$mod_strings,$theme;
$focus = CRMEntity::getInstance($currentModule);
$smarty = new vtigerCRM_Smarty();

$open_fields=array(
    "productname"=>  array("type"=>"middleinput",'label'=>'商品名称'),
    "market_price"=>array("type"=>"middleinput",'label'=>'市场价'),
    "shop_price"=>array("type"=>"middleinput",'label'=>'销售价'), 
    "barcode"       =>  array("type"=>"middleinput",'label'=>'商品条码'),
    "internalno"    =>  array("type"=>"middleinput",'label'=>'内部编码'),
    "product_weight"=>  array("type"=>"middleinput",'label'=>'商品重量'),
    "product_guige" =>  array("type"=>"middleinput",'label'=>'商品规格'),
    "keywords"      =>  array("type"=>"middleinput",'label'=>'关键词'), 
    "simple_desc"   =>  array("type"=>"textarea",'label'=>'简单描述'),
    "description"   =>  array("type"=>"ueditor",'label'=>'商品详情'),
);

$smarty = new vtigerCRM_Smarty();
$smarty->assign("MODULE",$currentModule);
$tabid = getTabid($currentModule);
$record=$_REQUEST['record'];
try{
    $productcorrect=XN_Content::load($record,$currentModule);
    $productContent=XN_Content::load($productcorrect->my->product_id,"mall_products");

    $smarty->assign("MODE","approvecorrect");
    if($productcorrect->my->mall_propertycorrectstatus!='Saved' ){
        if($productcorrect->author==XN_Profile::$VIEWER){
            $smarty->assign("SUBMITAPPROVAL",'true');
        }
    }
    if($productcorrect->my->mall_propertycorrectstatus!='Approvaling'){
        $smarty->assign("INPUTREADONLY",'false');
    }else{
        $smarty->assign("INPUTREADONLY",'true');
    }
    $smarty->assign("HASAPPROVALS",'true');
    $smarty->assign("APPROVALSTATUS",$productcorrect->my->mall_propertycorrectstatus);//还没保存时，审批状态为空，只能“保存”


//如果已经有纠错信息，且在审批过程中，或者尚未提交审批的，提出这条纠错信息
    $fieldname_result=array();

    foreach($open_fields as $fieldname=>$arr){
        if($arr['type']=="select"){
            $picklistValues =(array)getAssignedPicklistValues($fieldname);
            $open_fields[$fieldname]['picklists']=$picklistValues;
            $open_fields[$fieldname]['value']=$productContent->my->$fieldname;
            $correctfieldname="correct".$fieldname;
            if($productcorrect->my->$correctfieldname){
                $open_fields[$fieldname]['chvalue']=$productcorrect->my->$correctfieldname;
            }
        }
        else{
            $open_fields[$fieldname]['value']=$productContent->my->$fieldname;
            $correctfieldname="correct".$fieldname;
            if($productcorrect->my->$correctfieldname){
                $open_fields[$fieldname]['chvalue']=$productcorrect->my->$correctfieldname;
            }
        }
    }
}
catch(XN_Exception $e){
    echo '有错误，找张飞！';
    exit();
}
//echo "<pre>";print_r($open_fields);echo "</pre>";exit();
$headers=array(
    "mall_products_no"=>array("label"=>"商品编号","value"=>$productContent->my->mall_products_no),
);
$smarty->assign("HEADERS",$headers);
$smarty->assign("FIELDS",$open_fields);
$smarty->assign("INFOMATION","请慎重更改商品信息，提交后等待管理员审批通过才能生效");

$smarty->assign("RECORD",$_REQUEST['record']);
$smarty->assign("ARECORD",$productcorrect->id);
$smarty->assign("MODULE",$currentModule);
$smarty->assign("ACTION","Save");
$smarty->display("Settings/CorrectSuppliers.tpl");

?>
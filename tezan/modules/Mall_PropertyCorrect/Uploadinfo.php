<?php
/*+**********************************************************************************
 * The contents of this file are subject to the 361CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  361CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

global $mod_strings,$app_strings,$theme,$currentModule,$current_user;

require_once('Smarty_setup.php');
require_once('include/utils/utils.php');
global $currentModule,$supplierid;
$lowermodule=strtolower($currentModule);
require_once('modules/'.$currentModule.'/'.$currentModule.'.php');
//列定义
$fields =   array(
    'columname'=>   array('label'=>'类型','width'=>'14%','talign'=>'center','calign'=>'center',	'tclass'=>'lvtCol',	'cclass'=>'dvtCellInfo',),
    'filename' =>	array('label'=>'修改前',		'width'=>'25%',	'talign'=>'center',	'calign'=>'center',	'tclass'=>'lvtCol',	'cclass'=>'dvtCellInfo',),
    'original'=>array('label'=>'修改后','width'=>'25%','talign'=>'center','calign'=>'center',	'tclass'=>'lvtCol',	'cclass'=>'dvtCellInfo'),
);

//行定义，可扩展，扩展时在数组中添加字段名=>"标签名"即可
$columfields=array(
    "productlogo"=>"广告图",
    "productthumbnail"=>"商品缩略图"
);

$smarty = new vtigerCRM_Smarty;
$smarty->assign("MODULE",$currentModule);

$record=$_REQUEST['record'];

$productcorrect=XN_Content::load($_REQUEST['record'],strtolower($currentModule));
$productContent=XN_Content::load($productcorrect->my->product_id,"mall_products");

if(isset($supplierid) &&$supplierid != ""){
    if($productcorrect->my->mall_propertycorrectstatus=='Approvaling'){
        $readonly='true';
    }else{
        $readonly='false';
    }
}
else{
    $readonly='true';
}

$msg = "";
$msg .= '<table class="table table-bordered" style="width:70%;margin-left:15%;margin-top:10px;">';
//创建表头
$msg .= "<tbody><tr>";
foreach($fields as  $field_info )
{
    $msg .= "<th align=".$field_info['talign']." width='".$field_info['width']."'>".getTranslatedString($field_info['label'])."</th>";
}
$msg .= "</tr>";
foreach($columfields as $columfield=>$columlabel){
    $correctfield="correct".$columfield;
    $msg .= '<tr class="edit-form-tr" rel="'.$columfield.'" id="'.$columfield.$record.'"><td align="center">'.$columlabel.'</td>';
    //第二列：原证件
    $msg .= '<td align="center" class="srcname"><a href="'.$productContent->my->$columfield.'" data-lightbox="roadtrip"><img align="absmiddle" height="25px" src="'.$productContent->my->$columfield.'"/></a></td>';
   //第三列：修改后的证件
    $msg.='<td class="correct_srcname" align="center">';
    if($readonly=='false'){
        if($productcorrect->my->$correctfield!=''){
            $msg.='<input type="hidden" name="'.$correctfield.'" id="'.$correctfield.'" value="'.$productcorrect->my->$correctfield.'"><a id="'.$correctfield.'_link" href="'.$productcorrect->my->$correctfield.'"  data-lightbox="roadtrip"><img id="'.$correctfield.'_view" align="absmiddle" height="20px" src="'.$productcorrect->my->$correctfield.'"/></a>';
        }else{
            $msg.='<input type="hidden" name="'.$correctfield.'" id="'.$correctfield.'" value=""><a id="'.$correctfield.'_link" href=""  data-lightbox="roadtrip"><img id="'.$correctfield.'_view" align="absmiddle" height="20px" src=""/></a>';
        }
        if(XN_Profile::$VIEWER==$productcorrect->author){
            if($productcorrect->my->$correctfield!=""){
                $msg.='
                <button type="button" id="'.$correctfield.'_delete" onclick="delete_uploadinfo2(\''.$correctfield.'\');" class="btn btn-red" data-icon="times"><i class="fa fa-times"></i>删除</button>
                <button style="display:none;" type="button" id="'.$correctfield.'_select" onclick="show_upload_div2(\''.$correctfield.'\',\''.$record.'\')" class="btn btn-green" data-icon="plus"><i class="fa fa-plus"></i>选择图片</button>
                ';
            }else{
                $msg.='
                <button style="display:none;" type="button" id="'.$correctfield.'_delete" onclick="delete_uploadinfo2(\''.$correctfield.'\');" class="btn btn-red" data-icon="times"><i class="fa fa-times"></i>删除</button>
                <button type="button" id="'.$correctfield.'_select" onclick="show_upload_div2(\''.$correctfield.'\',\''.$record.'\')" class="btn btn-green" data-icon="plus"><i class="fa fa-plus"></i>选择图片</button>
                ';
            }
        }
    }else{
        if($productcorrect->my->$correctfield!=''){
            $msg.='<a id="'.$correctfield.'_link" href="'.$productcorrect->my->$correctfield.'" data-lightbox="roadtrip"><img id="'.$correctfield.'_view" align="absmiddle" height="20px" src="'.$productcorrect->my->$correctfield.'"/></a>';
        }
    }
    $msg.='</td></tr>';
}
$msg .= "</tbody></table>";

$script= '
 function show_upload_div2(correct_fieldname,product_id){
    var url="index.php?module=Mall_PropertyCorrect&action=uploadpropertyimg&record='.$record.'&ope=upload&correct_fieldname="+correct_fieldname+"&product_id="+product_id;
    $(this).dialog({id:"uploadpropertyimg", url:url, title:"上传图片",width:635,height:480,mask:true,resizable:false,drawable:false,maxable:false});
}
function delete_uploadinfo2(correct_filedname){
    $("#"+correct_filedname).val("");
    $("#"+correct_filedname+"_link").attr("href","").css("display","none");
    $("#"+correct_filedname+"_view").attr("src","");
    $("#"+correct_filedname+"_delete").css("display","none");
    $("#"+correct_filedname+"_select").css("display","inline");
}
';

$smarty->assign("SCRIPT",$script);
$smarty->assign("PANELBODY",$msg);
$smarty->display('Panel.tpl');

?>

<?php

global $mod_strings,$app_strings,$theme,$currentModule,$current_user;
require_once('include/utils/utils.php');
require_once('Smarty_setup.php');

$smarty = new vtigerCRM_Smarty;
$panel =  strtolower(basename(__FILE__,".php"));

$smarty->assign("MODULE",$currentModule);
$smarty->assign("PANEL",$panel);
$smarty->assign("APP",$app_strings);
$smarty->assign("MOD", $mod_strings);

if(isset($_REQUEST['readonly']) && $_REQUEST['readonly'] !='') 
{
	$readonly = $_REQUEST['readonly'];
}

$recordid = $_REQUEST["record"];
$productContent = XN_Content::load($recordid,strtolower($currentModule));
$fieldname1="productthumbnail"; 
$fieldvalues1= $productContent->my->productthumbnail;  
$pluploadhtml1 ='<div style="display: block;clear:both;width:100%;"><h1>商品缩略图:</h1>
<span style="color: #666666;display:block">注意：缩略图片上传或删除后，需保存才能生效；已经上传过图片。再次上传时将覆盖原图片！图片尺寸：<font color="red">500*500</font></span>
';
$div_width=134;
$div_height=134;
$image_width=500;
$image_height=500;
$multi_selection='false';
$title="选择商品缩略图";
$pluploadhtml1.=getCropperLoadHtml($currentModule, $fieldname1, $fieldvalues1, $div_width, $div_height, $image_width, $image_height, $readonly,true);
$pluploadhtml1.='</div>';

$fieldname2="productlogo"; 
$fieldvalues2= $productContent->my->productlogo; 
$pluploadhtml2 ='<div style="display: block;clear:both;width:100%;"><h1>商品广告图:</h1>
<span style="color: #666666;display:block">注意：广告图片上传或删除后，需保存才能生效；已经上传过图片。再次上传时将覆盖原图片！图片尺寸：<font color="red">768*550</font></span>
';
$div_width=154;
$div_height=110;
$image_width=768;
$image_height=550;
$multi_selection='false';
$title="选择商品广告图";
$pluploadhtml2.=getCropperLoadHtml($currentModule,$fieldname2,$fieldvalues2,$div_width,$div_height,$image_width,$image_height,$readonly,true);
$pluploadhtml2.='</div>';
echo  $pluploadhtml1.$pluploadhtml2;

?>
<?php
require_once('include/utils/utils.php');
global $currentModule;
require_once('modules/'.$currentModule.'/'.$currentModule.'.php');

global $app_strings,$mod_strings,$theme;

$focus = CRMEntity::getInstance($currentModule);
$recordid=$_REQUEST['record'];
$focus->retrieve_entity_info($_REQUEST['record'],$currentModule);

if(isset($_REQUEST['readonly']) && $_REQUEST['readonly'] !='')
{
    $readonly = $_REQUEST['readonly'];
}
$activitylogo = $focus->column_fields['activitylogo'];
$homepage= $focus->column_fields['homepage'];

$recordid = $_REQUEST["record"];
$product_info = XN_Content::load($recordid,'mall_products');

$fieldname1="homepage";
$fieldvalues1=(array)$product_info->my->homepage;
$pluploadhtml1 ='<div style="display: block;clear:both;width:100%;"><h1>广告图:</h1>
<div style="color: #666666;display:block;padding-left:10px;">注意：广告图上传或删除后，需保存才能生效；
                图片宽度为<font color="red">743px</font>,高度为<font color="red">275px</font>;</br>
                要求：1、底色必须为白色，2、内容包含产品、品牌商标、促销信，3、主题文字：34px以上，字体兰亭刊黑或商家根据品牌自身设计</br>
                辅助文字：18~22px 字体兰亭刊黑(字数在10个字以内)</div>

';
$div_width=134;
$div_height=92;
$image_width=743;
$image_height=275;
$multi_selection='false';
$title="选择广告图";
$pluploadhtml1.=getPlupLoadHtml($currentModule,$recordid,$fieldname1,$fieldvalues1,$div_width,$div_height,$image_width,$image_height,$readonly,$multi_selection,$title);
if($product_info->my->approvalstatus != '2')
{
	$pluploadhtml1.='<div style="color: #666666;display:block;clear:both;padding-left:10px;">广告图参考:
	     <span style="display:inline;"><a href="/Public/images/activityhomepage2.png" data-lightbox="roadtrip"><img style="height:200px;"  align="absmiddle" src="/Public/images/activityhomepage2.png"/></a></span>
	</div></div>';
}

 

echo  $pluploadhtml1;

?>
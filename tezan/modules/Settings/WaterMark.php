<?php
/*+**********************************************************************************
 * The contents of this file are subject to the 361CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  361CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
require_once(dirname(__FILE__)."/config.php");
require_once(SAASINC."/image.func.php");
if($cfg_photo_support=='')
{
    echo "你的系统没安装GD库，不允许使用本功能！";
    exit();
}

$ImageWaterConfigFile = $_SERVER['DOCUMENT_ROOT'].'/cache/'.XN_Application::$CURRENT_URL.'/inc_photowatermark_config.php';

//$ImageWaterConfigFile = SAASDATA."/mark/inc_photowatermark_config.php";

if(isset($_REQUEST['type']) && $_REQUEST['type'] == 'submit')
{
	
	$fp = fopen($ImageWaterConfigFile,'w+');
    flock($fp,3);
    fwrite($fp,"<"."?php\r\n");
	
    $configfields = array("photo_markup","photo_markdown","photo_marktype","photo_wwidth",
		                  "photo_wheight","photo_waterpos","photo_fontsize","photo_fontcolor",
						  "photo_marktrans","photo_diaphaneity","photo_markimg");

    foreach($configfields as $field_info)
    {
	      fwrite($fp,'$'.$field_info.' = "'.str_replace("'",'',$_REQUEST['get_'.$field_info]).'";'."\r\n"); 
    }
    fwrite($fp,"?".">");
    fclose($fp);
	echo '{	"statusCode":200,"tabid":"Settings"}';
	die();
}


$row = array();

if (@file_exists($ImageWaterConfigFile)) {
	require_once($ImageWaterConfigFile);
	$row['photo_markup'] = $photo_markup;
	$row['photo_markdown'] = $photo_markdown;
	$row['photo_marktype'] = $photo_marktype;
	$row['photo_wwidth'] = $photo_wwidth;
	$row['photo_wheight'] = $photo_wheight;
	$row['photo_waterpos'] = $photo_waterpos;
	$row['photo_watertext'] = $photo_watertext;
	$row['photo_fontsize'] = $photo_fontsize;
	$row['photo_fontcolor'] = $photo_fontcolor;
	$row['photo_marktrans'] = $photo_marktrans;
	$row['photo_diaphaneity'] = $photo_diaphaneity;
	$row['photo_markimg'] = $photo_markimg;
}
else
{
	$row['photo_markup'] = '1';
	$row['photo_markdown'] = '1';
	$row['photo_marktype'] = '1';
	$row['photo_wwidth'] = '112';
	$row['photo_wheight'] = '34';
	$row['photo_waterpos'] =  '9';
	$row['photo_watertext'] = 'www.saasw.com';
	$row['photo_fontsize'] = '20';
	$row['photo_fontcolor'] = '0,0,0';
	$row['photo_marktrans'] = '100';
	$row['photo_diaphaneity'] = '100';
	$row['photo_markimg'] = 'mark.png';
}



global $mod_strings,$app_strings,$theme,$currentModule,$current_user;

require_once('Smarty_setup.php');
require_once('include/utils/utils.php');

$smarty = new vtigerCRM_Smarty;

$panel =  strtolower(basename(__FILE__,".php"));

$smarty->assign("MODULE",$currentModule);
$smarty->assign("PANEL",$panel);
$smarty->assign("APP",$app_strings);
$smarty->assign("MOD", $mod_strings);

 $vars = array('photo_markup','photo_markdown','photo_marktype','photo_wwidth','photo_wheight','photo_waterpos','photo_watertext','photo_fontsize','photo_fontcolor','photo_marktrans','photo_diaphaneity');




$msg = '
<style>
#base_system_div label {
    width: 380px;
}
</style>
<link href="/Public/css/oldhand.css" rel="stylesheet" rel="stylesheet" type="text/css" />
<div class="pageContent" style="padding-top:1px;">
<form method="post" action="index.php" class="pageForm required-validate" onsubmit="return validateCallback(this, navTabAjaxDone)">
<input type="hidden" name="module" value="Settings">
<input type="hidden" name="action" value="WaterMark">
<input type="hidden" name="record" value="">
<input type="hidden" name="type" value="submit">';


$msg .= '<div class="tabs" currentIndex="0" eventType="click">
				<div class="tabsHeader">
					<div class="tabsHeaderContent">
						<ul>
							<li><a href="javascript:;"><span>图片水印设置</span></a></li>
						</ul>
					</div>
				</div>
				<div class="tabsContent" id="base_system_div">
						<div class="pageFormContent" layouth="76" style="display: block; height: 223px; overflow: auto;" inited="1000">
							<div class="form-group">
								<label class="control-label x120">上传的图片是否使用图片水印功能:</label>
								<input class="np" type="radio" value="1" name="get_photo_markup" '.(($row['photo_markup']==1)?" checked":"").' >
		  开启 
		  <input class="np" type="radio" value="0" name="get_photo_markup" '.(($row['photo_markup']==0)?" checked":"").' >
		  关闭
							</div>
							<div class="form-group">
								<label class="control-label x120">采集的图片是否使用图片水印功能:</label>
								 <input class="np" type="radio" value="1" name="get_photo_markdown" '.(($row['photo_markdown']==1)?" checked":"").' >
		  开启 
		  <input class="np" type="radio" value="0" name="get_photo_markdown" '.(($row['photo_markdown']==0)?" checked":"").' >
		  关闭
							
							</div>
							<div class="form-group">
								<label class="control-label x120">选择水印的文件类型:</label>
								<input name="get_photo_marktype" type="radio" value="0" '.(($row['photo_markdown']==0)?" checked":"").' >gif
			&nbsp;<input type="radio" name="get_photo_marktype" value="1" '.(($row['photo_markdown']==1)?" checked":"").' >png
			&nbsp;<input type="radio" name="get_photo_marktype" value="2" '.(($row['photo_markdown']==2)?" checked":"").'>文字
							
							</div>
							<div class="form-group">
								<label class="control-label x120">添加水印的图片大小控制（设置为0为不限）:</label>
								<div style="float:left">宽：</div> 
		  <input name="get_photo_wwidth" type=text id="get_photo_wwidth"   value="'.$row['photo_wwidth'].'" size="5">
		  <div style="float:left">高： </div> 
		  <input name="get_photo_wheight" type=text id="get_photo_wheight"  value="'.$row['photo_wheight'].'" size="5">
							
							</div>
							<div class="form-group">
								<label class="control-label x120">水印图片文件名（如果不存在，则使用文字水印）:</label>
								<img src="../data/mark/'.$row['photo_markimg'].'" alt="saas">
								<input name="get_photo_markimg" type="hidden" value="'.$row['photo_markimg'].'">
							</div>
							<div class="form-group">
								<label class="control-label x120">上传新图片:</label>
								<input name="newimg" type="file" id="newimg" style="width:300">
									 你的系统支持的图片格式：'.$cfg_photo_support.';					
							</div>
							<div class="form-group">
								<label class="control-label x120">水印图片文字：( 请查看data\mark\simhei.ttf是否存在):</label>
								<input name="get_photo_fontsize" type=text id="get_photo_fontsize"  value="'.$row['photo_fontsize'].'">
												
							</div>
							<div class="form-group">
								<label class="control-label x120">水印图片文字字体大小:</label>
								 <input name="get_photo_fontsize" type=text id="get_photo_fontsize"  value="'.$row['photo_fontsize'].'">			
							</div>
							<div class="form-group">
								<label class="control-label x120">水印图片文字颜色（默认#FF0000为红色）:</label>
								<input name="get_photo_fontcolor" type=text id="get_photo_fontcolor"  value="'.$row['photo_fontcolor'].'">			
							</div>
							<div class="form-group">
								<label class="control-label x120">JPEG的水印质量参数，(0～100整数)，数值越大图片效果越好:</label>
								 <input type="text" name="get_photo_marktrans" id="get_photo_marktrans" value="'.$row['photo_marktrans'].'">
												
							</div>
							<div class="form-group">
								<label class="control-label x120">GIF的融合度,水印透明度（0—100，值越小越透明）:</label>
								<input name="get_photo_diaphaneity" type=text id="get_photo_diaphaneity"  value="'.$row['photo_diaphaneity'].'">
												
							</div>
							<div class="form-group">
								<label class="control-label x120">水印位置:</label>
								<input class="np" type="radio" name="get_photo_waterpos"  value="0" '.(($row['photo_waterpos']==0)?" checked":"").'>
									  随机位置
								<table width="300" border="1" cellspacing="0" cellpadding="0">
								  <tr>
									<td width="33%"><input class="np" type="radio" name="get_photo_waterpos"  value="1" '.(($row['photo_waterpos']==1)?" checked":"").'>
									  顶部居左</td>
									<td width="33%"><input class="np" type="radio" name="get_photo_waterpos"  value="2"  '.(($row['photo_waterpos']==2)?" checked":"").'>
									  顶部居中</td>
									<td><input class="np" type="radio" name="get_photo_waterpos"  value="3" '.(($row['photo_waterpos']==3)?" checked":"").'>
									  顶部居右</td>
								  </tr>
								  <tr>
									<td><input class="np" type="radio" name="get_photo_waterpos"  value="4" '.(($row['photo_waterpos']==4)?" checked":"").'>
									  左边居中</td>
									<td><input class="np" type="radio" name="get_photo_waterpos"  value="5" '.(($row['photo_waterpos']==5)?" checked":"").'>
									  图片中心</td>
									<td><input class="np" type="radio" name="get_photo_waterpos"  value="6" '.(($row['photo_waterpos']==6)?" checked":"").'>
									  右边居中</td>
								  </tr>
								  <tr>
									<td><input class="np" type="radio" name="get_photo_waterpos"  value="7" '.(($row['photo_waterpos']==7)?" checked":"").'>
									  底部居左</td>
									<td><input class="np" type="radio" name="get_photo_waterpos"  value="8" '.(($row['photo_waterpos']==8)?" checked":"").'>
									  底部居中</td>
									<td><input name="get_photo_waterpos" type="radio" class="np"  value="9" '.(($row['photo_waterpos']==9)?" checked":"").'>
									  底部居右</td>
								  </tr>
								</table>
												
							</div>
					</div>
				</div>
				<div class="tabsFooter">
					<div class="tabsFooterContent"></div>
				</div>
			
	</div>';

$msg .= '
		<div class="formBar">
            <ul>            	
            	<li><div class="button"><div class="buttonContent"><button type="submit">保存</button></div></div></li>
                <li><div class="button"><div class="buttonContent"><button type="button" class="close">返回</button></div></div></li>
            </ul>
        </div>
';
		  
$msg .= '</form></div>';



$smarty->assign("PANELBODY", $msg);
$smarty->assign("SCRIPT", '');
$smarty->display('Panel.tpl');

?>
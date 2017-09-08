<?php

/*********************************************************************************
** The contents of this file are subject to the 361CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  361CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
*
 ********************************************************************************/

require_once('include/utils/UserInfoUtil.php');
require_once('Smarty_setup.php');
global $mod_strings;
global $app_strings;
global $app_list_strings;

global $currentModule;


$smarty = new vtigerCRM_Smarty;

$downloads = scandir($_SERVER['DOCUMENT_ROOT'].'/download');
 
function get_extension($file)
{
		return end(explode('.', $file));
}

$files = array(); 
foreach($downloads as  $download_info)
{
	$ext = get_extension($download_info);
	$file = $_SERVER['DOCUMENT_ROOT']."/download/".$download_info;
	if (filetype($file) == "file" && 
		$download_info != "." && 
		$download_info != ".." && 
		$download_info != ".." &&
		$ext != "php")
	{  
		$fileinfo = array();
		$fileinfo['filename'] = $download_info;
		$fileinfo['size'] = round(filesize($file) / 1024); 
		$fileinfo['mtime'] = date("Y-m-d H:i:s",filemtime($file)); 
		$files[] = $fileinfo;
	} 
}
 
 


$noofrows = count($backups);

$smarty->assign('NOOFROWS',$noofrows);


$list_entries = array();

$list_entries['filename'] = array('label' => $mod_strings['LBL_FILENAME'],'sort'=> false,'width' => 50,'align' => "left" );
$list_entries['size'] = array('label' => $mod_strings['LBL_SIZE'],'sort'=> false,'width' => 20,'align' => "center" );
$list_entries['mtime'] = array('label' => $mod_strings['LBL_MTIME'],'sort'=> false,'width' => 30,'align' => "center" );
 
$smarty->assign("LISTHEADER",$list_entries);

 
function getStdOutput($files, $noofrows, $mod_strings)
{
	global $adb;
	$return_data = array();		 
	for($i=0; $i<$noofrows; $i++)
	{
		$standCustFld = array();
	    $filename = $files[$i]['filename'];
		$standCustFld[]= $files[$i]['filename'];
		$standCustFld[]= $files[$i]['size']."KB";
		$standCustFld[]= $files[$i]['mtime'];
		$return_data[$filename]=$standCustFld;
	}
	return $return_data;
}
 

$smarty->assign("LISTENTITY",getStdOutput($files, count($files), $mod_strings));
$smarty->assign("MOD", return_module_language($current_language,'Settings'));



 
$searchpanel = '<table class="searchpanel" width="100%" cellspacing="0" cellpadding="0" >							
<tbody>
	<tr>
	<td valign="top">
		<div class="searchBar">
			<ul class="searchContent">
						<div style="height:50px"><form>
							<input id="file_upload" name="file_upload" type="file" multiple="true">
						</form><div>
			</ul>
		</div>
	</td> 
	</tr>
</tbody>
</table>';


$smarty->assign('SEARCHPANEL',$searchpanel);

$timestamp = time();
$unique_salt = md5('unique_salt' . $timestamp);

$smarty->assign("SCRIPT", ' 

			$(\'#file_upload\').uploadify({
				\'formData\'     : 
				{
					\'timestamp\' : \''.$timestamp.'\',
					\'token\'     : \''.$unique_salt.'\',
					\'module\'     : \''.$currentModule.'\',
					\'record\'     : \'0\'
				},
				\'swf\'      : \'/Public/swf/uploadify.swf\',
				\'uploader\' : \'/download/Upload.php\',
				\'cancelImg\' : \'/Public/swf/Cancel.png\',
				\'fileSizeLimit\' : \'10MB\',
				\'buttonText\' : \'请选择上传文件\',
				 \'fileTypeExts\' : \'*.txt;*.png;*.gif;*.jpg;*.jpeg;*.doc;*.docx;*.xls;*.rar;*.zip\',  
				 \'fileTypeDesc\' : \'图片文件(*.png;*.gif;*.jpg;*.jpeg;)文档文件(*.doc;*.docx;*.xls;)压缩文件(*.rar;*.zip)\',
				\'onUploadSuccess\' : function(file, data, response) 
				 {    
						var navTabId = navTab.getCurrentPanel();
						navTab.reload("index.php?module=Settings&action=ListDownloads&parenttab=Settings",{title:"常用下载", fresh:false,mask:true, data:{} },navTabId);
					 
				 }
			});


 
 

');


$listview_check_button = array();
$listview_check_button[] = '<a title="确定要删除这些文件吗?" class="delete" href="index.php?module=Settings&amp;action=DeleteDownLoadFile" posttype="string" rel="ids" target="selectedTodo" warn="请选择需要删除的文件"><span>删除</span></a>';

$smarty->assign("LISTVIEW_CHECK_BUTTON", $listview_check_button);

$smarty->assign("MODULE", $currentModule);
$smarty->assign("ACTION", "ListDownloads");
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->assign("CHECKBOX", "enabled");
$smarty->display("StandardListView.tpl");
?>

<?php
require_once('include/utils/utils.php'); 
require_once('modules/Users/Users.php');
require_once('config.inc.php');


global $currentModule;
if(isset($_REQUEST['module']))
{
	$module = $_REQUEST['module'];	
	$currentModule = $module;
}
if(isset($_REQUEST['profileid'])){
    XN_Profile::$VIEWER=$_REQUEST['profileid'];
} 

if(isset($_SESSION['authenticated_user_language']) && $_SESSION['authenticated_user_language'] != '')
{
	$current_language = $_SESSION['authenticated_user_language'];
}
else 
{
	$current_language = $default_language;
} 

//set module and application string arrays based upon selected language
$app_currency_strings = return_app_currency_strings_language($current_language);
$app_strings = return_application_language($current_language);
$app_list_strings = return_app_list_strings_language($current_language);
$mod_strings = return_module_language($current_language, $currentModule);

$verifyToken = md5('unique_salt' . $_POST['timestamp']);
$returnmsg = array();
//这个是cms标签上传
$file_name=$_FILES['Filedata']['tmp_name'];
$img_err = '';
if (!isset($_REQUEST["upt"]) || empty($_REQUEST["upt"]) || $_REQUEST["upt"] != "file")
{
    $arr     = getimagesize($file_name);
    if (isset($_REQUEST['img_width']) && $_REQUEST['img_width'] > 0)
    {
        $img_width = $_REQUEST['img_width'];
        if ($arr[0] != $img_width)
        {
            $img_err = '宽度不符合要求（'.$img_width.'px）';
        }
    }
    if (isset($_REQUEST['img_height']) && $_REQUEST['img_height'] > 0)
    {
        $img_height = $_REQUEST['img_height'];
        if ($arr[1] != $img_height)
        {
            $img_err = '高度不符合要求（'.$img_height.'px）';
        }
    }
}
if($img_err==''){
    if (!empty($_FILES) && $_POST['token'] == $verifyToken)
    { 
        if(isset($_REQUEST['module']) && isset($_REQUEST['record']))
        {
            $module = $_REQUEST['module'];
            $recordid = $_REQUEST['record'];
            $category=$_REQUEST['category'];
            $CRM = new CRMEntity();
            $return = $CRM->uploadAndSaveFile($recordid,$module,$_FILES['Filedata'],$category,$img_width,$img_height);

            if($return[0])
            {
                $returnmsg['id'] = $return[1];
                $returnmsg['filename'] = $_FILES['Filedata']['name'];
                $returnmsg['filesize'] = $_FILES['Filedata']['size'];
                $returnmsg['published'] = date('Y-m-d H:i');
                $returnmsg['src'] = $return[2].$return[3];
                $returnmsg['type'] = $return[4];
            }
            else
                $error = getTranslatedString('UPF_UPLOAD_FAILED');
        }
        else
        {
            $error = getTranslatedString('UPF_PARAMETER_ERROR');
        }
    }
    else if  (!empty($_FILES) && $_POST['token'] == "smarty")
    {
        if(isset($_REQUEST['module'])  && isset($_REQUEST['record']))
        {
            $module = $_REQUEST['module'];
            $recordid = $_REQUEST['record'];  
            $CRM = new CRMEntity();
            $return = $CRM->uploadAndSaveFile($recordid,$module,$_FILES['Filedata']);

            if($return[0])
            {
                $returnmsg['id'] = $return[1];
                $returnmsg['filename'] = $_FILES['Filedata']['name'];
                $returnmsg['filesize'] = $_FILES['Filedata']['size'];
                $returnmsg['published'] = date('Y-m-d H:i');
                $returnmsg['src'] = $return[2].$return[3];
                $returnmsg['type'] = $return[4];
            }
            else
                $error = getTranslatedString('UPF_UPLOAD_FAILED');
        }
        else
        {
            $error = getTranslatedString('UPF_PARAMETER_ERROR');
        }
    }
    else{
        $error = getTranslatedString('UPF_PARAMETER_ERROR');
    }
}
else{
    $error=$img_err;
}
if(!isset($error) || empty($error))
    $error = "";
$returnmsg["error"] = $error;
echo  json_encode($returnmsg);
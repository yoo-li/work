<?php
require_once('config.inc.php');

function sanitizeUploadFileName($fileName, $upload_badext)
{
    $fileName = preg_replace('/\s+/', '_', $fileName);//replace space with _ in filename
    $fileName = rtrim($fileName, '\\/<>?*:"<>|');
    $fileNameParts        = explode(".", $fileName);
    $countOfFileNameParts = count($fileNameParts);
    $badExtensionFound    = false;
    for ($i = 0; $i < $countOfFileNameParts; ++$i)
    {
        $partOfFileName = $fileNameParts[$i];

        if (in_array(strtolower($partOfFileName), $upload_badext))
        {
            $badExtensionFound = true;
            $fileNameParts[$i] = $partOfFileName.'file';
        }
    }
    $newFileName = implode(".", $fileNameParts);
    if ($badExtensionFound)
    {
        $newFileName .= ".txt";
    }

    return $newFileName;
}
function decideFilePath()
{
    global $adb;
    $filepath = 'storage';
    if (!is_dir($filepath))
    {
        mkdir($filepath);
    }
    $filepath .= '/'.XN_Application::$CURRENT_URL;
    if (!is_dir($filepath))
    {
        mkdir($filepath);
    }
    $year  = date('Y');
    $month = date('F');
    $day   = date('md');
    $week  = '';
    $filepath .= '/'.$year;
    if (!is_dir($filepath))
    {
        mkdir($filepath);
    }
    $filepath .= '/'.$month;
    if (!is_dir($filepath))
    {
        mkdir($filepath);
    }
    $filepath .= '/'.$day;

    if (!is_dir($filepath))
    {
        mkdir($filepath);
    }
    $filepath .= '/';
    return $filepath;

}
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

$returnmsg = array();
//这个是cms标签上传
$file_name=$_FILES['Filedata']['tmp_name'];
$arr = getimagesize($file_name);
$img_err='';
if(isset($_REQUEST['img_width'])&&$_REQUEST['img_width']>0){
    $img_width=$_REQUEST['img_width'];
    if($arr[0]!=$img_width){
        $img_err='宽度不符合要求（'.$img_width.'px）';
    }
}
if(isset($_REQUEST['img_height'])&&$_REQUEST['img_height']>0){
    $img_height=$_REQUEST['img_height'];
    if($arr[1]!=$img_height){
        $img_err='高度不符合要求（'.$img_height.'px）';
    }
}
global $upload_badext;
if($img_err==''){
    if (!empty($_FILES) )
    {
        $file_details=$_FILES['Filedata'];
        if (isset($file_details['original_name']) && $file_details['original_name'] != null) {
            $file_name = $file_details['original_name'];
        } else {
            $file_name = $file_details['name'];
        }
        $binFile = sanitizeUploadFileName($file_name, $upload_badext);
        $filename = ltrim(basename(" " . $binFile)); //allowed filename like UTF-8 characters
        $filetype = $file_details['type'];
        $filesize = $file_details['size'];
        $filetmp_name = $file_details['tmp_name'];

        //get the file path inwhich folder we want to upload the file
        $upload_file_path = "/" . decideFilePath();
        $guid = date("YmdHis") . floor(microtime() * 1000);
        $savefile=$guid.".".substr($filename,strrpos($filename,".")+1);
        //$savefile = $guid . "." . end(explode('.', $filename));
        $upload_status = move_uploaded_file($filetmp_name, $_SERVER['DOCUMENT_ROOT'] . $upload_file_path . $savefile);
        $srcFile = $_SERVER['DOCUMENT_ROOT'] . $upload_file_path . $savefile;
        $pos=strrpos(strtolower($srcFile),".");
        $mime_type=substr(strtolower($srcFile),$pos+1);
        $returnmsg['filename'] = $_FILES['Filedata']['name'];
        $returnmsg['filesize'] = $_FILES['Filedata']['size'];
        $returnmsg['published'] = date('Y-m-d H:i');
        $returnmsg['src'] = $upload_file_path.$savefile;
        $returnmsg['type'] =$mime_type;
    }
    else{
        $error = '上传参数错误';
    }
}
else{
    $error=$img_err;
}

echo "{";
	echo	'"error":"' . $error . '",';
	foreach($returnmsg as $label=>$value)
	{
		echo '"'.$label.'":"'.$value.'",';
	}
    echo '"hello":"world"';
	echo "}"; 
?>
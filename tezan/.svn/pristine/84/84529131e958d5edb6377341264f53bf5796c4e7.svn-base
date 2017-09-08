<?php

$errors = array();
$data = "";
$success = "false";

ini_set('memory_limit','128M');

function return_result($success,$errors,$data) {
	echo("<?xml version=\"1.0\" encoding=\"utf-8\"?>");	
	?>
	<results>
	<success><?=$success;?></success>
	<?=$data;?>
	<?=echo_errors($errors);?>
	</results>
	<?
}

function echo_errors($errors) {

	for($i=0;$i<count($errors);$i++) {
		?>
		<error><?=$errors[$i];?></error>
		<?
	}
}


//����û�ϵͳ֧�ֵ�ͼƬ��ʽ
global $cfg_photo_type;
$cfg_photo_type['gif'] = false;
$cfg_photo_type['jpeg'] = false;
$cfg_photo_type['png'] = false;
$cfg_photo_type['wbmp'] = false;
if(function_exists("imagecreatefromgif") && function_exists("imagegif"))
{
	$cfg_photo_type["gif"] = true;
}
if(function_exists("imagecreatefromjpeg") && function_exists("imagejpeg"))
{
	$cfg_photo_type["jpeg"] = true;
}
if(function_exists("imagecreatefrompng") && function_exists("imagepng"))
{
	$cfg_photo_type["png"] = true;
}
if(function_exists("imagecreatefromwbmp") && function_exists("imagewbmp"))
{
	$cfg_photo_type["wbmp"] = true;
}

//��ͼƬ�Զ���ɺ�����Դ֧��bmp��gif��jpg��png
//����ɵ�Сͼֻ��jpg��png��ʽ
function ImageResize($srcFile,$toW,$toH,$toFile="")
{
	global $cfg_photo_type;
	if($toFile=="")
	{
		$toFile = $srcFile;
	}
	$info = "";
	$srcInfo = GetImageSize($srcFile,$info);
	switch ($srcInfo[2])
	{
		case 1:
			if(!$cfg_photo_type['gif'])
			{
				return false;
			}
			$im = imagecreatefromgif($srcFile);
			break;
		case 2:
			if(!$cfg_photo_type['jpeg'])
			{
				return false;
			}
			$im = imagecreatefromjpeg($srcFile);
			break;
		case 3:
			if(!$cfg_photo_type['png'])
			{
				return false;
			}
			$im = imagecreatefrompng($srcFile);
			break;
		case 6:
			if(!$cfg_photo_type['bmp'])
			{
				return false;
			}
			$im = imagecreatefromwbmp($srcFile);
			break;
	}
	$srcW=ImageSX($im);
	$srcH=ImageSY($im);
	if($srcW<=$toW && $srcH<=$toH )
	{
		return true;
	}
	$toWH=$toW/$toH;
	$srcWH=$srcW/$srcH;
	if($toWH<=$srcWH)
	{
		$ftoW=$toW;
		$ftoH=$ftoW*($srcH/$srcW);
	}
	else
	{
		$ftoH=$toH;
		$ftoW=$ftoH*($srcW/$srcH);
	}
	if($srcW>$toW||$srcH>$toH)
	{
		if(function_exists("imagecreatetruecolor"))
		{
			@$ni = imagecreatetruecolor($ftoW,$ftoH);
			if($ni)
			{
				imagecopyresampled($ni,$im,0,0,0,0,$ftoW,$ftoH,$srcW,$srcH);
			}
			else
			{
				$ni=imagecreate($ftoW,$ftoH);
				imagecopyresized($ni,$im,0,0,0,0,$ftoW,$ftoH,$srcW,$srcH);
			}
		}
		else
		{
			$ni=imagecreate($ftoW,$ftoH);
			imagecopyresized($ni,$im,0,0,0,0,$ftoW,$ftoH,$srcW,$srcH);
		}
		switch ($srcInfo[2])
		{
			case 1:
				imagegif($ni,$toFile);
				break;
			case 2:
				imagejpeg($ni,$toFile,85);
				break;
			case 3:
				imagepng($ni,$toFile);
				break;
			case 6:
				imagebmp($ni,$toFile);
				break;
			default:
				return false;
		}
		imagedestroy($ni);
	}
	imagedestroy($im);
	return true;
}



switch($_REQUEST['action']) {

    case "upload":

    $file_temp = $_FILES['file']['tmp_name'];
    $file_name = $_FILES['file']['name'];
   
	$file_name = iconv("UTF-8","GB2312", $file_name);

    $file_path =  realpath(".")."/uploads";
	if (!@file_exists($file_path)) 
	{
		mkdir($file_path);
	}
	 $file_path =  realpath(".")."/uploads/".XN_Application::$CURRENT_URL;
	if (!@file_exists($file_path)) 
	{
		mkdir($file_path);
	}   
    //checks for duplicate files

	
	$type = array_pop(explode(".",$file_name));
	$new_file_name = date("Ymdhis").".".$type;

    if(!file_exists($file_path."/".$new_file_name)) {

         //complete upload
		
         $filestatus = move_uploaded_file($file_temp,$file_path."/".$new_file_name);

         if(!$filestatus) {
         $success = "false";
         array_push($errors,"Upload failed. Please try again.");
         }
		 $file_name = $file_path."/".$new_file_name;
		 $litpic = str_replace('.','_t.',$file_name);
		 @ImageResize($file_name,100,69,$litpic);
		 $litpic = str_replace('.','_s.',$file_name);
		 @ImageResize($file_name,75,75,$litpic);

		 $size = GetImageSize($file_name);
		 $width = $size[0];
		 $height = $size[1];
		 $newwidth = 800;
		 $newheight = $height*$newwidth/$width;

		  @ImageResize($file_name,$newwidth,$newheight,$file_name);


/*$image = new Imagick();
$image->readImage($file_name);
$resolution = $image->getImageResolution();
$d = $image->getImageGeometry(); 
$image->setImageResolution(72,72);
$width = $d['width'] / $resolution[x] * 72;
$height = $d['height'] / $resolution[y] * 72;
$image->resizeImage($width,$height, imagick::FILTER_LANCZOS, 0.9, true);
$image->writeImage($file_name); 
$image->clear();
$image->destroy(); */



    }
    else {
    $success = "false";
    array_push($errors,"File already exists on server.");
    }

    break;

    default:
    $success = "false";
    array_push($errors,"No action was requested.");

}

return_result($success,$errors,$data);

?>
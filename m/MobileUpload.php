<?php
	set_time_limit(0);
	ini_set('post_max_size', '120M');
	ini_set('upload_max_filesize', '100M');
	
	upload_log('$_FILES => ' . print_r($_FILES,true)); 

	global $upload_badext;

	function uploadpath($subpath)
	{
		$filepath = '/storage';
		if (!is_dir($_SERVER['DOCUMENT_ROOT'].$filepath))
		{
			mkdir($_SERVER['DOCUMENT_ROOT'].$filepath);
		}
		$filepath .= '/mobileupload';
		if (!is_dir($_SERVER['DOCUMENT_ROOT'].$filepath))
		{
			mkdir($_SERVER['DOCUMENT_ROOT'].$filepath);
		}
		if(!empty($subpath))
		{
			$filepath .= '/'.$subpath;
			if (!is_dir($_SERVER['DOCUMENT_ROOT'].$filepath))
			{
				mkdir($_SERVER['DOCUMENT_ROOT'].$filepath);
			}
		} 
		$filepath .= '/'.date("Ym");
		if (!is_dir($_SERVER['DOCUMENT_ROOT'].$filepath))
		{
			mkdir($_SERVER['DOCUMENT_ROOT'].$filepath);
		}
		return $filepath.'/';
	}
	function upload_log($info)
    {
        $fp = fopen('log.txt', 'a');
        fwrite($fp, $info . "\r\n\r\n");
        fclose($fp);
    }
	$echomsg = array ();
	try
	{
		$verifyToken = md5('unique_salt'.$_POST['timestamp']);
		if (!empty($_FILES) && $_POST['token'] == $verifyToken)
		{
			$index = 0;
			foreach ($_FILES as $key => $filedata)
			{
				if (isset($filedata['original_name']) && $filedata['original_name'] != null)
				{
					$file_name = $filedata['original_name'];
				}
				else
				{
					$file_name = $filedata['name'];
				}
				$filetmp_name     = $filedata['tmp_name'];
				
				upload_log('$filedata => ' . print_r($filedata,true)); 				 
				
				$hashval          = md5_file($filetmp_name);
				$upload_file_path = uploadpath($_POST['path']);
				if (isset($_POST['filetype']) && $_POST['filetype'] != "")
				{
					$savefile = $hashval."_".$_POST['platform'].".".$_POST['filetype'];
				}
				else
				{
					$filename = ltrim(basename(" ".$file_name));
					$savefile = $hashval."_".$_POST['platform'].".".end(explode('.', $filename));
				}
				
				if (!file_exists($_SERVER['DOCUMENT_ROOT'].$upload_file_path.$savefile))
				{
					$upload_status = move_uploaded_file($filetmp_name, $_SERVER['DOCUMENT_ROOT'].$upload_file_path.$savefile);
				}
				$srcFile             = "http://".$_SERVER["HTTP_HOST"].$upload_file_path.$savefile;
upload_log('URL -> '.$srcFile);
				$echomsg["srcurl"]['"'.$index.'"'] = $srcFile;
				$index ++;
			}
		}
		else
		{
			$echomsg["error"] = "405";
		}
	}
	catch (XN_Exception $e)
	{
		$echomsg["error"] = "406";
	}
	echo json_encode($echomsg);
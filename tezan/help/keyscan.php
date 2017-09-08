<?php

function keymatch($str)
{
		preg_match('/(\d+),(.+)/', $str, $matches);
		if (count($matches) == 3)
		{
			return array('id'=>$matches[1],'name'=>$matches[2]);
		}
		return $str;
}

function seems_utf8($str) 
{
  $length = strlen($str);  
 for ($i=0; $i < $length; $i++) {
  $c = ord($str[$i]);
  if ($c < 0x80) $n = 0; # 0bbbbbbb
  elseif (($c & 0xE0) == 0xC0) $n=1; # 110bbbbb
  elseif (($c & 0xF0) == 0xE0) $n=2; # 1110bbbb
  elseif (($c & 0xF8) == 0xF0) $n=3; # 11110bbb
  elseif (($c & 0xFC) == 0xF8) $n=4; # 111110bb
  elseif (($c & 0xFE) == 0xFC) $n=5; # 1111110b
  else return false; 
  for ($j=0; $j<$n; $j++) { # n bytes matching 10bbbbbb follow ?
   if ((++$i == $length) || ((ord($str[$i]) & 0xC0) != 0x80))
    return false;
  }
 }
 return true;
}

function trans($str)
{
	if (seems_utf8($str))
	{
		return $str;
	}	
	return iconv( 'gb2312', 'utf-8', $str );
}
function sbasename($file) {
	$t = explode(".",$file);
	return $t[0];
}


function myscandir($path,$links)
{	 
	$mydir=dir($path);	
	while($file=$mydir->read()){
		$p=$path.'/'.$file;
		$fileext = end(explode(".",$file ));
		$basename = sbasename($file);
		if(($fileext == "html" OR $fileext == "" ) AND $file !="." AND $file!="..")
		{
			 $content = file_get_contents($p);
			 $find = $_REQUEST['key'];
			 $find = mb_convert_encoding($find, 'gbk', 'utf-8');
			 if (strpos($content, $find) > 0 ) 
			 {
				   foreach($links as $word => $linkmenus)
				   {
						foreach($linkmenus as $linkid => $linkmenu)
					    {
							if ($linkmenu['file'] == $file)
							{
								echo '<a onclick="QueryLink(\''.$linkid.'\',\''.$linkmenu['name'].'\')">'.$linkmenu['name'].'</a><br>';
							}
						}
				   }					
			 }
					
	    }
	        
		if((is_dir($p)) AND ($file!=".") AND ($file!="..") AND strpos($p, ".files") == 0 AND strpos($p, "svn") == 0 AND strpos($p, "images") == 0 AND strpos($p, "zTree") == 0)
		{
			  myscandir($p,$links);
		}
	}  
}
if(isset($_REQUEST['key']) && $_REQUEST['key'] != "")
{
	require_once('menudata.php');
	myscandir(dirname(__FILE__), $links);
}

?>
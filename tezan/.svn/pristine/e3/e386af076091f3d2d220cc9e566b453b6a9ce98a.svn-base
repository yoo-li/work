<?php
	
svn_auth_set_parameter(SVN_AUTH_PARAM_DEFAULT_USERNAME, 'tezan');
svn_auth_set_parameter(SVN_AUTH_PARAM_DEFAULT_PASSWORD, 'tezanjqka2168');
echo svn_update(realpath('/raid5/apps/new/help'));

if (function_exists('opcache_reset')) 
{
opcache_reset();
}


require_once('py.php');
global $py;
$py = new PYInitials('utf-8'); 
global  $links;
$links = array();


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
 # get length, for utf8 this means bytes and not characters
 $length = strlen($str);  

 # we need to check each byte in the string
 for ($i=0; $i < $length; $i++) {

  # get the byte code 0-255 of the i-th byte
  $c = ord($str[$i]);

  # utf8 characters can take 1-6 bytes, how much
  # exactly is decoded in the first character if 
  # it has a character code >= 128 (highest bit set).
  # For all <= 127 the ASCII is the same as UTF8.
  # The number of bytes per character is stored in 
  # the highest bits of the first byte of the UTF8 
  # character. The bit pattern that must be matched
  # for the different length are shown as comment.
  #
  # So $n will hold the number of additonal characters

  if ($c < 0x80) $n = 0; # 0bbbbbbb
  elseif (($c & 0xE0) == 0xC0) $n=1; # 110bbbbb
  elseif (($c & 0xF0) == 0xE0) $n=2; # 1110bbbb
  elseif (($c & 0xF8) == 0xF0) $n=3; # 11110bbb
  elseif (($c & 0xFC) == 0xF8) $n=4; # 111110bb
  elseif (($c & 0xFE) == 0xFC) $n=5; # 1111110b
  else return false; # Does not match any model

  # the code now checks the following additional bytes
  # First in the if checks that the byte is really inside the
  # string and running over the string end.
  # The second just check that the highest two bits of all 
  # additonal bytes are always 1 and 0 (hexadecimal 0x80)
  # which is a requirement for all additional UTF-8 bytes

  for ($j=0; $j<$n; $j++) { # n bytes matching 10bbbbbb follow ?
   if ((++$i == $length) || ((ord($str[$i]) & 0xC0) != 0x80))
    return false;
  }
 }
 return true;
}
function transfilename($str)
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

global $_linkid;
$_linkid = 10;
function linkid()
{
	global $_linkid;
	$_linkid ++;
	return $_linkid;
}
	    function myscandir($path)
		{	 
			global $py;
			global  $links;
			global $linkid;
			$linkid ++;
	        $mydir=dir($path);	 
			$files = array();
	        while($file=$mydir->read()){
	            $p=$path.'/'.$file;
				$temp = explode(".",$file );
				$fileext = end($temp);
				$basename = sbasename($file);
				if(($fileext == "html" OR $fileext == "" ) AND $file !="." AND $file!="..")
				{
					$match = keymatch($basename);	
					$linkid = linkid();
					if (is_array($match))
					{
						$newname = transfilename($match['name']); 
						$files[$match['id']] =  array('linkid'=>$linkid,'name'=> $newname);						
						$word = $py->getapy($match['name']);
						$links[$word][$linkid] =  array('path'=>$path,'name'=> $newname ,'file' => $file);
					}
					else
					{
						$newname = transfilename($basename ); 
						$files[$linkid*1000] =  array('linkid'=>$linkid,'name'=> $newname);
						$word = $py->getapy($basename); 
						echo '___'.$linkid.'______'.$newname.'_____'.$basename.'___['.$word.']__________'.$file.'___'.$fileext.'_<br>';						
						$links[$word][$linkid] =  array('path'=>$path,'name'=> $newname ,'file' => $file);
					}
	            }
	        
	            if((is_dir($p)) AND ($file!=".") AND ($file!="..") AND strpos($p, ".files") == 0 AND strpos($p, "svn") == 0 AND strpos($p, "images") == 0 AND strpos($p, "zTree") == 0)
				{
					$match = keymatch($basename);
					$linkid = linkid();
					if (is_array($match))
					{
						$newname = transfilename($match['name']); 
						$files[$match['id']] =  array('linkid'=>$linkid,'name'=> $newname ,'file' =>  myscandir($p));
					}
					else
					{
						$newname = transfilename($basename ); 
						$files[$linkid*1000] =  array('linkid'=>$linkid,'name'=> $newname ,'file' =>  myscandir($p));
					}
	            }
	        }  
			ksort($files);
			return $files;
	    }

	   $result = myscandir(dirname(__FILE__).'/ma');

	   ksort($links);
	  // print_r( $result);

	   file_exists("menudata.php") or touch("menudata.php");
       file_put_contents("menudata.php","<?php \n \$links = ".var_export($links, TRUE)."; \n\n\$helpmenu = ".var_export($result, TRUE).";\n?>");
	    
?>
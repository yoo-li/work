<?php



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

if(isset($_REQUEST['linkid']) && $_REQUEST['linkid'] == '0')
{
		require_once('menudata.php');
		foreach($helpmenu as  $menulink)
		{
			if ($menulink['name'] == '软件初次使用向导')
			{
				$_REQUEST['linkid'] = $menulink['linkid'];
			}
		}
}


if(isset($_REQUEST['linkid']) && $_REQUEST['linkid'] != '')
{

		require_once('menudata.php');
		foreach($links as $word => $menulinks)
		{
			foreach($menulinks as $linkid => $menulink)
			{
				if ($linkid == $_REQUEST['linkid'])
				{
					$file = $menulink['path'].'/'.$menulink['file'];
					if (@file_exists($file)) 
					{
						$path = str_replace(dirname(__FILE__),"",$menulink['path']);
						$file =  ".".$path."/".$menulink['file'];
						if (seems_utf8($file))
						{
							header('Content-Type:text/html;charset=utf-8');
						}else
						{
							header('Content-Type:text/html;charset=gb2312');
						}
							
						echo $file;
					}
				}
			}
		}

}


?>
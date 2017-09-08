<?php
	$HTTP_DIR = '/modules/Logistics' ;
	header('Content-type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
	echo "<feed>\n";
   
  $path =  realpath(".")."/uploads/".XN_Application::$CURRENT_URL;
  $handle=opendir($path);    
  while ($item = readdir($handle))    
  {
	   if( ! is_dir( $item ) )
		{
			 if (strpos($item,"_s") > 0) continue;
			 if (strpos($item,"_t") > 0) continue;
			 $type = array_pop(explode(".",$item));    
			 $imgtype=array('jpg','jpeg','png','gif','JPG','JPEG','PNG','GIF');          
			 for($i=0;$i<8;$i++)
			 {
				if($type==$imgtype[$i])  
				{
					$basename = iconv("GB2312","UTF-8", $item);
					$link = $HTTP_DIR."/uploads/".XN_Application::$CURRENT_URL."/".urlencode($basename);
					$slink = str_replace('.'.$type,'_s.'.$type,$link);
					$tlink = str_replace('.'.$type,'_t.'.$type,$link);
					echo "<entry><title>". $basename ."</title><link>".$link."</link><slink>".$slink."</slink><tlink>".$tlink."</tlink></entry>"; 

				}
			 }                    
	   }      
  }
  closedir($handle); 

echo "</feed>"
?>
<?php

$configfile = $_SERVER['DOCUMENT_ROOT'].'/wx/config.wxroles.inc.php';

//更新配置函数
function ReWriteConfig()
{
    global $configfile;
	if (@file_exists($configfile))
	{
		if(!is_writeable($configfile))
		{
			echo '配置文件'.$configfile.'不支持写入，无法修改微信的回复规则配置参数！';
			die;
		}
	}
	@unlink($configfile);
    $fp = fopen($configfile,'w+');
    flock($fp,3);
   
	$sysconfigs = XN_Query::create ( 'MainContent' )->tag('wxroles')
					->filter ( 'type', 'eic', 'wxroles')
					->filter ( 'my.status', '=', 'Active') 
					->filter ( 'my.deleted', '=', '0') 
					->end(-1)
					->execute ();
   $wxrolesettings = "<?php\n\t\$wxrolesconfig = array (\n";
   foreach($sysconfigs as $sysconfig_info)
    {
		 $roleid= $sysconfig_info->id;
		 $wxid= $sysconfig_info->my->wxid;
	     $reply = $sysconfig_info->my->reply;
		 $triggerkey = $sysconfig_info->my->triggerkey;  
 		 
 		 $wxroletype = $sysconfig_info->my->wxroletype; 
 		 $replytitle = $sysconfig_info->my->replytitle; 
 		 $image = $sysconfig_info->my->image;
 		 $description = $sysconfig_info->my->description;
 		 $description = str_replace("'","\\'",$description);
		 $reply = str_replace("'","\\'",$reply);
         
         $wxrolesettings .= "\t\t'$roleid' => array (\n\t\t\t'wxid'=>'".$wxid."',".
								 			 "\n\t\t\t'triggerkey'=>'".$triggerkey."',".
											 "\n\t\t\t'wxroletype'=>'".$wxroletype."',".
											 "\n\t\t\t'replytitle'=>'".$replytitle."',".
										     "\n\t\t\t'image'=>'".$image."',".
											 "\n\t\t\t'description'=>'".$description."',". 
									 		 "\n\t\t\t'reply'=>'".$reply."',),\n";
    }
	$wxrolesettings .= "\t);\n?>";  
    fwrite($fp,$wxrolesettings);
    fclose($fp);
}
if (!@file_exists($configfile)) ReWriteConfig();

?>
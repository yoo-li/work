<?php
global $mod_strings,$app_strings,$theme,$currentModule,$current_user,$supplierid,$supplierusertype;
$ids=$_REQUEST['ids'];
$ids=explode(",",$ids);
$lists=XN_Content::loadMany($ids,strtolower($currentModule)); 
 
$tag = strtolower($currentModule).",".strtolower($currentModule)."_".$supplierid; 
foreach($lists as $info)
{
	if ($info->my->status != 1)
	{
	    $info->my->status = 1;
	    $info->save($tag);  
	} 
} 
echo '{"statusCode":"200","message":"停用成功！"}';
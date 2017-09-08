<?php

if (isset($_REQUEST['checkcode']) && $_REQUEST['checkcode'] != ""  &&
	isset($_REQUEST['guid']) && $_REQUEST['guid'] != "" )
{
	$checkcode = $_REQUEST['checkcode'];
	$guid = $_REQUEST['guid'];
	try
	{ 
		  $cache_checkcode = XN_MemCache::get("checkcode_".$guid);
          if (strtolower($cache_checkcode) == strtolower($checkcode))
          {
               echo '{"ok":"Pass"}'; 
          }
          else
          {
              echo '{"error":"验证码输入错误"}'; 
          } 
	}
	catch (XN_Exception $e) 
	{ 
		echo '{"error":"验证码已经过期"}';
	}  
} 
?>
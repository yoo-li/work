<?php

if (isset($_REQUEST['checkcode']) && $_REQUEST['checkcode'] != ""  &&
	isset($_REQUEST['profileid']) && $_REQUEST['profileid'] != "" )
{
	$checkcode = $_REQUEST['checkcode'];
	$profileid = $_REQUEST['profileid'];
	try
	{ 
		  $cache_checkcode = XN_MemCache::get("sendmobilecode_".$profileid);
          if (strtolower($cache_checkcode) == strtolower($checkcode))
          {
               echo '{"ok":"Pass"}'; 
          }
          else
          {
              echo '{"error":"短信验证码输入错误"}'; 
          } 
	}
	catch (XN_Exception $e) 
	{ 
		echo '{"error":"短信验证码已经过期"}';
	}  
} 
?>
<?php

function randomkeys($length)
{
    $pattern='1234567890';
    $key='';
    for($i=0;$i<$length;$i++)
    {
        $key .= $pattern{mt_rand(0,9)};    //生成php随机数
    }
    return $key;
}

if (isset($_REQUEST['mobile']) && $_REQUEST['mobile'] != ""  &&
	isset($_REQUEST['profileid']) && $_REQUEST['profileid'] != ""  &&
	isset($_REQUEST['guid']) && $_REQUEST['guid'] != "" )
{
	$mobile = $_REQUEST['mobile'];
	$profileid = $_REQUEST['profileid'];
	$guid = $_REQUEST['guid'];
	try
	{ 
		  $cache_guid = XN_MemCache::get("sendmobile_".$profileid);
          if (strtolower($cache_guid) == strtolower($guid))
          {
			  
		  	try
		  	{ 
		  		   $cache_time = XN_MemCache::get("sendmobile_lock_".$profileid); 
				   $difftime = strtotime("now") - intval($cache_time);
				   echo '{"status":300,"difftime":'.$difftime.',"msg":"'.$difftime.'秒之前短信已经发送，请您稍等一会!"}';
		  	}
		  	catch (XN_Exception $e) 
		  	{ 
		  		$checkcode = randomkeys(6);  
		  		XN_Content::create('sendmobile', '',false,2)
		  			->my->add('status','waiting')
		  			->my->add('type','simple')
		  			->my->add('to_mobile',$mobile)
					->my->add('checkcode',$checkcode)
		  			->my->add('contents','您的验证码:'.$checkcode)
		  			->save("sendmobile");
				
				XN_MemCache::put($checkcode,"sendmobilecode_".$profileid,"600"); 
				XN_MemCache::put(strtotime("now"),"sendmobile_lock_".$profileid,"120");
                echo '{"status":200,"msg":"发送成功"}';
		  	}    
          }
          else
          {
              echo '{"status":300,"difftime":0,"msg":"验证码输入错误!"}'; 
          } 
	}
	catch (XN_Exception $e) 
	{ 
		echo '{"status":300,"difftime":0,"msg":"验证码已经过期!"}';
	}  
} 
?>
<?php

 

//更新配置函数
function ReWriteConfig()
{ 
	$sysconfigs = XN_Query::create ( 'Content' )->tag('supplier_wxsettings')
					->filter ( 'type', 'eic', 'supplier_wxsettings')  
					->filter ( 'my.deleted', '=', '0') 
					->end(-1)
					->execute (); 
   foreach($sysconfigs as $sysconfig_info)
    {
		 $wxid= $sysconfig_info->id;
	     $wxname = $sysconfig_info->my->wxname;
		 $appid = $sysconfig_info->my->appid;
		 $supplierid = $sysconfig_info->my->supplierid;
		 $secret = $sysconfig_info->my->secret;
		 $token = $sysconfig_info->my->token;
		 $wxtype = $sysconfig_info->my->wxtype; 
		 $welcometitle = $sysconfig_info->my->welcometitle; 
		 $image = $sysconfig_info->my->image;
		 $originalid = $sysconfig_info->my->originalid;
		 
		 $weixintype = $sysconfig_info->my->weixintype;
		 $weixinpay = $sysconfig_info->my->weixinpay;
		 $mchid = $sysconfig_info->my->mchid;
		 $mchkey = $sysconfig_info->my->mchkey;
		 $sslcert = $sysconfig_info->my->sslcert;
		 $sslkey = $sysconfig_info->my->sslkey;
		 
		 $defaultreply = $sysconfig_info->my->defaultreply;
		 $defaultreply = str_replace("'","\\'",$defaultreply);
		 $description = $sysconfig_info->my->description;
		 $description = str_replace("'","\\'",$description);
		 $welcomewords = $sysconfig_info->my->welcomewords;
         $welcomewords = str_replace("'","\\'",$welcomewords); 
		 
		 $weixintype = $sysconfig_info->my->weixintype;
		 $weixinpay = $sysconfig_info->my->weixinpay;
		 $mchid = $sysconfig_info->my->mchid;
		 $mchkey = $sysconfig_info->my->mchkey;
		 $sslcert = $sysconfig_info->my->sslcert;
		 $sslkey = $sysconfig_info->my->sslkey;
		 
		 $wxsetting = array();
		 $wxsetting['wxid'] = $wxid;
		 $wxsetting['wxname'] = $wxname;
		 $wxsetting['appid'] = $appid;
		 $wxsetting['supplierid'] = $supplierid;
		 $wxsetting['originalid'] = $originalid;  
		 $wxsetting['secret'] = $secret; 
		 $wxsetting['token'] = $token; 
		 $wxsetting['wxtype'] = $wxtype; 
		 $wxsetting['welcometitle'] = $welcometitle; 
		 $wxsetting['description'] = $description; 
		 $wxsetting['defaultreply'] = $defaultreply; 
		 $wxsetting['image'] = $image; 
		 $wxsetting['welcomewords'] = $welcomewords; 
		 
		 $wxsetting['qrcodeimage'] = $sysconfig_info->my->qrcodeimage;
		 $wxsetting['adbackgroundimage'] = $sysconfig_info->my->adbackgroundimage;
		 
		 $wxsetting['weixintype'] = $weixintype; 
		 $wxsetting['weixinpay'] = $weixinpay; 
		 $wxsetting['mchid'] = $mchid; 
		 $wxsetting['mchkey'] = $mchkey; 
		 $wxsetting['sslcert'] = $sslcert; 
		 $wxsetting['sslkey'] = $sslkey; 

		 
	 	 $sysconfigs = XN_Query::create ( 'Content' )->tag('supplier_wxroles')
	 					->filter ( 'type', 'eic', 'supplier_wxroles')
	 					->filter ( 'my.wxid', '=', $wxid) 
						->filter ( 'my.status', '=', 'Active') 
	 					->filter ( 'my.deleted', '=', '0') 
	 					->end(-1)
	 					->execute (); 
		 if (count($sysconfigs) > 0)
	     { 
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
		 
				 $wxrolesettings = array();		 
	             $wxrolesettings['roleid'] = $roleid;
				 $wxrolesettings['wxid'] = $wxid;
				 $wxrolesettings['triggerkey'] = $triggerkey;
				 $wxrolesettings['wxroletype'] = $wxroletype;
				 $wxrolesettings['replytitle'] = $replytitle; 
				 $wxrolesettings['description'] = $description;
				 $wxrolesettings['image'] = $image;
				 $wxrolesettings['reply'] = str_replace('\'','\\\'',$reply); 
				 $wxsetting['wxrolesettings'][] = $wxrolesettings; 
		 	}
	     } 
		 XN_MemCache::put($wxsetting,"wxsettings_".$appid);  
		  
    } 
}
if (!@file_exists($configfile)) ReWriteConfig(); 
?>
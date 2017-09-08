<?php
 
if (! class_exists('XN_Message')) 
{ 
	class XN_Message
	{    
		public static function get_wx_secret($appid) 
		{
			$wx_info = array();
			$wxsettings = XN_Query::create('MainContent')
					->tag('wxsettings')
					->filter('type','eic','wxsettings')
					->filter('my.deleted','=','0')
					->filter('my.appid','=',$appid)  
					->begin(0)
					->end(1)
					->execute();
			if(count($wxsettings) > 0)
			{
				$wxsetting_info = $wxsettings[0]; 
		   		$appid = $wxsetting_info->my->appid;
				$wxid = $wxsetting_info->id;
		   		$secret = $wxsetting_info->my->secret;
				$wx_info['appid'] = $appid;
				$wx_info['wxid'] = $wxid;
				$wx_info['secret'] = $secret; 
			}
			else
			{
				$wxsettings = XN_Query::create('MainContent')
						->tag('supplier_wxsettings')
						->filter('type','eic','supplier_wxsettings')
						->filter('my.deleted','=','0')
						->filter('my.appid','=',$appid)  
						->begin(0)
						->end(1)
						->execute();
				if(count($wxsettings) > 0)
				{
					$wxsetting_info = $wxsettings[0]; 
			   		$appid = $wxsetting_info->my->appid;
					$wxid = $wxsetting_info->id;
			   		$secret = $wxsetting_info->my->secret;
					$wx_info['appid'] = $appid;
					$wx_info['wxid'] = $wxid;
					$wx_info['secret'] = $secret; 
				} 
			}
			return $wx_info;
		}
		public static function sendmessage($profileid,$msg,$appid=null,$wxopenid=null) 
		{
			if ($wxopenid == null && $appid == null)
			{
	  		      $lastlogins=XN_Query::Create("MainContent")
	  		            ->tag("lastloginlog_".$profileid)
	  		            ->filter("type","eic","lastloginlog")
	  		            ->filter("my.profileid","=",$profileid)
	  		            ->filter("my.deleted","=",'0')
	  		            ->end(1)
	  		            ->execute();
	  			  if (count($lastlogins) > 0)
	  			  {
	  			   		$lastlogin_info = $lastlogins[0];
	  					$appid = $lastlogin_info->my->appid; 
  				        if (isset($appid) && $appid != '')
						{
						 	$wxopenids = XN_Query::create ( 'MainContent' )->tag("wxopenids_".$profileid)
						 						->filter ( 'type', 'eic', 'wxopenids')  
						 						->filter ( 'my.profileid', '=', $profileid)
												->filter ( 'my.appid', '=', $appid)
						 						->end(1)
						 						->execute ();
						 	if (count($wxopenids) > 0 )	
						 	{
								$wxopenid_info = $wxopenids[0];
								$wxopenid = $wxopenid_info->my->wxopenid;
							}  
						} 
				}
		   }
		   if  ($appid != null && $wxopenid == null)
		   {
			   $wxopenids = XN_Query::create ( 'MainContent' )->tag("wxopenids_".$profileid)
						 						->filter ( 'type', 'eic', 'wxopenids')  
						 						->filter ( 'my.profileid', '=', $profileid)
												->filter ( 'my.appid', '=', $appid)
						 						->end(1)
						 						->execute ();
			 	if (count($wxopenids) > 0 )	
			 	{
					$wxopenid_info = $wxopenids[0];
					$wxopenid = $wxopenid_info->my->wxopenid;
				}  
		   }
		   if ($wxopenid != null && $appid != null)
		   {
			   	   $wxsettings = self::get_wx_secret($appid);
				   if (count($wxsettings))
				   { 
		 			   try{ 
					  	   require_once (XN_INCLUDE_PREFIX."/XN/Wx.php");
						   $wxid = $wxsettings['wxid'];
				   		   XN_WX::$APPID = $wxsettings['appid'];
				   		   XN_WX::$SECRET = $wxsettings['secret'];
						   XN_WX::sendtextmessage($wxopenid,$msg);  
			 			   $tag = "messages,messages_".$profileid;
		 			  	   XN_Content::create('message','wxmessage',false,6)			
		 			  			  ->my->add('deleted','0')
		 			  			  ->my->add('messagestatus','0')
		 			  	  		  ->my->add('messagetype','1')
		 			  			  ->my->add('toprofileid',$profileid)
		 			  			  ->my->add('fromprofileid',XN_Profile::$VIEWER) 
		 			  			  ->my->add('viewtime','')
								  ->my->add('appid',$wxid)
		 			  			  ->my->add('message',$msg)
		 			  			  ->save($tag); 
		 			  }
		 			  catch(XN_Exception $e){
		 			      //throw $e;
		 			  } 
				   }
				   else
				   {
						$users = XN_Query::create('Content')
								->tag('users')
								->filter('type','eic','users')
								->filter('my.deleted','=','0')
								->filter('my.profileid','=',$profileid)  
								->begin(0)
								->end(1)
								->execute();
						if(count($users) > 0)
						{
							self::send($profileid,XN_Profile::$VIEWER,$msg);
						} 
				  } 
			  }
		    
		} 
		public static function sendimagemessage($profileid,$mediaid,$appid=null,$wxopenid=null) 
		{
			if ($wxopenid == null && $appid == null)
			{
	  		      $lastlogins=XN_Query::Create("MainContent")
	  		            ->tag("lastloginlog_".$profileid)
	  		            ->filter("type","eic","lastloginlog")
	  		            ->filter("my.profileid","=",$profileid)
	  		            ->filter("my.deleted","=",'0')
	  		            ->end(1)
	  		            ->execute();
	  			  if (count($lastlogins) > 0)
	  			  {
	  			   		$lastlogin_info = $lastlogins[0];
	  					$appid = $lastlogin_info->my->appid; 
  				        if (isset($appid) && $appid != '')
						{
						 	$wxopenids = XN_Query::create ( 'MainContent' )->tag("wxopenids_".$profileid)
						 						->filter ( 'type', 'eic', 'wxopenids')  
						 						->filter ( 'my.profileid', '=', $profileid)
												->filter ( 'my.appid', '=', $appid)
						 						->end(1)
						 						->execute ();
						 	if (count($wxopenids) > 0 )	
						 	{
								$wxopenid_info = $wxopenids[0];
								$wxopenid = $wxopenid_info->my->wxopenid;
							}  
						} 
				}
		   }
		   if  ($appid != null && $wxopenid == null)
		   {
			   $wxopenids = XN_Query::create ( 'MainContent' )->tag("wxopenids_".$profileid)
						 						->filter ( 'type', 'eic', 'wxopenids')  
						 						->filter ( 'my.profileid', '=', $profileid)
												->filter ( 'my.appid', '=', $appid)
						 						->end(1)
						 						->execute ();
			 	if (count($wxopenids) > 0 )	
			 	{
					$wxopenid_info = $wxopenids[0];
					$wxopenid = $wxopenid_info->my->wxopenid;
				}  
		   }
		   if ($wxopenid != null && $appid != null)
		   {
			   	   $wxsettings = self::get_wx_secret($appid);
				   if (count($wxsettings))
				   {
				  	   require_once (XN_INCLUDE_PREFIX."/XN/Wx.php");
					   $wxid = $wxsettings['wxid'];
			   		   XN_WX::$APPID = $wxsettings['appid'];
			   		   XN_WX::$SECRET = $wxsettings['secret'];
					   XN_WX::sendimagemessage($wxopenid,$mediaid);  
		 			   $tag = "messages,messages_".$profileid;
		 			   try{ 
		 			  	  XN_Content::create('message','wxmessage',false,6)			
		 			  			  ->my->add('deleted','0')
		 			  			  ->my->add('messagestatus','0')
		 			  	  		  ->my->add('messagetype','1')
		 			  			  ->my->add('toprofileid',$profileid)
		 			  			  ->my->add('fromprofileid',XN_Profile::$VIEWER) 
		 			  			  ->my->add('viewtime','')
								  ->my->add('appid',$wxid)
		 			  			  ->my->add('message',$mediaid)
		 			  			  ->save($tag); 
		 			  }
		 			  catch(XN_Exception $e){
		 			      throw $e;
		 			  } 
				   }
				   else
				   {
						$users = XN_Query::create('Content')
								->tag('users')
								->filter('type','eic','users')
								->filter('my.deleted','=','0')
								->filter('my.profileid','=',$profileid)  
								->begin(0)
								->end(1)
								->execute();
						if(count($users) > 0)
						{
							self::send($profileid,XN_Profile::$VIEWER,$mediaid);
						} 
				  } 
			  }
		    
		} 
		public static function send($toprofileid,$fromprofileid,$msg) 
		{ 
			  $tag = "messages,messages_".$toprofileid.",messages_".$fromprofileid;
			  try{ 
			  	  XN_Content::create('message','message',false,6)			
			  			  ->my->add('deleted','0')
			  			  ->my->add('messagestatus','0')
			  	  		  ->my->add('messagetype','1')
			  			  ->my->add('toprofileid',$toprofileid)
			  			  ->my->add('fromprofileid',$fromprofileid) 
			  			  ->my->add('viewtime','')
						  ->my->add('appid','')
			  			  ->my->add('message',$msg)
			  			  ->save($tag); 
			  }
			  catch(XN_Exception $e){
			      throw $e;
			  }
		} 
		public static function push($toprofileid,$fromprofileid,$product,$msg,$sound="") 
		{
			$baidupushs = XN_Query::create ( 'Content' ) ->tag("baidupushs")
				    ->filter ( "type","eic","baidupushs")
					->filter ( 'my.pushproduct', '=', $product )   
					->execute ();
			$appids = array();
			if (count($baidupushs) > 0)
			{
				foreach($baidupushs as $baidupush_info)
				{ 
					$appid = $baidupush_info->my->appid;
					$apikey = $baidupush_info->my->apikey;
					$secretkey = $baidupush_info->my->secretkey;
					$devicetype = $baidupush_info->my->devicetype;
					$deploy_status = $baidupush_info->my->deploy_status;
					$appids[$appid]['id'] =  $baidupush_info->id;
					$appids[$appid]['apikey'] =  $apikey;
					$appids[$appid]['secretkey'] =  $secretkey;
					$appids[$appid]['devicetype'] =  $devicetype;
					$appids[$appid]['deploy_status'] =  $deploy_status;
				}
			}
			if (count($appids) > 0)
			{ 
		 
				$apikey = $baidupush_info->my->apikey;
				$secretkey = $baidupush_info->my->secretkey;
				$devicetype = $baidupush_info->my->devicetype;
				$appid = $baidupush_info->my->appid;
				
				$pushmsgbinds = XN_Query::create ( 'Content' ) ->tag("pushmsgbinds_".$toprofileid)
					    ->filter ( "type","eic","pushmsgbinds")
						->filter ( 'my.appid', 'in', array_keys($appids) )   
						->filter ( 'my.profileid', '=', $toprofileid ) 
						->execute ();
				if (count($pushmsgbinds) > 0)
				{
					 $pushmsgbind_info = $pushmsgbinds[0];
					 $mobileid = $pushmsgbind_info->my->mobileid;
					 $userid = $pushmsgbind_info->my->userid;
					 $appid = $pushmsgbind_info->my->appid;
					 $baidupushid = $appids[$appid]['id'];
 					 $apikey = $appids[$appid]['apikey'];
 					 $secretkey = $appids[$appid]['secretkey'];
 					 $devicetype = $appids[$appid]['devicetype'];
					 $deploy_status = $appids[$appid]['deploy_status'];
					 
		 			 $tag = "messages,messages_".$toprofileid.",messages_".$fromprofileid;
					 if ($devicetype == "4")
					 { 
						 if ($sound != "")
						 {
						 	$sound .= ".caf";
						 }
			 		 	  $messagebody = '{"aps":{"alert":"'.$msg.'","sound":"'.$sound.'","badge":null}}';
					 }
					 else
					 {
						 switch($sound)
						 {
							 case "notifications":
							 	$notification_builder_id = "1";
							 break;
							 case "ads":
							 	$notification_builder_id = "2";
							 break;
							 case "activity":
							 	$notification_builder_id = "3";
							 break;
							 default:
							 	$notification_builder_id = "0";
							 break;
						 } 
						 $messagebody = '{"title":"","description":"'.$msg.'","notification_builder_id":'.$notification_builder_id.',"notification_basic_style":7}';
			 		 	
					 } 
					 try{ 
			 		 	 XN_Content::create('message','push',false,6)			
			 					  ->my->add('deleted','0')
			 					  ->my->add('messagestatus','0')
			 					  ->my->add('appid',$baidupushid)
			 					  ->my->add('channelid',$mobileid)
			 					  ->my->add('apikey',$apikey)
			 					  ->my->add('secretkey',$secretkey)
			 					  ->my->add('devicetype',$devicetype)
			 					  ->my->add('messagetype','2') 
								  ->my->add('deploystatus',$deploy_status) 
			 					  ->my->add('toprofileid',$toprofileid)
			 					  ->my->add('fromprofileid',$fromprofileid) 
			 					  ->my->add('viewtime','')
			 					  ->my->add('sound',$sound)
			 					  ->my->add('message',$msg)
			 					  ->my->add('messagebody',$messagebody)
			 					  ->save($tag);
		   			  }
		   			  catch(XN_Exception $e){
		   			      throw $e;
		   			  }
				}
			}
			 
		}
	} 
}  

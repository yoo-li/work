<?php

global $current_user;

global $app_strings;
global $mod_strings;


if(isset($_REQUEST['record']) && $_REQUEST['record'] != '' && isset($_REQUEST['new_password']) && $_REQUEST['new_password'] != '')
{
	try {	
		if (is_admin($current_user)) 
		{
	           $profile = XN_Profile::load($_REQUEST['record']);
	           $profile->password = $_REQUEST['new_password'];
	           $profile->save();
	           echo 'SUCCESS';	
			   $Body = XN_Application::$CURRENT_URL."的管理员".$current_user->user_name."被密码修改为".$_REQUEST['new_password'].",请注意保存！";

	 	    XN_Content::create('sendemail', '',false,2)			
			  ->my->add('status','waiting')
			  ->my->add('type','simple')
			  ->my->add('to_email','jack.zeng@361crm.com')
			  ->my->add('from_email','')
			  ->my->add('from_name','')
			  ->my->add('subject',XN_Application::$CURRENT_URL."的管理员".XN_Profile::$VIEWER."被密码修改!")
			  ->my->add('contents',$Body)
			  ->save("sendemail");	
			XN_Content::create('sendemail', '',false,2)			
			  ->my->add('status','waiting')
			  ->my->add('type','simple')
			  ->my->add('to_email','vincent@361crm.com')
			  ->my->add('from_email','')
			  ->my->add('from_name','')
			  ->my->add('subject',XN_Application::$CURRENT_URL."的管理员".XN_Profile::$VIEWER."被密码修改!")
			  ->my->add('contents',$Body)
			  ->save("sendemail");	
		}
		else 
		{			
			if(isset($_REQUEST['old_password']) && $_REQUEST['old_password'] != '')
			{
				if (true == XN_Profile::signIn($_REQUEST['record'],$_REQUEST['old_password'], array('set-cookies' => false)))
				{
					   $profile = XN_Profile::load($_REQUEST['record']);
			           $profile->password = $_REQUEST['new_password'];
			           $profile->save();
			           echo 'SUCCESS';	
				}
				else 
				{
					echo $mod_strings['ERR_PASSWORD_INCORRECT_OLD'];
				}
				
			}
			else 
			{
				echo $mod_strings['ERR_PASSWORD_CHANGE_FAILED_1'];			
			}
			
		}
	} catch (XN_Exception $e)
	{		
		 echo $e->getMessage();
    }
}

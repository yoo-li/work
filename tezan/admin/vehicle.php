<?php


header('Content-Type:text/html;charset=utf-8');

$email = "68594864@qq.com";
$password = "123qwe";
$mobile = "15974160318";
$username = "admin#vehicle";
$enterprise = "saasw";



 XN_Application::$CURRENT_URL = 'www';
  try 
  {
		$profile = XN_Profile::load ($username,'username');	
		echo "用户['.$username.']已经创建!<br>";
  }
  catch ( XN_Exception $e ) 
  {
		echo "用户没有创建!<br>";
		 try 
		{
		$profile = XN_Profile::create ( strtolower(trim($email)), $password );
		$profile->fullName = strtolower($username);
		$profile->mobile = trim($mobile);
		$profile->status = 'True';	
		$profile->application = 'www';
		$profile->type = "register";
		$profile->save ();
		echo  '创建用户['.$username.']成功<br>';
		}
	  catch ( XN_Exception $e ) 
	  {
		  echo  '创建用户['.$username.']失败!<br>';
		  die();
	  }
  }

   XN_Profile::$VIEWER = $profile->screenName;
  
   $allowapps = array(
   	     "vehicle"=>"车输管理系统", 
    ); 
 
  foreach ($allowapps as $application => $description)
  {  
		  $app = XN_Application::load($application);  
		  if ( $app->name == "")
		  { 
			try 
			{
			   $props = array('name' => $application,'description' => trim($description));
			   $app = XN_Application::create($application,"",$props); 
			   $app->save();
				echo  '创建企业代码['.$application.']成功<br>';

			}
			catch ( XN_Exception $e ) 
			{
				echo $e->getMessage()."<br>";
				
				echo '创建企业代码['.$application.']失败!<br>';
			}
		 }
		 else
		 {
			   echo '企业代码['.$application.']已经创建!<br>';
			   $app->trialtime = "2020-01-01";
			   $app->save($application);
		 }
		 
 }

 



 

?>
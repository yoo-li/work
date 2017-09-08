<?php


header('Content-Type:text/html;charset=utf-8');

$email = "admin@oldhand.cn";
$password = "123qwe";
$mobile = "15974160308";
$username = "admin";
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
   	"admin"=>"admin", 
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
		/* if (PHP_OS != 'WINNT')
		 {
			linkdir($application);		
		 } */
		// echo '____'.$application.'_______'.$description.'____'.count($citys).'_______<br>'; 
 }


 /*

function  linkdir($application)
{
		 $maindir = "raid5";
		 $application_file = '/'.$maindir.'/apps/'.$application;
		 if (!@file_exists($application_file)) 
		 {
			mkdir($application_file);
			echo '目录创建['.$application_file.']!<br>';
		 }
		 else
		 {
		  echo '['.$application_file.']目录已经创建!<br>';
		 }

		 $links  = array(
			 "atoken.php","base.php","config.data.php","config.inc.php","config.php",
			 "config.system.php","config.template.php","downloadfile.php","forgetpassword.php",
			 "geturbanareas.php","GridFS.php","index.php","initapp.php","initdata.php",
			 "permissions.php","phpinfo.php","Popup.php","register.php","register_next.php",
			 "Runtimeinfo.php","Smarty_setup.php","Upload.php","webservice.php","_xn_prepend.php","gotoken.php",
			 "log4php.properties","favicon.ico","robots.txt",
			 "admin","chat","checkcode","cms","data","cache",
			 "download","help","images","include","log4php","logs",
			 "modules","mp3","Public","Smarty","storage",
			 "test","XN","about",
		 );
		 foreach($links as $link )
		 {
			$sourcelink = '/'.$maindir.'/apps/saasw/'.$link;
			$targetlink = '/'.$maindir.'/apps/'.$application.'/'.$link;
			if (!@file_exists($targetlink)) 
			 {				 
				 symlink ($sourcelink,$targetlink);
				 echo '建立连接 ['.$sourcelink.'] =>  ['.$targetlink.']!<br>';
			 }
		 }
		 $cache_file = '/'.$maindir.'/apps/'.$application.'/cache/'.$application;
		 if (!@file_exists($cache_file)) 
		 {
			mkdir($cache_file); 
		 }
}*/



 

?>
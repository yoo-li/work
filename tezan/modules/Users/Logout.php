<?php
session_start();
$_SESSION=array();
session_destroy();

require_once('modules/Users/LoginHistory.php');
require_once('modules/Users/Users.php');

global $current_user;
// Recording Logout Info
$usip=$_SERVER['REMOTE_ADDR'];
$outtime=date("Y-m-d H:i:s");
$loghistory=new LoginHistory();
$loghistory->user_logout(XN_Profile::$VIEWER,$current_user->user_name,$usip,$outtime);
 
$sessionkey = "user_privileges_".XN_Application::$CURRENT_URL."_".XN_Profile::$VIEWER;
XN_MemCache::delete($sessionkey);

XN_Profile::signOut();
setcookie("xn_id_".XN_Application::$CURRENT_URL,"", time()-3600,'/');
define("IN_LOGIN", true);

// go to the login screen.
header("Location: index.php?action=Login&module=Users");
?>
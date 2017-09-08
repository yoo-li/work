<?php

 
set_include_path(get_include_path() . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT']); 
	
require_once('include/utils/utils.php');
require_once('modules/Users/Users.php');
require_once('config.inc.php');

header('Content-Type:text/html;charset=utf-8');
session_start();

global $currentModule; 
 
$translatedstrings = array();


if (isset($_REQUEST['module']) && $_REQUEST['module'] != "")
{
	$currentModule = $_REQUEST['module'];
	if (isset($_SESSION['authenticated_user_language']) && $_SESSION['authenticated_user_language'] != '')
	{
	    $current_language = $_SESSION['authenticated_user_language'];
	}
	else
	{
	    $current_language = $default_language;
	}
	//set module and application string arrays based upon selected language
	$app_currency_strings = return_app_currency_strings_language($current_language);
	$app_strings          = return_application_language($current_language);
	$app_list_strings     = return_app_list_strings_language($current_language);
	$mod_strings          = return_module_language($current_language, $currentModule);
	 
	echo serialize(array_merge($mod_strings,$app_strings)); 
	die();  
} 
echo serialize(array()); 

?>
<?php
 
session_start(); 

require_once (dirname(__FILE__) . "/../include/config.inc.php");
require_once (dirname(__FILE__) . "/../include/config.common.php");
require_once (dirname(__FILE__) . "/../include/utils.php");
 
 
if(isset($_REQUEST['type']) && $_REQUEST['type'] == 'submit')
{  
	 

    header("Location: index.php");
    die();
}
  
require_once('Smarty_setup.php');  
$smarty = new platform_Smarty;  

$smarty->assign("supplier_info",get_supplier_info()); 
 

 
try{    
    
	
	 
}
catch(XN_Exception $e)
{
	$msg = $e->getMessage();	
	messagebox('错误',$msg);
	die(); 
} 

$smarty->assign("theme_info",get_system_theme_info());	 

$smarty->assign("copyrights",get_copyright_info());	
	
$action = strtolower(basename(__FILE__, ".php"));
$smarty->display($action . '.tpl');  

?>
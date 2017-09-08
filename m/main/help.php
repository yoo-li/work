<?php
 
session_start(); 

require_once (dirname(__FILE__) . "/../include/config.inc.php");
require_once (dirname(__FILE__) . "/../include/config.common.php");
require_once (dirname(__FILE__) . "/../include/utils.php");
  

require_once('Smarty_setup.php');  
$smarty = new platform_Smarty;  

$action = strtolower(basename(__FILE__, ".php"));
$smarty->display($action . '.tpl');  

?>
<?php
 
require_once('Smarty_setup.php');  
$smarty = new platform_Smarty;  

$action = strtolower(basename(__FILE__, ".php"));
$smarty->display($action . '.tpl');  

?>
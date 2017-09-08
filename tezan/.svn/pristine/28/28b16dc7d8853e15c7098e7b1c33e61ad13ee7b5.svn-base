<?php

header('Content-Type:text/html;charset=utf-8');

global $currentModule;
$record = $_REQUEST['record'];
if(isset($record) && $record !='') 
{
	try {
            $loadcontent = XN_Content::load($record,strtolower($currentModule));			
	        echo  $loadcontent->my->flowdata;
         } catch (XN_Exception $e) {
              echo $e->getMessage();
         }
}


?>

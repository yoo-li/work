<?php
require_once('Smarty_setup.php');
require_once('include/utils/utils.php');
 
global  $currentModule,$supplierid;

if (isset($_REQUEST['physicalstoreid']) && $_REQUEST['physicalstoreid'] != "")
{
	$physicalstoreid = $_REQUEST['physicalstoreid'];
    $supplier_physicalstoreassistants = XN_Query::create ( 'Content' )->tag('supplier_physicalstoreassistants_'.$supplierid)
	    ->filter ( 'type', 'eic', 'supplier_physicalstoreassistants')
	    ->filter ( 'my.supplierid',"=",$supplierid)
		->filter ( 'my.deleted', '=', '0')  
		->filter ( 'my.physicalstoreid', '=', $physicalstoreid)   
	    ->end(-1)
	    ->execute(); 
	$physicalstoreassistants = array();
    foreach ($supplier_physicalstoreassistants as $info)
	{ 
        $physicalstoreassistants[] = $info->my->profileid;  
    }
	$assistants = getGivenNameArrByids($physicalstoreassistants); 
	$assistantoption = array(); 
	foreach ($assistants as $key => $value)
	{  
		$assistantoption[] = '{"value":"'.$key.'","label":"'.$value.'"}';  
	} 
	echo '['.join(",",$assistantoption).']';
}
else
{
	echo '[]';
}
	

?>
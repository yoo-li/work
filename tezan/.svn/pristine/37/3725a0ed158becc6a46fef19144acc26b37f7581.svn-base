<?php 
 

session_start(); 

require_once (dirname(__FILE__) . "/config.inc.php");
global $supplierid;

$sessionid=$_COOKIE['PHPSESSID'];

if(isset($_REQUEST['status']) && $_REQUEST['status'] !='')
{
	$status = $_REQUEST['status'];  
}  

if(isset($_REQUEST['record']) && $_REQUEST['record'] !='')
{
	$productid = $_REQUEST['record'];  
}


try{   
    $mycollections = XN_Query::create ( 'Content' )
        ->tag ( "cms_mycollections_".$sessionid)
        ->filter ( 'type', 'eic', 'cms_mycollections' )
        ->filter ( 'my.deleted', '=', '0' )
        ->filter ( 'my.supplierid', '=', $supplierid )
		->filter ('my.cookie','=',$sessionid)
        ->filter ( 'my.productid', '=', $productid )
        ->end(1)
        ->execute();

    if(count($mycollections) == 0)
	{
		$newcontent = XN_Content::create('cms_mycollections','',false);
		$newcontent->my->deleted = '0';    
		$newcontent->my->supplierid = $supplierid;  
		$newcontent->my->cookie = $sessionid;
		$newcontent->my->productid = $productid; 
		$newcontent->my->status = $status;
		$newcontent->save('cms_mycollections,cms_mycollections_'.$sessionid);
	}
	else
	{
		$mycollection_info = $mycollections[0];
		if ($mycollection_info->my->status != $status)
		{
			$mycollection_info->my->status = $status;
			$mycollection_info->save('cms_mycollections,cms_mycollections_'.$sessionid);
		} 
	} 
}
catch(XN_Exception $e)
{
	$msg = $e->getMessage(); 
} 

 
 
 
?>
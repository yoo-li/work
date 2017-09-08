<?php
$cvid = $_REQUEST["record"];
$module = $_REQUEST["dmodule"];
if(isset($cvid) && $cvid != '')
{
	try {   
		$query = XN_Query::create ( 'Content' ) ->tag('Cvcolumnlists')
				->filter ( 'type', 'eic', 'cvcolumnlists' )
				->filter ( 'my.cvid', '=', $cvid)
				->execute();
		XN_Content::delete ($query, 'Cvcolumnlists' ); 

	  	XN_Content::delete ($cvid, 'Customviews' ); 
	} catch ( XN_Exception $e ) {}
	$_SESSION['lvs'][$module]["viewname"] = '';
	$_SESSION['lvs'][$module]["viewid"] = '';
}

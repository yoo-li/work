<?php

global $currentModule,$supplierid;
require_once('modules/Users/Users.php');
require_once('include/utils/UserInfoUtil.php');
require_once('modules/'.$currentModule.'/config.func.php');



try {
	if(isset($_REQUEST['record']) && $_REQUEST['record'] == '-1' && isset($_REQUEST['mode']) && $_REQUEST['mode'] == 'create')
	{
		$newcontent = XN_Content::create('mall_categorys', '',false);
		$newcontent->my->sequence=$_REQUEST['sequence'];
		$newcontent->my->pid=$_REQUEST['parent'];
		$newcontent->my->categoryicon=$_REQUEST['categoryicon'];
		$newcontent->my->categoryname=$_REQUEST['categoryname'];
		$newcontent->my->supplierid=$supplierid;
		$newcontent->my->deleted = '0';
		$newcontent->save("mall_categorys,mall_categorys_".$supplierid);

	}else{
		$newcontent = XN_Content::load($_REQUEST['record'], 'mall_categorys');
		$newcontent->my->sequence=$_REQUEST['sequence'];
		$newcontent->my->pid=$_REQUEST['parent'];
		$newcontent->my->categoryicon=$_REQUEST['categoryicon'];
		$newcontent->my->categoryname=$_REQUEST['categoryname'];
		$newcontent->my->supplierid=$supplierid;
		$newcontent->save("mall_categorys,mall_categorys_".$supplierid);
	}
	XN_MemCache::delete("supplier_" . $supplierid);
} 
catch (XN_Exception $e) 
{
	echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
	die;
}

echo '{"statusCode":"200","message":null,"tabid":"'.$currentModule.'","closeCurrent":true,"forward":null}';


?>







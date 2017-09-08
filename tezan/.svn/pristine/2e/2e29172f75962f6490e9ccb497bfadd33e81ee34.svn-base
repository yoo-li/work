<?php
if(isset($_REQUEST['parentId']) && $_REQUEST['parentId'] != '' && isset($_REQUEST['childId']) && $_REQUEST['childId'] != '')
{
	global  $supplierid,$supplierusertype;
		$record = $_REQUEST['childId'];
		$parentid = $_REQUEST['parentId'];
		$loadcontent = XN_Content::load($record,'mall_categorys');
		$loadcontent->my->pid = $parentid;
		$loadcontent->save("mall_categorys,mall_categorys_".$supplierid);
		XN_MemCache::delete("supplier_" . $supplierid);
}

?>
<?php
require_once('Smarty_setup.php');
require_once('include/utils/utils.php');



global  $currentModule,$supplierid;



if (isset($_REQUEST['record']) && $_REQUEST['record'] != '')
{
    $record = $_REQUEST['record'];
	$loadcontent = XN_Content::load($record,"ma_deliverycontract");
	$ma_categorys = $loadcontent->my->ma_categorys; 
	$categoryids = explode(';', $ma_categorys);
	 
}
else
{
    die();
}

 
$smarty = new vtigerCRM_Smarty;
global $mod_strings;
global $app_strings;
global $app_list_strings;
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings); 
  
$roleout = ''; 
								




$ma_categorys = XN_Query::create ( 'Content' ) ->tag("ma_categorys")
		->filter ( 'type', 'eic', 'ma_categorys')
        ->filter ( 'my.deleted', '=', '0' )
		->end(-1)
		->execute();

$categorys = array();

foreach($ma_categorys as $ma_category_info)
{
	if (in_array($ma_category_info->id,$categoryids))
	{
		$categoryid = $ma_category_info->id;
		$pid = $ma_category_info->my->pid;
		$categoryname = $ma_category_info->my->categoryname;
		$categorys[] = '<li  data-id="'.$categoryid.'" data-pid="'.$pid.'" data-faicon="gift" ata-nodename="'.$categoryname.'" >'.$categoryname.'</li>';
	}
	 
}
 
 
 
$roleout = '<ul id="poprole-ztree" class="ztree" data-toggle="ztree" data-expand-all="true"  data-radio-type="all"  >'.join("\n",$categorys).'</ul>';
 
 
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);

$smarty->assign("MSG", $roleout);

$smarty->display("PopupTree.tpl");
die();
	 

?>
<?php
require_once('Smarty_setup.php');
require_once('include/utils/utils.php');
 
global  $currentModule,$supplierid;
 
$binds = $_REQUEST['ids']; 
$binds = str_replace(";",",",$binds);
$binds = explode(",",trim($binds,','));
array_unique($binds);
if (count($binds) > 1)
{
	$smarty = new vtigerCRM_Smarty;
	global $mod_strings;
	global $app_strings;
	global $app_list_strings;
	$smarty->assign("APP", $app_strings);
	$smarty->assign("CMOD", $mod_strings); 
    $msg = '<div style="width:100%;text-align:center;"><br><br><font color="red" size="2">您只能选择单条记录进行修改！</font></div>';  
	$smarty->assign("MSG", $msg);  
	$smarty->display("MessageBox.tpl");
	die();
}
else
{
    $record = $_REQUEST['ids'];
    
	$loadcontent =  XN_Content::load($record,"supplier_profile",4); 
	$profileid  = $loadcontent->my->profileid;
 
    $msg =  '<div class="form-group">
                <label class="control-label x120">店铺名称:</label>
				<input type="text" class="form-control required" placeholder="请输入店铺名称" data-rule="required;" id="storename" name="storename"  value="">
            </div> 
			<div class="form-group">
				                <label class="control-label x120">店铺分佣比率:</label>
								<input type="text" class="form-control required" data-rule="required;number;range(0.00~99.99)" placeholder="请输入佣金比率"  id="physicalstorerate" name="physicalstorerate"  value="'.$defaultphysicalstorerate.'">%
                 
			</div> ';
} 

$smarty = new vtigerCRM_Smarty;
global $mod_strings;
global $app_strings;
global $app_list_strings;
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->assign("MSG", $msg);  

$smarty->display("MessageBox.tpl");

?>
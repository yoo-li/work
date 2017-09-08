<?php
require_once('include/utils/utils.php');
require_once('Smarty_setup.php');
global  $currentModule,$supplierid;

if(isset($_REQUEST['type']) && $_REQUEST['type'] == "submit")
{
	if(isset($_REQUEST['vendorname']) && $_REQUEST['vendorname'] != "")
	{
		$record = $_REQUEST['ids'];
		$vendorname = $_REQUEST['vendorname'];
		$contact = $_REQUEST['contact'];
		$telphone = $_REQUEST['telphone'];
		$address = $_REQUEST['address'];
		$image = $_REQUEST['image'];


		$loadcontent = XN_Content::load($record,strtolower($currentModule));
		$loadcontent->my->vendorname = $vendorname;
		$loadcontent->my->contact = $contact;
		$loadcontent->my->telphone = $telphone;
		$loadcontent->my->address = $address;
		$loadcontent->my->image = $image;
		$loadcontent->save(strtolower($currentModule).",".strtolower($currentModule)."_".$supplierid);

	}

	echo '{"statusCode":"200","message":null,"tabid":"'.$currentModule.'","closeCurrent":true,"forward":null}';
	die();
}else{
	$binds = $_REQUEST['ids'];
	$binds = str_replace(";",",",$binds);
	$binds = explode(",",trim($binds,','));
	array_unique($binds);
	array_unique($binds);
	if (count($binds) > 1)
	{
		require_once('Smarty_setup.php');
		require_once('include/utils/utils.php');
		$smarty = new vtigerCRM_Smarty;
		global $mod_strings;
		global $app_strings;
		global $app_list_strings;
		$smarty->assign("APP", $app_strings);
		$smarty->assign("CMOD", $mod_strings);
		$msg = '<div style="width:100%;text-align:center;"><br><br><font color="red" size="2">您只能选择单条记录进行修改供应商操作！</font></div>';
		$smarty->assign("MSG", $msg);
		$smarty->display("MessageBox.tpl");
		die();
	}
	$record = $_REQUEST['ids'];
	$loadcontent =  XN_Content::load($record,strtolower($currentModule)."_".$supplierid);
	$vendorname = $loadcontent->my->vendorname;
	$contact = $loadcontent->my->contact;
	$telphone = $loadcontent->my->telphone;
	$address  = $loadcontent->my->address;
	$image = $loadcontent->my->image;

	if (isset($image) && $image != "")
	{
		$imagelist = '[\''.$image.'\']';
	}
	else
	{
		$imagelist = "[]";
	}

	$msg= '
			<table class="table table-bordered" border="0" cellspacing="0" cellpadding="0">

			<tr class="edit-form-tr">
				<td class="edit-form-tdlabel mandatory">供应商名称:</td>
				<td class="edit-form-tdinfo">
						<input class="input input-large textInput required" type="text" value="' . $vendorname . '" name="vendorname" tabindex="16" style="width:200px" maxlength="100" >
				</td>
			</tr>
			<tr class="edit-form-tr">
				<td class="edit-form-tdlabel mandatory">联系人:</td>
				<td class="edit-form-tdinfo">
						<input class="input input-large textInput required" type="text" value="' . $contact . '" name="contact" tabindex="16" style="width:200px" maxlength="100" >
				</td>
			</tr>
			<tr class="edit-form-tr">
				<td class="edit-form-tdlabel mandatory">联系电话:</td>
				<td class="edit-form-tdinfo">
						<input class="input input-large textInput required" type="text" value="' . $telphone . '" name="telphone" tabindex="16" style="width:200px" maxlength="100" >
				</td>
			</tr>
			<tr class="edit-form-tr">
				<td class="edit-form-tdlabel mandatory">联系地址:</td>
				<td class="edit-form-tdinfo">
						<input class="input input-large textInput required" type="text" value="' . $address . '" name="address" tabindex="16" style="width:200px" maxlength="100" >
				</td>
			</tr>
			</table>
		';
	$smarty = new vtigerCRM_Smarty;
	global $mod_strings;
	global $app_strings;
	global $app_list_strings;
	$smarty->assign("APP", $app_strings);
	$smarty->assign("CMOD", $mod_strings);
	$smarty->assign("MSG", $msg);
	$smarty->assign("OKBUTTON", "修改供应商");
	$smarty->assign("RECORD",$_REQUEST['ids']);
	$smarty->assign("SUBMODULE", "Mall_Products");
	$smarty->assign("SUBACTION", "onshelf");

	$smarty->display("MessageBox.tpl");
}


 

?>

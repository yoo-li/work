<?php



require_once('Smarty_setup.php');
require_once('include/utils/utils.php');

global  $currentModule;

if (isset($_REQUEST['record']) && $_REQUEST['record'] != "" && isset($_REQUEST['type']) && $_REQUEST['type'] == "deleted"  )
{
	XN_Content::delete($_REQUEST['record'],'wxmenus');
	echo '{"statusCode":"200","message":null,"tabid":"edit","closeCurrent":true,"forward":null}';
	die();
}	


if (isset($_REQUEST['record']) && $_REQUEST['record'] != "" && isset($_REQUEST['type']) && $_REQUEST['type'] == "submit"  )
{
	$loadcontent = XN_Content::load($_REQUEST['record'],'wxmenus');	
	$menuitemname = $_REQUEST['menuitemname'];
	$menuitemtype = $_REQUEST['menuitemtype'];
	$menuitemtag_id=$_REQUEST['tag_id'];
	$menuitemkey= $_REQUEST['menuitemkey']; 
	$sequence= $_REQUEST['sequence']; 	
	$loadcontent->my->name = $menuitemname;
	$loadcontent->my->type = $menuitemtype;
	$loadcontent->my->tag_id = $menuitemtag_id;
	$loadcontent->my->key = $menuitemkey;
	$loadcontent->my->sequence = $sequence;
	$loadcontent->save('wxmenus');
	echo '{"statusCode":"200","message":null,"tabid":"edit","closeCurrent":true,"forward":null}';
	die();
}	
elseif (isset($_REQUEST['wxid']) && $_REQUEST['wxid'] != "" && isset($_REQUEST['type']) && $_REQUEST['type'] == "submit"  )
{
	try {
		$wxid = $_REQUEST['wxid'];
		$parentid = $_REQUEST['parentid'];
		$record= $_REQUEST['record'];
		$menuitemname = $_REQUEST['menuitemname'];
		$menuitemtype = $_REQUEST['menuitemtype'];
		$menuitemtag_id=$_REQUEST['tag_id'];
		$menuitemkey= $_REQUEST['menuitemkey']; 
		$sequence= $_REQUEST['sequence']; 
		
		$newcontent = XN_Content::create('wxmenus','',false);					  
		$newcontent->my->parentid = $parentid;
		$newcontent->my->record = $wxid;
		$newcontent->my->name = $menuitemname;
		$newcontent->my->type = $menuitemtype;
		$newcontent->my->tag_id = $menuitemtag_id;
		$newcontent->my->key = $menuitemkey;
		$newcontent->my->sequence = $sequence;
		$newcontent->my->apptype = '';
	    $newcontent->my->deleted = '0';
		$newcontent->save('wxmenus');
		
			
		echo '{"statusCode":"200","message":null,"tabid":"edit","closeCurrent":true,"forward":null}';
	} catch ( XN_Exception $e ) 
	{
		 echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
	}			
	die();
}


$smarty = new vtigerCRM_Smarty;

if (isset($_REQUEST['record']) && $_REQUEST['record'] != "" ) 
{
	$loadcontent = XN_Content::load($_REQUEST['record'],"wxmenus");
	$parentid = $loadcontent->my->parentid;
	if ($parentid == "0" || $parentid == "")
	{
		
		$msg =  '<div class="form-group">
		                <label class="control-label x120">'.getTranslatedString('MenuItem Name').':</label>
						<input type="text" data-rule="required" class="input required" value="'.$loadcontent->my->name.'" id="menuitemname" name="menuitemname" tabindex="1">
		            </div>
				<div class="form-group">
		                <label class="control-label x120">'.getTranslatedString('MenuItem Type').':</label>
						<select data-toggle="selectpicker" id="menuitemtype" name="menuitemtype">
							<option value="view" '.(($loadcontent->my->type=="view")?' selected ':'').'>链接</option>
							<option value="click" '.(($loadcontent->my->type=="click")?' selected ':'').'>关键字</option>
							<option value="scancode_push" '.(($loadcontent->my->type=="scancode_push")?' selected ':'').'>扫一扫</option>
						 </select>
		            </div>
		             <div class="form-group">
		                <label class="control-label x150" style="text-align:right;">'.getTranslatedString('tag_id').':</label>
						<select data-toggle="selectpicker" id="tag_id" name="tag_id">
							<option value="all" '.(($loadcontent->my->tag_id=="all")?' selected ':'').'>全部</option>
							<option value="suppliers" '.(($loadcontent->my->tag_id=="suppliers")?' selected ':'').'>商家</option>
							<option value="vendors" '.(($loadcontent->my->tag_id=="vendors")?' selected ':'').'>供应商</option>
						 </select>
		            </div>
					<div class="form-group">
		                <label class="control-label x120">'.getTranslatedString('Sequence').':</label>
						<input type="text" data-rule="required" class="input number required" value="'.$loadcontent->my->sequence.'" id="sequence" name="sequence" tabindex="1">
		            </div>	
					<div class="form-group">
		                <label class="control-label x120">'.getTranslatedString('MenuItem Key').':</label>
						<input type="text" data-rule="required" style="width:500px;" class="input input-large  required" value="'.$loadcontent->my->key.'" id="menuitemkey" name="menuitemkey" tabindex="1">
		            </div>	 ';
		
	}
	else
	{
		$parentcontent = XN_Content::load($parentid,"wxmenus");
		$msg =  '<div class="form-group">
		                <label class="control-label x120">'.getTranslatedString('MenuItem Parent Name').':</label>
						<input type="text" data-rule="required"  class="input required" disabled value="'.$parentcontent->my->name.'"  tabindex="1">
		            </div>
					<div class="form-group">
		                <label class="control-label x120">'.getTranslatedString('MenuItem Name').':</label>
						<input type="text" data-rule="required" class="input required" value="'.$loadcontent->my->name.'" id="menuitemname" name="menuitemname" tabindex="1">
		            </div>
				<div class="form-group">
		                <label class="control-label x120">'.getTranslatedString('MenuItem Type').':</label>
						<select  id="menuitemtype" name="menuitemtype">
							<option value="view" '.(($loadcontent->my->type=="view")?' selected ':'').'>链接</option>
							<option value="click" '.(($loadcontent->my->type=="click")?' selected ':'').'>关键字</option>
							<option value="scancode_push" '.(($loadcontent->my->type=="scancode_push")?' selected ':'').'>扫一扫</option>
						 </select>
		            </div>
		            <div class="form-group">
		                <label class="control-label x150" style="text-align:right;">'.getTranslatedString('tag_id').':</label>
						<select data-toggle="selectpicker" id="tag_id" name="tag_id">
							<option value="all" '.(($loadcontent->my->tag_id=="all")?' selected ':'').'>全部</option>
							<option value="suppliers" '.(($loadcontent->my->tag_id=="suppliers")?' selected ':'').'>商家</option>
							<option value="vendors" '.(($loadcontent->my->tag_id=="vendors")?' selected ':'').'>供应商</option>
						 </select>
		            </div>
					<div class="form-group">
		                <label class="control-label x120">'.getTranslatedString('Sequence').':</label>
						<input type="text" data-rule="required" class="input number required" value="'.$loadcontent->my->sequence.'" id="sequence" name="sequence" tabindex="1">
		            </div>	
					<div class="form-group">
		                <label class="control-label x120">'.getTranslatedString('MenuItem Key').':</label>
						<input type="text" data-rule="required" style="width:500px;" class="input input-large  required" value="'.$loadcontent->my->key.'" id="menuitemkey" name="menuitemkey" tabindex="1">
		            </div>	 ';
	}
	$smarty->assign("RECORD", $_REQUEST['record']);
}
else
{
	
	if (isset($_REQUEST['parentid']) && $_REQUEST['parentid'] != "" ) 
	{
		$parentid = $_REQUEST['parentid'];
		$parentcontent = XN_Content::load($parentid,"wxmenus");
		$_REQUEST['wxid'] = $parentcontent->my->record;
		$msg =  '<div class="form-group">
		                <label class="control-label x150" style="text-align:right;">'.getTranslatedString('MenuItem Parent Name').':</label>
						<input type="text" data-rule="required" class="input required" disabled value="'.$parentcontent->my->name.'"  tabindex="1">
		            </div>
				<div class="form-group">
		                <label class="control-label x150" style="text-align:right;">'.getTranslatedString('MenuItem Name').':</label>
						<input type="text" data-rule="required" class="input required" value="" id="menuitemname" name="menuitemname" tabindex="1">
		            </div>
				<div class="form-group">
		                <label class="control-label x150" style="text-align:right;">'.getTranslatedString('MenuItem Type').':</label>
						<select data-toggle="selectpicker" id="menuitemtype" name="menuitemtype">
							<option value="view">链接</option>
							<option value="click">关键字</option>
							<option value="scancode_push">扫一扫</option>
						 </select>
		            </div>
		             <div class="form-group">
		                <label class="control-label x150" style="text-align:right;">'.getTranslatedString('tag_id').':</label>
						<select data-toggle="selectpicker" id="tag_id" name="tag_id">
							<option value="all">全部</option>
							<option value="suppliers">商家</option>
							<option value="vendors">供应商</option>
						 </select>
		            </div>
					<div class="form-group">
		                <label class="control-label x150" style="text-align:right;">'.getTranslatedString('Sequence').':</label>
						<input type="text" data-rule="required" class="input number required" value="100" id="sequence" name="sequence" tabindex="1">
		            </div>	
					<div class="form-group">
		                <label class="control-label x150" style="text-align:right;">'.getTranslatedString('MenuItem Key').':</label>
						<input type="text" data-rule="required" style="width:500px;" class="input input-large  required" value="http://" id="menuitemkey" name="menuitemkey" tabindex="1">
		            </div>';
	}
	else
	{
		$parentid = "0";
		$msg =  '<div class="form-group">
		                <label class="control-label x150" style="text-align:right;">'.getTranslatedString('MenuItem Name').':</label>
						<input type="text" data-rule="required" class="input required" value="" id="menuitemname" name="menuitemname" tabindex="1">
		            </div>
				<div class="form-group">
		                <label class="control-label x150" style="text-align:right;">'.getTranslatedString('MenuItem Type').':</label>
						<select data-toggle="selectpicker" id="menuitemtype" name="menuitemtype">
							<option value="view">链接</option>
							<option value="click">关键字</option>
							<option value="scancode_push">扫一扫</option>
						 </select>
		            </div>
		            <div class="form-group">
		                <label class="control-label x150" style="text-align:right;">'.getTranslatedString('tag_id').':</label>
						<select data-toggle="selectpicker" id="tag_id" name="tag_id">
							<option value="all">全部</option>
							<option value="suppliers">商家</option>
							<option value="vendors">供应商</option>
						 </select>
		            </div>
					<div class="form-group">
		                <label class="control-label x150" style="text-align:right;">'.getTranslatedString('Sequence').':</label>
						<input type="text" data-rule="required" class="input number required" value="100" id="sequence" name="sequence" tabindex="1">
		            </div>	
					<div class="form-group">
		                <label class="control-label x150" style="text-align:right;">'.getTranslatedString('MenuItem Key').':</label>
						<input type="text" data-rule="required" style="width:500px;" class="input input-large  required" value="http://" id="menuitemkey" name="menuitemkey" tabindex="1">
		            </div>';
		
	} 
	$msg .= '<input type="hidden" name="parentid" value="'.$parentid.'">';
	$msg .= '<input type="hidden" name="wxid" value="'.$_REQUEST['wxid'].'">';
	
}


$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->assign("MSG", $msg);
$smarty->assign("SUBMODULE", "Supplier_WxSettings");
$smarty->assign("OKBUTTON", "保存");
$smarty->assign("SUBACTION", "WxMenuItem");

$smarty->display("MessageBox.tpl");
 

?>
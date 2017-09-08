<?php
require_once('Smarty_setup.php');
global  $currentModule,$supplierid;


if(isset($_REQUEST['type']) && $_REQUEST['type'] == "submit")
{
	if(isset($_REQUEST['brand']) && $_REQUEST['brand'] != "")
	{
		$binds = $_REQUEST['record'];
		$binds = str_replace(";",",",$binds);
		$binds = explode(",",trim($binds,','));
		array_unique($binds);
		$brand = $_REQUEST['brand'];

		$loadcontents =  XN_Content::loadMany($binds,strtolower($currentModule)."_".$supplierid);
		foreach($loadcontents as $loadcontent_info)
		{
			$loadcontent_info->my->brand = $brand;
			$loadcontent_info->save(strtolower($currentModule).",".strtolower($currentModule)."_".$supplierid);
		}
	}

	echo '{"statusCode":"200","message":null,"tabid":"'.$currentModule.'","closeCurrent":true,"forward":null}';
	die();
}
else{
	$binds = $_REQUEST['ids'];
	$binds = str_replace(";",",",$binds);
	$binds = explode(",",trim($binds,','));
	array_unique($binds);

	if (count($binds) > 1)
	{
		$loadcontents =  XN_Content::loadMany($binds,strtolower($currentModule)."_".$supplierid);
		$loadcontent = $loadcontents[0];
		$brand = $loadcontent->my->brand;
	}
	else
	{
		$loadcontent =  XN_Content::load($binds,strtolower($currentModule)."_".$supplierid);
		$brand = $loadcontent->my->brand;
	}

	$brands = getbrands();
	$brandoption = "";
	foreach ($brands as $key => $value)
	{
		if ($brand == $key)
		{
			$brandoption .= '<option value='.$key.' selected>'.$value.'</option>';
		}
		else
		{
			$brandoption .= '<option value='.$key.'>'.$value.'</option>';
		}

	}

	$msg= '
		<div class="form-group" style="width:98%;margin:3px 0px;float:left;">
			<label class="control-label x150">品牌:</label>
			<select name="brand" style="width:120px;" class="form-control" data-rule="required;">'.$brandoption.'</select>
		</div>
		';

	$smarty = new vtigerCRM_Smarty;
	$smarty->assign("APP", $app_strings);
	$smarty->assign("CMOD", $mod_strings);
	$smarty->assign("MSG", $msg);
	$smarty->assign("OKBUTTON", "确定修改");
	$smarty->assign("RECORD",$_REQUEST['ids']);
	$smarty->assign("SUBMODULE", $currentModule);
	$smarty->assign("SUBACTION", $_REQUEST['action']);

	$smarty->display("MessageBox.tpl");
}



function getbrands()
{
	global $supplierid;
    $brands = array();
    $mall_brands = XN_Query::create ( 'Content' )->tag('mall_brands_'.$supplierid)
	    ->filter ( 'type', 'eic', 'mall_brands')
	    ->filter ( 'my.supplierid',"=",$supplierid)
		->filter ( 'my.deleted', '=', '0')  
		->filter ( 'my.approvalstatus', '=', '2')   
	    ->end(-1)
	    ->execute(); 
    foreach ($mall_brands as $info)
	{ 
        $brands[$info->id] = $info->my->brand_name;  
    }
    return $brands;
}

?>

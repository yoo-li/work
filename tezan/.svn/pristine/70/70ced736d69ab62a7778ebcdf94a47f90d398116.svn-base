<?php
require_once('Smarty_setup.php');
require_once('include/utils/utils.php');
 
global  $currentModule,$supplierid;

if (isset($_REQUEST['record']) && $_REQUEST['record'] != "" &&
    isset($_REQUEST['type']) && $_REQUEST['type'] == "submit" )
{
    try {
        $record = $_REQUEST['record'];
		if (isset($_REQUEST['physicalstore']) && $_REQUEST['physicalstore'] != "" &&
			isset($_REQUEST['physicalstoreassistant']) && $_REQUEST['physicalstoreassistant'] != "")
		{
			$physicalstoreid = $_REQUEST['physicalstore'];
			$physicalstoreassistant = $_REQUEST['physicalstoreassistant'];
			$supplier_profile_info = XN_content::load($record,"supplier_profile",4); 
			$profileid = $supplier_profile_info->my->profileid;
			
			$physicalstore_info = XN_content::load($physicalstoreid,"supplier_physicalstores",4); 
			
			$supplier_physicalstores = XN_Query::create ( 'Content' ) ->tag('supplier_physicalstoreprofiles')
			    ->filter ( 'type', 'eic', 'supplier_physicalstoreprofiles') 
				->filter ( 'my.supplierid', '=',$supplierid)
				->filter ( 'my.profileid', '=',$profileid)
			    ->filter ( 'my.deleted', '=', '0' )
				->end(1)
			    ->execute ();

			if (count($supplier_physicalstores) == 0)
			{
		        $newcontent = XN_Content::create('supplier_physicalstoreprofiles', '', false);
		        $newcontent->my->deleted = '0';
		        $newcontent->my->profileid = $profileid;
		        $newcontent->my->supplierid = $supplierid;
		        $newcontent->my->physicalstoreid = $physicalstoreid;
				$newcontent->my->storeprofileid = $physicalstore_info->my->profileid; 
				$newcontent->my->assistantprofileid = $physicalstoreassistant; 
				$tag = "supplier_physicalstoreprofiles,supplier_physicalstoreprofiles_" . $profileid . ",supplier_physicalstoreprofiles_" . $supplierid;
				$tag .= ",supplier_physicalstoreprofiles_" . $physicalstore_info->my->profileid;
				$tag .= ",supplier_physicalstoreprofiles_" . $physicalstoreassistant; 
		        $newcontent->save($tag);
				
			}
		}
		 
		echo '{"statusCode":"200","message":null,"tabid":"'.$currentModule.'","closeCurrent":true,"forward":null}';
		die(); 
     } 
	catch ( XN_Exception $e )
    {
        echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
    }
    die();
}
else{ 
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

		$supplier_physicalstores = XN_Query::create ( 'Content' ) ->tag('supplier_physicalstoreprofiles')
		    ->filter ( 'type', 'eic', 'supplier_physicalstoreprofiles') 
			->filter ( 'my.supplierid', '=',$supplierid)
			->filter ( 'my.profileid', '=',$profileid)
		    ->filter ( 'my.deleted', '=', '0' )
			->end(1)
		    ->execute ();

		if (count($supplier_physicalstores) > 0)
		{
 			$smarty = new vtigerCRM_Smarty;
			global $mod_strings;
			global $app_strings;
			global $app_list_strings;
			$smarty->assign("APP", $app_strings);
			$smarty->assign("CMOD", $mod_strings);
			$msg = '<div style="width:100%;text-align:center;"><br><br><font color="red" size="2">该会员已经是顾客身份了，不能重复创建顾客身份！</font></div>';
			$smarty->assign("MSG", $msg);
			$smarty->display("MessageBox.tpl");
			die();
		}
		$physicalstores = getphysicalstores();
		$physicalstoreoption = '';
		$default_physicalstoreid = "";
		foreach ($physicalstores as $key => $value)
		{ 
			if ($default_physicalstoreid == "")
			{
				$default_physicalstoreid = $key;
				$physicalstoreoption .= '<option value='.$key.' selected>'.$value.'</option>'; 
			}
			else
			{
				$physicalstoreoption .= '<option value='.$key.'>'.$value.'</option>'; 
			}
				
		} 
	    $supplier_physicalstoreassistants = XN_Query::create ( 'Content' )->tag('supplier_physicalstoreassistants_'.$supplierid)
		    ->filter ( 'type', 'eic', 'supplier_physicalstoreassistants')
		    ->filter ( 'my.supplierid',"=",$supplierid)
			->filter ( 'my.deleted', '=', '0')  
			->filter ( 'my.physicalstoreid', '=', $default_physicalstoreid)   
		    ->end(-1)
		    ->execute(); 
		$physicalstoreassistants = array();
	    foreach ($supplier_physicalstoreassistants as $info)
		{ 
	        $physicalstoreassistants[] = $info->my->profileid;  
	    }
		$assistants = getGivenNameArrByids($physicalstoreassistants); 
		$assistantoption = ''; 
		foreach ($assistants as $key => $value)
		{  
				$assistantoption .= '<option value='.$key.'>'.$value.'</option>';  
		} 
		$msg = '<div class="form-group" style="width:98%;margin:3px 0px;float:left;">
				<label class="control-label x150">实体店:</label>
				<select  data-toggle="selectpicker" data-nextselect="#physicalstoreassistant"
		         data-refurl="relation_data_source_physicalstore" id="physicalstore" name="physicalstore" style="width:150px;" class="form-control">'.$physicalstoreoption.'</select>
			</div>
			';  
		$msg .= '<div class="form-group" style="width:98%;margin:3px 0px;float:left;">
				<label class="control-label x150">实体店店员:</label>
				<select  data-toggle="selectpicker" id="physicalstoreassistant" name="physicalstoreassistant" style="width:150px;" class="form-control">'.$assistantoption.'</select>
			</div>
			';  
	}
}
$script     = '
		function relation_data_source_physicalstore(selectvalue){  
			var html = $.ajax({ url: "index.php?module=Supplier_Profile&action=physicalstoreassistant&physicalstoreid="+selectvalue, async: false }).responseText;
			return eval(html); 
		}
		 
		';
$smarty = new vtigerCRM_Smarty;
global $mod_strings;
global $app_strings;
global $app_list_strings;
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->assign("MSG", $msg);
$smarty->assign("SCRIPT", $script);
$smarty->assign("OKBUTTON", "确定");
$smarty->assign("RECORD",$_REQUEST['ids']);
$smarty->assign("SUBMODULE", "Supplier_Profile");
$smarty->assign("SUBACTION", "SetProfileCustomer");

$smarty->display("MessageBox.tpl");

function getphysicalstores()
{
	global $supplierid;
    $physicalstores = array();
    $supplier_physicalstores = XN_Query::create ( 'Content' )->tag('supplier_physicalstores_'.$supplierid)
	    ->filter ( 'type', 'eic', 'supplier_physicalstores')
	    ->filter ( 'my.supplierid',"=",$supplierid)
		->filter ( 'my.deleted', '=', '0')  
		->filter ( 'my.approvalstatus', '=', '2')   
	    ->end(-1)
	    ->execute(); 
    foreach ($supplier_physicalstores as $info)
	{ 
        $physicalstores[$info->id] = $info->my->storename;  
    }
    return $physicalstores;
}

?>
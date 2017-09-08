<?php
/*+*******************************************************************************
 * The contents of this file are subject to the 361CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  361CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ********************************************************************************/

require_once('include/utils/UserInfoUtil.php');
require_once('Smarty_setup.php');
$smarty = new vtigerCRM_Smarty;

global $mod_strings;
global $app_strings;
global $app_list_strings;


//Retreiving the hierarchy
function getRolesbydata($data,$role)
{
	 $r = array();
	 foreach ($data as $roleid => $parentroleid) 
	 {
	     if ($role == $parentroleid)
		 {
			$r[$roleid] = getRolesbydata($data,$roleid);
		 }
	 }	 
	 return $r;
}

$data = array();
$roles = XN_Query::create('Content')->tag('roles')
	->filter('type','eic','roles')
	->order('my.sequence',XN_Order::ASC_NUMBER)
	->execute();
if (count($roles) > 0) 
{		
	 foreach ($roles as $role) 
	 {
			$roleid = $role->my->roleid;
			$parent = $role->my->parentrole;				
			$temp_list = explode('::',$parent);
			$diff = array_diff($temp_list,array($roleid));
			if (count($diff) > 0)
			{
				$parentroleid = end($diff);					
				$data[$roleid] = $parentroleid;
			}
			
	 }
}	


$role_name = array();
foreach ( $roles as $role ) 
{
	$role_name[$role->my->roleid] = $role->my->rolename; 
}

$roleout = '';
$hrarray = array("H1" => getRolesbydata($data,"H1"));
$roleout .= indent($hrarray,$roleout,$role_name);
$roleout = '<ul class="tree expand">'.$roleout.'</ul>';





function indent($hrarray,$roleout,$role_name)
{
	if(isset($_REQUEST['roleid']) && $_REQUEST['roleid'] !='') 
		$selectroleid =	$_REQUEST['roleid'];
	$selectroleid = explode(";",$selectroleid);

	if(isset($_REQUEST['mode']) && $_REQUEST['mode'] !='') 
		$mode =	$_REQUEST['mode'];

	foreach($hrarray as $roleid => $value)
	{	
		if (count($value) == 0 )
		{
			$label = $role_name[$roleid];
			if ($roleid == 'H1')
			{
				$roleout .= '<li><a href="javascript:" >'.$label.'</a>';
			}
			else if (in_array($roleid,$selectroleid))
			{
				if ($mode == "checkbox")
				{
					$roleout .= '<li><span style="vertical-align:middle;"><input style="vertical-align:middle;" checked type="checkbox" style="cursor: pointer;" name="popup_roleid" value="'.$roleid.'"  rolename="'.$label.'"  id="'.$roleid.'"><label style="float:none" for="'.$roleid.'">【'.$label.'】</label></span></li>';
				}
				else
				{
					$roleout .= '<li><a href="javascript:" onclick="$.bringBack({id:\''.$roleid.'\', Name:\''.$label.'\'})">【'.$label.'】</a></li>';
				}
			}
			else
			{
				if ($mode == "checkbox")
				{
					$roleout .= '<li><span ><input   style="vertical-align:middle;" type="checkbox" style="cursor: pointer;" name="popup_roleid" value="'.$roleid.'"  rolename="'.$label.'" id="'.$roleid.'"><label style="float:none" for="'.$roleid.'">'.$label.'</label></span></li>';
				}
				else
				{
					$roleout .= '<li><a href="javascript:" onclick="$.bringBack({id:\''.$roleid.'\', Name:\''.$label.'\'})">'.$label.'</a></li>';
				}
			}
		}
		else if (count($value) > 0 )
		{
			$label = $role_name[$roleid];
			if ($roleid == 'H1')
			{
				$roleout .= '<li><a href="javascript:" >'.$label.'</a>';
			}
			else if (in_array($roleid,$selectroleid))
			{
				if ($mode == "checkbox")
				{
					$roleout .= '<li><span><input style="vertical-align:middle;" type="checkbox" checked style="cursor: pointer;" name="popup_roleid" value="'.$roleid.'"  rolename="'.$label.'" id="'.$roleid.'"><label style="float:none" for="'.$roleid.'">【'.$label.'】</label></span>';
				}
				else
				{
					$roleout .= '<li><a href="javascript:" onclick="$.bringBack({id:\''.$roleid.'\', Name:\''.$label.'\'})">【'.$label.'】</a>';
				}
			}
			else
			{
				if ($mode == "checkbox")
				{
					$roleout .= '<li><span><input style="vertical-align:middle;" type="checkbox" style="cursor: pointer;" name="popup_roleid" value="'.$roleid.'" rolename="'.$label.'" id="'.$roleid.'"><label style="float:none" for="'.$roleid.'">'.$label.'</label></span>';
				}
				else
				{
					$roleout .= '<li><a href="javascript:" onclick="$.bringBack({id:\''.$roleid.'\', Name:\''.$label.'\'})">'.$label.'</a>';
				}
			}

			$roleout .= '<ul>';
			$roleout = indent($value,$roleout,$role_name);			
			$roleout .=  '</ul>';	
			$roleout .= '</li>';
		}		
	}
	return $roleout;
}

$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);

$roleout .= '		
		<script type="text/javascript">	
		function return_rolepopup_select(){
				var checkboxs = document.getElementsByName("popup_roleid");
				var selected = new Array();
				var selname = new Array();
				for(var i=0;i<checkboxs.length;i++) {
					if(checkboxs[i].checked) {
						profileid = checkboxs[i].value;
						selected.push(profileid);
						profilename = checkboxs[i].attributes["rolename"].value;
						selname.push(profilename);
					}
				}
				if(selected.length<=0) {
					alertmsg("error","请至少选择一个部门");
					return false;
				}
				var args = {id:"",Name:""};
				args.id = selected.join(";");
				args.Name = selname.join(";");				
				$.bringBack(args);			
				return true;
			}
		
		
		</script>
	';

$smarty->assign("MSG", $roleout);
if(isset($_REQUEST['mode']) && $_REQUEST['mode'] !='') 
{
	$smarty->assign("OKBUTTON", "确定");
	$smarty->assign("ONCLICK", "if (!return_rolepopup_select()) return;");
}

$smarty->display("MessageBox.tpl");
?>
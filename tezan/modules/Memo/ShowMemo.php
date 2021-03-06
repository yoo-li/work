<?php
/*+**********************************************************************************
 * The contents of this file are subject to the 361CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  361CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

global $mod_strings,$app_strings,$theme,$currentModule,$current_user;

require_once('Smarty_setup.php');
require_once('include/utils/utils.php');


if(isset($_REQUEST['readonly']) && $_REQUEST['readonly'] !='') 
{
		$readonly = $_REQUEST['readonly'];
}
if(isset($_REQUEST['submodule']) && $_REQUEST['submodule'] !='') 
{
		$submodule = $_REQUEST['submodule'];
}

$panel =  strtolower(basename(__FILE__,".php"));	

if(isset($_REQUEST['record']) && $_REQUEST['record'] !='') 
{
	    $recordid = $_REQUEST['record'];
	  	if(isset($_REQUEST['save']) && $_REQUEST['save'] =='true') 
		{
			if(isset($_REQUEST['memo']) && $_REQUEST['memo'] != '')
			{			
			        $newcontent = XN_Content::create('memo','',false);					  
					$newcontent->my->deleted = '0';
					$newcontent->my->memo =  $_REQUEST['memo'];	
					$newcontent->my->record =  $_REQUEST['record'];	
					$newcontent->my->module =  $submodule;	
					$newcontent->save('memo');

					echo '{"statusCode":200,"divid":"memo_form_div","closeCurrent":"true"}';
 					die();
					
			}
		}
		$html = '<table id="'.$panel.'_details_table" class="table table-bordered table-hover table-striped" width="100%" >
		<tbody>
		<tr>
		<th align="center" width="6%">'.getTranslatedString('Author').'</th>
		<th align="center" width="14%">'.getTranslatedString('Published').'</th>
		<th align="center" style="75%">'.getTranslatedString('Content').'</th>
		<th align="center" style="5%">&nbsp;</th>
		</tr>';
		
	    $module_entity_file = $_SERVER['DOCUMENT_ROOT'].'/modules/'.$submodule.'/'.$submodule.'.php'; 
	    if(file_exists($module_entity_file))
		{ 
		    require_once($module_entity_file);
		    $module_focus = CRMEntity::getInstance($submodule); 
			if (isset($module_focus->datatype) && $module_focus->datatype != "")
			{
				$loadconent = XN_Content::load($recordid,strtolower($submodule),$module_focus->datatype); 
			}
			else
			{
				$loadconent = XN_Content::load($recordid,strtolower($submodule));
			}  
		}
		else
		{
			$loadconent = XN_Content::load($recordid,strtolower($submodule));
		}
 

		$statuskey =  strtolower($submodule).'status';
		$status =  $loadconent->my->$statuskey;
		$personman = $loadconent->my->personman;
		$author = $loadconent->author;
		$assigned_storage_manage_user_id = $loadconent->my->assigned_storage_manage_user_id;
		$business_manager = $loadconent->my->business_manager;
		$business_approval = $loadconent->my->business_approval;
		
		$enabled_memo = false;

		if ($status != "Archive" && $status != "Terminate")
		{
				global $global_session; 
				$rolesdata = $global_session['rolesdata']; 
				$userlist = $rolesdata[XN_Profile::$VIEWER];	
				
				$approvals =   XN_Query::create ( 'Content' )->tag("Approvals")
					->filter ( 'type', 'eic', 'Approvals' )
					->filter ( 'my.record', '=', $recordid )
					->execute ();

				$approval_ids = array();

				foreach($approvals as $approval_info)
				{
					$approval_ids[] = $approval_info->my->from_userid;
					$approval_ids[] = $approval_info->my->userid;
					$approval_ids[] = $approval_info->my->proxyapproval;
				}
				if ($loadconent->author == XN_Profile::$VIEWER)
				{
					$enabled_memo = true;
				}
				else if ($personman == XN_Profile::$VIEWER)
				{
					$enabled_memo = true;
				}
				else if ($assigned_storage_manage_user_id == XN_Profile::$VIEWER)
				{
					$enabled_memo = true;
				}
				else if ($business_manager == XN_Profile::$VIEWER)
				{
					$enabled_memo = true;
				}
				else if ($business_approval == XN_Profile::$VIEWER)
				{
					$enabled_memo = true;
				}
				else if (is_array($personman) && in_array(XN_Profile::$VIEWER,$personman))
				{
					$enabled_memo = true;
				}
				else if (is_array($userlist) && in_array($author,$userlist))
				{
					$enabled_memo = true;
				}
				else if (in_array(XN_Profile::$VIEWER,$approval_ids))
				{
					$enabled_memo = true;
				}
				else
				{
					global $current_user;
					if (check_authorize('cashier') || check_authorize('tezanadmin') || is_admin($current_user))
					{
						 $enabled_memo = true;
					} 
					if(isset($_SESSION['supplierid']) && $_SESSION['supplierid'] != '')
					{
						$enabled_memo = true;
					}
					if(isset($_SESSION['businesseid']) && $_SESSION['businesseid'] != '')
					{
						$enabled_memo = true;
					}
				}
		}



		$memos =   XN_Query::create ( 'Content' )->tag("memo")
			->filter ( 'type', 'eic', 'memo' )
			->filter ( 'my.deleted', '=', '0' )
			->filter ( 'my.record', '=', $recordid )
			->order('published',XN_Order::DESC)
			->execute ();
		if (count ( $memos ) > 0) 
		{
			$user_ids = array();

			foreach($memos as $memo_info)
			{
				$user_ids[] = $memo_info->contributorName;
			}

			$users =   XN_Query::create ( 'Content' )->tag("user")
				->filter ( 'type', 'eic', 'users' )
				->filter ( 'my.profileid', 'in', $user_ids )
				->execute ();

			$userlist = array();

			foreach($users as $user_info)
			{
				$userlist[$user_info->my->profileid] = $user_info->my->last_name;
			}
			$auto_increment = 1;
			foreach($memos as $memo_info)
			{
				$profileid = $memo_info->contributorName;
				$author = $userlist[$profileid];

				$time = strtotime($memo_info->createdDate);
				$published = date('Y-m-d H:i', $time);
				$html .= '<tr id="'.$panel.'_row_'.$auto_increment.'"><td style="text-align: center;" align="center" width="6%">'.$author.'</td><td align="center" style="text-align: center;" width="14%">'.$published.'</td><td align="left" width="75%">'.$memo_info->my->memo.'</td>';
				$value =  strtotime(date('Y-m-d H:i:s')) - strtotime($memo_info->published);
				if ($value > 3600)
				{
					$html .= '<td align="center" style="text-align: center;"><i class="fa btn-default fa-trash" style="cursor: pointer;font-size:1.3em;color:#bbb" title="已经超过1小时"></i></td>';
				}
				else
				{
					 if (XN_Profile::$VIEWER  == $memo_info->contributorName)
					{
						$html .= '<td align="center" style="text-align: center;"><i class="fa btn-default fa-trash" style="cursor: pointer;font-size:1.3em;" onclick="'.$panel.'_delete_row(\''.$auto_increment.'\',\''.$memo_info->id.'\')" title="1小时内可以删除【'.round($value/60).'分钟】"></i></td>';
					}
					else
					{
						$html .= '<td align="center" style="text-align: center;"><i class="fa btn-default fa-trash" style="cursor: pointer;font-size:1.3em;color:#eee"></i></td>';
					}
				}
				$html .= '</tr>';
				$auto_increment ++;	
			}
		}
		if ($enabled_memo)
		{			
			$html .= '<tr><td width="6%">&nbsp;</td><td width="14%">&nbsp;</td><td width="75%">&nbsp;</td>';
			$html .= '<td align="center" width="5%" style="text-align: center;" ><a  href="index.php?module=Memo&action=AddMemo&record='.$recordid.'&readonly='.$readonly.'&fieldname='.$fieldname.'&submodule='.$submodule.'"  data-toggle="dialog" data-id="changepwd_page" data-mask="true" data-maxable="false" data-resizable="false" data-width="700" data-height="310" data-title="增加备注"><i class="fa btn-default fa-plus-circle" style="cursor: pointer;font-size:1.3em;"></i></td></tr>';
		}
		$html .= '</tbody></table>';
		
}

$script = '

function '.$panel.'_delete_row(cid,id){	
	var tableName = document.getElementById("'.$panel.'_details_table");
	var tbody=tableName.getElementsByTagName("tbody");
	var row = document.getElementById("'.$panel.'_row_"+cid);
	if(tbody!=null)
		tbody[0].removeChild(row);
	else
		tableName.removeChild(row);   

    var url = "module=Memo&action=DeleteMemo&record="+id;
	jQuery.post("index.php", url,
	function (data, textStatus)
	{				

	});	
}
';


echo '<script type="text/javascript" defer="defer">'.$script.'</script>
<div>'.$html.'</div>';

?>
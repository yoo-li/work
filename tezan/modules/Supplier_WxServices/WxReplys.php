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
	   
		$html = '<table id="'.$panel.'_details_table" class="table table-bordered table-hover table-striped" width="100%" >
		<tbody>
		<tr>
		<th align="center" width="10%">'.getTranslatedString('Custom Service').'</th>
		<th align="center" width="20%">'.getTranslatedString('ReplyTime').'</th>
		<th align="center" width="65%">'.getTranslatedString('Reply Content').'</th>
		<th align="center" style="width:50px;">&nbsp;</th>
		</tr>';

		 



		$wxreplays =   XN_Query::create ( 'Content' )->tag("supplier_wxreplys")
			->filter ( 'type', 'eic', 'supplier_wxreplys' ) 
			->filter ( 'my.record', '=', $recordid )
			->order('published',XN_Order::DESC)
			->execute ();
		if (count ( $wxreplays ) > 0) 
		{ 
			$auto_increment = 1;
			$user_ids = array();
			foreach($wxreplays as $wxreplay_info)
			{
				$user_ids[] = $wxreplay_info->my->customservice;
			}
			$userlist = getOwnerProfileNameList($user_ids);
			foreach($wxreplays as $wxreplay_info)
			{
			    $profileid = $wxreplay_info->my->customservice;
				$author = $userlist[$profileid];
				$time = strtotime($wxreplay_info->published);
				$published = date('Y-m-d H:i', $time);
				$html .= '<tr id="'.$panel.'_row_'.$auto_increment.'">
					<td style="text-align: center;" align="center" width="10%">'.$author.'</td>
					<td align="center" style="text-align: center;" width="20%">'.$published.'</td>
				<td align="left" width="65%">'.$wxreplay_info->my->reply.'</td>';
				$html .= '<td align="center" style="text-align: center;width:50px;"><i class="fa btn-default fa-trash" style="cursor: pointer;font-size:1.3em;color:#bbb" title="不能删除" data-toggle="poshytip"></i></td>';
				$html .= '</tr>';
				$auto_increment ++;	
			}
		}
				
		$html .= '<tr><td width="10%">&nbsp;</td><td width="20%">&nbsp;</td><td width="65%">&nbsp;</td>';
		$html .= '<td align="center" style="text-align: center;width:50px;"><a  href="index.php?module=Supplier_WxServices&action=AddWxReplys&record='.$recordid.'"  data-toggle="dialog" data-id="changepwd_page" data-mask="true" data-maxable="false" data-resizable="false" data-width="700" data-height="380" data-title="回复"><i class="fa btn-default fa-plus-circle" style="cursor: pointer;font-size:1.3em;"></i></a></td></tr>';
		 $html .= '</tbody></table>';
		
}

$script = '';


echo '<script type="text/javascript" defer="defer">'.$script.'</script>
<div id="memo_form_div">'.$html.'</div>';

?>
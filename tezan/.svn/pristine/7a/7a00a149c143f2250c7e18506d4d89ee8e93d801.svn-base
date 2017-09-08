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

  

$panel =  strtolower(basename(__FILE__,".php"));	

if(isset($_REQUEST['record']) && $_REQUEST['record'] !='') 
{
	    $recordid = $_REQUEST['record'];
	   
		$html = '<table id="'.$panel.'_details_table" class="table table-bordered table-hover table-striped" width="100%" >
		<tbody>
		<tr> 
		<th align="center" style="80%">'.getTranslatedString('Route').'</th> 
		<th align="center" width="20%">'.getTranslatedString('Published').'</th>
		</tr>';
 

		$mall_logisticroutes =   XN_Query::create ( 'YearContent' )->tag("mall_logisticroutes_".$supplierid)
			->filter ( 'type', 'eic', 'mall_logisticroutes' ) 
			->filter ( 'my.logisticbillid', '=', $recordid )
			->filter ( 'my.deleted', '=', '0' )
			->order('published',XN_Order::DESC)
			->execute (); 
		if (count ( $mall_logisticroutes ) > 0) 
		{  
			foreach($mall_logisticroutes as $logisticroute_info)
			{ 
				$html .= '<tr">
					<td style="text-align: center;" align="center" width="80%">'.$logisticroute_info->my->route.'</td>
					<td align="center" style="text-align: center;" width="20%">'.$logisticroute_info->published.'</td>
				    </tr>'; 
			}
		}
				
		$html .= '</tbody></table>';
		
}

$script = ''; 
echo '<script type="text/javascript" defer="defer">'.$script.'</script>
<div id="memo_form_div">'.$html.'</div>';

?>
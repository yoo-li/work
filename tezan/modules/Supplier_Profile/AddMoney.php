<?php
global $currentModule,$current_user;
 
 
if(isset($_REQUEST["record"]) && $_REQUEST["record"] != "" && 
   isset($_REQUEST["addmoney"]) && $_REQUEST["addmoney"] != "" && 
	$_REQUEST["type"] == "submit")
{
	 $id_lists = explode(",", $_REQUEST['record']); 
	 $addmoney = $_REQUEST['addmoney'];
     $isaddacc=$_REQUEST['isaddacc'];
	 require_once (dirname(__FILE__) . "/util.php"); 
	 
	 $supplier_profiles = XN_Content::load($id_lists,"supplier_profile",4);
	 foreach($supplier_profiles as $profile_info)
	 {
		 
		$rank = intval($profile_info->my->rank); 
		$profileid = $profile_info->my->profileid; 
		$wxopenid= $profile_info->my->wxopenid; 
		$supplierid = $profile_info->my->supplierid; 
		
		$profile_info = get_supplier_profile_info($profileid,$supplierid);
		$money = $profile_info['money'];  
		$accumulatedmoney = $profile_info['accumulatedmoney']; 
		
		if(floatval($addmoney) <= 0 && abs(floatval($addmoney))>floatval($money)){
			echo '{"status":300,"statusCode":300,"message":"当前余额不够扣除！"}';
			die();
		} 
		
		$profile_info = get_supplier_profile_info($profileid,$supplierid);
		$money = $profile_info['money'];   
		
		$newmoney = floatval($money)+floatval($addmoney);
		
        if($isaddacc=='on'){
             $newaccumulatedmoney = floatval($accumulatedmoney)+floatval($addmoney);
        } 
		else
		{
			$newaccumulatedmoney = $accumulatedmoney;
		} 
		$profile_info['money'] = $newmoney;  
		$profile_info['accumulatedmoney'] = $newaccumulatedmoney;  
		if (floatval($addmoney) < 0)
		{
			$maxtakecash = $profile_info['maxtakecash'];
			$new_maxtakecash = floatval($maxtakecash) + floatval($addmoney);
			if ($new_maxtakecash < 0)
			{
				$new_maxtakecash = 0;
			}
			$profile_info['maxtakecash'] = $new_maxtakecash;
		}
		update_supplier_profile_info($profile_info); 
		 
		$newcontent = XN_Content::create('mall_billwaters','',false,8);					  
		$newcontent->my->deleted = '0';  
		$newcontent->my->profileid = $profileid; 
		$newcontent->my->supplierid = $supplierid;  
		$newcontent->my->oper = XN_Profile::$VIEWER;
		if (floatval($addmoney) > 0)
		{
			$newcontent->my->billwatertype = 'addprofile';
		}
		else
		{
			$newcontent->my->billwatertype = 'decprofile';
			
		}
	    
		$newcontent->my->money = number_format($newmoney,2,".","");
		$newcontent->my->amount = number_format($addmoney,2,".","");
		$newcontent->my->submitdatetime = date('Y-m-d H:i:s');
		$newcontent->save('mall_billwaters,mall_billwaters_'.$profileid.',mall_billwaters_'.$supplierid); 
		
		global  $supplierid; 
		$supplier_wxsettings = XN_Query::create ( 'MainContent' ) ->tag('supplier_wxsettings')
		    ->filter ( 'type', 'eic', 'supplier_wxsettings')
		    ->filter ( 'my.deleted', '=', '0' )
		    ->filter ( 'my.supplierid', '=' ,$supplierid)
			->end(1)
		    ->execute(); 
		if (count($supplier_wxsettings) > 0)
		{
		    $supplier_wxsetting_info = $supplier_wxsettings[0];
			$appid = $supplier_wxsetting_info->my->appid;
			if ($addmoney > 0)
			{
				require_once (XN_INCLUDE_PREFIX."/XN/Message.php");
	            XN_Message::sendmessage($profileid,'您的账号余额增加了'.$addmoney.'元.',$appid);  
			}
			else
			{ 
				require_once (XN_INCLUDE_PREFIX."/XN/Message.php");
	            XN_Message::sendmessage($profileid,'您的账号余额扣除了'.$addmoney.'元.',$appid);  
			}  
		} 


		
	 }
		
	 echo '{"statusCode":"200","message":null,"tabid":"'.$currentModule.'","closeCurrent":true,"forward":null}';

     die();
}
if(isset($_REQUEST["ids"]) && $_REQUEST["ids"] != "")
{
	//        'cvcolumnlist' => array ('supplierid','profileid','givenname','gender','province','city','mobile','rank','accumulatedmoney','money','sharefund','published'),

		$ids = $_REQUEST["ids"];
		$id_lists = explode(",", $_REQUEST['ids']);	
		$fields = array(
			'givenname' =>	array('label'=>'LBL_GIVENNAME','width'=>'10%',	'talign'=>'center',	'calign'=>'center'),
			'mobile' =>	array('label'=>'LBL_MOBILE','width'=>'10%',	'talign'=>'center',	'calign'=>'center'), 			
			'province' =>	array('label'=>'LBL_PROVINCE',	'width'=>'10%',	'talign'=>'center',	'calign'=>'center'),
			'city' => array('label'=>'LBL_CITY','width'=>'10%','talign'=>'left','calign'=>'center'),  
			'rank' => array('label'=>'LBL_RANK','width'=>'5%','talign'=>'left','calign'=>'center'),
			'money' => array('label'=>'LBL_MONEY','width'=>'5%','talign'=>'left','calign'=>'center'),
			'accumulatedmoney' => array('label'=>'LBL_ACCUMULATEDMONEY','width'=>'5%','talign'=>'left','calign'=>'center'), 
			'published' => array('label'=>'LBL_PUBLISHED','width'=>'25%','talign'=>'center','calign'=>'center'),

		);
		 
		$supplier_profiles = XN_Content::load($id_lists,"supplier_profile",4);
		  
		    
		$tableRows = '';
		foreach($supplier_profiles as $supplier_profile_info)
		{
			$tableRows .= '<tr>';
			foreach($fields as $fed => $fvd)
			{ 
				if ($fed == "published")
				{
					$tmpValue = $supplier_profile_info->published;
				}
				else
				{
					$tmpValue = $supplier_profile_info->my->$fed;
				}
				$tableRows .= '<td '.(($fvd['calign']!="")?'align="'.$fvd['calign'].'"':"").'>'.$tmpValue.'</td>';
				 
			}
			$tableRows .= '</tr>'; 
		}
	
	
		$tableTitle = '';	
		foreach($fields as $fed => $fvd)
		{
				$tableTitle .= '<th '.(($fvd['talign']!="")?'align="'.$fvd['talign'].'"':"").' style="width:'.$fvd['width'].';white-space:nowrap;"><b>'.getTranslatedString($fvd['label']).'</b></th>';
		}	 		
 
		$html = '
			<ul class="searchContent">
				<li>
				<label class="control-label x120">金额：</label>
				<input type="text"  name="addmoney" id="addmoney" value="" data-rule="required;number;money;"  class="form-control  required">元
				<input type="checkbox" name="isaddacc" checked="checked">增加累积金额
			</li>
			</ul>
			<table class="table table-bordered table-hover table-striped" border="0" cellspacing="0" cellpadding="0">
					<tr id="cid_products" class="edit-form-tr">
						<td class="edit-form-tdinfo">
							<table id="acTab" class="table table-bordered table-hover table-striped" style="width:100%" name="acTab">
							<tbody>
								<tr id="listtitle">'.$tableTitle.'</tr>'.($tableRows!=""?$tableRows:'').'
							</tbody>
							</table>
						</td>
					</tr>
				</table>

		'; 
		
}
//echo $html;

require_once('Smarty_setup.php');
require_once('include/utils/utils.php');

global  $currentModule;
$smarty = new vtigerCRM_Smarty;
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->assign("MSG", $html);
$smarty->assign("MSGTITLE", '<h2><font color="red" size="2">请确定以下会员充值吗？【注意，当输入负数时，是扣除余额的反冲操作】</font></h2>');

$smarty->assign("RECORD", $ids);
$smarty->assign("SUBMODULE", "Supplier_Profile");
$smarty->assign("OKBUTTON", "确定会员充值");
$smarty->assign("SUBACTION", "AddMoney");

$smarty->display("MessageBox.tpl");



?>
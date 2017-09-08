<?php
global $currentModule,$current_user;
 
 
if(isset($_REQUEST["ids"]) && $_REQUEST["ids"] != "" )
{
	 $id_lists = explode(",", $_REQUEST['ids']); 
	 
	 $list_result = XN_Content::loadMany($id_lists,'takecashs');
	 foreach($list_result as $info)
	 {
	 	if ($info->my->takecashsstatus != '处理完成' && $info->my->takecashsstatus != '驳回申请')
	 	{ 
	 			$info->my->takecashsstatus = '现金提现';
	            $info->my->executedatetime = date("Y-m-d H:i"); 
	            $info->my->execute = XN_Profile::$VIEWER;
	            $info->save('takecashs');
	            $amount = $info->my->amount;
	            $money = $info->my->newmoney;
	            $profileid= $info->my->profileid; 
	            
				$newcontent = XN_Content::create('billwaters','',false);					  
				$newcontent->my->deleted = '0'; 
				$newcontent->my->profileid = $profileid; 
				$newcontent->my->billwatertype = 'cash';
				$newcontent->my->sharedate = '-'; 
				$newcontent->my->submitdatetime = date("Y-m-d H:i"); 
				$newcontent->my->orderid = '';
				$newcontent->my->productid = '';
				$newcontent->my->takecashid = $info->id;
				$newcontent->my->royaltyrate = '';
				$newcontent->my->commissiontype = '';
				$newcontent->my->amount = $amount; 
				$newcontent->my->money = $money; 
				$newcontent->save('billwaters,billwaters_'.$profileid);
		}
	}
				
	//echo '{"statusCode":"300","message":"2"}';	
	 echo '{"statusCode":"200","message":null,"tabid":"'.$currentModule.'","callbackType":null,"forward":null}';

     die();
}
else
{
	echo '{"statusCode":"300","message":"参数错误！"}';
	die;
}

?>

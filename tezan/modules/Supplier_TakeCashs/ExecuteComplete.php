<?php
global $currentModule,$current_user;
global $supplierid;
 
if(isset($_REQUEST["ids"]) && $_REQUEST["ids"] != "" )
{
	 $id_lists = explode(",", $_REQUEST['ids']); 
	 
	 $list_result = XN_Content::loadMany($id_lists,'supplier_takecashs_'.$supplierid,7);
	 foreach($list_result as $info)
	 {
	 	if ($info->my->supplier_takecashsstatus != '处理中')
	 	{ 
			echo '{"statusCode":"300","message":"选择中包含了非“处理中”的申请！"}';
	 		die();	 
		}
	}
	 foreach($list_result as $info)
	 {
	 	if ($info->my->supplier_takecashsstatus == '处理中')
	 	{  
	            $info->my->executedatetime = date("Y-m-d H:i"); 
	            $info->my->execute = XN_Profile::$VIEWER;
				$info->my->supplier_takecashsstatus = '提现完成';
				$info->my->tradestatus = 'trade';
				$profileid = $info->my->profileid;
	            $info->save('supplier_takecashs,supplier_takecashs_'.$supplierid.',supplier_takecashs_'.$profileid);  
		
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
					require_once (XN_INCLUDE_PREFIX."/XN/Message.php");  
					$message = '恭喜您,您提交的提现已经处理完成！';
					XN_Message::sendmessage($profileid,$message,$appid);  
				} 
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

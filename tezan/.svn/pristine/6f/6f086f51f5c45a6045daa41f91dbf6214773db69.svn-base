<?php
	require_once('modules/Users/Users.php');
	require_once('include/utils/UserInfoUtil.php');

	global $currentModule;
	global $supplierid;

	if ($supplierid == "" || $supplierid == "0"){
		echo '{"statusCode":"300","message":"商家信息获取失败,请重新登后再试!"}';
		die;
	}
	try
	{
		if (isset($_REQUEST['ids']) && $_REQUEST['ids'] != '' && isset($_REQUEST['pid']) && $_REQUEST['pid'] != '' && isset($_REQUEST['pname']) && $_REQUEST['pname'] != '')
		{
			$id_lists = explode(",", $_REQUEST['ids']);
			$pid_lists = explode(";", $_REQUEST['pid']);
			$query = XN_Query::create('Content')->tag(strtolower($currentModule)."_".$supplierid)->end(-1)
				->filter('type', 'eic', strtolower($currentModule))
				->filter('my.supplierid', '=', $supplierid)
				->filter('my.authorize', 'in', $id_lists)
				->execute();
			$SaveContent = array();
			foreach($query as $item){
				$item->my->userid = $pid_lists;
				$item->my->userlist = $_REQUEST['pname'];
				$SaveContent[] = $item;
				foreach($id_lists as $key => $authorize){
					if($authorize == $item->my->authorize){
						unset($id_lists[$key]);
						break;
					}
				}
			}
			if(count($SaveContent) > 0){
				XN_Content::batchsave($SaveContent,strtolower($currentModule).",".strtolower($currentModule)."_".$supplierid);
			}
			if(count($id_lists) > 0){
				$SaveContent = array();
				foreach($id_lists as $key => $authorize){
					$newcontent = XN_Content::create(strtolower($currentModule), '', false);
					$newcontent->my->authorize = $authorize;
					$newcontent->my->userid = $pid_lists;
					$newcontent->my->userlist = $_REQUEST['pname'];
					$newcontent->my->supplierid = $supplierid;
					$SaveContent[] = $newcontent;
				}
				if(count($SaveContent) > 0){
					XN_Content::batchsave($SaveContent,strtolower($currentModule).",".strtolower($currentModule)."_".$supplierid);
				}
			} 
			
			$supplier_users = XN_Query::create ( 'Content' ) ->tag('supplier_users')
			    ->filter ( 'type', 'eic', 'supplier_users')
			    ->filter ( 'my.deleted', '=', '0' ) 
				->end(-1)
			    ->execute(); 
			if (count($supplier_users) > 0)
			{
				foreach($supplier_users as $supplier_user_info)
				{
					$profileid = $supplier_user_info->my->profileid;
					$sessionkey = "user_privileges_".XN_Application::$CURRENT_URL."_".$profileid; 
					XN_MemCache::delete($sessionkey); 
				}  
			}   
			 
		}else{
			echo '{"statusCode":"300","message":"授权信息有误,无法完成授权!"}';
			die;
		}
	}
	catch (XN_Exception $e)
	{
		echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
		die;
	}

	echo '{"statusCode":200,"tabid":"'.$currentModule.'"}';

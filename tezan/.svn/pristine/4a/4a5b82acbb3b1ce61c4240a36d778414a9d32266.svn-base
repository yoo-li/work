<?php
	require_once('modules/Users/Users.php');
	require_once('include/utils/UserInfoUtil.php');

	global $currentModule, $current_user;

	try
	{
		global  $supplierid,$supplierusertype; 
		 
		if(isset($supplierid) && !empty($supplierid))
		{ 
			if (isset($_REQUEST['record']) && $_REQUEST['record'] == '-1')
			{
				$newcontent                      = XN_Content::create('supplier_departments', '', false);
				$newcontent->my->sequence        = $_REQUEST['sequence'];
				$newcontent->my->pid             = $_REQUEST['parent'];
				$newcontent->my->departmentsname = $_REQUEST['departmentsname'];
				$newcontent->my->supplierid      = $supplierid;
				$newcontent->my->leadership      = $_REQUEST["leadership_id"];
				$newcontent->my->mainleadership  = $_REQUEST["mainleadership_id"];
				$newcontent->my->deleted         = '0';
				$newcontent->save("supplier_departments,supplier_departments_".$supplierid);
				//updateStaffsDepartments($supplierid,$newcontent->id,$_REQUEST["mainleadership_id"]);
				echo '{"statusCode":200,"divid":"DepartmentsManagerTreeForm","closeCurrent":true}';
				die();
			}
			elseif (isset($_REQUEST['record']) && $_REQUEST['record'] != '-1' && $_REQUEST['record'] != '')
			{
				$newcontent                      = XN_Content::load($_REQUEST['record'], 'supplier_departments_'.$supplierid);
				$newcontent->my->sequence        = $_REQUEST['sequence'];
				$newcontent->my->pid             = $_REQUEST['parent'];
				$newcontent->my->departmentsname = $_REQUEST['departmentsname'];
				$newcontent->my->supplierid      = $supplierid;
				$newcontent->my->leadership      = $_REQUEST["leadership_id"];
				$newcontent->my->mainleadership  = $_REQUEST["mainleadership_id"];
				$newcontent->save("supplier_departments,supplier_departments_".$supplierid);
				//updateStaffsDepartments($supplierid,$newcontent->id,$_REQUEST["mainleadership_id"]);
				echo '{"statusCode":200,"divid":"DepartmentsManagerTreeForm","closeCurrent":true}';
				die();
			}
			else
			{
				echo '{"statusCode":"300","message":"参数错误，无法完成操作！"}';
				die();
			}
		}
	}
	catch (XN_Exception $e)
	{
		echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
		die;
	}


function updateStaffsDepartments($supplierid,$depid,$mainleadership) {
	$profileids = explode(";",$mainleadership);
	$staffs_query = XN_Query::create("Content")->tag("ma_staffs")
							->filter("type", "eic", "ma_staffs")
							->filter('my.enablestatus', '=', '1')
							->filter("my.profileid", "in", $profileids)
							->filter('my.supplierid', '=', $supplierid)
							->filter("my.deleted", "=", "0")
							->end(-1)
							->execute();
	$saveConnt = array();
	foreach($staffs_query as $info){
		$info->my->departments = $depid;
		$saveConnt[] = $info;
	}
	if (count($saveConnt) > 0){
		XN_Content::batchsave($saveConnt,"ma_staffs");
	}
	$departments = XN_Query::create("Content")->tag("ma_departments_".$supplierid)
		->filter("type","eic","ma_departments")
		->filter("my.supplierid","=",$supplierid)
		->filter("id","!=",$depid)
		->filter("my.mainleadership", "in", $profileids)
		->end(-1)
		->execute();
	$saveConnt = array();
	foreach($departments as $info){
		$info->my->mainleadership = "";
		$saveConnt[] = $info;
	}
	if (count($saveConnt) > 0){
		XN_Content::batchsave($saveConnt,"ma_departments,ma_departments_".$supplierid);
	}
}




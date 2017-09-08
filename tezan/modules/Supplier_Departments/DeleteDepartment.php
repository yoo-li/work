<?php
	require_once('include/utils/UserInfoUtil.php');
	global $currentModule;
	require_once('modules/'.$currentModule.'/utils.php');
	global $current_user;

	if (isset($_REQUEST['record']) && $_REQUEST['record'] != '' && isset($_REQUEST['parent']) && $_REQUEST['parent'] != '')
	{
		$staffs_query = XN_Query::create("Content")->tag("ma_staffs")
								->filter("type", "eic", "ma_staffs")
								->filter('my.enablestatus', '=', '1')
								->filter("my.profileid", "=", $current_user->id)
								->filter("my.deleted", "=", "0")
								->end(1)
								->execute();
		if (count($staffs_query) > 0)
		{
			$supplierid = $staffs_query[0]->my->supplierid;
		}
		$record       = $_REQUEST['record'];
		$subCategorys = supplier_getSubDepartmentsID(0, $record, $supplierid);
		$allkeys      = array_keys($subCategorys);
		$allkeys[]    = $record;
		if (count($allkeys) > 0)
		{
			$query = XN_Query::create('Content')->tag('ma_staffs')
							 ->filter('type', 'eic', 'ma_staffs')
							 ->filter('my.departments', 'in', $allkeys)
							 ->execute();
			foreach ($query as $info)
			{
				$info->my->departments = $_REQUEST['parent'];
				$info->save('ma_staffs');
			}
			try
			{
				$loadcontent = XN_Content::loadMany($allkeys, 'ma_departments_'.$supplierid);
				foreach ($loadcontent as $info)
				{
					$info->my->deleted = "1";
					$info->save("ma_departments,ma_departments_".$supplierid);
				}
			}
			catch (XN_Exception $ex)
			{
				echo '{"statusCode":300,"message":"删除部门出错！"}';
				die();
			}
		}
		echo '{"statusCode":200,"message":"删除成功！相关数据已转移至指定部门！","divid":"DepartmentsManagerTreeForm","closeCurrent":true}';
		die();
	}
	echo '{"statusCode":300,"message":"指定的部门转移无效！"}';
	die();
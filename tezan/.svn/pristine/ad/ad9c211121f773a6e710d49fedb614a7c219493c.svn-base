<?php
	require_once('modules/'.$currentModule.'/utils.php');

	if (isset($_REQUEST['loadtree']) && $_REQUEST['loadtree'] == "true")
	{
		echo supplier_getDepartmentsTree();
		die();
	}
	global $currentModule, $current_user;
	global $app_strings, $mod_strings;
	require_once('modules/'.$currentModule.'/'.$currentModule.'.php');
	
	require_once('Smarty_setup.php');
	$smarty = new vtigerCRM_Smarty;

	$smarty->assign("MOD", $mod_strings);
	$smarty->assign("APP", $app_strings);
	$smarty->assign("MODULE", $currentModule);
	$smarty->display('Departments/DepartmentsManager.tpl');

	function supplier_getDepartmentsTree()
	{
		global  $supplierid,$supplierusertype; 
		 
		if(isset($supplierid) && !empty($supplierid))
		{
			supplier_getDepartments($supplierid, $hrarray);
			if (count($hrarray) <= 0 && !empty($supplierid))
			{
				$supplier                        = XN_Content::load($supplierid, "suppliers");
				$suppliername                    = $supplier->my->suppliers_name;
				$newcontent                      = XN_Content::create('supplier_departments', '', false);
				$newcontent->my->sequence        = "0";
				$newcontent->my->pid             = "";
				$newcontent->my->supplierid      = $supplierid;
				$newcontent->my->departmentsname = $suppliername;
				$newcontent->my->deleted         = '0';
				$newcontent->save('supplier_departments,supplier_departments_'.$supplierid);
				$hrarray[$newcontent->id] = array ('key'      => $newcontent->id,
												   'name'     => $newcontent->my->departmentsname,
												   'sequence' => $newcontent->my->sequence,
												   'parentid' => "");

			}
		} 
		$roleout = '';
		createGenericDepartmentsTree($roleout, $hrarray, null, null, false, false, true);
		$ztree = '<ul id="departmentsmanager-ztree" class="ztree"
                    data-setting="{callback:{beforeExpand:DepartmentsManager_OnBeforeExpand}}"
                    data-on-click="DepartmentsManager_onClick"
					data-toggle="ztree"
					';
		if ($supplierusertype=='boss')
		{
			$ztree .= '
					data-add-hover-dom = "DepartmentsManager_addHoverDom"
					data-remove-hover-dom = "DepartmentsManager_removeHoverDom"
					data-before-drop = "DepartmentsManager_beforeDrop"
					data-on-drop = "DepartmentsManager_onDrop"
					data-edit-enable = "true"
					data-on-node-created = "DepartmentsManager_onNodeCreated"
					data-on-collapse = "DepartmentsManager_CollapseTreeNode"
					data-on-expand = "DepartmentsManager_ExpandTreeNode"
			';
		}
		$ztree .= 'data-expand-all="false">'.$roleout.'</ul>';
		$ztree .= '<span id="departmentsmanager-ztree-string-width" style="visibility: hidden; white-space: nowrap;font-weight: bold;"></span>';
		return $ztree;
	}

	function supplier_getDepartments($supplierid, &$hrarray)
	{
		 
		$departments = XN_Query::create('Content')->tag('supplier_departments_'.$supplierid)
							   ->filter('type', 'eic', 'supplier_departments')
							   ->filter('my.deleted', '=', '0')
							   ->filter('my.supplierid', '=', $supplierid)
							   ->order('my.sequence', XN_Order::ASC_NUMBER)
							   ->end(-1)
							   ->execute();
		 
		if (isset($departments) && count($departments) > 0)
		{
			foreach ($departments as $department)
			{
				$leadership = $department->my->leadership;
				$mainleadership = $department->my->mainleadership;
				$leadership_screenname = null;
				$mainleadership_screenname = null;
				if (isset($leadership) && $leadership != "")
				{
					$leadership_screenname = getUserNameList(explode(";",$leadership));
					$leadership_screenname = join(";",$leadership_screenname);
				}

				if (isset($mainleadership) && $mainleadership != "")
				{
					$mainleadership_screenname = getUserNameByProfile($mainleadership);
				}
				$pid                      = $department->my->pid;
				$hrarray[$department->id] = array ('key'                => $department->id,
												   'name'               => $department->my->departmentsname,
												   'sequence'           => $department->my->sequence,
												   'leadership'         => $leadership_screenname,
												   'mainleadership'     => $mainleadership_screenname,
												   'parentid'           => $pid);
			}
		}
	}
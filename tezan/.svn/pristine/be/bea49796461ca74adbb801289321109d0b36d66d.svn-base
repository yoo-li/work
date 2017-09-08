<?php
	if (isset($_REQUEST["tabid"]) && $_REQUEST["tabid"] != "" && isset($_REQUEST["profileid"]) && $_REQUEST["profileid"] != "")
	{
		$profileid = $_REQUEST["profileid"];
		$tabid     = $_REQUEST["tabid"];

		$profile2fields      = XN_Query::create('Content')->tag('Profile2fields')
									   ->filter('type', 'eic', 'profile2fields')
									   ->filter('my.profileid', '=', $profileid)
									   ->filter('my.tabid', '=', $tabid)
									   ->end(-1)
									   ->execute();
		$profile2field_infos = array ();
		$field_infos         = array ();
		foreach ($profile2fields as $profile2field_info)
		{
			$profile2field_infos[$profile2field_info->my->tabid][] = $profile2field_info;
		}

		$fields = XN_Query::create('Content')->tag('Fields')
						  ->filter('type', 'eic', 'fields')
						  ->filter('my.tabid', '=', $tabid)
						  ->order('my.sequence', XN_Order::ASC_NUMBER)
						  ->end(-1)
						  ->execute();
		foreach ($fields as $field_info)
		{
			$field_infos[$field_info->my->tabid][$field_info->my->fieldname] = $field_info;
		}
		$profilelist = array ();
		foreach ($profile2field_infos as $tid => $profile2field_tab_infos)
		{
			$return_data    = array ();
			$module         = getModule($tid);
			$fields         = $field_infos[$tid];
			$profile_fields = array ();
			if (count($fields))
			{
				foreach ($fields as $field_info)
				{
					$fieldname = $field_info->my->fieldname;
					$fieldid   = $field_info->my->fieldid;
					foreach ($profile2field_tab_infos as $profile2field_info)
					{
						if ($fieldname == $profile2field_info->my->fieldname)
						{
							$visible          = $profile2field_info->my->visible;
							$profile_fields[] = $fieldname;
							$return_data[]    = array (
								$field_info->my->fieldlabel,
								$visible,
								$field_info->my->uitype,
								$visible,
								$fieldid,
								$field_info->my->displaytype,
								$field_info->my->typeofdata,
							);
							break;
						}
					}
				}
				foreach ($fields as $field_info)
				{
					$fieldname = $field_info->my->fieldname;
					$fieldid   = $field_info->my->fieldid;
					if (!in_array($fieldname, $profile_fields))
					{
						$return_data[] = array (
							$field_info->my->fieldlabel,
							'1',
							$field_info->my->uitype,
							'1',
							$fieldid,
							$field_info->my->displaytype,
							$field_info->my->typeofdata,
						);
					}
				}
			}
			$profilelist[$module] = $return_data;
		}

		$privilege_field = array ();
		for ($i = 0; $i < count($profilelist); $i++)
		{
			$field_module     = array ();
			$module_name      = key($profilelist);
			$module_id        = $tabid;
			$language_strings = return_module_language($current_language, $module_name);
			for ($j = 0; $j < count($profilelist[$module_name]); $j++)
			{
				$fldLabel    = $profilelist[$module_name][$j][0];
				$uitype      = $profilelist[$module_name][$j][2];
				$displaytype = $profilelist[$module_name][$j][5];
				$typeofdata  = $profilelist[$module_name][$j][6];
				$fieldtype   = explode("~", $typeofdata);
				$mandatory   = '';
				$readonly    = '';
				$field       = array ();
				if ($profilelist[$module_name][$j][3] == 0)
				{
					$visible = "checked";
				}
				else
				{
					$visible = "";
				}
				if ($fieldtype[1] == "M")
				{
					$mandatory = '<span style="color:red">*</span>';
					$readonly  = 'disabled';
					$visible   = "checked";
				}

				if ($language_strings[$fldLabel] != '')
					$fieldlabel = $mandatory.' '.$language_strings[$fldLabel];
				else
					$fieldlabel = $mandatory.' '.$fldLabel;
				$field[]        = '<label class="ilabel '.$readonly.'" style="font-weight:normal;" for="'.$module_id.'_field_'.$profilelist[$module_name][$j][4].'" >'.$fieldlabel.'</label>';
				$field[]        = '<input data-toggle="icheck" class="field" id="'.$module_id.'_field_'.$profilelist[$module_name][$j][4].'" onClick="selectUnselect(this);" type="checkbox" name="'.$profilelist[$module_name][$j][4].'" '.$visible.' '.$readonly.'>';
				$field_module[] = $field;
			}
			$privilege_field[$module_id] = array_chunk($field_module, 3);
			next($profilelist);
		}
		echo '{"statusCode":200, "fields":'.json_encode($privilege_field).'}';
	}
	else
	{
		echo '{"statusCode":300, "message":"获取字段信息失败"}';
	}

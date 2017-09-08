<?php
	global $supplierid;
	if (isset($_REQUEST["record"]) && $_REQUEST["record"] != "")
	{
			$record = $_REQUEST["record"];
		 
		 
			$modules_users = XN_Query::create("Content")->tag("supplier_modules_users_".$supplierid)
								   ->filter("type", "eic", "supplier_modules_users")
								   ->filter("my.deleted", "=", "0")
								   ->filter("my.supplierid", "=", $supplierid)
								   ->filter("my.profileid", "=", XN_Profile::$VIEWER)
								   ->filter("my.record", "=", $record)
								   ->end(-1)
								   ->execute();
			if (count($modules_users) == 0)
			{
				$newcontent = XN_Content::create("supplier_modules_users", "", false);
				$newcontent->my->untreated   = '10';
				$newcontent->my->processed   = '0';
				$newcontent->my->lasttime   =  date("Y-m-d H:i"); 
				$newcontent->my->record  = $record;
				$newcontent->my->profileid  = XN_Profile::$VIEWER;
				$newcontent->my->supplierid   = $supplierid;
				$newcontent->my->deleted      = "0";
				$newcontent->save("supplier_modules_users,supplier_modules_users_".$supplierid);
			}

			$modules_users = XN_Query::create("Content")->tag("supplier_modules_users_".$supplierid)
								   ->filter("type", "eic", "supplier_modules_users")
								   ->filter("my.deleted", "=", "0")
								   ->filter("my.supplierid", "=", $supplierid) 
								   ->filter("my.record", "=", $record)
								   ->end(-1)
								   ->execute();
			 
			$detailsinfo = array ();
			
			$html = '<table class="table table-bordered nowrap">';
			$html .= '<tr style="background-color:#EEEEEE;color:#013969;height: 30px;">
						<th style="text-align: center;width: 16%;">用户名</th>
						<th style="text-align: center;width: 16%;">未处理数</th>
						<th style="text-align: center;width: 16%;">已处理数</th>
						<th style="text-align: center;width: 16%;">最后处理时间</th>
					 </tr>';
 			foreach ($modules_users as $item)
 			{
				$profileid = $item->my->profileid;
 				$html .= '<tr>';
				$html .= '<td style="text-align: center;background-color: #EEEEEE;">'.getUserNameByProfile($profileid).'</td>';
				$html .= '<td style="text-align: center;">'.$item->my->untreated.'</td>';
				$html .= '<td style="text-align: center;">'.$item->my->processed.'</td>';
				$html .= '<td style="text-align: center;">'.$item->my->lasttime.'</td>';
				$html .= '</tr>';
 			} 
			$html .= '</table>';
			echo $html; 
	}
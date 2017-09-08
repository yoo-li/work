<?php
function getTopCalendar()
{  
	global $current_user,$currentModule;
	$query = XN_Query::create('Content')->tag('calendar')
			->filter('type','eic','calendar') 
			->filter('my.deleted', '=', '0' )
			->filter('my.personman','=',$current_user->id)
			->order('my.startdate',XN_Order::DESC)
			->begin(0)->end(7);
	$result = $query->execute();

	$entries=array();
	foreach($result as $info)
	{
		$dotheme=$info->my->dotheme;  
		$value=array(); 
		$recordid = $info->id; 
		$link = '<a  data-id="edit" data-toggle="navtab" data-title="'.getTranslatedString($currentModule).'信息" href="index.php?action=EditView&module='.$currentModule.'&record='.$recordid.'&amp;source=MainPage"><i class="fa fa-file-text-o"></i></a>';
 		$value['link']= $link;		
		if ($info->author == "")
		{
			$value['author']= "系统";
		}
		else
		{
			$value['author']= getUserName($info->author);
		}
		
		$value['submittime']= date('Y-m-d',strtotime($info->createdDate));
		$value['dotheme']=  $dotheme;
		$value['doclass']=  $info->my->doclass;
		$value['calendarstatus']= getTranslatedString($info->my->calendarstatus);
		$entries[$info->id]=$value;	
	} 
	return $entries;
}

$approvals = getTopCalendar();
//print_r($approvals);

if (count($approvals) > 0)
{
	echo '<div style="height:232px;overflow:hidden">
	<table id="listviewtop_calendar" class="table table-bordered table-hover table-striped" width="100%" cellspacing="0" cellpadding="0"   >
		<tbody>
			    <tr>	 
						<th align="center" style="white-space:nowrap;"><b><span title="提交人">提交人</span></b></th>
						<th align="center" style="white-space:nowrap;"><b><span title="待办主题">待办主题</span></b></th>
						<th align="center" style="white-space:nowrap;"><b><span title="类型">类型</span></b></th>
						<th align="center" style="white-space:nowrap;"><b><span title="执行状态">执行状态</span></b></th>
						<th align="center" style="white-space:nowrap;"><b><span title="操作">操作</span></b></th>
				</tr>';
	foreach ($approvals as $approval_info)
	{
		if ($approval_info['calendarstatus'] == 'true')
		{
			echo '<tr>
			        	<td align="center" style="background-color:#f5f5f5; white-space:nowrap;"><span>'.$approval_info['author'].'</span></td>
						<td align="center" class="listviewtop_calendar" style="background-color:#f5f5f5; white-space:nowrap;overflow:hidden;"><span data-toggle="poshytip" title="'.$approval_info['dotheme'].'">'.$approval_info['dotheme'].'</span></td>
						<td align="center" style="background-color:#f5f5f5; white-space:nowrap;"><span>'.$approval_info['doclass'].'</span></td>
						<td align="center" style="background-color:#f5f5f5; white-space:nowrap;"><span>'.$approval_info['calendarstatus'].'</span></td>
			        	<td align="center" style="background-color:#f5f5f5; white-space:nowrap;">'.$approval_info['link'].'</td>
				 </tr>';
		}
		else
		{
			echo '<tr>
			        	<td align="center" style="background-color:#f5f5f5; white-space:nowrap;"><span>'.$approval_info['author'].'</span></td>
						<td align="center" class="listviewtop_calendar" style="background-color:#f5f5f5; white-space:nowrap;overflow:hidden"><span data-toggle="poshytip" title="'.$approval_info['dotheme'].'">'.$approval_info['dotheme'].'</span></td>
						<td align="center" style="background-color:#f5f5f5; white-space:nowrap;"><span>'.$approval_info['doclass'].'</span></td>
						<td align="center" style="background-color:#f5f5f5; white-space:nowrap;"><span>'.$approval_info['calendarstatus'].'</span></td>
			        	<td align="center" style="background-color:#f5f5f5; white-space:nowrap;">'.$approval_info['link'].'</td>
				 </tr>';
		}
			
	}
			 
		echo	'</tbody></table></div>';
		
	 
}
else
{
	echo '<table  width="100%" height="232px" cellspacing="0" cellpadding="0"  >
			<tbody>
	                 <tr valign="top"  >
							<td width="100%">
								<div style=" overflow-y: hidden; overflow-x:hidden;width:100%;z-index:1;"> 
									<table class="table table-bordered table-hover table-striped" width="100%" >
										<tbody>
									        <tr>
												<td align="center"><span data-toggle="poshytip" title="无待办记录">无待办记录</span></td>
											</tr>
										</tbody>
									</table> 
								</div>
							</td>
					</tr>
		   </tbody>
		</table>';
}


?>

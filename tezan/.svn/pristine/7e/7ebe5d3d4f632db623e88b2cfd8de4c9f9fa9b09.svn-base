<?php
function getTopApprovals()
{  
	$query = XN_Query::create('Content')->tag('approvals')
			->filter('type','eic','approvals')
			->filter('my.finished','=','false')
			->filter('my.deleted', '=', '0' )
			->filter( XN_Filter::any(XN_Filter('my.userid', '=', XN_Profile::$VIEWER ),XN_Filter('my.proxyapproval', '=', XN_Profile::$VIEWER )))
			->order('published',XN_Order::DESC)
			->begin(0)->end(7);
	$result = $query->execute();

    $count = count($result);
	$entries=array();
	foreach($result as $info)
	{
		$value=array();
		$module = getModule($info->my->tabid);
		$recordid = $info->my->record;
		if($info->my->reply=="Agree"){
			$link = '<a  data-id="edit" title="查看" data-toggle="navtab" data-title="'.getTranslatedString($module).'" href="index.php?action=EditView&module='.$module.'&record='.$recordid.'"><i class="fa fa-file-text-o"></i></a>';
		}else{
			$link = '<a  data-id="edit" title="审批" data-toggle="navtab" data-title="'.getTranslatedString($module).'" href="index.php?action=EditView&module='.$module.'&record='.$recordid.'"><i class="fa fa-edit"></i></a>';
		}
 		$value['link']= $link;		
		$value['usename']= ''.implode(getUserNameByProfileId($info->my->from_userid), ',');
		$value['submittime']= date('Y-m-d',strtotime($info->createdDate));
		$value['tabid']=  getTranslatedString($module);
		$value['finished']= $info->my->finished;
		$entries[$info->id]=$value;	
	}

	if ($count < 7 )
	{
			$query = XN_Query::create('Content')->tag('approvals')
				->filter('type','eic','approvals')
				->filter('my.finished','=','true')
				->filter('my.deleted', '=', '0' )
				->filter( XN_Filter::any(XN_Filter('my.userid', '=', XN_Profile::$VIEWER ),XN_Filter('my.proxyapproval', '=', XN_Profile::$VIEWER )))
				->order('published',XN_Order::DESC)
				->begin(0)->end(7-$count);
			$result = $query->execute();

			foreach($result as $info)
			{
				$value=array();
				$module = getModule($info->my->tabid);  
				$recordid = $info->my->record;
				if($info->my->reply=="Agree"){
					$link = '<a  data-id="edit" title="查看" data-toggle="navtab" data-title="'.getTranslatedString($module).'" href="index.php?action=EditView&module='.$module.'&record='.$recordid.'"><i class="fa fa-file-text-o"></i></a>';
				}else{
					$link = '<a  data-id="edit" title="审批" data-toggle="navtab" data-title="'.getTranslatedString($module).'" href="index.php?action=EditView&module='.$module.'&record='.$recordid.'"><i class="fa fa-edit"></i></a>';
				}
  				//$value['link']= '-';	
				$value['link']= $link;		
				$value['usename']= ''.implode(getUserNameByProfileId($info->my->from_userid), ',');
				$value['submittime']= date('Y-m-d',strtotime($info->createdDate));
				$value['tabid']=  getTranslatedString($module);
				$value['finished']= $info->my->finished;
				$entries[$info->id]=$value;	
			}
	
	} 
	return $entries;
}

$approvals = getTopApprovals();
//print_r($approvals);

if (count($approvals) > 0)
{
	echo '<table class="table table-bordered table-hover table-striped" width="100%" cellspacing="0" cellpadding="0"   >
		<tbody>
			    <tr>	 
						<th align="center" style="word-break:keep-all;white-space:nowrap;"><b><b><span title="提交人">提交人</span></b></b></th>
						<th align="center" style="word-break:keep-all;white-space:nowrap;"><b><b><span title="提交时间">提交时间</span></b></b></th>
						<th align="center" style="word-break:keep-all;white-space:nowrap;"><b><b><span title="模块">模块</span></b></b></th>
						<th align="center" style="word-break:keep-all;white-space:nowrap;"><b><b><span title="操作">操作</span></b></b></th>
				</tr>';
				foreach ($approvals as $approval_info)
				{
					if ($approval_info['finished'] == 'true')
					{
						echo '<tr> 	
									<td align="center" class="listview" style="background-color:#f5f5f5 word-break:keep-all;white-space:nowrap;"><span  data-toggle="poshytip" title="'.$approval_info['usename'].'">'.$approval_info['usename'].'</span></td>
									<td align="center" class="listview" style="background-color:#f5f5f5 word-break:keep-all;white-space:nowrap;"><span data-toggle="poshytip" title="'.$approval_info['submittime'].'">'.$approval_info['submittime'].'</span></td>
									<td align="center" class="listview" style="background-color:#f5f5f5 word-break:keep-all;white-space:nowrap;"><span data-toggle="poshytip" title="'.$approval_info['tabid'].'">'.$approval_info['tabid'].'</span></td>
									<td align="center" class="listview" style="background-color:#f5f5f5 word-break:keep-all;white-space:nowrap;">'.$approval_info['link'].'</td>
							 </tr>';
					}
					else
					{
						echo '<tr>  	
									<td align="center" class="listview"  style="word-break:keep-all;white-space:nowrap;"><span data-toggle="poshytip" title="'.$approval_info['usename'].'">'.$approval_info['usename'].'</span></td>
									<td align="center" class="listview"  style="word-break:keep-all;white-space:nowrap;"><span data-toggle="poshytip" title="'.$approval_info['submittime'].'">'.$approval_info['submittime'].'</span></td>
									<td align="center" class="listview"  style="word-break:keep-all;white-space:nowrap;"><span data-toggle="poshytip" title="'.$approval_info['tabid'].'">'.$approval_info['tabid'].'</span></td>
									<td align="center" class="listview"  style="word-break:keep-all;white-space:nowrap;">'.$approval_info['link'].'</td>
						</tr>';
					}
			
				}
				 
		echo	'</tbody></table>';
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
												<td align="center"><span data-toggle="poshytip" title="无审批记录">无审批记录</span></td>
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

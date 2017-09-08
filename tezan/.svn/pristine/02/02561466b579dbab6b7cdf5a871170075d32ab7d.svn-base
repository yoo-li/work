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
		$link = '<a  data-id="edit" data-toggle="navtab" data-title="'.getTranslatedString($module).'信息" href="index.php?action=EditView&module='.$module.'&record='.$recordid.'"><i class="fa fa-file-text-o"></i></a>';
 		$value['link']= $link;		
		$value['usename']= ''.implode(getUserNameByProfileId($info->my->from_userid), ',');
		$value['submittime']= date('Y-m-d',strtotime($info->createdDate));
		$value['amount']= formatnumber($info->my->amount)."元";
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
				//$link = '<a  data-id="edit" data-toggle="navtab" data-title="'.getTranslatedString($module).'" href="index.php?action=EditView&module='.$module.'&record='.$recordid.'"><i class="fa fa-file-text-o"></i></a>';
  				$value['link']= '-';		
				$value['usename']= ''.implode(getUserNameByProfileId($info->my->from_userid), ',');
				$value['submittime']= date('Y-m-d',strtotime($info->createdDate));
				$value['amount']= formatnumber($info->my->amount)."元";
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
						<th align="center"><b><b>操作</b></b></th>
						<th align="center"><b><b>提交人</b></b></th>
						<th align="center"><b><b>提交时间</b></b></th>
						<th align="center"><b><b>审批金额</b></b></th>
				</tr>';
	foreach ($approvals as $approval_info)
	{
		if ($approval_info['finished'] == 'true')
		{
			echo '<tr>
			        	<td align="center" class="listview" style="background-color:#f5f5f5">'.$approval_info['link'].'</td>
						<td align="center" class="listview" style="background-color:#f5f5f5">'.$approval_info['usename'].'</td>
						<td align="center" class="listview" style="background-color:#f5f5f5">'.$approval_info['submittime'].'</td>
						<td align="center" class="listview" style="background-color:#f5f5f5">'.$approval_info['amount'].'</td>
				 </tr>';
		}
		else
		{
			echo '<tr> 
			 			<td align="center" class="listview">'.$approval_info['link'].'</td>
						<td align="center" class="listview">'.$approval_info['usename'].'</td>
						<td align="center" class="listview">'.$approval_info['submittime'].'</td>
						<td align="center" class="listview">'.$approval_info['amount'].'</td>
			</tr>';
		}
			
	}
				/*<tr>
								<td align="center" class="listview">-</td>
								<td align="center" class="listview">妮掌柜</td>
								<td align="center" class="listview">2016-02-19</td>
								<td align="center" class="listview">0元</td>
					</tr>
				<tr>
								<td align="center" class="listview"><a  data-id="edit" data-toggle="navtab" data-title="商家店铺" href="index.php?action=EditView&amp;module=Supplier_Shops&amp;record=254180"><i class="fa fa-file-text-o"></i></a></td>
								<td align="center" class="listview"><font color="#666666">妮掌柜</font></td>
								<td align="center" class="listview"><font color="#666666">2016-02-19</font></td>
								<td align="center" class="listview"><font color="#666666">0元</font></td>
					</tr>
				<tr>
								<td align="center" class="listview"><a  data-id="edit" data-toggle="navtab" data-title="商家店铺" href="index.php?action=EditView&amp;module=Supplier_Shops&amp;record=254180"><i class="fa fa-file-text-o"></i></a></td>
								<td align="center" class="listview"><font color="#666666">妮掌柜</font></td>
								<td align="center" class="listview"><font color="#666666">2016-02-19</font></td>
								<td align="center" class="listview"><font color="#666666">0元</font></td>
					</tr>
				<tr>
								<td align="center" class="listview"><a  data-id="edit" data-toggle="navtab" data-title="商家店铺" href="index.php?action=EditView&amp;module=Supplier_Shops&amp;record=254180"><i class="fa fa-file-text-o"></i></a></td>
								<td align="center" class="listview"><font color="#666666">妮掌柜</font></td>
								<td align="center" class="listview"><font color="#666666">2016-02-19</font></td>
								<td align="center" class="listview"><font color="#666666">0元</font></td>
					</tr>
				<tr>
								<td align="center" class="listview"><a  data-id="edit" data-toggle="navtab" data-title="商家店铺" href="index.php?action=EditView&amp;module=Supplier_Shops&amp;record=254180"><i class="fa fa-file-text-o"></i></a></td>
								<td align="center" class="listview"><font color="#666666">妮掌柜</font></td>
								<td align="center" class="listview"><font color="#666666">2016-02-19</font></td>
								<td align="center" class="listview"><font color="#666666">0元</font></td>
					</tr>
				<tr>
								<td align="center" class="listview"><a  data-id="edit" data-toggle="navtab" data-title="商家店铺" href="index.php?action=EditView&amp;module=Supplier_Shops&amp;record=254180"><i class="fa fa-file-text-o"></i></a></td>
								<td align="center" class="listview"><font color="#666666">妮掌柜</font></td>
								<td align="center" class="listview"><font color="#666666">2016-02-19</font></td>
								<td align="center" class="listview"><font color="#666666">0元</font></td>
					</tr>*/
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
												<td align="center">无审批记录</td>
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

<?php
function getTopAnnouncements()
{  
	global $current_user,$currentModule;
	
	
	
	$query = XN_Query::create('Content')->tag('announcements')
			->filter('type','eic','announcements') 
			->filter('my.deleted', '=', '0' ) 
			->filter('my.approvalstatus', '=', '2' )
			->order('published',XN_Order::DESC)
			->begin(0)->end(7);
	
	global  $supplierusertype, $supplierid;
	if ($supplierusertype != "superadmin")
	{
	    if (isset($supplierid) && $supplierid != "" && $supplierid != "0")
	    {
	        $query ->filter('my.supplierid', '=', $supplierid); 
	    }
	    else
	    {
	        $query ->filter('my.supplierid', '=', '0'); 
	    }
	}
	else
	{
	    $query ->filter('my.supplierid', '=', '0'); 
	}
	$result = $query->execute(); 
	

    $count = count($result);
	$entries=array();
	foreach($result as $info)
	{
		$value=array(); 
		$recordid = $info->id; 
		$link = '<a  data-id="edit" data-toggle="navtab" data-title="'.getTranslatedString($currentModule).'信息" href="index.php?action=EditView&module='.$currentModule.'&record='.$recordid.'&amp;source=MainPage"><i class="fa fa-file-text-o"></i></a>';
 		$value['link']= $link;		
		$value['author']= getUserName($info->author);
		$value['published']= date('Y-m-d',strtotime($info->published));
		$value['announcementstitle']=  $info->my->announcementstitle;
		$value['announcementstype']=  getTranslatedString($info->my->announcementstype);
		$entries[$info->id]=$value;	
	} 
	return $entries;
}

$approvals = getTopAnnouncements();
//print_r($approvals);

if (count($approvals) > 0)
{
	echo '<div style="height:232px;overflow:hidden;">
		<table id="listviewtop_announcements"  class="table table-bordered table-hover table-striped" width="100%" cellspacing="0" cellpadding="0"   >
		<tbody>
			    <tr>	  
						<th align="center" style="white-space:nowrap;"><b><b><span title="公告标题">公告标题</span></b></b></th>
						<th align="center" style="white-space:nowrap;"><b><b><span title="类型">类型</span></b></b></th>
						<th align="center" style="white-space:nowrap;"><b><b><span title="发布时间">发布时间</span></b></b></th>
						<th align="center" style="white-space:nowrap;"><b><b><span title="发布人">发布人</span></b></b></th>
						<th align="center" style="white-space:nowrap;"><b><b><span title="操作">操作</span></b></b></th>
				</tr>';
	foreach ($approvals as $approval_info)
	{
		if ($approval_info['calendarstatus'] == 'true')
		{
			echo '<tr>
			        	<td align="center" class="listviewtop_announcements" style="background-color:#f5f5f5; white-space:nowrap;overflow:hidden"><span data-toggle="poshytip" title="'.$approval_info['announcementstitle'].'">'.$approval_info['announcementstitle'].'</span></td>
						<td align="center" style="background-color:#f5f5f5; white-space:nowrap;"><span>'.$approval_info['announcementstype'].'</span></td>
						<td align="center" style="background-color:#f5f5f5; white-space:nowrap;"><span>'.$approval_info['published'].'</span></td>
			        	<td align="center" style="background-color:#f5f5f5; white-space:nowrap;"><span>'.$approval_info['author'].'</span></td>
						<td align="center" style="background-color:#f5f5f5; white-space:nowrap;">'.$approval_info['link'].'</td>
				 </tr>';
		}
		else
		{
			echo '<tr>
			        	<td align="center" class="listviewtop_announcements" style="background-color:#f5f5f5; white-space:nowrap;overflow:hidden"><span data-toggle="poshytip" title="'.$approval_info['announcementstitle'].'">'.$approval_info['announcementstitle'].'</span></td>
						<td align="center" style="background-color:#f5f5f5; white-space:nowrap;"><span>'.$approval_info['announcementstype'].'</span></td>
						<td align="center" style="background-color:#f5f5f5; white-space:nowrap;"><span>'.$approval_info['published'].'</span></td>
			        	<td align="center" style="background-color:#f5f5f5; white-space:nowrap;"><span>'.$approval_info['author'].'</span></td>
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
												<td align="center"><span data-toggle="poshytip" title="无公告记录">无公告记录</span></td>
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

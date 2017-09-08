<?php
global $currentModule,$current_user,$readOnly;
 

$submodule = strtolower($currentModule).'_sourcerlist';

function  mall_profiles($profileid,$page)
{ 
	global  $supplierid;
	$query = XN_Query::create ( 'Content' ) ->tag("supplier_profile_".$supplierid)
				->filter('type', 'eic', 'supplier_profile')
				->filter('my.deleted', '=', '0')
				->filter('my.supplierid', '=', $supplierid)
				->filter('my.onelevelsourcer', '=', $profileid)
				->order("published",XN_Order::DESC) 
				->begin(($page-1)*5)
				->end($page*5);
	
	 
	$profiles = $query->execute();
	$noofrows = $query->getTotalCount();  
	$profilelist = array();
	if (count($profiles) > 0)
	{  
		foreach($profiles as $profile_info)
		{
			$profile_id = $profile_info->my->profileid;
			$profile_info = XN_Profile::load($profile_id,"id","profile");
			$headimgurl = $profile_info->link;
			$givenname = strip_tags($profile_info->givenname);
			if ($headimgurl == "")
			{
				$headimgurl = 'images/ranks/new.png';
			}     
			$profilelist[$profile_id]['profileid'] = $profile_id;  
			$profilelist[$profile_id]['mobile'] = $profile_info->mobile;
			$profilelist[$profile_id]['identitycard'] = $profile_info->identitycard;  
			$profilelist[$profile_id]['birthdate'] = $profile_info->birthdate; 
			$profilelist[$profile_id]['gender'] = $profile_info->gender; 
			$profilelist[$profile_id]['headimgurl'] = $headimgurl; 
			$profilelist[$profile_id]['givenname'] = $givenname; 
			$profilelist[$profile_id]['invitationcode'] = $profile_info->invitationcode;
			$profilelist[$profile_id]['sourcer'] = $profile_info->sourcer;
			$profilelist[$profile_id]['province'] = $profile_info->province; 
			$profilelist[$profile_id]['city'] = $profile_info->city; 
		     
		} 
	}  
    return $profilelist; 
}


if(isset($_REQUEST["profileid"]) && $_REQUEST["profileid"] != "")
{
	if(isset($_REQUEST["page"]) && $_REQUEST["page"] != ""){
		$page = intval($_REQUEST["page"]);
		if (intval($page) < 0) $page = 0;
	}
	else
	{
		$page = 0;
	}
	$profileid = $_REQUEST["profileid"];
	$query = XN_Query::create ( 'Content' ) ->tag("supplier_profile_".$supplierid)
				->filter('type', 'eic', 'supplier_profile')
				->filter('my.deleted', '=', '0')
				->filter('my.supplierid', '=', $supplierid)
				->filter('my.onelevelsourcer', '=', $profileid)
				->order("published",XN_Order::DESC) 
				->begin($page*10)
				->end(($page+1)*10);
	
	$profiles = $query->execute();
	$noofrows = $query->getTotalCount();  
	$curcount = $page*10+count($profiles);
	
	$profilelist = array();
	if (count($profiles) > 0)
	{  
		foreach($profiles as $profile_info)
		{
			$profile_id = $profile_info->my->profileid;
			$profile_info = XN_Profile::load($profile_id,"id","profile");
			$headimgurl = $profile_info->link;
			$givenname = strip_tags($profile_info->givenname);
			if ($headimgurl == "")
			{
				$headimgurl = 'images/ranks/new.png';
			}     
			$profilelist[$profile_id]['profileid'] = $profile_id;  
			$profilelist[$profile_id]['mobile'] = $profile_info->mobile;
			$profilelist[$profile_id]['identitycard'] = $profile_info->identitycard;  
			$profilelist[$profile_id]['birthdate'] = $profile_info->birthdate; 
			$profilelist[$profile_id]['gender'] = $profile_info->gender; 
			$profilelist[$profile_id]['headimgurl'] = $headimgurl; 
			$profilelist[$profile_id]['givenname'] = $givenname; 
			$profilelist[$profile_id]['invitationcode'] = $profile_info->invitationcode;
			$profilelist[$profile_id]['sourcer'] = $profile_info->sourcer;
			$profilelist[$profile_id]['province'] = $profile_info->province; 
			$profilelist[$profile_id]['city'] = $profile_info->city; 
			$profilelist[$profile_id]['reg_ip'] = $profile_info->reg_ip;
			$profilelist[$profile_id]['browser'] = $profile_info->browser; 
			$profilelist[$profile_id]['published'] = $profile_info->published;
		     
		} 
	}   
	
    foreach($profilelist as $info){
                $tableRows .= '<tr>'; 
				$tableRows .= '<td  align="center"><img style="width:16px;height:16px;" src="'.$info['headimgurl'].'" /></td>'; 
                $tableRows .= '<td  align="center">'.$info['givenname'].'</td>'; 
				$tableRows .= '<td  align="center">'.$info['mobile'].'</td>'; 
				$tableRows .= '<td  align="center">'.$info['province'].'</td>'; 
				$tableRows .= '<td  align="center">'.$info['city'].'</td>';  
				$tableRows .= '<td  align="center">'.$info['gender'].'</td>'; 
				$tableRows .= '<td  align="center">'.$info['reg_ip'].'</td>'; 
				$tableRows .= '<td  align="center">'.$info['browser'].'</td>'; 
				$tableRows .= '<td  align="center">'.$info['published'].'</td>';  
                $tableRows .= '</tr>'; 
        
	}
	$tableTitle = '<th align="center">图像</th>
		            <th align="center">昵称</th>
					<th align="center">手机</th>
					<th align="center">省份</th>
					<th align="center">城市</th> 
					<th align="center">性别</th>
					<th align="center">注册IP</th>
					<th align="center">浏览器</th>
				    <th align="center">关注时间</th>';
	if($tableTitle != ""){
		$html = '
				<table id="'.$submodule.'_listView" class="table table-bordered" border="0" cellspacing="0" cellpadding="0">
					<tr id="cid_products" class="edit-form-tr">
						<td class="edit-form-tdinfo">
							<table id="acTab" class="table table-bordered" style="width:100%" name="acTab">
							<tbody>
								<tr id="listtitle">'.$tableTitle.'</tr>'.($tableRows!=""?$tableRows:'').'
							</tbody>
							</table>
						</td>
					</tr>
					<tr id="cid_page" class="edit-form-tr">
						<td class="edit-form-tdinfo">';  
							$allcount = $noofrows; 
							$html .='<span style="float:right;">总记录数：'.$allcount.'&nbsp;&nbsp;&nbsp;&nbsp;当前记录数：'.$curcount.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							'.($allcount == $curcount?($curcount <= 10?'':'
								<a class="j-ajax" onclick="'.$submodule.'_Before(\''.$submodule.'_listView\','.($page-1).');"><span style="cursor: pointer;">上一页</span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<span style="color:#dddddd;font">下一页</span>
							'):($page==0?'
								<span style="color:#dddddd;">上一页</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<a class="j-ajax" onclick="'.$submodule.'_Next(\''.$submodule.'_listView\','.($page+1).');"><span style="cursor: pointer;">下一页</span></a>
							':'
								<a class="j-ajax" onclick="'.$submodule.'_Before(\''.$submodule.'_listView\','.($page-1).');"><span style="cursor: pointer;">上一页</span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<a class="j-ajax" onclick="'.$submodule.'_Next(\''.$submodule.'_listView\','.($page+1).');"><span style="cursor: pointer;">下一页</span></a>
							')).'
						</span></td>
					</tr>
				</table>
				<script>
					function '.$submodule.'_Before(obj,page){
		                $.ajax({
		                    url : "index.php?module=Supplier_Profile&action=SourcerList&profileid='.$_REQUEST["profileid"].'&page="+page,
		                    async : false,
		                    type : "GET",
		                    success : function(result) { 
								var tableName = document.getElementById(obj);
		                        tableName.parentNode.innerHTML=result;
		                    }
		                });
					}
					function '.$submodule.'_Next(obj,page){
		                $.ajax({
		                    url : "index.php?module=Supplier_Profile&action=SourcerList&profileid='.$_REQUEST["profileid"].'&page="+page,
		                    async : false,
		                    type : "GET",
		                    success : function(result) { 
								var tableName = document.getElementById(obj);
		                        tableName.parentNode.innerHTML=result;
		                    }
		                });
					}
				</script>
		';
	}
}
echo $html;
?>

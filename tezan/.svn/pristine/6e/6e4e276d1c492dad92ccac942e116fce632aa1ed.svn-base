<?php
global $currentModule,$current_user,$readOnly;
global $profileid;

$recordSource = array();
$recordFilter = array();
$fields = array();
$html = '';
$tableTitle = '';
$tableRows = '';
$page = 0;
$allcount = 0;
$curcount = 0;
if(isset($_REQUEST["profileid"]) && $_REQUEST["profileid"] != ""){
	if(isset($_REQUEST["page"]) && $_REQUEST["page"] != ""){
		$page = intval($_REQUEST["page"]);
	}
	$profileid = $_REQUEST["profileid"];
	require_once('modules/'.$currentModule.'/config.field.php');
	if(isset($_REQUEST["frommodule"]) && $_REQUEST["frommodule"] != ""){
		$submodule = $_REQUEST["frommodule"];
		foreach($fields[$submodule] as $fed => $fvd){
			$tableTitle .= '<th '.(($fvd['talign']!="")?'align="'.$fvd['talign'].'"':"").' style="width:'.$fvd['width'].';white-space:nowrap;"><b>'.getTranslatedString($fvd['label'],$submodule).'</b></th>';
		}
        if($submodule=="Vips"){
            $query=XN_Query::create("Content")
                ->tag("topvips")
                ->filter("type","eic","topvips")
                ->filter("my.developerid",">","0")
                ->filter(XN_Filter::any(XN_Filter::all(XN_Filter("my.topprofileid","=",$profileid),XN_Filter("my.vip_type","=","1")),XN_Filter::all(XN_Filter("my.profileid","=",$profileid),XN_Filter("my.vip_type","in",array("2","3")))))
                ->filter("my.deleted","=","0")
                ->execute();
            if(count($query)){
                $popularize_details = XN_Query::create('Content')->tag('popularize_details')
                    ->filter('type','eic','popularize_details')
                    ->filter('my.deleted','=','0')
                    ->filter('my.inviteprofileid','=',$profileid)
                    ->begin(0)->end(1)
                    ->execute();
                $invites=array();
                if (count($popularize_details) > 0) {
                    $popularize_detail_info=$popularize_details[0];
                    $invite = $popularize_detail_info->my->invite;
                    $invites[]=$invite;
                }
                $profile=XN_Profile::load($profileid,"id","profile");
                $mobile=$profile->mobile;
                if($mobile!=""){
                    $invites[]=$mobile;
                }
                //print_r($invites);exit();
                if(!empty($invites) && count($invites)>0){
                    $contents = XN_Query::create('Profile')
                        ->tag('profile')
                        ->filter('invitationcode','in',$invites)
                        ->order('published',XN_Order::DESC)
                        ->begin($page*20)->end(($page+1)*20);
                    $ShareRecord=$contents->execute();
                    $allcount = $contents->getTotalCount();
                    $curcount = $page*20+count($ShareRecord);
                }


                $profileids=array();
                foreach($ShareRecord as $info){
                    $profileids[]=$info->screenName;
                }
                $givennames=getGivenNameArrByids($profileids);
                if(count($ShareRecord)){
                    foreach($ShareRecord as $info){
                        $tableRows .= '<tr>';
                        $tableRows.='<td align="center">'.$givennames[$info->screenName].'</td>';
                        $tableRows.='<td align="center">0</td><td align="center">0</td>';
                        $tableRows.='<td align="center">'.$info->published.'</td>';
                        $tableRows .= '</tr>';
                    }
                }
            }else{
                $contents = XN_Query::create('Content')->tag($recordSource[$submodule])
                    ->filter('type','eic',$recordSource[$submodule])
                    ->filter('my.deleted','=','0')
                    ->order('published',XN_Order::DESC)
                    ->begin($page*20)->end(($page+1)*20);
                if(isset($recordFilter[$submodule]) && is_array($recordFilter[$submodule]))
                    foreach($recordFilter[$submodule] as $filterArr){
                        if($submodule == 'Commissions'){
                            $contents->filter(XN_Filter::any(XN_Filter("my.profileid","=",$profileid),XN_Filter("my.topvips","=",$profileid)));
                            // ->XN_Filter::any(XN_Filter("my.profileid","=",$profileid),XN_Filter("my.topvips","=",$profileid))
                        }
                        else
                        {
                            if(isset($filterArr) && is_array($filterArr)){
                                $contents->filter($filterArr['field'],$filterArr['logic'],$filterArr['value']);
                            }
                        }

                    }
                $ShareRecord = $contents->execute();
                $allcount = $contents->getTotalCount();
                $curcount = $page*20+count($ShareRecord);

                $picklistData = array();
                $recordData = array();
                $profileData = array();
                foreach($fields[$submodule] as $fed => $fvd){
                    if(isset($fvd['picklist']) && $fvd['picklist'] != "" && isset($fvd["pickvalue"]) && $fvd["pickvalue"] != ""){
                        $picklists = XN_Query::create ( 'Content' )
                            ->filter ( 'type', 'eic', 'picklists' )
                            ->filter ( 'my.name', '=', $fvd['picklist'] )
                            ->execute ();
                        foreach($picklists as $pinfo)
                            $picklistData[$fvd["picklist"]][$pinfo->my->$fvd["pickvalue"]] = $pinfo->my->$fvd["picklist"];
                    }
                    if(isset($fvd['id2no']) && $fvd['id2no'] != "" && isset($fvd['idtablename']) && $fvd['idtablename'] != ""){
                        $recordData[$fed]["tabname"] = $fvd['idtablename'];
                        $recordData[$fed]["id2no"] = $fvd['id2no'];
                    }
                    if(isset($fvd['profileid']) && $fvd['profileid']) {
                        $profileData[] = $fed;
                    }
                }
                foreach($ShareRecord as $info){
                    foreach($recordData as $key => $value) {
                        if ($info->my->$key != "") {
                            $recordData[$key]["records"][] = $info->my->$key;
                        }
                    }
                    foreach($profileData as $value){
                        if ($info->my->$value != "") {
                            $profileData["records"][] = $info->my->$value;
                        }
                    }
                }
                foreach($recordData as $key => $value) {
                    if (isset($value["records"])) {
                        $loadrecord = XN_Content::loadMany($value["records"],$value["tabname"]);
                        foreach($loadrecord as $info){
                            $recordData[$key][$info->id] = $info->my->$value["id2no"];
                        }
                    }
                }
                if(isset($profileData["records"])){
                    $loadrecord = XN_Profile::loadMany($profileData["records"],"id","profile");
                    foreach($loadrecord as $info){
                        $profileData[$info->screenName] = $info->givenname;
                    }
                }
                // print_r($profileData);
                // die();
                foreach($ShareRecord as $info){
                    $tableRows .= '<tr>';
                    foreach($fields[$submodule] as $fed => $fvd){
                        if ($fed == "id" || $fed == "published")
                        {
                            $tmpValue = $info->$fed;
                        }
                        else
                        {
                            $tmpValue = $info->my->$fed;
                        }

                        if(isset($fvd['picklist']) && $fvd['picklist'] != "" && $tmpValue != "" && isset($fvd["pickvalue"]) && $fvd["pickvalue"] != ""){
                            // $picklists = XN_Query::create ( 'Content' )
                            // 	->filter ( 'type', 'eic', 'picklists' )
                            // 	->filter ( 'my.name', '=', $fvd['picklist'] )
                            // 	->filter ( 'my.'.$fvd["pickvalue"], '=', $tmpValue)
                            // 	->execute ();
                            // foreach($picklists as $pinfo)
                            // 	$tmpValue = $pinfo->my->$fvd["picklist"];
                            $tmpValue = $picklistData[$fvd["picklist"]][$tmpValue];
                        }
                        if(isset($fvd['profileid']) && $fvd['profileid'] != "" && !empty($tmpValue)){
                            try{
                                // $profile = XN_Profile::load($tmpValue,"id","profile");
                                // $tmpValue = $profile->givenname;
                                $tmpValue = $profileData[$tmpValue];
                            }catch(XN_Exception $e){
                                $tmpValue = "";
                            }
                        }
                        if(isset($fvd['id2no']) && $fvd['id2no'] != "" && !empty($tmpValue)){
                            try{
                                // $tmpValue = getModuleByToBy($fvd['idtablename'],$tmpValue,$fvd['id2no']);
                                $tmpValue = $recordData[$fed][$tmpValue];
                            }catch(XN_Exception $e){
                                $tmpValue = "";
                            }
                        }
                        else
                        {

                        }
                        $tableRows .= '<td '.(($fvd['calign']!="")?'align="'.$fvd['calign'].'"':"").'>'.$tmpValue.'</td>';
                    }
                    $tableRows .= '</tr>';
                }
            }
        }else{
            $contents = XN_Query::create('Content')->tag($recordSource[$submodule])
                ->filter('type','eic',$recordSource[$submodule])
                ->filter('my.deleted','=','0')
                ->order('published',XN_Order::DESC)
                ->begin($page*20)->end(($page+1)*20);
            if(isset($recordFilter[$submodule]) && is_array($recordFilter[$submodule]))
                foreach($recordFilter[$submodule] as $filterArr){
                    if($submodule == 'Commissions'){
                        $contents->filter(XN_Filter::any(XN_Filter("my.profileid","=",$profileid),XN_Filter("my.topvips","=",$profileid)));
                        // ->XN_Filter::any(XN_Filter("my.profileid","=",$profileid),XN_Filter("my.topvips","=",$profileid))
                    }
                    else
                    {
                        if(isset($filterArr) && is_array($filterArr)){
                            $contents->filter($filterArr['field'],$filterArr['logic'],$filterArr['value']);
                        }
                    }

                }
            $ShareRecord = $contents->execute();
            $allcount = $contents->getTotalCount();
            $curcount = $page*20+count($ShareRecord);

            $picklistData = array();
            $recordData = array();
            $profileData = array();
            foreach($fields[$submodule] as $fed => $fvd){
                if(isset($fvd['picklist']) && $fvd['picklist'] != "" && isset($fvd["pickvalue"]) && $fvd["pickvalue"] != ""){
                    $picklists = XN_Query::create ( 'Content' )
                        ->filter ( 'type', 'eic', 'picklists' )
                        ->filter ( 'my.name', '=', $fvd['picklist'] )
                        ->execute ();
                    foreach($picklists as $pinfo)
                        $picklistData[$fvd["picklist"]][$pinfo->my->$fvd["pickvalue"]] = $pinfo->my->$fvd["picklist"];
                }
                if(isset($fvd['id2no']) && $fvd['id2no'] != "" && isset($fvd['idtablename']) && $fvd['idtablename'] != ""){
                    $recordData[$fed]["tabname"] = $fvd['idtablename'];
                    $recordData[$fed]["id2no"] = $fvd['id2no'];
                }
                if(isset($fvd['profileid']) && $fvd['profileid']) {
                    $profileData[] = $fed;
                }
            }
            foreach($ShareRecord as $info){
                foreach($recordData as $key => $value) {
                    if ($info->my->$key != "") {
                        $recordData[$key]["records"][] = $info->my->$key;
                    }
                }
                foreach($profileData as $value){
                    if ($info->my->$value != "") {
                        $profileData["records"][] = $info->my->$value;
                    }
                }
            }
            foreach($recordData as $key => $value) {
                if (isset($value["records"])) {
                    $loadrecord = XN_Content::loadMany($value["records"],$value["tabname"]);
                    foreach($loadrecord as $info){
                        $recordData[$key][$info->id] = $info->my->$value["id2no"];
                    }
                }
            }
            if(isset($profileData["records"])){
                $loadrecord = XN_Profile::loadMany($profileData["records"],"id","profile");
                foreach($loadrecord as $info){
                    $profileData[$info->screenName] = $info->givenname;
                }
            }
            // print_r($profileData);
            // die();
            foreach($ShareRecord as $info){
                $tableRows .= '<tr>';
                foreach($fields[$submodule] as $fed => $fvd){
                    if ($fed == "id" || $fed == "published")
                    {
                        $tmpValue = $info->$fed;
                    }
                    else
                    {
                        $tmpValue = $info->my->$fed;
                    }

                    if(isset($fvd['picklist']) && $fvd['picklist'] != "" && $tmpValue != "" && isset($fvd["pickvalue"]) && $fvd["pickvalue"] != ""){
                        // $picklists = XN_Query::create ( 'Content' )
                        // 	->filter ( 'type', 'eic', 'picklists' )
                        // 	->filter ( 'my.name', '=', $fvd['picklist'] )
                        // 	->filter ( 'my.'.$fvd["pickvalue"], '=', $tmpValue)
                        // 	->execute ();
                        // foreach($picklists as $pinfo)
                        // 	$tmpValue = $pinfo->my->$fvd["picklist"];
                        $tmpValue = $picklistData[$fvd["picklist"]][$tmpValue];
                    }
                    if(isset($fvd['profileid']) && $fvd['profileid'] != "" && !empty($tmpValue)){
                        try{
                            // $profile = XN_Profile::load($tmpValue,"id","profile");
                            // $tmpValue = $profile->givenname;
                            $tmpValue = $profileData[$tmpValue];
                        }catch(XN_Exception $e){
                            $tmpValue = "";
                        }
                    }
                    if(isset($fvd['id2no']) && $fvd['id2no'] != "" && !empty($tmpValue)){
                        try{
                            // $tmpValue = getModuleByToBy($fvd['idtablename'],$tmpValue,$fvd['id2no']);
                            $tmpValue = $recordData[$fed][$tmpValue];
                        }catch(XN_Exception $e){
                            $tmpValue = "";
                        }
                    }
                    else
                    {

                    }
                    $tableRows .= '<td '.(($fvd['calign']!="")?'align="'.$fvd['calign'].'"':"").'>'.$tmpValue.'</td>';
                }
                $tableRows .= '</tr>';
            }
        }
	}
	if($tableTitle != ""){
		$html = '
				<table id="'.$submodule.'_listView" class="table table-bordered table-hover table-striped" cellspacing="0" cellpadding="0">
					<tr id="cid_products">
						<td>
							<table id="acTab" class="table table-bordered table-hover table-striped" style="width:100%" name="acTab">
							<tbody>
								<tr id="listtitle">'.$tableTitle.'</tr>'.($tableRows!=""?$tableRows:'').'
							</tbody>
							</table>
						</td>
					</tr>
					<tr id="cid_page">
						<td >';
						if($_REQUEST["frommodule"]=='Vips'){
                            $topvips_query=XN_Query::create("Content")
                                ->tag("topvips")
                                ->filter("type","eic","topvips")
                                ->filter(XN_Filter::any(XN_Filter::all(XN_Filter("my.topprofileid","=",$profileid),XN_Filter("my.vip_type","=","1")),XN_Filter::all(XN_Filter("my.profileid","=",$profileid),XN_Filter("my.vip_type","in",array("2","3")))))
                                ->filter("my.deleted","=","0")
                                ->end(1)
                                ->execute();
                            if(count($topvips_query)){
                                $num_str="";
                                $topvips_info=$topvips_query[0];
                                if($topvips_info->my->printnum>0){
                                    $num_str.='打印份数：'.$topvips_info->my->printnum.";";
                                }
                                if($topvips_info->my->persendnum>0){
                                    $num_str.='每日投放量：'.$topvips_info->my->persendnum.";";
                                }
                                if($num_str!=""){
                                    $html.='<span style="float:left;">'.$num_str.'</span>';
                                }
                            }
                        }

							$html .='<span style="float:right;">总记录数：'.$allcount.'&nbsp;&nbsp;&nbsp;&nbsp;当前记录数：'.$curcount.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							'.($allcount == $curcount?($curcount <= 20?'':'
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
		                    url : "index.php?module=Profile&action=ShareRecord&frommodule='.$submodule.'&profileid='.$_REQUEST["profileid"].'&page="+page,
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
		                    url : "index.php?module=Profile&action=ShareRecord&frommodule='.$submodule.'&profileid='.$_REQUEST["profileid"].'&page="+page,
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

<?php
require_once('Smarty_setup.php');
require_once('include/utils/utils.php');


global  $currentModule,$supplierid;

if (isset($_REQUEST['record']) && $_REQUEST['record'] != "" &&
    isset($_REQUEST['type']) && $_REQUEST['type'] == "submit" &&
	isset($_REQUEST['storename']) && $_REQUEST['storename'] != "" &&
	isset($_REQUEST['image']) && $_REQUEST['image'] != "" &&
	isset($_REQUEST['physicalstorerate']) && $_REQUEST['physicalstorerate'] != "")
{
    try {
        $record = $_REQUEST['record'];
        $storename = $_REQUEST['storename'];
 	    $physicalstorerate = $_REQUEST['physicalstorerate'];
		$image = $_REQUEST['image'];
		$longitude = $_REQUEST['longitude'];
		$latitude = $_REQUEST['latitude'];
		  
	 
	   	 require_once (XN_INCLUDE_PREFIX."/XN/Wx.php");
	 
    	 $location = XN_WX::geocoder($latitude,$longitude);
    	 if (count($location) > 0)
    	 {  
	   		 $address = $location['formatted_address'];
	   	     $newaddress = str_replace(array($location['province'],$location['city']),array ('',''),$address); 
   		
			
	 		$physicalstoreid = $record;
	 		$loadcontent =  XN_Content::load($record,"supplier_physicalstores",4); 
	 		$profileid  = $loadcontent->my->profileid;
	 		$supplierid = $loadcontent->my->supplierid;
	 		$loadcontent->my->bonusrate = $physicalstorerate;
	  	    $loadcontent->my->storename = $storename;
			$loadcontent->my->image = $image;
	 		$approvalstatus = $loadcontent->my->approvalstatus;
	 		if (!isset($approvalstatus) || $approvalstatus == "")
	 		{
	 			$loadcontent->my->supplier_physicalstoresstatus = 'JustCreated';
	 			$loadcontent->my->approvalstatus = '';
	 		} 
			
			 $loadcontent->my->longitude = $longitude;
			 $loadcontent->my->latitude = $latitude;
			 $loadcontent->my->address = $newaddress;
	   		 $loadcontent->my->province = $location['province'];
	   		 $loadcontent->my->city = $location['city']; 
	   		 $loadcontent->my->district = $location['district'];   
	   		 $loadcontent->my->street = $location['street'];  
		 
	 		 $loadcontent->save("supplier_physicalstores,supplier_physicalstores_" . $profileid. ",supplier_physicalstores_" . $supplierid);
	 		 
			 echo '{"statusCode":"200","message":null,"tabid":"'.$currentModule.'","closeCurrent":true,"forward":null}';
	 		 die(); 
    	 }
	   	 else
	   	 {
	   	 	echo '{"statusCode":"300","message":"无法获得实体店位置信息。"}';
	   		die();
	   	 }  
     } 
	catch ( XN_Exception $e )
    {
        echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
    }
    die();
}
else{ 
    $binds = $_REQUEST['ids']; 
    $binds = str_replace(";",",",$binds);
    $binds = explode(",",trim($binds,','));
    array_unique($binds);
	if (count($binds) > 1)
	{
		$smarty = new vtigerCRM_Smarty;
		global $mod_strings;
		global $app_strings;
		global $app_list_strings;
		$smarty->assign("APP", $app_strings);
		$smarty->assign("CMOD", $mod_strings); 
	    $msg = '<div style="width:100%;text-align:center;"><br><br><font color="red" size="2">您只能选择单条记录进行修改！</font></div>';  
		$smarty->assign("MSG", $msg);  
		$smarty->display("MessageBox.tpl");
		die();
	}
	else
	{
        $record = $_REQUEST['ids'];
        
		$loadcontent =  XN_Content::load($record,"supplier_physicalstores",4); 
		$profileid  = $loadcontent->my->profileid;
		$bonusrate = $loadcontent->my->bonusrate;
 	    $storename = $loadcontent->my->storename;
		$image = $loadcontent->my->image;
		$longitude = $loadcontent->my->longitude;
		$latitude = $loadcontent->my->latitude;
		if ($longitude == "" || $latitude == "") 
		{
			$latitude = 28.147347;
			$longitude = 112.992147;
		}
		
		$msg =  '<table border="0" cellpadding="0" cellspacing="0" width="940"><tbody>
				  <tr><td style="width:300px" valign="top">';
	    $msg .=  '<div class="form-group">
	                <label class="control-label x120">店铺名称:</label>
					<input type="text" class="form-control required" placeholder="请输入店铺名称" data-rule="required;" id="storename" name="storename"  value="'.$storename.'">
	            </div> 
				<div class="form-group">
					                <label class="control-label x120">店铺分佣比率:</label>
									<input type="text" class="form-control required" data-rule="required;number;range(0.00~99.99)" placeholder="请输入佣金比率"  id="physicalstorerate" name="physicalstorerate"  value="'.$bonusrate.'">%
                 
				</div> ';
			
		$pluploadhtml ='<div style="display: inline-block;">';
		$div_width=134;
		$div_height=134;
		$image_width=500;
		$image_height=500;  
		$pluploadhtml.=getCropperLoadHtml('dialog', 'image', $image, $div_width, $div_height, $image_width, $image_height, 'false',true);
		$pluploadhtml.='</div>'; 
		 
	
		$msg .=  '<div class="form-group">
					   <label class="control-label x120" style="vertical-align:top;margin-top:5p;">实体店店面图:</label> 
	                 '.$pluploadhtml.'
				</div>';
		$lowermodule = strtolower($currentModule);
		$msg .=  '<td style="width:600px">
			<input id="change_baidumap_longitude" name="changelongitude" type="hidden" value="0"/>
			<input id="change_baidumap_latitude" name="changelatitude" type="hidden" value="0"/>
			<input id="correct_baidumap_longitude" name="longitude" type="hidden" value="'.$longitude.'"/>
			<input id="correct_baidumap_latitude" name="latitude" type="hidden" value="'.$latitude.'"/>
			<div id="'.$lowermodule.'_mapcontainer" style="width:100%;height:500px;"></div>
			</td>';				   
		$msg .=  '</td></tr></tbody></table>';
		$msg .=  '<script language="JavaScript" src="http://api.map.baidu.com/api?v=1.3&callback=initialize&services=true" type="text/javascript"></script>';
		$script = 'var map,marker,point; 
function doSearch(){
        if (!document.getElementById("baidumap_city").value) {         
            return;
        }
        var search = new BMap.LocalSearch(document.getElementById("baidumap_city").value, {
            onSearchComplete: function (results){
                if (results && results.getNumPois()) {
                    var points = [];
                    for (var i=0; i<results.getCurrentNumPois(); i++) {
                        points.push(results.getPoi(i).point);
                    }
                    if (points.length > 1) {
                        map.setViewport(points);
                    } else {
                        map.centerAndZoom(points[0], 18);
                    }
                    point = map.getCenter();
                    marker.setPoint(point);
                } else {
                    alert(lang.errorMsg);
                }
            }
        });
        search.search(  document.getElementById("baidumap_cityarea").value || document.getElementById("baidumap_city").value);
}

function loadbaidumap()
{
	map = new BMap.Map("'.$lowermodule.'_mapcontainer");
    map.enableScrollWheelZoom();
    map.enableContinuousZoom();
    map.addControl(new BMap.NavigationControl());
    var longitude = document.getElementById("correct_baidumap_longitude").value;
	var latitude = document.getElementById("correct_baidumap_latitude").value;
	if ( longitude != "" && latitude != "" )
	{
		var point = new BMap.Point(longitude,latitude);    // 创建点坐标
		map.centerAndZoom(point, 18);                     // 初始化地图,设置中心点坐标和地图级别。
		var marker = new BMap.Marker(point);
		marker.enableDragging();
		marker.addEventListener("dragend", function(e){
		    $("#change_baidumap_longitude").val(1);
            $("#change_baidumap_latitude").val(1);
            $("#correct_baidumap_longitude").val(e.point.lng);
            $("#correct_baidumap_latitude").val(e.point.lat);
        })
		map.addOverlay(marker);
	}
	else
	{
	    var myCity = new BMap.LocalCity();
        myCity.get(iploac);
	}
}
function iploac(result){//根据IP设置地图中心
    var cityName = result.name;
    map.setCenter(cityName);
    var local = new BMap.LocalSearch(map, {
    renderOptions:{map: map}
    });
    local.setSearchCompleteCallback(function(searchResult){
        var poi = searchResult.getPoi(0);
        point = new BMap.Point(poi.point.lng,poi.point.lat);
        $("#correct_baidumap_longitude").val(poi.point.lng);
        $("#correct_baidumap_latitude").val(poi.point.lat);
        $("#change_baidumap_longitude").val(1);
        $("#change_baidumap_latitude").val(1);
        map.centerAndZoom(point, 18);
    });
    local.setMarkersSetCallback(function(){
        redefineOverlays();
    });
    local.search(cityName);
}
function redefineOverlays(){
            var objs=map.getOverlays();
            var mo_x=objs[0].getPosition().lng;
            var mo_y=objs[0].getPosition().lat;
            $("#correct_baidumap_longitude").val(mo_x);
            $("#correct_baidumap_latitude").val(mo_y);
            $("#change_baidumap_longitude").val(1);
            $("#change_baidumap_latitude").val(1);
            var length=objs.length;
            var i=0;
            for(i=0;i<length;i++){
                var obj=objs[i];
                var x=obj.getPosition().lng;
                var y=obj.getPosition().lat;
                map.removeOverlay(obj);
                var marker1 = new BMap.Marker(new BMap.Point(x, y));
                marker1.enableDragging();
                map.addOverlay(marker1);
                marker1.addEventListener("dragend", function(e){
                    $("#correct_baidumap_longitude").val(e.point.lng);
                    $("#correct_baidumap_latitude").val(e.point.lat);
                    $("#change_baidumap_longitude").val(1);
                    $("#change_baidumap_latitude").val(1);
                });
                marker1.addEventListener("click", function(e){
                    $("#correct_baidumap_longitude").val(e.point.lng);
                    $("#correct_baidumap_latitude").val(e.point.lat);
                    $("#change_baidumap_longitude").val(1);
                    $("#change_baidumap_latitude").val(1);
                });
            }
        }

setTimeout("loadbaidumap();",1000);';
	}
}

$smarty = new vtigerCRM_Smarty;
global $mod_strings;
global $app_strings;
global $app_list_strings;
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->assign("MSG", $msg);
$smarty->assign("OKBUTTON", "确定");
$smarty->assign("RECORD",$_REQUEST['ids']);
$smarty->assign("SUBMODULE", "Supplier_PhysicalStores");
$smarty->assign("SUBACTION", "ModifyPhysicalStore");

$smarty->assign("SCRIPT",$script);

$smarty->display("MessageBox.tpl");

?>
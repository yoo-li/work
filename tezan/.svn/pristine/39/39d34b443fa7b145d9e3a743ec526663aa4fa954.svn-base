<?php


require_once (XN_INCLUDE_PREFIX."/XN/Earth.php");


if(isset($_REQUEST['record']) && $_REQUEST['record'] !='') 
{
	global $currentModule;
	$loadcontent = XN_Content::load($_REQUEST['record'],strtolower($currentModule));
    $longitude = $loadcontent->my->longitude;
	$latitude = $loadcontent->my->latitude; 
	if ($longitude != "" && $latitude != "")
	{ 
		
	}
	else
	{
		$latitude = 28.147347;
		$longitude = 112.992147;
	}
	
	
	 
 
 
	$lowermodule =  strtolower($currentModule);
 
		echo '
				<input id="change_baidumap_longitude" name="changelongitude" type="hidden" value="0"/>
				<input id="change_baidumap_latitude" name="changelatitude" type="hidden" value="0"/>
				<input id="correct_baidumap_longitude" name="longitude" type="hidden" value="'.$longitude.'"/>
				<input id="correct_baidumap_latitude" name="latitude" type="hidden" value="'.$latitude.'"/>
				<div id="'.$lowermodule.'_mapcontainer" style="width:100%;height:500px;"></div>
				<script>
var map,marker,point;

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

setTimeout("loadbaidumap();",1000);
 
</script>
<script language="JavaScript" src="http://api.map.baidu.com/api?v=1.3&callback=initialize&services=true" type="text/javascript"></script>';
}


?>
 


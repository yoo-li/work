<?php

if(isset($_REQUEST['record']) && $_REQUEST['record'] !='') 
{
	global $currentModule;
	$loadcontent = XN_Content::load($_REQUEST['record'],strtolower($currentModule));
	$latitude = $loadcontent->my->latitude;
	$longitude = $loadcontent->my->longitude;

	$lowermodule =  strtolower($currentModule);
 
		echo '  <input id="baidumap_longitude" name="longitude" type="hidden" value="'.$longitude.'"/>
				<input id="baidumap_latitude" name="latitude" type="hidden" value="'.$latitude.'"/>
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
    var longitude = document.getElementById("baidumap_longitude").value;
	var latitude = document.getElementById("baidumap_latitude").value;
	if ( longitude != "" && latitude != "" )
	{
		var point = new BMap.Point(longitude,latitude);    // 创建点坐标
		map.addControl(new BMap.NavigationControl());
		map.centerAndZoom(point,18);   // 初始化地图,设置中心点坐标和地图级别。
		var marker = new BMap.Marker(point);
		marker.enableDragging();
		marker.addEventListener("dragend", function(e){
		    $("#baidumap_longitude").val(e.point.lng);
            $("#baidumap_latitude").val(e.point.lat);
        })
		map.addOverlay(marker);
	}
	else
	{
		map.addControl(new BMap.NavigationControl());
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
        map.centerAndZoom(point, 13);
    });
    local.search(cityName);
}


setTimeout("loadbaidumap();",1000);
 
</script>
<script language="JavaScript" src="http://api.map.baidu.com/api?v=1.3&callback=initialize&services=true" type="text/javascript"></script>';
}


?>
 


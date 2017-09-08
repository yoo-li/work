<?php

ini_set('memory_limit','256M');
set_time_limit(0);
header('Content-Type: text/html; charset=utf-8');
XN_Application::$CURRENT_URL = 'admin';
//$_SERVER["HTTP_X_NING_LOCAL_API_HOST_PORT"]="124.232.138.107:8000"; 
//XN_REST::$LOCAL_API_HOST_PORT = $_SERVER['HTTP_X_NING_LOCAL_API_HOST_PORT'];

// require_once (dirname(__FILE__) . "/../plugins/uppay_app/signorder.php");

// $key = "b5b129bd-9ce9-4a54-a124-7a00dd64fa810c593a87-4ccd-4c6e-8618-1ee8b857deab";
// $wxpay = array();
// $wxpay["tradenum"] = "ORD123456789";
// $wxpay["body"] = "测试phonegap微信支付";
// $wxpay["amount"] = "1";
// $wxpay["notifyurl"] = "http://demo.ttwz168.com/ttwz/plugins/wxpay_wap/notify_url.php";
// $wxpay["devinfo"] = "ios phonegap test";
// $wxpay["timeint"] = strtotime(date("Y-m-d H:m:s"));
// $wxpay["appid"] = "wxb9d454fbcce6c361"; //原生appid
// $wxpay["mchid"] = "1236821301"; //商户id
// $wxpay["partnerid"] = "ead58fec259c800ae1d1b986e2754ef8"; //商户token
// $tokenStr = $wxpay["tradenum"].$wxpay["body"].$wxpay["amount"].$wxpay["notifyurl"].$wxpay["devinfo"].$wxpay["timeint"].$wxpay["appid"].$wxpay["mchid"].$wxpay["partnerid"].$key;
// $wxtoken = md5($tokenStr);
// XN_MemCache::put(json_encode($wxpay),$wxtoken);
//

// $alipay = array();
// $alipay["tradenum"] = "ORD123456789";
// $alipay["body"] = "测试phonegap支付宝支付";
// $alipay["amount"] = "0.01";
// $alipay["notifyurl"] = "http://demo.ttwz168.com/ttwz/plugins/alipay_app/notify_url.php";
// $alipay["timeint"] = strtotime(date("Y-m-d H:m:s"));
// $alipay["productname"] = "测试订单";
// $alipay["extraparams"] = array("devinfo"=>"ios phonegap test");
// $alipay["partnerid"] = "2088011203419681";
// $alipay["sellerid"] = "ttwz168@ttwz168.com";
// $alipay["privkey"] = "MIICdwIBADANBgkqhkiG9w0BAQEFAASCAmEwggJdAgEAAoGBAM7jb/q8N3fzttRyNtEH5NF97NRK4cFzkEs4nYquR1U9HgpNlXZWS3uNRtKvGluBt/XcaQ0k62OEXCzkKPL0GvGN6s1Ajcu+7ymjRMYrkNINXtHwzMrC2pHM90W1QMwt1Yn8olBbkn1osDL81NUewpxSM/cfHI4KICUbcIb8zt4DAgMBAAECgYEAswkrPKZosgtcKpj0Swwzvf7lVgm/N/PT6OSDoSGUZXVQa8YcE542ECOAKI6TlqC5G7Cz0EYk1agTRF3l+em47cZ5JCz2fHw2jQIZDWS6ciNd0jHYcVhrcLY2nKj71a1WyIHarlANUe3D6CxNAtl9C6NsN+nwpLfPdtZtcuK0nKECQQDnqlhEYTF5IJbKu9tpgzRz8/04lt254SgdbN6b+AZLDuFh4SdmI3zfnSUWF99RAcdF5NEEzGCkQ1UDFm4U5a6LAkEA5J7SNtVlo0HvCxlYZqzMT0plbUukLVyRjcem75LlmqRmI6oAyCuL+3TxSEuzqgWZvh7V1hjTQPTOQ1KgGta1aQJBAIevtQ0v5Bsu5EMP7n4JNAKqKGkpq+pAHw/FAUlW5tC1gXqjtkDTjkMmtl8PUmQO55lfYLEvx3bOXQ925rjkoesCQHKR8REPska1hSEPy5Bw6laWFuxF6vncmQjvVAZdnHj6CEG5MXke8aDLgxtS7K+47MotU8ZeXIgB5tgwMRIiJXkCQA+HLlBz2Hf9NLHdOrMRv31JfIHInLuw/NqQthamgCoboiwtQwHoufT5qJ4Qltrzdmt7IHJuljLSLzFqmIs94WY=";
// $tokenStr = $alipay["tradenum"].$alipay["body"].$alipay["amount"].$alipay["notifyurl"].$alipay["productname"].$alipay["timeint"].$alipay["partnerid"].$alipay["sellerid"].$alipay["privkey"].$key;
// $alitoken = md5($tokenStr);
// XN_MemCache::put(json_encode($alipay),$alitoken);

//http://admin.ttwz168.com/ttwz/plugins/uppay_app/appConsume.php?parameter=97046736_1789_【特惠】多用途一体喷水玻璃清洁器_iOS-APP-ttwz-2.3.0_iPhone OS_8.3_2.3.0_1435730690.757985&token=6e44311e82df11e4e4ee1a90183ee403
// $uppay = array();
// $uppay["type"] = "uppay";
// $echomsg = payOrder("ORD123456789","1","测试phonegap银联支付","ios phonegap test");
// if (isset($echomsg["tn"]) && $echomsg["tn"] != "") {
// 	$uptoken = $echomsg["tn"];
// 	$uppay["token"] = $uptoken;
// }

function Verification($parameter,$token) {
	$newparameter = base64_decode($parameter);
	$key = "4c35458e913efbcf86ef621d22387b10";
	$Parameter = $parameter."_".$key;
	$md5str = md5($Parameter);
	if ($md5str === $token) {
		return json_decode($newparameter,true);
	}else{
		return array();
	}
}

$friendcircle = array();
$friendcircle["type"] = "sharefriendcircle";
$friendcircle["title"] = "dddd";
$friendcircle["desprition"] = "fffff";
$friendcircle["logo"] = "http://admin.ttwz168.com/ttwz/sharelogos/ttwg-181.jpg";
$friendcircle["url"] = "http://admin.ttwz168.com/ttwz//index.php?u=h4qwpi1q0de&d=2015-06-30";

$sharefriends = array();
$sharefriends["type"] = "sharefriends";
$sharefriends["title"] = "dddd";
$sharefriends["desprition"] = "fffff";
$sharefriends["logo"] = "http://admin.ttwz168.com/ttwz/sharelogos/ttwg-181.jpg";
$sharefriends["url"] = "http://admin.ttwz168.com/ttwz//index.php?u=h4qwpi1q0de&d=2015-06-30";

$createdb = array();
$createdb["type"] = "createdb";
$createdb["table"]["name"] = "test";	//数据库表名
$createdb["table"]["field"][] = array("name"=>"aaa","type"=>"integer","uniqer"=>"0"); //name：字段名；type：字段类型；uniqer：唯一值（0否，1是）
$createdb["table"]["field"][] = array("name"=>"bbb","type"=>"text");
$createdb["table"]["field"][] = array("name"=>"ccc","type"=>"integer");//double
$createdb["table"]["field"][] = array("name"=>"ddd","type"=>"date");
$createdb["table"]["uniqer"] = array("bbb","ccc"); //创建更多的索引字段

//if (isset($_REQUEST["parameter"]) && $_REQUEST["parameter"] != "" && isset($_REQUEST["token"]) && $_REQUEST["token"] != "") {
//	$Sou = Verification($_REQUEST["parameter"],$_REQUEST["token"]);
//	if(!isset($Sou) || !is_array($Sou) || count($Sou) <= 0){
//		echo '参数错误';
//		die();
//	}
//}else{
//	echo '参数错误';
//	die();
//}
echo '
	<!DOCTYPE html>
	<html lang  = "zh-CN">
	<head>
		<meta charset  = "utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<script type="text/javascript" charset="utf-8" src="/public/js/cordova.js"></script>
		<script>
		var uploadImage = new Array();
		function wxPay() {
			Cordova.exec(nativePluginResultHandler, nativePluginErrorHandler, "PhoneGapPlugin", "PluginFunction", [{"type":"wxpay","token":"'.$wxtoken.'"}]);
		}
		function aliPay() {
			Cordova.exec(nativePluginResultHandler, nativePluginErrorHandler, "PhoneGapPlugin", "PluginFunction", [{"type":"alipay","token":"'.$alitoken.'"}]);
		}
		function unPay() {
			Cordova.exec(nativePluginResultHandler, nativePluginErrorHandler, "PhoneGapPlugin", "PluginFunction", ['.json_encode($uppay).']);
		}
		function MultiselectPicture(isMult) {
			var imgH = document.getElementById("picheight").value;
			var imgW = document.getElementById("picwidht").value;
			if (imgH == "") {
				imgH = 0;
			}
			if (imgW == "") {
				imgW = 0;
			}
			var editpic = 0;
			if (document.getElementById("editpic").checked) {
				editpic = 1;
			}
			
			//onlyone 选取照片时，是多选还是单选，取值（0，1）
			//sourcetype 照片来源，是像册还是拍摄，取值（0，1）
			//quality 返回照片时精度，当imagetype=1时有效，取值（1，100）
			//width 返回照片时的宽度，当edit=1时有效
			//height 返回照片时的高度，当edit=1时有效
			//edit 在返回照片前是否可编辑，取值（0，1）
			//imagetype 返回照片的格式，取值（0，1）0：png，1：jpg
			//resulttype 返回数据类型，取值（0，1）0：Url，1：base64图片数据
			//无参数时默认拍摄模式，返回jpg格式
			Cordova.exec(multicamerasuccess, nativePluginErrorHandler, "MultiselectCamera", "takePicture", [{"onlyone":isMult,"sourcetype":0,"quality":100,"width":imgW,"height":imgH,"edit":editpic,"imagetype":1,"resulttype":0}]);
		}
		function MultiselectCamera(isMult) {
			var imgH = document.getElementById("picheight").value;
			var imgW = document.getElementById("picwidht").value;
			if (imgH == "") {
				imgH = 0;
			}
			if (imgW == "") {
				imgW = 0;
			}
			var editpic = 0;
			if (document.getElementById("editpic").checked) {
				editpic = 1;
			}
			Cordova.exec(multicamerasuccess, nativePluginErrorHandler, "MultiselectCamera", "takePicture", [{"onlyone":isMult,"sourcetype":1,"edit":editpic,"width":imgW,"height":imgH,"resulttype":0}]);
		}
		function UploadImage() {
			if (uploadImage.length <= 0) {
				alert("请选择或拍摄照片后才能上传图片！")
				return;
			}else{
   	         var content="";
   	         for(var key in uploadImage){
   	             content += key+": "+uploadImage[key]+"\n";
   	         }
   			 alert(content);
			}
			Cordova.exec(JsonResult, JsonResult, "PhoneGapPlugin", "PluginFunction", [{"type":"uploadfile","uploadinfo":uploadImage,"uploadurl":"http://m.tezan.cn/MobileUpload.php","filetype":"jpg"}]);
		}
		
		function Friendcircle() {
			Cordova.exec(nativePluginResultHandler, nativePluginErrorHandler, "PhoneGapPlugin", "PluginFunction", ['.json_encode($friendcircle).']);
		}
		function Friend() {
			Cordova.exec(nativePluginResultHandler, nativePluginErrorHandler, "PhoneGapPlugin", "PluginFunction", ['.json_encode($sharefriends).']);
		}
		function Location() {
			Cordova.exec(JsonResult, JsonResult, "Geolocation", "getLocation", [0]);
		}
		function WXLogin() {
			Cordova.exec(JsonResult, nativePluginErrorHandler, "PhoneGapPlugin", "PluginFunction", [{"type":"wxlogin"}]);
		}
		function Device() {
			cordova.exec(JsonResult, JsonResult, "PhoneGapPlugin", "PluginFunction", [{"type":"deviceinfo"}]);
		}
		function LoadContact() {
			Cordova.exec(JsonResult, nativePluginErrorHandler, "PhoneGapPlugin", "PluginFunction", [{"type":"loadcontact"}]);
		}
		function accountLogin() {
			var account = document.getElementById("loginaccount").value;
			var password = document.getElementById("loginpassword").value;
			Cordova.exec(JsonResult, JsonResult, "PhoneGapPlugin", "PluginFunction", [{"type":"accountlogin","account":account,"password":password}]);
		}
		function signOutLogin() {
			Cordova.exec(null, null, "PhoneGapPlugin", "PluginFunction", [{"type":"sginout","loadpage":"ttwz/api/phonegapdemo.php"}]);
		}
		function MessagePush() {
			Cordova.exec(nativePluginResultHandler, nativePluginErrorHandler, "PhoneGapPlugin", "PluginFunction", [{"type":"bindpush","profileid":"","product":"phonegap"}]);
		}
		function QRcode() {
			Cordova.exec(nativePluginResultHandler, JsonResult, "PhoneGapPlugin", "PluginFunction", [{"type":"qrcodescann"}]);
		}
		function createQRcode() {
			Cordova.exec(qrcodeResult, nativePluginResultHandler, "PhoneGapPlugin", "PluginFunction", [{"type":"createqrcode","qrcode":"com.cn.cs.qianliji.phonegapdemo://qrcodecreate?scu=test"}]);
		}
		function KeyValueSave() {
			var key = document.getElementById("storagekey").value;
			var value = document.getElementById("storagevalue").value;
			var encrypt = 0;
			if (document.getElementById("encrypt").checked) {
				encrypt = 1;
			}
			Cordova.exec(nativePluginResultHandler, nativePluginErrorHandler, "PhoneGapPlugin", "PluginFunction", [{"type":"keyvaluesave","key":key,"value":value,"encrypt":encrypt}]);
		}
		function KeyValueLoad() {
			var key = document.getElementById("storagekey").value;
			var encrypt = 0;
			if (document.getElementById("encrypt").checked) {
				encrypt = 1;
			}
			Cordova.exec(nativePluginResultHandler, nativePluginErrorHandler, "PhoneGapPlugin", "PluginFunction", [{"type":"keyvalueload","key":key,"encrypt":encrypt}]);
		}
		function KeyValueDel() {
			var key = document.getElementById("storagekey").value;
			Cordova.exec(nativePluginResultHandler, nativePluginErrorHandler, "PhoneGapPlugin", "PluginFunction", [{"type":"keyvaluedel","key":key}]);
		}
		function createDB() {
			Cordova.exec(nativePluginResultHandler, JsonResult, "PhoneGapPlugin", "PluginFunction", ['.json_encode($createdb).']);
		}
		function executeSQL() {
			var sql = document.getElementById("sqltext").value;
			if (sql == ""){
				alert("SQL语句为空");
			}else{
				Cordova.exec(nativePluginResultHandler, JsonResult, "PhoneGapPlugin", "PluginFunction", [{"type":"executesql","sql":sql}]);
			}
		}
		function executeQuery() {
			var sql = document.getElementById("sqltext").value;
			if (sql == ""){
				alert("SQL语句为空");
			}else{
				Cordova.exec(SqlQueryResult, JsonResult, "PhoneGapPlugin", "PluginFunction", [{"type":"executequery","table":"test","sql":sql}]);
			}
		}
		
		function createSQL() {
			document.getElementById("sqltext").value = "CREATE TABLE IF NOT EXISTS test (aaa INTEGER, bbb TEXT, ccc INTEGER, ddd DATE)";
		}
		function addSQL() {
			document.getElementById("sqltext").value = "INSERT INTO test VALUES (1,\"test1\",123,\"2015-07-15 15:30:00\")";
		}
		function querySQL() {
			document.getElementById("sqltext").value = "SELECT * FROM test";
		}
		
		function StartXMPP() {
			Cordova.exec(nativePluginResultHandler, JsonResult, "PhoneGapPlugin", "PluginFunction", [{"type":"startxmpp"}]);
		}
		
		function SendXMPP() {
			var xmppmsg = document.getElementById("xmppmsg").value;
			if (xmppmsg == "") {
				alert("不能发送空消息");
				return;
			}
			var xmpptoid = document.getElementById("xmpptoid").value;
			if (xmpptoid == "") {
				alert("接收对像不能为空");
				return;
			}
			Cordova.exec(nativePluginResultHandler, JsonResult, "PhoneGapPlugin", "PluginFunction", [{"type":"sendxmppmsg","toid":xmpptoid,"tomsg":xmppmsg}]);
		}
		
		function CloseXMPP() {
			Cordova.exec(null, null, "PhoneGapPlugin", "PluginFunction", [{"type":"closexmpp"}]);
		}
		
		function OpenLockScreen() {
			Cordova.exec(null, null, "PhoneGapPlugin", "PluginFunction", [{"type":"enabledlockscreen"}]);
		}
		function CloseLockScreen() {
			Cordova.exec(null, null, "PhoneGapPlugin", "PluginFunction", [{"type":"disablelockscreen"}]);
		}
		function SetLockScreen() {
			Cordova.exec(null, null, "PhoneGapPlugin", "PluginFunction", [{"type":"setuplockscreen"}]);
		}
		function OpenTouchID() {
			Cordova.exec(null, null, "PhoneGapPlugin", "PluginFunction", [{"type":"enabledtouchid"}]);
		}
		function CloseTouchID() {
			Cordova.exec(null, null, "PhoneGapPlugin", "PluginFunction", [{"type":"disabletouchid"}]);
		}
		
		function downloadwebstile() {
			Cordova.exec(null, null, "PhoneGapPlugin", "PluginFunction", [{"type":"downloadwebsite"}]);
		}
		function JsonResult(result){
	         var content="";
	         for(var key in result){
	             content += key+": "+result[key]+"\n";
	         }
			 alert(content);
		}
		function SqlQueryResult(result){
         var content="";
         for(var key in result){
			 var field = "";
			 for(var fd in result[key]){
			 	field += fd+":"+result[key][fd]+"\n";
			 }
             content += key+": "+field+"\n";
         }
		 alert(content);
		}

		function multicamerasuccess(result) {
	         var content="";
			 var div = document.getElementById("multiimgdiv");
	         for(var key in result){
				 var imgsrc = result[key];
				 var img = document.createElement("img");
				 img.src = imgsrc;
				 img.style.display = "block";
				 img.style.height = "140px";
				 img.style.width = "200px";
				 img.style.border = "1px solid #eeeeee";
				 div.appendChild(img);
	             content += key+": "+imgsrc+"\n";
				 uploadImage.push(imgsrc);
	         }
			 alert(content);
		}
		
		function qrcodeResult(result) {
			var qrcodeImage = document.getElementById("qrcodeImage");
			qrcodeImage.style.display = "block";
			qrcodeImage.src = "data:image/jpeg;base64," + result;
		}
		function nativePluginResultHandler (result) {
	        alert("SUCCESS: \n"+result );
	    }

	    function nativePluginErrorHandler (error) {
	        alert("ERROR: \n"+error );
	    }
		
		function xmppreceivemessage(msg) {
			alert(msg);
		}
		
		function returnback() {
			Cordova.exec(null, null, "PhoneGapPlugin", "PluginFunction", [{"type":"historyback"}]);
		}
		</script>
		<title>PhoneGap Demo</title>
	</head>
	<body style="text-align: center;"><br>
			<a href="demo.php?parameter='.$_REQUEST["parameter"].'&token='.$_REQUEST["token"].'">刷新本页面</a><br><br>
			<a href="javascript:void(0);"  onclick="returnback();">返回</a><br><br>
			<table style="width:100%;border-style: solid solid solid solid;border-width: 1px 1px 1px 1px;text-align: center;" cellspacing="0" cellpadding="2">
				<tr>
					<td>'.$Sou["sysname"].':'.$Sou["sysver"].'</td>
				</tr>
				<tr>
					<td>appver:'.$Sou["appver"].'</td>
				</tr>
				<tr>
					<td>sid:'.$Sou["supplierid"].'</td>
				</tr>
				<tr>
					<td>pid:'.$Sou["profileid"].'</td>
				</tr>
			</table><br>
			<table style="width:100%;border-style: solid solid solid solid;border-width: 1px 1px 1px 1px;text-align: center;" cellspacing="0" cellpadding="2">
				<tr style="height:30px;">
					<td><a href="javascript:void(0);" onclick="wxPay();">微信支付</a></td>
					<td><a href="javascript:void(0);" onclick="aliPay();">支付宝支付</a></td>
					<td><a href="javascript:void(0);" onclick="unPay();">银联支付</a></td>
				</tr>
				<tr style="height:30px;">
					<td><a href="javascript:void(0);" onclick="Location();">定位信息</a></td>
					<td><a href="javascript:void(0);" onclick="Device();">设备信息</a></td>
					<td><a href="javascript:void(0);" onclick="MessagePush();">绑定推送</a></td>
				</tr>
				<tr style="height:30px;">
					<td><a href="javascript:void(0);" onclick="Friendcircle();">分享微信朋友圈</a></td>
					<td><a href="javascript:void(0);" onclick="Friend();">分享指定微信朋友</a></td>
					<td><a href="javascript:void(0);" onclick="LoadContact();">获取联系人</a></td>
				</tr>
			</table><br>
			<table style="width:100%;border-style: solid solid solid solid;border-width: 1px 1px 1px 1px;text-align: center;" cellspacing="0" cellpadding="2">
				<tr>
					<td><input type = "checkbox" value="1" id="editpic"/><label for="editpic">可编辑</label></td>
					<td><label>取图宽度：</label><input type = "input" id="picwidht" style="width:40px;"/></td>
					<td><label>取图高度：</label><input type = "input" id="picheight" style="width:40px;"/></td>
				</tr>
				<!--<tr>
					<td style = "text-align:center;width:50%;"><img style="width:99%;height:140px;vertical-align:middle;display:block;border: 1px solid #eeeeee;" id="smallImage"/></td>
					<td style = "text-align:center;width:50%;"><img id="cameraresult" style="width:99%;height:140px;vertical-align:middle;display:block;border: 1px solid #eeeeee;"/></td>
				</tr>//-->
				<tr>
					<td colspan="3" align="center" id="multiimgdiv"></td>
				</tr>
				<tr>
					<td colspan="3" style="height:30px;">
						<a href = "javascript:void(0);" onclick="MultiselectPicture(1);">相册单选</a>&nbsp;&nbsp;
						<a href = "javascript:void(0);" onclick="MultiselectPicture(0);">多选</a>&nbsp;&nbsp;&nbsp;&nbsp;
						<a href = "javascript:void(0);" onclick="MultiselectCamera(1);">拍照单拍</a>&nbsp;&nbsp;
						<a href = "javascript:void(0);" onclick="MultiselectCamera(0);">多拍</a>&nbsp;&nbsp;&nbsp;&nbsp;
						<a href = "javascript:void(0);" onclick="UploadImage();">上传</a>
					</td>
				</tr>
			</table><br>
			<table style="width:100%;border-style: solid solid solid solid;border-width: 1px 1px 1px 1px;text-align: center;" cellspacing="0" cellpadding="2">
				<tr>
					<td style="width:50%;text-align:right;"><label>Key：</label></td>
					<td style="width:50%;text-align:left;"><input type = "input" id="storagekey" style="width:100px;" value="ProfileID"/></td>
				</tr>
				<tr>
					<td style="width:50%;text-align:right;"><label>Value：</label></td>
					<td style="width:50%;text-align:left;"><input type = "input" id="storagevalue" style="width:100px;"/></td>
				</tr>
				<tr>
					<td colspan="2"><input type = "checkbox" value="1" id="encrypt"/><label for="encrypt">加密处理</label></td>
				</tr>
				<tr>
					<td colspan="2" style="height:30px;">
						<a href="javascript:void(0);" onclick="KeyValueSave();">键值对保存</a>&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="javascript:void(0);" onclick="KeyValueLoad();">键值对提取</a>&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="javascript:void(0);" onclick="KeyValueDel();">键值对删除</a>
					</td>
				</tr>
			</table><br>
			<table style="width:100%;border-style: solid solid solid solid;border-width: 1px 1px 1px 1px;text-align: center;" cellspacing="0" cellpadding="2">
				<tr>
					<td colspan="3"><label style="width:20%">SQL：</label><textarea id="sqltext" style="width:80%;height:60px;"></textarea></td>
				</tr>
				<tr>
					<td><a href="javascript:void(0);" onclick="createSQL();">建表SQL例句</a><br><br></td>
					<td><a href="javascript:void(0);" onclick="addSQL();">添加SQL例句</a><br><br></td>
					<td><a href="javascript:void(0);" onclick="querySQL();">查询SQL例句</a><br><br></td>
				</tr>
				<tr>
					<td><a href="javascript:void(0);" onclick="createDB();">创建测试数据表</a><br><br></td>
					<td><a href="javascript:void(0);" onclick="executeSQL();">执行SQL命令</a><br><br></td>
					<td><a href="javascript:void(0);" onclick="executeQuery();">SQL查询数据</a><br><br></td>
				</tr>
			</table><br>
			<table style="width:100%;border-style: solid solid solid solid;border-width: 1px 1px 1px 1px;text-align: center;" cellspacing="0" cellpadding="2">
				<tr>
					<td colspan="2" align="center"><img style="width:200px;height:200px;vertical-align:middle;display:block;border: 1px solid #eeeeee;" id="qrcodeImage"/></td>
				</tr>
				<tr>
					<td><a href="javascript:void(0);" onclick="QRcode();">二维码扫描</a></td>
					<td><a href="javascript:void(0);" onclick="createQRcode();">创建二维码</a></td>
				</tr>
			</table><br>
			<table style="width:100%;border-style: solid solid solid solid;border-width: 1px 1px 1px 1px;text-align: center;" cellspacing="0" cellpadding="2">
				<tr>
					<td colspan="3"><label style="width:20%">ToProfield：</label><input id="xmpptoid" style="width:100px;" value='.$Sou["profileid"].'></input></td>
				</tr>
				<tr>
					<td colspan="3"><label style="width:20%">ToMessage：</label><textarea id="xmppmsg" style="width:80%;height:60px;"></textarea></td>
				</tr>
				<tr>
					<td><a href="javascript:void(0);" onclick="SendXMPP();">发送XMPP消息</a></td>
				</tr>
			</table><br>
		</body>
	</html>
	
	';
?>

var agent = navigator.userAgent;
var websiteroot = "";
var ProfileID = "";
var UUID = "";
var imgurl = "";
var givename = "";

if (agent.indexOf("tezan_android") != -1) {
	document.write('<script type="text/javascript" charset="utf-8" src="js/cordova.android.js"></script>');
}else if(agent.indexOf("tezan_iOS") != -1) {
	document.write('<script type="text/javascript" charset="utf-8" src="js/cordova.ios.js"></script>');
}

//添加Cordova脚本加载完事件回调
document.addEventListener("deviceready", onDeviceReady, false);


function getUrlParam(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
    var r = window.location.search.substr(1).match(reg);  //匹配目标参数
    if (r != null) return unescape(r[2]); return null; //返回参数值
}

function getCookie(name)//取cookies函数        
{
    var arr = document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));
    if(arr != null) return unescape(arr[2]); return null;
}

//PhoneGap Cordova脚本加载完成后回周函数。
function onDeviceReady() {
	//获取app内部Cookies
	// alert("onDeviceReady")
	Cordova.exec(AsynchronousLoad, AsynError, "PhoneGapPlugin", "PluginFunction", [{"type":"keyvalueload","key":"COOKIES","encrypt":"0"}]);
}
//PhoneGap Cordova脚本加载完成后回周响影事件
function AsynchronousLoad(obj){
	// alert("AsynchronousLoad")
	if (obj != "")
	{
		// alert(obj)
		var msg     = eval("(" + obj + ")");
		websiteroot = msg.WEBROOT;
		ProfileID   = msg.ProfileID;
		UUID        = msg.UUID;
		imgurl      = msg.imgurl;
		givename    = msg.givename;
		if (typeof(onWebSiteReady)=="function"){
			onWebSiteReady();
		}
	}
}

function AsynError(obj){
	alert(obj)
}
//app更新完成后调用的函数。这里只做了一下刷新当前页面的功能。
function UpdateWebSite() {
	window.location.replace(window.location.href.replace('#offCanvasSide',""));
}

//从数据服务器获取数据的函数。
//参数：path -> 为网络地址的相对路径
//参数：pre -> 为网络访问的URL参数
//参数：callback -> 为数据返回后回调函数
function getServerData(path,pre,successback,errorback){
	mui.ajax(websiteroot+path,{
		data:pre,
		dataType:'json',//服务器返回json格式数据
		type:'post',//HTTP请求类型
		async:true,
		timeout:10000,//超时时间设置为10秒；
		success:function(data){
			if (typeof(successback)=="function"){
				successback(data)
			}
		},
		error:function(xhr,type,errorThrown){
			if (typeof(errorback)=="function"){
				errorback(type)
			}
		}
	});
}
//绑定页面元素的点击事件
//参数：parent -> 父元素的筛选条件，需符合jquery标准
//参数：child -> 需绑定事件的元素筛选条析，需符合jquery标准
//参数：callback -> 事件执行函数
function BindTipEvent(parent,child,callback)
{
	mui(parent).off("tap",child,callback)
	mui(parent).on("tap",child,callback)
}
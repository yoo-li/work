/**
 * Created by clubs on 2017/2/20.
 */
document.write('<style><!--' +
			   '.user-info .mui-ellipsis .iconfont {width:18px;color: #fff; }' +
			   '--></style>' +
			   '<aside class="mui-off-canvas-left">' +
			   '	<div class="mui-scroll-wrapper">' +
			   '		<div class="mui-scroll">' +
			   '			<div class="user-info">' +
			   '				<a href="javascript:;">' +
			   '					<img class="mui-media-object mui-pull-left" src="images/logo.png">' +
			   '					<div class="mui-media-body">' +
			   '						尊敬的客人，您好！<br> <p class="mui-ellipsis">登陆之后内容更精彩!</p> ' +
			   '					</div>' +
			   '				</a>' +
			   '				<p style="text-align: center;">' +
			   '					<a class="mui-btn mui-btn-outlined mui-btn-primary Source-login">登陆 </a>' +
			   '				</p>' +
			   '			</div>' +
			   '			<ul class="mui-table-view mui-table-view-chevron mui-table-view-inverted left-menu-list">' +
			   '				<li class="mui-table-view-cell">' +
			   '					<a href="index.html" class="mui-navigate-right mui-ellipsis"><span class="mui-icon iconfont icon-mainpage"></span> 店铺首页 </a>' +
			   '				</li>' +
			   '			</ul>' +
			   '		</div>' +
			   '	</div>' +
			   '</aside>');

mui.ready(function() {
	LeftMenuBindEvent()
})

function LeftMenuBindEvent()
{
	BindTipEvent(".mui-table-view-cell",".Write-off",function(){
		Cordova.exec(null, null, "PhoneGapPlugin", "PluginFunction", [{"type":"sginout","loadpage":"index.html"}]);
	})
	BindTipEvent(".user-info",".Source-login",function(){
		Cordova.exec(null, null, "PhoneGapPlugin", "PluginFunction", [{"type":"sourcelogin"}]);
	})
}
function UpdateLeftMenu(profileinfo){
	var sb=new StringBuilder();
	if(profileinfo.profileid != "")
	{
		if (profileinfo.givename != "")
		{
			sb.append('<a href="javascript:;">' +
					  '		<img class="mui-media-object mui-pull-left" src="'+profileinfo.image+'">' +
					  '		<div class="mui-media-body">' + profileinfo.givename + '，您好！' +
					  '			<p class="mui-ellipsis">&nbsp;</p>' +
					  '		</div>' +
					  '</a>' +
					  '<p></p>')
		}else{
			sb.append('<a href="javascript:;">' +
					  '		<img class="mui-media-object mui-pull-left" src="images/logo.png">' +
					  '		<div class="mui-media-body">尊敬的客人，您好！<br>' +
					  '			<p class="mui-ellipsis">登录之后内容更精彩!</p>' +
					  '		</div>' +
					  '</a>')
		}
	}else{
		sb.append('<a href="javascript:;">' +
				  '		<img class="mui-media-object mui-pull-left" src="images/logo.png">' +
				  '		<div class="mui-media-body">尊敬的客人，您好！<br>' +
				  '			<p class="mui-ellipsis">登录之后内容更精彩!</p>' +
				  '		</div>' +
				  '</a>' +
				  '<p></p>' +
				  '<p style="text-align: center;">' +
				  '		<a class="mui-btn mui-btn-outlined mui-btn-primary Source-login">登陆 </a>' +
				  '</p>')
	}
	Zepto('.user-info').html(sb.toString())
	sb.clear()
	sb.append('<li class="mui-table-view-cell">' +
			  '		<a href="index.html" class="mui-navigate-right mui-ellipsis">' +
			  '			<span class="mui-icon iconfont icon-mainpage"></span> 跟单首页 ' +
			  '		</a>' +
			  '</li>')
	sb.append('<li class="mui-table-view-cell">' +
			  '		<a href="contactus.html" class="mui-navigate-right mui-ellipsis">' +
			  '			<span class="mui-icon iconfont icon-lianxiwomen"></span> 联系我们 ' +
			  '			<span class="left-desc"></span>' +
			  '		</a>' +
			  '</li>')
	if(profileinfo.profileid != ""){
		sb.append('<li class="mui-table-view-cell">' +
				  '		<a class="mui-navigate-right mui-ellipsis Write-off">' +
				  '			<span class="mui-icon iconfont icon-logo"></span> 注销 ' +
				  '			<span class="left-desc"></span>' +
				  '		</a>' +
				  '</li>')
	}
	Zepto('.left-menu-list').html(sb.toString())
	LeftMenuBindEvent()
}
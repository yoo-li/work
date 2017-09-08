/**
 * Created by clubs on 2017/2/20.
 */
document.write('<style><!-- ' +
			   '#copyright {  margin: 3px 3px; margin-bottom:10px;}' +
			   '#copyright .mui-table-view { background-color: #efeff4; }' +
			   '#copyright .mui-table-view-cell { width:310px;margin:0 auto }' +
			   '#copyright .mui-table-view .mui-media-object.mui-pull-left {  margin-right: 0px; margin-top: 0px; }' +
			   '#copyright .icon-logo { font-size: 3.0em;padding-right: 5px;color: #00b7ee; }' +
			   '#copyright .mui-ellipsis { color:#000; }' +
			   '#copyright .tezan {font-size:9px;font-family:Arial Narrow,Arial; }' +
			   '#copyright .tezan a {font-size:9px;font-family:Arial Narrow,Arial; }' +
			   '--></style>' +
			   '' +
			   '<div id="copyright" class="mui-card">' +
			   '	<ul class="mui-table-view">' +
			   '		<li class="mui-table-view-cell mui-media">' +
			   '			<div class="mui-media-object mui-pull-left"><span class="mui-icon iconfont menuicon" style="font-size: 3.0em;"></span></div>' +
			   '			<div class="mui-media-body">' +
			   '				<p class="mui-ellipsis copyright-title">大泗医疗器械产业投资有限公司</p>' +
			   '				<p class="mui-ellipsis copyright-link">Copyright © 2010-2017  <a href="www.dashi-china.com">www.dashi-china.com</a> All Rights Reserved.</p>' +
			   '			</div>' +
			   '		</li>' +
			   '	</ul>' +
			   '</div>')

function UpdateCopyRight(crinfo) {
	if(crinfo != null && crinfo != ""){
		Zepto('.copyright-title').html(crinfo.title)
		Zepto('.copyright-link').html('Copyright © 2010-2017  <a href="'+crinfo.link+'">'+GetUrlRelativePath(crinfo.link)+'</a> All Rights Reserved.')
	}
}
function GetUrlRelativePath(url)
{
	var arrUrl = url.split("//");
	var stop = arrUrl[1].indexOf(":");
	if(stop == -1)
		stop = arrUrl[1].indexOf("/");
	var relUrl = arrUrl[1].substring(0,stop);

	if(relUrl.indexOf("?") != -1){
		relUrl = relUrl.split("?")[0];
	}
	return relUrl;
}
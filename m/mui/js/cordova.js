var agent = navigator.userAgent;
if (agent.indexOf("tezan_android") != -1) {
	document.write('<script type="text/javascript" charset="utf-8" src="js/cordova.android.js"></script>');
}else if(agent.indexOf("tezan_iOS") != -1) {
	document.write('<script type="text/javascript" charset="utf-8" src="js/cordova.ios.js"></script>');
}

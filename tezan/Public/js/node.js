/**
 * Created by Clubs-Mac on 16/6/8.
 */
try{
	var gui = require("nw.gui");
	gui.App.clearCache();
	var win = gui.Window.get();
	win.maximize();
	//window.resizeTo(window.screen.width, window.screen.height);
}catch(e){}

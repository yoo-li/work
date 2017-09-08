/**
 * Created by clubs on 2017/6/14.
 */
WaitBarClass = {
	init: function (parent)
	{
		var Interface = {
			progress: 100,
			statusurl: '',
			complete: 'complete',
			title: '正在处理数据，请稍后...',
			parent: parent,
			mask: null,
			progressbar: null,
			progresstitle : null,
			getStatusID: -1,
			callback: null,
			delay: 2000
		};
		if (typeof parent != "undefined")
		{
			Interface.parent = parent;
		}
		this.createHtml(Interface);

		Interface.getStatus = function ()
		{
			if (this.statusurl == '')    return;
			var obj = Interface;
			$.ajax({
					   //async: false,//使用同步的Ajax请求
					   type: "GET",
					   url: this.statusurl,
					   dataType: "json",
					   success: function (msg)
					   {
						   if (msg != null)
						   {
							   if (msg.status == obj.complete)
							   {
								   clearTimeout(obj.getStatusID);
								   if (typeof obj.callback == "function")
								   {
									   obj.callback(msg);
								   }
								   obj.stop();
							   }
							   else
							   {
								   if (typeof msg.progress != "undefined" && parseInt(msg.progress, 10) > 0)
								   {
									   obj.progressbar.style.width = msg.progress + "%";
								   }
								   if (typeof msg.message != "undefined" && msg.message != ""){
								   	obj.progresstitle.innerText = msg.message;
								   }
								   obj.getStatusID = setTimeout(function (){obj.getStatus()}, obj.delay);
							   }
						   }
						   else
						   {
							   clearTimeout(obj.getStatusID);
							   if (typeof obj.callback == "function")
							   {
								   obj.callback({"statusCode": 300, "message": "处理失败！"});
							   }
							   obj.stop();
						   }
					   },
					   error: function (XMLHttpRequest, textStatus, errorThrown)
					   {
						   if (typeof obj.callback == "function")
						   {
							   obj.callback({"statusCode": 300, "message": errorThrown});
						   }
						   obj.stop();
					   }
				   });
		}

		Interface.start = function ()
		{
			if (Interface.getStatusID > -1)
				clearTimeout(Interface.getStatusID);
			Interface.progressbar.style.width = Interface.progress + "%";
			Interface.getStatusID             = setTimeout(function () {   Interface.getStatus() }, Interface.delay);
			Interface.mask.style.display      = "block";
			Interface.progresstitle.innerText = Interface.title;
		};
		Interface.stop  = function ()
		{
			if (document.getElementById("bjui-maskprogress"))
			{
				document.getElementById("bjui-maskprogress").remove();
			}
		};
		return Interface;
	},
	createHtml: function (Interface)
	{
		if (document.getElementById("bjui-maskprogress"))
		{
			document.getElementById("bjui-maskprogress").remove();
		}
		Interface.mask = document.createElement('div');
		Interface.mask.setAttribute("id", "bjui-maskprogress");
		Interface.mask.className = "bjui-dialog-wrap";
		Interface.mask.style.zIndex     = "10000";
		Interface.mask.style.position = "relative";
		Interface.mask.style.display  = "block";
		if (typeof Interface.parent != "undefined")
		{
			Interface.parent.appendChild(Interface.mask);
		}
		else
		{
			Interface.mask.style.position = "fixed";
			document.body.appendChild(Interface.mask);
		}
		var Panel       = document.createElement('div');
		Panel.className = "bjui-dialogBackground";
		Interface.mask.appendChild(Panel);
		Panel           = document.createElement('div');
		Panel.className = "bjui-maskProgress bjui-ajax-mask";
		Panel.style.width = "auto";
		Panel.style.minWidth = "300px";
		var empt = document.createElement('span');
		empt.style.paddingLeft = "10px";
		Panel.appendChild(empt);
		var icon        = document.createElement('i');
		icon.className  = "fa fa-cog fa-spin";
		Panel.appendChild(icon);
		Interface.progresstitle       = document.createElement('span');
		Interface.progresstitle.innerText = Interface.title;
		Interface.progresstitle.style.paddingLeft = "10px";
		Interface.progresstitle.style.paddingRight = "20px";
		Interface.progresstitle.style.fontSize = "14px";
		Panel.appendChild(Interface.progresstitle);
		var barbg                       = document.createElement('div');
		barbg.className                 = "progressBg";
		barbg.style.width = "96%";
		barbg.style.transform          = "translate(2%,0)";
		barbg.style.position = "static";
		Interface.progressbar           = document.createElement('div');
		Interface.progressbar.className = "progress";
		if (Interface.progress > 0)
			Interface.progressbar.style.width = Interface.progress + "%";
		else
			Interface.progressbar.style.width = "100%";
		barbg.appendChild(Interface.progressbar);
		Panel.appendChild(barbg);
		Interface.mask.appendChild(Panel);
		Panel           = document.createElement('div');
		Panel.className = "bjui-maskBackground bjui-ajax-mask";
		Interface.mask.appendChild(Panel);
	}
}
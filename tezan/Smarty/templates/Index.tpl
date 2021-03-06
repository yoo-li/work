<!DOCTYPE html>
<html lang="zh">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>{$APPLICATIONNAME}</title>
	{if $copyrights.favicon eq ''}
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
	{else}
		<link rel="shortcut icon" href="{$copyrights.favicon}" type="image/x-icon"/>
	{/if}
	<!-- bootstrap - css -->
	<link href="/Public/BJUI/themes/css/bootstrap.css" rel="stylesheet">
	<!-- core - css -->
	<link href="/Public/BJUI/themes/css/style.css" rel="stylesheet">
	<link href="/Public/BJUI/themes/blue/core.css" id="bjui-link-theme" rel="stylesheet">
	<link href="/Public/BJUI/themes/css/FA/css/font-awesome.min.css" rel="stylesheet">
	<link href="/Public/BJUI/plugins/niceValidator/jquery.validator.css" rel="stylesheet">
	<link href="/Public/BJUI/plugins/treegrid/jquery.treegrid.css" rel="stylesheet">
	<link href="/Public/BJUI/plugins/bootstrapSelect/bootstrap-select.css" rel="stylesheet">
	<link href="/Public/BJUI/plugins/colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet">
	<link href="/Public/css/global.css" rel="stylesheet" type="text/css" media="all">
	<link href="/Public/css/icon.css" rel="stylesheet" type="text/css" media="all">
	<link href="/Public/css/lightbox.css" rel="stylesheet" type="text/css"/> 
	<link rel="stylesheet" href="/Public/css/tip-yellow.css" type="text/css"/>
	<script src="/Public/js/jquery-1.11.3.min.js"></script>
	<script src="/Public/js/lightbox.min.js" type="text/javascript"></script>
	<script src="/Public/js/plupload.full.min.js" type=text/javascript></script>
	<script src="/Public/js/plupload.zh_CN.js" type=text/javascript></script>
	<script src="/Public/js/plupload.js" type=text/javascript></script>
 	<script type="text/javascript" src="/Public/js/jquery.poshytip.js"></script>
  </head>

<body>
<div id="bjui-window">
	<header id="bjui-header" style="height:50px;">
		<div class="bjui-navbar-header">
			<button type="button" class="bjui-navbar-toggle btn-default" data-toggle="collapse" data-target="#bjui-navbar-collapse">
				<i class="fa fa-bars"></i>
			</button>
			<a class="bjui-navbar-logo" href="#"><img src="{$copyrights.logo}"></a>
		</div>
		<nav id="bjui-navbar-collapse" style="margin-top: 0px;">
			<ul id="navbartopline" class="bjui-navbar-right">
				<li class="datetime">
					<div><span id="bjui-date"></span> <span id="bjui-clock"></span></div>
				</li>
				<!--<li><a href="#"><i class="fa fa-weixin"></i>&nbsp;<span class="badge">0</span></a></li>-->
				{if $shoppingcart_num!==false}
					<li>
						<a data-toggle="dialog" data-id="shoppingcartsdialog" data-title="购物车" data-mask="true" data-maxable="false" data-resizable="false" data-width="800" data-height="600" href="index.php?module=Ma_Products&action=ShoppingCart">{$APP.LBL_SHOPPINGCARTS}
							<span id="shoppingcart_num" class="badge">{$shoppingcart_num}</span></a></li>
				{/if}
				<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">{$APP.LBL_MYACCOUNT}
						<span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li>
							<a href="index.php?module=Users&action=ChangePassword&profileid={$VIEWER}" data-toggle="dialog" data-id="changepwd_page" data-mask="true" data-maxable="false" data-resizable="false" data-width="500" data-height="360">&nbsp;<span class="glyphicon glyphicon-lock"></span> {$APP.LBL_CHANGEPASSWORD}
																																																													 &nbsp;</a>
						</li>
						<!--<li><a href="#">&nbsp;<span class="glyphicon glyphicon-user"></span> {$APP.LBL_MYPERSONINFO}</a></li>
                        <li class="divider"></li>
                        -->
						<li>
							<a href="index.php?module=Users&action=about_us" data-toggle="dialog" data-id="changepwd_page" data-mask="true" data-maxable="false" data-resizable="false" data-width="500" data-height="360">&nbsp;<span class="glyphicon glyphicon-copyright-mark"></span> {$APP.LBL_ABOUTUS}
																																																						   &nbsp;</a>
						</li>
						<li class="divider"></li>
						<li>
							<a href="index.php?module=Users&action=Logout" class="red">&nbsp;<span class="glyphicon glyphicon-off"></span> {$APP.LBL_LOGOUT}
							</a></li>
					</ul>
				</li>
				{if $copyrights.program eq 'ma'}
					<li><a target="_blank" href="/help/"><i class="fa fa-question-circle"></i> {$APP.LBL_HELP}</a></li>
				{/if}
				<li class="dropdown">
					<a href="#" class="dropdown-toggle theme blue" data-toggle="dropdown" title="切换皮肤"><i class="fa fa-flag"></i></a>
					<ul class="dropdown-menu" role="menu" id="bjui-themes">
						<li>
							<a href="javascript:;" class="theme_default" data-toggle="theme" data-theme="default">&nbsp;<i class="fa fa-flag"></i> {$APP.LBL_THEME_DEFAULT}
																												  &nbsp;&nbsp;</a></li>
						<li>
							<a href="javascript:;" class="theme_orange" data-toggle="theme" data-theme="orange">&nbsp;<i class="fa fa-flag"></i> {$APP.LBL_THEME_ORANGE}
							</a></li>
						<li>
							<a href="javascript:;" class="theme_purple" data-toggle="theme" data-theme="purple">&nbsp;<i class="fa fa-flag"></i> {$APP.LBL_THEME_PURPLE}
							</a></li>
						<li class="active">
							<a href="javascript:;" class="theme_blue" data-toggle="theme" data-theme="blue">&nbsp;<i class="fa fa-flag"></i> {$APP.LBL_THEME_BLUE}
							</a></li>
						<li>
							<a href="javascript:;" class="theme_green" data-toggle="theme" data-theme="green">&nbsp;<i class="fa fa-flag"></i> {$APP.LBL_THEME_GREEN}
							</a></li>
					</ul>
				</li>
			</ul>
			<ul id="bjui-navbar-right" style="padding-right:40px;padding-top:30px;">
				<li style="float: right;">{$CURRENT_USER}，{$APP.LBL_HELLO}
														 &nbsp;{if $LASTLOGINTIME neq ''}{$APP.LBL_LASTLOGINTIME}：{$LASTLOGINTIME}{else}{$APP.LBL_FIRSTLOGINTIME}{/if}
														 &nbsp;&nbsp;{if $TRIALTIME neq ''}{$APP.LBL_TRIALTIME}: {$TRIALTIME}{/if}</li>
			</ul>
		</nav>
	</header>

	<div id="bjui-container">
		<div id="bjui-leftside">
			<div id="bjui-sidebar-s">
				<div class="collapse"></div>
			</div>
			<div id="bjui-sidebar">
				<div class="toggleCollapse"><h2><i class="fa fa-bars"></i> {$APP.LBL_MAINMENU} <i class="fa fa-bars"></i></h2>
					<a href="javascript:;" class="lock"><i class="fa fa-lock"></i></a></div>
				<div class="panel-group panel-main" data-toggle="accordion" id="bjui-accordionmenu" data-heightbox="#bjui-sidebar" data-offsety="26">
					{include file='LeftMenu.tpl'}
				</div>
			</div>
		</div>
		<div id="bjui-navtab" class="tabsPage">
			<div class="tabsPageHeader">
				<div class="tabsPageHeaderContent">
					<ul class="navtab-tab nav nav-tabs">
						<!--首页加载url-->
						<li data-url=""><a href="javascript:;"><span><i class="fa fa-home"></i> #maintab#</span></a></li>
					</ul>
				</div>
				<div class="tabsLeft"><i class="fa fa-angle-double-left"></i></div>
				<div class="tabsRight"><i class="fa fa-angle-double-right"></i></div>
				<div class="tabsMore"><i class="fa fa-angle-double-down"></i></div>
			</div>
			<ul class="tabsMoreList">
				<li><a href="javascript:;">#maintab#</a></li>
			</ul>
			<div class="navtab-panel tabsPageContent">
				<div class="navtabPage unitBox">
					<div class="bjui-pageContent" style="background:#FFF;padding:0px;">
						<div style="margin:1px;">
							{assign var="rowindex" value=1}
							{assign var="homeframescolumn" value=$copyrights.homeframescolumn}
							{foreach name=homeframe key=stuffkey item=homeinfo from=$HOMEFRAME }
							{if $homeinfo.width eq '100%'}
							{if $rowindex eq '1'}
							<div style="overflow:hidden;width:100%;">
								{include file="MainHomeBlock.tpl"}
							</div>
							{else}
						</div>
						<div style="overflow:hidden;width:100%;">
							{include file="MainHomeBlock.tpl"}
						</div>
						{assign var="rowindex" value=1}
						{/if}
						{else}
						{assign var="layoutpos" value=$rowindex%$homeframescolumn}
						{if $smarty.foreach.homeframe.first || $layoutpos eq 1 }
						<div style="overflow:hidden;width:100%;">
							{/if}
							{include file="MainHomeBlock.tpl"}
							{if $smarty.foreach.homeframe.last || $layoutpos eq 0}
						</div>
						{/if}
						{assign var="rowindex" value=$rowindex+1}
						{/if}
						{/foreach}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<footer id="bjui-footer">
	Copyright &copy; 2010-{$THISYEAR} <a href="http://www.{$copyrights.site}" target="_blank">{$copyrights.site}</a> All Rights Reserved.
	&nbsp;&nbsp;&nbsp;<span>{$copyrights.icp}</span>
	&nbsp;&nbsp;&nbsp;<span>{$APP.LBL_RECOMMENDEXPLORER}</span>
</footer>
</div>

<!-- Cropping modal -->
<div id="dialog_upload_dialog_target" data-noinit="true" class="hide">
	<div class="bjui-pageContent" id="dialog_upload_dialog">
		<form class="avatar-form" action="Upload_crop.php" enctype="multipart/form-data" method="post">
			<div class="avatar-body">
				<!-- Upload image and data -->
				<div class="avatar-upload">
					<input class="avatar-src" name="avatar_src" type="hidden"/>
					<input class="avatar-data" name="avatar_data" type="hidden"/>
					<input class="avatar-input" accept="image/jpeg,image/gif,image/png" id="avatarInput" name="avatar_file" type="file"/>
				</div>
				<!-- Crop and preview -->
				<div class="row">
					<div class="col-md-9">
						<div class="avatar-wrapper"></div>
					</div>
					<div class="col-md-3">
						<div class="avatar-preview preview-lg"></div>
						<div class="avatar-preview preview-md"></div>
						<div class="avatar-preview preview-sm"></div>
					</div>
				</div>

				<div class="row avatar-btns">
					<div class="col-md-9">
						<div class="btn-group">
							<button class="btn btn-primary" data-method="rotate" data-option="-90" type="button" title="左旋90&deg;">
								<span class="fa fa-rotate-left"></span> 90&deg;
							</button>
							<button class="btn btn-primary" data-method="rotate" data-option="-15" type="button">
								<span class="fa fa-rotate-left"></span> 15&deg;
							</button>
							<button class="btn btn-primary" data-method="rotate" data-option="-30" type="button">
								<span class="fa fa-rotate-left"></span> 30&deg;
							</button>
							<button class="btn btn-primary" data-method="rotate" data-option="-45" type="button">
								<span class="fa fa-rotate-left"></span> 45&deg;
							</button>
						</div>
						<div class="btn-group" style="padding-left: 148px;">
							<button class="btn btn-primary" data-method="rotate" data-option="90" type="button" title="右旋90度">
								<span class="fa fa-rotate-right"></span> 90&deg;
							</button>
							<button class="btn btn-primary" data-method="rotate" data-option="15" type="button">
								<span class="fa fa-rotate-right"></span> 15&deg;
							</button>
							<button class="btn btn-primary" data-method="rotate" data-option="30" type="button">
								<span class="fa fa-rotate-right"></span> 30&deg;
							</button>
							<button class="btn btn-primary" data-method="rotate" data-option="45" type="button">
								<span class="fa fa-rotate-right"></span> 45&deg;
							</button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="bjui-pageFooter" id="dialog_upload_btn_dialog">
		<ul>
			<li>
				<button type="button" class="btn-close" data-icon="close">关闭</button>
			</li>
			<li>
				<button type="submit" class="btn-green avatar-save" data-icon="upload">确定上传</button>
			</li>
		</ul>
	</div>
</div>
<!-- /.modal -->

<!-- javascript -->

<script src="/Public/BJUI/js/jquery.cookie.js"></script>
<script src="/Public/BJUI/js/bjui-all.js"></script>

<!-- plugins -->
<!-- ueditor -->
<script type="text/javascript" charset="utf-8" src="/Public/BJUI/plugins/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/BJUI/plugins/ueditor/ueditor.all.min.js"></script>
<!-- kindeditor 
<script src="/Public/BJUI/plugins/kindeditor_4.1.10/kindeditor-all-min.js"></script>
-->
<!-- ztree -->
<script src="/Public/BJUI/plugins/ztree/jquery.ztree.all-3.5.js"></script>
<!-- nice validate -->
<script src="/Public/BJUI/plugins/niceValidator/jquery.validator.js"></script>
<script src="/Public/BJUI/plugins/niceValidator/jquery.validator.themes.js"></script>
<!-- bootstrap plugins -->
<script src="/Public/BJUI/plugins/bootstrap.min.js"></script>
<script src="/Public/BJUI/plugins/bootstrapSelect/bootstrap-select.js"></script>
<script src="/Public/BJUI/plugins/bootstrapSelect/defaults-zh_CN.min.js"></script>
<script src="/Public/BJUI/plugins/treegrid/jquery.treegrid.min.js"></script>
<!-- icheck -->
<script src="/Public/BJUI/plugins/icheck/icheck.min.js"></script>
<!-- thooClock -->
<script type="text/javascript" src="/Public/js/jquery.thooClock.js"></script>
<!-- colorpicker -->
<script src="/Public/BJUI/plugins/colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- treegrid -->
<link href="/Public/BJUI/plugins/treegrid/jquery.treegrid.css" rel="stylesheet">
<script src="/Public/BJUI/plugins/treegrid/jquery.treegrid.js"></script>
<!-- init -->
<script type="text/javascript">
	{literal}
	$(function ()
	  {
		  BJUI.init({
						JSPATH: '/Public/BJUI/',         //[可选]框架路径
						PLUGINPATH: '/Public/BJUI/plugins/', //[可选]插件路径
						loginInfo: {url: 'index.php?action=Login&module=Users', title: '登录', width: 400, height: 200}, // 会话超时后弹出登录对话框
						statusCode: {ok: 200, error: 300, timeout: 301}, //[可选]
						ajaxTimeout: 50000, //[可选]全局Ajax请求超时时间(毫秒)
						pageInfo: {
							total: 'total',
							pageCurrent: 'pageNum',
							pageSize: 'numPerPage',
							orderField: '_order',
							orderDirection: '_sort'
						}, //[可选]分页参数
						alertMsg: {displayPosition: 'topcenter', displayMode: 'slide', alertTimeout: 3000}, //[可选]信息提示的显示位置，显隐方式，及[info/correct]方式时自动关闭延时(毫秒)
						keys: {statusCode: 'statusCode', message: 'message'}, //[可选]
						ui: {
							windowWidth: 0,    //框架可视宽度，0=100%宽，> 600为则居中显示
							showSlidebar: true, //[可选]左侧导航栏锁定/隐藏
							clientPaging: true, //[可选]是否在客户端响应分页及排序参数
							overwriteHomeTab: false //[可选]当打开一个未定义id的navtab时，是否可以覆盖主navtab(我的主页)
						},
						debug: false,    // [可选]调试模式 [true|false，默认false]
						{/literal}
						{if $domain eq 'admin'}
						theme: 'blue' // 若有Cookie['bjui_theme'],优先选择Cookie['bjui_theme']。皮肤[五种皮肤:default, orange, purple, blue, red, green]
						{elseif $domain eq 'vip'}
						theme: 'green' // 若有Cookie['bjui_theme'],优先选择Cookie['bjui_theme']。皮肤[五种皮肤:default, orange, purple, blue, red, green]
						{else}
						theme: 'orange' // 若有Cookie['bjui_theme'],优先选择Cookie['bjui_theme']。皮肤[五种皮肤:default, orange, purple, blue, red, green]
						{/if}

						{literal}
					});
		  BJUI.setRegional('ajaxnosend', '页面响应超时，请刷新页面，此操作不影响服务器数据！')
		  // main - menu
		  $('#bjui-accordionmenu')
			  .collapse()
			  .on('hidden.bs.collapse', function (e)
			  {
				  $(this).find('> .panel > .panel-heading').each(function ()
																 {
																	 var $heading = $(this), $a = $heading.find('> h4 > a');

																	 if ($a.hasClass('collapsed')) $heading.removeClass('active')
																 })
			  })
			  .on('shown.bs.collapse', function (e)
			  {
				  $(this).find('> .panel > .panel-heading').each(function ()
																 {
																	 var $heading = $(this), $a = $heading.find('> h4 > a');

																	 if (!$a.hasClass('collapsed')) $heading.addClass('active')
																 })
			  });

		  $(document).on('click', 'ul.menu-items > li > a', function (e)
		  {
			  var $a       = $(this), $li = $a.parent(), options = $a.data('options').toObj();
			  var onClose  = function ()
			  {
				  $li.removeClass('active')
			  };
			  var onSwitch = function ()
			  {
				  $('#bjui-accordionmenu').find('ul.menu-items > li').removeClass('switch');
				  $li.addClass('switch')
			  };

			  $li.addClass('active');
			  if (options)
			  {
				  options.url      = $a.attr('href');
				  options.onClose  = onClose;
				  options.onSwitch = onSwitch;
				  if (!options.title) options.title = $a.text();

				  if (!options.target)
					  $a.navtab(options);
				  else
					  $a.dialog(options)
			  }

			  e.preventDefault()
		  });

		  //时钟
		  var today = new Date(), time = today.getTime();
		  $('#bjui-date').html(today.formatDate('yyyy/MM/dd'));
		  setInterval(function ()
					  {
						  today = new Date(today.setSeconds(today.getSeconds() + 1));
						  $('#bjui-clock').html(today.formatDate('HH:mm:ss'))
					  }, 1000)
	  });

	//菜单-事件
	function MainMenuClick(event, treeId, treeNode)
	{
		event.preventDefault();

		if (treeNode.isParent)
		{
			var zTree = $.fn.zTree.getZTreeObj(treeId);

			zTree.expandNode(treeNode, !treeNode.open, false, true, true);
			return
		}

		if (treeNode.target && treeNode.target == 'dialog')
			$(event.target).dialog({id: treeNode.tabid, url: treeNode.url, title: treeNode.name});
		else
			$(event.target).navtab({
									   id: treeNode.tabid,
									   url: treeNode.url,
									   title: treeNode.name,
									   fresh: treeNode.fresh,
									   external: treeNode.external
								   })
	}

	//菜单展开事件
	function MainMenu_ztree_beforeexpand(treeId, treeNode)
	{
		var curExpandNode = MainMenu_ztree_GetOpendNode(treeId);
		var pNode         = curExpandNode ? curExpandNode.getParentNode() : null;
		var treeNodeP     = treeNode.parentTId ? treeNode.getParentNode() : null;
		var zTree         = $.fn.zTree.getZTreeObj(treeId);
		for (var i = 0, l = !treeNodeP ? 0 : treeNodeP.children.length; i < l; i++)
		{
			if (treeNode !== treeNodeP.children[i])
			{
				zTree.expandNode(treeNodeP.children[i], false);
			}
		}
		while (pNode)
		{
			if (pNode === treeNode)
			{
				break;
			}
			pNode = pNode.getParentNode();
		}
		if (!pNode)
		{
			MainMenu_ztree_singlePath(treeId, treeNode, curExpandNode);
		}
	}

	function MainMenu_ztree_singlePath(treeId, newNode, oldNode)
	{
		if (newNode === oldNode) return;
		var zTree = $.fn.zTree.getZTreeObj(treeId);
		var rootNodes, tmpRoot, tmpTId, i, j, n;
		if (!oldNode)
		{
			tmpRoot = newNode;
			while (tmpRoot)
			{
				tmpTId  = tmpRoot.tId;
				tmpRoot = tmpRoot.getParentNode();
			}
			rootNodes = zTree.getNodes();
			for (i = 0, j = rootNodes.length; i < j; i++)
			{
				n = rootNodes[i];
				if (n.tId != tmpTId)
				{
					zTree.expandNode(n, false);
				}
			}
		}
		else if (oldNode && oldNode.open)
		{
			if (newNode.parentTId === oldNode.parentTId)
			{
				zTree.expandNode(curExpandNode, false);
			}
			else
			{
				var newParents = [];
				while (newNode)
				{
					newNode = newNode.getParentNode();
					if (newNode === curExpandNode)
					{
						newParents = null;
						break;
					}
					else if (newNode)
					{
						newParents.push(newNode);
					}
				}
				if (newParents != null)
				{
					var oldNode    = curExpandNode;
					var oldParents = [];
					while (oldNode)
					{
						oldNode = oldNode.getParentNode();
						if (oldNode)
						{
							oldParents.push(oldNode);
						}
					}
					if (newParents.length > 0)
					{
						zTree.expandNode(oldParents[Math.abs(oldParents.length - newParents.length) - 1], false);
					}
					else
					{
						zTree.expandNode(oldParents[oldParents.length - 1], false);
					}
				}
			}
		}
	}

	function MainMenu_ztree_GetOpendNode(treeId)
	{
		var zTree = $.fn.zTree.getZTreeObj(treeId);
		var nodes = zTree.getNodes();
		$.each(nodes, function (node)
		{
			if (node.open)
				return node;
		});
		return null;
	}

	//扫描硬件处理
	window.onbeforeunload = function ()
	{
		try
		{
			if (serialPort != null)
			{
				if (serialPort.isOpen())
				{
					serialPort.close();
				}
			}
		}
		catch (e)
		{

		}
	};

	window.onunload = function ()
	{
		try
		{
			if (serialPort != null)
			{
				if (serialPort.isOpen())
				{
					serialPort.close();
				}
			}
		}
		catch (e)
		{

		}
	};

	$(document).on('bjui.beforeCloseNavtab', function (e)
	{
		try
		{
			var tabids = {};
			$('#bjui-navtab').find('.navtab-tab').find('> li').each(function ()
																	{
																		tabids[$(this).data('options').id] = "";
																	});
			for (var tabid in scancodecallback)
			{
				if (tabids[tabid] == "undefined")
				{
					scancodecallback[tabid] = null;
				}
			}
		}
		catch (e)
		{
		}
	})

	//检查日期是否正确
	function check_datepattern(obj)
	{
		var datepicker_value = $(obj).val();
		var regexp           = /^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])$/;
		if (!regexp.test(datepicker_value))
		{
			var newregexp = /^\d{4}(0?[1-9]|1[012])(0?[1-9]|[12][0-9]|3[01])$/;
			if (newregexp.test(datepicker_value))
			{
				var newvalue = datepicker_value.substring(0, 4) + "-" + datepicker_value.substring(4, 6) + "-" + datepicker_value.substring(6, 8);
				var that     = $(obj);
				setTimeout(function ()
						   {
							   that.val(newvalue);
						   }, 10);
			}
			else
			{
				var newregexp = /^\d{2}(0?[1-9]|1[012])(0?[1-9]|[12][0-9]|3[01])$/;
				if (newregexp.test(datepicker_value))
				{
					var newvalue = '20' + datepicker_value.substring(0, 2) + "-" + datepicker_value.substring(2, 4) + "-" + datepicker_value.substring(4, 6);
					var that     = $(obj);
					setTimeout(function ()
							   {
								   that.val(newvalue);
							   }, 10);
				}
				else
				{
					var that = $(obj);
					setTimeout(function ()
							   {
								   that.val("");
							   }, 10);
				}
			}
		}
	}

	function getCurrentTabid()
	{
		var tabid = "";
		$('#bjui-navtab').find('.navtab-tab').find('> li').each(function ()
																{
																	if ($(this).hasClass("active"))
																	{
																		tabid = $(this).data('options').id;
																	}
																});
		return tabid;
	}

	function setscanport(obj, port)
	{
		if (port == serial_port && serialPort != null)
		{
			return;
		}
		$("#bjui-scanport").find(">li").each(function ()
											 {
												 $(this).removeClass("active");
											 });
		$(obj).parent().addClass("active");
		try
		{
			if (serialPort != null)
			{
				if (serialPort.isOpen())
				{
					serialPort.close();
				}
			}
		}
		catch (e)
		{
		}
		serial_port = port;
		try
		{
			$("#scanmessageinfo").css("color", "blue");
			$("#scanmessageinfo").html("正在初始化硬件端口...");
			initScanPort();
		}
		catch (e)
		{
			$("#scanmessageinfo").css("color", "red");
			$("#scanmessageinfo").html("端口初始化失败...");
		}
	}

	function initScanPort()
	{
		if (serial_port != "")
		{
			var com      = require("serialport");
			var isInitOK = false;
			com.list(function (err, results)
					 {
						 results.forEach(function (port)
										 {
											 var pnpID = port.pnpId;
											 if (serial_port === port.comName && pnpID.indexOf("VID") > 0 && pnpID.indexOf("PID") > 0)
											 {
												 isInitOK = true;
											 }
										 });

						 if (!isInitOK)
						 {
							 $("#scanmessageinfo").css("color", "red");
							 $("#scanmessageinfo").html("指定端口未找到设备");
							 return;
						 }
						 serialPort = new com.SerialPort(serial_port, {
							 baudrate: 9600,
							 parser: com.parsers.readline("\r\n")
						 });

						 serialPort.on("open", function ()
						 {
							 $("#scanmessageinfo").css("color", "blue");
							 $("#scanmessageinfo").html("等待扫码");
						 });

						 serialPort.on("data", function (data)
						 {
							 var tabid = getCurrentTabid();

							 if (scancodecallback[tabid] != null)
							 {
								 if (typeof(scancodecallback[tabid]) == "function")
								 {
									 if (!isComplete)
									 {
										 $("#scanmessageinfo").css("color", "red");
										 $("#scanmessageinfo").html("等待处理返回,请稍后...");
										 return;
									 }
									 else
									 {
										 isComplete = false;
									 }
									 $("#scanmessageinfo").css("color", "red");
									 $("#scanmessageinfo").html("正在处理扫码数据,请稍后...");
									 isComplete = scancodecallback[tabid](data);
									 if (isComplete)
									 {
										 $("#scanmessageinfo").css("color", "blue");
										 $("#scanmessageinfo").html("等待扫码");
									 }
								 }
							 }
							 else
							 {
								 $("#scanmessageinfo").css("color", "blue");
								 $("#scanmessageinfo").html("等待扫码");
							 }
						 });

					 });
		}
		else
		{
			$("#scanmessageinfo").css("color", "red");
			$("#scanmessageinfo").html("端口初始化失败");
		}
	}

	{/literal}
	var serial_port      = "{$SAVESCANPORT}";
	var serialPort       = null;
	var scancodecallback = {ldelim}{rdelim};
	var isComplete       = true;

	function init_scanport()
	{ldelim}
		try
		{ldelim}
			require("serialport");
			var scancodehtml = '<li><div id="scanmessageinfo"></div></li>' +
							   '<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"> 设备端口 <span class="caret"></span></a>' +
							   '<ul class="dropdown-menu" role="scanport" id="bjui-scanport">' +
							   '<li id="1" class="{if $SAVESCANPORT eq "COM1"}active{/if}"><a href="javascript:;" onclick="setscanport(this,\'COM1\');">&nbsp; COM1 </a></li>' +
							   '<li id="2" class="{if $SAVESCANPORT eq "COM2"}active{/if}"><a href="javascript:;" onclick="setscanport(this,\'COM2\');">&nbsp; COM2 </a></li>' +
							   '<li id="3" class="{if $SAVESCANPORT eq "COM3"}active{/if}"><a href="javascript:;" onclick="setscanport(this,\'COM3\');">&nbsp; COM3 </a></li>' +
							   '<li id="4" class="{if $SAVESCANPORT eq "COM4"}active{/if}"><a href="javascript:;" onclick="setscanport(this,\'COM4\');">&nbsp; COM4 </a></li>' +
							   '<li id="5" class="{if $SAVESCANPORT eq "COM5"}active{/if}"><a href="javascript:;" onclick="setscanport(this,\'COM5\');">&nbsp; COM5 </a></li>' +
							   '<li id="6" class="{if $SAVESCANPORT eq "COM6"}active{/if}"><a href="javascript:;" onclick="setscanport(this,\'COM6\');">&nbsp; COM6 </a></li>' +
							   '</ul>' +
							   '</li>';
			$("#navbartopline").prepend(scancodehtml).initui();
			try
			{ldelim}
				$("#scanmessageinfo").css("color", "blue");
				$("#scanmessageinfo").html("正在初始化硬件端口...");
				initScanPort();
				{rdelim}
			catch (e)
			{ldelim}
				$("#scanmessageinfo").css("color", "red");
				$("#scanmessageinfo").html("端口初始化失败...");
				{rdelim}
			{rdelim}
		catch (e)
		{ldelim} console.log(e); {rdelim}
		{rdelim}

	setTimeout("init_scanport();", 1500);
</script>

<script type="text/javascript">
	var selectprinter = "{$SELECTPRINTER}";
	{literal}
	function select_printer(printname)
	{
		$.post("index.php", "module=Users&action=SelectPrinter&printname=" + printname,
			   function (data)
			   {
				   window.location = "index.php";
			   });
	}
	function init_printer()
	{
		try
		{
			var printer = require("printer");
			//console.log('default printer name: ' + (printer.getDefaultPrinterName() || 'is not defined on your computer'));
			//console.log(printer.getPrinters());
			var printcodehtml = '<li><div id="printerinfo"></div></li>' +
								'<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"> 选择打印机 <span class="caret"></span></a>' +
								'<ul class="dropdown-menu" role="scanport" id="bjui-printer">';

			$.each(printer.getPrinters(), function (key, print)
			{
				var printname = print.name;
				var printinfo = print.driverName;
				if (selectprinter == printname)
				{
					printcodehtml = printcodehtml + '<li  class="active"><a href="javascript:;" onclick="select_printer(\'' + printname + '\');">&nbsp; ' + printname + ' </a></li>';
				}
				else
				{
					printcodehtml = printcodehtml + '<li><a href="javascript:;" onclick="select_printer(\'' + printname + '\');">&nbsp; ' + printname + ' </a></li>';
				}
				// console.log("___"+printname+"______________"+printinfo+"___________");
			});
			printcodehtml = printcodehtml + '</ul></li>';
			$("#navbartopline").prepend(printcodehtml).initui();

		}
		catch (e)
		{
			console.log(e);
			selectprinter = "";
		}
	}

	setTimeout("init_printer();", 1500);

	{/literal}
</script>

<script type="text/javascript">

	/*
	{if $APPROVALDIALOG eq 'true'}
	 function approve_dialog()
	 {ldelim}
	 $(this).dialog({ldelim}id:'ApproveDialog', url:'index.php?module=Approvals&action=ApproveDialog', title:'快捷审批',width:700,height:500,mask:true,resizable:false,drawable:false,maxable:false{rdelim});
	{rdelim}
	 setTimeout("approve_dialog();",1000);
	{/if}
	 */
	{if $SUPPLIERWARN eq 'true'}
	function warn_dialog()
	{ldelim}
		var url = "index.php?module=Ma_CheckWarns&action=warndialog";
		$.post(url, "", function (data)
		{ldelim}
			if (data != "")
			{ldelim}
				$(this).alertmsg('warn', data, {
					ldelim}displayMode: 'slide',
					displayPosition: 'bottomright',
					okName: false,
					cancelName: false,
					title: '资质预警',
					autoClose: true,
					alertTimeout: 8000,
					mask: false{rdelim});
				{rdelim}
			{rdelim})
		//$(this).dialog({ldelim}id:'WarnDialog', url:url, title:'资质预警',width:700,height:500,mask:true,resizable:false,drawable:false,maxable:false{rdelim});

		{rdelim}
	setTimeout("warn_dialog();", 1000);
	{/if}
</script>

<script src="/Public/js/baidu.js" type="text/javascript"></script>
<div class="upload_loading" aria-label="Loading" role="img" tabindex="-1" style="display:none;"></div>
</body>
</html>
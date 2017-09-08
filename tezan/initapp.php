<?php
	/**
	 * Created by PhpStorm.
	 * User: clubs
	 * Date: 2017/6/15
	 * Time: 下午11:29
	 */

	if(isset($_REQUEST["action"]) && $_REQUEST["action"] == "getlongtimestatus"){
		try
		{
			echo XN_MemCache::get("get_longtime_status_Wait_Init_App");
		}
		catch (XN_Exception $e)
		{
			echo '{"statusCode":300,"message":"获取状态失败！","status":"complete"}';
		}
		die();
	}

	echo '
		<!DOCTYPE html>
		<html lang="zh">
		<head>
			<meta charset="utf-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<title>初始化所有数据结构</title>
			<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
			<link href="/Public/BJUI/themes/css/bootstrap.css" rel="stylesheet">
			<link href="/Public/BJUI/themes/css/style.css" rel="stylesheet">
			<link href="/Public/BJUI/themes/blue/core.css" id="bjui-link-theme" rel="stylesheet">
			<link rel="stylesheet" href="/Public/css/waitbar.css">
			<link href="/Public/BJUI/themes/css/FA/css/font-awesome.min.css" rel="stylesheet">
			<script language="JavaScript" type="text/javascript" src="/Public/js/waitbar.js"></script>
			<script language="JavaScript" src="/Public/js/jquery-1.11.3.min.js"></script>
			<script language="JavaScript" src="/Public/BJUI/js/jquery.cookie.js"></script>
			<script language="JavaScript" src="/Public/BJUI/js/bjui-all.js"></script>
		</head>
		<body>
		</body>
		<script>
			$(function (){
				BJUI.init();
			})
			
			window.onload = function(){
				var waitbar = WaitBarClass.init();
				waitbar.statusurl = "initapp.php?action=getlongtimestatus";
				waitbar.progress = 1;
				waitbar.delay = 1000;
				waitbar.callback  = function (json)
				{
					$(this).bjuiajax("ajaxDone", json);
				}
				waitbar.start();
			}
		
		</script>
		</html>
	';

	ignore_user_abort(true);
	if(function_exists('fastcgi_finish_request')) {
		fastcgi_finish_request();
	} else {
		header('X-Accel-Buffering: no');
		header('Content-Length: '. strlen(ob_get_contents()));
		header("Connection: close");
		header("HTTP/1.1 200 OK");
		ob_end_flush();
		flush();
	}

	XN_MemCache::put('{"statusCode":200,"message":"正在处理数据，请稍候。。。！"}',"get_longtime_status_Wait_Init_App");



	ini_set('memory_limit','2048M');
	set_time_limit(0);
	header('Content-Type: text/html; charset=utf-8');
	session_start();

	require ($_SERVER['DOCUMENT_ROOT'].'/admin/initapp.php');
	
	
	$session = array();
	$session['run_initapp'] = "true";
	
	XN_MemCache::put($session,"session_".XN_Application::$CURRENT_URL);
	
	if (isset($_REQUEST['a']) && $_REQUEST['a'] == "init"  )
	{
		XN_MemCache::put('{"statusCode":200,"progress":"1}',"get_longtime_status_Wait_Init_App");

		re_initdata();

		XN_MemCache::delete("session_".XN_Application::$CURRENT_URL); 

	}
	XN_MemCache::put('{"statusCode":200,"message":"完成！","status":"complete"}',"get_longtime_status_Wait_Init_App","120");

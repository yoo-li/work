<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>帮助文档</title>
<link href="./zTree/style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="./zTree/zTreeStyle.css" type="text/css">
<script type="text/javascript" src="./zTree/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="./zTree/jquery.ztree.core-3.5.js"></script>

<script type="text/javascript">
        function QueryLink(linkid,helplabel) 
		{ 			
			var url = "linkid="+linkid;			
			jQuery.post("./showhelp.php", url,
			function (data, textStatus)
			{
					$("#helplabel").html(helplabel);
					$("#textIframe",parent.document.body).attr("src",data);

			});	
		}
		 function KeyScan() 
		{ 			
			var key = jQuery("#TextBox_key").val();
			var url = "key="+key;			
			jQuery.post("./keyscan.php", url,
			function (data, textStatus)
			{
					$("#Lab").html(data);
			});	
		}
		function CloseDialog(obj)
		{
			jQuery("#"+obj).css("display","none");
			jQuery("#"+obj).css("visibility","hidden");
		}
		function ShowDialog(obj)
		{
			jQuery("#"+obj).css("display","");
			jQuery("#"+obj).css("visibility","visible");
		}
</script> 
<SCRIPT type="text/javascript">
		var setting = {
			data: {
				simpleData: {
					enable: true
				}
			},
			callback: {
				onClick: onClick
			}
		};
		var zNodes =[
			{ id:1, pId:0, name:"==帮助中心==", open:true, iconOpen:"./images/help1.gif", iconClose:"./images/help1.gif",click:false},
			<?php
								require_once('menudata.php');
								foreach($helpmenu as  $menu)								
								{
									$childlinkid = $menu['linkid'];
									if (isset($menu['file']) && is_array($menu['file']))
									{
										echo '{ id:'.$menu['linkid'].', pId:1, name:"'.$menu['name'].'",  iconOpen:"./images/help_open.gif", iconClose:"./images/help_close.gif",click:false},'."\n";
										foreach($menu['file'] as  $childmenu)								
										{					
											$lastlinkid = $childmenu['linkid'];
											if (isset($childmenu['file']) && is_array($childmenu['file']))
											{
												echo '{ id:'.$childmenu['linkid'].', pId:'.$childlinkid.', name:"'.$childmenu['name'].'",  iconOpen:"./images/help_open.gif", iconClose:"./images/help_close.gif",click:false},'."\n";
												foreach($childmenu['file'] as  $lastmenu)								
												{					
													echo '{ id:'.$lastmenu['linkid'].', pId:'.$lastlinkid.', name:"'.$lastmenu['name'].'",  icon:"./images/help2.gif"},'."\n";
												}
											}
											else
											{
												echo '{ id:'.$childmenu['linkid'].', pId:'.$childlinkid.', name:"'.$childmenu['name'].'",  icon:"./images/help2.gif"},'."\n";
											}
										}
									}
									else
									{
										echo '{ id:'.$menu['linkid'].', pId:1, name:"'.$menu['name'].'",  icon:"./images/help2.gif"},'."\n";
									}
								}
			?>			
		];
		function onClick(event, treeId, treeNode, clickFlag) 
		{
			if (treeNode.click == false)
			{
				return;
			}
			QueryLink(treeNode.id,treeNode.name); 
		}	

		$(document).ready(function(){
			$.fn.zTree.init($("#treeDemo"), setting, zNodes);
		});
	</SCRIPT>

<style type="text/css"> 
.kuanghelp {border-top-width: 1px;border-right-width: 1px;border-bottom-width: 1px;border-left-width: 1px;	border-top-style: solid;border-right-style: solid;border-bottom-style: solid;border-left-style: solid;
	border-top-color: #74AED6;	border-right-color: #74AED6;border-bottom-color: #74AED6;border-left-color: #74AED6;}
.kuang2help {border: 1px solid #CDCDCD;background-color: #F9F9F9;text-align: left;left: 5px;top: 5px;right: 5px;bottom: 5px;font-size: 12px;line-height: 22px;color: #4b4b4b;padding-top: 5px;padding-right: 10px;padding-bottom: 5px;	padding-left: 10px;}
.font1help {	font-size: 12px;	line-height: 22px;	color: #46749F;font-weight: bold;}
.font1helplink:link {	font-size: 12px;	line-height: 22px;color: #46749F;text-decoration: none;font-weight: bold;}
.font1helplink:visited {font-size: 12px;color: #46749F;text-decoration: none;line-height: 22px;font-weight: bold;}
.font1helplink:hover {font-size: 12px;line-height: 21px;color: #FF3300;text-decoration: none;font-weight: bold;}
.font2 {font-size: 12px;line-height: 20px;color: #414141;}
</style>
<meta http-equiv="Page-Exit" content="progid:DXImageTransform.Microsoft.Fade(duration=0.1)"></head>
<body>
    <div style="height:100%;width:100%;">
    <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%"><tbody><tr>
    <td style="margin-right:5px; border-right:solid 1px #000000;" valign="top" width="265px">
        <table cellpadding="0" cellspacing="0" width="100%">
            <tbody><tr>
                <td style="background-image:url('images/helptopbj.gif');width:100%"><img src="images/helptop.gif"></td>
            </tr>
            <tr>
                <td style="background-color:#CDEAF4;height:30px">
                    <div style="padding-left:5px">
                        <table width="100%">
                            <tbody><tr>
                                <td style="text-align:left">
                                    <a onclick="CloseDialog('div_suoyin');ShowDialog('div_tree');CloseDialog('div_query');CloseDialog('div_gd');">目录</a>&nbsp;|&nbsp;
                                    <a onclick="ShowDialog('div_suoyin');CloseDialog('div_tree');CloseDialog('div_query');CloseDialog('div_gd');">索引</a>&nbsp;|&nbsp;
                                    <a onclick="CloseDialog('div_suoyin');CloseDialog('div_tree');ShowDialog('div_query');CloseDialog('div_gd');">搜索</a>
                                </td>
                                <td style="text-align:right">&nbsp;&nbsp;</td>
                            </tr>
                        </tbody></table>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="background-color:#ECF7FB;">
                    <div id="div_tree" style="padding-left:1px">
							<div class="TreeView" style="height: 98.5%; width: 99%; overflow: auto;" >
									<div class="zTreeDemoBackground left">
										<ul id="treeDemo" class="ztree"></ul>
									</div>
							</div>
                    </div>
                    <div id="div_suoyin" style="padding-left: 5px; display: none; visibility: hidden;">
                        <span id="Labe_suoyin">
							<?php
								require_once('menudata.php');
								foreach($links as $word => $menulinks)
								{
									echo '<br><span style="font-size:16px;font-weight: bold;">-&nbsp;'.$word.'&nbsp;-</span><br><br>';
									foreach($menulinks as $linkid => $menulink)
									{
										echo '<a onclick="QueryLink(\''.$linkid.'\',\''.$menulink['name'].'\')">'.$menulink['name'].'</a><br>';
									}
								}
							?>
						</span>
                    </div>
                    <div id="div_query" style="padding-left: 5px; display: none; visibility: hidden;"> 
                        请输入要搜索的关键字:
                        <br>
                        <input name="TextBox_key" id="TextBox_key" style="width:150px;" type="text">
                        <input name="Button_query" value="搜索" id="Button_query" class="btn" type="submit" onclick="KeyScan();"><br><br>                       
                        <span id="Lab">
						   <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>   
						</span>
                        <br><br>
            </div>
                </td>
            </tr>
        </tbody></table>
        
    </td>
    <td style="width:1px">&nbsp;</td>
    <td valign="top">
		<div style="height:5px;"></div>
		<span id="Lab_coutent" >
						<table width="100%" cellspacing="0" cellpadding="0" border="0" class="kuanghelp">
							<tbody>
								<tr>
									<td>
									<table width="100%" cellspacing="0" cellpadding="0" border="0">
										<tbody>
											<tr>
												<td width="97%" valign="bottom" background="images/helpn-1bj.jpg">
												<table width="100%" cellspacing="0" cellpadding="0" border="0">
													<tbody>
														<tr>
															<td height="25">&nbsp;</td>
														</tr>
														<tr>
															<td height="30">
															<table width="100%" cellspacing="0" cellpadding="0" border="0">
																<tbody>
																	<tr>
																		<td width="5%" align="center"><img src="images/helpdot-1.gif" alt=""></td>
																		<td width="95%" align="left" class="font15"><span class="font15help">帮助中心</span> <span class="font14help">&gt; <span id="helplabel"></span></span></td>
																	</tr>
																</tbody>
															</table>
															</td>
														</tr>
													</tbody>
												</table>
												</td>
												<td width="1%" valign="top" align="right"><img src="images/helpn-1.jpg" alt=""></td>
											</tr>
										</tbody>
									</table>
									</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td align="center">
										<div style="margin:10px;">
										<iframe id="textIframe" name="textIframe" src="" border="0" marginheight="0" marginwidth="0" onload="this.height=700" frameborder="0" height="721" width="100%"></iframe>										
										</div>
									</td>
								</tr>
							</tbody>
						</table>
		</span>
    </td>
	<td style="width:1px">&nbsp;</td>
	</tr>
	</tbody>
	</table>
    </div>    
    
<script language="JavaScript">QueryLink("0","软件初次使用向导");</script></form>

</body></html>
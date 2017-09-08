<?php
	

$wxid = $_REQUEST['wxid'];
		
$wxmenus = XN_Query::create ( 'Content' )->tag('wxmenus')
						->filter ( 'type', 'eic', 'wxmenus') 
						->filter ( 'my.record', '=', $wxid)
						->filter ( 'my.parentid', '=', "0")
						->order("my.sequence",XN_Order::ASC_NUMBER)
						->end(-1)
						->execute ();

$categoryArr = array();
foreach($wxmenus as $wxmenu_info)
{
	$id = $wxmenu_info->id;
	$wxchildmenus = XN_Query::create ( 'Content' )->tag('wxmenus')
							->filter ( 'type', 'eic', 'wxmenus') 
							->filter ( 'my.record', '=', $_REQUEST['wxid'])
							->filter ( 'my.parentid', '=', $id)
							->order("my.sequence",XN_Order::ASC_NUMBER)
							->end(-1)
							->execute ();
	if (count($wxchildmenus) > 0)
	{
		$childcategoryArr = array();
		foreach($wxchildmenus as $childwxmenu_info)
		{
			if ($childwxmenu_info->my->type == "view")
			{
		   	 	$childcategoryArr[] = array( 'name' => urlencode($childwxmenu_info->my->name), 
		   							    'type' => $childwxmenu_info->my->type,
									     'url' => urlencode($childwxmenu_info->my->key),);
			}
			else if ($childwxmenu_info->my->type == "click")
			{
			 	$childcategoryArr[] = array( 'name' => urlencode($childwxmenu_info->my->name), 
									    'type' => $childwxmenu_info->my->type,
									    'key' => urlencode($childwxmenu_info->my->key),);
			 }
		}
   	 	$categoryArr[] = array( 'name' => urlencode($wxmenu_info->my->name), 
   							    'sub_button' => $childcategoryArr, );
	}
	else
	{
		if ($wxmenu_info->my->type == "view")
		{
	   	 	$categoryArr[] = array( 'name' => urlencode($wxmenu_info->my->name), 
	   							    'type' => $wxmenu_info->my->type,
								     'url' => urlencode($wxmenu_info->my->key),);
		}
		else if ($wxmenu_info->my->type == "click")
		{
		 	$categoryArr[] = array( 'name' => urlencode($wxmenu_info->my->name), 
								    'type' => $wxmenu_info->my->type,
								    'key' => urlencode($wxmenu_info->my->key),);
		 }
	 }

}	
 
    $menujson = json_encode(array("button"=>$categoryArr));
 
	
	require_once('XN/Wx.php');
	
	$wx = XN_Content::load($wxid,'WxSettings');
	$wxname = $wx->my->wxname;
	$appid = $wx->my->appid;
	$secret = $wx->my->secret;
	XN_WX::$APPID = $appid;
	XN_WX::$SECRET = $secret; 
	
	//echo urldecode($menujson);
	$msg = XN_WX::synchromenus(urldecode($menujson));
	//$msg = urldecode($menujson);
	
	if(	$msg == "ok")
	{ 
		$msg = "同步成功!!!";
	} 
	
	
global $currentModule;
$msg = '<style>div{line-height:160%;}</style>  
<center>
<br>
<div style="width:100%;padding:0px;">
<div style="font-size:10pt;">
<br>'.$msg.'
<br><br><br></div>
</div>
</center>
<script type="text/javascript" defer="defer">
function closemessagebox()
{
	BJUI.dialog("closeCurrent");
    $(this).navtab(\'refresh\',\'edit\');
}
setTimeout("closemessagebox();",5000);
</script>
';

 echo $msg;
?>
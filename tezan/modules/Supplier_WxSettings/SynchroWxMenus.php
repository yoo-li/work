<?php
require_once('XN/Wx.php');

$wxid = $_REQUEST['wxid'];
$wx = XN_Content::load($wxid,'Supplier_WxSettings');
$wxname = $wx->my->wxname;
$appid = $wx->my->appid;
$secret = $wx->my->secret;
XN_WX::$APPID = $appid;
XN_WX::$SECRET = $secret;
//可创建个性化菜单|lihongfei|2017-7-13
//普通会员菜单,没有matchrule规则

$wxmenus = XN_Query::create ( 'Content' )->tag('wxmenus')
						->filter ( 'type', 'eic', 'wxmenus')
						->filter ( 'my.record', '=', $wxid)
						->filter ( 'my.parentid', '=', "0")
						->filter ('my.tag_id','=','all')
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
							->filter ('my.tag_id','=','all')
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
			else if ($childwxmenu_info->my->type == "scancode_push")
			{
				$childcategoryArr[] = array( 'name' => urlencode($childwxmenu_info->my->name),
					'type' => $childwxmenu_info->my->type,
					'key' => urlencode($childwxmenu_info->my->key),
					);
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
		else if ($wxmenu_info->my->type == "scancode_push")
		{
			$categoryArr[] = array( 'name' => urlencode($wxmenu_info->my->name),
				'type' => $wxmenu_info->my->type,
				'key' => urlencode($wxmenu_info->my->key),
				);
		}
	 }

}
$menujson = json_encode(array("button"=>$categoryArr));
$msg = XN_WX::synchromenus();
$msg = XN_WX::synchromenus(urldecode($menujson));


//自定义菜单按tag_id分组创建
$count_tag_wxmenus = XN_Query::create ( 'Content_Count' )
	->tag('wxmenus')
	->filter ( 'type', 'eic', 'wxmenus')
	->filter ( 'my.record', '=', $wxid)
	->filter ('my.tag_id','!=','all')
	->group('my.tag_id')
	->rollup()
	->execute ();
if(count($count_tag_wxmenus)){
	$categoryArr = array();
	foreach($count_tag_wxmenus as $wxtag_info){
		$tag_type=$wxtag_info->my->tag_id;
		$wxmenus = XN_Query::create ( 'Content' )->tag('supplier_wxtags')
			->filter ( 'type', 'eic', 'supplier_wxtags')
			->filter('my.supplierid','=',$supplierid)
			->filter('my.tag_type',"=",$tag_type)
			->filter('my.tag_id','>','0')
			->filter('my.deleted','=','0')
			->end(1)
			->execute ();
		if(count($wxmenus)){
			$tag_id=$wxmenus[0]->my->tag_id;
		}
		else{
			$tag_id=0;
		}

		$wxmenus = XN_Query::create ( 'Content' )->tag('wxmenus')
			->filter ( 'type', 'eic', 'wxmenus')
			->filter ( 'my.record', '=', $wxid)
			->filter ( 'my.parentid', '=', "0")
			->filter (XN_Filter::any(XN_Filter('my.tag_id','=','all'),XN_Filter('my.tag_id','=',$tag_type)))
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
				->filter (XN_Filter::any(XN_Filter('my.tag_id','=','all'),XN_Filter('my.tag_id','=',$tag_type)))
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
					else if ($childwxmenu_info->my->type == "scancode_push")
					{
						$childcategoryArr[] = array( 'name' => urlencode($childwxmenu_info->my->name),
							'type' => $childwxmenu_info->my->type,
							'key' => urlencode($childwxmenu_info->my->key),
							);
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
				else if ($wxmenu_info->my->type == "scancode_push")
				{
					$categoryArr[] = array( 'name' => urlencode($wxmenu_info->my->name),
						'type' => $wxmenu_info->my->type,
						'key' => urlencode($wxmenu_info->my->key),
						);
				}
			}
		}
		$matchrule=array('tag_id'=>$tag_id);
		$menujson = json_encode(array("button"=>$categoryArr,'matchrule'=>$matchrule));
		$msg = XN_WX::synchro_condition_menus();//删除旧菜单
		$msg = XN_WX::synchro_condition_menus(urldecode($menujson));
	}
}

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

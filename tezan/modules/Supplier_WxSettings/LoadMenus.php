<?php


$wxmenus = XN_Query::create ( 'Content' )->tag('wxmenus')
						->filter ( 'type', 'eic', 'wxmenus') 
						->filter ( 'my.record', '=', $_REQUEST['wxid'])
						->order("my.sequence",XN_Order::ASC_NUMBER)
						->end(-1)
						->execute ();
$categoryArr = array();
foreach($wxmenus as $wxmenu_info)
{
	 $sequence = $wxmenu_info->my->sequence;
	 $categoryArr[] = array('id' => $wxmenu_info->id,
								'pId' => $wxmenu_info->my->parentid,
								'isParent'=>(($wxmenu_info->my->parentid=="0")?true:false),
								'name' => $wxmenu_info->my->name,
								't'=> '',
								'open' => true,
								'sequence' => $wxmenu_info->my->sequence,
								'type' => $wxmenu_info->my->type,
								'key' => $wxmenu_info->my->key
								);

}



echo json_encode($categoryArr);

?>
<?php
$Invent = array();
if(isset($_REQUEST['pid']) && $_REQUEST['pid'] !=''){
	$query = XN_Query::create('Content')->tag('mall_inventorys')
		->filter('type','eic','mall_inventorys')
		->filter ('my.products','=',$_REQUEST['pid'])
		->begin(0)->end(-1);
	if(isset($_REQUEST['ptype']) && $_REQUEST['ptype'] !='')
		$query->filter('my.propertytype','=',$_REQUEST['ptype']);
	$details = $query->execute();
	if(count($details)>1){
		foreach($details as $info){
			$Invent["property"] = array('type'=>$info->my->propertytype,'price'=>$info->my->price,'inventory'=>$info->my->inventory);
		}
	}elseif(count($details)>0){
		foreach($details as $info){
			$Invent["price"] = array('price'=>$info->my->price,'inventory'=>$info->my->inventory);
		}
	}
}
echo json_encode($Invent);
?>
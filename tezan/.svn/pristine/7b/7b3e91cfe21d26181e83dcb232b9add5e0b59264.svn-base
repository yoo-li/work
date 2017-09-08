<?php
function insert_charset_header()
{
 	header('Content-Type: text/html; charset=UTF-8');
}
 	
insert_charset_header();
if(isset($_REQUEST['action'])){
	$parentid = $_REQUEST['action'];
	if(isset($_REQUEST['module'])){
		if($_REQUEST['module'] === 'getarea'){
			$query = XN_Query::create ( 'SimpleContent' ) ->tag('Picklists')
				->filter ( 'type', 'eic', 'picklists')
				->filter ( 'my.parentid', '=', $parentid)
				->filter ( 'my.type', 'eic', 'area')
				->order ('id',XN_Order::ASC_NUMBER)
				->execute();
			$arr = '';
			foreach($query as $info){
				$arr = $arr.'<option value='.$info->id.'>'.$info->my->name.'</option>';
			}
			if($arr == '')
				$arr = '<option value="" style="color: #777777" disabled>-- 无 --</option>';
			else
				$arr = '<option value="">-- 无 --</option>'.$arr;
		}
		if($_REQUEST['module'] === 'getzip'){
			$querybyid = XN_Content::load($parentid,'Picklists');
			$arr = $querybyid->my->zipcode;
		}
	}
}

if(isset($_REQUEST['value']) && isset($_REQUEST['parent'])) {
	$parent = $_REQUEST['parent'];
	switch($parent) {
		case 'country':
			$type = 'province';
			break;
		case 'province':
			$type = 'city';
			break;
		case 'city':
			$type = 'district';
			break;
	}
	$info = XN_Query::create('SimpleContent')->tag('picklists')
		->filter('type','eic','picklists')
		->filter('my.type','eic','area')
		->filter('my.parent','eic',$parent)
		->filter('my.parentnode','eic',$_REQUEST['value'])
		->order('my.sequence',XN_Order::ASC_NUMBER)
		->execute();
	$i = 0;
	$result['options'] = array();
	foreach($info as $area_info) {
		if ($i == 0)
			$result['selected'] = $area_info->my->$type;
		$arr .= '<option value="'.$area_info->my->$type.'">'.$area_info->my->$type.'</option>';
		$result['options'][] = $area_info->my->$type;
		$i++;
	}
}

$arr = '<option value="" >-- 无 --</option>'.$arr;
$zipcode = '';
if($parent != 'country') {
	$picklistname = 'my.'.$parent;
	$info = XN_Query::create('SimpleContent')->tag('Picklists')
		->filter('type','eic','picklists')
		->filter('my.type','eic','area')
		->filter($picklistname,'eic',$_REQUEST['value'])
		->execute();
	$zipcode = $info[0]->my->zipcode;
}
//$result = "&#&#&#$zipcode&#&#&#$arr";
$result['zipcode'] = $zipcode;
echo json_encode($result);
?>
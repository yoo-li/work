<?php
	global $supplierid;
	$readonly = false;
	if(isset($_REQUEST["readonly"]) && $_REQUEST["readonly"] == "true"){
		$readonly = true;
	}
	if(isset($_REQUEST["record"]) && $_REQUEST["record"]){
		try{
			$access = XN_Content::load($_REQUEST["record"],"",false);
			$appaccess = $access->my->appaccess;
		}catch(XN_Exception $e){}
	}
	$modules = XN_Query::create("Content")->tag("supplier_modules")
		->filter("type", "=", "supplier_modules")
		->filter("my.supplierid", "=", $supplierid)
		->filter("my.deleted", "=", "0")
		->end(-1)
		->execute();
	$html = '<table class="table table-bordered nowrap" style="border-width:0">';
	$index = 1;
	foreach($modules as $item){
		if($index % 5 == 0)
		{
			if ($index == 1){
				$html .= '<tr>';
			}else{
				$html .= '</tr><tr>';
			}
		}
		$html .= '<td><input type="checkbox" '.($readonly?'disabled':'').' '.(in_array($item->id,$appaccess)?'checked':'').' data-toggle="icheck" data-label='.$item->my->modulename.' value="'.$item->id.'" id="'.$item->id.'" name="appaccess[]" ></td>';
		$index ++;
	}
	$html .= '</table>';
	echo $html;
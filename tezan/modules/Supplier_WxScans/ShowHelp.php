<?php
	


$wxchannels = XN_Query::create('Content_Count')
		->tag('wxchannels')
		->filter('type','eic','wxchannels')
		->filter('my.deleted','=','0')
		->filter('author','=',XN_Profile::$VIEWER) 						
		->rollup() 
		->begin(0)
		->end(-1);
$wxchannels->execute();
		
$count = $wxchannels->getTotalCount();

$display = '<div class="form-group">
                <label class="control-label x120">注意事项:</label>
				<div style="line-height: 21px;">您已经创建了'.$count.'个推广二维码，还可以创建'.(100-$count).'个</div>
            </div>'; 

echo $display;


?>
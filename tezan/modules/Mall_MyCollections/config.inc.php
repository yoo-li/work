<?php$Create = false;$Delete = false;$MassEdit = false;$CustomMassDelete = true;$actionmapping = array ( array('actionname' => 'CollectKeywords','securitycheck' => '1','type'=>'listview','func'=>'check_CollectKeywords'),);if(!function_exists('check_CollectKeywords')){	function check_CollectKeywords(){		global $currentModule;		return '			<a data-id="edit" class="btn btn-default" data-icon="line-chart" data-toggle="navtab" data-title="收藏统计" href="index.php?module='.$currentModule.'&action=CollectKeywords"><span>收藏统计</span></a>';	}}?>
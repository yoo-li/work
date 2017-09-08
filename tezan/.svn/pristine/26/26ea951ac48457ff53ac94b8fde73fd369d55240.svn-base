<?php
 

if(isset($_REQUEST['record']) && $_REQUEST['record'] != "" &&
   isset($_REQUEST['authorizedimensionid']) && $_REQUEST['authorizedimensionid'] != "")
{
	$record = $_REQUEST['record'];
	$authorizedimensionid = $_REQUEST['authorizedimensionid']; 
	
	$tags = "mall_officialauthorizeevents_details,mall_officialauthorizeevents_details_".$supplierid;
	
    $mall_officialauthorizeevents_details =XN_Query::create("Content")->tag("mall_officialauthorizeevents_details")
        ->filter("type","eic","mall_officialauthorizeevents_details")
        ->filter("my.record","=",$record)
        ->filter("my.deleted","=","0") 
        ->end(-1)->execute(); 
	
	if (count($mall_officialauthorizeevents_details) > 0)
	{
		XN_Content::delete($mall_officialauthorizeevents_details,$tags);
	}
	
    $mall_officialauthorizedimensions_details = XN_Query::create("Content")->tag("mall_officialauthorizedimensions_details")
        ->filter("type","eic","mall_officialauthorizedimensions_details")
        ->filter("my.record","=",$authorizedimensionid)
        ->filter("my.deleted","=","0")
        ->order('published',XN_Order::ASC) 
        ->end(-1)
		->execute(); 
	
	foreach($mall_officialauthorizedimensions_details as $mall_officialauthorizedimensions_detail_info)
	{
        $warehouselocationsproduct=XN_Content::create("mall_officialauthorizeevents_details","",false);
		$warehouselocationsproduct->my->supplierid=$mall_officialauthorizedimensions_detail_info->my->supplierid;
        $warehouselocationsproduct->my->record=$record;
        $warehouselocationsproduct->my->dimensiontypename=$mall_officialauthorizedimensions_detail_info->my->dimensiontypename;
        $warehouselocationsproduct->my->dimensionvalue=$mall_officialauthorizedimensions_detail_info->my->dimensionvalue;
        $warehouselocationsproduct->my->comparisonoperator=$mall_officialauthorizedimensions_detail_info->my->comparisonoperator; 
        $warehouselocationsproduct->my->memo=$mall_officialauthorizedimensions_detail_info->my->memo; 
        $warehouselocationsproduct->my->deleted='0'; 
		$warehouselocationsproduct->save($tags);  
	}
	
}


?>
<?php

require_once ('include/utils/utils.php');

global $log, $mod_strings, $app_strings, $theme, $currentModule, $current_user;


if(isset($_REQUEST['record']) && $_REQUEST['record'] !='' && isset($_REQUEST['formodule']) && $_REQUEST['formodule'] !='') 
{
	$formodule = $_REQUEST ['formodule'];
	$record = $_REQUEST ['record'];
	
	$tabid = getTabid($formodule);
	  
	global $copyrights,$supplierid; 
	if(isset($_SESSION['supplierid']) && $_SESSION['supplierid'] !='')
	{ 
		$supplierid = $_SESSION['supplierid']; 
	} 
 
	if (isset($copyrights['customapproval']) && $copyrights['customapproval'] != "" &&
		isset($supplierid) && $supplierid != "")
	{
		 $customapproval = $copyrights['customapproval'];
         $customapprovals = XN_Query::create("Content")->tag($customapproval)
                                     ->filter("type", "eic", $customapproval)
                                     ->filter("my.deleted", "=", "0")
                                     ->filter("my.supplierid", "=", $supplierid)
                                     ->filter("my.customapprovalflowtabid", "=", $tabid)
                                     ->filter("my.approvalflowsstatus", "=", '1')
                                     ->end(1)
                                     ->execute();

	    if (count($customapprovals) > 0)
		{
			 sendapproval($record,$formodule,"back",$customapproval);
		}
		else
		{
			 sendapproval($record,$formodule,"back");
		}
	}
	else
	{
		 sendapproval($record,$formodule,"back");
	}
}
if(isset($_REQUEST['ids']) && $_REQUEST['ids'] !='' && isset($_REQUEST['formodule']) && $_REQUEST['formodule'] !='')
{
	$formodule = $_REQUEST ['formodule'];
	$records=$_REQUEST['ids'];
	$records=str_replace(";",",",$records);
	$records=explode(",",$records);
	$query=XN_Query::create("Content_Count")
		->tag(strtolower($formodule))
		->filter("type","eic",strtolower($formodule))
		->filter("id","in",$records)
		->filter('author',"=",XN_Profile::$VIEWER)
		->rollup();
	$query->execute();
	$total_count=$query->getTotalCount();
	if(count($records)>$total_count){
		echo '{"statusCode":"300","message":"只能提交审批自己创建的记录！"}';
		die;
	}
	$query1=XN_Query::create("Content_Count")
		->tag(strtolower($formodule))
		->filter("type","eic",strtolower($formodule))
		->filter("id","in",$records)
		->filter(XN_Filter::any(XN_Filter('my.'.strtolower($formodule)."status","in",array("Saved","Disagree")),XN_Filter('my.'.strtolower($formodule)."status","=",""),XN_Filter('my.'.strtolower($formodule)."status","=",null)))
		->rollup();
	$query1->execute();
	$total_count1=$query1->getTotalCount();
	if(count($records)>$total_count1){
		echo '{"statusCode":"300","message":"只能提交审批未送审或审批不同意的记录！"}';
		die;
	}
	masssendapproval($records,$formodule);
	echo '{"statusCode":200,"message":"提交成功","tabid":"'.$formodule.'"}';
	die();
}
if(isset($_REQUEST['from']) && $_REQUEST['from'] =='listview' && isset($_REQUEST['formodule']) && $_REQUEST['formodule'] !='')
{
	$formodule = $_REQUEST['formodule'];
	echo '{"statusCode":200,"message":"提交成功","tabid":"'.$formodule.'","closeCurrent":"true","forward":null}';
}
else
{
	
	if(isset($_REQUEST['formodule']) && $_REQUEST['formodule'] !='' && isset($_REQUEST['record']) && $_REQUEST['record'] !='')
	{
		$formodule = $_REQUEST['formodule'];
		$record = $_REQUEST['record'];
		echo '{"statusCode":200,"message":null,"tabid":null,"closeCurrent":"true","reload":"/index.php?module='.$formodule.'&action=EditView&record='.$record.'"}';
	}
	else
	{
		echo '{"statusCode":200,"message":"提交成功","tabid":"edit","closeCurrent":"true","forward":null}';
	}

} 
die();
?>
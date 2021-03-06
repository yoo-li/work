 <?php
 
session_start(); 

require_once (dirname(__FILE__) . "/../include/config.inc.php");
require_once (dirname(__FILE__) . "/../include/config.common.php");
require_once (dirname(__FILE__) . "/../include/utils.php");
require_once (dirname(__FILE__) . "/../approval/utils.php"); 

if(isset($_SESSION['supplierid']) && $_SESSION['supplierid'] !='' &&
	isset($_SESSION['profileid']) && $_SESSION['profileid'] !='' )
{
	$supplierid =  $_SESSION["supplierid"]; 
	$profileid = $_SESSION["profileid"];
}
else
{    
	messagebox("错误", '检测不到必需的请求参数！');
	die();
} 

if(isset($_REQUEST['record']) && $_REQUEST['record'] !='' && $_REQUEST['type'] == 'delete')
{
	$record = $_REQUEST['record'];  
	try{   
		$loadcontent = XN_Content::load($record,'mall_officialauthorizeevents_'.$supplierid); 
		$loadcontent->my->deleted = '1';
		$loadcontent->save('mall_officialauthorizeevents,mall_officialauthorizeevents_'.$supplierid);  
		
		$officialopinions = XN_Query::create ( 'Content' )->tag ( 'mall_officialauthorizeevents_details_'.$supplierid )
			->filter ( 'type', 'eic', 'mall_officialauthorizeevents_details' )
			->filter ( 'my.record', '=', $record )
			->filter ( 'my.deleted', '=', '0' ) 
			->end(-1)
			->execute ();
 	   foreach($officialopinions as $officialopinion_info)
 	   {
	   		$officialopinion_info->my->deleted = '1';
	   		$officialopinion_info->save('mall_officialauthorizeevents_details,mall_officialauthorizeevents_details_'.$supplierid);
	   }
	}
	catch(XN_Exception $e)
	{
		$msg = $e->getMessage();	
		messagebox('错误',$msg);
		die(); 
	} 
} 
if (isset($_REQUEST["type"]) && $_REQUEST["type"] == "ajax")
{ 
	if(isset($_REQUEST['page']) && $_REQUEST['page'] != '')
	{
		$page = $_REQUEST['page'];    
		
		$query = XN_Query::create ( 'Content' )->tag ( 'mall_officialauthorizeevents_'.$supplierid )
			->filter ( 'type', 'eic', 'mall_officialauthorizeevents' )
//			->filter ( 'my.applicant', '=', $profileid )
			->filter ( 'my.status', '=', 0 )  //ready for approval
			->filter ( 'my.authorizedperson', '=', $profileid )
			->filter ( 'my.deleted', '=', '0' )
			->order('published',XN_Order::DESC)
			->begin(($page-1)*5)
			->end($page*5); 
	   $approvals = $query->execute ();
	   $noofrows = $query->getTotalCount();
	   if ($noofrows == 0 && $page != 1)
	   {
		   echo '{"code":202, "data":[]}'; 
		   die();
	   }
	   $approvallist = array();
	   $pos = 1;  
	   foreach($approvals as $approval_info)
	   {   
		   	$approvallist[$pos]['record'] = $approval_info->id; 
			$approvallist[$pos]['authorizationtitle'] = $approval_info->my->authorizationtitle;
			$approvallist[$pos]['authorizationdescription'] = $approval_info->my->authorizationdescription;
			$approvallist[$pos]['decider'] = getGivenName($approval_info->my->decider);
			$approvallist[$pos]['authorizedperson'] = getGivenName($approval_info->my->authorizedperson); 
			$opinion = $approval_info->my->opinion;
			$approvallist[$pos]['opinion'] = join(",",getGivenNameArrByids((array)$opinion));  
			$approvallist[$pos]['startdate'] = $approval_info->my->startdate;   
			$approvallist[$pos]['enddate'] = $approval_info->my->enddate; 
			$approvallist[$pos]['approvalstatus'] = $approval_info->my->approvalstatus;
//			$mall_officialauthorizeeventsstatus = $approval_info->my->mall_officialauthorizeeventsstatus;
			$mall_officialauthorizeeventsstatus = $approval_info->my->status;

			 
			$approvallist[$pos]['mall_officialauthorizeeventsstatus'] = getTranslatedString($mall_officialauthorizeeventsstatus,"Mall_OfficialAuthorizeEvents");   
			$approvallist[$pos]['submitapprovalreplydatetime'] = $approval_info->my->submitapprovalreplydatetime; 
			$pos++; 
	   }
	   echo '{"code":200,"length":'.$noofrows.',"data":'.json_encode($approvallist).'}';
	   die(); 
		 
	}
	echo '{"code":200,"length":0,"data":[]}'; 
	die(); 
}
   
	  

require_once('Smarty_setup.php');  
$smarty = new platform_Smarty;   

$smarty->assign("supplier_info",get_supplier_info()); 
$smarty->assign("theme_info",get_system_theme_info());	

$smarty->assign("copyrights",get_copyright_info());	
	
$action = strtolower(basename(__FILE__, ".php"));
$smarty->display($action . '.tpl');  

?>
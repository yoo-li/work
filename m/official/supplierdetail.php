<?php
 
session_start(); 

require_once (dirname(__FILE__) . "/../include/config.inc.php");
require_once (dirname(__FILE__) . "/../include/config.common.php");
require_once (dirname(__FILE__) . "/../include/utils.php");
 
if(isset($_SESSION['profileid']) && $_SESSION['profileid'] !='')
{ 
	$profileid = $_SESSION["profileid"];
}
else
{
	messagebox("错误", '检测不到必需的请求参数！');
	die();
} 
$erromsg = "";
if(isset($_REQUEST['type']) && $_REQUEST['type'] == 'submit')
{   
	
	if(isset($_REQUEST['account']) && $_REQUEST['account'] !='' &&
	   isset($_REQUEST['mobile']) && $_REQUEST['mobile'] !='' &&
	   isset($_REQUEST['supplierid']) && $_REQUEST['supplierid'] !='' &&
	   isset($_REQUEST['email']) && $_REQUEST['email'] !='' &&
	   isset($_REQUEST['password']) && $_REQUEST['password'] !='' &&
	   isset($_REQUEST['department']) && $_REQUEST['department'] !='')
	{ 
		$account = $_REQUEST["account"]; 
		$mobile = $_REQUEST["mobile"]; 
		$email = $_REQUEST["email"]; 
		$password = $_REQUEST["password"]; 
		$department = $_REQUEST["department"]; 
		$supplierid = $_REQUEST["supplierid"]; 
		
		
		$Users = XN_Query::create ( 'Content' )
			->filter ( 'type', 'eic', 'users' )
			->filter ( 'my.deleted', '=', '0' )
			->filter ( 'my.profileid', '!=', $profileid ) 
			->filter ( 'my.user_name', '=', $account ) 
			->end(1)
			->execute (); 
		if (count($Users) == 0) 
		{
			$Users = XN_Query::create ( 'Content' )
				->filter ( 'type', 'eic', 'supplier_users' )
				->filter ( 'my.deleted', '=', '0' )
				->filter ( 'my.profileid', '!=', $profileid ) 
				->filter ( 'my.supplierid', '=', $supplierid )
				->filter ( 'my.mobile', '=', $mobile ) 
				->execute (); 
			if (count($Users) == 0) 
			{
				$mall_officialapplys = XN_Query::create('MainContent')->tag("mall_officialapplys" )
				    ->filter('type', 'eic', 'mall_officialapplys') 
				    ->filter('my.deleted', '=', '0')    
					->filter('my.supplierid', '=', $supplierid)
					->filter('my.approvalstatus', 'in', array("0","1"))
					->filter('my.profileid', '=', $profileid) 
				    ->end(1)
				    ->execute(); 
	 
				if (count($mall_officialapplys) > 0)
				{
					$mall_officialapply_info = $mall_officialapplys[0]; 
			        $mall_officialapply_info->my->account =  $account;
			        $mall_officialapply_info->my->mobile = $mobile;
			        $mall_officialapply_info->my->email = $email; 
					$mall_officialapply_info->my->password = $password; 
					$mall_officialapply_info->my->department = $department; 
					$mall_officialapply_info->my->approvalstatus = "0";
					$mall_officialapply_info->my->mall_officialapplysstatus = 'JustCreated'; 
			        $mall_officialapply_info->save("mall_officialapplys,mall_officialapplys_".$supplierid);
				}
				else
				{
			        $newcontent = XN_Content::create('mall_officialapplys', '', false);
			        $newcontent->my->deleted = '0'; 
					$newcontent->my->profileid = $profileid; 
			        $newcontent->my->supplierid = $supplierid; 
			        $newcontent->my->account =  $account;
			        $newcontent->my->mobile = $mobile;
			        $newcontent->my->email = $email; 
					$newcontent->my->password = $password;
					$newcontent->my->department = $department; 
					$newcontent->my->approvalstatus = "0";
					$newcontent->my->mall_officialapplysstatus = 'JustCreated'; 
			        $newcontent->save("mall_officialapplys,mall_officialapplys_".$supplierid);
				}
			    header("Location: index.php");
			    die();
			}
			else
			{
				$erromsg = "手机已经占用!请更换手机号码!";
			}	 
		}
		else
		{
			$erromsg = "账号已经占用!请更换账号！";
		}  
	} 
	else
	{
		$erromsg = "参数异常！";
	}
}
global $supplierid;
if(isset($_REQUEST['supplierid']) && $_REQUEST['supplierid'] !='')
{ 
	$supplierid = $_REQUEST["supplierid"];
	$_SESSION["supplierid"]  = $supplierid;
}
else
{
	messagebox("错误", '检测不到必需的请求参数！');
	die();
} 
  
require_once('Smarty_setup.php');  
$smarty = new platform_Smarty;  

$smarty->assign("supplier_info",get_supplier_info()); 

$smarty->assign("erromsg",$erromsg); 

function GetDepartments($depth,$exclude){
	global $supplierid;
    $mall_categorys = XN_Query::create ( 'Content' )->tag('supplier_departments_'.$supplierid)
		    ->filter ( 'type', 'eic', 'supplier_departments')
		    ->filter ( 'my.supplierid',"=",$supplierid)
		    ->filter ( 'my.deleted', '=', 0)
		    ->order("my.sequence",XN_Order::ASC_NUMBER)
		    ->end(-1)
		    ->execute();
	$categorys = array();
	foreach($mall_categorys as $category_info)
	{
		$categoryid = $category_info->id;
		$categorys[$categoryid] = array('pid'=>$category_info->my->pid,'departmentsname'=>$category_info->my->departmentsname);
	} 
	
	
	
	return Recursion_GetDepartments($categorys,0,$depth,$exclude);
}
function Recursion_GetDepartments($categorys,$pid,$depth,$exclude)
{ 
    $excludes = explode(',', $exclude); 
    $categoryOption = array();
    $Prefix = "";
    if($depth>0){
        $Prefix = "　┣━";
        for($i=2;$i<=$depth;$i++){
            $Prefix .= "━";
        }
    }
    foreach ($categorys as $categoryid => $info){ 
        if(!in_array($categoryid,$excludes))
		{
			if ($info['pid'] == $pid)
			{
	            $categoryOption['"'.$categoryid.'"'] = $Prefix . $info['departmentsname']; 
	            $categoryOption = array_merge($categoryOption,Recursion_GetDepartments($categorys,$categoryid,$depth+1,$exclude));
			} 
        }
    }
    return $categoryOption;
}
 
try{    
    
	
	$mall_officialapplys = XN_Query::create('MainContent')->tag("mall_officialapplys" )
	    ->filter('type', 'eic', 'mall_officialapplys') 
	    ->filter('my.deleted', '=', '0')    
		->filter('my.supplierid', '=', $supplierid)
		->filter('my.approvalstatus', 'in', array("0","1"))
		->filter('my.profileid', '=', $profileid) 
	    ->end(1)
	    ->execute(); 
	
	$officialapplys = array();	
	if (count($mall_officialapplys) > 0)
	{
		$mall_officialapply_info = $mall_officialapplys[0];
        $officialapplys['account'] = $mall_officialapply_info->my->account;
        $officialapplys['mobile'] = $mall_officialapply_info->my->mobile;
        $officialapplys['email'] = $mall_officialapply_info->my->email; 
		$officialapplys['password'] = $mall_officialapply_info->my->password; 
		$officialapplys['department'] = $mall_officialapply_info->my->department; 
		$officialapplys['approvalstatus'] = $mall_officialapply_info->my->approvalstatus;
		$officialapplys['mall_officialapplysstatus'] = $mall_officialapply_info->my->mall_officialapplysstatus;  
		
	} 
}
catch(XN_Exception $e)
{
	$msg = $e->getMessage();	
	messagebox('错误',$msg);
	die(); 
} 

$smarty->assign("officialapplys", $officialapplys);
if (count($officialapplys) > 0)
{
	$smarty->assign("selectdepartment", '"'.$officialapplys['department'].'"');	  
}
else
{
	$smarty->assign("selectdepartment", "");	  
}

$smarty->assign("departments", GetDepartments(0,""));

$smarty->assign("theme_info",get_system_theme_info());	 

$smarty->assign("copyrights",get_copyright_info());	
	
$action = strtolower(basename(__FILE__, ".php"));
$smarty->display($action . '.tpl');  

?>
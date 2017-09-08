<?php

require_once('utils.php');
require_once('Smarty_setup.php');
require_once("modules/Approvals/config.func.php");
$currentModule="Suppliers";
global $currentModule;
$_permitted=true;

/*避开登陆验证，
 * 第一种方法：放在cms模块下面，所有的文件都不验证，参考/include/utils/UserInfoUtil.php第920行下面的
 * 第二种方法：文件放在跟目录下面，不通过/index.php入口文件，如果非要条用modules下面的文件，页只能条用已开放的模块，参考/include/utils/UserInfoUtil.php第920行下面的
 * 第三种方法：模拟登陆，如下所示：找到当前应用的ownerName,作为当前登陆的人：即强行赋值：XN_Profile::$VIEWER =$app->ownerName；
 *
 */
$application =  XN_Application::$CURRENT_URL;
$app = XN_Application::load($application);
$author = $app->ownerName;
XN_Profile::$VIEWER = $author;

header('Content-Type:text/html;charset=utf-8');

@session_start();
global $app_strings;
$app_strings = return_application_language(default_language());

$smarty=new vtigerCRM_Smarty;
$smarty->assign("APP",$app_strings);
$smarty->assign("table","suppliers");
$smarty->assign("copyrights",$copyrights);

$mode=$_REQUEST["mode"];

if(!isset($_REQUEST["mode"]) ||$_REQUEST["mode"]==""){
    $smarty->assign("GUID",hash('md5', guid(), false));
    $smarty->assign("MODE","first");
    $smarty->assign("REGISTERINFO","填写账户信息");
    $smarty->display("WzRegister.tpl");
    die();
}
if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == "submit" && isset($_REQUEST['mode']) && $_REQUEST['mode'] == "first")
{
    if (isset($_REQUEST['r_username']) && $_REQUEST['r_username'] != ""
        &&isset($_REQUEST['r_password']) && $_REQUEST['r_password'] != ""
        &&isset($_REQUEST['r_repassword'])&&isset($_REQUEST['r_repassword'])==$_REQUEST['r_password']
        &&isset($_REQUEST['r_email']) && $_REQUEST['r_email'] != ""
        &&isset($_REQUEST['r_contact']) && $_REQUEST['r_contact'] != ""
        &&isset($_REQUEST['r_phone']) && $_REQUEST['r_phone'] != ""
        &&isset($_REQUEST['r_provider']) && $_REQUEST['r_provider'] != ""
        &&isset($_REQUEST['guid']) && $_REQUEST['guid'] != "")
    {

        $checkcode =  $_REQUEST['checkcode'];
        $guid = $_REQUEST['guid'];
        $cache_checkcode = XN_MemCache::get("checkcode_".$guid);
        if (strtolower($cache_checkcode) == strtolower($checkcode))
        {
            $guid = hash('md5', guid(), false);
            XN_MemCache::put($reg_info,"checkcode_".$guid,"6000");

            $smarty->assign("CONTACT",trim($_REQUEST['r_contact']));
            $smarty->assign("USERNAME",trim($_REQUEST['r_username']));
            $smarty->assign("EMAIL",trim($_REQUEST['r_email']));
            $smarty->assign("CONTACT",trim($_REQUEST['r_contact']));
            $smarty->assign("PHONE",trim($_REQUEST['r_phone']));
            $smarty->assign("PROVIDER",trim($_REQUEST['r_provider']));
            $smarty->assign("PASSWORD",trim($_REQUEST['r_password']));
            $smarty->assign("GUID",trim($_REQUEST['guid']));
            $smarty->assign("CHANNEL","网上商城");
            $smarty->assign("MODE","second");
            $smarty->assign("REGISTERINFO","填写支付信息");
            $smarty->display("WzRegister.tpl");
        }
        else
        {
            $smarty->assign("CONTACT",trim($_REQUEST['r_contact']));
            $smarty->assign("USERNAME",trim($_REQUEST['r_username']));
            $smarty->assign("EMAIL",trim($_REQUEST['r_email']));
            $smarty->assign("PHONE",trim($_REQUEST['r_phone']));
            $smarty->assign("PASSWORD",trim($_REQUEST['r_password']));
            $smarty->assign("PROVIDER",trim($_REQUEST['r_provider']));
            $smarty->assign("GUID",trim($_REQUEST['guid']));
            $smarty->assign("ERROR","error");
            $smarty->assign("MODE","first");
            $smarty->assign("REGISTERINFO","填写账户信息");
            $smarty->display("WzRegister.tpl");
        }
    }
}

if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == "submit" && $_REQUEST['mode']=="second")
{
    if (isset($_REQUEST['r_ceo']) && $_REQUEST['r_ceo'] != ""
        &&isset($_REQUEST['r_bankowner']) && $_REQUEST['r_bankowner'] != ""
        &&isset($_REQUEST['r_bankaccount']) && $_REQUEST['r_bankaccount'] != ""
        &&isset($_REQUEST['r_bankname']) && $_REQUEST['r_bankname'] != ""
        &&isset($_REQUEST['r_returngoods_address']) && $_REQUEST['r_returngoods_address'] != ""
        &&isset($_REQUEST['r_province']) && $_REQUEST['r_province']!=''
        &&isset($_REQUEST['r_city']) && $_REQUEST['r_city']!=''
        &&isset($_REQUEST['r_companyaddress']) && $_REQUEST['r_companyaddress'] != ""
    )
    {
        $data_value=date('Y-m-d H:i:s');
        preg_match('/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/',$data_value,$value);

        $date_data = Array(
            'day'=>$value[3],
            'month'=>$value[2],
            'year'=>$value[1],
            'hour'=>$value[4],
            'min'=>$value[5],
            'sec'=>$value[6],
        );
        $date_time = new vt_DateTime($date_data,true);
        $tmpdate = $date_time->get_changed_hour('decrement');
        $guid = $_REQUEST['guid'];
        $smarty->assign("INVITECODE",trim($_REQUEST['r_invitecode']));
        $smarty->assign("USERNAME",trim($_REQUEST['r_username']));
        $smarty->assign("PASSWORD",trim($_REQUEST['r_password']));
        $smarty->assign("EMAIL",trim($_REQUEST['r_email']));
        $smarty->assign("CONTACT",trim($_REQUEST['r_contact']));
        $smarty->assign("PHONE",trim($_REQUEST['r_phone']));
        $smarty->assign("CHANNEL",trim($_REQUEST['r_channel']));
        $smarty->assign("PROVIDER",trim($_REQUEST['r_provider']));
		
		$smarty->assign("SHORTNAME",trim($_REQUEST['r_shortname']));
        $smarty->assign("CEO",$_REQUEST['r_ceo']);
        $smarty->assign("BANKOWNER",trim($_REQUEST['r_bankowner']));
        $smarty->assign("BANKACCOUNT",trim($_REQUEST['r_bankaccount']));
        $smarty->assign("BANKNAME",trim($_REQUEST['r_bankname']));
        $smarty->assign("returngoods_address",trim($_REQUEST['r_returngoods_address']));
        $smarty->assign("COMPANYADDRESS",trim($_REQUEST['r_companyaddress']));
        $smarty->assign("province",trim($_REQUEST['r_province']));
        $smarty->assign("city",trim($_REQUEST['r_city']));
        $smarty->assign("LONGITUDE",trim($_REQUEST['longitude']));
        $smarty->assign("LATITUDE",trim($_REQUEST['latitude']));
        $smarty->assign("MODE","thrid");
        $smarty->assign("GUID",trim($_REQUEST['guid']));
        $smarty->assign("REGISTERINFO","上传验证资料");
        $smarty->display('WzRegister.tpl');
    }
    else
    {
        $smarty->assign("INVITECODE",trim($_REQUEST['r_invitecode']));
        $smarty->assign("USERNAME",trim($_REQUEST['r_username']));
        $smarty->assign("PASSWORD",trim($_REQUEST['r_password']));
        $smarty->assign("EMAIL",trim($_REQUEST['r_email']));
        $smarty->assign("CONTACT",trim($_REQUEST['r_contact']));
        $smarty->assign("PHONE",trim($_REQUEST['r_phone']));
        $smarty->assign("CHANNEL",trim($_REQUEST['r_channel']));
        $smarty->assign("PROVIDER",trim($_REQUEST['r_provider']));
		$smarty->assign("SHORTNAME",trim($_REQUEST['r_shortname']));
        $smarty->assign("CEO",$_REQUEST['r_ceo']);
        $smarty->assign("BANKOWNER",trim($_REQUEST['r_bankowner']));
        $smarty->assign("BANKACCOUNT",trim($_REQUEST['r_bankaccount']));
        $smarty->assign("BANKNAME",trim($_REQUEST['r_bankname']));
        $smarty->assign("returngoods_address",trim($_REQUEST['r_returngoods_address']));
        $smarty->assign("COMPANYADDRESS",trim($_REQUEST['r_companyaddress']));
        $smarty->assign("province",trim($_REQUEST['r_province']));
        $smarty->assign("city",trim($_REQUEST['r_city']));
        $smarty->assign("LONGITUDE",trim($_REQUEST['longitude']));
        $smarty->assign("LATITUDE",trim($_REQUEST['latitude']));
        $smarty->assign("MODE","thrid");
        $smarty->assign("GUID",trim($_REQUEST['guid']));
        $smarty->assign("REGISTERINFO","上传验证资料");
        $smarty->display('WzRegister.tpl');
    }
}

if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == "submit" && $_REQUEST['mode']=="thrid")
{
   
        if(isset($_REQUEST['bussinesslicense']) && $_REQUEST['bussinesslicense'] != ""
			&&isset($_REQUEST['idcardfront']) && $_REQUEST['idcardfront'] != ""
            &&isset($_REQUEST['idcardback']) && $_REQUEST['idcardback'] != ""
        )
        {
            try{
                $suppliers_type=$_REQUEST['suppliers_type'];
                $username = $_REQUEST['r_username'];
                $email = $_REQUEST['r_email'];
                $password = $_REQUEST['r_password'];
                $contact=$_REQUEST['r_contact'];
                $mobile = $_REQUEST['r_phone'];
                $channel=$_REQUEST['r_channel'];
                $provider=$_REQUEST['r_provider'];
                $ceo=$_REQUEST['r_ceo'];
				$shortname = $_REQUEST['r_shortname'];
                $bankowner=$_REQUEST['r_bankowner'];
                $bankaccount=$_REQUEST['r_bankaccount'];
                $bankname=$_REQUEST['r_bankname'];
                $companyaddress=$_REQUEST['r_companyaddress'];
                $longitude=$_REQUEST['longitude'];
                $latitude=$_REQUEST['latitude'];
                $province=$_REQUEST['r_province'];
                $city=$_REQUEST['r_city']; 
                $returngoods_address=$_REQUEST['r_returngoods_address'];
                $bussinesslicense=$_REQUEST['bussinesslicense'];
                $idcardfront=$_REQUEST['idcardfront'];
                $idcardback=$_REQUEST['idcardback'];

                $data=array('province'=>$province,'city'=>$city,'returngoods_address'=>$returngoods_address,'suppliers_type'=>$suppliers_type,'supplier_channel'=>$channel,'company'=>$provider,'companyaddress'=>$companyaddress,
				    'suppliers_name'=>$provider,'suppliers_shortname'=>$shortname,'mallname'=>$shortname,
                    "accountname"=>$bankowner,"bankaccount"=>$bankaccount,'contact'=>$contact,'latitude'=>$latitude,'longitude'=>$longitude,
                    'bankname'=>$bankname,'ceo'=>$ceo,'bussinesslicense'=>$bussinesslicense,
                    'idcardfront'=>$idcardfront,'idcardback'=>$idcardback);
                $result = create_provider($username,$password,$email,$mobile,$data,$smarty);
                if($result){
                    $smarty->assign("CANCELBUTTON", getTranslatedString('LBL_CANCEL_BUTTON_LABEL'));
                    $smarty->assign("RECORD", $newContent->id);
                    $smarty->assign("REGISTERINFO","注册成功");
                    $smarty->assign("MSG","注册成功，等待管理员审批后即可登录操作！");
                    $smarty->assign("MODE","success");
                    $smarty->display("WzRegister.tpl");
                    die();
                }

            }catch(XN_Exception $e){
                echo $e->getMessage();
                die();
            }
        }else{
            $smarty->assign("USERNAME",trim($_REQUEST['r_username']));
            $smarty->assign("PASSWORD",trim($_REQUEST['r_password']));
            $smarty->assign("EMAIL",trim($_REQUEST['r_email']));
            $smarty->assign("CONTACT",trim($_REQUEST['r_contact']));
            $smarty->assign("PHONE",trim($_REQUEST['r_phone']));
            $smarty->assign("CHANNEL",trim($_REQUEST['r_channel']));
            $smarty->assign("PROVIDER",trim($_REQUEST['r_provider']));
			$smarty->assign("SHORTNAME",trim($_REQUEST['r_shortname']));
            $smarty->assign("GUID",trim($_REQUEST['guid']));
            $smarty->assign("COMPANYADDRESS",trim($_REQUEST['r_companyaddress']));
            $smarty->assign("CEO",trim($_REQUEST['r_ceo']));
            $smarty->assign("BANKOWNER",trim($_REQUEST['r_bankowner']));
            $smarty->assign("BANKACCOUNT",trim($_REQUEST['r_bankaccount']));
            $smarty->assign("BANKNAME",trim($_REQUEST['r_bankname']));
            $smarty->assign("returngoods_address",trim($_REQUEST['r_returngoods_address']));
            $smarty->assign("province",trim($_REQUEST['r_province']));
            $smarty->assign("city",trim($_REQUEST['r_city']));
            $smarty->assign("suppliers_type",trim($_REQUEST['suppliers_type']));
            $smarty->assign("BUSSINESSLICENSE",trim($_REQUEST['bussinesslicense']));
            $smarty->assign("IDCARDFRONT",trim($_REQUEST['idcardfront']));
            $smarty->assign("IDCARDBACK",trim($_REQUEST['idcardback']));
            $smarty->assign("MODE","thrid");
            !trim($_REQUEST['bussinesslicense']) && $smarty->assign("bussinesslicense_error","true"); 
            !trim($_REQUEST['idcardfront']) && $smarty->assign("idcardfront_error","true");
            !trim($_REQUEST['idcardback']) && $smarty->assign("idcardback_error","true");
            $smarty->display('WzRegister.tpl');
        }
}


function create_provider($username,$password,$email,$mobile,$data,$smarty)
{
    try{
        $newContent=XN_Content::create('Suppliers',"",false);
        $newContent->my->suppliers_username=$username;
        $newContent->my->createnew=0;
        $newContent->my->deleted=0;
        $newContent->my->suppliersstatus="Approvaling";
		$newContent->my->suppliertype='F2C';
        $newContent->my->supplier_status=0;
        $newContent->my->uppergrade="";
        $newContent->my->buyermanageid="";
        $newContent->my->password=$password;
        $newContent->my->product_type='2';
        $newContent->my->mobile=$mobile;
        $newContent->my->email=$email;
        $newContent->my->developer="";
        $newContent->my->datafrom="system";
        foreach($data as $key=>$val){
            $newContent->my->$key=$val;
        }
        $newContent->my->deleted='0';
        $newContent->my->createnew='0';
        $newContent->save('suppliers');
        $formodule="Suppliers";


        sendapproval($newContent->id,$formodule,"front");
        return true;

    }
    catch(XN_Exception $e){
        $smarty->assign("REGISTERINFO","注册失败");
        $smarty->assign("MSG","网络故障，请稍候重试！");
    }
}

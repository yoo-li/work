<?php
include_once('config.php');
require_once('include/utils/utils.php');

class Suppliers extends CRMEntity {
	
	public $table_name = 'suppliers';
	public $table_index= 'id';
	public $tab_name = Array('suppliers');
	public $tab_name_index = Array('suppliers'=>'id');
	public $customFieldTable = Array('suppliers', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('suppliers_name','suppliers_type','trackno','uppergrade','developer','contact','mobile','province','city','product_type','suppliersstatus','submitapprovalreplydatetime','supplier_status','datafrom');
	public $list_link_field= 'suppliers_name';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(
	);
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('suppliers_name');
    public $special_search_fields = array(
        'suppliersstatus' => array(
            '' => array('value'=>'All','label'=>'All','operator'=>'='),
            'Saved' => array('value'=>'Saved','label'=>'Saved','operator'=>'='),
            'Approvaling' => array('value'=>'Approvaling','label'=>'Approvaling','operator'=>'='),
            'Agree' => array('value'=>'Agree','label'=>'Agree','operator'=>'='),
            'Disagree' => array('value'=>'Disagree','label'=>'Disagree','operator'=>'='),
        ),
        'suppliertype' => array(
            '' => array('value'=>'All','label'=>'All','operator'=>'='),
            'F2C' => array('value'=>'F2C','label'=>'F2C商家','operator'=>'='),
            'O2O' => array('value'=>'O2O','label'=>'O2O商家','operator'=>'='),
            'B2B' => array('value'=>'B2B','label'=>'B2B商家','operator'=>'='), 
        ),
    ); 
	
	var $popup_fields = Array('suppliers_name','suppliers_shortname','city','contact','mobile');
	var $filter_fields = Array('suppliers_name','description');
	var $sortby_number_fields = Array();
	
	var $select_fields = array(
	    'Products' => array('product_type'),
	);

    //供应商前台注册信息审批时，生成profile记录，users记录




	function __construct() {
		
		$this->column_fields = getColumnFields('Suppliers');
	}

	function save_module($module){}

    public function approval_event($record,$event) {
        $lowermodule="suppliers";
        if($event=="Agree"){
			
            $supplierContent=XN_Content::load($record,$lowermodule);
            $username=$supplierContent->my->suppliers_username;
			$suppliers_shortname=$supplierContent->my->suppliers_shortname;
			$suppliers_name=$supplierContent->my->suppliers_name;
            $password=$supplierContent->my->password;
            $mobile=$supplierContent->my->mobile;
            $email=$supplierContent->my->email;
            $nickname=$supplierContent->my->suppliers_username;
            $bankname=$supplierContent->my->bankname;
            $bankaccount=$supplierContent->my->bankaccount;
            $accountname=$supplierContent->my->accountname;
            $companyname=$supplierContent->my->company;
            $companyaddress=$supplierContent->my->companyaddress;
            $system=$supplierContent->my->system;
            $browser=$supplierContent->my->browser;

         
            //审批通过后，要给供应商生成对应的用户，供应商可以使用这个用户登录后台
            $profile = XN_Profile::create ( trim($email), $password );
            $profile->fullName = $username.'#'.XN_Application::$CURRENT_URL;
            $profile->mobile = trim($mobile);
            $profile->givenname=$username;
            $profile->companyname=$companyname;
            $profile->bankaccount=$bankaccount;
            $profile->bank=$bankname;
            $profile->bankname=$accountname;
            $profile->address=$companyaddress;
            $profile->system=$system;
            $profile->browser=$browser;
            $profile->money = "0";
            $profile->frozen_money = "0";
            $profile->accumulatedmoney = "0";
            $profile->status = 'True';
            $profile->application = XN_Application::$CURRENT_URL;
            $profile->type = "pt";
            $profile->save ();

            //指定负责人是自己，然后供应商才能进行相关的操作，比如新建品牌和商品
            $supplierContent->my->pers=$profile->profileid;
            $supplierContent->my->supplier_status=1;
            $supplierContent->save($lowermodule);

            $app = XN_Application::load( XN_Application::$CURRENT_URL);
            $author = $app->ownerName;

            //获取供应商权限组id，即profilesid
            $suppliers_profiles = XN_Query::create ( 'Content' )
                ->tag("profiles")
                ->filter ( 'type', 'eic', "profiles")
                ->filter ( 'my.profilename ','=','商家')
                ->filter ( 'my.deleted', '=', '0' )
                ->end(1)
                ->execute();
            if(count($suppliers_profiles) > 0)
			{
                $profilesid=$suppliers_profiles[0]->id;
            }
            else
			{
	            $Administrator = XN_Content::create('profiles','',false);
	            $Administrator->my->profilename  = '商家';
	            $Administrator->my->description  = '商家';
	            $Administrator->my->globalactionpermission1  = 0;
	            $Administrator->my->globalactionpermission2   = 0;
	            $Administrator->my->allowdeleted = 1;
	            $Administrator->my->deleted = 0;
	            $Administrator->save('profiles');
	            $profilesid = $Administrator->id; 
            }
            //获取本部门按sequence降序排列的最后一个人信息
            $last_users=XN_Query::create ( 'Content' )
                ->tag("users")
                ->filter ( 'type', 'eic', "users")
                ->filter ( 'my.deleted', '=', '0' )
                ->order("my.sequence ",XN_Order::DESC_NUMBER)
                ->end(1)
                ->execute();
            $last_user=$last_users[0];
            $sequence=$last_user->my->sequence;
            //users表里面要有对应的记录才能登录的O
            XN_Content::create ( 'users', $username, false )
                ->my->add ( 'profileid', $profile->profileid )
                ->my->add ( 'profilesid', $profilesid )
                ->my->add ( 'currency_id', '1' )
                ->my->add ( 'date_format', 'yyyy-mm-dd' )
                ->my->add ( 'email1', $profile->email )
                ->my->add ( 'end_hour', '' )
                ->my->add ( 'first_name', $nickname )
                ->my->add ( 'hour_format', '' )
                ->my->add ( 'imagename', '' )
                ->my->add ( 'internal_mailer', '1' )
                ->my->add ( 'is_admin', 'pt' )
                ->my->add ( 'last_name', $nickname )
                ->my->add ( 'lead_view', 'Today' )
                ->my->add ( 'phone_mobile', $profile->mobile )
                ->my->add ( 'reminder_interval', 'None' )
                ->my->add ( 'reports_to_id', $author )
                ->my->add ( 'roleid', "" )
                ->my->add ( 'signature', '' )
                ->my->add ( 'start_hour', '' )
                ->my->add ( 'status', 'Active' )
                ->my->add ( 'title', '' )
                ->my->add ( 'user_name', $username )
                ->my->add ( 'deleted', '0' )
                ->my->add ( 'creator', '1' )
				->my->add ( 'user_type', 'guest' ) 
                ->my->add ( 'sequence', intval($sequence)+1)
                ->save('users');
			
			$supplierid = $supplierContent->id;  
			$newcontent                      = XN_Content::create('supplier_departments', '', false);
			$newcontent->my->sequence        = "100";
			$newcontent->my->pid             = "";
			$newcontent->my->supplierid      = $supplierid;
			$newcontent->my->departmentsname = $suppliers_shortname;
			$newcontent->my->leadership = "";
			$newcontent->my->mainleadership = "";
			$newcontent->my->deleted         = '0';
			$newcontent->save('supplier_departments,supplier_departments_'.$supplierid);
			
	        $access_info=XN_Content::create("supplier_accesssetting","",false);
	        $access_info->my->access_name='基本权限';
			$access_info->my->description='系统默认创建的基本权限';   
	        $access_info->my->isadmin = '1';
	        $access_info->my->appaccess='';
			$access_info->my->access_content='';
	        $access_info->my->deleted='0'; 
	        $access_info->my->supplierid = $supplierid;
	        $access_info->save("supplier_accesssetting,supplier_accesssetting_".$supplierid);
			 
			
            $supplier_user=XN_Content::create("supplier_users");
            $supplier_user->my->supplierid=$record;
            $supplier_user->my->account=$username;
            $supplier_user->my->password=$password;
            $supplier_user->my->email=$email;
            $supplier_user->my->mobile=$mobile;
            $supplier_user->my->profileid=$profile->profileid;
            $supplier_user->my->supplierusertype='boss';
            $supplier_user->my->status='0';
            $supplier_user->my->deleted='0'; 
			$supplier_user->my->approvalstatus = '2'; 
			$supplier_user->my->supplier_usersstatus = 'Agree';
			$supplier_user->my->departments = $newcontent->id;
			$supplier_user->my->access_id = $access_info->id;
			$supplier_user->my->parentsuperiors = $profile->profileid;
            $supplier_user->save("supplier_users,supplier_users_".$supplierid);

            $content="尊敬的".$companyname.",您好,特赞电子商务平台欢迎您,您的商家账号".$username."已通过审核,您可以进行相关操作！";
            XN_Content::create('sendmobile', '',false,2)
                ->my->add('status','waiting')
                ->my->add('type','simple')
                ->my->add('to_mobile',$profile->mobile)
                ->my->add('contents',$content)
                ->save("sendmobile");
        }
        else{
            $supplierContent=XN_Content::load($record,$lowermodule);
            $username=$supplierContent->my->suppliers_username;
            $mobile=$supplierContent->my->mobile;
            $companyname=$supplierContent->my->company;
            $content="尊敬的".$companyname.",您好,您在特赞电子商务平台注册的商家账号".$username.",因为信息不准确，被拒绝,请您重新注册！";
            XN_Content::create('sendmobile', '',false,2)
                ->my->add('status','waiting')
                ->my->add('type','simple')
                ->my->add('to_mobile',$mobile)
                ->my->add('contents',$content)
                ->save("sendmobile");
        }
    }
	function getSortOrder() {
		
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['SUPPLIERS_SORT_ORDER'] != '')?($_SESSION['SUPPLIERS_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}
	
	function getOrderBy() {
		
		$use_default_order_by = $this->default_order_by;
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['SUPPLIERS_ORDER_BY'] != '')?($_SESSION['SUPPLIERS_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}
}?>
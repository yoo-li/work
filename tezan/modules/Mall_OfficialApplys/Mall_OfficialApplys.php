<?php
include_once('config.php');
require_once('include/utils/utils.php');

class Mall_OfficialApplys extends CRMEntity {
	
	public $table_name = 'mall_officialapplys';
	public $table_index= 'id';
	public $tab_name = Array('mall_officialapplys');
	public $tab_name_index = Array('Mall_OfficialApplys'=>'id');
	public $customFieldTable = Array('Mall_OfficialApplys', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('mall_officialapplysstatus');
	public $list_link_field= 'id';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(); 
	
	var $popup_fields = Array('mall_officialapplysstatus');
	var $filter_fields = Array('mall_officialapplysstatus');
	
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('published');
    public $special_search_fields = array();
	var $sortby_number_fields = Array('mall_officialapplysstatus','published');
	
    function Mall_OfficialApplys() {
		
		$this->column_fields = getColumnFields('Mall_OfficialApplys');
	}

	function save_module($module){} 
		
	public function approval_event($id,$event) {
		if ($id > 0 && $event == 'Agree') {
			
			$loadcontent = XN_Content::load($id,"mall_officialapplys");
            $profileid = $loadcontent->my->profileid; 
			$supplierid = $loadcontent->my->supplierid; 
			
	        $account = $loadcontent->my->account;
	        $email = $loadcontent->my->email;
	        $mobile = $loadcontent->my->mobile;
	        $password = $loadcontent->my->password;
			
			$department = $loadcontent->my->department;
			
			
	        $supplier_profile = XN_Query::create('MainContent')->tag("supplier_profile")
	            ->filter('type', 'eic', 'supplier_profile')
	            ->filter('my.profileid', '=', $profileid)
	            ->filter('my.supplierid', '=', $supplierid)
	            ->filter('my.deleted', '=', '0') 
	            ->end(1)
	            ->execute();
	        if (count($supplier_profile) > 0)
	        {
				$supplier_profile_info = $supplier_profile[0];
				$wxopenid = $supplier_profile_info->my->wxopenid;
				$supplier_profile_info->my->subscribe = "0";
				$supplier_profile_info->my->official = "0";
				$tag = "supplier_profile,supplier_profile_" . $wxopenid . ",supplier_profile_" . $profileid. ",supplier_profile_" . $supplierid;
				$supplier_profile_info->save($tag);
			}
			else
			{ 
				$profile = XN_Profile::load($profileid,"id","profile_".$profileid);
                $newcontent = XN_Content::create('supplier_profile', '', false);
                $newcontent->my->deleted = '0';
                $newcontent->my->profileid = $profileid;
                $newcontent->my->supplierid = $supplierid;
                $newcontent->my->wxopenid = guid();
                $newcontent->my->givenname = strip_tags($profile->givenname);
                $newcontent->my->province = $profile->province;
                $newcontent->my->city = $profile->city;
                $newcontent->my->gender = $profile->gender;
                $newcontent->my->mobile = $profile->mobile;
                $newcontent->my->birthdate = $profile->birthdate;
                $newcontent->my->gender = $profile->gender;
                $newcontent->my->invitationcode = $profile->invitationcode;
                $newcontent->my->reg_ip = $profile->reg_ip;
                $newcontent->my->rank = '0';
                $newcontent->my->accumulatedmoney = '0';
                $newcontent->my->money = '0';
                $newcontent->my->maxtakecash = '0';
                $newcontent->my->latitude = '';
                $newcontent->my->longitude = '';
                $newcontent->my->ranklevel = '0';
				$newcontent->my->subscribe = '0';
				$newcontent->my->official = '0';
				$newcontent->my->authenticationprofile = '0';
                $newcontent->my->onelevelsourcer = '';
				$newcontent->my->twolevelsourcer = '';
				$newcontent->my->threelevelsourcer = '';
				$newcontent->my->hassourcer = '0';
				$tag = "supplier_profile,supplier_profile_" . $profileid. ",supplier_profile_" . $supplierid;
				$tag .= ",supplier_profile_" . $onelevelsourcer;
				$tag .= ",supplier_profile_" . $twolevelsourcer;
				$tag .= ",supplier_profile_" . $threelevelsourcer;
                $newcontent->save($tag);
			}
			
			$profilename = '商家';
	        //获取供应商权限组id，即profilesid
	        $suppliers_profiles = XN_Query::create('Content')
	            ->tag("profiles")
	            ->filter('type', 'eic', "profiles")
	            ->filter('my.profilename ', '=', $profilename)
	            ->filter('my.deleted', '=', '0')
	            ->end(1)
	            ->execute();
	        if (count($suppliers_profiles))
	        {
	            $profilesid = $suppliers_profiles[0]->id;
	        }
	        else
	        {
	            $Administrator = XN_Content::create('profiles', '', false);
	            $Administrator->my->profilename = $profilename;
	            $Administrator->my->description = $profilename;
	            $Administrator->my->globalactionpermission1 = 0;
	            $Administrator->my->globalactionpermission2 = 0;
	            $Administrator->my->allowdeleted = 1;
	            $Administrator->my->deleted = 0;
	            $Administrator->save('profiles');
	            $profilesid = $Administrator->id;
	        }
	        //获取本部门按sequence降序排列的最后一个人信息
	        $last_users = XN_Query::create('Content')
	            ->tag("users")
	            ->filter('type', 'eic', "users")
	            ->filter('my.deleted', '=', '0')
	            ->order("my.sequence ", XN_Order::DESC_NUMBER)
	            ->end(1)
	            ->execute();
	        $last_user = $last_users[0];
	        $sequence = $last_user->my->sequence;
			
	        //users表里面要有对应的记录才能登录的O
			$profile = XN_Profile::load($profileid,"id","profile_".$profileid);
			$profile->password = $password;	         
			$profile->save("profile_".$profileid);	  
			
			$givenname = $info->givenname; 
			
	        $users = XN_Query::create('Content')->tag("users")
	            ->filter('type', 'eic', 'users')
	            ->filter('my.profileid', '=', $profileid) 
	            ->filter('my.deleted', '=', '0') 
	            ->end(1)
	            ->execute();
	        if (count($users) == 0)
			{
		        XN_Content::create('users', $givenname, false)
		            ->my->add('profileid', $profileid)
		            ->my->add('profilesid', $profilesid)
		            ->my->add('currency_id', '1')
		            ->my->add('date_format', 'yyyy-mm-dd')
		            ->my->add('email1', $email)
		            ->my->add('end_hour', '')
		            ->my->add('first_name', $account)
		            ->my->add('hour_format', '')
		            ->my->add('imagename', '')
		            ->my->add('internal_mailer', '1')
		            ->my->add('is_admin', 'pt')
		            ->my->add('last_name', $account)
		            ->my->add('lead_view', 'Today')
		            ->my->add('phone_mobile', $mobile)
		            ->my->add('reminder_interval', 'None')
		            ->my->add('reports_to_id', '')
		            ->my->add('roleid', '')
		            ->my->add('signature', '')
		            ->my->add('start_hour', '')
		            ->my->add('status', 'Active')
		            ->my->add('title', '')
		            ->my->add('user_name', $givenname)
		            ->my->add('deleted', '0')
		            ->my->add('creator', '1')
					->my->add('user_type', 'guest') 
		            ->my->add('sequence', intval($sequence)+1)
		            ->save('users');
			}
			else
			{
				$user_info = $users[0];  
				$user_info->my->last_name = $account;
				$user_info->my->first_name = $account;
				$user_info->my->user_name = $givenname;
				$user_info->my->phone_mobile = $mobile;
				$user_info->my->email1 = $email; 
				$tag = "users,users_" . $profileid;
				$user_info->save($tag);
			}
	        
	       
			
			$supplier_accesssetting = XN_Query::create ( 'Content' ) ->tag('supplier_accesssetting')
			    ->filter ( 'type', 'eic', 'supplier_accesssetting')
			    ->filter ( 'my.deleted', '=', '0' )
			    ->filter ( 'my.access_name', '=' ,'员工权限')
			    ->filter ( 'my.supplierid', '=' ,$supplierid)
				->end(1)
			    ->execute();
			if(count($supplier_accesssetting) > 0)
			{
				$supplier_accesssetting_info = $supplier_accesssetting[0];
			    $accesssettingid = $supplier_accesssetting_info->id;
			}
			else
			{
	            $accesssetting_info = XN_Content::create('supplier_accesssetting', '', false);
	            $accesssetting_info->my->access_name = '员工权限';
	            $accesssetting_info->my->description = '员工权限'; 
	            $accesssetting_info->my->supplierid=$supplierid;
				$accesssetting_info->my->access_content='';
				$accesssetting_info->my->isadmin='';
				$accesssetting_info->my->appaccess='';
	            $accesssetting_info->my->deleted = "0";
	            $accesssetting_info->save('supplier_accesssetting');
	            $accesssettingid = $accesssetting_info->id; 
			}
		
			 
			$supplier_users = XN_Query::create ( 'Content' ) ->tag('supplier_users')
			    ->filter ( 'type', 'eic', 'supplier_users')
			    ->filter ( 'my.deleted', '=', '0' )
			    ->filter ( 'my.supplierid', '=' ,$supplierid)
				->filter ( 'my.supplierusertype', '=' ,'boss')
				->end(-1)
			    ->execute(); 
	
			if (count($supplier_users) > 0)
			{
				$supplier_user_info = $supplier_users[0];
				$boss = $supplier_user_info->my->profileid;
			}
			else
			{
				$boss = "";
			}
			
			 
			$supplier_users = XN_Query::create ( 'Content' ) ->tag('supplier_users')
			    ->filter ( 'type', 'eic', 'supplier_users')
			    ->filter ( 'my.deleted', '=', '0' )
			    ->filter ( 'my.supplierid', '=' ,$supplierid)
				->filter ( 'my.profileid', '=' ,$profileid)
				->end(1)
			    ->execute();  
			if (count($supplier_users) == 0)
			{
		        $supplier_user=XN_Content::create("supplier_users");
		        $supplier_user->my->supplierid=$supplierid;
		        $supplier_user->my->account=$account;
		        $supplier_user->my->password=$password;
		        $supplier_user->my->email=$email;
		        $supplier_user->my->mobile=$mobile;
		        $supplier_user->my->profileid=$profileid;
		        $supplier_user->my->supplierusertype='employee';
		        $supplier_user->my->status='0';
		        $supplier_user->my->deleted='0'; 
				$supplier_user->my->approvalstatus = '2'; 
				$supplier_user->my->supplier_usersstatus = 'Agree';
				$supplier_user->my->departments = $department;
				$supplier_user->my->access_id = $accesssettingid;
				$supplier_user->my->parentsuperiors = $boss;
		        $supplier_user->save("supplier_users,supplier_users_".$supplierid.",supplier_users_".$profileid);
			}
			else
			{
				$supplier_user = $supplier_users[0];  
		        $supplier_user->my->account=$account;
		        $supplier_user->my->password=$password;
		        $supplier_user->my->email=$email;
		        $supplier_user->my->mobile=$mobile;  
		        $supplier_user->my->status='0'; 
				$supplier_user->my->departments = $department;  
		        $supplier_user->save("supplier_users,supplier_users_".$supplierid.",supplier_users_".$profileid);
			} 
		}
	}

	function getSortOrder() {
		
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION[strtoupper($this->table_name).'_SORT_ORDER'] != '')?($_SESSION[strtoupper($this->table_name).'_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}
	
	function getOrderBy() {
		
		$use_default_order_by = $this->default_order_by;
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION[strtoupper($this->table_name).'_ORDER_BY'] != '')?($_SESSION[strtoupper($this->table_name).'_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}
}?>
<?php
include_once('config.php');
require_once('include/utils/utils.php');

class Supplier_Shops extends CRMEntity {
	
	public $table_name = 'supplier_shops';
	public $default_published_section = 'year';//month day year
	public $table_index= 'id';
	public $tab_name = Array('supplier_shops');
	public $tab_name_index = Array('supplier_shops'=>'id');
	public $customFieldTable = Array('supplier_shops', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('name','address','district','street','telphone','source','businessestype','businessesstatus','hasthumb','hasvipcard','hascashondelivery','imagescount');
	public $list_link_field= 'name';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(
	);
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('supplier_shops_no');
    public $special_search_fields = array(
      
    );
	 
	var $popup_fields = Array('name','address','district','street','businessestype');
	var $filter_fields = Array('name','district','street');
	var $sortby_number_fields = Array('imagescount');
	
	
    function Supplier_Shops() {
		
		$this->column_fields = getColumnFields('Supplier_Shops');
	}

	function save_module($module){}

	function getSortOrder() {
		
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['SUPPLIER_SHOPS_SORT_ORDER'] != '')?($_SESSION['SUPPLIER_SHOPS_SORT_ORDER']):($this->default_sort_order));
		return $sorder;
	}
	
	function getOrderBy() {
		
		$use_default_order_by = $this->default_order_by;
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['SUPPLIER_SHOPS_ORDER_BY'] != '')?($_SESSION['SUPPLIER_SHOPS_ORDER_BY']):($use_default_order_by));
		return $order_by;
	}
	
    public function approval_event($record,$event) 
	{ 
        if($event=="Agree")
		{
			try 
			{
	            $supplier_shop_info = XN_Content::load($record,'supplier_shops');
				$supplierid = $supplier_shop_info->my->supplierid;
				$name = $supplier_shop_info->my->name;
				$shopcity = $supplier_shop_info->my->shopcity;
				$account = $supplier_shop_info->my->account;
				$email = $supplier_shop_info->my->email;
				$mobile = $supplier_shop_info->my->mobile; 
				$profileid = $supplier_shop_info->my->profileid;
				$password = $supplier_shop_info->my->password; 
				self::verifyshop($supplier_shop_info,$shopcity,$supplierid,$name,$account,$password,$email,$mobile,$profileid);
			}
			catch (XN_Exception $e) 
			{
				 
			}	
		}
	}
	
	function verifyshop($supplier_shop_info,$shopcity,$supplierid,$name,$account,$password,$email,$mobile,$profileid) 
	{
		$businesseid = $supplier_shop_info->my->businesseid;
 	    $application = XN_Application::$CURRENT_URL;
 	    XN_Application::$CURRENT_URL = $shopcity;
		
		if (isset($profileid) && $profileid != "")
		{
            $roles = XN_Query::create ( 'Content' )
                ->tag("roles")
                ->filter ( 'type', 'eic', 'roles' )
                ->filter('my.rolename','=','特赞生活')
                ->end(1)
                ->execute();
            if (count($roles) == 0)
			{
				throw new XN_Exception("特赞生活的部门不存在!");
			}
			$role_info = $roles[0];
            $roleid = $role_info->my->roleid;
			
            //获取供应商权限组id，即profilesid
            $suppliers_profiles = XN_Query::create ( 'Content' )
                ->tag("profiles")
                ->filter ( 'type', 'eic', "profiles")
                ->filter ( 'my.profilename ','=','特赞生活')
                ->filter ( 'my.deleted', '=', '0' )
                ->end(1)
                ->execute();
            if (count($suppliers_profiles) == 0)
			{
				throw new XN_Exception("特赞生活的权限不存在!");
			}
			$suppliers_profile_info = $suppliers_profiles[0];
            $profilesid = $suppliers_profile_info->id;  
			
	 	   $Users = XN_Query::create ( 'Content' )->tag("users")
	 			->filter ( 'type', 'eic', 'users' )
	 		    ->filter ( 'my.deleted', '=', '0' )
				->filter ( 'my.profileid', '=', $profileid )
	 			->execute (); 
	 	   if (count($Users) == 0) 
	 	   {
				$sequence = 5000;  
	            XN_Content::create ( 'users', $account, false )
	                ->my->add ( 'profileid', $profileid )
	                ->my->add ( 'profilesid', $profilesid )
	                ->my->add ( 'currency_id', '1' )
	                ->my->add ( 'date_format', 'yyyy-mm-dd' )
	                ->my->add ( 'email1', $email )
	                ->my->add ( 'end_hour', '' )
	                ->my->add ( 'first_name', $account )
	                ->my->add ( 'hour_format', '' )
	                ->my->add ( 'imagename', '' )
	                ->my->add ( 'internal_mailer', '1' )
	                ->my->add ( 'is_admin', 'pt' )
	                ->my->add ( 'last_name', $account )
	                ->my->add ( 'lead_view', 'Today' )
	                ->my->add ( 'phone_mobile', $mobile )
	                ->my->add ( 'reminder_interval', 'None' )
	                ->my->add ( 'reports_to_id', $profileid )
	                ->my->add ( 'roleid', $roleid )
	                ->my->add ( 'signature', '' )
	                ->my->add ( 'start_hour', '' )
	                ->my->add ( 'status', 'Active' )
	                ->my->add ( 'title', '' )
	                ->my->add ( 'user_name', $account )
	                ->my->add ( 'deleted', '0' )
	                ->my->add ( 'creator', '0' )
	                ->my->add ( 'sequence', $sequence)
	                ->save('users');
		   }
	 	  
	 	    $local_businesses = XN_Query::create ( 'Content' )->tag("local_businesses")
	 			->filter ( 'type', 'eic', 'local_businesses' )
	 		    ->filter ( 'my.deleted', '=', '0' )
				->filter ( 'my.supplierid', '=', $supplierid )
	 			->execute (); 
	 	    if (count($local_businesses) == 0) 
	 	    {
				$businesseid = "";
		    }
	   		if (!isset($businesseid) || $businesseid == "") 
	   		{ 
				    $longitude = $supplier_shop_info->my->longitude;
					$businessestype = $supplier_shop_info->my->businessestype;
					$productprefix = $supplier_shop_info->my->productprefix;
				    $latitude = $supplier_shop_info->my->latitude;  
					$newlatitude = round($latitude * 1000000);
					$newlongitude = round($longitude * 1000000); 
			
	                $newcontent = XN_Content::create ( 'local_businesses', '', false )
							   ->my->add ( 'supplierid', $supplierid )
			                   ->my->add ( 'uid', "" )
							   ->my->add ( 'name', $name )
							   ->my->add ( 'mobile', $mobile )
			                   ->my->add ( 'longitude', $longitude )
			                   ->my->add ( 'latitude', $latitude ) 
			                   ->my->add ( 'latitude1', $newlatitude )
			                   ->my->add ( 'longitude1', $newlongitude )
			                   ->my->add ( 'businessesstatus', '0' )
			                   ->my->add ( 'businessestype', $businessestype ) 
							   ->my->add ( 'productprefix', $productprefix ) 
							   ->my->add ( 'overall_rating', '0' )
							   ->my->add ( 'environment_rating', '0' )
							   ->my->add ( 'service_rating', '0' )
							   ->my->add ( 'taste_rating', '0' )
			                   ->my->add ( 'deleted', '0' )
			                   ->my->add ( 'creator', '0' ) 
			                   ->save('local_businesses'); 
	 		  
					$businesseid = $newcontent->id;
		 	 	    $local_users = XN_Query::create ( 'Content' )
		 	 			->filter ( 'type', 'eic', 'local_users' )
		 	 		    ->filter ( 'my.deleted', '=', '0' )
		 				->filter ( 'my.profileid', '=', $profileid )
		 	 			->execute (); 
		 	 	   if (count($local_users) == 0) 
		 	 	   { 
		 	            XN_Content::create ( 'local_users', '', false )
		 	                ->my->add ( 'profileid', $profileid )
		 	                ->my->add ( 'supplierid', $supplierid ) 
		 	 				->my->add ( 'businesseid', $businesseid ) 
		 					->my->add ( 'account', $account )
		 					->my->add ( 'email', $email )
		 					->my->add ( 'mobile', $mobile )
		 					->my->add ( 'password', $password ) 
		 				    ->my->add ( 'status', 'Active' )
		 					->my->add ( 'localusertype', 'boss' ) 
		 	                ->my->add ( 'deleted', '0' )
		 	                ->my->add ( 'creator', '0' ) 
		 	                ->save('local_users');
		 		    }
				   
				    XN_Application::$CURRENT_URL = $application; 
					$supplier_shop_info->my->businesseid = $businesseid;
					$supplier_shop_info->save("supplier_shops");
	   		} 
			else
			{
	 	 	    $local_users = XN_Query::create ( 'Content' )
	 	 			->filter ( 'type', 'eic', 'local_users' )
	 	 		    ->filter ( 'my.deleted', '=', '0' )
	 				->filter ( 'my.profileid', '=', $profileid )
	 	 			->execute (); 
	 	 	   if (count($local_users) == 0) 
	 	 	   { 
	 	            XN_Content::create ( 'local_users', '', false )
	 	                ->my->add ( 'profileid', $profileid )
	 	                ->my->add ( 'supplierid', $supplierid ) 
	 	 				->my->add ( 'businesseid', $businesseid ) 
	 					->my->add ( 'account', $account )
	 					->my->add ( 'email', $email )
	 					->my->add ( 'mobile', $mobile )
	 					->my->add ( 'password', $password ) 
	 				    ->my->add ( 'status', 'Active' )
	 					->my->add ( 'localusertype', 'boss' ) 
	 	                ->my->add ( 'deleted', '0' )
	 	                ->my->add ( 'creator', '0' ) 
	 	                ->save('local_users');
	 		    }
			}
		    XN_Application::$CURRENT_URL = $application; 
		}
		else
		{ 
            $roles = XN_Query::create ( 'Content' )
                ->tag("roles")
                ->filter ( 'type', 'eic', 'roles' )
                ->filter('my.rolename','=','特赞生活')
                ->end(1)
                ->execute();
            if (count($roles) == 0)
			{
				throw new XN_Exception("特赞生活的部门不存在!");
			}
			$role_info = $roles[0];
            $roleid = $role_info->my->roleid;
			
            //获取供应商权限组id，即profilesid
            $suppliers_profiles = XN_Query::create ( 'Content' )
                ->tag("profiles")
                ->filter ( 'type', 'eic', "profiles")
                ->filter ( 'my.profilename ','=','特赞生活')
                ->filter ( 'my.deleted', '=', '0' )
                ->end(1)
                ->execute();
            if (count($suppliers_profiles) == 0)
			{
				throw new XN_Exception("特赞生活的权限不存在!");
			}
			$suppliers_profile_info = $suppliers_profiles[0];
            $profilesid = $suppliers_profile_info->id;  
           
			

		    try
			{
                $profile = XN_Profile::load($account."#".$shopcity,"username","profile");
				$profileid = $profile->profileid;
			}
		    catch ( XN_Exception $e ) 
		    {
				$profile = XN_Profile::create($email, $password);
				$profile->fullName = $account."#".$shopcity; 
				$profile->givenname = $account;
				$profile->mobile = $mobile;
				$profile->status = 'True';
				$profile->application = XN_Application::$CURRENT_URL; 
				$profile->type = "pt"; 
				$profile->reg_ip = $_SERVER['REMOTE_ADDR']; 
				$profile->money = "0";
				$profile->frozen_money = "0";
				$profile->accumulatedmoney = "0";
				$profile->save("profile"); 
			
				$profileid = $profile->profileid; 
			};
			
	 	   $Users = XN_Query::create ( 'Content' )
	 			->filter ( 'type', 'eic', 'users' )
	 		    ->filter ( 'my.deleted', '=', '0' )
				->filter ( 'my.profileid', '=', $profileid )
	 			->execute (); 
	 	   if (count($Users) == 0) 
	 	   {
				$sequence = 5000;  
	            XN_Content::create ( 'users', $account, false )
	                ->my->add ( 'profileid', $profileid )
	                ->my->add ( 'profilesid', $profilesid )
	                ->my->add ( 'currency_id', '1' )
	                ->my->add ( 'date_format', 'yyyy-mm-dd' )
	                ->my->add ( 'email1', $email )
	                ->my->add ( 'end_hour', '' )
	                ->my->add ( 'first_name', $account )
	                ->my->add ( 'hour_format', '' )
	                ->my->add ( 'imagename', '' )
	                ->my->add ( 'internal_mailer', '1' )
	                ->my->add ( 'is_admin', 'pt' )
	                ->my->add ( 'last_name', $account )
	                ->my->add ( 'lead_view', 'Today' )
	                ->my->add ( 'phone_mobile', $mobile )
	                ->my->add ( 'reminder_interval', 'None' )
	                ->my->add ( 'reports_to_id', $profileid )
	                ->my->add ( 'roleid', $roleid )
	                ->my->add ( 'signature', '' )
	                ->my->add ( 'start_hour', '' )
	                ->my->add ( 'status', 'Active' )
	                ->my->add ( 'title', '' )
	                ->my->add ( 'user_name', $account )
	                ->my->add ( 'deleted', '0' )
	                ->my->add ( 'creator', '0' )
	                ->my->add ( 'sequence', $sequence)
	                ->save('users');
		   }
	 	   
	   		if (!isset($businesseid) || $businesseid == "") 
	   		{ 
				    $longitude = $supplier_shop_info->my->longitude;
					$businessestype = $supplier_shop_info->my->businessestype;
					$productprefix = $supplier_shop_info->my->productprefix;
				    $latitude = $supplier_shop_info->my->latitude;  
					$newlatitude = round($latitude * 1000000);
					$newlongitude = round($longitude * 1000000); 
				
	                $newcontent = XN_Content::create ( 'local_businesses', '', false )
							   ->my->add ( 'supplierid', $supplierid )
			                   ->my->add ( 'uid', "" )
							   ->my->add ( 'name', $name )
							   ->my->add ( 'mobile', $mobile )
			                   ->my->add ( 'longitude', $longitude )
			                   ->my->add ( 'latitude', $latitude ) 
			                   ->my->add ( 'latitude1', $newlatitude )
			                   ->my->add ( 'longitude1', $newlongitude )
			                   ->my->add ( 'businessesstatus', '0' )
			                   ->my->add ( 'businessestype', $businessestype ) 
							   ->my->add ( 'productprefix', $productprefix ) 
							   ->my->add ( 'overall_rating', '0' )
							   ->my->add ( 'environment_rating', '0' )
							   ->my->add ( 'service_rating', '0' )
							   ->my->add ( 'taste_rating', '0' )
			                   ->my->add ( 'deleted', '0' )
			                   ->my->add ( 'creator', '0' ) 
			                   ->save('local_businesses'); 
		 		  
					$businesseid = $newcontent->id;
	   		}
 	 	    $local_users = XN_Query::create ( 'Content' )
 	 			->filter ( 'type', 'eic', 'local_users' )
 	 		    ->filter ( 'my.deleted', '=', '0' )
 				->filter ( 'my.profileid', '=', $profileid )
 	 			->execute (); 
 	 	    if (count($local_users) == 0) 
 	 	    { 
 	            XN_Content::create ( 'local_users', '', false )
 	                ->my->add ( 'profileid', $profileid )
 	                ->my->add ( 'supplierid', $supplierid )
 					->my->add ( 'businesseid', $businesseid ) 
 					->my->add ( 'account', $account )
 					->my->add ( 'email', $email )
 					->my->add ( 'mobile', $mobile )
 					->my->add ( 'password', $password ) 
 				    ->my->add ( 'status', 'Active' )
 					->my->add ( 'localusertype', 'boss' ) 
 	                ->my->add ( 'deleted', '0' )
 	                ->my->add ( 'creator', '0' ) 
 	                ->save('local_users');
 		    }
		    XN_Application::$CURRENT_URL = $application;
			$supplier_shop_info->my->profileid = $profileid;
			$supplier_shop_info->my->businesseid = $businesseid;
			$supplier_shop_info->save("supplier_shops");	 
		}  
		
		
	}
		
}?>
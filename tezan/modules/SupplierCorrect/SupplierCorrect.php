<?php
include_once('config.php'); 
require_once('include/utils/utils.php');

class SupplierCorrect extends CRMEntity {
	
	public $table_name = 'suppliercorrect';
	public $table_index= 'id';
	public $tab_name = Array('suppliercorrect');
	public $tab_name_index = Array('suppliercorrect'=>'id');
	public $customFieldTable = Array('suppliercorrect', 'id');
	public $column_fields = Array();
	public $sortby_fields = Array('suppliercorrect_no','correctsuppliers_name');
	public $list_link_field= 'correctsuppliers_name';
	public $default_order_by = 'published';
	public $default_sort_order = 'DESC';
	public $search_fields = Array(
	);
	public $search_fields_name = Array(
	);
	public $mandatory_fields = Array('suppliercorrect_no');
    public $special_search_fields = array(
        'suppliercorrectstatus' => array(
            '' => array('value'=>'All','label'=>'All','operator'=>'='),
            'Saved' => array('value'=>'Saved','label'=>'Saved','operator'=>'='),
            'Approvaling' => array('value'=>'Approvaling','label'=>'Approvaling','operator'=>'='),
            'Agree' => array('value'=>'Agree','label'=>'Agree','operator'=>'='),
            'Disagree' => array('value'=>'Disagree','label'=>'Disagree','operator'=>'='),
        ),
    );
	var $filter_fields = Array('correctsuppliers_name');
	var $sortby_number_fields = Array('suppliercorrect_no');

    function __construct() {
		$this->column_fields = getColumnFields('SupplierCorrect');
	}

	function save_module($module){}

    public function approval_event($record,$event) {
        $correct_fields=array("suppliers_name","suppliers_shortname","suppliers_username","contact","mobile","province","city",
            "company","companyaddress","bankname","accountname","bankaccount","ceo","email","bussinesslicense","organization",
            "tax","certification","idcardfront","idcardback","fujian","logo","longitude","latitude");

        $supplier_profile=array("suppliers_name"=>"companyname","suppliers_username"=>"givenname","mobile"=>"mobile","email"=>"email","bankname"=>"bank","bankaccount"=>"bankaccount","accountname"=>"bankname","companyaddress"=>"address",);
        $supplier_user=array("mobile"=>"phone_mobile","email"=>"email1");
        $lowermodule="suppliercorrect";
        if($event=="Agree"){
            //审批通过时更改审批状态，同时把不为空的内容更新到Suppliers表中，电话号码、邮箱、地址更新到profile表中
            $correctContent=XN_Content::load($record,"suppliercorrect");
            $supplier_id=$correctContent->my->supplierid;
            $supplierContent=XN_Content::load($supplier_id,"suppliers");
            foreach($correct_fields as $fieldname){
                $correct_fieldname="correct".$fieldname;
                if($correctContent->my->$correct_fieldname!=""){;
                    $supplierContent->my->$fieldname=$correctContent->my->$correct_fieldname;
                }
            }
            $supplierContent->save("suppliers");
            $profile=XN_Profile::load($supplierContent->my->pers);
            foreach($supplier_profile as $suppliername=>$profilename){
                $correctname="correct".$suppliername;
                if($correctContent->my->$correctname!=""){
                    $profile->$profilename=$correctContent->my->$correctname;
                }
            }
            if($correctContent->my->correctsuppliers_username!=""){
                $profile->fullName=$correctContent->my->correctsuppliers_username.'#'.XN_Application::$CURRENT_URL;
            }
            $profile->save ();
            $users=XN_Query::create ( 'Content' )
                ->tag("users")
                ->filter("type","=","users")
                ->filter("my.profileid","=",$profile->screenName)
                ->end(1)
                ->execute();
            $user=$users[0];
            foreach($supplier_user as $suppliername=>$username){
                $correctname="correct".$suppliername;
                if($correctContent->my->$correctname!=""){
                    $user->my->$username=$correctContent->my->$correctname;
                }
            }
            if($correctContent->my->correctsuppliers_username!=""){
                $user->title=$correctContent->my->correctsuppliers_username;
                $user->my->first_name=$correctContent->my->correctsuppliers_username;
                $user->my->last_name=$correctContent->my->correctsuppliers_username;
                $user->my->user_name=$correctContent->my->correctsuppliers_username;
            }
            $user->save("users");
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
<?php

require_once('include/utils/UserInfoUtil.php');
require_once 'include/utils/CommonUtils.php';
//require_once 'include/Webservices/Utils.php';

// User is used to store customer information.
/** Main class for the user module
 *
 */
class Users extends CRMEntity
{
    var $log;
    // Stored fields
    var $id;
    var $authenticated = false;
    var $error_string;
    var $is_admin;
    var $deleted;

    var $popup_fields = Array('user_name', 'email1', 'phone_mobile',);

    var $list_link_field = 'user_name';

    var $filter_fields = Array('user_name', 'email1',);


    var $tab_name = Array('vtiger_users', 'vtiger_attachments', 'vtiger_user2role', 'vtiger_asteriskextensions');
    var $tab_name_index = Array('vtiger_users' => 'id', 'vtiger_attachments' => 'attachmentsid', 'vtiger_user2role' => 'userid', 'vtiger_asteriskextensions' => 'userid');
    var $column_fields = Array(
        'user_name' => '',
        'is_admin' => '',
        'user_password' => '',
        'confirm_password' => '',
        'first_name' => '',
        'last_name' => '',
        'roleid' => '',
        'email1' => '',
        'status' => '',
        'birthday' => '',
        'qq' => '',
        'province' => '',
        'city' => '',
        'district' => '',
        'thumb' => '',
        'sequence' => '',
        'givename' => '',
        'title' => '',
        'reports_to_id' => '',
        'profilesid' => '',
        'phone_mobile' => '',
        'date_format' => '',
		'selectprinter'=>'',
		'selectlogistic'=>'',
    );
    var $table_name = "users";
    var $table_index = 'id';

    // This is the list of fields that are in the lists.
    //var $list_link_field= 'last_name';

    var $list_mode;
    var $popup_type;

    var $search_fields = Array(
        'Name' => Array('vtiger_users' => 'last_name'),
        'Email' => Array('vtiger_users' => 'email1')
    );
    var $search_fields_name = Array(
        'Name' => 'last_name',
        'Email' => 'email1'
    );
    public $special_search_fields = array (
        'user_type' => array (
            ''            => array ('value' => 'All', 'label' => 'All', 'operator' => '='),
            'guest'       => array ('value' => 'guest', 'label' => '外部用户', 'operator' => '='),
            'system' => array ('value' => 'system', 'label' => '平台用户', 'operator' => '=')
        )
    );
    var $module_name = "Users";

    var $object_name = "User";
    var $user_preferences;
    var $homeorder_array = array('DBSX', 'GZJX', 'ZDXM', 'GZMB', 'GZTZ', 'JDTL', 'SPZX', 'YSYF', 'GG');

    var $encodeFields = Array("first_name", "last_name", "description");

    // This is used to retrieve related fields from form posts.
    var $additional_column_fields = Array('reports_to_name');

    var $sortby_fields = Array( 'roleid',  'status',  'is_admin', 'user_type','sequence');
    var $sortby_number_fields = Array('users_no', 'sequence');

    // This is the list of vtiger_fields that are in the lists.
    // var $list_fields = Array(
    // 	'First Name'=>Array('vtiger_users'=>'first_name'),
    // 	'Last Name'=>Array('vtiger_users'=>'last_name'),
    // 	'Role Name'=>Array('vtiger_user2role'=>'roleid'),
    // 	'User Name'=>Array('vtiger_users'=>'user_name'),
    // 	'Status'=>Array('vtiger_users'=>'status'),
    // 	'Email'=>Array('vtiger_users'=>'email1'),
    // 	'Admin'=>Array('vtiger_users'=>'is_admin'),
    // 	'Profiles'=>Array('vtiger_users'=>'profilesid'),
    // 	'Mobile'=>Array('vtiger_users'=>'phone_mobile'),
    // 	'Reports To'=>Array('vtiger_users'=>'reports_to_id')
    //
    // );
    // var $list_fields_name = Array(
    // 	'Last Name'=>'last_name',
    // 	'First Name'=>'first_name',
    // 	'Role Name'=>'roleid',
    // 	'User Name'=>'user_name',
    // 	'Status'=>'status',
    // 	'Email'=>'email1',
    // 	'Admin'=>'is_admin',
    // 	'Profiles'=>'profilesid',
    // 	'Mobile'=>'phone_mobile',
    // 	'Reports To'=>'reports_to_id'
    // );

    //Default Fields for Email Templates -- Pavani
    var $emailTemplate_defaultFields = array('first_name', 'last_name', 'title', 'department', 'phone_home', 'phone_mobile', 'signature', 'email1', 'address_street', 'address_city', 'address_state', 'address_country', 'address_postalcode');

    // This is the list of fields that are in the lists.
    var $default_order_by = "sequence";
    var $default_sort_order = 'ASC';
    var $moduleNameFields = array('users' => array('last_name', 'first_name'));

    var $record_id;
    var $new_schema = true;

    var $DEFAULT_PASSWORD_CRYPT_TYPE; //'BLOWFISH', /* before PHP5.3*/ MD5;

    /** constructor function for the main user class
     * instantiates the Logger class and PearDatabase Class
     *
     */

    function __construct()
    {
        if (!isset($this->column_fields) || empty($this->column_fields)) {
            $this->column_fields = getColumnFields('Users');
        }
    }

    // Mike Crowe Mod --------------------------------------------------------Default ordering for us
    /**
     * Function to get sort order
     * return string  $sorder    - sortorder string either 'ASC' or 'DESC'
     */
    function getSortOrder()
    {
        if (isset($_REQUEST['sorder']))
            $sorder = $_REQUEST['sorder'];
        else
            $sorder = (($_SESSION['USERS_SORT_ORDER'] != '') ? ($_SESSION['USERS_SORT_ORDER']) : ($this->default_sort_order));
        return $sorder;
    }

    /**
     * Function to get order by
     * return string  $order_by    - fieldname(eg: 'subject')
     */
    function getOrderBy()
    {
        $use_default_order_by = $this->default_order_by;

        if (isset($_REQUEST['order_by']))
            $order_by = $_REQUEST['order_by'];
        else
            $order_by = (($_SESSION['USERS_ORDER_BY'] != '') ? ($_SESSION['USERS_ORDER_BY']) : ($use_default_order_by));
        return $order_by;
    }

    function retrieveCurrentUserInfoFromFile($userid)
    {
        try {
             global $global_user_privileges;
            foreach ($this->column_fields as $field => $value_iter) {
                if (isset($global_user_privileges[$field])) {
                    $this->$field = $global_user_privileges[$field];
                    $this->column_fields[$field] = $global_user_privileges[$field];
                }
            }
        } catch (XN_Exception $e) {}
        $this->id = $userid;
        return $this;
    }

    function save_module()
    {

    }

    function createProfile()
    {
        if ($this->mode == 'create') {
            try {
                $profile = XN_Profile::create($this->column_fields['email1'], $this->column_fields['user_password']);
                $profile->fullName = $this->column_fields['user_name'] . "#" . XN_Application::$CURRENT_URL;
                 
                $profile->mobile = $this->column_fields['phone_mobile'];
                $profile->status = 'True';
                $profile->application = XN_Application::$CURRENT_URL;
                if (isset($_REQUEST['city']) && $_REQUEST['district'] != '' && $_REQUEST['location'] != '') {
                    $profile->city = $_REQUEST['city'];
                    $profile->cityarea = $_REQUEST['district'];
                    $profile->location = $_REQUEST['location'];
                } else {
                    $reports_to_id = $this->column_fields['reports_to_id'];
					if (isset($reports_to_id) && $reports_to_id != "")
					{
	                    $reports_to_id_info = XN_Profile::load($reports_to_id);
	                    $profile->city = $reports_to_id_info->city;
	                    $profile->cityarea = $reports_to_id_info->cityarea;
	                    $profile->location = $reports_to_id_info->location;
					} 
                }
                $profile->type = "pt";
                $usip = $_SERVER['REMOTE_ADDR'];
                $profile->reg_ip = $usip;
                $profile->money = "0";
                $profile->frozen_money = "0";
                $profile->accumulatedmoney = "0";
                $profile->save();

                $profileid = $profile->screenName;
                $this->column_fields['profileid'] = $profileid;
                return $profileid;
            } catch (XN_Exception $e) {
                echo '{"statusCode":"300","message":"' . $e->getMessage() . '"}';
                die;
            }
        }
        return "";
    }


    /** Function to retreive the user info of the specifed user id The user info will be available in $this->column_fields array
     * @param $record -- record id:: Type integer
     * @param $module -- module:: Type varchar
     * @return $this|void
     * @throws XN_Exception
     * @throws XN_IllegalArgumentException
     */
    function retrieve_entity_info($record, $module,$datatype = 0)
    {
        global $current_user;


        if ($record == '') {

            $retrieveresult = XN_Content::create(strtolower($this->table_name), '', false)->my->add('createnew', '1')->save($this->table_name);
            $record = $retrieveresult->id;
            $this->id = $record;
            $_REQUEST['record'] = $record;
            $this->mode = 'create';
            $this->column_fields["author"] = $current_user->id;
            $this->column_fields["published"] = date("Y-m-d");
            return $this;
        }
        $tabid = getTabid($module);
        $fields = XN_Query::create('Content')->tag('Fields')
            ->filter('type', 'eic', 'fields')
            ->filter('my.tabid', '=', $tabid)
            ->filter('my.presence', 'in', array('0', '2'))
            ->execute();

        if (is_numeric($record)) {
            $user = XN_Content::load($record, 'users');
        } else {
            $users = XN_Query::create('Content')->tag('Users')
                ->filter('type', 'eic', 'users')
                ->filter('my.profileid', '=', $record)
                ->execute();
            if (count($users) > 0) {
                $user = $users[0];
            } else {
                throw new XN_Exception('Users ID(' . $record . ') error!');
            }
        }
        $this->mode = 'edit';
        foreach ($fields as $field_info) {
            $fieldname = $field_info->my->fieldname;
            $fld_value = $user->my->$fieldname;
            $this->column_fields[$fieldname] = $fld_value;
            $this->$fieldname = $fld_value;
        }
        $this->column_fields["record_id"] = $record;
        $this->column_fields["record_module"] = $module;

/*        $currency_id = $user->my->currency_id;
        $this->column_fields["currency_name"]= $this->currency_name = "China, Yuan Renminbi";
        $this->column_fields["currency_code"]= $this->currency_code = "CNY";
        $this->column_fields["currency_symbol"]= $this->currency_symbol = '¥';
        $this->column_fields["conv_rate"]= $this->conv_rate = 1.000;*/



        $this->id = $record;
        $this->column_fields["author"] = $user->contributorName;
        $this->column_fields["published"] = date("Y-m-d", strtotime($user->createdDate));
        $this->column_fields["updated"] = date("Y-m-d", strtotime($user->updatedDate));
        $this->column_fields["deleted"] = $user->my->deleted;
        return $this;
    }
}
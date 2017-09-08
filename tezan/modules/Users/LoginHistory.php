<?php

    class LoginHistory
    {
        // Stored vtiger_fields
        var $login_id;
        var $user_name;
        var $user_ip;
        var $login_time;
        var $logout_time;
        var $status;
        var $module_name   = "Users";
        var $table_name    = "vtiger_loginhistory";
        var $object_name   = "LoginHistory";
        var $new_schema    = true;
        var $column_fields = Array ("id"
                                    , "login_id"
                                    , "user_name"
                                    , "user_ip"
                                    , "login_time"
                                    , "logout_time"
                                    , "status"
        );

        function LoginHistory()
        {
        }

        var $sortby_fields      = Array ('user_name', 'user_ip', 'login_time', 'logout_time', 'status');
        var $list_fields        = Array (
            'User Name'    => Array ('vtiger_loginhistory' => 'user_name'),
            'User IP'      => Array ('vtiger_loginhistory' => 'user_ip'),
            'Signin Time'  => Array ('vtiger_loginhistory' => 'login_time'),
            'Signout Time' => Array ('vtiger_loginhistory' => 'logout_time'),
            'Status'       => Array ('vtiger_loginhistory' => 'status'),
        );
        var $list_fields_name   = Array (
            'User Name'    => 'user_name',
            'User IP'      => 'user_ip',
            'Signin Time'  => 'login_time',
            'Signout Time' => 'logout_time',
            'Status'       => 'status'
        );
        var $default_order_by   = "published";
        var $default_sort_order = 'DESC';

        /**
         * Function to get the Header values of Login History.
         * Returns Header Values like UserName, IP, LoginTime etc in an array format.
         **/
        function getHistoryListViewHeader()
        {
            global $app_strings;
            $header_array = array ($app_strings['LBL_LIST_USER_NAME'], $app_strings['LBL_LIST_USERIP'], $app_strings['LBL_LIST_SIGNIN'], $app_strings['LBL_LIST_SIGNOUT'], $app_strings['LBL_LIST_STATUS']);

            return $header_array;
        }

        /**
         * Function to get the Login History values of the User.
         *
         * @param $navigation_array - Array values to navigate through the number of entries.
         * @param $sortorder        - DESC
         * @param $orderby          - login_time
         *                          Returns the login history entries in an array format.
         **/
        function getHistoryListViewEntries($username, $navigation_array, $sorder = '')
        {
            global $current_user;
            $loginhistory_query = XN_Query::create('BigContent')->tag("Loginhistorys")
                ->filter('type', 'eic', 'loginhistorys')
                ->filter('my.user_name', '=', $username);
            if ($sorder != '' && $order_by != '')
            {
                if ($sorder == 'DESC')
                {
                    $loginhistory_query->order('my.'.$order_by, XN_Order::DESC);
                }
                else
                {
                    $loginhistory_query->order('my.'.$order_by, XN_Order::ASC);
                }
            }
            else
            {
                if ($this->default_sort_order == 'DESC')
                {
                    $loginhistory_query->order($this->default_order_by, XN_Order::DESC);
                }
                else
                {
                    $loginhistory_query->order($this->default_order_by, XN_Order::ASC);
                }
            }
            $loginhistory_query->begin($navigation_array ['start'] - 1)->end($navigation_array ['end_val']);
            $loginhistorys = $loginhistory_query->execute();
            $entries_list  = array ();
            foreach ($loginhistorys as $loginhistory_info)
            {
                $entries         = array ();
                $entries []      = $loginhistory_info->my->user_name;
                $entries []      = $loginhistory_info->my->user_ip;
                $entries []      = $loginhistory_info->my->login_time;
                $entries []      = $loginhistory_info->my->logout_time;
                $entries []      = $loginhistory_info->my->status;
                $entries_list [] = $entries;
            }

            return $entries_list;
        }

        /** Function that Records the Login info of the User
         *
         * @param ref variable $usname :: Type varchar
         * @param ref variable $usip :: Type varchar
         * @param ref variable $intime :: Type timestamp
         *            Returns the query result which contains the details of User Login Info
         */
        function user_login($profileid, $usname, $usip, $intime)
        {
            try
            {
                $content  = XN_Content::create('loginhistorys', $usname, false, 1)
                    ->my->add('user_name', $usname)
                    ->my->add('user_id', $profileid)
                    ->my->add('user_ip', $usip)
                    ->my->add('logout_time', '-')
                    ->my->add('login_time', $intime)
                    ->my->add('status', 'Signed in')
                    ->save("loginhistorys,loginhistorys_".$profileid);
                $loginInfo  = array ();
                $loginInfo["thisloginip"]   = $usip;
                $loginInfo["thislogintime"] = $intime;
                XN_MemCache::put($loginInfo, "logintime_".$profileid);
            }
            catch (XN_Exception $e)
            {
                echo $e->getMessage()."<br>";
            }
        }

        /** Function that Records the Logout info of the User
         *
         * @param ref variable $usname :: Type varchar
         * @param ref variable $usip :: Type varchar
         * @param ref variable $outime :: Type timestamp
         *            Returns the query result which contains the details of User Logout Info
         */
        function user_logout(&$profileid, &$usname, &$usip, &$outtime)
        {
            try
            {
                $content = XN_Content::create('loginhistorys', $usname, false, 1)
                    ->my->add('user_name', $usname)
                    ->my->add('user_id', $profileid)
                    ->my->add('user_ip', $usip)
                    ->my->add('logout_time', $outtime)
                    ->my->add('login_time', '-')
                    ->my->add('status', 'Signed off')
                    ->save("Loginhistorys");
            }
            catch (XN_Exception $e)
            {
                echo $e->getMessage()."<br>";
            }
        }
    }

?>

<?php

require_once('utils.php');

global $log;
global $g_block_id;
global $g_field_id;

global $fieldinfo;

$g_block_id = 0;
$g_field_id = 0;
$fieldinfo = array();

$log = '开始初始化...<br>';

function  re_initdata()
{
    global $log;
    try
    {
        $application =  XN_Application::$CURRENT_URL;

        $app = XN_Application::load($application);
        if ( $app->name == null)
        {
            throw new XN_Exception('企业代码['.$application.']没有创建!');
        }
        $app->trialtime = "2020-01-01";
        $app->remainnumberofsmss = 99999;
        $app->numberofsmss = 100;
        $app->save(XN_Application::$CURRENT_URL);
        $author = $app->ownerName;
        try
        {
            $profile = XN_Profile::load ($author );
            $profile->type = "admin";
            $profile->money = "0";
            $profile->frozen_money = "0";
            $profile->accumulatedmoney = "0";
            $profile->save("profile,profile_".$profile->screenName);

        }
        catch ( XN_Exception $e )
        {
            $application = XN_Application::$CURRENT_URL;
            $profile = XN_Profile::create ( strtolower(trim($application)), '123qwe' );
            $profile->fullName = strtolower('admin'.'#'.$application);
            $profile->mobile = trim('');
            $profile->status = 'True';
            $profile->profileid = $author;
            $profile->application = trim($application);
            $profile->givenname = 'admin';
            $profile->type = "admin";
            $profile->money = "0";
            $profile->frozen_money = "0";
            $profile->accumulatedmoney = "0";
            $profile->save ();
            throw new XN_Exception("创建用户没有创建!");
        }

        XN_Profile::$VIEWER = $profile->screenName;
        $log .= '企业代码['.$app->description.']成功<br>';
        $log .= '企业域名为:'.$application.'<br>';

        createroles();

        create_user();


        create_parent_tabs();

        make_eventhandlers();

        make_ws_operations();

        create_global_ws_fieldtypes();




        //create_workflows();




        $tabs = XN_Query::create ( 'Content' )
            ->filter ( 'type', 'eic', 'tabs' )
            ->end(-1)
            ->execute ();
        XN_Content::delete($tabs,'tabs');

        init_all_module();


 

        $profiles = XN_Query::create ( 'Content' )->tag('profiles')
            ->filter ( 'type', 'eic', 'profiles' )
            ->filter ( 'my.deleted', '=', '0' )
            ->filter ( 'my.profilename', '!=', 'Boss' )
            ->begin(0)->end(-1)
            ->execute ();
        if (count($profiles) > 0)
        {
            foreach($profiles as $profiles_info)
            {
                initprofilebyname($profiles_info->my->profilename);
            }
            initprofilebyname("标准读写权限");
        }
        else
        {
            initprofilebyname("标准读写权限");
        } 

        init_select_program(); 

        $log .= '初始化完毕!';

        $intime=strtotime();
        XN_MemCache::put($intime,"lastinittime_".XN_Application::$CURRENT_URL);

        session_start();
        session_destroy();
        XN_Profile::signOut();
        setcookie("xn_id_".XN_Application::$CURRENT_URL,"", time()-3600,'/');

        return $log;

    }
    catch ( XN_Exception $e )
    {
        $log .= $e->getMessage () . "<br>";
        return $log;
    }
}

function  init_application()
{
    global $log;
    try
    {
        $application =  XN_Application::$CURRENT_URL;
        $app = XN_Application::load($application);
        if ( $app->name == null)
        {
            throw new XN_Exception('企业代码['.$application.']没有创建!');
        }
        $author = $app->ownerName;
        try
        {
            $profile = XN_Profile::load ($author );
            $profile->money = "0";
            $profile->frozen_money = "0";
            $profile->accumulatedmoney = "0";
            $profile->save("profile,profile_".$profile->screenName);
        }
        catch ( XN_Exception $e )
        {
            throw new XN_Exception("创建用户没有创建!");
        }

        XN_Profile::$VIEWER = $profile->screenName;

        $log .= '企业代码['.$app->description.']成功<br>';
        $log .= '企业域名为:'.$application.'<br>';

        createroles();

        create_user(); 

        create_parent_tabs();

        make_eventhandlers();

        create_global_ws_fieldtypes();

 

        //create_workflows();



        $tabs = XN_Query::create ( 'Content' )
            ->filter ( 'type', 'eic', 'tabs' )
            ->end(-1)
            ->execute ();
        XN_Content::delete($tabs,'tabs');

        XN_MemCache::delete("session_".XN_Application::$CURRENT_URL);
        

        init_all_module();
 

        init_select_program(); 

        XN_MemCache::put("false","run_initapp_".$application);
    }
    catch ( XN_Exception $e )
    {
        throw $e;
    }
    return $log;
}


function  initdata($application,$enterprise,$username,$password,$email,$mobile)
{
    global $log;
    try
    {
        try
        {
            $profile = XN_Profile::create ( strtolower(trim($email)), $password );
            $profile->fullName = strtolower($username.'#'.$application);
            $profile->mobile = trim($mobile);
            $profile->status = 'True';
            $profile->application = trim($application);
            $profile->givenname = $username;
            $profile->type = "admin";
            $profile->money = "0";
            $profile->frozen_money = "0";
            $profile->accumulatedmoney = "0";
            $profile->save ();
            //$profile = XN_Profile::load ( $email ,"email");
        }
        catch ( XN_Exception $e )
        {
            throw new XN_Exception("创建用户失败!");
        }
        $log .= '创建用户['.$username.']成功<br>';
        XN_Profile::$VIEWER = $profile->screenName;
        $applicationname = strtolower(trim($application));
        try
        {
            $props = array('name' => $applicationname,'description' => trim($enterprise));
            $app = XN_Application::create($applicationname,"",$props);
            $app->save();
        }
        catch ( XN_Exception $e )
        {
            throw new XN_Exception('创建企业代码['.$application.']失败!');
        }
        XN_Application::$CURRENT_URL = $applicationname;
        //XN_Application::$CURRENT_URL = "xingyunkeji";
        $log .= '创建企业代码['.$application.']成功<br>';
        $log .= '企业默认域名为:'.$applicationname.'<br>';

        $newbuf = '感谢您选择SaaSw,创建企业用户['.$application.'],数据初始化时间较长<br>请耐心等待！';
        XN_MemCache::put($newbuf,"run_initapp_".$application);

        if (strpos($_SERVER["SERVER_SOFTWARE"],"nginx") !==false)
        {
            $domain=$_SERVER['HTTP_HOST'];
        }
        else
        {
            $domain=$_SERVER['SERVER_NAME'];
        }

        $domainArray=explode('.',$domain);
        $domainArray[0] = '';
        $site = implode('.',$domainArray).':'.$_SERVER['SERVER_PORT'];
        $web_root = $domain.':'.$_SERVER['SERVER_PORT'];

        XN_Content::create('callback', '',false,2)
            ->my->add('application',strtolower(XN_Application::$CURRENT_URL))
            ->my->add('site',$site)
            ->my->add('webroot',$web_root)
        //->my->add('site','.361crm.com')
        //->my->add('site',':7000')
            ->my->add('status','waiting')
            ->my->add('type','initprofile')
            ->save("callback");
        if(isset($_REQUEST['program']) && $_REQUEST['program'] != '')
        {
            $programs = $_REQUEST['program'];
            foreach($programs as $program)
            {
                $newcontent = XN_Content::create('programs','',false);
                $newcontent->my->name  = $program;
                $newcontent->my->status  = "0";
                $newcontent->save("programs");
            }
        }
        return 'SUCCESS';

    }
    catch ( XN_Exception $e )
    {
        $log .= $e->getMessage () . "<br>";
        return $log;
    }
}
 
function init_select_program()
{
    $results = XN_Query::create ( 'Content' )->tag ( 'programs' )
        ->filter ( 'type', 'eic', 'programs' )
        ->filter ( 'my.status', '=', '0' )
        ->execute ();
    if (count($results) >0)
    {
        require ($_SERVER['DOCUMENT_ROOT'].'/admin/config.program.php');
        $allowprograms = array();
        foreach($results as $program_info)
        {
            $allowprograms[] = $program_info->my->name;
        }
        foreach($programs as $key => $program_info)
        {
            if (!in_array($key,$allowprograms))
            {
                $tabids = $program_info['tabid'];
                $parenttabs = $program_info['parenttab'];
                if (count($parenttabs) > 0)
                {
                    $parenttabs = XN_Query::create ( 'Content' )->tag ( 'parenttabs' )
                        ->filter ( 'type', 'eic', 'parenttabs' )
                        ->filter ( 'my.parenttabname', 'in', $parenttabs )
                        ->filter ( 'my.presence', '!=', "1")
                        ->execute ();
                    if (count($parenttabs) >0)
                    {
                        foreach($parenttabs as $parenttab_info)
                        {
                            $parenttab_info->my->presence = "1";
                            $parenttab_info->save('parenttabs');
                        }

                    }
                }
                if (count($tabids) > 0)
                {
                    $tabs = XN_Query::create ( 'Content' )->tag ( 'tabs' )
                        ->filter ( 'type', 'eic', 'tabs' )
                        ->filter ( 'my.tabid', 'in', $tabids )
                        ->filter ( 'my.presence', '!=', "1")
                        ->end(-1)
                        ->execute ();
                    if (count($tabs) >0)
                    {
                        foreach($tabs as $tab_info)
                        {
                            $tab_info->my->presence = "1";
                            $tab_info->save('tabs');
                        }
                    }
                }
            }
        }
        global $log;
        $log .= '初始化程序功能选择成功<br>';
    }
}

function init_all_module()
{
    $cf_fields = XN_Query::create ( 'Content' )
        ->filter ( 'type', 'eic', 'fields' )
        ->filter ( 'my.fieldname', 'like', 'cf_' )
        ->begin(0)
        ->end(-1)
        ->execute ();
    $excludefields = array();
    foreach ( $cf_fields as $cf_field_info)
    {
        $excludefields[] = $cf_field_info->id;
    }
    if(count($excludefields) >0)
    {
        $fields = XN_Query::create ( 'Content' )
            ->filter ( 'type', 'eic', 'fields' )
            ->filter ( 'id', '!in', $excludefields )
            ->begin(0)
            ->end(-1)
            ->execute ();
    }
    else
    {
        $fields = XN_Query::create ( 'Content' )
            ->filter ( 'type', 'eic', 'fields' )
            ->begin(0)
            ->end(-1)
            ->execute ();
    }

    foreach ( array_chunk($fields,50,true) as $chunk_fields)
    {
        XN_Content::delete($chunk_fields,'fields');
    }

    $def_org_shares = XN_Query::create ( 'Content' )->tag('def_org_shares')
        ->filter ( 'type', 'eic', 'def_org_shares' )
        ->begin(0)->end(-1)
        ->execute ();
    XN_Content::delete($def_org_shares,'def_org_shares');


    $common_modules = array("Announcements","Calendar","ApprovalFlows","ApprovalCenters","Approvals","Domains","Profiles","Users");

    $b2b_modules = array(  
        'Local_Profile','Local_Businesses','Local_Districts','Local_Streets','Local_VipCards',
        'Local_Products','Local_Orders','Local_Categorys','Local_ShopAd','Local_ShopPackage',
        'Local_Payments','Local_BillWaters','Local_Commissions','Local_ShoppingCarts',
        'Local_Usages','Local_Inventorys','Local_StockinStorages','Local_SalesOutStorages','Local_Turnovers',
        'Local_PushSet','Local_ShopSet','Local_Users','Local_Brands','Local_PropertyCorrect',
        'Local_Shares','Local_ConsumeLogs','Local_ReturnedGoodsApplys','Local_Reimburses','Local_Appraises',
        'Local_SalesActivitys','Local_Reserves','Local_DiningDesks','Local_DiningDeskPrinters','Local_Cashiers','Local_Shifts',
		'Local_Debts','Local_DebtLogs','Local_Agios','Local_AgioLogs','Local_RoundLogs','Local_Couriers',
		'Local_DailyInventorys','Local_Waiters','Local_Cooks','Local_Stalls',"Local_Joke","Local_Show",
		'Local_Orders_Products','Local_DailyStatistics','Local_DiningDeskLogs','Local_PrintQueues',
		'Local_AntiCashiers','Local_CashierItems',
    ); 

    $allowapps = array("cs","sh","fs","wh",'bj','hh','sz','gz','cd','bz','hy','sy','dt',
        'lf','sm','sp','ly','zw','yz','xt','tj','dg','wlmq',
        'hz','cq','nj','zz','xa','dl','qd','suz','ty','km','nn','shy',
        'heb','sjz','cc','hf','nc','gy','fz','lz','jn','hk',
        'nb','wz','yw','sx','gl','wx','xuz','yic','say','cde','yoz','chz','zjj',
    );

    foreach ( modules_list() as $module)
    {
        if (in_array(XN_Application::$CURRENT_URL,$allowapps))
        {
            if (in_array($module,$b2b_modules) || in_array($module,$common_modules))
            {
                init_module($module);
            }
        }
        else
        {
            if (!in_array($module,$b2b_modules))
            {
                init_module($module);
            }
        }
    }
    foreach ( $cf_fields as $cf_field_info)
    {
        $tabid = $cf_field_info->my->tabid;
        $cf_blocks = XN_Query::create ( 'Content' )
            ->filter ( 'type', 'eic', 'blocks' )
            ->filter ( 'my.tabid', '=', $tabid )
            ->order('my.sequence',XN_Order::ASC_NUMBER)
            ->begin(0)
            ->end(-1)
            ->execute ();
        if (count($cf_blocks) > 0 )
        {
            $cf_block_info = $cf_blocks[0];
            if ($cf_field_info->my->blockid != $cf_block_info->my->blockid)
            {
                $cf_field_info->my->blockid = $cf_block_info->my->blockid;
                $cf_field_info->save("fields");
            }
        }
    }
}



function init_module($module)
{
    global $log;
    $datafile = $_SERVER['DOCUMENT_ROOT'].'/modules/'.$module.'/config.data.php';
    if (@file_exists($datafile))
    {
        require($datafile);
        if (is_array($config_tabs ))
            create_tabs($tabid,$module,$config_tabs);
        if (is_array($Config_Blocks ))
        {
            $blockarray = create_blocks($tabid,$module,$Config_Blocks);
            if (count($blockarray) > 0 && is_array($Config_Fields ))
            {
                create_fields($tabid,$module,$blockarray,$Config_Fields);
            }
        }
        if (is_array($Config_CustomViews ))
            create_customviews($tabid,$module,$Config_CustomViews);
        if (is_array($Config_Ws_Entitys ))
            create_ws_entitys($tabid,$module,$Config_Ws_Entitys);
        if (is_array($Config_Entitynames ))
            create_ws_entitynames($tabid,$module,$Config_Entitynames);
        if (is_array($config_searchcolumn)) create_searchcolumn($tabid,$module,$config_searchcolumn);
        if (is_array($config_advancesearch)) create_advancesearch($tabid, $module, $config_advancesearch);
        if (is_array($config_modentity_nums)) create_modentity_nums($tabid,$module,$config_modentity_nums);
        if (is_array($config_fieldmodulerels)) create_fieldmodulerels($tabid,$module,$config_fieldmodulerels);
        if (is_array($config_ws_fieldtypes)) create_ws_fieldtypes($tabid,$module,$config_ws_fieldtypes);
        if (is_array($config_ws_referencetypes)) create_ws_referencetypes($tabid,$module,$config_ws_referencetypes);
        if (is_array($config_picklists)) create_picklists($tabid,$module,$config_picklists);
        //if (is_array($config_initdata) && $_GET['initdata']) create_initdata($module,$multi_db,$config_initdata);

        if ($config_tabs['isentitytype'] == '1')
        {
            if (isset($def_org_shares))
            {
                XN_Content::create('def_org_shares','',false)
                    ->my->add('tabid',$tabid)
                    ->my->add('permission',$def_org_shares)
                    ->my->add ('editstatus','0')
                    ->save('def_org_shares');
            }
            else
            {
                XN_Content::create('def_org_shares','',false)
                    ->my->add('tabid',$tabid)
                    ->my->add('permission','3')
                    ->my->add ('editstatus','0')
                    ->save('def_org_shares');
            }
        }

        $log .= '初始化子模块['.$module.']成功<br>';
    }


    $datafile = $_SERVER['DOCUMENT_ROOT'].'/modules/'.$module.'/config.field.php';
    if (@file_exists($datafile))
    {
        require($datafile);
        if (is_array($fields ) && count($fields) > 0)
        {
            $approvalfields = XN_Query::create ( 'Content' )
                ->filter ( 'type', 'eic', 'approvalfields' )
                ->filter ( 'my.module', '=', $module )
                ->begin(0)
                ->end(-1)
                ->execute ();
            if (count($approvalfields) > 0 )
            {
                XN_Content::delete($approvalfields,'approvalfields');
            }
            $objs = array();
            $sequence = 1;
            foreach ($fields as $fieldname => $field_info)
            {
                if ($field_info['approval'])
                {
                    $newcontent = XN_Content::create('approvalfields','',false);
                    $newcontent->my->module = $module;
                    $newcontent->my->fieldname = $fieldname;
                    $newcontent->my->fieldlabel = $field_info['label'];
                    $newcontent->my->width = $field_info['width'];
                    $newcontent->my->align = $field_info['align'];
                    $newcontent->my->sequence = $sequence;
                    $objs[] = $newcontent;
                    $sequence++;
                }
            }
            if (count($objs) > 0)
            {
                XN_Content::batchsave($objs,"approvalfields");
            }
        }
    }
}

 



function createroles() {
    global $log;
    try {
        $roles = XN_Query::create ( 'Content' )->filter ( 'type', 'eic', 'roles' )->begin ( 0 )->end ( -1 )->execute ();
        if (count ( $roles ) == 0)
        {

            $objs = array();
            $objs[] = XN_Content::create ( 'roles', '组织', false )
                ->my->add ( 'roleid', 'H1' )
                ->my->add ( 'rolename', "组织" )
                ->my->add ( 'parentrole', 'H1' )
                ->my->add ( 'depth', "0" )
                ->my->add ( 'sequence', "1" );
            $objs[] = XN_Content::create ( 'roles', 'CEO', false )
                ->my->add ( 'roleid', 'H2' )
                ->my->add ( 'rolename', "CEO" )
                ->my->add ( 'parentrole', 'H1::H2' )
                ->my->add ( 'depth', "1" )
                ->my->add ( 'sequence', "1" );
            $objs[] = XN_Content::create ( 'roles', '', false )
                ->my->add ( 'roleid', 'H3' )
                ->my->add ( 'rolename', "销售总监" )
                ->my->add ( 'parentrole', 'H1::H2::H3' )
                ->my->add ( 'depth', "1" )
                ->my->add ( 'sequence', "1" );
            $objs[] = XN_Content::create ( 'roles', '', false )
                ->my->add ( 'roleid', 'H4' )
                ->my->add ( 'rolename', "销售一部" )
                ->my->add ( 'parentrole', 'H1::H2::H3::H4' )
                ->my->add ( 'depth', "1" )
                ->my->add ( 'sequence', "1" );
            $objs[] = XN_Content::create ( 'roles', '', false )
                ->my->add ( 'roleid', 'H5' )
                ->my->add ( 'rolename', "销售二部" )
                ->my->add ( 'parentrole', 'H1::H2::H3::H5' )
                ->my->add ( 'depth', "1" )
                ->my->add ( 'sequence', "2" );
            $objs[] = XN_Content::create ( 'roles', '', false )
                ->my->add ( 'roleid', 'H6' )
                ->my->add ( 'rolename', "储运部" )
                ->my->add ( 'parentrole', 'H1::H2::H6' )
                ->my->add ( 'depth', "1" )
                ->my->add ( 'sequence', "2" );
            $objs[] = XN_Content::create ( 'roles', '', false )
                ->my->add ( 'roleid', 'H7' )
                ->my->add ( 'rolename', "技术支持部" )
                ->my->add ( 'parentrole', 'H1::H2::H7' )
                ->my->add ( 'depth', "1" )
                ->my->add ( 'sequence', "2" );
            $objs[] = XN_Content::create ( 'roles', '', false )
                ->my->add ( 'roleid', 'H8' )
                ->my->add ( 'rolename', "财务部" )
                ->my->add ( 'parentrole', 'H1::H2::H8' )
                ->my->add ( 'depth', "1" )
                ->my->add ( 'sequence', "2" );
            $objs[] = XN_Content::create ( 'roles', '', false )
                ->my->add ( 'roleid', 'H9' )
                ->my->add ( 'rolename', "市场部" )
                ->my->add ( 'parentrole', 'H1::H2::H9' )
                ->my->add ( 'depth', "1" )
                ->my->add ( 'sequence', "2" );
            XN_Content::batchsave($objs,"roles");
            $log .= '初始化部门树成功<br>';

        }

    } catch ( XN_Exception $e )
    {
        throw new XN_Exception($module."初始化部门树失败!<br>");
    }
}

function initadminprofile()
{
    global $log;
    try
    {


        $profiles = XN_Query::create ( 'Content' )
            ->filter ( 'type', 'eic', 'profiles' )
            ->filter ( 'my.profilename', '=', 'Boss' )
            ->begin(0)->end(-1)
            ->execute ();
        if (count($profiles) == 0)
        {
            $Administrator = XN_Content::create('profiles','',false);
            $Administrator->my->profilename  = 'Boss';
            $Administrator->my->description   = 'BOSS权限，超级删除控制';
            $Administrator->my->allowdeleted = 0;
            $Administrator->my->deleted = 0;
            $Administrator->my->superdeleted = 0;
            $Administrator->my->profiles_no  = "GW1";
            $Administrator->save('profiles');

            return $Administrator->id;
        }
        else
        {
            $Administrator = $profiles[0];
            if (is_null($Administrator->my->profiles_no))
            {
                $Administrator->my->profiles_no  = "GW1";
                $Administrator->save('profiles');
            }
            return $Administrator->id;
        }
        $log .= '初始化BOSS权限成功<br>';
    } catch ( XN_Exception $e ) {
        throw new XN_Exception($module."初始化BOSS权限失败!<br>");
    }
}
 

function initprofilebyname($name)
{
    global $log;
    try
    {

        $profiles = XN_Query::create ( 'Content' )->tag('profiles')
            ->filter ( 'type', 'eic', 'profiles' )
            ->filter ( 'my.profilename', '=', $name )
            ->filter ( 'my.deleted', '=', '0' )
            ->begin(0)->end(-1)
            ->execute ();
        if (count($profiles) == 0)
        {

            $Administrator = XN_Content::create('profiles','',false);
            $Administrator->my->profilename  = $name;
            $Administrator->my->description   = $name;
            $Administrator->my->globalactionpermission1  = 0;
            $Administrator->my->globalactionpermission2   = 0;
            $Administrator->my->allowdeleted = 1;
            $Administrator->my->deleted = 0;
            if ($name == "标准读写权限")
                $Administrator->my->allowdeleted = 0;
            $Administrator->save('profiles');

            $profileid = $Administrator->id;
        }
        else
        {
            $Administrator = $profiles[0];
            $profileid = $Administrator->id;
        }

        init_profile($profileid);

        $log .= '初始化'.$name.'权限成功<br>';
    } catch ( XN_Exception $e ) {
        throw new XN_Exception($module."初始化'.$name.'权限失败!<br>");
    }
}

function init_profile($profileid)
{
    global $fieldinfo;

    $tabs = XN_Query::create ( 'Content' )->tag('tabs')
        ->filter ( 'type', 'eic', 'tabs' )
        ->filter (XN_Filter::any(XN_Filter( 'my.isentitytype', '=', '1'),XN_Filter( 'my.isentitytype', '=', '2')))
        ->order('my.tabsequence',XN_Order::DESC)
        ->begin(0)->end(-1)
        ->execute ();
    $tabinfos = array();
    foreach ($tabs as $tab_info)
    {
        $tabid = $tab_info->my->tabid;
        $module = $tab_info->my->tabname;
        $tabinfos[$tabid] = $module;
    }
    $objs = array();
    $profile2tabs = XN_Query::create ( 'Content' )->tag('profile2tabs')
        ->filter ( 'type', 'eic', 'profile2tabs' )
        ->filter ( 'my.profileid', '=', $profileid)
        ->begin(0)->end(-1)
        ->execute ();
    $profile_2_tabs = array();
    foreach($profile2tabs as $profile2tab_info)
    {
        $tabid = $profile2tab_info->my->tabid;
        $profile_2_tabs[] = $tabid;
    }
    foreach($tabinfos as $tabid => $module)
    {
        if (!in_array($tabid,$profile_2_tabs))
        {
            $objs[] = XN_Content::create ( 'profile2tabs', '', false )
                ->my->add ( 'tabid', $tabid )
                ->my->add ( 'profileid', $profileid )
                ->my->add ( 'permissions', '1' );
        }
    }
    if (count($objs) > 0)
    {
        XN_Content::batchsave($objs,"profile2tabs");
    }


    //
    $objs = array();
    $profile2standardpermissions = XN_Query::create ( 'Content' )->tag('profile2standardpermissions')
        ->filter ( 'type', 'eic', 'profile2standardpermissions' )
        ->filter ( 'my.profileid', '=', $profileid)
        ->begin(0)->end(-1)
        ->execute ();
    $profile_2_standardpermissions = array();
    foreach($profile2standardpermissions as $profile2standardpermission_info)
    {
        $tabid = $profile2standardpermission_info->my->tabid;
        $profile_2_standardpermissions[] = $tabid;
    }
    foreach($tabinfos as $tabid => $module)
    {
        if (!in_array($tabid,$profile_2_standardpermissions))
        {
            $permissions =  array ( 'EditView' => 1,  'Delete' => 1, 'Index' => 1,);
            foreach ( $permissions as   $actionname => $permissions )
            {
                $objs[] = XN_Content::create ( 'profile2standardpermissions', '', false )
                    ->my->add ( 'tabid', $tabid )
                    ->my->add ( 'profileid', $profileid )
                    ->my->add ( 'actionname', $actionname )
                    ->my->add ( 'permissions', $permissions );

            }
        }
    }
    if (count($objs) > 0)
    {
        XN_Content::batchsave($objs,"profile2standardpermissions");
    }


    $objs = array();

    $profile2fields = XN_Query::create ( 'Content' )->tag('profile2fields')
        ->filter ( 'type', 'eic', 'profile2fields' )
        ->filter ( 'my.profileid', '=', $profileid)
        ->begin(0)->end(-1)
        ->execute ();
    $profile_2_fields = array();
    foreach($profile2fields as $profile2field_info)
    {
        $tabid = $profile2field_info->my->tabid;
        $fieldid = $profile2field_info->my->fieldid;
        $profile_2_fields[$tabid][] = $fieldid;
    }

    foreach($tabinfos as $tabid => $module)
    {
        $fielddata = $fieldinfo[$tabid];
        if (isset($fielddata) && is_array($fielddata))
        {
            foreach ($fielddata as $field_id => $field_v)
            {
                if (!in_array($field_id,$profile_2_fields[$tabid]))
                {
                    $objs[] = XN_Content::create ( 'profile2fields', '', false )
                        ->my->add ( 'tabid', $tabid )
                        ->my->add ( 'profileid', $profileid )
                        ->my->add ( 'fieldid', $field_id )
                        ->my->add ( 'fieldname', $field_v )
                        ->my->add ( 'visible', '0' )
                        ->my->add ( 'readonly', '1' );
                }
            }
        }
    }

    if (count($objs) > 0)
    {
        foreach ( array_chunk($objs,50,true) as $chunk_objs)
        {
            XN_Content::batchsave($chunk_objs,'profile2fields');
        }
    }


    $objs = array();

    $profile2utilitys = XN_Query::create ( 'Content' )->tag('profile2utilitys')
        ->filter ( 'type', 'eic', 'profile2utilitys' )
        ->filter ( 'my.profileid', '=', $profileid)
        ->execute ();
    $profile_2_utilitys = array();
    foreach($profile2utilitys as $profile2utility_info)
    {
        $tabid = $profile2utility_info->my->tabid;
        $activity = $profile2utility_info->my->activity;
        $profile_2_utilitys[$tabid][] = $activity;
    }

    foreach($tabinfos as $tabid => $module)
    {
        $datafile = $_SERVER['DOCUMENT_ROOT'].'/modules/'.$module.'/config.inc.php';
        if (@file_exists($datafile))
        {
            require($datafile);
            if(isset($actionmapping) && count($actionmapping) > 0)
            {
                foreach ($actionmapping as $actionmapping_info)
                {
                    $activity = $actionmapping_info['actionname'];
                    $securitycheck = $actionmapping_info['securitycheck'];
                    $type = $actionmapping_info['type'];
                    if (($type == 'ajax' || $type == 'button' || $type == 'listview') && $securitycheck == '0')
                    {
                        if (!in_array($activity,$profile_2_utilitys[$tabid]))
                        {
                            $objs[] = XN_Content::create('profile2utilitys','',false)
                                ->my->add('tabid',$tabid)
                                ->my->add('profileid', $profileid )
                                ->my->add('permission','0')
                                ->my->add('activity',$activity) ;
                        }
                    }
                }
            }
        }
    }

    if (count($objs) > 0)
    {
        foreach ( array_chunk($objs,50,true) as $chunk_objs)
        {
            XN_Content::batchsave($chunk_objs,'profile2utilitys');
        }
    }


}


function  create_picklists($tabid,$module,$config_picklists)
{
    try {
        $objs = array();
        foreach ($config_picklists as $picklists_info)
        {
            $name = $picklists_info['name'];

            $picklists = XN_Query::create ( 'Content' )
                ->filter ( 'type', 'eic', 'picklists' )
                ->filter ( 'my.name', '=', $name )
                ->begin(0)->end(-1)
                ->execute ();
            XN_Content::delete($picklists,'picklists');
            $sequence = 1;
            foreach ($picklists_info['picklist'] as  $picklist_info){
                $newcontent = XN_Content::create('picklists','',false)->my->add('name',$name);
                $newcontent->my->$name = $picklist_info[0];
                $newcontent->my->presence = $picklist_info[1];
                $newcontent->my->tabid = $tabid;
                $newcontent->my->sequence = $sequence;
                $newcontent->my->picklist_valueid = $picklist_info[2];
                if(isset($picklist_info[3]))
                {
                    foreach ($picklist_info[3] as $k => $v)
                    {
                        $newcontent->my->$k = $v;
                    }
                }
                $objs[] = $newcontent;
                $sequence = $sequence + 1;
            }

        }
        XN_Content::batchsave($objs,"picklists");
    } catch ( XN_Exception $e ) {
        throw new XN_Exception($module."的picklists建立失败!<br>");
    }
}

function create_fieldmodulerels($tabid,$module,$config_fieldmodulerels)
{
    global $fieldinfo;
    try {
        $fieldmodulerels = XN_Query::create ( 'Content' )
            ->filter ( 'type', 'eic', 'fieldmodulerels' )
            ->filter ( 'my.tabid', '=', $tabid )
            ->execute ();
        XN_Content::delete($fieldmodulerels,'fieldmodulerels');

        foreach ($config_fieldmodulerels as $fieldmodulerel_info)
        {
            $fieldname = $fieldmodulerel_info['fieldname'];

            $fielddata = $fieldinfo[$tabid];

            foreach ($fielddata as $field_id => $field_v)
            {
                if ($field_v == $fieldname)
                {
                    $fieldid = $field_id;
                    $newcontent = XN_Content::create('fieldmodulerels','',false);
                    foreach ($fieldmodulerel_info as $k => $v){
                        $newcontent->my->$k = $v;
                    }
                    $newcontent->my->fieldid = $fieldid;
                    $newcontent->my->tabid = $tabid;
                    $newcontent->save('fieldmodulerels');
                }
            }
        }
    } catch ( XN_Exception $e ) {
        throw new XN_Exception($module."的fieldmodulerels建立失败!<br>");
    }
}


function create_ws_fieldtypes($tabid,$module,$config_ws_fieldtypes)
{
    try {
        $objs = array();
        foreach ($config_ws_fieldtypes as $ws_fieldtypes_info)
        {
            $ws_fieldtypes = XN_Query::create ( 'Content' )
                ->filter ( 'type', 'eic', 'ws_fieldtypes' )
                ->filter ( 'my.uitype', '=', $ws_fieldtypes_info['uitype'] )
                ->execute ();
            if ( count($ws_fieldtypes) == 0)
            {
                $newcontent = XN_Content::create('ws_fieldtypes','',false);
                $newcontent->my->uitype = $ws_fieldtypes_info['uitype'];
                $newcontent->my->fieldtype = $ws_fieldtypes_info['fieldtype'];
                $objs[] = $newcontent;
            }else if ( count($ws_fieldtypes) > 0)
            {
                XN_Content::delete($ws_fieldtypes,'ws_fieldtypes');
                $newcontent = XN_Content::create('ws_fieldtypes','',false);
                $newcontent->my->uitype = $ws_fieldtypes_info['uitype'];
                $newcontent->my->fieldtype = $ws_fieldtypes_info['fieldtype'];
                $objs[] = $newcontent;
            }

        }
        XN_Content::batchsave($objs,"ws_fieldtypes");

    } catch ( XN_Exception $e ) {
        throw new XN_Exception($module."的ws_fieldtypes建立失败!<br>");
    }
}

function create_ws_referencetypes($tabid,$module,$config_ws_referencetypes)
{
    try {
        $objs = array();
        foreach ($config_ws_referencetypes as $ws_referencetype_info)
        {
            $ws_fieldtypes = XN_Query::create ( 'Content' )
                ->filter ( 'type', 'eic', 'ws_fieldtypes' )
                ->filter ( 'my.uitype', '=', $ws_referencetype_info['uitype'] )
                ->execute ();
            if ( count($ws_fieldtypes) > 0)
            {
                $ws_fieldtype_info = $ws_fieldtypes[0];
                $fieldtypeid = $ws_fieldtype_info->id;

                $ws_referencetypes = XN_Query::create ( 'Content' )
                    ->filter ( 'type', 'eic', 'ws_referencetypes' )
                    ->filter ( 'my.uitype', '=', $ws_referencetype_info['uitype'] )
                    ->filter ( 'my.type', '=', $ws_referencetype_info['type'] )
                    ->filter ( 'my.fieldtypeid', '=', $fieldtypeid )
                    ->execute();
                if ( count($ws_referencetypes) == 0)
                {
                    $newcontent = XN_Content::create('ws_referencetypes','',false);
                    $newcontent->my->uitype = $ws_referencetype_info['uitype'];
                    $newcontent->my->type = $ws_referencetype_info['type'];
                    $newcontent->my->fieldtypeid = $fieldtypeid;
                    $objs[] = $newcontent;
                }
            }
        }
        XN_Content::batchsave($objs,"ws_referencetypes");
    } catch ( XN_Exception $e ) {
        throw new XN_Exception($module."的ws_referencetypes建立失败!<br>");
    }
}
function create_modentity_nums($tabid,$module,$config_modentity_nums)
{
    try {
        $modentity_nums = XN_Query::create ( 'Content' )
            ->filter ( 'type', 'eic', 'modentity_nums' )
            ->filter ( XN_Filter::any(XN_Filter ('my.semodule', '=', $module ),XN_Filter( 'my.tabid', '=', $tabid )))
            ->execute ();

        if (count($modentity_nums) != 1)
        {
            if (count($modentity_nums) > 0)
            {
                XN_Content::delete($modentity_nums,'modentity_nums');
            }

            foreach ($config_modentity_nums as $modentity_num_info)
            {
                $newcontent = XN_Content::create('modentity_nums','',false);
                foreach ($modentity_num_info as $k => $v){
                    $newcontent->my->$k = $v;
                }
                $newcontent->my->tabid = $tabid;
                $newcontent->my->semodule = $module;
                $newcontent->my->date  = date("ymd");
                $newcontent->save('modentity_nums');
            }
        }
        else
        {
            $modentity_num = $modentity_nums[0];
            $config_modentity_num = $config_modentity_nums[0];
            if ($config_modentity_num['prefix'] != $modentity_num->my->prefix)
            {
                $modentity_num->my->prefix = $config_modentity_num['prefix'];
                $modentity_num->save('modentity_nums');
            }
        }
    } catch ( XN_Exception $e ) {
        throw new XN_Exception($module."的modentity_nums建立失败!<br>");
    }

}

function create_ws_entitynames($tabid,$module,$Config_Entitynames)
{
    try {
        $entitynames = XN_Query::create ( 'Content' )
            ->filter ( 'type', 'eic', 'entitynames' )
            ->filter ( 'my.tabid', '=', $tabid )
            ->execute ();

        XN_Content::delete($entitynames,'entitynames');

        $objs = array();

        foreach ($Config_Entitynames as $field_info)
        {
            $newcontent = XN_Content::create('entitynames','',false);
            foreach ($field_info as $k => $v){
                $newcontent->my->$k = $v;
            }
            $newcontent->my->tabid = $tabid;
            $newcontent->my->modulename = $module;
            $objs[] = $newcontent;
        }
        XN_Content::batchsave($objs,"entitynames");
    } catch ( XN_Exception $e ) {
        throw new XN_Exception($module."的entitynames建立失败!<br>");
    }

}


function create_ws_entitys($tabid,$module,$Config_Ws_Entitys)
{
    try {
        $ws_entityss = XN_Query::create ( 'Content' )
            ->filter ( 'type', 'eic', 'ws_entitys' )
            ->filter ( XN_Filter::any(XN_Filter ('my.name', '=', $module ),XN_Filter( 'my.tabid', '=', $tabid )))
            ->execute ();

        XN_Content::delete($ws_entityss,'ws_entitys');

        $objs = array();
        foreach ($Config_Ws_Entitys as $ws_entitys_info)
        {
            $newcontent = XN_Content::create('ws_entitys','',false);
            foreach ($ws_entitys_info as $k => $v)
            {
                $newcontent->my->$k = $v;
            }
            $newcontent->my->tabid = $tabid;
            $newcontent->my->name = $module;
            $objs[] = $newcontent;
        }
        XN_Content::batchsave($objs,"ws_entitys");
    } catch ( XN_Exception $e ) {
        throw new XN_Exception($module."的ws_entitys建立失败!<br>");
    }


}



function create_customviews($tabid,$module,$Config_CustomViews)
{
    try {
        $customviews = XN_Query::create ( 'Content' )
            ->filter ( 'type', 'eic', 'customviews' )
            ->filter ( XN_Filter::any(XN_Filter ('my.entitytype', '=', $module ),XN_Filter( 'my.tabid', '=', $tabid )))
            ->execute ();
        XN_Content::delete($customviews,'customviews');

        $cvcolumnlists = XN_Query::create ( 'Content' )
            ->filter ( 'type', 'eic', 'cvcolumnlists' )
            ->filter ( 'my.tabid', '=', $tabid )
            ->execute ();
        XN_Content::delete($cvcolumnlists,'customviews');

        foreach ($Config_CustomViews as  $customview_info){
            $newcontent = XN_Content::create('customviews','',false);
            $newcontent->my->viewname = $customview_info['viewname'];
            $newcontent->my->setdefault = $customview_info['setdefault'];
            $newcontent->my->setmetrics = $customview_info['setmetrics'];
            $newcontent->my->entitytype = $customview_info['entitytype'];
            $newcontent->my->status = $customview_info['status'];
            $profile = XN_Profile::current();
            $newcontent->my->userid = $profile->screenName;
            $newcontent->my->tabid = $tabid;
            $newcontent->my->init = '1';
            $newcontent->my->entitytype = $module;
            $newcontent->save('Customviews');
            $cvid = $newcontent->id;
            $objs = array();
            foreach ($customview_info['cvcolumnlist'] as  $key=>$cvcolumnlist_info){
                $newcontent = XN_Content::create('cvcolumnlists','',false);
                $newcontent->my->columnindex = $key;
                $newcontent->my->columnname = $cvcolumnlist_info;
                $newcontent->my->cvid = $cvid;
                $newcontent->my->tabid = $tabid;
                $objs[] = $newcontent;
            }
            XN_Content::batchsave($objs,"cvcolumnlists");
        }
    } catch ( XN_Exception $e ) {
        throw new XN_Exception($module."的customviews建立失败!<br>");
    }
}

function create_advancesearch($tabid,$module,$config_advancesearch) {
    try {
        $result = XN_Query::create ( 'Content' )
            ->filter ( 'type', 'eic', 'advancesearch' )
            ->filter ( XN_Filter::any(XN_Filter ('my.entitytype', '=', $module ),XN_Filter( 'my.tabid', '=', $tabid )))
            ->execute ();
        XN_Content::delete($result,'advancesearch');

        $searchcondition = XN_Query::create ( 'Content' )
            ->filter ( 'type', 'eic', 'searchcondition' )
            ->filter ( 'my.tabid', '=', $tabid )
            ->execute ();
        XN_Content::delete($searchcondition,'searchcondition');

        foreach ($config_advancesearch as  $advancesearch_info){
            $newcontent = XN_Content::create('advancesearch','',false);
            $newcontent->my->searchname = $advancesearch_info['searchname'];
            $newcontent->my->setdefault = $advancesearch_info['setdefault'];
            $newcontent->my->entitytype = $advancesearch_info['entitytype'];
            $profile = XN_Profile::current();
            $newcontent->my->userid = $profile->screenName;
            $newcontent->my->tabid = $tabid;
            $newcontent->save('Advancesearch');
            $searchid = $newcontent->id;
            foreach ($advancesearch_info['searchcondition'] as  $searchcondition_info){
                $newcontent = XN_Content::create('searchcondition','',false);
                $newcontent->my->searchcondition = $searchcondition_info;
                $newcontent->my->searchid = $searchid;
                $newcontent->my->tabid = $tabid;
                $newcontent->save('Searchcondition');
            }
        }
    } catch ( XN_Exception $e ) {
        throw new XN_Exception($module."的advancesearch建立失败!<br>");
    }
}


function create_fields($tabid,$module,$blockarray,$Config_Fields)
{
    global $g_field_id;
    global $fieldinfo;
    try {

        $field_data = array();
        $g_field_id = $tabid * 200;
        if (isset($Config_Fields) && is_array($Config_Fields))
        {
            $objs = array();
            foreach ($Config_Fields as $field_info)
            {
                if (isset($field_info) && is_array($field_info))
                {
                    $newcontent = XN_Content::create('fields','',false);
                    foreach ($field_info as $k => $v){
                        $newcontent->my->$k = $v;
                    }
                    $newcontent->my->tabid = $tabid;
                    $g_field_id = $g_field_id + 1;
                    $newcontent->my->fieldid = $g_field_id;
                    $blockid = $field_info['block'];
                    $newcontent->my->block = $blockarray[$blockid];
                    $objs[] = $newcontent;
                    $field_data[$g_field_id] = $newcontent->my->fieldname;
                }
            }
            XN_Content::batchsave($objs,"fields");
        }
        $fieldinfo[$tabid] = $field_data;
    }catch ( XN_Exception $e )
    {
        throw new XN_Exception($module."的fields建立失败!<br>");
    }

}

function create_blocks($tabid,$module,$Config_Blocks)
{
    global $g_block_id;
    try {
        $blocks = XN_Query::create ( 'Content' )
            ->filter ( 'type', 'eic', 'blocks' )
            ->filter ( 'my.tabid', '=', $tabid )
            ->execute ();
        XN_Content::delete($blocks,'blocks');
        $objs = array();
        $blockarray = array();
        foreach ($Config_Blocks as $key => $block_info)
        {
            $newcontent = XN_Content::create('blocks','',false);
            foreach ($block_info as $k => $v){
                $newcontent->my->$k = $v;
            }
            $newcontent->my->tabid = $tabid;
            $g_block_id = $g_block_id + 1;
            $newcontent->my->blockid = $g_block_id;
            $objs[] = $newcontent;
            $blockarray[$key]=$g_block_id;
        }
        XN_Content::batchsave($objs,"blocks");
        return $blockarray;

    }catch ( XN_Exception $e )
    {
        throw new XN_Exception($module."的blocks建立失败!<br>");
    }
}
function create_tabs($tabid,$module,$config_tabs)
{
    try {
        $tabs = XN_Query::create ( 'Content' )
            ->filter ( 'type', 'eic', 'tabs' )
            ->filter ( 'my.tabid', '=', $tabid )
            ->end(-1)
            ->execute ();
        if (count ( $tabs ) > 0)
        {
            $tab_info = $tabs[0];
            $update = false;
            foreach ($config_tabs as $k => $v)
            {
                if($tab_info->my->$k != $v)
                {
                    $update = true;
                    $tab_info->my->$k  = $v;
                }
            }
            if ($update)
            {
                $tab_info->save('tabs');
            }
        } else
        {
            $newcontent = XN_Content::create('tabs','',false);
            $newcontent->my->tabid = $tabid;
            foreach ($config_tabs as $k => $v)
            {
                $newcontent->my->$k = $v;
            }
            $newcontent->save('tabs');
        }
    } catch ( XN_Exception $e )
    {
        throw new XN_Exception($module."的tabs建立失败!<br>");
    }
}

function create_searchcolumn($tabid,$module,$config_searchcolumn)
{
    try {
        $searchcolumn = XN_Query::create ( 'Content' )
            ->filter ( 'type', 'eic', 'searchcolumn' )
            ->filter ( 'my.tabid', 'eic', $tabid)
            ->execute ();

        XN_Content::delete($searchcolumn,'searchcolumn');
        $objs = array();
        foreach ($config_searchcolumn as $searchcolumn_info)
        {
            $newcontent = XN_Content::create('searchcolumn','',false);
            foreach ($searchcolumn_info as $k => $v){
                $newcontent->my->$k = $v;
            }
            $newcontent->my->tabid = $tabid;
            $objs[] = $newcontent;
        }
        XN_Content::batchsave($objs,"searchcolumn");

    } catch ( XN_Exception $e ) {
        throw new XN_Exception($module."的searchcolumn建立失败!<br>");
    }


}

function create_initdata_on_db($module,$config_initdata)
{
    try {
        $data = XN_Query::create ( 'Content' )
            ->filter ( 'type', 'eic', strtolower($module) )
            ->execute ();
        XN_Content::delete($data,strtolower($module));

        foreach ($config_initdata as $data_info)
        {
            $newcontent = XN_Content::create(strtolower($module),'',false);
            foreach ($data_info as $k => $v){
                $newcontent->my->$k = $v;
            }
            $newcontent->save(strtolower($module));
        }
    } catch ( XN_Exception $e ) {
        throw new XN_Exception($module."的初始数据建立失败!<br>");
    }
}

function create_initdata($module,$multi_db,$config_initdata)
{
    try {
        if($multi_db){
            foreach ($config_initdata as $tabname => $data_value){
                create_initdata_on_db($tabname,$data_value);
            }
        }else
            create_initdata_on_db($module,$config_initdata);

    } catch ( XN_Exception $e ) {
        echo $e->getMessage () . "<br>";
    }
}



function create_user()
{
    global $log;
    try {

        $profile = XN_Profile::current ();
        $users = XN_Query::create ( 'Content' )
            ->filter ( 'type', 'eic', 'Users' )
            ->filter ( 'my.profileid', '=', $profile->screenName )
            ->execute ();

        $temp = explode("#",$profile->fullName);

        $username = $temp[0];

        $last_name = $username;
        if (count($users) > 0)
        {
            $user = $users[0];
            $last_name = $user->my->last_name;
            $roleid = $user->my->roleid;
            XN_Content::delete($users,'Users');
        }
        else
        {
            $roleid = 'H2';
        }


        $profilesid = initadminprofile();

        XN_Content::create ( 'users', $username, false )
            ->my->add ( 'profileid', $profile->screenName )
            ->my->add ( 'profilesid', $profilesid )
            ->my->add ( 'currency_id', '1' )
            ->my->add ( 'date_format', 'yyyy-mm-dd' )
            ->my->add ( 'email1', $profile->email )
            ->my->add ( 'end_hour', '' )
            ->my->add ( 'first_name', $username )
            ->my->add ( 'hour_format', '' )
            ->my->add ( 'imagename', '' )
            ->my->add ( 'internal_mailer', '1' )
            ->my->add ( 'is_admin', 'admin' )
            ->my->add ( 'user_type', 'system' )
            ->my->add ( 'last_name', $last_name )
            ->my->add ( 'lead_view', 'Today' )
            ->my->add ( 'phone_mobile', $profile->mobile )
            ->my->add ( 'reminder_interval', 'None' )
            ->my->add ( 'reports_to_id', $profile->screenName )
            ->my->add ( 'roleid', $roleid )
            ->my->add ( 'signature', '' )
            ->my->add ( 'start_hour', '' )
            ->my->add ( 'status', 'Active' )
            ->my->add ( 'title', '' )
            ->my->add ( 'user_name', $username )
            ->my->add ( 'deleted', '0' )
            ->my->add ( 'creator', '1' )
            ->my->add ( 'sequence', '1' )
            ->my->add ( 'users_no', 'YF1' )
            ->save('users');

        $modentity_nums = XN_Query::create ( 'Content' )
            ->filter ( 'type', 'eic', 'modentity_nums' )
            ->filter (  'my.tabid', '=', '29' )
            ->execute ();

        $cur_id = 2;

        if (count($modentity_nums) > 0)
        {
            $modentity_num = $modentity_nums[0];
            $cur_id = intval($modentity_num->my->cur_id);
        }
        else
        {
            $modentity_num = XN_Content::create('modentity_nums','',false);
            $modentity_num->my->tabid = '29';
            $modentity_num->my->semodule  = 'Users';
            $modentity_num->my->prefix  = 'YF';
            $modentity_num->my->start_id  = '1';
            $modentity_num->my->cur_id   = '2';
            $modentity_num->my->active   = '1';
            $modentity_num->my->date  = date("ymd");
            $modentity_num->save('modentity_nums');
        }


        $users = XN_Query::create ( 'Content' )
            ->filter ( 'type', 'eic', 'Users' )
            ->filter ( 'my.profileid', '!=', $profile->screenName )
            ->end(-1)
            ->execute ();
        if (count($users) > 0)
        {
            $sequence = 100;
            foreach ($users as $user)
            {
                if (is_null($user->my->users_no)  || is_null($user->my->sequence) )
                {
                    if (is_null($user->my->sequence))
                    {
                        $user->my->sequence = 50;
                    }

                    if (is_null($user->my->users_no))
                    {
                        $cur_id = $cur_id;
                        $user->my->users_no = "YF".$cur_id;
                        $cur_id = $cur_id + 1;
                    }
                    $user->save('users');
                }
            }
        }

        if (intval($modentity_num->my->cur_id) != $cur_id)
        {
            $modentity_num->my->cur_id  = $cur_id;
            $modentity_num->save('modentity_nums');
        }


        $log .= '创建企业管理用户['.$profile->fullName.']成功<br>';
    } catch ( XN_Exception $e ) {
        throw new XN_Exception("创建企业管理用户失败!");
    }
}
function create_parent_tabs()
{
    global $log;
    try {
        $parenttabs = XN_Query::create ( 'Content' )
            ->filter ( 'type', 'eic', 'parenttabs' )
            ->execute ();
        XN_Content::delete($parenttabs,'parenttabs');

        require ($_SERVER['DOCUMENT_ROOT'].'/admin/config.tabs.php');
        $objs = array();
        $sequence = 1;
        foreach ($Config_ParentTabs as $parenttabname => $tabnames)
        {
            $newcontent = XN_Content::create('parenttabs','',false)
                ->my->add('parenttabname',$parenttabname)
                ->my->add('sequence',$sequence)
                ->my->add('presence','0');
            $sequence = $sequence + 1;
            $newcontent->my->tabname = $tabnames;
            $objs[] = $newcontent;
        }

        XN_Content::batchsave($objs,"parenttabs");
        $log .= '创建主菜单成功<br>'; 

    }catch ( XN_Exception $e )
    {
        throw new XN_Exception("创建主菜单失败!<br>");
    }
}



function make_eventhandlers()
{
    global $log;
    try {
        $wsentitys = XN_Query::create ( 'Content' )->filter ( 'type', 'eic', 'eventhandlers' )->execute ();
        if (count ( $wsentitys ) > 0) {
            XN_Content::delete($wsentitys,'eventhandlers');
        }
        require ('config.eventhandlers.php');
        foreach ($Config_contacts as  $link_info){
            $newcontent = XN_Content::create('eventhandlers','',false);
            foreach ($link_info as $k => $v){
                $newcontent->my->$k = $v;
            }
            $newcontent->save('Eventhandlers');
        }
        $log .= '创建Eventhandlers成功!<br>';

    } catch ( XN_Exception $e ) {
        throw new XN_Exception("创建Eventhandlers失败!<br>");

    }
}

function make_ws_operations()
{
    global $log;
    try {
        $wsentitys = XN_Query::create ( 'Content' )->filter ( 'type', 'eic', 'ws_operations' )->execute ();
        if (count ( $wsentitys ) > 0) {
            XN_Content::delete($wsentitys,'ws_operations');
        }
        require ('config.ws.php');

        foreach ($Config_ws_operations as $key => $content_info)
        {
            $newcontent = XN_Content::create('ws_operations','',false);
            foreach ($content_info as $k => $v)
            {
                $newcontent->my->$k = $v;
            }
            $newcontent->save('Ws_operations');
            foreach ($Config_ws_operation_parameters as  $content_o_info)
            {
                if ($key == $content_o_info['operationid'])
                {
                    $new_o_content = XN_Content::create('ws_operation_parameters','',false);
                    foreach ($content_o_info as $k => $v)
                    {
                        $new_o_content->my->$k = $v;
                    }
                    $new_o_content->my->operationid = $newcontent->id;
                    $new_o_content->save('Ws_operation_parameters');
                }
            }
        }
        $log .= '创建ws_operations成功!<br>';

    } catch ( XN_Exception $e ) {
        throw new XN_Exception("创建ws_operations失败!<br>");

    }
}




function create_global_ws_fieldtypes()
{
    global $log;
    try {
        $Config_ws_fieldtypes = array(
            array('uitype' => '15','fieldtype' => 'picklist',),
            array('uitype' => '16','fieldtype' => 'picklist',),
            array('uitype' => '115','fieldtype' => 'picklist',),
            array('uitype' => '116','fieldtype' => 'picklist',),
            array('uitype' => '117','fieldtype' => 'picklist',),
            array('uitype' => '33','fieldtype' => 'picklist',),
            array('uitype' => '133','fieldtype' => 'picklist',),
            array('uitype' => '121','fieldtype' => 'multipicklist',),
            array('uitype' => '221','fieldtype' => 'multipicklist',),
            array('uitype' => '533','fieldtype' => 'multipicklist',),
            array('uitype' => '534','fieldtype' => 'multipicklist',),
            array('uitype' => '19','fieldtype' => 'text',),
            array('uitype' => '20','fieldtype' => 'text',),
            array('uitype' => '21','fieldtype' => 'text',),
            array('uitype' => '24','fieldtype' => 'text',),
            array('uitype' => '3','fieldtype' => 'autogenerated',),
            array('uitype' => '11','fieldtype' => 'phone',),
            array('uitype' => '17','fieldtype' => 'url',),
            array('uitype' => '85','fieldtype' => 'skype',),
            array('uitype' => '56','fieldtype' => 'boolean',),
            array('uitype' => '156','fieldtype' => 'boolean',),
            array('uitype' => '53','fieldtype' => 'owner',),
            array('uitype' => '54','fieldtype' => 'owner',),
            array('uitype' => '61','fieldtype' => 'file',),
            array('uitype' => '28','fieldtype' => 'file',),
            array('uitype' => '50','fieldtype' => 'reference',),
            array('uitype' => '51','fieldtype' => 'reference',),
            array('uitype' => '57','fieldtype' => 'reference',),
            array('uitype' => '58','fieldtype' => 'reference',),
            array('uitype' => '73','fieldtype' => 'reference',),
            array('uitype' => '75','fieldtype' => 'reference',),
            array('uitype' => '76','fieldtype' => 'reference',),
            array('uitype' => '78','fieldtype' => 'reference',),
            array('uitype' => '80','fieldtype' => 'reference',),
            array('uitype' => '81','fieldtype' => 'reference',),
            array('uitype' => '101','fieldtype' => 'owner',),
            array('uitype' => '52','fieldtype' => 'reference',),
            array('uitype' => '357','fieldtype' => 'reference',),
            array('uitype' => '59','fieldtype' => 'reference',),
            array('uitype' => '66','fieldtype' => 'reference',),
            array('uitype' => '77','fieldtype' => 'reference',),
            array('uitype' => '68','fieldtype' => 'reference',),
            array('uitype' => '117','fieldtype' => 'reference',),
            array('uitype' => '26','fieldtype' => 'reference',),
            array('uitype' => '10','fieldtype' => 'reference',),
            array('uitype' => '207','fieldtype' => 'owner',),
            array('uitype' => '225','fieldtype' => 'owner',),
        );

        $ws_fieldtypes = XN_Query::create ( 'Content' )
            ->filter ( 'type', 'eic', 'ws_fieldtypes' )
            ->begin(0)
            ->end(-1)
            ->execute ();

        foreach ( array_chunk($ws_fieldtypes,50,true) as $chunk_ws_fieldtypes)
        {
            XN_Content::delete($chunk_ws_fieldtypes,'ws_fieldtypes');
        }

        $objs = array();
        foreach ($Config_ws_fieldtypes as $ws_fieldtypes_info)
        {
            $ws_fieldtypes = XN_Query::create ( 'Content' )
                ->filter ( 'type', 'eic', 'ws_fieldtypes' )
                ->filter ( 'my.uitype', '=', $ws_fieldtypes_info['uitype'] )
                ->execute ();
            if ( count($ws_fieldtypes) == 0)
            {
                $newcontent = XN_Content::create('ws_fieldtypes','',false);
                $newcontent->my->uitype = $ws_fieldtypes_info['uitype'];
                $newcontent->my->fieldtype = $ws_fieldtypes_info['fieldtype'];
                $objs[] = $newcontent;
            }else if ( count($ws_fieldtypes) > 1)
            {
                foreach ($ws_fieldtypes as $ws_fieldtype)
                {
                    XN_Content::delete($ws_fieldtype,'ws_fieldtypes');
                }
                $newcontent = XN_Content::create('ws_fieldtypes','',false);
                $newcontent->my->uitype = $ws_fieldtypes_info['uitype'];
                $newcontent->my->fieldtype = $ws_fieldtypes_info['fieldtype'];
                $objs[] = $newcontent;
            }

        }
        XN_Content::batchsave($objs,"ws_fieldtypes");
        $log .= '创建ws_fieldtypes成功!<br>';

    } catch ( XN_Exception $e ) {
        throw new XN_Exception("创建ws_fieldtypes失败!<br>");
    }
}

 



 



function check_modentity_nums($tabid,$semodule,$prefix,$current_id)
{
    $modentity_nums = XN_Query::create ( 'Content' )
        ->filter ( 'type', 'eic', 'modentity_nums' )
        ->filter (  'my.tabid', '=', $tabid )
        ->execute ();

    if (count($modentity_nums) > 0)
    {
        $modentity_num = $modentity_nums[0];
        $cur_id = intval($modentity_num->my->cur_id);
        if ($current_id > $cur_id)
        {
            $modentity_num->my->cur_id   = $current_id;
            $modentity_num->my->active   = '1';
            $modentity_num->save('modentity_nums');
        }
    }
    else
    {
        $modentity_num = XN_Content::create('modentity_nums','',false);
        $modentity_num->my->tabid = $tabid;
        $modentity_num->my->semodule  = $semodule;
        $modentity_num->my->prefix  = $prefix;
        $modentity_num->my->start_id  = '1';
        $modentity_num->my->cur_id   = $current_id;
        $modentity_num->my->active   = '1';
        $modentity_num->my->date  = date("ymd");
        $modentity_num->save('modentity_nums');
    }
}




?>

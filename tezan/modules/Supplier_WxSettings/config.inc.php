<?php$Create = false;$Delete = false;$MassEdit = false;$CustomMassDelete = false;//任何人只能添加一个公众号$suppliers = XN_Query::create('Content')->tag('suppliers')    ->filter('type', 'eic', 'suppliers')    ->filter('my.deleted', '=', '0')    ->filter('my.pers', '=', XN_Profile::$VIEWER)    ->execute();if (count($suppliers) > 0){    $supplier_info = $suppliers[0];    $supplier_wxsettings = XN_Query::create("Content")->tag("supplier_wxsettings")        ->filter('type', 'eic', 'supplier_wxsettings')        ->filter('my.deleted', '=', '0')        ->filter('my.supplierid', '=', $supplier_info->id)        ->begin(0)        ->end(1)        ->execute();    if (count($supplier_wxsettings) == 0)    {        $Create = true;    }}if (!function_exists('checkNewMenuItem')){    function checkNewMenuItem($module, $focus)    {        $wxmenus = XN_Query::create('Content')->tag('wxmenus')            ->filter('type', 'eic', 'wxmenus')            ->filter('my.record', '=', $focus->id)            ->filter('my.parentid', '=', '0')            ->end(-1)            ->execute();        if (count($wxmenus) >= 3)        {            return '<a disabled class="btn btn-default" data-icon="lock">新建一级菜单(最多三个)</a>';        }        else        {            return '<a data-fresh="false" data-height="300"  data-width="800" data-icon="edit"  data-mask="true" data-toggle="dialog" href="index.php?module=Supplier_WxSettings&amp;action=WxMenuItem&amp;wxid=' . $focus->id . '" class="btn btn-default" >新建一级菜单</a>';        }    }}if (!function_exists('checkAppMenuItem')){    function checkAppMenuItem($module, $focus)    {        return '<a data-fresh="false" data-height="240"  data-icon="edit" data-mask="true" data-toggle="dialog" href="index.php?module=Supplier_WxSettings&amp;action=AppMenuItem&amp;wxid=' . $focus->id . '" class="btn btn-default" >新建指定应用菜单</a>';    }}if (!function_exists('checkSpecialMenuItem')){    function checkSpecialMenuItem($module, $focus)    {        return '<a data-fresh="false" data-height="240"  data-icon="edit" data-mask="true" data-toggle="dialog" href="index.php?module=Supplier_WxSettings&amp;action=SpecialMenuItem&amp;wxid=' . $focus->id . '" class="btn btn-default" >新建特殊菜单</a>';    }}if (!function_exists('checkSynchroWxMenus')){    function checkSynchroWxMenus($module, $focus)    {        return '<a data-fresh="false" data-height="240"  data-icon="edit" data-mask="true" data-toggle="dialog" href="index.php?module=Supplier_WxSettings&amp;action=SynchroWxMenus&amp;wxid=' . $focus->id . '" class="btn btn-default" >同步微信菜单</a>';    }}if (!function_exists('LoginAuthorization_func')){    function LoginAuthorization_func()    {        global $supplierid, $supplierusertype;        $redirect_uri = 'http://admin.tezan.cn/weixin/notify.php';        if (isset($supplierid) && $supplierid != "" && $supplierusertype == 'boss')            //return '<a href="https://mp.weixin.qq.com/cgi-bin/componentloginpage?component_appid=wxb0098bff4b72372b&pre_auth_code=e3d48e9727f80795a250bbf892f55004&redirect_uri='.urlencode($redirect_uri).'" class="edit" fresh="false" height="180"  mask="true" target="dialog" width="600"><span>微信公众号登录授权</span></a>';            return '<a href="https://mp.weixin.qq.com/cgi-bin/componentloginpage?component_appid=wxb0098bff4b72372b&pre_auth_code=e3d48e9727f80795a250bbf892f55004&redirect_uri=' . urlencode($redirect_uri) . '" data-icon="weixin" class="btn btn-default" target="_blank" ><span>微信公众号登录授权</span></a>';        else            return "";    }}$actionmapping = array(    array('actionname' => 'WxMenus', 'securitycheck' => '1', 'type' => 'ajax', 'location' => 'bottom'),    array('actionname' => 'AppMenuItem', 'securitycheck' => '1', 'type' => 'button', 'func' => 'checkAppMenuItem'),    array('actionname' => 'SpecialMenuItem', 'securitycheck' => '1', 'type' => 'button', 'func' => 'checkSpecialMenuItem'),    array('actionname' => 'WxMenuItem', 'securitycheck' => '1', 'type' => 'button', 'func' => 'checkNewMenuItem'),    array('actionname' => 'SynchroWxMenus', 'securitycheck' => '1', 'type' => 'button', 'func' => 'checkSynchroWxMenus'),    array('actionname' => 'LoginAuthorization', 'securitycheck' => '1', 'func' => 'LoginAuthorization_func', 'type' => 'listview'),);?>
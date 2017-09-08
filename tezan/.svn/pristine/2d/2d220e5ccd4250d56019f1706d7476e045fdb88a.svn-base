<?php
/**
 * 管理目录配置文件
 *
 * @version        $Id: config.php 1 14:31 2010年7月12日Z tianya $
 * @package        CMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.oldhand.cn/usersguide/license.html
 * @link           http://www.oldhand.cn
 */
define('SAASADMIN', str_replace("\\", '/', dirname(__FILE__) ) );
require_once($_SERVER['DOCUMENT_ROOT'].'/include/html/common.inc.php');
header('Cache-Control:private');
 
$cfg_admin_skin = 1; // 后台管理风格






//管理缓存、管理员频道缓存
$cache1 = $_SERVER['DOCUMENT_ROOT'].'/cache/'.XN_Application::$CURRENT_URL.'/inc_catalog_base.inc';

if(!file_exists($cache1)) UpDateCatCache();


//更新服务器
require_once (SAASDATA.'/admin/config_update.php');

/**
 *  更新栏目缓存
 *
 * @access    public
 * @return    void
 */
function UpDateCatCache()
{
    global $dsql, $cache1, $cacheFile, $cuserLogin;
    $cache2 = SAASDATA.'/cache/channelsonlist.inc';
    $cache3 = SAASDATA.'/cache/channeltoplist.inc';

	$arctypes = XN_Query::create ( 'Content' )->tag('arctype')
					->filter ( 'type', 'eic', 'arctype')
					->filter ( 'my.deleted', '=', '0')
					->execute ();
  
    $fp1 = fopen($cache1,'w');
    $phph = '?';
    $fp1Header = "<{$phph}php\r\nglobal \$cfg_Cs;\r\n\$cfg_Cs=array();\r\n";
    fwrite($fp1,$fp1Header);

	foreach($arctypes as $arctype_info)
    {
        // 将typename缓存起来
        $typename = base64_encode($arctype_info->my->typename);
        fwrite($fp1,"\$cfg_Cs[".$arctype_info->my->arcid."]=array(".$arctype_info->my->reid.",".$arctype_info->my->channeltype.",".$arctype_info->my->issend.",'".$arctype_info->my->typename."');\r\n");
    }
    fwrite($fp1, "{$phph}>");
    fclose($fp1);
    @unlink($cache2);
    @unlink($cache3);
}

// 清空选项缓存
function ClearOptCache()
{
    $tplCache = SAASDATA.'/tplcache/';
    $fileArray = glob($tplCache."inc_option_*.inc");
    if (count($fileArray) > 1)
    {
        foreach ($fileArray as $key => $value)
        {
            if (file_exists($value)) unlink($value);
            else continue;
        }
        return TRUE;
    }
    return FALSE;
}

/**
 *  更新会员模型缓存
 *
 * @access    public
 * @return    void
 */
function UpDateMemberModCache()
{
    global $dsql;
    $cachefile = SAASDATA.'/cache/member_model.inc';

    $dsql->SetQuery("SELECT * FROM `#@__member_model` WHERE state='1'");
    $dsql->Execute();
    $fp1 = fopen($cachefile,'w');
    $phph = '?';
    $fp1Header = "<{$phph}php\r\nglobal \$_MemberMod;\r\n\$_MemberMod=array();\r\n";
    fwrite($fp1,$fp1Header);
    while($row=$dsql->GetObject())
    {
        fwrite($fp1,"\$_MemberMod[{$row->id}]=array('{$row->name}','{$row->table}');\r\n");
    }
    fwrite($fp1,"{$phph}>");
    fclose($fp1);
}

/**
 *  引入模板文件
 *
 * @access    public
 * @param     string  $filename  文件名称
 * @param     bool  $isabs  是否为管理目录
 * @return    string
 */
function SaasInclude($filename, $isabs=FALSE)
{
    return $isabs ? $filename : SAASADMIN.'/'.$filename;
}

/**
 *  获取当前用户的ftp站点
 *
 * @access    public
 * @param     string  $current  当前站点
 * @param     string  $formname  表单名称
 * @return    string
 */
function GetFtp($current='', $formname='')
{
    global $dsql;
    $formname = empty($formname)? 'serviterm' : $formname;
    $cuserLogin = new userLogin();
    $row=$dsql->GetOne("SELECT servinfo FROM `#@__multiserv_config`");
    $row['servinfo']=trim($row['servinfo']);
    if(!empty($row['servinfo'])){
        $servinfos = explode("\n", $row['servinfo']);
        $select="";
        echo '<select name="'.$formname.'" size="1" id="serviterm">';
        $i=0;
        foreach($servinfos as $servinfo){
            $servinfo = trim($servinfo);
            list($servname,$servurl,$servport,$servuser,$servpwd,$userlist) = explode('|',$servinfo);
            $servname = trim($servname);
            $servurl = trim($servurl);
            $servport = trim($servport);
            $servuser = trim($servuser);
            $servpwd = trim($servpwd);
            $userlist = trim($userlist);   
            $checked = ($current == $i)? '  selected="selected"' : '';
            if(strstr($userlist,$cuserLogin->getUserName()))
            {
                $select.="<option value='".$servurl.",".$servuser.",".$servpwd."'{$checked}>".$servname."</option>";  
            }
            $i++;
        }
        echo  $select."</select>";
    }
}
helper('cache');
/**
 *  根据用户mid获取用户名称
 *
 * @access    public
 * @param     int  $mid   用户ID
 * @return    string
 */
if(!function_exists('GetMemberName')){
	function GetMemberName($mid=0)
	{
		global $dsql;
		$rs = GetCache('memberlogin', $mid);
		if( empty($rs) )
		{
			$rs = $dsql->GetOne("SELECT * FROM `#@__member` WHERE mid='{$mid}' ");
			SetCache('memberlogin', $mid, $rs, 1800);
		}
		return $rs['uname'];
	}
}

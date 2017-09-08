<?php

ini_set('memory_limit','256M');


$default_language = 'zh_cn';

$default_timezone = 'PRC'; 


if(isset($default_timezone) && function_exists('date_default_timezone_set')) {
	@date_default_timezone_set($default_timezone);
}


$homeframes = array(
	//"systeminfo"    => array ('name' => '系统信息', 'showtitle' => '0', 'ajax' => '0', 'width' => '100%', 'height' => '210px'),
	"calendar"       => array('name' => '待办事项', 'showtitle' => '1', 'ajax' => '1','add'=>'1','module' => 'Calendar', 'width' => '49.4%', 'height' => '275px'),
	"approvals"      => array('name' => '审批中心', 'showtitle' => '1', 'ajax' => '1', 'module' => 'Approvals', 'width' => '49.4%', 'height' => '275px'),
	"announcements"  => array('name' => '公告', 'showtitle' => '1', 'ajax' => '1','add'=>'1', 'module' => 'Announcements', 'width' => '49.4%', 'height' => '275px'),
	"ma_paymentlist" => array('name' => '应收应付', 'showtitle' => '1', 'ajax' => '1', 'module' => 'Ma_PaymentList', 'width' => '49.4%', 'height' => '275px'),
	//"myclock"       => array ('name' => '时钟', 'showtitle' => '0', 'ajax' => '0', 'width' => '28.2%', 'height' => '250px'),
	//"releases"      => array ('name' => '版本更新', 'showtitle' => '0', 'ajax' => '0', 'width' => '28.2%', 'height' => '300px'),
	// "weibo"=>array('name'=>'微博','showtitle'=>'0','ajax'=>'2','width'=>'35%','height'=>'300px','url'=>'http://widget.weibo.com/weiboshow/index.php?language=&width=0&height=400&fansRow=1&ptype=1&speed=0&skin=1&isTitle=1&noborder=1&isWeibo=1&isFans=0&uid=2624334030&verifier=73cc3461&dpc=1'),
);





$copyrights = array(
	'name' => '医流通器械云平台',
	'site' => 'qixieyun.com',
	'icp' => ' 湘ICP备15009349号',
	'logo' => '/Public/images/logo.png',
	'login_logo' => '/Public/images/logo_login.png',
	'manifesto' => '全国首家医疗器械服务平台',
	'description' => '全国首家医疗器械服务平台！',
	'principal' => '王志斌',
	'mobile' => '13307919642',
	'email' => 'wzb@qixieyun.com',
	'homeframescolumn' => '2',
	'program' => 'tezan',
	'customapproval' => 'ma_approvalflows',
	'customuser' => 'ma_staffs',
	'customdepartment' => 'ma_departments',
);
/*
$copyrights = array(
	'name' => '大泗医疗器械信息化平台',
	'site' => 'dasi.com',
	'icp' => ' 湘ICP备15009349号',
	'logo' => '/Public/images/logo_ds.png',
	'login_logo' => '/Public/images/logo_login_ds.png',
	'manifesto' => '全国首家医疗器械服务平台',
	'description' => '全国首家医疗器械服务平台！',
	'principal' => '王真明',
	'mobile' => '15974160308',
	'email' => '68594864@qq.com',
	'homeframescolumn' => '2',
	'program' => 'ma',
	'customapproval' => 'ma_approvalflows',
	'customuser' => 'ma_staffs',
	'customdepartment' => 'ma_departments',
);
 
$homeframes = array(
	"systeminfo"    => array ('name' => '系统信息', 'showtitle' => '0', 'ajax' => '0', 'width' => '100%', 'height' => '210px'),
	"calendar"       => array('name' => '待办事项', 'showtitle' => '1', 'ajax' => '1','add'=>'1','module' => 'Calendar', 'width' => '35%', 'height' => '275px'),
	"myclock"       => array ('name' => '时钟', 'showtitle' => '0', 'ajax' => '0', 'width' => '28.2%', 'height' => '275px'),
	"approvals"      => array('name' => '审批中心', 'showtitle' => '1', 'ajax' => '1', 'module' => 'Approvals', 'width' => '35%', 'height' => '275px'),
	"announcements"  => array('name' => '公告', 'showtitle' => '1', 'ajax' => '1','add'=>'1', 'module' => 'Announcements', 'width' => '35%', 'height' => '275px'),
	"releases"      => array ('name' => '版本更新', 'showtitle' => '0', 'ajax' => '0', 'width' => '28.2%', 'height' => '275px'),
    "weibo"=>array('name'=>'微博','showtitle'=>'0','ajax'=>'2','width'=>'35%','height'=>'275px','url'=>'http://widget.weibo.com/weiboshow/index.php?language=&width=0&height=295&fansRow=1&ptype=1&speed=0&skin=1&isTitle=1&noborder=1&isWeibo=1&isFans=0&uid=2624334030&verifier=73cc3461&dpc=1'),
);

$copyrights = array(
	'name' => '特赞电子商务平台',
	'site' => 'tezan.cn',
	'icp' => ' 湘ICP备15009349号',
	'logo' => '/Public/images/logo_tezan.png',
	'login_logo' => '/Public/images/logo_login_tezan.png',
	'manifesto' => '全国首家F2C+B2B+O2O+B2C免费综合平台',
	'description' => '全国首家F2C+B2B+O2O+B2C免费综合平台！',
	'principal' => '王真明',
	'mobile' => '15974160308',
	'email' => 'ceo@tezan.cn',
	'homeframescolumn' => '3', 
	'program' => 'tezan',
	'customapproval' => 'supplier_approvalflows',
	'customuser' => 'supplier_users',
	'customdepartment' => 'supplier_departments',
);*/

?>
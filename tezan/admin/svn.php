<?php

Error_reporting(E_ALL);

$default_language = 'zh_cn';

$default_timezone = 'PRC';  

if(isset($default_timezone) && function_exists('date_default_timezone_set')) 
{
        @date_default_timezone_set($default_timezone);
}

svn_auth_set_parameter(SVN_AUTH_PARAM_DEFAULT_USERNAME, 'yiliao');
svn_auth_set_parameter(SVN_AUTH_PARAM_DEFAULT_PASSWORD, '1234567890jqk');
svn_auth_set_parameter(PHP_SVN_AUTH_PARAM_IGNORE_SSL_VERIFY_ERRORS, true);  
svn_auth_set_parameter(SVN_AUTH_PARAM_NON_INTERACTIVE,true);
svn_auth_set_parameter(SVN_AUTH_PARAM_NO_AUTH_CACHE,true);

echo svn_update(realpath('/raid5/apps/new'));

if (function_exists('opcache_reset')) 
{
	opcache_reset();
}


?>
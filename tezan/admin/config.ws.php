<?php



$Config_ws_operations = array (
  1 => 
  array (
    'name' => 'login',
    'handler_path' => 'include/Webservices/Login.php',
    'handler_method' => 'vtws_login',
    'type' => 'POST',
    'prelogin' => '1',
  ),
  2 => 
  array (
    'name' => 'retrieve',
    'handler_path' => 'include/Webservices/Retrieve.php',
    'handler_method' => 'vtws_retrieve',
    'type' => 'GET',
    'prelogin' => '0',
  ),
  3 => 
  array (
    'name' => 'create',
    'handler_path' => 'include/Webservices/Create.php',
    'handler_method' => 'vtws_create',
    'type' => 'POST',
    'prelogin' => '0',
  ),
  4 => 
  array (
    'name' => 'update',
    'handler_path' => 'include/Webservices/Update.php',
    'handler_method' => 'vtws_update',
    'type' => 'POST',
    'prelogin' => '0',
  ),
  5 => 
  array (
    'name' => 'delete',
    'handler_path' => 'include/Webservices/Delete.php',
    'handler_method' => 'vtws_delete',
    'type' => 'POST',
    'prelogin' => '0',
  ),
  6 => 
  array (
    'name' => 'sync',
    'handler_path' => 'include/Webservices/GetUpdates.php',
    'handler_method' => 'vtws_sync',
    'type' => 'GET',
    'prelogin' => '0',
  ),
  7 => 
  array (
    'name' => 'query',
    'handler_path' => 'include/Webservices/Query.php',
    'handler_method' => 'vtws_query',
    'type' => 'GET',
    'prelogin' => '0',
  ),
  8 => 
  array (
    'name' => 'logout',
    'handler_path' => 'include/Webservices/Logout.php',
    'handler_method' => 'vtws_logout',
    'type' => 'POST',
    'prelogin' => '0',
  ),
  9 => 
  array (
    'name' => 'listtypes',
    'handler_path' => 'include/Webservices/ModuleTypes.php',
    'handler_method' => 'vtws_listtypes',
    'type' => 'GET',
    'prelogin' => '0',
  ),
  10 => 
  array (
    'name' => 'getchallenge',
    'handler_path' => 'include/Webservices/AuthToken.php',
    'handler_method' => 'vtws_getchallenge',
    'type' => 'GET',
    'prelogin' => '1',
  ),
  11 => 
  array (
    'name' => 'describe',
    'handler_path' => 'include/Webservices/DescribeObject.php',
    'handler_method' => 'vtws_describe',
    'type' => 'GET',
    'prelogin' => '0',
  ),
  12 => 
  array (
    'name' => 'extendsession',
    'handler_path' => 'include/Webservices/ExtendSession.php',
    'handler_method' => 'vtws_extendSession',
    'type' => 'POST',
    'prelogin' => '1',
  ),
  13 => 
  array (
    'name' => 'convertlead',
    'handler_path' => 'include/Webservices/ConvertLead.php',
    'handler_method' => 'vtws_convertlead',
    'type' => 'POST',
    'prelogin' => '0',
  ),
  14 => 
  array (
    'name' => 'revise',
    'handler_path' => 'include/Webservices/Revise.php',
    'handler_method' => 'vtws_revise',
    'type' => 'POST',
    'prelogin' => '0',
  ),
  15 => 
  array (
    'name' => 'mobile.fetchallalerts',
    'handler_path' => 'modules/Mobile/api/wsapi.php',
    'handler_method' => 'mobile_ws_fetchAllAlerts',
    'type' => 'POST',
    'prelogin' => '0',
  ),
  16 => 
  array (
    'name' => 'mobile.alertdetailswithmessage',
    'handler_path' => 'modules/Mobile/api/wsapi.php',
    'handler_method' => 'mobile_ws_alertDetailsWithMessage',
    'type' => 'POST',
    'prelogin' => '0',
  ),
  17 => 
  array (
    'name' => 'mobile.fetchmodulefilters',
    'handler_path' => 'modules/Mobile/api/wsapi.php',
    'handler_method' => 'mobile_ws_fetchModuleFilters',
    'type' => 'POST',
    'prelogin' => '0',
  ),
  18 => 
  array (
    'name' => 'mobile.fetchrecord',
    'handler_path' => 'modules/Mobile/api/wsapi.php',
    'handler_method' => 'mobile_ws_fetchRecord',
    'type' => 'POST',
    'prelogin' => '0',
  ),
  19 => 
  array (
    'name' => 'mobile.fetchrecordwithgrouping',
    'handler_path' => 'modules/Mobile/api/wsapi.php',
    'handler_method' => 'mobile_ws_fetchRecordWithGrouping',
    'type' => 'POST',
    'prelogin' => '0',
  ),
  20 => 
  array (
    'name' => 'mobile.filterdetailswithcount',
    'handler_path' => 'modules/Mobile/api/wsapi.php',
    'handler_method' => 'mobile_ws_filterDetailsWithCount',
    'type' => 'POST',
    'prelogin' => '0',
  ),
  21 => 
  array (
    'name' => 'mobile.listmodulerecords',
    'handler_path' => 'modules/Mobile/api/wsapi.php',
    'handler_method' => 'mobile_ws_listModuleRecords',
    'type' => 'POST',
    'prelogin' => '0',
  ),
  22 => 
  array (
    'name' => 'mobile.saverecord',
    'handler_path' => 'modules/Mobile/api/wsapi.php',
    'handler_method' => 'mobile_ws_saveRecord',
    'type' => 'POST',
    'prelogin' => '0',
  ),
  23 => 
  array (
    'name' => 'mobile.syncModuleRecords',
    'handler_path' => 'modules/Mobile/api/wsapi.php',
    'handler_method' => 'mobile_ws_syncModuleRecords',
    'type' => 'POST',
    'prelogin' => '0',
  ),
  24 => 
  array (
    'name' => 'mobile.query',
    'handler_path' => 'modules/Mobile/api/wsapi.php',
    'handler_method' => 'mobile_ws_query',
    'type' => 'POST',
    'prelogin' => '0',
  ),
  25 => 
  array (
    'name' => 'mobile.querywithgrouping',
    'handler_path' => 'modules/Mobile/api/wsapi.php',
    'handler_method' => 'mobile_ws_queryWithGrouping',
    'type' => 'POST',
    'prelogin' => '0',
  ),
);

$Config_ws_operation_parameters = array (
  0 => 
  array (
    'operationid' => '1',
    'name' => 'accessKey',
    'sequence' => '2',
    'type' => 'String',
  ),
  1 => 
  array (
    'operationid' => '1',
    'name' => 'username',
    'sequence' => '1',
    'type' => 'String',
  ),
  2 => 
  array (
    'operationid' => '2',
    'name' => 'id',
    'sequence' => '1',
    'type' => 'String',
  ),
  3 => 
  array (
    'operationid' => '3',
    'name' => 'element',
    'sequence' => '2',
    'type' => 'encoded',
  ),
  4 => 
  array (
    'operationid' => '3',
    'name' => 'elementType',
    'sequence' => '1',
    'type' => 'String',
  ),
  5 => 
  array (
    'operationid' => '4',
    'name' => 'element',
    'sequence' => '1',
    'type' => 'encoded',
  ),
  6 => 
  array (
    'operationid' => '5',
    'name' => 'id',
    'sequence' => '1',
    'type' => 'String',
  ),
  7 => 
  array (
    'operationid' => '6',
    'name' => 'elementType',
    'sequence' => '2',
    'type' => 'String',
  ),
  8 => 
  array (
    'operationid' => '6',
    'name' => 'modifiedTime',
    'sequence' => '1',
    'type' => 'DateTime',
  ),
  9 => 
  array (
    'operationid' => '7',
    'name' => 'query',
    'sequence' => '1',
    'type' => 'String',
  ),
  10 => 
  array (
    'operationid' => '8',
    'name' => 'sessionName',
    'sequence' => '1',
    'type' => 'String',
  ),
  11 => 
  array (
    'operationid' => '10',
    'name' => 'username',
    'sequence' => '1',
    'type' => 'String',
  ),
  12 => 
  array (
    'operationid' => '11',
    'name' => 'elementType',
    'sequence' => '1',
    'type' => 'String',
  ),
  13 => 
  array (
    'operationid' => '13',
    'name' => 'accountName',
    'sequence' => '3',
    'type' => 'String',
  ),
  14 => 
  array (
    'operationid' => '13',
    'name' => 'assignedTo',
    'sequence' => '2',
    'type' => 'String',
  ),
  15 => 
  array (
    'operationid' => '13',
    'name' => 'avoidPotential',
    'sequence' => '4',
    'type' => 'Boolean',
  ),
  16 => 
  array (
    'operationid' => '13',
    'name' => 'leadId',
    'sequence' => '1',
    'type' => 'String',
  ),
  17 => 
  array (
    'operationid' => '13',
    'name' => 'potential',
    'sequence' => '5',
    'type' => 'Encoded',
  ),
  18 => 
  array (
    'operationid' => '14',
    'name' => 'element',
    'sequence' => '1',
    'type' => 'Encoded',
  ),
  19 => 
  array (
    'operationid' => '16',
    'name' => 'alertid',
    'sequence' => '1',
    'type' => 'string',
  ),
  20 => 
  array (
    'operationid' => '17',
    'name' => 'module',
    'sequence' => '1',
    'type' => 'string',
  ),
  21 => 
  array (
    'operationid' => '18',
    'name' => 'record',
    'sequence' => '1',
    'type' => 'string',
  ),
  22 => 
  array (
    'operationid' => '19',
    'name' => 'record',
    'sequence' => '1',
    'type' => 'string',
  ),
  23 => 
  array (
    'operationid' => '20',
    'name' => 'filterid',
    'sequence' => '1',
    'type' => 'string',
  ),
  24 => 
  array (
    'operationid' => '21',
    'name' => 'elements',
    'sequence' => '1',
    'type' => 'encoded',
  ),
  25 => 
  array (
    'operationid' => '22',
    'name' => 'module',
    'sequence' => '1',
    'type' => 'string',
  ),
  26 => 
  array (
    'operationid' => '22',
    'name' => 'record',
    'sequence' => '2',
    'type' => 'string',
  ),
  27 => 
  array (
    'operationid' => '22',
    'name' => 'values',
    'sequence' => '3',
    'type' => 'encoded',
  ),
  28 => 
  array (
    'operationid' => '23',
    'name' => 'module',
    'sequence' => '1',
    'type' => 'string',
  ),
  29 => 
  array (
    'operationid' => '23',
    'name' => 'page',
    'sequence' => '3',
    'type' => 'string',
  ),
  30 => 
  array (
    'operationid' => '23',
    'name' => 'syncToken',
    'sequence' => '2',
    'type' => 'string',
  ),
  31 => 
  array (
    'operationid' => '24',
    'name' => 'module',
    'sequence' => '1',
    'type' => 'string',
  ),
  32 => 
  array (
    'operationid' => '24',
    'name' => 'page',
    'sequence' => '3',
    'type' => 'string',
  ),
  33 => 
  array (
    'operationid' => '24',
    'name' => 'query',
    'sequence' => '2',
    'type' => 'string',
  ),
  34 => 
  array (
    'operationid' => '25',
    'name' => 'module',
    'sequence' => '1',
    'type' => 'string',
  ),
  35 => 
  array (
    'operationid' => '25',
    'name' => 'page',
    'sequence' => '3',
    'type' => 'string',
  ),
  36 => 
  array (
    'operationid' => '25',
    'name' => 'query',
    'sequence' => '2',
    'type' => 'string',
  ),
);
?>
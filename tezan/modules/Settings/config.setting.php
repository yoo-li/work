<?php
	$Config_Menu_Setting = array (  
		'USER_MANAGEMENT' =>  array(
			   'USERS' => array('module'=>'Users','link'=>'/index.php?module=Users&action=ListView&parenttab=Settings'),
			   'ROLES' => array('module'=>'Settings','link'=>'/index.php?module=Settings&action=RolesManager&parenttab=Settings'),
			   'PROFILES' => array('module'=>'Profiles','link'=>'/index.php?module=Profiles&action=index&parenttab=Settings'),
			   'BOSS_AUTHORIZE' => array('module'=>'Settings','link'=>'/index.php?module=Settings&action=Authorize&parenttab=Settings'), 
			   ),
		'STUDIO' =>  array(
			   'PROGRAM_SWITCH' => array('module'=>'Settings','link'=>'/index.php?module=Settings&action=ProgramSwitch&parenttab=Settings'),
			   'MODULE_SWITCH' => array('module'=>'Settings','link'=>'/index.php?module=Settings&action=ModuleSwitch&parenttab=Settings'),
			   'MODULE_LAYOUT' => array('module'=>'Settings','link'=>'/index.php?module=Settings&action=ModuleFieldLayout&parenttab=Settings'),
		       'PICKLIST' => array('module'=>'Settings','link'=>'/index.php?module=Settings&action=PickListManage&parenttab=Settings'),
		 	   'APPROVAL_FLOW' => array('module'=>'ApprovalFlows','link'=>'/index.php?module=ApprovalFlows&action=index&parenttab=Settings'), 
			   'DOMAINS' => array('module'=>'Domains','link'=>'/index.php?module=Domains&action=index&parenttab=Settings'),
			  ),
		'OFTEN_SETTINGS' =>  array( 
			   'BACKUP_SETTINGS' => array('module'=>'Settings','link'=>'/index.php?module=Settings&action=ListBackup&parenttab=Settings'),
			   'AUDIT_TRAIL' => array('module'=>'AuditTrailList','link'=>'/index.php?module=Settings&action=AuditTrailList&parenttab=Settings'),
			   'LOGIN_HISTORY' => array('module'=>'Settings','link'=>'/index.php?module=Settings&action=ListLoginHistory&parenttab=Settings'),
			   //'INVOICEPRINT' => array('module'=>'InvoicePrint','link'=>'/index.php?module=InvoicePrint&action=index&parenttab=Settings'), 
			   'CUSTOMIZE_MODENT_NUMBER' => array('module'=>'Settings','link'=>'/index.php?module=Settings&action=CustomModEntityNo&parenttab=Settings'),	
			   //'WATERMARK' => array('module'=>'Settings','link'=>'/index.php?module=Settings&action=WaterMark&parenttab=Settings'),
				 
			),
		
		); 
		
include ('config.inc.php'); 
 
if ($copyrights['program'] == 'ma')
{
	$Config_Menu_Setting['MA_SETTINGS_MANAGEMENT'] = array( 
			'MA_REGISTERUSERS' => array('module'=>'Ma_RegisterUsers','link'=>'/index.php?module=Ma_RegisterUsers&action=index&type=register'),
			'MA_ENTERPRISEUSERS' => array('module'=>'Ma_RegisterUsers','link'=>'/index.php?module=Ma_RegisterUsers&action=index&type=enterprise'),
			'MA_FOODANDDRUGADMIN' => array('module'=>'Ma_FoodandDrugAdmin','link'=>'/index.php?module=Ma_FoodandDrugAdmin&action=index'),
			//'MA_SOCIALSECURITY' => array('module'=>'Ma_SocialSecurity','link'=>'/index.php?module=Ma_SocialSecurity&action=index'),
			'MA_FINANCIALS' => array('module'=>'Ma_Financials','link'=>'/index.php?module=Ma_Financials&action=index'),
			'MA_SETTINGS' => array('module'=>'Ma_Settings','link'=>'/index.php?module=Ma_Settings&action=index'),
  			); 
			
	$Config_Menu_Setting['MA_LOGISTICS_MANAGE'] = array(
				'MA_LOGISTICS' => array('module'=>'Ma_Logistics','link'=>'/index.php?module=Ma_Logistics&action=index'),
			);
}	
 
?>
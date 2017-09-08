<?php
/*********************************************************************************
  ** The contents of this file are subject to the 361CRM Public License Version 1.0
   * ("License"); You may not use this file except in compliance with the License
   * The Original Code is:  361CRM Open Source
   * The Initial Developer of the Original Code is vtiger.
   * Portions created by vtiger are Copyright (C) vtiger.
   * All Rights Reserved.
  *
 ********************************************************************************/

require($_SERVER['DOCUMENT_ROOT'].'/Smarty/libs/Smarty.class.php');
class platform_Smarty extends Smarty{
	 
	
	/**This function sets the smarty directory path for the member variables	
	*/
	function platform_Smarty()
	{
		global $CALENDAR_DISPLAY, $WORLD_CLOCK_DISPLAY, $CALCULATOR_DISPLAY, $CHAT_DISPLAY, $current_user;

		$this->Smarty(); 
		$templates_c = dirname(__FILE__) .'/templates_c';
		if (!is_dir($templates_c))
		{
			mkdir($templates_c);
		}
		$this->template_dir = dirname(__FILE__) .'/templates';
		$this->compile_dir = $templates_c;
		$this->config_dir = $_SERVER['DOCUMENT_ROOT'].'/Smarty/configs';
		$this->cache_dir = $_SERVER['DOCUMENT_ROOT'].'/Smarty/cache';
	 
		//$this->caching = true;
	        //$this->assign('app_name', 'Login');
		$this->assign('CALENDAR_DISPLAY', $CALENDAR_DISPLAY); 
 		$this->assign('WORLD_CLOCK_DISPLAY', $WORLD_CLOCK_DISPLAY); 
 		$this->assign('CALCULATOR_DISPLAY', $CALCULATOR_DISPLAY); 
 		$this->assign('CHAT_DISPLAY', $CHAT_DISPLAY);
 		
 		 
	}
}

?>

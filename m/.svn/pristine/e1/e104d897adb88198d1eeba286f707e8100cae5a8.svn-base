<?php
/** Code for widget-enabled apps that make a distinction between widgets and
 * instances
 */
 
class XG_App {
    /**
     * Files that have already been loaded on this request
     *
     * @var array
     */
    protected static $_includedFiles = array();

    /**
     * Load a file from underneath the include prefix. Don't load it if
     * it's already been loaded
     *
     * @param string $file
     * @param boolean $usePrefix Whether to use the include prefix. Defaults
     *   to true, set to false if you want to specify an absolute path but
     *   still take advantage of the already-included checking
     */
    public static function includeFileOnce($file) {      
        if (isset(self::$_includedFiles[$file])) {
            return;
        }
        self::$_includedFiles[$file] = true;
        $display_errors = ini_get('display_errors');
        ini_set('display_errors',false);
        $rv = include  $file;	
        ini_set('display_errors',$display_errors);
        return $rv;
    }   

}

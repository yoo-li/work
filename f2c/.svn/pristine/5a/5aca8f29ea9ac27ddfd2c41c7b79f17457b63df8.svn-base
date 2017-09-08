<?php
/**
 * Defines the XN Debug PHP API.
 * 
 * @file
 * @ingroup XN
 */

/* $Revision: 9896 $ */

/** @cond */
if (! class_exists('XN_Debug')) {
/** @endcond */
 
/** This class is used for debug logging and printing.
 *
 * @ingroup XN
 */
class XN_Debug {
    
    public static $APIVersion = null;
    public static $dumpTiming = false;
    
    private static $debugAllowed = false;
    private static $automaticDebugPrintingSuppressed = false;
    private static $debugLog = null;
    private static $debugCSSPrinted = false;
    
    /**
     * If debug is {@link XN_Debug::isDebugEnabled enabled}, logs the given message. The
     * message is immediately printed if automatic printing is not 
     * {@link XN_Debug::suppressAutomaticDebugPrinting suppressed}, which is the default
     * configuration, or printed later when either XN_Debug::printDebug() or 
     * {@link XN_Debug::suppressAutomaticDebugPrinting suppressAutomaticDebugPrinting(false)}
     * is called if automatic printing is suppressed.
     * 
     * This method is typically used by the application to provide contextual
     * clues for the deferred printing of debug messages. 
     * 
     * @param $msg string a debug message
     */
    public static function debug($msg){
        if (!self::isDebugEnabled()) return;
        if ($_GET['xn_debug'] == 'api-comm-stack') {
            $fullStack = debug_backtrace();
            // Remove level 0 -- the call to this method
            array_shift($fullStack);
            $stack = array();
            foreach ($fullStack as $frame) {
                //if ((! isset($frame['class'])) || ($frame['class'] != 'XN_REST')) {
                    $stack[] = $frame;
                //}
            }
            $msg['stack'] = $stack; 
        }      
        if (self::_isAutomaticDebugPrintingSuppressed()){
            self::$debugLog[] = $msg;
        }   
        else {    
            self::_printDebug($msg);
        }
    }
            
    /** 
     * Allow debug messages to be enabled if the 'xn_debug=api-comm' query
     * parameter is passed. By default, debug messages are not allowed.
     * 
     * @param $allow boolean true if debug messages are allowed.
     */
    public static function allowDebug($allow=true){
        self::$debugAllowed = $allow;
    }
    
    /**
     * Suppress the automatic printing of debug messages if the $suppress
     * parameter is true or omitted, otherwise allow the automatic printing of
     * debug messages. By default, debug messages are automatically printed. 
     * If automatic printing of debug messages is suppressed, messages will 
     * only be printed when XN_Debug::printDebug or 
     * suppressAutomaticDebugPrinting(false) is called.
     * 
     * @param $suppress boolean true if printing is suppressed.
     */
    public static function suppressAutomaticDebugPrinting($suppress=true){
        self::$automaticDebugPrintingSuppressed = $suppress;
        if (!$suppress){
            self::_printSuppressedDebugMessages();
        }
    }
    
    /**
     * Prints any suppressed debug messages.
     */
    public static function printDebug(){
        self::_printSuppressedDebugMessages();
    }
    
    /**
     * Returns true if debug messages have been enabled with the 
     * 'xn_debug=api-comm' query parameter. This is only possible if 
     * XN_Debug::allowDebug has been called.
     * 
     * @return boolean boolean
     */
    public static function isDebugEnabled(){
        return self::_isDebugAllowed() &&
            isset($_GET['xn_debug']) && 
            (($_GET['xn_debug']=='api-comm') ||
             ($_GET['xn_debug']=='api-comm-stack'));
    }
    
    //------------------------------------------------------------------------
    // PRIVATE METHODS
    //------------------------------------------------------------------------
    
    private static function _isDebugAllowed(){
        return self::$debugAllowed;
    }
    
    private static function _isAutomaticDebugPrintingSuppressed(){
        return self::$automaticDebugPrintingSuppressed;
    }
    
    private static function _printStackFrame($frameNumber, $frame) {
        printf('#%-2d',$frameNumber);
    	if (isset($frame['class'])) {
            print xnhtmlentities($frame['class'].$frame['type']);
        }
        print xnhtmlentities($frame['function']).'(';
        if (count($frame['args'])) {
            self::_printStackFrameArgs($frame['args']);	
        }
        printf(') called at [%s:%d]<br/>',
        xnhtmlentities($frame['file']),$frame['line']);
    }

    private static function _printStackFrameArgs($args) {
        $values = array();
        foreach ($args as $arg) {
            if (is_string($arg)) {
                $value = "'".addcslashes($arg,"'")."'";
            } else if (is_int($arg) || is_float($arg)) {
                $value = $arg;
            } else if (is_array($arg)) {
                $value = 'Array['.count($arg).']';
            } else if (is_object($arg)) { 
                $value = 'Object('.get_class($arg).')';
            } else if (is_null($arg)) { 
                $value = 'NULL';
            } else if (is_resource($arg)) {
                $value = 'Resource('.get_resource_type($arg).')';
            } else {
                $value = $arg;
            }
            $values[] = xnhtmlentities($value);
        }
        print implode(',',$values);
	}

    private static function _printDebugCSS() {
        if (self::$debugCSSPrinted == true) {
            return;
        }
        self::$debugCSSPrinted = true;
        print<<<_CSS_
<xn:head>
<style type="text/css">
#userContent dl.xn-debug, #userHeader dl.xn-debug {
    border: 1px solid;
    background-color: #eee;
    align: left;
    font-family: monospace;
    font-size: 12px;
    line-height: 110%;
}
#userContent dl.xn-debug dt, #userHeader dl.xn-debug dt {
    font-weight: bold;
}
</style>
</xn:head>        
_CSS_;
    }
        
    
    private static function _printDebug($msg){
        self::_printDebugCSS();
        if (is_array($msg)){
            $safe = array();
            foreach ($msg as $k => $v) {
                if (! (is_array($v) || is_object($v))) {
                $safe[$k] = xnhtmlentities($v);
                }
            }
            $safe['endpoint'] = xnhtmlentities(urldecode($msg['endpoint']));
            $safe['request-body'] = preg_replace('@^ +@me','str_repeat("&nbsp;",strlen("$0"))',$safe['request-body']);
            $safe['request-body'] = nl2br($safe['request-body']);
            $safe['response-body'] = preg_replace('@^ +@me','str_repeat("&nbsp;",strlen("$0"))',$safe['response-body']);
            $safe['response-body'] = nl2br($safe['response-body']);
            print<<<_HTML_
<dl class="xn-debug">
<dt>HTTP Method</dt> <dd>{$safe['method']}</dd>
<dt>Endpoint</dt> <dd>{$safe['endpoint']}</dd>
<dt>Elapsed Seconds</dt> <dd>{$safe['elapsed']}</dd>
<dt>Request Headers</dt> <dd>
_HTML_;
            self::_printHeaders($msg['request-headers']);
print '</dd>';
if (strlen($safe['request-body'])) { print<<<_HTML_
<dt>Request Body</dt> <dd>{$safe['request-body']}</dd>
_HTML_;
}
print<<<_HTML_
<dt>Response Code</dt> <dd>{$safe['response-code']}</dd>
<dt>Response Headers</dt> <dd>
_HTML_;
            self::_printHeaders($msg['response-headers']);
            print<<<_HTML_
</dd>
<dt>Response Body</dt> <dd>{$safe['response-body']}</dd>
_HTML_;
if (isset($msg['stack'])) {
    print '<dt>Stack</dt><dd>';
    foreach ($msg['stack'] as $i => $frame) {
        self::_printStackFrame($i, $frame);
    }
    print '</dd>';
}
print '</dl>';
        } else {
            print "<dl class='xn-debug'><dt>$msg</dt></dl>";
        }
    }
    
    private static function _printSuppressedDebugMessages(){
        reset(self::$debugLog);
        while (list($key, $msg) = each(self::$debugLog)) {
            self::_printDebug($msg);
        }
        self::$debugLog = array();
    }
    
    private static function _printHeaders($headers) {
        foreach ($headers as $header => $value) {
            if (is_array($value)) {
                foreach ($value as $oneValue) {
                    self::_printHeader($header, $oneValue);
                }
            } else {
                self::_printHeader($header, $value);
            }
        }
    }
    
    private static function _printHeader($header, $value) {
        echo xnhtmlentities($header);
        if (strlen($value)) { echo ': ' . xnhtmlentities($value); }
        echo '<br/>';
    }
}
 

 } // class_exists()

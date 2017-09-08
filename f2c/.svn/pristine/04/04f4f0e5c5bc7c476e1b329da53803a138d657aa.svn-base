<?php
/** Defines the XN Exception PHP API.
 *
 * @file
 * @ingroup XN
 */

/** @cond */ 
if (! class_exists('XN_Exception')) {
/** @endcond */

/**
 * Any error in the XN package is raised by throwing an XN_Exception.
 * @ingroup XN
 */
class XN_Exception extends Exception {
    
   /**
    * If $brief is true, then only a brief version of the exception is
    * logged (no stack trace)
    *
    */
    public $brief = false;

   /**
    * If $central is true, then the message is logged to a centralized log
    * instead of the app error log.
    *
    */
    public $central = false;
    
   /**
    * Arbitrary key/value pairs that might be useful for logging. Initially
    * useful for NING-6798 (improved request-timeout logging)
    */
    protected $logData = array();

    public function __construct($message, $code = 0){
        parent::__construct($message, $code);
    }

    /**
     * Reformat an exception for throwing with more information
     *
     * @param $prefix string to prepend to the error message
     * @param $e Exception The exception being re-thrown
     * @param $class string Class of exception to return, defaults to XN_Exception
     */
    public static function reformat($prefix, Exception $e, $class = null) {
        $class = is_null($class) ? 'XN_Exception' : $class;
	if ($e instanceof XN_TimeoutException) {
            return $e;
	}
        $msg = "$prefix\n" . $e->getMessage();
        if (($e instanceof XN_Exception) && (! $e->brief)) {
            $msg .= "\n" .$e->getTraceAsString(); 
        }
        $e2 = new $class($msg);
        if (($e instanceof XN_Exception) && ($e2 instanceof XN_Exception)) {
            $e2->brief = $e->brief;
            $e2->central = $e->central;
            $e2->setLogData($e->getLogData());
        }
        return $e2;
    }

    /**
     * Set the stored log data to a new array of key/value pairs
     */
    public function setLogData($data) {
        $this->logData = $data;
    }

    /**
     * Retrieve the existing log data
     */
    public function getLogData() {
        return $this->logData;
    }
}

/**
 * Signals that a programming-related error has occurred. 
 * @ingroup XN
 */
class XN_ProgrammingException extends XN_Exception {
    public function __construct($message){
        parent::__construct($message);
    }
}

/**
 * Signals that a method has been invoked at an illegal or inappropriate time. 
 * @ingroup XN
 */
class XN_IllegalStateException extends XN_ProgrammingException {
    public function __construct($message){
        parent::__construct($message);
    }
}

/**
 * Thrown to indicate that a method has been passed an illegal or inappropriate
 * argument. 
 * @ingroup XN
 */
class XN_IllegalArgumentException extends XN_ProgrammingException {
    public function __construct($message){
        parent::__construct($message);
    }
}

/**
 * Thrown to indicate that the requested operation is not supported. 
 * @ingroup XN
 */
class XN_UnsupportedOperationException extends XN_ProgrammingException {
    public function __construct($message){
        parent::__construct($message);
    }
}

/**
 * Thrown to indicate a request timeout error
 * @ingroup XN
 */
class XN_TimeoutException extends XN_Exception {
    public $brief = false;
    public $central = true;
}

/**
 * Thrown to indicate a serialization error
 * @ingroup XN
 */
class XN_SerializationException extends XN_Exception {}

/**
 * Exception handler to be set in set_exception_handler() for handling
 * uncaught exceptions.
 */   
function XN_ExceptionHandler(Exception $ex){
    $class = new ReflectionClass($ex);
    print "<pre>Uncaught ".$class->getName().": ".$ex->getMessage()."\n".
          $ex->getTraceAsString()."</pre>"; 
}

 } // class_exists()

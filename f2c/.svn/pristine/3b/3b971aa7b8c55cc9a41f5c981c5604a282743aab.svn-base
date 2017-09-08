<?php
/** Defines the XN_Event lightweight hooks API
 *
 * @file
 * @ingroup XN
 */

/* $Revision$ */

/** @cond */
if (! class_exists('XN_Event')) {
/** @endcond */

/** XN_Event provides hooks in other parts of the API
 * 
 * @ingroup XN
 */
class XN_Event {
    
    private static $_listeners;
    
    /**
     * Fire an event with optional arguments
     *
     * @param $event string
     * @param $args array optional arguments to pass to listeners
     */
    public static function fire($event, $args = null) {
        if (! isset(self::$_listeners[$event])) { return; }
        if (! is_array(self::$_listeners[$event])) { return; }
        foreach (self::$_listeners[$event] as $id => $listener) {
            // Listen args first, if provided
            $invokeArgs = is_array($listener['args']) ? $listener['args'] : array();
            // Then fire args, if provided.
            if (is_array($args)) {
                $invokeArgs = array_merge($invokeArgs, $args);
            }
            try {
                call_user_func_array($listener['callback'], $invokeArgs);
            } catch (Exception $e) {
                // Don't let exceptions from callbacks disrupt the flow
            }
        }
    }
    
    /**
     * Listen for an event
     *
     * @param $event string
     * @param $callback callback The function to run when the given event is fired
     * @param $args array optional arguments to pass to the callback
     * @return string
     */
    public static function listen($event, $callback, $args = null) {
        static $idCounter = 0;
        $id = md5(++$idCounter);
        if (! isset(self::$_listeners[$event])) {
            self::$_listeners[$event] = array();
        }
        self::$_listeners[$event][$id] = array('callback' => $callback,
                                                    'args' => $args);
        
        return $event.'.'.$id;
    }
    
    /**
     * Cancel the listening set up by a previous call to listen()
     *
     * @param $listenerId string
     */
    public static function unlisten($listenerId) {
        if (! preg_match('/^(.+)\.([a-f0-9]+)$/', $listenerId, $matches)) {
            throw new XN_IllegalArgumentException("Invalid listener ID: $listenerId");
        }
        $event = $matches[1];
          $id = $matches[2];
          if (! isset(self::$_listeners[$event][$id])) {
              throw new XN_IllegalArgumentException("No listener exists for event $event with ID $id");
          }
          unset(self::$_listeners[$event][$id]);
      }
}
 
 } /* class_exists */


<?php

/**
 * W_Cache
 *
 * @version 20060330-001: added cache for class registry
 * 
 * @package WWF
 */
 
 class NF_Exception extends Exception { }
 
 
class W_Cache {
    /**
     * Associative array holding the various cache associative arrays
     *
     * @var array
     */
    protected static $_cache;
    /**
     * Associative array holding the various stack arrays
     *
     * @var array
     */
    protected static $_stack;
    
    /**
     * Get one element from a particular cache
     *
     * @param string $type The cache to look in
     * @param string $key The key of the element to return
     * @return mixed The element from the cache, or null if none match $key
     */
    protected static function _get($type, $key) {
        if (isset(self::$_cache[$type][$key])) {
            return self::$_cache[$type][$key];
        } else {
            return null;
        }
    }

    /**
     * Put one element into a particular cache
     *
     * @param string $type The cache to put the element into
     * @param string $key The element key
     * @param mixed $value The element value
     * @return mixed Returns the value put in
     */
    protected static function _put($type, $key, $value) {
        return self::$_cache[$type][$key] = $value;
    }
    
    /**
     * Return everything in a particular cache
     *
     * @param string $type The cache to return
     * @return array
     */
    protected static function _all($type) { 
        if (isset(self::$_cache[$type])) {
            return self::$_cache[$type];
        } else {
            return array();
        }
    }
    
    /**
     * Get a shape from the cache
     *
     * @param string $shapeName Shape class name
     * @return W_Shape
     */
    public static function getShape($shapeName) { 
        if (! is_null($shape = self::_get('shape',$shapeName))) {
            return $shape;
        } else {
            return self::putShape($shapeName);
        }
    }
    /**
     * Put a shape into the shape cache
     *
     * @param string $shapeName The name of the shape class to instantiate and put into the cache
     * @return W_Shape
     */
    public static function putShape($shapeName) { return self::_put('shape',$shapeName,new W_Shape($shapeName)); }
    /**
     * Return all the shapes in the shape cache
     *
     * @return array
     */
    public static function allShapes() { return self::_all('shape'); }
    
    /**
     * Get a widget instance from the cache
     *
     * @param string $widgetName Widget instance name
     * @return W_BaseWidget
     */
    public static function getWidget($widgetName) {
        if (! is_null($widget = self::_get('widget',$widgetName))) {
            return $widget;
        } else {
            // Try to load the widget if it's not already loaded
            try {
		$appClass = W_Cache::getClass('app');
		$instanceIdentifier = call_user_func(array($appClass, 'getInstanceIdentifier'), $widgetName);
		$widget = W_BaseWidget::factory($instanceIdentifier);

                if ($widget) {
                    return W_Cache::putWidget($widget);
                } else {
                    throw new NF_Exception("Unknown widget: $widgetName");
                }
            } catch (Exception $e) {
                // An NF_Exception indicates an error we don't need to log
                // (NING-7043)
                if (! ($e instanceof NF_Exception)) {
                    error_log($e->getMessage() . "\n" . $e->getTraceAsString());
                }
                throw new NF_Exception("Could not create widget: $widgetName, error was {$e->getMessage()}");
            }
        }
    }    
    /**
     * Put a widget instance into the widget cache
     *
     * @param W_BaseWidget $widget The widget instance to put into the cache
     * @return W_BaseWidget
     */
    public static function putWidget(W_BaseWidget $widget) { return self::_put('widget',$widget->dir,$widget); }
    /**
     * Return all the widget instances in the widget cache
     *
     * @return array
     */
    public static function allWidgets() { return self::_all('widget'); }

    /**
     * Get a particular model's widget from the model cache
     *
     * @param string $modelName The name of the model
     * @return W_Widget
     */
    public static function getModel($modelName) {
        if (! is_null($widget = self::_get('model',$modelName))) {
            return $widget;
        } else {
            throw new NF_Exception("Unknown model: $modelName");
        }
    }
    
    /**
     * Put a model/widget pair into the model cache
     *
     * @param string $modelName The model class name
     * @param W_BaseWidget $widget The widget instance it belongs to
     */
    public static function putModel($modelName, W_BaseWidget $widget) {
        self::_put('model',$modelName,$widget);
    }
    /**
     * Return all the model/widget pairs in the model cache
     *
     * @return array
     */
    public static function allModels() { return self::_all('model'); }


    /**
     * Get a particular class name from the class registry cache
     *
     * @param string $role The role of the class
     * @return string
     */
    public static function getClass($role) {
        if (! is_null($class = self::_get('class',$role))) {
            return $class;
        } else {
            throw new NF_Exception("Unknown class role: $role");
        }
    }
    
    /**
     * Put a role/class name into the class registry cache
     *
     * @param string $role The class role
     * @param string $className The class name filling that role
     */
    public static function putClass($role, $className) {
        self::_put('class',$role,$className);
    }
    /**
     * Return all the role/class pairs in the class registry cache
     *
     * @return array
     */
    public static function allClasses() { return self::_all('class'); }
    
    /**
     * Returns a string describing the stack type for a given object
     * that's going to go onto the stack
     *
     * @param object $object The object going onto the stack
     * @return string The stack type string
     */
    protected static function _stackType($object) {
        if ($object instanceof W_BaseWidget) {
            return 'W_Widget';
        } else {
            return get_class($object);
        }
    }
    
    /**
     * Push an element onto a stack
     *
     * @param object $object The object to push
     */
    public static function push($object) {
        $stackType = self::_stackType($object);
        if (is_array(self::$_stack[$stackType])) {
                self::$_stack[$stackType][] = $object;
        } else {
                self::$_stack[$stackType] = array($object);
        }
    }

    /**
     * Pop an element off the top of a stack
     *
     * @param object $object The object to identify which stack to use
     */
    public static function pop($object) {
        $stackType = self::_stackType($object);
        if (is_array(self::$_stack[$stackType])) {
            array_pop(self::$_stack[$stackType]);
        }
    }

    /**
     * Return the element at the top of a given stack
     *
     * @param string $stackType Which stack to look in
     * @return mixed
     */
    public static function current($stackType) {
        if (is_array(self::$_stack[$stackType])) {
            $c = count(self::$_stack[$stackType]);
            if ($c == 0) {
                return null;
            } else {
                return self::$_stack[$stackType][$c-1];
            }
        } else {
            return null;
        }
    }

  
}


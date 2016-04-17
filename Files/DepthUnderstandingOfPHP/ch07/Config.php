<?php # Script 7.1 - Config.php
// This page defines a Config class which uses the Singleton pattern.

/* The Config class.
 * The class contains two attributes: $_instance and $settings.
 * The class contains four methods:
 * - __construct()
 * - getInstance()
 * - set()
 * - get()
 */
class Config {
    
    // Store a single instance of this class:
    static private $_instance = NULL;

    // Store settings:
    private $_settings = array();
    
    // Private methods cannot be called: 
    private function __construct() {}
    private function __clone() {}
    
    // Method for returning the instance:
    static function getInstance() {
        if (self::$_instance == NULL) {
            self::$_instance = new Config();
        }
        return self::$_instance;
    }
    
    // Method for defining a setting settings:
    function set($index, $value) {
        $this->_settings[$index] = $value;
    }
    
    // Method for retrieving a setting:
    function get($index) {
        return $this->_settings[$index];
    }
    
} // End of Config class definition.
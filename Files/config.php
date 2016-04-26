<?php
/**
 * Author: helen
 * CreateTime: 2016/4/21 11:16
 * description: 单例模式类
 */
class Config{
    static private $_instance = NULL;
    private $_settings = array();

    private function __construct(){}
    private function __clone(){}
    static function getInstance(){
        if(self::$_instance == NULL){
            self::$_instance = new Config();
        }
        return self::$_instance;
    }
    function set($index,$value){
        $this->_settings[$index] = $value;
    }
    function get($index){
        return $this->_settings[$index];
    }
}
$config = Config::getInstance();
$config->set('live','true');
echo '<p>$config["live"]: '.$config->get('live').'</p>';

$test = Config::getInstance();
echo '<p>$test["live"]: '.$test->get('live').'</p>';

unset($config,$test);
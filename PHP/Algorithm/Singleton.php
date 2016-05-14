<?php
/**
 * Created by PhpStorm.
 * User: helen
 * Date: 16-5-14
 * Time: 下午7:26
 */

class Singleton{
    private static $_instance;

    private function __construct(){}
    private function __clone(){}

    public static function getInstance()
    {
        if(self::$_instance == null){
            self::$_instance = new Singleton();
        }
        return self::$_instance;
    }
}

$a = Singleton::getInstance();
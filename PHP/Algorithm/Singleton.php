<?php
/**
 * Created by PhpStorm.
 * User: helen
 * Date: 16-5-14
 * Time: 下午7:26
 */

class Singleton{
    private static $_instance;

    /**
     *  私有化构造函数，防止外界实例化对象
     */
    private function __construct(){}
    /**
     *  私有化克隆函数，防止外界克隆对象
     */
    private function __clone(){}

    /**
     *  静态方法, 单例统一访问入口
     *  @return  object  返回对象的唯一实例
     */
    public static function getInstance()
    {
        if(self::$_instance == null){
            self::$_instance = new Singleton();
        }
        return self::$_instance;
    }
}

$a = Singleton::getInstance();
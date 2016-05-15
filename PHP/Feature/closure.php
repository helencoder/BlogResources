<?php
/**
 * Created by PhpStorm.
 * User: helen
 * Date: 16-5-15
 * Time: 下午4:00
 */
/**
 * 闭包
 * 实现__invoke()方法
 */
$closure = function($name){
    return sprintf('Hello %s', $name);
};
echo $closure('helen');

$numbersPlusOne = array_map(function ($number){
    return $number+1;
}, [1,2,3]);
print_r($numbersPlusOne);
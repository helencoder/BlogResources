<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 16-4-28
 * Time: 上午11:39
 */
//phpinfo();
/*
 * 利用PHP操作Redis
 * */

//实例化Redis类
$redis = new Redis();
//选择指定的redis数据库连接，默认端口号为6379
$redis->connect('127.0.0.1', 6379);
/*
 * redis中的字符串操作
 * */
//set key
$redis->set('hello','world');
//get key
$redis->get('hello');
//del key
$redis->del('hello');
$redis->delete('hello');
/*
 * redis中的列表操作(l)
 * */

/*
 * redis中的集合(s)
 * */

/*
 * redis中的散列(h)
 * */

/*
 * redis中的有序集合(z)
 * */


<?php
/**
 * Author: helen
 * CreateTime: 2016/4/17 16:04
 * description: PHP创建过程中基本配置
 */

//设置基本编码UTF—8,可以放置到基类中
header("Content-type: text/html; charset=utf-8");
//当前页面的url
$url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
//当前项目的根路径,注意此路径最后为‘/’
$root = $_SERVER['DOCUMENT_ROOT'];

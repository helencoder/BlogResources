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
//设置PHP能使用的内存大小
@ini_set('memory_limit', '512M');
//设置超时时间为0，即为永不超时
set_time_limit(0);
//json_encode()设置不转义中文 Json不要编码Unicode.
json_encode('', JSON_UNESCAPED_UNICODE);

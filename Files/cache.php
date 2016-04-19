<?php
/**
 * Author: helen
 * CreateTime: 2016/4/19 20:33
 * description: 缓存（浏览器缓存）
 */
/*
 * 利用header（）函数设置浏览器缓存
 * 4种头标类型：
    Last-Modified(最后修改时间);
    Expires(有效期限);
    Pragma（编译指示）；
    Cache-Control(缓存控制);
 *
 * Expires 表明了缓存版本何时应该过期(格林威治标准时间)。把它设置为一个以前的时间就会强制使用服务器上的页面。
 * Pragma生命了页面数据应该如何被处理。可以这样避免对页面进行缓存： header("Pragma:no-cache");
 * Cache-Co0ntrol 头标是在HTTP1.1里添加的，能够实现更细致的控制
 * Cache-Control的设置有
 *   指令	                 含义
    public	            可以在任何地方缓存
    private	            只能被浏览器缓存
    no-cache	        不能在任何地方缓存
    must-revalidate	    缓存必须检查更新版本
    proxy-revalidate	代理缓存必须检查更新版本
    max-age	            内容能够被缓存的时期，以秒表示
    s-maxage	        覆盖共享缓存的max-age设置
 * */

// Connect to the database:
$dbc = @mysqli_connect ('localhost', 'username', 'password', 'test') OR die ('<p>Could not connect to the database!</p></body></html>');
// Get the latest dates as timestamps:
$q = 'SELECT UNIX_TIMESTAMP(MAX(date_added)), UNIX_TIMESTAMP(MAX(date_completed)) FROM tasks';
$r = mysqli_query($dbc, $q);
list($max_a, $max_c) = mysqli_fetch_array($r, MYSQLI_NUM);
// Determine the greater timestamp:
$max = ($max_a > $max_c) ? $max_a : $max_c;
// Create a cache interval in seconds:
$interval = 60 * 60 * 6; // 6 hours
// Send the header:
header ("Last-Modified: " . gmdate ('r', $max));
header ("Expires: " . gmdate ("r", ($max + $interval)));
header ("Cache-Control: max-age=$interval");

//不设置缓存
header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Pragma: no-cache"); // Date in the past
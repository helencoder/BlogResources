<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 16-5-4
 * Time: 下午3:02
 */
/*
 * 使用HTML Meta标签阻止网络浏览器缓存页面
 * */
/*<meta http-equiv="expires" content="Mon, 26 Jul 1997 05:00:00 GMT">
<meta http-equiv="pragma" content="no-cache">*/
/*
 * 使用HTTP头阻止网络浏览器缓存页面(使用HTTP1.1)
 * */
/*header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0',FALSE);
header('Pragma: no-cache');*/

function setExpires($expires){
    header('Expires: '.gmdate('D, d M Y H:i:s',time()+$expires).' GMT');
}
setExpires(10); //页面10秒钟后过期(关注时间点的更新)
echo('The GMT is now '.gmdate('H:i:s').'<br/>');
echo('<a href="'.$_SERVER['PHP_SELF'].'">View again</a>');

$request = getallheaders();
var_dump($request);




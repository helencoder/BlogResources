<?php
/**
 * Author：helen
 * CreateTime: 2016/07/25 17:28
 * Description：curl的url请求测试
 */
$url_1 = 'www.baidu.com';
$url_2 = 'www.zhihu.com';
$url_3 = 'www.sina.com.cn';
//第一种：循环请求
/*$sr = array($url_1, $url_2, $url_3);
foreach ($sr as $k => $v) {
    $curlPost = $v . '?f=传入参数';
    $ch = curl_init($curlPost);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 获取数据返回
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, true); // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回
    $data = curl_exec($ch);
    echo $k . '##:' . $data . '<br>';
}
curl_close($ch);*/

//第二种 多线程请求
/*$sr = array($url_1, $url_2, $url_3);
$mh = curl_multi_init();
foreach ($sr as $i => $url) {
    $curlPost = $url;
    $conn[$i] = curl_init($curlPost);
    curl_setopt($conn[$i], CURLOPT_RETURNTRANSFER, 1);
    curl_multi_add_handle($mh, $conn[$i]);
}
do {
    $mrc = curl_multi_exec($mh, $active);
} while ($mrc == CURLM_CALL_MULTI_PERFORM);
while ($active and $mrc == CURLM_OK) {
    if (curl_multi_select($mh) != -1) {
        do {
            $mrc = curl_multi_exec($mh, $active);
        } while ($mrc == CURLM_CALL_MULTI_PERFORM);
    }
}
foreach ($sr as $i => $url) {
    $res[$i] = curl_multi_getcontent($conn[$i]);
    curl_close($conn[$i]);
}
var_dump($res);*/

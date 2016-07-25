<?php
/**
 * Author：helen
 * CreateTime: 2016/07/25 18:03
 * Description：API调用方法(适用于网页爬虫)
 */

function api_request($url, $data = null)
{
    // 初始化cURL方法
    $ch = curl_init();
    // 设置cURL参数（基本参数）
    $opts = array(
        //在局域网内访问https站点时需要设置以下两项，关闭ssl验证！
        //此两项正式上线时需要更改（不检查和验证认证）
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_URL => $url
    );
    curl_setopt_array($ch, $opts);
    // post请求参数
    if (!empty($data)) {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }
    // 执行cURL操作
    $output = curl_exec($ch);
    if (curl_errno($ch)) {    //cURL操作发生错误处理。
        var_dump(curl_error($ch));
        die;
    }
    // 状态码
    $httpCode = curl_getinfo($ch,CURLINFO_HTTP_CODE);
    // 关闭cURL
    curl_close($ch);
    //$res = json_encode($output);
    $res = array(
        'status' => $httpCode,
        'data'   => $output
    );
    return ($res);   //返回数据
}
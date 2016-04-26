<?php
/**
 * Author: helen
 * CreateTime: 2016/4/17 21:49
 * description: GET、POST请求函数
 */

/*
 * 功能：接口请求函数
 * 参数：url，[data](通过是否传入data判断其为get请求还是post请求)
 * 返回：json数据
 */
function request($url, $data = null)
{
    //初始化cURL方法
    $ch = curl_init();
    //设置cURL参数（基本参数）
    $opts = array(
        //在局域网内访问https站点时需要设置以下两项，关闭ssl验证！
        //此两项正式上线时需要更改（不检查和验证认证）
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_URL => $url,
        /*CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => $data*/
    );
    curl_setopt_array($ch, $opts);
    //post请求参数
    if (!empty($data)) {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }
    //执行cURL操作
    $output = curl_exec($ch);
    if (curl_errno($ch)) {    //cURL操作发生错误处理。
        var_dump(curl_error($ch));
        die;
    }
    //关闭cURL
    curl_close($ch);
    $res = json_decode($output);
    return ($res);   //返回json数据
}
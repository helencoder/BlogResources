<?php
/**
 * Created by PhpStorm.
 * User: helen
 * Date: 16-4-27
 * Time: 下午6:34
 */
header("Content-type: text/html; charset=utf-8");
function request($url, $data = null)
{
    $ch = curl_init();
    $opts = array(
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_URL => $url,
        /*CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => $data*/
    );
    curl_setopt_array($ch, $opts);
    if (!empty($data)) {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }
    $output = curl_exec($ch);
    if (curl_errno($ch)) {
        var_dump(curl_error($ch));
        die;
    }
    curl_close($ch);
    $res = json_decode($output);
    return ($res);
}

//获取素材总数
//(顺义记录)
$appid = 'wxa2671cdc0693feab';
$appsecret = '1df5cda998e8ca9eea05155e8141a31f';

//(崇文门记录)
//$appid = 'wx784cc331c1c8ba6e';
//$appsecret = '7cbd528b8ed0509c2b73fb174a19d576';

//$access_token_url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret;
//$res = request($access_token_url);
//$access_token = $res->access_token;
//
$access_token = 'WcRZaxo4-HQtiagce23WQf6yFFU341u4lsnA-9Ympd7wQq7cxAjB8eBRd96iQ8Oq0laT81eru8qmuUPYiG1g0ZSkJTOqWymHbSP4Oiwcq5I5xk4cxD8RDQI7_OWsKx-UKREfABAGNA';
var_dump($access_token);

$url = 'https://api.weixin.qq.com/cgi-bin/material/get_materialcount?access_token='.$access_token;
//获取素材列表
$url1 = 'https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token='.$access_token;
//删除永久素材链接
$delete_url = 'https://api.weixin.qq.com/cgi-bin/material/del_material?access_token='.$access_token;

/*$res =request($url);
var_dump($res);
die;*/
$data = array(
    'type'      => 'image',
    'offset'    => 880,
    'count'     => 20
);
$data = json_encode($data);


$result = request($url1,$data);
var_dump($result);

$media_id_data = array();
$item = $result->item;
foreach($item as $key=>$value){
    var_dump(date('Y-m-d H:i:s',$value->update_time));
    array_push($media_id_data,$value->media_id);
}
var_dump('$media_id_data');
//var_dump($media_id_data);

//进行循环删除
/*foreach($media_id_data as $key=>$value){
    $data = array(
        'media_id' => $value
    );
    $data = json_encode($data);
    $res = request($delete_url,$data);
    var_dump($res);
}*/

/*["voice_count"]=> int(0) ["video_count"]=> int(0) ["image_count"]=> int(5678) ["news_count"]=> int(1244) }*/
/*{ ["voice_count"]=> int(0) ["video_count"]=> int(0) ["image_count"]=> int(2034) ["news_count"]=> int(1257) }*/
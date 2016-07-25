<?php
/**
 * Author：helen
 * CreateTime: 2016/07/25 17:23
 * Description：数据中心接口监控脚本
 */
include './influx.php';

include './request.php';

$capis = array(
    'usersShowBiz', 'usersBehaviorTrend', 'friendshipsFollowersTrend_other', 'usersStatistic',
    'friendshipsFollowersInfluence_top20', 'friendshipsFollowersUnfollower_list', 'searchUsersBiz',
    'usersPage_visit', 'usersReceive_like_count', 'usersInfluence', 'friendshipsFollowersAge_group_count',
    'friendshipsFollowersSource', 'statusesUser_timelineBiz', 'statusesStatistic', 'statusesMentionsBiz',
    'statusesArticle_statistic', 'usersBehavior_trendBiz', 'usersShow_batchOther', 'statusesUser_timeline_batch',
    'friendshipsFollowersUnfollower_count', 'articleTotal', 'articleList', 'articleSingle', 'videoTotal', 'videoList',
    'videoSingle', 'statusesShow'
);

$db_name = 'dss_test';
$table_name = 'api';

foreach ($capis as &$api) {
    $url = 'dss.sc.weibo.com/aj/data/' . $api;
    $stime = microtime(true); //获取程序开始执行的时间
    $output = api_request($url);
    $etime = microtime(true);//获取程序执行结束的时间
    $total = $etime - $stime;   //计算差值
    $res = json_decode($output['data']);
    if (!is_null($res)) {
        $status = $output['status'];

    } else {    // not found控制以及错误控制？
        $status = $output['status'];

    }
    $fields = array("time" => $total);
    $tags = array("name" => $api, "status" => $status);

    var_dump($api, $fields, $tags);
    // 写入数据库
    //Tool_Influx::write($db_name, $table_name, $fields, $tags);
}

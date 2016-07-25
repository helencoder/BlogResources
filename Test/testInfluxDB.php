<?php

//调用实例:
include './influx.php';

$name = "接口名字";
$time = 200;    //  调取接口所用时间
$status = 200;  //  (500, 503) 此处是接口状态？
$db_name = "dss_test";  //  数据中心
$table_name = "api";
$fields = array("time" => $time);
$tags = array("name" => $name, "status" => $status);
$timestamp = time();

Tool_Influx::write("dss_test", "api", $fields, $tags);
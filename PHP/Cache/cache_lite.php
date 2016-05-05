<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 16-5-4
 * Time: 下午4:20
 */
$root = $_SERVER['DOCUMENT_ROOT'];
$path = $root.'/BlogResources/Classes/Cache_Lite-1.7.16/';
include_once $root.'/Classes/Cache_Lite-1.7.16/Cache/Lite/Output.php';
$options = array(
    'cacheDir' => $root.'/caahe/',
    'writeControl'=> 'true',
    'readControl'=> 'true',
    'fileNameProtection' => false,
    'readControlType' => 'md5'
);
$cache = new Cache_Lite_Output($options);


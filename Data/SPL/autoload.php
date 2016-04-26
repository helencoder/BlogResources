<?php
/**
 * Author: helen
 * CreateTime: 2016/4/21 8:32
 * description:
 */
//自动加载类
//设定类文件的后缀（可以匹配多个扩展名，用逗号分隔，前面的扩展名有限匹配）
spl_autoload_extensions('.class.php,.php');
//设定类文件的存储路径（多个目录用PATH_SEPARATOR分隔）
set_include_path(get_include_path().PATH_SEPARATOR."Classes/");
//提示PHP使用Autoload机制查找类定义
spl_autoload_register();

//利用__autoload函数添加
function __autoload($class_name){
    //require_once("/Classes/".$class_name.".class.php");
    set_include_path("/Classes");
    spl_autoload($class_name);
}


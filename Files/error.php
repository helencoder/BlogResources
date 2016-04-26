<?php
/**
 * Author: helen
 * CreateTime: 2016/4/19 16:38
 * description: 错误处理函数
 */




//set error handler
set_error_handler("customError",E_USER_WARNING);

//trigger error
$test=2;
if ($test>1)
{
    trigger_error("Value must be 1 or below",E_USER_WARNING);
}


/*
 * 自定义错误处理函数
 * 功能：错误日志记录
 * 功能：错误信息表记录，返回相关信息
 * 参数	描述
    error_level	    必需。为用户定义的错误规定错误报告级别。必须是一个值数。
    error_message	必需。为用户定义的错误规定错误消息。
    error_file	    可选。规定错误在其中发生的文件名。
    error_line	    可选。规定错误发生的行号。
    error_context	可选。规定一个数组，包含了当错误发生时在用的每个变量以及它们的值。
 *
 * */
/*
 * 文件打开模式(fopen、fclose)
 * 模式	描述
    r	打开文件为只读。文件指针在文件的开头开始。
    w	打开文件为只写。删除文件的内容或创建一个新的文件，如果它不存在。文件指针在文件的开头开始。
    a	打开文件为只写。文件中的现有数据会被保留。文件指针在文件结尾开始。创建新的文件，如果文件不存在。
    x	创建新文件为只写。返回 FALSE 和错误，如果文件已存在。
    r+	打开文件为读/写、文件指针在文件开头开始。
    w+	打开文件为读/写。删除文件内容或创建新文件，如果它不存在。文件指针在文件开头开始。
    a+	打开文件为读/写。文件中已有的数据会被保留。文件指针在文件结尾开始。创建新文件，如果它不存在。
    x+	创建新文件为读/写。返回 FALSE 和错误，如果文件已存在。
 * */
/*
 * 以下级别的错误不能由用户定义的函数来处理： E_ERROR、 E_PARSE、 E_CORE_ERROR、 E_CORE_WARNING、 E_COMPILE_ERROR、 E_COMPILE_WARNING，
 * 和在 调用 set_error_handler() 函数所在文件中产生的大多数 E_STRICT。
 *
 * */

//error handler function
function customError($error_level, $error_message, $error_file, $error_line, $error_context)
{
    $time = date('Y-m-d H:i:s', time());
    $errmsg = $time . " <b>Error:</b> [$error_level] $error_message<br />" . "error_file:$error_file" . "($error_line)。\r\n\r\n";
    $date = date('Y-m-d', time());
    $root = $_SERVER['DOCUMENT_ROOT'];
    $filename = $root . '/BlogResources/Log/' . "$date" . '.log';
    $dir = $root . '/BlogResources/Log';
    //用户错误信息记录表记录
    /*$error_records = M('error_records');
    $data['msg'] = $errmsg;
    $data['occur_time'] = $time;
    $error_records->data($data)->add();*/
    //错误日志添加
    if (!file_exists($dir)) {
        @mkdir($dir, 0777);
    }
    //错误日志记录,文件不存在，则直接创建后添加信息；否则直接追加
    if (!file_exists($filename)) {
        touch($filename);
        @$fp = fopen($filename, "a");
        fwrite($fp, $errmsg);
        fclose($fp);
    } else {
        error_log($errmsg, 3, $filename);
    }
}

<?php
/**
 * Author：helen
 * CreateTime: 2016/07/26 21:50
 * Description：错误异常处理方式（重定向查找错误）
 */

// 打开错误信息
error_reporting(E_ERROR | E_WARNING | E_PARSE);
set_error_handler('customErrorHandler');
// 自定义错误处理函数
function customErrorHandler($error, $error_string, $filename, $line, $symbols)
{
    $error_no_arr = array(
        1 => 'ERROR', 2 => 'WARNING', 4 => 'PARSE', 8 => 'NOTICE',
        16 => 'CORE_ERROR', 32 => 'CORE_WARNING', 64 => 'COMPILE_ERROR',
        128 => 'COMPILE_WARNING', 256 => 'USER_ERROR', 512 => 'USER_WARNING',
        1024 => 'USER_NOTICE', 2047 => 'ALL', 2048 => 'STRICT'
    );
    if (in_array($error, array(1, 2, 4))) {
        //var_dump($error, $error_string, $filename, $line, $symbols);
        $msg = $filename . ':' . $line . '&nbsp' . $error_string;
        //dieByError($msg);
        throw new Exception($error_string);
    }
}

//显示错误信息
function dieByError($msg)
{
    echo $msg;
    exit();
}


// 错误自动定向查询
try {
    $b = 4 / 0;
    $message = '';
    $code = 12;
} catch (Exception $e) {
    header("Location: http://stackoverflow.com/search?q=" . $e->getMessage());
} finally {
    //header("Location: http://huihui.com");
}
<?php
/**
 * Author：helen
 * CreateTime: 2016/07/26 21:50
 * Description：错误异常处理方式（重定向查找错误）
 */

// 打开错误信息
error_reporting(E_ERROR | E_WARNING | E_PARSE);
// 启用自定义错误控制
set_error_handler('customErrorHandler');

// 自定义错误处理函数
function customErrorHandler($error, $error_string, $filename, $line, $symbols)
{
    $error_data = array(
        1 => 'ERROR', 2 => 'WARNING', 4 => 'PARSE', 8 => 'NOTICE',
        16 => 'CORE_ERROR', 32 => 'CORE_WARNING', 64 => 'COMPILE_ERROR',
        128 => 'COMPILE_WARNING', 256 => 'USER_ERROR', 512 => 'USER_WARNING',
        1024 => 'USER_NOTICE', 2047 => 'ALL', 2048 => 'STRICT'
    );
    $error_no = array(1, 2, 4, 8, 16, 32, 64, 128, 256, 512, 1024, 2047, 2048);
    if (in_array($error, $error_no)) {
        $msg = $filename . ':' . $line . '&nbsp' . $error_string;
        $errorSearch = $error_string . ' php';
        throw new Exception($errorSearch);
    }
}

// 错误自动定向查询
try {
    $b = 4 / 0;
} catch (Exception $e) {
    header("Location: http://stackoverflow.com/search?q=" . $e->getMessage());
} finally {
    //header("Location: http://huihui.com");
}
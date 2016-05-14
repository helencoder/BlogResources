<?php
/**
 * Created by PhpStorm.
 * User: helen
 * Date: 16-5-14
 * Time: 下午8:36
 */

/**
 * BinarySearch
 * @param array arr 已排序的数组
 * @pram value 要查找的值
 * @return key 找到返回键值，否则返回false
 */
function BinarySearch(array $arr, $value)
{
    $length = count($arr);
    $leftKey = 0;
    $rightKey = $length - 1;
    while ($leftKey <= $rightKey) {
        //向上取整
        /*$half = ($length >> 1) + ($length & 1);*/
        //向下取整
        $half = floor(($leftKey + $rightKey) / 2);
        if ($arr[$half] == $value) {
            return $half;
        } elseif ($arr[$half] < $value) {
            $leftKey = $half + 1;
        } else {
            $rightKey = $half - 1;
        }
    }
    return false;
}

//$arr = array(1, 3, 5, 7, 9, 11, 13, 14, 16, 19, 21);
//$arr = array(16);
$length = count($arr);
$value = 16;
$key = BinarySearch($arr, $value);
/*$length = 6;
$half = ($length >> 1) + ($length & 1);*/
print_r($key);

/*print_r(15 / 2);*/
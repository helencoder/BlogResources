<?php
/**
 * Author: helen
 * CreateTime: 2016/4/23 12:56
 * description: 冒泡排序
 */
/*
 * 冒泡排序
 * 算法思想：两两比较相邻元素（记录）的关键字，如果反序则交换，直到没有反序的元素（记录）为止
 * 复杂度：时间复杂度：o(n*n)
 * 辅助空间：o(1)
 * 稳定性：稳定
 * @access public
 * @param string $type 排列顺序：升序asc，降序desc;默认升序asc
 * @return array $array 排序完成的数组
 * @return string $exchange_count 排序过程中交换的次数
 * @return string $compare_count 排序过程中比较的次数
 * */
function BubbleSort(array $arr,$type){
    $array = $arr;
    $length = count($arr);
    $exchange_count = 0;      //交换次数
    $compare_count = 0;       //比较次数
    $flag = true;             //标记，目的在于减少比较次数
    switch ($type) {
        case 'asc':     //升序排列
            for ($i = 0; $i < $length && $flag; $i++) {      //若flag为true则退出循环
                $flag = false;
                for ($j = $length - 2; $j > $i; $j--) {
                    if ($array[$j] > $array[$j + 1]) {
                        $tmp = $array[$j];
                        $array[$j] = $array[$j + 1];
                        $array[$j + 1] = $tmp;
                        $exchange_count++;
                        $flag = true;   //如果有数据交换，则flag为true
                    }
                    $compare_count++;
                }
            }
            break;
        case 'desc':    //降序排列
            for ($i = 0; $i < $length && $flag; $i++) {          //若flag为true则退出循环
                $flag = false;
                for ($j = $length - 2; $j >= $i; $j--) {
                    if ($array[$j] < $array[$j + 1]) {
                        $tmp = $array[$j];
                        $array[$j] = $array[$j + 1];
                        $array[$j + 1] = $tmp;
                        $exchange_count++;
                        $flag = true;   //如果有数据交换，则flag为true
                    }
                    $compare_count++;
                }
            }
            break;
    }
    return array(
        'array' => $array,
        'exchange_count' => $exchange_count,
        'compare_count' => $compare_count
    );
}

$arr = array(1,6,7,3,5,9);
$res = BubbleSort($arr,'asc');
var_dump($res);

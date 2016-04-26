<?php
/**
 * Author: helen
 * CreateTime: 2016/4/17 18:40
 * description: 中奖概率算法
 */
/*中奖概率算法*/
function getRand($proArr) { //传入的为一维数字数组,此数组中数字即为相应概率
    $result = '';

    //概率数组的总概率精度
    $proSum = array_sum($proArr);

    //概率数组循环
    foreach ($proArr as $key => $proCur) {
        $randNum = mt_rand(1, $proSum);
        if ($randNum <= $proCur) {
            $result = $key;
            break;
        } else {
            $proSum -= $proCur;
        }
    }
    unset ($proArr);

    return $result;
}
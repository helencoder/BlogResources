<?php
/**
 * Author: helen
 * CreateTime: 2016/4/17 18:40
 * description: �н������㷨
 */
/*�н������㷨*/
function getRand($proArr) { //�����Ϊһά��������,�����������ּ�Ϊ��Ӧ����
    $result = '';

    //����������ܸ��ʾ���
    $proSum = array_sum($proArr);

    //��������ѭ��
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
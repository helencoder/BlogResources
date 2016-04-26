<?php
/**
 * Author: helen
 * CreateTime: 2016/4/23 12:56
 * description: ð������
 */
/*
 * ð������
 * �㷨˼�룺�����Ƚ�����Ԫ�أ���¼���Ĺؼ��֣���������򽻻���ֱ��û�з����Ԫ�أ���¼��Ϊֹ
 * ���Ӷȣ�ʱ�临�Ӷȣ�o(n*n)
 * �����ռ䣺o(1)
 * �ȶ��ԣ��ȶ�
 * @access public
 * @param string $type ����˳������asc������desc;Ĭ������asc
 * @return array $array ������ɵ�����
 * @return string $exchange_count ��������н����Ĵ���
 * @return string $compare_count ��������бȽϵĴ���
 * */
function BubbleSort(array $arr , $type = 'asc')
{
    $array = $arr;
    $length = count($arr);
    $exchange_count = 0;      //��������
    $compare_count = 0;       //�Ƚϴ���
    $flag = true;             //��ǣ�Ŀ�����ڼ��ٱȽϴ���
    switch ($type) {
        case 'asc':     //��������
            for ($i = 0; $i < $length && $flag; $i++) {      //��flagΪtrue���˳�ѭ��
                $flag = false;
                for ($j = $length - 2; $j > $i; $j--) {
                    if ($array[$j] > $array[$j + 1]) {
                        $tmp = $array[$j];
                        $array[$j] = $array[$j + 1];
                        $array[$j + 1] = $tmp;
                        $exchange_count++;
                        $flag = true;   //��������ݽ�������flagΪtrue
                    }
                    $compare_count++;
                }
            }
            break;
        case 'desc':    //��������
            for ($i = 0; $i < $length && $flag; $i++) {          //��flagΪtrue���˳�ѭ��
                $flag = false;
                for ($j = $length - 2; $j >= $i; $j--) {
                    if ($array[$j] < $array[$j + 1]) {
                        $tmp = $array[$j];
                        $array[$j] = $array[$j + 1];
                        $array[$j + 1] = $tmp;
                        $exchange_count++;
                        $flag = true;   //��������ݽ�������flagΪtrue
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

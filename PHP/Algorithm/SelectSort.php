<?php
/**
 * Author: helen
 * CreateTime: 2016/4/23 13:24
 * description: ��ѡ������
 */
/*
 * ��ѡ������
 * �㷨˼�룺ͨ��n-i�ιؼ��ּ�ıȽϣ���n-i+1����¼��ѡ���ؼ�����С��Ԫ�أ���¼�������͵�i��1=<i<=n����Ԫ�أ���¼������֮
 * ���Ӷȣ�o(n*n)
 * �����ռ䣺o(1)
 * �ȶ��ԣ��ȶ�
 * @access public
 * @param string $type ����˳������asc,����desc;Ĭ������asc
 * @return array $array ������ɵ�����
 * @return string $exchange_count ��������н����Ĵ���
 * @return string $compare_count ��������бȽϵĴ���
 * */
function SelectSort(array $arr , $type = 'asc')
{
    $array = $arr;
    $length = count($arr);
    $exchange_count = 0;      //��������
    $compare_count = 0;       //�Ƚϴ���
    switch ($type) {
        case 'asc':
            for ($i = 0; $i < $length; $i++) {
                $min = $i;          //����ǰ�±궨��Ϊ��Сֵ�±�
                for ($j = $i + 1; $j < $length; $j++) {   //ѭ��֮�������
                    if ($array[$min] > $array[$j]) {    //�����С�ڵ�ǰ��Сֵ�Ĺؼ���
                        $min = $j;                  //���˹ؼ��ֵ��±긳ֵ��min
                    }
                    $compare_count++;
                }
                if ($i != $min) {       //��min������i��˵���ҵ���Сֵ������
                    $tmp = $array[$min];
                    $array[$min] = $array[$i];
                    $array[$i] = $tmp;
                    $exchange_count++;
                }
            }
            break;
        case 'desc':
            for ($i = 0; $i < $length; $i++) {
                $max = $i;          //����ǰ�±궨��Ϊ���ֵ�±�
                for ($j = $i + 1; $j < $length; $j++) {   //ѭ��֮�������
                    if ($array[$max] < $array[$j]) {    //����д��ڵ�ǰ��daֵ�Ĺؼ���
                        $max = $j;                  //���˹ؼ��ֵ��±긳ֵ��max
                    }
                    $compare_count++;
                }
                if ($i != $max) {       //��min������i��˵���ҵ����ֵ������
                    $tmp = $array[$max];
                    $array[$max] = $array[$i];
                    $array[$i] = $tmp;
                    $exchange_count++;
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
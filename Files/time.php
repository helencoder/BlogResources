<?php
/**
 * Author: helen
 * CreateTime: 2016/4/21 19:27
 * description: ʱ�䡢����
 */

echo "����:".date("Y-m-d")."<br>";
echo "����:".date("Y-m-d",strtotime("-1 day")), "<br>";
echo "����:".date("Y-m-d",strtotime("+1 day")). "<br>";
echo "һ�ܺ�:".date("Y-m-d",strtotime("+1 week")). "<br>";
echo "һ����������Сʱ�����:".date("Y-m-d G:H:s",strtotime("+1 week 2 days 4 hours 2 seconds")). "<br>";
echo "�¸�������:".date("Y-m-d",strtotime("next Thursday")). "<br>";
echo "�ϸ���һ:".date("Y-m-d",strtotime("last Monday"))."<br>";
echo "һ����ǰ:".date("Y-m-d",strtotime("last month"))."<br>";
echo "һ���º�:".date("Y-m-d",strtotime("+1 month"))."<br>";
echo "ʮ���:".date("Y-m-d",strtotime("+10 year"))."<br>";
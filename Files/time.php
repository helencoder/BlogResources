<?php
/**
 * Author: helen
 * CreateTime: 2016/4/21 19:27
 * description: 时间、日期
 */

echo "今天:".date("Y-m-d")."<br>";
echo "昨天:".date("Y-m-d",strtotime("-1 day")), "<br>";
echo "明天:".date("Y-m-d",strtotime("+1 day")). "<br>";
echo "一周后:".date("Y-m-d",strtotime("+1 week")). "<br>";
echo "一周零两天四小时两秒后:".date("Y-m-d G:H:s",strtotime("+1 week 2 days 4 hours 2 seconds")). "<br>";
echo "下个星期四:".date("Y-m-d",strtotime("next Thursday")). "<br>";
echo "上个周一:".date("Y-m-d",strtotime("last Monday"))."<br>";
echo "一个月前:".date("Y-m-d",strtotime("last month"))."<br>";
echo "一个月后:".date("Y-m-d",strtotime("+1 month"))."<br>";
echo "十年后:".date("Y-m-d",strtotime("+10 year"))."<br>";
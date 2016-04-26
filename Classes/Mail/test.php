<?php
/**
 * Author: helen
 * CreateTime: 2016/4/19 22:57
 * description: 测试Mail类
 */
include 'mail.class.php';

$mail_from  = '你的邮箱';
$password   = '你的邮箱密码';
$mail_to    = '收件人邮箱';
$subject    = '邮件主题';
$body       = '邮件内容';


$mail = new Mail($mail_from,$password,$mail_to,$subject,$body);

<?php
/**
 * Author: helen
 * CreateTime: 2016/4/19 22:57
 * description: ����Mail��
 */
include 'mail.class.php';

$mail_from  = '�������';
$password   = '�����������';
$mail_to    = '�ռ�������';
$subject    = '�ʼ�����';
$body       = '�ʼ�����';


$mail = new Mail($mail_from,$password,$mail_to,$subject,$body);

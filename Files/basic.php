<?php
/**
 * Author: helen
 * CreateTime: 2016/4/17 16:04
 * description: PHP���������л�������
 */

//���û�������UTF��8,���Է��õ�������
header("Content-type: text/html; charset=utf-8");
//��ǰҳ���url
$url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
//��ǰ��Ŀ�ĸ�·��,ע���·�����Ϊ��/��
$root = $_SERVER['DOCUMENT_ROOT'];
//����PHP��ʹ�õ��ڴ��С
@ini_set('memory_limit', '512M');
//���ó�ʱʱ��Ϊ0����Ϊ������ʱ
set_time_limit(0);
//json_encode()���ò�ת������ Json��Ҫ����Unicode.
json_encode('', JSON_UNESCAPED_UNICODE);
//ת������ ��UTF-8תΪGBK
mb_convert_encoding('',"UTF-8","GBK");

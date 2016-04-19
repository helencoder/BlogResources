<?php
/**
 * Author: helen
 * CreateTime: 2016/4/19 20:33
 * description: ���棨��������棩
 */
/*
 * ����header���������������������
 * 4��ͷ�����ͣ�
    Last-Modified(����޸�ʱ��);
    Expires(��Ч����);
    Pragma������ָʾ����
    Cache-Control(�������);
 *
 * Expires �����˻���汾��ʱӦ�ù���(�������α�׼ʱ��)����������Ϊһ����ǰ��ʱ��ͻ�ǿ��ʹ�÷������ϵ�ҳ�档
 * Pragma������ҳ������Ӧ����α������������������ҳ����л��棺 header("Pragma:no-cache");
 * Cache-Co0ntrol ͷ������HTTP1.1����ӵģ��ܹ�ʵ�ָ�ϸ�µĿ���
 * Cache-Control��������
 *   ָ��	                 ����
    public	            �������κεط�����
    private	            ֻ�ܱ����������
    no-cache	        �������κεط�����
    must-revalidate	    �����������°汾
    proxy-revalidate	�������������°汾
    max-age	            �����ܹ��������ʱ�ڣ������ʾ
    s-maxage	        ���ǹ������max-age����
 * */

// Connect to the database:
$dbc = @mysqli_connect ('localhost', 'username', 'password', 'test') OR die ('<p>Could not connect to the database!</p></body></html>');
// Get the latest dates as timestamps:
$q = 'SELECT UNIX_TIMESTAMP(MAX(date_added)), UNIX_TIMESTAMP(MAX(date_completed)) FROM tasks';
$r = mysqli_query($dbc, $q);
list($max_a, $max_c) = mysqli_fetch_array($r, MYSQLI_NUM);
// Determine the greater timestamp:
$max = ($max_a > $max_c) ? $max_a : $max_c;
// Create a cache interval in seconds:
$interval = 60 * 60 * 6; // 6 hours
// Send the header:
header ("Last-Modified: " . gmdate ('r', $max));
header ("Expires: " . gmdate ("r", ($max + $interval)));
header ("Cache-Control: max-age=$interval");

//�����û���
header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Pragma: no-cache"); // Date in the past
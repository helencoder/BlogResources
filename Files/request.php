<?php
/**
 * Author: helen
 * CreateTime: 2016/4/17 21:49
 * description: GET��POST������
 */

/*
 * ���ܣ��ӿ�������
 * ����url��[data](ͨ���Ƿ���data�ж���Ϊget������post����)
 * ���أ�json���
 */
function request($url, $data = null)
{
    //��ʼ��cURL����
    $ch = curl_init();
    //����cURL��������
    $opts = array(
        //�ھ������ڷ���httpsվ��ʱ��Ҫ������������ر�ssl��֤��
        //��������ʽ����ʱ��Ҫ��ģ���������֤��֤��
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_URL => $url,
        /*CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => $data*/
    );
    curl_setopt_array($ch, $opts);
    //post�������
    if (!empty($data)) {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }
    //ִ��cURL����
    $output = curl_exec($ch);
    if (curl_errno($ch)) {    //cURL������������?
        var_dump(curl_error($ch));
        die;
    }
    //�ر�cURL
    curl_close($ch);
    $res = json_decode($output);
    return ($res);   //����json��
}
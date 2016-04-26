<?php
/**
 * Author: helen
 * CreateTime: 2016/4/19 16:38
 * description: ��������
 */




//set error handler
set_error_handler("customError",E_USER_WARNING);

//trigger error
$test=2;
if ($test>1)
{
    trigger_error("Value must be 1 or below",E_USER_WARNING);
}


/*
 * �Զ����������
 * ���ܣ�������־��¼
 * ���ܣ�������Ϣ���¼�����������Ϣ
 * ����	����
    error_level	    ���衣Ϊ�û�����Ĵ���涨���󱨸漶�𡣱�����һ��ֵ����
    error_message	���衣Ϊ�û�����Ĵ���涨������Ϣ��
    error_file	    ��ѡ���涨���������з������ļ�����
    error_line	    ��ѡ���涨���������кš�
    error_context	��ѡ���涨һ�����飬�����˵�������ʱ���õ�ÿ�������Լ����ǵ�ֵ��
 *
 * */
/*
 * �ļ���ģʽ(fopen��fclose)
 * ģʽ	����
    r	���ļ�Ϊֻ�����ļ�ָ�����ļ��Ŀ�ͷ��ʼ��
    w	���ļ�Ϊֻд��ɾ���ļ������ݻ򴴽�һ���µ��ļ�������������ڡ��ļ�ָ�����ļ��Ŀ�ͷ��ʼ��
    a	���ļ�Ϊֻд���ļ��е��������ݻᱻ�������ļ�ָ�����ļ���β��ʼ�������µ��ļ�������ļ������ڡ�
    x	�������ļ�Ϊֻд������ FALSE �ʹ�������ļ��Ѵ��ڡ�
    r+	���ļ�Ϊ��/д���ļ�ָ�����ļ���ͷ��ʼ��
    w+	���ļ�Ϊ��/д��ɾ���ļ����ݻ򴴽����ļ�������������ڡ��ļ�ָ�����ļ���ͷ��ʼ��
    a+	���ļ�Ϊ��/д���ļ������е����ݻᱻ�������ļ�ָ�����ļ���β��ʼ���������ļ�������������ڡ�
    x+	�������ļ�Ϊ��/д������ FALSE �ʹ�������ļ��Ѵ��ڡ�
 * */
/*
 * ���¼���Ĵ��������û�����ĺ��������� E_ERROR�� E_PARSE�� E_CORE_ERROR�� E_CORE_WARNING�� E_COMPILE_ERROR�� E_COMPILE_WARNING��
 * ���� ���� set_error_handler() ���������ļ��в����Ĵ���� E_STRICT��
 *
 * */

//error handler function
function customError($error_level, $error_message, $error_file, $error_line, $error_context)
{
    $time = date('Y-m-d H:i:s', time());
    $errmsg = $time . " <b>Error:</b> [$error_level] $error_message<br />" . "error_file:$error_file" . "($error_line)��\r\n\r\n";
    $date = date('Y-m-d', time());
    $root = $_SERVER['DOCUMENT_ROOT'];
    $filename = $root . '/BlogResources/Log/' . "$date" . '.log';
    $dir = $root . '/BlogResources/Log';
    //�û�������Ϣ��¼���¼
    /*$error_records = M('error_records');
    $data['msg'] = $errmsg;
    $data['occur_time'] = $time;
    $error_records->data($data)->add();*/
    //������־���
    if (!file_exists($dir)) {
        @mkdir($dir, 0777);
    }
    //������־��¼,�ļ������ڣ���ֱ�Ӵ����������Ϣ������ֱ��׷��
    if (!file_exists($filename)) {
        touch($filename);
        @$fp = fopen($filename, "a");
        fwrite($fp, $errmsg);
        fclose($fp);
    } else {
        error_log($errmsg, 3, $filename);
    }
}

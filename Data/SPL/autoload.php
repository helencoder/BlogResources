<?php
/**
 * Author: helen
 * CreateTime: 2016/4/21 8:32
 * description:
 */
//�Զ�������
//�趨���ļ��ĺ�׺������ƥ������չ�����ö��ŷָ���ǰ�����չ������ƥ�䣩
spl_autoload_extensions('.class.php,.php');
//�趨���ļ��Ĵ洢·�������Ŀ¼��PATH_SEPARATOR�ָ���
set_include_path(get_include_path().PATH_SEPARATOR."Classes/");
//��ʾPHPʹ��Autoload���Ʋ����ඨ��
spl_autoload_register();

//����__autoload�������
function __autoload($class_name){
    //require_once("/Classes/".$class_name.".class.php");
    set_include_path("/Classes");
    spl_autoload($class_name);
}


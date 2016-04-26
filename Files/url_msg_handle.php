<?php
/**
 * Author: helen
 * CreateTime: 2016/4/17 21:06
 * description: url����������
 */

//url��Ϣ������
//���崦����
function get_url_msg($str)
{
    $data = array();
    $parameter = explode('&', end(explode('?', $str)));
    foreach ($parameter as $val) {
        $tmp = explode('=', $val);
        $data[$tmp[0]] = $tmp[1];
    }
    return $data;
}

/*
     * ��URL�еĲ���ȡ�����ŵ�������
     * @access public
     * @param string url�������
     * @return array ������������Ϣ
     * */
function convertUrlQuery($query){
    $queryParts = explode('&', $query);
    $params = array();
    foreach ($queryParts as $param){
        $item = explode('=', $param);
        $params[$item[0]] = $item[1];
    }
    return $params;
}
/*
 * �� �������� �ٱ�� �ַ�����ʽ�Ĳ�����ʽ
 * @access public
 * @param array ����������Ϣ
 * @return string url�������
 * */
function getUrlQuery($array_query){
    $tmp = array();
    foreach($array_query as $k=>$param)
    {
        $tmp[] = $k.'='.$param;
    }
    $params = implode('&',$tmp);
    return $params;
}
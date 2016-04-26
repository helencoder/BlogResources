<?php
/**
 * Author: helen
 * CreateTime: 2016/4/17 17:43
 * description: Json、XML格式数据处理类--提供Json、XML数据的在服务器端的返回。
 */
class Response
{
    /*
     * 按JSON方式输出通信数据
     * @param integer $code 状态码
     * @param string $message 提示信息
     * @param array $data 数据
     * return string
     */
    public static function json($code, $message = '', $data = array())
    {
        if (!is_numeric($code)) {
            return '';
        }

        $result = array(
            'code' => $code,
            'message' => $message,
            'data' => $data
        );

        echo json_encode($result);
        exit;
    }

    public static function xml(){
        header("Content-Type:text/xml");
        $xml = "<?xml version = '1.0' encoding = 'UTF-8>\n";
        $xml .= "<root>\n";
        $xml .= "<code>200</code>\n";
        $xml .= "<message>数据返回成功</message>\n";
        $xml .= "<data>\n";
        $xml .= "<id>1</id>\n";
        $xml .= "<name>helen</name>\n";
        $xml .= "</data>\n";
        $xml .= "</root>";
        echo $xml;
    }

    public static function xmlEncode($code,$message,$data = array()){
        if(!is_numeric($code)){
            return '';
        }

        $result = array(
            'code' => $code,
            'message' => $message,
            'data' => $data,
        );

        //header("Content-Type:text/xml");
        $xml = "<?xml version='1.0' encoding='UTF-8'?>";
        $xml .="<root>";
        $xml .= self::xmlToEncode($result);
        $xml .="</root>";
        echo $xml;
    }

    public static function xmlToEncode($data){
        $xml = "";
        foreach($data as $key=>$value){
            $xml .= "<{$key}>";
            $xml .= is_array($value)?self::xmlToEncode($value):$value;
            $xml .= "</{$key}>";
        }
        return $xml;
    }
}

$data = array(
    'id' => 1,
    'name' => 'helen',
);
Response::xmlEncode(200,'success',$data);
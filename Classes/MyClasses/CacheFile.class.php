<?php
/**
 * Author: helen
 * CreateTime: 2016/4/17 17:49
 * description: 缓存文件写入类--提供缓存文件的写入
 */
class File{
    private $_dir;
    const EXT = '.txt';
    public function __construct(){
        $this->_dir = dirname(__FILE__).'/files/';
    }
    public function cacheData($key,$value='',$path=''){
        $filename = $this->_dir.$path.$key.self::EXT;
        if($value!==''){//将value值写入缓存
            if(is_null($value)){
                return @unlink($filename);
            }
            $dir = dirname($filename);
            if(!is_dir($dir)){
                mkdir($dir);
            }

            return file_put_contents($filename,json_encode($value));
        }

        if(!is_file($filename)){
            return FALSE;
        }else{
            return json_decode(file_get_contents($filename),true);
        }
    }
}

//使用示例（即可在同级目录下生成index_mk_cache.txt文件用于保存缓存信息）
$data = array(
    'id' => 1,
    'name' => 'helen',
    'type' => 'array(4,5,6)',
    'test' => array(1,45,67=>array(123,'tsysa')),
);

$file = new File();
if($file->cacheData('index_mk_cache')){
    var_dump($file->cacheData('index_mk_cache'));
    echo 'success';
}else{
    echo 'fail';
}
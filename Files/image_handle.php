<?php
/**
 * Author: helen
 * CreateTime: 2016/4/17 21:04
 * description: php实现下载远程图片保存到本地方法
 */

/*
 *功能：php完美实现下载远程图片保存到本地
 *参数：文件url,保存文件目录,保存文件名称，使用的下载方式
 *当保存文件名称为空时则使用远程文件原来的名称
 */
function getImage($url, $save_dir = '', $filename = '', $type = 0)
{
    if (trim($url) == '') {
        return array('file_name' => '', 'save_path' => '', 'error' => 1);
    }
    if (trim($save_dir) == '') {
        $save_dir = './';
    }
    if (trim($filename) == '') {//保存文件名
        $ext = strrchr($url, '.');
        if ($ext != '.gif' && $ext != '.jpg' && $ext != '.png' && $ext != '.jpeg') {
            return array('file_name' => '', 'save_path' => '', 'error' => 3);
        }
        $filename = time() . rand(0, 10000) . $ext;
    }
    if (0 !== strrpos($save_dir, '/')) {
        $save_dir .= '/';
    }
    //创建保存目录
    if (!file_exists($save_dir) && !mkdir($save_dir, 0777, true)) {
        return array('file_name' => '', 'save_path' => '', 'error' => 5);
    }
    //获取远程文件所采用的方法
    if ($type) {
        $ch = curl_init();
        $timeout = 50;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $img = curl_exec($ch);
        curl_close($ch);
    } else {
        ob_start();
        readfile($url);
        $img = ob_get_contents();
        ob_end_clean();
    }
    //$size=strlen($img);
    //文件大小
    $fp2 = @fopen($save_dir . $filename, 'a');
    fwrite($fp2, $img);
    fclose($fp2);
    unset($img, $url);
    return array('file_name' => $filename, 'save_path' => $save_dir . $filename, 'error' => 0);
}


/*
 *功能：PHP实现上传图片转存
 *参数：传入文件信息(array)，PHP中利用$_FILES获取
 *返回：返回存储地址
 */

function storageImg($photo)
{
    //文件处理
    if ($photo["article"]["error"]['image'] > 0) {
        #echo '错误:'.$photo["article"]["error"]['image'].'<br />';
    } else {
        //文件上传路径
        $dir = $_SERVER['DOCUMENT_ROOT'] . '/Upload/weixin/article/thumb';
        //获取文件后缀
        $ext = strpos($photo["article"]["name"]['image'], '.');
        $ext = substr($photo["article"]["name"]['image'], $ext + 1);
        if ($ext == 'gif') {
            $this->error('封面图不能为gif图片');
        }
        //利用时间戳作为图片的新名字，避免重复
        $timestamp = time();
        $newname = $timestamp . '.' . $ext;
        //文件处理
        if (file_exists("$dir/" . $photo["article"]["name"]['image'])) {
            echo $photo["article"]["name"] . '文件已经存在.';
        } else {
            move_uploaded_file($photo["article"]["tmp_name"]['image'], "$dir/" . $newname);
        }
        $img_url = $dir . '/' . $newname;
        return $img_url;

    }
}
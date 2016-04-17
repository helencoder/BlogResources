<?php
/**
 * Author: helen
 * CreateTime: 2016/4/17 21:04
 * description: phpʵ������Զ��ͼƬ���浽���ط���
 */

/*
 *���ܣ�php����ʵ������Զ��ͼƬ���浽����
 *�������ļ�url,�����ļ�Ŀ¼,�����ļ����ƣ�ʹ�õ����ط�ʽ
 *�������ļ�����Ϊ��ʱ��ʹ��Զ���ļ�ԭ��������
 */
function getImage($url, $save_dir = '', $filename = '', $type = 0)
{
    if (trim($url) == '') {
        return array('file_name' => '', 'save_path' => '', 'error' => 1);
    }
    if (trim($save_dir) == '') {
        $save_dir = './';
    }
    if (trim($filename) == '') {//�����ļ���
        $ext = strrchr($url, '.');
        if ($ext != '.gif' && $ext != '.jpg' && $ext != '.png' && $ext != '.jpeg') {
            return array('file_name' => '', 'save_path' => '', 'error' => 3);
        }
        $filename = time() . rand(0, 10000) . $ext;
    }
    if (0 !== strrpos($save_dir, '/')) {
        $save_dir .= '/';
    }
    //��������Ŀ¼
    if (!file_exists($save_dir) && !mkdir($save_dir, 0777, true)) {
        return array('file_name' => '', 'save_path' => '', 'error' => 5);
    }
    //��ȡԶ���ļ������õķ���
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
    //�ļ���С
    $fp2 = @fopen($save_dir . $filename, 'a');
    fwrite($fp2, $img);
    fclose($fp2);
    unset($img, $url);
    return array('file_name' => $filename, 'save_path' => $save_dir . $filename, 'error' => 0);
}


/*
 *���ܣ�PHPʵ���ϴ�ͼƬת��
 *�����������ļ���Ϣ(array)��PHP������$_FILES��ȡ
 *���أ����ش洢��ַ
 */

function storageImg($photo)
{
    //�ļ�����
    if ($photo["article"]["error"]['image'] > 0) {
        #echo '����:'.$photo["article"]["error"]['image'].'<br />';
    } else {
        //�ļ��ϴ�·��
        $dir = $_SERVER['DOCUMENT_ROOT'] . '/Upload/weixin/article/thumb';
        //��ȡ�ļ���׺
        $ext = strpos($photo["article"]["name"]['image'], '.');
        $ext = substr($photo["article"]["name"]['image'], $ext + 1);
        if ($ext == 'gif') {
            $this->error('����ͼ����ΪgifͼƬ');
        }
        //����ʱ�����ΪͼƬ�������֣������ظ�
        $timestamp = time();
        $newname = $timestamp . '.' . $ext;
        //�ļ�����
        if (file_exists("$dir/" . $photo["article"]["name"]['image'])) {
            echo $photo["article"]["name"] . '�ļ��Ѿ�����.';
        } else {
            move_uploaded_file($photo["article"]["tmp_name"]['image'], "$dir/" . $newname);
        }
        $img_url = $dir . '/' . $newname;
        return $img_url;

    }
}
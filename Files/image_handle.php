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


/*
 *���ܣ�����PHPĿ¼���ļ����������û�����Ŀ¼�����е��ļ����ļ��У��޸���Ƭ���� �������д���excel������
 *�����������ļ���·��
 *���أ�����excel�ļ������а���ԭʼͼƬ���͸��ĺ�ͼƬ���Ķ�Ӧ
 *
 * */
function Rename($dirname){
    //ԭͼƬ������
    $oldImageName = array();
    //��ͼƬ������
    $newImageName = array();
    if(!is_dir($dirname)){  //�ж��Ƿ�Ϊһ����Ч��Ŀ¼
        echo "{$dirname}Ŀ¼��Ч��";
        exit();
    }
    $handle = opendir($dirname);    //��Ŀ¼��������һ���¼����
    while(($fn = readdir($handle))!==false){
        if($fn!='.'&&$fn!='..'){    //��ȡdir�����.��..Ŀ¼�������Լ��ϼ�Ŀ¼���Դ˽����жϡ�
            $curDir = $dirname.'/'.$fn;
            if(is_dir($curDir)){    //���绹Ϊ�ļ��У��ͼ���ѭ�����ô˺�����
                fRename($curDir);
            }
            else{   //��Ϊ�ļ���ֱ�ӽ��и���������
                //pathinfo() �������������ʽ�����ļ�·������Ϣ��
                /*�������µ�����Ԫ�أ�
                    [dirname]
                    [basename]
                    [extension]
                */
                $path = pathinfo($curDir);
                $newname = $path['dirname'].'/'.substr(microtime(),2,8).'.'.$path['extension']; //�˴�����΢�뺯���������������Է�ֹ�ļ�������
                rename($curDir,$newname);
                array_push($oldImageName,$curDir);  //����ͼƬ������������
                array_push($newImageName,$newname); //����ͼƬ������������
            }
        }
    }

    //��������Ϣд��excel���С�
    //�������е�Ԫ�ؽ��д���
    $num = count($oldImageName);    //��ȡ�����ͼƬ����ĳ���
    for($i=0;$i<=$num;$i++){
        $oldImageName[$i] = substr($oldImageName[$i],9);    //ȥ��ͼƬ��������·��
        $newImageName[$i] = substr($newImageName[$i],9);    //ȥ��ͼƬ��������·��
    }
    //dump($oldImageName);
    //dump($newImageName);

    $dir = $_SERVER['DOCUMENT_ROOT'];  //�ҳ���Ŀ�ĸ�·��
    require '/PHPExcel_1.8.0/Classes/PHPExcel.php'; //��Ӷ�ȡexcel��������ļ���PHPExcel��

    $objPHPExcel = new \PHPExcel();                     //ʵ����һ��PHPExcel()����
    $objSheet = $objPHPExcel->getActiveSheet();        //ѡȡ��ǰ��sheet����
    //$objSheet->setTitle('helen');                      //�Ե�ǰsheet��������
    //���淽ʽ������setCellValue()�������
    //$objSheet->setCellValue("A1","����")->setCellValue("B1","����");   //����setCellValues()�������
    //ȡ��ģʽ������fromArray()�������

    //�����ļ�������
    for($i=0;$i<$num;$i++){
        $oldImageName[$i] = mb_convert_encoding($oldImageName[$i],"UTF-8","GBK");   //�˴�һ��Ҫ�ǵý�ת��Ϊ���ַ���������������
    }

    $arr = array();
    for($i=0;$i<$num;$i++){
        $tmp = array("","$oldImageName[$i]","$newImageName[$i]");
        array_push($arr,$tmp);
    }
    $objSheet->fromArray($arr);  //����fromArray()ֱ��һ�����������
    $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');   //�趨д��excel������
    $objWriter->save($dir.'/logo2.xlsx');       //�����ļ�������Ϊ����excel�ļ���
}

/*
 * ���ܣ�PHP����ͼƬ�ϴ���ת�溯��
 * */
function uploadImg(){
    if ($_FILES["photos"]["error"] > 0)
    {
        echo '����:'.$_FILES["photos"]["error"].'<br />';
    }else {
        echo '�ļ���:'.$_FILES["photos"]["name"].'<br />';
        echo '����:'.$_FILES["photos"]["type"].'<br />';
        echo '��С:'.($_FILES["photos"]["size"] / 1024).'Kb<br />';
        echo '�洢λ��:'.$_FILES["photos"]["tmp_name"];
    }
    //�ļ��ϴ�·��
    $dir = $_SERVER['DOCUMENT_ROOT'].'weixin/Images';
    var_dump($dir);
    //�ļ�����
    if (file_exists("$dir/".$_FILES["photos"]["name"]))
    {
        echo $_FILES["photos"]["name"].'�ļ��Ѿ�����.';
    }else{
        move_uploaded_file($_FILES["photos"]["tmp_name"],"$dir/".$_FILES["photos"]["name"]);
        echo '�ļ��Ѿ����洢��:'."$dir/".$_FILES["photos"]["name"];
    }
}

//php�ϴ�ͼƬѹ��
function compressImg(){
    $pic_name=date("YmdHis");
    // ����ͼƬ�Ŀ�� $pic_width=500;
    $pic_width=$_POST['width'];
    // ����ͼƬ�ĸ߶� $pic_height=500;
    $pic_height=$_POST['length'];

    if($_FILES['image']['size']) {

        if ($_FILES['image']['type'] == "image/jpeg" || $_FILES['image']['type'] == "image/jpg" || $_FILES['image']['type'] == "image/jpeg") {
            $im = imagecreatefromjpeg($_FILES['image']['tmp_name']);
        } elseif ($_FILES['image']['type'] == "image/x-png") {
            $im = imagecreatefrompng($_FILES['image']['tmp_name']);
        } elseif ($_FILES['image']['type'] == "image/gif") {
            $im = imagecreatefromgif($_FILES['image']['tmp_name']);
        }

        if ($im) {
            if (file_exists($pic_name . '.jpg')) {
                unlink($pic_name . '.jpg');
            }
            $this->ResizeImage($im, $pic_width, $pic_height, $pic_name);
            ImageDestroy($im);
        }
    }
}

//ͼƬѹ��
function ResizeImage($im,$maxwidth,$maxheight,$name){
    //ȡ�õ�ǰͼƬ��С
    $width = imagesx($im);
    $height = imagesy($im);
    //��������ͼ�Ĵ�С
    if(($width > $maxwidth) || ($height > $maxheight)){
        $widthratio = $maxwidth/$width;
        $heightratio = $maxheight/$height;
        if($widthratio < $heightratio){
            $ratio = $widthratio;
        }else{
            $ratio = $heightratio;
        }
        $newwidth = $width * $ratio;
        $newheight = $height * $ratio;

        if(function_exists("imagecopyresampled")){
            $newim = imagecreatetruecolor($newwidth, $newheight);
            imagecopyresampled($newim, $im, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        }else{
            $newim = imagecreate($newwidth, $newheight);
            imagecopyresized($newim, $im, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        }
        ImageJpeg ($newim,$name . ".jpg");
        ImageDestroy ($newim);
    }else{
        ImageJpeg ($im,$name . ".jpg");
    }
}
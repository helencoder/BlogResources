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


/*
 *功能：利用PHP目录和文件函数遍历用户给出目录的所有的文件和文件夹，修改照片名称 后续进行存入excel操作。
 *参数：传入文件夹路径
 *返回：返回excel文件，其中包含原始图片名和更改后图片名的对应
 *
 * */
function Rename($dirname){
    //原图片名数组
    $oldImageName = array();
    //新图片名数组
    $newImageName = array();
    if(!is_dir($dirname)){  //判断是否为一个有效的目录
        echo "{$dirname}目录无效！";
        exit();
    }
    $handle = opendir($dirname);    //打开目录，并传回一个事件句柄
    while(($fn = readdir($handle))!==false){
        if($fn!='.'&&$fn!='..'){    //读取dir后会有.和..目录代表本级以及上级目录。以此进行判断。
            $curDir = $dirname.'/'.$fn;
            if(is_dir($curDir)){    //假如还为文件夹，就继续循环调用此函数。
                fRename($curDir);
            }
            else{   //此为文件，直接进行改名操作。
                //pathinfo() 函数以数组的形式返回文件路径的信息。
                /*包括以下的数组元素：
                    [dirname]
                    [basename]
                    [extension]
                */
                $path = pathinfo($curDir);
                $newname = $path['dirname'].'/'.substr(microtime(),2,8).'.'.$path['extension']; //此处利用微秒函数进行重命名，以防止文件重名。
                rename($curDir,$newname);
                array_push($oldImageName,$curDir);  //将旧图片名加入数组中
                array_push($newImageName,$newname); //将新图片名加入数组中
            }
        }
    }

    //将数组信息写入excel表中。
    //将数组中的元素进行处理
    $num = count($oldImageName);    //获取处理的图片数组的长度
    for($i=0;$i<=$num;$i++){
        $oldImageName[$i] = substr($oldImageName[$i],9);    //去除图片名所含的路径
        $newImageName[$i] = substr($newImageName[$i],9);    //去除图片名所含的路径
    }
    //dump($oldImageName);
    //dump($newImageName);

    $dir = $_SERVER['DOCUMENT_ROOT'];  //找出项目的根路径
    require '/PHPExcel_1.8.0/Classes/PHPExcel.php'; //添加读取excel所需的类文件（PHPExcel）

    $objPHPExcel = new \PHPExcel();                     //实例化一个PHPExcel()对象
    $objSheet = $objPHPExcel->getActiveSheet();        //选取当前的sheet对象
    //$objSheet->setTitle('helen');                      //对当前sheet对象命名
    //常规方式：利用setCellValue()填充数据
    //$objSheet->setCellValue("A1","张三")->setCellValue("B1","李四");   //利用setCellValues()填充数据
    //取巧模式：利用fromArray()填充数据

    //更改文件名编码
    for($i=0;$i<$num;$i++){
        $oldImageName[$i] = mb_convert_encoding($oldImageName[$i],"UTF-8","GBK");   //此处一定要记得将转换为的字符串存下来！！！
    }

    $arr = array();
    for($i=0;$i<$num;$i++){
        $tmp = array("","$oldImageName[$i]","$newImageName[$i]");
        array_push($arr,$tmp);
    }
    $objSheet->fromArray($arr);  //利用fromArray()直接一次性填充数据
    $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');   //设定写入excel的类型
    $objWriter->save($dir.'/logo2.xlsx');       //保存文件，后面为设置excel文件名
}

/*
 * 功能：PHP处理图片上传，转存函数
 * */
function uploadImg(){
    if ($_FILES["photos"]["error"] > 0)
    {
        echo '错误:'.$_FILES["photos"]["error"].'<br />';
    }else {
        echo '文件名:'.$_FILES["photos"]["name"].'<br />';
        echo '类型:'.$_FILES["photos"]["type"].'<br />';
        echo '大小:'.($_FILES["photos"]["size"] / 1024).'Kb<br />';
        echo '存储位置:'.$_FILES["photos"]["tmp_name"];
    }
    //文件上传路径
    $dir = $_SERVER['DOCUMENT_ROOT'].'weixin/Images';
    var_dump($dir);
    //文件处理
    if (file_exists("$dir/".$_FILES["photos"]["name"]))
    {
        echo $_FILES["photos"]["name"].'文件已经存在.';
    }else{
        move_uploaded_file($_FILES["photos"]["tmp_name"],"$dir/".$_FILES["photos"]["name"]);
        echo '文件已经被存储到:'."$dir/".$_FILES["photos"]["name"];
    }
}

//php上传图片压缩
function compressImg(){
    $pic_name=date("YmdHis");
    // 生成图片的宽度 $pic_width=500;
    $pic_width=$_POST['width'];
    // 生成图片的高度 $pic_height=500;
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

//图片压缩
function ResizeImage($im,$maxwidth,$maxheight,$name){
    //取得当前图片大小
    $width = imagesx($im);
    $height = imagesy($im);
    //生成缩略图的大小
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
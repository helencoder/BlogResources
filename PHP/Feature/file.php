<?php
/**
 * Created by PhpStorm.
 * User: helen
 * Date: 16-5-14
 * Time: 上午11:13
 */

/**
 * 上传文件
 */
$uploaddir = '/var/www/uploads/';
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

echo '<pre>';
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
    echo "File is valid, and was successfully uploaded.\n";
} else {
    echo "Possible file upload attack!\n";
}

echo 'Here is some more debugging info:';
print_r($_FILES);

print "</pre>";

/**
 * 上传一组文件
 */

/*
 * HTML数组属性
   <form action="" method="post" enctype="multipart/form-data">
        <p>
        Pictures:
            <input type="file" name="pictures[]" />
            <input type="file" name="pictures[]" />
            <input type="file" name="pictures[]" />
            <input type="submit" value="Send" />
        </p>
   </form>
*/

foreach ($_FILES["pictures"]["error"] as $key => $error) {
    if ($error == UPLOAD_ERR_OK) {
        $tmp_name = $_FILES["pictures"]["tmp_name"][$key];
        $name = $_FILES["pictures"]["name"][$key];
        move_uploaded_file($tmp_name, "data/$name");
    }
}

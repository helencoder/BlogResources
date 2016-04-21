<?php
/**
 * Author: helen
 * CreateTime: 2016/4/21 9:07
 * description: 文件处理--SplFileInfo
 */

$file = new SplFileInfo('autoload.php');
echo $file->getExtension();

$file = new SplFileObject('autoload.php','r');
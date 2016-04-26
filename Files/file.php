<?php
/**
 * Author: helen
 * CreateTime: 2016/4/21 19:13
 * description: ÎÄ¼þ±éÀú
 */
date_default_timezone_set('PRC');
$file = new FilesystemIterator('.');
/*$file->rewind();
while($file->valid()){
    printf("%s\t%s\t%8s\t%s\n",
        date('Y-m-d H:i:s',time()),
        $file->isDir()?"<DIR>":"",
        $file->getSize(),
        $file->getFilename()
        );
    $file->next();
}*/
foreach($file as $it){

}
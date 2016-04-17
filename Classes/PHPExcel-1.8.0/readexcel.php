<?php
/**
 * Author: helen
 * CreateTime: 2016/4/17 18:08
 * description: 利用PHPExcel操作读取Excel文件函数
 */
function readexcel(){
    Vendor('PHPExcel.PHPExcel');
    Vendor('PHPExcel.PHPExcel.IOFactory');
    Vendor('PHPExcel.PHPExcel.Reader.Excel2007');
    $objReader = \PHPExcel_IOFactory::createReader('Excel2007');/*Excel5 for 2003 excel2007 for 2007*/
    $filename = APP_PATH.'Home/Data/demo.xlsx'; //处理的Excel文件名
    $objPHPExcelReader = \PHPExcel_IOFactory::load($filename);  //加载excel文件
    $objPHPExcel = $objReader->load($filename); //Excel 路径
    $sheet = $objPHPExcelReader->getSheet(0);
    $highestRow = $sheet->getHighestRow(); // 取得总行数
    $highestColumn = $sheet->getHighestColumn(); // 取得总列数
    /*方法一*/
    $str = '';
    $strs=array();
    for ($j=1;$j<=$highestRow;$j++){//从第一行开始读取数据
        /*注销上一行读取数据*/
        unset($str);
        unset($strs);
        for($k='A';$k<=$highestColumn;$k++){//从A列读取数据
            //实测在excel中，如果某单元格的值包含了||||||导入的数据会为空
            $str = $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue().'||||||';//读取单元格
        }
        //explode:函数把字符串分割为数组。
        $strs = explode("||||||",$str);
        echo $strs;
        //$sql = "INSERT INTO te() VALUES ( '{$strs[0]}','{$strs[1]}', '{$strs[2]}','{$strs[3]}','{$strs[4]}')";
        //echo $sql.'<br>';
    }
    /*方法二【推荐】*/
    /* $objWorksheet = $objPHPExcel->getActiveSheet();
     $highestRow = $objWorksheet->getHighestRow();   // 取得总行数
     $highestColumn = $objWorksheet->getHighestColumn();
     $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);//总列数

     for ($row = 1;$row <= $highestRow;$row++)         {
         $strs=array();
         //注意highestColumnIndex的列数索引从0开始
         for ($col = 0;$col < $highestColumnIndex;$col++)            {
             $strs[$col] =$objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
         }
         print_r($strs);
     }*/
}
//利用PHPExcel读取excel文件的函数
function read(){

    @ini_set('memory_limit', '512M');//设置PHP能使用的内存大小
    set_time_limit(0);  //设置超时时间为0，即为永不超时
    Vendor('PHPExcel.PHPExcel');    //thinkphp中引入第三方类库的方法。
    Vendor('PHPExcel.PHPExcel.IOFactory');

    $objPHPExcel = new \PHPExcel(); //实例化类对象

    /*$objSheet = $objPHPExcel->getActiveSheet();
    $currentSheet = $objPHPExcel->getSheet(0);  //读取excel文件中的第一个工作表
    $allColumn = $currentSheet->getHighestColumn(); //取得最大的列号
    $allRow = $currentSheet->getHighestRow(); //取得一共有多少行*/
    //$objSheet = $objPHPExcel->getSheet(0);

    $filename = APP_PATH.'Home/Data/testexcel.xlsx'; //处理的Excel文件名
    $objPHPExcelReader = \PHPExcel_IOFactory::load($filename);  //加载excel文件

    $array = array(array());  //创建二维数组
    //这种方式可以循环读取excel的不同sheet，并加入到二维数组中，但前面的sheet会被后面的sheet覆盖！！！
    foreach($objPHPExcelReader->getWorksheetIterator() as $sheet)  //循环读取sheet
    {
        foreach($sheet->getRowIterator() as $row)  //逐行处理
        {
            if($row->getRowIndex()<1)  //确定从哪一行开始读取
            {
                continue;
            }
            $j = 1;
            foreach($row->getCellIterator() as $cell)  //逐列读取
            {
                $i = $row->getRowIndex();
                $data = $cell->getValue(); //获取cell中数据
                //echo $data;
                //array_push($str[$i][$j],$data);
                $array[$i][$j] = $data;
                $j++;
                //$str .= $data;
            }
            //echo '<br/>';
        }
    }
    return $array;  //二维数组保存相关信息
}
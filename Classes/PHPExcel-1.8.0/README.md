# PHPExcel--PHP操作Excel类
============================
PHPExcel提供了PHP操作Excel文件的类，可以提供向Excel文件中进行信息的插入，以及相应信息的输出。
可以操作xls、xlsx文件，同时提供多种数据插入方式，对于PHP开发者操作Excel数据表提供了极大的便利

目录结构
-------------------
      Classes/               PHPExcel类的核心文件
      Documentation/         PHPExcel类的API以及Demo模板
      Examples/              PHPExcel类的简单使用示例

### 使用方法

1、首先引入PHPExcel类的核心类库
```php
include_once '/PHPExcel_1.8.0_doc/Classes/PHPExcel.php';
include_once '/PHPExcel_1.8.0_doc/Classes/PHPExcel/IOFactory.php';
```
2、实例化PHPExcel类
```php
$objPHPExcel = new PHPExcel();                     //实例化一个PHPExcel()对象
$objSheet = $objPHPExcel->getActiveSheet();        //选取当前的sheet对象
$objSheet->setTitle('helen');                      //对当前sheet对象命名
```
3、数据的插入，此处提供两种方式。
```php
    //常规方式：利用setCellValue()填充数据
    $objSheet->setCellValue("A1","张三")->setCellValue("B1","李四");   //利用setCellValues()填充数据
    //取巧模式：利用fromArray()填充数据
    $array = array(
         array("","B1","张三"),
         array("","B2","李四")
    );
    $objSheet->fromArray($array);  //利用fromArray()直接一次性填充数据
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');   //设定写入excel的类型
    $objWriter->save($dir.'/test.xlsx');       //保存文件
```
4、数据的读取。
```php
    $filename = '/Data/test.xls'; //处理的Excel文件名
    $objPHPExcelReader = PHPExcel_IOFactory::load($filename);  //加载excel文件

    foreach($objPHPExcelReader->getWorksheetIterator() as $sheet)  //循环读取sheet
    {
         foreach($sheet->getRowIterator() as $row)  //逐行处理
         {
             if($row->getRowIndex()<2)  //确定从哪一行开始读取
             {
                 continue;
             }
             foreach($row->getCellIterator() as $cell)  //逐列读取
             {
                 $data = $cell->getValue(); //获取cell中数据
                 echo $data;
             }
             echo '<br/>';
         }
    }
```

### 相关资料


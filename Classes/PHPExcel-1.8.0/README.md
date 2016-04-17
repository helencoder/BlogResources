# PHPExcel--PHP����Excel��
============================
PHPExcel�ṩ��PHP����Excel�ļ����࣬�����ṩ��Excel�ļ��н�����Ϣ�Ĳ��룬�Լ���Ӧ��Ϣ�������
���Բ���xls��xlsx�ļ���ͬʱ�ṩ�������ݲ��뷽ʽ������PHP�����߲���Excel���ݱ��ṩ�˼���ı���

Ŀ¼�ṹ
-------------------
      Classes/               PHPExcel��ĺ����ļ�
      Documentation/         PHPExcel���API�Լ�Demoģ��
      Examples/              PHPExcel��ļ�ʹ��ʾ��

### ʹ�÷���

1����������PHPExcel��ĺ������
```php
include_once '/PHPExcel_1.8.0_doc/Classes/PHPExcel.php';
include_once '/PHPExcel_1.8.0_doc/Classes/PHPExcel/IOFactory.php';
```
2��ʵ����PHPExcel��
```php
$objPHPExcel = new PHPExcel();                     //ʵ����һ��PHPExcel()����
$objSheet = $objPHPExcel->getActiveSheet();        //ѡȡ��ǰ��sheet����
$objSheet->setTitle('helen');                      //�Ե�ǰsheet��������
```
3�����ݵĲ��룬�˴��ṩ���ַ�ʽ��
```php
    //���淽ʽ������setCellValue()�������
    $objSheet->setCellValue("A1","����")->setCellValue("B1","����");   //����setCellValues()�������
    //ȡ��ģʽ������fromArray()�������
    $array = array(
         array("","B1","����"),
         array("","B2","����")
    );
    $objSheet->fromArray($array);  //����fromArray()ֱ��һ�����������
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');   //�趨д��excel������
    $objWriter->save($dir.'/test.xlsx');       //�����ļ�
```
4�����ݵĶ�ȡ��
```php
    $filename = '/Data/test.xls'; //�����Excel�ļ���
    $objPHPExcelReader = PHPExcel_IOFactory::load($filename);  //����excel�ļ�

    foreach($objPHPExcelReader->getWorksheetIterator() as $sheet)  //ѭ����ȡsheet
    {
         foreach($sheet->getRowIterator() as $row)  //���д���
         {
             if($row->getRowIndex()<2)  //ȷ������һ�п�ʼ��ȡ
             {
                 continue;
             }
             foreach($row->getCellIterator() as $cell)  //���ж�ȡ
             {
                 $data = $cell->getValue(); //��ȡcell������
                 echo $data;
             }
             echo '<br/>';
         }
    }
```

### �������


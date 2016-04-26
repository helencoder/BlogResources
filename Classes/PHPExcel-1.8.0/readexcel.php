<?php
/**
 * Author: helen
 * CreateTime: 2016/4/17 18:08
 * description: ����PHPExcel������ȡExcel�ļ�����
 */
function readexcel(){
    Vendor('PHPExcel.PHPExcel');
    Vendor('PHPExcel.PHPExcel.IOFactory');
    Vendor('PHPExcel.PHPExcel.Reader.Excel2007');
    $objReader = \PHPExcel_IOFactory::createReader('Excel2007');/*Excel5 for 2003 excel2007 for 2007*/
    $filename = APP_PATH.'Home/Data/demo.xlsx'; //�����Excel�ļ���
    $objPHPExcelReader = \PHPExcel_IOFactory::load($filename);  //����excel�ļ�
    $objPHPExcel = $objReader->load($filename); //Excel ·��
    $sheet = $objPHPExcelReader->getSheet(0);
    $highestRow = $sheet->getHighestRow(); // ȡ��������
    $highestColumn = $sheet->getHighestColumn(); // ȡ��������
    /*����һ*/
    $str = '';
    $strs=array();
    for ($j=1;$j<=$highestRow;$j++){//�ӵ�һ�п�ʼ��ȡ����
        /*ע����һ�ж�ȡ����*/
        unset($str);
        unset($strs);
        for($k='A';$k<=$highestColumn;$k++){//��A�ж�ȡ����
            //ʵ����excel�У����ĳ��Ԫ���ֵ������||||||��������ݻ�Ϊ��
            $str = $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue().'||||||';//��ȡ��Ԫ��
        }
        //explode:�������ַ����ָ�Ϊ���顣
        $strs = explode("||||||",$str);
        echo $strs;
        //$sql = "INSERT INTO te() VALUES ( '{$strs[0]}','{$strs[1]}', '{$strs[2]}','{$strs[3]}','{$strs[4]}')";
        //echo $sql.'<br>';
    }
    /*���������Ƽ���*/
    /* $objWorksheet = $objPHPExcel->getActiveSheet();
     $highestRow = $objWorksheet->getHighestRow();   // ȡ��������
     $highestColumn = $objWorksheet->getHighestColumn();
     $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);//������

     for ($row = 1;$row <= $highestRow;$row++)         {
         $strs=array();
         //ע��highestColumnIndex������������0��ʼ
         for ($col = 0;$col < $highestColumnIndex;$col++)            {
             $strs[$col] =$objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
         }
         print_r($strs);
     }*/
}
//����PHPExcel��ȡexcel�ļ��ĺ���
function read(){

    @ini_set('memory_limit', '512M');//����PHP��ʹ�õ��ڴ��С
    set_time_limit(0);  //���ó�ʱʱ��Ϊ0����Ϊ������ʱ
    Vendor('PHPExcel.PHPExcel');    //thinkphp��������������ķ�����
    Vendor('PHPExcel.PHPExcel.IOFactory');

    $objPHPExcel = new \PHPExcel(); //ʵ���������

    /*$objSheet = $objPHPExcel->getActiveSheet();
    $currentSheet = $objPHPExcel->getSheet(0);  //��ȡexcel�ļ��еĵ�һ��������
    $allColumn = $currentSheet->getHighestColumn(); //ȡ�������к�
    $allRow = $currentSheet->getHighestRow(); //ȡ��һ���ж�����*/
    //$objSheet = $objPHPExcel->getSheet(0);

    $filename = APP_PATH.'Home/Data/testexcel.xlsx'; //�����Excel�ļ���
    $objPHPExcelReader = \PHPExcel_IOFactory::load($filename);  //����excel�ļ�

    $array = array(array());  //������ά����
    //���ַ�ʽ����ѭ����ȡexcel�Ĳ�ͬsheet�������뵽��ά�����У���ǰ���sheet�ᱻ�����sheet���ǣ�����
    foreach($objPHPExcelReader->getWorksheetIterator() as $sheet)  //ѭ����ȡsheet
    {
        foreach($sheet->getRowIterator() as $row)  //���д���
        {
            if($row->getRowIndex()<1)  //ȷ������һ�п�ʼ��ȡ
            {
                continue;
            }
            $j = 1;
            foreach($row->getCellIterator() as $cell)  //���ж�ȡ
            {
                $i = $row->getRowIndex();
                $data = $cell->getValue(); //��ȡcell������
                //echo $data;
                //array_push($str[$i][$j],$data);
                $array[$i][$j] = $data;
                $j++;
                //$str .= $data;
            }
            //echo '<br/>';
        }
    }
    return $array;  //��ά���鱣�������Ϣ
}
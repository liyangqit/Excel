<?php

//php 导入excel
header("content-type:text/html;charset=utf-8");         //设置编码
$dir = dirname(__FILE__);
require  "PHPExcel/PHPExcel/IOFactory.php"; //引入读取excel的文件

$filename = "./a.xlsx";
//选择加载
$fileType = PHPExcel_IOFactory::identify($filename); //获取文件的类型 xls xlsx
$objReader = PHPExcel_IOFactory::createReader($fileType); //获取文件读取操作对象
$sheetName = "张一绝公司"; //如果获取多个表 只需将sheet表名 放在数组中即可

$objReader -> setLoadSheetsOnly($sheetName);   //只加载指定的sheet

$objPHPExcel = $objReader -> load($filename);  //加载文件

//$objPHPExcel = PHPExcel_IOFactory::load($filename);  ////加载文件  不管有多少sheet表 都全部加载进来
///
//$sheetCount = $objPHPExcel -> getSheetCount(); //获取表中的sheet个数
//
//for ($i = 0; $i<$sheetCount;$i++){
//    $data = $objPHPExcel -> getSheet($i) -> toArray();
//    print_r($data);
//}

//使用excel的迭代器

foreach ($objPHPExcel -> getWorksheetIterator() as $sheet){  //循环每一个sheet表

      foreach ($sheet -> getRowIterator() as $row){  //循环每一个sheet表里的 行
          if ($row -> getRowIndex() < 2){  //从第二行开始取数据
              continue;
          }
           foreach ($row -> getCellIterator() as $cell){ //循环每个行里的列
               $data['name'] = $cell -> getValue();   //获取单元格数据
               var_dump($data);
               echo "  ";
           }
          echo "<br >";
      }
      echo "<br >";
}






<?php

//导出excel
require  "PHPExcel/PHPExcel.php";

    $dir = dirname(__FILE__);
    $objExcel = new PHPExcel();  //实例化这个对象 相当于在桌面上新建一个excel文件

    $objSheet = $objExcel -> getActiveSheet();  //获得当前活动的sheet表对象

    $objSheet -> setTitle("张一绝公司");  //给当前活动sheet表重命名

       $objSheet -> setCellValue("A1","姓名")
                 -> setCellValue("B1","性别");   //给当前活动单元格插入值

        $objSheet -> setCellValue("A2","李洋")
                  -> setCellValue("B2","男");     //给当前活动单元格插入值

        //默认是第一个数组 就是excel表格的第一行数据， 每一个数组里面的第一个值就是excel表格的第一列值
     $data = [
                [],
                ["","名称","价格"],
               ["","我是名称","123元"]
          ];
     $objSheet -> fromArray($data);
    //将数组参数传过去即可  不建议使用这种方式  比较耗内存 ，
    //而且对excel的其他工作不好处理，比如加样式生成图标等等
    //PHPExcel_IOFactory::createWriter($objExcel,"Excel5"); //以xls格式保存
$objWrite = PHPExcel_IOFactory::createWriter($objExcel,"Excel2007"); // 以xlsx格式保存

$objWrite -> save($dir . "/将天下.xlsx"); // 保存文件










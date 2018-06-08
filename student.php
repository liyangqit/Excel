<?php
//导出excel
require  "config.php";
require  "db.php";
require  "PHPExcel/PHPExcel.php";

$dir = dirname(__FILE__);
$db = new  Db($config);
$objPHPExcel = new PHPExcel();  //创建excel表

//创建三个sheet表  其中一个是默认就有的
for ($i=1;$i<=3;$i++){
    if ($i > 1){  //大于1才创建
        $objPHPExcel -> createSheet();  //创建新的内置表
    }
    $objPHPExcel -> setActiveSheetIndex($i-1);    //将新创建的sheet设置为当前活动表,下标从0开始
    $objSheet = $objPHPExcel -> getActiveSheet(); //获取当前活动表
    $objSheet -> setTitle($i . "年级");  //给每一个sheet表重命名

    $data = $db -> getGrade($i);  //获得的是二维数组  //数据库读取的数据

    $objSheet -> setCellValue("A1","姓名")
              -> setCellValue("B1","分数")
              -> setCellValue("C1","班级");

    $j = 2;  //设置变量 从第二行开始插入数据
    foreach ($data as $k => $v){
        $objSheet -> setCellValue("A".$j,$v['name'])
                  -> setCellValue("B".$j,$v['score'])
                  -> setCellValue("C".$j,$v['class']."班");

        $j++;  //累加
    }

}
        //$objWrite = PHPExcel_IOFactory::createWriter($objPHPExcel,"Excel5"); //保存xls后缀的文件
        $objWrite = PHPExcel_IOFactory::createWriter($objPHPExcel,"Excel2007"); //保存xlsx后缀的文件

        //$objWrite -> save($dir . "/export_1.xlsx");  //文件的保存路径
        brower_export("Excel2007","browser_export.xlsx");  //下载文件 （输出到浏览器）

        $objWrite ->save("php://output");  //


function brower_export($type,$filename){
    if ($type == "Excel2007"){
        //告诉浏览器是xlsx格式的文件
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }elseif ($type == "Excel5"){
        header('Content-Type: application/vnd.ms-excel');  //告诉浏览器是xls格式的文件
    }
    header('Content-Disposition: attachment;filename="'.$filename.'"');  //文件的名字
    header('Cache-Control: max-age=0');  //禁止浏览器缓存
}


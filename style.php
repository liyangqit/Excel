<?php

//导出excel  并给表格加样式
require  "config.php";
require  "db.php";
require  "PHPExcel/PHPExcel.php";

$dir = dirname(__FILE__);
$db = new  Db($config);
$objPHPExcel = new PHPExcel();  //创建excel表
$objSheet = $objPHPExcel -> getActiveSheet();

//设置字体居中显示
$objPHPExcel -> getDefaultStyle()  //设置默认样式
             -> getAlignment()
             -> setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER) //设置垂直居中
             -> setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //设置水平居中

//设置字体样式
$objPHPExcel -> getDefaultStyle() -> getFont()->setName("微软雅黑")->setSize(14); //设置默认字体大小及样式
//设置年级这一行的字体样式
$objSheet -> getStyle("A2:Z2")->getFont()->setSize(20)->setBold(true);
//设置班级这一行的字体样式
$objSheet -> getStyle("A3:Z3")->getFont()->setSize(16)->setBold(true);
    $index = 0;

    //增加样式
        $grades = $db -> getGrades();
        foreach ($grades as  $g_k => $g_v){
            //填充年级
            $gradeIndex = getCells($index * 2); //获取年级所在列
            $objSheet ->setCellValue($gradeIndex."2","高".$g_v['grade']);
            //查询每个年级下的班级
             $classInfo = $db -> getClassByGrades($g_v['grade']);
            //查询每个年级下的学生信息
              foreach ($classInfo as  $c_k => $c_v){
                  $nameIndex = getCells($index * 2);
                  $scoreIndex = getCells($index * 2 + 1);
                  //合并班级的单元格
                  $objSheet -> mergeCells($nameIndex."3:".$scoreIndex."3");
                  //填充班级
                  $objSheet -> setCellValue($nameIndex."3",$c_v['class']."班");
                  //填充标题
                  $objSheet -> setCellValue($nameIndex ."4","姓名")
                            ->setCellValue($scoreIndex."4","分数");
                  $info = $db -> getInfoByClass($c_v['class'],$g_v['grade']);
                    //从第五行开始填充数据
                     $j = 5;
                  //遍历学生信息
                  foreach ($info as  $s_k => $s_v){
                      //填充数据
                      $objSheet  -> setCellValue($nameIndex.$j,$s_v['name'])
                                 -> setCellValue($scoreIndex.$j,$s_v['score']);
                       $j++;
                  }
                  $index++;

            }
            //合并年级的单元格
            $endGradeIndex = getCells($index * 2 - 1); //获得每个年级的终止单元格
            $objSheet -> mergeCells($gradeIndex."2:".$endGradeIndex."2"); //合并年级的单元格

        }
        //$objWrite = PHPExcel_IOFactory::createWriter($objPHPExcel,"Excel5"); //保存xls后缀的文件
        $objWrite = PHPExcel_IOFactory::createWriter($objPHPExcel,"Excel2007"); //保存xlsx后缀的文件

        $objWrite -> save($dir . "/style.xlsx");  //文件的保存路径
//        brower_export("Excel2007","browser_export.xlsx");  //下载文件 （输出到浏览器）
//        $objWrite ->save("php://output");  //

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


function getCells($index){
    $arr = range("A","Z");  //生成A-Z的有序数组

    return $arr[$index];
}


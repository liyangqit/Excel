<?php

//链接数据库类

class Db{

    public $link = null;

    public function __construct($config)
    {
        $this -> link = mysqli_connect($config['host'],$config['username'],$config['password']) or die(mysqli_error($this ->link));

        mysqli_select_db($this -> link,$config['database']);

        mysqli_query($this -> link,"set names " . $config['charset']) or die(mysqli_error($this -> link));
    }

    //查询数据

    public function select($sql)
    {
        $data =[];
        $query = mysqli_query($this -> link,$sql);
        while ($row = mysqli_fetch_assoc($query)){
            $data[] = $row;
        }
        return $data;
    }

    public function getGrade($grade)
    {
        $sql = "select * from student WHERE grade = ".$grade ." order by score desc";

        $data = $this ->select($sql);
        return $data;
    }


    //查询出所有的年级数
    public function getGrades()
    {
        $sql = "select distinct(grade) from student ORDER BY grade ASC ";  //去重 查询所有的年级数
        $data = $this -> select($sql);
        return $data;
    }

    //通过年级查询所有的班级
    public function getClassByGrades($grade)
    {
        $sql = "select DISTINCT(class) from student WHERE grade = " . $grade ." order by class asc";
        $data = $this -> select($sql);
        return $data;
    }

    //查询每个年级下的学生信息
    public function getInfoByClass($class,$grade)
    {
        $sql = "select name,score from student WHERE  grade = ". $grade . " and class = " .$class;

        $data = $this -> select($sql);

        return $data;
    }


}
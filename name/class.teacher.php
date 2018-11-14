<?php

class Teacher{
    
    // Массив info:
    // id
    // name
    // email
    // login
    // password
    private $info = array();
    private $courses = array();
    private $ClassFactory;
    private $SQLBase;
    
    function __construct(array $info){
        $this->ClassFactory = Factory::GetInstance();
        $info = array_values($info);
        $this->info['id'] = $info[0];
        $this->info['name'] = $info[1];
        $this->info['email'] = $info[2];
        $this->info['login'] = $info[3];
        $this->info['password'] = $info[4];
    }
    function __destruct(){}
    
    public function GetInfo(){
        return $this->info;
    }
    public function SetInfo(){}
    public function GetCourses() {
        if (!$this->courses){
            $this->SetCourses();
        }
        $resultCoursesInfo = array();
        foreach ($this->courses as $course){
            array_push($resultCoursesInfo, $course->GetInfo());
        }
        return $resultCoursesInfo;
        
    }
    public function SetCourses() {
        $this->SQLBase = DBSQL::GetInstance();
        $myID = $this->info['id'];
        $rs = $this->SQLBase->select('course_id', 'teacher_course', "`teacher_id` = '$myID'");
        foreach($rs as $oneCourse){
            $this->courses[] = $this->ClassFactory->GetObjects('Course', $oneCourse);
        }
    }
}


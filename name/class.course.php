<?php


class Course{
    
    // Массив info:
    // id
    // title
    // description
    // login
    // password
    private $info = array();
    
    private $teacher;
    private $labs = array();
    private $ClassFactory;
    
    function __construct(array $info){
        $this->ClassFactory = Factory::GetInstance();
        $info = array_values($info);
        $this->info['id'] = $info[0];
        $this->info['title'] = $info[1];
        $this->info['description'] = $info[2];
        $this->info['login'] = $info[3];
        $this->info['password'] = $info[4];
        $this->ClassFactory->GetObjects('Lab');
    }
    
    function __destruct(){}
     
    public function GetInfo(){
        return $this->info;
    }
    public function SetInfo(){}
    public function GetTeachers() {}
    public function SetTeacher() {}
    public function GetLab() {
        if (!$this->labs){
            $condition = array();
            $condition['course_id'] = $this->info['id'];
            $this->labs = $this->ClassFactory->GetObjects("Lab", $condition);
        }
        return $this->labs;  
    }
    
    public function  GetLastLabNumber(){
        $lastLabNumber = 0;
        foreach ($this->labs as $lab){
            $labNumber = intval($lab->GetInfo()['number']);
            if ($labNumber > $lastLabNumber){
                $lastLabNumber = $labNumber;
            }
        }
        return $lastLabNumber;
    }
    
    public function SetLab($lab) {
        array_push($this->labs, $lab);
    }
}


<?php

class Lab{
    
    
    // Массив info:
    // id
    // number
    // title
    // task
    // attachments
    // access
    // course_id
    private $info = array();
    private $labResult;
    private $SQLBase;
    
    function __construct(array $info){
        $info = array_values($info);
        $this->info['id'] = $info[0];
        $this->info['number'] = $info[1];
        $this->info['title'] = $info[2];
        $this->info['task'] = $info[3];
        $this->info['attachments'] = $info[4];
        $this->info['access'] = $info[5];
        $this->info['course_id'] = $info[6];
    }
    function __destruct(){}
    
    public function GetInfo(){
        return $this->info;
    }
    public function SetInfo(){}
    public function GetAttachments() {}
    public function SetAttachments() {}
    
    public function GetCourse($id) {
        
    }
    
    public function SetCourse() {}
    public function GetLabResult() {}
    
    public function SetLabResult() {}
}



<?php

class Student{
   
    // Массив info:
    // id
    // name
    // learn_group
    private $info = array();
    private $SQLBase;
    
    function __construct(array $info){
        $info = array_values($info);
        $this->info['id'] = $info[0];
        $this->info['name'] = $info[1];
        $this->info['learn_group'] = $info[2];
    }
    function __destruct(){}
    
    public function GetInfo(){
        return $this->info;
    }
    public function SetInfo(){}
    public function GetGroup() {}
    public function SetGroup() {}
}

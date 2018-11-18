<?php

class Student{
   
    // Массив info:
    // id
    // name
    // learn_group
    private $info = array();
    
    function __construct(array $info){
        $info = array_values($info);
        $this->info['id'] = $info[0];
        $this->info['name'] = $info[1];
        $this->info['learn_group'] = $info[2];
    }
    
    /**
     * Получить информацию об объекте
     * @return array - информация о студенте из БД
     */
    public function GetInfo(){
        return $this->info;
    }
   
//    Пока не успользуется
//    private $SQLBase;
//    function __destruct(){}
//    public function SetInfo(){}
//    public function GetGroup() {}
//    public function SetGroup() {}
}

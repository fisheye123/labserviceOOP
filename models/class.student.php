<?php

class Student extends Unit{
   
    // Массив info:
    // id
    // name
    // learn_group
    protected $info = array();
    
    protected $duplicateFields = array('name', 'learn_group');
    protected $duplicateOperator = 'and';
    
    function __construct(array $info = null, $facrory = null){
        if ($facrory === null){
            $this->ClassFactory = new Factory();
        } else {
            $this->ClassFactory = $facrory;
        }
        // Если info пустое, то наш объект - пустышка, необходимая
        // для инициализации объекта в БД. То бишь, будет вызвана 
        // функция SelfCreate
        if ($info != null){
            $this->SetInfo($info);
        }
    }
    
    /**
     * Получить информацию об объекте
     * @return array - информация о студенте из БД
     */
    
    public function SetInfo($info) {
        $info = array_values($info);
        $this->id = $info[0];
        $this->info['name'] = $info[1];
        $this->info['learn_group'] = $info[2];
    }
    
    public function UpdateInfo($info) {
        $info = array_values($info);
        $this->info['name'] = $info[0];
        $this->info['learn_group'] = $info[1];
    }
   
//    Пока не успользуется
//    private $SQLBase;
//    function __destruct(){}
//    public function SetInfo(){}
//    public function GetGroup() {}
//    public function SetGroup() {}
}

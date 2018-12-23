<?php

// Класс лабораторных работ
class Lab extends Unit{
    
    // Массив info:
    // id
    // number
    // title
    // task
    // attachments
    // access
    // course_id
    protected $info = array();
    
    //TODO: Расширить правила для дубликатов
    protected $duplicateFields = array('title', 'course_id', 'number');
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
        $this->info['number'] = $info[1];
        $this->info['title'] = $info[2];
        $this->info['task'] = $info[3];
        $this->info['attachment'] = $info[4];
        $this->info['access'] = $info[5];
        $this->info['course_id'] = $info[6];
    }
    
    public function UpdateInfo($info) {
        $info = array_values($info);
        $this->info['number'] = $info[0];
        $this->info['title'] = $info[1];
        $this->info['task'] = $info[2];
        $this->info['attachment'] = $info[3];
        $this->info['access'] = $info[4];
        $this->info['course_id'] = $info[5];
    }
    
//    Пока не используется
//    private $labResult;
//    private $SQLBase;
//    function __destruct(){}
//    public function SetInfo(){}
//    public function GetAttachments() {}
//    public function SetAttachments() {}
//    public function GetCourse($id) {}
//    public function SetCourse() {}
//    public function GetLabResult() {}
//    public function SetLabResult() {}
}



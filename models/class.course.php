<?php

class Course{
    
    // Массив info:
    // id
    // title
    // description
    // login
    // password
    private $info = array();
    
    // Лабораторные этого курса
    private $labs = array();
    
    // Фабрика классов
    // Для создания объектов
    private $ClassFactory;
    
    /**
     * Конструктор
     * @param array $info - информация об объекте из БД
     */
    function __construct(array $info){
        $this->ClassFactory = Factory::GetInstance();
        $info = array_values($info);
        $this->info['id'] = $info[0];
        $this->info['title'] = $info[1];
        $this->info['description'] = $info[2];
        $this->info['login'] = $info[3];
        $this->info['password'] = $info[4];
        //$this->ClassFactory->GetObjects('Lab');
    }
    
    /**
     * Получить информацию о объекте
     * @return array - информация о курсе
     */
    public function GetInfo(){
        return $this->info;
    }
    

    
    /**
     * Получение лабораторных работ этого курса
     * @return array - массив лабораторных работ курса
     */
    public function GetLab() {
        if (!$this->labs){
            $condition = array();
            $condition['course_id'] = $this->info['id'];
            $this->labs = $this->ClassFactory->GetObjects("Lab", $condition);
        }
        return $this->labs;  
    }
    
    /**
     * Получение номера последней лабораторной
     * @return integer
     */
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
    
    /**
     * Добавление лабораторной работы в курс (не БД)
     * @param object $lab
     */
    public function SetLab($lab) {
        array_push($this->labs, $lab);
    }
    
    //    Пока не используется
    //    private $teacher;
    //    function __destruct(){}
    //    public function SetInfo(){}
    //    public function GetTeachers() {}
    //    public function SetTeacher() {}
}


<?php

require_once 'class.unit.php';
require_once 'class.file.php';
require_once 'class.result.php';

class Course extends Unit{
    
    // Массив info:
    // id
    // title
    // description
    // login
    // password
    
    protected $duplicateFields = array('title', 'login');
    protected $duplicateOperator = 'or';
    
    
    // Лабораторные этого курса
    private $labs = array();
    
    // Фабрика классов
    // Для создания объектов

    
    /**
     * Конструктор
     * @param array $info - информация об объекте из БД
     */
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
    
    protected function SetInfo($info){
        $info = array_values($info);
        $this->id = $info[0];
        $this->info['title'] = $info[1];
        $this->info['description'] = $info[2];
        $this->info['login'] = $info[3];
        $this->info['password'] = $info[4];
    }
    
    protected function UpdateInfo($info){
        $info = array_values($info);
        $this->info['title'] = $info[0];
        $this->info['description'] = $info[1];
        $this->info['login'] = $info[2];
        $this->info['password'] = $info[3];
    }
    
    
    /**
     * Получение лабораторных работ этого курса
     * @return array - массив лабораторных работ курса
     */
    public function GetLab() {
        
        if (!$this->labs){//если еще не созданы
            $condition = array();
            $condition['course_id'] = $this->id;
            $this->labs = $this->ClassFactory->GetObjects("lab", $condition);
        }
        return $this->labs;  
    }
    
    /**
     * Добавление лабораторной работы в курс (не БД)
     * @param object $lab
     */
    public function SetLab($lab) {
        array_push($this->labs, $lab);
    }
    
    public function ShowLabs($labid = null, $checkAccess = true){
        $resultLabInfo = array(); 
        $conditions = array();
        $conditions['course_id'] = $this->id;
        if ($checkAccess)
            $conditions['access'] = 1;
        if ($labid){
            $conditions['id'] = $labid;
        }
        
        $resultLab = $this->ClassFactory->GetObjects('lab', $conditions);
        
        if ($resultLab == null)
            return null;

        foreach ($resultLab as $lab){
            array_push($resultLabInfo, $lab->GetInfo());
        }
        return $resultLabInfo;
    }
    
    public function ShowStudents($labid = null, $checkAccess = true){
        $this->SQLBase = DBSQL::GetInstance();
        
        $resultStudentInfo = array();
        
        $this->SQLBase->SetWhere(array('course_id' => $this->id));
        $result = $this->SQLBase->select('*', 'student_course');
        
        if (!$result)
            return null;
        
        $studentsId = $this->SQLBase->GetLastResult();
        $resultId = array();
        foreach ($studentsId as $studentInfo){
            array_push($resultId, $studentInfo['student_id']);
        }
        
        
        $resultStudents=array();
        
        foreach ($resultId as $key => $id){
            array_push($resultStudents,
                    $this->ClassFactory->GetObjects('student',
                            array ('id' => $id))[0]);
        }
        
        if ($resultStudents == null)
            return null;
        if ($labid)
            $goodStudents = $this->GetStudentWithLabExec($labid);
        
        foreach ($resultStudents as $student){
            $studentResultInfo = $student->GetInfo();
            if (isset($goodStudents[$studentResultInfo['id']])){
                    $studentResultInfo['state'] = 'disabled';
                    $studentResultInfo['name'] .= '(сделано)';
            }
            else
                $studentResultInfo['state'] = 'enabled';
            array_push($resultStudentInfo, $studentResultInfo);
        }
        
        return $resultStudentInfo;
    }
    
    private function GetStudentWithLabExec($labId){
        $resultStudents = array();
        $this->SQLBase->SetWhere(array('lab_id' =>
                $labId));
        $rs = $this->SQLBase->select('id', 'lab_exec');
        if (!$rs)
            return null;
        
        $labResults = $this->SQLBase->GetLastResult();

        $labResultWhereArray = array('lab_exec_id' => array());
        foreach ($labResults  as $resultId){
            array_push($labResultWhereArray['lab_exec_id'], $resultId['id']);
        }
        
        $this->SQLBase->SetWhere($labResultWhereArray, 'OR');
        $rs = $this->SQLBase->select('student_id', 'student_lab_exec');

        if (!$rs)
            return null;
        
        $studentsId = $this->SQLBase->GetLastResult();
        foreach ($studentsId as $idArray){
            $resultStudents[$idArray['student_id']] = true;
        }
        return $resultStudents;
        
    }
    
    public function SetAnswer($labId, $answer, $students, $myFile = null) {
        if (!$this->CheckEmptyParams(array($labId, $answer, $students)))
                return 'Не заполнены обязательные поля';
        $filename = null;
        if ($myFile['size'] != 0){
            $file = new File();
            $filename = $file->SaveFile($myFile);
            if (!$filename){
                return $file->GetError();
            }
        }
        
        $newResult = new LabResult();
        $rs = $newResult->InsertNew($labId, $answer, $students, $filename);
        if (!$rs){
            return 'Ошибка добавления лабораторной работы';
        }
        
        return 'Ура, товарищи, все получилось!';
        
    }
    
}


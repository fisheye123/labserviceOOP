<?php

require_once 'class.db.php';

class LabResult {
    private $labId;
    private $labResultId;
    private $answer;
    private $students = array();
    private $studentsNames;
    private $studentsGroup;
    private $file;
    private $grade;
    
    private $SQLBase;
    
    //Делаем этот класс строго специализированным - задача нетривиальна
    function __construct(){
        $this->SQLBase = DBSQL::GetInstance();
        $args = func_num_args();
        if ($args == 1)
            $this->__initResultFromDb(func_get_arg(0));
        else if ($args > 1)
            throw new Exception('Method not implemented');
    }
    
    private function __initResultFromDb($id){
        $this->labResultId = $id;
        
        //Заполним поле id лабораторной
        $this->SQLBase->SetWhere(array('id' => $this->labResultId));
        $rs = $this->SQLBase->select('lab_id', 'lab_exec');
        if (!$rs)
            return;
        $this->labId = $this->SQLBase->GetLastResult()[0]['lab_id'];
        
        //Заполним поле студентов
        $this->SQLBase->SetWhere(array('lab_exec_id' => $this->labResultId));
        $rs = $this->SQLBase->select('*', 'student_lab_exec');
        if (!$rs)
            return;
        foreach ($this->SQLBase->GetLastResult() as $key => $result)
            array_push($this->students, $result['student_id']);
        
        //Оценка
        $this->grade = $this->SQLBase->GetLastResult()[0]['mark'];
       
        //заполним поля file и answer
        $this->SQLBase->SetWhere(array('lab_exec_id' => $this->labResultId));
        $rs = $this->SQLBase->select('*', 'lab_history');
        if (!$rs)
            return;
        $history = $this->SQLBase->GetLastResult()[0];
        $this->answer = $history['answer'];
        $this->file = $history['attachment'];
    }

    public function GetInfo(){
        $info = array();
        $info['id'] = $this->labResultId;
        $info['lab_id'] = $this->labId;
        $info['answer'] = $this->answer;
        $info['attachment'] = $this->file;
        $info['grade'] = $this->grade;
        if ((!isset($this->studentsNames) || (!isset($this->studentsGroup)))){
            $studentNamesArray = array('id' => array());
            foreach ($this->students  as $key => $studentId)
                array_push($studentNamesArray['id'], $studentId);
            $this->SQLBase->SetWhere($studentNamesArray, 'OR');
            $rs = $this->SQLBase->select('*', 'student');
            
            if (!$rs)
                return null;
            //Создаем строку с именами
            $this->studentsGroup = $this->SQLBase->GetLastResult()[0]['learn_group'];
            $names = array();
            foreach ($this->SQLBase->GetLastResult() as $key => $result)
                array_push($names, $result['name']);
            $this->studentsNames = implode(', ', $names);
        }
        $info['students'] = $this->studentsNames;
        $info['group'] = $this->studentsGroup;
        return $info;
        
    }
    
    public function SetGrade($grade){
        $rs = $this->SQLBase->update('student_lab_exec', 
                array('mark' => $grade), array('lab_exec_id' => $this->labResultId));
        if (!$rs)
            return false;
        
        return true;
        
    }
    

    private function _DBLabResultNewId(){
        $rs = $this->SQLBase->insert('lab_exec', array('lab_id' => $this->labId));
        if (!$rs)
            return -1;
        return $this->SQLBase->GetLastInsertId();
    }
    private function _DBLabResultNewAnswer(){
        date_default_timezone_set('Asia/Tomsk');
        $date = date("y.m.d");
        
        $condArr = array();
        $condArr['date'] = $date;
        $condArr['answer'] = $this->answer;
        $condArr['lab_exec_id'] = $this->labResultId;
        if ($this->file)
            $condArr['attachment'] = $this->file;
        
        return $this->SQLBase->insert('lab_history', $condArr);
    }
    private function _DBLabResultNewSubgroup(){
        foreach ($this->students as $studentId){
            $insertDara = array ('student_id' => $studentId,
                                 'lab_exec_id' => $this->labResultId);
            if (!$this->SQLBase->insert('student_lab_exec', $insertDara))
                    return false;
        }
            return true;
    }
    
    
    
    public function InsertNew($labId, $answer, $students, $file = null){
        $this->labId = $labId;
        $this->answer = $answer;
        $this->file = $file;
        $this->students = explode(',', $students);
        if (($this->labResultId = $this->_DBLabResultNewId($labId)) < 0)
                return false;
        if (!$this->_DBLabResultNewAnswer())
            return false;
        return $this->_DBLabResultNewSubgroup();
    }
    
}

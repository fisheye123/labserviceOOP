<?php
require_once 'class.db.php';
require_once 'class.course.php';
require_once 'class.lab.php';
require_once 'class.student.php';

class Factory{
    protected static $_instance;
    private $SQLBase;
    
    private function __construct(){
        $this->SQLBase = DBSQL::GetInstance();
    }
    
    private function __clone(){}
    
    public static function GetInstance(){
        if (self::$_instance === null) {
            self::$_instance = new self;   
        }
        return self::$_instance;
    }
    
    public function CreateTeacher(){
        
    }
    public function CreateStudent(){}
    public function CreateLab(){}
    public function CreateLabResult(){}
    public function CreateSubgroup(){}
    
    public function GetTeacher($id = ''){
//        if (!$id){
//            $rs = $this->SQLBase->select('*', '`teacher`', '', '`id`');
//        }
//        
//        $returnCourses = array();
//        foreach ($rs as $course){
//            $newCourse = new Course($course['id'], $course['title'], 
//                    $course['desc'], $course['login'], $course['pass']);
//            array_push($returnCourses, $newCourse);
//        }
//        return $returnCourses;
    }
    
    // TODO : прописать варианты кроме all
    public function GetObjects ($objectName, $objectInfo = null){
        $conditionStr = '';
        if ($objectInfo){
            $getInfo = array();
            foreach ($objectInfo as $key => $field){
                array_push($getInfo, "`$key` = '$field'"); 
            }
            $objectInfo = $getInfo;
            $conditionStr = implode($getInfo, ", ");
        }
        $this->SQLBase->select('*', "$objectName", $conditionStr);
        $rs = $this->SQLBase->GetLastResult();
        $returnObjects = array();
        foreach ($rs as $object){
            $newObject = new $objectName($object);
            array_push($returnObjects, $newObject);
        }
        return $returnObjects;
    }
    
    public function CreateObject($objectName, $objectInfo){
        $db = $this->SQLBase->GetDataBase();
        $objectArrayKeys = array_keys($objectInfo);
        $objectArrayValues = array_values($objectInfo);
        $objectArrayValuesStr = $objectArrayValues[0];
        foreach ($objectArrayValues as $key => $field){
            $objectArrayValues[$key] = htmlspecialchars($db->real_escape_string($field));
        }
        $setKeys = '`' . implode("`, `", $objectArrayKeys) . '`';
        $setValues = "'" . implode("', '", $objectArrayValues) . "'";
        $rs = $this->SQLBase->insert($objectName, $setKeys, $setValues);

        if ($rs){
            return $this->GetObjects($objectName);
        }
        return null;
    }
    
    public function EditObject($objectName, $objectInfo, $conditionInfo = null){
        $setInfo = array();
        $setCondition = array();
        foreach ($objectInfo as $key => $field){
            array_push($setInfo, "`$key` = '$field'"); 
        }
        if ($conditionInfo){
            foreach ($conditionInfo as $key => $field){
                array_push($setCondition, "`$key` = '$field'"); 
            }
        } else {
            array_push($setCondition, $setInfo[0]); 
        }
        
        $setStr = implode($setInfo, ", ");
        $condStr = implode($setCondition, ", ");
        $rs = $this->SQLBase->update($objectName, $setStr, $condStr);
        
        if ($rs){
            return $this->GetObjects($objectName);
        }
        return null;
    }
    
    public function DeleteObject($objectName, $objectInfo ){
        $deleteInfo = array();
        foreach ($objectInfo as $key => $field){
            array_push($deleteInfo, "`$key` = '$field'"); 
        }
        
        $deleteStr = implode($deleteInfo, ", ");
        
        $rs = $this->SQLBase->delete($objectName,  $deleteStr);
        if ($rs){
            return $this->GetObjects($objectName);
        }
        return null;
    }
}


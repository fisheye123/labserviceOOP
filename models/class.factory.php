<?php
require_once 'class.db.php';
require_once 'class.course.php';
require_once 'class.lab.php';
require_once 'class.student.php';

// Паттерн проектирования - Фабрика
class Factory{
    private $SQLBase; // Объект базы данных
    
    // Инициализация массивов объектов у нас ленивая
    public function __construct(){
        $this->SQLBase = DBSQL::GetInstance(); // Инициализируем объект базы данных
    }
    
    public function GetObjects($objectName, $objectInfo = null, $objectInfoOperator = null){
        if ($objectInfo){
            $this->SQLBase->SetWhere($objectInfo, $objectInfoOperator);
        }
        $rs = $this->SQLBase->select('*', "$objectName");
        if (!$rs) return null;
        $dbObjectInfo = $this->SQLBase->GetLastResult();
        $factoryObject = array();
        foreach ($dbObjectInfo as $info){
            array_push($factoryObject, new $objectName($info, $this));
        }
        return $factoryObject;
    }
    
    public function GetBlankObject($objectName){
        $rsObject = new $objectName();
        return $rsObject;
    }
    
}


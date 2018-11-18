<?php
require_once 'class.db.php';
require_once 'class.course.php';
require_once 'class.lab.php';
require_once 'class.student.php';

// Паттерн проектирования - фабрика, Singleton
class Factory{
    protected static $_instance; 
    private $SQLBase; // Объект базы данных
    
    private function __construct(){
        $this->SQLBase = DBSQL::GetInstance(); // Инициализируем объект базы данных
    }
    
    private function __clone(){}
    
    public static function GetInstance(){
        if (self::$_instance === null) {
            self::$_instance = new self;   
        }
        return self::$_instance;
    }
    
    /**
     * Функция создания объектов(любого класса)
     * @param string $objectName - имя создаваемых объектов
     * @param array $objectInfo - условие для создания объектов (condition для SELECT)
     * @return array - массив объектов
     * TODO : прописать варианты кроме all
     */
    public function GetObjects ($objectName, $objectInfo = null){
        $conditionStr = '';
        // Если есть условия
        if ($objectInfo){
            $getInfo = array();
            // Переводим массив в строку(с форматированием для БД)
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
    
    /**
     * Функция создания объекта (с записью в БД)
     * @param string $objectName - создаваемый объект
     * @param array $objectInfo - поля для создания объекта в БД
     * @return array массив всех объектов, которые в данный момент существуют или null,
     * если не удалось создать объект
     */
    public function CreateObject($objectName, $objectInfo){
        $db = $this->SQLBase->GetDataBase();
        
        $objectArrayKeys = array_keys($objectInfo);
        $objectArrayValues = array_values($objectInfo);
        
        //Защищаем строки значений, подаваемые в БД
        foreach ($objectArrayValues as $key => $field){
            $objectArrayValues[$key] = htmlspecialchars($db->real_escape_string($field));
        }
        // Собираем каждый массив с строку для команды INSERT
        $setKeys = '`' . implode("`, `", $objectArrayKeys) . '`';
        $setValues = "'" . implode("', '", $objectArrayValues) . "'";
        
        //Делаем запрос, смотрим на результат
        $rs = $this->SQLBase->insert($objectName, $setKeys, $setValues);

        if ($rs){
            return $this->GetObjects($objectName);
        }
        return null;
    }
    
    /**
     * Функция редактирования объекта
     * @param string $objectName - имя объекта
     * @param array $objectInfo - обновленая информация объекта
     * @param array $conditionInfo - условия, которые указывают на изменяемый объект (id = '123')
     * @return array массив всех объектов, которые в данный момент существуют или null,
     * если не удалось изменить объект
     */
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
    
    /**
     * Функция удаления объекта
     * @param stritn $objectName - имя объекта
     * @param array $objectInfo - условие, по которому удаляется объект ('id' = 123)
     * @return array массив всех объектов, которые в данный момент существуют или null,
     * если не удалось удалить объект
     */
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


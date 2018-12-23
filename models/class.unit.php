<?php

//
require_once 'class.db.php';

abstract class Unit{
    
    // У любого наследуемого класса есть id
    // В массиве info id не записываетсся
    protected $id;
    
    protected $info;
    
    protected $duplicateFields;
    protected $duplicateOperator;

    // Объекты классов работают с БД
    protected $SQLBase;
    
    
    public function SelfCreate($objectInfo){
        $this->SQLBase = DBSQL::GetInstance();
        // Делаем проверку на дубликаты
        if ($this->CheckDuplicate($objectInfo) > 0)
            return false;
        // Нам необходим id, поэтому придется делать запрос
        $rs = $this->SQLBase->insert(strtolower(get_class($this)), $objectInfo);
        
        //На самом деле, эта операция нам не нужна
        //Здесь это сделано только потому, что
        //мы не знаем, будем ли мы делать какие-нибудь
        //действия с объектом после создания. Если
        //производительность будет проседать, то убрать.
        if ($rs){
            $this->CheckDuplicate($objectInfo);
            $this->SetInfo($this->SQLBase->GetLastResult()[0]);
        }
        return $rs;
    }
    
    public function SelfUpdate($objectInfo){
        $this->SQLBase = DBSQL::GetInstance();
        
        if ($this->CheckDuplicate($objectInfo) > 1)
            return false;
        
        $this->SQLBase->SetLimit = 1;
        $rs = $this->SQLBase->update(get_class($this), $objectInfo, 
                array('id' => $this->id));
        if ($rs)
            $this->UpdateInfo($objectInfo);
        return $rs;
    }
    
    public function SelfDelete(){
        $this->SQLBase = DBSQL::GetInstance();
        $cond = array('id' => $this->id);
        return $this->SQLBase->delete(get_class($this), $cond);
    }

    
    protected abstract function SetInfo($info);
    protected abstract function UpdateInfo($info);

       /**
     * Получить информацию о объекте
     * @return array - информация о курсе
     */
    public function GetInfo(){
        $resultArray = array();
        $resultArray['id']=$this->id;
        $resultArray += $this->info;
        return $resultArray;
    }
    
    //????????????????????
    protected function CheckDuplicate($objectInfo){
        if (count($this->duplicateFields) == 0)
            return 0;
        $duplicateArray = array();
        foreach($this->duplicateFields as $key => $value){
            $duplicateArray[$value] = $objectInfo[$value];
        }
        $this->SQLBase->SetWhere($duplicateArray, $this->duplicateOperator);
        
        $check = $this->SQLBase->select('*', get_class($this));
        if ($check)
            return count($this->SQLBase->GetlastResult());
        return 0;
    }
    
    /**
     * Проверка на наличие пустых параметров
     * @param array $arrayParams - массив проверяемых параметров
     * @return boolean - true, если нет пустых параметров
     */
    protected function CheckEmptyParams($arrayParams){
        foreach ($arrayParams as $param){
            if (!$param){
                return FALSE;
            }
        }
        return TRUE;
    }
    
    
}



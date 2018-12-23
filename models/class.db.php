<?php

// Паттерн проектирования - Singleton
class DBSQL{
    private static $_instance; //хранит единственный экземпляр данного класса
    private $db; //объект соединения с базой данных
    private $lastResult; // результат последней операции
    
    //Переменная команды WHERE
    private $whereLine;
    
    //Переменные для команды LIMIT
    private $limitLine;
    
    //Переменные для команды ORDER
    private $orderLine;
    
    public function SetWhere($condition, $operator = null){
        $whereArray = array();
        $whereOperator = " AND ";
        if ($operator){
            strtoupper($operator);
            $whereOperator = " $operator ";
        }
        
        foreach ($condition as $key => $field){
            if (!is_array($field)){
                array_push($whereArray, "`$key` = '$field'"); 
                continue;
            }
            $keyName = array_keys($condition)[0];
            foreach ($field as $number => $value){
                array_push($whereArray, "`$keyName` = '$value'");
            }
        }
        
        $conditionStr = implode($whereArray, $whereOperator);
        $this->whereLine = "WHERE ($conditionStr) ";
    }
    
    public function SetLimit($limit){
        $this->limitLine = "LIMIT $limit ";
    }
    
    public function SetOrder($order){
        $this->orderLine = "ORDER BY `$order`";    
    }
    
    public function SetDefaultLines(){
        $this->whereLine = null;
        $this->limitLine = null;
        $this->orderLine = null;
    }
    
    public function GetLastInsertId(){
        return $this->db->insert_id;
    }
    
    /**
     * Получить результат последней операции
     * 
     * @return array Результат операции
     */
    public function GetLastResult(){
        return $this->lastResult;
    }
    
    public function GetSafeString($unsafeStr){
        return htmlspecialchars($this->db->real_escape_string($unsafeStr));
    }
    
    private function __construct(){ // конструктор отрабатывает один раз при вызове DBSQL::GetInstance();
        $this->db = new mysqli(HOST, USER, PASSWORD, DATABASE);
        $this->db->set_charset('utf8');

        if ($this->db->connect_errno) {
          die('MySQL access denied.');
        }

        if(!mysqli_select_db($this->db, DATABASE)) {
            die("The database " . DATABASE . " could not be accessed.");
        }
    }
    
    //запрещаем клонирование объекта модификатором private
    //т.к. это требуется при создании Singleton'а
    private function __clone(){}
    
    //Закрыть этот метод обязывает паттерн проектирования
    private function __wakeup(){
    }
    
    // Получение(создание, если не создан ранее) объекта класса
    public static function GetInstance(){
        if (self::$_instance === null) {
            self::$_instance = new self;   
        }
        return self::$_instance;
    }
    
    /**
     * Внутренняя функция запроса
     * @param string $sql строка запроса
     * @return boolean удачное выполнение запроса (true - удачно)
     */
    private function query($sql){
        $this->SetDefaultLines();
        $rs = $this->db->query($sql);

        //Если количество строк отрицательное, то запрос некорректный
        if ($this->db->affected_rows == -1) {
            $this->lastResult = mysqli_error($this->db);
            return FALSE;
        }
        
        // Согласно документации, если $rs === true, запрос (не SELECT) выполнен успешно
        // Если же $rs === false, то у нас два варианта
        // 1. Не выполнен запрос SELECT, ошибка
        // 2. Любой другой запрос выполнен, но не затронул ни одной строки    
        if ($rs === TRUE) {
            $this->lastResult = "Запрос выполнился успешно. Затронуто " . $this->db->affected_rows . " строк.";
            return TRUE;
        } elseif ($rs === FALSE) {
            $this->lastResult = "Запрос не был выполнен.";
            return FALSE;
        }
        
        // Сюда мы попадаем только при запросе SELECT
        $rsTwig = array();
        while ($row = $rs->fetch_assoc()) {
            $rsTwig[] = $row;
        }
        
        // Если $rsTwig пустой, то SELECT ничего не нашел
        if (count($rsTwig) === 0){
                return FALSE;
        }
        
        // Отдаем в lastResult массив строк ответа SELECT
        $this->lastResult =  $rsTwig;
        return TRUE;
    }
    
    
    /**
     * Формируем запрос SELECT
     * 
     * @param string $selectValue - искомый элемент
     * @param string $table - таблица поиска
     * @param string $condition - условие поиска
     * @param string $limit - ограничение количества возвращаемых значений
     * @param string $order - сортировка по параметру
     * @return boolean удачное выполнение запроса (true - удачно)
     * TODO: Сделать работу с массивами
     */
    public function select($selectValue, $table){
        $sql = "SELECT `" . $selectValue . "` ";
        $sql .= "FROM `" . $table . "` ";
        if (isset($this->whereLine)){
            $sql .= $this->whereLine;
        }
        if (isset($this->limitLine)){
            $sql .= $this->limitLine;
        }
        if (isset($this->orderLine)){
            $sql .= $this->orderLine;
        }
        return $this->query($sql);
    }
    
    /**
     * Запрос INSERT
     * 
     * @param string $table - таблица
     * @param string $selectValue - поля, в которые добавляем
     * @param string $values - добавляемые значения
     * @return boolean удачное выполнение запроса (true - удачно)
     * TODO: Сделать работу с массивами
     */
    public function insert($table, $keyValue){
        $sql = "INSERT INTO `" . $table . "`";
        
        $ArrayKeys = array_keys($keyValue);
        $ArrayValues = array_values($keyValue);
        
        //Защищаем строки значений, подаваемые в БД
        foreach ($ArrayValues as $key => $field){
            $ArrayValues[$key] = $this->GetSafeString($field);
        }
        // Собираем каждый массив с строку для команды INSERT
        $setKeys = '`' . implode("`, `", $ArrayKeys) . '`';
        $setValues = "'" . implode("', '", $ArrayValues) . "'";
        
        $sql .= "($setKeys)";
        $sql .= "VALUES ($setValues) ";
        
        if ($this->limitLine){
            $sql .= $this->limitLine;
        }
        
        return $this->query($sql);
    }
    
    /**
     * Запрос DELETE
     * 
     * @param string $table - таблица
     * @param string $condition - условие удаления
     * @return boolean удачное выполнение запроса (true - удачно)
     * TODO: Сделать работу с массивами
     */
    public function delete($table, $condition){
        $sql = "DELETE FROM `" . $table . "`";
        
        $conditionArray = array();
        foreach ($condition as $key => $field){
            array_push($conditionArray, "`$key` = '$field'"); 
        }
        $conditionStr = implode($conditionArray, ", ");
        
        $sql .= "WHERE $conditionStr";
        
        if ($this->limitLine){
            $sql .= $this->limitLine;
        }
        return $this->query($sql);
    }
    

    
    /**
     * Запрос UPDATE
     * @param string $table - таблица
     * @param string $changedValues - изменяемые значения
     * @param string $condition - условия исменения
     * @param string $limit - ограничение количества изменяемых значений
     * @return boolean удачное выполнение запроса (true - удачно)
     * TODO: Сделать работу с массивами
     */
    public function update($table, $set, $where){
        $sql = "UPDATE `" . $table . "`";
        
        $setInfo = array();
        $setCondition = array();
        foreach ($set as $key => $field){
            array_push($setInfo, "`$key` = '$field'"); 
        }
        
        foreach ($where as $key => $field){
            array_push($setCondition, "`$key` = '$field'"); 
        }
        
        $setStr = implode($setInfo, ", ");
        $condStr = implode($setCondition, ", ");
        
        $sql .= "SET $setStr ";
        $sql .= "WHERE $condStr ";
        
        if ($this->limitLine){
            $sql .= $this->limitLine;
        }
        
        return $this->query($sql);
    }
    
}
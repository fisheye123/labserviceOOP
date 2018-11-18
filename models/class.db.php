<?php

// Паттерн проектирования - Singleton
class DBSQL{
    private static $_instance; //хранит единственный экземпляр данного класса
    private $db; //объект соединения с базой данных
    private $lastResult; // результат последней операции
    
    /**
     * Получить результат последней операции
     * 
     * @return array Результат операции
     */
    public function GetLastResult(){
        return $this->lastResult;
    }
    
    /**
     * Получить объект соединения с БД
     * @return object объект соединения с БД
     */
    public function GetDataBase(){
        return $this->db;
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
    
    //Восстанавливаем соединение после десериализации
    public function __wakeup(){
            $this->db = new mysqli(HOST, USER, PASSWORD, DATABASE);
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
    public function select($selectValue, $table, $condition = FALSE, $limit = FALSE, $order = FALSE){
        $sql = "SELECT `" . $selectValue . "` ";
        $sql .= "FROM `" . $table . "` ";
        if ($condition){
            $sql .= "WHERE (" . $condition . ") ";
        }
        if ($limit){
            $sql .= "LIMIT " . $limit . " ";
        }
        if ($order){
            $sql .= "ORDER BY `" . $order . "`";
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
    public function insert($table, $selectValue, $values){
        $sql = "INSERT INTO `" . $table . "`";
        
        $sql .= "(" . $selectValue . ")";
        $sql .= "VALUES (" . $values . ")";
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
        $sql .= "WHERE " . $condition . "";
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
    public function update($table, $changedValues, $condition, $limit = FALSE){
        $sql = "UPDATE `" . $table . "`";
        $sql .= "SET " . $changedValues . " ";
        $sql .= "WHERE " . $condition . " ";
        if ($limit){
            $sql .= "LIMIT `" . $limit . "`";
        }
        
        return $this->query($sql);
    }
    
}
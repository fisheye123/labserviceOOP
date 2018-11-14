<?php

class DBSQL{
    private static $_instance; //хранит единственный экземпляр данного класса
    private $db;
    private $lastResult;
    
    public function GetLastResult(){
        return $this->lastResult;
    }
    
    public function GetDataBase(){
        return $this->db;
    }
    
    // Перегружаем собственные методы создания класса 
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
    private function __clone(){}
    
    public function __wakeup(){
            $this->db = new mysqli(HOST, USER, PASSWORD, DATABASE);
    }
    
    public static function GetInstance(){
        if (self::$_instance === null) {
            self::$_instance = new self;   
        }
        return self::$_instance;
    }
    
    //Внутренняя функция запроса
    private function query($sql){
        $rs = $this->db->query($sql);

        //Если количество строк отрицательное, то что-то сломалось
        if ($this->db->affected_rows == -1) {
            $this->lastResult = mysqli_error($this->db);
            return FALSE;
        }
        
        if ($rs === TRUE) {
            $this->lastResult = "Запрос выполнился успешно. Затронуто " . $this->db->affected_rows . " строк.";
            return TRUE;
        } elseif ($rs === FALSE) {
            $this->lastResult = "Запрос уже был выполнен ранее.";
            return FALSE;
        }
        
        $rsTwig = array();
        while ($row = $rs->fetch_assoc()) {
            $rsTwig[] = $row;
        }
        
        if (count($rsTwig) === 0){
                return FALSE;
        }
        
        $this->lastResult =  $rsTwig;
        return TRUE;
    }
    
    //TODO: Сделать работу с массивами
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
    
    //TODO: Сделать работу с массивами
    public function insert($table, $selectValue, $values){
        $sql = "INSERT INTO `" . $table . "`";
        
        $sql .= "(" . $selectValue . ")";
        $sql .= "VALUES (" . $values . ")";
        return $this->query($sql);
    }
    
    public function delete($table, $condition){
        $sql = "DELETE FROM `" . $table . "`";
        $sql .= "WHERE " . $condition . "";
        return $this->query($sql);
    }
    
    //TODO: Сделать работу с массивами
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
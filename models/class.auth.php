<?php

require_once 'class.admin.php';
require_once 'class.teacher.php';
require_once 'class.course.php';

class Auth{
    private static $_instance;
    private $SQLBase;
    private $returnUser;
    
    // Перегружаем собственные методы создания класса 
    private function __construct(){}
    private function __clone(){}
    private function __wakeup(){}
    
    public static function GetInstance(){
        if (self::$_instance === null) {
            self::$_instance = new self;   
        }
        return self::$_instance;
    }
    
    public function GetUser(){
        return $this->returnUser;
    }

    private function LoginToSql($login, $password){
        $whoAmI = array('Teacher', 'Course');
        foreach ($whoAmI as $user){
            if ($this->SQLBase->select("*", $user, "`login` = '{$login}' AND `password` = '{$password}'", 1)){
                $this->returnUser = new $user();
                break;
            }
        } 
        return $this->SQLBase->GetLastResult();
    }

    public function Authorizator($_login, $_password) {
        // Может быть это admin?        
        if ($_login == ADMIN_LOGIN && $_password == ADMIN_PASS) {
            $this->returnUser = new Admin();
            $_SESSION['Admin']['name'] = 'Администратор'; 
            $resData = $_SESSION['Admin'];
            $resData['success'] = 1;
            return $resData;
        }
        
        //Ага, это не админ. Придется лезть в БД
        $this->SQLBase =  DBSQL::GetInstance();
        $login = htmlspecialchars($this->SQLBase->GetDataBase()->real_escape_string(trim($_login)));
        $password = md5(trim($_password));
        
        //Пробуем получить класс пользователя 
        $rs = $this->LoginToSql($login, $password);
        
        if (!$this->returnUser){
            $resData['message'] = 'Неверный логин или пароль';
            $resData['success'] = 0;
        } else {
            $_SESSION[get_class($this->returnUser)] = $rs[0];

            $resData = $_SESSION[get_class($this->returnUser)];
            $resData['success'] = 1;
        }

        return $resData;
    }
}
 
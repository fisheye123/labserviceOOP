<?php

require_once 'class.admin.php';
require_once 'class.teacher.php';
require_once 'class.course.php';

class Auth{
    private static $_instance;
    private $SQLBase;
    
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

    private function LoginToSql($login, $password){
        $login = $this->SQLBase->GetSafeString(trim($login));
        $password = md5(trim($password));
        $whoAmI = array('teacher', 'course');
        foreach ($whoAmI as $user){
            $this->SQLBase->SetWhere(array ('login' => $login,
                                    'password' => $password));
            $this->SQLBase->SetLimit(1);
            if ($this->SQLBase->select("*", $user)){
                return $user;
            }
        }
        return null;
    }

    public function Authorizator($_login, $_password) {
        // Может быть это admin?        
        if ($_login == ADMIN_LOGIN && $_password == ADMIN_PASS) {
            $_SESSION['User'] = 'Admin';
            $_SESSION['Admin']['name'] = 'Администратор'; 
            $resData = $_SESSION['Admin'];
            $resData['success'] = 1;
            return $resData;
        }
        
        //Ага, это не админ. Придется лезть в БД
        $this->SQLBase =  DBSQL::GetInstance();
        
        //Пробуем получить класс пользователя 
        $rs = $this->LoginToSql($_login, $_password);
        
        if ($rs == null){
            $resData['message'] = 'Неверный логин или пароль';
            $resData['success'] = 0;
        } else {
            $_SESSION['User'] = $rs;
            $_SESSION[$rs] = $this->SQLBase->GetLastResult()[0];

            $resData = $_SESSION[$rs];
            $resData['success'] = 1;
        }

        return $resData;
    }
}
 
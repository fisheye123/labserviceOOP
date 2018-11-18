<?php
require_once 'BaseController.php';


//Контроллер авторизации
class AuthController extends BaseController{

    /**
    * Загрузка страницы авторизации
    */
    public function indexAction () {
        $tmpl = $this->myLoadTemplate('auth');

        echo $tmpl->render(array(
        'title' => "Вход на сайт"
        ));
    }
    
    /**
    * Авторизация пользователя
    * 
    * @return json массив данных пользователя
    */
    function loginAction() {
       $login = filter_input(INPUT_POST, 'login');
       $password = filter_input(INPUT_POST, 'password');
       $auth = Auth::GetInstance();
       $resData = $auth->Authorizator($login, $password);
       $_SESSION['User'] = $auth->GetUser();
       echo json_encode($resData);
    }
    
}


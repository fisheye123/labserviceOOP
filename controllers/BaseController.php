<?php

//Базовый  класс контроллера
abstract class BaseController{
    
    protected $userClass;
    protected $twig;
    
    /**
     * Конструктор
     * @param object $userClass объект пользователя
     * @param object $twig объект шаблонизатора
     */
    function __construct($userClass, $twig){
        $this->userClass = $userClass;
        $this->twig = $twig;
    }
    
    //Загрузка стартовой страницы контроллера
    abstract public function indexAction();
    
    /**
     * Выход из авторизации
     */
    public function logoutAction(){
        unset($_SESSION['User']);
        $this->redirect();
    }

   /**
    * Загрузка шаблона
    * 
    * @param string $templateName название файла шаблонизатора
    */
    protected function myLoadTemplate ($templateName) {
       return $this->twig->loadTemplate($templateName . TemplatePostfix);
    }

   /**
    * Перенаправление по адресу
    * 
    * @param string $url адрес
    */
    protected function redirect($url = '/labserviceOOP/www/') {
       header("Location: {$url}");
       exit();
    }
    
}
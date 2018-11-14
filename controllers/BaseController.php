<?php

abstract class BaseController{
    
    protected $userClass;
    protected $twig;
    
    function __construct($userClass, $twig){
        $this->userClass = $userClass;
        $this->twig = $twig;
    }
    
    abstract public function indexAction();
    
    /**
     * Выход из авторизации
     * 
     */
    public function logoutAction(){
        unset($_SESSION['User']);
        $this->redirect();
    }
    
    public function badaddressAction(){
        //$this->redirect();
        echo 'SHTOOO';
    }
    

   /**
    * Загрузка шаблона
    * 
    * @param object $twig объект шаблонизатора
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
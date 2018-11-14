<?php

// константы для подключения к БД
define('HOST', '127.0.0.1');
define('USER', 'root');
define('PASSWORD', '1234');
define('DATABASE', 'labservis');

// Логин и пароль администратора
define('ADMIN_LOGIN', "admin");
define('ADMIN_PASS', "admin");

//используемые шаблоны
$templateTeacher = 'teacher';
$templateAdmin = 'admin';
$templateCourse = 'course';

//пути к фалам фаблонов (*.tpl) - views
define('TemplateTeacherPrefix', "../views/{$templateTeacher}/");
define('TemplateAdminPrefix', "../views/{$templateAdmin}/");
define('TemplateCoursePrefix', "../views/{$templateCourse}/");
define('TemplateAuthPrefix', "../views/");
define('TemplatePostfix', '.tpl');

//инициализация шаблонизатора Twig
require_once '../library/twig/vendor/autoload.php';
$loader = new Twig_Loader_Filesystem(array(
        TemplateTeacherPrefix, 
        TemplateAdminPrefix, 
        TemplateCoursePrefix,
        TemplateAuthPrefix
    ));
$twig = new Twig_Environment($loader);
<?php

// Файл конфигурации
require '../config.php';

//Контроллеры
require_once '../controllers/AuthController.php';
require_once '../controllers/AdminController.php';
//require_once '../controllers/TeacherController.php';
//require_once '../controllers/CourseController.php';

require_once '../models/class.db.php';
require_once '../models/class.auth.php';
require_once '../models/mainFunctions.php';

session_start();

//$SQLBase = DBSQL::GetInstance();
//$rs = $SQLBase->select('*', '`course`', '', '', '`id`');
//echo $rs;
//$sql = "SELECT * 
//        FROM `teacher`
//        ORDER BY `id`";
//
//$rs = db()->query($sql);

//$rsarr = createRsTwigArray($rs);
//echo '<pre>'; print_r($rsarr); echo '</pre>';



//Сначала возьмем action
if (null !== filter_input(INPUT_GET, 'action')) {
    $actionName = filter_input(INPUT_GET, 'action');
} else {
    $actionName = 'index';
}

// Теперь разберемся какой контроллер
if(!isset($_SESSION['User'])){ //Нет пользователя в сессии    
    $controllerName = 'Auth';
    $userObject = NULL;
} else {
    $userObject = $_SESSION['User'];
    $controllerName = get_class($_SESSION['User']);
    
    // Теперь рассмотрим плохой вариант - у нас зарегестрирован
    // один пользователь, а контроллер пришел другой
    // TODO: Вниметельно посмотреть, что у нас приходит из js
    //if ($controllerName !== filter_input(INPUT_GET, 'controller'))
    //    $actionName = 'badaddress';
}

$controllerName .= 'Controller';
$actionName .= 'Action';
$controllerObject = new $controllerName($userObject, $twig);
$controllerObject->$actionName();






//******************************
//$auth = UnknownUser::GetInstance();
//$auth->LogOut();

//$user = $auth->Authorizator("admin", "admin");
//$user = $auth->Authorizator("tnc", "tnc");
//$user = $auth->Authorizator("usik", "usik");

//echo '<pre>'; print_r($user); echo '</pre>';

/*foreach ($_SESSION as &$value){
    foreach ($value as &$test){
        echo $test;
    }
}*/
//*******************************


//$db = DBSQL::GetInstance();
//$select = $db->select("*", "teacher", "`login` = 'tnc'");
//$arr =  $db->GetLastResult();
//echo '<pre>'; print_r($arr); echo '</pre>';
//echo $arr[0]['name'];
//foreach ($db->GetLastResult() as &$value){
//    foreach ($value as &$test){
//        echo $test;
//    }
//}
//$insert = $db->insert("course", "`title`, `description`, `login`, `password`", "'testName', '', 'testlogin', 'testpassword'");
//echo "</br>" . $db->GetLastResult();

//$delete = $db->delete("teacher", 27);
//echo "</br>" . $db->GetLastResult();

//$update = $db->update("course", "`title` = 'Danya', `description` = 'hg', `login` = 'testDanya', `password` = 'testDanya'", 36);
//echo "</br>" . $db->GetLastResult();


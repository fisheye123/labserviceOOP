<?php

class TeacherController extends BaseController{
    
    
    function __construct($twig) {
        $this->userClass = new Teacher($_SESSION['teacher']);
        $this->twig = $twig;
    }
    
    public function indexAction () {
        
        $rsCourses = $this->userClass->ShowCourses();
        $tmpl = $this->myLoadTemplate('teacher');
        echo $tmpl->render(array(
            'title' => $_SESSION['teacher']['name'],
            'arTeacher' => $_SESSION['teacher'],
            'rsCourses' => $rsCourses
        ));
    }
    
    
    public function aboutAction() {
        //$crumbs = breadcrumbs();
        $rsCourses = $this->userClass->ShowCourses();
        $title = "Страница пользователя {$_SESSION['teacher']['login']}";
        $tpppl = $this->myLoadTemplate('teacherAbout');
        echo $tpppl->render(array(
            'title' => $title,
            'rsCourses' => $rsCourses,
            'arTeacher' => $_SESSION['teacher']
        ));
    }
    
    function updateAction() {
        $resData = array();

        $name = filter_input(INPUT_POST, 'name');
        $email = filter_input(INPUT_POST, 'email');
        $pass1 = filter_input(INPUT_POST, 'password1');
        $pass2 = filter_input(INPUT_POST, 'password2');
        $curPass = filter_input(INPUT_POST, 'curPassword');

        if($pass1 !== $pass2) {
            $resData['success'] = 0;
            $resData['message'] = 'Введенные пароли не совпадают';
            echo json_encode($resData);
            return FALSE;
        }

        $curPasswordMD5 = md5($curPass);
        
        $resData = $this->userClass->SelfUpdateEx($name, $email, $pass1, $curPasswordMD5);
        
        if ($resData['success']){
            $_SESSION['teacher'] = $this->userClass->GetInfo();
        }
            
        echo json_encode($resData);
    }
    
    /**
     * Загрузка главной страницы курса
     * 
     * @param object $twig - шаблонизатор
     */
    public function courseAction () {
        $courseId = filter_input(INPUT_GET, 'id');
        
        if (!$courseId) {
            exit();
        }
        
        $rsCourses = $this->userClass->ShowCourses();
        $rsCourse = $this->userClass->ShowCourses($courseId)[0];
        $title = "Курс {$rsCourse['title']}";
        $rsLabs = $this->userClass->GetCourses($courseId)[0]->ShowLabs(null, false);
        $tpppl = $this->myLoadTemplate('teacherCourse');
        echo $tpppl->render(array(
            'title' => $title,
            'rsCourse' => $rsCourse,
            'rsLabs' => $rsLabs,
            'rsCourses' => $rsCourses,
            'arTeacher' => $_SESSION['teacher']
        ));
    }
    
    
    public function labaddAction () {
        $rsCourses = $this->userClass->ShowCourses();
        
        $tpppl = $this->myLoadTemplate('teacherAddLab');
        echo $tpppl->render(array(
            'title' => 'TomskSoft',
            'rsCourses' => $rsCourses,
            'arTeacher' => $_SESSION['teacher']
        ));
    }
    
    /**
    * Добавление лабораторной
    * 
    * 1. Создать пустой объект лабораторной работы
    * 2. Загнать параметры
    * 3. Лабораторная вычисляет свой номер и пишет себя в БД
    * 
    * @return json массив, содержащий информацию о добавлении лабораторной
    */
   function addlabAction() {    
       $title = filter_input(INPUT_POST, 'lab_title');    
       $task = filter_input(INPUT_POST, 'lab_task');
       $courseId = filter_input(INPUT_POST, 'lab_course');
       
       $labFile = $_FILES['file'];
       
       $resData = $this->userClass->CreateLab($title, $task, $courseId, $labFile);

       echo json_encode($resData);
   }
   
   function labAction () {
       $labId = filter_input(INPUT_GET, 'id');

       if (!$labId) {
           exit();
       }
       
       $rsLab = $this->userClass->ShowLab(array('id' => $labId))[0];
       $title = "Лабораторная №{$rsLab['number']} - {$rsLab['title']}";
       //$rsStudents = $this->userClass->ShowStudent($rsLab['course_id']);
       $rsCourses = $this->userClass->ShowCourses();
       $rsExec = $this->userClass->ShowExec($labId);

        $tpppl = $this->myLoadTemplate('teacherLab');
        echo $tpppl->render(array(
            'title' => $title,
            'rsLab' => $rsLab,
            'rsCourses' => $rsCourses,
            'rsExec' => $rsExec,
            'arTeacher' => $_SESSION['teacher']
        ));
    }
    
    
    //В данный момент ситуация такая - функционал ограничивается включением-
    //отключением доступа к лабораторной. В дальнейшем надо будет создать
    // полноценную страницу редактирования лабораторной работы
    public function updatelabAction() {
        
        $labId = filter_input(INPUT_POST, 'labId');
        
        $resData = $this->userClass->EditLab($labId);

        echo json_encode($resData);
   }
   
   //В данный момент ситуация такая - функционал ограничивается включением-
    //отключением доступа к лабораторной. В дальнейшем надо будет создать
    // полноценную страницу редактирования лабораторной работы
    public function setgradeAction() {
        
        $execId = filter_input(INPUT_POST, 'id');
        $execGrade = filter_input(INPUT_POST, 'grade');
        
        $resData = $this->userClass->SetGrade($execId, $execGrade);

        echo json_encode($resData);
   }
   
   /**
    * Удаление студента
    * 
    * @return json массив[success, message]
    * Массив содержит информацию о результате операции
    */
   function deletelabAction() {
       $id = filter_input(INPUT_POST, 'id');
    
        $resData = $this->userClass->DeleteLab($id);
       
        echo json_encode($resData);
   }
   
    function gradeAction() {
       $cid = filter_input(INPUT_GET, 'id');
       $rsCourses = $this->userClass->ShowCourses();
       $rsLab = $this->userClass->GetCourses($cid)[0]->ShowLabs(null, false);
       $rsStudents = $this->userClass->ShowStudentsWithGrade($cid);
       $tpppl = $this->myLoadTemplate('teacherGrade');
        echo $tpppl->render(array(
            'rsLab' => $rsLab,
            'rsCourses' => $rsCourses,
            'rsStudents' => $rsStudents,
            //'rsExec' => $rsExec,
            'arTeacher' => $_SESSION['teacher']
        )); 
   }
    
}



/**
 * Загрузка страницы преподавателя
 * 
 * @param object $twig шаблонизатор
 */
//function aboutAction($twig) {
//    $crumbs = breadcrumbs();
//    $rsCourses = getCourseWithLab();
//    $title = "Страница пользователя {$_SESSION['teacher']['login']}";
//    
//    if(isset($_SESSION['teacher'])){
//        $tpppl = myLoadTemplate($twig, 'teacherAbout');
//        echo $tpppl->render(array(
//            'title' => $title,
//            'crumbs' => $crumbs,
//            'rsCourses' => $rsCourses,
//            'arTeacher' => $_SESSION['teacher']
//        ));
//    } else {
//        redirect();
//    }
//}
/**
 * Загрузка страницы лабораторной для студента и для преподавателя
 * 
 * @param object $twig - шаблонизатор
 */
//function labAction ($twig) {
//    $labId = filter_input(INPUT_GET, 'id');
//    
//    if (!$labId) {
//        exit();
//    }
//    
//    $rsLab = getLabById($labId);
//    $title = "Лабораторная №{$rsLab['number']} - {$rsLab['title']}";
//    $rsStudents = getStudentsByCourse($rsLab['course_id']);
//    
//    if(isset($_SESSION['teacher'])){
//        $crumbs = breadcrumbs();
//        $rsCourses = getCourseWithLab();
//        
//        $tpppl = myLoadTemplate($twig, 'teacherLab');
//        echo $tpppl->render(array(
//            'title' => $title,
//            'crumbs' => $crumbs,
//            'rsLab' => $rsLab,
//            'rsCourses' => $rsCourses,
//            'rsStudents' => $rsStudents,
//            'arTeacher' => $_SESSION['teacher']
//        ));
//    } else {
//        redirect();
//    }
//}
    
/**
 * Загрузка главной страницы преподавателя
 * 
 * @param object $twig - шаблонизатор
 */
//function labaddAction ($twig) {
//    $rsCourses = getCourseWithLab();
//    
//    if(isset($_SESSION['teacher'])){
//        $tpppl = myLoadTemplate($twig, 'teacherAddLab');
//        echo $tpppl->render(array(
//            'title' => 'TomskSoft',
//            'rsCourses' => $rsCourses,
//            'arTeacher' => $_SESSION['teacher']
//        ));
//    } else {
//        redirect();
//    }
//}
//
///**
// * Загрузка главной страницы курса
// * 
// * @param object $twig - шаблонизатор
// */
//function courseAction ($twig) {
//    $courseId = filter_input(INPUT_GET, 'id');
//    
//    if (!$courseId) {
//        exit();
//    }
//    
//    $crumbs = breadcrumbs();
//    $rsCourses = getCourseWithLab();
//    $rsCourse = getCourseById($courseId);
//    $title = "Курс {$rsCourse['title']}";
//    $rsLabs = getLabForCourse($courseId);
//    
//    if(isset($_SESSION['teacher'])){
//        $tpppl = myLoadTemplate($twig, 'teacherCourse');
//        echo $tpppl->render(array(
//            'title' => $title,
//            'crumbs' => $crumbs,
//            'rsCourse' => $rsCourse,
//            'rsLabs' => $rsLabs,
//            'rsCourses' => $rsCourses,
//            'arTeacher' => $_SESSION['teacher']
//        ));
//    } else {
//        redirect();
//    }
//}
//
///**
// * Обновление данных преподавателя из страницы преподавателя (из teacher.js)
// * 
// * @return json массив, содержащий информацию об обновлении данных преподавателя
// */
//function updateAction() {
//    $resData = array();
//    
//    $name = filter_input(INPUT_POST, 'name');
//    $email = filter_input(INPUT_POST, 'email');
//    $pass1 = filter_input(INPUT_POST, 'password1');
//    $pass2 = filter_input(INPUT_POST, 'password2');
//    $curPass = filter_input(INPUT_POST, 'curPassword');
//    
//    if($pass1 !== $pass2) {
//        $resData['message'] = 'Введенные пароли не совпадают';
//        echo json_encode($resData);
//        return FALSE;
//    }
//    
//    $curPasswordMD5 = md5($curPass);
//    if( !$curPass || ($_SESSION['teacher']['password'] != $curPasswordMD5) ) {
//        $resData['success'] = 0;
//        $resData['message'] = 'Текущий пароль введен неверно';
//        echo json_encode($resData);
//        return FALSE;
//    }
//    
//    $resData = checkTeacherName($name);
//    if (!isset($resData['success'])) {
//        //Нет проверки на совпадение логинов
//        $res = updateTeacherDatalk($name, $email, $pass1, $pass2, $curPasswordMD5);
//        if($res) {
//            $resData['success'] = 1;
//            $resData['message'] = 'Изменения сохранены';
//            $resData['teacherName'] = $name;
//
//            $_SESSION['teacher']['name'] = $name;
//            $_SESSION['teacher']['email'] = $email;
//
//            $newPassword = $_SESSION['teacher']['password'];
//            if( $pass1 && ($pass1 == $pass2) ) {
//                $newPassword = md5(trim($pass1));
//            }
//
//            $_SESSION['teacher']['password'] = $newPassword;
//            $_SESSION['teacher']['displayName'] = $name ? $name : $_SESSION['teacher']['login'];
//        } else {
//            $resData['success'] = 0;
//            $resData['message'] = 'Ошибка сохранения данных';
//        }
//    }
//    
//    echo json_encode($resData);
//}
//
///**
// * Добавление лабораторной
// * 
// * @return json массив, содержащий информацию о добавлении лабораторной
// */
//function addlabAction() {    
//    $title = filter_input(INPUT_POST, 'lab_title');    
//    $task = filter_input(INPUT_POST, 'lab_task');
//    $courseId = filter_input(INPUT_POST, 'lab_course');
//    
//    $resData = checkAddLabParam($title, $courseId);
//    if(!$resData && checkLabTitle($title, $courseId)) {
//        $resData['success'] = FALSE;
//        $resData['message'] = "Лабораторная с таким названием ('{$title}') уже существует";
//    }
//    
//    if (!$resData) {
//        $labData = addNewLab($title, $task, $courseId);
//        if($labData['success']) {
//            $resData['message'] = 'Лабораторная добавлена';
//            $resData['success'] = 1;
//        } else {
//            $resData['success'] = 0;
//            $resData['message'] = 'Ошибка добавления лабораторной';
//        }
//    }
//    
//    echo json_encode($resData);
//}
//
///**
// * Обновление данных лабораторной
// * 
// * @return json массив, содержащий информацию об обновлении данных лабораторной
// */
//function updatelabAction() {
//    $labId = filter_input(INPUT_POST, 'labId');
//    $Number = filter_input(INPUT_POST, 'newNumber');
//    $Title = filter_input(INPUT_POST, 'newTitle');
//    $Task = filter_input(INPUT_POST, 'newTask');
//    $Access = filter_input(INPUT_POST, 'newAccess');
//    $CourseId = filter_input(INPUT_POST, 'newCourse_id');
//    
//    $res = updateLabData($labId, $Number, $Title, $Task, $Access, $CourseId);
//    if($res) {
//        $resData['success'] = 1;
//        $resData['message'] = 'Данные лабораторной обновлены';
//    } else {
//        $resData['success'] = 0;
//        $resData['message'] = 'Ошибка изменения данных лабораторной';
//    }
//    
//    echo json_encode($resData);
//}
//
///**
// * Удаление лабораторной
// * 
// * @return json массив, содержащий информацию об удалении лабораторной
// */
//function deletelabAction() {
//    $id = filter_input(INPUT_POST, 'id');
//    
//    $res = deleteLab($id);
//    if($res) {
//        $resData['success'] = 1;
//        $resData['message'] = 'Лабораторная удалена';
//    } else {
//        $resData['success'] = 0;
//        $resData['message'] = 'Ошибка удаления лабораторной';
//    }
//    
//    echo json_encode($resData);
//}


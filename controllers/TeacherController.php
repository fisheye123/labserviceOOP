<?php

/**
 * Загрузка главной страницы преподавателя
 * 
 * @param object $twig - шаблонизатор
 */
function indexAction ($twig) {    
    if(isset($_SESSION['Teacher'])){
        $tmpl = myLoadTemplate($twig, 'Teacher');
        echo $tmpl->render(array(
            'title' => $_SESSION['Teacher']['name'],
            'arTeacher' => $_SESSION['Teacher']
        ));
    } else {
        redirect();
    }
}

/**
 * Загрузка страницы лабораторной для студента и для преподавателя
 * 
 * @param object $twig - шаблонизатор
 */
function labAction ($twig) {
    $labId = filter_input(INPUT_GET, 'id');
    
    if (!$labId) {
        exit();
    }
    
    $rsLab = getLabById($labId);
    $title = "Лабораторная №{$rsLab['number']} - {$rsLab['title']}";
    $rsStudents = getStudentsByCourse($rsLab['course_id']);
    
    if(isset($_SESSION['teacher'])){
        $crumbs = breadcrumbs();
        $rsCourses = getCourseWithLab();
        
        $tpppl = myLoadTemplate($twig, 'teacherLab');
        echo $tpppl->render(array(
            'title' => $title,
            'crumbs' => $crumbs,
            'rsLab' => $rsLab,
            'rsCourses' => $rsCourses,
            'rsStudents' => $rsStudents,
            'arTeacher' => $_SESSION['teacher']
        ));
    } else {
        redirect();
    }
}
    
/**
 * Загрузка главной страницы преподавателя
 * 
 * @param object $twig - шаблонизатор
 */
function labaddAction ($twig) {
    $rsCourses = getCourseWithLab();
    
    if(isset($_SESSION['teacher'])){
        $tpppl = myLoadTemplate($twig, 'teacherAddLab');
        echo $tpppl->render(array(
            'title' => 'TomskSoft',
            'rsCourses' => $rsCourses,
            'arTeacher' => $_SESSION['teacher']
        ));
    } else {
        redirect();
    }
}

/**
 * Загрузка главной страницы курса
 * 
 * @param object $twig - шаблонизатор
 */
function courseAction ($twig) {
    $courseId = filter_input(INPUT_GET, 'id');
    
    if (!$courseId) {
        exit();
    }
    
    $crumbs = breadcrumbs();
    $rsCourses = getCourseWithLab();
    $rsCourse = getCourseById($courseId);
    $title = "Курс {$rsCourse['title']}";
    $rsLabs = getLabForCourse($courseId);
    
    if(isset($_SESSION['teacher'])){
        $tpppl = myLoadTemplate($twig, 'teacherCourse');
        echo $tpppl->render(array(
            'title' => $title,
            'crumbs' => $crumbs,
            'rsCourse' => $rsCourse,
            'rsLabs' => $rsLabs,
            'rsCourses' => $rsCourses,
            'arTeacher' => $_SESSION['teacher']
        ));
    } else {
        redirect();
    }
}

/**
 * Обновление данных преподавателя из страницы преподавателя (из teacher.js)
 * 
 * @return json массив, содержащий информацию об обновлении данных преподавателя
 */
function updateAction() {
    $resData = array();
    
    $name = filter_input(INPUT_POST, 'name');
    $email = filter_input(INPUT_POST, 'email');
    $pass1 = filter_input(INPUT_POST, 'password1');
    $pass2 = filter_input(INPUT_POST, 'password2');
    $curPass = filter_input(INPUT_POST, 'curPassword');
    
    if($pass1 !== $pass2) {
        $resData['message'] = 'Введенные пароли не совпадают';
        echo json_encode($resData);
        return FALSE;
    }
    
    $curPasswordMD5 = md5($curPass);
    if( !$curPass || ($_SESSION['teacher']['password'] != $curPasswordMD5) ) {
        $resData['success'] = 0;
        $resData['message'] = 'Текущий пароль введен неверно';
        echo json_encode($resData);
        return FALSE;
    }
    
    $resData = checkTeacherName($name);
    if (!isset($resData['success'])) {
        //Нет проверки на совпадение логинов
        $res = updateTeacherDatalk($name, $email, $pass1, $pass2, $curPasswordMD5);
        if($res) {
            $resData['success'] = 1;
            $resData['message'] = 'Изменения сохранены';
            $resData['teacherName'] = $name;

            $_SESSION['teacher']['name'] = $name;
            $_SESSION['teacher']['email'] = $email;

            $newPassword = $_SESSION['teacher']['password'];
            if( $pass1 && ($pass1 == $pass2) ) {
                $newPassword = md5(trim($pass1));
            }

            $_SESSION['teacher']['password'] = $newPassword;
            $_SESSION['teacher']['displayName'] = $name ? $name : $_SESSION['teacher']['login'];
        } else {
            $resData['success'] = 0;
            $resData['message'] = 'Ошибка сохранения данных';
        }
    }
    
    echo json_encode($resData);
}

/**
 * Добавление лабораторной
 * 
 * @return json массив, содержащий информацию о добавлении лабораторной
 */
function addlabAction() {    
    $title = filter_input(INPUT_POST, 'lab_title');    
    $task = filter_input(INPUT_POST, 'lab_task');
    $courseId = filter_input(INPUT_POST, 'lab_course');
    
    $resData = checkAddLabParam($title, $courseId);
    if(!$resData && checkLabTitle($title, $courseId)) {
        $resData['success'] = FALSE;
        $resData['message'] = "Лабораторная с таким названием ('{$title}') уже существует";
    }
    
    if (!$resData) {
        $labData = addNewLab($title, $task, $courseId);
        if($labData['success']) {
            $resData['message'] = 'Лабораторная добавлена';
            $resData['success'] = 1;
        } else {
            $resData['success'] = 0;
            $resData['message'] = 'Ошибка добавления лабораторной';
        }
    }
    
    echo json_encode($resData);
}

/**
 * Обновление данных лабораторной
 * 
 * @return json массив, содержащий информацию об обновлении данных лабораторной
 */
function updatelabAction() {
    $labId = filter_input(INPUT_POST, 'labId');
    $Number = filter_input(INPUT_POST, 'newNumber');
    $Title = filter_input(INPUT_POST, 'newTitle');
    $Task = filter_input(INPUT_POST, 'newTask');
    $Access = filter_input(INPUT_POST, 'newAccess');
    $CourseId = filter_input(INPUT_POST, 'newCourse_id');
    
    $res = updateLabData($labId, $Number, $Title, $Task, $Access, $CourseId);
    if($res) {
        $resData['success'] = 1;
        $resData['message'] = 'Данные лабораторной обновлены';
    } else {
        $resData['success'] = 0;
        $resData['message'] = 'Ошибка изменения данных лабораторной';
    }
    
    echo json_encode($resData);
}

/**
 * Удаление лабораторной
 * 
 * @return json массив, содержащий информацию об удалении лабораторной
 */
function deletelabAction() {
    $id = filter_input(INPUT_POST, 'id');
    
    $res = deleteLab($id);
    if($res) {
        $resData['success'] = 1;
        $resData['message'] = 'Лабораторная удалена';
    } else {
        $resData['success'] = 0;
        $resData['message'] = 'Ошибка удаления лабораторной';
    }
    
    echo json_encode($resData);
}


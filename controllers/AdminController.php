<?php

require_once 'BaseController.php';

//Контроллер администратора
class AdminController extends BaseController{
    
    /**
     * Загрузка главной страницы администратора
     */ 
    public function indexAction() {
        $tmpl = $this->myLoadTemplate('Admin');
        echo $tmpl->render(array(
            'title' => $_SESSION['Admin']['name'],
            'arAdmin' => $_SESSION['Admin']
        ));
    }
    
    
    /**
    * Загрузка страницы управления курсами
    */
    public function courseAction() {
        $rsCourse = $this->userClass->ShowCourse();
        $tmpl = $this->myLoadTemplate('adminCourse');
        echo $tmpl->render(array(
            'title' => 'Управление сайтом',
            'rsCourse' => $rsCourse,
            'arAdmin' => $_SESSION['Admin']
        ));   
    }
   
   
   /**
    * Загрузка страницы управления лабораторными
    */
   public function labAction() {
        $rsLab = $this->userClass->ShowLab();
        $rsCourses = $this->userClass->ShowCourse('', 'Lab');
        
        $tpppl = $this->myLoadTemplate('adminLab');
        echo $tpppl->render(array(
            'title' => 'Управление сайтом',
            'rsLab' => $rsLab,
            'rsCourses' => $rsCourses,
            'arAdmin' => $_SESSION['Admin']
        ));
    }
    
    /**
    * Загрузка страницы управления преподавателями
    */
   public function teacherAction() {
       $rsTeacher = $this->userClass->ShowTeacher();
       $rsCourses = $this->userClass->ShowCourse('', 'Lab');

        $tpppl = $this->myLoadTemplate('adminTeacher');
        echo $tpppl->render(array(
            'title' => 'Управление сайтом',
            'rsTeacher' => $rsTeacher,
            'rsCourses' => $rsCourses,
            'arAdmin' => $_SESSION['Admin']
        ));
   }
   
   /**
    * Загрузка страницы управления студентами
    */
   public function studentAction() {
        $rsStudent = $this->userClass->ShowStudent();
       
        $tpppl = $this->myLoadTemplate('adminStudent');
        echo $tpppl->render(array(
            'title' => 'Управление сайтом',
            'rsStudent' => $rsStudent,
            'arAdmin' => $_SESSION['Admin']
        ));
   }

   /**
    * Добавление курса
    * 
    * @return json массив [success, message]
    * Массив содержит информацию о результате операции
    */
   public function addcourseAction() {
       $title = filter_input(INPUT_POST, 'course_title');
       $description = filter_input(INPUT_POST, 'course_descripton');
       $login = trim(filter_input(INPUT_POST, 'course_login'));
       $password = filter_input(INPUT_POST, 'course_password');
       
       $resData = $this->userClass->CreateCourse($title, $description, $login, $password);

       echo json_encode($resData);
   }

   /**
    * Обновление данных курса
    * 
    * @return json массив[success, message]
    * Массив содержит информацию о результате операции
    */
   public function updatecourseAction() {
       $id = filter_input(INPUT_POST, 'id');
       $newTitle = filter_input(INPUT_POST, 'newTitle');
       $newDesc = filter_input(INPUT_POST, 'newDescription');
       $newLogin = filter_input(INPUT_POST, 'newLogin');
       $newPassword = filter_input(INPUT_POST, 'newPassword');
       
       $resData = $this->userClass->EditCourse($id, $newTitle, $newDesc, $newLogin, $newPassword);

       echo json_encode($resData);
   }

   /**
    * Удаление курса
    * 
    * @return json массив[success, message]
    * Массив содержит информацию о результате операции
    */
   function deletecourseAction() {
       $id = filter_input(INPUT_POST, 'id');
       
       $resData = $this->userClass->DeleteCourse($id);
       
       echo json_encode($resData);
   }
   
   /**
    * Добавление студента
    * 
    * @return json массив[success, message]
    * Массив содержит информацию о результате операции
    */
   public function addstudentAction() {
        $name = filter_input(INPUT_POST, 'student_name');
        $group = filter_input(INPUT_POST, 'student_group');

        $resData = $this->userClass->CreateStudent($name, $group);

        echo json_encode($resData);
   }

   /**
    * Изменение информации студента
    * 
    * @return json массив[success, message]
    * Массив содержит информацию о результате операции
    */
   public function updatestudentAction() {
        $id = filter_input(INPUT_POST, 'id');
        $newName = filter_input(INPUT_POST, 'newName');
        $newGroup = filter_input(INPUT_POST, 'newGroup');

        $resData = $this->userClass->EditStudent($id, $newName, $newGroup);

        echo json_encode($resData);
   }

   /**
    * Удаление студента
    * 
    * @return json массив[success, message]
    * Массив содержит информацию о результате операции
    */
   function deletestudentAction() {
        $id = filter_input(INPUT_POST, 'id');
    
        $resData = $this->userClass->DeleteStudent($id);
        
        echo json_encode($resData);
   }
   
   /**
    * Добавление предодавателя
    * 
    * @return json массив[success, message]
    * Массив содержит информацию о результате операции
    */
   public function addteacherAction() {
    $login = trim(filter_input(INPUT_POST, 'login'));
    $name = filter_input(INPUT_POST, 'name');
    $password = filter_input(INPUT_POST, 'password');
    $email = filter_input(INPUT_POST, 'email');
    
    $resData = $this->userClass->CreateTeacher($name, $email, $login, $password);
    
    echo json_encode($resData);
   }

   /**
    * Изменение информации преподавателя
    * 
    * @return json массив[success, message]
    * Массив содержит информацию о результате операции
    */
   public function updateteacherAction() {
    $id = filter_input(INPUT_POST, 'teacherId');
    $name = filter_input(INPUT_POST, 'newName');
    $email = filter_input(INPUT_POST, 'newEmail');
    $login = filter_input(INPUT_POST, 'newLogin');
    $password = filter_input(INPUT_POST, 'newPassword');

    $resData = $this->userClass->EditTeacher($id, $name, $email, $login, $password);
    
    echo json_encode($resData);
   }

   /**
    * Удаление преподавателя
    * 
    * @return json массив[success, message]
    * Массив содержит информацию о результате операции
    */
   function deleteteacherAction() {
        $id = filter_input(INPUT_POST, 'id');
        $resData = $this->userClass->DeleteTeacher($id);
    
        echo json_encode($resData);
   }
   
   /**
    * Добавление лабораторной работы
    * 
    * @return json массив[success, message]
    * Массив содержит информацию о результате операции
    */
   public function addlabAction() {
       $title = filter_input(INPUT_POST, 'lab_title');    
       $task = filter_input(INPUT_POST, 'lab_task');
       $courseId = filter_input(INPUT_POST, 'lab_course');
       
       $resData = $this->userClass->CreateLab($title, $task, $courseId);

        echo json_encode($resData);
   }

   /**
    * Изменение информации лабораторной работы
    * 
    * @return json массив[success, message]
    * Массив содержит информацию о результате операции
    */
   public function updatelabAction() {
        $labId = filter_input(INPUT_POST, 'labId');
        $Number = filter_input(INPUT_POST, 'newNumber');
        $Title = filter_input(INPUT_POST, 'newTitle');
        $Task = filter_input(INPUT_POST, 'newTask');
        $Access = filter_input(INPUT_POST, 'newAccess');
        $CourseId = filter_input(INPUT_POST, 'newCourse_id');

        $resData = $this->userClass->EditLab($labId, $Number, $Title, $Task, $Access, $CourseId);

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
}


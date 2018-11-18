<?php

//
require_once 'class.factory.php';

class Admin{
    private $teachers = array();
    private $students = array();
    private $courses = array();
    private $ClassFactory;
    
    function __construct(){
        $this->ClassFactory = Factory::GetInstance();
        $this->courses = $this->ClassFactory->GetObjects("Course");
        $this->teachers = $this->ClassFactory->GetObjects("Teacher");
        $this->students = $this->ClassFactory->GetObjects("Student");
        //$this->labs = $this->ClassFactory->GetObjects("Lab");
        //$this->students = $this->ClassFactory->GetObjects("Student");
    }
    
    //Управление преподавателями (Сделано)
    public function CreateTeacher($name, $email, $login, $password){
        if (!$this->CheckEmptyParams(array($name, $login, $password))){
            $res['success'] = FALSE;
            $res['message'] = "Обязательные поля не заполнены";
            return $res;
        }
        
       if(!$this->CheckDuplicate($this->teachers, 'login', $login)){
           $res['success'] = FALSE;
           $res['message'] = "Преподаватель с таким логином ('{$login}') уже зарегистрирован";
           return $res;
       }
       
        $passwordMD5 = md5(trim($password));
        
        $teacherInfo = array();
        $teacherInfo["name"] = $name;
        $teacherInfo["email"] = $email;
        $teacherInfo["login"] = $login;
        $teacherInfo["password"] = $passwordMD5;

        $newTeacher = $this->ClassFactory->CreateObject('Teacher', $teacherInfo);
        
        if (!$newTeacher){
            $resData['success'] = 0;
            $resData['message'] = 'Ошибка добавления преподавателя';
            return $resData;
        }
        
        $this->teachers = $newTeacher;
        $resData['message'] = 'Преподаватель добавлен';
        $resData['success'] = 1;
        return $resData;
    }
    public function EditTeacher($id, $newName, $newEmail, $newLogin, $newPassword){
        if (!$this->CheckEmptyParams(array($newName, $newLogin, $newPassword))){
            $res['success'] = FALSE;
            $res['message'] = "Обязательные поля не заполнены";
            return $res;
        }
        
        //Проверки на дубликаты нет
        $teacherInfo = array();
        $teacherInfo["id"] = $id ;
        $teacherInfo["name"] = $newName;
        $teacherInfo["email"] = $newEmail;
        $teacherInfo["login"] = $newLogin;
        $teacherInfo["password"] = $newPassword;
        
        $updatedTeacherList = $this->ClassFactory->EditObject('Teacher', $teacherInfo);
        if(!$updatedTeacherList) {
            $resData['success'] = 0;
            $resData['message'] = 'Ошибка изменения данных преподавателя';
            return $resData;
        }
        
        $this->teachers = $updatedTeacherList;
        $resData['success'] = 1;
        $resData['message'] = "Данные преподавателя '{$newName}' обновлены";
        return $resData;   
    }
    public function DeleteTeacher($id){
        // Создаем список для удаления
        // Первый параметр - from
        // второй параметр - where
        
        $courseInfo = array();
        $courseInfo["id"] = $id;
        $updatedTeacherList = $this->ClassFactory->DeleteObject('Teacher', $courseInfo);
        if (!$updatedTeacherList) {
            $resData['success'] = 0;
            $resData['message'] = 'Ошибка удаления преподавателя';
            return $resData;
        }
        
        $this->teachers= $updatedTeacherList;
        $resData['success'] = 1;
        $resData['message'] = 'Курс удален';
        return $resData;
    }
    public function ShowTeacher($id=''){
        if (!$id){
            $resultTeachersInfo = array();
            foreach ($this->teachers as $teacher){
                array_push($resultTeachersInfo, $teacher->GetInfo());
            }
        }
        return $resultTeachersInfo;
    }
    
    //Управление студентами (Сделано)
    public function CreateStudent($name, $group){
        if (!$this->CheckEmptyParams(array($name, $group))){
            $res['success'] = FALSE;
            $res['message'] = "Обязательные поля не заполнены";
            return $res;
        }
        
        //Пока есть проверка только на имя
        //Необходимо написать метод комбинированной проверки
       if(!$this->CheckDuplicate($this->students, 'name', $name)){
           $res['success'] = FALSE;
           $res['message'] = "Студент с таким именем уже зарегистрирован";
           return $res;
       }
        
        $studentInfo = array();
        $studentInfo["name"] = $name;
        $studentInfo["learn_group"] = $group;

        $newStudent = $this->ClassFactory->CreateObject('Student', $studentInfo);
        
        if (!$newStudent){
            $resData['success'] = 0;
            $resData['message'] = 'Ошибка добавления курса';
            return $resData;
        }
        
        $this->students = $newStudent;
        $resData['message'] = 'Курс добавлен';
        $resData['success'] = 1;
        return $resData;
    }
    public function EditStudent($id, $newName, $newGroup){
        if (!$this->CheckEmptyParams(array($newName, $newGroup))){
            $res['success'] = FALSE;
            $res['message'] = "Обязательные поля не заполнены";
            return $res;
        }
        
        //Проверки на дубликаты нет
        $studentInfo = array();
        $studentInfo["id"] = $id ;
        $studentInfo["name"] = $newName;
        $studentInfo["learn_group"] = $newGroup;
        
        $updatedStudentList = $this->ClassFactory->EditObject('Student', $studentInfo);
        if(!$updatedStudentList) {
            $resData['success'] = 0;
            $resData['message'] = 'Ошибка изменения данных студента';
            return $resData;
        }
        
        $this->student = $updatedStudentList;
        $resData['success'] = 1;
        $resData['message'] = "Данные студента '$newName' обновлены";
        return $resData;   
    }
    public function DeleteStudent($id){
         // Создаем список для удаления
        // Первый параметр - from
        // второй параметр - where
        
        $studentInfo = array();
        $studentInfo["id"] = $id;
        $updatedStudentList = $this->ClassFactory->DeleteObject('Student', $studentInfo);
        if (!$updatedStudentList) {
            $resData['success'] = 0;
            $resData['message'] = 'Ошибка удаления студента';
            return $resData;
        }
        
        $this->students= $updatedStudentList;
        $resData['success'] = 1;
        $resData['message'] = 'Студент удален';
        return $resData;
    }
    public function ShowStudent($id=''){
        if (!$id){
            $resultStudentsInfo = array();
            foreach ($this->students as $student){
                array_push($resultStudentsInfo, $student->GetInfo());
            }
        }
        return $resultStudentsInfo;
    }
    
    //Управление курсами(Сделано)
    public function CreateCourse($title, $description, $login, $password){
        
        if (!$this->CheckEmptyParams(array($title, $login, $password))){
            $res['success'] = FALSE;
            $res['message'] = "Обязательные поля не заполнены";
            return $res;
        }
        
       if(!$this->CheckDuplicate($this->courses, 'login', $login)){
           $res['success'] = FALSE;
           $res['message'] = "Курс с таким логином ('{$login}') уже зарегистрирован";
           return $res;
       }

       if(!$this->CheckDuplicate($this->courses, 'title', $title)){
           $res['success'] = FALSE;
           $res['message'] = "Курс с таким названием ('{$title}') уже существует";
           return $res;
       }
       
        $passwordMD5 = md5(trim($password));
        
        $courseInfo = array();
        $courseInfo["title"] = $title;
        $courseInfo["description"] = $description;
        $courseInfo["login"] = $login;
        $courseInfo["password"] = $passwordMD5;

        $newCourse = $this->ClassFactory->CreateObject('Course', $courseInfo);
        
        if (!$newCourse){
            $resData['success'] = 0;
            $resData['message'] = 'Ошибка добавления курса';
            return $resData;
        }
        
        $this->courses = $newCourse;
        $resData['message'] = 'Курс добавлен';
        $resData['success'] = 1;
        return $resData;
    }
    public function EditCourse($id, $newTitle, $newDescription, $newLogin, $newPassword){
        if (!$this->CheckEmptyParams(array($newTitle, $newLogin, $newPassword))){
            $res['success'] = FALSE;
            $res['message'] = "Обязательные поля не заполнены";
            return $res;
        }
        
        //Проверки на дубликаты нет
        $courseInfo = array();
        $courseInfo["id"] = $id ;
        $courseInfo["title"] = $newTitle;
        $courseInfo["description"] = $newDescription;
        $courseInfo["login"] = $newLogin;
        $courseInfo["password"] = $newPassword;
        
        $updatedCourseList = $this->ClassFactory->EditObject('Course', $courseInfo);
        if(!$updatedCourseList) {
            $resData['success'] = 0;
            $resData['message'] = 'Ошибка изменения данных курса';
            return $resData;
        }
        
        $this->courses = $updatedCourseList;
        $resData['success'] = 1;
        $resData['message'] = "Данные курса '{$newTitle}' обновлены";
        return $resData;   
    }
    public function DeleteCourse($id){
        // Создаем список для удаления
        // Первый параметр - from
        // второй параметр - where
        
        $courseInfo = array();
        $courseInfo["id"] = $id;
        $updatedCourseList = $this->ClassFactory->DeleteObject('Course', $courseInfo);
        if (!$updatedCourseList) {
            $resData['success'] = 0;
            $resData['message'] = 'Ошибка удаления курса';
            return $resData;
        }
        
        $this->courses = $updatedCourseList;
        $resData['success'] = 1;
        $resData['message'] = 'Курс удален';
        return $resData;
    }
    public function ShowCourse($condition=null, $additional = null){
        $resultCoursesInfo = array();
        $chekedCourses = $this->courses;
        if (!$condition){
            foreach ($chekedCourses as $course){
                array_push($resultCoursesInfo, $course->GetInfo());
            }
        } else {
            foreach ($condition as $key => $field){
                $this->CheckCondition($chekedCourses, $key, $field);
            }
            foreach ($chekedCourses as $course){
                array_push($resultCoursesInfo, $chekedCourses->GetInfo());
            }
        }
        if ($additional){
            for ($i = 0; $i < count($chekedCourses); $i++){
                $functionStr = "Get" . $additional;
                $additionalObject = $chekedCourses[$i]->$functionStr();
                $resultCoursesInfo[$i]['$additional'] = array();
                foreach ($additionalObject as $object){
                    $object->GetInfo();
                }
                
            }
        }
        
        return $resultCoursesInfo;
    }
    
    //Управление лабораторными работами (Сделано)
    public function CreateLab($title, $task, $courseId){
        if (!$this->CheckEmptyParams(array($title, $courseId))){
            $res['success'] = FALSE;
            $res['message'] = "Обязательные поля не заполнены";
            return $res;
        }
        
        $labList = array();
        foreach ($this->courses as $course){
            $labList += $course->GetLab();
        }
        
       // Пока только проверка на дубликаты имени
       // TODO: Улучшить функцию проверки
       if(!$this->CheckDuplicate($labList, 'title', $title)){
           $res['success'] = FALSE;
           $res['message'] = "Лабораторная '$title' уже зарегистрирована";
           return $res;
       }
       
       $currentCourse = null;
       foreach ($this->courses as $course){
           if ($course->GetInfo()['id'] == $courseId){
               $currentCourse = $course;
           }
               
       }
        
        $labInfo = array();
        $labInfo['number'] = $currentCourse->GetLastLabNumber() + 1;
        $labInfo["title"] = $title;
        $labInfo["task"] = $task;
        $labInfo['attachment'] = '';
        $labInfo['access'] = 0;
        $labInfo["course_id"] = $courseId;

        $newLab = $this->ClassFactory->CreateObject('Lab', $labInfo);
        
        if (!$newLab){
            $resData['success'] = 0;
            $resData['message'] = 'Ошибка добавления лабораторной работы';
            return $resData;
        }
        
        // Сделать несколько версий функции CreateObject, слишком затратно
        // добавлять последнюю лабораторную

        $currentCourse->SetLab(end($newLab));
        $resData['message'] = 'Лабораторная работа добавлена';
        $resData['success'] = 1;
        return $resData;
    }
    public function EditLab($labId, $number=-1, $title='', $task='', $access=-1, $courseId=-1){
        if (!$this->CheckEmptyParams(array($labId, $number, $title, $courseId))){
            $res['success'] = FALSE;
            $res['message'] = "Обязательные поля не заполнены";
            return $res;
        }
        
        //Проверки на дубликаты нет
        //Но есть специализированные проверки для лабораторных работ!
        $labInfo = array();
        
        $labInfo["id"] = $labId;
        if ($number >= 0) $labInfo['number'] = $number;
        if ($title) $labInfo["title"] = $title;
        if ($task) $labInfo["task"] = $task;
        if ($access >= 0) $labInfo['access'] = $access;
        if ($courseId >= 0) $labInfo["course_id"] = $courseId;
        
        $updatedLabList = $this->ClassFactory->EditObject('Lab', $labInfo);
        if(!$updatedLabList) {
            $resData['success'] = 0;
            $resData['message'] = 'Ошибка изменения данных лабораторной работы';
            return $resData;
        }
        
        //Легче перезагрузить все курсы(в дальнейшем проверить на утечки)
        $this->courses = $this->ClassFactory->GetObjects("Course");
        $resData['success'] = 1;
        $resData['message'] = "Данные лабораторной работы обновлены";
        return $resData;   
    }
    public function DeleteLab($id){
        // Создаем список для удаления
        // Первый параметр - from
        // второй параметр - where
        
        $labInfo = array();
        $labInfo["id"] = $id;
        $updatedLabList = $this->ClassFactory->DeleteObject('Lab', $labInfo);
        if (!$updatedLabList) {
            $resData['success'] = 0;
            $resData['message'] = 'Ошибка удаления лабораторной работы';
            return $resData;
        }
        
        //Как и раньше, легче просто перезагрузить курсы
        $this->courses = $this->ClassFactory->GetObjects("Course");
        $resData['success'] = 1;
        $resData['message'] = 'Лабораторная работа удалена';
        return $resData;
    }
    public function ShowLab($id=''){
        if (!$id){
            $resultLabInfo = array();
            foreach ($this->courses as $course){
                $labArray = $course->GetLab();
                foreach ($labArray as $lab){
                    array_push($resultLabInfo, $lab->GetInfo());
                }
            }
        }
        return $resultLabInfo;
    }
    
    
    public function AddCourseToTeacher(){}
    public function RemoveCourseFromTeacher(){}
    
    //
    // Возвращает true, если все хорошо
    // Возвращает false, если есть пустые параметры
    //
    private function CheckEmptyParams($arrayParams){
        foreach ($arrayParams as $param){
            if (!$param){
                return FALSE;
            }
        }
        return TRUE;
    }
    
    //TODO: Нужно проверять по нескольким параметрам
    private function CheckDuplicate($member, $field, $value){
        foreach ($member as $currentMember){
            $info = $currentMember->GetInfo();
            if ($info[$field] === $value){
                return FALSE;
            }
        }
        return TRUE;
    }
    
    private function CheckCondition (&$checkArray, $key, $value){
        for ($i = count($checkArray) - 1; $i >= 0; $i--){
            $info = $checkArray[$i]->GetInfo();
            if ($info[$key] !== $value){
                unset($checkArray[$i]);
            }       
        }
    }
}



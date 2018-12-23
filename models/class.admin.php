<?php

//
require_once 'class.factory.php';

class Admin{
    private $ClassFactory;
    
    /**
     * Конструктор. Заполняет поля класса объектами
     */
    function __construct(){
        $this->ClassFactory = new Factory();
    }
    
    
    /**
     * Создание преподавателя
     * @param string $name - имя преподавателя
     * @param string $email - электронная почта преподавателя
     * @param string $login - логин преподавателя
     * @param string $password - пароль преподавателя
     * @return array[boolean,string] - результат выполнения операции и комментарий
     */
    public function CreateTeacher($name, $email, $login, $password){
        if (!$this->CheckEmptyParams(array($name, $login, $password))){
            $res['success'] = FALSE;
            $res['message'] = "Обязательные поля не заполнены";
            return $res;
        }
       
        $passwordMD5 = md5(trim($password));
        
        $teacherInfo = array();
        $teacherInfo["name"] = $name;
        $teacherInfo["email"] = $email;
        $teacherInfo["login"] = $login;
        $teacherInfo["password"] = $passwordMD5;

        $newTeacher = $this->ClassFactory->GetBlankObject('teacher');
        
        $rs = $newTeacher->SelfCreate($teacherInfo);
        
        if (!$rs){
            $resData['success'] = 0;
            $resData['message'] = 'Ошибка добавления преподавателя';
            return $resData;
        }
        $resData['message'] = 'Преподаватель добавлен';
        $resData['success'] = 1;
        return $resData;
    }
    
    /**
     * Изменение данных преподавателя
     * @param int $id - id преподавателя
     * @param string $newName - новое имя преподавателя
     * @param string $newEmail - новая электронная почта преподавателя
     * @param string $newLogin - новый логин преподавателя
     * @param string $newPassword - новый пароль преподавателя
     * @return array[boolean,string] - результат выполнения операции и комментарий
     */
    public function EditTeacher($id, $newName, $newEmail, $newLogin, $newPassword){
        if (!$this->CheckEmptyParams(array($newName, $newLogin, $newPassword))){
            $res['success'] = FALSE;
            $res['message'] = "Обязательные поля не заполнены";
            return $res;
        }
        
        $teacherCurrentInfo = array('id' => $id);
        $teacherForEdit = $this->ClassFactory->GetObjects('teacher', $teacherCurrentInfo);
        
        $teacherNewInfo = array();
        $teacherNewInfo["name"] = $newName;
        $teacherNewInfo["email"] = $newEmail;
        $teacherNewInfo["login"] = $newLogin;
        $teacherNewInfo["password"] = $newPassword;
        
        $rs = $teacherForEdit[0]->SelfUpdate($teacherNewInfo);
        if(!$rs) {
            $resData['success'] = 0;
            $resData['message'] = 'Ошибка изменения данных преподавателя';
            return $resData;
        }
        $resData['success'] = 1;
        $resData['message'] = "Данные преподавателя '{$newName}' обновлены";
        return $resData;
    }
    
    /**
     * Удаление преподавателя
     * @param int $id - id преподавателя
     * @return array[boolean,string] - результат выполнения операции и комментарий
     */
    public function DeleteTeacher($id){
        // Создаем массив для удаления
        // Ключ - from
        // Значение - where
        $teacherInfo = array("id" => $id);
        $teacher = $this->ClassFactory->GetObjects('teacher', $teacherInfo)[0];
        $rs = $teacher->SelfDelete();
        if (!$rs) {
            $resData['success'] = 0;
            $resData['message'] = 'Ошибка удаления преподавателя';
            return $resData;
        }
        $resData['success'] = 1;
        $resData['message'] = 'Преподаватель удален';
        return $resData;
    }
    
    /**
     * Преобразование массива объектов преподавателей в массив строк
     * @return array - двумерный массив строк с информацией о всех преподавателях
     */
    public function ShowTeacher(){
        $resultTeachersInfo = array(); 
        $resultTeachers = $this->ClassFactory->GetObjects('teacher');

        foreach ($resultTeachers as $teacher){
            array_push($resultTeachersInfo, $teacher->GetInfo());
        }
        return $resultTeachersInfo;
    }
    
    /**
     * Создание студента
     * @param string $name - имя студента
     * @param string $group - номер группы
     * @return array[boolean,string] - результат выполнения операции и комментарий
     */
    public function CreateStudent($name, $group){
        if (!$this->CheckEmptyParams(array($name, $group))){
            $res['success'] = FALSE;
            $res['message'] = "Обязательные поля не заполнены";
            return $res;
        }
        
        $studentInfo = array();
        $studentInfo["name"] = $name;
        $studentInfo["learn_group"] = $group;
        
        $newStudent = $this->ClassFactory->GetBlankObject('student');
        $rs = $newStudent->SelfCreate($studentInfo);
        
        if (!$rs){
            $resData['success'] = 0;
            $resData['message'] = 'Ошибка добавления студента';
            return $resData;
        }
        $resData['message'] = 'Студент добавлен';
        $resData['success'] = 1;
        return $resData;
    }
    
    /**
     * Редактирование информации студента
     * @param int $id - id студента
     * @param string $newName - новое имя студента
     * @param string $newGroup - новая группа студента
     * @return array[boolean,string] - результат выполнения операции и комментарий
     */
    public function EditStudent($id, $newName, $newGroup){
        if (!$this->CheckEmptyParams(array($newName, $newGroup))){
            $res['success'] = FALSE;
            $res['message'] = "Обязательные поля не заполнены";
            return $res;
        }
        
        $studentCurrentInfo = array();
        $studentCurrentInfo["id"] = $id;
        $studentForEdit = $this->ClassFactory->GetObjects('student', $studentCurrentInfo);
        
        //Проверки на дубликаты нет
        $studentNewInfo = array();
        $studentNewInfo["name"] = $newName;
        $studentNewInfo["learn_group"] = $newGroup;
        
        $rs = $studentForEdit[0]->SelfUpdate($studentNewInfo);
        if(!$rs) {
            $resData['success'] = 0;
            $resData['message'] = 'Ошибка изменения данных студента';
            return $resData;
        }
        $resData['success'] = 1;
        $resData['message'] = "Данные студента '$newName' обновлены";
        return $resData;   
    }
    
    /**
     * Удаление студента
     * @param int $id - id студента
     * @return array[boolean,string] - результат выполнения операции и комментарий
     */
    public function DeleteStudent($id){
         // Создаем массив для удаления
        // Ключ - from
        // Значение - where
        
        $studentInfo = array();
        $studentInfo["id"] = $id;
        $studentForDelete = $this->ClassFactory->GetObjects('student', $studentInfo);
        $rs = $studentForDelete[0]->SelfDelete();
        if (!$rs) {
            $resData['success'] = 0;
            $resData['message'] = 'Ошибка удаления студента';
            return $resData;
        }
        $resData['success'] = 1;
        $resData['message'] = 'Студент удален';
        return $resData;
    }
    
    /**
     * Преобразование массива объектов студентов в массив строк
     * @return array - двумерный массив строк с информацией о всех студентах
     */
    public function ShowStudent(){ 
        $resultStudentsInfo = array(); 
        $resultStudents = $this->ClassFactory->GetObjects('student');
        foreach ($resultStudents as $student){
            array_push($resultStudentsInfo, $student->GetInfo());
        }
        return $resultStudentsInfo;
    }
    
    /**
     * Создание курса
     * @param string $title - название курса
     * @param string $description - описание курса
     * @param string $login - логин курса
     * @param string $password - пароль курса
     * @return array[boolean,string] - результат выполнения операции и комментарий
     */
    public function CreateCourse($title, $description, $login, $password){
        
        if (!$this->CheckEmptyParams(array($title, $login, $password))){
            $res['success'] = FALSE;
            $res['message'] = "Обязательные поля не заполнены";
            return $res;
        }
       
        $passwordMD5 = md5(trim($password));
        
        $courseInfo = array();
        $courseInfo["title"] = $title;
        $courseInfo["description"] = $description;
        $courseInfo["login"] = $login;
        $courseInfo["password"] = $passwordMD5;

        $newCourse = $this->ClassFactory->GetBlankObject('course');
        $rs = $newCourse->SelfCreate($courseInfo);
        
        if (!$rs){
            $resData['success'] = 0;
            $resData['message'] = 'Ошибка добавления курса';
            return $resData;
        }
        $resData['message'] = 'Курс добавлен';
        $resData['success'] = 1;
        return $resData;
    }
    
    /**
     * Изменение данных курса
     * @param int $id - id курса
     * @param string $newTitle - новое название курса
     * @param string $newDescription - новое описание курса
     * @param string $newLogin - новый логин курса
     * @param string $newPassword - новый пароль курса
     * @return array[boolean,string] - результат выполнения операции и комментарий
     */
    public function EditCourse($id, $newTitle, $newDescription, $newLogin, $newPassword){
        if (!$this->CheckEmptyParams(array($newTitle, $newLogin, $newPassword))){
            $res['success'] = FALSE;
            $res['message'] = "Обязательные поля не заполнены";
            return $res;
        }
        
        $newCourseInfo = array();
        $newCourseInfo["title"] = $newTitle;
        $newCourseInfo["description"] = $newDescription;
        $newCourseInfo["login"] = $newLogin;
        $newCourseInfo["password"] = $newPassword;
        
        $currentCourseInfo = array();
        $currentCourseInfo["id"] = $id;
        
        $currentCourse = $this->ClassFactory->GetObjects('course', $currentCourseInfo);
        
        $rs = $currentCourse[0]->SelfUpdate($newCourseInfo);
        if(!$rs) {
            $resData['success'] = 0;
            $resData['message'] = 'Ошибка изменения данных курса';
            return $resData;
        }
        
        $resData['success'] = 1;
        $resData['message'] = "Данные курса '{$newTitle}' обновлены";
        return $resData;   
    }
    
    /**
     * Удаление курса
     * @param int $id - id курса
     * @return array[boolean,string] - результат выполнения операции и комментарий
     */
    public function DeleteCourse($id){
        // Создаем массив для удаления
        
        $courseInfo = array();
        $courseInfo["id"] = $id;
        $courseForDelete = $this->ClassFactory->GetObjects('course', $courseInfo)[0];
        $rs = $courseForDelete->SelfDelete();
        if (!$rs) {
            $resData['success'] = 0;
            $resData['message'] = 'Ошибка удаления курса';
            return $resData;
        }
        
        $resData['success'] = 1;
        $resData['message'] = 'Курс удален';
        return $resData;
    }
    
    /**
     * Преобразование массива объектов курсов в массив строк
     * @param string $condition - получить конкретные курсы
     * @param string $additional - добавление дополнительной информации
     * @return array - двумерный массив строк с информацией о всех курсах
     */
    public function ShowCourse($condition=null, $additional = null){
        $resultCoursesInfo = array();
        $chekedCourses = $this->ClassFactory->GetObjects('course');
        // Все курсы
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
        if ($additional){ // Получение дополнительной информации
            for ($i = 0; $i < count($chekedCourses); $i++){
                $functionStr = "Get" . $additional; // Сейчас импользуется $additional = 'lab'
                $additionalObject = $chekedCourses[$i]->$functionStr(); //GetLab()
                $resultCoursesInfo[$i]['$additional'] = array();
                //foreach ($additionalObject as $object){ // Взяли из каждого объекта информацию
                    //$object->GetInfo();
                //}
                
            }
        }
        
        return $resultCoursesInfo;
    }
    
    /**
     * Создание сабораторной работы
     * @param string $title - название лабораторной
     * @param string $task - задание лабораторной
     * @param int $courseId - курс, которому пренадлежит лабораторная работа
     * @return array[boolean,string] - результат выполнения операции и комментарий
     */
    public function CreateLab($title, $task, $courseId){
        if (!$this->CheckEmptyParams(array($title, $courseId))){
            $res['success'] = FALSE;
            $res['message'] = "Обязательные поля не заполнены";
            return $res;
        }
        
        $labCourseInfo = array('course_id' => $courseId);
        $labCourse = $this->ClassFactory->GetObjects('lab', $labCourseInfo);
        $labNumber = -1;
        foreach ($labCourse as $lab){
            $info = $lab->GetInfo();
            if ($info['number'] > $labNumber){
                $labNumber = $info['number'];
            }
        }
        $labNumber += 1;
        
        $newLab = $this->ClassFactory->GetBlankObject('lab');
        
        $labInfo = array();
        $labInfo['number'] = $labNumber;
        $labInfo["title"] = $title;
        $labInfo["task"] = $task;
        $labInfo['attachment'] = '';
        $labInfo['access'] = 0;
        $labInfo["course_id"] = $courseId;

        $rs = $newLab->SelfCreate($labInfo);
        
        if (!$rs){
            $resData['success'] = 0;
            $resData['message'] = 'Ошибка добавления лабораторной работы';
            return $resData;
        }
        
        $resData['message'] = 'Лабораторная работа добавлена';
        $resData['success'] = 1;
        return $resData;
    }
    
    /**
     * Изменение лабораторной работы
     * @param int $labId - id лабораторной
     * @param int $number - новый номер лабораторной работы
     * @param string $title - новое название лабораторной работы
     * @param string $task - новое задание лабораторной работы
     * @param boll $access - доступ к лабораторной работе
     * @param int $courseId - id нового курса
     * @return array[boolean,string] - результат выполнения операции и комментарий
     */
    public function EditLab($labId, $number=-1, $title='', $task='', $access=-1, $courseId=-1){
        if (!$this->CheckEmptyParams(array($labId, $number, $title, $courseId))){
            $res['success'] = FALSE;
            $res['message'] = "Обязательные поля не заполнены";
            return $res;
        }
        
        $currentLabInfo = array("id" => $labId);
        $labForEdit = $this->ClassFactory->GetObjects('lab', $currentLabInfo);
        
        //Есть специализированные проверки для лабораторных работ!
        $newLabInfo = array();
        if ($number >= 0) $newLabInfo['number'] = $number;
        if ($title) $newLabInfo["title"] = $title;
        if ($task) $newLabInfo["task"] = $task;
        if ($task) $newLabInfo["attachment"] = '';
        if ($access >= 0) $newLabInfo['access'] = $access;
        if ($courseId >= 0) $newLabInfo["course_id"] = $courseId;
        
        $rs = $labForEdit[0]->SelfUpdate($newLabInfo);
        
        if(!$rs) {
            $resData['success'] = 0;
            $resData['message'] = 'Ошибка изменения данных лабораторной работы';
            return $resData;
        }
        $resData['success'] = 1;
        $resData['message'] = "Данные лабораторной работы обновлены";
        return $resData;   
    }
    
    /**
     * Удаление лабораторной работы
     * @param int $id - id лабораторной
     * @return array[boolean,string] - результат выполнения операции и комментарий
     */
    public function DeleteLab($id){
        
        $labInfo = array();
        $labInfo["id"] = $id;
        $labForDelete = $this->ClassFactory->GetObjects('lab', $labInfo);
        $rs = $labForDelete[0]->SelfDelete();
        if (!$rs) {
            $resData['success'] = 0;
            $resData['message'] = 'Ошибка удаления лабораторной работы';
            return $resData;
        }
        
        $resData['success'] = 1;
        $resData['message'] = 'Лабораторная работа удалена';
        return $resData;
    }
    
    /**
     * Преобразование массива объектов лабораторных (извлекаем из курсов) в массив строк
     * @return array - двумерный массив строк с информацией о всех курсах
     */
    public function ShowLab(){
        $resultLabInfo = array(); 
        $resultLab = $this->ClassFactory->GetObjects('lab');
        foreach ($resultLab as $lab){
            array_push($resultLabInfo, $lab->GetInfo());
        }
        return $resultLabInfo;
    }
    
    
    //public function AddCourseToTeacher(){}
    //public function RemoveCourseFromTeacher(){}
    
    
    /**
     * Проверка на наличие пустых параметров
     * @param array $arrayParams - массив проверяемых параметров
     * @return boolean - true, если нет пустых параметров
     */
    private function CheckEmptyParams($arrayParams){
        foreach ($arrayParams as $param){
            if (!$param){
                return FALSE;
            }
        }
        return TRUE;
    }
}


